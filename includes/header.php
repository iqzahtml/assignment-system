<?php
// check login
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assignment System</title>
</head>
<body>

<a href="../logout.php">Logout</a>
<hr>