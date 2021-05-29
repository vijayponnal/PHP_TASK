-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `php_task`;
CREATE DATABASE `php_task` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `php_task`;

DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cmp_name` varchar(100) NOT NULL,
  `cmp_email` varchar(100) NOT NULL,
  `cmp_mobile` varchar(12) NOT NULL,
  `cmp_address` varchar(250) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `company` (`id`, `cmp_name`, `cmp_email`, `cmp_mobile`, `cmp_address`, `created_date`) VALUES
(1,	'Company ABC',	'admin@abc.com',	'9090909090',	'1-22,Hyd,Ind,Ts,500078',	'2021-05-28 05:41:27');

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(12) DEFAULT NULL,
  `bill_to_address` varchar(250) DEFAULT NULL,
  `ship_to_address` varchar(250) DEFAULT NULL,
  `status` varchar(2) NOT NULL DEFAULT '00',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `customers_ibfk_2` FOREIGN KEY (`id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `customers` (`id`, `name`, `email`, `mobile`, `bill_to_address`, `ship_to_address`, `status`, `created_date`) VALUES
(1,	'customer one',	'customerone@abc.com',	'8989898989',	'1-2-3,Hyd,Ts,Ind',	'1-2-3,Hyd,Ts,Ind',	'00',	'2021-05-28 05:40:55');

DROP TABLE IF EXISTS `sales_line`;
CREATE TABLE `sales_line` (
  `so_line_id` int(11) NOT NULL AUTO_INCREMENT,
  `so_order_id` int(11) NOT NULL,
  `so_line_date` date NOT NULL,
  `so_line_item_description` varchar(150) DEFAULT NULL,
  `so_line_invcode` varchar(20) DEFAULT NULL,
  `so_line_qty` decimal(11,2) DEFAULT NULL,
  `so_line_price` decimal(11,2) NOT NULL DEFAULT 0.00,
  `so_line_tax_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `so_line_tax` decimal(11,2) NOT NULL DEFAULT 0.00,
  `so_line_discount` decimal(11,2) NOT NULL DEFAULT 0.00,
  `so_line_total` decimal(11,2) NOT NULL DEFAULT 0.00,
  `so_line_status` varchar(2) NOT NULL DEFAULT '00',
  PRIMARY KEY (`so_line_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `sales_order`;
CREATE TABLE `sales_order` (
  `so_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `so_date` date NOT NULL,
  `so_net` decimal(11,2) NOT NULL DEFAULT 0.00,
  `so_tax` decimal(11,2) NOT NULL DEFAULT 0.00,
  `so_discount` decimal(11,2) NOT NULL DEFAULT 0.00,
  `so_total` decimal(11,2) NOT NULL DEFAULT 0.00,
  `so_ship_charges` decimal(11,2) NOT NULL DEFAULT 0.00,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `so_ship_to` varchar(300) DEFAULT NULL,
  `so_bill_to` varchar(300) DEFAULT NULL,
  `so_created_date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `invoice_number` varchar(20) NOT NULL DEFAULT '000',
  `so_status` varchar(2) NOT NULL DEFAULT '00',
  PRIMARY KEY (`so_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2021-05-28 16:52:38
