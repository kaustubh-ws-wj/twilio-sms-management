<?php
    include 'config.php';
    if(isset($_POST) && $_POST['PhoneNumber'] != ''){
        $curl = curl_init();
        $phone_number = $_POST['PhoneNumber'];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/".ACCOUNT_SID."/IncomingPhoneNumbers.json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "PhoneNumber=".$phone_number,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ".BASIC_AUTH_KEY,
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response);
        if(isset($result->code)){
            echo json_encode(array('status'=>'error','response'=>$response));
        }else{
            //Insert to purchased number
            $query = "INSERT INTO purchased_numbers(pn_sid,address_sid,identity_sid,friendly_name,phone_number,region,type,monthly_rental,origin,voice,sms,mms,fax,date_created,date_updated,status,response) 
            VALUES ('{$result->sid}','{$result->address_sid}','{$result->identity_sid}','{$result->friendly_name}','{$result->phone_number}','{$_POST['region']}','{$_POST['type']}','{$_POST['monthly_rental']}','{$result->origin}','{$result->capabilities->voice}','{$result->capabilities->sms}','{$result->capabilities->mms}','{$result->capabilities->fax}','{$result->date_created}','{$result->date_update}','{$result->status}','{$response}')";
            if(mysqli_query($connect, $query)){
                header("Refresh:0; url=list_all_numbers.php?status=1");
            }else{
                header("Refresh:0; url=list_all_numbers.php?status=0");
            }
        }
    }
?>