<?php

 //define parameters
$host = '##############';;
$login = '##############';
$password = '##############';
$database = '##############';;
 //Connect to the mysql server
$conn = @new mysqli($host, $login, $password, $database);
 //handle connection errors
if ($conn->connect_errno != 0) {
    $errno = $conn->connect_errno;
    $errmsg = $conn->connect_error;
    die ("Connection failed with: ($errno) $errmsg.");
} 

$options = [
    'cost' => 10,
];
