<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Topup_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('topup');
        $this->tableName = 'topup_trans';
    }
    
    protected $field = array('id', 'customer', 'dates', 'type', 'courier', 'log', 'amount', 'bank', 'redeem', 'redeem_date', 'status', 'created', 'updated', 'deleted');
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
    
    function search($cust=null,$type=null,$publish=null)
    {   
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null_string($cust, 'customer');
        $this->cek_null_string($type, 'type');
        $this->cek_null_string($publish, 'status');
        
        $this->db->order_by('id', 'desc'); 
        return $this->db->get(); 
    }
    
    function get_json($cust=null,$type=null,$start=null,$end=null,$limit=null)
    {   
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->where('status', 1);
        $this->cek_null($cust, 'customer');
        $this->cek_null($type, 'type');
        $this->between('dates', $start, $end);
        
        if ($limit != null){ $this->db->limit($limit); }
        
        if ($start != null && $end != null){ $this->db->order_by('id', 'asc');}else{ $this->db->order_by('id', 'desc');  }
        return $this->db->get(); 
    }
    
    function get_by_courier($courier,$limit=0,$offset=0){
        
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->where('courier', $courier);
        $this->db->where('status', 1);
        $this->db->where('type', 1);
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'desc'); 
        return $this->db->get(); 
    }
    
    function report($start=null,$end=null,$type=null)
    {   
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->between('dates', $start, $end);
        $this->cek_null($type, 'type');
        $this->db->order_by('id', 'asc'); 
        return $this->db->get(); 
    }
    
    function counter()
    {
       $this->db->select_max('id');
       $query = $this->db->get($this->tableName)->row_array(); 
       return intval($query['id']);
    }

}

?>