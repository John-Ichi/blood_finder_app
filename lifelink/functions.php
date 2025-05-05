<?php

function connect(){
    $conn = new mysqli('localhost','root','','blood_finder_app');
    return $conn;
}

function updateAvailablity() {
    $conn = connect();
    $today = date("Y-m-d");
    $sql = $conn->query("SELECT next_available FROM donor_info");
    while($row = $sql->fetch_assoc()) {
        $next_available = $row['next_available'];
        if($next_available === $today) {
            $update = $conn->query("UPDATE donor_info SET available=1 WHERE next_available='$next_available'");
        }
        if($next_available <= $today) {
            $update = $conn->query("UPDATE donor_info SET next_available='$today' WHERE next_available='$next_available'");
        }
        if($next_available > $today) {
            $update = $conn->query("UPDATE donor_info SET available=0 WHERE next_available='$next_available'");
        }
    }
}

function getDonorInfoJSON() {
    $conn = connect();
    $sql = $conn->query("SELECT * FROM donor_info");

    if($sql->num_rows === 0) {
        return;
    }
    else {
        while($row = $sql->fetch_assoc()) {
            $donors[] = $row;
        }
        $output = json_encode($donors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents("_donor_list.json", $output);
    }
}

?>