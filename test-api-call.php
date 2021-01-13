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
	
	    

			function sendMailSMS($fromNumber,$toNumber,$smsBody,$date,$reciEmail){
            	$sender = 'services@simpletextsolutions.com';
                $senderName = 'SimpleTextSolutions';
                $recipient = $reciEmail;
                $usernameSmtp = 'services@simpletextsolutions.com';
                $passwordSmtp = 'p.mSkJ1xQy-L';
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