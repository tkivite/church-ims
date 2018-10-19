<?php

include("../../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';
$query = 'SELECT AccountID AS "primarykey",
AccountName,
AccountCode,
CurrentBalance,
`CR-DR`,
Category FROM SRC_Accounts Where Level = 1 And ParentID = 0';
//echo $query;?
/*
$_SESSION['sqlxls'] = $query;
$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New Accou" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New User</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>';*/

$pagination ='';

$res = generateChartOfAccounts("Accounts", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"),true);
//$res = generateGrid("Members", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"));

echo $res;

 


?>
