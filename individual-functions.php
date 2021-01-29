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

        $sql    = "SELECT * FROM `call_routes` WHERE `call_routes_name` = '${routeName}'";
        $result = mysqli_query($connect, $sql);
        $notif_email = mysqli_fetch_all($result,MYSQLI_ASSOC);
        echo json_encode($notif_email);
        
    }

    if (isset($_POST['send_msg'])) {
        $phone_number = '+1'.$_POST['recipient_number']; 
        $msg_body = $_POST['message'];
        $sender_number = $_POST['sender_number'];
        $date = date("Y-m-d h:m");
        try{
            $message = $twilio->messages->create($phone_number, // to
            [
                "body" => $msg_body,
                "messagingServiceSid" => "MG6cd88d0beeaca544176e383fdd0d90c8",
                "from" => $sender
            ]);
            $query_c = "INSERT INTO individual_messages(msg_body,recipient_number,sender_number,date,status) VALUES ('{$msg_body}','{$phone_number}','{$sender_number}','{$date}','1')";
            $ins = mysqli_query($connect, $query_c);
            header("location: individual-messages.php?status=1"); 
        }
        catch(RestException $e){
            echo 'Message: ' .$e->getMessage();
            header("location: individual-messages.php?status=0"); 
        }
    }


?>