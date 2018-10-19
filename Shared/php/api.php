<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once  __DIR__ .'/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('auto_detect_line_endings', true);



session_start();
use GuzzleHttp\Client;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'http://localhost:3000/',
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);
function print_r_html($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
function AuthenticateSession()
{
    
    if (!isset($_SESSION['loggedIn'])) {
        header("location: signin.php");
        exit;
    } else {
        
        
    }
    $_SESSION['start_time'] = time();
}
function login($username,$password){
    
    $payload = array();
    $payload["Email"] = $username;
    $payload["Password"] = $password;
    
    $payload = json_encode($payload);
    $response = postFormData('users/authenticate', $payload);   
   
    
    $body = $response->getBody();    
    $obj = json_decode($body);
    $_SESSION[token] = $obj -> token;
    $user = $obj -> Record;
    
    
    
    
    if ($obj -> success) {
        $_SESSION['loggedIn'] = true;    
       

        $_SESSION['userid']   = $user -> UserID;
      //  $_SESSION['user_id']   = $user -> userID;
        $_SESSION['user_id']  = $user -> UserID;
        $_SESSION['name']     = $user -> UserFirstName .' ' .$user -> UserLastName ;
        $_SESSION['email']    = $user -> UserEmail;
        $_SESSION['phone']    = $user -> UserPhone;
        $_SESSION['loggedIn'] = TRUE;
        return 1;
        
    }    else {
         $_SESSION['loggedIn'] = false;
        return 0;
    }
    
}
function loadTabData($tab,$user){
     $strQuery = "SELECT MENU_NAME,URL,PRMS_ID,ICON_TAG,DESCRIPTION FROM SRC_prmssns P WHERE PRMS_ID IN 
(SELECT SRC_rolepermissions.PermissionID FROM SRC_rolepermissions WHERE SRC_rolepermissions.RoleID IN 
(SELECT ROLEID FROM SRC_userroles WHERE SRC_userroles.UserID = " . $_SESSION['user_id'] . ")) 
AND MENU_LEVEL = 1 AND IS_MENU = 1 AND MODULE = 'Administration' ORDER BY MENU_POS ASC";   
 
      
        
        $resultArray = execQuery($strQuery);
    
    //return
}
function fetchJsonData($uri){
     global $client;
    $response = $client ->request('GET',$uri, [
    'debug' => TRUE,
    'headers' => [
    'Content-Type' => 'application/json',
    'Auth' => $_SESSION[token],
    'token' =>    $_SESSION[token],
  ]
]);
    return $response -> getBody();    
  //  $obj = json_decode($body);
}

function postFormData($uri,$data){
   global $client;
   $response = $client->post($uri, [
    'debug' => TRUE,
    'body' => $data,
    'headers' => [
    'Content-Type' => 'application/json',
    'Auth' => $_SESSION[token],
    'token' =>    $_SESSION[token],
  ]
]);
   
file_put_contents("api.txt", date("Y-m-d H:i(worry)") . "POST $uri : API Response to  $response \n", FILE_APPEND);
          
return $response;


}

function putFormData($uri,$data){
    
    
}



