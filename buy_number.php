<?php
include 'connection.php';
require 'vendor/autoload.php';
use Plivo\RestClient;
use Plivo\Exceptions\PlivoRestException;
$client = new RestClient("MAOGFLMJLKNGM0ODZMYJ", "MGQ2ZTg5ZWM5YzU5MDY3MjNiZjY0Y2EwMGFiY2M2");

try {
    $response = $client->phonenumbers->buy(
        $_POST['number']
    );
    if($response->statusCode == "404")
    {
        header("Refresh:0; url=search_phone_number.php?status=2"); 
    }
    else{
        header("Refresh:0; url=list_all_numbers.php?status=1");
    }
}
catch (PlivoRestException $ex) {
    print_r($ex);
    header("Refresh:0; url=search_phone_number.php?status=2");
}
?>