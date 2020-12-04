<?php 


include 'config.php';
require_once ("connection.php");
require __DIR__ . '/vendor/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
$twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);


// $payload = file_get_contents('php://input');
// $response = json_encode($payload);
// $sql = "INSERT INTO conversations (responses) values ('$response')";
// mysqli_query($connect, $sql);
// http_response_code(200);


$eventType = $_POST['EventType'];


$body = $_POST['Body'];

$post = json_encode($_POST);
error_log('---Request Start---');
error_log($post);
error_log('---Request End---');

    // Handle the event
	switch ($eventType) {
	    case 'onConversationAdded':
			//Perform Conversation Add Operation to Update attribute with default Folder name.
			//$conversation = $twilio->conversations->v1->conversations($conversationSid)->update(["attributes" => "{'folder':'Inbox'}"]);
			$sql = "INSERT INTO conversations (response) values ('$post')";
			mysqli_query($connect, $sql);
			http_response_code(200);
			break;
		case 'onConversationAdd':
			//Perform Conversation Add Operation to Update attribute with default Folder name.
			
			$sql = "INSERT INTO conversations (response) values ('$post')";
			mysqli_query($connect, $sql);
			http_response_code(200);
			break;
		case 'onMessageAdd':
			//Perform Conversation Add Operation to Update attribute with default Folder name.
			$sql = "INSERT INTO conversations (response) values ('$post')";
			mysqli_query($connect, $sql);
            /* 
                //Conversation update with default folder
                $conversationSid = $_POST['ConversationSid'];
                $conversation = $twilio->conversations->v1->conversations($conversationSid)->update(["attributes" => "{'folder':'Inbox'}"]);
            */
            http_response_code(200);
			break;
		case 'onMessageAdded':
			//Perform Conversation Add Operation to Update attribute with default Folder name.
			$sql = "INSERT INTO conversations (response) values ('$post')";
			mysqli_query($connect, $sql);
			http_response_code(200);
			break;
		default:
			$sql = "INSERT INTO conversations (response) values ('$post')";
			mysqli_query($connect, $sql);
			http_response_code(200);
			exit();
	}