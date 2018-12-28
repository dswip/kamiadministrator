<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Orders_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('orders');
        $this->tableName = 'orders';
    }
    
    
    protected $table = 'article';
    protected $field = array('id', 'code', 'dates', 'agent_id', 'content', 'image', 'approved', 'created', 'updated', 'deleted');
    protected $com;
                
    function get_last($limit=null, $offset=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('dates', 'desc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
    
    function search($agent=null,$publish=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null_string($agent, 'agent_id');
        $this->cek_null_string($publish, 'approved');
        $this->db->order_by('dates', 'asc'); 
        return $this->db->get(); 
    }
    
    function counter($type=0)
    {
       $this->db->select_max('id');
       $query = $this->db->get($this->tableName)->row_array(); 
       if ($type == 0){ return intval($query['id']+1); }else { return intval($query['id']); }
    }
    
    function get_detail_based_order($orderid){
        
        $this->db->where('code', $orderid);
        $query = $this->db->get($this->tableName)->row();
        return $query;
    }
    
}

?>