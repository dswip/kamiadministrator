$(document).ready(function (e) {
	
    // function general
	
	$('#datatable-buttons').dataTable({
	 dom: 'T<"clear">lfrtip',
		tableTools: {"sSwfPath": site}
	 });
	 
	// date time picker
	// $('#d1,#d2,#d3,#d4,#d5').daterangepicker({
	// 	 locale: {format: 'YYYY/MM/DD'}
	// }); 
	
	$('#ds1,#ds2').daterangepicker({
        locale: {format: 'YYYY/MM/DD'},
		singleDatePicker: true,
        showDropdowns: true
	});
	
	load_data();  
	
	// fungsi jquery update
	$(document).on('click','.text-primary',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_get +"/"+ del_id;
		
		window.location.href = url;
	});

	// fungsi jquery print
	$(document).on('click','.text-print',function(e)
	{	e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_print_invoice +"/"+ del_id;
		
		// window.location.href = url;
		window.open(url, "Invoice SO-0"+del_id, "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=600,width=800,height=600");
		
	});

		// fungsi ajax combo
	$(document).on('change','#ccity,#ccity_update',function(e)
	{	
		e.preventDefault();
		var value = $(this).val();
		var url = sites_ajax+'/ajaxcombo_district/';
		
		console.log(value);
		// batas
		$.ajax({
			type: 'POST',
			url: url,
    	    data: "value="+ value,
			success: function(result) {
			$('#cdistrict_update').hide();
			$(".select_box").html(result);
			}
		})
		return false;	
	});

	$(document).on('change','#cproduct',function(e)
	{	
		e.preventDefault();
		var value = $(this).val();
		var url = sites_product+'/get_price/'+value;
		
		if (value){
			$.ajax({
				type: 'GET',
				url: url,
				data: "value="+ value,
				success: function(result) {
				  $("#tprice").val(result);
				  getdays(value);
				}
			})
			return false;	
		}
		// batas
	});

	function getdays(value){
		var url = sites_product+'/get_price/'+value+'/validity';
		
		if (value){
			$.ajax({
				type: 'GET',
				url: url,
				data: "value="+ value,
				success: function(result) {
				  $("#hdays").val(result);
				}
			})
			return false;	
		}

	}

	// publish status
	$(document).on('click','#bgetpass',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var url = sites_ajax+'/get_pass';
		$(".error").fadeOut();
		
		$.ajax({
			type: 'POST',
			url: url,
			cache: false,
			headers: { "cache-control": "no-cache" },
			success: function(result) {
				$("#tpass").val(result);
			}
		})
		return false;
	});
	
	// publish status
	$(document).on('click','.primary_status',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_primary +"/"+ del_id;
		$(".error").fadeOut();
		
		// $("#myModal2").modal('show');
		// batas
		$.ajax({
			type: 'POST',
			url: url,
    	    cache: false,
			headers: { "cache-control": "no-cache" },
			success: function(result) {
				
				res = result.split("|");
				if (res[0] == "true")
				{   
			        error_mess(1,res[1],0);
					load_data();
				}
				else if (res[0] == 'warning'){ error_mess(2,res[1],0); }
				else{ error_mess(3,res[1],0); }
			}
		})
		return false;	
	});

	// publish status
	$(document).on('click','.premium_status',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");

		var url = sites_premium +"/"+ del_id;
		// batas
		$.ajax({
			type: 'POST',
			url: url,
    	    cache: false,
			headers: { "cache-control": "no-cache" },
			success: function(result) {
				res = result.split("|");
				if (res[0] == "true")
				{   
					error_mess(1,res[1],1);
					location.reload(true);
				}
				else if (res[0] == 'warning'){ error_mess(2,res[1],1); }
				else{ error_mess(3,res[1],1); }
			}
		})
		return false;	
	});
	
	
	$('#searchform').submit(function() {
		
		var city = $("#ccity").val();
		var publish = $("#cpublish").val();
		var param = ['searching',city,publish];
		
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data) {
				
				if (!param[1]){ param[1] = 'null'; }
				if (!param[2]){ param[2] = 'null'; }
				load_data_search(param);
			}
		})
		return false;
		swal('Error Load Data...!', "", "error");
		
	});
		
// document ready end	
});

