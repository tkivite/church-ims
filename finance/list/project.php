<?php

include("../../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';

$query = "SELECT ProjectTID as primarykey, ProjectName,Description,StartDate,Target,(select sum(Amount) from SRC_ProjectTransactions Where ProjectTID =ProjectTID and TransactionType ='INCOME')INCOME , (select sum(Amount) from SRC_ProjectTransactions Where ProjectTID =ProjectTID and TransactionType ='EXPENSE')EXPENSE FROM SRC_Projects" ;

$_SESSION['sqlxls'] = $query;
$target_page = $_SESSION['targetpage'];

$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New Project" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New Project</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>';

$res = generateGrid("Events", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"));

echo $res;
