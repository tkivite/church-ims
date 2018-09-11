<!doctype html>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$finalData = '';
//if (isset($_POST)) {
//    $target = "uploads/";
//    $mimes = array("text/csv");
//    if (isset($_FILES['csvupload'])) {
//        echo "files set ";
//        $_SESSION['TestingU'] = "here1 <br/>";
//        #payment file upload
//        if (in_array($_FILES['csvupload']['type'], $mimes)) {#Verify Posted file is of correct mime types
//            echo "Mine ok";
//            $target = $target . basename($_FILES['csvupload']['name']);
//
//            if (move_uploaded_file($_FILES['csvupload']['tmp_name'], $target)) {
//                $file = $target; //"MyFile.csv";
//                $csv = file_get_contents($file);
//                $array = array_map("str_getcsv", explode("\n", $csv));
//                $json = json_encode($array);
//
//                echo 'the count is ' . count($array);
//                $data3 = array();
//
//                foreach ($array as $row) {
//
//                    $item['id'] = $row[0];
//                    $item['currencyCode'] = $row[1];
//                    $item['flag'] = $row[2];
//                    $item['currency'] = $row[3];
//                    $item['level'] = $row[4];
//                    $item['units'] = $row[5];
//                    $item['asOf'] = $row[6];
//                    $item['onedChng'] = $row[7];
//                    $item['Status'] = $row[8];
//                    if (isset($item['id']) && $item['id'] != '') {
//                        $data3[] = $item;
//                    }
//                }
//
//                $finalData = json_encode($data3);
//                print_r($finalData);
//            }
//        } else {
//            echo "MIne not ok " . $_FILES['csvupload']['type'];
//        }
//    }
//}
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="handsontable.full.min.css">
        <link rel="stylesheet" type="text/css" href="main.css">
        <script src="handsontable.full.min.js"></script>
        <script src="../../js/libraries/jquery-1.8.2.js" type="text/javascript"></script>
    </head>
    <body>
        
