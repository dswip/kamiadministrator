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
        <h2 class="ff2 mid mbtm">Front Menu</h2>
        <p class="ff" style="text-indent:40px;font-size: 18px;">Halaman untuk mengatur menu pada website utama.</p>
    </div>
    
    <div class="col-md-12">
        <h2 class="ff2">Add Front Menu</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/7menu/1front1.png" data-fancybox data-caption="Front Menu"><img src="screenshots/7menu/1front1.png" alt="" class="img-responsive" width="600"></a>
    </div>
	<div class="col-md-12 mtopbtm">
		<span class="ff" style="font-size: 18px;">
			<ol>
			    <li>Isikan field dengan data yang valid.</li>
			    <li>Tombol</li>
			    <ul>
			    	<li>Save : Tombol untuk menyimpan data pada form yang telah terisi.</li>
			    	<li>Reset : Tombol untuk membersihkan field.</li>
			    </ul>
			    <li>Tombol</li>
			    <ul>
			    	<li>Finish : Tekan tombol untuk konfirmasi selesai pengisian form.</li>
			    	<li>Next : Tombol untuk menuju form selanjutnya.</li>
			    	<li>Preivous : Tombol untuk menuju form sebelumnya.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div class="col-md-12">
        <h2 class="ff2">Front Menu List</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/7menu/1front2.png" data-fancybox data-caption="Front Menu List"><img src="screenshots/7menu/1front2.png" alt="" class="img-responsive"></a>
    </div>
	<div class="col-md-12 mtopbtm">
		<span class="ff" style="font-size: 18px;">
			<ol>
			    <li>Klik tombol untuk mencetak.</li>
			    <li>Klik field untuk menampilkan banyaknya data pada tabel.</li>
			    <li>Klik field untuk melakukan pencarian.</li>
			    <li>Tombol.</li>
			    <ul>
			    	<li>Tombol Merah : Tombol untuk mengubah status.</li>
			    	<li>
			    	    Tombol Biru : Tombol untuk melakukan Edit Data.
			    	    <a href="screenshots/7menu/1frontedit.PNG" data-fancybox data-caption="Edit Front Menu"><img src="screenshots/7menu/1frontedit.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Tombol Merah : Tombol untuk menghapus data.</li>
			    </ul>
			    <li>Halaman tabel.</li>
			    <ul>
			    	<li>Previous : Tombol untuk melihat data sebelumnya.</li>
			    	<li>Next : Tombol untuk melihat data selanjutnya.</li>
			    </ul>
			    <li>Tombol untuk melakukan penghapusan pada data yang telah dipilih.</li>
				<li>Back : Tombol untuk kembali ke halaman Dashboard</li>
			</ol>
		</span>
	</div>
	
	
	
	<div id="2" class="col-md-12">
        <h2 class="ff2 mid mbtm">Admin Menu</h2>
        <p class="ff" style="text-indent:40px;font-size: 18px;">Halaman untuk mengatur menu pada website admin.</p>
    </div>
    
    <div class="col-md-12">
        <h2 class="ff2">Add Admin Menu</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/7menu/2admin1.png" data-fancybox data-caption="Admin Menu"><img src="screenshots/7menu/2admin1.png" alt="" class="img-responsive" width="600"></a>
    </div>
	<div class="col-md-12 mtopbtm">
		<span class="ff" style="font-size: 18px;">
			<ol>
			    <li>Isikan field dengan data yang valid.</li>
			    <li>Tombol</li>
			    <ul>
			    	<li>Save : Tombol untuk menyimpan data pada form yang telah terisi.</li>
			    	<li>Reset : Tombol untuk membersihkan field.</li>
			    </ul>
			    <li>Tombol</li>
			    <ul>
			    	<li>Finish : Tekan tombol untuk konfirmasi selesai pengisian form.</li>
			    	<li>Next : Tombol untuk menuju form selanjutnya.</li>
			    	<li>Preivous : Tombol untuk menuju form sebelumnya.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div class="col-md-12">
        <h2 class="ff2">Admin Menu List</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/7menu/2admin2.png" data-fancybox data-caption="Admin Menu List"><img src="screenshots/7menu/2admin2.png" alt="" class="img-responsive"></a>
    </div>
	<div class="col-md-12 mtopbtm">
		<span class="ff" style="font-size: 18px;">
			<ol>
			    <li>Klik tombol untuk mencetak.</li>
			    <li>Klik field untuk menampilkan banyaknya data pada tabel.</li>
			    <li>Klik field untuk melakukan pencarian.</li>
			    <li>Tombol.</li>
			    <ul>
			    	<li>
			    	    Tombol Biru : Tombol untuk melakukan Edit Data.
			    	    <a href="screenshots/7menu/2adminedit.PNG" data-fancybox data-caption="Edit Admin Menu"><img src="screenshots/7menu/2adminedit.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Tombol Merah : Tombol untuk menghapus data.</li>
			    </ul>
			    <li>Halaman tabel.</li>
			    <ul>
			    	<li>Previous : Tombol untuk melihat data sebelumnya.</li>
			    	<li>Next : Tombol untuk melihat data selanjutnya.</li>
			    </ul>
			    <li>Tombol untuk melakukan penghapusan pada data yang telah dipilih.</li>
				<li>Back : Tombol untuk kembali ke halaman Dashboard</li>
			</ol>
		</span>
	</div>
	
</div>

<div class="container mtop mbtm2">
	<a href="campaign" class="cbutton2 ff2"><span>Previous</span></a>
	<a href="configuration" class="cbutton ff2" style="float:right;"><span>Next</span></a>
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