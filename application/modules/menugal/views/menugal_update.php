<style type="text/css">@import url("<?php echo base_url() . 'css/style.css'; ?>");</style>
<style type="text/css">@import url("<?php echo base_url() . 'development-bundle/themes/base/ui.all.css'; ?>");</style>
<style type="text/css">@import url("<?php echo base_url() . 'css/jquery.fancybox-1.3.4.css'; ?>");</style>

<script type="text/javascript" src="<?php echo base_url();?>js/register.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/datetimepicker_css.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/development-bundle/ui/ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.tools.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/hoverIntent.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.fancybox-1.3.4.pack.js"></script>
<!--<script type="text/javascript" src="<?php //echo base_url();?> js/complete.js"></script> -->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/sortir.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/validate.js"></script> 
<script type='text/javascript' src='<?php echo base_url();?>js/jquery.validate.js'></script>  

<script type="text/javascript">
var uri = "<?php echo site_url('ajax')."/"; ?>";
var baseuri = "<?php echo base_url(); ?>";
</script>


<div id="webadmin">
	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<fieldset class="field"> <legend> Update Component </legend>
			<form name="modul_form" id="form" class="form" method="post" action="<?php echo $form_action; ?>" enctype="multipart/form-data">
				<table>
				
					<tr> <td>
					<label for="tname"> Name / Title </label>
					</td> <td>:</td> <td> <input type="text" class="required" name="tname" size="30" title="Type Modul Name" 
					value="<?php echo set_value('tname', isset($default['name']) ? $default['name'] : ''); ?>" /> &nbsp; - &nbsp; 
					<input type="text" class="required" name="ttitle" size="30" title="Type Modul Title" 
					value="<?php echo set_value('ttitle', isset($default['title']) ? $default['title'] : ''); ?>" /> <br />
					</td>
					</tr>
					
					
					
					<tr> <td> <label for="rpublish">Publish</label> </td> <td>:</td> 
					   <td> Yes <input name="rpublish" class="required" type="radio" value="Y" <?php echo set_radio('rpublish', 'Y', isset($default['publish']) && $default['publish'] == 'Y' ? TRUE : FALSE); ?> /> 
					   No <input name="rpublish" class="required" type="radio" value="N" <?php echo set_radio('rpublish', 'N', isset($default['publish']) && $default['publish'] == 'N' ? TRUE : FALSE); ?> />  
						  <br/>
					   </td> 
				    </tr>
					
					<tr> <td><label for="cstatus">Status</label></td> <td>:</td> 
						 <td>
			  <select name="cstatus" class="required" title="Status">
				 <option value="user" <?php echo set_select('cstatus', 'user', isset($default['status']) && $default['status'] == 'user' ? TRUE : FALSE); ?> /> User </option>
				 <option value="admin" <?php echo set_select('cstatus', 'admin', isset($default['status']) && $default['status'] == 'admin' ? TRUE : FALSE); ?> /> Admin </option>
			  </select>
							  <br /> 
						 </td>  </tr>
						 
					<tr> <td> <label for="raktif">Active</label> </td> <td>:</td> 
					   <td> Yes <input name="raktif" class="required" type="radio" value="Y" <?php echo set_radio('raktif', 'Y', isset($default['aktif']) && $default['aktif'] == 'Y' ? TRUE : FALSE); ?> /> No <input name="raktif" class="required" type="radio" value="N" <?php echo set_radio('raktif', 'N', isset($default['aktif']) && $default['aktif'] == 'N' ? TRUE : FALSE); ?> />  
						  <br/>
					   </td> 
				    </tr>
					
				<tr> <td><label for="tlimit"> Limit </label></td> <td>:</td> <td><input type="text" class="required" name="tlimit" id="tlimit" size="2" maxlength="3" title="" 
				value="<?php echo set_value('tlimit', isset($default['limit']) ? $default['limit'] : ''); ?>" onkeyup="checkdigit(this.value, 'tlimit')" /> 
				<br /> </td>  </tr>
					
				<tr> <td><label for="crole">Role</label></td> <td>:</td> <td> 				
				<?php					
					$js = 'class="required", size="6" ';
					echo form_dropdown('crole[]', $options, $array, $js);
				?>
				</td> </tr> 
				
				<tr> <td><label for="torder"> Order </label></td> <td>:</td> <td><input type="text" class="required" name="torder" id="torder" size="2" maxlength="3" title="" 
				value="<?php echo set_value('torder', isset($default['order']) ? $default['order'] : ''); ?>" onkeyup="checkdigit(this.value, 'torder')" /> 
				<br /> </td>  </tr>
				
				<tr> <td><label for="">Image</label> </td> <td>:</td> 
 				<td> <img width="50" src="<?php echo set_value('tket', isset($default['image']) ? $default['image'] : ''); ?>" 
				title="<?php echo set_value('tket', isset($default['image']) ? $default['image'] : ''); ?>"> </td> </tr>
				
				<tr> <td> <label for="userfile">Change image</label> </td> <td>:</td> <td> 
				<input type="file" title="Upload image" name="userfile" size="35" /> <br /> 
				<?php echo isset($error) ? $error : ''; ?> <small>*) Leave it blank if not upload images.</small> </td> </tr>
				
				</table> <br />  
			<p>
				<input type="submit" name="submit" class="button" title="Klik tombol untuk proses data" value=" Save " />
				<input type="reset" name="reset" class="button" title="Klik tombol untuk proses data" value=" Cancel " />
			</p>
		  </form>
	</fieldset>
</div>

<div class="title"> </div>

<!-- batas -->

