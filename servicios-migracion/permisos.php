<?php 
    include('./lib/funciones.php');
    include('./lib/mysql.php');
    include('./lib/pgsql.php');

    system ('clear');

    $db_postgresql      = getDB();
    $db_mysql           = connect_db();

    $hora_inicio            = date('h:i:s', time());
    $fecha_hoy              = date('Y-m-d h:i:s', time());

    echo '
            Inicio: '.$hora_inicio.' 
    ';

// // PROCESO DE ASIGNACION DE PERMISOS POR DEFECTO

    ejecuta_delete($db_postgresql, "DELETE FROM permisos");

    ejecuta_update($db_postgresql, "ALTER SEQUENCE permisosasignacion_idpermiso_seq RESTART WITH 1");

    $empresas           = ejecuta_select($db_postgresql, "SELECT idempresa FROM empresas WHERE idempresa = 1");
    $paises             = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE essede = 'true'");
    $agencias           = ejecuta_select($db_postgresql, "SELECT idagencia FROM agencias");
    $niveles            = ejecuta_select($db_postgresql, "SELECT idnivel FROM niveles");
    $tiposusuario       = ejecuta_select($db_postgresql, "SELECT idtipousuario FROM tiposusuario");
    $usuarios           = ejecuta_select($db_postgresql, "SELECT idusuario FROM usuarios");
    
// PERMISOS EMPRESAS

        echo '
Asignando Permisos a las Empresas
        ';

        foreach($empresas['resultado'] as $empresa)
        {
            $idempresa = $empresa['idempresa'];
            $sistemas  = ejecuta_select($db_postgresql, "SELECT idsistema FROM sistemas WHERE idempresa = $idempresa");

            foreach($sistemas['resultado'] as $sistema)
            {
                $idsistema              = $sistema['idsistema'];
                $modulos                = ejecuta_select($db_postgresql, "SELECT idmodulo FROM modulos");
                $insert_modulos         = "INSERT INTO permisos ( idempresa, idmodulo, permiso, moduloasignadodesde ) VALUES ";
                $array_valores_modulos  = array();

                foreach($modulos['resultado'] as $modulo)
                {
                    $idmodulo = $modulo['idmodulo'];
                    array_push($array_valores_modulos, "( $idempresa, $idmodulo, 'true', 'Por Defecto' )");

                    $funciones              = ejecuta_select($db_postgresql, "SELECT idfuncion FROM funciones WHERE idmodulo = $idmodulo");
                    $insert_funciones       = "INSERT INTO permisos ( idempresa, idmodulo, idfuncion, permiso, funcionasignadadesde ) VALUES  ";
                    $array_valores_funciones  = array();
                    
                    if($funciones['cantidad'] > 0)
                    {
                        foreach($funciones['resultado'] as $funcion)
                        {
                            $idfuncion = $funcion['idfuncion'];
                            array_push($array_valores_funciones, "( $idempresa, $idmodulo, $idfuncion, 'true', 'Por Defecto' )");
                        }

                        $valores_funciones    = implode(",", $array_valores_funciones);
                        $insert_funciones     = $insert_funciones.$valores_funciones;
    
                        ejecuta_insert($db_postgresql, $insert_funciones);
                    }
                }

                $valores_modulos    = implode(",", $array_valores_modulos);
                $insert_modulos     = $insert_modulos.$valores_modulos;

                ejecuta_insert($db_postgresql, $insert_modulos);
            }
        }

// PERMISOS SISTEMAS

    echo '
