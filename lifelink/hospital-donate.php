<?php
include '_functions.php';
$conn = connect();

date_default_timezone_set('Asia/Manila');

if(isset($_POST['submit'])) {
    $qty = $_POST['quantity'];

    $blood_type = $_POST['blood_type'];
    $form_factor = $_POST['form_factor'];
    $source = $_POST['source'];
    // $date = date('Y-m-d H:i:s');
    // $date_today = date_create($date);
    $date_today = new DateTime();
    // $expiration_date = date_add($date_today, date_interval_create_from_date_string("42 days"));
    $expiration_date = $date_today->add(new DateInterval('P42D'));
    $expiration = $expiration_date->format('Y-m-d H:i:s');

    $sql = "INSERT INTO blood_inventory
    (`blood_type`,
    `form_factor`,
    `source`,
    `expiration_date`,
    `blood_bank_id`)
    VALUES
    ('$blood_type',
    '$form_factor',
    '$source',
    '$expiration',
    2)";

    for($i = 0; $i < $qty; $i++) {
        $conn->query($sql);
    }
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
            <section id="update-inventory" class="content-section">
                <h2><i class="fas fa-plus-circle"></i> Update Blood Inventory</h2>
                <form method="POST" id="inventory-form">
                    <div class="form-group">
                        <label for="blood-type"><i class="fas fa-tint"></i> Blood Type:</label>
                        <select name="blood_type" id="blood-type" required>
                            <option value="">Select</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="form-factor"><i class="fas fa-cubes"></i> Form Factor:</label>
                        <select name="form_factor" id="form-factor" required>
                            <option value="">Select</option>
                            <option value="whole">Whole Blood</option>
                            <option value="rbc">Red Blood Cells</option>
                            <option value="platelets">Platelets</option>
                            <option value="plasma">Plasma</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="source"><i class="fas fa-truck-medical"></i> Source:</label>
                        <select name="source" id="source" required>
                            <option value="donation">Donation</option>
                            <option value="blood bank">Requested from blood bank</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity"><i class="fas fa-cubes"></i> Quantity (if done in bulk):</label>
                        <input type="number" id="quantity" min="1" value="1" name="quantity" required>
                    </div>
                    <button name="submit" type="submit" class="btn-submit"><i class="fas fa-save"></i> Add to Inventory</button>
                </form>
            </section>
</body>
</html>