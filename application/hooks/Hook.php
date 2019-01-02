<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @filename Hook.php
 *
 */

class Hook {
   public function run() {

        $ci =& get_instance();
        if ($ci->session->userdata('login') != TRUE)
        { $ci->session->sess_destroy(); }
    }
}

 ?>