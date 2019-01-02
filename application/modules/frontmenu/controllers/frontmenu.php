<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frontmenu extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Frontmenu_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->role = new Role_lib();
        $this->city = new City_lib();
        $this->menu = new Frontmenu_lib();
        $this->component = new Components();
    }

    private $properti, $modul, $title;
    private $role,$city,$menu,$component;

    function index()
    {
       $this->get_last(); 
    }
     
    public function getdatatable($search=null)
    {
        if(!$search){ $result = $this->Frontmenu_model->get_last($this->modul['limit'])->result(); }
	
        $output = null;
        if ($result){
            
          foreach ($result as $res)    
          {
              if ($res->parent_id == 0){ $stts = 'parent'; }else { $stts = 'child'; }
              $output[] = array ($res->id, $this->menu->getmenuname($res->parent_id), $res->position, $res->name, $res->type, $res->url, 
                                 $res->menu_order, $res->class_style, $res->id_style, $res->icon, $res->target, $res->publish, $stts
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
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Frontmenu_model->get_by_id($uid)->row();
       if ($val->publish == 0){ $lng = array('publish' => 1); }else { $lng = array('publish' => 0); }
       $this->Frontmenu_model->update($uid,$lng);
       echo 'true|Status Changed...!';
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }
    
    private $atts1 = array(
	  'class'      => 'btn btn-default btn-xs',
          'id'         => 'bnewsplace',
	  'title'      => 'Article List',
	  'width'      => '600',
	  'height'     => '500',
	  'scrollbars' => 'yes',
	  'status'     => 'yes',
	  'resizable'  => 'yes',
	  'screenx'    =>  '\'+((parseInt(screen.width) - 600)/2)+\'',
	  'screeny'    =>  '\'+((parseInt(screen.height) - 500)/2)+\'',
    );
    
    private $atts2 = array(
	  'class'      => 'btn btn-default btn-xs',
          'id'         => 'bnewsplaceupdate',
	  'title'      => 'Article List',
	  'width'      => '600',
	  'height'     => '500',
	  'scrollbars' => 'yes',
	  'status'     => 'yes',
	  'resizable'  => 'yes',
	  'screenx'    =>  '\'+((parseInt(screen.width) - 600)/2)+\'',
	  'screeny'    =>  '\'+((parseInt(screen.height) - 500)/2)+\'',
    );

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Configurationistrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'menu_view';
        $data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));
        
        $data['tombol'] = anchor_popup('article/article_list/', '<i class="fa fa-file-text"></i>&nbsp; Article List ', $this->atts1);
        $data['tombol2'] = anchor_popup('article/article_list/', '<i class="fa fa-file-text"></i>&nbsp; Article List ', $this->atts2);

        $data['parent'] = $this->menu->combo();
        $data['modul'] = $this->component->combo();
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
        $this->table->set_heading('#','No', 'Parent', 'Name', 'Position', 'Type', 'Order', 'Class', 'ID', 'Target', 'Status', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function add_process()
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
            $data['h2title'] = $this->modul['title'];
            $data['main_view'] = 'admin_view';
            $data['form_action'] = site_url($this->title.'/add_process');
            $data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

            // Form validation
            $this->form_validation->set_rules('tname', 'Menu Name', 'required|callback_valid_name');
            $this->form_validation->set_rules('cparent', 'Parent Adminmenu', 'required');
            $this->form_validation->set_rules('rposition', 'Position', 'required');
            $this->form_validation->set_rules('ctype', 'Menu Type', 'required');
            $this->form_validation->set_rules('turl', 'URL', 'required');
            $this->form_validation->set_rules('tlimit', 'Content Limit', 'required|numeric');
            $this->form_validation->set_rules('tmenuorder', 'Menu Order', 'required');
            $this->form_validation->set_rules('tclass', 'Class', '');
            $this->form_validation->set_rules('tid', 'ID', '');
            $this->form_validation->set_rules('ctarget', 'Target', 'required');

            if ($this->form_validation->run($this) == TRUE)
            {
               $menu = array('parent_id' => $this->input->post('cparent'),'name' => $this->input->post('tname'),
                             'position' => $this->input->post('rposition'), 'type' => $this->input->post('ctype'),
                             'url' => $this->input->post('turl'), 'limit' => $this->input->post('tlimit'),
                             'menu_order' => $this->input->post('tmenuorder'), 'class_style' => $this->input->post('tclass'),
                             'id_style' => $this->input->post('tid'),'icon' => null, 'target' => $this->input->post('ctarget'),
                             'created' => date('Y-m-d H:i:s'));

                $this->Frontmenu_model->add($menu);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
                echo 'true|Data successfully saved..!';
            }
            else
            {
    //            $this->load->view('template', $data);
    //            echo validation_errors();
                echo 'warning|'.validation_errors();
            }
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

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
             $this->Frontmenu_model->delete_child($cek[$i]); // delete child related parent menu  
             $this->Frontmenu_model->delete($cek[$i]);
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
            $this->Frontmenu_model->delete_child($uid); // delete child related parent menu
            $this->Frontmenu_model->force_delete($uid);
            $this->session->set_flashdata('message', "1 $this->title successfully removed..!");

            echo "true|1 $this->title successfully removed..!";
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        
    }
    
    function update($uid=null)
    {        
        $admin = $this->Frontmenu_model->get_by_id($uid)->row_array();
	$this->session->set_userdata('langid', $admin['id']);
        $res = implode("|", $admin);
        echo $res;
    }

    // Fungsi update untuk mengupdate db

    function update_process()
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'admin_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tname', 'Name', 'required|callback_validating_name');
        $this->form_validation->set_rules('cparent', 'Parent Adminmenu', 'required');
        $this->form_validation->set_rules('rposition', 'Position', 'required');
        $this->form_validation->set_rules('ctype', 'Menu Type', 'required');
        $this->form_validation->set_rules('turl', 'URL', 'required');
        $this->form_validation->set_rules('tlimit', 'Content Limit', 'required|numeric');
        $this->form_validation->set_rules('tmenuorder', 'Menu Order', 'required');
        $this->form_validation->set_rules('tclass', 'Class', '');
        $this->form_validation->set_rules('tid', 'ID', '');
        $this->form_validation->set_rules('ctarget', 'Target', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $menu = array('parent_id' => $this->input->post('cparent'),'name' => $this->input->post('tname'),
                             'position' => $this->input->post('rposition'), 'type' => $this->input->post('ctype'),
                             'url' => $this->input->post('turl'), 'limit' => $this->input->post('tlimit'),
                             'menu_order' => $this->input->post('tmenuorder'), 'class_style' => $this->input->post('tclass'),
                             'id_style' => $this->input->post('tid'), 'target' => $this->input->post('ctarget'));

	    $this->Frontmenu_model->update($this->session->userdata('langid'), $menu);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
          //  $this->session->unset_userdata('langid');
            echo "true|One $this->title has successfully updated..!";

        }
        else{ echo 'warning|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function valid_name($name)
    {
        if ($this->Frontmenu_model->valid('name',$name) == FALSE)
        {
            $this->form_validation->set_message('valid_name', $this->title.' name registered');
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validating_name($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->Frontmenu_model->validating('name',$name,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_name', "This $this->title name is already registered!");
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    function remove_img()
    {
        $img = $this->Frontmenu_model->get_by_id(1)->row();
        $img = $img->logo;
        if ($img){ $img = "./images/property/".$img; unlink("$img"); }
    }
    
    // ================================== ajax ======================================================
    
    function modultypefront()
    {
        $type = $this->input->post('ctype');

        if ($type == 'modul')
        {
           $values = $this->Frontmenu_model->getmodul()->result();
           echo "<select name=\"cmodul\" id=\"cmodul\" class=\"form-control\" size=\"5\" onchange=\"geturl(this.value)\">";
           foreach ($values as $val)
           {
             echo "<option value=\"$val->name\"> $val->name </option>";
           }
           echo "</select>";
        }
        elseif ($type == "articlelist")
        {
           $values = $this->Frontmenu_model->getarticle()->result();
           echo "<select name=\"ccat\" id=\"ccat\" class=\"form-control\" size=\"10\" onchange=\"setnilai(this.value)\">";
           foreach ($values as $val)
           {
             echo "<option value=\"$val->name\"> $val->name </option>";
           }
           echo "</select>";
        }
    }
    
}

?>