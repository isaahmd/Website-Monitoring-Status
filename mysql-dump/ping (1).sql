-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 01, 2024 at 06:06 AM
-- Server version: 8.0.35-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

CREATE DATABASE ping;
USE ping;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ping`
--

-- --------------------------------------------------------

--
-- Table structure for table `google_services`
--

CREATE TABLE `google_services` (
  `id` int NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `google_services`
--

INSERT INTO `google_services` (`id`, `ip`, `status`, `description`) VALUES
(1, '8.8.8.8', 0, 'Google'),
(2, 'youtube.com', 0, 'Youtube'),
(3, 'mail.google.com', 0, 'Email Google'),
(4, 'drive.google.com', 0, 'Storage Google');


-- --------------------------------------------------------

--
-- Table structure for table `microsoft_services`
--

CREATE TABLE `microsoft_services` (
  `id` int NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `microsoft_services`
--

INSERT INTO `microsoft_services` (`id`, `ip`, `status`, `description`) VALUES
(1, 'bing.com', 1, 'Bing Search Engine'),
(2, 'outlook.office.com', 0, 'Email Microsoft'),
(3, 'onedrive.live.com', 0, 'Email Microsoft'),
(4, 'teams.microsoft.com', 0, 'Video Conference Microsoft'); 
--
-- Indexes for dumped tables
--

--
-- Indexes for table `brilian_table`
--
ALTER TABLE `google_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bri_table`
--
ALTER TABLE `microsoft_services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brilian_table`
--
ALTER TABLE `google_services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `bri_table`
--
ALTER TABLE `microsoft_services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
