-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2026 at 11:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

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
-- Table structure for table `delivery_agent`
--

CREATE TABLE `delivery_agent` (
  `agent_id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_agent`
--

INSERT INTO `delivery_agent` (`agent_id`, `name`, `email`, `password`) VALUES
(1, 'Ali Zafar', 'alizafar@mediconnect.com', '$2y$10$K.SpInoAHlYBJN5TE0BkK.qTkx2hL2OD34uFyAyopvuHxkiQFDLRG'),
(2, 'Mir Taki Mir', 'mirtakimir@mediconnect.com', '$2y$10$mulogjcbVjosxuX0bRPKYOBPHidP2BYrPl.BlyK4TRTYLP.5K3Ley'),
(3, 'Atif Aslam', 'atifaslam@mediconnect.com', '$2y$10$4MlGZZ7syluGRNZ.hVAp/uGinKH.nWmOzVQb4JraYG0U2dq3.L3Xm'),
(4, 'Zahid Ahmed', 'zahidahmed@mediconnect.com', '$2y$10$Q.ITQod0chZkVxGUQMAR8OkK2RT10LypexquHvXqF2xSRLu6jm1Bq'),
(5, 'Fawad Khan', 'fawadkhan@mediconnect.com', '$2y$10$LDFpFJwdAKH.736y5kp6kORNAl41PE1XauF.ddEocraoJqfTrMXLK');

--
-- Triggers `delivery_agent`
--
DELIMITER $$
CREATE TRIGGER `delivery_agent_password_length_insert` BEFORE INSERT ON `delivery_agent` FOR EACH ROW BEGIN
    IF CHAR_LENGTH(NEW.password) < 8 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Password must be at least 8 characters';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delivery_agent_password_length_update` BEFORE UPDATE ON `delivery_agent` FOR EACH ROW BEGIN
    IF CHAR_LENGTH(NEW.password) < 8 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Password must be at least 8 characters';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_orders`
--

CREATE TABLE `delivery_orders` (
  `order_id` varchar(10) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_orders`
--

INSERT INTO `delivery_orders` (`order_id`, `customer_name`, `address`, `status`) VALUES
('MC101', 'Ali Khan', 'House 14, Street 3, Model Town, Lahore', 'Pending'),
('MC102', 'Sara Ahmed', 'Flat 6B, Block G, G-10 Markaz, Islamabad', 'Delivered'),
('MC103', 'Usman Raza', 'Plot 22, Block 7, Gulshan-e-Iqbal, Karachi', 'Delivered'),
('MC104', 'Ayesha Noor', 'House 9, Mall Road, Saddar, Rawalpindi', 'Delivered'),
('MC105', 'Bilal Sheikh', 'House 31, Street 12, Johar Town, Lahore', 'Delivered');

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
(5, 'rabianoor@gmail.com ', 'pharmacy@mediconnect.com', 'safa pharmacy', 'Ciprofloxacin', 3, 'pickup', '\r\n\r\ncommercial market', 'cash', 'Pending', '2026-01-01 10:54:57'),
(6, 'patient@example.com', 'safa@pharmacy.com', 'Safa Pharmacy', 'Paracetomol', 2, 'delivery', 'malik road', 'cash', 'Pending', '2026-01-01 16:01:14'),
(7, 'patient@example.com', 'safa@pharmacy.com', 'Safa Pharmacy', 'PANADOL', 1, 'pickup', '', 'cash', 'Pending', '2026-01-01 16:01:46'),
(8, 'patient@example.com', 'safa@pharmacy.com', 'Safa Pharmacy', 'Paracetomol', 3, 'pickup', '', 'card', 'Pending', '2026-01-01 18:47:29'),
(9, 'patient@example.com', 'safa@pharmacy.com', 'Safa Pharmacy', 'Ciprofloxacin', 2, 'delivery', 'ZAID ROAD RAWALPINDI', 'card', 'Pending', '2026-01-04 14:03:04'),
(10, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'risec', 1, 'pickup', 'hshhjhjshjhjs', 'card', 'Pending', '2026-01-04 15:21:34'),
(11, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Ciprofloxacin', 3, '', 'emili roa', 'card', 'Pending', '2026-01-04 15:25:22'),
(12, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Paracetomol', 12, '', 'emili road', 'card', 'Pending', '2026-01-04 15:39:44'),
(13, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Amoxicillin ', 3, '', 'jinnah road', 'card', 'Pending', '2026-01-04 21:01:53'),
(14, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Amoxicillin ', 3, 'pickup', '', 'card', 'Pending', '2026-01-04 21:02:40'),
(15, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Amoxicillin ', 2, 'pickup', '', 'card', 'Pending', '2026-01-04 21:02:52'),
(16, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Ciprofloxacin', 3, 'pickup', 'emili roa', 'card', 'Pending', '2026-01-04 21:12:21'),
(17, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'panadol', 2, '', 'jinnah gardens', 'card', 'Pending', '2026-01-04 21:16:14'),
(18, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Paracetomol', 2, 'pickup', 'quaid road', 'card', 'Pending', '2026-01-04 21:32:03'),
(19, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Paracetomol', 2, 'delivery', 'quaid road', 'card', 'Pending', '2026-01-04 22:41:10'),
(20, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Paracetomol', 2, 'delivery', 'quaid road', 'card', 'Pending', '2026-01-04 22:46:12'),
(21, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Paracetomol', 2, 'delivery', 'quaid road', 'card', 'Pending', '2026-01-04 22:46:18'),
(22, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Paracetomol', 2, 'pickup', '', 'card', 'Pending', '2026-01-04 23:33:57'),
(23, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Paracetomol', 1, 'pickup', '', 'card', 'Pending', '2026-01-04 23:42:41'),
(24, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Amoxicillin ', 1, 'pickup', 'House # 55, Sharoon Colony, Swan, Rawalpindi', 'cash', 'Pending', '2026-01-05 09:19:11'),
(25, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Paracetomol', 2, 'pickup', '', 'cash', 'Pending', '2026-01-05 10:40:04'),
(26, 'patient@example.com', 'safa@pharmacy.com', 'Safa', 'Amoxicillin ', 2, 'pickup', '', 'cash', 'Pending', '2026-01-05 10:40:19');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `category` enum('patient','pharmacy','delivery_agent') NOT NULL DEFAULT 'patient'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `name`, `email`, `password`, `phone`, `category`) VALUES
(1, 'Ashfaq Ahmed', 'ashfaqahmed@gmail.com', '$2y$10$5IpPQLl6CcQ.Nl70zykzUezOy3shPvoBZqMpxnNP1QFd6Qks5hm/6', '12300000000', 'patient'),
(2, 'Bano Qudsia', 'banoqudsia@gmail.com', '$2y$10$uNjR40qdJT.iwOFINOf30.8NxblSzCqIrpwHkbyadAO/Oa55V0S4K', '12311011011', 'patient'),
(3, 'Rabia Noor', 'rabianoor@gmail.com', '$2y$10$iXbmy2CIPtybfN/fvfqOauGI/af9mT473XZSj/mIe0ogl1qTKGRhK', '12345454545', 'patient'),
(4, 'Hamna Mahmood', 'hamnamahmood25@gmail.com', '$2y$10$KFiQnKcrvYfogHoFfk2q0umkk9y.jj9Cg0CFf8hUSquH7WI8uIVYm', '12325252525', 'patient'),
(5, 'Komal Kashif', 'komalkashif31@gmail.com', '$2y$10$lNhcXawR9/rzWcXYeAnlzORjrXgHFr7W07BK21iY1rxSK2YH4klS.', '12331313131', 'patient'),
(6, 'Emaan Hanif', 'emaanhanif17@gmail.com', '$2y$10$utzJuxCzAXU/89vDD42UH.zne3qmfYQXovfHK/7PFTRwJage0PRLS', '12345678900', 'patient'),
(8, 'Farah Naz', 'farahnaz@gmail.com', '$2y$10$sgVKx/ukIAYpOZ411vICaepkkfa9eI8HnGRYmRH/MtvqGYcN8m7se', '12389076541', 'patient'),
(11, 'Maryam Shah', 'maryamshah@gmail.com', '$2y$10$ZepLEi9qhFE7BsKdElIogOGxDwzaIVJVb0W3QtdN3i7TvN7ssTOv6', '12367896541', 'patient'),
(12, 'Khadija Mastoor', 'khadijamastoor@gmail.com', '$2y$10$OwsLKdU4gC1nkLzw/2S3muKuqRuBVZrFtnVrPgkv172h47F6bi.CW', '12356789012', 'patient'),
(13, 'Aamina Akif', 'aaminaakif@gmail.com', '$2y$10$ouGDL9IvJRWF6UzpZ088vOhGzR0soi84qrl/YMFRtNK7bMXkWo1E2', '12331313131', 'patient');

--
-- Triggers `patient`
--
DELIMITER $$
CREATE TRIGGER `patient_password_length_insert` BEFORE INSERT ON `patient` FOR EACH ROW BEGIN
    IF CHAR_LENGTH(NEW.password) < 8 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Password must be at least 8 characters';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `patient_password_length_update` BEFORE UPDATE ON `patient` FOR EACH ROW BEGIN
    IF CHAR_LENGTH(NEW.password) < 8 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Password must be at least 8 characters';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy`
--

CREATE TABLE `pharmacy` (
  `pharmacy_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmacy`
--

INSERT INTO `pharmacy` (`pharmacy_id`, `email`, `password`) VALUES
(1, 'pharmacy@mediconnect.com', '$2y$10$dMCmeyFr/pteVivDULt31eCbW.tBTWmh8dr9r2FzvPiSQriirHCyi');

--
-- Triggers `pharmacy`
--
DELIMITER $$
CREATE TRIGGER `pharmacy_password_length_insert` BEFORE INSERT ON `pharmacy` FOR EACH ROW BEGIN
    IF CHAR_LENGTH(NEW.password) < 8 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Password must be at least 8 characters';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pharmacy_password_length_update` BEFORE UPDATE ON `pharmacy` FOR EACH ROW BEGIN
    IF CHAR_LENGTH(NEW.password) < 8 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Password must be at least 8 characters';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `medicine_name`, `quantity`, `price`) VALUES
(3, 'Paracetomol', 20, 600),
(4, 'Amoxicillin ', 19, 900),
(5, 'Ciprofloxacin', 42, 560),
(6, 'panadol', 28, 200),
(7, 'Disprin\r\n', 2, 100),
(9, 'brufen', 20, 234),
(14, 'risec', 34, 400),
(19, 'Flagyl', 100, 450);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `delivery_agent`
--
ALTER TABLE `delivery_agent`
  ADD PRIMARY KEY (`agent_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `delivery_orders`
--
ALTER TABLE `delivery_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pharmacy`
--
ALTER TABLE `pharmacy`
  ADD PRIMARY KEY (`pharmacy_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
