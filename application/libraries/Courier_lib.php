<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courier_lib extends Main_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'courier';
    }

    private $ci;
    
    protected $field = array('id', 'ic', 'name', 'phone', 'address', 'email', 'image', 'company', 'joined', 'status', 'created', 'updated', 'deleted');
        
    function get_detail($id=null,$type=null)
    {
        $this->db->select($this->field);
        $this->db->where('id', $id);
        $val = $this->db->get($this->tableName)->row();
        if ($val){ return ucfirst($val->$type); }
    }
    
    function get(){
        
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'asc');
        return $this->db->get($this->tableName); 
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
    
    // push notif to all courier free
    function push_courier($mess=null){
        
        $login = new Courier_login_lib();
        $shipping = new Shipping_lib();
        $push = new Push_lib();
        
        $output = array();
        $i=0;
        $result = $login->get_coordinate_all()->result();
        foreach($result as $res){   
            
           if ($shipping->valid_free($res->userid) == TRUE){
              $output[$i] = $res->device;   
              $i++;
           }
	} 
        
        $push->send_multiple_device($output, $mess);  
    }
    
   
    
    


}

/* End of file Property.php */