<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Campaign_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('campaign');
        $this->tableName = 'campaign';
    }
    
    protected $table = 'campaign';
    protected $field = array('id', 'email_from', 'email_to', 'type', 'subject', 'category', 'content', 'dates', 'publish', 'created', 'updated', 'deleted');
    protected $com;
                
    function get_last($limit, $offset=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('dates', 'desc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
    
    function search($type=null,$publish=null)
    {   
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null_string($type, 'type');
        $this->cek_null_string($publish, 'publish');
        
        $this->db->order_by('dates', 'asc'); 
        return $this->db->get(); 
    }
    
    function report($start=null,$end=null,$from=null,$type=null,$category=null)
    {   
        $this->db->select($this->field);
        $this->db->from($this->tableName);

        $this->between('dates', $start, $end);
        $this->cek_null($from, 'email_from');
        $this->cek_null($type, 'type');
        $this->cek_null($category, 'category');

        $this->db->order_by('id', 'desc'); 
        return $this->db->get(); 
    }
    
    function combo()
    {
        $data = null;
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->order_by('category', 'asc');
        $val = $this->db->get($this->tableName)->result();
        if ($val){
            foreach($val as $row){ $data['options'][$row->category] = ucfirst($row->category); }
        }else{ $data['options'][""] = "--"; }
        
        return $data;
    }
    
}

?>