<!--        <form method="POST" enctype="multipart/form-data" >-->
            <div id="hot" class="hot handsontable htRowHeaders htColumnHeaders"></div>

            <?php
            //$data = $finalData;
            $data = "[
    {id: 1, flag: 'EUR', currencyCode: 'EUR', currency: 'KSH',	level: 0.9033, units: 'EUR / USD', asOf: '08/19/2015', onedChng: 0.0026, Status:'Active' },
    {id: 2, flag: 'JPY', currencyCode: 'JPY', currency: 'Japanese Yen', level: 124.3870, units: 'JPY / USD', asOf: '08/19/2015', onedChng: 0.0001, Status:'Active' },
    {id: 3, flag: 'GBP', currencyCode: 'GBP', currency: 'Pound Sterling', level: 0.6396, units: 'GBP / USD', asOf: '08/19/2015', onedChng: 0.00, Status:'Active' },
    {id: 4, flag: 'CHF', currencyCode: 'CHF', currency: 'Swiss Franc',	level: 0.9775, units: 'CHF / USD', asOf: '08/19/2015', onedChng: 0.0008, Status:'Active' },
    {id: 5, flag: 'CAD', currencyCode: 'CAD', currency: 'Canadian Dollar',	level: 1.3097, units: 'CAD / USD', asOf: '08/19/2015', onedChng: -0.0005, Status:'Active' },
    {id: 6, flag: 'AUD', currencyCode: 'AUD', currency: 'Australian Dollar',	level: 1.3589, units: 'AUD / USD', asOf: '08/19/2015', onedChng: 0.0020, Status:'Active' },
    {id: 7, flag: 'NZD', currencyCode: 'NZD', currency: 'New Zealand Dollar',	level: 1.5218, units: 'NZD / USD', asOf: '08/19/2015', onedChng: -0.0036, Status:'Active' },
    {id: 8, flag: 'SEK', currencyCode: 'SEK', currency: 'Swedish Krona',	level: 8.5280, units: 'SEK / USD', asOf: '08/19/2015', onedChng: 0.0016, Status:'Active' },
    {id: 9, flag: 'NOK', currencyCode: 'NOK', currency: 'Norwegian Krone',	level: 8.2433, units: 'NOK / USD', asOf: '08/19/2015', onedChng: 0.0008, Status:'Active' },
    {id: 10, flag: 'BRL', currencyCode: 'BRL', currency: 'Brazilian Real',	level: 3.4806, units: 'BRL / USD', asOf: '08/19/2015', onedChng: -0.0009, Status:'Active' },
    {id: 11, flag: 'CNY', currencyCode: 'CNY', currency: 'Chinese Yuan',	level: 6.3961, units: 'CNY / USD', asOf: '08/19/2015', onedChng: 0.0004, Status:'Active' },
    {id: 12, flag: 'RUB', currencyCode: 'RUB', currency: 'Russian Rouble',	level: 65.5980, units: 'RUB / USD', asOf: '08/19/2015', onedChng: 0.0059, Status:'Active' },
    {id: 13, flag: 'INR', currencyCode: 'INR', currency: 'Indian Rupee',	level: 65.3724, units: 'INR / USD', asOf: '08/19/2015', onedChng: 0.0026, Status:'Active' },
    {id: 14, flag: 'TRY', currencyCode: 'TRY', currency: 'New Turkish Lira',	level: 2.8689, units: 'TRY / USD', asOf: '08/19/2015', onedChng: 0.0092, Status:'Active' },
    {id: 15, flag: 'THB', currencyCode: 'THB', currency: 'Thai Baht',	level: 35.5029, units: 'THB / USD', asOf: '08/19/2015', onedChng: 0.0044, Status:'Active' },
    {id: 16, flag: 'IDR', currencyCode: 'IDR', currency: 'Indonesian Rupiah',	level: 13.83, units: 'IDR / USD', asOf: '08/19/2015', onedChng: -0.0009, Status:'Active' },
    {id: 17, flag: 'MYR', currencyCode: 'MYR', currency: 'Malaysian Ringgit',	level: 4.0949, units: 'MYR / USD', asOf: '08/19/2015', onedChng: 0.0010, Status:'Active' },
    {id: 18, flag: 'MXN', currencyCode: 'MXN', currency: 'Mexican New Peso',	level: 16.4309, units: 'MXN / USD', asOf: '08/19/2015', onedChng: 0.0017, Status:'Active' },
    {id: 19, flag: 'ARS', currencyCode: 'ARS', currency: 'Argentinian Peso',	level: 9.2534, units: 'ARS / USD', asOf: '08/19/2015', onedChng: 0.0011, Status:'Active' },
    {id: 20, flag: 'DKK', currencyCode: 'DKK', currency: 'Danish Krone',	level: 6.7417, units: 'DKK / USD', asOf: '08/19/2015', onedChng: 0.0025, Status:'Active' },
    {id: 21, flag: 'ILS', currencyCode: 'ILS', currency: 'Israeli New Sheqel',	level: 3.8262, units: 'ILS / USD', asOf: '08/19/2015', onedChng: 0.0084, Status:'Active' },
    {id: 22, flag: 'PHP', currencyCode: 'PHP', currency: 'Philippine Peso',	level: 46.3108, units: 'PHP / USD', asOf: '08/19/2015', onedChng: 0.0012, Status:'Active' }
  ]";
            // echo $data13;
            // echo '<br/>';
            echo '';
            ?>

            <button id="export-file" onclick="exportTOCsv()" class="intext-btn">
                Export as a file
            </button>


<!--        </form>-->

<!--        <form method="POST" id="b" action="http://tibusandbox.tangazoletu.com/api/handonExcelupdate/samplePost.php" enctype="multipart/form-data" >

            <input name="csvupload" type="file" id="csvupload" class="required" accept="application/vnd.ms-excel,text/csv">
            <input type="hidden" name="test" id="test" value="Patrick"/>
            <button type="" onclick="postUploadedFile()"  value="Submit">Testing here</button>

        </form>-->

