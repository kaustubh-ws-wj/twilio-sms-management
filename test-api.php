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

$participantSid = 'MBdc0adf037b4342fa9d3a4e471b5ff0a2';
$conversationSid = 'CH4f4cfc1203d147528eea0dd80d1a3222';


$participant = $twilio->conversations->v1->conversations($conversationSid)->fetch();
$attr = json_decode($participant->attributes, true);
$folder = $attr['folder'];

$sql = "INSERT INTO `unread` ( `folder`, `conversationSid`, `fromNumber`, `status`) VALUES ('${folder}','${conversationSid}', '1234567890', '1')";
echo $sql;
// mysqli_query($connect, $sql);

?>