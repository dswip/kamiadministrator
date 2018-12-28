$(document).ready(function (e) {
	
    // function general
	
    $('#bnewsplace,#bnewsplaceupdate').hide();

	$('#datatable-buttons').dataTable({
	 dom: 'T<"clear">lfrtip',
		tableTools: {"sSwfPath": site}
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
		
		$("#myModal2").modal('show');
		$.post(url,
			{id:$(this).attr('data-id')},
			function(result)
			{
			   res = result.split("|");
				
			   $("#tid_update").val(res[0]);
               $('#cparent_update').val(res[1]).change();

			   if (res[2] == 'top'){ $("#rposition0").prop( "checked", true );  }
			   else if(res[2] == 'middle'){ $("#rposition1").prop( "checked", true ); }
			   else if(res[2] == 'bottom'){ $("#rposition2").prop( "checked", true ); }

			   $("#tname_update").val(res[3]);
			   $("#ctypefrontupdate").val(res[4]);
			   $("#turl_update").val(res[5]);
			   $("#tmenuorder_update").val(res[6]);
			   $("#tclass_update").val(res[7]);
			   $("#tidstyle_update").val(res[8]);
			   $("#tlimit_update").val(res[10]);
			   $("#ctarget_update").val(res[12]);
			}   
		);
		
	});


	// publish status
	$(document).on('click','.primary_status',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_primary +"/"+ del_id;
		$(".error").fadeOut();
		
		$.ajax({
			type: 'POST',
			url: url,
    	    cache: false,
			headers: { "cache-control": "no-cache" },
			success: function(result) {
				load_data();
			}
		})
		return false;	
	});

	// fungsi get url type

	$('#ctypefront,#ctypefrontupdate').change(function() {
        var types = $(this).val();

		if (types == "article"){ 
			$('#bnewsplace,#bnewsplaceupdate').fadeIn(); $('#cmodul').fadeOut(); $('#ccat').fadeOut(); 
		}
		else if(types == "modul" || types == "articlelist"){

		   $('#bnewsplace,#bnewsplaceupdate').fadeOut();
		    $.ajax({
				type: 'POST',
				url: sites +'/modultypefront',
				data: $(this).serialize(),
				success: function(data)
				{
				   $("#valuebox,#valueplace_update").html(data);
				}
			})
			return false;
		}
		else if(types == "url"){
			$('#bnewsplace,#bnewsplaceupdate').fadeOut(); $('#cmodul').fadeOut(); $('#ccat').fadeOut();
			$("#turl,#turl_update").val("");
		}

    });
		
// document ready end	
});

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
						  if (s[i][11] == 1){ stts = 'btn btn-success'; }else { stts = 'btn btn-danger'; }	
						  oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][1], // parent
										s[i][3], // name
										s[i][2], // position
										s[i][4], // type
										s[i][6], // order
										s[i][7], // class
										s[i][8], // id
										s[i][10], // target
										s[i][12], // status
'<div class="btn-group" role"group">'+
'<a href="" class="'+stts+' btn-xs primary_status" id="' +s[i][0]+ '" title="Primary Status"> <i class="fa fa-power-off"> </i> </a>'+
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
	
	// batas fungsi load data
	function resets()
	{  
	   $(document).ready(function (e) {
		  // reset form
		  $("#tname, #turl, #tmenuorder, #tclass, #tid, #ctarget, #cstatus").val("");
		  $('#cparent,#cmodul').val("").change();
	  });
	}
	