-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2020 at 12:45 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plivo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_group`
--

CREATE TABLE `add_group` (
  `add_group_id` int(11) NOT NULL,
  `add_group_name` varchar(255) NOT NULL,
  `add_group_status` int(4) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `add_group`
--

INSERT INTO `add_group` (`add_group_id`, `add_group_name`, `add_group_status`, `createdon`) VALUES
(1, 'Group 1', 1, '2020-07-21 10:49:53'),
(2, 'Group 2', 1, '2020-07-21 10:54:26'),
(3, 'Group 3', 1, '2020-07-21 10:56:16'),
(4, 'Group 4', 1, '2020-07-21 11:01:05'),
(5, 'My G', 1, '2020-07-22 09:49:26');

-- --------------------------------------------------------

--
-- Table structure for table `numbers`
--

CREATE TABLE `numbers` (
  `numbers_id` int(11) NOT NULL,
  `numbers_first_name` varchar(255) NOT NULL,
  `numbers_last_name` varchar(255) NOT NULL,
  `numbers_address` varchar(255) NOT NULL,
  `numbers_phone_number` varchar(255) NOT NULL,
  `numbers_phone_type` varchar(255) NOT NULL,
  `numbers_group_id` int(11) NOT NULL,
  `numbers_status` int(4) NOT NULL DEFAULT 1,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `numbers`
--

INSERT INTO `numbers` (`numbers_id`, `numbers_first_name`, `numbers_last_name`, `numbers_address`, `numbers_phone_number`, `numbers_phone_type`, `numbers_group_id`, `numbers_status`, `createdon`) VALUES
(1, 'Chris', 'Paul', 'ABC Street', '267-952-6061', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(2, 'Chris', 'Paul', 'ABC Street', '267-952-6060', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(3, 'Chris', 'Paul', 'ABC Street', '267-929-0495', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(4, 'Chris', 'Paul', 'ABC Street', '267-890-7739', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(5, 'Chris', 'Paul', 'ABC Street', '267-870-8080', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(6, 'Chris', 'Paul', 'ABC Street', '267-863-8036', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(7, 'Chris', 'Paul', 'ABC Street', '267-855-1181', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(8, 'Chris', 'Paul', 'ABC Street', '267-839-0468', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(9, 'Chris', 'Paul', 'ABC Street', '267-839-0467', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(10, 'Chris', 'Paul', 'ABC Street', '267-827-2015', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(11, 'Chris', 'Paul', 'ABC Street', '267-823-8442', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(12, 'Chris', 'Paul', 'ABC Street', '267-810-1014', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(13, 'Chris', 'Paul', 'ABC Street', '267-787-1359', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(14, 'Chris', 'Paul', 'ABC Street', '267-787-1355', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(15, 'Chris', 'Paul', 'ABC Street', '267-783-1041', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(16, 'Chris', 'Paul', 'ABC Street', '267-754-1827', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(17, 'Chris', 'Paul', 'ABC Street', '267-754-0548', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(18, 'Chris', 'Paul', 'ABC Street', '267-732-0106', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(19, 'Chris', 'Paul', 'ABC Street', '267-726-3665', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(20, 'Chris', 'Paul', 'ABC Street', '267-726-3544', 'Mobile', 1, 1, '2020-07-21 11:29:21'),
(21, 'Chris', 'Paul', 'ABC Street', '267-723-7819', 'Mobile', 1, 1, '2020-07-21 11:29:22'),
(22, 'Chris', 'Paul', 'ABC Street', '267-719-1382', 'Mobile', 1, 1, '2020-07-21 11:29:22'),
(23, 'Chris', 'Paul', 'ABC Street', '267-715-0739', 'Mobile', 1, 1, '2020-07-21 11:29:22'),
(24, 'Chris', 'Paul', 'ABC Street', '267-715-0735', 'Mobile', 1, 1, '2020-07-21 11:29:22'),
(25, 'Chris', 'Paul', 'ABC Street', '267-692-0051', 'Mobile', 1, 1, '2020-07-21 11:29:22'),
(26, 'Chris', 'Paul', 'ABC Street', '267-680-8148', 'Mobile', 1, 1, '2020-07-21 11:29:22'),
(27, 'Chris', 'Paul', 'ABC Street', '267-668-2920', 'Mobile', 1, 1, '2020-07-21 11:29:22'),
(28, 'Chris', 'Paul', 'ABC Street', '267-651-0098', 'Mobile', 1, 1, '2020-07-21 11:29:22'),
(29, 'Chris', 'Paul', 'ABC Street', '267-641-0347', 'Mobile', 1, 1, '2020-07-21 11:29:22'),
(30, 'Chris', 'Paul', 'ABC Street', '267-952-6061', 'Mobile', 2, 1, '2020-07-21 13:16:42'),
(31, 'Chris', 'Paul', 'ABC Street', '267-952-6060', 'Mobile', 2, 1, '2020-07-21 13:16:42'),
(32, 'Chris', 'Paul', 'ABC Street', '267-929-0495', 'Mobile', 2, 1, '2020-07-21 13:16:42'),
(33, 'Chris', 'Paul', 'ABC Street', '267-890-7739', 'Mobile', 2, 1, '2020-07-21 13:16:42'),
(34, 'Chris', 'Paul', 'ABC Street', '267-870-8080', 'Mobile', 2, 1, '2020-07-21 13:16:42'),
(35, 'Chris', 'Paul', 'ABC Street', '267-863-8036', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(36, 'Chris', 'Paul', 'ABC Street', '267-855-1181', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(37, 'Chris', 'Paul', 'ABC Street', '267-839-0468', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(38, 'Chris', 'Paul', 'ABC Street', '267-839-0467', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(39, 'Chris', 'Paul', 'ABC Street', '267-827-2015', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(40, 'Chris', 'Paul', 'ABC Street', '267-823-8442', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(41, 'Chris', 'Paul', 'ABC Street', '267-810-1014', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(42, 'Chris', 'Paul', 'ABC Street', '267-787-1359', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(43, 'Chris', 'Paul', 'ABC Street', '267-787-1355', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(44, 'Chris', 'Paul', 'ABC Street', '267-783-1041', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(45, 'Chris', 'Paul', 'ABC Street', '267-754-1827', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(46, 'Chris', 'Paul', 'ABC Street', '267-754-0548', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(47, 'Chris', 'Paul', 'ABC Street', '267-732-0106', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(48, 'Chris', 'Paul', 'ABC Street', '267-726-3665', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(49, 'Chris', 'Paul', 'ABC Street', '267-726-3544', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(50, 'Chris', 'Paul', 'ABC Street', '267-723-7819', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(51, 'Chris', 'Paul', 'ABC Street', '267-719-1382', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(52, 'Chris', 'Paul', 'ABC Street', '267-715-0739', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(53, 'Chris', 'Paul', 'ABC Street', '267-715-0735', 'Mobile', 2, 1, '2020-07-21 13:16:43'),
(54, 'Chris', 'Paul', 'ABC Street', '267-692-0051', 'Mobile', 2, 1, '2020-07-21 13:16:44'),
(55, 'Chris', 'Paul', 'ABC Street', '267-680-8148', 'Mobile', 2, 1, '2020-07-21 13:16:44'),
(56, 'Chris', 'Paul', 'ABC Street', '267-668-2920', 'Mobile', 2, 1, '2020-07-21 13:16:44'),
(57, 'Chris', 'Paul', 'ABC Street', '267-651-0098', 'Mobile', 2, 1, '2020-07-21 13:16:44'),
(58, 'Chris', 'Paul', 'ABC Street', '267-641-0347', 'Mobile', 2, 1, '2020-07-21 13:16:44'),
(59, 'Gerald', 'Eley', '347 N Wilton St', '2155002459', 'Mobile', 5, 1, '2020-07-22 09:52:07'),
(60, 'Chris', 'Paul', 'ABC Street', '267-952-6060', 'Mobile', 5, 1, '2020-07-22 09:52:07');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`id`, `user_name`, `password`) VALUES
(1, 'admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_group`
--
ALTER TABLE `add_group`
  ADD PRIMARY KEY (`add_group_id`);

--
-- Indexes for table `numbers`
--
ALTER TABLE `numbers`
  ADD PRIMARY KEY (`numbers_id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_group`
--
ALTER TABLE `add_group`
  MODIFY `add_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `numbers`
--
ALTER TABLE `numbers`
  MODIFY `numbers_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
