<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Discount_lib extends Custom_Model {
    
    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'discount';
    }

    protected $field = array('id', 'name', 'start', 'end', 'type', 'minimum', 'percentage', 'agent', 'status', 'created', 'updated', 'deleted');
    
    function cek_discount($dates=null){
       
        $val = array('updated' => date('Y-m-d H:i:s'), 'status' => 0);
        $this->db->from($this->tableName); 
        $this->db->where('deleted', $this->deleted);
        $this->db->where('end <', $dates);
        $this->db->where('status', 1);
        $this->db->update($this->tableName, $val);
    }
    

}

/* End of file Property.php */