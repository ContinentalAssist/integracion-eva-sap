<?php 
    $db_postgresql      = getDB();
    $db_mysql           = connect_db();

    $hora_inicio        = date('h:i:s', time());

    $limpiar_tablas = true;

    if($limpiar_tablas)
    {
        echo 'Borrando crucerosordenes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE crucerosordenes CASCADE");

        echo 'Borrando beneficiarioscostos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE beneficiarioscostos CASCADE");

        echo 'Borrando beneficiariosbeneficiosadicionales...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE beneficiariosbeneficiosadicionales CASCADE");

        echo 'Borrando beneficiarios...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE beneficiarios CASCADE");

        echo 'Borrando asistenciascorporativas...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE asistenciascorporativas CASCADE");

        echo 'Borrando asistenciascorporativasviajes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE asistenciascorporativasviajes CASCADE");

        echo 'Borrando asistenciasviajes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE asistenciasviajes CASCADE");

        echo 'Borrando precompras...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE precompras CASCADE");

        echo 'Borrando ordenescomisiones...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE ordenescomisiones CASCADE");

        echo 'Borrando ordenescontactos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE ordenescontactos CASCADE");

        echo 'Borrando ordenes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE ordenes CASCADE");
    
    
        ejecuta_update($db_postgresql, "ALTER SEQUENCE crucerosordenes_idcruceroorden_seq RESTART WITH 1");
        ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficiarioscostos_idbeneficiariocosto_seq RESTART WITH 1");
        ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficiariosbeneficiosadicio_idbeneficiariobeneficioadicio_seq RESTART WITH 1");
        ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficiarios_idbeneficiario_seq RESTART WITH 1");
        ejecuta_update($db_postgresql, "ALTER SEQUENCE asistenciasviajes_idasistenciaviaje_seq RESTART WITH 1");
        ejecuta_update($db_postgresql, "ALTER SEQUENCE precompra_idprecompra_seq RESTART WITH 1");
        ejecuta_update($db_postgresql, "ALTER SEQUENCE ordenes_idorden_seq RESTART WITH 1");
        ejecuta_update($db_postgresql, "ALTER SEQUENCE ordenescomisiones_idordencomision_seq RESTART WITH 1");
        ejecuta_update($db_postgresql, "ALTER SEQUENCE ordenescontactos_idordencontacto_seq RESTART WITH 1");
        ejecuta_update($db_postgresql, "ALTER SEQUENCE asistenciascorporativasviajes_idasistenciacorporativaviaje_seq RESTART WITH 1");
        ejecuta_update($db_postgresql, "ALTER SEQUENCE asistenciascorporativas_idasistenciacorporativa_seq RESTART WITH 1");
        
    }
    
    // ORDENES *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: ordenes';

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

        $last_id_orden = ejecuta_select($db_postgresql, 'SELECT MAX(idorden) as idorden FROM ordenes ORDER BY idorden DESC', 'idorden');
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
                        COALESCE(id_cia, 1) as idsistema,
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
                            WHEN destino = 1 THEN 'EUR'
                            WHEN destino = 2 THEN 'AME'
                            WHEN destino = 3 THEN 'NAC'
                            ELSE 'AME'
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
                            WHEN broker.id_site = 5 THEN 'COP'
                            WHEN broker.id_site = 11 THEN 'MXN'
                            ELSE 'USD'
                        END as moneda_,
                        ifnull((SELECT DISTINCT valor FROM exchange where DATE_FORMAT(exchange.horainsert, '%Y-%m-%d')= orders.fecha and DATE_FORMAT(exchange.horabanco, '%Y-%m-%d')= orders.fecha and exchange.currency = moneda_ and exchange.tipo = 1 order by 1 desc LIMIT 1 ),1) as cambio
                    FROM orders 
                    LEFT JOIN broker ON orders.agencia = broker.id_broker
                    WHERE 
                    orders.id > $last_id_orden AND 
                    orders.fecha >= '2023-01-01'
                    AND orders.fecha <= '2023-12-31'
                    ORDER BY id ASC 
                ";


        $mysql_ = $db_mysql->query($select);

        while ($row = $mysql_->fetch_array(MYSQLI_ASSOC)) 
        {
            $registros[] = $row;
        }

        $cantidad_registros = count($registros);
    
        foreach($registros as $registro)
        {           
            $contador_ordenes = $contador_ordenes + 1;

            if($contador_ordenes % 1000 == 0 )
            {
                echo 'Procesados '.$contador_ordenes.' de '.$cantidad_registros.'
                ';
            }

            if($registro['idagencia'] != 0)
            {
                $idorden                = $registro['idorden'];
                $idtipoasistencia       = $registro['idtipoasistencia'];
                $idplan                 = $registro['idplan'];

                if($registro['idstatus'] == 0)
                {
                        $idstatus = 2;
                }
                else if($registro['idstatus'] == 2)
                {
                        $idstatus = 9;
                }
                else
                {
                        $idstatus = $registro['idstatus'];
                }

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

                $nombrecontacto         = $registro['nombrecontacto'];
                $correocontacto         = $registro['correocontacto'];
                $telefonocontacto       = $registro['telefonocontacto'];

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
    
                $insert = "INSERT INTO ordenes (
                                            idorden,
                                            idtipoasistencia,
                                            idstatus,
                                            codigovoucher,
                                            idagencia,
                                            idcorporativo,
                                            idmoneda,
                                            total,
                                            emisioncorporativa,
                                            cargamanual,
                                            idcupon,
                                            fechacreacion,
                                            fechamodificacion,
                                            idusuario,
                                            idplataformapago,
                                            tdctipo,
                                            tdcnumero,
                                            tdctitular,
                                            tdcexpiracion,
                                            respuestapago,
                                            referencia,
                                            idsistema,
                                            idempresa,
                                            idfuente,
                                            ip,
                                            comentarios,
                                            cargaprecompra,
                                            idprecompra,
                                            tiempoproducto,
                                            porcentajeincentivo,
                                            montoincentivo,
                                            tasacambio
                                            )
                                        VALUES
                                        (
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
                // echo 'o-';   
    
                if(ejecuta_insert($db_postgresql, $insert))
                {
                    // COMISIONES
                        $contador_comisiones = 1;
                        while($contador_comisiones <= 4)
                        {
                            $idagencia     = 'idagencianivel'.$contador_comisiones;
                            $idagencia     = $$idagencia;

                            $porcentaje     = 'porcentajenivel'.$contador_comisiones;
                            $porcentaje     = $$porcentaje;
                            
                            $monto          = 'montonivel'.$contador_comisiones;
                            $monto         = $$monto;

                            $insert_ordenes_comisiones = "INSERT INTO ordenescomisiones
                                                                    (
                                                                        idorden,
                                                                        idagencia,
                                                                        idnivel,
                                                                        porcentaje,
                                                                        monto
                                                                    )
                                                                VALUES 
                                                                    (
                                                                        $idorden,
                                                                        $idagencia,
                                                                        $contador_comisiones,
                                                                        $porcentaje,
                                                                        $monto
                                                                    ); ";

                            if(!ejecuta_insert($db_postgresql, $insert_ordenes_comisiones))
                            {
                                echo 'ERROR INSERTANDO COMISIONES: '.$insert_ordenes_comisiones; exit;
                            }
                                $contador_comisiones++;
                            
                        }


                    //COSTOS 
                        $contador_costos = 1;
                        while($contador_costos <= 2)
                        {
                            $costo     = 'costo'.$contador_costos;
                            $costo     = $$costo;

                            $insert_ordenes_costos = "INSERT INTO ordenescostos
                                                                    (
                                                                        idorden,
                                                                        idproveedor,
                                                                        costo
                                                                    )
                                                                VALUES 
                                                                    (
                                                                        $idorden,
                                                                        $contador_costos,
                                                                        $costo
                                                                    ); ";

                            if(!ejecuta_insert($db_postgresql, $insert_ordenes_costos))
                            {
                                echo 'ERROR INSERTANDO COSTOS: '.$insert_ordenes_costos; exit;
                            }
                                $contador_costos++;
                        }
                        

                    //CONTACTOS
                        $insert_ordenes_contactos = "INSERT INTO ordenescontactos
                                                                (
                                                                    idorden,
                                                                    nombrecontacto,
                                                                    correocontacto,
                                                                    telefonocontacto
                                                                )
                                                            VALUES 
                                                                (
                                                                    $idorden,
                                                                    UPPER('$nombrecontacto'),
                                                                    '$correocontacto',
                                                                    '$telefonocontacto'
                                                                ); ";

                        if(!ejecuta_insert($db_postgresql, $insert_ordenes_contactos))
                        {
                            echo 'ERROR INSERTANDO COSTOS: '.$insert_ordenes_contactos; exit;
                        }


                    //ASISTENCIAS VIAJES
                    if($registro['fechadesde'] != '0000-00-00 00:00:00' 
                    && $registro['fechadesde'] != '0000-00-00' 
                    && $registro['fechahasta'] != '0000-00-00 00:00:00' 
                    && $registro['fechahasta'] != '0000-00-00' 
                    && $registro['idcategoria'] != null
                    && $registro['idplan'] != null
                    && $registro['idcategoria'] != 32
                    )
                    {
                        $idorden        = $registro['idorden'];
                        $fechadesde     = $registro['fechadesde'];
                        $fechahasta     = $registro['fechahasta'];
                        
                        $origen         = ($registro['idorigen'] == '1S' || $registro['idorigen'] == 'US' || $registro['idorigen'] == ''  )  ? 'COM' : $registro['idorigen'];
                        $origen         = $origen == 'AN' ? 'AG' : $origen;
                        $select_pais    = ($registro['idorigen'] == '') ? "SELECT agencias.idpais as idpais FROM agencias WHERE agencias.idagencia = $idagencia" : "SELECT idpais FROM paises WHERE codigopais = '$origen'";
                        $idorigen       = ejecuta_select($db_postgresql, $select_pais, "idpais");
                        $idorigen       = ($idorigen == 0) ? 283 : $idorigen;
                        $destinos       = ($registro['destinos'] == '') ? 'AME' : $registro['destinos'];
                        $idcategoria    = $registro['idcategoria'];
                        $idplan         = $registro['idplan'];
                        $planfamiliar   = $registro['planfamiliar'] == '' ? 'f' : $registro['planfamiliar'];
                        $comentarios    = $registro['comentarios'];
    
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
                                            VALUES
                                                (
                                                    $idorden, 
                                                    '$fechadesde', 
                                                    '$fechahasta', 
                                                    $idorigen, 
                                                    '$destinos', 
                                                    $idcategoria, 
                                                    $idplan, 
                                                    '$planfamiliar', 
                                                    '$comentarios'
                                                );";

                        // echo 'a-';
    
                        if(ejecuta_insert($db_postgresql, $insert_asistenciasviajes))
                        {
                            $contador_asistencias_viajes_insertadas++;

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
                                                    WHERE id_orden = $idorden
                                                    ORDER BY id ASC
                                                ";

                            // echo $select_beneficiarios; exit;

                            $mysql_beneficiarios = $db_mysql->query($select_beneficiarios);

                            while ($row_beneficiarios = $mysql_beneficiarios->fetch_array(MYSQLI_ASSOC)) 
                            {
                                $row_array_beneficiarios[] = $row_beneficiarios;

                            }

                            if(count($row_array_beneficiarios) > 0)
                            {
                                $consecutivo = 1;
                                foreach($row_array_beneficiarios as $beneficiario)
                                {                                    
                                    $idbeneficiario         = $beneficiario['idbeneficiario'];
                                    $idorden                = $beneficiario['idorden'];
                                    $nombrebeneficiario     = $beneficiario['nombrebeneficiario'];
                                    $apellidobeneficiario   = $beneficiario['apellidobeneficiario'];
                                    $correobeneficiario     = $beneficiario['correobeneficiario'];
                                    $telefono               = $beneficiario['telefono'];
                                    $fechanacimiento        = $beneficiario['fechanacimiento'];
                                    $documentacion          = $beneficiario['documentacion'];
                                    $idstatus               = $beneficiario['idstatus'];
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

                                    if($apellidobeneficiario == 'notprovided')
                                    {
                                        $exp_nombrebeneficiario = explode(" ", $nombrebeneficiario);

                                        if(is_array($exp_nombrebeneficiario))
                                        {
                                            if(count($exp_nombrebeneficiario) == 1)
                                            {
                                                $nombrebeneficiario     = $exp_nombrebeneficiario[0];
                                            }
                                            if(count($exp_nombrebeneficiario) == 2)
                                            {
                                                $nombrebeneficiario     = $exp_nombrebeneficiario[0];
                                                $apellidobeneficiario   = $exp_nombrebeneficiario[1];
                                            }
                                            else if(count($exp_nombrebeneficiario) == 3)
                                            {
                                                $nombrebeneficiario     = $exp_nombrebeneficiario[0];
                                                $apellidobeneficiario   = $exp_nombrebeneficiario[1].' '.$exp_nombrebeneficiario[2];
                                            }
                                            else if(count($exp_nombrebeneficiario) == 4)
                                            {
                                                $nombrebeneficiario     = $exp_nombrebeneficiario[0].' '.$exp_nombrebeneficiario[1];
                                                $apellidobeneficiario   = $exp_nombrebeneficiario[2].' '.$exp_nombrebeneficiario[3];
                                            }
                                            else if(count($exp_nombrebeneficiario) == 5)
                                            {
                                                $nombrebeneficiario     = $exp_nombrebeneficiario[0].' '.$exp_nombrebeneficiario[1].' '.$exp_nombrebeneficiario[2];
                                                $apellidobeneficiario   = $exp_nombrebeneficiario[3].' '.$exp_nombrebeneficiario[4];
                                            }
                                            else if(count($exp_nombrebeneficiario) == 6)
                                            {
                                                $nombrebeneficiario     = $exp_nombrebeneficiario[0].' '.$exp_nombrebeneficiario[1].' '.$exp_nombrebeneficiario[2].' '.$exp_nombrebeneficiario[3];
                                                $apellidobeneficiario   = $exp_nombrebeneficiario[4].' '.$exp_nombrebeneficiario[5];
                                            }
                                        }

                                    }

                                    if($beneficiario['fechanacimiento'] == NULL || $beneficiario['fechanacimiento'] == 'NULL')
                                    {
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
                                                                        consecutivo
                                                                    ) 
                                                                VALUES (
                                                                        $idbeneficiario,
                                                                        $idorden,
                                                                        NULL,
                                                                        UPPER('$nombrebeneficiario'),
                                                                        UPPER('$apellidobeneficiario'),
                                                                        LOWER('$correobeneficiario'),
                                                                        '$telefono',
                                                                        NULL,
                                                                        '$documentacion',
                                                                        $idstatus,
                                                                        $precioventa,
                                                                        $consecutivo 
                                                                ); " ;
                                    }
                                    else
                                    {
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
                                                                        consecutivo
                                                                    ) 
                                                                VALUES (
                                                                        $idbeneficiario,
                                                                        $idorden,
                                                                        NULL,
                                                                        UPPER('$nombrebeneficiario'),
                                                                        UPPER('$apellidobeneficiario'),
                                                                        LOWER('$correobeneficiario'),
                                                                        '$telefono',
                                                                        '$fechanacimiento',
                                                                        '$documentacion',
                                                                        $idstatus,
                                                                        $precioventa,
                                                                        $consecutivo 
                                                                ); " ;
                                    }

                                    // echo 'b-';

                                    if(ejecuta_insert($db_postgresql, $insert_beneficiarios))
                                    {
                                        //COSTOS 
                                            $contador_costo = 1;
                                            while($contador_costo <= 2)
                                            {
                                                $costo     = 'costo'.$contador_costo;
                                                $costo     = $$costo;

                                                $insert_beneficarios_costos = "INSERT INTO beneficiarioscostos (
                                                                                            idbeneficiario,
                                                                                            idproveedor,
                                                                                            costo
                                                                                        )
                                                                                        VALUES (
                                                                                            $idbeneficiario,
                                                                                            $contador_costo,
                                                                                            $costo
                                                                                        )";

                                                ejecuta_insert($db_postgresql, $insert_beneficarios_costos);

                                                $contador_costo++;
                                            }
                                        
                                        //BENEFICIOS ADICIONALES
                                            if($id_rider > 0 && $costobeneficio1 > 0)
                                            {
                                                $insert_beneficio_adicional = "INSERT INTO beneficiariosbeneficiosadicionales (
                                                                                        idbeneficiario,
                                                                                        idbeneficioadicional,
                                                                                        precio
                                                                                    ) VALUES (
                                                                                        $idbeneficiario,
                                                                                        $id_rider,
                                                                                        $costobeneficio1
                                                                                    ) "; 
                                                
                                                if(!ejecuta_insert($db_postgresql, $insert_beneficio_adicional))
                                                {
                                                    echo $insert_beneficio_adicional; exit;
                                                }
                                            }

                                            if($id_rider2 > 0 && $costobeneficio2 > 0)
                                            {
                                                $insert_beneficio_adicional = "INSERT INTO beneficiariosbeneficiosadicionales (
                                                                                        idbeneficiario,
                                                                                        idbeneficioadicional,
                                                                                        precio
                                                                                    ) VALUES (
                                                                                        $idbeneficiario,
                                                                                        $id_rider2,
                                                                                        $costobeneficio2
                                                                                    ) ";
                                                
                                                if(!ejecuta_insert($db_postgresql, $insert_beneficio_adicional))
                                                {
                                                    echo $insert_beneficio_adicional; exit;
                                                }
                                            }

                                            if($cancel_precio > 0)
                                            {
                                                $insert_beneficio_adicional = "INSERT INTO beneficiariosbeneficiosadicionales (
                                                                                    idbeneficiario,
                                                                                    idbeneficioadicional,
                                                                                    precio,
                                                                                    monto,
                                                                                    cobertura
                                                                                ) VALUES (
                                                                                    $idbeneficiario,
                                                                                    38,
                                                                                    $cancel_precio,
                                                                                    $cancel_monto,
                                                                                    $cancel_cobertura
                                                                                ) ";
            
                                                if(!ejecuta_insert($db_postgresql, $insert_beneficio_adicional))
                                                {
                                                    echo $insert_beneficio_adicional; exit;
                                                }
                                            }


                                        $contador_beneficiarios_viajes_insertados++;
                                    }
                                    else
                                    {
                                        echo $insert_beneficiarios;
                                    }

                                    $consecutivo++;
                                }
                            }

                            $row_array_beneficiarios = array();
                        }
                        else
                        {
                            echo $insert_asistenciasviajes;
                        }
                    }
                    else if($registro['emisioncorporativa'] == 1 && $registro['fechadesde'] == '0000-00-00') //EMISIONES CORPORATIVAS
                    {
                        $insert_asistenciacorporativa = "INSERT INTO asistenciascorporativas (
                                                                    idorden,
                                                                    idplan,
                                                                    tiempoproducto
                                                                ) 
                                                            VALUES (
                                                                    $idorden,
                                                                    $idplan,
                                                                    $tiempoproducto
                                                            ); " ;

                        if(ejecuta_insert($db_postgresql, $insert_asistenciacorporativa))
                        {
                            $select_asistenciacorporativa = "SELECT  
                                                                id as idasistenciacorporativaviaje,
                                                                orden as idorden,
                                                                salida as fechadesde,
                                                                retorno as fechahasta,
                                                                origen as idorigen,
                                                                CASE
                                                                    WHEN destino = 1 THEN 'EUR'
                                                                    WHEN destino = 2 THEN 'AME'
                                                                    WHEN destino = 3 THEN 'NAC'
                                                                    ELSE 'AME'
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
                                                            WHERE orden = $idorden
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
                                    $idorigen       = ($idorigen == 0) ? 283 : $idorigen;
                                    $destinos                       = $asistenciacorporativa['destinos'];
                                    $codigovoucheremision           = $asistenciacorporativa['codigovoucheremision'];
                                    $fechacreacion                  = $asistenciacorporativa['fechacreacion'];
                                    $fechamodificacion              = ($asistenciacorporativa['fechamodificacion'] == '0000-00-00 00:00:00') ? $asistenciacorporativa['fechacreacion'] : $asistenciacorporativa['fechamodificacion'];
                                    $idagente                       = $asistenciacorporativa['idagente'];
                                    $idstatus                       = $asistenciacorporativa['idstatus'];
                                    $planfamiliar                   = $asistenciacorporativa['planfamiliar'];
                                    $comentarios                    = $asistenciacorporativa['comentarios'];

                                    $nombrecontacto                 = $asistenciacorporativa['nombrecontacto'];
                                    $correocontacto                 = $asistenciacorporativa['correocontacto'];
                                    $telefonocontacto               = $asistenciacorporativa['telefonocontacto'];
    
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
                                                                        VALUES (
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
                                                                        ); " ;
    
    
                                    // echo 'ac-';
                                    
                                    if(ejecuta_insert($db_postgresql, $insert_asistenciacorporativaviaje))
                                    {
                                        $insert_contactos_asistenciacorporativaviaje = "INSERT INTO ordenescontactos (
                                                                                                idorden,
                                                                                                idordencorporativa,
                                                                                                nombrecontacto,
                                                                                                correocontacto,
                                                                                                telefonocontacto
                                                                                            ) 
                                                                                        VALUES (
                                                                                                $idorden,
                                                                                                $idasistenciacorporativaviaje,
                                                                                                '$nombrecontacto',
                                                                                                '$correocontacto',
                                                                                                '$telefonocontacto'
                                                                                        ); " ;

                                        if(ejecuta_insert($db_postgresql, $insert_contactos_asistenciacorporativaviaje))
                                        {
                                            $contador_asistencias_viajes_insertadas++;
        
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
                                                    $nombrebeneficiario     = $beneficiario_corporativo['nombrebeneficiario'];
                                                    $apellidobeneficiario   = $beneficiario_corporativo['apellidobeneficiario'];
                                                    $correobeneficiario     = $beneficiario_corporativo['correobeneficiario'];
                                                    $telefono               = $beneficiario_corporativo['telefono'];
                                                    $fechanacimiento        = $beneficiario_corporativo['fechanacimiento'];
                                                    $documentacion          = $beneficiario_corporativo['documentacion'];
                                                    $idstatus               = $beneficiario_corporativo['idstatus'];
                                                    $precioventa            = $beneficiario_corporativo['precioventa'];
        
                                                    if($beneficiario_corporativo['fechanacimiento'] == NULL || $beneficiario_corporativo['fechanacimiento'] == 'NULL')
                                                    {
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
                                                                                    ) 
                                                                                VALUES (
                                                                                        $idbeneficiario,
                                                                                        $idorden,
                                                                                        $idordencorporativa,
                                                                                        UPPER('$nombrebeneficiario'),
                                                                                        UPPER('$apellidobeneficiario'),
                                                                                        LOWER('$correobeneficiario'),
                                                                                        '$telefono',
                                                                                        NULL,
                                                                                        '$documentacion',
                                                                                        $idstatus,
                                                                                        $precioventa,
                                                                                        $consecutivo,
                                                                                        '$fechadesde',
                                                                                        '$fechahasta' 
                                                                                ); " ;
                                                    }
                                                    else
                                                    {
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
                                                                                    ) 
                                                                                VALUES (
                                                                                        $idbeneficiario,
                                                                                        $idorden,
                                                                                        $idordencorporativa,
                                                                                        UPPER('$nombrebeneficiario'),
                                                                                        UPPER('$apellidobeneficiario'),
                                                                                        LOWER('$correobeneficiario'),
                                                                                        '$telefono',
                                                                                        '$fechanacimiento',
                                                                                        '$documentacion',
                                                                                        $idstatus,
                                                                                        $precioventa,
                                                                                        $consecutivo,
                                                                                        '$fechadesde',
                                                                                        '$fechahasta'
                                                                                ); " ;
                                                    }
        
                                                    if(ejecuta_insert($db_postgresql, $insert_beneficiarios))
                                                    {
                                                        $contador_costo = 1;
                                                        while($contador_costo <= 2)
                                                        {
                                                            $costo     = 'costo'.$contador_costo;
                                                            $costo     = $$costo;
        
                                                            $insert_beneficarios_costos = "INSERT INTO beneficiarioscostos (
                                                                                                        idbeneficiario,
                                                                                                        idproveedor,
                                                                                                        costo
                                                                                                    )
                                                                                                    VALUES (
                                                                                                        $idbeneficiario,
                                                                                                        $contador_costo,
                                                                                                        $costo
                                                                                                    )";
        
                                                            ejecuta_insert($db_postgresql, $insert_beneficarios_costos);
        
                                                            $contador_costo++;
                                                        }
                                                        
                                                        $contador_beneficiarios_viajes_corporativos_insertados++;
                                                    }
                                                    else
                                                    {
                                                        echo $insert_beneficiarios;
                                                    }
        
                                                    $consecutivo++;
                                                }
                                            }
        
                                            $row_array_beneficiarios_corporativos = array();
                                        }
                                        else
                                        {
                                            echo $insert_contactos_asistenciacorporativaviaje;
                                        }
                                    }
                                    else
                                    {
                                        echo $insert_asistenciacorporativaviaje;
                                    }
                                }
                            }
    
                            $row_asistenciacorporativa = array();
                            
                            $contador_ordenes_corporativas++;
                        }
                        else
                        {
                            echo $insert_asistenciacorporativa;
                            exit;
                        }
                    }
                    else // PRECOMPRAS
                    {
                        if($cargaprecompra) //CARGA PRECOMPRA
                        {
                            $select_precompra = "SELECT  
                                                    id as idprecompra,
                                                    IF(status = 1, 1, 2) as idstatus,
                                                    fecha_precompra as fechaprecompra,
                                                    voucher as idorden
                                                FROM precompra
                                                WHERE voucher = $idorden
                                            ";

                            $mysql_precompra = $db_mysql->query($select_precompra);

                            while ($row_precompra = $mysql_precompra->fetch_array(MYSQLI_ASSOC)) 
                            {
                                if(count($row_precompra) > 0)
                                {
                                    $idprecompra        = $row_precompra['idprecompra'];
                                    $idstatus           = $row_precompra['idstatus'];
                                    $fechaprecompra     = $row_precompra['fechaprecompra'];

                                    $insert_precompra = "INSERT INTO precompras (
                                                                        idprecompra,
                                                                        idstatus,
                                                                        fechaprecompra,
                                                                        idorden
                                                                    ) 
                                                                VALUES (
                                                                        $idprecompra,
                                                                        $idstatus,
                                                                        '$fechaprecompra',
                                                                        $idorden
                                                                ); " ;
                                    // echo 'p-';

                                    if(ejecuta_insert($db_postgresql, $insert_precompra))
                                    {
                                        
                                    }
                                    else
                                    {
                                        echo $insert_precompra;
                                    }
                                }
                            }
                        }
                        else // EMISIONES DE PRECOMPRA
                        {
                            if($registro['idcategoria'] == 32 && $registro['fechadesde'] != '0000-00-00' && $registro['fechahasta'] != '0000-00-00')
                            {
                                $contador_emisiones_precompras++;

                                $idorden        = $registro['idorden'];
                                $fechadesde     = $registro['fechadesde'];
                                $fechahasta     = $registro['fechahasta'];
                                $origen         = ($registro['idorigen'] == '1S' || $registro['idorigen'] == 'US' || $registro['idorigen'] == ''  )  ? 'COM' : $registro['idorigen'];
                                $origen         = $origen == 'AN' ? 'AG' : $origen;
                                $select_pais    = ($registro['idorigen'] == '') ? "SELECT agencias.idpais as idpais FROM agencias WHERE agencias.idagencia = $idagencia" : "SELECT idpais FROM paises WHERE codigopais = '$origen'";
                                $idorigen       = ejecuta_select($db_postgresql, $select_pais, "idpais");
                                $idorigen       = ($idorigen == 0) ? 283 : $idorigen;
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
                                                $insert_emision_precompra_asistenciasviajes = "INSERT INTO asistenciasviajes
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
                                                                                            VALUES
                                                                                                (
                                                                                                    $idorden, 
                                                                                                    '$fechadesde', 
                                                                                                    '$fechahasta', 
                                                                                                    $idorigen, 
                                                                                                    '$destinos', 
                                                                                                    $idcategoria, 
                                                                                                    $idplan, 
                                                                                                    '$planfamiliar', 
                                                                                                    '$comentarios'
                                                                                                );";

                                                if(ejecuta_insert($db_postgresql, $insert_emision_precompra_asistenciasviajes))
                                                {
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
                                                                            WHERE id_orden = $idorden
                                                                            ORDER BY id ASC
                                                                        ";

                                                    $mysql_beneficiarios = $db_mysql->query($select_beneficiarios);

                                                    while ($row_beneficiarios = $mysql_beneficiarios->fetch_array(MYSQLI_ASSOC)) 
                                                    {
                                                        $row_array_beneficiarios[] = $row_beneficiarios;

                                                    }

                                                    if(count($row_array_beneficiarios) > 0)
                                                    {
                                                        $consecutivo = 1;
                                                        foreach($row_array_beneficiarios as $beneficiario)
                                                        {                                    
                                                            $idbeneficiario         = $beneficiario['idbeneficiario'];
                                                            $idorden                = $beneficiario['idorden'];
                                                            $nombrebeneficiario     = $beneficiario['nombrebeneficiario'];
                                                            $apellidobeneficiario   = $beneficiario['apellidobeneficiario'];
                                                            $correobeneficiario     = $beneficiario['correobeneficiario'];
                                                            $telefono               = $beneficiario['telefono'];
                                                            $fechanacimiento        = $beneficiario['fechanacimiento'];
                                                            $documentacion          = $beneficiario['documentacion'];
                                                            $idstatus               = $beneficiario['idstatus'];
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

                                                            if($apellidobeneficiario == 'notprovided')
                                                            {
                                                                $exp_nombrebeneficiario = explode(" ", $nombrebeneficiario);

                                                                if(is_array($exp_nombrebeneficiario))
                                                                {
                                                                    if(count($exp_nombrebeneficiario) == 1)
                                                                    {
                                                                        $nombrebeneficiario     = $exp_nombrebeneficiario[0];
                                                                    }
                                                                    if(count($exp_nombrebeneficiario) == 2)
                                                                    {
                                                                        $nombrebeneficiario     = $exp_nombrebeneficiario[0];
                                                                        $apellidobeneficiario   = $exp_nombrebeneficiario[1];
                                                                    }
                                                                    else if(count($exp_nombrebeneficiario) == 3)
                                                                    {
                                                                        $nombrebeneficiario     = $exp_nombrebeneficiario[0];
                                                                        $apellidobeneficiario   = $exp_nombrebeneficiario[1].' '.$exp_nombrebeneficiario[2];
                                                                    }
                                                                    else if(count($exp_nombrebeneficiario) == 4)
                                                                    {
                                                                        $nombrebeneficiario     = $exp_nombrebeneficiario[0].' '.$exp_nombrebeneficiario[1];
                                                                        $apellidobeneficiario   = $exp_nombrebeneficiario[2].' '.$exp_nombrebeneficiario[3];
                                                                    }
                                                                    else if(count($exp_nombrebeneficiario) == 5)
                                                                    {
                                                                        $nombrebeneficiario     = $exp_nombrebeneficiario[0].' '.$exp_nombrebeneficiario[1].' '.$exp_nombrebeneficiario[2];
                                                                        $apellidobeneficiario   = $exp_nombrebeneficiario[3].' '.$exp_nombrebeneficiario[4];
                                                                    }
                                                                    else if(count($exp_nombrebeneficiario) == 6)
                                                                    {
                                                                        $nombrebeneficiario     = $exp_nombrebeneficiario[0].' '.$exp_nombrebeneficiario[1].' '.$exp_nombrebeneficiario[2].' '.$exp_nombrebeneficiario[3];
                                                                        $apellidobeneficiario   = $exp_nombrebeneficiario[4].' '.$exp_nombrebeneficiario[5];
                                                                    }
                                                                }

                                                            }

                                                            if($beneficiario['fechanacimiento'] == NULL || $beneficiario['fechanacimiento'] == 'NULL')
                                                            {
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
                                                                                                consecutivo
                                                                                            ) 
                                                                                        VALUES (
                                                                                                $idbeneficiario,
                                                                                                $idorden,
                                                                                                NULL,
                                                                                                UPPER('$nombrebeneficiario'),
                                                                                                UPPER('$apellidobeneficiario'),
                                                                                                LOWER('$correobeneficiario'),
                                                                                                '$telefono',
                                                                                                NULL,
                                                                                                '$documentacion',
                                                                                                $idstatus,
                                                                                                $precioventa,
                                                                                                $consecutivo 
                                                                                        ); " ;
                                                            }
                                                            else
                                                            {
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
                                                                                                consecutivo
                                                                                            ) 
                                                                                        VALUES (
                                                                                                $idbeneficiario,
                                                                                                $idorden,
                                                                                                NULL,
                                                                                                UPPER('$nombrebeneficiario'),
                                                                                                UPPER('$apellidobeneficiario'),
                                                                                                LOWER('$correobeneficiario'),
                                                                                                '$telefono',
                                                                                                '$fechanacimiento',
                                                                                                '$documentacion',
                                                                                                $idstatus,
                                                                                                $precioventa,
                                                                                                $consecutivo 
                                                                                        ); " ;
                                                            }

                                                            if(ejecuta_insert($db_postgresql, $insert_beneficiarios))
                                                            {
                                                                //COSTOS 
                                                                    $contador_costo = 1;
                                                                    while($contador_costo <= 2)
                                                                    {
                                                                        $costo     = 'costo'.$contador_costo;
                                                                        $costo     = $$costo;

                                                                        $insert_beneficarios_costos = "INSERT INTO beneficiarioscostos (
                                                                                                                    idbeneficiario,
                                                                                                                    idproveedor,
                                                                                                                    costo
                                                                                                                )
                                                                                                                VALUES (
                                                                                                                    $idbeneficiario,
                                                                                                                    $contador_costo,
                                                                                                                    $costo
                                                                                                                )";

                                                                        ejecuta_insert($db_postgresql, $insert_beneficarios_costos);

                                                                        $contador_costo++;
                                                                    }
                                                                
                                                                //BENEFICIOS ADICIONALES
                                                                    if($id_rider > 0 && $costobeneficio1 > 0)
                                                                    {
                                                                        $insert_beneficio_adicional = "INSERT INTO beneficiariosbeneficiosadicionales (
                                                                                                                idbeneficiario,
                                                                                                                idbeneficioadicional,
                                                                                                                precio
                                                                                                            ) VALUES (
                                                                                                                $idbeneficiario,
                                                                                                                $id_rider,
                                                                                                                $costobeneficio1
                                                                                                            ) "; 
                                                                        
                                                                        if(!ejecuta_insert($db_postgresql, $insert_beneficio_adicional))
                                                                        {
                                                                            echo $insert_beneficio_adicional; exit;
                                                                        }
                                                                    }

                                                                    if($id_rider2 > 0 && $costobeneficio2 > 0)
                                                                    {
                                                                        $insert_beneficio_adicional = "INSERT INTO beneficiariosbeneficiosadicionales (
                                                                                                                idbeneficiario,
                                                                                                                idbeneficioadicional,
                                                                                                                precio
                                                                                                            ) VALUES (
                                                                                                                $idbeneficiario,
                                                                                                                $id_rider2,
                                                                                                                $costobeneficio2
                                                                                                            ) ";
                                                                        
                                                                        if(!ejecuta_insert($db_postgresql, $insert_beneficio_adicional))
                                                                        {
                                                                            echo $insert_beneficio_adicional; exit;
                                                                        }
                                                                    }

                                                                    if($cancel_precio > 0)
                                                                    {
                                                                        $insert_beneficio_adicional = "INSERT INTO beneficiariosbeneficiosadicionales (
                                                                                                            idbeneficiario,
                                                                                                            idbeneficioadicional,
                                                                                                            precio,
                                                                                                            monto,
                                                                                                            cobertura
                                                                                                        ) VALUES (
                                                                                                            $idbeneficiario,
                                                                                                            38,
                                                                                                            $cancel_precio,
                                                                                                            $cancel_monto,
                                                                                                            $cancel_cobertura
                                                                                                        ) ";
                                    
                                                                        if(!ejecuta_insert($db_postgresql, $insert_beneficio_adicional))
                                                                        {
                                                                            echo $insert_beneficio_adicional; exit;
                                                                        }
                                                                    }


                                                                $contador_beneficiarios_viajes_insertados++;
                                                            }
                                                            else
                                                            {
                                                                echo $insert_beneficiarios;
                                                            }

                                                            $consecutivo++;
                                                        }
                                                    }

                                                    $row_array_beneficiarios = array();
                                                }
                                                else
                                                {
                                                    echo 'Error al insertar precompra en asistenciaviajes: '.$insert_emision_precompra_asistenciasviajes;
                                                }
                                        }
                                        else
                                        {
                                            echo 'Error al asociar (update) emision de precompra';
                                            echo $insert_emision_precompra;
                                        }
                                    }
                                }
                                
                                $idprecompra = $registro['idprecompra'];
                            }

                            if($cargamanual)
                            {
                                $contador_cargas_manuales++;
                            }
                            if($total)
                            {
                                $contador_ordenes_con_total_en_cero++;
                            }
                            else
                            {
                                echo 'fechadesde:'. $registro['fechadesde'];
                                echo 'fechadesde:'. $registro['fechadesde'];
                                echo 'fechahasta:'. $registro['fechahasta'];
                                echo 'fechahasta:'. $registro['fechahasta'];
                                echo 'destinos:'. $registro['destinos'];
                                echo 'idcategoria:'. $registro['idcategoria'];
                                echo 'idplan:'. $registro['idplan'];
                                echo 'asistencia rechazada';
                                echo $insert_precompra; 
                                $contador_asistencias_rechazadas++;
                            }
                        }
                    }
                }
                else
                {
                    echo 'insert rechazado';
                    echo $insert;
                }
            }
            else
            {
                if($registro['idagencia'] == 0)
                {
                    $contador_ordenes_con_agencia_cero++;
                }  
                
                if($registro['emisioncorporativa'] == 1 && $registro['fechadesde'] != '0000-00-00')
                {
                    $contador_ordenes_corporativas_no_validas++;
                }
            }
        }

        $secuencia = $idorden + 1;
        $secuencia = "ALTER SEQUENCE ordenes_idorden_seq RESTART WITH ".$secuencia; 
        ejecuta_select($db_postgresql, $secuencia);

        $secuencia = $idbeneficiario + 1;
        $secuencia = "ALTER SEQUENCE beneficiarios_idbeneficiario_seq RESTART WITH ".$secuencia; 
        ejecuta_select($db_postgresql, $secuencia);
    
   
    $ordenes_insertadas    = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM ordenes", 'cantidad');
  
    $hora_fin   = date('h:i:s', time());  

    echo 'Proceso Finalizado Exitosamente !'; 
?>
