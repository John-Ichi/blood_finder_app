<?php
include '_functions.php';
$conn = connect();

if (isset($_SESSION['hospital_email'])) {
    header('Location: hospital-db.php');
}

if (isset($_POST['hospital_login'])) {
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

if (isset($_POST['hospital_forgot'])) {
    $forgot_email = isset($_POST['forgot_email']) ? $_POST['forgot_email'] : '';
    $new_password = isset($_POST['forgot_new_password']) ? $_POST['forgot_new_password'] : '';
    $confirm_password = isset($_POST['forgot_confirm_password']) ? $_POST['forgot_confirm_password'] : '';
    if (!filter_var($forgot_email, FILTER_VALIDATE_EMAIL)) {
        $forgot_error = "Please enter a valid email address!";
    } else if ($new_password !== $confirm_password) {
        $forgot_error = "Passwords do not match!";
    } else {
        $check_sql = "SELECT * FROM hospital_login_info WHERE email='$forgot_email'";
        $result = $conn->query($check_sql);
        if ($result->num_rows > 0) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE hospital_login_info SET password='$hashed_password' WHERE email='$forgot_email'";
            if ($conn->query($update_sql) === TRUE) {
                $forgot_success = "Password has been reset successfully! You can now login.";
            } else {
                $forgot_error = "Error resetting password!";
            }
        } else {
            $forgot_error = "Email not found!";
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
        <div class="login-content" id="login-form-section">
            <form method="POST">
                <img src="surgeon-doctor.svg">
                <h2 class="title">Welcome</h2>
                <p class="form-note">Welcome back! Please log in to continue.</p>
                <?php if(isset($login_error)) echo "<p class='error' style='color:red;text-align:center;'>$login_error</p>"; ?>
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
                <a href="#" id="show-forgot">Forgot Password?</a>
                <input type="submit" class="btn" name="hospital_login" value="Login">
                <div style="margin-top:10px;text-align:center;">
                    <a href="hospital-signup.php">Sign Up</a>
                </div>
            </form>
        </div>
        <div class="login-content" id="forgot-form-section" style="display:none;">
            <form method="POST">
                <img src="surgeon-doctor.svg">
                <h2 class="title">Forgot Password</h2>
                <p class="form-note">We'll send you instructions to reset your password.</p>
                <?php if(isset($forgot_error)) echo "<p class='error' style='color:red;text-align:center;'>$forgot_error</p>"; ?>
                <?php if(isset($forgot_success)) echo "<p class='success' style='color:green;text-align:center;'>$forgot_success</p>"; ?>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Email</h5>
                        <input type="email" class="input" name="forgot_email" required>
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i"> 
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>New Password</h5>
                        <input type="password" class="input" name="forgot_new_password" required>
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i"> 
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Confirm Password</h5>
                        <input type="password" class="input" name="forgot_confirm_password" required>
                    </div>
                </div>
                <input type="submit" class="btn" name="hospital_forgot" value="Reset Password">
                <div style="margin-top:10px;text-align:center;">
                    <a href="#" id="back-to-login">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="hospital-login.js"></script>
    <script>
        document.getElementById('show-forgot').onclick = function(e) {
            e.preventDefault();
            document.getElementById('login-form-section').style.display = 'none';
            document.getElementById('forgot-form-section').style.display = 'flex';
        };
        document.getElementById('back-to-login').onclick = function(e) {
            e.preventDefault();
            document.getElementById('forgot-form-section').style.display = 'none';
            document.getElementById('login-form-section').style.display = 'flex';
        };
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>
