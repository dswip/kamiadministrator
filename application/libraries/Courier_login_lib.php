<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courier_login_lib extends Custom_Model
{
    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'courier_login_status';
        $this->ci = & get_instance();
    }

    protected $ci,$tableName,$deleted;
    
    public function add($user=0, $log=0, $device=null, $coordinate=null)
    {
        $trans = array('userid' => $user, 'log' => $log, 'device' => $device, 'coordinate' => $coordinate, 'created' => date('Y-m-d H:i:s'));
        if ($this->cek($user) == TRUE){ 
             $this->ci->db->insert($this->tableName, $trans); 
        }
        else { $this->edit($user,$log,$device); }
    }

    private function cek($user)
    {
        $this->ci->db->where('userid', $user);
        $num = $this->ci->db->get($this->tableName)->num_rows();
        if ($num > 0){ return FALSE; }else { return TRUE; }
    }
    
    private function edit($user,$log,$device=null,$coordinate=null)
    {
        $trans = array('log' => $log, 'device' => $device, 'coordinate' => $coordinate);
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
    
    function get_name($user){
       
        $this->ci->db->where('userid', $user);
       $res = $this->ci->db->get($this->tableName)->row(); 
       return $res->name;
    }
    
    function get_coordinate($user){
       
       $this->cek_null($user, 'userid');
//       $this->ci->db->where('userid', $user);
       $res = $this->ci->db->get($this->tableName)->row(); 
       return $res->coordinate;
    }
    
    function get_coordinate_all(){
       return $this->ci->db->get($this->tableName); 
    }
    
    function post_coordinate($user,$coordinate){
        $trans = array('coordinate' => $coordinate, 'created' => date('Y-m-d H:i:s'));
        $this->ci->db->where('userid', $user);
        $this->ci->db->update($this->tableName, $trans);
    }
     
}


/* End of file Property.php */