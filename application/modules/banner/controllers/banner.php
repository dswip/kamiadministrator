<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Banner_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->menu = new Frontmenu_lib();

    }

    private $properti, $modul, $title;
    private $menu;

    function index()
    {
       $this->get_last(); 
    }
    
    public function getdatatable($search=null)
    {
        if(!$search){ $result = $this->Banner_model->get_last($this->modul['limit'])->result(); }
        
        if ($result){
	foreach($result as $res)
	{           
	   $output[] = array ($res->id, $res->name, $res->position, $res->url, $res->publish, base_url().'images/banner/'.$res->image, $res->width, $res->height, $res->menu);
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
       $val = $this->Banner_model->get_by_id($uid)->row();
       if ($val->publish == 0){ $lng = array('publish' => 1); }else { $lng = array('publish' => 0); }
       $this->Banner_model->update($uid,$lng);
       echo 'true|Status Changed...!';
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'banner_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['array'] = array('','');
        $data['position'] = position();
        $data['menu'] = $this->menu->combo();
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
        $this->table->set_heading('#','No', 'Name', 'Position', 'Image', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url('banner/getdatatable');
            
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
           if ( $this->cek_relation($cek[$i]) == TRUE ) 
           {
              $img = $this->Banner_model->get_by_id($cek[$i])->row();
              $img = $img->image;
              if ($img){ $img = "./images/banner/".$img; unlink("$img"); }

              $this->Banner_model->delete($cek[$i]); 
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
           $this->Banner_model->delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully soft removed..!";
       }
       else
       {
        if ( $this->cek_relation($uid) == TRUE )
        {
           $img = $this->Banner_model->get_banner_by_id($uid)->row();
           $img = $img->image;
           if ($img){ $img = "./images/banner/".$img; unlink("$img"); }

           $this->Banner_model->delete($uid);
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
//        $product = $this->product->cek_relation($id, $this->title);
//        if ($product == TRUE) { return TRUE; } else { return FALSE; }
        return TRUE;
    }

    function add_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'banner_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('banner/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tname', 'Banner Name', 'required||maxlength[100]|callback_valid_banner');
        $this->form_validation->set_rules('cposition', 'Position Status', 'required');
        $this->form_validation->set_rules('cmenu', 'Menu', 'required');
        $this->form_validation->set_rules('turl', 'Url', 'required');
        $this->form_validation->set_rules('twidth', 'Width', 'required|numeric');
        $this->form_validation->set_rules('theight', 'Height', 'required|numeric');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/banner/';
            $config['file_name'] = split_space($this->input->post('tname'));
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = true;
            $config['max_size']	= '10000';
            $config['max_width']  = '30000';
            $config['max_height']  = '30000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);
//
            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $info['file_name'] = null;
                $data['error'] = $this->upload->display_errors();
                $banner = array('name' => $this->input->post('tname'), 'url' => $this->input->post('turl'),
                                'width' => $this->input->post('twidth'), 'height' => $this->input->post('theight'),
                                'position' => $this->input->post('cposition'),
                                'menu' => split_array($this->input->post('cmenu')),
                                'image' => null, 'created' => date('Y-m-d H:i:s'));
            }
            else
            {
                $info = $this->upload->data();
                $banner = array('name' => $this->input->post('tname'), 'url' => $this->input->post('turl'),
                                'width' => $this->input->post('twidth'), 'height' => $this->input->post('theight'),
                                'position' => $this->input->post('cposition'),
                                'menu' => split_array($this->input->post('cmenu')),
                                'image' => $info['file_name'], 'created' => date('Y-m-d H:i:s'));
            }

            $this->Banner_model->add($banner);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
//            redirect($this->title);
            
            if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
            else { echo 'true|'.$this->title.' successfully saved..!|'.base_url().'images/banner/'.$info['file_name']; }
            
          //  echo 'true';
        }
        else{ echo "error|".validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $banner = $this->Banner_model->get_by_id($uid)->row();
	$this->session->set_userdata('langid', $banner->id);
//        $this->load->view('banner_update', $data);
        
        echo $uid.'|'.$banner->name.'|'.$banner->position.'|'.$banner->url.'|'.
             base_url().'images/banner/'.$banner->image.'|'.$banner->width.'|'.$banner->height.'|'.
             $banner->menu;
    }


    public function valid_banner($name)
    {
        if ($this->Banner_model->valid('name',$name) == FALSE)
        {
            $this->form_validation->set_message('valid_banner', "This $this->title is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validation_banner($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->Banner_model->validating('name',$name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_banner', 'This banner is already registered!');
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
        $data['main_view'] = 'banner_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('banner/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tname', 'Banner Name', 'required||maxlength[100]|callback_validating_banner');
        $this->form_validation->set_rules('cposition', 'Position Status', 'required');
        $this->form_validation->set_rules('cmenu', 'Menu', 'required');
        $this->form_validation->set_rules('turl', 'Url', 'required');
        $this->form_validation->set_rules('twidth', 'Width', 'required|numeric');
        $this->form_validation->set_rules('theight', 'Height', 'required|numeric');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/banner/';
            $config['file_name'] = split_space($this->input->post('tname'));
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = true;
            $config['max_size']	= '10000';
            $config['max_width']  = '30000';
            $config['max_height']  = '30000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $info['file_name'] = null;
                $data['error'] = $this->upload->display_errors();
                $banner = array('name' => $this->input->post('tname'), 'url' => $this->input->post('turl'),
                                'width' => $this->input->post('twidth'), 'height' => $this->input->post('theight'),
                                'position' => $this->input->post('cposition'),
                                'menu' => split_array($this->input->post('cmenu')),
                                'created' => date('Y-m-d H:i:s'));
            }
            else
            {
                $this->remove_image($this->session->userdata('langid'));
                $info = $this->upload->data();
                $banner = array('name' => $this->input->post('tname'), 'url' => $this->input->post('turl'),
                                'width' => $this->input->post('twidth'), 'height' => $this->input->post('theight'),
                                'position' => $this->input->post('cposition'),
                                'menu' => split_array($this->input->post('cmenu')),
                                'image' => $info['file_name'], 'created' => date('Y-m-d H:i:s'));
            }

	    $this->Banner_model->update($this->session->userdata('langid'), $banner);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            
            if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
            else { echo 'true|Data successfully saved..!|'.base_url().'images/banner/'.$info['file_name']; }
            
        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function remove_image($uid)
    {
       $img = $this->Banner_model->get_by_id($uid)->row();
       $img = $img->image;
       if ($img){ $img = "./images/banner/".$img; unlink("$img"); } 
    }

}

?>