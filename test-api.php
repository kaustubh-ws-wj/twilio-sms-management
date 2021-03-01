<?php
//services@simpletextsolutions.com
//p.mSkJ1xQy-L
include 'config.php';
require_once ("connection.php");
require __DIR__ . '/vendor/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
$twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

$proxy_address = "+12675783087";
$from_number = "+18627725532";
$conversation_sid = "CHb8021e07777e459e88b87cfac49e6e2a";

// $campaign_messages_result = $twilio->messages->read(["from" => $proxy_address,"to" => $from_number],20);

// $messages = $twilio->conversations->v1->conversations($conversation_sid)->fetch();

$messages = $twilio->conversations->v1->conversations($conversation_sid)->messages->read();
if(!empty($messages)){ 
    $i = count($messages);
    $last_msg = $messages[--$i]->body;
    $o = new ReflectionObject($messages[--$i]->dateCreated);
    $p = $o->getProperty('date');
    $odate =  $p->getValue($messages[--$i]->dateCreated);
    $dates = new DateTime($odate, new DateTimeZone('UTC'));
    $dates->setTimezone(new DateTimeZone('America/New_York'));
    $txt_time = $dates->format('Y-m-d H:i:s');
}

echo $txt_time;
echo $last_msg;


// $i = count($smessages);
// $last_msgs = $smessages[--$i]->body;
// $date = '2021-02-11T04:31:21.679Z';

// $setquerys = "UPDATE `conversations` SET `DateCreated`='$date',`lastMsg`='$last_msgs' WHERE `ConversationSid`='$conversation_sid'";
// echo $setquerys;
echo "<pre>";
print_r($messages);

// echo "-------------------------------------------------";
// print_r($campaing_message_array);
// $o = new ReflectionObject($campaing_message_array['dateUpdated']);
// $p = $o->getProperty('date');
// echo  $p->getValue($campaing_message_array['dateUpdated']);
// $i = count($messages);
// $last_msg = $messages[--$i]->body;
// $date = '2021-02-11T04:31:21.679Z';
// echo $date;
// $setquer = "UPDATE `conversations` SET `DateCreated`='$date',`lastMsg`='$last_msg',`msgadded`='1' WHERE `ConversationSid`='$conversation_sid'";
// echo $setquer;
// $sql  = "SELECT ConversationSid FROM conversations WHERE msgadded = '0'";
// $cids = mysqli_query($connect,$sql);

// while($cid = mysqli_fetch_assoc($cids)){
//     $cidss = $cid['ConversationSid'];

//     $messages = $twilio->conversations->v1->conversations($cidss)->messages->read(1);
//     $last_msg = $messages[0]->body;

//     $query = "UPDATE `conversations` SET `lastMsg`='$last_msg',`msgadded`='1' WHERE `ConversationSid`='$cidss'";
//     $msgupdate = mysqli_query($connect,$query); 
// }

?> 