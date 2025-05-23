-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 06:42 AM
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
-- Database: `sample`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `DeptID` int(11) NOT NULL,
  `DeptName` text NOT NULL,
  `MgrEmpID` int(11) NOT NULL,
  `Budget` decimal(10,0) NOT NULL,
  `DeptCity` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`DeptID`, `DeptName`, `MgrEmpID`, `Budget`, `DeptCity`) VALUES
(1, 'DPSM', 55, 100000, 'Wellington'),
(2, 'Dummy Department', 54, 200000, 'Auckland'),
(3, 'Ghost Department', 53, 0, 'Iloilo');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EmpID` int(11) NOT NULL,
  `EmpName` text NOT NULL,
  `Age` int(11) NOT NULL,
  `Salary` decimal(10,4) NOT NULL,
  `HireDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EmpID`, `EmpName`, `Age`, `Salary`, `HireDate`) VALUES
(6, 'Robert Winson', 0, 40000.2500, '0000-00-00'),
(7, 'Robert Winson', 30, 40000.2500, '2018-11-01'),
(48, 'manammm', 22, 23000.0000, '2025-05-01'),
(51, 'ghost wreck', 20, 19000.0000, '2025-05-11'),
(53, 'Mana', 20, 12000.0000, '2025-05-06'),
(54, 'Whoever', 50, 190000.0000, '2024-12-30'),
(55, 'hahahahah', 12, 120000.0000, '2025-02-08'),
(56, 'Mana', 20, 19000.0000, '2025-05-06'),
(57, 'lalalalala tralala', 29, 100000.0000, '2025-05-18'),
(60, 'hahahahah', 20, 999999.9999, '2025-04-29');

-- --------------------------------------------------------

--
-- Table structure for table `work`
--

CREATE TABLE `work` (
  `EmpID` int(11) NOT NULL,
  `DeptID` int(11) NOT NULL,
  `Percent_Time` decimal(10,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `work`
--

INSERT INTO `work` (`EmpID`, `DeptID`, `Percent_Time`) VALUES
(1, 1, 100.0000),
(36, 3, 100.0000),
(37, 3, 50.0000),
(38, 3, 100.0000),
(48, 1, 40.0000),
(51, 3, 20.0000),
(53, 3, 10.0000),
(54, 2, 50.0000),
(55, 1, 20.0000),
(56, 2, 16.0000),
(57, 3, 45.0000),
(60, 2, 12.0000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DeptID`),
  ADD UNIQUE KEY `MgrEmpID` (`MgrEmpID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmpID`);

--
-- Indexes for table `work`
--
ALTER TABLE `work`
  ADD UNIQUE KEY `EmpID` (`EmpID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `DeptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `EmpID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
