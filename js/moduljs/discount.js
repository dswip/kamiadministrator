$(document).ready(function (e) {
	
    // function general
	
	$('#datatable-buttons').dataTable({
	 dom: 'T<"clear">lfrtip',
		tableTools: {"sSwfPath": site}
	 });
	 
	// date time picker
	$('#d1,#d2,#d3,#d4,#d5').daterangepicker({
		 locale: {format: 'YYYY/MM/DD'}
	}); 
	
	$('#ds1,#ds2,#ds3').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
		singleDatePicker: true,
        showDropdowns: true
     });
	
	load_data();  
	
	// batas dtatable
	
// fungsi jquery update
	$(document).on('click','.text-primary',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_get +"/"+ del_id;
		$(".error").fadeOut();
		
		$("#myModal2").modal('show');
		// batas
		$.ajax({
			type: 'POST',
			url: url,
    	    cache: false,
			headers: { "cache-control": "no-cache" },
			success: function(result) {
				
				res = result.split("|");	
				var val = res[7].split(",");
				
				resets();
				$("#tid_update").val(res[0]);
				$("#tname_update").val(res[1]);
				$("#ds2").val(res[2]);
				$("#ds3").val(res[3]);
				$("#ctype_update").val(res[4]);
				$("#tminorder_update").val(res[5]);
				$("#tpercent_update").val(res[6]);
				$("#cpaymenttype_update").val(val).change();
			}
		})
		return false;	
	});
	
		// fungsi jquery update
	$(document).on('click','.text-ledger',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_ledger +"/"+ del_id;
		
		window.location.href = url;
		
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
	
	
	$('#searchform').submit(function() {
		
		var dates = $("#ds1").val();
		var type = $("#ctype").val();
		var stts = $("#cstts").val();
		var param = ['searching',dates,type,stts];
		
		// alert(publish+" - "+dates);
		
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
				if (!param[3]){ param[3] = 'null'; }
				load_data_search(param);
			}
		})
		return false;
		swal('Error Load Data...!', "", "error");
		
	});
	
		
// document ready end	
});

	function load_data_search(search=null)
	{
		$(document).ready(function (e) {
			
			var oTable = $('#datatable-buttons').dataTable();
			var stts = 'btn btn-danger';
			
		    $.ajax({
				type : 'GET',
				url: source+"/"+search[0]+"/"+search[1]+"/"+search[2]+"/"+search[3],
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
			if (s[i][8] == 1){ stts = 'btn btn-success'; }else { stts = 'btn btn-danger'; }
			oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
						  i+1,
						  s[i][1],
					      s[i][2]+' : '+s[i][3],
						  s[i][4],
						  s[i][7],
						  s[i][5],
						  s[i][6],
'<div class="btn-group" role"group">'+
'<a href="" class="'+stts+' btn-xs primary_status" id="' +s[i][0]+ '" title="Primary Status"> <i class="fa fa-power-off"> </i> </a> '+
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
						  if (s[i][8] == 1){ stts = 'btn btn-success'; }else { stts = 'btn btn-danger'; }
						  oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][1],
										s[i][2]+' : '+s[i][3],
										s[i][4],
										s[i][7],
										s[i][5],
										s[i][6],
'<div class="btn-group" role"group">'+
'<a href="" class="'+stts+' btn-xs primary_status" id="' +s[i][0]+ '" title="Primary Status"> <i class="fa fa-power-off"> </i> </a> '+
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
		  $("#tname, #tmodel, #tsku").val("");
		  $("#catimg").attr("src","");
	  });
	}
	
	// function load_form()
	// {
	// 	$(document).ready(function (e) {
			
	// 	  	$.ajax({
	// 			type : 'GET',
	// 			url: source,
	// 			//force to handle it as text
	// 			contentType: "application/json",
	// 			dataType: "json",
	// 			success: function(data) 
	// 			{   
	// 				// alert(data[0][1]);
	// 				$("#tname").val(data[0][1]);
	// 				$("#taddress").val(data[0][2]);
	// 				$("#ccity").val(data[0][13]).change();
	// 				$("#tzip").val(data[0][9]);
	// 				$("#tphone").val(data[0][3]);
	// 				$("#tphone2").val(data[0][4]);
	// 				$("#tmail").val(data[0][5]);
	// 				$("#tbillmail").val(data[0][6]);
	// 				$("#ttechmail").val(data[0][7]);
	// 				$("#tccmail").val(data[0][8]);
	// 				$("#taccount_name").val(data[0][10]);
	// 				$("#taccount_no").val(data[0][11]);
	// 				$("#tbank").val(data[0][12]);
	// 				$("#tsitename").val(data[0][14]);
	// 				$("#tmetadesc").val(data[0][15]);
	// 				$("#tmetakey").val(data[0][16]);
	// 				$("#catimg_update").attr("src","");
	// 				$("#catimg_update").attr("src",base_url+"images/property/"+data[0][17]);
			   
	// 			},
	// 			error: function(e){
	// 			   //console.log(e.responseText);	
	// 			}
				
	// 		});  
			
	//     });  // end document ready	
	// }
	