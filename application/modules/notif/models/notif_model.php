<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notif_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('notif');
        $this->tableName = 'notif';
    }
    
    protected $field = array('id', 'customer', 'subject', 'content', 'type', 'reading', 'modul', 'status', 'created', 'deleted');
    protected $com;
    
    function get_last($limit, $offset=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('id', 'desc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
    
    function get_publish($cust,$limit=30)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->where('customer', $cust);
        $this->db->where('publish', 1);
        $this->db->where('type', 3);
        $this->db->order_by('id', 'desc'); 
        $this->db->limit($limit);
        return $this->db->get(); 
    }
    
    function search($customer=null,$type=null,$modul=null,$publish=null)
    {   
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null_string($type, 'type');
        $this->cek_null_string($publish, 'status');
        $this->cek_null_string($customer, 'customer');
        $this->cek_null_string($modul, 'modul');
        $this->db->order_by('id', 'asc'); 
        return $this->db->get(); 
    }
    
    function report($customer=null,$type=null)
    {   
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null($customer, 'customer');
        $this->cek_null($type, 'type');
        $this->db->order_by('created', 'asc'); 
        return $this->db->get(); 
    }
    
    function update_notif($cust,$users)
    {
        $this->db->where('customer', $cust);
        $this->db->update($this->tableName, $users);
    }
    
    function update_notif_id($uid,$users)
    {
        $this->db->where('id', $uid);
        $this->db->update($this->tableName, $users);
    }

}

?>