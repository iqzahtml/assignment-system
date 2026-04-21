<?php include "../includes/db.php"; ?>
<?php include "../includes/header.php"; ?>

<?php
$message = "";

if(isset($_POST['submit'])){
    $assignment_id = $_POST['assignment_id'];

    // check file
    if(!isset($_FILES['file']) || $_FILES['file']['error'] == 4){
        $message = "<div class='alert alert-danger'>Please select a file</div>";
    } else {

        $file = $_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
        $size = $_FILES['file']['size'];

        $allowed = ['pdf','docx','txt'];
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if(!in_array($ext, $allowed)){
            $message = "<div class='alert alert-danger'>Invalid file type</div>";
        }
        elseif($size > 2000000){
            $message = "<div class='alert alert-danger'>File too large (Max 2MB)</div>";
        }
        else{
            $newname = time() . "_" . $file;
            $target = "../uploads/" . $newname;

            if(move_uploaded_file($tmp, $target)){
                $stmt = $conn->prepare("INSERT INTO submissions (user_id,assignment_id,file) VALUES (?,?,?)");
                $stmt->bind_param("iis", $_SESSION['user_id'], $assignment_id, $newname);
                $stmt->execute();

                $message = "<div class='alert alert-success'>Submitted successfully</div>";
            }
        }
    }
}

// get assignment list
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

<script>
// client-side validation
document.querySelector("form").addEventListener("submit", function(e){
    let file = document.querySelector("[name='file']").value;

    if(file === ""){
        alert("Please select a file");
        e.preventDefault();
    }
});
</script>

<?php include "../includes/footer.php"; ?>