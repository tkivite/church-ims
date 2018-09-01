<?php

include("../../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';
$query = ', UserLastName) from SRC_users where UserID = CreatedBy)creator,
  (TimeCreated)Time_Recorded,(TimeOfTransaction)Time_Received  FROM SRC_Transactions\'';
//echo $query;
$_SESSION['sqlxls'] = $query;


$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New Transaction" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New Transaction</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>';

$res = generateGrid("Users", "view", $query, true, true, true, false, false, false,$actionsBar,array("search","status","date"),false);

echo $res;

 


?>
