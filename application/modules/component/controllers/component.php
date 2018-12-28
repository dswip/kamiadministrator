<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Component extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Component_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

//        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->role = new Role_lib();

    }

    private $properti, $modul, $title;
    private $role;
    var $limit = 1000;

    function index()
    {
       $this->get_last(); 
    }
     
    public function getdatatable($search=null,$publish=null,$status=null,$active=null)
    {
        if(!$search){ $result = $this->Component_model->get_last($this->limit)->result(); }
        else {$result = $this->Component_model->search($publish,$status,$active)->result(); }
	
        $output = null;
        if ($result){
                
         foreach($result as $res)
	 {
	   $output[] = array ($res->id, $res->name, $res->title, $res->publish, $res->status, $res->aktif,
                              $res->limit, $res->role, $res->icon, $res->order,
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
        $this->acl->otentikasi_admin($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Component Manager');
        $data['h2title'] = 'Component Manager';
        $data['main_view'] = 'component_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['options'] = $this->role->combo();
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
        $this->table->set_heading('#','No', 'Name', 'Pbl', 'Status', 'Act', 'Limit', 'Role', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
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
             $this->Component_model->delete($cek[$i]);
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
            $this->Component_model->delete($uid);
            
            $this->session->set_flashdata('message', "1 $this->title successfully removed..!");

            echo "true|1 $this->title successfully removed..!";
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        
    }

    function add_process()
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Component Manager');
            $data['h2title'] = 'Component Manager';
            $data['form_action'] = site_url($this->title.'/add_process');
            $data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

            // Form validation
            $this->form_validation->set_rules('tname', 'Modul Name', 'required|maxlength[50]|callback_valid_modul');
            $this->form_validation->set_rules('ttitle', 'Modul Title', 'required|maxlength[50]');
            $this->form_validation->set_rules('rpublish', 'Publish', 'required');
            $this->form_validation->set_rules('cstatus', 'Status', 'required');
            $this->form_validation->set_rules('raktif', 'Active', 'required');
            $this->form_validation->set_rules('tlimit', 'Limit', 'required');
            $this->form_validation->set_rules('torder', 'Order', 'required|numeric');
            $this->form_validation->set_rules('crole', 'Role', 'required|callback_valid_role');

            if ($this->form_validation->run($this) == TRUE)
            {  
                $config['upload_path']   = './images/component/';
                $config['file_name']     = $this->input->post('tname');
                $config['allowed_types'] = 'png|jpg';
                $config['overwrite']     = TRUE;
                $config['max_size']	 = '1000';
                $config['max_width']     = '1000';
                $config['max_height']    = '1000';
                $config['remove_spaces'] = TRUE;
                
                $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();
                $component = array('name' => $this->input->post('tname'), 'title' => $this->input->post('ttitle'),
                                   'publish' => $this->input->post('rpublish'), 'status' => $this->input->post('cstatus'),
                                   'aktif' => $this->input->post('raktif'), 'limit' => $this->input->post('tlimit'),
                                   'role' => $this->split_array($this->input->post('crole')), 'order' => $this->input->post('torder'),
                                   'icon' => 'default.png', 'created' => date('Y-m-d H:i:s'));
            }
            else
            {
                $info = $this->upload->data();
                $component = array('name' => $this->input->post('tname'), 'title' => $this->input->post('ttitle'),
                                   'publish' => $this->input->post('rpublish'), 'status' => $this->input->post('cstatus'),
                                   'aktif' => $this->input->post('raktif'), 'limit' => $this->input->post('tlimit'),
                                   'role' => $this->split_array($this->input->post('crole')), 'order' => $this->input->post('torder'),
                                   'icon' => $info['file_name'], 'created' => date('Y-m-d H:i:s'));
            }

                $this->Component_model->add($component);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
                if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
                else { echo 'true|Data successfully saved..!|'.base_url().'images/component/'.$info['file_name']; }
            }
            else
            {
    //            $this->load->view('template', $data);
    //            echo validation_errors();
                echo 'error|'.validation_errors();
            }
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }
    
    private function split_array($val)
    { return implode(",",$val); }
    
    function remove_img($id)
    {
        $img = $this->Component_model->get_by_id($id)->row();
        $img = $img->icon;
        if ($img){ $img = "./images/component/".$img; unlink("$img"); }
    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $admin = $this->Component_model->get_by_id($uid)->row();
	$this->session->set_userdata('langid', $admin->id);
        
        echo $uid.'|'.$admin->name.'|'.$admin->title.'|'.$admin->publish.'|'.$admin->status.
             '|'.$admin->aktif.'|'.$admin->limit.'|'.$admin->role.'|'.$admin->icon.'|'.$admin->order;
    }

    function valid_role($val)
    {
        if(!$val)
        {
          $this->form_validation->set_message('valid_role', "role type required.");
          return FALSE;
        }
        else{ return TRUE; }
    }
    
    function valid_modul($val)
    {
        if ($this->Component_model->valid('name',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_modul', $this->title.' registered');
            return FALSE;
        }
        else {  return TRUE; }
    }

    function validating_component($val)
    {
	$id = $this->session->userdata('langid');
	if ($this->Component_model->validating('name',$val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_component', "This $this->title name is already registered!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    // Fungsi update untuk mengupdate db
    function update_process()
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Componentistrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'admin_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tname', 'Modul Name', 'required|maxlength[50]|callback_validating_component');
        $this->form_validation->set_rules('ttitle', 'Modul Title', 'required|maxlength[50]');
        $this->form_validation->set_rules('rpublish', 'Publish', 'required');
        $this->form_validation->set_rules('cstatus', 'Status', 'required');
        $this->form_validation->set_rules('raktif', 'Active', 'required');
        $this->form_validation->set_rules('tlimit', 'Limit', 'required');
        $this->form_validation->set_rules('torder', 'Order', 'required|numeric');
        $this->form_validation->set_rules('crole', 'Active', 'required|callback_valid_role');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path']   = './images/component/';
            $config['file_name']     = $this->input->post('tname');
            $config['allowed_types'] = 'png|jpg';
            $config['overwrite']     = TRUE;
            $config['max_size']	     = '1500';
            $config['max_width']     = '1000';
            $config['max_height']    = '1000';
            $config['remove_spaces'] = TRUE;
            
            $this->load->library('upload', $config);
            
            if ( !$this->upload->do_upload("userfile"))
            {
                $data['error'] = $this->upload->display_errors();
                $component = array('name' => $this->input->post('tname'), 'title' => $this->input->post('ttitle'),
                                   'publish' => $this->input->post('rpublish'), 'status' => $this->input->post('cstatus'),
                                   'aktif' => $this->input->post('raktif'), 'limit' => $this->input->post('tlimit'),
                                   'role' => $this->split_array($this->input->post('crole')), 'order' => $this->input->post('torder'));
            }
            else
            {
                $info = $this->upload->data();
                $component = array('name' => $this->input->post('tname'), 'title' => $this->input->post('ttitle'),
                                   'publish' => $this->input->post('rpublish'), 'status' => $this->input->post('cstatus'),
                                   'aktif' => $this->input->post('raktif'), 'limit' => $this->input->post('tlimit'),
                                   'role' => $this->split_array($this->input->post('crole')), 'order' => $this->input->post('torder'),
                                   'icon' => $info['file_name']);
            }

	    $this->Component_model->update($this->session->userdata('langid'), $component);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
          //  $this->session->unset_userdata('langid');
             if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
             else { echo 'true|Data successfully saved..!|'.base_url().'images/component/'.$info['file_name']; }

        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }

}

?>