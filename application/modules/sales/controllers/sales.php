<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once 'definer.php';

class Sales extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Sales_model', '', TRUE);
        $this->load->model('Sales_item_model', 'sitem', TRUE);

        $this->properti = $this->property->get();
//        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->role = new Role_lib();
        $this->currency = new Currency_lib();
        $this->sales = new Product_lib();
        $this->customer = new Customer_lib();
        $this->product = new Product_lib();
        $this->shipping = new Shipping_lib();
        $this->bank = new Bank_lib();
        $this->category = new Categoryproduct_lib();
        $this->shiprate = new Shiprate_lib();
        $this->sms = new Sms_lib();
        $this->discount = new Discount_lib();
        $this->notif = new Notif_lib();
        $this->api_lib = new Api_lib();
        $this->cart = new Cart_lib();
        $this->courrier = new Courier_lib();
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token'); 
    }

    private $properti, $modul, $title, $sales ,$shipping, $bank, $shiprate, $cart, $discount;
    private $role, $currency, $customer, $payment, $city, $product ,$category,$agent, $notif, $api_lib, $courrier;
    
    function index()
    {
//         echo constant("RADIUS_API");
       $this->session->unset_userdata('start'); 
       $this->session->unset_userdata('end');
       $this->get_last(); 
    }
        
    function cek_ongoing(){
        
        $status = false;
        $sales = $this->Sales_model->get_ongoing();
        if($sales){ 
            
            $shipping = $this->shipping->get_detail_based_sales($sales->id);
            $output[] = array ("id" => $sales->id, "code" => $sales->code, "dates" => tglincomplete($sales->dates).' '. timein($sales->dates),
                               "cust_id" => $sales->cust_id, 'customer' => $this->customer->get_name($sales->cust_id), 'customer_phone' => $this->customer->get_detail($sales->cust_id,'phone1'), "total" => intval($sales->amount+$sales->shipping), "amount" => $sales->amount, "shipping" => $sales->shipping,
                               "payment_type" => $sales->payment_type, "coordinate" => $shipping->coordinate, "destination" => $shipping->destination, "distance" => $shipping->distance);
            $status = true;             
        } 
        $response = array('content' => $output, 'status' => $status);
            
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit;  
    }
        
    // fungsi untuk melakukan booking dari driver
    function book_order($sid,$courier=0,$type=1){
        
        $lng = array('booked' => $type, 'booked_by' => $courier); 
        $this->Sales_model->update($sid,$lng);
        
        $shp = array('courier' => $courier);  // update courier di shipping
        $this->shipping->edit($sid, $shp);
        
        $error= "Booked Process..!";
        $response = array('error' => $error, 'status' => true);
        
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit;  
    }
    
    // fungsi untuk mencek sales sudah terbook atau tidak
    function cek_sales_booked($sid,$courier){
        
        $status = false; $error = null;
        $sales = $this->Sales_model->get_by_id($sid)->row();
        
        if ($sales){
          if ($sales->booked == 1 && $sales->booked_by == $courier && $sales->canceled == NULL && $sales->approved == 0)
          { $status = true; $error= "Order Available..!"; }
        }else{ $error = false; }
        
        $response = array('error' => $error, 'status' => $status);
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit;  
        
    }
    
    function cek_booked_status($sid){
        
        $status = false; $error = null;
        $sales = $this->Sales_model->get_by_id($sid)->row();
        
        if ($sales){
          if ($sales->booked == 1){ $error= "Order Booked..!"; }
          if ($sales->canceled != NULL){ $error= "Order Canceled..!"; }
          else{ $status = true; }    
        }else{ $error = false; }
        
        $response = array('error' => $error, 'status' => $status);
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit;  
    }
    
    // function untuk memeriksa input user dari form sebagai admin
    function add_order()
    {
        $datax = (array)json_decode(file_get_contents('php://input')); 

        $status = false; $order = 0; $error = null;
        $payment = $datax['payment'];
        $cust    = $datax['cust'];
        $amount  = $datax['amount'];

        if ($payment != null && $cust != null)
        {
            // cek apakah sedang ada order aktif atau tidak
            if ($this->valid_pending_order($cust) == FALSE){
                $error = 'Anda masih memiliki order aktif.';
            }elseif ($this->valid_balance($cust, $amount, $payment) == FALSE){
                $error = 'Saldo Anda Tidak Mencukupi';
            }elseif ($this->limit_balance($amount, $payment) == FALSE){
                $error = 'Over Limit Order Pembayaran Tunai';
            }
            else{
                
               $orderid = $this->Sales_model->counter().mt_rand(100,9999);
               $sales = array('cust_id' => $cust, 'code' => $orderid, 'payment_type' => $payment, 'dates' => date('Y-m-d H:i:s'),
                              'created' => date('Y-m-d H:i:s'));
               $this->Sales_model->add($sales);
               $status = true; $order = $orderid; 
            }
        }
        else{ $error = 'Invalid JSON Format'; }
        
        $response = array('status' => $status, 'orderid' => $order, 'error'=> $error); 
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }
    
    // add item json
    
    private function valid_json($param){
        
      if (isset($param->qty) && isset($param->tax) && isset($param->price) && isset($param->attribute) && isset($param->description))
      { return TRUE; }else{ return FALSE; }
    }
    
    function add_item_mobile_json()
    {  
        $datax = (array)json_decode(file_get_contents('php://input'));         
 
        $orderid = $datax['status']->orderid;
        $result = true;
        $error = null;
        
        if ($this->cek_orderid($orderid) == TRUE && $this->valid_confirm($orderid,'code') == TRUE)
        {  
          $sales = $this->Sales_model->get_sales_based_order($orderid)->row();
          
          // cart get
          $nilai = null;
          $url = site_url('cart/get/'.$sales->cust_id);

          $responsecart = $this->api_lib->request($url, $nilai);
          $content = (array) json_decode($responsecart, true);
          $content = $content['content'];
          
          for($i=0; $i<count($content); $i++){
                  
            $qty   = intval($content[$i]['qty']);
            $price = floatval($content[$i]['price']);
            $amt_price = floatval($qty*$price);
            $percenttax = floatval($content[$i]['tax']);
            $tax = floatval($percenttax*$amt_price);

            $salestrans = array('product_id' => $content[$i]['product_id'], 'sales_id' => $sales->id,
                           'qty' => $qty, 'tax' => $tax, 'attribute' => $content[$i]['attribute'], 'description' => $content[$i]['description'],
                           'price' => $price, 'amount' => floatval($amt_price));

            $this->sitem->add($salestrans);
          }
          
          $this->cart->delete_by_customer($sales->cust_id); // hapus cart
          
          // add shipping
          if ($result == true){ 
               $this->shipping_json($datax);
              // set discount
              $this->set_discount($orderid);
              $this->update_trans($this->Sales_model->get_id_based_order($orderid));
              $this->courrier->push_courier('New Order Detected');
          }
          
        }
        else{ $result = false; $error = 'Invalid Orderid'; }
        
        $status = array('result' => $result, 'error' => $error);
        $response['status'] = $status;
            
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit;  
    }
    
    function add_item_json()
    {  
        $datax = (array)json_decode(file_get_contents('php://input'));         
 
        $content = $datax['content'];
        $orderid = $datax['status']->orderid;
        $result = true;
        $error = null;
        
        if ($this->cek_orderid($orderid) == TRUE && $this->valid_confirm($orderid,'code') == TRUE && $this->valid_shipping_json($datax['shipping']) == TRUE)
        {  
          $sid = $this->Sales_model->get_id_based_order($orderid);
          for($i=0; $i<count($content); $i++){
              
              if ($this->product->valid_product($content[$i]->product_id) == TRUE && $this->valid_json($content[$i]) == TRUE){
                  
                $qty   = intval($content[$i]->qty);
                $price = floatval($content[$i]->price);
                $amt_price = floatval($qty*$price);
                $percenttax = floatval($content[$i]->tax);
                $tax = floatval($percenttax*$amt_price);
                                       
                $sales = array('product_id' => $content[$i]->product_id, 'sales_id' => $sid,
                               'qty' => $qty, 'tax' => $tax, 'attribute' => $content[$i]->attribute, 'description' => $content[$i]->description,
                               'price' => $price, 'amount' => floatval($amt_price));
                
                $this->sitem->add($sales);
              }else { $result = false; $error = 'Invalid JSON Format'; break; }
          }
          
          // add shipping
          if ($result == true){ 
               $this->shipping_json($datax);
//              // set discount
              $this->set_discount($orderid);
              $this->update_trans($this->Sales_model->get_id_based_order($orderid));
          }
          
        }
        else{ $result = false; $error = 'Invalid Orderid'; }
        
        $status = array('result' => $result, 'error' => $error);
        $response['status'] = $status;
            
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit;  
    }
    
    function valid_shipping_json($shipping){
        if (isset($shipping->courier) && isset($shipping->coordinate) && isset($shipping->destination) && isset($shipping->distance) && isset($shipping->amount)){ return TRUE; }else{ return FALSE; }
    }
    
    private function set_discount($orderid){
        $sales = $this->Sales_model->get_sales_based_order($orderid)->row();
        
        $this->discount->cek_discount($sales->dates); // cek apakah ada discount yang expire
        
        $nilai = '{ "amount":"' . $sales->amount. '","payment":"' . $sales->payment_type.'", "date":"' .$sales->dates.'" }';
        $url = site_url('discount/calculate');

        $response = $this->api_lib->request($url, $nilai);
        $datax = (array) json_decode($response, true);
        
        $amount = intval($sales->amount-$sales->tax);
        $discount = intval($datax['result']);
        $discount = intval($sales->total*$discount/100);
        $amount = intval($amount-$discount);
        $tax = intval($sales->tax);
        $amount = intval($amount+$tax);
        
        $param = array('discount' => $discount, 'tax' => $tax, 'amount' => $amount);
        $this->Sales_model->update($sales->id, $param);
    }
    
    private function shipping_json($datax){
        
        $result = TRUE;
        $error = null;
        
        $orderid = $datax['status']->orderid;
        $sid = $this->Sales_model->get_id_based_order($orderid);
        $shipping = $datax['shipping'];
        
        if ($this->valid_shipping_json($shipping) == TRUE){
           
            $sales = $this->Sales_model->get_sales_based_order($orderid)->row();
            $param = array('sales_id' => $sid, 'dates' => $sales->dates,
                           'courier' => $shipping->courier, 'destination' => $shipping->destination,
                           'distance' => $shipping->distance,
                           'coordinate' => $shipping->coordinate, 
                           'amount' => $shipping->amount, 'created' => date('Y-m-d H:i:s'));
            
            $this->shipping->create($sid, $param);
            $this->update_trans($sid);
            
        }else { $result = FALSE; $error = "Invalid JSON Format"; }
        return $result; 
    }
    
    function confirmation_json(){
        
        $datax = (array)json_decode(file_get_contents('php://input')); 
        
        $uid = $this->Sales_model->get_id_based_order($datax['orderid']);
        $val = $this->Sales_model->get_by_id($uid)->row();
        $error = null;
        $result = false;
        
        if ($val->approved == 0){
           
           if ($val->amount <= 0){
               $lng = array('approved' => 0); $error = 'Error Validation Amount..!';
           }
           elseif($this->cek_shipping($uid) == FALSE ){ $lng = array('approved' => 0); $error = 'Shipping Transaction Not Posted..!'; }
           elseif($this->valid_balance($val->cust_id,intval($val->amount+$val->shipping),$val->payment_type) == FALSE ){ $lng = array('approved' => 0); $error = 'Invalid Balance For Wallet Transaction..!'; }
           else{
                $lng = array('approved' => 1);    
                  if ( $this->send_confirmation_email($uid) == true ){

                  $result = true; $error = 'Sales Order : '.$datax['orderid'].' posted'; 
                  $this->update_ledger($uid); // update balance sich customer dan driver
                  $this->Sales_model->update($uid,$lng); 
                  
                  $shp = array('received' => date('Y-m-d H:i:s'));  // update courier di shipping
                  $this->shipping->edit($uid, $shp);

                }else{ $error = 'Sending Error..!'; }
           }
       }    
       else { $error = 'Sales Order Posted..!'; }
       
        $status = array('status' => $result, 'error' => $error);
            
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($status,128))
            ->_display();
            exit;  
    }
    
     // cek order id valid tidak
    function cek_orderid_json(){
        
        $datax = (array)json_decode(file_get_contents('php://input')); 
        if ($this->Sales_model->valid_orderid($datax['orderid']) == FALSE){ $status = false; }else{ $status = true; }
        
        $response = array('status' => $status);
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;
    }
    
    function cek_id_json($uid){
        
        if ($this->Sales_model->valid_id($uid) == FALSE){ $status = false; }else{ $status = true; }
        
        $response = array('status' => $status);
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;
    }
    
    // sales transaction details
    function get_sales_transaction_json($orderid,$type=null){
        
        if ($type != null){
           $res = $this->Sales_model->get_by_id($orderid)->row();
           $orderid = $res->code;
           $salesid = $res->id;
        }
        else{
           $res = $this->Sales_model->get_sales_based_order($orderid)->row();
           $salesid = $res->id;
        }
        
        $output[] = array ("id" => $res->id, "code" => $res->code, "dates" => tglin($res->dates).' &nbsp; '. timein($res->dates),
                           "cust_id" => $res->cust_id, 'customer' => $this->customer->get_name($res->cust_id), "amount" => $res->amount, "tax" => $res->tax, "cost" => $res->cost, 
                           "discount" => $res->discount, "total" => $res->total, "shipping" => $res->shipping,
                           "payment_type" => $res->payment_type, "discount" => $res->discount, "approved" => $res->approved, "canceled" => $res->canceled);
        
        $response['content'] = $output;
        
        // get transaction item
        $trans = $this->sitem->get_last_item($salesid)->result();
        
        foreach ($trans as $res) {
          
          $product = $this->product->get_detail_based_id($res->product_id);
          $output1[] = array ("id" => $res->id, "sales_id" => $res->sales_id, "product" => $product->name, "product_id" => $res->product_id, "qty" => $res->qty,
                             "tax" => $res->tax, 'amount' => $res->amount, "price" => $res->price, "attribute" => $res->attribute, 
                             "image" => base_url().'images/product/'.$product->image,
                             "description" => $res->description );  
        }
        
        $response['transaction'] = $output1;
        
        // get shipping transaction
        $shipping = $this->shipping->get_detail_based_sales($salesid);
        
        $output2[] = array ("id" => $shipping->id, "sales_id" => $shipping->sales_id, "dates" => $shipping->dates, "courierid" => $shipping->courier,
                           "courier" => $this->courrier->get_detail($shipping->courier, 'name'), "coordinate" => $shipping->coordinate, "destination" => $shipping->destination, "distance" => $shipping->distance, 
                           "received" => $shipping->received, "confirm_customer" => $shipping->confirm_customer, "rating" => $shipping->rating,
                           "amount" => $shipping->amount, "status" => $shipping->status );
        
        $response['shipping'] = $output2;
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;
        
    }
    
   //    fungsi untuk mendapatkan sales list berdasarkan customer dan status approved / unapproved
    function get_sales_by_customer_json(){
        
        $datax = (array)json_decode(file_get_contents('php://input'));
        
        $output = null;
        $result = $this->Sales_model->search_json($datax['customer'],$datax['status'],$datax['limit'], $datax['start'])->result();
        $num = $this->Sales_model->search_json($datax['customer'],$datax['status'],$datax['limit'], $datax['start'])->num_rows();
        
        foreach ($result as $res){
            
            $output[] = array ("id" => $res->id, "code" => $res->code, "dates" => tglincomplete($res->dates).' '. timein($res->dates),
                               "cust_id" => $res->cust_id, 'customer' => $this->customer->get_name($res->cust_id), "amount" => $res->amount, "tax" => $res->tax, "cost" => $res->cost, 
                               "discount" => $res->discount, "total" => $res->total, "shipping" => $res->shipping,
                               "payment_type" => $res->payment_type, "discount" => $res->discount, "approved" => $res->approved, "canceled" => $res->canceled);
        }
        
        if ($num > 0){ $response['content'] = $output; }else{ $response['content'] = 'reachedMax'; }
        
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;
    }
   
    //    fungsi untuk mendapatkan sales list berdasarkan courier dan status approved
    function get_sales_by_courier_json(){
        
        $datax = (array)json_decode(file_get_contents('php://input'));
        
        $output = null;
        $result = $this->Sales_model->search_courier_json($datax['courier'],$datax['limit'], $datax['start'])->result();
        $num = $this->Sales_model->search_courier_json($datax['courier'],$datax['limit'], $datax['start'])->num_rows();
        
        foreach ($result as $res){
            
            $shipping = $this->shipping->get_detail_based_sales($res->id);
            
            $output[] = array ("id" => $res->id, "code" => $res->code, "dates" => tglincomplete($res->dates).' '. timein($res->dates),
                               "cust_id" => $res->cust_id, 'customer' => $this->customer->get_name($res->cust_id), "amount" => $res->amount, "tax" => $res->tax, "cost" => $res->cost, 
                               "discount" => $res->discount, "total" => $res->total, "shipping" => $res->shipping,
                               "payment_type" => $res->payment_type, "discount" => $res->discount, "approved" => $res->approved, "canceled" => $res->canceled,
                               "destination" => $shipping->destination
                              );
        }
        
        if ($num > 0){ $response['content'] = $output; }else{ $response['content'] = 'reachedMax'; }
        
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;
    }
    
   // get canceled transaction 
    function get_canceled_by_customer_json(){
        
        $datax = (array)json_decode(file_get_contents('php://input'));
        
        $output = null;
        $result = $this->Sales_model->search_canceled_json($datax['customer'],$datax['limit'])->result();
        
        foreach ($result as $res){
            
            $output[] = array ("id" => $res->id, "code" => $res->code, "dates" => $res->dates,
                               "cust_id" => $res->cust_id, 'customer' => $this->customer->get_name($res->cust_id), "amount" => $res->amount, "tax" => $res->tax, "cost" => $res->cost, 
                               "discount" => $res->discount, "total" => $res->total, "shipping" => $res->shipping,
                               "payment_type" => $res->payment_type, "discount" => $res->discount, "approved" => $res->approved, "canceled" => $res->canceled);
        }
                
        $response['content'] = $output;
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;
        
    }
    
    // edit transaction
     function edit_transaction(){
        
        $datax = (array)json_decode(file_get_contents('php://input')); 
        
        $price = floatval($datax['price']);
        $qty   = intval($datax['qty']);
        $amt_price = floatval($qty*$price);
        $percenttax = 0.1;
        $tax = floatval($percenttax*$amt_price);
        
        $sales = array( 'qty' => $qty, 'tax' => $tax, 'price' => $price, 'amount' => floatval($amt_price));
        $this->sitem->update_trans($datax['id'],$sales);
        
        $response = array('status' => true);
                
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;
    }
    
    // delete transaction
    function delete_transaction(){
        
        $datax = (array)json_decode(file_get_contents('php://input')); 
        $this->sitem->delete($datax['id']);
        
        $id = $this->Sales_model->get_id_based_order($datax['orderid']);
        
        $tot = $this->sitem->total($id);
        $tot = intval($tot['amount']);
        if ($tot == 0){ $this->Sales_model->force_delete($id); $this->shipping->delete_by_sales($id); }
        
        $response = array('status' => true, 'reload' => true);
                
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;
        
    }
    
    function cancel_order_json(){
        
        $datax = (array)json_decode(file_get_contents('php://input')); 
        $val = $this->Sales_model->get_sales_based_order($datax['orderid'])->row();
        $status = false; $error = null;
        
         if ($val->approved == 0){
           
           if($this->cek_shipping($val->id) == TRUE ){ $error = 'Order Sedang Dalam Proses Pengiriman..!'; }
           else{              
             if ($val->canceled != null){ $lng = array('canceled' => null); $error = 'Sales Order Uncanceled..!';      
             }else{ $lng = array('canceled' => date('Y-m-d H:i:s'), 'canceled_desc' => $datax['desc'], 'booked' => 0, 'booked_by' => 0); $error = 'Sales Order '.$datax['orderid'].' Canceled..!';  } 

             $this->update_ledger($val->id);
             $this->Sales_model->update($val->id,$lng); 
             $status = true;
           }
       }    
       else { $error = 'Sales Order Posted..!'; }
        
        $response = array('status' => $status, 'error' => $error);
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;
    }
