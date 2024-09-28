-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2024 at 09:42 AM
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
-- Database: `car_rent`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `car_type` varchar(255) NOT NULL,
  `daily_rent_price` decimal(8,2) NOT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT 1,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `name`, `brand`, `model`, `year`, `car_type`, `daily_rent_price`, `availability`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Toyota Camry', 'Toyota', 'Corolla', 2015, 'Sedan', 2500.00, 0, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTR9pLOuDgKjkBEmiuRpOv2mz7dDxZjFQ4vjULhVuWsSSHpKm48_qWH4QR368HYGT1rS2Y&usqp=CAU', '2024-09-21 15:23:31', '2024-09-28 01:41:39'),
(2, 'Honda City', 'Honda', 'City', 2018, 'Sedan', 3000.00, 0, 'uploads/1-1727412048-download (3).jfif', '2024-09-21 18:13:42', '2024-09-27 22:25:58'),
(4, 'Suzuki', 'fdfdfd', 'fdfdf', 2020, 'Suzuku', 2500.00, 0, 'uploads/1-1727070544-download.jfif', '2024-09-22 23:49:04', '2024-09-28 00:42:19'),
(5, 'Suzuki Celerio', 'Suzuki', 'Celerio', 2019, 'Hatchback', 2070.00, 0, 'uploads/1-1727070710-download.jfif', '2024-09-22 23:51:50', '2024-09-26 22:29:40'),
(6, 'Ciaz', 'Suzuki', '2018', 2018, 'Sedan', 4000.00, 0, 'uploads/8-1727501414-download (5).jfif', '2024-09-26 22:39:58', '2024-09-28 01:04:42'),
(7, 'Indigo', 'Tata', '2015', 2015, 'Sedan', 3500.00, 1, 'uploads/1-1727412171-download (4).jfif', '2024-09-26 22:42:51', '2024-09-26 22:42:51'),
(8, 'Hyundai i10', 'Hyundai', 'i10', 2017, 'Hatchback', 3500.00, 1, 'uploads/8-1727503562-download (6).jfif', '2024-09-28 00:06:02', '2024-09-28 00:06:02'),
(9, 'Nissan X-Trail', 'Nissan', 'X-Trail', 2015, 'SUV', 5000.00, 1, 'uploads/8-1727503696-download (7).jfif', '2024-09-28 00:08:16', '2024-09-28 00:08:16');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2024_09_17_044454_create_users_table', 1),
(5, '2024_09_18_170952_create_users_table', 2),
(6, '2024_09_18_173454_create_cars_table', 3),
(7, '2024_09_19_062827_create_rentals_table', 3),
(8, '2024_09_19_172707_create_rentals_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `car_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_cost` decimal(8,2) NOT NULL,
  `status` enum('Pending','Ongoing','Completed','Canceled') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`id`, `user_id`, `car_id`, `start_date`, `end_date`, `total_cost`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2024-09-25', '2024-09-25', 2500.00, 'Completed', '2024-09-24 09:25:09', '2024-09-25 23:10:19'),
(2, 2, 1, '2024-09-26', '2024-09-27', 5000.00, 'Completed', '2024-09-24 09:40:28', '2024-09-27 21:30:05'),
(6, 4, 5, '2024-09-27', '2024-09-29', 6210.00, 'Ongoing', '2024-09-25 23:11:45', '2024-09-26 22:29:40'),
(7, 2, 1, '2024-09-28', '2024-09-28', 2500.00, 'Ongoing', '2024-09-26 11:59:57', '2024-09-28 01:41:39'),
(8, 4, 2, '2024-10-03', '2024-10-05', 9000.00, 'Pending', '2024-09-26 22:30:10', '2024-09-26 22:30:10'),
(11, 2, 2, '2024-09-28', '2024-09-29', 6000.00, 'Ongoing', '2024-09-27 12:58:33', '2024-09-27 22:25:58'),
(14, 2, 6, '2024-09-30', '2024-10-01', 8000.00, 'Pending', '2024-09-28 00:47:09', '2024-09-28 00:47:09'),
(17, 15, 6, '2024-09-28', '2024-09-28', 4000.00, 'Ongoing', '2024-09-28 01:04:34', '2024-09-28 01:04:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `otp`, `role`, `created_at`, `updated_at`) VALUES
(2, 'Jesmin Jaman', 'akhterjahanjesmin1973@gmail.com', 'abc', '01714250255', 'Mohammadpur,Dhaka', '', 'customer', '2024-09-20 17:48:39', '2024-09-27 09:23:47'),
(3, 'MD. Kamruzzaman Mukta', 'karuzzamanmukta@gmail.com', 'acb', '01711355858', 'Dhaka', '0', 'customer', '2024-09-21 00:31:12', '2024-09-22 12:15:23'),
(4, 'Asif Jaman', 'asifjaman@gmail.com', '12ac', '01753677323', 'Dhanmondi,Dhaka', '0', 'customer', '2024-09-21 01:42:51', '2024-09-21 01:42:51'),
(8, 'Nujhat Tanzim', 'nujhattanzim@gmail.com', 'ab123', '01749535100', 'Amlapara,Pirojpur', '0', 'admin', '2024-09-28 05:28:58', '2024-09-28 05:28:58'),
(15, 'jesmin jesmin', 'jesminjaman49@gmail.com', 'ab', '01714250255', 'Dhanmondi,Dhaka', '0', 'customer', '2024-09-28 01:04:01', '2024-09-28 01:05:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rentals_user_id_foreign` (`user_id`),
  ADD KEY `rentals_car_id_foreign` (`car_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rentals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
