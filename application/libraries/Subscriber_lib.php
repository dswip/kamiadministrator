<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscriber_lib extends Main_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'subscriber';
    }

    private $ci;
    
    function get()
    {
       $this->db->select('email'); 
       return $this->db->get($this->tableName)->result(); 
    }


}

/* End of file Property.php */