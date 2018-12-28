<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Delivery_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('delivery');
        $this->tableName = 'delivery';
    }
    
    protected $field = array('delivery.id', 'delivery.sales_id', 'delivery.dates', 'delivery.courier', 'delivery.coordinate',
                             'delivery.destination', 'delivery.distance', 'delivery.received',
                             'delivery.amount', 'delivery.confirm_customer', 'delivery.rating', 'delivery.comments', 'delivery.status', 'delivery.created', 'delivery.updated', 'delivery.deleted');
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
    
    function search($cust=null,$sales=null,$status=null,$received=null)
    {   
        $this->db->select($this->field);
        $this->db->from('sales, delivery');
        $this->db->where('sales.id = sales_id');

        $this->cek_null_string($cust, 'sales.cust_id');
        $this->cek_null_string($sales, 'sales.code');
        $this->cek_null_string($status, 'delivery.status');
        
        if ($received == '0'){ $this->db->where('delivery.received', NULL);}    
        elseif ($received == '1'){ $this->db->where('delivery.received is NOT NULL'); }
        
        $this->db->order_by('delivery.id', 'desc'); 
        return $this->db->get(); 
    }
    
    function report($delivery_start=null,$delivery_end=null,$status=null)
    {   
        $this->db->select($this->field);
        $this->db->from('sales, delivery');
        $this->db->where('sales.id = sales_id');

        $this->between('delivery.dates', $delivery_start, $delivery_end);
        
        if ($status == '1'){ $this->db->where('delivery.status',$status); }
        elseif ($status == '0'){ $this->db->where('delivery.status',$status); }

        $this->db->order_by('delivery.id', 'desc'); 
        return $this->db->get(); 
    }
    
    function counter($type=0)
    {
       $this->db->select_max('id');
       $query = $this->db->get($this->tableName)->row_array(); 
       if ($type == 0){ return intval($query['id']+1); }else { return intval($query['id']); }
    }
     
}

?>