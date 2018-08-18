<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

require_once('dblink.php');
require_once('PHPMailer/class.phpmailer.php');
require_once('SimpleFileUpload.php'); #to upload all your files...


session_start();
/*
$timeout = 10;
$inactive = $timeout * 60;
if (isset($_SESSION['start_time'])) {

$session_life = time() - $_SESSION['start_time'];
if ($session_life > $inactive) {
session_destroy();
header("location: signin.php?logout=7");
exit;
}
}*/

date_default_timezone_set('Africa/Nairobi');
$dateExt = date("Y-m-d");
/**
 *  Clean Input
 *
 */
armor_1234567890_abc();
$_REQUEST = SanitizeInput($_REQUEST);
$_GET     = SanitizeInput($_GET);
$_POST    = SanitizeInput($_POST);

function print_r_html($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}


/**
 * @name crypt_word ()
 *  uses function password_hash() with BCRYPT Algorithm
 *      to not mess this up, have a look at
 * @link {http://blog.ircmaxell.com/2012/12/seven-ways-to-screw-up-bcrypt.html}
 * @link {http://www.php.net/manual/en/function.password-hash.php}
 * @param (string) $string
 * @return (boolean)
 */
function crypt_word($string)
{
    return md5($string);
}
/**
 * @function  armor_1234567890_abc()
 *
 *  to watch out for specific SQL injection attacks
 *  Borrowed from
 * @link {http://www.php.net//manual/en/security.database.sql-injection.php}
 * @author  Nikolay Mihaylov
 */
function armor_1234567890_abc()
{
    foreach ($_REQUEST as $key => $data) {
        $data = strtolower(trim($data));
        
        if (strpos($data, "base64_") !== false)
            exit;
        
        if (strpos($data, "union") !== false && strpos($data, "select") !== false)
            exit;
    }
}


/**
 * @name SanitizeInput ()
 *  Borrowed from
 * @link {http://css-tricks.com/snippets/php/sanitize-database-inputs/}
 *
 *
 */
function SanitizeInput($input)
{
    // print_r_html($input);
    #remove multiple occurences of whitespace characters in a string an convert them all into single spaces
    $input  = (!is_array($input)) ? preg_replace('/\s+/', ' ', $input) : $input;
    $output = (is_array($input)) ? array() : ''; #initialise output based on input
    
    if ($input <> '' || (is_array($input) && !empty($input))) {
        if (is_array($input)) {
            foreach ($input as $var => $val)
                $output[$var] = SanitizeInput($val);
            
        } else {
            // echo 'hello <br />';
            if (get_magic_quotes_gpc())
                $input = stripslashes($input);
            
            $output = CleanInput($input);
            // $output = mysql_real_escape_string($input);
        }
        
        
    }
    
    return $output;
}

/**
 * @name CleanInput ( )
 *  function borrowed from:
 * @link {http://css-tricks.com/snippets/php/sanitize-database-inputs/}
 *
 * @return string cleaned_input
 */
function CleanInput($input)
{
    
    $search = array(
        '@<script[^>]*?>.*?</script>@si', // Strip out javascript
        '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
        '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
        '@<![\s\S]*?--[ \t\n\r]*>@' // Strip multi-line comments
    );
    
    $output = preg_replace($search, '', $input);
    return $output;
}

/**
 * @name random_number ( )
 * @param (int) $number_of_digits
 *
 * @return (int) random number
 */
function random_number($number_of_digits = 4)
{
    # if used frequently, can have upto: $number_of_digits! possible combinations
    # $number_of_digits! = $number_of_digits·($number_of_digits – 1)·($number_of_digits – 2) · · · 3·2·1
    # Example: 4! = 4·3·2·1 = 24
    
    $a = mt_rand(1, 9);
    
    for ($i = 1; $i < $number_of_digits; $i++) {
        $a .= mt_rand(0, 9);
    }
    
    return $a;
}

/**
 * @name generateRandomString ( )
 * @param (int) $length
 *
 * @return (string) random string
 */
function generateRandomString($length = 10, $OnlyReadAble = true)
{
    
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' . uniqid();
    $characters .= (!$OnlyReadAble) ? '!@#$%^&*(){}[]:<>?/|~' : '';
    
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


/**
 * @todo - needs to be worked on....
 *
 *
 *
 */

function AuthenticateSession()
{
    
    if (!isset($_SESSION['loggedIn'])) {
        header("location: signin.php");
        exit;
    } else {
        
        
    }
    $_SESSION['start_time'] = time();
}

function getProtocol()
{
    if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        $protocol = 'https://';
    } else {
        $protocol = 'http://';
    }
    return $protocol;
}


function getRealIpAddr()
{
    switch (true) {
        case (!empty($_SERVER['HTTP_X_REAL_IP'])):
            return $_SERVER['HTTP_X_REAL_IP'];
        case (!empty($_SERVER['HTTP_CLIENT_IP'])):
            return $_SERVER['HTTP_CLIENT_IP'];
        case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        default:
            return $_SERVER['REMOTE_ADDR'];
    }
}


