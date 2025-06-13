<?php
include '_functions.php';
$conn = connect();

if (isset($_GET['request'])) {
    $sql =
        "SELECT id, email
        FROM donor_login_info
        WHERE email='$_GET[request]'";
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();
    $requested_donor = $row['id'];
    $requested_donor_email = $row['email'];
}

if ($requested_donor === '' || $requested_donor_email === '') {
    header('Location: donors.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeLink</title>
    <link rel="stylesheet" href="css/_request-donor.css">
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

        <fieldset style="display: none;">
            <input type="text" name="requested_donor" value="<?php echo $requested_donor?>">
            <input type="text" name="requested_donor_email" value="<?php echo $requested_donor_email?>">            
        </fieldset>

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
            <input type="text" name="rq_number" id="rq_number" placeholder="Enter your phone number..." required>
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

        <div class="form-field">
            <label for="rq_loc">
                <i class="fas fa-hospital"></i>
                Select Affiliated Healthcare Institution (Leave Blank if None): <!-- For Later -->
            </label>
            <select name="rq_loc" id="rq_loc" disabled>
                <option value="" selected></option>
                <?php getHospitalList(); ?>
            </select>
        </div>

        <div class="form-field">
            <label for="point_of_donation">
                <i class="fas fa-map-marker-alt"></i>
                Point of Donation:
            </label>
            <input type="text" name="point_of_donation" id="point_of_donation" placeholder="Where should the donor go to donate?" required>
        </div>

        <div class="checkbox-container">
            <input type="checkbox" name="urgent" id="urgent" value="1">
            <label for="urgent">Mark as URGENT</label>
        </div>

        <button type="submit" name="submit_request">Submit Request</button>
        <a href="donors.php">Return to donors</a>
    </form>

</body>
</html>