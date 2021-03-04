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

$proxy_address = "+12677109451";
$from_number = "+12678157307";
$conversation_sid = "CHe8edef36ee614cc1adfa5dddc95b8386";

// $campaign_messages_result = $twilio->messages->read(["from" => $proxy_address,"to" => $from_number],20);

$consql  = "SELECT ConversationSid FROM conversations WHERE msgadded = '0' AND ConversationSid != ''";
$cids = mysqli_query($connect,$consql);

while($cid = mysqli_fetch_assoc($cids)){
    $cidss = $cid['ConversationSid'];
    if (!empty($cidss)) {
        $messages = $twilio->conversations->v1->conversations($cidss)->messages->read();
        $i = count($messages);
        $last_msg = $messages[--$i]->body;
        $setquer = "UPDATE `conversations` SET `DateCreated`='$dateny',`lastMsg`='$last_msg',`msgadded`='1' WHERE `ConversationSid`='$cidss'";
        $msgupdate = mysqli_query($connect,$setquer);
    }
}

// $messages = $twilio->conversations->v1->conversations($conversation_sid)->messages->read();
// $campaign_messages_result = $twilio->messages->read(["from" => $proxy_address,"to" => $from_number],20);


echo "<pre>";
// print_r($messages);
echo "--------------------------";
print_r($purchased_number);

echo "-------------------------------------------------";
// print_r($campaign_messages_result);
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