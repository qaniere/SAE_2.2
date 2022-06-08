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

CREATE TABLE `Business` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `BusinessBuy` (
  `business` int(11) NOT NULL,
  `typeItem` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL COMMENT 'price per unit in euros'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='The business wants to buy quantity of item at unit price';


CREATE TABLE `BusinessSell` (
  `business` int(11) NOT NULL,
  `typeItem` int(11) NOT NULL,
  `quantity` int(11) NOT NULL COMMENT 'number of items on offer',
  `price` int(11) NOT NULL COMMENT 'price per unit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='the business wants to sell quantity of item at unit price';


CREATE TABLE `Customer` (
  `id` bigint(20) NOT NULL,
  `login` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stash` smallint(6) NOT NULL COMMENT 'no more than 65000 euros'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `CustomerExtraction` (
  `Customer` bigint(20) NOT NULL,
  `element` int(11) NOT NULL,
  `quantity` int(11) NOT NULL COMMENT 'in mg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `CustomerOrder` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `customerID` bigint(20) NOT NULL,
  `itemID` int(11) NOT NULL,
  `businessID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `CustomerProtectedData` (
  `id` bigint(20) NOT NULL,
  `surname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'can not be shared between accounts'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `ExtractionFromTypeItem` (
  `typeItem` int(11) NOT NULL,
  `element` int(11) NOT NULL,
  `quantity` int(11) NOT NULL COMMENT 'mg (thousandth of a gram)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `Mendeleiev` (
  `Z` int(11) NOT NULL,
  `symbol` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `Mendeleiev` (`Z`, `symbol`, `name`) VALUES
(13, 'Al', 'Aluminium'),
(28, 'Ni', 'Nickel'),
(29, 'Cu', 'Copper'),
(39, 'Y', 'Yttrium'),
(46, 'Pd', 'Paladium'),
(47, 'Ag', 'Silver'),
(57, 'La', 'Lanthanum'),
(59, 'Pr', 'Praseodymium'),
(60, 'Nd', 'Neodymium'),
(64, 'Gd', 'Gadolinium'),
(65, 'Tb', 'Terbium'),
(77, 'Ir', 'Iridium'),
(78, 'Pt', 'Platinum'),
(79, 'Au', 'Gold');


CREATE TABLE `TypeItem` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_extension` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `TypeItemDetails` (
  `typeItem` int(11) NOT NULL,
  `attribute` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
