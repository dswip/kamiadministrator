<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Push_lib extends Main_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->error = new Error_lib();
        $this->appid = "76ab1363-919e-4ce0-abad-c05a6f3e3be9";
        $this->apikey = "NzFkMmJkZGEtODI3NS00YzAxLWJiZjktNGIxNzk5NTg2Nzll";
        $this->customer = new Member_login_lib();
    }
       
    private $error,$appid,$customer,$apikey;
    
    function send($mess=null){
        $content      = array(
            "en" => $mess
        );
        $hashes_array = array();
        array_push($hashes_array, array(
            "id" => "like-button",
            "text" => "Like",
            "icon" => "http://wamenak.com/icon.png",
            "url" => "https://wamenak.com"
        ));
        array_push($hashes_array, array(
            "id" => "like-button-2",
            "text" => "Like2",
            "icon" => "http://wamenak.com/icon.png",
            "url" => "https://wamenak.com"
        ));
        $fields = array(
            'app_id' => $this->appid,
            'included_segments' => array(
                'All'
            ),
            'data' => array(
                "foo" => "bar"
            ),
            'contents' => $content,
            'web_buttons' => $hashes_array
        );

        $fields = json_encode($fields);
//        print("\nJSON sent:\n");
//        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.$this->apikey
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        // return $response;
        $return = json_decode($response,true);
        if ($return['recipients'] > 0){ return true; }else{ return false; }
    }
    
    function send_device($customer=null,$mess=null){
        
        $device = $this->customer->get_device($customer);
        $content = array( "en" => $mess );

        $fields = array(
                'app_id' => $this->appid,
                'include_player_ids' => array($device),
                'data' => array("foo" => "bar"),
                "icon" => "http://wamenak.com/icon.png", 
//                "url" => "https://wamenak.com",
                "targetUrl" => "profil.html",
                'contents' => $content
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic '.$this->apikey));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

//            return $response;
        $return = json_decode($response,true);
        return true;
//        if ($return['recipients'] > 0){ return true; }else{ return false; }
    }
    
    function send_multiple_device($device=null,$mess=null){
        
        $content = array( "en" => $mess );

        $fields = array(
                'app_id' => $this->appid,
                'include_player_ids' => $device,
                'data' => array("foo" => "bar"),
                "icon" => "http://wamenak.com/icon.png", 
//                "url" => "https://wamenak.com",
                'contents' => $content
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic '.$this->apikey));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

//            return $response;
        $return = json_decode($response,true);
        if ($return['recipients'] > 0){ return true; }else{ return false; }
    }
    
}

/* End of file Property.php */