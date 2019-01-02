<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('account');
        $this->tableName = 'account';
    }
    
    protected $field = array('id', 'parent_id', 'category', 'code', 'name', 'description', 'publish', 'created', 'updated', 'deleted');
    protected $com;
            
    function count_all_num_rows()
    {
        //method untuk mengembalikan nilai jumlah baris dari database.
        return $this->db->count_all($this->table);
    }
    
    function get_last($limit, $offset=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('code', 'asc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
    
    function report()
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('code', 'asc'); 
        return $this->db->get(); 
    }
    
    function search($category, $parent)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('code', 'asc'); 
        $this->cek_null_string($category, 'category');
        $this->cek_null_string($parent, 'parent_id');
        return $this->db->get(); 
    }
    
    function valid_code($code,$category)
    {
       $this->db->where('code', $code);
       $this->db->where('category', $category);
       $query = $this->db->get($this->tableName)->num_rows();

       if($query > 0){ return FALSE; }
       else{ return TRUE; } 
    }
    
    function validating_code($code,$category,$id)
    {
        $this->db->where('code', $code);
        $this->db->where('category', $category);
        $this->db->where_not_in('id', $id);
        $query = $this->db->get($this->tableName)->num_rows();

        if($query > 0){ return FALSE; }
        else{ return TRUE;}
    }  
    
}

?>