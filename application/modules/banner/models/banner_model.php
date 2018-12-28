<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banner_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('banner');
        $this->tableName = 'banner';
    }
    
    
    protected $field = array('id', 'name', 'position', 'url', 'publish', 'image', 'width', 'height', 'menu',
                             'created', 'updated', 'deleted');
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