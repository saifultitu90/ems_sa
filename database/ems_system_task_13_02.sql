-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2017 at 05:24 AM
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
-- Table structure for table `ems_system_task`
--

CREATE TABLE IF NOT EXISTS `ems_system_task` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'TASK',
  `parent` int(11) NOT NULL DEFAULT '0',
  `controller` varchar(500) NOT NULL,
  `ordering` smallint(6) NOT NULL DEFAULT '9999',
  `icon` varchar(255) NOT NULL DEFAULT 'menu.png',
  `status` varchar(11) NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ems_system_task`
--

INSERT INTO `ems_system_task` (`id`, `name`, `type`, `parent`, `controller`, `ordering`, `icon`, `status`, `date_created`, `user_created`, `date_updated`, `user_updated`) VALUES
(1, 'System Settings', 'MODULE', 0, '', 1, 'menu.png', 'Active', 1455625924, 1, 1485059056, 1),
(2, 'Module & Task', 'TASK', 1, 'Sys_module_task', 1, 'menu.png', 'Active', 1455625924, 1, 1455625924, 1),
(3, 'User Role', 'TASK', 1, 'Sys_user_role', 2, 'menu.png', 'Active', 1455625924, 1, 1455625924, 1),
(4, 'User Group', 'TASK', 1, 'Sys_user_group', 3, 'menu.png', 'Active', 1455625924, 1, 1455625924, 1),
(5, 'Setup', 'MODULE', 0, '', 2, 'menu.png', 'Active', 1455625924, 1, 1455625924, 1),
(6, 'Assign User To Group', 'TASK', 1, 'Sys_assign_user_group', 4, 'menu.png', 'Active', 1455778051, 1, NULL, NULL),
(7, 'Location Setup', 'MODULE', 5, '', 1, 'menu.png', 'Active', 1456130791, 1, NULL, NULL),
(8, 'Division', 'TASK', 7, 'Setup_location_division', 1, 'menu.png', 'Active', 1456130890, 1, NULL, NULL),
(9, 'Zone', 'TASK', 7, 'Setup_location_zone', 2, 'menu.png', 'Active', 1456130917, 1, NULL, NULL),
(10, 'Territory', 'TASK', 7, 'Setup_location_territory', 3, 'menu.png', 'Active', 1456130946, 1, NULL, NULL),
(11, 'District', 'TASK', 7, 'Setup_location_district', 4, 'menu.png', 'Active', 1456130981, 1, NULL, NULL),
(12, 'Upazilla', 'TASK', 7, 'Setup_location_upazilla', 5, 'menu.png', 'Active', 1456131008, 1, NULL, NULL),
(13, 'Union', 'TASK', 7, 'Setup_location_union', 6, 'menu.png', 'Active', 1456131036, 1, NULL, NULL),
(14, 'Crop Classification', 'MODULE', 5, '', 2, 'menu.png', 'Active', 1456131408, 1, NULL, NULL),
(15, 'Basic Setup', 'MODULE', 5, '', 3, 'menu.png', 'Active', 1456131435, 1, NULL, NULL),
(16, 'Crop', 'TASK', 14, 'Setup_cclassification_crop', 1, 'menu.png', 'Active', 1456131504, 1, NULL, NULL),
(17, 'Type', 'TASK', 14, 'Setup_cclassification_type', 2, 'menu.png', 'Active', 1456131532, 1, NULL, NULL),
(18, 'Variety', 'TASK', 14, 'Setup_cclassification_variety', 3, 'menu.png', 'Active', 1456131560, 1, 1456131571, 1),
(19, 'Warehouse', 'TASK', 15, 'Setup_bsetup_warehouse', 1, 'menu.png', 'Active', 1456131625, 1, NULL, NULL),
(20, 'Banks', 'TASK', 15, 'Setup_bsetup_bank', 4, 'menu.png', 'Active', 1456131692, 1, 1456924843, 1),
(21, 'Fiscal Year', 'TASK', 15, 'Setup_bbasic_fyear', 2, 'menu.png', 'Active', 1456132019, 1, 1456924735, 1),
(22, 'Competitor', 'TASK', 15, 'Setup_bsetup_competitor', 3, 'menu.png', 'Active', 1456132135, 1, 1456924747, 1),
(23, 'Customer Setup', 'MODULE', 5, '', 4, 'menu.png', 'Active', 1456132296, 1, NULL, NULL),
(24, 'Customer', 'TASK', 23, 'Setup_csetup_customer', 1, 'menu.png', 'Active', 1456132336, 1, 1456727233, 1),
(25, 'Other Customer', 'TASK', 23, 'Setup_csetup_ocustomer', 2, 'menu.png', 'Active', 1456132368, 1, NULL, NULL),
(26, 'Variety Pack SIze', 'TASK', 14, 'Setup_cclassification_vpack_size', 4, 'menu.png', 'Active', 1456545397, 1, NULL, NULL),
(27, 'Variety Pricing', 'TASK', 14, 'Setup_cclassification_vpricing', 5, 'menu.png', 'Active', 1456545441, 1, NULL, NULL),
(28, 'ARM Banks', 'TASK', 15, 'Setup_bsetup_arm_banks', 5, 'menu.png', 'Active', 1456545490, 1, 1456924803, 1),
(29, 'Stock In', 'MODULE', 46, '', 1, 'menu.png', 'Active', 1456545534, 1, 1458026108, 1),
(30, 'Variety Stock in', 'TASK', 29, 'Stockin_variety', 1, 'menu.png', 'Active', 1456545568, 1, NULL, NULL),
(31, 'Sales Return', 'TASK', 37, 'Sales_po_return', 5, 'menu.png', 'Active', 1456545601, 1, 1458221086, 1),
(32, 'Excess Inventory', 'TASK', 29, 'Stockin_excess', 3, 'menu.png', 'Active', 1456545634, 1, 1456713679, 1),
(33, 'Arm Bank Accounts', 'TASK', 15, 'Setup_bsetup_arm_bank_accounts', 6, 'menu.png', 'Active', 1456924913, 1, 1479012478, 1),
(34, 'Assign User to Area', 'TASK', 1, 'Sys_assign_user_area', 5, 'menu.png', 'Active', 1456990473, 1, NULL, NULL),
(35, 'Payment', 'MODULE', 0, '', 4, 'menu.png', 'Active', 1457090340, 1, 1457090356, 1),
(36, 'Customer Payment', 'TASK', 35, 'Payment_customer', 1, 'menu.png', 'Active', 1457090379, 1, 1464109112, 1),
(37, 'Sales', 'MODULE', 0, '', 5, 'menu.png', 'Active', 1457090430, 1, NULL, NULL),
(38, 'PO', 'TASK', 37, 'Sales_po', 1, 'menu.png', 'Active', 1457090478, 1, NULL, NULL),
(39, 'PO Approve', 'TASK', 37, 'Sales_po_approve', 2, 'menu.png', 'Active', 1457090541, 1, NULL, NULL),
(40, 'PO Delivery', 'TASK', 37, 'Sales_po_delivery', 3, 'menu.png', 'Active', 1457090589, 1, NULL, NULL),
(41, 'Bonus Rule', 'TASK', 14, 'Setup_cclassification_bounsrule', 6, 'menu.png', 'Active', 1457422347, 1, NULL, NULL),
(42, 'Reports', 'MODULE', 0, '', 6, 'menu.png', 'Active', 1457972897, 1, 1458026454, 1),
(43, 'Stock Out', 'TASK', 46, 'Stockout', 2, 'menu.png', 'Active', 1457972949, 1, 1458026202, 1),
(44, 'PO Receive', 'TASK', 37, 'Sales_po_receive', 4, 'menu.png', 'Active', 1457973120, 1, 1458026315, 1),
(45, 'Stock Report', 'TASK', 42, 'Reports_stock', 2, 'menu.png', 'Active', 1457983030, 1, 1459662685, 1),
(46, 'Stock', 'MODULE', 0, '', 3, 'menu.png', 'Active', 1458026078, 1, NULL, NULL),
(47, 'Couriers', 'TASK', 15, 'Setup_bsetup_couriers', 7, 'menu.png', 'Active', 1458221290, 1, NULL, NULL),
(48, 'Customer List Report', 'TASK', 42, 'Reports_customer_list', 3, 'menu.png', 'Active', 1458503531, 1, 1459662695, 1),
(49, 'Sales Report', 'TASK', 42, 'Reports_sales', 1, 'menu.png', 'Active', 1458644821, 1, 1459662677, 1),
(50, 'Variety Color', 'TASK', 15, 'Setup_bsetup_vcolors', 8, 'menu.png', 'Active', 1458730921, 1, NULL, NULL),
(51, 'Assign Product to season', 'TASK', 5, 'Setup_cclassification_ctype_time', 7, 'menu.png', 'Active', 1459170445, 1, 1462433723, 1),
(52, 'Season wise Variety Report', 'TASK', 42, 'Reports_ctype_time', 4, 'menu.png', 'Active', 1459170542, 1, 1459170562, 1),
(53, 'Market Survey', 'MODULE', 0, '', 7, 'menu.png', 'Active', 1459703389, 1, NULL, NULL),
(54, 'Primary Market Survey', 'TASK', 53, 'Survey_primary_market', 1, 'menu.png', 'Active', 1459703524, 1, NULL, NULL),
(55, 'ZI Primary Market Survey', 'TASK', 53, 'Survey_primary_market_zi', 2, 'menu.png', 'Active', 1459703656, 1, NULL, NULL),
(56, 'ARM Variety Info', 'TASK', 53, 'Survey_product_arm', 3, 'menu.png', 'Active', 1459703696, 1, 1459921388, 1),
(57, 'Competitor Variety Info', 'TASK', 53, 'Survey_product_competitor', 4, 'menu.png', 'Active', 1459703755, 1, 1459921402, 1),
(58, 'Primary Market Survey Report', 'TASK', 42, 'Reports_primary_market_survey', 5, 'menu.png', 'Active', 1459703872, 1, 1459703924, 1),
(59, 'Market Survey Report', 'TASK', 42, 'Reports_market_survey', 6, 'menu.png', 'Active', 1459703911, 1, 1459703935, 1),
(60, 'Task Management', 'MODULE', 0, '', 8, 'menu.png', 'Active', 1459967331, 1, NULL, NULL),
(61, 'Farmer and Field Visit Setup', 'TASK', 60, 'Tm_farmer_visit_setup', 1, 'menu.png', 'Active', 1459967524, 1, NULL, NULL),
(62, 'Field Visit', 'TASK', 60, 'Tm_field_visit', 2, 'menu.png', 'Active', 1459967607, 1, NULL, NULL),
(63, 'Field Visit Feedback', 'TASK', 60, 'Tm_field_visit_feedback', 3, 'menu.png', 'Active', 1459967641, 1, NULL, NULL),
(64, 'Popular Variety', 'TASK', 60, 'Tm_popular_variety', 4, 'menu.png', 'Active', 1460064777, 1, 1460064798, 1),
(65, 'Popular Variety Report', 'TASK', 42, 'Reports_popular_variety', 7, 'menu.png', 'Active', 1460150432, 1, NULL, NULL),
(66, 'Task Management Setup', 'MODULE', 5, '', 5, 'menu.png', 'Active', 1460361412, 1, 1472011771, 2),
(67, 'Season Setup', 'TASK', 66, 'Setup_tm_season', 1, 'menu.png', 'Active', 1460361482, 1, NULL, NULL),
(68, 'Fruit Picture Setup', 'TASK', 66, 'Setup_tm_fruit_picture', 3, 'menu.png', 'Active', 1460361542, 1, 1460885549, 1),
(69, 'Field Visit Report', 'TASK', 42, 'Reports_field_visit', 8, 'menu.png', 'Active', 1460794343, 1, NULL, NULL),
(70, 'TI Market Visit Setup', 'TASK', 66, 'Setup_tm_ti_market_visit', 4, 'menu.png', 'Active', 1460795285, 1, 1460885565, 1),
(71, 'ZI Market Visit Setup', 'TASK', 66, 'Setup_tm_zi_market_visit', 5, 'menu.png', 'Active', 1460795329, 1, 1460885585, 1),
(72, 'TI Market Visit', 'TASK', 60, 'Tm_ti_market_visit', 5, 'menu.png', 'Active', 1460795497, 1, 1460795553, 1),
(73, 'ZI Market Visit', 'TASK', 60, 'Tm_zi_market_visit', 6, 'menu.png', 'Active', 1460795534, 1, 1460795573, 1),
(74, 'TI Market Visit Report', 'TASK', 42, 'Reports_ti_market_visit', 9, 'menu.png', 'Active', 1460795813, 1, NULL, NULL),
(75, 'ZI Market Visit Report', 'TASK', 42, 'Reports_zi_market_visit', 10, 'menu.png', 'Active', 1460795861, 1, 1472868127, 2),
(76, 'Visit Shift Setup', 'TASK', 66, 'Setup_tm_shift', 2, 'menu.png', 'Active', 1460885663, 1, NULL, NULL),
(77, 'TI Market Visit Solution', 'TASK', 60, 'Tm_ti_market_visit_solution', 7, 'menu.png', 'Active', 1461090592, 1, NULL, NULL),
(78, 'ZI Market Visit Solution', 'TASK', 60, 'Tm_zi_market_visit_solution', 8, 'menu.png', 'Active', 1461090626, 1, NULL, NULL),
(79, 'DI Market Visit Setup', 'TASK', 5, 'Setup_tm_di_market_visit', 7, 'menu.png', 'Active', 1462773256, 1, NULL, NULL),
(80, 'Trainer Market Visit Setup', 'TASK', 5, 'Setup_tm_trainer_market_visit', 8, 'menu.png', 'Active', 1462773284, 1, 1462773305, 1),
(81, 'DI Market Visit', 'TASK', 60, 'Tm_di_market_visit', 9, 'menu.png', 'Active', 1462773430, 1, 1462773533, 1),
(82, 'Trainer Market Visit', 'TASK', 60, 'Tm_trainer_market_visit', 10, 'menu.png', 'Active', 1462773503, 1, NULL, NULL),
(83, 'DI Market Visit Solution', 'TASK', 60, 'Tm_di_market_visit_solution', 11, 'menu.png', 'Active', 1462773594, 1, NULL, NULL),
(84, 'Trainer Market Visit Feedback', 'TASK', 60, 'Tm_trainer_market_visit_solution', 12, 'menu.png', 'Active', 1462773627, 1, NULL, NULL),
(85, 'DI Market Visit Report', 'TASK', 42, 'Reports_di_market_visit', 11, 'menu.png', 'Active', 1463119099, 1, 1463207819, 1),
(86, 'Trainer Market Visit Report', 'TASK', 42, 'Reports_trainer_market_visit', 12, 'menu.png', 'Active', 1463119125, 1, NULL, NULL),
(87, 'Party Balance Report', 'TASK', 42, 'Reports_party_balance', 13, 'menu.png', 'Active', 1463119283, 1, 1463119301, 1),
(88, 'Site Offline', 'TASK', 1, 'Sys_site_offline', 6, 'menu.png', 'Active', 1463812301, 1, NULL, NULL),
(89, 'Balance Adjust', 'TASK', 23, 'Setup_csetup_balance_adjust', 3, 'menu.png', 'Active', 1464109078, 1, NULL, NULL),
(90, 'Payment Receive', 'TASK', 35, 'Payment_receive', 2, 'menu.png', 'Active', 1464109572, 1, NULL, NULL),
(91, 'Principals', 'TASK', 15, 'Setup_bsetup_principal', 3, 'menu.png', 'Active', 1465882874, 1, 1465883932, 1),
(92, 'Payment Report', 'TASK', 42, 'Reports_payment', 14, 'menu.png', 'Active', 1467184553, 1, NULL, NULL),
(93, 'PO Delivery Report', 'TASK', 42, 'Reports_po_delivery', 15, 'menu.png', 'Active', 1467184590, 1, NULL, NULL),
(94, 'ARM & Competitor variety Report', 'TASK', 42, 'Reports_arm_competitor_variety', 16, 'menu.png', 'Active', 1467248320, 1, NULL, NULL),
(95, 'Reset Approved PO', 'TASK', 1, 'Sys_reset_approved_po', 7, 'menu.png', 'Active', 1467477668, 1, NULL, NULL),
(96, 'ARM Product Characteristics Report', 'TASK', 42, 'Reports_arm_variety', 17, 'menu.png', 'Active', 1468217253, 1, NULL, NULL),
(97, 'R&D Demo Variety setup', 'TASK', 60, 'Tm_rnd_demo_setup', 13, 'menu.png', 'Active', 1470671429, 1, NULL, NULL),
(98, 'R&D Demo Picture', 'TASK', 60, 'Tm_rnd_demo_picture', 14, 'menu.png', 'Active', 1470671449, 1, NULL, NULL),
(99, 'Variety Pricing (kg)', 'TASK', 14, 'Setup_cclassification_vpricing_kg', 7, 'menu.png', 'Active', 1471767589, 1, NULL, NULL),
(100, 'R&D Demo Report', 'TASK', 42, 'Reports_rnd_demo_picture', 18, 'menu.png', 'Active', 1474793447, 1, NULL, NULL),
(101, 'ICT Monitoring (TI)', 'TASK', 60, 'Tm_ict_monitoring_ti', 15, 'menu.png', 'Active', 1475492383, 1, NULL, NULL),
(102, 'ICT Monitoring (ZI)', 'TASK', 60, 'Tm_ict_monitoring_zi', 16, 'menu.png', 'Active', 1475492408, 1, NULL, NULL),
(103, 'ICT Monitoring Report (TI)', 'TASK', 42, 'Reports_ict_monitoring_ti', 19, 'menu.png', 'Active', 1475492464, 1, NULL, NULL),
(104, 'ICT Monitoring (ZI)', 'TASK', 42, 'Reports_ict_monitoring_zi', 20, 'menu.png', 'Active', 1475492491, 1, NULL, NULL),
(105, 'Payment Ways', 'TASK', 15, 'Setup_bsetup_payment_ways', 5, 'menu.png', 'Active', 1476552610, 1, 1479023536, 1),
(106, 'FMS', 'MODULE', 0, '', 500, 'menu.png', 'Active', 1479702428, 1, NULL, NULL),
(107, 'fms', 'TASK', 106, 'Fms_file_upload', 501, 'menu.png', 'Active', 1479702556, 1, NULL, NULL),
(108, 'File Category', 'TASK', 106, 'Fms_file_category', 333, 'menu.png', 'Active', 1479872580, 1, NULL, NULL),
(109, 'Multiple FMS', 'TASK', 106, 'Fms_multiple', 3, 'menu.png', 'Active', 1480315736, 1, 1480315855, 1),
(113, 'Meeting Minutes', 'MODULE', 0, '', 15, 'menu.png', 'Active', 1482390970, 1, 1482392728, 1),
(114, 'Before Meeting', 'MODULE', 113, '', 1, 'menu.png', 'Active', 1485135051, 1, 1486023038, 1),
(115, 'With DI', 'TASK', 114, 'Mm_hom_agenda', 1, 'menu.png', 'Active', 1485135142, 1, 1486023696, 1),
(116, 'With HOM', 'TASK', 114, 'Mm_di_agenda', 2, 'menu.png', 'Active', 1485233753, 1, 1486023632, 1),
(117, 'In Meeting', 'MODULE', 113, '', 2, 'menu.png', 'Active', 1485397649, 1, 1486023066, 1),
(118, 'With DI', 'TASK', 117, 'Mm_hom_agenda_im', 1, 'menu.png', 'Active', 1485397725, 1, 1486023767, 1),
(119, 'test hom agenda sales bm', 'TASK', 114, 'testMm_agenda_sales_hom_sales_bm', 99, 'menu.png', 'Active', 1485916394, 1, 1485917177, 1),
(120, 'DI To ZI', 'TASK', 114, 'Mm_di_agenda_for_zi', 3, 'menu.png', 'Active', 1486173310, 1, 1486257773, 1),
(121, 'With ZI', 'TASK', 117, 'Mm_di_agenda_for_zi_im', 2, 'menu.png', 'Active', 1486176506, 1, 1486176708, 1),
(122, 'With ZI', 'TASK', 114, 'Mm_zi_agenda_bm', 1, 'menu.png', 'Active', 1486191044, 1, NULL, NULL),
(123, 'ZI To DI', 'TASK', 114, 'Mm_zi_agenda_for_ti', 1, 'menu.png', 'Active', 1486270422, 1, NULL, NULL),
(124, 'ZI To TI', 'TASK', 114, 'Mm_zi_agenda_for_ti_bm', 2, 'menu.png', 'Active', 1486358137, 1, NULL, NULL),
(125, 'ZI To TI', 'TASK', 117, 'Mm_zi_agenda_for_ti_im', 1, 'menu.png', 'Active', 1486359594, 1, NULL, NULL),
(126, 'TI To ZI', 'TASK', 114, 'Mm_ti_agenda', 1, 'menu.png', 'Active', 1486433247, 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ems_system_task`
--
ALTER TABLE `ems_system_task`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ems_system_task`
--
ALTER TABLE `ems_system_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=127;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
