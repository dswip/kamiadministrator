<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


    function editor($width='100%',$height='400px') {
        
    $path = '../js/ckfinder';    
    $CI =& get_instance();    
    //Loading Library For Ckeditor
    $CI->load->library('ckeditor');
    $CI->load->library('ckFinder');
    //configure base path of ckeditor folder 
    $CI->ckeditor->basePath = base_url().'js/ckeditor/';
    $CI->ckeditor-> config['toolbar'] = 'Full';
    $CI->ckeditor->config['language'] = 'en';
    $CI->ckeditor-> config['width'] = $width;
    $CI->ckeditor-> config['height'] = $height;
    //configure ckfinder with ckeditor config 
    $CI->ckfinder->SetupCKEditor($CI->ckeditor,$path); 
  }