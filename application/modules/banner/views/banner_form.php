<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Add New Banner </h4>
</div>
<div class="modal-body">
 
 <!-- error div -->
 <div class="alert alert-success success"> </div>
 <div class="alert alert-warning warning"> </div>
 <div class="alert alert-error error"> </div>
 
 <!-- form add -->
<div class="x_panel" >
<div class="x_title">
  
  <div class="clearfix"></div> 
</div>
<div class="x_content">

<form id="upload_form" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="<?php echo $form_action; ?>" 
      enctype="multipart/form-data">
     
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Name </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="tname" class="form-control col-md-7 col-xs-12" type="text" name="tname" required placeholder="Banner Name">
      </div>
    </div>

      <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Position <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
              
              <?php $js = "class='form-control' id='cposition' tabindex='-1' style='width:100%;' "; 
			        echo form_dropdown('cposition', $position, isset($default['position']) ? $default['position'] : '', $js); ?>
          </div>
      </div>
      
      <div class="form-group">
          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Url </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="turl" class="form-control col-md-7 col-xs-12" type="text" name="turl" required placeholder="Banner Url">
          </div>
      </div>
      
      <div class="form-group">
          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Dimension (px) </label>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <input id="twidth" class="form-control col-md-1 col-xs-1" type="number" name="twidth" required placeholder="Width">
            <input id="theight" class="form-control col-md-1 col-xs-1" type="number" name="theight" required placeholder="Height">
          </div>
      </div>
      
      <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"> Front Menu </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            
		<?php $js = "class='select2_multiple form-control' id='cmenu' multiple='multiple' tabindex='-1' style='width:100%;' "; 
             echo form_dropdown('cmenu[]', $menu, $array, $js); ?>
            
            </div>
      </div>

      <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Image </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="file" id="uploadImage" accept="image/*" class="input-medium" title="Upload" name="userfile" /> <br>
          <img id="catimg" style=" max-width:150px; height:auto;">
      </div>
      </div>

      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button">Save</button>
          <button type="button" id="bclose" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" id="breset" class="btn btn-warning">Reset</button>
          </div>
      </div>
  </form> 

</div>
</div>
<!-- form add -->

</div>
    <div class="modal-footer"> </div>
</div>
  
</div>