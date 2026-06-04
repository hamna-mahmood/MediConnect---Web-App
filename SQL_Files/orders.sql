-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2026 at 11:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mediconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `patient_email` varchar(100) NOT NULL,
  `pharmacy_email` varchar(100) DEFAULT NULL,
  `pharmacy_name` varchar(255) NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `delivery_type` enum('pickup','delivery') NOT NULL,
  `delivery_address` text DEFAULT NULL,
  `payment_method` enum('cash','card') NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `patient_email`, `pharmacy_email`, `pharmacy_name`, `medicine_name`, `quantity`, `delivery_type`, `delivery_address`, `payment_method`, `status`, `order_date`) VALUES
(1, '', NULL, '', '', 0, 'pickup', NULL, 'cash', 'Pending', '2026-01-01 09:59:01'),
(2, ' emaanhanif17@gmail.com', ' pharmacy@mediconnect.com', 'safa pharamacy', 'Panadol 500mg', 0, '', 'saddar mall road', 'cash', 'Pending', '2026-01-01 10:38:48'),
(3, '  \r\nfarahnaz@gmail.com', '\r\n pharmacy@mediconnect.com', '\r\nsafa pharmacy', '\r\nparacetomol', 2, 'pickup', '\r\n\r\nasghar mall', 'card', NULL, '2026-01-01 10:47:37'),
(4, '\r\nashfaqahmed@gmail.com ', '\r\n\r\n pharmacy@mediconnect.com', '\r\n\r\nsafa pharmacy', '\r\n\r\nAmoxicillin ', 1, 'delivery', '\r\n\r\nRehmanabad ', 'cash', 'Pending', '2026-01-01 10:51:32'),
(5, 'rabianoor@gmail.com ', 'pharmacy@mediconnect.com', 'safa pharmacy', 'Ciprofloxacin', 3, 'pickup', '\r\n\r\ncommercial market', 'cash', 'Pending', '2026-01-01 10:54:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
