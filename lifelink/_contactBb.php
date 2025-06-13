<?php
if (!isset($_GET['contactBb'])) {
    header('Location: bloodbanks.php');
} else if (isset($_GET['contactBb'])) {
    $hospital_email = $_GET['email'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeLink</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/_contactBb.css">
    <link rel="icon" href="resources/heartbeat-solid.svg">
</head>
<body>

    <div class="container">
        <div class="header">
            <div class="header-content">
                <i class="fas fa-envelope-medical"></i>
                <h1>Contact Blood Bank</h1>
                <p>Send your donation request or inquiry</p>
            </div>
        </div>

        <div class="form-container">
            <div class="urgent-notice">
                <i class="fas fa-exclamation-triangle"></i>
                <span>For urgent blood requests, please call the blood bank directly</span>
            </div>

            <form method="POST" action="_functions.php">
                <input type="hidden" name="blood_bank_email" value="<?php echo $hospital_email?>" readonly>

                <div class="form-group">
                    <label for="name">
                        <i class="fas fa-user"></i>
                        Full Name <span class="required">*</span>
                    </label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                        Contact Email <span class="required">*</span>
                    </label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" required>
                </div>

                <div class="form-group">
                    <label for="number">
                        <i class="fas fa-phone"></i>
                        Contact Number <span class="required">*</span>
                    </label>
                    <input type="tel" id="number" name="number" class="form-control" placeholder="Enter your phone number" required>
                </div>

                <div class="form-group">
                    <label for="message">
                        <i class="fas fa-comment-medical"></i>
                        Message / Request Details
                    </label>
                    <textarea id="message" name="message" class="form-control" placeholder="Please describe your blood donation request, blood type needed, urgency level, or any other relevant information..."></textarea>
                </div>

                <button type="submit" name="sendmail" class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    Send Message
                </button>
            </form>

            <div class="back-link">
                <a href="bloodbanks.php">
                    <i class="fas fa-arrow-left"></i>
                    Back to Blood Banks
                </a>
            </div>
        </div>
    </div>

</body>

</html>