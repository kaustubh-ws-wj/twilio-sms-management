<?php
require 'vendor/autoload.php';
use Plivo\RestClient;
use Plivo\Exceptions\PlivoRestException;

include 'connection.php';
$client = new RestClient("MAOGFLMJLKNGM0ODZMYJ", "MGQ2ZTg5ZWM5YzU5MDY3MjNiZjY0Y2EwMGFiY2M2");



if(isset($_POST) && !empty($_POST))
{
    // echo "<pre>";
    // print_r($_POST);
    // exit();    
    
    try {
        $response = $client->phonenumbers->list(
            $_POST["country_code"]
            // ['type'=>'tollfree', 'pattern'=>'833']
        );
        
        // echo "<pre>";
        // print_r($response);
        
        for($i=0; $i<20;$i++){
            echo "<pre>";
            print_r($response->resources[$i]->properties);  
            echo $i;
        }
       
    }
    catch (PlivoRestException $ex) {
        print_r($ex);
    }
}
else{
    header("Refresh:0; url=search_phone_number.php?status=0");
}


?>


