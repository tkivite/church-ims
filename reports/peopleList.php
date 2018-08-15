
<?php
include("../Shared/php/functions.php");
$_SESSION[page_size]=isset($page_size)? $page_size : 500;
$searchFilter = '';
$query = "SELECT ID AS \"primarykey\",Name,Email,Phone,Company,Address FROM people" ;
//echo $query;
$_SESSION['sqlxls'] = $query;

$res = generateGrid("People", "view", $query, true, true, true, false, false, false,$actionsBar,array("search","status","date"),false);

echo $res;

 
    

?>
