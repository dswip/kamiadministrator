<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_lib extends Custom_Model {
    
    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'product';
        $this->sales = new Sales_lib();
    }
    
    private $sales;
    protected $field = array('id', 'sku', 'category', 'name', 'description', 'image', 'url_type', 'url1', 'url2', 'url3',
                             'url4', 'url5', 'url6', 'capital', 'price', 'supplier', 'restricted', 'qty', 'start', 'end',
                             'recommended', 'orders', 'publish', 'created', 'updated', 'deleted');

    function cek_relation($id,$type)
    {
       $this->db->where($type, $id);
       $query = $this->db->get('product')->num_rows();
       if ($query > 0) { return FALSE; } else { return TRUE; }
    }
    
    function valid_product($id)
    {
       $this->db->where('id', $id);
       $query = $this->db->get('product')->num_rows();
       if ($query > 0) { return TRUE; } else { return FALSE; }
    }

    function get_details($name=null)
    {
        if ($name)
        {
           $this->db->select($this->field);
           $this->db->where('name', $name);
           return $this->db->get('product')->row();
        }
    }
    
    function get_qty($pid=0){
        
        $res = $this->get_by_id($pid)->row();
        
        if ($res->restricted == 0){ $qty = 0; }else{
               $sales_qty = $this->sales->total_based_date(date('Y-m-d'),$res->id);
               $sales_qty = intval($sales_qty['qty']);
               $qty = intval($res->qty-$sales_qty);
        }
        return $qty;
    }

    function get_id($name=null)
    {
        if ($name)
        {
           $this->db->select($this->field);
           $this->db->where('name', $name);
           $res = $this->db->get('product')->row();
           return $res->id;
        }
    }

    function get_name($id=null)
    {
        if ($id)
        {
           $this->db->select($this->field);
           $this->db->where('id', $id);
           $res = $this->db->get('product')->row();
           return @$res->name;
        }
    }
    
    function get_price($id=null)
    {
        if ($id)
        {
           $this->db->select($this->field);
           $this->db->where('id', $id);
           $res = $this->db->get('product')->row();
           return intval($res->price);
        }
    }
     
    function get_sku($id=null)
    {
        if ($id)
        {
           $this->db->select($this->field);
           $this->db->where('id', $id);
           $res = $this->db->get('product')->row();
           return @$res->sku;
        }
    }
      
    function get_detail_based_id($id=null)
    {
        if ($id)
        {
           $this->db->select($this->field);
           $this->db->where('id', $id);
           $res = $this->db->get('product')->row();
           return $res;
        }
    }
  
    function get_all()
    {
      $this->db->select($this->field);
      $this->db->order_by('name', 'asc');
      return $this->db->get('product');
    }
    
    function combo()
    {
        $this->db->select($this->field);
        $this->db->where('deleted', $this->deleted);
        $this->db->where('publish', 1);
        $val = $this->db->get($this->tableName)->result();
        if ($val){ foreach($val as $row){$data['options'][$row->id] = ucfirst($row->name);} }
        else { $data['options'][''] = '--'; }        
        return $data;
    }
    
    function combo_publish($id)
    {
        $this->db->select($this->field);
        $this->db->where('deleted', $this->deleted);
        $this->db->where('publish', 1);
        $this->db->where_not_in('id', $id);
        $val = $this->db->get($this->tableName)->result();
        if ($val){ foreach($val as $row){$data['options'][$row->id] = ucfirst($row->name);} }
        else { $data['options'][''] = '--'; }        
        return $data;
    }
    
    function get_product_based_category($cat)
    {
        $this->db->select_sum('qty');
        $this->db->where('deleted', $this->deleted);
        $this->db->where('publish', 1);
        $this->db->where('category', $cat);
        $res = $this->db->get($this->tableName)->row_array();
        return intval($res['qty']); 
    }
    
    // api purpose
    
    function get_poduct_based_cat($catid,$limit=5,$offset=0){
        
        $this->db->select($this->field);
        $this->db->where('deleted', $this->deleted);
        $this->db->where('publish', 1);
        $this->db->where('category', $catid);
        $this->db->order_by('orders', 'asc'); 
        $this->db->limit($limit, $offset);
        return $this->db->get($this->tableName);
    }
    
    function get_recommended($limit=100){
        
        $this->db->select($this->field);
        $this->db->where('deleted', $this->deleted);
        $this->db->where('publish', 1);
        $this->db->where('recommended', 1);
        $this->db->order_by('orders', 'desc'); 
        $this->db->limit($limit);
        return $this->db->get($this->tableName)->result();
    }
    
    function valid_restricted($pid){
        
        $this->db->select($this->field);
        $this->db->where('id', $pid);
        $res = $this->db->get($this->tableName)->row();
        
        if ($res->restricted == 1){
            $now = date('H:i:s');
            if ($now >= $res->start && $now <= $res->end){ return TRUE; }else{ return FALSE; }
        }else{ return TRUE; }
    }
    
    function valid_qty($pid,$req=0){
        
        $this->db->select($this->field);
        $this->db->where('id', $pid);
        $res = $this->db->get($this->tableName)->row();
        
        if ($res->restricted == 1){
            $qty = $this->sales->total_based_date(date('Y-m-d'),$pid);
            $qty = intval($qty['qty']);
            $qty = intval($req + $qty);
            if ($qty <= $res->qty){ return TRUE; }else{ return FALSE; }
        }else{ return TRUE; }
    }
    
    function get_slider(){
        
        $this->db->select('id, name, image, url, orders');
        $this->db->where('deleted', $this->deleted);
        $this->db->order_by('orders', 'asc'); 
        return $this->db->get('slider')->result();
    }

}

/* End of file Property.php */