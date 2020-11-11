<?php 

include 'config.php';
require __DIR__ . '/vendor/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
$twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

/* $messages = $twilio->messages->read([],20);

foreach ($messages as $key => $value) {
    echo $value->direction.' -----> '.$value->body.' ----> (From: '.$value->from.' To: '.$value->to.')</br>';
    
} */

$mobile = 'mobile';

