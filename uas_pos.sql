-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2018 at 04:30 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `braId` varchar(20) NOT NULL,
  `braName` varchar(30) NOT NULL,
  `braAddress` text NOT NULL,
  `braManager` varchar(20) NOT NULL,
  `braPhone` varchar(15) NOT NULL,
  `braMail` varchar(50) NOT NULL,
  `braStatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`braId`, `braName`, `braAddress`, `braManager`, `braPhone`, `braMail`, `braStatus`) VALUES
('000002', 'Lippo Karawaci', 'Jl. MH. Thamrin Boulevard 1100 Lippo Village, Kelapa Dua, Karawaci, Tangerang, Banten', '000001', '0212345678', 'lip.kara@fortuna.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `carId` int(20) NOT NULL,
  `cardId` varchar(20) NOT NULL,
  `carPrice` int(11) NOT NULL,
  `carStatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`carId`, `cardId`, `carPrice`, `carStatus`) VALUES
(33, '7', 1200, 1),
(34, '7', 1200, 4),
(35, '7', 1200, 2);

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `cardId` int(20) NOT NULL,
  `cardName` varchar(50) NOT NULL,
  `cardHeight` int(11) NOT NULL,
  `cardWidth` int(11) NOT NULL,
  `cardLength` int(11) NOT NULL,
  `cardType` varchar(20) NOT NULL,
  `cardWeight` int(11) NOT NULL,
  `cardPrice` int(11) NOT NULL,
  `cardAdded` date NOT NULL,
  `cardPhoto` varchar(30) NOT NULL,
  `cardStatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `card`
--

INSERT INTO `card` (`cardId`, `cardName`, `cardHeight`, `cardWidth`, `cardLength`, `cardType`, `cardWeight`, `cardPrice`, `cardAdded`, `cardPhoto`, `cardStatus`) VALUES
(7, 'Fortuna Test Prototype', 3, 3, 5, 'Family', 80, 10000000, '2018-04-22', 'flintstonecar-500x295.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `carpart`
--

CREATE TABLE `carpart` (
  `cardId` int(20) NOT NULL,
  `partId` varchar(20) NOT NULL,
  `cpStatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carpart`
--

INSERT INTO `carpart` (`cardId`, `partId`, `cpStatus`) VALUES
(7, '10', 1),
(7, '4', 1),
(7, '5', 1),
(7, '6', 1),
(7, '7', 1),
(7, '8', 1),
(7, '9', 1);

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `delId` int(11) NOT NULL,
  `delDate` date NOT NULL,
  `delivererId` varchar(20) NOT NULL,
  `delStatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`delId`, `delDate`, `delivererId`, `delStatus`) VALUES
(1, '2018-04-22', '000002', 1);

-- --------------------------------------------------------

--
-- Table structure for table `deliverydetail`
--

