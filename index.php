<!DOCTYPE html>
<?php
header('X-Frame-Options: DENY');
ini_set('display_errors', 0);

error_reporting(E_ERROR);





header("X-Frame-Options: DENY");
//set headers to NOT cache a page
header("Cache-Control: private,no-store,no-cache"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Strict-Transport-Security: max-age=31536000");
ini_set('display_errors', 1);

$currentCookieParams = session_get_cookie_params();

session_set_cookie_params($currentCookieParams["lifetime"], $currentCookieParams["path"], $currentCookieParams["secure"], $currentCookieParams["httponly"]);




session_start();

include("Shared/php/dblink.php");
include("Shared/php/functions.php");
//include("Shared/php/api.php");
//require_once 'vendor/autoload.php';

AuthenticateSession();



?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CHURCH INFORMATION MANAGEMENT | SYSTEM</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="frontend-template/bootstrap/css/bootstrap.min.css">
     <link rel="stylesheet" href="Shared/css/nicsasa.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="Shared/css/font-awesome.min.css"> 
    <!-- Ionicons -->
    <link rel="stylesheet" href="Shared/css/ionicons.min.css">  
    <!-- Theme style -->
    <link rel="stylesheet" href="frontend-template/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="frontend-template/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="frontend-template/plugins/datatables/dataTables.bootstrap.css"> 
    <link rel="stylesheet" href="Shared/css/buttons.dataTables.min.css">


    
    <!-- daterange picker -->
    <link rel="stylesheet" href="frontend-template/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="frontend-template/plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="frontend-template/plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="frontend-template/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="frontend-template/plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="frontend-template/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="frontend-template/dist/css/skins/_all-skins.min.css">
   
    <link rel="stylesheet" href="Shared/css/bootstrap-datetimepicker.min.css">      
    <link rel="stylesheet" href="Shared/css/nav-wizard.bootstrap.css">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery 2.1.4 -->
    <script src="frontend-template/plugins/jQuery/jQuery-2.1.4.min.js"></script>

    <!-- jQuery UI 1.11.4 
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip 
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="frontend-template/bootstrap/js/bootstrap.min.js"></script>
      <script src="Shared/js/jquery.blockUI.js" type="text/javascript"></script>

      <!--<script type="text/javascript" src="reports/js/jquery-latest.js"></script> -->
      <script type="text/javascript" src="reports/js/jquery.tablesorter.js"></script>
      <!--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
      <script type="text/javascript" src="reports/js/tableExport.js"></script>
      <script type="text/javascript" src="reports/js/jquery.base64.js"></script>
     <!--<script src="frontend-template/plugins/datatables/jquery.dataTables.min.js"></script>
      <script src="frontend-template/plugins/datatables/dataTables.bootstrap.min.js"></script>
      <!-- DataTables -->
        <script src="frontend-template/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="frontend-template/plugins/datatables/dataTables.bootstrap.min.js"></script>

        <script src="Shared/js/typeahead.js"></script>





<script src="Shared/js/dataTables.buttons.min.js"></script>
<script src="Shared/js/jszip.min.js"></script>
<script src="Shared/js/pdfmake.min.js"></script>
<script src="Shared/js/vfs_fonts.js"></script>
<script src="Shared/js/buttons.html5.min.js"></script>
<script src="Shared/js/buttons.print.min.js"></script>
<script src="Shared/js/buttons.flash.min.js"></script>

 
    <!-- Select2 -->
    <script src="frontend-template/plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="frontend-template/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="frontend-template/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="frontend-template/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="Shared/js/moment.min.js"></script>
    <script src="frontend-template/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="frontend-template/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="frontend-template/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="frontend-template/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="frontend-template/plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="frontend-template/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->

    <!-- AdminLTE for demo purposes -->
    <script src="frontend-template/dist/js/demo.js"></script>
    <script src="Shared/js/bootstrap-datetimepicker.min.js"></script>
  
     <!-- Custom js -->
   <!-- <script src="Shared/js/jquery.blockUI.js" type="text/javascript"></script>-->

    <script src="Shared/js/index.js" type="text/javascript"></script>
    <script src="Shared/js/events.js" type="text/javascript"></script>
    <!--<script src="Shared/js/jquery.blockUI.js" type="text/javascript"></script>-->
      <script src="frontend-template/dist/js/app.min.js"></script>

    
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
    
      <input type="hidden" id='reloadedContent' value='YES'/>           
          <!--<header class="main-header"><?php //include("./pages/header.php")
?></header>  -->
          <?php

$_SESSION[notes] = '';

          //$modules_array = array( "Administration","Approvals", "Messaging","Finance", "Reports", "Master Records", "Settings","User Administration"); //
          $modules_array = array( "Administration","Finance", "Reports", "Master Records", "Settings","User Administration"); //

          $user_id = $_SESSION['user_id'];
//print_r_html($_SESSION);
//$uri = "modules/$user_id";
/*$modules_arrayF = json_decode(fetchJsonData($uri));


$temp_modules = array();
foreach($modules_arrayF as $row)
{
$temp_modules[ strtoupper( $row -> MODULE ) ] = $row -> MODULE;
}



#first collect the menus we've identified (to allow to list them in this order)
foreach ($modules_array as $value)
if (isset($temp_modules[strtoupper($value)]))
$modules [] = $temp_modules[strtoupper($value)];


#then collect any we may not have listed. to come after the ordered menu
foreach ($modules_array as $key => $value)
if (!isset($temp_modules[strtoupper($value)]) && $temp_modules[strtoupper($value)] <> '')
$modules [] = $temp_modules[strtoupper($value)];
*/
$modules = $modules_array;
// print_r_html($modules);

?>

         <tabbedheader class="main-header"> 
         <nav class="navbar tabbednavbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <ul class="nav nav-tabs">

            <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>MIS</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>CHURCH MIS</b></span>
        </a>
            <!-- Sidebar toggle button-->
 
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <li class="active"><a data-toggle="tab" href="#dashboard" class="dashboardtab" ><i class="fa fa-dashboard"> Dashboard</i></a></li>
          <li ><a data-toggle="tab" href="#test" style="display:none;">Test</a></li>
            <?php
           
           $resolve=1;
          
           $adminicon = '<i class="fa fa-book"></i>';
           $messageicon = '<i class="fa fa-envelope"></i>';
           $reporticon = '<i class="fa fa-list"></i>';
           $settingicon = '<i class="fa fa-gear"></i>';
           $recordsicon = '<i class="fa fa-table"></i>';
           $approvalicon = '<i class="fa fa-edit"></i>';
           $diagosisicon = '<i class="fa fa-search"></i>';
           $usericon = '<i class="fa fa-user"></i>';
           $tabicon='';
          
          
           foreach ($modules as $item)
               {
               $moduletitle=$item;
               $moduletab = preg_replace('/\s+/', '', strtolower($item));
                switch($moduletab)
                     {
                      case "administration":
                            $tabicon = $adminicon;
                      break;
                      case "messaging":
                            $tabicon = $messageicon;
                      break;
                      case "reports":
                            $tabicon = $reporticon;
                      break;
                      case "masterrecords":
                            $tabicon = $recordsicon;
                      break;
                      case "settings":
                            $tabicon = $settingicon;
                      break;
                      case "diagnosis":
                            $tabicon = $diagnosisicon;
                      break;
                      case "useradministration":
                            $tabicon = $usericon;
                      break;
                       case "approvals":
                            $tabicon = $approvalicon;
                      break;
                      default:
                            $tabicon =  $settingicon;

                      }
               
               echo '<li><a data-toggle="tab" class="mymenutabs '.$moduletab.'" href="#'.$moduletab.'">'.$tabicon.' '. $item .'</a></li> '; 
               $resolve++; 
               }
?>
            <li> <a href="signout.php" class="btn btn-danger btn-xs"><i class="fa fa-sign-in"></i> Logout  </a></li>
         
                  <li>
              
            <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              
              <!-- Control Sidebar Toggle Button -->
                 <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="Shared/css/images/userImg1.png" class="user-image" alt="User Image">
                  
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="Shared/css/images/userImg1.png" class="img-circle" alt="User Image">
                    <p>
                      <?php
echo $_SESSION['Name'] . " - " . $_SESSION['Email'];
?> 
                      
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <!--<li class="user-body">
                  Password Expires in: <?php
echo $_SESSION['DAYS_TO_PASS_EXPIRY'];
?> Days 
                  </li>-->
                  <!-- Menu Footer-->
                  <!--<li class="user-footer">
                    <div class="pull-left">                      
                      <a href="changepassword.php"  class="btn btn-primary btn-flat">Change Password  </a>
                    </div>-->
                    <div class="pull-right">
                      <a href="signout.php" class="btn btn-danger btn-flat">Logout  </a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
           </li>

	  </ul>

            
          <div class="tab-content">
                  
		 <div id="dashboard" class="tab-pane fade in active">
		     <div class="content-wrapper" id="dashboard">
                     
		     </div>   
                 </div>
		 
		    <div id="test" class="tab-pane fade in active" style="display:none;">
		     <div class="content-wrapper" id="test" style="display:none;">
                     		    	    
		    
                     </div> </div> 
		     
		 
             
		  <?php
$i = 1;
foreach ($modules as $item) {
    $moduletitle = $item;
    $id          = 'dynamicWrapper' . $i;
    
    
    $moduletab = preg_replace('/\s+/', '', strtolower($item));
    echo '<div id="' . $moduletab . '" class="tab-pane fade in"><div class="content-wrapper"  id="' . $moduletab . '" >';
    
    
    include("./tabs/sidebar.php");
    //include('./tabs/'.$moduletab.'.php');
    
    
    echo '</div></div>';
    $i++;
}

?>
              
          </div>
          
          
         
          
         </nav>
  
         
         
        </tabbedheader>    

    

      <?php
include("./footer.php");
?>
      <!--<footer class="main-footer"> </footer>

       Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark"></aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    

<!--<div id="modal-7" class="modal hide fade">
    <div class="modal-header">
      <button class="close" data-dismiss="modal">&times;</button>
      <h3>Title</h3>
    </div>
    <div class="modal-body">            
        <div id="modalContent" style="display:block;">

    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-info" data-dismiss="modal" >Close</a>
    </div>
</div>-->



 <div class="alert alert-info" style="position: fixed; width: 100%; height: 100%; left: 0; top: 55;">
  <strong>Info!</strong> Indicates a neutral informative change or action.
</div >
 
 
 
    
  </body>
</html>




