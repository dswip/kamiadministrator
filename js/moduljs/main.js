$(document).ready(function (e) {
	
    // modal dialog
    $('#myModal,#myModal2,#myModal3,#myModal4,#myModal5').on('hidden.bs.modal', function () {
	  load_data();
    })
	
	$('#myModal').on('show.bs.modal', function () {
	  resets();
    })
	
    	// ajax loading

	$(document).ajaxStart(function(){
        $(".loader").css("display", "block");
    });
    $(document).ajaxComplete(function(){
        $(".loader").css("display", "none");
    });

   
    // function general
	$("#error,#success,#warning").hide();
	$(".error,.success,.warning,#loading").hide();

	// ajax form untuk form non modal
	
	$('#ajaxform,#ajaxform2,#ajaxform3,#ajaxform4').submit(function() {
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
					load_form();
					// location.reload(true);
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
	
	$('#ajaxformdata,#ajaxformdata2').submit(function() {
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
					load_data();
					resets();
					// location.reload(true);
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
	
	$('#cekallform').submit(function() {
		
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
				res = data.split("|");
				if (res[0] == "true")
				{
					load_data();
					error_mess(1,res[1],0);
				}
				else if(res[0] == 'error') { error_mess(3,res[1],0); }
				else{ 
				  load_data();
				  error_mess(2,res[1],0);
			    }
			},
			error: function(e) 
	    	{
				$("#error").html(e).fadeIn();
				console.log(e.responseText);	
	    	} 
		})
		return false;
	});
	
	// ================================================== delete ajax ===============================================
	
	$(document).on('click','.text-danger',function(e){
	
	e.preventDefault();
	
	var element = $(this);
	var del_id = element.attr("id");
	var info = 'id=' + del_id;
	
	 swal({
		title: "Are you sure?",
		text: "",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, I am sure!',
		cancelButtonText: "No, cancel it!",
		closeOnConfirm: true,
		closeOnCancel: true
	   },
	   function(isConfirm)
	   {
			if (isConfirm){  
			 
			  // alert(sites_del +"/"+ del_id);  
			  $.ajax({
				type: 'POST',
				url: sites_del +"/"+ del_id,
				data: $(this).serialize(),
				success: function(data)
				{
					console.log(data);
					res = data.split("|");
					if (res[0] == 'true'){ error_mess(1,res[1],0); }
					else if(res[0] == 'error') { error_mess(3,res[1],0); }
					else { error_mess(2,res[1],0); }
				    load_data();
				}
				})
				return false; 
			}
	   });
	
	});
	
	// form untuk upload data
	$("#upload_form").on('submit',(function(e) {
		
		e.preventDefault();
		$.ajax({
		    url: $(this).attr('action'),
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			beforeSend : function()
			{
				//$("#preview").fadeOut();
			},
			success: function(data)
		    {
				res = data.split("|");
				if(res[0]=='true')
				{
					// invalid file format.
					error_mess(1,res[1],1); 
					if (res[2]){ $("#catimg").attr("src",res[2]); }
				}
				else if (res[0] == 'warning'){ error_mess(2,res[1],1); }
				else if (res[0] == 'error'){ error_mess(3,res[1],1); }
		    },
		  	error: function(e) 
	    	{
				$("#error").html(e).fadeIn();
				console.log(e.responseText);	
	    	} 
				        
	   });
	     
	}));
	
	// ajax form non upload data
	$("#upload_form_non,#edit_form_non").on('submit',(function(e) {
		
		var elem = $(this);
		e.preventDefault();
		$.ajax({
        	url: $(this).attr('action'),
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			beforeSend : function()
			{
				//$("#preview").fadeOut();
			},
			success: function(data)
		    {
				res = data.split("|");
				
				if(res[0]=='true')
				{
					// invalid file format.
					error_mess(1,res[1]);
					if (elem.attr('id') == "upload_form_non"){ resets(); }
				}
				else if(res[0] == 'warning'){ error_mess(2,res[1]); }
				else if(res[0] == 'error'){ error_mess(3,res[1]); }
		    },
		  	error: function(e) 
	    	{
				//$("#error").html(e).fadeIn();
				error_mess(3,e);
				console.log(e.responseText);	
	    	} 	        
	   });
	     
	}));
	
	/*  edit form dengan upload  */
	$("#upload_form_edit").on('submit',(function(e) {
		
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			beforeSend : function()
			{
				//$("#preview").fadeOut();
			},
			success: function(data)
		    {
				res = data.split("|");
				if(res[0]=='warning')
				{
					// invalid file format.
					error_mess(2,res[1],1);
				}
				else if(res[0]=='error') { error_mess(3,res[1]); }
				else if (res[0] == 'true')
				{
					// view uploaded file.
					error_mess(1,res[1],1);
					if (res[2]){ $("#catimg_update").attr("src",""); 
					  $("#catimg_update").attr("src",res[2]);
					}

					$('#myModal2').modal('hide');
				    location.reload(true);
				}
		    },
		  	error: function(e) 
	    	{
				$("#err").html(e).fadeIn();
				console.log(e.responseText);	
	    	} 	        
	   });
	   
	}));
	
	
	// =============================================================================================================
		

// document ready end	
});


	// function errorbox
	function error_mess (type,mess,pages=1)
	{
	  $(document).ready(function (e) {
		  
		if (pages == 1)  
		{
			/* pop up window */
		  if (type == 1){ $(".success").html(mess).fadeIn(); setTimeout(function() { $(".success").fadeOut(); }, 3000); }
          else if (type == 2){ $(".warning").html(mess).fadeIn(); setTimeout(function() { $(".warning").fadeOut(); }, 3000); }
	      else if (type == 3){ $(".error").html(mess).fadeIn(); setTimeout(function() { $(".error").fadeOut(); }, 3000); }
		}
		else{
		  /* parent window */
		  if (type == 1){ $("#success").html(mess).fadeIn(); setTimeout(function() { $("#success").fadeOut(); }, 3000); }
          else if (type == 2){ $("#warning").html(mess).fadeIn(); setTimeout(function() { $("#warning").fadeOut(); }, 3000); }
	      else if (type == 3){ $("#error").html(mess).fadeIn(); setTimeout(function() { $("#error").fadeOut(); }, 3000); }
		}
	   
	   // document ready end	
      });
	}

