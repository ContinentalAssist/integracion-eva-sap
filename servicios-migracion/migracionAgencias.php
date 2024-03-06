<?php 
    include('./lib/funciones.php');
    include('./lib/mysql.php');
    include('./lib/pgsql.php');

    $db_postgresql      = getDB();
    $db_mysql           = connect_db();

    system ('clear');

    $hora_inicio = date('h:i:s', time());

    $limpiar_tablas = true;

    if($limpiar_tablas)
    {
        /*** CUIDADO, SOLO INCLUIR $db_postgresql ***********************************************************/
        /**/ 
        /**/ 
        echo 'Borrando cuponesagencias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE cuponesagencias CASCADE");

        echo 'Borrando categoriasagencias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE categoriasagencias CASCADE");

        echo 'Borrando planesagencias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesagencias CASCADE");

        echo 'Borrando agencias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE agencias CASCADE");

        echo 'Borrando comisionesagencias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE comisionesagencias CASCADE");

        echo 'Borrando corporativos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE corporativos CASCADE");
        
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE agencias_idagencia_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriasagencias_idcategoriaagencia_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cuponesagencias_idcuponagencia_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesagencias_idplanesagencias_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE corporativos_idcorporativo_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE comisiones_idcomisiones_seq RESTART WITH 1");
    }
    
    // AGENCIAS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: agencias';

        if($limpiar_tablas)
        {
            $last_id_agencia = 0;
        }
        else
        {
            $last_id_agencia = ejecuta_select($db_postgresql, 'SELECT MAX(idagencia) as idagencia FROM agencias ORDER BY idagencia DESC', 'idagencia');
        }
        
        $mysql    = $db_mysql->query("SELECT 
                                        broker.id_broker as idagencia,
                                        IF(id_cia = 0, 1, id_cia) as idsistema,
                                        UPPER(CAST(CONVERT(broker USING utf8) AS binary)) as nombreagencia,
                                        id_status as idstatus,
                                        broker.nivel as idnivel,
                                        id_site as idpais,
                                        CAST(CONVERT(phone1 USING utf8) AS binary) as telefono1,
                                        CAST(CONVERT(phone2 USING utf8) AS binary) as telefono2,
                                        CAST(CONVERT(phone3 USING utf8) AS binary) as telefono3,
                                        CAST(CONVERT(address USING utf8) AS binary) as direccion,
                                        date_up as fechacreacion,
                                        IF(account_manager = 0 OR account_manager IS NULL, 1076, account_manager) as idagente,
                                        img_broker as logoagencia,
                                        COALESCE(credito_base, 0) as creditobase,
                                        COALESCE(credito_actual, 0) as creditoactual,
                                        ver_precio as verprecio,
                                        solo_inclusion as versoloinclusion,
                                        multipais as multipais,
                                        CAST(CONVERT(banco USING utf8) AS binary) as banco,
                                        CAST(CONVERT(clabe_inter USING utf8) AS binary) as clabeinterbancaria,
                                        CAST(CONVERT(cuenta USING utf8) AS binary) as cuenta,
                                        UPPER(CAST(CONVERT(beneficiario USING utf8) AS binary)) as beneficiario,
                                        COALESCE(broker_nivel.parent, 0) as idagenciapadre,
                                        reporta as idagenciareporta,
                                        CAST(CONVERT(razon USING utf8) AS binary) as razonsocial,
                                        CAST(CONVERT(tax_id USING utf8) AS binary) as identificadortributaria,
                                        CAST(CONVERT(id_city USING utf8) AS binary) as ciudad,
                                        CAST(CONVERT(id_state USING utf8) AS binary) as estado,
                                        CAST(CONVERT(observations USING utf8) AS binary) as comentario,
                                        'CA' as acronimovoucher
                                    FROM broker
                                    LEFT join broker_nivel on broker.id_broker = broker_nivel.id_broker
                                    WHERE broker.id_broker > $last_id_agencia
                                    ORDER BY broker.id_broker ASC
                                    ");

        while ($row_agencias = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $registros[] = $row_agencias;
        }

        foreach($registros as $registro)
        {
            echo '.'; 

            $idagencia                  = $registro['idagencia'];
            $idsistema                  = $registro['idsistema'];
            $nombreagencia              = $registro['nombreagencia'];
            $idstatus                   = $registro['idstatus'];
            $idnivel                    = $registro['idnivel'];
            $idpais                     = $registro['idpais'] == 0 ? 283 : $registro['idpais'];
            $telefono1                  = $registro['telefono1'];
            $telefono2                  = $registro['telefono2'];
            $telefono3                  = $registro['telefono3'];
            $direccion                  = $registro['direccion'];
            $fechacreacion              = $registro['fechacreacion'];
            $idagente                   = $registro['idagente'];
            $logoagencia                = ($registro['logoagencia'] != '') ? 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/'.$registro['logoagencia'] : '';
            $creditobase                = $registro['creditobase'];
            $creditoactual              = $registro['creditoactual'];
            $verprecio                  = $registro['verprecio'];
            $versoloinclusion           = $registro['versoloinclusion'];
            $multipais                  = $registro['multipais'];
            $banco                      = $registro['banco'];
            $clabeinterbancaria         = $registro['clabeinterbancaria'];
            $cuenta                     = $registro['cuenta'];
            $beneficiario               = $registro['beneficiario'];
            $idagenciapadre             = $registro['idagenciapadre'];
            $idagenciareporta           = $registro['idagenciareporta'];
            $razonsocial                = $registro['razonsocial'];
            $identificadortributaria    = $registro['identificadortributaria'];
            $ciudad                     = $registro['ciudad'];
            $estado                     = $registro['estado'];
            $comentario                 = $registro['comentario'];
            $acronimovoucher            = $registro['acronimovoucher'];

            $insert = "INSERT INTO agencias (
                                        idagencia,
                                        idsistema,
                                        nombreagencia,
                                        idstatus,
                                        idnivel,
                                        idpais,
                                        telefono1,
                                        telefono2,
                                        telefono3,
                                        direccion,
                                        fechacreacion,
                                        idagente,
                                        logoagencia,
                                        creditobase,
                                        creditoactual,
                                        verprecio,
                                        versoloinclusion,
                                        multipais,
                                        banco,
                                        clabeinterbancaria,
                                        cuenta,
                                        beneficiario,
                                        idagenciapadre,
                                        idagenciareporta,
                                        razonsocial,
                                        identificadortributaria,
                                        ciudad,
                                        estado,
                                        comentario,
                                        acronimovoucher
                                        )
                                    VALUES(
                                        $idagencia,
                                        $idsistema,
                                        UPPER('$nombreagencia'),
                                        $idstatus,
                                        $idnivel,
                                        $idpais,
                                        '$telefono1',
                                        '$telefono2',
                                        '$telefono3',
                                        '$direccion',
                                        '$fechacreacion',
                                        $idagente,
                                        '$logoagencia',
                                        $creditobase,
                                        $creditoactual,
                                        '$verprecio',
                                        '$versoloinclusion',
                                        '$multipais',
                                        '$banco',
                                        '$clabeinterbancaria',
                                        '$cuenta',
                                        UPPER('$beneficiario'),
                                        $idagenciapadre,
                                        $idagenciareporta,
                                        '$razonsocial',
                                        '$identificadortributaria',
                                        UPPER('$ciudad'),
                                        UPPER('$estado'),
                                        '$comentario',
                                        '$acronimovoucher'
                                    )";

            if(ejecuta_insert($db_postgresql, $insert)) 
            {
                // BUSCA CATEGORIAS PLANES COMISIONES
                    $mysql_categorias_agencias = $db_mysql->query("SELECT DISTINCT
                                                                        plans.id as idplan,
                                                                        plans.id_plan_categoria as idcategoria,
                                                                        COALESCE(commissions.porcentaje,0) as porcentaje
                                                                    FROM plans
                                                                    LEFT JOIN commissions ON plans.id_plan_categoria = commissions.id_categoria AND commissions.id_agencia = $idagencia
                                                                    WHERE plans.id IN (
                                                                        SELECT DISTINCT orders.producto FROM orders WHERE orders.agencia = $idagencia)
                                                                    OR plans.id IN (
                                                                        SELECT DISTINCT
                                                                            plans.id 
                                                                        FROM plans 
                                                                        LEFT JOIN broker ON plans.id_site = broker.id_site
                                                                        WHERE broker.id_broker = $idagencia
                                                                        AND plans.publico = 1
                                                                    )");

                    $categorias_agencias = array();

                    while ($row_categorias = $mysql_categorias_agencias->fetch_array(MYSQLI_ASSOC)) 
                    {
                        $categorias_agencias[] = $row_categorias;
                    }

                    // if($idagencia == 173)
                    // {
                    //     print_r($categorias_agencias); exit;
                    // }

                    if(count($categorias_agencias) > 0)
                    {
                        // echo $idagencia.'-';

                        // print_r($categorias_agencias); exit;

                        foreach($categorias_agencias as $categoria_agencia)
                        {
                            $idcategoria    = $categoria_agencia['idcategoria'];
                            $idplan         = $categoria_agencia['idplan'];
                            $porcentaje     = $categoria_agencia['porcentaje'];
    
                            // ASIGNA CATEGORIAS
                                if($idcategoria != null && $idcategoria != 0)
                                {
                                    $cantidad_categoria = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM categoriasagencias WHERE idcategoria = $idcategoria AND idagencia = $idagencia ", "cantidad");
            
                                    if($cantidad_categoria == 0)
                                    {
                                        $insert  = "INSERT INTO categoriasagencias (
                                                                idcategoria, 
                                                                idagencia
                                                            )
                                                        VALUES
                                                            (
                                                                $idcategoria, 
                                                                $idagencia
                                                            )";
    
                                        ejecuta_insert($db_postgresql, $insert);
                                    }
                                }
    
                            // ASIGNA PLANES
                                if($idplan != null && $idplan != 0)
                                {
                                    $cantidad_planes = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planesagencias WHERE idplan = $idplan AND idagencia = $idagencia ", "cantidad");
            
                                    if($cantidad_planes == 0)
                                    {
                                        $insert  = "INSERT INTO planesagencias (
                                                                idplan, 
                                                                idagencia
                                                            )
                                                        VALUES
                                                            (
                                                                $idplan, 
                                                                $idagencia
                                                            )";
                            
                                        ejecuta_insert($db_postgresql, $insert);
                                    }
                                }
                            
                            // ASIGNA COMISIONES
    
                                if($idcategoria != null && $idcategoria != 0 && $idplan != null && $idplan != 0)
                                {
                                    $cantidad_comisiones_categoria = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM comisionesagencias WHERE idcategoria = $idcategoria AND idagencia = $idagencia AND idplan IS NULL", "cantidad");
            
                                    if($cantidad_comisiones_categoria == 0)
                                    {
                                        $insert  = "INSERT INTO comisionesagencias (
                                                                idcategoria,
                                                                idplan, 
                                                                idagencia,
                                                                comision
                                                            )
                                                        VALUES
                                                            (
                                                                $idcategoria,
                                                                NULL, 
                                                                $idagencia,
                                                                $porcentaje
                                                            )";
                            
                                        ejecuta_insert($db_postgresql, $insert);
                                    }
    
                                    $cantidad_comisiones_plan = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM comisionesagencias WHERE idcategoria = $idcategoria AND idagencia = $idagencia AND idplan = $idplan", "cantidad");
            
                                    if($cantidad_comisiones_plan == 0)
                                    {
                                        $insert  = "INSERT INTO comisionesagencias (
                                                                idcategoria,
                                                                idplan, 
                                                                idagencia,
                                                                comision
                                                            )
                                                        VALUES
                                                            (
                                                                $idcategoria,
                                                                $idplan, 
                                                                $idagencia,
                                                                $porcentaje
                                                            )";
                            
                                        ejecuta_insert($db_postgresql, $insert);
                                    }
    
                                }
                        }
                    }
            }
            else
            {
                echo $insert;
            }

            $row_categorias = array();
        }

    //SECUENCIA AGENCIAS
        $secuencia = $idagencia + 1;
        $secuencia = "ALTER SEQUENCE agencias_idagencia_seq RESTART WITH ".$secuencia; 
        ejecuta_select($db_postgresql, $secuencia);

    
    // CUPONES AGENCIAS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: cuponesagencias';

        $mysql_cupones_agencias = $db_mysql->query("SELECT 
                                                        id_broker as idagencia, 
                                                        id_cupon as idcupon 
                                                    FROM broker_coupons 
                                                    WHERE 1 = 1
                                                    AND id_broker > $last_id_agencia
                                                    ORDER BY id ASC");

        while ($row = $mysql_cupones_agencias->fetch_array(MYSQLI_ASSOC)) 
        {
            $cupones_agencias[] = $row;
        }

        foreach($cupones_agencias as $cupon_agencia)
        {
            echo '.';
            
            $idagencia = $cupon_agencia['idagencia'];
            $idcupon   = $cupon_agencia['idcupon'];
            
            $insert     = "INSERT INTO cuponesagencias (
                                    idagencia,
                                    idcupon
                                )
                            VALUES
                                (
                                    $idagencia,
                                    $idcupon
                                )";

            if(!ejecuta_insert($db_postgresql, $insert)) echo $insert;
        }


    // CORPORATIVOS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: corporativos';

        $contador_corporativos = 0;

        $select = "SELECT 
                        id_client as idcorporativo,
                        agencia as idagencia,
                        CAST(CONVERT(name USING utf8) AS binary) as nombrecorporativo,
                        id_status as idstatus,
                        date_up as fechacreacion,
                        observations as observaciones,
                        img_corpo as imgcorporativo,
                        credito_actual as creditoactual,
                        credito_base as creditobase
                    FROM corporativo 
                    WHERE agencia != 0
                    AND agencia > $last_id_agencia
                    ORDER BY corporativo.id_client ASC
                ";

        $mysql = $db_mysql->query($select);

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $corporativos[] = $row;
        }

        foreach($corporativos as $corporativo)
        {
            echo '.';

            $idcorporativo      = $corporativo['idcorporativo'];
            $idagencia          = $corporativo['idagencia'];
            $nombrecorporativo  = $corporativo['nombrecorporativo'];
            $idstatus           = $corporativo['idstatus'];
            $fechacreacion      = $corporativo['fechacreacion'];
            $observaciones      = $corporativo['observaciones'];
            $imgcorporativo     = $corporativo['imgcorporativo'];
            $creditoactual      = $corporativo['creditoactual'];
            $creditobase        = $corporativo['creditobase'];

            $insert_corporativo     = "INSERT INTO corporativos (
                                            idcorporativo,
                                            idagencia,
                                            nombrecorporativo,
                                            idstatus,
                                            fechacreacion,
                                            observaciones,
                                            imgcorporativo,
                                            creditoactual,
                                            creditobase
                                        )
                                    VALUES
                                        (
                                            $idcorporativo,
                                            $idagencia,
                                            UPPER('$nombrecorporativo'),
                                            $idstatus,
                                            '$fechacreacion',
                                            '$observaciones',
                                            '$imgcorporativo',
                                            $creditoactual,
                                            $creditobase
                                        )";
            
            if(ejecuta_insert($db_postgresql, $insert_corporativo))
            {

            }
            else
            {
                echo $insert;
            }

            $contador_corporativos++;
        }

        $secuencia = $idcorporativo + 1;
        $secuencia = "ALTER SEQUENCE corporativos_idcorporativo_seq RESTART WITH ".$secuencia; 
        ejecuta_select($db_postgresql, $secuencia);

    // USUARIOS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: usuarios';

        $select = "SELECT 
                        users.id as idusuario,
                        CAST(CONVERT(users.firstname USING utf8) AS binary) as nombreusuario,
                        CAST(CONVERT(users.lastname USING utf8) AS binary) as apellidousuario,
                        COALESCE(users.id_status, 0) as idstatus,
                        COALESCE(users.user_type, 5) as idtipousuario,
                        COALESCE(user_associate.id_associate, 0) as idagencia,
                        CAST(CONVERT(CONCAT(users.firstname,' ',users.lastname) USING utf8) AS binary) as aliasusuario,
                        users.password as contrasena,
                        CAST(CONVERT(users.email USING utf8) AS binary) as correo,
                        CAST(CONVERT(users.phone USING utf8) AS binary) as telefono,
                        COALESCE(user_associate.es_emision_corp, 0) as escorporativo,
                        COALESCE(users.created, '2000-01-01 00:00:00') as fechacreacion,
                        COALESCE(users.modified, '2000-01-01 00:00:00') as fechamodificacion,
                        COALESCE(users.changed_pass, '2000-01-01 00:00:00') as fechacambiarcontrasena,
                        COALESCE(users.force_change_pass, 1) as cambiarcontrasena,
                        COALESCE(users.language_id, 1) as ididioma,
                        COALESCE(users.ip_remote, '0.0.0.0') as ipremota,
                        0 as conectado,
                        COALESCE(users.only_local, 0) as soloconexionlocal,
                        COALESCE(users.last_login, '2000-01-01 00:00:00') as ultimaconexion,
                        COALESCE(users.incentivo, 0) as incentivo,
                        CAST(CONVERT(users.banco USING utf8) AS binary) as banco,
                        CAST(CONVERT(users.clabe_inter USING utf8) AS binary) as clabeinterbancaria,
                        CAST(CONVERT(users.beneficiario USING utf8) AS binary) as beneficiario,
                        CAST(CONVERT(users.cuenta USING utf8) AS binary) as cuenta
                    FROM users 
                    LEFT JOIN user_associate 
                        on users.id = user_associate.id_user 
                    WHERE user_associate.id_associate > $last_id_agencia
                    ORDER BY users.id ASC";

        $mysql = $db_mysql->query($select);

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $usuarios[] = $row;
        }

        foreach($usuarios as $usuario)
        {
            echo '.';

            $idusuario                  = $usuario['idusuario'];
            $nombreusuario              = trim(ucwords(strtolower($usuario['nombreusuario'])));
            $apellidousuario            = trim(ucwords(strtolower($usuario['apellidousuario'])));
            $idstatus                   = $usuario['idstatus'];
            $idtipousuario              = ($escorporativo) ? 4 : $usuario['idtipousuario'];
            $escorporativo              = $usuario['escorporativo'];
            $idagencia                  = ($escorporativo == 0) ? $usuario['idagencia'] : 'NULL' ;
            $aliasusuario               = trim(ucwords(strtolower($usuario['aliasusuario'])));
            $contrasena                 = $usuario['contrasena'];
            $correo                     = trim($usuario['correo']);
            $telefono                   = trim($usuario['telefono']);
            $fechacreacion              = $usuario['fechacreacion'];
            $fechamodificacion          = $usuario['fechamodificacion'];
            $fechacambiarcontrasena     = $usuario['fechacambiarcontrasena'];
            $cambiarcontrasena          = $usuario['cambiarcontrasena'];
            $ididioma                   = $usuario['ididioma'];
            $ipremota                   = $usuario['ipremota'];
            $conectado                  = $usuario['conectado'];
            $soloconexionlocal          = $usuario['soloconexionlocal'];
            $ultimaconexion             = $usuario['ultimaconexion'];
            $incentivo                  = $usuario['incentivo'];
            $banco                      = str_replace("?", " ", trim($usuario['banco']));
            $clabeinterbancaria         = str_replace("?", " ", trim($usuario['clabeinterbancaria']));
            $beneficiario               = str_replace("?", " ", trim($usuario['beneficiario']));
            $cuenta                     = str_replace("?", " ", trim($usuario['cuenta']));
            $idcorporativo              = ($escorporativo == 1) ? $usuario['idagencia'] : 'NULL' ;

            
            
            $postgresql_agencia = ($escorporativo == 1) ? ejecuta_select($db_postgresql, "SELECT idcorporativo FROM corporativos WHERE idcorporativo = $idcorporativo") : ejecuta_select($db_postgresql, "SELECT idagencia FROM agencias WHERE idagencia = $idagencia");
            
            $escorporativo = ($escorporativo == 1) ? 't' : 'f';

            if($correo != '' && $postgresql_agencia['cantidad'] > 0)
            {
                $insert     = "INSERT INTO usuarios (
                                        idusuario,
                                        nombreusuario,
                                        apellidousuario,
                                        idstatus,
                                        idtipousuario,
                                        idagencia,
                                        aliasusuario,
                                        contrasena,
                                        correo,
                                        telefono,
                                        escorporativo,
                                        fechacreacion,
                                        fechamodificacion,
                                        fechacambiarcontrasena,
                                        cambiarcontrasena,
                                        ididioma,
                                        ipremota,
                                        conectado,
                                        soloconexionlocal,
                                        ultimaconexion,
                                        incentivo,
                                        banco,
                                        clabeinterbancaria,
                                        beneficiario,
                                        cuenta,
                                        idcorporativo
                                    )
                                VALUES
                                    (
                                        $idusuario,
                                        '$nombreusuario',
                                        '$apellidousuario',
                                        $idstatus,
                                        $idtipousuario,
                                        $idagencia,
                                        '$aliasusuario',
                                        '$contrasena',
                                        '$correo',
                                        '$telefono',
                                        '$escorporativo',
                                        '$fechacreacion',
                                        '$fechamodificacion',
                                        '$fechacambiarcontrasena',
                                        '$cambiarcontrasena',
                                        $ididioma,
                                        '$ipremota',
                                        '$conectado',
                                        '$soloconexionlocal',
                                        '$ultimaconexion',
                                        $incentivo,
                                        '$banco',
                                        '$clabeinterbancaria',
                                        '$beneficiario',
                                        '$cuenta',
                                        $idcorporativo
                                    )";
                
                if(ejecuta_insert($db_postgresql, $insert))
                {

                }
                else
                {
                    echo 'Error insertando usuario corporativo: (Recomendada Suspención la Migración) '.$insert; 
                }
            }
        }

        $secuencia = $idusuario + 1;
        $secuencia = "ALTER SEQUENCE usuarios_idusuario_seq1 RESTART WITH ".$secuencia; 
        ejecuta_select($db_postgresql, $secuencia);
    
  
    $hora_fin   = date('h:i:s', time());  

    echo 'Proceso Finalizado Exitosamente !'; 
?>
