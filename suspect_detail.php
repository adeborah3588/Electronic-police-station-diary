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

$query = "SELECT * FROM suspects WHERE suspect_id=" . $_GET['_id'];

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
                        <a href="javascript:void(0)" class="text-primary" onclick="loadpage('suspects_list.php', 'page')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                        <line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline>
                        </svg><span class="icon-name">Go Back</span>
                        </a>
                    </div>
                     <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                     <?php if (!is_null($result['image_url'])) : ?>
                            <img src="<?php echo $result['image_url']?>"  alt="Image not found" onerror="this.src='images/placeholder-image.png'" style="max-height: 150px; max-width: 150px">
                        <?php else : ?>
                            <img src="images/placeholder-image.png" alt="Image not found" style="max-height: 150px; max-width: 150px">
                        <?php endif ; ?>
                         <h4 class="h2">Suspect #<?php echo $result["suspect_id"]; ?></h4>
                     </div>                 
                 </div>
             </div>
             <div class="widget-content widget-content-area">
                <h6 class="font-weight-bold text-center">Personal Information</h6>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Name: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result['first_name'] . " " . $result['last_name'] ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Date Of Birth: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo date("jS F Y", strtotime($result["date_of_birth"])) ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Age: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["age"] . "yrs" ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Gender: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["gender"] ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Marital Status: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["marital_status"] ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Occupation: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["occupation"] ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">NIN: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["nin"] ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Address: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["address"] ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Phone Number: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["phone_number"] ?></p></div>
                 </div>
                 <div class="row">
                    <div class="col-sm-6 text-right"><p class="font-weight-bold">LGA: </p></div>
                    <div class="col-sm-6 text-left"><p><?php echo $dbobject->getItemLabel('local_governments','lga_id',$result["lga_id"],'name'); ?></p></div>
                </div>
                 <div class="row">
                    <div class="col-sm-6 text-right"><p class="font-weight-bold">State Of Origin: </p></div>
                    <div class="col-sm-6 text-left"><p><?php echo $dbobject->getItemLabel('states','id',$result["state_id"],'name'); ?></p></div>
                </div>
                 <h6 class="font-weight-bold mt-3 text-center">Bank Account Details</h6>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Account Name: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["bank_account_name"] ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Account Number: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["bank_account_number"] ?></p></div>
                 </div>
                 <h6 class="font-weight-bold mt-3 text-center">Next Of Kin</h6>
                <div class="row">
                    <div class="col-sm-6 text-right"><p class="font-weight-bold">Name:</p></div>
                    <div class="col-sm-6 text-left"><p><?php echo $result["next_of_kin_name"] ?></p></div>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-right"><p class="font-weight-bold">Address:</p></div>
                    <div class="col-sm-6 text-left"><p><?php if ($result["next_of_kin_address"] != "") echo $result["next_of_kin_address"];  else echo "Not Specified"; ?></p></div>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-right"><p class="font-weight-bold">Occupation:</p></div>
                    <div class="col-sm-6 text-left"><p><?php echo $result["next_of_kin_occupation"] ?></p></div>
                </div>
                <h6 class="font-weight-bold mt-3 text-center">Criminal Record</h6>
                <div class="row">
                    <div class="col-sm-6 text-right"><p class="font-weight-bold">Accusation Date:</p></div>
                    <div class="col-sm-6 text-left"><p><?php echo date("jS F Y (g:ia)", strtotime($result['accusation_date'])) ?></p></div>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-right"><p class="font-weight-bold">Trial Date:</p></div>
                    <div class="col-sm-6 text-left"><p><?php echo date("jS F Y (g:ia)", strtotime($result['trial_date'])) ?></p></div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                    <button class="btn btn-primary submit-fn mt-2 mr-2" type="submit" onclick="loadpage('suspect_form.php?op=edit&_id=<?php echo $result['suspect_id']?>','page')">Edit</button>
                    <button class="btn btn-danger submit-fn mt-2 mr-2" type="submit" onclick="loadpage('suspects_list.php','page')">Cancel</button>
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
