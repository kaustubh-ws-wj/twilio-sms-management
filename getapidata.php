<?php 
include 'config.php';
require_once ("connection.php");
require __DIR__ . '/vendor/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
$twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

if(!empty($_POST['conversation_sid'])){

	$sql    = "SELECT phone_number from purchased_numbers";
	$result = mysqli_query($connect, $sql);
    //$purchased_number = mysqli_fetch_array($result);

    $proxy_address = $_POST['twilio_number'];
    $from_number = $_POST['from_number'];
    $purchased_number = array();
    $incomingNumber = $twilio->incomingPhoneNumbers->read([]);
    foreach($incomingNumber as $k => $numbers){
        $purchased_number[] = $numbers->phoneNumber;
    }
    
    $conversation_sid = $_POST['conversation_sid'];

    $query = "UPDATE `unread` SET `status` = '0' WHERE `unread`.`conversationSid` = '${conversation_sid}'";
    $returndata = mysqli_query($connect, $query);
    
    $messages = $twilio->conversations->v1->conversations($conversation_sid)->messages->read();
   
        $html = '<div class="messages-content-header">
                    <div class="profile-info">
                        <div class="user-info">
                            <span class="user-name">'.$_POST['from_number'].'</span>
                            <span class="user-availability">Online</span>
                        </div>
                    </div>   
                </div>';
        
        $html .='<div class="messages-content-body">
                    <div class="tab-pane fade show active" id="user-one" role="tabpanel" aria-labelledby="user-one-tab" style="height: 510px;">';
        if(!empty($messages)){

            $sender_msg = $twilio->messages->read(["from" => $proxy_address,"to" => $from_number],20);
            $receiver_msg = $twilio->messages->read(["from" => $from_number,"to" => $proxy_address],20);

            $sender_msg_array = array();
            $receiver_msg_array = array();

            foreach ($sender_msg as $key => $value){ 
                $o = new ReflectionObject($value->dateCreated);
                $p = $o->getProperty('date');
                $odate =  $p->getValue($value->dateCreated);
                $date = new DateTime($odate, new DateTimeZone('UTC'));
                $date->setTimezone(new DateTimeZone('America/New_York'));

                array_push($sender_msg_array,array( 'body'=>$value->body, 'from'=>$value->from, 'time'=>$date->format('Y-m-d H:i:s')));
            }
            foreach ($receiver_msg as $key => $value){ 
                $o = new ReflectionObject($value->dateCreated);
                $p = $o->getProperty('date');
                $odate =  $p->getValue($value->dateCreated);
                $date = new DateTime($odate, new DateTimeZone('UTC'));
                $date->setTimezone(new DateTimeZone('America/New_York'));

                array_push($receiver_msg_array,array( 'body'=>$value->body, 'from'=>$value->from, 'time'=>$date->format('Y-m-d H:i:s')));
            }

            $convarray = array_merge($sender_msg_array,$receiver_msg_array);

            usort($convarray, function($a, $b) {
                return $a['time'] <=> $b['time'];
            });            
            

            foreach ($convarray as $key => $value){

                if(in_array($value['from'],$purchased_number)){
                    $html .='<div class="single-message self-message text-right">
                                <div class="user-massage">
                                    <span class="user-name">'.$value['from'].'</span>
                                    <p><span class="color">'.$value['body'].'</span></p>
                                    <span style="font-size: 10px;" class="m-time">'.$value['time'].'</span>
                                </div>
                            </div>';
                }else{
                    $html .='<div class="single-message">
                                <div class="user-massage">
                                    <span class="user-name">'.$value['from'].'</span>
                                    <p><span class="color">'.$value['body'].'</span></p>
                                    <span style="font-size: 10px;" class="m-time">'.$value['time'].'</span>
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
        $html .= '<div class="latest-msg"> </div>';
        $html .=    '</div>
                </div>';
        $html.='<div class="send-message">
                    <div class="form-group">
                        <div class="iconsa">
                            <input type="hidden" name="conversation_sid" id="f_conversation_sid" value="'.$conversation_sid.'">
                            <input type="hidden" name="author" id="f_author" value="'.$proxy_address.'">
                            <input type="text" class="form-control" id="f_body" name="body" placeholder="Type Your Message" onkeyup="countChar(this)" required>
                            <small id="message-text" class="form-text text-muted text-warning"> <span id="current-count">160</span> remaining out of 160</small>
                            <input type="submit"  id="send" value="Send">  
                        </div>
                    </div>
                </div>';
        echo $html;
}?>