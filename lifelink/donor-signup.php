<?php
include '_functions.php';

session_start();
$conn = connect();

if(isset($_SESSION['donor_email'])) {
    header('Location: donor-db.php');
}

if(isset($_SESSION['hospital_email'])) {
    header('Location: hospital-db.php');
}

if(isset($_POST['signup'])) {
    $email = $_POST['username_email']; 
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $signup_error = "Please enter a valid email address!";
    } elseif($password !== $confirm_password) {
        $signup_error = "Passwords do not match!";
    } else {
        $check_sql = "SELECT * FROM donor_login_info WHERE email='$email'";
        $result = $conn->query($check_sql);
                    
        if($result->num_rows > 0) {
            $signup_error = "Email already exists!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            
            $sql = "INSERT INTO donor_login_info (email, password, is_active) 
            VALUES ('$email', '$hashed_password', 1)";
                            
            if($conn->query($sql) === TRUE) {
                $_SESSION['donor_email'] = $email;
                header('Location: donor-signup.php');
            } else {
                echo "
                <script>
                btn = document.getElementById('btn');
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                });
                </script>";
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
    <title>Sign Up</title>
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
        <h2>Sign Up</h2>
        <?php if (isset($signup_error)) echo "<p class='error'>$signup_error</p>"; ?>
        
        <form method="POST">
            Email: <br><input type="email" name="username_email" required id="email"><br>
            Password: <br><input type="password" name="password" required id="pass"><br>
            Confirm Password: <br><input type="password" name="confirm_password" required id="confirm"><br>
            <button type="submit" name="signup" id="btn">Sign Up</button>
        </form>
        <a href="donor-login.php">Login</a>
        
    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <script>
        btn = document.getElementById('btn');
        btn.addEventListener('click', function(e) {
            
            pass = document.getElementById('pass').value;
            conf = document.getElementById('confirm').value;

            if(pass != conf) {
                alert('');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>