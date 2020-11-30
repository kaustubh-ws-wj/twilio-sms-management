<?php 
include 'config.php';
require_once ("connection.php");
require __DIR__ . '/vendor/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
$twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

if(!empty($_POST['conversation_sid'])){

	$sql    = "SELECT * from numbers WHERE numbers_id = 5";
	$result = mysqli_query($connect, $sql);
    $row    = mysqli_fetch_assoc($result);

    $proxy_address = $_POST['twilio_number'];
    $purchased_number = array();
    $incomingNumber = $twilio->incomingPhoneNumbers->read([], 20);
    foreach($incomingNumber as $k => $numbers){
        $purchased_number[] = $numbers->phoneNumber;
    }

    $conversation_sid = $_POST['conversation_sid'];
    
    $messages = $twilio->conversations->v1->conversations($conversation_sid)->messages->read();
    
    $html = '<div class="messages-content-header">
                <div class="profile-info">
                    <div class="user-info">
                        <span class="user-name">'.$row['numbers_first_name'].' '.$row['numbers_last_name'].'</span>
                        <span class="user-availability">Online</span>
                    </div>
                </div>   
            </div>';

    
        
        $html .='<div class="messages-content-body">
                    <div class="tab-pane fade show active" id="user-one" role="tabpanel" aria-labelledby="user-one-tab" style="height: 510px;">';
        if(!empty($messages)){
            foreach ($messages as $key => $value){    
                if(in_array($value->author,$purchased_number)){
                    $html .='<div class="single-message self-message text-right">
                                <div class="user-massage">
                                    <span class="user-name">'.$value->author.'</span>
                                    <p><span class="color">'.$value->body.'</span></p>
                                    <span class="m-time">8:00 am</span>
                                </div>
                            </div>';
                    
                }else{
                    $html .='<div class="single-message">
                                <div class="user-massage">
                                    <span class="user-name">'.$value->author.'</span>
                                    <p><span class="color">'.$value->body.'</span></p>
                                    <span class="m-time">8:00 am</span>
                                </div>
                            </div>';
                }
            }
        }else{
                    $html .='<div class="single-message self-message text-center">
                                <div class="user-massage">
                                    <p><span class="color">NO MESSAGES</span></p>
                                </div>
                            </div>';
        }
        
        $html .=    '</div>
                </div>';
        $html.='<div class="send-message">
                    <form id="conv_msg_form" action="create_conv_message.php" method="POST" class="lt-form">
                        <div class="form-group">
                            <input type="hidden" name="conversation_sid" value="'.$conversation_sid.'">
                            <input type="hidden" name="author" value="'.$proxy_address.'">
                            <input type="text" class="form-control" required name="body" placeholder="Type Your Message">
                            <button type="submit" id="send" value="Send">Send</button>
                        </div>
                    </form>
                </div>';

echo $html;
}?>

