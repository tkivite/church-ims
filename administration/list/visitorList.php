
<?php

include("../../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';

$query = "Select VisitorID as primarykey,  concat(`FirstName`,' ',`MiddleName`, ' ',  `LastName`)Names, `Mobile`, `Email`,Residence,BornAgain,VisitorType,DateofVisit from SRC_Visitors" ;
$_SESSION['sqlxls'] = $query;
$target_page = $_SESSION['targetpage'];
$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New Visitor" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New Visitor</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

$actionsBar .='<button type="button" value ="Bulk Visitor" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">Bulk Creation</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>'; 

$res = generateGrid("Visitors", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"));

echo $res;
 
?>
