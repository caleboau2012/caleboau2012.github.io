CREATE DATABASE IF NOT EXISTS `ariya`;
#
USE `ariya`;
# CREATE DATABASE IF NOT EXISTS `calebcom_ariya`;

# USE `calebcom_ariya`;

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB;

INSERT INTO `categories` (`category_id`, `name`) VALUES
  (1, 'Halls'),
  (2, 'Office'),
  (3, 'Rooftop'),
  (4, 'Compound'),
  (5, 'Garden'),
  (6, 'Conference Room');

CREATE TABLE IF NOT EXISTS `bid_book_statuses` (
  `bid_book_status_id` TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`bid_book_status_id`)
) ENGINE=InnoDB;

INSERT INTO `bid_book_statuses` (`bid_book_status_id`, `name`) VALUES
  (1, 'in_progress'),
  (2, 'accepted'),
  (3, 'declined'),
  (4, 'closed'),
  (5, 'cancelled');

CREATE TABLE IF NOT EXISTS `bid_book_types` (
  `bid_book_type_id` TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(4) NOT NULL,
  PRIMARY KEY (`bid_book_type_id`)
) ENGINE=InnoDB;

INSERT INTO `bid_book_types` (`bid_book_type_id`, `name`) VALUES
  (1, 'bid'),
  (2, 'book'),
  (3, 'own');


CREATE TABLE IF NOT EXISTS `cron_statuses` (
  `cron_status_id` TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`cron_status_id`)
) ENGINE=InnoDB;

INSERT INTO `cron_statuses` (`cron_status_id`, `name`) VALUES
  (1, 'in_progress'),
  (2, 'completed');

CREATE TABLE IF NOT EXISTS `payment_statuses` (
  `payment_status_id` TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`payment_status_id`)
) ENGINE=InnoDB;

