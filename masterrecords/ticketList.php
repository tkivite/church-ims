
<?php

include("../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 500;
$searchFilter = '';

$query = "SELECT ID AS \"primarykey\",Name,Email,Phone,Company,Department,TimeCreated FROM tickets" ;

$_SESSION['sqlxls'] = $query;
$target_page = $_SESSION['targetpage'];

$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New Ticket" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New Ticket</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>'; 

$res = generateGrid("Ticket(s)", "view", $query, true, true, true, false, false, false,$actionsBar,array("search","status","date"));

echo $res;
 
?>
