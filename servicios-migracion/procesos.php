<?php 
    include('./lib/funciones.php');
    include('./lib/mysql.php');
    include('./lib/pgsql.php');

    system ('clear');

    $db_postgresql      = getDB();
    $db_mysql           = connect_db();

    $hora_inicio            = date('h:i:s', time());
    $fecha_hoy              = date('Y-m-d h:i:s', time());
    // $planes_normalizados        = 0;
    // $agencias_normalizadas      = 0;

    // $incluir_usuarios_claves = false;

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

//     // NORMALIZA IDSTATUS DE CUPONES
//         $update = "UPDATE cupones SET idstatus = 4 WHERE idstatus = 0";
//         ejecuta_update($db_postgresql, $update);

//     // NORMALIZA IDSTATUS DE asistenciascorporativasviajes
//         $update = "UPDATE asistenciascorporativasviajes SET idstatus = 4 WHERE idstatus = 0";
//         ejecuta_update($db_postgresql, $update);

//     // NORMALIZA IDSTATUS DE USUARIOS
//         $update = "UPDATE usuarios SET idstatus = 2 WHERE idstatus = 0";
//         ejecuta_update($db_postgresql, $update);


//     // NORMALIZACION DE CATEGORIAS DE AGENCIAS
//         $update = "UPDATE categorias SET publico = true WHERE idcategoria in (22,23,24,27)";
//         ejecuta_update($db_postgresql, $update);

//         $select_agencias ="SELECT idagencia from agencias where idagencia not in (SELECT idagencia from categoriasagencias)"; 
//         $agencias = ejecuta_select($db_postgresql, $select_agencias);

//         $select_categorias ="SELECT idcategoria from categorias where publico = true"; 
//         $categorias = ejecuta_select($db_postgresql, $select_categorias);

//         if($agencias['cantidad'] > 0)
//         {
//             foreach($agencias['resultado'] as $agencia)
//             {
//                 $idagencia = $agencia['idagencia'];

//                 foreach($categorias['resultado'] as $categoria)
//                 {
//                     $idcategoria = $categoria['idcategoria'];

//                     $insert = "INSERT INTO categoriasagencias ( idagencia, idcategoria ) VALUES ( $idagencia, $idcategoria )";
//                     ejecuta_insert($db_postgresql, $insert);
//                 }
                
//                 $agencias_normalizadas++;
//             }
//         }
//         else
//         {
//             echo '
//             No se encontraron agencias sin categorias asignadas
//             ';
//         }

//     // NORMALIZACION DE PLANES DE AGENCIAS
//         $select_agencias ="SELECT idagencia, idpais FROM agencias where idagencia NOT IN (SELECT idagencia FROM planesagencias)"; 
//         $agencias = ejecuta_select($db_postgresql, $select_agencias);

//         if($agencias['cantidad'] > 0)
//         {
//             foreach($agencias['resultado'] as $agencia)
//             {
//                 $idagencia  = $agencia['idagencia'];
//                 $idpais     = $agencia['idpais'];

//                 if(isset($idpais))
//                 {
//                     $select_planes ="SELECT idplan FROM planes where publico = true AND idplan IN (SELECT idplan FROM planespaises WHERE idpais = $idpais) AND idstatus = 1"; 
//                     $planes = ejecuta_select($db_postgresql, $select_planes);

//                     if($planes['cantidad'] > 0)
//                     {
//                         foreach($planes['resultado'] as $plan)
//                         {
//                             $idplan = $plan['idplan'];

//                             $insert = "INSERT INTO planesagencias ( idagencia, idplan ) VALUES ( $idagencia, $idplan )";
//                             ejecuta_insert($db_postgresql, $insert);
//                         }
//                     }
//                     else
//                     {
//                         $nombrepais = ejecuta_select($db_postgresql, "SELECT nombrepais FROM paises WHERE idpais = $idpais", "nombrepais");
//                         echo '
//                         '.$nombrepais.' no tiene planes públicos
//                         ';
//                     }
//                 }
//                 else
//                 {
//                     echo 'La agencia '.$idagencia.' no tiene país asignado
//                     ';
//                 }

//                 $agencias_normalizadas++;
//             }
//         }
//         else
//         {
//             echo '
//             No se encontraron agencias sin planes asignados
//             ';
//         }

//     // NORMALIZACION DE COMISIONES DE AGENCIAS
//         $select_agencias ="SELECT idagencia FROM agencias WHERE idagencia NOT IN (SELECT idagencia from comisionesagencias)"; 
//         $agencias = ejecuta_select($db_postgresql, $select_agencias);

//         if($agencias['cantidad'] > 0)
//         {
//             foreach($agencias['resultado'] as $agencia)
//             {
//                 echo '.';

//                 $idagencia = $agencia['idagencia'];

//                 $categorias = ejecuta_select($db_postgresql, "SELECT planes.idcategoria FROM planesagencias left join planes on planesagencias.idplan = planes.idplan WHERE idagencia = $idagencia GROUP BY 1");

//                 $mysql_comisiones = $db_mysql->query("SELECT id_categoria, porcentaje FROM commissions WHERE id_agencia = $idagencia");

//                 if($mysql_comisiones->num_rows > 0)
//                 {
//                     while ($row = $mysql_comisiones->fetch_array(MYSQLI_ASSOC)) 
//                     {
//                         $comisiones[] = $row;
//                     }

//                     foreach($categorias['resultado'] as $categoria)
//                     {
//                         $idcategoria = $categoria['idcategoria'];
                        
//                         foreach($comisiones as $comision)
//                         {
//                             // echo $comision['id_categoria']; 
//                             // echo $comision['porcentaje']; 
//                             // exit;
//                             // print_r($comision); exit;

//                             $porcentaje_comision = $comision['porcentaje'];

//                             if($comision['id_categoria'] == $idcategoria)
//                             {
//                                 $insert = "INSERT INTO comisionesagencias ( idagencia, idcategoria, comision ) VALUES ( $idagencia, $idcategoria, $porcentaje_comision )";
//                                 ejecuta_insert($db_postgresql, $insert);
//                             }
//                         }
//                     }

//                     $comisiones = array();

//                     $agencias_normalizadas++;
//                 }
//                 else
//                 {
//                     echo '
//                     No existen comisiones creadas para la agencia: '.$idagencia.'
//                     ';
//                 }
//             }
//         }
//         else
//         {
//             echo '
//             No se encontraron agencias sin comisiones de planes asignados
//             ';
//         }







// // PLANES 




//     // NORMALIZACION DE ASIGNACION DE FUENTES DE LOS PLANES
//         $select_planes ="SELECT idplan from planes p1 where idplan not in (SELECT idplan from planesfuentes p2) and p1.idstatus = 1"; 
//         $planes = ejecuta_select($db_postgresql, $select_planes);

//         if($planes['cantidad'] > 0)
//         {
//             foreach($planes['resultado'] as $plan)
//             {
//                 $idplan = $plan['idplan'];

//                 $insert = "INSERT INTO planesfuentes ( idplan, idfuente ) VALUES ( $idplan, 1 )";
                
//                 ejecuta_insert($db_postgresql, $insert);
                
//             }
//         }
//         else
//         {
//             echo '
//             No se encontraron planes sin fuentes asignadas
//             ';
//         }

//     // NORMALIZACION DE ASIGNACION DE PAISES DE LOS PLANES
//         $select_planes = "SELECT idplan from planes p1 where idplan not in (SELECT idplan from planespaises p2) and p1.idstatus = 1"; 
//         $planes = ejecuta_select($db_postgresql, $select_planes);

//         if($planes['cantidad'] > 0)
//         {
//             foreach($planes['resultado'] as $plan)
//             {
//                 $idplan = $plan['idplan'];

//                 $mysql_idpais = $db_mysql->query("SELECT id_site FROM plans WHERE id = $idplan");

//                 $row    = $mysql_idpais->fetch_array(MYSQLI_ASSOC);
//                 $idpais = $row['id_site'];
//                 $insert = "INSERT INTO planespaises ( idplan, idpais ) VALUES ( $idplan, $idpais )";
                
//                 ejecuta_insert($db_postgresql, $insert);
                
