<?php 
    include 'config.php';
    require_once ("connection.php");
    require __DIR__ . '/vendor/autoload.php';
    
    use Twilio\Rest\Client;
    use Twilio\Exceptions\RestException;

    $twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

    if (isset($_POST['csv'])) {
        $list[] = array('txt_time'=>'txt_time','from'=>'from','folder'=>'folder','last_msg'=>'last_msg');
        $conversations = $twilio->conversations->v1->conversations->read();
        if(!empty($conversations)){
            foreach($conversations as $key => $value){
                $conversation_array = $value->toArray();
                $attributes = json_decode($conversation_array['attributes'],true);
                if(!empty($attributes)){
                    $conv_sid = $conversation_array['sid'];
                    $participant = $twilio->conversations->v1->conversations($conv_sid)->participants->read();
                    $from = $participant[0]->messagingBinding['address'];
                    $proxy_address = $participant[0]->messagingBinding['proxy_address'];
                    $txt_time = $participant[0]->dateUpdated->format('Y-m-d H:i');
                    $folder = $attributes['folder'];
                    $messages = $twilio->conversations->v1->conversations($conv_sid)->messages->read(1);
                    $last_msg = $messages[0]->body;
                    
                    $list[] = array('txt_time'=>$txt_time,'from'=>$from,'folder'=>$folder,'last_msg'=>$last_msg);
                }
            }
        }

        $csv_name = "messages.csv";
        
        if (!@is_dir($csv_name)) {
            @mkdir($csv_name, 0777, TRUE);
        }
        $file = fopen($csv_name,"w");
        
        foreach ($list as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
        
    }



?>