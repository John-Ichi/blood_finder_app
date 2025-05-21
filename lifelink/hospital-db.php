<?php
include '_functions.php';
$conn = connect();

$current_session = $_SESSION['hospital_email'];

if(!$current_session) {
    header('Location: home.php');
}

$sess_id;
$sql_id = "SELECT id FROM hospital_login_info WHERE email='$current_session'";
$get_sess_id = $conn->query($sql_id);

while($row = $get_sess_id->fetch_assoc()) {
    $sess_id = $row['id'];
}

$name;
$stockAp;
$stockAn;
$stockBp; 
$stockBn;
$stockABp;
$stockABn;
$stockOp;
$stockOn;

$sql_info = "SELECT * FROM hospital_info WHERE id='$sess_id'";
$get_sess_info = $conn->query($sql_info);

while($row = $get_sess_info->fetch_assoc()) {
    $name = $row['name'];
    $stockAp = $row['a_positive_stock'];
    $stockAn = $row['a_negative_stock'];
    $stockBp = $row['b_positive_stock'];
    $stockBn = $row['b_negative_stock'];
    $stockABp = $row['ab_positive_stock'];
    $stockABn = $row['ab_negative_stock'];
    $stockOp = $row['o_positive_stock'];
    $stockOn = $row['o_negative_stock'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeLink - Hospital Dashboard</title>
    <link rel="icon" href="assets/heartu.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="resources/heartbeat-solid.svg">
</head>
<body>
    <header class="header">
        <a href="#" class="logo">
            <i class="fas fa-heartbeat"></i>
            <span>LifeLink</span>
        </a>
        <div class="nav-links">
            <a><?php echo $name?></a>
            <button id="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </div>
    </header>

    <div class="hospital-sidebar">
        <div class="sidebar-content">
            <div class="hospital-sidebar-links">
                <a href="#" data-section="dashboard" class="active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" data-section="inventory">
                    <i class="fas fa-tint"></i>
                    <span>Blood Inventory</span>
                </a>
                <a href="#" data-section="update-inventory">
                    <i class="fas fa-edit"></i>
                    <span>Update Inventory</span>
                </a>
                <a href="#" data-section="appointments">
                    <i class="fas fa-calendar-check"></i>
                    <span>Donor Appointments</span>
                </a>
                <a href="#" data-section="donation-history">
                    <i class="fas fa-history"></i>
                    <span>Donation History</span>
                </a>
                <a href="#" data-section="settings">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </div>
        </div>
    </div>

        <div class="main-content">
            <!-- Dashboard Section -->
            <section id="dashboard" class="content-section active">
                <div class="stats-container">
                    <div class="stat-card">
                        <i class="fas fa-flask fa-2x"></i>
                        <h3>Current Blood Supply</h3>
                        <p class="stat-value">1,245 units</p>
                        <p class="stat-info"><i class="fas fa-arrow-up"></i> +15 units this week</p>
                    </div>
                    <div class="stat-card urgent">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                        <h3>Critical Levels</h3>
                        <p class="stat-value">3 types</p>
                        <p class="stat-info">O-, A-, AB-</p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-user-clock fa-2x"></i>
                        <h3>Pending Appointments</h3>
                        <p class="stat-value">24</p>
                        <p class="stat-info"><i class="fas fa-bell"></i> 5 urgent requests</p>
                    </div>
                </div>

                <div class="content-row">
                    <div class="content-box">
                        <h2><i class="fas fa-ambulance"></i> Urgent Requests</h2>
                        <div class="request-item urgent">
                            <h3><i class="fas fa-procedures"></i> Emergency Surgery - Type O+</h3>
                            <p><i class="fas fa-clock"></i> Needed by: 05/15/2025</p>
                            <p><i class="fas fa-vial"></i> Quantity: 5 units</p>
                            <div class="request-actions">
                                <button class="btn-accept"><i class="fas fa-check"></i> Accept</button>
                                <button class="btn-decline"><i class="fas fa-times"></i> Decline</button>
                            </div>
                        </div>
                        <div class="request-item">
                            <h3><i class="fas fa-heart"></i> Cardiac Bypass - Type A-</h3>
                            <p><i class="fas fa-clock"></i> Needed by: 05/18/2025</p>
                            <p><i class="fas fa-vial"></i> Quantity: 3 units</p>
                            <div class="request-actions">
                                <button class="btn-accept"><i class="fas fa-check"></i> Accept</button>
                                <button class="btn-decline"><i class="fas fa-times"></i> Decline</button>
                            </div>
                        </div>
                    </div>

                <div class="content-box">
                    <h2><i class="fas fa-history"></i> Recent Donations</h2>
                        <div class="donation-list">
                        <div class="donation-item">
                        <h3><i class="fas fa-user"></i> Juan Dela Cruz</h3>
                        <p><i class="fas fa-tint"></i> Type: O+</p>
                        <p><i class="fas fa-calendar-day"></i> Date: 05/10/2025</p>
                        <p><i class="fas fa-syringe"></i> Quantity: 1 unit</p>
                        </div>
                        <div class="donation-item">
                        <h3><i class="fas fa-user"></i> Maria Santos</h3>
                        <p><i class="fas fa-tint"></i> Type: A+</p>
                        <p><i class="fas fa-calendar-day"></i> Date: 05/08/2025</p>
                        <p><i class="fas fa-syringe"></i> Quantity: 1 unit</p>
                         </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Blood Inventory Section -->
            <section id="inventory" class="content-section">
                <h2><i class="fas fa-warehouse"></i> Blood Inventory</h2>
                <div class="inventory-filters">
                    <select id="blood-type-filter">
                        <option value="all">All Blood Types</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-tint"></i> Blood Type</th>
                            <th><i class="fas fa-cubes"></i> Units Available</th>
                            <th><i class="fas fa-calendar-times"></i> Expiration Date</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="critical">
                            <td>A+</td>
                            <td><?php echo $stockAp?></td>
                            <td>06/15/2025</td>
                            <td><i class="fas fa-exclamation-circle"></i> Critical</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Update Inventory Section -->
            <section id="update-inventory" class="content-section">
                <h2><i class="fas fa-plus-circle"></i> Update Blood Inventory</h2>
                <form id="inventory-form">
                    <div class="form-group">
                        <label for="blood-type"><i class="fas fa-tint"></i> Blood Type:</label>
                        <select id="blood-type" required>
                            <option value="">Select Blood Type</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity"><i class="fas fa-cubes"></i> Quantity:</label>
                        <input type="number" id="quantity" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="expiration"><i class="fas fa-calendar-day"></i> Expiration Date:</label>
                        <input type="date" id="expiration" required>
                    </div>
                    <div class="form-group">
                        <label for="source"><i class="fas fa-truck-medical"></i> Source:</label>
                        <select id="source">
                            <option value="donation">Donation</option>
                            <option value="transfer">Transfer from other hospital</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="donor-id"><i class="fas fa-id-card"></i> Donor ID (if applicable):</label>
                        <input type="text" id="donor-id">
                    </div>
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Add to Inventory</button>
                </form>
            </section>

            <!-- Donor Appointments Section -->
            <section id="appointments" class="content-section">
                <h2><i class="fas fa-calendar-alt"></i> Donor Appointment Requests</h2>
                <div class="appointment-filters">
                    <select id="appointment-status">
                        <option value="all">All Appointments</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="completed">Completed</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <select id="appointment-blood-type">
                        <option value="all">All Blood Types</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>
                <div class="appointment-list">
                    <div class="appointment-item pending">
                        <div class="appointment-info">
                            <h3><i class="fas fa-user"></i> Juan Dela Cruz</h3>
                            <p><i class="fas fa-tint"></i> <strong>Blood Type:</strong> O+</p>
                            <p><i class="fas fa-clock"></i> <strong>Requested Date:</strong> 05/15/2025 at 10:00 AM</p>
                            <p><i class="fas fa-hourglass-half"></i> <strong>Status:</strong> Pending</p>
                        </div>
                        <div class="appointment-actions">
                            <button class="btn-approve"><i class="fas fa-check"></i> Approve</button>
                            <button class="btn-reject"><i class="fas fa-times"></i> Reject</button>
                        </div>
                    </div>
                    <div class="appointment-item approved">
                        <div class="appointment-info">
                            <h3><i class="fas fa-user"></i> Maria Santos</h3>
                            <p><i class="fas fa-tint"></i> <strong>Blood Type:</strong> A-</p>
                            <p><i class="fas fa-calendar-check"></i> <strong>Scheduled Date:</strong> 05/16/2025 at 2:00 PM</p>
                            <p><i class="fas fa-thumbs-up"></i> <strong>Status:</strong> Approved</p>
                        </div>
                        <div class="appointment-actions">
                            <button class="btn-complete"><i class="fas fa-check-double"></i> Mark as Completed</button>
                            <button class="btn-cancel"><i class="fas fa-ban"></i> Cancel</button>
                        </div>
                    </div>
                    <div class="appointment-item completed">
                        <div class="appointment-info">
                            <h3><i class="fas fa-user"></i> Pedro Reyes</h3>
                            <p><i class="fas fa-tint"></i> <strong>Blood Type:</strong> B+</p>
                            <p><i class="fas fa-calendar-day"></i> <strong>Donation Date:</strong> 05/10/2025 at 9:00 AM</p>
                            <p><i class="fas fa-check-circle"></i> <strong>Status:</strong> Completed</p>
                            <p><i class="fas fa-syringe"></i> <strong>Units Collected:</strong> 1</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Donation History Section -->
            <section id="donation-history" class="content-section">
                 <h2><i class="fas fa-clipboard-list"></i> Donation History</h2>
            <div class="history-filters">
                <input type="text" id="donor-search" placeholder="Search donor name...">
                <select id="history-blood-type">
                    <option value="all">All Blood Types</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>
                <input type="date" id="history-date" placeholder="Date">
            </div>
             <table class="history-table">
        <thead>
            <tr>
                <th><i class="fas fa-user"></i> Donor Name</th>
                <th><i class="fas fa-tint"></i> Blood Type</th>
                <th><i class="fas fa-calendar"></i> Donation Date</th>
                <th><i class="fas fa-vial"></i> Units Collected</th>
                <th><i class="fas fa-info-circle"></i> Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pedro Reyes</td>
                <td>B+</td>
                <td>05/10/2025</td>
                <td>1</td>
                <td><i class="fas fa-check-circle"></i> Processed</td>
            </tr>
            <tr>
                <td>Maria Santos</td>
                <td>A+</td>
                <td>05/08/2025</td>
                <td>1</td>
                <td><i class="fas fa-check-circle"></i> Processed</td>
            </tr>
            <tr>
                <td>Juan Dela Cruz</td>
                <td>O+</td>
                <td>05/05/2025</td>
                <td>1</td>
                <td><i class="fas fa-check-circle"></i> Processed</td>
            </tr>
        </tbody>
    </table>
</section>

            <!-- Settings Section -->
            <section id="settings" class="content-section">
                <h2><i class="fas fa-user-cog"></i> Account Settings</h2>
                <div class="settings-tabs">
                    <button class="tab-btn active" data-tab="profile"><i class="fas fa-hospital"></i> Hospital Profile</button>
                    <button class="tab-btn" data-tab="password"><i class="fas fa-key"></i> Change Password</button>
                </div>
                
                <div id="profile" class="tab-content active">
                    <form id="profile-form">
                        <div class="form-group">
                            <label><i class="fas fa-hospital-user"></i> Hospital Name:</label>
                            <input type="text" class="hospital-control" value="St. Luke's Medical Center" readonly>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email Address:</label>
                            <input type="email" class="hospital-control" value="bloodbank@stlukes.com.ph" readonly>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-map-marker-alt"></i> Location:</label>
                            <input type="text" class="hospital-control" value="Quezon City, Philippines" readonly>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> Contact Number:</label>
                            <input type="tel" class="hospital-control" value="+632 8723 0101" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-user-md"></i> Blood Bank Coordinator:</label>
                            <input type="text" class="hospital-control" value="Dr. Maria Reyes" required>
                        </div>
                        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Update Profile</button>
                    </form>
                </div>
                
                <div id="password" class="tab-content">
                    <form id="password-form">
                        <div class="form-group">
                            <label for="current-password"><i class="fas fa-lock"></i> Current Password:</label>
                            <input type="password" id="current-password" required>
                        </div>
                        <div class="form-group">
                            <label for="new-password"><i class="fas fa-key"></i> New Password:</label>
                            <input type="password" id="new-password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm-password"><i class="fas fa-check-double"></i> Confirm New Password:</label>
                            <input type="password" id="confirm-password" required>
                        </div>
                        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Change Password</button>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <script src="hospital-db.js"></script>
</body>
</html>