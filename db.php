<?php
error_reporting(E_ALL);
ini_set('display_errors', True);
$user = "ecell";
$host = "localhost";
$pass = "ecell";
$table = "ecell";
//$dbc=mysqli_connect($host,$user,$pass,$table)or die('Error connecting with database.');
/*global $db_connection;
$db_connection = new mysqli($host, $user, $pass, $table);
// Check connection
if ($db_connection->connect_error) {
    throw new Exception("Failed to connect to MySQL: " . mysqli_connect_error());
    unset($db_connection);
}*/
global $db;
try{
	$db = new PDO('mysql:host=localhost;dbname='.$table.';charset=utf8', $user, $pass);//use charset=utf8 here
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch ( PDOException $e ) {
	echo "Database error ".$e->getMessage();
}

