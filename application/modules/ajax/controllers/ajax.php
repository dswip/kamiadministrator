<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller
{
    function Ajax()
    {
        parent::__construct();
        $this->load->model('Ajax_model', '', TRUE);
//        $this->load->model('Product_model', '', TRUE);
//        $this->load->model('City_model', '', TRUE);
    }

     var $title = 'ajax';
     var $limit = null;
    
    function index()
    {       
        redirect('login');
    }

    function getcity()
    { 
      $values = $this->Ajax_model->getcity($this->input->post('ccountry'));
      echo "<select name=\"ccity\" id=\"ccity\">";
      if ($values)
      {
          foreach ($values as $val)
          {
             echo "<option value=\"$val->name\"> $val->name </option>";
          }
      }
      else{ echo "<option value=\"\"> -- No List -- </option>"; }
      echo "</select>";
    }

    function getlocation()
    {
      if ($this->input->post('ccity'))
      {
          $values = $this->Location_model->get_location_by_city($this->input->post('ccity'))->result();
          echo "<select name=\"clocation\" id=\"clocation\" class=\"required\">";
          if ($values)
          {
              echo "<option value=\"\"> -- All Location -- </option>";
              foreach ($values as $val)
              {
                 echo "<option value=\"$val->name\"> $val->name </option>";
              }
          }
          else{ echo "<option value=\"\"> -- No List -- </option>"; }
          echo "</select>";
      }
    }

    function getblock()
    {
      if ($this->input->post('ccluster'))
      {
          $values = $this->Block_model->get_block_by_cluster($this->input->post('ccluster'))->result();
          echo "<select name=\"cblock\" id=\"cblock\" class=\"required\">";
          if ($values)
          {
              echo "<option value=\"\"> -- All Block -- </option>";
              foreach ($values as $val)
              {
                 echo "<option value=\"$val->name\"> $val->name </option>";
              }
          }
          else{ echo "<option value=\"\"> -- No List -- </option>"; }
          echo "</select>";
      }
    }



    function getcode()
    {
        $val = $this->input->post('ccategory');
        $total = $this->Product_model->counter($val);
        $res = getcategorycode($val);
        echo $res.'-0'.$total;
    }

    function getcodecategory()
    {
        echo getcategorycode($this->input->post('ccategory'))."-0";
    }

//    -------------          batas ajax untuk menu -------------------------------------------

    function modultypefront()
    {
        $type = $this->input->post('ctype');

        if ($type == 'modul')
        {
           $values = $this->Ajax_model->getmodul()->result();
           echo "<select name=\"cmodul\" id=\"cmodul\" size=\"10\" onchange=\"geturl(this.value)\">";
           foreach ($values as $val)
           {
             echo "<option value=\"$val->name\"> $val->name </option>";
           }
           echo "</select>";
        }
        elseif ($type == "articlelist")
        {
           $values = $this->Ajax_model->getarticle()->result();
           echo "<select name=\"ccat\" id=\"ccat\" size=\"10\" onchange=\"setnilai(this.value)\">";
           foreach ($values as $val)
           {
             echo "<option value=\"$val->name\"> $val->name </option>";
           }
           echo "</select>";
        }
    }

}

?>