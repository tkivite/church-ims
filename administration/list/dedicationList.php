
<?php

include("../../Shared/php/functions.php");

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';

$query = "Select ChildrenDedicationID as primarykey, FirstName,MiddleName,LastName,DateOfDedication, PlaceOfDedication, CertificateIssued 
 from SRC_ChildrenDedication";
$_SESSION['sqlxls'] = $query;
$target_page = $_SESSION['targetpage'];

$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New Record" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New Record</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>'; 

$res = generateGrid("Dedication", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"));

echo $res;