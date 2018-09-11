

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

$datat = '[]';
$_SESSION['ho_edit'] = "";
$_SESSION['testing3'] = "";
//$query = "Select S.ID as primarykey,A.NAME As \"Acquirer\", S.ACCT_TYPE As \"AcctType\",
//S.MSISDN as \"ContactMSISDN\", HO_NUMBER as \"HeadOfficeNumber\", HO_NAME as \"HeadOfficeName\",B.TITLE
//as \"BusinessType\",(SELECT TITLE FROM MERCHANT_SETTLEMENT_BIZTYPE WHERE INTRASH = 'NO' AND ID=S.BUSINESS_TYPE) as \"BusinessCategory\",TM.FIRST_NAME AS \"TerritotyManager\",loc.TITLE
//as \"BusinessLocation\", (SELECT (FIRST_NAME ||' '|| LAST_NAME)NAME FROM MERCHANT_SETTLMNT_SALES_EXECS 
//WHERE MERCHANT_SETTLMNT_SALES_EXECS.INTRASH ='NO' AND MERCHANT_SETTLMNT_SALES_EXECS.ID=S.SALES_EXEC)SalesAgent,
//(SELECT TITLE FROM MERCHANT_SETTLEMENT_REGIONS WHERE MERCHANT_SETTLEMENT_REGIONS.INTRASH = 'NO' AND MERCHANT_SETTLEMENT_REGIONS.ID=S.BUSINESS_REGION)BusinessRegions, 
//(SELECT TITLE FROM MERCHANT_SETTLEMENT_COUNTY WHERE MERCHANT_SETTLEMENT_COUNTY.INTRASH = 'NO' AND MERCHANT_SETTLEMENT_COUNTY.ID=S.COUNTY)BusinessCounty,
//(CASE WHEN STATUS=0 THEN 'Inactive' ELSE 'Active' END) AS Status, to_char(S.DATE_CREATED,'YYYY-MM-DD') as \"DATECREATED\"
//,(CASE WHEN SETTLEMENT_OPTION=2 then 'Bank Settlement' ELSE 'M-PESA Settlment' END)\"SettlementOption\", 
//(CASE WHEN RTS_ALLOWED=1 then 'Yes' ELSE 'No' END)\"RTSAllowed\" from MERCHANT_SETTMENT_HO_DETAILS S
//left join MERCHANT_SETTLEMENT_AGREGATORS A on A.ID=S.AGGREGATOR_ID left join MERCHANT_SETTLEMENT_B_CLASS B 
//on B.ID = S.BUSINESS_CLASS_ID LEFT JOIN MERCHANT_SETTLEMENT_LOCATIONS loc ON loc.ID = S.BUSINESS_LOCATION  
//LEFT JOIN MERCHANT_SETTLMNT_TER_MANAGERS TM ON S.TERRITORY_MANAGER=TM.ID WHERE S.INTRASH = 'NO' AND ROWNUM<=5000 ORDER BY S.ID DESC ";
//
//$statement = oci_parse($dblink, $query);
//oci_execute($statement);
//$i = 0;
//
//$vals = array();
//while ($row2 = oci_fetch_array($statement)) {
//    $data['primarykey'] = $row2[0];
//    $data['Acquirer'] = $row2[1];
//    $data['AcctType'] = $row2[2];
//    $data['ContactMSISDN'] = $row2[3];
//    $data['HeadOfficeNumber'] = $row2[4];
//    $data['HeadOfficeName'] = $row2[5];
//    $data['BusinessType'] = $row2[6];
//    $data['BusinessCategory'] = $row2[7];
//    $data['TerritoryManager'] = $row2[8];
//    $data['BusinessLocation'] = $row2[9];
//    $data['SalesAgent'] = $row2[10];
//    $data['BusinessRegions'] = $row2[11];
//    $data['BusinessCounty'] = $row2[12];
//    $data['Status'] = $row2[13];
//    $data['DATECREATED'] = $row2[14];
//    $data['SettlementOption'] = $row2[15];
//    $data['RTSAllowed'] = $row2[16];
//
//
//    $vals[] = $data;
//}
//
//// $vals=  str_replace("/\\\\/", "\\", $vals);
//$data0 = json_encode($vals);
//$datat = addcslashes($data0, "'&^`!@#%");
// $datat;// = str_replace("\"", "'", $data0);
//get account types
$sql1 = "SELECT ID,TYPE_NAME FROM MSS_ACCOUNT_TYPES WHERE INTRASH = 'NO'  ORDER BY TYPE_NAME";
$res1 = oci_parse($dblink, $sql1);
oci_execute($res1);
$acc_types = "[";
while ($row1 = oci_fetch_array($res1)) {
    $acc_types.="'" . $row1[1] . "',";
}

