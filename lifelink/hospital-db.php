<?php
include '_functions.php';

session_start();
$conn = connect();

$current_session = $_SESSION['hospital_email'];

if(!$current_session) {
    header('Location: donor-login.php');
}

$session_id = "SELECT id FROM hospital_login_info WHERE email='$current_session'";
$get_sess_id = $conn->query($session_id);
$sess_id;

while($row = $get_sess_id->fetch_assoc()) {
    $sess_id = $row['id'];
    
}

$hospital_name;
$hospital_address;
$stockAp;
$stockAn;
$stockBp; 
$stockBn;
$stockABp;
$stockABn;
$stockOp;
$stockOn;

$session_info = "SELECT * FROM hospital_info WHERE id='$sess_id'";
$check_sess_info = $conn->query($session_info);
if($check_sess_info->num_rows === 0) {
    header('Location: hospital-info.php'); // complete details
}
else {
    while($row = $check_sess_info->fetch_assoc()) {
        $hospital_name = $row['name'];
        $hospital_address = $row['address'];
        $stockAp = $row['a_positive_stock'];
        $stockAn = $row['a_negative_stock'];
        $stockBp = $row['b_positive_stock'];
        $stockBn = $row['b_negative_stock'];
        $stockABp = $row['ab_positive_stock'];
        $stockABn = $row['ab_negative_stock'];
        $stockOp = $row['o_positive_stock'];
        $stockOn = $row['o_negative_stock'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <?php
    echo "<h1>" . $hospital_name . "</h1>";
    echo "<h2>" . $hospital_address . "</h2>";
    ?>
    <button>Update Stocks</button>
    <table>
        <tr>
            <th>Blood Type</th>
            <th>Quantity</th>
            <th></th>
        </tr>
        <tr>
            <td>A+</td>
            <td><?php echo $stockAp?></td>
        </tr>
        <tr>
            <td>A-</td>
            <td><?php echo $stockAn?></td>
        </tr>
        <tr>
            <td>B+</td>
            <td><?php echo $stockBp?></td>
        </tr>
        <tr>
            <td>B-</td>
            <td><?php echo $stockBn?></td>
        </tr>
        <tr>
            <td>AB+</td>
            <td><?php echo $stockABp?></td>
        </tr>
        <tr>
            <td>AB-</td>
            <td><?php echo $stockABn?></td>
        </tr>
        <tr>
            <td>O+</td>
            <td><?php echo $stockOp?></td>
        </tr>
        <tr>
            <td>O-</td>
            <td><?php echo $stockOn?></td>
        </tr>
    </table>
    <br><a href="">Donor Appointments</a>
    <br><a href="logout.php">Logout</a>
</body>
</html>