//             }
//         }
//         else
//         {
//             echo '
//             No se encontraron planes sin paises asignadas
//             ';
//         }

//     // NORMALIZACION DE ASIGNACION DE ORIGENES DE LOS PLANES
//         $select_planes = "SELECT idplan from planes p1 where idplan not in (SELECT idplan from planesorigenes p2) and p1.idstatus = 1"; 
//         $planes = ejecuta_select($db_postgresql, $select_planes);

//         if($planes['cantidad'] > 0)
//         {
//             $select_paises = "SELECT idpais from paises where origenpermitido = true"; 
//             $paises = ejecuta_select($db_postgresql, $select_paises);

//             foreach($planes['resultado'] as $plan)
//             {
//                 $idplan = $plan['idplan'];

//                 foreach($paises['resultado'] as $pais)
//                 {
//                     $idpais = $pais['idpais'];
//                 }

//                 $insert = "INSERT INTO planesorigenes ( idplan, idpais ) VALUES ( $idplan, $idpais )";
                
//                 ejecuta_insert($db_postgresql, $insert);
//             }
//         }
//         else
//         {
//             echo '
//             No se encontraron planes sin origenes asignadas
//             ';
//         }

//     // NORMALIZACION DE ASIGNACION DE DESTINOS DE LOS PLANES
//         $planes = ejecuta_select($db_postgresql, "SELECT idplan from planes p1 where idplan not in (SELECT idplan from planesdestinos p2) and p1.idstatus = 1");

//         if($planes['cantidad'] > 0)
//         {
//             $paises = ejecuta_select($db_postgresql, "SELECT idpais from paises where destinopermitido = true");

//             foreach($planes['resultado'] as $plan)
//             {
//                 $idplan = $plan['idplan'];

//                 foreach($paises['resultado'] as $pais)
//                 {
//                     $idpais = $pais['idpais'];
//                 }

//                 $insert = "INSERT INTO planesdestinos ( idplan, idpais ) VALUES ( $idplan, $idpais )";
                
//                 ejecuta_insert($db_postgresql, $insert);
//             }
//         }
//         else
//         {
//             echo '
//             No se encontraron planes sin origenes asignadas
//             ';
//         }

//     // NORMALIZACION BENEFICIOS ADICIONALES DE PLANES CON CATEGORIA ESTUDIANTES  *******************************************************************************************************************************************************************************
//         $planes = ejecuta_select($db_postgresql, "SELECT idplan FROM planes WHERE idplan NOT IN (SELECT idplan FROM planesbeneficiosadicionales) AND idcategoria = 27 AND idstatus = 1");

//         if($planes['cantidad'] > 0)
//         {
//             foreach($planes['resultado'] as $plan)
//             {
//                 $idplan = $plan['idplan'];

//                 $insert = "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, 'USD 15.000', 'USD 15.000', 35, '$fecha_hoy' )";
                
//                 if(ejecuta_insert($db_postgresql, $insert))
//                 {
//                     $update = "UPDATE planes SET fechaactualizacionbeneficiosadicionales = '$fecha_hoy' WHERE idplan = $idplan ";
//                     ejecuta_update($db_postgresql, $update);

//                     $select_idplanbeneficioadicional = "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy'";
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, $select_idplanbeneficioadicional, "idplanbeneficioadicional");

//                     $insert = "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 2, 100)";
                    
//                     if(ejecuta_insert($db_postgresql, $insert))
//                     {
//                         $planes_normalizados++;
//                     }
//                     else
//                     {
//                         echo $insert;
//                     }
//                 }
//                 else
//                 {
//                     echo $insert;
//                 }
//             }
//         }
//         else
//         {
//             echo '
//             No se encontraron planes con beneficios adicionales desactualizados - 
//             ';
//         }

//     // NORMALIZACION BENEFICIOS ADICIONALES DE PLANES CON CATEGORIA ANUALES MULTIVIAJES  *******************************************************************************************************************************************************************************
//         $planes                 = ejecuta_select($db_postgresql, "SELECT idplan, familiaplan FROM planes WHERE idplan NOT IN (SELECT idplan FROM planesbeneficiosadicionales) AND idcategoria IN (23) AND idstatus = 1");

//         if($planes['cantidad'] > 0)
//         {
//             foreach($planes['resultado'] as $plan)
//             {
//                 $idplan         = $plan['idplan'];
//                 $familiaplan    = trim($plan['familiaplan']);

//                 $coberturas     = ejecuta_select($db_postgresql, "SELECT cobertura, coberturaen FROM planesbeneficios WHERE idplan = $idplan AND idbeneficio = 1");
//                 $cobertura      = ($coberturas['cantidad'] > 0) ? $coberturas['resultado'][0]['cobertura'] : 'SIN ASIGNAR';
//                 $coberturaen    = ($coberturas['cantidad'] > 0) ? $coberturas['resultado'][0]['coberturaen'] : 'SIN ASIGNAR';

//                 if($familiaplan == 'GLOBAL')
//                 {
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 1.500', 'USD 1.500', 1, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 1.500', 'USD 1.500', 3, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
//                 }
//                 else if($familiaplan == 'TOTAL')
//                 {
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 3.000', 'USD 3.000', 1, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 3.000', 'USD 3.000', 3, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
//                 }
//                 else if($familiaplan == 'MAXIMUS')
//                 {
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 5.000', 'USD 5.000', 1, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 5.000', 'USD 5.000', 3, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
//                 }
//                 else if($familiaplan == 'SUPREME' || $familiaplan == 'SUMMIT' || $familiaplan == 'PREMIER' || $familiaplan == 'PRESTIGE')
//                 {
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 10.000', 'USD 10.000', 1, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 10.000', 'USD 10.000', 3, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
//                 }
                
                
//                 ejecuta_update($db_postgresql, "UPDATE planes SET fechaactualizacionbeneficiosadicionales = '$fecha_hoy' WHERE idplan = $idplan ");
//             }
//         }
//         else
//         {
//             echo '
//             No se encontraron planes con beneficios adicionales desactualizados 
//             ';
//         }

//     // NORMALIZACION BENEFICIOS ADICIONALES DE PLANES CON CATEGORIA PLANES POR VIAJES  *******************************************************************************************************************************************************************************
//         $planes                 = ejecuta_select($db_postgresql, "SELECT idplan, familiaplan FROM planes WHERE idplan NOT IN (SELECT idplan FROM planesbeneficiosadicionales) AND idcategoria IN (24) AND idstatus = 1");

//         if($planes['cantidad'] > 0)
//         {
//             foreach($planes['resultado'] as $plan)
//             {
//                 $idplan         = $plan['idplan'];
//                 $familiaplan    = trim($plan['familiaplan']);

//                 $coberturas     = ejecuta_select($db_postgresql, "SELECT cobertura, coberturaen FROM planesbeneficios WHERE idplan = $idplan AND idbeneficio = 1");
//                 $cobertura      = ($coberturas['cantidad'] > 0) ? $coberturas['resultado'][0]['cobertura'] : 'SIN ASIGNAR';
//                 $coberturaen    = ($coberturas['cantidad'] > 0) ? $coberturas['resultado'][0]['coberturaen'] : 'SIN ASIGNAR';

//                 if($familiaplan == 'GLOBAL')
//                 {
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 1.500', 'USD 1.500', 1, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 1.500', 'USD 1.500', 3, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
//                 }
//                 else if($familiaplan == 'TOTAL')
//                 {
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 3.000', 'USD 3.000', 1, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 3.000', 'USD 3.000', 3, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
//                 }
//                 else if($familiaplan == 'MAXIMUS')
//                 {
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 5.000', 'USD 5.000', 1, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 5.000', 'USD 5.000', 3, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
//                 }
//                 else if($familiaplan == 'SUPREME' || $familiaplan == 'SUMMIT' || $familiaplan == 'PREMIER' || $familiaplan == 'PRESTIGE')
//                 {
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 35, 0.2, 0.2, 0.2, 'USD 10.000', 'USD 10.000', 1, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 35", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 36, 0.2, 0.2, 0.2, '$cobertura', '$coberturaen', 2, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 36", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");

