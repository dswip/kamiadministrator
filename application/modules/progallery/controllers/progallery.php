<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Progallery extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Progallery_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));

        $this->category = $this->load->library('categoryproduct');
        $this->load->helper('ckeditor');
        $this->load->helper('editor');
    }

    private $properti, $modul, $title;
    private $category;

    function index()
    { $this->get_gallery(null); }


    function get_gallery($pid=null)
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'].' PRO-0'.$pid;
        $data['main_view'] = 'progallery_view';
	$data['form_action'] = site_url($this->title.'/add_process/'.$pid);
        $data['link'] = array('link_back' => anchor('product','<span>back</span>', array('class' => 'back')));
        $data['pid'] = $pid;
        $data['ckeditor'] = editor();

        $progallerys = $this->Progallery_model->get_last_progallery($pid)->result();

        $tmpl = array('table_open' => '<table class="tablemaster table table-bordered">');
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Product', 'Name', 'Thumb', 'Image', 'Action');

        $i = 0;
        foreach ($progallerys as $progallery)
        {
            $thumb_pro = array('src' => $progallery->thumbnail, 'class' => 'img-rounded', 'width' => '50', 'height' => '50');
            $img_pro = array('src' => $progallery->image, 'class' => 'img-rounded', 'width' => '75', 'height' => '75');

            $this->table->add_row
            (
                ++$i, 'PRO-0'.$progallery->product, $progallery->name, img($thumb_pro), img($img_pro),
                anchor($this->title.'/update/'.$progallery->id,'<span>details</span>',array('class' => 'edit', 'title' => '')).' '.
                anchor($this->title.'/delete/'.$progallery->id,'<span>delete</span>',array('class'=> 'delete', 'title' => 'delete' ,'onclick'=>"return confirm('Are you sure you will delete this data?')"))
            );
        }

        $data['table'] = $this->table->generate();

	$this->load->view('template', $data);
    }

    private function get_category($val)
    {
        switch ($val)
        {
            case "a": $val = 'Feature & Benefit'; break;
            case "b": $val = 'Interior & Exterior Finish Option'; break;
            case "c": $val = 'Design Pattern & Grilles'; break;
            case "d": $val = 'Hardware & Accessoriess'; break;
        }
        return $val;
    }


    function delete($uid)
    {
        $this->acl->otentikasi_admin($this->title);
        $progallery = $this->Progallery_model->get_progallery_by_id($uid)->row();

        $this->Progallery_model->delete($uid);
        $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
        redirect($this->title.'/get_gallery/'.$progallery->product);
    }

    function add_process($pid=null)
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'progallery_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor($this->title.'/get_gallery/'.$pid,'<span>back</span>', array('class' => 'back')));

        $data['pid'] = $pid;

	// Form validation
        $this->form_validation->set_rules('tname', 'Colour Name', 'required|callback_valid_progallery['.$pid.']');
        $this->form_validation->set_rules('tthumb', 'Thumbnail', 'required');
        $this->form_validation->set_rules('timage', 'Image', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {                
            $progallery = array('product' => $pid, 'name' => $this->input->post('tname'), 'thumbnail' => $this->input->post('tthumb'), 'image' => $this->input->post('timage'));

            $this->Progallery_model->add($progallery);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
            redirect($this->title.'/get_gallery/'.$pid);
        }
        else
        { 
           $this->load->view('template', $data);
        }

    }

    
    function update($uid)
    {
        $this->acl->otentikasi2($this->title);
        $progallery = $this->Progallery_model->get_progallery_by_id($uid)->row();

        $data['h2title'] = $this->modul['title'].' PRO-0'.$progallery->product;
        $data['form_action'] = site_url($this->title.'/update_process/');
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['main_view'] = 'progallery_view';
        $data['link'] = array('link_back' => anchor($this->title.'/get_gallery/'.$progallery->product,'<span>back</span>', array('class' => 'back')));

        $data['pid'] = $progallery->product;
        $data['default']['name'] = $progallery->name;
        $data['default']['thumb'] = $progallery->thumbnail;
        $data['default']['image'] = $progallery->image;

        $this->session->set_userdata('curid', $progallery->id);
	$this->load->view('template', $data);
    }

        // Fungsi update untuk mengupdate db
    function update_process()
    {
        $this->acl->otentikasi3($this->title);
        $progallerys = $this->Progallery_model->get_progallery_by_id($this->session->userdata('curid'))->row();

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'progallery_view';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('progallery/update/'.$progallery->product,'<span>back</span>', array('class' => 'back')));

        $data['pid']      = $progallery->product;

	// Form validation
        $this->form_validation->set_rules('tname', 'Colour Name', 'required|callback_validation_progallery['.$progallery->product.']');
        $this->form_validation->set_rules('tthumb', 'Thumbnail', 'required');
        $this->form_validation->set_rules('timage', 'Image', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $progallery = array('name' => $this->input->post('tname'), 'thumbnail' => $this->input->post('tthumb'), 'image' => $this->input->post('timage'));
            
	    $this->Progallery_model->update($this->session->userdata('curid'), $progallery);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
            redirect($this->title.'/get_gallery/'.$progallerys->product);
            $this->session->unset_userdata('curid');
        }
        else
        { $this->load->view('template', $data); }
    }

    public function valid_progallery($category,$pid)
    {
        if ($pid != null)
        {
            if ($this->Progallery_model->valid_progallery($category,$pid) == FALSE)
            {
                $this->form_validation->set_message('valid_progallery', "This $this->title is already registered.!");
                return FALSE;
            }
            else { return TRUE; }
        }
        else { $this->form_validation->set_message('valid_progallery', "Invalid product Id..!"); }
    }

    function validation_progallery($category,$pid)
    {
	$id = $this->session->userdata('curid');
	if ($this->Progallery_model->validating_progallery($category,$pid,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_progallery', 'This progallery is already registered!');
            return FALSE;
        }
        else{ return TRUE; }
    }

}

?>