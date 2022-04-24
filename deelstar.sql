-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 24, 2022 at 10:36 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deelstar`
--

-- --------------------------------------------------------

--
-- Table structure for table `fiets_gegevens`
--

DROP TABLE IF EXISTS `fiets_gegevens`;
CREATE TABLE IF NOT EXISTS `fiets_gegevens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `merk_id` int(11) NOT NULL,
  `model` varchar(50) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `color` varchar(50) NOT NULL,
  `size` int(2) NOT NULL,
  `status` int(1) NOT NULL,
  `info` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fiets_reparaties`
--

DROP TABLE IF EXISTS `fiets_reparaties`;
CREATE TABLE IF NOT EXISTS `fiets_reparaties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fiets_id` int(11) NOT NULL,
  `reparatie_datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reparatie_info` varchar(255) NOT NULL,
  `reparatie_notities` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fiets_verhuur`
--

DROP TABLE IF EXISTS `fiets_verhuur`;
CREATE TABLE IF NOT EXISTS `fiets_verhuur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klant_id` int(11) NOT NULL,
  `fiets_id` int(11) NOT NULL,
  `verhuur_datum` datetime NOT NULL,
  `verhuur_deadline` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `klant_gegevens`
--

DROP TABLE IF EXISTS `klant_gegevens`;
CREATE TABLE IF NOT EXISTS `klant_gegevens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `postalcode` varchar(6) NOT NULL,
  `housenr` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `merk_gegevens`
--

DROP TABLE IF EXISTS `merk_gegevens`;
CREATE TABLE IF NOT EXISTS `merk_gegevens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
