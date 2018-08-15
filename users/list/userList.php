<?php

include("../../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';
$query = 'SELECT UserID AS "primarykey",UserFirstName as First_Name,UserLastName as Last_Name ,UserGender as Gender,UserPhone as Phone,UserEmail as Email FROM SRC_users';
//echo $query;
$_SESSION['sqlxls'] = $query;
$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New User" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New User</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>';

$pagination ='';

$res = generateGrid("Users", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"),true);
//$res = generateGrid("Members", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"));

echo $res;

 


?>
