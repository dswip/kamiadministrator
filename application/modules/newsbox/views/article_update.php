

<div id="webadmin">

	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div id="errorbox" class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<form name="search_form" class="myform" id="form" method="post" action="<?php echo $form_action; ?>" enctype="multipart/form-data">
		<fieldset class="field"> <legend> News Box </legend>
			<table border="0">
			  
				<tr> <td> <label for="ttitle">Title</label> </td> <td>:</td> <td>  
				<input type="text" name="ttitle" title="News Title - max 100 character" size="45" maxlength="100" required 
				value="<?php echo set_value('ttitle', isset($default['title']) ? $default['title'] : ''); ?>" /> <br /> </td></tr>		
				
			</table>
		</fieldset>
		
		<fieldset class="field"> <legend>News Content</legend>

			<textarea name="tdesc" id="content" required > <?php echo isset($desc) ? $desc : ''; ?> </textarea>
		    <?php echo display_ckeditor($ckeditor); ?> <br />
			
			<p>
				<input type="submit" name="submit" class="btn"  value=" Save " />
				<input type="reset" name="reset" class="btn" value=" Cancel " />
			</p>
		</fieldset>
	</form>	
</div>



<!-- batas -->