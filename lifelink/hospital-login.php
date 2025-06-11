<?php
include '_functions.php';
$conn = connect();

if (isset($_SESSION['hospital_email'])) { // Check if logged in
    header('Location: hospital-db.php');
}

if (isset($_POST['hospital_login'])) { // Login
    $email = $_POST['hospital_email'];
    $password = $_POST['password'];
        
    $sql = "SELECT * FROM hospital_login_info WHERE email='$email' AND is_active=1";
    $result = $conn->query($sql);
            
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $update_sql = "UPDATE donor_login_info SET last_login=NOW() WHERE email='$user[email]'";
            $conn->query($update_sql);
            $_SESSION['login'] = true;
            $_SESSION['hospital_email'] = $user['email'];
            header('Location: hospital-db.php');
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
    <title>LifeLink</title>
    <link rel="icon" href="resources/heartbeat-solid.svg">
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
        <h2>LifeLink</h2>
        <?php if(isset($login_error)) echo "<p class='error'>$login_error</p>"; ?>
        <form method="POST">
            Email: <br><input type="email" name="hospital_email" required><br>
            Password: <br><input type="password" name="password" required><br>
            <button type="submit" name="hospital_login">Login</button>
        </form>
        <a href="hospital-signup.php">Sign Up</a><br>
    </div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>