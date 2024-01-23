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

$query = "SELECT * FROM inventory WHERE Inv_id=" . $_GET['_id'];

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
                        <a href="javascript:void(0)" class="text-primary" onclick="loadpage('inventory_list.php', 'page')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                        <line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline>
                        </svg><span class="icon-name">Go Back</span>
                        </a>
                    </div>
                     <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                        <?php if (!is_null($result['images_url'])) : ?>
                            <img src="<?php echo $result['images_url']?>"  alt="Image not found" onerror="this.src='images/placeholder-image.png'" style="max-height: 150px; max-width: 150px">
                        <?php else : ?>
                            <img src="images/placeholder-image.png" alt="Image not found" style="max-height: 150px; max-width: 150px">
                        <?php endif ; ?>
                         <h4 class="h2">Item #<?php echo $result["Inv_id"]; ?></h4>
                     </div>                 
                 </div>
             </div>
             <div class="widget-content widget-content-area">
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Item Name: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["item_name"] ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Serial Number: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["serial_number"] ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Quantity: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["quantity"] ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Date Of Collection: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo date("jS F Y", strtotime($result["date_of_collection"])) ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">Station: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $dbobject->getItemLabel('police_stations','station_id',$result["station_id"],'station_name'); ?></p></div>
                 </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">LGA: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["quantity"] ?></p></div>
                    </div>
                 <div class="row">
                     <div class="col-sm-6 text-right"><p class="font-weight-bold">State: </p></div>
                     <div class="col-sm-6 text-left"><p><?php echo $result["quantity"] ?></p></div>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-right"><p class="font-weight-bold">Created: </p></div>
                    <div class="col-sm-6 text-left"><p><?php echo date("jS F Y (g:ia)", strtotime($result['created'])) ?></p></div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-primary submit-fn mt-2 mr-2" type="submit" onclick="loadpage('inventory_form.php?op=edit&_id=<?php echo $result['Inv_id']?>','page')">Edit</button>
                        <button class="btn btn-danger submit-fn mt-2 mr-2" type="submit" onclick="loadpage('inventory_list.php','page')">Cancel</button>
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
