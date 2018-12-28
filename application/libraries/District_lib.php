<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class District_lib extends Main_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'kecamatan';
    }

    private $ci;
    
    function combo_district_db($cityid=null)
    {
        $data = null;
        if ($cityid != null)
        {
            $this->db->where('id_kabupaten', $cityid);
            $this->db->order_by('nama', 'asc'); 
            $val = $this->db->get($this->tableName)->result();
        }
        else {$val = $this->db->get($this->tableName)->result(); }
//        
        foreach($val as $row){$data['options'][$row->id] = $row->nama;}
        return $data;
    }
    
    function get_name($id)
    {
      $this->db->where('id', $id);
      $val = $this->db->get($this->tableName)->row();   
      if ($val){ return $val->nama; }else{ return null; }
    }
    
    function get_province($id)
    {
      $this->db->where('id', $id);
      $val = $this->db->get('provinsi')->row();   
      if ($val){ return $val->nama; }else{ return null; }
    }
    
    function combo_district_ajax($city=null,$type=null)
    {
        $this->cek_null($city, 'id_kabupaten');
        $val = $this->db->get($this->tableName)->result();
        
        if ($val){
            
          if ($type){ $name = 'cdistrictupdate'; }else{ $name = 'cdistrict'; }  
          $data = null;
          foreach($val as $row){$data['kecamatan'][$row->id] = $row->nama;}
          $js = "class='select2_single form-control' id='cdistrict' tabindex='-1' style='min-width:100px;' "; 
	  return form_dropdown($name, $data, isset($default['district']) ? $default['district'] : '', $js);
        }
    }
    
    private function splits($val)
    {
      $res = explode(".",$val); 
      return $res[0];
    }
   

}

/* End of file Property.php */