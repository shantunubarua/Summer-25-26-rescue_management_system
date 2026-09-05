-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2026 at 03:42 PM
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
-- Database: `rescue_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `witness_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `donation_type` varchar(100) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `witness_id`, `amount`, `donation_type`, `payment_method`, `transaction_id`, `message`, `status`, `created_at`) VALUES
(1, 2, 300.00, 'money', 'bkash', 'TXN0000000000001', 'good luck', 'pending', '2026-09-01 05:31:15'),
(2, 2, 300.00, 'money', 'bkash', 'TXN0000000000002', 'good luck', 'pending', '2026-09-01 05:31:28'),
(3, 2, 300.00, 'money', 'bkash', 'TXN0000000000003', 'good luck', 'pending', '2026-09-01 05:48:24'),
(4, 2, 300.00, 'money', 'bkash', 'TXN0000000000004', 'good luck', 'pending', '2026-09-01 05:53:52'),
(5, 2, 300.00, 'money', 'bkash', 'TXN0000000000005', 'good luck', 'pending', '2026-09-01 05:54:01'),
(6, 2, 300.00, 'money', 'card', 'TXN0000000000006', 'good initiative', 'pending', '2026-09-01 06:47:02'),
(7, 2, 100.00, 'money', 'cash', 'TXN453f3943bf9cd', 'keep up the good work', 'pending', '2026-09-01 08:02:35'),
(8, 2, 200.00, 'medicine', 'bank', 'TXN881b6d1b13c52', 'good', 'pending', '2026-09-01 08:05:43');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_requests`
--

CREATE TABLE `emergency_requests` (
  `id` int(11) NOT NULL,
  `help_seeker_id` int(11) NOT NULL,
  `emergency_type` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `priority` enum('low','medium','high','critical') NOT NULL DEFAULT 'medium',
  `victim_type` enum('self','other') NOT NULL DEFAULT 'self',
  `victim_information` text DEFAULT NULL,
  `victim_count` int(11) NOT NULL DEFAULT 1,
  `contact_information` varchar(150) NOT NULL,
  `status` enum('pending','assigned','ongoing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `volunteer_id` int(11) DEFAULT NULL,
  `accepted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergency_requests`
--

INSERT INTO `emergency_requests` (`id`, `help_seeker_id`, `emergency_type`, `location`, `description`, `priority`, `victim_type`, `victim_information`, `victim_count`, `contact_information`, `status`, `created_at`, `updated_at`, `volunteer_id`, `accepted_at`) VALUES
(1, 3, 'medical', 'Mirpur', 'A person needs immediate medical assistance.', 'high', 'self', NULL, 1, '01300000000', 'completed', '2026-08-24 15:57:34', '2026-08-30 11:18:56', 4, '2026-08-28 21:25:54');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `help_seeker_id` int(11) NOT NULL,
  `rescue_request_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('pending','reviewed','resolved') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `alert_type` enum('normal','important','emergency') NOT NULL DEFAULT 'normal',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `created_by`, `title`, `message`, `alert_type`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'Flood emergency alert', 'Rescue operation active in zone A', 'emergency', 'inactive', '2026-08-21 08:19:14', '2026-08-21 09:35:12');

-- --------------------------------------------------------

--
-- Table structure for table `rescue_reports`
--