<form id="upload_form" enctype="multipart/form-data">

    <input type="file" name="csvupload" />
    <button type="button" onclick="postUploadedFile()"  value="Submit">Testing here</button>
</form>

    </body>
    <script>
        var dataObject =<?php echo $data ?>;

        console.log(dataObject);

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
                    data: 'id',
                    type: 'numeric',
                    width: 40
                },
                {
                    data: 'flag',
                    renderer: flagRenderer
                },
                {
                    data: 'currencyCode',
                    type: 'text'
                },
                {
                    data: 'currency',
                    type: 'text'
                },
                {
                    data: 'level',
                    type: 'numeric',
                    format: '0.0000'
                },
                {
                    data: 'units',
                    type: 'text'
                },
                {
                    data: 'asOf',
                    type: 'date',
                    dateFormat: 'MM/DD/YYYY'
                },
                {
                    data: 'onedChng',
                    type: 'numeric',
                    format: '0.00%'
                },
                {
                    data: 'Status',
                    type: 'dropdown',
                    source: ['Active', 'InActive']
                }
            ],
            stretchH: 'all',
            width: 806,
            autoWrapRow: true,
            height: 441,
            maxRows: 22,
            rowHeaders: true,
            colHeaders: [
                'ID',
                'Country',
                'Code',
                'Currency',
                'Level',
                'Units',
                'Date',
                'Change',
                'Status'
            ],
            fixedRowsTop: 2,
            fixedColumnsLeft: 3,
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


        var buttons = {
            file: document.getElementById('export-file')
        };

        var exportPlugin = hot.getPlugin('exportFile');
        var resultTextarea = document.getElementById('result');



        //            buttons.stringRange.addEventListener('click', function () {
        //                resultTextarea.value = exportPlugin.exportAsString('csv', {
        //                    exportHiddenRows: true, // default false, exports the hidden rows
        //                    exportHiddenColumns: true, // default false, exports the hidden columns
        //                    columnHeaders: true, // default false, exports the column headers
        //                    rowHeaders: true, // default false, exports the row headers
        //                    columnDelimiter: ';', // default ',', the data delimiter
        //                    range: [1, 1, 3, 3]         // data range in format: [startRow, endRow, startColumn, endColumn]
        //                });
        //                console.log(resultTextarea.value);
        //            });


//                buttons.file.addEventListener('click', function () {
//                    alert("test");
//                    exportPlugin.downloadFile('csv', {filename: 'MyFile'});
//                });

        function exportTOCsv() {
            alert("test");
            exportPlugin.downloadFile('csv', {filename: 'MyFile'});
        }

 function   postUploadedFile() {
        var formData = new FormData($('#upload_form')[0]);

        formData.append('csvupload', $('input[type=file]')[0].files[0]);

        $.ajax({
            type: "POST",
            url: 'http://tibusandbox.tangazoletu.com/api/handonExcelupdate/samplePost.php',
            data: formData,
            //use contentType, processData for sure.
            contentType: false,
            processData: false,
            success: function (msg) {
                alert(msg);
            },
            error: function () {
                alert('Message is ok');
            }
        });
    }
    
        function postUploadedFile2() {
            alert('Perfect');
            event.preventDefault();
            var csvUpload = $("#csvUpload").val();
            var test = $("#test").val();

            console.log('Testing here ' + $('#b').serialize());
            $.ajax({
                type: 'POST',
                contentType: 'multipart/form-data',
                url: 'http://tibusandbox.tangazoletu.com/api/handonExcelupdate/samplePost.php',
                data: $('#b').serialize(),
                cache: false,                
                processData: false,                
                success: function (data) {
                    alert(data);
                }
            });
            
//                    $.ajax({
//                        url: 'http://tibusandbox.tangazoletu.com/api/handonExcelupdate/samplePost.php',
//                        type: 'POST',
//                        data: $('#b').serialize(),
//                        async: false,
//                        cache: false,
//                        contentType: 'multipart/form-data',
//                        processData: false,
//                        success: function (response) {
//                            alert(response);
//                        }
//                    });
        }
    </script>

</html>