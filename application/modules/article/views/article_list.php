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
      	var sites_del  = "<?php echo site_url('product/delete_attribute/');?>";
		
  		$(document).ready(function (e) {
		
            $('#reload').click(function() {
                document.location.reload();
            });


            // delete function

            $(document).on('click','.text-select',function(e){

                e.preventDefault();
                var element = $(this);
                var permalink = element.attr("id");
                $("#turl").val("article/"+permalink+"/");
    //            $("#myModal").modal('hide');
                opener.document.getElementById("turl").value = "article/"+permalink+"/";
                opener.document.getElementById("turl_update").value = "article/"+permalink+"/";
                window.close();
            });
		
		   	
		// document ready end	
        });
  </script>
  
</head>

<body>
        
<!-- Modal content-->
<div class="modal-body">
 
 <!-- form add -->
<div class="x_panel" >
<div class="x_title">
  
  <div class="clearfix"></div> 
</div>
<div class="x_content">
  
    <!-- error div -->
<div class="alert alert-success success"> </div>
<div class="alert alert-warning warning"> </div>
<div class="alert alert-danger error"> </div>

<form id="ajaxform" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="<?php echo $form_action; ?>">
     
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Category </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <?php $js = "class='form-control' id='ccat_list' tabindex='-1' style='width:100%;' "; 
           echo form_dropdown('ccategory', $category, isset($default['category']) ? $default['category'] : '', $js); ?>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Language </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <?php $js = "class='form-control' id='clang_list' tabindex='-1' style='width:100%;' "; 
           echo form_dropdown('clang', $language, isset($default['language']) ? $default['language'] : '', $js); ?>
        </div>
    </div>
    
      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary"> Search </button>
          <a class="btn btn-danger" href="<?php echo site_url('article/article_list'); ?>"> Reset </a>
          </div>
      </div>
  </form> 
	
  <div class="table-responsive">
      <?php echo ! empty($table) ? $table : ''; ?>     
  </div>

    
</div>
</div>
<!-- form add -->

</div>
</body>
</html>