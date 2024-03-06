<?php
    $db_postgresql      = getDBReportes();
    $db_mysql           = connect_db();

    system ('clear');

    $hora_inicio        = date('h:i:s', time());

    echo '
    Inicio: '.$hora_inicio.' 
';
//$migraraño= '2023';

/* $select = "SELECT * from orders b where id =898517 ";
$mysql_ = $db_mysql->query($select);
     while ($row = $mysql_->fetch_array(MYSQLI_ASSOC)) 
     {
         $registros[] = $row;
     } */
 // ORDENES *******************************************************************************************************************************************************************************
 echo '
 Migrando Tabla: ordenes...';
 
     $registros = array();
 
     $contador_ordenes                                       = 0;
     $contador_ordenes_rechazadas                            = 0;
     $contador_asistencias_rechazadas                        = 0;
     $contador_ordenes_con_agencia_cero                      = 0;
     $contador_ordenes_corporativas                          = 0;
     $contador_cargas_manuales                               = 0;
     $contador_ordenes_con_total_en_cero                     = 0;
     $contador_ordenes_corporativas_no_validas               = 0;
     $contador_asistencias_viajes_insertadas                 = 0;
     $contador_beneficiarios_viajes_insertados               = 0;
     $contador_beneficiarios_viajes_corporativos_insertados  = 0;
     $contador_emisiones_precompras                          = 0;
 
     $select = "SELECT  
                     id as idorden,
                     1 as idtipoasistencia,
                     COALESCE(status, 4) as idstatus,
                     COALESCE(codigo, 'XX-XXXX-XX') as codigovoucher,
                     agencia as idagencia,
                     COALESCE(cod_corp, 'NULL') as idcorporativo,
                     COALESCE(tasa_cambio, 1) as idmoneda,
                     total as total,
                     COALESCE(es_emision_corp, 0) as emisioncorporativa,
                     COALESCE(manual, 0) as cargamanual,
                     COALESCE(IF(cupon = '', 'NULL', cupon), 'NULL') as idcupon,
                     IF(fecha = '0000-00-00 00:00:00', '2000-01-01 00:00:00', COALESCE(fecha, '2000-01-01 00:00:00')) as fechacreacion,
                     IF(hora = '0000-00-00 00:00:00', '2000-01-01 00:00:00', COALESCE(hora, '2000-01-01 00:00:00')) as fechamodificacion,
                     COALESCE(vendedor, 293) as idusuario,
                     COALESCE(forma_pago, 1) as idplataformapago,
                     CAST(CONVERT(credito_tipo USING utf8) AS binary) as tdctipo,
                     CAST(CONVERT(credito_numero USING utf8) AS binary) as tdcnumero,
                     CAST(CONVERT(credito_nombre USING utf8) AS binary) as tdctitular,
                     CAST(CONVERT(credito_expira USING utf8) AS binary) as tdcexpiracion,
                     CAST(CONVERT(response USING utf8) AS binary) as respuestapago,
                     CAST(CONVERT(referencia USING utf8) AS binary) as referencia,
                     1 as idsistema,
                     1 as idempresa,
                     CASE
                         WHEN fuente = 0 THEN 1
                         WHEN fuente = 1 THEN 2
                         WHEN fuente = 2 THEN 4
                         WHEN fuente = 3 THEN 5
                         WHEN fuente = 4 THEN 3
                         ELSE 1
                     END as idfuente,
                     COALESCE(origin_ip, '0.0.0.0') as ip,
                     CAST(CONVERT(comentarios USING utf8) AS binary) as comentarios,
                     IF(programaplan = 32 AND salida = '0000-00-00', 1, 0) as cargaprecompra,
                     0 as idprecompra,
                     tiempo_x_producto as tiempoproducto,
                     IF( origen = '', 'US', COALESCE( origen, 'US' ) ) AS idorigen,
                     CASE
                         WHEN destino = 1 THEN 279
                         WHEN destino = 2 THEN 47
                         WHEN destino = 3 THEN 280
                         ELSE 47
                     END as destinos,
                     salida as fechadesde,
                     retorno as fechahasta,
                     programaplan as idcategoria,
                     producto as idplan,
                     COALESCE(family_plan, 0) as planfamiliar,
                     incentivo_porc as porcentajeincentivo,
                     incentivo_usd as montoincentivo,
                     nivel1,
                     nivel2,
                     nivel3,
                     nivel4,
                     nivel1_porc,
                     nivel2_porc,
                     nivel3_porc,
                     nivel4_porc,
                     nivel1_usd,
                     nivel2_usd,
                     nivel3_usd,
                     nivel4_usd,
                     CAST(CONVERT(nombre_contacto USING utf8) AS binary) as nombrecontacto, 
                     CAST(CONVERT(email_contacto USING utf8) AS binary) as correocontacto, 
                     CAST(CONVERT(telefono_contacto USING utf8) AS binary) as telefonocontacto, 
                     neto_prov as costo1,
                     neto_prov2 as costo2,
                     neto_prov3 as costo3,
                     neto_prov4 as costo4,
                     neto_prov5 as costo5,
                     neto_prov6 as costo6,
                     CASE
                         WHEN tasa_cambio = 1 THEN 'USD'
                         WHEN tasa_cambio = 2 THEN 'MXN'
                         WHEN tasa_cambio = 3 THEN 'COP'
                         ELSE 'AME'
                     END as moneda_,
                     COALESCE((SELECT DISTINCT valor FROM exchange where DATE_FORMAT(exchange.horainsert, '%Y-%m-%d')= orders.fecha and DATE_FORMAT(exchange.horabanco, '%Y-%m-%d')= orders.fecha and exchange.currency = moneda_ and exchange.tipo = 1 order by 1 desc LIMIT 1 ),1) as cambio
                 FROM orders 
                 WHERE (orders.status IN (1,2,4) AND orders.retorno >= '2023-01-01' AND orders.nombre_contacto NOT LIKE '%PRUEBA%')
                 OR (orders.status IN (1,2,4) AND orders.fecha >= '2023-01-01'  AND orders.nombre_contacto NOT LIKE '%PRUEBA%')
                 OR (orders.status IN (1,2,4) AND orders.programaplan IN (14) AND orders.cantidad > 0  AND orders.fecha >= '2023-01-01'  AND orders.nombre_contacto NOT LIKE '%PRUEBA%') 
                 OR (orders.status IN (1,2,4) AND orders.programaplan IN (32) AND orders.fecha >= '2023-01-01'  AND orders.nombre_contacto NOT LIKE '%PRUEBA%')
                 ORDER BY id ASC
             ";

 
     $mysql_ = $db_mysql->query($select);
     while ($row = $mysql_->fetch_array(MYSQLI_ASSOC)) 
     {
         $registros[] = $row;
     }

     // Filtra los registros según la condición 
    $registrosFiltrados = array_filter($registros, function($registro) {
        return $registro['idagencia'] !=  0 && $registro['idorden'] >  0 && $registro['idcategoria'] >  0;
    });

   

    $array_valores = array();
    $array_comisiones = array();
    $array_costos = array();
    $array_contactos = array();

    // Iterar sobre $registrosFiltrados 
    foreach($registrosFiltrados as $registro) {
        $idorden                = $registro['idorden'];
        $idtipoasistencia       = $registro['idtipoasistencia'];
        $idplan                 = $registro['idplan'];
        $idstatus = $registro['idstatus'] ==  0 ?  2 : ($registro['idstatus'] ==  2 ?  9 : $registro['idstatus']);
       
        $codigovoucher          = $registro['codigovoucher'];
        $idagencia              = $registro['idagencia'];
        $idcorporativo          = $registro['idcorporativo'];
        $idmoneda               = $registro['idmoneda'];
        $total                  = $registro['total'];
        $emisioncorporativa     = $registro['emisioncorporativa'];
        $cargamanual            = $registro['cargamanual'];
        $idcupon                = $registro['idcupon'];
        $fechacreacion          = $registro['fechacreacion'];
        $fechamodificacion      = $registro['fechamodificacion'];
        $idusuario              = ($registro['idusuario'] == 0) ? 1076 : $registro['idusuario'];
        $idplataformapago       = $registro['idplataformapago'];
        $tdctipo                = $registro['tdctipo'];
        $tdcnumero              = $registro['tdcnumero'];
        $tdctitular             = $registro['tdctitular'];
        $tdcexpiracion          = $registro['tdcexpiracion'];
        $respuestapago          = $registro['respuestapago'];
        $referencia             = $registro['referencia'];
        $idsistema              = $registro['idsistema'];
        $idempresa              = $registro['idempresa'];
        $idfuente               = $registro['idfuente'];
        $ip                     = $registro['ip'];
        $comentarios            = $registro['comentarios'];
        $cargaprecompra         = $registro['cargaprecompra'];
        $idprecompra            = $registro['idprecompra'];
        $tiempoproducto         = $registro['tiempoproducto'];

        $nombrecontacto         = str_replace("'", "", $registro['nombrecontacto']);
        $correocontacto         = $registro['correocontacto'];
        $telefonocontacto       = str_replace("'", "", $registro['telefonocontacto']);

        $costo1                 = $registro['costo1'];
        $costo2                 = $registro['costo2'];

        $porcentajeincentivo    = $registro['porcentajeincentivo'];
        $montoincentivo         = $registro['montoincentivo'];

        $idagencianivel1        = $registro['nivel1'];
        $idagencianivel2        = $registro['nivel2'];
        $idagencianivel3        = $registro['nivel3'];
        $idagencianivel4        = $registro['nivel4'];

        $porcentajenivel1       = $registro['nivel1_porc'];
        $porcentajenivel2       = $registro['nivel2_porc'];
        $porcentajenivel3       = $registro['nivel3_porc'];
        $porcentajenivel4       = $registro['nivel4_porc'];

        $montonivel1            = $registro['nivel1_usd'];
        $montonivel2            = $registro['nivel2_usd'];
        $montonivel3            = $registro['nivel3_usd'];
        $montonivel4            = $registro['nivel4_usd'];
        
        $tasacambio            = $registro['cambio'];

        $valor = " (
            $idorden,                
            $idtipoasistencia,             
            $idstatus,               
            '$codigovoucher',          
            $idagencia,              
            $idcorporativo,          
            $idmoneda,               
            $total,                  
            '$emisioncorporativa',     
            '$cargamanual',            
            $idcupon,                
            '$fechacreacion',          
            '$fechamodificacion',      
            $idusuario,              
            $idplataformapago,       
            '$tdctipo',                
            '$tdcnumero',              
            '$tdctitular',             
            '$tdcexpiracion',          
            '$respuestapago',          
            '$referencia',             
            $idsistema,              
            $idempresa,              
            $idfuente,               
            '$ip',                     
            '$comentarios',            
            '$cargaprecompra',         
            $idprecompra,
            $tiempoproducto,
            $porcentajeincentivo, 
            $montoincentivo,
            $tasacambio 
           )";

        
           // COMISIONES
            $contador_comisiones =  1;
            while ($contador_comisiones <=  4) {
                $idagencia     = 'idagencianivel'.$contador_comisiones;
                $idagencia     = $$idagencia;

                $porcentaje    = 'porcentajenivel'.$contador_comisiones;
                $porcentaje    = $$porcentaje;
                
                $monto         = 'montonivel'.$contador_comisiones;
                $monto         = $$monto;

                $valor_ordenes_comision= " ($idorden, $idagencia, $contador_comisiones, $porcentaje, $monto)";
                $array_comisiones[] = $valor_ordenes_comision;

                $contador_comisiones++;
            }          
            

            //COSTOS 
            $contador_costos = 1;
            while($contador_costos <= 2)
            {
                $costo     = 'costo'.$contador_costos;
                $costo     = $$costo;

                $valor_ordenes_costos = " ( $idorden, $contador_costos, $costo )";
                $array_costos[] = $valor_ordenes_costos;
               
               $contador_costos++;
            }


            //CONTACTOS
            $valor_ordenes_contactos = " ( $idorden, NULL,'$nombrecontacto', '$correocontacto', '$telefonocontacto')";

    
        // Agrega el array de valores al array principal
        $array_valores[] = $valor;
        // Agrega al array de contactos
        $array_contactos[] =$valor_ordenes_contactos;

    }


    $array_asistenciasviajes= array();
    $array_beneficiarios = array();
    $array_beneficio_adicional = array();
    $array_beneficiarios_costos= array();
    $registros_asistencias_viajes = array();
    $array_asistenciascorporativas =array();
    $array_asistenciascorporativasviajes =array();
    $registros_asistencias_corporativas = array();
    $array_precompras = array();


    // //ASISTENCIAS VIAJES
    $registros_asistencias_viajes = array_filter($registrosFiltrados, function($registro) {
        return $registro['fechadesde'] != '0000-00-00  00:00:00'   
            && $registro['fechadesde'] != '0000-00-00'   
            && $registro['fechahasta'] != '0000-00-00  00:00:00'   
            && $registro['fechahasta'] != '0000-00-00'   
            && $registro['idcategoria'] != null
            && $registro['idplan'] != null
            && $registro['idcategoria'] !=  32;
    });
    $idordenes = array_map(function($registro) {
        return $registro['idorden'];
    }, $registros_asistencias_viajes);

    $idordenes = implode(",", $idordenes);


    foreach ($registros_asistencias_viajes as $registro)
    {
        $idorden        = $registro['idorden'];
        $fechadesde     = $registro['fechadesde'];
        $fechahasta     = $registro['fechahasta'];
        
        $origen         = ($registro['idorigen'] == '1S' || $registro['idorigen'] == 'US' || $registro['idorigen'] == ''  )  ? 'COM' : $registro['idorigen'];
        $origen         = $origen == 'AN' ? 'AG' : $origen;
        $select_pais    = ($registro['idorigen'] == '') ? "SELECT agencias.idpais as idpais FROM agencias WHERE agencias.idagencia = $idagencia" : "SELECT idpais FROM paises WHERE codigopais = '$origen'";
        $idorigen       = ejecuta_select($db_postgresql, $select_pais, "idpais");
        $idorigen       = ($idorigen == 0) ? 99 : $idorigen;
        $destinos       = ($registro['destinos'] == '') ? 'AME' : $registro['destinos'];
        $idcategoria    = $registro['idcategoria'];
        $idplan         = $registro['idplan'];
        $planfamiliar   = $registro['planfamiliar'] == '' ? 'f' : $registro['planfamiliar'];
        $comentarios    = $registro['comentarios'];


        $valor_asistenciasviajes = " (
                $idorden, 
                '$fechadesde', 
                '$fechahasta', 
                $idorigen, 
                '$destinos', 
                $idcategoria, 
                $idplan, 
                '$planfamiliar', 
                '$comentarios'
            )";

            //Llenar array asistencias viajes     
            $array_asistenciasviajes []= $valor_asistenciasviajes; 

    }


    $select_beneficiarios = "SELECT  
        id as idbeneficiario,
        id_orden as idorden,
        CAST(CONVERT(nombre USING utf8) AS binary) as nombrebeneficiario,
        CAST(CONVERT(apellido USING utf8) AS binary) as apellidobeneficiario,
        CAST(CONVERT(email USING utf8) AS binary) as correobeneficiario,
        CAST(CONVERT(telefono USING utf8) AS binary) as telefono,
        IF(nacimiento = '0000-00-00', NULL, CAST(CONVERT(nacimiento USING utf8) AS binary)) as fechanacimiento,
        CAST(CONVERT(documento USING utf8) AS binary) as documentacion,
        IF(status != 1, 2, status) as idstatus,
        COALESCE(precio_vta, 0) as precioventa,
        COALESCE(precio_cost, 0) as costo1,
        COALESCE(precio_cost2, 0) as costo2,
        id_rider as beneficio1,
        precio_cost_sp as costobeneficio1,
        id_rider2 as beneficio2,
        precio_cost_sp2 as costobeneficio2,
        cancel_precio,
        cancel_monto,
        cancel_cobertura
    FROM beneficiaries
    WHERE id_orden in ($idordenes)
    ORDER BY id ASC
    ";


    $mysql_beneficiarios = $db_mysql->query($select_beneficiarios);

    while ($row_beneficiarios = $mysql_beneficiarios->fetch_array(MYSQLI_ASSOC)) 
        {
        $row_array_beneficiarios[] = $row_beneficiarios;

        }
            



    if(count($row_array_beneficiarios) > 0)
    {
        $lastIdOrden = null; // Variable para almacenar el último idorden procesado
    
        foreach($row_array_beneficiarios as $beneficiario)
        {                                    
                $idbeneficiario         = $beneficiario['idbeneficiario'];
                $idorden                = $beneficiario['idorden'];
                $nombrebeneficiario     = str_replace("'", "", $beneficiario['nombrebeneficiario']);
                $apellidobeneficiario   = str_replace("'", "", $beneficiario['apellidobeneficiario']);
                $correobeneficiario     = $beneficiario['correobeneficiario'];
                $telefono               = str_replace("'", "", $beneficiario['telefono']);
                $fechanacimiento        = $beneficiario['fechanacimiento'];
                $documentacion          = str_replace("'", "", $beneficiario['documentacion']);
                $idstatus               = ($beneficiario['idstatus'] == 0) ? 2 : $beneficiario['idstatus'];
                $precioventa            = $beneficiario['precioventa'];
                $costo1                 = $beneficiario['costo1'];
                $costo2                 = $beneficiario['costo2'];
                $id_rider               = $beneficiario['beneficio1'];
                $costobeneficio1        = $beneficiario['costobeneficio1'];
                $id_rider2              = $beneficiario['beneficio2'];
                $costobeneficio2        = $beneficiario['costobeneficio2'];
                $cancel_precio          = $beneficiario['cancel_precio'];
                $cancel_monto           = $beneficiario['cancel_monto'];
                $cancel_cobertura       = $beneficiario['cancel_cobertura'];

                $nombrebeneficiario     = str_replace(";", " ", $nombrebeneficiario);
                $apellidobeneficiario   = str_replace(";", " ", $apellidobeneficiario);
                if ($idorden != $lastIdOrden) {
                    $consecutivo =  1; // Reinicia el consecutivo si idorden ha cambiado
                }else 
                {
                    $consecutivo++; // Incrementa el consecutivo si idorden es igual al anterior
                }
                
                // valida apellido, se toma como apellido los dos ultimos elementos del explode    
                if ($apellidobeneficiario == 'notprovided') {
                    $exp_nombrebeneficiario = explode(" ", $nombrebeneficiario);
                    $count = count($exp_nombrebeneficiario);
                    if ($count >   1) {
                        $nombrebeneficiario = implode(' ', array_slice($exp_nombrebeneficiario,   0, -2));
                        $apellidobeneficiario = implode(' ', array_slice($exp_nombrebeneficiario, -2));
                    } else {
                        $nombrebeneficiario = $exp_nombrebeneficiario[0];
                        $apellidobeneficiario = '';
                    }
                }

            $valores_beneficiarios = "(
                    $idbeneficiario,
                    $idorden,
                    NULL,
                    UPPER('$nombrebeneficiario'),
                    UPPER('$apellidobeneficiario'),
                    LOWER('$correobeneficiario'),
                    '$telefono',
                    " . ($beneficiario['fechanacimiento'] == NULL || $beneficiario['fechanacimiento'] == 'NULL' ? "NULL" : "'$fechanacimiento'") . ",
                    '$documentacion',
                    $idstatus,
                    $precioventa,
                    $consecutivo,
                    NULL,
                    NULL  
            )";

            $array_beneficiarios [] = $valores_beneficiarios;
            
        
            
                
                    //COSTOS 
                        $contador_costo = 1;
                        while($contador_costo <= 2)
                        {
                            $costo     = 'costo'.$contador_costo;
                            $costo     = $$costo;

                            $valores_beneficarios_costos = "(
                                                            $idbeneficiario,
                                                            $contador_costo,
                                                            $costo
                                                        )";
                            $array_beneficiarios_costos [] = $valores_beneficarios_costos;

                            $contador_costo++;
                        }

                    
                    //BENEFICIOS ADICIONALES
                        if($id_rider > 0 && $costobeneficio1 > 0)
                        {
                            $insert_beneficio_adicional = "( $idbeneficiario,
                                                            $id_rider,
                                                            $costobeneficio1,
                                                            NULL,NULL )"; 
                            $array_beneficio_adicional[] = $insert_beneficio_adicional;
                        }

                        if($id_rider2 > 0 && $costobeneficio2 > 0)
                        {
                            $insert_beneficio_adicional = "(
                                                            $idbeneficiario,
                                                            $id_rider2,
                                                            $costobeneficio2,
                                                            NULL,NULL
                                                            )";
                            $array_beneficio_adicional[] = $insert_beneficio_adicional;
                        }

                        if($cancel_precio > 0)
                        {
                            $insert_beneficio_adicional = "(
                                                                $idbeneficiario,
                                                                38,
                                                                $cancel_precio,
                                                                $cancel_monto,
                                                                $cancel_cobertura
                                                            ) ";
                            $array_beneficio_adicional[] = $insert_beneficio_adicional;

                        }


                    $contador_beneficiarios_viajes_insertados++;
                
                    $lastIdOrden = $idorden; // Actualiza la última idorden procesada
        }
    }



