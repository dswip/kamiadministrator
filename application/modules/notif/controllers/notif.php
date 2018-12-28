<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notif extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Notif_model', '', TRUE);

        $this->properti = $this->property->get();
//        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->role = new Role_lib();
        $this->customer = new Customer_lib();
        $this->notif = new Notif_lib;
        $this->email = new Send_email();
        $this->sms = new Sms_lib();
        $this->push = new Push_lib();
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token'); 
        
    }

    private $properti, $modul, $title;
    private $role,$customer,$notif,$email,$sms,$push;

    function index()
    {
       $this->get_last(); 
    }
    
    public function get_notif($customer){
        
        $result = $this->Notif_model->get_publish($customer)->result();
        
        if ($result){
	foreach($result as $res)
	{
	   $output[] = array ("id" => $res->id, "subject" => $res->subject, "content" => $res->content, "reading" => $res->reading, "created" => tglincomplete($res->created).' '. timein($res->created));
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
    
    public function detail($uid){
        
        $result = $this->Notif_model->get_by_id($uid)->row();
        if ($result){
	
        $output = array ("id" => $result->id, "subject" => $result->subject, "content" => $result->content, "reading" => $result->reading, "created" => tglincomplete($result->created).' '. timein($result->created));    
            
        $notif = array('reading' => 1);
        $this->Notif_model->update($uid, $notif);
        
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($output,128))
            ->_display();
            exit; 
        }
    }
    
    public function remove($customer){
        
        $notif = array('publish' => 0);
        $this->Notif_model->update_notif($customer,$notif);
        $response = array('status' => true); 
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }
    
    public function remove_id($uid){
        
        $notif = array('publish' => 0);
        $this->Notif_model->update_notif_id($uid,$notif);
        $response = array('status' => true); 
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }
     
    public function getdatatable($search=null,$customer='null',$type='null',$modul='null',$publish='null')
    {
        if(!$search){ $result = $this->Notif_model->get_last($this->modul['limit'])->result(); }
        else {$result = $this->Notif_model->search($customer,$type,$modul,$publish)->result(); }
	
        $output = null;
        if ($result){
                
         foreach($result as $res)
	 {   
	   $output[] = array ($res->id, $this->customer->get_name($res->customer), $res->content, $this->notif->get_type($res->type), $res->reading, $res->status, tglin($res->created), tglin($res->deleted), $res->modul, $res->subject);
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

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Notif Manager');
        $data['h2title'] = 'Notif Manager';
        $data['main_view'] = 'notif_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['form_action_report'] = site_url($this->title.'/report_process');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['array'] = array('','');
        $data['modul'] = $this->notif->combo();
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
        $this->table->set_heading('#','No', 'Customer', 'Type', 'Read', 'Created', 'Subject', 'Modul', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
           
       $val = $this->Notif_model->get_by_id($uid)->row();
       if ($val->status != 1){
            if ($val->status == 0){ $lng = array('status' => 1); }
            
            if ($this->send_notif($uid) == true){
                $this->Notif_model->update($uid,$lng);
                echo 'true|Status Changed...!';
            }else{ echo "error|Failed To Send Notification..!"; }
            
       }else{ echo 'warning|Transaction Posted...!'; }  
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }
    
    private function send_notif($uid){
       
        $val = $this->Notif_model->get_by_id($uid)->row();
        
        $res = false;
        
        if ($val->type == 0){
          $res = $this->email->send(strtolower($this->customer->get_detail($val->customer, 'email')), "Support-Email", $val->content);    
        }elseif ($val->type == 1){
          $res = $this->sms->send($this->customer->get_detail($val->customer, 'phone1'), $val->content);  
        }elseif ($val->type == 2){
          $res1 = $this->email->send(strtolower($this->customer->get_detail($val->customer, 'email')), "Support-Email", $val->content);    
          $res2 = $this->sms->send($this->customer->get_detail($val->customer, 'phone1'), $val->content);  
          if ($res1 == true && $res2 == true){ $res = true; }
        }
        elseif ($val->type == 3){
          $res = $this->push->send_device($val->customer, $val->content);    
        }elseif ($val->type == 4){
          $res1 = $this->push->send_device($val->customer, $val->content);    
          $res2 = $this->sms->send($this->customer->get_detail($val->customer, 'phone1'), $val->content);  
          if ($res1 == true && $res2 == true){ $res = true; }
        }elseif ($val->type == 5){
          $res1 = $this->push->send_device($val->customer, $val->content);    
          $res2 = $this->email->send(strtolower($this->customer->get_detail($val->customer, 'email')), "Support-Email", $val->content);    
          if ($res1 == true && $res2 == true){ $res = true; }
        }elseif ($val->type == 6){
          $res1 = $this->push->send_device($val->customer, $val->content);    
          $res2 = $this->email->send(strtolower($this->customer->get_detail($val->customer, 'email')), "Support-Email", $val->content);    
          $res3 = $this->sms->send($this->customer->get_detail($val->customer, 'phone1'), $val->content);  
          if ($res1 == true && $res2 == true && $res3 == true){ $res = true; }
        }
        return $res;
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
             if ($type == 'soft') { $this->Notif_model->delete($cek[$i]); }
             else { $this->remove_img($cek[$i],'force');
                    $this->attribute_notif->force_delete_by_notif($cek[$i]);
                    $this->Notif_model->force_delete($cek[$i]);  }
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
            $val = $this->Notif_model->get_by_id($uid)->row();
            if ($val->status == 1){
               $lng = array('status' => 0);
               $this->Notif_model->update($uid,$lng);
               echo "true|1 $this->title successfully rollback..!";
            }else{ $this->Notif_model->delete($uid); echo "true|1 $this->title successfully removed..!"; }
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

	// Form validation
        $this->form_validation->set_rules('tcust', 'Customer', 'required');
        $this->form_validation->set_rules('ctype', 'Notif Type', 'required');
        $this->form_validation->set_rules('tsubject', 'Subject', 'required');
        $this->form_validation->set_rules('tcontent', 'Notif Content', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $notif = array('customer' => strtolower($this->input->post('tcust')), 
                           'subject' => strtolower($this->input->post('tsubject')),
                           'content' => strtolower($this->input->post('tcontent')),
                           'type' => $this->input->post('ctype'), 'created' => date('Y-m-d H:i:s'));
            
            $this->Notif_model->add($notif);
            echo 'true|'.$this->title.' successfully saved..!|';
        }
        else{ echo "error|".validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $notif = $this->Notif_model->get_by_id($uid)->row();
	$this->session->set_userdata('langid', $notif->id);
        echo $notif->id.'|'.$notif->customer.'|'.$notif->content.'|'.$notif->type.'|'.$notif->reading.'|'.$this->customer->get_name($notif->customer).'|'.$notif->subject;
    }
    
    // Fungsi update untuk mengupdate db
    function update_process($param=0)
    {
        if ($this->acl->otentikasi_admin($this->title) == TRUE){

        $data['title'] = $this->properti['name'].' | Notifistrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'notif_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

	// Form validation            
        $this->form_validation->set_rules('tcust', 'Customer', 'required|callback_valid_status');
        $this->form_validation->set_rules('ctype', 'Notif Type', 'required');
        $this->form_validation->set_rules('tsubject', 'Subject', 'required');
        $this->form_validation->set_rules('tcontent', 'Notif Content', 'required');
        
        if ($this->form_validation->run($this) == TRUE)
        {
             $notif = array('customer' => strtolower($this->input->post('tcust')), 
                            'subject' => strtolower($this->input->post('tsubject')),
                            'content' => strtolower($this->input->post('tcontent')),
                            'type' => $this->input->post('ctype'));
            
            $this->Notif_model->update($this->session->userdata('langid'), $notif);
            echo 'true|'.$this->title.' successfully updated..!|';
        }
        else{ echo 'error|'.validation_errors(); }
        
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function valid_status()
    {
        $res = $this->Notif_model->get_by_id($this->session->userdata('langid'))->row();
        if ($res->status == 1)
        {
            $this->form_validation->set_message('valid_status','Transaction has been posted..!');
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

//        Property Details
        $data['company'] = $this->properti['name'];
        $data['reports'] = $this->Notif_model->report($this->input->post('tcust'),$this->input->post('cnotiftype'))->result();
        
        if ($this->input->post('ctype') == 0){ $this->load->view('notif_report', $data); }
        else { $this->load->view('notif_pivot', $data); }
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