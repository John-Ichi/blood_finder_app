-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 10:00 AM
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
-- Table structure for table `blood_inventory`
--

CREATE TABLE `blood_inventory` (
  `serial_no` int(11) NOT NULL,
  `blood_type` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
  `form_factor` enum('whole','rbc','platelets','plasma') NOT NULL,
  `source` enum('donation','blood bank') NOT NULL,
  `date_recieved` datetime NOT NULL DEFAULT current_timestamp(),
  `expiration_date` datetime NOT NULL,
  `blood_bank_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_inventory`
--

INSERT INTO `blood_inventory` (`serial_no`, `blood_type`, `form_factor`, `source`, `date_recieved`, `expiration_date`, `blood_bank_id`) VALUES
(18, 'A+', 'whole', 'donation', '2025-05-22 09:13:19', '2025-07-03 09:13:19', 2),
(19, 'A-', 'rbc', 'donation', '2025-05-22 09:13:30', '2025-07-03 09:13:30', 2),
(20, 'A-', 'rbc', 'donation', '2025-05-22 09:13:30', '2025-07-03 09:13:30', 2),
(21, 'AB+', 'whole', 'blood bank', '2025-05-22 09:13:50', '2025-07-03 09:13:50', 2),
(22, 'AB+', 'whole', 'blood bank', '2025-05-22 09:13:50', '2025-07-03 09:13:50', 2),
(23, 'AB+', 'whole', 'blood bank', '2025-05-22 09:13:50', '2025-07-03 09:13:50', 2),
(24, 'AB+', 'whole', 'blood bank', '2025-05-22 09:13:50', '2025-07-03 09:13:50', 2),
(25, 'AB+', 'whole', 'blood bank', '2025-05-22 09:13:50', '2025-07-03 09:13:50', 2),
(26, 'O-', 'rbc', 'donation', '2025-05-22 09:14:02', '2025-07-03 09:14:02', 2),
(27, 'O-', 'rbc', 'donation', '2025-05-22 09:14:02', '2025-07-03 09:14:02', 2);

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
  `preferred_time` enum('Morning','Afternoon','Evening') NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `additional_info` varchar(500) NOT NULL DEFAULT 'No additional information regarding donor.',
  `status` enum('Pending','Rejected','Approved','Completed','Cancelled') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_appointments`
--

INSERT INTO `donation_appointments` (`donation_id`, `donor_id`, `date_of_donation`, `preferred_time`, `hospital_id`, `additional_info`, `status`) VALUES
(12, 2, '2025-05-27', 'Evening', 2, 'None to report', 'Approved'),
(14, 3, '2025-05-31', 'Morning', 3, 'Test.', 'Pending'),
(15, 4, '2025-05-29', 'Afternoon', 2, 'Test 123.', 'Approved'),
(16, 2, '2025-05-29', 'Morning', 2, '123', 'Approved'),
(17, 4, '2025-05-30', 'Morning', 2, 'Test', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `donation_history`
--

CREATE TABLE `donation_history` (
  `history_id` int(11) NOT NULL,
  `donation_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `date_completed` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_history`
--

INSERT INTO `donation_history` (`history_id`, `donation_id`, `donor_id`, `hospital_id`, `date_completed`) VALUES
(1, 15, 4, 2, '2025-05-29'),
(2, 17, 4, 2, '2025-05-29'),
(3, 16, 2, 2, '2025-05-29'),
(4, 15, 4, 2, '2025-05-29'),
(5, 15, 4, 2, '2025-05-29'),
(6, 12, 2, 2, '2025-05-29'),
(7, 16, 2, 2, '2025-05-29'),
(8, 15, 4, 2, '2025-05-29'),
(9, 17, 4, 2, '2025-05-29');

-- --------------------------------------------------------

--
-- Table structure for table `donor_info`
--

CREATE TABLE `donor_info` (
  `donor_id` int(11) NOT NULL,
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

INSERT INTO `donor_info` (`donor_id`, `name`, `blood_type`, `address`, `last_donation`, `contact`, `donor_notes`, `available`, `next_available`) VALUES
(2, 'John Ichiro Mananquil', 'A+', 'Naic, Cavite', 'No Record', '09951091995', '', 1, '2025-05-29'),
(3, 'dummy donor', 'A-', 'Tanza, Cavite', 'No Record', '12345678901', '', 1, '2025-05-29'),
(4, 'Dummy Donor 2', 'B-', 'Ternate, Cavite', 'No Record', '12345098765', '', 1, '2025-05-29'),
(9, 'Test Info', 'O+', 'Trece Martires City, Cavite', 'No Record', '09277348393', '', 1, '2025-05-29');

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
(2, 'dummy-email@gmail.com', '$2y$10$EK0gSQ5golcpx0IMSzcu4u2BEdPSkCYeBv2bLNzecTbGjz1VuBn3C', '2025-05-28', 1, '2025-05-02'),
(3, 'dummy-email2@gmail.com', '$2y$10$tEsmnGx81i4HN9Ie/EOHF.ovuedGpLR0RXI66WcsoSVI0KBPBgTJ2', '2025-05-27', 1, '2025-05-07'),
(4, 'dummy-email3@gmail.com', '$2y$10$wofa6uLtnv2pHqYQAqWOHulwp.6MCMeZE1.LF6Tf21Gpm8ohYcGKS', '2025-05-29', 1, '2025-05-08'),
(9, 'dummy-email4@gmail.com', '$2y$10$XgPaUMK5YQ2GqejOawIfne09FLhADz7kP1tA7PCOIu5m2QT0/d2We', '2025-05-28', 1, '2025-05-20'),
(10, 'dummy-email5@gmail.com', '$2y$10$88iftKjxPjFlj7tgDp5TBORXUsJ3TbXq5DcQ5DNcnRzljXRuYJeva', '2025-05-29', 1, '2025-05-20');

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
(2, 'Dummy Blood Bank', 'Silang, Cavite', '01-2345-6789'),
(3, 'dummy hospital 2', 'Dasmarinas, Cavite', '12-3456-7890');

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
(2, 'hospital-dummy@gmail.com', '$2y$10$P2.No2eI/nsewQslt9yreOo/JglWvwC7xo5hi4C8ktcgOicu4GS3u', NULL, 1, '2025-05-07'),
(3, 'hospital-dummy0@gmail.com', '$2y$10$AxwISO/g9dK9v16BfHcCAeSiMux1dnMCHP.xQUjIeO7q5Z8tIVX2e', NULL, 1, '2025-05-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blood_inventory`
--
ALTER TABLE `blood_inventory`
  ADD PRIMARY KEY (`serial_no`),
  ADD KEY `blood_bank_id` (`blood_bank_id`);

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
-- AUTO_INCREMENT for table `blood_inventory`
--
ALTER TABLE `blood_inventory`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `blood_requests`
--
ALTER TABLE `blood_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `donation_appointments`
--
ALTER TABLE `donation_appointments`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `donation_history`
--
ALTER TABLE `donation_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `donor_login_info`
--
ALTER TABLE `donor_login_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `hospital_login_info`
--
ALTER TABLE `hospital_login_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_inventory`
--
ALTER TABLE `blood_inventory`
  ADD CONSTRAINT `blood_inventory_ibfk_1` FOREIGN KEY (`blood_bank_id`) REFERENCES `hospital_login_info` (`id`);

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
-- Constraints for table `donation_history`
--
ALTER TABLE `donation_history`
  ADD CONSTRAINT `donation_history_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donor_info` (`donor_id`),
  ADD CONSTRAINT `donation_history_ibfk_2` FOREIGN KEY (`hospital_id`) REFERENCES `hospital_info` (`id`),
  ADD CONSTRAINT `donation_history_ibfk_3` FOREIGN KEY (`donation_id`) REFERENCES `donation_appointments` (`donation_id`);

--
-- Constraints for table `donor_info`
--
ALTER TABLE `donor_info`
  ADD CONSTRAINT `donor_info_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donor_login_info` (`id`);

--
-- Constraints for table `hospital_info`
--
ALTER TABLE `hospital_info`
  ADD CONSTRAINT `hospital_info_ibfk_1` FOREIGN KEY (`id`) REFERENCES `hospital_login_info` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
