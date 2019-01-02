<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Language_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('language');
        $this->tableName = 'language';
    }
    
    protected $field = array('id', 'name', 'code', 'primary', 'created', 'updated', 'deleted');
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
    

    function get_primary()
    {
        $this->db->where('primary', 1);
        return $this->db->get($this->tableName);
    }

}

?>