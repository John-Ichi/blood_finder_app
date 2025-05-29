<?php
include '_functions.php';
$conn = connect();

if(isset($_GET['approve'])) {
    $approve_appt = "UPDATE donation_appointments
    SET status='Approved'
    WHERE donation_id='$_GET[donation_id]'";

    $update_appt = $conn->query($approve_appt);

    header('Location: hospital-db.php');
}

if(isset($_GET['complete'])) {
    $id = $_GET['donation_id'];

    $sql = "UPDATE donation_appointments
    SET status='Completed'
    WHERE donation_id='$id'";

    $rs = $conn->query($sql);

    $sql = "SELECT donor_id, hospital_id FROM donation_appointments WHERE donation_id='$id'";
    $rs = $conn->query($sql);
    
    $donor_id;
    $hospital_id;

    while($row = $rs->fetch_assoc()) {
        $donor_id = $row['donor_id'];
        $hospital_id = $row['hospital_id'];
    }

    $sql =
        "INSERT INTO donation_history
        (`donation_id`, `donor_id`, `hospital_id`)
        VALUES
        ('$id','$donor_id','$hospital_id')";

    $rs = $conn->query($sql);

    $sql = "SELECT date_completed FROM donation_history WHERE donor_id='$donor_id' ORDER BY history_id DESC LIMIT 1";
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();

    header('Location: hospital-db.php');
}
?>