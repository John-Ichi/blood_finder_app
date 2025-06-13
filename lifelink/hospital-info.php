<?php
include '_functions.php';
$conn = connect();

$current_session = $_SESSION['hospital_email'];

if(!$current_session) {
    header('Location: hospital-login.php');
}

$session_id = "SELECT id FROM hospital_login_info WHERE email='$current_session'";
$get_sess_id = $conn->query($session_id);
$sess_id = "";
while($row = $get_sess_id->fetch_assoc()) {
    $sess_id = $row['id'];
}

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO hospital_info
    (`id`,`name`,`address`,`contact`)
    VALUES
    ('$sess_id','$name','$address','$contact')";

    $conn->query($sql);
    header('Location: hospital-db.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeLink</title>
    <link rel="icon" href="resources/heartbeat-solid.svg">
    <link rel="stylesheet" type="text/css" href="hospital-login.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
</head>
<body>
    <div class="lifelink-header">
        <img src="resources/heartbeat-solid.svg" alt="LifeLink Logo" class="lifelink-logo">
        <span class="lifelink-title">LifeLink</span>
    </div>
    <img class="wave" src="wave.svg">
    <div class="container">
        <div class="img">
            <img src="logo.svg">
        </div>
        <div class="login-content hospital-info-content">
            <form method="POST">
                <img src="surgeon-doctor.svg">
                <h2 class="title">Complete Information</h2>
                <p class="form-note">Please complete your hospital's information to help us serve you better.</p>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <div class="div">
                        <h5>Name</h5>
                        <input type="text" class="input" name="name" required>
                    </div>
                </div>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="div">
                        <h5>Address</h5>
                        <input type="text" class="input" name="address" required>
                    </div>
                </div>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="div">
                        <h5>Contact</h5>
                        <input type="text" class="input" name="contact" required>
                    </div>
                </div>
                <input type="submit" class="btn" name="submit" value="Confirm">
                <a href="_functions.php?logoutBB=true" class="btn hospital-logout" style="background:#fff;color:#e74c3c;border:1px solid #e74c3c;">Logout</a>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="hospital-login.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>