function validateLogin($uname, $pword)
{
    GLOBAL $dblink;
    
    $statement = $dblink->prepare("SELECT UserID,UserFirstName,UserLastName,UserPhone,UserEmail FROM SRC_users WHERE UserEmail =?");
    $statement->bind_param('s', $uname);
    $statement->execute();
    $statement->bind_result($userID, $uFName,$uLName,$uPhone,$uEm);
    $statement->store_result();
    $count = $statement->num_rows;
    
     file_put_contents("tmslog-$dateExt.txt", date("Y-m-d H:i(worry)") . print_r($statement->error, true)." \n", FILE_APPEND);
    
    
    
    
    if ($count == 1) {
        // login success
        /*while($row = mysql_fetch_array($result)){		  
        $myName=$row['fullName'];
        $uname=$row['userName'];
        $Rights=$row['myPermissions'];//defined user rights
        */
        while ($statement->fetch()) {
            
            $_SESSION['userid']   = $userID;
            $_SESSION['user_id']   = $userID;
            $_SESSION['name']     = $uFName.' '.$uLName;
            $_SESSION['email']    = $uEm;
            $_SESSION['phone']    = $uPhone;
            $_SESSION['loggedIn'] = TRUE;
            
            return 1;
           // header("Location: ./index.php");
            
            
        }
    } else {
      
        return 2;
        
    }
    $statement->free_result();
    
    
}
function getResultArray($result)
{
    $ll = 0;
    while ($rs = mysqli_fetch_assoc($result)) {
        foreach ($rs as $key => $value) {
            //echo $key ."=>".$value;
            $resultArray[$ll][$key] = $value;
        }
        $ll++;
        //$resultArray[] = $rs;
    }
    return $resultArray;
    
}

function execQuery($query, $getItem)
{
    GLOBAL $dblink;
    $result = $dblink->query($query);
  
    
   // $row    = mysqli_fetch_array($result);
    if ($getItem) {
        return mysqli_fetch_array($result)[0];
    } else
    {
        return getResultArray2($result);
    }
    
}

function getSearchForm()
{
    
    $searchForm = '<div class="box box-info" style="background-color: LightBlue">
                <div class="box-header with-border">
                  <h3 class="box-title">Data Loading Filters</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" role="form" action="javascript:void(0)">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="keywords" class="col-sm-2 control-label">Keywords: </label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="keywords" placeholder="Keywords">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="range" class="col-sm-2 control-label">Range: </label>
                    <div class="col-sm-10">
                    <div class="input-group">
                      <button class="btn btn-default pull-right" id="daterange-btn">
                        <i class="fa fa-calendar"></i> Date range
                        <i class="fa fa-caret-down"></i>
                      </button>
                    </div></div></div>

                    <div class="form-group">
                      <label for="loadSize" class="col-sm-2 control-label">Load: </label>
                      <div class="col-sm-10">
                        <select id="page_size" name="page_size" class="form-control">
			    <option value=200 " . ($_SESSION["page_size"] == "200" ? "selected" : "") . ">200</option>
			    <option value=500 " . ($_SESSION["page_size"] == "500" ? "selected" : "") . ">500</option>
			    <option value=1000 " . ($_SESSION["page_size"] == "1000" ? "selected" : "") . ">1000</option>
			    <option value=2000 " . ($_SESSION["page_size"] == "2000" ? "selected" : "") . ">2000</option>
			    <option value=5000 " . ($_SESSION["page_size"] == "5000" ? "selected" : "") . ">5000</option>
			    <option value=10000 " . ($_SESSION["page_size"] == "10000" ? "selected" : "") . ">10000</option>
			    <option value=20000 " . ($_SESSION["page_size"] == "20000" ? "selected" : "") . ">20000</option>
                      </select>
                      </div>
                    </div>
                                     </div><!-- /.box-body -->
                  <div class="box-footer">
                   
                    <button type="submit" id="dataFiltersBtn" class="btn btn-info pull-right">Submit</button>
                  </div><!-- /.box-footer -->
                </form>
              </div>';
    
    
    return $searchForm;
    
}

