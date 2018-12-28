<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formulasw40_lib {

    public function __construct()
    {
        $this->product = new Product_lib();
    }
    
    private $product,$daun,$daunhidup,$kacamati,$tulangdaun;
    
    function calculate($type=null,$width=0,$height=0,$pid=0,$heightkm=0){
       
        $pro = $this->product->get_detail_based_id($pid); 
        $this->daun = $pro->daun;
        $this->daunhidup = $pro->daunhidup;
        $this->kacamati = $pro->kacamati;
        $this->tulangdaun = $pro->tulang_daun;
        
        $res = 0;
        switch ($type) {
        case "KACA": $res = $this->c_kaca($width, $height); break;
        case "KUSEN SAYAP": $res = $this->c_kusen($width, $height, $heightkm); break;
        case "DAUN PINTU": $res = $this->c_daun($width, $height, $heightkm); break;
        case "TULANG PALSU": $res = $this->c_tulang_palsu($width, $height); break;
        case "TULANG DAUN": $res = $this->c_tulang_daun($width, $height, $this->tulangdaun); break;
        case "ACCESSORIES": $res = $this->product->get_bone($pid); break;
        } return $res;
    }
    
    function c_tulang_daun($width=0,$height=0,$type=0){
        
        if ($type == 0){ return 0; }
        elseif ($type == 1){ return floatval(2*$width+$height); }
        elseif ($type == 2){ return floatval(2*$width+2*$height); }
        elseif ($type == 3){ return floatval(2*$width); }
    }
    
    function c_kaca($width=0,$height=0)
    {
       return floatval($width*$height);
    }
    
    function c_tulang_palsu($width=0,$height=0,$heightkm=0)
    {
        if ($this->daun == 1){
            return floatval(0);
        }elseif ($this->daun == 2){
            $res1 = floatval(1*$height);
            return floatval($res1); 
        }
    }
    
    function c_kusen($width=0,$height=0)
    {
       // =C3+2*C4
       return floatval($width+2*$height);
    }
    
    function c_daun($width=0,$height=0,$heightkm=0)
    {
         if ($this->daun == 1){
             // =2*C3+2*C4
            $res1 = floatval(2*$width);
            $res2 = floatval(2*$height);
            return floatval($res1+$res2);
         }elseif ($this->daun == 2){
             // =2*C3+4*C4
             $res1 = floatval(2*$width);
             $res2 = floatval(4*$height);
             return floatval($res1+$res2);
         }
    }

}

/* End of file Property.php */
