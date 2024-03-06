<?php

use DI\Container;
use Slim\Factory\AppFactory;


/*******************************************************************************************/
/* FUNCIONES DE BASE DE DATOS                                                              */
/*******************************************************************************************/

function consulta_unica($db,$campo,$tabla,$condicion)
{
    $select    = "SELECT $campo FROM continental.$tabla where $condicion";
    $consulta  = pg_query($db,$select);

    while ($row = pg_fetch_array($consulta, null, PGSQL_ASSOC)) {
        return $data[] = $row;
    }
}

function consulta_multiple($db,$select)
{
    $consulta   = pg_query($db,$select);
    $result     = pg_fetch_all($consulta); 
    
    return $result;
}

function ejecuta_select($db, $select, $campo = false)
{
    $response   = array();
    $resultado  = consulta_multiple($db,$select);

    if($resultado == '')
    {
        $response["resultado"]  = $resultado;
        $response["cantidad"]   = 0;
        $response["error"]      = false;
    }
    else
    {
        $response["resultado"]  = $resultado;
        $response["cantidad"]   = count($response["resultado"]);
        $response["error"]      = false;
    }

    if($campo)
        return $response['resultado'][0][$campo];
    else
        return $response;

}

function ejecuta_insert($db, $insert)
{
    
    $accion     = pg_query($db, $insert);
    $resultado  = $accion == false? 0:  pg_affected_rows($accion);
    return $resultado;
}

function ejecuta_update($db, $update)
{   

    $consulta = pg_query($db, $update);

    return $consulta;
}

function ejecuta_delete($db, $delete)
{
    $resultado = pg_query($db, $delete);

    return $resultado;
}

function consulta_max($db,$campo,$tabla)
{
    $select    = "SELECT MAX($campo) as $campo FROM $tabla";
    $consulta  = pg_query($db,$select);

    while ($row = pg_fetch_array($consulta, null, PGSQL_ASSOC)) {
        return $row[$campo];
    }
}

/*******************************************************************************************/
/* FUNCIONES COMUNES                                                              */
/*******************************************************************************************/

function descontar_credito_agencia($db, $id_broker,$precio_total)
{

    $select =   "SELECT credito_actual
                    FROM continental.broker
                    WHERE id_broker = $id_broker
                ";

    $consulta = ejecuta_select($db, $select);

    $total_descontado = $consulta['resultado'][0]['credito_actual'] - $precio_total;

    $update =   "UPDATE continental.broker SET credito_actual = ".$total_descontado." WHERE id_broker = $id_broker";

    if(ejecuta_update($db,$update))
    {
        return true;
    }
    else
    {
        $response['resultado'] = array("mensaje_error"=>"EL CREDITO ACTUAL DE LA AGENCIA NO ES SUFICIENTE");
        $response['cantidad']  = 0;
        $response['error']     = true; 
        return $response;
    }
}

function valida_credito_agencia($db, $id_broker, $precio_total)
{
    $select =   "   SELECT credito_actual
                    FROM continental.broker
                    WHERE id_broker = $id_broker
                ";

    $consulta = ejecuta_select($db, $select);


    if($consulta['resultado'][0]['credito_actual'] > $precio_total )
    {
        //echo 'Bien';exit;
        return true;
    }
    else
    {
        return false;
    }
}

function valida_forma_pago($forma_pago, $tdc, $nombre_tdc, $cvv, $mes_vencimiento, $ano_vencimiento)
{
    $error = false;

    if($forma_pago == 2)
    {
        //POR AHORA
        //$response['resultado'] = array("mensaje_error"=>"FORMA DE PAGO TEMPORALMENTE INHABILITADA");
        //$error = true;

        // (NO BORRAR) VALIDACIONES PARA TDC (NO BORRAR)

        if($tdc != '')
        {
            if(strlen($tdc) == 16 || strlen($tdc) == 15)
            {
                if($cvv != '')
                {
                    if($nombre_tdc != '')
                    {
                        if($ano_vencimiento != '')
                        {
                            $ano = date('y');
        
                            if($ano_vencimiento >= $ano)
                            {
                                $mes = date('m');
                               
                                if($ano_vencimiento > $ano)
                                {
                                    $error = false;
                                }
                                else if($ano_vencimiento == $ano && $mes_vencimiento >= $mes)
                                {
                                    $error = false;
                                }
                                else
                                {
                                    $response['resultado'] = array("mensaje_error"=>"FORMA DE PAGO 2: LA TDC SE ENCUENTRA VENCIDA (MES)");
                                    $error = true;
                                }
                            }
                            else
                            {
                                $response['resultado'] = array("mensaje_error"=>"FORMA DE PAGO 2: LA TDC SE ENCUENTRA VENCIDA (A#O)");
                                $error = true;
                            }
                        }
                        else
                        {
                            $response['resultado'] = array("mensaje_error"=>"FORMA DE PAGO 2: EL DATO DEL A#O DE VENCIMIENTO DE LA TDC NO PUEDE ESTAR VACIO");
                            $error = true;
                        }
                    }
                    else
                    {
                        $response['resultado'] = array("mensaje_error"=>"FORMA DE PAGO 2: EL NOMBRE DEL TITULAR DE LA TDC ES UN DATO OBLIGATORIO");
                        $error = true;
                    }
                }
                else
                {
                    $response['resultado'] = array("mensaje_error"=>"FORMA DE PAGO 2: CVV INCORRECTO");
                    $error = true;
                }
            }
            else
            {
                $response['resultado'] = array("mensaje_error"=>"FORMA DE PAGO 2: CANTIDAD DE DIGITOS INCORRECTOS EN LA TDC");
                $error = true;
            }
        }
        else
        {
            $response['resultado'] = array("mensaje_error"=>"FORMA DE PAGO 2: LOS NUMEROS DE LA TDC SON NECESARIOS");
            $error = true;
        }
    }
    else if($forma_pago != 1 && $forma_pago != 2)
    {
        $response['resultado'] = array("mensaje_error"=>"FORMA DE PAGO INVALIDA");
        $error = true;
    }

    if($error)
    {
        $response['cantidad']  = 0;
        $response['error']     = true;

        return $response;
    }
    else
    {
        return true;
    }
}

function verifyRequiredParams($required_fields, $request)
{
    $error          = false;
    $error_fields   = "";
    $request_params = array();
    $request_params = $_REQUEST;

    if ($_SERVER['REQUEST_METHOD'] == 'PUT')
    {
        $app = \Slim\Slim::getInstance();    
        parse_str($app->request()->getBody(), $request_params);
    }

    foreach ($required_fields as $field)
    {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0)
        {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error)
    {
        $response               = array();
        $app                    = \Slim\Slim::getInstance();
        $response["error"]      = true;
        $response["message"]    = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';

        echoResponse(400, $response);
        $app->stop();
        exit;
    }
}

function busca_y_valida_cantidad_de_dias($desde, $hasta)
{
    $datetime1     = date_create($desde);
    $datetime2     = date_create($hasta);
    $interval      = date_diff($datetime1, $datetime2);
    $interval      = $interval->format('%a');
    $cantidad_dias = $interval + 1;


    if($datetime1 <= $datetime2)
    {
        if($cantidad_dias < 3)
        {
            $cantidad_dias = 3;
        }
        else if($cantidad_dias > 365)
        {
            $response['resultado'] = array("mensaje_error"=>"LA CANTIDAD DE DIAS ES SUPERIOR A LA PERMITIDA");
            $response['cantidad']  = 0;
            $response['error']     = true;
            return $response;
        }
    }
    else
    {
        $response['resultado'] = array("mensaje_error"=>"FORMATO DE FECHAS INCORRECTAS");
        $response['cantidad']  = 0;
        $response['error']     = true;
        return $response;
    }
    return $cantidad_dias;
}

function valida_categoria_plan_y_dias($db, $id_broker, $id_categoria, $id_plan, $cantidad_dias)
{

    $select     = " SELECT  id_categoria
                    FROM    continental.plan_categoria_broker
                    where   id_broker = ".$id_broker;

    $response   = ejecuta_select($db, $select);
    $categorias = $response['resultado'][0]['id_categoria'];

    $select  =  "   SELECT  plan_categoria_detail.id_plan_categoria
                    FROM    continental.plan_categoria_detail, continental.plans
                    WHERE   plan_categoria_detail.id_plan_categoria = $id_categoria
                    AND     $cantidad_dias BETWEEN plan_categoria_detail.min_time AND plan_categoria_detail.max_time
                    AND     plan_categoria_detail.id_plan_categoria in ($categorias)
                    AND     (plans.custom_broker = $id_broker OR plans.custom_broker = 0)
                    AND     plans.id = $id_plan
                    AND     plan_categoria_detail.language_id = 'spa'";
    $consulta = ejecuta_select($db, $select);

    if($consulta['resultado'][0]['id_plan_categoria'] == $id_categoria)
    {
        return $id_categoria;
    }
    else
    {
       /*  $response['resultado'] = array("mensaje_error"=>"LA CATEGORIA, EL PLAN O LOS DIAS NO SON VALIDOS. ASEGURESE QUE LOS DATOS SEAN CORRECTOS Y QUE LA AGENCIA ESTE AUTORIZADA PARA VENDER ESTA CATEGORIA");
        $response['cantidad']  = 0;
        $response['error']     = true; */

        return false;
    }
}

function validateEmail($email)
{
    //$app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        //echoResponse(400, $response);
        return $response;
        //$app->stop();
        //exit;
    }
}

function formatea_fecha($fecha,$caracater_salida)
{
    $fecha  = explode('/',$fecha);
    $fecha  = $fecha[2].$caracater_salida.$fecha[1].$caracater_salida.$fecha[0];
    return $fecha;
}

function formatea_fecha_anormal($fecha,$caracater_salida)
{
    $fecha  = explode('-',$fecha);
    $fecha  = $fecha[2].$caracater_salida.$fecha[1].$caracater_salida.$fecha[0];
    return $fecha;
}

function busca_personas_mayor_70($beneficiarios)
{
    $incremento = array();

    for($i=0;$i < count($beneficiarios); $i++)
    {
        $edad           = (int) calcula_edad(formatea_fecha($beneficiarios[$i]->fechaNac,'-'));
        $edad_indicada  = (int) $beneficiarios[$i]->edad;

        if($edad == $edad_indicada)
        {
            if($edad >= 70 && $edad < 85 )
            {
                array_push($incremento, $beneficiarios[$i]->pasaporte);
            }
        }
        else
        {
            $response["resultado"][0]["mensaje_error"]  = 'LA FECHA DE NACIMIENTO Y LA EDAD DEL PASAJERO CON EL DOCUMENTO: '.$beneficiarios[$i]->pasaporte.' NO COINCIDEN.';
            $response["cantidad"]                       = 0;
            $response["error"]                          = true;

            return $response;
        }
    }
    return $incremento;
}

function busca_personas_mayor_85($beneficiarios)
{
    $incremento = array();

    for($i=0;$i < count($beneficiarios); $i++)
    {
        $edad           = (int) calcula_edad(formatea_fecha($beneficiarios[$i]->fechaNac,'-'));
        $edad_indicada  = (int) $beneficiarios[$i]->edad;

        if($edad == $edad_indicada)
        {
            if($edad >= 85 && $edad <= 99 )
            {
                array_push($incremento, $beneficiarios[$i]->pasaporte);
            }
        }
        else
        {
            $response["resultado"][0]["mensaje_error"]  = 'LA FECHA DE NACIMIENTO Y LA EDAD DEL PASAJERO CON EL DOCUMENTO: '.$beneficiarios[$i]->pasaporte.' NO COINCIDEN.';
            $response["cantidad"]                       = 0;
            $response["error"]                          = true;

            return $response;
        }
    }
    return $incremento;
}

function calcula_edad($fecha)
{
    list($Y,$m,$d) = explode("-",$fecha);
    return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}

function busca_datos_agencia($db, $agencia,$campo)
{
    $select  = "SELECT  ws_tokens.id_broker,
                        id_country,
                        broker
                FROM    continental.ws_tokens , continental.broker
                WHERE   ws_tokens.token_pag = '$agencia'
                AND     ws_tokens.id_cia = 0
                AND     ws_tokens.id_broker = broker.id_broker ";
    $consulta = ejecuta_select($db, $select);
    $consulta = $consulta['resultado'][0][$campo];
    return $consulta;
}

function busca_datos_agencia_compra($db, $agencia)
{
    $select                 = "SELECT * FROM continental.broker where id_broker ='$agencia'";
    $datos_agencia    = ejecuta_select($db, $select);
    return $datos_agencia;
}

function busca_datos_nivel_agencia($db, $agencia)
{
    $select                 = "SELECT * FROM continental.broker_nivel where id_broker ='$agencia'";
    $datos_nivel_agencia    = ejecuta_select($db, $select);
    return $datos_nivel_agencia;
}

function busca_porcentaje_agencia($db, $id_broker,$id_categoria)
{
    $select                 = "SELECT porcentaje FROM continental.commissions where id_agencia = '$id_broker' and id_categoria = '$id_categoria'";
    $porcentaje_agencia     = ejecuta_select($db, $select);

    if($porcentaje_agencia['cantidad']==0)
    {
        $porcentaje_agencia['resultado'][0]['porcentaje'] = 0.00;
        $porcentaje_agencia['cantidad'] = 1;
        $porcentaje_agencia['error'] = false;
    }

    return $porcentaje_agencia;
}

function validacion_bloqueos($db, $beneficiarios,$email_contacto,$ip)
{
    $bloqueo_encontrados = 0;

    $nombre             = $beneficiarios[0]->nombre;
    $apellido           = $beneficiarios[0]->apellido;
    $identificacion     = $beneficiarios[0]->pasaporte;
    $correo             = $beneficiarios[0]->email;
    $correo_contacto    = $email_contacto;
    $ip                 = $ip;

    $select         = "SELECT COUNT(*) as cantidad_bloqueos FROM continental.bloqueos WHERE nombre LIKE '%$nombre%' AND apellido LIKE '%$apellido%' LIMIT 1 ";
    $validacion1    = ejecuta_select($db, $select);


    $select         = "SELECT COUNT(*) as cantidad_bloqueos FROM continental.bloqueos WHERE identificacion = '$identificacion' LIMIT 1 ";
    $validacion2    = ejecuta_select($db, $select);

    $select         = "SELECT COUNT(*) as cantidad_bloqueos FROM  continental.bloqueos WHERE email_pasajero LIKE '%$correo%' LIMIT 1 ";
    $validacion3    = ejecuta_select($db, $select);

    $select         = "SELECT COUNT(*) as cantidad_bloqueos FROM  continental.bloqueos WHERE email_contacto LIKE '%$correo_contacto%' LIMIT 1 ";
    $validacion4    = ejecuta_select($db, $select);

    $select         = "SELECT COUNT(*) as cantidad_bloqueos FROM  continental.bloqueos WHERE ip = '$ip' LIMIT 1 ";
    $validacion5    = ejecuta_select($db, $select);

    $bloqueo_encontrados = $validacion1['resultado'][0]['cantidad_bloqueos'] + $validacion2['resultado'][0]['cantidad_bloqueos'] + $validacion3['resultado'][0]['cantidad_bloqueos'] + $validacion4['resultado'][0]['cantidad_bloqueos'] + $validacion5['resultado'][0]['cantidad_bloqueos'];



    return $bloqueo_encontrados;
}

function genera_codigo_order($id_country,$inicioVoucher="CA")
{
    $chr = "0123456789ABCDEFGHIJKML";
    $str = "";

    while(strlen($str) < 6)
    {
        $str .= substr($chr, mt_rand(0,(strlen($chr))), 1);
    }

    $my_numeric_text_string = $str;
    $country                = utf8_encode(trim($id_country));

    if($country=='1S')
    {
        $country = 'COM';
    }

    /*if($id_broker == 2676)
    {
        $company = 'OI-';
    }
    else
    {
        $company = 'CA-';
    } */

    $codigo  = $inicioVoucher."-".$my_numeric_text_string. "-".$country;

    return $codigo;
}

function busca_id_orden_insertado($db, $codigo)
{
    $select = "SELECT id as lastid FROM continental.orders where codigo = '".$codigo."'";
    $lastid = ejecuta_select($db, $select);
    return $lastid['resultado'][0]['lastid'];
}

function busca_montos($db, $id_plan,$id_categoria,$cantidad_dias=0,$campo)
{
    if($id_categoria == 23)
    {
        $select = "SELECT precio,costo1,costo2 from continental.precios where id_plan = ".$id_plan.";";
    }
    else
    {
        $select = "SELECT precio,costo1,costo2 from continental.precios where id_plan = ".$id_plan." and dias = ".$cantidad_dias.";";
    }

    $consulta = ejecuta_select($db, $select);
    $consulta = $consulta['resultado'][0][$campo];

    return $consulta;
}

function busca_y_valida_beneficios_adicionales($beneficios_adicionales, $precio_beneficio_adicional, $precio_beneficio_adicional_por_edad, $fechaNac)
{

    sort($beneficios_adicionales);

    $beneficios_adicionales = array_pad($beneficios_adicionales, 3, 0);
    $edad                   = (int) calcula_edad(formatea_fecha($fechaNac,'-'));
    $cancelacion_multicausa = false;

    if($beneficios_adicionales[0] == 38 || $beneficios_adicionales[1] == 38 || $beneficios_adicionales[2] == 38) 
    {
        $cancelacion_multicausa = true;

        if($beneficios_adicionales[0] == 0)
        {
            unset($beneficios_adicionales[0]);
        }

        if($beneficios_adicionales[1] == 0)
        {
            unset($beneficios_adicionales[1]);
        }

        if($beneficios_adicionales[2] == 0)
        {
            unset($beneficios_adicionales[2]);
        }
    }
    else
    {
        unset($beneficios_adicionales[2]);
    }

    $beneficios_y_montos    = array();
    $arreglo                = array();

    for($contador=0;$contador < count($beneficios_adicionales); $contador++)
    {
        if ($edad > 70)
        {
            $precio_cost_sp  = $precio_beneficio_adicional_por_edad;
        }
        else
        {
            $precio_cost_sp  = $precio_beneficio_adicional;
        }

        if($beneficios_adicionales[$contador]==0)
        {
            $precio_cost_sp = 0;
        }

        $beneficios_y_montos[$contador] = array("id" => $beneficios_adicionales[$contador], "precio_cost_sp" => $precio_cost_sp);
    }

    return $beneficios_y_montos;
}

function busca_y_valida_cantidad_personas_con_beneficios_adicionales($beneficiarios)
{
    $detectadas                         = array();
    $cantidad_de_beneficios_adicionales = 0;
    $total_cantidad_de_beneficios       = 0;
    $mayores_a_70                       = 0;
    $menores_a_70                       = 0;

    for($i=0;$i < count($beneficiarios); $i++)
    {
        if(count($beneficiarios[$i]->beneficios_adicionales) > 0)
        {
            if(valida_combinacion_beneficios_adicionales($beneficiarios[$i]->beneficios_adicionales))
            {
                $edad = (int) calcula_edad(formatea_fecha($beneficiarios[$i]->fechaNac,'-'));
                if($edad > 70)
                {
                    $mayores_a_70 = $mayores_a_70 + count($beneficiarios[$i]->beneficios_adicionales);
                }
                else
                {
                    $menores_a_70 = $menores_a_70 + count($beneficiarios[$i]->beneficios_adicionales);
                }

                $cantidad = array("fechaNac" => $beneficiarios[$i]->fechaNac, "cantidad" => count($beneficiarios[$i]->beneficios_adicionales));
                array_push($detectadas, $cantidad);
            }
        }
    }

    for ($i=0;$i < count($detectadas); $i++)
    {
        $total_cantidad_de_beneficios = $total_cantidad_de_beneficios + $detectadas[$i]['cantidad'];
    }

    $personas_con_beneficios_adicionales['personas_con_beneficios'] = $detectadas;
    $personas_con_beneficios_adicionales['cantidad_total']          = $total_cantidad_de_beneficios;
    $personas_con_beneficios_adicionales['mayores_a_70']            = $mayores_a_70;
    $personas_con_beneficios_adicionales['menores_a_70']            = $menores_a_70;

    return $personas_con_beneficios_adicionales;
}

function armar_array_auditoria($modulo, $accion, $registro_actual, $datos)
{
    $auditorias = array();

    foreach($registro_actual as $clave => $valor)
    {
        if(isset($datos[$clave]))
        {
            if(gettype($datos[$clave]) == 'array')
            {
                $array_anterior = implode(",", $valor);
                $array_nuevo 	= implode(",", $datos[$clave]);
                
                if($array_anterior != $array_nuevo)
                {
                    $auditoria['idusuario']			= $datos['idusuario'];
                    $auditoria['modulo']			= $modulo;
                    $auditoria['accion']			= $accion.':'.$clave;
                    $auditoria['objetocambio']		= $datos['objetocambio'];
                    $auditoria['datosanteriores']	= $array_anterior;
                    $auditoria['datosnuevos']		= $array_nuevo;
                    array_push($auditorias, $auditoria);
                }
            }
            else
            {
                if($valor != $datos[$clave])
                {
                    $auditoria['idusuario']			= $datos['idusuario'];
                    $auditoria['modulo']			= $modulo;
                    $auditoria['accion']			= $accion.':'.$clave;
                    $auditoria['objetocambio']		= $datos['objetocambio'];
                    $auditoria['datosanteriores']	= $valor;
                    $auditoria['datosnuevos']		= $datos[$clave];
                    array_push($auditorias, $auditoria);
                }
            }
        }
    }

    return $auditorias;
}

