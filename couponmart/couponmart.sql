-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 30, 2025 at 08:56 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `couponmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

DROP TABLE IF EXISTS `businesses`;
CREATE TABLE IF NOT EXISTS `businesses` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `bios` text COLLATE utf8mb3_unicode_ci,
  `user_id` bigint UNSIGNED NOT NULL,
  `town_id` double NOT NULL,
  `location` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `room` varchar(199) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `floor` double DEFAULT NULL,
  `building` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `phone_number` double DEFAULT NULL,
  `verified` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` enum('pending','blacklisted','active') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `businesses_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `businesses`
--

INSERT INTO `businesses` (`id`, `business_name`, `image`, `bios`, `user_id`, `town_id`, `location`, `room`, `floor`, `building`, `phone_number`, `verified`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Quick Deals Ltd', NULL, 'We offer unbeatable discounts on fashion and electronics.', 1, 1, 'Central Plaza', '101', 1, 'Central Towers', 701234567, 'yes', 'active', '2025-08-07 18:17:06', '2025-08-07 18:17:06', NULL),
(7, 'victims', '1736840039.jpg', NULL, 2, 1, 'kenyatta avenue', '0', 2, 'highway towes', 726097138, 'verified', 'active', '2024-03-11 13:46:40', '2025-04-06 13:59:07', NULL),
(8, 'kauseway', NULL, NULL, 3, 1, NULL, NULL, NULL, NULL, 726097139, NULL, 'pending', '2025-08-08 17:27:06', '2025-08-08 17:27:06', NULL),
(9, 'helper investors', '1755212568.jpg', 'testing if things are ok', 9, 1, NULL, '34r', 2, 'highway towers', 72609771399, NULL, 'pending', '2025-08-14 18:43:14', '2025-08-15 08:29:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `business_category`
--

DROP TABLE IF EXISTS `business_category`;
CREATE TABLE IF NOT EXISTS `business_category` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint UNSIGNED NOT NULL,
  `business_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `business_category_category_id_foreign` (`category_id`),
  KEY `business_category_business_id_foreign` (`business_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `business_category`
--

INSERT INTO `business_category` (`id`, `category_id`, `business_id`, `created_at`, `updated_at`) VALUES
(1, 1, 9, NULL, NULL),
(2, 6, 9, NULL, NULL),
(3, 7, 9, NULL, NULL),
(4, 8, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `cat_name`, `created_at`, `updated_at`) VALUES
(1, 'Food & Drinks', '2025-08-07 18:11:18', '2025-08-07 18:11:18'),
(2, 'Fashion', '2025-08-07 18:11:18', '2025-08-07 18:11:18'),
(3, 'Electronics', '2025-08-07 18:11:18', '2025-08-07 18:11:18'),
(4, 'Travel', '2025-08-07 18:11:18', '2025-08-07 18:11:18'),
(5, 'Health', '2025-08-07 18:11:18', '2025-08-07 18:11:18'),
(6, 'Food & Drinks', '2025-08-07 18:17:05', '2025-08-07 18:17:05'),
(7, 'Fashion', '2025-08-07 18:17:05', '2025-08-07 18:17:05'),
(8, 'Electronics', '2025-08-07 18:17:05', '2025-08-07 18:17:05'),
(9, 'Travel', '2025-08-07 18:17:05', '2025-08-07 18:17:05'),
(10, 'Health', '2025-08-07 18:17:05', '2025-08-07 18:17:05');

-- --------------------------------------------------------

--
-- Table structure for table `category_coupon`
--

DROP TABLE IF EXISTS `category_coupon`;
CREATE TABLE IF NOT EXISTS `category_coupon` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint UNSIGNED NOT NULL,
  `coupon_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_coupon_category_id_foreign` (`category_id`),
  KEY `category_coupon_coupon_id_foreign` (`coupon_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `category_coupon`
--

INSERT INTO `category_coupon` (`id`, `category_id`, `coupon_id`, `created_at`, `updated_at`) VALUES
(1, 2, 26, NULL, NULL),
(2, 2, 27, NULL, NULL),
(3, 4, 28, NULL, NULL),
(4, 1, 29, NULL, NULL),
(5, 1, 30, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `business_id` double NOT NULL,
  `cost` double NOT NULL,
  `details` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_vouchers` double NOT NULL,
  `remaining_vouchers` double NOT NULL,
  `image` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `total_view` double DEFAULT NULL,
  `status` enum('pending','active','blacklisted','under review','matured','expired','suspended') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'pending',
  `system_charges` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `rerun` enum('true','false') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `title`, `business_id`, `cost`, `details`, `start_date`, `end_date`, `total_vouchers`, `remaining_vouchers`, `image`, `total_view`, `status`, `system_charges`, `created_at`, `updated_at`, `deleted_at`, `rerun`) VALUES
(1, '50% Off Fashion Items', 1, 100, 'Get 50% discount on all fashion items from Quick Deals.', '2025-08-07', '2025-08-17', 100, 100, NULL, 0, 'active', 10, '2025-08-07 18:17:06', '2025-08-07 18:17:06', NULL, 'false'),
(7, 'testing main', 7, 200, 'just testing', '2024-05-22', '2024-05-31', 300, 300, '1716374750.jpg', 9, '', NULL, '2024-05-22 04:45:11', '2025-01-12 16:15:11', NULL, 'false'),
(8, 'taste twoooo', 7, 300, 'the best offer in town', '2024-05-24', '2024-06-30', 200, 200, NULL, 1, '', NULL, '2024-05-24 11:35:27', '2025-01-12 16:15:11', NULL, 'false'),
(9, 'koupon mambosss', 7, 400, 'testing this products on this webpage', '2024-06-06', '2024-06-30', 200, 200, '1717687026.jpg', 7, '', NULL, '2024-06-06 09:15:00', '2025-02-10 17:44:56', NULL, 'true'),
(10, 'testong', 7, 300, 'asdfjk ak jkashd akj akj kh jkjkdh hsdjk', '2024-06-06', '2024-06-30', 200, 200, '1717687127.jpg', 4, '', NULL, '2024-06-06 09:18:11', '2025-02-25 21:00:28', NULL, 'true'),
(11, 'taste four', 7, 300, 'tasting stuffs', '2024-06-06', '2024-06-30', 20, 20, '1717687197.jpg', 3, '', NULL, '2024-06-06 09:19:39', '2025-02-10 18:08:05', NULL, 'true'),
(12, 'etims club', 7, 200, 'the best seat in the house', '2024-06-07', '2024-06-30', 200, 200, '1717743757.jpg', 22, '', NULL, '2024-06-07 01:02:17', '2025-01-12 16:15:11', NULL, 'false'),
(13, 'teams halves', 7, 200, 'new stuffs', '2024-06-07', '2024-06-30', 300, 300, '1729704453.jpg', 35, '', NULL, '2024-06-07 01:05:33', '2025-01-12 18:55:13', NULL, 'true'),
(14, 'take three', 7, 200, 'the best experience in town', '2024-07-29', '2024-07-31', 300, 300, '1729704640.jpg', 13, '', NULL, '2024-07-29 06:13:02', '2025-01-12 16:15:11', NULL, 'false'),
(15, 'testing this one', 7, 200, 'just tasting things out.', '2024-11-06', '2024-12-29', 300, 298, '1730885214.jpg', 20, '', NULL, '2024-11-06 03:26:06', '2025-01-31 14:48:52', NULL, 'true'),
(16, 'testing guyz not wanted', 7, 200, 'thinking out loudly', '2024-12-24', '2025-01-23', 200, -1708, '1734967747.jpg', 60, 'active', NULL, '2024-12-23 09:16:20', '2025-04-08 14:47:07', NULL, 'false'),
(17, 'teams halves', 7, 200, 'new stuffs', '2025-01-15', '2025-01-31', 300, 298, '1729704453.jpg', 10, 'blacklisted', NULL, '2025-01-12 20:04:09', '2025-02-02 15:24:20', NULL, 'false'),
(18, 'testing this one', 7, 200, 'just tasting things out.', '2025-02-01', '2025-02-12', 300, 300, '1730885214.jpg', NULL, '', NULL, '2025-01-31 14:55:34', '2025-02-10 17:44:34', NULL, 'true'),
(19, 'testing this one', 7, 200, 'just tasting things out.', '2025-02-11', '2025-03-30', 300, 300, '1730885214.jpg', NULL, '', NULL, '2025-02-10 17:44:34', '2025-02-10 17:45:46', NULL, 'true'),
(20, 'koupon mambosss', 7, 400, 'testing this products on this webpage', '2025-02-11', '2025-04-04', 200, 200, '1717687026.jpg', NULL, '', NULL, '2025-02-10 17:44:56', '2025-02-25 20:58:48', NULL, 'true'),
(21, 'testing this one', 7, 200, 'just tasting things out.', '2025-02-11', '2025-02-28', 300, 300, '1730885214.jpg', NULL, '', NULL, '2025-02-10 17:45:46', '2025-02-10 18:07:43', NULL, 'true'),
(22, 'testing this one', 7, 200, 'just tasting things out.', '2025-02-11', '2025-02-28', 300, 292, '1730885214.jpg', 8, 'suspended', NULL, '2025-02-10 18:07:43', '2025-08-18 09:46:45', NULL, 'false'),
(23, 'taste four', 7, 300, 'tasting stuffs', '2025-02-11', '2025-03-31', 20, 11, '1717687197.jpg', 16, 'active', NULL, '2025-02-10 18:08:05', '2025-08-06 08:54:14', NULL, 'false'),
(24, 'koupon mambosss', 7, 400, 'testing this products on this webpage', '2025-03-26', '2025-05-11', 200, 192, '1717687026.jpg', NULL, 'active', NULL, '2025-02-25 20:58:48', '2025-08-06 08:54:14', NULL, 'false'),
(25, 'testong new', 9, 300, 'asdfjk ak jkashd akj akj kh jkjkdh hsdjk', '2025-02-26', '2025-05-09', 200, 200, '1755507514.jpg', 2, 'matured', NULL, '2025-02-25 21:00:28', '2025-03-09 11:22:53', NULL, 'false'),
(26, 'iko ki2 twendes', 8, 200, 'testor to iko ki2', '2025-08-13', '2025-09-12', 20, 20, NULL, NULL, 'pending', NULL, '2025-08-12 14:19:07', '2025-08-12 14:19:07', NULL, 'false'),
(27, 'iko ki2', 8, 200, 'testor to iko ki2', '2025-08-13', '2025-09-12', 20, 20, NULL, NULL, 'active', NULL, '2025-08-12 14:29:02', '2025-08-12 14:29:02', NULL, 'false'),
(28, 'testoe 300', 7, 200, 'testing stuffs', '2025-08-15', '2025-08-23', 20, 20, '1755215133.jpg', NULL, 'active', NULL, '2025-08-14 20:31:35', '2025-08-18 09:10:10', NULL, 'false'),
(29, 'food basket', 9, 2000, 'this basket is composed of two wine bottles, three glasses', '2025-08-20', '2025-09-18', 20, 20, '1755507145.jpg', NULL, 'under review', NULL, '2025-08-18 05:51:29', '2025-08-18 05:52:25', NULL, 'false'),
(30, 'testor coupon', 9, 2000, 'the best coupons', '2025-08-18', '2025-08-18', 30, 30, '1755507514.jpg', NULL, 'under review', NULL, '2025-08-18 05:57:50', '2025-08-18 05:58:33', NULL, 'false');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_suspensions`
--

DROP TABLE IF EXISTS `coupon_suspensions`;
CREATE TABLE IF NOT EXISTS `coupon_suspensions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `coupon_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `reason` text COLLATE utf8mb3_unicode_ci,
  `suspended_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lifted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupon_suspensions_coupon_id_foreign` (`coupon_id`),
  KEY `coupon_suspensions_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `coupon_suspensions`
--

INSERT INTO `coupon_suspensions` (`id`, `coupon_id`, `user_id`, `reason`, `suspended_at`, `lifted_at`, `created_at`, `updated_at`) VALUES
(1, 22, 10, 'just testing', '2025-08-18 09:47:28', NULL, '2025-08-18 09:47:28', '2025-08-18 09:47:28');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

DROP TABLE IF EXISTS `genders`;
CREATE TABLE IF NOT EXISTS `genders` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `gender_name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `gender_name`, `created_at`, `updated_at`) VALUES
(1, 'Male', NULL, NULL),
(2, 'Female', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb3_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(9, '2025_08_07_204739_create_businesses_table', 2),
(8, '2025_08_07_203733_create_categories_table', 2),
(7, '2025_08_07_203700_create_coupons_table', 2),
(10, '2025_08_08_080657_update_coupon_table', 3),
(11, '2025_08_08_102035_create_category_coupon_table', 4),
(12, '2025_08_08_190907_create_towns_table', 5),
(13, '2025_08_09_124653_create_onboarding_steps_table', 6),
(14, '2025_08_13_161743_create_user_profiles_table', 7),
(15, '2025_08_13_210127_create_genders_table', 7),
(16, '2025_08_14_210238_create_business_category_table', 8),
(17, '2025_08_18_102855_create_coupon_suspensions_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9),
(1, 'App\\Models\\User', 10);

-- --------------------------------------------------------

--
-- Table structure for table `onboarding_steps`
--

DROP TABLE IF EXISTS `onboarding_steps`;
CREATE TABLE IF NOT EXISTS `onboarding_steps` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `onboardable_type` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `onboardable_id` bigint UNSIGNED NOT NULL,
  `step_name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `step_order` int UNSIGNED DEFAULT NULL,
  `status` enum('pending','in_progress','completed') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'pending',
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `onboarding_steps_onboardable_type_onboardable_id_index` (`onboardable_type`,`onboardable_id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `onboarding_steps`
--

INSERT INTO `onboarding_steps` (`id`, `onboardable_type`, `onboardable_id`, `step_name`, `step_order`, `status`, `metadata`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 09:16:24', '2025-08-11 09:16:24'),
(2, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 11:20:24', '2025-08-11 11:20:24'),
(3, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 11:50:28', '2025-08-11 11:50:28'),
(4, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 11:51:16', '2025-08-11 11:51:16'),
(5, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 11:52:43', '2025-08-11 11:52:43'),
(6, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 11:55:31', '2025-08-11 11:55:31'),
(7, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 11:56:17', '2025-08-11 11:56:17'),
(8, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 12:00:56', '2025-08-11 12:00:56'),
(9, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 12:01:22', '2025-08-11 12:01:22'),
(10, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 12:01:43', '2025-08-11 12:01:43'),
(11, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 12:04:20', '2025-08-11 12:04:20'),
(12, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 12:05:21', '2025-08-11 12:05:21'),
(13, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 15:01:23', '2025-08-11 15:01:23'),
(14, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 15:10:37', '2025-08-11 15:10:37'),
(15, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 15:11:15', '2025-08-11 15:11:15'),
(16, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 15:43:45', '2025-08-11 15:43:45'),
(17, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 15:44:54', '2025-08-11 15:44:54'),
(18, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 15:48:01', '2025-08-11 15:48:01'),
(19, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 15:48:19', '2025-08-11 15:48:19'),
(20, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 15:48:57', '2025-08-11 15:48:57'),
(21, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 16:02:13', '2025-08-11 16:02:13'),
(22, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 16:03:58', '2025-08-11 16:03:58'),
(23, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 16:05:40', '2025-08-11 16:05:40'),
(24, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 16:06:22', '2025-08-11 16:06:22'),
(25, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 16:06:34', '2025-08-11 16:06:34'),
(26, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 16:06:36', '2025-08-11 16:06:36'),
(27, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 16:06:38', '2025-08-11 16:06:38'),
(28, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 16:06:40', '2025-08-11 16:06:40'),
(29, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 16:07:25', '2025-08-11 16:07:25'),
(30, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 16:07:46', '2025-08-11 16:07:46'),
(31, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 16:08:34', '2025-08-11 16:08:34'),
(32, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 16:39:36', '2025-08-11 16:39:36'),
(33, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 16:41:01', '2025-08-11 16:41:01'),
(34, 'App\\Models\\Business', 8, 'Profile Completion', 1, 'pending', NULL, '2025-08-11 17:05:20', '2025-08-11 17:05:20'),
(35, 'App\\Models\\Business', 9, 'Profile Completion', 1, 'completed', NULL, '2025-08-14 18:43:14', '2025-08-14 18:43:14'),
(36, 'App\\Models\\Business', 9, 'Profile Completion', 3, 'pending', NULL, '2025-08-14 18:46:11', '2025-08-14 18:46:11'),
(37, 'App\\Models\\Business', 9, 'Profile Completion', 3, 'pending', NULL, '2025-08-14 18:46:44', '2025-08-14 18:46:44'),
(38, 'App\\Models\\Business', 9, 'Profile Completion', 1, 'pending', NULL, '2025-08-14 19:24:56', '2025-08-14 19:24:56');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', NULL, NULL),
(2, 'business', 'web', NULL, NULL),
(3, 'customer', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb3_unicode_ci,
  `payload` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('dP6m8J62UeWsc3b41qTF9dg67grZrmWFKtE7aG0J', 9, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVU84cnJCNnc5eEFMVFdYWWhTb2htTmg0YXRhMEhabVh4UGhwY0Q4WiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODg6Imh0dHA6Ly9jb3Vwb25zLmtlL2FkbWluL2NvdXBvbnMvcmVydW4vMjU/X3Rva2VuPVVPOHJyQjZ3OXhBTFRXWFloU29obU5oNGF0YTBIWm1YeFBocGNEOFoiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5O30=', 1758565038);

-- --------------------------------------------------------

--
-- Table structure for table `towns`
--

DROP TABLE IF EXISTS `towns`;
CREATE TABLE IF NOT EXISTS `towns` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `town_name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `towns`
--

INSERT INTO `towns` (`id`, `town_name`, `created_at`, `updated_at`) VALUES
(1, 'Nakuru', NULL, NULL),
(3, 'Nairobi', '2024-03-28 22:04:33', '2024-03-28 22:04:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Business Owner', 'business@example.comm', '2025-08-07 18:03:51', '$2y$12$8xD1.yKD5Luf.VxSLg7q.OrttgDnBGL9afGykNTmfT/uTo3JSxyNm', 'lXy3LMqHQM', '2025-08-07 18:03:52', '2025-08-07 18:03:52'),
(2, 'Business Owner', 'business@example.com', '2025-08-07 18:17:05', '$2y$12$iiyo/KbttdSeRsBItxxqb.1OEX4O4qeNrAbV3usrPc7ed8nrdOPX2', 'CmMDZYD1wJ', '2025-08-07 18:17:06', '2025-08-07 18:17:06'),
(10, NULL, 'admin@gmail.com', NULL, '$2y$12$DQ9ij4jv8pUwoVPrlbfOxub9jZrTNOF1P4sQ2zK7e0Ikyh4oXbJ7G', NULL, '2025-08-15 08:39:26', '2025-08-15 08:39:26'),
(4, NULL, 'testor@gmail.com', NULL, '$2y$12$ByQIBd/HbcP0KM8b6EbCeu8xJSjaXyihOtpZFqIgAU71xtsaKHyrC', NULL, '2025-08-14 11:18:01', '2025-08-14 11:18:01'),
(5, NULL, 'hoppers@gmail.com', NULL, '$2y$12$G65zu9/KLkY3f8uhFvzFOuLDWAwSflmmpCrld5T115JDtPMiKXbHW', NULL, '2025-08-14 11:27:27', '2025-08-14 11:27:27'),
(6, NULL, 'hopperrs@gmail.com', NULL, '$2y$12$lEx.xp0lYgC4dR4f4lNaduFQrqLAazQtAdpzzwAuC7ftArdikKJru', NULL, '2025-08-14 11:39:23', '2025-08-14 11:39:23'),
(7, NULL, 'iko@gmail.com', NULL, '$2y$12$L7UuhIzZRBrwriRkLzsxJeXWVdn9xGI0.ZAa7YOiIN3TuUAAcVuGq', NULL, '2025-08-14 11:42:05', '2025-08-14 11:42:05'),
(8, NULL, 'iko@gmail.comm', NULL, '$2y$12$m9NAuqDaKC4PGEz42SFIWuthjnODEDCw05J8jlTMfniCIBNODX/su', NULL, '2025-08-14 11:56:12', '2025-08-14 11:56:12'),
(9, NULL, 'helpers@gmail.com', NULL, '$2y$12$RK.YfOs9ZN0pjvPnFym8n.Fnh1fadIepmgp0o7NxjGe7toNa.Q3PG', NULL, '2025-08-14 18:42:25', '2025-08-14 18:42:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `town_id` bigint UNSIGNED NOT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` enum('pending','blacklisted','active') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_profiles_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `first_name`, `last_name`, `image`, `user_id`, `phone_number`, `town_id`, `gender`, `status`, `created_at`, `updated_at`) VALUES
(1, 'the', 'apples', '1755192595.jpg', 8, '0726097139', 1, 'male', 'pending', '2025-08-14 12:25:29', '2025-08-14 14:29:54'),
(2, 'the', 'apples', NULL, 8, '07260971399', 1, 'male', 'pending', '2025-08-14 12:30:26', '2025-08-14 12:30:26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
