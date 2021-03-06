<?php
 
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    include 'config.php';
    require_once ("connection.php");
    require __DIR__ . '/vendor/autoload.php';
    // Use the REST API Client to make requests to the Twilio REST API
    use Twilio\Rest\Client;
    use Twilio\Exceptions\RestException;

    $twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

    function date_compare($a, $b){
        $t1 = strtotime($a['DateCreated']);
        $t2 = strtotime($b['DateCreated']);
        return $t2 - $t1;
    } 
    $folder_name = "Buyers List";
    $conversations = $twilio->conversations->v1->conversations->read();      
    if(!empty($conversations)){
        foreach($conversations as $key => $value){
            $conversation_array = $value->toArray();
            $attributes = json_decode($conversation_array['attributes'],true);
            if(!empty($attributes)){
                if($attributes['folder']  == $folder_name){
                    
                    $conv_sid = $conversation_array['sid'];
                    $participant = $twilio->conversations->v1->conversations($conv_sid)->participants->read(1);
                    if(!empty($participant[0]->messagingBinding['address'])){
                        $from = $participant[0]->messagingBinding['address'];
                        $proxy_address = $participant[0]->messagingBinding['proxy_address'];
                        $txt_time = $participant[0]->dateUpdated->format('Y-m-d H:i');
                        $messages = $twilio->conversations->v1->conversations($conv_sid)->messages->read(1);
                        $last_msg = $messages[0]->body;
                    }

                    $sql = "INSERT INTO `conversations` ( `ConversationSid`, `DateCreated`, `lastMsg`, `MessagingBinding_ProxyAddress`, `MessagingBinding_Address`, `folder`, `msgadded`) VALUES ( '$conv_sid', '$txt_time', '$last_msg', '$proxy_address', '$from', '$folder_name', '1')";
                    mysqli_query($connect, $sql);
                    // $list[] = array('ConversationSid'=>$conv_sid,'DateCreated'=>$txt_time,'lastMsg'=>$last_msg,'MessagingBinding_ProxyAddress'=>$proxy_address,'MessagingBinding_Address'=>$from);

                    /* $conversation_html .="<a class='nav-link ui-widget-content' draggable='true' ondragstart='drag(event)' id='user-tab_".$key."' converstaionsid='".$conv_sid."' data-toggle='pill' href='#' role='tab' aria-controls='user' onClick='getMessages(\"".$conv_sid."\",\"".$proxy_address."\",\"".$from."\")' aria-selected='true' >
                                            <span class='d-flex'>
                                                <span class='message-highlight'>
                                                    <span class='user-name'>".$from."</span>
                                                    <span class='last-m'>".$last_msg."</span>
                                                </span>
                                            </span>
                                            <span class='m-time'>".$txt_time."</span>
                                        </a>"; 
                    */
                    $status = 'found';
                }else{
                    $status = 'error';
                }
            }else{
                $status = 'error';
            }
        }
    }else{
        $status = 'error';
    }

    usort($list, 'date_compare');
    echo json_encode(array('status'=> $status,'list'=> json_encode($list)));

?>