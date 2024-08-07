-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 07, 2024 at 01:09 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yoexto`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers_form_expressions`
--

CREATE TABLE `answers_form_expressions` (
  `id` bigint UNSIGNED NOT NULL,
  `form_expression_id` bigint UNSIGNED NOT NULL,
  `nis` text NOT NULL,
  `name` text NOT NULL,
  `absen` int NOT NULL,
  `expression` text NOT NULL,
  `because` text NOT NULL,
  `target` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_expressions`
--

CREATE TABLE `form_expressions` (
  `id` bigint UNSIGNED NOT NULL,
  `day` text NOT NULL,
  `date` datetime NOT NULL,
  `caption` longtext NOT NULL,
  `slug` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nis_students`
--

CREATE TABLE `nis_students` (
  `id` bigint UNSIGNED NOT NULL,
  `nis` text NOT NULL,
  `name` text NOT NULL,
  `absen` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nis_students`
--

INSERT INTO `nis_students` (`id`, `nis`, `name`, `absen`) VALUES
(3193400286, '21,5931', 'Hassan', 2),
(7382735728, '21,5932', 'Imam', 3),
(9434563454, '21,5935', 'Husein', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(5043078077, 'anggelika', '$argon2i$v=19$m=65536,t=4,p=1$MzZRcUZEYURGNnA4M3U2Wg$GOByaXuprzyachOL3FnGfFrKeFCV4rGU4xzIF2gsY3Q', 'guru', '2024-08-02 18:18:24', '2024-08-02 18:18:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers_form_expressions`
--
ALTER TABLE `answers_form_expressions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_form_expressions_form_expression_id_foreign` (`form_expression_id`);

--
-- Indexes for table `form_expressions`
--
ALTER TABLE `form_expressions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nis_students`
--
ALTER TABLE `nis_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers_form_expressions`
--
ALTER TABLE `answers_form_expressions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8794667704;

--
-- AUTO_INCREMENT for table `form_expressions`
--
ALTER TABLE `form_expressions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8829301221;

--
-- AUTO_INCREMENT for table `nis_students`
--
ALTER TABLE `nis_students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9434563455;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5043078078;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers_form_expressions`
--
ALTER TABLE `answers_form_expressions`
  ADD CONSTRAINT `answers_form_expressions_form_expression_id_foreign` FOREIGN KEY (`form_expression_id`) REFERENCES `form_expressions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
