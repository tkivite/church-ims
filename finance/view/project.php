<?php
/**
 * Created by PhpStorm.
 * User: tkivite
 * Date: 8/27/18
 * Time: 1:12 PM
 */

ini_set('display_errors', 1);
include '../../Shared/php/functions.php';
GLOBAL $dblink;

 $sql = " SELECT ProjectTID as primary_key, ProjectName,Description,StartDate,Target  
 FROM SRC_Projects WHERE  ProjectTID = '" . $_GET[key] . "' ";
GLOBAL $dblink;
$res = $dblink->query($sql);
//oci_execute($res);
$row = mysqli_fetch_array($res);
?>

<!-- <form role="form" action="signin.php" name="signin" id="signin" method="POST" >   <form name="user" role="form" method="POST" title="" enctype="multipart/form-data"> -->

<form class="form-horizontal" name="project" role="form" method="POST" >
    <dl class="dl-horizontal ">
        <dt>Project Name: </dt>
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
        <dt>Target: </dt>
        <dd><?php
            echo $row[4];
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