//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ( $idplan, 37, 0.2, 0.2, 0.2, 'USD 10.000', 'USD 10.000', 3, '$fecha_hoy' )");
//                     $idplanbeneficioadicional = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales WHERE idplan = $idplan AND fechaactualizacion = '$fecha_hoy' AND idbeneficioadicional = 37", "idplanbeneficioadicional");
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesbeneficiosadicionalesproveedores (idplanbeneficioadicional, idproveedor, porcentajeriesgo) VALUES ($idplanbeneficioadicional, 1, 100)");
//                 }
                
//                 ejecuta_update($db_postgresql, "UPDATE planes SET fechaactualizacionbeneficiosadicionales = '$fecha_hoy' WHERE idplan = $idplan ");
//             }
//         }
//         else
//         {
//             echo '
//             No se encontraron planes con beneficios adicionales desactualizados
//             ';
//         }

        
        // // NORMALIZACION DE ASIGNACION DE CATEGORIA PUBLICAS  *******************************************************************************************************************************************************************************
        //     $categorias_publicas = array(22,23,24,27);

        //     foreach($categorias_publicas as $categoria_publica)
        //     {
        //         $agencias                 = ejecuta_select($db_postgresql, "SELECT idagencia, idpais
        //                                                                     from agencias 
        //                                                                     where idagencia not in (
        //                                                                     select idagencia 
        //                                                                     from categoriasagencias
        //                                                                     where idcategoria in ($categoria_publica)
        //                                                                     )");
        
        //         if($agencias['cantidad'] > 0)
        //         {
        //             foreach($agencias['resultado'] as $agencia)
        //             {
        //                 $idagencia          = $agencia['idagencia'];
        //                 $idpais             = $agencia['idpais'];
        
        //                 ejecuta_insert($db_postgresql, "INSERT INTO categoriasagencias ( idagencia, idcategoria ) VALUES ( $idagencia, $categoria_publica)");
        
        //                 $planes_publicos = ejecuta_select($db, "SELECT planes.idplan 
        //                                                         FROM planes 
        //                                                         left join planespaises on planes.idplan = planespaises.idplan 
        //                                                         WHERE planes.publico = true 
        //                                                         AND planes.idcategoria = $categoria_publica
        //                                                         AND planespaises.idpais = $idpais;");
        
        //                 if($planes_publicos['cantidad'] > 0)
        //                 {
        //                     foreach($planes_publicos as $plan_publico)
        //                     {
        //                         $idplan =  $plan_publico['idplan'];
        
        //                         $cantidad = ejecuta_select($db, "SELECT count(*) as cantidad FROM planesagencias WHERE idagencia = $idagencia AND idplan = $idplan", "cantidad");
        
        //                         if($cantidad == 0)
        //                         {
        //                             ejecuta_insert($db_postgresql, "INSERT INTO planesagencias ( idagencia, idplan ) VALUES ( $idagencia, $idplan)");
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //         else
        //         {
        //             echo '
        //             No se encontraron agencias sin la categoria '.$categoria_publica.' asignada
        //             ';
        //         }
        //     }

//     // NORMALIZACION DE CATEGORIAS PUBLICAS Y PLANES PUBLICOS PARA LAS AGENCIAS

//         $agencias = ejecuta_select($db_postgresql, "SELECT idagencia, idpais FROM agencias");

//         foreach($agencias['resultado'] as $agencia)
//         {
//             $idagencia  = $agencia['idagencia'];

//             echo '
//             idagencia: '.$idagencia.'
// ';
//             $idpais     = $agencia['idpais'];
            
//             $categorias_publicas = array(22,23,24,27);

//             foreach($categorias_publicas as $categoria_publica)
//             {
//                 echo '
//                 idcategoria: '.$categoria_publica.'
// ';
//                 $cantidad_categoria = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM categoriasagencias WHERE idagencia = $idagencia AND idcategoria = $categoria_publica", "cantidad");

//                 if($cantidad_categoria == 0)
//                 {
//                     ejecuta_insert($db_postgresql, "INSERT INTO categoriasagencias (idagencia, idcategoria) VALUES ($idagencia, $categoria_publica) ");
//                 }

//                 $planes_publicos_pais = ejecuta_select($db_postgresql, "SELECT planes.idplan FROM planespaises LEFT JOIN planes ON planespaises.idplan = planes.idplan WHERE planespaises.idpais = $idpais AND planes.publico = true AND planes.idcategoria = $categoria_publica ");

//                 if($planes_publicos_pais['cantidad'] > 0)
//                 {
//                     foreach($planes_publicos_pais['resultado'] as $plan_publico)
//                     {
//                         $idplan = $plan_publico['idplan'];

//                         echo '
//                         idplan: '.$idplan.'
// ';
    
//                         $cantidad_plan = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planesagencias WHERE idplan = $idplan AND idagencia = $idagencia", "cantidad");
    
