<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_lib {

    public function __construct(){
 
    }

    private $ci;
    
    // ==================================== API ==============================
    
    function request($url=null,$param=null)
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
        $err = curl_error($curl);
//        $data = json_decode($response, true); 

        curl_close($curl);
        if ($err) { return $err; }
        else { return $response; }
    }
    
    
    function get_cost_fee($ori,$dest,$courier='jne',$weight=1000)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
//        CURLOPT_POSTFIELDS => "origin=".$ori."&destination=".$dest."&weight=".$weight."&courier=".$courier,
        CURLOPT_POSTFIELDS => "origin=".$ori."&originType=city&destination=".$dest."&destinationType=city&weight=".$weight."&courier=".$courier,
        CURLOPT_HTTPHEADER => array(
          "content-type: application/x-www-form-urlencoded",
          "key: eb7f7529d68f6a2933b5a042ffeeac9d"
        ),
      ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) 
        { 
//            echo "cURL Error #:" . $err; 
            return 0;
        }
        else 
        { 
          $data = json_decode($response, true); 
//          $paket = $data['rajaongkir']['results'][0]['costs'][4]['service']; 
//          $harga = intval($data['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value']); 
          $json = $data['rajaongkir']['results'][0]['costs'];
          
          $datax = null;
          for ($i=0; $i<count($json); $i++)
          {
            $paket = $json[$i]['service']; 
            $harga = intval($json[$i]['cost'][0]['value']); 
            $datax[$i] = $paket.'|'.$harga;
          }
          return $datax;
        }
    }


}

/* End of file Property.php */