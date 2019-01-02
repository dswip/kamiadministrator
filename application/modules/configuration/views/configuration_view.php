
 <!-- Datatables CSS -->
<link href="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/icheck/flat/green.css" rel="stylesheet" type="text/css">

<style type="text/css">
  a:hover { text-decoration:none;}
</style>

<script src="<?php echo base_url(); ?>js/moduljs/configuration.js"></script>
<script src="<?php echo base_url(); ?>js-old/register.js"></script>

<script type="text/javascript">

	var sites_add  = "<?php echo site_url('configuration/add_process/');?>";
	var sites_edit = "<?php echo site_url('configuration/update_process/');?>";
	var sites_del  = "<?php echo site_url('configuration/delete/');?>";
	var sites_get  = "<?php echo site_url('configuration/update/');?>";
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
        <span class="step_descr">
                          <small> Primary Details </small>
                      </span>
      </a>
    </li>
    <li>
      <a href="#step-2">
        <span class="step_no">2</span>
        <span class="step_descr">
                          <small> Bank Details  </small>
            </span>
      </a>
    </li>
    
    <li>
      <a href="#step-3">
        <span class="step_no">3</span>
        <span class="step_descr">
          <small> Site Configuration </small>
        </span>
      </a>
    </li>
    
    <li>
      <a href="#step-4">
        <span class="step_no">4</span>
        <span class="step_descr">
          <small> Period Management </small>
        </span>
      </a>
    </li>
    
  </ul>


  <div id="step-1">
    <!-- form -->
    <form class="form-horizontal form-label-left" id="ajaxform" method="post" action="<?php echo $form_action1; ?>">

      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Company Name </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" class="form-control" id="tname" name="tname" placeholder="Name" required>
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Address </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <textarea name="taddress" id="taddress" required class="form-control" rows="3" placeholder="Address"></textarea>        
        <input type="text" class="form-control" id="tcoordinate" name="tcoordinate" placeholder="Coordinate" style="width:250px;" required>
        </div>
      </div>
      <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> City </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?php $js = "class='select2_single form-control' id='ccity' tabindex='-1' style='width:100%;' "; 
	      echo form_dropdown('ccity', $city, isset($default['city']) ? $default['city'] : '', $js); ?>
        </div>
        
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Zip Code </label>
        <div class="col-md-6 col-sm-6 col-xs-12">          
          <input type="text" title="Zip Code" class="form-control" id="tzip" name="tzip" required placeholder="Zip Code" />
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Phone </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" class="form-control" id="tphone" name="tphone1" placeholder="Phone">
            <input type="text" class="form-control" id="tphone2" name="tphone2" placeholder="Phone 2">
            <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> 
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Email </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="email" class="form-control" id="tmail" name="tmail" placeholder="Email">
            <input type="email" class="form-control" id="tbillmail" name="tbillmail" placeholder="Billing Email">
            <input type="email" class="form-control" id="ttechmail" name="ttechmail" placeholder="Technical Email">
            <input type="email" class="form-control" id="tccmail" name="tccmail" placeholder="CC Email">
            <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span> 
        </div>
      </div>
      
      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button">Save</button>
        </div>
      </div>
      
	</form>
    <!-- end div layer 1 -->
  </div>
  
  <div id="step-2">   
    <form class="form-horizontal form-label-left" id="ajaxform2" method="post" action="<?php echo $form_action2; ?>">
     
     <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Account Name </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" class="form-control" name="taccount_name" id="taccount_name" title="Account Name" placeholder="Account Name" />
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Account No </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" class="form-control" name="taccount_no" id="taccount_no" title="Account No" placeholder="Account No" />
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Bank Details </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" class="form-control" name="tbank" id="tbank" title="Bank Details" placeholder="Bank Details" />
        </div>
      </div>
      
      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button">Save</button>
        </div>
      </div>
      
     </form>
  </div>
  
  <div id="step-4">   
    <form class="form-horizontal form-label-left" id="ajaxform4" method="post" action="<?php echo $form_action4; ?>">
     
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12"> Begin Period </label>
      <div class="col-md-2 col-sm-6 col-xs-12">
         <?php $js = "class='form-control' id='cbegin_month' tabindex='-1' style='width:100%;' "; 
	      echo form_dropdown('cbegin_month', $cmonth, isset($default['month']) ? $default['month'] : '', $js); ?>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <input type="number" maxlength="4" class="form-control" name="tbegin_year" id="tbegin_year" title="" />     
      </div>
    </div>
        
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12"> Period </label>
      <div class="col-md-2 col-sm-6 col-xs-12">
         <?php $js = "class='form-control' id='cmonth' tabindex='-1' style='width:100%;' "; 
	      echo form_dropdown('cmonth', $cmonth, isset($default['month']) ? $default['month'] : '', $js); ?>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <input type="number" maxlength="4" class="form-control" name="tyear" id="tyear" title="" />     
      </div>
    </div>
      
      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button">Save</button>
          <a href="<?php echo site_url('closing'); ?>" class="btn btn-danger"> Monthly End </a>
        </div>
      </div>
      
     </form>
  </div>
  
  
  <div id="step-3">
     
    <form class="form-horizontal form-label-left" id="ajaxform3" method="post" action="<?php echo $form_action3; ?>" 
    enctype="multipart/form-data">
   
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12"> Site Name </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
         <input type="text" class="form-control" name="tsitename" id="tsitename" title="Site Name" placeholder="Site Name" />
      </div>
    </div> 
    
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12"> Site Meta Description </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
         <textarea name="tmetadesc" id="tmetadesc" class="form-control" title="Meta Description" cols="55" rows="5"></textarea>
      </div>
    </div> 
    
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12"> Site Meta Keywords </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
         <textarea name="tmetakey" id="tmetakey" title="Meta Keyword" class="form-control" cols="55" rows="5"></textarea>
      </div>
    </div> 
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Image </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="file" id="uploadImage" accept="image/*" class="input-medium" title="Upload" name="userfile" /> <br>
            <img id="catimg_update" style="width:100%; height:auto;">
      </div>
    </div>
    
    <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button">Save</button>
        </div>
    </div>
    
    </form>
    
	<!-- end form -->
    
  </div>
  


</div>
<!-- End SmartWizard Content -->
                      
             </div>
               
               <!-- links -->
	           <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?>
               <!-- links -->
                             
            </div>
          </div>
      
    
      <!-- Modal - Add Form -->
      <div class="modal fade" id="myModal" role="dialog">
         <?php //$this->load->view('admin_form'); ?>      
      </div>
      <!-- Modal - Add Form -->
      
      <!-- Modal Edit Form -->
      <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	     <?php //$this->load->view('admin_update'); ?> 
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

        $('.buttonNext').addClass('btn btn-success');
        $('.buttonPrevious').addClass('btn btn-primary');
        $('.buttonFinish').addClass('btn btn-default');
      });
    </script>
    <!-- /jQuery Smart Wizard -->
