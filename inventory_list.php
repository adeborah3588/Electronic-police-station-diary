
<?php

session_start();

define('AJAX_REQUEST', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!AJAX_REQUEST)
{
    include('logout.php');
     
    die();
}

// 	include("lib/dbfunctions.php");

// 	$dbobject = new dbobject();

// 	$username = $_SESSION['sss_username_sess'];

//  $Class_list = $dbobject->gettableselect('classes_tb','class_id','class_name', '002');

//  $Class_list = $dbobject->gettableselect('classes_tb','sch_id','class_name', $_SESSION['schoolid']);
   
?>



            <div class="container">
                <div class="container">
 
                    <div class="row layout-top-spacing">
                        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                    <div class="col-xl-9 col-md-9 col-sm-9 col-9">
                                            <h4>Inventory</h4>
                                        </div>
                                        <div class="col-xl-3 col-md-3 col-sm-3 col-3">
                                            <input type="button" value="New Inventory Item" class="btn btn-outline-primary float-right mr-3" onclick="loadpage('inventory_form.php','page')">
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div class="table-responsive">
                                        <table id="_list" class="table table-bordered mb-4">
                                            <thead>
                                                <tr>
                                                    <th>S/NO</th>
                                                    <th>Item Name</th>
                                                    <th>Serial Number</th>
                                                    <th>Station</th>
                                                    <th>LGA</th>
                                                    <th>State</th> 
                                                    <th>Date Of Collection</th>
                                                    <th class="op-column">Operation</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>S/NO</th>
                                                    <th>Item Name</th>
                                                    <th>Serial Number</th>
                                                    <th>Station</th>
                                                    <th>LGA</th>
                                                    <th>State</th> 
                                                    <th>Date Of Collection</th>
                                                    <th class="op-column">Operation</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
 

                                </div>
                            </div>
                        </div>
                         
                            
                    </div>

                </div>
                </div>




                
<script>
    var table;
    var editor;
    var op = "get_inventory_list";
    $(document).ready(function() {
        table = $('#_list').DataTable({
            "processing": true,
            "columnDefs": [{
                "orderable": false,
                "targets": 0
            }],
            "serverSide": true,
            "paging": true,
            "oLanguage": {
                "sEmptyTable": "No record was found, please try another query"
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'csv',
                    title: "Inventory",
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                    },
                    className: 'btn btn-primary mt-4'
                },
                {
                    extend: 'excelHtml5',
                    title: "Inventory",
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                    },
                    className: 'btn btn-primary mt-4'
                },
                {
                    extend: 'pdfHtml5',
                    title: "Inventory",
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                    },
                    className: 'btn btn-primary mt-4'
                },
            ],

            "ajax": {
                "url": "utilities.php",
                "type": "POST",
                "data": function(d, l) {
                    d.op = op;
                    d.li = Math.random();
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            }
        });

        table.buttons(1, null).container().addClass( 'btn' ).appendTo(table.table().container());
        table.buttons(1, null).container().addClass( 'btn-outline-primary' ).appendTo(table.table().container());
    });

    function do_filter() {
        table.draw();
    }

    
	  function do_delete(id)
	  {
        $.ajax({
            type: "POST",
            url: "utilities.php",
            data: "op=doInventoryDe&_id=" + id,
            success: function(msg) {
                 
                  table.draw();
                  $.toast().reset('all');
                    $.toast({
                            heading: 'Positioning',
                            text: 'Use the predefined ones, or specify a custom position object.',
                            position: 'top-center',
                            stack: false,
    		                showHideTransition: 'slide'
                        })
            }
        });
		 
	  }

      function printTable() {
        $.ajax({
            type: "GET",
            url: "utilities.php",
            data: "op=print_inventory",
            success: function(msg) {
                var w = window.open('Inventory.pdf');
                w.print();
            }
        });
      }
</script>