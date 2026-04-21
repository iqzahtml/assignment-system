<?php include "../includes/db.php"; ?>
<?php include "../includes/header.php"; ?>

<h3>My Submissions</h3>

<?php
$user_id = $_SESSION['user_id'];

$sql = "SELECT assignments.title, submissions.file, submissions.created_at
        FROM submissions
        JOIN assignments ON submissions.assignment_id = assignments.id
        WHERE submissions.user_id = ?
        ORDER BY submissions.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="card p-3">
<table class="table">
    <tr>
        <th>Assignment</th>
        <th>File</th>
        <th>Date</th>
    </tr>

<?php while($row = $result->fetch_assoc()){ ?>
    <tr>
        <td><?= $row['title']; ?></td>
        <td><?= $row['file']; ?></td>
        <td><?= $row['created_at']; ?></td>
    </tr>
<?php } ?>

</table>
</div>

<?php include "../includes/footer.php"; ?>