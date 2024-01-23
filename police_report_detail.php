<?php
session_start();

define('AJAX_REQUEST', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if (!AJAX_REQUEST) {
    include 'logout.php';
    die();
}
 
include "lib/dbfunctions.php";
$dbobject = new dbobject();
$username = $_SESSION['sss_username_sess'];

$query = "SELECT * FROM report WHERE report_id=" . $_GET['_id'];

$result = $dbobject->db_query($query)[0];

// var_dump($result);

?>


  
        <!--  BEGIN CONTENT AREA  -->
        <div class="container">
 
 <div class="row layout-top-spacing">

     <div id="basic" class="col-lg-12 layout-spacing">
         <div class="statbox widget box box-shadow">
             <div class="widget-header">
                 <div class="row">
                    <div class="col-auto py-3">
                        <a href="javascript:void(0)" class="text-primary" onclick="loadpage('police_reports_list.php', 'page')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                        <line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline>
                        </svg><span class="icon-name">Go Back</span>
                        </a>
                    </div>
                     <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                         <h4 class="h2">Report #<?php echo $result["report_id"]; ?></h4>
                     </div>                 
                 </div>
             </div>
             <div class="widget-content widget-content-area">
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Officer: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $dbobject->getItemLabel('police_officer','police_id',$result["officer_id"],'name'); ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Type: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["report_type"] ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Status: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["status"] ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">LGA: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $dbobject->getItemLabel('local_governments','lga_id',$result["lga_id"],'name'); ?></p></div>
                    </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">State: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $dbobject->getItemLabel('states','id',$result["state_id"],'name'); ?></p></div>
                    </div>
                <div class="row">
                    <div class="col-sm-6 text-right"><p class="font-weight-bold">Created: </p></div>
                    <div class="col-sm-6 text-left"><p><?php echo $result["created"] ?></p></div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center mt-3"><p class="font-weight-bold">Message: </p></div>
                    <div class="col-sm-12 text-center"><p><?php echo $result["statement_message"] ?></p></div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-primary submit-fn mt-2 mr-2" type="submit" onclick="loadpage('police_report_form.php?op=edit&_id=<?php echo $result['report_id']?>','page')">Edit</button>
                        <button class="btn btn-danger submit-fn mt-2 mr-2" type="submit" onclick="loadpage('police_reports_list.php','page')">Cancel</button>
                    </div>
                </div>
             </div>
         </div>
     </div>


 </div>

 </div>



</div>
<!--  END CONTENT AREA  -->


<!--  BEGIN CUSTOM SCRIPTS FILE  -->
<script src="assets/js/scrollspyNav.js"></script>
<script src="assets/js/forms/bootstrap_validation/bs_validation_script.js"></script>
