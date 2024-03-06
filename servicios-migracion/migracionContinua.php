<?php
/*     include('./lib/funciones.php');
    include('./lib/mysql.php');
    include('./lib/pgsql.php'); */
    
    $db_postgresql      = getDB();
    $db_mysql           = connect_db();

    system ('clear');

    $hora_inicio        = date('h:i:s', time());

    echo '
    Inicio: '.$hora_inicio.' 
';






// Tablas Migrando continuamente:
    // Agencias
        $ultimo_idagencia = ejecuta_select($db_postgresql, "SELECT MAX(idagencia) as idagencia FROM agencias", "idagencia");
    // Corporativos
        $ultimo_idcorporativo = ejecuta_select($db_postgresql, "SELECT MAX(idcorporativo) as idcorporativo FROM corporativos", "idcorporativo");
    // Usuarios
        $ultimo_idusuario = ejecuta_select($db_postgresql, "SELECT MAX(idusuario) as idusuario FROM usuarios", "idusuario");
    // Planes
        $ultimo_idplan = ejecuta_select($db_postgresql, "SELECT MAX(idplan) as idplan FROM planes", "idplan");
    // Cupones
        $ultimo_idcupon = ejecuta_select($db_postgresql, "SELECT MAX(idcupon) as idcupon FROM cupones", "idcupon");
    // Órdenes
        $ultimo_idorden = ejecuta_select($db_postgresql, "SELECT MAX(idorden) as idorden FROM ordenes", "idorden");
    // Unificaciones
        $ultimo_idunificacion = ejecuta_select($db_postgresql, "SELECT MAX(idunificacion) as idunificacion FROM vouchersunificados", "idunificacion");
        

// MIGRAR AGENCIAS 



    // AGENCIAS CON ORDENES EMITIDIAS EN EL 2024
        $select = "SELECT agencia as idagencia
                    FROM orders 
                    WHERE fecha >= '2024-01-01'
                    AND status IN (1, 2, 4)
                    AND agencia NOT IN (0)
                    GROUP BY 1
                    ORDER BY 1
                ";

        $mysql = $db_mysql->query($select);
       

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
             
            $agencias_que_emitieron_2024[] = $row;
        }
        
        $agencias = array();

        foreach($agencias_que_emitieron_2024 as $agencia)
        {
            $idagencia = $agencia['idagencia'];

            if(!in_array($idagencia, $agencias))
            {
                array_push($agencias, $idagencia);
            }
        }
        $agencias        = implode(",", $agencias);
        $select          = "select unnest(ARRAY[".$agencias."]) as idagencia EXCEPT SELECT idagencia FROM agencias;";

        $agencias       = ejecuta_select($db_postgresql,  $select);
        $implode_agencias_noencontradas = "";

        $agencias_no_encontradas = array();

        if($agencias['cantidad'] > 0)
        {
            foreach($agencias['resultado'] as $idagencia_noencontrada)
            {
                array_push($agencias_no_encontradas, $idagencia_noencontrada['idagencia']);
            }

            $implode_agencias_noencontradas = implode(",", $agencias_no_encontradas);
        }

        $condicion_agencias_noencontradas = (count($agencias_no_encontradas) > 0) ? " OR broker.id_broker IN ($implode_agencias_noencontradas) " : " ";

        $registros = array();

    echo '
Migrando Agencias '.$implode_agencias_noencontradas .' ...
';
    
        $select_agencias = "SELECT 
                                broker.id_broker as idagencia,
                                1 as idsistema,
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
                                CASE
                                    WHEN id_site = 5 THEN 818
                                    WHEN id_site = 11 THEN 509
                                    ELSE 99
                                END as idagenciareporta,
                                UPPER(CAST(CONVERT(razon USING utf8) AS binary)) as razonsocial,
                                UPPER(CAST(CONVERT(tax_id USING utf8) AS binary)) as identificadortributaria,
                                UPPER(CAST(CONVERT(id_city USING utf8) AS binary)) as ciudad,
                                UPPER(CAST(CONVERT(id_state USING utf8) AS binary)) as estado,
                                CAST(CONVERT(observations USING utf8) AS binary) as comentario,
                                'CA' as acronimovoucher
                            FROM broker
                            LEFT join broker_nivel on broker.id_broker = broker_nivel.id_broker
                            WHERE broker.id_broker > $ultimo_idagencia $condicion_agencias_noencontradas
                            ORDER BY broker.id_broker ASC
                            ";
    
        $mysql    = $db_mysql->query($select_agencias);
        

    /// revisar este ciclo
        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $registros[] = $row;
        }
    
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
                            VALUES ";
    
        $array_valores = array();
        foreach($registros as $registro)
        {
            
            $idagencia                  = $registro['idagencia'];
            $idsistema                  = $registro['idsistema'];
            $nombreagencia              = str_replace("'", "", $registro['nombreagencia']);
            $idstatus                   = ($registro['idstatus'] == 0) ? 2 : $registro['idstatus'];
            $idnivel                    = $registro['idnivel'];
            $idpais                     = ($registro['idpais'] == 0) ? 99 : $registro['idpais'];
            $telefono1                  = str_replace(" ", "", str_replace("-", "", str_replace(".", "", str_replace("'", "", $registro['telefono1']))));
            $telefono2                  = str_replace(" ", "", str_replace("-", "", str_replace(".", "", str_replace("'", "", $registro['telefono2']))));
            $telefono3                  = str_replace(" ", "", str_replace("-", "", str_replace(".", "", str_replace("'", "", $registro['telefono3']))));
            $direccion                  = str_replace('"', "", str_replace("'", "", $registro['direccion']));
            $fechacreacion              = $registro['fechacreacion'];
            $idagente                   = $registro['idagente'];
            $logoagencia                = str_replace("'", "", $registro['logoagencia']);
            $creditobase                = $registro['creditobase'];
            $creditoactual              = $registro['creditoactual'];
            $verprecio                  = $registro['verprecio'];
            $versoloinclusion           = $registro['versoloinclusion'];
            $multipais                  = $registro['multipais'];
            $banco                      = str_replace("'", "", $registro['banco']);
            $clabeinterbancaria         = str_replace("'", "", $registro['clabeinterbancaria']);
            $cuenta                     = str_replace(".", "", str_replace(" ", "", str_replace("-", "", str_replace("'", "", $registro['cuenta']))));
            $beneficiario               = str_replace("'", "", $registro['beneficiario']);
            $idagenciapadre             = $registro['idagenciapadre'];
            $idagenciareporta           = $registro['idagenciareporta'];
            $razonsocial                = str_replace("'", "", $registro['razonsocial']);
            $identificadortributaria    = str_replace(" ", "", str_replace("-", "", str_replace(".", "", str_replace("'", "", $registro['identificadortributaria']))));
            $ciudad                     = str_replace("'", "", $registro['ciudad']);
            $estado                     = str_replace("'", "", $registro['estado']);
            $comentario                 = str_replace("'", "", $registro['comentario']);
            $acronimovoucher            = $registro['acronimovoucher'];
    
            $logoagencia                = ($logoagencia && $logoagencia != 'unknow.png') ? 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/'.$logoagencia : '';
    
            $valor = "(
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
    
            array_push($array_valores, $valor);
        }
    
        if(count($array_valores) > 0)
        {
            $valores        = implode(",", $array_valores);
            $insert         = $insert.$valores; 

            // ESTO
            if(!ejecuta_insert($db_postgresql, $insert))
            {
                echo $insert; exit;
            }
        
            $secuencia = $idagencia + 1;
            $secuencia = "ALTER SEQUENCE agencias_idagencia_seq RESTART WITH ".$secuencia; 
            ejecuta_select($db_postgresql, $secuencia);
        }
        
    
    
    
    
