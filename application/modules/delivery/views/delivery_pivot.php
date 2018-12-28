<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="<?php echo base_url().'images/fav_icon.png';?>" >
<title> <?php echo isset($title) ? $title : ''; ?>  </title>
<style media="all">
	table{ font-family:"Arial", Times, serif; font-size:11px;}
	h4{ font-family:"Arial", Times, serif; font-size:14px; font-weight:600;}
	.clear{clear:both;}
	table th{ background-color:#EFEFEF; padding:4px 0px 4px 0px; border-top:1px solid #000000; border-bottom:1px solid #000000;}
    p{ font-family:"Arial", Times, serif; font-size:12px; margin:0; padding:0;}
	legend{font-family:"Arial", Times, serif; font-size:13px; margin:0; padding:0; font-weight:600;}
	.tablesum{ font-size:13px;}
	.strongs{ font-weight:normal; font-size:12px; border-top:1px dotted #000000; }
	.poder{ border-bottom:0px solid #000000; color:#0000FF; font-size:9pt;}
	.red{ border-bottom:0px solid #000000; color:#900; font-size:10pt;}
</style>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'js-old/pivot/' ?>pivot.css">
	  <script type="text/javascript" src="<?php echo base_url().'js-old/pivot/' ?>jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/pivot/' ?>jquery-ui-1.9.2.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/pivot/' ?>jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/pivot/' ?>pivot.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {

			var input = $("#input")
			$("#output").pivotUI(input);
			$("#input").hide();
        });
    </script>

</head>

<body>

<div style="width:100%; border:0px solid blue; font-family:Arial, Helvetica, sans-serif; font-size:12px;">

	<div style="border:0px solid red; float:left;">
		<table border="0">
            <tr> <td> Shipping Period </td> <td> : </td> <td> <?php echo $delivery_start.' - '.$delivery_end; ?> </td> </tr>
            <tr> <td> Confirmation Status </td> <td> : </td> <td> <?php echo $paid; ?> </td> </tr>
			<tr> <td> Run Date </td> <td> : </td> <td> <?php echo $rundate; ?> </td> </tr>
			<tr> <td> Log </td> <td> : </td> <td> <?php echo $log; ?> </td> </tr>
		</table>
	</div>

	<center>
	   <div style="border:0px solid green; width:230px;">
	      <h4> <?php echo isset($company) ? $company : ''; ?> <br> Delivery - Report (Pivot Table) </h4>
	   </div>
	</center>

	<div class="clear"></div>

	<div style="width:100%; border:0px solid brown; margin-top:20px; border-bottom:0px dotted #000000; ">

    	<div id='jqxWidget'>
        <div style='margin-top: 10px;' id="output"> </div>
        </div>

		<table id="input" border="0" width="100%">
		   
            <thead>
           <tr>
<th> No </th> <th> Sales No </th> <th> Sales Date </th> <th> Deliver Date </th> <th> Courier </th> <th> Coordinate </th> <th> Distance </th> <th> Received </th> <th> Amount </th>  <th> Confirmed </th> <th> Rating </th> <th> Status </th> 
           </tr>
           </thead>
		  
         <tbody> 
		  <?php 
              
              function get_sales($val,$type='dates')
              {
                  $res = new Sales_lib(); 
                  $result = $res->get_detail_sales($val);
                  if ($type == 'dates'){ return tglin($result->dates); }
                  elseif ($type == 'code'){ return $result->code; }
                  
              }
              
              function courier($val)
              {
                  $res = new Courier_lib(); 
                  $result = $res->get_detail($val,'name');
                  return $result;
              }
              
              function pstatus($val){ if ($val == 0){ return 'N'; }else{ return 'Y'; } }
			  		  
		      $i=1; 
			  if ($reports)
			  {
				foreach ($reports as $res)
				{	
				   echo " 
				   <tr> 
				       <td class=\"strongs\">".$i."</td> 
                       <td class=\"strongs\">".get_sales($res->sales_id,'code')."</td> 
                       <td class=\"strongs\">".get_sales($res->sales_id)."</td> 
					   <td class=\"strongs\">".tglin($res->dates)."</td>
                       <td class=\"strongs\">".strtoupper(courier($res->courier))."</td>
                       <td class=\"strongs\">".$res->coordinate."</td>
                       <td class=\"strongs\">".$res->distance."</td>
                       <td class=\"strongs\">".tglin($res->received)."</td>
                       <td class=\"strongs\">".$res->amount."</td>
                       <td class=\"strongs\">".pstatus($res->confirm_customer)."</td>
                       <td class=\"strongs\">".$res->rating."</td>
                       <td class=\"strongs\">".pstatus($res->status)."</td>
				   </tr>";
				   $i++;
				}
			 }  
		  ?>
		</tbody>      
		</table>
		
	</div>
	
     <a style="float:left; margin:10px;" title="Back" href="<?php echo site_url('delivery'); ?>"> 
        <img src="<?php echo base_url().'images/back.png'; ?>"> 
     </a>
    
</div>

</body>
</html>
