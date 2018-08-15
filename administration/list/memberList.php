
<?php

include("../../Shared/php/functions.php");
//require 'vendor/autoload.php';

$_SESSION[page_size]=isset($page_size)? $page_size : 100;
$searchFilter = '';

$query = "Select MemberID as primarykey, `Email`,  `FirstName`,`MiddleName`, `LastName`, `Mobile`, `Residence`, `Occupation`, `Gender` from SRC_Members" ;

$_SESSION['sqlxls'] = $query;
$target_page = $_SESSION['targetpage'];

$actionsBar .= '<div class="gridActionsBar" id="addElements">';
$actionsBar .='<button type="button" value ="New Member" name="addButton" class="btn-primary btn-sm addButton gridPrimaryButton">New Member</button>';
$actionsBar .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$actionsBar .= '</div>'; 

$pagination ='';
/*
//$res = generateGrid("Members", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"));
//echo $res;

$url = 'http://localhost:3000/users/authenticate';
$data = '{"Email": "tkivite@gmail.com", "Password": "Password123$$"}';


// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
         'method'  => 'POST',
    'content' => json_encode( $data ),
    'header'=>  "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n"
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
//if ($result === FALSE) { /* Handle error  }

$response = json_decode( $result );

var_dump($response);
*/

// {"type":"User"...'
$res = generateGrid("Members", "view", $query, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"));

echo $res;
 
?>
