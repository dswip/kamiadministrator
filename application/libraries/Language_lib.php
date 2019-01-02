<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Language_lib extends Custom_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'language';
    }

    protected $field = array('id', 'name', 'code', 'primary', 'created', 'updated', 'deleted');

    function combo()
    {
        $this->db->select($this->field);
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){$data['options'][$row->code] = ucfirst($row->name);}
        return $data;
    }

    function combo_all()
    {
        $this->db->select($this->field);
        $val = $this->db->get($this->tableName)->result();
        $data['options'][''] = '-- All --';
        foreach($val as $row){$data['options'][$row->code] = ucfirst($row->name);}
        return $data;
    }


}

/* End of file Property.php */