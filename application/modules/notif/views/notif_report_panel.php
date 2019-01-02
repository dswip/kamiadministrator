<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Notif Report </h4>
</div>
<div class="modal-body">
 
 <!-- form add -->
<div class="x_panel" >
<div class="x_title">
  
  <div class="clearfix"></div> 
</div>
<div class="x_content">

<?php
    
$atts1 = array(
	  'class'      => 'btn btn-primary button_inline',
	  'title'      => 'Customer - List',
	  'width'      => '800',
	  'height'     => '600',
	  'scrollbars' => 'yes',
	  'status'     => 'yes',
	  'resizable'  => 'yes',
	  'screenx'    =>  '\'+((parseInt(screen.width) - 800)/2)+\'',
	  'screeny'    =>  '\'+((parseInt(screen.height) - 600)/2)+\'',
);

?>

<form id="" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
action="<?php echo $form_action_report; ?>" enctype="multipart/form-data">

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Type </label>
        <div class="col-md-4 col-sm-9 col-xs-12">     
        <input type="text" class="form-control" name="tcust" id="ccust_report" readonly style="width:80px; float:left;">
        <?php echo anchor_popup(site_url("customer/get_list/ccust_report/"), '[ ... ]', $atts1); ?> &nbsp;
        </div>
    </div>  
     
      
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Notif Type </label>
        <div class="col-md-3 col-sm-9 col-xs-12">     
        <select name="cnotiftype" id="ctype" class="form-control" style="min-width:150px;">
           <option value=""> -- </option>
           <option value="0"> Email </option>
           <option value="1"> SMS </option>
           <option value="2"> Email SMS </option>
           <option value="3"> Socket </option>
           <option value="4"> Email SMS Notif Socket </option>
        </select>
        </div>
    </div>  
      
      
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Type </label>
        <div class="col-md-3 col-sm-9 col-xs-12">     
			<select name="ctype" class="form-control">
              <option value="0"> Summary </option>
              <option value="1"> Pivottable </option>
            </select>
        </div>
    </div>

      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary">Post</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
      </div>
  </form> 
  <div id="err"></div>
</div>
</div>
<!-- form add -->

</div>
    <div class="modal-footer">
      
    </div>
  </div>
  
</div>