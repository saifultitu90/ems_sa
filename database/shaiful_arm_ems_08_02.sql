-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2017 at 03:22 AM
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
-- Table structure for table `ems_mm_agenda_sales_hom`
--

CREATE TABLE IF NOT EXISTS `ems_mm_agenda_sales_hom` (
  `id` int(11) NOT NULL,
  `date_hom_agenda` int(11) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'Active',
  `meeting_status` varchar(255) NOT NULL DEFAULT 'pending',
  `forwarded_to_di` varchar(255) NOT NULL DEFAULT 'pending',
  `forwarded_to_zi` varchar(255) NOT NULL DEFAULT 'pending',
  `forwarded_to_ti` varchar(255) NOT NULL DEFAULT 'pending',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `agenda_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `agenda_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ems_mm_di_collection_target_bm`
--

CREATE TABLE IF NOT EXISTS `ems_mm_di_collection_target_bm` (
  `id` int(11) NOT NULL,
  `agenda_id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `total_budget` int(11) NOT NULL,
  `last_target` int(11) NOT NULL,
  `last_achievement` float NOT NULL,
  `total_achievement` float NOT NULL,
  `next_month_target` int(11) NOT NULL,
  `next_month_target_im` int(11) DEFAULT NULL,
  `remarks_before_meeting` varchar(255) NOT NULL,
  `remarks_in_meeting` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) NOT NULL DEFAULT '0',
  `user_updated` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ems_mm_di_meeting_status`
--

CREATE TABLE IF NOT EXISTS `ems_mm_di_meeting_status` (
  `id` int(11) NOT NULL,
  `agenda_id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `meeting_status` varchar(255) NOT NULL,
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ems_mm_di_sales_target_bm`
--

CREATE TABLE IF NOT EXISTS `ems_mm_di_sales_target_bm` (
  `id` int(11) NOT NULL,
  `agenda_id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `total_budget` int(11) NOT NULL,
  `last_target` int(11) NOT NULL,
  `last_achievement` float NOT NULL,
  `total_achievement` float NOT NULL,
  `next_month_target` int(11) NOT NULL,
  `next_month_target_im` int(11) DEFAULT NULL,
  `remarks_before_meeting` varchar(255) NOT NULL,
  `remarks_in_meeting` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ems_mm_hom_collection_target_bm`
--

CREATE TABLE IF NOT EXISTS `ems_mm_hom_collection_target_bm` (
  `id` int(11) NOT NULL,
  `agenda_id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `total_budget` float DEFAULT NULL,
  `last_target` int(11) DEFAULT NULL,
  `last_achievement` int(11) DEFAULT NULL,
  `total_achievement` int(11) DEFAULT NULL,
  `next_month_target` int(11) DEFAULT NULL,
  `next_month_target_im` int(11) DEFAULT NULL,
  `remarks_before_meeting` varchar(255) NOT NULL,
  `remarks_in_meeting` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ems_mm_hom_sales_target_bm`
--

CREATE TABLE IF NOT EXISTS `ems_mm_hom_sales_target_bm` (
  `id` int(11) NOT NULL,
  `agenda_id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `total_budget` int(11) DEFAULT NULL,
  `last_target` int(11) DEFAULT NULL,
  `last_achievement` float DEFAULT NULL,
  `total_achievement` float DEFAULT NULL,
  `next_month_target` int(11) DEFAULT NULL,
  `next_month_target_im` int(11) DEFAULT NULL,
  `remarks_before_meeting` varchar(255) DEFAULT NULL,
  `remarks_in_meeting` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ems_mm_ti_collection_target_bm`
--

CREATE TABLE IF NOT EXISTS `ems_mm_ti_collection_target_bm` (
  `id` int(11) NOT NULL,
  `agenda_id` int(11) NOT NULL,
  `territory_id` int(11) NOT NULL,
  `total_budget` int(11) NOT NULL,
  `last_target` int(11) NOT NULL,
  `last_achievement` float NOT NULL,
  `total_achievement` float NOT NULL,
  `next_month_target` int(11) NOT NULL,
  `remarks_before_meeting` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ems_mm_ti_sales_target_bm`
--

