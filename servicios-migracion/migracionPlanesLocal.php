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

        echo 'Borrando cuponesplanes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE cuponesplanes CASCADE");

        echo 'Borrando planesbeneficios...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficios CASCADE");

        echo 'Borrando planesbeneficiosproveedores...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficiosproveedores CASCADE");

        echo 'Borrando planesbeneficiosadicionales...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficiosadicionales CASCADE");

        echo 'Borrando planesbeneficiosadicionalesproveedores...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesbeneficiosadicionalesproveedores CASCADE");

        echo 'Borrando planesprecios...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesprecios CASCADE");

        echo 'Borrando planescostos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planescostos CASCADE");

        echo 'Borrando planesagencias...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesagencias CASCADE");

        echo 'Borrando planespaises...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planespaises CASCADE");

        echo 'Borrando planesfuentes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesfuentes CASCADE");

        echo 'Borrando planesorigenes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesorigenes CASCADE");

        echo 'Borrando planesdestinos...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planesdestinos CASCADE");

        echo 'Borrando planes...';
        ejecuta_delete($db_postgresql, "TRUNCATE TABLE planes CASCADE");

        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE cuponesplanes_idcuponplan_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planes_idplan_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesprecios_idplanprecio_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planescostos_idplancosto_seq1 RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesagencias_idplanesagencias_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesbeneficios_idplanbeneficio_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesbeneficiosadicionales_idplanbeneficioadicional_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesbeneficiosadicionalesproveedores_idplanbeneficioadicionalproveedor_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planespaises_idplanpais_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesfuentes_idplanfuente_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesorigenes_idplanorigen_seq RESTART WITH 1");
        /**/ ejecuta_update($db_postgresql, "ALTER SEQUENCE planesdestinos_idplandestino_seq RESTART WITH 1");
    }

    // PLANES *******************************************************************************************************************************************************************************
        echo 'Migrando Planes ';
        
        $last_id_plan = ejecuta_select($db_postgresql, 'SELECT MAX(idplan) as idplan FROM planes ORDER BY idplan DESC', 'idplan');

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
                                                WHERE 1 = 1
                                                AND id IN (21,56,74,87,88,89,92,93,94,95,96,98,102,103,106,107,108,109,111,112,113,114,116,117,119,123,128,129,140,141,154,156,157,158,159,160,162,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,186,188,189,190,191,192,193,195,196,197,198,200,201,202,203,204,205,206,207,208,213,214,215,216,225,239,240,245,246,247,248,249,250,251,253,254,255,256,257,258,259,260,261,263,265,267,269,270,272,273,275,408,409,410,411,415,416,417,418,419,420,421,422,423,424,425,426,427,428,429,443,444,445,446,447,449,454,455,460,466,467,468,469,470,471,472,473,474,475,476,477,478,479,480,481,482,483,484,485,486,487,488,489,490,491,492,493,494,495,496,497,498,499,503,504,555,558,610,630,646,647,649,650,660,661,665,669,670,671,672,679,680,704,707,708,731,733,734,735,736,737,738,739,740,741,742,743,744,745,746,747,748,753,754,852,856,857,858,859,860,862,863,864,865,866,867,868,869,870,871,872,873,874,875,876,877,878,879,880,881,882,883,900,901,902,903,904,905,906,907,908,909,910,911,912,913,914,915,916,917,918,919,920,921,922,923,924,925,926,927,928,966,968,974,979,980,981,983,984,985,986,987,988,989,990,991,992,993,994,995,996,997,998,999,1000,1001,1002,1003,1004,1005,1006,1007,1008,1009,1010,1011,1012,1013,1014,1015,1016,1017,1018,1019,1022,1023,1024,1025,1026,1027,1038,1039,1040,1041,1042,1043,1049,1055,1063,1065,1066,1070,1071,1076,1077,1078,1079,1080,1081,1083,1085,1086,1087,1088,1089,1090,1091,1092,1093,1094,1095,1096,1097,1098,1099,1100,1101,1102,1103,1104,1105,1106,1107,1122,1125,1130,1132,1144,1149,1150,1153,1154,1155,1156,1157,1158,1159,1161,1164,1167,1168,1172,1173,1180,1204,1205,1207,1216,1218,1219,1220,1221,1239,1241,1243,1244,1246,1254,1256,1258,1259,1260,1261,1277,1282,1291,1293,1299,1300,1306,1308,1309,1310,1311,1312,1345,1351,1352,1358,1359,1361,1377,1383,1386,1387,1388,1389,1399,1400,1401,1404,1406,1411,1412,1414,1416,1421,1424,1431,1451,1452,1454,1455,1465,1478,1481,1486,1492,1495,1496,1501,1503,1504,1505,1509,1514,1521,1522,1523,1524,1529,1530,1536,1537,1538,1543,1599,1600,1610,1615,1626,1644,1645,1646,1649,1658,1677,1678,1696,1697,1698,1699,1700,1701,1702,1703,1704,1705,1713,1715,1716,1717,1719,1720,1721,1722,1723,1724,1725,1726,1727,1728,1729,1730,1731,1732,1733,1734,1735,1736,1737,1738,1739,1740,1741,1742,1743,1744,1745,1746,1747,1748,1749,1751,1752,1753,1760,1761,1766,1772,1774,1775,1776,1778,1781,1787,1788,1790,1791,1795,1796,1802,1805,1807,1810,1811,1812,1817,1819,1820,1826,1843,1844,1845,1851,1852,1853,1854,1855,1858,1859,1861,1862,1863,1864,1865,1869,1870,1871,1872,1873,1874,1878,1879,1880,1894,1895,1910,1912,1914,1920,1921,1924,1925,1926,1927,1928,1929,1930,1931,1932,1934,1940,1941,1942,1944,1945,1949,1950,1951,1952,1953,1954,1955,1956,1957,1958,1961,1967,1968,1969,1972,1973,1974,1976,1977,1978,1979,1980,1981,1987,1988,1989,1990,1991,1992,1993,1994,1995,1996,1997,1998,1999,2000,2001,2002,2003,2004,2005,2006,2007,2008,2009,2011,2017,2018,2019,2020,2021,2022,2023,2025,2026,2027,2030,2031,2032,2033,2038,2039,2040,2041,2042,2043,2044,2045,2047,2048,2049,2050,2051,2052,2053,2054,2055,2056,2057,2058,2059,2060,2061,2062,2063,2064,2065,2066,2067,2068,2069,2070,2071,2072,2073,2074,2075,2076,2079,2082,2083,2084,2085,2086,2087,2088,2089,2090,2091,2095,2096,2097,2105,2106,2107,2108,2109,2110,2111,2112,2114,2115,2117,2118,2119,2121,2123,2124,2125,2127,2128,2129,2130,2132,2133,2134,2137,2138,2139,2140,2141,2142,2143,2144,2151,2152,2155,2159,2160,2161,2162,2163,2164,2165,2168,2169,2170,2171,2173,2174,2175,2176,2177,2178,2179,2180,2181,2183,2184,2185,2186,2187,2188,2191,2192,2193,2194,2195,2197,2202,2204,2205,2206,2207,2208,2209,2210,2211,2212,2213,2214,2215,2216,2218,2221,2222,2223,2225,2226,2227,2228,2229,2230,2231,2234,2235,2236,2237,2238,2239,2240,2241,2243,2245,2246,2247,2248,2249,2250,2251,2252,2253,2255,2256,2259,2260,2262,2263,2264,2266,2267,2268,2269,2270,2271,2272,2273,2274,2275,2276,2278,2279,2280,2281,2282,2283,2284,2285,2286,2287,2288,2289,2290,2291,2292,2293,2294,2295,2300,2301,2302,2303,2304,2305,2306,2307,2308,2309,2310,2311,2312,2313,2314,2315,2316,2317,2318,2319,2320,2321,2322,2323,2324,2325,2326,2327,2328,2329,2330,2331,2332,2333,2334,2335,2336,2337,2338,2339,2340,2341,2342,2343,2344,2345,2346,2347,2348,2349,2350,2351,2352,2353,2354,2355,2356,2357,2358,2359,2360,2361,2362,2363,2364,2370,2371,2372,2373,2374,2375,2376,2383,2385,2386,2387,2388,2391,2392,2393,2394,2395,2396,2397,2398,2399,2400,2401,2402,2403,2404,2405,2406,2408,2409,2410,2411,2412,2413,2414,2416,2417,2418,2419,2420,2421,2422,2423,2425,2426,2427,2428,2429,2430,2431,2432,2433,2434,2435,2436,2437,2438,2439,2440,2441,2443,2444,2445,2447,2448,2449,2450,2451,2452,2454,2455,2456,2458,2459,2460,2461,2462,2463,2465,2466,2467,2468,2469,2470,2471,2472,2473,2474,2475,2476,2477,2478,2479,2480,2483,2484,2485,2486,2487,2488,2489,2490,2491,2492,2493,2496,2497,2498,2503,2504,2505,2506,2507,2508,2509,2510,2511,2512,2513,2514,2515,2516,2517,2518,2519,2520,2521,2522,2523,2524,2525,2526,2527,2528,2529,2530,2531,2532,2533,2534,2535,2536,2537,2538,2539,2540,2541,2542,2543,2544,2545,2546,2547,2548,2549,2550,2551,2552,2553,2554,2555,2556,2557,2558,2559,2560,2561,2562,2563,2564,2565,2566,2567,2568,2569,2570,2571,2572,2573,2574,2575,2576,2577,2578,2579,2580,2581,2582,2583,2586,2587,2588,2589,2590,2591,2592,2595,2596,2597,2598,2599,2600,2601,2602,2603,2604,2605,2608,2609,2610,2613,2614,2615,2616,2617,2618,2619,2620,2621,2622,2623,2624,2625,2626,2627,2628,2629,2630,2631,2632,2633,2634,2637,2638,2639,2640,2641,2642,2643,2644,2645,2646,2647,2648,2649,2650,2651,2652,2653,2654,2655,2656,2657,2658,2659,2660,2661,2662,2663,2664,2665,2666,2667,2668,2669,2670,2671,2672,2673,2674,2675,2676,2677,2678,2679,2680,2681,2682,2683,2684,2685,2686,2687,2688,2689,2690,2691,2692,2693,2694,2695,2696,2697,2698,2699,2700,2701,2702,2703,2704,2705,2706,2707,2708,2709,2711,2713,2714,2715,2716,2717,2718,2719,2721,2722,2723,2724,2725,2726,2729,2730,2731,2732,2733,2734,2735,2736,2737,2738,2739,2745,2747,2748,2749,2750,2751,2752,2753,2754,2755,2757,2758,2759,2760,2761,2762,2763,2764,2765,2766,2767,2768,2769,2770,2771,2772,2773,2775,2776,2778,2779,2780,2781,2782,2783,2784,2785,2786,2788,2789,2791,2793,2794,2795,2796,2797,2798,2800,2801,2802,2803,2805,2806,2807,2808,2809,2810,2811,2812,2813,2814,2815,2816,2817,2818,2819,2820,2821,2824,2825,2826,2827,2828,2829,2831,2832,2833,2836,2837,2838,2839,2840,2841,2843,2844,2845,2846,2850,2854,2855,2856,2861,2865,2866,2867,2868,2869,2870,2871,2872,2874,2875,2876,2877,2878,2879,2880,2883,2884,2885,2886,2887,2896,2901,2902)
                                                ORDER BY id ASC 
                                                ");

        while ($row = $mysql_plans->fetch_array(MYSQLI_ASSOC)) 
        {
            $plans[] = $row;
        }

        foreach($plans as $plan)
        {
            $idplan = $plan['id'];

            echo 'Plan:'.$idplan.'----'; 

            $paises = array(
                array("idpais" => 283, "idplan" => 249, "sustituido_por" => 249),
                array("idpais" => 283, "idplan" => 255, "sustituido_por" => 255),
                array("idpais" => 283, "idplan" => 256, "sustituido_por" => 256),
                array("idpais" => 283, "idplan" => 253, "sustituido_por" => 253),
                array("idpais" => 283, "idplan" => 259, "sustituido_por" => 259),
                array("idpais" => 283, "idplan" => 260, "sustituido_por" => 260),
                array("idpais" => 283, "idplan" => 254, "sustituido_por" => 254),
                array("idpais" => 283, "idplan" => 496, "sustituido_por" => 496),
                array("idpais" => 283, "idplan" => 497, "sustituido_por" => 497),
                array("idpais" => 283, "idplan" => 251, "sustituido_por" => 251),
                array("idpais" => 283, "idplan" => 261, "sustituido_por" => 261),
                array("idpais" => 283, "idplan" => 208, "sustituido_por" => 208),
                array("idpais" => 283, "idplan" => 250, "sustituido_por" => 250),
                array("idpais" => 283, "idplan" => 257, "sustituido_por" => 257),
                array("idpais" => 283, "idplan" => 258, "sustituido_por" => 258),
                array("idpais" => 283, "idplan" => 1543, "sustituido_por" => 253),
                array("idpais" => 283, "idplan" => 2649, "sustituido_por" => 253),
                array("idpais" => 283, "idplan" => 2673, "sustituido_por" => 253),
                array("idpais" => 283, "idplan" => 2674, "sustituido_por" => 253),
                array("idpais" => 283, "idplan" => 2675, "sustituido_por" => 253),
                array("idpais" => 283, "idplan" => 2650, "sustituido_por" => 259),
                array("idpais" => 283, "idplan" => 2685, "sustituido_por" => 259),
                array("idpais" => 283, "idplan" => 2686, "sustituido_por" => 259),
                array("idpais" => 283, "idplan" => 2687, "sustituido_por" => 259),
                array("idpais" => 283, "idplan" => 2651, "sustituido_por" => 260),
                array("idpais" => 283, "idplan" => 2697, "sustituido_por" => 260),
                array("idpais" => 283, "idplan" => 2698, "sustituido_por" => 260),
                array("idpais" => 283, "idplan" => 2699, "sustituido_por" => 260),
                array("idpais" => 283, "idplan" => 2655, "sustituido_por" => 254),
                array("idpais" => 283, "idplan" => 2679, "sustituido_por" => 254),
                array("idpais" => 283, "idplan" => 2681, "sustituido_por" => 254),
                array("idpais" => 283, "idplan" => 2680, "sustituido_por" => 254),
                array("idpais" => 283, "idplan" => 2656, "sustituido_por" => 496),
                array("idpais" => 283, "idplan" => 2691, "sustituido_por" => 496),
                array("idpais" => 283, "idplan" => 2692, "sustituido_por" => 496),
                array("idpais" => 283, "idplan" => 2693, "sustituido_por" => 496),
                array("idpais" => 283, "idplan" => 2657, "sustituido_por" => 497),
                array("idpais" => 283, "idplan" => 2703, "sustituido_por" => 497),
                array("idpais" => 283, "idplan" => 2704, "sustituido_por" => 497),
                array("idpais" => 283, "idplan" => 2705, "sustituido_por" => 497),
                array("idpais" => 283, "idplan" => 2652, "sustituido_por" => 251),
                array("idpais" => 283, "idplan" => 2676, "sustituido_por" => 251),
                array("idpais" => 283, "idplan" => 2677, "sustituido_por" => 251),
                array("idpais" => 283, "idplan" => 2678, "sustituido_por" => 251),
                array("idpais" => 283, "idplan" => 2653, "sustituido_por" => 261),
                array("idpais" => 283, "idplan" => 2688, "sustituido_por" => 261),
                array("idpais" => 283, "idplan" => 2689, "sustituido_por" => 261),
                array("idpais" => 283, "idplan" => 2690, "sustituido_por" => 261),
                array("idpais" => 283, "idplan" => 2654, "sustituido_por" => 208),
                array("idpais" => 283, "idplan" => 2700, "sustituido_por" => 208),
                array("idpais" => 283, "idplan" => 2701, "sustituido_por" => 208),
                array("idpais" => 283, "idplan" => 2702, "sustituido_por" => 208),
                array("idpais" => 283, "idplan" => 2641, "sustituido_por" => 250),
                array("idpais" => 283, "idplan" => 2670, "sustituido_por" => 250),
                array("idpais" => 283, "idplan" => 2671, "sustituido_por" => 250),
                array("idpais" => 283, "idplan" => 2672, "sustituido_por" => 250),
                array("idpais" => 283, "idplan" => 2642, "sustituido_por" => 257),
                array("idpais" => 283, "idplan" => 2682, "sustituido_por" => 257),
                array("idpais" => 283, "idplan" => 2683, "sustituido_por" => 257),
                array("idpais" => 283, "idplan" => 2684, "sustituido_por" => 257),
                array("idpais" => 283, "idplan" => 2643, "sustituido_por" => 258),
                array("idpais" => 283, "idplan" => 2694, "sustituido_por" => 258),
                array("idpais" => 283, "idplan" => 2695, "sustituido_por" => 258),
                array("idpais" => 283, "idplan" => 2696, "sustituido_por" => 258),
                array("idpais" => 283, "idplan" => 1994, "sustituido_por" => 249),
                array("idpais" => 283, "idplan" => 1995, "sustituido_por" => 255),
                array("idpais" => 283, "idplan" => 2000, "sustituido_por" => 253),
                array("idpais" => 283, "idplan" => 2003, "sustituido_por" => 251),
                array("idpais" => 283, "idplan" => 2004, "sustituido_por" => 261),
                array("idpais" => 283, "idplan" => 1997, "sustituido_por" => 250),
                array("idpais" => 283, "idplan" => 1998, "sustituido_por" => 257),
                array("idpais" => 283, "idplan" => 1999, "sustituido_por" => 258),
                array("idpais" => 283, "idplan" => 492, "sustituido_por" => 492),
                array("idpais" => 283, "idplan" => 493, "sustituido_por" => 493),
                array("idpais" => 283, "idplan" => 245, "sustituido_por" => 245),
                array("idpais" => 283, "idplan" => 247, "sustituido_por" => 247),
                array("idpais" => 283, "idplan" => 248, "sustituido_por" => 248),
                array("idpais" => 283, "idplan" => 246, "sustituido_por" => 246),
                array("idpais" => 283, "idplan" => 1122, "sustituido_por" => 1122),
                array("idpais" => 283, "idplan" => 1920, "sustituido_por" => 1920),
                array("idpais" => 283, "idplan" => 1958, "sustituido_por" => 1958),
                array("idpais" => 283, "idplan" => 1310, "sustituido_por" => 272),
                array("idpais" => 283, "idplan" => 1308, "sustituido_por" => 267),
                array("idpais" => 283, "idplan" => 2187, "sustituido_por" => 270),
                array("idpais" => 283, "idplan" => 1300, "sustituido_por" => 272),
                array("idpais" => 283, "idplan" => 1311, "sustituido_por" => 270),
                array("idpais" => 283, "idplan" => 630, "sustituido_por" => 630),
                array("idpais" => 283, "idplan" => 1844, "sustituido_por" => 1844),
                array("idpais" => 283, "idplan" => 1843, "sustituido_por" => 1843),
                array("idpais" => 283, "idplan" => 1168, "sustituido_por" => 269),
                array("idpais" => 283, "idplan" => 2079, "sustituido_por" => 2079),
                array("idpais" => 283, "idplan" => 1945, "sustituido_por" => 1945),
                array("idpais" => 283, "idplan" => 1167, "sustituido_por" => 267),
                array("idpais" => 283, "idplan" => 1312, "sustituido_por" => 1312),
                array("idpais" => 283, "idplan" => 1306, "sustituido_por" => 270),
                array("idpais" => 283, "idplan" => 2225, "sustituido_por" => 2225),
                array("idpais" => 283, "idplan" => 1978, "sustituido_por" => 1978),
                array("idpais" => 283, "idplan" => 2188, "sustituido_por" => 272),
                array("idpais" => 283, "idplan" => 2186, "sustituido_por" => 269),
                array("idpais" => 283, "idplan" => 1309, "sustituido_por" => 269),
                array("idpais" => 283, "idplan" => 1351, "sustituido_por" => 1351),
                array("idpais" => 283, "idplan" => 1934, "sustituido_por" => 1934),
                array("idpais" => 283, "idplan" => 2632, "sustituido_por" => 2632),
                array("idpais" => 283, "idplan" => 2633, "sustituido_por" => 2633),
                array("idpais" => 283, "idplan" => 1967, "sustituido_por" => 1967),
                array("idpais" => 283, "idplan" => 2239, "sustituido_por" => 267),
                array("idpais" => 283, "idplan" => 2240, "sustituido_por" => 269),
                array("idpais" => 283, "idplan" => 2241, "sustituido_por" => 267),
                array("idpais" => 283, "idplan" => 2142, "sustituido_por" => 2142),
                array("idpais" => 283, "idplan" => 1845, "sustituido_por" => 1845),
                array("idpais" => 283, "idplan" => 1649, "sustituido_por" => 267),
                array("idpais" => 283, "idplan" => 275, "sustituido_por" => 275),
                array("idpais" => 283, "idplan" => 267, "sustituido_por" => 267),
                array("idpais" => 283, "idplan" => 270, "sustituido_por" => 270),
                array("idpais" => 283, "idplan" => 273, "sustituido_por" => 273),
                array("idpais" => 283, "idplan" => 272, "sustituido_por" => 272),
                array("idpais" => 283, "idplan" => 269, "sustituido_por" => 269),
                array("idpais" => 283, "idplan" => 852, "sustituido_por" => 852),
                array("idpais" => 283, "idplan" => 2249, "sustituido_por" => 267),
                array("idpais" => 283, "idplan" => 2250, "sustituido_por" => 269),
                array("idpais" => 283, "idplan" => 2251, "sustituido_por" => 270),
                array("idpais" => 283, "idplan" => 2252, "sustituido_por" => 272),
                array("idpais" => 283, "idplan" => 2638, "sustituido_por" => 270),
                array("idpais" => 283, "idplan" => 2661, "sustituido_por" => 270),
                array("idpais" => 283, "idplan" => 2662, "sustituido_por" => 270),
                array("idpais" => 283, "idplan" => 2663, "sustituido_por" => 270),
                array("idpais" => 283, "idplan" => 2640, "sustituido_por" => 273),
                array("idpais" => 283, "idplan" => 2667, "sustituido_por" => 273),
                array("idpais" => 283, "idplan" => 2668, "sustituido_por" => 273),
                array("idpais" => 283, "idplan" => 2669, "sustituido_por" => 273),
                array("idpais" => 283, "idplan" => 2639, "sustituido_por" => 272),
                array("idpais" => 283, "idplan" => 2664, "sustituido_por" => 272),
                array("idpais" => 283, "idplan" => 2665, "sustituido_por" => 272),
                array("idpais" => 283, "idplan" => 2666, "sustituido_por" => 272),
                array("idpais" => 283, "idplan" => 2637, "sustituido_por" => 269),
                array("idpais" => 283, "idplan" => 2658, "sustituido_por" => 269),
                array("idpais" => 283, "idplan" => 2659, "sustituido_por" => 269),
                array("idpais" => 283, "idplan" => 2660, "sustituido_por" => 269),
                array("idpais" => 283, "idplan" => 1990, "sustituido_por" => 267),
                array("idpais" => 283, "idplan" => 1992, "sustituido_por" => 270),
                array("idpais" => 283, "idplan" => 1993, "sustituido_por" => 272),
                array("idpais" => 283, "idplan" => 1991, "sustituido_por" => 269),
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
                array("idpais" => 283,"idplan" => 647,"sustituido_por" => 647),
                array("idpais" => 11,"idplan" => 704,"sustituido_por" => 704),
                array("idpais" => 5,"idplan" => 704,"sustituido_por" => 704),
                array("idpais" => 283,"idplan" => 704,"sustituido_por" => 704),
                array("idpais" => 11,"idplan" => 707,"sustituido_por" => 707),
                array("idpais" => 5,"idplan" => 707,"sustituido_por" => 707),
                array("idpais" => 283,"idplan" => 707,"sustituido_por" => 707),
                array("idpais" => 11,"idplan" => 708,"sustituido_por" => 708),
                array("idpais" => 5,"idplan" => 708,"sustituido_por" => 708),
                array("idpais" => 283,"idplan" => 708,"sustituido_por" => 708),
                array("idpais" => 11,"idplan" => 2775,"sustituido_por" => 2775),
                array("idpais" => 5,"idplan" => 2775,"sustituido_por" => 2775),
                array("idpais" => 283,"idplan" => 2775,"sustituido_por" => 2775),
                array("idpais" => 11,"idplan" => 2831,"sustituido_por" => 2831),
                array("idpais" => 5,"idplan" => 2831,"sustituido_por" => 2831),
                array("idpais" => 283,"idplan" => 2831,"sustituido_por" => 2831),
                array("idpais" => 11,"idplan" => 2870,"sustituido_por" => 2870),
                array("idpais" => 5,"idplan" => 2870,"sustituido_por" => 2870),
                array("idpais" => 283,"idplan" => 2870,"sustituido_por" => 2870)
            );

            foreach($paises as $pais)
            {
                if($pais['idplan'] == $idplan || $pais['sustituido_por'] == $idplan)
                {
                    $idpais = $pais['idpais'];
                    $idplan = $pais['sustituido_por'];

                    $cantidad = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planes WHERE idplan = $idplan", "cantidad");

                    if($cantidad == 0)
                    {
                        $nombreplan                                 = $plan['name'];
                        $familiaplan                                = $plan['description'];
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
                        $idpopularidad                              = $plan['id_popularidad'];
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

                        $insert = "INSERT INTO planes (
                                                    idplan,
                                                    nombreplan, 
                                                    idstatus, 
                                                    idcategoria, 
                                                    tiempominimo, 
                                                    tiempomaximo, 
                                                    edadminima, 
                                                    edadmaxima, 
                                                    edadprecioincremento, 
                                                    planfamiliar, 
                                                    factorpenalizacionedad, 
                                                    factorbeneficiofamiliar, 
                                                    idmonedapago, 
                                                    idmonedacobertura, 
                                                    fechacreacion, 
                                                    fechamodificacion, 
                                                    idpopularidad, 
                                                    edadmaximabeneficiosadic, 
                                                    descripcionplan, 
                                                    descripcionplanen, 
                                                    idtipoasistencia, 
                                                    fechaactualizacionprecioscostos, 
                                                    fechaactualizacionbeneficios, 
                                                    fechaactualizacionbeneficiosadicionales, 
                                                    fechaactualizacionbeneficiosproveedores, 
                                                    publico,
                                                    familiaplan)
                                                VALUES(
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
                                                    UPPER('$familiaplan')
                                                    )";

                        if(!ejecuta_insert($db_postgresql, $insert))
                        {
                            echo $insert;
                        }

                        
                    }
                   
                    $idpais = ($idpais == 0) ? 283 : $idpais;

                    $cantidad_planespaises = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planespaises WHERE idplan = $idplan AND idpais = $idpais", "cantidad");

                    if($cantidad_planespaises == 0)
                    {
                        $insert     = "INSERT INTO planespaises (
                                                idplan, 
                                                idpais
                                            )
                                        VALUES
                                            (
                                                $idplan, 
                                                $idpais
                                            )";

                        if(!ejecuta_insert($db_postgresql, $insert))
                        {
                            echo $insert;
                        }
                    }

                    $cantidad_precios = ejecuta_select($db_postgresql, "SELECT count(*) as cantidad FROM planesprecios WHERE idplan = $idplan AND idpais = $idpais", "cantidad");

                    if($cantidad_precios == 0)
                    {
                        $mysql_precios  = array();
                        $precios        = array();

                        $select = "SELECT * FROM precios WHERE id_plan = '$idplan' ORDER BY id ASC";

                        $mysql_precios = $db_mysql->query($select);

                        while ($row_precio = $mysql_precios->fetch_array(MYSQLI_ASSOC)) 
                        { 
                            $precios[] = $row_precio; 
                        }

                        if(count($precios) > 0)
                        {
                            $insert_planesprecios 	= "INSERT INTO planesprecios ( idplan, dia, precio, idpais, fechaactualizacion ) VALUES ";
                            $insert_planescostos1 	= "INSERT INTO planescostos ( idplan, idproveedor, dia, costo, idpais, fechaactualizacion ) VALUES ";
                            $insert_planescostos2 	= "INSERT INTO planescostos ( idplan, idproveedor, dia, costo, idpais, fechaactualizacion ) VALUES ";
                            
                            $array_valores_planesprecios 	= array();
                            $array_valores_planescostos1 	= array();
                            $array_valores_planescostos2 	= array();

                            foreach($precios as $registro)
                            {    
                                $dia        = $registro['dias'];
                                $precio     = $registro['precio'];
                                $costo1     = ($registro['costo1'] > 0) ? $registro['costo1'] : 0;
                                $costo2     = ($registro['costo2'] > 0) ? $registro['costo2'] : 0;
                                $idpais     = ($idpais == 0) ? 283 : $idpais;

                                array_push($array_valores_planesprecios, "( $idplan, $dia, $precio, $idpais, '2000-01-01 00:00:00')");
                                array_push($array_valores_planescostos1, "( $idplan, 1, $dia, $costo1, $idpais, '2000-01-01 00:00:00')");
                                array_push($array_valores_planescostos2, "( $idplan, 2, $dia, $costo2, $idpais, '2000-01-01 00:00:00')");
                            }

                            $valores 				= implode(",", $array_valores_planesprecios);
                            $insert_planesprecios 	= $insert_planesprecios.$valores;

                            $valores 				= implode(",", $array_valores_planescostos1);
                            $insert_planescostos1 	= $insert_planescostos1.$valores;

                            $valores 				= implode(",", $array_valores_planescostos2);
                            $insert_planescostos2 	= $insert_planescostos2.$valores;

                            ejecuta_insert($db_postgresql, $insert_planesprecios);
                            ejecuta_insert($db_postgresql, $insert_planescostos1);
                            ejecuta_insert($db_postgresql, $insert_planescostos2);
                        }
                    }
                }
            }
        }

        $secuencia = $idplan + 1;
        $secuencia = "ALTER SEQUENCE planes_idplan_seq RESTART WITH ".$secuencia; 
        ejecuta_select($db_postgresql, $secuencia);

    // PLANES AGENCIAS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: Planes Agencias';

        $mysql_planes_agencias = $db_mysql->query("SELECT 
                                                    DISTINCT producto, 
                                                    programaplan, 
                                                    agencia 
                                                FROM orders 
                                                    JOIN plans ON plans.id = orders.producto 
                                                    JOIN broker ON broker.id_broker = orders.agencia 
                                                WHERE 1 = 1
                                                AND plans.id IN (21,56,74,87,88,89,92,93,94,95,96,98,102,103,106,107,108,109,111,112,113,114,116,117,119,123,128,129,140,141,154,156,157,158,159,160,162,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,186,208,225,239,240,245,246,247,248,249,250,251,253,254,255,256,257,258,259,260,261,267,269,270,272,273,275,492,493,496,497,555,558,610,630,646,647,649,650,660,661,665,669,670,671,672,679,680,704,707,708,753,754,852,966,968,974,979,980,981,1043,1049,1055,1063,1065,1066,1070,1071,1076,1077,1122,1125,1130,1132,1144,1161,1164,1180,1204,1205,1207,1216,1218,1219,1220,1221,1254,1256,1258,1259,1260,1261,1277,1282,1291,1293,1299,1312,1345,1351,1352,1358,1359,1361,1377,1381,1383,1386,1387,1388,1389,1399,1400,1401,1404,1406,1411,1412,1414,1416,1421,1424,1431,1451,1452,1454,1455,1465,1478,1481,1492,1495,1496,1501,1503,1504,1505,1509,1514,1521,1522,1523,1524,1529,1530,1536,1537,1538,1610,1615,1626,1644,1658,1677,1678,1696,1713,1748,1749,1751,1752,1753,1760,1761,1766,1772,1774,1775,1776,1778,1781,1787,1788,1790,1791,1795,1796,1802,1805,1807,1810,1811,1812,1817,1819,1820,1843,1844,1845,1851,1852,1853,1854,1855,1858,1859,1861,1862,1863,1864,1865,1869,1870,1871,1872,1873,1874,1894,1895,1910,1912,1914,1920,1921,1924,1925,1926,1927,1928,1929,1930,1931,1932,1934,1940,1941,1942,1944,1945,1949,1950,1951,1952,1953,1954,1955,1956,1957,1958,1961,1967,1968,1969,1972,1973,1974,1976,1977,1978,1979,1980,1981,1987,1988,1989,1996,2001,2002,2005,2006,2007,2008,2009,2011,2017,2018,2019,2020,2021,2022,2023,2025,2026,2027,2030,2031,2032,2033,2038,2039,2040,2041,2042,2043,2044,2045,2075,2076,2079,2082,2083,2084,2085,2086,2087,2097,2114,2115,2117,2118,2119,2121,2123,2124,2125,2127,2128,2129,2130,2132,2133,2134,2137,2138,2139,2140,2141,2142,2143,2144,2151,2152,2155,2162,2163,2164,2165,2173,2174,2175,2176,2177,2178,2179,2180,2181,2183,2184,2185,2191,2192,2193,2194,2195,2197,2202,2204,2205,2206,2207,2208,2209,2210,2211,2212,2214,2215,2216,2218,2221,2222,2223,2224,2225,2226,2227,2228,2229,2230,2231,2234,2235,2236,2238,2243,2245,2246,2247,2248,2253,2255,2256,2259,2260,2262,2263,2264,2266,2267,2268,2269,2270,2271,2272,2273,2274,2275,2276,2278,2279,2280,2281,2282,2283,2285,2286,2287,2288,2289,2290,2291,2292,2293,2294,2295,2300,2301,2356,2362,2363,2364,2374,2375,2376,2383,2386,2387,2388,2406,2408,2409,2410,2411,2412,2413,2414,2416,2417,2418,2419,2420,2421,2422,2423,2425,2426,2427,2428,2429,2430,2432,2433,2434,2435,2447,2448,2449,2450,2451,2452,2454,2455,2456,2460,2461,2462,2463,2465,2466,2467,2468,2469,2470,2471,2472,2473,2474,2475,2476,2489,2490,2491,2492,2493,2496,2497,2503,2505,2507,2510,2511,2512,2513,2514,2515,2516,2517,2518,2519,2520,2521,2522,2523,2524,2525,2526,2528,2529,2530,2531,2532,2533,2534,2536,2537,2544,2545,2546,2547,2548,2550,2551,2552,2553,2554,2555,2556,2557,2558,2559,2560,2561,2562,2563,2564,2565,2566,2567,2568,2571,2572,2573,2574,2575,2576,2577,2578,2579,2580,2581,2582,2583,2586,2587,2590,2591,2592,2595,2596,2597,2598,2599,2600,2601,2602,2603,2604,2605,2609,2610,2616,2617,2618,2619,2620,2621,2622,2626,2627,2628,2629,2630,2631,2632,2633,2634,2644,2645,2706,2707,2708,2709,2711,2713,2714,2715,2718,2719,2721,2722,2723,2724,2725,2726,2729,2730,2731,2732,2733,2734,2735,2736,2737,2738,2739,2745,2747,2748,2749,2750,2751,2752,2753,2754,2755,2757,2758,2759,2760,2761,2762,2763,2764,2765,2766,2767,2768,2769,2770,2771,2772,2773,2775,2776,2778,2779,2780,2781,2782,2783,2784,2785,2786,2788,2789,2791,2793,2794,2795,2796,2797,2798,2800,2801,2802,2803,2805,2806,2807,2808,2809,2810,2811,2812,2813,2814,2815,2816,2817,2818,2819,2820,2821,2824,2825,2826,2827,2828,2829,2831,2832,2833,2836,2837,2838,2839,2840,2841,2843,2844,2845,2846,2850,2854,2855,2856,2861,2865,2866,2867,2868,2869,2870,2871,2872,2874,2875,2876,2877,2878,2879,2880,2883,2884,2885,2886,2887,2896,2901,2902)
                                                ORDER BY producto, agencia ASC");

        while ($row = $mysql_planes_agencias->fetch_array(MYSQLI_ASSOC)) 
        {
            $planes_agencias[] = $row;
        }

        

        foreach($planes_agencias as $plan_agencia)
        {
            echo '(PA:'.$idplan.')';

            $insert_planesagencias              = "INSERT INTO planesagencias ( idplan, idagencia ) VALUES ";
            $insert_comisionesagencias          = "INSERT INTO comisionesagencias ( idagencia, idcategoria, idplan, comision ) VALUES ";
            $array_valores_planesagencias       = array();
            $array_valores_comisionesagencias   = array();

            $idplan          = $plan_agencia['producto'];
            $idagencia       = $plan_agencia['agencia'];
            $idcategoria     = $plan_agencia['programaplan'];

            array_push($array_valores_planesagencias, "( $idplan, $idagencia )");

            $existe_comision  = ejecuta_select($db_postgresql, "SELECT idcomisiones FROM comisionesagencias WHERE idagencia = $idagencia AND idcategoria = $idcategoria");

            if($existe_comision['cantidad'] == 0)
            {
                $mysql_comisiones = $db_mysql->query("SELECT porcentaje FROM commissions WHERE id_categoria = $idcategoria AND id_agencia = $idagencia LIMIT 1");

                while ($row = $mysql_comisiones->fetch_array(MYSQLI_ASSOC)) 
                {
                    $comisiones[] = $row;
                }

                if(count($comisiones) > 0)
                {
                    foreach($comisiones as $comision)
                    {
                        $porcentaje = $comision['porcentaje'];
    
                        array_push($array_valores_comisionesagencias, "( $idagencia, $idcategoria, NULL, $porcentaje )");
                    }
    
                    $valores 				    = implode(",", $array_valores_comisionesagencias);
                    $insert_comisionesagencias 	= $insert_comisionesagencias.$valores;
    
                    ejecuta_insert($db_postgresql, $insert_comisionesagencias);
                }

                $comisiones = array();
            }

            $valores 				    = implode(",", $array_valores_planesagencias);
            $insert_planesagencias 	    = $insert_planesagencias.$valores;

            ejecuta_insert($db_postgresql, $insert_planesagencias);

            
        }

        

        

    // // PLANES PAISES *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: Planes Paises';

    //     $mysql_planes_paises = $db_mysql->query("SELECT 
    //                                                 DISTINCT producto as idplan, 
    //                                                 plans.id_site as idpais 
    //                                             FROM orders 
    //                                                 JOIN plans ON plans.id = orders.producto 
    //                                             WHERE 1 = 1
    //                                             AND producto IN (21,56,74,87,88,89,92,93,94,95,96,98,102,103,106,107,108,109,111,112,113,114,116,117,119,123,128,129,140,141,154,156,157,158,159,160,162,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,208,225,239,240,245,246,247,248,249,250,251,253,254,255,256,257,258,259,260,261,267,269,270,272,273,275,492,493,496,497,555,558,630,646,649,650,660,661,665,669,670,671,672,679,680,753,754,852,966,968,979,980,981,1043,1049,1055,1063,1065,1066,1070,1071,1076,1077,1122,1125,1130,1132,1144,1161,1164,1180,1204,1205,1207,1216,1218,1219,1220,1221,1254,1256,1258,1259,1260,1261,1277,1282,1291,1293,1312,1351,1352,1358,1359,1361,1377,1381,1383,1386,1387,1388,1389,1399,1400,1401,1404,1406,1411,1412,1414,1416,1421,1424,1451,1452,1454,1455,1465,1481,1492,1495,1496,1501,1503,1504,1505,1514,1521,1522,1523,1524,1530,1536,1537,1538,1610,1615,1626,1644,1658,1677,1696,1748,1749,1751,1752,1753,1760,1761,1766,1772,1774,1775,1776,1781,1787,1788,1790,1791,1795,1796,1802,1805,1807,1810,1811,1812,1817,1819,1820,1843,1844,1845,1851,1852,1853,1854,1855,1858,1859,1861,1862,1863,1864,1865,1869,1870,1872,1873,1894,1895,1910,1912,1914,1920,1921,1924,1925,1926,1927,1928,1929,1930,1931,1932,1934,1940,1941,1942,1944,1945,1949,1950,1951,1952,1953,1954,1955,1956,1957,1958,1961,1967,1972,1973,1974,1976,1978,1979,1980,1981,1988,1989,1996,2002,2007,2008,2011,2017,2018,2020,2021,2022,2023,2025,2026,2027,2030,2031,2032,2033,2038,2039,2040,2041,2042,2043,2044,2045,2075,2076,2079,2082,2083,2085,2086,2087,2114,2115,2118,2119,2121,2123,2124,2125,2127,2128,2129,2130,2132,2133,2137,2138,2139,2140,2141,2142,2143,2144,2151,2152,2155,2162,2163,2164,2165,2173,2174,2175,2176,2177,2178,2179,2180,2181,2183,2184,2185,2202,2204,2205,2206,2207,2208,2209,2210,2211,2212,2214,2215,2216,2218,2221,2222,2223,2224,2225,2226,2227,2228,2229,2230,2231,2234,2235,2236,2238,2243,2245,2246,2247,2248,2253,2255,2256,2259,2260,2262,2263,2264,2266,2267,2268,2269,2270,2271,2272,2273,2274,2275,2276,2278,2279,2280,2281,2282,2283,2285,2286,2287,2288,2289,2290,2291,2292,2293,2294,2295,2300,2301,2356,2362,2363,2364,2374,2375,2376,2383,2386,2387,2388,2406,2408,2409,2410,2411,2412,2413,2414,2416,2417,2418,2419,2420,2421,2422,2423,2425,2426,2427,2428,2429,2430,2432,2433,2434,2435,2447,2448,2449,2450,2451,2452,2454,2455,2456,2460,2461,2462,2463,2465,2466,2467,2468,2469,2470,2471,2472,2473,2474,2475,2476,2489,2490,2491,2492,2493,2496,2497,2503,2505,2510,2511,2512,2513,2514,2515,2516,2517,2518,2519,2520,2521,2522,2523,2524,2525,2526,2528,2529,2530,2531,2532,2533,2534,2536,2537,2544,2545,2546,2547,2548,2550,2551,2552,2553,2554,2555,2556,2557,2558,2559,2560,2561,2562,2563,2564,2565,2566,2567,2568,2571,2572,2574,2575,2576,2577,2578,2579,2580,2581,2582,2583,2586,2587,2590,2591,2592,2595,2596,2597,2598,2599,2600,2601,2602,2603,2604,2605,2609,2610,2616,2617,2618,2619,2620,2621,2622,2626,2627,2628,2629,2630,2631,2632,2633,2634,2644,2645,2706,2707,2708,2709,2711,2713,2714,2715,2718,2719,2721,2722,2723,2724,2725,2726,2729,2730,2731,2732,2733,2734,2735,2736,2737,2738,2739,2745,2747,2748,2749,2750,2751,2752,2753,2754,2755,2757,2758,2759,2760,2761,2762,2763,2764,2765,2766,2767,2768,2769,2770,2771,2772,2773,2776,2778,2779,2780,2781,2782,2783,2784,2785,2786,2788,2789,2791,2793,2794,2795,2796,2797,2798,2800,2801,2802,2803,2805,2806,2807,2808,2809,2810,2811,2812,2813,2814,2815,2816,2817,2818,2819,2820,2821,2824,2825,2826,2827,2828,2829,2832,2833,2836,2837,2838,2839,2840,2841,2843,2844,2845,2846,2850,2854,2855,2856,2861,2865,2866,2867,2868,2869,2871,2872,2874,2875,2876,2877,2878,2879,2880,2883,2884,2885,2886,2887,2896,2901,2902)
    //                                             ORDER BY producto ASC");

    //     while ($row = $mysql_planes_paises->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $planes_paises[] = $row;
    //     }

    //     foreach($planes_paises as $plan_pais)
    //     {
    //         echo '(pp)';

    //         $idplan  = $plan_pais['idplan'];
    //         $idpais  = $plan_pais['idpais'];

    //         $insert     = "INSERT INTO planespaises (
    //                                 idplan, 
    //                                 idpais
    //                             )
    //                         VALUES
    //                             (
    //                                 $idplan, 
    //                                 $idpais
    //                             )";

    //         if(ejecuta_insert($db_postgresql, $insert))
    //         {

    //         }
    //         else
    //         {
    //             echo $insert;
    //         }
    //     }


    //PLANES FUENTES *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: Planes Fuentes';

        $mysql_planes = $db_mysql->query("SELECT 
                                            DISTINCT producto as idplan 
                                        FROM orders
                                        WHERE 1 = 1
                                        AND producto IN (21,56,74,87,88,89,92,93,94,95,96,98,102,103,106,107,108,109,111,112,113,114,116,117,119,123,128,129,140,141,154,156,157,158,159,160,162,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,186,208,225,239,240,245,246,247,248,249,250,251,253,254,255,256,257,258,259,260,261,267,269,270,272,273,275,492,493,496,497,555,558,610,630,646,647,649,650,660,661,665,669,670,671,672,679,680,704,707,708,753,754,852,966,968,974,979,980,981,1043,1049,1055,1063,1065,1066,1070,1071,1076,1077,1122,1125,1130,1132,1144,1161,1164,1180,1204,1205,1207,1216,1218,1219,1220,1221,1254,1256,1258,1259,1260,1261,1277,1282,1291,1293,1299,1312,1345,1351,1352,1358,1359,1361,1377,1381,1383,1386,1387,1388,1389,1399,1400,1401,1404,1406,1411,1412,1414,1416,1421,1424,1431,1451,1452,1454,1455,1465,1478,1481,1492,1495,1496,1501,1503,1504,1505,1509,1514,1521,1522,1523,1524,1529,1530,1536,1537,1538,1610,1615,1626,1644,1658,1677,1678,1696,1713,1748,1749,1751,1752,1753,1760,1761,1766,1772,1774,1775,1776,1778,1781,1787,1788,1790,1791,1795,1796,1802,1805,1807,1810,1811,1812,1817,1819,1820,1843,1844,1845,1851,1852,1853,1854,1855,1858,1859,1861,1862,1863,1864,1865,1869,1870,1871,1872,1873,1874,1894,1895,1910,1912,1914,1920,1921,1924,1925,1926,1927,1928,1929,1930,1931,1932,1934,1940,1941,1942,1944,1945,1949,1950,1951,1952,1953,1954,1955,1956,1957,1958,1961,1967,1968,1969,1972,1973,1974,1976,1977,1978,1979,1980,1981,1987,1988,1989,1996,2001,2002,2005,2006,2007,2008,2009,2011,2017,2018,2019,2020,2021,2022,2023,2025,2026,2027,2030,2031,2032,2033,2038,2039,2040,2041,2042,2043,2044,2045,2075,2076,2079,2082,2083,2084,2085,2086,2087,2097,2114,2115,2117,2118,2119,2121,2123,2124,2125,2127,2128,2129,2130,2132,2133,2134,2137,2138,2139,2140,2141,2142,2143,2144,2151,2152,2155,2162,2163,2164,2165,2173,2174,2175,2176,2177,2178,2179,2180,2181,2183,2184,2185,2191,2192,2193,2194,2195,2197,2202,2204,2205,2206,2207,2208,2209,2210,2211,2212,2214,2215,2216,2218,2221,2222,2223,2224,2225,2226,2227,2228,2229,2230,2231,2234,2235,2236,2238,2243,2245,2246,2247,2248,2253,2255,2256,2259,2260,2262,2263,2264,2266,2267,2268,2269,2270,2271,2272,2273,2274,2275,2276,2278,2279,2280,2281,2282,2283,2285,2286,2287,2288,2289,2290,2291,2292,2293,2294,2295,2300,2301,2356,2362,2363,2364,2374,2375,2376,2383,2386,2387,2388,2406,2408,2409,2410,2411,2412,2413,2414,2416,2417,2418,2419,2420,2421,2422,2423,2425,2426,2427,2428,2429,2430,2432,2433,2434,2435,2447,2448,2449,2450,2451,2452,2454,2455,2456,2460,2461,2462,2463,2465,2466,2467,2468,2469,2470,2471,2472,2473,2474,2475,2476,2489,2490,2491,2492,2493,2496,2497,2503,2505,2507,2510,2511,2512,2513,2514,2515,2516,2517,2518,2519,2520,2521,2522,2523,2524,2525,2526,2528,2529,2530,2531,2532,2533,2534,2536,2537,2544,2545,2546,2547,2548,2550,2551,2552,2553,2554,2555,2556,2557,2558,2559,2560,2561,2562,2563,2564,2565,2566,2567,2568,2571,2572,2573,2574,2575,2576,2577,2578,2579,2580,2581,2582,2583,2586,2587,2590,2591,2592,2595,2596,2597,2598,2599,2600,2601,2602,2603,2604,2605,2609,2610,2616,2617,2618,2619,2620,2621,2622,2626,2627,2628,2629,2630,2631,2632,2633,2634,2644,2645,2706,2707,2708,2709,2711,2713,2714,2715,2718,2719,2721,2722,2723,2724,2725,2726,2729,2730,2731,2732,2733,2734,2735,2736,2737,2738,2739,2745,2747,2748,2749,2750,2751,2752,2753,2754,2755,2757,2758,2759,2760,2761,2762,2763,2764,2765,2766,2767,2768,2769,2770,2771,2772,2773,2775,2776,2778,2779,2780,2781,2782,2783,2784,2785,2786,2788,2789,2791,2793,2794,2795,2796,2797,2798,2800,2801,2802,2803,2805,2806,2807,2808,2809,2810,2811,2812,2813,2814,2815,2816,2817,2818,2819,2820,2821,2824,2825,2826,2827,2828,2829,2831,2832,2833,2836,2837,2838,2839,2840,2841,2843,2844,2845,2846,2850,2854,2855,2856,2861,2865,2866,2867,2868,2869,2870,2871,2872,2874,2875,2876,2877,2878,2879,2880,2883,2884,2885,2886,2887,2896,2901,2902)
                                        ORDER BY producto ASC");

        while ($row = $mysql_planes->fetch_array(MYSQLI_ASSOC)) 
        {
            $planes_fuentes[] = $row;
        }

        $insert_planesfuentes           = "INSERT INTO planesfuentes ( idplan, idfuente ) VALUES ";
        $array_valores_planesfuentes    = array();

        foreach($planes_fuentes as $plan)
        {
            echo '(PF'.$idplan.')';

            $idplan  = $plan['idplan'];

            array_push($array_valores_planesfuentes, "( $idplan, 1 )");
        }

        $valores 				    = implode(",", $array_valores_planesfuentes);
        $insert_planesfuentes 	    = $insert_planesfuentes.$valores;

        ejecuta_insert($db_postgresql, $insert_planesfuentes);
        

    //PLANES ORIGENES Y DESTINOS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: Planes Origenes';

        $mysql_planes_origenes = $db_mysql->query("SELECT 
                                                        DISTINCT producto as idplan 
                                                    FROM orders 
                                                    WHERE 1 = 1
                                                    AND producto IN (21,56,74,87,88,89,92,93,94,95,96,98,102,103,106,107,108,109,111,112,113,114,116,117,119,123,128,129,140,141,154,156,157,158,159,160,162,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,186,208,225,239,240,245,246,247,248,249,250,251,253,254,255,256,257,258,259,260,261,267,269,270,272,273,275,492,493,496,497,555,558,610,630,646,647,649,650,660,661,665,669,670,671,672,679,680,704,707,708,753,754,852,966,968,974,979,980,981,1043,1049,1055,1063,1065,1066,1070,1071,1076,1077,1122,1125,1130,1132,1144,1161,1164,1180,1204,1205,1207,1216,1218,1219,1220,1221,1254,1256,1258,1259,1260,1261,1277,1282,1291,1293,1299,1312,1345,1351,1352,1358,1359,1361,1377,1381,1383,1386,1387,1388,1389,1399,1400,1401,1404,1406,1411,1412,1414,1416,1421,1424,1431,1451,1452,1454,1455,1465,1478,1481,1492,1495,1496,1501,1503,1504,1505,1509,1514,1521,1522,1523,1524,1529,1530,1536,1537,1538,1610,1615,1626,1644,1658,1677,1678,1696,1713,1748,1749,1751,1752,1753,1760,1761,1766,1772,1774,1775,1776,1778,1781,1787,1788,1790,1791,1795,1796,1802,1805,1807,1810,1811,1812,1817,1819,1820,1843,1844,1845,1851,1852,1853,1854,1855,1858,1859,1861,1862,1863,1864,1865,1869,1870,1871,1872,1873,1874,1894,1895,1910,1912,1914,1920,1921,1924,1925,1926,1927,1928,1929,1930,1931,1932,1934,1940,1941,1942,1944,1945,1949,1950,1951,1952,1953,1954,1955,1956,1957,1958,1961,1967,1968,1969,1972,1973,1974,1976,1977,1978,1979,1980,1981,1987,1988,1989,1996,2001,2002,2005,2006,2007,2008,2009,2011,2017,2018,2019,2020,2021,2022,2023,2025,2026,2027,2030,2031,2032,2033,2038,2039,2040,2041,2042,2043,2044,2045,2075,2076,2079,2082,2083,2084,2085,2086,2087,2097,2114,2115,2117,2118,2119,2121,2123,2124,2125,2127,2128,2129,2130,2132,2133,2134,2137,2138,2139,2140,2141,2142,2143,2144,2151,2152,2155,2162,2163,2164,2165,2173,2174,2175,2176,2177,2178,2179,2180,2181,2183,2184,2185,2191,2192,2193,2194,2195,2197,2202,2204,2205,2206,2207,2208,2209,2210,2211,2212,2214,2215,2216,2218,2221,2222,2223,2224,2225,2226,2227,2228,2229,2230,2231,2234,2235,2236,2238,2243,2245,2246,2247,2248,2253,2255,2256,2259,2260,2262,2263,2264,2266,2267,2268,2269,2270,2271,2272,2273,2274,2275,2276,2278,2279,2280,2281,2282,2283,2285,2286,2287,2288,2289,2290,2291,2292,2293,2294,2295,2300,2301,2356,2362,2363,2364,2374,2375,2376,2383,2386,2387,2388,2406,2408,2409,2410,2411,2412,2413,2414,2416,2417,2418,2419,2420,2421,2422,2423,2425,2426,2427,2428,2429,2430,2432,2433,2434,2435,2447,2448,2449,2450,2451,2452,2454,2455,2456,2460,2461,2462,2463,2465,2466,2467,2468,2469,2470,2471,2472,2473,2474,2475,2476,2489,2490,2491,2492,2493,2496,2497,2503,2505,2507,2510,2511,2512,2513,2514,2515,2516,2517,2518,2519,2520,2521,2522,2523,2524,2525,2526,2528,2529,2530,2531,2532,2533,2534,2536,2537,2544,2545,2546,2547,2548,2550,2551,2552,2553,2554,2555,2556,2557,2558,2559,2560,2561,2562,2563,2564,2565,2566,2567,2568,2571,2572,2573,2574,2575,2576,2577,2578,2579,2580,2581,2582,2583,2586,2587,2590,2591,2592,2595,2596,2597,2598,2599,2600,2601,2602,2603,2604,2605,2609,2610,2616,2617,2618,2619,2620,2621,2622,2626,2627,2628,2629,2630,2631,2632,2633,2634,2644,2645,2706,2707,2708,2709,2711,2713,2714,2715,2718,2719,2721,2722,2723,2724,2725,2726,2729,2730,2731,2732,2733,2734,2735,2736,2737,2738,2739,2745,2747,2748,2749,2750,2751,2752,2753,2754,2755,2757,2758,2759,2760,2761,2762,2763,2764,2765,2766,2767,2768,2769,2770,2771,2772,2773,2775,2776,2778,2779,2780,2781,2782,2783,2784,2785,2786,2788,2789,2791,2793,2794,2795,2796,2797,2798,2800,2801,2802,2803,2805,2806,2807,2808,2809,2810,2811,2812,2813,2814,2815,2816,2817,2818,2819,2820,2821,2824,2825,2826,2827,2828,2829,2831,2832,2833,2836,2837,2838,2839,2840,2841,2843,2844,2845,2846,2850,2854,2855,2856,2861,2865,2866,2867,2868,2869,2870,2871,2872,2874,2875,2876,2877,2878,2879,2880,2883,2884,2885,2886,2887,2896,2901,2902)
                                                    ORDER BY producto ASC");

        while ($row = $mysql_planes_origenes->fetch_array(MYSQLI_ASSOC)) 
        {
            $planes_origenes[] = $row;
        }

        $origenes = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE origenpermitido = true");

        foreach($planes_origenes as $plan)
        {
            echo 'Origen:'.$idplan.'-';
            $idplan  = $plan['idplan'];

            $insert_planesorigenes           = "INSERT INTO planesorigenes ( idplan, idpais ) VALUES ";
            $array_valores_planesorigenes    = array();

            foreach($origenes['resultado'] as $origen)
            {
                $idpais     = $origen['idpais'];

                array_push($array_valores_planesorigenes, "( $idplan, $idpais )");
            }

            $valores 				    = implode(",", $array_valores_planesorigenes);
            $insert_planesorigenes 	    = $insert_planesorigenes.$valores;

            ejecuta_insert($db_postgresql, $insert_planesorigenes);
        }

    //PLANES DESTINOS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: Planes Destinos';

        $mysql_planes_destinos = $db_mysql->query("SELECT 
                                                        DISTINCT producto as idplan 
                                                    FROM orders 
                                                    WHERE 1 = 1
                                                    AND producto IN (21,56,74,87,88,89,92,93,94,95,96,98,102,103,106,107,108,109,111,112,113,114,116,117,119,123,128,129,140,141,154,156,157,158,159,160,162,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,186,208,225,239,240,245,246,247,248,249,250,251,253,254,255,256,257,258,259,260,261,267,269,270,272,273,275,492,493,496,497,555,558,610,630,646,647,649,650,660,661,665,669,670,671,672,679,680,704,707,708,753,754,852,966,968,974,979,980,981,1043,1049,1055,1063,1065,1066,1070,1071,1076,1077,1122,1125,1130,1132,1144,1161,1164,1180,1204,1205,1207,1216,1218,1219,1220,1221,1254,1256,1258,1259,1260,1261,1277,1282,1291,1293,1299,1312,1345,1351,1352,1358,1359,1361,1377,1381,1383,1386,1387,1388,1389,1399,1400,1401,1404,1406,1411,1412,1414,1416,1421,1424,1431,1451,1452,1454,1455,1465,1478,1481,1492,1495,1496,1501,1503,1504,1505,1509,1514,1521,1522,1523,1524,1529,1530,1536,1537,1538,1610,1615,1626,1644,1658,1677,1678,1696,1713,1748,1749,1751,1752,1753,1760,1761,1766,1772,1774,1775,1776,1778,1781,1787,1788,1790,1791,1795,1796,1802,1805,1807,1810,1811,1812,1817,1819,1820,1843,1844,1845,1851,1852,1853,1854,1855,1858,1859,1861,1862,1863,1864,1865,1869,1870,1871,1872,1873,1874,1894,1895,1910,1912,1914,1920,1921,1924,1925,1926,1927,1928,1929,1930,1931,1932,1934,1940,1941,1942,1944,1945,1949,1950,1951,1952,1953,1954,1955,1956,1957,1958,1961,1967,1968,1969,1972,1973,1974,1976,1977,1978,1979,1980,1981,1987,1988,1989,1996,2001,2002,2005,2006,2007,2008,2009,2011,2017,2018,2019,2020,2021,2022,2023,2025,2026,2027,2030,2031,2032,2033,2038,2039,2040,2041,2042,2043,2044,2045,2075,2076,2079,2082,2083,2084,2085,2086,2087,2097,2114,2115,2117,2118,2119,2121,2123,2124,2125,2127,2128,2129,2130,2132,2133,2134,2137,2138,2139,2140,2141,2142,2143,2144,2151,2152,2155,2162,2163,2164,2165,2173,2174,2175,2176,2177,2178,2179,2180,2181,2183,2184,2185,2191,2192,2193,2194,2195,2197,2202,2204,2205,2206,2207,2208,2209,2210,2211,2212,2214,2215,2216,2218,2221,2222,2223,2224,2225,2226,2227,2228,2229,2230,2231,2234,2235,2236,2238,2243,2245,2246,2247,2248,2253,2255,2256,2259,2260,2262,2263,2264,2266,2267,2268,2269,2270,2271,2272,2273,2274,2275,2276,2278,2279,2280,2281,2282,2283,2285,2286,2287,2288,2289,2290,2291,2292,2293,2294,2295,2300,2301,2356,2362,2363,2364,2374,2375,2376,2383,2386,2387,2388,2406,2408,2409,2410,2411,2412,2413,2414,2416,2417,2418,2419,2420,2421,2422,2423,2425,2426,2427,2428,2429,2430,2432,2433,2434,2435,2447,2448,2449,2450,2451,2452,2454,2455,2456,2460,2461,2462,2463,2465,2466,2467,2468,2469,2470,2471,2472,2473,2474,2475,2476,2489,2490,2491,2492,2493,2496,2497,2503,2505,2507,2510,2511,2512,2513,2514,2515,2516,2517,2518,2519,2520,2521,2522,2523,2524,2525,2526,2528,2529,2530,2531,2532,2533,2534,2536,2537,2544,2545,2546,2547,2548,2550,2551,2552,2553,2554,2555,2556,2557,2558,2559,2560,2561,2562,2563,2564,2565,2566,2567,2568,2571,2572,2573,2574,2575,2576,2577,2578,2579,2580,2581,2582,2583,2586,2587,2590,2591,2592,2595,2596,2597,2598,2599,2600,2601,2602,2603,2604,2605,2609,2610,2616,2617,2618,2619,2620,2621,2622,2626,2627,2628,2629,2630,2631,2632,2633,2634,2644,2645,2706,2707,2708,2709,2711,2713,2714,2715,2718,2719,2721,2722,2723,2724,2725,2726,2729,2730,2731,2732,2733,2734,2735,2736,2737,2738,2739,2745,2747,2748,2749,2750,2751,2752,2753,2754,2755,2757,2758,2759,2760,2761,2762,2763,2764,2765,2766,2767,2768,2769,2770,2771,2772,2773,2775,2776,2778,2779,2780,2781,2782,2783,2784,2785,2786,2788,2789,2791,2793,2794,2795,2796,2797,2798,2800,2801,2802,2803,2805,2806,2807,2808,2809,2810,2811,2812,2813,2814,2815,2816,2817,2818,2819,2820,2821,2824,2825,2826,2827,2828,2829,2831,2832,2833,2836,2837,2838,2839,2840,2841,2843,2844,2845,2846,2850,2854,2855,2856,2861,2865,2866,2867,2868,2869,2870,2871,2872,2874,2875,2876,2877,2878,2879,2880,2883,2884,2885,2886,2887,2896,2901,2902)
                                                    ORDER BY producto ASC");

        while ($row = $mysql_planes_destinos->fetch_array(MYSQLI_ASSOC)) 
        {
            $planes_destinos[] = $row;
        }

        $destinos = ejecuta_select($db_postgresql, "SELECT idpais FROM paises WHERE destinopermitido = true");

        foreach($planes_destinos as $plan)
        {
            echo 'OD:'.$idplan.'-';
            $idplan  = $plan['idplan'];

            $insert_planesdestinos           = "INSERT INTO planesdestinos ( idplan, idpais ) VALUES ";
            $array_valores_planesdestinos    = array();

            foreach($destinos['resultado'] as $origen)
            {
                $idpais     = $origen['idpais'];

                array_push($array_valores_planesdestinos, "( $idplan, $idpais )");
            }

            $valores 				    = implode(",", $array_valores_planesdestinos);
            $insert_planesdestinos 	    = $insert_planesdestinos.$valores;

            ejecuta_insert($db_postgresql, $insert_planesdestinos);
        }


       
    // PLANES BENEFICIOS *******************************************************************************************************************************************************************************
        echo 'Migrando Tabla: planesbeneficios';

        $mysql = $db_mysql->query("SELECT DISTINCT beneficios_costo.id_plan, 
                                            beneficios_costo.id_beneficio, 
                                            CAST(CONVERT(beneficios_costo.valor  USING utf8) AS binary) as cobertura,
                                            CAST(CONVERT(beneficios_costo.language_id  USING utf8) AS binary) as coberturaen
                                            FROM beneficios_costo 
                                                JOIN plans ON plans.id = beneficios_costo.id_plan 
                                                JOIN beneficios ON beneficios.id_beneficio = beneficios_costo.id_beneficio 
                                            WHERE beneficios.language_id = 'spa' 
                                            AND plans.id IN (21,56,74,87,88,89,92,93,94,95,96,98,102,103,106,107,108,109,111,112,113,114,116,117,119,123,128,129,140,141,154,156,157,158,159,160,162,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,186,208,225,239,240,245,246,247,248,249,250,251,253,254,255,256,257,258,259,260,261,267,269,270,272,273,275,492,493,496,497,555,558,610,630,646,647,649,650,660,661,665,669,670,671,672,679,680,704,707,708,753,754,852,966,968,974,979,980,981,1043,1049,1055,1063,1065,1066,1070,1071,1076,1077,1122,1125,1130,1132,1144,1161,1164,1180,1204,1205,1207,1216,1218,1219,1220,1221,1254,1256,1258,1259,1260,1261,1277,1282,1291,1293,1299,1312,1345,1351,1352,1358,1359,1361,1377,1381,1383,1386,1387,1388,1389,1399,1400,1401,1404,1406,1411,1412,1414,1416,1421,1424,1431,1451,1452,1454,1455,1465,1478,1481,1492,1495,1496,1501,1503,1504,1505,1509,1514,1521,1522,1523,1524,1529,1530,1536,1537,1538,1610,1615,1626,1644,1658,1677,1678,1696,1713,1748,1749,1751,1752,1753,1760,1761,1766,1772,1774,1775,1776,1778,1781,1787,1788,1790,1791,1795,1796,1802,1805,1807,1810,1811,1812,1817,1819,1820,1843,1844,1845,1851,1852,1853,1854,1855,1858,1859,1861,1862,1863,1864,1865,1869,1870,1871,1872,1873,1874,1894,1895,1910,1912,1914,1920,1921,1924,1925,1926,1927,1928,1929,1930,1931,1932,1934,1940,1941,1942,1944,1945,1949,1950,1951,1952,1953,1954,1955,1956,1957,1958,1961,1967,1968,1969,1972,1973,1974,1976,1977,1978,1979,1980,1981,1987,1988,1989,1996,2001,2002,2005,2006,2007,2008,2009,2011,2017,2018,2019,2020,2021,2022,2023,2025,2026,2027,2030,2031,2032,2033,2038,2039,2040,2041,2042,2043,2044,2045,2075,2076,2079,2082,2083,2084,2085,2086,2087,2097,2114,2115,2117,2118,2119,2121,2123,2124,2125,2127,2128,2129,2130,2132,2133,2134,2137,2138,2139,2140,2141,2142,2143,2144,2151,2152,2155,2162,2163,2164,2165,2173,2174,2175,2176,2177,2178,2179,2180,2181,2183,2184,2185,2191,2192,2193,2194,2195,2197,2202,2204,2205,2206,2207,2208,2209,2210,2211,2212,2214,2215,2216,2218,2221,2222,2223,2224,2225,2226,2227,2228,2229,2230,2231,2234,2235,2236,2238,2243,2245,2246,2247,2248,2253,2255,2256,2259,2260,2262,2263,2264,2266,2267,2268,2269,2270,2271,2272,2273,2274,2275,2276,2278,2279,2280,2281,2282,2283,2285,2286,2287,2288,2289,2290,2291,2292,2293,2294,2295,2300,2301,2356,2362,2363,2364,2374,2375,2376,2383,2386,2387,2388,2406,2408,2409,2410,2411,2412,2413,2414,2416,2417,2418,2419,2420,2421,2422,2423,2425,2426,2427,2428,2429,2430,2432,2433,2434,2435,2447,2448,2449,2450,2451,2452,2454,2455,2456,2460,2461,2462,2463,2465,2466,2467,2468,2469,2470,2471,2472,2473,2474,2475,2476,2489,2490,2491,2492,2493,2496,2497,2503,2505,2507,2510,2511,2512,2513,2514,2515,2516,2517,2518,2519,2520,2521,2522,2523,2524,2525,2526,2528,2529,2530,2531,2532,2533,2534,2536,2537,2544,2545,2546,2547,2548,2550,2551,2552,2553,2554,2555,2556,2557,2558,2559,2560,2561,2562,2563,2564,2565,2566,2567,2568,2571,2572,2573,2574,2575,2576,2577,2578,2579,2580,2581,2582,2583,2586,2587,2590,2591,2592,2595,2596,2597,2598,2599,2600,2601,2602,2603,2604,2605,2609,2610,2616,2617,2618,2619,2620,2621,2622,2626,2627,2628,2629,2630,2631,2632,2633,2634,2644,2645,2706,2707,2708,2709,2711,2713,2714,2715,2718,2719,2721,2722,2723,2724,2725,2726,2729,2730,2731,2732,2733,2734,2735,2736,2737,2738,2739,2745,2747,2748,2749,2750,2751,2752,2753,2754,2755,2757,2758,2759,2760,2761,2762,2763,2764,2765,2766,2767,2768,2769,2770,2771,2772,2773,2775,2776,2778,2779,2780,2781,2782,2783,2784,2785,2786,2788,2789,2791,2793,2794,2795,2796,2797,2798,2800,2801,2802,2803,2805,2806,2807,2808,2809,2810,2811,2812,2813,2814,2815,2816,2817,2818,2819,2820,2821,2824,2825,2826,2827,2828,2829,2831,2832,2833,2836,2837,2838,2839,2840,2841,2843,2844,2845,2846,2850,2854,2855,2856,2861,2865,2866,2867,2868,2869,2870,2871,2872,2874,2875,2876,2877,2878,2879,2880,2883,2884,2885,2886,2887,2896,2901,2902)
                                            ORDER BY id_plan ASC");

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $planesbeneficios[] = $row;
        }

        foreach($planesbeneficios as $planbeneficio)
        {
            echo 'B:'.$idplan.'-';

            $idplan          = $planbeneficio['id_plan'];
            $idbeneficio     = $planbeneficio['id_beneficio'];
            $cobertura       = $planbeneficio['cobertura'];
            $coberturaen     = $planbeneficio['coberturaen'];

            $insert     = "INSERT INTO planesbeneficios (
                                    idplan, 
                                    idbeneficio,
                                    cobertura,
                                    coberturaen,
                                    fechaactualizacion
                                )
                            VALUES
                                (
                                    $idplan, 
                                    $idbeneficio,
                                    '$cobertura',
                                    '$coberturaen',
                                    '2000-01-01 00:00:00'
                                )";

            if(ejecuta_insert($db_postgresql, $insert))
                {
                    $idplanbeneficio = select_max_id($db_postgresql, 'idplanbeneficio', 'planesbeneficios');

                    $insert     = "INSERT INTO planesbeneficiosproveedores (
                                            idplanbeneficio, 
                                            idproveedor,
                                            porcentajeriesgo,
                                            fechaactualizacion
                                        )
                                    VALUES
                                        (
                                            $idplanbeneficio, 
                                            1,
                                            100,
                                            '2000-01-01 00:00:00'
                                        )";

                    ejecuta_insert($db_postgresql, $insert);
                }
        }


    // PLANES BENEFICIOS ADICIONALES *******************************************************************************************************************************************************************************
        echo 'Bigrando Tabla: planesbeneficiosadicionales';

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
                                            AND beneficios_plus.id_plan IN (21,56,74,87,88,89,92,93,94,95,96,98,102,103,106,107,108,109,111,112,113,114,116,117,119,123,128,129,140,141,154,156,157,158,159,160,162,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,186,208,225,239,240,245,246,247,248,249,250,251,253,254,255,256,257,258,259,260,261,267,269,270,272,273,275,492,493,496,497,555,558,610,630,646,647,649,650,660,661,665,669,670,671,672,679,680,704,707,708,753,754,852,966,968,974,979,980,981,1043,1049,1055,1063,1065,1066,1070,1071,1076,1077,1122,1125,1130,1132,1144,1161,1164,1180,1204,1205,1207,1216,1218,1219,1220,1221,1254,1256,1258,1259,1260,1261,1277,1282,1291,1293,1299,1312,1345,1351,1352,1358,1359,1361,1377,1381,1383,1386,1387,1388,1389,1399,1400,1401,1404,1406,1411,1412,1414,1416,1421,1424,1431,1451,1452,1454,1455,1465,1478,1481,1492,1495,1496,1501,1503,1504,1505,1509,1514,1521,1522,1523,1524,1529,1530,1536,1537,1538,1610,1615,1626,1644,1658,1677,1678,1696,1713,1748,1749,1751,1752,1753,1760,1761,1766,1772,1774,1775,1776,1778,1781,1787,1788,1790,1791,1795,1796,1802,1805,1807,1810,1811,1812,1817,1819,1820,1843,1844,1845,1851,1852,1853,1854,1855,1858,1859,1861,1862,1863,1864,1865,1869,1870,1871,1872,1873,1874,1894,1895,1910,1912,1914,1920,1921,1924,1925,1926,1927,1928,1929,1930,1931,1932,1934,1940,1941,1942,1944,1945,1949,1950,1951,1952,1953,1954,1955,1956,1957,1958,1961,1967,1968,1969,1972,1973,1974,1976,1977,1978,1979,1980,1981,1987,1988,1989,1996,2001,2002,2005,2006,2007,2008,2009,2011,2017,2018,2019,2020,2021,2022,2023,2025,2026,2027,2030,2031,2032,2033,2038,2039,2040,2041,2042,2043,2044,2045,2075,2076,2079,2082,2083,2084,2085,2086,2087,2097,2114,2115,2117,2118,2119,2121,2123,2124,2125,2127,2128,2129,2130,2132,2133,2134,2137,2138,2139,2140,2141,2142,2143,2144,2151,2152,2155,2162,2163,2164,2165,2173,2174,2175,2176,2177,2178,2179,2180,2181,2183,2184,2185,2191,2192,2193,2194,2195,2197,2202,2204,2205,2206,2207,2208,2209,2210,2211,2212,2214,2215,2216,2218,2221,2222,2223,2224,2225,2226,2227,2228,2229,2230,2231,2234,2235,2236,2238,2243,2245,2246,2247,2248,2253,2255,2256,2259,2260,2262,2263,2264,2266,2267,2268,2269,2270,2271,2272,2273,2274,2275,2276,2278,2279,2280,2281,2282,2283,2285,2286,2287,2288,2289,2290,2291,2292,2293,2294,2295,2300,2301,2356,2362,2363,2364,2374,2375,2376,2383,2386,2387,2388,2406,2408,2409,2410,2411,2412,2413,2414,2416,2417,2418,2419,2420,2421,2422,2423,2425,2426,2427,2428,2429,2430,2432,2433,2434,2435,2447,2448,2449,2450,2451,2452,2454,2455,2456,2460,2461,2462,2463,2465,2466,2467,2468,2469,2470,2471,2472,2473,2474,2475,2476,2489,2490,2491,2492,2493,2496,2497,2503,2505,2507,2510,2511,2512,2513,2514,2515,2516,2517,2518,2519,2520,2521,2522,2523,2524,2525,2526,2528,2529,2530,2531,2532,2533,2534,2536,2537,2544,2545,2546,2547,2548,2550,2551,2552,2553,2554,2555,2556,2557,2558,2559,2560,2561,2562,2563,2564,2565,2566,2567,2568,2571,2572,2573,2574,2575,2576,2577,2578,2579,2580,2581,2582,2583,2586,2587,2590,2591,2592,2595,2596,2597,2598,2599,2600,2601,2602,2603,2604,2605,2609,2610,2616,2617,2618,2619,2620,2621,2622,2626,2627,2628,2629,2630,2631,2632,2633,2634,2644,2645,2706,2707,2708,2709,2711,2713,2714,2715,2718,2719,2721,2722,2723,2724,2725,2726,2729,2730,2731,2732,2733,2734,2735,2736,2737,2738,2739,2745,2747,2748,2749,2750,2751,2752,2753,2754,2755,2757,2758,2759,2760,2761,2762,2763,2764,2765,2766,2767,2768,2769,2770,2771,2772,2773,2775,2776,2778,2779,2780,2781,2782,2783,2784,2785,2786,2788,2789,2791,2793,2794,2795,2796,2797,2798,2800,2801,2802,2803,2805,2806,2807,2808,2809,2810,2811,2812,2813,2814,2815,2816,2817,2818,2819,2820,2821,2824,2825,2826,2827,2828,2829,2831,2832,2833,2836,2837,2838,2839,2840,2841,2843,2844,2845,2846,2850,2854,2855,2856,2861,2865,2866,2867,2868,2869,2870,2871,2872,2874,2875,2876,2877,2878,2879,2880,2883,2884,2885,2886,2887,2896,2901,2902)
                                            AND beneficios_plus.id_beneficio IN (35,36,37)
                                            ORDER BY beneficios_plus.id ASC");

        while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
        {
            $planesbeneficiosadicionales[] = $row;
        }

        foreach($planesbeneficiosadicionales as $planbeneficioadicional)
        {
            echo 'BA:'.$idplan.'-';

            $idplan                     = $planbeneficioadicional['idplan'];
            $idbeneficioadicional       = $planbeneficioadicional['idbeneficioadicional'];
            $factorconversion           = $planbeneficioadicional['factorconversion'];
            $factorconversionedad       = $planbeneficioadicional['factorconversionedad'];
            $factorconversionfamiliar   = $planbeneficioadicional['factorconversionfamiliar'];
            $cobertura                  = $planbeneficioadicional['cobertura'];
            $coberturaen                = $planbeneficioadicional['coberturaen'];
            $orden                      = $planbeneficioadicional['orden'];
            $fechaactualizacion         = $planbeneficioadicional['fechaactualizacion'];

            $insert     = "INSERT INTO planesbeneficiosadicionales (
                                    idplan, 
                                    idbeneficioadicional,
                                    factorconversion,
                                    factorconversionedad,
                                    factorconversionfamiliar,
                                    cobertura,
                                    coberturaen,
                                    orden,
                                    fechaactualizacion
                                )
                            VALUES
                                (
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

            if(ejecuta_insert($db_postgresql, $insert))
            {
                $idplanbeneficioadicional = select_max_id($db_postgresql, 'idplanbeneficioadicional', 'planesbeneficiosadicionales');

                $insert_beneficiosadicionalesproveedores     = "INSERT INTO planesbeneficiosadicionalesproveedores (
                                                                        idplanbeneficioadicional, 
                                                                        idproveedor,
                                                                        porcentajeriesgo
                                                                    )
                                                                VALUES
                                                                    (
                                                                        $idplanbeneficioadicional, 
                                                                        2,
                                                                        100
                                                                    )";

                if(ejecuta_insert($db_postgresql, $insert_beneficiosadicionalesproveedores))
                {

                }
                else
                {
                    echo $insert;
                }
            }
        }

    // // CUPONES PLANES *******************************************************************************************************************************************************************************
    //     echo 'Migrando Tabla: cuponesplanes';

    //     $mysql = $db_mysql->query("SELECT 
    //                                     DISTINCT plans_category_coupons.id_plan, 
    //                                     plans_category_coupons.id_cupon 
    //                                 FROM plans_category_coupons 
    //                                     JOIN plans on plans.id = plans_category_coupons.id_plan 
    //                                     JOIN coupons on coupons.id = plans_category_coupons.id_cupon 
    //                                 WHERE 1 = 1
    //                                 AND plans.id IN (21,56,74,87,88,89,92,93,94,95,96,98,102,103,106,107,108,109,111,112,113,114,116,117,119,123,128,129,140,141,154,156,157,158,159,160,162,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,186,208,225,239,240,245,246,247,248,249,250,251,253,254,255,256,257,258,259,260,261,267,269,270,272,273,275,492,493,496,497,555,558,610,630,646,647,649,650,660,661,665,669,670,671,672,679,680,704,707,708,753,754,852,966,968,974,979,980,981,1043,1049,1055,1063,1065,1066,1070,1071,1076,1077,1122,1125,1130,1132,1144,1161,1164,1180,1204,1205,1207,1216,1218,1219,1220,1221,1254,1256,1258,1259,1260,1261,1277,1282,1291,1293,1299,1312,1345,1351,1352,1358,1359,1361,1377,1381,1383,1386,1387,1388,1389,1399,1400,1401,1404,1406,1411,1412,1414,1416,1421,1424,1431,1451,1452,1454,1455,1465,1478,1481,1492,1495,1496,1501,1503,1504,1505,1509,1514,1521,1522,1523,1524,1529,1530,1536,1537,1538,1610,1615,1626,1644,1658,1677,1678,1696,1713,1748,1749,1751,1752,1753,1760,1761,1766,1772,1774,1775,1776,1778,1781,1787,1788,1790,1791,1795,1796,1802,1805,1807,1810,1811,1812,1817,1819,1820,1843,1844,1845,1851,1852,1853,1854,1855,1858,1859,1861,1862,1863,1864,1865,1869,1870,1871,1872,1873,1874,1894,1895,1910,1912,1914,1920,1921,1924,1925,1926,1927,1928,1929,1930,1931,1932,1934,1940,1941,1942,1944,1945,1949,1950,1951,1952,1953,1954,1955,1956,1957,1958,1961,1967,1968,1969,1972,1973,1974,1976,1977,1978,1979,1980,1981,1987,1988,1989,1996,2001,2002,2005,2006,2007,2008,2009,2011,2017,2018,2019,2020,2021,2022,2023,2025,2026,2027,2030,2031,2032,2033,2038,2039,2040,2041,2042,2043,2044,2045,2075,2076,2079,2082,2083,2084,2085,2086,2087,2097,2114,2115,2117,2118,2119,2121,2123,2124,2125,2127,2128,2129,2130,2132,2133,2134,2137,2138,2139,2140,2141,2142,2143,2144,2151,2152,2155,2162,2163,2164,2165,2173,2174,2175,2176,2177,2178,2179,2180,2181,2183,2184,2185,2191,2192,2193,2194,2195,2197,2202,2204,2205,2206,2207,2208,2209,2210,2211,2212,2214,2215,2216,2218,2221,2222,2223,2224,2225,2226,2227,2228,2229,2230,2231,2234,2235,2236,2238,2243,2245,2246,2247,2248,2253,2255,2256,2259,2260,2262,2263,2264,2266,2267,2268,2269,2270,2271,2272,2273,2274,2275,2276,2278,2279,2280,2281,2282,2283,2285,2286,2287,2288,2289,2290,2291,2292,2293,2294,2295,2300,2301,2356,2362,2363,2364,2374,2375,2376,2383,2386,2387,2388,2406,2408,2409,2410,2411,2412,2413,2414,2416,2417,2418,2419,2420,2421,2422,2423,2425,2426,2427,2428,2429,2430,2432,2433,2434,2435,2447,2448,2449,2450,2451,2452,2454,2455,2456,2460,2461,2462,2463,2465,2466,2467,2468,2469,2470,2471,2472,2473,2474,2475,2476,2489,2490,2491,2492,2493,2496,2497,2503,2505,2507,2510,2511,2512,2513,2514,2515,2516,2517,2518,2519,2520,2521,2522,2523,2524,2525,2526,2528,2529,2530,2531,2532,2533,2534,2536,2537,2544,2545,2546,2547,2548,2550,2551,2552,2553,2554,2555,2556,2557,2558,2559,2560,2561,2562,2563,2564,2565,2566,2567,2568,2571,2572,2573,2574,2575,2576,2577,2578,2579,2580,2581,2582,2583,2586,2587,2590,2591,2592,2595,2596,2597,2598,2599,2600,2601,2602,2603,2604,2605,2609,2610,2616,2617,2618,2619,2620,2621,2622,2626,2627,2628,2629,2630,2631,2632,2633,2634,2644,2645,2706,2707,2708,2709,2711,2713,2714,2715,2718,2719,2721,2722,2723,2724,2725,2726,2729,2730,2731,2732,2733,2734,2735,2736,2737,2738,2739,2745,2747,2748,2749,2750,2751,2752,2753,2754,2755,2757,2758,2759,2760,2761,2762,2763,2764,2765,2766,2767,2768,2769,2770,2771,2772,2773,2775,2776,2778,2779,2780,2781,2782,2783,2784,2785,2786,2788,2789,2791,2793,2794,2795,2796,2797,2798,2800,2801,2802,2803,2805,2806,2807,2808,2809,2810,2811,2812,2813,2814,2815,2816,2817,2818,2819,2820,2821,2824,2825,2826,2827,2828,2829,2831,2832,2833,2836,2837,2838,2839,2840,2841,2843,2844,2845,2846,2850,2854,2855,2856,2861,2865,2866,2867,2868,2869,2870,2871,2872,2874,2875,2876,2877,2878,2879,2880,2883,2884,2885,2886,2887,2896,2901,2902)
    //                                 ORDER BY plans_category_coupons.id_plan_categoria ASC");

    //     while ($row = $mysql->fetch_array(MYSQLI_ASSOC)) 
    //     {
    //         $cuponesplanes[] = $row;
    //     }

    //     foreach($cuponesplanes as $cuponplan)
    //     {
    //         echo 'c';

    //         $idplan    = $cuponplan['id_plan'];
    //         $idcupon   = $cuponplan['id_cupon'];

    //         $insert     = "INSERT INTO cuponesplanes (
    //                                 idplan, 
    //                                 idcupon
    //                             )
    //                         VALUES
    //                             (
    //                                 $idplan, 
    //                                 $idcupon
    //                             )";

    //         if(ejecuta_insert($db_postgresql, $insert))
    //         {

    //         }
    //         else
    //         {
    //             echo $insert;
    //         }
    //     }
  
    $hora_fin   = date('h:i:s', time());  

    echo $plans['cantidad'].' Planes migrados exitosamente !';
    echo 'Proceso Finalizado Exitosamente !'; 
?>
