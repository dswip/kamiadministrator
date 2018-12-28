<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#252525">
	
	<title>Delica Calculator - User Guide</title>
	
    <link rel="icon" href="icon.png">
    
	<link rel="stylesheet" href="css/style.css">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <!-- Add fancyBox -->
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css">
    
    <style>
		body {
			background-color: black;
		}
	</style>

    
</head>

<body>

<!-------------HEADER----------------->
<?php include 'includes/header.php';?>
<!-------------/HEADER---------------->


<div class="container-fluid" id="main">
    <div class="col-md-12">
        <h2 class="ff2 mid mbtm">Dashboard</h2>
        <p class="ff" style="text-indent:40px;font-size: 18px;">Halaman utama pada web user guide.</p>
    </div>
    
    <div class="col-md-8">
        <a href="screenshots/1dashboard/1.PNG" data-fancybox data-caption="Dashboard"><img src="screenshots/1dashboard/1.PNG" alt="" class="img-responsive"></a>
    </div>
    
	<div class="col-md-12 mtop">
		<span class="ff" style="font-size: 18px;">
			<ol>
			    <li>Pilihan Menu pada Dashboard.</li>
                <ul>
                	<li>Article</li>
                	<li>Setting</li>
                	<li>Admin Menu</li>
					<li>Front Menu</li>
					<li>User</li>
					<li>Product</li>
               		<li>History</li>
               		<li>Component</li>
               		<li>Widget</li>
               		<li>Configuration</li>
                </ul>
			</ol>
		</span>
	</div>
</div>

<div class="container mtop mbtm2">
	<a href="article" class="cbutton ff2" style="float:right;"><span>Next</span></a>
</div>


<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery.fancybox.min.js"></script>


<script>
$('[data-fancybox]').fancybox({
  buttons : [
	'zoom',
	'close'
  ]
});	
</script>

<?php $page = 'dashboard'; ?>
</body>
</html>