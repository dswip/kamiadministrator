<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warehouse_transaction_lib {

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->product = new Product_lib();
    }

    private $ci,$product;
    private $table = 'warehouse_transaction';

//  $date = tanggal, $code = PJ/ SJ, $product = product, $in = 0, $out = 0;


    function get_amount($no)
    {
//        $this->ci->db->select('dates,code,currency,amount');
        $this->ci->db->select_sum('amount');
        $this->ci->db->where('code', $no);
        $res = $this->ci->db->get($this->table)->row_array();
        return intval($res['amount']);
    }
    
    function add($date, $code, $cur='IDR', $product, $in=0, $out=0, $price=0, $amount=0, $log=null)
    {
//        $balance = $this->product->get_qty($product);
        $opening = 0;
        $balance = 0;
//        if ($in>0){ $opening = $balance - $in; }elseif ($out > 0){ $opening = $balance + $out; }
        
        $trans = array('dates' => $date, 'code' => $code, 'currency' => $cur, 'product' => $product, 'in' => $in, 'out' => $out, 'price' => $price, 
                       'amount' => $amount, 'open' => $opening, 'balance' => $balance, 'log' => $log);
        $this->ci->db->insert('warehouse_transaction', $trans);
    }

//    ============================  remove transaction journal ==============================

    function remove($dates,$codetrans,$product)
    {
        // ============ update transaction ===================
        $this->ci->db->where('dates', $dates);
        $this->ci->db->where('code', $codetrans);
        $this->ci->db->where('product', $product);
        $this->ci->db->delete('warehouse_transaction');
        // ====================================================
    }
    
    function get_monthly($product,$month=0,$year=0)
    {
        $this->ci->db->select('code, dates, in, out, balance, log');
        $this->ci->db->where('product', $product);
        $this->ci->db->where('MONTH(dates)', $month);
        $this->ci->db->where('YEAR(dates)', $year);
        $this->ci->db->order_by('id','asc');
        return $this->ci->db->get($this->table);
    }
    
    function get_opening($product,$start,$end)
    {
        $this->ci->db->select('id, dates, in, out, open, balance, log');
        $this->ci->db->where('product', $product);
        $this->ci->db->where("dates BETWEEN '".setnull($start)."' AND '".setnull($end)."'");
        $this->ci->db->order_by('id','asc');
        $this->ci->db->limit(1);
        return $this->ci->db->get($this->table)->row();
    }
    
    function get_beginning_balance($product,$start,$end)
    {
       $this->ci->db->select_sum('in', 'ins');
       $this->ci->db->select_sum('amount');
       $this->ci->db->where('product', $product);
       if ($start != null){ $this->ci->db->where('dates >=', $start); }
       $this->ci->db->where('dates <', $end);
       return $this->ci->db->get($this->table)->row_array();
    }
    
    function get_transaction($product,$start,$end)
    {
        $this->ci->db->select('id, code, currency, product, dates, in, out, open, price, balance, amount, log');
        $this->ci->db->where('product', $product);
        $this->ci->db->where("dates BETWEEN '".setnull($start)."' AND '".setnull($end)."'");
//        $this->ci->db->order_by('id','asc');
        $this->ci->db->order_by('dates','asc');
        return $this->ci->db->get($this->table);
    }
    
    function get_sum_transaction_open_balance($product,$start)
    {
        $this->ci->db->select_sum('in', 'ins');
        $this->ci->db->select_sum('out', 'outs');
        $this->ci->db->where('product', $product);
        $this->ci->db->where('dates <', $start);
        $res = $this->ci->db->get($this->table)->row_array();
        return @intval($res['ins']-$res['outs']);
    }
   
    
    function get_sum_transaction_qty($product,$month,$year)
    {
        $this->ci->db->select_sum('in', 'ins');
        $this->ci->db->select_sum('out', 'outs');
        $this->ci->db->where('product', $product);
        $this->ci->db->where('MONTH(dates)', $month);
        $this->ci->db->where('YEAR(dates)', $year);
        $res = $this->ci->db->get($this->table)->row_array();
        return intval($res['ins']-$res['outs']);
    }

    private function cek_null($val,$field)
    {
        if ($val == ""){return null;}
        else {return $this->ci->db->where($field, $val);}
    }
}

/* End of file Property.php */
