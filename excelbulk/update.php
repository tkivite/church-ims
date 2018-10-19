<?php

session_start();
echo "The change is " . $_REQUEST['data'] . $_GET['data'];
$dataInput = $_REQUEST['data'] . $_GET['data'];
$values = explode(",", $dataInput);
print_r($values);

$changesArray[] = array();
if ($values[5] != $values[6]) {

    $_SESSION['ho_edit'].=$values[0] . ',';
}

print_r($_SESSION['ho_edit']);
exit;
$jsondata ='[["34613","Safaricom EBU SME","Buy Goods","254705235256","8884412","NAIROBI CENTRAL HARDWARE LTD HEADOFFICE","CBU Acquired",null,null,null,null,"Nrb, Eastern Region",null,"Active","2015-02-02","Bank Settlement","No"],["34612","Safaricom EBU SME","Buy Goods","254722313515","88909054","UTAFITI FOUNDATION HEADOFFICE","CBU Acquired",null,null,null,null,"Nrb, Eastern Region",null,"Active","2015-02-02","Bank Settlement","No"],["34611","Safaricom EBU SME","Buy Goods","254707420751","889080","KAYWORTHS INTERNATIONAL LIMITED","CBU Acquired",null,null,null,null,"Nrb, Eastern Region",null,"Active","2015-02-02","Bank Settlement","No"],["34610","Safaricom EBU SME","Buy Goods","254721660533","888160","JOP ENTERPRISES LTD","CBU Acquired",null,null,null,null,"Nrb, Eastern Region",null,"Active","2015-02-02","Bank Settlement","No"],["34570","Safaricom I&M","Buy Goods","254720402588","969967","CENTRAL PARK HOTEL LIMITED","CBU Acquired","Other",null,"Nairobi CBD",null,"Nrb, Eastern Region","Nairobi","Active","2015-01-29","Bank Settlement","No"],["34519","Safaricom I&M","Buy Goods","254722336683","96999145","VIKABU SACCO SOCIETY LTD","CBU Acquired","Other",null,"Nairobi CBD",null,"Nrb, Eastern Region","Nairobi","Active","2015-01-28","Bank Settlement","No"],["34302","Safaricom I&M","Buy Goods","254722331331","993845","DIXONS ELECTRONICS LTD HQ","CBU Acquired","Electronic Supplies / Electrical Service",null,"Nairobi CBD",null,"Nrb, Eastern Region","Nairobi","Active","2015-01-19","Bank Settlement","No"],["33918","Safaricom EBU SME","Buy Goods","254722281841","891459","SOY AFRIC LTD HEAD OFFICE","CBU Acquired","Other",null,"Nairobi CBD",null,"Nrb, Eastern Region","Nairobi","Active","2015-01-07","Bank Settlement","No"],["33735","Safaricom I&M","Buy Goods","254723000444","419165","KAPUTIEI SAFARILAND HOTEL HQ","CBU Acquired","Other",null,"Mombasa Road",null,"Nrb, Eastern Region","Kajiado","Active","2015-01-06","Bank Settlement","No"],["21823","Safaricom EBU SME","Buy Goods","254722806605","982950","Moston Masters Distributor ","CBU Acquired",null,null,"Lower Mountain",null,"Central, Rift Region ","Embu","Active","2014-10-24","Bank Settlement","No"]]';
$arr = array();
$arr = json_decode($jsondata);
unset($arr[0]);
$collcount = 15;
$_SESSION['ho_edit']="0,2,3,4,3";
echo $_SESSION['ho_edit'].'<br/>';
echo '................................................................................................';
$ho_edit = array_unique(explode(',', $_SESSION['ho_edit']));
echo '<br/>';
var_dump($ho_edit);
echo '<br/>';

foreach ($ho_edit as $itemIndex) {
    $itemIndex=$itemIndex+1;
    echo $itemIndex.'<br/>';
    print_r($arr[$itemIndex]);
    echo '<br/>';
}


echo '................................................................................................';
foreach ($arr as $row) {
    echo '<br/>';
    print_r($row);
    echo '<br/>';
}
?>