<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include 'config.php';
require_once ("connection.php");
require __DIR__ . '/vendor/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

$twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

// @Suraj new code

function date_compare($a, $b){
    $t1 = strtotime($a['txt_time']);
    $t2 = strtotime($b['txt_time']);
    return $t2 - $t1;
}  

$folder_name = $_POST['folder_name'];
$list = [];
$sql = "SELECT * FROM conversations where folder = '$folder_name' ORDER BY DateCreated DESC";
$con_arry = mysqli_query($connect,$sql);

while($conv = mysqli_fetch_assoc($con_arry)){ 
    $list[] = array('conv_sid'=>$conv['ConversationSid'],'from'=>$conv['MessagingBinding_Address'],'proxy_address'=>$conv['MessagingBinding_ProxyAddress'],'txt_time'=>date_format(new DateTime($conv['DateCreated']),'Y-m-d h:i:s A'),'last_msg'=>$conv['lastMsg']);
}

$status = 'found';
usort($list, 'date_compare');
echo json_encode(array('status'=> $status,'list'=> json_encode($list)));

// @kaustub old Code from api side
// $folder_name = $_POST['folder_name'];
// $list = [];
// $conversation_html = '';

// function date_compare($a, $b)
// {
//     $t1 = strtotime($a['txt_time']);
//     $t2 = strtotime($b['txt_time']);
//     return $t2 - $t1;
// }    

// //try{
//     $conversations = $twilio->conversations->v1->conversations->read();

      
//     if(!empty($conversations)){
//         foreach($conversations as $key => $value){
//             $conversation_array = $value->toArray();
//             $attributes = json_decode($conversation_array['attributes'],true);
//             if(!empty($attributes)){
//                 if($attributes['folder'] == $folder_name){
                    
//                     $conv_sid = $conversation_array['sid'];
//                     $participant = $twilio->conversations->v1->conversations($conv_sid)->participants->read(1);
//                     if(!empty($participant[0]->messagingBinding['address'])){
//                         $from = $participant[0]->messagingBinding['address'];
//                         $proxy_address = $participant[0]->messagingBinding['proxy_address'];
//                         $txt_time = $participant[0]->dateUpdated->format('Y-m-d H:i');
//                         $messages = $twilio->conversations->v1->conversations($conv_sid)->messages->read(1);
//                         $last_msg = $messages[0]->body;
//                     }

//                     $list[] = array('conv_sid'=>$conv_sid,'from'=>$from,'proxy_address'=>$proxy_address,'txt_time'=>$txt_time,'last_msg'=>$last_msg);

//                     /* $conversation_html .="<a class='nav-link ui-widget-content' draggable='true' ondragstart='drag(event)' id='user-tab_".$key."' converstaionsid='".$conv_sid."' data-toggle='pill' href='#' role='tab' aria-controls='user' onClick='getMessages(\"".$conv_sid."\",\"".$proxy_address."\",\"".$from."\")' aria-selected='true' >
//                                             <span class='d-flex'>
//                                                 <span class='message-highlight'>
//                                                     <span class='user-name'>".$from."</span>
//                                                     <span class='last-m'>".$last_msg."</span>
//                                                 </span>
//                                             </span>
//                                             <span class='m-time'>".$txt_time."</span>
//                                         </a>"; 
//                     */
//                     $status = 'found';
//                 }else{
//                     $status = 'error';
//                 }
//             }else{
//                 $status = 'error';
//             }
//         }
//     }else{
//         $status = 'error';
//     }
// //}catch(RestException $ex){}
// usort($list, 'date_compare');
// echo json_encode(array('status'=> $status,'list'=> json_encode($list)));

?>