//                         if($cantidad_plan == 0)
//                         {
//                             ejecuta_insert($db_postgresql, "INSERT INTO planesagencias (idplan, idagencia) VALUES ($idplan, $idagencia) ");
//                         }
//                     }
//                 }
//             }
//         }


    // // NORMALIZACION DE ASOCIACION DE PLANES A LAS PRECOMPRAS EXISTENTES

    //     $cargas_precompras = ejecuta_select($db_postgresql, "SELECT ordenes.idorden, 
    //                                                                 precompras.idprecompra 
    //                                                             FROM ordenes 
    //                                                             LEFT JOIN precompras ON ordenes.idorden = precompras.idorden
    //                                                             WHERE ordenes.cargaprecompra = true");

    //     foreach($cargas_precompras['resultado'] as $carga_precompra)
    //     {
    //         $idprecompra    = $carga_precompra['idprecompra'];
    //         $idorden        = $carga_precompra['idorden'];

    //         $planes_asociados = ejecuta_select($db_postgresql, "SELECT * FROM precomprasplanes WHERE precomprasplanes.idprecompra = $idprecompra");

    //         if($planes_asociados['cantidad'] == 0)
    //         {
    //             $mysql_idplan   = $db_mysql->query("SELECT producto as idplan FROM orders WHERE id = $idorden");
    //             $row            = $mysql_idplan->fetch_array(MYSQLI_ASSOC);
    //             $idplan         = $row['idplan'];
                
    //             if($idplan)
    //             {
    //                 ejecuta_insert($db_postgresql, "INSERT INTO precomprasplanes (idprecompra, idplan) VALUES ($idprecompra, $idplan) ");
    //             }
    //         }
    //     }
        

    // // NORMALIZACION DE LOGOS DE AGENCIAS

    //     $urllogosagencias               = ejecuta_select($db_postgresql, "SELECT valor FROM configuracion WHERE nombreconfiguracion = 'urllogosagencias' ", "valor");
    //     $normaliza_agencias_sin_logos   = ejecuta_update($db_postgresql, "UPDATE agencias SET logoagencia = '' WHERE logoagencia = '$urllogosagencias' ");

    // NORMALIZACION DE PLANFAMILIAR EN PLANES CORPORATIVOS

    // $normaliza_plan_familiar_corporativos   = ejecuta_update($db_postgresql, "UPDATE planes SET planfamiliar = 'f' WHERE idcategoria = 14 ");


    // // NORMALIZACION DE POPULARIDADES

    //     ejecuta_update($db_postgresql, "update planes set idpopularidad = 2");
    //     ejecuta_update($db_postgresql, "update planes set idpopularidad = 9 where familiaplan = 'TRAVELER'");
    //     ejecuta_update($db_postgresql, "update planes set idpopularidad = 8 where familiaplan = 'GLOBAL'");
    //     ejecuta_update($db_postgresql, "update planes set idpopularidad = 7 where familiaplan = 'TOTAL'");
    //     ejecuta_update($db_postgresql, "update planes set idpopularidad = 6 where familiaplan = 'MAXIMUS'");
    //     ejecuta_update($db_postgresql, "update planes set idpopularidad = 5 where familiaplan = 'SUPREME'");
    //     ejecuta_update($db_postgresql, "update planes set idpopularidad = 4 where familiaplan = 'SUMMIT'");

    // // NORMALIZACION DE LOS DESTINOS DE LOS PLANES CONSUL 

    //     $planes = ejecuta_select($db_postgresql, "SELECT idplan from planes where nombreplan like '%CONSUL%' AND nombreplan not like '%CONSULTING%' AND nombreplan not like '%CONSULTORES%'");

    //     foreach($planes['resultado'] as $plan)
    //     {
    //         $idplan = $plan['idplan'];

    //         ejecuta_delete($db_postgresql, "DELETE from planesdestinos WHERE idplan = $idplan");

    //         $paises_europeos = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE region like 'Europe'");

    //         foreach($paises_europeos['resultado'] as $pais_europeo)
    //         {
    //             $idpais = $pais_europeo['idpais'];

    //             ejecuta_insert($db_postgresql, "INSERT INTO planesdestinos (idplan, idpais) VALUES ($idplan, $idpais) ");
    //         }
    //     }

    // // PROCESO DE REPORTE DE BENEFICIARIOS DE OPENINSURANCE (2676)

    //     $array_nivel2           = array();
    //     $array_nivel3           = array();
    //     $array_nivel4           = array();
    //     $array_todas            = array(2676);
    //     $array_ordenes          = array();
    //     $array_idbeneficiarios  = array();
    //     $array_beneficiarios    = array();

    //     $agencias_nivel2 = $db_mysql->query("SELECT id_broker FROM broker_nivel WHERE parent = 2676");

    //     if($agencias_nivel2->num_rows > 0)
    //     {
    //         while ($row2 = $agencias_nivel2->fetch_array(MYSQLI_ASSOC)) 
    //         {
    //             $niveles2[] = $row2;
    //         }

    //         foreach($niveles2 as $nivel2)
    //         {
    //             $id_nivel2 = $nivel2['id_broker'];

    //             array_push($array_nivel2, $id_nivel2);
    //         }
    //     }

    //     foreach($array_nivel2 as $idnivel2)
    //     {
    //         $agencias_nivel3 = $db_mysql->query("SELECT id_broker FROM broker_nivel WHERE parent = $idnivel2");

    //         if($agencias_nivel3->num_rows > 0)
    //         {
    //             while ($row3 = $agencias_nivel3->fetch_array(MYSQLI_ASSOC)) 
    //             {
    //                 $niveles3[] = $row3;
    //             }

    //             foreach($niveles3 as $nivel3)
    //             {
    //                 $id_nivel3 = $nivel3['id_broker'];

    //                 if(!in_array($id_nivel3, $array_nivel3))
    //                 {
    //                     array_push($array_nivel3, $id_nivel3);
    //                 }
    //             }
    //         }
    //     }

    //     foreach($array_nivel3 as $idnivel3)
    //     {
    //         $agencias_nivel4 = $db_mysql->query("SELECT id_broker FROM broker_nivel WHERE parent = $idnivel3");

    //         if($agencias_nivel4->num_rows > 0)
    //         {
    //             while ($row4 = $agencias_nivel4->fetch_array(MYSQLI_ASSOC)) 
    //             {
    //                 $niveles4[] = $row4;
    //             }

    //             foreach($niveles4 as $nivel4)
    //             {
    //                 $id_nivel4 = $nivel4['id_broker'];

    //                 if(!in_array($id_nivel4, $array_nivel4))
    //                 {
    //                     array_push($array_nivel4, $id_nivel4);
    //                 }
    //             }
    //         }
    //     }

    //     foreach($array_nivel2 as $nivel2)
    //     {
    //         if(!in_array($nivel2, $array_todas))
    //         {
    //             array_push($array_todas, $nivel2);
    //         }
    //     }

    //     foreach($array_nivel3 as $nivel3)
    //     {
    //         if(!in_array($nivel3, $array_todas))
    //         {
    //             array_push($array_todas, $nivel3);
    //         }
    //     }

    //     foreach($array_nivel4 as $nivel4)
    //     {
    //         if(!in_array($nivel4, $array_todas))
    //         {
    //             array_push($array_todas, $nivel4);
    //         }
    //     }

    //     $agencias = implode(",", $array_todas); 

    //     $select_ordenes = $db_mysql->query("SELECT id FROM orders WHERE agencia IN ($agencias) AND fecha > '2018-09-01' AND status = 1 ORDER BY id ASC") ;

    //     if($select_ordenes->num_rows > 0)
    //     {
    //         while ($row_ordenes = $select_ordenes->fetch_array(MYSQLI_ASSOC)) 
    //         {
    //             $ordenes[] = $row_ordenes;
    //         }

    //         foreach($ordenes as $orden)
    //         {
    //             $idorden = $orden['id'];

    //             if(!in_array($idorden, $array_ordenes))
    //             {
    //                 array_push($array_ordenes, $idorden);
    //             }
    //         }
    //     }

    //     $ordenes = implode(",", $array_ordenes); 

    //     echo "SELECT CONCAT(beneficiaries.nombre,' ',beneficiaries.apellido) as nombreapellido, 
    //     beneficiaries.email, 
    //     beneficiaries.telefono, 
    //     UPPER(broker.broker) as agencia,
    //     CONCAT(users.firstname,' ',users.lastname) as agente
    //     FROM beneficiaries 
    //     LEFT JOIN orders ON beneficiaries.id_orden = orders.id 
    //     LEFT JOIN broker ON orders.agencia = broker.id_broker
    //     LEFT JOIN users ON orders.vendedor = users.id
    //     WHERE beneficiaries.id_orden IN ($ordenes)
    //     ORDER BY agencia ASC, agente ASC, nombreapellido ASC";


// // PROCESO DE REPORTE DE COMISIONES DE AGENCIAS DE KATY

//     $select = "SELECT 
//             broker.id_broker,
//             commissions.porcentaje
//             FROM broker 
//             LEFT JOIN commissions ON broker.id_broker = commissions.id_agencia
//             WHERE broker.id_broker in (5634,546,547,663,795,803,854,861,870,924,950,1037,1038,1040,1062,1080,1085,1270,1278,1288,1314,1338,1339,1407,1436,1458,1467,1512,1557,1584,1586,1597,1607,1608,1609,1637,1673,1694,1699,1712,1730,1786,1811,1818,1834,1838,1853,1866,1871,1920,1952,1976,1987,1991,2108,2156,2180,2221,2230,2261,2263,2312,2314,2328,2361,2370,2384,2401,2427,2448,2495,2531,2539,2552,2553,2587,2607,2623,2626,2627,2631,2650,2694,2768,3403,3430,3525,3661,3689,3757,3858,3960,4052,4086,4252,4494,4505,4514,4515,4611,4621,4650,4731,4771,4837,4847,4855,4888,5205,5394,5456,5467,5487,5520,5528,5531,5542,5581,5585,5587,5600,5624,5639,5671,5737,5739,5752,5774,5782,5783,5795)
//             AND commissions.porcentaje > 0
//             GROUP BY 1";


// PROCESO DE CALCULA EDAD
    // $fecha = '01/10/2022';


    // echo calcula_edad_proceso(formatea_fecha($fecha,'-'));
    // exit;


    // function calcula_edad_proceso($fecha)
    // {
    //     list($Y,$m,$d) = explode("-",$fecha);
    //     return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
    // }







// PERMISOS

$modulos_permitidos_por_defecto                 = array(44, 30, 3, 60, 2, 63, 26, 62, 35, 17, 21);
$modulos_corporativos_permitidos_por_defecto    = array(27);


ejecuta_delete($db_postgresql, "DELETE FROM permisos WHERE idagencia IS NOT NULL OR idusuario IS NOT NULL");


// // PROCESO DE ASIGNACION DE PERMISOS POR DEFECTO

    ejecuta_delete($db_postgresql, "DELETE FROM permisos");

    ejecuta_update($db_postgresql, "ALTER SEQUENCE permisosasignacion_idpermiso_seq RESTART WITH 1");

    $empresas           = ejecuta_select($db_postgresql, "SELECT idempresa FROM empresas WHERE idempresa = 1");
    $paises             = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE essede = true");
    $agencias           = ejecuta_select($db_postgresql, "SELECT idagencia FROM agencias");
    $niveles            = ejecuta_select($db_postgresql, "SELECT idnivel FROM niveles");
    $tiposusuario       = ejecuta_select($db_postgresql, "SELECT idtipousuario FROM tiposusuario");
    $usuarios           = ejecuta_select($db_postgresql, "SELECT idusuario FROM usuarios");
    $mixtos             = ejecuta_select($db_postgresql, "SELECT idmixto FROM mixtos");
    
    // PERMISOS EMPRESAS

        echo '