INSERT INTO `payment_statuses` (`payment_status_id`, `name`) VALUES
  (1, 'unpaid'),
  (2, 'paid'),
  (3, 'pending');

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `email_address` VARCHAR(255) NOT NULL UNIQUE,
  `password` TEXT NOT NULL,
  `profile_picture` VARCHAR(1023) NOT NULL DEFAULT 'user_default.png',
  `phone_number` VARCHAR(25) NOT NULL,
  `street` TEXT NOT NULL,
  `city` VARCHAR(70) NOT NULL,
  `state` VARCHAR(70) NOT NULL,
  `country` VARCHAR(70) NOT NULL,
  `company_name` VARCHAR(255) NOT NULL,
  `company_street` TEXT NOT NULL,
  `company_city` VARCHAR(70) NOT NULL,
  `company_state` VARCHAR(70) NOT NULL,
  `company_country` VARCHAR(70) NOT NULL,
  `account_number` VARCHAR(50) NOT NULL DEFAULT 0,
  `bank_code` VARCHAR(10) NOT NULL DEFAULT 0,
  `token` TEXT NOT NULL,
  `created_time` DATETIME NOT NULL,
  `modified_time` DATETIME NOT NULL,
  `active_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 2,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `properties` (
  `property_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `owner_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `category_id` TINYINT(1) UNSIGNED NOT NULL,
  `description` TEXT NOT NULL,
  `street` TEXT NOT NULL,
  `city` VARCHAR(70) NOT NULL,
  `state` VARCHAR(70) NOT NULL,
  `country` VARCHAR(70) NOT NULL,
  `latitude` VARCHAR(50) NOT NULL,
  `longitude` VARCHAR(50) NOT NULL,
  `capacity` VARCHAR(20) NOT NULL,
  `booking_price` VARCHAR(20) NOT NULL,
  `minimum_bid_price` VARCHAR(20) NOT NULL,
  `rating` INT UNSIGNED NOT NULL DEFAULT 0,
  `created_time` DATETIME NOT NULL,
  `modified_time` DATETIME NOT NULL,
  `active_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`property_id`),
  CONSTRAINT `fk_properties_owner_id` FOREIGN KEY (`owner_id`) REFERENCES users(`user_id`),
  CONSTRAINT `fk_properties_category_id` FOREIGN KEY (`category_id`) REFERENCES categories(`category_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `statistics` (
  `statistic_id` INT(30) UNSIGNED NOT NULL AUTO_INCREMENT,
  `property_id` INT UNSIGNED NOT NULL UNIQUE,
  `security` INT(3) UNSIGNED NOT NULL DEFAULT 0,
  `power` INT(3) UNSIGNED NOT NULL DEFAULT 0,
  `water` INT(3) UNSIGNED NOT NULL DEFAULT 0,
  `accessibility` INT(3) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`statistic_id`),
  CONSTRAINT `fk_statistics_property_id` FOREIGN KEY (`property_id`) REFERENCES properties(`property_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `features` (
  `feature_id` INT(30) UNSIGNED NOT NULL AUTO_INCREMENT,
  `property_id` INT UNSIGNED NOT NULL UNIQUE,
  `air_condition` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `swim_pool` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `bar` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `internet` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `backup_power` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `parking` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `rest_rooms` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`feature_id`),
  CONSTRAINT `fk_features_property_id` FOREIGN KEY (`property_id`) REFERENCES properties(`property_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `property_images` (
  `property_image_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `property_id` INT UNSIGNED NOT NULL,
  `url` VARCHAR(511) NOT NULL,
  `created_time` DATETIME NOT NULL,
  `active_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`property_image_id`),
  CONSTRAINT `fk_property_images_property_id` FOREIGN KEY (`property_id`) REFERENCES properties(`property_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `bids_books` (
  `bid_book_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `property_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `event_name` VARCHAR(255) NOT NULL,
  `event_date` DATE NOT NULL,
  `bid_book_type_id` TINYINT(1) UNSIGNED NOT NULL,
  `price` VARCHAR(20) NOT NULL,
  `bid_book_status_id` TINYINT(1) UNSIGNED NOT NULL,
  `cron_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `created_time` DATETIME NOT NULL,
  `modified_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `active_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`bid_book_id`),
  CONSTRAINT `fk_bids_books_property_id` FOREIGN KEY (`property_id`) REFERENCES properties(`property_id`),
  CONSTRAINT `fk_bids_books_user_id` FOREIGN KEY (`user_id`) REFERENCES users(`user_id`),
  CONSTRAINT `fk_bids_books_type_id` FOREIGN KEY (`bid_book_type_id`) REFERENCES bid_book_types(`bid_book_type_id`),
  CONSTRAINT `fk_bids_books_status_id` FOREIGN KEY (`bid_book_status_id`) REFERENCES bid_book_statuses(`bid_book_status_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `bid_book_races` (
  `bid_book_race_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `bid_book_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `event_name` VARCHAR(255) NOT NULL,
  `event_date` DATE NOT NULL,
  `price` VARCHAR(20) NOT NULL,
  `bid_book_status_id` TINYINT(1) UNSIGNED NOT NULL,
  `created_time` DATETIME NOT NULL,
  `active_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`bid_book_race_id`),
  CONSTRAINT `fk_bid_book_races_bid_book_id` FOREIGN KEY (`bid_book_id`) REFERENCES bids_books(`bid_book_id`),
  CONSTRAINT `fk_bid_book_races_user_id` FOREIGN KEY (`user_id`) REFERENCES users(`user_id`),
  CONSTRAINT `fk_bid_book_races_status_id` FOREIGN KEY (`bid_book_status_id`) REFERENCES bid_book_statuses(`bid_book_status_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `reviews` (
  `review_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `property_id` INT UNSIGNED NOT NULL,
  `rating` TINYINT(1) NOT NULL,
  `review` TEXT NOT NULL,
  `created_time` DATETIME NOT NULL,
  `modified_time` DATETIME NOT NULL,
  `active_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`review_id`),
  CONSTRAINT `fk_reviews_user_id` FOREIGN KEY (`user_id`) REFERENCES users(`user_id`),
  CONSTRAINT `fk_reviews_property_id` FOREIGN KEY (`property_id`) REFERENCES properties(`property_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `crons` (
  `cron_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `bid_book_id` INT UNSIGNED NOT NULL,
  `start_datetime` DATETIME NOT NULL,
  `interval_time` INT(10) NOT NULL,
  `cron_status_id` TINYINT(1) UNSIGNED NOT NULL,
  `cron_type_id` TINYINT(1) UNSIGNED NOT NULL,
  `modified_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `active_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`cron_id`),
  CONSTRAINT `fk_crons_bid_book_id` FOREIGN KEY (`bid_book_id`) REFERENCES bids_books(`bid_book_id`),
  CONSTRAINT `fk_crons_cron_status_id` FOREIGN KEY (`cron_status_id`) REFERENCES cron_statuses(`cron_status_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `notification_statuses` (
  `notification_status_id` TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`notification_status_id`)
) ENGINE=InnoDB;

INSERT INTO `notification_statuses` (`notification_status_id`, `name`) VALUES
  (1, 'pending'),
  (2, 'accepted'),
  (3, 'declined');

CREATE TABLE IF NOT EXISTS `notification_types` (
  `notification_type_id` TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`notification_type_id`)
) ENGINE=InnoDB;

INSERT INTO `notification_types` (`notification_type_id`, `name`) VALUES
  (1, 'bid'),
  (2, 'book'),
  (3, 'review'),
  (4, 'bid_closed'),
  (5, 'bid_accepted'),
  (6, 'bid_declined'),
  (7, 'book_accepted'),
  (8, 'book_declined'),
  (9, 'payment_accepted'),
  (10, 'bid_accepted_owner'),
  (11, 'bid_declined_owner'),
  (12, 'book_accepted_owner'),
  (13, 'book_declined_owner'),
  (14, 'payment_cancelled'),
  (15, 'payment_cancelled_owner'),
  (16, 'payment_reminder_24'),
  (17, 'payment_reminder_24_owner');

CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `owner_id` INT UNSIGNED NOT NULL,
  `subject_id` INT UNSIGNED NOT NULL,
  `notification_type_id` TINYINT(1) UNSIGNED NOT NULL,
  `notification_status_id` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_time` DATETIME NOT NULL,
  `modified_time` DATETIME NOT NULL,
  `active_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`notification_id`),
  CONSTRAINT `fk_notifications_owner_id` FOREIGN KEY (`owner_id`) REFERENCES users(`user_id`),
  CONSTRAINT `fk_notifications_type_id` FOREIGN KEY (`notification_type_id`) REFERENCES notification_types(`notification_type_id`),
  CONSTRAINT `fk_notifications_status_id` FOREIGN KEY (`notification_status_id`) REFERENCES notification_statuses(`notification_status_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `bid_book_id` INT UNSIGNED NOT NULL UNIQUE,
  `ticket_id` VARCHAR(15) NOT NULL,
  `rrr` VARCHAR(15) NULL,
  `order_id` VARCHAR(15) NULL,
  `property_amount` VARCHAR(20) NOT NULL,
  `ariya_amount` VARCHAR(20) NOT NULL,
  `gateway_amount` VARCHAR(20) NOT NULL,
  `total_amount` VARCHAR(20) NOT NULL,
  `payment_status_id` TINYINT(1) UNSIGNED DEFAULT 1,
  `response_status` INT(3) NULL,
  `response_message` VARCHAR(100) NULL,
  `response_transaction_time` VARCHAR(26) NULL,
  `twenty_four_hour_status_id` TINYINT(1) UNSIGNED DEFAULT 1,
  `created_time` DATETIME NOT NULL,
  `modified_time` DATETIME NOT NULL,
  `active_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`payment_id`),
  CONSTRAINT `fk_payments_bid_book_id` FOREIGN KEY (`bid_book_id`) REFERENCES bids_books(`bid_book_id`),
  CONSTRAINT `fk_payments_status_id` FOREIGN KEY (`payment_status_id`) REFERENCES payment_statuses(`payment_status_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `payment_reports` (
  `payment_report_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `bid_book_id` INT UNSIGNED NOT NULL,
  `ticket_id` VARCHAR(15) NOT NULL,
  `rrr` VARCHAR(15) NULL,
  `order_id` VARCHAR(15) NULL,
  `property_amount` VARCHAR(20) NOT NULL,
  `ariya_amount` VARCHAR(20) NOT NULL,
  `gateway_amount` VARCHAR(20) NOT NULL,
  `total_amount` VARCHAR(20) NOT NULL,
  `payment_status_id` TINYINT(1) UNSIGNED DEFAULT 1,
  `response_status` INT(3) NULL,
  `response_message` VARCHAR(100) NULL,
  `response_transaction_time` VARCHAR(26) NULL,
  `created_time` DATETIME NOT NULL,
  `modified_time` DATETIME NOT NULL,
  `active_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`payment_report_id`),
  CONSTRAINT `fk_payment_reports_bid_book_id` FOREIGN KEY (`bid_book_id`) REFERENCES bids_books(`bid_book_id`),
  CONSTRAINT `fk_payment_reports_status_id` FOREIGN KEY (`payment_status_id`) REFERENCES payment_statuses(`payment_status_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `contacts` (
  `contact_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email_address` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `created_time` DATETIME NOT NULL,
  `modified_time` DATETIME NOT NULL,
  `active_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB;
