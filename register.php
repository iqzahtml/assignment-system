<?php 
include "includes/db.php"; 
include "includes/header.php";


$error = "";
$success = "";

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if email already exists
        $check_sql = "SELECT id FROM users WHERE email = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $email);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);
        
        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $error = "Email already registered!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashed_password, $role);
            
            if (mysqli_stmt_execute($stmt)) {
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
        <input class="form-control mb-3" name="username" placeholder="Username" required><br>
        <input class="form-control mb-3" type="email" name="email" placeholder="Email" required><br>
        <input class="form-control mb-3" type="password" name="password" placeholder="Password" required><br>
        <input class="form-control mb-3" type="password" name="confirm_password" placeholder="Confirm Password" required><br>
        <select class="form-control mb-3" name="role" required><br>
            <option value="" disabled selected>Select Role</option>
            <option value="student">Student</option>
            <option value="admin">Admin</option>
        </select><br><br>
        <button type="submit" class="btn btn-secondary w-100" name="register">Register</button>
    </form>
    <div class="text-center mt-3">
        Already have an account?
        <a href="login.php"> Login here</a>
    </div>
</div>
<?php include "includes/footer.php" ?>