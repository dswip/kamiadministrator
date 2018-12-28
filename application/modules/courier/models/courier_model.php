<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Courier_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('courier');
        $this->tableName = 'courier';
    }
    
    protected $field = array('id', 'ic', 'name', 'phone', 'address', 'email', 'image', 'company', 'joined', 'status', 'created', 'updated', 'deleted');
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
    
    function search($publish=null)
    {   
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null_string($publish, 'status');
        
        $this->db->order_by('id', 'asc'); 
        return $this->db->get(); 
    }
    
    function report()
    {   
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('name', 'asc'); 
        return $this->db->get(); 
    }
    
    function cek_user_phone($username){
        
        $this->db->select($this->field);
        $this->db->where('phone', $username);
        $this->db->where('deleted', $this->deleted);
        $res = $this->db->get($this->tableName)->num_rows();
        if ($res > 0){ return TRUE; }else{ return FALSE; }
    }
    
    function login($user=null){
        
        $this->db->where('phone', $user);
        $this->db->where('status', 1);
        $this->db->limit(1);
        $res = $this->db->get($this->tableName)->num_rows();
        if ($res > 0){ return TRUE; }else{ return FALSE; }
    }
    
    function get_by_phone($phone=null){
        
        $this->db->select($this->field);
        $this->db->where('phone', $phone);
        $this->db->where('deleted', $this->deleted);
        return $this->db->get($this->tableName);
    }
    
    function counter($type=0)
    {
       $this->db->select_max('id');
       $query = $this->db->get($this->tableName)->row_array(); 
       if ($type == 0){ return intval($query['id']+1); }else { return intval($query['id']); }
    }

}

?>