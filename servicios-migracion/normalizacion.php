<?php 
    include('./lib/funciones.php');
    include('./lib/mysql.php');
    include('./lib/pgsql.php');

    system ('clear');

    $db_postgresql      = getDB();
    $db_mysql           = connect_db();

    $hora_inicio            = date('h:i:s', time());
    $fecha_hoy              = date('Y-m-d h:i:s', time());
    $planes_normalizados        = 0;
    $agencias_normalizadas      = 0;

    $incluir_usuarios_claves = false;

    echo '
            Inicio: '.$hora_inicio.' 
    ';

//     if($incluir_usuarios_claves)
//     {
//         // NORMALIZACIÓN DE USUARIOS CLAVES (PROGRAMADORES)
//             $update = "UPDATE usuarios SET idtipousuario = 0 WHERE idusuario = 3071";
//             ejecuta_update($db_postgresql, $update);
    
//             $insert = "INSERT INTO usuarios (nombreusuario, apellidousuario, idstatus, idtipousuario, idagencia, aliasusuario, contrasena, correo, telefono, escorporativo, fechacreacion, fechamodificacion, fechacambiarcontrasena, cambiarcontrasena, ididioma, ipremota, conectado, soloconexionlocal, ultimaconexion, incentivo, banco, clabeinterbancaria, beneficiario, cuenta, idcorporativo, whatsapp, facebook, twitter, recuperacion) VALUES('Andrés', 'Olan', 1, 0, 174, 'Andrés Olan', '4ndr3s2022', 'aolan@continentalassist.com', '777777', false, '2015-09-03 00:00:00', '2015-11-26 00:00:00', '2021-01-01 00:00:00', false, 1, '0.0.0.0', false, false, '2022-02-25 10:07:08', 0, '', '', '', '', 0, '', '', '', '')";
//             ejecuta_insert($db_postgresql, $insert);
    
//             $insert = "INSERT INTO usuarios (nombreusuario, apellidousuario, idstatus, idtipousuario, idagencia, aliasusuario, contrasena, correo, telefono, escorporativo, fechacreacion, fechamodificacion, fechacambiarcontrasena, cambiarcontrasena, ididioma, ipremota, conectado, soloconexionlocal, ultimaconexion, incentivo, banco, clabeinterbancaria, beneficiario, cuenta, idcorporativo, whatsapp, facebook, twitter, recuperacion) VALUES('Reynaldo', 'Guzmán', 1, 0, 174, 'Reynaldo Guzmán', 'r3yn4ld02022', 'rguzman@continentalassist.com', '777777', false, '2015-09-03 00:00:00', '2015-11-26 00:00:00', '2021-01-01 00:00:00', false, 1, '0.0.0.0', false, false, '2022-02-25 10:07:08', 0, '', '', '', '', 0, '', '', '', '')";
//             ejecuta_insert($db_postgresql, $insert);
    
