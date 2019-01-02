<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'libraries/jwt/JWT.php';
require_once APPPATH.'libraries/jwt/ExpiredException.php';
use \Firebase\JWT\JWT;

class Api_lib extends Custom_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->login = new Member_login_lib();
    }

    private $ci,$login;
    
    // ==================================== API ==============================
    
    function request($url=null,$param=null,$type=null)
    {   
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $param,
        CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
        ),
      ));

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        $err = curl_error($curl);
//        $data = json_decode($response, true); 

        curl_close($curl);
        if (!$type){
            if ($err) { return $err; }else { return $response; }
        }else{
            $result = array();
            $result[0] = $response;
            $result[1] = $info['http_code'];
            return $result;
        }
    }
    
    function response($data, $status = 200){ 
         $this->output
          ->set_status_header($status)
          ->set_content_type('application/json', 'utf-8')
          ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ))
          ->_display();
          exit;  
    }
    
    function otentikasi(){
        $jwt = $this->input->get_request_header('Authorization');
        // harus mencocokan decoded mobile no dengan log di database
        try{
          $decoded  = JWT::decode($jwt, 'woma', array('HS256'));
          return $this->login->valid($decoded->userid, $jwt);
        }
        catch (\Exception $e){ 
//            $response = array('error' => 'Error token..!');
//            return $this->response($response,401);
            return FALSE;
        }
    }

}

/* End of file Property.php */