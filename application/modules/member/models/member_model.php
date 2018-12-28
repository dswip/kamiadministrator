<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('member');
        $this->tableName = 'member';
    }
    
    protected $field = array('id', 'first_name', 'last_name', 'type', 'address', 'shipping_address', 'phone1', 'phone2', 'joined',
                             'fax', 'email', 'password', 'website', 'state', 'city', 'region', 'zip', 'notes', 'image', 'status',
                             'npwp', 'profession', 'organization', 'member_no',
                             'created', 'updated', 'deleted');
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
    
    function get()
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('first_name', 'asc'); 
        return $this->db->get(); 
    }
    
    function search($cat=null,$publish=null)
    {   
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null_string($cat, 'city');
        $this->cek_null_string($publish, 'status');
        
        $this->db->order_by('id', 'asc'); 
        return $this->db->get(); 
    }
    
    function login($user=null){
        
        $this->db->where('phone1', $user);
        $this->db->where('status', 1);
        $this->db->limit(1);
        $res = $this->db->get($this->tableName)->num_rows();
        if ($res > 0){ return TRUE; }else{ return FALSE; }
    }
    
    function get_by_username($username=null){
        
        $this->db->select($this->field);
        $this->db->where('email', $username);
        $this->db->where('deleted', $this->deleted);
        return $this->db->get($this->tableName);
    }
    
    function get_by_phone($phone=null){
        
        $this->db->select($this->field);
        $this->db->where('phone1', $phone);
        $this->db->where('deleted', $this->deleted);
        return $this->db->get($this->tableName);
    }
    
    function cek_user($username){
        
        $this->db->select($this->field);
        $this->db->where('email', $username);
        $this->db->where('deleted', $this->deleted);
        $res = $this->db->get($this->tableName)->num_rows();
        if ($res > 0){ return TRUE; }else{ return FALSE; }
    }
    
    function cek_user_phone($username){
        
        $this->db->select($this->field);
        $this->db->where('phone1', $username);
        $this->db->where('deleted', $this->deleted);
        $res = $this->db->get($this->tableName)->num_rows();
        if ($res > 0){ return TRUE; }else{ return FALSE; }
    }
    
    function valid_customer($email,$phone1){
        
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->where('email', $email);
        $this->db->or_where('phone1', $phone1); 
        $val = $this->db->get($this->tableName)->num_rows();
        if ($val > 0){ return FALSE; }else{ return TRUE; }
    }
    
    function counter($type=0)
    {
       $this->db->select_max('id');
       $query = $this->db->get($this->tableName)->row_array(); 
       if ($type == 0){ return intval($query['id']+1); }else { return intval($query['id']); }
    }

}

?>