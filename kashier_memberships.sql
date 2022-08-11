-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 11, 2022 at 03:14 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kashier_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `installments_period` varchar(255) NOT NULL,
  `installments_amount` varchar(255) NOT NULL,
  `kashier_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `customer_name`, `customer_email`, `total_amount`, `installments_period`, `installments_amount`, `kashier_id`) VALUES
(50, 'demo', 'demo', 'demo', 'demo', 'demo', 'demo'),
(51, 'testtesttest', 'testtesttest@gmail.com', '14000', '2months', '', ''),
(52, 'testtesttest', 'testtesttest@gmail.com', '14000', '2months', '7000', ''),
(53, 'testtesttest', 'testtesttest@gmail.com', '14000', '2months', '7000', ''),
(54, 'testtesttest', 'testtesttest@gmail.com', '14000', '2months', '7000', ''),
(55, 'testtesttest', 'testtesttest@gmail.com', '14000', '2months', '7000', ''),
(56, 'testtesttest', 'testtesttest@gmail.com', '14000', '2months', '7000', ''),
(57, 'testtesttest', 'testtesttest@gmail.com', '14000', '2months', '7000', ''),
(58, 'testtesttest', 'testtesttest@gmail.com', '14000', '2months', '7000', '62f3ad8d688e780015c18d10'),
(59, 'testtesttest', 'testtesttest@gmail.com', '14000', '2months', '7000', '62f3ad8ef166b90013a7ba9e'),
(60, 'testtesttest', 'testtesttest@gmail.com', '14000', '3months', '4666.67', '62f3aec7f166b90013a7bab0'),
(61, 'testtesttest', 'testtesttest@gmail.com', '14000', '3months', '4666.67', '62f3aec8f166b90013a7bab6'),
(63, 'testtesttest', 'testtesttest@gmail.com', '14000', '3months', '4666.67', '62f3aec9688e780015c18d22'),
(64, 'testtesttest', 'testtesttest@gmail.com', '14000', 'full', '14000', '62f3aefb688e780015c18d28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