function sendEmail($to, $subject, $message, $from, $replyto, $toname, $ccList = array())
{
    
    $mail = new PHPMailer();
    $body = $message;
    //$body             = preg_replace("[\]",'',$body);
    
    $mail->IsSMTP(); // telling the class to use SMTP
    //$mail->Host       = "mail.google.com"; // SMTP server
    //$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
    
    $host     = execQuery("Select Value from parameters where Parameter = 'SMTP Server'", true);
    $port     = execQuery("Select Value from parameters where Parameter = 'SMTP Port'", true);
    $username = execQuery("Select Value from parameters where Parameter = 'SMTP Username'", true);
    $password = execQuery("Select Value from parameters where Parameter = 'SMTP Password'", true);
    
    file_put_contents("tmslog-$dateExt.txt", date("Y-m-d H:i(worry)") . " Send EMail using  $host $port $username ********* \n", FILE_APPEND);
    
    
    $mail->SMTPDebug  = false; // 1 = errors and messages
    $mail->SMTPAuth   = true; // enable SMTP authentication
    $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
    $mail->Host       = $host; // sets GMAIL as the SMTP server
    $mail->Port       = $port; // set the SMTP port for the GMAIL server 465
    $mail->Username   = $username; // GMAIL username
    $mail->Password   = $password; // GMAIL password
    $mail->SetFrom($from);
    $mail->AddReplyTo($replyto);
    {
        $mail->AddCC($ccItem);
    }
    
    $mail->Subject = $subject;
    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
    $mail->MsgHTML($body);
    $address = $to;
    $mail->AddAddress($address, $toname);
    if (!$mail->Send()) {
        //echo "Mailer Error: " . $mail->ErrorInfo;
        //  file_put_contents("tmslog-"+date("Y-m-d")."txt", date("Y-m-d H:i(worry)") . " Email to  $address From $from Failed: " . print_r($mail->ErrorInfo, true)."\n", FILE_APPEND);
        file_put_contents("tmslog-$dateExt.txt", date("Y-m-d H:i(worry)") . " Email to  $to From $from FAILED!!!: " . print_r($mail->ErrorInfo, true) . "\n", FILE_APPEND);
        
    } else {
        //file_put_contents("tmslog-"+date("Y-m-d")."txt", date("Y-m-d H:i(worry)") . " Email to  $address From $from Sent Succesfully: " . print_r($mail->ErrorInfo, true)."\n", FILE_APPEND);
        file_put_contents("tmslog-$dateExt.txt", date("Y-m-d H:i(worry)") . " Email to  $to From $from Sent Succesfully: \n", FILE_APPEND);
        
    }
    
}
function getResultArray2($result)
{
    $ll = 0;
    while ($rs = mysqli_fetch_assoc($result)) {
        foreach ($rs as $key => $value) {
            //echo $key ."=>".$value;
            $resultArray[$ll][$key] = $value;
        }
        $ll++;
        //$resultArray[] = $rs;
    }
    return $resultArray;
    
}

