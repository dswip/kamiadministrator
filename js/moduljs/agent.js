$(document).ready(function (e) {
	
    // function general
	
	$('#datatable-buttons').dataTable({
	 dom: 'T<"clear">lfrtip',
		tableTools: {"sSwfPath": site}
	 });
	 
	// date time picker
	// $('#d1,#d2,#d3,#d4,#d5').daterangepicker({
		 // locale: {format: 'YYYY/MM/DD'}
    // }); 
	
	load_data();  
	
	// batas dtatable
	
	// fungsi jquery update
	$(document).on('click','.text-primary',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_get +"/"+ del_id;
		
		window.location.href = url;
		
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

	// fungsi detail status
	$(document).on('click','.text-details',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_details +"/"+ del_id;
		$(".error").fadeOut();
		
		$("#myModal2").modal('show');
		$.post(url,
			{id:$(this).attr('data-id')},
			function(result)
			{
				res = result.split("|");
				
				$("#title_code").html(res[0]);
				$("#name").html(res[1]);
				$("#type").html(res[2]);
				$("#address").html(res[3]);
				$("#phone").html(res[4]+" / "+res[5]);
				$("#email").html(res[5]);
				$("#pass").html(res[7]);
				$("#website").html(res[8]);
				$("#city").html(res[9]+" / "+res[10]);
				$("#zip").html(res[11]);
				$("#proimage").attr("src",res[12]);
				$("#accname").html(res[15]);
				$("#accno").html(res[14]);
				$("#bank").html(res[13]);	
			}   
		);
	});

	$(document).on('click','#bgetpass',function(e)
	{	
		e.preventDefault();
		var url = sites_ajax +"/get_pass";

		// batas
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

	function load_data_search(search=null)
	{
		$(document).ready(function (e) {
			
			var oTable = $('#datatable-buttons').dataTable();
			var stts = 'btn btn-danger';
			
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
						if (s[i][9] == 1){ stts = 'btn btn-success'; }else { stts = 'btn btn-danger'; }
						oTable.fnAddData([
			'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
									i+1,
									s[i][1],
									s[i][3],
									s[i][2],
									s[i][4],
									s[i][6],
									s[i][7],
									s[i][10],
			'<div class="btn-group" role"group">'+
			'<a href="" class="'+stts+' btn-xs primary_status" id="' +s[i][0]+ '" title="Primary Status"> <i class="fa fa-power-off"> </i> </a> '+
			'<a href="" class="btn btn-success btn-xs text-details" id="' +s[i][0]+ '" title="Agent Details"> <i class="fa fa-book"> </i> </a> '+
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
						  if (s[i][9] == 1){ stts = 'btn btn-success'; }else { stts = 'btn btn-danger'; }
						  oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][1],
										s[i][3],
										s[i][2],
										s[i][4],
										s[i][6],
										s[i][7],
										s[i][10],
'<div class="btn-group" role"group">'+
'<a href="" class="'+stts+' btn-xs primary_status" id="' +s[i][0]+ '" title="Primary Status"> <i class="fa fa-power-off"> </i> </a> '+
'<a href="" class="btn btn-success btn-xs text-details" id="' +s[i][0]+ '" title="Agent Details"> <i class="fa fa-book"> </i> </a> '+
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
	
	