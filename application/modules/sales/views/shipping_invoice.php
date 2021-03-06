<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="<?php echo base_url().'images/'; ?>fav_icon.png" >
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title> <?php echo isset($title) ? $title : '' ; ?> </title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link type="text/css" media="all" href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet" />
	  <!-- CUSTOM STYLE  -->
    <link type="text/css" media="all" href="<?php echo base_url(); ?>css/receipt/custom-style.css" rel="stylesheet" />
    <!-- GOOGLE FONTS -->
    <link type="text/css" media="all" href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css' />
    
    <style type="text/css">
        .border{ border: 1px solid red;}
    </style>

</head>
<body>
 <div class="container">
     
      <div class="row pad-top-botm">
         <div class="col-md-5 col-sm-6">
            <img src="<?php echo isset($p_logo) ? $p_logo : ''; ?>" style="padding-bottom:20px;" /> 
         </div>
          <div class="col-md-5 col-sm-6 col-md-offset-1">
           <strong> <?php echo isset($p_name) ? $p_name : ''; ?> </strong> <br />
           <?php echo isset($p_address) ? $p_address : ''; ?>
           <br /> <?php echo isset($p_zip) ? $p_zip : ''; ?> , <?php echo isset($p_city) ? $p_city : ''; ?>,
           <br /> Indonesia.    
         </div>
     </div>
     <h2 style="text-align:center; margin:0; padding:0; font-weight:bold;"> Shipping Receipt </h2> <br>
     <div  class="row text-center contact-info">
         <div class="col-md-12 col-sm-12">
             <hr />
             <span> <strong> Invoice No : </strong>  <?php echo isset($so) ? $so : ''; ?> </span>
             <span> <strong>Email : </strong>  <?php echo isset($p_email) ? $p_email : ''; ?> </span>
             <span> <strong>Call : </strong>  <?php echo isset($p_phone) ? $p_phone : ''; ?> </span>
             <hr />
         </div>
     </div>
     <div class="row pad-top-botm client-info">
         <div class="col-md-5 col-sm-6">
         <h4>  <strong> Customer : </strong></h4>
           <strong> <?php echo isset($c_name) ? $c_name : ''; ?> </strong> <br />
        <b>Address :</b> <?php echo isset($dest_desc) ? $dest_desc : ''; ?> , <br /> 
        <?php echo isset($dest) ? $dest : ''; ?> - Indonesia. <br />
        <b>Call :</b> <?php echo isset($c_phone) ? $c_phone : ''; ?> <br />
        <b>E-mail :</b> <?php echo isset($c_email) ? $c_email : ''; ?>
         </div>
         
         <div class="col-md-5 col-sm-6 col-md-offset-1">
            
        <h4>  <strong> Shipping Details </strong></h4>
        Currency : IDR <br>
        Shipping Date :  <?php echo isset($ship_date) ? $ship_date : ''; ?> <br />
        <b>Courier : </b> <?php echo isset($courier) ? $courier : ''; ?> - <?php echo isset($package) ? $package : ''; ?> <br />
    <b>AWB : </b> <?php echo isset($awb) ? $awb : ''; ?> <br />
        <b>Status : <?php echo isset($ship_status) ? $ship_status : ''; ?> </b> <br />
                
         </div>
     </div>
     
     <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
           <div class="table-responsive">
                 <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th> No.</th>
                    <th> Product </th>
                    <th> Weight </th>
                    <th> Rate </th>
                     <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                                
            <?php
                
                function product($pid,$type=0)
                {
                    $val = new Product_lib();
                    if ($type == 0){ return ucfirst($val->get_name($pid)); }
                    else { return $val->get_weight($pid); }
                }      
                         
                $tot_weight = 0;
                $tot_rate = 0;
                if ($items)
                {
                    $i=1;
                    foreach($items as $res)
                    {
                        $weight = product($res->product_id,1);
                        $amount = intval($weight*$rate);
                        echo"
                        <tr>
                            <td>".$i."</td>
                            <td> ".product($res->product_id)." </td>
                            <td align=\"center\">".$weight." kg </td>
                            <td align=\"right\">".idr_format($rate)."</td>
                            <td align=\"right\">".idr_format($amount)."</td>
                        </tr>
                        "; $i++; $tot_weight= intval($tot_weight + $weight); $tot_rate= intval($tot_rate + $amount);
                    }
                }
            ?>              
                        <tr>
                            <td colspan="1"></td>
                            <td align='right'> <b> Total : </b>  </td>
                            <td align="center"> <b> <?php echo isset($tot_weight) ? $tot_weight : '0'; ?> kg </b> </td>
                            <td> </td>
                            <td align="right"> <b> <?php echo isset($tot_rate) ? idr_format($tot_rate) : '0'; ?> </b> </td>
                        </tr>   

                        </tbody>
                    </table>
               </div>
             <hr />
         </div>
     </div>
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <strong> Important: </strong>
             <ol>
                  <li>
                    This is an electronic generated invoice so doesn't require any signature.
                 </li>
                 <li>
            Please read all terms and polices on <b> <?php echo $p_name; ?> </b> for returns, replacement and other issues.
                 </li>
             </ol>
             </div>
         </div>
     
      <div class="row pad-top-botm">
         <div class="col-lg-12 col-md-12 col-sm-12">
             <hr />
             <a href="" onclick="window.print();" class="btn btn-primary btn-lg" >Print Invoice</a>
         </div>
      </div>
 </div>

</body>
</html>
   