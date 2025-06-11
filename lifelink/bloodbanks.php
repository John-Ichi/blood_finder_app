<?php
include '_functions.php';
$conn = connect();

getBloodBankInfoJSON();

if (isset($_SESSION['donor_email']) && $_SESSION['donor_email'] != '') {
    header('Location: donor-db.php');
}

// Login
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
        echo "<script>alert('The password you have entered is incorrect. Please try again.')</script>";
        }
    }
    else {
        echo "<script>alert('User not found!')</script>";
    }
}

// Signup
if(isset($_POST['signup'])) {
    $email = $_POST['username_email']; 
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address!')</script>";
    } else
    if($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!')</script>";
    } else { 
        $check_sql = "SELECT * FROM donor_login_info WHERE email='$email'";
        $result = $conn->query($check_sql);
                        
        if($result->num_rows > 0) {
            echo "<script>alert('Email already exists!')</script>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                                
            $sql = "INSERT INTO donor_login_info (email, password, is_active) 
            VALUES ('$email', '$hashed_password', 1)";
                                
            if($conn->query($sql) === TRUE) {
                $_SESSION['donor_email'] = $email;
                echo "<script>alert('Account created successfully!')</script>";
                header('Location: donor-db.php');
            } else {
                echo "<script>alert('Error creating account.')</script>";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="bloodbanks.css">
    <link rel="icon" href="resources/heartbeat-solid.svg">
</head>
<body>
    <header class="header">
        <a href="#" class="logo">
            <i class="fas fa-heartbeat"></i>
            <span>LifeLink</span>
        </a>
        <div class="nav-links">
            <a href="donors.php">Donors</a>
            <a href="bloodbanks.php">Blood Banks</a>
        </div>
        <div class="ham-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="off-screen-menu">
            <ul>
                <li>Home</li>
                <li>Login</li>
                <li>About Us</li>
                <li>Contact</li>
            </ul>
        </div>
    </header>
    
    <div class="container">
        <div class="search-container">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search blood bank by name or location...">
                <button class="filter-btn" id="clearBtn"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
        
        <div class="card-grid" id="cardGrid">
        </div>
    </div>

            <!-- Login Section -->
            <section id="donor">

                <div class="blur-bg-overlay"></div>

                <div class="form-popup">
                    <span class="close-btn">&#10006</span>

                    <div class="form-box login">
                        <div class="form-details">
                            <h2>You're Back!</h2>
                            <p>Welcome back, and thank you for continuing to be a vital part of our blood donation community!</p>
                        </div>
                        <div class="form-content">
                            <h2>LOGIN</h2>

                            <form method="POST">
                                <div class="input-field">
                                    <input type="email" name="donor_email" required>
                                    <label>Email</label>
                                </div>
                                <div class="input-field">
                                    <input type="password" name="password" required>
                                    <label>Password</label>
                                </div>
                                <a href="#" class="forgot-password" id="forgot-password-link">Forgot password?</a>
                                <button name="donor_login" type="submit">Login</button>
                            </form>

                            <div class="bottom-link">
                                Don't have an account?
                                <a href="#">Signup</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-box signup">

                        <div class="form-details">
                            <h2>Create Account</h2>
                            <p>Welcome! Your decision to join can help save lives—thank you for being here.</p>
                        </div>

                        <div class="form-content">
                            <h2>SIGNUP</h2>
                            <form method="POST" id="signup">
                                <div class="input-field">
                                    <input type="email" name="username_email" required>
                                    <label>Enter your email</label>
                                </div>
                                <div class="input-field">
                                    <input type="password" name="password" id="password" required>
                                    <label>Create password</label>
                                </div>
                                <div class="input-field">
                                    <input type="password" name="confirm_password" id="confirm_password" required>
                                    <label>Confirm password</label>
                                </div>
                                <div class="policy-text">
                                    <input type="checkbox" id="policy" required>
                                    <label for="policy">
                                        I agree to the
                                        <a href="#">Terms & Conditions</a>
                                    </label>
                                </div>
                                <button name="signup" type="submit">Signup</button>
                            </form>
                            <div class="bottom-link">
                                Already have an account?
                                <a href="#">Login</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-box forgot">
                    
                        <div class="form-details">
                            <h2>Need Help?</h2>
                                <p>We’ll send you instructions to reset your password.</p>
                        </div>
                        <div class="form-content">
                            <h2>FORGOT PASSWORD</h2>
                            <form action="#" id="forgot-password-form">
                            
                                <div class="input-field">
                                    <input type="email" required />
                                    <label>Email</label>
                                </div>
                                <button type="submit">Send Reset Link</button>
                            </form>
                            <div class="bottom-link">
                                Remembered your password?
                                <a href="#" id="back-to-login">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

    <script src="bloodbanks.js"></script>
</body>
</html>