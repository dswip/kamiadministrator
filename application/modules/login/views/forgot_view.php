<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="shortcut icon" href="<?php echo base_url().'images/fav_icon.png';?>" />
	<title> Login </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
        
    <style type="text/css">@import url("<?php echo base_url() . 'css/login.css'; ?>");</style>
    <script type="text/javascript" src="<?php echo base_url().'js/jquery.min.js'; ?>"></script>
    
    <!-- sweet alert js -->
    <script type="text/javascript" src="<?php echo base_url().'js/sweetalert/sweetalert.min.js'; ?>"></script>
    <style type="text/css">@import url("<?php echo base_url() . 'js/sweetalert/sweetalert.css'; ?>");</style>
    
</head>

<script type="text/javascript">

$(document).ready(function (e) {
	
	
	
	$('#user').keypress(function (e) {
	 var key = e.which;
	 if(key == 13)  // the enter key code
	  {
        $('#loginbutton').click(); 
	  }
	});   
	
	$('#loginbutton').click(function() 
	{
		var user = $("#user").val();
		
		if (user != "")
		{
			var nilai = '{ "user":"'+user+'" }';
				
			$.ajax({
				type: 'POST',
                url: '<?php echo site_url('login/send_password'); ?>',
				data : nilai,
			    contentType: "application/json",
                dataType: 'json',
				success: function(data) 
			    {
					if (data.Success == true){ swal(data.Info, "", "success"); }
					else{ swal(data.Info, "", "error"); }
				}
			}) 
			return false;
			
		}
		else{ swal("Invalid Username / Email..!!", "", "error"); }
		
	});


// document ready end	
});

</script>

<body>

<form name="login_form" id="loginform" method="post">
<div class="containerx">
<img src="<?php echo $logo; ?>" alt="<?php echo $pname; ?>" class="logo">


<div class="txt_field">
	<i class="fa fa-user"></i>
	<input type="text" name="username" id="user" class="txt" required placeholder="email">
	<div class="clr"> </div>
</div>

<div class="btn">
	<button type="button" id="loginbutton"> Reset Password </button> <br>
    <p style="margin:5px 0 0 0; float:left;"> <a id="forgot" href="<?php echo site_url('login'); ?>"> [ Back Login ] </a> </p>
    <p>&copy; Copyrights <?php echo $pname.'&nbsp;'.date('Y'); ?>. <br>All rights reserved.</p>
</div>
	
</div>
</form>

</body>

<style type="text/css">

  #forgot{ color:#000; font-size:12px; text-decoration:none; }
  #forgot:hover { text-decoration:underline; }

</style>

</html>