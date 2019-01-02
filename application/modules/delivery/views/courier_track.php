<script src="<?php echo base_url(); ?>js-old/register.js"></script>

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
  
  <h4> <?php echo $code; ?> / <?php echo $dates; ?> WIB / <?php echo $courier_ic; ?> : <?php echo $courier; ?> </h4>
  <p style="font-size:11pt; color:#000;"> <?php echo $customer; ?> / <?php echo $cust_phone; ?> <br> 
  <?php echo $cust_address; ?> </p>
  
  <div id="step-1">
    
    <style type="text/css">
        #mapCanvas{ width: 100%; height: 500px;}  
    </style>
    
    <input type="hidden" id="hlat" value="<?php echo $lat; ?>">
    <input type="hidden" id="hlong" value="<?php echo $long; ?>">
    <input type="hidden" id="hdlat" value="<?php echo $dlat; ?>">
    <input type="hidden" id="hdlong" value="<?php echo $dlong; ?>">
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
var dlat = parseFloat($("#hdlat").val());
var dlong = parseFloat($("#hdlong").val());
var courier = "<?php echo $curid; ?>";
var sites_ajax  = "<?php echo site_url('courier/');?>";
var iconkurir = "<?php echo base_url().'images/kurir.png';?>";
var iconperson = "<?php echo base_url().'images/person.png';?>";
    
var pos = setInterval(getpos, 10000);

function getpos() {
    
    $.get(sites_ajax+"/get_loc/"+courier, function(data, status){
        res = data.split(",");
        var result = [parseFloat(res[0]), parseFloat(res[1])];
        transition(result);
    });
    
}
    
var position = [lat,long]; 
var custaddress = [dlat, dlong];

function initialize() { 
    var latlng = new google.maps.LatLng(position[0], position[1]);
    var latlngcust = new google.maps.LatLng(custaddress[0], custaddress[1]);
    
    var myOptions = {
        zoom: 17,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);

//    marker = new google.maps.Marker({
//        position: latlngcust,
//        map: map,
//        icon: iconperson,
//        title: "Customer"
//    });
//    
//    marker = new google.maps.Marker({
//        position: latlng,
//        map: map,
//        icon: iconkurir,
//        title: "Courier"
//    });
    
var locations = [
    ['Los Angeles', 34.052235, -118.243683],
    ['Santa Monica', 34.024212, -118.496475],
    ['Redondo Beach', 33.849182, -118.388405],
    ['Newport Beach', 33.628342, -117.927933],
    ['Long Beach', 33.770050, -118.193739]
  ];
    
var infowindow =  new google.maps.InfoWindow({});
var marker, count;
for (count = 0; count < locations.length; count++) {
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[count][1], locations[count][2]),
          map: map,
          title: locations[count][0]
        });
        google.maps.event.addListener(marker, 'click', (function (marker, count) {
          return function () {
            infowindow.setContent(locations[count][0]);
            infowindow.open(map, marker);
          }
        })(marker, count));
}
     

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
    
    
