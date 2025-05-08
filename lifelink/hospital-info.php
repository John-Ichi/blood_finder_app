<?php
include '_functions.php';
$conn = connect();

session_start();

$current_session = $_SESSION['hospital_email'];

if(!$current_session) {
    header('Location: donor-login.php');
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
    $stockAp = $_POST['a_positive_stock'];
    $stockAn = $_POST['a_negative_stock'];
    $stockBp = $_POST['b_positive_stock'];
    $stockBn = $_POST['b_negative_stock'];
    $stockABp = $_POST['ab_positive_stock'];
    $stockABn = $_POST['ab_negative_stock'];
    $stockOp = $_POST['o_positive_stock'];
    $stockOn = $_POST['o_negative_stock'];
    
    $sql = "INSERT INTO hospital_info
    (`id`,
    `name`,
    `address`,
    `a_positive_stock`,
    `a_negative_stock`,
    `b_positive_stock`,
    `b_negative_stock`,
    `ab_positive_stock`,
    `ab_negative_stock`,
    `o_positive_stock`,
    `o_negative_stock`)
    VALUES
    ('$sess_id',
    '$name',
    '$address',
    '$stockAp',
    '$stockAn',
    '$stockBp',
    '$stockBn',
    '$stockABp',
    '$stockABn',
    '$stockOp',
    '$stockOn')";

    $rs = $conn->query($sql);
    header('Location: hospital-dashboard.php');
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
        A+ Stock:
        <br><input type="text" name="a_positive_stock"><br>
        A- Stock:
        <br><input type="text" name="a_negative_stock"><br>
        B+ Stock:
        <br><input type="text" name="b_positive_stock"><br>
        B- Stock:
        <br><input type="text" name="b_negative_stock"><br>
        AB+ Stock:
        <br><input type="text" name="ab_positive_stock"><br>
        AB- Stock:
        <br><input type="text" name="ab_negative_stock"><br>
        O+ Stock:
        <br><input type="text" name="o_positive_stock"><br>
        O- Stock:
        <br><input type="text" name="o_negative_stock"><br>
        <button type="submit" name="submit">Confirm</button>
    </form>
</body>
</html>