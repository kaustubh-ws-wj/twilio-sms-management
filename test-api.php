<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';
require_once ("connection.php");
require __DIR__ . '/vendor/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
$twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

$proxy_address = "+12677109451";
$from_number = "+12678157307";
$conversation_sid = "CH25c3557fa94e48f1b79c25cf67e327b2";

// $campaign_messages_result = $twilio->messages->read(["from" => $proxy_address,"to" => $from_number],20);

$consql  = 'SELECT ConversationSid FROM conversations WHERE `lastMsg` = "Confirming 11am showing" limit 200';
// $consql  = 'SELECT ConversationSid FROM conversations WHERE `lastMsg` = "Call 302-295-1214" limit 200';
$cids = mysqli_query($connect,$consql);
// $i = 0;
while($cid = mysqli_fetch_assoc($cids)){
    $cidss = $cid['ConversationSid'];
    if (!empty($cidss)) {
        // echo $cidss.'->'.++$i."<br>";
        $campaign_messages_result = $twilio->conversations->v1->conversations($cidss)->messages->read();
        $i = count($campaign_messages_result);
        
        if ($i >= 1 ) {
            $campaing_message_array = $campaign_messages_result[--$i]->toArray();
            $o = new ReflectionObject($campaing_message_array['dateUpdated']);
            $p = $o->getProperty('date');
            $odates = $p->getValue($campaing_message_array['dateUpdated']);
            $dateone = new DateTime($odates, new DateTimeZone('UTC'));
            $dateone->setTimezone(new DateTimeZone('America/New_York'));
            $dateny = $dateone->format('Y-m-d H:i:s');
            $last_msg = $campaing_message_array['body'];
        
            $setquer = 'UPDATE `conversations` SET `DateCreated`="'.$dateny.'",`lastMsg`="'.$last_msg.'",`msgadded`="1" WHERE `ConversationSid`="'.$cidss.'"';
            $msgupdate = mysqli_query($connect,$setquer);
        }elseif($i == 0 ){
            if (!empty($campaign_messages_result)) {
                $campaing_message_array = $campaign_messages_result[0]->toArray();
                $o = new ReflectionObject($campaing_message_array['dateUpdated']);
                $p = $o->getProperty('date');
                $odates = $p->getValue($campaing_message_array['dateUpdated']);
                $dateone = new DateTime($odates, new DateTimeZone('UTC'));
                $dateone->setTimezone(new DateTimeZone('America/New_York'));
                $dateny = $dateone->format('Y-m-d H:i:s');
                $last_msg = $campaing_message_array['body'];
            
                $setquer = 'UPDATE `conversations` SET `DateCreated`="'.$dateny.'",`lastMsg`="'.$last_msg.'",`msgadded`="1" WHERE `ConversationSid`="'.$cidss.'"';
                $msgupdate = mysqli_query($connect,$setquer);
            }
           
        }
        
    }
}

// $messages = $twilio->conversations->v1->conversations($conversation_sid)->messages->read();
// $campaign_messages_result = $twilio->messages->read(["from" => $proxy_address,"to" => $from_number],20);


echo "<pre>";
// print_r($messages);
echo "--------------------------";
// print_r($purchased_number);

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