Asignando Permisos a las Empresas
        ';

        foreach($empresas['resultado'] as $empresa)
        {
            $idempresa = $empresa['idempresa'];

            $sistemas  = ejecuta_select($db_postgresql, "SELECT * FROM sistemas WHERE idempresa = $idempresa");

            if($sistemas['cantidad'] > 0)
            {
                foreach($sistemas['resultado'] as $sistema)
                {
                    $idsistema = $sistema['idsistema'];
    
                    $modulos   = ejecuta_select($db_postgresql, "SELECT * FROM modulos WHERE idsistema = $idsistema");
    
                    if($modulos['cantidad'] > 0)
                    {
                        foreach($modulos['resultado'] as $modulo)
                        {
                            $idmodulo = $modulo['idmodulo'];
                
                            $funciones = ejecuta_select($db_postgresql, "SELECT * FROM funciones WHERE idmodulo = $idmodulo");

                            ejecuta_insert($db_postgresql, "INSERT INTO permisos (
                                                                        idempresa,
                                                                        idmodulo,
                                                                        permiso,
                                                                        moduloasignadodesde
                                                                    )
                                                                    VALUES 
                                                                    (
                                                                        $idempresa,
                                                                        $idmodulo,
                                                                        true,
                                                                        'Empresa'
                                                                    ) ");
                            if($funciones['cantidad'] > 0)
                            {
                                foreach($funciones['resultado'] as $funcion)
                                {
                                    $idfuncion = $funcion['idfuncion'];
                    
                                    ejecuta_insert($db_postgresql, "INSERT INTO permisos (
                                                                                idempresa,
                                                                                idmodulo,
                                                                                idfuncion,
                                                                                permiso,
                                                                                moduloasignadodesde
                                                                            )
                                                                            VALUES 
                                                                            (
                                                                                $idempresa,
                                                                                $idmodulo,
                                                                                $idfuncion,
                                                                                true,
                                                                                'Empresa'
                                                                            ) ");
                                }
                            }
                        }
                    }
                }
            }
        }



 //BORRA PERMISOS DE USUARIOS

ejecuta_delete($db_postgresql, "DELETE FROM permisos WHERE idusuario IS NOT NULL");

    // PERMISOS SISTEMAS

    echo '
Asignando Permisos a los Sistemas
    ';

    $sistemas  = ejecuta_select($db_postgresql, "SELECT idsistema FROM sistemas");

    if($sistemas['cantidad'] > 0)
    {
        foreach($sistemas['resultado'] as $sistema)
        {
            $idsistema = $sistema['idsistema'];

            $modulos   = ejecuta_select($db_postgresql, "SELECT * FROM modulos");

            if($modulos['cantidad'] > 0)
            {
                foreach($modulos['resultado'] as $modulo)
                {
                    $idmodulo = $modulo['idmodulo'];
        
                    ejecuta_insert($db_postgresql, "INSERT INTO permisos (
                                                                idsistema,
                                                                idmodulo,
                                                                permiso
                                                            )
                                                            VALUES 
                                                            (
                                                                $idsistema,
                                                                $idmodulo,
                                                                true
                                                            ) ");

                    $funciones = ejecuta_select($db_postgresql, "SELECT * FROM funciones WHERE idmodulo = $idmodulo");
                    
                    if($funciones['cantidad'] > 0)
                    {
                        foreach($funciones['resultado'] as $funcion)
                        {
                            $idfuncion = $funcion['idfuncion'];
            
                            ejecuta_insert($db_postgresql, "INSERT INTO permisos (
                                                                        idsistema,
                                                                        idmodulo,
                                                                        idfuncion,
                                                                        permiso
                                                                    )
                                                                    VALUES 
                                                                    (
                                                                        $idsistema,
                                                                        $idmodulo,
                                                                        $idfuncion,
                                                                        true
                                                                    ) ");
                        }
                    }
                }
            }
        }
    }
    

    // PERMISOS PAISES

    echo '
Asignando Permisos a los Paises
    ';

    foreach($paises['resultado'] as $pais)
    {
        $idpais = $pais['idpais'];

        $sistemas  = ejecuta_select($db_postgresql, "SELECT * FROM sistemas WHERE idempresa = 1");

        if($sistemas['cantidad'] > 0)
        {
            foreach($sistemas['resultado'] as $sistema)
            {
                $idsistema = $sistema['idsistema'];

                $modulos   = ejecuta_select($db_postgresql, "SELECT * FROM modulos WHERE idsistema = $idsistema");

                if($modulos['cantidad'] > 0)
                {
                    foreach($modulos['resultado'] as $modulo)
                    {
                        $idmodulo = $modulo['idmodulo'];
            
                        $funciones = ejecuta_select($db_postgresql, "SELECT * FROM funciones WHERE idmodulo = $idmodulo");

                        $permiso_boolean = (in_array($idmodulo, $modulos_permitidos_por_defecto) || $idpais == 283) ? 'true' : 'false' ;
    
                        ejecuta_insert($db_postgresql, "INSERT INTO permisos (
                                                                    idpais,
                                                                    idmodulo,
                                                                    permiso
                                                                )
                                                                VALUES 
                                                                (
                                                                    $idpais,
                                                                    $idmodulo,
                                                                    $permiso_boolean
                                                                ) ");
                        if($funciones['cantidad'] > 0)
                        {
                            foreach($funciones['resultado'] as $funcion)
                            {
                                $idfuncion = $funcion['idfuncion'];
                
                                ejecuta_insert($db_postgresql, "INSERT INTO permisos (
                                                                            idpais,
                                                                            idmodulo,
                                                                            idfuncion,
                                                                            permiso
                                                                        )
                                                                        VALUES 
                                                                        (
                                                                            $idpais,
                                                                            $idmodulo,
                                                                            $idfuncion,
                                                                            $permiso_boolean
                                                                        ) ");
                            }
                        }
                    }
                }
            }
        }
    }




//     // PERMISOS AGENCIAS

//     echo '
// Asignando Permisos a las Agencias
//     ';

//     $agencias  = ejecuta_select($db_postgresql, "SELECT idagencia FROM agencias");
//     $modulos   = ejecuta_select($db_postgresql, "SELECT * FROM modulos WHERE idsistema = 1");


//     if($agencias['cantidad'] > 0)
//     {
//         foreach($agencias['resultado'] as $agencia)
//         {
//             $idagencia = $agencia['idagencia'];

//             if($modulos['cantidad'] > 0)
//             {
//                 foreach($modulos['resultado'] as $modulo)
//                 {
//                     $idmodulo = $modulo['idmodulo'];
        
//                     $funciones = ejecuta_select($db_postgresql, "SELECT * FROM funciones WHERE idmodulo = $idmodulo");

//                     ejecuta_insert($db_postgresql, "INSERT INTO permisos (
//                                                                 idagencia,
//                                                                 idmodulo,
//                                                                 permiso
//                                                             )
//                                                             VALUES 
//                                                             (
//                                                                 $idagencia,
//                                                                 $idmodulo,
//                                                                 true
//                                                             ) ");
//                     if($funciones['cantidad'] > 0)
//                     {
//                         foreach($funciones['resultado'] as $funcion)
//                         {
//                             $idfuncion = $funcion['idfuncion'];
            
//                             ejecuta_insert($db_postgresql, "INSERT INTO permisos (
//                                                                         idagencia,
//                                                                         idmodulo,
//                                                                         idfuncion,
//                                                                         permiso
//                                                                     )
//                                                                     VALUES 
//                                                                     (
//                                                                         $idagencia,
//                                                                         $idmodulo,
//                                                                         $idfuncion,
//                                                                         true
//                                                                     ) ");
//                         }
//                     }
//                 }
//             }
//         }
//     }



    // PERMISOS NIVELES

    echo '
