-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2025 at 04:10 PM
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
-- Database: `soeprojectdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `building_id` int(11) NOT NULL,
  `building_name` varchar(100) NOT NULL,
  `floors` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`building_id`, `building_name`, `floors`) VALUES
(1, 'Science Building', 3),
(2, 'Technology Building', 4),
(3, 'Main Building', 5),
(4, 'Admin Building', 2);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_number` varchar(50) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `room_type` enum('Classroom','Laboratory','Auditorium','Office','Others') NOT NULL,
  `capacity` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `floor` int(11) NOT NULL,
  `status` enum('Available','Occupied','Under Maintenance') DEFAULT 'Available',
  `room_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_number`, `room_name`, `room_type`, `capacity`, `building_id`, `floor`, `status`, `room_image`, `created_at`, `updated_at`) VALUES
(1, '101', 'Physics Lab', 'Laboratory', 40, 1, 1, 'Available', 'images/rooms/physics_lab.jpg', '2025-02-23 14:52:48', '2025-02-23 14:52:48'),
(2, '102', 'Computer Lab', 'Laboratory', 30, 2, 2, 'Occupied', 'images/rooms/computer_lab.jpg', '2025-02-23 14:52:48', '2025-02-23 14:52:48'),
(3, '201', 'Math Classroom', 'Classroom', 35, 3, 2, 'Available', 'images/rooms/math_classroom.jpg', '2025-02-23 14:52:48', '2025-02-23 14:52:48'),
(4, '202', 'Lecture Hall', 'Auditorium', 100, 3, 3, 'Under Maintenance', 'images/rooms/lecture_hall.jpg', '2025-02-23 14:52:48', '2025-02-23 14:52:48'),
(5, '301', 'Faculty Office', 'Office', 10, 4, 3, 'Available', 'images/rooms/faculty_office.jpg', '2025-02-23 14:52:48', '2025-02-23 14:52:48');

-- --------------------------------------------------------

--
-- Table structure for table `room_maintenance`
--

CREATE TABLE `room_maintenance` (
  `maintenance_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `issue_description` text NOT NULL,
  `reported_by` int(11) NOT NULL,
  `reported_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','In Progress','Resolved') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_reports`
--

CREATE TABLE `room_reports` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_reservations`
--

CREATE TABLE `room_reservations` (
  `reservation_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `purpose` text NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` enum('Pending','Approved','Rejected','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_status`
--

CREATE TABLE `room_status` (
  `status_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `status` enum('Available','Occupied','Under Maintenance') NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Maintenance','Faculty','Student') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'renzadmin', 'admin', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Faculty', '2025-02-23 15:06:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`building_id`),
  ADD UNIQUE KEY `building_name` (`building_name`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `room_number` (`room_number`),
  ADD KEY `building_id` (`building_id`);

--
-- Indexes for table `room_maintenance`
--
ALTER TABLE `room_maintenance`
  ADD PRIMARY KEY (`maintenance_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `reported_by` (`reported_by`);

--
-- Indexes for table `room_reports`
--
ALTER TABLE `room_reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `room_reservations`
--
ALTER TABLE `room_reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `room_status`
--
ALTER TABLE `room_status`
  ADD PRIMARY KEY (`status_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `building_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `room_maintenance`
--
ALTER TABLE `room_maintenance`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_reports`
--
ALTER TABLE `room_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_reservations`
--
ALTER TABLE `room_reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_status`
--
ALTER TABLE `room_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`building_id`) ON DELETE CASCADE;

--
-- Constraints for table `room_maintenance`
--
ALTER TABLE `room_maintenance`
  ADD CONSTRAINT `room_maintenance_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_maintenance_ibfk_2` FOREIGN KEY (`reported_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `room_reports`
--
ALTER TABLE `room_reports`
  ADD CONSTRAINT `room_reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `room_reservations`
--
ALTER TABLE `room_reservations`
  ADD CONSTRAINT `room_reservations_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_reservations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `room_status`
--
ALTER TABLE `room_status`
  ADD CONSTRAINT `room_status_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_status_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
