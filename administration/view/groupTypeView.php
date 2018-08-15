<?php
/**
 * Created by PhpStorm.
 * User: tkivite
 * Date: 8/15/18
 * Time: 7:21 PM
 */
include '../../Shared/php/functions.php';
$sql =  "Select GroupTypeID , `GroupType`, `Description` from SRC_GroupTypes where GroupTypeID  = '" . $_GET[key] . "'";
GLOBAL $dblink;
$res = $dblink->query($sql);
$row = mysqli_fetch_array($res);
?>

<!-- <form role="form" action="signin.php" name="signin" id="signin" method="POST" >   <form name="user" role="form" method="POST" title="" enctype="multipart/form-data"> -->

<form class="form-horizontal" name="user" role="form" method="POST" >
    <dl class="dl-horizontal ">
        <dt>Group Type: </dt>
        <dd><?php
echo $row[1];
?></dd>
    </dl>
    <dl class="dl-horizontal">
        <dt>Description: </dt>
        <dd><?php
echo $row[2];
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
