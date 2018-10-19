<link rel="stylesheet" type="text/css" href="../../api/handonExcelupdate/handsontable.full.min.css">
<!--<link rel="stylesheet" type="text/css" href="../../api/handonExcelupdate/main.css">-->
<script src="../../api/handonExcelupdate/handsontable.full.min.js"></script>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("../inc/dblink.php");
include '../inc/functions.php';


$collcount = 7;

$i = 0;

$vals = array();
$r = 0;

while ($r < 20) {
    $data['First_Name'] = '';
    $data['Middle_Name'] = '';
    $data['Last_Name'] = '';
    $data['Phone_Number'] = '';
    $data['Amount'] = 0;
    $data['Job_Group'] = '';
    $data['Province'] = 'Select County';
//    $data['County'] = 'Select County';    
//    $data['District'] = 'Select District';
//    $data['Payment_Type'] = 'Select Payment Type';
//    $data['Budget_Line'] = 'Select Budget Line';

    $vals[] = $data;
    $r++;
}

$data0 = json_encode($vals);
$datat = addcslashes($data0, "'&^`!@#%");

////Get counties
//$sql1 = "select id,title from county where intrash = 'NO' order by 2 asc";
//$res1 = @mysql_db_query($database, $sql1, $dblink);
//$counties = "[";
//while ($row1 = mysql_fetch_array($res1)) {
//    $counties .= "'" . $row1[1] . "',";
//}
//$counties .= "]";

//Get Province
$sql2 = "SELECT id,title FROM province WHERE InTrash = 'no' ORDER BY 2 asc";
$res2 = @mysql_db_query($database, $sql2, $dblink);
$province = "[";
while ($row2 = mysql_fetch_array($res2)) {
    $province .= "'" . $row2[1] . "',";
}
$province .= "]";
//
//Get District
$sql3 = "SELECT id,title FROM district WHERE InTrash = 'no' ORDER BY 2 asc";
$res3 = @mysql_db_query($database, $sql3, $dblink);
$district = "[";
while ($row3 = mysql_fetch_array($res3)) {
    $district .= "'" . $row3[1] . "',";
}
$district .= "]";

//Payment type
$sql4 = "SELECT id,title FROM ordertype WHERE InTrash = 'no' and id in (SELECT ordertypeId FROM org_ordertype where org_id='$_SESSION[org_o_id]' and  approvalOrder like '6%') ORDER BY 2 asc";
$res4 = @mysql_db_query($database, $sql4, $dblink);
$payment_type = "[";
while ($row4 = mysql_fetch_array($res4)) {
    $payment_type .= "'" . $row4[1] . "',";
}
$payment_type .= "]";


//Get budget
$sql5 = "SELECT id, title FROM budget WHERE InTrash = 'no' AND org_id='$_SESSION[org_o_id]'  ORDER BY id asc";
$res5 = @mysql_db_query($database, $sql5, $dblink);
$budgets = "[";
while ($row5 = mysql_fetch_array($res5)) {
    $budgets .= "'" . $row5[1] . "',";
}
$budgets .= "]";


//echo $datat;
?>


<form name="transaction" action="http://172.29.200.149/MerchantSettlement/API/handonExcel/update.php" method="POST" title="" class="HOUPTATEEXCEL" style="display: block;">


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
                    data: 'First_Name',
                    type: 'text',
                    width: 40
                },
                {
                    data: 'Middle_Name',
                    type: 'text',
                    width: 40
                },
                {
                    data: 'Last_Name',
                    type: 'text',
                    width: 40
                },
                {
                    data: 'Phone_Number',
                    type: 'text',
                    width: 50
                },
                {
                    data: 'Amount',
                    type: 'text'
                },
                {
                    data: 'Job_Group',
                    type: 'text'
                },
                {
                    data: 'Province',
                    type: 'dropdown',
                    source: <?php echo $province; ?>
                },
                {
                    data: 'County',
                    type: 'dropdown',
                    source: <?php echo $counties; ?>
                },
                {
                    data: 'District',
                    type: 'dropdown',
                    source: <?php echo $district; ?>
                },
                {
                    data: 'Payment_Type',
                    type: 'dropdown',
                    source: <?php echo $payment_type; ?>
                },
                {
                    data: 'Budget_Line',
                    type: 'dropdown',
                    source: <?php echo $budgets; ?>
                }
            ],
            stretchH: 'all',
            // width: 1200,
            autoWrapRow: true,
            height: 441,
            maxRows: 22,
            rowHeaders: true,
            colHeaders: [
                'First Name',
                'Middle Name',
                'Last Name',
                'Phone Number(254)',
                'Amount',
                'Job Group',
                'Province'
//                'County',
//                'District',
//                'Payment_Type',
//                'Budget_Line'
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
    </script>


    <span class="gridFormButtons">
        <input type="submit" name="action" onClick="setJsonData()" value="Continue" class="gridPrimaryButtonSubmit">
        <input type="button" name="cancel" value="Dismiss" class="gridSecondaryButton">
        <input type="hidden" name="cell" value="<?= $_GET['cell'] ?>"/>
        <input type="hidden" id="jsondata" name="jsondata" value=""/>
        <input type="hidden" id="collcount" name="collcount" value="<?= $collcount; ?>"/>
    </span>
</form>

