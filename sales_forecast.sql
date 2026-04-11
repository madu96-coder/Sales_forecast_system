-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 11, 2026 at 09:25 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sales_forecast`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `status`) VALUES
(1, 'Incense', 'active'),
(2, 'fragrance', 'active'),
(3, 'Herbal', 'active'),
(4, 'pooja', 'active'),
(9, 'soap', 'active'),
(10, 'electronics', 'inactive'),
(11, 'toys', 'active'),
(12, 'glasses', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `contact_number`
--

DROP TABLE IF EXISTS `contact_number`;
CREATE TABLE IF NOT EXISTS `contact_number` (
  `contact_id` int NOT NULL AUTO_INCREMENT,
  `supplier_id` int NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  PRIMARY KEY (`contact_id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_number`
--

INSERT INTO `contact_number` (`contact_id`, `supplier_id`, `contact_number`) VALUES
(1, 1, '0771234567'),
(2, 1, '0112345678'),
(3, 2, '0719876543'),
(4, 2, '0113456789'),
(5, 3, '0754567890'),
(6, 3, '0113456789'),
(7, 4, '0786543210'),
(8, 5, '0721122334'),
(9, 5, '0119988776'),
(10, 6, '0763344566'),
(11, 7, '0705566778'),
(12, 8, '0778899001'),
(13, 8, '0112233445');

-- --------------------------------------------------------

--
-- Table structure for table `forecast`
--

DROP TABLE IF EXISTS `forecast`;
CREATE TABLE IF NOT EXISTS `forecast` (
  `forecast_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `forecast_month` varchar(20) NOT NULL,
  `forecast_value` int NOT NULL,
  PRIMARY KEY (`forecast_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `forecast`
--

INSERT INTO `forecast` (`forecast_id`, `product_id`, `user_id`, `forecast_month`, `forecast_value`) VALUES
(1, 1, 1, 'March 2026', 22),
(2, 2, 1, 'March 2026', 17),
(3, 3, 1, 'March 2026', 19),
(4, 7, 1, 'March 2026', 28),
(5, 4, 2, 'March 2026', 17),
(6, 5, 2, 'March 2026', 15),
(7, 6, 2, 'March 2026', 14),
(8, 8, 2, 'March 2026', 21),
(9, 9, 2, 'March 2026', 18),
(10, 10, 3, 'March 2026', 6),
(11, 11, 3, 'March 2026', 5),
(12, 14, 3, 'March 2026', 6),
(13, 12, 1, 'March 2026', 9),
(14, 13, 1, 'March 2026', 10),
(15, 15, 2, 'March 2026', 8),
(16, 16, 2, 'March 2026', 7),
(17, 17, 3, 'March 2026', 5),
(18, 18, 3, 'March 2026', 6),
(19, 19, 3, 'March 2026', 5),
(20, 20, 3, 'March 2026', 5);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `inventory_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `stock_quantity` int NOT NULL,
  `last_update` date NOT NULL,
  PRIMARY KEY (`inventory_id`),
  UNIQUE KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `product_id`, `stock_quantity`, `last_update`) VALUES
