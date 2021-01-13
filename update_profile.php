<?php
    session_start(); 
    include 'connection.php';
    $user_id = $_SESSION['user_id'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $notification_email = $_POST['notification_email'];
	$phone_number = $_POST['phone_number'];
	$default_folder = $_POST['default_folder'];
	$phone_number = $_POST['phone_number'];
	$is_send = ($_POST['is_send'] == 'on') ? 1:0;
    $querys = "UPDATE `signup` SET
    `first_name`='{$first_name}',`last_name`='{$last_name}',`email`='{$email}',`notification_email`='{$notification_email}',`phone_number`='{$phone_number}',`default_folder`='{$default_folder}',`is_send`={$is_send} WHERE id = {$user_id}";
// echo $querys;die;
    $results = mysqli_query($connect,$querys);
    $_SESSION["message"] = "success";
    header("location: user_profile.php");
?>