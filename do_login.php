<?php
    session_start(); 
	// echo "<pre>";
	// print_r($_POST);
    include 'connection.php';
	$password = $_POST['password'];
	$user_name = $_POST['user_name'];

	$querys="SELECT * FROM signup where user_name = '{$user_name}' AND password = '{$password}'";
    // print_r($querys);
    $results = mysqli_query($connect,$querys);
    // print_r($results['num_rows']);
    if (mysqli_num_rows($results) > 0) {
    	while($row=mysqli_fetch_assoc($results)) {
		    $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['first_name'] = $row['first_name'];
		    $_SESSION['last_name'] = $row['last_name'];
		}
        header("location: dashboard.php");
    }
    else{
        header("Refresh:0; url=index.php?status=0");
    }
?>