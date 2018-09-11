
<?php

include("../../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';

$query = "Select BaptismID as primarykey, FirstName,MiddleName,LastName,Gender,DateOfBirth,Contacts
BaptisedBy,
DateOfBaptism,
PlaceOfBaptism,
CertificateIssued,
CertificateIssueDate from SRC_Baptism";
$_SESSION['sqlxls'] = $query;
$target_page = $_SESSION['targetpage'];

$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New Record" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New Record</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>'; 

$res = generateGrid("Baptism", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"));

echo $res;
 
?>
