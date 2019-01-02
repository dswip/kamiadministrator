<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formulacsmt100_lib {

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
        case "JANGKAR": $res = $this->c_jangkar($width, $height, $heightkm); break;
        case "DAUN JENDELA": $res = $this->c_daun($width, $height, $heightkm); break;
        case "DAUN KECIL": $res = $this->c_daun($width, $height, $heightkm); break;
        case "KUSEN": $res = $this->c_kusen($width, $height); break;
        case "ACCESSORIES": $res = intval($this->product->get_bone($pid)*2); break;
        case "TULANG": $res = $this->c_tulang($width, $height, $heightkm); break;
        case "POP KACA": $res = $this->c_pop($width, $height, $heightkm); break;
        case "KASA NYAMUK": $res = $this->c_kaca($width, $height); break;
        } return $res;
    }
    
    function c_kaca($width=0,$height=0)
    {
       return floatval($width*$height);
    }
    
    function c_tulang($width=0,$height=0,$heightkm=0)
    {
        if ($this->daun == 1){
            
            if ($this->kacamati == 0){ return 0; }
            elseif ($this->kacamati == 1){
               $res1 = floatval(1*$width);
               return floatval($res1);
            }
        }
        elseif ($this->daun == 2){
            
           if ($this->kacamati == 0){ return $height; } 
           elseif ($this->kacamati == 1){
               $res1 = floatval($height-$heightkm);
               return floatval($width+$res1);
           }   
        }
        elseif ($this->daun == 3){
            
           if ($this->kacamati == 0){ return floatval(2*$height); } 
           elseif ($this->kacamati == 1){
               
              $res1 = floatval($width+2*($height-$heightkm));
              return $res1;
           } 
           elseif ($this->kacamati == 3){
              $res1 = floatval($width+2*$height);
              return floatval($res1);  
           } 
        }
        elseif ($this->daun == 4){
            
           if ($this->kacamati == 0){ return floatval(3*$height); }  
           elseif ($this->kacamati == 2){
               // =C3+C4+2*(C4-C5)
              return floatval($width+$height+2*($height-$heightkm));  
           } 
           elseif ($this->kacamati == 4){
              $res1 = floatval($height*3);
              return floatval($res1+$width);  
           } 
        }

    }
    
    function c_pop($width=0,$height=0,$heightkm=0)
    {
        if ($this->kacamati == 1){
            
//            =2*C3+2*C5
            $res1 = floatval(2*$width+2*$heightkm);
            return floatval($res1);
        }elseif ($this->kacamati == 2){
            $res1 = floatval(2*$width);
            $res2 = floatval(4*$heightkm);
            return floatval($res1+$res2); 
        }elseif ($this->kacamati == 3){
            $res1 = floatval(2*$width);
            $res2 = floatval(6*$heightkm);
            return floatval($res1+$res2); 
        }elseif ($this->kacamati == 4){
            $res1 = floatval(2*$width+8*$heightkm);
            return floatval($res1); 
        }elseif($this->kacamati == 0){
            return 0;
        }
    }
    
    function c_kusen($width=0,$height=0)
    {
       // =2*C3+2*C4
       return floatval(2*$width+2*$height);        
    }
    
    function c_daun($width=0,$height=0,$heightkm=0)
    {
        if ($this->kacamati == 0){
           
            if ($this->daun == 1){
                // =2*C3+2*C4
                return floatval(2*$width+2*$height);
            }
            elseif ($this->daun == 2){
                //  =2*C3+4*C4
                return floatval(2*$width+4*$height);
             }elseif ($this->daun == 3){
//                 =2*C3+6*C4
                 return floatval(2*$width+6*$height);
             }elseif ($this->daun == 4){
//                 2*C3+8*C4
                 return floatval(2*$width+8*$height);
             } 
        }elseif ($this->kacamati == 1){
             if ($this->daun == 1){
                return floatval(2*$width+2*($height-$heightkm));
             }
             elseif ($this->daun == 2){
                return floatval(2*$width+4*($height-$heightkm));
             }elseif ($this->daun == 3){
                 
                // =2*C3+6*(C4-C5)
                return floatval(2*$width+6*($height-$heightkm));
             }
             elseif ($this->daun == 4){
                 $res1 = floatval(2*$width);
                 $res2 = floatval(8*($height-$heightkm));
//                 return floatval($res1+$res2);
             }
        }
        elseif ($this->kacamati == 2){
            if ($this->daun == 4){
                // =2*C3+8*(C4-C5)
                return floatval(2*$width+8*($height-$heightkm));
            }
        }
        elseif ($this->kacamati == 3){
            if ($this->daun == 3){
                // =2*C3+6*(C4-C5)
                return floatval(2*$width+6*($height-$heightkm));
            }
        }
        elseif ($this->kacamati == 4){
            if ($this->daun == 4){
                return floatval(2*$width+8*($height-$heightkm));
            }
        }
        
    }

}

/* End of file Property.php */
