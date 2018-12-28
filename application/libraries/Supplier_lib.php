<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier_lib extends Main_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'supplier';
    }

    private $ci;
    
    protected $field = array('id', 'name', 'type', 'cp', 'npwp', 'address', 'shipping_address', 'phone1', 'phone2', 'fax', 'hp',
                             'email', 'password', 'website', 'state', 'city', 'zip', 'notes', 'acc_name', 'acc_no', 'bank', 'image', 'joined', 'status',
                             'created', 'updated', 'deleted');
    
    function get_name($id=null)
    {
        if ($id)
        {
            $this->db->select('id,first_name,last_name');
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return ucfirst($val->first_name.' '.$val->last_name); }
        }
        else if($id == 0){ return 'Top'; }
        else { return ''; }
    }
    
    function get_type($id=null)
    {
        if ($id)
        {
            $this->db->select('type');
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return $val->type; }else { return 0; }
        }
        else { return 0; }
    }
    
    function get_cust_type($type=null)
    {
        $this->db->select($this->field);
        $this->db->where('type', $type);
        $this->db->where('status', 1);
        $this->db->where('deleted', $this->deleted);
        $val = $this->db->get($this->tableName)->result();
        return $val;
    }
    
    function get_details($id)
    {
       $this->db->where('id', $id);
       return $this->db->get($this->tableName); 
    }
    
    function combo()
    {
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->order_by('name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        $data = null;
        if ($val){
          foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }    
        }else{ $data['options'][''] = '--'; }
        return $data;
    }

}

/* End of file Property.php */