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

$proxy_address = "+12675783409";
$from_number = "+13476055623";
$conversation_sid = "CH11e5625a66394b46ba5b2f67b565b305";

// $campaign_messages_result = $twilio->messages->read(["from" => $proxy_address,"to" => $from_number],20);

$messages = $twilio->conversations->v1->conversations($conversation_sid)->messages->read();

echo "<pre>";
// print_r($campaign_messages_result);

// echo "-------------------------------------------------";

print_r($messages);

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