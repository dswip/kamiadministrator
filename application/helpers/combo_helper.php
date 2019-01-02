<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Formats a numbers as bytes, based on size, and adds the appropriate suffix
 *
 * @access	public
 * @param	mixed	// will be cast as int
 * @return	string
 */


if (! function_exists('setnull'))
{
    function setnull($value)
    {if ($value == ""){$value = null;}return $value;}
}

if (! function_exists('replace'))
{
    function replace($replace,$replacewith,$inme)
    {
        $doit = str_replace ("$replace", "$replacewith", $inme);
        return strtolower("$doit");
    }
}

if (! function_exists('status'))
{
    function status($val){if ($val == "0"){$value = 'N';}else{ $value = "Y"; }return $value;}
}

if (! function_exists('random_password'))
{
    function random_password() 
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $password = array(); 
        $alpha_length = strlen($alphabet) - 1; 
        for ($i = 0; $i < 8; $i++) 
        {
            $n = rand(0, $alpha_length);
            $password[] = $alphabet[$n];
        }
        return implode($password); 
    }
}

    



/* End of file combo_helper.php */
/* Location: ./system/helpers/combo_helper.php */