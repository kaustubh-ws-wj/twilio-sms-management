<?php
    include 'config.php';
    require_once ("connection.php");
    require __DIR__ . '/vendor/autoload.php';
    // Use the REST API Client to make requests to the Twilio REST API
    use Twilio\Rest\Client;
    use Twilio\Exceptions\RestException;
    $twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

    if(!empty($_POST['routeName'])){ 
        $routeName = $_POST['routeName'];

        $sql    = "SELECT * FROM `call_routes` WHERE `call_routes_name` WHERE '${routeName}'";
        $result = mysqli_query($connect, $sql);
        $notif_email = mysqli_fetch_all($get_notif_email_result,MYSQLI_ASSOC);
        
        
    }


?>