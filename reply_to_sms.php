<?php
require 'vendor/autoload.php';
use Plivo\XML\Response;

function sendResponseWithPlivo()
{
    $number = $_POST["From"];
    $response = new Response();
    $params = array(
        'src' => "+12157742371",
        'dst' => '+923152238226',
        'callbackUrl' => "https://www.foo.com/sms_status/",
        'callbackMethod' => "POST"
    );
    $message_body = "Testing reply to an incoming SMS";
    $response->addMessage($message_body, $params);
    return $response->toXML();
}
 header("Content-type: text/xml; charset=utf-8");
 echo sendResponseWithPlivo();