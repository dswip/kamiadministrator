<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Widget_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('widget');
        $this->tableName = 'widget';
    }
    
    protected $field = array('id', 'name', 'title', 'position', 'publish', 'order', 'menu', 'moremenu', 'limit');
    protected $com;
            
    
    function get_last($limit, $offset=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('name', 'asc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
   
}

?>