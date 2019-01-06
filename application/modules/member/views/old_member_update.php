
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

<script src="<?php echo base_url(); ?>js/moduljs/member.js"></script>
<script src="<?php echo base_url(); ?>js-old/register.js"></script>

<script type="text/javascript">

	var sites_add  = "<?php echo site_url('member/add_process/');?>";
	var sites_edit = "<?php echo site_url('member/update_process/');?>";
	var sites_del  = "<?php echo site_url('member/delete/');?>";
	var sites_get  = "<?php echo site_url('member/update/');?>";
    var sites_ajax  = "<?php echo site_url('member/');?>";
    var sites_primary = "<?php echo site_url('member/publish/');?>";
    var sites_product  = "<?php echo site_url('product/');?>";
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
    <form id="upload_form_parent" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
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
<option value="kontraktor"<?php echo set_select('ctype', 'kontraktor', isset($default['type']) && $default['type'] == 'kontraktor' ? TRUE : FALSE); ?>> Kontraktor </option>  
<option value="member"<?php echo set_select('ctype', 'member', isset($default['type']) && $default['type'] == 'member' ? TRUE : FALSE); ?>> Member </option>  
<option value="studio"<?php echo set_select('ctype', 'studio', isset($default['type']) && $default['type'] == 'studio' ? TRUE : FALSE); ?>> Studio </option> 
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
        <input type="text" class="form-control has-feedback-left" id="tzip" name="tzip" placeholder="ZIP"
        value="<?php echo isset($default['zip']) ? $default['zip'] : '' ?>">
        <span class="fa fa-file-archive-o form-control-feedback left" aria-hidden="true"></span> 
      </div>
    
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control" id="twebsite" name="twebsite" placeholder="Website"
        value="<?php echo isset($default['website']) ? $default['website'] : '' ?>">
        <span class="fa fa-internet-explorer form-control-feedback right" aria-hidden="true"></span> 
      </div>
        
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control has-feedback-left" id="tnpwp" name="tnpwp" placeholder="NPWP"
        value="<?php echo isset($default['npwp']) ? $default['npwp'] : '' ?>">
        <span class="fa fa-file-archive-o form-control-feedback left" aria-hidden="true"></span> 
      </div>
    
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control" id="tprofession" name="tprofession" placeholder="Profession"
        value="<?php echo isset($default['profession']) ? $default['profession'] : '' ?>">
        <span class="fa fa-book form-control-feedback right" aria-hidden="true"></span> 
      </div>
    
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control has-feedback-left" id="torganization" name="torganization" placeholder="Organization" value="<?php echo isset($default['organization']) ? $default['organization'] : '' ?>">
        <span class="fa fa-file-archive-o form-control-feedback left" aria-hidden="true"></span> 
      </div>
    
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control" id="tmemberno" name="tmemberno" placeholder="Organization No"
        value="<?php echo isset($default['memberno']) ? $default['memberno'] : '' ?>">
        <span class="fa fa-book form-control-feedback right" aria-hidden="true"></span> 
      </div>
    
      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
        <input type="text" class="form-control has-feedback-left" id="tinstagram" name="tinstagram" placeholder="Instagram" value="<?php echo isset($default['instagram']) ? $default['instagram'] : '' ?>">
        <span class="fa fa-instagram form-control-feedback left" aria-hidden="true"></span> 
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
      
      <!-- form transaction table  -->
      
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    
 <!-- searching form -->
   <h3> Premium Section </h3> <hr>
   <form id="ajaxtransform" class="form-inline" method="post" action="<?php echo site_url('member/add_premium'); ?>">
       
      <div class="form-group">
        <label class="control-label labelx"> Product </label> <br>
        <?php $js = "class='select2_single form-control' id='cproduct' tabindex='-1' style='min-width:250px;' "; 
             echo form_dropdown('cproduct', $product, isset($default['product']) ? $default['product'] : '', $js); ?>
          &nbsp;
      </div>
 
      <div class="form-group">
        <label class="control-label labelx"> Start </label> <br>
        <input type="text" name="tstart" id="ds1" class="form-control" style="width:120px;" maxlength="8" required> &nbsp;
        <input type="hidden" name="hdays" id="hdays">
        <input type="hidden" name="tpid" id="tpid" value="<?php echo $pid; ?>">
      </div>
       
      <div class="form-group">
        <label class="control-label labelx"> Qty </label> <br>
        <input type="number" name="tqty" id="tqty" class="form-control" style="width:80px;" value="1" maxlength="8" required> &nbsp;
      </div>
       
      <div class="form-group">
        <label class="control-label labelx"> Price </label> <br>
        <input type="number" name="tprice" id="tprice" class="form-control" style="width:120px;" value="0" maxlength="8" required> &nbsp;
      </div>

      <div class="form-group btn-group"> <br>
       <button type="submit" class="btn btn-primary button_inline"> Post </button>
       <button type="button" onClick="load_data();" class="btn btn-danger button_inline"> Reset </button>
      </div>
  </form> <br>



   <!-- searching form --> 
        
    </div>
    
<!-- table -->
  <div class="col-md-12 col-sm-12 col-xs-12">  
    <div class="table-responsive">
      <table class="table table-striped jambo_table bulk_action">
        <thead>
          <tr class="headings">
            <th class="column-title"> No </th>
            <th class="column-title"> Product </th>
            <th class="column-title"> Period </th>
            <th class="column-title"> Amount </th>
            <th class="column-title no-link last"><span class="nobr">Action</span>
            </th>
            <th class="bulk-actions" colspan="7">
              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
            </th>
          </tr>
        </thead>

        <tbody>
            
        <?php
           
//            function product($pid)
//            {
//                $val = new Product_lib();
//                return $val->get_sku($pid).'<br>'.ucfirst($val->get_name($pid));
//            }
//            
//            if ($items)
//            {
//                $i=1;
//                foreach($items as $res)
//                {
//                    echo "
//                     <tr class=\"even pointer\">
//                        <td> ".$i." </td>
//                        <td> ".product($res->product_id)." </td>
//                        <td> ".$res->qty." </td>
//                        <td class=\"a-right a-right \"> ".idr_format(intval($res->qty*$res->price))." </td>
//                        <td class=\"a-right a-right \"> ".idr_format($res->tax)." </td>
//                        <td class=\"a-right a-right \"> ".idr_format($res->amount)." </td>
//<td class=\" last\"> 
//<a class=\"btn btn-danger btn-xs\" href=\"".site_url('sales/delete_item/'.$res->id.'/'.$res->sales_id)."\"> 
//<i class=\"fa fas-2x fa-trash\"> </i> 
//</a> </td>
//                      </tr>
//                    "; $i++;
//                }
//            }
            
        ?> 

        </tbody>
      </table>
    </div>
    </div>
<!-- table -->

    
</div>
<!-- form transaction table  -->  
      
      
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
    