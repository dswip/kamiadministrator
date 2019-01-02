<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_lib extends Custom_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'role';
    }
    
    protected $field = array('id', 'name', 'desc', 'rules', 'granted_menu');
    
    function combo()
    {
        $this->db->select($this->field);
        $this->db->where('deleted', $this->deleted);
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){$data['options'][$row->name] = ucfirst($row->name);}
        return $data;
    }
    
    function get_granted_menu($role)
    {
       $this->db->select($this->field);
       $this->db->where('name', $role);
       $this->db->where('deleted', $this->deleted);
       $val = $this->db->get($this->tableName)->row();
       return $val->granted_menu;
    }


}

/* End of file Property.php */