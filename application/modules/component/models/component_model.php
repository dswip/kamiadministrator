<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Component_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = 0;
        $this->tableName = 'modul';
    }
    
    protected $field = array('id', 'name', 'title', 'publish', 'status', 'aktif', 'limit', 'role', 'icon', 'order',
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
    
    function search($publish=null,$status=null,$active=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null($publish, 'publish');
        $this->cek_null($status, 'status');
        $this->cek_null($active, 'aktif');
        $this->db->order_by('name', 'asc'); 
        return $this->db->get(); 
    }    
   
}

?>