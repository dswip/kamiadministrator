<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Edit User </h4>
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

 <form id="edit_form_non" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
 action="<?php echo $form_action_update; ?>" enctype="multipart/form-data">
   
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    <input type="text" class="form-control has-feedback-left" id="tname_update" name="tname" placeholder="Name">
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> 
                    <input type="hidden" id="tid_update" name="tid">
                  </div>
                    
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    <input type="email" class="form-control" id="tmail_update" name="tmail" placeholder="Email">
                    <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span> 
                  </div>
                  
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
     <input type="text" class="form-control has-feedback-left" readonly id="tusername_update" required name="tusername" placeholder="Username">
     <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> 
                  </div>
                  
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
     <input type="password" class="form-control" id="tpassword_update" name="tpassword" placeholder="Password">
                    <span class="fa fa-key form-control-feedback right" aria-hidden="true"></span> 
                  </div>
                  
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    <?php $js = "class='select2_single form-control' id='ccity_update' tabindex='-1' style='width:100%;' "; 
			        echo form_dropdown('ccity', $city, isset($default['city']) ? $default['city'] : '', $js); ?>
                  </div>
                  
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    <input type="tel" name="tphone" class="form-control" id="tphone_update" placeholder="Phone">
                    <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> 
                  </div>
                  
                  <!-- pembatas div -->
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">  
                  </div> 
                   <!-- pembatas div -->
                  
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Role </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <?php $js = "class='select2_single form-control' id='crole_update' tabindex='-1' style='width:100%;' "; 
			           echo form_dropdown('crole', $roles, isset($default['role']) ? $default['role'] : '', $js); ?>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Status </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
	                        TRUE <input name="rstatus" class="required" id="rstatus1" type="radio" value="1" /> 
							FALSE <input name="rstatus" class="required" id="rstatus0" type="radio" value="0" />  
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Address </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
<textarea name="taddress" id="taddress_update" class="form-control" rows="3" placeholder="Address"><?php echo set_value('taddress', isset($default['address']) ? $default['address'] : ''); ?></textarea>
                    </div>
                  </div>
                  
                  
                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                      <button type="submit" class="btn btn-primary" id="button">Save</button>
                      <button type="button" id="bclose" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="button" id="breset" class="btn btn-warning" onClick="reset();">Reset</button>
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