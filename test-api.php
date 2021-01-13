<?php
//services@simpletextsolutions.com
//p.mSkJ1xQy-L


include 'config.php';
require 'vendor/autoload.php';

require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

            function sendMailSMS(){
            	$sender = 'services@simpletextsolutions.com';
                $senderName = 'SimpleTextSolutions';
                $recipient = 'wakharekaustubh@gmail.com';
                $usernameSmtp = 'services@simpletextsolutions.com';
                $passwordSmtp = 'p.mSkJ1xQy-L';
                $configurationSet = 'ConfigSet';
                $host = 'mail.simpletextsolutions.com';
                $port = 587;
                $subject = 'SMS from Test';
                $bodyText =  "";
                $bodyHtml = '<p>SimpletextSolutions</p>';
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->SMTPDebug = 2;
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
    		
            sendMailSMS();