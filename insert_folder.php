<?php
	include 'connection.php';
	$query = "INSERT INTO folder(folder_name,folder_status) VALUES ('{$_POST['folder_name']}','1')";
    $ins = mysqli_query($connect, $query);
    if ($ins == 1) {
    	header("Refresh:0; url=add_folder.php?status=1");
    }
    else{
    	header("Refresh:0; url=add_folder.php?status=0");
    }
?>