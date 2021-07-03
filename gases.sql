-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2021 at 11:16 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gases`
--

-- --------------------------------------------------------

--
-- Table structure for table `gases`
--

CREATE TABLE `gases` (
  `id` int(11) NOT NULL,
  `CO` int(11) NOT NULL,
  `AQI` int(11) NOT NULL,
  `NO2` int(11) NOT NULL,
  `O3` int(11) NOT NULL,
  `FineParticles` int(11) NOT NULL,
  `CourseParticles` int(11) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gases`
--

INSERT INTO `gases` (`id`, `CO`, `AQI`, `NO2`, `O3`, `FineParticles`, `CourseParticles`, `lat`, `lng`, `type`) VALUES
(1, 70, 86, 19, 36, 26, 19, 13.754350, 100.620453, 'คณะวิศวกรรมศาสตร์'),
(2, 16, 27, 84, 38, 39, 83, 23.814095, 86.440071, 'OAT'),
(3, 95, 28, 56, 95, 9, 58, 23.811882, 86.440819, 'CSEDEPT'),
(4, 65, 49, 53, 15, 17, 40, 23.814287, 86.442741, 'Director'),
(5, 48, 20, 55, 18, 22, 57, 23.814919, 86.442497, 'Library');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gases`
--
ALTER TABLE `gases`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gases`
--
ALTER TABLE `gases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