// AGENCIAS PLATAFORMAS DE PAGO 

    $agencias = ejecuta_select($db_postgresql, "SELECT idagencia FROM agencias WHERE idagencia >= $ultimo_idagencia");

    $insert = "INSERT INTO agenciasplataformaspago (idagencia, idplataformapago) VALUES ";

    $array_valores = array();

    foreach($agencias['resultado'] as $agencia)
    {
        $idagencia = $agencia['idagencia'];

        if($idagencia)
        {
            array_push($array_valores, "($idagencia, 1)");
            array_push($array_valores, "($idagencia, 2)");
        }
    }

    
//ESTO
    if(count($array_valores) > 0)
    {
        $valores = implode(",", $array_valores);
        $insert = $insert.$valores;

        ejecuta_insert($db_postgresql, $insert);
    }





    // CORPORATIVOS *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: corporativos...
';

    $corporativos = array();

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
                WHERE id_client > $ultimo_idcorporativo
                ORDER BY corporativo.id_client ASC
            ";

    $mysql = $db_mysql->query($select);

    while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    {
        $corporativos[] = $row;
    }

    $insert = "INSERT INTO corporativos ( idcorporativo, idagencia, nombrecorporativo, idstatus, fechacreacion, observaciones, imgcorporativo, creditoactual, creditobase ) VALUES ";

    $array_valores = array();
    $archivo = array();
    foreach($corporativos as $corporativo)
    {
        array_push($archivo, $corporativo['idcorporativo']);

        $idcorporativo      = $corporativo['idcorporativo'];
        $idagencia          = $corporativo['idagencia'];
        $nombrecorporativo  = str_replace("'", "", $corporativo['nombrecorporativo']) ;
        $idstatus           = ($corporativo['idstatus'] == 0) ? 2 : $corporativo['idstatus'];
        $fechacreacion      = $corporativo['fechacreacion'];
        $observaciones      = $corporativo['observaciones'];
        $imgcorporativo     = $corporativo['imgcorporativo'];
        $creditoactual      = $corporativo['creditoactual'];
        $creditobase        = $corporativo['creditobase'];

        $valor     = " (
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

        array_push($array_valores, $valor);
    }

// ESTO
    if(count($array_valores) > 0)
    {
        $valores        = implode(",", $array_valores);
        $insert         = $insert.$valores; 

        if(!ejecuta_insert($db_postgresql, $insert))
        {
            echo $insert; exit;
        }

        $secuencia = $idcorporativo + 1;
        $secuencia = "ALTER SEQUENCE corporativos_idcorporativo_seq RESTART WITH ".$secuencia; 
        ejecuta_select($db_postgresql, $secuencia);

        sort($archivo);
        $todas_las_agencias_implode_con_corporativos = implode(",", $archivo);
    }

    


    









// CATEGORIAS AGENCIAS *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: categoriasagencias...
';

    $categorias_agencias = array();

    $select = "SELECT 
                    DISTINCT COALESCE(programaplan, 0) as programaplan, 
                    agencia 
                FROM orders 
                WHERE agencia > $ultimo_idagencia
                ORDER BY programaplan ASC";

    $mysql_categorias_agencias = $db_mysql->query($select);

    while ($row = $mysql_categorias_agencias->fetch_array(MYSQLI_ASSOC)) 
    {
        $categorias_agencias[] = $row;
    }

    $insert = "INSERT INTO categoriasagencias ( idcategoria, idagencia ) VALUES ";

    $array_valores = array(); 
    foreach($categorias_agencias as $categoria_agencia)
    {
        $idcategoria    = $categoria_agencia['programaplan'];
        $idagencia      = $categoria_agencia['agencia'];
        
        $valor     = " ( $idcategoria, $idagencia ) ";

        array_push($array_valores, $valor);
    }

    if(count($array_valores) > 0)
    {
        $valores    = implode(",", $array_valores);
        $insert     = $insert.$valores;

    // ESTO
        if(!ejecuta_insert($db_postgresql, $insert)) 
        {
            echo $insert; exit;
        }
    }














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

                    array_push($array_valores_categoriasagencias, $valor_categoriasagencias);

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
                                array_push($array_valores_planesagencias, $valor_planesagencias);
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
            if(!ejecuta_insert($db_postgresql, $insert_categoriasagencias))
            {
                echo $insert_categoriasagencias; exit;
            }
        }

        if(count($array_valores_planesagencias) > 0)
        {
            $valores = implode(",", $array_valores_planesagencias);
            $insert_planesagencias = $insert_planesagencias.$valores;
            if(!ejecuta_insert($db_postgresql, $insert_planesagencias))
            {
                echo $insert_planesagencias; exit;
            }
        }







// MIGRAR USUARIOS

echo '
Migrando Usuarios...
';

    $usuarios = array();

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
                    user_associate.es_emision_corp as escorporativo,
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
                    UPPER(CAST(CONVERT(users.banco USING utf8) AS binary)) as banco,
                    CAST(CONVERT(users.clabe_inter USING utf8) AS binary) as clabeinterbancaria,
                    UPPER(CAST(CONVERT(users.beneficiario USING utf8) AS binary)) as beneficiario,
                    CAST(CONVERT(users.cuenta USING utf8) AS binary) as cuenta
                FROM users 
                LEFT JOIN user_associate on users.id = user_associate.id_user 
                WHERE users.id > $ultimo_idusuario
                AND user_associate.id_associate NOT IN (0)
                GROUP BY users.id
                ORDER BY users.id ASC
                ";

        $mysql = $db_mysql->query($select);

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $usuarios[] = $row;
        }

        $insert_usuarios = "INSERT INTO usuarios (
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
                        VALUES ";

        $array_valores_usuarios = array();

        foreach($usuarios as $usuario)
        {
            $idusuario                  = $usuario['idusuario'];
            $nombreusuario              = str_replace("'", "", trim(ucwords(strtolower($usuario['nombreusuario']))));
            $apellidousuario            = str_replace("'", "", trim(ucwords(strtolower($usuario['apellidousuario']))));
            $idstatus                   = ($usuario['idstatus'] == 0) ? 2 : $usuario['idstatus'];
            $escorporativo              = $usuario['escorporativo'];
            $idcorporativo              = ($escorporativo == 1) ? $usuario['idagencia'] : 'NULL' ;
            $idtipousuario              = ($usuario['idtipousuario'] == 0) ? 100 : $usuario['idtipousuario'];
            $idagencia                  = ($escorporativo == 0) ? $usuario['idagencia'] : ejecuta_select($db_postgresql, "SELECT idagencia FROM corporativos WHERE idcorporativo = $idcorporativo", "idagencia") ;
            $aliasusuario               = trim(ucwords(strtolower($usuario['aliasusuario'])));
            $contrasena                 = $usuario['contrasena'];
            $correo                     = trim($usuario['correo']);
            $telefono                   = str_replace("'", "", trim($usuario['telefono']));
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

            $postgresql_agencia = ($escorporativo == 1) ? ejecuta_select($db_postgresql, "SELECT idcorporativo FROM corporativos WHERE idcorporativo = $idcorporativo") : ejecuta_select($db_postgresql, "SELECT idagencia FROM agencias WHERE idagencia = $idagencia");
            
            $escorporativo = ($escorporativo == 1) ? 't' : 'f';

            if($correo != '' && $postgresql_agencia['cantidad'] > 0)
            {
                $valor = "(
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

                array_push($array_valores_usuarios, $valor);
            }
        }

        if(count($array_valores) > 0)
        {
            $valores            = implode(",", $array_valores_usuarios);
            $insert_usuarios    = $insert_usuarios.$valores;

            // ESTO
            if(!ejecuta_insert($db_postgresql, $insert_usuarios))
            {
                echo $insert_usuarios; exit;
            }

            $secuencia = $idusuario + 1;
            $secuencia = "ALTER SEQUENCE usuarios_idusuario_seq1 RESTART WITH ".$secuencia; 
            ejecuta_select($db_postgresql, $secuencia);
        }




