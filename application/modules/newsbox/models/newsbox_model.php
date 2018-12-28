<?php

class Newsbox_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    var $table = 'newsbox';
    
    function get_news()
    {
        $this->db->select('id, title, text');
        $this->db->from('newsbox'); 
        return $this->db->get();
    }

    function update($uid, $users)
    {
        $this->db->where('id', $uid);
        $this->db->update($this->table, $users);
    }
    
    

}

?>