//             $insert = "INSERT INTO usuarios (nombreusuario, apellidousuario, idstatus, idtipousuario, idagencia, aliasusuario, contrasena, correo, telefono, escorporativo, fechacreacion, fechamodificacion, fechacambiarcontrasena, cambiarcontrasena, ididioma, ipremota, conectado, soloconexionlocal, ultimaconexion, incentivo, banco, clabeinterbancaria, beneficiario, cuenta, idcorporativo, whatsapp, facebook, twitter, recuperacion) VALUES('Fernando', 'Acevedo', 1, 0, 174, 'Fernando Acevedo', 'F3rn4nd02022', 'facevedo@continentalassist.com', '777777', false, '2015-09-03 00:00:00', '2015-11-26 00:00:00', '2021-01-01 00:00:00', false, 1, '0.0.0.0', false, false, '2022-02-25 10:07:08', 0, '', '', '', '', 0, '', '', '', '')";
//             ejecuta_insert($db_postgresql, $insert);
//     }

    // NORMALIZA IDSTATUS DE CUPONES (MIGRARON SOLO CUPONES)
        $update = "UPDATE cupones SET idstatus = 4 WHERE idstatus = 0";
        ejecuta_update($db_postgresql, $update);

    // NORMALIZA IDSTATUS DE asistenciascorporativasviajes
        $update = "UPDATE asistenciascorporativasviajes SET idstatus = 4 WHERE idstatus = 0";
        ejecuta_update($db_postgresql, $update);

    // NORMALIZA IDSTATUS DE USUARIOS
        $update = "UPDATE usuarios SET idstatus = 2 WHERE idstatus = 0";
        ejecuta_update($db_postgresql, $update);


    // NORMALIZACION DE CATEGORIAS DE AGENCIAS
        $update = "UPDATE categorias SET publico = true WHERE idcategoria in (22,23,24,27)";
        ejecuta_update($db_postgresql, $update);

        $select_agencias ="SELECT idagencia from agencias where idagencia not in (SELECT idagencia from categoriasagencias)"; 
        $agencias = ejecuta_select($db_postgresql, $select_agencias);

        $select_categorias ="SELECT idcategoria from categorias where publico = true"; 
        $categorias = ejecuta_select($db_postgresql, $select_categorias);

        if($agencias['cantidad'] > 0)
        {
            $insert = "INSERT INTO categoriasagencias ( idagencia, idcategoria ) VALUES ";

            $array_valores = array();
            foreach($agencias['resultado'] as $agencia)
            {
                $idagencia = $agencia['idagencia'];

                foreach($categorias['resultado'] as $categoria)
                {
                    $idcategoria = $categoria['idcategoria'];

                    $valor = "( $idagencia, $idcategoria )";
                    array_push($array_valores, $valor);
                }
                
                $agencias_normalizadas++;
            }

            if(count($array_valores) > 0)
            {
                $valores      = implode(",",$array_valores);
                $insert       = $insert.$valores;

                ejecuta_insert($db_postgresql, $insert);
            }
        }
        else
        {
            echo '
            No se encontraron agencias sin categorias asignadas
            ';
        }

    // NORMALIZACION DE PLANES DE AGENCIAS
        $select_agencias ="SELECT idagencia, idpais FROM agencias where idagencia NOT IN (SELECT idagencia FROM planesagencias)"; 
        $agencias = ejecuta_select($db_postgresql, $select_agencias);

        if($agencias['cantidad'] > 0)
        {
            $insert = "INSERT INTO planesagencias ( idagencia, idplan ) VALUES ";

            $array_valores = array();
            foreach($agencias['resultado'] as $agencia)
            {
                $idagencia  = $agencia['idagencia'];
                $idpais     = $agencia['idpais'];

                if(isset($idpais))
                {
                    $select_planes ="SELECT idplan FROM planes where publico = true AND idplan IN (SELECT idplan FROM planespaises WHERE idpais = $idpais) AND idstatus = 1"; 
                    $planes = ejecuta_select($db_postgresql, $select_planes);

                    if($planes['cantidad'] > 0)
                    {
                        foreach($planes['resultado'] as $plan)
                        {
                            $idplan = $plan['idplan'];

                            $valor = "( $idagencia, $idplan )";

                            array_push($array_valores, $valor);
                        }
                    }
                    else
                    {
                        $nombrepais = ejecuta_select($db_postgresql, "SELECT nombrepais FROM paises WHERE idpais = $idpais", "nombrepais");
                        echo '
                        '.$nombrepais.' no tiene planes públicos
                        ';
                    }
                }
                else
                {
                    echo 'La agencia '.$idagencia.' no tiene país asignado
                    ';
                }

                $agencias_normalizadas++;
            }

            if(count($array_valores) > 0)
            {
                $valores      = implode(",",$array_valores);
                $insert       = $insert.$valores;

                ejecuta_insert($db_postgresql, $insert);
            }
        }
        else
        {
            echo '
            No se encontraron agencias sin planes asignados
            ';
        }

    // NORMALIZACION DE COMISIONES DE AGENCIAS
        $select_agencias ="SELECT idagencia FROM agencias WHERE idagencia NOT IN (SELECT idagencia from comisionesagencias)"; 
        $agencias = ejecuta_select($db_postgresql, $select_agencias);

        if($agencias['cantidad'] > 0)
        {
            foreach($agencias['resultado'] as $agencia)
            {
                // echo '.';

                $idagencia = $agencia['idagencia'];

                $categorias = ejecuta_select($db_postgresql, "SELECT planes.idcategoria FROM planesagencias left join planes on planesagencias.idplan = planes.idplan WHERE idagencia = $idagencia GROUP BY 1");

                $mysql_comisiones = $db_mysql->query("SELECT id_categoria, porcentaje FROM commissions WHERE id_agencia = $idagencia");

                if($mysql_comisiones->num_rows > 0)
                {
                    while ($row = $mysql_comisiones->fetch_array(MYSQLI_ASSOC)) 
                    {
                        $comisiones[] = $row;
                    }

                    $insert = "INSERT INTO comisionesagencias ( idagencia, idcategoria, comision ) VALUES ";

                    $array_valores = array();
                    foreach($categorias['resultado'] as $categoria)
                    {
                        $idcategoria = $categoria['idcategoria'];
                        
                        foreach($comisiones as $comision)
                        {
                            // echo $comision['id_categoria']; 
                            // echo $comision['porcentaje']; 
                            // exit;
                            // print_r($comision); exit;

                            $porcentaje_comision = $comision['porcentaje'];

                            if($comision['id_categoria'] == $idcategoria)
                            {
                                $valor = "( $idagencia, $idcategoria, $porcentaje_comision )";

                                array_push($array_valores, $valor);
                            }
                        }
                    }

                    if(count($array_valores) > 0)
                    {
                        $valores      = implode(",",$array_valores);
                        $insert       = $insert.$valores;
    
                        ejecuta_insert($db_postgresql, $insert);
                    }

                    $comisiones = array();

                    $agencias_normalizadas++;
                }
                else
                {
                    echo '
                    No existen comisiones creadas para la agencia: '.$idagencia.'
                    ';
                }
            }
        }
        else
        {
            echo '
            No se encontraron agencias sin comisiones de planes asignados
            ';
        }







