
<link rel="stylesheet" type="text/css" href="../../api/handonExcelupdate/handsontable.full.min.css">
<!--<link rel="stylesheet" type="text/css" href="../../api/handonExcelupdate/main.css">-->
<script src="../../api/handonExcelupdate/handsontable.full.min.js"></script>

<!--        <link rel="stylesheet" type="text/css" href="handsontable.full.min.css">
        <link rel="stylesheet" type="text/css" href="main.css">
        <script src="handsontable.full.min.js"></script>-->

<?php
ini_set('display_errors', 'on');
error_reporting(E_ERROR);
//include("../../inc/dblink.php");
//include '../../inc/functions.php';
include("../inc/dblink.php");
include '../inc/functions.php';



$number_Expected = '';
$county_id = '';
$meeting_code = '';
$venue = '';
$status = '';
$start_date = '';
$end_date = '';

$meetingname = '';
$paymenttimes = '';
$meetingtype = '';
$mode = isset($_GET['mode']) ? $_GET['mode'] : $_SESSION['mode_s'];
$limit = ' Limit 1 ';
$nextday = "";
$didheattendquery = "";
echo "";
//echo "mode is ".$mode;
$_SESSION['mode_s'] = $mode;
$m_org = mysql_fetch_array(@mysql_db_query($database, "SELECT ORG_ID FROM event WHERE meeting_code ='" . $_GET['cell'] . "' limit 1", $dblink));
$m_org_id = $m_org[0];
//echo "The org id is " . $m_org_id;

