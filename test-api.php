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

$proxy_address = "+12675783493";
$from_number = "+13474407177";
$conversation_sid = "CH4536f5206dbc4cf7bc4e5c4bcb8c7d58";

// $call = $twilio->calls
//                ->create("+14155551212", // to
//                         "+14155551212", // from
//                         ["url" => "http://demo.twilio.com/docs/classic.mp3"]
//                );

// print($call->sid);

// $twilio->conversations->v1->conversations("CHXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")->delete();


// $messages = $twilio->conversations->v1->conversations($conversation_sid)->messages->read();

// $campaign_messages_result = $twilio->messages->read(["from" => $proxy_address,"to" => $from_number],20);

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

// $onlydate = date('Y-m-d', strtotime("2021-04-06"));
// foreach ($campaign_messages_result as $key => $value){ 
//     $o = new ReflectionObject($value->dateCreated);
//     $p = $o->getProperty('date');
//     $odate =  $p->getValue($value->dateCreated);
//     $date = new DateTime($odate, new DateTimeZone('UTC'));
//     $date->setTimezone(new DateTimeZone('America/New_York'));
//     // if ($date->format('Y-m-d') == $onlydate) {
//         echo $value->body."||".$date->format('Y-m-d H:i:s')."||".$key."<br>";
//     // }
// }

echo "<pre>";
print_r($sender_msg_array);
echo "-----------------";
print_r($receiver_msg_array);
echo "----------------";
print_r($convarray);
echo "----------------";

usort($convarray, function($a, $b) {
    return $a['time'] <=> $b['time'];
});
print_r($convarray);
foreach ($convarray as $key => $value){ 
    echo $value['body'];
}
die;
echo "--------------------------";
// print_r($campaign_messages_result);

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