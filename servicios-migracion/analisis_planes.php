<?php 
    include('./lib/funciones.php');
    include('./lib/mysql.php');
    include('./lib/pgsql.php');

    system ('clear');

    $db_postgresql      = getDB();
    $db_mysql           = connect_db();

    $hora_inicio = date('Y-m-d h:i:s', time());
    $fecha_hoy = date('Y-m-d h:i:s', time());   

    echo 'Inicio del Análisis de Planes: '.$hora_inicio.'
    ';

    // PLANES SIN FUENTES ASIGNADAS *******************************************************************************************************************************************************************************
        $select = "SELECT idplan from planes p1 where idplan not in (SELECT idplan from planesfuentes p2) and p1.idstatus = 1"; 
        $select = ejecuta_select($db_postgresql, $select);

        echo '
        Cantidad de PLANES SIN FUENTES ASIGNADAS: '.$select['cantidad'].'
        ';

        if($select['cantidad'] > 0)
        {
            echo 'idplan in (';
            foreach($select['resultado'] as $registro)
            {
                echo $registro['idplan'].',';
            }
            echo ')
            ';
        }

    // PLANES SIN PAISES ASIGNADOS *******************************************************************************************************************************************************************************
        $select = "SELECT idplan from planes p1 where idplan not in (SELECT idplan from planespaises p2) and p1.idstatus = 1"; 
        $select = ejecuta_select($db_postgresql, $select);

        echo '
        Cantidad de PLANES SIN PAISES ASIGNADOS: '.$select['cantidad'].'
        ';

        if($select['cantidad'] > 0)
        {
            echo 'idplan in (';
            foreach($select['resultado'] as $registro)
            {
                echo $registro['idplan'].',';
            }
            echo ')
            ';
        }

    // PLANES SIN ORIGENES ASIGNADOS *******************************************************************************************************************************************************************************
        $select = "SELECT idplan from planes p1 where idplan not in (SELECT idplan from planesorigenes p2) and p1.idstatus = 1"; 
        $select = ejecuta_select($db_postgresql, $select);

        echo '
        Cantidad de PLANES SIN ORIGENES ASIGNADOS: '.$select['cantidad'].'
        ';

        if($select['cantidad'] > 0)
        {
            echo 'idplan in (';
            foreach($select['resultado'] as $registro)
            {
                echo $registro['idplan'].',';
            }
            echo ')
            ';
        }

    // PLANES SIN DESTINO ASIGNADOS *******************************************************************************************************************************************************************************
        $select = "SELECT idplan from planes p1 where idplan not in (SELECT idplan from planesdestinos p2) and p1.idstatus = 1"; 
        $select = ejecuta_select($db_postgresql, $select);

        echo '
        Cantidad de PLANES SIN DESTINO ASIGNADOS: '.$select['cantidad'].'
        ';

        if($select['cantidad'] > 0)
        {
            echo 'idplan in (';
            foreach($select['resultado'] as $registro)
            {
                echo $registro['idplan'].',';
            }
            echo ')
            ';
        }

    // PLANES SIN AGENCIAS ASIGNADAS *******************************************************************************************************************************************************************************
        $select = "SELECT idplan from planes p1 where idplan not in (SELECT idplan from planesagencias p2) and p1.idstatus = 1"; 
        $select = ejecuta_select($db_postgresql, $select);

        echo '
        Cantidad de PLANES SIN AGENCIAS ASIGNADAS: '.$select['cantidad'].'
        ';

        if($select['cantidad'] > 0)
        {
            echo 'idplan in (';
            foreach($select['resultado'] as $registro)
            {
                echo $registro['idplan'].',';
            }
            echo ')
            ';
        }

    // PLANES (ANUALES MULTIVIAJES) SIN BENEFICIOS ADICIONALES *******************************************************************************************************************************************************************************
        $select = "SELECT idplan FROM planes WHERE idplan NOT IN (SELECT idplan FROM planesbeneficiosadicionales) AND idcategoria IN (23) AND idstatus = 1;"; 
        $select = ejecuta_select($db_postgresql, $select);

        echo '
        Cantidad de PLANES (ANUALES MULTIVIAJES) SIN BENEFICIOS ADICIONALES ASIGNADOS: '.$select['cantidad'].'
        ';

        if($select['cantidad'] > 0)
        {
            echo 'idplan in (';
            foreach($select['resultado'] as $registro)
            {
                echo $registro['idplan'].',';
            }
            echo ')
            ';
        }

    // PLANES (PLANES POR VIAJES) SIN BENEFICIOS ADICIONALES *******************************************************************************************************************************************************************************
        $select = "SELECT idplan FROM planes WHERE idplan NOT IN (SELECT idplan FROM planesbeneficiosadicionales) AND idcategoria IN (24) AND idstatus = 1;"; 
        $select = ejecuta_select($db_postgresql, $select);

        echo '
        Cantidad de PLANES (PLANES POR VIAJES) SIN BENEFICIOS ADICIONALES ASIGNADOS: '.$select['cantidad'].'
        ';

        if($select['cantidad'] > 0)
        {
            echo 'idplan in (';
            foreach($select['resultado'] as $registro)
            {
                echo $registro['idplan'].',';
            }
            echo ')
            ';
        }

    // PLANES (ESTUDIANTES) SIN BENEFICIOS ADICIONALES *******************************************************************************************************************************************************************************
        $select = "SELECT idplan FROM planes WHERE idplan NOT IN (SELECT idplan FROM planesbeneficiosadicionales) AND idcategoria IN (27) AND idstatus = 1;"; 
        $select = ejecuta_select($db_postgresql, $select);

        echo '
        Cantidad de PLANES (ESTUDIANTES) SIN BENEFICIOS ADICIONALES ASIGNADOS: '.$select['cantidad'].'
        ';

        if($select['cantidad'] > 0)
        {
            echo 'idplan in (';
            foreach($select['resultado'] as $registro)
            {
                echo $registro['idplan'].',';
            }
            echo ')
            ';
        }

    // PLANES SIN PRECIOS ASIGNADOS *******************************************************************************************************************************************************************************
        $select = "SELECT idplan FROM planes p1 WHERE idplan NOT IN (SELECT idplan FROM planesprecios p2 where p1.fechaactualizacionprecioscostos = p2.fechaactualizacion) AND p1.idstatus = 1;"; 
        $select = ejecuta_select($db_postgresql, $select);

        echo '
        Cantidad de PLANES SIN PRECIOS ASIGNADOS: '.$select['cantidad'].'
        ';

        if($select['cantidad'] > 0)
        {
            echo 'idplan in (';
            foreach($select['resultado'] as $registro)
            {
                echo $registro['idplan'].',';
            }
            echo ')
            ';
        }

    // PLANES SIN BENEFICIOS ASIGNADOS O DESACTUALIZADOS *******************************************************************************************************************************************************************************
        $select = "SELECT idplan from planes p1 where idplan not in (select idplan from planesbeneficios p2 where p1.fechaactualizacionbeneficios = p2.fechaactualizacion ) and p1.idstatus = 1"; 
        $select = ejecuta_select($db_postgresql, $select);

        echo '
        Cantidad de PLANES SIN BENEFICIOS ASIGNADOS O DESACTUALIZADOS: '.$select['cantidad'].'
        ';

        if($select['cantidad'] > 0)
        {
            echo 'idplan in (';
            foreach($select['resultado'] as $registro)
            {
                echo $registro['idplan'].',';
            }
            echo ')
            ';
        }

    // PLANES SIN COSTOS ASIGNADOS O DESACTUALIZADOS *******************************************************************************************************************************************************************************
        $select = "SELECT idplan from planes p1 where idplan not in (select idplan from planescostos p2 where p1.fechaactualizacionprecioscostos = p2.fechaactualizacion ) and p1.idstatus = 1"; 
        $select = ejecuta_select($db_postgresql, $select);

        echo '
        Cantidad de PLANES SIN COSTOS ASIGNADOS O DESACTUALIZADOS: '.$select['cantidad'].'
        ';

        if($select['cantidad'] > 0)
        {
            echo 'idplan in (';
            foreach($select['resultado'] as $registro)
            {
                echo $registro['idplan'].',';
            }
            echo ')
            ';
        }

        ;

echo '

';

    $hora_fin   = date('Y-m-d h:i:s', time());  

    echo ' Analisis Finalizado Exitosamente !
    '; 
    echo 'Fin del Análisis: '.$hora_fin.'
    ';
?>
