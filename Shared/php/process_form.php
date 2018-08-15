<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('auto_detect_line_endings', true);
include("dblink.php");
include("functions.php");
include("api.php");
include('Classes/PHPExcel/IOFactory.php');
require_once("SimpleFileUpload.php");

$postdata = file_get_contents('php://input');
if ($postdata == '')
    $postdata = $_POST;
$action = $_GET['action'];
session_start();
//    Extract POST to variables

//extract($clean);
GLOBAL $dblink;

$dateExt = date("Y-m-d");
$api_url = "http://localhost:3000/";

//mysqli_real_escape_string($dblink, $_POST['lastname']);

foreach ($_POST as $key => $value) {
    $_POST[$key] = mysqli_real_escape_string($dblink, $value);
}
extract($_POST);
extract($_GET);
$failCount = 0;
//$action = $_GET[action];
$user      = $_SESSION['user_id'];
if (preg_match('/^[-a-zA-Z0-9_ .]+$/', $_GET['f']) || empty($_GET['f'])) {
    
    $f = $_GET['f'];
} else {
    echo "An error encountered while processing your request";
    exit;
}

switch (strtoupper($f)) {
        case "MEMBER":
      
        if ($action == "delete") {
            $response = deleteFormData($api_url.'member', $_POST);
        } else {

            if ($_POST[cell] != '') {
                  $response = putFormData($api_url.'member', $_POST);
                  //$_SESSION[notes] = "Business Type updated succesfully";
            } else {
                  $response = postFormData($api_url.'member', $_POST);
            }
        }
        break;

                    
        break;
    case "AUTOCOMPLETE_AJAX":        
        $columnName   = strval($_POST['serchkey']);
        $keyword      = strval($_POST['query']);
        $search_param = "{$keyword}%";
        $sql          = $dblink->prepare("SELECT * FROM people WHERE $columnName LIKE ?");
        $sql->bind_param("s", $search_param);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $countryResult[] = $row[$columnName];
            }
            echo json_encode($countryResult);
        }
        //$dblink->close();
        break;
    case "OTHER_FIELDS_AJAX":
        $keyword   = strval($_GET['query']);
        $searching = strval($_GET['serchkey']);
        //$search_param = "{$keyword}%";
        
        
        $sql = $dblink->prepare("SELECT ID,Name,Email,Phone,Company FROM people WHERE $searching = ?");
        $sql->bind_param("s", $keyword);
        $sql->execute();
        $result = $sql->get_result();
        
        // $sql     = "SELECT ID,Name,Email,Phone,Company FROM people where $searching = '$keyword' limit 1";
        // $result  = $dblink->query($sql);
        $row     = mysqli_fetch_array($result);
        $Name    = $row[1];
        $Email   = $row[2];
        $Phone   = $row[3];
        $Company = $row[4];
        
        echo $Name . "$$" . $Email . "$$" . $Phone . "$$" . $Company;
        
        
        break;
    case "TICKETSGRID_AJAX":
        $result = "SELECT ID AS \"primarykey\",Name,Email,Department,Message, CONCAT((CASE
    WHEN TimeCreated  >= DATE_SUB(NOW(), INTERVAL 1 DAY) THEN \"<div class='btn-group row' role='group' aria-label='Basic example'><h4><span class='label label-warning'>New</span>\"   
    ELSE \" \" END) ,  (CASE WHEN Urgency = 'Urgent' THEN \"<span class='label label-danger'>Urgent</span></h4></div>\"   
    ELSE \" \" END))Labels  FROM tickets where Email = '$email' order by TimeCreated desc";
        
        $res = generateTicketsGrid("My Tickets", "view", $result, true, true, true, false, false, $pagination, false, false, false);
        echo $res;
        
        break;
    case "ESCALATE":
        
        $sql = "SELECT ID,Name,Email,Phone,Company,Message,Department FROM tickets where ID =? limit 1";
        
        
        $sql = $dblink->prepare($sql);
        $sql->bind_param("s", $query);
        $sql->execute();
        $result     = $sql->get_result();
        $row        = mysqli_fetch_array($result);
        $Name       = $row[1];
        $Email      = $row[2];
        $Phone      = $row[3];
        $Company    = $row[4];
        $Message    = $row[5];
        $Department = $row[6];
        
        $to      = execQuery("Select Value from parameters where Parameter = 'Support Email'", true);
        // $to = "tkivite@gmail.com";
        $subject = "**Escalated** Ticket from Company: $Company - Department: $Department";
        $toname  = "Support";
        
        $setEmail = sendEmail($to, $subject, $Message, $Email, $Email, $toname);
        file_put_contents("tmslog-$dateExt.txt", date("Y-m-d H:i(worry)") . " Escalation to  $to From $from Sent Succesfully: " . print_r($setEmail, true) . "\n", FILE_APPEND);
        
        if ($setEmail)
            echo "Your Ticket has been escalated";
        else
            echo "There was a problem escalating your ticket";
        
        break;
    case "TICKETS":
        // $message = str_replace('{{', '<', $message);
        //  $message = str_replace('}}', '>', $message);
        if ($_POST['cell'] != '') {
            
            $sql = "update tickets set Name=?, Email=?,Phone=?,Company=?,Department=?,Message=? where ID = ? ";
            $sql = $dblink->prepare($sql);
            $sql->bind_param("sssssss", $Name, $Email, $Phone, $Company, $Department, $Message, $cell);
            $sql->execute();
            
            file_put_contents("tmslog-$dateExt.txt", date("Y-m-d H:i(worry)") . " Data: " . print_r($_POST, true) . " Query: " . $sql . "\n", FILE_APPEND);
            
            //  auditAction("Ticket Update", "Updated Ticket Code Message to q'|$message|' ", 'NIC_RESP_CODES', $_POST['cell']);
            
            $_SESSION[notes] = "Ticket Updated" . $res;
        } else {
            $sql = "insert into tickets (Name,Email,Phone,Company,Department,Message) values(?,?,?,?,?,?)";
            $sql = $dblink->prepare($sql);
            $sql->bind_param("ssssss", $Name, $Email, $Phone, $Company, $Department, $Message);
            $sql->execute();
            // auditAction("Ticket Creation", "Created Ticket $id ", $_SERVER[REMOTE_ADDR], $postdata);
            
            
            $sqlInsertPerson = "INSERT INTO people (Name,Email,Phone,Company)
            SELECT * FROM (SELECT '$Name', '$Email', '$Phone', '$Company') AS tmp
            WHERE NOT EXISTS (
                SELECT Email FROM people WHERE Email = '$Email'
            ) LIMIT 1";
            // $sql             = $dblink->prepare($sqlInsertPerson);
            // $sql->bind_param("sssss", $Name, $Email, $Phone, $Company, $Email);
            // $sql->execute();
            $dblink->query($sqlInsertPerson);
            file_put_contents("tmslog-$dateExt.txt", date("Y-m-d H:i(worry)") . " create people: $Name - $Email - $Phone - $Company \n", FILE_APPEND);
             
            
                $subject = "New ticket from Company: $Company - Department: $Department";
                
                
                $to = execQuery("Select Value from parameters where Parameter = 'Support Email'", true);
                
                
                $senttEmail = sendEmail($to, $subject, $Message, $Email, $Email, $toname);
                file_put_contents("tmslog-$dateExt.txt", date("Y-m-d H:i(worry)") . " Email to  $to From $from Sent Succesfully: " . print_r($senttEmail, true) . "\n", FILE_APPEND);
                
                
                $reponseText = '<div class="alert alert-success">
                                    <strong>Thank you !</strong>  Your Request Ticket Has Been Created. You will receive response from us within 24 hours.
                                 </div>';
                
               
                $_SESSION[notes] = "Ticket Created";
                
           
            
            
        }
        
        break;
    
    case "NEWTICKET":
        /* If data was posted , extract post data, create ticket in db, create people record */
        
        if ($Name != '' && $Email != '') {
            $_SESSION['Email'] = $Email;
            $sql               = "insert into tickets (Name,Email,Phone,Company,Department,Message,Urgency) values(?,?,?,?,?,?,?)";
            $sql               = $dblink->prepare($sql);
            $sql->bind_param("sssssss", $Name, $Email, $Phone, $Company, $Department, $Message, $Urgency);
            $sql->execute();
            file_put_contents("tmslog-$dateExt.txt", date("Y-m-d H:i(worry)") . " create ticket: $Name - $Email - $Phone - $Company - $Department - $Message - $Urgency \n", FILE_APPEND);
            
            /*Insert People Record if email doesn't exist in people table */
            $sqlInsertPerson = "INSERT INTO people (Name,Email,Phone,Company)
            SELECT * FROM (SELECT '$Name', '$Email', '$Phone', '$Company') AS tmp
            WHERE NOT EXISTS (
                SELECT Email FROM people WHERE Email = '$Email'
            ) LIMIT 1";
            // $sql             = $dblink->prepare($sqlInsertPerson);
            // $sql->bind_param("sssss", $Name, $Email, $Phone, $Company, $Email);
            // $sql->execute();
            $dblink->query($sqlInsertPerson);
            file_put_contents("tmslog-$dateExt.txt", date("Y-m-d H:i(worry)") . " create people: $Name - $Email - $Phone - $Company \n", FILE_APPEND);
            
            
            
            /* If ticket was created successfully send support Email */
            
            $subject = "New ticket from Company: $Company - Department: $Department";
            
            
            $to = execQuery("Select Value from parameters where Parameter = 'Support Email'", true);
            
            
            $senttEmail = sendEmail($to, $subject, $Message, $Email, $Email, $toname);
            file_put_contents("tmslog-$dateExt.txt", date("Y-m-d H:i(worry)") . " Email to  $to From $from Sent Succesfully: " . print_r($senttEmail, true) . "\n", FILE_APPEND);
            
            
            $reponseText = '<div class="alert alert-success">
                                    <strong>Thank you !</strong>  Your Request Ticket Has Been Created. You will receive response from us within 24 hours.
                                 </div>';
            
            $res  = 0;
            /* Reset All Variables */
            $Name = $Email = $Phone = $Company = $Department = $Message = $Urgency = "";
            
            /* } else {
            $reponseText = '<div class="alert alert-danger">
            <strong>Sorry !</strong>  A problem occured while posting your ticket.
            </div>';
            
            }*/
        }
        
        echo $reponseText;
        
        break;
    
    
    case "CONTRACTUPDATE":
        /* If data was posted , extract post data, create ticket in db, create people record */
        
        
        //   $mimes = array('application/vnd.ms-excel', 'application/ms-excel', 'application/octet-stream', 'application/wps-office.xls', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/wps-office.xlsx');
        // $_SESSION['notes'] .= $_FILES['files']['type'];
        //   if (in_array($_FILES['docUpload']['type'], $mimes)) {
        
        if (isset($_FILES["docUpload"]["name"])) {
            $target_dir  = "Uploads/";
            $target_file = $target_dir . basename($_FILES["docUpload"]["name"]);
            
            $target            = 'uploads/';
            $target            = realpath($target) . "/"; #class SimpleFileUpload is included at the beginning of the functions file...
            $syshome_folder    = execQuery("select Value from parameters WHERE Parameter ='Home Folder' ", true);
            $sysuploads_folder = execQuery("select Value from parameters WHERE Parameter = 'Uploads Folder' ", true);
            $sysurl            = execQuery("select Value from parameters WHERE Parameter = 'Production Url' ", true);
            $savepath          = $syshome_folder . '/' . $sysuploads_folder . '/';
            $urlpath           = $sysurl . '/' . $sysuploads_folder . '/';
            
            $SimpleFileUpload = new SimpleFileUpload('docUpload', $savepath);
            $SimpleFileUpload->UploadFile();
            $newFname     = $SimpleFileUpload->FILE;
            $file_link    = $newFname;
            $file_urllink = str_replace($syshome_folder, $sysurl, $file_link);
            
            $DOB = date("Y-m-d H:i:s", strtotime($DOB));
            // $sql = "update contracts set CompanyName=?, Address=?,Phone=?,EquipmentText=?,User=?,MonthlyAmount=?,Term=?,Status=?,DOB=? where ID = ?";
            $sql = "update contracts set Status=?,Documents=? where ID = ?";
            $sql = $dblink->prepare($sql);
            //$sql->bind_param("ssssssssss",$CompanyName,$Address,$Phone,$EquipmentText,$User,$MonthlyAmount,$Term,$Status,$DOB,$cell);
            $sql->bind_param("sss", $Status, $file_urllink, $cell);
            $sql->execute();
            
            
            file_put_contents("tmslog-$dateExt.txt", date("Y-m-d H:i(worry)") . " Data: " . "\n", FILE_APPEND);
            
            //  auditAction("Ticket Update", "Updated Ticket Code Message to q'|$message|' ", 'NIC_RESP_CODES', $_POST['cell']);
            
            $_SESSION[notes] = "Contract Updated";
            
            
            
        } else {
            $_SESSION[notes] = "No File Attached";
        }
        header("Location: ../../");
        
        break;
    
    case "CONTRACT":
        
        $sqlIns = "insert into contracts (CompanyName,Address,Phone,EquipmentText,User,MonthlyAmount,Term,DOB,CompanyOlderThanFiveYears) values(?,?,?,?,?,?,?,?,?)";
        
        $DOB = ($CompanyAge == 'NO') ? date("Y-m-d H:i:s", strtotime($DOB)) : execQuery("select current_timestamp from dual", true);
        $sql = $dblink->prepare($sqlIns);
        $sql->bind_param("sssssssss", $CompanyName, $Address, $Phone, $EquipmentText, $User, $MonthlyAmount, $Term, $DOB, $CompanyAge);
        $sql->execute();
        // auditAction("Ticket Creation", "Created Ticket $id ", $_SERVER[REMOTE_ADDR], $postdata);
        file_put_contents("tmslog-$dateExt.txt", date("Y-m-d H:i(worry)") . print_r($sql->error, true) . "\n", FILE_APPEND);
        
        
        $cclist = explode(',', execQuery("Select Value from parameters where Parameter = 'Contracts Email CC'", true));
        
        $subject    = "New Application Telico";
        $to         = execQuery("Select Value from parameters where Parameter = 'Contracts Email'", true);
        $replyTo    = execQuery("Select Value from parameters where Parameter = 'Contracts Email Reply to'", true);
        $Message    = "A new Contract Created ";
        $senttEmail = sendEmail($to, $subject, $Message, $Email, $replyTo, $toname, $cclist);
        file_put_contents("tmslog-$dateExt.txt", date("Y-m-d H:i(worry)") . " Email to  $to From $from Sent Succesfully: " . print_r($senttEmail, true) . "\n", FILE_APPEND);
        $_SESSION[notes] = "Contract Created";
        
        
        
        
        
        
        
        break;
        
        
        
}