// PLANES *******************************************************************************************************************************************************************************
echo '
Migrando Planes...
';
    
        $plans  = array();
        $planes = array();
    
        $todos_los_planes       = array();
    
        $mysql_plans    = $db_mysql->query("SELECT  id, 
                                                    CAST(CONVERT(name USING utf8) AS binary) as name,
                                                    CAST(CONVERT(description USING utf8) AS binary) as description,
                                                    IF(activo != 1 OR eliminado = 2, 2, 1) as activo, 
                                                    id_plan_categoria, 
                                                    COALESCE(min_tiempo, 1) as min_tiempo,
                                                    COALESCE(max_tiempo, 365) as max_tiempo,
                                                    COALESCE(min_age, 0) as min_age,
                                                    COALESCE(max_age, 99) as max_age,
                                                    COALESCE(normal_age, 71) as normal_age,
                                                    COALESCE(family_plan, 'false') as family_plan,
                                                    overage_factor, 
                                                    COALESCE(factor_family, 'false') as factor_family,
                                                    COALESCE(moneda_pago, moneda, 'USD') as moneda_pago,
                                                    COALESCE(moneda, moneda_pago, 'USD') as moneda,
                                                    COALESCE(fecha_creacion, '2000-01-01 00:00:00') as fecha_creacion,
                                                    COALESCE(fecha_modificacion, '2000-01-01 00:00:00') as fecha_modificacion,
                                                    id_popularidad, 
                                                    COALESCE(max_age_ben_adic, 75) as max_age_ben_adic,
                                                    COALESCE(publico, 0) as publico,
                                                    id_site  
                                                FROM plans 
                                                WHERE id > $ultimo_idplan
                                                ORDER BY id ASC 
                                                ");
    
        while ($row = $mysql_plans->fetch_array(MYSQLI_ASSOC)) 
        {
            $plans[] = $row;
        }
    
        $insert_planes 	        = "INSERT INTO planes ( idplan, nombreplan, idstatus, idcategoria, tiempominimo, tiempomaximo, edadminima, edadmaxima, edadprecioincremento, planfamiliar, factorpenalizacionedad, factorbeneficiofamiliar, idmonedapago, idmonedacobertura, fechacreacion, fechamodificacion, idpopularidad, edadmaximabeneficiosadic, descripcionplan, descripcionplanen, idtipoasistencia, fechaactualizacionprecioscostos, fechaactualizacionbeneficios, fechaactualizacionbeneficiosadicionales, fechaactualizacionbeneficiosproveedores, publico, familiaplan) VALUES ";
        $insert_planesprecios 	= "INSERT INTO planesprecios ( idplan, dia, precio, idpais, fechaactualizacion ) VALUES ";
        $insert_planescostos1 	= "INSERT INTO planescostos ( idplan, idproveedor, dia, costo, idpais, fechaactualizacion ) VALUES ";
        $insert_planescostos2 	= "INSERT INTO planescostos ( idplan, idproveedor, dia, costo, idpais, fechaactualizacion ) VALUES ";
        $insert_planespaises    = "INSERT INTO planespaises ( idplan, idpais ) VALUES ";
        
        $array_valores_planes 	        = array();
        $array_valores_planesprecios 	= array();
        $array_valores_planescostos1 	= array();
        $array_valores_planescostos2 	= array();
        $array_valores_planespaises 	= array();
        $paises_utilizados = array();
        foreach($plans as $plan)
        {
            $idplan = $plan['id'];
            array_push($todos_los_planes, $idplan);
    
            $nombreplan                                 = $plan['name'];
            $familiaplan                                = NULL;
            $idstatus                                   = $plan['activo'];
            $idcategoria                                = $plan['id_plan_categoria'];
            $tiempominimo                               = $plan['min_tiempo'];
            $tiempomaximo                               = $plan['max_tiempo'];
            $edadminima                                 = $plan['min_age'];
            $edadmaxima                                 = $plan['max_age'];
            $edadprecioincremento                       = $plan['normal_age'];
            $planfamiliar                               = ($plan['family_plan'] == 'Y' || $plan['family_plan'] == 'N') ? $plan['family_plan'] : 'Y';
            $factorpenalizacionedad                     = $plan['overage_factor'];
            $factorbeneficiofamiliar                    = $plan['factor_family'];
            $monedapago                                 = $plan['moneda_pago'] == 'EURO' ? 'EUR' : $plan['moneda_pago'];
            $idmonedapago                               = ejecuta_select($db_postgresql, "SELECT idmoneda FROM monedas WHERE codigo = '$monedapago'",'idmoneda');
            $monedacobertura                            = $plan['moneda'] == 'EURO' ? 'EUR' : $plan['moneda'];
            $idmonedacobertura                          = ejecuta_select($db_postgresql, "SELECT idmoneda FROM monedas WHERE codigo = '$monedacobertura'",'idmoneda');
            $fechacreacion                              = ($plan['fecha_creacion'] == '0000-00-00 00:00:00') ? '2000-01-01 00:00:00' : $plan['fecha_creacion'];
            $fechamodificacion                          = ($plan['fecha_modificacion'] == '0000-00-00 00:00:00') ? '2000-01-01 00:00:00' : $plan['fecha_modificacion'];
            $idpopularidad                              = ($plan['id_popularidad'] == 0) ? 1 : $plan['id_popularidad'];
            $edadmaximabeneficioadic                    = $plan['max_age_ben_adic'];
            $descripcionplan                            = '';
            $descripcionplanen                          = '';
            $idtipoasistencia                           = 1;
            $fechaactualizacionprecioscostos            = '2000-01-01 00:00:00';
            $fechaactualizacionbeneficios               = '2000-01-01 00:00:00';
            $fechaactualizacionbeneficiosadicionales    = '2000-01-01 00:00:00';
            $fechaactualizacionbeneficiosproveedores    = '2000-01-01 00:00:00';
            $publico                                    = $plan['publico'];
    
            // $idpais = $plan['id_site'];
    
            $valor = "(
                            $idplan, 
                            UPPER('$nombreplan'), 
                            $idstatus, 
                            $idcategoria, 
                            $tiempominimo, 
                            $tiempomaximo, 
                            $edadminima, 
                            $edadmaxima, 
                            $edadprecioincremento, 
                            '$planfamiliar', 
                            $factorpenalizacionedad, 
                            $factorbeneficiofamiliar, 
                            $idmonedapago, 
                            $idmonedacobertura, 
                            '$fechacreacion', 
                            '$fechamodificacion', 
                            $idpopularidad, 
                            $edadmaximabeneficioadic, 
                            '$descripcionplan', 
                            '$descripcionplanen', 
                            $idtipoasistencia, 
                            '$fechaactualizacionprecioscostos', 
                            '$fechaactualizacionbeneficios', 
                            '$fechaactualizacionbeneficiosadicionales', 
                            '$fechaactualizacionbeneficiosproveedores', 
                            '$publico',
                            NULL
                            )";
    
            array_push($array_valores_planes, $valor);
    
            // CONSULTA LOS PRECIOS 
                $mysql_precios  = array();
                $precios        = array();
    
                $select = "SELECT * FROM precios WHERE id_plan = '$idplan' ORDER BY dias ASC";
    
                $mysql_precios = $db_mysql->query($select);
    
                while ($row_precio = $mysql_precios->fetch_array(MYSQLI_ASSOC)) 
                { 
                    $precios[] = $row_precio; 
                }
    
    
            // CONSULTA LOS PAISES QUE LO HAN UTILIZADO
                $select_paises_utilizados = "SELECT broker.id_site 
                                            from orders 
                                                left join broker on orders.agencia = broker.id_broker
                                            where orders.producto = $idplan
                                            group by 1";
    
                $mysql_utilizados = $db_mysql->query($select_paises_utilizados);
    
                while ($row_utilizados = $mysql_utilizados->fetch_array(MYSQLI_ASSOC)) 
                { 
                    $paises_utilizados[] = $row_utilizados; 
                }
    
            if(!in_array(99, $paises_utilizados))
            {
                array_push($paises_utilizados, array("id_site" => 99 ));
            }
    
            if(count($paises_utilizados) > 0)
            {
                foreach($paises_utilizados as $pais_utilizado)
                {
                    if($pais_utilizado['id_site'] != NULL)
                    {
                        $idpais = ($pais_utilizado['id_site'] == 0 ) ? 99 : $pais_utilizado['id_site'];
    
                        // INSERTA PLANESPAISES SI NO LO ENCUENTRA 
                            $cantidad_planespaises = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planespaises WHERE idplan = $idplan AND idpais = $idpais", "cantidad");
    
                            if($cantidad_planespaises == 0)
                            {
                                $valor_planespaises = " ( $idplan, $idpais )";
    
                                array_push($array_valores_planespaises, $valor_planespaises);
                            }
    
                        // INSERTA LOS PRECIOS PARA CADA PAIS
                            if(count($precios) > 0)
                            {
                                foreach($precios as $registro)
                                {    
                                    $dia        = $registro['dias'];
                                    $precio     = $registro['precio'];
                                    $costo1     = ($registro['costo1'] > 0) ? $registro['costo1'] : 0;
                                    $costo2     = ($registro['costo2'] > 0) ? $registro['costo2'] : 0;
    
                                    array_push($array_valores_planesprecios, "( $idplan, $dia, $precio, $idpais, '2000-01-01 00:00:00')");
                                    array_push($array_valores_planescostos1, "( $idplan, 1, $dia, $costo1, $idpais, '2000-01-01 00:00:00')");
                                    array_push($array_valores_planescostos2, "( $idplan, 2, $dia, $costo2, $idpais, '2000-01-01 00:00:00')");
                                }
                            }
                    }
                }
            }
    
            $paises_utilizados = array();
        }
    
        if(count($array_valores_planes) > 0)
        {
            $valores 				= implode(",", $array_valores_planes);
            $insert_planes 	        = $insert_planes.$valores;
        
            $valores 				= implode(",", $array_valores_planesprecios);
            $insert_planesprecios 	= $insert_planesprecios.$valores;
        
            $valores 				= implode(",", $array_valores_planescostos1);
            $insert_planescostos1 	= $insert_planescostos1.$valores;
        
            $valores 				= implode(",", $array_valores_planescostos2);
            $insert_planescostos2 	= $insert_planescostos2.$valores;
        
            $valores 				= implode(",", $array_valores_planespaises);
            $insert_planespaises 	= $insert_planespaises.$valores;
        
            // ESTO
            ejecuta_insert($db_postgresql, $insert_planes);
            ejecuta_insert($db_postgresql, $insert_planesprecios);
            ejecuta_insert($db_postgresql, $insert_planescostos1);
            ejecuta_insert($db_postgresql, $insert_planescostos2);
            ejecuta_insert($db_postgresql, $insert_planespaises);
        
            $secuencia = $idplan + 1;
            $secuencia = "ALTER SEQUENCE planes_idplan_seq RESTART WITH ".$secuencia; 
            ejecuta_select($db_postgresql, $secuencia);
        }






