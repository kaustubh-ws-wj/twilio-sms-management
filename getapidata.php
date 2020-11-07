<?php 
include 'config.php';
require_once ("connection.php");
if(!empty($_POST['id'])){

	$sql    = "SELECT * from numbers WHERE numbers_id = ".$_POST['id'];
	$result = mysqli_query($connect, $sql);
    $row    = mysqli_fetch_assoc($result);

    $conversation_sid = $_POST['conversation_sid'];
    $participant_obj = json_decode($row['participant_response']); 
    $identity = $participant_obj->identity;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://conversations.twilio.com/v1/Conversations/".$conversation_sid."/Messages",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ".BASIC_AUTH_KEY
        ),
    ));

    $messages_response = curl_exec($curl);
    curl_close($curl);
    $messages_result = json_decode($messages_response);

    $html = '<div class="messages-content-header">
                <div class="profile-info">
                    <div class="profile-picture">
                        <img src="assets/img/sample_p.jpg" alt="Profile Picture">    
                    </div>
                    <div class="user-info">
                        <span class="user-name">'.$row['numbers_first_name'].' '.$row['numbers_last_name'].'</span>
                        <span class="user-availability">Online</span>
                    </div>
                </div>
                <div class="user-options">
                    <ul class="global-list d-flex justify-content-between">
                        <li><a href="#"><i class="fa fa-phone" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-video-camera" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-user-plus" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a></li>
                    </ul>
                </div>    
            </div>';

    
        
        $html .='<div class="messages-content-body">
                    <div class="tab-pane fade show active" id="user-one" role="tabpanel" aria-labelledby="user-one-tab" style="height: 510px;">';
        if(!empty($messages_result->messages)){
            foreach ($messages_result->messages as $key => $value){    
                if($value->author == $identity){
                    $html .='<div class="single-message">
                                <div class="profile-picture">
                                    <img src="assets/img/sample_p.jpg" alt="Profile Picture">    
                                </div>
                                <div class="user-massage">
                                    <span class="user-name">'.$value->author.'</span>
                                    <p><span class="color">'.$value->body.'</span></p>
                                    <span class="m-time">8:00 am</span>
                                </div>
                            </div>';
                }else{
                    $html .='<div class="single-message self-message text-right">
                                <div class="user-massage">
                                    <span class="user-name">'.$value->author.'</span>
                                    <p><span class="color">'.$value->body.'</span></p>
                                    <span class="m-time">8:00 am</span>
                                </div>
                            </div>';
                }
            }
        }else{
                    $html .='<div class="single-message self-message text-center">
                                <div class="user-massage">
                                    <p><span class="color">NO MESSAGES</span></p>
                                </div>
                            </div>';
        }
        
        $html .=    '</div>
                </div>';
        $html.='<div class="send-message">
                    <form id="conv_msg_form" action="create_conv_message.php" method="POST" class="lt-form">
                        <div class="form-group">
                            <input type="hidden" name="conversation_sid" value="'.$conversation_sid.'">
                            <input type="hidden" name="author" value="+919860538505">
                            <input type="text" class="form-control" required name="body" placeholder="Type Your Message">
                            <button type="submit" id="send" value="Send">Send</button>
                        </div>
                    </form>
                </div>';

echo $html;
}?>