Asignando Permisos a los Niveles
    ';

    $niveles  = ejecuta_select($db_postgresql, "SELECT idnivel FROM niveles");
    $modulos   = ejecuta_select($db_postgresql, "SELECT * FROM modulos WHERE idsistema = 1");


    if($niveles['cantidad'] > 0)
    {
        foreach($niveles['resultado'] as $nivel)
        {
            $idnivel = $nivel['idnivel'];

            if($modulos['cantidad'] > 0)
            {
                foreach($modulos['resultado'] as $modulo)
                {
                    $idmodulo = $modulo['idmodulo'];
        
                    $funciones = ejecuta_select($db_postgresql, "SELECT * FROM funciones WHERE idmodulo = $idmodulo");

                    $permiso_boolean = (in_array($idmodulo, $modulos_permitidos_por_defecto) || $idnivel == 0) ? 'true' : 'false' ;

                    ejecuta_insert($db_postgresql, "INSERT INTO permisos (
                                                                idnivel,
                                                                idmodulo,
                                                                permiso
                                                            )
                                                            VALUES 
                                                            (
                                                                $idnivel,
                                                                $idmodulo,
                                                                $permiso_boolean
                                                            ) ");
                    if($funciones['cantidad'] > 0)
                    {
                        foreach($funciones['resultado'] as $funcion)
                        {
                            $idfuncion = $funcion['idfuncion'];
            
                            ejecuta_insert($db_postgresql, "INSERT INTO permisos (
                                                                        idnivel,
                                                                        idmodulo,
                                                                        idfuncion,
                                                                        permiso
                                                                    )
                                                                    VALUES 
                                                                    (
                                                                        $idnivel,
                                                                        $idmodulo,
                                                                        $idfuncion,
                                                                        $permiso_boolean
                                                                    ) ");
                        }
                    }
                }
            }
        }
    }

//     // PERMISOS USUARIOS

//     echo '
// Asignando Permisos a los Usuarios
//     ';

//     $usuarios  = ejecuta_select($db_postgresql, "SELECT idusuario FROM usuarios");
//     $modulos   = ejecuta_select($db_postgresql, "SELECT * FROM modulos WHERE idsistema = 1");


//     if($usuarios['cantidad'] > 0)
//     {
//         foreach($usuarios['resultado'] as $usuario)
//         {
//             $idusuario = $usuario['idusuario'];

//             if($modulos['cantidad'] > 0)
//             {
//                 foreach($modulos['resultado'] as $modulo)
//                 {
//                     $idmodulo = $modulo['idmodulo'];
        
//                     $funciones = ejecuta_select($db_postgresql, "SELECT * FROM funciones WHERE idmodulo = $idmodulo");

//                     ejecuta_insert($db_postgresql, "INSERT INTO permisos (
//                                                                 idusuario,
//                                                                 idmodulo,
//                                                                 permiso
//                                                             )
//                                                             VALUES 
//                                                             (
//                                                                 $idusuario,
//                                                                 $idmodulo,
//                                                                 true
//                                                             ) ");
//                     if($funciones['cantidad'] > 0)
//                     {
//                         foreach($funciones['resultado'] as $funcion)
//                         {
//                             $idfuncion = $funcion['idfuncion'];
            
//                             ejecuta_insert($db_postgresql, "INSERT INTO permisos (
//                                                                         idusuario,
//                                                                         idmodulo,
//                                                                         idfuncion,
//                                                                         permiso
//                                                                     )
//                                                                     VALUES 
//                                                                     (
//                                                                         $idusuario,
//                                                                         $idmodulo,
//                                                                         $idfuncion,
//                                                                         true
//                                                                     ) ");
//                         }
//                     }
//                 }
//             }
//         }
//     }

    // PERMISOS TIPOS USUARIOS

    echo '
Asignando Permisos a los Tipos de Usuarios
    ';

    $tiposusuario  = ejecuta_select($db_postgresql, "SELECT idtipousuario FROM tiposusuario");
    $modulos   = ejecuta_select($db_postgresql, "SELECT * FROM modulos WHERE idsistema = 1");


    if($tiposusuario['cantidad'] > 0)
    {
        foreach($tiposusuario['resultado'] as $tipousuario)
        {
            $idtipousuario = $tipousuario['idtipousuario'];

            if($modulos['cantidad'] > 0)
            {
                foreach($modulos['resultado'] as $modulo)
                {
                    $idmodulo = $modulo['idmodulo'];
        
                    $funciones = ejecuta_select($db_postgresql, "SELECT * FROM funciones WHERE idmodulo = $idmodulo");

                    $permiso_boolean = (in_array($idmodulo, $modulos_permitidos_por_defecto) || $idtipousuario == 0) ? 'true' : 'false' ;

                    ejecuta_insert($db_postgresql, "INSERT INTO permisos (
                                                                idtipousuario,
                                                                idmodulo,
                                                                permiso
                                                            )
                                                            VALUES 
                                                            (
                                                                $idtipousuario,
                                                                $idmodulo,
                                                                $permiso_boolean
                                                            ) ");
                    if($funciones['cantidad'] > 0)
                    {
                        foreach($funciones['resultado'] as $funcion)
                        {
                            $idfuncion = $funcion['idfuncion'];
            
                            ejecuta_insert($db_postgresql, "INSERT INTO permisos (
                                                                        idtipousuario,
                                                                        idmodulo,
                                                                        idfuncion,
                                                                        permiso
                                                                    )
                                                                    VALUES 
                                                                    (
                                                                        $idtipousuario,
                                                                        $idmodulo,
                                                                        $idfuncion,
                                                                        $permiso_boolean
                                                                    ) ");
                        }
                    }
                }
            }
        }
    }

    ejecuta_insert($db_postgresql, "INSERT INTO permisos (idempresa, idpais, idsistema, idagencia, idnivel, idtipousuario, idusuario, idmixto, idmodulo, idfuncion, permiso, moduloasignadodesde, funcionasignadadesde) VALUES(NULL, NULL, NULL, NULL, NULL, NULL, 3071, NULL, 1, NULL, true, 'Usuario', NULL)");
    ejecuta_insert($db_postgresql, "INSERT INTO permisos (idempresa, idpais, idsistema, idagencia, idnivel, idtipousuario, idusuario, idmixto, idmodulo, idfuncion, permiso, moduloasignadodesde, funcionasignadadesde) VALUES(NULL, NULL, NULL, NULL, NULL, NULL, 3071, NULL, 11, NULL, true, 'Usuario', NULL)");


//     // PERMISOS TIPOS MIXTOS

//     echo '
// Asignando Permisos a los Mixtos
//     ';

//     $mixtos  = ejecuta_select($db_postgresql, "SELECT idmixto FROM mixtos");
//     $modulos   = ejecuta_select($db_postgresql, "SELECT * FROM modulos WHERE idsistema = 1");

//     if($mixtos['cantidad'] > 0)
//     {
//         foreach($mixtos['resultado'] as $mixto)
//         {
//             $idmixto = $mixto['idmixto'];

//             if($modulos['cantidad'] > 0)
//             {
//                 foreach($modulos['resultado'] as $modulo)
//                 {
//                     $idmodulo = $modulo['idmodulo'];
        
//                     $funciones = ejecuta_select($db_postgresql, "SELECT * FROM funciones WHERE idmodulo = $idmodulo");

//                     ejecuta_insert($db_postgresql, "INSERT INTO permisos (
//                                                                 idmixto,
//                                                                 idmodulo,
//                                                                 permiso
//                                                             )
//                                                             VALUES 
//                                                             (
//                                                                 $idmixto,
//                                                                 $idmodulo,
//                                                                 false
//                                                             ) ");
//                     if($funciones['cantidad'] > 0)
//                     {
//                         foreach($funciones['resultado'] as $funcion)
//                         {
//                             $idfuncion = $funcion['idfuncion'];
            
//                             ejecuta_insert($db_postgresql, "INSERT INTO permisos (
//                                                                         idmixto,
//                                                                         idmodulo,
//                                                                         idfuncion,
//                                                                         permiso
//                                                                     )
//                                                                     VALUES 
//                                                                     (
//                                                                         $idmixto,
//                                                                         $idmodulo,
//                                                                         $idfuncion,
//                                                                         false
//                                                                     ) ");
//                         }
//                     }
//                 }
//             }
//         }
//     }


