
<?php

include("../../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';

$query = "Select EventID as primarykey, `EventName`,  `StartDate`,`EndDate`, `StartTime`, `EndTime`,`Description` from SRC_Events" ;

$_SESSION['sqlxls'] = $query;
$target_page = $_SESSION['targetpage'];

$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New Event" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New Event</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>'; 

$res = generateGrid("Events", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"));

echo $res;
 
?>
