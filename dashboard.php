    
    <link rel="stylesheet" href="frontend-template/plugins/jvectormap/jquery-jvectormap-1.2.2.css"> 
    <script src="frontend-template/plugins/sparkline/jquery.sparkline.min.js"></script>   
    <script src="frontend-template/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="frontend-template/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> 
    <script src="frontend-template/plugins/chartjs/Chart.min.js"></script>
    <script src="frontend-template/dist/js/pages/disbreceipts.js"></script>
   <?php
ini_set('display_errors', 1);
include("Shared/php/functions.php");
AuthenticateSession();
?>
       <script>
      
      
    $(document).ready(function() {

              $.ajax({
                type: 'POST',
                // dataType: "json",
                url: 'Shared/php/process_form.php?f=CHART_AJAX', // + formname,
                success: function(result) {

                    if (result || (typeof (result) !== 'undefined'))
                        chartValues = result;
                },
                complete: function() {
                   console.log("ChartValues"+chartValues);
		   $("#chartdata").val(chartValues);
	
		   
                }
            });
        
    });
      </script>

       <?php




/*
$reportdata =execQuery("select  
(select count(*) from nic_loan where loan_status ='PROCESSED')Active_Loans,
nvl((select sum(AMOUNT) from nic_loan where loan_status ='PROCESSED'),0)Active_Amount, 
(select count(*) from nic_loan where trunc(TIME_INITIATED) = trunc(sysdate))Today_Loans,
nvl((select sum(AMOUNT) from nic_loan where trunc(TIME_INITIATED) = trunc(sysdate)),0)Today_Borrowed, 
(select count(*) from NIC_LOAN_PAYMENTS where trunc(TIME_INITIATED) = trunc(sysdate))Today_Payments,
nvl((select sum(AMOUNT) from NIC_LOAN_PAYMENTS where trunc(TIME_INITIATED) = trunc(sysdate)),0)Today_Paid, 
(select count(*)  from nic_loan where loan_status ='FULLY_PAID')Closed_Loans,
nvl((select sum(amount) from nic_loan where loan_status ='FULLY_PAID'),0)Closed_Amount,  
nvl((select sum(INTEREST_REPAID) from nic_loan where loan_status ='FULLY_PAID'),0)Closed_Interest,
(select count(*)  from NIC_LOAN_SCHEDULE where trunc(DUE_DATE) = trunc(sysdate))Due_Toay,
nvl((select sum(INSTALLMENT_AMOUNT)  from NIC_LOAN_SCHEDULE where trunc(DUE_DATE) = trunc(sysdate)),0)Due_Amount,
(select count(*)  from nic_loan where loan_status ='DEFAULTED')Deafulted_Loans,
nvl((select sum(BALANCE)  from NIC_LOAN_SCHEDULE where DUE_DATE < sysdate),0)Defaulted_Amount,
(select count(*)  from nic_loan where loan_status ='BLACKLISTED')Blacklisted_Loans,
nvl((select sum(amount)-sum(PRINCIPAL_REPAID)  from nic_loan where loan_status ='BLACKLISTED'),0)Blacklisted_Amount, 
(select count(*)  from nic_loan where loan_status ='REPORTED_CRB')Reported_Loans,
nvl((select sum(amount)-sum(PRINCIPAL_REPAID)  from nic_loan where loan_status ='BLACKLISTED'),0)Reported_Amount,
nvl((select sum(actual_bal) from nic_sasa_accounts where account_id in (select loan_acc_fk from nic_product)),0)Loans_account,  
nvl((select sum(actual_bal) from nic_sasa_accounts where account_id in (select penalty_acc_fk from nic_product)),0)Penalty_account,  
nvl((select sum(actual_bal) from nic_sasa_accounts where account_id in (select interest_acc_fk from nic_product)),0)Interest_Account,
nvl((select sum(charge) from nic_product_charges ),0)Charges_account
from dual"); 
//print_r($reportdata);

*/
// $currency = execQuery("SELECT VALUE FROM NIC_PARAM WHERE PARAMETER='DEFAULT_CURRENCY' ",true);

