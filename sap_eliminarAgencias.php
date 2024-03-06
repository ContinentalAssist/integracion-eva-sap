<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/sap_eliminarAgencias', function (Request $request, Response $response) 
{
    $db         = getDB();
    $data       = json_decode($request->getBody());

    $idpaises = array(5,283,11);

    $contador5      = 0;
    $contador11     = 0;
    $contador283    = 0;

    $agencias_con_error = array();

    foreach($idpaises as $idpais)
    {
        $condicion_pais = ($idpais == 5 || $idpais == 11) ? ' AND agencias.idpais = '.$idpais : ' AND agencias.idpais NOT IN (5,11)';

        $SessionId = sap_login($db, $idpais);

        if($SessionId)
        {
            $agencias       = ejecuta_select($db,"SELECT 
                                                    agencias.idagenciasap
                                            FROM agencias
                                            LEFT JOIN paises ON agencias.idpais = paises.idpais
                                            WHERE agencias.idstatus = 1
                                            AND agencias.idagenciasap IS NOT NULL
                                            AND agencias.identificadortributaria != ''
                                            $condicion_pais
                                            LIMIT 1
                                            ");

            foreach($agencias['resultado'] as $agencia)
            {
                $idagenciasap   = $agencia['idagenciasap'];
                $url            = "BusinessPartners('".$idagenciasap."')";

                $agencias_sap = sap_servicio($db, $url , $SessionId, 'DELETE', $data, $idpais);
                $agencias_sap = json_decode($agencias_sap);

                if(!isset($agencias_sap->error))
                {
                    ejecuta_update($db, "UPDATE agencias SET idagenciasap = NULL WHERE idagencia = $idagencia");
                
                    switch($idpais)
                    {
                        case 5:
                            $contador5++;
                            break;
                        case 11:
                            $contador11++;
                            break;
                        case 283:
                            $contador283++;
                            break;
                    }
                }
                else
                {
                    // echo 'Error'; 
                    // print_r(json_encode($data)); exit;
                    // print_r($agencias_sap); exit;
                    array_push($agencias_con_error, $idagencia);
                }
            }

            sap_logout($db, $SessionId, $idpais);
        }
        else
        {

            $noData["resultado"]  = array("mexico" => $contador11, "colombia" => $contador5, "estadosunidos" => $contador283);
            $noData["cantidad"] = 0;
            $noData["error"] = true;
            $noData["mensaje"] = 'Error de Conexión a SAP con el pais:'.$idpais;

            $resultado = json_encode($noData);
            $response->getBody()->write($resultado);
            return $response;
        }   
    }

    $respuesta["resultado"]     = array("mexico" => $contador11, "colombia" => $contador5, "estadosunidos" => $contador283);
    $respuesta["error"]         = false;
    $respuesta["mensaje"]       = '';
    $respuesta["con_error"]     = $agencias_con_error;

    $resultado = json_encode($respuesta);
    $response->getBody()->write($resultado);
    return $response;
});
