<?php 
include 'config.php';
require_once ("connection.php");
require __DIR__ . '/vendor/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

$twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

$folder_name = $_POST['folder_name'];
$list = [];
$conversation_html = '';
function date_compare($a, $b)
{
    $t1 = strtotime($a['txt_time']);
    $t2 = strtotime($b['txt_time']);
    return $t2 - $t1;
}    

//try{
    $conversations = $twilio->conversations->v1->conversations;
    if(!empty($conversations)){
        foreach($conversations as $key => $value){
            $conversation_array = $value->toArray();
            $attributes = json_decode($conversation_array['attributes'],true);
            if(!empty($attributes)){
                if($attributes['folder'] == $folder_name){
                    $conv_sid = $conversation_array['sid'];
                    $participant = $twilio->conversations->v1->conversations($conv_sid)->participants->read(20);
                    $from = $participant[0]->messagingBinding['address'];
                    $proxy_address = $participant[0]->messagingBinding['proxy_address'];
                    $txt_time = $participant[0]->dateUpdated->format('Y-m-d H:i');
                    $messages = $twilio->conversations->v1->conversations($conv_sid)->messages->read(1);
                    $last_msg = $messages[0]->body;

                    $list[] = array('conv_sid'=>$conv_sid,'from'=>$from,'proxy_address'=>$proxy_address,'txt_time'=>$txt_time,'last_msg'=>$last_msg);

                    /* $conversation_html .="<a class='nav-link ui-widget-content' draggable='true' ondragstart='drag(event)' id='user-tab_".$key."' converstaionsid='".$conv_sid."' data-toggle='pill' href='#' role='tab' aria-controls='user' onClick='getMessages(\"".$conv_sid."\",\"".$proxy_address."\",\"".$from."\")' aria-selected='true' >
                                            <span class='d-flex'>
                                                <span class='message-highlight'>
                                                    <span class='user-name'>".$from."</span>
                                                    <span class='last-m'>".$last_msg."</span>
                                                </span>
                                            </span>
                                            <span class='m-time'>".$txt_time."</span>
                                        </a>"; 
                    */
                    $status = 'found';
                }else{
                    $status = 'error';
                }
            }else{
                $status = 'error';
            }
        }
    }else{
            $status = 'error';
    }
//}catch(RestException $ex){}
usort($list, 'date_compare');
echo json_encode(array('status'=> $status,'list'=> json_encode($list)));


