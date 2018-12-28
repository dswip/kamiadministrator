<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Payment_model', '', TRUE);

        $this->properti = $this->property->get();
        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));

    }

    private $properti, $modul, $title;

    function index()
    {
       $this->get_last(); 
    }
    
    public function getdatatable($search=null)
    {
        if(!$search){ $result = $this->Payment_model->get_last($this->modul['limit'])->result(); }
        
        if ($result){
	foreach($result as $res)
	{
	   $output[] = array ($res->id, $res->name, base_url().'images/payment/'.$res->image, $res->orders, $res->acc_no, $res->acc_name, $res->created, $res->updated, $res->deleted);
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
        $data['main_view'] = 'payment_view';
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
        $this->table->set_heading('#','No', '#', 'Name', 'Order', 'Account', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url('payment/getdatatable');
            
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
              $img = $this->Payment_model->get_payment_by_id($cek[$i])->row();
              $img = $img->image;
              if ($img){ $img = "./images/payment/".$img; unlink("$img"); }

              $this->Payment_model->delete($cek[$i]); 
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
           $this->Payment_model->delete($uid);
           $this->session->set_flashdata('message', "1 $this->title successfully removed..!");
           
           echo "true|1 $this->title successfully soft removed..!";
       }
       else
       {
        if ( $this->cek_relation($uid) == TRUE )
        {
           $img = $this->Payment_model->get_by_id($uid)->row();
           $img = $img->image;
           if ($img){ $img = "./images/payment/".$img; unlink("$img"); }

           $this->Payment_model->delete($uid);
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
        $data['main_view'] = 'payment_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('payment/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tname', 'Name', 'required|callback_valid_payment');
        $this->form_validation->set_rules('torder', 'Order', 'required|numeric');
        $this->form_validation->set_rules('taccno', 'Account No', '');
        $this->form_validation->set_rules('taccname', 'Account Name', '');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/payment/';
            $config['file_name'] = split_space($this->input->post('tname'));
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = true;
            $config['max_size']	= '10000';
            $config['max_width']  = '10000';
            $config['max_height']  = '10000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);
//
            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $info['file_name'] = null;
                $data['error'] = $this->upload->display_errors();
                $payment = array('name' => strtolower($this->input->post('tname')),
                                 'orders' => $this->input->post('torder'), 
                                 'acc_no' => $this->input->post('taccno'), 
                                 'acc_name' => $this->input->post('taccname'), 
                                 'image' => null, 'created' => date('Y-m-d H:i:s'));
            }
            else
            {
                $info = $this->upload->data();
                $payment = array('name' => strtolower($this->input->post('tname')), 
                                 'orders' => $this->input->post('torder'), 
                                 'acc_no' => $this->input->post('taccno'), 
                                 'acc_name' => $this->input->post('taccname'), 
                                 'image' => $info['file_name'], 'created' => date('Y-m-d H:i:s'));
            }

            $this->Payment_model->add($payment);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
//            redirect($this->title);
            
            if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
            else { echo 'true|'.$this->title.' successfully saved..!|'.base_url().'images/payment/'.$info['file_name']; }
            
          //  echo 'true';
        }
        else{ echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $payment = $this->Payment_model->get_by_id($uid)->row();
	$this->session->set_userdata('langid', $payment->id);
//        $this->load->view('payment_update', $data);
        echo $uid.'|'.$payment->name.'|'.$payment->orders.'|'.$payment->acc_no.'|'.$payment->acc_name.'|'.
             base_url().'images/payment/'.$payment->image;
    }


    public function valid_payment($name)
    {
        if ($this->Payment_model->valid('name',$name) == FALSE)
        {
            $this->form_validation->set_message('valid', "This $this->title is already registered.!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validation_payment($name)
    {
	$id = $this->session->userdata('langid');
	if ($this->Payment_model->validating('name',$name,$id) == FALSE)
        {
            $this->form_validation->set_message('validation', 'This payment is already registered!');
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
        $data['main_view'] = 'payment_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('payment/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tname', 'Name', 'required|max_length[100]|callback_validation_payment');
        $this->form_validation->set_rules('torder', 'Order', 'required|numeric');
        $this->form_validation->set_rules('taccno', 'Account No', '');
        $this->form_validation->set_rules('taccname', 'Account Name', '');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/payment/';
            $config['file_name'] = split_space($this->input->post('tname'));
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = true;
            $config['max_size']	= '10000';
            $config['max_width']  = '10000';
            $config['max_height']  = '10000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $data['error'] = $this->upload->display_errors();
                
                $payment = array('name' => strtolower($this->input->post('tname')),
                                 'orders' => $this->input->post('torder'), 
                                 'acc_no' => $this->input->post('taccno'), 
                                 'acc_name' => $this->input->post('taccname'));
                
                $img = null;
            }
            else
            {
                $info = $this->upload->data();
                $payment = array('name' => strtolower($this->input->post('tname')),
                                 'orders' => $this->input->post('torder'), 
                                 'acc_no' => $this->input->post('taccno'), 
                                 'acc_name' => $this->input->post('taccname'), 
                                 'image' => $info['file_name']);
                
                $img = base_url().'images/payment/'.$info['file_name'];
            }

	    $this->Payment_model->update($this->session->userdata('langid'), $payment);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            
            if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
            else { echo 'true|Data successfully saved..!|'.base_url().'images/payment/'.$info['file_name']; }
            
        }
        else{ echo 'error|'.validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function remove_image($uid)
    {
       $img = $this->Payment_model->get_payment_by_id($uid)->row();
       $img = $img->image;
       if ($img){ $img = "./images/payment/".$img; unlink("$img"); } 
    }

}

?>