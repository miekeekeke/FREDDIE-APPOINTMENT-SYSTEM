-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2025 at 06:42 AM
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
-- Database: `freddie_repairshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `AppointmentID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `ServiceID` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Status` enum('Scheduled','Completed','Cancelled') DEFAULT 'Scheduled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `status` enum('Available','Not Available') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `ContactNum` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FeedbackID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `Rating` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leather_conditioning`
--

CREATE TABLE `leather_conditioning` (
  `LeatherConditioningID` int(11) NOT NULL,
  `ServiceName` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner_admin`
--

CREATE TABLE `owner_admin` (
  `AdminID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `RoleID` int(11) NOT NULL,
  `Role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `ServiceID` int(11) NOT NULL,
  `ShoeRepairID` int(11) NOT NULL,
  `ShoeCleaningID` int(11) NOT NULL,
  `LeatherConditioning` int(11) NOT NULL,
  `ShoePolishingID` int(11) NOT NULL,
  `LeatherConditioningID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shoe_cleaning`
--

CREATE TABLE `shoe_cleaning` (
  `ShoeCleaningID` int(11) NOT NULL,
  `ServiceName` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shoe_polishing`
--

CREATE TABLE `shoe_polishing` (
  `ShoePolishingID` int(11) NOT NULL,
  `ServiceName` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shoe_repair`
--

CREATE TABLE `shoe_repair` (
  `ShoeRepairID` int(11) NOT NULL,
  `ServiceName` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','staff','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'aldrian', '$2y$10$m3Es1w9f3X8BQtF8aAShn.HOje6wOFrKjK.JvbZq8ZEbFqN06SCgS', 'customer'),
(2, 'meg', '$2y$10$vAdZ6zRW2kFh/ozMlawmN.ArCFePGhtQvuZIwYEqPMp0kKoCJAUEK', 'staff'),
(3, 'michael', '$2y$10$.w3j3yTH6EGRqCwEy59ele8o/SZZsPgl5hUF3ekAqWhjheeLlte0G', 'admin'),
(5, 'japeth', '$2y$10$S1BpRbPt0pZX4DWkCuX7o.eidsG9iV4EaPoV5GPFAhGFEHmKucOPy', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`AppointmentID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `StaffID` (`StaffID`),
  ADD KEY `ServiceID` (`ServiceID`);

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date` (`date`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedbackID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `StaffID` (`StaffID`);

--
-- Indexes for table `leather_conditioning`
--
ALTER TABLE `leather_conditioning`
  ADD PRIMARY KEY (`LeatherConditioningID`);

--
-- Indexes for table `owner_admin`
--
ALTER TABLE `owner_admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD KEY `RoleID` (`RoleID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`ServiceID`),
  ADD KEY `ShoeRepairID` (`ShoeRepairID`),
  ADD KEY `ShoeCleaningID` (`ShoeCleaningID`),
  ADD KEY `ShoePolishingID` (`ShoePolishingID`),
  ADD KEY `LeatherConditioningID` (`LeatherConditioningID`);

--
-- Indexes for table `shoe_cleaning`
--
ALTER TABLE `shoe_cleaning`
  ADD PRIMARY KEY (`ShoeCleaningID`);

--
-- Indexes for table `shoe_polishing`
--
ALTER TABLE `shoe_polishing`
  ADD PRIMARY KEY (`ShoePolishingID`);

--
-- Indexes for table `shoe_repair`
--
ALTER TABLE `shoe_repair`
  ADD PRIMARY KEY (`ShoeRepairID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`),
  ADD KEY `RoleID` (`RoleID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `availability`
--
ALTER TABLE `availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FeedbackID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leather_conditioning`
--
ALTER TABLE `leather_conditioning`
  MODIFY `LeatherConditioningID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owner_admin`
--
ALTER TABLE `owner_admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shoe_cleaning`
--
ALTER TABLE `shoe_cleaning`
  MODIFY `ShoeCleaningID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shoe_polishing`
--
ALTER TABLE `shoe_polishing`
  MODIFY `ShoePolishingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shoe_repair`
--
ALTER TABLE `shoe_repair`
  MODIFY `ShoeRepairID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`StaffID`) REFERENCES `staff` (`StaffID`),
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`ServiceID`) REFERENCES `service` (`ServiceID`),
  ADD CONSTRAINT `appointment_ibfk_4` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`),
  ADD CONSTRAINT `appointment_ibfk_5` FOREIGN KEY (`StaffID`) REFERENCES `staff` (`StaffID`),
  ADD CONSTRAINT `appointment_ibfk_6` FOREIGN KEY (`ServiceID`) REFERENCES `service` (`ServiceID`),
  ADD CONSTRAINT `appointment_ibfk_7` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`),
  ADD CONSTRAINT `appointment_ibfk_8` FOREIGN KEY (`StaffID`) REFERENCES `staff` (`StaffID`),
  ADD CONSTRAINT `appointment_ibfk_9` FOREIGN KEY (`ServiceID`) REFERENCES `service` (`ServiceID`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`StaffID`) REFERENCES `staff` (`StaffID`);

--
-- Constraints for table `owner_admin`
--
ALTER TABLE `owner_admin`
  ADD CONSTRAINT `owner_admin_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `role` (`RoleID`),
  ADD CONSTRAINT `owner_admin_ibfk_2` FOREIGN KEY (`RoleID`) REFERENCES `role` (`RoleID`),
  ADD CONSTRAINT `owner_admin_ibfk_3` FOREIGN KEY (`RoleID`) REFERENCES `role` (`RoleID`);

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `service_ibfk_1` FOREIGN KEY (`ShoeRepairID`) REFERENCES `shoe_repair` (`ShoeRepairID`),
  ADD CONSTRAINT `service_ibfk_2` FOREIGN KEY (`ShoeCleaningID`) REFERENCES `shoe_cleaning` (`ShoeCleaningID`),
  ADD CONSTRAINT `service_ibfk_3` FOREIGN KEY (`ShoePolishingID`) REFERENCES `shoe_polishing` (`ShoePolishingID`),
  ADD CONSTRAINT `service_ibfk_4` FOREIGN KEY (`LeatherConditioningID`) REFERENCES `leather_conditioning` (`LeatherConditioningID`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `role` (`RoleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
