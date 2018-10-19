<?php
/**
 * Created by PhpStorm.
 * User: tkivite
 * Date: 8/15/18
 * Time: 7:21 PM
 */
include '../../Shared/php/functions.php';
$sql =  "Select GroupID, GroupName,(select GroupType from SRC_GroupTypes where SRC_GroupTypes.GroupTypeID = SRC_Groups.GroupTypeID)Group_Type, GroupLabel from SRC_Groups Where  GroupID = '" . $_GET[key] . "'";
GLOBAL $dblink;
$res = $dblink->query($sql);
$row = mysqli_fetch_array($res);
?>

<!-- <form role="form" action="signin.php" name="signin" id="signin" method="POST" >   <form name="user" role="form" method="POST" title="" enctype="multipart/form-data"> -->

<div class="col-sm-12 bg-primary">
    <div class="container col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home<?php echo $_GET[key]; ?>">Group Details</a></li>
            <li><a data-toggle="tab" href="#leaders<?php echo $_GET[key]; ?>">Group Leaders</a></li>
            <li><a data-toggle="tab" href="#members<?php echo $_GET[key]; ?>">Group Members</a></li>
            <li><a data-toggle="tab" href="#activities<?php echo $_GET[key]; ?>">Group Activities</a></li>
            <li><a data-toggle="tab" href="#contributions<?php echo $_GET[key]; ?>">Group Contributions</a></li>

            <!--<li><a data-toggle="tab" href="#menu3"></a></li>-->
        </ul>

        <div class="tab-content">
            <div id="home<?php echo $_GET[key]; ?>" class="tab-pane  fade in active text-muted" style="background: #ECF0F5">


                <form class="form-horizontal" name="user" role="form" method="POST" >
                    <dl class="dl-horizontal ">
                        <dt>Group Name: </dt>
                        <dd><?php
                            echo $row[1];
                            ?></dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>Group Type: </dt>
                        <dd><?php
                            echo $row[2];
                            ?></dd>
                    </dl>

                    <dl class="dl-horizontal">
                        <dt>Group Label: </dt>
                        <dd><?php
                            echo $row[3];
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

            </div>
            <div id="members<?php echo $_GET[key]; ?>" class="tab-pane fade text-muted" style="background: #ECF0F5">
                <button id="<?php echo $id_directors; ?>" style="margin: 4px" type="button" name="director" value="Add Director" class="btn-primary btn-sm btn-success resolveBizCustomer">Add Director
                </button>
                <?php
                //$queryMe = "Select MERCHANT_MSISDN, STORE_NUMBER, STORE_NAME, loc.TITLE as LOCATION, bz.TITLE as BZ_TYPE,CASE WHEN CONFIRMED = 'NO' THEN 'Awaiting Confirmation' WHEN CONFIRMED = 'REJ' THEN 'Rejected'  WHEN SUBSCRIPTION_STATUS=0 THEN 'Inactive' ELSE 'Confirmed' END AS STATUS, to_char(activation_date,'YYYY-MM-DD') as ACTIVATION_DATE, to_char(subscription_date,'YYYY-MM-DD') as CREATION_DATE,(CASE WHEN SETTLEMENT_OPTION=2 then 'Bank Settlement' ELSE 'M-PESA Settlment' END) as SETTLEMENT_OPTION from MERCHANT_SETTLEMENT_SUBSCRPTNS S LEFT JOIN MERCHANT_SETTLEMENT_LOCATIONS loc ON loc.ID = S.BUSINESS_LOCATION LEFT JOIN MERCHANT_SETTLEMENT_BIZTYPE bz ON bz.ID = S.BUSINESS_TYPE WHERE S.INTRASH = 'NO' AND HO_ID= '" . $_GET[key] . "' ORDER BY SUBSCRIPTION_DATE DESC";
                // $queryMed = "SELECT DIRECTOR_ID,DIRECTOR_NAME,MOBILE,EMAIL,ID_NUMBER FROM NIC_BUSINESS_DIRECTORS WHERE CUSTOMER_ID_FK ='" . $_GET[key] . "' AND INTRASH='NO'";
                 $queryDir = "Select MemberID,  concat(`FirstName`,' ',`MiddleName`, ' ',  `LastName`)Names, `Mobile`, `Email`, `Residence`, `Occupation`, `Gender` from SRC_Members where MemberID in ( select MemberID from SRC_GroupMembers Where GroupID ='" . $_GET[key] . "') ";

                // $rsd = execQuery($queryMed);
                $rsd = execQuery($queryDir);
                //var_dump($rsd);

                echo "<table style='margin: 2px' id='report' class='table table-striped table-bordered table-hover dataTable no-footer'>
                    <tr class='gridColumns gradientSilver'>
                        <th>NAMES</th>
                        <th>PHONE NUMBER</th>
                        <th>EMAIL</th>
                        <th>RESIDENCE</th>
                    </tr>";
                foreach ($rsd as $rowd) {
                    $celd .= "<tr>";
                    $celd .= "<td>" . $rowd["Names"] . "</td>";
                    $celd .= "<td>" . $rowd["Mobile"] . "</td>";
                    $celd .= "<td>" . $rowd["Email"] . "</td>";
                    $celd .= "<td>" . $rowd["Residence"] . "</td>";
                   // $celd .= "<td><button id='$id_nominees_edit' type='button' name='editdirector' value='Edit Director' class='btn-primary btn-sm btn-success gridEditCustomerdetails'>Edit</button></td>";
                  //  $celd .= "<td><div>
                    //                  <button name='deleter' id='$id_nominees_delete' value='Delete' class='btn-primary btn-sm btn-danger gridCustomDelete'>Delete</button>
                   //                   </div></td>";
                    $celd .= "</tr>";
                }
                echo "$celd</table></br>";
                ?>
            </div>


            <div id="leaders<?php echo $_GET[key]; ?>" class="tab-pane fade text-muted" style="background: #ECF0F5">
                <button id="<?php echo $id_accs; ?>" style="margin: 4px" type="button" name="accs" value="" class="btn-primary btn-sm btn-success resolveBizCustomer">Add Account
                </button>
                <?php
                //$queryMe = "Select MERCHANT_MSISDN, STORE_NUMBER, STORE_NAME, loc.TITLE as LOCATION, bz.TITLE as BZ_TYPE,CASE WHEN CONFIRMED = 'NO' THEN 'Awaiting Confirmation' WHEN CONFIRMED = 'REJ' THEN 'Rejected'  WHEN SUBSCRIPTION_STATUS=0 THEN 'Inactive' ELSE 'Confirmed' END AS STATUS, to_char(activation_date,'YYYY-MM-DD') as ACTIVATION_DATE, to_char(subscription_date,'YYYY-MM-DD') as CREATION_DATE,(CASE WHEN SETTLEMENT_OPTION=2 then 'Bank Settlement' ELSE 'M-PESA Settlment' END) as SETTLEMENT_OPTION from MERCHANT_SETTLEMENT_SUBSCRPTNS S LEFT JOIN MERCHANT_SETTLEMENT_LOCATIONS loc ON loc.ID = S.BUSINESS_LOCATION LEFT JOIN MERCHANT_SETTLEMENT_BIZTYPE bz ON bz.ID = S.BUSINESS_TYPE WHERE S.INTRASH = 'NO' AND HO_ID= '" . $_GET[key] . "' ORDER BY SUBSCRIPTION_DATE DESC";
                $queryMep1 = "SELECT ID,ACC,(SELECT NAME FROM NIC_CHANNEL B WHERE B.CHANNEL_ID=A.CHANNEL_ID)CHANNEL FROM NIC_DISBURSEMENT_ACC A WHERE CUSTOMER_ID='" . $_GET[key] . "' AND INTRASH='NO'";

                //echo $queryMep;
                $rsp1 = execQuery($queryMep1);


                echo "<table style='margin: 2px' id='report' class='table table-striped table-bordered table-hover dataTable no-footer'>
                    <tr class='gridColumns gradientSilver'>
                        <th>ACCOUNT NUMBER</th>
                        <th>CHANNEL</th>
                        <th></th>
                        <th></th>
                    </tr>";

                foreach ($rsp1 as $rowp1) {
                    $id_accs_edit = $rowp1["ID"] . "|" . "accs" . "|" . $_GET[key];
                    $id_accs_delete = $rowp1["ID"] . "|" . 'NIC_DISBURSEMENT_ACC' . "|" . 'ID';
                    $celp1 .= "<form hidden><!--Dummy tu.Solves form on the edit button --></form> <tr class='noteven'>";
                    $celp1 .= "<td>" . $rowp1["ACC"] . "</td>";
                    $celp1 .= "<td>" . $rowp1["CHANNEL"] . "</td>";
                    $celp1 .= "<td><button id='$id_accs_edit' type='button' name='editacc' value='Edit Acc' class='btn-primary btn-sm btn-success gridEditCustomerdetails'>Edit</button></td>";
                    $celp1 .= "<td><div>
                                      <button name='deleter' id='$id_accs_delete' value='Delete' class='btn-primary btn-sm btn-danger gridCustomDelete'>Delete</button>
                                      </div></td>";
                    $celp1 .= "</tr>";
                }
                echo "$celp1</table></br>";
                ?>
            </div>

            <div id="activities<?php echo $_GET[key]; ?>" class="tab-pane fade text-muted" style="background: #ECF0F5">
                <?php
                //$queryMe = "Select MERCHANT_MSISDN, STORE_NUMBER, STORE_NAME, loc.TITLE as LOCATION, bz.TITLE as BZ_TYPE,CASE WHEN CONFIRMED = 'NO' THEN 'Awaiting Confirmation' WHEN CONFIRMED = 'REJ' THEN 'Rejected'  WHEN SUBSCRIPTION_STATUS=0 THEN 'Inactive' ELSE 'Confirmed' END AS STATUS, to_char(activation_date,'YYYY-MM-DD') as ACTIVATION_DATE, to_char(subscription_date,'YYYY-MM-DD') as CREATION_DATE,(CASE WHEN SETTLEMENT_OPTION=2 then 'Bank Settlement' ELSE 'M-PESA Settlment' END) as SETTLEMENT_OPTION from MERCHANT_SETTLEMENT_SUBSCRPTNS S LEFT JOIN MERCHANT_SETTLEMENT_LOCATIONS loc ON loc.ID = S.BUSINESS_LOCATION LEFT JOIN MERCHANT_SETTLEMENT_BIZTYPE bz ON bz.ID = S.BUSINESS_TYPE WHERE S.INTRASH = 'NO' AND HO_ID= '" . $_GET[key] . "' ORDER BY SUBSCRIPTION_DATE DESC";
                $queryMe = ' SELECT LOAN_ID,
                          LOAN_NUMBER,  T24_LOAN_NUMBER,  CUSTOMER_ID_FK,
                          PRODUCT_ID_FK,  AMOUNT,  PERIOD,  INTEREST,  LOAN_STATUS,
                          APPROVAL_STATUS,  PARENT_ID,  PROCESSING_STATUS,  TYPE,  TIME_INITIATED,  TIME_APPROVED
                        FROM NIC_LOAN  WHERE CUSTOMER_ID_FK= ' . $_GET[key] . '     ORDER BY LOAN_ID DESC';

                $rs = execQuery($queryMe);

                echo "<table id='report' class='table table-striped table-bordered table-hover dataTable no-footer'>
                    <tr class='gridColumns gradientSilver'>
                        <th>LOAN_NUMBER</th>
                        <th>AMOUNT</th>
                        <th>PERIOD</th>
                        <th>INTEREST</th>
                        <th>LOAN_STATUS</th>
                     </tr>";
                foreach ($rs as $row) {
                    $cel .= "<tr class='noteven'>";
                    $cel .= "<td>" . $row[LOAN_NUMBER] . "</td>";
                    $cel .= "<td>" . $row[AMOUNT] . "</td>";
                    $cel .= "<td>" . $row["PERIOD"] . "</td>";
                    $cel .= "<td>" . $row[INTEREST] . "</td>";
                    $cel .= "<td>" . $row["LOAN_STATUS"] . "</td>";
                    $cel .= "</tr>";
                }
                echo "$cel</table></br>";
                ?>


            </div>
            <div id="contributions<?php echo $_GET[key]; ?>" class="tab-pane fade text-muted" style="background: #ECF0F5">
                <?php
                //$queryMe = "Select MERCHANT_MSISDN, STORE_NUMBER, STORE_NAME, loc.TITLE as LOCATION, bz.TITLE as BZ_TYPE,CASE WHEN CONFIRMED = 'NO' THEN 'Awaiting Confirmation' WHEN CONFIRMED = 'REJ' THEN 'Rejected'  WHEN SUBSCRIPTION_STATUS=0 THEN 'Inactive' ELSE 'Confirmed' END AS STATUS, to_char(activation_date,'YYYY-MM-DD') as ACTIVATION_DATE, to_char(subscription_date,'YYYY-MM-DD') as CREATION_DATE,(CASE WHEN SETTLEMENT_OPTION=2 then 'Bank Settlement' ELSE 'M-PESA Settlment' END) as SETTLEMENT_OPTION from MERCHANT_SETTLEMENT_SUBSCRPTNS S LEFT JOIN MERCHANT_SETTLEMENT_LOCATIONS loc ON loc.ID = S.BUSINESS_LOCATION LEFT JOIN MERCHANT_SETTLEMENT_BIZTYPE bz ON bz.ID = S.BUSINESS_TYPE WHERE S.INTRASH = 'NO' AND HO_ID= '" . $_GET[key] . "' ORDER BY SUBSCRIPTION_DATE DESC";
                $queryservice = 'SELECT (NIC_LOAN.LOAN_ID || \'-AMT\'|| NIC_LOAN.AMOUNT)AS "LOAN"
                     ,NIC_LOAN.AMOUNT AS "PRINCIPAL AMT",(A.AMOUNT)AS "TRX AMT",
                     NVL(NIC_LOAN.LOAN_BALANCE,0)AS "LOAN BALANCE", NIC_CHANNEL.NAME,
                     A.TIME_INITIATED,A.TIME_COMPLETED,A.DESCRIPTION  FROM NIC_LOAN_PAYMENTS A
                                  INNER JOIN NIC_LOAN ON A.LOAN_ID_FK=NIC_LOAN.LOAN_ID
                                  INNER JOIN NIC_CHANNEL ON NIC_CHANNEL.CHANNEL_ID=A.CHANNEL_ID_FK
                                              WHERE
                                                   NIC_LOAN.CUSTOMER_ID_FK= ' . $_GET[key] . '
                                              ORDER BY LOAN_PAYMENT_ID DESC';

                $rs_repayment = execQuery($queryservice);

                echo "<table id='report1' class='table table-striped table-bordered table-hover dataTable no-footer'>
                    <tr class='gridColumns gradientSilver'>
                        <th>LOAN</th>
                        <th>PRINCIPAL AMT</th>
                        <th>TRX AMT</th>
                        <th>LOAN BALANCE</th>
                        <th>NAME</th>
                        <th>DESCRIPTION</th>
                    </tr>";
                foreach ($rs_repayment as $row) {
                    $cell .= "<tr class='noteven'>";
                    $cell .= "<td>" . $row["LOAN"] . "</td>";
                    $cell .= "<td>" . $row["PRINCIPAL AMT"] . "</td>";
                    $cell .= "<td>" . $row["TRX AMT"] . "</td>";
                    $cell .= "<td>" . $row["LOAN BALANCE"] . "</td>";
                    $cell .= "<td>" . $row[NAME] . "</td>";
                    $cell .= "<td>" . $row["DESCRIPTION"] . "</td>";
                    $cell .= "</tr>";
                }
                echo "$cell</table></br>";
                $_SESSION[selectedorg_s] = $key;
                ?>
            </div>


        </div>
    </div>

</div>

