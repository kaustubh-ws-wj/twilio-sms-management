<?php 
    include 'config.php';
    require_once ("connection.php");
    require __DIR__ . '/vendor/autoload.php';
    
    use Twilio\Rest\Client;
    use Twilio\Exceptions\RestException;
    
    $twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

    if (isset($_POST['csv'])) {
        $list[] = array('Time'=>'Time','Incoming phone'=>'Incoming phone','Folder'=>'Folder','Message'=>'Message');
        $consql  = "SELECT * FROM conversations WHERE msgadded = '1' AND ConversationSid != ''";

        $cids = mysqli_query($connect,$consql);
        while($cid = mysqli_fetch_assoc($cids)){
            if (!empty($cid['ConversationSid'])) {
                $list[] = array('txt_time'=>$cid['DateCreated'],'from'=>$cid['MessagingBinding_Address'],'folder'=>$cid['folder'],'last_msg'=>$cid['lastMsg']);
            }
        }
        // if(!empty($conversations)){
        //     foreach($conversations as $key => $value){
        //         $conversation_array = $value->toArray();
        //         $attributes = json_decode($conversation_array['attributes'],true);
        //         if(!empty($attributes)){
        //             $conv_sid = $conversation_array['sid'];
        //             $participant = $twilio->conversations->v1->conversations($conv_sid)->participants->read();
        //             if(!empty($participant)){
        //                 $from = $participant[0]->messagingBinding['address'];
        //                 $proxy_address = $participant[0]->messagingBinding['proxy_address'];
        //                 // $txt_time = $participant[0]->dateUpdated->format('Y-m-d H:i');
        //             }else{
        //                 $from = " - - ";
        //                 $proxy_address = " - - ";
        //                 // $txt_time = " - - ";
        //             }
        //             $folder = $attributes['folder'];
        //             $messages = $twilio->conversations->v1->conversations($conv_sid)->messages->read();
        //             if(!empty($messages)){ 
        //                 $i = count($messages);
        //                 $last_msg = $messages[--$i]->body;
        //                 $o = new ReflectionObject($messages[--$i]->dateCreated);
        //                 $p = $o->getProperty('date');
        //                 $odate =  $p->getValue($messages[--$i]->dateCreated);
        //                 $date = new DateTime($odate, new DateTimeZone('UTC'));
        //                 $date->setTimezone(new DateTimeZone('America/New_York'));
        //                 $txt_time = $date->format('Y-m-d H:i:s');
        //             }else{
        //                 $last_msg = " - - ";
        //                 $txt_time = " - - ";
        //             }
        //             $list[] = array('txt_time'=>$txt_time,'from'=>$from,'folder'=>$folder,'last_msg'=>$last_msg);
        //         }
        //     }
        // }
        
        $csv_name = "messages".date('d-h-i-s').".csv";
        
        // if (!@is_dir($csv_name)) {
        //     @mkdir($csv_name, 0777, TRUE);
        // }
        $file = fopen("downloadcsv/{$csv_name}","w");
        
        foreach ($list as $row) {
            fputcsv($file, $row);
        }
        fclose($file);

        echo $csv_name;
        
    }



?>