unset($row_array_beneficiarios); 
unset($idordenes);

//ASISTENCIAS CORPORATIVAS
$registros_asistencias_corporativas = array_filter($registrosFiltrados, function($registro) {
    return $registro['emisioncorporativa'] == 1 && $registro['fechadesde'] == '0000-00-00';
});
$idordenescorporativas = array_map(function($registro) {
    return $registro['idorden'];
}, $registros_asistencias_corporativas);

$idordenescorporativas = implode(",", $idordenescorporativas);



foreach ($registros_asistencias_corporativas as  $registro) {

    $idorden                = $registro['idorden'];
    $idplan                 = $registro['idplan'];
    $tiempoproducto         = $registro['tiempoproducto'];

    $valor_asistenciacorporativa = "(
        $idorden,
        $idplan,
        $tiempoproducto )" ;

        $array_asistenciascorporativas []= $valor_asistenciacorporativa;
}

// SELECT EMISIONES
$select_asistenciacorporativa = "SELECT  
            id as idasistenciacorporativaviaje,
            orden as idorden,
            salida as fechadesde,
            retorno as fechahasta,
            origen as idorigen,
            CASE
                WHEN destino = 1 THEN  279
                WHEN destino = 2 THEN 47
                WHEN destino = 3 THEN 280
                ELSE 47
            END as destinos,
            codigo as codigovoucheremision,
            fecha as fechacreacion,
            hora as fechamodificacion,
            IF(vendedor = 0, 1076, vendedor) as idagente,
            status as idstatus,
            COALESCE((SELECT family_plan from orders where orders.id = emisiones.orden ), 0) as planfamiliar,
            '' as comentarios,
            CAST(CONVERT(nombre_contacto USING utf8) AS binary) as nombrecontacto, 
            CAST(CONVERT(email_contacto USING utf8) AS binary) as correocontacto, 
            CAST(CONVERT(telefono_contacto USING utf8) AS binary) as telefonocontacto
            FROM emisiones
            WHERE orden IN ($idordenescorporativas)
            ";

