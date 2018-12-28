<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shipping_lib extends Custom_Model {
    
    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'delivery';
    }

    protected $field = array('id', 'sales_id', 'dates', 'courier', 'coordinate', 'destination', 'distance', 'received',
                             'amount', 'confirm_customer', 'rating', 'comments', 'status', 'created', 'updated', 'deleted');
    
    function cek_relation($id,$type)
    {
       $this->db->where($type, $id);
       $query = $this->db->get('product')->num_rows();
       if ($query > 0) { return FALSE; } else { return TRUE; }
    }
    
    function get_detail_based_sales($id=null)
    {
        if ($id)
        {
           $this->db->select($this->field);
           $this->db->where('sales_id', $id);
           $res = $this->db->get($this->tableName)->row();
           return $res;
        }
    }
    
    function cek_shiping_based_sales($sid)
    {
       if ($sid)
        {
           $this->db->select($this->field);
           $this->db->where('sales_id', $sid);
           $res = $this->db->get($this->tableName)->row();
           if ($res){
              if ($res->received){ return true; }else{ return false; } 
           }
           
        } 
    }
    
    function create($sid,$param)
    {
      $this->db->where('sales_id', $sid);
      $query = $this->db->get($this->tableName)->num_rows();
      if ($query > 0) {$this->edit($sid, $param); } 
      else { $this->add_new($param); }  
    }
    
    private function add_new($param)
    {
       $this->db->insert($this->tableName, $param); 
    }
    
    // fungsi ini di panggil untuk update shipping by sales id
    function edit($sid,$param)
    {
       $this->db->where('sales_id', $sid);
       $this->db->update($this->tableName, $param); 
    }
    
    function delete_by_sales($sid)
    {
       $this->db->where('sales_id', $sid);
       $this->db->delete($this->tableName);
    }
    
    function total($sid)
    {
      $this->db->where('sales_id', $sid);
      $query = $this->db->get($this->tableName)->row();
      if ($query){ return floatval($query->amount); }else{ return 0; }
    }
    
    function cleaning(){
        $val = array('deleted' => date('Y-m-d H:i:s'));
        $this->db->where('dates <>', date('Y-m-d'));
        $this->db->where('status', 0);
        $this->db->where('deleted', $this->deleted);
        $this->db->update($this->tableName, $val);
    }
    
    
    // function to get all free courier
    function valid_free($uid){
        $this->db->where('courier', $uid);
        $this->db->where('deleted', $this->deleted);
        $this->db->where('status', 1);
        $this->db->where('received IS NULL');
        $num = $this->db->get($this->tableName)->num_rows();
        if ($num > 0){ return FALSE; }else{ return TRUE; }
    }

}

/* End of file Property.php */