// CUPONES *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: cupones...
';

    $cupones = array();

    $mysql_cupones = $db_mysql->query("SELECT 
                                            coupons.id as idcupon,
                                            coupons.codigo as codigocupon, 
                                            coupons.porcentaje as porcentaje, 
                                            coupons.fecha_desde as fechadesde, 
                                            coupons.fecha_hasta as fechahasta, 
                                            coupons.id_status as idstatus, 
                                            coupons.ussage as disponibles, 
                                            COALESCE(coupons.created, '2000-01-01 00:00:00') as fechacreacion,
                                            COALESCE(coupons.modified, '2000-01-01 00:00:00') as fechamodificacion,
                                            coupons.acepta_familia as aceptafamiliar
                                        FROM coupons 
                                        WHERE coupons.id_status = 1 AND coupons.id > $ultimo_idcupon
                                        GROUP BY coupons.id
                                        ORDER BY coupons.id ASC");

    while ($row = $mysql_cupones->fetch_array(MYSQLI_ASSOC)) 
    {
        $cupones[] = $row;
    }

    $insert = "INSERT INTO cupones ( idcupon, codigocupon, porcentaje, fechadesde, fechahasta, idstatus, disponibles, fechacreacion, fechamodificacion, aceptafamiliar ) VALUES ";

    $array_valores = array();
    foreach($cupones as $cupon)
    {
        $idcupon            = $cupon['idcupon'];
        $codigocupon        = $cupon['codigocupon'];
        $porcentaje         = $cupon['porcentaje'];
        $fechadesde         = $cupon['fechadesde'].' 00:00:00';
        $fechahasta         = $cupon['fechahasta'].' 23:59:59';
        $idstatus           = ($cupon['idstatus'] == 0) ? 2 : $cupon['idstatus'];
        $disponibles        = $cupon['disponibles'];
        $fechacreacion      = $cupon['fechacreacion'];
        $fechamodificacion  = $cupon['fechamodificacion'];
        $aceptafamiliar     = $cupon['aceptafamiliar'];
    
        $valor = " (
                        $idcupon,
                        UPPER('$codigocupon'),
                        $porcentaje,
                        '$fechadesde',
                        '$fechahasta',
                        $idstatus,
                        $disponibles,
                        '$fechacreacion',
                        '$fechamodificacion',
                        '$aceptafamiliar'
                    )";

        array_push($array_valores, $valor);
    }

    if(count($array_valores) > 0)
    {
        $valores    = implode(",", $array_valores);
        $insert     = $insert.$valores;

        // ESTO
        if(!ejecuta_insert($db_postgresql, $insert)) 
        {
            echo $insert; exit;
        }


        $secuencia = $idcupon + 1;
        $secuencia = "ALTER SEQUENCE cupones_idcupon_seq RESTART WITH ".$secuencia; 
        ejecuta_select($db_postgresql, $secuencia);
    }







// CUPONES AGENCIAS *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: cuponesagencias...
';

    $cupones_agencias = array();

    $mysql_cupones_agencias = $db_mysql->query("SELECT 
                                                    broker_coupons.id_broker as idagencia, 
                                                    broker_coupons.id_cupon as idcupon 
                                                FROM coupons
                                                    LEFT JOIN broker_coupons ON coupons.id = broker_coupons.id_cupon
                                                WHERE broker_coupons.id_broker > $ultimo_idagencia
                                                AND coupons.id_status = 1
                                                ORDER BY coupons.id ASC");

    while ($row = $mysql_cupones_agencias->fetch_array(MYSQLI_ASSOC)) 
    {
        $cupones_agencias[] = $row;
    }

    $insert = "INSERT INTO cuponesagencias ( idagencia, idcupon ) VALUES ";

    $array_valores = array();
    foreach($cupones_agencias as $cupon_agencia)
    {
        $idagencia = $cupon_agencia['idagencia'];
        $idcupon   = $cupon_agencia['idcupon'];
        
        $valor     = " (
                        $idagencia,
                        $idcupon
                    )";

        array_push($array_valores, $valor);
    }

    if(count($array_valores) > 0)
    {
        $valores    = implode(",", $array_valores);
        $insert     = $insert.$valores;
    
        // ESTO
        if(!ejecuta_insert($db_postgresql, $insert)) 
        {
            echo $insert; exit;
        }
    }







