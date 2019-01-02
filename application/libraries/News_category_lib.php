<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_category_lib extends Custom_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'news_category';
    }

    protected $field = array('id', 'parent_id', 'name', 'desc', 'created', 'updated', 'deleted');
    
    function combo()
    {
        $this->db->select($this->field);
        $this->db->where('deleted', $this->deleted);
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){$data['options'][$row->id] = ucfirst($row->name);}
        return $data;
    }

    function combo_all($type='id')
    {
        $this->db->select($this->field);
        $this->db->where('deleted', $this->deleted);
        $val = $this->db->get($this->tableName)->result();
        $data['options'][''] = '-- All --';
        foreach($val as $row)
        {  if ($type == 'id'){ $data['options'][$row->id] = ucfirst($row->name); }
           else{ $data['options'][strtolower($row->name)] = ucfirst($row->name); }
        }
        return $data;
    }
    
    function combo_update($id)
    {
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->order_by('name', 'asc');
        $this->db->where_not_in('id', $id);
        $val = $this->db->get($this->tableName)->result();
        $data['options'][0] = 'Top';
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }
    
    function get_name($id=null)
    {
        if ($id)
        {
            $this->db->select($this->field);
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return ucfirst($val->name); }
        }
        else if($id == 0){ return 'Top'; }
        else { return ''; }
    }
    
    function get_id($name=null)
    {
        if ($name)
        {
            $this->db->select($this->field);
            $this->db->where('name', $name);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return $val->id; }
        }
        else { return ''; }
    }


}

/* End of file Property.php */