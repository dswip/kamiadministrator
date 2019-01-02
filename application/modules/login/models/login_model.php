<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    var $table = 'user';
    
    function check_user($username, $password)
    {
        $query = $this->db->get_where($this->table, array('username' => $username, 'password' => $password, 'status' => 1), 1, 0);
        if ($query->num_rows() > 0) {  return TRUE; } else { return FALSE; }
    }

    function check_username($username)
    {
        $query = $this->db->get_where($this->table, array('username' => $username), 1, 0);
        if ($query->num_rows() > 0) {  return TRUE; } else { return FALSE; }
    }

    function get_userid($username)
    {
        $query = $this->db->get_where($this->table, array('username' => $username), 1, 0)->row();
        return $query->id;
    }

    function get_role($username)
    {
        $query = $this->db->get_where($this->table, array('username' => $username), 1, 0)->row();
        return $query->role;
    }

    function get_rules($role)
    {
        $query = $this->db->get_where('role', array('name' => $role), 1, 0)->row();
        return $query->rules;
    }

    function get_email($username)
    {
        $query = $this->db->get_where($this->table, array('username' => $username), 1, 0)->row();
        return $query->email;
    }

    function get_pass($username)
    {
        $query = $this->db->get_where($this->table, array('username' => $username), 1, 0)->row();
        return $query->password;
    }

}

?>