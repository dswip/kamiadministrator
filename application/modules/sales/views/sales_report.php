<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="<?php echo base_url().'images/fav_icon.png';?>" >
<title> <?php echo isset($title) ? $title : ''; ?>  </title>
<style media="all">
	table{ font-family:"Tahoma", Times, serif; font-size:11px;}
	h4{ font-family:"Tahoma", Times, serif; font-size:14px; font-weight:600;}
	.clear{clear:both;}
	table th{ background-color:#EFEFEF; padding:4px 0px 4px 0px; border-top:1px solid #000000; border-bottom:1px solid #000000;}
    p{ font-family:"Tahoma", Times, serif; font-size:12px; margin:0; padding:0;}
	legend{font-family:"Tahoma", Times, serif; font-size:13px; margin:0; padding:0; font-weight:600;}
	.tablesum{ font-size:13px;}
	.strongs{ font-weight:normal; font-size:12px; border-top:1px dotted #000000; }
	.poder{ border-bottom:0px solid #000000; color:#0000FF;}
    .img_product{ height: 50px; align-content: center;}
</style>

<link rel="stylesheet" href="<?php echo base_url().'js-old/jxgrid/' ?>css/jqx.base.css" type="text/css" />
    
	<script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxdata.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxcheckbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxlistbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxmenu.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.columnsresize.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.columnsreorder.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.aggregates.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxdata.export.js"></script>
	<script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.export.js"></script>
	
    <script type="text/javascript">
	
        $(document).ready(function () {
          
			var rows = $("#table tbody tr");
                // select columns.
                var columns = $("#table thead th");
                var data = [];
                for (var i = 0; i < rows.length; i++) {
                    var row = rows[i];
                    var datarow = {};
                    for (var j = 0; j < columns.length; j++) {
                        // get column's title.
                        var columnName = $.trim($(columns[j]).text());
                        // select cell.
                        var cell = $(row).find('td:eq(' + j + ')');
                        datarow[columnName] = $.trim(cell.text());
                    }
                    data[data.length] = datarow;
                }
                var source = {
                    localdata: data,
                    datatype: "array",
                    datafields:
                    [
                        { name: "No", type: "string" },
						{ name: "Code", type: "string" },
						{ name: "Date", type: "string" },
						{ name: "Customer", type: "string" },
                        { name: "Payment Type", type: "string" },
						{ name: "Total", type: "number" },
                        { name: "Tax", type: "number" },
                        { name: "Cost", type: "number" },
                        { name: "Shipping", type: "number" },
                        { name: "Discount", type: "number" },
                        { name: "Amount", type: "number" },
                        { name: "Confirmation", type: "string" },
                        { name: "Redeem", type: "string" },
                        { name: "Canceled", type: "string" }
                    ]
                };
			
            var dataAdapter = new $.jqx.dataAdapter(source);
            $("#jqxgrid").jqxGrid(
            {
                width: '100%',
				source: dataAdapter,
				sortable: true,
				filterable: true,
				pageable: true,
				altrows: true,
				enabletooltips: true,
				filtermode: 'excel',
				autoheight: true,
				columnsresize: true,
				columnsreorder: true,
				showstatusbar: true,
				statusbarheight: 30,
				showaggregates: true,
				autoshowfiltericon: false,
                columns: [
                  { text: 'No', dataField: 'No', width: 50 },
				  { text: 'Code', dataField: 'Code', width : 100 },
				  { text: 'Date', dataField: 'Date', width : 150 },
				  { text: 'Customer', dataField: 'Customer', width : 250 },
                  { text: 'Payment Type', dataField: 'Payment Type', width : 170 },
    { text: 'Total', dataField: 'Total', width : 150, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
    { text: 'Tax', datafield: 'Tax', width: 150, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
    { text: 'Cost', dataField: 'Cost', width : 150, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
    { text: 'Shipping', dataField: 'Shipping', width : 150, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
    { text: 'Discount', dataField: 'Discount', width : 150, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
    { text: 'Amount', dataField: 'Amount', width : 150, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
    
                  { text: 'Confirmation', dataField: 'Confirmation', width : 100 },
                  { text: 'Redeem', dataField: 'Redeem', width : 120 },
                  { text: 'Canceled', dataField: 'Canceled', width : 120 }
                ]
            });
			
			$('#jqxgrid').jqxGrid({ pagesizeoptions: ['1000', '2000', '3000', '5000', '10000', '15000']}); 
			
			$("#bexport").click(function() {
				
				var type = $("#crtype").val();	
				if (type == 0){ $("#jqxgrid").jqxGrid('exportdata', 'html', 'Sales-Summary'); }
				else if (type == 1){ $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Sales-Summary'); }
				else if (type == 2){ $("#jqxgrid").jqxGrid('exportdata', 'pdf', 'Sales-Summary'); }
				else if (type == 3){ $("#jqxgrid").jqxGrid('exportdata', 'csv', 'Sales-Summary'); }
			});
			
//			$('#jqxgrid').on('celldoubleclick', function (event) {
//     	  		var col = args.datafield;
//				var value = args.value;
//				var res;
//			
//				if (col == 'Sales No')
//				{ 			
//				   res = value.split("SO-0");
//				   openwindow(res[1]);
//				}
// 			});
//			
//			function openwindow(val)
//			{
//				var site = "<?php //echo site_url('sales_payment/get_last/');?>";
//				window.open(site+"/"+val, "", "width=800, height=600"); 
//				//alert(site+"/"+val);
//			}
			
     	    $("#table").hide();
			
		// end jquery	
        });
    </script>
</head>

<body>

<div style="width:100%; border:0px solid blue; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
	
	<div style="border:0px solid red; float:left;">
		<table border="0">
			<tr> <td> Period </td> <td> : </td> <td> <?php echo $start.' - '.$end; ?> </td> </tr>
			<tr> <td> Run Date </td> <td> : </td> <td> <?php echo $rundate; ?> </td> </tr>
			<tr> <td> Log </td> <td> : </td> <td> <?php echo $log; ?> </td> </tr>
		</table>
	</div>

	<center>
	   <div style="border:0px solid green; width:230px;">	
	       <h4> <?php echo isset($company) ? $company : ''; ?> <br> Sales Report </h4>
	   </div>
	</center>
	
	<div class="clear"></div>
	
	<div style="width:100%; border:0px solid brown; margin-top:20px; border-bottom:1px dotted #000000; ">
	
    <div id='jqxWidget'>
        <div style='margin-top: 10px;' id="jqxgrid"> </div>
        
        <table style="float:right; margin:5px;">
        <tr>
        <td> <input type="button" id="bexport" value="Export"> - </td>
        <td> 
        <select id="crtype"> <option value="0"> HTML </option> <option value="1"> XLS </option>  <option value="2"> PDF </option> 
        <option value="3"> CSV </option> 
        </select>
        </td>
        </tr>
        </table>
        
    </div>
    
		<table id="table" border="0" width="100%">
		   <thead>
           <tr>
<th> No </th> <th> Code </th> <th> Date </th> <th> Customer </th> <th> Payment Type </th> <th> Total </th> <th> Tax </th>
<th> Cost </th> <th> Shipping </th> <th> Discount </th> <th> Amount </th> <th> Confirmation </th> <th> Redeem </th> 
<th> Canceled </th>
           </tr>
           </thead>
		  
          <tbody> 
		  <?php 
              
              function customer($val)
              {
                  $res = new Customer_lib(); 
                  return strtoupper($res->get_name($val));
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
                       <td class=\"strongs\">".$res->code."</td> 
                       <td class=\"strongs\">".tglin($res->dates)."</td> 
                       <td class=\"strongs\">".customer($res->cust_id)."</td>
                       <td class=\"strongs\">".$res->payment_type."</td>
                       <td class=\"strongs\">".$res->total."</td>
                       <td class=\"strongs\">".$res->tax."</td>
                       <td class=\"strongs\">".$res->cost."</td>
                       <td class=\"strongs\">".$res->shipping."</td>
                       <td class=\"strongs\">".$res->discount."</td>
                       <td class=\"strongs\">".floatval($res->amount+$res->cost+$res->shipping-$res->discount)."</td>
                       <td class=\"strongs\">".pstatus($res->approved)."</td>
                       <td class=\"strongs\">".$res->redeem_date."</td>
                       <td class=\"strongs\">".$res->canceled."</td>
				   </tr>";
				   $i++;
				}
			 }  
		  ?>
		</tbody>      
		</table>
        
        </div>
        
        <a style="float:left; margin:10px;" title="Back" href="<?php echo site_url('sales'); ?>"> 
          <img src="<?php echo base_url().'images/back.png'; ?>"> 
        </a>
        
	</div>
	

</body>
</html>
