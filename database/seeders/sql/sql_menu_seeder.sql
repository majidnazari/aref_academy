-- phpMyAdmin SQL Dump
-- version 5.2.0-dev+20210910.83091680cc
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 16, 2022 at 07:21 AM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `academy`
--

-- --------------------------------------------------------

--
-- Table structure for table `group_menu`
--

CREATE TABLE `group_menu` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id_creator` bigint UNSIGNED NOT NULL,
  `group_id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_menu`
--

INSERT INTO `group_menu` (`id`, `user_id_creator`, `group_id`, `menu_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 1, 1, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(2, 0, 2, 2, 2, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(3, 0, 3, 3, 3, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(4, 0, 4, 4, 4, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(5, 0, 5, 5, 5, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(6, 0, 1, 6, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(7, 0, 1, 7, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(8, 0, 1, 8, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(9, 0, 1, 9, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(10, 0, 1, 10, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(11, 0, 1, 11, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(12, 0, 1, 12, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(13, 0, 2, 10, 2, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(14, 0, 2, 7, 2, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(15, 0, 2, 12, 2, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(16, 0, 2, 9, 2, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(18, 0, 3, 7, 2, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(19, 0, 3, 10, 2, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(20, 0, 1, 13, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(21, 0, 2, 13, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(22, 0, 3, 13, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(23, 0, 4, 13, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(24, 0, 1, 14, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(25, 0, 2, 14, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(26, 0, 4, 14, 1, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(28, 0, 4, 10, 2, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(NULL,0,1,18,1, '2022-08-16 08:34:51', '2022-08-16 08:34:51', NULL),
(NULL,0,3,18,1, '2022-08-16 08:34:51', '2022-08-16 08:34:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int UNSIGNED NOT NULL,
  `slug` enum('link','dropdown') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'link',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `href` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `slug`, `name`, `icon`, `href`, `parent_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'link', 'داشبورد ادمین', 'DashboardIcon', '/admin', 0, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(2, 'link', 'داشبورد مدیر آموزشگاه', 'DashboardIcon', '/manager', 0, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(3, 'link', 'داشبورد مالی', 'DashboardIcon', '/financial', 0, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(4, 'link', 'داشبورد پذیرنده', 'DashboardIcon', '/teacher', 0, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(5, 'link', 'داشبورد دبیر', 'DashboardIcon', '/acceptor', 0, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(6, 'link', 'مدیریت کاربران', 'ShoppingCartIcon', '/users', 0, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(7, 'link', 'مدیریت کلاس‌ها', 'ClassIcon', '/courses', 0, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(8, 'link', 'سال تحصیلی فعال', 'ReceiptLongIcon', '/years', 0, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(9, 'link', 'تعریف تخلفات', 'NewReleasesIcon', '/faults', 0, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(10, 'link', 'فهرست دانش آموزان', 'PeopleIcon', '/students', 0, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(11, 'link', 'مدیریت شعبه‌ها', 'AddBusinessIcon', '/branches', 0, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(12, 'link', 'مدیریت دروس', 'MenuBookIcon', '/lessons', 0, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(13, 'link', 'گزارش کلاسها', 'BarChartIcon', '/reports/courses', 0, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(14, 'link', 'حضوروغیاب', 'CoPresentIcon', '/absence-presences', 0, '2022-05-23 08:41:54', '2022-05-23 08:41:54', NULL),
(NULL, 'link', 'گزارش مالی', 'BarChartIcon', '/reports/financial', 16, '2022-08-16 08:34:51', '2022-08-16 08:34:51', NULL);
--
-- Indexes for dumped tables
--

--
-- Indexes for table `group_menu`
--
ALTER TABLE `group_menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_menu_user_id_group_id_menu_id_unique` (`user_id`,`group_id`,`menu_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group_menu`
--
ALTER TABLE `group_menu`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;