// // PLANES 




    // NORMALIZACION DE ASIGNACION DE FUENTES DE LOS PLANES
        $select_planes ="SELECT idplan from planes p1 where idplan not in (SELECT idplan from planesfuentes p2) and p1.idstatus = 1"; 
        $planes = ejecuta_select($db_postgresql, $select_planes);

        if($planes['cantidad'] > 0)
        {
            $insert = "INSERT INTO planesfuentes ( idplan, idfuente ) VALUES "; 

            $array_valores = array();
            foreach($planes['resultado'] as $plan)
            {
                $idplan = $plan['idplan'];

                $valor = "( $idplan, 1 )";
                array_push($array_valores, $valor);
            }

            if(count($array_valores) > 0)
            {
                $valores      = implode(",",$array_valores);
                $insert       = $insert.$valores;

                ejecuta_insert($db_postgresql, $insert);
            }
        }
        else
        {
            echo '
            No se encontraron planes sin fuentes asignadas
            ';
        }

    // NORMALIZACION DE ASIGNACION DE PAISES DE LOS PLANES
        $select_planes = "SELECT idplan from planes p1 where idplan not in (SELECT idplan from planespaises p2) and p1.idstatus = 1"; 
        $planes = ejecuta_select($db_postgresql, $select_planes);

        if($planes['cantidad'] > 0)
        {
            $insert = "INSERT INTO planespaises ( idplan, idpais ) VALUES "; 

            $array_valores = array();
            foreach($planes['resultado'] as $plan)
            {
                $idplan = $plan['idplan'];

                $mysql_idpais = $db_mysql->query("SELECT id_site FROM plans WHERE id = $idplan");

                $row    = $mysql_idpais->fetch_array(MYSQLI_ASSOC);
                $idpais = $row['id_site'];
                
                $valor  = "( $idplan, $idpais )";
                array_push($array_valores, $valor);
            }

            if(count($array_valores) > 0)
            {
                $valores      = implode(",",$array_valores);
                $insert       = $insert.$valores;

                ejecuta_insert($db_postgresql, $insert);
            }
        }
        else
        {
            echo '
            No se encontraron planes sin paises asignadas
            ';
        }

    // NORMALIZACION DE ASIGNACION DE ORIGENES DE LOS PLANES
        $select_planes = "SELECT idplan from planes p1 where idplan not in (SELECT idplan from planesorigenes p2) and p1.idstatus = 1"; 
        $planes = ejecuta_select($db_postgresql, $select_planes);

        if($planes['cantidad'] > 0)
        {
            $select_paises = "SELECT idpais from paises where origenpermitido = true"; 
            $paises = ejecuta_select($db_postgresql, $select_paises);

            $insert = "INSERT INTO planesorigenes ( idplan, idpais ) VALUES "; 

            $array_valores = array();
            foreach($planes['resultado'] as $plan)
            {
                $idplan = $plan['idplan'];

                foreach($paises['resultado'] as $pais)
                {
                    $idpais = $pais['idpais'];
                }

                $valor = "( $idplan, $idpais )";
                array_push($array_valores, $valor);
                
            }

            if(count($array_valores) > 0)
            {
                $valores      = implode(",",$array_valores);
                $insert       = $insert.$valores;

                ejecuta_insert($db_postgresql, $insert);
            }
        }
        else
        {
            echo '
            No se encontraron planes sin origenes asignadas
            ';
        }

    // NORMALIZACION DE ASIGNACION DE DESTINOS DE LOS PLANES
        $planes = ejecuta_select($db_postgresql, "SELECT idplan from planes p1 where idplan not in (SELECT idplan from planesdestinos p2) and p1.idstatus = 1");

        if($planes['cantidad'] > 0)
        {
            $paises = ejecuta_select($db_postgresql, "SELECT idpais from paises where destinopermitido = true");

            $insert = "INSERT INTO planesdestinos ( idplan, idpais ) VALUES "; 

            $array_valores = array();
            foreach($planes['resultado'] as $plan)
            {
                $idplan = $plan['idplan'];

                foreach($paises['resultado'] as $pais)
                {
                    $idpais = $pais['idpais'];

                    $valor =  "( $idplan, $idpais )";

                    array_push($array_valores, $valor);
                }
            }

            if(count($array_valores) > 0)
            {
                $valores      = implode(",",$array_valores);
                $insert       = $insert.$valores;

                ejecuta_insert($db_postgresql, $insert);
            }
        }
        else
        {
            echo '
            No se encontraron planes sin origenes asignadas
            ';
        }

    // NORMALIZACION BENEFICIOS ADICIONALES DE PLANES CON CATEGORIA ESTUDIANTES  *******************************************************************************************************************************************************************************
        $planes = ejecuta_select($db_postgresql, "SELECT idplan FROM planes WHERE idplan NOT IN (SELECT idplan FROM planesbeneficiosadicionales) AND idcategoria = 27 AND idstatus = 1");

        if($planes['cantidad'] > 0)
        {
            foreach($planes['resultado'] as $plan)
            {
                $idplan = $plan['idplan'];

                $insert = "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, 'USD 15.000', 'USD 15.000', 35, '$fecha_hoy' )";
                
                if(ejecuta_insert($db_postgresql, $insert))
                {
                    $update = "UPDATE planes SET fechaactualizacionbeneficiosadicionales = '$fecha_hoy' WHERE idplan = $idplan ";
                    ejecuta_update($db_postgresql, $update);

                    $select_idplanbeneficioadicional = "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy'";
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, $select_idplanbeneficioadicional, "idplanbeneficioadicional");

                    $insert = "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 2, 100)";
                    
                    if(ejecuta_insert($db_postgresql, $insert))
                    {
                        $planes_normalizados++;
                    }
                    else
                    {
                        echo $insert;
                    }
                }
                else
                {
                    echo $insert;
                }
            }
        }
        else
        {
            echo '
            No se encontraron planes con beneficios adicionales desactualizados - 
            ';
        }

    // NORMALIZACION BENEFICIOS ADICIONALES DE PLANES CON CATEGORIA ANUALES MULTIVIAJES  *******************************************************************************************************************************************************************************
        $planes                 = ejecuta_select($db_postgresql, "SELECT idplan, familiaplan FROM planes WHERE idplan NOT IN (SELECT idplan FROM planesbeneficiosadicionales) AND idcategoria IN (23) AND idstatus = 1");

        if($planes['cantidad'] > 0)
        {
            foreach($planes['resultado'] as $plan)
            {
                $idplan         = $plan['idplan'];
                $familiaplan    = trim($plan['familiaplan']);

                $coberturas     = ejecuta_select($db_postgresql, "SELECT cobertura, coberturaen FROM planesbeneficios WHERE idplan = $idplan AND idbeneficio = 1");
                $cobertura      = ($coberturas['cantidad'] > 0) ? $coberturas['resultado'][0]['cobertura'] : 'SIN ASIGNAR';
                $coberturaen    = ($coberturas['cantidad'] > 0) ? $coberturas['resultado'][0]['coberturaen'] : 'SIN ASIGNAR';

                if($familiaplan == 'GLOBAL')
                {
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 1.500', 'USD 1.500', 1, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 1.500', 'USD 1.500', 3, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
                }
                else if($familiaplan == 'TOTAL')
                {
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 3.000', 'USD 3.000', 1, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 3.000', 'USD 3.000', 3, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
                }
                else if($familiaplan == 'MAXIMUS')
                {
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 5.000', 'USD 5.000', 1, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 5.000', 'USD 5.000', 3, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
                }
                else if($familiaplan == 'SUPREME' || $familiaplan == 'SUMMIT' || $familiaplan == 'PREMIER' || $familiaplan == 'PRESTIGE')
                {
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 10.000', 'USD 10.000', 1, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 10.000', 'USD 10.000', 3, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
                }
                
                
                ejecuta_update($db_postgresql, "UPDATE planes SET fechaactualizacionbeneficiosadicionales = '$fecha_hoy' WHERE idplan = $idplan ");
            }
        }
        else
        {
            echo '
            No se encontraron planes con beneficios adicionales desactualizados 
            ';
        }

    // NORMALIZACION BENEFICIOS ADICIONALES DE PLANES CON CATEGORIA PLANES POR VIAJES  *******************************************************************************************************************************************************************************
        $planes                 = ejecuta_select($db_postgresql, "SELECT idplan, familiaplan FROM planes WHERE idplan NOT IN (SELECT idplan FROM planesbeneficiosadicionales) AND idcategoria IN (24) AND idstatus = 1");

        if($planes['cantidad'] > 0)
        {
            foreach($planes['resultado'] as $plan)
            {
                $idplan         = $plan['idplan'];
                $familiaplan    = trim($plan['familiaplan']);

                $coberturas     = ejecuta_select($db_postgresql, "SELECT cobertura, coberturaen FROM planesbeneficios WHERE idplan = $idplan AND idbeneficio = 1");
                $cobertura      = ($coberturas['cantidad'] > 0) ? $coberturas['resultado'][0]['cobertura'] : 'SIN ASIGNAR';
                $coberturaen    = ($coberturas['cantidad'] > 0) ? $coberturas['resultado'][0]['coberturaen'] : 'SIN ASIGNAR';

                if($familiaplan == 'GLOBAL')
                {
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 1.500', 'USD 1.500', 1, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 1.500', 'USD 1.500', 3, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
                }
                else if($familiaplan == 'TOTAL')
                {
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 3.000', 'USD 3.000', 1, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 3.000', 'USD 3.000', 3, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
                }
                else if($familiaplan == 'MAXIMUS')
                {
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 5.000', 'USD 5.000', 1, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 5.000', 'USD 5.000', 3, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
                }
                else if($familiaplan == 'SUPREME' || $familiaplan == 'SUMMIT' || $familiaplan == 'PREMIER' || $familiaplan == 'PRESTIGE')
                {
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 10.000', 'USD 10.000', 1, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 10.000', 'USD 10.000', 3, '$fecha_hoy' )");
                    $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
                    ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
                }
                
                ejecuta_update($db_postgresql, "UPDATE planes SET fechaactualizacionbeneficiosadicionales = '$fecha_hoy' WHERE idplan = $idplan ");
            }
        }
        else
        {
            echo '
            No se encontraron planes con beneficios adicionales desactualizados
            ';
        }


















        
