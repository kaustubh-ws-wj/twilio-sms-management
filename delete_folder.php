<?php
	include 'connection.php';
	$query = "DELETE FROM folder WHERE folder_id = {$_GET['fid']}";
    $ins = mysqli_query($connect, $query);
    
    if ($ins == 1) {
    	header("Refresh:0; url=add_folder.php?status=3");
    }
    else{
    	header("Refresh:0; url=add_folder.php?status=0");
    }
?>