-- -------------------------------------------------------------
-- TablePlus 5.9.0(538)
--
-- https://tableplus.com/
--
-- Database: larabone
-- Generation Time: 2024-03-20 04:33:49.7530
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `dating_events`;
CREATE TABLE `dating_events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `happens_on` timestamp NOT NULL,
  `type` enum('gay','straight') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'straight',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `event_ratings`;
CREATE TABLE `event_ratings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id_from` bigint unsigned NOT NULL,
  `user_id_to` bigint unsigned NOT NULL,
  `event_id` bigint unsigned NOT NULL,
  `rating` enum('yes','no','maybe') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_ratings_user_id_from_user_id_to_event_id_unique` (`user_id_from`,`user_id_to`,`event_id`),
  KEY `event_ratings_user_id_to_foreign` (`user_id_to`),
  KEY `event_ratings_event_id_foreign` (`event_id`),
  CONSTRAINT `event_ratings_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `dating_events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_ratings_user_id_from_foreign` FOREIGN KEY (`user_id_from`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_ratings_user_id_to_foreign` FOREIGN KEY (`user_id_to`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `event_users`;
CREATE TABLE `event_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `event_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_users_user_id_foreign` (`user_id`),
  KEY `event_users_event_id_foreign` (`event_id`),
  CONSTRAINT `event_users_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `dating_events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `pat_tokenable_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `user_bio`;
CREATE TABLE `user_bio` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `nickname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `occupation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `gender` enum('both','female','male') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'female',
  `looking_for` enum('both','female','male') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'male',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_bio_user_id_foreign` (`user_id`),
  CONSTRAINT `user_bio_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '/assets/images/avatar/avatar.jpg',
  `status` enum('pending','active','inactive','banned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dating_events` (`id`, `name`, `happens_on`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'name', '2013-03-24 00:00:00', 'straight', 0, '2024-03-16 06:22:40', '2024-03-16 13:40:09'),
(2, 'Test 1', '2024-03-20 00:00:00', 'gay', 1, '2024-03-18 13:58:19', '2024-03-18 13:58:19'),
(3, 'Test Event Tomorrow', '2024-03-21 00:00:00', 'gay', 1, '2024-03-19 19:12:27', '2024-03-19 19:12:27'),
(4, 'Test Event Day After Tomorrow', '2024-03-22 00:00:00', 'gay', 1, '2024-03-19 19:13:53', '2024-03-19 19:13:53'),
(5, 'Test Event After Tomorr asd s ad', '2024-03-28 00:00:00', 'gay', 1, '2024-03-19 20:16:55', '2024-03-19 20:16:55');

INSERT INTO `event_ratings` (`id`, `user_id_from`, `user_id_to`, `event_id`, `rating`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 1, 'yes', '2024-03-16 07:25:54', '2024-03-16 14:34:50'),
(6, 2, 6, 1, 'no', '2024-03-16 18:03:35', '2024-03-16 18:03:35'),
(7, 2, 7, 1, 'maybe', '2024-03-16 18:03:40', '2024-03-16 18:03:40'),
(8, 8, 9, 2, 'maybe', '2024-03-18 15:30:14', '2024-03-18 15:41:51'),
(9, 9, 8, 2, 'yes', '2024-03-18 15:30:39', '2024-03-18 15:30:39'),
(10, 3, 2, 1, 'yes', '2024-03-19 19:00:45', '2024-03-19 19:00:45'),
(11, 3, 4, 1, 'maybe', '2024-03-19 19:00:49', '2024-03-19 19:00:49'),
(12, 3, 5, 1, 'no', '2024-03-19 19:00:53', '2024-03-19 19:00:53'),
(13, 10, 11, 3, 'yes', '2024-03-19 19:22:22', '2024-03-19 19:22:22'),
(14, 11, 10, 3, 'maybe', '2024-03-19 20:09:57', '2024-03-19 20:09:57');

INSERT INTO `event_users` (`id`, `user_id`, `event_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, NULL),
(2, 3, 1, NULL, NULL),
(3, 4, 1, NULL, NULL),
(4, 5, 1, NULL, NULL),
(5, 6, 1, NULL, NULL),
(6, 7, 1, NULL, NULL),
(7, 8, 2, NULL, NULL),
(8, 9, 2, NULL, NULL),
(9, 10, 3, NULL, NULL),
(10, 11, 3, NULL, NULL),
(11, 10, 4, NULL, NULL),
(12, 11, 4, NULL, NULL),
(13, 10, 5, NULL, NULL),
(14, 11, 5, NULL, NULL);

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2017_02_20_175730_create_speed_dates_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2024_02_13_110229_create_permission_tables', 1);

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 10),
(2, 'App\\Models\\User', 11);

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'permission_show', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(2, 'dashboard', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(3, 'role_create', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(4, 'role_edit', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(5, 'role_delete', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(6, 'role_show', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(7, 'user_create', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(8, 'user_edit', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(9, 'user_delete', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(10, 'user_show', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(11, 'settings_create', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(12, 'settings_edit', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(13, 'settings_delete', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(14, 'settings_show', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(15, 'sd_event_create', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(16, 'sd_event_edit', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(17, 'sd_event_delete', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(18, 'sd_event_show', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(19, 'sd_rating_create', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(20, 'sd_rating_edit', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(21, 'sd_rating_delete', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(22, 'sd_rating_show', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40');

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(8, 2),
(9, 1),
(10, 1),
(10, 2),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(18, 2),
(19, 1),
(19, 2),
(20, 1),
(21, 1),
(22, 1);

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40'),
(2, 'User', 'web', '2024-03-16 06:22:40', '2024-03-16 06:22:40');

INSERT INTO `user_bio` (`id`, `user_id`, `nickname`, `lastname`, `city`, `occupation`, `phone`, `birthdate`, `gender`, `looking_for`, `created_at`, `updated_at`) VALUES
(1, 2, 'JDoe', 'JDoe last', 'New York', 'Software Engineer', '1234567890', '1988-12-20', 'male', 'female', '2024-03-16 06:22:40', '2024-03-16 18:22:16'),
(2, 3, 'JDoe', 'JDoe Last', 'New York', 'Web Designer', '1234567890', '1988-12-13', 'female', 'male', '2024-03-16 07:23:22', '2024-03-16 07:23:22'),
(3, 4, 'JDoe', 'JDoe last', 'New York', 'Software Engineer', '1234567890', '1988-12-13', 'male', 'both', '2024-03-16 15:30:58', '2024-03-16 15:30:58'),
(4, 5, 'JDoe', 'JDoe Last', 'New York', 'Web Designer', '1234567890', '1988-12-13', 'male', 'both', '2024-03-16 15:30:59', '2024-03-16 16:21:00'),
(5, 6, 'JDoe', 'JDoe Last', 'New York', 'Web Designer', '1234567890', '1988-12-13', 'female', 'male', '2024-03-16 15:30:59', '2024-03-16 15:30:59'),
(6, 7, 'JDoe', 'JDoe Last', 'New York', 'Web Designer', '1234567890', '1988-12-13', 'female', 'both', '2024-03-16 15:30:59', '2024-03-16 15:30:59'),
(7, 8, 'newuser nicknameJDoe', 'new user lastnameJDoe last', 'New York', 'Software Engineer', '1234567890', '1988-12-13', 'female', 'female', '2024-03-18 13:58:37', '2024-03-18 15:30:03'),
(8, 9, 'newuser nicknameJDoe', 'new user lastnameJDoe last', 'New York', 'Software Engineer', '1234567890', '1988-12-13', 'female', 'male', '2024-03-18 15:24:35', '2024-03-18 15:24:35'),
(9, 10, 'newuser nicknameJDoe', 'new user lastnameJDoe last', 'New York', 'Software Engineer', '1234567890', '1988-12-13', 'male', 'female', '2024-03-19 19:12:49', '2024-03-19 20:17:03'),
(10, 11, 'newuser nicknameJDoe', 'new user lastnameJDoe last', 'New York', 'Software Engineer', '1234567890', '1988-12-13', 'female', 'male', '2024-03-19 19:12:49', '2024-03-19 19:12:49');

INSERT INTO `users` (`id`, `uuid`, `name`, `email`, `email_verified_at`, `avatar`, `status`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '8a6f784d-bf09-435c-8542-dce5b17e5d7c', 'Robin', 'super@bunk3r.net', NULL, 'assets/images/avatar/65f5d702c11d5.jpg', 'pending', '$2y$12$t8hylkuMzEc8GLktF1W3b.rtG2eNgh/XVrT5yi9A.8c7m44rn9BKe', NULL, '2024-03-16 06:22:40', '2024-03-16 17:29:38', NULL),
(2, 'c6a4ed5d-50f5-44fc-baf7-269fb7fcd63f', 'John Doe', 'users@bunk3r.net', NULL, 'assets/images/avatar/65f5a0da4a2da.jpg', 'pending', '$2y$12$y.PwoWaUJMQK86CZmyt1FuKvwTbZFuJKPIhuozOoYYBhFmY2M1g.y', NULL, '2024-03-16 06:22:40', '2024-03-16 15:30:58', NULL),
(3, 'c2f2b1d4-3316-4c4a-9204-393986e8daa3', 'Kenedy', 'user1@bunk3r.net', NULL, 'assets/images/avatar/65f5a0b4ab314.jpg', 'pending', '$2y$12$TkhvrW6irVmXiH1/HA/yoehbbrTmiefB5G3XW.xZpRdPLynZc1Utq', NULL, '2024-03-16 07:23:22', '2024-03-16 15:30:59', NULL),
(4, '7f7f6953-4551-43f8-8a16-2069d2ff1012', 'John Doe', 'user5@bunk3r.net', NULL, '/assets/images/avatar/avatar.jpg', 'pending', '$2y$12$dSdz1c32cCRuDocOlpTbQ.GzthaCBbbBsKbLOVKbLaYcDsOqvFtuW', NULL, '2024-03-16 15:30:58', '2024-03-16 15:30:58', NULL),
(5, 'ae5e8dff-a3c0-44a0-ac0b-2ad3c3aa48e9', 'Kenedy', 'user2@bunk3r.net', NULL, '/assets/images/avatar/avatar.jpg', 'pending', '$2y$12$6R8u1dAb3FZggtvLU5nIcuCte9s9Uul6PfM1OHsN6Nl4WE8hJNp86', NULL, '2024-03-16 15:30:59', '2024-03-16 15:30:59', NULL),
(6, '743770d7-d8dc-47e1-8574-9556061a6052', 'Kenedy', 'user3@bunk3r.net', NULL, '/assets/images/avatar/avatar.jpg', 'pending', '$2y$12$lSO/2KM/PR9Fu6NI02LUU.4GCpTBVQB0lNKY7pS/1mCx673.Yzz8u', NULL, '2024-03-16 15:30:59', '2024-03-16 15:30:59', NULL),
(7, '81a8b27a-def8-4340-967a-f76d38cd628e', 'Kenedy', 'user4@bunk3r.net', NULL, '/assets/images/avatar/avatar.jpg', 'pending', '$2y$12$ZSEf3EmOAU3nhBgGV0sRH.SrEi4Oi8WF9JaeMYOk2hnIas26rK5ve', NULL, '2024-03-16 15:30:59', '2024-03-16 15:30:59', NULL),
(8, 'b296f538-aed0-46b6-bcde-a90e10a14771', 'New User Full Name', 'newuseremail@bunk3r.net', NULL, 'assets/images/avatar/65f85dbd6fc80.png', 'pending', '$2y$12$AvtfQ13nltqsqELXeyYDGeROsGOwY8FIXUAApcrSlwEGXoezUElim', NULL, '2024-03-18 13:58:37', '2024-03-19 22:32:08', '2024-03-19 22:32:08'),
(9, '5634751d-b2f8-40e7-9390-4cf94b92dbbf', 'New User Full Name', 'newusearemail@bunk3r.net', NULL, '/assets/images/avatar/avatar.jpg', 'pending', '$2y$12$0i8s8UgLWfAGpV5dH6l2neU6eaS1uXaqpweTB8jhdhEvqI4i7OPzG', NULL, '2024-03-18 15:24:35', '2024-03-19 22:32:17', '2024-03-19 22:32:17'),
(10, '1a148dc1-1b3e-4a23-a7c4-444c66ee48f6', 'New User Full Name', 'yieoyo@gmail.com', NULL, '/assets/images/avatar/avatar.jpg', 'pending', '$2y$12$3ECZ24TcqbajcUMygWO5rOnvqCUZDjcymCX.4BHcQ2C7wM.6289MK', NULL, '2024-03-19 19:12:49', '2024-03-19 20:17:03', NULL),
(11, '24e6163e-49ad-43d0-9954-703ec5b60344', 'New User Full Name', 'mehrabahmedsaurav@gmail.com', NULL, '/assets/images/avatar/avatar.jpg', 'pending', '$2y$12$uoc0kQt4g9jdoBhUmv4rO.yAQpchuW6kRDstdCi7wzBDItLdbaGbO', NULL, '2024-03-19 19:12:49', '2024-03-19 20:17:03', NULL);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;