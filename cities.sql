-- phpMyAdmin SQL Dump
-- version 5.2.2
-- Host: localhost:3306
-- Generation Time: Jun 01, 2026
-- Server version: 8.0.46
-- PHP Version: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `randevuksa_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint UNSIGNED NOT NULL,
  `name_en` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint UNSIGNED DEFAULT '1',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name_en`, `name_ar`, `country_id`, `status`, `created_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Riyadh', 'الرياض', 1, 1, NULL, NULL, '2026-06-01 00:00:00', '2026-06-01 00:00:00'),
(2, 'Makkah', 'مكة المكرمة', 1, 1, NULL, NULL, '2026-06-01 00:00:00', '2026-06-01 00:00:00'),
(3, 'Madinah', 'المدينة المنورة', 1, 1, NULL, NULL, '2026-06-01 00:00:00', '2026-06-01 00:00:00'),
(4, 'Qassim', 'القصيم', 1, 1, NULL, NULL, '2026-06-01 00:00:00', '2026-06-01 00:00:00'),
(5, 'Eastern', 'الشرقية', 1, 1, NULL, NULL, '2026-06-01 00:00:00', '2026-06-01 00:00:00'),
(6, 'Asir', 'عسير', 1, 1, NULL, NULL, '2026-06-01 00:00:00', '2026-06-01 00:00:00'),
(7, 'Tabuk', 'تبوك', 1, 1, NULL, NULL, '2026-06-01 00:00:00', '2026-06-01 00:00:00'),
(8, 'Hail', 'حائل', 1, 1, NULL, NULL, '2026-06-01 00:00:00', '2026-06-01 00:00:00'),
(9, 'Northern Borders', 'الحدود الشمالية', 1, 1, NULL, NULL, '2026-06-01 00:00:00', '2026-06-01 00:00:00'),
(10, 'Jazan', 'جازان', 1, 1, NULL, NULL, '2026-06-01 00:00:00', '2026-06-01 00:00:00'),
(11, 'Najran', 'نجران', 1, 1, NULL, NULL, '2026-06-01 00:00:00', '2026-06-01 00:00:00'),
(12, 'Al Bahah', 'الباحة', 1, 1, NULL, NULL, '2026-06-01 00:00:00', '2026-06-01 00:00:00'),
(13, 'Al Jouf', 'الجوف', 1, 1, NULL, NULL, '2026-06-01 00:00:00', '2026-06-01 00:00:00');

--
-- Indexes for dumped tables
--

ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- AUTO_INCREMENT for dumped tables
--

ALTER TABLE `cities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