$mysql_asistenciacorporativa = $db_mysql->query($select_asistenciacorporativa);

while ($row_asistenciacorporativas = $mysql_asistenciacorporativa->fetch_array(MYSQLI_ASSOC)) 
{
$row_asistenciacorporativa[] = $row_asistenciacorporativas;
}


if(count($row_asistenciacorporativa) > 0)
{
    foreach($row_asistenciacorporativa as $asistenciacorporativa)
    {
        $idasistenciacorporativaviaje   = $asistenciacorporativa['idasistenciacorporativaviaje'];
        $idorden                        = $asistenciacorporativa['idorden'];
        $fechadesde                     = $asistenciacorporativa['fechadesde'];
        $fechahasta                     = ($asistenciacorporativa['fechahasta'] == '0000-00-00 00:00:00') ? $asistenciacorporativa['fechadesde'] : $asistenciacorporativa['fechahasta'];

        $origen         = ($asistenciacorporativa['idorigen'] == '1S' || $asistenciacorporativa['idorigen'] == 'US' )  ? 'COM' : $asistenciacorporativa['idorigen'];
        $origen         = $origen == 'AN' ? 'AG' : $origen;
        $select_pais    = ($asistenciacorporativa['idorigen'] == '') ? "SELECT agencias.idpais as idpais FROM agencias WHERE agencias.idagencia = $idagencia" : "SELECT idpais FROM paises WHERE codigopais = '$origen'";
        $idorigen       = ejecuta_select($db_postgresql, $select_pais, "idpais");
        $idorigen       = ($idorigen == 0) ? 99 : $idorigen;
        $destinos                       = $asistenciacorporativa['destinos'];
        $codigovoucheremision           = $asistenciacorporativa['codigovoucheremision'];
        $fechacreacion                  = $asistenciacorporativa['fechacreacion'];
        $fechamodificacion              = ($asistenciacorporativa['fechamodificacion'] == '0000-00-00 00:00:00') ? $asistenciacorporativa['fechacreacion'] : $asistenciacorporativa['fechamodificacion'];
        $idagente                      = $asistenciacorporativa['idagente'];
        $idstatus                       = ($asistenciacorporativa['idstatus'] == 0) ? 2 : $asistenciacorporativa['idstatus'];
        $planfamiliar                   = $asistenciacorporativa['planfamiliar'];
        $comentarios                    = $asistenciacorporativa['comentarios'];

        $nombrecontacto                 = str_replace("'", "", $asistenciacorporativa['nombrecontacto']);
        $correocontacto                 = $asistenciacorporativa['correocontacto'];
        $telefonocontacto               = str_replace("'", "", $asistenciacorporativa['telefonocontacto']);


        $valor_asistenciacorporativaviaje = " (
            $idasistenciacorporativaviaje,
            $idorden,
            '$fechadesde',
            '$fechahasta',
            $idorigen,
            '$destinos',
            '$codigovoucheremision',
            '$fechacreacion',
            '$fechamodificacion',
            $idagente,
            $idstatus,
            '$planfamiliar',
            '$comentarios'
     ) " ;

     $array_asistenciascorporativasviajes [] = $valor_asistenciacorporativaviaje;


            $valor_contactos_asistenciacorporativaviaje = "(
                    $idorden,
                    $idasistenciacorporativaviaje,
                    '$nombrecontacto',
                    '$correocontacto',
                    '$telefonocontacto'
            )" ;
            $array_contactos[] =$valor_contactos_asistenciacorporativaviaje;
        
            $select_beneficiarios_corporativos = "SELECT  
            id as idbeneficiario,
            id_emision as idordencorporativa,
            CAST(CONVERT(nombre USING utf8) AS binary) as nombrebeneficiario,
            CAST(CONVERT(apellido USING utf8) AS binary) as apellidobeneficiario,
            CAST(CONVERT(email USING utf8) AS binary) as correobeneficiario,
            CAST(CONVERT(telefono USING utf8) AS binary) as telefono,
            IF(nacimiento = '0000-00-00', 'NULL', CAST(CONVERT(nacimiento USING utf8) AS binary)) as fechanacimiento,
            CAST(CONVERT(documento USING utf8) AS binary) as documentacion,
            IF(status != 1, 2, status) as idstatus,
            COALESCE(precio_vta, 0) as precioventa
            FROM beneficiaries
            WHERE id_emision = $idasistenciacorporativaviaje
            ORDER BY id ASC
            ";
            
            $mysql_beneficiarios_corporativos = $db_mysql->query($select_beneficiarios_corporativos);
            
            while ($row_beneficiarios_corporativos = $mysql_beneficiarios_corporativos->fetch_array(MYSQLI_ASSOC)) 
            {
            $row_array_beneficiarios_corporativos[] = $row_beneficiarios_corporativos;
            }
            
            if(count($row_array_beneficiarios_corporativos) > 0)
            {
            
            
                $consecutivo = 1;
                foreach($row_array_beneficiarios_corporativos as $beneficiario_corporativo)
                {
            
                    $idbeneficiario         = $beneficiario_corporativo['idbeneficiario'];
                    $idordencorporativa     = $beneficiario_corporativo['idordencorporativa'];
                    $nombrebeneficiario     = str_replace("'", "", $beneficiario_corporativo['nombrebeneficiario']);
                    $apellidobeneficiario   = str_replace("'", "", $beneficiario_corporativo['apellidobeneficiario']);
                    $correobeneficiario     = $beneficiario_corporativo['correobeneficiario'];
                    $telefono               = str_replace("'", "", $beneficiario_corporativo['telefono']);
                    $fechanacimiento        = $beneficiario_corporativo['fechanacimiento'];
                    $documentacion          = str_replace("'", "", $beneficiario_corporativo['documentacion']);
                    $idstatus               = ($beneficiario_corporativo['idstatus'] == 0) ? 2 : $beneficiario_corporativo['idstatus'];
                    $precioventa            = $beneficiario_corporativo['precioventa'];
            
                                
                    $valores_beneficiarios = "(
                        $idbeneficiario,
                        $idorden,
                        $idordencorporativa,
                        UPPER('$nombrebeneficiario'),
                        UPPER('$apellidobeneficiario'),
                        LOWER('$correobeneficiario'),
                        '$telefono',
                        " . ($beneficiario_corporativo['fechanacimiento'] == NULL || $beneficiario_corporativo['fechanacimiento'] == 'NULL' ? "NULL" : "'$fechanacimiento'") . ",
                        '$documentacion',
                        $idstatus,
                        $precioventa,
                        $consecutivo,
                        '$fechadesde',
                        '$fechahasta'
                    )";
            
                    $array_beneficiarios [] = $valores_beneficiarios;
            
            
                    $contador_costo = 1;
                    while($contador_costo <= 2)
                    {
                    $costo     = 'costo'.$contador_costo;
                    $costo     = $$costo;
            
                    $valor_beneficarios_costos = "(
                                                    $idbeneficiario,
                                                    $contador_costo,
                                                    $costo
                                                )";

                    $array_beneficiarios_costos [] = $valor_beneficarios_costos;

                    $contador_costo++;
                    }
            
            
                    $consecutivo++;
                }
                $row_array_beneficiarios_corporativos = array();
            }
        
        
        
        
    }
}                                



//PRECOMPRAS
$registros_precompra = array_filter($registrosFiltrados, function($registro) {
    return $registro['cargaprecompra'] == 1;
});
$idprecompras = array_map(function($registro) {
    return $registro['idorden'];
}, $registros_precompra);
if (count($idprecompras)>0) {
    $idprecompras = implode(",", $idprecompras);

    $select_precompra = "SELECT  
                        id as idprecompra,
                        IF(status = 1, 1, 2) as idstatus,
                        fecha_precompra as fechaprecompra,
                        voucher as idorden
                    FROM precompra
                    WHERE voucher IN ($idprecompras)
                ";
       $mysql_precompra = $db_mysql->query($select_precompra);
    
       while ($row_precompra = $mysql_precompra->fetch_array(MYSQLI_ASSOC))
       {
        if(count($row_precompra) > 0){
            $idprecompra        = $row_precompra['idprecompra'];
                                    $idstatus           = ($row_precompra['idstatus'] == 0) ? 2 : $row_precompra['idstatus'];
                                    $fechaprecompra     = $row_precompra['fechaprecompra'];
    
                                    $valor_precompra = "(
                                                        $idprecompra,
                                                        $idstatus,
                                                        '$fechaprecompra',
                                                        $idorden
                                                    )" ;
                        $array_precompras [] = $valor_precompra;
    
        }
    
       }
}




