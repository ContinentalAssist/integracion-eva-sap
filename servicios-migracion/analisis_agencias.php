<?php 
    include('./lib/funciones.php');
    include('./lib/mysql.php');
    include('./lib/pgsql.php');

    system ('clear');

    $db_postgresql      = getDB();
    $db_mysql           = connect_db();

    $hora_inicio = date('Y-m-d h:i:s', time());
    $fecha_hoy = date('Y-m-d h:i:s', time());   

    echo 'Inicio del Análisis de Agencias: '.$hora_inicio.'
    ';

    // AGENCIAS SIN CATEGORIAS ASIGNADAS *******************************************************************************************************************************************************************************
        $select = "SELECT idagencia from agencias where idagencia not in (SELECT idagencia from categoriasagencias)"; 
        $select = ejecuta_select($db_postgresql, $select);

        echo '
        Cantidad de AGENCIAS SIN CATEGORIAS ASIGNADAS: '.$select['cantidad'].'
        ';

        if($select['cantidad'] > 0)
        {
            echo 'idagencia in (';
            foreach($select['resultado'] as $registro)
            {
                echo $registro['idagencia'].',';
            }
            echo ')
            ';
        }

    // AGENCIAS SIN PLANES ASIGNADOS *******************************************************************************************************************************************************************************
        $select = "SELECT idagencia from agencias where idagencia not in (SELECT idagencia from planesagencias)"; 
        $select = ejecuta_select($db_postgresql, $select);

        echo '
        Cantidad de AGENCIAS SIN PLANES ASIGNADOS: '.$select['cantidad'].'
        ';

        if($select['cantidad'] > 0)
        {
            echo 'idagencia in (';
            foreach($select['resultado'] as $registro)
            {
                echo $registro['idagencia'].',';
            }
            echo ')
            ';
        }

    // AGENCIAS SIN COMISIONES DE PLANES ASIGNADOS *******************************************************************************************************************************************************************************
        $select = "SELECT idagencia FROM agencias WHERE idagencia NOT IN (SELECT idagencia from comisionesagencias)"; 
        $select = ejecuta_select($db_postgresql, $select);

        echo '
        Cantidad de AGENCIAS SIN COMISIONES DE PLANES ASIGNADOS: '.$select['cantidad'].'
        ';

        if($select['cantidad'] > 0)
        {
            echo 'idagencia in (';
            foreach($select['resultado'] as $registro)
            {
                echo $registro['idagencia'].',';
            }
            echo ')
            ';
        }

    

echo '

';

    $hora_fin   = date('Y-m-d h:i:s', time());  

    echo ' Analisis Finalizado Exitosamente !
    '; 
    echo 'Fin del Análisis: '.$hora_fin.'
    ';
?>
