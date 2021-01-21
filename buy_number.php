<?php
    include 'config.php';
    include 'connection.php';
    require __DIR__ . '/vendor/autoload.php';
    // Use the REST API Client to make requests to the Twilio REST API
    use Twilio\Rest\Client;
    use Twilio\Exceptions\RestException;
    $twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

    if(isset($_POST) && $_POST['phoneNumber'] != ''){
        // ADd80bb97cfb167b0bc4a168bdf0d1fcc2
        $phone_number = $_POST['phoneNumber'];
        
        /* $curl = curl_init();
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
        curl_close($curl); */

        //
        $incoming_phone_number = $twilio->incomingPhoneNumbers->create(["phoneNumber" => $phone_number]);
        $result = $incoming_phone_number->toArray();
        $response = json_encode($incoming_phone_number->toArray());
        
        if(isset($result['code'])){
            echo json_encode(array('status'=>'error','response'=>json_encode($incoming_phone_number->toArray())));
        }else{
            //Insert to purchased number

            $twilio->messaging->v1->services("MG6cd88d0beeaca544176e383fdd0d90c8")
                                      ->phoneNumbers
                                      ->create($incoming_phone_number->sid);

            $date_created = $incoming_phone_number->dateCreated->format('Y-m-d H:i:s');
            $date_updated = $incoming_phone_number->dateUpdated->format('Y-m-d H:i:s');
            $query = "INSERT INTO purchased_numbers(pn_sid,address_sid,identity_sid,friendly_name,phone_number,region,type,monthly_rental,origin,voice,sms,mms,date_created,date_updated,status,response) 
            VALUES ('{$incoming_phone_number->sid}','{$incoming_phone_number->addressSid}','{$incoming_phone_number->identitySid}','{$incoming_phone_number->friendlyName}','{$incoming_phone_number->phoneNumber}','{$_POST['region']}','{$_POST['type']}','{$_POST['monthly_rental']}','{$incoming_phone_number->origin}','{$incoming_phone_number->capabilities['voice']}','{$incoming_phone_number->capabilities['sms']}','{$incoming_phone_number->capabilities['mms']}','{$date_created}','{$date_updated}','{$incoming_phone_number->status}','{$response}')";
            if(mysqli_query($connect, $query)){
                header("Refresh:0; url=list_all_numbers.php?status=1");
            }else{
                header("Refresh:0; url=list_all_numbers.php?status=0");
            }
        }
    }

    if(isset($_POST) && $_POST['phoneNumbers'] != ''){ 
        $phone_number =  (explode(",",$_POST['phoneNumbers']));
        foreach($phone_number as $phone_number ){
            $incoming_phone_number = $twilio->incomingPhoneNumbers->create(["phoneNumber" => $phone_number]);
            $result = $incoming_phone_number->toArray();
            $response = json_encode($incoming_phone_number->toArray());
            
            if(isset($result['code'])){
                echo json_encode(array('status'=>'error','response'=>json_encode($incoming_phone_number->toArray())));
            }else{
                //Insert to purchased number

                $twilio->messaging->v1->services("MG6cd88d0beeaca544176e383fdd0d90c8")
                                        ->phoneNumbers
                                        ->create($incoming_phone_number->sid);

                $date_created = $incoming_phone_number->dateCreated->format('Y-m-d H:i:s');
                $date_updated = $incoming_phone_number->dateUpdated->format('Y-m-d H:i:s');
                $query = "INSERT INTO purchased_numbers(pn_sid,address_sid,identity_sid,friendly_name,phone_number,region,type,monthly_rental,origin,voice,sms,mms,date_created,date_updated,status,response) 
                VALUES ('{$incoming_phone_number->sid}','{$incoming_phone_number->addressSid}','{$incoming_phone_number->identitySid}','{$incoming_phone_number->friendlyName}','{$incoming_phone_number->phoneNumber}','{$_POST['region']}','{$_POST['type']}','{$_POST['monthly_rental']}','{$incoming_phone_number->origin}','{$incoming_phone_number->capabilities['voice']}','{$incoming_phone_number->capabilities['sms']}','{$incoming_phone_number->capabilities['mms']}','{$date_created}','{$date_updated}','{$incoming_phone_number->status}','{$response}')";
                $result = mysqli_query($connect, $query);
            }
        }
        if($$result){
            header("Refresh:0; url=list_all_numbers.php?status=1");
        }else{
            header("Refresh:0; url=list_all_numbers.php?status=0");
        }
    }
?>