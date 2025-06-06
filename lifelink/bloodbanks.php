<?php
include '_functions.php';

getBloodBankInfoJSON();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeLink</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="bloodbanks.css">
    <link rel="icon" href="resources/heartbeat-solid.svg">
</head>
<body>
    <header class="header">
        <a href="#" class="logo">
            <i class="fas fa-heartbeat"></i>
            <span>LifeLink</span>
        </a>
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="#">Donor Lists</a>
            <a href="#">Blood Bank Lists</a>
        </div>
        <div class="ham-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="off-screen-menu">
            <ul>
                <li>Home</li>
                <li>Login</li>
                <li>About Us</li>
                <li>Contact</li>
            </ul>
        </div>
    </header>
    
    <div class="container">
        <div class="search-container">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search blood bank by name or location...">
                <button class="filter-btn" id="searchBtn"><i class="fas fa-search"></i> Search</button>
            </div>
        <!--<div class="filter-options" id="filterOptions">
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
            </div>-->
        </div>
        
        <div class="card-grid" id="cardGrid">
        </div>
    </div>

    <script src="bloodbanks.js"></script>
</body>
</html>