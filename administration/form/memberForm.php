<?php
ini_set('display_errors', 0);
include '../../Shared/php/functions.php';
GLOBAL $dblink;

$title = "New Member";
$cell  = $_GET['cell'];
if (isset($_GET[cell])) {
    $sql           = "Select MemberID as primarykey, `Email`,  `FirstName`,`MiddleName`, `LastName`, `Mobile`, `DOB`, `Image`, `Residence`, `Occupation`, `Gender` from SRC_Members where MemberID  = '" . $_GET[cell] . "'";
    $result        = $dblink->query($sql);
    $row           = mysqli_fetch_array($result);
    $Email   = $row[1];
    $FirstName     = $row[2];
    $MiddleName    = $row[3];
    $LastName      = $row[4];
    $Mobile        = $row[5];
    $DOB           = $row[6];
    $Image         = $row[7];
    $Residence     = $row[8];
    $Occupation    = $row[9];
    $Gender        = $row[10];
    
    
    $title = "Edit Member";
}

?>


 <div class="box box-primary">
                            <div class="panel-heading panel-primary">
                             <h3 class="panel-title"><?php
echo $title;
?></h3>
                             </div>
                             <div class="box-body">

    
<form name="members" role="form" method="POST" title="" class="form-horizontal" enctype="multipart/form-data" style="display: block;">
   

    <div class="form-group">
        <label class="control-label col-sm-2" for="name">First Name:</label>
        <div class="col-sm-10">
            <input type="text" name="FirstName" id="FirstName" class="form-control required" value="<?php
    echo $FirstName;
?>" maxlength="255" placeholder="enter your first name">
        </div>
    </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="name">Middle Name:</label>
        <div class="col-sm-10">
            <input type="text" name="MiddleName" id="MiddleName" class="form-control required" value="<?php
    echo $MiddleName;
?>" maxlength="255" placeholder="enter your middle name">
        </div>
    </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="name">Last Name:</label>
        <div class="col-sm-10">
            <input type="text" name="LastName" id="LastName" class="form-control required" value="<?php
    echo $LastName;
?>" maxlength="255" placeholder="enter your last name">
        </div>
    </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="name">Mobile:</label>
        <div class="col-sm-10">
            <input type="text" name="Mobile" id="Mobile" class="form-control required" value="<?php
    echo $Mobile;
?>" maxlength="255" placeholder="enter the mobile phone">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="name">Email:</label>
        <div class="col-sm-10">
            <input type="text" name="Email" id="Email" class="form-control required" value="<?php
    echo $Email;
?>" maxlength="255" placeholder="enter the user">
        </div>
    </div>
    
           
    <div class="form-group">
        <label class="control-label col-sm-2" for="Message">Residence:</label>
        <div class="col-sm-10">
              <input type="text" name="Residence" id="Residence" class="form-control required" value="<?php
    echo $Residence;
?>" maxlength="255" placeholder="enter residence">
 
                </div>
    </div>
                 
    <div class="form-group">
        <label class="control-label col-sm-2" for="Message">Occupation:</label>
        <div class="col-sm-10">
              <input type="text" name="Occupation" id="Occupation" class="form-control required" value="<?php
    echo $Occupation;
?>" maxlength="255" placeholder="enter Occupation">
 
                </div>
    </div>
     <div class="form-group">
               <label class="control-label col-sm-2" for="name">Gender:</label>
               <div class="col-sm-10">
                  <select class="form-control required" name="Gender" id="Gender">
                     <option value="Male" <?php
    echo ($Gender == 'Male') ? 'selected' : '';
?>>Male</option>
                     <option value="Female" <?php
    echo ($Gender == 'Female') ? 'selected' : '';
?>>Female</option>
                    
                     
                  </select>
               </div>
            </div>
    
    <div class="form-group" style="display: none;" id="Date of Birth">
        <label class="control-label col-sm-2" for="DOB">Date of birth:</label>
        <div class="col-sm-10">
              <input type="date" name="DOB" id="DOB" class="form-control required" value="<?php
    echo $DOB;
?>" maxlength="255" placeholder="enter term">
 
                </div>
    </div>
   
    <div class="form-group">
        <label class="control-label col-sm-2" for="email"></label>
        <div class="col-sm-10">

            <button type="submit" name="action" value="Save" class="btn-primary btn-sm btn-success gridPrimaryButtonSubmit">Save</button>
            <button type="button" name="cancel" value="Cancel" class="btn-primary btn-sm btn-danger gridSecondaryButton">Cancel</button>
            <input type="hidden" name="cell" value="<?php
    echo $_GET[cell];
?>"/>
        </div>

    </div>

</form>
         
</div>



  

                             