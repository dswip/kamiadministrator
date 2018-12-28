
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

<script src="<?php echo base_url(); ?>js/moduljs/campaign.js"></script>
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
        <span class="step_descr"> <small> Primary Details </small> </span>
      </a>
    </li>
  </ul>
  
  <div id="errors" class="alert alert-danger alert-dismissible fade in" role="alert"> 
     <?php $flashmessage = $this->session->flashdata('message'); ?> 
	 <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> 
  </div>
  
  <div id="step-1">
    <!-- form -->
    <form id="xajaxformdata" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
    action="<?php echo $form_action; ?>" 
      enctype="multipart/form-data">
      
<!--
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Language </label>
        <div class="col-md-3 col-sm-6 col-xs-12">
        <?php // $js = "class='select2_single form-control' id='clanguage' tabindex='-1' style='min-width:150px;' "; 
	  //  echo form_dropdown('clang', $language, isset($default['language']) ? $default['language'] : '', $js); ?>
        </div>
      </div>
-->
            
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Title </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
  	       <input type="text" title="Title" class="form-control" id="ttitle" name="ttitle" required placeholder=""
           value="<?php echo isset($default['title']) ? $default['title'] : '' ?>" />
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Date </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
           <input type="text" title="Article Date" class="form-control" id="ds1" name="tdates" required readonly 
           value="<?php echo isset($default['date']) ? $default['date'] : '' ?>" /> 
        </div>
      </div>
        
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Type </label>
        <div class="col-md-2 col-sm-2 col-xs-12">
           <select name="ctype" id="ctype" class="form-control">
<option value="email"<?php echo set_select('ctype', 'email', isset($default['type']) && $default['type'] == 'email' ? TRUE : FALSE); ?>> Email </option>
<option value="sms"<?php echo set_select('ctype', 'sms', isset($default['type']) && $default['type'] == 'sms' ? TRUE : FALSE); ?>> SMS </option>
<option value="notif"<?php echo set_select('ctype', 'notif', isset($default['type']) && $default['type'] == 'notif' ? TRUE : FALSE); ?>> Notification </option>
           </select>
        </div>
      </div>
        
       <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Category </label>
        <div class="col-md-4 col-sm-4 col-xs-12">
         <table>
             <tr> 
                 <td>  
                     <?php $js = "class='form-control' id='ccategory' tabindex='-1' style='min-width:100px;' "; 
	                 echo form_dropdown('ccategory', $category, isset($default['category']) ? $default['category'] : '', $js); ?>
                 </td>
                 <td>
                     <input type="text" class="form-control" name="tcategory" id="tcategory" placeholder="Category">
                 </td>
             </tr>
         </table>    
         
        </div>
      </div>  
        
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Recipient </label>
        <div class="col-md-4 col-sm-4 col-xs-12">
           <input type="checkbox" class="flat" name="ctocustomer" value="customer" checked> Customer
           <input type="checkbox" class="flat" name="ctodriver" value="courier" checked> Courier
        </div>
      </div> 
            
      <div class="form-group">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="tckbox">
                <?php echo $this->ckeditor->editor('tdescemail', isset($default['desc']) ? $default['desc'] : ''); ?> 
            </div>
<div id="tsmsbox" style="display:none;"> <textarea style="width:100%;" name="tdesc" cols="60" rows="2"></textarea> </div>
        </div>
      </div>
      
      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-3 btn-group">
          <button type="submit" class="btn btn-primary" id="button"> Save </button>
          <button type="reset" onClick="location.reload(true);" class="btn btn-danger"> Reset </button>
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
    
    