// ELIMINA DUPLICAODS EN PLANES PAISES
    $planes_duplicados = ejecuta_select($db_postgresql, "SELECT MIN(idplanpais) as idplanpais, idpais, idplan, count(*) as cantidad from planespaises
                                                            GROUP BY idplan, idpais
                                                            HAVING COUNT(*) > 1
                                                            ");
    
    if($planes_duplicados['cantidad'] > 0)
    {
        $array_borrar = array();
        foreach($planes_duplicados['resultado'] as $plan_duplicado)
        {
            $idplanpais = $plan_duplicado['idplanpais'];

            array_push($array_borrar, $idplanpais);
        }

        if(count($array_borrar) > 0)
        {
            $valores = implode(",", $array_borrar);
            $delete = "DELETE FROM planespaises WHERE idplanpais IN ($valores);";
            ejecuta_delete($db_postgresql, $delete);
        }
    }

// ELIMINA DUPLICAODS EN PLANES AGENCIAS
    $planes_duplicados = ejecuta_select($db_postgresql, "SELECT MIN(idplanesagencias) as idplanesagencias, idagencia, idplan, count(*) as cantidad from planesagencias
                                                            GROUP BY idplan, idagencia
                                                            HAVING COUNT(*) > 1
                                                            ");
    
    if($planes_duplicados['cantidad'] > 0)
    {
        $array_borrar = array();
        foreach($planes_duplicados['resultado'] as $plan_duplicado)
        {
            $idplanesagencias = $plan_duplicado['idplanesagencias'];

            array_push($array_borrar, $idplanesagencias);
        }

        if(count($array_borrar) > 0)
        {
            $valores = implode(",", $array_borrar);
            $delete = "DELETE FROM planesagencias WHERE idplanesagencias IN ($valores);";

            ejecuta_delete($db_postgresql, $delete);
        }
    }









   
























































































    




















   
























    



























































    







































































// CUPONES CATEGORIAS *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: cuponescategorias...';
    
    $cuponescategorias = array();

    $mysql = $db_mysql->query("SELECT 
                                DISTINCT plans_category_coupons.id_plan_categoria, 
                                plans_category_coupons.id_cupon 
                            FROM plans_category_coupons 
                                LEFT JOIN broker_coupons ON plans_category_coupons.id_cupon = broker_coupons.id_cupon
                                LEFT JOIN coupons ON plans_category_coupons.id_cupon = coupons.id
                            WHERE broker_coupons.id_broker > $ultimo_idagencia
                            AND coupons.id_status = 1
                            ORDER BY plans_category_coupons.id_plan_categoria ASC");

    while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    {
        $cuponescategorias[] = $row;
    }

    $insert = "INSERT INTO cuponescategorias ( idcategoria, idcupon ) VALUES ";

    $array_valores = array();
    foreach($cuponescategorias as $beneficiocategoria)
    {
        $idcategoria    = $beneficiocategoria['id_plan_categoria'];
        $idcupon        = $beneficiocategoria['id_cupon'];

        $valor     = " (
                            $idcategoria, 
                            $idcupon
                        )";

        array_push($array_valores, $valor);
    }

    if(count($array_valores) > 0)
    {
        $valores    = implode(",", $array_valores);
        $insert     = $insert.$valores;

        // ESTO
        if(!ejecuta_insert($db_postgresql, $insert)) 
        {
            echo $insert; exit;
        }
    }












































// CUPONES FUENTES (LUEGO)*******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: cuponesfuentes...';
    $cuponesfuentes = array();

    $mysql = $db_mysql->query("SELECT 
                                    coupons.target, 
                                    coupons.id 
                                FROM coupons 
                                    LEFT JOIN broker_coupons ON coupons.id = broker_coupons.id_cupon
                                WHERE broker_coupons.id_broker > $ultimo_idagencia
                                AND coupons.id_status = 1
                                ORDER BY id ASC ");

    while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    {
        $cuponesfuentes[] = $row;
    }

    $insert = "INSERT INTO cuponesfuentes ( idfuente, idcupon ) VALUES ";

    $array_valores = array();
    foreach($cuponesfuentes as $cuponfuente)
    {
        $idfuente   = $cuponfuente['target'] == 0 ? 1 : 2;
        $idcupon    = $cuponfuente['id'];

        $valor     = " (
                                $idfuente, 
                                $idcupon
                            )";

        array_push($array_valores, $valor);
    }

    if(count($array_valores) > 0)
    {
        $valores    = implode(",", $array_valores);
        $insert     = $insert.$valores;

        // ESTO
        if(!ejecuta_insert($db_postgresql, $insert)) 
        {
            echo $insert; exit;
        }
    }
                    



















































// PLANES AGENCIAS (ANALIZAR) *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: Planes Agencias...';

    $comisiones = array();
    $planes_agencias = array();

    if($implode_agencias_noencontradas != '')
    {
        $mysql_planes_agencias = $db_mysql->query("SELECT 
                                                    DISTINCT producto, 
                                                    programaplan, 
                                                    agencia 
                                                FROM orders 
                                                    JOIN plans ON plans.id = orders.producto 
                                                    JOIN broker ON broker.id_broker = orders.agencia 
                                                WHERE 1 = 1
                                                AND orders.agencia IN ($implode_agencias_noencontradas)
                                                ORDER BY producto, agencia ASC");
    
        while ($row = $mysql_planes_agencias->fetch_array(MYSQLI_ASSOC)) 
        {
            $planes_agencias[] = $row;
        }
    
        $insert_planesagencias              = "INSERT INTO planesagencias ( idplan, idagencia ) VALUES ";
        $insert_comisionesagencias          = "INSERT INTO comisionesagencias ( idagencia, idcategoria, idplan, comision ) VALUES ";
    
        $array_valores_planesagencias       = array();
        $array_valores_comisionesagencias   = array();
    
        if(count($planes_agencias) > 0)
        {
            foreach($planes_agencias as $plan_agencia)
            {
                $idplan          = $plan_agencia['producto'];
                $idagencia       = $plan_agencia['agencia'];
                $idcategoria     = $plan_agencia['programaplan'];
        
                array_push($array_valores_planesagencias, "( $idplan, $idagencia )");
        
                $existe_comision  = ejecuta_select($db_postgresql, "SELECT idcomisiones FROM comisionesagencias WHERE idagencia = $idagencia AND idcategoria = $idcategoria");
        
                if($existe_comision['cantidad'] == 0)
                {
                    $mysql_comisiones = $db_mysql->query("SELECT porcentaje FROM commissions WHERE id_categoria = $idcategoria AND id_agencia = $idagencia LIMIT 1");
        
                    while ($row = $mysql_comisiones->fetch_array(MYSQLI_ASSOC)) 
                    {
                        $comisiones[] = $row;
                    }
        
                    if(count($comisiones) > 0)
                    {
                        foreach($comisiones as $comision)
                        {
                            $porcentaje = $comision['porcentaje'];
        
                            array_push($array_valores_comisionesagencias, "( $idagencia, $idcategoria, NULL, $porcentaje )");
                        }
                    }
        
                    $comisiones = array();
                }
            }
        }
    
        if(count($array_valores_comisionesagencias) > 0)
        {
            $valores 				    = implode(",", $array_valores_comisionesagencias);
            $insert_comisionesagencias 	= $insert_comisionesagencias.$valores;
            
            // ESTO
            if(!ejecuta_insert($db_postgresql, $insert_comisionesagencias))
            {
                echo $insert_comisionesagencias; exit;
            }
    
            $valores 				    = implode(",", $array_valores_planesagencias);
            $insert_planesagencias 	    = $insert_planesagencias.$valores;
            
            // ESTO
            if(!ejecuta_insert($db_postgresql, $insert_planesagencias))
            {
                echo $insert_planesagencias; exit;
            }
        }
    }





























































//PLANES FUENTES *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: Planes Fuentes...';

    
    $insert           = "INSERT INTO planesfuentes ( idplan, idfuente ) VALUES ";
    $array_valores    = array();

    foreach($todos_los_planes as $idplan)
    {
        if($idplan != 0)
        {
            array_push($array_valores, "( $idplan, 1 )");
            array_push($array_valores, "( $idplan, 3 )");
        }
    }

    if(count($array_valores) > 0)
    {
        $valores 	    = implode(",", $array_valores);
        $insert 	    = $insert.$valores;

        // ESTO 
        ejecuta_insert($db_postgresql, $insert);
    }





















//PLANES ORIGENES Y DESTINOS *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: Planes Origenes...';

    $origenes = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE origenpermitido = true");

    $insert_planesorigenes           = "INSERT INTO planesorigenes ( idplan, idpais ) VALUES ";
    
    $array_valores_planesorigenes    = array();
    foreach($todos_los_planes as $idplan)
    {
        foreach($origenes['resultado'] as $origen)
        {
            $idpais     = $origen['idpais'];

            if($idplan != 0)
            {
                array_push($array_valores_planesorigenes, "( $idplan, $idpais )");
            }
        }
    }

    if(count($array_valores_planesorigenes) > 0)
    {
        $valores 				    = implode(",", $array_valores_planesorigenes);
        $insert_planesorigenes 	    = $insert_planesorigenes.$valores;

        // ESTO
        ejecuta_insert($db_postgresql, $insert_planesorigenes);
    }





















//PLANES DESTINOS *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: Planes Destinos...';

    $destinos = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE destinopermitido = true");

    $insert_planesdestinos           = "INSERT INTO planesdestinos ( idplan, idpais ) VALUES ";
    
    $array_valores_planesdestinos    = array();
    foreach($todos_los_planes as $idplan)
    {
        foreach($destinos['resultado'] as $origen)
        {
            $idpais     = $origen['idpais'];
            if($idplan != 0)
            {
                array_push($array_valores_planesdestinos, "( $idplan, $idpais )");
            }
        }
    }

    if(count($array_valores_planesdestinos) > 0)
    {
        $valores 				    = implode(",", $array_valores_planesdestinos);
        $insert_planesdestinos 	    = $insert_planesdestinos.$valores;

        // ESTO
        ejecuta_insert($db_postgresql, $insert_planesdestinos);
    }


















//PLANES PLATAFORMAS PAGO *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: Planes Plataformas Pago...';

    $insert_planesplataformaspago           = "INSERT INTO planesplataformaspago ( idplan, idplataformapago ) VALUES ";
    
    $array_valores_planesplataformaspago    = array();
    foreach($todos_los_planes as $idplan)
    {
        if($idplan != 0)
        {
            array_push($array_valores_planesplataformaspago, "( $idplan, 1 )");
            array_push($array_valores_planesplataformaspago, "( $idplan, 2 )");
        }
    }

    if(count($array_valores_planesplataformaspago) > 0)
    {
        $valores 				            = implode(",", $array_valores_planesplataformaspago);
        $insert_planesplataformaspago 	    = $insert_planesplataformaspago.$valores;

        // ESTO
        ejecuta_insert($db_postgresql, $insert_planesplataformaspago);
    }














   
// PLANES BENEFICIOS (LUEGO) *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: planesbeneficios...';

    $planesbeneficios = array();

    $mysql = $db_mysql->query("SELECT DISTINCT beneficios_costo.id_plan, 
                                        beneficios_costo.id_beneficio, 
                                        CAST(CONVERT(beneficios_costo.valor  USING utf8) AS binary) as cobertura,
                                        CAST(CONVERT(beneficios_costo.language_id  USING utf8) AS binary) as coberturaen,
                                        beneficios_costo.orden
                                        FROM beneficios_costo 
                                            JOIN plans ON plans.id = beneficios_costo.id_plan 
                                            JOIN beneficios ON beneficios.id_beneficio = beneficios_costo.id_beneficio 
                                        WHERE beneficios.language_id = 'spa' 
                                        AND plans.id > $ultimo_idplan
                                        ORDER BY id_plan ASC");

    while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    {
        $planesbeneficios[] = $row;
    }

    $insert = "INSERT INTO planesbeneficios ( idplan, idbeneficio, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ";

    $array_valores = array();

    foreach($planesbeneficios as $planbeneficio)
    {
        $idplan             = $planbeneficio['id_plan'];
        $idbeneficio        = $planbeneficio['id_beneficio'];
        $cobertura          = $planbeneficio['cobertura'];
        $coberturaen        = $planbeneficio['coberturaen'];
        $orden              = $planbeneficio['orden'];

        $valor     = " (
                            $idplan, 
                            $idbeneficio,
                            '$cobertura',
                            '$coberturaen',
                            $orden,
                            '2000-01-01 00:00:00'
                        )";

        array_push($array_valores, $valor);
    }

    if(count($array_valores) > 0)
    {
        $valores = implode(",", $array_valores);
        $insert = $insert.$valores;

        // ESTO
        ejecuta_insert($db_postgresql, $insert);
    }


















    // PLANES BENEFICIOS (LUEGO) *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: planesbeneficiosproveedores...';

    $planesbeneficios = ejecuta_select($db_postgresql, "SELECT idplanbeneficio FROM planesbeneficios WHERE idplan > $ultimo_idplan");

    if($planesbeneficios['cantidad'] > 0)
    {
        $insert         = "INSERT INTO planesbeneficiosproveedores ( idplanbeneficio, idproveedor, porcentajeriesgo, fechaactualizacion ) VALUES ";
        $array_valores  = array();

        foreach($planesbeneficios['resultado'] as $planbeneficio)
        {
            $idplanbeneficio  = $planbeneficio['idplanbeneficio'];
    
            $valor     = " (
                                $idplanbeneficio, 
                                1,
                                100,
                                '2000-01-01 00:00:00'
                            )";
    
            array_push($array_valores, $valor);
        }
    
        if(count($array_valores) > 0)
        {
            $valores = implode(",", $array_valores);
            $insert = $insert.$valores;

            // ESTO
            ejecuta_insert($db_postgresql, $insert);
        }
    }


















// PLANES BENEFICIOS ADICIONALES (LUEGO) *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: planesbeneficiosadicionales...';

    $planesbeneficiosadicionales = array();

    $mysql = $db_mysql->query("SELECT DISTINCT beneficios_plus.id_plan as idplan, 
                                        beneficios_plus.id_beneficio as idbeneficioadicional,
                                        '0.2' as factorconversion,
                                        '0.2' as factorconversionedad,
                                        '0.2' as factorconversionfamiliar,
                                        CAST(CONVERT(beneficios_plus.valor  USING utf8) AS binary) as cobertura,
                                        CAST(CONVERT(beneficios_plus.valor  USING utf8) AS binary) as coberturaen,
                                        beneficios_plus.orden as orden,
                                        '2000-01-01 00:00:00' as fechaactualizacion
                                        FROM beneficios_plus 
                                        WHERE beneficios_plus.language_id = 'spa' 
                                        AND beneficios_plus.id_plan > $ultimo_idplan
                                        AND beneficios_plus.id_beneficio IN (35,36,37)
                                        ORDER BY beneficios_plus.id ASC");

    while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    {
        $planesbeneficiosadicionales[] = $row;
    }

    $insert = "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ";

    $array_valores = array();

    foreach($planesbeneficiosadicionales as $planbeneficioadicional)
    {
        $idplan                     = $planbeneficioadicional['idplan'];
        $idbeneficioadicional       = $planbeneficioadicional['idbeneficioadicional'];
        $factorconversion           = $planbeneficioadicional['factorconversion'];
        $factorconversionedad       = $planbeneficioadicional['factorconversionedad'];
        $factorconversionfamiliar   = $planbeneficioadicional['factorconversionfamiliar'];
        $cobertura                  = $planbeneficioadicional['cobertura'];
        $coberturaen                = $planbeneficioadicional['coberturaen'];
        $orden                      = $planbeneficioadicional['orden'];
        $fechaactualizacion         = $planbeneficioadicional['fechaactualizacion'];

        $valor     = " (
                                $idplan, 
                                $idbeneficioadicional,
                                '$factorconversion',
                                '$factorconversionedad',
                                '$factorconversionfamiliar',
                                '$cobertura',
                                '$coberturaen',
                                $orden,
                                '$fechaactualizacion'
                            )";

        array_push($array_valores, $valor);
    }

    if(count($array_valores) > 0)
    {
        $valores = implode(",", $array_valores);
        $insert = $insert.$valores;

        // ESTO
        ejecuta_insert($db_postgresql, $insert);
    }











    // PLANES BENEFICIOS ADICIONALES PROVEEDORES(LUEGO) *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: planesbeneficiosadicionalesproveedores...';

    $planesbeneficiosadicionales = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan > $ultimo_idplan");

    if($planesbeneficiosadicionales['cantidad'] > 0)
    {
        $insert = "INSERT INTO planesbeneficiosadicionalesproveedores ( idplanbeneficioadicional, idproveedor, porcentajeriesgo ) VALUES ";
    
        $array_valores = array();
    
        foreach($planesbeneficiosadicionales['resultado'] as $planbeneficioadicional)
        {
            $idplanbeneficioadicional                     = $planbeneficioadicional['idplanbeneficioadicional'];
    
            $valor     = " (
                                $idplanbeneficioadicional, 
                                2,
                                100
                            )";
    
            array_push($array_valores, $valor);
        }
    
        if(count($array_valores) > 0)
        {
            $valores = implode(",", $array_valores);
            $insert = $insert.$valores;
            // ESTO
            ejecuta_insert($db_postgresql, $insert);
        }
    }
























































    


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
                    (SELECT DISTINCT valor FROM exchange WHERE exchange.currency = moneda_ AND exchange.tipo =1 ORDER BY id DESC LIMIT 1) as cambio
                FROM orders 
                WHERE (orders.id > $ultimo_idorden AND orders.status IN (1,2,4) AND orders.nombre_contacto NOT LIKE '%PRUEBA%')
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

        if($registro['idagencia'] != 0 && $registro['idorden'] > 0 && $registro['idcategoria'] > 0)
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
           
            $tasacambio            = empty($registro['cambio']) ? 1 : $registro['cambio'];
            
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
                                                                '$nombrecontacto',
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
                    $idorigen       = ($idorigen == 0) ? 99 : $idorigen;
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
                                    echo $insert_beneficiarios; exit;
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
                else if($registro['emisioncorporativa'] == 1 && $registro['fechadesde'] == '0000-00-00')
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
                                                                WHEN destino = 1 THEN 279
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
                                                        WHERE orden = $idorden
                                                    ";

                        $mysql_asistenciacorporativa = $db_mysql->query($select_asistenciacorporativa);
                        $row_asistenciacorporativa = array();
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
                                                                                COALESCE(precio_vta, 0) as precioventa,
                                                                                COALESCE(precio_cost, 0) as costo1,
                                                                                COALESCE(precio_cost2, 0) as costo2
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
                                                $costo1                 = $beneficiario_corporativo['costo1'];
                                                $costo2                 = $beneficiario_corporativo['costo2'];
    
                                                if($beneficiario_corporativo['fechanacimiento'] == NULL || $beneficiario_corporativo['fechanacimiento'] == 'NULL' )
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
    
                                                // echo 'b-';
                                                
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
                                                    echo $insert_beneficiarios; exit;
                                                }
    
                                                $consecutivo++;
                                            }
                                        }
    
                                        $row_array_beneficiarios_corporativos = array();
                                    }
                                    else
                                    {
                                        echo $insert_contactos_asistenciacorporativaviaje; exit;
                                    }
                                }
                                else
                                {
                                    echo $insert_asistenciacorporativaviaje; exit;
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
                else
                {
                    if($cargaprecompra)
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
                                $idstatus           = ($row_precompra['idstatus'] == 0) ? 2 : $row_precompra['idstatus'];
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
                                    echo $insert_precompra; exit;
                                }
                            }
                        }
                    }
                    else
                    {
                        // EMISIONES DE PRECOMPRA
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

                                            }
                                            else
                                            {

                                            }
                                    }
                                    else
                                    {
                                        echo 'Insercion de Emision de Precompra';
                                        echo $insert_emision_precompra; exit;
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
                echo $insert; exit;
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


    $ultimo_idorden = ejecuta_select($db_postgresql, "SELECT MAX(idorden) as idorden FROM ordenes", "idorden");
    $secuencia = $ultimo_idorden + 1;
    $secuencia = "ALTER SEQUENCE ordenes_idorden_seq RESTART WITH ".$secuencia; 
    ejecuta_select($db_postgresql, $secuencia);

    $ultimo_idbeneficiario = ejecuta_select($db_postgresql, "SELECT MAX(idbeneficiario) as idbeneficiario FROM beneficiarios", "idbeneficiario");
    $secuencia = $ultimo_idbeneficiario + 1;
    $secuencia = "ALTER SEQUENCE beneficiarios_idbeneficiario_seq RESTART WITH ".$secuencia; 
    ejecuta_select($db_postgresql, $secuencia);

    $secuencia = select_max_id($db_postgresql, 'idprecompra', 'precompras');
    $secuencia = $secuencia + 1;
    $secuencia = "ALTER SEQUENCE precompra_idprecompra_seq RESTART WITH ".$secuencia; 
    ejecuta_select($db_postgresql, $secuencia);
    





















/****************************************************************************************/
// ACTUALIZAR UNIFICACIONES
/****************************************************************************************/
        
    echo '
    Borrando unificarvouchers...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE vouchersunificados CASCADE");


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
                            UPPER('$codigovoucher'),
                            $vaciarbolsa,
                            $diassumados,
                            $diasrestados,
                            '$fechaunificacion',
                            '$comentarios'
                        )";
    
                array_push($array_valores, $valor);
            }
    
            if(count($array_valores) > 0)
            {
                $valores = implode(",", $array_valores);
                $insert = $insert.$valores;
                if(!ejecuta_insert($db_postgresql, $insert))
                {
                    echo $insert; exit;
                }
            }
    
        //SECUENCIA UNIFICACIÓN
            $secuencia = $idunificacion + 1;
            $secuencia = "ALTER SEQUENCE unificarvouchers_idunificacion_seq RESTART WITH ".$secuencia; 
            ejecuta_select($db_postgresql, $secuencia);

