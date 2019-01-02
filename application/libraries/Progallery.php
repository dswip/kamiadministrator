<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Progallery {

    public function __construct()
    {
        $this->ci = & get_instance();
    }

    private $ci;
    private $table = 'progallery';


    function delete_by_product($pid)
    {
        $this->ci->db->where('product', $pid);
        $this->ci->db->delete($this->table);
    }
}

/* End of file Property.php */