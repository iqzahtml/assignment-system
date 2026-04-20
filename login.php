<?php include "includes/db.php"; ?>

<?php
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass = $_POST['password'];

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

        } else {
            echo "Wrong password";
        }
    } else {
        echo "User not found";
    }
}
?>

<form method="POST">
<input type="email" name="email" placeholder="Email"><br>
<input type="password" name="password" placeholder="Password"><br>
<button name="login">Login</button>
</form>