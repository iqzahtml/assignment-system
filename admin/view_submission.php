<?php include "../includes/db.php"; ?>
<?php include "../includes/header.php"; ?>

<h3>All Submissions</h3>

<?php
$sql = "SELECT users.name, assignments.title, submissions.file 
        FROM submissions
        JOIN users ON submissions.user_id = users.id
        JOIN assignments ON submissions.assignment_id = assignments.id
        ORDER BY submissions.created_at DESC";

$result = $conn->query($sql);
?>

<div class="card p-3">
<table class="table">
    <tr>
        <th>Student</th>
        <th>Assignment</th>
        <th>File</th>
    </tr>

<?php while($row = $result->fetch_assoc()){ ?>
    <tr>
        <td><?= $row['name']; ?></td>
        <td><?= $row['title']; ?></td>
        <td>
            <a href="../uploads/<?= $row['file']; ?>" class="btn btn-sm btn-success">Download</a>
        </td>
    </tr>
<?php } ?>

</table>
</div>

<?php include "../includes/footer.php"; ?>