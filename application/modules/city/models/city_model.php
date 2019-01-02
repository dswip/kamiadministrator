<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class City_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    var $table = 'city';
    
    function count_all_num_rows()
    {
        //method untuk mengembalikan nilai jumlah baris dari database.
        return $this->db->count_all($this->table);
    }
    
    function get_last_city($limit, $offset)
    {
        $this->db->select('id, name');
        $this->db->from($this->table); 
        $this->db->order_by('name', 'asc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }
    
    function get_kabupaten()
    {
        $this->db->select('id, id_prov, nama');
        $this->db->from('kabupaten'); 
        $this->db->order_by('nama', 'asc'); 
        return $this->db->get(); 
    }
    
    function get_kecamatan($city)
    {
        $this->db->select('id, id_kabupaten, nama');
        $this->db->from('kecamatan'); 
        $this->db->where('id_kabupaten', $city);
        $this->db->order_by('nama', 'asc'); 
        return $this->db->get(); 
    }
    
    function delete($uid)
    {
        $this->db->where('id', $uid);
        $this->db->delete($this->table); // perintah untuk delete data dari db
    }
    
    function add($users)
    {
        $this->db->insert($this->table, $users);
    }
    
    function get_city_by_id($uid)
    {
        $this->db->select('id, name');
        $this->db->where('id', $uid);
        return $this->db->get($this->table);
    }
    
    function update($uid, $users)
    {
        $this->db->where('id', $uid);
        $this->db->update($this->table, $users);
    }
    
    function valid_city($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get($this->table)->num_rows();
        if($query > 0) { return FALSE; } else { return TRUE; }
    }

    function validating_city($name,$id)
    {
        $this->db->where('name', $name);
        $this->db->where_not_in('id', $id);
        $query = $this->db->get($this->table)->num_rows();
        if($query > 0) {  return FALSE; } else { return TRUE; }
    }

}

?>