/****************************************************************************************/
// FIN ACTUALIZAR UNIFICACIONES
/****************************************************************************************/
    


































// UNIFICACIONES *******************************************************************************************************************************************************************************
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
                                    WHERE id_unificacion > $ultimo_idunificacion
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

            $valor = "(
                        $idunificacion,
                        '$codigovoucher',
                        $vaciarbolsa,
                        $diassumados,
                        $diasrestados,
                        '$fechaunificacion',
                        '$comentarios'
                    )";

            array_push($array_valores, $valor);
        }

        if(count($array_valores) > 0)
        {
            $valores = implode(",", $array_valores);
            $insert = $insert.$valores;

            if(!ejecuta_insert($db_postgresql, $insert))
            {
                echo $insert; exit;
            }

            //SECUENCIA UNIFICACIÓN
            $secuencia = $idunificacion + 1;
            $secuencia = "ALTER SEQUENCE unificarvouchers_idunificacion_seq RESTART WITH ".$secuencia; 
            ejecuta_select($db_postgresql, $secuencia);
        }

    


    // ACTUALIZACIÓN DE LAS VISTAS
    echo '
Actualizando Vistas...
';
        //ejecuta_select($db_postgresql, 'REFRESH MATERIALIZED view vwm_reporteglobal');
        ejecuta_select($db_postgresql, 'REFRESH MATERIALIZED view vwm_reporteglobal_2024');






    





    echo '