function convertXLStoCSV($infile, $outfile)
{
    $fileType  = PHPExcel_IOFactory::identify($infile);
    $objReader = PHPExcel_IOFactory::createReader($fileType);
    
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load($infile);
    
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
    $objWriter->save($outfile);
}

function randomPassword($length = 8, $add_dashes = false, $available_sets = 'ud')
{
    $sets = array();
    if (strpos($available_sets, 'l') !== false)
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
    if (strpos($available_sets, 'u') !== false)
        $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
    if (strpos($available_sets, 'd') !== false)
        $sets[] = '23456789';
    if (strpos($available_sets, 's') !== false)
        $sets[] = '!@#$%&*?';
    $all      = '';
    $password = '';
    foreach ($sets as $set) {
        $password .= $set[array_rand(str_split($set))];
        $all .= $set;
    }
    $all = str_split($all);
    for ($i = 0; $i < $length - count($sets); $i++)
        $password .= $all[array_rand($all)];
    $password = str_shuffle($password);
    if (!$add_dashes)
        return $password;
    $dash_len = floor(sqrt($length));
    $dash_str = '';
    while (strlen($password) > $dash_len) {
        $dash_str .= substr($password, 0, $dash_len) . '-';
        $password = substr($password, $dash_len);
    }
    $dash_str .= $password;
    return $dash_str;
}

?>
