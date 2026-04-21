<?php 
include "includes/db.php"; 
include "includes/header.php";

$error = "";
$success = "";

if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // server-side validation
    if(empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($role)){
        $error = "All fields required!";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    }
    elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    }
    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    }
    else {

        // check email exists
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){
            $error = "Email already registered!";
        } else {

            // hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

            if ($stmt->execute()) {
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<div class="card main-card p-4 w-100">
    <h2 class="text-center"> Register </h2><br>

    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

   <form method="POST">
        <input class="form-control mb-3" name="username" placeholder="Username" required>
        <input class="form-control mb-3" type="email" name="email" placeholder="Email" required>
        <input class="form-control mb-3" type="password" name="password" placeholder="Password" required>
        <input class="form-control mb-3" type="password" name="confirm_password" placeholder="Confirm Password" required>

        <select class="form-control mb-3" name="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="student">Student</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit" class="btn btn-secondary w-100" name="register">Register</button>
    </form>

    <div class="text-center mt-3">
        Already have an account?
        <a href="login.php"> Login here</a>
    </div>
</div>

<script>
// client-side validation
document.querySelector("form").addEventListener("submit", function(e){

    let name = document.querySelector("[name='username']").value.trim();
    let email = document.querySelector("[name='email']").value.trim();
    let pass = document.querySelector("[name='password']").value;
    let confirm = document.querySelector("[name='confirm_password']").value;
    let role = document.querySelector("[name='role']").value;

    if(name === "" || email === "" || pass === "" || confirm === "" || role === ""){
        alert("All fields required!");
        e.preventDefault();
    }

    if(pass.length < 6){
        alert("Password must be at least 6 characters!");
        e.preventDefault();
    }

    if(pass !== confirm){
        alert("Passwords do not match!");
        e.preventDefault();
    }
});
</script>

<?php include "includes/footer.php"; ?>