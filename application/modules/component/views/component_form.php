<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Add New Component </h4>
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
   
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    <input type="text" class="form-control has-feedback-left" id="tname" name="tname" placeholder="Modul Name">
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> 
                  </div>
                  
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    <input type="text" class="form-control has-feedback-left" id="ttitle" name="ttitle" placeholder="Modul Title">
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> 
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Active </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                       TRUE <input name="raktif" class="required" type="radio" value="Y" /> 
                       FALSE <input name="raktif" class="required" type="radio" value="N" />  
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Publish </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                       TRUE <input name="rpublish" class="required" type="radio" value="Y" /> 
                       FALSE <input name="rpublish" class="required" type="radio" value="N" />  
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Status </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <select name="cstatus" class="form-control" title="Status">
                         <option value="user"> User </option>
                         <option value="admin"> Admin </option>
                      </select>
                    </div>
                  </div>
                                      
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Role </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                    
       <?php $js = "class='select2_multiple form-control' id='crole' multiple='multiple' tabindex='-1' style='width:100%;' "; 
	         echo form_dropdown('crole[]', $options, $array, $js); ?>
                    
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    <input type="tel" name="tlimit" class="form-control" id="tlimit" placeholder="Limit">
                  </div>
                  
                   <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    <input type="tel" name="torder" class="form-control" id="torder" placeholder="Order">
                  </div>
                  
      <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Image </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="file" id="uploadImage" accept="image/*" class="input-medium" title="Upload" name="userfile" /> <br>
            <img id="catimg" style=" max-width:50px; height:auto;">
      </div>
      </div>
       
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-primary" id="button">Save</button>
              <button type="button" id="bclose" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="reset" id="breset" class="btn btn-warning">Reset</button>
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