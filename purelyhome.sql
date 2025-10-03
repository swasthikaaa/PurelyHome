-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2025 at 10:54 AM
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
-- Database: `purelyhome`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('purelyhome-cache-67b380c7f8aa595abde19a93067ba674', 'i:1;', 1759129104),
('purelyhome-cache-67b380c7f8aa595abde19a93067ba674:timer', 'i:1759129104;', 1759129104),
('purelyhome-cache-a60694f350534928d288994838ecb43e', 'i:1;', 1759127267),
('purelyhome-cache-a60694f350534928d288994838ecb43e:timer', 'i:1759127267;', 1759127267),
('purelyhome-cache-c508cde39e9e25b99b49e79d3149fdc5', 'i:1;', 1759122197),
('purelyhome-cache-c508cde39e9e25b99b49e79d3149fdc5:timer', 'i:1759122197;', 1759122197);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Cleaning Essentials', '2025-09-11 10:40:43', '2025-09-11 10:40:43'),
(2, 'Kitchenware', '2025-09-11 10:40:43', '2025-09-11 10:40:43'),
(3, 'Home Decor', '2025-09-11 10:40:43', '2025-09-11 10:40:43');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_06_151110_create_phones_table', 1),
(5, '2025_09_06_151120_create_categories_table', 1),
(6, '2025_09_06_151130_create_products_table', 1),
(7, '2025_09_06_151160_create_carts_table', 1),
(8, '2025_09_06_151162_create_cart_items_table', 1),
(9, '2025_09_06_151165_create_orders_table', 1),
(10, '2025_09_06_151167_create_order_items_table', 1),
(11, '2025_09_06_151650_create_payments_table', 1),
(12, '2025_09_06_171637_create_personal_access_tokens_table', 1),
(13, '2025_09_10_173900_add_login_otp_to_users_table', 1),
(14, '2025_09_11_165550_add_status_to_users_table', 2),
(15, '2025_09_14_133139_add_offer_price_to_products_table', 3),
(16, '2025_09_28_232552_add_two_factor_enabled_to_users_table', 4);

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
  `name` text NOT NULL,
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
(4, 'App\\Models\\User', 6, 'api_token', '9c5b3c1da106631067ad2d481a3659f29045b41090e4f02b40fe4c845dfc6f34', '[\"*\"]', NULL, NULL, '2025-09-12 08:11:07', '2025-09-12 08:11:07'),
(11, 'App\\Models\\User', 6, 'login-token', '36804a2752dc35b6464f50a486e11c307bc0cca3f3d7821979de1e088c07f18f', '[\"*\"]', NULL, NULL, '2025-09-13 08:56:04', '2025-09-13 08:56:04'),
(14, 'App\\Models\\User', 6, 'login-token', '98f0a71b530984ec8b64fb4cb10c4032cd2acae301755e6e99eaa497302bb336', '[\"*\"]', NULL, NULL, '2025-09-13 10:49:41', '2025-09-13 10:49:41'),
(16, 'App\\Models\\User', 6, 'login-token', '2201ae9cbe7fea803c8504bbde89c05eb3f38e12a82f27d984101bf0338f3c1e', '[\"*\"]', NULL, NULL, '2025-09-14 07:49:05', '2025-09-14 07:49:05'),
(18, 'App\\Models\\User', 7, 'login-token', '1e36419d6b236aa63e52238188e19a5f1747476c32af44993f4d2a024069ea2c', '[\"*\"]', NULL, NULL, '2025-09-14 12:18:10', '2025-09-14 12:18:10'),
(19, 'App\\Models\\User', 6, 'api_token', '5909df5d08da2c76930edad2d441b6e97bf533d91cd8f7ff85cbec24c917fe67', '[\"*\"]', NULL, NULL, '2025-09-14 22:22:19', '2025-09-14 22:22:19'),
(21, 'App\\Models\\User', 6, 'login-token', '012143d25cbf4666ea019c8e3672a416c12d68f90fc00de83535f93d955cdc94', '[\"*\"]', NULL, NULL, '2025-09-15 00:02:36', '2025-09-15 00:02:36'),
(23, 'App\\Models\\User', 6, 'login-token', '972831870225ea681863dbf09ba54530ca72054971cbfd50a99823a5827cecf3', '[\"*\"]', NULL, NULL, '2025-09-15 00:06:19', '2025-09-15 00:06:19'),
(24, 'App\\Models\\User', 6, 'login-token', 'a90c8717d40c480f0fad79e168fde8f5f72e4d07af381c13271ab4359c13d3f5', '[\"*\"]', NULL, NULL, '2025-09-15 00:13:57', '2025-09-15 00:13:57'),
(25, 'App\\Models\\User', 7, 'login-token', 'a33480fb29ef52e7312f43efbd80085d9daea98337d8e308558b868a442778ff', '[\"*\"]', NULL, NULL, '2025-09-15 00:25:47', '2025-09-15 00:25:47'),
(27, 'App\\Models\\User', 6, 'login-token', '097f35736a9a18d1d47528e3988d4273372437f942cc68a132f79905c142485a', '[\"*\"]', NULL, NULL, '2025-09-15 00:54:32', '2025-09-15 00:54:32'),
(28, 'App\\Models\\User', 6, 'login-token', 'd9bacc39e810fdd04a5b2e6f6b77631d311083473f7d53a292075cd05d42a76b', '[\"*\"]', NULL, NULL, '2025-09-15 06:59:35', '2025-09-15 06:59:35'),
(29, 'App\\Models\\User', 8, 'login-token', '92acb722849a61ebe34566283333650c4bba84ad254302007a34b2901618611e', '[\"*\"]', NULL, NULL, '2025-09-15 07:03:34', '2025-09-15 07:03:34'),
(30, 'App\\Models\\User', 8, 'login-token', '3081224c08e5376191c9ffef30010f6f793474a2198fda9ceff312e8d2f62f7e', '[\"*\"]', NULL, NULL, '2025-09-15 07:14:30', '2025-09-15 07:14:30'),
(33, 'App\\Models\\User', 6, 'login-token', '0b307f2476ee78a611bbaae454304516f5aa80f6bdef9d55a13f11290bc562b9', '[\"*\"]', NULL, NULL, '2025-09-15 12:03:28', '2025-09-15 12:03:28'),
(34, 'App\\Models\\User', 6, 'login-token', '8a6fdbaa88f881695ed1ae65c2bff8b06fc906c232f82234209a10afbfba237c', '[\"*\"]', NULL, NULL, '2025-09-15 12:07:48', '2025-09-15 12:07:48'),
(35, 'App\\Models\\User', 8, 'login-token', '16f3be2116e5fa4d5e0b4148ecf4500724f8652237dd93e12ba350d579627190', '[\"*\"]', NULL, NULL, '2025-09-15 12:09:03', '2025-09-15 12:09:03'),
(36, 'App\\Models\\User', 8, 'login-token', '2d5aa2d72b9a55429e652978231bc4f1b5d3ef98bfd9410d06a89b00b9e91d25', '[\"*\"]', NULL, NULL, '2025-09-15 12:10:11', '2025-09-15 12:10:11'),
(37, 'App\\Models\\User', 6, 'login-token', '72f6cb2ef53573e98f2d0264e2d1ded45aae292528dc98af3d4cf081e66c713f', '[\"*\"]', NULL, NULL, '2025-09-15 12:11:20', '2025-09-15 12:11:20'),
(38, 'App\\Models\\User', 8, 'login-token', '3dd630e119cdf5ad24a04fd3b7487480ae81c3ed4911ed1049af2d46ba3e2b37', '[\"*\"]', NULL, NULL, '2025-09-15 12:13:38', '2025-09-15 12:13:38'),
(39, 'App\\Models\\User', 6, 'login-token', 'e0aca446a93fcda57e97020e02149ba2298c6c1282a2c9b719b8a2b0d0c42621', '[\"*\"]', NULL, NULL, '2025-09-16 09:00:01', '2025-09-16 09:00:01'),
(40, 'App\\Models\\User', 6, 'login-token', 'b80308de357f34f8deee99deed6c9fcb4db29e89cebf19037669ad447ada8fc7', '[\"*\"]', NULL, NULL, '2025-09-16 09:01:18', '2025-09-16 09:01:18'),
(41, 'App\\Models\\User', 6, 'login-token', '97917e3fbab5c1762e86a599f8575c194416a1be9ae096fd66b6e7bf7d81cfc9', '[\"*\"]', NULL, NULL, '2025-09-16 11:10:26', '2025-09-16 11:10:26'),
(42, 'App\\Models\\User', 6, 'login-token', 'f6ee946d23e9c65a2acf5fd51af6b03265a82e560262ae36266325a2da8fd999', '[\"*\"]', NULL, NULL, '2025-09-16 23:48:56', '2025-09-16 23:48:56'),
(43, 'App\\Models\\User', 6, 'login-token', '95631673fbcc9c746e450f4b5d8d24be263e7689fe7aa109ecd7a89a405ddb78', '[\"*\"]', NULL, NULL, '2025-09-17 00:00:23', '2025-09-17 00:00:23'),
(44, 'App\\Models\\User', 6, 'login-token', '5eaf16c0d70bcc683f86f2810ca1adfc6f37c4f7eb2186064018887db0e0f70f', '[\"*\"]', NULL, NULL, '2025-09-17 10:56:28', '2025-09-17 10:56:28'),
(45, 'App\\Models\\User', 6, 'login-token', '791ce3cb86bdea06f6e1154eeb3447be9ec6bfb77b92798aa24be92bf851057e', '[\"*\"]', NULL, NULL, '2025-09-18 00:11:28', '2025-09-18 00:11:28'),
(47, 'App\\Models\\User', 6, 'login-token', '47697f7598a11c9215a43bc4fd078ab0e7265ceff02f092e4ccb1fa221de237c', '[\"*\"]', NULL, NULL, '2025-09-18 08:42:27', '2025-09-18 08:42:27'),
(50, 'App\\Models\\User', 6, 'login-token', 'b7282899fc1a32642bb850883bd6acb1f87e65e62baa19063fc9972ddd0177b9', '[\"*\"]', NULL, NULL, '2025-09-19 14:43:30', '2025-09-19 14:43:30'),
(53, 'App\\Models\\User', 6, 'login-token', 'ac9d0ccdaf1ffc9f0c8d0d3334a5410106772a1e1e8b0f18a953990f54262375', '[\"*\"]', NULL, NULL, '2025-09-20 17:28:17', '2025-09-20 17:28:17'),
(54, 'App\\Models\\User', 6, 'login-token', '59e4253495d26a00100ccb397e9890e45125d1d0ab737c87a96acc51093a0956', '[\"*\"]', NULL, NULL, '2025-09-21 09:33:50', '2025-09-21 09:33:50'),
(55, 'App\\Models\\User', 9, 'login-token', '3a95c7d4db428d6b054a6699550532a19d06cbc319632737f33c318f930065bb', '[\"*\"]', NULL, NULL, '2025-09-21 09:45:31', '2025-09-21 09:45:31'),
(81, 'App\\Models\\User', 10, 'api_token', '97f55fa5ee7ac1e3922f4ba25f98160f8b73d705994fa84bcdf3e330f3d2f20f', '[\"*\"]', NULL, NULL, '2025-09-22 17:08:20', '2025-09-22 17:08:20'),
(106, 'App\\Models\\User', 10, 'login-token', '347b07399fd21eda426374079bef511d6dcba51bb3eef890868393806ea86375', '[\"*\"]', NULL, NULL, '2025-09-24 15:34:14', '2025-09-24 15:34:14'),
(107, 'App\\Models\\User', 10, 'login-token', '39db588efd8e52727546c4ee6c805308fdbb61df74500f66bf19b8a6e1a8b652', '[\"*\"]', NULL, NULL, '2025-09-24 15:34:53', '2025-09-24 15:34:53'),
(108, 'App\\Models\\User', 10, 'login-token', 'c9999c73014d23d69555519b81419e592068dd8c520a5ab09fdfcd60ab7c3238', '[\"*\"]', NULL, NULL, '2025-09-24 15:45:58', '2025-09-24 15:45:58'),
(109, 'App\\Models\\User', 10, 'login-token', 'd47e807f0916a8439732a65362e2cb21efd774a1fd72c34d6789fd9995b8c548', '[\"*\"]', NULL, NULL, '2025-09-24 15:49:40', '2025-09-24 15:49:40'),
(110, 'App\\Models\\User', 10, 'login-token', '3039aabfc9ba17d67818b0f3eb4030cc6bfba4219a53d1bb2f6524fa830eae69', '[\"*\"]', NULL, NULL, '2025-09-24 15:58:26', '2025-09-24 15:58:26'),
(111, 'App\\Models\\User', 10, 'login-token', '2e35880f64c4a97d6ee1e8e1d77f27e50d93983df463cb3310e489c57969105c', '[\"*\"]', NULL, NULL, '2025-09-24 16:35:24', '2025-09-24 16:35:24'),
(148, 'App\\Models\\User', 12, 'login-token', '2a6227e8fd6e8da3551c123176bbdf338e556a5105d1d9356398632eb27e0e59', '[\"*\"]', NULL, NULL, '2025-09-27 11:33:21', '2025-09-27 11:33:21'),
(149, 'App\\Models\\User', 12, 'login-token', '51b966955a6e43577594f3ea8072192f535427a35fac033e4ad0192087cbee07', '[\"*\"]', NULL, NULL, '2025-09-27 11:33:50', '2025-09-27 11:33:50'),
(150, 'App\\Models\\User', 13, 'login-token', '723f3289ffad182b8e37685ba7f3de8ddedb6dec875772d2b7cfc074a9b98282', '[\"*\"]', NULL, NULL, '2025-09-27 12:52:01', '2025-09-27 12:52:01'),
(151, 'App\\Models\\User', 14, 'login-token', 'c970b05339bcc5813de195edc859c05162b9315396ca41dfded63bbb7b24134a', '[\"*\"]', NULL, NULL, '2025-09-27 13:04:31', '2025-09-27 13:04:31'),
(152, 'App\\Models\\User', 15, 'login-token', 'fe168086f260858d6cece46568dfee56720131784fe510319a56e58eb6d175b5', '[\"*\"]', NULL, NULL, '2025-09-27 13:45:27', '2025-09-27 13:45:27'),
(155, 'App\\Models\\User', 20, 'login-token', '938d98b5dcf36fb6f2332248b9c0e6dc8b9997b53e0ec712893b31b87fdf7429', '[\"*\"]', NULL, NULL, '2025-09-27 14:34:25', '2025-09-27 14:34:25'),
(168, 'App\\Models\\User', 24, 'login-token', '23d9096bea27e20b2f26ffe1dd4eda2aadd8e65cfaeab49924cdc68b69f86123', '[\"*\"]', NULL, NULL, '2025-09-29 04:16:34', '2025-09-29 04:16:34'),
(169, 'App\\Models\\User', 24, 'login-token', 'e0605eba2de104e5f7f7bc1c1818c21eb3c0781a9554e98cdb2148c35a7d28ca', '[\"*\"]', NULL, NULL, '2025-09-29 04:57:33', '2025-09-29 04:57:33'),
(170, 'App\\Models\\User', 24, 'login-token', '5ea9346b5589c53bb035792236bea53a7a000a15ec12b7f50441e7a94bf23e5b', '[\"*\"]', NULL, NULL, '2025-09-29 04:57:57', '2025-09-29 04:57:57'),
(171, 'App\\Models\\User', 24, 'login-token', '3afdd2a5e0bd66c6d48baa06ddeb241b002c34b08b6446ff6f06f91ef67ce781', '[\"*\"]', NULL, NULL, '2025-09-29 04:59:49', '2025-09-29 04:59:49'),
(172, 'App\\Models\\User', 24, 'login-token', '3a882fcc135b8283e20045af050e34c3b964750a6a13a0372d2a6870ca589f21', '[\"*\"]', NULL, NULL, '2025-09-29 05:01:13', '2025-09-29 05:01:13'),
(173, 'App\\Models\\User', 24, 'login-token', '5be96dea8551816736a3d6b780dab19722f3cb4e0af7ae08ca5f24e6a4743863', '[\"*\"]', NULL, NULL, '2025-09-29 05:01:49', '2025-09-29 05:01:49'),
(175, 'App\\Models\\User', 24, 'login-token', '6214563f4b6a15b46f04b7cd492ea2f84a1a51570ecf5554a43f0dcc929b045c', '[\"*\"]', NULL, NULL, '2025-09-29 05:04:02', '2025-09-29 05:04:02'),
(176, 'App\\Models\\User', 24, 'login-token', 'd2b4eeca75529cec83988955505d3af6f8c23f999f49a27d12ed57ebb201c41d', '[\"*\"]', NULL, NULL, '2025-09-29 05:09:30', '2025-09-29 05:09:30'),
(177, 'App\\Models\\User', 24, 'login-token', '76f4fb91abfb663aec570f240f7fae046f35173db5f3a78aff8c5cace5c74c4b', '[\"*\"]', NULL, NULL, '2025-09-29 05:11:18', '2025-09-29 05:11:18'),
(178, 'App\\Models\\User', 24, 'login-token', '19058454ec56df71c34e4e546251ee2a1ebf85254c31be6a24b91fa79dbb4086', '[\"*\"]', NULL, NULL, '2025-09-29 06:26:48', '2025-09-29 06:26:48'),
(181, 'App\\Models\\User', 11, 'api_token', '5bdae2f3e713d86f90ccd071ce12388b25182f41f8b333615138df03ccfe89db', '[\"*\"]', '2025-10-03 07:40:49', NULL, '2025-10-03 07:40:21', '2025-10-03 07:40:49'),
(182, 'App\\Models\\User', 1, 'api_token', '451979109dd20c96600f5205dbfecbc269d0fb01cf9c8ed8768cdf5d5ad0a3e6', '[\"*\"]', '2025-10-03 08:51:40', NULL, '2025-10-03 07:41:39', '2025-10-03 08:51:40');

