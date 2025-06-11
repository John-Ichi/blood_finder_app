-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2025 at 10:40 AM
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
  `donor_id` int(11) NOT NULL,
  `requester_name` varchar(50) NOT NULL,
  `contact_email` varchar(50) NOT NULL,
  `contact_no` varchar(11) NOT NULL,
  `request_description` varchar(500) NOT NULL,
  `urgent` tinyint(1) NOT NULL DEFAULT 0,
  `hospital_id` int(11) DEFAULT NULL,
  `point_of_donation` varchar(100) NOT NULL,
  `date_needed` date NOT NULL,
  `status` enum('Pending','Accepted','Expired','Done','Cancelled') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donation_appointments`
--

CREATE TABLE `donation_appointments` (
  `donation_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `date_of_donation` date NOT NULL,
  `preferred_time` enum('Morning (8AM - 12PM)','Afternoon (12PM - 4PM)','Evening (4PM - 8PM)') NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `additional_info` varchar(500) NOT NULL DEFAULT 'No additional information regarding donor.',
  `status` enum('Pending','Rejected','Approved','Completed','Cancelled') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_appointments`
--

INSERT INTO `donation_appointments` (`donation_id`, `donor_id`, `date_of_donation`, `preferred_time`, `hospital_id`, `additional_info`, `status`) VALUES
(47, 14, '2025-06-18', 'Afternoon (12PM - 4PM)', 4, 'No additional information regarding donor.', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `donation_history`
--

CREATE TABLE `donation_history` (
  `history_id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `donation_id` int(11) DEFAULT NULL,
  `donor_id` int(11) NOT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `extraction_datetime` datetime NOT NULL,
  `component` enum('Whole Blood','Red Blood Cells','Platelets','Plasma') DEFAULT NULL,
  `units_collected` int(11) DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_history`
--

INSERT INTO `donation_history` (`history_id`, `request_id`, `donation_id`, `donor_id`, `hospital_id`, `extraction_datetime`, `component`, `units_collected`, `hidden`) VALUES
(49, NULL, 47, 14, 4, '2025-06-18 15:50:29', 'Whole Blood', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `donor_info`
--

CREATE TABLE `donor_info` (
  `donor_id` int(11) NOT NULL,
  `donor_name` varchar(50) NOT NULL,
  `blood_type` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `donor_notes` varchar(500) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `next_available` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor_info`
--

INSERT INTO `donor_info` (`donor_id`, `donor_name`, `blood_type`, `address`, `contact`, `donor_notes`, `available`, `next_available`) VALUES
(14, 'Finalizing', 'A+', 'Silang, Cavite', '09112223333', '', 0, '2025-07-30'),
(15, 'Finalizing 2', 'O+', 'Ternate, Cavite', '09xxxxxxxxx', '', 1, '2025-06-11'),
(16, 'Ichoooi', 'AB+', 'Trece Martires City, Cavite', '09xxxxxxxxx', 'Eczema', 1, '2025-06-11'),
(17, 'TESTING', 'O-', 'Naic, Cavite', '09xxxxxxxxx', 'TEST ACCOUNT', 1, '2025-06-11');

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
(14, 'yukinoo0713@gmail.com', '$2y$10$rn0OpJtiQHJMSvAyOOVm1eTkopBERWa4WM5dMIybWFz6hNVbCn4sW', '2025-06-11', 1, '2025-06-03'),
(15, 'johnichiro.mananquil.photos@gmail.com', '$2y$10$..ct3k.KyKwObTC/LWsLWuujTOH/bxQ5XXapvKig0xlAqr8gVtgUW', '2025-06-10', 1, '2025-06-06'),
(16, 'ichiljay@gmail.com', '$2y$10$9qY6KT3K1D.MKVfoiEJg6OmMOZ2.it43Da2rNzzNXouj5DEzdgF6G', '2025-06-10', 1, '2025-06-06'),
(17, 'ajbernaio505@gmail.com', '$2y$10$nziyGASijgBBOOjNk6kdauEu10bePKLJX1O6i0xjHuE2A169kMEye', '2025-06-11', 1, '2025-06-11');

-- --------------------------------------------------------

--
-- Table structure for table `hospital_info`
--

CREATE TABLE `hospital_info` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital_info`
--

INSERT INTO `hospital_info` (`id`, `name`, `address`, `contact`) VALUES
(4, 'Hospital Test Mail', 'Naic, Cavite', '01-2345-6789');

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
(4, 'aonoyuki17@gmail.com', '$2y$10$uNkROfbCmE3kMud9wn9RaOqWOSPwJXLjP4RW2jQ4O./3HJy0US4ry', NULL, 1, '2025-06-03'),
(5, 'dominiqueaira13@gmail.com', '$2y$10$KZ.mbSPPVpH9GUcfuXQdFOjjTQM8y7j9A8F3N1xwxArOLF2yyUSzW', NULL, 1, '2025-06-11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `requested_donor` (`donor_id`),
  ADD KEY `hospital_id` (`hospital_id`);

--
-- Indexes for table `donation_appointments`
--
ALTER TABLE `donation_appointments`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `hospital_id` (`hospital_id`);

--
-- Indexes for table `donation_history`
--
ALTER TABLE `donation_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `hospital_id` (`hospital_id`),
  ADD KEY `donation_id` (`donation_id`);

--
-- Indexes for table `donor_info`
--
ALTER TABLE `donor_info`
  ADD KEY `email` (`donor_id`);

--
-- Indexes for table `donor_login_info`
--
ALTER TABLE `donor_login_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

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
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `donation_appointments`
--
ALTER TABLE `donation_appointments`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `donation_history`
--
ALTER TABLE `donation_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `donor_login_info`
--
ALTER TABLE `donor_login_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `hospital_login_info`
--
ALTER TABLE `hospital_login_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD CONSTRAINT `blood_requests_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donor_login_info` (`id`),
  ADD CONSTRAINT `blood_requests_ibfk_2` FOREIGN KEY (`hospital_id`) REFERENCES `hospital_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `donation_appointments`
--
ALTER TABLE `donation_appointments`
  ADD CONSTRAINT `donation_appointments_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donor_login_info` (`id`),
  ADD CONSTRAINT `donation_appointments_ibfk_2` FOREIGN KEY (`hospital_id`) REFERENCES `hospital_login_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `donation_history`
--
ALTER TABLE `donation_history`
  ADD CONSTRAINT `donation_history_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donor_info` (`donor_id`),
  ADD CONSTRAINT `donation_history_ibfk_2` FOREIGN KEY (`hospital_id`) REFERENCES `hospital_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `donation_history_ibfk_3` FOREIGN KEY (`donation_id`) REFERENCES `donation_appointments` (`donation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `donor_info`
--
ALTER TABLE `donor_info`
  ADD CONSTRAINT `donor_info_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donor_login_info` (`id`);

--
-- Constraints for table `hospital_info`
--
ALTER TABLE `hospital_info`
  ADD CONSTRAINT `hospital_info_ibfk_1` FOREIGN KEY (`id`) REFERENCES `hospital_login_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