if ($mode == '5') {//section for attendance processing
    $result = @mysql_db_query($database, "select (TIMESTAMPDIFF(DAY, start_date, end_date)+1)NOofDays,start_date,travelling_days,meeting_type from event where meeting_code='" . $_GET['cell'] . "' limit 1", $dblink);
    while ($row = mysql_fetch_array($result)) {
        $dayone = explode('-', $row[1]);
        $i = 0;
        $travellingday = $dayone[2] - 1;
        $meetingdays = "'Payable Travelling Days',";
        $travelling_days = $row[2];
        $meetingtype = $row[3];
        $didheattendquery = "(select (case when count(*)>0 then 0 else $travelling_days end) from attendance where processing_status!=0 and meeting_code='" . $_GET['cell'] . "' and recipient_id=R.recipient_id)AS 'arrivalday',"; //'1,';
        $didheattendquery2 = "(select (case when count(*)>0 then 0 else $travelling_days end) from attendance where processing_status!=0 and meeting_code='" . $_GET['cell'] . "' and recipient_id=R.recipient_id)";
        $duration = $row[0];


        // echo date('M', strtotime($dayone[1] . '01'));

        while ($row[0] > $i) {
            $nextday = $dayone[2] + $i;
            $monthsdays = cal_days_in_month(CAL_GREGORIAN, $dayone[1], $dayone[0]);
            $nextday = ($nextday > $monthsdays) ? ($nextday - $monthsdays) : $nextday;
            $columnno = 5 + $i;
            $meetingdays.="'" . date('M', strtotime($dayone[1] . '01')) . " " . $nextday . "',";
            $didheattendquery.="(select count(*) from attendance A where DATE(requesttime)='$dayone[0]-$dayone[1]-$nextday' and A.MSISDN=R.msisdn and verification_status='Approved' and processing_status='0' and meeting_code='" . $_GET['cell'] . "') AS '" . $nextday . "', ";
            $i++;
        }
        $meetingdays.="'No of Days',";
        // echo "select (case when count(*)>0 then count(*)+arrivalday else count(*) end) from attendance A where A.MSISDN=R.msisdn and verification_status='Approved' and processing_status='0' and meeting_code='" . $_GET['cell'] . "'";
        $didheattendquery.="(select (case when count(*)>0 then count(*)+arrivalday else count(*) end) from attendance A where A.MSISDN=R.msisdn and verification_status='Approved' and processing_status='0' and meeting_code='" . $_GET['cell'] . "')as 'NoofDays', ";
    }
    //echo $meetingdays;
//RESPECTIVE attendance


    $sqltotalpr = "select 
				  sum(
				  (select (case when '$meetingtype'='DayOnly' then lunchDinnerRate when '$meetingtype'='HalfBoard' then dinnerRate else amount end) from perdiem where id=C.designationid AND org_id='$m_org_id')*(select (case when count(*)>0 then count(*)+$didheattendquery2 else count(*) end) from attendance A where A.MSISDN=R.msisdn and verification_status='Approved' and processing_status='0' and meeting_code='" . $_GET['cell'] . "')-0
				  )as 'Total'
				  from attendance R  INNER JOIN recipient C on R.recipient_id=C.ID WHERE R.meeting_code='" . $_GET['cell'] . "' and R.processing_status='0'";
    $rowk = mysql_fetch_array(@mysql_db_query($database, $sqltotalpr, $dblink));

    Echo "<h3>BATCH NO: " . $_GET['cell'] . " Totaling to: " . $rowk[0] . "</h3>";

    $result2 = @mysql_db_query($database, "select 
				  (select concat(firstname,' ',middlename,' ',lastname) from recipient where id=R.recipient_id)Name,
				   (select title from county where county.id=C.countyid) as `NameofCounty`,
				    (select title from district where id=C.subcountyid)Station, 
				    (select designation from perdiem where id=C.designationid AND org_id='$m_org_id')Designation,
				    (select title from jobgroup where id=C.jobgroupid)JobGroup,
				  $didheattendquery 
				  R.MSISDN as 'Telephone Number',
				  (select (case when '$meetingtype'='DayOnly' then lunchDinnerRate when '$meetingtype'='HalfBoard' then dinnerRate else amount end) from perdiem where id=C.designationid AND org_id='$m_org_id')Rate,
				  (select (case when '$meetingtype'='DayOnly' then lunchDinnerRate when '$meetingtype'='HalfBoard' then dinnerRate else amount end) from perdiem where id=C.designationid AND org_id='$m_org_id')*(select (case when count(*)>0 then count(*)+arrivalday else count(*) end) from attendance A where A.MSISDN=R.msisdn and verification_status='Approved' and processing_status='0' and meeting_code='" . $_GET['cell'] . "') as Amount,
				  0 as 'Less lunch',
				  0 as 'Transport',
				  0 as 'Extra per diem',
				  0 as 'Others',
				  (
				  (select (case when '$meetingtype'='DayOnly' then lunchDinnerRate when '$meetingtype'='HalfBoard' then dinnerRate else amount end) from perdiem where id=C.designationid AND org_id='$m_org_id')*(select (case when count(*)>0 then count(*)+arrivalday else count(*) end) from attendance A where A.MSISDN=R.msisdn and verification_status='Approved' and processing_status='0' and meeting_code='" . $_GET['cell'] . "')-0
				  ) as 'Net Pay','YES' AS 'Process','' AS 'Comments',R.ID
				  from attendance R  INNER JOIN recipient C on R.recipient_id=C.ID WHERE R.meeting_code='" . $_GET['cell'] . "' and R.processing_status='0' GROUP BY R.MSISDN", $dblink);

    $rateheader = $meetingtype == 'DayOnly' ? "Lunch Rate" : $meetingtype == 'HalfBoard' ? "Dinner Rate" : "Per Diem Rate";
    $data = "["; //"[['Name','County','Station','Designation','Job Group',$meetingdays'Telephone Number', '$rateheader', 'Amount','Less lunch','Transport', 'Extra per diem','Others','Net Pay','Process','Comments','ID'],";

    $collcount = 17 + $duration; //sure columns before addition of dynamic ones
    while ($row2 = mysql_fetch_array($result2)) {
        $NameofCounty = str_replace("'", "\'", $row2['NameofCounty']);
        $station = str_replace("'", "\'", $row2['Station']);
        $data.="['" . $row2['Name'] . "','" . $NameofCounty . "','" . $station . "','" . $row2['Designation'] . "','" . $row2['JobGroup'] . "','" . $row2[5] . "'";
        if ($duration > 0) {
            $data.=",'" . $row2[6] . "'";
        }
        if ($duration > 1) {
            $data.=",'" . $row2[7] . "'";
        }
        if ($duration > 2) {
            $data.=",'" . $row2[8] . "'";
        }
        if ($duration > 3) {
            $data.=",'" . $row2[9] . "'";
        }
        if ($duration > 4) {
            $data.=",'" . $row2[10] . "'";
        }
        if ($duration > 5) {
            $data.=",'" . $row2[11] . "'";
        }
        if ($duration > 6) {
            $data.=",'" . $row2[12] . "'";
        }
        $data.=",'" . $row2['NoofDays'] . "','" . $row2['Telephone Number'] . "','" . $row2['Rate'] . "','" . $row2['Amount'] . "','" . $row2['Less lunch'] . "','" . $row2['Transport'] . "','" . $row2['Extra per diem'] . "','" . $row2['Others'] . "','" . $row2['Net Pay'] . "','" . $row2['Process'] . "', '" . $row2['Comments'] . "','" . $row2['ID'] . "'],";
    }
    $data.="]";
    $data = str_replace(",]", "]", $data);
    $columns = "[";
    $j = 0;
    while ($collcount > $j) {

        if ($j == ($collcount - 2)) {
            $columns.="{
        type: 'dropdown',
        source: ['YES','NO']
      },";
        } elseif ($j < ($collcount - 8)) {
            $columns.="{data: $j,readOnly:true},";
        } else {
            $columns.="{data: $j},";
        }
        $j++;
    }

    $columns.= "]";
    $columns = str_replace(",]", "]", $columns);
    $columnheaders = "['Name','County','Station','Designation','Job Group',$meetingdays'Telephone Number', '$rateheader', 'Amount','Less lunch','Transport', 'Extra per diem','Others','Net Pay','Process','Comments','ID']";
//echo $columns;
//echo $collcount." ";
//echo $duration." ";
//echo $data;
#Sample data
    ?>

    <form name="ATTENDANCEPROCESSINGWITHEXCEL" method="POST" title="" class="ATTENDANCEPROCESSINGWITHEXCEL" style="display: block;">


        <div id="hot" style="width: 100%; height: 70%; overflow: hidden; z-index: 0"></div>
        <script>
            var dataObject =<?php echo $data; ?>;

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
                columns: <?= $columns; ?>,
                stretchH: 'all',
                // width: 1200,
                autoWrapRow: true,
                height: 441,
                //maxRows: 22,
                rowHeaders: true,
                colHeaders: <?= $columnheaders; ?>,
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
                        url: 'forms/process_form.php?f=MER_SESSION&data=' + change,
                        date: change
                    });

                },
            };


            var hot = new Handsontable(hotElement, hotSettings);
            exportPlugin = hot.getPlugin('exportFile');

            function setJsonData() {
                //document.getElementById('jsondata').value=hot.getData();
                document.getElementById("jsondata").value = JSON.stringify(hot.getData());
                // $('#jsondata').val(hot.getData);
                // alert(JSON.stringify(hot.getData()));
            }
            
            function exportTOCsv() {
                event.preventDefault();
                //alert("test");
                var timestamp = $.now();
                var filename = 'TIBU_' + timestamp;
                exportPlugin.downloadFile('csv', {filename: filename,columnHeaders: true});
            }

        </script>

        <?= "<h3 style='text-align: right;'>Total Payable: " . $rowk[0] . "     </h3>"; ?>
        <span class="gridFormButtons">
            <?= (hasPermission("addmeeting", "2") ? '<input type="submit" name="action" onClick="setJsonData()" value="Continue" class="gridPrimaryButtonSubmit">' : '<input type="submit" name="action" onClick="setJsonData()" value="Continue" class="gridPrimaryButtonSubmit">') ?>
            <input type="button" name="cancel" value="Dismiss" class="gridSecondaryButton">
            <button id="export-file" onclick="exportTOCsv()" class="intext-btn gridPrimaryButton">Export as a CSV file</button>
            <input type="hidden" name="cell" value="<?= $_GET['cell'] ?>"/>
            <input type="hidden" id="jsondata" name="jsondata" value=""/>
            <input type="hidden" id="collcount" name="collcount" value="<?= $collcount; ?>"/>
        </span>
    </form>

    <?php
} elseif ($mode == '6') {//section for attendance approval
    $nextday = '';
    $result = @mysql_db_query($database, "select (TIMESTAMPDIFF(DAY, start_date, end_date)+1)NOofDays,start_date,travelling_days,meeting_type from event where meeting_code='" . $_GET['cell'] . "' limit 1", $dblink);
    while ($row = mysql_fetch_array($result)) {
        $dayone = explode('-', $row[1]);
        $i = 0;
        $travellingday = $dayone[2] - 1;
        $meetingdays = "'Payable Travelling Days',";
        $travelling_days = $row[2];
        $meetingtype = $row[3];
        //didheattendquery = '1,';
        $didheattendquery = "(select (case when count(*)>0 then $travelling_days else $travelling_days end) from attendance where processing_status=1 and meeting_code='" . $_GET['cell'] . "' and recipient_id=R.recipient_id)AS 'arrivalday',"; //'1,';
        $didheattendquery2 = "(select (case when count(*)>0 then $travelling_days else $travelling_days end) from attendance where processing_status=1 and meeting_code='" . $_GET['cell'] . "' and recipient_id=R.recipient_id)";
        $duration = $row[0];
        while ($row[0] > $i) {
            $nextday = $dayone[2] + $i;
            $monthsdays = cal_days_in_month(CAL_GREGORIAN, $dayone[1], $dayone[0]);
            $nextday = ($nextday > $monthsdays) ? ($nextday - $monthsdays) : $nextday;
            $columnno = 5 + $i;
            $meetingdays.="'" . date('M', strtotime($dayone[1] . '01')) . " " . $nextday . "',"; // $meetingdays.="'" . $nextday . "',";
            $didheattendquery.="(select count(*) from attendance A where DATE(requesttime)='$dayone[0]-$dayone[1]-$nextday' and A.MSISDN=R.msisdn and verification_status='Approved' and processing_status='1'  and meeting_code='" . $_GET['cell'] . "') AS '" . $nextday . "', ";
            $i++;
        }
        $meetingdays.="'No of Days',";
        $didheattendquery.="(select (case when count(*)>0 then count(*)+arrivalday else count(*) end) from attendance A where A.MSISDN=R.msisdn and verification_status='Approved' and processing_status='1' and meeting_code='" . $_GET['cell'] . "')as 'NoofDays', ";
    }

    $attendanceids = "(select id from attendance where recipient_id=R.recipient_id 
 and meeting_code='" . $_GET['cell'] . "' and processing_status='1') ";
