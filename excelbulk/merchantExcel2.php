
<link rel="stylesheet" type="text/css" href="API/handonExcel/handsontable.full.min.css">
<link rel="stylesheet" type="text/css" href="API/handonExcel/main.css">
<script src="API/handonExcel/handsontable.full.min.js"></script>

<!--        <link rel="stylesheet" type="text/css" href="handsontable.full.min.css">
        <link rel="stylesheet" type="text/css" href="main.css">
        <script src="handsontable.full.min.js"></script>-->

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

//    include("../../inc/dblink.php");
//    include '../../inc/functions.php';

include("../inc/dblink.php");
include '../inc/functions.php';
//error_reporting(1);


$collcount = 17;
$_SESSION['ho_edit'] = "";
$_SESSION['testing3'] = "";
 $query = " SELECT ID as primarykey,STORE_NUMBER,STORE_NAME,MERCHANT_MSISDN,MERCHANT_MSISDN2,
            SUBSCRIPTION_STATUS,
            (SELECT HO_NAME FROM MERCHANT_SETTMENT_HO_DETAILS WHERE INTRASH='NO' AND ID=HO_ID AND ROWNUM=1)HeadOfficeName ,
            (SELECT NAME FROM MERCHANT_SETTLEMENT_AGREGATORS  WHERE ID=AGGREGATOR_ID AND ROWNUM=1 )Acquirer,
            (SELECT CLASS_NAME FROM MERCHANT_SETTLEMENT_B_CLASS WHERE INTRASH = 'NO' AND ID=BUSINESS_CLASS_ID AND ROWNUM=1)BusinessType
            ,(SELECT TITLE FROM MERCHANT_SETTLEMENT_LOCATIONS WHERE INTRASH = 'NO' and ID=BUSINESS_LOCATION and rownum=1)BusinessLocation,
            (SELECT TITLE FROM MERCHANT_SETTLEMENT_BIZTYPE WHERE INTRASH = 'NO' AND ID=BUSINESS_TYPE)BusinessCategory ,
            TILL_NUMBERS,
            (SELECT TITLE FROM MERCHANT_SETTLEMENT_REGIONS WHERE INTRASH ='NO'AND ID=BUSINESS_REGION AND ROWNUM=1)BusinessRegions, 
            (SELECT TITLE FROM MERCHANT_SETTLEMENT_COUNTY WHERE MERCHANT_SETTLEMENT_COUNTY.INTRASH = 'NO' AND MERCHANT_SETTLEMENT_COUNTY.ID=COUNTY AND ROWNUM=1)BusinessCounty,
            (NOK_NAME)NextOfKinName ,(NOK_MSISDN)NextOfKinMSISDN,(NOK_ID)NextOfKinID ,(EMAIL)Email,(COMMENTS)Comments

            FROM MERCHANT_SETTLEMENT_SUBSCRPTNS WHERE INTRASH='NO' AND ROWNUM<=3 ORDER BY ID DESC ";

$statement = oci_parse($dblink, $query);
oci_execute($statement);
$i = 0;

$vals = array();
while ($row2 = oci_fetch_array($statement)) {
    $data['primarykey'] = $row2[0];
    $data['STORE_NUMBER'] = $row2[1];
    $data['STORE_NAME'] = $row2[2];
    $data['MERCHANT_MSISDN'] = $row2[3];
    $data['MERCHANT_MSISDN2'] = $row2[4];
    $data['SUBSCRIPTION_STATUS'] = $row2[5];
    $data['Acquirer'] = $row2[6];
    $data['BusinessType'] = $row2[7];
    $data['BusinessLocation'] = $row2[8];
    $data['BusinessCategory'] = $row2[9];
    $data['TILL_NUMBERS'] = $row2[10];
    $data['BusinessRegions'] = $row2[11];
    $data['BusinessCounty'] = $row2[12];
    $data['NextOfKinName'] = $row2[13];
    $data['NextOfKinMSISDN'] = $row2[14];
    $data['NextOfKinID'] = $row2[15];
    $data['Email'] = $row2[15];
    $data['Comments'] = $row2[16];
   // $data['SettlementOptions'] = $row2[17];

    $vals[] = $data;
}

// $vals=  str_replace("/\\\\/", "\\", $vals);
$data0 = json_encode($vals);
$datat = addcslashes($data0, "'&^`!@#%");

// $datat;// = str_replace("\"", "'", $data0);


//$acc_types.="]";
//get agregators
$sql1 = "SELECT ID, NAME FROM MERCHANT_SETTLEMENT_AGREGATORS WHERE INTRASH ='NO' ORDER BY NAME ASC";
$res1 = oci_parse($dblink, $sql1);
oci_execute($res1);
$agregators_types = "[";
while ($row1 = oci_fetch_array($res1)) {
    $agregators_types.="'" . $row1[1] . "',";
}
$agregators_types.="]";

//get HOs
$sql1="SELECT ID,HO_NAME FROM MERCHANT_SETTMENT_HO_DETAILS WHERE INTRASH ='NO' ORDER BY HO_NAME ASC";
$res1 = oci_parse($dblink, $sql1);
oci_execute($res1);
$ho_list= "[";
while ($row1 = oci_fetch_array($res1)) {
    $ho_list.="'" . $row1[1] . "',";
}
$ho_list.="]";

