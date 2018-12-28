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
        <h2 class="ff2 mid mbtm">Setting</h2>
        <p class="ff" style="text-indent:40px;font-size: 18px;">Halaman untuk mengatur daftar ongkos kirim, metode pembayaran, diskon penjualan, dan detail bank</p>
    </div>
    
    <div class="col-md-12">
        <h2 class="ff2">Shipping Rate</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/4setting/1shipping.png" data-fancybox data-caption="Article Category"><img src="screenshots/4setting/1shipping.png" alt="" class="img-responsive"></a>
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
			    		Tombol Biru : Tombol untuk melakukan Edit.
			    		<a href="screenshots/4setting/1shippingupdate.PNG" data-fancybox data-caption="Shipping Rate Update"><img src="screenshots/4setting/1shippingupdate.PNG" alt="" class="img-responsive"></a>
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
			    		<a href="screenshots/4setting/1shippingaddnew.png" data-fancybox data-caption="Add New Shipping Rate"><img src="screenshots/4setting/1shippingaddnew.png" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Back : Tombol untuk kembali ke halaman Dashboard.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="2" class="col-md-12">
        <h2 class="ff2">Payment Type</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/4setting/2payment.PNG" data-fancybox data-caption="Payment Type"><img src="screenshots/4setting/2payment.PNG" alt="" class="img-responsive"></a>
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
			    	    Tombol Biru : Tombol untuk melakukan Update.
			    	    <a href="screenshots/4setting/2paymentupdate.PNG" data-fancybox data-caption="Update Payment"><img src="screenshots/4setting/2paymentupdate.PNG" alt="" class="img-responsive"></a>
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
			    		<a href="screenshots/4setting/2paymentaddnew.PNG" data-fancybox data-caption="Add New Payment"><img src="screenshots/4setting/2paymentaddnew.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Back : Tombol untuk kembali ke halaman sebelumnya.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="3" class="col-md-12">
        <h2 class="ff2">Sales Discount</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/4setting/3sales.PNG" data-fancybox data-caption="Sales Discount"><img src="screenshots/4setting/3sales.PNG" alt="" class="img-responsive"></a>
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
			    	<li>Tombol Merah-1 : Tombol untuk mengganti status.</li>
			    	<li>
			    		Tombol Biru : Tombol untuk melakukan Update.
			    		<a href="screenshots/4setting/3salesupdate.PNG" data-fancybox data-caption="Sales Discout Rate Update"><img src="screenshots/4setting/3salesupdate.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Tombol Merah-2 : Tombol untuk menghapus data.</li>
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
			    		<a href="screenshots/4setting/3salesaddnew.PNG" data-fancybox data-caption="Add New Sales"><img src="screenshots/4setting/3salesaddnew.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Back : Tombol untuk kembali ke halaman Dashboard.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="4" class="col-md-12">
        <h2 class="ff2">Bank Details</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/4setting/4bank.PNG" data-fancybox data-caption="Sales Discount"><img src="screenshots/4setting/4bank.PNG" alt="" class="img-responsive"></a>
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
			    	<li>Tombol Merah-1 : Tombol untuk mengganti status.</li>
			    	<li>
			    		Tombol Biru : Tombol untuk melakukan Update.
			    		<a href="screenshots/4setting/4bankupdate.PNG" data-fancybox data-caption="Bank Details Update"><img src="screenshots/4setting/4bankupdate.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Tombol Merah-2 : Tombol untuk menghapus data.</li>
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
			    		<a href="screenshots/4setting/4bankaddnew.PNG" data-fancybox data-caption="Add New Bank Details"><img src="screenshots/4setting/4bankaddnew.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Back : Tombol untuk kembali ke halaman Dashboard.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
</div>

<div class="container mtop mbtm2">
	<a href="catalog" class="cbutton2 ff2"><span>Previous</span></a>
	<a href="sales" class="cbutton ff2" style="float:right;"><span>Next</span></a>
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