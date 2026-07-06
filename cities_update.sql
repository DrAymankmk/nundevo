SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET NAMES utf8mb4 */;

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
(13, 'Al Jouf', 'الجوف', 1, 1, NULL, NULL, '2026-06-01 00:00:00', '2026-06-01 00:00:00')
ON DUPLICATE KEY UPDATE
  name_en = VALUES(name_en),
  name_ar = VALUES(name_ar),
  country_id = VALUES(country_id),
  status = VALUES(status),
  updated_at = VALUES(updated_at);

ALTER TABLE cities AUTO_INCREMENT = 14;
COMMIT;
