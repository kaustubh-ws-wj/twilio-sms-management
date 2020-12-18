<?php
	include 'connection.php';
	$query = "DELETE FROM contact_list WHERE id = {$_GET['id']}";

    $ins = mysqli_query($connect, $query);
    if ($ins == 1) {
    	header("Refresh:0; url=view_contacts.php?status=1");
    }
    else{
    	header("Refresh:0; url=view_contacts.php?status=0");
    }
?>