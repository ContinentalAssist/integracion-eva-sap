<?php
	function getDB() {
		$connStr = pg_connect("host=db-desarrollo-eva-nyc3-02567-do-user-15422798-0.c.db.ondigitalocean.com port=25060 dbname=continental_desarrollo_bd user=doadmin password=AVNS_Qy7sP_guliDHM2mcK_2");
		//$connStr = pg_connect("sslmode=disable host=10.100.1.4 port=5432 dbname=continental_desarrollo_bd user=sistemas password=C0nt1n3nt4l");
		// $connStr = pg_connect("sslmode=disable host=35.227.126.41 port=5432 dbname=continental_desarrollo_bd_migracion user=sistemas password=C0nt1n3nt4l");
		//$connStr = pg_connect("sslmode=disable host=10.100.1.41 port=5432 dbname=eva-bd user=sistemas password=C0nt1n3nt4l");	
	return $connStr;
	} 
?>
