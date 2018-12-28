<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title> Delica ALumunium Invoice - <?php echo $so; ?> </title>
	
	<style type="text/css" media="all">
		td, th {
			border: 1px solid rgba(0,0,0,0.4);
			text-align: left;
			padding: 8px;
			text-align: center;
            font-size: 10pt;
		}
		@media (min-width:320px) and (max-width:480px){
			body {
				font-size: 5pt;
			}
		}
        .left{ text-align: left;}
        
	</style>
    
    <script type="text/javascript">
    
    function closeWindow() {
    setTimeout(function() {
    window.close();
    }, 60000);
    }

    </script> 
    
</head>
<body onload="closeWindow();" style="font-family: 'Josefin sans', sans-serif;">
<div style="width:100%;margin: 0 auto; ">
	<div style="float:left; width:100%; margin:0;">
		<img src="<?php echo base_url(); ?>images/property/kop-surat.png" alt="" style="min-height:120px; width:100%; margin:0; padding:0;">
	</div>
	
<!-------------------->
	<div class="row" style="text-align:left; float:left; margin-left:2%; width:96%;">
        
		<span style="font-size:11pt; float:left;">
			<?php echo $so; ?> <br>
			Medan, <?php echo $dates; ?> <br>
			Kepada Yth: <br>
			<?php echo $c_name; ?> <br>
			<?php echo $c_address.' - '.$c_zip; ?> <br>
			<?php echo $c_city; ?> <br>
			Di tempat <br>
		</span> <br>
        
        <span style="font-size:11pt; float:right; margin-right:2%;">
			Agent : <strong> <?php echo $a_code.' / '.$a_name; ?> </strong> <br> <?php echo $a_phone; ?> <br>
            <?php echo $a_address.' - '.$a_zip; ?> <br> <?php echo $a_city; ?>
		</span>
        
	</div>
    
<!------------------->
	<div style="clear: both;margin: 1% 0 2% 2%; ">
		<span style="text-decoration: underline; font-size:10pt;"><b>Subject: Penawaran Harga Jendela Aluminium Delica Powder Coating </b></span> <br> <br>
		
		<span style="font-size:11pt;">
Dengan hormat, <br>
Bersama dengan surat ini, kami sampaikan penawaran produk DELICA ALUMUNIUM sesuai dengan informasi dan ukuran gambar <br>
		</span>
	</div>
<!------------------>
	<div class="row">
		<table style="border-collapse: collapse;width: 100%; font-size:11pt;">
			<thead>
				<tr>
					<th rowspan="2" style="background-color: #dddddd;">No</th>
					<th rowspan="2" style="background-color: #dddddd;">Nama</th>
					<th colspan="2" style="background-color: #dddddd;">Dimensi (m)</th>
					<th rowspan="2" style="background-color: #dddddd;">Unit</th>
					<th rowspan="2" style="background-color: #dddddd;">Harga (Rp) </th>.
					<th rowspan="2" style="background-color: #dddddd;">Total Harga (Rp) </th>
				</tr>
				<tr>
					<th style="background-color: #dddddd;">Lebar</th>
					<th style="background-color: #dddddd;">Tinggi</th>
				</tr>
			</thead>
			<tbody>
                
<!--
				<tr>
					<td style="background-color: #dddddd;">1</td>
<td style="text-align: left;"><b>JO1</b> <br> <i>Clear 5mm (Single glass)</i> <br> <small> Kamar Mandi </small> <br>
    <img src="folding.png" alt="" width="80" style="">  </td>
					<td>7</td>
					<td>4</td>
					<td>3</td>
					<td>Rp. 1.166.220</td>
					<td>Rp. 3.498.660</td>
				</tr>
-->
                
<?php 
                
    if ($items){
        
        function product($pid,$type){
            $res = new Product_lib();
            $res = $res->get_detail_based_id($pid);
            if ($type == 'image'){
             return base_url().'images/product/'.$res->image;    
            }else{ return $res->$type; }
        }
        
        function attribute($val){
            $res = explode('|',$val);
            return $res;
        }
        
        function glass($uid){
            $res = new Material_lib();
            return $res->get_name($uid);
        }
        
        $tot_qty = 0;
        $tot_amount = 0;
        
        foreach($items as $res){
$attr = attribute($res->attribute);
$price = intval($res->price*0.1);
$price = intval($res->price-$price);
echo "
<tr>
<td style=\"background-color: #dddddd;\">1</td>
<td style=\"text-align: left;\"><b>".product($res->product_id,'sku').' - '.strtoupper(product($res->product_id,'name'))."</b> <br> <i> ".glass($attr[6])."</i> <br> <small> ".ucfirst($res->description)." </small> <br>
    <img src=\"".product($res->product_id,'image')."\" width=\"80\">  
</td>
<td>".$attr[0]."</td>
<td>".$attr[1]."</td>
<td>".$res->qty."</td>
<td> ".idr_format($price)." </td>
<td>".idr_format($price*$res->qty)."</td>
</tr>";
       $tot_qty = intval($tot_qty+$res->qty);
       $tot_amount = floatval($tot_amount+$res->amount);
    }
        
    }
