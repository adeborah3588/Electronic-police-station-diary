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
    $arr=array("report_id","report_type","statement_message","officer_id","status","state_id", "lga_id");
    $clause['report_id']=$_id;
    $result = $dbobject->doSelect('report',$arr,$clause);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC); 

    $officer_id = $row['officer_id'];
    $report_type = $row['report_type'];
    $report_status = $row['status'];
    $message = $row['statement_message'];
    $state_id = $row['state_id'];
    $lga_id = $row['lga_id'];
     
}

    $officers = $dbobject->gettableselect('police_officer', 'police_id', 'name', $officer_id);
    $states = $dbobject->gettableselect('states', 'id', 'name', $state_id);
    $lgas = $dbobject->gettableselect('local_governments', 'lga_id', 'name', $lga_id);
 
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
                                            <h4><?php if ($status == '0') echo "New";  else echo "Edit"; ?> Report</h4>
                                        </div>                 
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <form id="form1" class="simple-example" action="javascript:void(0);" novalidate>

                                    <input type="hidden" id="_id" name="_id" value="<?php echo $_id; ?>" >
                                    <input type="hidden" id="status" name="status" value="<?php echo $status; ?>" >
                                    <div class="form-row">
                                            <div class="col-md-12 mb-4">
                                                <div id="select_menu" class="form-group mb-4">
                                                    <label for="officer">Officer</label>
                                                    <select id="officer" name="officer" class="custom-select" required>
                                                      <?php echo $officers; ?>
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <label for="type">Report Type</label>
                                                <input type="text" class="form-control" id="type" name="type" placeholder="" value="<?php echo $report_type; ?>" required>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label for="report_status">Status</label>
                                                <input type="text" class="form-control" id="report_status" name="report_status" placeholder="" value="<?php echo $report_status; ?>" required>
                                            </div>

                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <div id="select_menu" class="form-group mb-4">
                                                    <label for="state">State</label>
                                                    <select id="state" name="state" class="custom-select" required>
                                                      <?php echo $states; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <div id="select_menu" class="form-group mb-4">
                                                    <label for="lga">LGA</label>
                                                    <select id="lga" name="lga" class="custom-select" required>
                                                      <?php echo $lgas; ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="col-md-12">
                                                <label for="message">Message</label>
                                                <textarea name="message" id="message" class="form-control" cols="30" rows="10" style="resize: none;"><?php echo $message ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                    <input class="btn btn-primary submit-fn mt-2" type="button" id="subbtn" name="subbtn" value="Submit" onclick="javascript:
                                                        if($.trim($('#type').val())==''){
                                                            $('#display_message').html('<div class=\' alert alert-danger \'>Report Type field is empty</div>');
                                                            $('#display_message').show();
                                                        }else if(jQuery.trim($('#report_status').val())==''){
                                                            $('#display_message').html('<div class=\' alert alert-danger \'>Report Status field is empty</div>');
                                                            $('#display_message').show();
                                                        }else if(jQuery.trim($('#officer').val())=='#'){
                                                            $('#display_message').html('<div class=\' alert alert-danger \'>Officer field is empty</div>');
                                                            $('#display_message').show();
                                                        }else if(jQuery.trim($('#state').val())=='#'){
                                                            $('#display_message').html('<div class=\' alert alert-danger \'>State field is empty</div>');
                                                            $('#display_message').show();
                                                        }else if(jQuery.trim($('#lga').val())=='#'){
                                                            $('#display_message').html('<div class=\' alert alert-danger \'>LGA field is empty</div>');
                                                            $('#display_message').show();
                                                        }else if(jQuery.trim($('#message').val())==''){
                                                            $('#display_message').html('<div class=\' alert alert-danger \'>Message field is empty</div>');
                                                            $('#display_message').show();
                                                        }else{
                                                            return callpage('reportnew');}; return false;"
                                                        > 
                                                        
                                                        
                                                        
                                                        <button class="btn btn-danger submit-fn mt-2" type="submit" onclick="loadpage('police_reports_list.php','page')">Cancel</button>

                                                </div>

                                                <div class="col-md-8">
                                                    <div id="display_message" style="width:100%; display:none;"></div>
                                                </div>
                                            </div>
                                            
                                            
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
    <script>
        $(function() {
            $('#state').change(function() {
                // console.log(event.target.value);
                $.ajax({
                    type: "POST",
                    url: 'utilities.php',
                    data: "op=get_lgas&state=" + event.target.value,
                    success: function (data) {
                        $('#lga').html(data);
                    }
                });
            });
        });
    </script>
