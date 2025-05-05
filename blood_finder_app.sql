-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 12:15 PM
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
-- Table structure for table `blood_bank_listing`
--

CREATE TABLE `blood_bank_listing` (
  `id` int(11) NOT NULL,
  `hospital_name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact_number` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_bank_listing`
--

INSERT INTO `blood_bank_listing` (`id`, `hospital_name`, `address`, `contact_number`) VALUES
(1, 'Divine Grace Medical Center', 'General Trias, Cavite', '912345678'),
(2, 'First Filipino Saint Hospital', 'Naic, Cavite', '977832776'),
(3, 'Naic Doctors Hospital', 'Naic, Cavite', '923165479'),
(4, 'Olivarez General Hospital', 'Paranaque, Metro Manila', '924317659'),
(5, 'Rizal Medical Center', 'Pasig, Metro Manila', '985741293'),
(6, 'Makati Life Medical Center', 'Makati, Metro Manila', '985674139'),
(7, 'Westlake Medical Center', 'San Pedro, Laguna', '983216547'),
(8, 'Calamba Doctors Hospital', 'Calamba, Laguna', '954132786'),
(9, 'Global Medical Center', 'Cabuyao, Laguna', '912356283');

-- --------------------------------------------------------

--
-- Table structure for table `blood_bank_type_list`
--

CREATE TABLE `blood_bank_type_list` (
  `id` int(11) NOT NULL,
  `available_type` set('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_bank_type_list`
--

INSERT INTO `blood_bank_type_list` (`id`, `available_type`) VALUES
(1, 'A+,A-,B+'),
(2, 'A+,B+,AB-'),
(3, 'A+,O+,O-');

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
  `healthcare_institution` enum('lorem','dummy hospital') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_requests`
--

INSERT INTO `blood_requests` (`request_id`, `requested_donor`, `name`, `contact`, `request_description`, `urgent`, `healthcare_institution`) VALUES
(2, 2, 'John', '09662996199', 'TEST', 1, 'dummy hospital'),
(3, 2, 'Allen', '12345678909', 'TEST 2', 0, 'dummy hospital');

-- --------------------------------------------------------

--
-- Table structure for table `donatee_request`
--

CREATE TABLE `donatee_request` (
  `request_id` int(11) NOT NULL,
  `type_requested` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donatee_request`
--

INSERT INTO `donatee_request` (`request_id`, `type_requested`, `date`) VALUES
(1, 'A+', '2025-04-13');

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `donor_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `blood_type` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `contact` varchar(11) NOT NULL,
  `last_donation` varchar(50) NOT NULL DEFAULT 'No Record',
  `donor_notes` varchar(500) DEFAULT NULL,
  `available` tinyint(1) NOT NULL,
  `next_available` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`donor_id`, `name`, `email`, `password`, `blood_type`, `address`, `contact`, `last_donation`, `donor_notes`, `available`, `next_available`) VALUES
(51, 'Ichiro', 'john_ichiro@email.com', 'ichiro-pass123', 'A+', 'Naic, Cavite', '09912345678', '2025-04-04', 'Available weekends only.', 0, '2025-05-29'),
(53, 'John', 'mananquil_john@email.com', 'john_pass@123', 'A-', 'Tanza, Cavite', '09987654321', 'No Record', 'First time donor.', 1, '2025-04-21'),
(54, 'Allen', 'allen_dinglas@email.com', 'allen_password123', 'B+', 'Ternate, Cavite', '09918273645', 'No Record', 'Please refer to my email.', 0, '2025-04-30'),
(55, 'Ceejay', 'email.ceejay@email.com', 'cj-pass123', 'B-', 'Naic, Cavite', '09921873645', '2025-01-01', 'Available ASAP.', 1, '2025-04-21');

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
('dummy-email@gmail.com', 'John Ichiro Mananquil', 'A+', 'Tanza, Cavite', 'No Record', '09951091995', 'Weekdays only.', 1, '2025-05-05');

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
(2, 'dummy-email@gmail.com', '$2y$10$EK0gSQ5golcpx0IMSzcu4u2BEdPSkCYeBv2bLNzecTbGjz1VuBn3C', '2025-05-05', 1, '2025-05-02');

-- --------------------------------------------------------

--
-- Table structure for table `donor_record`
--

CREATE TABLE `donor_record` (
  `record_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `number_of_donations` int(11) NOT NULL,
  `previous_donation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blood_bank_listing`
--
ALTER TABLE `blood_bank_listing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_bank_type_list`
--
ALTER TABLE `blood_bank_type_list`
  ADD KEY `id` (`id`);

--
-- Indexes for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `requested_donor` (`requested_donor`);

--
-- Indexes for table `donatee_request`
--
ALTER TABLE `donatee_request`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`donor_id`);

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
-- Indexes for table `donor_record`
--
ALTER TABLE `donor_record`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `donor_id` (`donor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blood_bank_listing`
--
ALTER TABLE `blood_bank_listing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `blood_requests`
--
ALTER TABLE `blood_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `donatee_request`
--
ALTER TABLE `donatee_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `donor`
--
ALTER TABLE `donor`
  MODIFY `donor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `donor_login_info`
--
ALTER TABLE `donor_login_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `donor_record`
--
ALTER TABLE `donor_record`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_bank_type_list`
--
ALTER TABLE `blood_bank_type_list`
  ADD CONSTRAINT `blood_bank_type_list_ibfk_1` FOREIGN KEY (`id`) REFERENCES `blood_bank_listing` (`id`);

--
-- Constraints for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD CONSTRAINT `blood_requests_ibfk_1` FOREIGN KEY (`requested_donor`) REFERENCES `donor_login_info` (`id`);

--
-- Constraints for table `donor_info`
--
ALTER TABLE `donor_info`
  ADD CONSTRAINT `donor_info_ibfk_1` FOREIGN KEY (`email`) REFERENCES `donor_login_info` (`email`);

--
-- Constraints for table `donor_record`
--
ALTER TABLE `donor_record`
  ADD CONSTRAINT `donor_record_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donor` (`donor_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
