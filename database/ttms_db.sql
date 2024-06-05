-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2023 at 09:42 PM
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
-- Database: `ttms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill_list`
--

CREATE TABLE `bill_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `user_id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `tax_category` int(11) NOT NULL,
  `company_name` text NOT NULL,
  `company_registration` text NOT NULL,
  `owner` text NOT NULL,
  `balance` float(12,2) NOT NULL DEFAULT 0.00,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `revenue` double NOT NULL,
  `income_tax` double NOT NULL,
  `tax_penalty` double NOT NULL,
  `extra_payment` double NOT NULL,
  `total_tax_amount` double NOT NULL,
  `payment_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_list`
--

INSERT INTO `bill_list` (`id`, `code`, `user_id`, `category_id`, `tax_category`, `company_name`, `company_registration`, `owner`, `balance`, `date_created`, `date_updated`, `revenue`, `income_tax`, `tax_penalty`, `extra_payment`, `total_tax_amount`, `payment_status`) VALUES
(11, '', 1, 0, 0, 'sdsdsds', '2147483647', 'wsdd', 0.00, '2023-07-03 10:04:57', '2023-07-03 10:27:51', 121212, 121212, 1212, 1212, 1212, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(6, 'Xyz', 1, 0, '2023-07-03 06:09:37', '2023-07-03 10:26:09');

-- --------------------------------------------------------

--
-- Table structure for table `compliant_list`
--

CREATE TABLE `compliant_list` (
  `name` varchar(255) NOT NULL,
  `delete_flag` int(1) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `tin_number` int(11) NOT NULL,
  `compliant` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compliant_list`
--

INSERT INTO `compliant_list` (`name`, `delete_flag`, `company_name`, `tin_number`, `compliant`, `status`, `date_created`) VALUES
('sssdsdss', 0, 'wewewe', 1212121, '12121212qqwqwqw', 0, '2023-07-03');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Tax Management System'),
(6, 'short_name', 'TTMS - PHP'),
(11, 'logo', 'uploads/logo.png?v=1651131091'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover.png?v=1651131093');

-- --------------------------------------------------------

--
-- Table structure for table `tax_payer_list`
--

CREATE TABLE `tax_payer_list` (
  `id` int(30) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` varchar(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `house_number` int(11) NOT NULL,
  `house_size` varchar(255) NOT NULL,
  `house_ownership` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_registration` int(11) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `code` int(11) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_payment_history`
--

CREATE TABLE `tax_payment_history` (
  `id` int(30) NOT NULL,
  `pass_id` int(30) NOT NULL,
  `toll_id` int(30) NOT NULL,
  `cost` float(12,2) NOT NULL DEFAULT 0.00,
  `user_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `owner` varchar(255) NOT NULL,
  `company_registration` int(11) NOT NULL,
  `total_tax_amount` double NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `tax_category` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `revenue` double NOT NULL,
  `income_tax` double NOT NULL,
  `extra_payment` double NOT NULL,
  `tax_penalty` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tax_payment_history`
--

INSERT INTO `tax_payment_history` (`id`, `pass_id`, `toll_id`, `cost`, `user_id`, `date_created`, `date_updated`, `owner`, `company_registration`, `total_tax_amount`, `company_name`, `tax_category`, `payment_status`, `revenue`, `income_tax`, `extra_payment`, `tax_penalty`) VALUES
(5, 0, 0, 0.00, 1, '2023-07-03 10:13:50', '2023-07-03 10:13:50', 'wsdd', 2147483647, 1212, 'sdsdsds', 6, 1, 121212, 121212, 1212, 1212);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `toll_id` int(30) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `toll_id`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', NULL, 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatars/1.png?v=1649834664', NULL, 1, NULL, '2021-01-20 14:02:37', '2022-04-13 15:24:24'),
(2, 'Claire', 'C', 'Blake', 'cblake', '25d55ad283aa400af464c76d713c07ad', 'uploads/avatars/2.png?v=1651131001', NULL, 2, NULL, '2022-04-28 15:30:01', '2023-07-03 05:02:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill_list`
--
ALTER TABLE `bill_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_payer_list`
--
ALTER TABLE `tax_payer_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_payment_history`
--
ALTER TABLE `tax_payment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pass_id` (`pass_id`),
  ADD KEY `toll_id` (`toll_id`),
  ADD KEY `cost` (`cost`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `toll_id` (`toll_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill_list`
--
ALTER TABLE `bill_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tax_payer_list`
--
ALTER TABLE `tax_payer_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tax_payment_history`
--
ALTER TABLE `tax_payment_history`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill_list`
--
ALTER TABLE `bill_list`
  ADD CONSTRAINT `user_id_fk_pl` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `toll_id_fk_ul` FOREIGN KEY (`toll_id`) REFERENCES `tax_payer_list` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
