<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Product Assembly </h4>
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

<form id="upload_form_non" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
action="<?php echo $form_action_assembly; ?>">
     
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Product </label>
        <div class="col-md-6 col-sm-9 col-xs-12">
          <input type="text" readonly id="tname_update" class="form-control">
          <input type="hidden" id="tid_update" name="tid">
        </div>
    </div>
    
     <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Material </label>
        <div class="col-md-7 col-sm-9 col-xs-12">
     <?php $js = "class='select2_multiple form-control' id='cmaterial_update' multiple='multiple' tabindex='-1' style='width:100%;' "; 
     echo form_dropdown('cmaterial[]', $material, $array, $js); ?>     
        </div>
    </div>

      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 btn-group">
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