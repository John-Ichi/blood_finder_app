<?php
include '_functions.php';
$conn = connect();
$current_session = $_SESSION['donor_email'];

if (!$current_session) {
    header('Location: index.php'); // Check not logged in
}

$session_id =
    "SELECT id
    FROM donor_login_info
    WHERE email='$current_session'";
$get_sess_id = $conn->query($session_id);
while ($row = $get_sess_id->fetch_assoc()) {
    $sess_id = $row['id']; // Get user id
}

$rs = $conn->query("SELECT * FROM donor_info WHERE donor_id='$sess_id'");
if ($rs->num_rows > 0) {
    header('Location: donor-db.php'); // Check information
}

if (isset($_POST['submit'])) { // Complete registration 
    $province = $_POST['province'];
    $municipality = $_POST['municipality'];
    $address = $municipality . ", " . $province;

    $sql =
        "INSERT INTO donor_info
        (`donor_id`,`donor_name`,`blood_type`,`address`,`contact`)
        VALUES
        (?,?,?,?,?)";
    $register = $conn->prepare($sql);
    $register->bind_param('sssss',$sess_id,$_POST['name'],$_POST['blood_type'],$address,$_POST['contact']);
    $register->execute();

    header('Location: donor-db.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/donor-info.css">
    <link rel="icon" href="resources/heartbeat-solid.svg">
    <title>LifeLink</title>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <a href="#" class="logo">
            <i class="fas fa-heartbeat"></i>
            <span>LifeLink</span>
        </a>
        <div class="nav-links">
            <button id="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </div>
    </header>

    <!-- Form -->
    <div id="page" class="site">
        <div class="containers">
            <div class="form-box">
                <div class="progress">
                    <div class="logos">Complete Your Details</div>
                    <div class="steps-container">
                        <ul class="progress-steps">
                            <li class="step active">
                                <span>1</span>
                                <p>Name<br><span>Let us know who you are</span></p>
                            </li>
                            <li class="step">
                                <span>2</span>
                                <p>Blood Type<br><span>Select blood type</span></p>
                            </li>
                            <li class="step">
                                <span>3</span>
                                <p>Contact<br><span>How can we reach you?</span></p>
                            </li>
                            <li class="step">
                                <span>4</span>
                                <p>Address<br><span>Let us know where to find you</span></p>
                            </li>
                        </ul>
                    </div>
                </div>
                <form method="POST" id="registration">
                    <div class="form-one form-step active">
                        <svg class="form-step-svg" viewBox="0 0 100 100" fill="#cf1d1d" xmlns="http://www.w3.org/2000/svg" aria-label="User Profile">
                            <title>User Profile</title>
                            <circle cx="50" cy="35" r="20" fill="#cf1d1d"/>
                            <path d="M20 85 C20 65, 35 55, 50 55 C65 55, 80 65, 80 85 L20 85" fill="#cf1d1d"/>
                        </svg>
                        <!-- Get name -->
                        <h2>Name</h2>
                        <p>Enter your name correctly</p>
                        <div>
                            <input type="text" name="name" id="name" placeholder="e.g. Ceejay Cervantes">
                        </div>
                    </div>
                    <div class="form-two form-step">
                        <svg class="form-step-svg" viewBox="0 0 100 100" fill="#cf1d1d" xmlns="http://www.w3.org/2000/svg" aria-label="Blood Drop">
                            <title>Blood Drop</title>
                            <path d="M50 15 C50 15, 20 45, 20 70 C20 85, 32.5 90, 50 90 C67.5 90, 80 85, 80 70 C80 45, 50 15, 50 15Z"/>
                        </svg>
                        <!-- Get blood type -->
                        <h2>Blood Type</h2>
                        <p>Select your blood type</p>
                        <div>
                            <select name="blood_type" id="bloodtype">
                                <option value="" selected style="display: none;">Select</option>
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
                    <div class="form-three form-step">
                        <svg class="form-step-svg" viewBox="0 0 100 100" fill="#cf1d1d" xmlns="http://www.w3.org/2000/svg" aria-label="Phone">
                            <title>Phone</title>
                            <rect x="25" y="10" width="50" height="80" rx="8" ry="8" fill="#cf1d1d"/>
                            <rect x="30" y="20" width="40" height="50" rx="2" ry="2" fill="white"/>
                            <circle cx="50" cy="80" r="4" fill="white"/>
                        </svg>
                        <!-- Get contact -->
                        <h2>Contact</h2>
                        <p>How can we reach you?</p>
                        <div>
                            <label>Contact Number</label>
                            <input type="tel" name="contact" placeholder="e.g. 09xxxxxxxxx" id="contact">
                        </div>    
                    </div>
                    <div class="form-four form-step">
                        <svg class="form-step-svg" viewBox="0 0 100 100" fill="#cf1d1d" xmlns="http://www.w3.org/2000/svg" aria-label="Location Pin">
                            <title>Location Pin</title>
                            <path d="M50 10 C30 10, 10 30, 10 50 C10 80, 50 90, 50 90 C50 90, 90 80, 90 50 C90 30, 70 10, 50 10Z"/>
                            <circle cx="50" cy="50" r="15" fill="white"/>
                        </svg>
                        <!-- Get address -->
                        <h2>Address</h2>
                        <p>Let us know where to find you</p>
                        <div>
                            <label>Province</label>
                            <input type="text" name="province" id="province" placeholder="e.g. Metro Manila">
                        </div>
                        <div>
                            <label>Municipality/City</label>
                            <input type="text" name="municipality" id="municipality" placeholder="e.g. Cavite">
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn-prev" disabled>Back</button>
                        <button type="button" class="btn-next">Next Step</button>
                        <button type="submit" class="btn-submit" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal" id="logoutModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Confirm Logout</h2>
            <p>Are you sure you want to log out?</p>
            <div class="modal-actions" style="margin-top: 1.2rem;">
                <form method="GET" action="_functions.php">
                    <input type="text" name="logoutBB" value="true" style="display: none;">
                    <button class="btn btn-primary" id="confirmLogout" name="logoutDonor" value="true">Yes, Log Out</button>
                    <button class="btn btn-outline" style="margin-left: 0.5rem;" id="cancelLogout">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script src="donor-info.js"></script>
</body>
</html>
