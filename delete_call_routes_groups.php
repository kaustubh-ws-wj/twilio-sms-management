<?php
	include 'connection.php';
    $query_d = "Delete FROM call_routes WHERE `call_routes_name` =  '{$_GET['name']}'";
    $ins_d = mysqli_query($connect, $query_d); 
    if($ins_d == 1)
    {
        header("Refresh:0; url=call_routes_listing.php?status=2");
    }
    else{
    	header("Refresh:0; url=call_routes_listing.php?status=0");
    }
    
?>