<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_login_lib
{
    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'member_login_status';
        $this->ci = & get_instance();
    }

    private $ci,$tableName,$deleted;
    
    public function add($user=0, $log=0, $device=null)
    {
        $trans = array('userid' => $user, 'log' => $log, 'device' => $device, 'joined' => date('Y-m-d H:i:s'));
        if ($this->cek($user) == TRUE){ $this->ci->db->insert($this->tableName, $trans); }
        else { $this->edit($user,$log,$device); }
    }

    private function cek($user)
    {
        $this->ci->db->where('userid', $user);
        $num = $this->ci->db->get($this->tableName)->num_rows();
        if ($num > 0){ return FALSE; }else { return TRUE; }
    }
    
    private function edit($user,$log,$device=null)
    {
        $trans = array('log' => $log, 'device' => $device, 'joined' => date('Y-m-d H:i:s'));
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
    
    function get_by_userid($user)
    {
       $this->ci->db->where('userid', $user);
       $res = $this->ci->db->get($this->tableName)->row(); 
       return $res->log;
    }
    
    function get_device($user){
       
        $this->ci->db->where('userid', $user);
       $res = $this->ci->db->get($this->tableName)->row(); 
       return $res->device;
    }
     
}


/* End of file Property.php */