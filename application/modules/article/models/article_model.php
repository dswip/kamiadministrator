<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Article_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('article');
        $this->tableName = 'article';
    }
    
    
    protected $table = 'article';
    protected $field = array('id', 'category_id', 'user', 'lang', 'permalink', 'title', 'text', 'image', 'dates', 'time', 'counter', 
                             'comment', 'front', 'publish', 'created', 'updated', 'deleted');
    protected $com;
                
    function get_last($limit=null, $offset=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('dates', 'desc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
    
    function get_list($lang=null,$cat=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null($lang, 'lang');
        $this->cek_null($cat, 'category_id');
        $this->db->order_by('dates', 'desc'); 
        return $this->db->get(); 
    }
    
    function search($cat=null,$lang=null,$publish=null,$dates=null)
    {
        if ($dates != 'null'){
          $start = picker_between_split($dates, 0);
          $end = picker_between_split($dates, 1);
        }
        else { $start = null; $end=null; }
        
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->cek_null_string($cat, 'category_id');
        $this->cek_null_string($lang, 'lang');
        $this->cek_null_string($publish, 'publish');
        $this->between('dates', $start, $end);
        
        $this->db->order_by('dates', 'asc'); 
        return $this->db->get(); 
    }
    
}

?>