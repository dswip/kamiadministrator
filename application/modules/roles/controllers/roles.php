<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Role_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->menu = new Adminmenu_lib();

    }

    private $properti, $modul, $title, $menu;

    function index()
    {
       $this->get_last(); 
    }
     
    public function getdatatable($search=null)
    {
        if(!$search){ $result = $this->Role_model->get_last_role($this->modul['limit'])->result(); }
	
        $output = null;
        if ($result){
                
         foreach($result as $res)
	 {  
	   $output[] = array ($res->id, $res->name, ucfirst($res->desc), self::get_rules($res->rules));
	 } 
         
        $this->output
         ->set_status_header(200)
         ->set_content_type('application/json', 'utf-8')
         ->set_output(json_encode($output))
         ->_display();
         exit;  
        }
    }
    
    private function get_rules($val)
    {
        $re = null;
        switch ($val)
        {
            case 1:
              $re = "read";
              break;
            case 2:
              $re = "read / write";
              break;
            case 3:
              $re = "full control";
              break;
            case 4:
              $re = "approval";
              break;
        }
        return $re;
    }

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'role_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['array'] = array('','');
        $data['options'] = $this->menu->combo_parent();
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
        $this->table->set_heading('#','No', 'Name', 'Description', 'Rules', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    private function split_array($val){ return implode(",",$val); }
    
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
                 $this->Role_model->delete($cek[$i]);
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
      }
      else{ echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
      
    }

    function delete($uid)
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
        
            $this->Role_model->delete($uid);
            $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
            echo "true|1 $this->title successfully removed..!";
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        
       // redirect($this->title);
    }

    function add_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
            $data['h2title'] = $this->modul['title'];
            $data['main_view'] = 'role_view';
            $data['form_action'] = site_url($this->title.'/add_process');
            $data['link'] = array('link_back' => anchor('role/','<span>back</span>', array('class' => 'back')));

            // Form validation
            $this->form_validation->set_rules('tname', 'Role Name', 'required|maxlength[100]|callback_valid_roles');
            $this->form_validation->set_rules('tdesc', 'Role Description', 'required');
            $this->form_validation->set_rules('crules', 'Rules', 'required');

            if ($this->form_validation->run($this) == TRUE)
            {//
                $roles = array('name' => $this->input->post('tname'), 'desc' => $this->input->post('tdesc'), 'rules' => $this->input->post('crules'),
                               'created' => date('Y-m-d H:i:s'), 'granted_menu' => $this->split_array($this->input->post('cmenu')));

                $this->Role_model->add($roles);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
                echo 'true|Data successfully saved..!';
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

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $role = $this->Role_model->get_by_id($uid)->row();
               
	$this->session->set_userdata('langid', $role->id);
        echo $uid.'|'.$role->name.'|'.$role->desc.'|'.$role->rules.'|'.$role->granted_menu;
    }


    function valid_roles($val)
    {
        if ($this->Role_model->valid('name',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_roles', $this->title.' registered');
            return FALSE;
        }
        else{  return TRUE; }
    }

    function validating_roles($val)
    {
	$id = $this->session->userdata('langid');
	if ($this->Role_model->validating('name',$val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_roles', "This $this->title name is already registered!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    // Fungsi update untuk mengupdate db
    function update_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
            $data['h2title'] = $this->modul['title'];
            $data['main_view'] = 'role_update';
            $data['form_action'] = site_url($this->title.'/update_process');
            $data['link'] = array('link_back' => anchor('role/','<span>back</span>', array('class' => 'back')));

            // Form validation
            $this->form_validation->set_rules('tname', 'Role Name', 'required|maxlength[100]|callback_validating_roles');
            $this->form_validation->set_rules('tdesc', 'Role Description', 'required');
            $this->form_validation->set_rules('crules', 'Rules', 'required');

            if ($this->form_validation->run($this) == TRUE)
            {
                $roles = array('name' => $this->input->post('tname'), 'desc' => $this->input->post('tdesc'), 'rules' => $this->input->post('crules'),
                               'granted_menu' => $this->split_array($this->input->post('cmenu')));

                $this->Role_model->update($this->session->userdata('langid'), $roles);
                $this->session->set_flashdata('message', "One $this->title has successfully updated!");
              //  $this->session->unset_userdata('langid');
                echo "true|One $this->title has successfully updated..!";

            }
            else{ echo 'error|'.validation_errors(); }
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }

}

?>