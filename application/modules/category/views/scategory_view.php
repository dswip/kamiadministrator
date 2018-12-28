
 <!-- Datatables CSS -->
<link href="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url(); ?>css/icheck/flat/green.css" rel="stylesheet">


<script src="<?php echo base_url(); ?>js/ajaxupload.js"></script>
<script src="<?php echo base_url(); ?>js-old/register.js"></script>
<script type="text/javascript">

    var site = "<?php echo site_url();?>";
	var sites_add  = "<?php echo site_url('category/add_process/');?>";
	var sites_edit = "<?php echo site_url('category/update_process/');?>";
	var sites_del  = "<?php echo site_url('category/delete/');?>";
	
	$(function(){
            $(document).on('click','.text-primary',function(e)
			{
				var sites = "<?php echo site_url('category/update/');?>";
				
                e.preventDefault();
                $("#myModal2").modal('show');
                $.post(sites,
                    {id:$(this).attr('data-id')},
                    function(result)
					{
						res = result.split("|");
						
						document.getElementById("tid").value = res[0];
						document.getElementById("tname").value = res[2];
						document.getElementById('cparent').value = res[3];
						document.getElementById('catimg').src = res[4];
						
                        // $(".modal-body").html(res[2]);
                    }   
                );
            });
			
        });
	
</script>

          <div class="row"> 
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel" >
   				
                <div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
                <p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
                
                <div class="x_content">
                  
                <form class="form-inline" method="post" action="<?php echo ! empty($form_action_del) ? $form_action_del : ''; ?>">
                  <!-- table -->
                  <?php echo ! empty($table) ? $table : ''; ?>
                  <!-- table -->
                  
                  <!-- Check All Function -->
                  <div class="form-group">
                    Check All : 
                    <?php echo ! empty($checkbox) ? $checkbox : ''; ?>
                    <button type="submit" class="btn btn-danger btn-xs">
                       <span class="glyphicon glyphicon-trash"></span>
                    </button>
                  </div>
                  <!-- Check All Function -->
                  
                </form>
                 
                </div>
                <div class="pagination"> <?php echo ! empty($pagination) ? $pagination : ''; ?> </div>
               <!-- Trigger the modal with a button --> 
               <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"></i>&nbsp;Add New </button>
               <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3"> Report  </button>-->
               
               <!-- links -->
	           <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?>
               <!-- links -->
                             
            </div>
          </div>


      <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group"></ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
      </div>
      
    
      <!-- Modal - Add Form -->
      <div class="modal fade" id="myModal" role="dialog">
         <?php $this->load->view('category_form'); ?>      
      </div>
      <!-- Modal - Add Form -->
      
      <!-- Modal Edit Form -->
      <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	     <?php $this->load->view('category_update'); ?> 
      </div>
      <!-- Modal Edit Form -->
      
      <!-- Modal - Report Form -->
      <div class="modal fade" id="myModal3" role="dialog">
         <?php /*$this->load->view('category_report');*/ ?>    
      </div>
      <!-- Modal - Report Form -->
      
      <script src="<?php echo base_url(); ?>js/icheck/icheck.min.js"></script>
      
       <!-- Datatables JS -->
        <script src="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/buttons.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/jszip.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/pdfmake.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/vfs_fonts.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/buttons.print.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.scroller.min.js"></script>

       <!-- pace -->
        <script src="<?php echo base_url(); ?>js/pace/pace.min.js"></script>
        <script>
          var handleDataTableButtons = function() {
              "use strict";
              0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
                dom: "Bfrtip",
                "order": [[ 1, "asc" ]],     
                buttons: [{
                  extend: "copy",
                  className: "btn-sm"
                }, {
                  extend: "csv",
                  className: "btn-sm"
                }, {
                  extend: "excel",
                  className: "btn-sm"
                }, {
                  extend: "pdf",
                  className: "btn-sm"
                }, {
                  extend: "print",
                  className: "btn-sm"
                }],
                responsive: !0
              })
            },
            TableManageButtons = function() {
              "use strict";
              return {
                init: function() {
                  handleDataTableButtons()
                }
              }
            }();
        </script>
        <!-- pace -->
        
		<script type="text/javascript">
             TableManageButtons.init();
        </script>
    