function generateGrid($title, $id, $query, $search, $print, $export, $checkbox, $col_nums, $pagination, $actions, $filters, $expander = true)
{
    GLOBAL $total_pages, $dblink;
    //include('include.php');
    
    $_SESSION['page_size'] = 10000;
    
    if ($search == '') {
        $search = false;
    }
    $search = false;
    if ($print == '') {
        $print = false;
    }
    if ($export == '') {
        $export = false;
    }
    if ($checkbox == '') {
        $checkbox = false;
    }
    if ($col_nums == '') {
        $col_nums = false;
    }
    // $content = saveData($query, $data_map);
    
    $content = $dblink->query($query);
    
    //var_dump($content);
    
    $resultArray = getResultArray2($content);
    
    
    
    $gridComponent = '<section class="content" id="dynamicContent">';
    
    
    $gridComponent .= " <div class='row'><div class='col-sm-6'> " . $actions . "</br></div>";
    $gridComponent .= " <div class='col-sm-2'>  <div class='alert alert-warning' id='info-notes' style='display:none'>
      information goes here
</div ><input type='hidden' id ='thisnote' name='thisnote' value='" . $_SESSION[notes] . "' /> </br></div>";
    $gridComponent .= "<div class='col-sm-4' style='text-align: right'>";
    $gridComponent .= "<form method='POST' class='gridSearch'>";
    #Add search button & Number of records per page
    if ($search) {
        $gridComponent .= "<input type='text' name='keywords' placeholder='Search'>
		<input type='submit' value='&nbsp;' class='searchButton gridSecondaryButton'>";
    }
    #Add print grid option
    $gridComponent .= '<div class="btn-group"><button id="reloadData" class="btn btn-info btn-sm" "><span class="glyphicon glyphicon-refresh"></span>  Refresh</button>&nbsp;';
    //  $gridComponent .='<button id="reloadData" class="btn btn-info btn-sm" onclick="reloadData()"><span class="glyphicon glyphicon-refresh"></span>  Refresh</button>';
    // $gridComponent .= "&nbsp;<button type='button'  id='reloadData' class='btn dt-button ' onclick='reloadData()'>Reload</button>";
    /*
    glyphicon glyphicon-refresh
    if ($print) {
    $gridComponent .= "&nbsp;<button type='button'  id='printGrid' class='btn btn-primary printButton gridSecondaryButton2'>Print</button>";
    }
    
    if ($export) {
    $gridComponent .= "&nbsp;<button type='button'  id='exportXLS' onclick='exportXls()' class='btn btn-primary exportxlsButton gridSecondaryButton2'>Export</button>";
    
    }*/
    $gridComponent .= "</div></form>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div> </div> ";
    
    $gridComponent .= ' <div class="row">
                <div class="col-lg-12">
               
                        <div id="listHeading" class="panel panel-heading col-lg-12">
                           <div  id="titleDiv" style="text-align: left" class="col-lg-3">' . $title . '(' . $total_pages . ')  </div>
                           <div  id="searchDiv" style="text-align: left" class="col-lg-3"></div>
                           <div  id="pageSizeDIv" style="text-align: right" class="col-lg-2">
                           </div>
                           
                           <div  id="filtersDiv" style="text-align: right" class="col-lg-4">
                                 <a data-toggle="collapse" href="#AsearchDiv">Filters</a>
                                 <div id="AsearchDiv" class="panel-collapse collapse">
				      <div class="panel-body">' . getSearchForm() . '</div>
				     
    			         </div>                                 
                           </div>

                           
                       </div>';
    $gridComponent .= '</div> </div>';
    
    
    $gridComponent .= ' <div class="row">
                <div class="col-xs-12">';
    
    $page = $_GET['id'];
    
    $gridComponent .= ' <div id="gridform" class="gridContent"></div>
                            
                             <div class="box">
                             <!-- <div class="box-header">
                             <h3 class="box-title">' . $title . '</h3>
                             </div>/.box-header -->';
    
    
    $gridComponent .= '                          <div class="box-body">

                           
                                <table id="example1" class="table table-bordered table-striped datatableClass">
                                <input type="hidden" id="this_page_id" value=' . $page . ' />

                                 
 
                             
                              <thead>

                                        <tr>';
    
    
    $headerCount = 0;
    if ($checkbox) {
        // $gridComponent .= "<th class='grid1of10 '><input type='checkbox' name='primarykey[]' value='all'/></th>";
        $gridComponent .= "<th><input type='checkbox' name='primarykey[]' value='all'/></th>";
        $headerCount = 1;
    }
    if ($col_nums) {
        //$gridComponent .= "<th class='grid1of10 '>No</th>";
        $gridComponent .= "<th>No</th>";
        $headerCount = $headerCount + 1;
    }
    $headerCount = $headerCount + mysqli_num_fields($content);
    $totalAmount = 0;
    $isAmount    = false;
    #Generate extra headers from column names
    $row         = 1;
    $amountVar   = '';
    
    $sizee = mysqli_num_fields($content);
    
    $sizee = $sizee;
    
    if ($expander) {
        $gridComponent .= "<th></th>";
    }
    
    
    while ($row < $sizee) {
        
        // $meta = strtoupper(mysqli_fetch_field_direct($content, $row));
        $finfo = mysqli_fetch_field_direct($content, $row);
        $meta  = strtoupper($finfo->name);
        
        switch ($meta) {
            case "PRIMARYKEY":
            case "CONFIRMABLE";
            case "R":
                break;
            default:
                $gridComponent .= "<th >" . ucwords(strtolower(str_replace("_", " ", trim($meta)))) . "</th>";
                if (strtoupper($meta) == "AMOUNT" || strtoupper($meta) == "TOTAL CHARGES") {
                    $isAmount  = true;
                    $amountVar = strtoupper($meta) == "AMOUNT" ? "AMOUNT" : "Total Charges";
                }
                break;
        }
        $row = $row + 1;
    }
    
    $gridComponent .= "</tr>";
    $gridComponent .= "</thead> <tbody>";
    $col_count = 0;
    $itemCount = mysqli_num_rows($content);
    #Generate grid row details
    
    foreach ($resultArray as $resul) {
        
        
        
        //  $gridComponent .= "<tr class='gridContentRecord' title='" . $row[1] . "'>";
        $gridComponent .= "<tr  title='" . $resul['primarykey'] . "'>";
        
        
        if ($checkbox) {
            $disabled = $resul[CONFIRMABLE] == "INCONFIRMABLE" ? "disabled='disabled'" : "";
            $gridComponent .= "<td ><input type='checkbox' name='primarykey[]' $disabled value='" . $resul[1] . "'/></td>";
        }
        
        
        if ($col_nums) {
            $col_count += 1;
            $gridComponent .= "<td>$col_count</td>";
        }
        $count = mysqli_num_fields($content);
        
        $y = 1;
        
        if ($expander) {
            $gridComponent .= "<td class= 'details-control'>  </td>";
        }
        
        
        while ($y < $count) {
            $finfo = mysqli_fetch_field_direct($content, $y);
            $meta  = $finfo->name;
            
            //   $meta ="Phone";
            
            $i = $y - 1;
            //$gridComponent .= $meta;
            
            
            
            
            $gridComponent .= "<td>$resul[$meta]</td>";
            
            
            $y = $y + 1;
        }
        
        $gridComponent .= "</tr>";
        
        
    }
    
    $gridComponent .= ' </tbody>
                                </table>
                            </div>';
    
    $gridComponent .= '                         <!-- /.table-responsive -->
                            <div class="well">
                                <h4><!--Footer Information--></h4>
                                <!--<img src="Shared/css/images/Footer_02-07.png" class="img-circle" width="100%" height="100%" alt="Header Logo">-->
       

                            </div>
                            </div>
                        
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div></section>';
    
    
    $gridComponent .= "<script> document.title='CHURCH-MIS | " . $title . "';
    
    
                       if ( $.fn.dataTable.isDataTable( '#example1' ) ) {
                            table = $('#example1').DataTable();
                            table.destroy();
                            }
                         else {

                          $('#example1').DataTable({

                                              dom: 'lBfrtip',
						    buttons: [
						    {
							extend: 'pdfHtml5',
							orientation: 'landscape',
							pageSize: 'LEGAL'
						    },
							 'excel', 'print'
						    ]

                                              });
                       
                       
                        $('.btn-group').append($('div.dt-buttons'));
                        $('#example1_filter').appendTo($('#searchDiv'));
                        $('#example1_length').appendTo($('#pageSizeDIv'));
                        
                        }

                         $('#daterange-btn').daterangepicker(
			    {
			      ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			      },
			      startDate: moment().subtract(29, 'days'),
			      endDate: moment()
			    },
			function (start, end) {
			  $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			}
			);

                           
                              

                     </script>";
    
    
    return $gridComponent;
}



