<?php 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/srv_migracion_v1/mgr_limpiartablas',function (Request $request, Response $response)
{    
    $db_postgresql      = getDB();
    $db_mysql           = connect_db();
    $data               = json_decode($request->getBody());

    $requeridos = array(
        "clave" => array("tipo" => "string", "datos" => "novacio")
    );

    $campos_validos = validar_campos_requeridos($requeridos, $data);
    
    if($campos_validos === true)
    {
        $clave = $data->clave;

        /*** CUIDADO, SOLO INCLUIR $db_postgresql ***********************************************************/
        /**/ 
        /**/ ejecuta_delete($db_postgresql, "DELETE FROM planes");
        /**/ ejecuta_delete($db_postgresql, "DELETE FROM planesprecios");
        /**/ ejecuta_delete($db_postgresql, "DELETE FROM planescostos");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planes_idplan_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE precios_idprecio_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planescostos_idplancosto_seq RESTART WITH 1");
        /**/ 
        /*** CUIDADO, SOLO INCLUIR $db_postgresql ***********************************************************/


        $noData["resultado"] = 'Limpieza exitosa !';
        $noData["cantidad"]  = 0;
        $noData["error"]     = false;

        $resultado = json_encode($noData);
        $response->getBody()->write($resultado);
        return $response;
    }
    else
    {
        $noData["resultado"]        = array();
        $noData["cantidad"]         = 0;
        $noData["error"]            = true;
        $noData["mensaje_error"]    = $campos_validos;

        $resultado = json_encode($noData);
        $response->getBody()->write($resultado);
        return $response;
    }
});
?>
