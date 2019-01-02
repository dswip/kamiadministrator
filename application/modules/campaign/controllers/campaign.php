<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Campaign extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Campaign_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->role = new Role_lib();
        $this->language = new Language_lib();
        $this->customer = new Customer_lib();
        $this->sms = new Sms_lib();
        $this->push = new Push_lib();
        $this->email = new Send_email();
    }

    private $properti, $modul, $title, $sms, $push;
    private $role, $category, $language, $customer,$email;

    function index()
    {
       $this->get_last(); 
    }
     
    public function getdatatable($search=null,$type='null',$publish='null')
    {
        if(!$search){ $result = $this->Campaign_model->get_last($this->modul['limit'])->result(); }
        else {$result = $this->Campaign_model->search($type,$publish)->result(); }
	
        $output = null;
        if ($result){
                
         foreach($result as $res)
	 {             
	   $output[] = array ($res->id, $res->email_to, $res->type, $res->category, $res->subject, 
                              $res->content, tglin($res->dates), $res->publish,
                              $res->created, $res->updated, $res->deleted
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
    
     
    function add()
    {

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Create New '.$this->modul['title'];
        $data['main_view'] = 'campaign_form';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['language'] = $this->language->combo_all();
        $data['email'] = $this->property->combo_email();
        $data['email_all'] = $this->property->combo_email('param');
        $data['source'] = site_url($this->title.'/getdatatable');
        $data['category'] = $this->Campaign_model->combo();
        
        $this->load->helper('editor');
        editor();

        $this->load->view('template', $data);
    }  
      
    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Campaign Manager');
        $data['h2title'] = 'Campaign Manager';
        $data['main_view'] = 'campaign_view';

	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_confirmation'] = site_url($this->title.'/confirmation_process');
        $data['form_action_report'] = site_url($this->title.'/report_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['language'] = $this->language->combo_all();
        $data['email'] = $this->property->combo_email();
        $data['email_all'] = $this->property->combo_email('param');
        
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
        $this->table->set_heading('#','No', 'Target', 'Category', 'Date', 'Type', 'Subject', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Campaign_model->get_by_id($uid)->row();
       if ($val->publish == 0){ $lng = array('publish' => 1); }else { $lng = array('publish' => 0); }
       $this->Campaign_model->update($uid,$lng);
       echo 'true|Status Changed...!';
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }
    
    function delete_all()
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
             $this->Campaign_model->delete($cek[$i]);
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
            $this->Campaign_model->delete($uid);
            
            $this->session->set_flashdata('message', "1 $this->title successfully removed..!");

            echo "true|1 $this->title successfully removed..!";
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        
    }

    function add_process()
    {
        if ($this->acl->otentikasi2($this->title) == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Campaign Manager');
            $data['h2title'] = 'Campaign Manager';
            $data['form_action'] = site_url($this->title.'/add_process');
            $data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

            // Form validation
            $this->form_validation->set_rules('ctocustomer', 'Customer Recipient', 'callback_valid_recipient['.$this->input->post('ctocourier').']');
            $this->form_validation->set_rules('ctodriver', 'Driver Recipient', '');
            $this->form_validation->set_rules('ccategory', 'Article Category', 'callback_valid_category['.$this->input->post('tcategory').']');
            $this->form_validation->set_rules('tdesc', 'Article Content', '');
            $this->form_validation->set_rules('ttitle', 'Subject', 'required');

            if ($this->form_validation->run($this) == TRUE)
            {  
                if ($this->input->post('ctocustomer') != "" && $this->input->post('ctodriver') != ""){ 
                    $reicipt = $this->input->post('ctocustomer').','.$this->input->post('ctodriver');
                }elseif ( $this->input->post('ctocustomer') != "" && $this->input->post('ctodriver') == "" ){
                    $reicipt = $this->input->post('ctocustomer');
                }elseif ( $this->input->post('ctodriver') == "" ){ $reicipt = $this->input->post('ctodriver'); }
                if ($this->input->post('tcategory') != ""){ $category = $this->input->post('tcategory'); }else{
                    $category = $this->input->post('ccategory');
                }
                
                if ($this->input->post('ctype') == 'sms' || $this->input->post('ctype') == 'notif'){ $content = $this->input->post('tdesc'); }else{ $content = $this->input->post('tdescemail'); }
                
                $campaign = array(
                'email_to' => $reicipt,
                'type' => $this->input->post('ctype'),
                'subject' => $this->input->post('ttitle'),
                'category' => $category,
                'content' => $content,
                'dates' => $this->input->post('tdates'), 
                'created' => date('Y-m-d H:i:s'));

                $this->Campaign_model->add($campaign);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
//                echo 'true|Data successfully saved..!|';
            }
            else{  $this->session->set_flashdata('message', validation_errors()); }
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        redirect($this->title.'/add/');
    }
    
    private function cek_tick($val)
    {
        if (!$val)
        { return 0;} else { return 1; }
    }
    
    private function split_array($val)
    { return implode(",",$val); }
    
    function remove_img($id)
    {
        $img = $this->Campaign_model->get_by_id($id)->row();
        $img = $img->icon;
        if ($img){ $img = "./images/component/".$img; unlink("$img"); }
    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
        $data['main_view'] = 'campaign_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['language'] = $this->language->combo_all();
        $data['email'] = $this->property->combo_email();
        $data['email_all'] = $this->property->combo_email('param');
        $data['source'] = site_url($this->title.'/getdatatable');
        $data['category'] = $this->Campaign_model->combo();
        
        $campaign = $this->Campaign_model->get_by_id($uid)->row();
	$this->session->set_userdata('langid', $campaign->id);
        
        $data['default']['title'] = $campaign->subject;
        $data['default']['date'] = $campaign->dates;
        $data['default']['type'] = $campaign->type;
        $data['default']['category'] = $campaign->category;
        
        $val1=''; $val2='';
        $to = explode(',', $campaign->email_to);
        if ($to[0] == 'courier'){ $val1 = 'checked'; }elseif($to[0] == 'customer'){ $val2 = 'checked'; }
        if (isset($to[1]) && $to[1] == 'customer'){ $val2 = 'checked'; }elseif(isset($to[1]) && $to[1] == 'courier'){ $val1 = 'checked'; }
        
        $data['default']['courier'] = $val1;
        $data['default']['customer'] = $val2;
        $data['default']['desc'] = $campaign->content;
        
        $this->load->helper('editor');
        editor();
        
        $this->load->view('template', $data);
    }
    
    function valid_recipient($tocusomer,$toagent)
    {
        if ( $tocusomer == "" && $toagent == "" )
        {
            $this->form_validation->set_message('valid_recipient', 'Recipient required..!!');
            return FALSE;
        }
        else{ return TRUE;  }
    }
    
    function valid_category($ccat,$tcat)
    {
        if ( $ccat == "" && $tcat == "" )
        {
            $this->form_validation->set_message('valid_category', 'Category required..!!');
            return FALSE;
        }
        else{ return TRUE;  }
    }
 
    function valid($val)
    {
        if ($this->Campaign_model->valid('title',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_modul', $this->title.' registered');
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validating($val)
    {
	$id = $this->session->userdata('langid');
	if ($this->Campaign_model->validating('title',$val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_modul', "This $this->title name is already registered!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    // Fungsi update untuk mengupdate db
    function update_process()
    {
        if ($this->acl->otentikasi_admin($this->title) == TRUE){

        $data['title'] = $this->properti['name'].' | Campaignistrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'admin_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('ctocustomer', 'Customer Recipient', 'callback_valid_recipient['.$this->input->post('ctodriver').']');
        $this->form_validation->set_rules('ctodriver', 'Courier Recipient', '');
        $this->form_validation->set_rules('ccategory', 'Article Category', 'callback_valid_category['.$this->input->post('tcategory').']');
        $this->form_validation->set_rules('tdesc', 'Article Content', '');
        $this->form_validation->set_rules('ttitle', 'Subject', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            if ($this->input->post('ctocustomer') != "" && $this->input->post('ctodriver') != ""){ 
                $reicipt = $this->input->post('ctocustomer').','.$this->input->post('ctodriver');
            }elseif ( $this->input->post('ctocustomer') != "" && $this->input->post('ctodriver') == "" ){
                $reicipt = $this->input->post('ctocustomer');
            }elseif ( $this->input->post('ctodriver') != "" && $this->input->post('ctocustomer') == "" ){ $reicipt = $this->input->post('ctodriver'); }

            if ($this->input->post('tcategory') != ""){ $category = $this->input->post('tcategory'); }else{
                $category = $this->input->post('ccategory');
            }
                
            if ($this->input->post('ctype') == 'sms' || $this->input->post('ctype') == 'notif'){ $content = $this->input->post('tdesc'); }else{ $content = $this->input->post('tdescemail'); }
            
            $campaign = array(
                'email_to' => $reicipt,
                'type' => $this->input->post('ctype'),
                'subject' => $this->input->post('ttitle'),
                'category' => $category,
                'content' => $content,
                'dates' => $this->input->post('tdates'));
            
	    $this->Campaign_model->update($this->session->userdata('langid'), $campaign);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            

        }
        else{ $this->session->set_flashdata('message', validation_errors()); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        redirect($this->title.'/update/'.$this->session->userdata('langid'));
        $this->session->unset_userdata('langid');
    }
    
    function confirmation($uid)
    {
       if ($this->acl->otentikasi_admin($this->title) == TRUE){
           
            $stts = true;
            $campaign = $this->Campaign_model->get_by_id($uid)->row();
            
            if ($campaign->publish == 1){
               $value = array('publish' => 0);
            }else{
               $value = array('dates' => date('Y-m-d'), 'publish' => 1); 
               
               // sending campaign 
               if ($campaign->type == 'email'){ $stts = $this->mail_campaign($uid); }
               elseif ($campaign->type == 'sms'){ $stts = $this->mail_sms($uid); }
               elseif ($campaign->type == 'notif'){ $stts = $this->mail_notif($uid); }
            }
            
            if ($stts == true){
              $this->Campaign_model->update($uid, $value);
              $this->session->set_flashdata('message', "One $this->title has successfully updated!");
              
              echo 'true|Data Successfully Saved..!'; 
            }else { echo 'error|Sent Email Failed...!!'; }
	    
        }
        else{ echo 'error|'.validation_errors(); }
    }
    
    private function get_customer_type($val,$type='email')
    {
       $hasil = array();
       $i=0;
       if ($val == 'customer'){ 
           
           if ($type == 'notif'){
               $result = $this->customer->get_active_device()->result(); 
           }else{
                $result = $this->customer->get_cust_type('customer');     
           }
           
           foreach ($result as $res) {
              if ($type == 'email'){ $hasil[$i] = $res->email;  }
              elseif ($type == 'sms'){ $hasil[$i] = $res->phone1; } 
              elseif ($type == 'notif'){ $hasil[$i] = $res->device; }
              $i++;   
           } 
       }
//       elseif ($val == 'courier'){ $result = $this->agent->get_agent_type(); 
//           foreach ($result as $res) {
//              if ($type == 'email'){ $hasil[$i] = $res->email;  }else{ $hasil[$i] = $res->phone1; } $i++; 
//           } 
//       }
       return $hasil;
    }
    
    private function mail_notif($pid)
    {   
        // property display
       $data['p_logo'] = $this->properti['logo'];
       $data['p_name'] = $this->properti['name'];
       $data['p_site_name'] = $this->properti['sitename'];
       $data['p_email'] = $this->properti['email'];

       $campaign = $this->Campaign_model->get_by_id($pid)->row();
       $res = explode(',', $campaign->email_to);
       $val1 = array(); $val2 = array();
       
       if (count($res) == 1){ $val1 = $this->get_customer_type($res[0],'notif'); }
       else if (count($res) == 2){ $val1 = $this->get_customer_type($res[0],'notif'); $val2 = $this->get_customer_type($res[1],'notif'); }
       
       $to = array_merge($val1,$val2);
//       print_r(array_values($to));
        
       return $this->push->send_multiple_device($to, $campaign->content);  
    }
    
    private function mail_sms($pid)
    {   
        // property display
       $data['p_logo'] = $this->properti['logo'];
       $data['p_name'] = $this->properti['name'];
       $data['p_site_name'] = $this->properti['sitename'];
       $data['p_email'] = $this->properti['email'];

       $campaign = $this->Campaign_model->get_by_id($pid)->row();
       $res = explode(',', $campaign->email_to);
       $val1 = array(); $val2 = array();
       
       if (count($res) == 1){ $val1 = $this->get_customer_type($res[0],'sms'); }
       else if (count($res) == 2){ $val1 = $this->get_customer_type($res[0],'sms'); $val2 = $this->get_customer_type($res[1],'sms'); }
       
       $to = array_merge($val1,$val2);
//       print_r(array_values($to));
        
       for ($i=0; $i<count($to); $i++){
         $this->sms->send($to[$i], $campaign->content); 
       }
      return true; 
//        if ($this->sms->send($to, $campaign->content) == true ){ return true; }else{ return false;  }
    }
    
    private function mail_campaign($pid)
    {   
        // property display
       $data['p_logo'] = $this->properti['logo'];
       $data['p_name'] = $this->properti['name'];
       $data['p_site_name'] = $this->properti['sitename'];
       $data['p_email'] = $this->properti['email'];

       $campaign = $this->Campaign_model->get_by_id($pid)->row();
       $res = explode(',', $campaign->email_to);
       
       $val1 = array(); $val2 = array();
       
       if (count($res) == 1){ $val1 = $this->get_customer_type($res[0]); }
       else if (count($res) == 2){ $val1 = $this->get_customer_type($res[0]); $val2 = $this->get_customer_type($res[1]); }
       
       $to = array_merge($val1,$val2);
       
       $data['from'] = $data['p_email'];
       $data['to'] = $campaign->email_to;
       $data['type'] = $campaign->type;
       $data['category'] = $campaign->category;
       $data['article'] = $campaign->subject;
       $data['dates'] = tglin($campaign->dates).' - '. timein($campaign->dates);
       $data['content'] = $campaign->content;
       $html = $this->load->view('campaign_invoice_email',$data,true);
        
        // email send
        return $this->email->send_many($to, $campaign->subject, $html);
    }
    
    function report_process()
    {
        $this->acl->otentikasi2($this->title);
        $data['title'] = $this->properti['name'].' | Report '.ucwords($this->modul['title']);

        $data['rundate'] = tglin(date('Y-m-d'));
        $data['log'] = $this->session->userdata('log');
        $period = $this->input->post('campaignperiod');  
        
        $start = picker_between_split($period, 0);
        $end = picker_between_split($period, 1);
        
        $from = $this->input->post('cfrom');
        $type = $this->input->post('rtype');
        $category = $this->input->post('ccategory');

        $data['start'] = tglin($start);
        $data['end'] = tglin($end);
        
//        Property Details
        $data['company'] = $this->properti['name'];
        $data['reports'] = $this->Campaign_model->report($start, $end, $from, $type, $category)->result();
        
        $this->load->view('campaign_report', $data);
    } 
    
            // Fungsi update untuk menset texfield dengan nilai dari database
    function receipt($param=0,$type='invoice')
    {
        $campaign = $this->Campaign_model->get_by_id($param)->row();
        
        $data['title'] = $this->properti['name'].' | Invoice '.ucwords($this->modul['title']).' | CMP-0'.$campaign->id;
        
        if ($campaign){
                
            // property
            $data['p_name'] = $this->properti['sitename'];
            $data['p_address'] = $this->properti['address'];
            $data['p_city'] = $this->properti['city'];
            $data['p_zip']  = $this->properti['zip'];
            $data['p_phone']  = $this->properti['phone1'];
            $data['p_email']  = $this->properti['email'];
            $data['p_logo']  = $this->properti['logo'];

            // campaign details
            $data['from'] = $campaign->email_from;
            $data['to'] = $campaign->email_to;
            $data['type'] = $campaign->type;
            $data['category'] = $campaign->category;
            $data['subject'] = $campaign->subject;
            $data['content'] = $campaign->content;
            $data['dates'] = tglin($campaign->dates).' - '. timein($campaign->dates);

            $this->load->view('campaign_invoice', $data);
        }
    }

}

?>