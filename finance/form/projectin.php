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
    $sql                  = " SELECT ProjectTID as primarykey, ProjectID,
                              (select ProjectName from SRC_Projects WHERE SRC_Projects.ProjectID = SRC_ProjectTransactions.ProjectID)Project,
                              Amount,TransactionType,TransactingParty,Description,Channel,TimeofTransaction,createdBy 
                              from SRC_ProjectTransactions where TransactionType ='INCOME' AND ProjectID = '" . $_GET[cell] . "'";
    $result               = $dblink->query($sql);
    $row                  = mysqli_fetch_array($result);
    $projectId            = $row[1];
    $project              = $row[2];
    $transactionAmount    = $row[3];
    $transactionType      = $row[4];
    $party                = $row[5];
    $description          = $row[6];
    $channel              = $row[7];
    $timeOfTransaction    = $row[8];


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


<form name="projectin" role="form" method="POST" title="" class="form-horizontal" enctype="multipart/form-data" style="display: block;">


    <div class="form-group">
        <label class="control-label col-sm-2" for="name">Transaction Type:</label>
        <div class="col-sm-10">
          <select name="transactiontype" id="transactiontype">
              <option value="INCOME">INCOME</option>
              <option value="EXPENSE">EXPENSE</option>
          </select>

        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="name">Project:</label>
        <div class="col-sm-10">
            <?php $query = 'Select ProjectID, ProjectName From SRC_Projects';

            $select = createSelect('project','SelectProject',$query,true,$projectId);
            echo  $select;
            ?>

        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="name">Debit Party:</label>
        <div class="col-sm-10">


            <input type="text" name="party" id="party" class="form-control required" value="<?php
            echo $party;
            ?>" maxlength="255" placeholder="Received from (Name and Phone)">

        </div>
    </div>



    <div class="form-group">
        <label class="control-label col-sm-2" for="name">Group (Where applicable):</label>
        <div class="col-sm-10">


            <?php $query = 'Select GroupID ,GroupName, `GroupTypeID`, `GroupLabel` from SRC_Groups order by GroupName Asc';

            $select = createSelect('group','Select Group',$query,true,$group);
            echo  $select;
            ?>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="name">Channel:</label>
        <div class="col-sm-10">
            <?php $query = 'Select ChannelID,ChannelName From SRC_PaymentChannels  order by ChannelID Asc';

            $select = createSelect('channel','Select Channel',$query,true,$channel);
            echo  $select;
            ?>

        </div>
    </div>

    <div class="form-group" >
        <label class="control-label col-sm-2" for="DOB">Amount:</label>
        <div class="col-sm-10">
            <input type="money" name="amount" id="amount" class="form-control required" value="<?php
            echo $amount
            ?>" maxlength="255" placeholder="enter amount">

        </div>
    </div>

    <div class="form-group" >
        <label class="control-label col-sm-2" for="DOB">Time of transaction:</label>
        <div class="col-sm-10">
            <input type="datetime-local" name="transactiontime" id="transactiontime" class="form-control required" value="<?php
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
            <textarea name="description" id="description" class="form-control required" placeholder="enter details">
            <?php
                echo $description
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