// echo $dynamicrows;
//RESPECTIVE attendance
    $sqltotalpr = "select 
				  sum(payable_amount_1)as 'Total'
				  from attendance R  INNER JOIN recipient C on R.recipient_id=C.ID WHERE R.meeting_code='" . $_GET['cell'] . "' and R.processing_status='1'";
    $rowk = mysql_fetch_array(@mysql_db_query($database, $sqltotalpr, $dblink));

    Echo "<h3>BATCH NO: " . $_GET['cell'] . " Totaling to: " . $rowk[0] . "</h3>";

    $result2 = mysql_db_query($database, "select 
				  (select concat(firstname,' ',middlename,' ',lastname) from recipient where id=R.recipient_id)Name,
				   (select title from county where county.id=C.countyid) as `NameofCounty`,
				    (select title from district where id=C.subcountyid)Station, 
				    (select designation from perdiem where id=C.designationid AND org_id='$m_org_id')Designation,
				    (select title from jobgroup where id=C.jobgroupid)JobGroup,
				  $didheattendquery 
				  R.MSISDN as 'Telephone Number',
				  (select (case when '$meetingtype'='DayOnly' then lunchDinnerRate when '$meetingtype'='HalfBoard' then dinnerRate else amount end) from perdiem where id=C.designationid AND org_id='$m_org_id')Rate,
				  (SELECT sum(credit) FROM temp_supervision_details where title='Per Diem' and apiorder_id in $attendanceids $limit) as Amount,
				  (SELECT sum(credit) FROM temp_supervision_details where title='Lunch' and apiorder_id in $attendanceids $limit) as 'Less_lunch_day_500',
				  (SELECT sum(credit) FROM temp_supervision_details where title='Transport/Fuel' and apiorder_id in $attendanceids $limit) as 'Transport',
				  (SELECT sum(credit) FROM temp_supervision_details where title='Extra Per Diem' and apiorder_id in $attendanceids $limit) as 'Extra_per_diem',
				  (SELECT sum(credit) FROM temp_supervision_details where title='Others' and apiorder_id in $attendanceids $limit) as 'Others',
				  payable_amount_1 as 'Net Pay','YES' AS 'Approve','' AS 'Comments',
				  (select CONVERT(GROUP_CONCAT(id) USING 'utf8') from attendance where recipient_id=R.recipient_id and
 meeting_code='" . $_GET['cell'] . "' and processing_status='1')ID
				  from attendance R  INNER JOIN recipient C on R.recipient_id=C.ID where meeting_code='" . $_GET['cell'] . "' and processing_status='1' GROUP BY R.MSISDN", $dblink);
    $rateheader = $meetingtype == 'DayOnly' ? "Lunch Rate" : $meetingtype == 'HalfBoard' ? "Dinner Rate" : "Per Diem Rate";
    $data = "["; //"[['Name','County','Station','Designation','Job Group',$meetingdays'Telephone Number', '$rateheader', 'Amount','Less lunch day @500 ','Transport', 'Extra per diem','Others','Net Pay','Approve','Comments','ID'],";

    $collcount = 17 + $duration; //sure columns before addition of dynamic ones
    while ($row2 = mysql_fetch_array($result2)) {

        $NameofCounty = str_replace("'", "\'", $row2['NameofCounty']);
        $station = str_replace("'", "\'", $row2['Station']);
        $data.="['" . $row2['Name'] . "','" . $NameofCounty . "','" . $station . "','" . $row2['Designation'] . "','" . $row2['JobGroup'] . "','" . $row2[5] . "'";
        if ($duration > 0) {
            $data.=",'" . $row2[6] . "'";
        }
        if ($duration > 1) {
            $data.=",'" . $row2[7] . "'";
        }
        if ($duration > 2) {
            $data.=",'" . $row2[8] . "'";
        }
        if ($duration > 3) {
            $data.=",'" . $row2[9] . "'";
        }
        if ($duration > 4) {
            $data.=",'" . $row2[10] . "'";
        }
        if ($duration > 5) {
            $data.=",'" . $row2[11] . "'";
        }
        if ($duration > 6) {
            $data.=",'" . $row2[12] . "'";
        }
        $data.=",'" . $row2['NoofDays'] . "','" . $row2['Telephone Number'] . "','" . $row2['Rate'] . "','" . $row2['Amount'] . "','" . $row2['Less_lunch_day_500'] . "','" . $row2['Transport'] . "','" . $row2['Extra_per_diem'] . "','" . $row2['Others'] . "','" . $row2['Net Pay'] . "','" . $row2['Approve'] . "','" . $row2['Comments'] . "','" . $row2['ID'] . "'],";
    }
    $data.="]";
    $data = str_replace(",]", "]", $data);
    $columns = "[";
    $j = 0;
    while ($collcount > $j) {
        $columns.="{data: $j},";
        $j++;
    }
    $columns.= "]";
    $columns = str_replace(",]", "]", $columns);
    $columnheaders = "['Name','County','Station','Designation','Job Group',$meetingdays'Telephone Number', '$rateheader', 'Amount','Less lunch day @500 ','Transport', 'Extra per diem','Others','Net Pay','Approve','Comments','ID']";
//echo $meetingdays;
//echo $data;
#Sample data
    ?>

    <form name="ATTENDANCEAPPROVALEXCEL" method="POST" title="" class="ATTENDANCEAPPROVALEXCEL" style="display: block;">


        <div id="hot" style="width: 100%; height: 70%; overflow: hidden; z-index: 0"></div>
        <script>
            var dataObject =<?php echo $data; ?>;

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
                columns: <?= $columns; ?>,
                stretchH: 'all',
                // width: 1200,
                autoWrapRow: true,
                height: 441,
                //maxRows: 22,
                rowHeaders: true,
                colHeaders: <?= $columnheaders; ?>,
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
                        url: 'forms/process_form.php?f=MER_SESSION&data=' + change,
                        date: change
                    });

                },
            };


            var hot = new Handsontable(hotElement, hotSettings);
            exportPlugin = hot.getPlugin('exportFile');

            function setJsonData() {
                //document.getElementById('jsondata').value=hot.getData();
                document.getElementById("jsondata").value = JSON.stringify(hot.getData());
                //alert(JSON.stringify(hot.getData()));
            }
            function setEditJsonData() {
                document.getElementById("jsondata").value = JSON.stringify(hot.getData());
                document.getElementById("editexcel").value = 1;
                // alert(JSON.stringify(hot.getData()));
            }
            
            function exportTOCsv() {
                event.preventDefault();
                //alert("test");
                var timestamp = $.now();
                var filename = 'TIBU_' + timestamp;
                exportPlugin.downloadFile('csv', {filename: filename,columnHeaders: true});
            }
            
        </script>
        <?= "<h3 style='text-align: right;'>Total Payable: " . $rowk[0] . "     </h3>"; ?>

        <span class="gridFormButtons">
            <?= (hasPermission("addmeeting", "2") ? '<input type="submit" name="action" onClick="setJsonData()" value="Appove Payment" class="gridPrimaryButtonSubmit">
&nbsp&nbsp&nbsp<input type="submit" name="action" onClick="setEditJsonData()" value="Update Excel" class="gridPrimaryButtonSubmit">' : '<input type="submit" name="action" onClick="setJsonData()" value="Appove Payment" class="gridPrimaryButtonSubmit">
&nbsp&nbsp&nbsp<input type="submit" name="action" onClick="setEditJsonData()" value="Update Excel" class="gridPrimaryButtonSubmit">') ?>
            <input type="button" name="cancel" value="Dismiss" class="gridSecondaryButton">
            <button id="export-file" onclick="exportTOCsv()" class="intext-btn gridPrimaryButton">Export as a CSV file</button>
            <input type="hidden" name="cell" value="<?= $_GET['cell'] ?>"/>
            <input type="hidden" id="jsondata" name="jsondata" value=""/>
            <input type="hidden" id="collcount" name="collcount" value="<?= $collcount; ?>"/>
            <input type="hidden" id="editexcel" name="editexcel" value=""/>
        </span>
    </form>



    <?php
} elseif ($mode == '7') {//view all attendance
//echo "The code is ".$_GET['cell'];
    $result = @mysql_db_query($database, "select (TIMESTAMPDIFF(DAY, start_date, end_date)+1)NOofDays,start_date,travelling_days,meeting_type from event where meeting_code='" . $_GET['cell'] . "' limit 1", $dblink);
    while ($row = mysql_fetch_array($result)) {
        $dayone = explode('-', $row[1]);
        $i = 0;
        $travellingday = $dayone[2] - 1;
        $meetingdays = "'Payable Travelling Days',";
        $travelling_days = $row[2];
        $meetingtype = $row[3];
        $didheattendquery = $travelling_days . ','; //'1,';
        $duration = $row[0];

        while ($row[0] > $i) {
            $nextday = $dayone[2] + $i;
            $monthsdays = cal_days_in_month(CAL_GREGORIAN, $dayone[1], $dayone[0]);
            $nextday = ($nextday > $monthsdays) ? ($nextday - $monthsdays) : $nextday;
            $columnno = 5 + $i;
            $meetingdays.="'" . date('M', strtotime($dayone[1] . '01')) . " " . $nextday . "',"; // $meetingdays.="'" . $nextday . "',";
            $didheattendquery.="(select count(*) from attendance A where DATE(requesttime)='$dayone[0]-$dayone[1]-$nextday' and A.MSISDN=R.msisdn and verification_status='Approved' and meeting_code='" . $_GET['cell'] . "') AS '" . $nextday . "', ";
            $i++;
        }
        $meetingdays.="'No of Days',";
        $didheattendquery.="(select (case when count(*)>0 then count(*)+$travelling_days else count(*) end) from attendance A where A.MSISDN=R.msisdn and verification_status='Approved' and meeting_code='" . $_GET['cell'] . "')as 'NoofDays', ";
    }


    $attendanceids = "(select id from attendance where recipient_id=R.recipient_id 
 and meeting_code='" . $_GET['cell'] . "') ";
