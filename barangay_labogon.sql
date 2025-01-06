-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 08:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barangay_labogon`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `appointment_with` enum('Barangay Chairman','SK Chairman') NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` enum('pending','approved','declined','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `full_name`, `address`, `contact_number`, `appointment_with`, `date`, `time`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 'jarred', 'zone1', '09050673250', 'Barangay Chairman', '2025-01-22', '13:23:00', 'approved', '2025-01-05 05:19:30', '2025-01-05 10:51:49'),
(2, 0, 'Jarred Saludaga', 'Punta Engano', '09050673250', 'Barangay Chairman', '2025-01-29', '18:56:00', 'approved', '2025-01-05 10:53:44', '2025-01-05 11:05:07'),
(3, 0, 'Jarred Saludaga', 'Punta Engano', '09050673250', 'SK Chairman', '2025-01-24', '19:09:00', 'approved', '2025-01-05 11:04:16', '2025-01-05 11:04:33'),
(4, 0, 'Jarred Saludaga', 'Punta Engano', '09050673250', 'SK Chairman', '2025-01-21', '19:18:00', 'approved', '2025-01-05 11:13:36', '2025-01-05 11:13:49'),
(5, 0, 'Jarred Saludaga', 'Punta Engano', '09050673250', 'SK Chairman', '2025-01-15', '08:26:00', 'approved', '2025-01-05 11:27:04', '2025-01-05 11:27:13'),
(6, 4, 'Jarred Saludaga', 'Punta Engano', '09050673250', 'SK Chairman', '2025-01-23', '11:39:00', 'approved', '2025-01-05 11:37:58', '2025-01-05 11:38:14'),
(7, 7, 'Jenn Cutie', 'Punta Engano', '09050673250', 'SK Chairman', '2025-01-18', '09:41:00', 'approved', '2025-01-05 11:39:23', '2025-01-05 11:39:37'),
(8, 18, 'Jarred Saludaga', 'Punta Engano', '09050673250', 'SK Chairman', '2025-01-15', '09:45:00', 'approved', '2025-01-05 11:43:16', '2025-01-05 11:43:42'),
(9, 4, 'Jarred Saludaga', 'Punta Engano', '09050673250', 'Barangay Chairman', '2025-01-29', '23:49:00', 'approved', '2025-01-05 11:45:34', '2025-01-05 11:45:43'),
(10, 4, 'Jarred Saludaga', 'Punta Engano', '09050673250', 'Barangay Chairman', '2025-01-21', '22:54:00', 'declined', '2025-01-05 11:51:30', '2025-01-05 18:34:03'),
(11, 4, 'Jarred Saludaga', 'Punta Engano', '09050673250', 'Barangay Chairman', '2025-01-23', '22:57:00', 'approved', '2025-01-05 11:54:22', '2025-01-05 18:33:20'),
(12, 4, 'Jarred Saludaga', 'Punta Engano', '09050673250', 'Barangay Chairman', '2025-01-23', '22:57:00', 'pending', '2025-01-05 11:55:14', '2025-01-05 11:55:14'),
(13, 4, 'Jarred Saludaga', 'Punta Engano', '09050673250', 'Barangay Chairman', '2025-01-23', '10:58:00', 'approved', '2025-01-05 11:55:28', '2025-01-05 17:12:08'),
(14, 4, 'Jarred Saludaga', 'Punta Engano', '09050673250', 'Barangay Chairman', '2025-01-21', '11:17:00', 'approved', '2025-01-05 12:15:50', '2025-01-05 17:11:59');

-- --------------------------------------------------------

--
-- Table structure for table `buy_and_sell`
--

CREATE TABLE `buy_and_sell` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_category` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `seller_name` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','Sold') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buy_and_sell`
--

INSERT INTO `buy_and_sell` (`id`, `user_id`, `product_name`, `product_category`, `description`, `seller_name`, `contact_number`, `email`, `address`, `image_name`, `status`, `created_at`, `updated_at`) VALUES
(21, 4, 'plastic bottle big', 'Bottles', 'di nako ganahan ani', 'jarred', '09050673250', 'jarredsaludaga@gmail.com', 'Punta Engano', 'product_67798594ce88e4.68239150.jpg', 'Sold', '2025-01-04 19:01:40', '2025-01-04 19:23:50'),
(22, 7, 'bottle na dakoo kaayos tanan', 'Bottles', 'palita', 'jenn', '02323232', 'kleindmas@gmail.com', 'zone 1', 'product_677985d5199917.39851394.jpg', 'pending', '2025-01-04 19:02:45', '2025-01-04 19:02:45'),
(23, 4, 'Metals', 'Scrap Metals', 'jsdsds', 'Jarred', '09050673250', 'jarredsaludaga@gmail.com', 'Punta Engano', 'product_67798a996ea9a9.49183097.jpg', 'Sold', '2025-01-04 19:23:05', '2025-01-04 19:23:42'),
(24, 4, 'jarred', 'Appliances', 'sdsds', 'jarred', '09050673250', 'jarredsaludaga@gmail.com', 'Punta Engano', 'product_67798b18f0d427.43750111.jpg', 'Sold', '2025-01-04 19:25:12', '2025-01-04 19:25:41'),
(25, 4, 'jarred', 'Bottles', 'sdsds', 'jarred', '09050673250', 'jarredsaludaga@gmail.com', 'Punta Engano', 'product_67798b8ae90c09.81859224.jpg', 'Sold', '2025-01-04 19:27:06', '2025-01-04 19:27:21'),
(27, 4, 'bottlesss', 'Bottles', 'sdsds', 'jarred', '09050673250', 'jarredsaludaga@gmail.com', 'Punta Engano', 'product_677a1ae1004101.85462454.jpg', 'Sold', '2025-01-05 05:38:41', '2025-01-05 12:10:27');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT 'Anonymous',
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `username`, `comment`, `created_at`) VALUES
(9, 54, 4, 'Anonymous', 'I want to volunteeer for the sake of our brgy.', '2025-01-05 10:15:14'),
(10, 54, 7, 'Anonymous', 'I also want to participate', '2025-01-05 10:15:50'),
(11, 54, 4, 'jarred', 'i want to participate', '2025-01-05 12:13:11'),
(12, 54, 4, 'Anonymous', 'i want to participate', '2025-01-05 12:13:21');

