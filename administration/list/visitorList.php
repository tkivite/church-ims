
<?php

include("../../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';

$query = "Select VisitorID as primarykey, `Email`,  `FirstName`,`MiddleName`, `LastName`, `Mobile`, Occupation,Residence,BornAgain,VisitorType,DateofVisit from SRC_Visitors" ;
$_SESSION['sqlxls'] = $query;
$target_page = $_SESSION['targetpage'];
$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New Visitor" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New Visitor</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>'; 

$res = generateGrid("Visitors", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"));

echo $res;
 
?>
