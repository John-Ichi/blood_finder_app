<?php
include 'functions.php';

session_start();
$conn = connect();

if(isset($_SESSION['email'])) {
header('Location: dashboard.php');
}

if(isset($_POST['login'])) {
    $email = $_POST['username_email'];
    $password = $_POST['password'];
        
    $sql = "SELECT * FROM donor_login_info WHERE email='$email' AND is_active=1";
    $result = $conn->query($sql);
            
    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])) {
        $update_sql = "UPDATE donor_login_info SET last_login=NOW() WHERE email='$user[email]'";
        $conn->query($update_sql);
        $_SESSION['login'] = true;
        $_SESSION['email'] = $user['email'];
                        
        header('Location: dashboard.php');
        } else {
        $login_error = "Invalid password!";
        }
    } else {
        $login_error = "User not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .form-container {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            width: 300px;
            float: left;
        }
        .error { color: red; }
        .success { color: green; }
        .clear { clear: both; }
    </style>
</head>
<body>
    <h1>LifeLink</h1>

    <div class="form-container">
        <h2>Login</h2>
        <?php if (isset($login_error)) echo "<p class='error'>$login_error</p>"; ?>
        <?php if (isset($login_success)) echo "<p class='success'>$login_success</p>"; ?>
        
        <form action="" method="POST">
            Email: <br><input type="email" name="username_email" required><br>
            Password: <br><input type="password" name="password" required><br>
            <button type="submit" name="login">Login</button>
        </form>
        <a href="signup.php">Sign Up</a>
    </div>
    
    <div class="clear"></div>
    
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>