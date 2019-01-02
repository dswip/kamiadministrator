<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shiprate extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Shiprate_model', 'model', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->city = new City_lib();
        $this->shiprate = new Shiprate_lib();
        $this->district = new District_lib();
    }

    private $properti, $modul, $title, $city, $shiprate, $district;

    function index()
    {
       $this->get_last(); 
    }
    
    // ajax
    function combo_district($city,$type=null)
    { echo $this->district->combo_district_ajax($city,$type);  }
    
    public function getdatatable($search=null,$city='null',$courier='null')
    {
        if(!$search){ $result = $this->model->get_last($this->modul['limit'])->result(); }
        else { $result = $this->model->search($city,$courier)->result(); }
        
        if ($result){
	foreach($result as $res)
	{
	   $output[] = array ($res->id, $res->courier, $this->city->get_name($res->city), strtolower($res->type), idr_format($res->rate),
                              $this->district->get_name($res->district));
	}
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($output, 128))
            ->_display();
            exit; 
        }
    }

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'shiprate_view';
        $data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_import'] = site_url($this->title.'/import');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));
	// ---------------------------------------- //
        
        $data['city'] = $this->city->combo_city_db();
        $data['district'] = $this->district->combo_district_db();
        $data['courrier'] = $this->shiprate->combo_courier();
 
        $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = "<li><span><b>";
        $config['cur_tag_close'] = "</b></span></li>";

        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('#','No', 'Courrier', 'Type', 'Destination', 'District', 'Rate', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url('shiprate/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Account_model->get_by_id($uid)->row();
       if ($val->publish == 0){ $lng = array('publish' => 1); }else { $lng = array('publish' => 0); }
       $this->Account_model->update($uid,$lng);
       echo 'true|Status Changed...!';
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
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
              $img = $this->Account_model->get_account_by_id($cek[$i])->row();
              $img = $img->image;
              if ($img){ $img = "./images/account/".$img; unlink("$img"); }

              $this->Account_model->delete($cek[$i]); 
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

    function delete($uid,$type='hard')
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
        if ($type == 'soft'){
           $this->model->delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully soft removed..!";
       }
       else
       {
           $this->model->force_delete($uid);
           echo "true|1 $this->title successfully removed..!";
       }
       }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }

    function add_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'account_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('account/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('ccity', 'City', 'required');
        $this->form_validation->set_rules('cdistrict', 'District', 'required|callback_valid_district['.$this->input->post('ctype').']');
        $this->form_validation->set_rules('ccourrier', 'Courrier', '');
        $this->form_validation->set_rules('ctype', 'Rate Type', 'required');
        $this->form_validation->set_rules('trate', 'Rate', 'required|numeric');

        if ($this->form_validation->run($this) == TRUE)
        {
            if ($this->input->post('tcourrier')){$kurir = $this->input->post('tcourrier');}
            else{ $kurir = $this->input->post('ccourrier'); }
            
            $shiprate = array('courier' => strtoupper($kurir),
                              'city' => $this->input->post('ccity'),
                              'district' => $this->input->post('cdistrict'),
                              'type' => $this->input->post('ctype'),
                              'rate' => $this->input->post('trate'),
                              'created' => date('Y-m-d H:i:s'));

            $this->model->add($shiprate);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
            
            echo 'true|Data successfully saved..!';
        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null,$type='get')
    {        
        $shiprate = $this->model->get_by_id($uid)->row();
        $this->session->set_userdata('langid', $uid);    
        
        echo $shiprate->id.'|'.$shiprate->courier.'|'.$shiprate->city.'|'.$shiprate->district.'|'.$shiprate->type.'|'.$shiprate->rate.'|'. $this->district->get_name($shiprate->district);
    }    

    public function valid_district($district,$type)
    {
        if ($this->input->post('tcourrier')){$kurir = $this->input->post('tcourrier');}
        else{ $kurir = $this->input->post('ccourrier'); }
        
        if ($this->model->valid_district($district,$kurir,$type) == FALSE)
        {
            $this->form_validation->set_message('valid_district', "This $this->title is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    public function validating_district($district,$type)
    {
        $id = $this->session->userdata('langid');
        
        if ($this->input->post('tcourrier')){$kurir = $this->input->post('tcourrier');}
        else{ $kurir = $this->input->post('ccourrier'); }
        
        if ($this->model->validating_district($id,$district,$kurir,$type) == FALSE)
        {
            $this->form_validation->set_message('validating_district', "This $this->title is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    // Fungsi update untuk mengupdate db
    function update_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

	// Form validation
        $this->form_validation->set_rules('ccity', 'City', 'required');
        $this->form_validation->set_rules('cdistrictupdate', 'District', 'required|callback_validating_district['.$this->input->post('ctype').']');
        $this->form_validation->set_rules('ccourrier', 'Courrier', '');
        $this->form_validation->set_rules('ctype', 'Rate Type', 'required');
        $this->form_validation->set_rules('trate', 'Rate', 'required|numeric');
        
        if ($this->form_validation->run($this) == TRUE)
        {
            if ($this->input->post('tcourrier')){$kurir = $this->input->post('tcourrier');}
            else{ $kurir = $this->input->post('ccourrier'); }
     
            $shiprate = array('courier' => strtoupper($kurir),
                              'city' => $this->input->post('ccity'),
                              'district' => $this->input->post('cdistrictupdate'),
                              'type' => $this->input->post('ctype'),
                              'rate' => $this->input->post('trate'));
            
	    $this->model->update($this->session->userdata('langid'), $shiprate);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            
            echo 'true|Data successfully saved..!';
            
        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function remove_image($uid)
    {
       $img = $this->Account_model->get_account_by_id($uid)->row();
       $img = $img->image;
       if ($img){ $img = "./images/account/".$img; unlink("$img"); } 
    }
    
    function report()
    {
        $this->acl->otentikasi2($this->title);
        $data['title'] = $this->properti['name'].' | Report '.ucwords($this->modul['title']);

        $data['rundate'] = tglin(date('Y-m-d'));
        $data['log'] = $this->session->userdata('log');

//        Property Details
        $data['company'] = $this->properti['name'];
        $data['reports'] = $this->Account_model->report()->result();
        
        $this->load->view('account_report', $data);
    }
    
    function import()
    {
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'attendance_import';
	$data['form_action_import'] = site_url($this->title.'/import_process');
        $data['error'] = null;
	
//        $this->form_validation->set_rules('cmonth', 'Period Month', 'required|callback_valid_period['.$this->input->post('tyear').']');
        $this->form_validation->set_rules('cparent', 'Account Category', 'required|callback_valid_year');
        $this->form_validation->set_rules('userfile', 'Import File', '');
        
        if ($this->form_validation->run($this) == TRUE)
        {
             // ==================== upload ========================
            
            $config['upload_path']   = './uploads/';
            $config['file_name']     = 'account';
            $config['allowed_types'] = '*';
//            $config['allowed_types'] = 'csv';
            $config['overwrite']     = TRUE;
            $config['max_size']	     = '1000';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            
            if ( !$this->upload->do_upload("userfile"))
            { 
               $data['error'] = $this->upload->display_errors(); 
               $this->session->set_flashdata('message', "Error imported!");
               echo 'error|'.$data['error'];
            }
            else
            { 
               // success page 
              $this->import_account($this->input->post('cparent'),$config['file_name'].'.csv');
              $info = $this->upload->data(); 
              $this->session->set_flashdata('message', "One $this->title data successfully imported!");
              echo 'true|CSV Successful Uploaded';
            }                
        }
        else { $this->session->set_flashdata('message', "Error imported!"); echo 'error|'.validation_errors(); }
       // redirect($this->title);
        
    }
    
    private function import_account($parent,$filename)
    {
        $stts = null;
        $this->load->helper('file');
//        $csvreader = new CSVReader();
        $csvreader = $this->load->library('csvreader');
        $filename = './uploads/'.$filename;
        
        $result = $csvreader->parse_file($filename);
        
        foreach($result as $res)
        {
           if(isset($res['CODE']) && isset($res['NAME']))
           {
              if ($this->valid_code($res['CODE']) == TRUE)
              {
                $account = array('name' => $res['NAME'],
                             'code' => $res['CODE'],
                             'category' => $this->account->get_category($parent),
                             'parent_id' => $parent,
                             'description' => $res['NAME'],
                             'publish' => 1,
                             'created' => date('Y-m-d H:i:s'));
            
                $this->Account_model->add($account);
              }
           }              
        }
    }

}

?>