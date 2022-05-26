<?php
$host_database = 'localhost';
$port_database = '5432';
$db = 'TSW';
$username_database = 'www';
$password_database ='tsw2022';

$connection_string = "host=$host_database port=$port_database dbname=$db user=$username_database password=$password_database";

	//CONNESSIONE AL DB
	$db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
	 
?>
