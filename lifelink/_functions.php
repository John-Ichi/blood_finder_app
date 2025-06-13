<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'johnichiro.mananquil@gmail.com';
$mail->Password   = 'rymk licv rxna awlq';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port       = 465;

$lifelink_email = $mail->Username;

function connect(){
    $conn = new mysqli('localhost','root','','blood_finder_app');
    return $conn;
}

// Hospital-db functions
if (isset($_GET['logoutBB']) && $_GET['logoutBB'] == true) { // Logout hospital
    unset($_SESSION['hospital_email']);
    header('Location: hospital-login.php');
}

if (isset($_GET['approveAppointment']) && $_GET['approveAppointment'] == true) { // Approve appointment
    $conn = connect();
    $sql =
        "UPDATE donation_appointments
        SET status='Approved'
        WHERE donation_id='$_GET[donation_id]'";
    $rs = $conn->query($sql);

    echo "
        <script>
            alert('Appointment approved!');
            window.location.href = 'hospital-db.php';
        </script>
    ";
}

if (isset($_GET['declineAppointment']) && $_GET['declineAppointment'] == true) { // Decline appointment
    $conn = connect();
    $sql =
        "DELETE FROM donation_appointments
        WHERE donation_id='$_GET[donation_id]'";
    $rs = $conn->query($sql);

    $mail->setFrom($mail->Username);
    $mail->addAddress($_GET['email']);
    $mail->Subject = 'Donation Appointment';
    $mail->Body =
        "Your donation appointment request to " . $_GET['name'] . " has been declined.
        
        Best regards, LifeLink Team";
    $mail->send();

    header('Location: hospital-db.php');
}

if (isset($_POST['finalizeAppointment'])) { // Finalize appointment
    $conn = connect();
    $donation_id = $_POST['donation_id'];
    $hospital_id = $_POST['hospital_id'];
    $donor_id = $_POST['donor_id'];
    $donation_datetime = $_POST['extraction_datetime'];

    $sql = // Update appointment
        "UPDATE donation_appointments
        SET status='Completed'
        WHERE donation_id='$donation_id'";
    $rs = $conn->query($sql);

    $sql = // Update history
        "INSERT INTO donation_history
        (`donation_id`,`donor_id`,`hospital_id`,`extraction_datetime`,`component`,`units_collected`)
        VALUES
        ('$donation_id','$donor_id','$hospital_id','$donation_datetime','$_POST[blood_component]','$_POST[units]')";
    $rs = $conn->query($sql);

    $date_obj = new DateTime($donation_datetime);
    $date_add = date_add($date_obj, date_interval_create_from_date_string("42 days"));
    $next_available = $date_add->format("Y-m-d H:i:s");

    $sql = // Update last donation/next available donor
        "UPDATE donor_info
        SET next_available='$next_available'
        WHERE donor_id='$donor_id'";
    $rs = $conn->query($sql);

    header('Location: hospital-db.php');
}

if (isset($_GET['cancelAppointmentBB']) && $_GET['cancelAppointmentBB'] == true) { // Cancel appointment
    $conn = connect();
    $sql =
        "DELETE FROM donation_appointments
        WHERE donation_id='$_GET[donation_id]'";
    $rs = $conn->query($sql);

    $mail->setFrom($mail->Username);
    $mail->addAddress($_GET['email']);
    $mail->Subject = 'Donation Appointment';
    $mail->Body =
        "Your donation appointment to " . $_GET['name'] . " has been cancelled.
        
        Best regards, LifeLink Team";
    $mail->send();

    echo "
        <script>
            alert('Appointment cancelled!');
            window.location.href = 'hospital-db.php';
        </script>
    ";
}

// Donor-db functions
if (isset($_GET['logoutDonor']) && $_GET['logoutDonor'] == true) { // Logout donor
    unset($_SESSION['donor_email']);
    header('Location: index.php');
}


if (isset($_GET['cancelAppointmentDonor']) && $_GET['cancelAppointmentDonor'] == true) {
    $conn = connect();
    $sql =
        "DELETE FROM donation_appointments
        WHERE donation_id='$_GET[donation_id]'";
    $rs = $conn->query($sql);

    echo "
        <script>
            alert('appointment cancelled');
            window.location.href = 'donor-db.php';
        </script>
    ";
}

