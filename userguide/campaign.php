<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#252525">
	
	<title>Delica Calculator - User Guide</title>
	
    <link rel="icon" href="icon.png">
    
	<link rel="stylesheet" href="css/style.css">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <!-- Add fancyBox -->
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css">
    
    <style>
		body {
			background-color: black;
		}
	</style>

    
</head>

<body>
<!-------------HEADER----------------->
<?php include 'includes/header.php';?>
<!-------------/HEADER---------------->


<div class="container-fluid" id="main">
    <div class="col-md-12">
        <h2 class="ff2 mid mbtm">Marketing</h2>
        <p class="ff" style="text-indent:40px;font-size: 18px;">Halaman untuk mengatur kegiatan pemasaran/marketing.</p>
    </div>
    
    <div class="col-md-12">
        <h2 class="ff2">Campaign</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/6marketing/campaign.PNG" data-fancybox data-caption="Campaign"><img src="screenshots/6marketing/campaign.PNG" alt="" class="img-responsive"></a>
    </div>
	<div class="col-md-12 mtopbtm">
		<span class="ff" style="font-size: 18px;">
			<ol>
			    <li>Klik field untuk menampilkan data yang akan di-filter.</li>
			    <li>Tombol</li>
			    <ul>
			    	<li>Filter : Tombol untuk memfilter data.</li>
			    	<li>Clear : Tombol untuk membersihkan field.</li>
			    	<li>Reset : Tombol untuk me-reset.</li>
			    </ul>
			    <li>Klik tombol untuk mencetak.</li>
			    <li>Klik field untuk menampilkan banyaknya data pada tabel.</li>
			    <li>Klik field untuk melakukan pencarian.</li>
			    <li>Tombol.</li>
			    <ul>
			    	<li>Tombol Hijau : Tombol untuk mengganti status.</li>
			    	<li>Tombol Orange : Tombol untuk mencetak invoice.</li>
			    	<li>
			    		Tombol Biru : Tombol untuk melakukan Edit Data.
			    		<a href="screenshots/6marketing/marketingedit.png" data-fancybox data-caption="Edit Marketing"><img src="screenshots/6marketing/marketingedit.png" alt="" class="img-responsive" width="500"></a>
			    	</li>
			    	<li>Tombol Merah : Tombol untuk menghapus data.</li>
			    </ul>
			    <li>Halaman tabel.</li>
			    <ul>
			    	<li>Previous : Tombol untuk melihat data sebelumnya.</li>
			    	<li>Next : Tombol untuk melihat data selanjutnya.</li>
			    </ul>
			    <li>Tombol untuk melakukan penghapusan pada data yang telah dipilih.</li>
			    <li>Tombol.</li>
			    <ul>
			    	<li>
			    		Add New : Tombol untuk menambah data.
			    		<a href="screenshots/6marketing/addnew.png" data-fancybox data-caption="Add New Marketing"><img src="screenshots/6marketing/addnew.png" alt="" class="img-responsive" width="500"></a>
			    	</li>
			    	<li>Back : Tombol untuk kembali ke halaman Dashboard.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
</div>

<div class="container mtop mbtm2">
	<a href="sales" class="cbutton2 ff2"><span>Previous</span></a>
	<a href="menu" class="cbutton ff2" style="float:right;"><span>Next</span></a>
</div>


<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery.fancybox.min.js"></script>


<script>
$('[data-fancybox]').fancybox({
  buttons : [
	'zoom',
	'close'
  ]
});	
</script>

<script type="text/javascript">
    $(function() {
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});
</script>



</body>
</html>