Asignando Permisos a los Sistemas
    ';

    $sistemas  = ejecuta_select($db_postgresql, "SELECT idsistema FROM sistemas");
    
    foreach($sistemas['resultado'] as $sistema)
    {
        $idsistema              = $sistema['idsistema'];
        $modulos                = ejecuta_select($db_postgresql, "SELECT idmodulo FROM modulos");
        $insert_modulos         = "INSERT INTO permisos ( idsistema, idmodulo, permiso, moduloasignadodesde ) VALUES ";
        $array_valores_modulos  = array();

        if($modulos['cantidad'] > 0)
        {
            foreach($modulos['resultado'] as $modulo)
            {
                $idmodulo = $modulo['idmodulo'];
    
                array_push($array_valores_modulos, "( $idsistema, $idmodulo, 'true', 'Por Defecto'  )");
    
                $funciones              = ejecuta_select($db_postgresql, "SELECT idfuncion FROM funciones WHERE idmodulo = $idmodulo");
                $insert_funciones       = "INSERT INTO permisos ( idsistema, idmodulo, idfuncion, permiso, funcionasignadadesde ) VALUES  ";
                $array_valores_funciones  = array();
                
                if($funciones['cantidad'] > 0)
                {
                    foreach($funciones['resultado'] as $funcion)
                    {
                        $idfuncion = $funcion['idfuncion'];
                        array_push($array_valores_funciones, "( $idsistema, $idmodulo, $idfuncion, 'true', 'Por Defecto'  )");
                    }

                    $valores_funciones    = implode(",", $array_valores_funciones);
                    $insert_funciones     = $insert_funciones.$valores_funciones;
        
                    ejecuta_insert($db_postgresql, $insert_funciones);
                }
            }

            $valores_modulos    = implode(",", $array_valores_modulos);
            $insert_modulos     = $insert_modulos.$valores_modulos;
    
            ejecuta_insert($db_postgresql, $insert_modulos);
        }
    }
    
    
// PERMISOS PAISES

    echo '
Asignando Permisos a los Paises
    ';

    foreach($paises['resultado'] as $pais)
    {
        $idpais = $pais['idpais'];

        $sistemas  = ejecuta_select($db_postgresql, "SELECT idsistema FROM sistemas WHERE idempresa = 1");

        foreach($sistemas['resultado'] as $sistema)
        {
            $idsistema              = $sistema['idsistema'];
            $modulos                = ejecuta_select($db_postgresql, "SELECT idmodulo FROM modulos WHERE idsistema = $idsistema");
            $insert_modulos         = "INSERT INTO permisos ( idpais, idmodulo, permiso, moduloasignadodesde) VALUES ";
            $array_valores_modulos  = array();

            if($modulos['cantidad'] > 0)
            {
                foreach($modulos['resultado'] as $modulo)
                {
                    $idmodulo = $modulo['idmodulo'];

                    array_push($array_valores_modulos, "( $idpais, $idmodulo, 'true', 'Por Defecto'  )");

                    $funciones              = ejecuta_select($db_postgresql, "SELECT idfuncion FROM funciones WHERE idmodulo = $idmodulo");
                    $insert_funciones       = "INSERT INTO permisos ( idpais, idmodulo, idfuncion, permiso, funcionasignadadesde ) VALUES  ";
                    $array_valores_funciones  = array();
                    
                    if($funciones['cantidad'] > 0)
                    {
                        foreach($funciones['resultado'] as $funcion)
                        {
                            $idfuncion = $funcion['idfuncion'];
                            array_push($array_valores_funciones, "( $idpais, $idmodulo, $idfuncion, 'true', 'Por Defecto'  )");
                        }

                        $valores_funciones    = implode(",", $array_valores_funciones);
                        $insert_funciones     = $insert_funciones.$valores_funciones;

                        ejecuta_insert($db_postgresql, $insert_funciones);
                    }
                }

                $valores_modulos    = implode(",", $array_valores_modulos);
                $insert_modulos     = $insert_modulos.$valores_modulos;

                ejecuta_insert($db_postgresql, $insert_modulos);
            }
        }
    }

// PERMISOS NIVELES

    echo '
