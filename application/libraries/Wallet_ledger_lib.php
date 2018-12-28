<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallet_ledger_lib {

    public function __construct()
    {
        $this->ci = & get_instance();
    }

    private $ci;
    private $table = 'wallet_ledger';
    protected $field = array('id', 'customer', 'code', 'no', 'dates', 'debit', 'credit', 'vamount', 'created', 'updated', 'deleted');


    private function cek($code, $no, $cust, $date)
    {
       $this->ci->db->where('dates', $date);
       $this->ci->db->where('code', $code);
       $this->ci->db->where('no', $no);
       $this->ci->db->where('customer', $cust);
       $res = $this->ci->db->get($this->table)->num_rows();
       if ($res > 0){ return FALSE; }else { return TRUE; }
    }
    
    function add($code, $no, $date, $debit=0, $credit=0, $cust)
    {  
        if ($this->cek($code, $no, $cust, $date) == TRUE)
        {
          $vamount = intval($debit-$credit);
          $trans = array('code' => $code, 'no' => $no, 'dates' => $date, 
                         'debit' => intval($debit), 'credit' => intval($credit), 
                         'vamount' => $vamount, 'customer' => $cust, 'created' => date('Y-m-d H:i:s'));
          $this->ci->db->insert($this->table, $trans);
        }
        else { $this->edit($code, $no, $date, $debit, $credit, $cust); }
    }
    
    private function edit($code, $no, $date, $debit=0, $credit=0, $cust)
    {   
        $id = $this->get_id($code, $no, $cust, $date);
        
        $vamount = intval($debit-$credit);
        $trans = array('code' => $code, 'no' => $no, 'dates' => $date, 'debit' => $debit, 'credit' => $credit, 'vamount' => $vamount, 'customer' => $cust);
        $this->ci->db->where('id', $id);
        $this->ci->db->update($this->table, $trans);
    }
    
    private function get_id($code, $no, $cust, $date)
    {
       $this->ci->db->where('dates', $date);
       $this->ci->db->where('code', $code);
       $this->ci->db->where('no', $no);
       $this->ci->db->where('customer', $cust);
       $res = $this->ci->db->get($this->table)->row();
       return $res->id;
    }

//    =================  remove transaction journal =================

    function remove($dates,$codetrans,$no)
    {
        // ============ update transaction ===================
        $this->ci->db->where('dates', $dates);
        $this->ci->db->where('code', $codetrans);
        $this->ci->db->where('no', $no);
        $this->ci->db->delete($this->table);
        // ===================================================
    }
    
    private function cek_null($val,$field)
    {
        if ($val == ""){return null;}
        else {return $this->ci->db->where($field, $val);}
    }
    
    function get_transaction_monthly($cust,$month,$year)
    {
        $this->ci->db->select($this->field);
        $this->ci->db->where('customer', $cust);
        $this->ci->db->where('MONTH(dates)', $month);
        $this->ci->db->where('YEAR(dates)', $year);
        $this->ci->db->order_by('id','asc');
        $res = $this->ci->db->get($this->table)->result();
        return $res;
    }
    
    function get_sum_transaction_monthly($cust,$month,$year)
    {
        $this->ci->db->select_sum('debit');
        $this->ci->db->select_sum('credit');
        $this->ci->db->select_sum('vamount');
        
        $this->ci->db->where('customer', $cust);
        $this->ci->db->where('MONTH(dates)', $month);
        $this->ci->db->where('YEAR(dates)', $year);
        $res = $this->ci->db->get($this->table)->row_array();
        return $res;
    }
     
     // closing function
    function get_sum_transaction_balance($acc, $cur, $start,$end,$cust,$type)
    {
        $this->ci->db->select_sum('debit');
        $this->ci->db->select_sum('credit');
        $this->ci->db->select_sum('vamount');
        
        $this->ci->db->where('acc', $acc);
        $this->ci->db->where('currency', $cur);
        $this->ci->db->where('customer_id', $cust);
        $this->ci->db->where('type', $type);
        $this->ci->db->where("dates BETWEEN '".setnull($start)."' AND '".setnull($end)."'");
        $res = $this->ci->db->get($this->table)->row_array();
        return $res;
    }
    
}

/* End of file Property.php */