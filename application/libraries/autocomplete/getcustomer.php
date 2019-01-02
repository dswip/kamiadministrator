<?php
    include 'koneksi.php';
	if(isset($_GET['q'])){
		/* # pilih table
		 * parameter "q" harus di-filter minimal dengan mysql_escape_string 
		 * hanya untuk berjaga-jaga apabila ada inputan dengan karakter khusus
		 * yang error ketika dibaca oleh syntax query MySQL
		 * */
		$param = mysql_escape_string($_GET['q']); 
		
		# lakukan pencarian, tampilkan nama pegawai yang berawalan nilai parameter "q"
		$query = mysql_query("SELECT `name`, `address`, `phone1`, `npwp`, `city` FROM customer WHERE name LIKE '$param%'") or die(mysql_error());
		if(mysql_num_rows($query) > 0){
			$data = array(); # siapkan variable untuk menampung keseluruhan data
			while($row = mysql_fetch_object($query))
                        {
		  	  $data[] = $row; # input data ke variable array satu per satu baris hasil query
			}
			/*
			 * Variable yang mengandung keseluruhan data dari query lalu di konversi
			 * ke JSON dengan fungsi dari PHP5 "json_encode". Hasil keluaran ini akan 
			 * diterima dan di proses oleh Ajax di plugin autocomplete pada file "index.html"
			 * */
			die(json_encode($data)); 
			/* 
			 * lebih jauh tentang implementasi JSON pada aplikasi Ajax dapat anda lihat di artikel di blog saya
			 * http://chandrajatnika.com/2009/02/implementasi-json-pada-aplikasi-ajax/
			 * */			
		}
	}
?>
