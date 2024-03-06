<?php
    $db_postgresql      = getDB();
    $db_mysql           = connect_db();

    system ('clear');

    $hora_inicio        = date('h:i:s', time());

    echo '
    Inicio: '.$hora_inicio.' 
';

$limpiar_tablas     = true;

// echo 'Configurar los planes que las agencias utilizan para los webservices'; exit;
// echo 'Configurar todas las plataformas de pago en USD para todos los planes'; exit;
// echo 'Configurar todas las plataformas de pago para todas las agencias'; exit;
// echo 'Configurar comisiones para todas las agencias'; 

if($limpiar_tablas)
{
        /*** CUIDADO, SOLO INCLUIR $db_postgresql ***********************************************************/
        /**/ 
        /**/ 
        echo '
    Borrando cuponesagencias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE cuponesagencias CASCADE");

        echo '
    Borrando cuponesplanes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE cuponesplanes CASCADE");

        echo '
    Borrando cuponesfuentes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE cuponesfuentes CASCADE");

        echo '
    Borrando cuponescategorias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE cuponescategorias CASCADE");

        echo '
    Borrando categoriasagencias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE categoriasagencias CASCADE");

        echo '
    Borrando planesbeneficios...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficios CASCADE");

        echo '
    Borrando planesbeneficiosproveedores...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficiosproveedores CASCADE");

        echo '
    Borrando planesbeneficiosadicionales...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficiosadicionales CASCADE");

        echo '
    Borrando planesbeneficiosadicionalesproveedores...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficiosadicionalesproveedores CASCADE");

        echo '
    Borrando planesprecios...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesprecios CASCADE");

        echo '
    Borrando planescostos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planescostos CASCADE");

        echo '
    Borrando planesagencias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesagencias CASCADE");

        echo '
    Borrando planespaises...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planespaises CASCADE");

        echo '
    Borrando planesfuentes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesfuentes CASCADE");

        echo '
    Borrando planesorigenes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesorigenes CASCADE");

        echo '
    Borrando planesdestinos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesdestinos CASCADE");

        echo '
    Borrando planesplataformaspago...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesplataformaspago CASCADE");

        echo '
    Borrando beneficioscategorias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE beneficioscategorias CASCADE");

        echo '
    Borrando categoriasfuentes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE categoriasfuentes CASCADE");

        echo '
    Borrando categoriasorigenes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE categoriasorigenes CASCADE");

        echo '
    Borrando categoriaspaises...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE categoriaspaises CASCADE");

        echo '
    Borrando categoriasdestinos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE categoriasdestinos CASCADE");

        echo '
    Borrando crucerosordenes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE crucerosordenes CASCADE");

        echo '
    Borrando auditorias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE auditorias CASCADE");

        echo '
    Borrando beneficios...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE beneficios CASCADE");

        echo '
    Borrando beneficiarioscostos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE beneficiarioscostos CASCADE");

        echo '
    Borrando beneficiariosbeneficiosadicionales...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE beneficiariosbeneficiosadicionales CASCADE");

        echo '
    Borrando beneficiarios...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE beneficiarios CASCADE");

        echo '
    Borrando asistenciascorporativas...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE asistenciascorporativas CASCADE");

        echo '
    Borrando asistenciascorporativasviajes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE asistenciascorporativasviajes CASCADE");

        echo '
    Borrando asistenciasviajes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE asistenciasviajes CASCADE");

        echo '
    Borrando categorias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE categorias CASCADE");

        echo '
    Borrando cruceros...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE cruceros CASCADE");

        echo '
    Borrando cupones...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE cupones CASCADE");

        echo '
    Borrando planes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planes CASCADE");

        echo '
    Borrando usuarios...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE usuarios CASCADE");

        echo '
    Borrando agencias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE agencias CASCADE");

        echo '
    Borrando comisionesagencias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE comisionesagencias CASCADE");

        echo '
    Borrando precompras...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE precompras CASCADE");

        echo '
    Borrando corporativos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE corporativos CASCADE");

        echo '
    Borrando ordenescomisiones...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE ordenescomisiones CASCADE");

        echo '
    Borrando ordenescontactos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE ordenescontactos CASCADE");

        echo '
    Borrando ordenescostos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE ordenescostos CASCADE");

        echo '
    Borrando ordenes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE ordenes CASCADE");

        echo '
    Borrando Permisos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE permisos CASCADE");

        echo '
    Borrando unificarvouchers...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE vouchersunificados CASCADE");

        echo '
    Borrando cotizaciones...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE cotizaciones CASCADE");


        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE auditorias_idauditoria_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE usuarios_idusuario_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE agencias_idagencia_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficios_idbeneficio_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficioscategorias_idbeneficiocategoria_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categorias_idcategoria_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriasagencias_idcategoriaagencia_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriasdestinos_idcategoriadestino_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriasfuentes_idcategoriafuente_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriasorigenes_idcategoriaorigen_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE categoriaspaises_idcategoriapais_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cruceros_idcrucero_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE crucerosordenes_idcruceroorden_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cupones_idcupon_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cuponesfuentes_idcuponfuente_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cuponesagencias_idcuponagencia_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cuponesplanes_idcuponplan_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cuponescategorias_idcuponcategoria_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planes_idplan_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesprecios_idplanprecio_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planescostos_idplancosto_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesagencias_idplanesagencias_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesbeneficios_idplanbeneficio_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesbeneficiosadicionales_idplanbeneficioadicional_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesbeneficiosadicionalespr_idplanbeneficioadicionalprove_seq RESTART WITH 1");                                                                                                                      
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficiarioscostos_idbeneficiariocosto_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficiariosbeneficiosadicio_idbeneficiariobeneficioadicio_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE beneficiarios_idbeneficiario_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE asistenciasviajes_idasistenciaviaje_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE precompra_idprecompra_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE ordenes_idorden_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE ordenescomisiones_idordencomision_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE ordenescontactos_idordencontacto_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE asistenciascorporativasviajes_idasistenciacorporativaviaje_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE asistenciascorporativas_idasistenciacorporativa_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE ordenescostos_idordencosto_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE corporativos_idcorporativo_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planespaises_idplanpais_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesfuentes_idplanfuente_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesorigenes_idplanorigen_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesdestinos_idplandestino_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesbeneficiosproveedores_idplanbeneficioproveedor_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE permisosasignacion_idpermiso_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planescostos_idplancosto_seq1 RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesplataformaspago_idplanplataformapago_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE unificarvouchers_idunificacion_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE ordenesguardadas_idordenguardada_seq RESTART WITH 1");
    
    
}















// MIGRAR TABLAS POR DEFECTO











//CATEGORIAS *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: categorias...';

$categorias = array();


$mysql_categorias = $db_mysql->query("SELECT 
                                        id_plan_categoria as idcategoria, 
                                        CAST(CONVERT(name_plan USING utf8) AS binary) as nombrecategoria,
                                        1 as idstatus,
                                        '' as nombrecategoriaen,
                                        CAST(CONVERT(description_plan USING utf8) AS binary) as descripcioncategoria,
                                        '' as descripcioncategoriaen,
                                        moneda as moneda,
                                        min_time as tiempominimo,
                                        max_time as tiempomaximo,
                                        min_age as edadminima,
                                        max_age as edadmaxima,
                                        true as planfamiliar
                                    FROM plan_categoria_detail
                                    WHERE language_id = 'spa'
                                    ");
while ($row = $mysql_categorias->fetch_array(MYSQLI_ASSOC)) 
{
    $categorias[] = $row;
}



$insert = "INSERT INTO categorias (
                    idcategoria,
                    nombrecategoria,
                    idstatus,
                    nombrecategoriaen,
                    descripcioncategoria,
                    descripcioncategoriaen,
                    idmoneda,
                    tiempominimo,
                    tiempomaximo,
                    edadminima,
                    edadmaxima,
                    planfamiliar
                )
            VALUES ";

$array_valores = array();

foreach($categorias as $categoria)
{
    $idcategoria                = $categoria['idcategoria']; 
    $nombrecategoria            = $categoria['nombrecategoria']; 
    $idstatus                   = ($categoria['idstatus'] == 0) ? 2 : $categoria['idstatus']; 
    $nombrecategoriaen          = $categoria['nombrecategoriaen']; 
    $descripcioncategoria       = $categoria['nombrecategoria']; 
    $descripcioncategoriaen     = $categoria['nombrecategoriaen']; 
    $monedacategoria            = $categoria['moneda']; 
    $idmoneda                   = ejecuta_select($db_postgresql, "SELECT idmoneda FROM monedas WHERE codigo = '$monedacategoria'",'idmoneda');
    $tiempominimo               = $categoria['tiempominimo']; 
    $tiempomaximo               = $categoria['tiempomaximo']; 
    $edadminima                 = $categoria['edadminima']; 
    $edadmaxima                 = $categoria['edadmaxima']; 
    $planfamiliar               = $categoria['planfamiliar']; 

    $valor     = "(
                        $idcategoria,
                        '$nombrecategoria',
                        $idstatus,
                        '$nombrecategoriaen',
                        '$descripcioncategoria',
                        '$descripcioncategoriaen',
                        $idmoneda,
                        $tiempominimo,
                        $tiempomaximo,
                        $edadminima,
                        $edadmaxima,
                        '$planfamiliar'
                )";

    array_push($array_valores, $valor);
}

$valores = implode(",", $array_valores);
$insert = $insert.$valores;

if(ejecuta_insert($db_postgresql, $insert) == 0) 
{
    echo $insert;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}


$mysql_categorias = $db_mysql->query("SELECT 
                                            id_plan_categoria as idcategoria, 
                                            CAST(CONVERT(name_plan USING utf8) AS binary) as nombrecategoria,
                                            CAST(CONVERT(description_plan USING utf8) AS binary) as descripcioncategoria
                                        FROM plan_categoria_detail
                                        WHERE language_id = 'eng'
                                        ");

while ($row = $mysql_categorias->fetch_array(MYSQLI_ASSOC)) 
{
    $categorias[] = $row;
}

foreach($categorias as $categoria)
{   
    $idcategoria            = $categoria['idcategoria'];
    $nombrecategoriaen      = $categoria['nombrecategoria'];
    $descripcioncategoriaen = $categoria['descripcioncategoria'];

    $update = "UPDATE categorias SET nombrecategoriaen = '$nombrecategoriaen', descripcioncategoriaen = '$descripcioncategoriaen' WHERE  idcategoria = $idcategoria ";
    
    if(!ejecuta_update($db_postgresql, $update)) echo $update;
}

$secuencia = $idcategoria + 1;
$secuencia = "ALTER SEQUENCE categorias_idcategoria_seq1 RESTART WITH ".$secuencia; 
ejecuta_select($db_postgresql, $secuencia);










// ACTUALIZACIONES 
    ejecuta_update($db_postgresql, "UPDATE public.categorias SET nombrecategoria='Cruceros', idstatus=1, nombrecategoriaen='Cruises', descripcioncategoria='Cruceros', descripcioncategoriaen='Not only does it protect while traveling by sea or rivers, but you are protected in the event of early termination, since we will refund 100% of the penalty that applies the shipping, if you could start your journey by unforeseen covered by the plan. Whats more, you also protect your luggage in case of delay or loss on international flights to and from the cruise departure ports and their country of permanent residence.', idmoneda=1, tiempominimo=1, tiempomaximo=30, edadminima=1, edadmaxima=75, planfamiliar=true, publico=false, aceptabeneficiosadicionales=false, aceptafactorconversion=true, idtipoasistencia=1, validamontoviaje=true, edadmaximaplanfamiliar=70, idcategoriasapusa=NULL, idcategoriasapmex=NULL, idcategoriasapcol=NULL WHERE idcategoria=25; ");
    ejecuta_update($db_postgresql, "UPDATE public.categorias SET nombrecategoria='Cruceros', idstatus=1, nombrecategoriaen='Cruises', descripcioncategoria='Cruceros', descripcioncategoriaen='Not only does it protect while traveling by sea or rivers, but you are protected in the event of early termination, since we will refund 100% of the penalty that applies the shipping, if you could start your journey by unforeseen covered by the plan. Whats more, you also protect your luggage in case of delay or loss on international flights to and from the cruise departure ports and their country of permanent residence.', idmoneda=1, tiempominimo=1, tiempomaximo=30, edadminima=1, edadmaxima=75, planfamiliar=true, publico=false, aceptabeneficiosadicionales=false, aceptafactorconversion=true, idtipoasistencia=1, validamontoviaje=true, edadmaximaplanfamiliar=70, idcategoriasapusa=NULL, idcategoriasapmex=NULL, idcategoriasapcol=NULL WHERE idcategoria=25;");




// BENEFICIOS *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: beneficios...';

$beneficios_spa = array();
$beneficios_eng = array();

$mysql_beneficios = $db_mysql->query("SELECT 
                                            id_beneficio as idbeneficio, 
                                            CAST(CONVERT(name USING utf8) AS binary) as nombrebeneficio,
                                            COALESCE(id_status, 'false') as idstatus,
                                            '2000-01-01 00:00:00' as fechacreacion,
                                            '2000-01-01 00:00:00' as fechamodificacion,
                                            min_age as edadminima,
                                            max_age as edadmaxima,
                                            CAST(CONVERT(descripcion USING utf8) AS binary) as descripcionbeneficio,
                                            COALESCE(id_fam, 0) as idfamilia,
                                            1 as idtipoasistencia
                                        FROM beneficios 
                                        WHERE language_id = 'spa'
                                        ORDER BY id_beneficio ASC");


while ($row = $mysql_beneficios->fetch_array(MYSQLI_ASSOC)) 
{
    $beneficios_spa[] = $row;
}

$insert = "INSERT INTO beneficios ( idbeneficio, nombrebeneficio, idstatus, fechacreacion, fechamodificacion, edadminima, edadmaxima, descripcionbeneficio, idfamilia, idtipoasistencia ) VALUES ";

$array_valores = array();
foreach($beneficios_spa as $beneficio)
{
    $idbeneficio            = $beneficio['idbeneficio']; 
    $nombrebeneficio        = $beneficio['nombrebeneficio']; 
    $idstatus               = ($beneficio['idstatus'] == 0) ? 2 : $beneficio['idstatus']; 
    $fechacreacion          = $beneficio['fechacreacion']; 
    $fechamodificacion      = $beneficio['fechamodificacion']; 
    $edadminima             = $beneficio['edadminima']; 
    $edadmaxima             = $beneficio['edadmaxima']; 
    $descripcionbeneficio   = $beneficio['descripcionbeneficio']; 
    $idfamilia              = $beneficio['idfamilia']; 
    $idtipoasistencia       = $beneficio['idtipoasistencia']; 

    $valor     = " (
                        $idbeneficio,
                        '$nombrebeneficio',
                        $idstatus,
                        '$fechacreacion',
                        '$fechamodificacion',
                        $edadminima,
                        $edadmaxima,
                        '$descripcionbeneficio',
                        $idfamilia,
                        $idtipoasistencia
                    )";

    array_push($array_valores, $valor);
}

$valores = implode(",", $array_valores);
$insert = $insert.$valores;
if(ejecuta_insert($db_postgresql, $insert) == 0) 
{
   echo $insert;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}

$mysql_beneficios = $db_mysql->query("SELECT 
                                            id_beneficio as idbeneficio, 
                                            CAST(CONVERT(name USING utf8) AS binary) as nombrebeneficio,
                                            CAST(CONVERT(descripcion USING utf8) AS binary) as descripcionbeneficio
                                        FROM beneficios 
                                        WHERE language_id = 'eng'
                                        ORDER BY id_beneficio ASC");

while ($row = $mysql_beneficios->fetch_array(MYSQLI_ASSOC)) 
{
    $beneficios_eng[] = $row;
}

foreach($beneficios_eng as $beneficio)
{
    $idbeneficio            = $beneficio['idbeneficio'];
    $nombrebeneficio        = $beneficio['nombrebeneficio'];
    $descripcionbeneficio   = $beneficio['descripcionbeneficio'];

    $update = "UPDATE beneficios SET nombrebeneficioen = '$nombrebeneficio', descripcionbeneficioen = '$descripcionbeneficio'  WHERE  idbeneficio = $idbeneficio ";
    ejecuta_update($db_postgresql, $update);
}

$secuencia = $idbeneficio + 1;
$secuencia = "ALTER SEQUENCE beneficios_idbeneficio_seq1 RESTART WITH ".$secuencia; 
ejecuta_select($db_postgresql, $secuencia);







// BENEFICIOS CATEGORIAS *******************************************************************************************************************************************************************************

echo '
Migrando Tabla: beneficioscategorias...';

$beneficioscategorias = array();

$mysql = $db_mysql->query("SELECT DISTINCT id_categoria, id_beneficio FROM beneficios_costo ORDER BY id_categoria ASC");

while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
{
    $beneficioscategorias[] = $row;
}

$insert = "INSERT INTO beneficioscategorias ( idcategoria, idbeneficio ) VALUES ";

$array_valores = array();
foreach($beneficioscategorias as $beneficiocategoria)
{
    $idcategoria    = $beneficiocategoria['id_categoria'];
    $idbeneficio    = $beneficiocategoria['id_beneficio'];

    $valor     = "(
                    $idcategoria, 
                    $idbeneficio
                )";

    array_push($array_valores, $valor);
}
            
$valores = implode(",", $array_valores);
$insert = $insert.$valores;


if(ejecuta_insert($db_postgresql, $insert) == 0) 
{
   echo $insert;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}


// AGENCIAS EN EL ARCHIVO

$agencias_con_bolsas_de_dias_y_precompras = array();
$incluir = array();

echo '
Calculando Agencias...';

    $paises = array(
        array("idpais" => 11,  "agencias" => array(118, 1498, 1504	, 1516	, 1552	, 1557	, 1605	, 1607	, 1613	, 1637	, 1668	, 1677	, 1683	, 1768	, 1786	, 1836	, 1863	, 1871	, 1877	, 1991	, 2042	, 2044	, 2087	, 2101	, 2121	, 2165	, 2190	, 2199	, 2207	, 2208	, 2217	, 2220	, 2230	, 2231	, 2255	, 2256	, 2257	, 2265	, 2296	, 2297	, 2346	, 2352	, 2385	, 2399	, 2403	, 2440	, 2514	, 2552	, 2564	, 2581	, 2610	, 2631	, 2655	, 2661	, 2696	, 2731	, 2766	, 2767	, 3386	, 3389	, 3391	, 3414	, 3505	, 3514	, 3543	, 3549	, 3636	, 3648	, 3653	, 3735	, 3756	, 3774	, 3777	, 3787	, 3788	, 3809	, 3811	, 3813	, 3828	, 3841	, 3864	, 3876	, 3878	, 3884	, 3942	, 3961	, 4008	, 4028	, 4031	, 4040	, 4043	, 4045	, 4053	, 4060	, 4072	, 4075	, 4076	, 4078	, 4099	, 4111	, 4113	, 4116	, 4124	, 4126	, 4128	, 4136	, 4140	, 4141	, 4145	, 4150	, 4156	, 4158	, 4159	, 4173	, 4185	, 4187	, 4189	, 4195	, 4224	, 4240	, 4244	, 4252	, 4267	, 4291	, 4299	, 4300	, 4307	, 4309	, 4372	, 4375	, 4376	, 4377	, 4406	, 4433	, 4434	, 4437	, 4450	, 4463	, 4464	, 4471	, 4503	, 4546	, 4556	, 4557	, 4566	, 4567	, 4573	, 4574	, 4579	, 4597	, 4608	, 4617	, 4628	, 4642	, 4643	, 4647	, 4653	, 4656	, 4666	, 4705	, 4718	, 4722	, 4731	, 4733	, 4741	, 4750	, 4763	, 4769	, 4809	, 4844	, 4847	, 4855	, 4885	, 4888	, 4892	, 5009	, 5017	, 5022	, 5108	, 5111	, 5206	, 5248	, 5252	, 5255	, 5258	, 5264	, 5279	, 5284	, 5285	, 5312	, 5313	, 5326	, 5334	, 5335	, 5338	, 5341	, 5342	, 5358	, 5364	, 5424	, 5437	, 5446	, 5450	, 5463	, 5465	, 5469	, 5470	, 5473	, 5481	, 5484	, 5494	, 5496	, 5504	, 5507	, 5542	, 5547	, 5550	, 5568	, 5581	, 5589	, 5593	, 5597	, 5638	, 5644	, 5646	, 5671	, 5755	, 5758	, 5762	, 5763	, 5784	, 5785	, 5786	, 5790	, 5792	, 5793	, 5796	, 5797	, 5809	, 5821	, 5822	, 5824	, 5828	, 5833	, 5840	, 5841	, 5852	, 5856	, 5857	, 5858	, 5878	, 5893	, 5894	, 5899	, 5909	, 5910	, 5922	, 5930	, 5931	, 5960	, 5966	, 5977	, 5981	, 6000	, 6004	, 6005	, 6012	, 6015	, 6026	, 6032	, 6041	, 6046	, 6052	, 6054	, 6055	, 6060	, 6062	, 6063	, 6065	, 6067	, 6069	, 6072	, 6076	, 6087	, 6090	, 6096	, 6110	, 6111	, 6118	, 6119	, 6120	, 6122	, 6132	, 6133	, 6151	, 6154	, 6159	, 6160	, 6161	, 6164	, 6168	, 6171	, 6172	, 6173	, 6182	, 6186	, 6193	, 6195	, 6197	, 6198	, 6216	, 6222	, 6223	, 6226	, 6229	, 6233	, 6236	, 6237	, 6251	, 6252	, 6257	, 6258	, 6260	, 6264	, 6280	, 6281	, 6282	, 6286	, 6291	, 6292	, 6294	, 6296	, 6298	, 6299	, 6300	, 6306	, 6308	, 6323	, 6324	, 6325	, 6331	, 6334	, 6336	, 6338	, 6346	, 6348	, 6351	, 6354	, 6359	, 6360	, 6363	, 6365	, 6369	, 6377	, 6388	, 6389	, 6390	, 6397	, 6403	, 6405	, 6407	, 6408	, 6410	, 6411	, 6417	, 6420	, 6421	, 6425	, 6450	, 6452	, 6457	, 6461	, 6463	, 6469	, 6474	, 6486	, 6487	, 6488	, 6489	, 6495	, 6496	, 6501	, 6507	, 6511	, 6516	, 6525	, 6526	, 867)),
        array("idpais" => 5,   "agencias" => array(818	, 936	, 1079	, 1095	, 1098	, 1099	, 1119	, 1147	, 1184	, 1206	, 1226	, 1237	, 1247	, 1253	, 1283	, 1299	, 1305	, 1342	, 1402	, 1416	, 1417	, 1425	, 1452	, 1464	, 1484	, 1506	, 1523	, 1545	, 1559	, 1578	, 1632	, 1690	, 1691	, 1701	, 1739	, 1740	, 1760	, 1781	, 1827	, 1944	, 1949	, 1962	, 1963	, 1965	, 1966	, 1998	, 2015	, 2030	, 2081	, 2124	, 2135	, 2158	, 2175	, 2177	, 2187	, 2192	, 2241	, 2248	, 2274	, 2287	, 2329	, 2376	, 2408	, 2412	, 2432	, 2437	, 2470	, 2507	, 2508	, 2551	, 2566	, 2576	, 2583	, 2590	, 2591	, 2611	, 2658	, 2668	, 2675	, 2692	, 2701	, 2714	, 2720	, 3387	, 3410	, 3419	, 3443	, 3481	, 3671	, 3696	, 3716	, 3734	, 3739	, 3744	, 3753	, 3766	, 3806	, 3817	, 3829	, 3833	, 3845	, 3880	, 3887	, 4006	, 4290	, 4409	, 4442	, 4446	, 4456	, 4479	, 4528	, 4553	, 4590	, 4607	, 4644	, 4654	, 4657	, 4698	, 4706	, 4719	, 4724	, 4768	, 4776	, 4782	, 4790	, 4802	, 4803	, 4812	, 4815	, 4833	, 4840	, 4843	, 4863	, 4865	, 4867	, 4890	, 4896	, 5002	, 5006	, 5007	, 5015	, 5024	, 5118	, 5208	, 5219	, 5221	, 5235	, 5241	, 5245	, 5271	, 5280	, 5293	, 5305	, 5317	, 5318	, 5332	, 5378	, 5389	, 5441	, 5442	, 5522	, 5533	, 5537	, 5543	, 5580	, 5607	, 5655	, 5751	, 5889	, 5998	, 6027	, 6035	, 6039	, 6048	, 6070	, 6075	, 6181	, 6189	, 6201	, 6202	, 6305	, 6342	, 6347	, 6350	, 6370	, 6374	, 6383	, 6415	, 6418	, 6423	, 6424	, 6439	, 6453	, 6454	, 6460	, 6465	, 6473	, 6479	, 6508	, 6510)),
        array("idpais" => 99, "agencias" => array(1501, 1142	, 1228	, 1285	, 173	, 174	, 178	, 1806	, 186	, 1923	, 1942	, 196	, 204	, 219	, 2218	, 2233	, 226	, 2342	, 2429	, 2477	, 2506	, 2649	, 266	, 2676	, 2738	, 2746	, 2787	, 2790	, 2851	, 2859	, 289	, 2947	, 3018	, 3085	, 3103	, 3131	, 3330	, 3401	, 3440	, 3627	, 3660	, 4188	, 4304	, 4305	, 433	, 4429	, 4516	, 4545	, 4550	, 4554	, 4591	, 4598	, 4610	, 4626	, 4627	, 4672	, 4683	, 4723	, 4726	, 4752	, 479	, 4795	, 4800	, 4804	, 4849	, 4854	, 4864	, 4875	, 4910	, 4919	, 4995	, 4997	, 4998	, 5018	, 5026	, 5030	, 5107	, 5217	, 5239	, 5282	, 5296	, 5302	, 5329	, 5336	, 5340	, 5386	, 5399	, 5402	, 5407	, 5410	, 5414	, 5415	, 5419	, 5444	, 5454	, 5475	, 5476	, 5493	, 5511	, 5518	, 5554	, 5557	, 5562	, 5563	, 5566	, 5572	, 5573	, 5577	, 5599	, 5608	, 5609	, 5629	, 5635	, 5657	, 5778	, 5811	, 5825	, 5831	, 5908	, 5956	, 5992	, 6102	, 6157	, 6158	, 6188	, 6190	, 6225	, 6227	, 6235	, 6250	, 6268	, 6272	, 6274	, 6275	, 6277	, 6290	, 6310	, 6364	, 6394	, 6401	, 6426	, 6441	, 6442	, 6443	, 6455	, 6482	, 6503	, 6534	, 891	, 915	, 916, 3890))
    );

    $todas = array();

/*     $archivo = array();
    foreach($paises as $pais)
    {
        $agencias = $pais['agencias'];
        
        foreach($agencias as $idagencia)
        {
            array_push($archivo, $idagencia);
        }
    } 

    sort($archivo);






    // AGENCIAS CON ORDENES EMITIDIAS EN EL 2024
    $select = "SELECT agencia as idagencia
                FROM orders 
                WHERE fecha >= '2024-01-01'
                AND status IN (1, 2, 4)
                AND agencia NOT IN (0)
                GROUP BY 1
                ORDER BY 1
            ";

    $mysql = $db_mysql->query($select);

    while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    {
        $agencias_que_emitieron_2024[] = $row;
    }
    $row = array();

// AGENCIAS CON ORDENES EN RIESGO
    $select = "SELECT agencia as idagencia
                FROM orders 
                WHERE retorno >= '2024-01-01'
                AND status IN (1, 2, 4)
                AND agencia NOT IN (0)
                GROUP BY 1
                ORDER BY 1
                ";

    $mysql = $db_mysql->query($select);

    while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    {
        $agencias_ordenes_en_riesgo[] = $row;
    }

    $row = array();


// AGENCIAS CON BOLSAS DE DIAS Y PRECOMPRAS
    $select = "SELECT orders.agencia as idagencia
                FROM orders 
                    LEFT JOIN broker ON orders.agencia = broker.id_broker
                WHERE orders.programaplan IN (14, 32)
                AND orders.status IN (1, 2, 4)
                AND orders.agencia NOT IN (0)
                GROUP BY 1
                ORDER BY 1
                ";

    $mysql = $db_mysql->query($select);

    while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    {
        $agencias_con_bolsas_de_dias_y_precompras[] = $row;
    }

    $row = array();

// TODAS LAS AGENCIAS 
    $todas = array();

    foreach($agencias_que_emitieron_2024 as $agencia)
    {
        $idagencia = $agencia['idagencia'];

        if(!in_array($idagencia, $archivo))
        {
            array_push($archivo, $idagencia);
        }
    }

    foreach($agencias_ordenes_en_riesgo as $agencia)
    {
        $idagencia = $agencia['idagencia'];
        if(!in_array($idagencia, $archivo))
        {
            array_push($archivo, $idagencia);
        }
    }

    foreach($agencias_con_bolsas_de_dias_y_precompras as $agencia)
    {
        $idagencia = $agencia['idagencia'];
        if(!in_array($idagencia, $archivo))
        {
            array_push($archivo, $idagencia);
        }
    }





    $conseguidas = true;

    while($conseguidas)
    {
        $implode_archivo    = implode(",", $archivo);

        $select = "SELECT parent as idagencia
                    FROM broker_nivel 
                    WHERE id_broker IN (".$implode_archivo.") 
                    AND parent NOT IN (".$implode_archivo.") 
                    GROUP BY parent";

        $mysql = $db_mysql->query($select);

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $incluir[] = $row;
        }

        if(count($incluir) > 0)
        {
            foreach($incluir as $agencia)
            {
                if(!in_array($agencia['idagencia'], $archivo))
                {
                    array_push($archivo, $agencia['idagencia']);
                }
            }

            $incluir = array();
        }
        else
        {
            $conseguidas = false;
        }
    } 

    sort($archivo);
    $row = array(); */

    // PLANES BLOQUEADOS PERSONALIZADOS
    $planes_bloqueados       = array();
    $planes_bloqueados[0]    = array("idagencia" => 3890, "planes" => array(1540,1541,1542,1583,1544,1545,1550));
    $planes_bloqueados[1]    = array("idagencia" => 2477, "planes" => array(1934,2186,2187,2188,1167,1168,1306,1300,1309,1311,1310,1308,2633,2632));
    $planes_bloqueados[2]    = array("idagencia" => 907, "planes" => array(1564,1565,1566,1567,1568,1569,1570));
    $planes_bloqueados[3]    = array("idagencia" => 3440, "planes" => array(1716,1717,1718,1719,1720,1721,1722,1723,1724,1725,1726,1727,1728,1729,1730,1731));
    $planes_bloqueados[4]    = array("idagencia" => 4092, "planes" => array(1649,1650,1651,1652,1653,1654,1655));
    $planes_bloqueados[5]    = array("idagencia" => 2042, "planes" => array(2085,2086));
    $planes_bloqueados[6]    = array("idagencia" => 4598, "planes" => array(2249,2250,2251,2252));
    $planes_bloqueados[7]    = array("idagencia" => 4808, "planes" => array(2189,2190,2191,2192,2193,2194,2195,2196,2197,2198,2199,2200,2244,2379,2380,2381,2382));
    $planes_bloqueados[8]    = array("idagencia" => 5768, "planes" => array(2577,2578,2579,2580,2581,2582));
    $planes_bloqueados[9]    = array("idagencia" => 5211, "planes" => array(87,88,89,1869,1377));
    $planes_bloqueados[10]   = array("idagencia" => 4387, "planes" => array(2597,2598,2600,2599,2601,2602,2605,2604,2607,2606));
    $planes_bloqueados[11]   = array("idagencia" => 4726, "planes" => array(2646,2647,2648));
    $planes_bloqueados[12]   = array("idagencia" => 4723, "planes" => array(2108,2111,2106,2107,2109,2110));
    $planes_bloqueados[13]   = array("idagencia" => 1687, "planes" => array(1353,707,1352,1644,1910,2490));
    $planes_bloqueados[14]   = array("idagencia" => 3691, "planes" => array(1353,707));
    $planes_bloqueados[15]   = array("idagencia" => 5799, "planes" => array(2508,2509));
    $planes_bloqueados[16]   = array("idagencia" => 5580, "planes" => array(2610,2621,2622,2623,2624,2625,2626,2627,2628));
    $planes_bloqueados[17]   = array("idagencia" => 4496, "planes" => array(1937,1939));
    $planes_bloqueados[18]   = array("idagencia" => 4728, "planes" => array(1937,1939));
    $planes_bloqueados[19]   = array("idagencia" => 4626, "planes" => array(192));
    $planes_bloqueados[20]   = array("idagencia" => 5908, "planes" => array(2538,2539,2540,2542,2543));
    $planes_bloqueados[21]   = array("idagencia" => 4748, "planes" => array(88));
    $planes_bloqueados[22]   = array("idagencia" => 3938, "planes" => array(2391,2393,2394,2395,2396,2397,2398,2399,2400,2401,2402,2403,2404,2405,2406));
    $planes_bloqueados[23]   = array("idagencia" => 6106, "planes" => array(56,87,88,89,1377,1869));
    $planes_bloqueados[24]   = array("idagencia" => 4672, "planes" => array(1716,1717,1718,1719,2106,2107,2108,2109,2110,2111));
    $planes_bloqueados[25]   = array("idagencia" => 5906, "planes" => array(1870));
    $planes_bloqueados[26]   = array("idagencia" => 5931, "planes" => array(2557,2558,2559,2560,2561,2562,2563,2564,2565,2566));
    $planes_bloqueados[27]   = array("idagencia" => 5990, "planes" => array(2557,2558,2559,2560,2561,2562,2563,2564,2565,2566));
    $planes_bloqueados[28]   = array("idagencia" => 6057, "planes" => array(2637,2658,2659,2660,2638,2661,2662,2663,2639,2664,2665,2666,2640,2667,2668,2669,2641,2670,2671,2672,2642,2682,2683,2684,2643,2694,2695,2696,2649,2673,2674,2675,2650,2685,2686,2687,2651,2697,2698,2699,2652,2676,2677,2678,2653,2688,2689,2690,2654,2701,2702,2703,2655,2679,2680,2681,2656,2691,2692,2693,2657,2703,2704,2705));
    $planes_bloqueados[29]   = array("idagencia" => 6058, "planes" => array(2637,2658,2659,2660,2638,2661,2662,2663,2639,2664,2665,2666,2640,2667,2668,2669,2641,2670,2671,2672,2642,2682,2683,2684,2643,2694,2695,2696,2649,2673,2674,2675,2650,2685,2686,2687,2651,2697,2698,2699,2652,2676,2677,2678,2653,2688,2689,2690,2654,2701,2702,2703,2655,2679,2680,2681,2656,2691,2692,2693,2657,2703,2704,2705));
    $planes_bloqueados[30]   = array("idagencia" => 4677, "planes" => array(2017,2018));
    $planes_bloqueados[31]   = array("idagencia" => 4626, "planes" => array(200,498,499));
    $planes_bloqueados[32]   = array("idagencia" => 4232, "planes" => array(1778));
    $planes_bloqueados[33]   = array("idagencia" => 5350, "planes" => array(89));
    $planes_bloqueados[34]   = array("idagencia" => 4429, "planes" => array(484,485,486,487,471,476,477,472,478,479,474,480,481,473,482,470,490,491));
    $planes_bloqueados[35]   = array("idagencia" => 2297, "planes" => array(21,87,89));
    $planes_bloqueados[36]   = array("idagencia" => 5532, "planes" => array(2041,2042,2043));
    $planes_bloqueados[37]   = array("idagencia" => 5888, "planes" => array(2530,2531,2532,2533,2534,2535));
    $planes_bloqueados[38]   = array("idagencia" => 5923, "planes" => array(267,269,270,272,273,275));
    $planes_bloqueados[39]   = array("idagencia" => 5217, "planes" => array(2569,2570));
    $planes_bloqueados[40]   = array("idagencia" => 5339, "planes" => array(114,116,21,123,56,87,92));
    $planes_bloqueados[41]   = array("idagencia" => 2297, "planes" => array(21,87,89));
    $planes_bloqueados[42]   = array("idagencia" => 5248, "planes" => array(21,123));
    $planes_bloqueados[43]   = array("idagencia" => 5901, "planes" => array(56,87,88,1869,1377));
    $planes_bloqueados[44]   = array("idagencia" => 1425, "planes" => array(157,159,160,162));
    $planes_bloqueados[45]   = array("idagencia" => 6115, "planes" => array(2706,2707,2708,2709,2710));
    $planes_bloqueados[46]   = array("idagencia" => 6117, "planes" => array(484,485,486,487));
    $planes_bloqueados[47]   = array("idagencia" => 3514, "planes" => array(88,1869));
    $planes_bloqueados[48]   = array("idagencia" => 118, "planes" => array(2946,2964,2965));

   /*  foreach($planes_bloqueados as $agencia)
    {
        if(!in_array($agencia['idagencia'], $archivo))
        {
            array_push($archivo, $agencia['idagencia']);
        }
    }

    sort($archivo); */

   // $todas_las_agencias_implode = implode(",", $archivo);



   $todas_las_agencias_implode= "";




// MIGRAR AGENCIAS 

$registros = array();

echo '
Migrando Agencias...';

$select_agencias = "SELECT 
                        broker.id_broker as idagencia,
                        1 as idsistema,
                        UPPER(CAST(CONVERT(broker USING utf8) AS binary)) as nombreagencia,
                        id_status as idstatus,
                        broker.nivel as idnivel,
                        id_site as idpais,
                        CAST(CONVERT(phone1 USING utf8) AS binary) as telefono1,
                        CAST(CONVERT(phone2 USING utf8) AS binary) as telefono2,
                        CAST(CONVERT(phone3 USING utf8) AS binary) as telefono3,
                        CAST(CONVERT(address USING utf8) AS binary) as direccion,
                        date_up as fechacreacion,
                        IF(account_manager = 0 OR account_manager IS NULL, 1076, account_manager) as idagente,
                        img_broker as logoagencia,
                        COALESCE(credito_base, 0) as creditobase,
                        COALESCE(credito_actual, 0) as creditoactual,
                        ver_precio as verprecio,
                        solo_inclusion as versoloinclusion,
                        multipais as multipais,
                        CAST(CONVERT(banco USING utf8) AS binary) as banco,
                        CAST(CONVERT(clabe_inter USING utf8) AS binary) as clabeinterbancaria,
                        CAST(CONVERT(cuenta USING utf8) AS binary) as cuenta,
                        UPPER(CAST(CONVERT(beneficiario USING utf8) AS binary)) as beneficiario,
                        COALESCE(broker_nivel.parent, 0) as idagenciapadre,
                        CASE
                            WHEN id_site = 5 THEN 818
                            WHEN id_site = 11 THEN 509
                            ELSE 99
                        END as idagenciareporta,
                        UPPER(CAST(CONVERT(razon USING utf8) AS binary)) as razonsocial,
                        UPPER(CAST(CONVERT(tax_id USING utf8) AS binary)) as identificadortributaria,
                        UPPER(CAST(CONVERT(id_city USING utf8) AS binary)) as ciudad,
                        UPPER(CAST(CONVERT(id_state USING utf8) AS binary)) as estado,
                        CAST(CONVERT(observations USING utf8) AS binary) as comentario,
                        'CA' as acronimovoucher
                    FROM broker
                    LEFT join broker_nivel on broker.id_broker = broker_nivel.id_broker
                    WHERE 
                    broker.id_broker NOT IN (0)
                    ORDER BY broker.id_broker ASC
                    ";
                      /* broker.id_broker IN (".$todas_las_agencias_implode.") */

$mysql    = $db_mysql->query($select_agencias);
$array_list_idagency= [];
while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
{
    $registros[] = $row;
    $array_list_idagency =$row['idagencia'];
}

print_r( $array_list_idagency); exit;

$insert = "INSERT INTO agencias (
                        idagencia,
                        idsistema,
                        nombreagencia,
                        idstatus,
                        idnivel,
                        idpais,
                        telefono1,
                        telefono2,
                        telefono3,
                        direccion,
                        fechacreacion,
                        idagente,
                        logoagencia,
                        creditobase,
                        creditoactual,
                        verprecio,
                        versoloinclusion,
                        multipais,
                        banco,
                        clabeinterbancaria,
                        cuenta,
                        beneficiario,
                        idagenciapadre,
                        idagenciareporta,
                        razonsocial,
                        identificadortributaria,
                        ciudad,
                        estado,
                        comentario,
                        acronimovoucher
                        )
                    VALUES ";

