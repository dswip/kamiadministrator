<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once 'definer.php';

class Delivery extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Delivery_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->role = new Role_lib();
        $this->customer = new Customer_lib();
        $this->payment = new Payment_lib();
        $this->city = new City_lib();
        $this->product = new Product_lib();
        $this->sales = new Sales_lib();
        $this->shiprate = new Shiprate_lib();
        $this->courier = new Courier_lib();
        $this->api_lib = new Api_lib();
        $this->notif = new Notif_lib();
    }

    private $properti, $modul, $title, $api_lib, $notif;
    private $role, $customer, $payment, $city, $product, $sales, $shiprate, $courier;

    function index()
    {
       $this->get_last(); 
    }
    
    
    function calculate_distance($destination='0',$type=null){
        
        $source = $this->properti['coordinate'];
        
        $dataJson = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$source."&destinations=".$destination."&key=AIzaSyCIyA_tbgcPHkf0NaVCgJZ3KtiCbYRaD0I");
        $data = json_decode($dataJson,true);
        if ($data){
          $nilaiJarak = $data['rows'][0]['elements'][0]['distance']['text'];    
        }else{ $nilaiJarak = 0; }
        if (!$type){ return round($nilaiJarak); }else{ echo round($nilaiJarak); }
    }
    
    function calculate_shiprate($distance=9,$payment='CASH',$minimum=10000) {
        
        $nilai = '{ "period":"'.date('H').'", "distance":"'.$distance.'", "payment":"'.$payment.'", "minimum":"'.$minimum.'" }';
        $url = site_url('shiprate/calculate');

        $response = $this->api_lib->request($url, $nilai);
        $datax = (array) json_decode($response, true);
        return intval($datax['result']);
    }
     
    public function getdatatable($search=null,$cust='null',$sales='null',$ship='null',$received='null')
    {
        if(!$search){ $result = $this->Delivery_model->get_last($this->modul['limit'])->result(); }
        else {
            $result = $this->Delivery_model->search($cust,$sales,$ship,$received)->result(); 
        }
	
        $output = null;
        if ($result){
                
         foreach($result as $res)
	 {
           if ($res->status == 0){ $status = 'Process'; }
           elseif($res->status == 1){ $status = 'Delivered'; } 
           
           // sales date
           $sales = $this->sales->get_detail_sales($res->sales_id);
           
	   $output[] = array ($res->id, 
                              $sales->code, // sales no
                              tglin($sales->dates), // sales no
                              $this->customer->get_name($sales->cust_id), // customer
                              tglin($res->dates), // delivery date
                              strtoupper($this->courier->get_detail($res->courier, 'name')), // courier
                              $res->distance, // distance
                              $res->received, // received
                              idr_format($res->amount), // package
                              $res->status, // paid status 
                              $status, // shipped status
                              $res->confirm_customer
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
        $data['h2title'] = 'Delivery Order';
        $data['main_view'] = 'delivery_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all/hard');
        $data['form_action_report'] = site_url($this->title.'/report_process');
        $data['form_action_import'] = site_url($this->title.'/import');
        $data['form_action_confirmation'] = site_url($this->title.'/payment_confirmation');
        $data['link'] = array('link_back' => anchor('sales/','Back', array('class' => 'btn btn-danger')));

        $data['customer'] = $this->customer->combo();
        $data['courier'] = $this->courier->combo();
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
        $this->table->set_heading('#', 'No', 'Sales', 'Cust', 'Ship-Date', 'Courier', 'Balance', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable/');
        $data['graph'] = site_url()."/delivery/chart/".$this->input->post('cmonth').'/'.$this->input->post('tyear');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
        
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Delivery_model->get_by_id($uid)->row();
       $sales = $this->sales->get_by_id($val->sales_id)->row();
       
        if ($sales->approved != 0){
            echo "error|Sales Posted, Transaction Rollback..!"; 
        }
        elseif ($val->amount == 0){
            echo "error|Invalid Amount, Transaction Rollback..!"; 
        }
        else{ 
            if ($val->status == 0){ $lng = array('status' => 1);  }else { $lng = array('status' => 0); }
            $content = $this->properti['name']." : Order ".$sales->code." sedang proses pengantaran ke alamat tujuan. Informasi lebih lanjut hubungi kami di ".$this->properti['phone1'];
            if ($this->notif->create($sales->cust_id, $content, 4, $this->title, '', 0) == true){
               
                $this->Delivery_model->update($uid,$lng);
                // update shipping amount sales
                $res = array('shipping' => $val->amount);
                $this->sales->update($val->sales_id, $res);
                
                echo 'true|Status Changed...!';
            }else{ echo 'error|Notif Sent Failed...!'; }
        }
       
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }

    function delete($uid)
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
            
            $val = $this->Delivery_model->get_by_id($uid)->row();
            $sales = $this->sales->get_by_id($val->sales_id)->row();
            
            if ($sales->approved == 0){
                    
               if ($val->status == 1){
                   
                  $lng = array('received' => null, 'status' => 0);
                  $this->Delivery_model->update($uid,$lng);
                  echo "true|1 $this->title successfully rollback..!";  
               }else{
                   $this->Delivery_model->delete($uid);
                   echo "true|1 $this->title successfully removed..!";  
               } 
            }else{ echo "error|Sales Posted, Transaction Rollback..!"; }
            
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function add($param=0)
    {

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Create New '.$this->modul['title'];
        $data['main_view'] = 'delivery_form';
        if ($param == 0){$data['form_action'] = site_url($this->title.'/add_process'); $data['counter'] = $this->Delivery_model->counter(); }
        else { $data['form_action'] = site_url($this->title.'/update_process'); $data['counter'] = $param; }
	
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));
        $data['form_action_trans'] = site_url($this->title.'/add_item/0'); 
        $data['form_action_delivery'] = site_url($this->title.'/delivery/0'); 

        $data['customer'] = $this->customer->combo();
        $data['payment'] = $this->payment->combo();
        $data['source'] = site_url($this->title.'/getdatatable');
        $data['graph'] = site_url()."/delivery/chart/";
        $data['city'] = $this->city->combo_city_combine();
        $data['default']['dates'] = date("Y/m/d");
        $data['product'] = $this->product->combo();
        
        $data['items'] = $this->sitem->get_last_item(0)->result();

        $this->load->view('template', $data);
    }
    
    
    function track($uid=null)
    {        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Tracking '.$this->modul['title'];
        $data['main_view'] = 'courier_track';
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));
        
        $delivery = $this->Delivery_model->get_by_id($uid)->row();
        $sales = $this->sales->get_by_id($delivery->sales_id)->row();
        
        $coor = explode(',',$this->properti['coordinate']);
        $data['lat'] = $coor[0];
        $data['long'] = $coor[1];
        $data['curid'] = $delivery->courier;
        $data['code'] = $sales->code;
        $data['dates'] = tglincomplete($delivery->dates).'&nbsp;'. timein($delivery->dates);
        $data['courier_ic'] = $this->courier->get_detail($delivery->courier, 'ic');
        $data['courier'] = $this->courier->get_detail($delivery->courier, 'name');
        $data['customer'] = $this->customer->get_detail($sales->cust_id, 'first_name');
        $data['cust_phone'] = $this->customer->get_detail($sales->cust_id, 'phone1');
        $data['cust_address'] = $delivery->destination;
        
        $coordelivery = explode(',',$delivery->coordinate);
        $data['dlat'] = $coordelivery[0];
        $data['dlong'] = $coordelivery[1];
        
        $this->load->view('template', $data);
    }
    
    
    private function split_array($val)
    { return implode(",",$val); }
    
    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($sid)
    {
        $delivery = $this->Delivery_model->get_by_id($sid)->row();
	$this->session->set_userdata('langid', $delivery->id);
        
        $sales = $this->sales->get_detail_sales($delivery->sales_id);
        
        echo $sid.'|'.$delivery->sales_id.'|'.$sales->code.'|'.tglin($sales->dates).'|'.strtoupper($delivery->courier).'|'.$delivery->coordinate.'|'.$delivery->distance.'|'.
             $delivery->destination.'|'.$delivery->amount.'|'.$delivery->status.'|'.$sales->approved;
    }
    
    function send_invoice_email($param)
    {   
        // property display
       $data['p_logo'] = $this->properti['logo'];
       $data['p_name'] = $this->properti['name'];
       $data['p_site_name'] = $this->properti['sitename'];
       $data['p_address'] = $this->properti['address'];
       $data['p_zip'] = $this->properti['zip'];
       $data['p_city'] = $this->properti['city'];
       $data['p_phone'] = $this->properti['phone1'];
       $data['p_email'] = $this->properti['email'];
       
       $delivery = $this->Delivery_model->get_by_id($param)->row();
       $sales = $this->sales->get_detail_sales($delivery->sales_id);
       $customer = $this->customer->get_details($sales->cust_id)->row();
         
        // email send
        $this->load->library('email');
        $config['charset']  = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';

        $this->email->initialize($config);
        $this->email->from($this->properti['email'], $this->properti['name']);
        $this->email->to($customer->email);
        $this->email->cc($this->properti['cc_email']); 
        
//        $html = $this->load->view('agent_confirmation',$data,true); 
        $html = $this->invoice($param,'html');
        
        $this->email->subject('Delivery Confirmation - '.strtoupper($sales->code));
        $this->email->message($html);

        if (!$this->email->send()){ echo 'error|Failed to sent invoice..!!'; }else{ echo 'true|Invoice sent..!!';  }
    }
    
        // Fungsi update untuk menset texfield dengan nilai dari database
    function invoice($param=0,$type='invoice')
    {
        $delivery = $this->Delivery_model->get_by_id($param)->row();
        $sales = $this->sales->get_detail_sales($delivery->sales_id);
        
        $data['title'] = $this->properti['name'].' | Invoice '.ucwords($this->modul['title']).' | '.$sales->code;
        
        if ($delivery){
                
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
            
            // sales details
            $data['code'] = $sales->code;

            // delivery
            $data['so'] = $sales->code;
            $data['dates'] = tglin($delivery->dates);
            $data['time'] = timein($delivery->dates);
            $data['destination'] = $delivery->destination;
            $data['courier'] = $this->courier->get_detail($delivery->courier, 'name');
            $data['distance'] = $delivery->distance;
            $data['received'] = timein($delivery->received);
            $data['confirmed'] = $delivery->confirm_customer;
            $data['amount'] = idr_format($delivery->amount);
            
             if ($type == 'invoice'){ $this->load->view('delivery_invoice', $data); }
             else{
                $html = $this->load->view('delivery_invoice', $data, true); // render the view into HTML
                return $html;
            }
        }
    }
    
    function update_process($param=null)
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'delivery_form';
        $data['form_action'] = site_url($this->title.'/update_process/'.$param); 
	$data['link'] = array('link_back' => anchor('category/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('ccourier', 'Courrier', 'required|callback_valid_delivery');
        $this->form_validation->set_rules('tcoordinate', 'Coordinate', 'required');
        $this->form_validation->set_rules('tdistance', 'Distance', 'required|numeric');
        $this->form_validation->set_rules('taddress', 'Address', 'required');
        $this->form_validation->set_rules('tamount', 'Amount', 'required|numeric');

        if ($this->form_validation->run($this) == TRUE)
        {
            $sales = $this->sales->get_by_id($this->input->post('tsid_update'))->row();
            $rate = $this->calculate_shiprate($this->input->post('tdistance'), $sales->payment_type, $sales->amount);
            
            if ($rate == 1){ $amount = 0; }else{ $amount = intval($rate*$this->input->post('tdistance')); }
            
            $delivery = array('destination' => $this->input->post('taddress'), 'courier' => $this->input->post('ccourier'),
                              'distance' => $this->input->post('tdistance'), 'coordinate' => $this->input->post('tcoordinate'),
                              'amount' => $amount, 'updated' => date('Y-m-d H:i:s'));

            $this->Delivery_model->update($this->session->userdata('langid'), $delivery);
            echo "true|One $this->title data successfully saved!|".$param;
        }
        else{ echo "error|". validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        //redirect($this->title.'/update/'.$param);
    }
    
    function confirmation($uid)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
           
        $val = $this->Delivery_model->get_by_id($uid)->row();
        $sales = $this->sales->get_detail_sales($val->sales_id);
        if ($val->status == 0){
            echo "error|Transaction not posted..!";
        }
        if ($val->received != null){
            echo 'warning|Transaction Has Been Received.';
        }
        else{ 
            $lng = array('received' => date('Y-m-d H:i:s')); 
            $this->Delivery_model->update($uid,$lng);
            echo 'true|Transaction Has Been Received at '.date('d-m-Y H:i:s');    
        }
       
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }
    
    function valid_delivery($val=null)
    {
        $res = $this->Delivery_model->get_by_id($this->session->userdata('langid'))->row();
        if ($res->status == 1)
        {
            $this->form_validation->set_message('valid_delivery','Transaction has been posted..!');
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
        $deliveryperiod = $this->input->post('deliveryperiod');  
        
        $delivery_start = picker_between_split($deliveryperiod, 0);
        $delivery_end = picker_between_split($deliveryperiod, 1);
        
        $paid = $this->input->post('cpaid');
        
        $data['delivery_start'] = tglin($delivery_start);
        $data['delivery_end'] = tglin($delivery_end);
        
        if (!$paid){ $data['paid'] = ''; }elseif ($paid == 1){ $data['paid'] = 'Paid'; }else { $data['paid'] = 'Unpaid'; }
        
//        Property Details
        $data['company'] = $this->properti['name'];
        $data['reports'] = $this->Delivery_model->report($delivery_start, $delivery_end, $paid)->result();
        
        if ($this->input->post('ctype') == 0){ $this->load->view('delivery_report', $data); }
        else { $this->load->view('delivery_pivot', $data); }
    }   

}

?>