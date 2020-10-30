<?php
	include 'connection.php';
	
    $query_d = "UPDATE `folder` SET `folder_name` = '{$_POST['folder_name']}' WHERE `folder_id` = {$_POST['folder_id']}";
    $ins_d = mysqli_query($connect, $query_d);
    if ($ins_d == 1) {
    	header("Refresh:0; url=add_folder.php?status=4");
    }
    else{
    	header("Refresh:0; url=add_folder.php?status=0");
    }   
    
?>