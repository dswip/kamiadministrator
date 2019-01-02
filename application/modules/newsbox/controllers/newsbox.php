<?php

class Newsbox extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Newsbox_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->lang = $this->load->library('language');
        $this->category = $this->load->library('article_category');

        $this->load->helper('ckeditor');
        $this->load->helper('editor');

    }
    
    private $properti, $modul, $title;
    private $lang, $category;
    
    function index()
    {
        $this->update();
    }

    function update()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Update '.$this->modul['title'];
        $data['main_view'] = 'article_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

	$data['ckeditor'] = editor();
        
        $article = $this->Newsbox_model->get_news()->row();
       
        $data['default']['title'] = $article->title;
        $data['desc'] = $article->text;
	
	$this->session->set_userdata('newsid', $article->id);
    
       $this->load->view('template', $data);
    }
    
    // Fungsi update untuk mengupdate db
    function update_process()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Update '.$this->modul['title'];
        $data['main_view'] = 'article_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['link'] = array('link_back' => anchor($this->title,'<span>back</span>', array('class' => 'back')));

	$data['ckeditor'] = editor();
        
        $this->form_validation->set_rules('ttitle', 'Newsbox Title', 'required||maxlength[100]');
        $this->form_validation->set_rules('tdesc', 'Newsbox Content', '');
	
        if ($this->form_validation->run() == TRUE)
        {
                $article = array('title' => $this->input->post('ttitle'), 'text' => $this->input->post('tdesc'));

            $this->Newsbox_model->update($this->session->userdata('newsid'), $article);
            $this->session->set_flashdata('message', "One data $this->title successfully saved!");
            redirect($this->title.'/update/'.$this->session->userdata('articleid'));
            $this->session->unset_userdata('articleid');
            
        }
        else { $this->load->view('template', $data); }
    }
    
}

?>