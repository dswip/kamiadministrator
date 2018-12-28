<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Topup extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Topup_model', '', TRUE);

        $this->properti = $this->property->get();
//        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->role = new Role_lib();
        $this->customer = new Customer_lib();
        $this->courier = new Courier_lib();
        $this->bank = new Bank_lib();
        $this->ledger = new Wallet_ledger_lib();
        $this->cledger = new Courier_wallet_ledger_lib();
        $this->notif = new Notif_lib();
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token'); 
        
    }

    private $properti, $modul, $title;
    private $role,$customer,$courier,$bank,$ledger,$cledger,$notif;

    function index()
    {
       $this->get_last(); 
    }
    
    // ==================================== API ================================
    function add_json(){
        
        $datas = (array)json_decode(file_get_contents('php://input'));
        $status = true; $error = null;
        $uid = 0;
        
        if ($datas['type'] == '1'){
            $topup = array('customer' => $datas['customer'], 
            'dates' => date('Y-m-d H:i:s'),
            'type' => $datas['type'], 'amount' => $datas['amount'],
            'courier' => $datas['courier'], 'log' => '0',
            'created' => date('Y-m-d H:i:s'));
            
        }elseif($datas['type'] == '2'){
            $topup = array('customer' => $datas['customer'], 
            'dates' => date('Y-m-d H:i:s'),
            'type' => $datas['type'], 'amount' => $datas['amount'],
            'bank' => $datas['bank'], 'sender_name' => $datas['sender_name'], 'sender_acc' => $datas['sender_acc'], 'sender_bank' => $datas['sender_bank'],
            'log' => '0',
            'created' => date('Y-m-d H:i:s'));
        }

        $this->Topup_model->add($topup);
        $uid = $this->Topup_model->counter();
        if ($datas['type'] == '0'){ $error = "Topup berhasil : ".date('d-m-Y H:i:s'); }
        if ($datas['type'] == '1'){ $error = "Topup berhasil : ".date('d-m-Y H:i:s'); }
        if ($datas['type'] == '2'){ $error = "Topup berhasil | ".date('d-m-Y H:i:s'); }
        
        $response = array('status' => $status, 'error' => $error, 'id' => $uid); 
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }
    
    function confirmation_driver(){
        
        $datas = (array)json_decode(file_get_contents('php://input'));
        $errorlib = new Error_lib();
        
        $status = false;
        $error = null;
        
        $val = $this->Topup_model->get_by_id($datas['id'])->row();
        
        try { 
            $lng = array('status' => 1); $this->Topup_model->update($datas['id'], $lng);
            $this->ledger->add('TOP', $datas['id'], $val->dates, $val->amount, 0, $val->customer); // add ledger customer
            $this->cledger->add('TOP', $datas['id'], $val->dates, $val->amount, 0, $val->courier); // add ledger driver
            
            $sms = $this->properti['name']." : Topup berhasil senilai ".idr_format($val->amount)." pada tanggal ".tglin($val->dates).' '.timein($val->dates).". No transaksi : TOP-0".$val->id;
            $html = $this->invoice($datas['id']);
            $notifemail = $this->notif->create($val->customer, $html, 0, $this->title, 'Wamenak Topup-Receipt - '.strtoupper('TOP-0'.$val->id),0);
            $notifsms = $this->notif->create($val->customer, $sms, 1, $this->title, 'Wamenak Topup-Receipt - '.strtoupper('TOP-0'.$val->id),0);
            $notifpush = $this->notif->create($val->customer, $sms, 3, $this->title, 'Wamenak Topup-Receipt - '.strtoupper('TOP-0'.$val->id));
            
            if ($notifemail == true && $notifsms == true && $notifpush == true){ $status = true; $error = "Topup Confirmation Success...!"; }else{ $status = true; $error = "Notifications failed to send"; }
        } catch (Exception $e) { $errorlib->create($this->title, $e->getMessage()); $error = 'Error on confirmation..!'; }
        
        $response = array('status' => $status, 'error' => $error); 
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
        
    }
    
    public function get_transaction_json(){
        
        $datas = (array)json_decode(file_get_contents('php://input'));
        $customer = $datas['customer'];
        $type = null; $start = null; $end= null; $limit=25;
        if (isset($datas['type'])){ $type = $datas['type']; $limit = null; }
        if (isset($datas['start'])){ $start = $datas['start']; $limit = null; }
        if (isset($datas['end'])){ $end = $datas['end']; $limit = null; }
        
        $result = $this->Topup_model->get_json($customer,$type,$start,$end,$limit)->result();
        
        if ($result){
	foreach($result as $res)
	{ 
           if ($res->type == 1){ $courier = $this->courier->get_detail($res->courier, 'name'); }else{ $courier = ''; } 
           if ($res->type == 2){ $bank = $this->bank->get_details($res->bank, 'acc_name').' : '.$this->bank->get_details($res->bank, 'acc_no'); }else{ $bank = ''; }
	   $output[] = array ("id" => $res->id, "dates" => tglin($res->dates), "time" => timein($res->dates), "type" => $this->get_type($res->type), "courier" => $courier,
                              "bank" => $bank, "amount" => idr_format($res->amount));
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
    
    public function get_by_courier($courier,$limit=0,$start=0){
                
        $result = $this->Topup_model->get_by_courier($courier,$limit,$start)->result();
        $num = $this->Topup_model->get_by_courier($courier,$limit,$start)->num_rows();
        
        if ($result){
            foreach($result as $res)
            { 
               if ($res->redeem_date == null){ $redem = '-'; }else{ $redem = tglin($res->redeem_date).' '.timein($res->redeem_date); } 
               $output[] = array ("id" => $res->id, "code" => 'TOP-0'.$res->id, "dates" => tglin($res->dates), "time" => timein($res->dates), "customer" => $this->customer->get_name($res->customer),
                                  "amount" => idr_format($res->amount), "redeem" => $redem);
            }
        }
        
        if ($num > 0){ $response['content'] = $output; }else{ $response['content'] = 'reachedMax'; }
         $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit; 
        
    }
    
    
    // =========================================================================
     
    public function getdatatable($search=null,$cust='null',$type='null',$publish='null')
    {
        if(!$search){ $result = $this->Topup_model->get_last($this->modul['limit'])->result(); }
        else {$result = $this->Topup_model->search($cust,$type,$publish)->result(); }
	
        $output = null;
        if ($result){
                
         foreach($result as $res)
	 {   
	   $output[] = array ($res->id, 'CU0'.$res->customer.' - '.$this->customer->get_name($res->customer), tglin($res->dates).' '. timein($res->dates), $this->get_type($res->type), $this->courier->get_detail($res->courier,'name').' - '.$this->courier->get_detail($res->courier,'ic'), $res->log, 
                              idr_format($res->amount), $res->status, $res->redeem 
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
    
    private function get_type($val){
        
        $res = null;
        switch ($val) {
            case 0: $res = "Cash"; break;
            case 1: $res = "Driver"; break;
            case 2: $res = "Transfer"; break;
            default: $res = "Cash";
        }
        return $res;
    }

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Topup Manager');
        $data['h2title'] = 'Topup Manager';
        $data['main_view'] = 'topup_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['form_action_report'] = site_url($this->title.'/report_process');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['array'] = array('','');
        $data['customer'] = $this->customer->combo_complete();
        $data['bank'] = $this->bank->combo();
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
        $this->table->set_heading('#','No', 'Customer', 'Date', 'Type', 'Amount', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function invoice($pid=0){
        
        // property display
       $data['p_logo'] = $this->properti['logo'];
       $data['p_name'] = $this->properti['name'];
       $data['p_site_name'] = $this->properti['sitename'];
       $data['p_address'] = $this->properti['address'];
       $data['p_zip'] = $this->properti['zip'];
       $data['p_city'] = $this->properti['city'];
       $data['p_phone'] = $this->properti['phone1'];
       $data['p_email'] = $this->properti['email'];
       
       $trans = $this->Topup_model->get_by_id($pid)->row();
       
       $data['code'] = 'TOP-0'.$trans->id;
       $data['date'] = tglin($trans->dates);
       $data['time'] = timein($trans->dates);
       $data['type'] = $this->get_type($trans->type);
       $data['courier'] = $this->courier->get_detail($trans->courier, 'name');
       $data['amount'] = idr_format($trans->amount);
       $data['bank'] = $this->bank->get_details($trans->bank, 'acc_no').' &nbsp; <br> '.$this->bank->get_details($trans->bank, 'acc_name').'<br>'.$this->bank->get_details($trans->bank, 'acc_bank');
       
       if ($trans->type == 0){ $view = 'topup_cash'; }
       elseif ($trans->type == 1){ $view = 'topup_driver'; }
       elseif ($trans->type == 2){ $view = 'topup_transfer'; }
        
       $html = $this->load->view($view, $data, true);
       return $html;
    }

    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Topup_model->get_by_id($uid)->row();
       if ($val->status == 0){ 
           
          try { 
            $lng = array('status' => 1); $this->Topup_model->update($uid,$lng);
            $this->ledger->add('TOP', $uid, $val->dates, $val->amount, 0, $val->customer);  // tambah saldo cust
            
            $sms = $this->properti['name']." : Topup berhasil senilai ".idr_format($val->amount)." pada tanggal ".tglin($val->dates).' '.timein($val->dates).". No transaksi : TOP-0".$val->id;
            $html = $this->invoice($uid);
            $notifemail = $this->notif->create($val->customer, $html, 0, $this->title, 'Wamenak Topup-Receipt - '.strtoupper('TOP-0'.$val->id),0);
            $notifsms = $this->notif->create($val->customer, $sms, 1, $this->title, 'Wamenak Topup-Receipt - '.strtoupper('TOP-0'.$val->id),0);
            $notifpush = $this->notif->create($val->customer, $sms, 3, $this->title, 'Wamenak Topup-Receipt - '.strtoupper('TOP-0'.$val->id));
            
            if ($notifemail == true && $notifsms == true && $notifpush == true){  echo 'true|Confirmation Success...!'; }else{ echo 'warning|Notifications failed to send'; }
          } catch (Exception $e) { echo 'error|'.$e->getMessage(); }
           
       }
       else{ echo 'warning|Transaction Already Posted...!'; }
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }
    
    function redeem($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
          
        $val = $this->Topup_model->get_by_id($uid)->row();   
        if ($val->status == 1){
            
            if ($val->redeem == 0){ 
                $lng = array('redeem' => 1, 'redeem_date' => date('Y-m-d H:i:s')); $this->Topup_model->update($uid,$lng);
                $this->cledger->add('RTOP', $uid, date('Y-m-d H:i:s'), 0, $val->amount, $val->courier); // redeem courier
                echo 'true|Status Changed...!'; 
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
             if ($type == 'soft') { $this->Topup_model->delete($cek[$i]); }
             else { $this->remove_img($cek[$i],'force');
                    $this->attribute_topup->force_delete_by_topup($cek[$i]);
                    $this->Topup_model->force_delete($cek[$i]);  }
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
            
            $val = $this->Topup_model->get_by_id($uid)->row();
            if ($val->status == 1){
                $lng = array('status' => 0, 'redeem' => 0, 'redeem_date' => null); $this->Topup_model->update($uid,$lng); 
                $this->ledger->remove($val->dates, 'TOP', $uid);
                $this->cledger->remove($val->dates, 'TOP', $uid); // remove ledger courier
                $this->cledger->remove_redeem('RTOP', $uid); // remove reddem ledger courier
                
                echo 'true|Transaction Rollbacked...!';
            }
            else{
                $this->Topup_model->delete($uid);
                $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
                echo "true|1 $this->title successfully removed..!";
            }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        
    }
    
    function add()
    {

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Create New '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['language'] = $this->language->combo();
        $data['category'] = $this->category->combo();
        $data['currency'] = $this->currency->combo();
        $data['source'] = site_url($this->title.'/getdatatable');
        
        $this->load->helper('editor');
        editor();

        $this->load->view('template', $data);
    }

    function add_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];

	// Form validation
        $this->form_validation->set_rules('tcust', 'Customer', 'required');
        $this->form_validation->set_rules('tdates', 'Transaction Date', 'required');
        $this->form_validation->set_rules('ctype', 'Transaction Type', 'required');
        $this->form_validation->set_rules('tamount', 'Amount', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            if ($this->input->post('ctype') == 0){ $bank = 0; }else{ $bank = $this->input->post('cbank'); }
            $topup = array('customer' => $this->input->post('tcust'), 
                 'dates' => strtolower($this->input->post('tdates')),
                 'type' => $this->input->post('ctype'), 'amount' => $this->input->post('tamount'),
                 'bank' => $bank, 'log' => $this->session->userdata('log'),
                 'created' => date('Y-m-d H:i:s'));

            $this->Topup_model->add($topup);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
            echo "true|Transaction has been created..";
        }
        else{ echo "error|".validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }
    
    private function cek_tick($val)
    {
        if (!$val)
        { return 0;} else { return 1; }
    }
    
    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $topup = $this->Topup_model->get_by_id($uid)->row_array();
	$this->session->set_userdata('langid', $topup['id']);
        echo implode('|', $topup);
    }
    
    // Fungsi update untuk mengupdate db
    function update_process()
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){

	// Form validation            
        $this->form_validation->set_rules('tcust', 'Customer', 'required|callback_valid_status');
        $this->form_validation->set_rules('tdates', 'Transaction Date', 'required');
        $this->form_validation->set_rules('ctype', 'Transaction Type', 'required');
        $this->form_validation->set_rules('tamount', 'Amount', 'required');
        
        if ($this->form_validation->run($this) == TRUE)
        {
            if ($this->input->post('ctype') == 0){ $bank = 0; }else{ $bank = $this->input->post('cbank'); }
            $topup = array('customer' => $this->input->post('tcust'), 
                 'dates' => strtolower($this->input->post('tdates')),
                 'type' => $this->input->post('ctype'), 'amount' => $this->input->post('tamount'),
                 'bank' => $bank, 'log' => $this->session->userdata('log'),
                 'created' => date('Y-m-d H:i:s'));
            
            
            $this->Topup_model->update($this->session->userdata('langid'), $topup);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            echo 'true|Data successfully saved..!';
        }
        else{ echo 'error|'.validation_errors();}
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    public function valid_status($val)
    {
        $value = $this->Topup_model->get_by_id($this->session->userdata('langid'))->row();
        if ($value->status == 1)
        {
            $this->form_validation->set_message('valid_status', "This $this->title is already posted.!");
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
        
//        Property Details
        $data['company'] = $this->properti['name'];
        $data['reports'] = $this->Topup_model->report($start,$end, $this->input->post('ctranstype'))->result();
        
        if ($this->input->post('crtype') == 0){ $this->load->view('topup_report', $data); }
        else { $this->load->view('topup_pivot', $data); }
    }   

}

?>