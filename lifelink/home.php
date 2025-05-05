<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeLink</title>
    <link rel="shortcut icon" href="fas fa-heartbeat" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family-Material+Symbols+Rounded:opsz,wght,FILL.GRAD@48,400,0,0">
    <link rel="stylesheet" href="home.css">
    <link rel="icon" href="resources/heartbeat-solid.svg">
</head>
<body>

    <div class="container">
        <nav>
            <div class="logo">
                <i class="fas fa-heartbeat"></i>
                <span>LifeLink</span>
            </div>
            <div class="nav-links">
                <a href="#" class="home-link">Home</a>
                <a href="donors.php" class="donorlist-link">Donor List</a>
                <a href="#" class="login-link">Bank List</a>
            </div>
        </nav>
    </div>

    <section class="page active" id="home">
        <div class="hero">
            <div class="search-container">
                <h2>Find Blood Donors</h2>
                <div class="search-form">
                    <div class="form-group">
                        <label for="bloodType">Blood Type</label>
                        <form method="POST" action="donors.php">
                        <select name="blood_type" id="bloodType" required>
                            <option value="">Select Blood Type</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                </div>
                <button type="submit" name="filter" class="btn btn-primary" id="searchBtn">
                    <i class="fas fa-search"></i> Search Donors
                </button>
                </form>
            </div>
    
            <div class="hero-content">
                <h1>Connecting Blood Donors With Those In Need</h1>
                <p>A platform dedicated to making blood donation accessible and efficient. Join our community of lifesavers today.</p>
                <a href="#login" class="btn btn-primary btn-large donor-login-btn">
                    <i class="fas fa-sign-in-alt"></i> Donor Login
                </a>
            </div>
        </div>

        <div class="how-it-works">
            <div class="container">
                <div class="section-title">
                    <h2>How It Works</h2>
                    <p>Our simple three-step process makes it easy to connect donors with recipients</p>
                </div>


            <div class="steps">
            <div class="step">
                <div class="step-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3>1. Register</h3>
                <p>Create an account as a donor and provide your blood type and location information.</p>
            </div>
            
            <div class="step">
                <div class="step-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>2. Search</h3>
                <p>Those in need can search for compatible donors by blood type and location.</p>
            </div>
            
            <div class="step">
                <div class="step-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3>3. Connect</h3>
                <p>Get connected with matching donors in your area when you need blood urgently.</p>
            </div>

    </section>

<!--
    <section class="page" id="donorlist">
        
        <div class="blur-bg-overlay"></div>
        <div class="form-popup">
            <span class="close-btn materials-symbols-rounded">&times;</span>
            <div class="form-box login" id="login">
                <div class="form-details">
                    <div class="overlay">
                    <h2>Welcome Back</h2>
                    <p>Join our growing community of life-savers and make a difference today. Your blood can be the bridge between hope and healing.</p>
                    </div>
                </div>
                <div class="form-content">
                    <h2>LOGIN</h2>
                    <form action="#">
                        <div class="input-field">
                            <input type="text" required>
                            <label>Email</label>
                        </div>
                        <div class="input-field">
                            <input type="password" required>
                            <label>Password</label>
                        </div>
                        <a href="#" class="forgot-pass">Forgot password?</a>
                        <button type="submit">Log In</button>
                    </form>
                    <div class="bottom-link">
                        Don't have an account?
                        <a href="#" id="signup-link">Signup</a>
                    </div>
                </div>
            </div>

            <span class="close-btn materials-symbols-rounded">&times;</span>
            <div class="form-box signup" id="signup">
                <div class="form-details">
                    <div class="overlay">
                    <h2>Create Account</h2>
                    <p>Ready to make a difference? Sign up today to become a blood donor and be the reason someone gets a second chance at life.</p>
                    </div>
                </div>
                <div class="form-content">
                    <h2>SIGN UP</h2>
                    <form action="#">
                        <div class="input-field">
                            <input type="text" required>
                            <label>Enter Your Email</label>
                        </div>
                        <div class="input-field">
                            <input type="password" required>
                            <label>Create Password</label>
                        </div>
                        <div class="input-field">
                            <input type="text" required>
                            <label>Enter Your Number</label>
                        </div>
                        <div class="policy">
                            <input type="checkbox" id="policy">
                            <label for="policy">
                                I agree to the
                                <a href="#">Terms & Conditions</a>
                            </label>
                        </div>
                        <button type="submit">Sign Up</button>
                    </form>
                    <div class="bottom-link">
                        Already have an account?
                        <a href="#" id="login-link">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
-->

</body>
<script src="home.js"></script>
</html>
