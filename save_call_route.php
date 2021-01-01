<?php
	include 'connection.php';
// 	echo "<pre>";
//  print_r($_POST);
    $folder_id = $_POST['default_folder'];
    $folder_name_query = "SELECT folder_name FROM folder WHERE folder_id = {$folder_id}";
    $folder_name_exe = mysqli_query($connect,$folder_name_query);
    $folder_name_result = mysqli_fetch_all($folder_name_exe,MYSQLI_ASSOC);
    $folder_name = $folder_name_result[0]['folder_name'];
    foreach ($_POST['numbers'] as $number)
    {
        // echo $number; exit;
        $query = "INSERT INTO call_routes(call_routes_name,call_routes_number,call_routes_status,folder_name,folder_id) VALUES ('{$_POST['route_name']}','{$number}','1','{$folder_name}',{$folder_id})";
        $ins = mysqli_query($connect, $query);      
    }
    if ($ins == 1) {
    	header("Refresh:0; url=call_routes_listing.php?status=1");
    }
    else{
    	header("Refresh:0; url=call_routes_groups.php?status=0");
    }
?>