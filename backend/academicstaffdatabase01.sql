-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2023 at 07:28 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `academicstaffdatabase01`
--

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `requestID` int(11) NOT NULL,
  `fromStudent` int(11) DEFAULT NULL,
  `toStaff` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text,
  `requestStatus` int(11) DEFAULT NULL,
  `response` text,
  `dateTimeStart` datetime DEFAULT NULL,
  `dateTimeEnd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`requestID`, `fromStudent`, `toStaff`, `title`, `description`, `requestStatus`, `response`, `dateTimeStart`, `dateTimeEnd`) VALUES
(1, 1, 1, '', '', 2, 'ok', '1970-01-01 13:00:00', '1970-01-01 13:10:00'),
(2, 1, 1, 'Hello madm our project is not working', 'our backend and frontend our backend and frontend our backend and frontend our backend and frontend our backend and frontend our backend and frontend our backend and frontend our backend and frontend our backend and frontend our backend and frontend ', 2, 'okay we can meet tommorow', '2023-04-28 09:00:00', '2023-04-28 09:10:00'),
(3, 1, 1, 'About GPA', 'gpa is les and might be in batch miss list, what should i do sir', 2, 'okay come and meet me at the office', '2023-04-28 09:00:00', '2023-04-28 09:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `staffdetails`
--

CREATE TABLE `staffdetails` (
  `staffID` int(11) NOT NULL,
  `staffName` varchar(255) DEFAULT NULL,
  `staffPassword` varchar(255) DEFAULT NULL,
  `staffEmail` varchar(255) DEFAULT NULL,
  `staffContactNo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staffdetails`
--

INSERT INTO `staffdetails` (`staffID`, `staffName`, `staffPassword`, `staffEmail`, `staffContactNo`) VALUES
(1, 'staff01', 'staff01', 'staff01@email.com', '0710000011'),
(2, 'staff02', 'staff02', 'staff02@email.com', '0710000055'),
(3, 'staff03', 'staff03', 'staff03@email.com', '0710000066');

-- --------------------------------------------------------

--
-- Table structure for table `studentdetails`
--

CREATE TABLE `studentdetails` (
  `studentID` int(11) NOT NULL,
  `studentname` varchar(255) DEFAULT NULL,
  `studentPassword` varchar(255) DEFAULT NULL,
  `studentEmail` varchar(255) DEFAULT NULL,
  `studentContactNo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentdetails`
--

INSERT INTO `studentdetails` (`studentID`, `studentname`, `studentPassword`, `studentEmail`, `studentContactNo`) VALUES
(1, 'student01', 'student01', 'student01@email.com', '0710000022'),
(2, 'student02', 'student02', 'student02@email.com', '0710000033'),
(3, 'student03', 'student03', 'student03@email.com', '0710000044');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`requestID`),
  ADD KEY `fromStudent` (`fromStudent`),
  ADD KEY `toStaff` (`toStaff`);

--
-- Indexes for table `staffdetails`
--
ALTER TABLE `staffdetails`
  ADD PRIMARY KEY (`staffID`),
  ADD UNIQUE KEY `staffName` (`staffName`),
  ADD UNIQUE KEY `staffEmail` (`staffEmail`);

--
-- Indexes for table `studentdetails`
--
ALTER TABLE `studentdetails`
  ADD PRIMARY KEY (`studentID`),
  ADD UNIQUE KEY `studentname` (`studentname`),
  ADD UNIQUE KEY `studentEmail` (`studentEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `requestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staffdetails`
--
ALTER TABLE `staffdetails`
  MODIFY `staffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `studentdetails`
--
ALTER TABLE `studentdetails`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`fromStudent`) REFERENCES `studentdetails` (`studentID`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`toStaff`) REFERENCES `staffdetails` (`staffID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
