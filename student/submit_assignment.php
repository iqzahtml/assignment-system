<?php include "../includes/db.php"; ?>
<?php include "../includes/header.php"; ?>

<?php
$message = "";

// submit form
if(isset($_POST['submit'])){
    $assignment_id = $_POST['assignment_id'];

    // file info
    $file = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];

    // allowed file type
    $allowed = ['pdf','docx','txt'];
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    // validation
    if(empty($file)){
        $message = "<div class='alert alert-danger'>Select a file</div>";
    }
    elseif(!in_array($ext, $allowed)){
        $message = "<div class='alert alert-danger'>Invalid file type</div>";
    }
    elseif($size > 2000000){ // 2MB limit
        $message = "<div class='alert alert-danger'>File too large</div>";
    }
    else{
        $newname = time() . "_" . $file; // avoid duplicate
        $target = "../uploads/" . $newname;

        // move file
        if(move_uploaded_file($tmp, $target)){

            $stmt = $conn->prepare("INSERT INTO submissions (user_id, assignment_id, file) VALUES (?,?,?)");
            $stmt->bind_param("iis", $_SESSION['user_id'], $assignment_id, $newname);
            $stmt->execute();

            $message = "<div class='alert alert-success'>Submitted successfully</div>";
        }
    }
}

// get assignments
$res = $conn->query("SELECT * FROM assignments");
?>

<div class="card main-card p-4 w-100">
    <h3>Submit Assignment</h3>

    <?php echo $message; ?>

    <form method="POST" enctype="multipart/form-data">
        
        <select class="form-control mb-3" name="assignment_id">
            <?php while($row = $res->fetch_assoc()){ ?>
                <option value="<?= $row['id']; ?>">
                    <?= $row['title']; ?>
                </option>
            <?php } ?>
        </select>

        <input class="form-control mb-3" type="file" name="file">

        <button class="btn btn-secondary w-100" name="submit">Submit</button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>