<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency_lib {

    public function __construct()
    {
        $this->ci = & get_instance();
    }

    private $ci;

    function combo()
    {
        $this->ci->db->select('id, name, code');
        $val = $this->ci->db->get('currencies')->result();
        foreach($val as $row){$data['options'][$row->name] = $row->name;}
        return $data;
    }

    function combo_all()
    {
        $this->ci->db->select('id, name, code');
        $val = $this->ci->db->get('currencies')->result();
        $data['options'][''] = '-- All --';
        foreach($val as $row){$data['options'][$row->name] = $row->name;}
        return $data;
    }

    function get_code($name=null)
    {
        $this->ci->db->select('code');
        $this->ci->db->from('currencies');
        $this->ci->db->where('name', $name);
        $res = $this->ci->db->get()->row();
        return $res->code;
    }
    
    function cek($code=null)
    {
        $this->ci->db->from('currencies');
        $this->ci->db->where('code', $code);
        $num = $this->ci->db->get()->num_rows();
        if ($num > 0){ return TRUE; }else { return FALSE; }
    }


}

/* End of file Property.php */