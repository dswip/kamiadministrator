se<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Edit Admin Menu </h4>
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
   
   				  <div class="form-group">
   				  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Name </label>
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    <input type="text" class="form-control" id="tname_update" name="tname" placeholder="" required>
                    <input type="hidden" id="tid_update" name="tid">
                  </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Component </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                     <?php $js = "class='select2_single form-control' id='cmodul_update' onChange=\"geturl(this.value, 'turl_update')\" tabindex='-1' style='width:100%;' ";
echo form_dropdown('cmodul', $modul, isset($default['modul']) ? $default['modul'] : '', $js); ?>
                    </div>
                  </div>   
                  
                  <div class="form-group">
   				  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Url </label>
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
     <input type="text" class="form-control" id="turl_update" name="turl" placeholder="Url">
                  </div>
                  </div>
                  
                  <div class="form-group">
   				  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Menu Order </label>                
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
<input type="number" class="form-control" name="tmenuorder" id="tmenuorder_update" title="Menu Order" placeholder="" />
                  </div>
                  </div>
                  
                  <div class="form-group">
   				  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Class </label>
                 <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
<input type="text" class="form-control" name="tclass" id="tclass_update" title="Class Style" placeholder="" />
                  </div>
                  </div>
                  
                  <div class="form-group">
   				  <label class="control-label col-md-3 col-sm-3 col-xs-12"> ID </label>
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
<input type="text" class="form-control" name="tid" id="tidstyle_update" title="ID Style" placeholder="" />
                  </div>
                  </div>
                   
                   <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Parent </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <?php $js = "class='select2_single form-control' id='cparent_update' tabindex='-1' style='width:100%;' "; 
	                  echo form_dropdown('cparent', $parent, isset($default['parent']) ? $default['parent'] : '', $js); ?>
                    </div>
                  </div>
                  
                  
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Target </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                     <select name="ctarget" id="ctarget_update" class="form-control" title="Target">
                      <option value="_parent"> Parent </option>
                      <option value="_blank"> Blank </option>
                      <option value="_self"> Self </option>
                      <option value="_top"> Top </option>
                    </select>
                    </div>
                  </div>   
                  
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Parent Status </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                    <select name="cstatus" id="cstatus_update" class="form-control" title="Target">
                          <option value="0"> Child </option>
                          <option value="1"> Parent </option>
                     </select>
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