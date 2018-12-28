$(document).ready(function (e) {
	

	var favorite = [];
    // function general
	
	$('#datatable-buttons').dataTable({dom: 'T<"clear">lfrtip', tableTools: {"sSwfPath": site}});
	 
	// // date time picker
	$('#d1,#d2,#d3,#d4,#d5').daterangepicker({
		 locale: {format: 'YYYY/MM/DD'},
		 autoUpdateInput: false
    });


    $('#d1,#d2,#d3,#d4,#d5').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
    });

	  $('#d1,#d2,#d3,#d4,#d5').on('cancel.daterangepicker', function(ev, picker) {
	      $(this).val('');
	  }); 
	
	$('#ds1,#ds2').daterangepicker({
        locale: {format: 'YYYY/MM/DD'},
		singleDatePicker: true,
        showDropdowns: true
	});

	$('#dtime1,#dtime2').daterangepicker({
        timePicker: true,
		singleDatePicker: true,
        showDropdowns: true,
        timePicker24Hour: true,
        locale: { format: 'YYYY/MM/DD H:mm'}
	});

	// // fungsi jquery input mask
	$("#ttime").mask("99-99");

	load_data();  
	
	// batas dtatable

	// fungsi jquery konfirmasi pembayaran
	$(document).on('click','.text-payment',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_payment_confirmation +"/"+ del_id;
		$(".error").fadeOut();
		
		$("#myModal4").modal('show');
		// batas
		$.ajax({
			type: 'POST',
			url: url,
    	    cache: false,
			headers: { "cache-control": "no-cache" },
			success: function(result) {
				res = result.split("|");
			    $('#dtime2').val(res[1]);
			}
		})
		return false;	
	});

	$(document).on('click','.text-tracker',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_track +"/"+ del_id;

		window.location.href = url;
	});

	// fungsi jquery konfirmasi pembayaran
	$(document).on('click','.text-confirmation',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_confirmation +"/"+ del_id;
		$(".error").fadeOut();

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
	
	// fungsi jquery update
	$(document).on('click','.text-primary',function(e)
	{	e.preventDefault();
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

				$('#tid_update').val(res[0]);
				$('#tsid_update').val(res[1]);
			    $('#tsales_update').val(res[2]);
			    $('#tsales_date').val(res[3]);
			    $('#ccourier').val(res[4]).change();
				$('#tcoordinate').val(res[5]);
				$('#tdistance').val(res[6]);
				$('#taddress').val(res[7]);
				$('#tamount').val(res[8]);
				$('#tstatus').val(res[9]);
				$('#tsalesstatus').val(res[10]);
			}
		})
		return false;	
		
	});

	$(document).on('click','.text-print',function(e)
	{	e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_print_invoice +"/"+ del_id;

		// window.location.href = url;
		window.open(url, "Invoice SO-0"+del_id, "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=600,width=800,height=600");
		
	});

	$(document).on('click','.text-email',function(e)
	{	e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");

		$.ajax({
		    type: "POST",
        	url: sites_email_invoice +"/"+ del_id+"/ajax",
        	cache: false,
			success: function(data)
		    {
				res = data.split("|");
				if(res[0]=='true')
				{
					// invalid file format.
					error_mess(1,res[1],0);
				}
				else if(res[0] == 'warning'){ error_mess(2,res[1],0); }
				else if(res[0] == 'error'){ error_mess(3,res[1],0); }
				console.log(res[0]);
		    },
		  	error: function(e) 
	    	{
				//$("#error").html(e).fadeIn();
				error_mess(3,e);
				console.log(e.responseText);	
	    	} 	        
	   });

		
	});

	$(document).on('click','#bconfirm',function(e)
	{	e.preventDefault();
		$(".error").fadeOut();

        // fungsi looping
    	favorite = [];
        $.each($("input[name='cek[]']:checked"), function(){            
            favorite.push($(this).val());
        });
        // alert("My favourite sports are: " + favorite.join(", "));
        $("#myModal4").modal('show');
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

	// calculate distance
	$(document).on('click','#bcalculate',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var input = $("#tcoordinate").val();
		var url = sites_api +"/calculate_distance";

		var nilai = '{ "to":"'+input+'" }';
		
		$.ajax({
			type: 'POST',
			url: url,
			data: nilai,
			cache: false,
			contentType: "application/json",
            dataType: 'json',
			headers: { "cache-control": "no-cache" },
			success: function(result) {
				
				$("#tdistance").val(result.result);
			}
		})
		return false;
	});
	
   // fungsi ajax form sales
	$('#salesformdata').submit(function() {

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
			        error_mess(1,res[1],0);
					
				    var url = sites_get +"/"+ res[2];
		            window.location.href = url;
				}
				else if (res[0] == 'warning'){ error_mess(2,res[1],0); }
				else{ error_mess(3,res[1],0); }
			},
			error: function(e) 
	    	{
				$("#error").html(e).fadeIn();
				console.log(e.responseText);	
	    	} 
		})
		return false;
	});

	// ajax transaction data 
	$('#ajaxtransform,#ajaxtransform1').submit(function() {

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
			        error_mess(1,res[1],0);
					location.reload(true);
				}
				else if (res[0] == 'warning'){ error_mess(2,res[1],0); }
				else{ error_mess(3,res[1],0); }
			},
			error: function(e) 
	    	{
				$("#error").html(e).fadeIn();
				console.log(e.responseText);	
	    	} 
		})
		return false;
	});

		// fungsi ajax get customer
	$(document).on('change','#ccustomer',function(e)
	{	
		e.preventDefault();
		var value = $("#ccustomer").val();
		var url = sites+'/get_customer/'+value;

		if (value){ 
		    // batas
			$.ajax({
				type: 'POST',
				url: url,
	    	    cache: false,
				headers: { "cache-control": "no-cache" },
				success: function(result) {
				var res = result.split('|');
				$("#temail").val(res[0]);
				$("#tshipadd,#tshipaddkurir").val(res[1]);
				}
			})
			return false;

		}else { swal('Error Load Data...!', "", "error"); }

	});

	// ckship
	$('#ckship').change(function() {
        if($(this).is(":checked")) {
          
          var par = $("#tshipadd").val();	
          $("#tshipaddkurir").val(par);

        }else { $("#tshipaddkurir").val(""); }
    });

	// get details product
	$(document).on('change','#cproduct',function(e)
	{	
		e.preventDefault();

		var pid = $("#cproduct").val();
		var url = sites+'/get_product/'+pid;

		if (pid){
	    // batas
		$.ajax({
			type: 'POST',
			url: url,
    	    cache: false,
			headers: { "cache-control": "no-cache" },
			success: function(result) {
			res = result.split('|');
				$("#tprice").val(res[0]); 
				console.log(res[1]);
			}
		})
		return false; }else { $("#tprice").val('0');  }
	});

	$(document).on('change','#cpackage',function(e)
	{	
		e.preventDefault();

		var packages = $("#cpackage").val();
		var weight = $("#tweight").val();

		var res = packages.split('|');
		var nilai = parseInt(res[1]*weight);
		var url = sites+'/ongkir/278/110/pos/'+nilai;

	    // batas
		$.ajax({
			type: 'POST',
			url: url,
    	    cache: false,
			headers: { "cache-control": "no-cache" },
			success: function(result) {
			$("#shipn").html(result);
			$("#rate").val(res[1]);
			}
		})
		return false;
	});

	$('#searchform').submit(function() {
		
		var cust = $("#ccust").val();
		var sales = $("#tsales").val();
		var ship = $("#cship").val();
		var received = $("#creceived").val();
		var param = ['searching',cust,sales,ship,received];

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
				if (!param[4]){ param[4] = 'null'; }
				load_data_search(param);
			}
		});
		return false;
		swal('Error Load Data...!', "", "error");
		
	});	


		