// ajax transaction data 
$(document).on('submit','#ajaxtransform',function(e){

	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: $(this).attr('action'),
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(data) {
			res = data.split("|");
			if (res[0] == "true")
			{   
				error_mess(1,res[1],1);
				location.reload(true);
			}
			else if (res[0] == 'warning'){ error_mess(2,res[1],1); }
			else{ error_mess(3,res[1],1); }
		},
		error: function(e) 
		{
			$("#error").html(e).fadeIn();
			console.log(e.responseText);	
		} 
	})
	return false;
});

	function load_data_search(search=null)
	{
		$(document).ready(function (e) {
			
			var oTable = $('#datatable-buttons').dataTable();
			var stts = 'btn btn-danger';
			var premium = '';
			
				console.log(source+"/"+search[0]+"/"+search[1]+"/"+search[2]);
			
		    $.ajax({
				type : 'GET',
				url: source+"/"+search[0]+"/"+search[1]+"/"+search[2],
				//force to handle it as text
				contentType: "application/json",
				dataType: "json",
				success: function(s) 
				{   
				       console.log(s);
					  
						oTable.fnClearTable();
						$(".chkselect").remove()
	
		$("#chkbox").append('<input type="checkbox" name="newsletter" value="accept1" onclick="cekall('+s.length+')" id="chkselect" class="chkselect">');
							
					for(var i = 0; i < s.length; i++) {
						if (s[i][17] == 1){ stts = 'btn btn-success'; }else { stts = 'btn btn-danger'; }
			if (s[i][19] == 1){ premium = '<a class="btn-xs" title="Premium Status"> <i class="fa fa-trophy"></i> </a> '; }
						oTable.fnAddData([
			'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
									i+1,
			'<img src="'+s[i][16]+'" class="img_product" alt="'+s[i][1]+'">',
									s[i][3],
									s[i][1]+' '+s[i][2],
									s[i][9],
									s[i][12],
									s[i][6],
									s[i][18],
			'<div class="btn-group" role"group">'+premium+
			'<a href="" class="'+stts+' btn-xs primary_status" id="' +s[i][0]+ '" title="Primary Status"> <i class="fa fa-power-off"> </i> </a> '+
			'<a href="" class="btn btn-warning btn-xs text-print" id="' +s[i][0]+ '" title="Invoice Status"> <i class="fa fa-print"> </i> </a> '+
			'<a href="" class="btn btn-primary btn-xs text-primary" id="' +s[i][0]+ '" title=""> <i class="fa fas-2x fa-edit"> </i> </a> '+
			'<a href="#" class="btn btn-danger btn-xs text-danger" id="'+s[i][0]+'" title="delete"> <i class="fa fas-2x fa-trash"> </i> </a>'+
			'</div>'
										]);										
										} // End For 
											
				},
				error: function(e){
				   oTable.fnClearTable();  
				   //console.log(e.responseText);	
				}
				
			});  // end document ready	
			
        });
	}

    // fungsi load data
	function load_data()
	{
		$(document).ready(function (e) {
			
			var oTable = $('#datatable-buttons').dataTable();
			var stts = 'btn btn-danger';
			var premium = '';
			
		    $.ajax({
				type : 'GET',
				url: source,
				//force to handle it as text
				contentType: "application/json",
				dataType: "json",
				success: function(s) 
				{   
				       console.log(s);
					  
						oTable.fnClearTable();
						$(".chkselect").remove()
	
		$("#chkbox").append('<input type="checkbox" name="newsletter" value="accept1" onclick="cekall('+s.length+')" id="chkselect" class="chkselect">');
							
							for(var i = 0; i < s.length; i++) {
						  if (s[i][17] == 1){ stts = 'btn btn-success'; }else { stts = 'btn btn-danger'; }
if (s[i][19] == 1){ premium = '<a class="btn-xs" title="Premium Status"> <i class="fa fa-trophy"></i> </a> '; }
						  oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
'<img src="'+s[i][16]+'" class="img_product" alt="'+s[i][1]+'">',
										s[i][3],
										s[i][1]+' '+s[i][2],
										s[i][9],
										s[i][12],
										s[i][6],
										s[i][18],
'<div class="btn-group" role"group">'+premium+
'<a href="" class="'+stts+' btn-xs primary_status" id="' +s[i][0]+ '" title="Primary Status"> <i class="fa fa-power-off"> </i> </a> '+
'<a href="" class="btn btn-warning btn-xs text-print" id="' +s[i][0]+ '" title="Invoice Status"> <i class="fa fa-print"> </i> </a> '+
'<a href="" class="btn btn-primary btn-xs text-primary" id="' +s[i][0]+ '" title=""> <i class="fa fas-2x fa-edit"> </i> </a> '+
'<a href="#" class="btn btn-danger btn-xs text-danger" id="'+s[i][0]+'" title="delete"> <i class="fa fas-2x fa-trash"> </i> </a>'+
'</div>'
										    ]);										
											} // End For 
											
				},
				error: function(e){
				   oTable.fnClearTable();  
				   console.log(e.responseText);	
				}
				
			});  // end document ready	
			
        });
	}
	
	// batas fungsi load data
	function resets()
	{  
	   $(document).ready(function (e) {
		  // reset form
		  $("#breset").click();
		  $("#catimg").attr("src","");
	  });
	}
	
	