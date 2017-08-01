-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 04, 2017 at 07:06 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shopavenew`
--

-- --------------------------------------------------------

--
-- Table structure for table `rkl_product`
--

CREATE TABLE IF NOT EXISTS `rkl_product` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(160) NOT NULL,
  `category` varchar(160) NOT NULL,
  `description` varchar(160) NOT NULL,
  `sku` varchar(20) NOT NULL,
  `upc` varchar(20) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `shipping_cost` decimal(8,2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `rkl_product`
--

INSERT INTO `rkl_product` (`ID`, `product_name`, `category`, `description`, `sku`, `upc`, `price`, `shipping_cost`) VALUES
(8, 'test4', 'test1', 'test1', 'test', 'test', 1801.00, 40.00),
(9, 'test4', 'test1', 'test1', 'test', 'test', 1801.00, 40.00),
(10, 'test', 'test1', 'test1', 'test', 'test', 1801.00, 401.00),
(11, 'test4', 'test1', 'test1', 'test', 'test', 1801.00, 40.00),
(12, 'test4', 'test1', 'test1', 'test', 'test', 1801.00, 40.00);

-- --------------------------------------------------------

--
-- Table structure for table `rkl_role`
--

CREATE TABLE IF NOT EXISTS `rkl_role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `modify_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rkl_role`
--

INSERT INTO `rkl_role` (`id`, `name`, `create_datetime`, `modify_datetime`, `created_by`, `modify_by`) VALUES
(1, 'Admin', '0000-00-00 00:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rkl_users`
--

CREATE TABLE IF NOT EXISTS `rkl_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `password` varchar(36) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `is_blocked` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(50) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `modify_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rkl_users`
--

INSERT INTO `rkl_users` (`id`, `firstname`, `lastname`, `password`, `email`, `phone`, `is_blocked`, `is_active`, `token`, `create_datetime`, `modify_datetime`, `created_by`, `modify_by`) VALUES
(1, 'superadmin', 'superadmin', '17c4520f6cfd1ab53d8745e84681eb49', 'superadmin@gmail.com', '1111111111', 0, 1, '', '2017-04-26 00:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rkl_users_role`
--

CREATE TABLE IF NOT EXISTS `rkl_users_role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `modify_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rkl_users_role`
--

INSERT INTO `rkl_users_role` (`id`, `user_id`, `role_id`, `create_datetime`, `modify_datetime`, `created_by`, `modify_by`) VALUES
(1, 1, 1, '0000-00-00 00:00:00', NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
