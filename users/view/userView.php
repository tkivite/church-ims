
<?php
include '../../Shared/php/functions.php';
 $sql = "SELECT ID ,Name,Email,Phone,Company FROM users WHERE ID = '" . $_GET[key] . "'";
GLOBAL $dblink;
$res = $dblink->query($sql);
//oci_execute($res);
$row = mysqli_fetch_array($res);
?>

<!-- <form role="form" action="signin.php" name="signin" id="signin" method="POST" >   <form name="user" role="form" method="POST" title="" enctype="multipart/form-data"> -->

<form class="form-horizontal" name="user" role="form" method="POST" >
    <dl class="dl-horizontal ">
        <dt>Names: </dt>
        <dd><?php echo  $row[2]  ?></dd>
    </dl>
    <dl class="dl-horizontal">
        <dt>Email: </dt>
        <dd><?php echo  $row[2]   ?></dd>
    </dl>
    <dl class="dl-horizontal">
        <dt>Phone: </dt>
        <dd><?php echo  $row[3] ?></dd>
    </dl>

    <dl class="dl-horizontal">
        <dt>Company: </dt>
        <dd><?php echo  $row[4] ?></dd>
    </dl>

    <dl class="dl-horizontal">
        <dt> </dt>
        <dd>
            <input type="button" name="updater" value="Edit" class="btn-primary btn-sm gridEditButton1">              
        </dd>
    </dl>

    <input type="hidden" name="cell" id="formRecordId" value="<?php echo   $_GET[key] ?>"/>
   
    </br></br></br>

</form>
