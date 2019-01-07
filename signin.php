<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header('X-Frame-Options: DENY');

header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Strict-Transport-Security: max-age=31536000");
#header("Content-Security-Policy: default-src 'none'; script-src 'self'; connect-src 'self'; img-src 'self'; style-src 'self';");

header("Cache-Control: private,no-store,no-cache, must-revalidate"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past



$currentCookieParams = session_get_cookie_params();

session_set_cookie_params($currentCookieParams["lifetime"], $currentCookieParams["path"], $currentCookieParams["secure"], $currentCookieParams["httponly"]);
//error_reporting(E_ERROR);

session_start();
include("Shared/php/functions.php");
$loginStatus = '';


if (isset($_POST["action"])) // Trigger
    {
    
    $pword = $_POST['password'];
    $uname = $_POST['login'];
    //call to login function 
    $loginStatus2 = validateLogin($uname, $pword);
    
    echo $loginStatus2;


    if ($loginStatus2 == 1) {
            
        header("Location: ./index.php");
            
            
        
    } else {
        //login failed
        echo "<script language=\"JavaScript\">\n";
        echo "alert('Username or Password was incorrect!');\n";
       // echo "window.location='signin.php'";
        echo "</script>";
        
    }
    
}
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ChurchMIS | SYSTEM</title>

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
    <!-- iCheck -->


<style>
    .panel-default>.panel-heading {
        color: white;
        background-color: #0d98ba;
        border-color: #0d98ba;
        font-size: 40px;
        font-weight: 700;
        text-align: center;
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default" style="border-color: #0d98ba;">
                    <div class="panel-heading" con>
                       <!-- <img src="Shared/css/images/User_Avatar-512.png"  width="50%" height="50%"  alt="Login Image">
                        -->

                        <img src="Shared/css/images/ccilogo-new.png"  width="15%" height="15%"  alt="Login Image"> ChurchMIS
                       
              
                    </div>
                    <div class="panel-body">
                        <form role="form" action="signin.php" name="signin" id="signin" method="POST" >
                            <fieldset>
                            
                               <div class="checkbox">
                                    <label>
                                                                <?php
//echo $loginStatus;
?>
                                    </label>



                                </div>
                                
                                <div class="form-group">
                                    <input class="form-control" placeholder="login" name="login" type="username" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                               
                                
                                
                                
                                <div class="checkbox">
                                    <label>
                                        Login to access the system | <span style=" text-align: right; padding:5px;">
                                            <a  href="forgotpassword.php"
                                                                                                                          style=" text-decoration: none; color: blue; text-align: right; " title="Forgot Password"
                                                                                                                          onclick="ForgotPassword()">Forgot Password?</a></span> <br/>
                                    </label>



                                </div>

                                <!-- Change this to a button or input when using this as a form -->

                                <input type="submit" name="action" value="Login"  class="btn btn-lg btn-success btn-block" />

                                <!--<a href="index.php" class="btn btn-lg btn-success btn-block">Login</a>-->
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
   <script src="frontend-template/plugins/jQuery/jQuery-2.1.4.min.js"></script>

    <!-- jQuery UI 1.11.4 
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip 
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="frontend-template/bootstrap/js/bootstrap.min.js"></script>
      <!-- DataTables -->
  
<script src="frontend-template/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="frontend-template/plugins/datatables/dataTables.bootstrap.min.js"></script>
 <script src="Shared/js/jquery.blockUI.js" type="text/javascript"></script>



    <script>
        $(function() {


            

            // Handle external links
            $('a[rel="external"]').click(function() {
                var href = $(this).attr('href');

                // Send external link event to Google Analaytics
                try {
                    _gaq.push(['_trackEvent','External Links', href.split(/\/+/g)[1], href]);
                } catch (e) {};

                window.open(href,'jr_'+Math.round(Math.random()*11));
                return false;
            });

            // Handle displaying of option links
            $('em.option').css({
                cursor: 'pointer',
                fontSize: '1.1em',
                color: '#333',
                letterSpacing: '1px',
                borderBottom: '1px dashed #BBB'
            }).click(function() {
                var self = $(this);
                var opt = $.trim(self.text());

                $('ol.dp-c:first').children('li').children('span').each(function() {
                    var self = $(this);
                    var text = self.text();
                    var srch = opt+':';

                    // If found, highlight and jump window to position on page
                    if (text.search(srch) !== -1) {
                        self.css('color','red');
                        window.location.hash = '#c-'+opt;
                        window.scrollTo(0,self[0].offsetTop);
                    }
                });
            });

        });
        $(document).ready(function() {
        
           selectedTab = localStorage.getItem('selectedTab');
           selectedPage = localStorage.getItem('selectedPage');
           console.log("Old Tab"+selectedTab);
           console.log("Old Page"+selectedPage);
           localStorage.setItem('selectedTab','');
           localStorage.setItem('selectedPage','');
           console.log("Removing Values: ");
           selectedTab = localStorage.getItem('selectedTab');
           selectedPage = localStorage.getItem('selectedPage');
            console.log("New Tab"+selectedTab);
           console.log("New Page"+selectedPage);
            $.reject({
                reject: { all: false,
                    msie5: true, msie6: true, msie7: true, msie9: true}, // Reject all renderers for demo
                close: true,
                display: ['firefox','chrome','msie'],
                header: 'SuperFrame<br>Your browser is not supported here', // Header Text
                paragraph1: 'Please install one of the many optional browsers below to proceed',
                closeMessage: 'By closing this window you acknowledge that your experience '+
                'on this website may be degraded' // Message below close window link
            }); // Customized Text

            return false;
        });
    </script>



</body>

</html>
