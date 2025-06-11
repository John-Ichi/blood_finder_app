<?php
include '_functions.php';
$conn = connect();

$today = date("Y-m-d");
echo $today;

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
    <title>Complete Information</title>
</head>
<body>
    <form method="POST">
        Name:
        <br><input type="text" name="name"><br>
        Address:
        <br><input type="text" name="address"><br>
        Contact:
        <br><input type="text" name="contact"><br>
        <button type="submit" name="submit">Confirm</button>
    </form>
                <form method="GET" action="_functions.php">
                    <input type="text" name="logoutBB" value="true" style="display: none;">
                    <button class="btn btn-primary" id="confirmLogout">Yes, Log Out</button>
                    <button class="btn btn-outline" style="margin-left: 0.5rem;" id="cancelLogout">Cancel</button>
                </form>
</body>
</html>
