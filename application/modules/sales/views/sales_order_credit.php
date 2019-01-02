<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title> Konfirmasi Pemesanan - #<?php echo isset($so_no) ? $so_no : '' ; ?> </title>

  <style type="text/css">
      body{ color: #808080; font-family: arial;}
      p{ font-size: 12px; margin: 10px;}
      .content{ font-size: 14px; float: left;}
      .clear{ clear: both;}
      .border{ border: 1px solid red;}
      .space{ margin: 5px 2px 2px 2px;}
      a{ font-style: normal; text-decoration: none; color: inherit;}
  </style>    
</head>
<body style="margin:0; padding:0; background-color:#ffffff;">
  <center>
    
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;" bgcolor="#ffffff">
        <tr>
            <td align="left" valign="top" bgcolor="#000">
               <img src="<?php echo base_url(); ?>images/html_email_img/logo.png" width="" height="" style="margin:12px; padding:0; border:none; display:block;" border="0" alt="" />  
            </td>
        </tr>
        
<!--  heading awal  -->
     
    <tr>
        <td align="center" valign="top" bgcolor="">
           <h2> Konfirmasi Pesanan #<?php echo isset($so_no) ? $so_no : '' ; ?> </h2> <hr>
        </td>
    </tr>
        
    <tr>
        <td align="center" valign="top" bgcolor="">
           <p style="text-align:left;"> Hai <strong> <?php echo isset($c_name) ? $c_name : '' ; ?> </strong>, <br>
Terima kasih atas kepercayaanmu telah berbelanja di <?php echo isset($p_site_name) ? $p_site_name : '' ; ?> <br>
Segera pilih metode pembayaran dan lakukan pembayaran untuk mendapatkan barang pilihanmu. Kamu dapat memilih dari sekian banyak metode pembayaran yang disediakan <?php echo isset($p_name) ? $p_name : '' ; ?>, sebagai berikut: </p>
        </td>
    </tr>
    
    <!-- banklist -->
    <tr>
        <td align="left" valign="top" bgcolor="#EFEFEF">
           <img src="<?php echo base_url(); ?>images/html_email_img/banklist.jpg" width="620px" height="" style="margin:15px; padding:0; border:none; display:block;" border="0" alt="" />  
        </td>
    </tr>
    
    <!-- jenis pembayaran button -->
   <tr>
    <td align="center" valign="middle" height="84" style="font-family: Arial, sans-serif; font-size:14px; font-weight:bold; background-color:#f2f2f2;">
    	<a href="<?php echo $sites_url.'/member/payment_confirmation/'; ?>" target="_blank" style="font-family: Arial, sans-serif; color:#fff; background-color: #0089C4; display: inline-block; text-decoration: none; font-weight:normal; line-height:44px; width:300px;"> Konfirmasi Pembayaran </a>
    </td>
   </tr>
   
   <!-- table transaksi -->
   <tr>
        <td align="center" valign="top" bgcolor="">
           <p style="text-align:left;"> Berikut adalah penjelasan tagihan pembayaran: </p>
        </td>
   </tr>
   
   <tr>
        <td align="center" valign="top" bgcolor="#0089C4" style="color:#fff; padding:10px; font-weight:bold;">
           Tagihan #<?php echo isset($so_no) ? $so_no : '' ; ?>
        </td>
   </tr>
      
   <tr>
        <td align="left" valign="top" bgcolor="" style="border-bottom:1px solid #000;"> 
        <p class="content" style="width:150px;"> Waktu Transaksi </p>
        <p class="content" style=""> <?php echo isset($so_date) ? $so_date : '' ; ?> WIB </p>
        </td>
   </tr>
      
   <tr>
        <td align="left" valign="top" bgcolor="" style="border-bottom:1px solid #000;"> 
        <p class="content" style="width:150px;"> Pembeli </p>
        <p class="content"> <a> <?php echo isset($c_name) ? $c_name : '' ; ?> </a> </p>
        </td>
   </tr>
      
   <tr>
        <td align="left" valign="top" bgcolor="" style="border-bottom:1px solid #000;"> 
        <p class="content" style="width:150px;"> Metode / Status Pembayaran </p>
<p class="content" style=""> <?php echo isset($payment) ? $payment : '' ; ?> / <?php echo isset($status) ? $status : '' ; ?> </p>
        </td>
   </tr>
      
   <tr>
        <td align="left" valign="top" bgcolor="" style="border-bottom:15px solid #0089C4;"> 
        <p class="content" style="width:150px;"> Jasa Pengiriman </p>
<p class="content" style=""> <?php echo isset($courier) ? $courier : '' ; ?> / <?php echo isset($package) ? $package : '' ; ?> </p>
        </td>
   </tr>
      
   <tr>
        <td align="left" valign="top" bgcolor="" style="background-color:#EFEFEF;"> 
        <p class="content" style="font-weight:bold; font-size:16px;"> Nama Produk </p>
        <p class="" style="font-weight:bold; font-size:16px; float:right;"> Total Belanja </p>
        </td>
   </tr>   
      
   <?php
    
       function product($pid,$type='name')
       {
           $val = new Product_lib();
           $res = $val->get_detail_based_id($pid);
           if ($type == 'name'){ return ucfirst($res->name); }
           elseif ($type == 'img'){ return base_url().'images/product/'.$res->image; }
           
       }
      
       if ($item)
       {
           foreach($item as $res)
           {
               echo "
   <tr>
        <td align=\"left\" valign=\"top\" style=\"border-bottom:1px solid #000;\"> 
        <img src=\"".product($res->product_id,'img')."\" width=\"80px\" style=\"margin:10px; padding:0; border:none; display:block; float:left;\" border=\"0\" />  
        <p class=\"content\" style=\"font-size:15px; margin:10px 0 0 30px;\"> <strong>".product($res->product_id,'name')."</strong> - ".$res->qty." Pcs <br> Rp. ".num_format($res->amount).",- </p>
        </td>
   </tr> 
               ";
           }
       }
      
      
   ?>
   
   <!-- product list -->
<!--
   <tr>
        <td align="left" valign="top" bgcolor="" style="border-bottom:1px solid #000;"> 
        <img src="https://3.bp.blogspot.com/-8Gc2GRDyF5E/VyBocw9uUgI/AAAAAAAAB_E/PgM8F968BJwwcFX9DUR--B8f-wp-U7kKgCLcB/s1600/kolam%2Brenang%2Banak%2Btema%2Blaut.jpg" width="80px" height="" style="margin:10px; padding:0; border:none; display:block; float:left;" border="0" alt="" />  
        <p class="content" style="font-size:15px; margin:10px 0 0 30px;"> <strong> Kolam Renang Anak Viking Play Pool Grosir </strong> - 2 Pcs <br> Rp. 100.000,- </p>
        </td>
   </tr>       
-->
   <!-- product list -->
      
    <tr>
    <td align="left" valign="top" bgcolor="" style="border-bottom:1px solid #000;"> 
    <p class="content" style="width:100px; margin-left:30%;"> Subtotal </p>
    <p class="" style="float:right; font-size:15px;"> Rp <?php echo isset($sub_total) ? $sub_total : '' ; ?>-, </p>
    </td>
   </tr>  
   
   <tr>
    <td align="left" valign="top" bgcolor="" style="border-bottom:1px solid #000;"> 
    <p class="content" style="width:150px;"> Harga Total Belanja </p>
<p class="" style="float:right; font-size:15px; font-weight:bold;"> Rp <?php echo isset($sub_total) ? $sub_total : '' ; ?>-, </p>
    </td>
   </tr>  
   
   <tr>
    <td align="left" valign="top" bgcolor="" style="border-bottom:1px solid #000;"> 
    <p class="content" style="width:150px;"> Biaya Kirim </p>
        <p class="" style="float:right; font-size:15px;"> Rp <?php echo isset($shipping_amt) ? $shipping_amt : '' ; ?>-, </p>
    </td>
   </tr>  
   
   <tr>
        <td align="left" valign="middle" bgcolor="" style="background-color:#EFEFEF;"> 
        <p class="content" style="font-weight:bold; font-size:16px; padding-top:12px;"> TOTAL PEMBAYARAN </p>
        <p class="" style="font-weight:bold; width:150px; font-size:16px; text-align:right; float:right; background-color:#F97B0C; color:#fff; padding:10px;"> Rp <?php echo isset($total) ? $total : '' ; ?>,- </p>
        </td>
   </tr>
   
   <tr>
    <td align="left" valign="top" bgcolor=""> 
      <p class="content" style="width:35%px; font-size:14px; line-height: 150%;"> <strong> Alamat tujuan pengiriman </strong> <br>
         <?php echo isset($ship_address) ? $ship_address : '' ; ?> <br>
         No. Telp: <?php echo isset($c_phone) ? $c_phone : '' ; ?> 
      </p> <div style="clear:both;"></div>
      <p style="font-size:14px;"> Jika kamu menghadapi kendala mengenai pembayaran, silakan langsung Hubungi 
      <a target="_blank" href="<?php echo isset($sites_url) ? $sites_url : '' ; ?>"> <?php echo isset($p_name) ? $p_name : '' ; ?> </a>
      <br> <br>  </p>
    </td>
   </tr>  
      
   <tr>
        <td align="left" valign="middle" bgcolor="" style="background-color:#EFEFEF;"> 
            
        <p class="content" style="font-size:14px; text-align:left;"> 
<img src="<?php echo base_url(); ?>images/html_email_img/unnamed.png" align="left" style="padding:10px 8px 4px 0px;">
Segala bentuk informasi seperti nomor kontak, alamat e-mail, atau password kamu bersifat rahasia. Jangan menginformasikan data-data tersebut kepada siapa pun, termasuk kepada pihak yang mengatasnamakan <?php echo isset($p_name) ? $p_name : '' ; ?>. 
 </p>
        </td>
   </tr>
      
    <tr>
        <td align="left" height="44" valign="middle" bgcolor="" style="padding-top:25px;"> 
        <p style="width:45%; float:left;"> 
          Copyright © <?php echo date('Y');?> <?php echo isset($p_name) ? $p_name : '' ; ?>. <br>
          All Rights Reserved <br>
          <?php echo isset($p_address) ? $p_address : '' ; ?>. <br>
          <?php echo isset($p_city) ? $p_city : '' ; ?>. Indonesia. <?php echo isset($p_zip) ? $p_zip : '' ; ?> 
        </p>
            <p style="float:right"> 
               <a href="#"> <img src="<?php echo base_url(); ?>images/html_email_img/android.png" alt="android"> </a> 
               <a href="#"> <img src="<?php echo base_url(); ?>images/html_email_img/apple.png" alt="apple"> </a> <br>

    <a target="_blank" href="https://www.instagram.com/delica_aluminium/"> 
        <img class="space" src="<?php echo base_url(); ?>images/html_email_img/ig.png" alt="ig" align="right"> 
    </a> 
                
    <a target="_blank" href="https://www.youtube.com/channel/UCYhihRcxQ7G4HazWj9oD4aA">
        <img class="space" src="<?php echo base_url(); ?>images/html_email_img/yt.png" alt="yt" align="right"> 
    </a>
                
    <a target="_blank" href="https://www.instagram.com/delica_aluminium/"> 
        <img class="space" src="<?php echo base_url(); ?>images/html_email_img/fb.png" alt="fb" align="right"> 
    </a>
            </p> <div class="clear"></div>
            <hr>
        </td>
   </tr>
   
   <tr>
       <td align="left" valign="middle" bgcolor="#000;" style="padding-top:10px; padding-bottom:10px;"> 
    <p style="font-size:10px; text-align:center; line-height:20px; color:#fff; margin:0; padding:0;"> Anda memperoleh e-mail ini karena keanggotaan Anda pada 
<a target="_blank" href="<?php echo isset($sites_url) ? $sites_url : '' ; ?>" style="color:#0089C4;">
    <?php echo isset($p_name) ? $p_name : '' ; ?> </a> Anda bisa mengubah pengaturan notifikasi kapanpun. <br>
Harap jangan membalas e-mail ini, karena e-mail ini dikirimkan secara otomatis oleh sistem. </p>
       </td>
   </tr>
      
    </table>
  </center>
</body>
</html>
