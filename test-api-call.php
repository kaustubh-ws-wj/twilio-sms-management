<?php 


// include 'config.php';

include 'connection.php';

$payload = @file_get_contents('php://input');
$response = json_encode($payload);
$sql = "INSERT INTO conversations (responses) values ('$response')";
mysqli_query($connect, $sql);
http_response_code(200);	