function generateAccountsChildren($title, $id, $query, $search, $print, $export, $checkbox, $col_nums, $pagination, $actions, $filters, $expander = true,$parent)
{
    GLOBAL $total_pages, $dblink;
    //include('include.php');
    
    $_SESSION['page_size'] = 10000;
    
    if ($search == '') {
        $search = false;
    }
    $search = false;
    if ($print == '') {
        $print = false;
    }
    if ($export == '') {
        $export = false;
    }
    if ($checkbox == '') {
        $checkbox = false;
    }
    if ($col_nums == '') {
        $col_nums = false;
    }
    // $content = saveData($query, $data_map);
    
    $content = $dblink->query($query);
    
    //var_dump($content);
    
    $resultArray = getResultArray2($content);
    
    $gridComponent = '';    
    echo $tableid= "example$parent";
    
    
    
    $gridComponent .= '<table id="'.$tableid.'" class="table table-bordered  datatableClass">
                                <input type="hidden" id="this_page_id" value=' . $page . ' />';

                                 
    $headerCount = 0;
    if ($checkbox) {
         $gridComponent .= "<th class='grid1of10 '><input type='checkbox' name='primarykey[]' value='all'/></th>";
        $gridComponent .= "<th><input type='checkbox' name='primarykey[]' value='all'/></th>";
        $headerCount = 1;
    }
    if ($col_nums) {
        $gridComponent .= "<th class='grid1of10 '>No</th>";
        $gridComponent .= "<th>No</th>";
        $headerCount = $headerCount + 1;
    }
    $headerCount = $headerCount + mysqli_num_fields($content);
    $totalAmount = 0;
    $isAmount    = false;
    #Generate extra headers from column names
    $row         = 1;
    $amountVar   = '';
    
    $sizee = mysqli_num_fields($content);
    
    $sizee = $sizee;
    
    if ($expander) {
        $gridComponent .= "<th></th>";
    }
    
    
    while ($row < $sizee) {
        
        // $meta = strtoupper(mysqli_fetch_field_direct($content, $row));
        $finfo = mysqli_fetch_field_direct($content, $row);
        $meta  = strtoupper($finfo->name);
        
       switch ($meta) {
            case "PRIMARYKEY":
            case "CONFIRMABLE";
            case "R":
                break;
            default:
                $gridComponent .= "<th >" . ucwords(strtolower(str_replace("_", " ", trim($meta)))) . "</th>";
                if (strtoupper($meta) == "AMOUNT" || strtoupper($meta) == "TOTAL CHARGES") {
                    $isAmount  = true;
                    $amountVar = strtoupper($meta) == "AMOUNT" ? "AMOUNT" : "Total Charges";
                }
                break;
        }
        $row = $row + 1;
    }
    
    $gridComponent .= "<tbody>";
    $col_count = 0;
    $itemCount = mysqli_num_rows($content);
    #Generate grid row details
    
    foreach ($resultArray as $resul) {
        
        
        
        //  $gridComponent .= "<tr class='gridContentRecord' title='" . $row[1] . "'>";
        $gridComponent .= "<tr  title='" . $resul['primarykey'] . "'>";
        
        
        
        
        
      
        $count = mysqli_num_fields($content);
        
        $y = 1;
        
   
            $gridComponent .= "<td class= 'acct-details-control'>  </td>";
      
        
        
        while ($y < $count) {
            $finfo = mysqli_fetch_field_direct($content, $y);
            $meta  = $finfo->name;
            
            //   $meta ="Phone";
            
            $i = $y - 1;
            //$gridComponent .= $meta;
            
            
            
            
            $gridComponent .= "<td>$resul[$meta]</td>";
            
            
            $y = $y + 1;
        }
        
        $gridComponent .= "</tr>";
        
        
    }
    
    $gridComponent .= ' </tbody>
                                </table>';
                             
    
    return $gridComponent;
}


