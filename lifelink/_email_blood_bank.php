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
    <title>Document</title>
</head>
<body>
    <form method="POST" action="_functions.php">
        Send to
        <input type="text" name="blood_bank_email" value="<?php echo $hospital_email?>" readonly>
        Name
        <input type="text" name="name" required>
        Contact email
        <input type="text" name="email" required>
        Contact number
        <input type="text" name="number" required>
        Message
        <textarea name="message"></textarea>
        <button name="sendmail">Send</button>
    </form>
</body>
</html>