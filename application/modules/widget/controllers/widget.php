<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Widget extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Widget_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->role = new Role_lib();
        $this->menu = new Frontmenu_lib();
        $this->widget = new Widget_lib();
    }

    private $properti, $modul, $title;
    private $city,$role,$menu,$widget;

    function index()
    {
       $this->get_last(); 
    }
     
    public function getdatatable($search=null)
    {
        if(!$search){ $result = $this->Widget_model->get_last($this->modul['limit'])->result(); }
	
        $output = null;
        if ($result){
                
         foreach($result as $res)
	 {   
           if ($res->publish == 1){ $stts = "Y"; }else { $stts = "N"; }
	   $output[] = array ($res->id, $res->name, $res->title, $res->position, $stts, $res->order,
                              $res->menu, $this->menu->getmenuname($res->moremenu), $res->limit
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
        $data['main_view'] = 'widget_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['menu'] = $this->menu->combo();
        $data['position'] = $this->widget->combo_position();
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
        $this->table->set_heading('#','No', 'Name', 'Title', 'Position', 'Order', 'More', 'Limit', 'Publish', 'Action');

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
             $this->Widget_model->delete($cek[$i]);
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
            $this->Widget_model->delete($uid);
            $this->session->set_flashdata('message', "1 $this->title successfully removed..!");

            echo "true|1 $this->title successfully removed..!";
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; } 
    }

    function add_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
            $data['h2title'] = $this->modul['title'];
            $data['main_view'] = 'widget_view';
            $data['form_action'] = site_url($this->title.'/add_process');
            $data['link'] = array('link_back' => anchor('widget/','<span>back</span>', array('class' => 'back')));

            // Form validation
            $this->form_validation->set_rules('tname', 'Widget Name', 'required||maxlength[50]|callback_valid_widget');
            $this->form_validation->set_rules('ttitle', 'Title', '');
            $this->form_validation->set_rules('rpublish', 'Publish', 'required');
            $this->form_validation->set_rules('cposition', 'Status', 'required');
            $this->form_validation->set_rules('tmenuorder', 'Active', 'required');
            $this->form_validation->set_rules('cmenu', 'Menu', 'required');
            $this->form_validation->set_rules('cmore', 'Readmore', 'required');
            $this->form_validation->set_rules('tlimit', 'Limit', 'required');

            if ($this->form_validation->run($this) == TRUE)
            {
                $widget = array('name' => $this->input->post('tname'), 'title' => $this->input->post('ttitle'), 'limit' => $this->input->post('tlimit'),
                                'publish' => $this->input->post('rpublish'), 'position' => $this->input->post('cposition'), 'moremenu' => $this->input->post('cmore'),
                                'order' => $this->input->post('tmenuorder'), 'created' => date('Y-m-d H:i:s'),
                                'menu' => $this->split_array($this->input->post('cmenu')));

                $this->Widget_model->add($widget);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
                echo 'true|Data successfully saved..!';
            }
            else
            {
                echo 'warning|'.validation_errors();
            }
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }
    
    function split_array($val)
    {
      return implode(",",$val);
    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $widget = $this->Widget_model->get_by_id($uid)->row();
        
	$this->session->set_userdata('langid', $widget->id);
        echo $uid.'|'.$widget->name.'|'.$widget->title.'|'.$widget->position.'|'.$widget->publish.
             '|'.$widget->order.'|'.$widget->menu.'|'.$widget->moremenu.'|'.$widget->limit;
    }


    function valid_widget($val)
    {
        if ($this->Widget_model->valid('name',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_widget', $this->title.' registered');
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validating_widget($val)
    {
	$id = $this->session->userdata('langid');
	if ($this->Widget_model->validating('name',$val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_widget', "This $this->title name is already registered!");
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
        $data['main_view'] = 'widget_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('widget/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tname', 'Widget Name', 'required|maxlength[50]|callback_validating_widget');
        $this->form_validation->set_rules('ttitle', 'Title', '');
        $this->form_validation->set_rules('rpublish', 'Publish', 'required');
        $this->form_validation->set_rules('cposition', 'Status', 'required');
        $this->form_validation->set_rules('tmenuorder', 'Active', 'required');
        $this->form_validation->set_rules('cmenu', 'Menu', 'required');
        $this->form_validation->set_rules('cmore', 'Readmore', 'required');
        $this->form_validation->set_rules('tlimit', 'Limit', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $widget = array('name' => $this->input->post('tname'), 'title' => $this->input->post('ttitle'), 'limit' => $this->input->post('tlimit'),
                            'publish' => $this->input->post('rpublish'), 'position' => $this->input->post('cposition'), 
                            'moremenu' => $this->input->post('cmore'), 'order' => $this->input->post('tmenuorder'),
                            'menu' => $this->split_array($this->input->post('cmenu')));

	    $this->Widget_model->update($this->session->userdata('langid'), $widget);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
          //  $this->session->unset_userdata('langid');
            echo "true|One $this->title has successfully updated..!";

        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }

}

?>