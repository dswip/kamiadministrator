<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Role_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('roles');
        $this->tableName = 'role';
    }
    
    protected $field = array('id', 'name', 'desc', 'rules', 'granted_menu');
    protected $com;
            
   
    function get_last_role($limit, $offset=null)
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