//     // NORMALIZACION DE ASIGNACION DE CATEGORIA PUBLICAS  *******************************************************************************************************************************************************************************
//         $categorias_publicas = array(22,23,24,27);

//         $insert_categoriasagencias          = "INSERT INTO categoriasagencias ( idagencia, idcategoria ) VALUES ";
//         $array_valores_categoriasagencias   = array();

//         $insert_planesagencias              = "INSERT INTO planesagencias ( idagencia, idplan ) VALUES ";
//         $array_valores_planesagencias       = array();


//         foreach($categorias_publicas as $categoria_publica)
//         {
//             $agencias                 = ejecuta_select($db_postgresql, "SELECT idagencia, idpais
//                                                                         from agencias 
//                                                                         where idagencia not in (
//                                                                         select idagencia 
//                                                                         from categoriasagencias
//                                                                         where idcategoria in ($categoria_publica) )");

//             if($agencias['cantidad'] > 0)
//             {
//                 foreach($agencias['resultado'] as $agencia)
//                 {
//                     $idagencia          = $agencia['idagencia'];
//                     $idpais             = $agencia['idpais'];

//                     $valor_categoriasagencias = "( $idagencia, $categoria_publica) ";

//                     array_push($array_valores_categoriasagencias, $valor_categoriasagencias);

//                     $planes_publicos = ejecuta_select($db_postgresql, "SELECT planes.idplan 
//                                                                         FROM planes 
//                                                                         left join planespaises on planes.idplan = planespaises.idplan 
//                                                                         WHERE planes.publico = true 
//                                                                         AND planes.idcategoria = $categoria_publica
//                                                                         AND planespaises.idpais = $idpais;");

//                     if($planes_publicos['cantidad'] > 0)
//                     {
//                         foreach($planes_publicos['resultado'] as $plan_publico)
//                         {
//                             $idplan =  $plan_publico['idplan'];

//                             $cantidad = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planesagencias WHERE idagencia = $idagencia AND idplan = $idplan", "cantidad");

//                             if($cantidad == 0)
//                             {
//                                 $valor_planesagencias = "( $idagencia, $idplan )";
//                                 array_push($array_valores_planesagencias, $valor_planesagencias);
//                             }
//                         }
//                     }
//                 }
//             }
//             else
//             {
//                 echo '
// No se encontraron agencias sin la categoria '.$categoria_publica.' asignada...
// ';
//             }
//         }

//         if(count($array_valores_categoriasagencias) > 0)
//         {
//             $valores = implode(",", $array_valores_categoriasagencias);
//             $insert_categoriasagencias = $insert_categoriasagencias.$valores;
//             if(!ejecuta_insert($db_postgresql, $insert_categoriasagencias))
//             {
//                 echo $insert_categoriasagencias; exit;
//             }
//         }

//         if(count($array_valores_planesagencias) > 0)
//         {
//             $valores = implode(",", $array_valores_planesagencias);
//             $insert_planesagencias = $insert_planesagencias.$valores;
//             if(!ejecuta_insert($db_postgresql, $insert_planesagencias))
//             {
//                 echo $insert_planesagencias; exit;
//             }
//         }





//         // NORMALIZACION DE ASIGNACION DE PLANES PUBLICOS  *******************************************************************************************************************************************************************************

//         $insert_planesagencias              = "INSERT INTO planesagencias ( idagencia, idplan ) VALUES ";
//         $array_valores_planesagencias       = array();
        
