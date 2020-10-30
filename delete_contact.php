<?php
	include 'connection.php';
	$query = "DELETE FROM numbers WHERE numbers_id = {$_GET['number']}";
// 	print_r($_GET);
// 	exit();
    $ins = mysqli_query($connect, $query);
    if ($ins == 1) {
    	header("Refresh:0; url=view_contacts.php?status=1&group={$_GET['group']}");
    }
    else{
    	header("Refresh:0; url=view_contacts.php?status=0&group={$_GET['group']}");
    }
?>