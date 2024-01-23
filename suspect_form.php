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
    $arr=array(
                "suspect_id","first_name","last_name","address","image_url","next_of_kin_name", "trial_date", "accusation_date", "health_issues", "date_of_arrest", 
                "next_of_kin_address", "occupation", "next_of_kin_occupation", "date_of_birth", "phone_number", "marital_status", "age", "bank_account_name", "bank_account_number",
                "nationality", "gender", "nin", "state_id", "lga_id"
            );
    $clause['suspect_id']=$_id;
    $result = $dbobject->doSelect('suspects',$arr,$clause);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC); 

    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $address = $row['address'];
    // $image_url = $row['image_url'];
    $next_of_kin_name = $row['next_of_kin_name'];
    $trial_date = $row['trial_date'];
    $accusation_date = $row['accusation_date'];
    $health_issues = $row['health_issues'];
    $date_of_arrest = $row['date_of_arrest'];
    $next_of_kin_address = $row['next_of_kin_address'];
    $occupation = $row['occupation'];
    $next_of_kin_occupation = $row['next_of_kin_occupation'];
    $date_of_birth = $row['date_of_birth'];
    $phone_number = $row['phone_number'];
    $marital_status = $row['marital_status'];
    $age = $row['age'];
    $bank_account_name = $row['bank_account_name'];
    $bank_account_number = $row['bank_account_number'];
    $nationality = $row['nationality'];
    $gender = $row['gender'];
    $nin = $row['nin'];
    $state_id = $row['state_id'];
    $lga_id = $row['lga_id'];
     
}

    $states = $dbobject->gettableselect('states', 'id', 'name', $state_id);
    $lgas = $dbobject->gettableselect('local_governments', 'lga_id', 'name', $lga_id);
    $max_date = date("Y-m-d",strtotime('-12 years'));
 
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
                                            <h4><?php if ($status == '0') echo "New";  else echo "Edit"; ?> Suspect</h4>
                                        </div>                 
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <form id="form1" class="simple-example" action="javascript:void(0);" method="post" enctype="multipart/form-data" novalidate>

                                    <input type="hidden" id="_id" name="_id" value="<?php echo $_id; ?>" >
                                    <input type="hidden" id="status" name="status" value="<?php echo $status; ?>" >
                                    <input type="hidden" name="inputfile" id="filename">
                                    <div class="form-row">
                                        <div class="custom-file mb-4">
                                            <input type="file" class="custom-file-input" name="image" id="file_upload" accept=".jpg, .png, .jpeg">
                                            <label class="custom-file-label" for="customFile">Upload Image</label>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <label for="fname">First Name</label>
                                                <input type="text" class="form-control" id="fname" name="fname" placeholder="" value="<?php echo $first_name; ?>" required>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label for="lname">Last Name</label>
                                                <input type="text" class="form-control" id="lname" name="lname" placeholder="" value="<?php echo $last_name; ?>" required>
                                            </div>
                                    </div>
                                    <div class="form-row">
                                            <div class="col-md-6 mb-4"> 
                                                <label for="mstatus">Marital Status</label>
                                                <select name="mstatus" id="mstatus" class="custom-select" required>
                                                    <option value="#">::: please select option ::: </option>
                                                    <option value="Single" <?php if ($marital_status == 'Single') {echo "selected='selelcted'";} else {echo "";} ?>>Single</option>
                                                    <option value="Married" <?php if ($marital_status == 'Married') {echo "selected='selelcted'";} else {echo "";} ?>>Married</option>
                                                    <option value="Divorced" <?php if ($marital_status == 'Divorced') {echo "selected='selelcted'";} else {echo "";} ?>>Divorced</option>
                                                    <option value="Widowed" <?php if ($marital_status == 'Widowed') {echo "selected='selelcted'";} else {echo "";} ?>>Widowed</option>
                                                </select>
                                            </div>
                                        <div class="col-md-6 mb-4">
                                            <label for="nin">NIN</label>
                                            <input type="text" class="form-control" name="nin" id="nin" value=<?php echo $nin ?>>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12 mb-4">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" class="form-control" name="dob" id="dob" value="<?php echo $date_of_birth ?>" max="<?php echo $max_date?>">
                                        </div>
                                    </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <label for="phone">Phone Number</label>
                                                <input type="text" class="form-control" id="phone" name="phone" placeholder="" value="<?php echo $phone_number; ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control" id="address" name="address" placeholder="" value="<?php echo $address; ?>" required>
                                            </div>

                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <label for="occupation">Occupation</label>
                                                <input type="text" class="form-control" id="occupation" name="occupation" placeholder="" value="<?php echo $occupation; ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label for="gender">Gender</label>
                                                <select name="gender" id="gender" class="custom-select" required>
                                                    <option value="#">::: please select option ::: </option>
                                                    <option value="Male" <?php if ($gender == 'Male') {echo "selected='selelcted'";} else {echo "";} ?>>Male</option>
                                                    <option value="Female" <?php if ($gender == 'Female') {echo "selected='selelcted'";} else {echo "";} ?>>Female</option>
                                                    <option value="Other" <?php if ($gender == 'Other') {echo "selected='selelcted'";} else {echo "";} ?>>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-4">
                                                <label for="acctname">Bank Account Name</label>
                                                <input type="text" class="form-control" name="acctname" id="acctname" value=<?php echo $bank_account_name ?>>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-4">
                                                <label for="acctnumber">Bank Account Number</label>
                                                <input type="number" class="form-control" name="acctnumber" id="acctnumber" value=<?php echo $bank_account_number ?>>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <label for="nextofkin">Name of Next Of Kin</label>
                                                <input type="text" class="form-control" id="nextofkin" name="nextofkin" placeholder="" value="<?php echo $next_of_kin_name; ?>" required>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label for="nextofkinocc">Occupation of Next of Kin</label>
                                                <input type="text" class="form-control" id="nextofkinocc" name="nextofkinocc" placeholder="" value="<?php echo $next_of_kin_occupation; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-4">
                                                <label for="nextofkinadd">Address of Next Of Kin</label>
                                                <input type="text" class="form-control" id="nextofkinadd" name="nextofkinadd" placeholder="" value="<?php echo $next_of_kin_address; ?>" required>
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
                                        <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <label for="accdate">Accusation Date</label>
                                                <input type="date" name="accdate" class="form-control" id="accdate" max="<?php echo date('Y-m-d') ?>" value=<?php echo $accusation_date?>>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                            <label for="trialdate">Trial Date</label>
                                                <input type="date" name="trialdate" class="form-control" id="trialdate" value=<?php echo $trial_date ?>>
                                            </div>
                                        </div>

                                        <div class="form-row mb-3">
                                            <div class="col-md-12">
                                                <label for="issues">Health Issues</label>
                                                <textarea name="issues" id="issues" class="form-control" cols="30" rows="10" style="resize: none;"><?php echo $health_issues ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                        <div class="col-md-4">
                                            <input class="btn btn-primary submit-fn mt-2 mr-2" type="button" id="subbtn" name="subbtn" value="Submit" onclick="sendForm()"> 
                                            <button class="btn btn-danger submit-fn mt-2" type="submit" onclick="loadpage('suspects_list.php','page')">Cancel</button>
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

        function sendForm() {
                if($.trim($('#fname').val())==''){
                    $('#display_message').html('<div class=\' alert alert-danger \'>First Name field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#lname').val())==''){
                    $('#display_message').html('<div class=\' alert alert-danger \'>Last Name field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#nin').val())=='#'){
                    $('#display_message').html('<div class=\' alert alert-danger \'>NIN field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#state').val())=='#'){
                    $('#display_message').html('<div class=\' alert alert-danger \'>State field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#lga').val())=='#'){
                    $('#display_message').html('<div class=\' alert alert-danger \'>LGA field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#accdate').val())==''){
                    $('#display_message').html('<div class=\' alert alert-danger \'>Accusation Date field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#nextofkin').val())==''){
                    $('#display_message').html('<div class=\' alert alert-danger \'>Name of Next of Kin field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#nextofkinocc').val())==''){
                    $('#display_message').html('<div class=\' alert alert-danger \'>Occupation of Next of Kin field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#nextofkinadd').val())==''){
                    $('#display_message').html('<div class=\' alert alert-danger \'>Address of Next of Kin field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#acctname').val())==''){
                    $('#display_message').html('<div class=\' alert alert-danger \'>Bank Account Name field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#acctnumber').val())==''){
                    $('#display_message').html('<div class=\' alert alert-danger \'>Bank Account Number field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#dob').val())==''){
                    $('#display_message').html('<div class=\' alert alert-danger \'>Date of Birth field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#phone').val())==''){
                    $('#display_message').html('<div class=\' alert alert-danger \'>Phone Number field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#address').val())==''){
                    $('#display_message').html('<div class=\' alert alert-danger \'>Address field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#occupation').val())==''){
                    $('#display_message').html('<div class=\' alert alert-danger \'>Occupation field is empty</div>');
                    $('#display_message').show();
                }else if(jQuery.trim($('#mstatus').val())=='#'){
                    $('#display_message').html('<div class=\' alert alert-danger \'>Marital Status field is empty</div>');
                    $('#display_message').show();
                }else{
                    var data = new FormData();
                    data.append('op', 'upload_image');
                    data.append('dir', 'suspects');
                    var files = document.getElementById('file_upload').files;
                    // console.log(files[0]);
                    data.append('file', files[0]);
                    $.ajax({
                        type: 'POST',
                        url: 'utilities.php',
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(msg) {
                            // console.log(msg);
                            $('#filename').val(msg);
                            return callpage('suspectnew');
                        }
                    });
                }; 
                return false;
            }
    </script>
