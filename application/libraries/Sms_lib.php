<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_lib extends Main_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->error = new Error_lib();
    }
       
    private $error;
    

    // raja sms
    
    function cek_balance(){
        
        ob_start();
        // setting 
        $apikey      = 'b4d9b6384c804103ef05a17e976b46bd'; // api key 
        $urlserver   = 'http://45.76.156.114/sms/api_sms_otp_send_json.php'; // url server sms  

        // create header json  
        $senddata = array(
                'apikey' => $apikey
        );

        // sending  
        $data=json_encode($senddata);
        $curlHandle = curl_init($urlserver);
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json',
                                'Content-Length: ' . strlen($data))
        );
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 5);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 5);
        $respon = curl_exec($curlHandle);

        $curl_errno = curl_errno($curlHandle);
        $curl_error = curl_error($curlHandle);	
        $http_code  = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        curl_close($curlHandle);
        if ($curl_errno > 0) {
                $senddatax = array(
                'sending_respon'=>array(
                        'globalstatus' => 90, 
                        'globalstatustext' => $curl_errno."|".$http_code)
                );
                $respon=json_encode($senddatax);
        } else {
                if ($http_code<>"200") {
                        $senddatax = array(
                        'sending_respon'=>array(
                                'globalstatus' => 90, 
                                'globalstatustext' => $curl_errno."|".$http_code)
                        );
                        $respon= json_encode($senddatax);	
                }
        }		
        header('Content-Type: application/json');
        return $respon;
        
    }
    
    function send($number='082277014410',$message=''){
        
        ob_start();
        // setting 
        $apikey      = 'b4d9b6384c804103ef05a17e976b46bd'; // api key 
        $urlserver   = 'http://45.76.156.114/sms/api_sms_otp_send_json.php'; // url server sms 
        $callbackurl = ''; // url callback get status sms 
        $senderid    = '0'; // Option senderid 0=Sms Long Number / 1=Sms Masking/Custome Senderid

        // create header json  
        $senddata = array(
                'apikey' => $apikey,  
                'callbackurl' => $callbackurl, 
                'senderid' => $senderid, 
                'datapacket'=>array()
        );

        array_push($senddata['datapacket'],array(
                'number' => trim($number),
                'message' => $message
        ));
        
        // sending  
        $data=json_encode($senddata);
        $curlHandle = curl_init($urlserver);
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json',
                                'Content-Length: ' . strlen($data))
        );
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 30);
        $respon = curl_exec($curlHandle);

        $curl_errno = curl_errno($curlHandle);
        $curl_error = curl_error($curlHandle);	
        $http_code  = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        curl_close($curlHandle);
        if ($curl_errno > 0) {
                $senddatax = array(
                'sending_respon'=>array(
                        'globalstatus' => 90, 
                        'globalstatustext' => $curl_errno."|".$http_code)
                );
                $respon=json_encode($senddatax);
        } else {
                if ($http_code<>"200") {
                        $senddatax = array(
                        'sending_respon'=>array(
                                'globalstatus' => 90, 
                                'globalstatustext' => $curl_errno."|".$http_code)
                        );
                        $respon= json_encode($senddatax);	
                }
        }
//        return $respon;
        $respon = json_decode($respon, true);        
        
//        print_r($globalstatus.'|'.$sendingstatus.'|'.$error);
        $com = new Components();
        $com = $com->get_id('sms'); 
        if ($http_code <> 200){
            $this->error->create($com, '403 Bad Connection'); 
            return FALSE;
        }else{
            $globalstatus = $respon['sending_respon'][0]['globalstatus'];
            $sendingstatus = $respon['sending_respon'][0]['datapacket'][0]['packet']['sendingstatus'];
            $error = $respon['sending_respon'][0]['globalstatustext'];
            if ($sendingstatus == '10' && $globalstatus == '10'){ return TRUE; }else{ $this->error->create($com, $error); return FALSE; }
        }
    }
    
    // api messabot
    function xxsend($no='0',$text=""){
        
        $data = [
            "destination" => [$no],
            "text" => $text,
            // Uncomment line di bawah untuk penggunaan fitur masking
            // "masking" => "NAMA_MASKING",
          ];

          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => "https://mesabot.com/api/v2/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
              "client-id: 2yuKyM6q",
              "client-secret: woPasN6q",
              "content-type: application/json",
            ),
          ));
       
       $response = curl_exec($curl);
       $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err){ $this->error->create(0, $err); }
        else 
        { 
           $obj = json_decode($response,true); 
           $com = new Components();
           $com = $com->get_id('sms'); 
           if (strtolower($obj['status_code']) == "200"){ return TRUE; }else{ $this->error->create($com, $obj['message']); return FALSE; }
        }
        
    }
    
    function send_blast($no,$text=""){
        
        $data = [
            "destination" => $no,
            "text" => $text,
            // Uncomment line di bawah untuk penggunaan fitur masking
            // "masking" => "NAMA_MASKING",
          ];

          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => "https://mesabot.com/api/v2/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
              "client-id: 2yuKyM6q",
              "client-secret: woPasN6q",
              "content-type: application/json",
            ),
          ));
       
       $response = curl_exec($curl);
       $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err){ $this->error->create(0, $err); }
        else 
        { 
           $obj = json_decode($response,true); 
           $com = new Components();
           $com = $com->get_id('sms'); 
           if (strtolower($obj['status_code']) == "200"){ return TRUE; }else{ $this->error->create($com, $obj['message']); return FALSE; }
        }
        
    }
    
    // api zenziva
    function zenziva_send($telepon=0,$text=""){
        
        $userkey = "osh2b5"; //userkey lihat di zenziva
        $passkey = "12011989"; // set passkey di zenziva
        $message = $text;
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://reguler.zenziva.net/apps/smsapi.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "userkey=".$userkey."&passkey=".$passkey."&nohp=".$telepon."&pesan=".urlencode($message)
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        if ($err){ $this->error->create(0, $err); }
        else 
        { 
           $com = new Components();
           $com = $com->get_id('sms'); 
           $XMLdata = new SimpleXMLElement($response);
           $status = (string)$XMLdata->message[0]->text;
           if (strtolower($status) == "success"){ return TRUE; }else{ $this->error->create($com, $status); return FALSE; }
        }
    }

}

/* End of file Property.php */