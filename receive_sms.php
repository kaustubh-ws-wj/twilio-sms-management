<?php
require 'vendor/autoload.php';

$from_number = $_REQUEST["From"];
$to_number = $_REQUEST["To"];
$text = $_REQUEST["Text"];

echo("Message received - From $from_number, To: $to_number, Text: $text");