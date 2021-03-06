<?php

include 'connection.php';
include 'config.php';
require __DIR__ . '/vendor/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

$twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

if(isset($_POST) && isset($_POST['conv_sid']) && !empty($_POST['conv_sid']) && !empty($_POST['folder'])){
    //get conversation id
    $conversation_sid = $_POST['conv_sid'];
    $folder = $_POST['folder'];
    try{
        $conversation = $twilio->conversations->v1->conversations($conversation_sid)->update(["attributes" => json_encode(array('folder'=>$folder))]);
        $conversation_array = $conversation->toArray();

        $sql = "UPDATE `conversations` SET `folder`='$folder' WHERE `ConversationSid` = '$conversation_sid'";
        $res = mysqli_query($connect,$sql);

        echo json_encode($conversation_array);
    }catch(RestException $ex){
        echo json_encode(array('message'=>$ex->getMessages()));
    }
}

if(isset($_POST) && isset($_POST['cid']) && !empty($_POST['cid']) && !empty($_POST['selectedFolder'])){ 
    $cid = $_POST['cid'];
    $folder = $_POST['selectedFolder'];
    foreach($cid as $conversation_sid){
        try{
            $conversation = $twilio->conversations->v1->conversations($conversation_sid)->update(["attributes" => json_encode(array('folder'=>$folder))]);
            $conversation_array = $conversation->toArray();

            $sql = "UPDATE `conversations` SET `folder`='$folder' WHERE `ConversationSid` = '$conversation_sid'";
            $res = mysqli_query($connect,$sql);
            
        }catch(RestException $ex){
            echo json_encode(array('message'=>$ex->getMessages()));
        }
    }
    
    echo json_encode($conversation_array);
}

