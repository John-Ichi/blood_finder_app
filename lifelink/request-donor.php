<?php
include '_functions.php';

$conn = connect();

$requested_donor = "";
if(isset($_GET['request'])) {
    $sql = "SELECT id FROM donor_login_info WHERE email='$_GET[request]'";
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();
    $requested_donor = $row['id'];
}

if(isset($_POST['submit_request'])) {
    $sql = "INSERT INTO blood_requests
    (`requested_donor`,
    `name`,
    `contact`,
    `request_description`,
    `urgent`,
    `healthcare_institution`,
    `date_needed`)
    VALUES
    ('$requested_donor',
    ' $_POST[rq_name]',
    '$_POST[rq_contact]',
    '$_POST[rq_desc]',
    '$_POST[urgent]',
    '$_POST[rq_loc]',
    '$_POST[date]')";

    $rs = $conn->query($sql);
    header('Location: donors.php');
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
        Contact: <br><input type="text" name="rq_contact" placeholder="Enter your contact number..." required><br>
        Date Needed: <br><input type="date" name="date" required><br>
        Request Description:
        <br><textarea name="rq_desc" placeholder="Briefly describe your request..."></textarea><br>
        <input type="checkbox" name="urgent" value="1">Mark as URGENT <br>
        Select affiliated healthcare institution:
        <br><select name="rq_loc">
            <option value="" selected disabled style="display: none;"></option>
            <option value="dummy hospital">dummy hospital</option>
        </select><br>
        <button type="submit" name="submit_request">Submit Request</button>
    </form>
    <a href="donors.php">Return to donors</a>
    
</body>
</html>