-- --------------------------------------------------------

--
-- Table structure for table `documentation_appointments`
--

CREATE TABLE `documentation_appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `years_of_residency` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documentation_appointments`
--

INSERT INTO `documentation_appointments` (`id`, `user_id`, `name`, `address`, `contact_number`, `email`, `birthday`, `age`, `gender`, `years_of_residency`, `created_at`, `status`) VALUES
(1, 18, 'Jarred Saludaga', 'Punta Engano', '9050673250', 'jarredsaludaga@gmail.com', '2025-01-16', 22, '0', 22, '2025-01-05 16:59:53', 'approved'),
(2, 18, 'Jarred Saludaga', 'Punta Engano', '9050673250', 'jarredsaludaga@gmail.com', '2025-01-23', 22, '0', 22, '2025-01-05 17:02:04', 'approved'),
(3, 4, 'Jarred Saludaga', 'Punta Engano', '9050673250', 'jarredsaludaga@gmail.com', '2025-01-16', 4, '0', 22, '2025-01-05 17:44:57', 'approved'),
(4, 4, 'Jarred Saludaga', 'Punta Engano', '0050673250', 'jarredsaludaga@gmail.com', '2024-12-31', 13, '0', 15, '2025-01-05 17:50:34', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `employees_schedule`
--

CREATE TABLE `employees_schedule` (
  `id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `assignment_area` varchar(255) NOT NULL,
  `task` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `progress` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `schedule_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_role`
--

CREATE TABLE `employee_role` (
  `id` int(11) NOT NULL,
  `employee_role` varchar(100) NOT NULL,
  `task_description` text NOT NULL,
  `schedule_date` varchar(100) DEFAULT NULL,
  `timetable` varchar(50) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_role`
--

INSERT INTO `employee_role` (`id`, `employee_role`, `task_description`, `schedule_date`, `timetable`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'Waste Collection Team', 'Collect waste from designated zones', 'Daily', '9:00 AM - 12:00 PM (Morning)', 'Ensuring proper waste segregation on-site.', '2024-12-29 17:02:35', '2024-12-29 17:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `date`, `description`, `image`) VALUES
(38, 'Waste Management Event', '2025-01-16', 'Clean the area', 'Uploads/ewaste-aspect-ratio-2000-1200-1024x614.jpg'),
(39, 'Clean and Green', '2025-01-21', 'Clean and greenery', 'Uploads/29913-recycle-sstock-2103583127.jpg'),
(50, 'event for green', '2025-01-23', 'sdasdas', 'Uploads/29913-recycle-sstock-2103583127.jpg'),
(58, 'Clean and Green', '2025-01-15', 'clean and green ', 'Uploads/ewaste-aspect-ratio-2000-1200-1024x614.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `garbage_collection`
--

CREATE TABLE `garbage_collection` (
  `id` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `schedule_time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` enum('done','to pick up') NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `garbage_collection`
--

INSERT INTO `garbage_collection` (`id`, `schedule_date`, `schedule_time`, `location`, `status`, `user_id`) VALUES
(4, '2025-01-15', '02:21:00', 'zone 1', 'done', 4),
(5, '2025-01-22', '02:22:00', 'zone 12', 'done', 4),
(6, '2025-01-22', '02:25:00', 'zone 1', 'done', 4),
(7, '2025-01-16', '02:28:00', 'zone 1', 'done', 4),
(8, '2025-01-15', '16:26:00', 'zone 1', 'done', 4),
(9, '2025-01-17', '16:30:00', 'zone1', 'done', 4),
(10, '2025-01-10', '02:33:00', 'Labogon dapit', 'done', 4),
(11, '2025-01-16', '04:34:00', 'zone 1', 'done', 4),
(12, '2025-01-06', '17:36:00', 'zone 1', 'done', 4),
(13, '2025-01-15', '05:38:00', 'zone 1', 'done', 4),
(14, '2025-01-08', '05:41:00', 'Zone 1', 'to pick up', 4),
(15, '2025-01-16', '02:38:00', 'hello', 'to pick up', 4);

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `severity` varchar(50) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`id`, `title`, `description`, `type`, `severity`, `latitude`, `longitude`, `address`, `image_path`, `image_name`, `status`, `created_at`) VALUES
(1, 'dwacwa', 'dwacdaw', 'Illegal Waste Dumping', 'Medium', 14.583354343191623, 120.99336810508413, 'Unknown Location', 'images/6764c64e639b7-desktop-support-engineer.jpg', '6764c64e639b7-desktop-support-engineer.jpg', 'Responded', '2024-12-20 01:20:14'),
(2, 'Na banga', 'Nabanga ng pusa ', 'Other', 'High', 14.633126909785632, 121.00535667668115, 'Unknown Location', 'images/6764c7b7083fb-prompt.png', '6764c7b7083fb-prompt.png', 'Responded', '2024-12-20 01:26:15'),
(3, 'Testt ko to ', 'Test ko to ', 'Fire', 'Medium', 14.62563013246867, 120.99112339410807, 'Unknown Location', 'images/6764cc0456407-desktop-support-engineer.jpg', '6764cc0456407-desktop-support-engineer.jpg', 'Responded', '2024-12-20 01:44:36'),
(4, 'testulit', 'testulet ', 'Fire', 'Medium', 14.569802916373773, 120.9862748934295, 'Unknown Location', 'images/6764cc58998a6-mainpage.png', '6764cc58998a6-mainpage.png', 'Responded', '2024-12-20 01:46:00'),
(5, 'dwada', 'dwadaw', 'Illegal Waste Dumping', 'High', -34.39098041942627, 150.5959383745019, 'Unknown Location', 'images/6765c5ed3908a-desktop-support-engineer.jpg', '6765c5ed3908a-desktop-support-engineer.jpg', 'Responded', '2024-12-20 19:30:53'),
(6, 'dwa', 'dawda', 'Flood', 'Low', -34.331474543551494, 150.7359948506423, 'Unknown Location', 'images/6765c6baebda5-desktop-support-engineer.jpg', '6765c6baebda5-desktop-support-engineer.jpg', 'Responded', '2024-12-20 19:34:18'),
(7, 'dwa', 'dawda', 'Flood', 'Low', -34.331474543551494, 150.7359948506423, 'Unknown Location', 'images/6765c6c048abb-desktop-support-engineer.jpg', '6765c6c048abb-desktop-support-engineer.jpg', 'Responded', '2024-12-20 19:34:24'),
(8, 'dwa', 'dawda', 'Flood', 'Low', -34.26340407418496, 150.59454587603292, 'Unknown Location', 'images/6765c72ad63ae-desktop-support-engineer.jpg', '6765c72ad63ae-desktop-support-engineer.jpg', 'Responded', '2024-12-20 19:36:10'),
(9, 'dwa', 'dawda', 'Flood', 'Low', 0, 0, 'Unknown Location', 'images/6765c73916907-desktop-support-engineer.jpg', '6765c73916907-desktop-support-engineer.jpg', 'Responded', '2024-12-20 19:36:25'),
(10, 'dwa', 'dawda', 'Flood', 'Low', 0, 0, 'Unknown Location', 'images/6765c75cdb6fd-desktop-support-engineer.jpg', '6765c75cdb6fd-desktop-support-engineer.jpg', 'Responded', '2024-12-20 19:37:00'),
(11, 'dwadwa', 'dwacd', 'Fire', 'High', 0, 0, 'Unknown Location', 'images/6765c76bda12c-desktop-support-engineer.jpg', '6765c76bda12c-desktop-support-engineer.jpg', 'Responded', '2024-12-20 19:37:15'),
(12, 'dwadwa', 'dwacd', 'Fire', 'High', 0, 0, 'Unknown Location', 'images/6765c7a0edf89-desktop-support-engineer.jpg', '6765c7a0edf89-desktop-support-engineer.jpg', 'Responded', '2024-12-20 19:38:08'),
(13, 'dwacdwacd', 'awcda', 'Illegal Waste Dumping', 'Medium', 0, 0, 'Unknown Location', 'images/6765c80e15740-desktop-support-engineer.jpg', '6765c80e15740-desktop-support-engineer.jpg', 'Responded', '2024-12-20 19:39:58'),
(14, 'dwadwada', 'dwadw', 'Illegal Waste Dumping', 'Medium', 14.60441791148512, 120.97896457949605, 'Unknown Location', 'images/6765c8915b05e-desktop-support-engineer.jpg', '6765c8915b05e-desktop-support-engineer.jpg', 'Responded', '2024-12-20 19:42:09'),
(15, 'dwadaw', 'dwada', 'Flood', 'Low', 0, 0, 'Unknown Location', 'images/67662d8037ef8-desktop-support-engineer.jpg', '67662d8037ef8-desktop-support-engineer.jpg', 'Responded', '2024-12-21 02:52:48'),
(16, 'dwadwa', 'wdadwadaw', 'Illegal Waste Dumping', 'Medium', 14.604644058078646, 120.98325586242677, 'Unknown Location', 'images/676642b4ad0de-desktop-support-engineer.jpg', '676642b4ad0de-desktop-support-engineer.jpg', 'Responded', '2024-12-21 04:23:16'),
(17, 'dwadaw', 'dwadawda', 'Flood', 'Low', 10.276948424948456, 123.94474786427506, 'Unknown Location', 'images/676644a3cebab-mainpage.png', '676644a3cebab-mainpage.png', 'Responded', '2024-12-21 04:31:31'),
(18, 'dwadaw', 'dwadawda', 'Flood', 'Low', 10.276948424948456, 123.94474786427506, 'Unknown Location', 'images/676644a7bcff0-mainpage.png', '676644a7bcff0-mainpage.png', 'Responded', '2024-12-21 04:31:35'),
(19, 'dwadaw', 'dwadawda', 'Flood', 'Low', 10.276948424948456, 123.94474786427506, 'Unknown Location', 'images/676644bc649c5-mainpage.png', '676644bc649c5-mainpage.png', 'Responded', '2024-12-21 04:31:56'),
(20, 'dwadaw', 'dwadawda', 'Flood', 'Low', 10.276948424948456, 123.94474786427506, 'Unknown Location', 'images/676644eb7074f-mainpage.png', '676644eb7074f-mainpage.png', 'Responded', '2024-12-21 04:32:43'),
(21, 'dwavdfav', 'garegrdjigjk', 'Flood', 'Low', 10.277270404507032, 123.94463521149643, 'Unknown Location', 'images/67664dc80f994-desktop-support-engineer.jpg', '67664dc80f994-desktop-support-engineer.jpg', 'Pending', '2024-12-21 05:10:32'),
(22, 'Emergengy Flood', 'Flood due to heavy rain', 'Flood', 'Medium', 10.27744920007699, 123.94462376832962, 'Unknown Location', 'images/67714df440a67-nopremiumplan.png', '67714df440a67-nopremiumplan.png', 'Pending', '2024-12-29 13:26:12'),
(23, 'Flood 22 ', 'Flood due to heavy rain ', 'Flood', 'Medium', 10.277309371251077, 123.9449658213628, 'Unknown Location', 'images/677158bd11a40-image 2-1.png', '677158bd11a40-image 2-1.png', 'Pending', '2024-12-29 14:12:13'),
(24, 'Nag ka bangaan ', 'Tanga kase ', 'Other', 'High', 10.277243600381093, 123.94475389924534, 'Unknown Location', 'images/6774e6dd7e0dc-labogonbanner.jpg', '6774e6dd7e0dc-labogonbanner.jpg', 'Pending', '2025-01-01 06:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `initiatives`
--

CREATE TABLE `initiatives` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `total_kilos` double NOT NULL,
  `success_rate` decimal(5,2) DEFAULT NULL,
  `impact_metrics` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `initiatives`
--

INSERT INTO `initiatives` (`id`, `name`, `location`, `description`, `total_kilos`, `success_rate`, `impact_metrics`, `created_at`) VALUES
(10, 'Daily Waste Generation', 'Zone 3', 'Estimated at 0.65 kg/person/day (Philippine urban average)', 20045, 0.65, '9', '2024-12-28 08:27:07'),
(11, 'Biodegradable Waste', 'Zone 1', '50% of total waste (average waste composition)', 10022, 50.00, '9', '2024-12-28 08:27:59'),
(12, 'Non-Biodegradable Waste', 'Zone 4 ', '35% of total waste', 7016, 35.00, '8', '2024-12-28 08:29:05'),
(13, 'Recyclable Waste', 'Zone 2', '15% of total waste', 3007, 15.00, '7', '2024-12-28 08:29:32'),
(14, 'Households Practicing Segregation', 'Zone 1', '60% participation rate', 3701, 60.00, '9', '2024-12-28 08:30:57');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `status`, `created_at`) VALUES
(1, 4, 'Your Barangay appointment has been approved.', 'unread', '2025-01-05 19:04:33'),
(2, 4, 'Your Barangay appointment has been approved.', 'unread', '2025-01-05 19:04:38'),
(3, 0, 'Your Barangay appointment has been approved.', 'unread', '2025-01-05 19:05:07'),
(4, 0, 'Your Barangay appointment has been approved.', 'unread', '2025-01-05 19:13:49'),
(5, 0, 'Your Barangay appointment has been approved.', 'unread', '2025-01-05 19:13:53'),
(6, 0, 'Your Barangay appointment has been approved.', 'unread', '2025-01-05 19:27:13'),
(7, 0, 'Your Barangay appointment has been approved.', 'unread', '2025-01-05 19:27:16'),
(8, 4, 'Your Barangay appointment has been approved.', 'unread', '2025-01-05 19:38:14'),
(9, 4, 'Your Barangay appointment has been approved.', 'unread', '2025-01-05 19:38:20'),
(10, 7, 'Your Barangay appointment has been approved.', 'unread', '2025-01-05 19:39:38'),
(11, 7, 'Your Barangay appointment has been approved.', 'unread', '2025-01-05 19:39:40'),
(12, 18, 'Your Barangay appointment has been approved.', 'unread', '2025-01-05 19:43:42'),
(13, 4, 'Your Barangay appointment has been approved.', 'unread', '2025-01-05 19:45:43'),
(14, 4, 'Your Barangay appointment has been approved.', 'unread', '2025-01-06 01:11:59'),
(15, 4, 'Your Barangay appointment has been approved.', 'unread', '2025-01-06 01:12:08'),
(16, 4, 'Your Barangay document appointment has been approved.', 'unread', '2025-01-06 01:27:42'),
(17, 18, 'Your Barangay document appointment has been approved.', 'unread', '2025-01-06 01:27:44'),
(18, 18, 'Your Barangay document appointment has been approved.', 'unread', '2025-01-06 01:27:46'),
(19, 18, 'Your Barangay document appointment has been approved.', 'unread', '2025-01-06 01:27:48'),
(20, 18, 'Your Barangay document appointment has been approved.', 'unread', '2025-01-06 01:27:50'),
(21, 18, 'Your Barangay document appointment has been declined.', 'unread', '2025-01-06 01:27:51'),
(22, 18, 'Your Barangay document appointment has been approved.', 'unread', '2025-01-06 01:31:21'),
(23, 18, 'Your Barangay document appointment has been approved.', 'unread', '2025-01-06 01:32:42'),
(24, 18, 'Your Barangay document appointment has been approved.', 'unread', '2025-01-06 01:32:43'),
(25, 18, 'Your documentation appointment has been approved.', 'unread', '2025-01-06 01:35:44'),
(26, 18, 'Your documentation appointment has been approved.', 'unread', '2025-01-06 01:35:55'),
(27, 4, 'Your documentation appointment has been approved.', 'unread', '2025-01-06 01:50:59'),
(28, 4, 'Your Barangay appointment has been approved.', 'unread', '2025-01-06 02:33:21'),
(29, 4, 'Your Barangay appointment has been declined.', 'unread', '2025-01-06 02:34:03');

-- --------------------------------------------------------

--
-- Table structure for table `organizational_chart`
--

CREATE TABLE `organizational_chart` (
  `position_id` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `current_project` text DEFAULT NULL,
  `assign_task` varchar(255) NOT NULL,
  `progress` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizational_chart`
--

INSERT INTO `organizational_chart` (`position_id`, `position`, `full_name`, `email`, `number`, `current_project`, `assign_task`, `progress`, `address`, `image_path`, `image_name`) VALUES
(1, 'Punong Barangay', 'EULOGIO CESAR MANAYON', 'cesarmanayon@gmail.com', '+639123456789', 'Road Widening', 'Wast Collection Team', '61%', 'Purok 5 skina babag', 'uploads/avatar2.jpg', 'avatar2.jpg'),
(2, 'Sanguniang Barangay', 'LARRY BERDON ', 'larryberdon@gmail.com', '09123456789', 'Road Widening', 'Wast Collection Team', '61%', 'Babag', 'uploads/avatar.png', 'avatar.png');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `is_anonymous` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `photo_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `is_approved`, `is_anonymous`, `created_at`, `photo_path`) VALUES
(54, 4, 'There is an event in labogon. It is a clean and green, if you are willing to volunteer just come to the zone 1 location. You\'re cooperation is very much appreciated.', 1, 1, '2025-01-05 18:13:43', 'uploads/677a5b576cc3b_ewaste-aspect-ratio-2000-1200-1024x614.jpg'),
(55, 4, 'i want to help ', 1, 1, '2025-01-05 20:14:10', 'uploads/677a779203bc1_ewaste-aspect-ratio-2000-1200-1024x614.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reminder`
--

CREATE TABLE `reminder` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`id`, `date`, `description`, `created_at`) VALUES
(15, '2025-01-02', 'Garbage collection reminder', '2025-01-02 22:10:44'),
(16, '2025-01-02', 'Garbage collection reminder', '2025-01-02 22:15:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`id`, `user_name`, `password`, `user_email`, `user_type`) VALUES
(1, 'dave@gmail.com', '$2y$10$WtbzJRNA1CcqvyJtWmfBYedfsucn6Rlr0gPx42rbA4z6dYy3LZzfK', 'daavviidd21@gmail.com', 'user'),
(2, 'dave1@gmail.com', '$2y$10$rjgoJBv1pJ6a4aW4SwpFGuRL/3RToN/Uzp7BfTIH3iqqyn89l/D4u', 'dave@gmail.com', 'user'),
(3, 'jarred', '$2y$10$ep2MF2z7mbawKIfXpTM6K.SIZAQWHa3IUsv800EchTUu51Tit0gMu', 'jarredsaludaga@gmail.com', 'user'),
(4, 'jarred', '$2y$10$heniX/hWhs/55r9wokX9Pe8Vz/adToEXDwTJi7QcVvreteY89UREO', 'kleindmas@gmail.com', 'user'),
(6, 'user_username', 'user_password', 'user_email@example.com', 'user'),
(7, 'jenn', '$2y$10$lQ2C/b75NgPmL3LHsoVe9ekGhcUpU2JAkedzTm2AJIJrQD/YFyt/a', 'jen@gmail.com', 'user'),
(8, 'jarred', '$2y$10$Se6MXkuH4NspKIqK0tLQv.RMJUfUkzGltWDaduXE2sUzPKW17UHcO', 'jar@gmail.com', 'purok_leader'),
(18, 'adminpo', '$2y$10$GoyNTwqTKhoCFtsUl4d22eB5vse2KKQ1r7cTCL4mh8ImIP1H.GaAS', 'adminpo@gmail.com', 'admin'),
(19, 'derraj', '$2y$10$CDaDdLfg4HXOgPFx0EsKkuuKzeNYZJI8qSngsyMJGcX/O0njmbd8q', 'deraj@gmail.com', 'user'),
(20, 'john', '$2y$10$fdqVB7Fa8gUE2ClhDYrFY.EcGJMZfh0YZ73TC/Fj2I2pYukoBHPee', 'john@gmail.com', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buy_and_sell`
--
ALTER TABLE `buy_and_sell`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `documentation_appointments`
--
ALTER TABLE `documentation_appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `employees_schedule`
--
ALTER TABLE `employees_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_role`
--
ALTER TABLE `employee_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `garbage_collection`
--
ALTER TABLE `garbage_collection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `initiatives`
--
ALTER TABLE `initiatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizational_chart`
--
ALTER TABLE `organizational_chart`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reminder`
--
ALTER TABLE `reminder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `buy_and_sell`
--
ALTER TABLE `buy_and_sell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `documentation_appointments`
--
ALTER TABLE `documentation_appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees_schedule`
--
ALTER TABLE `employees_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_role`
--
ALTER TABLE `employee_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `garbage_collection`
--
ALTER TABLE `garbage_collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `incidents`
--
ALTER TABLE `incidents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `initiatives`
--
ALTER TABLE `initiatives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `organizational_chart`
--
ALTER TABLE `organizational_chart`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `reminder`
--
ALTER TABLE `reminder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buy_and_sell`
--
ALTER TABLE `buy_and_sell`
  ADD CONSTRAINT `buy_and_sell_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `documentation_appointments`
--
ALTER TABLE `documentation_appointments`
  ADD CONSTRAINT `documentation_appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`id`);

--
-- Constraints for table `garbage_collection`
--
ALTER TABLE `garbage_collection`
  ADD CONSTRAINT `garbage_collection_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
