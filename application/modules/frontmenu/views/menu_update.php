se<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Edit Front Menu </h4>
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Parent </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php $js = "class='select2_single form-control' id='cparent_update' tabindex='-1' style='width:100%;' "; 
	                  echo form_dropdown('cparent', $parent, isset($default['parent']) ? $default['parent'] : '', $js); ?>
                    </div>
                  </div>
     
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"> Position </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              
<input name="rposition" id="rposition0" type="radio" title="Menu Position" class="required"  value="top"    
<?php echo set_radio('rposition', 'top',    isset($default['position']) && $default['position'] == 'top' ? TRUE : FALSE); ?> /> Top <br/>
<input name="rposition" id="rposition1" type="radio" title="Menu Position" class="required"  value="middle" <?php echo set_radio('rposition', 'middle', isset($default['position']) && $default['position'] == 'middle' ? TRUE : FALSE); ?> /> Middle <br/>
<input name="rposition" id="rposition2" type="radio" title="Menu Position" class="required"  value="bottom" <?php echo set_radio('rposition', 'bottom', isset($default['position']) && $default['position'] == 'bottom' ? TRUE : FALSE); ?> /> Bottom <br/>
                
            </div>
          </div> 
                  
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Type </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
<select name="ctype" class="form-control" id="ctypefrontupdate" class="required" title="Type"> 
<option value="modul" <?php echo set_select('ctype', 'modul', isset($default['type']) && $default['type'] == 'modul' ? TRUE : FALSE); ?> >modul</option> 
<option value="article" <?php echo set_select('ctype', 'article', isset($default['type']) && $default['type'] == 'article' ? TRUE : FALSE); ?> >article</option> 
<option value="articlelist" <?php echo set_select('ctype', 'articlelist', isset($default['type']) && $default['type'] == 'articlelist' ? TRUE : FALSE); ?> >article list</option> 
<option value="url" <?php echo set_select('ctype', 'url', isset($default['type']) && $default['type'] == 'url' ? TRUE : FALSE); ?> >url</option> 
</select>              
                    </div>
                  </div>   
     
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"> Value </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <?php echo $tombol2; ?>    
              <div id="valueplace_update"></div>             
            </div>
          </div>   
           
                  <div class="form-group">
   				  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Url </label>
                  <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
     <input type="text" class="form-control" id="turl_update" name="turl" placeholder="Url">
                  </div>
                  </div>
     
                  <div class="form-group">
   				  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Limit </label>
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
     <input type="number" class="form-control" id="tlimit_update" name="tlimit" placeholder="Limit">
                  </div>
                  </div>
                  
                  <div class="form-group">
   				  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Menu Order </label>                
                  <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
<input type="number" class="form-control" name="tmenuorder" id="tmenuorder_update" title="Menu Order" placeholder="" />
                  </div>
                  </div>
                  
                  <div class="form-group">
   				  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Class </label>
                 <div class="col-md-5 col-sm-5 col-xs-12 form-group has-feedback">
<input type="text" class="form-control" name="tclass" id="tclass_update" title="Class Style" placeholder="" />
                  </div>
                  </div>
                  
                  <div class="form-group">
   				  <label class="control-label col-md-3 col-sm-3 col-xs-12"> ID </label>
                  <div class="col-md-5 col-sm-5 col-xs-12 form-group has-feedback">
<input type="text" class="form-control" name="tid" id="tidstyle_update" title="ID Style" placeholder="" />
                  </div>
                  </div>
                   
                   
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"> Target </label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                     <select name="ctarget" id="ctarget_update" class="form-control" title="Target">
                      <option value="_parent"> Parent </option>
                      <option value="_blank"> Blank </option>
                      <option value="_self"> Self </option>
                      <option value="_top"> Top </option>
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