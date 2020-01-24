-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2020 at 08:54 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adomantrareports`
--
CREATE DATABASE IF NOT EXISTS `adomantrareports` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `adomantrareports`;

-- --------------------------------------------------------

--
-- Table structure for table `additional_info`
--

CREATE TABLE `additional_info` (
  `id` int(11) NOT NULL,
  `deviceInfo` varchar(100) NOT NULL,
  `adTypeInfo` varchar(255) NOT NULL,
  `pieceDetailsInfo` varchar(255) NOT NULL,
  `creativeUnitInfo` varchar(255) NOT NULL,
  `unitBuyInfo` varchar(255) NOT NULL,
  `CTRInfo` varchar(255) NOT NULL,
  `inserted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `additional_info`
--

INSERT INTO `additional_info` (`id`, `deviceInfo`, `adTypeInfo`, `pieceDetailsInfo`, `creativeUnitInfo`, `unitBuyInfo`, `CTRInfo`, `inserted_date`, `updated_date`, `updated_by`) VALUES
(1, 'OLA APP', 'Native Banner', 'Capture short bursts of attention with in-feed small banner ads. A small banner ad contains three components image, ad copy just below the image containing primary text, secondary text, CTA and promotional offers.', '84*84', 'CPM', '0.5%-1.2%', '2019-11-20 11:43:14', '2019-11-20 11:43:14', 1),
(2, 'OLA APP', 'Single Banner', 'Capture short bursts of attention with image ads. An image adconsists of 3 elements,image,adcopy just\r\nbelow the image containing primary text, secondary text,CTA and offers if any\"', '336*180', 'CPM', '0.5%-1.2%', '2019-11-20 11:57:13', '2019-12-03 06:25:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `additional_targeting`
--

CREATE TABLE `additional_targeting` (
  `id` int(11) NOT NULL,
  `type_target` varchar(255) NOT NULL,
  `adtypeID` int(11) NOT NULL,
  `status` int(1) NOT NULL COMMENT 'Inactive=0;Active=1',
  `rate` varchar(50) NOT NULL,
  `inserted_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `crud_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `additional_targeting`
--

INSERT INTO `additional_targeting` (`id`, `type_target`, `adtypeID`, `status`, `rate`, `inserted_time`, `updated_time`, `crud_by`) VALUES
(1, 'Cab Type- Auto, Bike and Share', 1, 1, '100', '2019-11-13 04:29:36', '2019-11-25 11:04:25', '1'),
(2, 'Cab Type- Micro and Mini', 1, 1, '150', '2019-11-13 04:29:36', '2019-11-25 11:04:28', '1'),
(3, 'Cab Type- Prime- Play, Executive, SUV', 1, 1, '200', '2019-11-13 04:30:15', '2019-11-25 11:04:30', '1'),
(4, 'Cohorts( Airport, Premium Apartments, Working Professionals)', 2, 1, '200', '2019-11-13 04:30:15', '2019-11-25 11:04:32', '1'),
(5, 'Time, Location, Gender, Income Level', 2, 1, '200', '2019-11-13 04:30:54', '2019-11-25 11:04:35', '1'),
(6, 'Pass through Ads( Geo-Fencing)( Ola Play)', 2, 1, '200', '2019-11-13 04:30:54', '2019-11-25 11:04:37', '1'),
(7, 'OS Segregation( Android vs IOS Users)', 3, 1, '100', '2019-11-13 04:31:09', '2019-11-25 11:04:41', '1'),
(8, 'Unique CTA', 3, 1, '100', '2019-11-13 04:32:08', '2019-11-25 11:04:43', '1'),
(9, 'Lead Generation Form', 4, 1, '200', '2019-11-13 04:32:08', '2019-11-25 11:04:46', '1'),
(10, 'Click to Call', 5, 1, '200', '2019-11-13 04:32:23', '2019-11-25 11:04:48', '1'),
(11, 'cab data', 9, 1, '400', '2019-12-03 05:55:17', '2019-12-03 05:55:17', ''),
(12, 'geo', 10, 1, '200', '2019-12-03 10:14:00', '2019-12-03 10:14:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `adtype`
--

CREATE TABLE `adtype` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `typeRate` varchar(100) NOT NULL,
  `deviceId` int(1) NOT NULL COMMENT 'fromDeviceTable',
  `status` int(1) NOT NULL COMMENT 'Inactive=0;Active=1',
  `inserted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `crud_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adtype`
--

INSERT INTO `adtype` (`id`, `type`, `typeRate`, `deviceId`, `status`, `inserted_date`, `updated_date`, `crud_by`) VALUES
(1, 'Native Banner', '100', 1, 1, '2019-11-12 10:08:39', '2019-11-13 07:08:16', ''),
(2, 'Single Banner', '200', 1, 1, '2019-11-12 10:08:39', '2019-11-13 07:08:19', ''),
(3, 'Carousel Banner', '300', 1, 1, '2019-11-12 10:08:51', '2019-11-13 07:08:22', ''),
(4, 'Single Banner', '100', 2, 1, '2019-11-12 10:09:22', '2019-11-13 07:08:24', ''),
(5, 'Carousel Banner', '200', 2, 1, '2019-11-12 10:09:22', '2019-11-13 07:08:27', ''),
(6, 'Video', '100', 2, 1, '2019-11-12 10:09:50', '2019-11-13 07:08:31', ''),
(7, 'Auto Play Video', '300', 2, 1, '2019-11-12 10:09:50', '2019-11-13 07:08:34', ''),
(9, 'floting banner', '150', 5, 1, '2019-12-03 04:56:04', '2019-12-03 04:56:04', ''),
(10, 'native banner', '200', 6, 1, '2019-12-03 10:13:35', '2019-12-03 10:13:35', '');

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `deviceType` varchar(100) NOT NULL,
  `status` int(1) NOT NULL COMMENT 'Inactive=0;Active=1',
  `inserted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `crud_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`id`, `deviceType`, `status`, `inserted_date`, `updated_date`, `crud_by`) VALUES
(1, 'OLA APP', 1, '2019-11-12 09:40:29', '2019-11-12 09:40:29', ''),
(2, 'OLA Play', 1, '2019-11-12 09:40:29', '2019-11-12 09:40:29', ''),
(3, 'Swiggy', 1, '2019-11-25 09:11:41', '2019-11-25 09:11:41', '1'),
(4, 'Uber', 1, '2019-11-25 09:11:41', '2019-11-25 09:11:41', '1'),
(5, 'adotrip', 1, '2019-12-02 08:38:35', '2019-12-02 08:38:35', ''),
(6, 'adomantra', 1, '2019-12-03 10:12:21', '2019-12-03 10:12:21', '');

-- --------------------------------------------------------

--
-- Table structure for table `screenshot`
--

CREATE TABLE `screenshot` (
  `id` int(11) NOT NULL,
  `deviceInfo` varchar(50) NOT NULL,
  `adTypeInfo` varchar(100) NOT NULL,
  `screenshot_path` varchar(255) NOT NULL,
  `inserted_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `screenshot`
--

INSERT INTO `screenshot` (`id`, `deviceInfo`, `adTypeInfo`, `screenshot_path`, `inserted_time`, `updated_time`, `updated_by`) VALUES
(1, 'OLA APP', 'Native Banner', 'assets/media/client-logos/native_banner.png', '2019-11-21 06:38:57', '2019-11-21 07:31:08', 1),
(2, 'OLA APP', 'Single Banner', 'assets/media/client-logos/single_banner.png', '2019-11-21 06:49:50', '2019-11-21 07:10:46', 1),
(4, 'adotrip', 'floting banner', 'native_banner.png', '2019-12-03 08:26:46', '2019-12-03 08:26:46', 0),
(5, 'adotrip', 'floting banner', '/assets/media/client-logos/native_banner.png', '2019-12-03 08:27:57', '2019-12-03 08:27:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` int(1) NOT NULL COMMENT 'admin=1;ops=2;sales=3',
  `status` int(1) NOT NULL COMMENT 'inactive=0;active=1',
  `inserted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `type`, `status`, `inserted_date`, `updated_date`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin@123', 1, 1, '2019-11-12 06:26:20', '2019-11-12 06:26:20'),
(2, 'abhishek srivastav', 'abhi@gmail.com', 'abhi@123', 2, 1, '2019-11-12 06:26:59', '2019-11-12 06:26:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_info`
--
ALTER TABLE `additional_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `additional_targeting`
--
ALTER TABLE `additional_targeting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adtype`
--
ALTER TABLE `adtype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `screenshot`
--
ALTER TABLE `screenshot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_info`
--
ALTER TABLE `additional_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `additional_targeting`
--
ALTER TABLE `additional_targeting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `adtype`
--
ALTER TABLE `adtype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `screenshot`
--
ALTER TABLE `screenshot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
