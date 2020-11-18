<?php 
include 'config.php';
require_once ("connection.php");
require __DIR__ . '/vendor/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

$twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

if((!empty($_POST['conversation_sid']) && $_POST['conversation_sid'] != '') && (!empty($_POST['author']) && $_POST['author'] != '') && (!empty($_POST['body']) && $_POST['body'] != '')){
    
    $conversation_sid = $_POST['conversation_sid'];
    $author = $_POST['author'];
    $body = $_POST['body'];
    try{
        $message = $twilio->conversations->v1->conversations($conversation_sid)->messages->create(["author" => $author,"body" => $body]);
        $message_result = $message->toArray();
        $message_response = json_encode($message->toArray());
        
        header("Refresh:0; url=list_all_numbers.php?status=1");
    }catch(RestException $ex){
        header("Refresh:0; url=list_all_numbers.php?status=0");
    }
    
}else{
    header("Refresh:0; url=list_all_numbers.php?status=0");
}