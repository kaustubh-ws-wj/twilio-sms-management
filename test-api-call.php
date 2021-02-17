<?php 

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
            $conversationSid = $_POST['ConversationSid'];
            $MessagingBinding_ProxyAddress = $_POST['MessagingBinding_ProxyAddress'];
            $MessagingBinding_Address = $_POST['MessagingBinding_Address'];
            
			$twilio_number = $_POST["MessagingBinding_ProxyAddress"];
			$get_folder_query = "SELECT folder_name FROM call_routes WHERE call_routes_number = '$twilio_number'";
			$get_folder_result = mysqli_query($connect, $get_folder_query);
			$folder_name = mysqli_fetch_all($get_folder_result,MYSQLI_ASSOC);
            $folder = $folder_name[0]['folder_name'];

            $date = new DateTime($_POST['DateCreated'], new DateTimeZone('UTC'));
            $date->setTimezone(new DateTimeZone('America/New_York'));
            $date = $date->format('Y-m-d H:i:s');

            $sql = "INSERT INTO `conversations` ( `ConversationSid`, `DateCreated`, `lastMsg`, `MessagingBinding_ProxyAddress`, `MessagingBinding_Address`, `folder`, `msgadded`, `response`) VALUES ( '$conversationSid', '$date', '', '$MessagingBinding_ProxyAddress', '$MessagingBinding_Address', '$folder', '0', '$post')";
            mysqli_query($connect, $sql);

            $conversation = $twilio->conversations->v1->conversations($conversationSid)->update(["attributes" => json_encode(array('folder'=>$folder))]);
            http_response_code(200);
            
            break;

        case 'onMessageAdded':    
            $conversationSid = $_POST['ConversationSid'];
            $participantSid = $_POST['ParticipantSid'];
            // $sql = "INSERT INTO conversations (response) values ('$post')";
            // mysqli_query($connect, $sql);
        
            $smsBody = $_POST['Body'];
            $date = $_POST['DateCreated'];
            $from = $_POST['Author'];

            $participant = $twilio->conversations->v1->conversations($conversationSid)->fetch();
            $attr = json_decode($participant->attributes, true);
            $folder = $attr['folder'];

            $sql = "INSERT INTO `unread` ( `folder`, `conversationSid`, `fromNumber`, `status`) VALUES ('${folder}','${conversationSid}', '${from}', '1')";
            mysqli_query($connect, $sql);

            $consql  = "SELECT ConversationSid FROM conversations WHERE msgadded = '0' AND ConversationSid != ''";
            $cids = mysqli_query($connect,$consql);

            while($cid = mysqli_fetch_assoc($cids)){
                $cidss = $cid['ConversationSid'];
                if (!empty($cidss)) {
                    $messages = $twilio->conversations->v1->conversations($cidss)->messages->read();
                    $i = count($messages);
                    $last_msg = $messages[--$i]->body;
                    $setquer = "UPDATE `conversations` SET `DateCreated`='$date',`lastMsg`='$last_msg',`msgadded`='1' WHERE `ConversationSid`='$cidss'";
                    $msgupdate = mysqli_query($connect,$setquer);
                }
            }

            $smessages = $twilio->conversations->v1->conversations($cidss)->messages->read();
            $i = count($smessages);
            $last_msgs = $smessages[--$i]->body;

            $setquerys = "UPDATE `conversations` SET `DateCreated`='$date',`lastMsg`='$last_msgs' WHERE `ConversationSid`='$cidss'";
            $msgupdate = mysqli_query($connect,$setquerys);
            
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
				
				//sendMailSMS($_POST['From'],$_POST['To'],$smsBody,$date,$reciEmail);
                //demo($_POST['From'],$_POST['To'],$smsBody,$date,$reciEmail);
            }
			http_response_code(200);
			exit();
    }
    

    function sendMailSMS($fromNumber,$toNumber,$smsBody,$date,$reciEmail){
        $sender = 'admin@simpletextsolutions.com';
        $senderName = 'SimpleTextSolutions';
        $recipient = 'cpbuyerslist@gmail.com';
        $usernameSmtp = 'admin@simpletextsolutions.com';
        $passwordSmtp = 'tFl&njH5H8@R'; 
        $configurationSet = 'ConfigSet';
        $host = 'mail.simpletextsolutions.com';
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
            
        } catch (Exception $e) {
        
            
        }
    }