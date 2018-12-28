<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courier_Balance_lib extends Custom_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'wallet_courier_balances';
    }
   
    protected $field = array('id', 'courier', 'beginning', 'end', 'vamount', 'month', 'year', 'created', 'updated', 'deleted');
            
    function create($cust,$month=0,$year=0,$begin=0,$end=0)
    {
       $this->db->select($this->field); 
       $this->db->where('courier',$cust);
       $this->db->where('month',$month);
       $this->db->where('year',$year);
       $query = $this->db->get($this->tableName)->num_rows();
       
       if ($query == 0){ $this->fill($cust, $month, $year, $begin, $end); }
       else{ $this->edit($cust, $month, $year, $begin, $end); }
    }
    
    private function edit($cust,$month=0,$year=0,$begin=0,$end=0)
    {
       $trans = array('beginning' => $begin, 'end' => $end);
       $this->db->where('courier', $cust);
       $this->db->where('month', $month);
       $this->db->where('year', $year);
       $this->db->update($this->tableName, $trans); 
    }
    
    function fill($cust,$month,$year,$begin=0,$end=0)
    {
       $this->db->where('courier',$cust);
       $this->db->where('month',$month);
       $this->db->where('year',$year);
       $num = $this->db->get($this->tableName)->num_rows();
       
       if ($num == 0)
       {
          $trans = array('courier' => $cust, 'month' => $month, 'year' => $year, 'beginning' => $begin, 'end' => $end);
          $this->db->insert($this->tableName, $trans); 
       }
    }
    
    /// ========================= vamount ======================================
    
    function create_vamount($cust,$month=0,$year=0,$amt=0)
    {
       $this->db->where('courier',$cust);
       $this->db->where('month',$month);
       $this->db->where('year',$year);
       $query = $this->db->get($this->tableName)->num_rows();
       
       if ($query == 0){ $this->fill_vamount($cust, $month, $year, $amt); }
       else{ $this->edit_vamount($cust, $month, $year, $amt); }
    }
    
    private function edit_vamount($cust,$month=0,$year=0,$amt=0)
    {
       $trans = array('vamount' => $amt);
       $this->db->where('courier', $cust);
       $this->db->where('month', $month);
       $this->db->where('year', $year);
       $this->db->update($this->tableName, $trans); 
    }
    
    function fill_vamount($cust,$month,$year,$amt=0)
    {
       $this->db->where('courier',$cust);
       $this->db->where('month',$month);
       $this->db->where('year',$year);
       $num = $this->db->get($this->tableName)->num_rows();
       
       if ($num == 0)
       {
          $trans = array('courier' => $cust, 'month' => $month, 'year' => $year, 'vamount' => $amt);
          $this->db->insert($this->tableName, $trans); 
       }
    }
    
    function remove_balance($cust)
    {
       $this->db->where('courier',$cust); 
       $this->db->delete($this->tableName);
    }
    
    function get($cust,$month,$year)
    {
       $this->db->select($this->field);  
       $this->db->where('courier',$cust);
       $this->db->where('month',$month);
       $this->db->where('year',$year);
       return $this->db->get($this->tableName)->row();
    }
    
    function update_balance($id,$amount,$type='end')
    {
       if ($type == 'end'){ $balance = array('end' => $$amount); }else{ $balance = array('beginning' => $$amount);  }
       $this->db->where('id',$id);
       $this->db->update($this->tableName, $balance);
    }

}

/* End of file Property.php */
