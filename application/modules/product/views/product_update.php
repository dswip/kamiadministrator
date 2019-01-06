
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
 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
 
 <!-- Include Date Range Picker -->
<script type="text/javascript" src="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datetimepicker/bootstrap-datetimepicker.min.css" />


<style type="text/css">
  a:hover { text-decoration:none;}
</style>

<script src="<?php echo base_url(); ?>js/moduljs/product.js"></script>
<script src="<?php echo base_url(); ?>js-old/register.js"></script>

<script type="text/javascript">

	var sites_add  = "<?php echo site_url('product/add_process/');?>";
	var sites_edit = "<?php echo site_url('product/update_process/');?>";
	var sites_del  = "<?php echo site_url('product/delete/');?>";
	var sites_get  = "<?php echo site_url('product/update/');?>";
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
         <?php $js = "class='form-control' id='ccategory' tabindex='-1' style='min-width:150px;' "; 
	     echo form_dropdown('ccategory', $category, isset($default['category']) ? $default['category'] : '', $js); ?>
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Supplier </label>
        <div class="col-md-3 col-sm-6 col-xs-12">
        <?php $js = "class='form-control' id='cmodel' tabindex='-1' style='min-width:150px;' "; 
	    echo form_dropdown('csupplier', $supplier, isset($default['supplier']) ? $default['supplier'] : '', $js); ?>
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
          <label class="control-label col-md-3 col-sm-3 col-xs-12"> Modal - Price </label>  
          <div class="col-md-1 col-sm-12 col-xs-12 form-group">
            <table>
                <tr> 
                    <td> <input type="number" name="tmodal" class="form-control" style="width:120px;" value="<?php echo isset($default['modal']) ? $default['modal'] : '' ?>">
                    </td> 
                    <td> <input type="number" name="tprice" class="form-control" style="width:120px;" value="<?php echo isset($default['price']) ? $default['price'] : '' ?>">
                    </td> 
                </tr>
            </table>
          </div>
      </div>
        
      <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Validity </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
         <input type="number" name="tvalidity" class="form-control" required style="width:75px;" value="<?php echo isset($default['validity']) ? $default['validity'] : '' ?>">
      </div>
      </div>  
       
      <div class="form-group">  
          <label class="control-label col-md-3 col-sm-3 col-xs-12"> <br> Restricted Stock (Qty) </label>  
          <div class="col-md-6 col-sm-12 col-xs-12 form-group">
             
            <table>
                <tr> 
                    <td> <?php $js = "class='' id='crestrict'"; echo form_checkbox('crestrict', 1, set_value('crestrict', isset($default['restricted']) ? $default['restricted'] : 'FALSE'), $js); ?>
                    </td> 
                    <td> <input type="number" name="tqty" id="tqty" class="form-control" maxlength="3" readonly style="width:70px; margin-left:20px;" value="<?php echo isset($default['qty']) ? $default['qty'] : '' ?>">
                    </td> 
                    
                    <td> 
<input type="text" title="Article Date" class="timepicker text-center form-control" id="tstart" readonly name="tstart" style=" margin-left:20px; width:120px;" /> 
<input type="text" title="Article Date" class="timepicker text-center form-control" id="tend" name="tend" readonly style=" margin-left:20px; width:120px;" /> <br>
                    </td> 
                </tr>
                <tr>
<td colspan="3"> <input type="text" readonly class="form-control" style="width:80%;" value="<?php echo $default['start'].' - '.$default['end'] ?>"> </td>
                </tr>
            </table>             
               
          </div>
      </div>
      
      <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Upload Type </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
         <select name="curl" id="curl" class="form-control" style="width:150px;"> 
<option value="UPLOAD"<?php echo set_select('ctype', 'UPLOAD', isset($default['url_type']) && $default['url_type'] == 'UPLOAD' ? TRUE : FALSE); ?>> UPLOAD </option>  
<option value="URL"<?php echo set_select('ctype', 'URL', isset($default['url_type']) && $default['url_type'] == 'URL' ? TRUE : FALSE); ?>> URL </option>  
        </select>
      </div>
      </div>  
      
      <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Order </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
         <input type="number" name="torder" class="form-control" required style="width:65px;" value="<?php echo isset($default['order']) ? $default['order'] : '' ?>">
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
    
   <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script> 