?>

				<tr>
                    <td colspan="4" style="background-color: #dddddd; text-align:right;"> Total Unit : </td>
					<td style="background-color: #dddddd;"> <?php echo @$tot_qty; ?> </td>
					<td colspan="3" style="background-color: #dddddd;">&nbsp;</td>
				</tr>
                
                <tr>
					<td colspan="4" style="background-color: #dddddd; text-align:right;"> Total : </td>
<td colspan="3" style="text-align: right;background-color: #dddddd;"> <?php echo idr_format($total+$discount); ?>,- </td>
				</tr>
                
                 <tr>
					<td colspan="4" style="background-color: #dddddd; text-align:right;"> Discount : </td>
<td colspan="3" style="text-align: right;background-color: #dddddd;"> <?php echo idr_format($discount); ?>,- </td>
				</tr>
                
                 <tr>
					<td colspan="4" style="background-color: #dddddd; text-align:right;"> Tax : </td>
<td colspan="3" style="text-align: right;background-color: #dddddd;"> <?php echo idr_format($tax); ?>,- </td>
				</tr>
                
                <tr>
					<td colspan="4" style="background-color: #dddddd; text-align:right;"> Shipping + Landed Cost : </td>
<td colspan="3" style="text-align: right;background-color: #dddddd;"> <?php echo $shipping; ?>,- </td>
				</tr>
                
				<tr>
					<td colspan="4" style="background-color: #dddddd; text-align:right;"> Grand Total : </td>
<td colspan="3" style="text-align: right;background-color: #dddddd;"> <strong style="font-size:12pt;"> <?php echo $tot_amt; ?>,- </strong> </td>
				</tr>
                
			</tbody>
		</table>
<!------------------------------->
		<table style="margin: 3% 0; width: 50%;">
			<tr>
				<th style="text-align: left;background-color: #dddddd;">Spesifikasi:</th>
			</tr>
			<tr>
				<td style="text-align: left;">
					-Aluminium Alloy Powder Coating; T:1,4 mm <br>
					-Accessories: Engsel, handle <br>
					-Glass (Asahi Mas) <br>
					-Single / Double Glass System <br>
				</td>
			</tr>
		</table>
	</div>
<!-------------------------------->
	<div style="clear: both;margin: 1% 0 3% 2%;">
		<span style="font-size:10pt;">
			<h3>Keterangan :</h3>
			1. Harga diatas sudah termasuk transportasi dan pemasangan. <br>
			2. Harga diatas sudah termasuk semua aksesoris dan kaca. <br>
			3. Cara pembayaran :
				<ol style="list-style-type: lower-alpha;">
					<li>Pembayaran ke 1 : 50% pada saat persetujuan. <br></li>
					<li>Pembayaran ke 2 : 30% sebelum barang dikirim. <br></li>
					<li>Pembayaran ke 3 (pelunasan) : 20% setelah selesai pemasangan. <br></li>
				</ol>
			4. Surat penawaran ini berlaku sampai 30 hari dari tanggal penawaran diterbitkan. <br>
			5. Harga tidak terikat/dapat berubah sewaktu-waktu sebelum kontrak disetujui. <br>
			6. Kiriman barang dua bulan sejak pembayaran pertama dan lokasi diukur. <br>
			7. Perubahan yang terjadi akibat adanya perubahan desain / penyempurnaan struktur akan di kondisikan dalam surat revisi.
			Harga diatas tidak berlaku untuk pekerjaan tambahan. <br>
			8. Serah terima produk dan aksesories dalam keadaan terpasang. <br>
		</span>
        
        <table style="margin: 2% 0; width:50%; text-align:left;">
			<tr>
				<th colspan="3" style="text-align: left;background-color: #dddddd;"> Pembayaran melalui :</th>
			</tr>
            
            <?php
                
                if ($banks){
                    
                    foreach ($banks as $res){
echo "
<tr> <td class=\"left\">".$res->acc_bank."</td> <td> AN : ".strtoupper($res->acc_name)." </td> <td class=\"left\"> Acc : ".$res->acc_no." </td> </tr>
";
                    }
                }
            
            ?>
            
		</table>
        
	</div>

<div class="footer"> 
    <img src="<?php echo base_url(); ?>images/property/footer.png" alt="" style="height:80px; width:100%; margin:0; padding:0;">
</div>
    
</div>
</body>
</html>