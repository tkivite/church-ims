<?php

echo "testing here";

$finalData = "";

$target = "uploads/";
$mimes = array("text/csv");
if (isset($_FILES['csvupload'])) {
    echo "files set ";
    $_SESSION['TestingU'] = "here1 <br/>";
    #payment file upload
    if (in_array($_FILES['csvupload']['type'], $mimes)) {#Verify Posted file is of correct mime types
        // echo "Mine ok";
        $target = $target . basename($_FILES['csvupload']['name']);

        if (move_uploaded_file($_FILES['csvupload']['tmp_name'], $target)) {
            $file = $target; //"MyFile.csv";
            $csv = file_get_contents($file);
            $array = array_map("str_getcsv", explode("\n", $csv));
            $json = json_encode($array);

            echo 'the count is ' . count($array);
            $data3 = array();

            foreach ($array as $row) {

                $item['id'] = $row[0];
                $item['currencyCode'] = $row[1];
                $item['flag'] = $row[2];
                $item['currency'] = $row[3];
                $item['level'] = $row[4];
                $item['units'] = $row[5];
                $item['asOf'] = $row[6];
                $item['onedChng'] = $row[7];
                $item['Status'] = $row[8];
                if (isset($item['id']) && $item['id'] != '') {
                    $data3[] = $item;
                }
            }

            $finalData = json_encode($data3);
            echo $finalData;
            return;
        }
    } else {
        echo "MIne not ok " . $_FILES['csvupload']['type'];
    }
}
?>