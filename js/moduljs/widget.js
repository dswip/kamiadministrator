$(document).ready(function (e) {
	
    // function general
	
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
			   var val = res[6].split(",");
			   
			   $("#tid_update").val(res[0]);
			   $("#tname_update").val(res[1]);
			   $("#ttitle_update").val(res[2]);
			   $("#torder_update").val(res[5]);
			   $("#tlimit_update").val(res[8]);
			   
			   // $("#cposition_update option[value='"+res[3]+"']").prop('selected', true);
			   $('#cposition_update').val(res[3]).change();
			   $('#cmore_update').val(res[7]).change();
			   $("#cmenu_update").val(val).change();
			   
			   // rstatus
			   if (res[4] == 1){ $("#rpublish1").prop( "checked", true );  }
			   else { $("#rpublish0").prop( "checked", true ); }
			}   
		);
		
	});
		
// document ready end	
});

    // fungsi load data
	function load_data()
	{
		$(document).ready(function (e) {
			
			var oTable = $('#datatable-buttons').dataTable();
			
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
						  oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][1],
										s[i][2],
										s[i][3],
										s[i][5],
										s[i][7],
										s[i][8],
										s[i][4],
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
	
	// batas fungsi load data
	function resets()
	{  
	   $(document).ready(function (e) {
		  // reset form
		  $("#tname, #ttitle, #cposition, #torder, #tlimit").val("");
		  $("#cmenu option:selected").prop("selected", false);
		  $("#cmore option:selected").prop("selected", false);
	  });
	}
	