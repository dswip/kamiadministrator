<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_lib {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'user';
        $this->ci = & get_instance();
    }
    
    private $ci,$tableName,$deleted;

    function combo()
    {
        $this->ci->db->select('id, name, username');
        $val = $this->ci->db->get($this->tableName)->result();
        foreach($val as $row){$data['options'][$row->id] = $row->name;}
        return $data;
    }
    
    function combo_criteria($role)
    {
        $data = null;
        $this->ci->db->select('id, name, username');
        $this->ci->db->where('role', $role);
        $val = $this->ci->db->get($this->tableName)->result();
        if ($val){ $data['options'][''] = '-- All --'; foreach($val as $row){$data['options'][$row->id] = $row->username;} }
        else { $data['options'][''] = '-- All --';  }
        return $data;
    }

    function combo_all()
    {
        $this->ci->db->select('id, name, username');
        $val = $this->ci->db->get($this->tableName)->result();
        $data['options'][''] = '-- All --';
        foreach($val as $row){$data['options'][$row->id] = $row->name;}
        return $data;
    }

    function get_id($username)
    {
        $this->ci->db->select('id');
        $this->ci->db->where('username', $username);
        $val = $this->ci->db->get($this->tableName)->row();
        if ($val){
          return $val->id;    
        }
        
    }

    function get_username($id)
    {
        if ($id)
        {
            $this->ci->db->select('id, username');
            $this->ci->db->where('id', $id);
            $val = $this->ci->db->get($this->tableName)->row();
            if ($val){ return $val->username; }
            else { return null; }
        }
    }


}

/* End of file Property.php */