Asignando Permisos a los Niveles
    ';

    $niveles  = ejecuta_select($db_postgresql, "SELECT idnivel FROM niveles");
    
    foreach($niveles['resultado'] as $nivel)
    {
        $idnivel = $nivel['idnivel'];

        $sistemas  = ejecuta_select($db_postgresql, "SELECT idsistema FROM sistemas WHERE idempresa = 1");

        foreach($sistemas['resultado'] as $sistema)
        {
            $idsistema              = $sistema['idsistema'];
            $modulos                = ejecuta_select($db_postgresql, "SELECT idmodulo FROM modulos WHERE idsistema = $idsistema");
            $insert_modulos         = "INSERT INTO permisos ( idnivel, idmodulo, permiso, moduloasignadodesde ) VALUES ";
            $array_valores_modulos  = array();

            if($modulos['cantidad'] > 0)
            {
                foreach($modulos['resultado'] as $modulo)
                {
                    $idmodulo = $modulo['idmodulo'];

                    array_push($array_valores_modulos, "( $idnivel, $idmodulo, 'true', 'Por Defecto'  )");

                    $funciones              = ejecuta_select($db_postgresql, "SELECT idfuncion FROM funciones WHERE idmodulo = $idmodulo");
                    $insert_funciones       = "INSERT INTO permisos ( idnivel, idmodulo, idfuncion, permiso, funcionasignadadesde ) VALUES  ";
                    $array_valores_funciones  = array();
                    
                    if($funciones['cantidad'] > 0)
                    {
                        foreach($funciones['resultado'] as $funcion)
                        {
                            $idfuncion = $funcion['idfuncion'];
                            array_push($array_valores_funciones, "( $idnivel, $idmodulo, $idfuncion, 'true', 'Por Defecto'  )");
                        }

                        $valores_funciones    = implode(",", $array_valores_funciones);
                        $insert_funciones     = $insert_funciones.$valores_funciones;

                        ejecuta_insert($db_postgresql, $insert_funciones);
                    }
                }

                $valores_modulos    = implode(",", $array_valores_modulos);
                $insert_modulos     = $insert_modulos.$valores_modulos;

                ejecuta_insert($db_postgresql, $insert_modulos);
            }
        }
    }


// PERMISOS TIPOS USUARIOS

    echo '
