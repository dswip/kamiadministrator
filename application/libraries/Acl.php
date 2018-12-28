<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acl {

    public function __construct()
    {
        // Do something with $params
        $this->ci = & get_instance();
        $this->login = new Login_lib();
        $this->admin = new Admin_lib();
    }

    private $ci,$login,$admin;

    public function otentikasi()
    { 
      $userid = $this->admin->get_id($this->ci->session->userdata('username'));  
      if ($this->ci->session->userdata('login') != TRUE || $this->login->valid($userid, $this->ci->session->userdata('log')) != TRUE )
      { redirect('login'); } 
    }

    function otentikasi1($title,$ajax=null)
    {
        $this->ci->db->select('id, name, publish, status, aktif, limit, role');
        $this->ci->db->where('name', $title);
        $mod = $this->ci->db->get('modul')->row();

        $mod = $mod->role;
        $mod = explode(",", $mod);

        foreach ($mod as $row) { if ($row == $this->ci->session->userdata('role')) {$val = TRUE; break;} else {$val = FALSE;} }

        if ($val != TRUE)
        {
           if ($ajax){ return FALSE; }
           else{
             $this->ci->session->set_flashdata('message', 'Sorry, you do not have the right to access '.$title.' component');
             redirect('main');
           }
        }
         else {return TRUE;}
    }

    function otentikasi2($title,$ajax=null)
    {
        $this->ci->db->select('id, name, publish, status, aktif, limit, role');
        $this->ci->db->where('name', $title);
        $mod = $this->ci->db->get('modul')->row();

        $mod = $mod->role;
        $mod = explode(",", $mod);

        foreach ($mod as $row)
        { if ($row == $this->ci->session->userdata('role')) {$val = TRUE; break;} else {$val = FALSE;} }

        if ($val != TRUE || $this->ci->session->userdata('rules') != 2 && $this->ci->session->userdata('rules') != 3)
        {
           if ($ajax){ return FALSE; }
           else{
             $this->ci->session->set_flashdata('message', 'Sorry, you do not have the right to access '.$title.' component');
             redirect($title);
           }
        }
         else {return TRUE;}
    }

    function otentikasi3($title,$ajax=null)
    {
        $this->ci->db->select('id, name, publish, status, aktif, limit, role');
        $this->ci->db->where('name', $title);
        $mod = $this->ci->db->get('modul')->row();

        $mod = $mod->role;
        $mod = explode(",", $mod);

        foreach ($mod as $row)
        { if ($row == $this->ci->session->userdata('role')) {$val = TRUE; break;} else {$val = FALSE;} }

        if ($val != TRUE || $this->ci->session->userdata('rules') != 3)
        {
           if ($ajax){ return FALSE; }
           else{
             $this->ci->session->set_flashdata('message', 'Sorry, you do not have the right to access '.$title.' component');
             redirect($title);
           }
        }
        else {return TRUE;}
    }

    function otentikasi4($title,$ajax=null)
    {
        $this->ci->db->select('id, name, publish, status, aktif, limit, role');
        $this->ci->db->where('name', $title);
        $mod = $this->ci->db->get('modul')->row();

        $mod = $mod->role;
        $mod = explode(",", $mod);

        foreach ($mod as $row)
        { if ($row == $this->ci->session->userdata('role')) {$val = TRUE; break;} else {$val = FALSE;} }

        if ($val != TRUE || $this->ci->session->userdata('rules') != 4)
        {
            
           if ($ajax){ return FALSE; }
           else{
             $this->ci->session->set_flashdata('message', 'Sorry, you do not have the right to edit '.$title.' component');
             redirect($title);
           } 
        }
        else {return TRUE;}
        
    }

    function otentikasi_admin($title,$ajax=null)
    {
        if ($this->ci->session->userdata('rules') != 3)
        {
           if ($ajax){ return FALSE;}
           else 
           {
             $this->ci->session->set_flashdata('message', 'Sorry, you do not have the right to edit this value');
             redirect('main');
           }  
        }
        else {return TRUE;}
    }
}

/* End of file Property.php */