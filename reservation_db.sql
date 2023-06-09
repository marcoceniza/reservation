-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2023 at 01:17 AM
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
  `created_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `email`, `phone`, `room_type_id`, `created_status`) VALUES
(5, 'Enim distinctio Ven', 'Beatae maxime dolore', 'lyfetan@mailinator.com', 123, 18, 1),
(6, 'Debitis sed voluptat', 'Minima culpa sed ni', 'kemafogim@mailinator.com', 1234567, 19, 1),
(7, 'Ea ab velit fugiat ', 'Animi quia perspici', 'qalyxaluf@mailinator.com', 1234, 20, 1),
(8, 'Do deleniti commodi ', 'Et neque qui duis ir', 'qikysuje@mailinator.com', 123450, 21, 1),
(17, 'Occaecat reprehender', 'Doloremque ipsam inv', 'maguq@mailinator.com', 213123, 18, 0);

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
(1, 'my first name', 'my last name', 30, 0, 'full street address'),
(2, 'my first name', 'my last name', 30, 0, 'full street address');

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
(3, 5, 18, '2023-06-05 00:00:00', '2023-06-06 00:00:00', 1),
(4, 6, 19, '2023-06-08 00:00:00', '2023-06-09 00:00:00', 1),
(5, 5, 18, '2023-06-12 12:30:00', '2023-06-15 17:30:00', 1),
(6, 5, 18, '2023-06-05 14:02:00', '2023-06-07 16:32:00', 1),
(7, 7, 20, '2023-06-05 16:00:00', '2023-06-07 18:00:00', 1),
(8, 7, 20, '2023-06-15 16:00:00', '2023-06-16 18:00:00', 1),
(9, 7, 20, '2023-06-15 16:00:00', '2023-06-16 18:00:00', 1),
(10, 6, 19, '2023-06-22 17:00:00', '2023-06-23 19:00:00', 1),
(11, 6, 19, '2023-06-16 17:00:00', '2023-06-17 18:00:00', 1),
(12, 6, 19, '2023-06-16 22:22:00', '2023-06-17 21:00:00', 1),
(13, 6, 19, '2023-06-06 12:12:00', '2023-06-07 12:23:00', 1),
(14, 5, 18, '2023-06-08 12:12:00', '2023-06-09 12:22:00', 1),
(15, 5, 18, '2023-06-06 12:12:00', '2023-06-07 22:22:00', 1),
(16, 7, 20, '2023-06-13 12:22:00', '2023-06-13 15:33:00', 1),
(17, 6, 19, '2023-06-14 12:22:00', '2023-06-15 14:02:00', 1);

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
(18, 'Illo quo non quis hi', 12, 24.00, '1685424032_4fe3e7ed977fab31b7ee.jpg', 1, 'Enim maxime cum expe', '2023-05-30 05:20:32', '0000-00-00 00:00:00'),
(19, 'Accusantium dolores ', 8, 15.00, '1685424129_974741152bd600de7e5c.jpg', 0, 'In aut maxime id iru', '2023-05-30 05:22:09', '0000-00-00 00:00:00'),
(20, 'Quas ad earum saepe ', 22, 11.00, '1685803909_9fb33475df71623f00f1.jpg', 1, 'Aut quia voluptatibu', '2023-06-03 14:51:49', '0000-00-00 00:00:00'),
(21, 'Laboris nostrum illu', 32, 44.00, '1685806309_de691a1d62547c15fcdd.jpg', 0, 'Qui velit ipsum in ', '2023-06-03 15:31:49', '2023-06-03 15:33:36');

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
(6, 'admin@gmail.com', '$2y$10$MT3ZXL5UY4QCEBX9ojCJGec26.8FfYQ9/.G5f9PHirqVlH3LJCFUm', 0, 1),
(7, 'me@mydomain.com', '$2y$10$5XWp39/8Egxt5PgZlX9y8u427kXyt3Wgnxl0c8SNX94GHiKtORJ/a', 0, 2);

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
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `room_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
