<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attribute_list_lib extends Custom_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'attribute_list';
    }

    protected $field = array('id', 'name', 'created', 'updated', 'deleted');

    function combo()
    {
        $this->db->select($this->field);
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){$data['options'][$row->id] = ucfirst($row->name);}
        return $data;
    }

    function combo_all()
    {
        $this->db->select($this->field);
        $val = $this->db->get($this->tableName)->result();
        $data['options'][''] = '-- All --';
        foreach($val as $row){$data['options'][$row->id] = ucfirst($row->name);}
        return $data;
    }
    
    function get_name($id=null)
    {
        if ($id)
        {
            $this->db->select('id,name');
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return $val->name; }
        }
        else if($id == 0){ return 'Top'; }
        else { return ''; }
    }


}

/* End of file Property.php */