$array_valores = array();

foreach($registros as $registro)
{
    $idagencia                  = $registro['idagencia'];
    $idsistema                  = $registro['idsistema'];
    $nombreagencia              = str_replace("'", "", $registro['nombreagencia']);
    $idstatus                   = ($registro['idstatus'] == 0) ? 2 : $registro['idstatus'];
    $idnivel                    = $registro['idnivel'];
    $idpais                     = ($registro['idpais'] == 0) ? 99 : $registro['idpais'];
    $telefono1                  = str_replace(" ", "", str_replace("-", "", str_replace(".", "", str_replace("'", "", $registro['telefono1']))));
    $telefono2                  = str_replace(" ", "", str_replace("-", "", str_replace(".", "", str_replace("'", "", $registro['telefono2']))));
    $telefono3                  = str_replace(" ", "", str_replace("-", "", str_replace(".", "", str_replace("'", "", $registro['telefono3']))));
    $direccion                  = str_replace('"', "", str_replace("'", "", $registro['direccion']));
    $fechacreacion              = $registro['fechacreacion'];
    $idagente                   = $registro['idagente'];
    $logoagencia                = str_replace("'", "", $registro['logoagencia']);
    $creditobase                = $registro['creditobase'];
    $creditoactual              = $registro['creditoactual'];
    $verprecio                  = $registro['verprecio'];
    $versoloinclusion           = $registro['versoloinclusion'];
    $multipais                  = $registro['multipais'];
    $banco                      = str_replace("'", "", $registro['banco']);
    $clabeinterbancaria         = str_replace("'", "", $registro['clabeinterbancaria']);
    $cuenta                     = str_replace(".", "", str_replace(" ", "", str_replace("-", "", str_replace("'", "", $registro['cuenta']))));
    $beneficiario               = str_replace("'", "", $registro['beneficiario']);
    $idagenciapadre             = $registro['idagenciapadre'];
    $idagenciareporta           = $registro['idagenciareporta'];
    $razonsocial                = str_replace("'", "", $registro['razonsocial']);
    $identificadortributaria    = str_replace(" ", "", str_replace("-", "", str_replace(".", "", str_replace("'", "", $registro['identificadortributaria']))));
    $ciudad                     = str_replace("'", "", $registro['ciudad']);
    $estado                     = str_replace("'", "", $registro['estado']);
    $comentario                 = str_replace("'", "", $registro['comentario']);
    $acronimovoucher            = $registro['acronimovoucher'];

    $valor = "(
                    $idagencia,
                    $idsistema,
                    UPPER('$nombreagencia'),
                    $idstatus,
                    $idnivel,
                    $idpais,
                    '$telefono1',
                    '$telefono2',
                    '$telefono3',
                    '$direccion',
                    '$fechacreacion',
                    $idagente,
                    CONCAT('https://storage.googleapis.com/files-continentalassist-backend/Agencias/','$logoagencia'),
                    $creditobase,
                    $creditoactual,
                    '$verprecio',
                    '$versoloinclusion',
                    '$multipais',
                    '$banco',
                    '$clabeinterbancaria',
                    '$cuenta',
                    UPPER('$beneficiario'),
                    $idagenciapadre,
                    $idagenciareporta,
                    '$razonsocial',
                    '$identificadortributaria',
                    UPPER('$ciudad'),
                    UPPER('$estado'),
                    '$comentario',
                    '$acronimovoucher'
                )";
    $array_valores [] = $valor;
    //array_push($array_valores, $valor);
}


$valores        = implode(",", $array_valores);
$insert         = $insert.$valores; 

if(ejecuta_insert($db_postgresql, $insert) == 0) 
{
   echo $insert;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}

$secuencia = $idagencia + 1;
$secuencia = "ALTER SEQUENCE agencias_idagencia_seq RESTART WITH ".$secuencia; 
ejecuta_select($db_postgresql, $secuencia);








// AGENCIAS PLATAFORMAS DE PAGO 

$agencias = ejecuta_select($db_postgresql, "SELECT idagencia FROM agencias");

$insert = "INSERT INTO agenciasplataformaspago (idagencia, idplataformapago) VALUES ";

$array_valores = array();

foreach($agencias['resultado'] as $agencia)
{
    $idagencia = $agencia['idagencia'];

    if($idagencia)
    {
        array_push($array_valores, "($idagencia, 1)");
        array_push($array_valores, "($idagencia, 2)");
    }
}

$valores = implode(",", $array_valores);
$insert = $insert.$valores;


if(ejecuta_insert($db_postgresql, $insert) == 0) 
{
   echo $insert;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}








// CORPORATIVOS *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: corporativos...';

$corporativos = array();

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
            WHERE agencia IN (".$todas_las_agencias_implode.")
            AND agencia NOT IN (0)
            ORDER BY corporativo.id_client ASC
        ";

$mysql = $db_mysql->query($select);

while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
{
    $corporativos[] = $row;
}

$insert = "INSERT INTO corporativos ( idcorporativo, idagencia, nombrecorporativo, idstatus, fechacreacion, observaciones, imgcorporativo, creditoactual, creditobase ) VALUES ";

$array_valores = array();

foreach($corporativos as $corporativo)
{
    array_push($archivo, $corporativo['idcorporativo']);

    $idcorporativo      = $corporativo['idcorporativo'];
    $idagencia          = $corporativo['idagencia'];
    $nombrecorporativo  = str_replace("'", "", $corporativo['nombrecorporativo']) ;
    $idstatus           = ($corporativo['idstatus'] == 0) ? 2 : $corporativo['idstatus'];
    $fechacreacion      = $corporativo['fechacreacion'];
    $observaciones      = $corporativo['observaciones'];
    $imgcorporativo     = $corporativo['imgcorporativo'];
    $creditoactual      = $corporativo['creditoactual'];
    $creditobase        = $corporativo['creditobase'];

    $valor     = " (
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

    array_push($array_valores, $valor);
}

$valores        = implode(",", $array_valores);
$insert         = $insert.$valores; 
if(ejecuta_insert($db_postgresql, $insert) == 0) 
{
   echo $insert;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}

$secuencia = $idcorporativo + 1;
$secuencia = "ALTER SEQUENCE corporativos_idcorporativo_seq RESTART WITH ".$secuencia; 
ejecuta_select($db_postgresql, $secuencia);


sort($archivo);

$todas_las_agencias_implode_con_corporativos = implode(",", $archivo);









// CATEGORIAS AGENCIAS *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: categoriasagencias...';

$categorias_agencias = array();

$select = "SELECT 
                DISTINCT COALESCE(programaplan, 0) as programaplan, 
                agencia 
            FROM orders 
            WHERE agencia IN ($todas_las_agencias_implode)
            AND agencia NOT IN (0)
            AND programaplan > 0
            ORDER BY programaplan ASC";

$mysql_categorias_agencias = $db_mysql->query($select);

while ($row = $mysql_categorias_agencias->fetch_array(MYSQLI_ASSOC)) 
{
    $categorias_agencias[] = $row;
}

$insert = "INSERT INTO categoriasagencias ( idcategoria, idagencia ) VALUES ";

$array_valores = array(); 
foreach($categorias_agencias as $categoria_agencia)
{
    $idcategoria    = $categoria_agencia['programaplan'];
    $idagencia      = $categoria_agencia['agencia'];
    
    $valor     = " ( $idcategoria, $idagencia ) ";

    array_push($array_valores, $valor);
}

$valores    = implode(",", $array_valores);
$insert     = $insert.$valores;



if(ejecuta_insert($db_postgresql, $insert) == 0) 
{
   echo $insert;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}






































// CATEGORIAS DESTINOS *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: categoriasdestinos...';

$categorias = ejecuta_select($db_postgresql, "SELECT idcategoria FROM categorias ORDER BY idcategoria ASC ");
$paises     = ejecuta_select($db_postgresql, "SELECT idpais FROM paises ORDER BY idpais ASC ");

$insert     = "INSERT INTO categoriasdestinos(idcategoria, idpais) VALUES ";

$array_valores  = array();
foreach($categorias['resultado'] as $categoria)
{
    $idcategoria = $categoria['idcategoria'];

    foreach($paises['resultado'] as $pais)
    {
        $idpais = ($pais['idpais'] == 0) ? 99 : $pais['idpais'];

        $valor = "($idcategoria, $idpais)";
        
        array_push($array_valores, $valor);
    }
}

$valores    = implode(",", $array_valores);
$insert     = $insert.$valores;

if(ejecuta_insert($db_postgresql, $insert) == 0) 
{
   echo $insert;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}












// CATEGORIAS FUENTES *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: categoriasfuentes...';

$categorias = ejecuta_select($db_postgresql, "SELECT  idcategoria FROM categorias ORDER BY idcategoria ASC ");
$fuentes    = ejecuta_select($db_postgresql, "SELECT  idfuente FROM fuentes ORDER BY idfuente ASC ");

$insert = "INSERT INTO categoriasfuentes(idcategoria, idfuente) VALUES ";

$array_valores = array();
foreach($categorias['resultado'] as $categoria)
{
    $idcategoria = $categoria['idcategoria'];

    foreach($fuentes['resultado'] as $fuente)
    {
        $idfuente = $fuente['idfuente'];

        $valor = "($idcategoria, $idfuente)";
        
        array_push($array_valores, $valor);
    }
}

$valores    = implode(",", $array_valores);
$insert     = $insert.$valores;

if(ejecuta_insert($db_postgresql, $insert) == 0) 
{
   echo $insert;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}













// CATEGORIAS ORIGEN *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: categoriasorigenes...';

$categorias = ejecuta_select($db_postgresql, "SELECT  idcategoria FROM categorias ORDER BY idcategoria ASC ");
$paises     = ejecuta_select($db_postgresql, "SELECT  idpais FROM paises ORDER BY idpais ASC ");

$insert = "INSERT INTO categoriasorigenes(idcategoria, idpais) VALUES ";

$array_valores = array();
foreach($categorias['resultado'] as $categoria)
{
    $idcategoria = $categoria['idcategoria'];

    foreach($paises['resultado'] as $pais)
    {
        $idpais = ($pais['idpais'] == 0) ? 99 : $pais['idpais'];

        $valor = "($idcategoria, $idpais)";
        
        array_push($array_valores, $valor);
    }
}

$valores    = implode(",", $array_valores);
$insert     = $insert.$valores;

if(ejecuta_insert($db_postgresql, $insert) == 0) 
{
   echo $insert;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}
























// CATEGORIAS PAISES *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: categoriaspaises...';

$categorias_paises = array();

$mysql_categorias_paises = $db_mysql->query("SELECT DISTINCT id_site, id_category FROM category_site ORDER BY id_site ASC");

while ($row = $mysql_categorias_paises->fetch_array(MYSQLI_ASSOC)) 
{
    $categorias_paises[] = $row;
}

$insert = "INSERT INTO categoriaspaises ( idcategoria, idpais ) VALUES ";

$array_valores = array();
foreach($categorias_paises as $categoria_pais)
{
    $idpais         = ($categoria_pais['id_site'] == 0) ? 99 : $categoria_pais['id_site'];
    $idcategoria    = $categoria_pais['id_category'];

    if($idcategoria != null && $idcategoria != 0)
    {
        $valor     = " ( $idcategoria, $idpais )";

        array_push($array_valores, $valor);
    }
}

$valores    = implode(",", $array_valores);
$insert     = $insert.$valores;


if(ejecuta_insert($db_postgresql, $insert) == 0) 
{
   echo $insert;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}


























// MIGRAR USUARIOS

echo '
Migrando Usuarios...';

$usuarios = array();

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
                user_associate.es_emision_corp as escorporativo,
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
                UPPER(CAST(CONVERT(users.banco USING utf8) AS binary)) as banco,
                CAST(CONVERT(users.clabe_inter USING utf8) AS binary) as clabeinterbancaria,
                UPPER(CAST(CONVERT(users.beneficiario USING utf8) AS binary)) as beneficiario,
                CAST(CONVERT(users.cuenta USING utf8) AS binary) as cuenta
            FROM users 
            LEFT JOIN user_associate on users.id = user_associate.id_user 
            WHERE
            user_associate.id_associate IN (".$todas_las_agencias_implode_con_corporativos.")
            AND user_associate.id_associate NOT IN (0)
            GROUP BY users.id
            ORDER BY users.id ASC
            ";

    $mysql = $db_mysql->query($select);
    while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    {
        $usuarios[] = $row;
    }
    

    $insert_usuarios = "INSERT INTO usuarios (
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
                    VALUES ";

    $array_valores_usuarios = array();

    foreach($usuarios as $usuario)
    {
        

        $idusuario                  = $usuario['idusuario'];
        $nombreusuario              = str_replace("'", "", trim(ucwords(strtolower($usuario['nombreusuario']))));
        $apellidousuario            = str_replace("'", "", trim(ucwords(strtolower($usuario['apellidousuario']))));
        $idstatus                   = ($usuario['idstatus'] == 0) ? 2 : $usuario['idstatus'];
        $escorporativo              = $usuario['escorporativo'];
        $idtipousuario              = empty($usuario['idtipousuario']) ? 100 : $usuario['idtipousuario'];           
        $idagencia                  = ($escorporativo == 0) ? $usuario['idagencia'] : 'NULL' ;
        $aliasusuario               = trim(ucwords(strtolower($usuario['aliasusuario'])));
        $contrasena                 = $usuario['contrasena'];
        $correo                     = trim($usuario['correo']);
        $telefono                   = str_replace("'", "", trim($usuario['telefono']));
        $fechacreacion              = $usuario['fechacreacion'];
        $fechamodificacion          = $usuario['fechamodificacion'];
        $fechacambiarcontrasena     = ($usuario['fechacambiarcontrasena'] == '0000-00-00 00:00:00') ?'2025-12-31 00:00:00.000':$usuario['fechacambiarcontrasena'];
        $cambiarcontrasena          = $usuario['cambiarcontrasena'];
        $ididioma                   = $usuario['ididioma'];
        $ipremota                   = $usuario['ipremota'];
        $conectado                  = $usuario['conectado'];
        $soloconexionlocal          = $usuario['soloconexionlocal'];
        $ultimaconexion             = ($usuario['ultimaconexion'] == '0000-00-00 00:00:00') ?'2025-12-31 00:00:00.000':$usuario['ultimaconexion'];
        
        $incentivo                  = $usuario['incentivo'];
        $banco                      = str_replace("?", " ", trim($usuario['banco']));
        $clabeinterbancaria         = str_replace("?", " ", trim($usuario['clabeinterbancaria']));
        $beneficiario               = str_replace("?", " ", trim($usuario['beneficiario']));
        $cuenta                     = str_replace("?", " ", trim($usuario['cuenta']));
        $idcorporativo              = ($escorporativo == 1) ? $usuario['idagencia'] : 'NULL' ;

        $postgresql_agencia = ($escorporativo == 1) ? ejecuta_select($db_postgresql, "SELECT idcorporativo FROM corporativos WHERE idcorporativo = $idcorporativo") : ejecuta_select($db_postgresql, "SELECT idagencia FROM agencias WHERE idagencia = $idagencia");
        
        $escorporativo = ($escorporativo == 1) ? 't' : 'f';

        if($correo != '' && $postgresql_agencia['cantidad'] > 0)
        {
            $valor = "(
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
                   

            array_push($array_valores_usuarios, $valor);
        }
    }

    $valores            = implode(",", $array_valores_usuarios);
    
    $insert_usuarios    = $insert_usuarios.$valores;
   
   
    if(ejecuta_insert($db_postgresql, $insert_usuarios) == 0) 
    {
    echo $insert_usuarios;
        die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
    }

    $secuencia = $idusuario + 1;
    $secuencia = "ALTER SEQUENCE usuarios_idusuario_seq1 RESTART WITH ".$secuencia; 
   
    ejecuta_select($db_postgresql, $secuencia);









// PROCESO DE ASIGNACION DE PERMISOS POR DEFECTO

ejecuta_update($db_postgresql, "ALTER SEQUENCE permisosasignacion_idpermiso_seq RESTART WITH 1");

$empresas           = ejecuta_select($db_postgresql, "SELECT idempresa FROM empresas WHERE idempresa = 1");
$paises             = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE essede = 'true'");
$agencias           = ejecuta_select($db_postgresql, "SELECT idagencia FROM agencias");
$niveles            = ejecuta_select($db_postgresql, "SELECT idnivel FROM niveles");
$tiposusuario       = ejecuta_select($db_postgresql, "SELECT idtipousuario FROM tiposusuario");
$usuarios           = ejecuta_select($db_postgresql, "SELECT idusuario FROM usuarios");







// PERMISOS TIPOS USUARIOS

echo '
Asignando Permisos a los Tipos de Usuarios...';

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

$insert1 = "INSERT INTO permisos (idtipousuario, idmodulo, permiso, moduloasignadodesde) VALUES ";
$array_valores1 = array();

$insert2 = "INSERT INTO permisos (idtipousuario, idfuncion, idmodulo, permiso, funcionasignadadesde) VALUES ";
$array_valores2 = array();

foreach($todos_tiposusuarios['resultado'] as $tipousuario)
{
    $idtipousuario = $tipousuario['idtipousuario'];

    foreach($array_todos_modulos as $idmodulo)
    {
        $valor1 = "($idtipousuario, $idmodulo, 'false', 'Por Defecto' )";

        array_push($array_valores1, $valor1);
    }

    foreach($array_funciones as $funcion)
    {
        $idmodulo   = $funcion['idmodulo'];
        $idfuncion  = $funcion['idfuncion'];

        $valor2 = " ($idtipousuario, $idfuncion, $idmodulo, 'false', 'Por Defecto' ) ";

        array_push($array_valores2, $valor2);
    }
}

$valores    = implode(",", $array_valores1);
$insert1    = $insert1.$valores;

if(ejecuta_insert($db_postgresql, $insert1) == 0) 
{
   echo $insert1;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}

$valores    = implode(",", $array_valores2);
$insert2    = $insert2.$valores;

if(ejecuta_insert($db_postgresql, $insert2) == 0) 
{
   echo $insert2;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}




$tiposusuario_permisos = array(
    array('idtipousuario' => 1, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,49,31,32,27,56,2,20,26,52,53,55,57,17,47,76,87,23,83,11), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,91,93,92,88,13,151,90,152,175,48,38,160,82,169,145,140,146,170,142,147,144,148,149,112,115,114,113,183,85,84,171,174,116,118,119,177,179,182,180,181,178,184,94,96,97,98,105,100,101,102,103,104,106,108,109,111,72,74,26,34,61,63,185,187,78,80,81,188,189,190)),
    array('idtipousuario' => 2, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,49,27,2,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,93,90,175,48,38,160,144,177,183,174,171,164,163,162,86,85,84,83,56)),
    array('idtipousuario' => 3, 'modulos' => array(3,17,21,30,35,58,60,62,63,86,44,49,27,2,26), "funciones" => array(1,22,24,49,50,51,53,54,55,73,76,79,83,86,89,121,153,154,155,90,175,48,38,160,144,177)),
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








// ASIGNAR ROL AGENTES COMERCIALES DE TODOS LOS NIVELES 1,2,3,4

echo '
Asignando Roles...';

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











// USUARIOS CON ROLES DIFERENTES DE PROGRAMADOR

