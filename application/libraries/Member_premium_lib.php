<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_premium_lib extends Custom_Model {
    
    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'member_premium';
    }
    
    protected $field = array('id', 'member_id', 'product_id', 'joined', 'end', 'amount', 'status', 'orderid');
    
    function valid_product($id)
    {
       $this->db->where('id', $id);
       $query = $this->db->get('product')->num_rows();
       if ($query > 0) { return TRUE; } else { return FALSE; }
    }
    
    function post_premium($uid,$member){
        
        $premium = $this->get_detail_based_id($uid);
        if ($premium->status == 1){ $this->unpublish_id($uid); return TRUE; }else{
            $now = date('Y-m-d');
            if ($now <= $premium->end){
                $this->unpublish($member);
                $this->publish($uid);
                return TRUE;
            }else{ $this->unpublish($member); $this->unpublish_id($uid); return FALSE; }
        }
    }
    
    // fungsi mendapatkan status premium member atau tidak
    function get_status($member){
         $this->db->select($this->field);
         $this->db->where('member_id', $member);
         $this->db->where('status', 1);
         $res = $this->db->get($this->tableName)->num_rows();
         if ($res > 0){ return TRUE; }else{ return FALSE; }
    }
    
    function cek_status($member){
         $this->db->select($this->field);
         $this->db->where('member_id', $member);
         $this->db->where('end >=', date('Y-m-d'));
         $this->db->order_by('end', 'asc'); 
         $this->db->limit(1);
         $res = $this->db->get($this->tableName);
         if ($res->num_rows() > 0){
             $rows = $res->row();
             $this->unpublish($member);
             $this->publish($rows->id);
             return TRUE;
         }else{ $this->unpublish($member); return FALSE; }
    }
    
    private function unpublish_id($uid){
       $val = array('status' => 0);
       $this->db->where('id', $uid);
       $this->db->update($this->tableName, $val); 
    }
      
    private function unpublish($member){
       $val = array('status' => 0);
       $this->db->where('member_id', $member);
       $this->db->update($this->tableName, $val); 
    }
    
    private function publish($uid){
       $val = array('status' => 1);
       $this->db->where('id', $uid);
       $this->db->update($this->tableName, $val); 
    }
    
    function get_detail_based_order($id=null)
    {
        if ($id)
        {
           $this->db->select($this->field);
           $this->db->where('orderid', $id);
           $res = $this->db->get($this->tableName)->row();
           return $res;
        }
    }
    
    function get_detail_based_id($id=null)
    {
        if ($id)
        {
           $this->db->select($this->field);
           $this->db->where('id', $id);
           $res = $this->db->get($this->tableName)->row();
           return $res;
        }
    }
    
    function get_detail_based_member($member=null)
    {
        if ($member)
        {
           $this->db->select($this->field);
           $this->db->where('member_id', $member);
           $res = $this->db->get($this->tableName);
           return $res;
        }
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
    
    function remove($uid)
    {
       $this->db->where('id', $uid);
       $this->db->delete($this->tableName);
    }
    
    function insert($users)
    {
       $this->db->insert($this->tableName, $users);
    }
   
}

/* End of file Property.php */