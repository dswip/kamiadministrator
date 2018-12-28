

<div id="webadmin">

	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div id="errorbox" class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<form name="search_form" class="myform" id="form" method="post" action="<?php echo $form_action; ?>" enctype="multipart/form-data">
		<fieldset class="field"> <legend> Create Article </legend>
			
			<table width="auto">
			  <tr> <td> <span class="label">Category</span> </td> <td> : &nbsp; </td> 
			  <td> <?php echo form_dropdown('ccategory', $category, isset($default['category']) ? $default['category'] : ''); ?> <br/> </td>  </tr>
			  
			   <tr> <td> <span class="label"> Language </span> </td> <td>:</td> 
			   <td> <?php echo form_dropdown('clang', $language, isset($default['lang']) ? $default['lang'] : ''); ?> <br/> </td>  </tr>
			   
			   <tr> <td> <span class="label"> Permalink </span> </td> <td>:</td> 
			   <td>  <input type="text" readonly="readonly" class="required input-large" name="tpermalink" id="tpermalink" title="News Permalink - max 20 character" size="30" 
			         value="<?php echo set_value('tpermalink', isset($default['permalink']) ? $default['permalink'] : ''); ?>" /> <br /> 
			   </td></tr>
			  
				<tr> <td> <span class="label"> Title </span> </td> <td>:</td> 
				<td>  <input type="text" class="required input-large" name="ttitle" title="News Title - max 100 character" size="45" maxlength="100" onkeyup="setpermalink(this.value)" value="<?php echo set_value('ttitle', isset($default['title']) ? $default['title'] : ''); ?>" /> <br /> </td></tr>		
							
				<tr> <td> <span class="label"> Date </span></td> <td>:</td> 
				<td> 
					<div id="datetimepicker" class="input-append date">
					  <input type="text" name="tdate" readonly="readonly" class="input-small"></input>
					  <span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i> </span>
					</div>
				</td> </tr>
				
				<tr> <td> <span class="label">Commented <br /> Front Page</span> </td> <td>:</td> 
				<td> <input type="checkbox" name="ccoment" title="Tick checkbox if regulated as commented" value="1" <?php echo set_radio('ccoment', '1', isset($default['coment']) && $default['coment'] == '1' ? TRUE : FALSE); ?> /> &nbsp; - &nbsp; <input type="checkbox" name="cfront" title="Tick checkbox if regulated as front" value="1" <?php echo set_radio('cfront', '1', isset($default['front']) && $default['front'] == '1' ? TRUE : FALSE); ?> /> <br /> </td>
				
				<tr> <td> <span class="label"> Image </span> </td> <td>:</td> 
				<td> <input type="file" class="input-medium" title="Upload image" name="userfile"  /> <br /> <?php echo isset($error) ? $error : '';?> </td> </tr>
			</table>
		</fieldset>
		
		<fieldset class="field"> <legend>News Content</legend>
		<textarea name="tdesc" id="content" >  </textarea>
		<?php echo display_ckeditor($ckeditor); ?> <br />

		<p>
			<input type="submit" name="submit" class="btn" title="Klik tombol untuk proses data" value=" Save " />
			<input type="reset" name="reset" class="btn" title="Klik tombol untuk proses data" value=" Cancel " />
		</p>
		</fieldset>
		
	</form>	
</div>

<script type="text/javascript">
      $('#datetimepicker').datetimepicker({
        format: 'yyyy-MM-dd'
      });
</script>

<div class="buttonplace"> <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?> </div>


<!-- batas -->