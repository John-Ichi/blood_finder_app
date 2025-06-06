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
    <link rel="icon" href="resources/heartbeat-solid.svg">
</head>
<body>

    <h1>
        Request Donor
    </h1>
    <form method="POST" autocomplete="off">
        Name: <br><input type="text" name="rq_name" placeholder="Enter your name..." required><br>
        Contact Number: <br><input type="text" name="rq_number" placeholder="09xxxxxxxxx" required><br>
        Contact Email: <br><input type="text" name="rq_email" placeholder="Enter your contact number..." required><br>
        Date Needed: <br><input type="date" name="date" required><br>
        Request Description:
        <br><textarea name="rq_desc" placeholder="Briefly describe your request..."></textarea><br>
        <input type="checkbox" name="urgent" value="1">Mark as URGENT <br>
        Select affiliated healthcare institution (leave blank if none):
        <br><select name="rq_loc">
            <option value="" selected></option>
            <?php getHospitalList(); ?>
        </select><br>
        Point of donation
        <br><input type="text" name="point_of_donation" placeholder="Where should the donor go to donate?" required><br>
        <button type="submit" name="submit_request">Submit Request</button>
    </form>
    <a href="donors.php">Return to donors</a>
    
</body>
</html>