<?php

    if(isset($_GET['proceso']))
    {
        include_once '../lib/funciones.php';
        include_once '../lib/pgsql.php';
        include_once '../lib/pgsql-reportes.php';
        include_once '../lib/mysql.php';
        
        if($_GET['proceso'] == 'refrescarVistasMaterializadasCompletas')
        {
            include_once '../refrescarVistasMaterializadasCompletas.php';
        }
        else if($_GET['proceso'] == 'refrescarVistasMaterializadas')
        {
            include_once '../refrescarVistasMaterializadas.php';
        }
        else if($_GET['proceso'] == 'migracionOrdenes')
        {
            include_once '../migracionOrdenes.php';
        }
        else if($_GET['proceso'] == 'migracionAgencias')
        {
            include_once '../migracionAgencias.php';
        }
        else if($_GET['proceso'] == 'migracionPlanes')
        {
            include_once '../migracionPlanes.php';
        }
        else if($_GET['proceso'] == 'migracionContinua')
        {
            include_once '../migracionContinua.php';
        }
        else if($_GET['proceso'] == 'migracion_completa')
        {
            include_once '../migracion_completa.php';
        }
        else if($_GET['proceso'] == 'migracion')
        {
            include_once '../migracion.php';
        }
        else if($_GET['proceso'] == 'limpiar_tablas_psql')
        {
            include_once '../limpiar_tablas_psql.php';
        }
        else if($_GET['proceso'] == 'planes_migrar')
        {
            include_once '../planes_migrar.php';
        }
        
    }
    else
    {
        echo 'Proceso NO definido';
    }
?>