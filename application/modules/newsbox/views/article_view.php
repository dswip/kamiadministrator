

<div id="webadmin">

	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div id="errorbox" class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<form name="search_form" class="myform" id="form" method="post" action="<?php echo $form_action; ?>">
		<table style="margin-left:10px;">
			<tr> 
				<td> Category : <br />
				     <?php $js="class='input-medium'"; echo form_dropdown('ccategory', $category, isset($default['category']) ? $default['category'] : '', $js); ?> &nbsp; 
				</td>
				
				<td> Language : <br /> <?php $js="class='input-medium'"; echo form_dropdown('clang', $language, isset($default['lang']) ? $default['lang'] : '', $js); ?> &nbsp;
				<br/> </td> 
				
				<td>
					Date : <br />
					<div id="datetimepicker" class="input-append date">
					  <input type="text" name="tdate" readonly="readonly" class="input-small"></input>
					  <span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i> </span>
					</div>
				</td>
				
				<td> &nbsp; <input type="submit" class="btn" title="Process Button" value="Search" />  </td>
			</tr>
		</table>
	</form>	
</div>

<div id="webadmin2">	
    <form name="search_form" class="myform" method="post" action="<?php echo $form_action_del; ?>">
     <?php echo ! empty($table) ? $table : ''; ?>
	 <div class="paging"> <?php echo ! empty($pagination) ? $pagination : ''; ?> </div>
	 <p class="cek"> &nbsp; <?php echo ! empty($radio1) ? $radio1 : ''; echo ! empty($radio2) ? $radio2 : ''; ?>  <input type="submit" name="button" class="button_delete" title="Process Button" value="Delete All" />  </p> 
	</form>	
	
	<!-- links -->
	<div class="buttonplace"> <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?> </div>
</div>

<script type="text/javascript">
      $('#datetimepicker').datetimepicker({
        format: 'yyyy-MM-dd'
      });
</script>
