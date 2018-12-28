<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formula120_lib {

    public function __construct()
    {
        $this->product = new Product_lib();
    }
    
    private $product,$daun,$daunhidup;
    
    function calculate($type=null,$width=0,$height=0,$pid=0){
       
        $pro = $this->product->get_detail_based_id($pid); 
        $this->daun = $pro->daun;
        $this->daunhidup = $pro->daunhidup;
        
        $res = 0;
        switch ($type) {
        case "KACA": $res = $this->c_kaca($width, $height); break;
        case "JANGKAR": $res = $this->c_jangkar($width, $height); break;
        case "DAUN PINTU": $res = $this->c_daun($width, $height); break;
        case "KUSEN": $res = $this->c_kusen($width, $height); break;
        case "PENUTUP": $res = $this->c_penutup($width, $height); break;
        case "REL": $res = $this->c_rel($width,$height); break;
        case "ACCESSORIES": $res = $this->product->get_bone($pid); break;
        } return $res;
    }
    
    function c_kaca($width=0,$height=0)
    {
       return floatval($width*$height);
    }
    
    function c_kusen($width=0,$height=0)
    {
        if ($this->daun == 2 || $this->daun == 4){
            $res1 = floatval(2*$width);
            $res2 = floatval(2*$height);
            return floatval($res1+$res2);
        }elseif ($this->daun == 3){
            $res1 = floatval(4*$width);
            $res2 = floatval(4*$height);
            return floatval($res1+$res2); 
        }
    }
    
    function c_daun($width=0,$height=0)
    {
        
        if ($this->daun == 2){
           $res1 = floatval(2*$width);
           $res2 = floatval(4*$height);
           return floatval($res1+$res2);
        }elseif ($this->daun == 3){
            $res1 = floatval(2*$width);
            $res2 = floatval(6*$height);
            return floatval($res1+$res2);
        }elseif ($this->daun == 4){
            $res1 = floatval(2*$width);
            $res2 = floatval(8*$height);
            return floatval($res1+$res2);
        }
    }
    
    function c_jangkar($width=0,$height=0)
    {   
        if ($this->daun == 2){ return floatval(2*$height);
        }elseif ($this->daun == 3 || $this->daun == 4){ return floatval(4*$height); }
    }
    
    function c_penutup($width=0,$height=0)
    {
        $res1 = floatval(4*$width);
        $res2 = floatval(4*$height);
        return floatval($res1+$res2);
    }
    
    function c_rel($width=0,$height=0)
    {
        $daun= $this->daun;
        $daunhidup= $this->daunhidup;
        
        if ($daun == 2 && $daunhidup == 1){
            return floatval($width*1);
        }elseif ($daun == 2 && $daunhidup == 2){
            return floatval($width*2);
        }elseif ($daun == 3 && $daunhidup == 2){
            return floatval($width*2);
        }elseif ($daun == 3 && $daunhidup == 3){
            return floatval($width*3);
        }elseif ($daun == 4 && $daunhidup == 2){
            return floatval($width*1);
        }elseif ($daun == 4 && $daunhidup == 4){
            return floatval($width*2);
        }
    }

}

/* End of file Property.php */
