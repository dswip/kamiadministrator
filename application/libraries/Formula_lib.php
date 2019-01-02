<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formula_lib extends Main_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = null;
        $this->f120 = new Formula120_lib();
        $this->sd80 = new Formulasd80_lib();
        $this->fd   = new Formulafd_lib();
        $this->sw40 = new Formulasw40_lib();
        $this->csmt100 = new Formulacsmt100_lib();
        $this->csmt50  = new Formulacsmt50_lib();
        $this->csmt38 = new Formulacsmt38_lib();
    }
    
    private $product,$f120,$sd80,$fd,$sw40,$csmt100,$csmt50,$csmt38;
    
    function calculate($series=null,$type=null,$width=0,$height=0,$pid=0,$heightkm=0,$heightkm1=0,$kusen=null){
       
        $res = 0;
        switch ($series) {
        case "LS120": $res = $this->f120->calculate($type,$width,$height,$pid); break;
        case "SD80": $res = $this->sd80->calculate($type,$width,$height,$pid,$heightkm); break;
        case "FD": $res = $this->fd->calculate($type,$width,$height,$pid,$heightkm); break;
        case "SWING40": $res = $this->sw40->calculate($type,$width,$height,$pid,$heightkm); break;
//        case "SWING30": $res = $this->c_penutup($width, $height); break;
        case "CSMT100": $res = $this->csmt100->calculate($type,$width,$height,$pid,$heightkm); break;
        case "CSMT50": $res = $this->csmt50->calculate($type,$width,$height,$pid,$heightkm,$heightkm1,$kusen); break;
        case "CSMT38": $res = $this->csmt38->calculate($type,$width,$height,$pid,$heightkm,$heightkm1,$kusen); break;
        } return $res;
    }
   

}

/* End of file Property.php */
