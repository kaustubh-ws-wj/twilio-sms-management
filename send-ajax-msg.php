<?php
    include 'config.php';
    require_once ("connection.php");
    require __DIR__ . '/vendor/autoload.php';
    // Use the REST API Client to make requests to the Twilio REST API
    use Twilio\Rest\Client;
    use Twilio\Exceptions\RestException;
    $twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

    

    if (!empty($_POST['body'])) { 
        $conversation_sid = $_POST['conversation_sid'];
        $author = $_POST['author'];
        $body = $_POST['body'];

        //get purchsed number list
        $purchased_number = array();
        $incomingNumber = $twilio->incomingPhoneNumbers->read([], 20);
        foreach($incomingNumber as $k => $numbers){
            $purchased_number[] = $numbers->phoneNumber;
        }

        //send message
        try{
            $message = $twilio->conversations->v1->conversations($conversation_sid)->messages->create(["author" => $author,"body" => $body]);
            $message_result = $message->toArray();
            $message_response = json_encode($message->toArray());
        }catch(RestException $ex){
            
        }

        //get last message
        $messages = $twilio->conversations->v1->conversations($conversation_sid)->messages->read();

        if(!empty($messages)){
            foreach ($messages as $key => $value){   
                $author =  $value->author;
                $body =  $value->body;
                $date = $value->dateUpdated->format('Y-m-d H:i A');
            }
        }else{
            echo "can not getting last message";
        }
        
        if(in_array($value->author,$purchased_number)){
            $html .='<div class="single-message self-message text-right">
                        <div class="user-massage">
                            <span class="user-name">'.$author.'</span>
                            <p><span class="color">'.$body.'</span></p>
                            <span style="font-size: 10px;" class="m-time">'. $date.'</span>
                        </div>
                    </div>';
            
        }else{
            $html .='<div class="single-message">
                        <div class="user-massage">
                            <span class="user-name">'.$author.'</span>
                            <p><span class="color">'.$body.'</span></p>
                            <span style="font-size: 10px;" class="m-time">'.$date.'</span>
                        </div>
                    </div>';
        }
        echo $html;
    }

?>