///PRECOMPRAS CON FECHAS DEFINIDAS

foreach($registrosFiltrados as $registro) {
 // EMISIONES DE PRECOMPRA
 if($registro['idcategoria'] == 32 && $registro['fechadesde'] != '0000-00-00' && $registro['fechahasta'] != '0000-00-00')
 {

     $idorden        = $registro['idorden'];
     $fechadesde     = $registro['fechadesde'];
     $fechahasta     = $registro['fechahasta'];
     $origen         = ($registro['idorigen'] == '1S' || $registro['idorigen'] == 'US' || $registro['idorigen'] == ''  )  ? 'COM' : $registro['idorigen'];
     $origen         = $origen == 'AN' ? 'AG' : $origen;
     $select_pais    = ($registro['idorigen'] == '') ? "SELECT agencias.idpais as idpais FROM agencias WHERE agencias.idagencia = $idagencia" : "SELECT idpais FROM paises WHERE codigopais = '$origen'";
     $idorigen       = ejecuta_select($db_postgresql, $select_pais, "idpais");
     $idorigen       = ($idorigen == 0) ? 99 : $idorigen;
     $destinos       = ($registro['destinos'] == '') ? 'AME' : $registro['destinos'];
     $idcategoria    = $registro['idcategoria'];
     $idplan         = $registro['idplan'];
     $planfamiliar   = $registro['planfamiliar'] == '' ? 'f' : $registro['planfamiliar'];
     $comentarios    = $registro['comentarios'];

     $select_precompra_padre   = "SELECT precompra FROM historico_precompra WHERE orden = $idorden";
     
     $mysql_precompra_padre = $db_mysql->query($select_precompra_padre);

     while ($row_precompra_padre = $mysql_precompra_padre->fetch_array(MYSQLI_ASSOC)) 
     {
         if(count($row_precompra_padre) > 0)
         {
             $idprecompra                    = $row_precompra_padre['precompra'];
             $update_emision_precompra       = "UPDATE ordenes SET idprecompra = $idprecompra WHERE idorden = $idorden";
 
             if(ejecuta_update($db_postgresql, $update_emision_precompra))
             {
                     $valor_emision_precompra_asistenciasviajes = "(
                                                                         $idorden, 
                                                                         '$fechadesde', 
                                                                         '$fechahasta', 
                                                                         $idorigen, 
                                                                         '$destinos', 
                                                                         $idcategoria, 
                                                                         $idplan, 
                                                                         '$planfamiliar', 
                                                                         '$comentarios'
                                                                     )";
                     $array_asistenciasviajes [] = $valor_emision_precompra_asistenciasviajes;
                    
             }
             
         }
     }
     
     $idprecompra = $registro['idprecompra'];
 }

}





unset($idprecompras);


//SECCIÓN INSERT ORDENES


    // Prepara el insert para ordenes
    $insert = "INSERT INTO ordenes (
        idorden, idtipoasistencia, idstatus, codigovoucher, idagencia, idcorporativo, idmoneda, total,
        emisioncorporativa, cargamanual, idcupon, fechacreacion, fechamodificacion, idusuario, idplataformapago,
        tdctipo, tdcnumero, tdctitular, tdcexpiracion, respuestapago, referencia, idsistema, idempresa, idfuente,
        ip, comentarios, cargaprecompra, idprecompra, tiempoproducto, porcentajeincentivo, montoincentivo, tasacambio
    ) VALUES ";

    $valores = implode(",", $array_valores);
    $insert = $insert.$valores;

    if(ejecuta_insert($db_postgresql, $insert) == 0) 
    {
        echo $insert;
        die( "ERROR INSERTANDO ORDENES: " . pg_last_error($db_postgresql));
    }

    
    unset($array_valores);





$insert_asistenciacorporativa = "INSERT INTO asistenciascorporativas (
    idorden,
    idplan,
    tiempoproducto
) 
VALUES  " ;



$valores_asistenciascorporativas = implode(",", $array_asistenciascorporativas);
$insert_asistenciacorporativa = $insert_asistenciacorporativa.$valores_asistenciascorporativas;

if(ejecuta_insert($db_postgresql, $insert_asistenciacorporativa) == 0) 
{
echo $insert_asistenciacorporativa;
die( "ERROR INSERTANDO ASISTENCIAS CORPORATIVAS:" . pg_last_error($db_postgresql));
}


//SECCIÓN DE INSERTS CONFIGURACION ORDENES


$insert_asistenciasviajes = "INSERT INTO asistenciasviajes
(
    idorden, 
    fechadesde, 
    fechahasta, 
    idorigen, 
    destinos, 
    idcategoria, 
    idplan, 
    planfamiliar, 
    comentarios
)
VALUES ";

$valores_asistenciasviajes = implode(",", $array_asistenciasviajes);
$insert_asistenciasviajes = $insert_asistenciasviajes.$valores_asistenciasviajes;

if(ejecuta_insert($db_postgresql, $insert_asistenciasviajes) == 0) 
{
echo $insert_asistenciasviajes;
die( "ERROR INSERTANDO ASISTENCIAS VIAJES:" . pg_last_error($db_postgresql));
}



$insert_asistenciacorporativaviaje = "INSERT INTO asistenciascorporativasviajes (
    idasistenciacorporativaviaje,
    idorden,
    fechadesde,
    fechahasta,
    idorigen,
    destinos,
    codigovoucheremision,
    fechacreacion,
    fechamodificacion,
    idagente,
    idstatus,
    planfamiliar,
    comentarios
) 
VALUES " ;


$valores_asistenciacorporativaviaje = implode(",", $array_asistenciascorporativasviajes);
$insert_asistenciacorporativaviaje = $insert_asistenciacorporativaviaje.$valores_asistenciacorporativaviaje;

if(ejecuta_insert($db_postgresql, $insert_asistenciacorporativaviaje) == 0) 
{
echo $insert_asistenciacorporativaviaje;
die( "ERROR INSERTANDO ASISTENCIAS CORPORATIVAS VIAJES:" . pg_last_error($db_postgresql));
}





if (count($array_precompras)>0) {

    $insert_precompra = "INSERT INTO precompras (
        idprecompra,
        idstatus,
        fechaprecompra,
        idorden
    ) VALUES ";

    $valores_precompras = implode(",", $array_precompras);
    $insert_precompra = $insert_precompra.$valores_precompras;
    
     if(ejecuta_insert($db_postgresql, $insert_precompra) == 0) 
    {
        echo $insert_precompra;
        die( "ERROR INSERTANDO PPRECOMPRA: " . pg_last_error($db_postgresql));
    }
}





// Prepara el insert para ordenescomisiones
$insert_ordenes_comisiones = "INSERT INTO ordenescomisiones ( idorden, idagencia, idnivel, porcentaje, monto ) VALUES ";
$valores_comisiones = implode(",", $array_comisiones);
$insert_ordenes_comisiones = $insert_ordenes_comisiones.$valores_comisiones;


   if (!empty($comisiones)) {

    if (ejecuta_insert($db_postgresql, $insert_ordenes_comisiones) ==  0) {
        echo $insert_ordenes_comisiones;
        die("ERROR INSERTANDO COMISIONES: " . pg_last_error($db_postgresql));
    }
}


$insert_ordenes_costos = "INSERT INTO ordenescostos ( idorden, idproveedor, costo ) VALUES  ";
$valores_costos = implode(",", $array_costos);
$insert_ordenes_costos = $insert_ordenes_costos.$valores_costos;

if(ejecuta_insert($db_postgresql, $insert_ordenes_costos) == 0) 
{
    echo $insert_ordenes_costos;
    die( "ERROR INSERTANDO COSTOS:" . pg_last_error($db_postgresql));
}


$insert_ordenes_contactos = "INSERT INTO ordenescontactos 
( idorden, idordencorporativa, nombrecontacto, correocontacto, telefonocontacto )
 VALUES ";
$valores_contactos = implode(",", $array_contactos);
$insert_ordenes_contactos = $insert_ordenes_contactos.$valores_contactos;
if(ejecuta_insert($db_postgresql, $insert_ordenes_contactos) == 0) 
{
    echo $insert_ordenes_contactos;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}

