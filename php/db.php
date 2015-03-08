<?php
error_reporting(E_ALL);
ini_set('display_errors', True);
$user = "ecell";
$host = "localhost";
$pass = "ecell";
$table = "ecell";
$dbc=mysqli_connect($host,$user,$pass,$table)or die('Error connecting with database.');
