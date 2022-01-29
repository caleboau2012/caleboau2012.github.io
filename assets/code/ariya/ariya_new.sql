-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 20, 2015 at 06:15 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ariya`
--

-- --------------------------------------------------------

--
-- Table structure for table `bids_books`
--

CREATE TABLE IF NOT EXISTS `bids_books` (
  `bid_book_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `bid_book_type_id` tinyint(1) unsigned NOT NULL,
  `price` varchar(20) NOT NULL,
  `bid_book_status_id` tinyint(1) unsigned NOT NULL,
  `created_time` datetime NOT NULL,
  `active_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`bid_book_id`),
  KEY `fk_bids_books_property_id` (`property_id`),
  KEY `fk_bids_books_user_id` (`user_id`),
  KEY `fk_bids_books_type_id` (`bid_book_type_id`),
  KEY `fk_bids_books_status_id` (`bid_book_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `bids_books`
--

INSERT INTO `bids_books` (`bid_book_id`, `property_id`, `user_id`, `event_name`, `event_date`, `bid_book_type_id`, `price`, `bid_book_status_id`, `created_time`, `active_status`) VALUES
(3, 1, 3, 'Private', '2015-05-10', 2, '0', 2, '2015-05-20 05:51:06', 1),
(5, 1, 3, 'Private', '2015-05-27', 2, '0', 2, '2015-05-20 17:27:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bid_book_statuses`
--

CREATE TABLE IF NOT EXISTS `bid_book_statuses` (
  `bid_book_status_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`bid_book_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bid_book_statuses`
--

INSERT INTO `bid_book_statuses` (`bid_book_status_id`, `name`) VALUES
(1, 'pending'),
(2, 'accepted'),
(3, 'declined');

-- --------------------------------------------------------

--
-- Table structure for table `bid_book_types`
--

CREATE TABLE IF NOT EXISTS `bid_book_types` (
  `bid_book_type_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(4) NOT NULL,
  PRIMARY KEY (`bid_book_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bid_book_types`
--

INSERT INTO `bid_book_types` (`bid_book_type_id`, `name`) VALUES
(1, 'bid'),
(2, 'book');

-- --------------------------------------------------------

--
-- Table structure for table `bid_races`
--

CREATE TABLE IF NOT EXISTS `bid_races` (
  `bid_race_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bid_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `price` varchar(20) NOT NULL,
  `created_time` datetime NOT NULL,
  `active_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`bid_race_id`),
  KEY `fk_bid_races_bid_id` (`bid_id`),
  KEY `fk_bid_races_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Halls'),
(2, 'Office'),
(3, 'Rooftop'),
(4, 'Compound');

-- --------------------------------------------------------

--
-- Table structure for table `crons`
--

CREATE TABLE IF NOT EXISTS `crons` (
  `cron_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bid_id` int(10) unsigned NOT NULL,
  `start_datetime` datetime NOT NULL,
  `interval` tinyint(2) NOT NULL,
  `cron_status_id` tinyint(1) unsigned NOT NULL,
  `created_time` datetime NOT NULL,
  `active_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`cron_id`),
  KEY `fk_crons_bid_id` (`bid_id`),
  KEY `fk_crons_cron_status_id` (`cron_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cron_statuses`
--

CREATE TABLE IF NOT EXISTS `cron_statuses` (
  `cron_status_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`cron_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE IF NOT EXISTS `features` (
  `feature_id` int(30) unsigned NOT NULL AUTO_INCREMENT,
  `property_id` int(10) unsigned NOT NULL,
  `air_condition` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `swim_pool` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `bar` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `internet` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `backup_power` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`feature_id`),
  UNIQUE KEY `property_id` (`property_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`feature_id`, `property_id`, `air_condition`, `swim_pool`, `bar`, `internet`, `backup_power`) VALUES
(1, 1, 1, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE IF NOT EXISTS `properties` (
  `property_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` tinyint(1) unsigned NOT NULL,
  `description` text NOT NULL,
  `street` text NOT NULL,
  `city` varchar(70) NOT NULL,
  `state` varchar(70) NOT NULL,
  `country` varchar(70) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `capacity` varchar(20) NOT NULL,
  `booking_price` varchar(20) NOT NULL,
  `minimum_bid_price` varchar(20) NOT NULL,
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL,
  `active_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`property_id`),
  KEY `fk_properties_owner_id` (`owner_id`),
  KEY `fk_properties_category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`property_id`, `owner_id`, `name`, `category_id`, `description`, `street`, `city`, `state`, `country`, `latitude`, `longitude`, `capacity`, `booking_price`, `minimum_bid_price`, `created_time`, `modified_time`, `active_status`) VALUES
(1, 3, 'A property', 1, 'A description', 'A street', 'In a city', 'In a state', 'Nigeria', '6.51411069478635', '3.2594847337891224', '5000', '30000', '10000', '2015-05-17 00:08:30', '2015-05-17 02:32:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE IF NOT EXISTS `property_images` (
  `property_image_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property_id` int(10) unsigned NOT NULL,
  `url` varchar(511) NOT NULL,
  `created_time` datetime NOT NULL,
  `active_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`property_image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`property_image_id`, `property_id`, `url`, `created_time`, `active_status`) VALUES
(1, 1, '1_58414_1431821310.jpg', '2015-05-17 00:08:30', 1),
(2, 1, '1_24287_1431821310.png', '2015-05-17 00:08:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `review_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `property_id` int(10) unsigned NOT NULL,
  `rating` tinyint(1) NOT NULL DEFAULT '0',
  `remark` text NOT NULL,
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL,
  `active_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`review_id`),
  KEY `fk_reviews_user_id` (`user_id`),
  KEY `fk_reviews_property_id` (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `statistics`
--

CREATE TABLE IF NOT EXISTS `statistics` (
  `statistic_id` int(30) unsigned NOT NULL AUTO_INCREMENT,
  `property_id` int(10) unsigned NOT NULL,
  `security` int(3) unsigned NOT NULL DEFAULT '0',
  `power` int(3) unsigned NOT NULL DEFAULT '0',
  `water` int(3) unsigned NOT NULL DEFAULT '0',
  `accessibility` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`statistic_id`),
  UNIQUE KEY `property_id` (`property_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `statistics`
--

INSERT INTO `statistics` (`statistic_id`, `property_id`, `security`, `power`, `water`, `accessibility`) VALUES
(1, 1, 20, 60, 30, 80);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `profile_picture` varchar(1023) NOT NULL DEFAULT 'user_default.png',
  `phone_number` varchar(25) NOT NULL,
  `street` text NOT NULL,
  `city` varchar(70) NOT NULL,
  `state` varchar(70) NOT NULL,
  `country` varchar(70) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_street` text NOT NULL,
  `company_city` varchar(70) NOT NULL,
  `company_state` varchar(70) NOT NULL,
  `company_country` varchar(70) NOT NULL,
  `token` text NOT NULL,
  `created_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL,
  `active_status` tinyint(1) unsigned NOT NULL DEFAULT '2',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email_address` (`email_address`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email_address`, `password`, `profile_picture`, `phone_number`, `street`, `city`, `state`, `country`, `company_name`, `company_street`, `company_city`, `company_state`, `company_country`, `token`, `created_time`, `modified_time`, `active_status`) VALUES
(3, 'Matthew', 'Mayaki', 'admin@admin.com', '$2a$10$35879711142b666d3655bOYAknwlHhLb3hRwed0FVNOTWfzPFeWXS', '301431821101.jpeg', '12345678910', 'An address', 'In a city', 'in a state', 'in a country', '', '', '', '', '', 'a0cb5a56a081ef409a8d26963f8808f9', '2015-05-17 00:01:48', '2015-05-17 00:05:01', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bids_books`
--
ALTER TABLE `bids_books`
  ADD CONSTRAINT `fk_bids_books_property_id` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`),
  ADD CONSTRAINT `fk_bids_books_status_id` FOREIGN KEY (`bid_book_status_id`) REFERENCES `bid_book_statuses` (`bid_book_status_id`),
  ADD CONSTRAINT `fk_bids_books_type_id` FOREIGN KEY (`bid_book_type_id`) REFERENCES `bid_book_types` (`bid_book_type_id`),
  ADD CONSTRAINT `fk_bids_books_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `bid_races`
--
ALTER TABLE `bid_races`
  ADD CONSTRAINT `fk_bid_races_bid_id` FOREIGN KEY (`bid_id`) REFERENCES `bids_books` (`bid_book_id`),
  ADD CONSTRAINT `fk_bid_races_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `crons`
--
ALTER TABLE `crons`
  ADD CONSTRAINT `fk_crons_bid_id` FOREIGN KEY (`bid_id`) REFERENCES `bids_books` (`bid_book_id`),
  ADD CONSTRAINT `fk_crons_cron_status_id` FOREIGN KEY (`cron_status_id`) REFERENCES `cron_statuses` (`cron_status_id`);

--
-- Constraints for table `features`
--
ALTER TABLE `features`
  ADD CONSTRAINT `fk_features_property_id` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`);

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `fk_properties_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `fk_properties_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_property_id` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`),
  ADD CONSTRAINT `fk_reviews_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `statistics`
--
ALTER TABLE `statistics`
  ADD CONSTRAINT `fk_statistics_property_id` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