// document ready end	
});


	function load_data_search(search)
	{
		$(document).ready(function (e) {
			
			var oTable = $('#datatable-buttons').dataTable();
			var stts = 'btn btn-danger';
			var received = 'btn btn-danger';
			
		    $.ajax({
				type : 'GET',
				url: source+"/"+search[0]+"/"+search[1]+"/"+search[2]+"/"+search[3]+"/"+search[4],
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
			if (s[i][7] == null){ received = 'btn btn-danger'; }else { received = 'btn btn-success'; }
			oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
						  i+1,
						  s[i][1]+'<br>'+s[i][2],
						  s[i][3],
						  s[i][4],
						  s[i][5]+'<br> <b>'+s[i][6]+' km </b>',
						  s[i][8],
'<div class="btn-group" role"group">'+
'<a href="" class="'+stts+' btn-xs primary_status" id="' +s[i][0]+ '" title="Confirmation Status"> <i class="fa fa-power-off"> </i> </a> '+
'<a href="" class="btn btn-success btn-xs text-print" id="' +s[i][0]+ '" title="Invoice Status"> <i class="fa fa-print"> </i> </a> '+
'<a href="" class="'+received+' btn-xs text-confirmation" id="' +s[i][0]+ '" title="Deliver Status"> <i class="fa fa-truck"> </i> </a> '+
'<a href="" class="btn btn-warning btn-xs text-tracker" id="' +s[i][0]+ '" title="Track"> <i class="fa fas-2x fa-search"> </i> </a> '+
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
			var received = 'btn btn-danger';
			
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
						  if (s[i][7] == null){ received = 'btn btn-danger'; }else { received = 'btn btn-success'; }
						  oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][1]+'<br>'+s[i][2],
										s[i][3],
										s[i][4],
										s[i][5]+'<br> <b>'+s[i][6]+' km </b>',
										s[i][8],
'<div class="btn-group" role"group">'+
'<a href="" class="'+stts+' btn-xs primary_status" id="' +s[i][0]+ '" title="Confirmation Status"> <i class="fa fa-power-off"> </i> </a> '+
'<a href="" class="btn btn-success btn-xs text-print" id="' +s[i][0]+ '" title="Invoice Status"> <i class="fa fa-print"> </i> </a> '+
'<a href="" class="'+received+' btn-xs text-confirmation" id="' +s[i][0]+ '" title="Deliver Status"> <i class="fa fa-truck"> </i> </a> '+
'<a href="" class="btn btn-warning btn-xs text-tracker" id="' +s[i][0]+ '" title="Track"> <i class="fa fas-2x fa-search"> </i> </a> '+
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
	
	function load_form()
	{
		$(document).ready(function (e) {
			
		  	$.ajax({
				type : 'GET',
				url: source,
				//force to handle it as text
				contentType: "application/json",
				dataType: "json",
				success: function(data) 
				{   
					// alert(data[0][1]);
					$("#tname").val(data[0][1]);
					$("#taddress").val(data[0][2]);
					$("#ccity").val(data[0][13]).change();
					$("#tzip").val(data[0][9]);
					$("#tphone").val(data[0][3]);
					$("#tphone2").val(data[0][4]);
					$("#tmail").val(data[0][5]);
					$("#tbillmail").val(data[0][6]);
					$("#ttechmail").val(data[0][7]);
					$("#tccmail").val(data[0][8]);
					$("#taccount_name").val(data[0][10]);
					$("#taccount_no").val(data[0][11]);
					$("#tbank").val(data[0][12]);
					$("#tsitename").val(data[0][14]);
					$("#tmetadesc").val(data[0][15]);
					$("#tmetakey").val(data[0][16]);
					$("#catimg_update").attr("src","");
					$("#catimg_update").attr("src",base_url+"images/property/"+data[0][17]);
			   
				},
				error: function(e){
				   //console.log(e.responseText);	
				}
				
			});  
			
	    });  // end document ready	
	}
	