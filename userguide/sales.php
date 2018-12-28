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
        <h2 class="ff2 mid mbtm">Sales</h2>
        <p class="ff" style="text-indent:40px;font-size: 18px;">Halaman untuk mengatur penjualan, pemesanan, pengiriman, daftar agen, daftar pelanggan, dan penawaran.</p>
    </div>
    
    <div class="col-md-12">
        <h2 class="ff2">Agent</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/5sales/1agent.PNG" data-fancybox data-caption="Agent"><img src="screenshots/5sales/1agent.PNG" alt="" class="img-responsive"></a>
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
			    <li>Klik field untuk menampilkan banyaknya data pada tabel.</li>
			    <li>Klik tombol untuk mencetak.</li>
			    <li>Klik field untuk melakukan pencarian.</li>
			    <li>Tombol.</li>
			    <ul>
			    	<li>1 : Tombol untuk mengubah status.</li>
			    	<div class="col-md-6 col-xs-12">
			    		<li>
							2 : Tombol untuk melihat data detail agent.
							<a href="screenshots/5sales/1agentdetails.PNG" data-fancybox data-caption="Agent Details"><img src="screenshots/5sales/1agentdetails.PNG" alt="" class="img-responsive" width="560"></a>
						</li>
			    	</div>
			    	
			    	<div class="col-md-6 col-xs-12">
			    		<li class="mtop">
							3 : Tombol untuk mengedit data agent.
							<a href="screenshots/5sales/1agentedit.png" data-fancybox data-caption="Edit Agent"><img src="screenshots/5sales/1agentedit.png" alt="" class="img-responsive"></a>
						</li>
			    	</div>
			    	<li>4 : Tombol untuk menghapus data.</li>
			    	
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
			    		<a href="screenshots/5sales/1agentaddnew.PNG" data-fancybox data-caption="Add New Agent"><img src="screenshots/5sales/1agentaddnew.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Back : Tombol untuk kembali ke halaman Dashboard.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="2" class="col-md-12">
        <h2 class="ff2">Customers</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/5sales/2customer.PNG" data-fancybox data-caption="Customers"><img src="screenshots/5sales/2customer.PNG" alt="" class="img-responsive"></a>
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
			    	<li>Tombol Hijau : Tombol untuk mengubah status.</li>
                    <li>
                        Tombol Biru : Tombol untuk mengedit data customer.
                        <a href="screenshots/5sales/2customeredit.png" data-fancybox data-caption="Edit Customer"><img src="screenshots/5sales/2customeredit.png" alt="" class="img-responsive" width="500"></a>
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
			    		<a href="screenshots/5sales/2customeraddnew.PNG" data-fancybox data-caption="Add New Customer"><img src="screenshots/5sales/2customeraddnew.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Back : Tombol untuk kembali ke halaman Dashboard.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="3" class="col-md-12">
        <h2 class="ff2">Order</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/5sales/3order.PNG" data-fancybox data-caption="Order"><img src="screenshots/5sales/3order.PNG" alt="" class="img-responsive"></a>
    </div>
	<div class="col-md-12 mtopbtm">
		<span class="ff" style="font-size: 18px;">
			<ol>
			    <li>Klik field untuk menampilkan data yang akan di-filter.</li>
			    <li>Tombol</li>
			    <ul>
			    	<li>Filter : Tombol untuk memfilter data.</li>
			    	<li>Reset : Tombol untuk me-reset.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div class="col-md-8">
        <a href="screenshots/5sales/3orderr.PNG" data-fancybox data-caption="Order"><img src="screenshots/5sales/3orderr.PNG" alt="" class="img-responsive"></a>
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
			    	<li>1 : Tombol untuk mengubah status.</li>
                    <li>2 : Tombol untuk mencetak invoice.</li>
			    	<li>3 : Tombol untuk membuka halaman konfirmasi pembayaran.</li>
			    	<li>4 : Tombol untuk menuju halaman pembayaran komisi.</li>
			    	<li>
			    	    5 : Tombol untuk menuju halaman Update Order.
			    	    <a href="screenshots/5sales/3orderupdate.png" data-fancybox data-caption="Update Order"><img src="screenshots/5sales/3orderupdate.png" alt="" class="img-responsive" width="500"></a>
			    	</li>
			    	<li>6 : Tombol untuk menghapus data.</li>
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
			    		Report : Tombol untuk menambah laporan.
			    		<a href="screenshots/5sales/3orderreport.PNG" data-fancybox data-caption="Order Report"><img src="screenshots/5sales/3orderreport.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li class="mtop">
			    		Shipping : Tombol untuk menuju halaman status pengiriman.
			    		<a href="screenshots/5sales/4shipping.PNG" data-fancybox data-caption="Shipping"><img src="screenshots/5sales/4shipping.PNG" alt="" class="img-responsive" width="600"></a>
			    	</li class="mtop">
			    	<li class="mtop">Back : Tombol untuk kembali ke halaman Dashboard.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="4" class="col-md-12">
        <h2 class="ff2">Shipping</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/5sales/4shipping.PNG" data-fancybox data-caption="Sales Discount"><img src="screenshots/5sales/4shipping.PNG" alt="" class="img-responsive"></a>
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
			    <li>Halaman tabel.</li>
			    <ul>
			    	<li>Previous : Tombol untuk melihat data sebelumnya.</li>
			    	<li>Next : Tombol untuk melihat data selanjutnya.</li>
			    </ul>
			    <li>Tombol</li>
			    <ul>
			    	<li>
			    	    Biru : Tombol melakukan konfirmasi pembayaran.
			    	    <a href="screenshots/5sales/4shippingpaymentconfirmation.PNG" data-fancybox data-caption="Payment Confirmation"><img src="screenshots/5sales/4shippingpaymentconfirmation.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li class="mtop">Merah : Tombol untuk menghapus data.</li>
			    </ul>
			    <li class="mtop">Tombol.</li>
			    <ul>
			    	<li>
			    		Report : Tombol untuk menambah data.
			    		<a href="screenshots/5sales/4shippingreport.PNG" data-fancybox data-caption="Shipping Report"><img src="screenshots/5sales/4shippingreport.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li class="mtop">Back : Tombol untuk kembali ke halaman Dashboard.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="5" class="col-md-12">
        <h2 class="ff2">Order Offer</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/5sales/5orderoffer.PNG" data-fancybox data-caption="Order Offer"><img src="screenshots/5sales/5orderoffer.PNG" alt="" class="img-responsive"></a>
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
			    <li>Halaman tabel.</li>
			    <ul>
			    	<li>Previous : Tombol untuk melihat data sebelumnya.</li>
			    	<li>Next : Tombol untuk melihat data selanjutnya.</li>
			    </ul>
			    <li>Tombol untuk menghapus data.</li>
			    <li>Back : Tombol untuk kembali ke halaman Dashboard.</li>
			</ol>
		</span>
	</div>
	
</div>

<div class="container mtop mbtm2">
	<a href="setting" class="cbutton2 ff2"><span>Previous</span></a>
	<a href="campaign" class="cbutton ff2" style="float:right;"><span>Next</span></a>
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