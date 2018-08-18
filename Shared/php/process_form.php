<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('auto_detect_line_endings', true);
include("dblink.php");
include("functions.php");

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

foreach ($_POST as $key => $value) {
    $_POST[$key] = mysqli_real_escape_string($dblink, $value);
}
extract($_POST);
extract($_GET);
$failCount = 0;
//$action = $_GET[action];
$user = $_SESSION['user_id'];
if (preg_match('/^[-a-zA-Z0-9_ .]+$/', $_GET['f']) || empty($_GET['f'])) {

    $f = $_GET['f'];
} else {
    echo "An error encountered while processing your request";
    exit;
}

switch (strtoupper($f)) {
    case "GROUPTYPES":
        if ($_POST['cell'] != '') {
            $sql = "update SRC_GroupTypes set GroupType=?, Description=? where GroupTypeID = ? ";
            $sql = $dblink->prepare($sql);
            $sql->bind_param("sss", $GroupTypeName, $Description, $cell);
            $sql->execute();
            LogInFile("Record Update", $_POST, $sql);

            $_SESSION[notes] = "Group Type Updated Successfully";
        } else {
            $sql = "insert into SRC_GroupTypes (GroupType,Description) values(?,?)";
            $sql = $dblink->prepare($sql);
            $sql->bind_param("ss", $GroupTypeName, $Description);
            $sql->execute();
            LogInFile("New Record", $_POST, $sql);
            // auditAction("Ticket Creation", "Created Ticket $id ", $_SERVER[REMOTE_ADDR], $postdata);

            $_SESSION[notes] = "Group Type Created Successfully";
        }
        break;
    case "GROUPS":
        if ($_POST['cell'] != '') {

           // Select GroupID as primarykey, GroupName,(select GroupType from SRC_GroupTypes where SRC_GroupTypes.GroupTypeID = SRC_Groups.GroupTypeID)Group_Type, GroupLabel
            $sql = "update SRC_Groups set GroupName = ? GroupTypeID = ?, GroupLabel = ? where GroupID = ? ";
            $sql = $dblink->prepare($sql);
            $sql->bind_param("ssss", $GroupName, $GroupTypeID,$GroupLabel, $cell);
            $sql->execute();
            LogInFile("Group Update", $_POST, $sql);

            $_SESSION[notes] = "Group Updated Successfully";
        } else {
            $sql = "insert into SRC_GroupTypes (GroupName,GroupTypeID,GroupLabel ) values(?,?,?)";
            $sql = $dblink->prepare($sql);
            $sql->bind_param("sss", $GroupName, $GroupTypeID,$GroupLabel);
            $sql->execute();
            LogInFile("New Record", $_POST, $sql);
            // auditAction("Ticket Creation", "Created Ticket $id ", $_SERVER[REMOTE_ADDR], $postdata);
            $_SESSION[notes] = "Group Created Successfully";


        }
        break;
    case "MEMBERS":
        if ($_POST['cell'] != '') {

           // MemberID as primarykey, `Email`,  `FirstName`,`MiddleName`, `LastName`, `Mobile`, `Residence`, `Occupation`, `Gender` from SRC_Members
            $sql = "update SRC_Members set Email = ?, FirstName = ?, MiddleName = ? , LastName = ?, Mobile = ?, Residence = ?, Occupation = ?, Gender = ? where MemberID = ? ";
            $sql = $dblink->prepare($sql);
            $sql->bind_param("sssssssss", $Email, $FirstName,$MiddleName,$LastName,$Mobile,$Residence,$Occupation, $Gender, $cell);
            $sql->execute();
            LogInFile("Member Update", $_POST, $sql);

            $_SESSION[notes] = "Member Updated Successfully";
        } else {
            $sql = "insert into SRC_Members (Email,FirstName , MiddleName,LastName , Mobile , Residence , Occupation , Gender) values(?,?,?,?,?,?,?,?)";
            $sql = $dblink->prepare($sql);
            $sql->bind_param("ssssssss", $Email, $FirstName,$MiddleName,$LastName,$Mobile,$Residence,$Occupation, $Gender);
            $sql->execute();
            LogInFile("New Member", $_POST, $sql);
            // auditAction("Ticket Creation", "Created Ticket $id ", $_SERVER[REMOTE_ADDR], $postdata);


        }
        break;


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
    $all = '';
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

function LogInFile($Title,$data,$sql)
{
    file_put_contents("ims-log-$dateExt.txt", date("Y-m-d H:i(worry)") . $Title ."  " . print_r($data, true) . " Query: " . $sql . "\n", FILE_APPEND);
}

?>