ejecuta_update($db_postgresql, "UPDATE usuarios SET idtipousuario = 100 WHERE idusuario = 3071");
ejecuta_insert($db_postgresql, "INSERT INTO usuarios (nombreusuario, apellidousuario, idstatus, idtipousuario, idagencia, aliasusuario, contrasena, correo, telefono, escorporativo, fechacreacion, fechamodificacion, fechacambiarcontrasena, cambiarcontrasena, ididioma, ipremota, conectado, soloconexionlocal, ultimaconexion, incentivo, banco, clabeinterbancaria, beneficiario, cuenta, idcorporativo, whatsapp, facebook, twitter, recuperacion) VALUES('Andrés', 'Olan', 1, 100, 174, 'Andrés Olan', '4ndr3s2022', 'aolan@continentalassist.com', '777777', false, '2015-09-03 00:00:00', '2015-11-26 00:00:00', '2021-01-01 00:00:00', false, 1, '0.0.0.0', false, false, '2022-02-25 10:07:08', 0, '', '', '', '', 0, '', '', '', '');");
ejecuta_insert($db_postgresql, "INSERT INTO usuarios (nombreusuario, apellidousuario, idstatus, idtipousuario, idagencia, aliasusuario, contrasena, correo, telefono, escorporativo, fechacreacion, fechamodificacion, fechacambiarcontrasena, cambiarcontrasena, ididioma, ipremota, conectado, soloconexionlocal, ultimaconexion, incentivo, banco, clabeinterbancaria, beneficiario, cuenta, idcorporativo, whatsapp, facebook, twitter, recuperacion) VALUES('Reynaldo', 'Guzmán', 1, 100, 174, 'Reynaldo Guzmán', 'r3yn4ld02022', 'rguzman@continentalassist.com', '777777', false, '2015-09-03 00:00:00', '2015-11-26 00:00:00', '2021-01-01 00:00:00', false, 1, '0.0.0.0', false, false, '2022-02-25 10:07:08', 0, '', '', '', '', 0, '', '', '', '');");
ejecuta_insert($db_postgresql, "INSERT INTO usuarios (nombreusuario, apellidousuario, idstatus, idtipousuario, idagencia, aliasusuario, contrasena, correo, telefono, escorporativo, fechacreacion, fechamodificacion, fechacambiarcontrasena, cambiarcontrasena, ididioma, ipremota, conectado, soloconexionlocal, ultimaconexion, incentivo, banco, clabeinterbancaria, beneficiario, cuenta, idcorporativo, whatsapp, facebook, twitter, recuperacion) VALUES('Ernesto', 'Galvan', 1, 100, 174, 'Ernesto Galvan', '3rn3st02022', 'egalvan@continentalassist.com', '777777', false, '2015-09-03 00:00:00', '2015-11-26 00:00:00', '2021-01-01 00:00:00', false, 1, '0.0.0.0', false, false, '2022-02-25 10:07:08', 0, '', '', '', '', 0, '', '', '', '');");
ejecuta_insert($db_postgresql, "INSERT INTO usuarios (nombreusuario, apellidousuario, idstatus, idtipousuario, idagencia, aliasusuario, contrasena, correo, telefono, escorporativo, fechacreacion, fechamodificacion, fechacambiarcontrasena, cambiarcontrasena, ididioma, ipremota, conectado, soloconexionlocal, ultimaconexion, incentivo, banco, clabeinterbancaria, beneficiario, cuenta, idcorporativo, whatsapp, facebook, twitter, recuperacion, urlimagenperfil, idusuariosap) VALUES('Usuario', 'Desarrollo', 1, 10, 174, '', 'Desarrollo123', 'desarrollo@continentalassist.com', '5586888152', false, '2023-07-12 18:37:03.456', '2023-07-12 18:37:03.456', '2023-07-12 18:37:03.456', true, 1, '', false, false, NULL, 0, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '', NULL);");
ejecuta_insert($db_postgresql, "INSERT INTO usuarios (nombreusuario, apellidousuario, idstatus, idtipousuario, idagencia, aliasusuario, contrasena, correo, telefono, escorporativo, fechacreacion, fechamodificacion, fechacambiarcontrasena, cambiarcontrasena, ididioma, ipremota, conectado, soloconexionlocal, ultimaconexion, incentivo, banco, clabeinterbancaria, beneficiario, cuenta, idcorporativo, whatsapp, facebook, twitter, recuperacion) VALUES ('Ecommerce', 'Estados Unidos', 1, 8, 174, 'Ecommerce Estados Unidos', 'EcoUsa123', 'ecommerceusa@continentalassist.com', '777777', false, NOW(), NOW(), NOW(), false, 1, '0.0.0.0', false, false, NOW(), 0, '', '', '', '', 0, '', '', '', '');");
ejecuta_insert($db_postgresql, "INSERT INTO usuarios (nombreusuario, apellidousuario, idstatus, idtipousuario, idagencia, aliasusuario, contrasena, correo, telefono, escorporativo, fechacreacion, fechamodificacion, fechacambiarcontrasena, cambiarcontrasena, ididioma, ipremota, conectado, soloconexionlocal, ultimaconexion, incentivo, banco, clabeinterbancaria, beneficiario, cuenta, idcorporativo, whatsapp, facebook, twitter, recuperacion) VALUES ('Ecommerce', 'México', 1, 8, 509, 'Ecommerce México', 'EcoMex123', 'ecommercemex@continentalassist.com', '777777', false, NOW(), NOW(), NOW(), false, 1, '0.0.0.0', false, false, NOW(), 0, '', '', '', '', 0, '', '', '', '');");
ejecuta_insert($db_postgresql, "INSERT INTO usuarios (nombreusuario, apellidousuario, idstatus, idtipousuario, idagencia, aliasusuario, contrasena, correo, telefono, escorporativo, fechacreacion, fechamodificacion, fechacambiarcontrasena, cambiarcontrasena, ididioma, ipremota, conectado, soloconexionlocal, ultimaconexion, incentivo, banco, clabeinterbancaria, beneficiario, cuenta, idcorporativo, whatsapp, facebook, twitter, recuperacion) VALUES ('Ecommerce', 'Colombia', 1, 8, 818, 'Ecommerce Colombia', 'EcoCol123', 'ecommercecol@continentalassist.com', '777777', false, NOW(), NOW(), NOW(), false, 1, '0.0.0.0', false, false, NOW(), 0, '', '', '', '', 0, '', '', '', '');");


ejecuta_update($db_postgresql, "UPDATE public.usuarios SET nombreusuario='Sofia', apellidousuario='Rivera', idstatus=1, idtipousuario=1, idagencia=174, aliasusuario='Sofia Rivera', contrasena='Sof14d3lM4r', correo='srivera@continentalassist.com', telefono='3138558308', escorporativo=false, fechacreacion='2019-10-07 00:00:00.000', fechamodificacion='2020-11-30 00:00:00.000', fechacambiarcontrasena='2019-10-07 15:59:59.000', cambiarcontrasena=false, ididioma=2, ipremota='0.0.0.0', conectado=true, soloconexionlocal=false, ultimaconexion='2023-07-24 19:04:51.703', incentivo=1, banco='', clabeinterbancaria='', beneficiario='', cuenta='', idcorporativo=NULL, whatsapp=NULL, facebook=NULL, twitter=NULL, recuperacion=NULL, urlimagenperfil='', idusuariosap=NULL, ciudadusuario=NULL, fechanacimiento=NULL, firmocondiciones=false WHERE idusuario=8320; ");










// ACTUALIZA USUARIOS QUE SE UTILIZAN PARA SESIONES

//USUARIO: caUsuarioDesarrollo
$idusuario_caUsuarioDesarrollo = ejecuta_select($db_postgresql, "SELECT idusuario FROM usuarios WHERE correo = 'desarrollo@continentalassist.com'","idusuario");
ejecuta_update($db_postgresql, "UPDATE sesiones SET idusuario = $idusuario_caUsuarioDesarrollo WHERE token = 'caUsuarioDesarrollo' ");







    // PLANES *******************************************************************************************************************************************************************************
    echo '
