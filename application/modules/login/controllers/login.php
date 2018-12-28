<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {


   public function __construct()
   {
        parent::__construct();

        $this->load->model('Login_model', '', TRUE);

        $this->load->helper('date');
        $this->log = new Log_lib();
        $this->load->library('email');
        $this->login = new Login_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('login');

        $this->properti = $this->property->get();

        // Your own constructor code
   }

   private $date,$time,$log,$login;
   private $properti,$com;

   function index()
   {
        $data['pname'] = $this->properti['name'];
        $data['logo'] = $this->properti['logo'];
        $data['form_action'] = site_url('login/login_process');

        $this->load->view('login_view', $data);
    }
    
    function response_json(){
      
       $datax = (array)json_decode(file_get_contents('php://input')); 

       $pesan = $datax['pesan'].' berasal dari php';
        
       $response = array('success' => false, 'user' => 'sanjaya kirana', 'pesan' => $pesan); 
       $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, 128))
        ->_display();
        exit;
       
   }
    
    function curl_function()
    {
        $user = 'admins';
        $pass = 'admin';
        $nilai = '{ "user":"'.$user.'", "pass": "'.$pass.'"}';
        
        $curl = curl_init();
        $url = 'http://cms.delicaindonesia.com/index.php/login/login_process';
        
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $nilai,
        CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
        ),
      ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
//        $data = json_decode($response, true); 

        curl_close($curl);
        if ($err) { echo $err; }
        else { echo $response; }
    }

    // function untuk memeriksa input user dari form sebagai admin
    function login_process()
    {
        
        $datax = (array)json_decode(file_get_contents('php://input')); 

        $username = $datax['user'];
        $password = $datax['pass'];

            if ($this->Login_model->check_user($username,$password) == TRUE)
            {
                $this->date  = date('Y-m-d');
                $this->time  = waktuindo();
                $userid = $this->Login_model->get_userid($username);
                $role = $this->Login_model->get_role($username);
                $rules = $this->Login_model->get_rules($role);
                $logid = $this->log->max_log();
                $waktu = tgleng(date('Y-m-d')).' - '.waktuindo().' WIB';

                $this->log->insert($userid, $this->date, $this->time, 'login');
                $this->login->add($userid, $logid);

                $data = array('username' => $username, 'userid' => $userid, 'role' => $role, 'rules' => $rules, 'log' => $logid, 'login' => TRUE, 'waktu' => $waktu);
                $this->session->set_userdata($data);
                
                $response = array(
                  'Success' => true,
		  'User' => $datax['user'],
                  'Info' => 'Login Success'); 
            }
            else
            {
                $response = array(
                'Success' => false,
                'Info' => 'Invalid Login..!!');
            }
            
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response))
        ->_display();
        exit;

    }

    // function untuk logout
    function process_logout()
    {
        $userid = $this->Login_model->get_userid($this->session->userdata('username'));
        $this->date  = date('Y-m-d');
        $this->time  = waktuindo();
        
        $this->log->insert($userid, $this->date, $this->time, 'logout');
        $this->session->sess_destroy();
        redirect('login');
    }

    function forgot()
    {
	$data['form_action'] = site_url('login/send_password');
        $data['pname'] = $this->properti['name'];
        $data['logo'] = $this->properti['logo'];
        $this->load->view('forgot_view' ,$data);
    }

    function send_password()
    {
        $datax = (array)json_decode(file_get_contents('php://input')); 

        $username = $datax['user'];
        
        if ($this->Login_model->check_username($username) == FALSE)
        {
           $this->session->set_flashdata('message', 'Username not registered ..!!');

           $response = array(
              'Success' => false,
              'User' => $username,
              'Info' => 'Username / Email not registered...!'); 
        }
        else
        {  
            try
            {
              $this->send_email($username); 
              $response = array(
               'Success' => true,
               'User' => $username,
               'Info' => 'Password has been sent to your email!');  
              
            }
            catch(Exception $e) {  
//                echo 'Pesan Error: ' .$e->getMessage();  
                $this->log->insert(0, date('Y-m-d'), waktuindo(), 'error', $this->com, $e->getMessage());
                $response = array(
               'Success' => false,
               'User' => $username,
               'Info' => $e->getMessage());    
            } 
        }
        
        $this->output
        ->set_status_header(201)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;
    }
    
    function send_email($username)
    {
        $email = $this->Login_model->get_email($username);
        $pass = $this->Login_model->get_pass($username);
        $mess = "
          ".$this->properti['name']." - ".base_url()."
          FORGOT PASSWORD :

          Your Username is: ".$username."
          Your Password : ".$pass." <hr />
Your password for this account has been recovered . You don�t need to do anything, this message is simply a notification to protect the security of your account.
Please note: your password may take awhile to activate. If it doesn�t work on your first try, please try it again later
DO NOT REPLY TO THIS MESSAGE. For further help or to contact support, please email to ".$this->properti['email']."
****************************************************************************************************************** ";

        $params = array($this->properti['email'], $this->properti['name'], $email, 'Password Recovery', $mess, 'text');
        $se = $this->load->library('send_email',$params);

        if ( $se->send_process() == TRUE ){ return TRUE; }
        else { return FALSE;}
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */