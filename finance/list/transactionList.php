<?php

include("../../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';
$query = 'SELECT UserID AS "primarykey",UserFirstName as First_Name,UserLastName as Last_Name ,UserGender as Gender,UserPhone as Phone,UserEmail as Email FROM SRC_users';
//echo $query;
$_SESSION['sqlxls'] = $query;

$res = generateGrid("Users", "view", $query, true, true, true, false, false, false,$actionsBar,array("search","status","date"),false);

echo $res;

 


?>