Asignando tokens de agencias
';
    
        $contador_agencias_actualizadas = 0;

        $condicion_agencias_noencontradas = ($implode_agencias_noencontradas != '') ? " OR idagencia IN ($implode_agencias_noencontradas) " : "";
        
        $agencias_sin_token = ejecuta_select($db_postgresql, "SELECT idagencia, nombreagencia, logoagencia, color1frame, tokenpagina, tokenhash FROM agencias WHERE agencias.tokenhash IS NULL AND idagencia > $ultimo_idagencia $condicion_agencias_noencontradas");
    
        if($agencias_sin_token['cantidad'] > 0)
        {
            foreach($agencias_sin_token['resultado'] as $agencia)
            {
                if(!$agencia['tokenpagina'] && !$agencia['tokenhash'])
                {
                    $idagencia      = $agencia['idagencia'];
                    $nombreagencia  = $agencia['nombreagencia'];
                    $nombreagencia  = str_replace(' ', '', $nombreagencia);
                    $nombreagencia  = str_replace('.', '', $nombreagencia);
                    $nombreagencia  = str_replace(',', '', $nombreagencia);
                    $nombreagencia  = str_replace('/', '', $nombreagencia);
                    $nombreagencia  = str_replace('(', '', $nombreagencia);
                    $nombreagencia  = str_replace(')', '', $nombreagencia);
                    $nombreagencia  = str_replace('+', '', $nombreagencia);
                    $nombreagencia  = str_replace('&', '', $nombreagencia);
                    $nombreagencia  = str_replace('"', '', $nombreagencia);
                    $nombreagencia  = str_replace("'", '', $nombreagencia);
                    $nombreagencia  = str_replace('?', '', $nombreagencia);
                    $nombreagencia  = str_replace('$', '', $nombreagencia);
                    $nombreagencia  = str_replace('ñ', 'n', $nombreagencia);
                    $nombreagencia  = str_replace('Ñ', 'n', $nombreagencia);
                    $nombreagencia  = str_replace('-', '', $nombreagencia);
                    $nombreagencia  = str_replace('_', '', $nombreagencia);
                    $nombreagencia  = str_replace('á', 'a', $nombreagencia);
                    $nombreagencia  = str_replace('é', 'e', $nombreagencia);
                    $nombreagencia  = str_replace('í', 'i', $nombreagencia);
                    $nombreagencia  = str_replace('ó', 'o', $nombreagencia);
                    $nombreagencia  = str_replace('ú', 'u', $nombreagencia);
                    $nombreagencia  = str_replace('Á', 'a', $nombreagencia);
                    $nombreagencia  = str_replace('É', 'e', $nombreagencia);
                    $nombreagencia  = str_replace('Í', 'i', $nombreagencia);
                    $nombreagencia  = str_replace('Ó', 'o', $nombreagencia);
                    $nombreagencia  = str_replace('Ó', 'u', $nombreagencia);
                    $nombreagencia  = strtolower($nombreagencia);
                    $tokenpagina    = "www.".$nombreagencia.".com";
        
                    $valida_tokenpagina = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM agencias WHERE tokenpagina = '$tokenpagina'", "cantidad");
        
                    if($valida_tokenpagina)
                    {
                        $contador = 1;
                        while($valida_tokenpagina)
                        {
                            $tokenpagina        = "www.".$nombreagencia.$contador.".com";
                            $valida_tokenpagina = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM agencias WHERE tokenpagina = '$tokenpagina'", "cantidad");
                            $contador++;
                        }
                    }
        
                    $cadena         = 'Continental'.$nombreagencia.'Assist';
                    $tokenhash      = sha1($cadena);
        
                    ejecuta_update($db_postgresql, "UPDATE agencias SET tokenpagina = '$tokenpagina', tokenhash = '$tokenhash' WHERE idagencia = $idagencia ");
                    
                    $contador_agencias_actualizadas++;
                }
            }
        }
    



    // ASIGNAR PRECIOS NO ASIGNADOS

