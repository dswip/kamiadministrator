<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Article extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Article_model', '', TRUE);

        $this->properti = $this->property->get();
//        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->role = new Role_lib();
        $this->category = new News_category_lib();
        $this->language = new Language_lib();
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token'); 

    }

    private $properti, $modul, $title;
    private $role, $category, $language;

    // json format
    function get_article(){
        
        $datas = (array)json_decode(file_get_contents('php://input'));
        $uid = $datas['id'];
        
        $res = $this->Article_model->get_by_id($uid)->row();
        
	$output[] = array ("id" => $res->id, "lang" => $res->lang, "permalink" => $res->permalink, "title" => $res->title, 
                           "text" => $res->text, "dates" => $res->dates, "time" => $res->time,
                           "image" => base_url().'images/article/'.$res->image);
        
        $response['content'] = $output;
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit;    
    }
    
    function index()
    {
       $this->get_last(); 
    }
     
    public function getdatatable($search=null,$cat='null',$lang='null',$publish='null',$dates='null')
    {
        if(!$search){ $result = $this->Article_model->get_last($this->modul['limit'])->result(); }
        else {$result = $this->Article_model->search($cat,$lang,$publish,$dates)->result(); }
	
        $output = null;
        if ($result){
                
         foreach($result as $res)
	 {             
	   $output[] = array ($res->id, $this->category->get_name($res->category_id), $res->user, $res->lang, $res->permalink, $res->title,
                              $res->text, $res->image, tglin($res->dates), $res->time, $res->counter, $res->comment, status($res->front), $res->publish,
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

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Article Manager');
        $data['h2title'] = 'Article Manager';

        $data['main_view'] = 'article_view';

	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['category'] = $this->category->combo_all();
        $data['language'] = $this->language->combo_all();
        
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
        $this->table->set_heading('#','No', 'Category', '#', 'Title', 'Date', 'Time', 'User', 'Front', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Article_model->get_by_id($uid)->row();
       if ($val->publish == 0){ $lng = array('publish' => 1); }else { $lng = array('publish' => 0); }
       $this->Article_model->update($uid,$lng);
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
             $this->Article_model->delete($cek[$i]);
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
            $this->Article_model->delete($uid);
            
            $this->session->set_flashdata('message', "1 $this->title successfully removed..!");

            echo "true|1 $this->title successfully removed..!";
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
        $data['source'] = site_url($this->title.'/getdatatable');
        
        $this->load->helper('editor');
        editor();

        $this->load->view('template', $data);
    }

    function add_process()
    {
        if ($this->acl->otentikasi2($this->title) == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Article Manager');
            $data['h2title'] = 'Article Manager';
            $data['main_view'] = 'article_form';
            $data['form_action'] = site_url($this->title.'/add_process');
            $data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

            // Form validation
            
            $this->form_validation->set_rules('ttitle', 'Article Title', 'required|maxlength[100]|callback_valid');
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

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();
                
                $article = array(
                'title' => $this->input->post('ttitle'), 'category_id' => $this->input->post('ccategory'),
                'permalink' => split_space($this->input->post('ttitle')),
                'lang' => $this->input->post('clang'), 'image' => null, 'user' => $this->session->userdata('username'),
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

                $this->Article_model->add($article);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
//                if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
//                else { echo 'true|Data successfully saved..!|'.base_url().'images/article/'.$info['file_name']; }
                
                redirect($this->title.'/add/');
            }
            else
            {
                $this->load->view('template', $data);
    //            echo validation_errors();
                //echo 'error|'.validation_errors();
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
        $img = $this->Article_model->get_by_id($id)->row();
        $img = $img->icon;
        if ($img){ $img = "./images/component/".$img; unlink("$img"); }
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
        
        $article = $this->Article_model->get_by_id($uid)->row();
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
        if ($this->Article_model->valid('title',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_modul', $this->title.' registered');
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validating($val)
    {
	$id = $this->session->userdata('langid');
	if ($this->Article_model->validating('title',$val,$id) == FALSE)
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

	    $this->Article_model->update($this->session->userdata('langid'), $article);
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
        $result = $this->Article_model->get_list($lang,$category)->result();
        
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