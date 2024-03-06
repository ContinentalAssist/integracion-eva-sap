<?php 
    include('./lib/funciones.php');
    include('./lib/mysql.php');
    include('./lib/pgsql.php');

    $db_postgresql      = getDB();
    $db_mysql           = connect_db();

    $hora_inicio = date('h:i:s', time());

    $limpiar_tablas = true;

    if($limpiar_tablas)
    {
        /*** CUIDADO, SOLO INCLUIR $db_postgresql ***********************************************************/
        /**/ 
        /**/ 
        // echo 'Borrando cuponesagencias...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE cuponesagencias CASCADE");

        // echo 'Borrando cuponesplanes...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE cuponesplanes CASCADE");

        // echo 'Borrando cuponesfuentes...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE cuponesfuentes CASCADE");

        // echo 'Borrando cuponescategorias...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE cuponescategorias CASCADE");

        // echo 'Borrando categoriasagencias...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE categoriasagencias CASCADE");

        // echo 'Borrando planesbeneficios...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficios CASCADE");

        // echo 'Borrando planesbeneficiosproveedores...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficiosproveedores CASCADE");

        // echo 'Borrando planesbeneficiosadicionales...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficiosadicionales CASCADE");

        // echo 'Borrando planesbeneficiosadicionalesproveedores...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficiosadicionalesproveedores CASCADE");

        // echo 'Borrando planesprecios...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesprecios CASCADE");

        // echo 'Borrando planescostos...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE planescostos CASCADE");

        // echo 'Borrando planesagencias...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesagencias CASCADE");

        // echo 'Borrando planespaises...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE planespaises CASCADE");

        // echo 'Borrando planesfuentes...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesfuentes CASCADE");

        // echo 'Borrando planesorigenes...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesorigenes CASCADE");

        // echo 'Borrando planesdestinos...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesdestinos CASCADE");

        // echo 'Borrando beneficioscategorias...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE beneficioscategorias CASCADE");

        // echo 'Borrando categoriasfuentes...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE categoriasfuentes CASCADE");

        // echo 'Borrando categoriasorigenes...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE categoriasorigenes CASCADE");

        // echo 'Borrando categoriaspaises...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE categoriaspaises CASCADE");

        // echo 'Borrando categoriasdestinos...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE categoriasdestinos CASCADE");

        //         echo 'Borrando crucerosordenes...';
        //         ejecuta_delete($db_postgresql, "TRUNCATE TABLE crucerosordenes CASCADE");

        echo 'Borrando auditorias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE auditorias CASCADE");

        // echo 'Borrando beneficios...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE beneficios CASCADE");

        //         echo 'Borrando beneficiarioscostos...';
        //         ejecuta_delete($db_postgresql, "TRUNCATE TABLE beneficiarioscostos CASCADE");

        //         echo 'Borrando beneficiariosbeneficiosadicionales...';
        //         ejecuta_delete($db_postgresql, "TRUNCATE TABLE beneficiariosbeneficiosadicionales CASCADE");

        //         echo 'Borrando beneficiarios...';
        //         ejecuta_delete($db_postgresql, "TRUNCATE TABLE beneficiarios CASCADE");

        //         echo 'Borrando asistenciascorporativas...';
        //         ejecuta_delete($db_postgresql, "TRUNCATE TABLE asistenciascorporativas CASCADE");

        //         echo 'Borrando asistenciascorporativasviajes...';
        //         ejecuta_delete($db_postgresql, "TRUNCATE TABLE asistenciascorporativasviajes CASCADE");

        //         echo 'Borrando asistenciasviajes...';
        //         ejecuta_delete($db_postgresql, "TRUNCATE TABLE asistenciasviajes CASCADE");

        // echo 'Borrando categorias...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE categorias CASCADE");

        // echo 'Borrando cruceros...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE cruceros CASCADE");

        // echo 'Borrando cupones...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE cupones CASCADE");

        // echo 'Borrando planes...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE planes CASCADE");

        echo 'Borrando usuarios...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE usuarios CASCADE");

        // echo 'Borrando agencias...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE agencias CASCADE");

        // echo 'Borrando comisionesagencias...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE comisionesagencias CASCADE");

        //         echo 'Borrando precompras...';
        //         ejecuta_delete($db_postgresql, "TRUNCATE TABLE precompras CASCADE");

        // echo 'Borrando corporativos...';
        // ejecuta_delete($db_postgresql, "TRUNCATE TABLE corporativos CASCADE");

        //         echo 'Borrando ordenescomisiones...';
        //         ejecuta_delete($db_postgresql, "TRUNCATE TABLE ordenescomisiones CASCADE");

        //         echo 'Borrando ordenescontactos...';
        //         ejecuta_delete($db_postgresql, "TRUNCATE TABLE ordenescontactos CASCADE");

        //         echo 'Borrando ordenes...';
        //         ejecuta_delete($db_postgresql, "TRUNCATE TABLE ordenes CASCADE");
    
    
    
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE auditorias_idauditoria_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE usuarios_idusuario_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE agencias_idagencia_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficios_idbeneficio_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficioscategorias_idbeneficiocategoria_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categorias_idcategoria_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriasagencias_idcategoriaagencia_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriasdestinos_idcategoriadestino_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriasfuentes_idcategoriafuente_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriasorigenes_idcategoriaorigen_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriaspaises_idcategoriapais_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cruceros_idcrucero_seq RESTART WITH 1");
        //         /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE crucerosordenes_idcruceroorden_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cupones_idcupon_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cuponesfuentes_idcuponfuente_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cuponesagencias_idcuponagencia_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cuponesplanes_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cuponescategorias_idcuponcategoria_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planes_idplan_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesprecios_idplanprecio_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planescostos_idplancosto_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesagencias_idplanesagencias_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesbeneficios_idplanbeneficio_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesbeneficiosadicionales_idplanbeneficioadicional_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesbeneficiosadicionalesproveedores_idplanbeneficioadicionalproveedor_seq RESTART WITH 1");
        //         /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficiarioscostos_idbeneficiariocosto_seq RESTART WITH 1");
        //         /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficiariosbeneficiosadicio_idbeneficiariobeneficioadicio_seq RESTART WITH 1");
        //         /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficiarios_idbeneficiario_seq RESTART WITH 1");
        //         /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE asistenciasviajes_idasistenciaviaje_seq RESTART WITH 1");
        //         /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE precompra_idprecompra_seq RESTART WITH 1");
        //         /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE ordenes_idorden_seq RESTART WITH 1");
        //         /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE ordenescomisiones_idordencomision_seq RESTART WITH 1");
        //         /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE ordenescontactos_idordencontacto_seq RESTART WITH 1");
        //         /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE asistenciascorporativasviajes_idasistenciacorporativaviaje_seq RESTART WITH 1");
        //         /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE asistenciascorporativas_idasistenciacorporativa_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE corporativos_idcorporativo_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planespaises_idplanpais_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesfuentes_idplanfuente_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesorigenes_idplanorigen_seq RESTART WITH 1");
        // /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesdestinos_idplandestino_seq RESTART WITH 1");
    }
    
    // // AGENCIAS *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: agencias';
        
    //     $mysql    = $db_mysql->query("SELECT 
    //                                     broker.id_broker as idagencia,
    //                                     IF(id_cia = 0, 1, id_cia) as idsistema,
    //                                     UPPER(CAST(CONVERT(broker USING utf8) AS binary)) as nombreagencia,
    //                                     id_status as idstatus,
    //                                     broker.nivel as idnivel,
    //                                     id_site as idpais,
    //                                     CAST(CONVERT(phone1 USING utf8) AS binary) as telefono1,
    //                                     CAST(CONVERT(phone2 USING utf8) AS binary) as telefono2,
    //                                     CAST(CONVERT(phone3 USING utf8) AS binary) as telefono3,
    //                                     CAST(CONVERT(address USING utf8) AS binary) as direccion,
    //                                     date_up as fechacreacion,
    //                                     IF(account_manager = 0 OR account_manager IS NULL, 1076, account_manager) as idagente,
    //                                     img_broker as logoagencia,
    //                                     COALESCE(credito_base, 0) as creditobase,
    //                                     COALESCE(credito_actual, 0) as creditoactual,
    //                                     ver_precio as verprecio,
    //                                     solo_inclusion as versoloinclusion,
    //                                     multipais as multipais,
    //                                     CAST(CONVERT(banco USING utf8) AS binary) as banco,
    //                                     CAST(CONVERT(clabe_inter USING utf8) AS binary) as clabeinterbancaria,
    //                                     CAST(CONVERT(cuenta USING utf8) AS binary) as cuenta,
    //                                     UPPER(CAST(CONVERT(beneficiario USING utf8) AS binary)) as beneficiario,
    //                                     COALESCE(broker_nivel.parent, 0) as idagenciapadre,
    //                                     reporta as idagenciareporta,
    //                                     CAST(CONVERT(razon USING utf8) AS binary) as razonsocial,
    //                                     CAST(CONVERT(tax_id USING utf8) AS binary) as identificadortributaria,
    //                                     CAST(CONVERT(id_city USING utf8) AS binary) as ciudad,
    //                                     CAST(CONVERT(id_state USING utf8) AS binary) as estado,
    //                                     CAST(CONVERT(observations USING utf8) AS binary) as comentario,
    //                                     'CA' as acronimovoucher
    //                                 FROM broker
    //                                 LEFT join broker_nivel on broker.id_broker = broker_nivel.id_broker
    //                                 ORDER BY broker.id_broker ASC
    //                                 ");

    //     while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $registros[] = $row;
    //     }

    //     foreach($registros as $registro)
    //     {
    //         echo '.';    

    //         $idagencia                  = $registro['idagencia'];
    //         $idsistema                  = $registro['idsistema'];
    //         $nombreagencia              = $registro['nombreagencia'];
    //         $idstatus                   = $registro['idstatus'];
    //         $idnivel                    = $registro['idnivel'];
    //         $idpais                     = $registro['idpais'];
    //         $telefono1                  = $registro['telefono1'];
    //         $telefono2                  = $registro['telefono2'];
    //         $telefono3                  = $registro['telefono3'];
    //         $direccion                  = $registro['direccion'];
    //         $fechacreacion              = $registro['fechacreacion'];
    //         $idagente                   = $registro['idagente'];
    //         $logoagencia                = $registro['logoagencia'];
    //         $creditobase                = $registro['creditobase'];
    //         $creditoactual              = $registro['creditoactual'];
    //         $verprecio                  = $registro['verprecio'];
    //         $versoloinclusion           = $registro['versoloinclusion'];
    //         $multipais                  = $registro['multipais'];
    //         $banco                      = $registro['banco'];
    //         $clabeinterbancaria         = $registro['clabeinterbancaria'];
    //         $cuenta                     = $registro['cuenta'];
    //         $beneficiario               = $registro['beneficiario'];
    //         $idagenciapadre             = $registro['idagenciapadre'];
    //         $idagenciareporta           = $registro['idagenciareporta'];
    //         $razonsocial                = $registro['razonsocial'];
    //         $identificadortributaria    = $registro['identificadortributaria'];
    //         $ciudad                     = $registro['ciudad'];
    //         $estado                     = $registro['estado'];
    //         $comentario                 = $registro['comentario'];
    //         $acronimovoucher            = $registro['acronimovoucher'];

    //         $insert = "INSERT INTO agencias (
    //                                     idagencia,
    //                                     idsistema,
    //                                     nombreagencia,
    //                                     idstatus,
    //                                     idnivel,
    //                                     idpais,
    //                                     telefono1,
    //                                     telefono2,
    //                                     telefono3,
    //                                     direccion,
    //                                     fechacreacion,
    //                                     idagente,
    //                                     logoagencia,
    //                                     creditobase,
    //                                     creditoactual,
    //                                     verprecio,
    //                                     versoloinclusion,
    //                                     multipais,
    //                                     banco,
    //                                     clabeinterbancaria,
    //                                     cuenta,
    //                                     beneficiario,
    //                                     idagenciapadre,
    //                                     idagenciareporta,
    //                                     razonsocial,
    //                                     identificadortributaria,
    //                                     ciudad,
    //                                     estado,
    //                                     comentario,
    //                                     acronimovoucher
    //                                     )
    //                                 VALUES(
    //                                     $idagencia,
    //                                     $idsistema,
    //                                     UPPER('$nombreagencia'),
    //                                     $idstatus,
    //                                     $idnivel,
    //                                     $idpais,
    //                                     '$telefono1',
    //                                     '$telefono2',
    //                                     '$telefono3',
    //                                     '$direccion',
    //                                     '$fechacreacion',
    //                                     $idagente,
    //                                     CONCAT('https://storage.googleapis.com/files-continentalassist-backend/Agencias/','$logoagencia'),
    //                                     $creditobase,
    //                                     $creditoactual,
    //                                     '$verprecio',
    //                                     '$versoloinclusion',
    //                                     '$multipais',
    //                                     '$banco',
    //                                     '$clabeinterbancaria',
    //                                     '$cuenta',
    //                                     UPPER('$beneficiario'),
    //                                     $idagenciapadre,
    //                                     $idagenciareporta,
    //                                     '$razonsocial',
    //                                     '$identificadortributaria',
    //                                     UPPER('$ciudad'),
    //                                     UPPER('$estado'),
    //                                     '$comentario',
    //                                     '$acronimovoucher'
    //                                 )";

    //         if(!ejecuta_insert($db_postgresql, $insert)) {echo $insert;}
    //     }

    // //SECUENCIA AGENCIAS
    //     $secuencia = $idagencia + 1;
    //     $secuencia = "ALTER SEQUENCE agencias_idagencia_seq RESTART WITH ".$secuencia; 
    //     ejecuta_select($db_postgresql, $secuencia);

    // // BENEFICIOS *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: beneficios';

    //     $mysql_beneficios = $db_mysql->query("SELECT 
    //                                                 id_beneficio as idbeneficio, 
    //                                                 CAST(CONVERT(name USING utf8) AS binary) as nombrebeneficio,
    //                                                 COALESCE(id_status, 'false') as idstatus,
    //                                                 '2000-01-01 00:00:00' as fechacreacion,
    //                                                 '2000-01-01 00:00:00' as fechamodificacion,
    //                                                 min_age as edadminima,
    //                                                 max_age as edadmaxima,
    //                                                 CAST(CONVERT(descripcion USING utf8) AS binary) as descripcionbeneficio,
    //                                                 COALESCE(id_fam, 0) as idfamilia,
    //                                                 1 as idtipoasistencia
    //                                             FROM beneficios 
    //                                             WHERE language_id = 'spa'
    //                                             ORDER BY id_beneficio ASC");

    //     while ($row = $mysql_beneficios->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $beneficios_spa[] = $row;
    //     }

    //     foreach($beneficios_spa as $beneficio)
    //     {
    //         echo '.';

    //         $idbeneficio            = $beneficio['idbeneficio']; 
    //         $nombrebeneficio        = $beneficio['nombrebeneficio']; 
    //         $idstatus               = $beneficio['idstatus']; 
    //         $fechacreacion          = $beneficio['fechacreacion']; 
    //         $fechamodificacion      = $beneficio['fechamodificacion']; 
    //         $edadminima             = $beneficio['edadminima']; 
    //         $edadmaxima             = $beneficio['edadmaxima']; 
    //         $descripcionbeneficio   = $beneficio['descripcionbeneficio']; 
    //         $idfamilia              = $beneficio['idfamilia']; 
    //         $idtipoasistencia       = $beneficio['idtipoasistencia']; 

    //         $insert     = "INSERT INTO beneficios (
    //                                 idbeneficio,
    //                                 nombrebeneficio,
    //                                 idstatus,
    //                                 fechacreacion,
    //                                 fechamodificacion,
    //                                 edadminima,
    //                                 edadmaxima,
    //                                 descripcionbeneficio,
    //                                 idfamilia,
    //                                 idtipoasistencia
    //                             )
    //                         VALUES
    //                             (
    //                                 $idbeneficio,
    //                                 '$nombrebeneficio',
    //                                 $idstatus,
    //                                 '$fechacreacion',
    //                                 '$fechamodificacion',
    //                                 $edadminima,
    //                                 $edadmaxima,
    //                                 '$descripcionbeneficio',
    //                                 $idfamilia,
    //                                 $idtipoasistencia
    //                             )";

    //         ejecuta_insert($db_postgresql, $insert);
    //     }

    //     $mysql_beneficios = $db_mysql->query("SELECT 
    //                                                 id_beneficio as idbeneficio, 
    //                                                 CAST(CONVERT(name USING utf8) AS binary) as nombrebeneficio,
    //                                                 CAST(CONVERT(descripcion USING utf8) AS binary) as descripcionbeneficio
    //                                             FROM beneficios 
    //                                             WHERE language_id = 'eng'
    //                                             ORDER BY id_beneficio ASC");

    //     while ($row = $mysql_beneficios->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $beneficios_eng[] = $row;
    //     }

    //     foreach($beneficios_eng as $beneficio)
    //     {
    //         echo '.';
    //         $idbeneficio            = $beneficio['idbeneficio'];
    //         $nombrebeneficio        = $beneficio['nombrebeneficio'];
    //         $descripcionbeneficio   = $beneficio['descripcionbeneficio'];

    //         $update = "UPDATE beneficios SET nombrebeneficioen = '$nombrebeneficio', descripcionbeneficioen = '$descripcionbeneficio' WHERE  idbeneficio = $idbeneficio ";
    //         ejecuta_update($db_postgresql, $update);
    //     }

    //     $secuencia = $idbeneficio + 1;
    //     $secuencia = "ALTER SEQUENCE beneficios_idbeneficio_seq1 RESTART WITH ".$secuencia; 
    //     ejecuta_select($db_postgresql, $secuencia);

    

    // //CATEGORIAS *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: categorias';

    //     $mysql_categorias = $db_mysql->query("SELECT 
    //                                                     id_plan_categoria as idcategoria, 
    //                                                     name_plan as nombrecategoria,
    //                                                     1 as idstatus,
    //                                                     '' as nombrecategoriaen,
    //                                                     CAST(CONVERT(description_plan USING utf8) AS binary) as descripcioncategoria,
    //                                                     '' as descripcioncategoriaen,
    //                                                     moneda as moneda,
    //                                                     min_time as tiempominimo,
    //                                                     max_time as tiempomaximo,
    //                                                     min_age as edadminima,
    //                                                     max_age as edadmaxima,
    //                                                     true as planfamiliar
    //                                                 FROM plan_categoria_detail
    //                                                 WHERE language_id = 'spa'
    //                                                 ");

    //     while ($row = $mysql_categorias->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $categorias[] = $row;
    //     }

    //     foreach($categorias as $categoria)
    //     {
    //         echo '.';

    //         $idcategoria                = $categoria['idcategoria']; 
    //         $nombrecategoria            = $categoria['nombrecategoria']; 
    //         $idstatus                   = $categoria['idstatus']; 
    //         $nombrecategoriaen          = $categoria['nombrecategoriaen']; 
    //         $descripcioncategoria       = $categoria['descripcioncategoria']; 
    //         $descripcioncategoriaen     = $categoria['descripcioncategoriaen']; 
    //         $monedacategoria            = $categoria['moneda']; 
    //         $idmoneda                   = ejecuta_select($db_postgresql, "SELECT idmoneda FROM monedas WHERE codigo = '$monedacategoria'",'idmoneda');
    //         $tiempominimo               = $categoria['tiempominimo']; 
    //         $tiempomaximo               = $categoria['tiempomaximo']; 
    //         $edadminima                 = $categoria['edadminima']; 
    //         $edadmaxima                 = $categoria['edadmaxima']; 
    //         $planfamiliar               = $categoria['planfamiliar']; 

    //         $insert     = "INSERT INTO categorias (
    //                                     idcategoria,
    //                                     nombrecategoria,
    //                                     idstatus,
    //                                     nombrecategoriaen,
    //                                     descripcioncategoria,
    //                                     descripcioncategoriaen,
    //                                     idmoneda,
    //                                     tiempominimo,
    //                                     tiempomaximo,
    //                                     edadminima,
    //                                     edadmaxima,
    //                                     planfamiliar
    //                                 )
    //                             VALUES
    //                                 (
    //                                     $idcategoria,
    //                                     '$nombrecategoria',
    //                                     $idstatus,
    //                                     '$nombrecategoriaen',
    //                                     '$descripcioncategoria',
    //                                     '$descripcioncategoriaen',
    //                                     $idmoneda,
    //                                     $tiempominimo,
    //                                     $tiempomaximo,
    //                                     $edadminima,
    //                                     $edadmaxima,
    //                                     '$planfamiliar'
    //                             )";

    //         if(!ejecuta_insert($db_postgresql, $insert)) echo $insert;
    //     }

    //     $mysql_categorias = $db_mysql->query("SELECT 
    //                                                     id_plan_categoria as idcategoria, 
    //                                                     name_plan as nombrecategoria,
    //                                                     CAST(CONVERT(description_plan USING utf8) AS binary) as descripcioncategoria
    //                                                 FROM plan_categoria_detail
    //                                                 WHERE language_id = 'eng'
    //                                                 ");

    //     while ($row = $mysql_categorias->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $categorias[] = $row;
    //     }

    //     foreach($categorias as $categoria)
    //     {   
    //         $idcategoria            = $categoria['idcategoria'];
    //         $nombrecategoriaen      = $categoria['nombrecategoria'];
    //         $descripcioncategoriaen = $categoria['descripcioncategoria'];


    //         $update = "UPDATE categorias SET nombrecategoriaen = '$nombrecategoriaen', descripcioncategoriaen = '$descripcioncategoriaen' WHERE  idcategoria = $idcategoria ";
            
    //         if(!ejecuta_update($db_postgresql, $update)) echo $update;
    //     }

    //     $secuencia = $idcategoria + 1;
    //     $secuencia = "ALTER SEQUENCE categorias_idcategoria_seq1 RESTART WITH ".$secuencia; 
    //     ejecuta_select($db_postgresql, $secuencia);

    // // BENEFICIOS CATEGORIAS *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: beneficioscategorias';

    //     $mysql = $db_mysql->query("SELECT DISTINCT id_categoria, id_beneficio FROM beneficios_costo ORDER BY id_categoria ASC");

    //     while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $beneficioscategorias[] = $row;
    //     }

    //     foreach($beneficioscategorias as $beneficiocategoria)
    //     {
    //         echo '.';

    //         $idcategoria    = $beneficiocategoria['id_categoria'];
    //         $idbeneficio    = $beneficiocategoria['id_beneficio'];

    //         $insert     = "INSERT INTO beneficioscategorias (
    //                                 idcategoria, 
    //                                 idbeneficio
    //                             )
    //                         VALUES
    //                             (
    //                                 $idcategoria, 
    //                                 $idbeneficio
    //                             )";

    //         ejecuta_insert($db_postgresql, $insert);
    //     }


    // // CATEGORIAS AGENCIAS *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: categoriasagencias';

    //     $mysql_categorias_agencias = $db_mysql->query("SELECT DISTINCT COALESCE(programaplan, 0) as programaplan, agencia FROM orders ORDER BY programaplan ASC");

    //     while ($row = $mysql_categorias_agencias->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $categorias_agencias[] = $row;
    //     }

    //     foreach($categorias_agencias as $categoria_agencia)
    //     {
    //         echo '.';
            
    //         $idcategoria    = $categoria_agencia['programaplan'];
    //         $idagencia      = $categoria_agencia['agencia'];

    //         $select = "SELECT idagencia FROM agencias WHERE idagencia = $idagencia";
    //         $select_agencia = ejecuta_select($db_postgresql, $select);

    //         if($select_agencia['cantidad'] > 0 && $idcategoria != null && $idcategoria != 0)
    //         {
    //             $insert     = "INSERT INTO categoriasagencias (
    //                                     idcategoria, 
    //                                     idagencia
    //                                 )
    //                             VALUES
    //                                 (
    //                                     $idcategoria, 
    //                                     $idagencia
    //                                 )";
    
    //             if(!ejecuta_insert($db_postgresql, $insert)) echo $insert;
    //         }
    //     }

    // // CATEGORIAS DESTINOS *******************************************************************************************************************************************************************************
    //     $categorias = ejecuta_select($db_postgresql, "SELECT  idcategoria FROM categorias ORDER BY idcategoria ASC ");
    //     $paises     = ejecuta_select($db_postgresql, "SELECT  idpais FROM paises ORDER BY idpais ASC ");

    //     echo 'Migrando Tabla: categoriasdestinos';

    //     foreach($categorias['resultado'] as $categoria)
    //     {
    //         $idcategoria = $categoria['idcategoria'];

    //         foreach($paises['resultado'] as $pais)
    //         {
    //             echo '.';    

    //             $idpais = $pais['idpais'];

    //             $insert = "INSERT INTO categoriasdestinos(idcategoria, idpais) VALUES ($idcategoria, $idpais)";
                
    //             if(!ejecuta_insert($db_postgresql, $insert))
    //             {
    //                 echo $insert;
    //                 // exit;
    //             }
    //         }
    //     }

    // // CATEGORIAS FUENTES *******************************************************************************************************************************************************************************
    //     $categorias = ejecuta_select($db_postgresql, "SELECT  idcategoria FROM categorias ORDER BY idcategoria ASC ");
    //     $fuentes    = ejecuta_select($db_postgresql, "SELECT  idfuente FROM fuentes ORDER BY idfuente ASC ");

    //     echo 'Migrando Tabla: categoriasfuentes';

    //     foreach($categorias['resultado'] as $categoria)
    //     {
    //         $idcategoria = $categoria['idcategoria'];

    //         foreach($fuentes['resultado'] as $fuente)
    //         {
    //             echo '.';    

    //             $idfuente = $fuente['idfuente'];

    //             $insert = "INSERT INTO categoriasfuentes(idcategoria, idfuente) VALUES ($idcategoria, $idfuente)";
                
    //             if(!ejecuta_insert($db_postgresql, $insert))
    //             {
    //                 echo $insert;
    //                 // exit;
    //             }
    //         }
    //     }

    // // CATEGORIAS ORIGEN *******************************************************************************************************************************************************************************
    //     $categorias = ejecuta_select($db_postgresql, "SELECT  idcategoria FROM categorias ORDER BY idcategoria ASC ");
    //     $paises     = ejecuta_select($db_postgresql, "SELECT  idpais FROM paises ORDER BY idpais ASC ");

    //     echo 'Migrando Tabla: categoriasorigenes';

    //     foreach($categorias['resultado'] as $categoria)
    //     {
    //         $idcategoria = $categoria['idcategoria'];

    //         foreach($paises['resultado'] as $pais)
    //         {
    //             echo '.';    

    //             $idpais = $pais['idpais'];

    //             $insert = "INSERT INTO categoriasorigenes(idcategoria, idpais) VALUES ($idcategoria, $idpais)";
                
    //             if(!ejecuta_insert($db_postgresql, $insert))
    //             {
    //                 echo $insert;
    //                 // exit;
    //             }
    //         }
    //     }

    // // CATEGORIAS PAISES *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: categoriaspaises';

    //     $mysql_categorias_paises = $db_mysql->query("SELECT DISTINCT id_site, id_category FROM category_site ORDER BY id_site ASC");

    //     while ($row = $mysql_categorias_paises->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $categorias_paises[] = $row;
    //     }

    //     foreach($categorias_paises as $categoria_pais)
    //     {
    //         echo '.';
            
    //         $idpais         = $categoria_pais['id_site'];
    //         $idcategoria    = $categoria_pais['id_category'];

    //         if($idcategoria != null && $idcategoria != 0)
    //         {
    //             $insert     = "INSERT INTO categoriaspaises (
    //                                     idcategoria, 
    //                                     idpais
    //                                 )
    //                             VALUES
    //                                 (
    //                                     $idcategoria, 
    //                                     $idpais
    //                                 )";

    //             if(!ejecuta_insert($db_postgresql, $insert)) echo $insert;
    //         }
    //     }

    // // CRUCEROS *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: cruceros';

    //     $mysql_cruceros = $db_mysql->query("SELECT id, CAST(CONVERT(crucero USING utf8) AS binary) as crucero, status FROM cruiseline ORDER BY id ASC");

    //     while ($row = $mysql_cruceros->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $cruceros[] = $row;
    //     }

    //     foreach($cruceros as $crucero)
    //     {
    //         echo '.';
            
    //         $idcrucero      = $crucero['id'];
    //         $nombrecrucero  = $crucero['crucero'];
    //         $idstatus       = $crucero['status'];
           
    //         $insert     = "INSERT INTO cruceros (
    //                                 idcrucero, 
    //                                 nombrecrucero,
    //                                 idstatus
    //                             )
    //                         VALUES
    //                             (
    //                                 $idcrucero, 
    //                                 '$nombrecrucero',
    //                                 $idstatus
    //                             )";

    //         if(!ejecuta_insert($db_postgresql, $insert)) echo $insert;
    //     }

    //     $secuencia = $idcrucero + 1;
    //     $secuencia = "ALTER SEQUENCE cruceros_idcrucero_seq RESTART WITH ".$secuencia; 
    //     ejecuta_select($db_postgresql, $secuencia);


    

    // // CUPONES *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: cupones';

    //     $mysql_cupones = $db_mysql->query("SELECT 
    //                                             id as idcupon,
    //                                             codigo as codigocupon, 
    //                                             porcentaje as porcentaje, 
    //                                             fecha_desde as fechadesde, 
    //                                             fecha_hasta as fechahasta, 
    //                                             id_status as idstatus, 
    //                                             ussage as disponibles, 
    //                                             COALESCE(created, '2000-01-01 00:00:00') as fechacreacion,
    //                                             COALESCE(modified, '2000-01-01 00:00:00') as fechamodificacion,
    //                                             acepta_familia as aceptafamiliar
    //                                         FROM coupons 
    //                                         ORDER BY id ASC");

    //     while ($row = $mysql_cupones->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $cupones[] = $row;
    //     }

    //     foreach($cupones as $cupon)
    //     {
    //         echo '.';
            
    //         $idcupon            = $cupon['idcupon'];
    //         $codigocupon        = $cupon['codigocupon'];
    //         $porcentaje         = $cupon['porcentaje'];
    //         $fechadesde         = $cupon['fechadesde'].' 00:00:00';
    //         $fechahasta         = $cupon['fechahasta'].' 23:59:59';
    //         $idstatus           = $cupon['idstatus'];
    //         $disponibles        = $cupon['disponibles'];
    //         $fechacreacion      = $cupon['fechacreacion'];
    //         $fechamodificacion  = $cupon['fechamodificacion'];
    //         $aceptafamiliar     = $cupon['aceptafamiliar'];
        
    //         $insert     = "INSERT INTO cupones (
    //                                 idcupon,
    //                                 codigocupon,
    //                                 porcentaje,
    //                                 fechadesde,
    //                                 fechahasta,
    //                                 idstatus,
    //                                 disponibles,
    //                                 fechacreacion,
    //                                 fechamodificacion,
    //                                 aceptafamiliar
    //                             )
    //                         VALUES
    //                             (
    //                                 $idcupon,
    //                                 UPPER('$codigocupon'),
    //                                 $porcentaje,
    //                                 '$fechadesde',
    //                                 '$fechahasta',
    //                                 $idstatus,
    //                                 $disponibles,
    //                                 '$fechacreacion',
    //                                 '$fechamodificacion',
    //                                 '$aceptafamiliar'
    //                             )";

    //         if(!ejecuta_insert($db_postgresql, $insert)) echo $insert;
            
    //     }

    //     $secuencia = $idcupon + 1;
    //     $secuencia = "ALTER SEQUENCE cupones_idcupon_seq RESTART WITH ".$secuencia; 
    //     ejecuta_select($db_postgresql, $secuencia);

    // // CUPONES AGENCIAS *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: cuponesagencias';

    //     $mysql_cupones_agencias = $db_mysql->query("SELECT id_broker as idagencia, id_cupon as idcupon FROM broker_coupons ORDER BY id ASC");

    //     while ($row = $mysql_cupones_agencias->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $cupones_agencias[] = $row;
    //     }

    //     foreach($cupones_agencias as $cupon_agencia)
    //     {
    //         echo '.';
            
    //         $idagencia = $cupon_agencia['idagencia'];
    //         $idcupon   = $cupon_agencia['idcupon'];
            
    //         $insert     = "INSERT INTO cuponesagencias (
    //                                 idagencia,
    //                                 idcupon
    //                             )
    //                         VALUES
    //                             (
    //                                 $idagencia,
    //                                 $idcupon
    //                             )";

    //         if(!ejecuta_insert($db_postgresql, $insert)) echo $insert;
    //     }

    // // CUPONES CATEGORIAS *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: cuponescategorias';

    //     $mysql = $db_mysql->query("SELECT DISTINCT id_plan_categoria, id_cupon FROM plans_category_coupons ORDER BY id_plan_categoria ASC");

    //     while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $cuponescategorias[] = $row;
    //     }

    //     foreach($cuponescategorias as $beneficiocategoria)
    //     {
    //         echo '.';

    //         $idcategoria    = $beneficiocategoria['id_plan_categoria'];
    //         $idcupon        = $beneficiocategoria['id_cupon'];

    //         $insert     = "INSERT INTO cuponescategorias (
    //                                 idcategoria, 
    //                                 idcupon
    //                             )
    //                         VALUES
    //                             (
    //                                 $idcategoria, 
    //                                 $idcupon
    //                             )";

    //         ejecuta_insert($db_postgresql, $insert);
    //     }

    // // CUPONES FUENTES *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: cuponesfuentes';

    //     $mysql = $db_mysql->query("SELECT target, id FROM coupons ORDER BY id ASC ");

    //     while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $cuponesfuentes[] = $row;
    //     }

    //     foreach($cuponesfuentes as $cuponfuente)
    //     {
    //         echo '.';

    //         $idfuente   = $cuponfuente['target'] == 0 ? 1 : 2;
    //         $idcupon    = $cuponfuente['id'];

    //         $insert     = "INSERT INTO cuponesfuentes (
    //                                 idfuente, 
    //                                 idcupon
    //                             )
    //                         VALUES
    //                             (
    //                                 $idfuente, 
    //                                 $idcupon
    //                             )";

    //         ejecuta_insert($db_postgresql, $insert);
    //     }

    // // PLANES *******************************************************************************************************************************************************************************
    //     echo 'Migrando Planes ';
        
    //     $mysql_plans    = $db_mysql->query("SELECT  id, 
    //                                                 CAST(CONVERT(name USING utf8) AS binary) as name,
    //                                                 IF(activo != 1, 2, 1) as activo, 
    //                                                 id_plan_categoria, 
    //                                                 COALESCE(min_tiempo, 1) as min_tiempo,
    //                                                 COALESCE(max_tiempo, 365) as max_tiempo,
    //                                                 COALESCE(min_age, 0) as min_age,
    //                                                 COALESCE(max_age, 99) as max_age,
    //                                                 COALESCE(normal_age, 71) as normal_age,
    //                                                 COALESCE(family_plan, 'false') as family_plan,
    //                                                 overage_factor, 
    //                                                 COALESCE(factor_family, 'false') as factor_family,
    //                                                 COALESCE(moneda_pago, moneda, 'USD') as moneda_pago,
    //                                                 COALESCE(moneda, moneda_pago, 'USD') as moneda,
    //                                                 COALESCE(fecha_creacion, '2000-01-01 00:00:00') as fecha_creacion,
    //                                                 COALESCE(fecha_modificacion, '2000-01-01 00:00:00') as fecha_modificacion,
    //                                                 id_popularidad, 
    //                                                 COALESCE(max_age_ben_adic, 75) as max_age_ben_adic,
    //                                                 COALESCE(publico, 0) as publico,
    //                                                 id_site  
    //                                             FROM plans 
    //                                             ORDER BY id ASC 
    //                                             ");

    //     while ($row = $mysql_plans->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $plans[] = $row;
    //     }


    //     foreach($plans as $plan)
    //     {
    //         echo '.';    

    //         $idplan                                     = $plan['id'];
    //         $nombreplan                                 = $plan['name'];
    //         $idstatus                                   = $plan['activo'];
    //         $idcategoria                                = $plan['id_plan_categoria'];
    //         $tiempominimo                               = $plan['min_tiempo'];
    //         $tiempomaximo                               = $plan['max_tiempo'];
    //         $edadminima                                 = $plan['min_age'];
    //         $edadmaxima                                 = $plan['max_age'];
    //         $edadprecioincremento                       = $plan['normal_age'];
    //         $planfamiliar                               = ($plan['family_plan'] == 'Y' || $plan['family_plan'] == 'N') ? $plan['family_plan'] : 'Y';
    //         $factorpenalizacionedad                     = $plan['overage_factor'];
    //         $factorbeneficiofamiliar                    = $plan['factor_family'];
    //         $monedapago                                 = $plan['moneda_pago'] == 'EURO' ? 'EUR' : $plan['moneda_pago'];
    //         $idmonedapago                               = ejecuta_select($db_postgresql, "SELECT idmoneda FROM monedas WHERE codigo = '$monedapago'",'idmoneda');
    //         $monedacobertura                            = $plan['moneda'] == 'EURO' ? 'EUR' : $plan['moneda'];
    //         $idmonedacobertura                          = ejecuta_select($db_postgresql, "SELECT idmoneda FROM monedas WHERE codigo = '$monedacobertura'",'idmoneda');
    //         $fechacreacion                              = ($plan['fecha_creacion'] == '0000-00-00 00:00:00') ? '2000-01-01 00:00:00' : $plan['fecha_creacion'];
    //         $fechamodificacion                          = ($plan['fecha_modificacion'] == '0000-00-00 00:00:00') ? '2000-01-01 00:00:00' : $plan['fecha_modificacion'];
    //         $idpopularidad                              = $plan['id_popularidad'];
    //         $edadmaximabeneficioadic                    = $plan['max_age_ben_adic'];
    //         $descripcionplan                            = '';
    //         $descripcionplanen                          = '';
    //         $idtipoasistencia                           = 1;
    //         $fechaactualizacionprecioscostos            = '2000-01-01 00:00:00';
    //         $fechaactualizacionbeneficios               = '2000-01-01 00:00:00';
    //         $fechaactualizacionbeneficiosadicionales    = '2000-01-01 00:00:00';
    //         $fechaactualizacionbeneficiosproveedores    = '2000-01-01 00:00:00';
    //         $publico                                    = $plan['publico'];

    //         $idpais = $plan['id_site'];

    //         $insert = "INSERT INTO planes (
    //                                     idplan,
    //                                     nombreplan, 
    //                                     idstatus, 
    //                                     idcategoria, 
    //                                     tiempominimo, 
    //                                     tiempomaximo, 
    //                                     edadminima, 
    //                                     edadmaxima, 
    //                                     edadprecioincremento, 
    //                                     planfamiliar, 
    //                                     factorpenalizacionedad, 
    //                                     factorbeneficiofamiliar, 
    //                                     idmonedapago, 
    //                                     idmonedacobertura, 
    //                                     fechacreacion, 
    //                                     fechamodificacion, 
    //                                     idpopularidad, 
    //                                     edadmaximabeneficiosadic, 
    //                                     descripcionplan, 
    //                                     descripcionplanen, 
    //                                     idtipoasistencia, 
    //                                     fechaactualizacionprecioscostos, 
    //                                     fechaactualizacionbeneficios, 
    //                                     fechaactualizacionbeneficiosadicionales, 
    //                                     fechaactualizacionbeneficiosproveedores, 
    //                                     publico)
    //                                 VALUES(
    //                                     $idplan, 
    //                                     UPPER('$nombreplan'), 
    //                                     $idstatus, 
    //                                     $idcategoria, 
    //                                     $tiempominimo, 
    //                                     $tiempomaximo, 
    //                                     $edadminima, 
    //                                     $edadmaxima, 
    //                                     $edadprecioincremento, 
    //                                     '$planfamiliar', 
    //                                     $factorpenalizacionedad, 
    //                                     $factorbeneficiofamiliar, 
    //                                     $idmonedapago, 
    //                                     $idmonedacobertura, 
    //                                     '$fechacreacion', 
    //                                     '$fechamodificacion', 
    //                                     $idpopularidad, 
    //                                     $edadmaximabeneficioadic, 
    //                                     '$descripcionplan', 
    //                                     '$descripcionplanen', 
    //                                     $idtipoasistencia, 
    //                                     '$fechaactualizacionprecioscostos', 
    //                                     '$fechaactualizacionbeneficios', 
    //                                     '$fechaactualizacionbeneficiosadicionales', 
    //                                     '$fechaactualizacionbeneficiosproveedores', 
    //                                     '$publico' 
    //                                     )";

    //         if(ejecuta_insert($db_postgresql, $insert))
    //         {
    //             $mysql_precios  = array();
    //             $precios        = array();

    //             // PRECIOS
    //                 $mysql_precios = $db_mysql->query("SELECT * FROM precios WHERE id_plan = '$idplan' ORDER BY id ASC");

    //                 while ($row_precio = $mysql_precios->fetch_array(MYSQLI_ASSOC)) 
    //                 { 
    //                     $precios[] = $row_precio; 
    //                 }

    //                 if(count($precios) > 0)
    //                 {
    //                     foreach($precios as $precio)
    //                     {    
    //                         $dia        = $precio['dias'];
    //                         $precio     = $precio['precio'];
    //                         $costo1     = isset($precio['costo1']) ? $precio['costo1'] : 0;
    //                         $costo2     = isset($precio['costo2']) ? $precio['costo2'] : 0;
        
    //                         $insert     = "INSERT INTO planesprecios (
    //                                                         idplan, 
    //                                                         dia, 
    //                                                         precio, 
    //                                                         idpais, 
    //                                                         fechaactualizacion
    //                                                     )
    //                                                 VALUES
    //                                                     (
    //                                                         $idplan, 
    //                                                         $dia, 
    //                                                         $precio, 
    //                                                         $idpais, 
    //                                                         '2000-01-01 00:00:00'
    //                                                     )";
        
    //                         ejecuta_insert($db_postgresql, $insert);

    //                         if($costo1 > 0)
    //                         {
    //                             $insert = "INSERT INTO planescostos
    //                                                     (
    //                                                         idplan, 
    //                                                         idproveedor, 
    //                                                         dia, 
    //                                                         costo, 
    //                                                         idpais, 
    //                                                         fechaactualizacion
    //                                                     )
    //                                             VALUES
    //                                                 (
    //                                                     $idplan, 
    //                                                     1, 
    //                                                     $dia, 
    //                                                     $costo1, 
    //                                                     $idpais, 
    //                                                     '2000-01-01 00:00:00'
    //                                                 );";
        
    //                             ejecuta_insert($db_postgresql, $insert);
    //                         }

    //                         if($costo2 > 0)
    //                         {
    //                             $insert = "INSERT INTO planescostos
    //                                                     (
    //                                                         idplan, 
    //                                                         idproveedor, 
    //                                                         dia, 
    //                                                         costo, 
    //                                                         idpais, 
    //                                                         fechaactualizacion
    //                                                     )
    //                                             VALUES
    //                                                 (
    //                                                     $idplan, 
    //                                                     6, 
    //                                                     $dia, 
    //                                                     $costo2, 
    //                                                     $idpais, 
    //                                                     '2000-01-01 00:00:00'
    //                                                 );";
                                                    
    //                             ejecuta_insert($db_postgresql, $insert);
    //                         }
    //                     }
    //                 }
    //         }
    //         else
    //         {
    //             echo 'El plan '.$idplan.' ha tenido un problema para ser migrado';
    //         }
    //     }

    //     $secuencia = $idplan + 1;
    //     $secuencia = "ALTER SEQUENCE planes_idplan_seq RESTART WITH ".$secuencia; 
    //     ejecuta_select($db_postgresql, $secuencia);

    // // PLANES AGENCIAS *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: Planes Agencias';

    //     $mysql_planes_agencias = $db_mysql->query("SELECT DISTINCT producto, programaplan, agencia FROM orders JOIN plans ON plans.id = orders.producto JOIN broker ON broker.id_broker = orders.agencia ORDER BY producto, agencia ASC");

    //     while ($row = $mysql_planes_agencias->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $planes_agencias[] = $row;
    //     }

    //     foreach($planes_agencias as $plan_agencia)
    //     {
    //         echo '.';

    //         $idplan          = $plan_agencia['producto'];
    //         $idagencia       = $plan_agencia['agencia'];
    //         $idcategoria     = $plan_agencia['programaplan'];

    //         $insert     = "INSERT INTO planesagencias (
    //                                 idplan, 
    //                                 idagencia
    //                             )
    //                         VALUES
    //                             (
    //                                 $idplan, 
    //                                 $idagencia
    //                             )";

    //         ejecuta_insert($db_postgresql, $insert);

    //         $existe_comision  = ejecuta_select($db_postgresql, "SELECT idcomisiones FROM comisionesagencias WHERE idagencia = $idagencia AND idcategoria = $idcategoria");


    //         if($existe_comision['cantidad'] == 0)
    //         {
    //             $mysql_comisiones = $db_mysql->query("SELECT porcentaje FROM commissions WHERE id_categoria = $idcategoria AND id_agencia = $idagencia LIMIT 1");

    //             while ($row = $mysql_comisiones->fetch_array(MYSQLI_ASSOC)) 
    //             {
    //                 $comisiones[] = $row;
    //             }

    //             foreach($comisiones as $comision)
    //             {
    //                 $porcentaje = $comision['porcentaje'];

    //                 $insert     = "INSERT INTO comisionesagencias (
    //                                         idagencia, 
    //                                         idcategoria, 
    //                                         idplan,
    //                                         comision
    //                                     )
    //                                 VALUES
    //                                     (
    //                                         $idagencia, 
    //                                         $idcategoria, 
    //                                         NULL,
    //                                         $porcentaje
    //                                     )";

    //                 ejecuta_insert($db_postgresql, $insert);
    //             }

    //             $comisiones = array();
    //         }
    //     }

    // // PLANES PAISES *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: Planes Paises';

    //     $mysql_planes_paises = $db_mysql->query("SELECT DISTINCT producto as idplan, plans.id_site as idpais FROM orders JOIN plans ON plans.id = orders.producto ORDER BY producto ASC");

    //     while ($row = $mysql_planes_paises->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $planes_paises[] = $row;
    //     }

    //     foreach($planes_paises as $plan_pais)
    //     {
    //         echo '.';

    //         $idplan  = $plan_pais['idplan'];
    //         $idpais  = $plan_pais['idpais'];

    //         $insert     = "INSERT INTO planespaises (
    //                                 idplan, 
    //                                 idpais
    //                             )
    //                         VALUES
    //                             (
    //                                 $idplan, 
    //                                 $idpais
    //                             )";

    //         ejecuta_insert($db_postgresql, $insert);

    //     }


    // //PLANES FUENTES *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: Planes Fuentes';

    //     $mysql_planes = $db_mysql->query("SELECT DISTINCT producto as idplan FROM orders ORDER BY producto ASC");

    //     while ($row = $mysql_planes->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $planes_fuentes[] = $row;
    //     }

    //     foreach($planes_fuentes as $plan)
    //     {
    //         echo '.';

    //         $idplan  = $plan['idplan'];

    //         $insert     = "INSERT INTO planesfuentes (
    //                                 idplan, 
    //                                 idfuente
    //                             )
    //                         VALUES
    //                             (
    //                                 $idplan, 
    //                                 1
    //                             )";

    //         ejecuta_insert($db_postgresql, $insert);

    //     }

    // //PLANES ORIGENES Y DESTINOS *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: Planes Origenes y Planes Destinos';

    //     $mysql_planes_origenes = $db_mysql->query("SELECT DISTINCT producto as idplan FROM orders ORDER BY producto ASC");

    //     while ($row = $mysql_planes_origenes->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $planes_origenes[] = $row;
    //     }

    //     $origenes = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE origenpermitido = true");
    //     $destinos = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE destinopermitido = true");

    //     foreach($planes_origenes as $plan)
    //     {
    //         echo '.';
    //         $idplan  = $plan['idplan'];

    //         foreach($origenes['resultado'] as $origen)
    //         {
    //             $idpais     = $origen['idpais'];
    
    //             $insert     = "INSERT INTO planesorigenes (
    //                                     idplan, 
    //                                     idpais
    //                                 )
    //                             VALUES
    //                                 (
    //                                     $idplan, 
    //                                     $idpais
    //                                 )";
    
    //             ejecuta_insert($db_postgresql, $insert);
    //         }

    //         foreach($destinos['resultado'] as $destino)
    //         {
    //             $idpais     = $destino['idpais'];
    
    //             $insert     = "INSERT INTO planesdestinos (
    //                                     idplan, 
    //                                     idpais
    //                                 )
    //                             VALUES
    //                                 (
    //                                     $idplan, 
    //                                     $idpais
    //                                 )";
    
    //             ejecuta_insert($db_postgresql, $insert);
    //         }
    //     }

       
    // // PLANES BENEFICIOS *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: planesbeneficios';

    //     $mysql = $db_mysql->query("SELECT DISTINCT beneficios_costo.id_plan, 
    //                                         beneficios_costo.id_beneficio, 
    //                                         CAST(CONVERT(beneficios_costo.valor  USING utf8) AS binary) as cobertura,
    //                                         CAST(CONVERT(beneficios_costo.language_id  USING utf8) AS binary) as coberturaen
    //                                         FROM beneficios_costo JOIN plans ON plans.id = beneficios_costo.id_plan JOIN beneficios ON beneficios.id_beneficio = beneficios_costo.id_beneficio WHERE beneficios.language_id = 'spa' ORDER BY id_plan ASC");

    //     while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $planesbeneficios[] = $row;
    //     }

    //     foreach($planesbeneficios as $planbeneficio)
    //     {
    //         echo '.';

    //         $idplan          = $planbeneficio['id_plan'];
    //         $idbeneficio     = $planbeneficio['id_beneficio'];
    //         $cobertura       = $planbeneficio['cobertura'];
    //         $coberturaen     = $planbeneficio['coberturaen'];

    //         $insert     = "INSERT INTO planesbeneficios (
    //                                 idplan, 
    //                                 idbeneficio,
    //                                 cobertura,
    //                                 coberturaen,
    //                                 fechaactualizacion
    //                             )
    //                         VALUES
    //                             (
    //                                 $idplan, 
    //                                 $idbeneficio,
    //                                 '$cobertura',
    //                                 '$coberturaen',
    //                                 '2000-01-01 00:00:00'
    //                             )";

    //         if(ejecuta_insert($db_postgresql, $insert))
    //             {
    //                 $idplanbeneficio = select_max_id($db_postgresql, 'idplanbeneficio', 'planesbeneficios');

    //                 $insert     = "INSERT INTO planesbeneficiosproveedores (
    //                                         idplanbeneficio, 
    //                                         idproveedor,
    //                                         porcentajeriesgo,
    //                                         fechaactualizacion
    //                                     )
    //                                 VALUES
    //                                     (
    //                                         $idplanbeneficio, 
    //                                         1,
    //                                         100,
    //                                         '2000-01-01 00:00:00'
    //                                     )";

    //                 ejecuta_insert($db_postgresql, $insert);
    //             }
    //     }


    // // PLANES BENEFICIOS ADICIONALES *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: planesbeneficiosadicionales';

    //     $mysql = $db_mysql->query("SELECT DISTINCT beneficios_plus.id_plan as idplan, 
    //                                         beneficios_plus.id_beneficio as idbeneficioadicional,
    //                                         '0.2' as factorconversion,
    //                                         '0.2' as factorconversionedad,
    //                                         '0.2' as factorconversionfamiliar,
    //                                         CAST(CONVERT(beneficios_plus.valor  USING utf8) AS binary) as cobertura,
    //                                         CAST(CONVERT(beneficios_plus.valor  USING utf8) AS binary) as coberturaen,
    //                                         beneficios_plus.orden as orden,
    //                                         '2000-01-01 00:00:00' as fechaactualizacion
    //                                         FROM beneficios_plus 
    //                                         WHERE beneficios_plus.language_id = 'spa' 
    //                                         AND beneficios_plus.id_beneficio IN (35,36,37)
    //                                         ORDER BY beneficios_plus.id ASC");

    //     while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $planesbeneficiosadicionales[] = $row;
    //     }

    //     foreach($planesbeneficiosadicionales as $planbeneficioadicional)
    //     {
    //         echo '.';

    //         $idplan                     = $planbeneficioadicional['idplan'];
    //         $idbeneficioadicional       = $planbeneficioadicional['idbeneficioadicional'];
    //         $factorconversion           = $planbeneficioadicional['factorconversion'];
    //         $factorconversionedad       = $planbeneficioadicional['factorconversionedad'];
    //         $factorconversionfamiliar   = $planbeneficioadicional['factorconversionfamiliar'];
    //         $cobertura                  = $planbeneficioadicional['cobertura'];
    //         $coberturaen                = $planbeneficioadicional['coberturaen'];
    //         $orden                      = $planbeneficioadicional['orden'];
    //         $fechaactualizacion         = $planbeneficioadicional['fechaactualizacion'];

    //         $insert     = "INSERT INTO planesbeneficiosadicionales (
    //                                 idplan, 
    //                                 idbeneficioadicional,
    //                                 factorconversion,
    //                                 factorconversionedad,
    //                                 factorconversionfamiliar,
    //                                 cobertura,
    //                                 coberturaen,
    //                                 orden,
    //                                 fechaactualizacion
    //                             )
    //                         VALUES
    //                             (
    //                                 $idplan, 
    //                                 $idbeneficioadicional,
    //                                 '$factorconversion',
    //                                 '$factorconversionedad',
    //                                 '$factorconversionfamiliar',
    //                                 '$cobertura',
    //                                 '$coberturaen',
    //                                 $orden,
    //                                 '$fechaactualizacion'
    //                             )";

    //         if(ejecuta_insert($db_postgresql, $insert))
    //         {
    //             $idplanbeneficioadicional = select_max_id($db_postgresql, 'idplanbeneficioadicional', 'planesbeneficiosadicionales');

    //             $insert_beneficiosadicionalesproveedores     = "INSERT INTO planesbeneficiosadicionalesproveedores (
    //                                                                     idplanbeneficioadicional, 
    //                                                                     idproveedor,
    //                                                                     porcentajeriesgo
    //                                                                 )
    //                                                             VALUES
    //                                                                 (
    //                                                                     $idplanbeneficioadicional, 
    //                                                                     2,
    //                                                                     100
    //                                                                 )";

    //             ejecuta_insert($db_postgresql, $insert_beneficiosadicionalesproveedores);
    //         }
    //     }

    // // CUPONES PLANES *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: cuponesplanes';

    //     $mysql = $db_mysql->query("SELECT DISTINCT plans_category_coupons.id_plan, plans_category_coupons.id_cupon FROM plans_category_coupons JOIN plans on plans.id = plans_category_coupons.id_plan JOIN coupons on coupons.id = plans_category_coupons.id_cupon ORDER BY plans_category_coupons.id_plan_categoria ASC");

    //     while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $cuponesplanes[] = $row;
    //     }

    //     foreach($cuponesplanes as $cuponplan)
    //     {
    //         echo '.';

    //         $idplan    = $cuponplan['id_plan'];
    //         $idcupon   = $cuponplan['id_cupon'];

    //         $insert     = "INSERT INTO cuponesplanes (
    //                                 idplan, 
    //                                 idcupon
    //                             )
    //                         VALUES
    //                             (
    //                                 $idplan, 
    //                                 $idcupon
    //                             )";

    //         ejecuta_insert($db_postgresql, $insert);
    //     }

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
            
            ejecuta_insert($db_postgresql, $insert_corporativo);

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

            if($escorporativo == 1)
            {
                $select = "SELECT idcorporativo FROM corporativos WHERE idcorporativo = $idcorporativo"; 
                $postgresql_agencia = ejecuta_select($db_postgresql, $select);
                // echo $select.'--------------------'; 
                // echo $idusuario.'--------------------------------'; 
                // print_r($postgresql_agencia);
                // echo '-----------------------------';
                // print_r($usuario);
                // exit;
            }
            else
            {
                $select = "SELECT idagencia FROM agencias WHERE idagencia = $idagencia";
                $postgresql_agencia = ejecuta_select($db_postgresql, $select);
            }
            
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

                                if ($idusuario == 2716)
                                {
                                    echo $insert; exit;
                                }
                
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

    

    // // ORDENES *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: ordenes';

    //     $contador_ordenes                                       = 0;
    //     $contador_ordenes_rechazadas                            = 0;
    //     $contador_asistencias_rechazadas                        = 0;
    //     $contador_ordenes_con_agencia_cero                      = 0;
    //     $contador_ordenes_corporativas                          = 0;
    //     $contador_cargas_manuales                               = 0;
    //     $contador_ordenes_con_total_en_cero                     = 0;
    //     $contador_ordenes_corporativas_no_validas               = 0;
    //     $contador_asistencias_viajes_insertadas                 = 0;
    //     $contador_beneficiarios_viajes_insertados               = 0;
    //     $contador_beneficiarios_viajes_corporativos_insertados  = 0;
    //     $contador_emisiones_precompras                          = 0;

    //     $select = "SELECT  
    //                     id as idorden,
    //                     1 as idproducto,
    //                     COALESCE(status, 4) as idstatus,
    //                     COALESCE(codigo, 'XX-XXXX-XX') as codigovoucher,
    //                     agencia as idagencia,
    //                     COALESCE(cod_corp, 'NULL') as idcorporativo,
    //                     COALESCE(tasa_cambio, 1) as idmoneda,
    //                     total as total,
    //                     COALESCE(es_emision_corp, 0) as emisioncorporativa,
    //                     COALESCE(manual, 0) as cargamanual,
    //                     COALESCE(IF(cupon = '', 'NULL', cupon), 'NULL') as idcupon,
    //                     IF(fecha = '0000-00-00 00:00:00', '2000-01-01 00:00:00', COALESCE(fecha, '2000-01-01 00:00:00')) as fechacreacion,
    //                     IF(hora = '0000-00-00 00:00:00', '2000-01-01 00:00:00', COALESCE(hora, '2000-01-01 00:00:00')) as fechamodificacion,
    //                     COALESCE(vendedor, 293) as idusuario,
    //                     COALESCE(forma_pago, 1) as idplataformapago,
    //                     CAST(CONVERT(credito_tipo USING utf8) AS binary) as tdctipo,
    //                     CAST(CONVERT(credito_numero USING utf8) AS binary) as tdcnumero,
    //                     CAST(CONVERT(credito_nombre USING utf8) AS binary) as tdctitular,
    //                     CAST(CONVERT(credito_expira USING utf8) AS binary) as tdcexpiracion,
    //                     CAST(CONVERT(response USING utf8) AS binary) as respuestapago,
    //                     CAST(CONVERT(referencia USING utf8) AS binary) as referencia,
    //                     COALESCE(id_cia, 1) as idsistema,
    //                     1 as idempresa,
    //                     CASE
    //                         WHEN fuente = 0 THEN 1
    //                         WHEN fuente = 1 THEN 2
    //                         WHEN fuente = 2 THEN 4
    //                         WHEN fuente = 3 THEN 5
    //                         WHEN fuente = 4 THEN 3
    //                         ELSE 1
    //                     END as idfuente,
    //                     COALESCE(origin_ip, '0.0.0.0') as ip,
    //                     CAST(CONVERT(comentarios USING utf8) AS binary) as comentarios,
    //                     IF(programaplan = 32 AND salida = '0000-00-00', 1, 0) as cargaprecompra,
    //                     0 as idprecompra,
    //                     tiempo_x_producto as tiempoproducto,
    //                     IF( origen = '', 'US', COALESCE( origen, 'US' ) ) AS idorigen,
    //                     CASE
    //                         WHEN destino = 1 THEN 'EUR'
    //                         WHEN destino = 2 THEN 'AME'
    //                         WHEN destino = 3 THEN 'NAC'
    //                         ELSE 'AME'
    //                     END as destinos,
    //                     salida as fechadesde,
    //                     retorno as fechahasta,
    //                     programaplan as idcategoria,
    //                     producto as idplan,
    //                     COALESCE(family_plan, 0) as planfamiliar,
    //                     incentivo_porc as porcentajeincentivo,
    //                     incentivo_usd as montoincentivo,
    //                     nivel1,
    //                     nivel2,
    //                     nivel3,
    //                     nivel4,
    //                     nivel1_porc,
    //                     nivel2_porc,
    //                     nivel3_porc,
    //                     nivel4_porc,
    //                     nivel1_usd,
    //                     nivel2_usd,
    //                     nivel3_usd,
    //                     nivel4_usd,
    //                     CAST(CONVERT(nombre_contacto USING utf8) AS binary) as nombrecontacto, 
    //                     CAST(CONVERT(email_contacto USING utf8) AS binary) as correocontacto, 
    //                     CAST(CONVERT(telefono_contacto USING utf8) AS binary) as telefonocontacto, 
    //                     neto_prov as costo1,
    //                     neto_prov2 as costo2,
    //                     neto_prov3 as costo3,
    //                     neto_prov4 as costo4,
    //                     neto_prov5 as costo5,
    //                     neto_prov6 as costo6
    //                 FROM orders 
    //                 WHERE orders.fecha >= '2018-01-01' 
    //                 AND orders.fecha <= '2018-12-31'
    //                 ORDER BY id ASC 
    //             ";

    //     $mysql_ = $db_mysql->query($select);

    //     while ($row = $mysql_->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $registros[] = $row;
    //     }

    //     $cantidad_registros = count($registros);
    
    //     foreach($registros as $registro)
    //     {           
    //         $contador_ordenes = $contador_ordenes + 1;

    //         if($contador_ordenes % 1000 == 0 )
    //         {
    //             echo 'Procesados '.$contador_ordenes.' de '.$cantidad_registros.'
    //             ';
    //         }

    //         if($registro['idagencia'] != 0)
    //         {
    //             $idorden                = $registro['idorden'];
    //             $idproducto             = $registro['idproducto'];
    //             $idstatus               = $registro['idstatus'];
    //             $codigovoucher          = $registro['codigovoucher'];
    //             $idagencia              = $registro['idagencia'];
    //             $idcorporativo          = $registro['idcorporativo'];
    //             $idmoneda               = $registro['idmoneda'];
    //             $total                  = $registro['total'];
    //             $emisioncorporativa     = $registro['emisioncorporativa'];
    //             $cargamanual            = $registro['cargamanual'];
    //             $idcupon                = $registro['idcupon'];
    //             $fechacreacion          = $registro['fechacreacion'];
    //             $fechamodificacion      = $registro['fechamodificacion'];
    //             $idusuario              = ($registro['idusuario'] == 0) ? 1076 : $registro['idusuario'];
    //             $idplataformapago       = $registro['idplataformapago'];
    //             $tdctipo                = $registro['tdctipo'];
    //             $tdcnumero              = $registro['tdcnumero'];
    //             $tdctitular             = $registro['tdctitular'];
    //             $tdcexpiracion          = $registro['tdcexpiracion'];
    //             $respuestapago          = $registro['respuestapago'];
    //             $referencia             = $registro['referencia'];
    //             $idsistema              = $registro['idsistema'];
    //             $idempresa              = $registro['idempresa'];
    //             $idfuente               = $registro['idfuente'];
    //             $ip                     = $registro['ip'];
    //             $comentarios            = $registro['comentarios'];
    //             $cargaprecompra         = $registro['cargaprecompra'];
    //             $idprecompra            = $registro['idprecompra'];
    //             $tiempoproducto         = $registro['tiempoproducto'];

    //             $nombrecontacto         = $registro['nombrecontacto'];
    //             $correocontacto         = $registro['correocontacto'];
    //             $telefonocontacto       = $registro['telefonocontacto'];

    //             $costo1                 = $registro['costo1'];
    //             $costo2                 = $registro['costo2'];

    //             $porcentajeincentivo    = $registro['porcentajeincentivo'];
    //             $montoincentivo         = $registro['montoincentivo'];

    //             $idagencianivel1        = $registro['nivel1'];
    //             $idagencianivel2        = $registro['nivel2'];
    //             $idagencianivel3        = $registro['nivel3'];
    //             $idagencianivel4        = $registro['nivel4'];

    //             $porcentajenivel1       = $registro['nivel1_porc'];
    //             $porcentajenivel2       = $registro['nivel2_porc'];
    //             $porcentajenivel3       = $registro['nivel3_porc'];
    //             $porcentajenivel4       = $registro['nivel4_porc'];

    //             $montonivel1            = $registro['nivel1_usd'];
    //             $montonivel2            = $registro['nivel2_usd'];
    //             $montonivel3            = $registro['nivel3_usd'];
    //             $montonivel4            = $registro['nivel4_usd'];
    
    //             $insert = "INSERT INTO ordenes (
    //                                         idorden,
    //                                         idproducto,
    //                                         idstatus,
    //                                         codigovoucher,
    //                                         idagencia,
    //                                         idcorporativo,
    //                                         idmoneda,
    //                                         total,
    //                                         emisioncorporativa,
    //                                         cargamanual,
    //                                         idcupon,
    //                                         fechacreacion,
    //                                         fechamodificacion,
    //                                         idusuario,
    //                                         idplataformapago,
    //                                         tdctipo,
    //                                         tdcnumero,
    //                                         tdctitular,
    //                                         tdcexpiracion,
    //                                         respuestapago,
    //                                         referencia,
    //                                         idsistema,
    //                                         idempresa,
    //                                         idfuente,
    //                                         ip,
    //                                         comentarios,
    //                                         cargaprecompra,
    //                                         idprecompra,
    //                                         tiempoproducto,
    //                                         porcentajeincentivo,
    //                                         montoincentivo
    //                                         )
    //                                     VALUES
    //                                     (
    //                                         $idorden,                
    //                                         $idproducto,             
    //                                         $idstatus,               
    //                                         '$codigovoucher',          
    //                                         $idagencia,              
    //                                         $idcorporativo,          
    //                                         $idmoneda,               
    //                                         $total,                  
    //                                         '$emisioncorporativa',     
    //                                         '$cargamanual',            
    //                                         $idcupon,                
    //                                         '$fechacreacion',          
    //                                         '$fechamodificacion',      
    //                                         $idusuario,              
    //                                         $idplataformapago,       
    //                                         '$tdctipo',                
    //                                         '$tdcnumero',              
    //                                         '$tdctitular',             
    //                                         '$tdcexpiracion',          
    //                                         '$respuestapago',          
    //                                         '$referencia',             
    //                                         $idsistema,              
    //                                         $idempresa,              
    //                                         $idfuente,               
    //                                         '$ip',                     
    //                                         '$comentarios',            
    //                                         '$cargaprecompra',         
    //                                         $idprecompra,
    //                                         $tiempoproducto,
    //                                         $porcentajeincentivo, 
    //                                         $montoincentivo     
    //                                     )";
    //             // echo 'o-';   
    
    //             if(ejecuta_insert($db_postgresql, $insert))
    //             {
    //                 // COMISIONES
    //                     $contador_comisiones = 1;
    //                     while($contador_comisiones <= 4)
    //                     {
    //                         $idagencia     = 'idagencianivel'.$contador_comisiones;
    //                         $idagencia     = $$idagencia;

    //                         $porcentaje     = 'porcentajenivel'.$contador_comisiones;
    //                         $porcentaje     = $$porcentaje;
                            
    //                         $monto          = 'montonivel'.$contador_comisiones;
    //                         $monto         = $$monto;

    //                         $insert_ordenes_comisiones = "INSERT INTO ordenescomisiones
    //                                                                 (
    //                                                                     idorden,
    //                                                                     idagencia,
    //                                                                     idnivel,
    //                                                                     porcentaje,
    //                                                                     monto
    //                                                                 )
    //                                                             VALUES 
    //                                                                 (
    //                                                                     $idorden,
    //                                                                     $idagencia,
    //                                                                     $contador_comisiones,
    //                                                                     $porcentaje,
    //                                                                     $monto
    //                                                                 ); ";

    //                         if(!ejecuta_insert($db_postgresql, $insert_ordenes_comisiones))
    //                         {
    //                             echo 'ERROR INSERTANDO COMISIONES: '.$insert_ordenes_comisiones; exit;
    //                         }
    //                             $contador_comisiones++;
                            
    //                     }


    //                 //COSTOS 
    //                     $contador_costos = 1;
    //                     while($contador_costos <= 2)
    //                     {
    //                         $costo     = 'costo'.$contador_costos;
    //                         $costo     = $$costo;

    //                         $insert_ordenes_costos = "INSERT INTO ordenescostos
    //                                                                 (
    //                                                                     idorden,
    //                                                                     idproveedor,
    //                                                                     costo
    //                                                                 )
    //                                                             VALUES 
    //                                                                 (
    //                                                                     $idorden,
    //                                                                     $contador_costos,
    //                                                                     $costo
    //                                                                 ); ";

    //                         if(!ejecuta_insert($db_postgresql, $insert_ordenes_costos))
    //                         {
    //                             echo 'ERROR INSERTANDO COSTOS: '.$insert_ordenes_costos; exit;
    //                         }
    //                             $contador_costos++;
    //                     }
                        

    //                 //CONTACTOS
    //                     $insert_ordenes_contactos = "INSERT INTO ordenescontactos
    //                                                             (
    //                                                                 idorden,
    //                                                                 nombrecontacto,
    //                                                                 correocontacto,
    //                                                                 telefonocontacto
    //                                                             )
    //                                                         VALUES 
    //                                                             (
    //                                                                 $idorden,
    //                                                                 '$nombrecontacto',
    //                                                                 '$correocontacto',
    //                                                                 '$telefonocontacto'
    //                                                             ); ";

    //                     if(!ejecuta_insert($db_postgresql, $insert_ordenes_contactos))
    //                     {
    //                         echo 'ERROR INSERTANDO COSTOS: '.$insert_ordenes_contactos; exit;
    //                     }


    //                 //ASISTENCIAS VIAJES
    //                 if($registro['fechadesde'] != '0000-00-00 00:00:00' 
    //                 && $registro['fechadesde'] != '0000-00-00' 
    //                 && $registro['fechahasta'] != '0000-00-00 00:00:00' 
    //                 && $registro['fechahasta'] != '0000-00-00' 
    //                 && $registro['idcategoria'] != null
    //                 && $registro['idplan'] != null
    //                 && $registro['idcategoria'] != 32
    //                 )
    //                 {
    //                     $idorden        = $registro['idorden'];
    //                     $fechadesde     = $registro['fechadesde'];
    //                     $fechahasta     = $registro['fechahasta'];
                        
    //                     $origen         = ($registro['idorigen'] == '1S' || $registro['idorigen'] == 'US' || $registro['idorigen'] == ''  )  ? 'COM' : $registro['idorigen'];
    //                     $origen         = $origen == 'AN' ? 'AG' : $origen;
    //                     $select_pais    = ($registro['idorigen'] == '') ? "SELECT agencias.idpais as idpais FROM agencias WHERE agencias.idagencia = $idagencia" : "SELECT idpais FROM paises WHERE codigopais = '$origen'";
    //                     $idorigen       = ejecuta_select($db_postgresql, $select_pais, "idpais");
    //                     $destinos       = ($registro['destinos'] == '') ? 'AME' : $registro['destinos'];
    //                     $idcategoria    = $registro['idcategoria'];
    //                     $idplan         = $registro['idplan'];
    //                     $planfamiliar   = $registro['planfamiliar'] == '' ? 'f' : $registro['planfamiliar'];
    //                     $comentarios    = $registro['comentarios'];
    
    //                     $insert_asistenciasviajes = "INSERT INTO asistenciasviajes
    //                                             (
    //                                                 idorden, 
    //                                                 fechadesde, 
    //                                                 fechahasta, 
    //                                                 idorigen, 
    //                                                 destinos, 
    //                                                 idcategoria, 
    //                                                 idplan, 
    //                                                 planfamiliar, 
    //                                                 comentarios
    //                                             )
    //                                         VALUES
    //                                             (
    //                                                 $idorden, 
    //                                                 '$fechadesde', 
    //                                                 '$fechahasta', 
    //                                                 $idorigen, 
    //                                                 '$destinos', 
    //                                                 $idcategoria, 
    //                                                 $idplan, 
    //                                                 '$planfamiliar', 
    //                                                 '$comentarios'
    //                                             );";

    //                     // echo 'a-';
    
    //                     if(ejecuta_insert($db_postgresql, $insert_asistenciasviajes))
    //                     {
    //                         $contador_asistencias_viajes_insertadas++;

    //                         $select_beneficiarios = "SELECT  
    //                                                     id as idbeneficiario,
    //                                                     id_orden as idorden,
    //                                                     CAST(CONVERT(nombre USING utf8) AS binary) as nombrebeneficiario,
    //                                                     CAST(CONVERT(apellido USING utf8) AS binary) as apellidobeneficiario,
    //                                                     CAST(CONVERT(email USING utf8) AS binary) as correobeneficiario,
    //                                                     CAST(CONVERT(telefono USING utf8) AS binary) as telefono,
    //                                                     IF(nacimiento = '0000-00-00', NULL, CAST(CONVERT(nacimiento USING utf8) AS binary)) as fechanacimiento,
    //                                                     CAST(CONVERT(documento USING utf8) AS binary) as documentacion,
    //                                                     IF(status != 1, 2, status) as idstatus,
    //                                                     COALESCE(precio_vta, 0) as precioventa,
    //                                                     COALESCE(precio_cost, 0) as costo1,
    //                                                     COALESCE(precio_cost2, 0) as costo2,
    //                                                     id_rider as beneficio1,
    //                                                     precio_cost_sp as costobeneficio1,
    //                                                     id_rider2 as beneficio2,
    //                                                     precio_cost_sp2 as costobeneficio2,
    //                                                     cancel_precio,
    //                                                     cancel_monto,
    //                                                     cancel_cobertura
    //                                                 FROM beneficiaries
    //                                                 WHERE id_orden = $idorden
    //                                                 ORDER BY id ASC
    //                                             ";

    //                         // echo $select_beneficiarios; exit;

    //                         $mysql_beneficiarios = $db_mysql->query($select_beneficiarios);

    //                         while ($row_beneficiarios = $mysql_beneficiarios->fetch_array(MYSQLI_ASSOC)) 
    //                         {
    //                             $row_array_beneficiarios[] = $row_beneficiarios;

    //                         }

    //                         if(count($row_array_beneficiarios) > 0)
    //                         {
    //                             $consecutivo = 1;
    //                             foreach($row_array_beneficiarios as $beneficiario)
    //                             {                                    
    //                                 $idbeneficiario         = $beneficiario['idbeneficiario'];
    //                                 $idorden                = $beneficiario['idorden'];
    //                                 $nombrebeneficiario     = $beneficiario['nombrebeneficiario'];
    //                                 $apellidobeneficiario   = $beneficiario['apellidobeneficiario'];
    //                                 $correobeneficiario     = $beneficiario['correobeneficiario'];
    //                                 $telefono               = $beneficiario['telefono'];
    //                                 $fechanacimiento        = $beneficiario['fechanacimiento'];
    //                                 $documentacion          = $beneficiario['documentacion'];
    //                                 $idstatus               = $beneficiario['idstatus'];
    //                                 $precioventa            = $beneficiario['precioventa'];
    //                                 $costo1                 = $beneficiario['costo1'];
    //                                 $costo2                 = $beneficiario['costo2'];
    //                                 $id_rider               = $beneficiario['beneficio1'];
    //                                 $costobeneficio1        = $beneficiario['costobeneficio1'];
    //                                 $id_rider2              = $beneficiario['beneficio2'];
    //                                 $costobeneficio2        = $beneficiario['costobeneficio2'];
    //                                 $cancel_precio          = $beneficiario['cancel_precio'];
    //                                 $cancel_monto           = $beneficiario['cancel_monto'];
    //                                 $cancel_cobertura       = $beneficiario['cancel_cobertura'];

    //                                 $nombrebeneficiario     = str_replace(";", " ", $nombrebeneficiario);
    //                                 $apellidobeneficiario   = str_replace(";", " ", $apellidobeneficiario);

    //                                 if($apellidobeneficiario == 'notprovided')
    //                                 {
    //                                     $exp_nombrebeneficiario = explode(" ", $nombrebeneficiario);

    //                                     if(is_array($exp_nombrebeneficiario))
    //                                     {
    //                                         if(count($exp_nombrebeneficiario) == 1)
    //                                         {
    //                                             $nombrebeneficiario     = $exp_nombrebeneficiario[0];
    //                                         }
    //                                         if(count($exp_nombrebeneficiario) == 2)
    //                                         {
    //                                             $nombrebeneficiario     = $exp_nombrebeneficiario[0];
    //                                             $apellidobeneficiario   = $exp_nombrebeneficiario[1];
    //                                         }
    //                                         else if(count($exp_nombrebeneficiario) == 3)
    //                                         {
    //                                             $nombrebeneficiario     = $exp_nombrebeneficiario[0];
    //                                             $apellidobeneficiario   = $exp_nombrebeneficiario[1].' '.$exp_nombrebeneficiario[2];
    //                                         }
    //                                         else if(count($exp_nombrebeneficiario) == 4)
    //                                         {
    //                                             $nombrebeneficiario     = $exp_nombrebeneficiario[0].' '.$exp_nombrebeneficiario[1];
    //                                             $apellidobeneficiario   = $exp_nombrebeneficiario[2].' '.$exp_nombrebeneficiario[3];
    //                                         }
    //                                         else if(count($exp_nombrebeneficiario) == 5)
    //                                         {
    //                                             $nombrebeneficiario     = $exp_nombrebeneficiario[0].' '.$exp_nombrebeneficiario[1].' '.$exp_nombrebeneficiario[2];
    //                                             $apellidobeneficiario   = $exp_nombrebeneficiario[3].' '.$exp_nombrebeneficiario[4];
    //                                         }
    //                                         else if(count($exp_nombrebeneficiario) == 6)
    //                                         {
    //                                             $nombrebeneficiario     = $exp_nombrebeneficiario[0].' '.$exp_nombrebeneficiario[1].' '.$exp_nombrebeneficiario[2].' '.$exp_nombrebeneficiario[3];
    //                                             $apellidobeneficiario   = $exp_nombrebeneficiario[4].' '.$exp_nombrebeneficiario[5];
    //                                         }
    //                                     }

    //                                 }

    //                                 if($beneficiario['fechanacimiento'] == NULL || $beneficiario['fechanacimiento'] == 'NULL')
    //                                 {
    //                                     $insert_beneficiarios = "INSERT INTO beneficiarios (
    //                                                                     idbeneficiario,
    //                                                                     idorden,
    //                                                                     idordencorporativa,
    //                                                                     nombrebeneficiario,
    //                                                                     apellidobeneficiario,
    //                                                                     correobeneficiario,
    //                                                                     telefono,
    //                                                                     fechanacimiento,
    //                                                                     documentacion,
    //                                                                     idstatus,
    //                                                                     precioventa,
    //                                                                     consecutivo
    //                                                                 ) 
    //                                                             VALUES (
    //                                                                     $idbeneficiario,
    //                                                                     $idorden,
    //                                                                     NULL,
    //                                                                     UPPER('$nombrebeneficiario'),
    //                                                                     UPPER('$apellidobeneficiario'),
    //                                                                     LOWER('$correobeneficiario'),
    //                                                                     '$telefono',
    //                                                                     NULL,
    //                                                                     '$documentacion',
    //                                                                     $idstatus,
    //                                                                     $precioventa,
    //                                                                     $consecutivo 
    //                                                             ); " ;
    //                                 }
    //                                 else
    //                                 {
    //                                     $insert_beneficiarios = "INSERT INTO beneficiarios (
    //                                                                     idbeneficiario,
    //                                                                     idorden,
    //                                                                     idordencorporativa,
    //                                                                     nombrebeneficiario,
    //                                                                     apellidobeneficiario,
    //                                                                     correobeneficiario,
    //                                                                     telefono,
    //                                                                     fechanacimiento,
    //                                                                     documentacion,
    //                                                                     idstatus,
    //                                                                     precioventa,
    //                                                                     consecutivo
    //                                                                 ) 
    //                                                             VALUES (
    //                                                                     $idbeneficiario,
    //                                                                     $idorden,
    //                                                                     NULL,
    //                                                                     UPPER('$nombrebeneficiario'),
    //                                                                     UPPER('$apellidobeneficiario'),
    //                                                                     '$correobeneficiario',
    //                                                                     '$telefono',
    //                                                                     '$fechanacimiento',
    //                                                                     '$documentacion',
    //                                                                     $idstatus,
    //                                                                     $precioventa,
    //                                                                     $consecutivo 
    //                                                             ); " ;
    //                                 }

    //                                 // echo 'b-';

    //                                 if(ejecuta_insert($db_postgresql, $insert_beneficiarios))
    //                                 {
    //                                     //COSTOS 
    //                                         $contador_costo = 1;
    //                                         while($contador_costo <= 2)
    //                                         {
    //                                             $costo     = 'costo'.$contador_costo;
    //                                             $costo     = $$costo;

    //                                             $insert_beneficarios_costos = "INSERT INTO beneficiarioscostos (
    //                                                                                         idbeneficiario,
    //                                                                                         idproveedor,
    //                                                                                         costo
    //                                                                                     )
    //                                                                                     VALUES (
    //                                                                                         $idbeneficiario,
    //                                                                                         $contador_costo,
    //                                                                                         $costo
    //                                                                                     )";

    //                                             ejecuta_insert($db_postgresql, $insert_beneficarios_costos);

    //                                             $contador_costo++;
    //                                         }
                                        
    //                                     //BENEFICIOS ADICIONALES
    //                                         if($id_rider > 0 && $costobeneficio1 > 0)
    //                                         {
    //                                             $insert_beneficio_adicional = "INSERT INTO beneficiariosbeneficiosadicionales (
    //                                                                                     idbeneficiario,
    //                                                                                     idbeneficioadicional,
    //                                                                                     precio
    //                                                                                 ) VALUES (
    //                                                                                     $idbeneficiario,
    //                                                                                     $id_rider,
    //                                                                                     $costobeneficio1
    //                                                                                 ) "; 
                                                
    //                                             if(!ejecuta_insert($db_postgresql, $insert_beneficio_adicional))
    //                                             {
    //                                                 echo $insert_beneficio_adicional; exit;
    //                                             }
    //                                         }

    //                                         if($id_rider2 > 0 && $costobeneficio2 > 0)
    //                                         {
    //                                             $insert_beneficio_adicional = "INSERT INTO beneficiariosbeneficiosadicionales (
    //                                                                                     idbeneficiario,
    //                                                                                     idbeneficioadicional,
    //                                                                                     precio
    //                                                                                 ) VALUES (
    //                                                                                     $idbeneficiario,
    //                                                                                     $id_rider2,
    //                                                                                     $costobeneficio2
    //                                                                                 ) ";
                                                
    //                                             if(!ejecuta_insert($db_postgresql, $insert_beneficio_adicional))
    //                                             {
    //                                                 echo $insert_beneficio_adicional; exit;
    //                                             }
    //                                         }

    //                                         if($cancel_precio > 0)
    //                                         {
    //                                             $insert_beneficio_adicional = "INSERT INTO beneficiariosbeneficiosadicionales (
    //                                                                                 idbeneficiario,
    //                                                                                 idbeneficioadicional,
    //                                                                                 precio,
    //                                                                                 monto,
    //                                                                                 cobertura
    //                                                                             ) VALUES (
    //                                                                                 $idbeneficiario,
    //                                                                                 38,
    //                                                                                 $cancel_precio,
    //                                                                                 $cancel_monto,
    //                                                                                 $cancel_cobertura
    //                                                                             ) ";
            
    //                                             if(!ejecuta_insert($db_postgresql, $insert_beneficio_adicional))
    //                                             {
    //                                                 echo $insert_beneficio_adicional; exit;
    //                                             }
    //                                         }


    //                                     $contador_beneficiarios_viajes_insertados++;
    //                                 }
    //                                 else
    //                                 {
    //                                     echo $insert_beneficiarios;
    //                                 }

    //                                 $consecutivo++;
    //                             }
    //                         }

    //                         $row_array_beneficiarios = array();
    //                     }
    //                     else
    //                     {
    //                         echo $insert_asistenciasviajes;
    //                     }
    //                 }
    //                 else if($registro['emisioncorporativa'] == 1 && $registro['fechadesde'] == '0000-00-00')
    //                 {
    //                     $insert_asistenciacorporativa = "INSERT INTO asistenciascorporativas (
    //                                                                 idorden,
    //                                                                 idplan,
    //                                                                 tiempoproducto
    //                                                             ) 
    //                                                         VALUES (
    //                                                                 $idorden,
    //                                                                 $idplan,
    //                                                                 $tiempoproducto
    //                                                         ); " ;

    //                     if(ejecuta_insert($db_postgresql, $insert_asistenciacorporativa))
    //                     {
    //                         $select_asistenciacorporativa = "SELECT  
    //                                                             id as idasistenciacorporativaviaje,
    //                                                             orden as idorden,
    //                                                             salida as fechadesde,
    //                                                             retorno as fechahasta,
    //                                                             origen as idorigen,
    //                                                             CASE
    //                                                                 WHEN destino = 1 THEN 'EUR'
    //                                                                 WHEN destino = 2 THEN 'AME'
    //                                                                 WHEN destino = 3 THEN 'NAC'
    //                                                                 ELSE 'AME'
    //                                                             END as destinos,
    //                                                             codigo as codigovoucheremision,
    //                                                             fecha as fechacreacion,
    //                                                             hora as fechamodificacion,
    //                                                             IF(vendedor = 0, 1076, vendedor) as idagente,
    //                                                             status as idstatus,
    //                                                             COALESCE((SELECT family_plan from orders where orders.id = emisiones.orden ), 0) as planfamiliar,
    //                                                             '' as comentarios,
    //                                                             CAST(CONVERT(nombre_contacto USING utf8) AS binary) as nombrecontacto, 
    //                                                             CAST(CONVERT(email_contacto USING utf8) AS binary) as correocontacto, 
    //                                                             CAST(CONVERT(telefono_contacto USING utf8) AS binary) as telefonocontacto
    //                                                         FROM emisiones
    //                                                         WHERE orden = $idorden
    //                                                     ";
    
    //                         $mysql_asistenciacorporativa = $db_mysql->query($select_asistenciacorporativa);
    
    //                         while ($row_asistenciacorporativas = $mysql_asistenciacorporativa->fetch_array(MYSQLI_ASSOC)) 
    //                         {
    //                             $row_asistenciacorporativa[] = $row_asistenciacorporativas;
    //                         }
    
    //                         if(count($row_asistenciacorporativa) > 0)
    //                         {
    //                             foreach($row_asistenciacorporativa as $asistenciacorporativa)
    //                             {
    //                                 $idasistenciacorporativaviaje   = $asistenciacorporativa['idasistenciacorporativaviaje'];
    //                                 $idorden                        = $asistenciacorporativa['idorden'];
    //                                 $fechadesde                     = $asistenciacorporativa['fechadesde'];
    //                                 $fechahasta                     = ($asistenciacorporativa['fechahasta'] == '0000-00-00 00:00:00') ? $asistenciacorporativa['fechadesde'] : $asistenciacorporativa['fechahasta'];
    
    //                                 $origen         = ($asistenciacorporativa['idorigen'] == '1S' || $asistenciacorporativa['idorigen'] == 'US' )  ? 'COM' : $asistenciacorporativa['idorigen'];
    //                                 $origen         = $origen == 'AN' ? 'AG' : $origen;
    //                                 $select_pais    = ($asistenciacorporativa['idorigen'] == '') ? "SELECT agencias.idpais as idpais FROM agencias WHERE agencias.idagencia = $idagencia" : "SELECT idpais FROM paises WHERE codigopais = '$origen'";
    //                                 $idorigen       = ejecuta_select($db_postgresql, $select_pais, "idpais");
    
    //                                 $destinos                       = $asistenciacorporativa['destinos'];
    //                                 $codigovoucheremision           = $asistenciacorporativa['codigovoucheremision'];
    //                                 $fechacreacion                  = $asistenciacorporativa['fechacreacion'];
    //                                 $fechamodificacion              = ($asistenciacorporativa['fechamodificacion'] == '0000-00-00 00:00:00') ? $asistenciacorporativa['fechacreacion'] : $asistenciacorporativa['fechamodificacion'];
    //                                 $idagente                      = $asistenciacorporativa['idagente'];
    //                                 $idstatus                       = $asistenciacorporativa['idstatus'];
    //                                 $planfamiliar                   = $asistenciacorporativa['planfamiliar'];
    //                                 $comentarios                    = $asistenciacorporativa['comentarios'];

    //                                 $nombrecontacto                 = $asistenciacorporativa['nombrecontacto'];
    //                                 $correocontacto                 = $asistenciacorporativa['correocontacto'];
    //                                 $telefonocontacto               = $asistenciacorporativa['telefonocontacto'];
    
    //                                 $insert_asistenciacorporativaviaje = "INSERT INTO asistenciascorporativasviajes (
    //                                                                             idasistenciacorporativaviaje,
    //                                                                             idorden,
    //                                                                             fechadesde,
    //                                                                             fechahasta,
    //                                                                             idorigen,
    //                                                                             destinos,
    //                                                                             codigovoucheremision,
    //                                                                             fechacreacion,
    //                                                                             fechamodificacion,
    //                                                                             idagente,
    //                                                                             idstatus,
    //                                                                             planfamiliar,
    //                                                                             comentarios
    //                                                                         ) 
    //                                                                     VALUES (
    //                                                                             $idasistenciacorporativaviaje,
    //                                                                             $idorden,
    //                                                                             '$fechadesde',
    //                                                                             '$fechahasta',
    //                                                                             $idorigen,
    //                                                                             '$destinos',
    //                                                                             '$codigovoucheremision',
    //                                                                             '$fechacreacion',
    //                                                                             '$fechamodificacion',
    //                                                                             $idagente,
    //                                                                             $idstatus,
    //                                                                             '$planfamiliar',
    //                                                                             '$comentarios'
    //                                                                     ); " ;
    
    //                                 if(ejecuta_insert($db_postgresql, $insert_asistenciacorporativaviaje))
    //                                 {
    //                                     $insert_contactos_asistenciacorporativaviaje = "INSERT INTO ordenescontactos (
    //                                                                                             idorden,
    //                                                                                             idordencorporativa,
    //                                                                                             nombrecontacto,
    //                                                                                             correocontacto,
    //                                                                                             telefonocontacto
    //                                                                                         ) 
    //                                                                                     VALUES (
    //                                                                                             $idorden,
    //                                                                                             $idasistenciacorporativaviaje,
    //                                                                                             '$nombrecontacto',
    //                                                                                             '$correocontacto',
    //                                                                                             '$telefonocontacto'
    //                                                                                     ); " ;

    //                                     if(ejecuta_insert($db_postgresql, $insert_contactos_asistenciacorporativaviaje))
    //                                     {
    //                                         $contador_asistencias_viajes_insertadas++;
        
    //                                         $select_beneficiarios_corporativos = "SELECT  
    //                                                                                 id as idbeneficiario,
    //                                                                                 id_emision as idordencorporativa,
    //                                                                                 CAST(CONVERT(nombre USING utf8) AS binary) as nombrebeneficiario,
    //                                                                                 CAST(CONVERT(apellido USING utf8) AS binary) as apellidobeneficiario,
    //                                                                                 CAST(CONVERT(email USING utf8) AS binary) as correobeneficiario,
    //                                                                                 CAST(CONVERT(telefono USING utf8) AS binary) as telefono,
    //                                                                                 IF(nacimiento = '0000-00-00', 'NULL', CAST(CONVERT(nacimiento USING utf8) AS binary)) as fechanacimiento,
    //                                                                                 CAST(CONVERT(documento USING utf8) AS binary) as documentacion,
    //                                                                                 IF(status != 1, 2, status) as idstatus,
    //                                                                                 COALESCE(precio_vta, 0) as precioventa
    //                                                                             FROM beneficiaries
    //                                                                             WHERE id_emision = $idasistenciacorporativaviaje
    //                                                                             ORDER BY id ASC
    //                                                                         ";
        
    //                                         $mysql_beneficiarios_corporativos = $db_mysql->query($select_beneficiarios_corporativos);
        
    //                                         while ($row_beneficiarios_corporativos = $mysql_beneficiarios_corporativos->fetch_array(MYSQLI_ASSOC)) 
    //                                         {
    //                                             $row_array_beneficiarios_corporativos[] = $row_beneficiarios_corporativos;
    //                                         }
        
    //                                         if(count($row_array_beneficiarios_corporativos) > 0)
    //                                         {
    //                                             $consecutivo = 1;
    //                                             foreach($row_array_beneficiarios_corporativos as $beneficiario_corporativo)
    //                                             {
    //                                                 $idbeneficiario         = $beneficiario_corporativo['idbeneficiario'];
    //                                                 $idordencorporativa     = $beneficiario_corporativo['idordencorporativa'];
    //                                                 $nombrebeneficiario     = $beneficiario_corporativo['nombrebeneficiario'];
    //                                                 $apellidobeneficiario   = $beneficiario_corporativo['apellidobeneficiario'];
    //                                                 $correobeneficiario     = $beneficiario_corporativo['correobeneficiario'];
    //                                                 $telefono               = $beneficiario_corporativo['telefono'];
    //                                                 $fechanacimiento        = $beneficiario_corporativo['fechanacimiento'];
    //                                                 $documentacion          = $beneficiario_corporativo['documentacion'];
    //                                                 $idstatus               = $beneficiario_corporativo['idstatus'];
    //                                                 $precioventa            = $beneficiario_corporativo['precioventa'];
        
    //                                                 if($beneficiario_corporativo['fechanacimiento'] == NULL || $beneficiario_corporativo['fechanacimiento'] == 'NULL' )
    //                                                 {
    //                                                     $insert_beneficiarios = "INSERT INTO beneficiarios (
    //                                                                                     idbeneficiario,
    //                                                                                     idorden,
    //                                                                                     idordencorporativa,
    //                                                                                     nombrebeneficiario,
    //                                                                                     apellidobeneficiario,
    //                                                                                     correobeneficiario,
    //                                                                                     telefono,
    //                                                                                     fechanacimiento,
    //                                                                                     documentacion,
    //                                                                                     idstatus,
    //                                                                                     precioventa,
    //                                                                                     consecutivo
    //                                                                                 ) 
    //                                                                             VALUES (
    //                                                                                     $idbeneficiario,
    //                                                                                     $idorden,
    //                                                                                     $idordencorporativa,
    //                                                                                     UPPER('$nombrebeneficiario'),
    //                                                                                     UPPER('$apellidobeneficiario'),
    //                                                                                     '$correobeneficiario',
    //                                                                                     '$telefono',
    //                                                                                     NULL,
    //                                                                                     '$documentacion',
    //                                                                                     $idstatus,
    //                                                                                     $precioventa,
    //                                                                                     $consecutivo 
    //                                                                             ); " ;
    //                                                 }
    //                                                 else
    //                                                 {
    //                                                     $insert_beneficiarios = "INSERT INTO beneficiarios (
    //                                                                                     idbeneficiario,
    //                                                                                     idorden,
    //                                                                                     idordencorporativa,
    //                                                                                     nombrebeneficiario,
    //                                                                                     apellidobeneficiario,
    //                                                                                     correobeneficiario,
    //                                                                                     telefono,
    //                                                                                     fechanacimiento,
    //                                                                                     documentacion,
    //                                                                                     idstatus,
    //                                                                                     precioventa,
    //                                                                                     consecutivo
    //                                                                                 ) 
    //                                                                             VALUES (
    //                                                                                     $idbeneficiario,
    //                                                                                     $idorden,
    //                                                                                     $idordencorporativa,
    //                                                                                     UPPER('$nombrebeneficiario'),
    //                                                                                     UPPER('$apellidobeneficiario'),
    //                                                                                     '$correobeneficiario',
    //                                                                                     '$telefono',
    //                                                                                     '$fechanacimiento',
    //                                                                                     '$documentacion',
    //                                                                                     $idstatus,
    //                                                                                     $precioventa,
    //                                                                                     $consecutivo 
    //                                                                             ); " ;
    //                                                 }
        
    //                                                 // echo 'b-';
                                                    
    //                                                 if(ejecuta_insert($db_postgresql, $insert_beneficiarios))
    //                                                 {
    //                                                     $contador_costo = 1;
    //                                                     while($contador_costo <= 2)
    //                                                     {
    //                                                         $costo     = 'costo'.$contador_costo;
    //                                                         $costo     = $$costo;
        
    //                                                         $insert_beneficarios_costos = "INSERT INTO beneficiarioscostos (
    //                                                                                                     idbeneficiario,
    //                                                                                                     idproveedor,
    //                                                                                                     costo
    //                                                                                                 )
    //                                                                                                 VALUES (
    //                                                                                                     $idbeneficiario,
    //                                                                                                     $contador_costo,
    //                                                                                                     $costo
    //                                                                                                 )";
        
    //                                                         ejecuta_insert($db_postgresql, $insert_beneficarios_costos);
        
    //                                                         $contador_costo++;
    //                                                     }
                                                        
    //                                                     $contador_beneficiarios_viajes_corporativos_insertados++;
    //                                                 }
    //                                                 else
    //                                                 {
    //                                                     echo $insert_beneficiarios;
    //                                                 }
        
    //                                                 $consecutivo++;
    //                                             }
    //                                         }
        
    //                                         $row_array_beneficiarios_corporativos = array();
    //                                     }
    //                                     else
    //                                     {
    //                                         echo $insert_contactos_asistenciacorporativaviaje;
    //                                     }
    //                                 }
    //                                 else
    //                                 {
    //                                     echo $insert_asistenciacorporativaviaje;
    //                                 }
    //                             }
    //                         }
    
    //                         $row_asistenciacorporativa = array();
                            
    //                         $contador_ordenes_corporativas++;
    //                     }
    //                     else
    //                     {
    //                         echo $insert_asistenciacorporativa;
    //                         exit;
    //                     }
    //                 }
    //                 else
    //                 {
    //                     if($cargaprecompra)
    //                     {
    //                         $select_precompra = "SELECT  
    //                                                 id as idprecompra,
    //                                                 IF(status = 1, 1, 2) as idstatus,
    //                                                 fecha_precompra as fechaprecompra,
    //                                                 voucher as idorden
    //                                             FROM precompra
    //                                             WHERE voucher = $idorden
    //                                         ";

    //                         $mysql_precompra = $db_mysql->query($select_precompra);

    //                         while ($row_precompra = $mysql_precompra->fetch_array(MYSQLI_ASSOC)) 
    //                         {
    //                             if(count($row_precompra) > 0)
    //                             {
    //                                 $idprecompra        = $row_precompra['idprecompra'];
    //                                 $idstatus           = $row_precompra['idstatus'];
    //                                 $fechaprecompra     = $row_precompra['fechaprecompra'];

    //                                 $insert_precompra = "INSERT INTO precompras (
    //                                                                     idprecompra,
    //                                                                     idstatus,
    //                                                                     fechaprecompra,
    //                                                                     idorden
    //                                                                 ) 
    //                                                             VALUES (
    //                                                                     $idprecompra,
    //                                                                     $idstatus,
    //                                                                     '$fechaprecompra',
    //                                                                     $idorden
    //                                                             ); " ;
    //                                 // echo 'p-';

    //                                 if(ejecuta_insert($db_postgresql, $insert_precompra))
    //                                 {
                                        
    //                                 }
    //                                 else
    //                                 {
    //                                     echo $insert_precompra;
    //                                 }
    //                             }
    //                         }
    //                     }
    //                     else
    //                     {
    //                         // EMISIONES DE PRECOMPRA
    //                         if($registro['idcategoria'] == 32 && $registro['fechadesde'] != '0000-00-00' && $registro['fechahasta'] != '0000-00-00')
    //                         {
    //                             $contador_emisiones_precompras++;

    //                             $idorden        = $registro['idorden'];
    //                             $fechadesde     = $registro['fechadesde'];
    //                             $fechahasta     = $registro['fechahasta'];
    //                             $origen         = ($registro['idorigen'] == '1S' || $registro['idorigen'] == 'US' || $registro['idorigen'] == ''  )  ? 'COM' : $registro['idorigen'];
    //                             $origen         = $origen == 'AN' ? 'AG' : $origen;
    //                             $select_pais    = ($registro['idorigen'] == '') ? "SELECT agencias.idpais as idpais FROM agencias WHERE agencias.idagencia = $idagencia" : "SELECT idpais FROM paises WHERE codigopais = '$origen'";
    //                             $idorigen       = ejecuta_select($db_postgresql, $select_pais, "idpais");
    //                             $destinos       = ($registro['destinos'] == '') ? 'AME' : $registro['destinos'];
    //                             $idcategoria    = $registro['idcategoria'];
    //                             $idplan         = $registro['idplan'];
    //                             $planfamiliar   = $registro['planfamiliar'] == '' ? 'f' : $registro['planfamiliar'];
    //                             $comentarios    = $registro['comentarios'];

    //                             $select_precompra_padre   = "SELECT precompra FROM historico_precompra WHERE orden = $idorden";
                                
    //                             $mysql_precompra_padre = $db_mysql->query($select_precompra_padre);

    //                             while ($row_precompra_padre = $mysql_precompra_padre->fetch_array(MYSQLI_ASSOC)) 
    //                             {
    //                                 if(count($row_precompra_padre) > 0)
    //                                 {
    //                                     $idprecompra                    = $row_precompra_padre['precompra'];
    //                                     $update_emision_precompra       = "UPDATE ordenes SET idprecompra = $idprecompra WHERE idorden = $idorden";
                            
    //                                     if(ejecuta_update($db_postgresql, $update_emision_precompra))
    //                                     {
    //                                             $insert_emision_precompra_asistenciasviajes = "INSERT INTO asistenciasviajes
    //                                                                                             (
    //                                                                                                 idorden, 
    //                                                                                                 fechadesde, 
    //                                                                                                 fechahasta, 
    //                                                                                                 idorigen, 
    //                                                                                                 destinos, 
    //                                                                                                 idcategoria, 
    //                                                                                                 idplan, 
    //                                                                                                 planfamiliar, 
    //                                                                                                 comentarios
    //                                                                                             )
    //                                                                                         VALUES
    //                                                                                             (
    //                                                                                                 $idorden, 
    //                                                                                                 '$fechadesde', 
    //                                                                                                 '$fechahasta', 
    //                                                                                                 $idorigen, 
    //                                                                                                 '$destinos', 
    //                                                                                                 $idcategoria, 
    //                                                                                                 $idplan, 
    //                                                                                                 '$planfamiliar', 
    //                                                                                                 '$comentarios'
    //                                                                                             );";

    //                                             if(ejecuta_insert($db_postgresql, $insert_emision_precompra_asistenciasviajes))
    //                                             {

    //                                             }
    //                                             else
    //                                             {

    //                                             }
    //                                     }
    //                                     else
    //                                     {
    //                                         echo 'Insercion de Emision de Precompra';
    //                                         echo $insert_emision_precompra;
    //                                     }
    //                                 }
    //                             }
                                
    //                             $idprecompra = $registro['idprecompra'];
    //                         }

    //                         if($cargamanual)
    //                         {
    //                             $contador_cargas_manuales++;
    //                         }
    //                         if($total)
    //                         {
    //                             $contador_ordenes_con_total_en_cero++;
    //                         }
    //                         else
    //                         {
    //                             echo 'fechadesde:'. $registro['fechadesde'];
    //                             echo 'fechadesde:'. $registro['fechadesde'];
    //                             echo 'fechahasta:'. $registro['fechahasta'];
    //                             echo 'fechahasta:'. $registro['fechahasta'];
    //                             echo 'destinos:'. $registro['destinos'];
    //                             echo 'idcategoria:'. $registro['idcategoria'];
    //                             echo 'idplan:'. $registro['idplan'];
    //                             echo 'asistencia rechazada';
    //                             echo $insert_precompra; 
    //                             $contador_asistencias_rechazadas++;
    //                         }
    //                     }
    //                 }
    //             }
    //             else
    //             {
    //                 echo 'insert rechazado';
    //                 echo $insert;
    //             }
    //         }
    //         else
    //         {
    //             if($registro['idagencia'] == 0)
    //             {
    //                 $contador_ordenes_con_agencia_cero++;
    //             }  
                
    //             if($registro['emisioncorporativa'] == 1 && $registro['fechadesde'] != '0000-00-00')
    //             {
    //                 $contador_ordenes_corporativas_no_validas++;
    //             }
    //         }
    //     }

    //     $secuencia = $idorden + 1;
    //     $secuencia = "ALTER SEQUENCE ordenes_idorden_seq RESTART WITH ".$secuencia; 
    //     ejecuta_select($db_postgresql, $secuencia);

    //     $secuencia = $idbeneficiario + 1;
    //     $secuencia = "ALTER SEQUENCE beneficiarios_idbeneficiario_seq RESTART WITH ".$secuencia; 
    //     ejecuta_select($db_postgresql, $secuencia);
    
    // // CRUCEROS ORDENES *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: crucerosordenes';
    //     $mysql_cruceros_ordenes = $db_mysql->query("SELECT id, COALESCE(id_order, 0) as id_order, COALESCE(id_cruise, 0) as id_cruise, confirmacion FROM cruise_order ORDER BY id ASC");

    //     while ($row = $mysql_cruceros_ordenes->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $cruceros_ordenes[] = $row;
    //     }

    //     foreach($cruceros_ordenes as $cruceroorden)
    //     {
    //         echo '.';
            
    //         $idcruceroorden = $cruceroorden['id'];
    //         $idcrucero      = $cruceroorden['id_cruise'];
    //         $idorden        = $cruceroorden['id_order'];
    //         $confirmacion   = $cruceroorden['confirmacion'];
        
    //         if($idcrucero != 0 && $idorden != 0)
    //         {
    //             $insert     = "INSERT INTO crucerosordenes (
    //                                     idcruceroorden,
    //                                     idcrucero, 
    //                                     idorden,
    //                                     confirmacion
    //                                 )
    //                             VALUES
    //                                 (
    //                                     $idcruceroorden,
    //                                     $idcrucero, 
    //                                     $idorden, 
    //                                     '$confirmacion'
    //                                 )";
    
    //             if(!ejecuta_insert($db_postgresql, $insert)) echo $insert;
    //         }
    //     }

    $ordenes_insertadas    = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM ordenes", 'cantidad');
  
    $hora_fin   = date('h:i:s', time());  

    // echo '
    // Inicio: '.$hora_inicio.'  
    // Fin: '.$hora_fin .'
    // // Ordenes Procesadas: '.$contador_ordenes.'
    // // Ordenes Insertadas: '.$ordenes_insertadas.'
    // // Asistencias Viajes insertadas: '.$contador_asistencias_viajes_insertadas.'
    // // Asistencias manuales: '.$contador_cargas_manuales.'
    // // Asistencias con total en cero: '.$contador_ordenes_con_total_en_cero.'
    // // Asistencias con agencias en cero: '.$contador_ordenes_con_agencia_cero.'
    // // Ordenes de emisiones corporativas: '.$contador_ordenes_corporativas.'
    // // Ordenes corporativas no válidas (por esemisioncorporativa en true y fecha diferentes a 0000-00-00): '.$contador_ordenes_corporativas_no_validas.'
    // // Corporativos Insertados: '.$contador_corporativos.'
    // // Beneficiarios Viajes Insertados: '.$contador_beneficiarios_viajes_insertados.'
    // // Beneficiarios Viajes Corporativos Insertados: '.$contador_beneficiarios_viajes_corporativos_insertados.'
    // // Contador de Emisiones de Precompra: '.$contador_emisiones_precompras.'
    // // ';

    echo $planes['cantidad'].' Planes migrados exitosamente !';
    echo 'Proceso Finalizado Exitosamente !'; 
?>
