<?php

include("../../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';
$query = "SELECT ProjectTID as primarykey, (select ProjectName from SRC_Projects WHERE SRC_Projects.ProjectID = SRC_ProjectTransactions.ProjectID)Project,Amount,TransactionType,TransactingParty,Description from SRC_ProjectTransactions where TransactionType ='EXPENSE'" ;

$_SESSION['sqlxls'] = $query;
$target_page = $_SESSION['targetpage'];
$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New Project" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New Transaction</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>';

$res = generateGrid("Projects Expense", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"));

echo $res;