-- --------------------------------------------------------

--
-- Table structure for table `phones`
--

CREATE TABLE `phones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `price` decimal(10,2) NOT NULL,
  `offer_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `admin_id`, `name`, `slug`, `description`, `quantity`, `price`, `offer_price`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 1, 1, 'Rubber Gloves (pair)', 'rubber-gloves-pair', 'Durable cleaning glove, protects hands during harsh cleaning.', 8, 190.00, 150.00, 'products/rfnz3sS2hjnHOPZKHHrV2rtoYxEF96gmNygZ39qN.jpg', 1, '2025-09-11 10:40:43', '2025-09-29 04:24:32'),
(4, 1, 1, 'Universal Foam Home Cleaner with Brush (Leather/Fabric safe)', 'suscipit-ggMEIA', 'Multipurpose foam cleaner + attached brush head for spot cleaning upholstery or fabric.', 8, 1241.00, 1050.00, 'products/cEw3KYVHeXOMwrWruRi5lkSvshFFWHtsiyKfgTnr.jpg', 1, '2025-09-11 10:40:43', '2025-09-21 17:41:54'),
(6, 1, 1, 'Glass & Window Cleaner Spray (500 ml)', 'ratione-GgvzAR', 'Streak-free formula for windows, mirrors.', 17, 755.00, 600.00, 'products/PM897woH5h7ljl4gL4Fy6PKKIxtlybKsWPt5pToL.jpg', 1, '2025-09-11 10:40:43', '2025-09-25 17:33:43'),
(8, 1, 1, 'Furniture Polish (450 ml)', 'furniture-polish-450-ml', 'Polish to restore sheen on wood furniture, protect surfaces.', 0, 2100.00, 1700.00, 'products/dF33cAzQlFxCL9M3QwKbSKjZa2wOzrpMuijathJn.jpg', 1, '2025-09-11 10:40:43', '2025-09-28 12:33:45'),
(10, 3, 1, 'Table Lamp (Barclay / Epoxy / Art Style)', 'fugit-987oWk', 'Decorative table lamp with accent base & shade—adds mood lighting and decor flair. \nfinez.lk', 1, 4300.00, 4000.00, 'products/A2aZxEdoSLrHgdIGdEQGGzfGnuNTE80sAsB7BNAp.jpg', 1, '2025-09-11 10:40:43', '2025-09-28 12:41:52'),
(11, 2, 1, '5-in-1 Cast Aluminium Cookware Set (Harvest brand)', '5-in-1-cast-aluminium-cookware-set-harvest-brand', 'Set of 5 pots/pans with lids; stackable; ideal for small kitchens.', 10, 16995.00, 12500.00, 'products/AQsvgmLHIZsittOuCYpOTh9TU1f3rqlLu7VL0uHG.jpg', 1, '2025-09-12 01:45:53', '2025-09-27 07:08:34'),
(42, 3, 1, 'Modern Floral Painting Wall Art', 'modern-floral-painting-wall-art', 'A framed floral motif painting, modern colours; suits living room or bedroom accent.', 10, 11900.00, 9900.00, 'products/XKVGO1oMkhX8BL1Kl7SFmGljFKnimhInId7QVffL.jpg', 1, '2025-09-28 16:54:14', '2025-09-28 16:54:53'),
(43, 3, 1, 'Lion Wall Art (Wood / Composite)', 'lion-wall-art-wood-composite', 'Decorative panel showing a lion motif; decent size for hallway or feature wall.', 14, 6900.00, 5500.00, 'products/tzyV7GH0Eyee3snRzcME8BudlkpG1e6cyyzZIrbZ.jpg', 1, '2025-09-28 17:09:41', '2025-09-28 17:09:41'),
(44, 3, 1, 'Natural Ceramic Vase with Holder', 'natural-ceramic-vase-with-holder', 'Indoor planter / vase with metal stand; stylish for small plants. Good for tabletops or corners.', 8, 2450.00, 2000.00, 'products/qZrMKHHfwhMdKKcmfGT8jXwkJfE9W2WrrbDTwrDa.jpg', 1, '2025-09-28 17:11:03', '2025-09-28 17:11:03'),
(46, 2, 1, 'Automatic Rechargeable Water Dispenser (for jugs/water bottles)', 'automatic-rechargeable-water-dispenser-for-jugswater-bottles', 'Portable, USB-charging dispenser; useful where running water dispensing is needed.', 17, 1395.00, 1150.00, 'products/UvV4sRMYN956cpimqivwK912LQcHQuLe9EQrTr96.jpg', 1, '2025-09-28 17:15:05', '2025-09-28 17:15:05'),
(47, 2, 1, '24 cm Marble-Coated Frying Pan with Lid', '24-cm-marble-coated-frying-pan-with-lid', 'Non-stick pan, looks upscale; ideal for general frying.', 10, 4945.00, 4200.00, 'products/Ipb639tNlSwuuQ8TqOmnxoUTUSCVbPgQojXfeIHR.jpg', 1, '2025-09-28 17:16:54', '2025-09-28 17:16:54'),
(48, 3, 1, 'Edited)', 'edited', 'Durable cleaning glove, protects hands during harsh cleaning tasks', 8, 190.00, 150.00, 'products/kPUDkrrFxOiiDOF64W6u6omRlj5uHVWBSegFhlRs.jpg', 1, '2025-09-28 17:18:09', '2025-10-03 08:27:30'),
(49, 2, 1, '4-Tier Adjustable Kitchen Trolley (rolling storage cart)', '4-tier-adjustable-kitchen-trolley-rolling-storage-cart', 'A mobile storage/trolley with 4 shelves; helps organize kitchen tools, spices, small appliances and create extra counter/storage space. Useful in smaller kitchens.', 10, 7500.00, 6300.00, 'products/29h1tLCM9v5Vijj6zXtu0RScVDHnJaPQMsAMyNTa.jpg', 1, '2025-09-28 17:27:06', '2025-09-28 17:27:06'),
(52, 1, 1, 'Telescopic/Long-Handle Dust Cleaner Brush', 'telescopiclong-handle-dust-cleaner-brush', 'A brush with a long handle (adjustable telescopically) to clean high or hard-to-reach surfaces (ceiling corners, ceiling fan blades, high shelves). Good to reduce strain on back & shoulders.', 5, 1950.00, 1600.00, 'products/a6L7as0Ekg2a6lb2uTQw4NTTUMkVqq8Vu3CVMYFS.jpg', 1, '2025-09-28 17:41:13', '2025-09-28 17:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7tn4nTtXNbSVdL4JFit1BoFcauZORoHGEVvCg7RM', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoieVdUenJ2c0hyRmhNa2pZUUpjU2FLZ0pSbm5qc1AxTjBwUndzTENWTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9vcmRlcnMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTA6ImF1dGhfdG9rZW4iO3M6NTI6IjE3NHxoQWczZjFoQ29KMUhONm1XN2RIQlB4NmMwMnFzQnRBOVFnWDA0YXFyYjFlOWJiNjYiO30=', 1759128940),
('nfH5bpDs3Qgjp0lAr5uPUKLe4kTh3b98HNemQ1sC', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSXQzRVJDMnlVb3VHZVNrdjBsbTAwVVMyM2p1STRDOFNZSUt1MFA5QiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1759477180),
('r6fhomsvwnRlRDV5MpXfeMZCOhVXr5LAqXo1FhjW', 11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoieG5PN3M2S0lsbDlOaFlEM3FMbVpVZEF3SG9LRlZCdFYwWEdORzA5UiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJFJWazBwc3ZkR2xyVDQ3UzFXMzJqNk9OSkNOS243TmpCalMvY3NZMzd3eDR4c2VxM1FEcXd5Ijt9', 1759129083),
('RZ62pz8iOga6ZEpKxSEzTOuOkE54e0zUmJHNa0ap', NULL, '127.0.0.1', 'PostmanRuntime/7.48.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSHF1ZmJrWnExOURtcWtSWkk5UXFoVWtWYnNlOXlrUW1wb2pscmhXdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvYWRtaW4tb3JkZXJzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1759481462);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `login_otp` varchar(255) DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `otp_expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `status`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`, `login_otp`, `two_factor_enabled`, `otp_expires_at`) VALUES
(1, 'Admin User', 'admin@purelyhome.com', '2025-09-11 10:40:42', '$2y$12$9gx94/bxmcrsGGnzsi6hq.PzKVw9dEZ72mYJ24Iz4RKr8ly2XRgca', 'admin', 'active', NULL, NULL, NULL, '2025-09-11 10:40:42', '2025-09-11 10:40:42', NULL, 0, NULL),
(11, 'Swasthika', 'swasthikalingaraj@gmail.com', NULL, '$2y$12$RVk0psvdGlrT47S1W32j6ONJCNKn7NjBjS/csY37wx4xseq3QDqwy', 'customer', 'active', 'f7yB1ENf86yvDB9gb3beEKtLQu6Spx8SSNzs0YXBAmlE7MyGGHLtaQ81L8Kk', NULL, NULL, '2025-09-24 17:56:00', '2025-09-29 06:57:25', '199672', 0, '2025-09-29 07:02:25'),
(24, 'Yash', 'yashnick514@gmail.com', NULL, '$2y$12$vH.jO9rBDrFWe.bAI6O.lu6kUit8LX/krLW6KyYD3Z9K.0J26o.Gi', 'customer', 'active', NULL, NULL, NULL, '2025-09-29 04:16:21', '2025-09-29 06:54:55', '437431', 0, '2025-09-29 06:31:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phones_user_id_foreign` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_status_index` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `phones`
--
ALTER TABLE `phones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `phones`
--
ALTER TABLE `phones`
  ADD CONSTRAINT `phones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
