<?php
include '_functions.php';
$conn = connect();

date_default_timezone_set('Asia/Manila');

if (isset($_GET['decline'])) {
    $sql =
        "DELETE FROM donation_appointments
        WHERE donation_id='$_GET[donation_id]'";
    $rs = $conn->query($sql);

    header('Location: hospital-db.php');
}

if(isset($_GET['cancel'])) {
    $sql =
        "DELETE FROM donation_appointments
        WHERE donation_id='$_GET[donation_id]'";
    $rs = $conn->query($sql);

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

if(isset($_POST['complete'])) {
    $donation_id = $_POST['donation_id'];
    $hospital_id = $_POST['hospital_id'];
    $donor_id = $_POST['donor_id'];
    $donation_datetime = $_POST['extraction_datetime'];

    // update appointment status
    $sql =
        "UPDATE donation_appointments
        SET status='Completed'
        WHERE donation_id='$donation_id'";

    $rs = $conn->query($sql);

    // update donation history table
    $sql =
        "INSERT INTO donation_history
        (`donation_id`,`donor_id`,`hospital_id`,`extraction_datetime`,`component`,`units_collected`)
        VALUES
        ('$donation_id','$donor_id','$hospital_id','$donation_datetime','$_POST[blood_component]','$_POST[units]')";

    $rs = $conn->query($sql);

    // update last donation/next available donor
    $date_obj = new DateTime($donation_datetime);
    $date_add = date_add($date_obj, date_interval_create_from_date_string("42 days"));
    $next_available = $date_add->format("Y-m-d H:i:s");

    $sql =
        "UPDATE donor_info
        SET next_available='$next_available'
        WHERE donor_id='$donor_id'";
    
    $rs = $conn->query($sql);

    header('Location: hospital-db.php');
}
?>