
 <!-- Datatables CSS -->
<link href="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/icheck/flat/green.css" rel="stylesheet" type="text/css">

<!-- Date time picker -->
 <script type="text/javascript" src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 
 <!-- Include Date Range Picker -->
<script type="text/javascript" src="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />


<style type="text/css">
  a:hover { text-decoration:none;}
</style>

<script src="<?php echo base_url(); ?>js/moduljs/supplier.js"></script>
<script src="<?php echo base_url(); ?>js-old/register.js"></script>

<script type="text/javascript">

	var sites_add  = "<?php echo site_url('supplier/add_process/');?>";
	var sites_edit = "<?php echo site_url('supplier/update_process/');?>";
	var sites_del  = "<?php echo site_url('supplier/delete/');?>";
	var sites_get  = "<?php echo site_url('supplier/update/');?>";
    var sites_ajax  = "<?php echo site_url('supplier/');?>";
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
                      
                  
             <!-- Smart Wizard -->
<div id="wizard" class="form_wizard wizard_horizontal">
  
  <ul class="wizard_steps">
    <li>
      <a href="#step-1">
        <span class="step_no">1</span>
        <span class="step_descr"> <small> General </small> </span>
      </a>
    </li>
   
  </ul>
  
  <div id="errors" class="alert alert-danger alert-dismissible fade in" role="alert"> 
     <?php $flashmessage = $this->session->flashdata('message'); ?> 
	 <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> 
  </div>
  
  <div id="step-1">
    <!-- form -->
    <form id="supload_form_parent" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
    action="<?php echo $form_action.'/1'; ?>" 
      enctype="multipart/form-data">
		
    <br>    
      
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control has-feedback-left" id="tname" name="tname" placeholder="Name" value="<?php echo isset($default['name']) ? $default['name'] : '' ?>">
        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> 
      </div>

      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control" id="tic" name="tic" placeholder="IC" value="<?php echo isset($default['ic']) ? $default['ic'] : '' ?>">
        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span> 
      </div>
    
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="email" class="form-control has-feedback-left" id="temail" name="temail"
        value="<?php echo isset($default['email']) ? $default['email'] : '' ?>">
        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span> 
      </div>
    
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control has-feedback-left" id="tphone" name="tphone"
        value="<?php echo isset($default['phone']) ? $default['phone'] : '' ?>">
        <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span> 
      </div>
      
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control has-feedback-left" id="tcompany" name="tcompany"
        value="<?php echo isset($default['company']) ? $default['company'] : '' ?>">
        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span> 
      </div>
      
      <!-- pembatas div -->
      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
      </div>
       <!-- pembatas div -->
     
      <div class="form-group">
      <label class="control-label col-md-1 col-sm-1 col-xs-12"> Address : </label>
        <div class="col-md-11 col-sm-11 col-xs-12">
       <textarea name="taddress" id="taddress" rows="4" class="form-control" placeholder="Address"><?php echo $address; ?></textarea>
        </div>
      </div>    
    
      <!-- pembatas div -->
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
      </div>
       <!-- pembatas div -->
    
      <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
        <input type="file" id="uploadImage" accept="image/*" class="input-medium" title="Upload" name="userfile" /> <br>
        <img id="catimg" style=" max-width:100px; height:auto;" src="<?php echo isset($default['image']) ? $default['image'] : '' ?>">
      </div>
      
      <!-- pembatas div -->
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
      </div>
       <!-- pembatas div --> 
      
      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button"> Save General </button>
        </div>
      </div>
      
	</form>
    <!-- end div layer 1 -->
  </div>
  
</div>
<!-- End SmartWizard Content -->
                      
     </div>
       
       <!-- links -->
       <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?>
       <!-- links -->
                     
    </div>
  </div>
      
      <script src="<?php echo base_url(); ?>js/icheck/icheck.min.js"></script>
      
       <!-- Datatables JS -->
        <script src="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/jszip.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/pdfmake.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/vfs_fonts.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.scroller.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.tableTools.js"></script>
    
    <!-- jQuery Smart Wizard -->
    <script src="<?php echo base_url(); ?>js/wizard/jquery.smartWizard.js"></script>
        
        <!-- jQuery Smart Wizard -->
    <script>
      $(document).ready(function() {
        $('#wizard').smartWizard();

        $('#wizard_verticle').smartWizard({
          transitionEffect: 'slide'
        });

      });
    </script>
    <!-- /jQuery Smart Wizard -->
    
    
