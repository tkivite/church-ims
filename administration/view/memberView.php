
<?php
include '../../Shared/php/functions.php';
$sql =  "Select MemberID, `FirstName`,`MiddleName`, `LastName`, `Mobile`,`Email`,`DOB`, `Gender`,  `Residence`, `Occupation` from SRC_Members where MemberID  = '" . $_GET[key] . "'";
GLOBAL $dblink;
$res = $dblink->query($sql);
//oci_execute($res);
$row = mysqli_fetch_array($res);
?>

<!-- <form role="form" action="signin.php" name="signin" id="signin" method="POST" >   <form name="user" role="form" method="POST" title="" enctype="multipart/form-data"> -->

<form class="form-horizontal" name="user" role="form" method="POST" >
    <dl class="dl-horizontal ">
        <dt>First Name: </dt>
        <dd><?php
echo $row[1];
?></dd>
    </dl>
    <dl class="dl-horizontal">
        <dt>Middle Name: </dt>
        <dd><?php
echo $row[2];
?></dd>
    </dl>
    <dl class="dl-horizontal">
        <dt>Last Name: </dt>
        <dd><?php
echo $row[3];
?></dd>
    </dl>
    
       <dl class="dl-horizontal">
        <dt>Gender: </dt>
        <dd><?php
echo $row[7];
?></dd>
    </dl>
    <dl class="dl-horizontal">
        <dt>Mobile: </dt>
        <dd><?php
echo $row[4];
?></dd>
    </dl>
    <dl class="dl-horizontal">
        <dt>Email: </dt>
        <dd><?php
echo $row[5];
?></dd>
    </dl>
<dl class="dl-horizontal">
        <dt>Date of Birth: </dt>
        <dd><?php
echo $row[6];
?></dd>
    </dl>
<dl class="dl-horizontal">
        <dt>Residence: </dt>
        <dd><?php
echo $row[8];
?></dd>
    </dl>
<dl class="dl-horizontal">
        <dt>Occupation: </dt>
        <dd><?php
echo $row[9];
?></dd>
    </dl>

     

    <dl class="dl-horizontal">
        <dt> </dt>
        <dd>
            <input type="button" name="updater" value="Edit" class="btn-primary btn-sm gridEditButton1">           
        </dd>
    </dl>

    <input type="hidden" name="cell" id="formRecordId" value="<?php
echo $_GET[key];
?>"/>
   
    </br></br></br>

</form>
