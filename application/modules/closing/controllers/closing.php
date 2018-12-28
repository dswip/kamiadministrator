<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Closing extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Closing_model', '', TRUE);
        
        $this->properti = $this->property->get();
        $this->acl->otentikasi();
        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));

        $this->user = $this->load->library('admin_lib');
        $this->component = new Components();
        $this->period = new Period_lib();
        $this->period = $this->period->get();
        $this->balance = new Balance_lib();
        $this->cbalance = new Courier_Balance_lib();
        $this->customer = new Customer_lib();
        $this->ledger = new Wallet_ledger_lib();
        $this->cledger = new Courier_wallet_ledger_lib();
        $this->courier = new Courier_lib();
    }

    private $atts = array('width'=> '800','height'=> '600',
                      'scrollbars' => 'yes','status'=> 'yes',
                      'resizable'=> 'yes','screenx'=> '0','screenx' => '\'+((parseInt(screen.width) - 800)/2)+\'',
                      'screeny'=> '0','class'=> 'print','title'=> 'print', 'screeny' => '\'+((parseInt(screen.height) - 600)/2)+\'');

    private $properti, $modul, $title, $component,$balance,$cbalance;
    private $user,$customer,$period, $ledger, $cledger, $courier;

    function index()
    { 
        $this->monthly(); 
    }
    
    function calculate($page='main')
    {
        $customer = $this->customer->get()->result();
        
        $res = null;
        foreach ($customer as $res)
        {    
            $next = $this->next_period();  

            $beginning = $this->balance->get($res->id, $this->period->month, $this->period->year);
            if ($beginning){ $beginning = floatval($beginning->beginning); }else{ $beginning = 0; }          
            $trans = $this->ledger->get_sum_transaction_monthly($res->id, $this->period->month, $this->period->year);
            $trans = floatval($trans['vamount']);
            
            $this->balance->create($res->id, $this->period->month, $this->period->year, 0, $beginning+$trans);
            $this->balance->create($res->id, $next[0], $next[1], $beginning+$trans);         
        }
        
        $this->session->set_flashdata('message', "Calculating Ending Balance Sucessed..!");
        redirect($page);    
    }
    
    private function closing_customer(){
        
        $errorlib = new Error_lib();
        try {   
            $customer = $this->customer->get()->result();
            $res = null;
            foreach ($customer as $res)
            {    
                $next = $this->next_period();  

                $beginning = $this->balance->get($res->id, $this->period->month, $this->period->year);
                if ($beginning){ $beginning = floatval($beginning->beginning); }else{ $beginning = 0; }          
                $trans = $this->ledger->get_sum_transaction_monthly($res->id, $this->period->month, $this->period->year);
                $trans = floatval($trans['vamount']);

                $this->balance->create($res->id, $this->period->month, $this->period->year, 0, $beginning+$trans);
                $this->balance->create($res->id, $next[0], $next[1], $beginning+$trans);         
            }
            return true;
        } catch (Exception $e) { $errorlib->create($this->title, $e->getMessage()); return false; }
    }
    
    private function closing_courier(){
        
        $errorlib = new Error_lib();
        try {   
            $courier = $this->courier->get()->result();
            $res = null;
            foreach ($courier as $res)
            {    
                $next = $this->next_period();  

                $beginning = $this->cbalance->get($res->id, $this->period->month, $this->period->year);
                if ($beginning){ $beginning = floatval($beginning->beginning); }else{ $beginning = 0; }          
                $trans = $this->cledger->get_sum_transaction_monthly($res->id, $this->period->month, $this->period->year);
                $trans = floatval($trans['vamount']);

                $this->cbalance->create($res->id, $this->period->month, $this->period->year, 0, $beginning+$trans);
                $this->cbalance->create($res->id, $next[0], $next[1], $beginning+$trans);         
            }
            return true;
        } catch (Exception $e) { $errorlib->create($this->title, $e->getMessage()); return false; }
    }
    
    function monthly()
    {   
        if ($this->closing_customer() == true && $this->closing_courier() == true){
            $ps = new Period_lib();
            $next = $this->next_period();  
            $ps->update_period($next[0], $next[1]);
            $this->session->set_flashdata('message', "Monthly End Sucessed..!");
        }else{ $this->session->set_flashdata('message', "Monthly End Failed..!"); }
        redirect('main');    
    }
    
    private function next_period()
    {
        $month = $this->period->month;
        $year = $this->period->year;
        
        if ($month == 12){$nmonth = 1;}else { $nmonth = $month +1; }
        if ($month == 12){ $nyear = $year+1; }else{ $nyear = $year; }
        $res[0] = $nmonth; $res[1] = $nyear;
        return $res;
    }
    
}

?>
