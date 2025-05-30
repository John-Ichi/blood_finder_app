<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeLink - Donor Dashboard</title>
    <link rel="icon" href="assets/heartbeat-solid.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="donor-wp.css">
</head>
<body>
    <header class="header">
    <a href="#" class="logo">
        <i class="fas fa-heartbeat"></i>
        <span>LifeLink</span>
    </a>
    <div class="nav-links">
        <a href="#">Home</a>
        <a href="#">Donor Lists</a>
        <a href="#">Blood Bank Lists</a>
    </div>
</header>
    
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-content">
            <div class="user-profile">
                <h3>Juan Dela Cruz</h3>
                <p>O+ Blood Type</p>
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
                <div style="display: flex; gap: 0.8rem; justify-content: center;">
                    <button class="btn btn-primary" data-page="donate">Schedule Donation</button>
                    <button class="btn btn-outline" data-page="requests">View Requests</button>
            </div>
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
                        <p>March 15, 2023 at Philippine Red Cross - Manila</p>
                        <p style="margin-top: 0.8rem;"><strong>Next eligible donation:</strong> May 15, 2023</p>
                        <button class="btn btn-primary" style="margin-top: 0.8rem;" data-page="donate">Schedule Next Donation</button>
                    </div>
                </section>
                
                <!-- Urgent Requests Card -->
                <section class="card">
                    <div class="card-header">
                        <h2>Urgent Requests Near You</h2>
                        <i class="fas fa-exclamation-triangle" style="color: var(--primary-dark); font-size: 1.3rem;"></i>
                    </div>
                    <ul class="request-list" style="max-height: 300px; overflow-y: auto;">
                        <li class="request-item" data-type="O+" data-distance="3.2" data-urgency="urgent">
                            <div class="request-info">
                                <h3>Emergency Request - Type O+</h3>
                                <p>Philippine General Hospital - Needed by 05/15/2023</p>
                                <p><i class="fas fa-procedures"></i> Surgery Type: Cardiac Bypass</p>
                                <p>Distance: 3.2 km from you</p>
                                <p class="urgent-tag" style="color: var(--primary-dark); font-weight: bold;">URGENT</p>
                            </div>
                            <div class="request-actions">
                                <button class="btn btn-primary btn-sm accept-request">Accept</button>
                                <button class="btn btn-outline btn-sm view-details">Details</button>
                            </div>
                        </li>
                        <li class="request-item" data-type="A-" data-distance="5.7">
                            <div class="request-info">
                                <h3>Scheduled Surgery - Type A-</h3>
                                <p>St. Luke's Medical Center - Needed by 05/20/2023</p>
                                <p><i class="fas fa-procedures"></i> Surgery Type: Hip Replacement</p>
                                <p>Distance: 5.7 km from you</p>
                            </div>
                            <div class="request-actions">
                                <button class="btn btn-primary btn-sm accept-request">Accept</button>
                                <button class="btn btn-outline btn-sm view-details">Details</button>
                            </div>
                        </li>
                    </ul>
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
                        <div class="donation-status">
                            <div class="status-badge status-pending">
                            <i class="fas fa-clock"></i> Pending Approval
                            </div>
                            <button class="btn btn-outline btn-sm view-appointment-details">View Details</button>
                            </div>
                        <form id="donationForm">
                            <div class="form-group">
                                <label for="donationDate">Preferred Donation Date</label>
                                <input type="date" id="donationDate" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="donationTime">Preferred Time</label>
                                <select id="donationTime" class="form-control" required>
                                    <option value="">Select a time</option>
                                    <option value="morning">Morning (8am-12pm)</option>
                                    <option value="afternoon">Afternoon (12pm-4pm)</option>
                                    <option value="evening">Evening (4pm-8pm)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="donationCenter">Donation Center</label>
                                <select id="donationCenter" class="form-control" required>
                                    <option value="">Select a center</option>
                                    <option value="redcross-manila">Philippine Red Cross - Manila</option>
                                    <option value="pgh">Philippine General Hospital</option>
                                    <option value="st-lukes">St. Luke's Medical Center - Global City</option>
                                    <option value="makati-med">Makati Medical Center</option>
                                    <option value="redcross-cebu">Philippine Red Cross - Cebu</option>
                                    <option value="redcross-davao">Philippine Red Cross - Davao</option>
                                    <option value="cebu-doctors">Cebu Doctors' University Hospital</option>
                                    <option value="davao-doctors">Davao Doctors Hospital</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="bloodType">Your Blood Type</label>
                                <select id="bloodType" class="form-control" required>
                                    <option value="">Select your blood type</option>
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
                            <div class="form-group">
                                <label for="healthInfo">Health Information</label>
                                <textarea id="healthInfo" class="form-control" rows="4" placeholder="Any recent illnesses, medications, etc."></textarea>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Schedule Donation</button>
                                <button type="button" class="btn btn-outline" data-page="home">Cancel</button>
                            </div>
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
                                <span class="filter-label">Blood Type:</span>
                                <select id="filterBloodType" class="form-control">
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
                    <ul class="request-list" id="requestsList">
                        <li class="request-item" data-type="O+" data-distance="3.2" data-urgency="urgent">
                            <div class="request-info">
                                <h3>Emergency Request - Type O+</h3>
                                <p>Philippine General Hospital - Needed by 05/15/2023</p>
                                <p><i class="fas fa-procedures"></i> Surgery Type: Cardiac Bypass</p>
                                <p>Distance: 3.2 km from you</p>
                                <p class="urgent-tag" style="color: var(--primary-dark); font-weight: bold;">URGENT</p>
                            </div>
                            <div class="request-actions">
                                <button class="btn btn-primary btn-sm accept-request">Accept</button>
                                <button class="btn btn-outline btn-sm view-details">Details</button>
                            </div>
                        </li>
                        <li class="request-item" data-type="A-" data-distance="5.7">
                            <div class="request-info">
                                <h3>Scheduled Surgery - Type A-</h3>
                                <p>St. Luke's Medical Center - Needed by 05/20/2023</p>
                                <p><i class="fas fa-procedures"></i> Surgery Type: Hip Replacement</p>
                                <p>Distance: 5.7 km from you</p>
                            </div>
                            <div class="request-actions">
                                <button class="btn btn-primary btn-sm accept-request">Accept</button>
                                <button class="btn btn-outline btn-sm view-details">Details</button>
                            </div>
                        </li>
                        <li class="request-item" data-type="AB+" data-distance="8.1">
                            <div class="request-info">
                                <h3>Cancer Treatment - Type AB+</h3>
                                <p>Makati Medical Center - Needed by 05/25/2023</p>
                                <p><i class="fas fa-radiation"></i> Surgery Type: Tumor Removal</p>
                                <p>Distance: 8.1 km from you</p>
                            </div>
                            <div class="request-actions">
                                <button class="btn btn-primary btn-sm accept-request">Accept</button>
                                <button class="btn btn-outline btn-sm view-details">Details</button>
                            </div>
                        </li>
                        <li class="request-item" data-type="B-" data-distance="12.3">
                            <div class="request-info">
                                <h3>Childbirth - Type B-</h3>
                                <p>Asian Hospital - Needed by 05/18/2023</p>
                                <p><i class="fas fa-baby"></i> Surgery Type: Emergency C-Section</p>
                                <p>Distance: 12.3 km from you</p>
                            </div>
                            <div class="request-actions">
                                <button class="btn btn-primary btn-sm accept-request">Accept</button>
                                <button class="btn btn-outline btn-sm view-details">Details</button>
                            </div>
                        </li>
                        <li class="request-item" data-type="O-" data-distance="16.3">
                            <div class="request-info">
                                <h3>Car Accident - Type O-</h3>
                                <p>Philippine General Hospital - Needed by 04/06/2023</p>
                                <p><i class="fas fa-radiation"></i> Surgery Type: Hemorrhage Removal</p>
                                <p>Distance: 16.3 km from you</p>
                            </div>
                            <div class="request-actions">
                                <button class="btn btn-primary btn-sm accept-request">Accept</button>
                                <button class="btn btn-outline btn-sm view-details">Details</button>
                            </div>
                        </li>
                    </ul>
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
                    <form id="profileForm">
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" id="fullName" class="form-control" value="Juan Dela Cruz" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" value="juan.delacruz@gmail.com" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" class="form-control" value="+63 912 345 6789" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" class="form-control" rows="2">123 Rizal Avenue, Manila, Philippines</textarea>
                        </div>
                        <div class="form-group">
                            <label for="bloodTypeProfile">Blood Type</label>
                            <select id="bloodTypeProfile" class="form-control" disabled>
                                <option value="O+">O+</option>
                                <option value="A+">A+</option>
                                <option value="B+">B+</option>
                                <option value="AB+">AB+</option>
                                <option value="O-">O-</option>
                                <option value="A-">A-</option>
                                <option value="B-">B-</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Profile</button>
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
            </section>
        </div>

    <!-- Modals -->
    <!-- Appointment Details Modal -->
    <div class="modal" id="appointmentDetailsModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Appointment Details</h2>
            <div class="appointment-details">
                <p><strong>Status:</strong> <span id="appointmentStatus">Pending Approval</span></p>
                <p><strong>Date:</strong> <span id="appointmentDate">Not scheduled yet</span></p>
                <p><strong>Time:</strong> <span id="appointmentTime">Not selected yet</span></p>
                <p><strong>Location:</strong> <span id="appointmentLocation">Not selected yet</span></p>
                <p><strong>Blood Type:</strong> <span id="appointmentBloodType">Not specified</span></p>
                <p><strong>Notes:</strong> <span id="appointmentNotes">No additional notes provided.</span></p>
            </div>
            <div class="modal-actions" style="margin-top: 1.2rem;">
            <button class="btn btn-primary" id="editAppointment">Edit Appointment</button>
            <button class="btn btn-outline" style="margin-left: 0.5rem;" id="cancelAppointment">Cancel Appointment</button>
            </div>
        </div>
    </div>    

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

    <script src="donor-wp.js"></script>
</body>
</html>