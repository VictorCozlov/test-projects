-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql301.byethost22.com
-- Generation Time: Jun 03, 2017 at 06:12 PM
-- Server version: 5.6.35-81.0
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `b22_19256040_restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admission`
--

CREATE TABLE IF NOT EXISTS `Admission` (
  `id_admission` int(11) NOT NULL AUTO_INCREMENT,
  `name_admiss` varchar(50) NOT NULL,
  `login` varchar(20) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `function` varchar(20) NOT NULL,
  PRIMARY KEY (`id_admission`),
  UNIQUE KEY `id_admission` (`id_admission`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `Admission`
--

INSERT INTO `Admission` (`id_admission`, `name_admiss`, `login`, `pass`, `function`) VALUES
(2, 'Vova', '1111', '1111', 'admin'),
(10, 'Alexandr', '123', '123', 'director');

-- --------------------------------------------------------

--
-- Table structure for table `Admission1`
--

CREATE TABLE IF NOT EXISTS `Admission1` (
  `id_admission` int(11) NOT NULL AUTO_INCREMENT,
  `name_admiss` varchar(50) NOT NULL,
  `login` varchar(20) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `function` varchar(20) NOT NULL,
  PRIMARY KEY (`id_admission`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE IF NOT EXISTS `Category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name_category` varchar(60) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_category`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`id_category`, `name_category`, `delete`) VALUES
(1, 'Salads', '0'),
(2, 'Salads', '1'),
(3, 'Salads', '1'),
(4, 'Salads', '1'),
(5, 'Hot dishes', '0'),
(6, 'Salads1', '1'),
(7, 'Salads Varza', '0'),
(8, 'Salads', '1'),
(9, 'Salads Varza', '1'),
(10, 'Hot dishes1', '1'),
(11, 'Hot dishes1256', '1'),
(12, 'Hot dishes12', '1');

-- --------------------------------------------------------

--
-- Table structure for table `Deposit`
--

CREATE TABLE IF NOT EXISTS `Deposit` (
  `id_deposit` int(11) NOT NULL AUTO_INCREMENT,
  `name_deposit` varchar(60) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_deposit`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Deposit`
--

INSERT INTO `Deposit` (`id_deposit`, `name_deposit`, `delete`) VALUES
(1, 'Deposit11', '0'),
(2, 'Deposit22', '0'),
(3, 'Deposit33', '0');

-- --------------------------------------------------------

--
-- Table structure for table `Dishes`
--

CREATE TABLE IF NOT EXISTS `Dishes` (
  `id_dish` int(11) NOT NULL AUTO_INCREMENT,
  `name_dish` varchar(60) NOT NULL,
  `first_cost` smallint(6) NOT NULL,
  `cost` smallint(6) NOT NULL,
  `weight` smallint(6) NOT NULL,
  `description` text NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_dish`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Dishes`
--

INSERT INTO `Dishes` (`id_dish`, `name_dish`, `first_cost`, `cost`, `weight`, `description`, `delete`) VALUES
(1, 'Suppe', 10, 15, 200, 'A light soup mit GEflugel', '0'),
(2, 'Olivie', 15, 21, 250, 'A light sallad', '0'),
(3, 'Potatoes', 15, 25, 50, 'potato mash', '0'),
(4, 'Potatoes fry', 25, 75, 150, 'Oil boided potatoes', '0'),
(5, 'Potatoes1', 28, 32, 157, 'Potatoes fry free', '0');

-- --------------------------------------------------------

--
-- Table structure for table `DishesInCategory`
--

CREATE TABLE IF NOT EXISTS `DishesInCategory` (
  `id_category` int(11) NOT NULL,
  `id_dish` int(11) NOT NULL,
  PRIMARY KEY (`id_category`,`id_dish`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `DishesInCategory`
--

INSERT INTO `DishesInCategory` (`id_category`, `id_dish`) VALUES
(5, 1),
(5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `DishesOrdered`
--

CREATE TABLE IF NOT EXISTS `DishesOrdered` (
  `id_dish` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `serving` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_dish`,`id_menu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `DishesOrdered`
--

INSERT INTO `DishesOrdered` (`id_dish`, `id_menu`, `serving`) VALUES
(5, 7, 24),
(3, 7, 46),
(1, 7, 85),
(4, 8, 62),
(2, 7, 127),
(4, 7, 10),
(2, 8, 10),
(5, 8, 18);

-- --------------------------------------------------------

--
-- Table structure for table `Employers`
--

CREATE TABLE IF NOT EXISTS `Employers` (
  `id_employer` int(11) NOT NULL AUTO_INCREMENT,
  `name_employer` varchar(100) NOT NULL,
  `telephone_employer` varchar(20) NOT NULL,
  `id_restaurant` int(11) NOT NULL,
  `id_function` int(11) NOT NULL,
  `delete` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_employer`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Employers`
--

INSERT INTO `Employers` (`id_employer`, `name_employer`, `telephone_employer`, `id_restaurant`, `id_function`, `delete`) VALUES
(1, 'Igor Caravan', '0231 5-55-69', 4, 1, '0'),
(2, 'Oxana Rotari', '0231 5-55-67', 1, 1, '0'),
(3, 'Igor Ivanici', '0231 4-58-79', 3, 3, '0'),
(4, 'Nikolai Karpovici', '0231 8-96-97', 2, 2, '0');

-- --------------------------------------------------------

--
-- Table structure for table `Functions`
--

CREATE TABLE IF NOT EXISTS `Functions` (
  `id_function` int(11) NOT NULL AUTO_INCREMENT,
  `name_function` varchar(50) NOT NULL,
  `salary` smallint(6) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_function`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Functions`
--

INSERT INTO `Functions` (`id_function`, `name_function`, `salary`, `delete`) VALUES
(1, 'Manager', 10000, '0'),
(2, 'Contabil', 14005, '0'),
(3, 'Chef', 14000, '0'),
(4, 'chelner', 2000, '0');

-- --------------------------------------------------------

--
-- Table structure for table `Menu`
--

CREATE TABLE IF NOT EXISTS `Menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `name_menu` varchar(60) NOT NULL,
  `menu_price_fc` smallint(6) NOT NULL,
  `menu_price_c` smallint(6) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_menu`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `Menu`
--

INSERT INTO `Menu` (`id_menu`, `name_menu`, `menu_price_fc`, `menu_price_c`, `delete`) VALUES
(8, 'Pleasant', 5700, 5226, '0'),
(7, 'Surbum', 5850, 5335, '0');

-- --------------------------------------------------------

--
-- Table structure for table `Ocupation`
--

CREATE TABLE IF NOT EXISTS `Ocupation` (
  `id_employer` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  PRIMARY KEY (`id_employer`,`id_order`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Ocupation`
--

INSERT INTO `Ocupation` (`id_employer`, `id_order`) VALUES
(1, 68),
(2, 1),
(3, 5),
(4, 68);

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE IF NOT EXISTS `Orders` (
  `id_order` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `date_event` date NOT NULL,
  `time_event` time NOT NULL,
  `name` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `order_price` smallint(6) NOT NULL,
  `prepaid` smallint(6) NOT NULL,
  `number_of_guests` smallint(6) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_restaurant` int(11) NOT NULL,
  `accepted` enum('1','0') NOT NULL DEFAULT '0',
  `completed` enum('0','1') NOT NULL DEFAULT '0',
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`id_order`, `date`, `date_event`, `time_event`, `name`, `telephone`, `order_price`, `prepaid`, `number_of_guests`, `id_menu`, `id_restaurant`, `accepted`, `completed`, `delete`) VALUES
(1, '2017-01-04 00:00:00', '0000-00-00', '00:00:00', 'Alibaba Shachid', '0124578965', 0, 1000, 100, 0, 20, '1', '0', '0'),
(2, '2017-01-11 00:00:00', '0000-00-00', '00:00:00', 'Google Company', '0124578965', 0, 0, 45, 0, 0, '0', '0', '0'),
(6, '2017-01-24 04:45:55', '0000-00-00', '00:00:00', 'privet', '014578956', 0, 0, 47, 0, 0, '0', '0', '0'),
(5, '2017-01-11 00:00:00', '2019-02-15', '18:45:00', 'Vasilii Alibabaevici', '014578956', 7450, 1000, 300, 7, 2, '1', '0', '0'),
(7, '2017-01-24 04:47:22', '0000-00-00', '00:00:00', 'privet', '014578956', 0, 0, 47, 0, 0, '0', '0', '0'),
(68, '2017-04-23 11:56:20', '2017-02-15', '17:30:00', 'Victor Harabadjia', '0231 5-55-87', 7250, 1000, 120, 8, 19, '1', '0', '0'),
(72, '2017-05-05 11:30:07', '2018-01-12', '15:45:00', 'Patric Siew', '0231 5-58-98', 0, 0, 121, 0, 0, '0', '0', '0'),
(73, '2017-05-12 11:43:31', '0000-00-00', '00:00:00', 'Barbara Watson', '0231 5-55-87', 0, 0, 65, 0, 0, '0', '0', '0'),
(74, '2017-05-12 12:40:36', '0000-00-00', '00:00:00', 'Peter Natew', '0456 8-98-87', 0, 0, 100, 0, 0, '0', '0', '0'),
(75, '2017-05-22 16:17:49', '2017-04-17', '15:40:00', 'Igor Samuilovich', '0231 5-51-81', 0, 1000, 110, 0, 0, '1', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `Producator`
--

CREATE TABLE IF NOT EXISTS `Producator` (
  `id_producator` int(11) NOT NULL AUTO_INCREMENT,
  `name_producator` varchar(100) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_producator`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Producator`
--

INSERT INTO `Producator` (`id_producator`, `name_producator`, `delete`) VALUES
(1, 'Provider3', '0'),
(2, 'Provider1', '0'),
(3, 'Provider2', '0');

-- --------------------------------------------------------

--
-- Table structure for table `ProductInDish`
--

CREATE TABLE IF NOT EXISTS `ProductInDish` (
  `id_dish` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `weight` smallint(6) NOT NULL,
  PRIMARY KEY (`id_dish`,`id_product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ProductInDish`
--

INSERT INTO `ProductInDish` (`id_dish`, `id_product`, `weight`) VALUES
(1, 1, 61),
(2, 3, 150),
(1, 5, 50),
(2, 5, 51);

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE IF NOT EXISTS `Products` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `name_product` varchar(100) NOT NULL,
  `delete` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_product`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`id_product`, `name_product`, `delete`) VALUES
(1, 'Onion', '0'),
(2, 'Potatoes', '0'),
(3, 'Cicken', '0'),
(4, 'Bread', '0'),
(5, 'Ð£ÐºÑ€Ð¾Ð¿', '0'),
(6, 'Ð¾Ð³ÑƒÑ€Ñ†Ñ‹', '0');

-- --------------------------------------------------------

--
-- Table structure for table `ProductsInDeposit`
--

CREATE TABLE IF NOT EXISTS `ProductsInDeposit` (
  `id_deposit` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `weight_unit` decimal(6,2) NOT NULL,
  `price_per_kg` decimal(5,2) NOT NULL,
  `unitatea` enum('kg','piec') NOT NULL DEFAULT 'kg',
  `id_producator` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_deposit`,`id_product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ProductsInDeposit`
--

INSERT INTO `ProductsInDeposit` (`id_deposit`, `id_product`, `weight_unit`, `price_per_kg`, `unitatea`, `id_producator`, `delete`) VALUES
(1, 1, '100.00', '8.00', 'kg', 1, '0'),
(1, 2, '108.50', '12.90', 'kg', 3, '0'),
(1, 3, '40.00', '45.78', 'kg', 1, '0'),
(1, 4, '45.00', '7.85', 'piec', 2, '0'),
(2, 1, '70.00', '4.60', 'kg', 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `Restaurant`
--

CREATE TABLE IF NOT EXISTS `Restaurant` (
  `id_restaurant` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `number_sits` smallint(6) NOT NULL,
  `delete` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_restaurant`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `Restaurant`
--

INSERT INTO `Restaurant` (`id_restaurant`, `name`, `address`, `telephone`, `number_sits`, `delete`) VALUES
(1, 'Moldova', 'm. Balti str. Negrutii 28A', '0(231) 5-81-22', 160, '0'),
(2, 'Glamour', 'm. Chisinau str. C Stamati 124 B', '0(122) 54-89-74', 210, '1'),
(3, 'Prezident', 'm. Balti str N Iorga 147 A', '0(231) 7-54-87', 250, '0'),
(4, 'Oscar', 'str. Sadoveanu 1, or. BÄƒlÈ›i', '(0231) 5-54-59', 120, '0'),
(23, 'Noroc', 'str. Decebal 131, or. BÄƒlÈ›i', '0(231)2-22-82', 50, '0'),
(22, 'bn', 'bg', 'bgh', 13, '1'),
(21, 'Tineretia', 'Sarmesicidusa 20A', '0(125)457893', 210, '1'),
(19, 'Harabadji', 'or. Drochiia 54A', '0(289) 2-96-87', 190, '1'),
(20, 'Magnolia', 'Chisinau str Columna', '21365(1245-45)', 45, '0'),
(18, 'TelAvim', 'm. Balti str. Columna 35A', '0(255) 6-54-89', 157, '1');

-- --------------------------------------------------------

--
-- Table structure for table `SignUpForNews`
--

CREATE TABLE IF NOT EXISTS `SignUpForNews` (
  `id_sign_up` int(11) NOT NULL AUTO_INCREMENT,
  `sign_up_name` varchar(50) NOT NULL,
  `sign_up_email` varchar(50) NOT NULL,
  PRIMARY KEY (`id_sign_up`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `SignUpForNews`
--

INSERT INTO `SignUpForNews` (`id_sign_up`, `sign_up_name`, `sign_up_email`) VALUES
(1, 'Natali', 'NataliR@mail.ru'),
(6, 'Vasilii', 'Vasilii@mail.ru'),
(9, 'Snejana', 'Snejana@mail.ru'),
(8, 'MessaD', 'MessaD@mail.ru');

-- --------------------------------------------------------

--
-- Table structure for table `TempOrder`
--

CREATE TABLE IF NOT EXISTS `TempOrder` (
  `id_t_o` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `reserv_date` date NOT NULL,
  `reserv_time` time NOT NULL,
  `am_guests` smallint(6) NOT NULL,
  `cont_number` varchar(25) NOT NULL,
  `accepted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_t_o`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `TempOrder`
--

INSERT INTO `TempOrder` (`id_t_o`, `name`, `reserv_date`, `reserv_time`, `am_guests`, `cont_number`, `accepted`) VALUES
(1, 'Victor Harabadjia', '2017-02-15', '17:30:00', 120, '0231 5-55-87', '1'),
(2, 'Patric Siew', '2018-01-12', '15:45:00', 121, '0231 5-58-98', '1'),
(3, 'Comandor Teylor', '2019-01-01', '17:30:00', 123, '0231 8-98-97', '0');

-- --------------------------------------------------------

--
-- Table structure for table `Variabile`
--

CREATE TABLE IF NOT EXISTS `Variabile` (
  `line` smallint(6) NOT NULL,
  `profit_procent` float NOT NULL DEFAULT '0',
  `dish_procent` float NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Variabile`
--

INSERT INTO `Variabile` (`line`, `profit_procent`, `dish_procent`) VALUES
(1, 27, 9);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
