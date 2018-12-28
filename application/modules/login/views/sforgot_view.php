<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?php echo base_url().'images/fav_icon.png';?>" />
<style type="text/css">@import url("<?php echo base_url() . 'css/login.css'; ?>");</style>
<script type="text/javascript" src="<?php echo base_url(); ?>js/register.js"></script>
<title>Login</title>
</head>
<body>

	<div class="container_12">
			
			<div class="grid_12" id="container">
				
				<div class="grid_12" id="loginplace">
					
					<div id="logos" style="margin: 15px 0 0 335px;"> <img align="middle" width="300" height="150" src="<?php echo $logo; ?>" alt="<?php echo $pname; ?>" /> </div> 
					<div class="clear"></div>
				
					<div id="loginbox">
						<fieldset class="field">
						<p style="text-align:center; font-weight:bolder; "> Web base ERP System - Forgot Password </p>
						<form action="<?php echo $form_action; ?>" name="login_form" id="login_form" method="post" onsubmit="return login();">  
							<table style="margin-left:35px; ">
		<tr> <td> <label for="username">Username</label>  </td> <td>:</td> <td> <input type="text" name="username" id="user" size="20" class="form_field"/> <br /> </td> </tr>
		<tr> <td colspan="3"> <input type="submit" name="submit" class="button" value="Send Email"/> <input type="reset" name="reset" class="button" value="Reset"/> </td> </tr>
							</table>
					  </form>
					  <a href="<?php echo base_url()."index.php/login"; ?>"> [ Back Login ] </a>
					  </fieldset>
					  <?php
						$message = $this->session->flashdata('message');
						echo $message == '' ? '' : '<p class="field_error">' . $message . '</p>';
					  ?>
				    </div>
					
					<div id="descbox">
						<p style="font-size:11px; color:#333333; text-align:left; font-family:Verdana, Arial, Helvetica, sans-serif; "> 
							This is a secure service that is only given to the appropriate authorities. <br />
							Username is the email address you have registered as a user ID to login
							and password provided separately via email.
						</p>
						
						<p style="font-size:11px; color:#333333; text-align:left; font-family:Verdana, Arial, Helvetica, sans-serif; ">
							If you experience any difficulties in accessing this service please contact your Administrator or Manager. 
						</p>
					</div>
					
					<div id="footer">
						<p> Copyright &copy; <?php echo date('Y').' '.$pname; ?> </p>
					</div>
					
				</div>			
									
        	</div>
	</div>

</body>
</html>
