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
    $sql                  = " SELECT TransactionID as PRIMARY_KEY, TransactionDetails,TransactionAmount,CreatedBy,TransactionConfirmed,TimeCreated,TimeOfTransaction  FROM SRC_Transactions WHERE  TransactionID = '" . $_GET[cell] . "'";
    $result               = $dblink->query($sql);
    $row                  = mysqli_fetch_array($result);
    $TransactionType      = $row[1];
    $TransactionAmount    = $row[2];
    $CreatedBy            = $row[3];
    $TransactionConfirmed = $row[4];
    $TimeCreated          = $row[5];
    $TimeOfTransaction    = $row[6];



    $title = "Edit Transaction";
}

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

             $select = createSelect('TransactionType','SelectTransactionType',$query,true,$TransactionType);
             echo  $select;
            ?>

        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="DOB">Line Amounts:</label>
        <div class="col-sm-10">
            <?php $channels = execQuery('Select ChannelID,ChannelName From SRC_PaymentChannels  order by ChannelID Asc');
           // var_dump($channels);
            $i = 0;
            foreach ($channels as $item) {
            ?>
            <div class="input-group">
                <div class="input-group-addon" style="width: 120px !important;background-color: lightgrey;">
                    <?php echo $item['ChannelName']; ?>
                </div>
                <input type="number" min="0.00" max="10000.00" step="0.01" name="<?php echo 'amount_'.$i; ?>" class="form-control" placeholder="Amount">
                <input type="hidden" name="<?php echo 'channel_'.$i; ?>" value="<?php  echo $item['ChannelID'];  ?>"/>
            </div>

                <?php

            }


            ?>
        </div>
        <!-- /.input group -->
    </div>

    <div class="form-group" >
        <label class="control-label col-sm-2" for="DOB">Time of transaction:</label>
        <div class="col-sm-10">
            <input type="datetime-local" name="TransactionTime" id="TransactionTime" class="form-control required" value="<?php
            echo $TimeOfTransaction
            ?>" maxlength="255" placeholder="enter term">

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
        </div>

    </div>

</form>

</div>