Migrando Planes...';

    $plans  = array();
    $planes = array();

    $todos_planes       = array();
    $archivo_planes     = array(21,56,74,87,88,89,92,93,94,95,96,98,102,103,106,107,108,109,111,112,113,114,116,117,119,123,128,129,140,141,154,156,157,158,159,160,162,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,186,188,189,190,191,192,193,195,196,197,198,200,201,202,203,204,205,206,207,208,213,214,215,216,225,239,240,245,246,247,248,249,250,251,253,254,255,256,257,258,259,260,261,263,265,267,269,270,272,273,275,408,409,410,411,415,416,417,418,419,420,421,422,423,424,425,426,427,428,429,443,444,445,446,447,449,454,455,460,466,467,468,469,470,471,472,473,474,475,476,477,478,479,480,481,482,483,484,485,486,487,488,489,490,491,492,493,494,495,496,497,498,499,503,504,555,558,610,630,646,647,649,650,660,661,665,669,670,671,672,679,680,704,707,708,731,733,734,735,736,737,738,739,740,741,742,743,744,745,746,747,748,753,754,852,856,857,858,859,860,862,863,864,865,866,867,868,869,870,871,872,873,874,875,876,877,878,879,880,881,882,883,900,901,902,903,904,905,906,907,908,909,910,911,912,913,914,915,916,917,918,919,920,921,922,923,924,925,926,927,928,966,968,974,979,980,981,983,984,985,986,987,988,989,990,991,992,993,994,995,996,997,998,999,1000,1001,1002,1003,1004,1005,1006,1007,1008,1009,1010,1011,1012,1013,1014,1015,1016,1017,1018,1019,1022,1023,1024,1025,1026,1027,1038,1039,1040,1041,1042,1043,1049,1055,1063,1065,1066,1070,1071,1076,1077,1078,1079,1080,1081,1083,1085,1086,1087,1088,1089,1090,1091,1092,1093,1094,1095,1096,1097,1098,1099,1100,1101,1102,1103,1104,1105,1106,1107,1122,1125,1130,1132,1144,1149,1150,1153,1154,1155,1156,1157,1158,1159,1161,1164,1167,1168,1172,1173,1180,1204,1205,1207,1216,1218,1219,1220,1221,1239,1241,1243,1244,1246,1254,1256,1258,1259,1260,1261,1277,1282,1291,1293,1299,1300,1306,1308,1309,1310,1311,1312,1345,1351,1352,1358,1359,1361,1377,1383,1386,1387,1388,1389,1399,1400,1401,1404,1406,1411,1412,1414,1416,1421,1424,1431,1451,1452,1454,1455,1465,1478,1481,1486,1492,1495,1496,1501,1503,1504,1505,1509,1514,1521,1522,1523,1524,1529,1530,1536,1537,1538,1543,1599,1600,1610,1615,1626,1644,1645,1646,1649,1658,1677,1678,1696,1697,1698,1699,1700,1701,1702,1703,1704,1705,1713,1715,1716,1717,1719,1720,1721,1722,1723,1724,1725,1726,1727,1728,1729,1730,1731,1732,1733,1734,1735,1736,1737,1738,1739,1740,1741,1742,1743,1744,1745,1746,1747,1748,1749,1751,1752,1753,1760,1761,1766,1772,1774,1775,1776,1778,1781,1787,1788,1790,1791,1795,1796,1802,1805,1807,1810,1811,1812,1817,1819,1820,1826,1843,1844,1845,1851,1852,1853,1854,1855,1858,1859,1861,1862,1863,1864,1865,1869,1870,1871,1872,1873,1874,1878,1879,1880,1894,1895,1910,1912,1914,1920,1921,1924,1925,1926,1927,1928,1929,1930,1931,1932,1934,1940,1941,1942,1944,1945,1949,1950,1951,1952,1953,1954,1955,1956,1957,1958,1961,1967,1968,1969,1972,1973,1974,1976,1977,1978,1979,1980,1981,1987,1988,1989,1990,1991,1992,1993,1994,1995,1996,1997,1998,1999,2000,2001,2002,2003,2004,2005,2006,2007,2008,2009,2011,2017,2018,2019,2020,2021,2022,2023,2025,2026,2027,2030,2031,2032,2033,2038,2039,2040,2041,2042,2043,2044,2045,2047,2048,2049,2050,2051,2052,2053,2054,2055,2056,2057,2058,2059,2060,2061,2062,2063,2064,2065,2066,2067,2068,2069,2070,2071,2072,2073,2074,2075,2076,2079,2082,2083,2084,2085,2086,2087,2088,2089,2090,2091,2095,2096,2097,2105,2106,2107,2108,2109,2110,2111,2112,2114,2115,2117,2118,2119,2121,2123,2124,2125,2127,2128,2129,2130,2132,2133,2134,2137,2138,2139,2140,2141,2142,2143,2144,2151,2152,2155,2159,2160,2161,2162,2163,2164,2165,2168,2169,2170,2171,2173,2174,2175,2176,2177,2178,2179,2180,2181,2183,2184,2185,2186,2187,2188,2191,2192,2193,2194,2195,2197,2202,2204,2205,2206,2207,2208,2209,2210,2211,2212,2213,2214,2215,2216,2218,2221,2222,2223,2225,2226,2227,2228,2229,2230,2231,2234,2235,2236,2237,2238,2239,2240,2241,2243,2245,2246,2247,2248,2249,2250,2251,2252,2253,2255,2256,2259,2260,2262,2263,2264,2266,2267,2268,2269,2270,2271,2272,2273,2274,2275,2276,2278,2279,2280,2281,2282,2283,2284,2285,2286,2287,2288,2289,2290,2291,2292,2293,2294,2295,2300,2301,2302,2303,2304,2305,2306,2307,2308,2309,2310,2311,2312,2313,2314,2315,2316,2317,2318,2319,2320,2321,2322,2323,2324,2325,2326,2327,2328,2329,2330,2331,2332,2333,2334,2335,2336,2337,2338,2339,2340,2341,2342,2343,2344,2345,2346,2347,2348,2349,2350,2351,2352,2353,2354,2355,2356,2357,2358,2359,2360,2361,2362,2363,2364,2370,2371,2372,2373,2374,2375,2376,2383,2385,2386,2387,2388,2391,2392,2393,2394,2395,2396,2397,2398,2399,2400,2401,2402,2403,2404,2405,2406,2408,2409,2410,2411,2412,2413,2414,2416,2417,2418,2419,2420,2421,2422,2423,2425,2426,2427,2428,2429,2430,2431,2432,2433,2434,2435,2436,2437,2438,2439,2440,2441,2443,2444,2445,2447,2448,2449,2450,2451,2452,2454,2455,2456,2458,2459,2460,2461,2462,2463,2465,2466,2467,2468,2469,2470,2471,2472,2473,2474,2475,2476,2477,2478,2479,2480,2483,2484,2485,2486,2487,2488,2489,2490,2491,2492,2493,2496,2497,2498,2503,2504,2505,2506,2507,2508,2509,2510,2511,2512,2513,2514,2515,2516,2517,2518,2519,2520,2521,2522,2523,2524,2525,2526,2527,2528,2529,2530,2531,2532,2533,2534,2535,2536,2537,2538,2539,2540,2541,2542,2543,2544,2545,2546,2547,2548,2549,2550,2551,2552,2553,2554,2555,2556,2557,2558,2559,2560,2561,2562,2563,2564,2565,2566,2567,2568,2569,2570,2571,2572,2573,2574,2575,2576,2577,2578,2579,2580,2581,2582,2583,2586,2587,2588,2589,2590,2591,2592,2595,2596,2597,2598,2599,2600,2601,2602,2603,2604,2605,2608,2609,2610,2613,2614,2615,2616,2617,2618,2619,2620,2621,2622,2623,2624,2625,2626,2627,2628,2629,2630,2631,2632,2633,2634,2637,2638,2639,2640,2641,2642,2643,2644,2645,2646,2647,2648,2649,2650,2651,2652,2653,2654,2655,2656,2657,2658,2659,2660,2661,2662,2663,2664,2665,2666,2667,2668,2669,2670,2671,2672,2673,2674,2675,2676,2677,2678,2679,2680,2681,2682,2683,2684,2685,2686,2687,2688,2689,2690,2691,2692,2693,2694,2695,2696,2697,2698,2699,2700,2701,2702,2703,2704,2705,2706,2707,2708,2709,2711,2713,2714,2715,2716,2717,2718,2719,2721,2722,2723,2724,2725,2726,2729,2730,2731,2732,2733,2734,2735,2736,2737,2738,2739,2745,2747,2748,2749,2750,2751,2752,2753,2754,2755,2757,2758,2759,2760,2761,2762,2763,2764,2765,2766,2767,2768,2769,2770,2771,2772,2773,2775,2776,2778,2779,2780,2781,2782,2783,2784,2785,2786,2788,2789,2791,2793,2794,2795,2796,2797,2798,2800,2801,2802,2803,2805,2806,2807,2808,2809,2810,2811,2812,2813,2814,2815,2816,2817,2818,2819,2820,2821,2824,2825,2826,2827,2828,2829,2831,2832,2833,2836,2837,2838,2839,2840,2841,2843,2844,2845,2846,2850,2854,2855,2856,2861,2865,2866,2867,2868,2869,2870,2871,2872,2874,2875,2876,2877,2878,2879,2880,2883,2884,2885,2886,2887,2896,2901,2902);

    $planes_emitidos = $db_mysql->query("SELECT producto as idplan 
                                            FROM orders 
                                            WHERE fecha >= '2024-01-01' 
                                            AND status IN (1,2,4) 
                                            GROUP BY 1 
                                            ORDER BY 1 ");
                                    
    while ($row = $planes_emitidos->fetch_array(MYSQLI_ASSOC)) 
    {
        $planes[] = $row['idplan'];
    }

    

    foreach($planes as $idplan)
    {
        if(!in_array($idplan, $archivo_planes))
        {
            array_push($archivo_planes, $idplan);
        }
    }
          
    $planes = array();

    $planes_riesgo = $db_mysql->query("SELECT producto as idplan 
                                            FROM orders 
                                            WHERE retorno >= '2024-01-01' 
                                            AND status IN (1,2,4) 
                                            GROUP BY 1 
                                            ORDER BY 1 ");

    while ($row = $planes_riesgo->fetch_array(MYSQLI_ASSOC)) 
    {
        $planes[] = $row['idplan'];
    }

    foreach($planes as $idplan)
    {
        if(!in_array($idplan, $archivo_planes))
        {
            array_push($archivo_planes, $idplan);
        }
    }

    $planes = array();
    //2019 
    $planes_bolsas_dias = $db_mysql->query("SELECT producto as idplan 
                                            FROM orders 
                                            WHERE fecha >= '2024-01-01'
                                            AND programaplan IN (14) 
                                            AND status IN (1,2,4) 
                                            GROUP BY 1 
                                            ORDER BY 1 ");

    while ($row = $planes_bolsas_dias->fetch_array(MYSQLI_ASSOC)) 
    {
        $planesbolsas[] = $row['idplan'];
    }

    foreach($planesbolsas as $idplan)
    {
        if(!in_array($idplan, $archivo_planes))
        {
            array_push($archivo_planes, $idplan);
        }
    }
    
    //2019
    $precompras = $db_mysql->query("SELECT producto as idplan 
                                    FROM orders 
                                    WHERE fecha >= '2024-01-01' 
                                    AND programaplan IN (32) 
                                    AND status IN (1,2,4) 
                                    GROUP BY 1 
                                    ORDER BY 1 ");

    while ($row = $precompras->fetch_array(MYSQLI_ASSOC)) 
    {
        $planesprecompra[] = $row['idplan'];
    }
   
    foreach($planesprecompra as $idplan)
    {
        if(!in_array($idplan, $archivo_planes))
        {
            array_push($archivo_planes, $idplan);
        }
    }
    



    // PLANES BLOQUEADOS PERSONALIZADOS
        $planes_bloqueados       = array();
        
        $planes_bloqueados[0]    = array("idagencia" => 3890, "planes" => array(1540,1541,1542,1583,1544,1545,1550));
        $planes_bloqueados[1]    = array("idagencia" => 2477, "planes" => array(1934,2186,2187,2188,1167,1168,1306,1300,1309,1311,1310,1308,2633,2632));
        $planes_bloqueados[2]    = array("idagencia" => 907, "planes" => array(1564,1565,1566,1567,1568,1569,1570));
        $planes_bloqueados[3]    = array("idagencia" => 3440, "planes" => array(1716,1717,1718,1719,1720,1721,1722,1723,1724,1725,1726,1727,1728,1729,1730,1731));
        $planes_bloqueados[4]    = array("idagencia" => 4092, "planes" => array(1649,1650,1651,1652,1653,1654,1655));
        $planes_bloqueados[5]    = array("idagencia" => 2042, "planes" => array(2085,2086));
        $planes_bloqueados[6]    = array("idagencia" => 4598, "planes" => array(2249,2250,2251,2252));
        $planes_bloqueados[7]    = array("idagencia" => 4808, "planes" => array(2189,2190,2191,2192,2193,2194,2195,2196,2197,2198,2199,2200,2244,2379,2380,2381,2382));
        $planes_bloqueados[8]    = array("idagencia" => 5768, "planes" => array(2577,2578,2579,2580,2581,2582));
        $planes_bloqueados[9]    = array("idagencia" => 5211, "planes" => array(87,88,89,1869,1377));
        $planes_bloqueados[10]   = array("idagencia" => 4387, "planes" => array(2597,2598,2600,2599,2601,2602,2605,2604,2607,2606));
        $planes_bloqueados[11]   = array("idagencia" => 4726, "planes" => array(2646,2647,2648));
        $planes_bloqueados[12]   = array("idagencia" => 4723, "planes" => array(2108,2111,2106,2107,2109,2110));
        $planes_bloqueados[13]   = array("idagencia" => 1687, "planes" => array(1353,707,1352,1644,1910,2490));
        $planes_bloqueados[14]   = array("idagencia" => 3691, "planes" => array(1353,707));
        $planes_bloqueados[15]   = array("idagencia" => 5799, "planes" => array(2508,2509));
        $planes_bloqueados[16]   = array("idagencia" => 5580, "planes" => array(2610,2621,2622,2623,2624,2625,2626,2627,2628));
        $planes_bloqueados[17]   = array("idagencia" => 4496, "planes" => array(1937,1939));
        $planes_bloqueados[18]   = array("idagencia" => 4728, "planes" => array(1937,1939));
        $planes_bloqueados[19]   = array("idagencia" => 4626, "planes" => array(192));
        $planes_bloqueados[20]   = array("idagencia" => 5908 , "planes" => array(2538,2539,2540,2542,2543));
        $planes_bloqueados[21]   = array("idagencia" => 4748, "planes" => array(88));
        $planes_bloqueados[22]   = array("idagencia" => 3938, "planes" => array(2391,2393,2394,2395,2396,2397,2398,2399,2400,2401,2402,2403,2404,2405,2406));
        $planes_bloqueados[23]   = array("idagencia" => 6106, "planes" => array(56,87,88,89,1377,1869));
        $planes_bloqueados[24]   = array("idagencia" => 4672, "planes" => array(1716,1717,1718,1719,2106,2107,2108,2109,2110,2111));
        $planes_bloqueados[25]   = array("idagencia" => 5906, "planes" => array(1870));
        $planes_bloqueados[26]   = array("idagencia" => 5931, "planes" => array(2557,2558,2559,2560,2561,2562,2563,2564,2565,2566));
        $planes_bloqueados[27]   = array("idagencia" => 5990, "planes" => array(2557,2558,2559,2560,2561,2562,2563,2564,2565,2566));
        $planes_bloqueados[28]   = array("idagencia" => 6057, "planes" => array(2637,2658,2659,2660,2638,2661,2662,2663,2639,2664,2665,2666,2640,2667,2668,2669,2641,2670,2671,2672,2642,2682,2683,2684,2643,2694,2695,2696,2649,2673,2674,2675,2650,2685,2686,2687,2651,2697,2698,2699,2652,2676,2677,2678,2653,2688,2689,2690,2654,2701,2702,2703,2655,2679,2680,2681,2656,2691,2692,2693,2657,2703,2704,2705));
        $planes_bloqueados[29]   = array("idagencia" => 6058, "planes" => array(2637,2658,2659,2660,2638,2661,2662,2663,2639,2664,2665,2666,2640,2667,2668,2669,2641,2670,2671,2672,2642,2682,2683,2684,2643,2694,2695,2696,2649,2673,2674,2675,2650,2685,2686,2687,2651,2697,2698,2699,2652,2676,2677,2678,2653,2688,2689,2690,2654,2701,2702,2703,2655,2679,2680,2681,2656,2691,2692,2693,2657,2703,2704,2705));
        $planes_bloqueados[30]   = array("idagencia" => 4677, "planes" => array(2017,2018));
        $planes_bloqueados[31]   = array("idagencia" => 4626, "planes" => array(200,498,499));
        $planes_bloqueados[32]   = array("idagencia" => 4232, "planes" => array(1778));
        $planes_bloqueados[33]   = array("idagencia" => 5350, "planes" => array(89));
        $planes_bloqueados[34]   = array("idagencia" => 4429, "planes" => array(484,485,486,487,471,476,477,472,478,479,474,480,481,473,482,470,490,491));
        $planes_bloqueados[35]   = array("idagencia" => 2297, "planes" => array(21,87,89));
        $planes_bloqueados[36]   = array("idagencia" => 5532, "planes" => array(2041,2042,2043));
        $planes_bloqueados[37]   = array("idagencia" => 5888, "planes" => array(2530,2531,2532,2533,2534,2535));
        $planes_bloqueados[38]   = array("idagencia" => 5923, "planes" => array(267,269,270,272,273,275));
        $planes_bloqueados[39]   = array("idagencia" => 5217, "planes" => array(2569,2570));
        $planes_bloqueados[40]   = array("idagencia" => 5339, "planes" => array(114,116,21,123,56,87,92));
        $planes_bloqueados[41]   = array("idagencia" => 2297, "planes" => array(21,87,89));
        $planes_bloqueados[42]   = array("idagencia" => 5248, "planes" => array(21,123));
        $planes_bloqueados[43]   = array("idagencia" => 5901, "planes" => array(56,87,88,1869,1377));
        $planes_bloqueados[44]   = array("idagencia" => 1425, "planes" => array(157,159,160,162));
        $planes_bloqueados[45]   = array("idagencia" => 6115, "planes" => array(2706,2707,2708,2709,2710));
        $planes_bloqueados[46]   = array("idagencia" => 6117, "planes" => array(484,485,486,487));
        $planes_bloqueados[47]   = array("idagencia" => 3514, "planes" => array(88,1869));
        $planes_bloqueados[48]   = array("idagencia" => 118, "planes" => array(2946,2964,2965));

        foreach($planes_bloqueados as $agencia)
        {
            foreach($agencia['planes'] as $idplan)
            {
                if(!in_array($idplan, $archivo_planes))
                {
                    array_push($archivo_planes, $idplan);
                }
            }
        }

        


    sort($archivo_planes);


    $implode_planes = implode(",", $archivo_planes);

    $paises = array(
        array("idpais" => 99, "idplan" => 249, "sustituido_por" => 249),
        array("idpais" => 99, "idplan" => 255, "sustituido_por" => 255),
        array("idpais" => 99, "idplan" => 256, "sustituido_por" => 256),
        array("idpais" => 99, "idplan" => 253, "sustituido_por" => 253),
        array("idpais" => 99, "idplan" => 259, "sustituido_por" => 259),
        array("idpais" => 99, "idplan" => 260, "sustituido_por" => 260),
        array("idpais" => 99, "idplan" => 254, "sustituido_por" => 254),
        array("idpais" => 99, "idplan" => 496, "sustituido_por" => 496),
        array("idpais" => 99, "idplan" => 497, "sustituido_por" => 497),
        array("idpais" => 99, "idplan" => 251, "sustituido_por" => 251),
        array("idpais" => 99, "idplan" => 261, "sustituido_por" => 261),
        array("idpais" => 99, "idplan" => 208, "sustituido_por" => 208),
        array("idpais" => 99, "idplan" => 250, "sustituido_por" => 250),
        array("idpais" => 99, "idplan" => 257, "sustituido_por" => 257),
        array("idpais" => 99, "idplan" => 258, "sustituido_por" => 258),
        array("idpais" => 99, "idplan" => 1543, "sustituido_por" => 253),
        array("idpais" => 99, "idplan" => 2649, "sustituido_por" => 253),
        array("idpais" => 99, "idplan" => 2673, "sustituido_por" => 253),
        array("idpais" => 99, "idplan" => 2674, "sustituido_por" => 253),
        array("idpais" => 99, "idplan" => 2675, "sustituido_por" => 253),
        array("idpais" => 99, "idplan" => 2650, "sustituido_por" => 259),
        array("idpais" => 99, "idplan" => 2685, "sustituido_por" => 259),
        array("idpais" => 99, "idplan" => 2686, "sustituido_por" => 259),
        array("idpais" => 99, "idplan" => 2687, "sustituido_por" => 259),
        array("idpais" => 99, "idplan" => 2651, "sustituido_por" => 260),
        array("idpais" => 99, "idplan" => 2697, "sustituido_por" => 260),
        array("idpais" => 99, "idplan" => 2698, "sustituido_por" => 260),
        array("idpais" => 99, "idplan" => 2699, "sustituido_por" => 260),
        array("idpais" => 99, "idplan" => 2655, "sustituido_por" => 254),
        array("idpais" => 99, "idplan" => 2679, "sustituido_por" => 254),
        array("idpais" => 99, "idplan" => 2681, "sustituido_por" => 254),
        array("idpais" => 99, "idplan" => 2680, "sustituido_por" => 254),
        array("idpais" => 99, "idplan" => 2656, "sustituido_por" => 496),
        array("idpais" => 99, "idplan" => 2691, "sustituido_por" => 496),
        array("idpais" => 99, "idplan" => 2692, "sustituido_por" => 496),
        array("idpais" => 99, "idplan" => 2693, "sustituido_por" => 496),
        array("idpais" => 99, "idplan" => 2657, "sustituido_por" => 497),
        array("idpais" => 99, "idplan" => 2703, "sustituido_por" => 497),
        array("idpais" => 99, "idplan" => 2704, "sustituido_por" => 497),
        array("idpais" => 99, "idplan" => 2705, "sustituido_por" => 497),
        array("idpais" => 99, "idplan" => 2652, "sustituido_por" => 251),
        array("idpais" => 99, "idplan" => 2676, "sustituido_por" => 251),
        array("idpais" => 99, "idplan" => 2677, "sustituido_por" => 251),
        array("idpais" => 99, "idplan" => 2678, "sustituido_por" => 251),
        array("idpais" => 99, "idplan" => 2653, "sustituido_por" => 261),
        array("idpais" => 99, "idplan" => 2688, "sustituido_por" => 261),
        array("idpais" => 99, "idplan" => 2689, "sustituido_por" => 261),
        array("idpais" => 99, "idplan" => 2690, "sustituido_por" => 261),
        array("idpais" => 99, "idplan" => 2654, "sustituido_por" => 208),
        array("idpais" => 99, "idplan" => 2700, "sustituido_por" => 208),
        array("idpais" => 99, "idplan" => 2701, "sustituido_por" => 208),
        array("idpais" => 99, "idplan" => 2702, "sustituido_por" => 208),
        array("idpais" => 99, "idplan" => 2641, "sustituido_por" => 250),
        array("idpais" => 99, "idplan" => 2670, "sustituido_por" => 250),
        array("idpais" => 99, "idplan" => 2671, "sustituido_por" => 250),
        array("idpais" => 99, "idplan" => 2672, "sustituido_por" => 250),
        array("idpais" => 99, "idplan" => 2642, "sustituido_por" => 257),
        array("idpais" => 99, "idplan" => 2682, "sustituido_por" => 257),
        array("idpais" => 99, "idplan" => 2683, "sustituido_por" => 257),
        array("idpais" => 99, "idplan" => 2684, "sustituido_por" => 257),
        array("idpais" => 99, "idplan" => 2643, "sustituido_por" => 258),
        array("idpais" => 99, "idplan" => 2694, "sustituido_por" => 258),
        array("idpais" => 99, "idplan" => 2695, "sustituido_por" => 258),
        array("idpais" => 99, "idplan" => 2696, "sustituido_por" => 258),
        array("idpais" => 99, "idplan" => 1994, "sustituido_por" => 249),
        array("idpais" => 99, "idplan" => 1995, "sustituido_por" => 255),
        array("idpais" => 99, "idplan" => 2000, "sustituido_por" => 253),
        array("idpais" => 99, "idplan" => 2003, "sustituido_por" => 251),
        array("idpais" => 99, "idplan" => 2004, "sustituido_por" => 261),
        array("idpais" => 99, "idplan" => 1997, "sustituido_por" => 250),
        array("idpais" => 99, "idplan" => 1998, "sustituido_por" => 257),
        array("idpais" => 99, "idplan" => 1999, "sustituido_por" => 258),
        array("idpais" => 99, "idplan" => 492, "sustituido_por" => 492),
        array("idpais" => 99, "idplan" => 493, "sustituido_por" => 493),
        array("idpais" => 99, "idplan" => 245, "sustituido_por" => 245),
        array("idpais" => 99, "idplan" => 247, "sustituido_por" => 247),
        array("idpais" => 99, "idplan" => 248, "sustituido_por" => 248),
        array("idpais" => 99, "idplan" => 246, "sustituido_por" => 246),
        array("idpais" => 99, "idplan" => 1122, "sustituido_por" => 1122),
        array("idpais" => 99, "idplan" => 1920, "sustituido_por" => 1920),
        array("idpais" => 99, "idplan" => 1958, "sustituido_por" => 1958),
        array("idpais" => 99, "idplan" => 1310, "sustituido_por" => 272),
        array("idpais" => 99, "idplan" => 1308, "sustituido_por" => 267),
        array("idpais" => 99, "idplan" => 2187, "sustituido_por" => 270),
        array("idpais" => 99, "idplan" => 1300, "sustituido_por" => 272),
        array("idpais" => 99, "idplan" => 1311, "sustituido_por" => 270),
        array("idpais" => 99, "idplan" => 630, "sustituido_por" => 630),
        array("idpais" => 99, "idplan" => 1844, "sustituido_por" => 1844),
        array("idpais" => 99, "idplan" => 1843, "sustituido_por" => 1843),
        array("idpais" => 99, "idplan" => 1168, "sustituido_por" => 269),
        array("idpais" => 99, "idplan" => 2079, "sustituido_por" => 2079),
        array("idpais" => 99, "idplan" => 1945, "sustituido_por" => 1945),
        array("idpais" => 99, "idplan" => 1167, "sustituido_por" => 267),
        array("idpais" => 99, "idplan" => 1312, "sustituido_por" => 1312),
        array("idpais" => 99, "idplan" => 1306, "sustituido_por" => 270),
        array("idpais" => 99, "idplan" => 2225, "sustituido_por" => 2225),
        array("idpais" => 99, "idplan" => 1978, "sustituido_por" => 1978),
        array("idpais" => 99, "idplan" => 2188, "sustituido_por" => 272),
        array("idpais" => 99, "idplan" => 2186, "sustituido_por" => 269),
        array("idpais" => 99, "idplan" => 1309, "sustituido_por" => 269),
        array("idpais" => 99, "idplan" => 1351, "sustituido_por" => 1351),
        array("idpais" => 99, "idplan" => 1934, "sustituido_por" => 1934),
        array("idpais" => 99, "idplan" => 2632, "sustituido_por" => 2632),
        array("idpais" => 99, "idplan" => 2633, "sustituido_por" => 2633),
        array("idpais" => 99, "idplan" => 1967, "sustituido_por" => 1967),
        array("idpais" => 99, "idplan" => 2239, "sustituido_por" => 267),
        array("idpais" => 99, "idplan" => 2240, "sustituido_por" => 269),
        array("idpais" => 99, "idplan" => 2241, "sustituido_por" => 267),
        array("idpais" => 99, "idplan" => 2142, "sustituido_por" => 2142),
        array("idpais" => 99, "idplan" => 1845, "sustituido_por" => 1845),
        array("idpais" => 99, "idplan" => 1649, "sustituido_por" => 267),
        array("idpais" => 99, "idplan" => 275, "sustituido_por" => 275),
        array("idpais" => 99, "idplan" => 267, "sustituido_por" => 267),
        array("idpais" => 99, "idplan" => 270, "sustituido_por" => 270),
        array("idpais" => 99, "idplan" => 273, "sustituido_por" => 273),
        array("idpais" => 99, "idplan" => 272, "sustituido_por" => 272),
        array("idpais" => 99, "idplan" => 269, "sustituido_por" => 269),
        array("idpais" => 99, "idplan" => 852, "sustituido_por" => 852),
        array("idpais" => 99, "idplan" => 2249, "sustituido_por" => 267),
        array("idpais" => 99, "idplan" => 2250, "sustituido_por" => 269),
        array("idpais" => 99, "idplan" => 2251, "sustituido_por" => 270),
        array("idpais" => 99, "idplan" => 2252, "sustituido_por" => 272),
        array("idpais" => 99, "idplan" => 2638, "sustituido_por" => 270),
        array("idpais" => 99, "idplan" => 2661, "sustituido_por" => 270),
        array("idpais" => 99, "idplan" => 2662, "sustituido_por" => 270),
        array("idpais" => 99, "idplan" => 2663, "sustituido_por" => 270),
        array("idpais" => 99, "idplan" => 2640, "sustituido_por" => 273),
        array("idpais" => 99, "idplan" => 2667, "sustituido_por" => 273),
        array("idpais" => 99, "idplan" => 2668, "sustituido_por" => 273),
        array("idpais" => 99, "idplan" => 2669, "sustituido_por" => 273),
        array("idpais" => 99, "idplan" => 2639, "sustituido_por" => 272),
        array("idpais" => 99, "idplan" => 2664, "sustituido_por" => 272),
        array("idpais" => 99, "idplan" => 2665, "sustituido_por" => 272),
        array("idpais" => 99, "idplan" => 2666, "sustituido_por" => 272),
        array("idpais" => 99, "idplan" => 2637, "sustituido_por" => 269),
        array("idpais" => 99, "idplan" => 2658, "sustituido_por" => 269),
        array("idpais" => 99, "idplan" => 2659, "sustituido_por" => 269),
        array("idpais" => 99, "idplan" => 2660, "sustituido_por" => 269),
        array("idpais" => 99, "idplan" => 1990, "sustituido_por" => 267),
        array("idpais" => 99, "idplan" => 1992, "sustituido_por" => 270),
        array("idpais" => 99, "idplan" => 1993, "sustituido_por" => 272),
        array("idpais" => 99, "idplan" => 1991, "sustituido_por" => 269),
        array("idpais" => 1, "idplan" => 2054, "sustituido_por" => 249),
        array("idpais" => 1, "idplan" => 2059, "sustituido_por" => 255),
        array("idpais" => 1, "idplan" => 2064, "sustituido_por" => 256),
        array("idpais" => 1, "idplan" => 2056, "sustituido_por" => 253),
        array("idpais" => 1, "idplan" => 2061, "sustituido_por" => 259),
        array("idpais" => 1, "idplan" => 2066, "sustituido_por" => 260),
        array("idpais" => 1, "idplan" => 2058, "sustituido_por" => 254),
        array("idpais" => 1, "idplan" => 2063, "sustituido_por" => 496),
        array("idpais" => 1, "idplan" => 2068, "sustituido_por" => 497),
        array("idpais" => 1, "idplan" => 2057, "sustituido_por" => 251),
        array("idpais" => 1, "idplan" => 2062, "sustituido_por" => 261),
        array("idpais" => 1, "idplan" => 2067, "sustituido_por" => 208),
        array("idpais" => 1, "idplan" => 2055, "sustituido_por" => 250),
        array("idpais" => 1, "idplan" => 2060, "sustituido_por" => 257),
        array("idpais" => 1, "idplan" => 2065, "sustituido_por" => 258),
        array("idpais" => 1, "idplan" => 2033, "sustituido_por" => 2033),
        array("idpais" => 1, "idplan" => 2073, "sustituido_por" => 492),
        array("idpais" => 1, "idplan" => 2074, "sustituido_por" => 493),
        array("idpais" => 1, "idplan" => 2069, "sustituido_por" => 245),
        array("idpais" => 1, "idplan" => 2071, "sustituido_por" => 247),
        array("idpais" => 1, "idplan" => 2072, "sustituido_por" => 248),
        array("idpais" => 1, "idplan" => 2070, "sustituido_por" => 246),
        array("idpais" => 1, "idplan" => 2049, "sustituido_por" => 275),
        array("idpais" => 1, "idplan" => 2048, "sustituido_por" => 267),
        array("idpais" => 1, "idplan" => 2051, "sustituido_por" => 270),
        array("idpais" => 1, "idplan" => 2053, "sustituido_por" => 273),
        array("idpais" => 1, "idplan" => 2052, "sustituido_por" => 272),
        array("idpais" => 1, "idplan" => 2050, "sustituido_por" => 269),
        array("idpais" => 1, "idplan" => 2047, "sustituido_por" => 852),
        array("idpais" => 2, "idplan" => 2095, "sustituido_por" => 249),
        array("idpais" => 2, "idplan" => 2477, "sustituido_por" => 255),
        array("idpais" => 2, "idplan" => 2478, "sustituido_por" => 256),
        array("idpais" => 2, "idplan" => 2483, "sustituido_por" => 253),
        array("idpais" => 2, "idplan" => 2484, "sustituido_por" => 253),
        array("idpais" => 2, "idplan" => 2485, "sustituido_por" => 253),
        array("idpais" => 2, "idplan" => 2486, "sustituido_por" => 251),
        array("idpais" => 2, "idplan" => 2487, "sustituido_por" => 261),
        array("idpais" => 2, "idplan" => 2488, "sustituido_por" => 208),
        array("idpais" => 2, "idplan" => 2479, "sustituido_por" => 253),
        array("idpais" => 2, "idplan" => 2096, "sustituido_por" => 259),
        array("idpais" => 2, "idplan" => 2480, "sustituido_por" => 260),
        array("idpais" => 2, "idplan" => 2112, "sustituido_por" => 492),
        array("idpais" => 2, "idplan" => 2088, "sustituido_por" => 245),
        array("idpais" => 2, "idplan" => 2090, "sustituido_por" => 247),
        array("idpais" => 2, "idplan" => 2089, "sustituido_por" => 246),
        array("idpais" => 2, "idplan" => 2091, "sustituido_por" => 248),
        array("idpais" => 2, "idplan" => 2106, "sustituido_por" => 267),
        array("idpais" => 2, "idplan" => 2111, "sustituido_por" => 273),
        array("idpais" => 2, "idplan" => 2109, "sustituido_por" => 270),
        array("idpais" => 2, "idplan" => 2107, "sustituido_por" => 269),
        array("idpais" => 2, "idplan" => 2108, "sustituido_por" => 275),
        array("idpais" => 2, "idplan" => 2110, "sustituido_por" => 272),
        array("idpais" => 2, "idplan" => 2160, "sustituido_por" => 270),
        array("idpais" => 2, "idplan" => 2159, "sustituido_por" => 269),
        array("idpais" => 2, "idplan" => 2161, "sustituido_por" => 272),
        array("idpais" => 2, "idplan" => 2105, "sustituido_por" => 852),
        array("idpais" => 4, "idplan" => 415, "sustituido_por" => 249),
        array("idpais" => 4, "idplan" => 416, "sustituido_por" => 255),
        array("idpais" => 4, "idplan" => 417, "sustituido_por" => 256),
        array("idpais" => 4, "idplan" => 421, "sustituido_por" => 253),
        array("idpais" => 4, "idplan" => 422, "sustituido_por" => 259),
        array("idpais" => 4, "idplan" => 423, "sustituido_por" => 260),
        array("idpais" => 4, "idplan" => 427, "sustituido_por" => 254),
        array("idpais" => 4, "idplan" => 428, "sustituido_por" => 496),
        array("idpais" => 4, "idplan" => 429, "sustituido_por" => 497),
        array("idpais" => 4, "idplan" => 424, "sustituido_por" => 251),
        array("idpais" => 4, "idplan" => 425, "sustituido_por" => 261),
        array("idpais" => 4, "idplan" => 426, "sustituido_por" => 208),
        array("idpais" => 4, "idplan" => 418, "sustituido_por" => 250),
        array("idpais" => 4, "idplan" => 419, "sustituido_por" => 257),
        array("idpais" => 4, "idplan" => 420, "sustituido_por" => 258),
        array("idpais" => 4, "idplan" => 454, "sustituido_por" => 492),
        array("idpais" => 4, "idplan" => 455, "sustituido_por" => 493),
        array("idpais" => 4, "idplan" => 408, "sustituido_por" => 245),
        array("idpais" => 4, "idplan" => 410, "sustituido_por" => 247),
        array("idpais" => 4, "idplan" => 411, "sustituido_por" => 248),
        array("idpais" => 4, "idplan" => 409, "sustituido_por" => 246),
        array("idpais" => 4, "idplan" => 1153, "sustituido_por" => 275),
        array("idpais" => 4, "idplan" => 1156, "sustituido_por" => 245),
        array("idpais" => 4, "idplan" => 1149, "sustituido_por" => 267),
        array("idpais" => 4, "idplan" => 1154, "sustituido_por" => 270),
        array("idpais" => 4, "idplan" => 1159, "sustituido_por" => 493),
        array("idpais" => 4, "idplan" => 1158, "sustituido_por" => 492),
        array("idpais" => 4, "idplan" => 1155, "sustituido_por" => 272),
        array("idpais" => 4, "idplan" => 1157, "sustituido_por" => 246),
        array("idpais" => 4, "idplan" => 1150, "sustituido_por" => 269),
        array("idpais" => 4, "idplan" => 445, "sustituido_por" => 275),
        array("idpais" => 4, "idplan" => 443, "sustituido_por" => 267),
        array("idpais" => 4, "idplan" => 446, "sustituido_por" => 270),
        array("idpais" => 4, "idplan" => 449, "sustituido_por" => 273),
        array("idpais" => 4, "idplan" => 447, "sustituido_por" => 272),
        array("idpais" => 4, "idplan" => 444, "sustituido_por" => 269),
        array("idpais" => 5, "idplan" => 165, "sustituido_por" => 165),
        array("idpais" => 5, "idplan" => 166, "sustituido_por" => 166),
        array("idpais" => 5, "idplan" => 167, "sustituido_por" => 167),
        array("idpais" => 5, "idplan" => 171, "sustituido_por" => 171),
        array("idpais" => 5, "idplan" => 172, "sustituido_por" => 172),
        array("idpais" => 5, "idplan" => 173, "sustituido_por" => 173),
        array("idpais" => 5, "idplan" => 177, "sustituido_por" => 177),
        array("idpais" => 5, "idplan" => 239, "sustituido_por" => 239),
        array("idpais" => 5, "idplan" => 240, "sustituido_por" => 240),
        array("idpais" => 5, "idplan" => 174, "sustituido_por" => 174),
        array("idpais" => 5, "idplan" => 175, "sustituido_por" => 175),
        array("idpais" => 5, "idplan" => 176, "sustituido_por" => 176),
        array("idpais" => 5, "idplan" => 168, "sustituido_por" => 168),
        array("idpais" => 5, "idplan" => 169, "sustituido_por" => 169),
        array("idpais" => 5, "idplan" => 170, "sustituido_por" => 170),
        array("idpais" => 5, "idplan" => 2614, "sustituido_por" => 171),
        array("idpais" => 5, "idplan" => 2615, "sustituido_por" => 174),
        array("idpais" => 5, "idplan" => 2613, "sustituido_por" => 168),
        array("idpais" => 5, "idplan" => 2624, "sustituido_por" => 171),
        array("idpais" => 5, "idplan" => 2625, "sustituido_por" => 174),
        array("idpais" => 5, "idplan" => 2623, "sustituido_por" => 168),
        array("idpais" => 5, "idplan" => 2575, "sustituido_por" => 2575),
        array("idpais" => 5, "idplan" => 1049, "sustituido_por" => 1049),
        array("idpais" => 5, "idplan" => 2427, "sustituido_por" => 2427),
        array("idpais" => 5, "idplan" => 2448, "sustituido_por" => 2448),
        array("idpais" => 5, "idplan" => 2226, "sustituido_por" => 2226),
        array("idpais" => 5, "idplan" => 2227, "sustituido_por" => 2227),
        array("idpais" => 5, "idplan" => 2574, "sustituido_por" => 2574),
        array("idpais" => 5, "idplan" => 2387, "sustituido_por" => 2387),
        array("idpais" => 5, "idplan" => 2491, "sustituido_por" => 2491),
        array("idpais" => 5, "idplan" => 2114, "sustituido_por" => 2114),
        array("idpais" => 5, "idplan" => 2228, "sustituido_por" => 2228),
        array("idpais" => 5, "idplan" => 2773, "sustituido_por" => 2773),
        array("idpais" => 5, "idplan" => 1961, "sustituido_por" => 1961),
        array("idpais" => 5, "idplan" => 2426, "sustituido_por" => 2426),
        array("idpais" => 5, "idplan" => 2723, "sustituido_por" => 2723),
        array("idpais" => 5, "idplan" => 2275, "sustituido_por" => 2275),
        array("idpais" => 5, "idplan" => 2152, "sustituido_por" => 2152),
        array("idpais" => 5, "idplan" => 2455, "sustituido_por" => 2455),
        array("idpais" => 5, "idplan" => 2739, "sustituido_por" => 2739),
        array("idpais" => 5, "idplan" => 2151, "sustituido_por" => 2151),
        array("idpais" => 5, "idplan" => 2234, "sustituido_por" => 2234),
        array("idpais" => 5, "idplan" => 2529, "sustituido_por" => 2529),
        array("idpais" => 5, "idplan" => 2620, "sustituido_por" => 2620),
        array("idpais" => 5, "idplan" => 2202, "sustituido_por" => 2202),
        array("idpais" => 5, "idplan" => 2411, "sustituido_por" => 2411),
        array("idpais" => 5, "idplan" => 2408, "sustituido_por" => 2408),
        array("idpais" => 5, "idplan" => 2414, "sustituido_por" => 2414),
        array("idpais" => 5, "idplan" => 2416, "sustituido_por" => 2416),
        array("idpais" => 5, "idplan" => 2413, "sustituido_por" => 2413),
        array("idpais" => 5, "idplan" => 661, "sustituido_por" => 661),
        array("idpais" => 5, "idplan" => 182, "sustituido_por" => 182),
        array("idpais" => 5, "idplan" => 183, "sustituido_por" => 183),
        array("idpais" => 5, "idplan" => 178, "sustituido_por" => 178),
        array("idpais" => 5, "idplan" => 180, "sustituido_por" => 180),
        array("idpais" => 5, "idplan" => 181, "sustituido_por" => 181),
        array("idpais" => 5, "idplan" => 179, "sustituido_por" => 179),
        array("idpais" => 5, "idplan" => 2616, "sustituido_por" => 2616),
        array("idpais" => 5, "idplan" => 2617, "sustituido_por" => 2617),
        array("idpais" => 5, "idplan" => 2627, "sustituido_por" => 2627),
        array("idpais" => 5, "idplan" => 2618, "sustituido_por" => 2618),
        array("idpais" => 5, "idplan" => 2628, "sustituido_por" => 2628),
        array("idpais" => 5, "idplan" => 2626, "sustituido_por" => 2626),
        array("idpais" => 5, "idplan" => 1791, "sustituido_por" => 1791),
        array("idpais" => 5, "idplan" => 2030, "sustituido_por" => 2030),
        array("idpais" => 5, "idplan" => 2040, "sustituido_por" => 2040),
        array("idpais" => 5, "idplan" => 2291, "sustituido_por" => 2291),
        array("idpais" => 5, "idplan" => 2278, "sustituido_por" => 2278),
        array("idpais" => 5, "idplan" => 1811, "sustituido_por" => 1811),
        array("idpais" => 5, "idplan" => 1812, "sustituido_por" => 1812),
        array("idpais" => 5, "idplan" => 2292, "sustituido_por" => 2292),
        array("idpais" => 5, "idplan" => 2383, "sustituido_por" => 2383),
        array("idpais" => 5, "idplan" => 1817, "sustituido_por" => 1817),
        array("idpais" => 5, "idplan" => 2736, "sustituido_por" => 2736),
        array("idpais" => 5, "idplan" => 2761, "sustituido_por" => 2761),
        array("idpais" => 5, "idplan" => 2762, "sustituido_por" => 2762),
        array("idpais" => 5, "idplan" => 1796, "sustituido_por" => 1796),
        array("idpais" => 5, "idplan" => 2764, "sustituido_por" => 2764),
        array("idpais" => 5, "idplan" => 2763, "sustituido_por" => 2763),
        array("idpais" => 5, "idplan" => 2286, "sustituido_por" => 2286),
        array("idpais" => 5, "idplan" => 2293, "sustituido_por" => 2293),
        array("idpais" => 5, "idplan" => 2766, "sustituido_por" => 2766),
        array("idpais" => 5, "idplan" => 2765, "sustituido_por" => 2765),
        array("idpais" => 5, "idplan" => 2768, "sustituido_por" => 2768),
        array("idpais" => 5, "idplan" => 2767, "sustituido_por" => 2767),
        array("idpais" => 5, "idplan" => 2447, "sustituido_por" => 2447),
        array("idpais" => 5, "idplan" => 1787, "sustituido_por" => 1787),
        array("idpais" => 5, "idplan" => 1790, "sustituido_por" => 1790),
        array("idpais" => 5, "idplan" => 2027, "sustituido_por" => 2027),
        array("idpais" => 5, "idplan" => 2026, "sustituido_por" => 2026),
        array("idpais" => 5, "idplan" => 2025, "sustituido_por" => 2025),
        array("idpais" => 5, "idplan" => 2280, "sustituido_por" => 2280),
        array("idpais" => 5, "idplan" => 2032, "sustituido_por" => 2032),
        array("idpais" => 5, "idplan" => 2018, "sustituido_por" => 2018),
        array("idpais" => 5, "idplan" => 2363, "sustituido_por" => 2363),
        array("idpais" => 5, "idplan" => 2770, "sustituido_por" => 2770),
        array("idpais" => 5, "idplan" => 2769, "sustituido_por" => 2769),
        array("idpais" => 5, "idplan" => 660, "sustituido_por" => 660),
        array("idpais" => 5, "idplan" => 2287, "sustituido_por" => 2287),
        array("idpais" => 5, "idplan" => 2754, "sustituido_por" => 2754),
        array("idpais" => 5, "idplan" => 1802, "sustituido_por" => 1802),
        array("idpais" => 5, "idplan" => 1810, "sustituido_por" => 1810),
        array("idpais" => 5, "idplan" => 1805, "sustituido_por" => 1805),
        array("idpais" => 5, "idplan" => 1788, "sustituido_por" => 1788),
        array("idpais" => 5, "idplan" => 2045, "sustituido_por" => 2045),
        array("idpais" => 5, "idplan" => 2038, "sustituido_por" => 2038),
        array("idpais" => 5, "idplan" => 2755, "sustituido_por" => 2755),
        array("idpais" => 5, "idplan" => 2456, "sustituido_por" => 2456),
        array("idpais" => 5, "idplan" => 2285, "sustituido_por" => 2285),
        array("idpais" => 5, "idplan" => 2290, "sustituido_por" => 2290),
        array("idpais" => 5, "idplan" => 2294, "sustituido_por" => 2294),
        array("idpais" => 5, "idplan" => 2279, "sustituido_por" => 2279),
        array("idpais" => 5, "idplan" => 2031, "sustituido_por" => 2031),
        array("idpais" => 5, "idplan" => 1807, "sustituido_por" => 1807),
        array("idpais" => 5, "idplan" => 2039, "sustituido_por" => 2039),
        array("idpais" => 5, "idplan" => 2288, "sustituido_por" => 2288),
        array("idpais" => 5, "idplan" => 2289, "sustituido_por" => 2289),
        array("idpais" => 5, "idplan" => 1795, "sustituido_por" => 1795),
        array("idpais" => 5, "idplan" => 2017, "sustituido_por" => 2017),
        array("idpais" => 5, "idplan" => 2748, "sustituido_por" => 2748),
        array("idpais" => 5, "idplan" => 1521, "sustituido_por" => 1521),
        array("idpais" => 5, "idplan" => 2183, "sustituido_por" => 2183),
        array("idpais" => 5, "idplan" => 1077, "sustituido_por" => 1077),
        array("idpais" => 5, "idplan" => 1043, "sustituido_por" => 1043),
        array("idpais" => 5, "idplan" => 981, "sustituido_por" => 981),
        array("idpais" => 5, "idplan" => 1523, "sustituido_por" => 1523),
        array("idpais" => 5, "idplan" => 1524, "sustituido_por" => 1524),
        array("idpais" => 5, "idplan" => 1626, "sustituido_por" => 1626),
        array("idpais" => 5, "idplan" => 1132, "sustituido_por" => 1132),
        array("idpais" => 5, "idplan" => 2248, "sustituido_por" => 2248),
        array("idpais" => 5, "idplan" => 1522, "sustituido_por" => 1522),
        array("idpais" => 5, "idplan" => 1076, "sustituido_por" => 1076),
        array("idpais" => 5, "idplan" => 980, "sustituido_por" => 980),
        array("idpais" => 5, "idplan" => 1496, "sustituido_por" => 1496),
        array("idpais" => 5, "idplan" => 158, "sustituido_por" => 158),
        array("idpais" => 5, "idplan" => 156, "sustituido_por" => 156),
        array("idpais" => 5, "idplan" => 159, "sustituido_por" => 159),
        array("idpais" => 5, "idplan" => 162, "sustituido_por" => 162),
        array("idpais" => 5, "idplan" => 160, "sustituido_por" => 160),
        array("idpais" => 5, "idplan" => 157, "sustituido_por" => 157),
        array("idpais" => 5, "idplan" => 154, "sustituido_por" => 154),
        array("idpais" => 5, "idplan" => 2621, "sustituido_por" => 2621),
        array("idpais" => 5, "idplan" => 2622, "sustituido_por" => 2622),
        array("idpais" => 5, "idplan" => 2610, "sustituido_por" => 2610),
        array("idpais" => 5, "idplan" => 1615, "sustituido_por" => 1615),
        array("idpais" => 5, "idplan" => 2212, "sustituido_por" => 2212),
        array("idpais" => 5, "idplan" => 2214, "sustituido_por" => 2214),
        array("idpais" => 5, "idplan" => 1861, "sustituido_por" => 1861),
        array("idpais" => 5, "idplan" => 2216, "sustituido_por" => 2216),
        array("idpais" => 5, "idplan" => 2215, "sustituido_por" => 2215),
        array("idpais" => 5, "idplan" => 1864, "sustituido_por" => 1864),
        array("idpais" => 5, "idplan" => 2213, "sustituido_por" => 1361),
        array("idpais" => 5, "idplan" => 1361, "sustituido_por" => 1361),
        array("idpais" => 5, "idplan" => 1503, "sustituido_por" => 1503),
        array("idpais" => 5, "idplan" => 2419, "sustituido_por" => 2419),
        array("idpais" => 5, "idplan" => 754, "sustituido_por" => 754),
        array("idpais" => 5, "idplan" => 753, "sustituido_por" => 753),
        array("idpais" => 6, "idplan" => 2335, "sustituido_por" => 249),
        array("idpais" => 6, "idplan" => 2336, "sustituido_por" => 255),
        array("idpais" => 6, "idplan" => 2337, "sustituido_por" => 256),
        array("idpais" => 6, "idplan" => 2341, "sustituido_por" => 253),
        array("idpais" => 6, "idplan" => 2342, "sustituido_por" => 259),
        array("idpais" => 6, "idplan" => 2343, "sustituido_por" => 260),
        array("idpais" => 6, "idplan" => 2347, "sustituido_por" => 254),
        array("idpais" => 6, "idplan" => 2348, "sustituido_por" => 496),
        array("idpais" => 6, "idplan" => 2349, "sustituido_por" => 497),
        array("idpais" => 6, "idplan" => 2344, "sustituido_por" => 251),
        array("idpais" => 6, "idplan" => 2345, "sustituido_por" => 261),
        array("idpais" => 6, "idplan" => 2346, "sustituido_por" => 208),
        array("idpais" => 6, "idplan" => 2338, "sustituido_por" => 250),
        array("idpais" => 6, "idplan" => 2339, "sustituido_por" => 257),
        array("idpais" => 6, "idplan" => 2340, "sustituido_por" => 258),
        array("idpais" => 6, "idplan" => 2436, "sustituido_por" => 250),
        array("idpais" => 6, "idplan" => 2437, "sustituido_por" => 257),
        array("idpais" => 6, "idplan" => 2438, "sustituido_por" => 258),
        array("idpais" => 6, "idplan" => 2439, "sustituido_por" => 253),
        array("idpais" => 6, "idplan" => 2440, "sustituido_por" => 259),
        array("idpais" => 6, "idplan" => 2441, "sustituido_por" => 260),
        array("idpais" => 6, "idplan" => 2443, "sustituido_por" => 251),
        array("idpais" => 6, "idplan" => 2444, "sustituido_por" => 261),
        array("idpais" => 6, "idplan" => 2445, "sustituido_por" => 208),
        array("idpais" => 6, "idplan" => 2738, "sustituido_por" => 2738),
        array("idpais" => 6, "idplan" => 2493, "sustituido_por" => 2493),
        array("idpais" => 6, "idplan" => 2729, "sustituido_por" => 2729),
        array("idpais" => 6, "idplan" => 2546, "sustituido_por" => 2546),
        array("idpais" => 6, "idplan" => 2753, "sustituido_por" => 2753),
        array("idpais" => 6, "idplan" => 2410, "sustituido_por" => 2410),
        array("idpais" => 6, "idplan" => 2422, "sustituido_por" => 2422),
        array("idpais" => 6, "idplan" => 2420, "sustituido_por" => 2420),
        array("idpais" => 6, "idplan" => 2238, "sustituido_por" => 2238),
        array("idpais" => 6, "idplan" => 2354, "sustituido_por" => 492),
        array("idpais" => 6, "idplan" => 2355, "sustituido_por" => 493),
        array("idpais" => 6, "idplan" => 2350, "sustituido_por" => 245),
        array("idpais" => 6, "idplan" => 2352, "sustituido_por" => 247),
        array("idpais" => 6, "idplan" => 2353, "sustituido_por" => 248),
        array("idpais" => 6, "idplan" => 2351, "sustituido_por" => 246),
        array("idpais" => 6, "idplan" => 2570, "sustituido_por" => 248),
        array("idpais" => 6, "idplan" => 2569, "sustituido_por" => 247),
        array("idpais" => 6, "idplan" => 2331, "sustituido_por" => 275),
        array("idpais" => 6, "idplan" => 2330, "sustituido_por" => 267),
        array("idpais" => 6, "idplan" => 2332, "sustituido_por" => 270),
        array("idpais" => 6, "idplan" => 2334, "sustituido_por" => 273),
        array("idpais" => 6, "idplan" => 2333, "sustituido_por" => 272),
        array("idpais" => 6, "idplan" => 2329, "sustituido_por" => 269),
        array("idpais" => 6, "idplan" => 2435, "sustituido_por" => 2435),
        array("idpais" => 6, "idplan" => 2433, "sustituido_por" => 2433),
        array("idpais" => 6, "idplan" => 2434, "sustituido_por" => 2434),
        array("idpais" => 6, "idplan" => 2646, "sustituido_por" => 267),
        array("idpais" => 6, "idplan" => 2647, "sustituido_por" => 269),
        array("idpais" => 6, "idplan" => 2648, "sustituido_por" => 270),
        array("idpais" => 7, "idplan" => 1742, "sustituido_por" => 251),
        array("idpais" => 7, "idplan" => 1743, "sustituido_por" => 261),
        array("idpais" => 7, "idplan" => 1744, "sustituido_por" => 208),
        array("idpais" => 7, "idplan" => 1745, "sustituido_por" => 492),
        array("idpais" => 7, "idplan" => 1746, "sustituido_por" => 493),
        array("idpais" => 7, "idplan" => 1747, "sustituido_por" => 248),
        array("idpais" => 7, "idplan" => 1740, "sustituido_por" => 275),
        array("idpais" => 7, "idplan" => 1738, "sustituido_por" => 267),
        array("idpais" => 7, "idplan" => 1741, "sustituido_por" => 270),
        array("idpais" => 7, "idplan" => 1739, "sustituido_por" => 269),
        array("idpais" => 8, "idplan" => 2308, "sustituido_por" => 249),
        array("idpais" => 8, "idplan" => 2309, "sustituido_por" => 255),
        array("idpais" => 8, "idplan" => 2310, "sustituido_por" => 256),
        array("idpais" => 8, "idplan" => 2314, "sustituido_por" => 253),
        array("idpais" => 8, "idplan" => 2315, "sustituido_por" => 259),
        array("idpais" => 8, "idplan" => 2316, "sustituido_por" => 260),
        array("idpais" => 8, "idplan" => 2320, "sustituido_por" => 254),
        array("idpais" => 8, "idplan" => 2321, "sustituido_por" => 496),
        array("idpais" => 8, "idplan" => 2322, "sustituido_por" => 497),
        array("idpais" => 8, "idplan" => 2317, "sustituido_por" => 251),
        array("idpais" => 8, "idplan" => 2318, "sustituido_por" => 261),
        array("idpais" => 8, "idplan" => 2319, "sustituido_por" => 208),
        array("idpais" => 8, "idplan" => 2311, "sustituido_por" => 250),
        array("idpais" => 8, "idplan" => 2312, "sustituido_por" => 257),
        array("idpais" => 8, "idplan" => 2313, "sustituido_por" => 258),
        array("idpais" => 8, "idplan" => 2327, "sustituido_por" => 492),
        array("idpais" => 8, "idplan" => 2328, "sustituido_por" => 493),
        array("idpais" => 8, "idplan" => 2323, "sustituido_por" => 245),
        array("idpais" => 8, "idplan" => 2325, "sustituido_por" => 247),
        array("idpais" => 8, "idplan" => 2326, "sustituido_por" => 248),
        array("idpais" => 8, "idplan" => 2324, "sustituido_por" => 246),
        array("idpais" => 8, "idplan" => 2305, "sustituido_por" => 275),
        array("idpais" => 8, "idplan" => 2302, "sustituido_por" => 267),
        array("idpais" => 8, "idplan" => 2304, "sustituido_por" => 270),
        array("idpais" => 8, "idplan" => 2307, "sustituido_por" => 273),
        array("idpais" => 8, "idplan" => 2306, "sustituido_por" => 272),
        array("idpais" => 8, "idplan" => 2303, "sustituido_por" => 269),
        array("idpais" => 8, "idplan" => 265, "sustituido_por" => 852),
        array("idpais" => 9, "idplan" => 471, "sustituido_por" => 249),
        array("idpais" => 9, "idplan" => 476, "sustituido_por" => 255),
        array("idpais" => 9, "idplan" => 477, "sustituido_por" => 256),
        array("idpais" => 9, "idplan" => 474, "sustituido_por" => 253),
        array("idpais" => 9, "idplan" => 480, "sustituido_por" => 259),
        array("idpais" => 9, "idplan" => 481, "sustituido_por" => 260),
        array("idpais" => 9, "idplan" => 475, "sustituido_por" => 254),
        array("idpais" => 9, "idplan" => 494, "sustituido_por" => 496),
        array("idpais" => 9, "idplan" => 495, "sustituido_por" => 497),
        array("idpais" => 9, "idplan" => 473, "sustituido_por" => 251),
        array("idpais" => 9, "idplan" => 482, "sustituido_por" => 261),
        array("idpais" => 9, "idplan" => 470, "sustituido_por" => 208),
        array("idpais" => 9, "idplan" => 472, "sustituido_por" => 250),
        array("idpais" => 9, "idplan" => 478, "sustituido_por" => 257),
        array("idpais" => 9, "idplan" => 479, "sustituido_por" => 258),
        array("idpais" => 9, "idplan" => 2402, "sustituido_por" => 251),
        array("idpais" => 9, "idplan" => 2403, "sustituido_por" => 261),
        array("idpais" => 9, "idplan" => 2396, "sustituido_por" => 249),
        array("idpais" => 9, "idplan" => 2397, "sustituido_por" => 255),
        array("idpais" => 9, "idplan" => 2398, "sustituido_por" => 250),
        array("idpais" => 9, "idplan" => 2399, "sustituido_por" => 257),
        array("idpais" => 9, "idplan" => 2400, "sustituido_por" => 253),
        array("idpais" => 9, "idplan" => 2401, "sustituido_por" => 259),
        array("idpais" => 9, "idplan" => 2087, "sustituido_por" => 2087),
        array("idpais" => 9, "idplan" => 2362, "sustituido_por" => 2362),
        array("idpais" => 9, "idplan" => 2631, "sustituido_por" => 2631),
        array("idpais" => 9, "idplan" => 2245, "sustituido_por" => 2245),
        array("idpais" => 9, "idplan" => 490, "sustituido_por" => 492),
        array("idpais" => 9, "idplan" => 491, "sustituido_por" => 493),
        array("idpais" => 9, "idplan" => 2404, "sustituido_por" => 492),
        array("idpais" => 9, "idplan" => 2405, "sustituido_por" => 492),
        array("idpais" => 9, "idplan" => 466, "sustituido_por" => 245),
        array("idpais" => 9, "idplan" => 468, "sustituido_por" => 247),
        array("idpais" => 9, "idplan" => 469, "sustituido_por" => 248),
        array("idpais" => 9, "idplan" => 467, "sustituido_por" => 246),
        array("idpais" => 9, "idplan" => 2406, "sustituido_por" => 2406),
        array("idpais" => 9, "idplan" => 1599, "sustituido_por" => 852),
        array("idpais" => 9, "idplan" => 1600, "sustituido_por" => 852),
        array("idpais" => 9, "idplan" => 1878, "sustituido_por" => 267),
        array("idpais" => 9, "idplan" => 1879, "sustituido_por" => 269),
        array("idpais" => 9, "idplan" => 1880, "sustituido_por" => 270),
        array("idpais" => 9, "idplan" => 1038, "sustituido_por" => 267),
        array("idpais" => 9, "idplan" => 1041, "sustituido_por" => 267),
        array("idpais" => 9, "idplan" => 1107, "sustituido_por" => 267),
        array("idpais" => 9, "idplan" => 1040, "sustituido_por" => 269),
        array("idpais" => 9, "idplan" => 1042, "sustituido_por" => 269),
        array("idpais" => 9, "idplan" => 2385, "sustituido_por" => 258),
        array("idpais" => 9, "idplan" => 1700, "sustituido_por" => 272),
        array("idpais" => 9, "idplan" => 1704, "sustituido_por" => 251),
        array("idpais" => 9, "idplan" => 1697, "sustituido_por" => 267),
        array("idpais" => 9, "idplan" => 1701, "sustituido_por" => 249),
        array("idpais" => 9, "idplan" => 1698, "sustituido_por" => 269),
        array("idpais" => 9, "idplan" => 1702, "sustituido_por" => 250),
        array("idpais" => 9, "idplan" => 1699, "sustituido_por" => 270),
        array("idpais" => 9, "idplan" => 1703, "sustituido_por" => 253),
        array("idpais" => 9, "idplan" => 1705, "sustituido_por" => 852),
        array("idpais" => 9, "idplan" => 1039, "sustituido_por" => 267),
        array("idpais" => 9, "idplan" => 1826, "sustituido_por" => 267),
        array("idpais" => 9, "idplan" => 489, "sustituido_por" => 275),
        array("idpais" => 9, "idplan" => 484, "sustituido_por" => 267),
        array("idpais" => 9, "idplan" => 486, "sustituido_por" => 270),
        array("idpais" => 9, "idplan" => 488, "sustituido_por" => 273),
        array("idpais" => 9, "idplan" => 487, "sustituido_por" => 272),
        array("idpais" => 9, "idplan" => 485, "sustituido_por" => 269),
        array("idpais" => 9, "idplan" => 460, "sustituido_por" => 852),
        array("idpais" => 9, "idplan" => 483, "sustituido_por" => 2142),
        array("idpais" => 9, "idplan" => 2395, "sustituido_por" => 272),
        array("idpais" => 9, "idplan" => 2391, "sustituido_por" => 267),
        array("idpais" => 9, "idplan" => 2393, "sustituido_por" => 269),
        array("idpais" => 9, "idplan" => 2394, "sustituido_por" => 270),
        array("idpais" => 10, "idplan" => 1086, "sustituido_por" => 249),
        array("idpais" => 10, "idplan" => 1087, "sustituido_por" => 255),
        array("idpais" => 10, "idplan" => 1088, "sustituido_por" => 256),
        array("idpais" => 10, "idplan" => 1092, "sustituido_por" => 253),
        array("idpais" => 10, "idplan" => 1093, "sustituido_por" => 259),
        array("idpais" => 10, "idplan" => 1094, "sustituido_por" => 260),
        array("idpais" => 10, "idplan" => 1098, "sustituido_por" => 254),
        array("idpais" => 10, "idplan" => 1099, "sustituido_por" => 496),
        array("idpais" => 10, "idplan" => 1100, "sustituido_por" => 497),
        array("idpais" => 10, "idplan" => 1095, "sustituido_por" => 251),
        array("idpais" => 10, "idplan" => 1096, "sustituido_por" => 261),
        array("idpais" => 10, "idplan" => 1097, "sustituido_por" => 208),
        array("idpais" => 10, "idplan" => 1089, "sustituido_por" => 250),
        array("idpais" => 10, "idplan" => 1090, "sustituido_por" => 257),
        array("idpais" => 10, "idplan" => 1091, "sustituido_por" => 258),
        array("idpais" => 10, "idplan" => 2115, "sustituido_por" => 2115),
        array("idpais" => 10, "idplan" => 2295, "sustituido_por" => 2295),
        array("idpais" => 10, "idplan" => 1105, "sustituido_por" => 492),
        array("idpais" => 10, "idplan" => 1106, "sustituido_por" => 493),
        array("idpais" => 10, "idplan" => 1101, "sustituido_por" => 245),
        array("idpais" => 10, "idplan" => 1103, "sustituido_por" => 247),
        array("idpais" => 10, "idplan" => 1104, "sustituido_por" => 248),
        array("idpais" => 10, "idplan" => 1102, "sustituido_por" => 246),
        array("idpais" => 10, "idplan" => 1085, "sustituido_por" => 275),
        array("idpais" => 10, "idplan" => 1078, "sustituido_por" => 267),
        array("idpais" => 10, "idplan" => 1080, "sustituido_por" => 270),
        array("idpais" => 10, "idplan" => 1083, "sustituido_por" => 273),
        array("idpais" => 10, "idplan" => 1081, "sustituido_por" => 272),
        array("idpais" => 10, "idplan" => 1079, "sustituido_por" => 269),
        array("idpais" => 11, "idplan" => 103, "sustituido_por" => 103),
        array("idpais" => 11, "idplan" => 2745, "sustituido_por" => 2745),
        array("idpais" => 11, "idplan" => 102, "sustituido_por" => 102),
        array("idpais" => 11, "idplan" => 93, "sustituido_por" => 93),
        array("idpais" => 11, "idplan" => 109, "sustituido_por" => 109),
        array("idpais" => 11, "idplan" => 108, "sustituido_por" => 108),
        array("idpais" => 11, "idplan" => 95, "sustituido_por" => 95),
        array("idpais" => 11, "idplan" => 2516, "sustituido_por" => 2516),
        array("idpais" => 11, "idplan" => 2517, "sustituido_por" => 2517),
        array("idpais" => 11, "idplan" => 2518, "sustituido_por" => 2518),
        array("idpais" => 11, "idplan" => 2519, "sustituido_por" => 2519),
        array("idpais" => 11, "idplan" => 2520, "sustituido_por" => 2520),
        array("idpais" => 11, "idplan" => 2521, "sustituido_por" => 2521),
        array("idpais" => 11, "idplan" => 98, "sustituido_por" => 98),
        array("idpais" => 11, "idplan" => 140, "sustituido_por" => 140),
        array("idpais" => 11, "idplan" => 141, "sustituido_por" => 141),
        array("idpais" => 11, "idplan" => 112, "sustituido_por" => 112),
        array("idpais" => 11, "idplan" => 111, "sustituido_por" => 111),
        array("idpais" => 11, "idplan" => 96, "sustituido_por" => 96),
        array("idpais" => 11, "idplan" => 107, "sustituido_por" => 107),
        array("idpais" => 11, "idplan" => 106, "sustituido_por" => 106),
        array("idpais" => 11, "idplan" => 94, "sustituido_por" => 94),
        array("idpais" => 11, "idplan" => 2168, "sustituido_por" => 103),
        array("idpais" => 11, "idplan" => 2170, "sustituido_por" => 109),
        array("idpais" => 11, "idplan" => 2171, "sustituido_por" => 112),
        array("idpais" => 11, "idplan" => 2169, "sustituido_por" => 107),
        array("idpais" => 11, "idplan" => 2588, "sustituido_por" => 109),
        array("idpais" => 11, "idplan" => 2716, "sustituido_por" => 109),
        array("idpais" => 11, "idplan" => 2589, "sustituido_por" => 112),
        array("idpais" => 11, "idplan" => 2717, "sustituido_por" => 112),
        array("idpais" => 11, "idplan" => 2263, "sustituido_por" => 2263),
        array("idpais" => 11, "idplan" => 671, "sustituido_por" => 671),
        array("idpais" => 11, "idplan" => 1894, "sustituido_por" => 1894),
        array("idpais" => 11, "idplan" => 1895, "sustituido_por" => 1895),
        array("idpais" => 11, "idplan" => 1070, "sustituido_por" => 1070),
        array("idpais" => 11, "idplan" => 1071, "sustituido_por" => 1071),
        array("idpais" => 11, "idplan" => 2512, "sustituido_por" => 2512),
        array("idpais" => 11, "idplan" => 1865, "sustituido_por" => 1865),
        array("idpais" => 11, "idplan" => 2511, "sustituido_por" => 2511),
        array("idpais" => 11, "idplan" => 2462, "sustituido_por" => 2462),
        array("idpais" => 11, "idplan" => 2284, "sustituido_por" => 2421),
        array("idpais" => 11, "idplan" => 2421, "sustituido_por" => 2421),
        array("idpais" => 11, "idplan" => 2282, "sustituido_por" => 2282),
        array("idpais" => 11, "idplan" => 1981, "sustituido_por" => 1981),
        array("idpais" => 11, "idplan" => 2129, "sustituido_por" => 2129),
        array("idpais" => 11, "idplan" => 2572, "sustituido_por" => 2572),
        array("idpais" => 11, "idplan" => 2174, "sustituido_por" => 2174),
        array("idpais" => 11, "idplan" => 1180, "sustituido_por" => 1180),
        array("idpais" => 11, "idplan" => 2526, "sustituido_por" => 2526),
        array("idpais" => 11, "idplan" => 2722, "sustituido_por" => 2722),
        array("idpais" => 11, "idplan" => 2223, "sustituido_por" => 2223),
        array("idpais" => 11, "idplan" => 2423, "sustituido_por" => 2423),
        array("idpais" => 11, "idplan" => 2121, "sustituido_por" => 2121),
        array("idpais" => 11, "idplan" => 2510, "sustituido_por" => 2510),
        array("idpais" => 11, "idplan" => 968, "sustituido_por" => 968),
        array("idpais" => 11, "idplan" => 2127, "sustituido_por" => 2127),
        array("idpais" => 11, "idplan" => 2725, "sustituido_por" => 2725),
        array("idpais" => 11, "idplan" => 2528, "sustituido_por" => 2528),
        array("idpais" => 11, "idplan" => 2432, "sustituido_por" => 2432),
        array("idpais" => 11, "idplan" => 966, "sustituido_por" => 966),
        array("idpais" => 11, "idplan" => 2461, "sustituido_por" => 2461),
        array("idpais" => 11, "idplan" => 2460, "sustituido_por" => 2460),
        array("idpais" => 11, "idplan" => 2752, "sustituido_por" => 2752),
        array("idpais" => 11, "idplan" => 2551, "sustituido_por" => 2551),
        array("idpais" => 11, "idplan" => 2567, "sustituido_por" => 2567),
        array("idpais" => 11, "idplan" => 2155, "sustituido_por" => 2155),
        array("idpais" => 11, "idplan" => 2417, "sustituido_por" => 2417),
        array("idpais" => 11, "idplan" => 2568, "sustituido_por" => 2568),
        array("idpais" => 11, "idplan" => 2630, "sustituido_por" => 2630),
        array("idpais" => 11, "idplan" => 2609, "sustituido_por" => 2609),
        array("idpais" => 11, "idplan" => 1772, "sustituido_por" => 1772),
        array("idpais" => 11, "idplan" => 2524, "sustituido_por" => 2524),
        array("idpais" => 11, "idplan" => 2221, "sustituido_por" => 2221),
        array("idpais" => 11, "idplan" => 2425, "sustituido_por" => 2425),
        array("idpais" => 11, "idplan" => 1055, "sustituido_por" => 1055),
        array("idpais" => 11, "idplan" => 1781, "sustituido_por" => 1781),
        array("idpais" => 11, "idplan" => 1696, "sustituido_por" => 1696),
        array("idpais" => 11, "idplan" => 2451, "sustituido_por" => 2451),
        array("idpais" => 11, "idplan" => 2553, "sustituido_por" => 2553),
        array("idpais" => 11, "idplan" => 2283, "sustituido_por" => 2283),
        array("idpais" => 11, "idplan" => 2737, "sustituido_por" => 2737),
        array("idpais" => 11, "idplan" => 2724, "sustituido_por" => 2724),
        array("idpais" => 11, "idplan" => 2175, "sustituido_por" => 2175),
        array("idpais" => 11, "idplan" => 2264, "sustituido_por" => 2264),
        array("idpais" => 11, "idplan" => 2474, "sustituido_por" => 2474),
        array("idpais" => 11, "idplan" => 2475, "sustituido_por" => 2475),
        array("idpais" => 11, "idplan" => 2592, "sustituido_por" => 2592),
        array("idpais" => 11, "idplan" => 2505, "sustituido_por" => 2505),
        array("idpais" => 11, "idplan" => 2556, "sustituido_por" => 2556),
        array("idpais" => 11, "idplan" => 2629, "sustituido_por" => 2629),
        array("idpais" => 11, "idplan" => 2751, "sustituido_por" => 2751),
        array("idpais" => 11, "idplan" => 2503, "sustituido_por" => 2503),
        array("idpais" => 11, "idplan" => 2525, "sustituido_por" => 2525),
        array("idpais" => 11, "idplan" => 2210, "sustituido_por" => 2210),
        array("idpais" => 11, "idplan" => 1748, "sustituido_por" => 1748),
        array("idpais" => 11, "idplan" => 2450, "sustituido_por" => 2450),
        array("idpais" => 11, "idplan" => 2721, "sustituido_por" => 2721),
        array("idpais" => 11, "idplan" => 2771, "sustituido_por" => 2771),
        array("idpais" => 11, "idplan" => 1161, "sustituido_por" => 1161),
        array("idpais" => 11, "idplan" => 2555, "sustituido_por" => 2555),
        array("idpais" => 11, "idplan" => 2206, "sustituido_por" => 2206),
        array("idpais" => 11, "idplan" => 2392, "sustituido_por" => 2454),
        array("idpais" => 11, "idplan" => 2454, "sustituido_por" => 2454),
        array("idpais" => 11, "idplan" => 2758, "sustituido_por" => 2758),
        array("idpais" => 11, "idplan" => 2178, "sustituido_por" => 2178),
        array("idpais" => 11, "idplan" => 2470, "sustituido_por" => 2470),
        array("idpais" => 11, "idplan" => 2356, "sustituido_por" => 2356),
        array("idpais" => 11, "idplan" => 2118, "sustituido_por" => 2118),
        array("idpais" => 11, "idplan" => 2431, "sustituido_por" => 1514),
        array("idpais" => 11, "idplan" => 1514, "sustituido_por" => 1514),
        array("idpais" => 11, "idplan" => 1254, "sustituido_por" => 1254),
        array("idpais" => 11, "idplan" => 2409, "sustituido_por" => 2409),
        array("idpais" => 11, "idplan" => 2757, "sustituido_por" => 2757),
        array("idpais" => 11, "idplan" => 2207, "sustituido_por" => 2207),
        array("idpais" => 11, "idplan" => 2645, "sustituido_por" => 2645),
        array("idpais" => 11, "idplan" => 2644, "sustituido_por" => 2644),
        array("idpais" => 11, "idplan" => 2523, "sustituido_por" => 2523),
        array("idpais" => 11, "idplan" => 2452, "sustituido_por" => 2452),
        array("idpais" => 11, "idplan" => 2130, "sustituido_por" => 2130),
        array("idpais" => 11, "idplan" => 2596, "sustituido_por" => 2596),
        array("idpais" => 11, "idplan" => 2634, "sustituido_por" => 2634),
        array("idpais" => 11, "idplan" => 2759, "sustituido_por" => 2759),
        array("idpais" => 11, "idplan" => 2545, "sustituido_por" => 2545),
        array("idpais" => 11, "idplan" => 2747, "sustituido_por" => 2747),
        array("idpais" => 11, "idplan" => 2544, "sustituido_por" => 2544),
        array("idpais" => 11, "idplan" => 2497, "sustituido_por" => 2497),
        array("idpais" => 11, "idplan" => 2536, "sustituido_por" => 2536),
        array("idpais" => 11, "idplan" => 650, "sustituido_por" => 650),
        array("idpais" => 11, "idplan" => 679, "sustituido_por" => 679),
        array("idpais" => 11, "idplan" => 649, "sustituido_por" => 649),
        array("idpais" => 11, "idplan" => 680, "sustituido_por" => 680),
        array("idpais" => 11, "idplan" => 128, "sustituido_por" => 128),
        array("idpais" => 11, "idplan" => 1481, "sustituido_por" => 1481),
        array("idpais" => 11, "idplan" => 129, "sustituido_por" => 129),
        array("idpais" => 11, "idplan" => 665, "sustituido_por" => 665),
        array("idpais" => 11, "idplan" => 646, "sustituido_por" => 646),
        array("idpais" => 11, "idplan" => 2535, "sustituido_por" => 1481),
        array("idpais" => 11, "idplan" => 74, "sustituido_por" => 74),
        array("idpais" => 11, "idplan" => 113, "sustituido_por" => 113),
        array("idpais" => 11, "idplan" => 114, "sustituido_por" => 114),
        array("idpais" => 11, "idplan" => 117, "sustituido_por" => 117),
        array("idpais" => 11, "idplan" => 119, "sustituido_por" => 119),
        array("idpais" => 11, "idplan" => 116, "sustituido_por" => 116),
        array("idpais" => 11, "idplan" => 2601, "sustituido_por" => 2601),
        array("idpais" => 11, "idplan" => 2605, "sustituido_por" => 2605),
        array("idpais" => 11, "idplan" => 2533, "sustituido_por" => 2533),
        array("idpais" => 11, "idplan" => 2604, "sustituido_por" => 2604),
        array("idpais" => 11, "idplan" => 2534, "sustituido_por" => 2534),
        array("idpais" => 11, "idplan" => 2602, "sustituido_por" => 2602),
        array("idpais" => 11, "idplan" => 2563, "sustituido_por" => 2563),
        array("idpais" => 11, "idplan" => 2706, "sustituido_por" => 2706),
        array("idpais" => 11, "idplan" => 2590, "sustituido_por" => 2590),
        array("idpais" => 11, "idplan" => 2565, "sustituido_por" => 2565),
        array("idpais" => 11, "idplan" => 2718, "sustituido_por" => 2718),
        array("idpais" => 11, "idplan" => 2708, "sustituido_por" => 2708),
        array("idpais" => 11, "idplan" => 2591, "sustituido_por" => 2591),
        array("idpais" => 11, "idplan" => 2603, "sustituido_por" => 2603),
        array("idpais" => 11, "idplan" => 2566, "sustituido_por" => 2566),
        array("idpais" => 11, "idplan" => 2719, "sustituido_por" => 2719),
        array("idpais" => 11, "idplan" => 2709, "sustituido_por" => 2709),
        array("idpais" => 11, "idplan" => 2564, "sustituido_por" => 2564),
        array("idpais" => 11, "idplan" => 2707, "sustituido_por" => 2707),
        array("idpais" => 11, "idplan" => 1869, "sustituido_por" => 1869),
        array("idpais" => 11, "idplan" => 1870, "sustituido_por" => 1870),
        array("idpais" => 11, "idplan" => 1377, "sustituido_por" => 1377),
        array("idpais" => 11, "idplan" => 2713, "sustituido_por" => 2713),
        array("idpais" => 11, "idplan" => 2735, "sustituido_por" => 2735),
        array("idpais" => 11, "idplan" => 2711, "sustituido_por" => 2711),
        array("idpais" => 11, "idplan" => 2734, "sustituido_por" => 2734),
        array("idpais" => 11, "idplan" => 225, "sustituido_por" => 225),
        array("idpais" => 11, "idplan" => 555, "sustituido_por" => 555),
        array("idpais" => 11, "idplan" => 1753, "sustituido_por" => 1753),
        array("idpais" => 11, "idplan" => 1066, "sustituido_por" => 1066),
        array("idpais" => 11, "idplan" => 1065, "sustituido_por" => 1065),
        array("idpais" => 11, "idplan" => 1941, "sustituido_por" => 1941),
        array("idpais" => 11, "idplan" => 1942, "sustituido_por" => 1942),
        array("idpais" => 11, "idplan" => 1940, "sustituido_por" => 1940),
        array("idpais" => 11, "idplan" => 2476, "sustituido_por" => 2476),
        array("idpais" => 11, "idplan" => 1389, "sustituido_por" => 1389),
        array("idpais" => 11, "idplan" => 2472, "sustituido_por" => 2472),
        array("idpais" => 11, "idplan" => 2230, "sustituido_por" => 2230),
        array("idpais" => 11, "idplan" => 1400, "sustituido_por" => 1400),
        array("idpais" => 11, "idplan" => 1401, "sustituido_por" => 1401),
        array("idpais" => 11, "idplan" => 1851, "sustituido_por" => 1851),
        array("idpais" => 11, "idplan" => 2466, "sustituido_por" => 2466),
        array("idpais" => 11, "idplan" => 2133, "sustituido_por" => 2133),
        array("idpais" => 11, "idplan" => 1989, "sustituido_por" => 1989),
        array("idpais" => 11, "idplan" => 2181, "sustituido_por" => 2181),
        array("idpais" => 11, "idplan" => 2138, "sustituido_por" => 2138),
        array("idpais" => 11, "idplan" => 2595, "sustituido_por" => 2595),
        array("idpais" => 11, "idplan" => 1973, "sustituido_por" => 1973),
        array("idpais" => 11, "idplan" => 1775, "sustituido_por" => 1775),
        array("idpais" => 11, "idplan" => 1610, "sustituido_por" => 1610),
        array("idpais" => 11, "idplan" => 1404, "sustituido_por" => 1404),
        array("idpais" => 11, "idplan" => 2513, "sustituido_por" => 2513),
        array("idpais" => 11, "idplan" => 1761, "sustituido_por" => 1761),
        array("idpais" => 11, "idplan" => 1677, "sustituido_por" => 1677),
        array("idpais" => 11, "idplan" => 1760, "sustituido_por" => 1760),
        array("idpais" => 11, "idplan" => 1819, "sustituido_por" => 1819),
        array("idpais" => 11, "idplan" => 2204, "sustituido_por" => 2204),
        array("idpais" => 11, "idplan" => 2235, "sustituido_por" => 2235),
        array("idpais" => 11, "idplan" => 1277, "sustituido_por" => 1277),
        array("idpais" => 11, "idplan" => 1282, "sustituido_por" => 1282),
        array("idpais" => 11, "idplan" => 2247, "sustituido_por" => 2247),
        array("idpais" => 11, "idplan" => 2243, "sustituido_por" => 2243),
        array("idpais" => 11, "idplan" => 2208, "sustituido_por" => 2208),
        array("idpais" => 11, "idplan" => 1387, "sustituido_por" => 1387),
        array("idpais" => 11, "idplan" => 2473, "sustituido_por" => 2473),
        array("idpais" => 11, "idplan" => 2119, "sustituido_por" => 2119),
        array("idpais" => 11, "idplan" => 1412, "sustituido_por" => 1412),
        array("idpais" => 11, "idplan" => 1411, "sustituido_por" => 1411),
        array("idpais" => 11, "idplan" => 1853, "sustituido_por" => 1853),
        array("idpais" => 11, "idplan" => 2468, "sustituido_por" => 2468),
        array("idpais" => 11, "idplan" => 2375, "sustituido_por" => 2375),
        array("idpais" => 11, "idplan" => 2430, "sustituido_por" => 2430),
        array("idpais" => 11, "idplan" => 2140, "sustituido_por" => 2140),
        array("idpais" => 11, "idplan" => 1873, "sustituido_por" => 1873),
        array("idpais" => 11, "idplan" => 2124, "sustituido_por" => 2124),
        array("idpais" => 11, "idplan" => 2489, "sustituido_por" => 2489),
        array("idpais" => 11, "idplan" => 2021, "sustituido_por" => 2021),
        array("idpais" => 11, "idplan" => 1766, "sustituido_por" => 1766),
        array("idpais" => 11, "idplan" => 2549, "sustituido_por" => 2021),
        array("idpais" => 11, "idplan" => 1452, "sustituido_por" => 1452),
        array("idpais" => 11, "idplan" => 1414, "sustituido_por" => 1414),
        array("idpais" => 11, "idplan" => 1536, "sustituido_por" => 1536),
        array("idpais" => 11, "idplan" => 1537, "sustituido_por" => 1537),
        array("idpais" => 11, "idplan" => 1538, "sustituido_por" => 1538),
        array("idpais" => 11, "idplan" => 1258, "sustituido_por" => 1258),
        array("idpais" => 11, "idplan" => 1259, "sustituido_por" => 1259),
        array("idpais" => 11, "idplan" => 1260, "sustituido_por" => 1260),
        array("idpais" => 11, "idplan" => 1261, "sustituido_por" => 1261),
        array("idpais" => 11, "idplan" => 2042, "sustituido_por" => 2042),
        array("idpais" => 11, "idplan" => 2237, "sustituido_por" => 2516),
        array("idpais" => 11, "idplan" => 2471, "sustituido_por" => 2471),
        array("idpais" => 11, "idplan" => 2041, "sustituido_por" => 2041),
        array("idpais" => 11, "idplan" => 1256, "sustituido_por" => 1256),
        array("idpais" => 11, "idplan" => 2527, "sustituido_por" => 2224),
        array("idpais" => 11, "idplan" => 2128, "sustituido_por" => 2128),
        array("idpais" => 11, "idplan" => 1492, "sustituido_por" => 1492),
        array("idpais" => 11, "idplan" => 1658, "sustituido_por" => 1658),
        array("idpais" => 11, "idplan" => 1980, "sustituido_por" => 1980),
        array("idpais" => 11, "idplan" => 1858, "sustituido_por" => 1858),
        array("idpais" => 11, "idplan" => 1859, "sustituido_por" => 1859),
        array("idpais" => 11, "idplan" => 1359, "sustituido_por" => 1359),
        array("idpais" => 11, "idplan" => 1125, "sustituido_por" => 1125),
        array("idpais" => 11, "idplan" => 1358, "sustituido_por" => 1358),
        array("idpais" => 11, "idplan" => 2772, "sustituido_por" => 2772),
        array("idpais" => 11, "idplan" => 2749, "sustituido_por" => 2749),
        array("idpais" => 11, "idplan" => 1979, "sustituido_por" => 1979),
        array("idpais" => 11, "idplan" => 2492, "sustituido_por" => 2492),
        array("idpais" => 11, "idplan" => 2260, "sustituido_por" => 2260),
        array("idpais" => 11, "idplan" => 2205, "sustituido_por" => 2205),
        array("idpais" => 11, "idplan" => 2236, "sustituido_por" => 2236),
        array("idpais" => 11, "idplan" => 2209, "sustituido_por" => 2209),
        array("idpais" => 11, "idplan" => 1388, "sustituido_por" => 1388),
        array("idpais" => 11, "idplan" => 2576, "sustituido_por" => 2576),
        array("idpais" => 11, "idplan" => 2547, "sustituido_por" => 2547),
        array("idpais" => 11, "idplan" => 2619, "sustituido_por" => 2619),
        array("idpais" => 11, "idplan" => 2386, "sustituido_por" => 2386),
        array("idpais" => 11, "idplan" => 2231, "sustituido_por" => 2231),
        array("idpais" => 11, "idplan" => 1416, "sustituido_por" => 1416),
        array("idpais" => 11, "idplan" => 1855, "sustituido_por" => 1855),
        array("idpais" => 11, "idplan" => 2141, "sustituido_por" => 2141),
        array("idpais" => 11, "idplan" => 2125, "sustituido_por" => 2125),
        array("idpais" => 11, "idplan" => 2023, "sustituido_por" => 2023),
        array("idpais" => 11, "idplan" => 2571, "sustituido_por" => 2571),
        array("idpais" => 11, "idplan" => 2550, "sustituido_por" => 2550),
        array("idpais" => 11, "idplan" => 2082, "sustituido_por" => 2082),
        array("idpais" => 11, "idplan" => 2083, "sustituido_por" => 2083),
        array("idpais" => 11, "idplan" => 2075, "sustituido_por" => 2075),
        array("idpais" => 11, "idplan" => 2281, "sustituido_por" => 2281),
        array("idpais" => 11, "idplan" => 2256, "sustituido_por" => 2256),
        array("idpais" => 11, "idplan" => 1386, "sustituido_por" => 1386),
        array("idpais" => 11, "idplan" => 2259, "sustituido_por" => 2259),
        array("idpais" => 11, "idplan" => 2255, "sustituido_por" => 2255),
        array("idpais" => 11, "idplan" => 1820, "sustituido_por" => 1820),
        array("idpais" => 11, "idplan" => 1406, "sustituido_por" => 1406),
        array("idpais" => 11, "idplan" => 1852, "sustituido_por" => 1852),
        array("idpais" => 11, "idplan" => 2467, "sustituido_por" => 2467),
        array("idpais" => 11, "idplan" => 2429, "sustituido_por" => 2429),
        array("idpais" => 11, "idplan" => 2139, "sustituido_por" => 2139),
        array("idpais" => 11, "idplan" => 1872, "sustituido_por" => 1872),
        array("idpais" => 11, "idplan" => 2123, "sustituido_por" => 2123),
        array("idpais" => 11, "idplan" => 2144, "sustituido_por" => 2144),
        array("idpais" => 11, "idplan" => 2022, "sustituido_por" => 2022),
        array("idpais" => 11, "idplan" => 2020, "sustituido_por" => 2020),
        array("idpais" => 11, "idplan" => 670, "sustituido_por" => 670),
        array("idpais" => 11, "idplan" => 1205, "sustituido_por" => 1205),
        array("idpais" => 11, "idplan" => 1974, "sustituido_por" => 1974),
        array("idpais" => 11, "idplan" => 1776, "sustituido_por" => 1776),
        array("idpais" => 11, "idplan" => 2548, "sustituido_por" => 2548),
        array("idpais" => 11, "idplan" => 1144, "sustituido_por" => 1144),
        array("idpais" => 11, "idplan" => 2469, "sustituido_por" => 2469),
        array("idpais" => 11, "idplan" => 1751, "sustituido_por" => 1751),
        array("idpais" => 11, "idplan" => 2374, "sustituido_por" => 2374),
        array("idpais" => 11, "idplan" => 1530, "sustituido_por" => 1530),
        array("idpais" => 11, "idplan" => 1063, "sustituido_por" => 1063),
        array("idpais" => 11, "idplan" => 1130, "sustituido_por" => 1130),
        array("idpais" => 11, "idplan" => 1944, "sustituido_por" => 1944),
        array("idpais" => 11, "idplan" => 1421, "sustituido_por" => 1421),
        array("idpais" => 11, "idplan" => 2176, "sustituido_por" => 2176),
        array("idpais" => 11, "idplan" => 1914, "sustituido_por" => 1914),
        array("idpais" => 11, "idplan" => 2211, "sustituido_por" => 2211),
        array("idpais" => 11, "idplan" => 1204, "sustituido_por" => 1204),
        array("idpais" => 11, "idplan" => 1749, "sustituido_por" => 1749),
        array("idpais" => 11, "idplan" => 1293, "sustituido_por" => 1293),
        array("idpais" => 11, "idplan" => 1930, "sustituido_por" => 1930),
        array("idpais" => 11, "idplan" => 1927, "sustituido_por" => 1927),
        array("idpais" => 11, "idplan" => 1924, "sustituido_por" => 1924),
        array("idpais" => 11, "idplan" => 1932, "sustituido_por" => 1932),
        array("idpais" => 11, "idplan" => 1925, "sustituido_por" => 1925),
        array("idpais" => 11, "idplan" => 1931, "sustituido_por" => 1931),
        array("idpais" => 11, "idplan" => 1926, "sustituido_por" => 1926),
        array("idpais" => 11, "idplan" => 1929, "sustituido_por" => 1929),
        array("idpais" => 11, "idplan" => 1928, "sustituido_por" => 1928),
        array("idpais" => 11, "idplan" => 1424, "sustituido_por" => 1424),
        array("idpais" => 11, "idplan" => 2229, "sustituido_por" => 2229),
        array("idpais" => 11, "idplan" => 1164, "sustituido_por" => 1164),
        array("idpais" => 11, "idplan" => 2428, "sustituido_por" => 2428),
        array("idpais" => 11, "idplan" => 1207, "sustituido_por" => 1207),
        array("idpais" => 11, "idplan" => 1988, "sustituido_por" => 1988),
        array("idpais" => 11, "idplan" => 2180, "sustituido_por" => 2180),
        array("idpais" => 11, "idplan" => 2137, "sustituido_por" => 2137),
        array("idpais" => 11, "idplan" => 2143, "sustituido_por" => 2143),
        array("idpais" => 11, "idplan" => 1291, "sustituido_por" => 1291),
        array("idpais" => 11, "idplan" => 669, "sustituido_por" => 669),
        array("idpais" => 11, "idplan" => 1972, "sustituido_por" => 1972),
        array("idpais" => 11, "idplan" => 1774, "sustituido_por" => 1774),
        array("idpais" => 11, "idplan" => 1451, "sustituido_por" => 1451),
        array("idpais" => 11, "idplan" => 1752, "sustituido_por" => 1752),
        array("idpais" => 11, "idplan" => 1399, "sustituido_por" => 1399),
        array("idpais" => 11, "idplan" => 2043, "sustituido_por" => 2043),
        array("idpais" => 11, "idplan" => 1495, "sustituido_por" => 1495),
        array("idpais" => 11, "idplan" => 1854, "sustituido_por" => 1854),
        array("idpais" => 11, "idplan" => 2076, "sustituido_por" => 2076),
        array("idpais" => 11, "idplan" => 1216, "sustituido_por" => 1216),
        array("idpais" => 11, "idplan" => 1644, "sustituido_por" => 1644),
        array("idpais" => 11, "idplan" => 1352, "sustituido_por" => 1352),
        array("idpais" => 11, "idplan" => 1910, "sustituido_por" => 1910),
        array("idpais" => 11, "idplan" => 2490, "sustituido_por" => 2490),
        array("idpais" => 11, "idplan" => 2173, "sustituido_por" => 2173),
        array("idpais" => 11, "idplan" => 2506, "sustituido_por" => 103),
        array("idpais" => 11, "idplan" => 2509, "sustituido_por" => 103),
        array("idpais" => 11, "idplan" => 2504, "sustituido_por" => 107),
        array("idpais" => 11, "idplan" => 2508, "sustituido_por" => 107),
        array("idpais" => 11, "idplan" => 2498, "sustituido_por" => 103),
        array("idpais" => 11, "idplan" => 1645, "sustituido_por" => 1644),
        array("idpais" => 11, "idplan" => 1646, "sustituido_por" => 1644),
        array("idpais" => 11, "idplan" => 123, "sustituido_por" => 123),
        array("idpais" => 11, "idplan" => 56, "sustituido_por" => 56),
        array("idpais" => 11, "idplan" => 88, "sustituido_por" => 88),
        array("idpais" => 11, "idplan" => 2514, "sustituido_por" => 2514),
        array("idpais" => 11, "idplan" => 2515, "sustituido_por" => 2515),
        array("idpais" => 11, "idplan" => 92, "sustituido_por" => 92),
        array("idpais" => 11, "idplan" => 89, "sustituido_por" => 89),
        array("idpais" => 11, "idplan" => 87, "sustituido_por" => 87),
        array("idpais" => 11, "idplan" => 2162, "sustituido_por" => 2162),
        array("idpais" => 11, "idplan" => 2597, "sustituido_por" => 2597),
        array("idpais" => 11, "idplan" => 2164, "sustituido_por" => 2164),
        array("idpais" => 11, "idplan" => 2600, "sustituido_por" => 2600),
        array("idpais" => 11, "idplan" => 2531, "sustituido_por" => 2531),
        array("idpais" => 11, "idplan" => 2165, "sustituido_por" => 2165),
        array("idpais" => 11, "idplan" => 2599, "sustituido_por" => 2599),
        array("idpais" => 11, "idplan" => 2532, "sustituido_por" => 2532),
        array("idpais" => 11, "idplan" => 2163, "sustituido_por" => 2163),
        array("idpais" => 11, "idplan" => 2598, "sustituido_por" => 2598),
        array("idpais" => 11, "idplan" => 2530, "sustituido_por" => 2530),
        array("idpais" => 11, "idplan" => 21, "sustituido_por" => 21),
        array("idpais" => 11, "idplan" => 2559, "sustituido_por" => 2559),
        array("idpais" => 11, "idplan" => 2557, "sustituido_por" => 2557),
        array("idpais" => 11, "idplan" => 2586, "sustituido_por" => 2586),
        array("idpais" => 11, "idplan" => 2560, "sustituido_por" => 2560),
        array("idpais" => 11, "idplan" => 2714, "sustituido_por" => 2714),
        array("idpais" => 11, "idplan" => 2732, "sustituido_por" => 2732),
        array("idpais" => 11, "idplan" => 2562, "sustituido_por" => 2562),
        array("idpais" => 11, "idplan" => 2587, "sustituido_por" => 2587),
        array("idpais" => 11, "idplan" => 2561, "sustituido_por" => 2561),
        array("idpais" => 11, "idplan" => 2715, "sustituido_por" => 2715),
        array("idpais" => 11, "idplan" => 2733, "sustituido_por" => 2733),
        array("idpais" => 11, "idplan" => 2558, "sustituido_por" => 2558),
        array("idpais" => 11, "idplan" => 2730, "sustituido_por" => 2730),
        array("idpais" => 11, "idplan" => 2731, "sustituido_por" => 2731),
        array("idpais" => 11, "idplan" => 2583, "sustituido_por" => 2583),
        array("idpais" => 11, "idplan" => 558, "sustituido_por" => 558),
        array("idpais" => 11, "idplan" => 2463, "sustituido_por" => 2463),
        array("idpais" => 11, "idplan" => 2465, "sustituido_por" => 2465),
        array("idpais" => 11, "idplan" => 1863, "sustituido_por" => 1863),
        array("idpais" => 11, "idplan" => 1862, "sustituido_por" => 1862),
        array("idpais" => 11, "idplan" => 672, "sustituido_por" => 672),
        array("idpais" => 12, "idplan" => 991, "sustituido_por" => 249),
        array("idpais" => 12, "idplan" => 992, "sustituido_por" => 255),
        array("idpais" => 12, "idplan" => 993, "sustituido_por" => 256),
        array("idpais" => 12, "idplan" => 997, "sustituido_por" => 253),
        array("idpais" => 12, "idplan" => 998, "sustituido_por" => 259),
        array("idpais" => 12, "idplan" => 999, "sustituido_por" => 260),
        array("idpais" => 12, "idplan" => 1003, "sustituido_por" => 254),
        array("idpais" => 12, "idplan" => 1004, "sustituido_por" => 496),
        array("idpais" => 12, "idplan" => 1005, "sustituido_por" => 497),
        array("idpais" => 12, "idplan" => 1000, "sustituido_por" => 251),
        array("idpais" => 12, "idplan" => 1001, "sustituido_por" => 261),
        array("idpais" => 12, "idplan" => 1002, "sustituido_por" => 208),
        array("idpais" => 12, "idplan" => 994, "sustituido_por" => 250),
        array("idpais" => 12, "idplan" => 995, "sustituido_por" => 257),
        array("idpais" => 12, "idplan" => 996, "sustituido_por" => 258),
        array("idpais" => 12, "idplan" => 1010, "sustituido_por" => 492),
        array("idpais" => 12, "idplan" => 1011, "sustituido_por" => 493),
        array("idpais" => 12, "idplan" => 1006, "sustituido_por" => 245),
        array("idpais" => 12, "idplan" => 1008, "sustituido_por" => 247),
        array("idpais" => 12, "idplan" => 1009, "sustituido_por" => 248),
        array("idpais" => 12, "idplan" => 1007, "sustituido_por" => 246),
        array("idpais" => 12, "idplan" => 986, "sustituido_por" => 275),
        array("idpais" => 12, "idplan" => 984, "sustituido_por" => 267),
        array("idpais" => 12, "idplan" => 987, "sustituido_por" => 270),
        array("idpais" => 12, "idplan" => 989, "sustituido_por" => 273),
        array("idpais" => 12, "idplan" => 988, "sustituido_por" => 272),
        array("idpais" => 12, "idplan" => 985, "sustituido_por" => 269),
        array("idpais" => 12, "idplan" => 983, "sustituido_por" => 852),
        array("idpais" => 12, "idplan" => 990, "sustituido_por" => 2142),
        array("idpais" => 13, "idplan" => 739, "sustituido_por" => 249),
        array("idpais" => 13, "idplan" => 740, "sustituido_por" => 255),
        array("idpais" => 13, "idplan" => 741, "sustituido_por" => 256),
        array("idpais" => 13, "idplan" => 745, "sustituido_por" => 253),
        array("idpais" => 13, "idplan" => 746, "sustituido_por" => 259),
        array("idpais" => 13, "idplan" => 747, "sustituido_por" => 260),
        array("idpais" => 13, "idplan" => 1243, "sustituido_por" => 254),
        array("idpais" => 13, "idplan" => 1244, "sustituido_por" => 496),
        array("idpais" => 13, "idplan" => 1246, "sustituido_por" => 497),
        array("idpais" => 13, "idplan" => 748, "sustituido_por" => 251),
        array("idpais" => 13, "idplan" => 1239, "sustituido_por" => 261),
        array("idpais" => 13, "idplan" => 1241, "sustituido_por" => 208),
        array("idpais" => 13, "idplan" => 742, "sustituido_por" => 250),
        array("idpais" => 13, "idplan" => 743, "sustituido_por" => 257),
        array("idpais" => 13, "idplan" => 744, "sustituido_por" => 258),
        array("idpais" => 13, "idplan" => 2388, "sustituido_por" => 2388),
        array("idpais" => 13, "idplan" => 2222, "sustituido_por" => 2222),
        array("idpais" => 13, "idplan" => 2253, "sustituido_por" => 2253),
        array("idpais" => 13, "idplan" => 2608, "sustituido_por" => 2184),
        array("idpais" => 13, "idplan" => 2184, "sustituido_por" => 2266),
        array("idpais" => 13, "idplan" => 2266, "sustituido_por" => 1383),
        array("idpais" => 13, "idplan" => 1383, "sustituido_por" => 1381),
        array("idpais" => 13, "idplan" => 1219, "sustituido_por" => 1219),
        array("idpais" => 13, "idplan" => 1218, "sustituido_por" => 1218),
        array("idpais" => 13, "idplan" => 1026, "sustituido_por" => 492),
        array("idpais" => 13, "idplan" => 1027, "sustituido_por" => 493),
        array("idpais" => 13, "idplan" => 1022, "sustituido_por" => 245),
        array("idpais" => 13, "idplan" => 1024, "sustituido_por" => 247),
        array("idpais" => 13, "idplan" => 1025, "sustituido_por" => 248),
        array("idpais" => 13, "idplan" => 1023, "sustituido_por" => 246),
        array("idpais" => 13, "idplan" => 1455, "sustituido_por" => 1455),
        array("idpais" => 13, "idplan" => 1957, "sustituido_por" => 1957),
        array("idpais" => 13, "idplan" => 1950, "sustituido_por" => 1950),
        array("idpais" => 13, "idplan" => 1954, "sustituido_por" => 1954),
        array("idpais" => 13, "idplan" => 2268, "sustituido_por" => 2268),
        array("idpais" => 13, "idplan" => 2270, "sustituido_por" => 2270),
        array("idpais" => 13, "idplan" => 2271, "sustituido_por" => 2271),
        array("idpais" => 13, "idplan" => 2272, "sustituido_por" => 2272),
        array("idpais" => 13, "idplan" => 1454, "sustituido_por" => 1454),
        array("idpais" => 13, "idplan" => 2273, "sustituido_por" => 2273),
        array("idpais" => 13, "idplan" => 1955, "sustituido_por" => 1955),
        array("idpais" => 13, "idplan" => 1951, "sustituido_por" => 1951),
        array("idpais" => 13, "idplan" => 1952, "sustituido_por" => 1952),
        array("idpais" => 13, "idplan" => 1956, "sustituido_por" => 1956),
        array("idpais" => 13, "idplan" => 1949, "sustituido_por" => 1949),
        array("idpais" => 13, "idplan" => 1953, "sustituido_por" => 1953),
        array("idpais" => 13, "idplan" => 2269, "sustituido_por" => 2269),
        array("idpais" => 13, "idplan" => 2267, "sustituido_por" => 2267),
        array("idpais" => 13, "idplan" => 1976, "sustituido_por" => 1976),
        array("idpais" => 13, "idplan" => 734, "sustituido_por" => 275),
        array("idpais" => 13, "idplan" => 1172, "sustituido_por" => 267),
        array("idpais" => 13, "idplan" => 735, "sustituido_por" => 270),
        array("idpais" => 13, "idplan" => 738, "sustituido_por" => 273),
        array("idpais" => 13, "idplan" => 736, "sustituido_por" => 272),
        array("idpais" => 13, "idplan" => 733, "sustituido_por" => 269),
        array("idpais" => 13, "idplan" => 737, "sustituido_por" => 2142),
        array("idpais" => 13, "idplan" => 731, "sustituido_por" => 852),
        array("idpais" => 13, "idplan" => 1221, "sustituido_por" => 1221),
        array("idpais" => 13, "idplan" => 1220, "sustituido_por" => 1220),
        array("idpais" => 14, "idplan" => 1015, "sustituido_por" => 275),
        array("idpais" => 14, "idplan" => 1013, "sustituido_por" => 267),
        array("idpais" => 14, "idplan" => 1016, "sustituido_por" => 270),
        array("idpais" => 14, "idplan" => 1019, "sustituido_por" => 273),
        array("idpais" => 14, "idplan" => 1017, "sustituido_por" => 272),
        array("idpais" => 14, "idplan" => 1014, "sustituido_por" => 269),
        array("idpais" => 14, "idplan" => 1012, "sustituido_por" => 852),
        array("idpais" => 14, "idplan" => 1018, "sustituido_por" => 2142),
        array("idpais" => 15, "idplan" => 863, "sustituido_por" => 249),
        array("idpais" => 15, "idplan" => 864, "sustituido_por" => 255),
        array("idpais" => 15, "idplan" => 865, "sustituido_por" => 256),
        array("idpais" => 15, "idplan" => 869, "sustituido_por" => 253),
        array("idpais" => 15, "idplan" => 870, "sustituido_por" => 259),
        array("idpais" => 15, "idplan" => 871, "sustituido_por" => 260),
        array("idpais" => 15, "idplan" => 875, "sustituido_por" => 254),
        array("idpais" => 15, "idplan" => 876, "sustituido_por" => 496),
        array("idpais" => 15, "idplan" => 877, "sustituido_por" => 497),
        array("idpais" => 15, "idplan" => 872, "sustituido_por" => 251),
        array("idpais" => 15, "idplan" => 873, "sustituido_por" => 261),
        array("idpais" => 15, "idplan" => 874, "sustituido_por" => 208),
        array("idpais" => 15, "idplan" => 866, "sustituido_por" => 250),
        array("idpais" => 15, "idplan" => 867, "sustituido_por" => 257),
        array("idpais" => 15, "idplan" => 868, "sustituido_por" => 258),
        array("idpais" => 15, "idplan" => 2179, "sustituido_por" => 2179),
        array("idpais" => 15, "idplan" => 2246, "sustituido_por" => 2246),
        array("idpais" => 15, "idplan" => 2760, "sustituido_por" => 2760),
        array("idpais" => 15, "idplan" => 2554, "sustituido_por" => 2554),
        array("idpais" => 15, "idplan" => 882, "sustituido_por" => 492),
        array("idpais" => 15, "idplan" => 883, "sustituido_por" => 493),
        array("idpais" => 15, "idplan" => 878, "sustituido_por" => 245),
        array("idpais" => 15, "idplan" => 880, "sustituido_por" => 247),
        array("idpais" => 15, "idplan" => 881, "sustituido_por" => 248),
        array("idpais" => 15, "idplan" => 879, "sustituido_por" => 246),
        array("idpais" => 15, "idplan" => 858, "sustituido_por" => 275),
        array("idpais" => 15, "idplan" => 856, "sustituido_por" => 267),
        array("idpais" => 15, "idplan" => 859, "sustituido_por" => 270),
        array("idpais" => 15, "idplan" => 862, "sustituido_por" => 273),
        array("idpais" => 15, "idplan" => 860, "sustituido_por" => 272),
        array("idpais" => 15, "idplan" => 857, "sustituido_por" => 269),
        array("idpais" => 17, "idplan" => 908, "sustituido_por" => 249),
        array("idpais" => 17, "idplan" => 909, "sustituido_por" => 255),
        array("idpais" => 17, "idplan" => 910, "sustituido_por" => 256),
        array("idpais" => 17, "idplan" => 914, "sustituido_por" => 253),
        array("idpais" => 17, "idplan" => 915, "sustituido_por" => 259),
        array("idpais" => 17, "idplan" => 916, "sustituido_por" => 260),
        array("idpais" => 17, "idplan" => 920, "sustituido_por" => 254),
        array("idpais" => 17, "idplan" => 927, "sustituido_por" => 496),
        array("idpais" => 17, "idplan" => 928, "sustituido_por" => 497),
        array("idpais" => 17, "idplan" => 917, "sustituido_por" => 251),
        array("idpais" => 17, "idplan" => 918, "sustituido_por" => 261),
        array("idpais" => 17, "idplan" => 919, "sustituido_por" => 208),
        array("idpais" => 17, "idplan" => 911, "sustituido_por" => 250),
        array("idpais" => 17, "idplan" => 912, "sustituido_por" => 257),
        array("idpais" => 17, "idplan" => 913, "sustituido_por" => 258),
        array("idpais" => 17, "idplan" => 1723, "sustituido_por" => 253),
        array("idpais" => 17, "idplan" => 1724, "sustituido_por" => 259),
        array("idpais" => 17, "idplan" => 1725, "sustituido_por" => 260),
        array("idpais" => 17, "idplan" => 1726, "sustituido_por" => 253),
        array("idpais" => 17, "idplan" => 1727, "sustituido_por" => 259),
        array("idpais" => 17, "idplan" => 1728, "sustituido_por" => 260),
        array("idpais" => 17, "idplan" => 1720, "sustituido_por" => 250),
        array("idpais" => 17, "idplan" => 1721, "sustituido_por" => 257),
        array("idpais" => 17, "idplan" => 1722, "sustituido_por" => 258),
        array("idpais" => 17, "idplan" => 1729, "sustituido_por" => 251),
        array("idpais" => 17, "idplan" => 1730, "sustituido_por" => 261),
        array("idpais" => 17, "idplan" => 1731, "sustituido_por" => 208),
        array("idpais" => 17, "idplan" => 1486, "sustituido_por" => 2514),
        array("idpais" => 17, "idplan" => 925, "sustituido_por" => 492),
        array("idpais" => 17, "idplan" => 926, "sustituido_por" => 493),
        array("idpais" => 17, "idplan" => 1737, "sustituido_por" => 493),
        array("idpais" => 17, "idplan" => 1736, "sustituido_por" => 492),
        array("idpais" => 17, "idplan" => 921, "sustituido_por" => 245),
        array("idpais" => 17, "idplan" => 923, "sustituido_por" => 247),
        array("idpais" => 17, "idplan" => 924, "sustituido_por" => 248),
        array("idpais" => 17, "idplan" => 922, "sustituido_por" => 246),
        array("idpais" => 17, "idplan" => 2370, "sustituido_por" => 245),
        array("idpais" => 17, "idplan" => 1732, "sustituido_por" => 245),
        array("idpais" => 17, "idplan" => 2372, "sustituido_por" => 247),
        array("idpais" => 17, "idplan" => 1734, "sustituido_por" => 247),
        array("idpais" => 17, "idplan" => 1735, "sustituido_por" => 248),
        array("idpais" => 17, "idplan" => 2373, "sustituido_por" => 248),
        array("idpais" => 17, "idplan" => 2371, "sustituido_por" => 246),
        array("idpais" => 17, "idplan" => 1733, "sustituido_por" => 246),
        array("idpais" => 17, "idplan" => 2459, "sustituido_por" => 852),
        array("idpais" => 17, "idplan" => 2458, "sustituido_por" => 852),
        array("idpais" => 17, "idplan" => 1173, "sustituido_por" => 245),
        array("idpais" => 17, "idplan" => 903, "sustituido_por" => 275),
        array("idpais" => 17, "idplan" => 901, "sustituido_por" => 267),
        array("idpais" => 17, "idplan" => 904, "sustituido_por" => 270),
        array("idpais" => 17, "idplan" => 907, "sustituido_por" => 273),
        array("idpais" => 17, "idplan" => 905, "sustituido_por" => 272),
        array("idpais" => 17, "idplan" => 902, "sustituido_por" => 269),
        array("idpais" => 17, "idplan" => 2358, "sustituido_por" => 267),
        array("idpais" => 17, "idplan" => 2360, "sustituido_por" => 270),
        array("idpais" => 17, "idplan" => 2361, "sustituido_por" => 272),
        array("idpais" => 17, "idplan" => 2541, "sustituido_por" => 269),
        array("idpais" => 17, "idplan" => 2359, "sustituido_por" => 269),
        array("idpais" => 17, "idplan" => 900, "sustituido_por" => 852),
        array("idpais" => 17, "idplan" => 2357, "sustituido_por" => 852),
        array("idpais" => 17, "idplan" => 906, "sustituido_por" => 2142),
        array("idpais" => 17, "idplan" => 1719, "sustituido_por" => 270),
        array("idpais" => 17, "idplan" => 2539, "sustituido_por" => 267),
        array("idpais" => 17, "idplan" => 1717, "sustituido_por" => 270),
        array("idpais" => 17, "idplan" => 2542, "sustituido_por" => 270),
        array("idpais" => 17, "idplan" => 2580, "sustituido_por" => 2580),
        array("idpais" => 17, "idplan" => 2582, "sustituido_por" => 2582),
        array("idpais" => 17, "idplan" => 2581, "sustituido_por" => 2581),
        array("idpais" => 17, "idplan" => 2579, "sustituido_por" => 2579),
        array("idpais" => 17, "idplan" => 2578, "sustituido_por" => 2578),
        array("idpais" => 17, "idplan" => 2577, "sustituido_por" => 2577),
        array("idpais" => 17, "idplan" => 1716, "sustituido_por" => 269),
        array("idpais" => 17, "idplan" => 2543, "sustituido_por" => 272),
        array("idpais" => 17, "idplan" => 2540, "sustituido_por" => 269),
        array("idpais" => 17, "idplan" => 2538, "sustituido_por" => 852),
        array("idpais" => 17, "idplan" => 1715, "sustituido_por" => 852),
        array("idpais" => 18, "idplan" => 195, "sustituido_por" => 249),
        array("idpais" => 18, "idplan" => 201, "sustituido_por" => 255),
        array("idpais" => 18, "idplan" => 202, "sustituido_por" => 256),
        array("idpais" => 18, "idplan" => 197, "sustituido_por" => 253),
        array("idpais" => 18, "idplan" => 205, "sustituido_por" => 259),
        array("idpais" => 18, "idplan" => 206, "sustituido_por" => 260),
        array("idpais" => 18, "idplan" => 200, "sustituido_por" => 254),
        array("idpais" => 18, "idplan" => 498, "sustituido_por" => 496),
        array("idpais" => 18, "idplan" => 499, "sustituido_por" => 497),
        array("idpais" => 18, "idplan" => 198, "sustituido_por" => 251),
        array("idpais" => 18, "idplan" => 263, "sustituido_por" => 261),
        array("idpais" => 18, "idplan" => 207, "sustituido_por" => 208),
        array("idpais" => 18, "idplan" => 196, "sustituido_por" => 250),
        array("idpais" => 18, "idplan" => 203, "sustituido_por" => 257),
        array("idpais" => 18, "idplan" => 204, "sustituido_por" => 258),
        array("idpais" => 18, "idplan" => 2412, "sustituido_por" => 2412),
        array("idpais" => 18, "idplan" => 2537, "sustituido_por" => 2537),
        array("idpais" => 18, "idplan" => 503, "sustituido_por" => 492),
        array("idpais" => 18, "idplan" => 504, "sustituido_por" => 493),
        array("idpais" => 18, "idplan" => 213, "sustituido_por" => 245),
        array("idpais" => 18, "idplan" => 215, "sustituido_por" => 247),
        array("idpais" => 18, "idplan" => 216, "sustituido_por" => 248),
        array("idpais" => 18, "idplan" => 214, "sustituido_por" => 246),
        array("idpais" => 18, "idplan" => 193, "sustituido_por" => 275),
        array("idpais" => 18, "idplan" => 188, "sustituido_por" => 267),
        array("idpais" => 18, "idplan" => 190, "sustituido_por" => 270),
        array("idpais" => 18, "idplan" => 192, "sustituido_por" => 273),
        array("idpais" => 18, "idplan" => 191, "sustituido_por" => 272),
        array("idpais" => 18, "idplan" => 189, "sustituido_por" => 269),
        array("idpais" => 5, "idplan" => 660, "sustituido_por" => 660),
        array("idpais" => 11, "idplan" => 671, "sustituido_por" => 671),
        array("idpais" => 11, "idplan" => 1465, "sustituido_por" => 1465),
        array("idpais" => 0, "idplan" => 1996, "sustituido_por" => 1996),
        array("idpais" => 0, "idplan" => 2002, "sustituido_por" => 2002),
        array("idpais" => 0, "idplan" => 2007, "sustituido_por" => 2007),
        array("idpais" => 0, "idplan" => 2008, "sustituido_por" => 2008),
        array("idpais" => 0, "idplan" => 2011, "sustituido_por" => 2011),
        array("idpais" => 11, "idplan" => 2085, "sustituido_por" => 2085),
        array("idpais" => 11, "idplan" => 2086, "sustituido_por" => 2086),
        array("idpais" => 11, "idplan" => 2132, "sustituido_por" => 2132),
        array("idpais" => 11, "idplan" => 2449, "sustituido_por" => 2449),
        array("idpais" => 11, "idplan" => 2552, "sustituido_por" => 2552),
        array("idpais" => 11, "idplan" => 2726, "sustituido_por" => 2726),
        array("idpais" => 11, "idplan" => 2750, "sustituido_por" => 2750),
        array("idpais" => 11, "idplan" => 2776, "sustituido_por" => 2776),
        array("idpais" => 11, "idplan" => 2778, "sustituido_por" => 2778),
        array("idpais" => 11, "idplan" => 2779, "sustituido_por" => 2779),
        array("idpais" => 11, "idplan" => 2780, "sustituido_por" => 2780),
        array("idpais" => 5, "idplan" => 2781, "sustituido_por" => 2781),
        array("idpais" => 11, "idplan" => 2782, "sustituido_por" => 2782),
        array("idpais" => 11, "idplan" => 2783, "sustituido_por" => 2783),
        array("idpais" => 11, "idplan" => 2784, "sustituido_por" => 2784),
        array("idpais" => 11, "idplan" => 2785, "sustituido_por" => 2785),
        array("idpais" => 11, "idplan" => 2786, "sustituido_por" => 2786),
        array("idpais" => 11, "idplan" => 2788, "sustituido_por" => 2788),
        array("idpais" => 11, "idplan" => 2789, "sustituido_por" => 2789),
        array("idpais" => 11, "idplan" => 2791, "sustituido_por" => 2791),
        array("idpais" => 5, "idplan" => 2793, "sustituido_por" => 2793),
        array("idpais" => 11, "idplan" => 2794, "sustituido_por" => 2794),
        array("idpais" => 11, "idplan" => 2795, "sustituido_por" => 2795),
        array("idpais" => 11, "idplan" => 2796, "sustituido_por" => 2796),
        array("idpais" => 5, "idplan" => 2797, "sustituido_por" => 2797),
        array("idpais" => 11, "idplan" => 2798, "sustituido_por" => 2798),
        array("idpais" => 11, "idplan" => 2800, "sustituido_por" => 2800),
        array("idpais" => 11, "idplan" => 2801, "sustituido_por" => 2801),
        array("idpais" => 11, "idplan" => 2802, "sustituido_por" => 2802),
        array("idpais" => 5, "idplan" => 2803, "sustituido_por" => 2803),
        array("idpais" => 11, "idplan" => 2805, "sustituido_por" => 2805),
        array("idpais" => 11, "idplan" => 2806, "sustituido_por" => 2806),
        array("idpais" => 11, "idplan" => 2807, "sustituido_por" => 2807),
        array("idpais" => 11, "idplan" => 2808, "sustituido_por" => 2808),
        array("idpais" => 11, "idplan" => 2809, "sustituido_por" => 2809),
        array("idpais" => 11, "idplan" => 2810, "sustituido_por" => 2810),
        array("idpais" => 11, "idplan" => 2811, "sustituido_por" => 2811),
        array("idpais" => 11, "idplan" => 2812, "sustituido_por" => 2812),
        array("idpais" => 5, "idplan" => 2813, "sustituido_por" => 2813),
        array("idpais" => 11, "idplan" => 2814, "sustituido_por" => 2814),
        array("idpais" => 11, "idplan" => 2815, "sustituido_por" => 2815),
        array("idpais" => 6, "idplan" => 2816, "sustituido_por" => 2816),
        array("idpais" => 5, "idplan" => 2817, "sustituido_por" => 2817),
        array("idpais" => 5, "idplan" => 2818, "sustituido_por" => 2818),
        array("idpais" => 9, "idplan" => 2819, "sustituido_por" => 2819),
        array("idpais" => 5, "idplan" => 2820, "sustituido_por" => 2820),
        array("idpais" => 5, "idplan" => 2821, "sustituido_por" => 2821),
        array("idpais" => 13, "idplan" => 2824, "sustituido_por" => 2824),
        array("idpais" => 11, "idplan" => 2825, "sustituido_por" => 2825),
        array("idpais" => 11, "idplan" => 2826, "sustituido_por" => 2826),
        array("idpais" => 11, "idplan" => 2827, "sustituido_por" => 2827),
        array("idpais" => 11, "idplan" => 2828, "sustituido_por" => 2828),
        array("idpais" => 6, "idplan" => 2829, "sustituido_por" => 2829),
        array("idpais" => 11, "idplan" => 2832, "sustituido_por" => 2832),
        array("idpais" => 0, "idplan" => 2833, "sustituido_por" => 2833),
        array("idpais" => 0, "idplan" => 2836, "sustituido_por" => 2836),
        array("idpais" => 5, "idplan" => 2837, "sustituido_por" => 2837),
        array("idpais" => 11, "idplan" => 2838, "sustituido_por" => 2838),
        array("idpais" => 11, "idplan" => 2839, "sustituido_por" => 2839),
        array("idpais" => 11, "idplan" => 2840, "sustituido_por" => 2840),
        array("idpais" => 11, "idplan" => 2841, "sustituido_por" => 2841),
        array("idpais" => 11, "idplan" => 2843, "sustituido_por" => 2843),
        array("idpais" => 11, "idplan" => 2844, "sustituido_por" => 2844),
        array("idpais" => 11, "idplan" => 2845, "sustituido_por" => 2845),
        array("idpais" => 5, "idplan" => 2846, "sustituido_por" => 2846),
        array("idpais" => 18, "idplan" => 2850, "sustituido_por" => 2850),
        array("idpais" => 13, "idplan" => 2854, "sustituido_por" => 2854),
        array("idpais" => 11, "idplan" => 2855, "sustituido_por" => 2855),
        array("idpais" => 11, "idplan" => 2856, "sustituido_por" => 2856),
        array("idpais" => 0, "idplan" => 2861, "sustituido_por" => 2861),
        array("idpais" => 0, "idplan" => 2865, "sustituido_por" => 2865),
        array("idpais" => 11, "idplan" => 2866, "sustituido_por" => 2866),
        array("idpais" => 11, "idplan" => 2867, "sustituido_por" => 2867),
        array("idpais" => 11, "idplan" => 2868, "sustituido_por" => 2868),
        array("idpais" => 18, "idplan" => 2869, "sustituido_por" => 2869),
        array("idpais" => 11, "idplan" => 2871, "sustituido_por" => 2871),
        array("idpais" => 11, "idplan" => 2872, "sustituido_por" => 2872),
        array("idpais" => 11, "idplan" => 2874, "sustituido_por" => 2874),
        array("idpais" => 11, "idplan" => 2875, "sustituido_por" => 2875),
        array("idpais" => 11, "idplan" => 2876, "sustituido_por" => 2876),
        array("idpais" => 11, "idplan" => 2877, "sustituido_por" => 2877),
        array("idpais" => 11, "idplan" => 2878, "sustituido_por" => 2878),
        array("idpais" => 6, "idplan" => 2879, "sustituido_por" => 2879),
        array("idpais" => 11, "idplan" => 2880, "sustituido_por" => 2880),
        array("idpais" => 11, "idplan" => 2883, "sustituido_por" => 2883),
        array("idpais" => 11, "idplan" => 2884, "sustituido_por" => 2884),
        array("idpais" => 11, "idplan" => 2885, "sustituido_por" => 2885),
        array("idpais" => 11, "idplan" => 2886, "sustituido_por" => 2886),
        array("idpais" => 11, "idplan" => 2887, "sustituido_por" => 2887),
        array("idpais" => 5, "idplan" => 2896, "sustituido_por" => 2896),
        array("idpais" => 11, "idplan" => 2901, "sustituido_por" => 2901),
        array("idpais" => 11, "idplan" => 2902, "sustituido_por" => 2902),
        array("idpais" => 15, "idplan" => 979,"sustituido_por" => 979),
        array("idpais" => 11, "idplan" => 1465,"sustituido_por" => 1465),
        array("idpais" => 15, "idplan" => 1501,"sustituido_por" => 1501),
        array("idpais" => 5, "idplan" => 1504,"sustituido_por" => 1504),
        array("idpais" => 5, "idplan" => 1505,"sustituido_por" => 1505),
        array("idpais" => 11, "idplan" => 1912,"sustituido_por" => 1912),
        array("idpais" => 11, "idplan" => 1921,"sustituido_por" => 1921),
        array("idpais" => 11, "idplan" => 2044,"sustituido_por" => 2044),
        array("idpais" => 11, "idplan" => 2086,"sustituido_por" => 2086),
        array("idpais" => 11, "idplan" => 2132,"sustituido_por" => 2132),
        array("idpais" => 11, "idplan" => 2177,"sustituido_por" => 2177),
        array("idpais" => 5, "idplan" => 2185,"sustituido_por" => 2185),
        array("idpais" => 15, "idplan" => 2218,"sustituido_por" => 2218),
        array("idpais" => 5, "idplan" => 2262,"sustituido_por" => 2262),
        array("idpais" => 18, "idplan" => 2274,"sustituido_por" => 2274),
        array("idpais" => 11, "idplan" => 2276,"sustituido_por" => 2276),
        array("idpais" => 11, "idplan" => 2300,"sustituido_por" => 2300),
        array("idpais" => 5, "idplan" => 2301,"sustituido_por" => 2301),
        array("idpais" => 5, "idplan" => 2364,"sustituido_por" => 2364),
        array("idpais" => 5, "idplan" => 2376,"sustituido_por" => 2376),
        array("idpais" => 5, "idplan" => 2418,"sustituido_por" => 2418),
        array("idpais" => 11, "idplan" => 2449,"sustituido_por" => 2449),
        array("idpais" => 0, "idplan" => 2496,"sustituido_por" => 2496),
        array("idpais" => 5, "idplan" => 2522,"sustituido_por" => 2522),
        array("idpais" => 11, "idplan" => 2552,"sustituido_por" => 2552),
        array("idpais" => 13, "idplan" => 2824,"sustituido_por" => 2824),
        array("idpais" => 13, "idplan" => 2084,"sustituido_por" => 2084),
        array("idpais" => 18,"idplan" => 186,"sustituido_por" => 186),
        array("idpais" => 5,"idplan" => 610,"sustituido_por" => 610),
        array("idpais" => 5,"idplan" => 660,"sustituido_por" => 660),
        array("idpais" => 11,"idplan" => 671,"sustituido_por" => 671),
        array("idpais" => 11,"idplan" => 974,"sustituido_por" => 974),
        array("idpais" => 15,"idplan" => 979,"sustituido_por" => 979),
        array("idpais" => 11,"idplan" => 1299,"sustituido_por" => 1299),
        array("idpais" => 0,"idplan" => 1345,"sustituido_por" => 1345),
        array("idpais" => 11,"idplan" => 1431,"sustituido_por" => 1431),
        array("idpais" => 11,"idplan" => 1465,"sustituido_por" => 1465),
        array("idpais" => 11,"idplan" => 1478,"sustituido_por" => 1478),
        array("idpais" => 15,"idplan" => 1501,"sustituido_por" => 1501),
        array("idpais" => 5,"idplan" => 1504,"sustituido_por" => 1504),
        array("idpais" => 5,"idplan" => 1505,"sustituido_por" => 1505),
        array("idpais" => 11,"idplan" => 1509,"sustituido_por" => 1509),
        array("idpais" => 5,"idplan" => 1529,"sustituido_por" => 1529),
        array("idpais" => 11,"idplan" => 1678,"sustituido_por" => 1678),
        array("idpais" => 11,"idplan" => 1713,"sustituido_por" => 1713),
        array("idpais" => 7,"idplan" => 1778,"sustituido_por" => 1778),
        array("idpais" => 11,"idplan" => 1871,"sustituido_por" => 1871),
        array("idpais" => 18,"idplan" => 1874,"sustituido_por" => 1874),
        array("idpais" => 11,"idplan" => 1912,"sustituido_por" => 1912),
        array("idpais" => 11,"idplan" => 1921,"sustituido_por" => 1921),
        array("idpais" => 11,"idplan" => 1968,"sustituido_por" => 1968),
        array("idpais" => 5,"idplan" => 1969,"sustituido_por" => 1969),
        array("idpais" => 0,"idplan" => 1977,"sustituido_por" => 1977),
        array("idpais" => 11,"idplan" => 1987,"sustituido_por" => 1987),
        array("idpais" => 0,"idplan" => 1996,"sustituido_por" => 1996),
        array("idpais" => 0,"idplan" => 2001,"sustituido_por" => 2001),
        array("idpais" => 0,"idplan" => 2002,"sustituido_por" => 2002),
        array("idpais" => 0,"idplan" => 2005,"sustituido_por" => 2005),
        array("idpais" => 0,"idplan" => 2006,"sustituido_por" => 2006),
        array("idpais" => 0,"idplan" => 2007,"sustituido_por" => 2007),
        array("idpais" => 0,"idplan" => 2008,"sustituido_por" => 2008),
        array("idpais" => 0,"idplan" => 2009,"sustituido_por" => 2009),
        array("idpais" => 0,"idplan" => 2011,"sustituido_por" => 2011),
        array("idpais" => 11,"idplan" => 2019,"sustituido_por" => 2019),
        array("idpais" => 11,"idplan" => 2044,"sustituido_por" => 2044),
        array("idpais" => 11,"idplan" => 2085,"sustituido_por" => 2085),
        array("idpais" => 11,"idplan" => 2086,"sustituido_por" => 2086),
        array("idpais" => 2,"idplan" => 2097,"sustituido_por" => 2097),
        array("idpais" => 0,"idplan" => 2117,"sustituido_por" => 2117),
        array("idpais" => 11,"idplan" => 2132,"sustituido_por" => 2132),
        array("idpais" => 17,"idplan" => 2134,"sustituido_por" => 2134),
        array("idpais" => 11,"idplan" => 2177,"sustituido_por" => 2177),
        array("idpais" => 5,"idplan" => 2185,"sustituido_por" => 2185),
        array("idpais" => 11,"idplan" => 2191,"sustituido_por" => 2191),
        array("idpais" => 11,"idplan" => 2192,"sustituido_por" => 2192),
        array("idpais" => 11,"idplan" => 2193,"sustituido_por" => 2193),
        array("idpais" => 11,"idplan" => 2194,"sustituido_por" => 2194),
        array("idpais" => 11,"idplan" => 2195,"sustituido_por" => 2195),
        array("idpais" => 11,"idplan" => 2197,"sustituido_por" => 2197),
        array("idpais" => 15,"idplan" => 2218,"sustituido_por" => 2218),
        array("idpais" => 5,"idplan" => 2262,"sustituido_por" => 2262),
        array("idpais" => 18,"idplan" => 2274,"sustituido_por" => 2274),
        array("idpais" => 11,"idplan" => 2276,"sustituido_por" => 2276),
        array("idpais" => 11,"idplan" => 2300,"sustituido_por" => 2300),
        array("idpais" => 5,"idplan" => 2301,"sustituido_por" => 2301),
        array("idpais" => 5,"idplan" => 2364,"sustituido_por" => 2364),
        array("idpais" => 5,"idplan" => 2376,"sustituido_por" => 2376),
        array("idpais" => 5,"idplan" => 2418,"sustituido_por" => 2418),
        array("idpais" => 11,"idplan" => 2449,"sustituido_por" => 2449),
        array("idpais" => 0,"idplan" => 2496,"sustituido_por" => 2496),
        array("idpais" => 11,"idplan" => 2507,"sustituido_por" => 2507),
        array("idpais" => 5,"idplan" => 2522,"sustituido_por" => 2522),
        array("idpais" => 11,"idplan" => 2552,"sustituido_por" => 2552),
        array("idpais" => 0,"idplan" => 2573,"sustituido_por" => 2573),
        array("idpais" => 11,"idplan" => 2726,"sustituido_por" => 2726),
        array("idpais" => 11,"idplan" => 2750,"sustituido_por" => 2750),
        array("idpais" => 11,"idplan" => 2776,"sustituido_por" => 2776),
        array("idpais" => 11,"idplan" => 2778,"sustituido_por" => 2778),
        array("idpais" => 11,"idplan" => 2779,"sustituido_por" => 2779),
        array("idpais" => 11,"idplan" => 2780,"sustituido_por" => 2780),
        array("idpais" => 5,"idplan" => 2781,"sustituido_por" => 2781),
        array("idpais" => 11,"idplan" => 2782,"sustituido_por" => 2782),
        array("idpais" => 11,"idplan" => 2783,"sustituido_por" => 2783),
        array("idpais" => 11,"idplan" => 2784,"sustituido_por" => 2784),
        array("idpais" => 11,"idplan" => 2785,"sustituido_por" => 2785),
        array("idpais" => 11,"idplan" => 2786,"sustituido_por" => 2786),
        array("idpais" => 11,"idplan" => 2788,"sustituido_por" => 2788),
        array("idpais" => 11,"idplan" => 2789,"sustituido_por" => 2789),
        array("idpais" => 11,"idplan" => 2791,"sustituido_por" => 2791),
        array("idpais" => 5,"idplan" => 2793,"sustituido_por" => 2793),
        array("idpais" => 11,"idplan" => 2794,"sustituido_por" => 2794),
        array("idpais" => 11,"idplan" => 2795,"sustituido_por" => 2795),
        array("idpais" => 11,"idplan" => 2796,"sustituido_por" => 2796),
        array("idpais" => 5,"idplan" => 2797,"sustituido_por" => 2797),
        array("idpais" => 11,"idplan" => 2798,"sustituido_por" => 2798),
        array("idpais" => 11,"idplan" => 2800,"sustituido_por" => 2800),
        array("idpais" => 11,"idplan" => 2801,"sustituido_por" => 2801),
        array("idpais" => 11,"idplan" => 2802,"sustituido_por" => 2802),
        array("idpais" => 5,"idplan" => 2803,"sustituido_por" => 2803),
        array("idpais" => 11,"idplan" => 2805,"sustituido_por" => 2805),
        array("idpais" => 11,"idplan" => 2806,"sustituido_por" => 2806),
        array("idpais" => 11,"idplan" => 2807,"sustituido_por" => 2807),
        array("idpais" => 11,"idplan" => 2808,"sustituido_por" => 2808),
        array("idpais" => 11,"idplan" => 2809,"sustituido_por" => 2809),
        array("idpais" => 11,"idplan" => 2810,"sustituido_por" => 2810),
        array("idpais" => 11,"idplan" => 2811,"sustituido_por" => 2811),
        array("idpais" => 11,"idplan" => 2812,"sustituido_por" => 2812),
        array("idpais" => 5,"idplan" => 2813,"sustituido_por" => 2813),
        array("idpais" => 11,"idplan" => 2814,"sustituido_por" => 2814),
        array("idpais" => 11,"idplan" => 2815,"sustituido_por" => 2815),
        array("idpais" => 6,"idplan" => 2816,"sustituido_por" => 2816),
        array("idpais" => 5,"idplan" => 2817,"sustituido_por" => 2817),
        array("idpais" => 5,"idplan" => 2818,"sustituido_por" => 2818),
        array("idpais" => 9,"idplan" => 2819,"sustituido_por" => 2819),
        array("idpais" => 5,"idplan" => 2820,"sustituido_por" => 2820),
        array("idpais" => 5,"idplan" => 2821,"sustituido_por" => 2821),
        array("idpais" => 13,"idplan" => 2824,"sustituido_por" => 2824),
        array("idpais" => 11,"idplan" => 2825,"sustituido_por" => 2825),
        array("idpais" => 11,"idplan" => 2826,"sustituido_por" => 2826),
        array("idpais" => 11,"idplan" => 2827,"sustituido_por" => 2827),
        array("idpais" => 11,"idplan" => 2828,"sustituido_por" => 2828),
        array("idpais" => 6,"idplan" => 2829,"sustituido_por" => 2829),
        array("idpais" => 11,"idplan" => 2832,"sustituido_por" => 2832),
        array("idpais" => 0,"idplan" => 2833,"sustituido_por" => 2833),
        array("idpais" => 0,"idplan" => 2836,"sustituido_por" => 2836),
        array("idpais" => 5,"idplan" => 2837,"sustituido_por" => 2837),
        array("idpais" => 11,"idplan" => 2838,"sustituido_por" => 2838),
        array("idpais" => 11,"idplan" => 2839,"sustituido_por" => 2839),
        array("idpais" => 11,"idplan" => 2840,"sustituido_por" => 2840),
        array("idpais" => 11,"idplan" => 2841,"sustituido_por" => 2841),
        array("idpais" => 11,"idplan" => 2843,"sustituido_por" => 2843),
        array("idpais" => 11,"idplan" => 2844,"sustituido_por" => 2844),
        array("idpais" => 11,"idplan" => 2845,"sustituido_por" => 2845),
        array("idpais" => 5,"idplan" => 2846,"sustituido_por" => 2846),
        array("idpais" => 18,"idplan" => 2850,"sustituido_por" => 2850),
        array("idpais" => 13,"idplan" => 2854,"sustituido_por" => 2854),
        array("idpais" => 11,"idplan" => 2855,"sustituido_por" => 2855),
        array("idpais" => 11,"idplan" => 2856,"sustituido_por" => 2856),
        array("idpais" => 0,"idplan" => 2861,"sustituido_por" => 2861),
        array("idpais" => 0,"idplan" => 2865,"sustituido_por" => 2865),
        array("idpais" => 11,"idplan" => 2866,"sustituido_por" => 2866),
        array("idpais" => 11,"idplan" => 2867,"sustituido_por" => 2867),
        array("idpais" => 11,"idplan" => 2868,"sustituido_por" => 2868),
        array("idpais" => 18,"idplan" => 2869,"sustituido_por" => 2869),
        array("idpais" => 11,"idplan" => 2871,"sustituido_por" => 2871),
        array("idpais" => 11,"idplan" => 2872,"sustituido_por" => 2872),
        array("idpais" => 11,"idplan" => 2874,"sustituido_por" => 2874),
        array("idpais" => 11,"idplan" => 2875,"sustituido_por" => 2875),
        array("idpais" => 11,"idplan" => 2876,"sustituido_por" => 2876),
        array("idpais" => 11,"idplan" => 2877,"sustituido_por" => 2877),
        array("idpais" => 11,"idplan" => 2878,"sustituido_por" => 2878),
        array("idpais" => 6,"idplan" => 2879,"sustituido_por" => 2879),
        array("idpais" => 11,"idplan" => 2880,"sustituido_por" => 2880),
        array("idpais" => 11,"idplan" => 2883,"sustituido_por" => 2883),
        array("idpais" => 11,"idplan" => 2884,"sustituido_por" => 2884),
        array("idpais" => 11,"idplan" => 2885,"sustituido_por" => 2885),
        array("idpais" => 11,"idplan" => 2886,"sustituido_por" => 2886),
        array("idpais" => 11,"idplan" => 2887,"sustituido_por" => 2887),
        array("idpais" => 5,"idplan" => 2896,"sustituido_por" => 2896),
        array("idpais" => 11,"idplan" => 2901,"sustituido_por" => 2901),
        array("idpais" => 11,"idplan" => 2902,"sustituido_por" => 2902),
        array("idpais" => 11,"idplan" => 647,"sustituido_por" => 647),
        array("idpais" => 5,"idplan" => 647,"sustituido_por" => 647),
        array("idpais" => 99,"idplan" => 647,"sustituido_por" => 647),
        array("idpais" => 11,"idplan" => 704,"sustituido_por" => 704),
        array("idpais" => 5,"idplan" => 704,"sustituido_por" => 704),
        array("idpais" => 99,"idplan" => 704,"sustituido_por" => 704),
        array("idpais" => 11,"idplan" => 707,"sustituido_por" => 707),
        array("idpais" => 5,"idplan" => 707,"sustituido_por" => 707),
        array("idpais" => 99,"idplan" => 707,"sustituido_por" => 707),
        array("idpais" => 11,"idplan" => 708,"sustituido_por" => 708),
        array("idpais" => 5,"idplan" => 708,"sustituido_por" => 708),
        array("idpais" => 99,"idplan" => 708,"sustituido_por" => 708),
        array("idpais" => 11,"idplan" => 2775,"sustituido_por" => 2775),
        array("idpais" => 5,"idplan" => 2775,"sustituido_por" => 2775),
        array("idpais" => 99,"idplan" => 2775,"sustituido_por" => 2775),
        array("idpais" => 11,"idplan" => 2831,"sustituido_por" => 2831),
        array("idpais" => 5,"idplan" => 2831,"sustituido_por" => 2831),
        array("idpais" => 99,"idplan" => 2831,"sustituido_por" => 2831),
        array("idpais" => 11,"idplan" => 2870,"sustituido_por" => 2870),
        array("idpais" => 5,"idplan" => 2870,"sustituido_por" => 2870),
        array("idpais" => 99,"idplan" => 2870,"sustituido_por" => 2870)
    );

    $todos_los_planes = array();

    foreach($paises as $pais)
    {
        // // SUSTITUYENDO PLANES
            // $idplan_sustituto = $pais['sustituido_por'];
            
            // if(!in_array($idplan_sustituto, $todos_los_planes))
            // {
            //     array_push($todos_los_planes, $idplan_sustituto);
            // }

        // SIN SUSTITUIR PLANES
            $idplan             = $pais['idplan'];
            $idplan_sustituto   = $pais['sustituido_por'];
            
            if(!in_array($idplan, $todos_los_planes))
            {
                array_push($todos_los_planes, $idplan);
            }

            if(!in_array($idplan_sustituto, $todos_los_planes))
            {
                array_push($todos_los_planes, $idplan_sustituto);
            }
    }


    foreach($archivo_planes as $idplan)
    {
        if(!in_array($idplan, $todos_los_planes))
        {
            array_push($todos_los_planes, $idplan);
        }
    }
 

    sort($todos_los_planes);


    $implode_planes = implode(",",$todos_los_planes);


    /* $full_plans =$db_mysql->query("SELECT * from orders where producto =126");

    while ($row = $full_plans->fetch_array(MYSQLI_ASSOC)) 
    {
        $plans[] = $row;
    } */

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
                                            WHERE id IN ($implode_planes)
                                            ORDER BY id ASC 
                                            ");
    while ($row = $mysql_plans->fetch_array(MYSQLI_ASSOC)) 
    {
        $plans[] = $row;
    }

    $insert_planes 	        = "INSERT INTO planes ( idplan, nombreplan, idstatus, idcategoria, tiempominimo, tiempomaximo, edadminima, edadmaxima, edadprecioincremento, planfamiliar, factorpenalizacionedad, factorbeneficiofamiliar, idmonedapago, idmonedacobertura, fechacreacion, fechamodificacion, idpopularidad, edadmaximabeneficiosadic, descripcionplan, descripcionplanen, idtipoasistencia, fechaactualizacionprecioscostos, fechaactualizacionbeneficios, fechaactualizacionbeneficiosadicionales, fechaactualizacionbeneficiosproveedores, publico, familiaplan) VALUES ";
    $insert_planesprecios 	= "INSERT INTO planesprecios ( idplan, dia, precio, idpais, fechaactualizacion ) VALUES ";
    $insert_planescostos1 	= "INSERT INTO planescostos ( idplan, idproveedor, dia, costo, idpais, fechaactualizacion ) VALUES ";
    $insert_planescostos2 	= "INSERT INTO planescostos ( idplan, idproveedor, dia, costo, idpais, fechaactualizacion ) VALUES ";
    $insert_planespaises        = "INSERT INTO planespaises ( idplan, idpais ) VALUES ";
    
    $array_valores_planes 	        = array();
    $array_valores_planesprecios 	= array();
    $array_valores_planescostos1 	= array();
    $array_valores_planescostos2 	= array();
    $array_valores_planespaises 	= array();

    foreach($plans as $plan)
    {
        $idplan = $plan['id'];

        // foreach($paises as $pais)
        // {
        //     if($pais['idplan'] == $idplan || $pais['sustituido_por'] == $idplan)
        //     {
        //         $idpais = $pais['idpais'];
        //         $idplan = $pais['sustituido_por'];
        //     }
        // }

        $nombreplan                                 = $plan['name'];
        $familiaplan                                = NULL;
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
        $idpopularidad                              = ($plan['id_popularidad'] == 0) ? 1 : $plan['id_popularidad'];
        $edadmaximabeneficioadic                    = $plan['max_age_ben_adic'];
        $descripcionplan                            = '';
        $descripcionplanen                          = '';
        $idtipoasistencia                           = 1;
        $fechaactualizacionprecioscostos            = '2000-01-01 00:00:00';
        $fechaactualizacionbeneficios               = '2000-01-01 00:00:00';
        $fechaactualizacionbeneficiosadicionales    = '2000-01-01 00:00:00';
        $fechaactualizacionbeneficiosproveedores    = '2000-01-01 00:00:00';
        $publico                                    = $plan['publico'];

        // $idpais = $plan['id_site'];

        $valor = "(
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
                        NULL
                        )";

        array_push($array_valores_planes, $valor);





        // CONSULTA LOS PRECIOS 
            $mysql_precios  = array();
            $precios        = array();

            $select = "SELECT * FROM precios WHERE id_plan = '$idplan' ORDER BY id ASC";

            $mysql_precios = $db_mysql->query($select);

            while ($row_precio = $mysql_precios->fetch_array(MYSQLI_ASSOC)) 
            { 
                $precios[] = $row_precio; 
            }

        // CONSULTA LOS PAISES QUE LO HAN UTILIZADO
            $select_paises_utilizados = "SELECT broker.id_site 
                                        from orders 
                                            left join broker on orders.agencia = broker.id_broker
                                        where orders.producto = $idplan
                                        group by 1";

            $mysql_utilizados = $db_mysql->query($select_paises_utilizados);

            while ($row_utilizados = $mysql_utilizados->fetch_array(MYSQLI_ASSOC)) 
            { 
                $paises_utilizados[] = $row_utilizados; 
            }

        if(count($paises_utilizados) > 0)
        {
            foreach($paises_utilizados as $pais_utilizado)
            {
                if($pais_utilizado['id_site'] != NULL)
                {
                    $idpais = ($pais_utilizado['id_site'] == 0 ) ? 99 : $pais_utilizado['id_site'];

                    // INSERTA PLANESPAISES SI NO LO ENCUENTRA 
                        $cantidad_planespaises = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planespaises WHERE idplan = $idplan AND idpais = $idpais", "cantidad");

                        if($cantidad_planespaises == 0)
                        {
                            $valor_planespaises = " ( $idplan, $idpais )";

                            array_push($array_valores_planespaises, $valor_planespaises);
                        }

                    // INSERTA LOS PRECIOS PARA CADA PAIS
                        if(count($precios) > 0)
                        {
                            foreach($precios as $registro)
                            {    
                                $dia        = $registro['dias'];
                                $precio     = $registro['precio'];
                                $costo1     = ($registro['costo1'] > 0) ? $registro['costo1'] : 0;
                                $costo2     = ($registro['costo2'] > 0) ? $registro['costo2'] : 0;

                                array_push($array_valores_planesprecios, "( $idplan, $dia, $precio, $idpais, '2000-01-01 00:00:00')");
                                array_push($array_valores_planescostos1, "( $idplan, 1, $dia, $costo1, $idpais, '2000-01-01 00:00:00')");
                                array_push($array_valores_planescostos2, "( $idplan, 2, $dia, $costo2, $idpais, '2000-01-01 00:00:00')");
                            }
                        }
                }
            }
        }

        $paises_utilizados = array();
    }

    $valores 		= implode(",", $array_valores_planes);
    $insert_planes 	        = $insert_planes.$valores;

    if(ejecuta_insert($db_postgresql, $insert_planes) == 0) 
    {
    echo $insert_planes;
        die( "Error al insert_planes: " . pg_last_error($db_postgresql));
    }

    

    $valores 				= implode(",", $array_valores_planesprecios);
    $insert_planesprecios 	= $insert_planesprecios.$valores;

    if(ejecuta_insert($db_postgresql, $insert_planesprecios) == 0) 
    {
    echo $insert_planesprecios;
        die( "Error al insert_planesprecios: " . pg_last_error($db_postgresql));
    }
   


    $valores 				= implode(",", $array_valores_planescostos1);
    $insert_planescostos1 	= $insert_planescostos1.$valores;

    if(ejecuta_insert($db_postgresql, $insert_planescostos1) == 0) 
    {
    echo $insert_planescostos1;
        die( "Error al insert_planescostos1: " . pg_last_error($db_postgresql));
    }

    $valores 				= implode(",", $array_valores_planescostos2);
    $insert_planescostos2 	= $insert_planescostos2.$valores;

    if(ejecuta_insert($db_postgresql, $insert_planescostos2) == 0) 
    {
    echo $insert_planescostos2;
        die( "Error al insert_planescostos2: " . pg_last_error($db_postgresql));
    }

    $valores 				= implode(",", $array_valores_planespaises);
    $insert_planespaises 	= $insert_planespaises.$valores;
   
    
    if(ejecuta_insert($db_postgresql, $insert_planespaises) == 0) 
    {
    echo $insert_planespaises;
        die( "Error al insert_planespaises: " . pg_last_error($db_postgresql));
    }
  



    $secuencia = $idplan + 1;
    $secuencia = "ALTER SEQUENCE planes_idplan_seq RESTART WITH ".$secuencia; 
    ejecuta_select($db_postgresql, $secuencia);

   



    // CUPONES *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: cupones...';

    $cupones = array();

    $mysql_cupones = $db_mysql->query("SELECT 
                                            coupons.id as idcupon,
                                            coupons.codigo as codigocupon, 
                                            coupons.porcentaje as porcentaje, 
                                            coupons.fecha_desde as fechadesde, 
                                            coupons.fecha_hasta as fechahasta, 
                                            coupons.id_status as idstatus, 
                                            coupons.ussage as disponibles, 
                                            COALESCE(coupons.created, '2000-01-01 00:00:00') as fechacreacion,
                                            COALESCE(coupons.modified, '2000-01-01 00:00:00') as fechamodificacion,
                                            coupons.acepta_familia as aceptafamiliar
                                        FROM coupons 
                                        WHERE coupons.id_status = 1 OR coupons.id IN (SELECT cupon FROM orders WHERE fecha >= '2024-01-01' GROUP BY 1)
                                        GROUP BY coupons.id
                                        ORDER BY coupons.id ASC");

    while ($row = $mysql_cupones->fetch_array(MYSQLI_ASSOC)) 
    {
        $cupones[] = $row;
    }
    
    $insert = "INSERT INTO cupones ( idcupon, codigocupon, porcentaje, fechadesde, fechahasta, idstatus, disponibles, fechacreacion, fechamodificacion, aceptafamiliar ) VALUES ";

    $array_valores = array();
    foreach($cupones as $cupon)
    {
        $idcupon            = $cupon['idcupon'];
        $codigocupon        = $cupon['codigocupon'];
        $porcentaje         = $cupon['porcentaje'];
        $fechadesde         = $cupon['fechadesde'].' 00:00:00';
        $fechahasta         = $cupon['fechahasta'].' 23:59:59';
        $idstatus           = ($cupon['idstatus'] == 0) ? 2 : $cupon['idstatus'];
        $disponibles        = $cupon['disponibles'];
        $fechacreacion      = $cupon['fechacreacion'];
        $fechamodificacion  = $cupon['fechamodificacion'];
        $aceptafamiliar     = $cupon['aceptafamiliar'];
    
        $valor = " (
                        $idcupon,
                        UPPER('$codigocupon'),
                        $porcentaje,
                        '$fechadesde',
                        '$fechahasta',
                        $idstatus,
                        $disponibles,
                        '$fechacreacion',
                        '$fechamodificacion',
                        '$aceptafamiliar'
                    )";

        array_push($array_valores, $valor);
    }

    $valores    = implode(",", $array_valores);
    $insert     = $insert.$valores;
   
   
    if(ejecuta_insert($db_postgresql, $insert) == 0) 
    {
    echo $insert;
        die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
    }
    $secuencia = $idcupon + 1;
    $secuencia = "ALTER SEQUENCE cupones_idcupon_seq RESTART WITH ".$secuencia; 
    ejecuta_select($db_postgresql, $secuencia);







// CUPONES AGENCIAS *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: cuponesagencias...';

    $cupones_agencias = array();

    $mysql_cupones_agencias = $db_mysql->query("SELECT 
                                                    broker_coupons.id_broker as idagencia, 
                                                    broker_coupons.id_cupon as idcupon 
                                                FROM coupons
                                                    LEFT JOIN broker_coupons ON coupons.id = broker_coupons.id_cupon
                                                WHERE broker_coupons.id_broker IN ($todas_las_agencias_implode)
                                                AND coupons.id_status = 1
                                                ORDER BY coupons.id ASC");

    while ($row = $mysql_cupones_agencias->fetch_array(MYSQLI_ASSOC)) 
    {
        $cupones_agencias[] = $row;
    }

    $insert = "INSERT INTO cuponesagencias ( idagencia, idcupon ) VALUES ";

    $array_valores = array();
    foreach($cupones_agencias as $cupon_agencia)
    {
        $idagencia = $cupon_agencia['idagencia'];
        $idcupon   = $cupon_agencia['idcupon'];
        
        $valor     = " (
                        $idagencia,
                        $idcupon
                    )";

        array_push($array_valores, $valor);
    }

    $valores    = implode(",", $array_valores);
    $insert     = $insert.$valores;

    if(ejecuta_insert($db_postgresql, $insert) == 0) 
    {
    echo $insert;
        die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
    }



// CUPONES CATEGORIAS *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: cuponescategorias...';
    
    $cuponescategorias = array();

    $mysql = $db_mysql->query("SELECT 
                                DISTINCT plans_category_coupons.id_plan_categoria, 
                                plans_category_coupons.id_cupon 
                            FROM plans_category_coupons 
                                LEFT JOIN broker_coupons ON plans_category_coupons.id_cupon = broker_coupons.id_cupon
                                LEFT JOIN coupons ON plans_category_coupons.id_cupon = coupons.id
                            WHERE broker_coupons.id_broker IN ($todas_las_agencias_implode)
                            AND coupons.id_status = 1
                            ORDER BY plans_category_coupons.id_plan_categoria ASC");

    while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    {
        $cuponescategorias[] = $row;
    }

    $insert = "INSERT INTO cuponescategorias ( idcategoria, idcupon ) VALUES ";

    $array_valores = array();
    foreach($cuponescategorias as $beneficiocategoria)
    {
        $idcategoria    = $beneficiocategoria['id_plan_categoria'];
        $idcupon        = $beneficiocategoria['id_cupon'];

        $valor     = " (
                            $idcategoria, 
                            $idcupon
                        )";

        array_push($array_valores, $valor);
    }

    $valores    = implode(",", $array_valores);
    $insert     = $insert.$valores;    

    if(ejecuta_insert($db_postgresql, $insert) == 0) 
    {
    echo $insert;
        die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
    }















// CUPONES FUENTES (LUEGO)*******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: cuponesfuentes...';
    $cuponesfuentes = array();

    $mysql = $db_mysql->query("SELECT 
                                    coupons.target, 
                                    coupons.id 
                                FROM coupons 
                                    LEFT JOIN broker_coupons ON coupons.id = broker_coupons.id_cupon
                                WHERE broker_coupons.id_broker IN ($todas_las_agencias_implode)
                                AND coupons.id_status = 1
                                ORDER BY id ASC ");
    while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    {
        $cuponesfuentes[] = $row;
    }

    $insert = "INSERT INTO cuponesfuentes ( idfuente, idcupon ) VALUES ";

    $array_valores = array();
    foreach($cuponesfuentes as $cuponfuente)
    {
        $idfuente   = $cuponfuente['target'] == 0 ? 1 : 2;
        $idcupon    = $cuponfuente['id'];

        $valor     = " (
                                $idfuente, 
                                $idcupon
                            )";



        array_push($array_valores, $valor);
    }

    $valores    = implode(",", $array_valores);
    $insert     = $insert.$valores;

    if(ejecuta_insert($db_postgresql, $insert) == 0) 
    {
    echo $insert;
        die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
    }
      
  


// PLANES AGENCIAS (ANALIZAR) *******************************************************************************************************************************************************************************
    echo '
Migrando Tabla: Planes Agencias...';

    $comisiones = array();

    $mysql_planes_agencias = $db_mysql->query("SELECT 
                                                DISTINCT producto, 
                                                programaplan, 
                                                agencia 
                                            FROM orders 
                                                JOIN plans ON plans.id = orders.producto 
                                                JOIN broker ON broker.id_broker = orders.agencia 
                                            WHERE 1 = 1
                                            AND plans.id IN ($implode_planes)
                                            AND orders.agencia IN ($todas_las_agencias_implode)
                                            AND orders.agencia NOT IN (0)
                                            ORDER BY producto, agencia ASC");

    while ($row = $mysql_planes_agencias->fetch_array(MYSQLI_ASSOC)) 
    {
        $planes_agencias[] = $row;
    }

    $insert_planesagencias              = "INSERT INTO planesagencias ( idplan, idagencia ) VALUES ";
    $insert_comisionesagencias          = "INSERT INTO comisionesagencias ( idagencia, idcategoria, idplan, comision ) VALUES ";

    $array_valores_planesagencias       = array();
    $array_valores_comisionesagencias   = array();




   
    // Preparar arrays para almacenar los IDs únicos
$agenciasComisiones = [];
$categoriasComisiones = [];

// Recorrer los planes de agencias y verificar la existencia de comisiones
foreach ($planes_agencias as $plan_agencia) {
    $idplan = $plan_agencia['producto'];
    $idagencia = $plan_agencia['agencia'];
    $idcategoria = $plan_agencia['programaplan'];

    // Verificar si existe comisión en comisionesagencias
    $existe_comision = ejecuta_select($db_postgresql, "SELECT idcomisiones FROM comisionesagencias WHERE idagencia = $idagencia AND idcategoria = $idcategoria");
    if ($existe_comision['cantidad'] ==  0) {
        // Si no existe, agregar los IDs a los arrays para consultar en MySQL
        $agenciasComisiones[$idagencia] = true;
        $categoriasComisiones[$idcategoria] = true;
    }

    // Agregar el valor a array_valores_planesagencias
    $array_valores_planesagencias[] = "($idplan, $idagencia)";
}

// Construir strings para las consultas en MySQL usando los IDs únicos
$agenciasStr = implode(',', array_keys($agenciasComisiones));
$categoriasStr = implode(',', array_keys($categoriasComisiones));

// Realizar una sola consulta para obtener las comisiones desde MySQL
$mysql_comisiones = $db_mysql->query("SELECT id_agencia, id_categoria, porcentaje FROM commissions WHERE id_agencia IN ($agenciasStr) AND id_categoria IN ($categoriasStr)");

// Procesar las comisiones obtenidas y agregarlos a array_valores_comisionesagencias
while ($row = $mysql_comisiones->fetch_array(MYSQLI_ASSOC)) {
    $array_valores_comisionesagencias[] = "({$row['id_agencia']}, {$row['id_categoria']}, NULL, {$row['porcentaje']})";
}


   


    $valores 		            = implode(",", $array_valores_planesagencias);
    $insert_planesagencias 	    = $insert_planesagencias.$valores;
   
    if(ejecuta_insert($db_postgresql, $insert_planesagencias) == 0) 
    {
         echo $insert_planesagencias;
        die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
    }

    $valores 			= implode(",", $array_valores_comisionesagencias);
    $insert_comisionesagencias 	= $insert_comisionesagencias.$valores;
   
    if(ejecuta_insert($db_postgresql, $insert_comisionesagencias) == 0) 
    {
         echo $insert_comisionesagencias;
        die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
    }










// ACTUALIZAR FRAMES
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#0d70b7', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/continentalassistmexico.png' WHERE idagencia = 4446;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#523c97', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/enel.png' WHERE idagencia = 3752;         ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#41B6E6', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/logo-segurointeligente.png' WHERE idagencia = 4413;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#41B6E6', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/logo-segurointeligentefunerario.png' WHERE idagencia = 5532;");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#41B6E6', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/howden.jpg' WHERE idagencia = 1944;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#df2127', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/aon.png' WHERE idagencia = 1860;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#223269', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/milenio.png' WHERE idagencia = 1760;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#df2127', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/asixpress.jpg' WHERE idagencia = 4497;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#002847', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/gestionas.png' WHERE idagencia = 2507;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#eaa91e', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/seguroselroble.png' WHERE idagencia = 4188;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#0093d0', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/tripless.png' WHERE idagencia = 4610;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#000092', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/1seguros.png' WHERE idagencia = 3942;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#ea4f46', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/healthtravel.png' WHERE idagencia = 4771;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#223269', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/milenio.png' WHERE idagencia = 4347;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#2e9042', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/segurosdespertar.png' WHERE idagencia = 4807;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#010077', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/oscarodriozola.png' WHERE idagencia = 5248;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#CE0E2D', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/viajesegurogt.png' WHERE idagencia = 4429;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#0899D7', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/segurosmundial.png' WHERE idagencia = 5580;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#001689', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/grupoprotg.png' WHERE idagencia = 4844;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#75bc20', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/brove.png' WHERE idagencia = 5652;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#FFFFFF', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/coltefinanciera.png' WHERE idagencia = 5806;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#2a6da8', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/urreta.png' WHERE idagencia = 5814;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#44499d', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/fidex.png' WHERE idagencia = 5854;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#7f35b2', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/wtw.png' WHERE idagencia = 5855;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#0a5d7d', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/nuno.png' WHERE idagencia = 5795;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#745fc9', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/thb.png' WHERE idagencia = 5211;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#017687', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/stori.jpg' WHERE idagencia = 5901;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#22294c', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/tuasesor.png' WHERE idagencia = 5888;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#000880', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/continentalassistmexico.png' WHERE idagencia = 509;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#005189', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/confia.png' WHERE idagencia = 5217;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#1b75bc', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/visasencolombia.png' WHERE idagencia = 4528;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#009d4c', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/kanko.png' WHERE idagencia = 1920;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#de594a', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/sekuritas.png' WHERE idagencia = 1425;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#4F36CC', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/yap.png' WHERE idagencia = 6117;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#014F81', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/faros.jpg' WHERE idagencia = 6191;       ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#3D7ABD', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/ever.jpg' WHERE idagencia = 5923;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#CE0F0F', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/malek.jpg' WHERE idagencia = 2429;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#014BAE', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/cobintel1.jpg' WHERE idagencia = 6163;         ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#ed1c27', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/davivienda.jpg' WHERE idagencia = 4726;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#e3284a', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/arca.jpg' WHERE idagencia = 6319;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#9b2c39', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/femsa.jpg' WHERE idagencia = 6320;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#179DCD', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/inter.jpg' WHERE idagencia = 6321;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#4D4D4E', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/hga.jpg' WHERE idagencia = 6012;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#EE2629', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/bancofinandina.png' WHERE idagencia = 6358;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#105AAB', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/ficosha.png' WHERE idagencia = 4637;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#0064a9', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/avia.png' WHERE idagencia = 1962;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#16264a', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/josealfonsoguerrero.jpg' WHERE idagencia = 3715;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#135671', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/vitro.png' WHERE idagencia = 6375;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#12406f', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/hir.png' WHERE idagencia = 6433;        ");
ejecuta_update($db_postgresql, "UPDATE agencias SET color1frame = '#12406f', logoagencia = 'https://storage.googleapis.com/files-continentalassist-backend/Agencias/gnp.png' WHERE idagencia = 6432;        ");
  
    


// ACTUALIZA TOKENS
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = 'd2f97766cd12ab40e750a6aba99c6adc769048c1', tokenpagina = 'affinitypro.wsaffinity.com' WHERE idagencia = 2477;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '2d924235266d588f1e6ae3bf8f2c6fb41b963cc5', tokenpagina = 'healthform.sagicor.cr' WHERE idagencia = 2477;");

ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '1f1f00265442290d1ba1a9a9c462dcc57e062749', tokenpagina = '190.242.155.195' WHERE idagencia = 4598;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '183765f9175d4f42a7d9b744e678e29f99552cc8', tokenpagina = '190.242.155.194' WHERE idagencia = 4598;");

ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '8e4075ab851d30bace5e8198d6bfa7a4a43c3865', tokenpagina = 'www.visiontravel.com' WHERE idagencia = 1501;");

ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '57b06dccc74138f3183d6df49b42520d7581efa8', tokenpagina = 'miportal.latinoseguros.com.mx' WHERE idagencia = 2138;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '356964e2f8c0811ead9d1529fbae58127379054e', tokenpagina = 'www.continentalassist.com' WHERE idagencia = 174;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '858214380555c5b6f55c22a92b70506887f9a7e0', tokenpagina = 'comprar.nacionaldeseguros.com.pa' WHERE idagencia = 2411;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '3d8dc6b019ac048fb3548ee7ceae0b47dc068b47', tokenpagina = 'openinsurances.com' WHERE idagencia = 2676;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = 'eb05f6398bf5b83fa166f48cf5b6696a9e148949', tokenpagina = 'macooley.azurewebsites.net' WHERE idagencia = 2540;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '160d8b912c5aa1f2c5ca62ab498cae101341f600', tokenpagina = 'www.viajar-seguro.com' WHERE idagencia = 907;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = 'bcc791c6c175f7c6306189f9a82702', tokenpagina = 'hyperiondg.com' WHERE idagencia = 3637;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = 'ceffc6ac6af74d07556f5575c362c2ab5291540dBLOQUEADO0', tokenpagina = 'www.susegurodeviaje.comBloqueado' WHERE idagencia = 3890;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = 'a28a8ddec522eb03109e25f7e3ff37f4d4eb81e6', tokenpagina = 'www.onetravel.com' WHERE idagencia = 4092;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '6603799a08aaf2f9534d5907a47c9e859a3182e6', tokenpagina = 'www.myglobalassist.com' WHERE idagencia = 3440;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '1a0bc61e9d6cf89b5e0294ba934214e4f773b14e', tokenpagina = 'cotizamatico.com.mx' WHERE idagencia = 4075;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '339bd2bd2deb69b288d70f5b8869851731102934', tokenpagina = 'staging.smarttravel.xyz' WHERE idagencia = 4482;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '6ddad85339c8c2d77beeccd0caf481e1b31e7a74', tokenpagina = 'www.adisa.cr' WHERE idagencia = 4367;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = 'c49df2d8c23135134bc1e35ff5c40f7b4b15d747', tokenpagina = 'www.ainhoa.com' WHERE idagencia = 755;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '394a5445754b5caca6c809e13d781f558a6cc8bf', tokenpagina = 'www.triplesinc.com' WHERE idagencia = 4610;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '636561414aa2ad2d1c1514d85d8c86e0d7a46452', tokenpagina = 'www.segurvendingcr.com' WHERE idagencia = 4726;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '70d415cf6205a3682694a4a4df2b30bad77ba0d9', tokenpagina = 'grupobituaj.com.mx' WHERE idagencia = 2042;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '7764656149128e4b25ffee7f58d631e45b62e2a8', tokenpagina = 'continental.coboser.com' WHERE idagencia = 4723;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '81e335b0f29d5c45c5d2c1bf2290f65cdb1b39d7', tokenpagina = 'www.segurvending.com' WHERE idagencia = 5331;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '1a7780829b53156057d6b7c5c83988c6e7298722', tokenpagina = 'sabar.vortyze.net' WHERE idagencia = 5211;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '731503a98234c346d30afaabf3a3418f7b4f3bee', tokenpagina = '200.58.131.71' WHERE idagencia = 5768;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = 'b634875830791ddbd0dac6ed2c1b3c636a06ef18', tokenpagina = 'www.segurosgyt.com' WHERE idagencia = 4429;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '5ea80c2fb4cd78202bf661940288646557e3b859', tokenpagina = 'www.segurosmundial.com.co' WHERE idagencia = 5580;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '567baa1a00844d3f22ab89a66e8c3288e8e19eb0', tokenpagina = '165.227.22.221' WHERE idagencia = 4387;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '66d87bf18d46323bdf1dcaf536805185f15ff01c', tokenpagina = 'www.promericanicaragua.com' WHERE idagencia = 6307;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = 'a14fecce3616ac6f71caf4b47e4a79c7829855ea', tokenpagina = 'www.davivienda.com' WHERE idagencia = 6330;");
ejecuta_update($db_postgresql, "UPDATE agencias SET tokenhash = '5bf9cfd3cab4a28a5c4d208092eb2c3477bbe609', tokenpagina = 'www.malekseguros.com' WHERE idagencia = 2429;");


// CREAR TOKENS PARA LAS AGENCIAS QUE NO TENGAN






// ASOCIAR PLANES BLOQUEADOS 

$insert_planesagencias              = "INSERT INTO planesagencias (idagencia, idplan) VALUES ";
$array_valores_planesagencias       = array();

$insert_categoriasagencias          = "INSERT INTO categoriasagencias (idagencia, idcategoria) VALUES ";
$array_valores_categoriasagencias   = array();

foreach($planes_bloqueados as $agencia)
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
        //array_push($array_categorias, $idcategoria);
        $array_categorias[] =$idcategoria;
    }

    $valor_planesagencias = " ($idagencia, $idplan) ";
    //array_push($array_valores_planesagencias, $valor_planesagencias);
    $array_valores_planesagencias[] =$valor_planesagencias;
}

foreach($array_categorias as $idcategoria)
{
    $valor_categoriasagencias = " ($idagencia, $idcategoria) ";
    //array_push($array_valores_categoriasagencias, $valor_categoriasagencias);
    $array_valores_categoriasagencias[] =$valor_categoriasagencias;

}
}

$valores_planesagencias = implode(",", $array_valores_planesagencias);
$insert_planesagencias = $insert_planesagencias.$valores_planesagencias;
if(ejecuta_insert($db_postgresql, $insert_planesagencias) == 0) 
{
     echo $insert_planesagencias;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}

$valores_categoriasagencias = implode(",", $array_valores_categoriasagencias);
$insert_categoriasagencias = $insert_categoriasagencias.$valores_categoriasagencias;

if(ejecuta_insert($db_postgresql, $insert_categoriasagencias) == 0) 
{
     echo $insert_categoriasagencias;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}





//PLANES FUENTES *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: Planes Fuentes...';


$insert           = "INSERT INTO planesfuentes ( idplan, idfuente ) VALUES ";
$array_valores    = array();

foreach($todos_los_planes as $idplan)
{
    if($idplan != 0)
    {
        array_push($array_valores, "( $idplan, 1 )");
        array_push($array_valores, "( $idplan, 3 )");
        //$array_valores[] = "( $idplan,  1 )";
        //$array_valores[] = "( $idplan,  3 )";
    }
}

$valores 	    = implode(",", $array_valores);
$insert 	    = $insert.$valores;

//ejecuta_insert($db_postgresql, $insert);
if(ejecuta_insert($db_postgresql, $insert) == 0) 
{
     echo $insert;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}

ejecuta_insert($db_postgresql, "INSERT INTO planesfuentes ( idplan, idfuente ) VALUES (87, 2),(88, 2),(89, 2) ");




//PLANES ORIGENES Y DESTINOS *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: Planes Origenes...';

$origenes = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE origenpermitido = true");

$insert_planesorigenes           = "INSERT INTO planesorigenes ( idplan, idpais ) VALUES ";

$array_valores_planesorigenes    = array();
foreach($todos_los_planes as $idplan)
{
    foreach($origenes['resultado'] as $origen)
    {
        $idpais     = $origen['idpais'];

        if($idplan != 0)
        {
             $array_valores_planesorigenes[] = "( $idplan, $idpais )";

        }
    }
}

$valores 				    = implode(",", $array_valores_planesorigenes);
$insert_planesorigenes 	    = $insert_planesorigenes.$valores;

if(ejecuta_insert($db_postgresql, $insert_planesorigenes) == 0) 
{
     echo $insert_planesorigenes;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}








//PLANES DESTINOS *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: Planes Destinos...';

$destinos = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE destinopermitido = true");

$insert_planesdestinos           = "INSERT INTO planesdestinos ( idplan, idpais ) VALUES ";

$array_valores_planesdestinos    = array();
foreach($todos_los_planes as $idplan)
{
    foreach($destinos['resultado'] as $origen)
    {
        $idpais     = $origen['idpais'];
        if($idplan != 0)
        {
            //array_push($array_valores_planesdestinos, "( $idplan, $idpais )");
            $array_valores_planesdestinos[] = "( $idplan, $idpais )";

        }
    }
}

$valores 				    = implode(",", $array_valores_planesdestinos);
$insert_planesdestinos 	    = $insert_planesdestinos.$valores;

//ejecuta_insert($db_postgresql, $insert_planesdestinos);

if(ejecuta_insert($db_postgresql, $insert_planesdestinos) == 0) 
{
     echo $insert_planesdestinos;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}






//PLANES PLATAFORMAS PAGO *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: Planes Plataformas Pago...';

$insert_planesplataformaspago           = "INSERT INTO planesplataformaspago ( idplan, idplataformapago ) VALUES ";

$array_valores_planesplataformaspago    = array();
foreach($todos_los_planes as $idplan)
{
    if($idplan != 0)
    {
           $array_valores_planesplataformaspago[] = "( $idplan, 1 )";
        $array_valores_planesplataformaspago[] = "( $idplan, 2 )";

    }
}

$valores 				            = implode(",", $array_valores_planesplataformaspago);
$insert_planesplataformaspago 	    = $insert_planesplataformaspago.$valores;

if(ejecuta_insert($db_postgresql, $insert_planesplataformaspago) == 0) 
{
     echo $insert_planesplataformaspago;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}






// PLANES BENEFICIOS (LUEGO) *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: planesbeneficios...';

$planesbeneficios = array();

$mysql = $db_mysql->query("SELECT DISTINCT beneficios_costo.id_plan, 
                                    beneficios_costo.id_beneficio, 
                                    CAST(CONVERT(beneficios_costo.valor  USING utf8) AS binary) as cobertura,
                                    CAST(CONVERT(beneficios_costo.language_id  USING utf8) AS binary) as coberturaen,
                                    beneficios_costo.orden
                                    FROM beneficios_costo 
                                        JOIN plans ON plans.id = beneficios_costo.id_plan 
                                        JOIN beneficios ON beneficios.id_beneficio = beneficios_costo.id_beneficio 
                                    WHERE beneficios.language_id = 'spa' 
                                    AND plans.id IN ($implode_planes)
                                    ORDER BY id_plan ASC");

while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
{
    $planesbeneficios[] = $row;
}

$insert = "INSERT INTO planesbeneficios ( idplan, idbeneficio, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ";

$array_valores = array();

foreach($planesbeneficios as $planbeneficio)
{
    $idplan             = $planbeneficio['id_plan'];
    $idbeneficio        = $planbeneficio['id_beneficio'];
    $cobertura          = $planbeneficio['cobertura'];
    $coberturaen        = $planbeneficio['coberturaen'];
    $orden              = $planbeneficio['orden'];

    $valor     = " (
                        $idplan, 
                        $idbeneficio,
                        '$cobertura',
                        '$coberturaen',
                        $orden,
                        '2000-01-01 00:00:00'
                    )";

      $array_valores[] = $valor;

}

$valores = implode(",", $array_valores);
$insert = $insert.$valores;

if(ejecuta_insert($db_postgresql, $insert) == 0) 
{
     echo $insert;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}





// PLANES BENEFICIOS (LUEGO) *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: planesbeneficiosproveedores...';

$planesbeneficios = ejecuta_select($db_postgresql, "SELECT idplanbeneficio FROM planesbeneficios");

if($planesbeneficios['cantidad'] > 0)
{
    $insert         = "INSERT INTO planesbeneficiosproveedores ( idplanbeneficio, idproveedor, porcentajeriesgo, fechaactualizacion ) VALUES ";
    $array_valores  = array();

    foreach($planesbeneficios['resultado'] as $planbeneficio)
    {
        $idplanbeneficio  = $planbeneficio['idplanbeneficio'];

        $valor     = " (
                            $idplanbeneficio, 
                            1,
                            100,
                            '2000-01-01 00:00:00'
                        )";

        //array_push($array_valores, $valor);
        $array_valores[] = $valor;

    }

    $valores = implode(",", $array_valores);
    $insert = $insert.$valores;
    //ejecuta_insert($db_postgresql, $insert);
    if(ejecuta_insert($db_postgresql, $insert) == 0) 
    {
        echo $insert;
        die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
    }
}





