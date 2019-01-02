<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Component extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Component_model', '', TRUE);
        $this->properti = $this->property->get();
        $this->acl->otentikasi();
        $this->role = $this->load->library('role');

//        $this->modul = $this->components->get('component');
////        $this->title = $this->component['name'];
        $this->title = strtolower(get_class($this));
    }
    
    private $properti, $role;
    var $title;
    var $limit = 25;
    
    function index()
    { $this->get_last_component();  }
    
    function get_last_component()
    {
        $this->acl->otentikasi_admin($this->title);
        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Component Manager');
        $data['h2title'] = 'Component Manager';
        $data['main_view'] = 'component_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','<span>back</span>', array('class' => 'back')));

	$uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        $components = $this->Component_model->get_last_modul($this->limit, $offset)->result();
        $num_rows = $this->Component_model->count_all_num_rows(); 

        $data['options'] = $this->role->combo();
        $data['array'] = array('','');
//
        $config['base_url'] = site_url('component/get_last_component');
        $config['total_rows'] = $num_rows;
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links(); //array menampilkan link untuk pagination.
        // akhir dari config untuk pagination

        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table cellpadding="2" cellspacing="1" class="tablemaster table table-bordered">');
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        $atts = array(
              'class'      => 'update',
              'title'      => 'edit / update',
              'width'      => '600',
              'height'     => '500',
              'scrollbars' => 'no',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    =>  '\'+((parseInt(screen.width) - 600)/2)+\'',
              'screeny'    =>  '\'+((parseInt(screen.height) - 500)/2)+\'',
            );

        $this->table->set_heading('#','No', 'Name', 'Pbl', 'Status', 'Act', 'Limit', 'Role', 'Action');

        $i = 0 + $offset;
        foreach ($components as $component)
        {
            $datax = array('name'=> 'cek[]','id'=> 'cek'.$i,'value'=> $component->id,'checked'=> FALSE, 'style'=> 'margin:0px');
            $this->table->add_row
            (
                form_checkbox($datax), ++$i, $component->name, $component->publish, $component->status, $component->aktif, $component->limit, $component->role,
                anchor($this->title.'/update/'.$component->id,'<span>update</span>',array('class' => 'update')).' '.
//                anchor_popup($this->title.'/update/'.$component->id, '<span>update</span>', $atts).' '.
                anchor($this->title.'/delete/'.$component->id,'<span>delete</span>',array('class'=> 'delete', 'title' => 'delete' ,'onclick'=>"return confirm('Are you sure you will delete this data?')"))
            );
        }

        // table di generate
        $data['table'] = $this->table->generate();
        //          fasilitas check all
        $js = "onClick='cekall($i)'";
        $sj = "onClick='uncekall($i)'";
        $data['radio1'] = form_radio('newsletter', 'accept1', FALSE, $js).'Check';
        $data['radio2'] = form_radio('newsletter', 'accept2', FALSE, $sj).'Uncheck';

        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function delete($uid)
    {
        $this->acl->otentikasi_admin($this->title);

        $img = $this->Component_model->get_modul_by_id($uid)->row();
        $img = $img->icon;
        if ($img){ $img = "./images/component/".$img; unlink("$img"); }

        $this->Component_model->delete($uid); // memanggil model untuk mendelete data
        $this->session->set_flashdata('message', "1 $this->title successfully removed..!!"); // set flash data message dengan session
        redirect($this->title);
    }

    function delete_all()
    {
      $this->acl->otentikasi_admin($this->title);
      $cek = $this->input->post('cek');

      if($cek)
      {
        $jumlah = count($cek);
        for ($i=0; $i<$jumlah; $i++)
        {
            $img = $this->Component_model->get_modul_by_id($cek[$i])->row();
            $img = $img->icon;
            if ($img){ $img = "./images/component/".$img; unlink("$img"); }

            $this->Component_model->delete($cek[$i]);
        }

        $this->session->set_flashdata('message', "$jumlah $this->title successfully removed..!!"); // set flash data message dengan session
        redirect($this->title);
      }
      else
      {
           $this->session->set_flashdata('message', "No $this->title Selected..!!"); // set flash data message dengan session
           redirect($this->title);
      }
    }
    
    function add_process()
    {
        $this->acl->otentikasi_admin($this->title);
        
	$data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Component Manager');
        $data['h2title'] = "Component Manager";

        $data['main_view'] = 'component_view';
        $data['error'] = '';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
	$data['link'] = array('link_back' => anchor($this->title,'<span>kembali</span>', array('class' => 'back')));

        $data['options'] = $this->role->combo();
        $data['array'] = array('','');

        $this->form_validation->set_rules('tname', 'Modul Name', 'required|maxlength[50]|callback_valid_modul');
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
            $config['max_size']	     = '150';
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
                                   'icon' => 'default.png');
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

            $this->Component_model->add($component);
            $this->session->set_flashdata('message', "One data $this->title successfully saved!");
            redirect($this->title);    
        }
        else
        {
            $this->load->view('template', $data);
        }
    }

    private function split_array($val)
    { return implode(",",$val); }

    function valid_role($val)
    {
        if(!$val)
        {
          $this->form_validation->set_message('valid_role', "role type required.");
          return FALSE;
        }
        else
        {
          return TRUE;
        }
    }

    function valid_modul($val)
    {
        if ($this->Component_model->valid_modul($val) == FALSE)
        {
            $this->form_validation->set_message('valid_modul', $this->title.' registered');
            return FALSE;
        }
        else {  return TRUE; }
    }

    function validating_component($val)
    {
	$id = $this->session->userdata('modid');
	if ($this->Component_model->validating_modul($val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_component', "This $this->title name is already registered!");
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    function update($uid)
    {
        $this->acl->otentikasi_admin($this->title);
        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Component Manager');
        $data['h2title'] = "Component Manager";

        $data['main_view'] = 'component_update';
        $data['error'] = '';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
	$data['link'] = array('link_back' => anchor($this->title,'<span>kembali</span>', array('class' => 'back')));

        $data['options'] = $this->role->combo();
        
        $component = $this->Component_model->get_modul_by_id($uid)->row();
       
	$data['default']['name'] = $component->name;
        $data['default']['title'] = $component->title;
        $data['default']['publish'] = $component->publish;
        $data['default']['status'] = $component->status;
        $data['default']['aktif'] = $component->aktif;
        $data['default']['limit'] = $component->limit;
        $data['default']['order'] = $component->order;
        $data['default']['image'] = base_url().'images/component/'.$component->icon;

        $data['array'] = explode(",", $component->role);
	
	$this->session->set_userdata('modid', $component->id);
    
       $this->load->view('component_update', $data);
    }
    
    // Fungsi update untuk mengupdate db
    function update_process()
    {
        $this->acl->otentikasi_admin($this->title);

	$data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Component Manager');
        $data['h2title'] = "Component Manager";

        $data['main_view'] = 'component_update';
        $data['error'] = '';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
	$data['link'] = array('link_back' => anchor($this->title,'<span>kembali</span>', array('class' => 'back')));

        $data['options'] = $this->role->combo();
        $data['array'] = array('','');

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
            $config['max_size']	     = '150';
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

            $this->Component_model->update($this->session->userdata('modid'),$component);
            $this->session->set_flashdata('message', "One data $this->title successfully saved!");
            redirect($this->title.'/update/'.$this->session->userdata('modid'));
            $this->session->unset_userdata('modid');
        }
        else
        {
           $this->load->view('component_update', $data);
        }
    }
    
}

?>