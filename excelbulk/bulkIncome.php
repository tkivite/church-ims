<link rel="stylesheet" type="text/css" href="../../church-ims-test/excelbulk/handsontable.full.min.css">
<!--<link rel="stylesheet" type="text/css" href="../../api/handonExcelupdate/main.css">-->
<script src="../../church-ims-test/excelbulk/handsontable.full.min.js"></script>

<?php
/**
 * Created by PhpStorm.
 * User: tkivite
 * Date: 9/11/18
 * Time: 9:42 AM
 */

ini_set('display_errors', 0);
//error_reporting(E_ALL);

//include("../Shared/php/dblink.php");
include '../Shared/php/functions.php';
Global $dblink;

//echo $_SESSION['testing4'];
$collcount = 8;

$i = 0;

$vals = array();
$r = 0;

//while ($r < 20) {
//    $data['First_Name'] = '';
//    $data['Middle_Name'] = '';
//    $data['Last_Name'] = '';
//    $data['Phone_Number'] = '';
//    $data['Amount'] = 0;
//    $data['Job_Group'] = '';
//    $data['Province'] = 'Select Province';
//    $data['County'] = 'Select County';
//    $data['District'] = 'Select District';
//    $data['Payment_Type'] = 'Select Payment Type';
//    $data['Budget_Line'] = 'Select Budget Line';
//    $vals[] = $data;
//    $r++;
//}

$data0 = json_encode($vals);
$datat = addcslashes($data0, "'&^`!@#%");

$confirmed = "['Confirmed','Not Confirmed']";

//Get counties
$sql1 = "select MemberID,concat(FirstName,' ',MiddleName,' ',LastName)Member from SRC_Members order by 2 asc";
$res1 = $dblink->query($sql1);

$members = "[";
while ($row1 = mysqli_fetch_array($res1)) {
    $members .= "'" . $row1[1] . "',";
}
$members .= "]";

$sql2 = "SELECT TransactionTypeID,TransactionType FROM SRC_TransactionTypes where AccountID in (select AccountID from SRC_Accounts where Category ='Income') ORDER BY 2 asc";
$res2 = $dblink->query($sql2);
$transactionType= "[";
while ($row2 = mysqli_fetch_array($res2)) {
    $transactionType .= "'" . $row2[1] . "',";
}
$transactionType .= "]";


