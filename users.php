<?php
$con = new mysqli('localhost', 'root', '', 'user_auth');
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_POST['signup'])) {
    $email = $_POST['username_email']; 
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $signup_error = "Please enter a valid email address!";
    } elseif ($password !== $confirm_password) {
        $signup_error = "Passwords do not match!";
    } else {
        $check_sql = "SELECT * FROM users WHERE email='$email'";
        $result = $con->query($check_sql);
        
        if ($result->num_rows > 0) {
            $signup_error = "Email already exists!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO users (email, password, is_active) 
                    VALUES ('$email', '$hashed_password', 1)";
            
            if ($con->query($sql) === TRUE) {
                $signup_success = "Account created successfully!";
            } else {
                $signup_error = "Error creating account!";
            }
        }
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['username_email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND is_active=1";
    $result = $con->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $update_sql = "UPDATE users SET last_login=NOW() WHERE id=".$user['id'];
            $con->query($update_sql);
            
            $login_success = "Login successful! Welcome " . explode('@', $email)[0];
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
    <title>User Authentication</title>
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
    <h1>User Authentication</h1>
    
    <div class="form-container">
        <h2>Sign Up</h2>
        <?php if (isset($signup_error)) echo "<p class='error'>$signup_error</p>"; ?>
        <?php if (isset($signup_success)) echo "<p class='success'>$signup_success</p>"; ?>
        
        <form action="" method="POST">
            Email: <br><input type="email" name="username_email" required><br>
            Password: <br><input type="password" name="password" required><br>
            Confirm Password: <input type="password" name="confirm_password" required><br>
            <button type="submit" name="signup">Sign Up</button>
        </form>
    </div>
    
    <div class="form-container">
        <h2>Login</h2>
        <?php if (isset($login_error)) echo "<p class='error'>$login_error</p>"; ?>
        <?php if (isset($login_success)) echo "<p class='success'>$login_success</p>"; ?>
        
        <form action="" method="POST">
            Email: <br><input type="email" name="username_email" required><br>
            Password: <br><input type="password" name="password" required><br>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
    
    <div class="clear"></div>
</body>
</html>