if (isset($_GET['hide_history_id'])) {
    $conn = connect();
    $sql =
        "UPDATE donation_history
        SET hidden=1
        WHERE history_id='$_GET[hide_history_id]'";
    $rs = $conn->query($sql);

    header('Location: hospital-db.php');
}

if (isset($_POST['acceptBloodRequest'])) {
    $mail->setFrom('johnichiro.mananquil@gmail.com');
    $mail->addAddress($_POST['requestContact']);
    $mail->Subject = 'Blood Donor Request';
    $mail->Body =
        "Your request from " . $_POST['donorName'] . " has been accepted.
        
        Best regards, LifeLink Team";
    $mail->send();

    $conn = connect();
    $sql =
        "UPDATE blood_requests
        SET status='Accepted'
        WHERE request_id='$_POST[requestId]'";
    $rs = $conn->query($sql);

    echo "
    <script>
        alert('Requester has been notified of your acceptance via email. Please refer to their contact number ASAP.')
        window.location.href = 'donor-db.php';
    </script>";
}

if (isset($_POST['declineBloodRequest'])) {
    $mail->setFrom($mail->Username);
    $mail->addAddress($_POST['requestContact']);
    $mail->Subject = 'LifeLink Blood Request';
    $mail->Body =
        "Your request for blood from " . $_POST['donorName'] . " has been declined.
        
        Best regards, LifeLink Team";
    $mail->send();

    $conn = connect();
    $sql =
        "DELETE FROM blood_requests
        WHERE request_id='$_POST[requestId]'";
    $rs = $conn->query($sql);

    echo "
    <script>
        alert('Requester has been notified of your declination via email.')
        window.location.href = 'donor-db.php';
    </script>";
}

if (isset($_POST['cancelBloodRequest'])) {
    $mail->setFrom($mail->Username);
    $mail->addAddress($_POST['requestContact']);
    $mail->Subject = 'Blood Donor Request';
    $mail->Body =
        "Your request from " . $_POST['donorName'] . " has been cancelled.
        
        Best regards, LifeLink Team";
    $mail->send();
    
    $conn = connect();
    $sql =
        "DELETE FROM blood_requests
        WHERE request_id='$_POST[requestId]'";
    $rs = $conn->query($sql);

    echo "
    <script>
        alert('Requester has been notified of your cancellation via email.')
        window.location.href = 'donor-db.php';
    </script>";
}

if (isset($_POST['completeBloodRequest'])) {
    $conn = connect();
    $donor_id = $_POST['donorId'];
    $donation_date = $_POST['date'];

    // Update request status
    $sql =
        "UPDATE blood_requests
        SET status='Done'
        WHERE request_id='$_POST[requestId]'";
    $rs = $conn->query($sql);

    // Insert donation history
    $date = date_create($donation_date);
    $sql =
        "INSERT INTO donation_history
        (`request_id`,`donor_id`,`extraction_datetime`)
        VALUES
        ('$_POST[requestId]','$donor_id','$donation_date')";
    $rs = $conn->query($sql);

    // Update next available
    $next_date = date_add($date, date_interval_create_from_date_string("43 days"));
    $next_available = $next_date->format('Y-m-d');
    $sql =
        "UPDATE donor_info
        SET available=0, next_available='$next_available'
        WHERE donor_id='$donor_id'";
    $rs = $conn->query($sql);

    echo "
        <script>
            alert('Donation marked as done!');
            window.location.href = 'donor-db.php';
        </script>
    ";
}

if (isset($_POST['sendmail'])) {
    $mail->setFrom($mail->Username);
    $mail->addAddress($_POST['blood_bank_email']);
    $mail->Subject = 'LifeLink Blood Contact';
    $mail->Body =
        "A message from " . $_POST['name'] . ":
        " . $_POST['message'] . "
        Contact information: 
        " .
        $_POST['email'] . "
        " . $_POST['number'] . "
        Regards, LifeLink Team";
    $mail->send();

    echo "
        <script>
            alert('Email sent! Please refer to the blood bank phone number for anything urgent. Thank you!');
            window.location.href = 'bloodbanks.php';
        </script>
    ";
}

