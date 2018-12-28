<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menugal_model extends CI_Model
{
    function __construct()
    {
       parent::__construct();
    }
    
    var $table = 'modul';
    
    function count_all_num_rows()
    {
        //method untuk mengembalikan nilai jumlah baris dari database.
        return $this->db->count_all($this->table);
    }
    
    function get_last_modul($limit, $offset)
    {
        $this->db->select('id, name, title, publish, status, aktif, limit, role, icon, order');
        $this->db->from($this->table); // from table dengan join nya
        $this->db->order_by('name', 'asc'); // query order
        $this->db->limit($limit, $offset);
        return $this->db->get(); // mengembalikan isi dari db
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
    
    function get_modul_by_id($uid)
    {
        $this->db->select('id, name, title, publish, status, aktif, limit, role, icon, order');
        $this->db->where('id', $uid);
        return $this->db->get($this->table);
    }

    function get_modul_by_name($name)
    {
        $this->db->select('id, name, title, publish, status, aktif, limit, role, icon, order');
        $this->db->where('name', $name);
        return $this->db->get($this->table);
    }

    function get_modul_name()
    {
        $this->db->where('status', 'admin');
        $this->db->where('aktif', 'Y');
        $this->db->order_by('name', 'asc'); // query order
        return $this->db->get($this->table);
    }
    
    function counter()
    {
        $this->db->select_max('userid');
        return $this->db->get($this->table);
    }
    
    function update($uid, $users)
    {
        $this->db->where('id', $uid);
        $this->db->update($this->table, $users);
    }
    
    function valid_modul($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get($this->table)->num_rows();

        if($query > 0)
        {
           return FALSE;
        }
        else
        {
           return TRUE;
        }
    }

    function validating_modul($name,$id)
    {
        $this->db->where('name', $name);
        $this->db->where_not_in('id', $id);
        $query = $this->db->get($this->table)->num_rows();

        if($query > 0)
        {
                return FALSE;
        }
        else
        {
                return TRUE;
        }
    }

}

?>