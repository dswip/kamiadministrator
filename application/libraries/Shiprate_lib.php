<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shiprate_lib extends Custom_Model {
    
    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'shiprate';
    }

    protected $field = array('id', 'courier', 'city', 'cityid', 'district', 'type', 'rate', 'created', 'updated', 'deleted');

    
    function combo_courier()
    {
        $data = null;
        $this->db->distinct();
        $val = $this->db->get($this->tableName)->result();
        if (!$val){ $data['options'][''] = '--'; }else{
           foreach($val as $row){$data['options'][$row->courier] = $row->courier;}    
        }
        return $data;
    }
    
    function get_city_name($city){
        
        $this->db->where('cityid', $city);
        $val = $this->db->get($this->tableName)->row();
        return $val->city;
    }
    
    function combo_city(){
        
        $data = null;
        $this->db->distinct();
        $val = $this->db->get($this->tableName)->result();
        if (!$val){ $data['options'][''] = '--'; }else{
           foreach($val as $row){$data['options'][$row->city] = $row->city;}    
        }
        return $data;
    }
    
    function combo_city_id(){
        
        $data = null;
        $this->db->distinct();
        $val = $this->db->get($this->tableName)->result();
        if (!$val){ $data['options'][''] = '--'; }else{
           foreach($val as $row){$data['options'][$row->cityid] = $row->city;}    
        }
        return $data;
    }
    
    function combo_district($city=null){
        
        $data = null;
        $this->db->where('cityid', $city);
        $this->db->distinct();
        $val = $this->db->get($this->tableName)->result();
        if (!$val){ $data['options'][''] = '--'; }else{
           foreach($val as $row){$data['options'][$row->district] = $row->district;}    
        }
        $js = "class='form-control' id='cdistrict' tabindex='-1' style='min-width:100px;' "; 
	return form_dropdown('cdistrict', $data, isset($default['district']) ? $default['district'] : '', $js);
    }
    
    function rate($city,$district,$type='weight',$courier='ESL'){
       
       $this->db->where('courier', $courier);
       $this->db->where('cityid', $city);
       $this->db->where('district', $district);
       $this->db->where('type', $type);
       $this->db->distinct();
       $val = $this->db->get($this->tableName)->row();
       return intval($val->rate);
    }

}

/* End of file Property.php */