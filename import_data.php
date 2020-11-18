<?php
include 'connection.php';
include 'PHPExcel-1.8/Classes/PHPExcel.php';
include 'config.php';

require __DIR__ . '/vendor/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

$twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

$image = $_FILES['file']['name'];

if(move_uploaded_file($_FILES['file']['tmp_name'],"excel_upload/".$image))
{
    if (isset($_POST) && !empty($_POST)) {
        $file = $_FILES['file']['tmp_name'];
        $inputFileName = "excel_upload/".$image;
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        // $allDataInSheett = unset($allDataInSheet[1]);
        // echo "<pre>";
        // print_r($allDataInSheet);
        $recipients = count($allDataInSheet)-1;
        // exit();

        //INSERT Query for the List contacts
        $sql = "INSERT INTO contact_list(list_name,list_path,recipients,status) VALUES('{$image}','{$inputFileName}','{$recipients}','Active')";
        mysqli_query($connect, $sql);
        $last_id = $connect->insert_id;
        

        if (count($allDataInSheet) > 1) {
            foreach ($allDataInSheet as $key => $value) {
                if($key != 1) {
                    if($value['D'] != ''){
                        //trim with space
                        $phone_number = trim($value['D'],' ');
                        //replace - with the ''
                        $phone_number = str_replace('-','',$phone_number);
                        $phone_wo_no = $phone_number;
                        //adding + sign must have left char
                        $phone_number = '+'.$phone_number;
                        //creatring conversation
                        /* $conversation = $twilio->conversations->v1->conversations->create(["friendlyName" => $phone_number, "uniqueName"=> $phone_wo_no]);
                        $conversations_response = $conversation->toArray();
                        $conversations_json_response = json_encode($conversations_response);
                       
                        if(!isset($conversations_response['code'])){  //on no exceptions
                            $conversation_sid = $conversations_response['sid'];
                            $chat_service_sid = $conversations_response['chatServiceSid'];
                            $messaging_service_sid = $conversations_response['messagingServiceSid'];
                            
                            try{
                                //add participant to conversation api
                                $participant = $twilio->conversations->v1->conversations($conversation_sid)->participants->create(["messagingBindingAddress" => $phone_number,"messagingBindingProxyAddress" => '+18325146419']);
                                $participant_response = $participant->toArray();
                                $participant_json_response = json_encode($participant_response);
                                
                                if(!isset($participant_response['code'])){    //on no exception
                                    $participant_sid = $participant_response['sid'];
                                    $participant_identity = $participant_response['identity']; */
                                    
                                        /* $query = "INSERT INTO numbers(contact_list_id,numbers_first_name,numbers_last_name,numbers_address,numbers_phone_number,numbers_phone_type,numbers_group_id,numbers_status,conversation_sid,chat_service_sid,messaging_service_sid,participant_sid,identity,conversation_response,participant_response) 
                                        VALUES ('{$last_id}','{$value['A']}','{$value['B']}','{$value['C']}','{$phone_number}','{$value['E']}','{$_POST['group']}','1','{$conversation_sid}','{$chat_service_sid}','{$messaging_service_sid}','{$participant_sid}','{$participant_identity}','{$conversations_json_response}','{$participant_json_response}')"; */
                                        
                                        $query = "INSERT INTO numbers(contact_list_id,numbers_first_name,numbers_last_name,numbers_address,numbers_phone_number,numbers_phone_type,numbers_group_id,numbers_status) 
                                        VALUES ('{$last_id}','{$value['A']}','{$value['B']}','{$value['C']}','{$phone_number}','{$value['E']}','{$_POST['group']}','1')";
                                        
                                        if(mysqli_query($connect, $query)){
                                            
                                        }else{
                                            echo 'no';
                                            print_r($q);die;
                                        }
                                /* }else{
                                    echo 'no p';
                                    echo $participant_json_response;die;
                                }
                            }catch(RestException $ex){
                                echo 'Catch';die;
                            }
                        }else{
                            echo $conversations_res;die;
                        } */
                    }   
                }
            }
            
            header("Refresh:0; url=import_contacts.php?status=1");
        }
        else{
            header("Refresh:0; url=import_contacts.php?status=2");
        }
    }
    else{
            header("Refresh:0; url=import_contacts.php?status=0");
    }
}
else
{
 header("Refresh:0; url=import_contacts.php?status=0");
}
?>