Asignando Permisos a los Tipos de Usuarios
    ';

    $array_todos_funciones      = array();
    $array_funciones            = array();
    $array_todos_modulos        = array();

    $todos_modulos = ejecuta_select($db_postgresql, "SELECT idmodulo FROM modulos");

    foreach($todos_modulos['resultado'] as $modulo)
    {
        array_push($array_todos_modulos, $modulo['idmodulo']);
    }
    
    $todos_funciones = ejecuta_select($db_postgresql, "SELECT idmodulo, idfuncion FROM funciones");

    foreach($todos_funciones['resultado'] as $funcion)
    {
        array_push($array_todos_funciones, $funcion['idfuncion']);
        array_push($array_funciones, $funcion);
    }

    $todos_tiposusuarios = ejecuta_select($db_postgresql, "SELECT idtipousuario FROM tiposusuario");

    foreach($todos_tiposusuarios['resultado'] as $tipousuario)
    {
        $idtipousuario = $tipousuario['idtipousuario'];

        foreach($array_todos_modulos as $idmodulo)
        {
            ejecuta_insert($db_postgresql, "INSERT INTO permisos (idtipousuario, idmodulo, permiso, moduloasignadodesde) VALUES ($idtipousuario, $idmodulo, 'false', 'Por Defecto' )");
        }

        foreach($array_funciones as $funcion)
        {
            $idmodulo   = $funcion['idmodulo'];
            $idfuncion  = $funcion['idfuncion'];

            ejecuta_insert($db_postgresql, "INSERT INTO permisos (idtipousuario, idfuncion, idmodulo, permiso, funcionasignadadesde) VALUES ($idtipousuario, $idfuncion, $idmodulo, 'false', 'Por Defecto' )");
        }
    }

    $tiposusuario_permisos = array(
        array('idtipousuario' => 1, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,49,31,32,27,56,2,20,26,52,53,55,57,17,47,76,87,23,83,11), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,91,93,92,88,13,151,90,152,175,48,38,160,82,169,145,140,146,170,142,147,144,148,149,112,115,114,113,183,85,84,171,174,116,118,119,177,179,182,180,181,178,184,94,96,97,98,105,100,101,102,103,104,106,108,109,111,72,74,26,34,61,63,185,187,78,80,81,188,189,190)),
        array('idtipousuario' => 2, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,49,27,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,93,90,175,48,38,160,144,177)),
        array('idtipousuario' => 3, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,49,27,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,90,175,48,38,160,144,177)),
        array('idtipousuario' => 4, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,49,31,27,56,2,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,93,88,151,90,152,48,38,160,82,145,140,146,170,142,147,144,148,149,112,115,114,113,85,84,171,174,177,179,182,181)),
        array('idtipousuario' => 5, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,27,2,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,93,88,151,90,152,48,38,140,146,170,142,147,144,148,149,85,84,171,174,177,179,182,181)),
        array('idtipousuario' => 6, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,27,2,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,93,88,151,90,152,48,38,140,146,170,142,147,144,148,149,171,177,179,182,181)),
        array('idtipousuario' => 7, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,27,2,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,93,88,151,90,152,48,38,140,146,170,142,147,144,148,149,171,177,179,182,181)),
        array('idtipousuario' => 8, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,27,2,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,88,151,90,152,48,140,146,170,142,147,144,148,149,171,177,179,182,181)),
        array('idtipousuario' => 9, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,27,2,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,93,88,151,90,152,48,38,140,146,170,142,147,144,148,149,171,177,179,182,181)),
        array('idtipousuario' => 10, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,27,2,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,88,151,90,152,48,144,171,177,179,182,181)),
        array('idtipousuario' => 11, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,27,2,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,93,88,151,90,152,48,38,140,146,170,142,147,144,148,149,171,177,179,182,181)),
        array('idtipousuario' => 12, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,27,2,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,88,151,90,152,48,144,171,177,179,182,181)),
        array('idtipousuario' => 13, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,27,2,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,93,88,151,90,152,48,38,140,146,170,142,147,144,148,149,171,177,179,182,181)),
        array('idtipousuario' => 14, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,27,2,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,88,151,90,152,48,144,171,177,179,182,181)),
        array('idtipousuario' => 100, 'modulos' => $array_todos_modulos, "funciones" => $array_todos_funciones)
    );

    foreach($tiposusuario_permisos as $tipousuario)
    {
        $idtipousuario  = $tipousuario['idtipousuario'];
        $modulos        = $tipousuario['modulos'];
        $funciones      = $tipousuario['funciones'];

        foreach($modulos as $idmodulo)
        {
            ejecuta_update($db_postgresql, "UPDATE permisos SET permiso = 'true' WHERE idtipousuario = $idtipousuario AND idmodulo = $idmodulo AND idfuncion IS NULL");
        }

        foreach($funciones as $idfuncion)
        {
            foreach($array_funciones as $array_funcion)
            {
                if($array_funcion['idfuncion'] == $idfuncion)
                {
                    $idmodulo = $array_funcion['idmodulo'];
                    ejecuta_update($db_postgresql, "UPDATE permisos SET permiso = 'true' WHERE idtipousuario = $idtipousuario AND idmodulo = $idmodulo AND idfuncion = $idfuncion");
                }
            }
        }
    }

echo '
Asignando Roles
';

// ASIGNAR ROL AGENTES COMERCIALES DE TODOS LOS NIVELES 1,2,3,4

    $idtipousuario  = 8;

    for($i = 1; $i <= 4; $i++)
    {
        $usuarios          = ejecuta_select($db_postgresql, "SELECT idusuario FROM usuarios LEFT JOIN agencias ON usuarios.idagencia = agencias.idagencia WHERE agencias.idnivel = $i");
        $array_usuarios    = array();

        foreach($usuarios['resultado'] as $usuario)
        {
            array_push($array_usuarios, $usuario['idusuario']);
        }

        $usuarios   = implode(",", $array_usuarios);
        $update     = "UPDATE usuarios SET idtipousuario = $idtipousuario WHERE idusuario IN (".$usuarios.")";

        ejecuta_update($db_postgresql, $update);

        $idtipousuario++;
        $idtipousuario++;
    }