//         $agencias                 = ejecuta_select($db_postgresql, "SELECT idagencia, idpais
//                                                                         from agencias 
//                                                                         where idagencia not in (
//                                                                             select idagencia 
//                                                                             from planesagencias
//                                                                         )
//                                                                     ");

//         if($agencias['cantidad'] > 0)
//         {
//             foreach($agencias['resultado'] as $agencia)
//             {
//                 $idagencia          = $agencia['idagencia'];
//                 $idpais             = $agencia['idpais'];

//                 $planes_publicos = ejecuta_select($db_postgresql, "SELECT planes.idplan 
//                                                                     FROM planes 
//                                                                     left join planespaises on planes.idplan = planespaises.idplan 
//                                                                     WHERE planes.publico = true 
//                                                                     AND planespaises.idpais = $idpais;");

//                 if($planes_publicos['cantidad'] > 0)
//                 {
//                     foreach($planes_publicos['resultado'] as $plan_publico)
//                     {
//                         $idplan =  $plan_publico['idplan'];
//                         $cantidad = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planesagencias WHERE idagencia = $idagencia AND idplan = $idplan", "cantidad");

//                         if($cantidad == 0)
//                         {
//                             $valor_planesagencias = "( $idagencia, $idplan )";
//                             array_push($array_valores_planesagencias, $valor_planesagencias);
//                         }
//                     }
//                 }
//             }
//         }
//         else
//         {
//             echo '
// No se encontraron agencias sin planes asignados...
// ';
//         }

