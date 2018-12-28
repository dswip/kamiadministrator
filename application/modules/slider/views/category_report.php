<script type="text/javascript">

$(document).ready(function (e) {
	
	$("#breset").click(function(){
	
	  document.getElementById('tname').value = '';
	  document.getElementById("preview").innerHTML = "";
	  document.getElementById("uploadImage").value = "";
	  
	});
	
	// document ready end	
});

</script>

<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Category Report </h4>
</div>
<div class="modal-body">
 
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
        <input id="tname" class="form-control col-md-7 col-xs-12" type="text" name="tname" required placeholder="Category Name">
      </div>
    </div>

      <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Parent <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
              
              <?php $js = "class='select2_single form-control' id='cparent' tabindex='-1' style='width:100%;' "; 
			        echo form_dropdown('cparent', $parent, isset($default['parent']) ? $default['parent'] : '', $js); ?>
              
          </div>
      </div>


      <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Image </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="file" id="uploadImage" accept="image/*" class="input-medium" title="Upload" name="userfile" /> <br>
          <div style="margin:10px;" id="preview"><img src="" /></div>
      </div>
      </div>

      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-success" id="button">Save</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          <button type="button" id="breset" class="btn btn-primary">Reset</button>
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