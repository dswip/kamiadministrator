<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shiprate_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('shiprate');
        $this->tableName = 'shiprate';
    }
    
    protected $field = array('id', 'courier', 'city', 'district', 'type', 'rate', 'created', 'updated', 'deleted');
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
    
    function search($city, $courier)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null_string($city, 'city');
        $this->cek_null_string($courier, 'courier');
        return $this->db->get(); 
    }
    
    function valid_district($district,$kurir,$type)
    {
       $this->db->where('district', $district);
       $this->db->where('courier', $kurir);
       $this->db->where('type', $type);
       $query = $this->db->get($this->tableName)->num_rows();

       if($query > 0){ return FALSE; }else{ return TRUE; } 
    }
    
    function validating_district($id,$district,$kurir,$type)
    {
       $this->db->where('district', $district);
       $this->db->where('courier', $kurir);
       $this->db->where('type', $type);
       $this->db->where_not_in('id', $id);
       $query = $this->db->get($this->tableName)->num_rows();

       if($query > 0){ return FALSE; }else{ return TRUE; } 
    }
    
    
}

?>