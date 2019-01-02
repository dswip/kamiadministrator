<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Formats a numbers as bytes, based on size, and adds the appropriate suffix
 *
 * @access	public
 * @param	mixed	// will be cast as int
 * @return	string
 */


if ( ! function_exists('acl'))
{
    function acl()
    {
        $CI =& get_instance();
        if ($CI->session->userdata('login') != TRUE )
        {
            redirect('login');
        }
    }
}

if ( ! function_exists('otentikasi1'))
{
    function otentikasi1($title)
    {
       $CI =& get_instance();
       $CI->load->model('Login_model');
       $mod = $CI->Login_model->get_modul_by_name($title)->row();
       $mod = $mod->role;
       $mod = explode(",", $mod);

      foreach ($mod as $row)
      {
        if ($row == $CI->session->userdata('role'))
        {$val = TRUE; break;}
        else
        {$val = FALSE;}
      }

      if ($val != TRUE)
      {
         $CI->session->set_flashdata('message', 'Sorry, you do not have the right to access this page');
         redirect($title);
      }

    }
}



/* End of file combo_helper.php */
/* Location: ./system/helpers/combo_helper.php */