CREATE TABLE IF NOT EXISTS `ems_mm_ti_sales_target_bm` (
  `id` int(11) NOT NULL,
  `agenda_id` int(11) NOT NULL,
  `territory_id` int(11) NOT NULL,
  `total_budget` int(11) NOT NULL,
  `last_target` int(11) NOT NULL,
  `last_achievement` float NOT NULL,
  `total_achievement` float NOT NULL,
  `next_month_target` int(11) NOT NULL,
  `remarks_before_meeting` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ems_mm_zi_collection_target_bm`
--

CREATE TABLE IF NOT EXISTS `ems_mm_zi_collection_target_bm` (
  `id` int(11) NOT NULL,
  `agenda_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `territory_id` int(11) NOT NULL,
  `total_budget` int(11) NOT NULL,
  `last_target` int(11) NOT NULL,
  `last_achievement` float NOT NULL,
  `total_achievement` float NOT NULL,
  `next_month_target` int(11) NOT NULL,
  `next_month_target_im` int(11) DEFAULT NULL,
  `remarks_before_meeting` varchar(255) NOT NULL,
  `remarks_in_meeting` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ems_mm_zi_meeting_status`
--

CREATE TABLE IF NOT EXISTS `ems_mm_zi_meeting_status` (
  `id` int(11) NOT NULL,
  `agenda_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `meeting_status` varchar(255) NOT NULL,
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ems_mm_zi_sales_target_bm`
--

CREATE TABLE IF NOT EXISTS `ems_mm_zi_sales_target_bm` (
  `id` int(11) NOT NULL,
  `agenda_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `territory_id` int(11) NOT NULL,
  `total_budget` int(11) NOT NULL,
  `last_target` int(11) NOT NULL,
  `last_achievement` float NOT NULL,
  `total_achievement` float NOT NULL,
  `next_month_target` int(11) NOT NULL,
  `next_month_target_im` int(11) DEFAULT NULL,
  `remarks_before_meeting` varchar(255) NOT NULL,
  `remarks_in_meeting` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ems_mm_agenda_sales_hom`
--
ALTER TABLE `ems_mm_agenda_sales_hom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_mm_di_collection_target_bm`
--
ALTER TABLE `ems_mm_di_collection_target_bm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_mm_di_meeting_status`
--
ALTER TABLE `ems_mm_di_meeting_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_mm_di_sales_target_bm`
--
ALTER TABLE `ems_mm_di_sales_target_bm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_mm_hom_collection_target_bm`
--
ALTER TABLE `ems_mm_hom_collection_target_bm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_mm_hom_sales_target_bm`
--
ALTER TABLE `ems_mm_hom_sales_target_bm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_mm_ti_collection_target_bm`
--
ALTER TABLE `ems_mm_ti_collection_target_bm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_mm_ti_sales_target_bm`
--
ALTER TABLE `ems_mm_ti_sales_target_bm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_mm_zi_collection_target_bm`
--
ALTER TABLE `ems_mm_zi_collection_target_bm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_mm_zi_meeting_status`
--
ALTER TABLE `ems_mm_zi_meeting_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_mm_zi_sales_target_bm`
--
ALTER TABLE `ems_mm_zi_sales_target_bm`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ems_mm_agenda_sales_hom`
--
ALTER TABLE `ems_mm_agenda_sales_hom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ems_mm_di_collection_target_bm`
--
ALTER TABLE `ems_mm_di_collection_target_bm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ems_mm_di_meeting_status`
--
ALTER TABLE `ems_mm_di_meeting_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ems_mm_di_sales_target_bm`
--
ALTER TABLE `ems_mm_di_sales_target_bm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ems_mm_hom_collection_target_bm`
--
ALTER TABLE `ems_mm_hom_collection_target_bm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ems_mm_hom_sales_target_bm`
--
ALTER TABLE `ems_mm_hom_sales_target_bm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ems_mm_ti_collection_target_bm`
--
ALTER TABLE `ems_mm_ti_collection_target_bm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ems_mm_ti_sales_target_bm`
--
ALTER TABLE `ems_mm_ti_sales_target_bm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ems_mm_zi_collection_target_bm`
--
ALTER TABLE `ems_mm_zi_collection_target_bm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ems_mm_zi_meeting_status`
--
ALTER TABLE `ems_mm_zi_meeting_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ems_mm_zi_sales_target_bm`
--
ALTER TABLE `ems_mm_zi_sales_target_bm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
