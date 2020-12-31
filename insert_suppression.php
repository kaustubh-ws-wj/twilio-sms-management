<?php
	include 'connection.php';
	$query = "INSERT INTO suppression(suppression) VALUES ('{$_POST['suppression_numbers']}')";
    $ins = mysqli_query($connect, $query);
    if ($ins == 1) {
    	header("Refresh:0; url=add_suppression.php?status=1");
    }
    else{
    	header("Refresh:0; url=add_suppression.php?status=0");
    }
?>