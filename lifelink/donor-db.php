<?php
include '_functions.php';
$conn = connect();

$current_session = $_SESSION['donor_email'];

if(!isset($current_session)) {
    header('Location: home.php');
}

$session_id = "SELECT id FROM donor_login_info WHERE email='$current_session'";
$get_sess_id = $conn->query($session_id);
$sess_id = "";
while($row = $get_sess_id->fetch_assoc()) {
    $sess_id = $row['id']; // get id of donor
}

updateAvailablity();
$session_info = "SELECT * FROM donor_info WHERE donor_id='$sess_id'";

$check_sess_info = $conn->query($session_info);
if($check_sess_info->num_rows === 0) { // if wala pang details e.g. after account creation
    header('Location: donor-info.php'); // complete details
}

$name = "";
$contact = "";
$location = "";
$blood_type = "";
$donor_notes = "";
$last_donation = "";
$next_available = "";

$get_sess_info = $conn->query($session_info);
while ($row = $get_sess_info->fetch_assoc()) { // set current session info
    $name = $row['name'];
    $contact = $row['contact'];
    $location = $row['address'];
    $blood_type = $row['blood_type'];
    $donor_notes = $row['donor_notes'];
    $last_donation = $row['last_donation'];
    $next_available = $row['next_available'];
}

if (isset($_POST['update'])) { // update information function
    $sql = "UPDATE `donor_info` SET
    `name`='$_POST[name]',
    `email`='$_POST[email]',
    `contact`='$_POST[contact]',
    `address`='$_POST[address]',
    `donor_notes`='$_POST[donor_notes]'
    WHERE
    `email`='$current_session'";
    $rs = $conn->query($sql);
    header('Location: donor-db.php');
}

