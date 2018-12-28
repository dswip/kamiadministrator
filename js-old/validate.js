
	  $(document).ready(function(){

		$("#form,.form").validate({
		    errorPlacement: function(error, element) {
			error.appendTo(element.parent("td"));
		}
	    });
		
	  });