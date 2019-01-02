<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('property');
        $this->load->library('user_agent');
        $this->properti = $this->property->get();
        
        $this->period = new Period_lib();
        $this->period = $this->period->get();
        
        $this->acl->otentikasi();
    }

    var $title = 'main';
    var $limit = null;
    private $properti,$period;

    function index()
    {       
	$this->main_panel();
        
//        $this->load->library('email');
//
//        $this->email->from('info@dswip.com', 'Dswip');
//        $this->email->to('sanjaya.kiran@gmail.com'); 
////        $this->email->cc('another@another-example.com'); 
//
//        $this->email->subject('Email Test');
//        $this->email->message('Testing the email class.');	
//
//        $this->email->send();
//
//        echo $this->email->print_debugger();
    }
    

    private function user_agent()
    {
        $agent=null;
        if ($this->agent->is_browser()){  $agent = $this->agent->browser().' '.$this->agent->version();}
        elseif ($this->agent->is_robot()){ $agent = $this->agent->robot(); }
        elseif ($this->agent->is_mobile()){ $agent = $this->agent->mobile(); }
        else{ $agent = 'Unidentified User Agent'; }
        return $agent." - ".$this->agent->platform();
    }
    
    function main_panel()
    {
       $data['name'] = $this->properti['name'];
       $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Main Panel');
       $data['h2title'] = "Main Panel";

       $data['waktu'] = tgleng(date('Y-m-d')).' - '.waktuindo().' WIB';
       $data['user_agent'] = $this->user_agent();
       $data['main_view'] = 'main/main_view';
       $data['month'] = get_month($this->period->month);
       $data['year'] = $this->period->year;
       $this->load->view('template', $data);

    }

    function article()
    {
       otentikasi1($this->title);
       $property = $this->Property_model->get_last_propery()->row();
       $data['name'] = $property->name;
       $data['title'] = propertyname('Article');
       $data['h2title'] = "Article Panel";

       $data['waktu'] = tgleng(date('Y-m-d')).' - '.waktuindo().' WIB';
       $data['main_view'] = 'main/article';
       $this->load->view('template', $data);
    }
    
}

?>