<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Formats a numbers as bytes, based on size, and adds the appropriate suffix
 *
 * @access	public
 * @param	mixed	// will be cast as int
 * @return	string
 */

//get modul limit
if ( ! function_exists('get_module_limit'))
{
    function get_module_limit($title=null)
    {
       $CI =& get_instance();
       $CI->load->model('Modul_model');
       $mod = $CI->Modul_model->get_modul_by_name($title)->row();
       return $mod->limit;
    }
}

/* End of file combo_helper.php */
/* Location: ./system/helpers/combo_helper.php */