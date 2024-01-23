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
 
$parent_id = "";
$status="0";
if($_REQUEST['op']=='edit'){
    $status="2";
    $_id = $_REQUEST['_id'];
    //  echo " <<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>";
    $arr=array("duty_id","unit_id","location","time_from","time_to","date");
    $clause['duty_id']=$_id;
    $result = $dbobject->doSelect('police_duty',$arr,$clause);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC); 

    $unit_id = $row['unit_id'];
    $location = $row['location'];
    $time_from = $row['time_from'];
    $time_to = $row['time_to'];
    $date = $row['date'];
     
}

    $unit_itmes = $dbobject->gettableselect('unittb', 'unit_id', 'unit_name', $unit_id);
 
?>
        <!--  BEGIN CONTENT AREA  -->
      

        <div class="container">
                <div class="container">
 
            
                    <div class="row layout-top-spacing">

                        <div id="basic" class="col-lg-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>New Police Duty</h4>
                                        </div>                 
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <form id="form1" class="simple-example" action="javascript:void(0);" novalidate>

                                    <input type="hidden" id="_id" name="_id" value="<?php echo $_id; ?>" >
                                    <input type="hidden" id="status" name="status" value="<?php echo $status; ?>" >
                                        <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                            <div id="select_menu" class="form-group mb-4">
                                                <label for="unitid">Unit Name</label>
                                                    <select id="unitid" name="unitid" class="custom-select" required>
                                                      <?php echo $unit_itmes; ?>
                                                    </select>
                                                    <div class="valid-feedback">Example valid custom select feedback</div>
                                                    <div class="invalid-feedback">
                                                        Please Select the field
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label for="location">Location</label>
                                                <input type="text" class="form-control" id="location" name="location" placeholder="" value="<?php echo $location; ?>" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please fill the Email
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-row">
                                            
                                        <div class="col-md-6 mb-4">
                                                <label for="stime">Starting Time</label>
                                                <input type="time" class="form-control" id="stime" name="stime" placeholder="" value="<?php echo $time_from; ?>" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please fill the Email
                                                </div>
                                            </div>
  
                                            <div class="col-md-6 mb-4">
                                                <label for="ctime">Closing Time</label>
                                                <input type="time" class="form-control" id="ctime" name="ctime" placeholder="" value="<?php echo $time_to; ?>"  required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please fill the Email
                                                </div>
                                            </div>
  
 
                                        </div>

                                        <div class="form-row">
                                           
                                        <div class="col-md-6 mb-4">
                                                <label for="dutydate">Duty Date</label>
                                                <input type="date" class="form-control" id="dutydate" name="dutydate" placeholder="" value="<?php echo $date; ?>"  required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please fill the Email
                                                </div>
                                            </div>
                                        </div>


                                        <input class="btn btn-primary submit-fn mt-2" type="button" onclick="callpage('pdnew')" id="subbtn" name="subbtn" value="Submit"> 



                                        <button class="btn btn-danger submit-fn mt-2" type="submit" onclick="loadpage('police_duty_list.php','page')">Cancel</button>
                                   
                                   
                                    </form>
  

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
