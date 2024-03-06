<?php
    date_default_timezone_set('America/Mexico_City');

    $db_postgresql              = getDB();
    $db_mysql                   = connect_db();
    $hora_inicio                = date('h:i:s', time());
    $fecha_hoy                  = date('Y-m-d h:i:s', time());
    $ano_hoy                    = date('Y', time());
    $planes_normalizados        = 0;
    $agencias_normalizadas      = 0;

    echo 'Inicio: '.$hora_inicio.' <br>';

    // VISTAS: VISTAS COMPLETAS
    
        $vistas = ejecuta_select($db_postgresql, "SELECT idvista, nombrevista FROM vistasmaterializadas WHERE idstatus = 1 AND vistacompleta = true AND actualizarautomatico = true");

        foreach($vistas['resultado'] as $vista)
        {
            $idvista        = $vista['idvista'];
            $nombrevista    = $vista['nombrevista'];

            if(ejecuta_select($db_postgresql, "REFRESH MATERIALIZED VIEW ".$nombrevista))
            {
                if(ejecuta_update($db_postgresql, "UPDATE vistasmaterializadas SET fechaactualizacion = '$fecha_hoy' WHERE idvista = $idvista"))
                {
                    echo 'Vista '.$nombrevista.' Actualizada <br>';
                }
            }
        }

    $hora_fin   = date('h:i:s', time());  

    echo 'Fin: '.$hora_fin.' <br> ';
    echo 'Proceso de Actualización Finalizado Exitosamente ! <br> '; 
?>