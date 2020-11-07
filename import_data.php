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
        // print_r(count($allDataInSheet));
        // exit();
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
                        $curl = curl_init();

                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://conversations.twilio.com/v1/Conversations",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => "FriendlyName=".$phone_wo_no."&UniqueName=".$phone_wo_no,
                            CURLOPT_HTTPHEADER => array(
                                "Authorization: Basic ".BASIC_AUTH_KEY,
                                "Content-Type: application/x-www-form-urlencoded"
                            ),
                        ));

                        $conversations_res = curl_exec($curl);
                        curl_close($curl);
                        $conversations_response = json_decode($conversations_res);

                        if(!isset($conversations_response->code)){  //on no exception
                            $conversation_sid = $conversations_response->sid;
                            $chat_service_sid = $conversations_response->chat_service_sid;
                            $messaging_service_sid = $conversations_response->messaging_service_sid;

                            try{
                                //add participant to conversation api
                                $participant = $twilio->conversations->v1->conversations($conversation_sid)->participants->create(["messagingBindingAddress" => $phone_number,"messagingBindingProxyAddress" => "+14138533247"]);
                                $participant_response = $participant->toArray();
                                $participant_json_response = json_encode($participant_response);
                                 
                                if(!isset($participant_response['code'])){    //on no exception
                                    $participant_sid = $participant_response['sid'];
                                    $participant_identity = $participant_response['identity'];
                                    
                                        $query = "INSERT INTO numbers(numbers_first_name,numbers_last_name,numbers_address,numbers_phone_number,numbers_phone_type,numbers_group_id,numbers_status,conversation_sid,chat_service_sid,messaging_service_sid,participant_sid,identity,conversation_response,participant_response) 
                                        VALUES ('{$value['A']}','{$value['B']}','{$value['C']}','{$phone_number}','{$value['E']}','{$_POST['group']}','1','{$conversation_sid}','{$chat_service_sid}','{$messaging_service_sid}','{$participant_sid}','{$participant_identity}','{$conversations_res}','{$participant_json_response}')";
                                        if($q = mysqli_query($connect, $query)){
                                            
                                        }else{
                                            echo 'no';
                                            print_r($q);die;
                                        }
                                }else{
                                    echo 'no p';
                                    echo $participant_json_response;die;
                                }
                            }catch(RestException $ex){
                                echo 'Catch';die;
                            }
                            
                            
                        }else{
                            echo $conversations_res;die;
                        }
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