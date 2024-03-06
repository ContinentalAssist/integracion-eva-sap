<?php

function connect_db() 
{
	$server 	= '72.52.231.114';
	$user 		= 'continen_migraci';
	$pass 		= 'System32***';
    $database 	= 'continen_contneo';
	$connection = new mysqli($server, $user, $pass, $database);

	return $connection;
}