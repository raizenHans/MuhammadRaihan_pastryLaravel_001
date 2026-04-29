-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2026 at 10:41 AM
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
-- Database: `laravel_pastry_raihan`
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
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `productable_type` varchar(255) NOT NULL,
  `productable_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `session_id`, `productable_type`, `productable_id`, `product_name`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 'JOYrgDxGUaKpcTAKAN4HK7uFK8ZqGP8TEhtS3cOF', 'App\\Models\\Pastry', 1, 'Croissant Original', 15000.00, 1, 15000.00, '2026-04-29 00:21:50', '2026-04-29 00:21:50'),
(2, 'JOYrgDxGUaKpcTAKAN4HK7uFK8ZqGP8TEhtS3cOF', 'App\\Models\\Pastry', 2, 'Chocolate Danish', 18000.00, 1, 18000.00, '2026-04-29 00:23:36', '2026-04-29 00:23:36'),
(8, 'VL1N09OHCNzsFACLNuYAgzqL0NObWvmEpMGDGdU1', 'App\\Models\\Pastry', 1, 'Croissant Original', 15000.00, 1, 15000.00, '2026-04-29 01:00:28', '2026-04-29 01:00:28');

-- --------------------------------------------------------

--
-- Table structure for table `drinks`
--

CREATE TABLE `drinks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_number` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drinks`
--

INSERT INTO `drinks` (`id`, `product_code`, `product_number`, `name`, `price`, `stock`, `description`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'DRNK002', 2, 'Matcha Frappe', 24000.00, 40, 'Minuman blend matcha Jepang murni', NULL, 1, '2026-04-14 07:39:11', '2026-04-14 07:39:11'),
(3, 'DRNK003', 3, 'Americano', 18000.00, 60, 'Kopi hitam klasik tanpa gula', NULL, 1, '2026-04-14 07:39:11', '2026-04-14 07:39:11'),
(4, 'PRD-260421134', 1, 'Matcha latte Cincau', 30000.00, 50, 'Sangat enak dan sehat', NULL, 1, '2026-04-20 23:10:38', '2026-04-20 23:10:38'),
(5, 'DRNK001', 4, 'Iced Latte', 20000.00, 50, 'Espresso segar dengan susu dingin', NULL, 1, '2026-04-20 23:10:58', '2026-04-20 23:10:58');

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
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `member_code` varchar(50) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `user_id`, `member_code`, `nik`, `phone`, `points`, `created_at`, `updated_at`) VALUES
(1, 3, 'CS0012412345678', '1234567890123456', '081234567891', 190, '2026-04-14 07:39:11', '2026-04-29 00:44:07');

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
(4, '2026_04_14_055616_create_members_tabel', 1),
(5, '2026_04_14_061205_create_pastries_table', 1),
(6, '2026_04_14_061730_create_drinks_table', 1),
(7, '2026_04_14_061757_create_promos_table', 1),
(8, '2026_04_14_061929_create_carts_table', 1),
(9, '2026_04_14_062022_create_transactions_table', 1),
(10, '2026_04_14_062100_create_transaction_detail_table', 1),
(11, '2026_04_16_003200_create_rewards_table', 2),
(12, '2026_04_16_004847_alter_status_columns_on_transactions_table', 3),
(13, '2026_04_21_000001_add_claimed_reward_and_reward_extras', 4),
(14, '2026_04_29_065109_add_deleted_at_to_transactions_table', 5);

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
-- Table structure for table `pastries`
--

