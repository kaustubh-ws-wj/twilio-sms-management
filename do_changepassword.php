<?php
    session_start(); 
    include 'connection.php';
    $current_password = $_POST['current_password'];
	$new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['user_id'];
    $querys = "SELECT password FROM signup WHERE id ='{$user_id}'";
// echo $querys;die;
    $results = mysqli_query($connect,$querys);
    if (mysqli_num_rows($results) > 0)   {
        $row = mysqli_fetch_assoc($results);
        if($row['password'] == $current_password){
            if($new_password == $confirm_password){
                $querys_update = "UPDATE `signup` SET
                `password`='{$new_password}' WHERE id='{$user_id}'";
                // echo $querys_update;
                $result_updates = mysqli_query($connect,$querys_update);
                if (mysqli_affected_rows($connect) > 0) {
                    $_SESSION["message"] = "success";
                    header("location: change_password.php");
                }
            }else{
                $_SESSION["message"] = "errornotmatchcnf";
                header("location: change_password.php");
            }
        }else{
            $_SESSION["message"] = "errornotmatch";
            header("location: change_password.php");
        }
    }
?>