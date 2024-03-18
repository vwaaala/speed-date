-- -------------------------------------------------------------
-- TablePlus 5.9.0(538)
--
-- https://tableplus.com/
--
-- Database: larabone
-- Generation Time: 2024-03-15 21:48:47.3280
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dating_events` (`id`, `name`, `happens_on`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'name', '2024-03-13 14:30:00', 'gay', 1, '2024-03-15 14:16:12', '2024-03-15 14:16:12');

INSERT INTO `event_ratings` (`id`, `user_id_from`, `user_id_to`, `event_id`, `rating`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 1, 'yes', '2024-03-15 14:18:07', '2024-03-15 14:18:07'),
(2, 2, 3, 1, 'yes', '2024-03-15 15:12:47', '2024-03-15 15:12:47');

INSERT INTO `event_users` (`id`, `user_id`, `event_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, NULL),
(2, 3, 1, NULL, NULL);

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '2014_10_12_000000_create_users_table', 1),
(9, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(10, '2014_10_12_100000_create_password_resets_table', 1),
(11, '2017_02_20_175730_create_speed_dates_table', 1),
(12, '2019_08_19_000000_create_failed_jobs_table', 1),
(13, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(14, '2024_02_13_110229_create_permission_tables', 1);

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3);

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'permission_show', 'web', '2024-03-15 14:16:11', '2024-03-15 14:16:11'),
(2, 'dashboard', 'web', '2024-03-15 14:16:11', '2024-03-15 14:16:11'),
(3, 'role_create', 'web', '2024-03-15 14:16:11', '2024-03-15 14:16:11'),
(4, 'role_edit', 'web', '2024-03-15 14:16:11', '2024-03-15 14:16:11'),
(5, 'role_delete', 'web', '2024-03-15 14:16:11', '2024-03-15 14:16:11'),
(6, 'role_show', 'web', '2024-03-15 14:16:11', '2024-03-15 14:16:11'),
(7, 'user_create', 'web', '2024-03-15 14:16:11', '2024-03-15 14:16:11'),
(8, 'user_edit', 'web', '2024-03-15 14:16:11', '2024-03-15 14:16:11'),
(9, 'user_delete', 'web', '2024-03-15 14:16:11', '2024-03-15 14:16:11'),
(10, 'user_show', 'web', '2024-03-15 14:16:11', '2024-03-15 14:16:11'),
(11, 'settings_create', 'web', '2024-03-15 14:16:12', '2024-03-15 14:16:12'),
(12, 'settings_edit', 'web', '2024-03-15 14:16:12', '2024-03-15 14:16:12'),
(13, 'settings_delete', 'web', '2024-03-15 14:16:12', '2024-03-15 14:16:12'),
(14, 'settings_show', 'web', '2024-03-15 14:16:12', '2024-03-15 14:16:12'),
(15, 'sd_event_create', 'web', '2024-03-15 14:16:12', '2024-03-15 14:16:12'),
(16, 'sd_event_edit', 'web', '2024-03-15 14:16:12', '2024-03-15 14:16:12'),
(17, 'sd_event_delete', 'web', '2024-03-15 14:16:12', '2024-03-15 14:16:12'),
(18, 'sd_event_show', 'web', '2024-03-15 14:16:12', '2024-03-15 14:16:12'),
(19, 'sd_rating_create', 'web', '2024-03-15 14:16:12', '2024-03-15 14:16:12'),
(20, 'sd_rating_edit', 'web', '2024-03-15 14:16:12', '2024-03-15 14:16:12'),
(21, 'sd_rating_delete', 'web', '2024-03-15 14:16:12', '2024-03-15 14:16:12'),
(22, 'sd_rating_show', 'web', '2024-03-15 14:16:12', '2024-03-15 14:16:12');

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
(1, 'Super Admin', 'web', '2024-03-15 14:16:11', '2024-03-15 14:16:11'),
(2, 'User', 'web', '2024-03-15 14:16:11', '2024-03-15 14:16:11');

INSERT INTO `user_bio` (`id`, `user_id`, `nickname`, `lastname` `city`, `occupation`, `phone`, `birthdate`, `gender`, `looking_for`, `created_at`, `updated_at`) VALUES
(1, 2, 'JDoe', 'JDoe Last', 'New York', 'Software Engineer', '1234567890', '1988-12-13', 'male', 'female', '2024-03-15 14:16:12', '2024-03-15 14:17:30'),
(2, 3, 'JDoe2', 'JDoe2 Last', 'New York', 'Web Designer', '1234567890', '1988-12-13', 'female', 'male', '2024-03-15 14:17:30', '2024-03-15 14:17:30');

INSERT INTO `users` (`id`, `uuid`, `name`, `email`, `email_verified_at`, `avatar`, `status`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '8a7ac52e-78c6-4785-970c-8bdbae715c80', 'Oliver Brown', 'super@bunk3r.net', NULL, 'assets/images/avatar/avatar.jpg', 'pending', '$2y$12$7XqCtm4tJcUzQV3u1EyGgeFJUX2fXXplvpkCXe0GgrV52CeCWg7fu', NULL, '2024-03-15 14:16:11', '2024-03-15 14:16:11', NULL),
(2, '07ca338e-b2ea-49a6-953e-ff03d0493bba', 'John Doesssss', 'users@bunk3r.net', NULL, 'assets/images/avatar/65f46ac6edcc9.jpg', 'pending', '$2y$12$6U9t2XFnYe1hBN65th5jmuJPXSMmqSWoLERChGJrLF3ljvWEDjcxq', NULL, '2024-03-15 14:16:12', '2024-03-15 15:35:34', NULL),
(3, '7a783039-73c0-4763-8f71-9486813f7694', 'Kenedy', 'user1@bunk3r.net', NULL, 'assets/images/avatar/avatar.jpg', 'pending', '$2y$12$c1PNUBsAeoC0WYSAqdHV7OcUfsGbANLtvI/qtgpAclLRSIGbnvE8y', NULL, '2024-03-15 14:17:30', '2024-03-15 14:17:30', NULL);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;