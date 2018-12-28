<div id="webadmin">
	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<fieldset class="field"> <legend> Create Component </legend>
			<form name="modul_form" id="form" class="myform" method="post" action="<?php echo $form_action; ?>" enctype="multipart/form-data">
				<table>
				
					<tr> <td> <span class="label"> Name / Title </span> </td> <td>: &nbsp;</td> 
					<td> <input type="text" class="input-large" name="tname" title="Type Modul Name" required /> &nbsp; - &nbsp; 
					<input type="text" class="input-large" name="ttitle" title="Type Modul Title" required /> <br />
					</td>
				  </tr>
					
					<tr> <td> <span class="label">Publish </span> </td> <td>:</td> 
					<td> Yes <input name="rpublish" class="required" type="radio" value="Y" /> 
					     No <input name="rpublish" class="required" type="radio" value="N" />  <br/>  <br/>
					</td> 
				    </tr>
					
					<tr> <td><span class="label">Status</span></td> <td>:</td> 
						 <td>
			  <select name="cstatus" class="required input-small" title="Status">
				 <option value="user" <?php echo set_select('cstatus', 'user', isset($default['status']) && $default['status'] == 'user' ? TRUE : FALSE); ?> /> User </option>
				 <option value="admin" <?php echo set_select('cstatus', 'admin', isset($default['status']) && $default['status'] == 'admin' ? TRUE : FALSE); ?> /> Admin </option>
			  </select> <br />  
						 </td>  </tr>
						 
					<tr> <td> <span class="label">Active</span> </td> <td>:</td> 
					   <td> Yes <input name="raktif" class="required" type="radio" value="Y" /> 
					        No <input name="raktif" class="required" type="radio" value="N" />  <br/>  <br/>  
					   </td> 
				    </tr>
					
				<tr> <td> <span class="label"> Limit </span></td> <td>:</td> 
				     <td> <input type="text" class="required input-small" name="tlimit" id="tlimit" size="2" maxlength="3" onkeyup="checkdigit(this.value, 'tlimit')" required />                          <br />  </td>  </tr>
					
				<tr> <td><span class="label">Role</span></td> <td>:</td> <td> 				
				<?php $js = 'class="required input-medium", size="6" '; echo form_dropdown('crole[]', $options, $array, $js); ?>
				</td> </tr> 
				
				<tr> <td> <span class="label"> Order </label></td> <td>:</td> 
				     <td> <input type="text" class="required input-small" name="torder" id="torder" size="2" maxlength="3" onkeyup="checkdigit(this.value, 'torder')" required /> 
				     <br />  </td>  </tr>
				
				<tr> <td><span class="label"> Image </span> </td> <td>:</td> 
 				<td> <img width="250" height="170" src="<?php echo set_value('tket', isset($default['image']) ? $default['image'] : ''); ?>" 
				title="<?php echo set_value('tket', isset($default['image']) ? $default['image'] : ''); ?>"> </td> </tr>
				
				<tr> <td> <span class="label">Change image</span> </td> <td>:</td> <td> 
				<input type="file" class="input-large" title="Upload image" name="userfile" /> <br /> 
				<?php echo isset($error) ? $error : ''; ?> <small>*) Leave it blank if not upload images.</small> </td> </tr>
				
				</table> <br />  
			<p>
				<input type="submit" name="submit" class="btn"  value=" Save " />
				<input type="reset" name="reset" class="btn"  value=" Cancel " />
			</p>
		  </form>
	</fieldset>
</div>

<div id="webadmin2">
	
    <form name="search_form" class="myform" method="post" action="<?php echo $form_action_del; ?>">
     <?php echo ! empty($table) ? $table : ''; ?>
	 <div class="paging"> <?php echo ! empty($pagination) ? $pagination : ''; ?> </div>
	 <p class="cek"> <?php echo ! empty($radio1) ? $radio1 : ''; echo ! empty($radio2) ? $radio2 : ''; ?> <input type="submit" name="button" class="button_delete" title="Process Button" value="Delete All" />  </p> 
	</form>	
	
	<!-- links -->
	<div class="buttonplace"> <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?> </div>
</div>



<!-- batas -->

