<?php include "../includes/db.php"; ?>
<?php include "../includes/header.php"; ?>

<?php
$message = "";

if(isset($_POST['submit'])){
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);

    // server-side validation
    if(empty($title) || empty($desc)){
        $message = "<div class='alert alert-danger'>All fields required</div>";
    }
    elseif(strlen($title) < 3){
        $message = "<div class='alert alert-danger'>Title too short</div>";
    }
    else{
        $stmt = $conn->prepare("INSERT INTO assignments (title, description) VALUES (?,?)");
        $stmt->bind_param("ss", $title, $desc);

        if($stmt->execute()){
            $message = "<div class='alert alert-success'>Assignment created successfully</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error creating assignment</div>";
        }
    }
}
?>

<div class="card main-card p-4 w-100">
    <h3>Create Assignment</h3>

    <?php echo $message; ?>

    <form method="POST">
        <input class="form-control mb-3" type="text" name="title" placeholder="Title">
        <textarea class="form-control mb-3" name="description" placeholder="Description"></textarea>
        <button class="btn btn-secondary w-100" name="submit">Create</button>
    </form>
</div>

<script>
// client-side validation
document.querySelector("form").addEventListener("submit", function(e){
    let title = document.querySelector("[name='title']").value.trim();
    let desc = document.querySelector("[name='description']").value.trim();

    if(title === "" || desc === ""){
        alert("All fields required");
        e.preventDefault();
    }

    if(title.length < 3){
        alert("Title too short");
        e.preventDefault();
    }
});
</script>

<?php include "../includes/footer.php"; ?>