function inserta_auditoria($db, $auditoria){
    $servicio = $auditoria['servicio'];
    $ps       = $auditoria['ps'];
    $data     = $auditoria['data'];
    $response = ($auditoria['response']['resultado']) ? json_encode($auditoria['response']['resultado']) : 'conexion';
    $insert   = "INSERT INTO continental.ws_auditoria(servicio, ps, data_recibida, fecha, response) 
                VALUES ('".$servicio."','".$ps."','".$data."', NOW(), '".$response."');";
    $response = ejecuta_insert($db, $insert);
    return $response;
}


function inserta_orden($db, $orden)
{
    $id                     = $orden['id'];
    $tiempo_x_producto      = $orden['tiempo_x_producto'];
    $origen                 = $orden['origen'];
    $destino                = $orden['destino'];
    $salida                 = $orden['salida'];
    $retorno                = $orden['retorno'];
    $programaplan           = $orden['programaplan'];
    $nombre_contacto        = $orden['nombre_contacto'];
    $email_contacto         = $orden['email_contacto'];
    $comentarios            = $orden['comentarios'];
    $comentario_medicas     = $orden['comentario_medicas'];
    $telefono_contacto      = $orden['telefono_contacto'];
    $producto               = $orden['producto'];
    $credito_tipo           = $orden['credito_tipo'];
    $credito_numero         = $orden['credito_numero'];
    $credito_expira         = $orden['credito_expira'];
    $credito_cvv            = $orden['credito_cvv'];
    $credito_nombre         = $orden['credito_nombre'];
    $agencia                = $orden['agencia'];
    $nombre_agencia         = $orden['nombre_agencia'];
    $total                  = $orden['total'];
    $codigo                 = $orden['codigo'];
    $fecha                  = $orden['fecha'];
    $hora                   = $orden['hora'];
    $neta                   = $orden['neta'];
    $neta2                  = $orden['neta2'];
    $neta3                  = $orden['neta3'];
    $vendedor               = $orden['vendedor'];
    $incentivo_porc         = $orden['incentivo_porc'];
    $incentivo_usd          = $orden['incentivo_usd'];
    $cantidad               = $orden['cantidad'];
    $nivel1                 = $orden['nivel1'];
    $nivel2                 = $orden['nivel2'];
    $nivel3                 = $orden['nivel3'];
    $nivel4                 = $orden['nivel4'];
    $nivel1_porc            = $orden['nivel1_porc'];
    $nivel2_porc            = $orden['nivel2_porc'];
    $nivel3_porc            = $orden['nivel3_porc'];
    $nivel4_porc            = $orden['nivel4_porc'];
    $nivel1_usd             = $orden['nivel1_usd'];
    $nivel2_usd             = $orden['nivel2_usd'];
    $nivel3_usd             = $orden['nivel3_usd'];
    $nivel4_usd             = $orden['nivel4_usd'];
    $status                 = $orden['status'];
    $es_emision_corp        = $orden['es_emision_corp'];
    $cupon                  = $orden['cupon'];
    $codeauto               = $orden['codeauto'];
    $procesado              = $orden['procesado'];
    $procesado_id           = $orden['procesado_id'];
    $origin_ip              = $orden['origin_ip'];
    $v_authorizado          = $orden['v_authorizado'];
    $response               = $orden['response'];
    $cod_corp               = $orden['cod_corp'];
    $id_client              = $orden['id_client'];
    $alter_cur              = $orden['alter_cur'];
    $tasa_cambio            = $orden['tasa_cambio'];
    $forma_pago             = $orden['forma_pago'];
    $family_plan            = $orden['family_plan'];
    $tax1_name              = $orden['tax1_name'];
    $tax1_Value             = $orden['tax1_Value'];
    $tax1_totalcomisionable = $orden['tax1_totalcomisionable'];
    $tax1_impuesto          = $orden['tax1_impuesto'];
    $neto_prov              = $orden['neto_prov'];
    $neto_prov2             = $orden['neto_prov2'];
    $neto_prov3             = $orden['neto_prov3'];
    $neto_prov4             = $orden['neto_prov4'];
    $neto_prov5             = $orden['neto_prov5'];
    $neto_prov6             = $orden['neto_prov6'];
    $cancelacion            = $orden['cancelacion'];
    $cancelacion2           = $orden['cancelacion2'];
    $referencia             = $orden['referencia'];
    $eliminado              = $orden['eliminado'];
    $fuente                 = $orden['fuente'];
    $manual                 = $orden['manual'];
    $extra                  = $orden['extra'];
    $extra2                 = $orden['extra2'];
    $id_cia                 = $orden['id_cia'];

    $insert                 = "INSERT INTO continental.orders (tiempo_x_producto, origen, destino, salida, retorno, programaplan, nombre_contacto, email_contacto, comentarios, comentario_medicas, telefono_contacto, producto, credito_tipo, credito_numero, credito_expira, credito_cvv, credito_nombre, agencia, nombre_agencia, total, codigo, fecha, hora, neta, neta2, neta3, vendedor, incentivo_porc, incentivo_usd, cantidad, nivel1, nivel2, nivel3, nivel4, nivel1_porc, nivel2_porc, nivel3_porc, nivel4_porc, nivel1_usd, nivel2_usd, nivel3_usd, nivel4_usd, status, es_emision_corp, cupon, codeauto, procesado, procesado_id, origin_ip, v_authorizado, response, cod_corp, id_client, alter_cur, tasa_cambio, forma_pago, family_plan, tax1_name, tax1_Value, tax1_totalcomisionable, tax1_impuesto, neto_prov, neto_prov2, neto_prov3, neto_prov4, neto_prov5, neto_prov6, cancelacion, cancelacion2, referencia, eliminado, fuente, manual, extra, extra2, id_cia ) 
                                VALUES ($tiempo_x_producto, '$origen', '$destino', '$salida', '$retorno', '$programaplan', '$nombre_contacto', '$email_contacto', '$comentarios', '$comentario_medicas', '$telefono_contacto', $producto, '$credito_tipo', '$credito_numero', '$credito_expira', '$credito_cvv', '$credito_nombre', $agencia, '$nombre_agencia', $total, '$codigo', NOW(), NOW(), $neta, $neta2, $neta3, $vendedor, $incentivo_porc, $incentivo_usd, '$cantidad', $nivel1, $nivel2, $nivel3, $nivel4, $nivel1_porc, $nivel2_porc, $nivel3_porc, $nivel4_porc, $nivel1_usd, $nivel2_usd, $nivel3_usd, $nivel4_usd, $status, '$es_emision_corp', '$cupon', '$codeauto', $procesado, '$procesado_id', '$origin_ip', '$v_authorizado', '$response', $cod_corp, $id_client, '$alter_cur', $tasa_cambio, $forma_pago, '$family_plan', '$tax1_name', $tax1_Value, $tax1_totalcomisionable, $tax1_impuesto, $neto_prov, $neto_prov2, $neto_prov3, $neto_prov4, $neto_prov5, $neto_prov6, $cancelacion, $cancelacion2, '$referencia', $eliminado, $fuente, $manual, $extra, $extra2, $id_cia );";
    $response = ejecuta_insert($db, $insert);
    
    return $response;
}

// function inserta_beneficiario($db, $beneficiario)
// {
//     $id_orden          = $beneficiario['id_orden'];
//     $id_emision        = $beneficiario['id_emision'];
//     $nombre            = $beneficiario['nombre'];
//     $apellido          = $beneficiario['apellido'];
//     $email             = $beneficiario['email'];
//     $telefono          = $beneficiario['telefono'];
//     $nacimiento        = $beneficiario['nacimiento'];
//     $documentacion     = $beneficiario['documentacion'];
//     $nacionalidad      = $beneficiario['nacionalidad'];
//     $titular           = $beneficiario['titular'];
//     $rp_id_generate    = $beneficiario['rp_id_generate'];
//     $rp_date_generate  = $beneficiario['rp_date_generate'];
//     $precio_vta        = $beneficiario['precio_vta'];
//     $precio_cost       = $beneficiario['precio_cost'];
//     $precio_cost2      = $beneficiario['precio_cost2'];
//     $ben_status        = $beneficiario['ben_status'];
//     $id_rider          = $beneficiario['id_rider'];
//     $precio_cost_sp    = $beneficiario['precio_cost_sp'];
//     $id_rider2         = $beneficiario['id_rider2'];
//     $precio_cost_sp2   = $beneficiario['precio_cost_sp2'];
//     $cancel_monto      = $beneficiario['cancel_monto'];
//     $cancel_cobertura  = $beneficiario['cancel_cobertura'];
//     $es_emision_corp   = $beneficiario['es_emision_corp'];

//     $insert = " INSERT INTO continental.beneficiaries   (id_orden, id_emision, nombre, apellido, email, telefono, nacimiento, documento, nacionalidad, titular, rp_id_generate, rp_date_generate, precio_vta, precio_cost, precio_cost2, ben_status, id_rider, precio_cost_sp, id_rider2, precio_cost_sp2, cancel_monto, cancel_cobertura, es_emision_corp ) VALUES ($id_orden, $id_emision, '$nombre', '$apellido', '$email', '$telefono', '$nacimiento', '$documento', '$nacionalidad', '$titular', '$rp_id_generate', NOW(), $precio_vta, $precio_cost, $precio_cost2, $ben_status, '$id_rider', $precio_cost_sp, $id_rider2, $precio_cost_sp2, $cancel_monto, $cancel_cobertura, $es_emision_corp )";
//     $response = ejecuta_insert($db, $insert);

//     return $response;
// }

function activa_orden($db, $lastid)
{
    $update = "UPDATE continental.orders SET status = 1 where id = $lastid";
    $response = ejecuta_update($db, $update);

    return $response;
}

function rechaza_orden($db, $lastid)
{
    $update = "UPDATE continental.orders SET status = 3 where id = $lastid";

    $response = ejecuta_update($db, $update);

    return $response;
}

function asigna_precio_individual($fechaNac, $precio_individual, $precio_incremento_por_edad)
{
    $edad = (int) calcula_edad(formatea_fecha($fechaNac,'-'));

    if($edad > 70)
    {
        $precio_individual_mas_incremento = $precio_individual + $precio_incremento_por_edad;
        return $precio_individual_mas_incremento;
    }
    else
    {
        return $precio_individual;
    }
}

function valida_combinacion_beneficios_adicionales($beneficios_adicionales)
{
    $cantidad = count($beneficios_adicionales);

    if($cantidad > 1)
    {
        for($contador = 0; $contador < $cantidad; $contador++)
        {
            if(isset($beneficios_adicionales[$contador+1]))
            {
                if(($beneficios_adicionales[$contador]==36 && $beneficios_adicionales[$contador+1]==37) || $beneficios_adicionales[$contador]==37 && $beneficios_adicionales[$contador+1]==36)
                {
                   /*  $respuesta["resultado"]       = array("mensaje_error"=>"LA COMBINACION DE LOS BENEFICIOS ADICIONALES NO ES CORRECTA.");
                    $respuesta["cantidad"]        = 0;
                    $respuesta["error"]           = true; */

                    return false;
                }else{
                    return true;
                }
            }
        }
    }else{
        return true;
    }
}

function valida_agencia($db, $ps)
{
    $validacion_comillas_simples = strpos("'", $ps);
    $validacion_comillas_dobles  = strpos('"', $ps);

    if($validacion_comillas_simples===false && $validacion_comillas_dobles===false)
    {
        $select    = "SELECT id_broker from continental.ws_tokens where token_pag = '".$ps."' and id_cia = 1";
        $resultado = ejecuta_select($db,$select);

        return $resultado['resultado'][0]['id_broker'];
    }
}

function valida_solo_inclusion($db, $id_broker)
{
    $select    = "SELECT solo_inclusion from continental.broker where id_broker = ".$id_broker;
    $resultado = ejecuta_select($db, $select);
    return $resultado['resultado'][0]['solo_inclusion'];
}

function valida_agencia_solo_inclusion($db, $id_broker, $id_categoria)
{
    $select    = "select solo_inclusion from continental.broker where id_broker = ".$id_broker;

    $resultado = ejecuta_select($db, $select);

    if($resultado['resultado'][0]['solo_inclusion'] == 1 && $id_categoria != 28)
    {
        $response["resultado"][0]["mensaje_error"]  = 'LA AGENCIA NO ESTA AUTORIZADA A VENDER ESTA CATEGORIA';
        $response["cantidad"]                       = 0;
        $response["error"]                          = true;
    }

    return $response;
}

function valida_origen($db, $origen)
{
    if($origen != '')
    {
        $select = "SELECT  iso_country from continental.countries where iso_country = '$origen'";
        $resultado = ejecuta_select($db, $select);
        if($resultado['resultado'][0]['iso_country'] == $origen)
        {
            return $origen;
        }
        else
        {
            return error('ORIGEN INVALIDO');
        }
    }
    else
    {
        return error('EL CAMPO ORIGEN NO PUEDE ESTAR VACIO');
    }
}

function valida_destino($db, $destino)
{
    if($destino !== '')
    {
        $select = "SELECT id_destino from continental.ws_destino where id_destino = '$destino' and status_destino = 1";
        $resultado = ejecuta_select($db, $select);
        if($resultado['resultado'][0]['id_destino'] == $destino)
        {
            return $destino;
        }
        else
        {
            return error('DESTINO INVALIDO');
        }
    }
    else
    {
        return error('EL CAMPO DESTINO NO PUEDE ESTAR VACIO');
    }
}

function formato_link($pagina)
{
    $pagina = str_replace("http://", "", $pagina);
    $pagina = str_replace("https://", "", $pagina);
    $last= substr($pagina, -1);
    if($last == '/')
    $pagina = substr($pagina, 0, -1);
    return $pagina;
}

function busca_categoria($db, $id_plan)
{
    $select     = " SELECT  id_plan_categoria
                    FROM    continental.plans
                    where   id = '$id_plan'";
    $categoria   = ejecuta_select($db, $select);
    $categoria = $categoria['resultado'][0]['id_plan_categoria'];
    return $categoria;
}

// function error($mensaje)
// {
//     $response['resultado'] = array("mensaje_error"=>$mensaje);
//     $response["cantidad"]  = 0;
//     $response["error"]     = true;

//     return $response;
// }

// function response_error($response, $mensaje)
// {
//     $respuesta = array();
//     $respuesta['resultado'] = array("mensaje_error"=>$mensaje);
//     $respuesta["cantidad"]  = 0;
//     $respuesta["error"]     = true;
//     $respuesta 				= json_encode($respuesta);
//     $response->getBody()->write($respuesta);
//     return $response;
// }

function busca_vendedor($db, $id_broker)
{
    $select = "SELECT vendedor FROM continental.ws_tokens WHERE id_broker = $id_broker and id_cia = 0";

    $vendedor = ejecuta_select($db, $select);
    $vendedor = $vendedor['resultado'][0]['vendedor'];
    return $vendedor;
}

function valida_ver_precio($db, $id_broker)
{
    $select = "SELECT ver_precio FROM continental.broker WHERE id_broker = $id_broker";

    $ver_precio = ejecuta_select($db, $select);
    $ver_precio = ($ver_precio['resultado'][0]['ver_precio'] == 1) ? true : false ;
    return $ver_precio;
}

function validar_formatos_entrada($data, $formatos)
{
    $todo_bien = true;
    foreach ($formatos[1] as $formato)
    {
        if($formato[1] == "numerico")
        {
            if(is_numeric($data->$formato[0]))
            {
                $todo_bien = true;
            }
            else
            {
                return false;
            }
        }

        if($formato[1] == "array")
        {
            if(is_array($data->$formato[0]))
            {
                $todo_bien = true;
            }
            else
            {
                return false;
            }
        }

        if($formato[1] == "caracter")
        {
            if(is_string($data->$formato[0]))
            {
                $todo_bien = true;
            }
            else
            {
                return false;
            }
        }

        if($formato[1] == "fecha")
        {
            if(is_string($data->$formato[0]))
            {
                $todo_bien = true;
            }
            else
            {
                return false;
            }
        }

        if($formato[1] == "no_validar")
        {
            $todo_bien = true;
        } 
    }

    if($todo_bien)
    {
        return true;
    }
}

function categorias_validas($db, $id_broker)
{
    $select = "SELECT id_categoria FROM continental.plan_categoria_broker WHERE id_broker = " .$id_broker;
    $response = ejecuta_select($db, $select);
    return (valida_solo_inclusion($db, $id_broker)) ? '28' : $response['resultado'][0]['id_categoria'];
}

function campo_tabla_condicion_order_limit_error($db, $campo,$tabla,$condicion,$order,$limit,$error)
{
    $order = ($order != '') ? ' ORDER BY '.$order  : ' ';
    $limit = ($limit != '') ? ' LIMIT '.$limit : ' ';

    $select   = "SELECT $campo as campo FROM continental.$tabla WHERE $condicion  $order $limit ";
    $busqueda = ejecuta_select($db, $select);
    if($busqueda['resultado'])
    {
        return $busqueda['resultado'][0]['campo'];
    }
    else
    {
        if($error)
        {
            $mensaje = 'LA BUSQUEDA DEL CAMPO '.$campo.' EN LA TABLA '.$tabla.' CON LA CONDICION '. $condicion.' NO TIENE RESULTADOS VALIDOS';
            return $mensaje;
        }
        else
        {
            return false;
        }
    }
}

function insertar_emision($db, $data_emision)
{
    $insert = "INSERT INTO continental.emisiones (orden, salida, retorno, origen, destino, dias, nombre_contacto, email_contacto,
                            telefono_contacto,codigo, fecha, hora, status, corporativo, agencia, vendedor, nombre_agencia, cantidad, comentarios )
                            VALUES  (".$data_emision['orden'].",
                                    '".$data_emision['salida']."',
                                    '".$data_emision['retorno']."',
                                    '".$data_emision['origen']."',
                                    ".$data_emision['destino'].",
                                    ".$data_emision['dias'].",
                                    '".$data_emision['nombre_contacto']."',
                                    '".$data_emision['email_contacto']."',
                                    '".$data_emision['telefono_contacto']."',
                                    '".$data_emision['codigo']."',
                                    '".$data_emision['fecha']."',
                                    '".$data_emision['hora']."',
                                    ".$data_emision['status'].",
                                    ".$data_emision['corporativo'].",
                                    ".$data_emision['agencia'].",
                                    ".$data_emision['vendedor'].",
                                    '".$data_emision['nombre_agencia']."',
                                    ".$data_emision['cantidad'].",
                                    '".$data_emision['comentarios']."');";
    $response = ejecuta_insert($db, $insert);

    if($response)
    {
        $condicion   = "emisiones.codigo = '".$data_emision['codigo']."'";
        $id_generado = campo_tabla_condicion_order_limit_error($db, 'id','emisiones',$condicion, '', 0, true);
        return $id_generado;
    }
    else
    {
        $response['resultado'] = array("mensaje_error"=>"No se ha podido crear la emisión bajo ese voucher corporativo");
        $response['cantidad']  = 0;
        $response['error']     = true;

        return $response;
    }
}

