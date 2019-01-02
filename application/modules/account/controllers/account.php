<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Account_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->account = new Account_lib();
    }

    private $properti, $modul, $title, $account;

    function index()
    {
       $this->get_last(); 
    }
    
    public function getdatatable($search=null,$category='null',$parent='null')
    {
        if(!$search){ $result = $this->Account_model->get_last($this->modul['limit'])->result(); }
        else { $result = $this->Account_model->search($category,$parent)->result(); }
        
        if ($result){
	foreach($result as $res)
	{
	   $output[] = array ($res->id, $this->account->get_name($res->parent_id), $this->account->get_belanja_type($res->category), $res->code, ucfirst($res->name), $res->description, $res->publish, $res->created, $res->updated, $res->deleted);
	}
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($output, 128))
            ->_display();
            exit; 
        }
    }

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'account_view';
	      $data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_import'] = site_url($this->title.'/import');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));
	// ---------------------------------------- //
        
        $data['parent'] = $this->account->combo('nulls');
        $data['parent_import'] = $this->account->combo_complete('nulls');
        $data['category'] = $this->account->combo_belanja();
        $data['parent_update'] = $this->account->combo_update($this->session->userdata('langid'));
 
        $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = "<li><span><b>";
        $config['cur_tag_close'] = "</b></span></li>";

        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('#','No', 'Category', 'Parent', 'Code', 'Name', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url('account/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Account_model->get_by_id($uid)->row();
       if ($val->publish == 0){ $lng = array('publish' => 1); }else { $lng = array('publish' => 0); }
       $this->Account_model->update($uid,$lng);
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
           if ( $this->cek_relation($cek[$i]) == TRUE ) 
           {
              $img = $this->Account_model->get_account_by_id($cek[$i])->row();
              $img = $img->image;
              if ($img){ $img = "./images/account/".$img; unlink("$img"); }

              $this->Account_model->delete($cek[$i]); 
           }
           else { $x=$x+1; }
           
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
      }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }

    function delete($uid,$type='soft')
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
        if ($type == 'soft'){
           $this->Account_model->delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully soft removed..!";
       }
       else
       {
        if ( $this->cek_relation($uid) == TRUE )
        {
           $img = $this->Account_model->get_account_by_id($uid)->row();
           $img = $img->image;
           if ($img){ $img = "./images/account/".$img; unlink("$img"); }

           $this->Account_model->delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully removed..!";
        }
        else { $this->session->set_flashdata('message', "$this->title related to another component..!"); 
        echo  "invalid|$this->title related to another component..!";} 
       }
       }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }

    private function cek_relation($id)
    {
        $product = $this->product->cek_relation($id, $this->title);
        if ($product == TRUE) { return TRUE; } else { return FALSE; }
    }

    function add_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'account_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('account/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tcode', 'Kode Rekening', 'required|callback_valid_code');
        $this->form_validation->set_rules('tname', 'Nama Rekening', 'required|callback_valid_account');
        $this->form_validation->set_rules('tdesc', 'Keterangan', '');
        $this->form_validation->set_rules('cparent', 'Parent', 'numeric');
        $this->form_validation->set_rules('ccategory', 'Category', 'callback_valid_category['.$this->input->post('cparent').']');

        if ($this->form_validation->run($this) == TRUE)
        {
            if ($this->input->post('cparent')==0){$category = $this->input->post('ccategory');}
            else{ $category = $this->account->get_category($this->input->post('cparent')); }
            
            $account = array('name' => strtolower($this->input->post('tname')),
                             'code' => $this->input->post('tprefix').$this->input->post('tcode'),
                             'category' => $category,
                             'parent_id' => $this->input->post('cparent'),
                             'description' => $this->input->post('tdesc'),
                             'publish' => 1,
                             'created' => date('Y-m-d H:i:s'));

            $this->Account_model->add($account);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
            
            echo 'true|Data successfully saved..!';
        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null,$type='get')
    {        
        $account = $this->Account_model->get_by_id($uid)->row();
        if ($type=='update'){
            $this->session->unset_userdata('langid');
	    $this->session->set_userdata('langid', $account->id);    
        }

        $field = array($account->id, $account->parent_id, $account->category,  $account->code, $account->name, 
                   $account->description, $account->publish, $this->account->get_code($account->id)
            );
        
        echo implode('|', $field);
    }
    
    
    public function valid_code($code)
    {
        if ($this->Account_model->valid('code',$this->input->post('tprefix').$code) == FALSE)
        {
            $this->form_validation->set_message('valid_code', "This $this->title code is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    function valid_category($category,$parent)
    {
        if ($parent == 0){ 
            if (!$category){ $this->form->validation->validation->set_message('valid_category', 'Category Required...!!'); return FALSE; }
            else{ return TRUE; }
        }
        else { return TRUE; }
    }
    
    function validation_code($code)
    {
	$id = $this->session->userdata('langid');
	if ($this->Account_model->validating('code',$this->input->post('tprefix').$code,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_code', 'This '.$this->title.' code is already registered!');
            return FALSE;
        }
        else { return TRUE; }
    }

    public function valid_account($name)
    {
        if ($this->Account_model->valid('name',$name) == FALSE)
        {
            $this->form_validation->set_message('valid_account', "This $this->title is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validation_account($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->Account_model->validating('name',$name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_account', 'This account is already registered!');
            return FALSE;
        }
        else { return TRUE; }
    }

    // Fungsi update untuk mengupdate db
    function update_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'account_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('account/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tcode', 'Kode Rekening', 'required|callback_validation_code');
        $this->form_validation->set_rules('tname', 'Nama Rekening', 'required|callback_validation_account');
        $this->form_validation->set_rules('tdesc', 'Keterangan', '');
        $this->form_validation->set_rules('cparent', 'Parent', 'numeric');
        $this->form_validation->set_rules('ccategory', 'Category', 'callback_valid_category['.$this->input->post('cparent').']');
        
        if ($this->form_validation->run($this) == TRUE)
        {
            if ($this->input->post('cparent')==0){$category = $this->input->post('ccategory');}
            else{ $category = $this->account->get_category($this->input->post('cparent')); }
            
             $account = array('name' => strtolower($this->input->post('tname')),
                             'code' => $this->input->post('tprefix').$this->input->post('tcode'),
                             'category' => $category,
                             'parent_id' => $this->input->post('cparent'),
                             'description' => $this->input->post('tdesc'));
            
	    $this->Account_model->update($this->session->userdata('langid'), $account);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            
            echo 'true|Data successfully saved..!';
            
        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function remove_image($uid)
    {
       $img = $this->Account_model->get_account_by_id($uid)->row();
       $img = $img->image;
       if ($img){ $img = "./images/account/".$img; unlink("$img"); } 
    }
    
    function report()
    {
        $this->acl->otentikasi2($this->title);
        $data['title'] = $this->properti['name'].' | Report '.ucwords($this->modul['title']);

        $data['rundate'] = tglin(date('Y-m-d'));
        $data['log'] = $this->session->userdata('log');

//        Property Details
        $data['company'] = $this->properti['name'];
        $data['reports'] = $this->Account_model->report()->result();
        
        $this->load->view('account_report', $data);
    }
    
    function import()
    {
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'attendance_import';
	$data['form_action_import'] = site_url($this->title.'/import_process');
        $data['error'] = null;
	
//        $this->form_validation->set_rules('cmonth', 'Period Month', 'required|callback_valid_period['.$this->input->post('tyear').']');
        $this->form_validation->set_rules('cparent', 'Account Category', 'required|callback_valid_year');
        $this->form_validation->set_rules('userfile', 'Import File', '');
        
        if ($this->form_validation->run($this) == TRUE)
        {
             // ==================== upload ========================
            
            $config['upload_path']   = './uploads/';
            $config['file_name']     = 'account';
            $config['allowed_types'] = '*';
//            $config['allowed_types'] = 'csv';
            $config['overwrite']     = TRUE;
            $config['max_size']	     = '1000';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            
            if ( !$this->upload->do_upload("userfile"))
            { 
               $data['error'] = $this->upload->display_errors(); 
               $this->session->set_flashdata('message', "Error imported!");
               echo 'error|'.$data['error'];
            }
            else
            { 
               // success page 
              $this->import_account($this->input->post('cparent'),$config['file_name'].'.csv');
              $info = $this->upload->data(); 
              $this->session->set_flashdata('message', "One $this->title data successfully imported!");
              echo 'true|CSV Successful Uploaded';
            }                
        }
        else { $this->session->set_flashdata('message', "Error imported!"); echo 'error|'.validation_errors(); }
       // redirect($this->title);
        
    }
    
    private function import_account($parent,$filename)
    {
        $stts = null;
        $this->load->helper('file');
//        $csvreader = new CSVReader();
        $csvreader = $this->load->library('csvreader');
        $filename = './uploads/'.$filename;
        
        $result = $csvreader->parse_file($filename);
        
        foreach($result as $res)
        {
           if(isset($res['CODE']) && isset($res['NAME']))
           {
              if ($this->valid_code($res['CODE']) == TRUE)
              {
                $account = array('name' => $res['NAME'],
                             'code' => $res['CODE'],
                             'category' => $this->account->get_category($parent),
                             'parent_id' => $parent,
                             'description' => $res['NAME'],
                             'publish' => 1,
                             'created' => date('Y-m-d H:i:s'));
            
                $this->Account_model->add($account);
              }
           }              
        }
    }

}

?>