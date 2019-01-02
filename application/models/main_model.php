<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main_model extends Custom_Model
{
    private $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('main');
    }
   
    
    protected $table = 'admin_menu';
    protected $field = array('id', 'parent_id', 'name', 'modul', 'url', 'menu_order', 'class_style', 'id_style', 
                             'icon', 'target', 'parent_status');
    protected $com;
          

}

?>