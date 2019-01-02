<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frontmenu_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('frontmenu');
        $this->tableName = 'menu';
    }
    
    protected $field = array('id', 'parent_id', 'position', 'name', 'type', 'url', 'menu_order', 'class_style', 'id_style', 
                             'default', 'limit', 'icon', 'target', 'publish', 'created', 'updated', 'deleted');
    protected $com;
            
    
    function get_last($limit, $offset=null)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
    
    function delete_child($parent)
    {
       $this->db->where('parent_id', $parent);
       $this->db->delete($this->tableName);
    }
    
    // ajax function
    function getmodul()
    {
        $this->db->select('name');
        $this->db->from('modul');
        $this->db->where('aktif', 'Y');
        $this->db->where('publish', 'Y');
        $this->db->order_by('name', 'asc'); 
        return $this->db->get();
    }
    
    function getarticle()
    {
        $this->db->select('name, id');
        $this->db->from('news_category');
        return $this->db->get();
    }

}

?>