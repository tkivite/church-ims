<?php

//session_start();
//echo "The change is " . $_REQUEST['data'] . $_GET['data'];
//$dataInput = $_REQUEST['data'] . $_GET['data'];
//$values = explode(",", $dataInput);
//print_r($values);
//
//$changesArray[] = array();
//if ($values[5] != $values[6]) {
//
//    $_SESSION['mer_edit'].=$values[0] . ',';
//}
//echo 'The sesion is ';
//print_r($_SESSION['mer_edit']);

echo $sr = "790365,791369,790356,905822,905821,790150";

echo "<br/>";

$elements = explode(",", $sr);
$ky = implode("','", $elements);
$ky="'" . $ky . "'";

exit;

$_SESSION['testing3'] = '<br/> json data..............' . $_POST['jsondata'];
$_SESSION['testing3'] .= '<br/> Merchant edit' . $_SESSION['mer_edit'];
$jsondata = '[["28920","954516","ROSE TAILORING STALL 304","254726911437","254726911437","Active",null,null,"EBU Acquired","Nairobi CBD","Other","954616","Nrb, Eastern Region","Nairobi","PLISILA KANUNA","254714626367",null,null],["28919","958120","HIFAR ENTERPRISES","254716631041","254726911437","Active","Tangazoletu","Safaricom EBU SME","EBU Acquired","Nairobi East","Kiosk / Stall - Clothes / General Items","958220","Nrb, Eastern Region","Nairobi","JANE KIMONYI","254728559807",null,null],["28915","954513","JECINTA KINYILI","254722746311","254726911437","Active",null,null,"EBU Acquired","Kangundo Road","Other","954613","Nrb, Eastern Region","Machakos","not provided","not provided",null,null]]';
$arr = array();
$arr = json_decode($jsondata);

print_r($arr);

$_SESSION['mer_edit'] = "0,0,0,0,";
$_SESSION['testing3'].= $_SESSION['mer_edit'] . '<br/>';
$_SESSION['testing3'].= '................................................................................................';
$mer_edit = array_unique(explode(',', rtrim("0,1,2", ",")));
// $_SESSION['testing3'].= '<br/>';
$_SESSION['testing3'].=implode(",", $mer_edit);

print_r($mer_edit);
// $_SESSION['testing3'].= '<br/>';

foreach ($mer_edit as $itemIndex) {

    $_SESSION['testing3'].= "The index is .................................." . $itemIndex . '<br/>';
    $merchant = $arr[$itemIndex];

    print_r($merchant);
    $_SESSION['testing3'].="the array is: " . $itemIndex . " " . $arr[$itemIndex];
    $merchant_id = $merchant[0];
    $StoreNumber = $merchant[1];
    $StoreName = $merchant[2];
    $MerchantMsisdn = $merchant[3];
    $MerchantMsisdn2 = $merchant[4];
    $SubscriptionStatus = $merchant[5] == "Active" ? 1 : 0;
    $HoName = $merchant[6];
    $AcquirerName = $merchant[7];
    $businesstype = $merchant[8];
    $BusinessLocation = $merchant[9];
    $BusinessCategory = $merchant[10];
    $TillNumbers = $merchant[11];
    $BusinessRegions = $merchant[12];
    $BusinessCounty = $merchant[13];
    $NextOfKinName = $merchant[14];
    $NextOfKinMSISDN = $merchant[15];
    $NextOfKinID = $merchant[16];
    $Email = $merchant[17];
    $Comments = $merchant[18];


    $update = "UPDATE MERCHANT_SETTLEMENT_SUBSCRPTNS SET STORE_NUMBER='$StoreNumber',STORE_NAME='$StoreName',MERCHANT_MSISDN='$MerchantMsisdn',MERCHANT_MSISDN2='$MerchantMsisdn2',
                            SUBSCRIPTION_STATUS='$SubscriptionStatus',
                            HO_ID=(SELECT ID FROM MERCHANT_SETTMENT_HO_DETAILS WHERE INTRASH='NO' AND HO_NAME='$HoName' AND ROWNUM=1) ,
                            AGGREGATOR_ID=(SELECT ID FROM MERCHANT_SETTLEMENT_AGREGATORS  WHERE NAME='$AcquirerName' AND ROWNUM=1 ),
                            BUSINESS_CLASS_ID=(SELECT ID FROM MERCHANT_SETTLEMENT_B_CLASS WHERE INTRASH = 'NO' AND CLASS_NAME='$BusinessType' AND ROWNUM=1)
                            ,BUSINESS_LOCATION=(SELECT ID FROM MERCHANT_SETTLEMENT_LOCATIONS WHERE INTRASH = 'NO' and TITLE='$BusinessLocation' and rownum=1),
                            BUSINESS_TYPE=(SELECT ID FROM MERCHANT_SETTLEMENT_BIZTYPE WHERE INTRASH = 'NO' AND TITLE='$BusinessCategory' and ROWNUM=1) ,
                            TILL_NUMBERS='$TillNumbers',
                            BUSINESS_REGION=(SELECT ID FROM MERCHANT_SETTLEMENT_REGIONS WHERE INTRASH ='NO'AND TITLE='$BusinessRegions' AND ROWNUM=1), 
                            COUNTY=(SELECT ID FROM MERCHANT_SETTLEMENT_COUNTY WHERE MERCHANT_SETTLEMENT_COUNTY.INTRASH = 'NO' AND MERCHANT_SETTLEMENT_COUNTY.TITLE='$BusinessCounty' AND ROWNUM=1),
                            NOK_NAME='$NextOfKinName' ,NOK_MSISDN='$NextOfKinMSISDN',NOK_ID='$NextOfKinID' ,EMAIL='$Email',COMMENTS='$Comments'
                 WHERE INTRASH='NO' AND ID='$merchant_id'";

    $_SESSION['testing3'].= '<br/> :.....................' . $update;
}
echo $_SESSION['testing3'];
$_SESSION['Notes'] = count($mer_edit) . " Merchant Records Updated successfully";
?>