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
    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    }
    elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    }
    else {
        // check email
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s",$email);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){
            $error = "Email already exists!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss",$username,$email,$hashed,$role);

            if($stmt->execute()){
                $success = "Register successful!";
            } else {
                $error = "Something went wrong!";
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