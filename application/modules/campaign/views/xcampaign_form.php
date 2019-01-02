<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Create New Campaign </h4>
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

<form id="upload_form_non" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="<?php echo $form_action; ?>" enctype="multipart/form-data">

      <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> From - Email <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
              <?php $js = "class='form-control' id='cfrom' tabindex='-1' style='width:100%;' "; 
			  echo form_dropdown('cfrom', $email, isset($default['from']) ? $default['from'] : '', $js); ?>
          </div>
      </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> To </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
          <select name="cto[]" id="cto" class="select2_multiple form-control" multiple='multiple' required tabindex='-1' style='width:100%;'>
              <option value="customer"> Customer </option>
              <option value="member"> Member </option>
              <option value="subscriber"> Subscriber </option>
          </select>
      </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Type </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="radio">
           <label> <input type="radio" checked="" value="email" id="rtype1" name="rtype"> Email </label>
           <label> <input type="radio" checked="" value="sms" id="rtype2" name="rtype"> SMS </label>
        </div>
      </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Subject </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" name="tsubject" id="tsubject" required class="form-control" placeholder="Subject">
      </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Category </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <?php $js = "class='form-control' id='ccategory_article' tabindex='-1' style='width:100%;' "; 
        //echo form_dropdown('ccategory', $category_id, isset($default['category']) ? $default['category'] : '', $js); ?>
      </div>
    </div>

    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Article </label>
      <div class="col-md-6 col-sm-6 col-xs-12" id="carticlebox">
        <!-- article combo box -->  
      </div>
    </div>
<!--
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Campaign Date </label>
      <div class="col-md-5 col-sm-5 col-xs-12">
        <input type="text" title="Article Date" class="form-control" id="dtime1" name="tdates" required readonly 
           value="<?php //echo isset($default['date']) ? $default['date'] : '' ?>" />   
      </div>
    </div>
-->

      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button">Save</button>
          <button type="button" id="bclose" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="reset" id="" class="btn btn-warning">Reset</button>
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