echo '
Asignando precios a planes sin precios
';

        $insert_precios         = "INSERT INTO planesprecios (idplan, idpais, dia, precio) VALUES ";
        $insert_costos          = "INSERT INTO planescostos (idplan, idpais, idproveedor, dia, costo) VALUES ";
        $array_precios              = array();
        $array_costos               = array();
        $array_planes_paises        = array();
        $array_con_precio           = array();
        $array_con_precio_paises    = array();
        $array_sin_precio           = array();
        $planes_sin_precio          = array();

        $planes = ejecuta_select($db_postgresql, "SELECT 
                                                            idplan, 
                                                            count(*) as cantidad_paises
                                                        FROM planespaises 
                                                        WHERE idplan > $ultimo_idplan
                                                        GROUP BY 1
                                                        order by cantidad_paises DESC
                                                    ");

        if($planes['cantidad'] > 0)
        {
            foreach($planes['resultado'] as $plan)
            {
                if($plan['cantidad_paises'] > 1)
                {
                    $idplan = $plan['idplan'];
    
                    $planpaises = ejecuta_select($db_postgresql, "SELECT idpais FROM planespaises WHERE idplan = $idplan");
    
                    foreach($planpaises['resultado'] as $planpais)
                    {
                        $idpais = $planpais['idpais'];
                        $valor  = array("idplan" => $idplan, "idpais" => $idpais);
    
                        $cantidad = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planesprecios WHERE idplan = $idplan AND idpais = $idpais", "cantidad");
    
                        if($cantidad == 0)
                        {
                            array_push($array_sin_precio, $valor);
                        }
                        else
                        {
                            array_push($array_con_precio, $idplan);
                            array_push($array_con_precio_paises, $valor);
                        }
                    }
                }
            }
        }



        foreach($array_sin_precio as $sinprecio)
        {
            $idplan_sinprecio = $sinprecio['idplan'];
            $idpais_sinprecio = $sinprecio['idpais'];

            if(in_array($idplan_sinprecio, $array_con_precio))
            {
                foreach($array_con_precio_paises as $con_precio_paises)
                {
                    if($idplan_sinprecio == $con_precio_paises['idplan'])
                    {
                        $idpais_con_precio = $con_precio_paises['idpais'];

                        $precios = ejecuta_select($db_postgresql, "SELECT dia, precio FROM planesprecios WHERE idplan = $idplan_sinprecio AND idpais = $idpais_con_precio ORDER BY dia ASC");

                        if($precios['cantidad'] > 0)
                        {
                            foreach($precios['resultado'] as $diaprecio)
                            {
                                $dia    = $diaprecio['dia'];
                                $precio = $diaprecio['precio'];

                                array_push($array_precios, "($idplan_sinprecio, $idpais_sinprecio, $dia, $precio)");
                            }

                            $costos  = ejecuta_select($db_postgresql, "SELECT dia, costo, idproveedor FROM planescostos WHERE idplan = $idplan_sinprecio AND idpais = $idpais_con_precio ORDER BY dia ASC");
                        
                            if($costos['cantidad'] > 0)
                            {
                                foreach($costos['resultado'] as $diacosto)
                                {
                                    $dia            = $diacosto['dia'];
                                    $idproveedor    = $diacosto['idproveedor'];
                                    $costo          = $diacosto['costo'];

                                    array_push($array_costos, "($idplan_sinprecio, $idpais_sinprecio, $idproveedor, $dia, $costo)");
                                }
                            }

                            break;
                        }
                    }
                }
            }
        }

        if(count($array_precios) > 0)
        {
            $valores = implode(",", $array_precios);
            $insert_precios     = $insert_precios.$valores;
            ejecuta_insert($db_postgresql, $insert_precios);
        }

        if(count($array_costos) > 0)
        {
            $valores = implode(",", $array_costos);
            $insert_costos     = $insert_costos.$valores;
            ejecuta_insert($db_postgresql, $insert_costos);
        }






// ELIMINA DUPLICAODS EN PLANES PAISES
ejecuta_update($db_postgresql, "DELETE from planespaises where idplanpais in (
    SELECT MIN(idplanpais) as min_idplanpais
    FROM planespaises
    GROUP BY idplan, idpais
    HAVING COUNT(*) > 1)");




// BORRANDO COMISIONES AGENCIAS DUPLICADAS
echo '
Borrando comisionesagencias duplicadas...
';
// ejecuta_delete($db_postgresql, "DELETE FROM comisionesagencias WHERE idcomisiones NOT IN ( SELECT MIN(idcomisiones) FROM comisionesagencias GROUP BY idagencia, idcategoria HAVING COUNT(*) > 1 )");
ejecuta_delete($db_postgresql, "DELETE from planesagencias where idplanesagencias in (select MIN(idplanesagencias) from planesagencias group by idplan,idagencia having count(*) > 1 order by 1 desc)");





























$hora_fin   = date('h:i:s', time());  







    echo '
    FIN: '.$hora_fin.' 
';











    echo '
Proceso Terminado
';
?>