// ASIGNAR ROLES ESPECIALES

$tiposusuario = array(
    array("idtipousuario" => 1, "usuarios" => array(
        array("idusuario" => 11, "nombre" => "Eli Soued"),
        array("idusuario" => 1076, "nombre" => "Deborah Rosenfeld"),
        array("idusuario" => 2581, "nombre" => "Johana Ramirez")
    )),
    array("idtipousuario" => 2, "usuarios" => array(
        array("idusuario" => 3204, "nombre" => "Maria Jarque"),
        array("idusuario" => 11644, "nombre" => "Juan Manuel"),
        array("idusuario" => 10777, "nombre" => "Yulian Moreno"),
        array("idusuario" => 10363, "nombre" => "Luz Benavides"),
        array("idusuario" => 278, "nombre" => "Luz Benavides"),
        array("idusuario" => 11945, "nombre" => "Ilana Areiza")
    )),
    array("idtipousuario" => 3, "usuarios" => array(
        array("idusuario" => 10957, "nombre" => "Agustín Bastidas"),
        array("idusuario" => 3320, "nombre" => "Saúl Martinez")
    )),
    array("idtipousuario" => 4, "usuarios" => array(
        array("idusuario" => 3550, "nombre" => "Noemi Hernandez"),
        array("idusuario" => 9437, "nombre" => "Iván Gómez"),
        array("idusuario" => 7142, "nombre" => "Katerine Pedroza")
    )),
    array("idtipousuario" => 5, "usuarios" => array(
        array("idusuario" => 11594, "nombre" => "Aaron Nuñez"),
        array("idusuario" => 10653, "nombre" => "Angela Natalia"),
    )),
    array("idtipousuario" => 6, "usuarios" => array(
        array("idusuario" => 3671, "nombre" => "Rosa Manjarez"),
        array("idusuario" => 6254, "nombre" => "Daniel Rojas"),
        array("idusuario" => 10727, "nombre" => "Cesar Rodriguez"),
        array("idusuario" => 7828, "nombre" => "Maricruz Muñoz"),
        array("idusuario" => 4229, "nombre" => "Catalina Zamora "),
        array("idusuario" => 8995, "nombre" => "Catalina Zamora "),
        array("idusuario" => 4892, "nombre" => "Carolina Acero"),
        array("idusuario" => 11868, "nombre" => "Andrea Pardo")
    )),
    array("idtipousuario" => 7, "usuarios" => array(
        array("idusuario" => 11217, "nombre" => "Francisco Martinez"),
        array("idusuario" => 8617, "nombre" => "Ximena Cortes"),
        array("idusuario" => 10686, "nombre" => "Georgina Ochoa"),
        array("idusuario" => 10852, "nombre" => "Ada Duarte"),
        array("idusuario" => 8373, "nombre" => "Georgina Davila"),
        array("idusuario" => 10769, "nombre" => "Sandra Morales"),
        array("idusuario" => 10599, "nombre" => "Erika Retavisca")
    ))
);

foreach($tiposusuario as $tipousuario)
{
    $idtipousuario  = $tipousuario['idtipousuario'];
    $usuarios       = $tipousuario['usuarios'];

    $array_usuarios = array();

    foreach($usuarios as $usuario)
    {
        array_push($array_usuarios, $usuario['idusuario']);
    }   

    $implode = implode(",", $array_usuarios);
    $update = "UPDATE usuarios SET idtipousuario = $idtipousuario WHERE idusuario IN (".$implode.")";
    ejecuta_update($db_postgresql, $update);
}


echo '
Proceso Terminado

';

exit;

?>
