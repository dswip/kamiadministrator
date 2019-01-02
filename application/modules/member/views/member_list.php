<html>
<head>    
<!-- bootstrap basic -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>js/bs/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="<?php echo base_url(); ?>js/bs/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo base_url();?>js-old/register.js"></script>
    
<title> Customer List </title>    
</head>
<body onload="closeWindow()">
  <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 border">
     
    <style type="text/css">
        #example{ font-size: 13px;}
    </style>        
    <?php echo ! empty($table) ? $table : ''; ?>        
                
  <script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>js/bs/datatable/jquery-1.12.4.js"></script>
  <script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>js/bs/datatable/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/bs/datatable/dataTables.bootstrap.min.js"></script>
    
  <script type="text/javascript">

  function closeWindow() {
setTimeout(function() {
window.close();
}, 30000);
}      
      
  $(function(){
    $("#example").dataTable();
  })
  </script>

</div>     
      </div>
    </div>
</body>
</html>