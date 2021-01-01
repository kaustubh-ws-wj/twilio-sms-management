<?php
	include 'connection.php';
	$query = "DELETE FROM campaign WHERE campaign_id = {$_GET['id']}";

    $ins = mysqli_query($connect, $query);
    if ($ins == 1) {
    	header("Refresh:0; url=view_campaign.php?status=1");
    }
    else{
    	header("Refresh:0; url=view_campaign.php?status=0");
    }
?>