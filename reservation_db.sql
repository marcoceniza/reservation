-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2023 at 06:01 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservation_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `created_status` int(11) NOT NULL,
  `reserved_date` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `email`, `phone`, `room_type_id`, `created_status`, `reserved_date`) VALUES
(28, 'John', 'Doe', 'johndoe@gmail.com', 1234567890, 25, 1, '2023-06-16 14:22:23.000000'),
(29, 'Alice', 'Wonderland', 'alicewonderland@gmail.com', 1234567890, 26, 0, '2023-06-16 14:33:54.000000');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `profile_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `phone` int(20) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profile_id`, `first_name`, `last_name`, `age`, `phone`, `address`) VALUES
(3, 'Jan', 'Devson', 30, 1234567890, 'full street address');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `customer_id`, `room_type_id`, `start_date`, `end_date`, `status`) VALUES
(21, 28, 25, '2023-06-28 12:00:00', '2023-06-30 20:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE `room_type` (
  `room_type_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `category` int(11) NOT NULL COMMENT '1-with Aircon, 0-without Aircon ',
  `location` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_type`
--

INSERT INTO `room_type` (`room_type_id`, `name`, `capacity`, `price`, `photo`, `category`, `location`, `created_at`, `updated_at`) VALUES
(25, 'Bohol Beach Club, Bohol', 12, 23.00, '1686865617_5fdd44add02af909eb84.png', 1, 'Bohol, Philippines', '2023-06-15 21:46:57', '0000-00-00 00:00:00'),
(26, 'Plantation Bay Resort, Cebu', 12, 16.00, '1686865997_90f94e209c36431c3ae6.jpg', 1, 'Cebu, Philippines', '2023-06-15 21:53:17', '0000-00-00 00:00:00'),
(29, 'Miniloc Island Resort, El Nido', 12, 44.00, '1686868293_876ebcd0556e9fe14e15.jpg', 0, 'El Nido, Philippines', '2023-06-15 22:31:33', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT 0 COMMENT '0-customer, 1-admin',
  `profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `user_type`, `profile_id`) VALUES
(8, 'admin@gmail.com', '$2y$10$V.Ti3mapkbuA8SWuRysWW.5x6Gk13tRRjshML2anel62350DFtn9W', 1, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `room_type_id` (`room_type_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`profile_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `room_type_id` (`room_type_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`room_type_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_ibfk_1` (`profile_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `room_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`room_type_id`) REFERENCES `room_type` (`room_type_id`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`room_type_id`) REFERENCES `room_type` (`room_type_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
