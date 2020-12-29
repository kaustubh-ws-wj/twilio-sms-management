<?php
	include 'connection.php';
	$query = "INSERT INTO add_group(add_group_name,add_group_status) VALUES ('{$_POST['group_name']}','1')";
    $ins = mysqli_query($connect, $query);
    if ($ins == 1) {
    	header("Refresh:0; url=import_contacts.php?status=1");
    }
    else{
    	header("Refresh:0; url=import_contacts.php?status=0");
    }
?>