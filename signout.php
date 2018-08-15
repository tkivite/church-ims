<?php
session_start();
include("Shared/php/functions.php");
//auditAction("SYSTEM LOGOUT", $_SESSION['loggedInAs'] ." successfully logged out");
session_destroy();
header("location: signin.php?logout=5");
?>

