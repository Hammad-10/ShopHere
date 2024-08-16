-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 15, 2024 at 01:24 PM
-- Server version: 8.0.39-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ShopHere`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `adminId` varchar(40) NOT NULL,
  `adminName` varchar(40) NOT NULL,
  `adminPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`adminId`, `adminName`, `adminPassword`) VALUES
('abbasi123', 'Abbasi', 'abc123'),
('admin123', 'Admin', 'abc123'),
('hammad123', 'Hammad', 'abc123'),
('jasim123', 'Jasim', 'abc123');

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `customerId` int NOT NULL,
  `customerName` varchar(40) NOT NULL,
  `CustomerPassword` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`customerId`, `customerName`, `CustomerPassword`) VALUES
(1, 'Najam', 'abc123'),
(2, 'Hammad', 'abc123');

-- --------------------------------------------------------

--
-- Table structure for table `OrderItems`
--

CREATE TABLE `OrderItems` (
  `order_sno` int NOT NULL,
  `product_sno` int NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `order_sno` int NOT NULL,
  `orderId` varchar(40) NOT NULL,
  `cust_id` int NOT NULL,
  `status` varchar(40) NOT NULL,
  `grandTotal` int NOT NULL,
  `dateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`order_sno`, `orderId`, `cust_id`, `status`, `grandTotal`, `dateTime`) VALUES
(1, 'ODNajam', 1, 'placed', 800, '2024-08-14 15:32:10'),
(2, 'ODHammad', 2, 'placed', 1500, '2024-08-14 15:34:12'),
(3, 'ODNajam', 1, 'que', 0, '2024-08-15 13:10:02');

-- --------------------------------------------------------

--
-- Table structure for table `ProductCategories`
--

CREATE TABLE `ProductCategories` (
  `categId` int NOT NULL,
  `categName` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ProductCategories`
--

INSERT INTO `ProductCategories` (`categId`, `categName`) VALUES
(1, 'Soap'),
(2, 'Moisturizer'),
(4, 'Oil'),
(5, 'Medicine'),
(6, 'Beauty');

-- --------------------------------------------------------

--
-- Table structure for table `ProductCategoryLink`
--

CREATE TABLE `ProductCategoryLink` (
  `categId` int NOT NULL,
  `Productsno` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ProductCategoryLink`
--

INSERT INTO `ProductCategoryLink` (`categId`, `Productsno`) VALUES
(1, 1),
(2, 2),
(2, 4),
(4, 3),
(4, 6),
(4, 8),
(5, 1),
(5, 5),
(5, 9),
(6, 4),
(6, 10);

-- --------------------------------------------------------

--
-- Table structure for table `ProductImages`
--

CREATE TABLE `ProductImages` (
  `sno` int NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ProductImages`
--

INSERT INTO `ProductImages` (`sno`, `image`) VALUES
(1, 'ProductImagesUpload/dettol2.jpeg'),
(1, 'ProductImagesUpload/dettol.jpeg'),
(2, 'ProductImagesUpload/moisturizer.jpeg'),
(3, 'ProductImagesUpload/oil.jpeg'),
(4, 'ProductImagesUpload/moisturizer.jpeg'),
(5, 'ProductImagesUpload/eyeserum.jpeg'),
(8, 'ProductImagesUpload/oil.jpeg'),
(9, 'ProductImagesUpload/eyeserum.jpeg'),
(10, 'ProductImagesUpload/cream.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `sno` int NOT NULL,
  `sku` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`sno`, `sku`, `name`, `price`, `quantity`) VALUES
(1, 'sku001', 'Dettol', 400, 5),
(2, 'sku002', 'Face Moisturizer', 400, 6),
(3, 'sku003', 'Hyderating Oil', 400, 5),
(4, 'sku004', 'Cream', 1100, 5),
(5, 'sku005', 'Conatural Eye Serium', 300, 4),
(8, 'sku006', 'Pro Oil', 400, 5),
(10, 'sku008', 'Beauty Cream', 300, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`adminId`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`customerId`);

--
-- Indexes for table `OrderItems`
--
ALTER TABLE `OrderItems`
  ADD PRIMARY KEY (`order_sno`,`product_sno`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`order_sno`);

--
-- Indexes for table `ProductCategories`
--
ALTER TABLE `ProductCategories`
  ADD PRIMARY KEY (`categId`);

--
-- Indexes for table `ProductCategoryLink`
--
ALTER TABLE `ProductCategoryLink`
  ADD PRIMARY KEY (`categId`,`Productsno`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `customerId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `order_sno` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ProductCategories`
--
ALTER TABLE `ProductCategories`
  MODIFY `categId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `sno` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;