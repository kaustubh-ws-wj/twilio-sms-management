<?php
	include 'connection.php';
	
    $query_d = "Delete FROM call_routes WHERE `call_routes_name` =  '{$_POST['route_name']}'";
    $ins_d = mysqli_query($connect, $query_d); 
    // echo "<pre>";
    // print_r($ins_d);
    // exit();
    if($ins_d == 1)
    {
        foreach ($_POST['numbers'] as $number)
        {
            // echo $number; exit;
            $query = "INSERT INTO call_routes(call_routes_name,call_routes_number,call_routes_status) VALUES ('{$_POST['route_name']}','{$number}','1')";
            $ins = mysqli_query($connect, $query);      
        }
        if ($ins == 1) {
        	header("Refresh:0; url=call_routes_listing.php?status=1");
        }
        else{
        	header("Refresh:0; url=call_routes_groups.php?status=0");
        }    
    }
    else{
    	header("Refresh:0; url=call_routes_listing.php?status=0");
    }
    
?>