// PLANES BENEFICIOS ADICIONALES (LUEGO) *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: planesbeneficiosadicionales...';

$planesbeneficiosadicionales = array();

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
                                    AND beneficios_plus.id_plan IN ($implode_planes)
                                    AND beneficios_plus.id_beneficio IN (35,36,37)
                                    ORDER BY beneficios_plus.id ASC");

while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
{
    $planesbeneficiosadicionales[] = $row;
}

$insert = "INSERT INTO planesbeneficiosadicionales ( idplan, idbeneficioadicional, factorconversion, factorconversionedad, factorconversionfamiliar, cobertura, coberturaen, orden, fechaactualizacion ) VALUES ";

$array_valores = array();

foreach($planesbeneficiosadicionales as $planbeneficioadicional)
{
    $idplan                     = $planbeneficioadicional['idplan'];
    $idbeneficioadicional       = $planbeneficioadicional['idbeneficioadicional'];
    $factorconversion           = $planbeneficioadicional['factorconversion'];
    $factorconversionedad       = $planbeneficioadicional['factorconversionedad'];
    $factorconversionfamiliar   = $planbeneficioadicional['factorconversionfamiliar'];
    $cobertura                  = $planbeneficioadicional['cobertura'];
    $coberturaen                = $planbeneficioadicional['coberturaen'];
    $orden                      = $planbeneficioadicional['orden'];
    $fechaactualizacion         = $planbeneficioadicional['fechaactualizacion'];

    $valor     = " (
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

    $array_valores[] = $valor;

}

