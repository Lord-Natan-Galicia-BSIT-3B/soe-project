-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2025 at 03:06 PM
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
  `BuildingID` int(11) NOT NULL,
  `BuildingName` varchar(100) NOT NULL,
  `BuildingDescription` text DEFAULT NULL,
  `BuildingLocation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`BuildingID`, `BuildingName`, `BuildingDescription`, `BuildingLocation`) VALUES
(1, 'Main Building', 'Houses administration and classrooms', 'Front Gate'),
(2, 'Science Hall', 'Dedicated to science laboratories', 'Near Parking Lot');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `receiver_email` varchar(255) NOT NULL,
  `room` varchar(100) NOT NULL,
  `problem_description` text NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `sender_email`, `receiver_email`, `room`, `problem_description`, `photo_path`, `created_at`) VALUES
(13, 'john.reyes@dyci.edu.ph', 'alice@dyci.edu.ph', '101', 'testttttt', NULL, '2025-05-19 06:20:02'),
(14, '', 'alice@dyci.edu.ph', '101', 'sadasdas', '../uploads/1747654529_profile.jpg', '2025-05-19 11:35:29'),
(15, '', 'alice@dyci.edu.ph', '101', 'asdasd', '../uploads/1747655108_profile.jpg', '2025-05-19 11:45:08'),
(16, 'john.reyes@dyci.edu.ph', 'alice@dyci.edu.ph', '101', 'asdasdd', '../uploads/1747656032_profile.jpg', '2025-05-19 12:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `RequestID` int(11) NOT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `IssueDescription` text NOT NULL,
  `Status` enum('Pending','In Progress','Completed') DEFAULT 'Pending',
  `DateReported` datetime NOT NULL,
  `DateResolved` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`RequestID`, `RoomID`, `UserID`, `IssueDescription`, `Status`, `DateReported`, `DateResolved`) VALUES
(1, 2, 3, 'Broken gas valve in the chemistry lab.', 'In Progress', '2025-05-01 14:30:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `ReservationID` int(11) NOT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `Purpose` text DEFAULT NULL,
  `Status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `Section` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`ReservationID`, `RoomID`, `UserID`, `StartTime`, `EndTime`, `Purpose`, `Status`, `Section`, `updated_at`) VALUES
(13, 1, 2, '2025-05-19 07:00:00', '2025-05-19 08:00:00', 'asdasd', 'Approved', 'tstonly', '2025-05-19 20:44:02');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `RoomID` int(11) NOT NULL,
  `BuildingID` int(11) DEFAULT NULL,
  `RoomNumber` varchar(50) NOT NULL,
  `RoomCapacity` int(11) DEFAULT NULL,
  `RoomStatus` enum('Available','Occupied','Under Maintenance') DEFAULT 'Available',
  `RoomDescription` text DEFAULT NULL,
  `QRCode` varchar(255) DEFAULT NULL,
  `RoomImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`RoomID`, `BuildingID`, `RoomNumber`, `RoomCapacity`, `RoomStatus`, `RoomDescription`, `QRCode`, `RoomImage`) VALUES
(1, 1, '101', 30, 'Occupied', 'Standard classroom with projector', 'QR101', '../assets/images/c.jpg'),
(2, 2, '201', 20, 'Available', 'Chemistry lab with safety equipment', 'QR201', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `scanlogs`
--

CREATE TABLE `scanlogs` (
  `ScanID` int(11) NOT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ScanTime` datetime NOT NULL,
  `Action` enum('Occupied','Vacant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scanlogs`
--

INSERT INTO `scanlogs` (`ScanID`, `RoomID`, `UserID`, `ScanTime`, `Action`) VALUES
(1, 1, 2, '2025-05-03 07:59:00', 'Occupied'),
(2, 1, 2, '2025-05-03 10:01:00', 'Vacant');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('Admin','Professor','Maintenance','Students') NOT NULL,
  `ContactInfo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Name`, `Email`, `Password`, `Role`, `ContactInfo`) VALUES
(1, 'Alice Dela Cruz', 'alice@dyci.edu.ph', 'encryptedpass1', 'Admin', '09171234567'),
(2, 'Prof. John Reyes', 'john.reyes@dyci.edu.ph', 'encryptedpass2', 'Professor', '09181234567'),
(3, 'Mark Santos', 'mark.santos@dyci.edu.ph', 'encryptedpass3', 'Maintenance', '09221234567'),
(4, 'Alice Johnson', 'galicia.lordnatan.02009@dyci.edu.ph', 'password123', 'Students', '09179368714'),
(5, 'natangalicia', 'natandyci@gmail.com', '$2y$10$xZnBqa84HnTe3eFEjdItfONDxDAIpBSbofs7wn2uXkgqw4JiRXkEK', 'Professor', '09179368715'),
(7, 'natangalicia', 'natandyci23@gmail.com', '$2y$10$KLyMN/OHfLqHXJR.AD0pSu8N2IkEg7skgjpft4erSPK0UDn0vsxtW', 'Professor', '09179368715');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`BuildingID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `RoomID` (`RoomID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`ReservationID`),
  ADD KEY `RoomID` (`RoomID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`RoomID`),
  ADD KEY `BuildingID` (`BuildingID`);

--
-- Indexes for table `scanlogs`
--
ALTER TABLE `scanlogs`
  ADD PRIMARY KEY (`ScanID`),
  ADD KEY `RoomID` (`RoomID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `BuildingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `ReservationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `scanlogs`
--
ALTER TABLE `scanlogs`
  MODIFY `ScanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`RoomID`) REFERENCES `rooms` (`RoomID`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`RoomID`) REFERENCES `rooms` (`RoomID`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`BuildingID`) REFERENCES `buildings` (`BuildingID`);

--
-- Constraints for table `scanlogs`
--
ALTER TABLE `scanlogs`
  ADD CONSTRAINT `scanlogs_ibfk_1` FOREIGN KEY (`RoomID`) REFERENCES `rooms` (`RoomID`),
  ADD CONSTRAINT `scanlogs_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
