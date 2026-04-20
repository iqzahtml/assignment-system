<?php include "../includes/db.php"; ?>
<?php include "../includes/header.php"; ?>

<h2>Student Dashboard</h2>

<input type="text" id="search" placeholder="Search assignment">

<div id="result"></div>

<script>
// ajax search
document.getElementById("search").addEventListener("keyup", function(){
    let keyword = this.value;

    fetch("search.php?key=" + keyword)
    .then(res => res.text())
    .then(data => {
        document.getElementById("result").innerHTML = data;
    });
});
</script>

<a href="submit_assignment.php">Submit Assignment</a>
<a href="my_submissions.php">My Submissions</a>

<?php include "../includes/footer.php"; ?>