<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_model extends CI_Model
{
    function __construct() { parent::__construct(); }
    
    var $table = '';

    function getmodul()
    {
        $this->db->select('name');
        $this->db->from('modul');
        $this->db->where('aktif', 'Y');
        $this->db->where('publish', 'Y');
        return $this->db->get();
    }

    function getarticle()
    {
        $this->db->select('name, id');
        $this->db->from('news_category');
        return $this->db->get();
    }

    function cek_date($val,$val2)
    {
        if ($val != "" && $val2 != "")
        {
            $value = $this->db->where("export.order_date BETWEEN '$val' AND '$val2'");
        }
        else{ $value = null;}
        return $value;
    }


    function getcity($ccountry)
    {
        $this->db->select('city.name');
        $this->db->from('city,country');
        $this->db->where('city.country_id = country.id');
        $this->db->where('country.name', $ccountry);
        return $this->db->get()->result();
    }
}

?>