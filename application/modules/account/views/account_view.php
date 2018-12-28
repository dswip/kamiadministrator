
 <!-- Datatables CSS -->
<link href="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/icheck/flat/green.css" rel="stylesheet" type="text/css">

<script src="<?php echo base_url(); ?>js/moduljs/account.js"></script>
<script src="<?php echo base_url(); ?>js-old/register.js"></script>

<script type="text/javascript">

	var sites_add  = "<?php echo site_url('account/add_process/');?>";
	var sites_edit = "<?php echo site_url('account/update_process/');?>";
	var sites_del  = "<?php echo site_url('account/delete/');?>";
	var sites_get  = "<?php echo site_url('account/update/');?>";
	var sites_primary  = "<?php echo site_url('account/publish/');?>";
	var source = "<?php echo $source;?>";
	
</script>

          <div class="row"> 
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel" >
              
              <!-- xtitle -->
              <div class="x_title">
              
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                </ul>
                
                <div class="clearfix"></div>
              </div>
              <!-- xtitle -->
                
                <div class="x_content">
                    
          <!-- searching form -->
           
           <form id="searchform" class="form-inline">
               
  <div class="form-group">
        <?php $js = "class='select2_single form-control' id='ccategory_search' tabindex='-1' style='width:300px;' "; 
        echo form_dropdown('ccategory', $category, isset($default['category']) ? $default['category'] : '', $js); ?>
  </div>
               
  <div class="form-group">
      <?php $js = "class='select2_single form-control' id='cparent_search' tabindex='-1' style='width:250px;' "; 
	  echo form_dropdown('cparent', $parent, isset($default['parent']) ? $default['parent'] : '', $js); ?>
  </div>              
               
              <div class="form-group">
               <button type="submit" class="btn btn-primary button_inline"> Filter </button>
               <button type="reset" onClick="" class="btn btn-success button_inline"> Clear </button>
               <button type="button" onClick="load_data(null);" class="btn btn-danger button_inline"> Reset </button>
              </div>
          </form> <br>
           
           <!-- searching form -->                
                  
          <form class="form-inline" id="cekallform" method="post" action="<?php echo ! empty($form_action_del) ? $form_action_del : ''; ?>">
                  
                  <div class="table-responsive">
                  <!-- table -->
                  <?php echo ! empty($table) ? $table : ''; ?>
                  <!-- table -->
                  </div>
                  
                  <!-- Check All Function -->
                  <div class="form-group" id="chkbox">
                    Check All : 
                    <button type="submit" id="cekallbutton" class="btn btn-danger btn-xs">
                       <span class="glyphicon glyphicon-trash"></span>
                    </button>
                  </div>
                  <!-- Check All Function -->    
          </form>       
             </div>

               <!-- Trigger the modal with a button --> 
 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"></i>&nbsp;Add New </button>
 
 <a href="<?php echo site_url('account/report'); ?>" class="btn btn-primary"> Report </a>
 <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal3"> CSV Import </button>                  
               
               <!-- links -->
	           <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?>
               <!-- links -->
                             
            </div>
          </div>
      
    
      <!-- Modal - Add Form -->
      <div class="modal fade" onclick="" id="myModal" role="dialog">
         <?php $this->load->view('account_form'); ?>      
      </div>
      <!-- Modal - Add Form -->
      
      <!-- Modal Edit Form -->
      <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	     <?php $this->load->view('account_update'); ?> 
      </div>
      <!-- Modal Edit Form -->
      
      <!-- Modal - Report Form -->
      <div class="modal fade" id="myModal3" role="dialog">
         <?php $this->load->view('account_import'); ?>    
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
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.tableTools.js"></script>
        