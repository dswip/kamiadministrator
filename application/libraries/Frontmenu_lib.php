<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontmenu_lib extends Main_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'menu';
    }

    private $ci;

    function combo()
    {
        $this->db->select('id, name');
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){$data['options'][$row->id] = $row->name;}
        return $data;
    }

    public function getmenuname($val)
    {
        if ($val)
        {
           $this->db->select('id, parent_id, position, name, type, url, menu_order, limit, default, class_style, id_style, icon');
           $this->db->where('id', $val);
           $res = $this->db->get($this->tableName)->row();

           if ($res) {  return $res->name; } else{ return null; }
        }
    }


}

/* End of file Property.php */