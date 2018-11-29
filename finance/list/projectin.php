<?php
/**
 * Created by PhpStorm.
 * User: tkivite
 * Date: 8/27/18
 * Time: 1:12 PM
 */

ini_set('display_errors', 1);
include '../../Shared/php/functions.php';
GLOBAL $dblink;
//(Select `TransactionType` From SRC_TransactionTypes WHERE SRC_TransactionTypes.TransactionTypeID = SRC_Transactions.TransactionTypeID)
//(Select ChannelName From SRC_PaymentChannels WHERE ChannelID = TransactionChannelID)Channel,
//select concat(UserFirstName,\' \', UserLastName) from SRC_users where UserID = CreatedBy)
//(case When TransactionConfirmed = 0 then \'Not Confirmed\' else \'Confirmed\' end)Confirmed

$title = "New Transaction";
$cell  = $_GET['cell'];
if (isset($_GET[cell])) {
    $sql                  = " SELECT TransactionID as PRIMARY_KEY, TransactionDetails,TransactionAmount,CreatedBy,TransactionConfirmed,TimeCreated,TimeOfTransaction,TransactionChannelID,TransactionAmount,TransactionMemberID  FROM SRC_Transactions WHERE  TransactionID = '" . $_GET[cell] . "'";
    $result               = $dblink->query($sql);
    $row                  = mysqli_fetch_array($result);
    $transactionType      = $row[1];
    $transactionAmount    = $row[2];
    $createdBy            = $row[3];
    $transactionConfirmed = $row[4];
    $timeCreated          = $row[5];
    $timeOfTransaction    = $row[6];
    $channel              = $row[7];
    $amount               = $row[8];
    $member               = $row[9];

    $title = "Edit Transaction";
}
echo 'Modede--' . $_GET['mode'];
?>


 <div class="box box-primary">
                            <div class="panel-heading panel-primary">
                             <h3 class="panel-title"><?php
echo $title;
?></h3>
                             </div>
                             <div class="box-body">


<form name="moneyin" role="form" method="POST" title="" class="form-horizontal" enctype="multipart/form-data" style="display: block;">


    <div class="form-group">
        <label class="control-label col-sm-2" for="name">Transaction Type:</label>
        <div class="col-sm-10">
            <?php $query = 'Select TransactionTypeID,`TransactionType` From SRC_TransactionTypes where AccountID in (select AccountID from SRC_Accounts where Category =\'Income\') ';

             $select = createSelect('TransactionType','SelectTransactionType',$query,true,$transactionType);
             echo  $select;
            ?>

        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="name">Debit Party:</label>
        <div class="col-sm-10">


            <input type="text" name="party" id="party" class="form-control required" value="<?php
            echo $member;
            ?>" maxlength="255" placeholder="Received from (Name and Phone)">

        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="name">Member:</label>
        <div class="col-sm-10">
            <?php $query = 'select MemberID,concat(FirstName,\' \',MiddleName,\' \',LastName)Member from SRC_Members order by 2 asc';

            $select = createSelect('member','Not Applicable',$query,true,$member);
            echo  $select;
            ?>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="name">Channel:</label>
        <div class="col-sm-10">
            <?php $query = 'Select ChannelID,ChannelName From SRC_PaymentChannels  order by ChannelID Asc';

            $select = createSelect('Channel','Select Channel',$query,true,$channel);
            echo  $select;
            ?>

        </div>
    </div>

    <div class="form-group" >
        <label class="control-label col-sm-2" for="DOB">Amount:</label>
        <div class="col-sm-10">
            <input type="money" name="Amount" id="Amount" class="form-control required" value="<?php
            echo $amount
            ?>" maxlength="255" placeholder="enter amount">

        </div>
    </div>

    <div class="form-group" >
        <label class="control-label col-sm-2" for="DOB">Time of transaction:</label>
        <div class="col-sm-10">
            <input type="datetime-local" name="TransactionTime" id="TransactionTime" class="form-control required" value="<?php
            echo $timeOfTransaction
            ?>" maxlength="255" placeholder="enter time of transaction">

        </div>
        </div>

    <div class="form-group" >
        <label class="control-label col-sm-2" for="DOB">Reference:</label>
        <div class="col-sm-10">
            <input type="text" name="reference" id="reference" class="form-control required" value="<?php
            echo $reference
            ?>" maxlength="255" placeholder="enter reference">

        </div>
    </div>

    <div class="form-group" >
        <label class="control-label col-sm-2" for="DOB">Details:</label>
        <div class="col-sm-10">
            <textarea name="details" id="details" class="form-control required" placeholder="enter details">
            <?php
                echo $details
                ?></textarea>
        </div>
    </div>






    <div class="form-group">
        <label class="control-label col-sm-2" for="email"></label>
        <div class="col-sm-10">

            <button type="submit" name="action" value="Save" class="btn-primary btn-sm btn-success gridPrimaryButtonSubmit">Save</button>
            <button type="button" name="cancel" value="Cancel" class="btn-primary btn-sm btn-danger gridSecondaryButton">Cancel</button>
            <input type="hidden" name="cell" value="<?php
            echo $_GET[cell];
            ?>"/>
            <input type="hidden" name="recordscount" value="<?php
            echo $recordCount;
            ?>"/>

    </div>

</form>

</div>


     <script>
         $(document).ready(function(e) {
             // var currentEmail = document.getElementById("Email").value;
             // loadTicketList(currentEmail);


             $("#party").typeahead({

                 source: function(query, result) {
                     //console.log(this.element);
                     var serchKey = this.$element.attr('id');
                     $.ajax({
                         url: "Shared/php/process_form.php?f=AUTOCOMPLETE_AJAX",
                         data: {
                             serchkey: serchKey,
                             query: query
                         },

                         type: "POST",
                         dataType: "json",

                         success: function(data) {
                             result($.map(data, function(item) {
                                 return item;
                             }));
                         }
                     });
                 },

                 afterSelect: function(item) {
                     var serchKey = this.$element.attr('id');
                     autoCompleteOtherFields(serchKey, item);
                 }
             });

         });
     </script>


