-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: May 23, 2022 at 07:34 PM
-- Server version: 10.7.3-MariaDB-1:10.7.3+maria~focal
-- PHP Version: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coff_it`
--

-- --------------------------------------------------------

--
-- Table structure for table `Business`
--

CREATE TABLE `Business` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Business`
--

INSERT INTO `Business` (`id`, `email` `name`, `country`) VALUES
(1, 'ecologic@gmail.com', 'Ecologic', 'France'),
(2, 'veolia@gmail.com', 'Veolia', 'France'),
(3, 'yes@gmail.com', 'yes yes', 'France');

-- --------------------------------------------------------

--
-- Table structure for table `BusinessBuy`
--

CREATE TABLE `BusinessBuy` (
  `business` int(11) NOT NULL,
  `typeItem` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL COMMENT 'price per unit in euros'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='The business wants to buy quantity of item at unit price';

--
-- Dumping data for table `BusinessBuy`
--

INSERT INTO `BusinessBuy` (`business`, `typeItem`, `quantity`, `price`) VALUES
(3, 1, 38, 20);

-- --------------------------------------------------------

--
-- Table structure for table `BusinessSell`
--

CREATE TABLE `BusinessSell` (
  `business` int(11) NOT NULL,
  `typeItem` int(11) NOT NULL,
  `quantity` int(11) NOT NULL COMMENT 'number of items on offer',
  `price` int(11) NOT NULL COMMENT 'price per unit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='the business wants to sell quantity of item at unit price';

--
-- Dumping data for table `BusinessSell`
--

INSERT INTO `BusinessSell` (`business`, `typeItem`, `quantity`, `price`) VALUES
(3, 1, 42, 65);

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `id` bigint(20) NOT NULL,
  `login` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stash` smallint(6) NOT NULL COMMENT 'no more than 65000 euros'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`id`, `login`, `stash`) VALUES
(1, 'golgot77', 42),
(2, 'JeanMi91', 33);

-- --------------------------------------------------------

--
-- Table structure for table `CustomerExtraction`
--

CREATE TABLE `CustomerExtraction` (
  `Customer` bigint(20) NOT NULL,
  `element` int(11) NOT NULL,
  `quantity` int(11) NOT NULL COMMENT 'in mg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `CustomerExtraction`
--

INSERT INTO `CustomerExtraction` (`Customer`, `element`, `quantity`) VALUES
(1, 13, 25000),
(1, 79, 340);

-- --------------------------------------------------------
--
-- Table structure for table `CustomerProtectedData`
--

CREATE TABLE `CustomerProtectedData` (
  `id` bigint(20) NOT NULL,
  `surname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'can not be shared between accounts'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `CustomerProtectedData`
--

INSERT INTO `CustomerProtectedData` (`id`, `surname`, `firstname`, `email`) VALUES
(1, 'Tartenpion', 'Cunégonde', 'cunegonde.tartenpion@toto.fr'),
(2, 'Erraj', 'Jean-Michel', 'synthe@cool.fr');

-- --------------------------------------------------------

--
-- Table structure for table `ExtractionFromTypeItem`
--

CREATE TABLE `ExtractionFromTypeItem` (
  `typeItem` int(11) NOT NULL,
  `element` int(11) NOT NULL,
  `quantity` int(11) NOT NULL COMMENT 'mg (thousandth of a gram)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ExtractionFromTypeItem`
--

INSERT INTO `ExtractionFromTypeItem` (`typeItem`, `element`, `quantity`) VALUES
(1, 13, 25000),
(1, 29, 15000),
(1, 46, 15),
(1, 47, 340),
(1, 78, 1),
(1, 79, 34);

-- --------------------------------------------------------

--
-- Table structure for table `Mendeleiev`
--

CREATE TABLE `Mendeleiev` (
  `Z` int(11) NOT NULL,
  `symbol` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Mendeleiev`
--

INSERT INTO `Mendeleiev` (`Z`, `symbol`, `name`) VALUES
(13, 'Al', 'Aluminium'),
(28, 'Ni', 'Nickel'),
(29, 'Cu', 'Copper'),
(39, 'Y', 'Yttrium'),
(46, 'Pd', 'Paladium'),
(47, 'Ag', 'Silver'),
(57, 'La', 'Lanthanum'),
(59, 'Pr', 'praseodymium'),
(60, 'Nd', 'neodymium'),
(64, 'Gd', 'gadolinium'),
(65, 'Tb', 'terbium'),
(77, 'Ir', 'Iridium'),
(78, 'Pt', 'Platinum'),
(79, 'Au', 'gold');

-- --------------------------------------------------------

--
-- Table structure for table `TypeItem`
--

CREATE TABLE `TypeItem` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `TypeItem`
--

INSERT INTO `TypeItem` (`id`, `name`) VALUES
(3, 'dell latitude 7490'),
(2, 'Fairphone 2'),
(1, 'Iphone 5');

-- --------------------------------------------------------

--
-- Table structure for table `TypeItemDetails`
--

CREATE TABLE `TypeItemDetails` (
  `typeItem` int(11) NOT NULL,
  `attribute` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `TypeItemDetails`
--

INSERT INTO `TypeItemDetails` (`typeItem`, `attribute`, `value`) VALUES
(1, 'main camera', '8 Mpx'),
(1, 'screen', '4 in, 1136 × 640 '),
(1, 'second camera', '1.2 Mpx');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Business`
--
ALTER TABLE `Business`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_business` (`country`,`name`);

--
-- Indexes for table `BusinessBuy`
--
ALTER TABLE `BusinessBuy`
  ADD PRIMARY KEY (`business`,`typeItem`),
  ADD KEY `typeItem` (`typeItem`);

--
-- Indexes for table `BusinessSell`
--
ALTER TABLE `BusinessSell`
  ADD PRIMARY KEY (`business`,`typeItem`),
  ADD KEY `typeItem` (`typeItem`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Indexes for table `CustomerExtraction`
--
ALTER TABLE `CustomerExtraction`
  ADD KEY `Customer` (`Customer`),
  ADD KEY `element` (`element`);

--
-- Indexes for table `CustomerProtectedData`
--
ALTER TABLE `CustomerProtectedData`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ExtractionFromTypeItem`
--
ALTER TABLE `ExtractionFromTypeItem`
  ADD PRIMARY KEY (`typeItem`,`element`) USING BTREE,
  ADD KEY `element` (`element`);

--
-- Indexes for table `Mendeleiev`
--
ALTER TABLE `Mendeleiev`
  ADD PRIMARY KEY (`Z`),
  ADD UNIQUE KEY `symbol` (`symbol`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `TypeItem`
--
ALTER TABLE `TypeItem`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `TypeItemDetails`
--
ALTER TABLE `TypeItemDetails`
  ADD PRIMARY KEY (`typeItem`,`attribute`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Business`
--
ALTER TABLE `Business`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `TypeItem`
--
ALTER TABLE `TypeItem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `BusinessBuy`
--
ALTER TABLE `BusinessBuy`
  ADD CONSTRAINT `BusinessBuy_ibfk_1` FOREIGN KEY (`business`) REFERENCES `Business` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `BusinessBuy_ibfk_2` FOREIGN KEY (`typeItem`) REFERENCES `TypeItem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `BusinessSell`
--
ALTER TABLE `BusinessSell`
  ADD CONSTRAINT `BusinessSell_ibfk_1` FOREIGN KEY (`business`) REFERENCES `Business` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `BusinessSell_ibfk_2` FOREIGN KEY (`typeItem`) REFERENCES `TypeItem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CustomerExtraction`
--
ALTER TABLE `CustomerExtraction`
  ADD CONSTRAINT `CustomerExtraction_ibfk_1` FOREIGN KEY (`Customer`) REFERENCES `Customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `CustomerExtraction_ibfk_2` FOREIGN KEY (`element`) REFERENCES `Mendeleiev` (`Z`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CustomerProtectedData`
--
ALTER TABLE `CustomerProtectedData`
  ADD CONSTRAINT `CustomerProtectedData_ibfk_1` FOREIGN KEY (`id`) REFERENCES `Customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ExtractionFromTypeItem`
--
ALTER TABLE `ExtractionFromTypeItem`
  ADD CONSTRAINT `ExtractionFromTypeItem_ibfk_1` FOREIGN KEY (`element`) REFERENCES `Mendeleiev` (`Z`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ExtractionFromTypeItem_ibfk_2` FOREIGN KEY (`typeItem`) REFERENCES `TypeItem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `TypeItemDetails`
--
ALTER TABLE `TypeItemDetails`
  ADD CONSTRAINT `TypeItemDetails_ibfk_1` FOREIGN KEY (`typeItem`) REFERENCES `TypeItem` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
