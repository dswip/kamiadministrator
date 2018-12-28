<script src="<?php echo base_url(); ?>js-old/register.js"></script>
<script type="text/javascript">

	var sites_add  = "<?php echo site_url('courier/add_process/');?>";
	var sites_edit = "<?php echo site_url('courier/update_process/');?>";
	var sites_del  = "<?php echo site_url('courier/delete/');?>";
	var sites_get  = "<?php echo site_url('courier/update/');?>";
    var sites_ajax  = "<?php echo site_url('courier/');?>";
	var source = "<?php echo $source;?>";
	
</script>

          <div class="row"> 
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel" >
              
              <!-- xtitle -->
              <div class="x_title">
              
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                </ul>
                
                <div class="clearfix"></div>
              </div>
              <!-- xtitle -->
                
                <div class="x_content">
                      
                  
             <!-- Smart Wizard -->
<div id="wizard" class="form_wizard wizard_horizontal">
  
  <ul class="wizard_steps">
    <li>
      <a href="#step-1">
        <span class="step_no">1</span>
        <span class="step_descr"> <small> General </small> </span>
      </a>
    </li>
   
  </ul>
  
  <div id="errors" class="alert alert-danger alert-dismissible fade in" role="alert"> 
     <?php $flashmessage = $this->session->flashdata('message'); ?> 
	 <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> 
  </div>
  
  <div id="step-1">
    
    <style type="text/css">
        #mapCanvas{ width: 100%; height: 400px;}  
    </style>
    
    <input type="hidden" id="hlat" value="<?php echo $lat; ?>">
    <input type="hidden" id="hlong" value="<?php echo $long; ?>">
    <div id="mapCanvas"></div>
    
  </div>
  
</div>
<!-- End SmartWizard Content -->
                      
     </div>
       
       <!-- links -->
       <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?>
       <!-- links -->
                     
    </div>
  </div>
    
    <!-- Place this tag in your head or just before your close body tag. -->
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAG_XxJt7OYEkXFTo9MmxC-ec73At7pwhs"></script>
<script type="text/javascript">

$(document).ready(function (e) {
    
var lat = parseFloat($("#hlat").val());
var long = parseFloat($("#hlong").val());
var courier = "<?php echo $curid; ?>";
    
var pos = setInterval(getpos, 5000);

function getpos() {
    
    $.get(sites_ajax+"/get_loc/"+courier, function(data, status){
        res = data.split(",");
        var result = [parseFloat(res[0]), parseFloat(res[1])];
        transition(result);
    });
    
}
    
var position = [lat,long];   

function initialize() { 
    var latlng = new google.maps.LatLng(position[0], position[1]);
    var myOptions = {
        zoom: 15,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);

    marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: "Latitude:"+position[0]+" | Longitude:"+position[1]
    });

//    google.maps.event.addListener(map, 'click', function(event) {
//        var result = [event.latLng.lat(), event.latLng.lng()];
//        transition(result);
//    });
}

//Load google map
google.maps.event.addDomListener(window, 'load', initialize);


var numDeltas = 100;
var delay = 10; //milliseconds
var i = 0;
var deltaLat;
var deltaLng;

function transition(result){
    i = 0;
    deltaLat = (result[0] - position[0])/numDeltas;
    deltaLng = (result[1] - position[1])/numDeltas;
    moveMarker();
}

function moveMarker(){
    position[0] += deltaLat;
    position[1] += deltaLng;
    var latlng = new google.maps.LatLng(position[0], position[1]);
	marker.setTitle("Latitude:"+position[0]+" | Longitude:"+position[1]);
    marker.setPosition(latlng);
    if(i!=numDeltas){
        i++;
        setTimeout(moveMarker, delay);
    }
}  
    
// document ready end	
});    
    
</script>
    
    
