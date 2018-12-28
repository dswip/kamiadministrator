<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="<?php echo base_url().'images/'; ?>fav_icon.png" >
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title> <?php echo isset($title) ? $title : '' ; ?> </title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link type="text/css" media="all" href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet" />
	  <!-- CUSTOM STYLE  -->
    <link type="text/css" media="all" href="<?php echo base_url(); ?>css/receipt/custom-style.css" rel="stylesheet" />
    
    <style type="text/css">
        .border{ border: 1px solid #CCC;}
        .tables tr { line-height: 16px; }
    </style>

</head>
<body>
 <div class="container">
     
     <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
             <?php echo isset($content) ? $content : ''; ?>
         </div>
     </div>

 </div>

</body>
</html>
