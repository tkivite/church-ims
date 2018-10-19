
<?php

include("../../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';

$query = "Select GroupID as primarykey, GroupName,(select GroupType from SRC_GroupTypes where SRC_GroupTypes.GroupTypeID = SRC_Groups.GroupTypeID)Group_Type, GroupLabel from SRC_Groups Where Intrash ='NO'" ;

$_SESSION['sqlxls'] = $query;
$target_page = $_SESSION['targetpage'];

$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New Group" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New Group</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>'; 

$res = generateGrid("Contracts", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"));

echo $res;
 
?>
