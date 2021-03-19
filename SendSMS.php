<?php
ini_set('max_execution_time', 6000);
include 'config.php';
include 'connection.php';
include 'PHPExcel-1.8/Classes/PHPExcel.php';
require __DIR__ . '/vendor/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

$twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

if(isset($_POST) && !empty($_POST) && isset($_POST['call_routes_id']) && !empty($_POST['call_routes_id'])){
    $message_body = $_POST['message'];

    // $query_test = "SELECT * FROM numbers where numbers_group_id = {$_POST['group']}";
    // $result_test = mysqli_query($connect, $query_test);
    // $total_rows_test = mysqli_num_rows($result_test);

    $contact_list_query = "SELECT * FROM contact_list WHERE id= {$_POST['contact_list']}";
    $result_contact_list = mysqli_query($connect,$contact_list_query);
    $assoc_result_contact_list = mysqli_fetch_assoc($result_contact_list);

    
    if($assoc_result_contact_list['mapping_status'] != 'Needs to map'){

        $inputFileType = PHPExcel_IOFactory::identify($assoc_result_contact_list['list_path']);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($assoc_result_contact_list['list_path']);
        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

        // echo '<pre>';print_r($allDataInSheet);die;

        $phone_col = $assoc_result_contact_list['phone'];
        if(count($allDataInSheet) > 1){
            if (count($_POST['call_routes_id']) > 0) {
                $abc = serialize($_POST['call_routes_id']);
                $total_customer_number = count($allDataInSheet);
                $total_sender_number = count($_POST['call_routes_id']);                    
                $total_sms_to_be_send = $total_customer_number * $total_sender_number;
                $query_c = "INSERT INTO campaign(campaign_name,campaign_message,campaign_call_route,campaign_route_numbers,campaign_status,total,total_sent,cost) VALUES ('{$_POST['campaign_name']}','{$message_body}','{$_POST['route']}','{$abc}','1','{$total_sms_to_be_send}',0,00.00)";
                $ins = mysqli_query($connect, $query_c);
                $last_id = mysqli_insert_id($connect);
                //capable to send 120 SMS 
                $throttle = 120;
                $sent_count = 0;
                $sender_pool = count($_POST['call_routes_id']);
                $next = 0;
                $tot_sent_sms = 0;
                $cost = 0.0000;
                $suppress_count = 0; 
                $not_send = 0;
                $digit_incre = 0;
                //foreach($_POST['call_routes_id'] as $i => $number){
                    foreach($allDataInSheet as $key => $value){
                        if($key != 1){
                            if($value[$phone_col] != ''){
                                $phone_number = '+1'.$value[$phone_col];                            
                                if($sent_count == 120){
                                    $next++;
                                    $sent_count = 0;
                                }
                                if ($digit_incre < $total_customer_number) {
                                    $digit_incre++;
                                }
                                $sender = $_POST['call_routes_id'][$next];
                                //$sender = $number;
                                // echo 'post msg -> '.$message_body;

                                unset($new_body);
                                $new_body = $message_body;
                                
                                //old find and replace code
                                // $words = array('Hello','Hey','Hii');
                                // $new_body = str_replace("Hello",$words[rand(0,2)],$new_body);
                                //End of old find and replace code

                                $newwrd   = ["Hello", "Hi", "Hey"];
                                $new_body = str_replace("#spin#", $newwrd[rand(0,2)], $new_body);

                                foreach($allDataInSheet[1] as $col => $cell_val){
                                    $new_body = str_replace("#".$cell_val."#",$value[$col],$new_body);
                                }                               
                                
                                $check_suppression_query = "SELECT * FROM suppression WHERE suppression = {$phone_number} LIMIT 1";
                                $check_suppression_exe = mysqli_query($connect,$check_suppression_query);
                                $check_suppression_rows = mysqli_num_rows($check_suppression_exe); 
                                if($check_suppression_rows > 0){
                                    $suppress_count++;
                                }else{
                                    try{
                                        $message = $twilio->messages->create($phone_number, // to
                                        [
                                            "body" => $new_body,
                                            "messagingServiceSid" => "MG6cd88d0beeaca544176e383fdd0d90c8",
                                            "from" => $sender
                                        ]);
                                        $sent_count++;

                                        $status = $message->status;
                                        $cost = $cost + $message->price;
                                        if($status == 'sent'){
                                            $tot_sent_sms++;
                                        }
                                    }
                                    catch(RestException $e){
                                        echo 'Message: ' .$e->getMessage();
                                    }
                                    
                                    /* 
                                        $curl = curl_init();
                                        curl_setopt_array($curl, array(
                                            CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/".ACCOUNT_SID."/Messages.json",
                                            CURLOPT_RETURNTRANSFER => true,
                                            CURLOPT_ENCODING => "",
                                            CURLOPT_MAXREDIRS => 10,
                                            CURLOPT_TIMEOUT => 0,
                                            CURLOPT_FOLLOWLOCATION => true,
                                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                            CURLOPT_CUSTOMREQUEST => "POST",
                                            CURLOPT_POSTFIELDS => "Body=".$message."&To=".$phone_number."&From=".$sender,
                                            CURLOPT_HTTPHEADER => array(
                                                "Authorization: Basic ".BASIC_AUTH_KEY,
                                                "Content-Type: application/x-www-form-urlencoded"
                                            ),
                                        ));
                                        $response = curl_exec($curl);
                                        curl_close($curl); 
                                    */
                                }
                            }
                        }
                    }
                    $querys = "UPDATE `campaign` SET `total_sent` = {$tot_sent_sms}, `cost` = {$cost} WHERE campaign_id = {$last_id}";
                    $res = mysqli_query($connect,$querys);
                //}
                
                header("location: send_message.php?status=1");            
            }else{
                header("location: send_message.php?status=0");
            }
        }else{
            header("location: send_message.php?status=4");
        }
    }else{
        header("Refresh:0; url=send_message.php?status=3");
    }   
    
    /* if (count($_POST['call_routes_id']) > 0 && $total_rows_test > 0) {
        $abc = serialize($_POST['call_routes_id']);
        // echo "<pre>";
        // print_r($abc);
        // exit;
    	$query_c = "INSERT INTO campaign(campaign_name,campaign_message,campaign_group,campaign_call_route,campaign_route_numbers,campaign_status) VALUES ('{$_POST['campaign_name']}','{$message}','{$_POST['group']}','{$_POST['route']}','{$abc}','1')";
        $ins = mysqli_query($connect, $query_c);
        $query = "SELECT * FROM numbers where numbers_group_id = {$_POST['group']}";
        $result = mysqli_query($connect, $query);
        $total_rows = mysqli_num_rows($result);
        
        
        $i=0;
        while($roww=mysqli_fetch_assoc($result))
        {
    	    $phone_number = $roww['numbers_phone_number'];
    		
    		$sender = $_POST['call_routes_id'][$i];
    		
    		$curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/".ACCOUNT_SID."/Messages.json",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "Body=".$message."&To=".$phone_number."&From=".$sender,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic ".BASIC_AUTH_KEY,
                    "Content-Type: application/x-www-form-urlencoded"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            
            $i++;
        }
    	header("location: send_message.php?status=1");
    }
    else{
    	header("location: send_message.php?status=0");
    } */
}
else
{
    header("location: send_message.php?status=2");
}