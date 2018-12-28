<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bank extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Bank_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));

    }

    private $properti, $modul, $title;

    function index()
    {
       $this->get_last_bank(); 
    }
    
    public function getdatatable($search=null)
    {
        if(!$search){ $result = $this->Bank_model->get_last($this->modul['limit'])->result(); }
        
        if ($result){
	foreach($result as $res)
	{   
	   $output[] = array ($res->id, $res->acc_name, $res->acc_no, $res->acc_bank, $res->currency,
                              $res->created, $res->updated, $res->deleted);
	}
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($output))
            ->_display();
            exit; 
        }
    }

    function get_last_bank()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'bank_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));
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
        $this->table->set_heading('#','No', 'Currency', 'Name', 'Account', 'Action');

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
           if ( $this->cek_relation($cek[$i]) == TRUE ) 
           {
              $this->Bank_model->delete($cek[$i]); 
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
           $this->Bank_model->delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully soft removed..!";
       }
       else
       {
        if ( $this->cek_relation($uid) == TRUE )
        {
           $this->Bank_model->force_delete($uid);
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
        $data['main_view'] = 'bank_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('bank/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tname', 'Account Name', 'required');
        $this->form_validation->set_rules('tno', 'Account No', 'required|callback_valid_bank');
        $this->form_validation->set_rules('tbank', 'Bank Description', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $bank = array('acc_name' => strtolower($this->input->post('tname')),
                          'currency' => 'IDR',
                          'acc_no' => $this->input->post('tno'), 
                          'acc_bank' => $this->input->post('tbank'), 'created' => date('Y-m-d H:i:s'));

            $this->Bank_model->add($bank);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
            
            echo 'true|Data successfully saved..!';
        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $bank = $this->Bank_model->get_by_id($uid)->row_array();
	$this->session->set_userdata('langid', $bank['id']);

        echo implode("|", $bank);
    }


    public function valid_bank($name)
    {
        if ($this->Bank_model->valid('acc_no',$name) == FALSE)
        {
            $this->form_validation->set_message('valid_bank', "This $this->title is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validation_bank($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->Bank_model->validating('acc_no',$name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation_bank', 'This bank is already registered!');
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
        $data['main_view'] = 'bank_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('bank/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tname', 'Account Name', 'required');
        $this->form_validation->set_rules('tno', 'Account No', 'required|callback_validation_bank');
        $this->form_validation->set_rules('tbank', 'Bank Description', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {            
            $bank = array('acc_name' => strtolower($this->input->post('tname')),
                          'acc_no' => $this->input->post('tno'), 
                          'acc_bank' => $this->input->post('tbank'));

	    $this->Bank_model->update($this->session->userdata('langid'), $bank);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            
            echo 'true|Data successfully saved..!';
        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }

}

?>