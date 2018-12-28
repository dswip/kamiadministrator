
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

<script src="<?php echo base_url(); ?>js/moduljs/customer.js"></script>
<script src="<?php echo base_url(); ?>js-old/register.js"></script>

<script type="text/javascript">

	var sites_add  = "<?php echo site_url('member/add_process/');?>";
	var sites_edit = "<?php echo site_url('member/update_process/');?>";
	var sites_del  = "<?php echo site_url('member/delete/');?>";
	var sites_get  = "<?php echo site_url('member/update/');?>";
    var sites_ajax  = "<?php echo site_url('member/');?>";
    var sites_primary = "<?php echo site_url('member/publish/');?>";
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
        <input type="text" class="form-control has-feedback-left" id="tfname" name="tfname"
        value="<?php echo isset($default['fname']) ? $default['fname'] : '' ?>" >
        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> 
      </div>

      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control" id="tlname" name="tlname" 
        value="<?php echo isset($default['lname']) ? $default['lname'] : '' ?>">
        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span> 
      </div>
    
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="email" class="form-control has-feedback-left" id="temail" name="temail"
        value="<?php echo isset($default['email']) ? $default['email'] : '' ?>">
        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span> 
      </div>
    
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <select name="ctype" id="ctype" class="form-control"> 
<option value="customer"<?php echo set_select('ctype', 'customer', isset($default['type']) && $default['type'] == 'customer' ? TRUE : FALSE); ?>> Customer </option>  
<option value="member"<?php echo set_select('ctype', 'member', isset($default['type']) && $default['type'] == 'member' ? TRUE : FALSE); ?>> Member </option>  
        </select>
      </div>
    
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control has-feedback-left" id="tphone1" name="tphone1"
        value="<?php echo isset($default['phone1']) ? $default['phone1'] : '' ?>">
        <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span> 
      </div>

      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control" id="tphone2" name="tphone2"
        value="<?php echo isset($default['phone2']) ? $default['phone2'] : '' ?>">
        <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> 
      </div>
       
            <!-- password generator -->
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
 <input type="text" class="form-control has-feedback-left" readonly id="tpass" name="tpass" style="width:200px; float:left; margin-right:10px;" value="<?php echo isset($default['password']) ? $default['password'] : '' ?>">
        
        <button type="button" id="bgetpass" class="btn btn-default"> GET Password </button>  
      </div>
        
      <div class="clear"></div>
        
      <div class="form-group">
      <label class="control-label col-md-1 col-sm-1 col-xs-12"> Address : </label>
        <div class="col-md-11 col-sm-11 col-xs-12">
       <textarea name="taddress" id="taddress" rows="4" class="form-control" placeholder="Address"><?php echo $address; ?></textarea>
        </div>
      </div>    
        
      <div class="form-group">
      <label class="control-label col-md-1 col-sm-1 col-xs-12"> Shipping Address : </label>
        <div class="col-md-11 col-sm-11 col-xs-12">
       <textarea name="tshipping" id="tshipping" rows="4" class="form-control" placeholder="Address"><?php echo $shipping; ?></textarea>
        </div>
      </div>    
    
      <!-- pembatas div -->
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
      </div>
       <!-- pembatas div -->
        
     <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
<?php $js = "class='select2_single form-control' placeholder='Select City' id='ccity' tabindex='-1' style='width:100%;' "; 
echo form_dropdown('ccity', $city, isset($default['city']) ? $default['city'] : '', $js); ?>
     </div>
        
     <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
<?php $js = "class='form-control' placeholder='Select District' id='cdistrict_update' tabindex='-1' style='width:100%;' "; 
echo form_dropdown('cdistrict', $district, isset($default['district']) ? $default['district'] : '', $js); ?>
     </div>
    
     <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
        <div class="select_box"></div>
     </div>
    
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control has-feedback-left" id="tzip" name="tzip"
        value="<?php echo isset($default['zip']) ? $default['zip'] : '' ?>">
        <span class="fa fa-file-archive-o form-control-feedback left" aria-hidden="true"></span> 
      </div>
    
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control" id="twebsite" name="twebsite"
        value="<?php echo isset($default['website']) ? $default['website'] : '' ?>">
        <span class="fa fa-internet-explorer form-control-feedback right" aria-hidden="true"></span> 
      </div>
    
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
    
    
