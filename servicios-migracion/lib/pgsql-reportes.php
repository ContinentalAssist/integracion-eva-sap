<?php
	function getDBReportes() {
		$connStr = pg_connect("sslmode=disable host=35.196.65.213 port=5432 dbname=postgres user=postgres password=Continental*2024");
		//$connStr = pg_connect("host=db-reportes-do-user-15422798-0.c.db.ondigitalocean.com port=25060 dbname=defaultdb user=doadmin password=AVNS_5W8WNFq7giFW_waDil7");
		return $connStr;
	} 
?>
