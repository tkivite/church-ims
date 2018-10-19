<?php
/**
 * Created by PhpStorm.
 * User: tkivite
 * Date: 8/15/18
 * Time: 7:21 PM
 */

include '../../Shared/php/functions.php';
GLOBAL $dblink;
$title = "New Group Type";
$cell = $_GET['cell'];
if (isset($_GET[cell])) {
    $sql = "Select GroupTypeID , `GroupType`, `Description` from SRC_GroupTypes where GroupTypeID  = '" . $_GET[cell] . "'";
    $result = $dblink->query($sql);
    $row = mysqli_fetch_array($result);
    $GroupTypeId = $row[0];
    $GroupType = $row[1];
    $Description = $row[2];
    $title = "Edit Group Type";
}
?>
<div class="box box-primary">
    <div class="panel-heading panel-primary">
        <h3 class="panel-title"><?php
            echo $title;
            ?></h3>
    </div>
    <div class="box-body">

        <form name="grouptypes" role="form" method="POST" title="" class="form-horizontal" enctype="multipart/form-data"
              style="display: block;">

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Group Type Name:</label>
                <div class="col-sm-10">
                    <input type="text" name="GroupTypeName" id="GroupTypeName" class="form-control required"
                           value="<?php
                           echo $GroupType;
                           ?>" maxlength="255" placeholder="enter your first name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Description:</label>
                <div class="col-sm-10">
                    <textarea name="Description" id="Description" placeholder="Description" class="form-control required"><?php   echo $Description;
                           ?> </textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="email"></label>
                <div class="col-sm-10">

                    <button type="submit" name="action" value="Save"
                            class="btn-primary btn-sm btn-success gridPrimaryButtonSubmit">Save
                    </button>
                    <button type="button" name="cancel" value="Cancel"
                            class="btn-primary btn-sm btn-danger gridSecondaryButton">Cancel
                    </button>
                    <input type="hidden" name="cell" value="<?php
                    echo $_GET[cell];
                    ?>"/>
                </div>

            </div>

        </form>

    </div>