$acc_types.="]";
//get agregators
$sql1 = "SELECT ID, NAME FROM MERCHANT_SETTLEMENT_AGREGATORS WHERE INTRASH ='NO' ORDER BY NAME ASC";
$res1 = oci_parse($dblink, $sql1);
oci_execute($res1);
$agregators_types = "[";
while ($row1 = oci_fetch_array($res1)) {
    $agregators_types.="'" . $row1[1] . "',";
}
$agregators_types.="]";

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

//get teritory managers
$sql1 = "SELECT ID, (FIRST_NAME||' '||LAST_NAME)NAME FROM MERCHANT_SETTLMNT_TER_MANAGERS WHERE INTRASH ='NO' ORDER BY FIRST_NAME ASC";
$res1 = oci_parse($dblink, $sql1);
oci_execute($res1);
$territory_managers = "[";
while ($row1 = oci_fetch_array($res1)) {
    $territory_managers.="'" . $row1[1] . "',";
}
$territory_managers.="]";


//get sales agents
$sql1 = "SELECT ID, (FIRST_NAME||' '||LAST_NAME)NAME FROM MERCHANT_SETTLMNT_SALES_EXECS WHERE INTRASH ='NO' ORDER BY FIRST_NAME ASC";
$res1 = oci_parse($dblink, $sql1);
oci_execute($res1);
$sales_agents = "[";
while ($row1 = oci_fetch_array($res1)) {
    $sales_agents.="'" . $row1[1] . "',";
}
$sales_agents.="]";

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

//get Business Regions
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
//echo $datat;
?>

<form method="POST" id="a"> 
    <label>
        <span>Search:</span>
        <input type="text" name="keywords" id="keywords" value="" class="required" placeholder="Enter Keyword(s)">
        <input type="submit" value="Load Search Results" name="submit" class="Buttonsearch gridSecondaryButton3">
    </label>
</form>

