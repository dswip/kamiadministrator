<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assembly_lib extends Main_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'assembly';
    }

    private $ci;
    
    protected $field = array('id', 'product', 'material');
       
    function create($pid,$material)
    {
        $assembly = array('product' => $pid, 'material' => $material);
        $this->db->insert($this->tableName, $assembly);
    }
    
    function cleaning($pid)
    {
       $this->db->where('product', $pid); 
       $this->db->delete($this->tableName);
    }
    
    function cek_product($pid)
    {
       $this->db->where('product', $pid);
       $query = $this->db->get($this->tableName)->num_rows();
       if ($query > 0) { return TRUE; } else { return FALSE; }
    }
    
    function get_details($pid)
    {
       $this->db->select($this->field); 
       $this->db->where('product', $pid);
       return $this->db->get($this->tableName); 
    }
    

}

/* End of file Property.php */
