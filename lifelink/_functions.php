<?php

session_start();

function connect(){
    $conn = new mysqli('localhost','root','','blood_finder_app');
    return $conn;
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

function getDonorInfoJSON() {
    $conn = connect();
    $sql = $conn->query("SELECT * FROM donor_info");

    if($sql->num_rows === 0) {
        return;
    }
    else {
        while($row = $sql->fetch_assoc()) {
            $donors[] = $row;
        }
        $output = json_encode($donors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents("_donor_list.json", $output);
    }
}

function getHospitalList() {
    $conn = connect();
    $hospital_info = "SELECT `id`, `name` FROM hospital_info";
    $get_hospital_info = $conn->query($hospital_info);
    while($row = $get_hospital_info->fetch_assoc()) {
        echo "<option value='". $row['id'] . "'>" . $row['name'] . "</option>";
    }
}

function getDonorRequests($sess_id) {
    $conn = connect();
    $session_rqs = "SELECT * FROM blood_requests where requested_donor='$sess_id'";
    $get_sess_rqs = $conn->query($session_rqs);
    if($get_sess_rqs->num_rows === 0) {
        echo "<p>No blood requests yet.</p>";
    }
    while($row = $get_sess_rqs->fetch_assoc()) {
        echo "
        <li class='request-item' data-type='A-' data-distance='5.7'" . ($row['urgent'] == 1 ? "data-urgency='urgent'" : '') . ">
            <div class='request-info'>
                <h3>" . $row['request_description'] . "</h3>
                <p>" . $row['healthcare_institution'] . " - Needed by " . $row['date_needed'] . "</p>
                <p>Requested by: " . $row['name'] . "</p>
                <p>Distance: insert km from you</p>
                <p>Contact Information: " . $row['contact'] . "</p>" .
                ($row['urgent'] == 1 ? "<p class='urgent-tag' style='color: var(--primary-dark); font-weight: bold;'>URGENT</p>" : '') .    
            "</div>
            <div class='request-actions'>
                <button class='btn btn-primary btn-sm accept-request'>Accept</button>
                <button class='btn btn-outline btn-sm view-details'>Details</button>
            </div>
        </li>";
    }
}

function getUrgentRequests($sess_id) {
    // need pa filter closest
    $conn = connect();
    $urgent_rqs = "SELECT * FROM blood_requests where requested_donor='$sess_id' AND urgent=1 LIMIT 2";
    $get_urgent_rqs = $conn->query($urgent_rqs);
    if($get_urgent_rqs->num_rows === 0) {
        echo "<p>No Urgent Requests Yet.</p>";
    }
    $count = 0;
    while($row = $get_urgent_rqs->fetch_assoc()) {
        // tbc data-type && data-distance
        echo "
        <li class='request-item' data-type='A-' data-distance='5.7' data-urgency='urgent'>
            <div class='request-info'>
                <h3>" . $row['request_description'] . "</h3>
                <p>" . $row['healthcare_institution'] . " - Needed by [insert date]</p>
                <p>Requested by: " . $row['name'] . "</p>
                <p>Distance: ___ km from you.</p>
                <p>Contact Information: " . $row['contact'] . "</p>
                <p class='urgent-tag' style='color: var(--primary-dark); font-weight: bold;'>URGENT</p>    
            </div>
            <div class='request-actions'>
                <button class='btn btn-primary btn-sm accept-request'>Accept</button>
                <button class='btn btn-outline btn-sm view-details'>Details</button>
            </div>
        </li>";
    }
}

function getMostRecentAppointment($sess_id) {
    $conn = connect();
    $most_recept_appt = "SELECT * FROM donation_appointments WHERE donor_id='$sess_id' ORDER BY donation_id DESC LIMIT 1";
    $get = $conn->query($most_recept_appt);
    if($get->num_rows === 0) {
        return;
    }
    else {
        while($row = $get->fetch_assoc()) {
            $status = $row['status'];
        }
        return $status;
    }
}

?>