<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Campaign Confirmation </h4>
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

<form id="edit_form_non" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="<?php echo $form_action_confirmation; ?>" 
      enctype="multipart/form-data">
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Confirm Date </label>
      <div class="col-md-4 col-sm-12 col-xs-12">
  <input id="dtime1" class="form-control col-md-7 col-xs-12" type="text" name="tcdates" required>
      </div> 
    </div>
      
      <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Status </label>
      <div class="col-md-3 col-sm-12 col-xs-12">
          <select name="cstts" id="cstts" class="form-control">
              <option value="1"> Confirm </option>
              <option value="0"> Unconfirm </option>
          </select>
      </div>
      </div>

      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-7 col-sm-7 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button"> Publish </button>
          <button type="button" id="bclose" class="btn btn-danger" data-dismiss="modal"> Close </button>
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