CREATE TABLE `rescue_reports` (
  `id` int(11) NOT NULL,
  `emergency_request_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `rescue_status` enum('pending','ongoing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resource_requests`
--

CREATE TABLE `resource_requests` (
  `id` int(11) NOT NULL,
  `volunteer_id` int(11) NOT NULL,
  `resource_type` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','approved','rejected','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resource_requests`
--

INSERT INTO `resource_requests` (`id`, `volunteer_id`, `resource_type`, `quantity`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'First Aid Kit', 2, 'Needed for emergency rescue activity.', 'pending', '2026-08-30 12:07:59', '2026-08-30 12:07:59'),
(2, 4, 'First Aid Kit', 2, 'fgg', 'pending', '2026-08-30 12:13:30', '2026-08-30 12:13:30'),
(3, 4, 'First Aid Kit', 2, 'hh', 'pending', '2026-08-30 12:17:06', '2026-08-30 12:17:06'),
(4, 4, 'First Aid Kit 2', 2, 'qqq', 'pending', '2026-08-30 12:22:43', '2026-08-30 12:22:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','volunteer','witness','help_seeker') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'System Admin', 'admin@rescue.com', '01700000000', '$2y$10$0TxWWt5Dy4zyekIjW/gJYefYvGILexixK0i/rsl1F3fPTZtSN3vai', 'admin', '2026-08-21 07:35:46', '2026-08-21 07:35:46'),
(2, 'Tanaka Rahman', 'tanaka@rescue.com', '01800000000', '$2y$10$lJMs7egNit.DoRe/xM7asO35.mHpp0cuKqiPA2alhtQ5s7/bZah.y', 'witness', '2026-08-21 08:18:48', '2026-08-21 08:18:48'),
(3, 'Parvej', 'parvej@rescue.com', '01900000000', '$2y$10$UHacZYTqkzzRovwowls1fuc41RobBnObJZQkJ8UH5u/zUU9Y/T80W', 'help_seeker', '2026-08-23 05:36:16', '2026-08-23 05:36:16'),
(4, 'Suporna', 'suporna@rescue.com', '01615000000', '$2y$10$9KF9gXFTFbPW1UwEGm5A2epXacKWrMWmjabHNztosJGFy0PAiZsJq', 'volunteer', '2026-08-27 14:12:38', '2026-08-30 11:23:26');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_profiles`
--

CREATE TABLE `volunteer_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `emergency_contact` varchar(100) DEFAULT NULL,
  `availability_status` enum('available','unavailable','currently_rescuing') NOT NULL DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer_profiles`
--

INSERT INTO `volunteer_profiles` (`id`, `user_id`, `address`, `blood_group`, `experience`, `skills`, `emergency_contact`, `availability_status`, `created_at`, `updated_at`) VALUES
(1, 4, 'bashundhara', 'A+', '', 'First Aid,Swimming', '01300000000', 'available', '2026-08-28 15:03:11', '2026-09-01 12:37:02');

-- --------------------------------------------------------

--
-- Table structure for table `witness_reports`
--

CREATE TABLE `witness_reports` (
  `id` int(11) NOT NULL,
  `witness_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `damage_level` varchar(20) NOT NULL DEFAULT 'low',
  `incident_type` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `incident_date` datetime NOT NULL,
  `evidence_file` varchar(255) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `witness_reports`
--

INSERT INTO `witness_reports` (`id`, `witness_id`, `title`, `description`, `damage_level`, `incident_type`, `location`, `incident_date`, `evidence_file`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 'Car Accident', 'Car vs Bike Clash', 'low', 'accident', 'Kuril', '2026-08-29 00:00:00', NULL, 'pending', '2026-08-29 10:39:46', '2026-08-29 10:39:46'),
(3, 2, 'Road Accident', 'A road accident occurred near the main road', 'low', 'accident', 'Main Road', '2026-08-29 00:00:00', NULL, 'pending', '2026-08-29 10:42:18', '2026-08-29 10:42:18'),
(4, 2, 'Flood', 'Flood at feni', 'low', 'flood', 'Feni', '2026-12-12 00:00:00', NULL, 'pending', '2026-08-29 10:47:35', '2026-08-29 10:47:35'),
(5, 2, 'Medical Emergency', 'Suicide', 'low', 'medical', 'Jatrabari', '2026-12-11 00:00:00', 'uploads/witness/witness_2_1788000957_6a92babd16d2b.jpeg', 'pending', '2026-08-29 10:55:57', '2026-08-29 10:55:57'),
(6, 2, 'Gas leakage', 'At residential area', 'medium', 'other', 'Puran Dhaka', '2026-09-01 00:00:00', NULL, 'pending', '2026-09-01 03:42:30', '2026-09-01 03:42:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_transaction_id` (`transaction_id`),
  ADD KEY `donor_id` (`witness_id`);

--
-- Indexes for table `emergency_requests`
--
ALTER TABLE `emergency_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_emergency_help_seeker` (`help_seeker_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_feedback_help_seeker` (`help_seeker_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notifications_admin` (`created_by`);

--
-- Indexes for table `rescue_reports`
--
ALTER TABLE `rescue_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rescue_reports_admin` (`admin_id`);

--
-- Indexes for table `resource_requests`
--
ALTER TABLE `resource_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `volunteer_profiles`
--
ALTER TABLE `volunteer_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `witness_reports`
--
ALTER TABLE `witness_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_witness_reports_user` (`witness_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `emergency_requests`
--
ALTER TABLE `emergency_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rescue_reports`
--
ALTER TABLE `rescue_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `resource_requests`
--
ALTER TABLE `resource_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `volunteer_profiles`
--
ALTER TABLE `volunteer_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `witness_reports`
--
ALTER TABLE `witness_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`witness_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `emergency_requests`
--
ALTER TABLE `emergency_requests`
  ADD CONSTRAINT `fk_emergency_help_seeker` FOREIGN KEY (`help_seeker_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_help_seeker` FOREIGN KEY (`help_seeker_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_admin` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `rescue_reports`
--
ALTER TABLE `rescue_reports`
  ADD CONSTRAINT `fk_rescue_reports_admin` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `volunteer_profiles`
--
ALTER TABLE `volunteer_profiles`
  ADD CONSTRAINT `volunteer_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `witness_reports`
--
ALTER TABLE `witness_reports`
  ADD CONSTRAINT `fk_witness_reports_user` FOREIGN KEY (`witness_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