//     // LIMPIAR PERMISOS
// echo '
// Limpiando Permisos Sistemas
// ';
//     ejecuta_update($db_postgresql, "UPDATE permisos SET permiso = NULL WHERE idsistema IS NOT NULL");
// echo '
// Limpiando Permisos Paises
// ';
//     ejecuta_update($db_postgresql, "UPDATE permisos SET permiso = NULL WHERE idpais IS NOT NULL");
// echo '
// Limpiando Permisos Niveles
// ';
//     ejecuta_update($db_postgresql, "UPDATE permisos SET permiso = NULL WHERE idnivel IS NOT NULL");
// echo '
// Limpiando Permisos Agencias
// ';
//     ejecuta_update($db_postgresql, "UPDATE permisos SET permiso = NULL WHERE idagencia IS NOT NULL");
// echo '
// Limpiando Permisos Tipos de Usuarios
// ';
//     ejecuta_update($db_postgresql, "UPDATE permisos SET permiso = NULL WHERE idtipousuario IS NOT NULL");
// echo '
// Limpiando Permisos Usuarios
// ';
//     ejecuta_update($db_postgresql, "UPDATE permisos SET permiso = NULL WHERE idusuario IS NOT NULL");






    // //ELIMINAR PERMISOS

    // ejecuta_delete($db_postgresql, "DELETE FROM permisos ");
    // ejecuta_delete($db_postgresql, "DELETE FROM permisos WHERE idempresa IS NULL AND idsistema IS NULL");



//     // ASOCIAR PLANES A LAS AGENCIAS QUE LOS HAYAN UTILIZADO

//     $planesasociados = 0;

//     echo '
//     ASOCIAR PLANES A LAS AGENCIAS QUE LOS HAYAN UTILIZADO

// ';


// echo '
// Seleccionando Agencias...

// ';
    
//         $array_agencias = array();

//         $mysql_brokers = $db_mysql->query("SELECT id_broker as idagencia, id_site as idpais FROM broker ORDER BY id_broker ASC");
       
//         if($mysql_brokers->num_rows > 0)
//         {
//             while ($row = $mysql_brokers->fetch_array(MYSQLI_ASSOC)) 
//             {
//                 $brokers[] = $row;
//             }

//             foreach($brokers as $broker)
//             {
//                 $idagencia  = $broker['idagencia'];
//                 $idpais     = $broker['idpais'];

//                 $agencia = ["idagencia" => $idagencia, "idpais" => $idpais, "planes" => array()];

//                 array_push($array_agencias, $agencia);
//             }
//         }


//         echo '
// Asociando Planes...

// ';

//         $contador = 0;
//         foreach($array_agencias as $agencia)
//         {
//             $idagencia = $agencia['idagencia'];
            
//             $mysql_planes = $db_mysql->query("SELECT producto FROM orders WHERE agencia = $idagencia GROUP BY producto ORDER BY producto ASC");

//             if($mysql_planes->num_rows > 0)
//             {
//                 while ($row_planes = $mysql_planes->fetch_array(MYSQLI_ASSOC)) 
//                 {
//                     $planes[] = $row_planes;
//                 }

//                 foreach($planes as $plan)
//                 {
//                     $id_plan = $plan['producto'];

//                     array_push($array_agencias[$contador]['planes'], $id_plan);
//                 }
//             }

//             $planes = array();
//             $contador++;
//         }

//         echo '
// Insertando en planespaises...
// Insertando en planesagencias...

// ';

//         $contador = 0;
//         foreach($array_agencias as $agencia)
//         {
//             $idagencia  = $agencia['idagencia'];
//             $idpais     = $agencia['idpais'];
//             $planes     = $agencia['planes'];

//             if($idpais == 0) $idpais = 283;

//             foreach($planes as $idplan)
//             {
//                 if($idplan == 0) continue;

//                 $existe = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planespaises WHERE planespaises.idpais = $idpais AND planespaises.idplan = $idplan", "cantidad");

//                 if($existe == 0)
//                 {
//                     ejecuta_insert($db_postgresql, "INSERT INTO planespaises (idpais, idplan) VALUES ($idpais, $idplan) ");
//                     $planesasociados++;
//                 }

//                 $existe = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planesagencias WHERE planesagencias.idagencia = $idagencia AND planesagencias.idplan = $idplan", "cantidad");

//                 if($existe == 0)
//                 {
//                     ejecuta_insert($db_postgresql, "INSERT INTO planesagencias (idagencia, idplan) VALUES ($idagencia, $idplan) ");
//                     $planesasociados++;
//                 }
//             }
//             $contador = 0;
//         }

//         echo '
// Planes Asociados: '.$planesasociados.'

