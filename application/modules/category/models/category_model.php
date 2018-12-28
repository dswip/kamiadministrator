<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('category');
        $this->tableName = 'category';
    }
    
    protected $field = array('id', 'name', 'parent_id', 'publish', 'image', 'permalink', 'orders', 'created', 'updated', 'deleted');
    protected $com;
    
    function get_last_category($limit, $offset=null)
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