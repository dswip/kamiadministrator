<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Log_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->user = new Admin_lib();
        $this->com = new Components();
    }

    private $properti, $modul, $title;
    private $user,$com;

    function index()
    {
       $this->get_last();
    }
     
    public function getdatatable($search=null)
    {
        if(!$search){ $result = $this->Log_model->get_last_user($this->modul['limit'])->result(); }
	
        $output = null;
        if ($result){
            
         foreach($result as $res)
	 {
	   $output[] = array ($res->id, $this->user->get_username($res->userid), tglin($res->date), $res->time, $this->com->get_name($res->component_id), $res->activity,
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

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'log_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_report'] = site_url($this->title.'/report_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['user'] = $this->user->combo_all();
        $data['modul'] = $this->com->combo_id_all();
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
        $this->table->set_heading('#','No', 'Username', 'Date', 'Time', 'Component', 'Activity', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function delete_all()
    {
      $this->acl->otentikasi_admin($this->title);
      
      $cek = $this->input->post('cek');
      $jumlah = count($cek);

      if($cek)
      {
        $jumlah = count($cek);
        $x = 0;
        for ($i=0; $i<$jumlah; $i++)
        {
           $this->Log_model->delete($cek[$i]);
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
   //   redirect($this->title);
    }

    function delete($uid)
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
        $this->Log_model->delete($uid);
        $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
        echo "true|1 $this->title successfully removed..!";
       }
       else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }

    function add_process()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'admin_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tusername', 'UserName', 'required|callback_valid_username');
	$this->form_validation->set_rules('tpassword', 'Password', 'required');
        $this->form_validation->set_rules('tname', 'Name', 'required');
        $this->form_validation->set_rules('taddress', 'Address', 'required');
        $this->form_validation->set_rules('tphone', 'Phone', 'required|numeric');
        $this->form_validation->set_rules('ccity', 'City', 'required');
        $this->form_validation->set_rules('tmail', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('crole', 'Role', 'required');
        $this->form_validation->set_rules('tid', 'Yahoo Id', '');
        $this->form_validation->set_rules('rstatus', 'Status', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {//
            $users = array('username' => $this->input->post('tusername'),'password' => $this->input->post('tpassword'),'name' => $this->input->post('tname'),
                           'address' => $this->input->post('taddress'), 'phone1' => $this->input->post('tphone'), 'city' => $this->input->post('ccity'),
                           'email' => $this->input->post('tmail'), 'yahooid' => setnull($this->input->post('tid')), 'role' => $this->input->post('crole'), 
                           'status' => $this->input->post('rstatus'), 'created' => date('Y-m-d H:i:s'));

            $this->Log_model->add($users);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
            echo 'true|Data successfully saved..!';
        }
        else
        {
//            $this->load->view('template', $data);
//            echo validation_errors();
            echo 'invalid|'.validation_errors();
        }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $admin = $this->Log_model->get_user_by_id($uid)->row();
               
	$this->session->set_userdata('langid', $admin->id);
        
        echo $uid.'|'.$admin->username.'|'.$admin->name.'|'.$admin->address.'|'.$admin->phone1.
             '|'.$admin->city.'|'.$admin->email.'|'.$admin->role.'|'.$admin->status;
    }


    function valid_username()
    {
        $uname = $this->input->post('tusername');
        
        if ($this->Log_model->valid_name($uname) == FALSE)
        {
            $this->form_validation->set_message('valid_username', 'This user is already registered.!');
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validation_username($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->Log_model->validation_username($name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_username', 'This user is already registered!');
            return FALSE;
        }
        else{ return TRUE; }
    }

    // Fungsi update untuk mengupdate db
    function update_process()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'admin_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tusername', 'UserName', 'required|callback_validation_username');
	$this->form_validation->set_rules('tpassword', 'Password', '');
        $this->form_validation->set_rules('tname', 'Name', 'required');
        $this->form_validation->set_rules('taddress', 'Address', 'required');
        $this->form_validation->set_rules('tphone', 'Phone', 'required|numeric');
        $this->form_validation->set_rules('ccity', 'City', 'required');
        $this->form_validation->set_rules('tmail', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('crole', 'Role', 'required');
        $this->form_validation->set_rules('rstatus', 'Status', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            if ($this->input->post('tpassword')){
            
              $users = array('username' => $this->input->post('tusername'),'password' => $this->input->post('tpassword'),'name' => $this->input->post('tname'),
                           'address' => $this->input->post('taddress'), 'phone1' => $this->input->post('tphone'), 'city' => $this->input->post('ccity'),
                           'email' => $this->input->post('tmail'), 'yahooid' => setnull($this->input->post('tid')), 'role' => $this->input->post('crole'), 
                           'status' => $this->input->post('rstatus'));     
            }
            else {
              $users = array('username' => $this->input->post('tusername'),'name' => $this->input->post('tname'),
                           'address' => $this->input->post('taddress'), 'phone1' => $this->input->post('tphone'), 'city' => $this->input->post('ccity'),
                           'email' => $this->input->post('tmail'), 'yahooid' => setnull($this->input->post('tid')), 'role' => $this->input->post('crole'), 
                           'status' => $this->input->post('rstatus'));
            }

	    $this->Log_model->update($this->session->userdata('langid'), $users);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
          //  $this->session->unset_userdata('langid');
            echo "true|One $this->title has successfully updated..!";

        }
        else
        {
            echo 'invalid|'.validation_errors();
        }
    }
    
    function report_process()
    {
        $this->acl->otentikasi2($this->title);
        $data['title'] = $this->properti['name'].' | Report '.ucwords($this->modul['title']);

        $user  = $this->input->post('cuser');
        $modul = $this->input->post('ccom');
        
        $period = $this->input->post('reservation');  
        $start = picker_between_split($period, 0);
        $end = picker_between_split($period, 1);

        $data['start'] = $start;
        $data['end'] = $end;
        $data['user'] = $this->user->get_username($user);
        $data['modul'] = $this->com->get_name($modul);
        $data['rundate'] = tglin(date('Y-m-d'));
        $data['log'] = $this->session->userdata('log');

//        Property Details
        $data['company'] = $this->properti['name'];
        $data['reports'] = $this->Log_model->report($user,$modul,$start,$end)->result();

        if ($this->input->post('ctype') == 0){ $this->load->view('log_report', $data); }
        else { $this->load->view('log_pivot', $data); } 
    }

}

?>