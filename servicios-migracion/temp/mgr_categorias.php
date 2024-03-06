<?php 

    include('./lib/funciones.php');
    include('./lib/mysql.php');
    include('./lib/pgsql.php');

    $db_postgresql      = getDB();
    $db_mysql           = connect_db();
    
    // /*** CUIDADO, SOLO INCLUIR $db_postgresql ***********************************************************/
    // /**/ 
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM auditorias");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM usuarios");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM cuponesagencias");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM cuponesplanes");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM cuponescategorias");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM categoriasagencias");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM agencias");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM beneficios");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM beneficioscategorias");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM categoriasfuentes");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM categoriasorigenes");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM categoriaspaises");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM categoriasdestinos");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM categorias");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM crucerosordenes");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM cruceros");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM cupones");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM planes");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM planesprecios");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM planescostos");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM planesagencias");
    /**/ ejecuta_delete($db_postgresql, "DELETE FROM planesbeneficios");

    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE auditorias_idauditoria_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE usuarios_idusuario_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE agencias_idagencia_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficios_idbeneficio_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficioscategorias_idbeneficiocategoria_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categorias_idcategoria_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriasagencias_idcategoriaagencia_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriasdestinos_idcategoriadestino_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriasfuentes_idcategoriafuente_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriasorigenes_idcategoriaorigen_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriaspaises_idcategoriapais_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cruceros_idcrucero_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE crucerosordenes_idcruceroorden_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cupones_idcupon_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE agentescupones_idagentecupon_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cuponesplanes_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cuponescategorias_idcuponcategoria_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planes_idplan_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE precios_idprecio_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planescostos_idplancosto_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesagencias_idplanesagencias_seq RESTART WITH 1");
    /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesbeneficios_idplanbeneficio_seq RESTART WITH 1");
    // /**/ 
    // /*** CUIDADO, SOLO INCLUIR $db_postgresql ***********************************************************/

    // // FORMATO *******************************************************************************************************************************************************************************
    //     $mysql_    = $db_mysql->query("SELECT  
    //                                         FROM  
    //                                         ORDER BY id ASC 
    //                                         ");

    //     while ($row = $mysql_->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $registros[] = $row;
    //     }

    //     echo 'Migrando  ';

    //     foreach($registros as $registro)
    //     {
    //         echo '.';    

    //         $idplan                                     = $registro['id'];

    //         $insert = "INSERT INTO planes (
    //                                     )
    //                                 VALUES(
                                         
    //                                     )";

    //         if(ejecuta_insert($db_postgresql, $insert))
    //         {

    //         }
    //     }

    // AGENCIAS *******************************************************************************************************************************************************************************
        $mysql    = $db_mysql->query("SELECT 
                                        broker.id_broker as idagencia,
                                        id_cia as idsistema,
                                        UPPER(CAST(CONVERT(broker USING utf8) AS binary)) as nombreagencia,
                                        id_status as idstatus,
                                        broker.nivel as idnivel,
                                        id_site as idpais,
                                        CAST(CONVERT(phone1 USING utf8) AS binary) as telefono1,
                                        CAST(CONVERT(phone2 USING utf8) AS binary) as telefono2,
                                        CAST(CONVERT(phone3 USING utf8) AS binary) as telefono3,
                                        CAST(CONVERT(address USING utf8) AS binary) as direccion,
                                        date_up as fechacreacion,
                                        COALESCE(account_manager, 293) as idagente,
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
                                    ORDER BY broker.id_broker ASC
                                    ");

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $registros[] = $row;
        }

        echo 'Migrando Tabla: agencias';

        foreach($registros as $registro)
        {
            echo '.';    

            $idagencia                  = $registro['idagencia'];
            $idsistema                  = $registro['idsistema'];
            $nombreagencia              = $registro['nombreagencia'];
            $idstatus                   = $registro['idstatus'];
            $idnivel                    = $registro['idnivel'];
            $idpais                     = $registro['idpais'];
            $telefono1                  = $registro['telefono1'];
            $telefono2                  = $registro['telefono2'];
            $telefono3                  = $registro['telefono3'];
            $direccion                  = $registro['direccion'];
            $fechacreacion              = $registro['fechacreacion'];
            $idagente                   = $registro['idagente'];
            $logoagencia                = $registro['logoagencia'];
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

            if(!ejecuta_insert($db_postgresql, $insert)) {echo $insert; exit;}
        }

    // BENEFICIOS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: beneficios';

        $mysql_beneficios = $db_mysql->query("SELECT 
                                                    id_beneficio as idbeneficio, 
                                                    CAST(CONVERT(name USING utf8) AS binary) as nombrebeneficio,
                                                    COALESCE(id_status, 'false') as idstatus,
                                                    '2021-01-01 00:00:00' as fechacreacion,
                                                    '2021-01-01 00:00:00' as fechamodificacion,
                                                    min_age as edadminima,
                                                    max_age as edadmaxima,
                                                    CAST(CONVERT(descripcion USING utf8) AS binary) as descripcionbeneficio,
                                                    COALESCE(id_fam, 0) as idfamilia,
                                                    1 as idtipoasistencia
                                                FROM beneficios 
                                                WHERE language_id = 'spa'
                                                ORDER BY id_beneficio ASC");

        while ($row = $mysql_beneficios->fetch_array(MYSQLI_ASSOC)) 
        {
            $beneficios_spa[] = $row;
        }

        foreach($beneficios_spa as $beneficio)
        {
            echo '.';

            $idbeneficio            = $beneficio['idbeneficio']; 
            $nombrebeneficio        = $beneficio['nombrebeneficio']; 
            $idstatus               = $beneficio['idstatus']; 
            $fechacreacion          = $beneficio['fechacreacion']; 
            $fechamodificacion      = $beneficio['fechamodificacion']; 
            $edadminima             = $beneficio['edadminima']; 
            $edadmaxima             = $beneficio['edadmaxima']; 
            $descripcionbeneficio   = $beneficio['descripcionbeneficio']; 
            $idfamilia              = $beneficio['idfamilia']; 
            $idtipoasistencia       = $beneficio['idtipoasistencia']; 

            $insert     = "INSERT INTO beneficios (
                                    idbeneficio,
                                    nombrebeneficio,
                                    idstatus,
                                    fechacreacion,
                                    fechamodificacion,
                                    edadminima,
                                    edadmaxima,
                                    descripcionbeneficio,
                                    idfamilia,
                                    idtipoasistencia
                                )
                            VALUES
                                (
                                    $idbeneficio,
                                    '$nombrebeneficio',
                                    $idstatus,
                                    '$fechacreacion',
                                    '$fechamodificacion',
                                    $edadminima,
                                    $edadmaxima,
                                    '$descripcionbeneficio',
                                    $idfamilia,
                                    $idtipoasistencia
                                )";

            ejecuta_insert($db_postgresql, $insert);
        }

        $mysql_beneficios = $db_mysql->query("SELECT 
                                                    id_beneficio as idbeneficio, 
                                                    CAST(CONVERT(name USING utf8) AS binary) as nombrebeneficio,
                                                    CAST(CONVERT(descripcion USING utf8) AS binary) as descripcionbeneficio
                                                FROM beneficios 
                                                WHERE language_id = 'eng'
                                                ORDER BY id_beneficio ASC");

        while ($row = $mysql_beneficios->fetch_array(MYSQLI_ASSOC)) 
        {
            $beneficios_eng[] = $row;
        }

        foreach($beneficios_eng as $beneficio)
        {
            echo '.';
            $idbeneficio            = $beneficio['idbeneficio'];
            $nombrebeneficio        = $beneficio['nombrebeneficio'];
            $descripcionbeneficio   = $beneficio['descripcionbeneficio'];

            $update = "UPDATE beneficios SET nombrebeneficioen = '$nombrebeneficio', descripcionbeneficioen = '$descripcionbeneficio' WHERE  idbeneficio = $idbeneficio ";
            ejecuta_update($db_postgresql, $update);
        }

    // BENEFICIOS CATEGORIAS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: beneficioscategorias';

        $mysql = $db_mysql->query("SELECT DISTINCT id_categoria, id_beneficio FROM beneficios_costo ORDER BY id_categoria ASC");

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $beneficioscategorias[] = $row;
        }

        foreach($beneficioscategorias as $beneficiocategoria)
        {
            echo '.';

            $idcategoria    = $beneficiocategoria['id_categoria'];
            $idbeneficio    = $beneficiocategoria['id_beneficio'];

            $insert     = "INSERT INTO beneficioscategorias (
                                    idcategoria, 
                                    idbeneficio
                                )
                            VALUES
                                (
                                    $idcategoria, 
                                    $idbeneficio
                                )";

            ejecuta_insert($db_postgresql, $insert);
        }


    // BENEFICIOS  *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: beneficioscategorias';

        $mysql = $db_mysql->query("SELECT DISTINCT id_categoria, id_beneficio FROM beneficios_costo ORDER BY id_categoria ASC");

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $beneficioscategorias[] = $row;
        }

        foreach($beneficioscategorias as $beneficiocategoria)
        {
            echo '.';

            $idcategoria    = $beneficiocategoria['id_categoria'];
            $idbeneficio    = $beneficiocategoria['id_beneficio'];

            $insert     = "INSERT INTO beneficioscategorias (
                                    idcategoria, 
                                    idbeneficio
                                )
                            VALUES
                                (
                                    $idcategoria, 
                                    $idbeneficio
                                )";

            ejecuta_insert($db_postgresql, $insert);
        }

    //CATEGORIAS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: categorias';

        $mysql_categorias = $db_mysql->query("SELECT 
                                                        id_plan_categoria as idcategoria, 
                                                        name_plan as nombrecategoria,
                                                        1 as idstatus,
                                                        '' as nombrecategoriaen,
                                                        CAST(CONVERT(description_plan USING utf8) AS binary) as descripcioncategoria,
                                                        '' as descripcioncategoriaen,
                                                        moneda as moneda,
                                                        min_time as tiempominimo,
                                                        max_time as tiempomaximo,
                                                        min_age as edadminima,
                                                        max_age as edadmaxima,
                                                        true as planfamiliar
                                                    FROM plan_categoria_detail
                                                    WHERE language_id = 'spa'
                                                    ");

        while ($row = $mysql_categorias->fetch_array(MYSQLI_ASSOC)) 
        {
            $categorias[] = $row;
        }

        foreach($categorias as $categoria)
        {
            echo '.';

            $idcategoria                = $categoria['idcategoria']; 
            $nombrecategoria            = $categoria['nombrecategoria']; 
            $idstatus                   = $categoria['idstatus']; 
            $nombrecategoriaen          = $categoria['nombrecategoriaen']; 
            $descripcioncategoria       = $categoria['descripcioncategoria']; 
            $descripcioncategoriaen     = $categoria['descripcioncategoriaen']; 
            $monedacategoria            = $categoria['moneda']; 
            $idmoneda                   = ejecuta_select($db_postgresql, "SELECT idmoneda FROM monedas WHERE codigo = '$monedacategoria'",'idmoneda');
            $tiempominimo               = $categoria['tiempominimo']; 
            $tiempomaximo               = $categoria['tiempomaximo']; 
            $edadminima                 = $categoria['edadminima']; 
            $edadmaxima                 = $categoria['edadmaxima']; 
            $planfamiliar               = $categoria['planfamiliar']; 

            $insert     = "INSERT INTO categorias (
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
                                        edadmaxima,
                                        planfamiliar
                                    )
                                VALUES
                                    (
                                        $idcategoria,
                                        '$nombrecategoria',
                                        $idstatus,
                                        '$nombrecategoriaen',
                                        '$descripcioncategoria',
                                        '$descripcioncategoriaen',
                                        $idmoneda,
                                        $tiempominimo,
                                        $tiempomaximo,
                                        $edadminima,
                                        $edadmaxima,
                                        '$planfamiliar'
                                )";

            if(!ejecuta_insert($db_postgresql, $insert)) echo $insert;
        }

        $mysql_categorias = $db_mysql->query("SELECT 
                                                        id_plan_categoria as idcategoria, 
                                                        name_plan as nombrecategoria,
                                                        CAST(CONVERT(description_plan USING utf8) AS binary) as descripcioncategoria
                                                    FROM plan_categoria_detail
                                                    WHERE language_id = 'eng'
                                                    ");

        while ($row = $mysql_categorias->fetch_array(MYSQLI_ASSOC)) 
        {
            $categorias[] = $row;
        }

        foreach($categorias as $categoria)
        {   
            $idcategoria            = $categoria['idcategoria'];
            $nombrecategoriaen      = $categoria['nombrecategoria'];
            $descripcioncategoriaen = $categoria['descripcioncategoria'];


            $update = "UPDATE categorias SET nombrecategoriaen = '$nombrecategoriaen', descripcioncategoriaen = '$descripcioncategoriaen' WHERE  idcategoria = $idcategoria ";
            
            if(!ejecuta_update($db_postgresql, $update)) echo $update;
        }

    // CATEGORIAS AGENCIAS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: categoriasagencias';

        $mysql_categorias_agencias = $db_mysql->query("SELECT DISTINCT COALESCE(programaplan, 0) as programaplan, agencia FROM orders ORDER BY programaplan ASC");

        while ($row = $mysql_categorias_agencias->fetch_array(MYSQLI_ASSOC)) 
        {
            $categorias_agencias[] = $row;
        }

        foreach($categorias_agencias as $categoria_agencia)
        {
            echo '.';
            
            $idcategoria    = $categoria_agencia['programaplan'];
            $idagencia      = $categoria_agencia['agencia'];

            $select = "SELECT idagencia FROM agencias WHERE idagencia = $idagencia";
            $select_agencia = ejecuta_select($db_postgresql, $select);

            if($select_agencia['cantidad'] > 0 && $idcategoria != null && $idcategoria != 0)
            {
                $insert     = "INSERT INTO categoriasagencias (
                                        idcategoria, 
                                        idagencia
                                    )
                                VALUES
                                    (
                                        $idcategoria, 
                                        $idagencia
                                    )";
    
                if(!ejecuta_insert($db_postgresql, $insert)) echo $insert;
            }
        }

    // CATEGORIAS DESTINOS *******************************************************************************************************************************************************************************
        $categorias = ejecuta_select($db_postgresql, "SELECT  idcategoria FROM categorias ORDER BY idcategoria ASC ");
        $paises     = ejecuta_select($db_postgresql, "SELECT  idpais FROM paises ORDER BY idpais ASC ");

        echo 'Migrando Tabla: categoriasdestinos';

        foreach($categorias['resultado'] as $categoria)
        {
            $idcategoria = $categoria['idcategoria'];

            foreach($paises['resultado'] as $pais)
            {
                echo '.';    

                $idpais = $pais['idpais'];

                $insert = "INSERT INTO categoriasdestinos(idcategoria, idpais) VALUES ($idcategoria, $idpais)";
                
                if(!ejecuta_insert($db_postgresql, $insert))
                {
                    echo $insert;
                    exit;
                }
            }
        }

    // CATEGORIAS FUENTES *******************************************************************************************************************************************************************************
        $categorias = ejecuta_select($db_postgresql, "SELECT  idcategoria FROM categorias ORDER BY idcategoria ASC ");
        $fuentes    = ejecuta_select($db_postgresql, "SELECT  idfuente FROM fuentes ORDER BY idfuente ASC ");

        echo 'Migrando Tabla: categoriasfuentes';

        foreach($categorias['resultado'] as $categoria)
        {
            $idcategoria = $categoria['idcategoria'];

            foreach($fuentes['resultado'] as $fuente)
            {
                echo '.';    

                $idfuente = $fuente['idfuente'];

                $insert = "INSERT INTO categoriasfuentes(idcategoria, idfuente) VALUES ($idcategoria, $idfuente)";
                
                if(!ejecuta_insert($db_postgresql, $insert))
                {
                    echo $insert;
                    exit;
                }
            }
        }

    // CATEGORIAS ORIGEN *******************************************************************************************************************************************************************************
        $categorias = ejecuta_select($db_postgresql, "SELECT  idcategoria FROM categorias ORDER BY idcategoria ASC ");
        $paises     = ejecuta_select($db_postgresql, "SELECT  idpais FROM paises ORDER BY idpais ASC ");

        echo 'Migrando Tabla: categoriasorigenes';

        foreach($categorias['resultado'] as $categoria)
        {
            $idcategoria = $categoria['idcategoria'];

            foreach($paises['resultado'] as $pais)
            {
                echo '.';    

                $idpais = $pais['idpais'];

                $insert = "INSERT INTO categoriasorigenes(idcategoria, idpais) VALUES ($idcategoria, $idpais)";
                
                if(!ejecuta_insert($db_postgresql, $insert))
                {
                    echo $insert;
                    exit;
                }
            }
        }

    // CATEGORIAS PAISES *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: categoriaspaises';

        $mysql_categorias_paises = $db_mysql->query("SELECT DISTINCT id_site, id_category FROM category_site ORDER BY id_site ASC");

        while ($row = $mysql_categorias_paises->fetch_array(MYSQLI_ASSOC)) 
        {
            $categorias_paises[] = $row;
        }

        foreach($categorias_paises as $categoria_pais)
        {
            echo '.';
            
            $idpais         = $categoria_pais['id_site'];
            $idcategoria    = $categoria_pais['id_category'];

            if($idcategoria != null && $idcategoria != 0)
            {
                $insert     = "INSERT INTO categoriaspaises (
                                        idcategoria, 
                                        idpais
                                    )
                                VALUES
                                    (
                                        $idcategoria, 
                                        $idpais
                                    )";

                if(!ejecuta_insert($db_postgresql, $insert)) echo $insert;
            }
        }

    // CRUCEROS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: cruceros';

        $mysql_cruceros = $db_mysql->query("SELECT id, CAST(CONVERT(crucero USING utf8) AS binary) as crucero, status FROM cruiseline ORDER BY id ASC");

        while ($row = $mysql_cruceros->fetch_array(MYSQLI_ASSOC)) 
        {
            $cruceros[] = $row;
        }

        foreach($cruceros as $crucero)
        {
            echo '.';
            
            $idcrucero      = $crucero['id'];
            $nombrecrucero  = $crucero['crucero'];
            $idstatus       = $crucero['status'];
           
            $insert     = "INSERT INTO cruceros (
                                    idcrucero, 
                                    nombrecrucero,
                                    idstatus
                                )
                            VALUES
                                (
                                    $idcrucero, 
                                    '$nombrecrucero',
                                    $idstatus
                                )";

            if(!ejecuta_insert($db_postgresql, $insert)) echo $insert;
        }

    // CRUCEROS ORDENES *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: crucerosordenes';

        $mysql_cruceros_ordenes = $db_mysql->query("SELECT id, COALESCE(id_order, 0) as id_order, COALESCE(id_cruise, 0) as id_cruise, confirmacion FROM cruise_order ORDER BY id ASC");

        while ($row = $mysql_cruceros_ordenes->fetch_array(MYSQLI_ASSOC)) 
        {
            $cruceros_ordenes[] = $row;
        }

        foreach($cruceros_ordenes as $cruceroorden)
        {
            echo '.';
            
            $idcruceroorden = $cruceroorden['id'];
            $idcrucero      = $cruceroorden['id_cruise'];
            $idorden        = $cruceroorden['id_order'];
            $confirmacion   = $cruceroorden['confirmacion'];
        
            if($idcrucero != 0 && $idorden != 0)
            {
                $insert     = "INSERT INTO crucerosordenes (
                                        idcruceroorden,
                                        idcrucero, 
                                        idorden,
                                        confirmacion
                                    )
                                VALUES
                                    (
                                        $idcruceroorden,
                                        $idcrucero, 
                                        $idorden, 
                                        '$confirmacion'
                                    )";
    
                if(!ejecuta_insert($db_postgresql, $insert)) echo $insert;
            }
        }

    // CUPONES *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: cupones';

        $mysql_cupones = $db_mysql->query("SELECT 
                                                id as idcupon,
                                                codigo as codigocupon, 
                                                porcentaje as porcentaje, 
                                                fecha_desde as fechadesde, 
                                                fecha_hasta as fechahasta, 
                                                id_status as idstatus, 
                                                ussage as disponibles, 
                                                COALESCE(created, '2021-01-01 00:00:00') as fechacreacion,
                                                COALESCE(modified, '2021-01-01 00:00:00') as fechamodificacion,
                                                acepta_familia as aceptafamiliar
                                            FROM coupons 
                                            ORDER BY id ASC");

        while ($row = $mysql_cupones->fetch_array(MYSQLI_ASSOC)) 
        {
            $cupones[] = $row;
        }

        foreach($cupones as $cupon)
        {
            echo '.';
            
            $idcupon            = $cupon['idcupon'];
            $codigocupon        = $cupon['codigocupon'];
            $porcentaje         = $cupon['porcentaje'];
            $fechadesde         = $cupon['fechadesde'].' 00:00:00';
            $fechahasta         = $cupon['fechahasta'].' 23:59:59';
            $idstatus           = $cupon['idstatus'];
            $disponibles        = $cupon['disponibles'];
            $fechacreacion      = $cupon['fechacreacion'];
            $fechamodificacion  = $cupon['fechamodificacion'];
            $aceptafamiliar     = $cupon['aceptafamiliar'];
        
            $insert     = "INSERT INTO cupones (
                                    idcupon,
                                    codigocupon,
                                    porcentaje,
                                    fechadesde,
                                    fechahasta,
                                    idstatus,
                                    disponibles,
                                    fechacreacion,
                                    fechamodificacion,
                                    aceptafamiliar
                                )
                            VALUES
                                (
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

            if(!ejecuta_insert($db_postgresql, $insert)) echo $insert;
            
        }

    // CUPONES AGENCIAS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: cuponesagencias';

        $mysql_cupones_agencias = $db_mysql->query("SELECT id_broker as idagencia, id_cupon as idcupon FROM broker_coupons ORDER BY id ASC");

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

    // CUPONES CATEGORIAS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: cuponescategorias';

        $mysql = $db_mysql->query("SELECT DISTINCT id_plan_categoria, id_cupon FROM plans_category_coupons ORDER BY id_plan_categoria ASC");

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $cuponescategorias[] = $row;
        }

        foreach($cuponescategorias as $beneficiocategoria)
        {
            echo '.';

            $idcategoria    = $beneficiocategoria['id_plan_categoria'];
            $idcupon        = $beneficiocategoria['id_cupon'];

            $insert     = "INSERT INTO cuponescategorias (
                                    idcategoria, 
                                    idcupon
                                )
                            VALUES
                                (
                                    $idcategoria, 
                                    $idcupon
                                )";

            ejecuta_insert($db_postgresql, $insert);
        }

    // CUPONES PLANES *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: cuponesplanes';

        $mysql = $db_mysql->query("SELECT DISTINCT id_plan, id_cupon FROM plans_category_coupons ORDER BY id_plan_categoria ASC");

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $cuponesplanes[] = $row;
        }

        foreach($cuponesplanes as $cuponplan)
        {
            echo '.';

            $idplan    = $cuponplan['id_plan'];
            $idcupon   = $cuponplan['id_cupon'];

            $insert     = "INSERT INTO cuponesplanes (
                                    idplan, 
                                    idcupon
                                )
                            VALUES
                                (
                                    $idplan, 
                                    $idcupon
                                )";

            ejecuta_insert($db_postgresql, $insert);
        }

    // CUPONES FUENTES *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: cuponesfuentes';

        $mysql = $db_mysql->query("SELECT target, id FROM coupons ORDER BY id ASC ");

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $cuponesfuentes[] = $row;
        }

        foreach($cuponesfuentes as $cuponfuente)
        {
            echo '.';

            $idfuente   = $cuponfuente['target'];
            $idcupon    = $cuponfuente['id_cupon'];

            $insert     = "INSERT INTO cuponesfuentes (
                                    idfuente, 
                                    idcupon
                                )
                            VALUES
                                (
                                    $idfuente, 
                                    $idcupon
                                )";

            ejecuta_insert($db_postgresql, $insert);
        }

    // PLANES *******************************************************************************************************************************************************************************
        echo 'Migrando Planes ';
        
        $mysql_plans    = $db_mysql->query("SELECT  id, 
                                                    CAST(CONVERT(name USING utf8) AS binary) as name,
                                                    activo, 
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
                                                    COALESCE(fecha_creacion, '2021-01-01 00:00:00') as fecha_creacion,
                                                    COALESCE(fecha_modificacion, '2021-01-01 00:00:00') as fecha_modificacion,
                                                    id_popularidad, 
                                                    COALESCE(max_age_ben_adic, 75) as max_age_ben_adic,
                                                    COALESCE(publico, 'false') as publico,
                                                    id_site  
                                                FROM plans 
                                                ORDER BY id ASC 
                                                ");

        while ($row = $mysql_plans->fetch_array(MYSQLI_ASSOC)) 
        {
            $plans[] = $row;
        }


        foreach($plans as $plan)
        {
            echo '.';    

            $idplan                                     = $plan['id'];
            $nombreplan                                 = $plan['name'];
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
            $fechacreacion                              = ($plan['fecha_creacion'] == '0000-00-00 00:00:00') ? '2021-01-01 00:00:00' : $plan['fecha_creacion'];
            $fechamodificacion                          = ($plan['fecha_modificacion'] == '0000-00-00 00:00:00') ? '2021-01-01 00:00:00' : $plan['fecha_modificacion'];
            $idpopularidad                              = $plan['id_popularidad'];
            $edadmaximabeneficioadic                    = $plan['max_age_ben_adic'];
            $descripcionplan                            = '';
            $descripcionplanen                          = '';
            $idtipoasistencia                           = 1;
            $fechaactualizacionprecioscostos            = '2021-01-01 00:00:00';
            $fechaactualizacionbeneficios               = '2021-01-01 00:00:00';
            $fechaactualizacionbeneficiosadicionales    = '2021-01-01 00:00:00';
            $fechaactualizacionbeneficiosproveedores    = '2021-01-01 00:00:00';
            $publico                                    = $plan['publico'];

            $idpais = $plan['id_site'];

            $insert = "INSERT INTO planes (
                                        idplan,
                                        nombreplan, 
                                        idstatus, 
                                        idcategoria, 
                                        tiempominimo, 
                                        tiempomaximo, 
                                        edadminima, 
                                        edadmaxima, 
                                        edadprecioincremento, 
                                        planfamiliar, 
                                        factorpenalizacionedad, 
                                        factorbeneficiofamiliar, 
                                        idmonedapago, 
                                        idmonedacobertura, 
                                        fechacreacion, 
                                        fechamodificacion, 
                                        idpopularidad, 
                                        edadmaximabeneficiosadic, 
                                        descripcionplan, 
                                        descripcionplanen, 
                                        idtipoasistencia, 
                                        fechaactualizacionprecioscostos, 
                                        fechaactualizacionbeneficios, 
                                        fechaactualizacionbeneficiosadicionales, 
                                        fechaactualizacionbeneficiosproveedores, 
                                        publico)
                                    VALUES(
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
                                        '$publico' 
                                        )";

            if(ejecuta_insert($db_postgresql, $insert))
            {
                $mysql_precios  = array();
                $precios        = array();

                // PRECIOS
                    $mysql_precios = $db_mysql->query("SELECT * FROM precios WHERE id_plan = '$idplan' ORDER BY id ASC");

                    while ($row_precio = $mysql_precios->fetch_array(MYSQLI_ASSOC)) 
                    { 
                        $precios[] = $row_precio; 
                    }

                    if(count($precios) > 0)
                    {
                        foreach($precios as $precio)
                        {    
                            $dia        = $precio['dias'];
                            $precio     = $precio['precio'];
                            $costo1     = isset($precio['costo1']) ? $precio['costo1'] : 0;
                            $costo2     = isset($precio['costo2']) ? $precio['costo2'] : 0;
        
                            $insert     = "INSERT INTO planesprecios (
                                                            idplan, 
                                                            dia, 
                                                            precio, 
                                                            idpais, 
                                                            fechaactualizacion
                                                        )
                                                    VALUES
                                                        (
                                                            $idplan, 
                                                            $dia, 
                                                            $precio, 
                                                            $idpais, 
                                                            '2021-01-01 00:00:00'
                                                        )";
        
                            ejecuta_insert($db_postgresql, $insert);

                            if($costo1 > 0)
                            {
                                $insert = "INSERT INTO planescostos
                                                        (
                                                            idplan, 
                                                            idproveedor, 
                                                            dia, 
                                                            costo, 
                                                            idpais, 
                                                            fechaactualizacion
                                                        )
                                                VALUES
                                                    (
                                                        $idplan, 
                                                        1, 
                                                        $dia, 
                                                        $costo1, 
                                                        $idpais, 
                                                        '2021-01-01 00:00:00'
                                                    );";
        
                                ejecuta_insert($db_postgresql, $insert);
                            }

                            if($costo2 > 0)
                            {
                                $insert = "INSERT INTO planescostos
                                                        (
                                                            idplan, 
                                                            idproveedor, 
                                                            dia, 
                                                            costo, 
                                                            idpais, 
                                                            fechaactualizacion
                                                        )
                                                VALUES
                                                    (
                                                        $idplan, 
                                                        6, 
                                                        $dia, 
                                                        $costo2, 
                                                        $idpais, 
                                                        '2021-01-01 00:00:00'
                                                    );";
                                                    
                                ejecuta_insert($db_postgresql, $insert);
                            }
                        }
                    }
            }
            else
            {
                echo 'El plan '.$idplan.' ha tenido un problema para ser migrado';
            }
        }

    // PLANES AGENCIAS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: Planes Agencias';

        $mysql_planes_agencias = $db_mysql->query("SELECT DISTINCT producto, agencia FROM orders ORDER BY producto ASC");

        while ($row = $mysql_planes_agencias->fetch_array(MYSQLI_ASSOC)) 
        {
            $planes_agencias[] = $row;
        }

        foreach($planes_agencias as $plan_agencia)
        {
            echo '.';

            $idplan     = $plan_agencia['producto'];
            $idagencia  = $plan_agencia['agencia'];

            $insert     = "INSERT INTO planesagencias (
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

    // PLANES BENEFICIOS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: Planes Beneficios';

        $mysql_planes_beneficios = $db_mysql->query("SELECT DISTINCT producto, agencia FROM orders ORDER BY producto");

        while ($row = $mysql_planes_beneficios->fetch_array(MYSQLI_ASSOC)) 
        {
            $planes_beneficios[] = $row;
        }

        foreach($planes_beneficios as $plan_beneficio)
        {
            echo '.';

            $idplan     = $plan_beneficio['producto'];
            $idagencia  = $plan_beneficio['agencia'];

            $insert     = "INSERT INTO planesagencias (
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

    $planes = ejecuta_select($db_postgresql, "SELECT * FROM planes");

    echo $planes['cantidad'].' Planes migrados exitosamente !';
    echo 'Proceso Finalizado Exitosamente !'; 
?>