function asociar_beneficiarios_a_emision($db, $id_emision_generada, $id_grupal)
{
    $update =   "UPDATE continental.beneficiaries SET id_orden= 0, id_emision= $id_emision_generada WHERE id_orden = $id_grupal";
    $ejecuta = ejecuta_update($db, $update);

    if(pg_affected_rows($ejecuta) > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function insertar_historico_precompra($db, $data)
{
    $insert = "INSERT INTO continental.historico_precompra(orden, precompra, consumido, fecha, usuario, status) 
                VALUES (".$data['id_orden'].", ".$data['id_precompra'].", ".$data['total'].", NOW(), 1076, 1)";

    $response = ejecuta_insert($db, $insert);

    if($response)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function actualiza_monto_precompra($db, $id_precompra, $restante)
{
    $update =   "UPDATE continental.precompra SET precompra_restante= $restante WHERE precompra.id = $id_precompra";

    $ejecuta = ejecuta_update($db, $update);
    
    if($ejecuta)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function actualiza_categoria_plan_precompra($db, $id_orden, $id_plan, $id_categoria)
{
    $update =   "UPDATE continental.orders SET programaplan = $id_categoria, producto = $id_plan WHERE orders.id = $id_orden";

    $ejecuta = ejecuta_update($db, $update);

    if($ejecuta)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function anular_voucher($db, $id_grupal)
{
    $update =   "UPDATE continental.orders SET status= 4 WHERE id = $id_grupal";
    $ejecuta = ejecuta_update($db, $update);

    if(pg_affected_rows($ejecuta) > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function restar_dias($db, $cantidad_restar, $id_corporativo)
{
    if($cantidad_restar > 0){
        $update =   "UPDATE continental.orders SET cantidad = (SELECT CAST(cantidad AS INT) FROM continental.orders where id = $id_corporativo) - $cantidad_restar WHERE id = $id_corporativo";
        $ejecutar = ejecuta_update($db, $update);
    
        if(pg_affected_rows($ejecutar) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }else{
        return false;
    }
}

function buscar_overage($db, $id_plan)
{
    //$db        = new Mysqli_Manager();
    //$db->conn();
    $condicion = "id = ".$id_plan;
    $resultado = consulta_unica($db,'overage','plans',$condicion);

    return $resultado;
}

function valida_plan_familiar($db, $id_categoria, $beneficiarios, $auditoria)
{
    if($id_categoria == 23 || $id_categoria == 24)
    {
        $cantidad_menores = 0;
        $cantidad_adultos = 0;

        for($i=0;$i < count($beneficiarios); $i++)
        {
            $edad = (int) calcula_edad(formatea_fecha($beneficiarios[$i]->fechaNac,'-'));

            if($edad > 70)
            {
                $response["resultado"]  = 'LAS PERSONAS MAYORES A 70 AÑOS NO APLICAN PARA PLAN FAMILIAR';
                $response["cantidad"]                       = 0;
                $response["error"]                          = true;
                $auditoria['response'] = $response;
                inserta_auditoria($db, $auditoria);

                return $response;
            }
            else
            {
                if($edad > 23)
                {
                    $cantidad_adultos++;
                }
                else
                {
                    $cantidad_menores++;
                }
            }
        }

        if($cantidad_adultos == 2 && $cantidad_menores > 0 && $cantidad_menores <= 4)
        {
            return true;
        }
        else
        {
            $response["resultado"]  = 'NO CUMPLE CON LOS REQUISITOS MINIMOS PARA OPTAR A PLAN FAMILIAR';
            $response["cantidad"]                       = 0;
            $response["error"]                          = true;
            $auditoria['response'] = $response;
            inserta_auditoria($db, $auditoria);

            return $response;
        }
    }
    else
    {
        $response["resultado"]  = 'LA CATEGORIA SELECCIONADA NO APLICA PARA PLAN FAMILIAR';
        $response["cantidad"]                       = 0;
        $response["error"]                          = true;
        $auditoria['response'] = $response;

        return $response;
    }
}

function valida_edades_para_plan_familiar($edades)
{
    $familiar_valido = true;
    $cantidad_adultos = 0;
    $cantidad_menores = 0;

    foreach ($edades as $edad)
    {
        if($edad > 70)
        {
            $familiar_valido = false;
        }
        else
        {
            if($edad > 23)
            {
                $cantidad_adultos++;
            }
            else
            {
                $cantidad_menores++;
            }
        }
    }

    if($cantidad_adultos == 2 && $cantidad_menores > 0 && $cantidad_menores <= 4 && $familiar_valido == true)
    {
        return $familiar_valido;
    }
    else
    {
        return false;
    }
}

function consulta_tasa_de_cambio($db, $id_plan)
{
    $response = ejecuta_select($db,"SELECT moneda.id as id FROM continental.moneda, continental.plans WHERE plans.id = '$id_plan' AND moneda.simbolo = plans.moneda_pago");

    // print_r($response);exit;

    return $response['resultado'][0]['id'];
}

function valida_fecha_salida($desde)
{
    $hoy = date("Y-m-d");

    if($desde < $hoy)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function app_inserta_usuario($db, $usuario)
{
    $nombre   = $usuario['nombre'];
    $email    = $usuario['email'] ;
    $password = $usuario['password'];

    $insert   = "INSERT INTO continental.app_usuarios (id, nombre, email,password, status ) VALUES (NULL, '$nombre', '$email', '$password', 1 );";

    $response = ejecuta_insert($db, $insert);

    return $response;
}

function valida_cupon($db, $cupon, $id_broker)
{
    $hoy = date("Y-m-d");

    if($cupon != '')
    {
        $sql = "    SELECT  coupons.id,
                            coupons.codigo,
                            coupons.porcentaje 
                    FROM continental.coupons, continental.broker_coupons 
                    WHERE coupons.codigo = '$cupon' 
                    AND coupons.id_status = 1
                    AND broker_coupons.id_cupon = coupons.id
                    AND broker_coupons.id_broker = $id_broker
                    AND '$hoy' BETWEEN coupons.fecha_desde 
                    AND coupons.fecha_hasta
                    AND coupons.ussage > '0' ";
        $response = ejecuta_select($db, $sql);

        if($response['resultado'])
        {
            return $response['resultado'][0];
        }
        else
        {
            //inserta_auditoria($auditoria);
            return false;
        }
    }
    else
    {
        return false;
    }
}

function cupon_utilizado($db, $cupon){

    $codigo = $cupon['codigo'];

    $update =   "UPDATE  continental.coupons SET  ussage = ( ussage -1 ) WHERE codigo = '$codigo' ";

    if(ejecuta_update($db, $update))
    {
        return true;
    }
}

function requerido_error($mensaje_error)
{
    $response["resultado"][0]["mensaje_error"]  = $mensaje_error;
    $response["cantidad"]                       = 0;
    $response["error"]                          = true;
    
    return $response;
}

function calcula_monto_por_personas_con_cancelacion_multicausa($beneficiarios)
{
    $monto_cancelacion_multicausa = 0;

    for($contador = 0; $contador < count($beneficiarios); $contador++)
    {
        if(isset($beneficiarios[$contador]->cancelacion_precio))
        {
            if($beneficiarios[$contador]->cancelacion_precio > 0)
            {
                $monto_cancelacion_multicausa += $beneficiarios[$contador]->cancelacion_precio;
            }
        }
    }
    return $monto_cancelacion_multicausa;
}

function valida_voucher_activos_beneficiarios($db, $beneficiarios, $desde)
{
    for($contador = 0; $contador < count($beneficiarios); $contador++)
    {
        $nombre     = $beneficiarios[$contador]->nombre;
        $apellido   = $beneficiarios[$contador]->apellido;
        $fechaNac   = formatea_fecha($beneficiarios[$contador]->fechaNac,'-');

        $sql = " SELECT beneficiaries.id
                    FROM continental.beneficiaries, continental.orders
                    WHERE beneficiaries.id_orden = orders.id
                    AND '$desde'
                    BETWEEN orders.salida
                    AND orders.retorno
                    AND CONCAT( beneficiaries.nombre,' ', beneficiaries.apellido ) LIKE '%$nombre%$apellido%'
                    AND beneficiaries.nacimiento = '$fechaNac'
                    AND orders.status = 1 ";

        $response = ejecuta_select($db, $sql);

        if($response['cantidad']>0)
        {
            $response['resultado'] = array("mensaje_error"=>"UNO DE LOS BENEFICIARIOS YA CUENTA CON UN VOUCHER ACTIVO PARA LAS FECHAS SELECCIONADAS");
            $response['cantidad']  = 0;
            $response['error']     = true;
        }  
        
        return $response;
    }
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
// FUNCIONES NUEVO BACKEND
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function consulta_cantidad($db, $tabla, $condicion = null)
{
    $condicion  = ($condicion) ? ' WHERE '.$condicion : '';
    $select     = "SELECT count(*) as cantidad FROM $tabla $condicion";

    $consulta   = pg_query($db,$select);

    while ($row = pg_fetch_array($consulta, null, PGSQL_ASSOC)) {
        return $row['cantidad'];
    }
}

function flag($elemento, $print = false)
{
    if($print)
    {
        print_r($elemento);
        exit;
    }
}

function select_unico($db,$campo,$tabla,$condicion)
{
    $select    = "SELECT $campo FROM $tabla where $condicion";
    $consulta  = pg_query($db,$select);
    
    while ($row = pg_fetch_array($consulta, null, PGSQL_ASSOC)) {
        return  $row[$campo];
    }
}

function consulta_permisos_funciones_usuario($db, $tipo, $usuario, $nombreclave)
{
    $modulos    = ejecuta_select($db, "SELECT * FROM modulos WHERE nombreclave = '$nombreclave'");
    $modulos    = $modulos['resultado'];

    if($tipo == 'porEmpresas')
    {
        $tabla      = 'empresas';
        $join       = 'empresas.idempresa = permisos.idempresa';
        $where      = 'empresas.idempresa = '.$usuario['idempresa'];
    }
    else if($tipo == 'porPais')
    {
        $tabla      = 'paises';
        $join       = 'paises.idpais = permisos.idpais';
        $where      = 'paises.idpais = '.$usuario['idpais'];
    }
    else if($tipo == 'porSistemas')
    {
        $tabla      = 'sistemas';
        $join       = 'sistemas.idsistema = permisos.idsistema';
        $where      = 'sistemas.idsistema = '.$usuario['idsistema'];
    }
    else if($tipo == 'porAgencias')
    {
        $tabla      = 'agencias';
        $join       = 'agencias.idagencia = permisos.idagencia';
        $where      = 'agencias.idagencia = '.$usuario['idagencia'];
    }
    else if($tipo == 'porNiveles')
    {
        $tabla      = 'niveles';
        $join       = 'niveles.idnivel = permisos.idnivel';
        $where      = 'niveles.idnivel = '.$usuario['idnivel'];
    }
    else if($tipo == 'porTiposUsuario')
    {
        $tabla      = 'tiposusuario';
        $join       = 'tiposusuario.idtipousuario = permisos.idtipousuario';
        $where      = 'tiposusuario.idtipousuario = '.$usuario['idtipousuario'];
    }
    else if($tipo == 'porMixtos')
    {
        $tabla      = 'mixtos';
        $join       = 'mixtos.idmixto = permisos.idmixto';
        $where      = 'mixtos.idmixto = '.$usuario['idmixto'];
    }
    else if($tipo == 'porUsuarios')
    {
        $tabla      = 'usuarios';
        $join       = 'usuarios.idusuario = permisos.idusuario';
        $where      = 'usuarios.idusuario = '.$usuario['idusuario'];
    }

    foreach($modulos as $modulo)
    {
        $idmodulo       = $modulo['idmodulo'];
        $select_permiso = ejecuta_select($db, "SELECT coalesce(permisos.permiso, NULL) as permiso FROM $tabla LEFT JOIN permisos ON $join AND permisos.idmodulo = $idmodulo AND permisos.idfuncion is NULL WHERE $where ");

        $permisos[$modulo['nombreclave']]['nombreclave']        = $modulo['nombreclave'];
        $permisos[$modulo['nombreclave']]['permiso']            = $select_permiso['resultado'][0]['permiso'];

        $funciones = ejecuta_select($db, "SELECT * FROM funciones WHERE idmodulo = $idmodulo");
        $funciones = $funciones['resultado'];

        $permisos[$modulo['nombreclave']]['funciones'] = [];

        foreach($funciones as $funcion)
        {
            $idfuncion          = $funcion['idfuncion'];
            $select_permiso     = ejecuta_select($db, "SELECT coalesce(permisos.permiso, NULL) as permiso FROM $tabla LEFT JOIN permisos ON $join AND permisos.idmodulo = $idmodulo AND permisos.idfuncion = $idfuncion WHERE $where ");
            
            $permisos[$modulo['nombreclave']]['funciones'][$funcion['nombreclave']]['nombreclave']          = $funcion['nombreclave'];
            $permisos[$modulo['nombreclave']]['funciones'][$funcion['nombreclave']]['permiso']              = $select_permiso['resultado'][0]['permiso'];
        }
    }  

    return $permisos;
}

// function consulta_permisos_funciones_usuario($db, $tipo, $usuario, $print = false)
// {
//     $modulos    = ejecuta_select($db, "SELECT * FROM modulos");
//     $modulos    = $modulos['resultado'];

//     if($tipo == 'porEmpresas')
//     {
//         $tabla      = 'empresas';
//         $join       = 'empresas.idempresa = permisos.idempresa';
//         $where      = 'empresas.idempresa = '.$usuario['idempresa'];
//     }
//     else if($tipo == 'porPais')
//     {
//         $tabla      = 'paises';
//         $join       = 'paises.idpais = permisos.idpais';
//         $where      = 'paises.idpais = '.$usuario['idpais'];
//     }
//     else if($tipo == 'porSistemas')
//     {
//         $tabla      = 'sistemas';
//         $join       = 'sistemas.idsistema = permisos.idsistema';
//         $where      = 'sistemas.idsistema = '.$usuario['idsistema'];
//     }
//     else if($tipo == 'porAgencias')
//     {
//         $tabla      = 'agencias';
//         $join       = 'agencias.idagencia = permisos.idagencia';
//         $where      = 'agencias.idagencia = '.$usuario['idagencia'];
//     }
//     else if($tipo == 'porNiveles')
//     {
//         $tabla      = 'niveles';
//         $join       = 'niveles.idnivel = permisos.idnivel';
//         $where      = 'niveles.idnivel = '.$usuario['idnivel'];
//     }
//     else if($tipo == 'porTiposUsuario')
//     {
//         $tabla      = 'tiposusuario';
//         $join       = 'tiposusuario.idtipousuario = permisos.idtipousuario';
//         $where      = 'tiposusuario.idtipousuario = '.$usuario['idtipousuario'];
//     }
//     else if($tipo == 'porMixtos')
//     {
//         $tabla      = 'mixtos';
//         $join       = 'mixtos.idmixto = permisos.idmixto';
//         $where      = 'mixtos.idmixto = '.$usuario['idmixto'];
//     }
//     else if($tipo == 'porUsuarios')
//     {
//         $tabla      = 'usuarios';
//         $join       = 'usuarios.idusuario = permisos.idusuario';
//         $where      = 'usuarios.idusuario = '.$usuario['idusuario'];
//     }

//     foreach($modulos as $modulo)
//     {
//         $idmodulo       = $modulo['idmodulo'];
//         $select_permiso = ejecuta_select($db, "SELECT coalesce(permisos.permiso, NULL) as permiso FROM $tabla LEFT JOIN permisos ON $join AND permisos.idmodulo = $idmodulo AND permisos.idfuncion is NULL WHERE $where ");

//         $permisos[$modulo['nombreclave']]['idmodulo']           = $modulo['idmodulo'];
//         $permisos[$modulo['nombreclave']]['nombremodulo']       = $modulo['nombremodulo'];
//         $permisos[$modulo['nombreclave']]['nombreclave']        = $modulo['nombreclave'];
//         $permisos[$modulo['nombreclave']]['descripcionmodulo']  = $modulo['descripcionmodulo'];
//         $permisos[$modulo['nombreclave']]['iconomodulo']        = $modulo['iconomodulo'];
//         $permisos[$modulo['nombreclave']]['mostrarenmenu']      = ($modulo['mostrarenmenu'] == 't') ? true : false ;
//         $permisos[$modulo['nombreclave']]['permiso']            = $select_permiso['resultado'][0]['permiso'];

//         $funciones = ejecuta_select($db, "SELECT * FROM funciones WHERE idmodulo = $idmodulo");
//         $funciones = $funciones['resultado'];

//         $permisos[$modulo['nombreclave']]['funciones'] = [];

//         foreach($funciones as $funcion)
//         {
//             $idfuncion    = $funcion['idfuncion'];
//             $select_permiso     = ejecuta_select($db, "SELECT coalesce(permisos.permiso, NULL) as permiso FROM $tabla LEFT JOIN permisos ON $join AND permisos.idmodulo = $idmodulo AND permisos.idfuncion = $idfuncion WHERE $where ");
            
//             $permisos[$modulo['nombreclave']]['funciones'][$funcion['nombreclave']]['idfuncion']            = $funcion['idfuncion'];
//             $permisos[$modulo['nombreclave']]['funciones'][$funcion['nombreclave']]['nombrefuncion']        = $funcion['nombrefuncion'];
//             $permisos[$modulo['nombreclave']]['funciones'][$funcion['nombreclave']]['nombreclave']          = $funcion['nombreclave'];
//             $permisos[$modulo['nombreclave']]['funciones'][$funcion['nombreclave']]['descripcionfuncion']   = $funcion['descripcionfuncion'];
//             $permisos[$modulo['nombreclave']]['funciones'][$funcion['nombreclave']]['permiso']              = $select_permiso['resultado'][0]['permiso'];
//         }
//     }  

//     return $permisos;
// }

// function consulta_permisos($db, $usuario, $print = false)
// {
//     $idempresa      = $usuario['idempresa'];
//     $idpais         = $usuario['idpais'];
//     $idsistema      = $usuario['idsistema'];
//     $idagencia      = $usuario['idagencia'];
//     $idnivel        = $usuario['idnivel'];
//     $idtipousuario  = $usuario['idtipousuario'];
//     $idmixto        = $usuario['idmixto'];
//     $idusuario      = $usuario['idusuario'];

//     $permisos['permisos_empresa']      = consulta_permisos_funciones_usuario($db, 'porEmpresas', $usuario, $print);
//     $permisos['permisos_pais']         = consulta_permisos_funciones_usuario($db, 'porPais', $usuario, $print);
//     $permisos['permisos_sistema']      = consulta_permisos_funciones_usuario($db, 'porSistemas', $usuario, $print);
//     $permisos['permisos_agencia']      = consulta_permisos_funciones_usuario($db, 'porAgencias', $usuario, $print);
//     $permisos['permisos_nivel']        = consulta_permisos_funciones_usuario($db, 'porNiveles', $usuario, $print);
//     $permisos['permisos_tipousuario']  = consulta_permisos_funciones_usuario($db, 'porTiposUsuario', $usuario, $print);
//     $permisos['permisos_mixto']        = consulta_permisos_funciones_usuario($db, 'porMixtos', $usuario, $print);
//     $permisos['permisos_usuario']      = consulta_permisos_funciones_usuario($db, 'porUsuarios', $usuario, $print);



//     $usuario['permisos'] = [];
//     $usuario['permisos'] = $permisos['permisos_empresa'];
//     $usuario['permisos'] = jerarquiza_permisos($permisos['permisos_pais'], $usuario['permisos']);
//     $usuario['permisos'] = jerarquiza_permisos($permisos['permisos_sistema'], $usuario['permisos']);
//     $usuario['permisos'] = jerarquiza_permisos($permisos['permisos_agencia'], $usuario['permisos']);
//     $usuario['permisos'] = jerarquiza_permisos($permisos['permisos_nivel'], $usuario['permisos']);
//     $usuario['permisos'] = jerarquiza_permisos($permisos['permisos_tipousuario'], $usuario['permisos']);
//     $usuario['permisos'] = jerarquiza_permisos($permisos['permisos_mixto'], $usuario['permisos']);
//     $usuario['permisos'] = jerarquiza_permisos($permisos['permisos_usuario'], $usuario['permisos']);

//     foreach($usuario['permisos'] as $modulo)
//     {
//         if($modulo['permiso'] != 't')
//         {
//             unset($usuario['permisos'][$modulo['nombreclave']]);
//         }

//         foreach($modulo['funciones'] as $funcion)
//         {
//             if($funcion['permiso'] != 't')
//             {
//                 unset($usuario['permisos'][$modulo['nombreclave']]['funciones'][$funcion['nombreclave']]);
//             }
//         }
//     } 

//     return $usuario;
// }

function consulta_permisos_modulo($db, $usuario, $nombreclave)
{
    $idempresa      = $usuario['idempresa'];
    $idpais         = $usuario['idpais'];
    $idsistema      = $usuario['idsistema'];
    $idagencia      = $usuario['idagencia'];
    $idnivel        = $usuario['idnivel'];
    $idtipousuario  = $usuario['idtipousuario'];
    $idmixto        = $usuario['idmixto'];
    $idusuario      = $usuario['idusuario'];

    $permisos['permisos_empresa']      = consulta_permisos_funciones_usuario($db, 'porEmpresas', $usuario, $nombreclave);
    $permisos['permisos_pais']         = consulta_permisos_funciones_usuario($db, 'porPais', $usuario, $nombreclave);
    $permisos['permisos_sistema']      = consulta_permisos_funciones_usuario($db, 'porSistemas', $usuario, $nombreclave);
    $permisos['permisos_agencia']      = consulta_permisos_funciones_usuario($db, 'porAgencias', $usuario, $nombreclave);
    $permisos['permisos_nivel']        = consulta_permisos_funciones_usuario($db, 'porNiveles', $usuario, $nombreclave);
    $permisos['permisos_tipousuario']  = consulta_permisos_funciones_usuario($db, 'porTiposUsuario', $usuario, $nombreclave);
    $permisos['permisos_mixto']        = consulta_permisos_funciones_usuario($db, 'porMixtos', $usuario, $nombreclave);
    $permisos['permisos_usuario']      = consulta_permisos_funciones_usuario($db, 'porUsuarios', $usuario, $nombreclave);

    $usuario['permisos'] = [];
    $usuario['permisos'] = $permisos['permisos_empresa'];
    $usuario['permisos'] = jerarquiza_permisos($permisos['permisos_pais'], $usuario['permisos'], $nombreclave);
    $usuario['permisos'] = jerarquiza_permisos($permisos['permisos_sistema'], $usuario['permisos'], $nombreclave);
    $usuario['permisos'] = jerarquiza_permisos($permisos['permisos_agencia'], $usuario['permisos'], $nombreclave);
    $usuario['permisos'] = jerarquiza_permisos($permisos['permisos_nivel'], $usuario['permisos'], $nombreclave);
    $usuario['permisos'] = jerarquiza_permisos($permisos['permisos_tipousuario'], $usuario['permisos'], $nombreclave);
    $usuario['permisos'] = jerarquiza_permisos($permisos['permisos_mixto'], $usuario['permisos'], $nombreclave);
    $usuario['permisos'] = jerarquiza_permisos($permisos['permisos_usuario'], $usuario['permisos'], $nombreclave);

    foreach($usuario['permisos'] as $modulo)
    {
        if($modulo['permiso'] != 't')
        {
            unset($usuario['permisos'][$modulo['nombreclave']]);
        }

        foreach($modulo['funciones'] as $funcion)
        {
            if($funcion['permiso'] != 't')
            {
                unset($usuario['permisos'][$nombreclave]['funciones'][$funcion['nombreclave']]);
            }

            unset($usuario['permisos'][$nombreclave]['funciones'][$funcion['nombreclave']]['nombreclave']);
            unset($usuario['permisos'][$nombreclave]['funciones'][$funcion['nombreclave']]['permiso']);
        }
    } 

    unset($usuario['permisos'][$nombreclave]['nombreclave']);
    unset($usuario['permisos'][$nombreclave]['permiso']);

    return $usuario;
}


function jerarquiza_permisos($modulos, $usuario, $nombreclave)
{
    foreach($modulos as $modulo)
    {
        if(!is_null($modulo['permiso']))
        {
            $usuario[$nombreclave]['permiso'] = $modulo['permiso'];
        }

        foreach($modulo['funciones'] as $funcion)
        {
            if(!is_null($funcion['permiso']))
            {
                $usuario[$nombreclave]['funciones'][$funcion['nombreclave']]['permiso'] = $funcion['permiso'];
            }

        }
    } 

    return $usuario;
}

// function jerarquiza_permisos($modulos, $usuario)
// {
//     foreach($modulos as $modulo)
//     {
//         if(!is_null($modulo['permiso']))
//         {
//             $usuario[$modulo['nombreclave']]['permiso'] = $modulo['permiso'];
//         }

//         foreach($modulo['funciones'] as $funcion)
//         {
//             if(!is_null($funcion['permiso']))
//             {
//                 $usuario[$modulo['nombreclave']]['funciones'][$funcion['nombreclave']]['permiso'] = $funcion['permiso'];
//             }

//         }
//     } 

//     return $usuario;
// }

function auditar($db, $auditoria)
{
    $idusuario          = $auditoria['idusuario'];
    $modulo             = $auditoria['modulo'];
    $accion             = $auditoria['accion'];
    $objetocambio       = ($auditoria['objetocambio']) ? $auditoria['objetocambio'] : '' ;
    $datosanteriores    = $auditoria['datosanteriores'];
    $datosnuevos        = $auditoria['datosnuevos'];
    
    $sql = "INSERT INTO auditorias ( idusuario, modulo, accion, datosanteriores, datosnuevos, fecha, objetocambio ) VALUES ( $idusuario, '$modulo', '$accion', '$datosanteriores', '$datosnuevos', NOW(), '$objetocambio')";
    
    ejecuta_insert($db, $sql);
    
    return true;
}

function inserta_log_servicios($db, $servicio, $log)
{
    ejecuta_insert($db, "INSERT INTO logs ( fecha, servicio, log ) VALUES ( NOW(), '$servicio', '$log')");
    
    return true;
}

function auditar_array($db, $auditorias)
{
    foreach($auditorias as $auditoria)
    {
        $idusuario          = $auditoria['idusuario'];
        $modulo             = $auditoria['modulo'];
        $accion             = $auditoria['accion'];
        $objetocambio       = ($auditoria['objetocambio']) ? $auditoria['objetocambio'] : '';
        $datosanteriores    = ($auditoria['datosanteriores']) ? $auditoria['datosanteriores'] : 'f';
        $datosnuevos        = ($auditoria['datosnuevos']) ? $auditoria['datosnuevos'] : 'f';

        $sql = "INSERT INTO auditorias ( idusuario, modulo, accion, datosanteriores, datosnuevos, fecha, objetocambio ) VALUES ( $idusuario, '$modulo', '$accion', '$datosanteriores', '$datosnuevos', NOW(), '$objetocambio')";
        
        ejecuta_insert($db, $sql);
    }
    return true;
}



function select_sistemas($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT 
                    sistemas.*,
                    status.nombrestatus
                FROM sistemas, status
                WHERE sistemas.idstatus = status.idstatus
                $busqueda
                $paginacion
                ";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "sistemas");
        }
    }

    // ASIGNA CONFIGURACIONES
    if($include_conf)
    {
        $contador = 0;
        foreach($result['resultado'] as $registro)
        {
            $idregistro     = $registro['idsistema'];
            $modulos        = ejecuta_select($db, "SELECT idmodulo FROM modulos WHERE idsistema = $idregistro");

            $result['resultado'][$contador]['configuracionmodulos']  = ($modulos['cantidad'] == 0) ? 'f' : 't'; 
            
            $contador++;
        }
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_sistema($db, $idsistema)
{
    $result = ejecuta_select($db, "SELECT 
                                        sistemas.*
                                    FROM sistemas
                                    WHERE sistemas.idsistema = $idsistema ");

    $contador = 0;
    foreach($result['resultado'] as $registro)
    {
        $idsistema          = $registro['idsistema'];
        $modulosasignados   = [];

        //MODULOS
            $modulos = ejecuta_select($db, "SELECT idmodulo FROM modulos WHERE idsistema = $idsistema ");
            foreach($modulos['resultado'] as $modulo) array_push($modulosasignados, $modulo['idmodulo']);
            $result['resultado'][$contador]['modulosasignados'] = $modulosasignados;
        
        $contador++;
    }

    return $result;
}

function select_modulo($db, $idmodulo)
{
    $result = ejecuta_select($db, "SELECT 
                                        modulos.*,
                                        empresas.idempresa
                                    FROM  modulos
                                    left join sistemas on modulos.idsistema = sistemas.idsistema 
                                    left join empresas on sistemas.idempresa = empresas.idempresa
                                    join status on modulos.idstatus = status.idstatus
                                    where modulos.idmodulo = $idmodulo 
                                    ");

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();
    
    return $result;
}



function select_modulos($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        // $sql = "SELECT 
        //             modulos.idmodulo,
        //             modulos.nombremodulo,
        //             modulos.nombreclave,
        //             modulos.descripcionmodulo,
        //             empresas.idempresa,
        //             empresas.nombreempresa,
        //             sistemas.idsistema,
        //             sistemas.nombresistema,
        //             modulos.orden,
        //             modulos.idmodulopadre,
        //             modulos.iconomodulo,
        //             modulos.ruta,
        //             modulos.mostrarenmenu,
        //             modulos.fechacreacion,
        //             status.nombrestatus
        //         FROM modulos, empresas, sistemas, status
        //         WHERE modulos.idsistema = sistemas.idsistema
        //         AND sistemas.idempresa = empresas.idempresa
        //         AND modulos.idstatus = status.idstatus
        //         $busqueda
        //         ORDER BY modulos.orden ASC
        //         $paginacion
        //         ;";

        $sql = "SELECT 
                    modulos.idmodulo,
                    modulos.nombremodulo,
                    modulos.nombreclave,
                    modulos.descripcionmodulo,
                    sistemas.idsistema,
                    sistemas.nombresistema,
                    modulos.orden,
                    modulos.idmodulopadre,
                    modulos.iconomodulo,
                    modulos.ruta,
                    modulos.mostrarenmenu,
                    modulos.fechacreacion,
                    status.nombrestatus
                FROM  modulos
                left join sistemas on modulos.idsistema = sistemas.idsistema 
                join status on modulos.idstatus = status.idstatus  
                WHERE 1 = 1
                $busqueda	
                ORDER BY modulos.idmodulo ASC
                $paginacion;";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "modulos");
        }
    }

    // ASIGNA CONFIGURACIONES
        if($include_conf)
        {

        }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_menu_modulos($db, $paginador, $include_conf = true)
{
    $idsistema = 1;

    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT 
                    modulos.idmodulo,
                    modulos.nombremodulo,
                    modulos.nombreclave,
                    modulos.descripcionmodulo,
                    modulos.orden,
                    modulos.iconomodulo,
                    modulos.ruta                
                   
                FROM modulos, empresas, sistemas, status
                WHERE modulos.idsistema = sistemas.idsistema
                AND modulos.mostrarenmenu = 't'
                AND sistemas.idempresa = empresas.idempresa
                AND modulos.idstatus = status.idstatus
                AND modulos.idsistema = $idsistema
                AND modulos.idstatus = 1
                $busqueda
                ORDER BY modulos.orden ASC
                $paginacion
                ;";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "modulos");
        }
    }


    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_agencia($db, $idagencia)
{
    $result = ejecuta_select($db, "SELECT 
                                        agencias.*,
                                        empresas.idempresa,
                                        empresas.nombreempresa,
                                        sistemas.nombresistema,
                                        paises.nombrepais,
                                        paises.bandera,
                                        niveles.nombrenivel,
                                        CONCAT(usuarios.nombreusuario,' ',usuarios.apellidousuario) as nombreagente,
                                        status.nombrestatus
                                    from empresas, sistemas, paises, niveles, agencias
                                    left join usuarios on agencias.idagente = usuarios.idusuario 
                                    left join status on agencias.idstatus = status.idstatus 
                                    where sistemas.idempresa = empresas.idempresa
                                    and agencias.idsistema = sistemas.idsistema
                                    and agencias.idpais = paises.idpais
                                    and agencias.idnivel = niveles.idnivel
                                    and agencias.idagencia = $idagencia
                                    order by agencias.idagencia DESC 
                                    ;");
    $contador_agencia = 0;

    foreach($result['resultado'] as $agencia)
    {
        $idagencia = $agencia['idagencia'];

        $categorias = ejecuta_select($db, "SELECT categoriasagencias.idcategoria
                                            FROM categoriasagencias
                                            WHERE categoriasagencias.idagencia = $idagencia
                                            ;");
        $categoriasasignadas    = [];

        foreach($categorias['resultado'] as $categoria)
        {
            array_push($categoriasasignadas, $categoria['idcategoria']);
        }
        
        $planes = ejecuta_select($db, "SELECT planesagencias.idplan
                                        FROM planesagencias
                                        WHERE planesagencias.idagencia = $idagencia
                                        ;");

        $planesasignados        = [];

        foreach($planes['resultado'] as $plan)
        {
            array_push($planesasignados, $plan['idplan']);
        }

        $comisionescategorias = ejecuta_select($db, "SELECT     comisionesagencias.idcategoria,
                                                                comisionesagencias.comision,
                                                                categorias.nombrecategoria
                                                    FROM comisionesagencias, categorias
                                                    WHERE comisionesagencias.idagencia = $idagencia 
                                                    AND comisionesagencias.idplan IS NULL
                                                    AND comisionesagencias.idcategoria = categorias.idcategoria
                                                    ;");

        $comisionesplanes = ejecuta_select($db, "SELECT     comisionesagencias.idcategoria,
                                                            comisionesagencias.idplan,
                                                            comisionesagencias.comision,
                                                            planes.nombreplan
                                                    FROM comisionesagencias, planes
                                                    WHERE comisionesagencias.idagencia = $idagencia 
                                                    AND comisionesagencias.idplan IS NOT NULL
                                                    AND comisionesagencias.idplan = planes.idplan
                                                    ;");


        $comisionesasignadas = [];

        foreach($comisionescategorias['resultado'] as $comisioncategoria)
        {
            $comisioncategoria['planes'] = [];
            
            foreach($comisionesplanes['resultado'] as $comisionplanes)
            {
                if($comisionplanes['idcategoria'] == $comisioncategoria['idcategoria'])
                {
                    $arreglo = array("idplan" => $comisionplanes['idplan'], "nombreplan" =>  $comisionplanes['nombreplan'], "comision" => $comisionplanes['comision']);
                    array_push($comisioncategoria['planes'], $arreglo);
                }
            }
            array_push($comisionesasignadas, $comisioncategoria);
        }

        $result['resultado'][$contador_agencia]['planesasignados']        = $planesasignados;
        $result['resultado'][$contador_agencia]['categoriasasignadas']    = $categoriasasignadas;
        $result['resultado'][$contador_agencia]['comisionesasignadas']    = $comisionesasignadas;

        $contador_agencia++;
    }

    return $result;
}

function armar_condiciones($data, $filtros)
{
    $busqueda = '';

    if(isset($data->busqueda))
    {
        if(count($data->busqueda) > 0)
        {
            $busqueda = armar_busqueda($data, $filtros);
        }
    }

    $condiciones = array(
        "paginadorlimite"    => $data->paginadorlimite ? $data->paginadorlimite : 0,
        "paginadorinicio"    => $data->paginadorinicio ? $data->paginadorinicio : 0,
        "busqueda"           => $busqueda   
    );

    return $condiciones;
}

function armar_busqueda($data, $filtros)
{
    $busqueda = 'AND';

    while ($tipo_dato = current($filtros)) 
    {
        $campo = key($filtros);

        if(isset($data->busqueda->$campo))
        {
            $tipodatos          = gettype($data->busqueda->$campo);
            $tabla              = $filtros[$campo]['tabla'];
            $tipobusqueda       = $filtros[$campo]['tipobusqueda'];
            $datos              = $data->busqueda->$campo;

            if($tipobusqueda == 'fechabetween')
            {
                $campoid            = $filtros[$campo]['campoid'];
                $fechadesde         = $data->busqueda->fechadesde;
                $fechahasta         = $data->busqueda->fechahasta;
                $busqueda = $busqueda." $campoid BETWEEN '$fechadesde 00:00:00' AND '$fechahasta 23:59:59' AND";
            }
            else if($tipobusqueda == 'relacional')
            {
                $tabla_relacional   = $filtros[$campo]['tabla_relacional'];
                $campoid            = $filtros[$campo]['campoid'];
                $busqueda           = $busqueda." $tabla.$campoid IN (SELECT $tabla_relacional.$campoid FROM $tabla_relacional WHERE $tabla_relacional.$campo = $datos ) AND";
            }
            else if($tipodatos == 'integer')
            {
                $busqueda = $busqueda." $tabla.$campo = $datos AND";
            }
            else if($tipodatos == 'string')
            {
                $busqueda = $busqueda." UPPER($tabla.$campo) LIKE UPPER('%".$datos."%') AND";
            }
        }

        next($filtros);
    }

    $busqueda = substr($busqueda, 0, -3); 

    return $busqueda;
}

function select_usuarios($db, $paginador = null)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';
        
        $sql = "SELECT 
            usuarios.*,
            agencias.nombreagencia,
            tiposusuario.descripcion,
            status.nombrestatus
            FROM agencias,tiposusuario,usuarios
            LEFT JOIN status on usuarios.idstatus = status.idstatus 
            WHERE agencias.idagencia = usuarios.idagencia
            AND  tiposusuario.idtipousuario = usuarios.idtipousuario
            $busqueda
            order by usuarios.idusuario DESC
            $paginacion
            ;";
        
        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "usuarios");
        }
    }


    if($result['resultado'] == null) $result['resultado'] = array();

    return $result;
}

function select_agencias($db, $paginador = null, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';
        
        $sql = "SELECT 
                agencias.idagencia,
                UPPER(agencias.nombreagencia) as nombreagencia,
                agencias.idpais,
                agencias.idnivel,
                agencias.idstatus,
                agencias.idsistema,
                empresas.nombreempresa,
                sistemas.nombresistema,
                paises.nombrepais,
                paises.bandera,
                niveles.nombrenivel,
                status.nombrestatus
            from empresas, sistemas, paises, niveles, agencias
            left join status on agencias.idstatus = status.idstatus 
            where sistemas.idempresa = empresas.idempresa
            and agencias.idsistema = sistemas.idsistema
            and agencias.idpais = paises.idpais
            and agencias.idnivel = niveles.idnivel
            $busqueda
            order by agencias.idagencia DESC
            $paginacion
            ;";
        
        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "agencias");
        }
    }


    // ASIGNA CONFIGURACIONES
        if($include_conf)
        {
            $contador = 0;
            foreach($result['resultado'] as $registro)
            {
                $idregistro     = $registro['idagencia'];
                $categorias     = ejecuta_select($db, "SELECT idcategoria FROM categoriasagencias WHERE idagencia = $idregistro");
                $planes         = ejecuta_select($db, "SELECT idplan FROM planesagencias WHERE idagencia = $idregistro");
                $comisiones     = ejecuta_select($db, "SELECT idcomisiones FROM comisionesagencias WHERE idagencia = $idregistro");
                $usuarios       = ejecuta_select($db, "SELECT idusuario FROM usuarios WHERE idagencia = $idregistro");
    
                $result['resultado'][$contador]['configuracioncategorias']  = ($categorias['cantidad'] == 0) ? 'f' : 't'; 
                $result['resultado'][$contador]['configuracionplanes']      = ($planes['cantidad'] == 0) ? 'f' : 't'; 
                $result['resultado'][$contador]['configuracioncomisiones']  = ($comisiones['cantidad'] == 0) ? 'f' : 't'; 
                $result['resultado'][$contador]['configuracionusuarios']    = ($usuarios['cantidad'] == 0) ? 'f' : 't'; 
                
                $contador++;
            }
        }

    if($result['resultado'] == null) $result['resultado'] = array();

    return $result;
}



function selectAgenciaUsusarios($db, $idagencia)
{
    $result = ejecuta_select($db, "SELECT 
                                        usuarios.idusuario,
                                        UPPER(TRIM(usuarios.nombreusuario)) as nombreusuario,
                                        UPPER(TRIM(usuarios.apellidousuario)) as apellidousuario,
                                        CONCAT(UPPER(TRIM(usuarios.nombreusuario)),', ',UPPER(TRIM(usuarios.apellidousuario))) as nombrecompletousuario,
                                        status.nombrestatus,
                                        tiposusuario.descripcion as nombretipousuario
                                    FROM 
                                        usuarios,
                                        status,
                                        tiposusuario
                                    WHERE usuarios.idagencia = $idagencia
                                    AND usuarios.idstatus = status.idstatus
                                    AND usuarios.idtipousuario = tiposusuario.idtipousuario
                                    ORDER BY nombrecompletousuario ASC, usuarios.idusuario ASC");

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();
    
    return $result;
}

function select_usuario($db, $idusuario)
{
    $result = ejecuta_select($db, "SELECT *
                                    from usuarios
                                    WHERE usuarios.idusuario = $idusuario ");
                                    
    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_paises($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT 
                    paises.idpais ,
                    paises.nombrepais ,
                    paises.nombrepaisen ,
                    paises.nombrepaispt ,
                    paises.idstatus ,
                    paises.codigopais ,
                    paises.bandera ,
                    paises.idmoneda ,
                    paises.ididioma ,
                    paises.essede ,
                    paises.origenpermitido ,
                    paises.destinopermitido ,
                    status.nombrestatus
                FROM paises, status
                WHERE paises.idstatus = status.idstatus
                $busqueda
                ORDER BY idpais
                $paginacion
                ";
        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "paises");
        }
    }

    $contador = 0;
    foreach($result['resultado'] as $pais)
    {
        $idpais              = $pais['idpais'];
        $categoriasasignadas = [];

        $categorias = ejecuta_select($db, "SELECT categoriaspaises.idcategoria
                                            from categoriaspaises, categorias, status
                                            where categoriaspaises.idpais = $idpais
                                            and categorias.idcategoria = categoriaspaises.idcategoria
                                            and categorias.idstatus = status.idstatus
                                            and categorias.idstatus = 1
                                            order by categoriaspaises.idcategoria;");

        $result['resultado'][$contador]['configuracioncategorias'] = ($categorias['cantidad'] > 0) ? 't' : 'f';

        $contador++;
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_paises_sedes($db)
{
    $paises = ejecuta_select($db, "SELECT 
                                        paises.idpais,
                                        initcap(paises.nombrepais) as nombrepais,
                                        paises.idstatus,
                                        status.nombrestatus
                                    FROM paises, status
                                    WHERE paises.idstatus = status.idstatus
                                    AND paises.essede = true
                                    ORDER BY idpais");

    $contador_pais = 0;
    
    foreach($paises['resultado'] as $pais)
    {
        $idpais = $pais['idpais'];
        $categoriasasignadas = [];

        $categorias = ejecuta_select($db, "SELECT categoriaspaises.idcategoria
                                            from categoriaspaises, categorias, status
                                            where categoriaspaises.idpais = $idpais
                                            and categorias.idcategoria = categoriaspaises.idcategoria
                                            and categorias.idstatus = status.idstatus
                                            and status.idstatus = 1
                                            order by categoriaspaises.idcategoria;");

        foreach($categorias['resultado'] as $categoria)
        {
            array_push($categoriasasignadas, $categoria['idcategoria']);
        }

        $paises['resultado'][$contador_pais]['categoriasasignadas'] = $categoriasasignadas;

        $contador_pais++;
    }

    return $paises;
}

function select_pais($db, $idpais)
{
    $result = ejecuta_select($db, "SELECT *
                                    FROM paises
                                    WHERE paises.idpais = $idpais ");

    $id = 0;

    foreach($result['resultado'] as $pais)
    {
        $idpais                = $pais['idpais'];
        $categoriasasignadas   = [];
    
        //CATEGORIAS
            $categorias = ejecuta_select($db, "SELECT categoriaspaises.idcategoria FROM categoriaspaises WHERE categoriaspaises.idpais = $idpais ");
            foreach($categorias['resultado'] as $categoria) array_push($categoriasasignadas, $categoria['idcategoria']);
        
        $result['resultado'][$id]['categoriasasignadas'] = $categoriasasignadas;
        
        $id++;
    }

    return $result;
}

function select_condicion_general($db, $idcondiciongeneral)
{
    $result = ejecuta_select($db, "SELECT *
                                    FROM condicionesgenerales
                                    WHERE condicionesgenerales.idcondiciongeneral = $idcondiciongeneral ");

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_condiciones_generales($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT  condicionesgenerales.idcondiciongeneral,
                        condicionesgenerales.nombrecondiciongeneral,
                        condicionesgenerales.idstatus,
                        condicionesgenerales.fechamodificacion,
                        status.nombrestatus
                    FROM condicionesgenerales, status
                    WHERE condicionesgenerales.idstatus = status.idstatus
                    $busqueda
                    ORDER BY idcondiciongeneral
                    $paginacion
                    ;";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "condicionesgenerales");
        }
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();
    
    return $result;
}

function select_empresa($db, $idempresa)
{
    $result = ejecuta_select($db, "SELECT *
                                    FROM empresas
                                    WHERE empresas.idempresa = $idempresa ");

    $contador = 0;
    foreach($result['resultado'] as $registro)
    {
        $idempresa          = $registro['idempresa'];
        $sistemasasignados  = [];
    
        //SISTEMAS
            $sistemas = ejecuta_select($db, "SELECT idsistema FROM sistemas WHERE idempresa = $idempresa AND idstatus = 1 ");
            foreach($sistemas['resultado'] as $sistema) array_push($sistemasasignados, $sistema['idsistema']);
            $result['resultado'][$contador]['sistemasasignados'] = $sistemasasignados;
        
        $contador++;
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_proveedores($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT 
                    proveedores.idproveedor,
                    proveedores.nombreproveedor,
                    proveedores.idstatus,
                    status.nombrestatus
                FROM proveedores, status
                WHERE proveedores.idstatus = status.idstatus
                $busqueda
                ORDER BY idproveedor
                $paginacion
                ;";
        
        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "proveedores");
        }
    }

    // ASIGNA CONFIGURACIONES
        if($include_conf)
        {
            // $contador = 0;
            // foreach($result['resultado'] as $registro)
            // {
            //     $idregistro     = $registro['idproveedor'];
            //     $sistemas         = ejecuta_select($db, "SELECT * FROM sistemas WHERE idproveedor = $idregistro AND idstatus = 1 ");
            //     $result['resultado'][$contador]['configuracionsistemas'] = ($sistemas['cantidad'] == 0) ? 'f' : 't'; 
            //     $contador++;
            // }
        }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();
    
    return $result;
}

function select_proveedor($db, $idproveedor)
{
    $result = ejecuta_select($db, "SELECT *
                                    FROM proveedores
                                    WHERE proveedores.idproveedor = $idproveedor ");

    // $contador = 0;
    // foreach($result['resultado'] as $registro)
    // {
    //     $idproveedor          = $registro['idproveedor'];
    //     $sistemasasignados  = [];
    
    //     //SISTEMAS
    //         $sistemas = ejecuta_select($db, "SELECT idsistema FROM sistemas WHERE idproveedor = $idproveedor AND idstatus = 1 ");
    //         foreach($sistemas['resultado'] as $sistema) array_push($sistemasasignados, $sistema['idsistema']);
    //         $result['resultado'][$contador]['sistemasasignados'] = $sistemasasignados;
        
    //     $contador++;
    // }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_empresas($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT  empresas.idempresa,
                        empresas.nombreempresa,
                        empresas.idstatus,
                        status.nombrestatus
                    FROM empresas, status
                    WHERE empresas.idstatus = status.idstatus
                    $busqueda
                    ORDER BY idempresa
                    $paginacion
                    ;";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "empresas");
        }
    }

    // ASIGNA CONFIGURACIONES
        if($include_conf)
        {
            $contador = 0;
            foreach($result['resultado'] as $registro)
            {
                $idregistro     = $registro['idempresa'];
                $sistemas         = ejecuta_select($db, "SELECT * FROM sistemas WHERE idempresa = $idregistro AND idstatus = 1 ");
                $result['resultado'][$contador]['configuracionsistemas'] = ($sistemas['cantidad'] == 0) ? 'f' : 't'; 
                $contador++;
            }
        }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();
    
    return $result;
}

function select_tasacambio($db, $idtasacambio)
{
    $result = ejecuta_select($db, "SELECT  tasascambios.idtasacambio,
                                            tasascambios.valor,
                                            tasascambios.fechainsertado,
                                            tasascambios.idmoneda,
                                            monedas.codigo as moneda,
                                            tasascambios.idtipotasa,
                                            tipostasas.nombretipotasa,
                                            tasascambios.idagencia,
                                            agencias.nombreagencia,
                                            tasascambios.idusuario,
                                            CONCAT(usuarios.nombreusuario,' ',usuarios.apellidousuario) as nombreusuario
                                        FROM  monedas, tipostasas, tasascambios
                                        LEFT JOIN agencias on tasascambios.idagencia = agencias.idagencia
                                        LEFT JOIN usuarios on tasascambios.idusuario = usuarios.idusuario
                                        WHERE tasascambios.idmoneda = monedas.idmoneda
                                        AND tasascambios.idtipotasa = tipostasas.idtipotasa
                                        AND tasascambios.idtasacambio = $idtasacambio 
                                    ");

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_tasascambios($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT  tasascambios.idtasacambio,
                    tasascambios.valor,
                    tasascambios.fechainsertado,
                    tasascambios.fechabanco,
                    tasascambios.idmoneda,
                    monedas.codigo as moneda,
                    tasascambios.idtipotasa,
                    tipostasas.nombretipotasa,
                    tasascambios.idagencia,
                    agencias.nombreagencia,
                    tasascambios.idusuario,
                    CONCAT(usuarios.nombreusuario,' ',usuarios.apellidousuario) as nombreusuario
                FROM  monedas, tipostasas, tasascambios
                LEFT JOIN agencias on tasascambios.idagencia = agencias.idagencia
                LEFT JOIN usuarios on tasascambios.idusuario = usuarios.idusuario
                WHERE tasascambios.idmoneda = monedas.idmoneda
                AND tasascambios.idtipotasa = tipostasas.idtipotasa
                $busqueda
                ORDER BY fechainsertado DESC
                $paginacion
                ";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "tasascambios");
        }
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();
    
    return $result;
}

function select_tiposasistencias($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT 
                    tiposasistencias.idtipoasistencia,
                    tiposasistencias.nombretipoasistencia,
                    tiposasistencias.idstatus,
                    status.nombrestatus
                FROM tiposasistencias, status
                WHERE tiposasistencias.idstatus = status.idstatus
                $busqueda
                ORDER BY idtipoasistencia
                $paginacion
                ;";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "tiposasistencias");
        }
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_tipoasistencia($db, $idtipoasistencia)
{
    $result = ejecuta_select($db, "SELECT *
                                    FROM tiposasistencias
                                    WHERE tiposasistencias.idtipoasistencia = $idtipoasistencia ");

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}



function select_funciones($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT 
                    funciones.idfuncion,
                    funciones.nombrefuncion,
                    funciones.idstatus,
                    funciones.idmodulo,
                    modulos.nombremodulo,
                    status.nombrestatus
                FROM funciones, status, modulos
                WHERE funciones.idstatus = status.idstatus
                AND funciones.idmodulo = modulos.idmodulo
                $busqueda
                ORDER BY idfuncion DESC
                $paginacion
                ;";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "funciones");
        }
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_funcion($db, $idfuncion)
{
    $result = ejecuta_select($db, "SELECT 
                                        funciones.*,
                                        modulos.nombremodulo,
                                        empresas.idempresa,
                                        sistemas.idsistema,
                                        status.nombrestatus
                                    FROM funciones, status, modulos, sistemas, empresas
                                    WHERE funciones.idfuncion = $idfuncion
                                    AND funciones.idstatus = status.idstatus
                                    AND funciones.idmodulo = modulos.idmodulo
                                    AND sistemas.idempresa = empresas.idempresa
                                    AND modulos.idsistema = sistemas.idsistema
                                    ORDER BY idfuncion");

    return $result;
}


function select_alertas($db, $paginadorlimite = 0, $paginadorinicio = 0)
{
    $paginacion = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    $result = ejecuta_select($db, "SELECT 
                                        idagencia,
                                        nombreagencia,
                                        creditobase,
                                        creditoactual
                                    FROM agencias
                                    WHERE idstatus = 1
                                    AND creditoactual < ((creditobase * 25) / 100)
                                    ORDER BY nombreagencia
                                    $paginacion
                                    ");

    $cantidad           = ejecuta_select($db, "SELECT count(*) as cantidad FROM agencias WHERE idstatus = 1 AND creditoactual < ((creditobase * 25) / 100) ");
    $result['cantidad'] = $cantidad['resultado'][0]['cantidad'];
    
    return $result;
}

function select_auditorias($db, $paginadorlimite = 0, $paginadorinicio = 0)
{
    $paginacion = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    $result = ejecuta_select($db, "SELECT 
                                        auditorias.*,
                                        usuarios.nombreusuario,
                                        usuarios.apellidousuario
                                    FROM auditorias, usuarios
                                    WHERE auditorias.idusuario = usuarios.idusuario
                                    ORDER BY auditorias.idauditoria DESC
                                    $paginacion
                                    ");

    $result['total'] = consulta_cantidad($db, 'auditorias' );
    return $result;
}

function select_sesiones($db)
{
    $result = ejecuta_select($db, "SELECT 
                                        usuarios.*,
                                        CONCAT(usuarios.nombreusuario,' ',usuarios.apellidousuario) as nombrecompletousuario,
                                        agencias.nombreagencia,
                                        paises.bandera,
                                        sesiones.navegador
                                    FROM usuarios, agencias, paises, sesiones
                                    WHERE conectado = true 
                                    AND usuarios.idusuario = sesiones.idusuario
                                    AND usuarios.idagencia = agencias.idagencia
                                    AND agencias.idpais = paises.idpais");
    return $result;
}

function cotizador_viajes_datos_permitidos_usuario($db, $idusuario)
{
    $sql = "SELECT  usuarios.idusuario, 
                    usuarios.idtipousuario, 
                    empresas.idempresa,
                    agencias.idpais,
                    usuarios.idagencia, 
                    agencias.idsistema,
                    agencias.idnivel,
                    usuarios.escorporativo 
            FROM usuarios, agencias, sistemas, empresas
            WHERE usuarios.idusuario = $idusuario
            AND usuarios.idagencia = agencias.idagencia
            AND agencias.idsistema = sistemas.idsistema
            AND sistemas.idempresa = empresas.idempresa
            ";

    $result = ejecuta_select($db, $sql);

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_categoria($db, $idcategoria)
{
    $result = ejecuta_select($db, "SELECT 
                                        idcategoria,
                                        nombrecategoria,
                                        idstatus,
                                        nombrecategoriaen,
                                        descripcioncategoria,
                                        descripcioncategoriaen,
                                        idmoneda,
                                        tiempominimo,
                                        tiempomaximo,
                                        edadminima,
                                        edadmaxima
                                    FROM categorias
                                    WHERE categorias.idcategoria = $idcategoria ");

    $id = 0;

    foreach($result['resultado'] as $categoria)
    {
        $idcategoria                = $categoria['idcategoria'];
        $fuentesasignadas           = [];
        $paisesasignados            = [];
        $agenciasasignadas          = [];
        $origenesasignados          = [];
        $destinosasignados          = [];
       
        //FUENTES
            $fuentes = ejecuta_select($db, "SELECT categoriasfuentes.idfuente FROM categoriasfuentes WHERE categoriasfuentes.idcategoria = $idcategoria ");
            foreach($fuentes['resultado'] as $fuente) array_push($fuentesasignadas, $fuente['idfuente']);

        //PAISES
            $paises = ejecuta_select($db, "SELECT categoriaspaises.idpais FROM categoriaspaises WHERE categoriaspaises.idcategoria = $idcategoria ");
            foreach($paises['resultado'] as $pais) array_push($paisesasignados, $pais['idpais']);

        //AGENCIAS
            $agencias = ejecuta_select($db, "SELECT categoriasagencias.idagencia FROM categoriasagencias WHERE categoriasagencias.idcategoria = $idcategoria ");
            foreach($agencias['resultado'] as $agencia) array_push($agenciasasignadas, $agencia['idagencia']);

        //ORIGENES
            $origenes = ejecuta_select($db, "SELECT categoriasorigenes.idpais FROM categoriasorigenes WHERE categoriasorigenes.idcategoria = $idcategoria ");
            foreach($origenes['resultado'] as $origen) array_push($origenesasignados, $origen['idpais']);
        
        //ORIGENES
            $destinos = ejecuta_select($db, "SELECT categoriasdestinos.idpais FROM categoriasdestinos WHERE categoriasdestinos.idcategoria = $idcategoria ");
            foreach($destinos['resultado'] as $destino) array_push($destinosasignados, $destino['idpais']);

        $result['resultado'][$id]['fuentesasignadas']                   = $fuentesasignadas;
        $result['resultado'][$id]['paisesasignados']                    = $paisesasignados;
        $result['resultado'][$id]['agenciasasignadas']                  = $agenciasasignadas;
        $result['resultado'][$id]['origenesasignados']                  = $origenesasignados;
        $result['resultado'][$id]['destinosasignados']                  = $destinosasignados;
        
        $id++;
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_categorias($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT categorias.idcategoria,
                                            categorias.nombrecategoria,
                                            categorias.nombrecategoriaen,
                                            categorias.idstatus,
                                            categorias.idmoneda,
                                            categorias.tiempominimo,
                                            categorias.tiempomaximo,
                                            categorias.edadminima,
                                            categorias.edadmaxima,
                                            status.nombrestatus
                                        FROM categorias, status
                                        WHERE categorias.idstatus = status.idstatus
                                        $busqueda
                                        ORDER BY categorias.idcategoria DESC
                                        $paginacion
                                        ";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "categorias");
        }
    }
    
    if($include_conf)
    {
        // ASIGNA CONFIGURACIONES
            $contador = 0;
            foreach($result['resultado'] as $registro)
            {
                $idregistro     = $registro['idcategoria'];
                $fuentes        = ejecuta_select($db, "SELECT * FROM categoriasfuentes WHERE idcategoria = $idregistro");
                $paises         = ejecuta_select($db, "SELECT * FROM categoriaspaises WHERE idcategoria = $idregistro");
                $agencias       = ejecuta_select($db, "SELECT * FROM categoriasagencias WHERE idcategoria = $idregistro");
    
                $result['resultado'][$contador]['configuracionvisualizacion'] = ($fuentes['cantidad'] == 0 || $paises['cantidad'] == 0 || $agencias['cantidad'] == 0) ? 'f' : 't'; 
                $contador++;
            }
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();
    
    return $result;
}

function select_categorias_pais($db, $idpais)
{
    $result = ejecuta_select($db, "SELECT categoriaspaises.*,
                                        categorias.nombrecategoria
                                    FROM categoriaspaises, categorias
                                    WHERE categoriaspaises.idcategoria = categorias.idcategoria
                                    AND categoriaspaises.idpais = $idpais");
    return $result;
}

function select_plan($db, $idplan)
{
    $result = ejecuta_select($db, "SELECT 
                                        planes.idplan as idplan,
                                        planes.nombreplan as nombreplan,
                                        planes.idstatus as idstatus,
                                        planes.idcategoria as idcategoria,
                                        planes.tiempominimo as tiempominimo, 
                                        planes.tiempomaximo as tiempomaximo, 
                                        planes.edadminima as edadminima, 
                                        planes.edadmaxima as edadmaxima, 
                                        planes.edadprecioincremento as edadprecioincremento, 
                                        planes.planfamiliar, 
                                        planes.factorpenalizacionedad as factorpenalizacionedad, 
                                        planes.factorbeneficiofamiliar as factorbeneficiofamiliar, 
                                        planes.idmonedapago as idmonedapago, 
                                        planes.idmonedacobertura as idmonedacobertura, 
                                        to_char(planes.fechacreacion, 'YYYY-mm-dd') as fechacreacion,
                                        to_char(planes.fechamodificacion, 'YYYY-mm-dd') as fechamodificacion,
                                        planes.idpopularidad as idpopularidad, 
                                        planes.edadmaximabeneficiosadic as edadmaximabeneficiosadic, 
                                        planes.descripcionplan as descripcionplan, 
                                        planes.descripcionplanen as descripcionplanen, 
                                        planes.idtipoasistencia as idtipoasistencia, 
                                        planes.fechaactualizacionprecioscostos,
                                        planes.fechaactualizacionbeneficios,
                                        planes.fechaactualizacionbeneficiosadicionales,
                                        planes.fechaactualizacionbeneficiosproveedores,
                                        status.nombrestatus,
                                        categorias.nombrecategoria,
                                        popularidades.nombrepopularidad,
                                        tiposasistencias.nombretipoasistencia
                                    FROM planes, status, categorias, popularidades, tiposasistencias
                                    WHERE planes.idstatus = status.idstatus
                                    AND planes.idcategoria = categorias.idcategoria
                                    AND planes.idpopularidad = popularidades.idpopularidad
                                    AND planes.idtipoasistencia = tiposasistencias.idtipoasistencia
                                    AND planes.idplan = $idplan
                                    ORDER BY planes.idplan DESC
                                    ");

    $id = 0;

    foreach($result['resultado'] as $plan)
    {
        $idplan                                     = $plan['idplan'];
        $fechaactualizacionprecioscostos            = $plan['fechaactualizacionprecioscostos'];
        $fechaactualizacionbeneficios               = $plan['fechaactualizacionbeneficios'];
        $fechaactualizacionbeneficiosadicionales    = $plan['fechaactualizacionbeneficiosadicionales'];
        $fechaactualizacionbeneficiosproveedores    = $plan['fechaactualizacionbeneficiosproveedores'];
        $plataformaspagoasignadas                   = [];
        $origenesasignados                          = [];
        $destinosasignados                          = [];
        $fuentesasignadas                           = [];
        $paisesasignados                            = [];
        $agenciasasignadas                          = [];
        $niveles                                    = [];
        $proveedoresasignados                       = [];
        $preciosasignados                           = [];


        //PLATAFORMAS
            $plataformaspago = ejecuta_select($db, "SELECT planesplataformaspago.idplataformapago FROM planesplataformaspago WHERE planesplataformaspago.idplan = $idplan ");
            foreach($plataformaspago['resultado'] as $plataforma) array_push($plataformaspagoasignadas, $plataforma['idplataformapago']);
            
        //ORIGENES
            $origenes = ejecuta_select($db, "SELECT planesorigenes.idpais FROM planesorigenes WHERE planesorigenes.idplan = $idplan ");
            foreach($origenes['resultado'] as $origen) array_push($origenesasignados, $origen['idpais']);

        //DESTINOS
            $destinos = ejecuta_select($db, "SELECT planesdestinos.idpais FROM planesdestinos WHERE planesdestinos.idplan = $idplan ");
            foreach($destinos['resultado'] as $destino) array_push($destinosasignados, $destino['idpais']);
            
        //FUENTES
            $fuentes = ejecuta_select($db, "SELECT planesfuentes.idfuente FROM planesfuentes WHERE planesfuentes.idplan = $idplan ");
            foreach($fuentes['resultado'] as $fuente) array_push($fuentesasignadas, $fuente['idfuente']);

        //PAISES
            $paises = ejecuta_select($db, "SELECT planespaises.idpais FROM planespaises WHERE planespaises.idplan = $idplan ");
            foreach($paises['resultado'] as $pais) array_push($paisesasignados, $pais['idpais']);

        //AGENCIAS

            $agencias = ejecuta_select($db, "SELECT planesagencias.idagencia FROM planesagencias WHERE planesagencias.idplan = $idplan ");
            foreach($agencias['resultado'] as $agencia) array_push($agenciasasignadas, $agencia['idagencia']);

        //BENEFICIOS
            $beneficiosasignados = ejecuta_select($db, "SELECT   
                                                        planesbeneficios.idplanbeneficio,
                                                        planesbeneficios.idbeneficio,
                                                        planesbeneficios.cobertura,
                                                        planesbeneficios.coberturaen,
                                                        planesbeneficios.orden,
                                                        beneficios.nombrebeneficio
                                            FROM planesbeneficios, beneficios
                                            WHERE planesbeneficios.idplan = $idplan
                                            AND planesbeneficios.fechaactualizacion = '$fechaactualizacionbeneficios'
                                            AND planesbeneficios.idbeneficio = beneficios.idbeneficio
                                            AND beneficios.idstatus = 1 ");

            $contador_beneficio = 0;

            if($beneficiosasignados['cantidad'] > 0)
            {
                foreach($beneficiosasignados['resultado'] as $beneficio)
                {
                    $idplanbeneficio = $beneficio['idplanbeneficio'];
                    $proveedores = array();
                    
                    $select_proveedores = ejecuta_select($db, "SELECT   planesbeneficiosproveedores.idproveedor,
                                                                        proveedores.nombreproveedor,
                                                                        planesbeneficiosproveedores.porcentajeriesgo
                                                            FROM planesbeneficiosproveedores, proveedores
                                                            WHERE planesbeneficiosproveedores.idplanbeneficio = $idplanbeneficio
                                                            AND planesbeneficiosproveedores.fechaactualizacion = '$fechaactualizacionbeneficiosproveedores'
                                                            AND planesbeneficiosproveedores.idproveedor = proveedores.idproveedor
                                                        ");
    
                    foreach($select_proveedores['resultado'] as $proveedor) 
                    {
                        $array_proveedores = array();
    
                        $array_proveedores['idproveedor'] = $proveedor['idproveedor']; 
                        $array_proveedores['nombreproveedor'] = $proveedor['nombreproveedor']; 
                        $array_proveedores['porcentajeriesgo'] = $proveedor['porcentajeriesgo']; 
    
                        array_push($proveedores, $array_proveedores);
                    }
    
                    $beneficiosasignados['resultado'][$contador_beneficio]['proveedores'] = $proveedores;
                    
                    $contador_beneficio++;
                } 
            }
            else
            {
                $beneficiosasignados['resultado'] = array();
            }

        //BENEFICIOS ADICIONALES
            $beneficioadicionalessasignados = ejecuta_select($db, "SELECT   planesbeneficiosadicionales.idplanbeneficioadicional,
                                                                            planesbeneficiosadicionales.idbeneficioadicional,
                                                                            planesbeneficiosadicionales.factorconversion,
                                                                            planesbeneficiosadicionales.factorconversionedad,
                                                                            planesbeneficiosadicionales.factorconversionfamiliar,
                                                                            planesbeneficiosadicionales.cobertura,
                                                                            planesbeneficiosadicionales.coberturaen,
                                                                            planesbeneficiosadicionales.orden,
                                                                            beneficiosadicionales.nombrebeneficioadicional
                                                        FROM planesbeneficiosadicionales, beneficiosadicionales
                                                        WHERE planesbeneficiosadicionales.idplan = $idplan
                                                        AND planesbeneficiosadicionales.fechaactualizacion = '$fechaactualizacionbeneficiosadicionales'
                                                        AND planesbeneficiosadicionales.idbeneficioadicional = beneficiosadicionales.idbeneficioadicional
                                                        AND beneficiosadicionales.idstatus = 1 ");

            $contador_beneficio = 0;

            if($beneficioadicionalessasignados['cantidad'] > 0)
            {
                foreach($beneficioadicionalessasignados['resultado'] as $beneficioadicional)
                {
                    $idplanbeneficioadicional = $beneficioadicional['idplanbeneficioadicional'];
                    $proveedores = array();
                    
                    $select_proveedores = ejecuta_select($db, "SELECT   planesbeneficiosadicionalesproveedores.idproveedor,
                                                                        proveedores.nombreproveedor,
                                                                        planesbeneficiosadicionalesproveedores.porcentajeriesgo
                                                            FROM planesbeneficiosadicionalesproveedores, proveedores
                                                            WHERE planesbeneficiosadicionalesproveedores.idplanbeneficioadicional = $idplanbeneficioadicional
                                                            AND planesbeneficiosadicionalesproveedores.idproveedor = proveedores.idproveedor
                                                        ");
    
                    foreach($select_proveedores['resultado'] as $proveedor) 
                    {
                        $array_proveedores = array();
    
                        $array_proveedores['idproveedor'] = $proveedor['idproveedor']; 
                        $array_proveedores['nombreproveedor'] = $proveedor['nombreproveedor']; 
                        $array_proveedores['porcentajeriesgo'] = $proveedor['porcentajeriesgo']; 
    
                        array_push($proveedores, $array_proveedores);
                    }
    
                    $beneficioadicionalessasignados['resultado'][$contador_beneficio]['proveedores'] = $proveedores;
                    
                    $contador_beneficio++;
                } 
            }
            else
            {
                $beneficioadicionalessasignados['resultado'] = array();
            }


        //PRECIOS Y COSTOS 
            $contador_pais = 0;
            foreach($paisesasignados as $paisasignado)
            {
                $precios = ejecuta_select($db, "SELECT  planesprecios.dia,
                                                        planesprecios.precio
                                            FROM planesprecios
                                            WHERE planesprecios.idplan = $idplan
                                            AND planesprecios.idpais = $paisasignado
                                            AND planesprecios.fechaactualizacion = '$fechaactualizacionprecioscostos'
                                            ");
                                        

                $preciosasignados[$contador_pais]['idpais'] = $paisasignado;
                $preciosasignados[$contador_pais]['precioscalculados'] = ($precios['resultado']) ? $precios['resultado'] : array();

                $contador_dias = 0;
                foreach($preciosasignados[$contador_pais]['precioscalculados'] as $precioscalculados)
                {
                    $costosasignados    = array();
                    $dia                = $precioscalculados['dia'];

                    $costos = ejecuta_select($db, "SELECT  planescostos.idproveedor,
                                                        planescostos.costo
                                            FROM planescostos
                                            WHERE planescostos.idplan = $idplan
                                            AND planescostos.dia = $dia
                                            AND planescostos.idpais = $paisasignado
                                            AND planescostos.fechaactualizacion = '$fechaactualizacionprecioscostos'
                                            ");

                    foreach($costos['resultado'] as $costo) array_push($costosasignados, $costo);

                    $preciosasignados[$contador_pais]['precioscalculados'][$contador_dias]['costos'] = $costosasignados;

                    $contador_dias++;
                }

                $contador_pais++;
            } 

        // PROVEEDORES BENEFICIOS
            $proveedores = ejecuta_select($db, "SELECT planesbeneficiosproveedores.idproveedor FROM planesbeneficiosproveedores WHERE planesbeneficiosproveedores.idplanbeneficio in (SELECT idplanbeneficio FROM planesbeneficios WHERE planesbeneficios.idplan = $idplan) GROUP BY planesbeneficiosproveedores.idproveedor");
            foreach($proveedores['resultado'] as $proveedor) array_push($proveedoresasignados, $proveedor['idproveedor']);

        // PROVEEDORES BENEFICIOS
            $proveedores = ejecuta_select($db, "SELECT planesbeneficiosadicionalesproveedores.idproveedor FROM planesbeneficiosadicionalesproveedores WHERE planesbeneficiosadicionalesproveedores.idplanbeneficioadicional in (SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE planesbeneficiosadicionales.idplan = $idplan) ");
            foreach($proveedores['resultado'] as $proveedor) 
            {
                if(!in_array($proveedor['idproveedor'], $proveedoresasignados )) 
                {
                    array_push($proveedoresasignados, $proveedor['idproveedor']);
                }
            }

        $result['resultado'][$id]['plataformaspagoasignadas']           = $plataformaspagoasignadas;
        $result['resultado'][$id]['origenesasignados']                  = $origenesasignados;
        $result['resultado'][$id]['destinosasignados']                  = $destinosasignados;
        $result['resultado'][$id]['fuentesasignadas']                   = $fuentesasignadas;
        $result['resultado'][$id]['paisesasignados']                    = $paisesasignados;
        $result['resultado'][$id]['agenciasasignadas']                  = $agenciasasignadas;
        $result['resultado'][$id]['beneficiosasignados']                = $beneficiosasignados['resultado'];
        $result['resultado'][$id]['beneficiosadicionalesasignados']     = $beneficioadicionalessasignados['resultado'];
        $result['resultado'][$id]['proveedoresasignados']               = $proveedoresasignados;
        $result['resultado'][$id]['precios']                            = $preciosasignados;
        
        $id++;
    }

    return $result;
}

function select_planes($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';
        
        $sql = "SELECT   planes.idplan,
                    UPPER(planes.nombreplan) as nombreplan,
                    planes.idtipoasistencia,
                    tiposasistencias.nombretipoasistencia,
                    planes.idcategoria,
                    categorias.nombrecategoria,
                    planes.idstatus,
                    status.nombrestatus
                FROM planes, status, categorias, tiposasistencias
                WHERE planes.idstatus = status.idstatus
                AND planes.idcategoria = categorias.idcategoria
                AND planes.idtipoasistencia = tiposasistencias.idtipoasistencia
                $busqueda
                ORDER BY planes.idplan DESC
                $paginacion
                ;";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "planes");
        }
    }

    // ASIGNA CONFIGURACIONES
        if($include_conf)
        {
            $contador = 0;
            foreach($result['resultado'] as $registro)
            {
                $idregistro             = $registro['idplan'];
                $paisesasignados        = array();

                $fuentes                = ejecuta_select($db, "SELECT * FROM planesfuentes WHERE idplan = $idregistro");
                $paises                 = ejecuta_select($db, "SELECT idpais FROM planespaises WHERE idplan = $idregistro");
                $agencias               = ejecuta_select($db, "SELECT * FROM planesagencias WHERE idplan = $idregistro");
                $beneficios             = ejecuta_select($db, "SELECT * FROM planesbeneficios WHERE idplan = $idregistro");
                $beneficiosadicionales  = ejecuta_select($db, "SELECT * FROM planesbeneficiosadicionales WHERE idplan = $idregistro");
                $precios                = ejecuta_select($db, "SELECT * FROM planesprecios WHERE idplan = $idregistro");
    
                $result['resultado'][$contador]['configuracionvisualizacion']           = ($fuentes['cantidad'] == 0 || $paises['cantidad'] == 0 || $agencias['cantidad'] == 0) ? 'f' : 't'; 
                $result['resultado'][$contador]['configuracionbeneficios']              = ($beneficios['cantidad'] == 0) ? 'f' : 't'; 
                $result['resultado'][$contador]['configuracionbeneficiosadicionales']   = ($beneficiosadicionales['cantidad'] == 0) ? 'f' : 't'; 
                $result['resultado'][$contador]['configuracionprecios']                 = ($precios['cantidad'] == 0) ? 'f' : 't'; 

                $contador++;
            }
        }

    if($result['resultado'] == null) $result['resultado'] = array();

    return $result;
}

function select_planes_pais($db, $idpais)
{
    $result = ejecuta_select($db, "SELECT 
                                        planes.idplan,
                                        UPPER(planes.nombreplan) as nombreplan,
                                        categorias.idcategoria,
                                        UPPER(categorias.nombrecategoria) as nombrecategoria
                                    FROM planespaises, planes, categorias
                                    WHERE planespaises.idplan = planes.idplan
                                    AND planes.idcategoria = categorias.idcategoria
                                    AND planespaises.idpais = $idpais
                                    ORDER BY categorias.idcategoria ASC
                                    ");

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_beneficio($db, $idbeneficio)
{
    $categoriasasignadas = [];

    $result = ejecuta_select($db, "SELECT *
                                    FROM beneficios
                                    WHERE beneficios.idbeneficio = $idbeneficio ");

    if($result['cantidad'] > 0)
    {
        $categorias = ejecuta_select($db, "SELECT beneficioscategorias.idcategoria FROM beneficioscategorias WHERE beneficioscategorias.idbeneficio = $idbeneficio");
        foreach($categorias['resultado'] as $categoria) array_push($categoriasasignadas, $categoria['idcategoria']);
        $result['resultado'][0]['categoriasasignadas'] = $categoriasasignadas;
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_beneficios($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT  
                        beneficios.idbeneficio,
                        beneficios.nombrebeneficio,
                        beneficios.idstatus,
                        beneficios.fechacreacion,
                        beneficios.fechamodificacion,
                        beneficios.edadminima,
                        beneficios.edadmaxima,
                        beneficios.descripcionbeneficio,
                        beneficios.idfamilia,
                        beneficios.nombrebeneficioen,
                        beneficios.descripcionbeneficioen,
                        beneficios.idtipoasistencia,
                        status.nombrestatus,
                        familias.nombrefamilia,
                        tiposasistencias.nombretipoasistencia
                FROM beneficios, status, familias, tiposasistencias
                WHERE beneficios.idstatus = status.idstatus
                AND beneficios.idfamilia = familias.idfamilia
                AND beneficios.idtipoasistencia = tiposasistencias.idtipoasistencia
                $busqueda
                ORDER BY beneficios.idbeneficio DESC 
                $paginacion
                ";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "beneficios");
        }
    }

    if($result['cantidad'] > 0)
    {
        $id = 0;
        foreach($result['resultado'] as $beneficio)
        {
            $idbeneficio            = $beneficio['idbeneficio'];
            $categoriasasignadas    = [];

            $categorias = ejecuta_select($db, "SELECT beneficioscategorias.idcategoria FROM beneficioscategorias WHERE beneficioscategorias.idbeneficio = $idbeneficio");
            foreach($categorias['resultado'] as $categoria) array_push($categoriasasignadas, $categoria['idcategoria']);
            
            $result['resultado'][$id]['categoriasasignadas'] = $categoriasasignadas;
            
            $id++;
        }
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function 
adicional($db, $idbeneficioadicional)
{
    $result = ejecuta_select($db, "SELECT   
                                        beneficiosadicionales.idbeneficioadicional, 
                                        beneficiosadicionales.nombrebeneficioadicional,
                                        beneficiosadicionales.idstatus,
                                        to_char(beneficiosadicionales.fechacreacion, 'YYYY-mm-dd') as fechacreacion,
                                        to_char(beneficiosadicionales.fechamodificacion, 'YYYY-mm-dd') as fechamodificacion,
                                        beneficiosadicionales.edadminima,
                                        beneficiosadicionales.edadmaxima,
                                        beneficiosadicionales.descripcionbeneficioadicional,
                                        beneficiosadicionales.idfamilia,
                                        beneficiosadicionales.nombrebeneficioadicionalen,
                                        beneficiosadicionales.descripcionbeneficioadicionalen,
                                        beneficiosadicionales.idtipoasistencia,
                                        status.nombrestatus,
                                        familias.nombrefamilia,
                                        tiposasistencias.nombretipoasistencia
                                FROM beneficiosadicionales, status, familias, tiposasistencias
                                WHERE beneficiosadicionales.idbeneficioadicional = $idbeneficioadicional
                                AND beneficiosadicionales.idstatus = status.idstatus
                                AND beneficiosadicionales.idfamilia = familias.idfamilia
                                AND beneficiosadicionales.idtipoasistencia = tiposasistencias.idtipoasistencia
                                ORDER BY beneficiosadicionales.idbeneficioadicional DESC ");
    return $result;
}


function select_beneficios_adicionales($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT   beneficiosadicionales.*,
                                                status.nombrestatus,
                                                familias.nombrefamilia,
                                                tiposasistencias.nombretipoasistencia
                                        FROM beneficiosadicionales, status, familias, tiposasistencias
                                        WHERE beneficiosadicionales.idstatus = status.idstatus
                                        AND beneficiosadicionales.idfamilia = familias.idfamilia
                                        AND beneficiosadicionales.idtipoasistencia = tiposasistencias.idtipoasistencia
                                        $busqueda
                                        ORDER BY beneficiosadicionales.idbeneficioadicional DESC 
                                        $paginacion
                                        ";
        
        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "beneficiosadicionales");
        }
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_cupon($db, $idcupon)
{
    $result = ejecuta_select($db, "SELECT 
                                        cupones.idcupon,
                                        cupones.codigocupon,
                                        cupones.porcentaje,
                                        to_char(cupones.fechadesde, 'YYYY-mm-dd') as fechadesde,
                                        to_char(cupones.fechahasta, 'YYYY-mm-dd') as fechahasta,
                                        cupones.idstatus,
                                        cupones.disponibles,
                                        to_char(cupones.fechacreacion, 'YYYY-mm-dd') as fechacreacion,
                                        to_char(cupones.fechamodificacion, 'YYYY-mm-dd') as fechamodificacion,
                                        cupones.aceptafamiliar
                                    FROM cupones
                                    WHERE cupones.idcupon = $idcupon
                                    ORDER BY cupones.idcupon DESC
                                    ");

    $id = 0;

    foreach($result['resultado'] as $cupon)
    {
        $idcupon                    = $cupon['idcupon'];
        $fuentesasignadas           = [];
        $paisesasignados            = [];
        $agenciasasignadas          = [];
        $categoriasasignadas        = [];
        $planesasignados            = [];

        //FUENTES
            $fuentes = ejecuta_select($db, "SELECT cuponesfuentes.idfuente FROM cuponesfuentes WHERE cuponesfuentes.idcupon = $idcupon ");
            foreach($fuentes['resultado'] as $fuente) array_push($fuentesasignadas, $fuente['idfuente']);

        //PAISES
            $paises = ejecuta_select($db, "SELECT cuponespaises.idpais FROM cuponespaises WHERE cuponespaises.idcupon = $idcupon ");
            foreach($paises['resultado'] as $pais) array_push($paisesasignados, $pais['idpais']);

        //AGENCIAS
            $agencias = ejecuta_select($db, "SELECT cuponesagencias.idagencia FROM cuponesagencias WHERE cuponesagencias.idcupon = $idcupon ");
            foreach($agencias['resultado'] as $agencia) array_push($agenciasasignadas, $agencia['idagencia']);

        //CATEGORIAS
            $categorias = ejecuta_select($db, "SELECT cuponescategorias.idcategoria FROM cuponescategorias WHERE cuponescategorias.idcupon = $idcupon ");
            foreach($categorias['resultado'] as $categoria) array_push($categoriasasignadas, $categoria['idcategoria']);
        
        //PLANES
            $planes = ejecuta_select($db, "SELECT cuponesplanes.idplan FROM cuponesplanes WHERE cuponesplanes.idcupon = $idcupon ");
            foreach($planes['resultado'] as $plan) array_push($planesasignados, $plan['idplan']);

        $result['resultado'][$id]['fuentesasignadas']       = $fuentesasignadas;
        $result['resultado'][$id]['paisesasignados']        = $paisesasignados;
        $result['resultado'][$id]['agenciasasignadas']      = $agenciasasignadas;
        $result['resultado'][$id]['categoriasasignadas']    = $categoriasasignadas;
        $result['resultado'][$id]['planesasignados']        = $planesasignados;

        $id++;
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_cupones($db,  $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT 
                    cupones.idcupon,
                    cupones.codigocupon,
                    cupones.porcentaje,
                    to_char(cupones.fechadesde, 'YYYY-mm-dd') as fechadesde,
                    to_char(cupones.fechahasta, 'YYYY-mm-dd') as fechahasta,
                    cupones.idstatus,
                    cupones.disponibles,
                    to_char(cupones.fechacreacion, 'YYYY-mm-dd') as fechacreacion,
                    to_char(cupones.fechamodificacion, 'YYYY-mm-dd') as fechamodificacion,
                    status.nombrestatus,
                    cupones.aceptafamiliar
                FROM cupones, status
                WHERE cupones.idstatus = status.idstatus
                $busqueda
                ORDER BY cupones.idcupon DESC
                $paginacion
                ";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "cupones");
        }
    }

    if($include_conf)
    {
        // ASIGNA CONFIGURACIONES
            $contador = 0;
            foreach($result['resultado'] as $registro)
            {
                $idregistro     = $registro['idcupon'];
                $fuentes        = ejecuta_select($db, "SELECT * FROM cuponesfuentes WHERE idcupon = $idregistro");
                $paises         = ejecuta_select($db, "SELECT * FROM cuponespaises WHERE idcupon = $idregistro");
                $planes         = ejecuta_select($db, "SELECT * FROM cuponesplanes WHERE idcupon = $idregistro");
                $agencias       = ejecuta_select($db, "SELECT * FROM cuponesagencias WHERE idcupon = $idregistro");
                $result['resultado'][$contador]['configuracionvisualizacion'] = ($fuentes['cantidad'] == 0 || $paises['cantidad'] == 0 || $planes['cantidad'] == 0 || $agencias['cantidad'] == 0) ? 'f' : 't'; 
                $contador++;
            }
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_noticia($db, $idnoticia)
{
    $result = ejecuta_select($db, "SELECT noticias.idnoticia,
                                        noticias.titulo,
                                        noticias.subtitulo,
                                        noticias.descripcion,
                                        noticias.fechacreacion,
                                        noticias.fechapublicacion,
                                        noticias.idusuario,
                                        CONCAT(usuarios.nombreusuario,' ',usuarios.apellidousuario) as nombrecompletousuario,
                                        noticias.idstatus,
                                        status.nombrestatus,
                                        noticias.urlimagen,
                                        noticias.idtiponoticia
                                    FROM noticias, status, usuarios
                                    WHERE noticias.idnoticia = $idnoticia
                                    AND noticias.idstatus = status.idstatus
                                    AND noticias.idusuario = usuarios.idusuario
                                    ORDER BY noticias.idnoticia DESC
                                    ");
    $id = 0;

    foreach($result['resultado'] as $noticia)
    {
        $idnoticia                    = $noticia['idnoticia'];
        $paisesasignados            = [];
        $agenciasasignadas          = [];
        $usuariosasignados          = [];


        //PAISES
            $paises = ejecuta_select($db, "SELECT noticiaspaises.idpais FROM noticiaspaises WHERE noticiaspaises.idnoticia = $idnoticia ");
            foreach($paises['resultado'] as $pais) array_push($paisesasignados, $pais['idpais']);

        //AGENCIAS
            $agencias = ejecuta_select($db, "SELECT noticiasagencias.idagencia FROM noticiasagencias WHERE noticiasagencias.idnoticia = $idnoticia ");
            foreach($agencias['resultado'] as $agencia) array_push($agenciasasignadas, $agencia['idagencia']);

        //USUARIOS
            $usuarios = ejecuta_select($db, "SELECT noticiasusuarios.idusuario FROM noticiasusuarios WHERE noticiasusuarios.idnoticia = $idnoticia ");
            foreach($usuarios['resultado'] as $categoria) array_push($usuariosasignados, $categoria['idusuario']);
        

        $result['resultado'][$id]['paisesasignados']        = $paisesasignados;
        $result['resultado'][$id]['agenciasasignadas']      = $agenciasasignadas;
        $result['resultado'][$id]['usuariosasignados']      = $usuariosasignados;

        $id++;
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();


 //   $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();
    
    return $result;
}

function select_ordenes_asistencias_viajes($db,  $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql ="SELECT 
                ordenes.idorden,
                ordenes.idproducto,
                ordenes.codigovoucher,
                asistenciasviajes.fechadesde,
                asistenciasviajes.fechahasta,
                categorias.nombrecategoria,
                planes.nombreplan,
                monedas.codigo as codigomoneda,
                ordenes.total as total,
                paises.bandera,
                ordenes.idstatus,
                status.nombrestatus
            FROM ordenes, asistenciasviajes, categorias, planes, agencias, paises, monedas, status
            WHERE ordenes.idorden = asistenciasviajes.idorden 
            AND asistenciasviajes.idcategoria = categorias.idcategoria
            AND asistenciasviajes.idplan = planes.idplan
            AND ordenes.idagencia = agencias.idagencia
            AND agencias.idpais = paises.idpais
            AND ordenes.idmoneda = monedas.idmoneda
            AND ordenes.cargaprecompra = false
            AND ordenes.idstatus = status.idstatus
            $busqueda   
            ORDER BY ordenes.fechacreacion DESC
            $paginacion
        ";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "ordenes", "ordenes.cargaprecompra = false");
        }
    }

    if($result['cantidad'] > 0)
    {
        $contador_orden = 0;
        foreach($result['resultado'] as $orden)
        {
            $idorden = $orden['idorden'];

            $beneficiarios = ejecuta_select($db, "SELECT 
                                                        UPPER(beneficiarios.nombrebeneficiario) as nombrebeneficiario,
                                                        UPPER(beneficiarios.apellidobeneficiario) as apellidobeneficiario,
                                                        beneficiarios.fechanacimiento,
                                                        beneficiarios.consecutivo
                                                    FROM beneficiarios
                                                    WHERE beneficiarios.idorden = $idorden 
                                                    ORDER BY idbeneficiario ASC 
                                                    LIMIT 1");

            $result['resultado'][$contador_orden]['beneficiarios'] = $beneficiarios['resultado'];
            $contador_orden++;
        }
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function obtiene_codigovoucher($db, $idorden)
{
    $codigovoucher = ejecuta_select($db, "SELECT codigovoucher FROM ordenes WHERE idorden = $idorden");
    return $codigovoucher['resultado'][0]['codigovoucher'];
}

function select_orden_asistencia_viaje($db, $idorden)
{
    $codigovoucher = obtiene_codigovoucher($db, $idorden);
    $codigovoucher_explode 	= explode('-', $codigovoucher);

    $orden 		= ejecuta_select($db, "SELECT 
                                            ordenes.idorden,
                                            ordenes.idproducto,
                                            ordenes.codigovoucher,
                                            ordenes.idagencia,
                                            asistenciasviajes.idorigen,
                                            paises.nombrepais as origen,
                                            asistenciasviajes.destinos,
                                            asistenciasviajes.fechadesde,
                                            asistenciasviajes.fechahasta,
                                            asistenciasviajes.idcategoria,
                                            categorias.nombrecategoria,
                                            asistenciasviajes.idplan,
                                            planes.nombreplan,
                                            ordenes.idmoneda,
                                            monedas.codigo as codigomoneda,
                                            ordenes.total,
                                            ordenes.comentarios,
                                            ordenes.idstatus,
                                            to_char(ordenes.fechacreacion, 'YYYY-mm-dd hh:ii:ss') as fechacreacion
                                        FROM ordenes, asistenciasviajes, categorias, planes, paises, monedas
                                        WHERE codigovoucher = '$codigovoucher' 
                                        AND ordenes.idorden = asistenciasviajes.idorden 
                                        AND asistenciasviajes.idcategoria = categorias.idcategoria
                                        AND asistenciasviajes.idplan = planes.idplan
                                        AND asistenciasviajes.idorigen = paises.idpais
                                        AND ordenes.idmoneda = monedas.idmoneda
                                        ");

    if($orden['cantidad'] > 0)
    {
        $idorden = $orden['resultado'][0]['idorden'];

        //BENEFICIARIOS
            $beneficiarios = ejecuta_select($db, "SELECT 
                                                        beneficiarios.idbeneficiario,
                                                        beneficiarios.nombrebeneficiario,
                                                        beneficiarios.apellidobeneficiario,
                                                        beneficiarios.fechanacimiento,
                                                        beneficiarios.documentacion,
                                                        beneficiarios.consecutivo
                                                    FROM beneficiarios
                                                    WHERE beneficiarios.idorden = $idorden 
                                                    ORDER BY idbeneficiario ASC ");

            $contador = 0;
            foreach($beneficiarios['resultado'] as $beneficiario)
            {
                $beneficiarios['resultado'][$contador]['codigovoucherpersonal'] = $codigovoucher_explode[0].'-'.$codigovoucher_explode[1].'-'.$beneficiario['consecutivo'].'-'.$codigovoucher_explode[2];
                $contador++;
            }

            $orden['resultado'][0]['beneficiarios'] = ($beneficiarios['cantidad'] > 0) ? $beneficiarios['resultado'] : array();

        // DESTINOS 
            $array_destinos         = array();
            $destinos 				= explode(',', $orden['resultado'][0]['destinos']);


            foreach($destinos as $destino)
            {
                $idpais = ejecuta_select($db, "SELECT idpais FROM paises WHERE idpais = $destino", 'idpais');

                array_push($array_destinos, $idpais);
            }  

            $orden['resultado'][0]['destinos'] = $array_destinos;
    }

    $orden['resultado'] = ($orden['cantidad'] > 0) ? $orden['resultado'] : array();
    
    return $orden;
}

function select_noticias($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT noticias.idnoticia,
                        noticias.titulo,
                        noticias.subtitulo,
                        noticias.descripcion,
                        noticias.fechacreacion,
                        noticias.fechapublicacion,
                        CONCAT(usuarios.nombreusuario,' ',usuarios.apellidousuario) as nombrecompletousuario,
                        noticias.idstatus,
                        status.nombrestatus,
                        noticias.urlimagen,
                        noticias.idtiponoticia
                    FROM noticias, status, usuarios
                    WHERE noticias.idstatus = status.idstatus
                    AND noticias.idusuario = usuarios.idusuario
                    $busqueda
                    ORDER BY noticias.idnoticia DESC
                    $paginacion
                    ";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "noticias");
        }
    }

    if($include_conf)
    {
        // ASIGNA CONFIGURACIONES
            $contador = 0;
            foreach($result['resultado'] as $registro)
            {
                $idregistro     = $registro['idnoticia'];
                $paises         = ejecuta_select($db, "SELECT * FROM noticiaspaises WHERE idnoticia = $idregistro");
                $agencias       = ejecuta_select($db, "SELECT * FROM noticiasagencias WHERE idnoticia = $idregistro");
                $usuarios       = ejecuta_select($db, "SELECT * FROM noticiasusuarios WHERE idnoticia = $idregistro");
                $result['resultado'][$contador]['configuracionvisualizacion'] = ($paises['cantidad'] == 0 && $agencias['cantidad'] == 0 && $usuarios['cantidad'] == 0) ? 'f' : 't'; 
                $contador++;
            }
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_inicio_noticias($db, $idusuario)
{
    $datos_usuario = ejecuta_select($db, "SELECT 
                                                usuarios.idagencia,
                                                agencias.idpais
                                            FROM usuarios, agencias
                                            WHERE usuarios.idusuario = $idusuario
                                            AND usuarios.idagencia = agencias.idagencia");
                                            
    if($datos_usuario['cantidad'] > 0)
    {
        $idpais     = $datos_usuario['resultado'][0]['idpais'];
        $idagencia  = $datos_usuario['resultado'][0]['idagencia'];

        $noticias = array();

        $hoy = date('Y-m-j');

        $semana_proxima = date('Y-m-j', strtotime('+7 day', strtotime($hoy)));
        $semana_pasada  = date('Y-m-j', strtotime('-7 day', strtotime($hoy)));
        $semana_pasada = "{$semana_pasada } 00:00:00";
        //$hoy = "{$hoy } 23:59:59";

        $noticias_generales = ejecuta_select($db, "SELECT noticias.idnoticia,
                                                noticias.titulo,
                                                noticias.subtitulo,
                                                noticias.descripcion,
                                                noticias.fechacreacion,
                                                noticias.fechapublicacion,
                                                noticias.idusuario,
                                                CONCAT(usuarios.nombreusuario,' ',usuarios.apellidousuario) as nombrecompletousuario,
                                                noticias.idstatus,
                                                status.nombrestatus,
                                                noticias.urlimagen
                                            FROM noticias, status, usuarios, noticiasagencias, noticiaspaises
                                            WHERE noticias.idstatus = status.idstatus
                                            AND noticias.idusuario = usuarios.idusuario
                                            AND noticias.fechapublicacion <= '$hoy'
                                            AND noticias.fechapublicacion BETWEEN '$semana_pasada' AND '$hoy'
                                            AND noticias.idnoticia = noticiaspaises.idnoticia AND noticiaspaises.idpais = $idpais
                                            AND noticias.idnoticia = noticiasagencias.idnoticia AND noticiasagencias.idagencia = $idagencia
                                            AND noticias.idtiponoticia = 1
                                            ORDER BY noticias.idnoticia DESC
                                            ");

        $noticias['generales'] = ($noticias_generales['cantidad'] > 0) ? $noticias_generales['resultado'] : array();

        $noticias_directas = ejecuta_select($db, "SELECT noticias.idnoticia,
                                                noticias.titulo,
                                                noticias.subtitulo,
                                                noticias.descripcion,
                                                noticias.fechacreacion,
                                                noticias.fechapublicacion,
                                                noticias.idusuario,
                                                CONCAT(usuarios.nombreusuario,' ',usuarios.apellidousuario) as nombrecompletousuario,
                                                noticias.idstatus,
                                                status.nombrestatus,
                                                noticias.urlimagen,
                                                noticiasusuarios.idnoticiausuario,
                                                noticiasusuarios.idstatus AS idvisto
                                            FROM noticias, status, usuarios, noticiasusuarios
                                            WHERE noticias.idstatus = status.idstatus
                                            AND noticias.idusuario = usuarios.idusuario
                                            AND noticias.fechapublicacion <= 'NOW()'
                                            AND noticias.idnoticia = noticiasusuarios.idnoticia AND noticiasusuarios.idusuario = $idusuario
                                            AND noticias.idstatus NOT IN (6)
                                            AND noticias.idtiponoticia = 2
                                            ORDER BY noticias.idnoticia DESC
                                            ");
                
                if(!empty($noticias_directas["resultado"])){
                    foreach ($noticias_directas["resultado"] as $key => $value) {
                        if($value['idvisto'] === '6'){
                            $id=$value['idnoticiausuario'];
                            $update =  "UPDATE public.noticiasusuarios  SET idstatus = 7  WHERE idnoticiausuario= $id";
                            ejecuta_update($db,$update);    
                        }
                    }
    
        }
        
        $noticias['directas'] = ($noticias_directas['cantidad'] > 0) ? $noticias_directas['resultado'] : array();

        $result['resultado']    = $noticias;
        $result['cantidad']     = count($noticias['generales']) + count($noticias['directas']);
        $result['error']        = false;
    }
    else
    {
        $result['resultado']        = array();
        $result['cantidad']         = 0;
        $result['error']            = true;
        $result['mensaje_error']    = 'El usuario no existe';
    }

    return $result;
}

function select_precompra($db, $idprecompra)
{
    $precompra = ejecuta_select($db, "SELECT 
                                        ordenes.idorden,
                                        precompras.idprecompra,
                                        ordenes.idstatus,
                                        status.nombrestatus,
                                        ordenes.codigovoucher,
                                        ordenes.idagencia,
                                        ordenes.idmoneda,
                                        monedas.codigo,
                                        ordenes.total,
                                        to_char(ordenes.fechacreacion, 'YYYY-mm-dd') as fechacreacion,
                                        ordenes.idplataformapago,
                                        plataformaspago.nombreplataformapago,
                                        agencias.idnivel
                                    FROM precompras, ordenes, monedas, status, plataformaspago, agencias
                                    WHERE precompras.idprecompra = $idprecompra
                                    AND precompras.idorden = ordenes.idorden
                                    AND ordenes.idmoneda = monedas.idmoneda
                                    AND ordenes.idstatus = status.idstatus
                                    AND ordenes.idplataformapago = plataformaspago.idplataformapago
                                    AND ordenes.idagencia = agencias.idagencia
                                ");


    if($precompra['cantidad'] > 0)  
    {
        $select = "SELECT SUM(total) as consumido 
                    FROM ordenes 
                    WHERE idstatus = 1 
                    AND idprecompra = $idprecompra";
                    
        $consumido = ejecuta_select($db, $select);

        $precompra['resultado'][0]['consumido'] = $consumido['resultado'][0]['consumido'];
        $precompra['resultado'][0]['restante']  = strval($precompra['resultado'][0]['total'] - $consumido['resultado'][0]['consumido']);

        //PLANES ASIGNADOS
            $array_planes_asignados = array();

            $planesasignados = ejecuta_select($db, "SELECT idplan FROM precomprasplanes WHERE idprecompra = $idprecompra");

            foreach($planesasignados['resultado'] as $planasignado)
            {
                array_push($array_planes_asignados, $planasignado['idplan']);
            }

            $precompra['resultado'][0]['planesasignados'] = $array_planes_asignados;
    }

    $precompra['resultado'] = ($precompra['cantidad'] > 0) ? $precompra['resultado'] : array();

    return $precompra;
}

function select_precompras($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';

        $sql = "SELECT  precompras.idprecompra,
                        ordenes.idorden,
                        to_char(ordenes.fechacreacion, 'YYYY-mm-dd hh:ii:ss') as fechaprecompra,
                        status.nombrestatus,
                        ordenes.codigovoucher, 
                        ordenes.total,
                        monedas.codigo,
                        ordenes.idagencia,
                        agencias.nombreagencia
                FROM precompras, status, ordenes, monedas, agencias
                    WHERE precompras.idstatus = status.idstatus 
                    AND  precompras.idorden = ordenes.idorden 
                    AND ordenes.idmoneda = monedas.idmoneda
                    AND ordenes.idagencia = agencias.idagencia
                    $busqueda
                    ORDER BY idprecompra
                    $paginacion
                    ;";
        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "precompras");
        }
    }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();
    
    return $result;
}

function desasociar_cuponesfuentes($db, $idcupon)
{
    $result = ejecuta_delete($db, "DELETE FROM cuponesfuentes WHERE idcupon = $idcupon");

    return $result;
}

function desasociar_cuponespaises($db, $idcupon)
{
    $result = ejecuta_delete($db, "DELETE FROM cuponespaises WHERE idcupon = $idcupon");

    return $result;
}

function desasociar_cuponesagencias($db, $idcupon)
{
    $result = ejecuta_delete($db, "DELETE FROM cuponesagencias WHERE idcupon = $idcupon");

    return $result;
}

function desasociar_cuponesplanes($db, $idcupon)
{
    $result = ejecuta_delete($db, "DELETE FROM cuponesplanes WHERE idcupon = $idcupon");

    return $result;
}

function requerido($response, $campo)
{
    $noData["resultado"]["mensaje_error"]  = 'ERROR: El valor del campo: '.$campo.', es requerido.';
    $noData["cantidad"]                    = 0;
    $noData["error"]                       = true;

    $resultado = json_encode($noData);
    $response->getBody()->write($resultado);
    return $reponse;
}

function verifica_token_sesion($db,  $vtoken)
{

    $token = extrae_token($vtoken);
     
    if($token != '')
    {
        $sql = "SELECT token FROM sesiones WHERE token = '$token'";

        $token_activo = ejecuta_select($db, $sql);
       // var_dump($token);
       // var_dump($token_activo);
       // exit();    	
        if($token == $token_activo['resultado'][0]['token'])
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

function verifica_apikey($db,$key)
{
    $apikey =extrae_apikey($key);
    
    if($apikey != '')
    {
        $sql=  "SELECT apikey FROM sistemas WHERE apikey = '$apikey';";
        $apikey_activo = ejecuta_select($db,$sql);
        
        if($apikey == $apikey_activo['resultado'][0]['apikey'])
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}


function extrae_token($token)
{
    $token 		= explode(' ', $token);
    $token 		= (count($token) > 1) ? $token[1] : $token[0];

    return $token;
}


function extrae_apikey($apikey)
{
    $apikey 		= explode(' ', $apikey);
    $apikey 		= (count($apikey) > 1) ? $apikey[1] : $apikey[0];

    return $apikey;
}

function valida_token_continental($token)
{
    if(substr($token, 0, 11) == 'continental')
    {
        return true;
    }
    else
    {
        return false;
    }
}

function validar_usuario($db,$correo,$password)
{

   $sql="SELECT contrasena FROM usuarios  WHERE correo='$correo'";
   
   $usuario = ejecuta_select($db, $sql); 
   if($usuario['resultado'] != false){
    if($password === sha1($usuario['resultado'][0]['contrasena'])){
        
        return true;

       }else{
        $response["resultado"]  = array();
        $response["cantidad"]   = 0;
        $response["error"]   = true;
        $response["mensaje"]    = 'Contraseña no valida';
        return $response;
       }
   }else{

    $response["resultado"]  = array();
    $response["cantidad"]   = 0;
    $response["error"]   = true;
    $response["mensaje"]    = 'Correo no valido';
   return $response;
   }



}

function select_max_id($db, $campo, $tabla)
{
    $select = "SELECT MAX($campo) as $campo FROM $tabla";
    $valor = ejecuta_select($db, $select);
    return $valor['resultado'][0][$campo];
}

function validar_campos_requeridos($requeridos, $data)
{
    while ($tipo_requerido = current($requeridos)) 
    {
        $campo  = key($requeridos);
        $tipo   = gettype($data->$campo);
        $datos  = $data->$campo;

        if(!$data->$campo && $tipo != 'boolean' && $tipo != 'array' && $datos != 0)
        {
            return 'Falta el valor del campo requerido: '.$campo.', por favor asegurese de enviarlo.';
        }
        else
        {
            if($tipo_requerido['subtipo'] == 'boolean')
            {
                if($datos != 't' && $datos != 'f')
                {
                    return 'El tipo de valor en el campo: '.$campo.', no es valido, por favor envie un string con t/f';
                }
            }

            if($tipo !== $tipo_requerido['tipo'])
            {
                return 'El tipo de dato del valor en el campo: '.$campo.', debe ser de tipo: '.$tipo_requerido['tipo'].'.';
            }
            else
            {
                if($tipo_requerido['datos'] == "novacio" && $tipo != 'boolean' && $datos == "" && $datos != 0 )
                {
                    return 'El valor en el campo: '.$campo.', no puede estar vacío.';
                }

                if($tipo_requerido['datos'] == "fecha")
                {
                    if(!valida_formato_fecha($datos, $tipo_requerido['formato']))
                    {
                        return 'El valor en el campo: '.$campo.', no cumple con el formato de fecha requerido ('.$tipo_requerido['formato'].').';
                    }
                }

            }
        }

        next($requeridos);
    }

    return true;
}

function valida_formato_fecha($fecha, $formato)
{
    if($formato == 'YYYY-MM-DD')
    {
        $fecha = explode('-', $fecha);

        if(count($fecha) == 3)
        {
            if(strlen($fecha[0]) == 4 && strlen($fecha[1]) == 2 && strlen($fecha[2]) == 2)
            {
                return true;
            }
        }
        else
        {
            return false;
        }
    }

    if($formato == 'DD-MM-YYYY')
    {
        $fecha = explode('-', $fecha);

        if(count($fecha) == 3)
        {
            if(strlen($fecha[0]) == 2 && strlen($fecha[1]) == 2 && strlen($fecha[2]) == 4)
            {
                return true;
            }
        }
        else
        {
            return false;
        }
    }

    return false;
}

function generar_codigo_voucher($db, $acronimovoucher, $codigopais)
{
    $chr 	= "0123456789ABCDEFGHIJKMLNOPQRSTUVWXYZ";
    $valido = false; 

    while(!$valido):
        $codigo = "";
        while(strlen($codigo) < 6) $codigo .= substr($chr, mt_rand(0,(strlen($chr))), 1);
        $codigovoucher 	= $acronimovoucher.'-'.$codigo.'-'.$codigopais;
        $valida_codigo	= ejecuta_select($db, "SELECT * FROM ordenes WHERE codigovoucher = '$codigovoucher' ");
        $valido 		= ($valida_codigo['cantidad'] == 0) ? true : false;
    endwhile;
    
    return $codigovoucher;
}

function consulta_planes_precompras_disponibles($db, $idpais, $idagencia, $dias, $edades)
{
    $array_planes = array();

    $precompras_agencia = ejecuta_select($db, "SELECT 
                                                    precompras.idprecompra, 
                                                    ordenes.total as cargainicial
                                                FROM ordenes, precompras 
                                                WHERE cargaprecompra = true 
                                                AND ordenes.idorden = precompras.idorden 
                                                AND ordenes.idagencia = $idagencia 
                                                AND ordenes.idstatus = 1 
                                                ORDER BY precompras.idprecompra ASC");

    $contador = 0;
    foreach($precompras_agencia['resultado'] as $precompra_agencia)
    {
        $idprecompra    = $precompra_agencia['idprecompra'];
        $consumido      = ejecuta_select($db, "SELECT 
                                                    COALESCE(SUM(total), 0) as consumido 
                                                FROM ordenes 
                                                WHERE idprecompra = $idprecompra 
                                                AND idstatus = 1", 
                                            "consumido");

        $restante = $precompra_agencia['cargainicial'] - $consumido;

        if($restante > 0)
        {
            $precompras_planes = ejecuta_select($db, "SELECT idplan FROM precomprasplanes WHERE idprecompra = $idprecompra");

            foreach($precompras_planes['resultado'] as $precompra_plan)
            {
                $idplan = $precompra_plan['idplan'];

                $plan_precio = ejecuta_select($db, "SELECT 
                                                    precio 
                                                FROM planes, planesprecios 
                                                WHERE planes.idplan = planesprecios.idplan 
                                                AND planes.fechaactualizacionprecioscostos = planesprecios.fechaactualizacion
                                                AND planesprecios.idplan = $idplan
                                                AND planesprecios.dia = $dias
                                                AND planesprecios.idpais = $idpais
                                                AND planes.idstatus = 1
                                                ", "precio");

                $factores = ejecuta_select($db, "SELECT edadprecioincremento, factorpenalizacionedad FROM planes WHERE idplan = $idplan");   
                
                $factores = $factores['resultado'][0];

                $precio_total = 0;
                foreach($edades as $edad)
                {
                    if($edad <= $factores['edadprecioincremento'])
                    {
                        $precio_total =+ $plan_precio;
                    }
                    else
                    {
                        $precio_total =+ $plan_precio * $factores['factorpenalizacionedad'];
                    }
                }


                if($precio_total < $restante)
                {
                    if(!in_array($precompra_plan['idplan'], $array_planes))
                    {
                        array_push($array_planes, $idplan);
                    }
                }
            }
        }

        $contador++;
    }

    return $array_planes;
}

function consulta_planes_para_cotizar($db, $dias, $idcategoria, $idtipoasistencia, $idfuente, $idpais, $idagencia, $origen, $destinos_implode, $edadminima, $edadmaxima, $condicion_planes_precompra, $edades, $planfamiliar = false, $categori = false, $mostrar_id = false, $idmontoviaje = false)
{
    $condicion_plan_familiar = ' ';
    $camponombreplan = "UPPER(planes.nombreplan) as nombreplan,";

    if($mostrar_id)
    {
        $camponombreplan = "CONCAT(UPPER(planes.nombreplan),' (',planes.idplan,')') as nombreplan,";
    }

    if($planfamiliar)
    {
        $condicion_plan_familiar = ' AND planes.planfamiliar = true ';
    }

    if($idcategoria == 23)
    {
        if($dias <= 30)                 $dias = 30;
        if($dias >= 31 && $dias <= 60)  $dias = 60; 
        if($dias >= 61)                 $dias = 90; 
    }

    $select = "SELECT DISTINCT planes.idplan,
                                $camponombreplan
                                planes.idcategoria,
                                UPPER(categorias.nombrecategoria) as nombrecategoria,
                                planes.edadprecioincremento,
                                planes.factorpenalizacionedad,
                                planes.idmonedapago,
                                planes.idmonedacobertura,
                                planes.idpopularidad,
                                popularidades.nombrepopularidad,
                                planes.fechaactualizacionprecioscostos,
                                planes.fechaactualizacionbeneficios,
                                planes.fechaactualizacionbeneficiosadicionales,
                                planes.fechaactualizacionbeneficiosproveedores,
                                monedas.codigo as codigomonedapago,
                                categorias.validamontoviaje
                        FROM planes
                        LEFT JOIN planesorigenes ON planes.idplan = planesorigenes.idplan
                        LEFT JOIN planesdestinos ON planes.idplan = planesdestinos.idplan
                        LEFT JOIN planesfuentes ON planes.idplan = planesfuentes.idplan
                        LEFT JOIN planespaises ON planes.idplan = planespaises.idplan 
                        LEFT JOIN planesagencias ON planes.idplan = planesagencias.idplan
                        LEFT JOIN categorias ON planes.idcategoria = categorias.idcategoria
                        LEFT JOIN popularidades ON planes.idpopularidad = popularidades.idpopularidad
                        LEFT JOIN monedas ON planes.idmonedapago = monedas.idmoneda
                        WHERE planes.idstatus = 1
                        AND ($dias BETWEEN planes.tiempominimo AND planes.tiempomaximo)
                        AND planes.idcategoria = $idcategoria
                        AND categorias.idtipoasistencia = $idtipoasistencia
                        AND planesfuentes.idfuente = $idfuente
                        AND planespaises.idpais = $idpais
                        AND planesagencias.idagencia = $idagencia
                        AND planesorigenes.idpais IN ($origen)
                        AND planesdestinos.idpais IN ($destinos_implode)
                        AND $edadminima >= planes.edadminima 
                        AND $edadmaxima <= planes.edadmaxima
                        $condicion_plan_familiar
                        $condicion_planes_precompra
                        ORDER BY 
                            planes.idpopularidad DESC,
                            nombreplan ASC,
                            planes.idplan ASC
                        ";

    // if($idcategoria == 23)
    // {
    //     echo $select; exit;
    // }

    echo $select; exit;

    $planes = ejecuta_select($db, $select);

    // print_r($planes); exit;

    $id = 0;
    foreach ($planes['resultado'] as $plan) 
    {
        $idplan                                     = $plan['idplan'];
        $edadprecioincremento                       = $plan['edadprecioincremento'];
        $factorpenalizacionedad                     = $plan['factorpenalizacionedad'];
        $validamontoviaje                           = $plan['validamontoviaje'];

        // PLATAFORMAS DE PAGO
            $plataformaspagoasignadas   = [];
            $plataformaspago            = ejecuta_select($db, "SELECT planesplataformaspago.idplataformapago FROM planesplataformaspago WHERE planesplataformaspago.idplan = $idplan ");
            foreach ($plataformaspago['resultado'] as $plataforma) array_push($plataformaspagoasignadas, $plataforma['idplataformapago']);

        //BENEFICIOS 
            $select = "SELECT   planesbeneficios.idbeneficio,
                                planesbeneficios.cobertura,
                                planesbeneficios.coberturaen,
                                planesbeneficios.orden,
                                beneficios.nombrebeneficio,
                                beneficios.nombrebeneficioen
                    FROM planesbeneficios
                    LEFT JOIN beneficios ON planesbeneficios.idbeneficio = beneficios.idbeneficio
                    WHERE planesbeneficios.idplan = $idplan
                    AND beneficios.idstatus = 1 
                    AND beneficios.idtipoasistencia = $idtipoasistencia
                    AND beneficios.edadminima <= $edadminima
                    AND beneficios.edadmaxima >= $edadmaxima 
                    ";


        $beneficiosasignados = ejecuta_select($db, $select);

        $contador_beneficio = 0;

        // REVISAR EL TEMA DE LA CATEGORIA ANUALES MULTIVIAJES PORQUE DEBERIAN APARECER TODOS LOS PLANES (30,60,90)
            if($idcategoria == 23)
            {
                if($dias <= 30)                 $dias = 30;
                if($dias >= 31 && $dias <= 60)  $dias = 60; 
                if($dias >= 61)                 $dias = 90; 
            }

            //PRECIOS 
                $select = "SELECT   precio
                            FROM planesprecios 
                            WHERE idplan = $idplan
                            AND idpais = $idpais
                            AND dia = $dias
                        ";

                // echo $select; exit;

                $precios = ejecuta_select($db, $select);

        if($precios['cantidad'] > 0)
        {
            $preciofinal                    = 0;
            $precioincrementoedad           = 0;
            $cantidadpasajerossinincremento = 0;
            $cantidadpasajerosconincremento = 0;

            // echo $planfamiliar; exit;
    
            if($planfamiliar)
            {
                $edadmaximaplanfamiliar = ejecuta_select($db, "SELECT valor FROM configuracion WHERE nombreconfiguracion = 'edadmaximaplanfamiliar' ", "valor");
    
                $menores = 0;
                $mayores = 0;
    
                foreach ($edades as $edad) 
                {
                    if ($edad <= $edadmaximaplanfamiliar) {
                        $menores++;
                    } else {
                        $mayores++;
                    }
                }

                if($menores <= 4 && $mayores == 2)
                {
                    $factorbeneficiofamiliar = ejecuta_select($db, "SELECT factorbeneficiofamiliar FROM planes WHERE idplan = $idplan", "factorbeneficiofamiliar");
                    $preciofinal = $precios['resultado'][0]['precio'] * $factorbeneficiofamiliar;
                }
            }
            else
            {
                foreach ($edades as $edad) 
                {
                    if ($edad >= $edadprecioincremento) 
                    {
                        $cantidadpasajerosconincremento++;
                        $precioincrementoedad = $precios['resultado'][0]['precio'] * $factorpenalizacionedad;
                        $preciofinal = $preciofinal + $precioincrementoedad;
                    } 
                    else 
                    {
                        $cantidadpasajerossinincremento++;
                        $preciofinal = $preciofinal + $precios['resultado'][0]['precio'];
                    }
                }
            }

            if($validamontoviaje == 't' && $idmontoviaje)
            {
                $montoviaje = ejecuta_select($db, "SELECT valormontoviaje FROM categoriasmontosviajes WHERE idmontoviaje = $idmontoviaje", "valormontoviaje");

                $preciofinal            = ($preciofinal * $montoviaje) / 100;
                $precio_individual      = (number_format($precios['resultado'][0]['precio'], 2, '.', '')  * number_format($montoviaje, 2, '.', '') ) / 100;
               
                $precioincrementoedad   = ($precioincrementoedad * $montoviaje) / 100; 

                $planes['resultado'][$id]['plataformaspagoasignadas']           = $plataformaspagoasignadas;
                $planes['resultado'][$id]['beneficiosasignados']                = ($beneficiosasignados['cantidad'] > 0) ? $beneficiosasignados['resultado'] : array();
                $planes['resultado'][$id]['precio_grupal']                      = strval(number_format($preciofinal, 2, '.', ''));
                $planes['resultado'][$id]['precioindividual']                   = ($precios['cantidad'] > 0) ? strval(number_format($precio_individual, 2, '.', '')) : null;
                $planes['resultado'][$id]['precioincrementoedad']               = strval(number_format($precioincrementoedad, 2, '.', ''));
                $planes['resultado'][$id]['cantidadpasajerossinincremento']     = strval($cantidadpasajerossinincremento);
                $planes['resultado'][$id]['cantidadpasajerosconincremento']     = strval($cantidadpasajerosconincremento);
            }
            else
            {
                $planes['resultado'][$id]['plataformaspagoasignadas']           = $plataformaspagoasignadas;
                $planes['resultado'][$id]['beneficiosasignados']                = ($beneficiosasignados['cantidad'] > 0) ? $beneficiosasignados['resultado'] : array();
                $planes['resultado'][$id]['precio_grupal']                      = strval(number_format($preciofinal, 2, '.', ''));
                $planes['resultado'][$id]['precioindividual']                   = ($precios['cantidad'] > 0) ? strval(number_format($precios['resultado'][0]['precio'], 2, '.', '')) : null;
                $planes['resultado'][$id]['precioincrementoedad']               = strval(number_format($precioincrementoedad, 2, '.', ''));
                $planes['resultado'][$id]['cantidadpasajerossinincremento']     = strval($cantidadpasajerossinincremento);
                $planes['resultado'][$id]['cantidadpasajerosconincremento']     = strval($cantidadpasajerosconincremento);
            }

            // VALIDACION DE PRECIOS: SI LOS PRECIOS ESTAN EN CERO EL PLAN NO ES ENVIADO
                if($planes['resultado'][$id]['precio_grupal'] == 0)
                {
                    unset($planes['resultado'][$id]);
                    $planes['cantidad'] = $planes['cantidad'] - 1;
                }            
        }
        else
        {
            unset($planes['resultado'][$id]);
            $planes['cantidad'] = $planes['cantidad'] - 1;
        }

        $id++;
    }



    // NO BORRAR: VALIDACION DE LOS MONTOS RESTANTES DE LAS PRECOMPRAS
        // if($idcategoria == 32 && $planes['cantidad'] > 0)
        // {
        //     $contador_plan = 0;
        //     foreach($planes['resultado'] as $plan)
        //     {
        //         $idplan = $plan['idplan'];

        //         $precompras = ejecuta_select($db, "SELECT idprecompra FROM precomprasplanes WHERE idplan = $idplan");

        //         if($precompras['cantidad'] > 0)
        //         {
        //             foreach($precompras['resultado'] as $precompra)
        //             {
        //                 $idprecompra = $precompra['idprecompra'];
                        
        //                 $datos_precompra = select_precompra($db, $idprecompra);

        //                 if($datos_precompra['cantidad'] > 0)
        //                 {
        //                     if($datos_precompra['resultado'][0]['idstatus'] != 1 || $datos_precompra['resultado'][0]['restante'] < $planes['resultado'][$contador_plan]['precio_grupal'])
        //                     {
        //                         unset($planes['resultado'][$contador_plan]);
        //                         $planes['cantidad'] = $planes['cantidad'] - 1;
        //                     }
        //                 }
        //             }
        //         }
        //         $contador_plan++;
        //     }
        // }

        // if($idcategoria == 32)
        // {
        //     print_r($planes); exit;

        // }

        // echo 'Aqui'; exit;


    if($planes['cantidad'] > 0) 
    {
        $array_planes['resultado'] = array();

        foreach($planes['resultado'] as $plan)
        {
            array_push($array_planes['resultado'], $plan);
        }

        $array_planes['cantidad']     = count($array_planes['resultado']);
        $array_planes['error']        = false;
    }
    else
    {
        $array_planes['resultado']    = array();
        $array_planes['cantidad']     = 0;
        $array_planes['error']        = false;
    }

    return $array_planes;
    
}

function select_beneficio_adicional($db, $idbeneficioadicional)
{
    $result = ejecuta_select($db, "SELECT idbeneficioadicional, 
                                        nombrebeneficioadicional, 
                                        idstatus, 
                                        fechamodificacion, 
                                        edadminima, 
                                        edadmaxima, 
                                        descripcionbeneficioadicional, 
                                        idfamilia, 
                                        nombrebeneficioadicionalen, 
                                        descripcionbeneficioadicionalen, 
                                        idtipoasistencia
                                    FROM beneficiosadicionales
                                    WHERE idbeneficioadicional = $idbeneficioadicional
                            ");

    // $id = 0;

    // foreach($result['resultado'] as $categoria)
    // {
    //     $idcategoria                = $categoria['idcategoria'];
    //     $fuentesasignadas           = [];
    //     $paisesasignados            = [];
    //     $agenciasasignadas          = [];
    //     $origenesasignados          = [];
    //     $destinosasignados          = [];
       
    //     //FUENTES
    //         $fuentes = ejecuta_select($db, "SELECT categoriasfuentes.idfuente FROM categoriasfuentes WHERE categoriasfuentes.idcategoria = $idcategoria ");
    //         foreach($fuentes['resultado'] as $fuente) array_push($fuentesasignadas, $fuente['idfuente']);

    //     //PAISES
    //         $paises = ejecuta_select($db, "SELECT categoriaspaises.idpais FROM categoriaspaises WHERE categoriaspaises.idcategoria = $idcategoria ");
    //         foreach($paises['resultado'] as $pais) array_push($paisesasignados, $pais['idpais']);

    //     //AGENCIAS
    //         $agencias = ejecuta_select($db, "SELECT categoriasagencias.idagencia FROM categoriasagencias WHERE categoriasagencias.idcategoria = $idcategoria ");
    //         foreach($agencias['resultado'] as $agencia) array_push($agenciasasignadas, $agencia['idagencia']);

    //     //ORIGENES
    //         $origenes = ejecuta_select($db, "SELECT categoriasorigenes.idpais FROM categoriasorigenes WHERE categoriasorigenes.idcategoria = $idcategoria ");
    //         foreach($origenes['resultado'] as $origen) array_push($origenesasignados, $origen['idpais']);
        
    //     //ORIGENES
    //         $destinos = ejecuta_select($db, "SELECT categoriasdestinos.idpais FROM categoriasdestinos WHERE categoriasdestinos.idcategoria = $idcategoria ");
    //         foreach($destinos['resultado'] as $destino) array_push($destinosasignados, $destino['idpais']);

    //     $result['resultado'][$id]['fuentesasignadas']                   = $fuentesasignadas;
    //     $result['resultado'][$id]['paisesasignados']                    = $paisesasignados;
    //     $result['resultado'][$id]['agenciasasignadas']                  = $agenciasasignadas;
    //     $result['resultado'][$id]['origenesasignados']                  = $origenesasignados;
    //     $result['resultado'][$id]['destinosasignados']                  = $destinosasignados;
        
    //     $id++;
    // }

    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function consulta_precompra_disponible($db, $idagencia, $idplan, $total)
{
    $precompras = ejecuta_select($db, "SELECT precompras.idprecompra, ordenes.total FROM ordenes, precompras WHERE ordenes.idagencia = $idagencia AND ordenes.idstatus = 1 and ordenes.cargaprecompra = true AND ordenes.idorden = precompras.idorden");
    
    foreach($precompras['resultado'] as $precompra)
    {
        $idprecompra 	= $precompra['idprecompra'];
        $carga_inicial 	= $precompra['total'];

        $cantidad_orden_plan_precompra 	= ejecuta_select($db, "SELECT count(*) as cantidad FROM precomprasplanes WHERE idprecompra = $idprecompra AND idplan = $idplan", 'cantidad' );
        
        if($cantidad_orden_plan_precompra > 0)
        {
            $consumido  = ejecuta_select($db, "SELECT SUM(total) as consumido FROM ordenes WHERE idprecompra = $idprecompra AND idstatus = 1 ", 'consumido');
            $restante   = $carga_inicial - $consumido;

            if(($restante - $total) > 0)
            {
                return $idprecompra;
            }
        }
    }
}

function select_reportes($db, $paginador, $include_conf = true)
{
    $busqueda           = ($paginador != null) ? $paginador['busqueda'] : '';
    $paginadorlimite    = ($paginador != null) ? $paginador['paginadorlimite'] : 0;
    $paginadorinicio    = ($paginador != null) ? $paginador['paginadorinicio'] : 0;
    $paginacion         = ($paginadorlimite > 0) ? ' LIMIT '.$paginadorlimite.' OFFSET '.$paginadorinicio : ' ';

    for($contador = 0; $contador <= 1; $contador++)
    {
        $paginacion = ($contador == 0) ? $paginacion : '';
        
        $sql = "SELECT 
                    reportes.idreporte,
                    reportes.nombrereporte,
                    reportes.idstatus,
                    reportes.tiporeporte,
                    (case when reportes.configuracion is not null then 't' else 'f' end) as configuracionreporte,
                    status.nombrestatus
                FROM reportes, status
                WHERE reportes.idstatus = status.idstatus
                $busqueda
                ORDER BY  reportes.idreporte DESC
                $paginacion
                ";

        if($contador == 0) 
        {
            $result = ejecuta_select($db, $sql);
        }
        else
        {
            $cantidad = ejecuta_select($db, $sql);
            $result['cantidad'] = ($busqueda != '') ? $cantidad['cantidad'] : consulta_cantidad($db, "reportes");
        }
    }



    $result['resultado'] = ($result['cantidad'] > 0) ? $result['resultado'] : array();

    return $result;
}

function select_reporte($db, $idreporte)
{
    $result = ejecuta_select($db, "SELECT *
                                    FROM reportes
                                    WHERE reportes.idreporte = $idreporte ");
    
    if($result['cantidad'] > 0)
    {
        $result['resultado'][0]['configuracion'] = ($result['resultado'][0]['configuracion'] != null) ? json_decode($result['resultado'][0]['configuracion']) : array();
    }
    else
    {
        $result['resultado'] = array();
    }

        
    return $result;
}




?>
