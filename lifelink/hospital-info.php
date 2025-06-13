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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="resources/heartbeat-solid.svg">
</head>
<body>

    <header class="header">
        <a href="#" class="logo">
            <i class="fas fa-heartbeat"></i>
            <span>LifeLink</span>
        </a>
        <div class="nav-links">
            <button id="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </div>
    </header>

    <div class="parent-container">
        <div class="form-container">
            <div class="form-header">
                <h1><i class="fas fa-hospital"></i> Complete Information</h1>
                <p>Enter your details to complete registration</p>
            </div>

            <div class="form-content">
                <form method="POST">
                    <div class="form-group">
                        <i class="fas fa-hospital-alt"></i>
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter name of blood bank or healthcare institution..." required>
                    </div>

                    <div class="form-group">
                        <i class="fas fa-map-marker-alt"></i>
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" placeholder="Enter address..." required>
                    </div>

                    <div class="form-group">
                        <i class="fas fa-phone-alt"></i>
                        <label for="contact">Contact</label>
                        <input type="text" name="contact" id="contact" placeholder="Enter contact number..." required>
                    </div>

                    <button type="submit" name="submit" id="confirmRegistration">Confirm</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal" id="logoutModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Confirm Logout</h2>
            <p>Are you sure you want to log out?</p>
            <div class="modal-actions" style="margin-top: 1.2rem;">
                <form method="GET" action="_functions.php">
                    <input type="text" name="logoutBB" value="true" style="display: none;">
                    <button class="btn btn-primary" id="confirmLogout">Yes, Log Out</button>
                    <button class="btn btn-outline" style="margin-left: 0.5rem;" id="cancelLogout">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const logoutBtn = document.getElementById('logout-btn');
        logoutBtn.addEventListener('click', function() {
            const logoutModal = document.getElementById('logoutModal');
            logoutModal.style.display = 'flex';

            const closeModal = document.querySelector('.close-modal');
            closeModal.addEventListener('click', function(e) {
                logoutModal.style.display = 'none';
            });

            const cancelLogout = document.getElementById('cancelLogout');
            cancelLogout.addEventListener('click', function(e) {
                e.preventDefault();
                logoutModal.style.display = 'none';
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && logoutModal.style.display === 'flex') {
                    logoutModal.style.display = 'none';
                }
            });
        });
    </script>

</body>
</html>