CREATE TABLE `deliverydetail` (
  `delId` varchar(20) NOT NULL,
  `carId` varchar(20) NOT NULL,
  `delDetStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deliverydetail`
--

INSERT INTO `deliverydetail` (`delId`, `carId`, `delDetStatus`) VALUES
('', '34', 2);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `empId` varchar(20) NOT NULL,
  `empFName` varchar(30) NOT NULL,
  `empLName` varchar(30) NOT NULL,
  `empDOB` date NOT NULL,
  `empPass` varchar(50) NOT NULL,
  `empPosition` varchar(20) NOT NULL,
  `empMail` varchar(50) NOT NULL,
  `empPhone` varchar(15) NOT NULL,
  `empAddress` text NOT NULL,
  `empPhoto` varchar(30) NOT NULL,
  `dateLimit` date NOT NULL,
  `empStatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`empId`, `empFName`, `empLName`, `empDOB`, `empPass`, `empPosition`, `empMail`, `empPhone`, `empAddress`, `empPhoto`, `dateLimit`, `empStatus`) VALUES
('000000', 'Michael', 'Surya', '1998-10-17', 'aaaaaa', 'Admin', 'michael.surya@gmail.com', '08123456', 'Serdang Asri 3, R7/06, Tangerang', 'Ia.jpg', '3018-04-15', 1),
('000001', 'Excalibur', 'Prime', '2017-01-11', '11012017', 'Manager', 'ex.prime@yahoo.com', '08123123', 'Warframe', 'Warframe0007.jpg', '1970-01-01', 1),
('000002', 'Courier', 'Guy', '2018-04-05', '05042018', 'Courier', 'courier.guy@fortuna.com', '0987171717', '123123123123', 'user_male2-128.png', '1970-01-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `part`
--

CREATE TABLE `part` (
  `partId` int(12) NOT NULL,
  `partName` varchar(50) NOT NULL,
  `partQuantity` int(11) NOT NULL,
  `partPrice` int(11) NOT NULL,
  `partType` int(11) NOT NULL,
  `partPhoto` varchar(40) NOT NULL,
  `partStatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `part`
--

INSERT INTO `part` (`partId`, `partName`, `partQuantity`, `partPrice`, `partType`, `partPhoto`, `partStatus`) VALUES
(1, 'Harganya 12000', 0, 1200, 1, 'Ia.jpg', 1),
(3, 'Ini nyoba', 0, 1000, 2, 'Warframe0000.jpg', 1),
(4, 'Test Chasis', 0, 1000, 1, '3testdrive.jpg', 1),
(5, 'Test Body', 0, 1000, 2, '3testdrive1.jpg', 1),
(6, 'Test Engine', 0, 1000, 3, '3testdrive2.jpg', 1),
(7, 'Test Wheel', 0, 1000, 4, '3testdrive3.jpg', 1),
(8, 'Test Battery', 0, 1000, 5, '3testdrive4.jpg', 1),
(9, 'Test Radiator', 0, 1000, 11, '3testdrive5.jpg', 1),
(10, 'Test Brake', 0, 1000, 10, '3testdrive6.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parttype`
--

CREATE TABLE `parttype` (
  `parttId` int(11) NOT NULL,
  `parttName` varchar(30) NOT NULL,
  `parttLimit` int(11) NOT NULL,
  `parttStatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parttype`
--

INSERT INTO `parttype` (`parttId`, `parttName`, `parttLimit`, `parttStatus`) VALUES
(1, 'Chasis', 1, 1),
(2, 'Body', 1, 1),
(3, 'Engine', 1, 1),
(4, 'Wheel', 4, 1),
(5, 'Battery', 1, 1),
(6, 'Air Conditioner', 1, 1),
(7, 'Cassette Player', 1, 1),
(8, 'DVD Player', 1, 1),
(9, 'Shock Breaker', 4, 1),
(10, 'Brake', 1, 1),
(11, 'Radiator', 1, 1),
(12, 'Doors', 4, 1),
(13, 'Windshield', 1, 1),
(14, 'Meter Set', 1, 1),
(15, 'Lamp Set', 1, 1),
(16, 'Airbag', 1, 1),
(17, 'Bumper', 1, 1),
(18, 'Speaker', 1, 1),
(19, 'Camera Set', 1, 1),
(20, 'Seat Set', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

CREATE TABLE `production` (
  `prodId` int(11) NOT NULL,
  `empId` varchar(20) NOT NULL,
  `braId` varchar(20) NOT NULL,
  `prodStart` date NOT NULL,
  `prodStatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `production`
--

INSERT INTO `production` (`prodId`, `empId`, `braId`, `prodStart`, `prodStatus`) VALUES
(15, '000000', '000002', '2018-04-22', 2);

-- --------------------------------------------------------

--
-- Table structure for table `productiondet`
--

CREATE TABLE `productiondet` (
  `prodId` varchar(20) NOT NULL,
  `carId` varchar(20) NOT NULL,
  `prodDetFinish` date NOT NULL,
  `prodDetCost` int(11) NOT NULL,
  `prodDetStatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productiondet`
--

INSERT INTO `productiondet` (`prodId`, `carId`, `prodDetFinish`, `prodDetCost`, `prodDetStatus`) VALUES
('15', '33', '2018-04-22', 12000, 1),
('15', '34', '0000-00-00', 12000, 1),
('15', '35', '0000-00-00', 12000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `suppId` int(11) NOT NULL,
  `suppName` varchar(30) NOT NULL,
  `suppAddress` text NOT NULL,
  `suppPhone` varchar(15) NOT NULL,
  `suppMail` varchar(50) NOT NULL,
  `suppStatus` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`suppId`, `suppName`, `suppAddress`, `suppPhone`, `suppMail`, `suppStatus`) VALUES
(1, 'Number one', 'Di Sekitar Sini', '1234567', 'aa@aa', 1),
(2, 'aaaaaaa bbbbb', 'Di Sekitar Sini', '0818872771', 'aa@aa', 1),
(3, 'Chronas Corp', 'Jakarta Selatan, aaa, aaaa, aaa', '0818872771', 'chronas.corp@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplierdet`
--

CREATE TABLE `supplierdet` (
  `supplierId` varchar(20) NOT NULL,
  `partId` varchar(20) NOT NULL,
  `sDetStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplierdet`
--

INSERT INTO `supplierdet` (`supplierId`, `partId`, `sDetStatus`) VALUES
('000001', '3', 1),
('1', '1', 1),
('3', '', 1),
('3', '1', 1),
('3', '10', 1),
('3', '4', 1),
('3', '5', 1),
('3', '6', 1),
('3', '7', 1),
('3', '8', 1),
('3', '9', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supply`
--

CREATE TABLE `supply` (
  `supplyId` varchar(20) NOT NULL,
  `supplierId` varchar(20) NOT NULL,
  `empId` varchar(20) NOT NULL,
  `supplyDate` date NOT NULL,
  `supplyStatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supply`
--

INSERT INTO `supply` (`supplyId`, `supplierId`, `empId`, `supplyDate`, `supplyStatus`) VALUES
('0120180422001', '3', '000000', '2018-04-22', 1),
('0120180422002', '3', '000000', '2018-04-22', 1),
('0120180422003', '3', '000000', '2018-04-22', 1),
('0120180422004', '3', '000000', '2018-04-22', 1),
('0120180422005', '3', '000000', '2018-04-22', 1),
('0120180422006', '3', '000000', '2018-04-22', 1),
('0120180422007', '3', '000000', '2018-04-22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplydet`
--

CREATE TABLE `supplydet` (
  `supplyId` varchar(20) NOT NULL,
  `partId` varchar(20) NOT NULL,
  `supplyQuantity` int(11) NOT NULL,
  `supplyPrice` int(11) NOT NULL,
  `supplyDetStatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplydet`
--

INSERT INTO `supplydet` (`supplyId`, `partId`, `supplyQuantity`, `supplyPrice`, `supplyDetStatus`) VALUES
('0120180422001', '10', 3, 1200, 1),
('0120180422002', '4', 3, 1200, 1),
('0120180422003', '5', 3, 1200, 1),
('0120180422004', '6', 3, 1200, 1),
('0120180422005', '7', 12, 1200, 1),
('0120180422006', '8', 3, 1200, 1),
('0120180422007', '9', 3, 1200, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`braId`);

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`carId`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`cardId`);

--
-- Indexes for table `carpart`
--
ALTER TABLE `carpart`
  ADD PRIMARY KEY (`cardId`,`partId`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`delId`);

--
-- Indexes for table `deliverydetail`
--
ALTER TABLE `deliverydetail`
  ADD PRIMARY KEY (`delId`,`carId`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`empId`);

--
-- Indexes for table `part`
--
ALTER TABLE `part`
  ADD PRIMARY KEY (`partId`);

--
-- Indexes for table `parttype`
--
ALTER TABLE `parttype`
  ADD PRIMARY KEY (`parttId`);

--
-- Indexes for table `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`prodId`);

--
-- Indexes for table `productiondet`
--
ALTER TABLE `productiondet`
  ADD PRIMARY KEY (`prodId`,`carId`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`suppId`);

--
-- Indexes for table `supplierdet`
--
ALTER TABLE `supplierdet`
  ADD PRIMARY KEY (`supplierId`,`partId`);

--
-- Indexes for table `supply`
--
ALTER TABLE `supply`
  ADD PRIMARY KEY (`supplyId`);

--
-- Indexes for table `supplydet`
--
ALTER TABLE `supplydet`
  ADD PRIMARY KEY (`supplyId`,`partId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `carId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `cardId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `part`
--
ALTER TABLE `part`
  MODIFY `partId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `parttype`
--
ALTER TABLE `parttype`
  MODIFY `parttId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `production`
--
ALTER TABLE `production`
  MODIFY `prodId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `suppId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
