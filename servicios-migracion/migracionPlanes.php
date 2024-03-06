<?php 
    $db_postgresql      = getDB();
    $db_mysql           = connect_db();

    $hora_inicio = date('h:i:s', time());

    $limpiar_tablas = false;

    if($limpiar_tablas)
    {
        /*** CUIDADO, SOLO INCLUIR $db_postgresql ***********************************************************/
        /**/ 
        /**/ 

        echo 'Borrando cuponesplanes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE cuponesplanes CASCADE");

        echo 'Borrando planesbeneficios...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficios CASCADE");

        echo 'Borrando planesbeneficiosproveedores...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficiosproveedores CASCADE");

        echo 'Borrando planesbeneficiosadicionales...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficiosadicionales CASCADE");

        echo 'Borrando planesbeneficiosadicionalesproveedores...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficiosadicionalesproveedores CASCADE");

        echo 'Borrando planesprecios...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesprecios CASCADE");

        echo 'Borrando planescostos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planescostos CASCADE");

        echo 'Borrando planesagencias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesagencias CASCADE");

        echo 'Borrando planespaises...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planespaises CASCADE");

        echo 'Borrando planesfuentes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesfuentes CASCADE");

        echo 'Borrando planesorigenes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesorigenes CASCADE");

        echo 'Borrando planesdestinos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesdestinos CASCADE");

        echo 'Borrando planes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planes CASCADE");

        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cuponesplanes_idcuponplan_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planes_idplan_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesprecios_idplanprecio_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planescostos_idplancosto_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesagencias_idplanesagencias_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesbeneficios_idplanbeneficio_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesbeneficiosadicionales_idplanbeneficioadicional_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesbeneficiosadicionalesproveedores_idplanbeneficioadicionalproveedor_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planespaises_idplanpais_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesfuentes_idplanfuente_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesorigenes_idplanorigen_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesdestinos_idplandestino_seq RESTART WITH 1");
    }

    // PLANES *******************************************************************************************************************************************************************************
        echo 'Migrando Planes ';
        
        $last_id_plan = ejecuta_select($db_postgresql, 'SELECT MAX(idplan) as idplan FROM planes ORDER BY idplan DESC', 'idplan');

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
                                                WHERE 1 = 1
                                                AND id > $last_id_plan
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
            $familiaplan                                = $plan['description'];
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
            $idpopularidad                              = $plan['id_popularidad'];
            $edadmaximabeneficioadic                    = $plan['max_age_ben_adic'];
            $descripcionplan                            = '';
            $descripcionplanen                          = '';
            $idtipoasistencia                           = 1;
            $fechaactualizacionprecioscostos            = '2000-01-01 00:00:00';
            $fechaactualizacionbeneficios               = '2000-01-01 00:00:00';
            $fechaactualizacionbeneficiosadicionales    = '2000-01-01 00:00:00';
            $fechaactualizacionbeneficiosproveedores    = '2000-01-01 00:00:00';
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
                                        publico,
                                        familiaplan)
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
                                        '$publico',
                                        UPPER('$familiaplan')
                                        )";

            if(ejecuta_insert($db_postgresql, $insert))
            {
                $mysql_precios  = array();
                $precios        = array();

                // PRECIOS
                    $select = "SELECT * FROM precios WHERE id_plan = '$idplan' ORDER BY id ASC";

                    $mysql_precios = $db_mysql->query($select);

                    while ($row_precio = $mysql_precios->fetch_array(MYSQLI_ASSOC)) 
                    { 
                        $precios[] = $row_precio; 
                    }

                    if(count($precios) > 0)
                    {
                        foreach($precios as $registro)
                        {    
                            $dia        = $registro['dias'];
                            $precio     = $registro['precio'];
                            $costo1     = $registro['costo1'];
                            $costo2     = $registro['costo2'];
        
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
                                                            '2000-01-01 00:00:00'
                                                        )";
        
                            if(ejecuta_insert($db_postgresql, $insert))
                            {
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
                                                            '2000-01-01 00:00:00'
                                                        );";
            
                                    if(ejecuta_insert($db_postgresql, $insert))
                                    {

                                    }
                                    else
                                    {
                                        echo $insert;
                                    }
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
                                                            '2000-01-01 00:00:00'
                                                        );";
                                                        
                                    if(ejecuta_insert($db_postgresql, $insert))
                                    {

                                    }
                                    else
                                    {
                                        echo $insert;
                                    }
                                }
                            }
                            else
                            {
                                echo $insert;
                            }

                            
                        }
                    }
            }
            else
            {
                echo 'El plan '.$idplan.' ha tenido un problema para ser migrado';
            }
        }

        $secuencia = $idplan + 1;
        $secuencia = "ALTER SEQUENCE planes_idplan_seq RESTART WITH ".$secuencia; 
        ejecuta_select($db_postgresql, $secuencia);

    // PLANES AGENCIAS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: Planes Agencias';

        $mysql_planes_agencias = $db_mysql->query("SELECT 
                                                    DISTINCT producto, 
                                                    programaplan, 
                                                    agencia 
                                                FROM orders 
                                                    JOIN plans ON plans.id = orders.producto 
                                                    JOIN broker ON broker.id_broker = orders.agencia 
                                                WHERE 1 = 1
                                                AND plans.id > $last_id_plan
                                                ORDER BY producto, agencia ASC");

        while ($row = $mysql_planes_agencias->fetch_array(MYSQLI_ASSOC)) 
        {
            $planes_agencias[] = $row;
        }

        foreach($planes_agencias as $plan_agencia)
        {
            echo '.';

            $idplan          = $plan_agencia['producto'];
            $idagencia       = $plan_agencia['agencia'];
            $idcategoria     = $plan_agencia['programaplan'];

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

            $existe_comision  = ejecuta_select($db_postgresql, "SELECT idcomisiones FROM comisionesagencias WHERE idagencia = $idagencia AND idcategoria = $idcategoria");


            if($existe_comision['cantidad'] == 0)
            {
                $mysql_comisiones = $db_mysql->query("SELECT porcentaje FROM commissions WHERE id_categoria = $idcategoria AND id_agencia = $idagencia LIMIT 1");

                while ($row = $mysql_comisiones->fetch_array(MYSQLI_ASSOC)) 
                {
                    $comisiones[] = $row;
                }

                foreach($comisiones as $comision)
                {
                    $porcentaje = $comision['porcentaje'];

                    $insert     = "INSERT INTO comisionesagencias (
                                            idagencia, 
                                            idcategoria, 
                                            idplan,
                                            comision
                                        )
                                    VALUES
                                        (
                                            $idagencia, 
                                            $idcategoria, 
                                            NULL,
                                            $porcentaje
                                        )";

                    ejecuta_insert($db_postgresql, $insert);
                }

                $comisiones = array();
            }
        }

    // PLANES PAISES *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: Planes Paises';

        $mysql_planes_paises = $db_mysql->query("SELECT 
                                                    DISTINCT producto as idplan, 
                                                    plans.id_site as idpais 
                                                FROM orders 
                                                    JOIN plans ON plans.id = orders.producto 
                                                WHERE 1 = 1
                                                AND producto > $last_id_plan
                                                ORDER BY producto ASC");

        while ($row = $mysql_planes_paises->fetch_array(MYSQLI_ASSOC)) 
        {
            $planes_paises[] = $row;
        }

        foreach($planes_paises as $plan_pais)
        {
            echo '.';

            $idplan  = $plan_pais['idplan'];
            $idpais  = $plan_pais['idpais'];

            $insert     = "INSERT INTO planespaises (
                                    idplan, 
                                    idpais
                                )
                            VALUES
                                (
                                    $idplan, 
                                    $idpais
                                )";

            if(ejecuta_insert($db_postgresql, $insert))
            {

            }
            else
            {
                echo $insert;
            }
        }


    //PLANES FUENTES *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: Planes Fuentes';

        $mysql_planes = $db_mysql->query("SELECT 
                                            DISTINCT producto as idplan 
                                        FROM orders
                                        WHERE 1 = 1
                                        AND producto > $last_id_plan 
                                        ORDER BY producto ASC");

        while ($row = $mysql_planes->fetch_array(MYSQLI_ASSOC)) 
        {
            $planes_fuentes[] = $row;
        }

        foreach($planes_fuentes as $plan)
        {
            echo '.';

            $idplan  = $plan['idplan'];

            $insert     = "INSERT INTO planesfuentes (
                                    idplan, 
                                    idfuente
                                )
                            VALUES
                                (
                                    $idplan, 
                                    1
                                )";

            if(ejecuta_insert($db_postgresql, $insert))
            {

            }
            else
            {
                echo $insert;
            }

        }

    //PLANES ORIGENES Y DESTINOS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: Planes Origenes y Planes Destinos';

        $mysql_planes_origenes = $db_mysql->query("SELECT 
                                                        DISTINCT producto as idplan 
                                                    FROM orders 
                                                    WHERE 1 = 1
                                                    AND producto > $last_id_plan
                                                    ORDER BY producto ASC");

        while ($row = $mysql_planes_origenes->fetch_array(MYSQLI_ASSOC)) 
        {
            $planes_origenes[] = $row;
        }

        $origenes = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE origenpermitido = true");
        $destinos = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE destinopermitido = true");

        foreach($planes_origenes as $plan)
        {
            echo '.';
            $idplan  = $plan['idplan'];

            foreach($origenes['resultado'] as $origen)
            {
                $idpais     = $origen['idpais'];
    
                $insert     = "INSERT INTO planesorigenes (
                                        idplan, 
                                        idpais
                                    )
                                VALUES
                                    (
                                        $idplan, 
                                        $idpais
                                    )";
    
                if(ejecuta_insert($db_postgresql, $insert))
                {

                }
                else
                {
                    echo $insert;
                }
            }

            foreach($destinos['resultado'] as $destino)
            {
                $idpais     = $destino['idpais'];
    
                $insert     = "INSERT INTO planesdestinos (
                                        idplan, 
                                        idpais
                                    )
                                VALUES
                                    (
                                        $idplan, 
                                        $idpais
                                    )";
    
                if(ejecuta_insert($db_postgresql, $insert))
                {

                }
                else
                {
                    echo $insert;
                }
            }
        }

       
    // PLANES BENEFICIOS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: planesbeneficios';

        $mysql = $db_mysql->query("SELECT DISTINCT beneficios_costo.id_plan, 
                                            beneficios_costo.id_beneficio, 
                                            CAST(CONVERT(beneficios_costo.valor  USING utf8) AS binary) as cobertura,
                                            CAST(CONVERT(beneficios_costo.language_id  USING utf8) AS binary) as coberturaen
                                            FROM beneficios_costo 
                                                JOIN plans ON plans.id = beneficios_costo.id_plan 
                                                JOIN beneficios ON beneficios.id_beneficio = beneficios_costo.id_beneficio 
                                            WHERE beneficios.language_id = 'spa' 
                                            AND plans.id > $last_id_plan
                                            ORDER BY id_plan ASC");

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $planesbeneficios[] = $row;
        }

        foreach($planesbeneficios as $planbeneficio)
        {
            echo '.';

            $idplan          = $planbeneficio['id_plan'];
            $idbeneficio     = $planbeneficio['id_beneficio'];
            $cobertura       = $planbeneficio['cobertura'];
            $coberturaen     = $planbeneficio['coberturaen'];

            $insert     = "INSERT INTO planesbeneficios (
                                    idplan, 
                                    idbeneficio,
                                    cobertura,
                                    coberturaen,
                                    fechaactualizacion
                                )
                            VALUES
                                (
                                    $idplan, 
                                    $idbeneficio,
                                    '$cobertura',
                                    '$coberturaen',
                                    '2000-01-01 00:00:00'
                                )";

            if(ejecuta_insert($db_postgresql, $insert))
                {
                    $idplanbeneficio = select_max_id($db_postgresql, 'idplanbeneficio', 'planesbeneficios');

                    $insert     = "INSERT INTO planesbeneficiosproveedores (
                                            idplanbeneficio, 
                                            idproveedor,
                                            porcentajeriesgo,
                                            fechaactualizacion
                                        )
                                    VALUES
                                        (
                                            $idplanbeneficio, 
                                            1,
                                            100,
                                            '2000-01-01 00:00:00'
                                        )";

                    ejecuta_insert($db_postgresql, $insert);
                }
        }


    // PLANES BENEFICIOS ADICIONALES *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: planesbeneficiosadicionales';

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
                                            AND beneficios_plus.id_plan > $last_id_plan
                                            AND beneficios_plus.id_beneficio IN (35,36,37)
                                            ORDER BY beneficios_plus.id ASC");

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $planesbeneficiosadicionales[] = $row;
        }

        foreach($planesbeneficiosadicionales as $planbeneficioadicional)
        {
            echo '.';

            $idplan                     = $planbeneficioadicional['idplan'];
            $idbeneficioadicional       = $planbeneficioadicional['idbeneficioadicional'];
            $factorconversion           = $planbeneficioadicional['factorconversion'];
            $factorconversionedad       = $planbeneficioadicional['factorconversionedad'];
            $factorconversionfamiliar   = $planbeneficioadicional['factorconversionfamiliar'];
            $cobertura                  = $planbeneficioadicional['cobertura'];
            $coberturaen                = $planbeneficioadicional['coberturaen'];
            $orden                      = $planbeneficioadicional['orden'];
            $fechaactualizacion         = $planbeneficioadicional['fechaactualizacion'];

            $insert     = "INSERT INTO planesbeneficiosadicionales (
                                    idplan, 
                                    idbeneficioadicional,
                                    factorconversion,
                                    factorconversionedad,
                                    factorconversionfamiliar,
                                    cobertura,
                                    coberturaen,
                                    orden,
                                    fechaactualizacion
                                )
                            VALUES
                                (
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

            if(ejecuta_insert($db_postgresql, $insert))
            {
                $idplanbeneficioadicional = select_max_id($db_postgresql, 'idplanbeneficioadicional', 'planesbeneficiosadicionales');

                $insert_beneficiosadicionalesproveedores     = "INSERT INTO planesbeneficiosadicionalesproveedores (
                                                                        idplanbeneficioadicional, 
                                                                        idproveedor,
                                                                        porcentajeriesgo
                                                                    )
                                                                VALUES
                                                                    (
                                                                        $idplanbeneficioadicional, 
                                                                        2,
                                                                        100
                                                                    )";

                if(ejecuta_insert($db_postgresql, $insert_beneficiosadicionalesproveedores))
                {

                }
                else
                {
                    echo $insert;
                }
            }
        }

    // CUPONES PLANES *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: cuponesplanes';

        $mysql = $db_mysql->query("SELECT 
                                        DISTINCT plans_category_coupons.id_plan, 
                                        plans_category_coupons.id_cupon 
                                    FROM plans_category_coupons 
                                        JOIN plans on plans.id = plans_category_coupons.id_plan 
                                        JOIN coupons on coupons.id = plans_category_coupons.id_cupon 
                                    WHERE 1 = 1
                                    AND plans.id > $last_id_plan
                                    ORDER BY plans_category_coupons.id_plan_categoria ASC");

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

            if(ejecuta_insert($db_postgresql, $insert))
            {

            }
            else
            {
                echo $insert;
            }
        }
  
    $hora_fin   = date('h:i:s', time());  

    echo $planes['cantidad'].' Planes migrados exitosamente !';
    echo 'Proceso Finalizado Exitosamente !'; 
?>
