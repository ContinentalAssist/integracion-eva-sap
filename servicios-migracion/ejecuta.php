<?php
    include('./lib/funciones.php');
    include('./lib/mysql.php');
    include('./lib/pgsql.php');

    $db_postgresql      = getDB();
    $db_mysql           = connect_db();



    // NORMALIZA Y ASIGNA PLANES BLOQUEADOS PERSONALIZADOS
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

        $insert_planesagencias  = "INSERT INTO planesagencias ( idplan, idagencia ) VALUES ";
        $array_valores          = array();

        foreach($planes_bloqueados as $agencia)
        {
            $idagencia = $agencia['idagencia'];

            foreach($agencia['planes'] as $idplan)
            {
                $cantidad = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planesagencias WHERE idplan = $idplan AND idagencia = $idagencia", "cantidad");

                if($cantidad == 0)
                {
                    $valor = " ($idplan, $idagencia) ";
                    array_push($array_valores, $valor);
                }
            }
        }

        if(count($array_valores) > 0)
        {
            $valores                = implode(",", $array_valores);
            $insert_planesagencias  = $insert_planesagencias.$valores;
            if(!ejecuta_insert($db_postgresql, $insert_planesagencias))
            {
                echo  $insert_planesagencias; exit;
            }
        }
    
    


?>