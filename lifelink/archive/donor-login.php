<?php
include '_functions.php';
$conn = connect();

if(isset($_SESSION['donor_email'])) { // check if naka login ang donor
    header('Location: donor-db.php');
}

if(isset($_SESSION['hospital_email'])) { // check if naka login ang hospital
    header('Location: hospital-db.php');
}

if(isset($_POST['donor_login'])) {
    $sql = "SELECT * FROM donor_login_info WHERE email='$_POST[donor_email]' AND is_active=1";
    $result = $conn->query($sql);
            
    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if(password_verify($_POST['password'], $user['password'])) {
        $conn->query("UPDATE donor_login_info SET last_login=NOW() WHERE email='$user[email]'");
        $_SESSION['donor_email'] = $user['email'];
                        
        header('Location: donor-db.php');
        }
        else {
        $login_error = "Invalid password!";
        }
    }
    else {
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
        <h2>Login</h2>
        <?php if (isset($login_error)) echo "<p class='error'>$login_error</p>"; ?>
        <form action="" method="POST">
            Email: <br><input type="email" name="donor_email" required><br>
            Password: <br><input type="password" name="password" required><br>
            <button type="submit" name="donor_login">Login</button>
        </form>
        <a href="donor-signup.php">Sign Up</a><br>
        <a href="hospital-login.php">Log in as hospital</a><br>
        <a href="home.php">Return to home</a>
    </div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>