// echo $dynamicrows;
//RESPECTIVE attendance

    $sqltotalpr = "select 
				  sum(
				  (select amount from perdiem where id=C.designationid AND org_id='$m_org_id' )*(select (case when count(*)>0 then count(*)+$travelling_days else count(*) end) from attendance A where A.MSISDN=R.msisdn and meeting_code='" . $_GET['cell'] . "')-
				  ((select (case when count(*)>0 then count(*) else count(*) end) from attendance A where A.MSISDN=R.msisdn  and meeting_code='" . $_GET['cell'] . "')*500)
				  )as 'Total'
				  from attendance R  INNER JOIN recipient C on R.recipient_id=C.ID WHERE R.meeting_code='" . $_GET['cell'] . "'";
    $rowk = mysql_fetch_array(@mysql_db_query($database, $sqltotalpr, $dblink));

    echo $headerTitle = "<h3>BATCH NO " . $_GET['cell'] . " Totaling to: " . $rowk[0] . "</h3>";
    $headerfile = "BATCH NO " . $_GET['cell'] . " Totaling to: " . $rowk[0];

    $query_4 = "select 
				  (select concat(firstname,' ',middlename,' ',lastname) from recipient where id=R.recipient_id)Name,
				   (select title from county where county.id=C.countyid) as `NameofCounty`,
				    (select title from district where id=C.subcountyid)Station, 
				    (select designation from perdiem where id=C.designationid AND org_id='$m_org_id')Designation,
				    (select title from jobgroup where id=C.jobgroupid)JobGroup,
				  $didheattendquery 
				  R.MSISDN as 'Telephone Number',
				  (select amount from perdiem where id=C.designationid AND org_id='$m_org_id')Rate,
				 (SELECT sum(credit) FROM temp_supervision_details where title='Per Diem' and apiorder_id in $attendanceids $limit) as Amount,
				  (SELECT sum(credit) FROM temp_supervision_details where title='Lunch' and apiorder_id in $attendanceids $limit) as 'Less_lunch_day_500',
				  (SELECT sum(credit) FROM temp_supervision_details where title='Transport/Fuel' and apiorder_id in $attendanceids $limit) as 'Transport',
				  (SELECT sum(credit) FROM temp_supervision_details where title='Extra Per Diem' and apiorder_id in $attendanceids $limit) as 'Extra_per_diem',
				  (SELECT sum(credit) FROM temp_supervision_details where title='Others' and apiorder_id in $attendanceids $limit) as 'Others',				  
				  payable_amount_1 as 'Net Pay',
				  (CASE when processing_status='0' then 'Pending Processing'
				   when processing_status='1' then 'Processed Pending Approval' when processing_status='3' then 'Rejected' 
				    when processing_status='4' then 'Processed and Approved' end) AS 'Status',
				    processing_comments,approval_comments,R.ID
				  from attendance R  INNER JOIN recipient C on R.recipient_id=C.ID where meeting_code='" . $_GET['cell'] . "' GROUP BY R.MSISDN";
    $_SESSION['hanson_excel'] = $query_4;
    $_SESSION['FileName'] = $headerfile;
    $result2 = mysql_db_query($database, $query_4, $dblink);
    $rateheader = $meetingtype == 'DayOnly' ? "Lunch Rate" : $meetingtype == 'HalfBoard' ? "Dinner Rate" : "Per Diem Rate";
    $data = "["; // "[['Name','County','Station','Designation','Job Group',$meetingdays'Telephone Number', '$rateheader', 'Amount','Less lunch day @500 ','Transport', 'Extra per diem','Others','Net Pay','Status','Processing Comments','Approval Comments','ID'],";

    $collcount = 17 + $duration; //sure columns before addition of dynamic ones

    while ($row2 = mysql_fetch_array($result2)) {

        $NameofCounty = str_replace("'", "\'", $row2['NameofCounty']);
        $station = str_replace("'", "\'", $row2['Station']);
        $data.="['" . $row2['Name'] . "','" . $NameofCounty . "','" . $station . "','" . $row2['Designation'] . "','" . $row2['JobGroup'] . "','" . $row2[5] . "'";
        if ($duration > 0) {
            $data.=",'" . $row2[6] . "'";
        }
        if ($duration > 1) {
            $data.=",'" . $row2[7] . "'";
        }
        if ($duration > 2) {
            $data.=",'" . $row2[8] . "'";
        }
        if ($duration > 3) {
            $data.=",'" . $row2[9] . "'";
        }
        if ($duration > 4) {
            $data.=",'" . $row2[10] . "'";
        }
        if ($duration > 5) {
            $data.=",'" . $row2[11] . "'";
        }
        if ($duration > 6) {
            $data.=",'" . $row2[12] . "'";
        }
        $data.=",'" . $row2['NoofDays'] . "','" . $row2['Telephone Number'] . "','" . $row2['Rate'] . "','" . $row2['Amount'] . "','" . $row2['Less_lunch_day_500'] . "','" . $row2['Transport'] . "','" . $row2['Extra_per_diem'] . "','" . $row2['Others'] . "','" . $row2['Net Pay'] . "','" . $row2['Status'] . "','" . $row2['processing_comments'] . "','" . $row2['approval_comments'] . "','" . $row2['ID'] . "'],";
    }
    $data.="]";
    $data = str_replace(",]", "]", $data);
    $columns = "[";
    $j = 0;
    while ($collcount > $j) {
        $columns.="{data: $j},";
        $j++;
    }
    $columns.= "]";
    $columns = str_replace(",]", "]", $columns);
    $columnheaders = "['Name','County','Station','Designation','Job Group',$meetingdays'Telephone Number', '$rateheader', 'Amount','Less lunch day @500 ','Transport', 'Extra per diem','Others','Net Pay','Status','Processing Comments','Approval Comments','ID']";
