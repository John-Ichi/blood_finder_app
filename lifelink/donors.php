<?php
include '_functions.php';

updateAvailablity();
getDonorInfoJSON();

if(!isset($_POST['filter'])) {
    $search = '';
}
else {
    $search = $_POST['blood_type'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeLink - Blood Donor Directory</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="donors.css">
    <link rel="icon" href="resources/heartbeat-solid.svg">
</head>
<body>

    <nav>
        <a href="home.php" class="logo">
            <i class="fas fa-heartbeat"></i>
            <span>LifeLink</span>
        </a>
        <div class="nav-links">
            <a href="home.php">Home</a>
            <a href="#">Donors</a>
            <a href="#">Blood Banks</a>
            <a href="donor-login.php">Login</a>
        </div>
    </nav>
    
    <div class="container">
        <div class="search-container">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search donors by a keyword in name, location, or blood type..." value="<?php echo $search?>">
                <button class="filter-btn" id="clearBtn"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="filter-options" id="filterOptions">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="A+">A+</button>
                <button class="filter-btn" data-filter="A-">A-</button>
                <button class="filter-btn" data-filter="B+">B+</button>
                <button class="filter-btn" data-filter="B-">B-</button>
                <button class="filter-btn" data-filter="AB+">AB+</button>
                <button class="filter-btn" data-filter="AB-">AB-</button>
                <button class="filter-btn" data-filter="O+">O+</button>
                <button class="filter-btn" data-filter="O-">O-</button>
                <button class="filter-btn" data-filter="available">Available</button>
            </div>
        </div>
        
        <div class="donor-grid" id="donorGrid">
        </div>
    </div>

    <script src="donors.js"></script>
</body>
</html>