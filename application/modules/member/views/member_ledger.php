<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Customer Ledger </title>

<style type="text/css" media="all">

	body{ font-size:0.75em; font-family:Arial, Helvetica, sans-serif; margin:0; padding:0;}
	#container{ width:21cm; height:11.6cm; border:0pt solid #000;}
	.clear{ clear:both;}
	#tablebox{ height:6.45cm; width:20cm; border:0pt solid red; float:left; margin:0.1cm 0 0 0.4cm;}
		
	#logobox{ width:5.5cm; height:1cm; border:0pt solid blue; margin:0.8cm 0 0 0.5cm; float:left;}
	#venbox{ width:7.5cm; height:2.0cm; border:0pt solid green; margin:0.0cm 0cm 0.2cm 0.5cm; float:left;}
    #venbox2{ width:7.5cm; height:2.0cm; border:0pt solid green; margin:0.0cm 0cm 0.2cm 0.5cm; float:right;}
	#title{ text-align:center; font-size:17pt;}
	h4{ font-size:14pt; margin:0;}
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
						{ name: "Date", type: "string" },
                        { name: "Code", type: "string" },
						{ name: "Debit", type: "string" },
						{ name: "Credit", type: "number" },
						{ name: "Balance", type: "number" }
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
				  { text: 'Date', dataField: 'Date', width : 150, cellsalign: 'center' },
                  { text: 'Code', dataField: 'Code', width : 100, cellsalign: 'center' },
{ text: 'Debit', datafield: 'Debit', width: 150, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
{ text: 'Credit', datafield: 'Credit', width: 150, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
				  { text: 'Balance', dataField: 'Balance', width: 170, cellsalign: 'right', cellsformat: 'number'}
				  
                ]
            });
            
            $("#bexport").click(function() {
				
				var type = $("#crtype").val();	
				if (type == 0){ $("#jqxgrid").jqxGrid('exportdata', 'html', 'Customer-Ledger'); }
				else if (type == 1){ $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Customer-Ledger'); }
				else if (type == 2){ $("#jqxgrid").jqxGrid('exportdata', 'pdf', 'Customer-Ledger'); }
				else if (type == 3){ $("#jqxgrid").jqxGrid('exportdata', 'csv', 'Customer-Ledger'); }
			});
			
			$('#jqxgrid').jqxGrid({ pagesizeoptions: ['500', '1000', '1500']}); 
			
			 $("#table").hide();
			
		// end jquery	
        });
    </script>


</head>


<script type="text/javascript">
    
    function closeWindow() {
        setTimeout(function() {
        window.close();
        }, 300000);
    }
    
</script>     
    
<body bgcolor="#FFFFFF"; onload="closeWindow();">

<div id="container">
	
    <center>
	   <div style="border:0px solid green; width:500px;"> <br>	
	       <h4> <?php echo isset($company) ? $company : ''; ?> </h4>
	   </div>
	</center> <hr>
	
    <p style="padding:0; font-weight:bold; font-size:1.3em; text-align:center;"> Transaction Ledger </p>
    
    <div id="venbox2">
	<table width="100%" style="font-size:1em; margin:0; text-align:left; font-weight:bold;">
	  <tr> <td> Code </td> <td>:</td> <td> <?php echo isset($code) ? $code : ''; ?> </td> </tr>
      <tr> <td> Name </td> <td>:</td> <td> <?php echo isset($name) ? $name : ''; ?> </td> </tr>
      <tr> <td> Log </td> <td>:</td> <td> <?php echo isset($log) ? $log : ''; ?> </td> </tr>
	</table>
	</div>
	
	<div id="tablebox">
    
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
	
		<table id="table">
        <thead>
	    <tr>  <th> No </th> <th> Date </th> <th> Code </th> <th> Debit </th> <th> Credit </th> <th> Balance </th> </tr>	
        </thead>

        <tbody>
        <tr> <td></td> <td> Open Balance : </td> <td></td> <td></td> <td></td>  <td> <?php echo $beginning; ?> </td> </tr>
        
        <?php
		
		if ($items)
		{
			$i=1;
            $balance = $beginning;
			foreach ($items as $res)
			{
                $balance = floatval($balance+$res->vamount);
				echo "	
				 <tr> 
					<td> ".$i." </td>
					<td class=\"left\"> ".tglin($res->dates)." </td>
                    <td class=\"left\"> ".$res->code.'-'.$res->no." </td>
					<td class=\"left\"> ".floatval($res->debit)." </td> 
                    <td class=\"left\"> ".floatval($res->credit)." </td> 
                    <td class=\"left\"> ".$balance." </td> 
				 </tr>
				
				"; $i++;
			}
		}
		
        ?>
        </tbody>

		</table>
	</div>  <div class="clear"></div>
	
</div>

</body>
</html>
