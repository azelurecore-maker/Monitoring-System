-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2026 at 10:51 AM
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
-- Database: `dilg_pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `role` varchar(50) NOT NULL,
  `barangay` varchar(100) NOT NULL DEFAULT '—',
  `password` varchar(255) NOT NULL,
  `date_added` date NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `role`, `barangay`, `password`, `date_added`, `status`) VALUES
(101, 'AdminSapianDILG', 'DILG Admin', '—', 'adminDILG', '2025-11-04', 'active'),
(102, 'Robin Delfin', 'Barangay Reporter', 'Agsilab', '7777777', '2026-11-11', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `barangay_folders` (created automatically from Add New User > Assigned Barangay)
--

CREATE TABLE IF NOT EXISTS `barangay_folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `allocated_budget` decimal(15,2) NOT NULL DEFAULT 0.00,
  `amount_utilized` decimal(15,2) NOT NULL DEFAULT 0.00,
  `description` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Pending',
  `submitted_by` varchar(150) DEFAULT NULL,
  `target_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `expense_items` longtext DEFAULT NULL,
  `progress` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `mode_of_implementation` varchar(20) DEFAULT NULL,
  `date_completed` date DEFAULT NULL,
  `photos` longtext DEFAULT NULL,
  `review_status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
