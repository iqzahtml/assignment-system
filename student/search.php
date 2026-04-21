<?php include "../includes/db.php"; ?>

$key = $_GET['key'] ?? "";

// prepared statement for security
$sql = "SELECT * FROM assignments WHERE title LIKE ?";
$stmt = $conn->prepare($sql);

$search = "%$key%";
$stmt->bind_param("s", $search);
$stmt->execute();

$result = $stmt->get_result();

while($row = $result->fetch_assoc()){
    echo $row['title'] . "<br>";
}