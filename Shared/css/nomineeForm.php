<?php
ini_set('display_errors', 0);
include '../../Shared/php/functions.php';

$firstname = '';
$lastname = '';
$lastname = '';
$email = '';
$password = '';

$sql = "SELECT
  FIRST_NAME,
  MIDDLE_NAME,
  LAST_NAME,
  ID_NUMBER,
  (SELECT EMAIL FROM NIC_NOMINEES_MAP WHERE NOMINEE_ID_FK=NOMINEE_ID AND CUSTOMER_ID_FK ='" . $_GET[c_id] . "')EMAIL,
  MSISDN,
  (SELECT ACTIVE_STATUS FROM NIC_NOMINEES_MAP WHERE NOMINEE_ID_FK='" . $_GET[cell_id] . "' AND CUSTOMER_ID_FK ='" . $_GET[c_id] . "')ACTIVE_STATUS,
  (SELECT TRX_CHANNEL FROM NIC_NOMINEES_MAP WHERE NOMINEE_ID_FK='" . $_GET[cell_id] . "' AND CUSTOMER_ID_FK ='" . $_GET[c_id] . "')TRX_CHANNEL,
  (SELECT LOAN_LIMIT FROM NIC_NOMINEES_MAP WHERE NOMINEE_ID_FK='" . $_GET[cell_id] . "' AND CUSTOMER_ID_FK ='" . $_GET[c_id] . "')LOAN_LIMIT,
  (SELECT CAN_BORROW FROM NIC_NOMINEES_MAP WHERE NOMINEE_ID_FK='" . $_GET[cell_id] . "' AND CUSTOMER_ID_FK ='" . $_GET[c_id] . "')CAN_BORROW,
  (SELECT CAN_APPROVE FROM NIC_NOMINEES_MAP WHERE NOMINEE_ID_FK='" . $_GET[cell_id] . "' AND CUSTOMER_ID_FK ='" . $_GET[c_id] . "')CAN_APPROVE
FROM NIC_BUSINESS_NOMINEES WHERE NOMINEE_ID='" . $_GET[cell_id] . "'";


GLOBAL $dblink;
$res = oci_parse($dblink, $sql);
oci_execute($res);
$row = oci_fetch_array($res);
$firstname = $row[0];
$middlename = $row[1];
$lastname = $row[2];
$id_number = $row[3];
$email = $row[4];
$msisdn = $row[5];
$active_status = $row[6];
$channel = $row[7];
$limit = $row[8];
$can_borrow = $row[9];
$can_approve = $row[10];
$customeridfk = 1;

echo $can_borrow;

?>
<script src="onboarding/js/admin.js"></script>

