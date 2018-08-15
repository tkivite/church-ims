
<?php
include '../../Shared/php/functions.php';
$sql = "SELECT AccountID AS \"primarykey\",AccountName,AccountCode,CurrentBalance,`CR-DR`,Category FROM SRC_Accounts Where ParentID = '" . $_GET[key] . "' ";
GLOBAL $dblink;

$parent = $_GET['key'];

echo 'PArent  '.$parent;
$res = generateAccountsChildren("Accounts", "view", $sql, true, true, true, false, false, $pagination,$actionsBar,array("search","status","date"),true,$parent);

echo $res;
/*$content = $dblink->query($sql); 
    
$resultArray = getResultArray2($content);


$gridComponent ='<table>';

    foreach ($resultArray as $resul) {
        
        
        $pk = $resul['primarykey'];
        //  $gridComponent .= "<tr class='gridContentRecord' title='" . $row[1] . "'>";
        //   if($resul['Label'] == 'NEW')
        //    $banner = 'style ="border: 2px solid red;"';             
        //    else 
        //      $banner ='';
        $gridComponent .= "<tr  $banner title='" . $resul['primarykey'] . "'>";
        
        
      
        
      
        $count = mysqli_num_fields($content);
        
        $y = 1;
        
       
            $gridComponent .= "<td class= 'acct-details-control'>  </td>";
        
        
        
        while ($y < $count) {
            $finfo = mysqli_fetch_field_direct($content, $y);
            $meta  = $finfo->name;
            
            //   $meta ="Phone";
            
            $i = $y - 1;
            //$gridComponent .= $meta;
            
            
         
                $gridComponent .= "<td>$resul[$meta]</td>";
            
            
            $y = $y + 1;
        }
            $gridComponent .= "</tr>";
        
        
    }
    $gridComponent .= "</table>";
echo $gridComponent;*/

?>


