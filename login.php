<?php 
session_start();
include "includes/db.php"; 
include "includes/header.php"; 

$error="";

if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    // server-side validation
    if(empty($email) || empty($pass)){
        $error = "All fields required!";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Invalid email format!";
    }
    else{

        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($row = $result->fetch_assoc()){
            if(password_verify($pass, $row['password'])){
                
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = $row['role'];

                // redirect ikut role
                if($row['role'] == 'admin'){
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: student/dashboard.php");
                }
                exit();

            } else {
                $error = "Wrong password";
            }
        } else {
            $error = "User not found";
        }
    }
}
?>

<div class="card main-card p-4 w-100">
    <h2 class="text-center">Login</h2>

    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <input class="form-control mb-3" type="email" name="email" placeholder="Email" required>
        <input class="form-control mb-3" type="password" name="password" placeholder="Password" required>

        <button class="btn btn-secondary w-100" name="login">Login</button>

        <div class="text-center mt-2">
            Don't have an account?
            <a href="register.php"> Register here</a>
        </div>
    </form>
</div>

<script>
// client-side validation
document.querySelector("form").addEventListener("submit", function(e){

    let email = document.querySelector("[name='email']").value.trim();
    let pass = document.querySelector("[name='password']").value;

    if(email === "" || pass === ""){
        alert("Please fill all fields");
        e.preventDefault();
    }
});
</script>

<?php include "includes/footer.php"; ?>