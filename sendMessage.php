<?php 

require 'vendor/autoload.php';
use Plivo\RestClient;
use Plivo\Exceptions\PlivoRestException;

 $client = new RestClient("MAOGFLMJLKNGM0ODZMYJ", "MGQ2ZTg5ZWM5YzU5MDY3MjNiZjY0Y2EwMGFiY2M2");
 // $client = new RestClient("MANTZHZGNKNZZJY2I2MW", "NDIzZjMyMmY2ZmI0NWQ5NTIyOTk5OWMyN2MyMGIz");
print_r($_POST['message']);
if(isset($_POST['phone_number']) && isset($_POST['message'])){
        try {
              $response = $client->messages->create(
                  '+18335751890', #from
                  ['+'.$_POST['phone_number']], #to
                  $_POST['message'],#message
                );
 			echo "Message Sent Successfully...";
        }
        catch (PlivoRestException $ex) {
            echo "Something went wrong. Please try again...";
        }
}
?>