<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Orders_model', '', TRUE);

        $this->properti = $this->property->get();
//        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->role = new Role_lib();
        $this->category = new News_category_lib();
        $this->language = new Language_lib();
        $this->agent = new Agent_lib();
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token'); 

    }

    private $properti, $modul, $title, $agent;
    private $role, $category, $language;

    // json format
    function get_orders(){
        
        $datas = (array)json_decode(file_get_contents('php://input'));
        $agent = $datas['agent_id'];
        
        $result = $this->Orders_model->search($agent,'null')->result();
        
        foreach ($result as $res) {
            
           if ($res->approved == 1){ $stts = 'Processed'; }else{ $stts = 'On Progress'; } 
           $output[] = array ("id" => $res->id, "code" => $res->code, "dates" => tglin($res->dates), 
                              "agent_id" => $this->agent->get_name($res->agent_id), "content" => $res->content,
                              "status" => $stts, "image" => base_url().'images/offer/'.$res->image);
        }
        
        $response['content'] = $output;
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit;    
    }
    
     function get_orders_by_id(){
        
        $datas = (array)json_decode(file_get_contents('php://input'));
        $uid = $datas['id'];
        
        $res = $this->Orders_model->get_by_id($uid)->row();
            
        if ($res->approved == 1){ $stts = 'Processed'; }else{ $stts = 'On Progress'; } 
        $output[] = array ("id" => $res->id, "code" => $res->code, "dates" => tglin($res->dates), 
                           "agent_id" => $this->agent->get_name($res->agent_id), "content" => $res->content,
                           "status" => $stts, "image" => base_url().'images/offer/'.$res->image);

        $response['content'] = $output;
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit;    
    }
    
    function add_orders(){
        
        $datax = (array)json_decode(file_get_contents('php://input')); 
        
        $orderid = $this->Orders_model->counter().mt_rand(100,9999);
        $orders = array('dates' => date('Y-m-d'), 'agent_id' => $datax['agent_id'], 'code' => $orderid,
                        'content' => $datax['content'], 'created' => date('Y-m-d H:i:s'));

        $this->Orders_model->add($orders);
        $response = array('status' => true, 'orderid' => $orderid); 
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
        
    }
    
    function remove_orders(){
        
        $datax = (array)json_decode(file_get_contents('php://input')); 
        
        $orderid = $this->Orders_model->get_by_id($datax['id'])->row();
        if ($orderid->approved == 0){
            
            $source = 'images/offer/'.$orderid->image;
            unlink($source);
            
            $this->Orders_model->force_delete($datax['id']);
            $response = array('status' => true, 'error' => 'Offer Removed..!!'); 
            
        }else{ $response = array('status' => false, 'error' => "Offer Already Posted..!!");  }

        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
        
    }
    
    function edit_image_orders(){
        
        $datax = (array)json_decode(file_get_contents('php://input')); 
        
        $orderid = $this->Orders_model->get_detail_based_order($datax['orderid']);
        $orders = array('image' => $datax['image']);

        $this->Orders_model->update($orderid->id,$orders);
        $response = array('status' => true); 
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
        
    }
    
    function index()
    {
       $this->get_last(); 
    }
     
    public function getdatatable($search=null,$agent='null',$publish='null')
    {
        if(!$search){ $result = $this->Orders_model->get_last($this->modul['limit'])->result(); }
        else {$result = $this->Orders_model->search($agent,$publish)->result(); }
	
        $output = null;
        if ($result){
                
         foreach($result as $res)
	 {             
	   $output[] = array ($res->id, $res->code, tglin($res->dates), $this->agent->get_name($res->agent_id), $res->content, base_url().'images/orders/'.$res->image,
                              $res->approved, $res->created, $res->updated, $res->deleted
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

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Article Manager');
        $data['h2title'] = 'Orders Manager';

        $data['main_view'] = 'orders_view';

	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['agent'] = $this->agent->combo_name();
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
        $this->table->set_heading('#','No', 'Code', 'Dates', 'Agent', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Orders_model->get_by_id($uid)->row();
       if ($val->approved == 0){ $lng = array('approved' => 1); }else { $lng = array('approved' => 0); }
       $this->Orders_model->update($uid,$lng);
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
             $this->Orders_model->delete($cek[$i]);
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
            $this->Orders_model->delete($uid);
            
            $this->session->set_flashdata('message', "1 $this->title successfully removed..!");

            echo "true|1 $this->title successfully removed..!";
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        
    }
    
    function add()
    {

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Create New '.$this->modul['title'];
        $data['main_view'] = 'orders_form';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['language'] = $this->language->combo();
        $data['category'] = $this->category->combo();
        $data['source'] = site_url($this->title.'/getdatatable');
        
        $this->load->helper('editor');
        editor();

        $this->load->view('template', $data);
    }

    function add_process()
    {
        if ($this->acl->otentikasi2($this->title) == TRUE){         
 
                $config['upload_path']   = './uploads/';
//                $config['upload_path']   = 'http://calculator.dswip.com/uploads/';
                $config['file_name']     = split_space($this->input->post('ttitle'));
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['overwrite']     = TRUE;
                $config['max_size']	 = '10000';
                $config['max_width']     = '10000';
                $config['max_height']    = '10000';
                $config['remove_spaces'] = TRUE;
                
                $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();
                print_r($data['error']);
            }
            else
            {
                $info = $this->upload->data();
                
                //File path at local server
                $source = 'uploads/'.$info['file_name'];
                
                                //Load codeigniter FTP class
                $this->load->library('ftp');
                
                //FTP configuration
                $ftp_config['hostname'] = 'ftp.dswip.com'; 
//                $ftp_config['hostname'] = 'ftp.103.247.11.242'; 
                $ftp_config['username'] = 'dv200135';
                $ftp_config['password'] = 'Jsu74gYStdh6';
                $ftp_config['debug']    = FALSE;
                
                //Connect to the remote server
                $this->ftp->connect($ftp_config);
                
                //File upload path of remote server
                $destination = '/calculator.dswip.com/uploads/'.$info['file_name'];
                
                 //Upload file to the remote server
                $stts = $this->ftp->upload($source, ".".$destination);
                //Close FTP connection
                $this->ftp->close();
                
                if ($stts == TRUE){ echo 'success transfer'; @unlink($source); }else{ echo 'failed transfer'; }
                
            }
            
           
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
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
        $img = $this->Orders_model->get_by_id($id)->row();
        $img = $img->icon;
        if ($img){ $img = "./images/component/".$img; unlink("$img"); }
    }
    

    function invoice($param=0,$type='invoice')
    {
        $orders = $this->Orders_model->get_by_id($param)->row();
        
        $data['title'] = $this->properti['name'].' | '.ucwords($this->modul['title']);
        
        if ($orders){
                
            // property
            $data['p_name'] = $this->properti['sitename'];
            $data['p_address'] = $this->properti['address'];
            $data['p_city'] = $this->properti['city'];
            $data['p_zip']  = $this->properti['zip'];
            $data['p_phone']  = $this->properti['phone1'];
            $data['p_email']  = $this->properti['email'];
            $data['p_logo']  = $this->properti['logo'];

            $data['code'] = $orders->code;
            $data['dates'] = tglin($orders->dates);
            $data['agent'] = $this->agent->get_name($orders->agent_id);
            $data['content'] = $orders->content;
            $data['image'] = base_url().'images/offer/'.$orders->image;
            
            if ($orders->approved == 1){ $stts = 'Processed'; }else{ $stts = 'On Progress'; }
            $data['status'] = $stts;
            
             if ($type == 'invoice'){ $this->load->view('orders_invoice', $data); }
             else{
                $html = $this->load->view('orders_invoice', $data, true); // render the view into HTML
                return $html;
             }
        }
    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['language'] = $this->language->combo();
        $data['category'] = $this->category->combo();
        $data['source'] = site_url($this->title.'/getdatatable');
        
        $article = $this->Orders_model->get_by_id($uid)->row();
	$this->session->set_userdata('langid', $article->id);
        
        $data['default']['category'] = $article->category_id;
        $data['default']['language'] = $article->lang;
        $data['default']['title'] = $article->title;
        $data['default']['date'] = $article->dates;
        $data['default']['coment'] = $article->comment;
        $data['default']['front'] = $article->front;
        $data['default']['image'] = base_url().'images/article/'.$article->image;
        $data['default']['desc'] = $article->text;
        
        echo $article->title;
        
        $this->load->helper('editor');
        editor();
        
        $this->load->view('template', $data);
    }
 
    function valid($val)
    {
        if ($this->Orders_model->valid('title',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_modul', $this->title.' registered');
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validating($val)
    {
	$id = $this->session->userdata('langid');
	if ($this->Orders_model->validating('title',$val,$id) == FALSE)
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

        $data['title'] = $this->properti['name'].' | Articleistrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'admin_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('ttitle', 'Article Title', 'required|maxlength[100]|callback_validating');
        $this->form_validation->set_rules('ccategory', 'Category', 'required');
        $this->form_validation->set_rules('clang', 'Language', 'required');
        $this->form_validation->set_rules('tdates', 'Article Dates', 'required');
        $this->form_validation->set_rules('tdesc', 'Article Content', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path']   = './images/article/';
            $config['file_name']     = split_space($this->input->post('ttitle'));
            $config['allowed_types'] = 'png|jpg';
            $config['overwrite']     = TRUE;
            $config['max_size']	 = '10000';
            $config['max_width']     = '10000';
            $config['max_height']    = '10000';
            $config['remove_spaces'] = TRUE;
            
            $this->load->library('upload', $config);
            
            if ( !$this->upload->do_upload("userfile"))
            {
                $data['error'] = $this->upload->display_errors();
                $article = array(
                'title' => $this->input->post('ttitle'), 'category_id' => $this->input->post('ccategory'),
                'permalink' => split_space($this->input->post('ttitle')),
                'lang' => $this->input->post('clang'), 'user' => $this->session->userdata('username'),
                'comment' => $this->cek_tick($this->input->post('ccoment')), 'front' => $this->cek_tick($this->input->post('cfront')),
                'dates' => setnull($this->input->post('tdates')), 'time' => waktuindo(), 'text' => $this->input->post('tdesc'),
                'created' => date('Y-m-d H:i:s'));
            }
            else
            {
                $info = $this->upload->data();
                $article = array(
                'title' => $this->input->post('ttitle'), 'category_id' => $this->input->post('ccategory'),
                'permalink' => split_space($this->input->post('tpermalink')),
                'lang' => $this->input->post('clang'), 'image' => $info['file_name'], 'user' => $this->session->userdata('username'),
                'comment' => $this->cek_tick($this->input->post('ccoment')), 'front' => $this->cek_tick($this->input->post('cfront')),
                'dates' => setnull($this->input->post('tdates')), 'time' => waktuindo(), 'text' => $this->input->post('tdesc'),
                'created' => date('Y-m-d H:i:s'));
            }

	    $this->Orders_model->update($this->session->userdata('langid'), $article);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            redirect($this->title.'/update/'.$this->session->userdata('langid'));
          //  $this->session->unset_userdata('langid');
//             if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
//             else { echo 'true|Data successfully saved..!|'.base_url().'images/component/'.$info['file_name']; }

        }
        else{ $this->load->view('template', $data); echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    // get list
    function article_list($lang=null,$category=null)
    {        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
	$data['form_action'] = site_url($this->title.'/article_list/');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['category'] = $this->category->combo_all();
        $data['language'] = $this->language->combo_all(); 
        
        $lang = $this->input->post('clang');
        $category = $this->input->post('ccategory');
        $result = $this->Orders_model->get_list($lang,$category)->result();
        
        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('No', '#', 'Category', 'Title', 'Dates', '#');
        
        $i = 0;
        foreach ($result as $res)
        {
            $this->table->add_row
            (
                ++$i, $res->lang, $this->category->get_name($res->category_id), $res->title, tglin($res->dates),
                anchor('#','<span>Select</span>',array('class'=> 'btn btn-primary btn-sm text-select', 'id' => $res->permalink, 'title' => 'Select'))
            );
        }
//
        $data['table'] = $this->table->generate();
        
        $this->load->view('article_list', $data);
    }


}

?>