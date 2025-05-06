-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 09:23 AM
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
-- Database: `toefl`
--

-- --------------------------------------------------------

--
-- Table structure for table `bundler`
--

CREATE TABLE `bundler` (
  `uuid` varchar(40) NOT NULL,
  `id_exam` varchar(40) NOT NULL,
  `id_quest` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bundler`
--

INSERT INTO `bundler` (`uuid`, `id_exam`, `id_quest`) VALUES
('0675777c-a4a4-4085-86c9-fc006bcaec2a', '48eb6bc1-425d-45dc-88cd-f3b0fb9a', '66daa9d5-ddbd-4bf7-a25c-e27f19cc4a'),
('0675777c-a4a4-4085-86c9-fc006bcaec2b', '48eb6bc1-425d-45dc-88cd-f3b0fb9a', '66daa9d5-ddbd-4bf7-a25c-e27f19cc4a7'),
('0675777c-a4a4-4085-86c9-fc006bcaec2c', '48eb6bc1-425d-45dc-88cd-f3b0fb9a', '66daa9d5-ddbd-4bf7-a25c-e27f19cc4a7d'),
('0675777c-a4a4-4085-86c9-fc006bcaec2d', '48eb6bc1-425d-45dc-88cd-f3b0fb9a', '66daa9d5-ddbd-4bf7-a25c-e27f19cc4b');

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `uuid` varchar(40) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(8) NOT NULL,
  `access` timestamp NULL DEFAULT NULL,
  `expired` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`uuid`, `name`, `code`, `access`, `expired`) VALUES
('48eb6bc1-425d-45dc-88cd-f3b0fb9a', 'alung', 'hGS7Gs', '2025-03-22 12:23:38', '2025-03-22 12:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `uuid` varchar(40) NOT NULL,
  `id_question` varchar(40) NOT NULL,
  `options` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`uuid`, `id_question`, `options`) VALUES
('477bc32e-cbe1-4f2b-b7e2-f3e7bfbb240c', '66daa9d5-ddbd-4bf7-a25c-e27f19cc4a7d', 'EKO'),
('9dcd0b2d-666c-48bb-a1f4-12fb7f537574', '66daa9d5-ddbd-4bf7-a25c-e27f19cc4a7d', 'KEO edit'),
('cc232ce1-28fe-4268-a411-c76faf06db52', '66daa9d5-ddbd-4bf7-a25c-e27f19cc4a7d', 'OKE');

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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(4, 'App\\Models\\User', 1232322, 'auth_token', '2c06b58625427d69436151d9ef7bfe496d4f46a544da20a0ba7e9d5b52cdae3b', '[\"*\"]', '2025-03-23 07:56:40', '2025-03-24 04:20:57', '2025-03-23 04:20:57', '2025-03-23 07:56:40'),
(5, 'App\\Models\\User', 1232322, 'auth_token', '0684261afb2709d8c1d4c98ed1378e7cb5062b4c950a064f97631330eb8630d3', '[\"*\"]', '2025-04-15 03:31:58', '2025-04-16 01:58:34', '2025-04-15 01:58:34', '2025-04-15 03:31:58'),
(6, 'App\\Models\\User', 1232322, 'auth_token', '0d06a74f0dbec31aea6138df616f6e7d7e8834646bc2d1730910cc88a1985879', '[\"*\"]', '2025-04-17 01:31:42', '2025-04-17 22:36:28', '2025-04-16 22:36:28', '2025-04-17 01:31:42'),
(7, 'App\\Models\\User', 1232323, 'auth_token', '0b52111f3662bca12c057e65abaaec5928abe007144a2511de1a25dab89a921e', '[\"*\"]', '2025-04-24 00:39:18', '2025-04-24 23:52:50', '2025-04-23 23:52:50', '2025-04-24 00:39:18'),
(8, 'App\\Models\\User', 1232323, 'auth_token', '7250a0dcb80528bdbbe42ae98d788df1f505b37baf926943dbf90468b3578ff3', '[\"*\"]', '2025-04-24 00:14:39', '2025-04-24 23:55:35', '2025-04-23 23:55:35', '2025-04-24 00:14:39'),
(9, 'App\\Models\\User', 1232323, 'auth_token', '58bc263ef86db0564b108c1e98fc5abf80699e48e03f198812982be69a04a12c', '[\"*\"]', '2025-04-28 22:18:29', '2025-04-29 00:47:48', '2025-04-28 00:47:48', '2025-04-28 22:18:29'),
(10, 'App\\Models\\User', 1232323, 'auth_token', '53a5b87fe740921ecf0aeeb0378b093813fa5ccd257bfc4a672288178ce4f45b', '[\"*\"]', '2025-05-05 23:53:44', '2025-05-06 23:39:22', '2025-05-05 23:39:23', '2025-05-05 23:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `quests`
--

CREATE TABLE `quests` (
  `uuid` varchar(40) NOT NULL,
  `question` varchar(255) NOT NULL,
  `type` varchar(40) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `options` varchar(40) NOT NULL,
  `weight` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quests`
--

INSERT INTO `quests` (`uuid`, `question`, `type`, `answer`, `options`, `weight`) VALUES
('66daa9d5-ddbd-4bf7-a25c-e27f19cc4a', 'OKE', 'VOICE', 'OKE', '66daa9d5-ddbd-4bf7-a25c-e27f19cc4a7d', 10),
('66daa9d5-ddbd-4bf7-a25c-e27f19cc4a7', 'OKE', 'TEXT', 'OKE', '66daa9d5-ddbd-4bf7-a25c-e27f19cc4a7d', 10),
('66daa9d5-ddbd-4bf7-a25c-e27f19cc4a7d', 'OKE edit 1', 'TEXT', 'OKE', '66daa9d5-ddbd-4bf7-a25c-e27f19cc4a7d', 10),
('66daa9d5-ddbd-4bf7-a25c-e27f19cc4b', 'OKE', 'VOICE', 'OKE', '66daa9d5-ddbd-4bf7-a25c-e27f19cc4a7d', 10);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `uuid` varchar(40) NOT NULL,
  `id_exam` varchar(40) NOT NULL,
  `id_user` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`uuid`, `id_exam`, `id_user`) VALUES
('af5b1ceb-15de-46fe-a0b1-0d7fd36d55b2', '48eb6bc1-425d-45dc-88cd-f3b0fb9a', '1232323');

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `uuid` varchar(40) NOT NULL,
  `id_exam` varchar(40) NOT NULL,
  `username` varchar(155) NOT NULL,
  `name` varchar(155) NOT NULL,
  `score` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `score`
--

INSERT INTO `score` (`uuid`, `id_exam`, `username`, `name`, `score`, `status`, `created_at`, `updated_at`) VALUES
('ansjdnajsnda', '48eb6bc1-425d-45dc-88cd-f3b0fb9a', '2113020213', 'alung', 100, 'LULUS', '2025-04-24 07:33:26', '2025-04-24 07:33:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'PESERTA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`) VALUES
(1232323, 'pepe', '2113020213', '$2y$10$y9y2h78nDjzoNvo1FJMm3uNzQEQjqyQ7jQayp36xijNfmTKKXPcLS', 'PESERTA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bundler`
--
ALTER TABLE `bundler`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `id_question` (`id_question`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `quests`
--
ALTER TABLE `quests`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `options` (`options`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1232324;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
