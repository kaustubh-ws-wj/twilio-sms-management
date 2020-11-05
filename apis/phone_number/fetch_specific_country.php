<?php 
    include '../../config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(isset($_POST['country_code']) && $_POST['country_code'] != ''){
        $country_code = strtoupper($_POST['country_code']);
    
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/".ACCOUNT_SID."/AvailablePhoneNumbers/".$country_code.".json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ".BASIC_AUTH_KEY
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        $result = json_decode($response);
        if(!empty($result)){
            if(isset($result->status)){
                echo json_encode(array('status'=>'error','object'=>$response));
            }else{
                echo $response;
            }
        }
    }
}

?>