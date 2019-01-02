<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('admin');
        $this->tableName = 'user';
    }
    
    protected $field = array('id', 'username', 'password', 'name', 'address', 'phone1', 'phone2',
                             'city', 'email', 'yahooid', 'role', 'status', 'lastlogin', 
                             'created', 'updated', 'deleted'
                            );
    protected $com;
            
   
    function get_last_user($limit, $offset=null)
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