unset($array_comisiones);
unset($array_costos);
unset($array_contactos);
unset($array_precompras);








    $insert_beneficiarios = "INSERT INTO beneficiarios (
                                idbeneficiario,
                                idorden,
                                idordencorporativa,
                                nombrebeneficiario,
                                apellidobeneficiario,
                                correobeneficiario,
                                telefono,
                                fechanacimiento,
                                documentacion,
                                idstatus,
                                precioventa,
                                consecutivo,
                                fechacorporativadesde,
                                fechacorporativahasta
                            )   VALUES  ";


    $valores_beneficiarios = implode(",", $array_beneficiarios);
    $insert_beneficiarios = $insert_beneficiarios.$valores_beneficiarios;

    if(ejecuta_insert($db_postgresql, $insert_beneficiarios) == 0) 
    {
        echo $insert_beneficiarios;
        die( "ERROR INSERTANDO BENEFICIARIOS:" . pg_last_error($db_postgresql));
    }
   



    $insert_beneficarios_costos = "INSERT INTO beneficiarioscostos (
        idbeneficiario,
        idproveedor,
        costo
    )
    VALUES ";


    $valores_beneficarios_costos = implode(",", $array_beneficiarios_costos);
    $insert_beneficarios_costos = $insert_beneficarios_costos.$valores_beneficarios_costos;


    if(ejecuta_insert($db_postgresql, $insert_beneficarios_costos) == 0) 
    {
    echo $insert_beneficarios_costos;
    die( "ERROR INSERTANDO BENEFICIARIOS COSTOS:" . pg_last_error($db_postgresql));
    }


    $insert_beneficio_adicional = "INSERT INTO beneficiariosbeneficiosadicionales (
        idbeneficiario,
        idbeneficioadicional,
        precio,
        monto,
        cobertura
    ) VALUES  ";


    $valores_beneficio_adicional = implode(",", $array_beneficio_adicional);
    $insert_beneficio_adicional = $insert_beneficio_adicional.$valores_beneficio_adicional;


    if(ejecuta_insert($db_postgresql, $insert_beneficio_adicional) == 0) 
    {
    echo $insert_beneficio_adicional;
    die( "ERROR INSERTANDO BENEFICIO ADICIONAL:" . pg_last_error($db_postgresql));
    }



    




 
     $secuencia = $idorden + 1;
     $secuencia = "ALTER SEQUENCE ordenes_idorden_seq RESTART WITH ".$secuencia; 
     ejecuta_select($db_postgresql, $secuencia);
 
     $secuencia = $idbeneficiario + 1;
     $secuencia = "ALTER SEQUENCE beneficiarios_idbeneficiario_seq RESTART WITH ".$secuencia; 
     ejecuta_select($db_postgresql, $secuencia);
 
     $secuencia = select_max_id($db_postgresql, 'idprecompra', 'precompras');
     $secuencia = $secuencia + 1;
     $secuencia = "ALTER SEQUENCE precompra_idprecompra_seq RESTART WITH ".$secuencia; 
     ejecuta_select($db_postgresql, $secuencia);
 
 
 
 
 
 
 
 
 
 
 // CRUCEROS *******************************************************************************************************************************************************************************
     echo '
 Migrando Tabla: cruceros...';
 
     $cruceros = array();
 
     $mysql_cruceros = $db_mysql->query("SELECT id, CAST(CONVERT(crucero USING utf8) AS binary) as crucero, status FROM cruiseline ORDER BY id ASC");
 
     while ($row = $mysql_cruceros->fetch_array(MYSQLI_ASSOC)) 
     {
         $cruceros[] = $row;
     }
 
     $insert     = "INSERT INTO cruceros ( idcrucero, nombrecrucero, idstatus ) VALUES ";
 
     $array_valores = array();
 
     foreach($cruceros as $crucero)
     {
         echo '.';
         
         $idcrucero      = $crucero['id'];
         $nombrecrucero  = $crucero['crucero'];
         $idstatus       = ($crucero['status'] == 0) ? 2 : $crucero['status'];
        
         
                             $valor ="(
                                 $idcrucero, 
                                 '$nombrecrucero',
                                 $idstatus
                             )";
 
         //array_push($array_valores, $valor);
         $array_valores[] = $valor;
     }
 
     $valores        = implode(",", $array_valores);
     $insert         = $insert.$valores; 
 
    
     if(ejecuta_insert($db_postgresql, $insert) == 0) 
     {
         echo $insert;
         die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
     }
     $secuencia = $idcrucero + 1;
     $secuencia = "ALTER SEQUENCE cruceros_idcrucero_seq RESTART WITH ".$secuencia; 
     ejecuta_select($db_postgresql, $secuencia);
 
 
 
 // ECOMMERCE
 echo '
 Ejecutando actualizaciones para eCommerce...
 ';
     // ACTUALIZACION DEL USUARIO ECOMMERCE:
     ejecuta_update($db_postgresql, "UPDATE usuarios SET nombreusuario='Usuario', apellidousuario='Ecommerce', idstatus=1, idtipousuario=2, idagencia=118, aliasusuario='eCommerce', contrasena='3Comm3rc3', correo='directa@continentalassist.com', telefono='786.800.2764', escorporativo=false, fechacreacion='2013-09-12 00:00:00.000', fechamodificacion='2018-02-06 00:00:00.000', fechacambiarcontrasena='2000-01-01 00:00:00.000', cambiarcontrasena=true, ididioma=1, ipremota='0.0.0.0', conectado=false, soloconexionlocal=false, ultimaconexion='2000-01-01 00:00:00.000', incentivo=0, banco='', clabeinterbancaria='', beneficiario='', cuenta='', idcorporativo=NULL, whatsapp=NULL, facebook=NULL, twitter=NULL, recuperacion=NULL, urlimagenperfil='', idusuariosap=NULL WHERE idusuario=293;");
     ejecuta_update($db_postgresql, "UPDATE agencias SET idsistema=1, nombreagencia='Ecommerce', idstatus=1, idnivel=0, idpais=99, telefono1='786.800.2764', telefono2='', telefono3='', direccion='Casa Matriz', fechacreacion='2014-03-18 00:00:00.000', idagente=1076, logoagencia='', creditobase=0.00, creditoactual=0.00, verprecio=true, versoloinclusion=false, multipais=false, banco='', clabeinterbancaria='', cuenta='', beneficiario='', idagenciapadre=0, idagenciareporta=118, razonsocial='', identificadortributaria='', ciudad='0', estado='', comentario='', acronimovoucher='CA', tiempomaximocotizar=365, color1frame='#05184C', tokenhash='20da2fd7cb11fc8c0b50875753e73e0bcb635d6d', tokenpagina='www.ventasdirectas.com', marcacompartida=false, correo='info@continentalassist.com', color2frame='#43D3FB', idagenciasap=NULL, idcanalventa=NULL, voucherpersonalizado=NULL WHERE idagencia=118;");
     ejecuta_update($db_postgresql, "UPDATE agencias SET idsistema=1, nombreagencia='CONTINENTAL ASSIST COLOMBIA', idstatus=1, idnivel=1, idpais=5, telefono1='', telefono2='', telefono3='', direccion='bogota colombia', fechacreacion='2015-02-27 00:00:00.000', idagente=8252, logoagencia='https://storage.googleapis.com/files-continentalassist-backend/Agencias/unknow.png', creditobase=2000.00, creditoactual=787559.02, verprecio=true, versoloinclusion=false, multipais=false, banco='', clabeinterbancaria='', cuenta='', beneficiario='', idagenciapadre=174, idagenciareporta=818, razonsocial='Continental Assist Colombia', identificadortributaria='', ciudad='BOGOTA', estado='BOGOTA', comentario='', acronimovoucher='CA', tiempomaximocotizar=365, color1frame='#05184C', tokenhash=NULL, tokenpagina=NULL, marcacompartida=false, correo='info@continentalassist.com', color2frame='#43D3FB', idagenciasap=NULL, idcanalventa=NULL, voucherpersonalizado=NULL WHERE idagencia=818;");
 
 
     // ACTUALIZA USUSARIO ASOCIADO A LA SESION DEL ECOMMERCE
     $idusuario_ecommerce = ejecuta_select($db_postgresql, "SELECT idusuario FROM usuarios WHERE correo = 'ecommerce@continentalassist.com' ", "idusuario");
     $update = "UPDATE sesiones SET idusuario=$idusuario_ecommerce WHERE token = 'caUsuarioPaginaWeb'; ";
     ejecuta_update($db_postgresql, $update);
 
     // ACTUALIZA POPULARIDAD DE LOS PLANES ECOMMERCE
     ejecuta_update($db_postgresql, "UPDATE public.planes SET idpopularidad=10 WHERE idplan=2946; ");
     ejecuta_update($db_postgresql, "UPDATE public.planes SET idpopularidad=9 WHERE idplan=2964; ");
     ejecuta_update($db_postgresql, "UPDATE public.planes SET idpopularidad=8 WHERE idplan=2965; ");
 
 
 // ACTUALIZACIONES ADICIONALES
 echo '
 Actualizando comisiones de archivo de agencias...
 ';
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	1498;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	1504;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	1516;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	1552;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	1557;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	1605;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	1607;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	1613;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	1637;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	1668;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1677;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1683;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	1768;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1786;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1836;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1863;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	1871;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	1877;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1991;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2042;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2044;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2087;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2101;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2121;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2165;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2190;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2199;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2207;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	2208;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2217;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	2220;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2230;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2231;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2255;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2256;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2257;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	2265;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2296;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =15	WHERE idagencia = 	2297;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	2346;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2352;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2385;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2399;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	2403;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2440;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	2514;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2552;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2564;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2581;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2610;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	2631;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	2655;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2661;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2696;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	2731;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =33	WHERE idagencia = 	2766;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2767;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =33	WHERE idagencia = 	3386;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	3389;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3391;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =33	WHERE idagencia = 	3414;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3505;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	3514;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3543;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	3549;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	3636;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	3648;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3653;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3735;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	3756;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	3774;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	3777;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	3787;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	3788;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	3809;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3811;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	3813;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3828;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	3841;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	3864;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3876;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =40	WHERE idagencia = 	3878;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	3884;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	3942;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3961;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4008;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4028;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4031;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4040;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	4043;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4045;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4053;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4060;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4072;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4075;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4076;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4078;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4099;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4111;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4113;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4116;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4124;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4126;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4128;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4136;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4140;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =32	WHERE idagencia = 	4141;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4145;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4150;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4156;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4158;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	4159;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4185;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4187;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4189;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4195;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4224;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	4240;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4244;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	4252;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	4267;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4291;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4299;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4300;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4307;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4309;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4372;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4375;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4376;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4377;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4406;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4433;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4434;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4437;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	4450;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4463;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =22	WHERE idagencia = 	4464;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4471;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4503;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4546;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4556;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4557;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4566;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4567;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4573;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4574;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4579;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4597;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4608;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4617;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4628;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4642;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4643;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4647;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4653;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	4656;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4666;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4705;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4718;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4722;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4731;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4733;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	4741;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4750;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	4763;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4769;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4809;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4844;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4847;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4855;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4885;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4888;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4892;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	5009;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	5017;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5022;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5108;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5111;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5206;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5248;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5252;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5255;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5258;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5264;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5279;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	5284;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	5285;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5312;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	5313;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5326;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5334;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5335;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =10	WHERE idagencia = 	5338;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5341;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5342;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5358;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5364;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5424;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	5437;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5446;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5450;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5463;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5465;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5469;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5470;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5473;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5481;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5484;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5494;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5496;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	5504;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5507;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	5542;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5547;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5568;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5581;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5589;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5593;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5597;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5638;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5644;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5646;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	5671;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5755;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5758;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5762;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	5763;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5784;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	5785;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5786;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5790;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5792;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5793;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5796;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5797;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5809;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5821;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	5822;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5824;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	5828;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5833;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5840;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5841;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5852;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5856;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5857;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5858;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5878;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5893;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5894;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5909;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5910;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	5922;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	5930;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =23	WHERE idagencia = 	5931;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5960;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5966;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5977;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	5981;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6000;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6004;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6005;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	6012;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6015;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6026;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6032;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6041;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6046;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6052;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6054;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6055;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6060;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6062;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	6063;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6065;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6067;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6069;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6072;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6076;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6087;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6090;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6096;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6110;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6111;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6118;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6119;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6120;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6122;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6132;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6133;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6151;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6154;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6159;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6160;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6161;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6164;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6168;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6171;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6172;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6173;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6182;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6186;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6193;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6195;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	6197;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6198;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	6216;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6222;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6223;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6226;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6229;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6233;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6236;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6237;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6251;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	6252;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6257;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6258;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6260;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6264;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	6280;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =33	WHERE idagencia = 	6281;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6282;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =0	WHERE idagencia = 	6286;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6291;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6292;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6294;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =15	WHERE idagencia = 	6296;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6298;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6299;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6300;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6306;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =23	WHERE idagencia = 	6308;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6323;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6324;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6325;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =23	WHERE idagencia = 	6331;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6334;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6336;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6338;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6346;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6348;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6351;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6354;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6359;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =0	WHERE idagencia = 	6360;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6363;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6365;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6369;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6377;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6388;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6389;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6390;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6397;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6403;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6405;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6407;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6408;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =15	WHERE idagencia = 	6410;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =13	WHERE idagencia = 	6411;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6417;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6420;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6421;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6425;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6450;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6452;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6457;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6461;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6463;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6469;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6474;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6486;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =23	WHERE idagencia = 	6487;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6488;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6489;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	6495;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6496;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6501;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6507;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6511;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	6516;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6525;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	6526;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	867;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =40	WHERE idagencia = 	178;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	1942;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =0	WHERE idagencia = 	2477;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =45	WHERE idagencia = 	2676;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2787;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	2851;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	3085;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4516;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4545;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =45	WHERE idagencia = 	4554;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =0	WHERE idagencia = 	4598;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	5239;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	5329;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5410;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6290;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =0	WHERE idagencia = 	936;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =40	WHERE idagencia = 	1079;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1098;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1099;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	1119;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1147;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	1206;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1226;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1237;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1247;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	1253;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1283;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1299;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1305;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1342;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	1402;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1416;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1417;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =15	WHERE idagencia = 	1425;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1452;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1464;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1484;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1506;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1523;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	1545;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	1559;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1578;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1632;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1690;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1701;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	1740;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1760;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	1781;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	1827;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1944;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1949;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1962;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1963;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1965;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	1966;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	1998;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2015;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2030;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2081;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =40	WHERE idagencia = 	2124;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2135;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2158;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2177;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2187;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2192;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	2248;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2274;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2287;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2376;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2408;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2432;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2470;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2507;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =40	WHERE idagencia = 	2551;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2566;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2576;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2583;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2591;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2658;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2668;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2675;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2692;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2701;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =0	WHERE idagencia = 	2714;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	2720;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3387;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3410;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	3419;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3443;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =20	WHERE idagencia = 	3481;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3671;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3696;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3716;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3734;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3739;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =0	WHERE idagencia = 	3744;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	3753;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3766;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3806;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3817;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =0	WHERE idagencia = 	3829;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3845;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3880;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	3887;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4290;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4442;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4446;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4479;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4528;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =40	WHERE idagencia = 	4553;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4590;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	4607;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4644;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4654;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4657;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4698;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4706;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4719;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4768;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4776;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4782;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4790;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4802;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4812;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4815;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4833;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4840;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4843;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =35	WHERE idagencia = 	4863;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4865;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4867;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	4896;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5002;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5006;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5007;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5015;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5118;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5208;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5219;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5221;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5235;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5241;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5245;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5271;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5280;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5305;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5317;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5318;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5332;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5389;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5441;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5442;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =50	WHERE idagencia = 	5522;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5533;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =25	WHERE idagencia = 	5537;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5543;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5607;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5655;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =0	WHERE idagencia = 	5751;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5889;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	5998;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =0	WHERE idagencia = 	6027;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6035;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6039;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6048;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6070;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6075;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =40	WHERE idagencia = 	6189;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6201;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6202;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6370;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6374;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6383;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6415;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6418;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6423;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6424;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6439;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6453;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6460;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6465;");
     ejecuta_update($db_postgresql, "UPDATE comisionesagencias SET comision =30	WHERE idagencia = 	6479;");
 
 
 
 
 
 
 
 // NORMALIZANDO
 echo '
 Normalizando...
 ';
 
 
 
 
 
 
 
 
 
 
 // NORMALIZACION DE ASIGNACION DE CATEGORIA PUBLICAS  *******************************************************************************************************************************************************************************
       
 echo '
 Normalizando Categorias Públicas...
 ';
         $categorias_publicas = array(22,23,24,27);
 
         $insert_categoriasagencias          = "INSERT INTO categoriasagencias ( idagencia, idcategoria ) VALUES ";
         $array_valores_categoriasagencias   = array();
 
         $insert_planesagencias              = "INSERT INTO planesagencias ( idagencia, idplan ) VALUES ";
         $array_valores_planesagencias       = array();
 
 
         foreach($categorias_publicas as $categoria_publica)
         {
             $agencias                 = ejecuta_select($db_postgresql, "SELECT idagencia, idpais
                                                                         from agencias 
                                                                         where idagencia not in (
                                                                         select idagencia 
                                                                         from categoriasagencias
                                                                         where idcategoria in ($categoria_publica) )");
 
             if($agencias['cantidad'] > 0)
             {
                 foreach($agencias['resultado'] as $agencia)
                 {
                     $idagencia          = $agencia['idagencia'];
                     $idpais             = $agencia['idpais'];
 
                     $valor_categoriasagencias = "( $idagencia, $categoria_publica) ";
 
                     //array_push($array_valores_categoriasagencias, $valor_categoriasagencias);
                     $array_valores_categoriasagencias[] = $valor_categoriasagencias;

                     $planes_publicos = ejecuta_select($db_postgresql, "SELECT planes.idplan 
                                                                         FROM planes 
                                                                         left join planespaises on planes.idplan = planespaises.idplan 
                                                                         WHERE planes.publico = true 
                                                                         AND planes.idcategoria = $categoria_publica
                                                                         AND planespaises.idpais = $idpais;");
 
                     if($planes_publicos['cantidad'] > 0)
                     {
                         foreach($planes_publicos['resultado'] as $plan_publico)
                         {
                             $idplan =  $plan_publico['idplan'];
 
                             $cantidad = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planesagencias WHERE idagencia = $idagencia AND idplan = $idplan", "cantidad");
 
                             if($cantidad == 0)
                             {
                                 $valor_planesagencias = "( $idagencia, $idplan )";
                                 //array_push($array_valores_planesagencias, $valor_planesagencias);
                                 $array_valores_planesagencias[] = $valor_planesagencias;

                             }
                         }
                     }
                 }
             }
             else
             {
                 echo '
 No se encontraron agencias sin la categoria '.$categoria_publica.' asignada...
 ';
             }
         }
 
         if(count($array_valores_categoriasagencias) > 0)
         {
             $valores = implode(",", $array_valores_categoriasagencias);
             $insert_categoriasagencias = $insert_categoriasagencias.$valores;
            
             if(ejecuta_insert($db_postgresql, $insert_categoriasagencias) == 0) 
             {
                 echo $insert_categoriasagencias;
                 die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
             }
         }
 
         if(count($array_valores_planesagencias) > 0)
         {
             $valores = implode(",", $array_valores_planesagencias);
             $insert_planesagencias = $insert_planesagencias.$valores;
             if(ejecuta_insert($db_postgresql, $insert_planesagencias) == 0) 
             {
                 echo $insert_planesagencias;
                 die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
             }
             
            
         }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 // NORMALIZACION DE ASIGNACION DE PLANES PUBLICOS  *******************************************************************************************************************************************************************************
 echo '
 Normalizando Planes Públicos...
 ';
         $insert_planesagencias              = "INSERT INTO planesagencias ( idagencia, idplan ) VALUES ";
         $array_valores_planesagencias       = array();
         
         $agencias                 = ejecuta_select($db_postgresql, "SELECT idagencia, idpais
                                                                         from agencias 
                                                                         where idagencia not in (
                                                                             select idagencia 
                                                                             from planesagencias
                                                                         )
                                                                     ");
 
         if($agencias['cantidad'] > 0)
         {
             foreach($agencias['resultado'] as $agencia)
             {
                 $idagencia          = $agencia['idagencia'];
                 $idpais             = $agencia['idpais'];
 
                 $planes_publicos = ejecuta_select($db_postgresql, "SELECT planes.idplan 
                                                                     FROM planes 
                                                                     left join planespaises on planes.idplan = planespaises.idplan 
                                                                     WHERE planes.publico = true 
                                                                     AND planespaises.idpais = $idpais;");
 
                 if($planes_publicos['cantidad'] > 0)
                 {
                     foreach($planes_publicos['resultado'] as $plan_publico)
                     {
                         $idplan =  $plan_publico['idplan'];
                         $cantidad = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planesagencias WHERE idagencia = $idagencia AND idplan = $idplan", "cantidad");
 
                         if($cantidad == 0)
                         {
                             $valor_planesagencias = "( $idagencia, $idplan )";
                             //array_push($array_valores_planesagencias, $valor_planesagencias);
                             $array_valores_planesagencias[] = $valor_planesagencias;

                             
                         }
                     }
                 }
             }
         }
         else
         {
             echo '
 No se encontraron agencias sin planes asignados...
 ';
         }
 
         if(count($array_valores_planesagencias) > 0)
         {
             $valores = implode(",", $array_valores_planesagencias);
             $insert_planesagencias = $insert_planesagencias.$valores;
             
             if(ejecuta_insert($db_postgresql, $insert_planesagencias) == 0) 
             {
                 echo $insert_planesagencias;
                 die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
             }
         }
 
 
 
 
 
 
 
 
 
 
 
 
 
 // NORMALIZA Y ASIGNA PLANES BLOQUEADOS PERSONALIZADOS
 echo '
 Normalizando Planes Bloqueados...
 ';
         $planes_bloqueados       = array();
         $planes_bloqueados[0]    = array("idagencia" => 3890, "planes" => array(1540,1541,1542,1583,1544,1545,1550));
         $planes_bloqueados[1]    = array("idagencia" => 2477, "planes" => array(1934,2186,2187,2188,1167,1168,1306,1300,1309,1311,1310,1308,2633,2632));
         $planes_bloqueados[2]    = array("idagencia" => 907, "planes" => array(1564,1565,1566,1567,1568,1569,1570));
         $planes_bloqueados[3]    = array("idagencia" => 3440, "planes" => array(1716,1717,1718,1719,1720,1721,1722,1723,1724,1725,1726,1727,1728,1729,1730,1731));
         $planes_bloqueados[4]    = array("idagencia" => 4092, "planes" => array(1649,1650,1651,1652,1653,1654,1655));
         $planes_bloqueados[5]    = array("idagencia" => 2042, "planes" => array(2085,2086));
         $planes_bloqueados[6]    = array("idagencia" => 4598, "planes" => array(2249,2250,2251,2252));
         $planes_bloqueados[7]    = array("idagencia" => 4808, "planes" => array(2189,2190,2191,2192,2193,2194,2195,2196,2197,2198,2199,2200,2244,2379,2380,2381,2382));
         $planes_bloqueados[8]    = array("idagencia" => 5768, "planes" => array(2577,2578,2579,2580,2581,2582));
         $planes_bloqueados[9]    = array("idagencia" => 5211, "planes" => array(87,88,89,1869,1377));
         $planes_bloqueados[10]   = array("idagencia" => 4387, "planes" => array(2597,2598,2600,2599,2601,2602,2605,2604,2607,2606));
         $planes_bloqueados[11]   = array("idagencia" => 4726, "planes" => array(2646,2647,2648));
         $planes_bloqueados[12]   = array("idagencia" => 4723, "planes" => array(2108,2111,2106,2107,2109,2110));
         $planes_bloqueados[13]   = array("idagencia" => 1687, "planes" => array(1353,707,1352,1644,1910,2490));
         $planes_bloqueados[14]   = array("idagencia" => 3691, "planes" => array(1353,707));
         $planes_bloqueados[15]   = array("idagencia" => 5799, "planes" => array(2508,2509));
         $planes_bloqueados[16]   = array("idagencia" => 5580, "planes" => array(2610,2621,2622,2623,2624,2625,2626,2627,2628));
         $planes_bloqueados[17]   = array("idagencia" => 4496, "planes" => array(1937,1939));
         $planes_bloqueados[18]   = array("idagencia" => 4728, "planes" => array(1937,1939));
         $planes_bloqueados[19]   = array("idagencia" => 4626, "planes" => array(192));
         $planes_bloqueados[20]   = array("idagencia" => 5908 , "planes" => array(2538,2539,2540,2542,2543));
         $planes_bloqueados[21]   = array("idagencia" => 4748, "planes" => array(88));
         $planes_bloqueados[22]   = array("idagencia" => 3938, "planes" => array(2391,2393,2394,2395,2396,2397,2398,2399,2400,2401,2402,2403,2404,2405,2406));
         $planes_bloqueados[23]   = array("idagencia" => 6106, "planes" => array(56,87,88,89,1377,1869));
         $planes_bloqueados[24]   = array("idagencia" => 4672, "planes" => array(1716,1717,1718,1719,2106,2107,2108,2109,2110,2111));
         $planes_bloqueados[25]   = array("idagencia" => 5906, "planes" => array(1870));
         $planes_bloqueados[26]   = array("idagencia" => 5931, "planes" => array(2557,2558,2559,2560,2561,2562,2563,2564,2565,2566));
         $planes_bloqueados[27]   = array("idagencia" => 5990, "planes" => array(2557,2558,2559,2560,2561,2562,2563,2564,2565,2566));
         $planes_bloqueados[28]   = array("idagencia" => 6057, "planes" => array(2637,2658,2659,2660,2638,2661,2662,2663,2639,2664,2665,2666,2640,2667,2668,2669,2641,2670,2671,2672,2642,2682,2683,2684,2643,2694,2695,2696,2649,2673,2674,2675,2650,2685,2686,2687,2651,2697,2698,2699,2652,2676,2677,2678,2653,2688,2689,2690,2654,2701,2702,2703,2655,2679,2680,2681,2656,2691,2692,2693,2657,2703,2704,2705));
         $planes_bloqueados[29]   = array("idagencia" => 6058, "planes" => array(2637,2658,2659,2660,2638,2661,2662,2663,2639,2664,2665,2666,2640,2667,2668,2669,2641,2670,2671,2672,2642,2682,2683,2684,2643,2694,2695,2696,2649,2673,2674,2675,2650,2685,2686,2687,2651,2697,2698,2699,2652,2676,2677,2678,2653,2688,2689,2690,2654,2701,2702,2703,2655,2679,2680,2681,2656,2691,2692,2693,2657,2703,2704,2705));
         $planes_bloqueados[30]   = array("idagencia" => 4677, "planes" => array(2017,2018));
         $planes_bloqueados[31]   = array("idagencia" => 4626, "planes" => array(200,498,499));
         $planes_bloqueados[32]   = array("idagencia" => 4232, "planes" => array(1778));
         $planes_bloqueados[33]   = array("idagencia" => 5350, "planes" => array(89));
         $planes_bloqueados[34]   = array("idagencia" => 4429, "planes" => array(484,485,486,487,471,476,477,472,478,479,474,480,481,473,482,470,490,491));
         $planes_bloqueados[35]   = array("idagencia" => 2297, "planes" => array(21,87,89));
         $planes_bloqueados[36]   = array("idagencia" => 5532, "planes" => array(2041,2042,2043));
         $planes_bloqueados[37]   = array("idagencia" => 5888, "planes" => array(2530,2531,2532,2533,2534,2535));
         $planes_bloqueados[38]   = array("idagencia" => 5923, "planes" => array(267,269,270,272,273,275));
         $planes_bloqueados[39]   = array("idagencia" => 5217, "planes" => array(2569,2570));
         $planes_bloqueados[40]   = array("idagencia" => 5339, "planes" => array(114,116,21,123,56,87,92));
         $planes_bloqueados[41]   = array("idagencia" => 2297, "planes" => array(21,87,89));
         $planes_bloqueados[42]   = array("idagencia" => 5248, "planes" => array(21,123));
         $planes_bloqueados[43]   = array("idagencia" => 5901, "planes" => array(56,87,88,1869,1377));
         $planes_bloqueados[44]   = array("idagencia" => 1425, "planes" => array(157,159,160,162));
         $planes_bloqueados[45]   = array("idagencia" => 6115, "planes" => array(2706,2707,2708,2709,2710));
         $planes_bloqueados[46]   = array("idagencia" => 6117, "planes" => array(484,485,486,487));
         $planes_bloqueados[47]   = array("idagencia" => 3514, "planes" => array(88,1869));
         $planes_bloqueados[48]   = array("idagencia" => 118, "planes" => array(2946,2964,2965));
 
         $insert_planesagencias  = "INSERT INTO planesagencias ( idplan, idagencia ) VALUES ";
         $array_valores          = array();
 
         foreach($planes_bloqueados as $agencia)
         {
             $idagencia = $agencia['idagencia'];
 
             foreach($agencia['planes'] as $idplan)
             {
                 ejecuta_update($db_postgresql, "UPDATE planes SET idstatus = 1 WHERE idplan = $idplan");
 
                 $cantidad = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planesagencias WHERE idplan = $idplan AND idagencia = $idagencia", "cantidad");
 
                 if($cantidad == 0)
                 {
                     $valor = " ($idplan, $idagencia) ";
                    // array_push($array_valores, $valor);
                     $array_valores[] = $valor;

                 }
             }
         }
 
         if(count($array_valores) > 0)
         {
             $valores                = implode(",", $array_valores);
             $insert_planesagencias  = $insert_planesagencias.$valores;
           
             if(ejecuta_insert($db_postgresql, $insert_planesagencias) == 0) 
             {
                 echo $insert_planesagencias;
                 die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
             }
         }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 // AGENCIAS *******************************************************************************************************************************************************************************
         echo '
 Migrando Tabla: unificarvouchers...
 ';
         $registros = array();
 
         $mysql    = $db_mysql->query("SELECT 
                                         id_unificacion as idunificacion,
                                         codigo_voucher as codigovoucher,
                                         IF(cantidad_dias_fijo IS NULL, 'false', 'true') as vaciarbolsa,
                                         cantidad_dias_sumar as diassumados,
                                         cantidad_dias_restar as diasrestados,
                                         IF(fecha_unificacion = '0000-00-00', '2000-01-01', fecha_unificacion) as fechaunificacion,
                                         CAST(CONVERT(comentario USING utf8) AS binary) as comentarios
                                     FROM unificar_voucher_corporativo
                                     ORDER BY id_unificacion ASC
                                     ");
 
         while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
         {
             $registros[] = $row;
         }
 
         $insert         = "INSERT INTO vouchersunificados ( idunificacion, codigovoucher, vaciarbolsa, diassumados, diasrestados, fechaunificacion, comentarios ) VALUES ";
         $array_valores  = array();
         
         foreach($registros as $registro)
         {
             $idunificacion      = $registro['idunificacion'];
             $codigovoucher      = $registro['codigovoucher'];
             $vaciarbolsa        = $registro['vaciarbolsa'];
             $diassumados        = $registro['diassumados'];
             $diasrestados       = $registro['diasrestados'];
             $fechaunificacion   = $registro['fechaunificacion'];
             $comentarios        = $registro['comentarios'];
 
             // if($idunificacion == 138)
             // {
             //     $comentarios        = str_replace("?", "*", $comentarios);
             // }
 
             $valor = "(
                         $idunificacion,
                         '$codigovoucher',
                         $vaciarbolsa,
                         $diassumados,
                         $diasrestados,
                         '$fechaunificacion',
                         '$comentarios'
                     )";
 
             //array_push($array_valores, $valor);
             $array_valores[] = $valor;

         }
 
         if(count($array_valores) > 0)
         {
             $valores = implode(",", $array_valores);
             $insert = $insert.$valores;
             
             if(ejecuta_insert($db_postgresql, $insert) == 0) 
             {
                 echo $insert;
                 die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
             }
         }
 
     //SECUENCIA UNIFICACIÓN
         $secuencia = $idunificacion + 1;
         $secuencia = "ALTER SEQUENCE unificarvouchers_idunificacion_seq RESTART WITH ".$secuencia; 
         ejecuta_select($db_postgresql, $secuencia);
 
 
     // ACTUALIZACIÓN DE LAS VISTAS
     echo '
 Actualizando Vistas...
 ';
 //rguzman
      //   ejecuta_select($db_postgresql, 'REFRESH MATERIALIZED view vwm_reporteglobal');
       //  ejecuta_select($db_postgresql, 'REFRESH MATERIALIZED view vwm_reporteglobal_2023');
 
     // ACTUALIZACIÓN DE LAS VISTAS
 echo '
 Actualizando Canales de Venta...
 ';
         ejecuta_update($db_postgresql, 'UPDATE agencias SET idcanalventa = 1 WHERE 1 = 1');
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
     // ASIGNA IDAGENCIASAP
     echo '
 Asignando idagenciasap...
 ';
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 1 WHERE idagencia = 174");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 1 WHERE idagencia = 818");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 1 WHERE idagencia = 1142");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 1 WHERE idagencia = 479");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 1 WHERE idagencia = 509");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 1 WHERE idagencia = 893");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 1 WHERE idagencia = 4304");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 1 WHERE idagencia = 1228");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 1 WHERE idagencia = 2542");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 1 WHERE idagencia = 4385");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 1 WHERE idagencia = 1710");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 2 WHERE idagencia = 2477");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 3 WHERE idagencia = 1086");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 4 WHERE idagencia = 4893");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 5 WHERE idagencia = 4598");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 6 WHERE idagencia = 4672");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 7 WHERE idagencia = 5217");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 8 WHERE idagencia = 4627");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 9 WHERE idagencia = 6330");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 10 WHERE idagencia = 5923");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 11 WHERE idagencia = 4637");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 12 WHERE idagencia = 2124");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 13 WHERE idagencia = 4232");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 14 WHERE idagencia = 4625");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 15 WHERE idagencia = 6290");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 16 WHERE idagencia = 1504");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 17 WHERE idagencia = 3878");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 18 WHERE idagencia = 3440");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 19 WHERE idagencia = 4092");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 20 WHERE idagencia = 2676");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 21 WHERE idagencia = 5326");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 22 WHERE idagencia = 2661");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 23 WHERE idagencia = 4626");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 24 WHERE idagencia = 5768");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 25 WHERE idagencia = 4610");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 26 WHERE idagencia = 6528");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 27 WHERE idagencia = 907");
         ejecuta_update($db_postgresql, "UPDATE agencias SET idagenciasap = 28 WHERE idagencia = 5410");
 
 
 
 
 
     // ASIGNA CODIGOEJECUTIVOSAP
     echo '
 Asignando codigoejecutivosap...
 ';
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'KP' where idusuario in (12628,12001,7142,5714,4462,2659,9211)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'ES' where idusuario in (7146,297,11)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'JR' where idusuario in (2581,12059)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'DB' where idusuario in (1076,7093,2591,10947,10843)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'RM' where idusuario in (3671)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'CZ' where idusuario in (8995,5832,4229)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'DR' where idusuario in (7467,6367,6254)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'AN' where idusuario in (9187,7466,4890)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'MC' where idusuario in (8984,7828)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'NH' where idusuario in (3550)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'CR' where idusuario in (10727)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'BB' where idusuario in (3872)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'SP' where idusuario in (11050)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'XC' where idusuario in (11016,8617)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'AH' where idusuario in (6210)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'FM' where idusuario in (11217)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'LO' where idusuario in (10686)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'GD' where idusuario in (8373)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'CA' where idusuario in (4892)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'ER' where idusuario in (10599)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'MM' where idusuario in (10769)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'AP' where idusuario in (11868)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'NC' where idusuario in (10653)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = 'IG' where idusuario in (9437,8252)");
     ejecuta_update($db_postgresql, "update usuarios set codigoejecutivosap = '**' where codigoejecutivosap is null and idagencia in (select idagencia from agencias where agencias.idnivel = 1)");
 
 
 // ACTUALIZA CATEGORIAS BENEFICIOS ADICIONALES
     echo '
 Asignando  categoriasbeneficiosadicionales...
 ';
     ejecuta_update($db_postgresql, "UPDATE categorias SET aceptabeneficiosadicionales = true WHERE idcategoria in (25, 29, 30, 40, 14, 22, 28, 37, 32, 35, 38, 26, 27, 23, 39, 24)");
 
 
 
 // ACTUALIZA CODIGOSCATEGORIASSAP
     echo '
 Asignando  codigoscategoriassap...
 ';
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='CR' WHERE idcategoria=25");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='NC' WHERE idcategoria=26");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='PV' WHERE idcategoria=40");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='PV' WHERE idcategoria=24");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='CO' WHERE idcategoria=14");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='LE' WHERE idcategoria=22");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='AM' WHERE idcategoria=23");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='ES' WHERE idcategoria=27");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='IN' WHERE idcategoria=28");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='NI' WHERE idcategoria=29");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='RR' WHERE idcategoria=30");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='PR' WHERE idcategoria=32");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='MS' WHERE idcategoria=35");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='PE' WHERE idcategoria=37");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='TO' WHERE idcategoria=38");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='IN' WHERE idcategoria=31");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='IC' WHERE idcategoria=33");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='CA' WHERE idcategoria=34");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='PT' WHERE idcategoria=36");
     ejecuta_update($db_postgresql, "UPDATE categorias set codigocategoriasap='AL' WHERE idcategoria=39");
 
 
 
 
 
 
 
 
 // ACTUALIZA FAMILIASPLANES
     echo '
 Asignando  idfamiliaplan...
 ';
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 33  WHERE UPPER(nombreplan) like '%GLOBAL%' AND idcategoria = 22");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 34  WHERE UPPER(nombreplan) like '%TOTAL%' AND idcategoria = 22");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 35  WHERE UPPER(nombreplan) like '%MAXIMUS%' AND idcategoria = 22");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 36  WHERE UPPER(nombreplan) like '%SUPREME%' AND idcategoria = 22");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 37  WHERE UPPER(nombreplan) like '%Euroshenguen%' AND idcategoria = 22");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 38  WHERE UPPER(nombreplan) like '%INTERNATIONAL GOLD%' AND idcategoria = 22");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 39  WHERE UPPER(nombreplan) like '%INTERNATIONAL PLATINUM%' AND idcategoria = 22");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 40  WHERE UPPER(nombreplan) like '%INTERNATIONAL PLATINUM 300%' AND idcategoria = 22");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 41  WHERE UPPER(nombreplan) like '%INTERNATIONAL PLUS%' AND idcategoria = 22");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 12 WHERE UPPER(nombreplan) like '%GLOBAL 30%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 13 WHERE UPPER(nombreplan) like '%GLOBAL 60%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 14 WHERE UPPER(nombreplan) like '%GLOBAL 90%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 15 WHERE UPPER(nombreplan) like '%TOTAL 30%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 16 WHERE UPPER(nombreplan) like '%TOTAL 60%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 17 WHERE UPPER(nombreplan) like '%TOTAL 90%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 18 WHERE UPPER(nombreplan) like '%MAXIMUS 30%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 19 WHERE UPPER(nombreplan) like '%MAXIMUS 60%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 20 WHERE UPPER(nombreplan) like '%MAXIMUS 90%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 21 WHERE UPPER(nombreplan) like '%SUPREME 30%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 22 WHERE UPPER(nombreplan) like '%SUPREME 60%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 23 WHERE UPPER(nombreplan) like '%SUPREME 90%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 24 WHERE UPPER(nombreplan) like '%PREMIER 30%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 25 WHERE UPPER(nombreplan) like '%PREMIER 60%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 26 WHERE UPPER(nombreplan) like '%PREMIER 90%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 27 WHERE UPPER(nombreplan) like '%PRESTIGE 30%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 28 WHERE UPPER(nombreplan) like '%PRESTIGE 60%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 29 WHERE UPPER(nombreplan) like '%PRESTIGE 90%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 30 WHERE UPPER(nombreplan) like '%SUMMIT 30%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 31 WHERE UPPER(nombreplan) like '%SUMMIT 60%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 32 WHERE UPPER(nombreplan) like '%SUMMIT 90%' AND idcategoria = 23");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 1 WHERE UPPER(nombreplan) like '%TRAVEL%' AND idcategoria = 24");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 2 WHERE UPPER(nombreplan) like '%GLOBAL%' AND idcategoria = 24");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 3 WHERE UPPER(nombreplan) like '%CONSUL%' AND idcategoria = 24");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 4 WHERE UPPER(nombreplan) like '%TOTAL%' AND idcategoria = 24");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 5 WHERE UPPER(nombreplan) like '%MAXIMUS%' AND idcategoria = 24");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 6 WHERE UPPER(nombreplan) like '%SUPREME%' AND idcategoria = 24");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 7 WHERE UPPER(nombreplan) like '%PREMIER%' AND idcategoria = 24");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 8 WHERE UPPER(nombreplan) like '%PRESTIGE%' AND idcategoria = 24");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 9 WHERE UPPER(nombreplan) like '%SUMMIT%' AND idcategoria = 24");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 10 WHERE UPPER(nombreplan) like '%UNLIMITED%' AND idcategoria = 24");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 11 WHERE UPPER(nombreplan) like '%PLATA 85%' AND idcategoria = 24");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 53 WHERE UPPER(nombreplan) like '%CRUISE TOTAL%' AND idcategoria = 25");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 54 WHERE UPPER(nombreplan) like '%CRUISE TOTAL C.G%' AND idcategoria = 25");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 55 WHERE UPPER(nombreplan) like '%CRUISE MAXIMUS%' AND idcategoria = 25");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 56 WHERE UPPER(nombreplan) like '%CRUISE MAXIMUS C.G%' AND idcategoria = 25");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 42 WHERE UPPER(nombreplan) like '%STUDENT%' AND idcategoria = 27");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 43 WHERE UPPER(nombreplan) like '%STUDENT Max%' AND idcategoria = 27");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 44 WHERE UPPER(nombreplan) like '%STUDENT PLUS%' AND idcategoria = 27");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 45 WHERE UPPER(nombreplan) like '%TRAVELER%' AND idcategoria = 28");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 46 WHERE UPPER(nombreplan) like '%GLOBAL%' AND idcategoria = 28");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 47 WHERE UPPER(nombreplan) like '%TOTAL%' AND idcategoria = 28");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 48 WHERE UPPER(nombreplan) like '%MAXIMUS%' AND idcategoria = 28");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 49 WHERE UPPER(nombreplan) like '%SUPREME%' AND idcategoria = 28");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 50 WHERE UPPER(nombreplan) like '%PREMIER%' AND idcategoria = 28");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 51 WHERE UPPER(nombreplan) like '%PRESTIGE%' AND idcategoria = 28");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 52 WHERE UPPER(nombreplan) like '%SUMMIT%' AND idcategoria = 28");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 57 WHERE UPPER(nombreplan) like '%MAXIMUS%' AND idcategoria = 38");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 58 WHERE UPPER(nombreplan) like '%TOTAL%' AND idcategoria = 38");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 59 WHERE UPPER(nombreplan) like '%TRAVELER NACIONAL%' AND idcategoria = 26");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 59 WHERE UPPER(nombreplan) like '%TOTAL INTERNACIONAL%' AND idcategoria = 26");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 60 WHERE UPPER(nombreplan) like '%MAXIMUS NACIONAL%' AND idcategoria = 26");
     ejecuta_update($db_postgresql, "UPDATE planes SET idfamiliaplan = 60 WHERE UPPER(nombreplan) like '%MAXIMUS INTERNACIONAL%' AND idcategoria = 26");
 











    $hora_fin   = date('h:i:s', time());  




    die( "hora_fin ". $hora_fin . pg_last_error($db_postgresql));


?>