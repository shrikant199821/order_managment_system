-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 12:30 PM
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
-- Database: `oms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `email`) VALUES
(1, 'shrikant', 'shrikant@gmail.com'),
(15, 'user 1', 'user1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_value` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `user_id`, `order_date`, `total_value`) VALUES
(23, NULL, 15, '2024-11-12 12:40:17', 0.00),
(24, 15, 15, '2024-11-12 12:42:42', 160.00),
(25, NULL, 15, '2024-11-12 12:42:45', 0.00),
(26, NULL, 15, '2024-11-12 12:42:47', 0.00),
(27, NULL, 15, '2024-11-12 12:48:16', 0.00),
(28, NULL, 15, '2024-11-12 12:48:24', 0.00),
(29, NULL, 15, '2024-11-12 12:49:03', 0.00),
(30, NULL, 15, '2024-11-12 12:49:05', 0.00),
(31, NULL, 15, '2024-11-12 12:49:34', 0.00),
(32, NULL, 15, '2024-11-12 12:49:36', 0.00),
(33, NULL, 15, '2024-11-12 12:49:37', 0.00),
(34, NULL, 15, '2024-11-12 12:49:38', 0.00),
(35, NULL, 15, '2024-11-12 12:49:38', 0.00),
(36, 15, 15, '2024-11-12 13:14:26', 210.00),
(37, 1, 15, '2024-11-12 13:39:54', 1200.00),
(38, 1, 15, '2024-11-12 13:46:24', 2000.00),
(39, 1, 15, '2024-11-12 13:46:57', 2000.00),
(40, 1, 1, '2024-11-12 16:10:59', 1100.00),
(41, 15, 1, '2024-11-12 16:16:52', 1250.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`detail_id`, `order_id`, `product_name`, `quantity`, `price`) VALUES
(12, 24, 'Red Wine Glass Spill', 2, 20.00),
(13, 24, 'Orange', 4, 30.00),
(14, 36, 'Tomato', 1, 10.00),
(15, 36, 'Potato', 2, 100.00),
(16, 37, 'glass', 30, 40.00),
(17, 38, 'glass', 20, 100.00),
(18, 39, 'glass', 20, 100.00),
(19, 40, 'Red Wine Glass Spill', 10, 50.00),
(20, 40, 'Tomato', 20, 30.00),
(21, 41, 'Red Wine Glass Spill', 5, 50.00),
(22, 41, 'Tomato', 20, 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `PASSWORD`) VALUES
(1, 'shrikant', 'shrikant@gmail.com', '$2y$10$qMGL.03sL7uiqgkFV9SJOO.Cmr3hfQbgby5J8GOOyr5mrpQMRy2Qe'),
(15, 'user 1', 'user1@gmail.com', '$2y$10$8GTaUZW3kOoFo.iwr4izvunlCMI21WBc4BO7vWXeKMQQ.LIxeoNS.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