if(isset($_POST['donation_appointment'])) { // donation appointment function
    $sql = "INSERT INTO donation_appointments
    (`donor_id`,
    `date_of_donation`,
    `preferred_time`,
    `hospital_id`,
    `additional_info`)
    VALUES
    ('$sess_id',
    '$_POST[date_of_donation]',
    '$_POST[preferred_time]',
    '$_POST[hospital_id]',
    '$_POST[additional_info]')";
    $rs = $conn->query($sql);
    header('Location: donor-db.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeLink - Blood Donation Platform</title>
    <link rel="icon" href="assets/heartu.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="resources/heartbeat-solid.svg">
</head>
<body>
    <!-- Top Navigation -->
    <header class="header">
        <a href="home.php" class="logo">
            <i class="fas fa-heartbeat"></i>
            <span>LifeLink</span>
        </a>
        <div class="nav-links">
            <a href="home.php">Home</a>
            <a href="#">Donors</a>
            <a href="#">Blood Banks</a>
        </div>
    </header>
    
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-content">
            <div class="user-profile">
                <h3><?php echo $name?></h3>
                <p>Blood Type: <b><?php echo $blood_type?></b></p>
            </div>
            <div class="sidebar-links">
                <a href="#" data-page="home" class="active">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="#" data-page="donate">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Schedule Donation</span>
                </a>
                <a href="#" data-page="requests">
                    <i class="fas fa-tint"></i>
                    <span>Blood Requests</span>
                </a>
                <a href="#" data-page="profile">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
                <a href="#" id="logoutBtn" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">

        <div class="card-row">
            <!-- Home Page -->
            <section class="page active" id="home-page">
                <div class="hero">
                    <h1>Save Lives Through Blood Donation</h1>
                    <p>Join our community of donors and help patients in need across the Philippines. Your single donation can save up to three lives.</p>
                    <!--<div style="display: flex; gap: 0.8rem; justify-content: center;"></div>-->
                </div>

                <div class="card-row">
                    <!-- Recent Activity Card -->
                    <section class="card">
                        <div class="card-header">
                            <h2>Recent Activity</h2>
                            <i class="fas fa-chart-line" style="color: var(--primary); font-size: 1.3rem;"></i>
                        </div>
                        <div style="text-align: center; padding: 1.5rem 0;">
                            <i class="fas fa-tint" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 0.8rem;"></i>
                            <h3>Your Last Donation</h3>
                            <p>
                            <?php // add distance
                            if($last_donation != "No Record") {
                                echo $last_donation . " at _____";
                            }
                            else
                                echo $last_donation;
                            ?>
                            </p>
                            <p style="margin-top: 0.8rem;">
                                <strong>Next eligible donation:</strong>
                                <?php
                                echo $next_available;
                                ?>
                            </p>
                            <button class="btn btn-primary" style="margin-top: 0.8rem;" data-page="donate">Schedule Next Donation</button>
                        </div>
                    </section>
                    
                    <!-- Urgent Requests Card -->
                    <section class="card">
                        <div class="card-header">
                            <h2>Urgent Requests Near You</h2>
                            <i class="fas fa-exclamation-triangle" style="color: var(--primary-dark); font-size: 1.3rem;"></i>
                        </div>
                        <ul class="request-list" style="height: 378px;"><?php getUrgentRequests($sess_id); ?></ul>
                        <button class="btn btn-outline" style="width: 100%;" data-page="requests">
                            View All Requests
                        </button>
                    </section>
                </div>
            </section>

            <!-- Donate Page -->
            <section class="page" id="donate-page">
                <div class="hero">
                    <h1>Schedule Your Donation</h1>
                    <p>Find a convenient time and location to donate blood across the Philippines.</p>
                </div>

                <div class="dashboard">
                    <div class="donation-form-container">
                        <section class="card donation-form-card">
                            <div class="card-header">
                                <h2>Donation Appointment</h2>
                                <i class="fas fa-tint" style="color: var(--primary); font-size: 1.5rem;"></i>
                            </div>
                            <div style="text-align: center; margin: 1rem;">
                                <?php
                                $status = getMostRecentAppointment($sess_id);
                                if($status === 'pending') {
                                    echo "<p class='urgent-tag' style='color: var(--primary-dark); font-weight: bold; text-align: center'>Ongoing Appointment Request</p>";
                                    // need ng function to view, paliitin
                                    echo "
                                        <div class='form-details'>
                                            <button class='btn btn-sm btn-outline view-details'>View Details</button>
                                        </div>
                                    ";
                                }
                                ?>
                            </div>
                            <form id="donationForm" method="POST">
                                <fieldset <?php if($status === 'pending') {echo 'disabled';}?>>
                                    <div class="form-group">
                                        <label for="donationDate">Preferred Donation Date</label>
                                        <input type="date" id="donationDate" class="form-control" name="date_of_donation" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="donationTime">Preferred Time</label>
                                        <select id="donationTime" class="form-control" name="preferred_time" required>
                                            <option value="">Select a time</option>
                                            <option value="morning">Morning (8am-12pm)</option>
                                            <option value="afternoon">Afternoon (12pm-4pm)</option>
                                            <option value="evening">Evening (4pm-8pm)</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="donationCenter">Donation Center</label>
                                        <select id="donationCenter" class="form-control" name="hospital_id" required>
                                            <option value="">Select a center</option>
                                            <?php
                                            getHospitalList();
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="healthInfo">Health Information</label>
                                        <textarea id="healthInfo" class="form-control" rows="4" placeholder="Any recent illnesses, medications, etc." name="additional_info"></textarea>
                                    </div>                            
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary" name="donation_appointment">Schedule Donation</button>
                                        <button type="button" class="btn btn-outline" data-page="home">Cancel</button>
                                    </div>
                                </fieldset>
                            </form>
                        </section>
                    </div>
                </div>
            </section>

            <!-- Requests Page -->
            <section class="page" id="requests-page">
                <div class="hero">
                    <h1>Blood Requests</h1>
                    <p>View current blood requests across the Philippines and help those in need.</p>
                </div>

                <div class="dashboard">
                    <section class="card" style="grid-column: 1 / -1;">
                        <div class="card-header">
                            <h2>Current Blood Requests</h2>
                            <div class="filter-container">
                                <div class="filter-group">
                                    <span class="filter-label">Distance:</span>
                                    <select id="filterDistance" class="form-control">
                                        <option value="">Any Distance</option>
                                        <option value="5">Within 5 km</option>
                                        <option value="10">Within 10 km</option>
                                        <option value="20">Within 20 km</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <span class="filter-label">Urgency:</span>
                                    <select id="filterUrgency" class="form-control">
                                        <option value="">All</option>
                                        <option value="urgent">Urgent Only</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <ul class="request-list" id="requestsList"><?php getDonorRequests($sess_id); ?><!-- display requests --></ul>
                    </section>
                </div>
            </section>

            <!-- Profile Page -->
            <section class="page" id="profile-page">
                <div class="hero">
                    <h1>My Profile</h1>
                    <p>Manage your account information and donation history.</p>
                </div>

                <div class="card-row">
                <!-- Personal Information Card -->    
                    <section class="card">
                        <div class="card-header">
                            <h2>Personal Information</h2>
                            <i class="fas fa-user" style="color: var(--primary); font-size: 1.3rem;"></i>
                        </div>
                        <form id="profileForm" method="POST">
                            <div class="form-group">
                                <label for="fullName">Full Name</label>
                                <input type="text" id="fullName" class="form-control" name="name" value="<?php echo $name?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <!-- bind ba natin email? -->
                                <input type="email" id="email" class="form-control" name="email" value="<?php echo $current_session?>" disabled> 
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" class="form-control" name="contact" value="<?php echo $contact?>" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" class="form-control" name="address" rows="2"><?php echo $location?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="address">Personal Notes</label>
                                <textarea id="address" class="form-control" name="donor_notes" rows="2" placeholder="Add personal donor notes e.g. preferred dates of donation"><?php echo $donor_notes?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="bloodTypeProfile">Blood Type</label>
                                <select id="bloodTypeProfile" class="form-control" disabled>
                                    <option value="A+" <?php if($blood_type === "A+") {echo 'selected';}?>>A+</option>
                                    <option value="A-" <?php if($blood_type === "A-") {echo 'selected';}?>>A+</option>
                                    <option value="B+" <?php if($blood_type === "B+") {echo 'selected';}?>>B+</option>
                                    <option value="B-" <?php if($blood_type === "B-") {echo 'selected';}?>>B-</option>
                                    <option value="AB+" <?php if($blood_type === "AB+") {echo 'selected';}?>>AB+</option>
                                    <option value="AB-" <?php if($blood_type === "AB-") {echo 'selected';}?>>AB-</option>
                                    <option value="O+" <?php if($blood_type === "O+") {echo 'selected';}?>>O+</option>
                                    <option value="O-" <?php if($blood_type === "O-") {echo 'selected';}?>>O-</option>
                                </select> 
                            </div>
                            <button type="submit" name="update" class="btn btn-primary">Update Profile</button>
                        </form>
                    </section>

                <!-- Donation History Card -->
                <section class="card">
                    <div class="card-header">
                        <h2>Donation History</h2>
                        <i class="fas fa-history" style="color: var(--primary); font-size: 1.3rem;"></i>
                    </div>
                    <ul class="request-list" style="max-height: 465px; overflow-y: auto;">
                        <li class="request-item">
                            <div class="request-info">
                                <h3>March 15, 2023</h3>
                                <p><i class="fas fa-map-marker-alt"></i> Philippine Red Cross - Manila</p>
                                <p><i class="fas fa-tint"></i> A+ Blood Type</p>
                                <p><i class="fas fa-heartbeat"></i> Surgery: Cardiac Bypass</p>
                                <p><i class="fas fa-check-circle"></i> Successful Donation</p>
                            </div>
                            <div class="request-actions">
                                <button class="btn btn-outline btn-sm view-details">Details</button>
                            </div>
                        </li>
                        <li class="request-item">
                            <div class="request-info">
                                <h3>January 10, 2023</h3>
                                <p><i class="fas fa-map-marker-alt"></i> Philippine General Hospital</p>
                                <p><i class="fas fa-tint"></i> B- Blood Type</p>
                                <p><i class="fas fa-brain"></i> Surgery: Neurosurgery</p>
                                <p><i class="fas fa-check-circle"></i> Successful Donation</p>
                            </div>
                            <div class="request-actions">
                                <button class="btn btn-outline btn-sm view-details">Details</button>
                            </div>
                        </li>
                        <li class="request-item">
                            <div class="request-info">
                                <h3>November 5, 2022</h3>
                                <p><i class="fas fa-map-marker-alt"></i> St. Luke's Medical Center</p>
                                <p><i class="fas fa-tint"></i> O+ Blood Type</p>
                                <p><i class="fas fa-bone"></i> Surgery: Orthopedic Procedure</p>
                                <p><i class="fas fa-check-circle"></i> Successful Donation</p>
                            </div>
                            <div class="request-actions">
                                <button class="btn btn-outline btn-sm view-details">Details</button>
                            </div>
                        </li>
                        <li class="request-item">
                            <div class="request-info">
                                <h3>August 20, 2022</h3>
                                <p><i class="fas fa-map-marker-alt"></i> Makati Medical Center</p>
                                <p><i class="fas fa-tint"></i> AB+ Blood Type</p>
                                <p><i class="fas fa-baby"></i> Surgery: Emergency C-Section</p>
                                <p><i class="fas fa-check-circle"></i> Successful Donation</p>
                            </div>
                            <div class="request-actions">
                                <button class="btn btn-outline btn-sm view-details">Details</button>
                            </div>
                        </li>
                    </ul>
                    <button class="btn btn-outline" style="margin-top: 0.8rem; width: 100%;" id="viewFullHistory">
                        View Full History
                    </button>
                </section>
            </section>
        </div>
    </div>

    <!-- Modals -->
    <!-- Request Details Modal -->
    <div class="modal" id="requestModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Request Details</h2>
            <div class="request-details">
                <p><strong>Patient Name:</strong> Maria Santos</p>
                <p><strong>Blood Type Needed:</strong> O+</p>
                <p><strong>Hospital:</strong> Philippine General Hospital</p>
                <p><strong>Address:</strong> Taft Avenue, Ermita, Manila</p>
                <p><strong>Contact Person:</strong> Wilma Santos</p>
                <p><strong>Contact Phone:</strong> +63 917 123 4567</p>
                <p><strong>Surgery Type:</strong> <i class="fas fa-procedures"></i> Cardiac Bypass</p>
                <p><strong>Reason for Request:</strong> Emergency surgery following accident</p>
                <p><strong>Urgency:</strong> High - Needed within 24 hours</p>
            </div>
            <div class="modal-actions" style="margin-top: 1.2rem;">
                <button class="btn btn-primary" id="confirmAccept">Accept Request</button>
                <button class="btn btn-outline" style="margin-left: 0.5rem;" id="saveForLater">Save for Later</button>
            </div>
        </div>
    </div>
    
    <!-- Donation Details Modal -->
    <div class="modal" id="donationDetailsModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Donation Details</h2>
            <div class="donation-details">
                <p><strong>Date:</strong> <span id="detailDate"></span></p>
                <p><strong>Location:</strong> <span id="detailLocation"></span></p>
                <p><strong>Blood Type:</strong> <span id="detailType"></span></p>
                <p><strong>Surgery Type:</strong> <i class="fas fa-procedures"></i> <span id="detailSurgery"></span></p>
                <p><strong>Notes:</strong> <span id="detailNotes"></span></p>
            </div>
            <button class="btn btn-primary" id="closeDetailsBtn">Close</button>
        </div>
    </div>
    
    <div class="modal" id="appointmentDetailsModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Appointment Details</h2>
            <div class="appointment-details">
                <p>Paragraph</p>
            </div>
        </div>
    </div>

    <!-- Full History Modal -->
    <div class="modal" id="fullHistoryModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Complete Donation History</h2>
            <div class="filter-container" style="margin-bottom: 1rem;">
                <div class="filter-group">
                    <span class="filter-label">Year:</span>
                    <select id="filterHistoryYear" class="form-control">
                        <option value="">All Years</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                    </select>
                </div>
                <div class="filter-group">
                    <span class="filter-label">Blood Type:</span>
                    <select id="filterHistoryType" class="form-control">
                        <option value="">All Types</option>
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
            <ul class="request-list">
                <li class="request-item">
                    <div class="request-info">
                        <h3>March 15, 2023</h3>
                        <p><i class="fas fa-map-marker-alt"></i> Philippine Red Cross - Manila</p>
                        <p><i class="fas fa-tint"></i> A+ Blood Type</p>
                        <p><i class="fas fa-heartbeat"></i> Surgery: Cardiac Bypass</p>
                        <p><i class="fas fa-check-circle"></i> Successful Donation</p>
                    </div>
                    <div class="request-actions">
                        <button class="btn btn-outline btn-sm view-details">Details</button>
                    </div>
                </li>
                <li class="request-item">
                    <div class="request-info">
                        <h3>January 10, 2023</h3>
                        <p><i class="fas fa-map-marker-alt"></i> Philippine General Hospital</p>
                        <p><i class="fas fa-tint"></i> B- Blood Type</p>
                        <p><i class="fas fa-brain"></i> Surgery: Neurosurgery</p>
                        <p><i class="fas fa-check-circle"></i> Successful Donation</p>
                    </div>
                    <div class="request-actions">
                        <button class="btn btn-outline btn-sm view-details">Details</button>
                    </div>
                </li>
                <li class="request-item">
                    <div class="request-info">
                        <h3>November 5, 2022</h3>
                        <p><i class="fas fa-map-marker-alt"></i> St. Luke's Medical Center</p>
                        <p><i class="fas fa-tint"></i> O+ Blood Type</p>
                        <p><i class="fas fa-bone"></i> Surgery: Orthopedic Procedure</p>
                        <p><i class="fas fa-check-circle"></i> Successful Donation</p>
                    </div>
                    <div class="request-actions">
                        <button class="btn btn-outline btn-sm view-details">Details</button>
                    </div>
                </li>
                <li class="request-item">
                    <div class="request-info">
                        <h3>August 20, 2022</h3>
                        <p><i class="fas fa-map-marker-alt"></i> Makati Medical Center</p>
                        <p><i class="fas fa-tint"></i> AB+ Blood Type</p>
                        <p><i class="fas fa-baby"></i> Surgery: Emergency C-Section</p>
                        <p><i class="fas fa-check-circle"></i> Successful Donation</p>
                    </div>
                    <div class="request-actions">
                        <button class="btn btn-outline btn-sm view-details">Details</button>
                    </div>
                </li>
                <li class="request-item">
                    <div class="request-info">
                        <h3>May 15, 2022</h3>
                        <p><i class="fas fa-map-marker-alt"></i> Philippine Heart Center</p>
                        <p><i class="fas fa-tint"></i> O+ Blood Type</p>
                        <p><i class="fas fa-heart"></i> Surgery: Heart Transplant</p>
                        <p><i class="fas fa-check-circle"></i> Successful Donation</p>
                    </div>
                    <div class="request-actions">
                        <button class="btn btn-outline btn-sm view-details">Details</button>
                    </div>
                </li>
                <li class="request-item">
                    <div class="request-info">
                        <h3>February 8, 2022</h3>
                        <p><i class="fas fa-map-marker-alt"></i> National Kidney and Transplant Institute</p>
                        <p><i class="fas fa-tint"></i> A- Blood Type</p>
                        <p><i class="fas fa-kidneys"></i> Surgery: Kidney Transplant</p>
                        <p><i class="fas fa-check-circle"></i> Successful Donation</p>
                    </div>
                    <div class="request-actions">
                        <button class="btn btn-outline btn-sm view-details">Details</button>
                    </div>
                </li>
            </ul>
            <button class="btn btn-primary" style="margin-top: 1rem; width: 100%;" id="closeFullHistory">
                Close
            </button>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal" id="logoutModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Confirm Logout</h2>
            <p>Are you sure you want to log out?</p>
            <div class="modal-actions" style="margin-top: 1.2rem;">
                <button class="btn btn-primary" id="confirmLogout">Yes, Log Out</button>
                <button class="btn btn-outline" style="margin-left: 0.5rem;" id="cancelLogout">Cancel</button>
            </div>
        </div>
    </div>

    <script src="donor-db.js"></script>
</body>
</html>