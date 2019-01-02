<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formulacsmt38_lib {

    public function __construct()
    {
        $this->product = new Product_lib();
    }
    
    private $product,$daun,$daunhidup,$kacamati,$tulangdaun, $kacamatibawah;
    
    function calculate($type=null,$width=0,$height=0,$pid=0,$heightkm=0,$heightkm1=0,$kusen=null){
       
        $pro = $this->product->get_detail_based_id($pid); 
        $this->daun = $pro->daun;
        $this->daunhidup = $pro->daunhidup;
        $this->kacamati = $pro->kacamati;
        $this->tulangdaun = $pro->tulang_daun;
        $this->kacamatibawah = $pro->kacamati_bawah;
        
        $res = 0;
        switch ($type) {
        case "KACA": $res = $this->c_kaca($width, $height); break;
        case "DAUN JENDELA": $res = $this->c_daun($width, $height, $heightkm,$heightkm1); break;
        case "KUSEN SAYAP": $res = $this->c_kusen_sayap($pid,$width, $height, $kusen); break;
        case "KUSEN": $res = $this->c_kusen($pid,$width, $height, $kusen); break;
        case "ACCESSORIES": $res = $this->product->get_bone($pid); break;
        case "ACCESSORIES-D": $res = $this->product->get_bone($pid); break;
        case "DAUN PINTU": $res = $this->c_daun_pintu($width, $height); break;
        case "TULANG": $res = $this->tulangdaun; break;
        case "TULANG DAUN": $res = $this->c_tulang_daun($width, $height, $this->tulangdaun); break;
        case "TULANG PALSU": $res = $this->c_tulang_palsu($width, $height); break;
        case "POP": $res = $this->c_pop($width, $height, $heightkm, $heightkm1); break;
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
    
    function c_pop($width=0,$height=0,$heightkm=0,$heightkm1=0)
    {
        if ($this->daunhidup == 0){
            // =2*C3+2*C4
            return floatval(2*$width+2*$height);
        }else{
            if ($this->kacamati == 1 && $this->kacamatibawah == 0){
                // =2*C3+2*C5
                return floatval(2*$width+2*$heightkm);
            }elseif ($this->kacamati == 1 && $this->kacamatibawah == 1){
                // =2*C3+2*C5 + 2*C3+2*C6
                $res1 = floatval(2*$width+2*$heightkm);
                $res2 = floatval(2*$width+2*$heightkm1);
                return floatval($res1+$res2);
            }elseif ($this->kacamati == 2 && $this->kacamatibawah == 0){
                // =2*C3+4*C5
                $res1 = floatval(2*$width+4*$heightkm);
                return floatval($res1);
            }elseif ($this->kacamati == 2 && $this->kacamatibawah == 2){
                // =4*C3+4*C5+4*C6
                $res1 = floatval(4*$width+4*$heightkm+4*$heightkm1);
                return floatval($res1);
            }elseif ($this->kacamati == 3 && $this->kacamatibawah == 0){
                // 2*C3+6*C5
                $res1 = floatval(2*$width+6*$heightkm);
                return floatval($res1);
            }
            else{ return 0; } // end else
        }
    }
    
    function c_kusen($pid,$width=0,$height=0,$kusen)
    {
        $category = $this->product->get_by_id($pid)->row();
        if ($category->category == 13){ return floatval($width+2*$height);  }else{ return floatval(2*$width+2*$height);   }
           
    }
    
    function c_kusen_sayap($pid,$width=0,$height=0,$kusen)
    {
       $category = $this->product->get_by_id($pid)->row();
       if ($category->category == 13){ $res = floatval($width+2*$height);  }else{ $res = floatval(2*$width+2*$height);   } 
       if ($kusen == "SAYAP"){ return $res; }else{ return 0; } 
    }

    function c_tulang_palsu($width=0,$height=0)
    { 
       if ($this->daunhidup == 1){
           return 0;
       }elseif ($this->daunhidup == 2){
           return floatval(1*$height);
       }
    }
        
    function c_daun_pintu($width=0,$height=0)
    { 
       if ($this->daunhidup == 1){
//           =2*C3+2*C4
           return floatval(2*$width+2*$height);
           
       }elseif ($this->daunhidup == 2){
           // =2*C3+4*C4
           return floatval(2*$width+4*$height);
       }
    }
    
    function c_daun($width=0,$height=0,$heightkm=0,$heightkm1=0)
    { 
       if ($this->daunhidup == 0){
           return 0;
       }elseif ($this->daunhidup == 1){
           
           if ($this->kacamati == 0){
              // =2*C3+2*C4
              return floatval(2*$width+2*$height);
           }elseif($this->kacamati == 1 && $this->kacamatibawah == 0){
              // =2*C3+2*(C4-C5)
              return floatval(2*$width+2*($height-$heightkm));
           }elseif ($this->kacamati == 1 && $this->kacamatibawah == 1){
              // =2*C3+2*(C4-C5-C6)
              return floatval(2*$width+2*($height-$heightkm-$heightkm1));
           }
           
       }elseif ($this->daunhidup == 2){
           
           if ($this->kacamati == 0){
               //=2*C3+4*C4
               return floatval(2*$width+4*$height);
           }elseif ($this->kacamati == 1 && $this->kacamatibawah == 0){
               // =2*C3+4*(C4-C5)
               return floatval(2*$width+4*($height-$heightkm));
           }elseif ($this->kacamati == 1 && $this->kacamatibawah == 1){
               // =2*C3+4*(C4-C5-C6)
               return floatval(2*$width+4*($height-$heightkm-$heightkm1));
           }
           
       }elseif ($this->daunhidup == 3){
           
           if ($this->kacamati == 0){
               // =2*C3+6*C4
               return floatval(2*$width+6*$height);
           }elseif ($this->kacamati == 1 && $this->kacamatibawah == 0){
               // =2*C3+6*(C4-C5)
               return floatval(2*$width+6*($height-$heightkm));
           }elseif ($this->kacamati == 1 && $this->kacamatibawah == 1){
               // =2*C3+6*(C4-C5-C6)
               return floatval(2*$width+6*($height-$heightkm-$heightkm1));
           }
           
       }elseif ($this->daunhidup == 4){
           
           if ($this->kacamati == 0){
               return floatval(2*$width+8*$height);
           }elseif ($this->kacamati == 2 && $this->kacamatibawah == 0){
               // =2*C3+8*(C4-C5)
               return floatval(2*$width+8*($height-$heightkm));
           }elseif ($this->kacamati == 1 && $this->kacamatibawah == 1){
               // =2*C3+8*(C4-C5-C6)
               return floatval(2*$width+8*($height-$heightkm-$heightkm1));
           }elseif ($this->kacamati == 2 && $this->kacamatibawah == 2){
//               =2*C3+8*(C4-C5-C6)
               return floatval(2*$width+8*($height-$heightkm-$heightkm1));
           }
           
       }elseif ($this->daunhidup == 5){
           
           if ($this->kacamati == 0){
               // =2*C3+10*C4
               return floatval(2*$width+10*$height);
           }elseif ($this->kacamati == 3 && $this->kacamatibawah == 0){
               // =2*C3+10*(C4-C5)
               return floatval(2*$width+10*($height-$heightkm));
           }
       }elseif ($this->daunhidup == 6){
           
           if ($this->kacamati == 0){
               // =2*C3+12*C4
               return floatval(2*$width+12*$height);
           }elseif ($this->kacamati == 2 && $this->kacamatibawah == 0){
               // =2*C3+12*(C4-C5)
               return floatval(2*$width+12*($height-$heightkm));
           }elseif ($this->kacamati == 3 && $this->kacamatibawah == 0){
               // 2*C3+12*(C4-C5)
               return floatval(2*$width+12*($height-$heightkm));
           }
       }
       
        
    }

}

/* End of file Property.php */
