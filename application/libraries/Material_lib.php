<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Material_lib extends Main_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'material';
        $this->material = new Material_list_lib();
    }

    private $material;
    
    protected $field = array('id', 'name', 'model', 'price', 'color', 'type', 'glass', 'weight', 'groups', 'created', 'updated', 'deleted');
    
    function cek_relation($id,$type)
    {
       $this->db->where($type, $id);
       $query = $this->db->get($this->tableName)->num_rows();
       if ($query > 0) { return FALSE; } else { return TRUE; }
    }
    
    function get_type($series=0){
        
      $this->db->select('type');
      $this->db->where('model', $series);
      $this->db->where('glass', 0);
      $this->db->where('deleted', NULL);
      $this->db->distinct();
      return $this->db->get($this->tableName); 
    }
    
    function combo_type($series=null)
    {
        $data = null;
        $this->db->select('type');
        $this->db->where('model', $series);
        $this->db->where('glass', 0);
        $this->db->where('deleted', NULL);
        $val = $this->db->get($this->tableName)->result();
        $data['options'][''] = '--';
        if ($val){
          foreach($val as $row){ $data['options'][$row->type] = ucfirst($row->type); }
        }
        return $data;
    }
    
    function get_details($id)
    {
       $this->db->where('id', $id);
       return $this->db->get($this->tableName); 
    }
    
    function get_name($id=null)
    {
        if ($id)
        {
            $this->db->select($this->field);
            $this->db->where('id', $id);
            $val = $this->db->get($this->tableName)->row();
            if ($val){ return $val->name; }else { return ''; }
        }
        else { return ''; }
    }
    
    function combo()
    {
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->order_by('name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        return $data;
    }
    
    function get_price($pid,$material, $color=null, $type=null, $glassid=null, $group=1){
        
        $this->db->select('material.id, material.name, material.model, material.price, material.color, material.type, material.glass, material.groups');
        $this->db->from($this->tableName);
        $this->db->where('material.material_list', $material);
        $result = $this->db->get();
        $result = $result->row();
        
        if ($result->glass != 1){
            return $this->get_material_price($pid, $material, $color, $type, $group);
        }else{   return $this->get_glass($glassid,$type,$group); }
    }
    
    // get material price
    private function get_material_price($pid,$material, $color=null, $type=null, $group=null){
        
       $this->db->select('material.id, material.name, material.model, material.price, material.color, material.type, material.glass');
       
       $this->db->from('product, material, material_list, assembly');
       $this->db->where('product.id = assembly.product');
       $this->db->where('material_list.id = assembly.material');
       $this->db->where('material_list.id = material.material_list');
       $this->db->where('product.model = material.model');
       $this->db->where('material.deleted', NULL);
       $this->db->where('assembly.product', $pid);
       $this->db->where('assembly.material', $material);
       
       $this->cek_null($color, 'material.color');
       $this->cek_null($type, 'material.type');
       $this->cek_null($group, 'material.groups');
       
       $this->db->distinct();
       $result = $this->db->get();
       $result = $result->row();
       
       return @intval($result->price);
    }
    
    private function get_glass($glassid=null, $type=null, $group=null){
        
        $this->db->select('material.id, material.name, material.model, material.price, material.color, material.type, material.glass'); 
        $this->db->from($this->tableName);
        $this->db->where('material.glass', 1);
        $this->db->where('material.deleted', NULL);

        if ($glassid){ $this->db->where('material.id', $glassid); }
        else{  $this->cek_null($type, 'material.type'); }
        $this->db->limit(1);
        $result = $this->db->get();
        $result = $result->row();
        return @intval($result->price);
    }
    
    function combo_glass($type=null)
    {
        $this->db->select($this->field);
        $this->db->where('material.glass', 1);
        $this->db->where('deleted', NULL);
        $this->db->where('type', $type);
        $this->db->order_by('name', 'asc');
        $val = $this->db->get($this->tableName)->result();
        if ($val){
          foreach($val as $row){ $data['options'][$row->id] = ucfirst($row->name); }
        }else{
          $data['options'][''] = '--';
        }
        return $data;
    }
    
    function get_glass_weight($w=0,$h=0,$glass=0){
        
        $luas = intval($w*$h);
        
        $this->db->select($this->field);
        $this->db->where('deleted', NULL);
        $this->db->where('id', $glass);
        $res = $this->db->get($this->tableName)->row();
        $res = $res->weight/1000;
        $vol = floatval($res*$luas);
        $weight = round(floatval($vol * 2580));
        
        return $weight;
//        Volume = 0,005m x 1m2 = 0,005m3 berat = 0,005m3 x 2579m3 = 12,895k
    }


}

/* End of file Property.php */