// ';


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

    // // ACTUALIZACION DEL TIPO DE ASISTENCIA DE ALGUNOS PLANES
    // ejecuta_update($db_postgresql, "UPDATE planes SET idtipoasistencia = 2 WHERE idplan IN (2041,2042,2043) ");

    // // ASIGNACION DE PLANES PERSONALIZADOS (Planes Bloqueados que se asignan de manera hardcodeada)

    // $agencias       = array();
    // $agencias[0]    = array("idagencia" => 3890, "planes" => array(1540,1541,1542,1583,1544,1545,1550));
    // $agencias[1]    = array("idagencia" => 2477, "planes" => array(1934,2186,2187,2188,1167,1168,1306,1300,1309,1311,1310,1308,2633,2632));
    // $agencias[2]    = array("idagencia" => 907, "planes" => array(1564,1565,1566,1567,1568,1569,1570));
    // $agencias[3]    = array("idagencia" => 3440, "planes" => array(1716,1717,1718,1719,1720,1721,1722,1723,1724,1725,1726,1727,1728,1729,1730,1731));
    // $agencias[4]    = array("idagencia" => 4092, "planes" => array(1649,1650,1651,1652,1653,1654,1655));
    // $agencias[5]    = array("idagencia" => 2042, "planes" => array(2085,2086));
    // $agencias[6]    = array("idagencia" => 4598, "planes" => array(2249,2250,2251,2252));
    // $agencias[7]    = array("idagencia" => 4808, "planes" => array(2189,2190,2191,2192,2193,2194,2195,2196,2197,2198,2199,2200,2244,2379,2380,2381,2382));
    // $agencias[8]    = array("idagencia" => 5768, "planes" => array(2577,2578,2579,2580,2581,2582));
    // $agencias[9]    = array("idagencia" => 5211, "planes" => array(87,88,89,1869,1377));
    // $agencias[10]   = array("idagencia" => 4387, "planes" => array(2597,2598,2600,2599,2601,2602,2605,2604,2607,2606));
    // $agencias[11]   = array("idagencia" => 4726, "planes" => array(2646,2647,2648));
    // $agencias[12]   = array("idagencia" => 4723, "planes" => array(2108,2111,2106,2107,2109,2110));
    // //ASYNC_COTIZA3 FILLPLAN
    // $agencias[13]   = array("idagencia" => 1687, "planes" => array(1353,707,1352,1644,1910,2490));
    // $agencias[14]   = array("idagencia" => 3691, "planes" => array(1353,707));
    // $agencias[15]   = array("idagencia" => 5799, "planes" => array(2508,2509));
    // $agencias[16]   = array("idagencia" => 5580, "planes" => array(2610,2621,2622,2623,2624,2625,2626,2627,2628));
    // $agencias[17]   = array("idagencia" => 4496, "planes" => array(1937,1939));
    // $agencias[18]   = array("idagencia" => 4728, "planes" => array(1937,1939));
    // $agencias[19]   = array("idagencia" => 4626, "planes" => array(192));
    // $agencias[20]   = array("idagencia" => 5908 , "planes" => array(2538,2539,2540,2542,2543));
    // $agencias[21]   = array("idagencia" => 4748, "planes" => array(88));
    // $agencias[22]   = array("idagencia" => 3938, "planes" => array(2391,2393,2394,2395,2396,2397,2398,2399,2400,2401,2402,2403,2404,2405,2406));
    // $agencias[23]   = array("idagencia" => 6106, "planes" => array(56,87,88,89,1377,1869));
    // $agencias[24]   = array("idagencia" => 4672, "planes" => array(1716,1717,1718,1719,2106,2107,2108,2109,2110,2111));
    // $agencias[25]   = array("idagencia" => 5906, "planes" => array(1870));
    // $agencias[26]   = array("idagencia" => 5931, "planes" => array(2557,2558,2559,2560,2561,2562,2563,2564,2565,2566));
    // $agencias[27]   = array("idagencia" => 5990, "planes" => array(2557,2558,2559,2560,2561,2562,2563,2564,2565,2566));
    // $agencias[28]   = array("idagencia" => 6057, "planes" => array(2637,2658,2659,2660,2638,2661,2662,2663,2639,2664,2665,2666,2640,2667,2668,2669,2641,2670,2671,2672,2642,2682,2683,2684,2643,2694,2695,2696,2649,2673,2674,2675,2650,2685,2686,2687,2651,2697,2698,2699,2652,2676,2677,2678,2653,2688,2689,2690,2654,2701,2702,2703,2655,2679,2680,2681,2656,2691,2692,2693,2657,2703,2704,2705));
    // $agencias[29]   = array("idagencia" => 6058, "planes" => array(2637,2658,2659,2660,2638,2661,2662,2663,2639,2664,2665,2666,2640,2667,2668,2669,2641,2670,2671,2672,2642,2682,2683,2684,2643,2694,2695,2696,2649,2673,2674,2675,2650,2685,2686,2687,2651,2697,2698,2699,2652,2676,2677,2678,2653,2688,2689,2690,2654,2701,2702,2703,2655,2679,2680,2681,2656,2691,2692,2693,2657,2703,2704,2705));
    // $agencias[30]   = array("idagencia" => 4677, "planes" => array(2017,2018));
    // $agencias[31]   = array("idagencia" => 4626, "planes" => array(200,498,499));
    // $agencias[32]   = array("idagencia" => 4232, "planes" => array(1778));
    // $agencias[33]   = array("idagencia" => 5350, "planes" => array(89));
    // $agencias[34]   = array("idagencia" => 4429, "planes" => array(484,485,486,487,471,476,477,472,478,479,474,480,481,473,482,470,490,491));
    // $agencias[35]   = array("idagencia" => 2297, "planes" => array(21,87,89));
    // $agencias[36]   = array("idagencia" => 5532, "planes" => array(2041,2042,2043));
    // $agencias[37]   = array("idagencia" => 5888, "planes" => array(2530,2531,2532,2533,2534,2535));
    // $agencias[38]   = array("idagencia" => 5923, "planes" => array(267,269,270,272,273,275));
    // $agencias[39]   = array("idagencia" => 5217, "planes" => array(2569,2570));
    // $agencias[40]   = array("idagencia" => 5339, "planes" => array(114,116,21,123,56,87,92));
    // $agencias[41]   = array("idagencia" => 2297, "planes" => array(21,87,89));
    // $agencias[42]   = array("idagencia" => 5248, "planes" => array(21,123));
    // $agencias[43]   = array("idagencia" => 5901, "planes" => array(56,87,88,1869,1377));
    // $agencias[44]   = array("idagencia" => 1425, "planes" => array(157,159,160,162));
    // $agencias[45]   = array("idagencia" => 6115, "planes" => array(2706,2707,2708,2709,2710));
    // $agencias[46]   = array("idagencia" => 6117, "planes" => array(484,485,486,487));

    // foreach($agencias as $agencia)
    // {
    //     $idagencia  = $agencia['idagencia'];
    //     $planes     = $agencia['planes'];

    //     ejecuta_delete($db_postgresql, "DELETE FROM planesagencias WHERE idagencia = $idagencia");
    //     ejecuta_delete($db_postgresql, "DELETE FROM categoriasagencias WHERE idagencia = $idagencia");

    //     $array_categorias = array();

    //     foreach($planes as $idplan)
    //     {
    //         $idcategoria = ejecuta_select($db_postgresql, "SELECT idcategoria FROM planes WHERE idplan = $idplan", "idcategoria");

    //         if(!in_array($idcategoria, $array_categorias))
    //         {
    //             array_push($array_categorias, $idcategoria);
    //         }

    //         ejecuta_insert($db_postgresql, "INSERT INTO planesagencias (idagencia, idplan) VALUES ($idagencia, $idplan) ");
    //     }

    //     foreach($array_categorias as $idcategoria)
    //     {
    //         ejecuta_insert($db_postgresql, "INSERT INTO categoriasagencias (idagencia, idcategoria) VALUES ($idagencia, $idcategoria) ");
    //     }
    // }

    // ASOCIAR CATEGORIA COPORTIVOS A LAS AGENCIAS QUE TENGAN BOLSA DE DIAS COMPRADAS
//         $categoriascorporativosasignadas = 0;
        
//         $agencias = ejecuta_select($db_postgresql, "SELECT idagencia from corporativos where idcorporativo in (select 
//                                                         ordenes.idcorporativo
//                                                     from ordenes 
//                                                     where emisioncorporativa = true
//                                                     group by 1)
//                                                     order by 1 ASC");

//         foreach($agencias['resultado'] as $agencia)
//         {
//             $idagencia = $agencia['idagencia'];

//             $cantidad = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM categoriasagencias WHERE idcategoria = 14 AND idagencia = $idagencia", "cantidad");

//             if($cantidad == 0)
//             {
//                 ejecuta_insert($db_postgresql, "INSERT INTO categoriasagencias (idcategoria, idagencia) VALUES (14, $idagencia)");
//                 $categoriascorporativosasignadas++;
//             }
//         }

//         echo '
// categoriascorporativosasignadas: '.$categoriascorporativosasignadas.'

// ';

    // //  ASOCIAR "ACEPTA BENEFICIOS ADICIONALES" A LAS CATEGORIAS PLANES POR VIAJES Y ANUALES

    // ejecuta_update($db_postgresql, "UPDATE categorias SET aceptabeneficiosadicionales = false ");
    // ejecuta_update($db_postgresql, "UPDATE categorias SET aceptabeneficiosadicionales = true WHERE idcategoria IN (23,24) ");

// //ASOCIAR PLATAFORMAS PAGO A TODAS LAS AGENCIAS
//         $categoriascorporativosasignadas = 0;
        
//         $agencias           = ejecuta_select($db_postgresql, "SELECT idagencia FROM agencias");
//         $plataformaspagos   = ejecuta_select($db_postgresql, "SELECT idplataformapago FROM plataformaspago WHERE idstatus = 1");

//         foreach($agencias['resultado'] as $agencia)
//         {
//             $idagencia = $agencia['idagencia'];

//             foreach($plataformaspagos['resultado'] as $plataformapago)
//             {
//                 $idplataformapago = $plataformapago['idplataformapago'];

//                 ejecuta_insert($db_postgresql, "INSERT INTO agenciasplataformaspago (idagencia, idplataformapago) VALUES ($idagencia, $idplataformapago)");
//             }
//         }

//         echo '

// ';

// //ASOCIAR ID AGENCIA A LOS USUARIOS CORPORATIVOS
            
//     $usuarios_corporativos   = ejecuta_select($db_postgresql, "SELECT 
//                                                                     usuarios.idusuario, 
//                                                                     usuarios.idcorporativo,
//                                                                     corporativos.idagencia
//                                                                 FROM usuarios 
//                                                                 LEFT JOIN corporativos ON usuarios.idcorporativo = corporativos.idcorporativo
//                                                                 WHERE usuarios.escorporativo = true");

//     foreach($usuarios_corporativos['resultado'] as $usuario_corporativo)
//     {
//         $idusuario      = $usuario_corporativo['idusuario'];
//         $idcorporativo  = $usuario_corporativo['idcorporativo'];
//         $idagencia      = $usuario_corporativo['idagencia'];

//         ejecuta_update($db_postgresql, "UPDATE usuarios SET idagencia = $idagencia WHERE idusuario = $idusuario");
//     }

// // QUITAR LAS CATEGORIAS DE LA FUNTES NO PERMITIDAS

//     ejecuta_delete($db_postgresql, "DELETE FROM categoriasfuentes WHERE idfuente = 3 AND idcategoria NOT IN (22, 23, 24, 27) ");

echo '

';


echo '
Proceso Terminado

';

exit;

?>
