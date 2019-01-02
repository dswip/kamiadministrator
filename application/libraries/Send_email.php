<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send_email extends Custom_Model {

    public function __construct()
    {
        // Do something with $params
        parent::__construct();
        
        $this->ci = & get_instance();
        $this->ci->load->library('property');
        
    }

    private $ci;
    private $property;
    
    public function send_many($to=null,$subject=null,$mess=null,$type='html')
    {
        $this->load->library('email');
        $this->property = $this->ci->property->get();

        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;

        $config['protocol']   = "smtp";
        $config['smtp_host']  = "mail.wamenak.com";
        $config['smtp_user']  = 'info@wamenak.com';
        $config['smtp_pass']  = 'wamenak2018';
        $config['smtp_port']  = '587';
        $config['charset']  = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = $type;

        $this->email->initialize($config);
        $this->email->from($this->property['email'], $this->property['name']);
        $this->email->to($to);
        $this->email->cc($this->property['cc_email']);
        $this->email->subject($subject);
        $this->email->message($mess);

        if ($this->email->send() != TRUE) 
        {  return $this->email->print_debugger(); }else{ return TRUE; }
    }

    public function send($to=null,$subject=null,$mess=null,$type='html')
    {
        if ($this->email_validation($to) == TRUE)
        {
              $this->load->library('email');
              $this->property = $this->ci->property->get();

              $config['charset'] = 'iso-8859-1';
              $config['wordwrap'] = TRUE;
              
              $config['protocol']   = "smtp";
              $config['smtp_host']  = "mail.wamenak.com";
              $config['smtp_user']  = 'info@wamenak.com';
              $config['smtp_pass']  = 'wamenak2018';
              $config['smtp_port']  = '587';
              $config['charset']  = 'utf-8';
              $config['wordwrap'] = TRUE;
              $config['mailtype'] = $type;
              
              $this->email->initialize($config);
              $this->email->from($this->property['email'], $this->property['name']);
              $this->email->to($to);
              $this->email->cc($this->property['cc_email']);
              $this->email->subject($subject);
              $this->email->message($mess);
              
              if ($this->email->send() != TRUE) 
              {
//                 throw new Exception("Failed To Sent Email");   
                  return $this->email->print_debugger();
              }else{ return TRUE; }
        }
        else { return FALSE; }
    }

    private function email_validation($param)
    {
        if ( filter_var($param, FILTER_VALIDATE_EMAIL) != TRUE ){ return FALSE; } else { return TRUE; }
    }
}

/* End of file Property.php */