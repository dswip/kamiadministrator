<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_lib
{
    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'login_status';
        $this->ci = & get_instance();
    }

    private $ci,$tableName,$deleted;
    
    public function add($user=0, $log=0)
    {
        $trans = array('userid' => $user, 'log' => $log);
        if ($this->cek($user) == TRUE){ $this->ci->db->insert($this->tableName, $trans); }
        else { $this->edit($user,$log); }
    }

    private function cek($user)
    {
        $this->ci->db->where('userid', $user);
        $num = $this->ci->db->get($this->tableName)->num_rows();
        if ($num > 0){ return FALSE; }else { return TRUE; }
    }
    
    private function edit($user,$log)
    {
        $trans = array('log' => $log);
        $this->ci->db->where('userid', $user);
        $this->ci->db->update($this->tableName, $trans);
    }
    
    function valid($user,$log)
    {
       $this->ci->db->where('userid', $user);
       $this->ci->db->where('log', $log);
       $num = $this->ci->db->get($this->tableName)->num_rows(); 
       if ($num > 0){ return TRUE; }else { return FALSE; }
    }
    
}


/* End of file Property.php */