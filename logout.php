<?php
session_start();
// unset($_SESSION['activeha']);
session_destroy();

header('location: index.php');

?>