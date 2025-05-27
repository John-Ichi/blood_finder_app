<?php
include '_functions.php';
$conn = connect();

if(isset($_GET['approve'])) {
    $sql = "UPDATE donation_appointments
    SET status='approved'
    WHERE donation_id='$_GET[donation_id]'";

    $rs = $conn->query($sql);

    header('Location: hospital-db.php');
}

if(isset($_GET['complete'])) {
    $sql = "UPDATE donation_appointments
    SET status='completed'
    WHERE donation_id='$_GET[donation_id]'";

    $rs = $conn->query($sql);

    header('Location: hospital-db.php');
}
?>