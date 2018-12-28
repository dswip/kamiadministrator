<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Cart_model', 'model', TRUE);

        $this->properti = $this->property->get();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->product = new Product_lib();
        $this->color = new Color_lib();
        $this->series = new Model_lib();
        $this->material = new Material_lib();
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token'); 
    }

    private $properti, $modul, $title;
    private $product, $color, $series, $material;

    function index()
    {
       $this->get(); 
    }
    
    public function get($customer){
        
        $datas = (array)json_decode(file_get_contents('php://input'));
//        $customer = $datas['customer'];
        
        $result = $this->model->get_by_customer($customer)->result();
        $output = null;
        if ($result){
	foreach($result as $res)
	{
           if ($this->cek_valid($res->id, $res->product_id, $res->qty) == TRUE){
               
             $product = $this->product->get_by_id($res->product_id)->row();
	     $output[] = array ("id" => $res->id, "customer" => $res->customer, "product_id" => $res->product_id, "product" => $product->name,
                              "qty" => $res->qty, "tax" => $res->tax, "amount" => $res->amount, "price" => $res->price, "attribute" => $res->attribute,
                              "description" => $res->description, "publish" => $res->publish,
                              "image" => base_url().'images/product/'.$product->image);      
           } 
	}
        
        $total_p = $this->model->total($customer,1);
        $total_u = $this->model->total($customer,0);
        
        $total = array('amount_publish' => intval($total_p['amount']), 'amount_unpublish' => intval($total_u['amount']), 'qty_publish' => intval($total_p['qty']), 'qty_unpublish' => intval($total_u['qty']));
        $response['content'] = $output;
        $response['total'] = $total;
        
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit; 
        }
    }
    
    private function cek_valid($uid,$pid,$qty){
        
         if ( $this->product->valid_restricted($pid) == FALSE || $this->product->valid_qty($pid, $qty) == FALSE ){
             $this->model->force_delete($uid); return FALSE;
         }else{ return TRUE; }
    }
    
    function delete_customer()
    {
        $datax = (array)json_decode(file_get_contents('php://input')); 
        $status = true;
        $error = null;
        
        if ( isset($datax['customer']) ){  $this->model->delete_by_customer($datax['customer']);  }
        else{ $status = false; $error = 'Invalid JSON Format';  }
        
        $response = array('status' => $status, 'error' => $error);
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }
    
    function publish()
    {
        $datax = (array)json_decode(file_get_contents('php://input')); 
        $status = true;
        $error = null;
        
        if ( isset($datax['id']) ){ $error = $this->model->publish($datax['id']); }
        else{ $status = false; $error = 'Invalid JSON Format';  }
        
        $response = array('status' => $status, 'error' => $error);
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }

    function delete()
    {
        $datax = (array)json_decode(file_get_contents('php://input')); 
        $status = true;
        $error = null;
        
        if ( isset($datax['id']) ){  $this->model->force_delete($datax['id']);  }
        else{ $status = false; $error = 'Invalid JSON Format';  }
        
        $response = array('status' => $status, 'error' => $error);
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }

    function add()
    {
        $datax = (array)json_decode(file_get_contents('php://input')); 
        $status = true;
        $error = null;
        
        if ( isset($datax['customer']) && isset($datax['product_id']) && isset($datax['qty']) && isset($datax['attribute']) && isset($datax['description']) )
        {   
            
            if ( $this->product->valid_restricted($datax['product_id']) == FALSE ){ $error = 'Waktu pemesanan berakhir'; $status = false; }
            elseif( $this->product->valid_qty($datax['product_id'], $datax['qty']) == FALSE ) { $error = 'Stock tidak tersedia'; $status = false;  }
            else{
                
                $price = $this->product->get_price($datax['product_id']);
                $amount = intval($price)*intval($datax['qty']);
                $tax = intval($amount*0);

                $cart = array('customer' => $datax['customer'], 'product_id' => $datax['product_id'], 'qty' => $datax['qty'],
                              'price' => $price, 'attribute' => $datax['attribute'], 'description' => $datax['description'],  
                              'amount' => $amount, 'tax' => $tax,
                              'created' => date('Y-m-d H:i:s'));

                $this->model->create($cart);
            }

        }
        else{ $status = false; $error = 'Invalid JSON Format';  }
        
        $response = array('status' => $status, 'error' => $error);
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }

    function update()
    {
        $datax = (array)json_decode(file_get_contents('php://input')); 
        $status = true;
        $error = null;
        
        if ( isset($datax['id']) && isset($datax['qty']) )
        {   
            $price = $this->model->get_by_id($datax['id'])->row();
            $price = $price->price;
            
            $amount = intval($price)*intval($datax['qty']);
            $tax = intval($amount*0);
            $cart = array('qty' => $datax['qty'], 'amount' => $amount, 'tax' => $tax);

            $this->model->updateid($datax['id'],$cart);
        }
        else{ $status = false; $error = 'Invalid JSON Format';  }
        
        $response = array('status' => $status, 'error' => $error);
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }

}

?>
