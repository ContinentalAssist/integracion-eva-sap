<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/sap_consultaOrdenesFacturas', function (Request $request, Response $response) 
{
    $db         = getDB();
    $data       = json_decode($request->getBody());

    $fechadesde     = $data->fechadesde;
    $fechahasta     = $data->fechahasta;
    $idpais         = $data->idpais;

    $SessionId = sap_login($db, $idpais);

    $ruta = "Orders?"."$"."select=DocEntry,DocNum,Cancelled,CancelDate,DocDate,CardCode,CardName,VatSum,DocTotal,NumAtCard,DocumentLines";
    // ReceiptNumber
    // $ruta = "Orders?"."$"."select=DocEntry,DocNum,Cancelled,CancelDate,DocDate,CardCode,CardName,VatSum,DocTotal,ReceiptNumber,NumAtCard,DocumentLines";
    // $ruta = "Orders";

    $ordenes_sap = json_decode(sap_servicio($db, $ruta , $SessionId, 'GET', $data_orden, $idpais));

    sap_logout($db, $SessionId, $idpais);

    print_r($ordenes_sap); exit;
    print_r($ordenes_sap->value); exit;



        // $ordenes = ejecuta_select($db, $select);

        // foreach($ordenes['resultado'] as $orden)
        // {
        //     $DocDate        = sap_formato_fecha($orden['fechacreacion']);
        //     $DocDueDate     = sap_formato_fecha($orden['fechacreacion']);
        //     $idagencia      = $orden['idagencia'];
        //     $CardCode       = ejecuta_select($db, "SELECT idagenciasap FROM agencias WHERE idagencia    = $idagencia", "idagenciasap");
        //     $NumAtCard      = $orden['codigovoucher'];
        //     $TaxDate        = sap_formato_fecha($orden['fechacreacion']);

        //     if($idpais != 5 && $idpais != 11)
        //     {
        //         $Price = $orden['total'];
        //     }
        //     else
        //     {
        //         if($orden['idmoneda'] != 1)
        //         {
        //             $Price = $orden['total'];
        //         }
        //         else
        //         {
        //             $Price = formato_monto($orden['total']) * formato_monto($orden['tasacambio']);
        //         }
        //     }

        //     // CUPON
        //     if($orden['idcupon'] > 0)
        //     {
        //         $idcupon            = $orden['idcupon'];
        //         $porcentaje_cupon   = ejecuta_select($db, "SELECT porcentaje FROM cupones WHERE idcupon = $idcupon", "porcentaje");
        //         $DocTotal           = $Price + (($Price * $porcentaje_cupon) / 100);
        //         $DiscPrcnt          = $porcentaje_cupon;
        //     }
        //     else
        //     {
        //         $DocTotal           = $Price;
        //         $DiscPrcnt          = 0;
        //     }

        //     $DocumentLines  = array();

        //     $idusuariosap = sap_consulta_ejecutivo_responsable_orden($idorden);

        //     $articulo = array(
        //         "ItemCode" => "ACNG",
        //         "Quantity" => 1,
        //         "ShipDate" => $DocDate,
        //         "Price" => formato_monto($Price),
        //         "CostingCode" => $orden['idpaissap'],
        //         "CostingCode2" => $idusuariosap,
        //         "CostingCode3" => "DRAV0001",
        //         "CostingCode4" => "B2C0001",
        //         "CostingCode5" => $orden['idplansap'],
        //         "DiscPrcnt" => $DiscPrcnt
        //     );

        //     $data_orden = array(
        //         "DocDate" => $DocDate,
        //         "DocDueDate" => $DocDueDate,
        //         "CardCode" => $CardCode,
        //         "NumAtCard" => $NumAtCard,
        //         "TaxDate" => $TaxDate,
        //         "DocTotal" => formato_monto($DocTotal),
        //         "DocumentLines" => array($articulo)
        //     );

        //     print_r($data_orden); exit;

        //     $ordenes_sap = json_decode(sap_servicio($db, "Orders", $SessionId, 'POST', $data_orden, $idpais));

        //     if(!$ordenes_sap->error)
        //     {
        //         $idorden    = $orden['idorden'];
        //         $idordensap = $ordenes_sap->DocEntry;
        //         ejecuta_update($db, "UPDATE ordenes SET idordensap = $idordensap WHERE idorden = $idorden");
        //         array_push($array_ordenes_insertadas, $idorden);
        //     }
        //     else
        //     {
        //         if($ordenes_sap->error->code == -10)
        //         {
        //             $tasa = array(
        //                 "RateDate" => $DocDate,
        //                 "Currency" => "USD",
        //                 "Rate" => formato_monto($orden['tasacambio'])
        //             );

        //             $actualiza_tasa = json_decode(sap_servicio($db, "SBOBobService_SetCurrencyRate", $SessionId, 'POST', $tasa, $idpais));

        //             if(!$actualiza_tasa->error)
        //             {
        //                 $ordenes_sap = json_decode(sap_servicio($db, "Orders", $SessionId, 'POST', $data_orden, $idpais));

        //                 if(!$ordenes_sap->error)
        //                 {
        //                     $idorden    = $orden['idorden'];
        //                     $idordensap = $ordenes_sap->DocEntry;
        //                     ejecuta_update($db, "UPDATE ordenes SET idordensap = $idordensap WHERE idorden = $idorden");
        //                     array_push($array_ordenes_insertadas, $idorden);
        //                 }
        //                 else
        //                 {
        //                     print_r($ordenes_sap); 
        //                     print_r($array_ordenes_insertadas); exit;
        //                 }
        //             }
        //             else
        //             {
        //                 print_r($actualiza_tasa); 
        //                 print_r($array_ordenes_insertadas); exit;
        //             }
        //         }
        //         else
        //         {
        //             print_r($ordenes_sap);
        //             print_r($array_ordenes_insertadas); exit;
        //         }
        //     }
        // }

        // sap_logout($db, $SessionId, $idpais);

        // print_r($array_ordenes_insertadas); exit;
    
});