function generateChartOfAccounts($title, $id, $query, $search, $print, $export, $checkbox, $col_nums, $pagination, $actions, $filters, $expander = true)
{
    GLOBAL $total_pages, $dblink;
    //include('include.php');
    
    $_SESSION['page_size'] = 10000;
    
    if ($search == '') {
        $search = false;
    }
    $search = false;
    if ($print == '') {
        $print = false;
    }
    if ($export == '') {
        $export = false;
    }
    if ($checkbox == '') {
        $checkbox = false;
    }
    if ($col_nums == '') {
        $col_nums = false;
    }
    // $content = saveData($query, $data_map);
    
    $content = $dblink->query($query);
    
    //var_dump($content);
    
    $resultArray = getResultArray2($content);
    
    
    
    $gridComponent = '<section class="content" id="dynamicContent">';
    
    
    $gridComponent .= " <div class='row'><div class='col-sm-6'> " . $actions . "</br></div>";
    $gridComponent .= " <div class='col-sm-2'>  <div class='alert alert-warning' id='info-notes' style='display:none'>
      information goes here
</div ><input type='hidden' id ='thisnote' name='thisnote' value='" . $_SESSION[notes] . "' /> </br></div>";
    $gridComponent .= "<div class='col-sm-4' style='text-align: right'>";
    $gridComponent .= "<form method='POST' class='gridSearch'>";
    #Add search button & Number of records per page
    if ($search) {
        $gridComponent .= "<input type='text' name='keywords' placeholder='Search'>
		<input type='submit' value='&nbsp;' class='searchButton gridSecondaryButton'>";
    }
    #Add print grid option
    $gridComponent .= '<div class="btn-group"><button id="reloadData" class="btn btn-info btn-sm" "><span class="glyphicon glyphicon-refresh"></span>  Refresh</button>&nbsp;';
  
    $gridComponent .= "</div></form>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div> </div> ";
    
    $gridComponent .= ' <div class="row">
                <div class="col-lg-12">
               
                        <div id="listHeading" class="panel panel-heading col-lg-12">
                           <div  id="titleDiv" style="text-align: left" class="col-lg-3">' . $title . '(' . $total_pages . ')  </div>
                           <div  id="searchDiv" style="text-align: left" class="col-lg-3"></div>
                           <div  id="pageSizeDIv" style="text-align: right" class="col-lg-2">
                           </div>
                           
                           <div  id="filtersDiv" style="text-align: right" class="col-lg-4">
                                 <a data-toggle="collapse" href="#AsearchDiv">Filters</a>
                                 <div id="AsearchDiv" class="panel-collapse collapse">
				      <div class="panel-body">' . getSearchForm() . '</div>
				     
    			         </div>                                 
                           </div>

                           
                       </div>';
    $gridComponent .= '</div> </div>';
    
    
    $gridComponent .= ' <div class="row">
                <div class="col-xs-12">';
    
    $page = $_GET['id'];
    
    $gridComponent .= ' <div id="gridform" class="gridContent"></div>
                            
                             <div class="box">
                             <!-- <div class="box-header">
                             <h3 class="box-title">' . $title . '</h3>
                             </div>/.box-header -->';
    
    
    $gridComponent .= '                          <div class="box-body">

                           
                                <table id="example1" class="table table-bordered table-striped ">
                                <input type="hidden" id="this_page_id" value=' . $page . ' />

                                 
 
                             
                              <thead>

                                        <tr>';
    
    
    $headerCount = 0;
    if ($checkbox) {
        // $gridComponent .= "<th class='grid1of10 '><input type='checkbox' name='primarykey[]' value='all'/></th>";
        $gridComponent .= "<th><input type='checkbox' name='primarykey[]' value='all'/></th>";
        $headerCount = 1;
    }
    if ($col_nums) {
        //$gridComponent .= "<th class='grid1of10 '>No</th>";
        $gridComponent .= "<th>No</th>";
        $headerCount = $headerCount + 1;
    }
    $headerCount = $headerCount + mysqli_num_fields($content);
    $totalAmount = 0;
    $isAmount    = false;
    #Generate extra headers from column names
    $row         = 1;
    $amountVar   = '';
    
    $sizee = mysqli_num_fields($content);
    
    $sizee = $sizee;
    
    if ($expander) {
        $gridComponent .= "<th></th>";
    }
    
    
    while ($row < $sizee) {
        
        // $meta = strtoupper(mysqli_fetch_field_direct($content, $row));
        $finfo = mysqli_fetch_field_direct($content, $row);
        $meta  = strtoupper($finfo->name);
        
        switch ($meta) {
            case "PRIMARYKEY":
            case "CONFIRMABLE";
            case "R":
                break;
            default:
                $gridComponent .= "<th >" . ucwords(strtolower(str_replace("_", " ", trim($meta)))) . "</th>";
                if (strtoupper($meta) == "AMOUNT" || strtoupper($meta) == "TOTAL CHARGES") {
                    $isAmount  = true;
                    $amountVar = strtoupper($meta) == "AMOUNT" ? "AMOUNT" : "Total Charges";
                }
                break;
        }
        $row = $row + 1;
    }
    
    $gridComponent .= "</tr>";
    $gridComponent .= "</thead> <tbody>";
    $col_count = 0;
    $itemCount = mysqli_num_rows($content);
    #Generate grid row details
    
    foreach ($resultArray as $resul) {
        
        
        
        //  $gridComponent .= "<tr class='gridContentRecord' title='" . $row[1] . "'>";
        $gridComponent .= "<tr  title='" . $resul['primarykey'] . "'>";
        
        
        if ($checkbox) {
            $disabled = $resul[CONFIRMABLE] == "INCONFIRMABLE" ? "disabled='disabled'" : "";
            $gridComponent .= "<td ><input type='checkbox' name='primarykey[]' $disabled value='" . $resul[1] . "'/></td>";
        }
        
        
        if ($col_nums) {
            $col_count += 1;
            $gridComponent .= "<td>$col_count</td>";
        }
        $count = mysqli_num_fields($content);
        
        $y = 1;
        
        if ($expander) {
            $gridComponent .= "<td class= 'acct-details-control'>  </td>";
        }
        
        
        while ($y < $count) {
            $finfo = mysqli_fetch_field_direct($content, $y);
            $meta  = $finfo->name;
            
            //   $meta ="Phone";
            
            $i = $y - 1;
            //$gridComponent .= $meta;
            
            
            
            
            $gridComponent .= "<td>$resul[$meta]</td>";
            
            
            $y = $y + 1;
        }
        
        $gridComponent .= "</tr>";
        
        
    }
    
    $gridComponent .= ' </tbody>
                                </table>
                            </div>';
    
    $gridComponent .= '                         <!-- /.table-responsive -->
                            <div class="well">
                                <h4><!--Footer Information--></h4>
                                <!--<img src="Shared/css/images/Footer_02-07.png" class="img-circle" width="100%" height="100%" alt="Header Logo">-->
       

                            </div>
                            </div>
                        
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div></section>';
    
    
    $gridComponent .= "<script> document.title='NIC-SASA | " . $title . "';
    
    
                       if ( $.fn.dataTable.isDataTable( '#example1' ) ) {
                            table = $('#example1').DataTable();
                            table.destroy();
                            }
                         else {

                          $('#example1').DataTable({

                                              dom: 'lBfrtip',
						    buttons: [
						    {
							extend: 'pdfHtml5',
							orientation: 'landscape',
							pageSize: 'LEGAL'
						    },
							 'excel', 'print'
						    ]

                                              });
                       
                       
                        $('.btn-group').append($('div.dt-buttons'));
                        $('#example1_filter').appendTo($('#searchDiv'));
                        $('#example1_length').appendTo($('#pageSizeDIv'));
                        
                        }

                         $('#daterange-btn').daterangepicker(
			    {
			      ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			      },
			      startDate: moment().subtract(29, 'days'),
			      endDate: moment()
			    },
			function (start, end) {
			  $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			}
			);

                           
                              

                     </script>";
    
    
    return $gridComponent;
}
function generateTicketsGrid($title, $id, $query, $search, $print, $export, $checkbox, $col_nums, $pagination, $actions, $filters, $expander = true)
{
    GLOBAL $total_pages, $dblink;
    //include('include.php');
    
    $_SESSION['page_size'] = 10000;
    
    if ($search == '') {
        $search = false;
    }
    $search = false;
    if ($print == '') {
        $print = false;
    }
    if ($export == '') {
        $export = false;
    }
    if ($checkbox == '') {
        $checkbox = false;
    }
    if ($col_nums == '') {
        $col_nums = false;
    }
    // $content = saveData($query, $data_map);
    
    $content = $dblink->query($query);
    
    //var_dump($content);
    
    $resultArray = getResultArray2($content);
    
    $total_pages = count($resultArray);
    
    
    
    
    
    
    // </div> ";
    
    $gridComponent .= ' <div class="row">
                <div class="col-lg-12">
               
                        <div id="listHeading" class="panel panel-heading col-lg-12">
                           <div  id="titleDiv" style="text-align: left" class="col-lg-3"><h2>' . $title . '(' . $total_pages . ')  </h2></div>
                           <div  id="searchDiv" style="text-align: left" class="col-lg-3"></div>
                           <div  id="pageSizeDIv" style="text-align: right" class="col-lg-2">
                           </div>
                           
                     

                           
                       </div>';
    $gridComponent .= '</div> </div>';
    
    
    $gridComponent .= ' <div class="row">
                <div class="col-xs-12">';
    
    $page = $_GET['id'];
    
    $gridComponent .= ' <div id="gridform" class="gridContent"></div>
                            
                             <div class="box">
                             <!-- <div class="box-header">
                             <h2 class="panel-title">' . $title . '</h3>
                             </div>/.box-header -->';
    
    
    $gridComponent .= '                          <div class="box-body">

                           
                                <table id="example1" class="table table-bordered table-striped ">
                                <input type="hidden" id="this_page_id" value=' . $page . ' />

                                 
 
                             
                              <thead>

                                        <tr>';
    
    
    $headerCount = 0;
    if ($checkbox) {
        // $gridComponent .= "<th class='grid1of10 '><input type='checkbox' name='primarykey[]' value='all'/></th>";
        $gridComponent .= "<th><input type='checkbox' name='primarykey[]' value='all'/></th>";
        $headerCount = 1;
    }
    if ($col_nums) {
        //$gridComponent .= "<th class='grid1of10 '>No</th>";
        $gridComponent .= "<th>No</th>";
        $headerCount = $headerCount + 1;
    }
    $headerCount = $headerCount + mysqli_num_fields($content);
    $totalAmount = 0;
    $isAmount    = false;
    #Generate extra headers from column names
    $row         = 1;
    $amountVar   = '';
    
    $sizee = mysqli_num_fields($content);
    
    $sizee = $sizee;
    
    if ($expander) {
        $gridComponent .= "<th></th>";
    }
    
    
    while ($row < $sizee) {
        
        // $meta = strtoupper(mysqli_fetch_field_direct($content, $row));
        $finfo = mysqli_fetch_field_direct($content, $row);
        $meta  = strtoupper($finfo->name);
        
        switch ($meta) {
            case "PRIMARYKEY":
            case "CONFIRMABLE";
            case "R":
                break;
            default:
                $gridComponent .= "<th >" . ucwords(strtolower(str_replace("_", " ", trim($meta)))) . "</th>";
                if (strtoupper($meta) == "AMOUNT" || strtoupper($meta) == "TOTAL CHARGES") {
                    $isAmount  = true;
                    $amountVar = strtoupper($meta) == "AMOUNT" ? "AMOUNT" : "Total Charges";
                }
                break;
        }
        $row = $row + 1;
    }
    $gridComponent .= "<th>Action</th>";
    $gridComponent .= "</tr>";
    $gridComponent .= "</thead> <tbody>";
    $col_count = 0;
    $itemCount = mysqli_num_rows($content);
    #Generate grid row details
    
    foreach ($resultArray as $resul) {
        
        
        $pk = $resul['primarykey'];
        //  $gridComponent .= "<tr class='gridContentRecord' title='" . $row[1] . "'>";
        //   if($resul['Label'] == 'NEW')
        //    $banner = 'style ="border: 2px solid red;"';             
        //    else 
        //      $banner ='';
        $gridComponent .= "<tr  $banner title='" . $resul['primarykey'] . "'>";
        
        
        if ($checkbox) {
            $disabled = $resul[CONFIRMABLE] == "INCONFIRMABLE" ? "disabled='disabled'" : "";
            $gridComponent .= "<td ><input type='checkbox' name='primarykey[]' $disabled value='" . $resul[1] . "'/></td>";
        }
        
        
        if ($col_nums) {
            $col_count += 1;
            $gridComponent .= "<td>$col_count</td>";
        }
        $count = mysqli_num_fields($content);
        
        $y = 1;
        
        if ($expander) {
            $gridComponent .= "<td class= 'details-control'>  </td>";
        }
        
        
        while ($y < $count) {
            $finfo = mysqli_fetch_field_direct($content, $y);
            $meta  = $finfo->name;
            
            //   $meta ="Phone";
            
            $i = $y - 1;
            //$gridComponent .= $meta;
            
            
            if ($meta == 'Label')
                $gridComponent .= "<td style='width:150px'>$resul[$meta]</td>";
            else
                $gridComponent .= "<td>$resul[$meta]</td>";
            
            
            $y = $y + 1;
        }
        $gridComponent .= "<td> <button onclick='escalate(" . $pk . ")' class='btn-primary btn-sm btn-success'>Escalate</button></td>";
        $gridComponent .= "</tr>";
        
        
    }
    
    $gridComponent .= ' </tbody>
                                </table>
                            </div>';
    
    $gridComponent .= '                         <!-- /.table-responsive -->
                            <div class="well">
                                <h4><!--Footer Information--></h4>
                                <!--<img src="Shared/css/images/Footer_02-07.png" class="img-circle" width="100%" height="100%" alt="Header Logo">-->
       

                            </div>
                            </div>
                        
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>';
    
    
    $gridComponent .= "<script> document.title='NIC-SASA | " . $title . "';
    
    
                       if ( $.fn.dataTable.isDataTable( '#example1' ) ) {
                            table = $('#example1').DataTable();
                            table.destroy();
                            }
                         else {

                          $('#example1').DataTable({

                                              dom: 'lBfrtip',
						    buttons: [
						    {
							extend: 'pdfHtml5',
							orientation: 'landscape',
							pageSize: 'LEGAL'
						    },
							 'excel', 'print'
						    ]

                                              });
                       
                       
                        $('.btn-group').append($('div.dt-buttons'));
                        $('#example1_filter').appendTo($('#searchDiv'));
                        $('#example1_length').appendTo($('#pageSizeDIv'));
                        
                        }

                         $('#daterange-btn').daterangepicker(
			    {
			      ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			      },
			      startDate: moment().subtract(29, 'days'),
			      endDate: moment()
			    },
			function (start, end) {
			  $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			}
			);

                           
                              

                     </script>";
    
    
    return $gridComponent;
}
function GetValue($Get_Field, $Get_Table, $Where_Field, $Where_Value, $Other = '')
{
    Global $dblink;
    $query = "SELECT $Get_Field FROM $Get_Table WHERE $Where_Field='$Where_Value' $Other";
    $sql   = $dblink->prepare($query);
    $sql->execute();
    $res = $sql->get_result();
    
    $result = getResultArray($res);
    return $result[0][0];
    
}

function createSelect($name, $default, $query, $required, $selItem, $multiSelect = false) {
    GLOBAL $dblink, $database;
    $class = "class=";
    if ($required)
        $required = "required,";
    else
        $required = "";
    $multiple = '';
    if ($multiSelect) {
        $multiple = "multiple='multiple'";
        $multiSelect = 'multiselectd 3col active';
    } else
        $multiSelect = "";

    $select = "<select name='" . $name . "[]' id='$name' class='$required $multiSelect' $multiple>";
    if ($default != '')#First option
        $select .= "<option value=''>$default</option>";
    #Get elements from Query
    $result = mysql_db_query($database, $query, $dblink);
    while ($row = mysql_fetch_array($result)) {
        if ($selItem != '' && ($selItem == $row[0] ))
            $select .= "<option value='" . $row[0] . "' selected>". $row[1] . "</option>";
        else
            $select .= "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
    }
    $select .= "</select>";
    return $select;
}


?>
