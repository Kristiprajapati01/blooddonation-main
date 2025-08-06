-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2025 at 07:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blooddonation`
--

-- --------------------------------------------------------

--
-- Table structure for table `bloodbank`
--

CREATE TABLE `bloodbank` (
  `id` int(11) UNSIGNED NOT NULL,
  `service_type` enum('24-hour','Custom') NOT NULL,
  `service_start_time` time DEFAULT NULL,
  `service_end_time` time DEFAULT NULL,
  `image` varchar(255) DEFAULT 'img/slide1.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bloodbank`
--

INSERT INTO `bloodbank` (`id`, `service_type`, `service_start_time`, `service_end_time`, `image`) VALUES
(40, '24-hour', '00:00:00', '23:59:59', '../upload/abc.png'),
(68, '24-hour', '00:00:00', '23:59:59', '../upload/download1.png'),
(69, '24-hour', '00:00:00', '23:59:59', '../upload/background1.png'),
(71, '24-hour', '00:00:00', '23:59:59', '../upload/abcd.png'),
(72, '24-hour', '00:00:00', '23:59:59', '../upload/lllll.png'),
(73, '24-hour', '00:00:00', '23:59:59', '../upload/a.png'),
(74, '24-hour', '00:00:00', '23:59:59', '../upload/DONATE-BLOOD-3.png'),
(75, '24-hour', '00:00:00', '23:59:59', '../upload/DONATE-BLOOD-3.png'),
(109, '24-hour', '00:00:00', '23:59:59', '../upload/background1.png'),
(110, '24-hour', '00:00:00', '23:59:59', '../upload/a.png'),
(122, '24-hour', '00:00:00', '23:59:59', '../upload/185052-dbsl.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `blood_bank_ratings`
--

CREATE TABLE `blood_bank_ratings` (
  `id` int(11) NOT NULL,
  `blood_bank_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_bank_ratings`
--

INSERT INTO `blood_bank_ratings` (`id`, `blood_bank_id`, `user_id`, `rating`, `created_at`) VALUES
(27, 40, 45, 2, '2025-04-09 22:14:30'),
(28, 40, 76, 5, '2025-05-06 18:20:34'),
(29, 40, 77, 4, '2025-05-06 18:21:00'),
(30, 40, 78, 4, '2025-05-06 18:21:31'),
(31, 40, 79, 5, '2025-05-06 18:23:05'),
(32, 68, 76, 1, '2025-05-06 18:26:47'),
(33, 69, 80, 3, '2025-05-06 18:28:11'),
(34, 71, 81, 3, '2025-05-06 18:29:11'),
(35, 40, 82, 4, '2025-05-06 18:30:05'),
(36, 40, 83, 5, '2025-05-06 18:31:04'),
(37, 40, 84, 5, '2025-05-06 18:41:04'),
(38, 40, 85, 4, '2025-05-06 18:42:16'),
(39, 72, 85, 2, '2025-05-06 18:44:42'),
(40, 40, 86, 5, '2025-05-06 18:52:28'),
(41, 40, 87, 5, '2025-05-06 18:55:36'),
(42, 40, 88, 5, '2025-05-06 18:57:22'),
(43, 40, 89, 5, '2025-05-06 18:58:50'),
(44, 68, 90, 2, '2025-05-06 19:00:45'),
(45, 40, 91, 5, '2025-05-06 19:04:59'),
(46, 40, 92, 5, '2025-05-06 19:13:12'),
(47, 40, 93, 5, '2025-05-06 19:16:11'),
(48, 68, 94, 1, '2025-05-06 19:17:16'),
(49, 73, 95, 1, '2025-05-06 19:18:13'),
(50, 74, 96, 1, '2025-05-06 19:22:04'),
(51, 75, 97, 1, '2025-05-06 19:24:21'),
(52, 40, 98, 1, '2025-05-06 19:27:47'),
(53, 68, 99, 2, '2025-05-06 19:28:47'),
(54, 69, 100, 2, '2025-05-06 19:29:47'),
(55, 68, 101, 1, '2025-05-06 19:33:25'),
(56, 40, 102, 5, '2025-05-06 19:35:40'),
(57, 72, 103, 1, '2025-05-06 19:36:40'),
(58, 68, 103, 3, '2025-05-06 19:44:33'),
(59, 40, 104, 4, '2025-05-06 19:46:08'),
(62, 40, 55, 4, '2025-05-06 20:02:15'),
(63, 71, 45, 4, '2025-05-06 20:08:53'),
(64, 109, 55, 5, '2025-05-16 10:36:00'),
(65, 110, 45, 4, '2025-07-29 12:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `blood_details`
--

CREATE TABLE `blood_details` (
  `id` int(11) UNSIGNED NOT NULL,
  `donor_email` varchar(225) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` char(1) NOT NULL,
  `dob` date NOT NULL,
  `weight` float NOT NULL,
  `bloodgroup` varchar(3) NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(15) NOT NULL,
  `bloodqty` float NOT NULL,
  `collection` date NOT NULL,
  `bloodbank_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expire` timestamp NULL DEFAULT NULL,
  `donor_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_details`
--

INSERT INTO `blood_details` (`id`, `donor_email`, `name`, `gender`, `dob`, `weight`, `bloodgroup`, `address`, `contact`, `bloodqty`, `collection`, `bloodbank_id`, `created_at`, `expire`, `donor_id`) VALUES
(33, '', 'Kristi Prajapati', 'F', '2003-10-18', 54, 'A+', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, NepaL', '9841407154', 400, '2025-04-08', 40, '2025-04-09 08:07:33', '2025-05-19 18:15:00', NULL),
(34, '', 'Test', 'M', '2000-02-22', 55, 'B+', 'Kathmandu Metropolitan City, Kathmandu, Bagmati Province, Nepal', '9852364859', 500, '2025-04-09', 40, '2025-04-09 09:38:11', '2025-05-20 18:15:00', NULL),
(35, '', 'mony', 'M', '2000-02-22', 88, 'AB-', 'Kathmandu', '9864333083', 500, '2025-05-16', 40, '2025-05-16 11:39:16', '2025-06-26 18:15:00', NULL),
(36, '', 'testttt', 'F', '2000-02-22', 88, 'A+', 'pokhara', '9845632104', 500, '2025-05-17', 68, '2025-05-17 01:48:45', '2025-06-27 18:15:00', NULL),
(37, '', 'Sweta', 'F', '1998-05-28', 65, 'A+', 'Jyatha Marg, Kamalachi, Kathmandu-27, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 20137, Nepal', '9845632145', 500, '2025-07-28', 122, '2025-07-28 06:52:39', '2025-09-07 18:15:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blood_requests`
--

CREATE TABLE `blood_requests` (
  `id` int(11) UNSIGNED NOT NULL,
  `bloodgroup` varchar(200) NOT NULL,
  `requester_name` varchar(255) NOT NULL,
  `requester_email` varchar(255) NOT NULL,
  `requester_phone` varchar(50) NOT NULL,
  `donation_address` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Rejected','Completed') DEFAULT 'Pending',
  `bloodbank_id` int(11) UNSIGNED NOT NULL,
  `delivery_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_requests`
--

INSERT INTO `blood_requests` (`id`, `bloodgroup`, `requester_name`, `requester_email`, `requester_phone`, `donation_address`, `quantity`, `message`, `request_date`, `status`, `bloodbank_id`, `delivery_time`) VALUES
(52, 'A+', 'User', 'user@gmail.com', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 100, 'pleaseeee', '2025-04-09 09:44:27', 'Pending', 40, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `campaign_name` varchar(255) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `campaign_date` date NOT NULL,
  `description` text NOT NULL,
  `bloodbank_id` int(10) UNSIGNED NOT NULL,
  `location` varchar(255) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `campaign_name`, `contact_number`, `campaign_date`, `description`, `bloodbank_id`, `location`, `latitude`, `longitude`) VALUES
(27, 'Donate Blood Campaign', '9856321478', '2025-04-10', 'soon', 40, 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 27.70831700, 85.32058170),
(28, 'ktm ', '9852364178', '2025-04-10', 'blood donation', 40, 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 27.70831700, 85.32058170);

-- --------------------------------------------------------

--
-- Table structure for table `donation_requests`
--

CREATE TABLE `donation_requests` (
  `id` int(11) UNSIGNED NOT NULL,
  `blood_bank_id` int(11) UNSIGNED NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Rejected','Completed') DEFAULT 'Pending',
  `quantity` int(100) NOT NULL,
  `donor_email` varchar(255) NOT NULL,
  `message` varchar(225) DEFAULT NULL,
  `appointment_time` timestamp(5) NULL DEFAULT NULL,
  `responsetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_requests`
--

INSERT INTO `donation_requests` (`id`, `blood_bank_id`, `request_date`, `status`, `quantity`, `donor_email`, `message`, `appointment_time`, `responsetime`) VALUES
(32, 40, '2025-04-10 10:22:25', 'Approved', 200, 'd@gmail.com', 'im ready', '2025-04-10 10:25:00.00000', '2025-04-10 10:26:01'),
(33, 40, '2025-05-05 14:18:27', 'Pending', 500, 'd@gmail.com', 'im ready to donate', NULL, '2025-05-05 14:18:27'),
(34, 74, '2025-05-06 12:46:36', 'Pending', 500, 'd@gmail.com', 'im ready', NULL, '2025-05-06 12:46:36');

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `id` int(11) UNSIGNED NOT NULL,
  `donor_blood_type` varchar(3) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `last_donation_date` date DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT '../upload/defaultimage.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`id`, `donor_blood_type`, `dob`, `weight`, `gender`, `last_donation_date`, `profile_image`) VALUES
(55, 'B+', '2000-02-22', 88, 'Female', '2024-12-07', '../upload/ab.png'),
(57, 'A+', '2029-10-18', 55, 'Female', '2025-04-19', '../upload/defaultimage.png'),
(58, 'A-', '2000-10-14', 55, 'Female', '2025-04-29', '../upload/defaultimage.png'),
(59, 'A-', '2002-07-13', 55, 'Male', '2024-12-07', '../upload/defaultimage.png'),
(60, 'O+', '1997-03-08', 77, 'Female', '2024-01-11', '../upload/defaultimage.png'),
(61, 'B+', '2006-02-18', 55, 'Male', '2024-07-12', '../upload/defaultimage.png'),
(67, 'AB+', '2003-10-18', 55, 'Female', '2025-05-05', '../upload/defaultimage.png'),
(105, 'A-', '2025-05-06', 88, 'Male', '2025-05-06', '../upload/defaultimage.png'),
(106, 'A+', '2025-05-06', 65, 'Male', '2025-05-06', '../upload/defaultimage.png'),
(107, 'O+', '2000-12-22', 88, 'Female', '2025-05-09', '../upload/defaultimage.png'),
(120, 'B+', '2000-02-22', 54, 'Female', '2024-10-10', '../upload/defaultimage.png'),
(121, 'A+', '2003-10-18', 55, 'Female', '2025-07-31', '../upload/defaultimage.png'),
(123, 'A-', '2001-07-14', 55, 'Female', '2025-03-06', '../upload/defaultimage.png');

-- --------------------------------------------------------

--
-- Table structure for table `donorblood_request`
--

CREATE TABLE `donorblood_request` (
  `id` int(11) UNSIGNED NOT NULL,
  `donor_id` int(11) UNSIGNED NOT NULL,
  `donor_email` varchar(255) NOT NULL,
  `requester_name` varchar(255) NOT NULL,
  `requester_email` varchar(255) NOT NULL,
  `requester_phone` varchar(50) NOT NULL,
  `donation_address` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Rejected','Completed') DEFAULT 'Pending',
  `bloodgroup` varchar(3) NOT NULL,
  `delivery_time` time DEFAULT NULL,
  `responsetime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donorblood_request`
--

INSERT INTO `donorblood_request` (`id`, `donor_id`, `donor_email`, `requester_name`, `requester_email`, `requester_phone`, `donation_address`, `quantity`, `message`, `request_date`, `status`, `bloodgroup`, `delivery_time`, `responsetime`) VALUES
(14, 55, 'd@gmail.com', 'User', 'user@gmail.com', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 200, 'urgent', '2025-04-10 10:19:14', 'Approved', 'B+', '01:00:00', '2025-04-10 10:20:24'),
(15, 55, 'd@gmail.com', 'User', 'user@gmail.com', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 104, 'hi', '2025-04-18 15:22:44', 'Rejected', 'B+', NULL, '2025-05-05 14:18:43'),
(16, 58, 'B@gmail.com', 'User', 'user@gmail.com', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 150, 'urgeny', '2025-04-29 05:59:52', 'Rejected', 'A-', '01:00:00', '2025-04-29 06:06:29'),
(17, 67, 'Kp@gmail.com', 'User', 'user@gmail.com', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 500, 'urgent', '2025-07-31 02:00:49', 'Approved', 'AB+', '01:00:00', '2025-07-31 02:01:22'),
(18, 121, 'prajapatikristi175@gmail.com', 'User', 'user@gmail.com', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 500, 'urgent', '2025-07-31 04:17:25', 'Approved', 'A+', '01:00:00', '2025-07-31 04:18:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_type` enum('User','Donor','Admin','BloodBank') NOT NULL,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `phone`, `address`, `user_type`, `latitude`, `longitude`) VALUES
(40, 'Kathmandu Blood Bank', 'ktm123@gmail.com', '$2y$10$OmmQjgQfLr1qIqQUoHdr7uYH0behzBKWGR2o/eHgEA.SZOg5cwUj.', '9860726807', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'BloodBank', 27.708317, 85.320582),
(45, 'User', 'user@gmail.com', '$2y$10$b1T8eJAyTkjH58g5eIm3sOEj54Rpi3T4yOqdqdtTDppNzAh9VEyxe', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'User', 27.708317, 85.320582),
(46, 'ADMIN', 'admin@gmail.com', '$2y$10$hDNZFFO7A2I.lgy3qO0LAerQhUYLR1E7bRYz3l7.90kHfhpu.fge2', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'Admin', 27.708317, 85.320582),
(55, 'Donors', 'd@gmail.com', '$2y$10$rEjt1CPQHxhU.Te./j8TxuoBhesqpZx9Lu/Z1BQSrcuFQr/tVWcFa', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'Donor', 27.708317, 85.320582),
(57, 'test', 'test@abc.com', '$2y$10$kNe/P56PxG.z.Bi6C7VidOM79wTdbJSDalv30krnKnFm5dXlnDrLW', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'Donor', 27.708317, 85.320582),
(58, 'Kristi', 'B@gmail.com', '$2y$10$KQ3Yq9sLOYkicNoTOhZt/OisA8upvKPGSjxIlRxA5Ext6s4hVhqjG', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'Donor', 27.708317, 85.320582),
(59, 'Ram', 'ram@gmail.com', '$2y$10$EgRmSwFYxdheY8c0djD6wuicNck2FAU5hZVAotxR4LislLWbnE/.K', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'Donor', 27.708317, 85.320582),
(60, 'test', 'test3@gmail.com', '$2y$10$rWMTH2h/bnCKp1unEWJSK.wOk5TQAT.9qPcZ.cL/b7ZA6BwdGqFua', '9852364178', 'p, Kanda-04, Kanda, Bajhang, Sudurpashchim Province, Nepal', 'Donor', 30.005586, 81.282612),
(61, 'Jenisha', 'j@gmail.com', '$2y$10$tgF.DqBaDLE6cXmJV6TtkeJiUmDzoxIft/.eDECncPehCtUAaqX76', '9852364178', 'Lagan Marga, Kathmandu-21, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 04110, Nepal', 'Donor', 27.699418, 85.307237),
(66, 'Kristi', 'k@gmail.com', '123456', '123456', '9852364178', 'User', 27.708317, 85.320582),
(67, 'KristiP', 'Kp@gmail.com', '$2y$10$XPq3MHmHefdOF9vmeYv7b.CsNlqKq17kPw3f8EdcLqiziughYasYW', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'Donor', 27.708317, 85.320582),
(68, 'Pokhara Blood Bank', 'pkr123@gmail.com', '$2y$10$KnpKzB5AC3yhb0T.Sf1pmOGL2j5PbZwX5ciDxzsAZPNohY.pJk2z.', '9852364178', 'p, Kanda-04, Kanda, Bajhang, Sudurpashchim Province, Nepal', 'BloodBank', 30.005537, 81.282671),
(69, 'Pokhara Blood Bank', 'pr@gmail.com', '$2y$10$AGDF/L7kfYWAcD3oz6PAOueXYmii9igi1bUCtkXLqppLgWTBhJM0O', '9852364178', 'Pokhara, Kaski, Gandaki Province, Nepal', 'BloodBank', 28.209538, 83.991402),
(70, 'Shristi', 'shristi@gmail.com', '$2y$10$b2WNNwRASSUgDWoi6xLVS.gqOQVRzC2pajACnzDk9Tfuy4pIqmp/2', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'User', 27.708317, 85.320582),
(71, 'Butwal Blood Bank', 'Butwal@gmail.com', '$2y$10$98l/YEoc7NlvWxp154Eifecfgj2mZtzhzZjFCDSaweGmQex4VxnfC', '9852364178', 'Butwal, Rupandehi, Lumbini Province, 32907, Nepal', 'BloodBank', 27.700399, 83.465767),
(72, 'Jhapa Blood Bank', 'jhapa@gmail.com', '$2y$10$XjgZ0nkBMx5qyOUb7SjIR.QxuMjgkUlOSo.ycwu3.S6eXjnbnkSaS', '9852364178', 'Jhapa, Koshi Province, Nepal', 'BloodBank', 26.583735, 87.885701),
(73, 'Kantipur Blood Bank', 'kantipur@gmail.com', '$2y$10$0IkmemnX3PHGPd8nq9PjF.pYfvee/5csYTGSjmDzQ.Bs18sChjZl6', '9853364178', 'Kantipur, Mamur, Alital-03, Alital, Dadeldhura, Sudurpashchim Province, Nepal', 'BloodBank', 29.145107, 80.478837),
(74, 'Kritipur', 'kritipur@gmail.com', '$2y$10$8uqqpBm6sg7gIjleRZ7aI.tUu7b9/c9mTWoD3KnH8p1/MzVMK7MoC', '9852364178', 'Sankha Kriti Maha Bihar, Bhagwati marg, Kamalpokhari, Narayan Chaur, Kathmandu-01, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 46000, Nepal', 'BloodBank', 27.713618, 85.326241),
(75, 'Patan Blood Bank', 'patan@gmail.com', '$2y$10$YIQR0JiHQ.NskPqzbQ3IEO1THET8dzkeevvl.MRneN7Q8BJiUHWta', '9852364178', 'Patan, Baitadi, Sudurpashchim Province, Nepal', 'BloodBank', 29.450609, 80.582430),
(76, 'Sujindra Maharjan', 'sujin@gmail.com', '$2y$10$ze9JgZ8pHZ0PSv7TqyfHy.LCVtFvRrsGacHKQVGb8r.E1C41XwM7m', '9852364178', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'User', 27.708317, 85.320582),
(77, 'Ab', 'ab@gmail.com', '$2y$10$Ptc3Bs328SFbTOvWIAePCO8hnJ88Rhiapa3rIpz0VESW7XDzMu01y', '9852364178', 'Lalitpur, Lalitpur Metropolitan City, Lalitpur, Bagamati Province, 44707, Nepal', 'User', 27.676734, 85.316805),
(78, 'abc', 'abcd@gmail.com', '$2y$10$5UBVKQLO.aGfGRdaCH9hO.HjjnfL.TIvL2wVXvlgu0r.Fhgpdlxgq', '9865412365', 'Bhaktapur, Changunarayan-05, Changunarayan, Changunarayan Municipality, Bhaktapur, Bagamati Province, 44800, Nepal', 'User', 27.704332, 85.452118),
(79, 'G', 'g@gmail.com', '$2y$10$AV7r1yyAGmOw6XjyKTgnhO6ZY7fC4S3E/B.919E6f8PFQ0uiWbL8G', '9864512387', 'Jha Upachar Kendra, F3, Hannumannagar Kankalini-08, Hanuman Nagar, Hannumannagar Kankalini, Saptari, Madhesh Province, Nepal', 'User', 26.507576, 86.860490),
(80, 'Hari', 'hari@gmail.com', '$2y$10$yCkIt9kIHwgeKcujCvnZauPpVXr7GxwfVRjre92dzmo82MO3cbf0G', '9845632145', 'Ason, Kathmandu-25, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'User', 27.707480, 85.312235),
(81, 'Gita', 'gita@gmail.com', '$2y$10$R9GEK/svdORlbUrRv5qFN.DopbSuOtvwYrWt2SWh.TTWRE6N4KTAK', '9874568912', 'Thahity Jyatha Marg, Lut Chok, Thamel, Kathmandu-26, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 44600, Nepal', 'User', 27.708935, 85.311498),
(82, 'Shyam', 'shyam@gmail.com', '$2y$10$8pvf/ztTNQT2uuyDJPzLr.G84ZurPiVmxReYI/3Hx03f642fw7kg2', '9874125639', 'Thame, Khumbupasanglahmu, Solukhumbu, Koshi Province, 56000, Nepal', 'User', 27.831887, 86.650479),
(83, 'Harry', 'harry@gmail.com', '$2y$10$KaWx0lcaKEqVbyDvi8iu2OmgZzkeaIrWCynd54CgMK2IT1814/9e6', '9874125639', 'Sherina krishi farm tha pashupanxi farm, Namobuddha-09, Puranogaun Dapcha, Namobuddha, Kavrepalanchok, Bagamati Province, 45205, Nepal', 'User', 27.554778, 85.612388),
(84, 'cd', 'cd@gmail.com', '$2y$10$y2t.N12lc3kFD0CAM8SqqOmEe5nXs0oK1cD3pxcprDKNKbF30NM8S', '9874125639', 'Kat Resort Pvt. Ltd, Pasang Lhamu Highway, Nigale, Kakani-04, Jurethum, Kakani, Nuwakot, Bagamati Province, Nepal', 'User', 27.818214, 85.244857),
(85, 'de', 'de@gmail.com', '$2y$10$bdDmwwhV9AXir.Ytc1V28.OFYOwFYRjJWLXiQycELiwD6x1IFrKKO', '9874125632', 'Hama Industries, Jitpur Simara-02, Simara, Jitpur Simara, Bara, Madhesh Province, Nepal', 'User', 27.166492, 84.974445),
(86, 'E', 'ef@gmail.com', '$2y$10$R6PE7T3dXVKDHaTwbjDwx.K501mw9v83fSrlNG5RX2YVy66fe7dcu', '9874563214', 'Cho Aui I, Khumbupasanglahmu, Solukhumbu, Koshi Province, Nepal', 'User', 28.073097, 86.612660),
(87, 'F', 'f@gmail.com', '$2y$10$tkc.HzwaVNim83UwUPqXC.ddXTQz445IVEA6.8LhG.1nuFjTIZQtm', '9874563214', 'Kat Resort Pvt. Ltd, Pasang Lhamu Highway, Nigale, Kakani-04, Jurethum, Kakani, Nuwakot, Bagamati Province, Nepal', 'User', 27.818214, 85.244857),
(88, 'Rachel', 'rachel@gmail.com', '$2y$10$XTWqrG37wyB0Ad9inkiYX.uHrtkK4UmyrKf2OAQuxQt6h9ehJWfCS', '9874563214', 'Paknajol, Kathmandu-16, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 46001, Nepal', 'User', 27.715548, 85.308458),
(89, 'green', 'green@gmail.com', '$2y$10$Wx8x2OlDysLYsYDU2KZor.NFYJ/Cakn0qGacALIV0HqNn4GlU5S.C', '9875698423', 'Thamel, Kathmandu-26, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 46001, Nepal', 'User', 27.717028, 85.311256),
(90, 'Ross', 'ross@gmail.com', '$2y$10$e.ruwMdG2YLRz1csjLw0ROwii70q1CkXI3/5PzE.ttwZlz2LBJrKu', '9874568974', 'B., Hospital Marg-1, Bulbulley, Chabahil, Kathmandu-07, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 44660, Nepal', 'User', 27.717608, 85.345560),
(91, 'monica', 'monica@gmail.com', '$2y$10$nGuK8zaK8KGI24Nh3e1UGOSONdpWyZs1BkwdxJ2BnIDVQGDtqhIpm', '9874589656', 'Jyatha Marg, Kamalachi, Kathmandu-27, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 20137, Nepal', 'User', 27.710374, 85.312937),
(92, 'chandler', 'chandler@gmail.com', '$2y$10$esvaNNaYTcRCn.4afpwIUOz6XfSzRmynJH18zWLSmdSmaTY7mgDRm', '9874569874', 'Jhamsikhel, Dhobighat, Lalitpur-03, Lalitpur, Lalitpur Metropolitan City, Lalitpur, Bagamati Province, 44690, Nepal', 'User', 27.678250, 85.309409),
(93, 'potter', 'potter@gmail.com', '$2y$10$i1Kb/6ZVU8iq/R5JxFCtTePkeQbgxUnBMaVLfPR6MH7h8zroylRb.', '9874569874', 'p, Kanda-04, Kanda, Bajhang, Sudurpashchim Province, Nepal', 'User', 30.005586, 81.282612),
(94, 'hridaa', 'hrida@gmail.com', '$2y$10$bM6Y0pky7NI2gKdOko2kWO/d0ygMIVRxq6q27rldja81xENHnng9K', '9874563214', 'KR Liquor Shop, Pragati Sadak, Nav Milan Bastii, Tokha-10, Tokha, Tokha Municipality, Kathmandu, Bagamati Province, 21775, Nepal', 'User', 27.738434, 85.317809),
(95, 'Hridaan', 'hridaan@gmail.com', '$2y$10$JPwJPZJ4gR5ixs9xxumbQOpGc5XYp8xVqZ4qxvHnoTDVQpnjzfBj2', '98741203645', 'Hetauda, Makwanpur, Bagamati Province, 44107, Nepal', 'User', 27.429585, 85.032659),
(96, 'Sichu', 'suchu@gmail.com', '$2y$10$15spR5WlVqxjoWiquaxxuetfQgVE/IR0WSodi3Wva/k38eS1Wp.9C', '9874563210', 'Ason, Jyatha Marg, Lut Chok, Thamel, Kathmandu-26, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 14292, Nepal', 'User', 27.709380, 85.312317),
(97, 'karina', 'karina@gmail.com', '$2y$10$56.6dvoLIFcwXE5sOfKadONHT3V9zdBmBEJUfcsSQw43qHem0T6UK', '9876530214', 'Maru Tol, Kathmandu-20, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 44066, Nepal', 'User', 27.703789, 85.305860),
(98, 'karuna', 'karuna@gmail.com', '$2y$10$UimBwxY/oqU5iiErxev6Gu3TezZqqPtNa4KdLF4ewlhuacwQpymEW', '9802589631', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'User', 27.708317, 85.320582),
(99, 'Urima', 'urima@gmail.com', '$2y$10$iHv484N/a6Xe9vOPv3JCaOxtlyAjEkBNuIeaL2iOPQkK/8yonmvo6', '9832014785', 'Nayabazar, Kathmandu-16, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 46001, Nepal', 'User', 27.720663, 85.306635),
(100, 'uri', 'uri@gmail.com', '$2y$10$l67..1Cm3hNsvFKKX20LDOOuKvycs/5BaOSapibayWCy4kzC5RJdG', '985236985', 'Naya Naikap, Chandragiri Municipality, Kathmandu, Bagamati Province, 44618, Nepal', 'User', 27.687254, 85.264708),
(101, 'karki', 'karki@gmail.com', '$2y$10$JoRHrw8M/Y7lN5QSwjA2f.9RW4rMPmNli.4KcwZgb7KmallXhxwO6', '9874589658', 'Cloth Shop, Bagbazar, Bhimkalipatan Chowk, Bagar, Pokhara-01, Pokhara, Kaski, Gandaki Province, 88700, Nepal', 'User', 28.239905, 83.987240),
(102, 'john', 'john@gmail.com', '$2y$10$dSgvMTzFowEkWy/j28W6QuOuKq1j7TcSWJ/7ThUZeC7Biw/vJifHK', '9874101478', 'Thahity Jyatha Marg, Lut Chok, Thamel, Kathmandu-26, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 44600, Nepal', 'User', 27.708935, 85.311498),
(103, 'Doe', 'doe@gmail.com', '$2y$10$QnB8/a7nbyq2ny4RcEnsS.VLX8omNW2Ad.v54UgGucAU0f/ZSuuTq', '987412589', 'Ason, Kathmandu-25, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'User', 27.707480, 85.312235),
(104, 'Maharjan', 'maharjan@gmail.com', '$2y$10$Q4RlygfJcAxHW0Jg0kntZ.YucqUHCNWEFmAhRUCr3Mz8ufgDKClgq', '9871000000', 'Ason, Kathmandu-25, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'User', 27.707480, 85.312235),
(105, 'krisyi', 'z@abc.com', '$2y$10$RO3a530TyF1ftldtCF5NjOdZFj6J3Qu9xh0NIb4na/tSggpOxzcES', '9874125698', 'Kat Resort Pvt. Ltd, Pasang Lhamu Highway, Nigale, Kakani-04, Jurethum, Kakani, Nuwakot, Bagamati Province, Nepal', 'Donor', 27.818214, 85.244857),
(106, 'Prajapati', 'prajapatikristi175@a.com', '$2y$10$XmJd80kmhQl5R2zIRl951.rzonFtlr6DxAVBAsrJVMhwSnpRtROci', '9864333083', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'Donor', 27.708317, 85.320582),
(107, 'kariaa', 'karia@gmail.com', '$2y$10$B00K5hw3UAqZ/IgvVI/6yex1PqQHg0NQM8RrdpKtNKocoVSTLq.J2', '9845632147', 'Kat Resort Pvt. Ltd, Pasang Lhamu Highway, Nigale, Kakani-04, Jurethum, Kakani, Nuwakot, Bagamati Province, Nepal', 'Donor', 27.818214, 85.244857),
(109, 'kk', 'kk@abc.com', '$2y$10$APPBrg6Q5SrKSPf1T4q6JOLrZ.yxMjbAwBNCDKEn.rK94HUW2nQbK', '9874563214', 'Bala, Silichong, Sankhuwasabha, Koshi Province, Nepal', 'BloodBank', 27.508010, 87.082418),
(110, 'aa', 'aaa@gmail.com', '$2y$10$5rO8gaUUznG8hfZqFh/J.O6mGYHj5hkMofB7Zmti9yeVzKWJEvD0q', '9874563214', 'Balaju, Kathmandu-16, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 44611, Nepal', 'BloodBank', 27.727043, 85.304590),
(111, 'bank', 'ba@gmail.com', '$2y$10$Z50gvwQ8lB34wNDvPM4HdubcCXrnrW9K6cS/iKvYv8evOLdJjX.Uy', '9874563214', 'Kat Resort Pvt. Ltd, Pasang Lhamu Highway, Nigale, Kakani-04, Jurethum, Kakani, Nuwakot, Bagamati Province, Nepal', 'BloodBank', 27.818214, 85.244857),
(120, 'rr', 'rr@gmail.com', '$2y$10$nbZcI0Nt/aD4sr0DUmITB.KUkW5OJu6cS/cpGMeXSREWxyRqa./xW', '9874563210', 'Kathmandu Metropolitan City, Kathmandu, Bagamati Province, Nepal', 'Donor', 27.708317, 85.320582),
(121, 'Kristi Prajapati', 'prajapatikristi175@gmail.com', '$2y$10$J8fkZQskfMbE0mcJD5bfx.rCPLAre3vnxTalo8x/Ln4D/M0on1WnK', '9864333083', 'Thahity Jyatha Marg, Lut Chok, Thamel, Kathmandu-26, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 44600, Nepal', 'Donor', 27.708935, 85.311498),
(122, 'Jyatha', 'jyatha@gmail.com', '$2y$10$1uNZrbJEk68F0pyF4Xi2M.qpNY/SfkYM5DmJLVVgxRwtvKfqAq6ri', '9852364178', 'Thahity Jyatha Marg, Lut Chok, Thamel, Kathmandu-26, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 44600, Nepal', 'BloodBank', 27.708935, 85.311498),
(123, 'A', 'a1@gmail.com', '$2y$10$BJwN8i0rhjxq4PDAjszGDepDuA3iOk7Ut98YZCjyp7SUVJ/kCXVtO', '9845632145', 'Sanepa, Lalitpur-02, Lalitpur, Lalitpur Metropolitan City, Lalitpur, Bagamati Province, 44690, Nepal', 'Donor', 27.683772, 85.309353);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bloodbank`
--
ALTER TABLE `bloodbank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_bank_ratings`
--
ALTER TABLE `blood_bank_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blood_bank_id` (`blood_bank_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `blood_details`
--
ALTER TABLE `blood_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bloodbank_id` (`bloodbank_id`),
  ADD KEY `fk_donor` (`donor_id`);

--
-- Indexes for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bloodbank_id` (`bloodbank_id`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bloodbank_id` (`bloodbank_id`);

--
-- Indexes for table `donation_requests`
--
ALTER TABLE `donation_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_donor_email` (`donor_email`),
  ADD KEY `fk_blood_bank_id` (`blood_bank_id`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donorblood_request`
--
ALTER TABLE `donorblood_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donor_id` (`donor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blood_bank_ratings`
--
ALTER TABLE `blood_bank_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `blood_details`
--
ALTER TABLE `blood_details`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `blood_requests`
--
ALTER TABLE `blood_requests`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `donation_requests`
--
ALTER TABLE `donation_requests`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `donorblood_request`
--
ALTER TABLE `donorblood_request`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bloodbank`
--
ALTER TABLE `bloodbank`
  ADD CONSTRAINT `bloodbank_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blood_bank_ratings`
--
ALTER TABLE `blood_bank_ratings`
  ADD CONSTRAINT `blood_bank_ratings_ibfk_1` FOREIGN KEY (`blood_bank_id`) REFERENCES `bloodbank` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blood_bank_ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blood_details`
--
ALTER TABLE `blood_details`
  ADD CONSTRAINT `blood_details_ibfk_1` FOREIGN KEY (`bloodbank_id`) REFERENCES `bloodbank` (`id`),
  ADD CONSTRAINT `fk_donor` FOREIGN KEY (`donor_id`) REFERENCES `donor` (`id`);

--
-- Constraints for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD CONSTRAINT `fk_bloodbank_id` FOREIGN KEY (`bloodbank_id`) REFERENCES `bloodbank` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `campaigns_ibfk_1` FOREIGN KEY (`bloodbank_id`) REFERENCES `bloodbank` (`id`);

--
-- Constraints for table `donation_requests`
--
ALTER TABLE `donation_requests`
  ADD CONSTRAINT `donation_requests_ibfk_1` FOREIGN KEY (`donor_email`) REFERENCES `users` (`email`),
  ADD CONSTRAINT `fk_blood_bank_id` FOREIGN KEY (`blood_bank_id`) REFERENCES `bloodbank` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `donor`
--
ALTER TABLE `donor`
  ADD CONSTRAINT `donor_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `donorblood_request`
--
ALTER TABLE `donorblood_request`
  ADD CONSTRAINT `donorblood_request_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
