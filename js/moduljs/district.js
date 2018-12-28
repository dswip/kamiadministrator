$(document).ready(function (e) {
	
	$('#datatable-buttons').dataTable({
	 dom: 'T<"clear">lfrtip',
		tableTools: {"sSwfPath": site}
	 });
	
    // function general
    load_data();
	
	// reset form
	$("#breset,#bclose").click(function(){
	   resets();
	});

	// fungsi ajax district / kecamatan
	$(document).on('change','#ccity',function(e)
	{	
		e.preventDefault();
		var value = $(this).val();
		
		var url = sites+'/combo_district/'+value;

		if (value){ 
			// batas
			$.ajax({
				type: 'POST',
				url: url,
				cache: false,
				headers: { "cache-control": "no-cache" },
				success: function(result) {
				$("#dbox,#dbox_update").html(result);
				}
			})
			return false;

		}else { swal('Error Load Data...!', "", "error"); }

	});

	$(document).on('change','#ccity_update',function(e)
	{	
		e.preventDefault();
	});

	$(document).on('click','#xbget',function(e)
	{	
		e.preventDefault();
		var value = $("#ccity_update").val();
		
		var url = sites+'/combo_district/'+value+"/update";

		if (value){ 
			// batas
			$.ajax({
				type: 'POST',
				url: url,
				cache: false,
				headers: { "cache-control": "no-cache" },
				success: function(result) {
					
					$('#cdistrict_update').hide();
					$('#cdistrict_update_name').hide();
					$("#dbox_update").show();
					$("#dbox_update").html(result);
				}
			})
			return false;

		}else { swal('Error Load Data...!', "", "error"); }

	});
	
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

				// 2|ESL|1275|1275130|weight|9500
				$("#tid_update").val(res[0]);
				$("#cccourrier_update").val(res[1]);
				$('#ccity_update').val(res[2]).change();
				$('#cdistrict_update').val(res[3]).change();
				$('#cdistrict_update_name').val(res[6]);
				$('#ctype_update').val(res[4]).change();
				$('#trate_update').val(res[5]);
				$("#dbox_update").hide();
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

	$('#searchform').submit(function() {
		
		var city = $("#ccity_search").val();
		var courier = $("#ccourrier_search").val();
		var param = ['searching',city,courier];
		
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
				load_data_search(param);
			}
		})
		return false;
		swal('Error Load Data...!', "", "error");
		
	});	
	
		
// document ready end	
});

    function resets()
    {
	  $(document).ready(function (e) {
		  
		 $("#tname,#uploadImage").val("");
		 $("#catimg,#catimg_update").attr("src","");
	  });
	}
	
	function load_data_search(search=null)
	{
		$(document).ready(function (e) {
			
			var oTable = $('#datatable-buttons').dataTable();
			var stts = 'btn btn-danger';
			
				// console.log(source+"/"+search[0]+"/"+search[1]+"/"+search[2]+"/"+search[3]);
			
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
			if (s[i][4] == 1){ stts = 'btn btn-success'; }else { stts = 'btn btn-danger'; }	
			 oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
						i+1,
						s[i][1],
						s[i][3],
						s[i][2],
						s[i][4],
						s[i][5],
'<div class="btn-group" role"group">'+
'<a href="" class="btn btn-primary btn-xs text-primary" id="' +s[i][0]+ '" title=""> <i class="fa fas-2x fa-edit"> </i> </a>'+
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
						$(".chkselect").remove();
							
		$("#chkbox").append('<input type="checkbox" name="newsletter" value="accept1" onclick="cekall('+s.length+')" id="chkselect" class="chkselect">');
							
							for(var i = 0; i < s.length; i++) {
							if (s[i][4] == 1){ stts = 'btn btn-success'; }else { stts = 'btn btn-danger'; }	
							 oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][1],
										s[i][3],
										s[i][2],
										s[i][5],
										s[i][4],
'<div class="btn-group" role"group">'+
'<a href="" class="btn btn-primary btn-xs text-primary" id="' +s[i][0]+ '" title=""> <i class="fa fas-2x fa-edit"> </i> </a>'+
'<a href="#" class="btn btn-danger btn-xs text-danger" id="'+s[i][0]+'" title="delete"> <i class="fa fas-2x fa-trash"> </i> </a>'+
'</div>'
											   ]);										
											} // End For
											
											
				},
				error: function(e){
				   console.log(e.responseText);	
				   oTable.fnClearTable(); 
				}
				
			});  // end document ready	
			
        });
	}
	// batas fungsi load data