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
<script type="text/javascript" src="<?php echo base_url();?>js/complete.js"></script> 
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
	
	<fieldset class="field"> <legend>Add New Front Menu</legend>
			<form name="admin_form" class="myform" id="form" method="post" action="<?php echo $form_action; ?>" enctype="multipart/form-data">
				<table>
					<tr> <td><label for="tname">Name</label></td> <td>:</td> <td><input type="text" class="required" name="tname" size="35" title="Category name" value="<?php echo set_value('tname', isset($default['name']) ? $default['name'] : ''); ?>" /> <br /> </td> </tr>
					
					<tr><td> <label for="ctype">Type</label></td> <td>:</td> 
<td> <select name="ctype" id="ctypefront" class="required" size="5" title="Type"> 
<option value="modul" <?php echo set_select('ctype', 'modul', isset($default['type']) && $default['type'] == 'modul' ? TRUE : FALSE); ?> >modul</option> 
<option value="article" <?php echo set_select('ctype', 'article', isset($default['type']) && $default['type'] == 'article' ? TRUE : FALSE); ?> >article</option> 
<option value="articlelist" <?php echo set_select('ctype', 'articlelist', isset($default['type']) && $default['type'] == 'articlelist' ? TRUE : FALSE); ?> >article list</option> 
<option value="url" <?php echo set_select('ctype', 'url', isset($default['type']) && $default['type'] == 'url' ? TRUE : FALSE); ?> >url</option> 
</select>  </td> </tr>
					
                <tr> <td> <label for="cvalue"> Value </label> </td> <td>:</td> <td> <div id="valueplace"></div> <div id="bnewsplace"> <?php echo $tombol; ?> </div> </td> </tr>
                <tr> <td> <label for="rposition"> Position </label> </td> <td>:</td> 
                     <td> 
                          <input name="rposition" type="radio" title="Menu Position" class="required"  value="top"    <?php echo set_radio('rposition', 'top',    isset($default['position']) && $default['position'] == 'top' ? TRUE : FALSE); ?> /> Top <br/>
                          <input name="rposition" type="radio" title="Menu Position" class="required"  value="middle" <?php echo set_radio('rposition', 'middle', isset($default['position']) && $default['position'] == 'middle' ? TRUE : FALSE); ?> /> Middle <br/>
                          <input name="rposition" type="radio" title="Menu Position" class="required"  value="bottom" <?php echo set_radio('rposition', 'bottom', isset($default['position']) && $default['position'] == 'bottom' ? TRUE : FALSE); ?> /> Bottom <br/>
                    </td> 
                </tr>
				   
				    <tr> <td><label for="cparent"> Parent Item </label></td> <td>:</td> <td> 
					<?php $js = 'class="required", size="10" '; echo form_dropdown('cparent', $query_menu, isset($default['parent']) ? $default['parent'] : '', $js); ?>
					 <br/> </td> </tr> 

				   <tr> <td><label for="turl">Url</label></td> <td>:</td> <td><input type="text" class="required" name="turl" id="turl" size="30" title="URL" value="<?php echo set_value('turl', isset($default['url']) ? $default['url'] : ''); ?>" /> <br /> </td> </tr>
				   
				   <tr> <td> <label for="tmenuorder">Order</label> </td> <td>:</td> <td> <input type="text" name="tmenuorder" id="tmenuorder" title="Menu Order" onkeyup="checkdigit(this.value, 'tmenuorder')" size="1" class="form_field" value="<?php echo set_value('tmenuorder', isset($default['menuorder']) ? $default['menuorder'] : ''); ?>" />                   <br /> </td> </tr>
				   
				   <tr> <td><label for="tlimit"> Limit </label></td> <td>:</td> <td>
                       <input type="text" class="required" name="tlimit" id="tlimit" size="2" maxlength="3" title="" 
				value="<?php echo set_value('tlimit', isset($default['limit']) ? $default['limit'] : ''); ?>" onkeyup="checkdigit(this.value, 'tlimit')" /> 
				<br />  </td>  </tr>
				   
				   <tr> <td><label for="tclass">Class</label></td> <td>:</td> <td><input type="text" class="form_field" name="tclass" size="10" title="Class" value="<?php echo set_value('tclass', isset($default['class']) ? $default['class'] : ''); ?>" /> <br /> <?php echo form_error('tclass', '<p class="field_error">', '</p>');?></td> </tr>
				   <tr> <td><label for="tid">ID</label></td> <td>:</td> <td><input type="text" class="form_field" name="tid" size="10" title="ID" value="<?php echo set_value('tid', isset($default['id']) ? $default['id'] : ''); ?>" /> <br /> </td> </tr>
				   
				   <tr> <td><label for="ctarget"> Target </label></td> <td>:</td> 
					 <td>
<select name="ctarget" class="required" title="Position">
<option value="_parent" <?php echo set_select('ctarget', '_parent', isset($default['target']) && $default['target'] == '_parent' ? TRUE : FALSE); ?> /> Parent </option>
<option value="_blank" <?php echo set_select('ctarget', '_blank', isset($default['target']) && $default['target'] == '_blank' ? TRUE : FALSE); ?> /> Blank </option>
<option value="_self" <?php echo set_select('ctarget', '_self', isset($default['target']) && $default['target'] == '_self' ? TRUE : FALSE); ?> /> Self </option>
<option value="_top" <?php echo set_select('ctarget', '_top', isset($default['target']) && $default['target'] == '_top' ? TRUE : FALSE); ?> /> Top </option>
</select> <br />   </td>  </tr>
				   
				<tr> <td><label for="">Image</label> </td> <td>:</td> 
 				<td> <img width="50" src="<?php echo set_value('tket', isset($default['image']) ? $default['image'] : ''); ?>" 
				title="<?php echo set_value('tket', isset($default['image']) ? $default['image'] : ''); ?>"> </td> </tr>
				
				<tr> <td> <label for="userfile">Change image</label> </td> <td>:</td> <td> 
				<input type="file" title="Upload image" name="userfile" size="35" /> <br /> 
				<?php echo isset($error) ? $error : ''; ?> <small>*) Leave it blank if not upload images.</small> </td> </tr>
				   
				</table>				  
			<p>
				<input type="submit" name="submit" class="button" title="Klik tombol untuk proses data" value=" Save " />
				<input type="reset" name="reset" class="button" title="Klik tombol untuk proses data" value=" Cancel " />
			</p>
		  </form>
	</fieldset>
</div>


