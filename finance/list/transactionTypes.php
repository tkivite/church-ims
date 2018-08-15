
<?php

include("../../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';

$query = "Select TransactionTypeID as primarykey, `TransactionType` From SRC_TransactionTypes" ;

$_SESSION['sqlxls'] = $query;
$target_page = $_SESSION['targetpage'];
/*
$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New Member" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New Member</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>'; */

$pagination ='';

$res = generateGrid("Transaction Types", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"));
echo $res;
 
?>
