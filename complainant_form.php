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
    $arr=array("complainant_id","name","Address","date_of_birth","age",  "email", "phone_number", "occupation", "next_of_kin", "next_of_kin_phone_number", "next_of_kin_email","next_of_kin_occupation","nin", "state_id", "lga_id", 'station_id');
    $clause['complainant_id']=$_id;
    $result = $dbobject->doSelect('complainants',$arr,$clause);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC); 

    $complainant_id = $row['complainant_id'];
    $station_id = $row['station_id'];
    $name = $row['name'];
    $email = $row['email'];
    $address = $row['Address'];
    // $image_url = $row['image_url'];
    $next_of_kin_name = $row['next_of_kin'];
    $next_of_kin_email = $row['next_of_kin_email'];
    $next_of_kin_phone_number = $row['next_of_kin_phone_number'];
    $occupation = $row['occupation'];
    $next_of_kin_occupation = $row['next_of_kin_occupation'];
    $date_of_birth = $row['date_of_birth'];
    $phone_number = $row['phone_number'];
    $age = $row['age'];
    $nin = $row['nin'];
    $state_id = $row['state_id'];
    $lga_id = $row['lga_id'];
    $station_id = $row['station_id'];
     
}

    $stations = $dbobject->gettableselect('police_stations', 'station_id', 'station_name', $station_id);
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
                                            <h4><?php if ($status == '0') echo "New";  else echo "Edit"; ?> Complainant</h4>
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
                                            <div class="col-md-12 mb-4">
                                            <div id="select_menu" class="form-group mb-4">
                                                <label for="station">Station Name</label>
                                                    <select id="station" name="station" class="custom-select" required>
                                                      <?php echo $stations; ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="" value="<?php echo $name; ?>" required>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control" id="address" name="address" placeholder="" value="<?php echo $address; ?>" required>
                                            </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12 mb-4">
                                            <label for="nin">NIN</label>
                                            <input type="text" class="form-control" name="nin" id="nin" value=<?php echo $nin ?>>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12 mb-4">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" class="form-control" name="dob" id="dob" value="<?php echo $date_of_birth ?>" max="<?php echo date('Y-m-d')?>">
                                        </div>
                                    </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <label for="phone">Phone Number</label>
                                                <input type="text" class="form-control" id="phone" name="phone" placeholder="" value="<?php echo $phone_number; ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" id="email" name="email" placeholder="" value="<?php echo $email; ?>" required>
                                            </div>

                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-4">
                                                <label for="occupation">Occupation</label>
                                                <input type="text" class="form-control" id="occupation" name="occupation" placeholder="" value="<?php echo $occupation; ?>" required>
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
                                            <div class="col-md-6 mb-4">
                                                <label for="nextofkinemail">Email of Next Of Kin</label>
                                                <input type="text" class="form-control" id="nextofkinemail" name="nextofkinemail" placeholder="" value="<?php echo $next_of_kin_email; ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label for="nextofkinphone">Phone Number of Next Of Kin</label>
                                                <input type="text" class="form-control" id="nextofkinphone" name="nextofkinphone" placeholder="" value="<?php echo $next_of_kin_phone_number; ?>" required>
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


                                        <div class="row">
                                            <div class="col-md-4">
                                            <input class="btn btn-primary submit-fn mt-2 mr-2" type="button" id="subbtn" name="subbtn" value="Submit" onclick="sendForm()"> 
                                            <button class="btn btn-danger submit-fn mt-2" type="submit" onclick="loadpage('complainants_list.php','page')">Cancel</button>
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
                $.ajax({
                    type: "GET",
                    url: 'utilities.php',
                    data: "op=get_lgas&state=" + event.target.value,
                    success: function (data) {
                        $('#lga').html(data);
                    }
                });
            });
        });

        function sendForm() {
            if($.trim($('#name').val())==''){
                $('#display_message').html('<div class=\' alert alert-danger \'>Name field is empty</div>');
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
            }else if(jQuery.trim($('#email').val())==''){
                $('#display_message').html('<div class=\' alert alert-danger \'>Email field is empty</div>');
                $('#display_message').show();
            }else if(jQuery.trim($('#nextofkin').val())==''){
                $('#display_message').html('<div class=\' alert alert-danger \'>Name of Next of Kin field is empty</div>');
                $('#display_message').show();
            }else if(jQuery.trim($('#nextofkinocc').val())==''){
                $('#display_message').html('<div class=\' alert alert-danger \'>Occupation of Next of Kin field is empty</div>');
                $('#display_message').show();
            }else if(jQuery.trim($('#nextofkinemail').val())==''){
                $('#display_message').html('<div class=\' alert alert-danger \'>Email of Next of Kin field is empty</div>');
                $('#display_message').show();
            }else if(jQuery.trim($('#nextofkinphone').val())==''){
                $('#display_message').html('<div class=\' alert alert-danger \'>Phone Number of Next of Kin field is empty</div>');
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
            }else{
                var data = new FormData();
                    data.append('op', 'upload_image');
                    data.append('dir', 'complainants');
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
                            return callpage('complainantnew');
                        }
                    });
            } 
            return false;
        }
    </script>
