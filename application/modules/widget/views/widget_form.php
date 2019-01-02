<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Add New Widget </h4>
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

<form id="upload_form_non" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="<?php echo $form_action; ?>" 
      enctype="multipart/form-data">
   
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    <input type="text" class="form-control has-feedback-left" id="tname" name="tname" required placeholder="Name">
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> 
                  </div>
                    
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    <input type="text" class="form-control" id="ttitle" name="ttitle" required placeholder="Title">
                    <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span> 
                  </div>
                  
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                  	<?php $js = "class='select2_single form-control' id='cposition' tabindex='-1' style='width:100%;' "; 
			        echo form_dropdown('cposition', $position, isset($default['position']) ? $default['position'] : '', $js); ?>	
                    <span class="fa fa-key form-control-feedback right" aria-hidden="true"></span> 					
                  </div>
                  
                  <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                    <input type="text" class="form-control" id="torder" name="tmenuorder" required placeholder="Order">
                    <span class="fa fa-key form-control-feedback right" aria-hidden="true"></span> 
                  </div>
                  
                  <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                    <input type="text" class="form-control" id="tlimit" name="tlimit" required placeholder="Limit">
                    <span class="fa fa-key form-control-feedback right" aria-hidden="true"></span> 
                  </div>
                  
                  <!-- pembatas div -->
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    
                  </div>
                   <!-- pembatas div -->
                  
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Publish </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
	                        TRUE <input name="rpublish" class="required" type="radio" value="1" /> 
							FALSE <input name="rpublish" class="required" type="radio" value="0" />  
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-md-9 col-sm-3 col-xs-12"> Menu </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                  <?php $js = "class='select2_multiple form-control' id='cmenu' multiple='multiple' tabindex='-1' style='width:100%;' "; 
	              echo form_dropdown('cmenu[]', $menu, $array, $js); ?>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-md-9 col-sm-3 col-xs-12"> More </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                  <?php $js = "class='select2_single form-control' id='cmore' tabindex='-1' style='width:100%;' "; 
			      echo form_dropdown('cmore', $menu, isset($default['more']) ? $default['more'] : '', $js); ?>
                    </div>
                  </div>
                  
                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                      <button type="submit" class="btn btn-primary" id="button">Save</button>
                      <button type="button" id="bclose" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="reset" id="breset" class="btn btn-warning" onClick="resets()">Reset</button>
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