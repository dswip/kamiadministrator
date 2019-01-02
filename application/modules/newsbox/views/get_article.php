<style type="text/css">@import url("<?php echo base_url() . 'css/style.css'; ?>");</style>
<script type="text/javascript" src="<?php echo base_url();?>js/complete.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/register.js"></script>

<?php $flashmessage = $this->session->flashdata('message');
   echo ! empty($h2_title) ? '<h3>' . $h2_title .'</h3>' : ''; 
?> 
<h4> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </h4>

<div class="tableplace">

	<div id="searchplace">
		<form name="search_form" class="myform" method="post" action="<?php echo $form_action; ?>">
			<table>
				<tr> 
					<td> <label for="ccategory">Category</label> </td> 
					<td> <?php echo form_dropdown('ccategory', $options_cat, isset($default['category']) ? $default['category'] : ''); ?> 
					<br/> <?php echo form_error('ccategory', '<p class="field_error">', '</p>'); ?> </td> 
				<td> <input type="submit" class="button" title="Process Button" value="Search" /> <input type="reset" class="button" title="Cancel Button" value="Cancel" /></td>
				</tr>
			</table>
		</form>	
	</div>
	
	<div class="clear"></div> 
	<table class="tablemaster">
	<tr> <th> No </th> <th> Category </th> <th> Lang </th> <th> Permalink </th> <th> Judul </th> <th> Tanggal </th> <th> Action </th> </tr>
		<?php
		      $i=1; 
			  if ($articles)
			  {
				  foreach ($articles as $row)
				  {	
					echo "<tr> <td>".$i."</td> <td>".$row->category."</td> <td>".$row->lang."</td> <td>".$row->permalink."</td> <td>".$row->title."</td> 
					<td>".tgleng($row->dates)."</td> 
					<td> <input type=\"button\" value=\"Select\" onClick=\"setnews('$row->permalink')\" /> </td> </tr>";
					$i++;
				  }
			  }
		  ?>
    </table>
		<div class="paging"> <?php echo ! empty($pagination) ? $pagination : ''; ?> </div>
</div>

<div class="buttonplace"> 
		<?php 
	    if (!empty($link))
		{
			foreach($link as $links)
			{
				echo $links . '';
			}
		} ?>
	</div>
