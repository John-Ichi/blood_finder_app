<?php
include '_functions.php';

$conn = connect();

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

$requested_donor = "";
$requested_donor_email = "";

if(isset($_GET['request'])) {
    $sql = "SELECT id, email FROM donor_login_info WHERE email='$_GET[request]'";
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();
    $requested_donor = $row['id'];
    $requested_donor_email = $row['email'];
}

if ($requested_donor === '' || $requested_donor_email === '') {
    header('Location: donors.php');
}

if(isset($_POST['submit_request'])) {
    if ($_POST['rq_loc'] === '') {
        $sql =
            "INSERT INTO blood_requests
            (`donor_id`,
            `requester_name`,
            `contact_no`,
            `contact_email`,
            `request_description`,
            `urgent`,
            `point_of_donation`,
            `date_needed`)
            VALUES
            ('$requested_donor',
            ' $_POST[rq_name]',
            '$_POST[rq_number]',
            '$_POST[rq_email]',
            '$_POST[rq_desc]',
            '$_POST[urgent]',
            '$_POST[point_of_donation]',
            '$_POST[date]')";
    } else {
        $sql =
            "INSERT INTO blood_requests
            (`donor_id`,
            `requester_name`,
            `contact_no`,
            `contact_email`,
            `request_description`,
            `urgent`,
            `hospital_id`,
            `point_of_donation`,
            `date_needed`)
            VALUES
            ('$requested_donor',
            ' $_POST[rq_name]',
            '$_POST[rq_number]',
            '$_POST[rq_email]',
            '$_POST[rq_desc]',
            '$_POST[urgent]',
            '$_POST[rq_loc]',
            '$_POST[point_of_donation]',
            '$_POST[date]')";
    }

    $rs = $conn->query($sql);

    $mail->setFrom($mail->Username);
    $mail->addAddress($requested_donor_email);
    $mail->Subject = "LifeLink Blood Request";
    $mail->Body =
        "A request was made to you from " . $_POST['rq_name'] . ".
        
        Best regards, LifeLink Team";
    $mail->send();

    echo "
    <script>
        alert('The selected donor has been notified of your request via email.');
        window.location.href = 'donors.php';
    </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Donor</title>
    <link rel="stylesheet" href="request-donor.css">
    <link rel="icon" href="resources/heartbeat-solid.svg">
</head>
<body>
        <div class="header">
            <div class="header-content">
                <i class="fas fa-envelope-medical"></i>
                <h1>Request Donor</h1>
            </div>
        </div>
    
    <form method="POST" autocomplete="off">
        <div class="form-field">
            <label for="rq_name">
                <i class="fas fa-user"></i>
                Name:
            </label>
            <input type="text" name="rq_name" id="rq_name" placeholder="Enter your name..." required>
        </div>

        <div class="form-field">
            <label for="rq_number">
                <i class="fas fa-phone"></i>
                Contact Number:
            </label>
            <input type="text" name="rq_number" id="rq_number" placeholder="09xxxxxxxxx" required>
        </div>

        <div class="form-field">
            <label for="rq_email">
                <i class="fas fa-envelope"></i>
                Contact Email:
            </label>
            <input type="email" name="rq_email" id="rq_email" placeholder="Enter your email address..." required>
        </div>

        <div class="form-field">
            <label for="date">
                <i class="fas fa-calendar-alt"></i>
                Date Needed:
            </label>
            <input type="date" name="date" id="date" required>
        </div>

        <div class="form-field">
            <label for="rq_desc">
                <i class="fas fa-comment-medical"></i>
                Request Description:
            </label>
            <textarea name="rq_desc" id="rq_desc" placeholder="Briefly describe your request..."></textarea>
        </div>

        <div class="checkbox-container">
            <input type="checkbox" name="urgent" id="urgent" value="1">
            <label for="urgent">Mark as URGENT</label>
        </div>

        <div class="form-field">
            <label for="rq_loc">
                <i class="fas fa-hospital"></i>
                Select affiliated healthcare institution (leave blank if none):
            </label>
            <select name="rq_loc" id="rq_loc">
                <option value="" selected></option>
                <?php getHospitalList(); ?>
            </select>
        </div>

        <div class="form-field">
            <label for="point_of_donation">
                <i class="fas fa-map-marker-alt"></i>
                Point of donation:
            </label>
            <input type="text" name="point_of_donation" id="point_of_donation" placeholder="Where should the donor go to donate?" required>
        </div>

        <button type="submit" name="submit_request">Submit Request</button>
        <a href="donors.php">Return to donors</a>
    </form>
</body>
</html>