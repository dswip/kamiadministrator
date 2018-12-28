<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attribute_product_lib extends Custom_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'attribute_product';
    }

    protected $field = array('id', 'product_id', 'attribute_id', 'value');

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
    
    function add($users)
    {
        $this->db->insert($this->tableName, $users);
    }
    
    function force_delete($uid)
    {
        $this->db->where('id', $uid);
        $this->db->delete($this->tableName);
    }
    
    function force_delete_by_product($uid)
    {
        $this->db->where('product_id', $uid);
        $this->db->delete($this->tableName);
    }
    
    function valid($attribute,$pid)
    {
        $this->db->where('product_id', $pid);
        $this->db->where('attribute_id', $attribute);
        $query = $this->db->get($this->tableName)->num_rows();

        if($query > 0){ return FALSE; }
        else{ return TRUE; }
    }
    
    function get_list($pid)
    {
        $this->db->select($this->field);
        $this->db->where('product_id', $pid);
        return $this->db->get($this->tableName);
    }


}

/* End of file Property.php */