//  ============== ajax ===========================
    
    
    function get_customer($id)
    {
        if ($id){
          $cust = $this->customer->get_details($id)->row();
          echo $cust->email.'|'.$cust->shipping_address;
        }else { echo "|"; }
    }
    
//     ============== ajax ===========================
     
    public function getdatatable($search=null,$cust='null',$confirm='null')
    {
        if(!$search){ $result = $this->Sales_model->get_last($this->modul['limit'])->result(); }
        else {$result = $this->Sales_model->search($cust,$confirm)->result(); }
	
        $output = null;
        if ($result){
                
         foreach($result as $res)
	 {
           $total = intval($res->amount-$res->discount);  
           if (floatval($total+$res->shipping) > 0){ $status = 'C'; }else{ $status = 'S'; }
           
           if ($this->shipping->cek_shiping_based_sales($res->id) == true){ $ship = 'Shipped'; }else{ $ship = '-'; } // shipping status
	   $output[] = array ($res->id, $res->code, tglin($res->dates), timein($res->dates), $this->customer->get_name($res->cust_id), 
                              idr_format(floatval($total+$res->shipping)),
                              $status, $ship, $res->approved, $res->redeem, $res->canceled
                             );
	 } 
         
        $this->output
         ->set_status_header(200)
         ->set_content_type('application/json', 'utf-8')
         ->set_output(json_encode($output))
         ->_display();
         exit;  
         
        }
    }

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Sales Order');
        $data['h2title'] = 'Sales Order';
        $data['main_view'] = 'sales_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all/hard');
        $data['form_action_report'] = site_url($this->title.'/report_process');
        $data['form_action_import'] = site_url($this->title.'/import');
        $data['form_action_confirmation'] = site_url($this->title.'/payment_confirmation');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['bank'] = $this->bank->combo();
        $data['array'] = array('','');
        $data['month'] = combo_month();
        $data['year'] = date('Y');
        $data['default']['month'] = date('n');
        
	// ---------------------------------------- //
 
        $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = "<li><span><b>";
        $config['cur_tag_close'] = "</b></span></li>";

        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('#','No', 'Code', 'Date', 'Customer', 'Total', 'Ship-Status', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable/');
        $data['graph'] = site_url()."/sales/chart/".$this->input->post('cmonth').'/'.$this->input->post('tyear');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function chart($month=null,$year=null)
    {   
        $data = $this->category->get();
        $datax = array();
        foreach ($data as $res) 
        {  
           $tot = $this->Sales_model->get_sales_qty_based_category($res->id,$month,$year); 
           $point = array("label" => $res->name , "y" => $tot);
           array_push($datax, $point);      
        }
        echo json_encode($datax, JSON_NUMERIC_CHECK);
    }
    
    private function cek_shipping($uid=0){
        
       $shipping = $this->shipping->get_detail_based_sales($uid); 
       if ($shipping){
           
           if($shipping->status == 0){ return FALSE; }else{ return TRUE; }
           
       }else{ return TRUE; }
    }
    
    function cancel($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Sales_model->get_by_id($uid)->row();
       
       if ($val->approved == 0){
           
           if($this->cek_shipping($uid) == TRUE ){ $mess = 'error|Shipping Transaction Posted..!'; }
           else{              
             if ($val->canceled != null){ $lng = array('canceled' => null); $mess = 'true|Sales Order Uncanceled..!';      
             }else{ $lng = array('canceled' => date('Y-m-d H:i:s')); $mess = 'true|Sales Order Canceled..!';  } 

             $this->update_ledger($uid);
             $this->Sales_model->update($uid,$lng); 
           }
       }    
       else { $mess = 'warning|Sales Order Posted..!'; }
       
       echo $mess;
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }
    
    function cleaning()
    {   
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       
          $this->Sales_model->cleaning(); $this->shipping->cleaning();
          $mess = 'true|Cleaning Process..!';
          echo $mess;
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Sales_model->get_by_id($uid)->row();
       
       if ($val->approved == 0){
           
           if ($val->amount <= 0){
               $lng = array('approved' => 0); $mess = 'error|Error Validation Amount..!';
           }
           elseif($this->cek_shipping($uid) == FALSE ){ $lng = array('approved' => 0); $mess = 'error|Shipping Transaction Not Posted..!'; }
           elseif($this->valid_balance($val->cust_id,intval($val->amount+$val->shipping),$val->payment_type) == FALSE ){ $lng = array('approved' => 0); $mess = 'error|Invalid Balance For Wallet Transaction..!'; }
           else{
            $lng = array('approved' => 1);    
              if ( $this->send_confirmation_email($uid) == true ){ $mess = 'true|Sales Order Posted..!'; 
              
              $this->update_ledger($uid); // update balance sich customer
              $this->Sales_model->update($uid,$lng); 
              
              $shp = array('received' => date('Y-m-d H:i:s'));  // update courier di shipping
              $this->shipping->edit($uid, $shp);
              
            }
              else{ $mess = 'error|Sending Error..!'; }
           }
       }    
       else { $mess = 'warning|Sales Order Posted..!'; }
       
       echo $mess;
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }
    
    private function send_confirmation_email($sid)
    {   
       $sales = $this->Sales_model->get_by_id($sid)->row();
       $html = $this->invoice($sid, 'email');
       $this->notif->create($sales->cust_id, 'Wamenak E-Receipt - '.strtoupper($sales->code), 3, $this->title, 'Wamenak E-Receipt - '.strtoupper($sales->code));
       return $this->notif->create($sales->cust_id, $html, 0, $this->title, 'Wamenak E-Receipt - '.strtoupper($sales->code), 0);
    }
    
    private function update_ledger($sid,$type='add'){
        $ledger = new Wallet_ledger_lib();
        $cledger = new Courier_wallet_ledger_lib();
        $sales = $this->Sales_model->get_by_id($sid)->row();
        
        if ($sales->payment_type == 'WALLET'){ 
            if ($type == 'add'){
              $ledger->add('SO', $sid, $sales->dates, 0, intval($sales->amount+$sales->shipping), $sales->cust_id);     
            }else{  $ledger->remove($sales->dates, 'SO', $sid); }
        }elseif ($sales->payment_type == 'CASH'){
            if ($type == 'add'){
              $cledger->add('SO', $sid, $sales->dates, intval($sales->amount+$sales->shipping), 0, $sales->booked_by);     
            }else{  $cledger->remove($sales->dates, 'SO', $sid); $cledger->remove_redeem('RSO', $sid); }
        }
    }
            
    function redeem($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
          
        $val = $this->Sales_model->get_by_id($uid)->row();   
        $cledger = new Courier_wallet_ledger_lib();
        
        if ($val->approved == 1){
            
            if ($val->redeem == 0){ 
                $lng = array('redeem' => 1, 'redeem_date' => date('Y-m-d H:i:s'));
                $this->Sales_model->update($uid,$lng); echo 'true|Status Changed...!'; 
                
                if ($val->payment_type == 'CASH'){ 
                    $cledger->add('RSO', $uid, date('Y-m-d H:i:s'), 0, intval($val->amount+$val->shipping), $val->booked_by);
                }
                
            }
            else{ echo 'warning|Transaction Already Posted...!'; }
        }else{ echo 'warning|Transaction Not Posted...!'; }
             
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }
    
    
    function delete_all($type='soft')
    {
      if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
      
        $cek = $this->input->post('cek');
        $jumlah = count($cek);

        if($cek)
        {
          $jumlah = count($cek);
          $x = 0;
          for ($i=0; $i<$jumlah; $i++)
          {
             if ($type == 'soft') { $this->Sales_model->delete($cek[$i]); }
             else { $this->shipping->delete_by_sales($cek[$i]);
                    $this->Sales_model->force_delete($cek[$i]);  
             }
             $x=$x+1;
          }
          $res = intval($jumlah-$x);
          //$this->session->set_flashdata('message', "$res $this->title successfully removed &nbsp; - &nbsp; $x related to another component..!!");
          $mess = "$res $this->title successfully removed &nbsp; - &nbsp; $x related to another component..!!";
          echo 'true|'.$mess;
        }
        else
        { //$this->session->set_flashdata('message', "No $this->title Selected..!!"); 
          $mess = "No $this->title Selected..!!";
          echo 'false|'.$mess;
        }
      }else{ echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
      
    }

    function delete($uid)
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
            
            $val = $this->Sales_model->get_by_id($uid)->row();
            
            if ($val->approved == 1){
                $lng = array('redeem' => 0, 'approved' => 0, 'canceled' => null, 'redeem_date' => null); $this->Sales_model->update($uid,$lng);
                $this->update_ledger($uid,'min');
                echo "true|1 $this->title successfully rollback..!";
            }else{
                $this->shipping->delete_by_sales($uid);
                $this->Sales_model->delete($uid);
                echo "true|1 $this->title successfully removed..!";
            }
            
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        
    }
    
    function add($param=0)
    {

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Create New '.$this->modul['title'];
        $data['main_view'] = 'sales_form';
        if ($param == 0){$data['form_action'] = site_url($this->title.'/add_process'); $data['counter'] = $this->Sales_model->counter(); }
        else { $data['form_action'] = site_url($this->title.'/update_process'); $data['counter'] = $param; }
	
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));
        $data['form_action_trans'] = site_url($this->title.'/add_item/0'); 
        $data['form_action_shipping'] = site_url($this->title.'/shipping/0'); 

        $data['customer'] = $this->customer->combo();
        $data['agent'] = $this->agent->combo();
        $data['payment'] = $this->payment->combo();
        $data['source'] = site_url($this->title.'/getdatatable');
        $data['graph'] = site_url()."/sales/chart/";
        $data['city'] = $this->city->combo_city_combine();
        $data['default']['dates'] = date("Y/m/d");
        $data['product'] = $this->product->combo();
        
        $data['items'] = $this->sitem->get_last_item(0)->result();

        $this->load->view('template', $data);
    }

    function add_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'category_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('category/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('ccustomer', 'Customer', 'required');
        $this->form_validation->set_rules('tdates', 'Transaction Date', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $sales = array('cust_id' => $this->input->post('ccustomer'), 'dates' => date("Y-m-d H:i:s"),
                           'created' => date('Y-m-d H:i:s'));

            $this->Sales_model->add($sales);
            echo "true|One $this->title data successfully saved!|".$this->Sales_model->counter(1);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
//            redirect($this->title.'/update/'.$this->Sales_model->counter(1));
        }
        else{ $data['message'] = validation_errors(); echo "error|".validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }
    
    function add_item($sid=0)
    { 
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       if ($sid == 0){ echo 'error|Sales ID not saved'; }
       else {
       
         // Form validation
        $this->form_validation->set_rules('cproduct', 'Product', 'required|callback_valid_product['.$sid.']');
        $this->form_validation->set_rules('tqty', 'Qty', 'required|numeric');
        $this->form_validation->set_rules('tprice', 'Price', 'required|numeric');
        $this->form_validation->set_rules('ctax', 'Tax Type', 'required');

            if ($this->form_validation->run($this) == TRUE && $this->valid_confirm($sid) == TRUE)
            {
                $amt_price = intval($this->input->post('tqty')*$this->input->post('tprice'));
                $tax = intval($this->input->post('ctax')*$amt_price);
                $sales = array('product_id' => $this->input->post('cproduct'), 'sales_id' => $sid,
                               'qty' => $this->input->post('tqty'), 'tax' => $tax,
                               'price' => $this->input->post('tprice'), 'amount' => intval($amt_price));

                $this->sitem->add($sales);
                $this->update_trans($sid);
                echo "true|Sales Transaction data successfully saved!|";
            }
            else{ echo "error|".validation_errors(); }  
        }
       }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    private function update_trans($sid)
    {
        $totals = $this->sitem->total($sid);
        $price = intval($totals['amount']);
        
        // shipping total        
        $transaction = array('tax' => $totals['tax'], 'total' => intval($price-$totals['tax']), 'amount' => intval($price), 'shipping' => $this->shipping->total($sid));
	$this->Sales_model->update($sid, $transaction);
    }
    
    function delete_item($id,$sid)
    {
        if ($this->acl->otentikasi2($this->title) == TRUE && $this->valid_confirm($sid) == TRUE){ 
        
        $this->sitem->delete($id); // memanggil model untuk mendelete data
        $this->update_trans($sid);
        $this->session->set_flashdata('message', "1 item successfully removed..!"); // set flash data message dengan session
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        redirect($this->title.'/update/'.$sid);
    }
    
    private function split_array($val)
    { return implode(",",$val); }
   
    function shipping($sid=0)
    { 
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       if ($sid == 0){ echo 'error|Sales ID not saved'; }
       else {
       
        $sales = $this->Sales_model->get_by_id($sid)->row();
           
         // Form validation
        $this->form_validation->set_rules('ccity', 'City', 'required');
        $this->form_validation->set_rules('tshipaddkurir', 'Shipping Address', 'required');
        $this->form_validation->set_rules('tweight', 'Weight', 'required|numeric');

            if ($this->form_validation->run($this) == TRUE && $this->valid_confirm($sid) == TRUE)
            {
                $param = array('sales_id' => $sid, 'shipdate' => null,
                               'courier' => 'ESL', 'dest' => $this->input->post('ccity'),
                               'district' => $this->input->post('cdistrict'),
                               'dest_desc' => $this->input->post('tshipaddkurir'), 'package' => 'RDX',
                               'weight' => $this->input->post('tweight'), 'rate' => $this->input->post('rate'),
                               'amount' => intval($this->input->post('rate')*$this->input->post('tweight')));
                
                $this->shipping->create($sid, $param);
                $this->update_trans($sid);
                echo "true|Shipping Transaction data successfully saved!|";
            }
            else{ echo "error|".validation_errors(); }  
        }
       }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($param=0)
    {
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Update '.$this->modul['title'];
        $data['main_view'] = 'sales_form';
        $data['form_action'] = site_url($this->title.'/update_process/'.$param); 
        $data['form_action_trans'] = site_url($this->title.'/add_item/'.$param); 
	
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['source'] = site_url($this->title.'/getdatatable');
        $data['graph'] = site_url()."/sales/chart/";
        $data['product'] = $this->product->combo();
        
        $sales = $this->Sales_model->get_by_id($param)->row();
        $customer = $this->customer->get_details($sales->cust_id)->row();
        
        $data['counter'] = $sales->code; 
        $data['default']['customer'] = $customer->first_name.' '.$customer->last_name;
        $data['default']['email'] = $customer->email;
        $data['default']['dates'] = $sales->dates;
        $data['default']['payment'] = $sales->payment_type;
        $data['total'] = $sales->total;
        $data['shipping'] = $sales->shipping;
        $data['tot_amt'] = intval($sales->amount+$sales->shipping);
        
        $shippping = $this->shipping->get_detail_based_sales($param);
        if ($shippping){ $data['default']['ship_address'] = $shippping->destination; }else{ $data['default']['ship_address'] = '-'; }
        $data['tax']    = $sales->tax;
        
        // transaction table
        $data['items'] = $this->sitem->get_last_item($param)->result();
        $this->load->view('template', $data);
    }
    
        // Fungsi update untuk menset texfield dengan nilai dari database
    function invoice($param=0,$type='invoice')
    {
        $data['title'] = $this->properti['name'].' | Invoice '.ucwords($this->modul['title']).' | SO-0'.$param;
        $sales = $this->Sales_model->get_by_id($param)->row();
        
        if ($sales){
                
            // property
            $data['p_name'] = $this->properti['sitename'];
            $data['p_address'] = $this->properti['address'];
            $data['p_city'] = $this->properti['city'];
            $data['p_zip']  = $this->properti['zip'];
            $data['p_phone']  = $this->properti['phone1'];
            $data['p_email']  = $this->properti['email'];
            $data['p_logo']  = $this->properti['logo'];

            // customer details
            $customer = $this->customer->get_details($sales->cust_id)->row();
            $data['c_name'] = strtoupper($customer->first_name.' '.$customer->last_name);
            $data['c_email'] = $customer->email;
            $data['c_phone'] = $customer->phone1;

            // sales
            $data['code'] = $sales->code;
            $data['dates'] = tglincomplete($sales->dates);
            $data['time'] = timein($sales->dates);

            $data['total'] = idr_format($sales->total);
            $data['discount'] = idr_format(floatval($sales->discount));
            $data['shipping'] = idr_format(floatval($sales->shipping));
            $data['tot_amt'] = idr_format(intval($sales->amount-$sales->discount+$sales->cost+$sales->shipping));

            // shipping
            $shippping = $this->shipping->get_detail_based_sales($param);
            if ($shippping){ $data['destination'] = $shippping->destination; }else{ $data['destination'] = '-'; }

            // transaction table
            $data['items'] = $this->sitem->get_last_item($param)->result();
            if ($type == 'invoice'){ $this->load->view('sales_invoice', $data); }
            else{
                $html = $this->load->view('sales_invoice', $data, true); // render the view into HTML
                return $html;
            }
        }
    }
    
    function send_email_offer_json(){
        
        $datax = (array)json_decode(file_get_contents('php://input')); 
        
        $error = null;
        $sid = $this->Sales_model->get_id_based_order($datax['orderid']);
        $no = $datax['orderid'];
        
        $pdfFilePath = FCPATH."/downloads/".$no.".pdf";
        if (file_exists($pdfFilePath) == TRUE){ 
            
          if ($this->send_confirmation_email($sid) == TRUE && $this->send_confirmation_sms($sid) == TRUE)
          { $status = true; $error = 'Invoice Sent..!'; }
          else { $status = false; $error = 'Failed to sending invoice..!'; }
        }
        else{ $status = false; $error = 'File not existed..!'; }
        
        $status = array('status' => $status, 'error' => $error);
        $response['status'] = $status;
            
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit;  
    }
    
    
    function update_process($param)
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'sales_form';
        $data['form_action'] = site_url($this->title.'/update_process/'.$param); 
	$data['link'] = array('link_back' => anchor('category/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tcustomer', 'Customer', 'required');
        $this->form_validation->set_rules('cpayment', 'Payment Type', 'required');
        $this->form_validation->set_rules('tdates', 'Transaction Date', 'required');

        if ($this->form_validation->run($this) == TRUE && $this->valid_confirm($param) == TRUE && $this->valid_items($param) == TRUE)
        {
            $sales = array('updated' => date('Y-m-d H:i:s'), 'payment_type' => $this->input->post('cpayment'));

            $this->Sales_model->update($param, $sales);
            $this->update_trans($param);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
            echo "true|One $this->title data successfully saved!|".$param;
        }
        else{ echo "error|". validation_errors(); $this->session->set_flashdata('message', validation_errors()); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        //redirect($this->title.'/update/'.$param);
    }
    
    function confirmation($sid)
    {
        $sales = $this->Sales_model->get_by_id($sid)->row();
	$this->session->set_userdata('langid', $sales->id);
        
        echo $sid.'|'.$sales->sender_name.'|'.$sales->sender_acc.'|'.$sales->sender_bank.'|'.$sales->sender_amount.'|'.$sales->bank_id.'|'.$sales->confirmation.'|'.
             tglin($sales->paid_date).'|'.date("H:i:s", $sales->paid_date);
    }
    
    function payment_confirmation()
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'sales_form';
	$data['link'] = array('link_back' => anchor('category/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tcdates', 'Confirmation Date', 'required');
        $this->form_validation->set_rules('taccname', 'Account Name', 'required');
        $this->form_validation->set_rules('taccno', 'Account No', 'required');
        $this->form_validation->set_rules('taccbank', 'Account Bank', 'required');
        $this->form_validation->set_rules('tamount', 'Amount', 'required|numeric');
        $this->form_validation->set_rules('cbank', 'Merchant Bank', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            if ($this->input->post('cstts') == '1'){
                $sales = array('confirmation' => 1, 'updated' => date('Y-m-d H:i:s'));
                $stts = 'confirmed!';
                // lakukan action pengurangan stock
                $this->change_product($this->session->userdata('langid'));
                
                $this->Sales_model->update($this->session->userdata('langid'), $sales);
                // lakukan action email ke customer
                $status = $this->mail_invoice($this->session->userdata('langid'));
            }
            else { $sales = array('confirmation' => 0, 'updated' => date('Y-m-d H:i:s')); 
                   $stts = 'unconfirmed!'; 
                   // lakukan action pengurangan stock
                   $this->change_product($this->session->userdata('langid'),0);
                $status = true;
                $this->Sales_model->update($this->session->userdata('langid'), $sales);
            }
            
            if ($status == true){
               echo "true|One $this->title data payment successfully ".$stts;  
            }else { echo "error|Error Sending Mail...!! ";   }
        }
        else{ echo "error|". validation_errors(); $this->session->set_flashdata('message', validation_errors()); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; } 
    }
    
    private function change_product($sid,$type=1)
    {
        $item = $this->sitem->get_last_item($sid)->result();
        if ($type==1){ foreach ($item as $res) { $this->product->min_qty($res->product_id,$res->qty); } }
        else{ foreach ($item as $res) { $this->product->add_qty($res->product_id,$res->qty); } }
    }
    
    function valid_product($id,$sid)
    {
        if ($this->sitem->valid_product($id,$sid) == FALSE)
        {
            $this->form_validation->set_message('valid_product','Product already listed..!');
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    function valid_name($val)
    {
        if ($this->Sales_model->valid('name',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_name','Name registered..!');
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    function valid_pending_order($cust){
        
        if ($this->Sales_model->valid_pending_order($cust) == FALSE){ return FALSE; }else{ return TRUE; }
    }
    
    function valid_balance($custid,$amt=0,$type='CASH'){
        
        if ($type == 'CASH'){ return TRUE; }else{
            
            $nilai = '{ "customer":"' . $custid. '" }';
            $url = site_url('customer/balance');

            $response = $this->api_lib->request($url, $nilai);
            $datax = (array) json_decode($response, true);
            if ($amt <= intval($datax['balance'])){ return TRUE; }else{ return FALSE; }
        } 
    }
    
    function limit_balance($amt=0,$type='CASH'){
        
        if ($type == 'WALLET'){ return TRUE; }else{
            if (intval($amt) > 50000){ return FALSE; }else{ return TRUE; }
        } 
    }
    
    function valid_confirm($sid,$type='id')
    {
        if ($this->Sales_model->valid_confirm($sid,$type) == FALSE)
        {
            $this->form_validation->set_message('valid_confirm','Sales Already Confirmed..!');
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    function cek_orderid($orderid){
        if ($this->Sales_model->valid_orderid($orderid) == FALSE){ return FALSE; }else{ return TRUE; }
    }
    
    function valid_items($sid)
    {
        if ($this->sitem->valid_items($sid) == FALSE)
        {
            $this->form_validation->set_message('valid_items',"Empty Transaction..!");
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    function report_process()
    {
        $this->acl->otentikasi2($this->title);
        $data['title'] = $this->properti['name'].' | Report '.ucwords($this->modul['title']);

        $data['rundate'] = tglin(date('Y-m-d'));
        $data['log'] = $this->session->userdata('log');
        $period = $this->input->post('reservation');  
        $start = picker_between_split($period, 0);
        $end = picker_between_split($period, 1);
        $shipped = $this->input->post('cshipped');

        $data['start'] = tglin($start);
        $data['end'] = tglin($end);
        
//        Property Details
        $data['company'] = $this->properti['name'];
        $data['reports'] = $this->Sales_model->report($start,$end)->result();
//        
        if ($this->input->post('ctype') == 0){ $this->load->view('sales_report', $data); }
        else { $this->load->view('sales_pivot', $data); }
    }   

}

?>