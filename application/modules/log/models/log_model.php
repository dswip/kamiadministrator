<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('log');
        $this->tableName = 'log';
    }
    
    protected $field = array('id', 'userid', 'date', 'time', 'component_id', 'activity', 
                             'created', 'updated', 'deleted', 'description'
                            );
    protected $com;
    
    function get_last_user($limit, $offset=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('id', 'desc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
   
    
    function report($user=null,$modul=null,$start,$end)
    {
       $this->db->select($this->field);
       $this->db->from($this->tableName); 
       $this->db->where('deleted', $this->deleted);
       $this->between("log.date", $start, $end);
       $this->cek_null($user, 'userid');
       $this->cek_null($modul, 'component_id');
       $this->db->order_by('id', 'desc'); 
       return $this->db->get(); 
    }

}

?>