<?php 
include 'config.php';
require_once ("connection.php");
if((!empty($_POST['conversation_sid']) && $_POST['conversation_sid'] != '') && (!empty($_POST['author']) && $_POST['author'] != '') && (!empty($_POST['body']) && $_POST['body'] != '')){

    $conversation_sid = $_POST['conversation_sid'];
    $author = $_POST['author'];
    $body = $_POST['body'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://conversations.twilio.com/v1/Conversations/".$conversation_sid."/Messages",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "Author=".$author."&Body=".$body,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ".BASIC_AUTH_KEY,
            "Content-Type: application/x-www-form-urlencoded"
        ),
    ));

    $conv_messages_response = curl_exec($curl);
    curl_close($curl);
    echo $conv_messages_response;
}else{
    echo 'EROROR';
}