<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Discount extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Discount_model', 'model', TRUE);

        $this->properti = $this->property->get();
//        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->agent = new Agent_lib();
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token'); 
    }

    private $properti, $modul, $title;
    private $agent;

    function index()
    {
       $this->get_last();
    }
    
    // api calculate
    function calculate(){
        
        $datas = (array)json_decode(file_get_contents('php://input'));
        
        $amount = $datas['amount'];
        $payment = $datas['payment'];
        $date = date('Y-m-d');
        
        $error = null;
        $result = 0;
        $nominal = 0;
        
        if ($payment != null && $amount != null){ 
           $result = floatval($this->model->get_discount($amount,$date,$payment));
           $nominal = floatval($result/100*$amount);
        }else{ $error = "Invalid JSON Format"; }
                
        $response = array('result' => $result, 'amount' => $nominal, 'error' => $error); 
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;
    }
    
    public function getdatatable($search=null,$end='null',$type='null',$status='null')
    {
        $this->model->cek_discount(date('Y-m-d'));
        
        if(!$search){ $result = $this->model->get_last($this->modul['limit'])->result(); }
        else{ $result = $this->model->search($end,$type,$status)->result(); }
        
        if ($result){
	foreach($result as $res)
	{
	   $output[] = array ($res->id, $res->name, tglin($res->start), tglin($res->end), $res->type,  idr_format($res->minimum),
                              $res->percentage, $res->payment_type, $res->status);
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
       $val = $this->model->get_by_id($uid)->row();
       if ($val->status == 0){ 
           $lng = array('status' => 1); }else { $lng = array('status' => 0); }
       $this->model->update($uid,$lng);
       echo 'true|Status Changed...!';
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }
    
    function get_last()
    {   
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'discount_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['form_action_report'] = site_url($this->title.'/report_process');
        $data['link'] = array( 'link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')) );

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
        $this->table->set_heading('#','No', 'Name', 'Period', 'Type', 'Payment Type', 'Minimum Order', '%', 'Action');

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
           $this->model->delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully soft removed..!";
       }
       else
       {
        if ( $this->cek_relation($uid) == TRUE )
        {
           $this->model->force_delete($uid);
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
            
        $start = picker_between_split($this->input->post('tdates'), 0);
        $end   = picker_between_split($this->input->post('tdates'), 1);    
            
	// Form validation
        $this->form_validation->set_rules('tname', 'Name', 'required|callback_valid_discount['.$end.']');
        $this->form_validation->set_rules('tdates', 'Period', 'required');
        $this->form_validation->set_rules('ctype', 'Type', 'required');
        $this->form_validation->set_rules('cpaymenttype', 'Payment Type', 'required');
        $this->form_validation->set_rules('tminorder', 'Min Order', 'required|numeric');
        $this->form_validation->set_rules('tpercent', 'Percentage Value', 'required|numeric');

        if ($this->form_validation->run($this) == TRUE)
        {
            
            $model = array('name' => strtoupper($this->input->post('tname')),
                           'start' => $start, 'end' => $end,
                           'type' => $this->input->post('ctype'),
                           'payment_type' => $this->input->post('cpaymenttype'),
                           'minimum' => $this->input->post('tminorder'),
                           'percentage' => $this->input->post('tpercent'),
                           'created' => date('Y-m-d H:i:s'));
            
            $this->model->add($model);
            echo 'true|'.$this->title.' successfully saved..!|';
        }
        else{ echo "error|".validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $category = $this->model->get_by_id($uid)->row();
	$this->session->set_userdata('langid', $category->id);        
        echo $uid.'|'.$category->name.'|'.$category->start.'|'.$category->end.'|'.$category->type.'|'.$category->minimum.'|'.$category->percentage.'|'.$category->payment_type.'|'.$category->status;
    }

    public function valid_discount($name,$end)
    {
        $minorder = $this->input->post('tminorder');
        $type = $this->input->post('ctype');
        
        if ($this->model->valid_discount($end, $minorder, $type) == FALSE)
        {
            $this->form_validation->set_message('valid_discount', "This $this->title is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validation_discount($name,$end)
    {
        $minorder = $this->input->post('tminorder');
        $type = $this->input->post('ctype');
	$id = $this->session->userdata('langid');
	if ($this->model->validating_discount($end, $minorder, $type, $id) == FALSE)
        {
            $this->form_validation->set_message('validation_discount', "This $this->title is already registered!");
            return FALSE;
        }
        else { return TRUE; }
    }

    // Fungsi update untuk mengupdate db
    function update_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

	// Form validation
        $this->form_validation->set_rules('tname', 'Name', 'required|callback_validation_discount['.$this->input->post('tend').']');
        $this->form_validation->set_rules('ctype', 'Type', 'required');
        $this->form_validation->set_rules('tminorder', 'Min Order', 'required|numeric');
        $this->form_validation->set_rules('tpercent', 'Percentage Value', 'required|numeric');

        if ($this->form_validation->run($this) == TRUE)
        {   
            $model = array('name' => strtoupper($this->input->post('tname')),
                           'start' => $this->input->post('tstart'), 'end' => $this->input->post('tend'),
                           'type' => $this->input->post('ctype'),
                           'minimum' => $this->input->post('tminorder'),
                           'percentage' => $this->input->post('tpercent'));
            
	    $this->model->update($this->session->userdata('langid'), $model);            
            echo "true|One $this->title has successfully updated!";
        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function report_process()
    {
        $this->acl->otentikasi2($this->title);
        $data['title'] = $this->properti['name'].' | Report '.ucwords($this->modul['title']);

        $data['rundate'] = tglin(date('Y-m-d'));
        $data['log'] = $this->session->userdata('log');

        $model = $this->input->post('cmodel');
        $material = $this->input->post('cmaterial');
//        Property Details
        $data['company'] = $this->properti['name'];
        $data['reports'] = $this->model->report($model, $material)->result();
        $this->load->view('material_report', $data);
    }

}

?>