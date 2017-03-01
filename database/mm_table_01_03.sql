-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2017 at 08:52 AM
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shaiful_arm_ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `ems_mm_agenda_hom`
--

CREATE TABLE IF NOT EXISTS `ems_mm_agenda_hom` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `purpose` text NOT NULL,
  `status_forward` varchar(255) NOT NULL DEFAULT 'Pending',
  `status_complete` varchar(255) NOT NULL DEFAULT 'Pending',
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_mm_agenda_hom`
--

INSERT INTO `ems_mm_agenda_hom` (`id`, `date`, `purpose`, `status_forward`, `status_complete`, `status`, `date_created`, `user_created`, `date_updated`, `user_updated`) VALUES
(1, 1488218400, 'testings', 'Forwarded', 'Completed', 'Active', 1488267596, 1, 1488330889, 1),
(2, 1, 'new testing', 'Forwarded', 'Completed', 'Active', 1488335485, 1, 1488338656, 1),
(3, 2, 'again testings', 'Forwarded', 'Completed', 'Active', 1488349995, 1, 1488350030, 1),
(4, 1, 'just for testing', 'Forwarded', 'Completed', 'Active', 1488351708, 1, 1488353389, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_mm_agenda_hom_collection`
--

CREATE TABLE IF NOT EXISTS `ems_mm_agenda_hom_collection` (
  `id` int(11) NOT NULL,
  `id_agenda` int(11) NOT NULL,
  `id_division` int(11) NOT NULL,
  `budget_total` int(11) DEFAULT NULL,
  `achievement_total` float DEFAULT NULL,
  `target_current_month` int(11) DEFAULT NULL,
  `achievement_current_month` float DEFAULT NULL,
  `target_next_month` int(11) DEFAULT NULL,
  `target_next_month_im` int(11) DEFAULT NULL,
  `remarks_before_meeting` varchar(255) DEFAULT NULL,
  `remarks_in_meeting` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `revision` int(11) NOT NULL DEFAULT '1',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_mm_agenda_hom_collection`
--

INSERT INTO `ems_mm_agenda_hom_collection` (`id`, `id_agenda`, `id_division`, `budget_total`, `achievement_total`, `target_current_month`, `achievement_current_month`, `target_next_month`, `target_next_month_im`, `remarks_before_meeting`, `remarks_in_meeting`, `status`, `revision`, `date_created`, `user_created`, `date_updated`, `user_updated`) VALUES
(1, 2, 1, 34, 534, 53, 4534, 534, NULL, 'erter', NULL, 'Active', 3, 1488348068, 1, NULL, NULL),
(2, 2, 2, 345, 34, 534, 534, 534, NULL, 'erter', NULL, 'Active', 3, 1488348068, 1, NULL, NULL),
(3, 2, 3, 34, 534, 5, 345, 345, NULL, '345', NULL, 'Active', 3, 1488348068, 1, NULL, NULL),
(4, 2, 1, 20, 534, 53, 4534, 534, NULL, 'erter', NULL, 'Active', 2, 1488348081, 1, NULL, NULL),
(5, 2, 2, 345, 34, 534, 534, 534, NULL, 'erter', NULL, 'Active', 2, 1488348081, 1, NULL, NULL),
(6, 2, 3, 34, 534, 5, 345, 345, NULL, '345', NULL, 'Active', 2, 1488348081, 1, NULL, NULL),
(7, 2, 1, 20, 534, 53, 4534, 534, NULL, 'erter', 'ok1', 'Active', 1, 1488348106, 1, 1488351640, 1),
(8, 2, 2, 345, 34, 534, 534, 534, NULL, 'erter', 'ok2', 'Active', 1, 1488348106, 1, 1488351640, 1),
(9, 2, 3, 34, 534, 5, 345, 345, NULL, '345', 'ok3', 'Active', 1, 1488348106, 1, 1488351640, 1),
(10, 1, 1, 456, 45, 645, 645, 64, NULL, 'etrter', NULL, 'Active', 4, 1488349671, 1, NULL, NULL),
(11, 1, 2, 456, 45, 645, 64, 56, NULL, 'etert4', NULL, 'Active', 4, 1488349671, 1, NULL, NULL),
(12, 1, 3, 5, 645, 645, 645, 654, NULL, 'erter', NULL, 'Active', 4, 1488349671, 1, NULL, NULL),
(13, 1, 1, 456, 45, 645, 645, 64, NULL, 'etrter', NULL, 'Active', 3, 1488349708, 1, NULL, NULL),
(14, 1, 2, 25, 45, 645, 64, 56, NULL, 'etert4', NULL, 'Active', 3, 1488349708, 1, NULL, NULL),
(15, 1, 3, 5, 645, 645, 645, 654, NULL, 'erter', NULL, 'Active', 3, 1488349708, 1, NULL, NULL),
(16, 1, 1, 456, 45, 645, 645, 64, NULL, 'etrter', NULL, 'Active', 2, 1488349719, 1, NULL, NULL),
(17, 1, 2, 40, 45, 645, 64, 56, NULL, 'etert4', NULL, 'Active', 2, 1488349719, 1, NULL, NULL),
(18, 1, 3, 5, 645, 645, 645, 654, NULL, 'erter', NULL, 'Active', 2, 1488349719, 1, NULL, NULL),
(19, 1, 1, 456, 45, 645, 645, 64, NULL, 'etrter', 'ok', 'Active', 1, 1488349727, 1, 1488352466, 1),
(20, 1, 2, 40, 45, 645, 64, 56, NULL, 'etert4', 'okk', 'Active', 1, 1488349727, 1, 1488352466, 1),
(21, 1, 3, 5, 645, 645, 645, 654, NULL, 'erter', 'okkk', 'Active', 1, 1488349727, 1, 1488352466, 1),
(22, 3, 1, 0, 0, 0, 0, 0, NULL, '', '', 'Active', 1, 1488350112, 1, 1488353071, 1),
(23, 3, 2, 0, 0, 0, 0, 0, NULL, '', '', 'Active', 1, 1488350112, 1, 1488353071, 1),
(24, 3, 3, 0, 0, 0, 0, 0, NULL, '', '', 'Active', 1, 1488350112, 1, 1488353071, 1),
(25, 4, 1, 345, 34, 53, 453, 4534, NULL, 'werwe', NULL, 'Active', 3, 1488352818, 1, NULL, NULL),
(26, 4, 2, 435, 34, 534, 534, 534, NULL, 'rwerwe', NULL, 'Active', 3, 1488352818, 1, NULL, NULL),
(27, 4, 3, 34, 534, 534, 5, 34534, NULL, 'werwer', NULL, 'Active', 3, 1488352818, 1, NULL, NULL),
(28, 4, 1, 345, 34, 53, 453, 4534, NULL, 'werwe', NULL, 'Active', 2, 1488352829, 1, NULL, NULL),
(29, 4, 2, 20, 34, 534, 534, 534, NULL, 'rwerwe', NULL, 'Active', 2, 1488352829, 1, NULL, NULL),
(30, 4, 3, 34, 534, 534, 5, 34534, NULL, 'werwer', NULL, 'Active', 2, 1488352829, 1, NULL, NULL),
(31, 4, 1, 345, 34, 53, 453, 4534, NULL, 'werwe', 'test', 'Active', 1, 1488352839, 1, 1488352878, 1),
(32, 4, 2, 20, 34, 534, 534, 534, NULL, 'rwerwe', 'test1', 'Active', 1, 1488352839, 1, 1488352878, 1),
(33, 4, 3, 34, 534, 534, 5, 34534, NULL, 'werwer', 'test2', 'Active', 1, 1488352839, 1, 1488352878, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_mm_agenda_hom_sales`
--

CREATE TABLE IF NOT EXISTS `ems_mm_agenda_hom_sales` (
  `id` int(11) NOT NULL,
  `id_agenda` int(11) NOT NULL,
  `id_division` int(11) NOT NULL,
  `budget_total` int(11) DEFAULT NULL,
  `achievement_total` float DEFAULT NULL,
  `target_current_month` int(11) DEFAULT NULL,
  `achievement_current_month` float DEFAULT NULL,
  `target_next_month` int(11) DEFAULT NULL,
  `target_next_month_im` int(11) DEFAULT NULL,
  `remarks_before_meeting` varchar(255) DEFAULT NULL,
  `remarks_in_meeting` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'Active',
  `revision` int(11) NOT NULL DEFAULT '1',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_mm_agenda_hom_sales`
--

INSERT INTO `ems_mm_agenda_hom_sales` (`id`, `id_agenda`, `id_division`, `budget_total`, `achievement_total`, `target_current_month`, `achievement_current_month`, `target_next_month`, `target_next_month_im`, `remarks_before_meeting`, `remarks_in_meeting`, `status`, `revision`, `date_created`, `user_created`, `date_updated`, `user_updated`) VALUES
(1, 2, 1, 34, 534, 534, 534, 3453, NULL, 'terter', NULL, 'Active', 3, 1488348068, 1, NULL, NULL),
(2, 2, 2, 345, 345, 34, 534, 534, NULL, 'ertert', NULL, 'Active', 3, 1488348068, 1, NULL, NULL),
(3, 2, 3, 345, 34, 5345, 345, 34, NULL, 'erter', NULL, 'Active', 3, 1488348068, 1, NULL, NULL),
(4, 2, 1, 10, 534, 534, 534, 3453, NULL, 'terter', NULL, 'Active', 2, 1488348081, 1, NULL, NULL),
(5, 2, 2, 345, 345, 34, 534, 534, NULL, 'ertert', NULL, 'Active', 2, 1488348081, 1, NULL, NULL),
(6, 2, 3, 345, 34, 5345, 345, 34, NULL, 'erter', NULL, 'Active', 2, 1488348081, 1, NULL, NULL),
(7, 2, 1, 10, 534, 534, 534, 3453, NULL, 'terter', 'test1', 'Active', 1, 1488348106, 1, 1488351640, 1),
(8, 2, 2, 345, 345, 34, 534, 534, NULL, 'ertert', 'testt2', 'Active', 1, 1488348106, 1, 1488351640, 1),
(9, 2, 3, 345, 34, 5345, 345, 34, NULL, 'erter', 'testtt3', 'Active', 1, 1488348106, 1, 1488351640, 1),
(10, 1, 1, 54654, 54654, 54, 645, 645, NULL, 'erter', NULL, 'Active', 4, 1488349671, 1, NULL, NULL),
(11, 1, 2, 6, 654, 645645, 45645, 645654, NULL, 'eerter', NULL, 'Active', 4, 1488349671, 1, NULL, NULL),
(12, 1, 3, 5464, 54654, 5, 654, 645, NULL, 'ter', NULL, 'Active', 4, 1488349671, 1, NULL, NULL),
(13, 1, 1, 54654, 54654, 54, 645, 645, NULL, 'erter', NULL, 'Active', 3, 1488349708, 1, NULL, NULL),
(14, 1, 2, 15, 654, 645645, 45645, 645654, NULL, 'eerter', NULL, 'Active', 3, 1488349708, 1, NULL, NULL),
(15, 1, 3, 5464, 54654, 5, 654, 645, NULL, 'ter', NULL, 'Active', 3, 1488349708, 1, NULL, NULL),
(16, 1, 1, 54654, 54654, 54, 645, 645, NULL, 'erter', NULL, 'Active', 2, 1488349719, 1, NULL, NULL),
(17, 1, 2, 30, 654, 645645, 45645, 645654, NULL, 'eerter', NULL, 'Active', 2, 1488349719, 1, NULL, NULL),
(18, 1, 3, 5464, 54654, 5, 654, 645, NULL, 'ter', NULL, 'Active', 2, 1488349719, 1, NULL, NULL),
(19, 1, 1, 54654, 54654, 54, 645, 645, NULL, 'erter', 't', 'Active', 1, 1488349727, 1, 1488352466, 1),
(20, 1, 2, 30, 654, 645645, 45645, 645654, NULL, 'eerter', 'tt', 'Active', 1, 1488349727, 1, 1488352466, 1),
(21, 1, 3, 5464, 54654, 5, 654, 645, NULL, 'ter', 'ttt', 'Active', 1, 1488349727, 1, 1488352466, 1),
(22, 3, 1, 0, 0, 0, 0, 0, NULL, '', '', 'Active', 1, 1488350112, 1, 1488353071, 1),
(23, 3, 2, 0, 0, 0, 0, 0, NULL, '', '', 'Active', 1, 1488350112, 1, 1488353071, 1),
(24, 3, 3, 0, 0, 0, 0, 0, NULL, '', '', 'Active', 1, 1488350112, 1, 1488353071, 1),
(25, 4, 1, 34534, 345, 34, 534, 534, NULL, 'rwerwe', NULL, 'Active', 3, 1488352818, 1, NULL, NULL),
(26, 4, 2, 345, 345, 34, 534, 534, NULL, 'werwerwe', NULL, 'Active', 3, 1488352818, 1, NULL, NULL),
(27, 4, 3, 34, 534, 534, 534, 5, NULL, 'werwe', NULL, 'Active', 3, 1488352818, 1, NULL, NULL),
(28, 4, 1, 10, 345, 34, 534, 534, NULL, 'rwerwe', NULL, 'Active', 2, 1488352829, 1, NULL, NULL),
(29, 4, 2, 345, 345, 34, 534, 534, NULL, 'werwerwe', NULL, 'Active', 2, 1488352829, 1, NULL, NULL),
(30, 4, 3, 34, 534, 534, 534, 5, NULL, 'werwe', NULL, 'Active', 2, 1488352829, 1, NULL, NULL),
(31, 4, 1, 10, 345, 34, 534, 534, NULL, 'rwerwe', 'ok', 'Active', 1, 1488352839, 1, 1488352878, 1),
(32, 4, 2, 345, 345, 34, 534, 534, NULL, 'werwerwe', 'okk', 'Active', 1, 1488352839, 1, 1488352878, 1),
(33, 4, 3, 34, 534, 534, 534, 5, NULL, 'werwe', 'okkk', 'Active', 1, 1488352839, 1, 1488352878, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ems_mm_agenda_hom`
--
ALTER TABLE `ems_mm_agenda_hom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_mm_agenda_hom_collection`
--
ALTER TABLE `ems_mm_agenda_hom_collection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_mm_agenda_hom_sales`
--
ALTER TABLE `ems_mm_agenda_hom_sales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ems_mm_agenda_hom`
--
ALTER TABLE `ems_mm_agenda_hom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ems_mm_agenda_hom_collection`
--
ALTER TABLE `ems_mm_agenda_hom_collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `ems_mm_agenda_hom_sales`
--
ALTER TABLE `ems_mm_agenda_hom_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