<form name="HOUPTATEEXCEL" id="HOUPTATEEXCEL"  method="POST" title="" class="HOUPTATEEXCEL" style="display: none;">


    <link rel="stylesheet" type="text/css" href="API/handonExcel/handsontable.full.min.css">
    <!--    <link rel="stylesheet" type="text/css" href="API/handonExcel/main.css">-->
    <script src="API/handonExcel/handsontable.full.min.js"></script>

    <div id="hot" style="width: 100%; height: 70%; overflow: hidden;"></div>
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
                    data: 'Acquirer',
                    type: 'dropdown',
                    source: <?php echo $agregators_types; ?>
                },
                {
                    data: 'AcctType',
                    type: 'dropdown',
                    source: <?php echo $acc_types; ?>
                },
                {
                    data: 'ContactMSISDN',
                    type: 'text'
                },
                {
                    data: 'HeadOfficeNumber',
                    type: 'text',
                },
                {
                    data: 'HeadOfficeName',
                    type: 'text'
                },
                {
                    data: 'BusinessType',
                    type: 'dropdown',
                    source: <?php echo $businesses_types; ?>
                },
                {
                    data: 'BusinessCategory',
                    type: 'dropdown',
                    source: <?php echo $businesses_category; ?>
                },
                {
                    data: 'TerritoryManager',
                    type: 'dropdown',
                    source: <?php echo $territory_managers; ?>
                },
                {
                    data: 'BusinessLocation',
                    type: 'dropdown',
                    source: <?php echo $business_locations; ?>
                },
                {
                    data: 'SalesAgent',
                    type: 'dropdown',
                    source: <?php echo $sales_agents; ?>
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
                    data: 'Status',
                    type: 'dropdown',
                    source: ['Active', 'InActive']
                },
                {
                    data: 'DATECREATED',
                    type: 'date',
                    dateFormat: 'MM/DD/YYYY'
                },
                {
                    data: 'SettlementOption',
                    type: 'dropdown',
                    source: ['To M-PESA', 'To Bank']
                },
                {
                    data: 'RTSAllowed',
                    type: 'dropdown',
                    source: ['YES', 'NO']
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
                'Acquirer',
                'AcctType',
                'Contact Msisdn',
                'Head Office Number',
                'Head Office Name',
                'Business Type',
                'Business Category',
                'Territory Manager',
                'Business Location',
                'Sales Agent',
                'Region',
                'County',
                'Status',
                'Date Created',
                'Settlement Option',
                'Rts Allowed'

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
                    url: 'API/handonExcel/update.php?data=' + change,
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

        $(".Buttonsearch").click(function (event) {
            event.preventDefault();
            var keywords = $("#keywords").val();

            //$('#HOUPTATEEXCEL').hide()();
            $('#loadingAdd').show();
            $.ajax({
                url: 'forms/process_form.php?f=HO_SEARCH&keywords=' + keywords,
                data: keywords,
                success: function (jdata) {

                    dataObject = JSON.parse(jdata);
                    console.log(dataObject);
                    hotSettings = {
                        data: dataObject,
                        columns: [
                            {
                                data: 'primarykey',
                                type: 'numeric'
                            },
                            {
                                data: 'Acquirer',
                                type: 'dropdown',
                                source: <?php echo $agregators_types; ?>
                            },
                            {
                                data: 'AcctType',
                                type: 'dropdown',
                                source: <?php echo $acc_types; ?>
                            },
                            {
                                data: 'ContactMSISDN',
                                type: 'text'
                            },
                            {
                                data: 'HeadOfficeNumber',
                                type: 'text',
                            },
                            {
                                data: 'HeadOfficeName',
                                type: 'text'
                            },
                            {
                                data: 'BusinessType',
                                type: 'dropdown',
                                source: <?php echo $businesses_types; ?>
                            },
                            {
                                data: 'BusinessCategory',
                                type: 'dropdown',
                                source: <?php echo $businesses_category; ?>
                            },
                            {
                                data: 'TerritoryManager',
                                type: 'dropdown',
                                source: <?php echo $territory_managers; ?>
                            },
                            {
                                data: 'BusinessLocation',
                                type: 'dropdown',
                                source: <?php echo $business_locations; ?>
                            },
                            {
                                data: 'SalesAgent',
                                type: 'dropdown',
                                source: <?php echo $sales_agents; ?>
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
                                data: 'Status',
                                type: 'dropdown',
                                source: ['Active', 'InActive']
                            },
                            {
                                data: 'DATECREATED',
                                type: 'date',
                                dateFormat: 'MM/DD/YYYY'
                            },
                            {
                                data: 'SettlementOption',
                                type: 'dropdown',
                                source: ['To M-PESA', 'To Bank']
                            },
                            {
                                data: 'RTSAllowed',
                                type: 'dropdown',
                                source: ['YES', 'NO']
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
                            'Acquirer',
                            'AcctType',
                            'Contact Msisdn',
                            'Head Office Number',
                            'Head Office Name',
                            'Business Type',
                            'Business Category',
                            'Territory Manager',
                            'Business Location',
                            'Sales Agent',
                            'Region',
                            'County',
                            'Status',
                            'Date Created',
                            'Settlement Option',
                            'Rts Allowed'

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
                                url: 'API/handonExcel/update.php?data=' + change,
                                date: change
                            });

                        },
                    };
                    $('#loadingAdd').hide();
                    $('#HOUPTATEEXCEL').show();
                    $('#hot').empty();
                    hot = new Handsontable(hotElement, hotSettings);

//                    var data = JSON.parse(jdata);
//                    $('#hot').handsontable('loadData', data);
//                    


                }


            });



        });

    </script>


    <span class="gridFormButtons">
        <input type="submit" name="action" onClick="setJsonData()" value="Submit" class="gridPrimaryButtonSubmit">
        <input type="button" name="cancel" value="Dismiss" class="gridSecondaryButton">
        <input type="hidden" name="cell" value="<?= $_GET['cell'] ?>"/>
        <input type="hidden" id="jsondata" name="jsondata" value=""/>
        <input type="hidden" id="collcount" name="collcount" value="<?= $collcount; ?>"/>
    </span>
</form>

