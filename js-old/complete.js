
		  $(document).ready(function(){
		  
			// $('#bnews').hide();
			
			// input-masked
			$("#d1,#d2,#d3,#d4,#d5,#d6,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d14,#d15,#d16").mask("9999-99-99");
			$("#tweight").mask("99.9");
			$("#tphone").mask("099-9999999");
			$("#ttime").mask("99:99");
			
			// $('.flexme').flexigrid({height:'auto',width:845,striped:true});
			
			
			
			
			// tabs
			$(".tab_content").hide(); //Hide all content
			$("ul.tabs li:first").addClass("active").show(); //Activate first tab
			$(".tab_content:first").show(); //Show first tab content
			
			//On Click Event
			$("ul.tabs li").click(function() {
				$("ul.tabs li").removeClass("active"); //Remove any "active" class
				$(this).addClass("active"); //Add "active" class to selected tab
				$(".tab_content").hide(); //Hide all tab content
				var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
				$(activeTab).fadeIn(); //Fade in the active content
				return false;
			});
			// akhir tabs
			
			// pilih semua input dan terapkan tooltip pada semua input 
			// $(".myform :input").tooltip({
			  // position: "center right",
        	  // offset: [-2, 10],
			  // effect: "fade",
			  // opacity: 0.7,
		      // tip: '.tooltip'
		    // });
				
			$("a.fancy").fancybox({
				'titlePosition'		: 'outside',
				'overlayColor'		: '#000',
				'overlayOpacity'	: 0.9
			});
			
			$(".editstatus, .update").fancybox({
				'width': '75%',
				'height': '100%',
				'overlayColor' : '#000',
				'autoScale': true,
				'transitionIn': 'fade',
				'transitionOut': 'fade',
				'type': 'iframe',
				'href': this.href,
				'onClosed': function() { parent.location.reload(true)}
			});
			
			 // $('#datetimepicker').datetimepicker({ format: 'yyyy-MM-dd'});
			
			// Batas select action
			
			// hide / show
		
			  // Load Page di awal
			 // $("#obj2").hide();
			 // $("#bhide").hide();
			 
			 // Tampilkan DIV ID=Form setelah klik A ID=ShowForm
			 // $("#bshow").click(function(){
				 // $("#obj2").fadeIn();
				 // $("#bhide").fadeIn();
				 // $("#bshow").hide();
			 // });
			 
			 // sembunyi DIV ID=Form setelah klik A ID=ShowForm
			 // $("#bhide").click(function(){
				 // $("#obj2").hide();
				 // $("#bhide").hide();
				 // $("#bshow").fadeIn();
			 // });
			
			
			// $('#ccity').change(function() {				
				// $.ajax({
				// type: 'POST',
				// url: uri +'getlocation',
				// data: $(this).serialize(),
				// success: function(data)
				// {
				   // $("#clocation").hide();
				   // document.getElementById("cityplace").innerHTML = data;
				// }
				// })
				// return false;
    	    // });
			

			// $('#ccategory').change(function() {
				// $.ajax({
				// type: 'POST',
				// url: uri +'getcode',
				// data: $(this).serialize(),
				// success: function(data)
				// {
				   // document.getElementById("tcode").value = data;
				// }
				// })
				// return false;
    	    // });
			
			
			// menu function
			
			$('#ctypefront').change(function() {
                var types = $("#ctypefront").val();
				if (types == "article")
				{$('#bnewsplace').fadeIn(); $('#cmodul').fadeOut(); $('#ccat').fadeOut();}
				else if(types == "modul")
				{
				   $('#bnewsplace').fadeOut();
				    $.ajax({
						type: 'POST',
						url: uri +'modultypefront',
						data: $(this).serialize(),
						success: function(data)
						{
						   document.getElementById("valueplace").innerHTML = data;
						}
					})
					return false;
				}
				else if(types == "articlelist")
				{
				   $('#bnewsplace').fadeOut();
				    $.ajax({
						type: 'POST',
						url: uri +'modultypefront',
						data: $(this).serialize(),
						success: function(data)
						{
						   document.getElementById("valueplace").innerHTML = data;
						}
					})
					return false;
				}
				else if(types == "url")
				{
					$('#bnewsplace').fadeOut(); $('#cmodul').fadeOut(); $('#ccat').fadeOut();
					document.getElementById("turl").value = "";
				}
    	    });
			
			// /* Insert ajax */
			
			// // $('#form').submit(function() {
				// // $.ajax({
					// // type: 'POST',
					// // url: $(this).attr('action'),
					// // data: $(this).serialize(),
					// // success: function(data) {
				    // // $('#webadmin2').html(data);	
				  // // }
				// // })
				// // return false;
			// // });
			
			$('#ajaxform').submit(function() {
				$.ajax({
					type: 'POST',
					url: $(this).attr('action'),
					data: $(this).serialize(),
					success: function(data) {
						// $('#result').html(data);
						if (data == "true")
						{
							location.reload(true);
						}
						else
						{
							// alert(data);
							document.getElementById("errorbox").innerHTML = data;
						}
						
					}
				})
				return false;
			});
			
			/* == ============ batas insert ajax ================*/
			
			// $('#ctest').change(function() {
				
				// $.ajax({
				// type: 'POST',
				// url: uri +'getcustomer',
				// data: $(this).serialize(),
				// success: function(data)
				// {
				   // alert(data);
				// }
				// })
				// return false;
    	    // });
			
			//end document ready
		  });
