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
    $arr=array("Inv_id","station_id","item_name","quantity","serial_number","date_of_collection", "state_id", "lga_id");
    $clause['Inv_id']=$_id;
    $result = $dbobject->doSelect('inventory',$arr,$clause);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC); 

    $station_id = $row['station_id'];
    $item_name = $row['item_name'];
    $quantity = $row['quantity'];
    $serial_number = $row['serial_number'];
    $date = $row['date_of_collection'];
    $state_id = $row['state_id'];
    $lga_id = $row['lga_id'];
     
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
                                            <h4><?php if ($status == '0') echo "New";  else echo "Edit"; ?> Inventory Item</h4>
                                        </div>                 
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <form id="form1" class="simple-example" action="javascript:void(0);" novalidate>

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
                                                <label for="itemname">Item Name</label>
                                                <input type="text" class="form-control" id="itemname" name="itemname" placeholder="" value="<?php echo $item_name; ?>" required>
                                            </div>
  
                                            <div class="col-md-6 mb-4">
                                                <label for="quantity">Quantity</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="" value="<?php echo $quantity; ?>"  required>
                                            </div>
  
 
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <label for="serialno">Serial No.</label>
                                                <input type="text" class="form-control" id="serialno" name="serialno" placeholder="" value="<?php echo $serial_number; ?>"  required>
                                            </div>
                                           
                                            <div class="col-md-6 mb-4">
                                                <label for="date">Date of Collection</label>
                                                <input type="date" class="form-control" id="date" name="date" placeholder="" value="<?php echo $date; ?>" max="<?php echo date('Y-m-d')?>"  required>
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
                                        <button class="btn btn-danger submit-fn mt-2" type="submit" onclick="loadpage('inventory_list.php','page')">Cancel</button>
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
            if($.trim($('#itemname').val())==''){
                $('#display_message').html('<div class=\' alert alert-danger \'>Item Name field is empty</div>');
                $('#display_message').show();
            }else if(jQuery.trim($('#quantity').val())==''){
                $('#display_message').html('<div class=\' alert alert-danger \'>Quantity field is empty</div>');
                $('#display_message').show();
            }else if(jQuery.trim($('#station').val())=='#'){
                $('#display_message').html('<div class=\' alert alert-danger \'>Station Name field is empty</div>');
                $('#display_message').show();
            }else if(jQuery.trim($('#state').val())=='#'){
                $('#display_message').html('<div class=\' alert alert-danger \'>State field is empty</div>');
                $('#display_message').show();
            }else if(jQuery.trim($('#lga').val())=='#'){
                $('#display_message').html('<div class=\' alert alert-danger \'>LGA field is empty</div>');
                $('#display_message').show();
            }else if(jQuery.trim($('#serialno').val())==''){
                $('#display_message').html('<div class=\' alert alert-danger \'>Serial Number field is empty</div>');
                $('#display_message').show();
            }else if(jQuery.trim($('#date').val())==''){
                $('#display_message').html('<div class=\' alert alert-danger \'>Date of Collection field is empty</div>');
                $('#display_message').show();
            }else{
                var data = new FormData();
                    data.append('op', 'upload_image');
                    data.append('dir', 'inventory');
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
                            return callpage('invnew');
                        }
                    });
            } 
            return false;
        }
    </script>
