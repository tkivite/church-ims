<?php

include("../../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';

$query = "SELECT ProjectID as primarykey, ProjectName,Description,StartDate,Target,(select sum(Amount) from cmis2018.SRC_ProjectTransactions Where SRC_ProjectTransactions.ProjectID =SRC_Projects.ProjectID and TransactionType ='INCOME')INCOME , 
(select sum(Amount) from cmis2018.SRC_ProjectTransactions Where SRC_ProjectTransactions.ProjectID =SRC_Projects.ProjectID and TransactionType ='EXPENSE')EXPENSE 
FROM cmis2018.SRC_Projects" ;

$_SESSION['sqlxls'] = $query;
$target_page = $_SESSION['targetpage'];

$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New Project" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New Project</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>';

$res = generateGrid("Projects", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"));

echo $res;