if (isset($_POST['deleteBloodRequest'])) {
    $conn = connect();
    $sql =
        "DELETE FROM blood_requests
        WHERE request_id='$_POST[requestId]'";
    $rs = $conn->query($sql);

    header('Location: donor-db.php');
}

if (isset($_POST['archiveBloodRequest'])) {
    $conn = connect();
    $sql =
        "UPDATE blood_requests
        SET archived=1
        WHERE request_id='$_POST[requestId]'";
    $rs = $conn->query($sql);

    header('Location: donor-db.php');
}

function updateAvailablity() {
    $conn = connect();
    $today = date("Y-m-d");
    $sql = $conn->query("SELECT next_available FROM donor_info");
    while($row = $sql->fetch_assoc()) {
        $next_available = $row['next_available'];
        if($next_available === $today) {
            $update = $conn->query("UPDATE donor_info SET available=1 WHERE next_available='$next_available'");
        }
        if($next_available <= $today) {
            $update = $conn->query("UPDATE donor_info SET next_available='$today' WHERE next_available='$next_available'");
        }
        if($next_available > $today) {
            $update = $conn->query("UPDATE donor_info SET available=0 WHERE next_available='$next_available'");
        }
    }
}

function updateRequests() {
    $conn = connect();
    $today = date("Y-m-d");
    $rs = $conn->query("SELECT date_needed FROM blood_requests");
    while($row = $rs->fetch_assoc()) {
        $date_needed = $row['date_needed'];
        if ($date_needed < $today) {
            $update = $conn->query("UPDATE blood_requests SET status='Expired' WHERE date_needed='$date_needed'");
        }
    }
}

