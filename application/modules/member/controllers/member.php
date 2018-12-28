<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Member_model', '', TRUE);

        $this->properti = $this->property->get();
//        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->role = new Role_lib();
        $this->city = new City_lib();
        $this->disctrict = new District_lib();
        $this->login = new Member_login_lib();
        $this->balance = new Balance_lib();
        $this->period = new Period_lib();
        $this->period = $this->period->get();
        $this->ledger = new Wallet_ledger_lib();
        $this->notif = new Notif_lib();
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token'); 
        
    }

    private $properti, $modul, $title, $ledger, $city, $disctrict;
    private $role, $login, $balance, $period, $notif;

    function index()
    {
       $this->get_last(); 
    }
    
        // ------ json login -------------------
    function login(){
        
        $datas = (array)json_decode(file_get_contents('php://input'));
        $user = $datas['username'];
        
        $status = true;
        $error = null;
        $logid = null;
        $name = null;
        $userid = null;
        
        if ($user != null){
            
            if ($this->Member_model->cek_user_phone($user) == TRUE){
                $res = $this->Member_model->login($user);
                if ($res == FALSE){ $status = false; $error = 'Invalid Credential..!'; }
                else{

                    $sms = new Sms_lib();
                    $push = new Push_lib();
                    $logid = mt_rand(1000,9999);
                    $res = $this->Member_model->get_by_phone($user)->row(); 
                    $userid = $res->id;
                    $this->login->add($userid, $logid, $datas['device']);
                    $sms->send($user, $this->properti['name'].' : Kode OTP : '.$logid);
//                    $push->send_device($userid, $this->properti['name'].' : Kode OTP : '.$logid);
                    $name = $res->first_name;
                }
            }else{ $status = false; $error = 'Invalid Phone Number'; }
        }else{ $status = false; $error = "Wrong format..!!"; }
        
        $response = array('status' => $status, 'error' => $error, 'user' => $name, 'phone' => $user, 'userid' => $userid, 'log' => $logid); 
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }
    
    function forgot(){
        
        $datas = (array)json_decode(file_get_contents('php://input'));
        $user = $datas['username'];
        
        $status = true;
        $error = null;
        
        if ($user != null){
            
            $res = $this->Member_model->cek_user($user);
            if ($res == TRUE){ 
                $val = $this->Member_model->get_by_username($user)->row();
//                if ($this->send_confirmation_email($val->id) == TRUE){ $status = true; $error = "Password has been sent to your email."; }else{ $status = false; $error = 'Email Not Sent..!'; }
                $status = TRUE; $error = "Password has been sent to your email";
            }else{ $status = false; $error = 'Invalid Member Credential..!'; }
            
        }else{ $status = false; $error = "Wrong format..!!"; }
        
        $response = array('status' => $status, 'error' => $error, 'user' => $datas['username']); 
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }
    
    function otentikasi(){
       
        $datas = (array)json_decode(file_get_contents('php://input'));
        $user = $datas['userid'];
        $log = $datas['log'];
        
        $status = true;
        $error = null;
        
        if ( isset($datas['userid']) && isset($datas['log']) ){
           if ( $this->login->valid($user, $log) == FALSE ){ $status = false; $error = "user already login..!!"; }      
        }else{ $status = false; $error = "Wrong format..!!"; }
        
        $response = array('status' => $status, 'error' => $error); 
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }
    
    // change password
    
    function change_password(){
        
        $datas = (array)json_decode(file_get_contents('php://input'));
        $user = $datas['username'];
        $old = $datas['old_password'];
        $new = $datas['new_password'];
        
        $status = TRUE;
        $error = null;
        
        if ($user != null && $old != null && $new != null){
            
            $res = $this->Member_model->login($user,$old);
            if ($res == TRUE){ 
                
                if ($new == $old){ $status = FALSE; $error = "Password sudah pernah digunakan.";}else{
                    
                    $result = $this->Member_model->get_by_username($user)->row();
                    $member = array('password' => $new);
                    $this->Member_model->update($result->id, $member);
                    $error = 'Password Berhasil Diubah';
                }
            }else{ $status = FALSE; $error = 'Akun tidak ditemukan..!'; }
            
        }else{ $status = FALSE; $error = "Wrong format..!!"; }
        
        $response = array('status' => $status, 'error' => $error, 'user' => $datas['username']); 
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
        
    }
    
    function detail($user){
        
        $status = true;
        $error = null;
        
        if ( isset($user) ){
            
        $res = $this->Member_model->get_by_id($user)->row();
        $output = array ("id" => $res->id, "first_name" => strtoupper($res->first_name), "last_name" => $res->last_name,
                         "type" => $res->type, "email" => $res->email, "address" => $res->address, "phone" => $res->phone1);
                       
        }else{ $status = false; $error = "Wrong format..!!"; }

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($output,128))
            ->_display();
            exit; 
    }
    
    // get detail by phone
    function detail_by_phone($phone){
        
        $status = true;
        $error = null;
        $output = null;
        
        if ( isset($phone) ){
            
        $res = $this->Member_model->get_by_phone($phone)->row();
        if ($res){
            $output = array ("id" => $res->id, "first_name" => strtoupper($res->first_name), "last_name" => $res->last_name,
                         "type" => $res->type, "email" => $res->email, "address" => $res->address, "phone" => $res->phone1);
        }
                       
        }else{ $status = false; $error = "Wrong format..!!"; }

            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($output,128))
            ->_display();
            exit; 
    }
    
    function valid_member(){
        
        $datax = (array)json_decode(file_get_contents('php://input')); 
        
        if ($this->Member_model->valid_member($datax['email'], $datax['phone']) == TRUE){
            $response = array('status' => true, 'error' => null); 
        }else{ $response = array('status' => false, 'error' => 'Email atau No Telepon Tidak Valid');  }
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }
    
    function register(){
        
        $datax = (array)json_decode(file_get_contents('php://input')); 
        if ($this->Member_model->valid_member($datax['email'], $datax['phone']) == TRUE){
            
            $member = array('first_name' => strtolower($datax['name']), 
                          'phone1' => $datax['phone'],
                          'email' => $datax['email'],
                          'joined' => date('Y-m-d H:i:s'), 'status' => 1,
                          'created' => date('Y-m-d H:i:s'));

            $this->Member_model->add($member);
            $this->balance->create($this->Member_model->counter(1), $this->period->month, $this->period->year);
            
            if ($this->send_confirmation_email($this->Member_model->counter(1)) == TRUE){
                 $response = array('status' => true, 'error' => 'Registrasi Berhasil'); 
            }else{ $response = array('status' => true, 'error' => 'Gagal Mengirim Notifikasi');  }
            
        }else{
            $response = array('status' => false, 'error' => 'Registrasi Gagal, Email atau No Telepon sudah terdaftar..!'); 
        }
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }
    
    function edit_member(){
        
        $datax = (array)json_decode(file_get_contents('php://input')); 
        $status = false; $error = null; 
        
        if ($this->Member_model->validating('email', $datax['email'], $datax['id']) == FALSE ){
            $error = 'Email sudah pernah terdaftar';
        }else{  
            $member = array('first_name' => strtolower($datax['fname']), 'email' => $datax['email']);
            $status = true; $error = 'Profil Berhasil Diubah';
            $this->Member_model->update($datax['id'],$member);
        }
            
        $response = array('status' => $status, 'error' => $error); 
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
        
    }
    
    // get current balance
    function balance(){
       
        $datas = (array)json_decode(file_get_contents('php://input'));
        
        $status = true;
        $error = null;
        $balance = 0;
        
        if (isset($datas['member'])){
            
            // balance
            $balance = $this->balance->get($datas['member'], $this->period->month, $this->period->year);
            $beginning = @floatval($balance->beginning);
            $trans = $this->ledger->get_sum_transaction_monthly($datas['member'],$this->period->month, $this->period->year);
            $trans = floatval($trans['vamount']);
            $balance = $beginning+$trans;
            
        }else{ $status = false; $error = "Wrong format..!!"; }
        
        $response = array('balance' => $balance, 'status' => $status, 'error' => $error); 
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }
    
    private function send_confirmation_sms($pid){
       
        $member = $this->Member_model->get_by_id($pid)->row();
        $mess = "Selamat datang di wamenak.com ".ucfirst($member->fname)." Mohon cek email anda untuk informasi lebih lanjut. Terima Kasih.";
        return $this->sms->send($member->phone1, $mess);
    }
    
    private function send_confirmation_email($pid)
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
       
       $member = $this->Member_model->get_by_id($pid)->row();

       $data['code']    = 'CUST-0'.$member->id;
       $data['name']    = strtoupper($member->first_name.' '.$member->last_name);
       $data['type']    = strtoupper($member->type);
       $data['phone']    = $member->phone1;
       $data['email']    = $member->email;
       $data['joined']  = tglin($member->joined).' / '. timein($member->joined);
         
        // email send
       $html = $this->load->view('member_receipt',$data,true); 
       return $this->notif->create($pid, $html, 0, $this->title, 'Wamenak E-Welcome - '.strtoupper($data['code']));
    }
    

    // ========================== api ==========================================
    
    public function getdatatable($search=null,$cat='null',$publish='null')
    {
        if(!$search){ $result = $this->Member_model->get_last($this->modul['limit'])->result(); }
        else {$result = $this->Member_model->search($cat,$publish)->result(); }
	
        $output = null;
        if ($result){
                
         foreach($result as $res)
	 {   
	   $output[] = array ($res->id, $res->first_name, $res->last_name, $res->type, $res->address, $res->shipping_address, 
                              $res->phone1, $res->phone2, $res->fax, $res->email, $res->password, $res->website, $this->city->get_name($res->city),
                              $res->region, $res->zip, $res->notes, 
                              base_url().'images/member/'.$res->image, $res->status , tglin($res->joined)
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
    
    function get_list($target='titem')
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'member_list';
        $data['form_action'] = site_url($this->title.'/member_list');
        
        $member = $this->Member_model->get()->result();              
        
        $qty = 0;

        $tmpl = array('table_open' => '<table id="example" width="100%" cellspacing="0" class="table table-striped table-bordered">');

            $this->table->set_template($tmpl);
            $this->table->set_empty("&nbsp;");

            //Set heading untuk table
            $this->table->set_heading('No', 'Code', 'Name', 'Phone', 'Email', 'Joined', 'Action');

            $i = 0;
            if ($member){

                foreach ($member as $res)
                {
                   $datax = array('name' => 'button', 'type' => 'button', 'class' => 'btn btn-primary', 'content' => 'Select', 'onclick' => 'setvalue(\''.$res->id.'\',\''.$target.'\')');

                    $this->table->add_row
                    (
                        ++$i, 'CU0'.$res->id, ucfirst($res->first_name.' '.$res->last_name), $res->phone1, $res->email, tglin($res->joined),
                        form_button($datax)
                    );
                }            
            }

            $data['table'] = $this->table->generate();
            $this->load->view('member_list', $data);
    }

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Member Manager');
        $data['h2title'] = 'Member Manager';
        $data['main_view'] = 'member_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['form_action_report'] = site_url($this->title.'/report_process');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['city'] = $this->city->combo_city_db();
        $data['array'] = array('','');
        
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
        $this->table->set_heading('#','No', 'Image', 'Type', 'Name', 'Email', 'City', 'Joined', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Member_model->get_by_id($uid)->row();
       if ($val->status == 0){ $lng = array('status' => 1); }else { $lng = array('status' => 0); }
       $this->Member_model->update($uid,$lng);
       echo 'true|Status Changed...!';
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
             if ($type == 'soft') { $this->Member_model->delete($cek[$i]); }
             else { $this->remove_img($cek[$i],'force');
                    $this->attribute_member->force_delete_by_member($cek[$i]);
                    $this->Member_model->force_delete($cek[$i]);  }
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
            $this->Member_model->delete($uid);
            
            $this->session->set_flashdata('message', "1 $this->title successfully removed..!");

            echo "true|1 $this->title successfully removed..!";
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        
    }
    
    function ledger($param=0)
    {
        $data['title'] = $this->properti['name'].' | Invoice Ledger'.ucwords($this->modul['title']);
        $member = $this->Member_model->get_by_id($param)->row();
        
        if ($member){
                
            $data['company'] = $this->properti['name'];

            $data['code'] = 'CU0'.$param;
            $data['name'] = ucfirst($member->first_name.' '.$member->last_name);
            
            // balance
            $balance = $this->balance->get($param, $this->period->month, $this->period->year);
            $data['beginning'] = floatval($balance->beginning);
            $data['log'] = $this->session->userdata('log');

            // transaction table
            $data['items'] = $this->ledger->get_transaction_monthly($param, $this->period->month, $this->period->year);
            $this->load->view('member_ledger', $data);
        }
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
        $data['main_view'] = 'category_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('category/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tfname', 'SKU', 'required');
        $this->form_validation->set_rules('tlname', 'Name', 'required');
        $this->form_validation->set_rules('ctype', 'Member Type', 'required');
        $this->form_validation->set_rules('taddress', 'Address', 'required');
        $this->form_validation->set_rules('tphone1', 'Phone 1', 'required');
        $this->form_validation->set_rules('tphone2', 'Phone 2', '');
        $this->form_validation->set_rules('temail', 'Email', 'required|valid_email|callback_valid_email');
        $this->form_validation->set_rules('twebsite', 'Website', '');
        $this->form_validation->set_rules('ccity', 'City', 'required');
        $this->form_validation->set_rules('cdistrict', 'District', 'required');
        $this->form_validation->set_rules('tzip', 'Zip', '');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/member/';
            $config['file_name'] = split_space($this->input->post('tfname').'_'.waktuindo());
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = true;
            $config['max_size']	= '10000';
            $config['max_width']  = '30000';
            $config['max_height']  = '30000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);
//
            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $info['file_name'] = null;
                $data['error'] = $this->upload->display_errors();
                $member = array('first_name' => strtolower($this->input->post('tfname')), 
                                  'last_name' => strtolower($this->input->post('tlname')),
                                  'type' => $this->input->post('ctype'), 'address' => $this->input->post('taddress'),
                                  'shipping_address' => $this->input->post('taddress'), 'phone1' => $this->input->post('tphone1'), 'phone2' => $this->input->post('tphone2'),
                                  'email' => $this->input->post('temail'), 'password' => 'password', 
                                  'website' => $this->input->post('twebsite'), 'region' => $this->input->post('cdistrict'),
                                  'city' => $this->input->post('ccity'), 'state' => $this->city->get_province_based_city($this->input->post('ccity')),
                                  'zip' => $this->input->post('tzip'), 'joined' => date('Y-m-d H:i:s'),
                                  'image' => null, 'created' => date('Y-m-d H:i:s'));
            }
            else
            {
                $info = $this->upload->data();
                
                $member = array('first_name' => strtolower($this->input->post('tfname')), 
                                  'last_name' => strtolower($this->input->post('tlname')),
                                  'type' => $this->input->post('ctype'), 'address' => $this->input->post('taddress'),
                                  'shipping_address' => $this->input->post('taddress'), 'phone1' => $this->input->post('tphone1'), 'phone2' => $this->input->post('tphone2'),
                                  'email' => $this->input->post('temail'), 'password' => 'password', 
                                  'website' => $this->input->post('twebsite'), 'region' => $this->input->post('cdistrict'),
                                  'city' => $this->input->post('ccity'), 'state' => $this->city->get_province_based_city($this->input->post('ccity')),
                                  'zip' => $this->input->post('tzip'), 'joined' => date('Y-m-d H:i:s'),
                                  'image' => $info['file_name'], 'created' => date('Y-m-d H:i:s'));
            }

            $this->Member_model->add($member);
            $this->balance->create($this->Member_model->counter(1), $this->period->month, $this->period->year);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
//            redirect($this->title);
            
            if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
            else { echo 'true|'.$this->title.' successfully saved..!|'.base_url().'images/member/'.$info['file_name']; }
            
          //  echo 'true';
        }
        else{ echo "error|".validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }
    
    private function cek_tick($val)
    {
        if (!$val)
        { return 0;} else { return 1; }
    }
    
    private function split_array($val)
    { return implode(",",$val); }
   

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
        $data['main_view'] = 'member_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));
        $data['source'] = site_url($this->title.'/getdatatable');

        $data['city'] = $this->city->combo_city_db();
        $data['district'] = $this->disctrict->combo_district_db(null);
        $data['array'] = array('','');
        
        $member = $this->Member_model->get_by_id($uid)->row();
	$this->session->set_userdata('langid', $member->id);
        
        $data['default']['fname'] = $member->first_name;
        $data['default']['lname'] = $member->last_name;
        $data['default']['type'] = $member->type;
        $data['address'] = $member->address;
        $data['shipping'] = $member->shipping_address;
        $data['default']['phone1'] = $member->phone1;
        $data['default']['phone2'] = $member->phone2;
        $data['default']['email'] = $member->email;
        $data['default']['password'] = $member->password;
        $data['default']['website'] = $member->website;
        $data['default']['city'] = $member->city;
        $data['default']['district'] = $member->region;
        $data['default']['zip'] = $member->zip;
        $data['default']['image'] = base_url().'images/member/'.$member->image;

        $this->load->view('template', $data);
    }
    
    function image_gallery($pid=null)
    {        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = site_url($this->title.'/add_image/'.$pid);
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $result = $this->Member_model->get_by_id($pid)->row();
        
        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('No', 'Name', 'Image');
        
        for ($i=1; $i<=5; $i++)
        {   
            switch ($i) {
                case 1:$url = $result->url1; break;
                case 2:$url = $result->url2; break;
                case 3:$url = $result->url3; break;
                case 4:$url = $result->url4; break;
                case 5:$url = $result->url5; break;
            }
            
            if ($url){ if ($result->url_upload == 1){ $url = base_url().'images/member/'.$url; } }
            
            $image_properties = array('src' => $url, 'alt' => 'Image'.$i, 'class' => 'img_member', 'width' => '60', 'title' => 'Image'.$i,);
            $this->table->add_row
            (
               $i, 'Image'.$i, !empty($url) ? img($image_properties) : ''
            );
        }

        $data['table'] = $this->table->generate();
        
        $this->load->view('member_image', $data);
    }
    
    function valid_image($val)
    {
        if ($val == 0)
        {
            if (!$this->input->post('turl')){ $this->form_validation->set_message('valid_image','Image Url Required..!'); return FALSE; }
            else { return TRUE; }            
        }
    }
    
    function add_image($pid)
    {
        if ($this->acl->otentikasi2($this->title) == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Member Manager');
            $data['h2title'] = 'Member Manager';
            $data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

            // Form validation
            
            $this->form_validation->set_rules('cname', 'Image Attribute', 'required|');
            $this->form_validation->set_rules('userfile', 'Image Value', '');

            if ($this->form_validation->run($this) == TRUE)
            {  
                $result = $this->Member_model->get_by_id($pid)->row();
                if ($result->url_upload == 1)               
                {
                    switch ($this->input->post('cname')) {
                    case 1:$img = "./images/member/".$result->url1; break;
                    case 2:$img = "./images/member/".$result->url2; break;
                    case 3:$img = "./images/member/".$result->url3; break;
                    case 4:$img = "./images/member/".$result->url4; break;
                    case 5:$img = "./images/member/".$result->url5; break;
                  }
                  @unlink("$img"); 
                }
                
                    $config['upload_path'] = './images/member/';
                    $config['file_name'] = split_space($result->name.'_'.$this->input->post('cname'));
                    $config['allowed_types'] = 'jpg|gif|png';
                    $config['overwrite']  = true;
                    $config['max_size']   = '1000';
                    $config['max_width']  = '30000';
                    $config['max_height'] = '30000';
                    $config['remove_spaces'] = TRUE;

                    $this->load->library('upload', $config);
                    
                    if ( !$this->upload->do_upload("userfile")) // if upload failure
                    {
                        $attr = array('url'.$this->input->post('cname') => null, 'url_upload' => 1);
                    }
                    else {$info = $this->upload->data();
                         $attr = array('url'.$this->input->post('cname') => $info['file_name'], 'url_upload' => 1); 
                    } 
                
                $this->Member_model->update($pid, $attr);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
                
                echo 'true|Data successfully saved..!'; 
            }
            else
            {
    //            echo validation_errors();
                echo 'error|'.validation_errors();
            }
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function attribute($pid=null,$category=null)
    {        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = site_url($this->title.'/add_attribute/'.$pid);
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['attributes'] = $this->attribute->combo($category);  
        $result = $this->attribute_member->get_list($pid)->result();
        
        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('No','Attribute', 'Value', '#');
        
        $i = 0;
        foreach ($result as $res)
        {
            $this->table->add_row
            (
                ++$i, $this->attribute_list->get_name($res->attribute_id), $res->value,
                anchor('#','<span>delete</span>',array('class'=> 'btn btn-danger btn-sm text-danger', 'id' => $res->id, 'title' => 'delete'))
            );
        }

        $data['table'] = $this->table->generate();
        
        $this->load->view('member_attribute', $data);
    }
    
    function add_attribute($pid)
    {
        if ($this->acl->otentikasi2($this->title) == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Member Manager');
            $data['h2title'] = 'Member Manager';
            $data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

            // Form validation
            
            $this->form_validation->set_rules('cattribute', 'Attribute List', 'required|maxlength[100]|callback_valid_attribute['.$pid.']');
            $this->form_validation->set_rules('tvalue', 'Attribute Value', 'required');

            if ($this->form_validation->run($this) == TRUE)
            {  
                $attr = array('member_id' => $pid, 'attribute_id' => $this->input->post('cattribute'), 'value' => $this->input->post('tvalue'));
                $this->attribute_member->add($attr);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
                
                echo 'true|Data successfully saved..!'; 
            }
            else
            {
    //            echo validation_errors();
                echo 'error|'.validation_errors();
            }
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function valid_email($val)
    {
        if ($this->Member_model->valid('email',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_email','Email registered..!');
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validating_email($val)
    {
	$id = $this->session->userdata('langid');
	if ($this->Member_model->validating('email',$val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_email', "Email registered!");
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    // Fungsi update untuk mengupdate db
    function update_process($param=0)
    {
        if ($this->acl->otentikasi_admin($this->title) == TRUE){

        $data['title'] = $this->properti['name'].' | Memberistrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'member_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

	// Form validation

        $this->form_validation->set_rules('tfname', 'SKU', 'required');
        $this->form_validation->set_rules('tlname', 'Name', 'required');
        $this->form_validation->set_rules('ctype', 'Member Type', 'required');
        $this->form_validation->set_rules('taddress', 'Address', 'required');
        $this->form_validation->set_rules('tphone1', 'Phone 1', 'required');
        $this->form_validation->set_rules('tphone2', 'Phone 2', '');
        $this->form_validation->set_rules('temail', 'Email', 'required|valid_email|callback_validating_email');
        $this->form_validation->set_rules('twebsite', 'Website', '');
        $this->form_validation->set_rules('ccity', 'City', 'required');
        $this->form_validation->set_rules('cdistrict', 'District', 'required');
        $this->form_validation->set_rules('tzip', 'Zip', '');
        $this->form_validation->set_rules('tpass', 'Password', 'required');
            
        if ($this->form_validation->run($this) == TRUE)
        {
            // start update 1
            $config['upload_path'] = './images/member/';
            $config['file_name'] = split_space($this->input->post('tfname').'_'.waktuindo());
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = true;
            $config['max_size']	= '10000';
            $config['max_width']  = '30000';
            $config['max_height']  = '30000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $info['file_name'] = null;
                $data['error'] = $this->upload->display_errors();

                $member = array('first_name' => strtolower($this->input->post('tfname')), 
                              'last_name' => strtolower($this->input->post('tlname')), 'password' => $this->input->post('tpass'),
                              'type' => $this->input->post('ctype'), 'address' => $this->input->post('taddress'),
                              'shipping_address' => $this->input->post('tshipping'), 'phone1' => $this->input->post('tphone1'), 'phone2' => $this->input->post('tphone2'),
                              'email' => $this->input->post('temail'),
                              'website' => $this->input->post('twebsite'), 'region' => $this->input->post('cdistrict'),
                              'city' => $this->input->post('ccity'), 'state' => $this->city->get_province_based_city($this->input->post('ccity')),
                              'zip' => $this->input->post('tzip'));

            }
            else
            {
                $info = $this->upload->data();

                $member = array('first_name' => strtolower($this->input->post('tfname')), 
                              'last_name' => strtolower($this->input->post('tlname')), 'password' => $this->input->post('tpass'),
                              'type' => $this->input->post('ctype'), 'address' => $this->input->post('taddress'),
                              'shipping_address' => $this->input->post('tshipping'), 'phone1' => $this->input->post('tphone1'), 'phone2' => $this->input->post('tphone2'),
                              'email' => $this->input->post('temail'),
                              'website' => $this->input->post('twebsite'), 'region' => $this->input->post('cdistrict'),
                              'city' => $this->input->post('ccity'), 'state' => $this->city->get_province_based_city($this->input->post('ccity')),
                              'zip' => $this->input->post('tzip'), 'image' => $info['file_name']);
            }

            $this->Member_model->update($this->session->userdata('langid'), $member);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            redirect($this->title.'/update/'.$this->session->userdata('langid'));

            // end update 1
        }
        else{ $this->session->set_flashdata('message', validation_errors());
              redirect($this->title.'/update/'.$this->session->userdata('langid'));
            }
        
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function ajaxcombo_district()
    {
        $cityid = $this->input->post('value');
        if ($cityid != null){
            $district = $this->disctrict->combo_district_db($cityid);
            $js = "class='select2_single form-control' id='cdistrict' tabindex='-1' style='width:100%;' "; 
            echo form_dropdown('cdistrict', $district, isset($default['district']) ? $default['district'] : '', $js);
        }
    }
   

}

?>