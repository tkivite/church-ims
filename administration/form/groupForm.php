<?php
/**
 * Created by PhpStorm.
 * User: tkivite
 * Date: 8/15/18
 * Time: 7:21 PM
 */

include '../../Shared/php/functions.php';
GLOBAL $dblink;
$title = "New Group";
$cell = $_GET['cell'];
if (isset($_GET[cell])) {
    $sql = "Select GroupID ,GroupName, `GroupTypeID`, `GroupLabel` from SRC_Groups where GroupID  = '" . $_GET[cell] . "'";
    $result = $dblink->query($sql);
    $row = mysqli_fetch_array($result);
    $GroupId = $row[0];
    $GroupName = $row[1];
    $GroupType = $row[2];
    $GroupLabel = $row[3];
    $title = "Edit Group";
}
?>
<div class="box box-primary">
    <div class="panel-heading panel-primary">
        <h3 class="panel-title"><?php
            echo $title;
            ?></h3>
    </div>
    <div class="box-body">

        <form name="groups" role="form" method="POST" title="" class="form-horizontal" enctype="multipart/form-data"
              style="display: block;">

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Group Name:</label>
                <div class="col-sm-10">
                    <input type="text" name="GroupName" id="GroupName" class="form-control required"
                           value="<?php
                           echo $GroupName;
                           ?>" maxlength="255" placeholder="enter group name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Group Type:</label>

                <div class="col-sm-10">
                    <?php $query = 'Select GroupTypeID,GroupType From SRC_GroupTypes  order by GroupTypeID Asc';

                    $select = createSelect('GroupType','Select Group Type',$query,true,$GroupType);
                    echo  $select;
                    ?>

                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Group Label:</label>
                <div class="col-sm-10">
                    <input type="text" name="GroupLabel" id="GroupLabel" class="form-control required"
                           value="<?php
                           echo $GroupLabel;
                           ?>" maxlength="255" placeholder="enter group label ">
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