function getDonorInfoJSON() {
    $conn = connect();

    $sql = 
        "SELECT donor_login_info.email, donation_history.extraction_datetime, donor_info.*
        FROM donor_login_info
        RIGHT JOIN donor_info
        ON donor_info.donor_id = donor_login_info.id
        LEFT JOIN donation_history
        ON donor_info.donor_id = donation_history.donor_id
        ORDER BY next_available ASC";

    $rs = $conn->query($sql);

    if ($rs->num_rows === 0) {
        $output = json_encode(null);
        
    } else {
        while($row = $rs->fetch_assoc()) {
            $donors[] = $row;
        }
        $output = json_encode($donors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    file_put_contents("_donor_list.json", $output);
}

function getBloodBankInfoJSON() {
    $conn = connect();

    $sql =
        "SELECT hospital_login_info.email, hospital_info.*
        FROM hospital_info
        LEFT JOIN hospital_login_info
        ON hospital_info.id = hospital_login_info.id";
    $rs = $conn->query($sql);

    if($rs->num_rows === 0) {
        $output = json_encode(null);
    }
    else {
        while($row = $rs->fetch_assoc()) {
            $bloodbanks[] = $row;
        }
        $output = json_encode($bloodbanks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    file_put_contents("_bloodbanks.json", $output);
}

function getDonationAppointments($sess_id) {
    $conn = connect();

    $sql =
        "SELECT donor_info.donor_id, donor_login_info.email, donor_info.donor_name, donor_info.blood_type, donation_appointments.*
        FROM donor_info
        RIGHT JOIN donation_appointments
        ON donation_appointments.donor_id = donor_info.donor_id
        LEFT JOIN donor_login_info
        ON donation_appointments.donor_id = donor_login_info.id
        WHERE hospital_id='$sess_id'
        ORDER BY
        status='Approved' DESC,
        date_of_donation ASC";

    $rs = $conn->query($sql);

    if ($rs->num_rows != 0) {
        while($row = $rs->fetch_assoc()) {
            $appointments[] = $row;
        }
        $output = json_encode($appointments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    } else {
        $output = json_encode(null);
    }
    file_put_contents("_appointments.json", $output);
}

function getHospitalList() {
    $conn = connect();
    $hospital_info = "SELECT `id`, `name` FROM hospital_info";
    $get_hospital_info = $conn->query($hospital_info);
    while($row = $get_hospital_info->fetch_assoc()) {
        echo "<option value='". $row['id'] . "'>" . $row['name'] . "</option>";
    }
}

function checkExpiry() {
    $conn = connect();
    $sql = "SELECT date_needed FROM blood_requests";
    $rs = $conn->query($sql);

    $today = date("Y-m-d");

    while ($row = $rs->fetch_assoc()) {
        if ($row['date_needed'] < $today) {
            $update = $conn->query("UPDATE blood_requests SET status='Expired' WHERE date_needed='$row[date_needed]'");
        }
    } 
}

function getAcceptedBloodRequest($sess_id) {
    $conn = connect();
    $sql = "SELECT status FROM blood_requests WHERE donor_id='$sess_id' AND status='Accepted'";
    $rs = $conn->query($sql);
    if ($rs->num_rows != 0) {
        $hasAcceptedARequest = true;
    } else $hasAcceptedARequest = false;
    return $hasAcceptedARequest;
}

function hasAppointment($sess_id) {
    $conn = connect();
    $sql =
        "SELECT status FROM donation_appointments
        WHERE donor_id='$sess_id' AND status='Pending'
        ORDER BY donation_id DESC LIMIT 1";
    $rs = $conn->query($sql);

    $hasAppointment = false;

    if ($rs->num_rows != 0)  $hasAppointment = true;
    
    return $hasAppointment;
}

function getDonorRequests($sess_id) {
    checkExpiry();

    $conn = connect();
    $sql =
        "SELECT donor_info.donor_name, blood_requests.*
        FROM blood_requests
        LEFT JOIN donor_info
        ON blood_requests.donor_id = donor_info.donor_id
        WHERE blood_requests.donor_id='$sess_id'
        ORDER BY status='Pending', urgent DESC, date_needed ASC";
    $rs = $conn->query($sql);
    if($rs->num_rows === 0) {
        echo "<p>No blood requests yet.</p>";
    }

    $blood_req = getAcceptedBloodRequest($sess_id);
    $hasAppointment = hasAppointment($sess_id);

    $count = 0;
    while($row = $rs->fetch_assoc()) {
        $date = date_create($row['date_needed']);
        $date_needed = date_format($date, "F j, Y");

        if ($row['status'] != 'Done') {
            $count++;
            echo "
            <li class='request-item'" . ($row['urgent'] == 1 ? "data-urgency='urgent'" : '') . ">
                <div class='request-info'>
                    <h3>" . $row['request_description'] . ($row['status'] === 'Expired' ? ' [Expired]' : '') . "</h3>
                    <p>" . $row['point_of_donation'] . " - Needed by " . $date_needed . "</p>
                    <p>Requested by: " . $row['requester_name'] . "</p>" .
                    /* <p>Distance: insert km from you</p> */
                    "<p>Contact Number: " . $row['contact_no'] . "</p>
                    <p>Contact Email: " . $row['contact_email'] . "</p>" .
                    ($row['urgent'] == 1 ? "<p class='urgent-tag' style='color: var(--primary-dark); font-weight: bold;'>URGENT</p>" : '') .    
                "</div>";
            
            if ($row['status'] === 'Pending') {
                if ($blood_req === true || $hasAppointment === true) {
                    echo "
                    <div class='request-actions'>
                        <form method='POST' action='_functions.php'>
                            <input type='text' name='requestId' value='" . $row['request_id'] . "' style='display: none;'>
                            <input type='text' name='requestContact' value='" . $row['contact_email'] . "' style='display: none;'>
                            <input type='text' name='donorName' value='" . $row['donor_name'] . "' style='display: none;'>
                            <fieldset disabled>
                            <button class='btn btn-primary btn-sm accept-request' name='acceptBloodRequest'>Accept</button>
                            <button class='btn btn-outline btn-sm decline-request' name='declineBloodRequest'>Decline</button>
                            </fieldset>
                        </form>
                    </div>
                </li>";    
                } else {
                    echo "
                    <div class='request-actions'>
                        <form method='POST' action='_functions.php'>
                            <input type='text' name='requestId' value='" . $row['request_id'] . "' style='display: none;'>
                            <input type='text' name='requestContact' value='" . $row['contact_email'] . "' style='display: none;'>
                            <input type='text' name='donorName' value='" . $row['donor_name'] . "' style='display: none;'>
                            <button class='btn btn-primary btn-sm accept-request' name='acceptBloodRequest'>Accept</button>
                            <button class='btn btn-outline btn-sm decline-request' name='declineBloodRequest'>Decline</button>
                        </form>
                    </div>
                </li>";
                }
            }
            
            if ($row['status'] === 'Accepted') {
                echo "
                <div class='request-actions'>
                    <form method='POST' action='_functions.php' id='completeForm'>
                        <input type='text' name='requestId' value='" . $row['request_id'] . "' style='display: none;'>
                        <input type='text' name='donorId' value='" . $sess_id . "' style='display: none;'>
                        <input type='text' name='date' value='" . $row['date_needed'] . "' style='display: none;'>
                        <input type='text' name='requestContact' value='" . $row['contact_email'] . "' style='display: none;'>
                        <button class='btn btn-primary btn-sm complete-request' name='completeBloodRequest'>Mark as Done</button>
                        <button class='btn btn-outline btn-sm cancel-request' name='cancelBloodRequest'>Cancel</button>
                    </form>
                </div>
            </li>";
            }

            if ($row['status'] === 'Expired') {
                echo "
                <div class='request-actions'>
                    <form method='POST' action='_functions.php' id='completeForm'>
                        <input type='text' name='requestId' value='" . $row['request_id'] . "' style='display: none;'>
                        <button class='btn btn-primary btn-sm delete-request' name='deleteBloodRequest'>Delete</button>
                    </form>
                </div>
            </li>";
            }
        } else if ($count === 0) {
            echo "<p>No pending or accepted blood requests.</p>";
        }   
    }
}

function getUrgentRequests($sess_id) {
    // need pa filter closest
    $conn = connect();
    $urgent_rqs =
        "SELECT donor_info.donor_name, blood_requests.*
        FROM blood_requests
        LEFT JOIN donor_info
        ON blood_requests.donor_id = donor_info.donor_id
        WHERE blood_requests.donor_id='$sess_id'
        AND urgent=1
        AND status='pending'
        ORDER BY date_needed ASC
        LIMIT 3";
    $get_urgent_rqs = $conn->query($urgent_rqs);

    if($get_urgent_rqs->num_rows === 0) {
        echo "<p>No Pending Urgent Requests.</p>";
    }
    while($row = $get_urgent_rqs->fetch_assoc()) {
        $date = date_create($row['date_needed']);
        $date_needed = date_format($date, "F j, Y");

        if ($row['status'] != 'Done') {
            echo "
            <li class='request-item' data-urgency='urgent'>
                <div class='request-info'>
                    <h3>" . $row['request_description'] . "</h3>
                    <p>" . $row['point_of_donation'] . " - Needed by " . $date_needed . "</p>
                    <p>Requested by: " . $row['requester_name'] . "</p>
                    <p>Contact Number: " . $row['contact_no'] . "</p>
                    <p>Contact Email: " . $row['contact_email'] ."</p>
                    <p class='urgent-tag' style='color: var(--primary-dark); font-weight: bold;'>URGENT</p>    
                </div>
                <div class='request-actions'>
                    <form method='POST' action='_functions.php'>
                        <input type='text' name='requestId' value='" . $row['request_id'] . "' style='display: none;'>
                        <input type='text' name='requestContact' value='" . $row['contact_email'] . "' style='display: none;'>
                        <input type='text' name='donorName' value='" . $row['donor_name'] . "' style='display: none;'>
                        <button class='btn btn-primary btn-sm accept-request' name='acceptBloodRequest'>Accept</button>
                        <button class='btn btn-outline btn-sm decline-request' name='declineBloodRequest'>Decline</button>
                    </form>
                </div>
            </li>";
        }
    }
}

function getRecentAppointmentDetails($sess_id) {
    $conn = connect();
    $sql =
        "SELECT hospital_info.name, hospital_info.contact, donation_appointments.*
        FROM donation_appointments
        LEFT JOIN hospital_info
        ON donation_appointments.hospital_id = hospital_info.id
        WHERE donor_id='$sess_id'
        ORDER BY donation_id
        DESC LIMIT 1";
    $get = $conn->query($sql);
    if($get->num_rows === 0) {
        return;
    } else {
        while($row = $get->fetch_assoc()) {
            $appt[] = $row; 
        }
        return $appt;
    }
}

function getSessionInfo($sess_id) {
    $conn = connect();
    $sql = "SELECT * FROM donor_info WHERE donor_id='$sess_id'";
    $get = $conn->query($sql);
    if($get->num_rows === 0) { // if wala pang details e.g. after account creation
        header('Location: donor-info.php'); // complete details
        return;
    } else {
        while($row = $get->fetch_assoc()) {
            $userinfo[] = $row;
        }
        return $userinfo;
    }
}

function getHospitalDBDonationHistory($sess_id) {
    $conn = connect();
    $sql =
        "SELECT
            donor_info.donor_name,
            donor_info.blood_type,
            donation_history.*
        FROM donation_history
        LEFT JOIN donor_info
        ON donation_history.donor_id = donor_info.donor_id
        WHERE hospital_id='$sess_id' OR donation_id != null
        ORDER BY hidden, extraction_datetime DESC";
    $rs = $conn->query($sql);
    
    if ($rs->num_rows != 0) {
        while($row = $rs->fetch_assoc()) {
            $bbhistory[] = $row;
        }
        $output = json_encode($bbhistory, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    } else {
        $output = json_encode(null);
    }
    file_put_contents("_blood-bank-history.json", $output);
}

function getDonorDBDonationHistory($sess_id) {
    $conn = connect();
    $sql =
        "SELECT
            hospital_info.name,
            donation_history.*,
            blood_requests.date_needed,
            blood_requests.requester_name,
            blood_requests.point_of_donation
        FROM hospital_info
        RIGHT JOIN donation_history
        ON donation_history.hospital_id = hospital_info.id
        LEFT JOIN blood_requests
        ON donation_history.request_id = blood_requests.request_id
        WHERE donation_history.donor_id='$sess_id'
        ORDER BY extraction_datetime DESC";
    $rs = $conn->query($sql);
    if ($rs->num_rows != 0) {
        while($row = $rs->fetch_assoc()) {

            if ($row['request_id'] === null) { // by donation
                $completion_datetime = date_create($row['extraction_datetime']);
                $date = date_format($completion_datetime, "F j, Y");
                $time = date_format($completion_datetime, "h:i:s A");

                echo "
                    <li class='request-item'>
                        <div class='request-info'>
                            <h3>" . $date . "</h3>
                            <p><i class='fas fa-map-marker-alt'></i> " . $row['name'] . "</p>
                            <p><i class='fas fa-tint'></i> Component Extracted: " . $row['component'] . "</p>
                            <p><i class='fas fa-tint'></i> Units Collected: " . $row['units_collected'] . "</p>
                            <p><i class='fas fa-clock'></i> Time of Extraction: " . $time . "</p>
                        </div>
                    </li>
                ";
            } else if ($row['donation_id'] === null) { // by request
                $date = date_create($row['date_needed']);
                $date_format = date_format($date, 'F j, Y');
                echo "
                    <li class='request-item'>
                        <div class='request-info'>
                            <h3>" . $date_format . "</h3>
                            <p><i class='fas fa-map-marker-alt'></i> Location: " . $row['point_of_donation'] . "</p>
                            <p><i class='fas fa-user'></i> Donated to: " . $row['requester_name'] . "</p>
                        </div>
                    </li>
                ";
            }
        }
    } else {
        echo "<p>No donation records yet.</p>";
    }
}

function getRecentDonation($sess_id) {
    $conn = connect();

    $sql =
        "SELECT blood_requests.date_needed, blood_requests.point_of_donation, donation_history.*
        FROM donation_history
        LEFT JOIN blood_requests
        ON donation_history.request_id = blood_requests.request_id
        WHERE donation_history.donor_id='$sess_id'
        ORDER BY history_id DESC
        LIMIT 1";
    
    $rs = $conn->query($sql);

    if ($rs->num_rows != 0) {
        while ($row = $rs->fetch_assoc()) {
            $recent_donation[] = $row;
        }
        return $recent_donation;
    } else {
        return;
    }
}

?>