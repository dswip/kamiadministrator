<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Period_lib extends Custom_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'periods';
    }

    private $ci;

    protected $field = array('id', 'month', 'year', 'closing_month', 'start_month', 'start_year', 'status');


    public function get($type=null)
    {
       $this->db->select($this->field);
       $val = $this->db->get($this->tableName)->row();
       if ($type == 'month'){ return $val->month; }
       elseif ($type == 'year') { return $val->year; }
       else { return $val; }
    }
    
    function update_period($month, $year)
    {
        $val = array('month' => $month, 'year' => $year);
        $this->db->where('id', 1);
        $this->db->update($this->tableName, $val);
    }
    
    function updateid($uid, $users)
    {
        $this->db->where('id', $uid);
        $this->db->update($this->tableName, $users);
        
        $val = array('updated' => date('Y-m-d H:i:s'));
        $this->db->where('id', $uid);
        $this->db->update($this->tableName, $val);
    }
    
}

/* End of file Property.php */