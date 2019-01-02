<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank_lib extends Main_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'bank';
    }

    private $ci;
    
    protected $field = array('id', 'acc_name', 'acc_no', 'acc_bank', 'currency',
                             'created', 'updated', 'deleted');
       
    
    function get(){
        
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->order_by('id', 'asc');
        return $this->db->get($this->tableName)->result();
    }
    
    function get_details($id,$type=null)
    {
        if ($id != 0){
           $this->db->where('id', $id);
           if (!$type){ return $this->db->get($this->tableName);  }
          else { $res = $this->db->get($this->tableName)->row(); return $res->$type;  }
        }
    }
    
    function combo()
    {
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->order_by('acc_name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->acc_no.' : '.$row->acc_name); }
        return $data;
    }


}

/* End of file Property.php */