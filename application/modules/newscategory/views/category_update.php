<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> Category - Update </h4>
        </div>
        
 <div class="modal-body"> 
 
 <!-- error div -->
 <div class="alert alert-success success"> </div>
 <div class="alert alert-warning warning"> </div>
 <div class="alert alert-error error"> </div>

 <!-- form edit -->
 <form id="edit_form_non" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
 action="<?php echo $form_action_update; ?>" enctype="multipart/form-data">
     
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Name </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="tname_update" readonly class="form-control col-md-7 col-xs-12" type="text" name="tname" placeholder="Category Name">
        <input type="hidden" id="tid_update" name="tid_update">
      </div>
    </div>

      <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Parent <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <?php $js = "class='select2_single form-control' tabindex='-1' style='width:100%;' id='cparent_update' "; 
			        echo form_dropdown('cparent', $parent, isset($default['parent']) ? $default['parent'] : '', $js); 
			   ?>
          </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Description </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
         <textarea name="tdesc" id="tdesc_update" class="form-control" rows="3" placeholder="Description"></textarea>
        </div>
      </div>

      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button">Save</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
      </div>
  </form> 
  <!-- form edit -->
  
  </div>
 </div>
</div>