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

    case "MONEYIN":
        LogInFile("New Transaction", $_POST, '$TransactionType, $amount.\'_\'.$i, $channel.\'_\'.$i, $reference, $details, to_timestamp(\'" . $TimeOfTransaction . "\',  \'yyyy-mm-dd h-m-s\')');
        if ($_POST['cell'] != '') {

            // MemberID as primarykey, `Email`,  `FirstName`,`MiddleName`, `LastName`, `Mobile`, `Residence`, `Occupation`, `Gender` from SRC_Members
            $sql = "update SRC_Transactions set Email = ?, FirstName = ?, MiddleName = ? , LastName = ?, Mobile = ?, Residence = ?, Occupation = ?, Gender = ? where MemberID = ? ";
            $sql = $dblink->prepare($sql);
            $sql->bind_param("sssssssss", $Email, $FirstName,$MiddleName,$LastName,$Mobile,$Residence,$Occupation, $Gender, $cell);
            $sql->execute();
            LogInFile("Member Update", $_POST, $sql);

            $_SESSION[notes] = "Member Updated Successfully";
        } else {

            for ($i=0;$i < $recordscount; $i++) {

                $amount = $_POST["amount_" . $i];
                $channel = $_POST["channel_" . $i];
                if($amount > 0 ) {
                    $sql = "insert into SRC_Transactions (TransactionTypeID,TransactionAmount , TransactionChannelID,TransactionRef , TransactionDetails ) 
                                                  values(?,?,?,?,?)";
                    $sql = $dblink->prepare($sql);
                    $sql->bind_param("sssss", $TransactionType, $amount, $channel, $reference, $details );
                    $sql->execute();

                    LogInFile("New Transaction", $_POST, $sql->error);
                }
                // auditAction("Ticket Creation", "Created Ticket $id ", $_SERVER[REMOTE_ADDR], $postdata);

            }

        }
        break;
    case "MONEYOUT":
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

    case "TRANS_ADD":
        $rows = $_GET['rows'];
        $i = 0;

        $vals = array();

        while ($r < $rows) {
            $data['First_Name'] = '';
            $data['Middle_Name'] = '';
            $data['Last_Name'] = '';
            $data['Phone_Number'] = '';
            $data['Amount'] = 0;
            $data['Job_Group'] = '';
            $data['Province'] = 'Select Province';
            $data['County'] = 'Select County';
            $data['District'] = 'Select District';
            $data['Payment_Type'] = 'Select Payment Type';
            $data['Budget_Line'] = 'Select Budget Line';
            $vals[] = $data;
            $r++;
        }

        $data0 = json_encode($vals);
        $_SESSION['datat2'] = "";
        $_SESSION['datat2'] = $data0;
        echo $_SESSION['datat2'];

        break;

    case "BULK_MEMBER_CREATION":

        $jsondata = $_POST['jsondata'];
        $arr = array();
        $arr = json_decode($jsondata);

    //    ECHO $_SESSION['testing4'] .= '................................................................................................<br/>';


        $countx = 0;
        $esistingCount = 0;

        foreach ($arr as $x) {
            $FirstName = $x[0];
            $MiddleName = $x[1];
            $LastName = $x[2];
            $Mobile = $x[3];
            $Mobile = mysqli_escape_string(str_replace(" ", "", str_replace("+", "", trim($Mobile))));
            $Email = $x[4];
            $Residence = $x[5];
            $Occupation = $x[6];
            $Gender = $x[7];
            $Group = $x[8];

            $sql = "insert into SRC_Members (Email,FirstName , MiddleName,LastName , Mobile , Residence , Occupation , Gender) values (?,?,?,?,?,?,?,?)";
            $sql = $dblink->prepare($sql);
            $sql->bind_param("ssssssss", $Email, $FirstName,$MiddleName,$LastName,$Mobile,$Residence,$Occupation, $Gender);
            $sql->execute();
            $membberid = $sql->insert_id;
            LogInFile("New Member", $_POST, $sql);

            $sql1 = "insert into SRC_Group_Members (MemberID,GroupID) values (?,select GroupID from SRC_Groups where GroupName = ?)";
            $sql1 = $dblink->prepare($sql1);
            $sql1->bind_param("ss", $membberid, $Group);
            $sql1->execute();
            $countx += 1;
        }
        $_SESSION['notes'] = "$countx Members have been successfully uploaded.";


        break;

    case "BULK_INCOME":


            $jsondata = $_POST['jsondata'];
            $arr = array();
            $arr = json_decode($jsondata);

            //    ECHO $_SESSION['testing4'] .= '................................................................................................<br/>';


            $countx = 0;
            $esistingCount = 0;

            foreach ($arr as $x) {

                $reference = $x[0].'-'.$x[1].' -'.$x[3].' '.$x[4].': '.x[2];
                $Member = $x[0];
                $Member = execQuery("select IFNULL(MemberID,0) from SRC_Members where concat(FirstName,' ',MiddleName,' ',LastName) = '$Member'",true);

                $Mobile = $x[1];
                $amount = $x[2];
                $TransactionType = $x[3];
                $TransactionType = execQuery("SELECT TransactionTypeID FROM SRC_TransactionTypes where TransactionType = '$TransactionType'",true);

                $channel = $x[4];
                $channel = execQuery("Select ChannelID From SRC_PaymentChannels where ChannelName = '$channel' ", true);
                $Confirmed = $x[5];
                $Notes = $x[6];




                if ($amount > 0) {
                    $sql = "insert into SRC_Transactions (TransactionMemberID,TransactionTypeID,TransactionAmount , TransactionChannelID,TransactionRef , TransactionDetails ) 
                                                  values(?,?,?,?,?,?)";
                    $sql = $dblink->prepare($sql);
                    $sql->bind_param("ssssss", $Member,$TransactionType, $amount, $channel, $reference, $Notes);
                    $sql->execute();
                    LogInFile("New Transaction", $_POST, $sql->error);
                }
                // auditAction("Ticket Creation", "Created Ticket $id ", $_SERVER[REMOTE_ADDR], $postdata);
                $countx += 1;
            }
        $_SESSION['notes'] = "$countx Transactions have been successfully uploaded.";


        break;

    case "BULK_EXPENSE":


        $jsondata = $_POST['jsondata'];
        $arr = array();
        $arr = json_decode($jsondata);

        //    ECHO $_SESSION['testing4'] .= '................................................................................................<br/>';


        $countx = 0;
        $esistingCount = 0;

        foreach ($arr as $x) {

            $reference = $x[0].'-'.$x[1].' -'.$x[3].' '.$x[4].': '.x[2];
            $Member = $x[0];
            $Member = execQuery("select IFNULL(MemberID,0) from SRC_Members where concat(FirstName,' ',MiddleName,' ',LastName) = '$Member'",true);

            $Mobile = $x[1];
            $amount = $x[2];
            $TransactionType = $x[3];
            $TransactionType = execQuery("SELECT TransactionTypeID FROM SRC_TransactionTypes where TransactionType = '$TransactionType'",true);

            $channel = $x[4];
            $channel = execQuery("Select ChannelID From SRC_PaymentChannels where ChannelName = '$channel' ", true);
            $Confirmed = $x[5];
            $Notes = $x[6];




            if ($amount > 0) {
                $sql = "insert into SRC_Transactions (TransactionMemberID,TransactionTypeID,TransactionAmount , TransactionChannelID,TransactionRef , TransactionDetails ) 
                                                  values(?,?,?,?,?,?)";
                $sql = $dblink->prepare($sql);
                $sql->bind_param("ssssss", $Member,$TransactionType, $amount, $channel, $reference, $Notes);
                $sql->execute();
                LogInFile("New Transaction", $_POST, $sql->error);
            }
            // auditAction("Ticket Creation", "Created Ticket $id ", $_SERVER[REMOTE_ADDR], $postdata);
            $countx += 1;
        }
        $_SESSION['notes'] = "$countx Transactions have been successfully uploaded.";


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
    $dateExt = date("Y-m-d");
    file_put_contents("ims-log-$dateExt.txt", date("Y-m-d H:i(worry)") . $Title ."  " . print_r($data, true) . " Query: " . print_r($sql) . "\n", FILE_APPEND);
    //file_put_contents("log.txt", date("Y-m-d H:i(worry)") . $Title ."  " . print_r($data, true) . " Query: " . $sql . "\n", FILE_APPEND);
}

?>
