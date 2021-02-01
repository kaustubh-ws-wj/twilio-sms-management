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
$conversationSid = 'CH21f6d4b4a9e74e1da2f8be0785cb9d5b';


$participant = $twilio->conversations->v1->conversations($conversationSid)->messages->read();
echo "hello";
echo "<pre>";
print_r($participant);  
?>