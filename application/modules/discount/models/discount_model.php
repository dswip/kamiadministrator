<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Discount_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('discount');
        $this->tableName = 'discount';
    }
    
    protected $field = array('id', 'name', 'start', 'end', 'type', 'payment_type', 'minimum', 'percentage', 'status', 'created', 'updated', 'deleted');
    protected $com;
    
    function cek_discount($dates=null){
       
        $val = array('updated' => date('Y-m-d H:i:s'), 'status' => 0);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->where('end <', $dates);
        $this->db->where('status', 1);
        $this->db->update($this->tableName, $val);
    }
    
    function get_discount($nominal=0,$dates=0,$payment=null){
        
        $this->cek_discount($dates); // cek discount
        
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->where('minimum <=', $nominal);
        $this->db->where('end >=', $dates);
        $this->db->where('status', 1);
        $this->db->where('payment_type', $payment);
        $this->db->order_by('minimum', 'desc'); 
        $this->db->order_by('type', 'desc'); 
        $this->db->limit(1);
        $res = $this->db->get()->row(); 
        if ($res){ return $res->percentage; }else{ return 0; }
    }
    
    function get_last($limit)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('name', 'asc'); 
        $this->db->limit($limit);
        return $this->db->get(); 
    }
    
    function search($end, $type, $status)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('name', 'asc'); 
        $this->cek_null_string($end, 'end');
        $this->cek_null_string($type, 'type'); 
        $this->cek_null_string($status, 'status'); 
        return $this->db->get(); 
    }
    
    function report($model, $material)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('name', 'asc'); 
        $this->cek_null($model, 'model');
        $this->cek_null($material, 'material_list'); 
        return $this->db->get(); 
    }
    
    function valid_discount($end,$minorder,$type)
    {
        $this->db->where('end', $end);
        $this->db->where('minimum', $minorder);
        $this->db->where('type', $type);
        
        $query = $this->db->get($this->tableName)->num_rows();
        if($query > 0){ return FALSE; }else{ return TRUE; }
    }
    
    function validating_discount($end,$minorder,$type,$id)
    {
        $this->db->where('end', $end);
        $this->db->where('minimum', $minorder);
        $this->db->where('type', $type);
        
        $this->db->where_not_in('id', $id);
        $query = $this->db->get($this->tableName)->num_rows();
        if($query > 0){ return FALSE; }else{ return TRUE; }
    }
    
}

?>