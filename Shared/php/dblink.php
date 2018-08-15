<?php

$hostname_dbConn = "localhost";
$DB_dbConn = "church360";
$username_dbConn = "root";
$password_dbConn = "1SUPERtitus";

$dblink= new mysqli($hostname_dbConn, $username_dbConn, $password_dbConn,$DB_dbConn );
// Check connection
if($dblink->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}
/*
$dbCON= mysqli_connect($hostname_dbConn, $username_dbConn, $password_dbConn,$DB_dbConn);
	if (mysqli_connect_errno($dbCON)) {
	   trigger_error('Database connection failed: '  . mysqli_connect_error(), E_USER_ERROR);
	}*/





?>
