<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notif_lib extends Custom_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'notif';
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('notif');
        $this->sms = new Sms_lib();
        $this->email = new Send_email();
        $this->customer = new Customer_lib();
        $this->push = new Push_lib();
    }

    private $ci,$email,$sms,$customer,$push;
    protected $field = array('id', 'customer', 'subject', 'content', 'type', 'reading', 'modul', 'status', 'publish', 'created', 'deleted');
    
    /*
        0 = email
        1= sms
        2 = email + sms
        3 = notif socket
        4 = socket + SMS
        5 = email + notif socket
        6 = email + sms+ notif socket
    */
    
    function get_type($val=0){
        
        $res = null;
        switch ($val) {
            case 0: $res = 'Email'; break;
            case 1: $res = 'SMS'; break;
            case 2: $res = 'Email + SMS'; break;
            case 3: $res = 'Socket'; break;
            case 4: $res = 'Socket + SMS'; break;
            case 5: $res = 'Email + Socket'; break;
            case 6: $res = 'Email + SMS + Socket'; break;
        }
        return $res;
    }
    
    function get_by_customer($customer=null,$type=0,$read=null)
    {
        $this->db->select($this->field);
        $this->cek_null($customer, 'customer');
        $this->cek_null($type, 'type');
        $this->cek_null($read, 'reading');
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('created', 'desc'); 
        $this->db->from($this->tableName); 
        return $this->db->get(); 
    }
    
    function create($customer, $content, $type, $modul='', $subject='', $publish=1)
    {
        $journal = array('customer' => $customer, 'subject' => $subject, 'content' => $content, 'type' => $type, 'modul' => $modul, 'status' => 1, 'publish' => $publish, 'created' => date('Y-m-d H:i:s'));
        if ($this->db->insert($this->tableName, $journal) == TRUE){
            $this->send_notif($this->max());
            return TRUE;
        }else{ return FALSE; }
    }
    
    public function max()
    {
        $this->db->select_max('id');
        $val = $this->db->get($this->tableName)->row_array();
        $val = $val['id'];
        return $val;
    }
    
    function combo()
    {
        $data = null;
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->order_by('modul', 'asc');
        $this->db->distinct();
        $val = $this->db->get($this->tableName)->result();
        if ($val){
          foreach($val as $row){ $data['options'][$row->modul] = strtolower($row->modul); }
        }else{ $data['options'][''] = ''; }
        return $data;
    }
    
    private function send_notif($uid){
       
        $val = $this->get_by_id($uid)->row();
        $res = false;
        
        if ($val->type == 0){
          $res = $this->email->send(strtolower($this->customer->get_detail($val->customer, 'email')), $val->subject, $val->content);    
        }elseif ($val->type == 1){
          $res = $this->sms->send($this->customer->get_detail($val->customer, 'phone1'), $val->content);  
        }elseif ($val->type == 2){
          $res1 = $this->email->send(strtolower($this->customer->get_detail($val->customer, 'email')), $val->subject, $val->content);    
          $res2 = $this->sms->send($this->customer->get_detail($val->customer, 'phone1'), $val->content);  
          if ($res1 == true && $res2 == true){ $res = true; }
        }elseif ($val->type == 3){
          $res = $this->push->send_device($val->customer, $val->content);
          
        }elseif ($val->type == 4){
          $res = $this->push->send_device($val->customer, $val->content);
          $res1 = $this->sms->send($this->customer->get_detail($val->customer, 'phone1'), $val->content);  
          if ($res == true && $res1 == true){ $res = true; }
          
        }elseif ($val->type == 5){
          $res = $this->push->send_device($val->customer, $val->content);
          $res1 = $this->email->send(strtolower($this->customer->get_detail($val->customer, 'email')), $val->subject, $val->content);    
          if ($res == true && $res1 == true){ $res = true; }
          
        }elseif ($val->type == 6){
          $res1 = $this->email->send(strtolower($this->customer->get_detail($val->customer, 'email')), $val->subject, $val->content);    
          $res2 = $this->sms->send($this->customer->get_detail($val->customer, 'phone1'), $val->content);  
          $res3 = $this->push->send_device($val->customer, $val->content);
          if ($res1 == true && $res2 == true && $res3 == true){ $res = true; }
        }
        return $res;
    }

}

/* End of file Property.php */
