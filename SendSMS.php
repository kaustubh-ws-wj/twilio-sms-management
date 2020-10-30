<?php
include 'connection.php';
require 'vendor/autoload.php';
use Plivo\RestClient;
$client = new RestClient("MAOGFLMJLKNGM0ODZMYJ", "MGQ2ZTg5ZWM5YzU5MDY3MjNiZjY0Y2EwMGFiY2M2");

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
        $abc = serialize($_POST[call_routes_id]);
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
    	    $phone_number = '+1';
    		$phone_number .= str_replace("-", "", $roww['numbers_phone_number']);
    		
    		$sender = "+".$_POST['call_routes_id'][$i];
    		
    // 		echo "<pre>";
    //         print_r($sender);
            
    // 		echo "<pre>";
    //         print_r($phone_number);
            
    //         echo "<pre>";
    //         print_r($message);
            
            // exit;
    		$message_created = $client->messages->create(
    		    $sender,
    		    [$phone_number],
    		    $message
    		);
    		print_r($message_created);
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