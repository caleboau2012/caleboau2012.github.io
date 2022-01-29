-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2014 at 05:49 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kopa`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE IF NOT EXISTS `announcement` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `announce` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`ID`, `announce`) VALUES
(1, '       Message '),
(2, 'Testing        ');

-- --------------------------------------------------------

--
-- Table structure for table `otondo`
--

CREATE TABLE IF NOT EXISTS `otondo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `call_no` varchar(15) NOT NULL,
  `code` int(15) NOT NULL,
  `password` varchar(25) NOT NULL,
  `batch` int(15) NOT NULL,
  `state` varchar(25) NOT NULL,
  `request` int(1) NOT NULL,
  `request_state` varchar(25) DEFAULT NULL,
  `dp` varchar(25) DEFAULT NULL,
  `alias` varchar(25) DEFAULT NULL,
  `status` text,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `call_no` (`call_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `otondo`
--

INSERT INTO `otondo` (`ID`, `call_no`, `code`, `password`, `batch`, `state`, `request`, `request_state`, `dp`, `alias`, `status`) VALUES
(1, '10', 10, '', 1, 'osun', 0, '', NULL, NULL, NULL),
(2, '1000', 1000, 'prince', 1, 'osun', 0, '', '1404055208.png', 'Kay Lee', 'testing this code'),
(4, '100', 1000, 'password', 10, 'kwara', 0, '', NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
