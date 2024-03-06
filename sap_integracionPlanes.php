<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/sap_integracionPlanes', function (Request $request, Response $response) 
{
    $db         = getDB();
    $data       = json_decode($request->getBody());

    $borrar = false;
    $migrar = true;

    $idpaises = array(11);

    $array_planes_a_migrar  = array();
    $array_planes_migrados  = array();
    $array_planes_borrados  = array();
    $errores                = array();
    $response               = array();

    if($borrar)
    {
        foreach($idpaises as $idpais)
        {
            $SessionId = sap_login($db, $idpais);
        
            $planes_a_borrar = ejecuta_select($db, "SELECT 
                                                        idplansap 
                                                    FROM planes 
                                                    WHERE idplansap IS NOT NULL 
                                                    GROUP BY idplansap");

            foreach($planes_a_borrar['resultado'] as $plan_a_borrar)
            {
                $idplansap  = $plan_a_borrar['idplansap'];
                $ruta       = "Items('".$idplansap."')"; 
                $respuesta  = json_decode(sap_servicio($db, $ruta, $SessionId, 'DELETE', $data, $idpais));

                if(!$respuesta->error)
                {
                    array_push($array_planes_borrados, $idplansap);

                }
                else
                {
                    array_push($errores, $respuesta->error->message->value);
                }
            }
        }

        sap_logout($db, $SessionId, $idpais);
    }

    if($migrar)
    {
        foreach($idpaises as $idpais)
        {
            $SessionId = sap_login($db, $idpais);
        
            switch($idpais)
            {
                case 5:
                    $campo = "idcategoriasapcol";
                    $condicion_pais = " AND planespaises.idpais = $idpais ";
                    break;
                case 11:
                    $campo = "idcategoriasapmex";
                    $condicion_pais = " AND planespaises.idpais = $idpais ";
                    break;
                default:
                    $campo = "idcategoriasapusa";
                    $condicion_pais = " AND planespaises.idpais NOT IN (5,11) ";
                    break;
            }
    
            $query = "SELECT 
                            planes.idplansap
                        FROM planes 
                        LEFT JOIN planespaises ON planes.idplan = planespaises.idplan
                        WHERE planes.idstatus = 1 
                        $condicion_pais
                        AND planes.idplansap IS NOT NULL
                        GROUP BY idplansap
                        ";
            $planes = ejecuta_select($db, $query);

            foreach($planes['resultado'] as $plan)
            {
                $idplan = sap_extraer_idplan($plan['idplansap']);
                array_push($array_planes_a_migrar, $idplan);
            }

            $planes_a_migrar = implode(",", $array_planes_a_migrar);

            $query = "SELECT 
                            planes.idplan,
                            planes.idcategoria,
                            planes.nombreplan,
                            categorias.$campo as idcategoriasap
                        FROM planes 
                        LEFT JOIN planespaises ON planes.idplan = planespaises.idplan
                        LEFT JOIN categorias ON planes.idcategoria = categorias.idcategoria
                        WHERE planes.idstatus = 1 
                        AND planes.idplan IN ($planes_a_migrar)
                        GROUP BY planes.idplan, idcategoriasap
                        ";

            $planes = ejecuta_select($db, $query);
    
            foreach($planes['resultado'] as $plan)
            {
                $idplan         = $plan['idplan'];
                $nombreplan     = $plan['nombreplan'];
                $idcategoria    = $plan['idcategoria'];
                $idcategoriasap = $plan['idcategoriasap'];
    
                $ItemCode = sap_acronimo_plan($idplan, $idcategoria);
    
                $data = array(
                    "ItemCode" => $ItemCode,
                    "ItemName" => $nombreplan,
                    "ForeignName" => $nombreplan,
                    "ItemsGroupCode" => $idcategoriasap,
                    "Valid" => "tYES"
                );
    
                $respuesta = json_decode(sap_servicio($db, "Items", $SessionId, 'POST', $data, $idpais));
    
                if(!$respuesta->error)
                {
                    $idplansap = $respuesta->ItemCode;
                    ejecuta_update($db, "UPDATE planes SET idplansap = '$idplansap' WHERE idplan = $idplan");
                    $plan_migrado = array("idpais" => $idpais, "idplan" => $idplan, "idplansap" => $idplansap);
                    array_push($array_planes_migrados, $plan_migrado);
                }
                else
                {
                    array_push($errores, $respuesta->error->message->value);
                }
            }
        }

        sap_logout($db, $SessionId, $idpais);
    }

    $response['borrados'] = $array_planes_borrados;
    $response['migrados'] = $array_planes_migrados;
    $response['errores'] = $errores;

    print_r(json_encode($response));

    exit;
});
