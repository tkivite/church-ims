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
$title = "New Project";
$cell = $_GET['cell'];

if (isset($_GET[cell])) {
    $sql = " SELECT ProjectTID as primarykey, ProjectName,Description,StartDate,Target  FROM SRC_Projects WHERE  ProjectTID = '" . $_GET[cell] . "'";
    $result = $dblink->query($sql);
    $row = mysqli_fetch_array($result);
    $ProjectName = $row[1];
    $Description = $row[2];
    $Target = $row[4];
    $title = "Edit Project";
}
?>
<div class="box box-primary">
    <div class="panel-heading panel-primary">
        <h3 class="panel-title"><?php
            echo $title;
            ?></h3>
    </div>
    <div class="box-body">


        <form name="project" role="form" method="POST" title="" class="form-horizontal" enctype="multipart/form-data"
              style="display: block;">


            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Project Name:</label>
                <div class="col-sm-10">
                    <input type="text" name="name" id="name" class="form-control required" value="<?php
                    echo $ProjectName;
                    ?>" maxlength="255" placeholder="Project Name">

                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Description:</label>
                <div class="col-sm-10">


                    <input type="text" name="description" id="description" class="form-control required" value="<?php
                    echo $Description;
                    ?>" maxlength="255" placeholder="Description">

                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Target:</label>
                <div class="col-sm-10">
                    <input type="money" name="target" id="target" class="form-control required" value="<?php
                    echo $Target;
                    ?>" maxlength="255" placeholder="Target Amount">

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
                    <input type="hidden" name="recordscount" value="<?php
                    echo $recordCount;
                    ?>"/>

                </div>

        </form>

    </div>