$valores = implode(",", $array_valores);
$insert = $insert.$valores;

if(ejecuta_insert($db_postgresql, $insert) == 0) 
{
    echo $insert;
    die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
}









// PLANES BENEFICIOS ADICIONALES PROVEEDORES(LUEGO) *******************************************************************************************************************************************************************************
echo '
Migrando Tabla: planesbeneficiosadicionalesproveedores...';

$planesbeneficiosadicionales = ejecuta_select($db_postgresql, "SELECT idplanbeneficioadicional FROM planesbeneficiosadicionales");

if($planesbeneficiosadicionales['cantidad'] > 0)
{
    $insert = "INSERT INTO planesbeneficiosadicionalesproveedores ( idplanbeneficioadicional, idproveedor, porcentajeriesgo ) VALUES ";

    $array_valores = array();

    foreach($planesbeneficiosadicionales['resultado'] as $planbeneficioadicional)
    {
        $idplanbeneficioadicional                     = $planbeneficioadicional['idplanbeneficioadicional'];

        $valor     = " (
                            $idplanbeneficioadicional, 
                            2,
                            100
                        )";

        $array_valores[] = $valor;

    }

    $valores = implode(",", $array_valores);
    $insert = $insert.$valores;
   

    if(ejecuta_insert($db_postgresql, $insert) == 0) 
    {
        echo $insert;
        die( "Error al ejecutar la consulta: " . pg_last_error($db_postgresql));
    }
}






  

    $hora_fin   = date('h:i:s', time());  




    die( "Proceso Terminado ". $hora_fin . pg_last_error($db_postgresql));
   



?>