//get Business Class
$sql1 = "SELECT ID,CLASS_NAME FROM MERCHANT_SETTLEMENT_B_CLASS WHERE INTRASH = 'NO' ORDER BY CLASS_NAME";
$res1 = oci_parse($dblink, $sql1);
oci_execute($res1);
$businesses_types = "[";
while ($row1 = oci_fetch_array($res1)) {
    $businesses_types.="'" . $row1[1] . "',";
}
$businesses_types.="]";

//get Business Class
$sql1 = "SELECT ID, TITLE FROM MERCHANT_SETTLEMENT_BIZTYPE WHERE INTRASH = 'NO' ORDER BY TITLE";
$res1 = oci_parse($dblink, $sql1);
oci_execute($res1);
$businesses_category = "[";
while ($row1 = oci_fetch_array($res1)) {
    $businesses_category.="'" . $row1[1] . "',";
}
$businesses_category.="]";

//get Business location
$sql1 = "SELECT ID,TITLE FROM MERCHANT_SETTLEMENT_LOCATIONS WHERE INTRASH = 'NO' ORDER BY TITLE ASC";
$res1 = oci_parse($dblink, $sql1);
oci_execute($res1);
$business_locations = "[";
while ($row1 = oci_fetch_array($res1)) {
    $business_locations.="'" . $row1[1] . "',";
}
$business_locations.="]";

//get Business Regions
$sql1 = "SELECT ID,TITLE FROM MERCHANT_SETTLEMENT_REGIONS WHERE INTRASH = 'NO' ORDER BY TITLE";
$res1 = oci_parse($dblink, $sql1);
oci_execute($res1);
$business_regions = "[";
while ($row1 = oci_fetch_array($res1)) {
    $business_regions.="'" . $row1[1] . "',";
}
// $business_regions= str_replace("'","\'",$business_regions);// addslashes($business_regions);
$business_regions.="]";

//get Business County
$sql1 = " SELECT ID,TITLE FROM MERCHANT_SETTLEMENT_COUNTY WHERE INTRASH = 'NO' ORDER BY TITLE";
$res1 = oci_parse($dblink, $sql1);
oci_execute($res1);
$business_county = "[";
while ($row1 = oci_fetch_array($res1)) {
    $business_county.="'" . $row1[1] . "',";
}
//$business_county= str_replace("'","\'",$business_county);
$business_county.="]";

//var_dump($vals);
echo $datat;
?>


<form name="MERCHANTUPTATEEXCEL" action="http://172.29.200.149/MerchantSettlement/API/handonExcel/update.php" method="POST" title="" class="HOUPTATEEXCEL" style="display: block;">


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
                    data: 'primarykey',
                    type: 'numeric',
                    width: 40
                }, 
                {
                    data: 'STORE_NUMBER',
                    type: 'numeric',
                    width: 10
                },
                {
                    data: 'STORE_NAME',
                    type: 'text'
                },
                {
                    data: 'MERCHANT_MSISDN',
                    type: 'text'
                },                
                {
                    data: 'MERCHANT_MSISDN2',
                    type: 'text'
                },                      
                {
                    data: 'SUBSCRIPTION_STATUS',
                    type: 'dropdown'
                   // source:['Active','InActive']
                },
                {
                    data: 'Acquirer',
                    type: 'dropdown',
                    source: <?php echo $ho_list; ?>
                },
                {
                    data: 'BusinessType',
                    type: 'dropdown',
                    source: <?php echo $businesses_types; ?>
                },
                {
                    data: 'BusinessLocation',
                    type: 'dropdown',
                    source: <?php echo $business_locations; ?>
                },
                {
                    data: 'BusinessCategory',
                    type: 'dropdown',
                    source: <?php echo $businesses_category; ?>
                },
                {
                    data: 'TILL_NUMBERS',
                    type: 'text'
                }, 
                {
                    data: 'BusinessRegions',
                    type: 'dropdown',
                    source: <?php echo $business_regions; ?>
                },
                {
                    data: 'BusinessCounty',
                    type: 'dropdown',
                    source: <?php echo $business_county; ?>
                },
                {
                    data: 'NextOfKinName',
                    type: 'text'
                },
                {
                    data: 'NextOfKinMSISDN',
                    type: 'text',
                },
                {
                    data: 'Email',
                    type: 'text'
                },
                {
                    data: 'Comments',
                    type: 'text'
                }              
            ],
            stretchH: 'all',
            // width: 1200,
            autoWrapRow: true,
            height: 441,
            maxRows: 22,
            rowHeaders: true,
            colHeaders: [
                'ID',
                'Store Number',
                'Store Name',
                'Merchant MSISDN',
                'Merchant MSISDN2',
                'Status',
                'Acquirer',
                'Business Type',
                'Business Location',
                'Business Category',
                'Whitelisted Tills',
                'Business Regions',
                'Business County',
                'Next Of Kin Name',
                'NOK MSISDN',
                'Email',
                'Comments'

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
            filters: true,
            afterChange: function (change, source) {
                if (!change) {
                    return;
                }
                $.ajax({
                    url: 'API/handonExcel/merchantUpdate.php?data=' + change,
                    date: change
                });

            },
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

