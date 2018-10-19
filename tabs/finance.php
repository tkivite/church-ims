<section class="content" id="dynamicContent">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="panel-heading panel-primary">

                    <h2>Finance  </h2><span> Helps you manage financial records including, payments and receipts,budgets,payroll, chart of accounts etc </span>
                </div>


                    <div class="box-body ">



                        <?php
     ini_set('display_errors','0');
        include("../Shared/php/dblink.php");

    include("../Shared/php/functions.php");
     GLOBAL $dblink;
 $strQuery = "SELECT MENU_NAME,URL,PRMS_ID,ICON_TAG,DESCRIPTION FROM SRC_prmssns P WHERE PRMS_ID IN 
(SELECT SRC_rolepermissions.PermissionID FROM SRC_rolepermissions WHERE SRC_rolepermissions.RoleID IN 
(SELECT ROLEID FROM SRC_userroles WHERE SRC_userroles.UserID = " . $_SESSION['user_id'] . ")) 
AND MENU_LEVEL = 1 AND IS_MENU = 1 AND MODULE = 'Finance' ORDER BY MENU_POS ASC";   
 
      /*  $res = oci_parse($dblink, $strQuery);
        oci_execute($res);
        $resultArray = getResultArray($res);
       * *
       */
        
        $resultArray = execQuery($strQuery);

  
                if (count($resultArray) > 0) {
                     foreach ($resultArray as $row) {
                         echo '    <a href="' . $row["URL"] . '#" class="loaddata"  >';

                         ?>

                            <div class="col-md-3 col-sm-6 col-xs-12">


                                <div class="info-box">
                                    <span class="info-box-icon bg-blue"> <?php echo  $row["ICON_TAG"];?></span>

                                    <div class="info-box-content">
                                        <span class="info-box-number"><?php echo    $row["MENU_NAME"]; ?></span>
                                        <span class="info-box-title"><?php echo   $row["DESCRIPTION"]; ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                            </a>

                            <?php
                                                    
                     }
                }
?>

                    </div>
                </div>

            </div>
    </div>
</section>