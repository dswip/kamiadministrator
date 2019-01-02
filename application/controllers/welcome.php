<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
    //    $this->load->model('Category_model', '', TRUE);

      //  $this->properti = $this->property->get();
       // $this->acl->otentikasi();

      /*  $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->product = new Product_lib();
        $this->category = new Categoryproduct_lib();
        $this->model = new Categorys(); */

    }

    private $properti, $modul, $title;
    private $product,$category,$model;

    function index()
    {
      // $this->get_last_category(); 
      echo 'im welcome';
    }
    
    function chart()
    {
        $this->db->select('playerid, score');
        $this->db->from('score'); 
        $result = $this->db->get()->result(); 
        
        print json_encode($result); 
    }
    
    public function getdatatable($search=null)
    {
        if(!$search){ $result = $this->Category_model->get_last_category($this->modul['limit'])->result(); }
        
        if ($result){
	foreach($result as $res)
	{
	   $output[] = array ($res->id, $res->name, $this->category->get_name($res->parent_id), base_url().'images/category/'.$res->image, $res->publish);
	}
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($output, JSON_PRETTY_PRINT))
            ->_display();
            exit; 
        }
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Category_model->get_by_id($uid)->row();
       if ($val->publish == 0){ $lng = array('publish' => 1); }else { $lng = array('publish' => 0); }
       $this->Category_model->update($uid,$lng);
       echo 'true|Status Changed...!';
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }

    function get_last_category()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'category_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['parent'] = $this->category->combo();
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
        $this->table->set_heading('#','No', 'Name', 'Parent', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url('category/getdatatable');
            
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
              $img = $this->Category_model->get_by_id($cek[$i])->row();
              $img = $img->image;
              if ($img){ $img = "./images/category/".$img; unlink("$img"); }

              $this->Category_model->delete($cek[$i]); 
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
           $this->Category_model->delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully soft removed..!";
       }
       else
       {
        if ( $this->cek_relation($uid) == TRUE )
        {
           $img = $this->Category_model->get_by_id($uid)->row();
           $img = $img->image;
           if ($img){ $img = "./images/category/".$img; unlink("$img"); }

           $this->Category_model->delete($uid);
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
        $data['main_view'] = 'category_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('category/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tname', 'Name', 'required|callback_valid_category');
        $this->form_validation->set_rules('cparent', 'Parent Category', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/category/';
            $config['file_name'] = $this->input->post('tname');
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = true;
            $config['max_size']	= '1000';
            $config['max_width']  = '3000';
            $config['max_height']  = '3000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);
//
            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $info['file_name'] = null;
                $data['error'] = $this->upload->display_errors();
                $category = array('name' => strtolower($this->input->post('tname')),
                                  'parent_id' => $this->input->post('cparent'), 
                                  'image' => null, 'created' => date('Y-m-d H:i:s'));
            }
            else
            {
                $info = $this->upload->data();
                $category = array('name' => strtolower($this->input->post('tname')),
                                  'parent_id' => $this->input->post('cparent'), 
                                  'image' => $info['file_name'], 'created' => date('Y-m-d H:i:s'));
            }

            $this->Category_model->add($category);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
//            redirect($this->title);
            
            if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
            else { echo 'true|'.$this->title.' successfully saved..!|'.base_url().'images/category/'.$info['file_name']; }
            
          //  echo 'true';
        }
        else{ echo "error|".validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $data['parent'] = $this->category->combo_update($uid);
        $category = $this->Category_model->get_by_id($uid)->row();
        $data['default']['name'] = $category->name;
        $data['default']['parent'] = $category->parent_id;
        $data['default']['image'] = base_url().'images/category/'.$category->image;
//
	$this->session->set_userdata('langid', $category->id);
//        $this->load->view('category_update', $data);
        
        echo $uid.'|'.$category->name.'|'.$category->parent_id.'|'.base_url().'images/category/'.$category->image;
    }


    public function valid_category($name)
    {
        if ($this->Category_model->valid('name',$name) == FALSE)
        {
            $this->form_validation->set_message('valid_category', "This $this->title is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validation_category($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->Category_model->validating('name',$name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_category', 'This category is already registered!');
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
        $data['main_view'] = 'category_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('category/','<span>back</span>', array('class' => 'back')));
        $data['parent'] = $this->category->combo_update($this->session->userdata('langid'));

	// Form validation
        $this->form_validation->set_rules('tname_update', 'Name', 'required|max_length[100]|callback_validation_category');
        $this->form_validation->set_rules('cparent_update', 'Parent Category', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/category/';
            $config['file_name'] = $this->input->post('tname_update');
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = true;
            $config['max_size']	= '10000';
            $config['max_width']  = '10000';
            $config['max_height']  = '10000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile_update")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();
                $category = array('name' => strtolower($this->input->post('tname_update')),'parent_id' => $this->input->post('cparent_update'));
                $img = null;
            }
            else
            {
                $info = $this->upload->data();
                $category = array('name' => strtolower($this->input->post('tname_update')),'parent_id' => $this->input->post('cparent_update'), 'image' => $info['file_name']);
                $img = base_url().'images/category/'.$info['file_name'];
            }

	    $this->Category_model->update($this->session->userdata('langid'), $category);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            
            if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
            else { echo 'true|Data successfully saved..!|'.base_url().'images/category/'.$info['file_name']; }
            
        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function remove_image($uid)
    {
       $img = $this->Category_model->get_by_id($uid)->row();
       $img = $img->image;
       if ($img){ $img = "./images/category/".$img; unlink("$img"); } 
    }

}

?>
