
<?php

include("../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 500;
$searchFilter = '';

$query = "SELECT ID AS \"primarykey\",Parameter,Value,Description FROM parameters" ;

$_SESSION['sqlxls'] = $query;
$target_page = $_SESSION['targetpage'];

$res = generateGrid("System Parameters", "view", $query, true, true, true, false, false, false,$actionsBar,array("search","status","date"),false);

echo $res;
 
?>
