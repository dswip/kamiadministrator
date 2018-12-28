
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

<script src="<?php echo base_url(); ?>js/moduljs/sales.js"></script>
<script src="<?php echo base_url(); ?>js-old/register.js"></script>

<script type="text/javascript">

	var sites_add  = "<?php echo site_url('sales/add_process/');?>";
	var sites_edit = "<?php echo site_url('sales/update_process/');?>";
	var sites_del  = "<?php echo site_url('sales/delete/');?>";
	var sites_get  = "<?php echo site_url('sales/update/');?>";
	var source = "<?php echo $source;?>";
    var url  = "<?php echo $graph;?>";
	
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
    <li>
      <a href="#step-2">
        <span class="step_no">2</span>
        <span class="step_descr"> <small> Data </small> </span>
      </a>
    </li>
    <li>
      <a href="#step-3">
        <span class="step_no">3</span>
        <span class="step_descr"> <small> Price &amp; Qty </small> </span>
      </a>
    </li>
    <li>
      <a href="#step-4">
        <span class="step_no">4</span>
        <span class="step_descr"> <small> Dimension </small> </span>
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
		
      <div class="form-group">  
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sku"> SKU </label>
	  <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" class="form-control" id="tsku" required name="tsku" placeholder="SKU" 
        value="<?php echo isset($default['sku']) ? $default['sku'] : '' ?>">
      </div>
      </div>
	
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Category </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
         <?php $js = "class='select2_single form-control' id='ccategory' tabindex='-1' style='min-width:150px;' "; 
	     echo form_dropdown('ccategory', $category, isset($default['category']) ? $default['category'] : '', $js); ?>
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Manufacture </label>
        <div class="col-md-3 col-sm-6 col-xs-12">
        <?php $js = "class='select2_single form-control' id='cmanufacture' tabindex='-1' style='min-width:150px;' "; 
	    echo form_dropdown('cmanufacture', $manufacture, isset($default['manufacture']) ? $default['manufacture'] : '', $js); ?>
        </div>
      </div>
      
       <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Currency </label>
        <div class="col-md-3 col-sm-6 col-xs-12">
        <?php $js = "class='select2_single form-control' id='ccurrency' tabindex='-1' style='min-width:150px;' "; 
	    echo form_dropdown('ccurrency', $currency, isset($default['currency']) ? $default['currency'] : '', $js); ?>
        </div>
      </div>
            
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Name </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
  	       <input type="text" title="Product Name" class="form-control" id="tname" name="tname" required placeholder=""
           value="<?php echo isset($default['name']) ? $default['name'] : '' ?>" />
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Model </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
  	       <input type="text" title="Product Model" class="form-control" id="tmodel" name="tmodel" required placeholder=""
           value="<?php echo isset($default['model']) ? $default['model'] : '' ?>" />
        </div>
      </div>
      
      <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Image </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="file" id="uploadImage" accept="image/*" class="input-medium" title="Upload" name="userfile" /> <br>
          <img id="catimg" style=" max-width:100px; height:auto;" src="<?php echo isset($default['image']) ? $default['image'] : '' ?>">
      </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Short Description </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
<textarea class="form-control" cols="35" rows="3" name="tshortdesc"><?php echo isset($default['sdesc']) ? $default['sdesc'] : '' ?></textarea>
        </div>
      </div>
      
      <div class="form-group">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php echo $this->ckeditor->editor('tdesc', isset($default['description']) ? $default['description'] : '');?> 
        </div>
      </div>
      
      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button"> Save General </button>
        </div>
      </div>
      
	</form>
    <!-- end div layer 1 -->
  </div>
  
  <!-- div 2 -->
  <div id="step-2">
     
    <!-- form -->
