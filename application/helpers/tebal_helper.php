<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Formats a numbers as bytes, based on size, and adds the appropriate suffix
 *
 * @access	public
 * @param	mixed	// will be cast as int
 * @return	string
 */
if ( ! function_exists('cetak_tebal'))
{
	function cetak_tebal($val)
	{
            return "<b>".$val."</b>";
	}	
}

if ( ! function_exists('split_space'))
{
    function split_space($string)
    {
        return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
    }
}

if ( ! function_exists('split_array'))
{
  function split_array($val){ return implode(",",$val); }
}

if ( ! function_exists('position'))
{
    function position()
    {
        $data = null;
        for($i=1; $i<=10; $i++)
        {
          $data['options']['user'.$i] = ucfirst('user'.$i);
        }
        return $data;
    }
}

if (! function_exists('num_format'))
{
    function num_format($val)
    {
       return number_format($val,0,',','.');
    }
}

/* End of file number_helper.php */
/* Location: ./system/helpers/number_helper.php */