//echo $meetingdays;
    //   echo $data;
#Sample data
    ?>


    <!--    <form name="MERCHANTUPTATEEXCEL" id="MERCHANTUPTATEEXCEL"  method="POST" title="" class="HOUPTATEEXCEL" style="display: block;">-->
    <form name="ATTENDANCEAPPROVALEXCEL" method="POST" title="" class="ATTENDANCEAPPROVALEXCEL" style="display: block;">


        <div id="hot" style="width: 100%; height: 70%; overflow: hidden; z-index: 0"></div>
        <script>
            var dataObject =<?php echo $data; ?>;

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
                columns: <?= $columns; ?>,
                stretchH: 'all',
                // width: 1200,
                autoWrapRow: true,
                height: 441,
                //maxRows: 22,
                rowHeaders: true,
                colHeaders: <?= $columnheaders; ?>,
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
                        url: 'forms/process_form.php?f=MER_SESSION&data=' + change,
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
            <input type="button" name="cancel" value="Dismiss" class="gridSecondaryButton">
            <input type="button" onclick="exportXls3()" value="Download Excel" id="exportXLS22" class="gridPrimaryButton">
            <input type="hidden" name="cell" value="<?= $_GET['cell'] ?>"/>
            <input type="hidden" id="jsondata" name="jsondata" value=""/>
            <input type="hidden" id="collcount" name="collcount" value="<?= $collcount; ?>"/>
        </span>
    </form>



<?php }
?>