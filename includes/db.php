<?php
// connect database
$conn = new mysqli("localhost", "root", "", "assignment_system");

// check connection
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// start session
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>