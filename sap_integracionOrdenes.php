<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/sap_integracionOrdenes', function (Request $request, Response $response) 
{
    $db         = getDB();
    $data       = json_decode($request->getBody());
    $fechadesde      = $data->fechadesde;
    $fechahasta      = $data->fechahasta;
    // 5 Colombia
    // 11 Mexico
    // 99 Estados Unidos

    $idpaises = array(11);

    $array_ordenes_insertadas = array();
    $array_ordenes_no_insertadas = array();

    foreach($idpaises as $idpais)
    {
        $SessionId = sap_login($db, $idpais);
     
        ejecuta_select($db, "REFRESH MATERIALIZED view vwm_reporteglobal_2024");

        $condicion_pais = ($idpais == 5 || $idpais == 11) ? " AND vwm_reporteglobal_2024.idpais = $idpais " : " AND vwm_reporteglobal_2024.idpais NOT IN (5,11) ";

        $select = "SELECT 
                    idorden,
                    codigo_voucher,
                    idpais,
                    identificadortributaria,
                    idagenciasap,
                    fecha_creacion,
                    fecha_desde,
                    fecha_hasta,
                    idmoneda,
                    tasa_cambio,
                    moneda,
                    idplan,
                    precio_final_usd_sin_iva,
                    idagencia,
                    dimension1,
                    dimension2,
                    dimension3,
                    dimension4,
                    dimension5,
                    codigofamiliaplansap
                FROM vwm_reporteglobal_2024 
                WHERE vwm_reporteglobal_2024.fecha_creacion BETWEEN '$fechadesde' AND '$fechahasta' 
                AND vwm_reporteglobal_2024.idstatus = 1 
                AND vwm_reporteglobal_2024.idordensap IS NULL
                AND identificadortributaria  != '' AND identificadortributaria  != 'NA'
                $condicion_pais
                ORDER BY fecha_creacion ASC
                LIMIT 10
                ";
          //AND identificadortributaria  != '' AND identificadortributaria  != 'NA' //RGUZMAN        

//LIMIT 100
        $ordenes = ejecuta_select($db, $select);

        foreach($ordenes['resultado'] as $orden)
        {
            // FECHA DE CREACION
            $DocDate        = sap_formato_fecha($orden['fecha_creacion']);
            // FECHA DE CREACION
            $DocDueDate     = sap_formato_fecha($orden['fecha_creacion']);
            // AGENCIA
            $CardCode       = $orden['idagenciasap'];//$orden['identificadortributaria'];
            // CODIGO VOUCHER
            $NumAtCard      = $orden['codigo_voucher'];
            // FECHA TASA CAMBIO
            $TaxDate        = sap_formato_fecha($orden['fecha_creacion']);

            // if($idpais != 5 && $idpais != 11)
            // {
            //     $Price = $orden['precio_final_usd_sin_iva'];
            // }
            // else
            // {
            //     if($orden['idmoneda'] != 1)
            //     {
            //         $Price = $orden['precio_final_usd_sin_iva'];
            //     }
            //     else
            //     {
            //         $Price = formato_monto($orden['precio_final_usd_sin_iva']) * formato_monto($orden['tasa_cambio']);
            //     }
            // }

            $Price = $orden['precio_final_usd_sin_iva'];

            // CUPON
            if(array_key_exists('cupon_porcentaje', $orden) && $orden['cupon_porcentaje'] > 0)
            {
                $porcentaje_cupon   = $orden['cupon_porcentaje'];
                $DocTotal           = $Price + (($Price * $porcentaje_cupon) / 100);
                $DiscPrcnt          = $porcentaje_cupon;
            }
            else
            {
                $DocTotal           = $Price;
                $DiscPrcnt          = 0;
            }

            $DocumentLines  = array();

           // $idusuariosap = sap_consulta_ejecutivo_responsable_orden($db,$idorden);

            // $articulo = array(
            //     "ItemCode" => "CONT",
            //     "Quantity" => 1,
            //     "ShipDate" => $DocDate,
            //     "Price" => formato_monto($Price),
            //     "CostingCode" => $orden['dimension1'],
            //     "CostingCode2" => $orden['dimension2'],
            //     "CostingCode3" => $orden['dimension3'],
            //     "CostingCode4" => $orden['dimension4'],
            //     "CostingCode5" => $orden['dimension5'],
            //     "DiscPrcnt" => $DiscPrcnt
            // );

            $articulo = array(
                "ItemCode" => 'XPTOT60',//$orden['codigofamiliaplansap'],
                "Quantity" => 1,
                "ShipDate" => $DocDate,
                "Price" => formato_monto($Price),
                "CostingCode" => 'D9000000',//'MX05NH3', // $orden['dimension1'],
                "CostingCode2" => 'D9000001',//'I1A05BY1',//$orden['dimension2'],
                "CostingCode3" => 'D9000002',//'35490000',//$orden['dimension3'],
                "CostingCode4" => 'D9000003',//'60540000',//$orden['dimension4'],
                "CostingCode5" => 'D9000004',//'010632',//,$orden['dimension5'],
                "DiscPrcnt" => $DiscPrcnt
            );


/*             Dimension 1	D9000000
Dimension 2	D9000001
Dimension 3	D9000002
Dimension 4	D9000003
Dimension 5	D9000004 */

            $data_orden = array(
                "DocDate" => $DocDate,
                "DocDueDate" => $DocDueDate,
                "CardCode" => $CardCode,
                "NumAtCard" => $NumAtCard,
                "TaxDate" => $TaxDate,
                "DocTotal" => formato_monto($DocTotal),
                "DocumentLines" => array($articulo)
            );


            $ordenes_sap = json_decode(sap_servicio($db, "Orders", $SessionId, 'POST', $data_orden, $idpais));

            if(!$ordenes_sap->error)
            {
                $idorden    = $orden['idorden'];
                $idordensap = $ordenes_sap->DocEntry;
                ejecuta_update($db, "UPDATE ordenes SET idordensap = $idordensap WHERE idorden = $idorden");
                array_push($array_ordenes_insertadas, $idorden);
            }
            else
            {
                if($ordenes_sap->error->code == -10)
                {
                    $tasa = array(
                        "RateDate" => $DocDate,
                        "Currency" => "USD",
                        "Rate" => formato_monto($orden['tasa_cambio'])
                    );

                    $actualiza_tasa = json_decode(sap_servicio($db, "SBOBobService_SetCurrencyRate", $SessionId, 'POST', $tasa, $idpais));

                    if(!$actualiza_tasa->error)
                    {
                        $ordenes_sap = json_decode(sap_servicio($db, "Orders", $SessionId, 'POST', $data_orden, $idpais));

                        if(!$ordenes_sap->error)
                        {
                            $idorden    = $orden['idorden'];
                            $idordensap = $ordenes_sap->DocEntry;
                            ejecuta_update($db, "UPDATE ordenes SET idordensap = $idordensap WHERE idorden = $idorden");
                            array_push($array_ordenes_insertadas, $idorden);
                        }
                        else
                        {
                            print_r($ordenes_sap); 
                            print_r($array_ordenes_insertadas); exit;
                        }
                    }
                    else
                    {
                        print_r($actualiza_tasa); 
                        print_r($array_ordenes_insertadas); exit;
                    }
                }
                else
                {
                    array_push($array_ordenes_no_insertadas, $ordenes_sap );
                }
            }
        }

        sap_logout($db, $SessionId, $idpais);

        echo '
        Ordenes Insertadas:';
        print_r($array_ordenes_insertadas);

        echo '
        Ordenes NO Insertadas:';
        print_r($array_ordenes_no_insertadas); exit;
    }
});
