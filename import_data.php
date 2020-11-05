<?php
include 'connection.php';
include 'PHPExcel-1.8/Classes/PHPExcel.php';

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
                            CURLOPT_POSTFIELDS => "friendlyName=".$phone_wo_no."&uniqueName=".$phone_wo_no,
                            CURLOPT_HTTPHEADER => array(
                                "Authorization: Basic ".BASIC_AUTH_KEY,
                                "Content-Type: application/x-www-form-urlencoded"
                            ),
                        ));

                        $conversations_response = curl_exec($curl);
                        curl_close($curl);
                        
                        //add participant to conversation api
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://conversations.twilio.com/v1/Conversations/".$created_conversation->sid."/Participants",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => "messagingBindingAddress=".$phone_number."&messagingBindingProxyAddress=+14138533247",
                            CURLOPT_HTTPHEADER => array(
                                "Authorization: Basic ".BASIC_AUTH_KEY,
                                "Content-Type: application/x-www-form-urlencoded"
                            ),
                        ));
                        $participat_response = curl_exec($curl);
                        curl_close($curl);

                        $query = "INSERT INTO numbers(numbers_first_name,numbers_last_name,numbers_address,numbers_phone_number,numbers_phone_type,numbers_group_id,numbers_status,conversation_sid,participant_sid,conversation_response,participant_reponse) VALUES ('{$value['A']}','{$value['B']}','{$value['C']}','{$phone_number}','{$value['E']}','{$_POST['group']}','1')";
                        
                    }   
                    mysqli_query($connect, $query);
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