<?php
include '_functions.php';
$conn = connect();

$current_session = $_SESSION['donor_email'];

if(!$current_session) {
    header('Location: home.php');
}

$session_id = "SELECT id FROM donor_login_info WHERE email='$current_session'";
$get_sess_id = $conn->query($session_id);
$sess_id = "";
while($row = $get_sess_id->fetch_assoc()) {
    $sess_id = $row['id']; // get id of donor
}

$rs = $conn->query("SELECT * FROM donor_info WHERE donor_id='$sess_id'");
if($rs->num_rows > 0) {
    header('Location: donor-db.php');
}

if(isset($_POST['submit'])) {
    $sql = "INSERT INTO
    donor_info (`donor_id`,`name`,`blood_type`,`address`,`contact`)
    VALUES ('$sess_id','$_POST[name]','$_POST[blood_type]','$_POST[address]','$_POST[contact]')";
    $rs = $conn->query($sql);
    header('Location: donor-db.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <h1>Complete your details</h1><br>
        Name <br><input type="text" name="name"><br>
        Blood Type <br>
        <select name="blood_type" required>
            <option value="" selected>Select blood type</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
        </select><br>
        Address <br><input type="text" name="address" placeholder="e.g. Naic, Cavite"><br>
        Contact <br><input type="text" name="contact"><br>
        <button type="submit" name="submit">Submit</button>
    </form>
    <a href="_logout.php">Logout</a>
</body>
</html>