CREATE TABLE `pastries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_number` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pastries`
--

INSERT INTO `pastries` (`id`, `product_code`, `product_number`, `name`, `price`, `stock`, `description`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'PSTR001', 2, 'Croissant Original', 15000.00, 60, 'Croissant lembut dengan mentega premium', 'image_produk/nxN47FSXwtYAN8iB7hdh3aQuCSZ4u7TiYraLPt68.png', 1, '2026-04-14 07:39:11', '2026-04-29 01:15:56'),
(2, 'PSTR002', 2, 'Chocolate Danish', 18000.00, 29, 'Danish dengan filling coklat lumer', NULL, 1, '2026-04-14 07:39:11', '2026-04-24 01:07:22'),
(3, 'PSTR003', 3, 'Almond Croissant', 20000.00, 20, 'Croissant dengan taburan almond panggang', NULL, 1, '2026-04-14 07:39:11', '2026-04-14 07:39:11'),
(4, 'PSTR004', 4, 'Apple Pie', 22000.00, 15, 'Pie renyah dengan isian apel kayu manis', NULL, 1, '2026-04-14 07:39:11', '2026-04-14 07:39:11'),
(5, 'PSTR005', 5, 'Tiramisu Cake', 25000.00, 49, 'Kue tiramisu klasik khas Italia', NULL, 1, '2026-04-14 07:39:11', '2026-04-29 00:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_number` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promos`
--

INSERT INTO `promos` (`id`, `product_code`, `product_number`, `name`, `price`, `stock`, `description`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'PRMO001', 1, 'Breakfast Combo', 30000.00, 25, '1 Croissant Original + 1 Iced Latte', NULL, 1, '2026-04-14 07:39:11', '2026-04-14 07:39:11'),
(2, 'PRMO002', 2, 'Sweet Couple', 45000.00, 13, '2 Tiramisu Cake + 1 Americano', NULL, 1, '2026-04-14 07:39:11', '2026-04-24 01:13:04');

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Nama keuntungan, misal: Combo 1',
  `points_required` int(11) NOT NULL COMMENT 'Poin yang dibutuhkan untuk ditukar',
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0 COMMENT '0 = tidak terbatas',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `name`, `points_required`, `description`, `image_path`, `stock`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Combo 1', 70, '2x Produk Promo', NULL, 47, 1, '2026-04-15 17:36:46', '2026-04-28 22:55:33'),
(2, 'Gelas Dessert', 150, '1x Piring/Gelas Dessert Khusus', NULL, 35, 1, '2026-04-15 17:36:46', '2026-04-23 18:49:51');

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
('0lTdyo4q8mQ5VxgTpdzPe2MtJwg0Hft6um1PXfq7', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieTdzQ2cyM3k3RWhSQ0VMN2FPaVJ0VE4zckRqRFljSjFPQk9WMkdvSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dCI7czo1OiJyb3V0ZSI7czo4OiJjaGVja291dCI7fXM6MTE6ImNhcnRfYWN0aXZlIjtiOjE7fQ==', 1777452039),
('Ac84uwqM16sHBW2QbxIitLhTMACgteQLxw3OvBMJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZjZUM2J4QkR2ZjJ5aHNzQjczVEVXZm9HTWVGcjVnMTlrUERpMmw2MyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dCI7czo1OiJyb3V0ZSI7czo4OiJjaGVja291dCI7fXM6MTE6ImNhcnRfYWN0aXZlIjtiOjE7fQ==', 1777449175),
('cI1whXKCgkO9dKf2qbcuz4IMr8lH0GNqTjhFeq8y', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRk84QjMzNXg2SlFIZEtmelpkbUVxZzhlM3VEVGs4U3FJRDRLc2ZPeCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czoxMToiY2FydF9hY3RpdmUiO2I6MTt9', 1777452047),
('CUbPZkGZIIseQmdPzBbzJl8jOCrhjZw3Lrnp4CXm', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRUJaUWxXQ3ZiNTRlRlE1dThBQ3U3eDBoRlVneFFMR3hsS1dWMlo1NSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dCI7czo1OiJyb3V0ZSI7czo4OiJjaGVja291dCI7fXM6MTE6ImNhcnRfYWN0aXZlIjtiOjE7fQ==', 1777448643),
('dBXcpoNpRpzhb98jjmDxe5E7yRyhMRpHaQw7bb0e', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWmVQbXZJaE1UNklJVTNIam1YbHlUckxsQVc0TE5WQmRLeDRmU3JDNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dCI7czo1OiJyb3V0ZSI7czo4OiJjaGVja291dCI7fXM6MTE6ImNhcnRfYWN0aXZlIjtiOjE7fQ==', 1777451978),
('dyfeZEKEsXJm6mxjxwg1skCsRkhi41Jb6LqAIsxE', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUjh4SEg5YVB6RWhKZ0JQS3N6YTZqN0R5WkFEYW5rOFlVclQybEJjUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dCI7czo1OiJyb3V0ZSI7czo4OiJjaGVja291dCI7fXM6MTE6ImNhcnRfYWN0aXZlIjtiOjE7fQ==', 1777451906),
('khFu4GRTzNrsJCJe8UaK6jfJuhBT4BVqf08v4dJ4', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTUJ0cTlHaDI4cVJOWlo3eTBtWUNGYUNZUThSSmgyN2tBeG9ldkpzZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dCI7czo1OiJyb3V0ZSI7czo4OiJjaGVja291dCI7fXM6MTE6ImNhcnRfYWN0aXZlIjtiOjE7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1777447620),
('Km7ynhxhFIMMRhWl5722DZziDw94tgdq1KofvUOp', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWWRDR0k1OE9vNkhickxlMkhteUlxQzdRcm9Db1pJSURpejVWVW85ayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9vcGVyYXRvci9vcmRlcnMvaGlzdG9yeSI7czo1OiJyb3V0ZSI7czoxNjoib3BlcmF0b3IuaGlzdG9yeSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1777447553),
('lndgcpu33KMfPyqTGrjd1yHFkzS7m3oPWD9YeT1V', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS2NpbjBEWTFBZ3dkQ1k4QjZGbXA4NmhHSmNuOU9XbW9GZEVBYXBtVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dCI7czo1OiJyb3V0ZSI7czo4OiJjaGVja291dCI7fXM6MTE6ImNhcnRfYWN0aXZlIjtiOjE7fQ==', 1777452008),
('O22HdgJhJlh7Vdoh07p0QZv7VueSwTdUSI1SVs6C', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWnlxZHJyRzJZU3U4SWhGVlNHRlRLeDFJUjQ2VWRHbjJYVDRmaVNNOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dCI7czo1OiJyb3V0ZSI7czo4OiJjaGVja291dCI7fXM6MTE6ImNhcnRfYWN0aXZlIjtiOjE7fQ==', 1777450008),
('QSzU8ZWH768vGmayPhjle2GBU0x9vv6ORG8ueSbq', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMVRoc3JMaWZwRURjWndLOGVaOVh1aGNjdUhVUDF1c1dmM2lRZW1jaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9vcGVyYXRvci9vcmRlcnMiO3M6NToicm91dGUiO3M6MTU6Im9wZXJhdG9yLm9yZGVycyI7fXM6MTE6ImNhcnRfYWN0aXZlIjtiOjE7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1777451927),
('r1zw2D3xVy1CdbI2ulxyE4vwcfiGfYfh9hIX696x', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ21SdlFrY3JnN0VFRUZWSHZKOEttd0pBREIwVmZ1eGxvUnNseDZIaSI7czoxMToiY2FydF9hY3RpdmUiO2I6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozMDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2NoZWNrb3V0IjtzOjU6InJvdXRlIjtzOjg6ImNoZWNrb3V0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777448050),
('RHLmaWHiZnEDnZRcZMHUEDoiJl28qcC6P3L6KVDX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoickxubGt5aTZtN1lYMjRhSWRQdGJadFVSaGNGVFRIR2tYcHNZRENWbSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dCI7czo1OiJyb3V0ZSI7czo4OiJjaGVja291dCI7fXM6MTE6ImNhcnRfYWN0aXZlIjtiOjE7fQ==', 1777449641);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_code` varchar(50) NOT NULL,
  `member_id` bigint(20) UNSIGNED DEFAULT NULL,
  `operator_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `final_total` decimal(12,2) NOT NULL,
  `paid_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `change_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `earned_points` int(11) NOT NULL DEFAULT 0,
  `redeemed_points` int(11) NOT NULL DEFAULT 0,
  `claimed_reward_id` bigint(20) UNSIGNED DEFAULT NULL,
  `claimed_reward_name` varchar(150) DEFAULT NULL COMMENT 'Snapshot nama hadiah saat diklaim',
  `order_status` enum('pending','diproses','selesai','dibatalkan') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','lunas','gagal') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_code`, `member_id`, `operator_id`, `customer_name`, `total_amount`, `discount`, `final_total`, `paid_amount`, `change_amount`, `earned_points`, `redeemed_points`, `claimed_reward_id`, `claimed_reward_name`, `order_status`, `payment_status`, `payment_method`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'TRX202604140001', NULL, 2, 'Budi (Guest)', 35000.00, 0.00, 35000.00, 35000.00, 0.00, 0, 0, NULL, NULL, 'diproses', 'lunas', 'Midtrans/BRI', '2026-04-14 07:39:11', '2026-04-29 00:29:37', '2026-04-29 00:29:37'),
