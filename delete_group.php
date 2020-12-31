<?php
	include 'connection.php';
	$query = "DELETE FROM add_group WHERE add_group_id = {$_GET['group']}";
    $ins = mysqli_query($connect, $query);
    
    $query_do = "DELETE FROM numbers WHERE numbers_group_id = {$_GET['group']}";
    $ins_do = mysqli_query($connect, $query_do);
    
    if ($ins == 1 && $ins_do == 1) {
    	header("Refresh:0; url=import_contacts.php?status=1");
    }
    else{
    	header("Refresh:0; url=import_contacts.php?status=0");
    }
?>