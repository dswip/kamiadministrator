<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Closing_model extends Custom_Model
{   
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('ledger');
        $this->tableName = 'closing';
    }
    
    function count_all_num_rows()
    {
        //method untuk mengembalikan nilai jumlah baris dari database.
        return $this->db->count_all($this->table);
    }
    
    function get_last_closing($limit, $offset)
    {
        $this->db->select('id, dates, times, user, notes, log');
        $this->db->from($this->tableName);
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $offset);
        return $this->db->get(); 
    }

    function search($date=null)
    {
        $this->db->select('id, dates, times, user, notes, log');
        $this->db->from($this->tableName);
        $this->cek_null($date,"dates");
        return $this->db->get();
    }

}

?>