//Get District
$sql3 = "Select ChannelID,ChannelName From SRC_PaymentChannels  order by 2 Asc";
$res3 = $dblink->query($sql3);
$channels = "[";
while ($row3 = mysqli_fetch_array($res3)) {
    $value = str_replace("'", "",$row3[1]);
    $channels .= "'" . $value . "',";
}
$channels .= "]";
/*
//Payment type
$sql4 = "SELECT id,title FROM ordertype WHERE InTrash = 'no' and id in (SELECT ordertypeId FROM org_ordertype where approvalOrder like '6%') ORDER BY 2 asc";
$res4 = $dblink->query($sql4);
$payment_type = "[";
while ($row4 = mysqli_fetch_array($res4)) {
    $payment_type .= "'" . $row4[1] . "',";
}
$payment_type .= "]";


//Get budget
$sql5 = "SELECT id, title FROM budget WHERE InTrash = 'no'  ORDER BY 2 asc";
$res5 = $dblink->query($sql5);
$budgets = "[";
while ($row5 = mysqli_fetch_array($res5)) {
    $budgets .= "'" . $row5[1] . "',";
}
$budgets .= "]";

//echo $datat;
*/
?>
<div class="box box-primary">
    <div class="panel-heading panel-primary">
        <h3 class="panel-title">


           Income in Bulk
        </h3>
    </div>
    <div class="box-body">

        <form method="POST" id="a" action="" class="newEntry panel-title" >


            <div class="col-sm-7">


                <div class="form-group">
                    <label class="control-label col-sm-4" for="name">Number of Records:</label>
                    <div class="col-sm-4">
                        <input type="text" name="numrows" id="numrows" value="" class=" form-control required" placeholder="Enter number of records to be added">
                    </div>
                    <div class="col-sm-4">
                        <input type="submit" value="Load Rows" name="submit" class="Buttonsearch gridSecondaryButton3"></div>
                </div>
            </div>

        </form>
        &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;




        <form name="BULK_INCOME" method="POST" title="" class="HOUPTATEEXCEL" style="display: block;">


    <div id="hot" style="width: 100%; height: 70%; overflow: hidden; z-index: 0"></div>
    <script>
        var dataObject =<?php echo $datat; ?>;

        console.log('data object' + dataObject);

        var currencyCodes = ['EUR', 'JPY', 'GBP', 'CHF', 'CAD', 'AUD', 'NZD', 'SEK', 'NOK', 'BRL', 'CNY', 'RUB', 'INR', 'TRY', 'THB', 'IDR', 'MYR', 'MXN', 'ARS', 'DKK', 'ILS', 'PHP'];
        var flagRenderer = function (instance, td, row, col, prop, value, cellProperties) {
            var currencyCode = value;
            while (td.firstChild) {
                td.removeChild(td.firstChild);
            }
            if (currencyCodes.indexOf(currencyCode) > -1) {
                var flagElement = document.createElement('DIV');
                flagElement.className = 'flag ' + currencyCode.toLowerCase();
                td.appendChild(flagElement);
            } else {
                var textNode = document.createTextNode(value === null ? '' : value);
                td.appendChild(textNode);
            }
        };

        var hotElement = document.querySelector('#hot');
        var hotElementContainer = hotElement.parentNode;
        var hotSettings = {
            data: dataObject,
            columns: [
                {
                    data: 'Member',
                    type: 'autocomplete',
                    source: <?php echo $members; ?>
                },
                {
                    data: 'Phone_Number',
                    type: 'text'
                },
                {
                    data: 'Amount',
                    type: 'text'
                },
                {
                    data: 'Transaction_Type',
                    type: 'dropdown',
                    source: <?php echo $transactionType; ?>
                },
                {
                    data: 'Channel',
                    type: 'dropdown',
                    source: <?php echo $channels; ?>
                },
                {
                    data: 'Confirmed',
                    type: 'dropdown',
                    source: <?php echo $confirmed; ?>
                },
                {
                    data: 'Notes',
                    type: 'text'
                 }
            ],
            stretchH: 'all',
            // width: 1200,
            autoWrapRow: true,
            height: 300,
            maxRows: 22,
            rowHeaders: true,
            colHeaders: [
                'Member',
                'Phone Number(254)',
                'Amount',
                'Transaction Type',
                'Channel',
                'Confirmed',
                'Notes'

            ],
            fixedRowsTop: 0,
            fixedColumnsLeft: 5,
            columnSorting: true,
            sortIndicator: true,
            autoColumnSize: {
                samplingRatio: 23
            },
            mergeCells: true,
            manualRowResize: true,
            manualColumnResize: true,
            manualRowMove: true,
            manualColumnMove: true,
            contextMenu: true,
            dropdownMenu: true,
            filters: true
        };


        var hot = new Handsontable(hotElement, hotSettings);


        function setJsonData() {
            //document.getElementById('jsondata').value=hot.getData();
            document.getElementById("jsondata").value = JSON.stringify(hot.getData());
            // $('#jsondata').val(hot.getData);
            // alert(JSON.stringify(hot.getData()));
        }


        $(".Buttonsearch").click(function (event) {
            //alert('Testing here');
            event.preventDefault();
            var keywords = $("#numrows").val();
            $('#loadingAdd').show();
            $.ajax({
                url: 'Shared/php/process_form.php?f=TRANS_ADD&rows=' + keywords,
                data: keywords,
                success: function (jdata) {

                    dataObject = JSON.parse(jdata);
                    console.log(dataObject);
                    hotSettings = {
            data: dataObject,
                        columns: [
                            {
                                data: 'Member',
                                type: 'autocomplete',
                                source: <?php echo $members; ?>
                            },
                            {
                                data: 'Phone_Number',
                                type: 'text'
                            },
                            {
                                data: 'Amount',
                                type: 'text'
                            },
                            {
                                data: 'Transaction_Type',
                                type: 'dropdown',
                                source: <?php echo $transactionType; ?>
                            },
                            {
                                data: 'Channel',
                                type: 'dropdown',
                                source: <?php echo $channels; ?>
                            },
                            {
                                data: 'Confirmed',
                                type: 'dropdown',
                                source: <?php echo $confirmed; ?>
                            },
                            {
                                data: 'Notes',
                                type: 'text'
                            }
                        ],
            stretchH: 'all',
            // width: 1200,
            autoWrapRow: true,
            height: 300,
            maxRows: 22,
            rowHeaders: true,
            colHeaders: [
                'Member',
                'Phone Number(254)',
                'Amount',
                'Transaction Type',
                'Channel',
                'Confirmed',
                'Notes'
            ],
            fixedRowsTop: 0,
            fixedColumnsLeft: 5,
            columnSorting: true,
            sortIndicator: true,
            autoColumnSize: {
                samplingRatio: 23
            },
            mergeCells: true,
            manualRowResize: true,
            manualColumnResize: true,
            manualRowMove: true,
            manualColumnMove: true,
            contextMenu: true,
            dropdownMenu: true,
            filters: true
        };
                    $('#loadingAdd').hide();
                    $('#MER_EXCEL_UPLOAD').show();
                    $('#hot').empty();
                    hot = new Handsontable(hotElement, hotSettings);
                    buttons = {
                        file: document.getElementById('export-file')
                    };
                    exportPlugin = hot.getPlugin('exportFile');


                }

            });

        });

    </script>
    <style>
        .gridSecondaryButton3 {
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            border: 1px solid #CCC;
            padding: 4px 12px;
        }
    </style>


    <span class="gridFormButtons">
        <input type="submit" name="action" onClick="setJsonData()" value="Continue" class="gridPrimaryButtonSubmit">
        <input type="button" name="cancel" value="Dismiss" class="gridSecondaryButton">
        <input type="hidden" name="cell" value="<?= $_GET['cell'] ?>"/>
        <input type="hidden" id="jsondata" name="jsondata" value=""/>
        <input type="hidden" id="collcount" name="collcount" value="<?= $collcount; ?>"/>
    </span>
</form>

    </div></div>