<form id="sajaxformdata" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
action="<?php echo $form_action.'/2'; ?>" >

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12"> Meta Tag Title </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
<textarea class="form-control" cols="35" rows="4" name="tmetatitle"><?php echo isset($default['metatitle']) ? $default['metatitle'] : '' ?></textarea>
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12"> Meta Tag Description </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
<textarea class="form-control" cols="35" rows="4" name="tmetadesc"><?php echo isset($default['metadesc']) ? $default['metadesc'] : '' ?></textarea>
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12"> Meta Tag Keywords </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
<textarea class="form-control" cols="35" rows="4" name="tmetakeywords"><?php echo isset($default['metakeywords']) ? $default['metakeywords'] : '' ?></textarea>
        </div>
      </div>
      
      <div class="form-group">
      <label class="control-label col-md-6 col-sm-6 col-xs-12"> Spesification </label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php echo $this->ckeditor->editor('tspec', isset($default['spec']) ? $default['spec'] : '');?> 
        </div>
      </div>
      
      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button"> Save Data </button>
        </div>
      </div>
      
	</form>
    <!-- end div layer 2 -->
     
  </div>
  <!-- div 2 -->
  
  <!-- div 3 -->
  <div id="step-3">
  		
     <form id="ajaxformdata" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
     action="<?php echo $form_action.'/3'; ?>" >

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12"> Price / Discount % </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
 <input type="number" title="Price" class="form-control" id="tprice" name="tprice" required value="<?php echo isset($default['price']) ? $default['price'] : '' ?>" />
        </div>
        
        <div class="col-md-2 col-sm-2 col-xs-12">
 <input type="number" title="Discount %" class="form-control" id="tdisc_p" name="tdisc_p" value="<?php echo isset($default['disc_p']) ? $default['disc_p'] : '' ?>" />
        </div>
      </div>
      
      <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12"> Discount Price </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
       <input type="number" title="Discount Price" class="form-control" id="tdiscount" name="tdiscount" required value="<?php echo isset($default['discount']) ? $default['discount'] : '' ?>" />
        </div>
      </div>
      
      <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12"> Qty </label>
        <div class="col-md-2 col-sm-2 col-xs-12">
       <input type="number" title="Qty" class="form-control" id="tqty" name="tqty" required value="<?php echo isset($default['qty']) ? $default['qty'] : '' ?>" />
        </div>
      </div>
      
      <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12"> Min Order </label>
        <div class="col-md-1 col-sm-1 col-xs-12">
       <input type="number" title="Min Order" class="form-control" id="tmin" name="tmin" required value="<?php echo isset($default['min']) ? $default['min'] : '' ?>" />
        </div>
      </div>

      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button"> Save Price &amp; Qty </button>
        </div>
      </div>
      
	</form>  
    
  </div>
  <!-- div 3 -->
  
  <!-- div 4 -->
  <div id="step-4">
    
    <form id="ajaxformdata2" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
    action="<?php echo $form_action.'/4'; ?>" >

      <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12"> Dimensions <br> (L x W x H) </label>
       
        <div class="col-md-1 col-sm-1 col-xs-12">
 <input type="number" title="Length" class="form-control" id="tlength" name="tlength" placeholder="L" value="<?php echo isset($default['length']) ? $default['length'] : '' ?>" />
        </div>
        
		<div class="col-md-1 col-sm-1 col-xs-12">
 <input type="number" title="Width" class="form-control" id="twidth" name="twidth" placeholder="W" value="<?php echo isset($default['width']) ? $default['width'] : '' ?>" />
        </div>
        
        <div class="col-md-1 col-sm-1 col-xs-12">
 <input type="number" title="Height" class="form-control" id="theight" name="theight" placeholder="H" value="<?php echo isset($default['height']) ? $default['height'] : '' ?>" />
        </div>
        
      </div>
      
      <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12"> Dimension Class </label>
        <div class="col-md-2 col-sm-2 col-xs-12">
         <select name="cdimension" class="form-control">
<option value="m"<?php echo set_select('cdimension', 'm', isset($default['dclass']) && $default['dclass'] == 'm' ? TRUE : FALSE); ?>> m 
</option>
<option value="cm"<?php echo set_select('cdimension', 'cm', isset($default['dclass']) && $default['dclass'] == 'cm' ? TRUE : FALSE); ?>> cm 
</option>
<option value="mm"<?php echo set_select('cdimension', 'mm', isset($default['dclass']) && $default['dclass'] == 'mm' ? TRUE : FALSE); ?>> mm 
</option>
<option value="inch"<?php echo set_select('cdimension', 'inch', isset($default['dclass']) && $default['dclass'] == 'inch' ? TRUE : FALSE); ?>> inch </option>
<option value="inch"<?php echo set_select('cdimension', 'ft', isset($default['dclass']) && $default['dclass'] == 'ft' ? TRUE : FALSE); ?>> ft
</option>
         </select>
        </div>
      </div>
      
      <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12"> Weight (kg) </label>
        <div class="col-md-2 col-sm-2 col-xs-12">
       <input type="number" title="Weight" class="form-control" id="tweight" name="tweight" value="<?php echo isset($default['weight']) ? $default['weight'] : '' ?>" />
        </div>
      </div>
      
      <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12"> Related </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            
		<?php $js = "class='select2_multiple form-control' id='crelated' multiple='multiple' tabindex='-1' style='width:100%;' "; 
             echo form_dropdown('crelated[]', $related, isset($default['related']) ? $default['related'] : '', $js); ?>
             <small> * Leave blank to get auto related </small>
            </div>
      </div>

      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button"> Save Dimension </button>
        </div>
      </div>
      
	</form>  
    
  </div>
  <!-- div 4 -->
  
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
    
    
