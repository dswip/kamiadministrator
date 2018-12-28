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
        <h2 class="ff2 mid mbtm">Catalog</h2>
        <p class="ff" style="text-indent:40px;font-size: 18px;">Halaman untuk mengatur kategori produk, bahan produk, merk, model, daftar produk, dan atribut.</p>
    </div>
    
    <div class="col-md-12">
        <h2 class="ff2">Category</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/3catalog/1category.PNG" data-fancybox data-caption="Category"><img src="screenshots/3catalog/1category.PNG" alt="" class="img-responsive"></a>
    </div>
	<div class="col-md-12 mtopbtm">
		<span class="ff" style="font-size: 18px;">
			<ol>
			    <li>Klik field untuk menampilkan banyaknya data pada tabel.</li>
			    <li>Klik tombol untuk mencetak.</li>
			    <li>Klik field untuk melakukan pencarian.</li>
			    <li>Tombol.</li>
			    <ul>
			    	<li>1 : Tombol untuk mengganti status.</li>
			    	<li>
			    		2 : Tombol untuk melakukan update.
			    		<a href="screenshots/3catalog/1categoryupdate.PNG" data-fancybox data-caption="Category Update"><img src="screenshots/3catalog/1categoryupdate.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>3 : Tombol untuk menghapus data.</li>
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
			    		<a href="screenshots/3catalog/1categoryaddnew.PNG" data-fancybox data-caption="Category Add New"><img src="screenshots/3catalog/1categoryaddnew.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Back : Tombol untuk kembali ke halaman sebelumnya.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="2" class="col-md-12">
        <h2 class="ff2">Material Item</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/3catalog/2material.png" data-fancybox data-caption="Material Item"><img src="screenshots/3catalog/2material.png" alt="" class="img-responsive" width="600"></a>
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
			    	<li>
			    		Tombol Biru : Tombol untuk melakukan Update.
			    		<a href="screenshots/3catalog/2materialupdate.PNG" data-fancybox data-caption="Material Update"><img src="screenshots/3catalog/2materialupdate.PNG" alt="" class="img-responsive"></a>
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
			    		<a href="screenshots/3catalog/2materialaddnew.PNG" data-fancybox data-caption="Material Add New"><img src="screenshots/3catalog/2materialaddnew.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li class="mtop">
			    		Report : Tombol untuk menambah data laporan.
			    		<a href="screenshots/3catalog/2materialreport.PNG" data-fancybox data-caption="Material Report"><img src="screenshots/3catalog/2materialreport.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li class="mtop">
			    		Material List : Tombol untuk menampilkan halaman Material List.
			    		<a href="screenshots/3catalog/2materiallist.PNG" data-fancybox data-caption="Material List"><img src="screenshots/3catalog/2materiallist.PNG" alt="" class="img-responsive" width="600"></a>
			    	</li>
			    	<li class="mtop">
			    		Color Type : Tombol untuk menampilkan Color Type.
			    		<a href="screenshots/3catalog/2materialcolortype.PNG" data-fancybox data-caption="Material Color Type"><img src="screenshots/3catalog/2materialcolortype.PNG" alt="" class="img-responsive" width="600"></a>
			    	</li>
			    	<li>Back : Tombol untuk kembali ke halaman sebelumnya.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="3" class="col-md-12">
        <h2 class="ff2">Manufactures</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/3catalog/3manufacture.PNG" data-fancybox data-caption="Manufactures"><img src="screenshots/3catalog/3manufacture.PNG" alt="" class="img-responsive"></a>
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
			    		Tombol Biru : Tombol untuk melakukan update.
			    		<a href="screenshots/3catalog/3manufactureupdate.PNG" data-fancybox data-caption="Manufactures Update"><img src="screenshots/3catalog/3manufactureupdate.PNG" alt="" class="img-responsive"></a>
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
			    		<a href="screenshots/3catalog/3manufactureaddnew.PNG" data-fancybox data-caption="Manufactures Add New"><img src="screenshots/3catalog/3manufactureaddnew.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Back : Tombol untuk kembali ke halaman sebelumnya.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="4" class="col-md-12">
        <h2 class="ff2">Model</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/3catalog/4model.PNG" data-fancybox data-caption="Model"><img src="screenshots/3catalog/4model.PNG" alt="" class="img-responsive"></a>
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
			    		<a href="screenshots/3catalog/4modelupdate.PNG" data-fancybox data-caption="Model Update"><img src="screenshots/3catalog/4modelupdate.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Tombol Merah : Tombol untuk menghapus data.</li>
			    </ul>
			    <li>Tombol untuk melakukan penghapusan pada data yang telah dipilih.</li>
			    <li>Halaman tabel.</li>
			    <ul>
			    	<li>Previous : Tombol untuk melihat data sebelumnya.</li>
			    	<li>Next : Tombol untuk melihat data selanjutnya.</li>
			    </ul>
			    <li>Tombol.</li>
			    <ul>
			    	<li>
			    		Add New : Tombol untuk menambah data.
			    		<a href="screenshots/3catalog/4modeladdnew.PNG" data-fancybox data-caption="Model Add New"><img src="screenshots/3catalog/4modeladdnew.PNG" alt="" class="img-responsive"></a>
			    	</li>
			    	<li>Back : Tombol untuk kembali ke halaman sebelumnya.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
	<div id="5" class="col-md-12">
        <h2 class="ff2">Product List</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/3catalog/5product.png" data-fancybox data-caption="Product List"><img src="screenshots/3catalog/5product.png" alt="" class="img-responsive"></a>
    </div>
	<div class="col-md-12 mtopbtm">
		<span class="ff" style="font-size: 18px;">
			<ol>
			    <li>Klik tombol untuk mencetak.</li>
			    <li>Klik field untuk menampilkan banyaknya data pada tabel.</li>
			    <li>Klik field untuk melakukan pencarian.</li>
			    <li>Tombol.</li>
			    <ul>
			    	<li>1 : Tombol untuk mengubah status.</li>
			    	<div class="col-md-3 col-xs-12">
			    		<li>
							2 : Tombol Assembly Status.
							<a href="screenshots/3catalog/5productassembly.PNG" data-fancybox data-caption="Product Assembly"><img src="screenshots/3catalog/5productassembly.PNG" alt="" class="img-responsive"></a>
						</li>
			    	</div>
			    	
			    	<div class="col-md-3 col-xs-12">
			    		<li class="mtop">
							3 : Tombol untuk membuka status Calculator.
							<a href="screenshots/3catalog/5productcalculator.PNG" data-fancybox data-caption="Product Calculator"><img src="screenshots/3catalog/5productcalculator.PNG" alt="" class="img-responsive"></a>
						</li>
			    	</div>
			    	
			    	<div class="col-md-3 col-xs-12">
			    		<li class="mtop">
							4 : Tombol untuk melakukan upload gambar produk.
							<a href="screenshots/3catalog/5productimage.PNG" data-fancybox data-caption="Product Image"><img src="screenshots/3catalog/5productimage.PNG" alt="" class="img-responsive"></a>
						</li>
			    	</div>
			    	
			    	<div class="col-md-3 col-xs-12">
			    		<li class="mtop">
							5 : Tombol untuk melakukan Edit Product.
							<a href="screenshots/3catalog/5productedit.png" data-fancybox data-caption="Product Edit"><img src="screenshots/3catalog/5productedit.png" alt="" class="img-responsive" width="600"></a>
						</li>
			    	</div>
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
							<a href="screenshots/3catalog/5productaddnew.PNG" data-fancybox data-caption="Add New Product"><img src="screenshots/3catalog/5productaddnew.PNG" alt="" class="img-responsive"></a>
						</li>
			    	</div>
			    	<div class="col-md-4 col-xs-12">
			    		<li class="mtop">
							Report : Tombol untuk menambah data laporan.
							<a href="screenshots/3catalog/5productreport.png" data-fancybox data-caption="Add New Product Report"><img src="screenshots/3catalog/5productreport.png" alt="" class="img-responsive"></a>
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
        <h2 class="ff2">Attributes</h2>
    </div>
    <div class="col-md-8">
        <a href="screenshots/3catalog/6attribute.PNG" data-fancybox data-caption="Attributes"><img src="screenshots/3catalog/6attribute.PNG" alt="" class="img-responsive"></a>
    </div>
	<div class="col-md-12 mtopbtm">
		<span class="ff" style="font-size: 18px;">
			<ol>
			    <li>Klik tombol untuk mencetak.</li>
			    <li>Klik field untuk menampilkan banyaknya data pada tabel.</li>
			    <li>Klik field untuk melakukan pencarian.</li>
			    <li>Tombol.</li>
			    <ul>
			    	<li>Tombol Biru : Tombol untuk melakukan Update.</li>
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
							<a href="screenshots/3catalog/6attributeaddnew.PNG" data-fancybox data-caption="Add New Attributes"><img src="screenshots/3catalog/6attributeaddnew.PNG" alt="" class="img-responsive"></a>
						</li>
			    	</div>
			    	<div class="col-md-4 col-xs-12">
			    		<li class="mtop">
							Attribute Group : Tombol untuk membuka halaman Attribute Group.
							<a href="screenshots/3catalog/6attributegroup.PNG" data-fancybox data-caption="Attributes Group"><img src="screenshots/3catalog/6attributegroup.PNG" alt="" class="img-responsive"></a>
							<ol>
								<li>Klik tombol untuk mencetak.</li>
								<li>Klik field untuk menampilkan banyaknya data pada tabel.</li>
								<li>Klik field untuk melakukan pencarian.</li>
								<li>Tombol.</li>
								<ul>
									<li>Tombol Biru : Tombol untuk melakukan Update.</li>
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
										<a href="screenshots/3catalog/6attributegroupaddnew.PNG" data-fancybox data-caption="Add New Attributes"><img src="screenshots/3catalog/6attributegroupaddnew.PNG" alt="" class="img-responsive"></a>
									</li>
									<li>Back : Tombol untuk kembali ke halaman sebelumnya.</li>
								</ul>
							</ol>
						</li>
		    			
			    	</div>
			    	<li>Back : Tombol untuk kembali ke halaman Dashboard.</li>
			    </ul>
			</ol>
		</span>
	</div>
	
</div>

<div class="container mtop mbtm2">
	<a href="article" class="cbutton2 ff2"><span>Previous</span></a>
	<a href="setting" class="cbutton ff2" style="float:right;"><span>Next</span></a>
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