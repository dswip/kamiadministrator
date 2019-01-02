<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class City extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('City_model', '', TRUE);

        $this->properti = $this->property->get();
//        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token'); 

    }

    private $properti, $modul, $title;
    
    // --- json -------
    
    function get_city(){
        
        $result = $this->City_model->get_kabupaten()->result();
        
        foreach($result as $res){
            $output[] = array ("id" => $res->id, 'id_prov' => $res->id_prov, "nama" => $res->nama);
        }
        $response['content'] = $output;
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit; 
    }
    
    function get_district(){
        
        $datas = (array)json_decode(file_get_contents('php://input'));
        $cityid = $datas['city'];
        
        $result = $this->City_model->get_kecamatan($cityid)->result();
        
        foreach($result as $res){
            $output[] = array ("id" => $res->id, 'id_kabupaten' => $res->id_kabupaten, "nama" => $res->nama);
        }
        $response['content'] = $output;
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit; 
    }

    function index()
    {
      $this->load->helper('editor');
      editor();
      $this->load->view('welcome_message');
    }


    function get_last_city()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'city_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['link'] = array('link_back' => anchor('main/','<span>back</span>', array('class' => 'back')));
        
	$uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

	// ---------------------------------------- //
        $citys = $this->City_model->get_last_city($this->modul['limit'], $offset)->result();
        $num_rows = $this->City_model->count_all_num_rows();

        if ($num_rows > 0)
        {
	    $config['base_url'] = site_url($this->title.'/get_last_city');
            $config['total_rows'] = $num_rows;
            $config['per_page'] = $this->modul['limit'];
            $config['uri_segment'] = $uri_segment;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links(); //array menampilkan link untuk pagination.
            // akhir dari config untuk pagination

            // library HTML table untuk membuat template table class zebra
            $tmpl = array('table_open' => '<table cellpadding="2" cellspacing="1" class="tablemaster">');

            $this->table->set_template($tmpl);
            $this->table->set_empty("&nbsp;");

            //Set heading untuk table
            $this->table->set_heading('#','No', 'Name', 'Action');

            $i = 0 + $offset;
            foreach ($citys as $city)
            {
                $datax = array('name'=> 'cek[]','id'=> 'cek'.$i,'value'=> $city->id,'checked'=> FALSE, 'style'=> 'margin:0px');
                
                $this->table->add_row
                (
                    form_checkbox($datax), ++$i, $city->name,
                    anchor($this->title.'/update/'.$city->id,'<span>details</span>',array('class' => 'update', 'title' => '')).' '.
                    anchor($this->title.'/delete/'.$city->id,'<span>delete</span>',array('class'=> 'delete', 'title' => 'delete' ,'onclick'=>"return confirm('Are you sure you will delete this data?')"))
                );
            }

            $data['table'] = $this->table->generate();
        }
        else
        {
            $data['message'] = "No $this->title data was found!";
        }

        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }

    function delete($uid)
    {
        $this->acl->otentikasi_admin($this->title);
        $this->City_model->delete($uid); // memanggil model untuk mendelete data
        $this->session->set_flashdata('message', "1 $this->title successfully removed..!"); // set flash data message dengan session
        redirect($this->title);
    }

    function add_process()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'city_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('city/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tname', 'Name', 'required|callback_valid_city');

        if ($this->form_validation->run($this) == TRUE)
        {
            $city = array('name' => $this->input->post('tname'));
            
            $this->City_model->add($city);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
//            redirect($this->title);
            echo 'true';
        }
        else
        {
//               $this->load->view('template', $data);
            echo validation_errors();
        }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid)
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'city_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('city/','<span>back</span>', array('class' => 'back')));

        $city = $this->City_model->get_city_by_id($uid)->row();

        $data['default']['name'] = $city->name;

	$this->session->set_userdata('langid', $city->id);
        $this->load->view('city_update', $data);
    }


    public function valid_city($name)
    {
        if ($this->City_model->valid_city($name) == FALSE)
        {
            $this->form_validation->set_message('valid_city', "This $this->title is already registered.!");
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    function validation_city($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->City_model->validating_city($name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_city', 'This city is already registered!');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    // Fungsi update untuk mengupdate db
    function update_process()
    {
        $this->acl->otentikasi2($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'city_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('city/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tname', 'Name', 'required|max_length[100]|callback_validation_city');

        if ($this->form_validation->run($this) == TRUE)
        {
            $city = array('name' => $this->input->post('tname'));

	    $this->City_model->update($this->session->userdata('langid'), $city);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            redirect($this->title.'/update/'.$this->session->userdata('langid'));
            $this->session->unset_userdata('langid');

        }
        else
        {
            $this->load->view('city_update', $data);
        }
    }

}

?>