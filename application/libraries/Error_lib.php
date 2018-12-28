<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error_lib extends Custom_Model {
    
    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'error_log';
    }

    protected $field = array('id', 'modul', 'message', 'created');
    
    function create($modul=0,$meesage=null){
        
       $data = array('modul' => $modul, 'message' => $meesage, 'created' => date('Y-m-d H:i:s'));
       $this->db->insert($this->tableName, $data); 
    }
}

/* End of file Property.php */