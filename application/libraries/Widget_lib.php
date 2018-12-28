<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widget_lib extends Main_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
    }

    function combo_position()
    {
        $data=null;
        for ($i=1; $i<=20; $i++)
        {
            $data['options']['user'.$i] = 'user '.$i;
        }
        return $data;
    }


}

/* End of file Property.php */