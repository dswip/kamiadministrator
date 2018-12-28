<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cart_model extends Custom_Model
{
    protected $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('cart');
        $this->tableName = 'cart';
    }
    
    protected $field = array('id', 'customer', 'product_id', 'qty', 'tax', 'amount', 'price', 'attribute', 'description' , 'publish', 'created');
    protected $com;
    
    function create($cart){
        
        $result = $this->cek($cart['customer'], $cart['product_id'], $cart['description']);
        
        if ($result == 'TRUE'){ 
            $this->add($cart); 
        }else{
           $this->edit_qty($result, $cart['qty']);
        }
    }
    
    function edit_qty($uid,$qty=0){
        
        $res = $this->get_by_id($uid)->row();
        $oldqty = intval($res->qty+$qty);
        $amount = intval($res->price)*intval($oldqty);
        $val = array('amount' => $amount, 'qty' => $oldqty);
        $this->db->where('id', $uid);
        $this->db->update($this->tableName, $val);
    }
    
    function cek($cust,$pid,$desc){
        
        $this->db->where('customer', $cust);
        $this->db->where('product_id', $pid);
        $this->db->where('description', $desc);
        $num = $this->db->get($this->tableName)->num_rows();
        $res = $this->db->get($this->tableName)->row();
        if ($num > 0){ return $res->id; }else{ return 'TRUE'; }
    }
    
    function get_by_customer($customer=null)
    {
        $this->db->select($this->field);
        $this->cek_null($customer, 'customer');
        $this->db->order_by('created', 'desc'); 
        $this->db->from($this->tableName); 
        return $this->db->get(); 
    }
    
    function delete_by_customer($customer=null,$publish=1){
        
        $this->db->where('customer', $customer);
        $this->db->where('publish', $publish);
        $this->db->delete($this->tableName);
    }
    
    function updateid($uid, $users)
    {
        $this->db->where('id', $uid);
        $this->db->update($this->tableName, $users);
        
        $val = array('created' => date('Y-m-d H:i:s'));
        $this->db->where('id', $uid);
        $this->db->update($this->tableName, $val);
    }
    
    function publish($uid)
    {
        $this->db->where('id', $uid);
        $this->db->from($this->tableName); 
        $value = $this->db->get()->row();
        if ($value->publish == 1){ $publish = 0; $stts = 'unpublished'; }else{ $publish = 1; $stts = 'published'; }
        
        $val = array('publish' => $publish);
        $this->db->where('id', $uid);
        $this->db->update($this->tableName, $val);
        return $stts;
    }
    
    function total($customer=0,$publish=0){
        
        $this->db->select_sum('amount');
        $this->db->select_sum('price');
        $this->db->select_sum('qty');
        $this->db->where('customer', $customer);
        $this->db->where('publish', $publish);
        return $this->db->get($this->tableName)->row_array();
    }

}

?>