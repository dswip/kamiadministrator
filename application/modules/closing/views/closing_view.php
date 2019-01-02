<div id="webadmin">
	
	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div id="errorbox" class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<fieldset class="field"> <legend> Sales Adjustment </legend>
	<form name="modul_form" class="myform" id="form" method="post" action="<?php echo $form_action; ?>">
		<table>
			<tr> 
			
			<td> <label for=""> Date </label></td> <td>:</td> 
			<td> <input type="Text" name="tdate" id="d1" title="Start date" size="10" class="form_field" /> 
				 <img src="<?php echo base_url();?>/jdtp-images/cal.gif" onclick="javascript:NewCssCal('d1','yyyymmdd')" style="cursor:pointer"/>
			</td> 
			
			<td colspan="3" align="right"> 
			<input type="submit" name="submit" class="button" value="Search" /> 
			</td>
			
			</tr> 
		</table>	
	</form>			  
	</fieldset>
</div>


<div id="webadmin2">
	
 <?php echo ! empty($table) ? $table : ''; ?>
 <div class="paging"> <?php echo ! empty($pagination) ? $pagination : ''; ?> </div>
	
<!-- links -->
<div class="buttonplace"> <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?> </div>

</div>

