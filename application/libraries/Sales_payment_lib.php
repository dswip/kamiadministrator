<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_payment_lib extends Custom_Model {
    
    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'sales_payment';
    }

    protected $field = array('id', 'sales_id', 'code', 'dates', 'phase', 'amount', 'payment_id', 'bank_id', 'paid_contact', 'due_date',
                             'cc_no', 'cc_name', 'cc_bank', 'sender_name', 'sender_acc', 'sender_bank', 'sender_amount',
                             'confirmation', 'log', 'created', 'updated', 'deleted');

    function cek_relation($id,$type)
    {
       $this->db->where($type, $id);
       $query = $this->db->get('product')->num_rows();
       if ($query > 0) { return FALSE; } else { return TRUE; }
    }
    
    function get_detail($id=null)
    {
        if ($id)
        {
           $this->db->select($this->field);
           $this->db->where('id', $id);
           $res = $this->db->get($this->tableName)->row();
           return $res;
        }
    }
    
    function get_transaction($id=null)
    {
        if ($id)
        {
           $this->db->where('sales_id', $id);
           $res = $this->db->get($this->tableName);
           return $res;
        }
    }
    
    function total($pid)
    {
        $this->db->select_sum('amount');
        $this->db->where('sales_id', $pid);
        $this->db->where('confirmation', 1);
        $res = $this->db->get($this->tableName)->row_array();
        return floatval($res['amount']);
    }
    
    function delete_by_sales($sid)
    {
       $this->db->where('sales_id', $sid);
       $this->db->delete($this->tableName);
    }
  

}

/* End of file Property.php */