<div class="box box-primary">
    <div class="panel-heading panel-primary">
        <h3 class="panel-title">Nominee</h3>
    </div>
    <div class="box-body">

        <form name="nominees" role="form" method="POST" title="" class="form-horizontal" style="display: block;" onload="checkBusinessLimit()">

            <div class="form-group">
                <label class="control-label col-sm-2" for="msisdn">Phone Number:</label>
                <div class="col-sm-10">
                    <input type="text" name="msisdn" class="form-control required msisdn"
                           value="<?php echo ($msisdn <> '') ? $msisdn : '2547' ?>" maxlength="12"
                           placeholder="Enter Phone Number">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="firstname">First Name:</label>
                <div class="col-sm-10">
                    <input type="text" name="firstname" class="form-control" value="<?php echo $firstname ?>"
                           maxlength="128" placeholder="Enter first name">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="middlename">Middle Name:</label>
                <div class="col-sm-10">
                    <input type="text" name="middlename" class="form-control" value="<?php echo $middlename ?>"
                           maxlength="128" placeholder="Enter middle name (optional)">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="lastname">Last Name:</label>
                <div class="col-sm-10">
                    <input type="text" name="lastname" class="form-control" value="<?php echo $lastname ?>"
                           maxlength="128" placeholder="Enter last name">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="idnumber">ID Number:</label>
                <div class="col-sm-10">
                    <input type="text" name="idnumber" class="form-control required id_number"
                           value="<?php echo $id_number ?>" maxlength="128" placeholder="Enter Id Number">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Email:</label>
                <div class="col-sm-10">
                    <input type="text" name="email" class="form-control required email" value="<?php echo $email ?>"
                           maxlength="255" placeholder="Enter email ">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="loanlimit">Borrowing Limit(Amount in KES):</label>
                <div class="col-sm-10">
                    <input type="text" name="limit" id="nomineelimit" class="form-control required"
                           value="<?php echo $limit ?>" maxlength="128" placeholder="Enter Borrowing Limit">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="status">Status:</label>
                <div class="col-sm-10">
                    <select name="activestatus" class="form-control required">
                        <option value="1">Active</option>
                        <option value="0" <?php echo $active_status = 0 ? "selected" : "" ?>>Inactive</option>
                    </select>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="status">Can Borrow:</label>
                <div class="col-sm-10">
                    <select name="can_borrow" class="form-control required">
                        <option value="YES">YES</option>
                        <option value="NO" <?php echo $can_borrow == 'NO' ? "selected" : "" ?>>NO</option>
                    </select>

                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="status">Can Approve:</label>
                <div class="col-sm-10">
                    <select name="can_approve" class="form-control required">
                        <option value="YES">YES</option>
                        <option value="NO" <?php echo $can_approve == 'NO' ? "selected" : "" ?>>NO</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="status">Can Access USSD:</label>
                <div class="col-sm-10">
                    <select name="channel" class="form-control required">
                        <option value="ALL">YES</option>
                        <option value="NONE" <?php echo $channel == "NONE" ? "selected" : "" ?>>NO</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="email"></label>
                <div class="col-sm-10">

                    <?php echo(hasPermission("nominees", "3") ? '<button type="submit" name="action" value="Save" class="btn-primary btn-sm btn-success gridPrimaryButtonSubmit">Save</button>' : '') ?>
                    <button type="button" name="cancel" value="Cancel"
                            class="btn-primary btn-sm btn-danger gridSecondaryButton">Cancel
                    </button>
                    <input type="hidden" name="customeridfk" id="customeridfk" value="<?php echo $_GET[c_id] ?>"/>
                    <input type="hidden" name="mode" value=""/>
                    <input type="hidden" name="cell" value="<?php echo $_GET[cell_id] ?>"/>
                </div>

            </div>

        </form>

        <div class="well">
            <h4><!--Footer Information--></h4>
            <!--<img src="Shared/css/images/Footer_02-07.png" class="img-circle" width="100%" height="100%" alt="Header Logo">-->


        </div>
    </div>

</div>

<script type="text/javascript">

    $("[name='msisdn']").bind('change', function () {
        getMSISDNDetails();
    });
    
     $("#nomineelimit").on("focusout", function (){
        
        
        var customer_id =$('#customeridfk').val();
        var valuentered = $(this).val(); 
        
        console.log(customer_id+"-");
        console.log(valuentered);
        
        
        if(valuentered != "")
        {
         $.ajax({
            type: 'POST',
            url: 'Shared/php/process_form.php?f=BUSINESS_LIMIT_AJAX', // + formname,
            data: {
                'customer_id': customer_id
            },
            success: function (result) {
              console.log("Response "+result);
              //console.log("Success: ");
              if(valuentered < result ){
                  $(this).val(valuentered); 
                   console.log("OK less"+result);
                }
                else
                {
                    $("#nomineelimit").val(result); 
                    console.log("Not Ok larger"+result);
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                 console.log('Failure'+errorThrown);
            }
            });
            }
            else
            {
            $("#nomineelimit").attr("placeholder", "Please enter an amount");
            }
 
    });

    
   $( document ).ready(function() {

    
       console.log( "ready!" );
    
       var customer_id =$('#customeridfk').val();
             
        console.log("Cutomer: "+customer_id+"-");
        
        
        
        
         $.ajax({
            type: 'POST',
            url: 'Shared/php/process_form.php?f=BUSINESS_LIMIT_AJAX', // + formname,
            data: {
                'customer_id': customer_id
            },
            success: function (result) {
              console.log("Response "+result);
              //$("#nomineelimit").val(result);
             $("#nomineelimit").attr("placeholder", "< "+result);
            
            },
            error: function(jqXHR, textStatus, errorThrown){
                 console.log('Failure'+errorThrown);
            }
            });
 
    
});
    
    function getMSISDNDetails() {
        $("[name='firstname']").enabled = false;
        $.ajax({
            type: 'POST',
            url: 'Shared/php/process_form.php?f=NOMINEE_DETAILS_AJAX', // + formname,
            data: {
                'nomineemsisdn': $("[name='msisdn']").val()
            },
            success: function (result) {
                if (result != 'New Nominee' && result != '' && result != null) {
                    var r = result.split("|");
                    $("[name='firstname']").val(r[0]);
                    $("[name='middlename']").val(r[1]);
                    $("[name='lastname']").val(r[2]);
                    $("[name='idnumber']").val(r[3]);
                    $("[name='mode']").val("update");

                }
                else {
                    $("[name='mode']").val("new");
                }
            },
            complete: function () {

            }

        });
    }
</script>