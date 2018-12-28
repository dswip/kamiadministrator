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
        <h2 class="ff2 mid mbtm">Configuration</h2>
        <p class="ff" style="text-indent:40px;font-size: 18px;">Halaman untuk mengatur konfigurasi admin, jabatan, serta riwayat aktivitas.</p>
    </div>
    
    <div class="col-md-12">
        <h2 class="ff2">Web Admin</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/8configuration/1webadmin.PNG" data-fancybox data-caption="Web Admin"><img src="screenshots/8configuration/1webadmin.PNG" alt="" class="img-responsive"></a>
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
			    		<a href="screenshots/8configuration/1webadminedit.PNG" data-fancybox data-caption="Edit Web Admin"><img src="screenshots/8configuration/1webadminedit.PNG" alt="" class="img-responsive"></a>
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
			    		<a href="screenshots/8configuration/1webadminaddnew.PNG" data-fancybox data-caption="Add New Web Admin"><img src="screenshots/8configuration/1webadminaddnew.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Back : Tombol untuk kembali ke halaman sebelumnya.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="2" class="col-md-12">
        <h2 class="ff2">Component Manager</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/8configuration/2component.PNG" data-fancybox data-caption="Material Item"><img src="screenshots/8configuration/2component.PNG" alt="" class="img-responsive" width="600"></a>
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
			    	<li>
			    		Tombol Biru : Tombol untuk melakukan Update.
			    		<a href="screenshots/8configuration/2componentaddnew.PNG" data-fancybox data-caption="Add New Component Manager"><img src="screenshots/8configuration/2componentaddnew.PNG" alt="" class="img-responsive"></a>
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
			    		<a href="screenshots/8configuration/2componentaddnew2.PNG" data-fancybox data-caption="Add New Component Manager"><img src="screenshots/8configuration/2componentaddnew2.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Back : Tombol untuk kembali ke halaman sebelumnya.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="3" class="col-md-12">
        <h2 class="ff2">Widget List</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/8configuration/3widget.PNG" data-fancybox data-caption="Widget List"><img src="screenshots/8configuration/3widget.PNG" alt="" class="img-responsive"></a>
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
			    		<a href="screenshots/8configuration/3widgetedit.PNG" data-fancybox data-caption="Edit Widget List"><img src="screenshots/8configuration/3widgetedit.PNG" alt="" class="img-responsive"></a>
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
			    		<a href="screenshots/8configuration/3widgetaddnew.PNG" data-fancybox data-caption="Add New Widget List"><img src="screenshots/8configuration/3widgetaddnew.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Back : Tombol untuk kembali ke halaman sebelumnya.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="4" class="col-md-12">
        <h2 class="ff2">History</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/8configuration/4history.PNG" data-fancybox data-caption="History"><img src="screenshots/8configuration/4history.PNG" alt="" class="img-responsive"></a>
    </div>
	<div class="col-md-12 mtopbtm">
		<span class="ff" style="font-size: 18px;">
			<ol>
			    <li>Klik tombol untuk mencetak.</li>
			    <li>Klik field untuk menampilkan banyaknya data pada tabel.</li>
			    <li>Klik field untuk melakukan pencarian.</li>
			    <li>Tombol Merah : Tombol untuk menghapus data.</li>
			    <li>Halaman tabel.</li>
			    <ul>
			    	<li>Previous : Tombol untuk melihat data sebelumnya.</li>
			    	<li>Next : Tombol untuk melihat data selanjutnya.</li>
			    </ul>
			    <li>Tombol untuk melakukan penghapusan pada data yang telah dipilih.</li>
			    <li>Tombol.</li>
			    <ul>
			    	<li>Back : Tombol untuk kembali ke halaman sebelumnya.</li>
			    	<li>
			    		Error Log: Tombol untuk membuka halaman Error Log.
			    		<a href="screenshots/8configuration/4historyerrorlog.PNG" data-fancybox data-caption="Error Log"><img src="screenshots/8configuration/4historyerrorlog.PNG" alt="" class="img-responsive" width="600"></a>
			    	</li>
			    	<li class="mtop">
			    		Report : Tombol untuk menambah data.
			    		<a href="screenshots/8configuration/4historyreport.PNG" data-fancybox data-caption="Report"><img src="screenshots/8configuration/4historyreport.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="5" class="col-md-12">
        <h2 class="ff2">Role</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/8configuration/5role.PNG" data-fancybox data-caption="Role"><img src="screenshots/8configuration/5role.PNG" alt="" class="img-responsive"></a>
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
			    		<a href="screenshots/8configuration/5roleedit.PNG" data-fancybox data-caption="Edit Role"><img src="screenshots/8configuration/5roleedit.PNG" alt="" class="img-responsive"></a>
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
			    	<div class="col-md-4 col-xs-12">
			    		<li>
							Add New : Tombol untuk menambah data.
							<a href="screenshots//8configuration/5roleaddnew.PNG" data-fancybox data-caption="Add New Role"><img src="screenshots/8configuration/5roleaddnew.PNG" alt="" class="img-responsive"></a>
						</li>
			    	</div>
			    	<div class="col-md-4 col-xs-12">
			    		<li class="mtop">
							Report : Tombol untuk menambah data laporan.
						</li>
			    	</div>
			    	<div class="col-md-4 col-xs-12">
			    		<li class="mtop">Back : Tombol untuk kembali ke halaman Dashboard.</li>
			    	</div>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="6" class="col-md-12">
        <h2 class="ff2">Global Configuration</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/8configuration/6global.png" data-fancybox data-caption="Global Configuration"><img src="screenshots/8configuration/6global.png" alt="" class="img-responsive"></a>
    </div>
	<div class="col-md-12 mtopbtm">
		<span class="ff" style="font-size: 18px;">
			<ol>
			    <li>Isikan data yang valid pada form yang tersedia.</li>
			    <li>Tombol untuk menyimpan form yang telah diisi.</li>
			    <li>Tombol</li>
			    <ul>
			    	<li>Finish : Tekan tombol untuk konfirmasi selesai pengisian form.</li>
			    	<li>Next : Tombol untuk menuju form selanjutnya.</li>
			    	<li>Preivous : Tombol untuk menuju form sebelumnya.</li>
			    </ul>
			    <li>Tombol untuk kembali ke halaman Dashboard</li>
			</ol>
		</span>
	</div>
	
	<div class="col-md-8">
        <a href="screenshots/8configuration/6global2.PNG" data-fancybox data-caption="Global Configuration"><img src="screenshots/8configuration/6global2.PNG" alt="" class="img-responsive"></a>
    </div>
	<div class="col-md-12 mtopbtm">
		<span class="ff" style="font-size: 18px;">
			<ol>
			    <li>Isikan data yang valid pada form yang tersedia.</li>
			    <li>Tombol untuk menyimpan form yang telah diisi.</li>
			    <li>Tombol</li>
			    <ul>
			    	<li>Finish : Tekan tombol untuk konfirmasi selesai pengisian form.</li>
			    	<li>Next : Tombol untuk menuju form selanjutnya.</li>
			    	<li>Preivous : Tombol untuk menuju form sebelumnya.</li>
			    </ul>
			    <li>Tombol untuk kembali ke halaman Dashboard</li>
			</ol>
		</span>
	</div>
	
	<div class="col-md-8">
        <a href="screenshots/8configuration/6global3.png" data-fancybox data-caption="Global Configuration"><img src="screenshots/8configuration/6global3.png" alt="" class="img-responsive"></a>
    </div>
	<div class="col-md-12 mtopbtm">
		<span class="ff" style="font-size: 18px;">
			<ol>
			    <li>Isikan data yang valid pada form yang tersedia.</li>
			    <li>Tombol untuk menyimpan form yang telah diisi.</li>
			    <li>Tombol</li>
			    <ul>
			    	<li>Finish : Tekan tombol untuk konfirmasi selesai pengisian form.</li>
			    	<li>Next : Tombol untuk menuju form selanjutnya.</li>
			    	<li>Preivous : Tombol untuk menuju form sebelumnya.</li>
			    </ul>
			    <li>Tombol untuk kembali ke halaman Dashboard</li>
			</ol>
		</span>
	</div>
	
</div>

<div class="container mtop mbtm2">
	<a href="menu" class="cbutton2 ff2"><span>Previous</span></a>
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