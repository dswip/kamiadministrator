<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends MX_Controller {


   public function __construct()
   {
        parent::__construct();

        $this->load->helper('date');
        $this->log = new Log_lib();
        $this->load->library('email');
        $this->login = new Login_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('login');

        $this->properti = $this->property->get();   
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token'); 

        // Your own constructor code
   }

   private $date,$time,$log,$login;
   private $properti,$com;

   function index()
   {
       redirect('login');
   }
   
    function response($data, $status = 200){ 
          $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ))
            ->_display();
            exit;  
    }
   
   function times($param=null){
        
        $startTime = date("Y-m-d H:i:s");
        $cenvertedTime = date('Y-m-d H:i:s',strtotime('-7 hour',strtotime($startTime)));

        if (!$param){
           return $this->response(array('gmt7' => $startTime, 'gmt' => lockcode_format($cenvertedTime))); 
        }
   }
   
   function get_kecamatan(){
       
       $offset = $this->input->post('start');
       $limit = $this->input->post('limit');
       
       $this->db->select('nama, id_kabupaten');
       $this->db->order_by('nama', 'asc'); 
       $this->db->limit($limit, $offset);
       $result = $this->db->get('kecamatan');
       
       if ($result->num_rows > 0){
            $response = '';
            
            foreach ($result->result() as $res) {
                $response .= '
                    <div>
                       <h2>'.$res->nama.'</h2>
                       <p>'.$res->id_kabupaten.'</p>
                    </div>
                '; 
            }
            exit($response);
            
        }else{ exit('reachedMax'); }
       
   }
   
   function calculate_distance(){
        
       $datax = (array)json_decode(file_get_contents('php://input')); 
       
       $destination = str_replace(' ', '', $datax['to']);
       $property = new Property();
       $property = $property->get();
       $source = $property['coordinate'];
       $error = null;
       $result = 0;
       
       if ($destination != null){     
         $dataJson = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$source."&destinations=".$destination."&key=AIzaSyCIyA_tbgcPHkf0NaVCgJZ3KtiCbYRaD0I");
         $data = json_decode($dataJson,true);
         $nilaiJarak = $data['rows'][0]['elements'][0]['distance']['text'];    
         $result = round($nilaiJarak);
       }
       else{ $error = 'Invalid JSON Format'; }
       $response = array('result' => $result, 'error' => $error);
                
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;
    }

   public function category($parent=0){
        
        $lib = new Categoryproduct_lib();
        $result = $lib->get_based_parent($parent);
        
        if ($result){
	foreach($result as $res)
	{
	   $output[] = array ("id" => $res->id, "name" => ucfirst($res->name), "permalink" => $res->permalink, "order" => $res->orders, "image" => base_url().'images/category/'.$res->image);
	}
        $response['content'] = $output;
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit; 
        }
    }

   public function category_detail($parent=0){
        
        $lib = new Categoryproduct_lib();
        $res = $lib->get_by_id($parent)->row();
        
        if ($res){
	$output[] = array ("id" => $res->id, "name" => $res->name, "permalink" => $res->permalink, "order" => $res->orders, "image" => base_url().'images/category/'.$res->image);
        
        $response['content'] = $output;
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit; 
        }
    }
    
    function contact(){
        
       $datax = (array)json_decode(file_get_contents('php://input')); 
       
       $this->load->library('email');
       $this->email->from($datax['email'], $datax['name']);
       $this->email->to($this->properti['email']);  
       $this->email->subject('Contact Message : '.$datax['name']);
       $this->email->message($datax['message']);	

       if ($this->email->send()){ $stts = 'true'; }else{ $stts = (string)$this->email->print_debugger(); }

       $response = array('status' => $stts);
       $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;
   }
    
    // get bank list
    public function bank_list(){
        
        $datas = (array)json_decode(file_get_contents('php://input'));
        
        $lib = new Bank_lib();
        $result = $lib->get();
        
        if ($result){
	foreach($result as $res)
	{
	   $output[] = array ("id" => $res->id, "acc_name" => $res->acc_name, "acc_no" => $res->acc_no, "acc_bank" => $res->acc_bank,
                              "currency" => $res->currency);
	}
        $response['content'] = $output;
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit; 
        }
    }
    
     // get bank list
    public function slider(){
        
        $datas = (array)json_decode(file_get_contents('php://input'));
        
        $lib = new Product_lib();
        $result = $lib->get_slider();
        
        if ($result){
	foreach($result as $res)
	{
	   $output[] = array ("id" => $res->id, "name" => $res->name, "url" => $res->url, "orders" => $res->orders, 
                              "image" => base_url().'images/slider/'.$res->image);
	}
        $response['content'] = $output;
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit; 
        }
    }
    
    // get otp
    function otp(){
        
       $datas = (array)json_decode(file_get_contents('php://input'));
       $sms = new Sms_lib(); 
       $cust = new Customer_lib();
       
       if (isset($datas['type'])){ $code = random_password(); }else{ $code = mt_rand(1000,9999); }
       
       $stts = $sms->send($cust->get_detail($datas['customer'], 'phone1'), $this->properti['name'].' : Kode OTP : '.$code);
       $response = array('status' => $stts, 'code' => $code);
       $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;   
    }
    
    function send_otp(){
        
       $datas = (array)json_decode(file_get_contents('php://input'));
       $sms = new Sms_lib(); 
       
       if (isset($datas['type'])){ $code = random_password(); }else{ $code = mt_rand(1000,9999); }
       
       $stts = $sms->send($datas['phone'], $this->properti['name'].' : Kode OTP : '.$code);
       $response = array('status' => $stts, 'code' => $code);
       $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;   
    }
    
     function resend_otp(){
        
       $datas = (array)json_decode(file_get_contents('php://input'));
       $sms = new Sms_lib(); 
       $login = new Customer_login_lib();
       $cust = new Customer_lib();
       
       $code = $login->get_by_userid($datas['customer']);
       
       $stts = $sms->send($cust->get_detail($datas['customer'], 'phone1'), $this->properti['name'].' : Kode OTP : '.$code);
       $response = array('status' => $stts, 'code' => $code);
       $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;   
    }
    
    function resend_otp_driver(){
        
       $datas = (array)json_decode(file_get_contents('php://input'));
       $sms = new Sms_lib(); 
       $login = new Courier_login_lib();
       $cust = new Courier_lib();
       
       $code = $login->get_by_userid($datas['driver']);
       
       $stts = $sms->send($cust->get_detail($datas['driver'], 'phone'), $this->properti['name'].' : Kode OTP : '.$code);
       $response = array('status' => $stts, 'code' => $code);
       $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;   
    }
    

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
