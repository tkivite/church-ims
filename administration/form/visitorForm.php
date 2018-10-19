<?php
ini_set('display_errors', 0);
include '../../Shared/php/functions.php';
GLOBAL $dblink;

$title = "New Visitor";
$cell  = $_GET['cell'];
if (isset($_GET[cell])) {
    $sql           = "Select VisitorID as primarykey, 
                      `Email`,  `FirstName`,`MiddleName`, `LastName`, 
                      `Mobile`, Occupation,Residence,BornAgain,Gender,VisitorType,DateofVisit
                       from SRC_Visitors where VisitorID  = '" . $_GET[cell] . "'";
    $result        = $dblink->query($sql);
    $row           = mysqli_fetch_array($result);
    $Email         = $row[1];
    $FirstName     = $row[2];
    $MiddleName    = $row[3];
    $LastName      = $row[4];
    $Mobile        = $row[5];
   // $DOB           = $row[6];
  //  $Image         = $row[7];
    $Occupation    = $row[6];
    $Residence     = $row[7];
    $BornAgain     = $row[8];
    $Gender        = $row[9];
    $VisitorType   = $row[10];
    $dateOfVisit   = $row[11];

    
    
    $title = "Edit Visitor";
}

?>


 <div class="box box-primary">
                            <div class="panel-heading panel-primary">
                             <h3 class="panel-title"><?php
echo $title;
?></h3>
                             </div>
                             <div class="box-body">

    
<form name="visitors" role="form" method="POST" title="" class="form-horizontal" enctype="multipart/form-data" style="display: block;">
   

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
    <div class="form-group" style="display: none;" id="Date of Visit">
        <label class="control-label col-sm-2" for="DOB">Date of Visit:</label>
        <div class="col-sm-10">
            <input type="date" name="dateOfVisit" id="dateOfVisit" class="form-control required" value="<?php
            echo $dateOfVisit;
            ?>" maxlength="255" placeholder="enter term">

        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="Message">Born Again:</label>
        <div class="col-sm-10">



                <select class="form-control required" name="bornAgain" id="bornAgain">
                <option <?php echo $BornAgain =="NO"?"selected":""; ?> value = "NO">NO</option>
                <option <?php echo $BornAgain =="YES"?"selected":""; ?>  value = "YES">YES</option>
            </select>

        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="Message">Visitor Type:</label>
        <div class="col-sm-10">


            <select class="form-control required" name="visitorType" id="visitorType">
                <option <?php echo $VisitorType =="Looking for Church"?"selected":""; ?> value = "Looking for Church">Looking for Church</option>
                <option <?php echo $VisitorType =="Just Visiting"?"selected":""; ?>  value = "Just Visiting">Just Visiting</option>
            </select>

        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="Message">Notes:</label>
        <div class="col-sm-10">
           <textarea class = "form-control" rows="5" name="notes" id="notes" placeholder="Additional Notes about the visitor"></textarea>
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



  

                             