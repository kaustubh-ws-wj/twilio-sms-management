<?php
include 'config.php';
include 'connection.php';
require 'vendor/autoload.php';
include 'connection.php';
// echo "<pre>";
// print_r($_POST);
// exit;
if(isset($_POST) && !empty($_POST) && isset($_POST['call_routes_id']) && !empty($_POST['call_routes_id']))
{
    $message = $_POST['message'];
    $query_test = "SELECT * FROM numbers where numbers_group_id = {$_POST['group']}";
    $result_test = mysqli_query($connect, $query_test);
    $total_rows_test = mysqli_num_rows($result_test);
    if (count($_POST['call_routes_id']) > 0 && $total_rows_test > 0) {
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
    }
}
else
{
    // header("location: send_message.php?status=2");
}