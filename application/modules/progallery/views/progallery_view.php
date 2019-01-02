	
<div id="webadmin">
	
	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div id="errorbox" class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<fieldset class="field"> <legend> Product Description </legend>
	<form name="modul_form" class="myform" id="form" method="post" action="<?php echo $form_action; ?>">
		<table>
		
			<tr> 					
				<td> Color Name </td> <td>: &nbsp;</td>
                <td> <input type="text" name="tname" class="input-xlarge"
				     value="<?php echo set_value('tname', isset($default['name']) ? $default['name'] : ''); ?>" required /> </td>
			</tr>
			
			<tr>					
			    <td> Thumbnail (Url) </td> <td>:</td> <td> 
<textarea name="tthumb" class="required input-xlarge" rows="3" cols="55" required><?php echo set_value('tthumb', isset($default['thumb']) ? $default['thumb'] : ''); ?></textarea>
<br /> <img src="<?php echo set_value('tthumb', isset($default['thumb']) ? $default['thumb'] : ''); ?>" width="100" height="100" alt="" />
    </td>	
			</tr>
			
			<tr>					
			    <td> Image (Url) </td> <td>:</td> <td> 
<textarea name="timage" class="required input-xlarge" rows="3" cols="55" required><?php echo set_value('timage', isset($default['image']) ? $default['image'] : ''); ?></textarea>
<br /> <img src="<?php echo set_value('timage', isset($default['image']) ? $default['image'] : ''); ?>" width="100" height="100" alt="" /> 
			   </td>	
			</tr>
			
			<tr>
				<td></td> 
				 <td colspan="3"> 
				   <br /> <input type="submit" name="submit" class="btn" title="" value="Save" /> 
				          <input type="reset" name="reset" class="btn" title="" value="Cancel" />  
				 </td>
			</tr>
			
		</table>	
	</form>			  
	</fieldset>
	
</div>


<div id="webadmin2">
	
	<form name="search_form" class="myform" method="post" action="<?php echo ! empty($form_action_del) ? $form_action_del : ''; ?>">
      <?php echo ! empty($table) ? $table : ''; ?>
	  <div class="paging"> <?php echo ! empty($pagination) ? $pagination : ''; ?> </div>
	</form>	
		
	<!-- links -->
	<div class="buttonplace"> <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?> </div>

	
</div>

