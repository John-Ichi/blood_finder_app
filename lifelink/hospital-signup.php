<?php
include '_functions.php';
$conn = connect();

if (isset($_SESSION['hospital_email'])) { // Check if logged in
    header('Location: hospital-db.php');
}

if (isset($_POST['hospital_signup'])) {
    $email = $_POST['hospital_email']; 
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $signup_error = "Please enter a valid email address!";
    } else if ($password !== $confirm_password) {
        $signup_error = "Passwords do not match!";
    } else {
        $check_sql = "SELECT * FROM hospital_login_info WHERE email='$email'";
        $result = $conn->query($check_sql);
                    
        if ($result->num_rows > 0) {
            $signup_error = "Email already exists!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            
            $sql = "INSERT INTO hospital_login_info (email, password, is_active) 
            VALUES ('$email', '$hashed_password', 1)";
                            
            if ($conn->query($sql) === TRUE) {
                $signup_success = "Account created successfully!";
            } else {
                $signup_error = "Error creating account!";
            }
        }
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
    <link rel="stylesheet" type="text/css" href="hospital-login.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
</head>
<body>
    <div class="lifelink-header">
        <img src="resources/heartbeat-solid.svg" alt="LifeLink Logo" class="lifelink-logo">
        <span class="lifelink-title">LifeLink</span>
    </div>
    <img class="wave" src="wave.svg">
    <div class="container">
        <div class="img">
            <img src="logo.svg">
        </div>
        <div class="login-content signup-content">
            <form method="POST">
                <img src="surgeon-doctor.svg">
                <h2 class="title">Sign Up</h2>
                <p class="form-note">Create your hospital account and join the LifeLink network.</p>
                <?php if(isset($signup_error)) echo "<p class='error' style='color:red;text-align:center;'>$signup_error</p>"; ?>
                <?php if(isset($signup_success)) echo "<p class='success' style='color:green;text-align:center;'>$signup_success</p>"; ?>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Email</h5>
                        <input type="email" class="input" name="hospital_email" required>
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i"> 
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Password</h5>
                        <input type="password" class="input" name="password" required>
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i"> 
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Confirm Password</h5>
                        <input type="password" class="input" name="confirm_password" required>
                    </div>
                </div>
                <input type="submit" class="btn" name="hospital_signup" value="Sign Up">
                <div style="margin-top:10px;text-align:center;">
                    <a href="hospital-login.php">Login</a>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="hospital-login.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>