//         if(count($array_valores_planesagencias) > 0)
//         {
//             $valores = implode(",", $array_valores_planesagencias);
//             $insert_planesagencias = $insert_planesagencias.$valores;
//             if(!ejecuta_insert($db_postgresql, $insert_planesagencias))
//             {
//                 echo $insert_planesagencias; exit;
//             }
//         }









    // NORMALIZACION DE ASOCIACION DE PLANES A LAS PRECOMPRAS EXISTENTES

        $cargas_precompras = ejecuta_select($db_postgresql, "SELECT ordenes.idorden, 
                                                                    precompras.idprecompra 
                                                                FROM ordenes 
                                                                LEFT JOIN precompras ON ordenes.idorden = precompras.idorden
                                                                WHERE ordenes.cargaprecompra = true");

        $insert = "INSERT INTO precomprasplanes (idprecompra, idplan) VALUES ";

        $array_valores = array();
        foreach($cargas_precompras['resultado'] as $carga_precompra)
        {
            $idprecompra    = $carga_precompra['idprecompra'];
            $idorden        = $carga_precompra['idorden'];

            $planes_asociados = ejecuta_select($db_postgresql, "SELECT * FROM precomprasplanes WHERE precomprasplanes.idprecompra = $idprecompra");

            if($planes_asociados['cantidad'] == 0)
            {
                $mysql_idplan   = $db_mysql->query("SELECT producto as idplan FROM orders WHERE id = $idorden");
                $row            = $mysql_idplan->fetch_array(MYSQLI_ASSOC);
                $idplan         = $row['idplan'];
                
                if($idplan)
                {
                    $valor = "($idprecompra, $idplan) ";

                    array_push($array_valores, $valor);
                }
            }
        }

        if(count($array_valores) > 0)
        {
            $valores      = implode(",",$array_valores);
            $insert       = $insert.$valores;

            ejecuta_insert($db_postgresql, $insert);
        }

        

    // NORMALIZACION DE LOGOS DE AGENCIAS

        $urllogosagencias               = ejecuta_select($db_postgresql, "SELECT valor FROM configuracion WHERE nombreconfiguracion = 'urllogosagencias' ", "valor");
        $normaliza_agencias_sin_logos   = ejecuta_update($db_postgresql, "UPDATE agencias SET logoagencia = '' WHERE logoagencia = '$urllogosagencias' ");

    // NORMALIZACION DE PLANFAMILIAR EN PLANES CORPORATIVOS

    $normaliza_plan_familiar_corporativos   = ejecuta_update($db_postgresql, "UPDATE planes SET planfamiliar = 'f' WHERE idcategoria = 14 ");


    // NORMALIZACION DE POPULARIDADES

        ejecuta_update($db_postgresql, "update planes set idpopularidad = 2");
        ejecuta_update($db_postgresql, "update planes set idpopularidad = 9 where familiaplan = 'TRAVELER'");
        ejecuta_update($db_postgresql, "update planes set idpopularidad = 8 where familiaplan = 'GLOBAL'");
        ejecuta_update($db_postgresql, "update planes set idpopularidad = 7 where familiaplan = 'TOTAL'");
        ejecuta_update($db_postgresql, "update planes set idpopularidad = 6 where familiaplan = 'MAXIMUS'");
        ejecuta_update($db_postgresql, "update planes set idpopularidad = 5 where familiaplan = 'SUPREME'");
        ejecuta_update($db_postgresql, "update planes set idpopularidad = 4 where familiaplan = 'SUMMIT'");

    // NORMALIZACION DE LOS DESTINOS DE LOS PLANES CONSUL 

        $planes = ejecuta_select($db_postgresql, "SELECT idplan from planes where nombreplan like '%CONSUL%' AND nombreplan not like '%CONSULTING%' AND nombreplan not like '%CONSULTORES%'");

        $insert = "INSERT INTO planesdestinos (idplan, idpais) VALUES ";

        $array_valores = array();
        foreach($planes['resultado'] as $plan)
        {
            $idplan = $plan['idplan'];

            ejecuta_delete($db_postgresql, "DELETE from planesdestinos WHERE idplan = $idplan");

            $paises_europeos = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE region like 'Europe'");

            foreach($paises_europeos['resultado'] as $pais_europeo)
            {
                $idpais = $pais_europeo['idpais'];

                $valor = " ($idplan, $idpais) ";
                array_push($array_valores, $valor);
            }
        }

        if(count($array_valores) > 0)
        {
            $valores      = implode(",",$array_valores);
            $insert       = $insert.$valores;

            ejecuta_insert($db_postgresql, $insert);
        }

    // NORMALIZACION DE LOS PORCENTAJES DE LOS BENEFICIOS 

        ejecuta_update($db_postgresql, "UPDATE planesbeneficiosadicionales SET factorconversion = '0.25' WHERE idbeneficioadicional = 35");
        ejecuta_update($db_postgresql, "UPDATE planesbeneficiosadicionales SET factorconversion = '0.5' WHERE idbeneficioadicional = 36");
        ejecuta_update($db_postgresql, "UPDATE planesbeneficiosadicionales SET factorconversion = '0.25' WHERE idbeneficioadicional = 37");
        
    // NORMALIZACION DEL STATUS POR ACTIVAR DE 2 a 9 
        ejecuta_update($db_postgresql, "UPDATE ordenes SET idstatus = 9 WHERE idstatus = 2");


    // ASOCIAR CATEGORIA COPORTIVOS A LAS AGENCIAS QUE TENGAN BOLSA DE DIAS COMPRADAS
        $categoriascorporativosasignadas = 0;
            
        $agencias = ejecuta_select($db_postgresql, "SELECT idagencia from corporativos where idcorporativo in (select 
                                                        ordenes.idcorporativo
                                                    from ordenes 
                                                    where emisioncorporativa = true
                                                    group by 1)
                                                    order by 1 ASC");

        $insert = "INSERT INTO categoriasagencias (idcategoria, idagencia) VALUES ";

        $array_valores = array();
        foreach($agencias['resultado'] as $agencia)
        {
            $idagencia = $agencia['idagencia'];

            $cantidad = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM categoriasagencias WHERE idcategoria = 14 AND idagencia = $idagencia", "cantidad");

            if($cantidad == 0)
            {
                $valor = "(14, $idagencia)";

                array_push($array_valores, $valor);

                $categoriascorporativosasignadas++;
            }
        }

        if(count($array_valores) > 0)
        {
            $valores      = implode(",",$array_valores);
            $insert       = $insert.$valores;

            ejecuta_insert($db_postgresql, $insert);
        }


        echo '
    categoriascorporativosasignadas: '.$categoriascorporativosasignadas.'

    ';

    // NORMALIZACION DE PLANES A LAS AGENCIAS QUE LOS HAYAN UTILIZADO

    $planesasociados = 0;

    echo '
    ASOCIAR PLANES A LAS AGENCIAS QUE LOS HAYAN UTILIZADO
 
 ';
 
 
 echo '
 Seleccionando Agencias...
 
 ';
     
         $array_agencias = array();
 
         $mysql_brokers = $db_mysql->query("SELECT id_broker as idagencia, id_site as idpais FROM broker ORDER BY id_broker ASC");
        
         if($mysql_brokers->num_rows > 0)
         {
             while ($row = $mysql_brokers->fetch_array(MYSQLI_ASSOC)) 
             {
                 $brokers[] = $row;
             }
 
             foreach($brokers as $broker)
             {
                 $idagencia  = $broker['idagencia'];
                 $idpais     = $broker['idpais'];
 
                 $agencia = ["idagencia" => $idagencia, "idpais" => $idpais, "planes" => array()];
 
                 array_push($array_agencias, $agencia);
             }
         }
 
 
         echo '
 Asociando Planes...
 ';
 
         $contador = 0;
         foreach($array_agencias as $agencia)
         {
             $idagencia = $agencia['idagencia'];
             
             $mysql_planes = $db_mysql->query("SELECT producto FROM orders WHERE agencia = $idagencia GROUP BY producto ORDER BY producto ASC");
 
             if($mysql_planes->num_rows > 0)
             {
                 while ($row_planes = $mysql_planes->fetch_array(MYSQLI_ASSOC)) 
                 {
                     $planes[] = $row_planes;
                 }
 
                 foreach($planes as $plan)
                 {
                     $id_plan = $plan['producto'];
 
                     array_push($array_agencias[$contador]['planes'], $id_plan);
                 }
             }
 
             $planes = array();
             $contador++;
         }
 
         echo '
 Insertando en planespaises...
 Insertando en planesagencias...
 
 ';
 
         $contador = 0;
         foreach($array_agencias as $agencia)
         {
             $idagencia  = $agencia['idagencia'];
             $idpais     = $agencia['idpais'];
             $planes     = $agencia['planes'];
 
             if($idpais == 0) $idpais = 283;
 
             foreach($planes as $idplan)
             {
                 if($idplan == 0) continue;
                 
                 $existe = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planespaises WHERE planespaises.idpais = $idpais AND planespaises.idplan = $idplan", "cantidad");
 
                 if($existe == 0)
                 {
                     ejecuta_insert($db_postgresql, "INSERT INTO planespaises (idpais, idplan) VALUES ($idpais, $idplan) ");
                     $planesasociados++;
                 }
 
                 $existe = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planesagencias WHERE planesagencias.idagencia = $idagencia AND planesagencias.idplan = $idplan", "cantidad");
 
                 if($existe == 0)
                 {
                     ejecuta_insert($db_postgresql, "INSERT INTO planesagencias (idagencia, idplan) VALUES ($idagencia, $idplan) ");
                     $planesasociados++;
                 }
             }
             $contador = 0;
         }
 
        echo '
Planes Asociados a las agencias que los hayan utilizado: '.$planesasociados.'
';
 
//         // NORMALIZACION DE ASIGNACION DE ORIGENES

//             $planesorigenasignado = 0;

//             $planes = ejecuta_select($db_postgresql, "SELECT idplan 
//                                                         from planes 
//                                                         where planes.idplan not in (select idplan from planesorigenes group by 1)");

//             $origenes = ejecuta_select($db_postgresql, "SELECT idpais from paises where origenpermitido = true order by 1");

//             if($planes['cantidad'] > 0)
//             {
//                 foreach($planes['resultado'] as $plan)
//                 {
//                     $idplan = $plan['idplan'];

//                     foreach($origenes['resultado'] as $origen )
//                     {
//                         $idpais = $origen['idpais'];

//                         ejecuta_insert($db_postgresql, "INSERT INTO planesorigenes (idplan, idpais) VALUES ($idplan, $idpais) ");
//                         $planesorigenasignado++;
//                     }
//                 }
//             }

//             echo '
// Planes-Origenes asignados: '. $planesorigenasignado.'
// '; 

//         // NORMALIZACION DE ASIGNACION DE DESTINOS

//             $planesdestinoasignado = 0;

//             $planes = ejecuta_select($db_postgresql, "SELECT idplan 
//                                                         from planes 
//                                                         where planes.idplan not in (select idplan from planesdestinos group by 1)");

//             $destinos = ejecuta_select($db_postgresql, "SELECT idpais from paises where destinopermitido = true order by 1");

//             if($planes['cantidad'] > 0)
//             {
//                 foreach($planes['resultado'] as $plan)
//                 {
//                     $idplan = $plan['idplan'];

//                     foreach($destinos['resultado'] as $destino )
//                     {
//                         $idpais = $destino['idpais'];

//                         ejecuta_insert($db_postgresql, "INSERT INTO planesdestinos (idplan, idpais) VALUES ($idplan, $idpais) ");
//                         $planesdestinoasignado++;
//                     }
//                 }
//             }

//             echo '
// Planes-Destinos asignados: '. $planesdestinoasignado.'
// '; 

//         // NORMALIZACION DE ASIGNACION DE FUENTES

//             $planesfuentesasignado = 0;

//             $planes = ejecuta_select($db_postgresql, "SELECT idplan 
//                                                         from planes 
//                                                         where planes.idplan not in (select idplan from planesfuentes group by 1)");

//             if($planes['cantidad'] > 0)
//             {
//                 foreach($planes['resultado'] as $plan)
//                 {
//                     $idplan = $plan['idplan'];

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesfuentes (idplan, idfuente) VALUES ($idplan, 1) ");
//                     $planesfuentesasignado++;
                    
//                 }
//             }

//         echo '
// Planes-Fuentes asignados: '. $planesfuentesasignado.'
// '; 





// NORMALIZACION DE PLANES PERSONALIZADOS 

// ACTUALIZACION DEL TIPO DE ASISTENCIA DE ALGUNOS PLANES
ejecuta_update($db_postgresql, "UPDATE planes SET idtipoasistencia = 2 WHERE idplan IN (2041,2042,2043) ");

// ASIGNACION DE PLANES PERSONALIZADOS (Planes Bloqueados que se asignan de manera hardcodeada)

$agencias       = array();
$agencias[0]    = array("idagencia" => 3890, "planes" => array(1540,1541,1542,1583,1544,1545,1550));
$agencias[1]    = array("idagencia" => 2477, "planes" => array(1934,2186,2187,2188,1167,1168,1306,1300,1309,1311,1310,1308,2633,2632));
$agencias[2]    = array("idagencia" => 907, "planes" => array(1564,1565,1566,1567,1568,1569,1570));
$agencias[3]    = array("idagencia" => 3440, "planes" => array(1716,1717,1718,1719,1720,1721,1722,1723,1724,1725,1726,1727,1728,1729,1730,1731));
$agencias[4]    = array("idagencia" => 4092, "planes" => array(1649,1650,1651,1652,1653,1654,1655));
$agencias[5]    = array("idagencia" => 2042, "planes" => array(2085,2086));
$agencias[6]    = array("idagencia" => 4598, "planes" => array(2249,2250,2251,2252));
$agencias[7]    = array("idagencia" => 4808, "planes" => array(2189,2190,2191,2192,2193,2194,2195,2196,2197,2198,2199,2200,2244,2379,2380,2381,2382));
$agencias[8]    = array("idagencia" => 5768, "planes" => array(2577,2578,2579,2580,2581,2582));
$agencias[9]    = array("idagencia" => 5211, "planes" => array(87,88,89,1869,1377));
$agencias[10]   = array("idagencia" => 4387, "planes" => array(2597,2598,2600,2599,2601,2602,2605,2604,2607,2606));
$agencias[11]   = array("idagencia" => 4726, "planes" => array(2646,2647,2648));
$agencias[12]   = array("idagencia" => 4723, "planes" => array(2108,2111,2106,2107,2109,2110));
//ASYNC_COTIZA3 FILLPLAN
$agencias[13]   = array("idagencia" => 1687, "planes" => array(1353,707,1352,1644,1910,2490));
$agencias[14]   = array("idagencia" => 3691, "planes" => array(1353,707));
$agencias[15]   = array("idagencia" => 5799, "planes" => array(2508,2509));
$agencias[16]   = array("idagencia" => 5580, "planes" => array(2610,2621,2622,2623,2624,2625,2626,2627,2628));
$agencias[17]   = array("idagencia" => 4496, "planes" => array(1937,1939));
$agencias[18]   = array("idagencia" => 4728, "planes" => array(1937,1939));
$agencias[19]   = array("idagencia" => 4626, "planes" => array(192));
$agencias[20]   = array("idagencia" => 5908 , "planes" => array(2538,2539,2540,2542,2543));
$agencias[21]   = array("idagencia" => 4748, "planes" => array(88));
$agencias[22]   = array("idagencia" => 3938, "planes" => array(2391,2393,2394,2395,2396,2397,2398,2399,2400,2401,2402,2403,2404,2405,2406));
$agencias[23]   = array("idagencia" => 6106, "planes" => array(56,87,88,89,1377,1869));
$agencias[24]   = array("idagencia" => 4672, "planes" => array(1716,1717,1718,1719,2106,2107,2108,2109,2110,2111));
$agencias[25]   = array("idagencia" => 5906, "planes" => array(1870));
$agencias[26]   = array("idagencia" => 5931, "planes" => array(2557,2558,2559,2560,2561,2562,2563,2564,2565,2566));
$agencias[27]   = array("idagencia" => 5990, "planes" => array(2557,2558,2559,2560,2561,2562,2563,2564,2565,2566));
$agencias[28]   = array("idagencia" => 6057, "planes" => array(2637,2658,2659,2660,2638,2661,2662,2663,2639,2664,2665,2666,2640,2667,2668,2669,2641,2670,2671,2672,2642,2682,2683,2684,2643,2694,2695,2696,2649,2673,2674,2675,2650,2685,2686,2687,2651,2697,2698,2699,2652,2676,2677,2678,2653,2688,2689,2690,2654,2701,2702,2703,2655,2679,2680,2681,2656,2691,2692,2693,2657,2703,2704,2705));
$agencias[29]   = array("idagencia" => 6058, "planes" => array(2637,2658,2659,2660,2638,2661,2662,2663,2639,2664,2665,2666,2640,2667,2668,2669,2641,2670,2671,2672,2642,2682,2683,2684,2643,2694,2695,2696,2649,2673,2674,2675,2650,2685,2686,2687,2651,2697,2698,2699,2652,2676,2677,2678,2653,2688,2689,2690,2654,2701,2702,2703,2655,2679,2680,2681,2656,2691,2692,2693,2657,2703,2704,2705));
$agencias[30]   = array("idagencia" => 4677, "planes" => array(2017,2018));
$agencias[31]   = array("idagencia" => 4626, "planes" => array(200,498,499));
$agencias[32]   = array("idagencia" => 4232, "planes" => array(1778));
$agencias[33]   = array("idagencia" => 5350, "planes" => array(89));
$agencias[34]   = array("idagencia" => 4429, "planes" => array(484,485,486,487,471,476,477,472,478,479,474,480,481,473,482,470,490,491));
$agencias[35]   = array("idagencia" => 2297, "planes" => array(21,87,89));
$agencias[36]   = array("idagencia" => 5532, "planes" => array(2041,2042,2043));
$agencias[37]   = array("idagencia" => 5888, "planes" => array(2530,2531,2532,2533,2534,2535));
$agencias[38]   = array("idagencia" => 5923, "planes" => array(267,269,270,272,273,275));
$agencias[39]   = array("idagencia" => 5217, "planes" => array(2569,2570));
$agencias[40]   = array("idagencia" => 5339, "planes" => array(114,116,21,123,56,87,92));
$agencias[41]   = array("idagencia" => 2297, "planes" => array(21,87,89));
$agencias[42]   = array("idagencia" => 5248, "planes" => array(21,123));
$agencias[43]   = array("idagencia" => 5901, "planes" => array(56,87,88,1869,1377));
$agencias[44]   = array("idagencia" => 1425, "planes" => array(157,159,160,162));
$agencias[45]   = array("idagencia" => 6115, "planes" => array(2706,2707,2708,2709,2710));
$agencias[46]   = array("idagencia" => 6117, "planes" => array(484,485,486,487));
$agencias[47]   = array("idagencia" => 3514, "planes" => array(88,1869));

$insert_planesagencias              = "INSERT INTO planesagencias (idagencia, idplan) VALUES ";
$array_valores_planesagencias       = array();

$insert_categoriasagencias          = "INSERT INTO categoriasagencias (idagencia, idcategoria) VALUES ";
$array_valores_categoriasagencias   = array();

foreach($agencias as $agencia)
{
    $idagencia  = $agencia['idagencia'];
    $planes     = $agencia['planes'];

    ejecuta_delete($db_postgresql, "DELETE FROM planesagencias WHERE idagencia = $idagencia");
    ejecuta_delete($db_postgresql, "DELETE FROM categoriasagencias WHERE idagencia = $idagencia");

    $array_categorias = array();

    foreach($planes as $idplan)
    {
        $idcategoria = ejecuta_select($db_postgresql, "SELECT idcategoria FROM planes WHERE idplan = $idplan", "idcategoria");

        if(!in_array($idcategoria, $array_categorias))
        {
            array_push($array_categorias, $idcategoria);
        }

        $valor_planesagencias = " ($idagencia, $idplan) ";
        array_push($array_valores_planesagencias, $valor_planesagencias);
    }

    foreach($array_categorias as $idcategoria)
    {
        $valor_categoriasagencias = " ($idagencia, $idcategoria) ";
        array_push($array_valores_categoriasagencias, $valor_categoriasagencias);
    }
}

$valores_planesagencias = implode(",", $array_valores_planesagencias);
$insert_planesagencias = $insert_planesagencias.$valores_planesagencias;
ejecuta_insert($db_postgresql, $insert_planesagencias );

$valores_categoriasagencias = implode(",", $array_valores_categoriasagencias);
$insert_categoriasagencias = $insert_categoriasagencias.$valores_categoriasagencias;
ejecuta_insert($db_postgresql, $insert_categoriasagencias);














    //  ASOCIAR "ACEPTA BENEFICIOS ADICIONALES" A LAS CATEGORIAS PLANES POR VIAJES Y ANUALES

    ejecuta_update($db_postgresql, "UPDATE categorias SET aceptabeneficiosadicionales = false ");
    ejecuta_update($db_postgresql, "UPDATE categorias SET aceptabeneficiosadicionales = true WHERE idcategoria IN (23,24) ");

    // NOMARLIZA EDADES MINIMAS
    ejecuta_update($db_postgresql, "UPDATE planes SET edadminima = 0 WHERE edadminima = 1");
    ejecuta_update($db_postgresql, "UPDATE categorias set edadmaximaplanfamiliar = 23");















    


echo '
            Cantidad de Planes Normalizados: '.$planes_normalizados.'
';

echo '
            Cantidad de Agencias Normalizadas: '.$agencias_normalizadas.'
';
  
echo '
            Porcentajes de Beneficios Adicionales Normalizados
';

$hora_fin   = date('h:i:s', time());  

echo '
            Fin: '.$hora_fin.'
';
echo '
            Proceso de Normalización Finalizado Exitosamente !

'; 
?>
