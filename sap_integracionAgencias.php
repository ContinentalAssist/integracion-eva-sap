<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/sap_integracionAgencias', function (Request $request, Response $response) 
{
    $db         = getDB();
    $data       = json_decode($request->getBody());


    // $idpaises = array(5,283,11);
    // $idpaises = array(5);
    $idpaises = array(11);

    $contador5      = 0;
    $contador11     = 0;
    $contador99    = 0;

    $agencias_con_error = array();

    foreach($idpaises as $idpais)
    {
        $condicion_pais = ($idpais == 5 || $idpais == 11) ? ' AND agencias.idpais = '.$idpais : ' AND agencias.idpais NOT IN (5,11)';

        $SessionId = sap_login($db, $idpais);
        //substring(REPLACE(REPLACE(agencias.identificadortributaria,'NIT ',''),' ',''),0,12) as identificadortributaria,

        if($SessionId)
        {
            $agencias       = ejecuta_select($db,"SELECT 
                                                    agencias.idagencia,
                                                    agencias.nombreagencia as nombreagencia,
                                                    agencias.identificadortributaria,
                                                    substring(agencias.direccion,0,20) as direccion,
                                                    agencias.ciudad,
                                                    agencias.estado,
                                                    paises.codigopais,
                                                    agencias.telefono1,
                                                    agencias.telefono2,
                                                    agencias.correo
                                            FROM agencias
                                            LEFT JOIN paises ON agencias.idpais = paises.idpais
                                            WHERE agencias.idstatus = 1
                                            AND agencias.idagenciasap IS NULL
                                            AND agencias.identificadortributaria != ''
                                            $condicion_pais
                                            LIMIT 1
                                            ");

            foreach($agencias['resultado'] as $agencia)
            {
                $idagencia                              = $agencia['idagencia'];
                // $agencia['identificadortributaria']     = str_pad($agencia['identificadortributaria'], 13, '0', STR_PAD_LEFT);
                $idagenciasap 	                        = "C".$agencia['identificadortributaria'];
                $agencia['codigopais']                  = ($agencia['codigopais'] == 'COM') ? 'US' : $agencia['codigopais'];

                switch($idpais)
                {
                    case 5:
                        $DebitorAccount 	= "13050501";
                        $Currency 			= "##";//$
                        $GroupCode 			= '100';
                        $BPPaymentMethods 	= array();
                        break;
                    case 11:
                        $DebitorAccount 	= "13050501";
                        $Currency 			= "##";//MXN
                        $GroupCode 			= '100';
                        $BPPaymentMethods 	= array();
                        break;
                    default:
                        $DebitorAccount 	= "13051001";
                        $Currency 			= "##";//$
                        $GroupCode 			= '100';
                        $BPPaymentMethods 	= array();
                        break;
                }
                
                $data = array(
                        "CardCode" => $idagenciasap,
                        "CardName" =>  ucwords(strtolower($agencia['nombreagencia'])),
                        // "DebitorAccount" => $DebitorAccount,
                        "CardType" => 'C',
                        "Currency" => $Currency,
                        "FederalTaxID" => $agencia['identificadortributaria'],//str_pad($agencia['identificadortributaria'], 12, '0', STR_PAD_LEFT),
                        "GroupCode" => $GroupCode,
                        // "BPPaymentMethods" => $BPPaymentMethods,
                        "Address" =>  ucwords(strtolower($agencia['direccion'])),
                        "City" =>  ucwords(strtolower($agencia['ciudad'])),
                        "County" =>  ucwords(strtolower($agencia['estado'])),
                        "Country" => $agencia['codigopais'],
                        "Cellular" => $agencia['telefono1'],
                        "EmailAddress" =>  $agencia['correo'],
                        "Phone1" => $agencia['telefono1'],
                        "Phone2" => $agencia['telefono2'],
                        "HouseBank" => -1
                    );



                $agencias_sap = sap_servicio($db, "BusinessPartners", $SessionId, 'POST', $data, $idpais);
                $agencias_sap = json_decode($agencias_sap);

                if(!isset($agencias_sap->error))
                {
                    ejecuta_update($db, "UPDATE agencias SET idagenciasap = '$idagenciasap' WHERE idagencia = $idagencia");
                
                    switch($idpais)
                    {
                        case 5:
                            $contador5++;
                            break;
                        case 11:
                            $contador11++;
                            break;
                        case 99:
                            $contador99++;
                            break;
                    }
                }
                else
                {
                    // echo 'Error'; 
                    // print_r(json_encode($data)); exit;
                    // print_r($agencias_sap); exit;
                    array_push($agencias_con_error, $agencias_sap);
                }
            }

            sap_logout($db, $SessionId, $idpais);
        }
        else
        {

            $noData["resultado"]  = array("mexico" => $contador11, "colombia" => $contador5, "estadosunidos" => $contador99);
            $noData["cantidad"] = 0;
            $noData["error"] = true;
            $noData["mensaje"] = 'Error de Conexión a SAP con el pais:'.$idpais;

            $resultado = json_encode($noData);
            $response->getBody()->write($resultado);
            return $response;
        }   
    }

    $respuesta["resultado"]     = array("mexico" => $contador11, "colombia" => $contador5, "estadosunidos" => $contador99);
    $respuesta["error"]         = false;
    $respuesta["mensaje"]       = '';
    $respuesta["con_error"]     = $agencias_con_error;

    $resultado = json_encode($respuesta);
    $response->getBody()->write($resultado);
    return $response;
});