(2, 'TRX202604140002', 1, 2, 'Azka', 115000.00, 10000.00, 105000.00, 105000.00, 45000.00, 50, 0, NULL, NULL, 'diproses', 'lunas', 'Midtrans BCA (Virtual Account)', '2026-04-14 07:39:11', '2026-04-29 00:27:40', '2026-04-29 00:27:40'),
(3, 'TRX20260416015738205', NULL, 2, 'Raihan', 15000.00, 0.00, 15000.00, 20000.00, 5000.00, 0, 0, NULL, NULL, 'diproses', 'lunas', 'Cash', '2026-04-15 18:57:38', '2026-04-15 19:00:00', NULL),
(4, 'TRX20260416020140313', NULL, 2, 'Roy', 15000.00, 0.00, 15000.00, 20000.00, 5000.00, 0, 0, NULL, NULL, 'diproses', 'lunas', 'Cash', '2026-04-15 19:01:40', '2026-04-15 19:02:12', NULL),
(5, 'TRX20260421002229723', NULL, 2, 'Raihan', 15000.00, 0.00, 15000.00, 20000.00, 5000.00, 0, 0, NULL, NULL, 'diproses', 'lunas', 'Cash', '2026-04-20 17:22:29', '2026-04-20 23:33:46', NULL),
(6, 'TRX20260421071913200', 1, 2, 'Raihan', 105000.00, 10000.00, 95000.00, 100000.00, 5000.00, 50, 0, NULL, NULL, 'diproses', 'lunas', 'Cash', '2026-04-21 00:19:14', '2026-04-21 00:19:55', NULL),
(7, 'TRX20260422052553482', 1, 2, 'Raihan', 15000.00, 0.00, 15000.00, 15000.00, 0.00, 0, 0, NULL, NULL, 'diproses', 'lunas', 'Midtrans BCA (Virtual Account)', '2026-04-21 22:25:53', '2026-04-24 01:18:58', NULL),
(8, 'TRX20260422060905123', 1, 2, 'raihan', 15000.00, 0.00, 15000.00, 15000.00, 0.00, 0, 150, 2, 'Gelas Dessert', 'diproses', 'lunas', 'Midtrans BCA (Virtual Account)', '2026-04-21 23:09:05', '2026-04-24 01:18:22', NULL),
(9, 'TRX20260424014951647', 1, 2, 'Raihan', 15000.00, 0.00, 15000.00, 20000.00, 5000.00, 0, 150, 2, 'Gelas Dessert', 'diproses', 'lunas', 'Cash', '2026-04-23 18:49:51', '2026-04-23 18:51:02', NULL),
(10, 'TRX20260424062047910', 1, 2, 'Raihan', 15000.00, 0.00, 15000.00, 15000.00, 0.00, 0, 70, 1, 'Combo 1', 'diproses', 'lunas', 'Midtrans BCA (Virtual Account)', '2026-04-23 23:20:47', '2026-04-24 01:12:38', NULL),
(11, 'TRX20260424080253764', 1, 2, 'Raihan', 18000.00, 0.00, 18000.00, 20000.00, 2000.00, 0, 70, 1, 'Combo 1', 'diproses', 'lunas', 'Cash', '2026-04-24 01:02:53', '2026-04-24 01:07:22', NULL),
(12, 'TRX20260424081430328', 1, 2, 'Raihan', 30000.00, 0.00, 30000.00, 30000.00, 0.00, 0, 0, NULL, NULL, 'diproses', 'lunas', 'Midtrans BCA (Virtual Account)', '2026-04-24 01:14:30', '2026-04-24 01:15:08', NULL),
(13, 'TRX20260424082051247', 1, 2, 'Raihan', 30000.00, 0.00, 30000.00, 30000.00, 0.00, 0, 0, NULL, NULL, 'diproses', 'lunas', 'Midtrans BCA', '2026-04-24 01:20:51', '2026-04-29 00:24:30', NULL),
(14, 'TRX20260429055533189', 1, 2, 'Raihan', 15000.00, 0.00, 15000.00, 15000.00, 0.00, 0, 70, 1, 'Combo 1', 'diproses', 'lunas', 'Midtrans BCA (Virtual Account)', '2026-04-28 22:55:33', '2026-04-28 22:57:11', NULL),
(15, 'TRX20260429072706641', 1, 2, 'Raihan', 15000.00, 0.00, 15000.00, 15000.00, 0.00, 0, 0, NULL, NULL, 'diproses', 'lunas', 'Midtrans BCA', '2026-04-29 00:27:06', '2026-04-29 00:27:24', NULL),
(16, 'TRX20260429073423721', NULL, 2, 'raihan', 15000.00, 0.00, 15000.00, 15000.00, 0.00, 0, 0, NULL, NULL, 'diproses', 'lunas', 'Midtrans/PERMATA', '2026-04-29 00:34:23', '2026-04-29 00:36:44', NULL),
(17, 'TRX20260429074407874', 1, 2, 'Raihan', 120000.00, 10000.00, 110000.00, 0.00, 0.00, 50, 0, NULL, NULL, 'pending', 'pending', 'Midtrans/QRIS', '2026-04-29 00:44:07', '2026-04-29 00:52:32', '2026-04-29 00:52:32'),
(18, 'TRX20260429075300677', 1, 2, 'Raihan', 30000.00, 0.00, 30000.00, 50000.00, 20000.00, 0, 0, NULL, NULL, 'diproses', 'lunas', 'Cash', '2026-04-29 00:53:00', '2026-04-29 00:54:01', NULL),
(19, 'TRX20260429080044898', 1, 2, 'Raihan', 15000.00, 0.00, 15000.00, 20000.00, 5000.00, 0, 0, NULL, NULL, 'diproses', 'lunas', 'Cash', '2026-04-29 01:00:44', '2026-04-29 01:05:11', NULL),
(20, 'TRX20260429080651379', 1, 2, 'Raihan', 15000.00, 0.00, 15000.00, 15000.00, 0.00, 0, 0, NULL, NULL, 'diproses', 'lunas', 'Midtrans/ONLINE', '2026-04-29 01:06:51', '2026-04-29 01:16:14', '2026-04-29 01:16:14'),
(21, 'TRX20260429083830690', 1, 2, 'Raihan', 30000.00, 0.00, 30000.00, 0.00, 0.00, 0, 0, NULL, NULL, 'pending', 'pending', 'Midtrans/ONLINE', '2026-04-29 01:38:30', '2026-04-29 01:38:47', NULL),
(22, 'TRX20260429083945487', NULL, NULL, 'raihan', 15000.00, 0.00, 15000.00, 0.00, 0.00, 0, 0, NULL, NULL, 'pending', 'pending', NULL, '2026-04-29 01:39:45', '2026-04-29 01:39:45', NULL),
(23, 'TRX20260429084013183', NULL, NULL, 'raihan', 15000.00, 0.00, 15000.00, 0.00, 0.00, 0, 0, NULL, NULL, 'pending', 'pending', NULL, '2026-04-29 01:40:13', '2026-04-29 01:40:13', NULL),
(24, 'TRX20260429084043546', NULL, NULL, 'raihan', 18000.00, 0.00, 18000.00, 0.00, 0.00, 0, 0, NULL, NULL, 'pending', 'pending', NULL, '2026-04-29 01:40:43', '2026-04-29 01:40:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `productable_type` varchar(255) NOT NULL,
  `productable_id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `member_benefit` decimal(12,2) NOT NULL DEFAULT 0.00,
  `final_subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `transaction_id`, `productable_type`, `productable_id`, `product_code`, `product_name`, `quantity`, `unit_price`, `subtotal`, `member_benefit`, `final_subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-14 07:39:11', '2026-04-14 07:39:11'),
(2, 1, 'App\\Models\\Drink', 1, 'DRNK001', 'Iced Latte', 1, 20000.00, 20000.00, 0.00, 20000.00, '2026-04-14 07:39:11', '2026-04-14 07:39:11'),
(3, 2, 'App\\Models\\Promo', 2, 'PRMO002', 'Sweet Couple', 2, 45000.00, 90000.00, 0.00, 90000.00, '2026-04-14 07:39:11', '2026-04-14 07:39:11'),
(4, 2, 'App\\Models\\Pastry', 5, 'PSTR005', 'Tiramisu Cake', 1, 25000.00, 25000.00, 0.00, 25000.00, '2026-04-14 07:39:11', '2026-04-14 07:39:11'),
(5, 3, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-15 18:57:38', '2026-04-15 18:57:38'),
(6, 4, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-15 19:01:40', '2026-04-15 19:01:40'),
(7, 5, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-20 17:22:30', '2026-04-20 17:22:30'),
(8, 6, 'App\\Models\\Pastry', 2, 'PSTR002', 'Chocolate Danish', 5, 18000.00, 90000.00, 0.00, 90000.00, '2026-04-21 00:19:14', '2026-04-21 00:19:14'),
(9, 6, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-21 00:19:14', '2026-04-21 00:19:14'),
(10, 7, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-21 22:25:53', '2026-04-21 22:25:53'),
(11, 8, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-21 23:09:06', '2026-04-21 23:09:06'),
(12, 9, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-23 18:49:51', '2026-04-23 18:49:51'),
(13, 10, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-23 23:20:48', '2026-04-23 23:20:48'),
(14, 11, 'App\\Models\\Pastry', 2, 'PSTR002', 'Chocolate Danish', 1, 18000.00, 18000.00, 0.00, 18000.00, '2026-04-24 01:02:53', '2026-04-24 01:02:53'),
(15, 12, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 2, 15000.00, 30000.00, 0.00, 30000.00, '2026-04-24 01:14:30', '2026-04-24 01:14:30'),
(16, 13, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 2, 15000.00, 30000.00, 0.00, 30000.00, '2026-04-24 01:20:51', '2026-04-24 01:20:51'),
(17, 14, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-28 22:55:33', '2026-04-28 22:55:33'),
(18, 15, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-29 00:27:06', '2026-04-29 00:27:06'),
(19, 16, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-29 00:34:23', '2026-04-29 00:34:23'),
(20, 17, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 8, 15000.00, 120000.00, 0.00, 120000.00, '2026-04-29 00:44:07', '2026-04-29 00:44:07'),
(21, 18, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 2, 15000.00, 30000.00, 0.00, 30000.00, '2026-04-29 00:53:00', '2026-04-29 00:53:00'),
(22, 19, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-29 01:00:44', '2026-04-29 01:00:44'),
(23, 20, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-29 01:06:52', '2026-04-29 01:06:52'),
(24, 21, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 2, 15000.00, 30000.00, 0.00, 30000.00, '2026-04-29 01:38:30', '2026-04-29 01:38:30'),
(25, 22, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-29 01:39:45', '2026-04-29 01:39:45'),
(26, 23, 'App\\Models\\Pastry', 1, 'PSTR001', 'Croissant Original', 1, 15000.00, 15000.00, 0.00, 15000.00, '2026-04-29 01:40:13', '2026-04-29 01:40:13'),
(27, 24, 'App\\Models\\Pastry', 2, 'PSTR002', 'Chocolate Danish', 1, 18000.00, 18000.00, 0.00, 18000.00, '2026-04-29 01:40:43', '2026-04-29 01:40:43');

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
  `role` enum('admin','operator','customer') NOT NULL DEFAULT 'customer',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@pastry.com', NULL, '$2y$12$OORKoezhtMfauMew2cAUXufLqqFu2KWSBqdtdoMqWQIUVGOMmCCdS', 'admin', 1, NULL, '2026-04-14 07:39:11', '2026-04-14 23:50:57'),
(2, 'Op Raihan', 'op@pastry.com', NULL, '$2y$12$zo6LGWavJQ8eug22o7rli.Irzce1u/CunrGHHKqjnR/jLFZUqFr6y', 'operator', 1, NULL, '2026-04-14 07:39:11', '2026-04-15 18:40:54'),
(3, 'Cust Azka', 'azka@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, NULL, '2026-04-14 07:39:11', '2026-04-14 07:39:11'),
(4, 'Raihan Nugraha', 'raihan@pastry.com', NULL, '$2y$12$53jHxoJi8Sqkx0N/6R7/4OXQWC1jcfoJBMk9BuYVyLUyPDtz.yig.', 'admin', 1, NULL, '2026-04-21 00:40:47', '2026-04-21 00:40:47');

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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_productable_type_productable_id_index` (`productable_type`,`productable_id`),
  ADD KEY `carts_session_id_index` (`session_id`);

--
-- Indexes for table `drinks`
--
ALTER TABLE `drinks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `drinks_product_code_unique` (`product_code`);

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
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `members_member_code_unique` (`member_code`),
  ADD UNIQUE KEY `members_nik_unique` (`nik`),
  ADD KEY `members_user_id_foreign` (`user_id`);

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
-- Indexes for table `pastries`
--
ALTER TABLE `pastries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pastries_product_code_unique` (`product_code`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promos_product_code_unique` (`product_code`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_transaction_code_unique` (`transaction_code`),
  ADD KEY `transactions_member_id_foreign` (`member_id`),
  ADD KEY `transactions_operator_id_foreign` (`operator_id`),
  ADD KEY `transactions_claimed_reward_id_foreign` (`claimed_reward_id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_details_transaction_id_foreign` (`transaction_id`),
  ADD KEY `transaction_details_productable_type_productable_id_index` (`productable_type`,`productable_id`);

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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `drinks`
--
ALTER TABLE `drinks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pastries`
--
ALTER TABLE `pastries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_claimed_reward_id_foreign` FOREIGN KEY (`claimed_reward_id`) REFERENCES `rewards` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_operator_id_foreign` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
