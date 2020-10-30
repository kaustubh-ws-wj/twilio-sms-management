<?php
	include 'connection.php';
// 	echo "<pre>";
//     print_r($_POST);
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
?>