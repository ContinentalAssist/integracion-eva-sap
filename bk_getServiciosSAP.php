<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/bk_getServiciosSAP', function (Request $request, Response $response) 
{
    $db         = getDB();
    $data       = json_decode($request->getBody());
    $cantidad   = consulta_cantidad($db, 'ordenes');

    $SessionId = sap_login($db);
    
    if($SessionId)
    {
        // //GET
        //     $condiciones = '$select=CardCode,CardName';

        //     $agencias = sap_serivicio($db, "https://srv-2108.starkcloud.com:50000/b1s/v1/BusinessPartners?".$condiciones, $SessionId, 'GET', array());

        //     if(!empty($agencias))
        //     {
        //         print_r($agencias);
        //         sap_logout($db, $SessionId);
        //     }

        // // POST
        //     $data = array(
        //             "CardCode" => "C0003",
        //             "CardName" => "Cliente Prueba 3",
        //             "CardType" => "cCustomer",
        //             "Address" => "Direccion cliente prueba 3",
        //             "ZipCode" => "05270",
        //             "MailAddress" => "prueba2@cliente.com",
        //             "Phone1" => "1234567890",
        //             "Phone2" => "0987654321",
        //             "FederalTaxID" => "RFC123456789"
        //     );

        //     $agencias = sap_serivicio($db, "https://srv-2108.starkcloud.com:50000/b1s/v1/BusinessPartners", $SessionId, 'POST', $data);

        //     if(!empty($agencias))
        //     {
        //         print_r($agencias);
        //         sap_logout($db, $SessionId);
        //     }

        // // PATCH
        //     $data = array(
        //         "CardName" => "Cliente Prueba EDITADA"
        //     );

        //     $actualiza_agencia = sap_serivicio($db, "https://srv-2108.starkcloud.com:50000/b1s/v1/BusinessPartners('C0003')", $SessionId, 'PATCH', $data);

        //     if($actualiza_agencia)
        //     {
        //         //GET
        //             $condiciones = '';

        //             $agencia = sap_serivicio($db, "https://srv-2108.starkcloud.com:50000/b1s/v1/BusinessPartners('C0003')?".$condiciones, $SessionId, 'GET', array());

        //             if(!empty($agencia))
        //             {
        //                 print_r($agencia);
        //                 sap_logout($db, $SessionId);
        //             }

        //     }
    }
    else
    {
            $noData["resultado"] = array();
            $noData["cantidad"] = 0;
            $noData["error"] = true;
            $noData["mensaje"] = 'Error de Conexión a SAP';

            $resultado = json_encode($noData);
            $response->getBody()->write($resultado);
            return $response;
    }

    exit;



    // $filtros = array(
    //     "idorden"           => array("tipobusqueda" => "propia", "tabla" => "ordenes"),
    //     "codigovoucher"     => array("tipobusqueda" => "propia", "tabla" => "ordenes"),
    //     "idtipoasistencia"  => array("tipobusqueda" => "propia", "tabla" => "ordenes"),
    //     "idstatus"          => array("tipobusqueda" => "propia", "tabla" => "ordenes"),
    //     "idagencia"         => array("tipobusqueda" => "propia", "tabla" => "ordenes"),
    //     "idcorporativo"     => array("tipobusqueda" => "propia", "tabla" => "ordenes"),
    //     "emisioncorporativa"=> array("tipobusqueda" => "propia", "tabla" => "ordenes"),
    //     "idmoneda"          => array("tipobusqueda" => "propia", "tabla" => "ordenes"),
    //     "fechacreacion"     => array("tipobusqueda" => "fechabetween", "tabla" => "ordenes","column"=>"fechacreacion", "campoid" => "ordenes.fechacreacion"),
    //     "idusuario"         => array("tipobusqueda" => "propia", "tabla" => "ordenes")
    // );

    // $key_activo     = verifica_apikey($db, $request->getHeaders()['X-Api-Key'][0]);
    // $token_activo   = verifica_token_sesion($db, $request->getHeaders()['Authorization'][0]);

    // if ($key_activo) 
    // {
    //     if ($token_activo) 
    //     {
    //         $idusuario      = get_usuario_token($db,$request->getHeaders()['Authorization'][0]);
    //         $condiciones    = armar_condiciones($data, $filtros);

    //         $token          = explode(" ",$request->getHeaders()['Authorization'][0]);
    //         $respuesta      = select_ordenes($db, $condiciones, $idusuario, $token[1]);

    //         if ($cantidad > 0) 
    //         {
    //             $resultado  = json_encode($respuesta,JSON_NUMERIC_CHECK);
    //             $response->getBody()->write($resultado);

    //             return $response;
    //         } 
    //         else 
    //         {
    //             $noData["resultado"] = array();
    //             $noData["cantidad"]  = 0;
    //             $noData["error"]     = true;
    //             $noData["mensaje"]   = 'No exiten asistencias de viajes creadas';

    //             $resultado = json_encode($noData);
    //             $response->getBody()->write($resultado);
    //             return $response;
    //         }
    //     } 
    //     else 
    //     {
    //         $noData["resultado"] = array();
    //         $noData["cantidad"] = 0;
    //         $noData["error"] = true;
    //         $noData["mensaje"] = 'Token no válido';

    //         $resultado = json_encode($noData);
    //         $response->getBody()->write($resultado);
    //         return $response;
    //     }
    // } 
    // else 
    // {
    //     $noData["resultado"] = array();
    //     $noData["cantidad"] = 0;
    //     $noData["error"] = true;
    //     $noData["mensaje"] = 'Aplicación no válida';

    //     $resultado = json_encode($noData);
    //     $response->getBody()->write($resultado);
    //     return $response;
    // }
});
