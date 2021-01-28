<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include 'config.php';
require_once ("connection.php");
require __DIR__ . '/vendor/autoload.php';

require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

$twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

if ($_POST) {
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
			$conversationSid = $_POST['ConversationSid'];

			$twilio_number = $_POST["MessagingBinding_ProxyAddress"];
			$get_folder_query = "SELECT folder_name FROM call_routes WHERE call_routes_number = '$twilio_number'";
			$get_folder_result = mysqli_query($connect, $get_folder_query);
			$folder_name = mysqli_fetch_all($get_folder_result,MYSQLI_ASSOC);
			$folder = $folder_name[0]['folder_name'];

			$conversation = $twilio->conversations->v1->conversations($conversationSid)->update(["attributes" => json_encode(array('folder'=>$folder))]);
			http_response_code(200);
            break;

        case 'onMessageAdded':    
            $conversationSid = $_POST['ConversationSid'];
            $participantSid = $_POST['ParticipantSid'];
            $sql = "INSERT INTO conversations (response) values ('$post')";
            mysqli_query($connect, $sql);
            // {"RetryCount":"0","EventType":"onMessageAdded","Attributes":"{}","DateCreated":"2021-01-11T15:18:18.310Z","Author":"+16103162324","Index":"0","MessageSid":"IM91dd7dbac17847b4ace86450180bcd39","ParticipantSid":"MB14cf856e712a45e3a46afffad20bcf62","Body":"1018","AccountSid":"AC529db4ea06aba0a1ed7356e28d6b0dbb","Source":"SMS","ConversationSid":"CHcbf9398587e445589de80b077992f041"}
            $smsBody = $_POST['Body'];
            $date = $_POST['DateCreated'];
            $from = $_POST['Author'];
            
            $query = "SELECT notification_email FROM signup";
            $get_notif_email_result = mysqli_query($connect, $query);
            $notif_email = mysqli_fetch_all($get_notif_email_result,MYSQLI_ASSOC);
            $reciEmail = $notif_email[0]['notification_email'];

            $participant = $twilio->conversations->v1->conversations($conversationSid)->participants($participantSid)->fetch();
            $to = $participant->messagingBinding['address'];  

            sendMailSMS($from,$to,$smsBody,$date,$reciEmail);
            http_response_code(200);
            break;
            
		default:
			if($_POST['MessageStatus'] == 'delivered'){
				$message = $twilio->messages($_POST['SmsSid'])->fetch();
				$sms_data = $message->toArray();
				$smsBody = $sms_data['body'];
				$date = $sms_data['dateSent']->format('Y-m-d h:i:s A');
				
				$query = "SELECT notification_email FROM signup";
                $get_notif_email_result = mysqli_query($connect, $query);
                $notif_email = mysqli_fetch_all($get_notif_email_result,MYSQLI_ASSOC);
                $reciEmail = $notif_email[0]['notification_email'];
				
				 sendMailSMS($_POST['From'],$_POST['To'],$smsBody,$date,$reciEmail);
                 //demo($_POST['From'],$_POST['To'],$smsBody,$date,$reciEmail);
            }
			http_response_code(200);
			exit();
	}
}
function sendMailSMS($fromNumber,$toNumber,$smsBody,$date,$reciEmail){
    $sender = 'services@simpletextsolutions.com';
    $senderName = 'SimpleTextSolutions';
    $recipient = 'cpbuyerslist@gmail.com';
    $usernameSmtp = 'services@simpletextsolutions.com';
    $passwordSmtp = 'pPk8mlm4hZAE';
    $configurationSet = 'ConfigSet';
    $host = 'mail.simpletextsolutions.com';
    // $sender = 'webdeveloperswj@gmail.com';
    // $senderName = 'sender name';
    // $recipient = 'surajoshi1994@gmail.com';
    // $usernameSmtp = 'webdeveloperswj@gmail.com';
    // $passwordSmtp = 'WjWebDev45681$';
    // $configurationSet = 'ConfigSet';
    // $host = 'smtp.gmail.com'; 
    $port = 587;
    $subject = 'SMS from '.$fromNumber;
    $bodyText =  "";
    $bodyHtml = '<p>'.$smsBody.'</p><hr><p> From : '.$fromNumber.'  To :'.$toNumber.' <br> '.$date.'</p>';
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        // $mail->SMTPDebug = 2;
        $mail->setFrom($sender, $senderName);
        $mail->Username   = $usernameSmtp;
        $mail->Password   = $passwordSmtp;
        $mail->Host       = $host;
        $mail->Port       = $port;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'tls';
        $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);
        $mail->addAddress($recipient);
        $mail->isHTML(true);
        $mail->Subject    = $subject;
        $mail->Body       = $bodyHtml;
        $mail->AltBody    = $bodyText;
        $mail->Send();
    } catch (phpmailerException $e) {
        echo 'Message: ' .$e->getMessage();
    } catch (Exception $e) {
        echo 'Message: ' .$e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <input type="hideen" name="EventType" value="onMessageAdded">
        <input type="hideen" name="Body" value="Email">
        <input type="hideen" name="ConversationSid" value="CH94d78173e3fd4c1c8c22ef70004ce61f"> 
        <input type="hideen" name="ParticipantSid" value="MB134dbba0e0c242458bef39686109284c"> 
        <input type="hideen" name="DateCreated" value="2021-01-27T04:42:09.712Z">
        <input type="hideen" name="Author" value="+16103162324"> 
        <input type="submit" value="Submit">
    </form>
</body>
</html>