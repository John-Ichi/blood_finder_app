-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 07:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_finder_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `blood_requests`
--

CREATE TABLE `blood_requests` (
  `request_id` int(11) NOT NULL,
  `requested_donor` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `request_description` varchar(500) NOT NULL,
  `urgent` tinyint(1) NOT NULL DEFAULT 0,
  `healthcare_institution` enum('lorem','dummy hospital') NOT NULL,
  `date_needed` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_requests`
--

INSERT INTO `blood_requests` (`request_id`, `requested_donor`, `name`, `contact`, `request_description`, `urgent`, `healthcare_institution`, `date_needed`) VALUES
(6, 2, 'Allen', '09xxxxxxxxx', 'Anemia', 0, 'dummy hospital', '2025-05-15'),
(9, 2, ' tes12423', '23423', 'HELP', 1, 'dummy hospital', '2025-05-31'),
(10, 2, ' asd', 'asd', 'asd', 1, 'dummy hospital', '2025-12-30');

-- --------------------------------------------------------

--
-- Table structure for table `donation_appointments`
--

CREATE TABLE `donation_appointments` (
  `donation_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `date_of_donation` date NOT NULL,
  `preferred_time` enum('morning','afternoon','evening') NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `additional_info` varchar(500) NOT NULL DEFAULT 'No additional information regarding donor.',
  `status` enum('pending','declined','accepted') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_appointments`
--

INSERT INTO `donation_appointments` (`donation_id`, `donor_id`, `date_of_donation`, `preferred_time`, `hospital_id`, `additional_info`, `status`) VALUES
(8, 2, '2025-05-10', 'morning', 2, 'TEST', 'accepted'),
(9, 4, '2025-05-10', 'afternoon', 2, 'TEST 3', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `donor_info`
--

CREATE TABLE `donor_info` (
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `blood_type` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
  `address` varchar(100) NOT NULL,
  `last_donation` varchar(50) DEFAULT 'No Record',
  `contact` varchar(11) NOT NULL,
  `donor_notes` varchar(500) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `next_available` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor_info`
--

INSERT INTO `donor_info` (`email`, `name`, `blood_type`, `address`, `last_donation`, `contact`, `donor_notes`, `available`, `next_available`) VALUES
('dummy-email@gmail.com', 'John Ichiro Mananquil', 'A+', 'Tanza, Cavite', 'No Record', '09951091995', 'Test update No. 1234', 1, '2025-05-20'),
('dummy-email2@gmail.com', 'Test', 'A+', 'Naic, Cavite', 'No Record', '09991112222', '', 1, '2025-05-20'),
('dummy-email3@gmail.com', 'Alex Boy', 'A+', 'Naic, Cavite', 'No Record', '1', 'Hihi', 1, '2025-05-20');

-- --------------------------------------------------------

--
-- Table structure for table `donor_login_info`
--

CREATE TABLE `donor_login_info` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `date_created` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor_login_info`
--

INSERT INTO `donor_login_info` (`id`, `email`, `password`, `last_login`, `is_active`, `date_created`) VALUES
(2, 'dummy-email@gmail.com', '$2y$10$EK0gSQ5golcpx0IMSzcu4u2BEdPSkCYeBv2bLNzecTbGjz1VuBn3C', '2025-05-20', 1, '2025-05-02'),
(3, 'dummy-email2@gmail.com', '$2y$10$tEsmnGx81i4HN9Ie/EOHF.ovuedGpLR0RXI66WcsoSVI0KBPBgTJ2', '2025-05-07', 1, '2025-05-07'),
(4, 'dummy-email3@gmail.com', '$2y$10$wofa6uLtnv2pHqYQAqWOHulwp.6MCMeZE1.LF6Tf21Gpm8ohYcGKS', '2025-05-08', 1, '2025-05-08'),
(9, 'dummy-email4@gmail.com', '$2y$10$XgPaUMK5YQ2GqejOawIfne09FLhADz7kP1tA7PCOIu5m2QT0/d2We', NULL, 1, '2025-05-20'),
(10, 'dummy-email5@gmail.com', '$2y$10$88iftKjxPjFlj7tgDp5TBORXUsJ3TbXq5DcQ5DNcnRzljXRuYJeva', NULL, 1, '2025-05-20');

-- --------------------------------------------------------

--
-- Table structure for table `hospital_info`
--

CREATE TABLE `hospital_info` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `a_positive_stock` int(11) NOT NULL,
  `a_negative_stock` int(11) NOT NULL,
  `b_positive_stock` int(11) NOT NULL,
  `b_negative_stock` int(11) NOT NULL,
  `ab_positive_stock` int(11) NOT NULL,
  `ab_negative_stock` int(11) NOT NULL,
  `o_positive_stock` int(11) NOT NULL,
  `o_negative_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital_info`
--

INSERT INTO `hospital_info` (`id`, `name`, `address`, `a_positive_stock`, `a_negative_stock`, `b_positive_stock`, `b_negative_stock`, `ab_positive_stock`, `ab_negative_stock`, `o_positive_stock`, `o_negative_stock`) VALUES
(2, 'dummy', 'Tanza, Cavite', 12, 11, 14, 16, 17, 15, 9, 10);

-- --------------------------------------------------------

--
-- Table structure for table `hospital_login_info`
--

CREATE TABLE `hospital_login_info` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `date_created` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital_login_info`
--

INSERT INTO `hospital_login_info` (`id`, `email`, `password`, `last_login`, `is_active`, `date_created`) VALUES
(2, 'hospital-dummy@gmail.com', '$2y$10$Srzjb3jqVIdCHt/DJ.DDi.Zq0IDWykiInEOtQ9HGo93e2Wx.eoFMC', NULL, 1, '2025-05-07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `requested_donor` (`requested_donor`);

--
-- Indexes for table `donation_appointments`
--
ALTER TABLE `donation_appointments`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `hospital_id` (`hospital_id`);

--
-- Indexes for table `donor_info`
--
ALTER TABLE `donor_info`
  ADD KEY `email` (`email`);

--
-- Indexes for table `donor_login_info`
--
ALTER TABLE `donor_login_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `hospital_info`
--
ALTER TABLE `hospital_info`
  ADD KEY `id` (`id`);

--
-- Indexes for table `hospital_login_info`
--
ALTER TABLE `hospital_login_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blood_requests`
--
ALTER TABLE `blood_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `donation_appointments`
--
ALTER TABLE `donation_appointments`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `donor_login_info`
--
ALTER TABLE `donor_login_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hospital_login_info`
--
ALTER TABLE `hospital_login_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD CONSTRAINT `blood_requests_ibfk_1` FOREIGN KEY (`requested_donor`) REFERENCES `donor_login_info` (`id`);

--
-- Constraints for table `donation_appointments`
--
ALTER TABLE `donation_appointments`
  ADD CONSTRAINT `donation_appointments_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donor_login_info` (`id`),
  ADD CONSTRAINT `donation_appointments_ibfk_2` FOREIGN KEY (`hospital_id`) REFERENCES `hospital_login_info` (`id`);

--
-- Constraints for table `donor_info`
--
ALTER TABLE `donor_info`
  ADD CONSTRAINT `donor_info_ibfk_1` FOREIGN KEY (`email`) REFERENCES `donor_login_info` (`email`);

--
-- Constraints for table `hospital_info`
--
ALTER TABLE `hospital_info`
  ADD CONSTRAINT `hospital_info_ibfk_1` FOREIGN KEY (`id`) REFERENCES `hospital_login_info` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
