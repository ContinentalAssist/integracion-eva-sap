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
        echo 'Borrando unificarvouchers...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE vouchersunificados CASCADE");
  
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE unificarvouchers_idunificacion_seq RESTART WITH 1");
    }
    
    // AGENCIAS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: unificarvouchers';

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

        foreach($registros as $registro)
        {
            echo '.';   
            
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

            $insert = "INSERT INTO vouchersunificados (
                                        idunificacion,
                                        codigovoucher,
                                        vaciarbolsa,
                                        diassumados,
                                        diasrestados,
                                        fechaunificacion,
                                        comentarios
                                        )
                                    VALUES(
                                        $idunificacion,
                                        '$codigovoucher',
                                        $vaciarbolsa,
                                        $diassumados,
                                        $diasrestados,
                                        '$fechaunificacion',
                                        '$comentarios'
                                    )";

            if(!ejecuta_insert($db_postgresql, $insert)) {echo $insert;}
        }

    //SECUENCIA UNIFICACIÓN
        $secuencia = $idunificacion + 1;
        $secuencia = "ALTER SEQUENCE unificarvouchers_idunificacion_seq RESTART WITH ".$secuencia; 
        ejecuta_select($db_postgresql, $secuencia);

    $hora_fin   = date('h:i:s', time());  

    echo 'Migración Finalizado Exitosamente !'; 
?>
