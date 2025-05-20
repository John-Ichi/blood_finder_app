<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include 'connect.php';

    $current_session = $_SESSION['email'];

    if(!$current_session) {
        echo "<script>alert('Please Log In')</script>";
        header('Location: login.php');
    }
    else {
        $rs = $conn->query("SELECT * FROM donor_info WHERE email='$current_session'");
        if($rs->num_rows === 0) {
            header('Location: user-info.php');
        }
        else {
            while($row = $rs->fetch_assoc()) {
                echo $row['name'];
            }
        }
    }

    ?>

    <a href="logout.php"><button>Logout</button></a>
</body>
</html>