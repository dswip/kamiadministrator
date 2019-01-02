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
        $this->tableName = 'error_log';
    }
    
    protected $field = array('id', 'modul', 'message', 'created');
    protected $com;
    
    function get_last($limit, $offset=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->order_by('id', 'desc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
   
    function report($start,$end)
    {
       $this->db->select($this->field);
       $this->db->from($this->tableName); 
       $this->between("date", $start, $end);
       $this->db->order_by('id', 'desc'); 
       return $this->db->get(); 
    }

}

?>