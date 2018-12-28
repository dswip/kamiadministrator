<!doctype html>
<html>
<head>
<meta charset="utf-8">
  <style type="text/css">@import url("<?php echo base_url() . 'css/bootstrap.min.css'; ?>");</style>
  <style type="text/css">@import url("<?php echo base_url() . 'fonts/css/font-awesome.min.css'; ?>");</style>
  <style type="text/css">@import url("<?php echo base_url() . 'css/select/select2.min.css'; ?>");</style>
  
  <script src="<?php echo base_url();?>js/jquery.min.js"></script>
  <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
  
  <style type="text/css">
  	.success,.warning,.error{ display:none;}
  </style>
  
  <script type="text/javascript">
      	var sites_del  = "<?php echo site_url('product/delete_image/');?>";
		
  		$(document).ready(function (e) {
		   
		   $('#ajaxform').submit(function() {
			$.ajax({
				type: 'POST',
				url: $(this).attr('action'),
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(data) {
					
					res = data.split("|");
					console.log(res[0]);
					if (res[0] == "true")
					{   $('#breset,#reload').click();
						$(".success").html(res[1]).fadeIn(); setTimeout(function() { $(".success").fadeOut(); }, 3000); 
					}
			  else if (res[0] == 'warning'){ $(".warning").html(res[1]).fadeIn(); setTimeout(function() { $(".warning").fadeOut(); }, 3000);  }
			  else{ $(".error").html(res[1]).fadeIn(); setTimeout(function() { $(".error").fadeOut(); }, 3000); }
				}
			})
			return false;
		});
		
		$('#reload').click(function() {
			document.location.reload();
		});
		
		
		// delete function
		
		$(document).on('click','.text-danger',function(e){
	
			e.preventDefault();
			
			var element = $(this);
			var del_id = element.attr("id");
			
			  $.ajax({
				type: 'POST',
				url: sites_del +"/"+ del_id,
				data: $(this).serialize(),
				success: function(data)
				{
					res = data.split("|");
					console.log(res[0]);
					if (res[0] == "true")
					{   $('#breset,#reload').click();
						$(".success").html(res[1]).fadeIn(); setTimeout(function() { $(".success").fadeOut(); }, 3000); 
					}
			  else if (res[0] == 'warning'){ $(".warning").html(res[1]).fadeIn(); setTimeout(function() { $(".warning").fadeOut(); }, 3000);  }
			  else{ $(".error").html(res[1]).fadeIn(); setTimeout(function() { $(".error").fadeOut(); }, 3000); }
				}
				})
				return false; 
	      });
		
		   	
		// document ready end	
        });
  </script>
  
</head>

<body>

<!-- error div -->
<div class="alert alert-success success"> </div>
<div class="alert alert-warning warning"> </div>
<div class="alert alert-danger error"> </div>

<form id="ajaxform" data-parsley-validate class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data"
      action="<?php echo $form_action; ?>">
     
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Name </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <select class="form-control" name="cname" id="cname">
            <option value="1"> Image 1 </option> <option value="2"> Image 2 </option> <option value="3"> Image 3 </option>
            <option value="4"> Image 4 </option> <option value="5"> Image 5 </option>
          </select>
        </div>
    </div>
    
     <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Value / Url </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
		   <input type="file" id="uploadImage" accept="image/*" class="input-medium" title="Upload" name="userfile" /> <br>
        </div>
    </div>
    
      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary">Post</button>
          <button type="reset" id="breset" class="btn btn-danger"> Reset </button>
          <button type="button" id="reload" class="btn btn-success"> Reload </button>
          </div>
      </div>
  </form> 
	
  <div class="table-responsive">
      <?php echo ! empty($table) ? $table : ''; ?>     
  </div>
    
</body>
</html>