?>
        <section class="content" id="dashboardContent">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-12">
               
            </div>  
           </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Search Tools</h3>

                        </div>
                    </div>
                </div>
            </div>
 
        <div class="row">
       <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Membership</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-sm btn-info" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   </div>
                </div><!-- /.box-header -->
                <div class="box-body" style="display: block;">
       
       
       
       
       
       
       
       
       
       

       
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-lime">
                <div class="inner activeL">
                  <p>All Active Members</p>
                  <h2>173</h2>
                </div>
                <div class="icon">
                  <i class="ion ion-grid"></i>
                </div>
                <a href="142" class="small-box-footer loadDashboardLink">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-teal">
                <div class="inner">
                  
                  <p>New Members (less than 1 year)</p>
                  <h2>70</h2>


                </div>
                <div class="icon">
                  <i class="ion ion-cash"></i>
                </div>
                <a href="142" class="small-box-footer loadDashboardLink">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->

           <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-maroon">
                <div class="inner">
                  <p>Visitors (Last One Year)</p>
                  <h2>320</h2>
                </div>
                <div class="icon">
                  <i class="ion ion-ios-pricetags"></i>
                </div>
                <a href="144" class="small-box-footer loadDashboardLink">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->


            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-orange">
                <div class="inner">
                   <p>Inactive Members</p>
                  <h2> 50</h2>
                 
                </div>
                <div class="icon">
                  <i class="ion ion-cash"></i>
                </div>
                <a href="143" class="small-box-footer loadDashboardLink">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->

            </div>
            </div>
              </div>
          </div><!-- /.row -->
            


   

    
    
    
    
          
        
 <!--  <div class = "row">       
         
         <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">NIC Goal Completion</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-sm btn-info" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <button class="btn btn-sm btn-info" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body" style="display: block;">
                      <div class="progress-group">
                        <span class="progress-text">Customers Registered</span>
                        <span class="progress-number"><b>160</b>/200</span>
                        <div class="progress sm">
                          <div class="progress-bar progress-bar-aqua" style="width: 80%"></div>
                        </div>
                      </div>
                      <div class="progress-group">
                        <span class="progress-text">Loans Borrowed</span>
                        <span class="progress-number"><b>310</b>/400</span>
                        <div class="progress sm">
                          <div class="progress-bar progress-bar-red" style="width: 80%"></div>
                        </div>
                      </div>
                      <div class="progress-group">
                        <span class="progress-text">Repayments</span>
                        <span class="progress-number"><b>480</b>/800</span>
                        <div class="progress sm">
                          <div class="progress-bar progress-bar-green" style="width: 80%"></div>
                        </div>
                      </div>
                      <div class="progress-group">
                        <span class="progress-text">Organisations Enrolled</span>
                        <span class="progress-number"><b>250</b>/500</span>
                        <div class="progress sm">
                          <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
                        </div>
                      </div>
                       <div class="progress-group">
                        <span class="progress-text">Programs Added</span>
                        <span class="progress-number"><b>250</b>/500</span>
                        <div class="progress sm">
                          <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
                        </div>
                      </div>
                    </div>
                
               
                <div class="box-footer" style="display: block;">
                
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                        <h2 class="description-header">$35,210.43</h2>
                        <span class="description-text">TOTAL REVENUE</span>
                      </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                        <h2 class="description-header">$10,390.90</h2>
                        <span class="description-text">TOTAL COST</span>
                      </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                        <h2 class="description-header">$24,813.53</h2>
                        <span class="description-text">TOTAL PROFIT</span>
                      </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block">
                        <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                        <h2 class="description-header">1200</h2>
                        <span class="description-text">GOAL COMPLETIONS</span>
                      </div>
                    </div>
                    
                    </div>
                    </div>
                    </row> -->
                    
                    
          

        </section><!-- /.content -->
      <!-- /.content-wrapper -->
      <input type="hidden" id="chartdata" name="chartdata" value="" />
   