(44, 1, 500, '2026-02-01'),
(45, 2, 450, '2026-02-01'),
(46, 3, 480, '2026-02-01'),
(47, 7, 600, '2026-02-01'),
(48, 4, 300, '2026-02-01'),
(49, 5, 280, '2026-02-01'),
(50, 6, 260, '2026-02-01'),
(51, 8, 320, '2026-02-01'),
(52, 9, 290, '2026-02-01'),
(53, 10, 120, '2026-02-01'),
(54, 11, 100, '2026-02-01'),
(55, 14, 110, '2026-02-01'),
(56, 12, 200, '2026-02-01'),
(57, 13, 180, '2026-02-01'),
(58, 15, 170, '2026-02-01'),
(59, 16, 150, '2026-02-01'),
(60, 17, 80, '2026-02-01'),
(61, 18, 90, '2026-02-01'),
(62, 19, 70, '2026-02-01'),
(63, 20, 75, '2026-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `category_id` int NOT NULL,
  `stock` int DEFAULT '0',
  `status` varchar(20) DEFAULT 'active',
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `product_name` (`product_name`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `unit_price`, `category_id`, `stock`, `status`) VALUES
(1, 'Lia Lavender Incense', 150.00, 1, 55, 'active'),
(2, 'Lia jasmine Incense', 150.00, 1, 30, 'active'),
(3, 'Lia kewda Incense', 150.00, 1, 14, 'active'),
(4, 'Lia Honey rose Incense', 150.00, 1, 16, 'active'),
(5, 'Lia pineapple Incense', 150.00, 1, 5, 'active'),
(6, 'Lia cinnamon Incense', 150.00, 1, 20, 'active'),
(7, 'Citronella Mosquito repellent incense', 100.00, 3, 18, 'active'),
(8, 'Good luck seven incense', 100.00, 1, 24, 'inactive'),
(9, 'Three is one incense ', 200.00, 1, 19, 'active'),
(10, 'Fairytale long sticks', 350.00, 1, 20, 'active'),
(11, 'Lia fruits long stick', 350.00, 1, 22, 'active'),
(12, 'Parampara cup Sambrani 12 pcs', 650.00, 4, 21, 'active'),
(13, 'Sama Cup Sambrani 12 pcs', 550.00, 4, 20, 'active'),
(14, 'Rahasyamai Long Sticks', 350.00, 1, 20, 'active'),
(15, 'Shivaji Cup Sambrani 12 pc', 450.00, 4, 20, 'active'),
(16, 'Suwanda Sambrani Powder', 70.00, 4, 20, 'active'),
(17, 'Sinhala Tamil New year Gift pack', 1000.00, 4, 20, 'active'),
(18, 'Parampara long Sticks premium', 800.00, 1, 20, 'active'),
(19, 'Room Freshener Chandanam', 1250.00, 2, 20, 'active'),
(20, 'Iris Lavender Fragrance Sachet', 390.00, 2, 20, 'active'),
(31, 'siddalepa   ', 200.00, 4, 4, 'inactive'),
(36, 'lux', 200.00, 9, 12, 'inactive'),
(37, 'sunlight ', 120.00, 9, 2, 'active'),
(38, 'kohomba ', 200.00, 9, 2, 'active'),
(39, 'laptop', 1000.00, 10, 1, 'active'),
(40, 'acer laptop', 2000.00, 10, 1, 'active'),
(41, 'doll', 100.00, 11, 1, 'inactive'),
(42, 'iphone', 3000.00, 10, 3, 'active'),
(43, 'jugs', 200.00, 12, 16, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `sales_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `sales_date` date NOT NULL,
  PRIMARY KEY (`sales_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `product_id`, `quantity`, `sales_date`) VALUES
(1, 1, 15, '2025-09-05'),
(2, 2, 12, '2025-09-06'),
(3, 3, 14, '2025-09-07'),
(4, 7, 18, '2025-09-08'),
(5, 10, 3, '2025-09-10'),
(6, 12, 5, '2025-09-12'),
(7, 1, 17, '2025-10-05'),
(8, 2, 13, '2025-10-06'),
(9, 3, 15, '2025-10-07'),
(10, 7, 20, '2025-10-08'),
(11, 10, 4, '2025-10-10'),
(12, 12, 6, '2025-10-12'),
(13, 1, 18, '2025-11-05'),
(14, 2, 14, '2025-11-06'),
(15, 3, 16, '2025-11-07'),
(16, 7, 22, '2025-11-08'),
(17, 10, 4, '2025-11-10'),
(18, 12, 6, '2025-11-12'),
(19, 1, 25, '2025-12-05'),
(20, 2, 20, '2025-12-06'),
(21, 3, 22, '2025-12-07'),
(22, 7, 30, '2025-12-08'),
(23, 10, 30, '2025-12-10'),
(24, 12, 10, '2025-12-12'),
(25, 17, 15, '2025-12-15'),
(26, 1, 20, '2026-01-05'),
(27, 2, 15, '2026-01-06'),
(28, 3, 18, '2026-01-07'),
(29, 7, 25, '2026-01-08'),
(30, 10, 5, '2026-01-10'),
(31, 12, 8, '2026-01-12'),
(32, 1, 22, '2026-02-03'),
(33, 2, 17, '2026-02-05'),
(34, 3, 19, '2026-02-06'),
(35, 7, 28, '2026-02-08'),
(36, 11, 6, '2026-02-10'),
(37, 13, 10, '2026-02-12'),
(50, 2, 2, '2026-03-27'),
(51, 2, 1, '2026-03-27'),
(52, 3, 2, '2026-03-27'),
(53, 2, 1, '2026-03-27'),
(54, 1, 1, '2026-03-27'),
(55, 2, 3, '2026-03-27'),
(56, 2, 2, '2026-03-28'),
(57, 2, 2, '2026-03-28'),
(58, 9, 1, '2026-03-30'),
(59, 7, 2, '2026-04-04'),
(60, 13, 2, '2026-04-04'),
(61, 3, 2, '2026-04-05'),
(62, 31, 3, '2026-04-07'),
(63, 31, 1, '2026-04-08'),
(64, 36, 2, '2026-04-09'),
(65, 39, 1, '2026-04-09'),
(66, 40, 1, '2026-04-09');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `supplier_id` int NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `email`) VALUES
(1, 'Lanka Herbal Supplies', 'lanka.herbal@gmail.com'),
(2, 'Ceylon Fragrance oils Pvt Ltd', 'info@ceylonfragrance.lk'),
(3, 'Colombo Packaging Solutions', 'sales@colombopack.lk'),
(4, 'Sri Lanka Bamboo Products', 'bamboo.sl@gmail.com'),
(5, 'Nature Aroma Exporters', 'contact@naturearoma.lk'),
(6, 'Green Leaf Raw Materials', 'greenleaf@gmail.com'),
(7, 'Iland Chemical Traders', 'islandchem@gmail.com'),
(8, 'Saman Packaging (Pvt) Ltd', 'samanpack@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `supplies`
--

DROP TABLE IF EXISTS `supplies`;
CREATE TABLE IF NOT EXISTS `supplies` (
  `supplier_id` int NOT NULL,
  `product_id` int NOT NULL,
  KEY `product_id` (`product_id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supplies`
--

INSERT INTO `supplies` (`supplier_id`, `product_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(2, 6),
(3, 10),
(3, 11),
(3, 17),
(4, 7),
(4, 8),
(4, 9),
(5, 12),
(5, 13),
(5, 15),
(6, 14),
(6, 6),
(6, 16),
(7, 19),
(7, 7),
(8, 1),
(8, 18),
(8, 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` enum('admin','sales_manager','production_manager','inventory_manager') NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'isanka', '123', 'admin'),
(2, 'sanda', '123', 'sales_manager'),
(3, 'nimesh', '123', 'production_manager'),
(4, 'kasun', '123', 'inventory_manager');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_number`
--
ALTER TABLE `contact_number`
  ADD CONSTRAINT `contact_number_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `forecast`
--
ALTER TABLE `forecast`
  ADD CONSTRAINT `forecast_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `forecast_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `supplies`
--
ALTER TABLE `supplies`
  ADD CONSTRAINT `supplies_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `supplies_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
