-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th8 23, 2020 lúc 06:50 PM
-- Phiên bản máy phục vụ: 8.0.19
-- Phiên bản PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `facebook_game`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cate_gears`
--

CREATE TABLE `cate_gears` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `z_index` int NOT NULL DEFAULT '1',
  `animation` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cate_gears`
--

INSERT INTO `cate_gears` (`id`, `name`, `description`, `z_index`, `animation`, `created_at`, `updated_at`) VALUES
(1, 'Giáp', 'Không', 3, '', NULL, NULL),
(2, 'Vũ Khí', NULL, 5, '', '2020-01-12 03:48:15', '2020-01-12 03:48:15'),
(3, 'Mũ', NULL, 3, '', '2020-01-12 03:48:23', '2020-01-12 03:48:23'),
(4, 'Vũ Khí Phụ', NULL, 5, NULL, '2020-01-12 03:48:39', '2020-01-12 03:48:39'),
(5, 'Phụ Kiện', NULL, 2, NULL, '2020-01-12 03:48:52', '2020-01-12 03:48:52'),
(6, 'Cánh', NULL, 1, NULL, '2020-01-12 03:49:57', '2020-01-12 03:49:57'),
(7, 'Ngoại Hình', NULL, 2, NULL, '2020-01-12 03:50:08', '2020-01-12 03:50:08'),
(8, 'Trang Phục', NULL, 5, NULL, '2020-01-12 03:50:17', '2020-01-12 03:50:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `characters`
--

CREATE TABLE `characters` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `strength` bigint NOT NULL DEFAULT '0',
  `health_points` bigint NOT NULL DEFAULT '0',
  `intelligent` bigint NOT NULL DEFAULT '0',
  `agility` bigint NOT NULL DEFAULT '0',
  `lucky` bigint NOT NULL DEFAULT '0',
  `armor_strength` bigint NOT NULL DEFAULT '0',
  `armor_intelligent` bigint NOT NULL DEFAULT '0',
  `default_energy` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `characters`
--

INSERT INTO `characters` (`id`, `name`, `avatar`, `strength`, `health_points`, `intelligent`, `agility`, `lucky`, `armor_strength`, `armor_intelligent`, `default_energy`, `created_at`, `updated_at`) VALUES
(0, 'Chưa chọn nhân vật', '', 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL),
(2, 'Assassin', 'assassin', 18, 50, 0, 12, 8, 2, 2, 200, NULL, NULL),
(3, 'Paladin', 'paladin', 12, 100, 0, 5, 5, 8, 8, 220, NULL, NULL),
(4, 'Wizard', 'wizard', 0, 65, 25, 5, 5, 1, 1, 250, NULL, NULL),
(5, 'Priest', 'priest', 0, 70, 15, 3, 7, 1, 1, 270, NULL, NULL),
(6, 'Archer', 'archer', 25, 55, 0, 10, 5, 2, 2, 210, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_conversations`
--

CREATE TABLE `chat_conversations` (
  `user_id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_rooms`
--

CREATE TABLE `chat_rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `people` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `configs`
--

CREATE TABLE `configs` (
  `id` bigint UNSIGNED NOT NULL,
  `maintaince` tinyint NOT NULL,
  `limit_pvp_time_status` tinyint NOT NULL,
  `limit_pvp_time` int NOT NULL,
  `access_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirm_access_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `group_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `started_day` date NOT NULL,
  `per_post` int NOT NULL,
  `per_comment` int NOT NULL,
  `per_commented` int NOT NULL,
  `per_react` int NOT NULL,
  `per_reacted` int NOT NULL,
  `open_chat` tinyint NOT NULL DEFAULT '1',
  `open_pvp` tinyint NOT NULL DEFAULT '1',
  `introduce` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `configs`
--

INSERT INTO `configs` (`id`, `maintaince`, `limit_pvp_time_status`, `limit_pvp_time`, `access_token`, `confirm_access_token`, `group_id`, `started_day`, `per_post`, `per_comment`, `per_commented`, `per_react`, `per_reacted`, `open_chat`, `open_pvp`, `introduce`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 3, 'EAAAAAYsX7TsBALSMAAWRDfn27uBtgDGRPGDfjP3hCLefq41ZB6EKa5t51JFmttN47Xq9XeN8Wv2qLPOVmuocKWdxcRxZB7HjRqsnG3TYwKVSULy9Vk248q6FrVyIzw8mZC7IBAcw2stuRcxZCG3na2NJQ97qs3SnvnNklndYDRooQZAhMYUO4w63JZCvOu6OHMBzwbC5cu2krYxEZCrA1oM100kZC67AZC4wZD', 'EAABwzLixnjYBAAlR410haWGhnUX89QzDmsyR9gjP0naVv2RTweXUcE8zrUtAHEM4zyVbu1BG6xNRSinuWH8fy4fSxPnb5lf8iZCPbRwApcfCbvcj70hZAJKU73O3jhyeTZCM1m6AQimH9cdFlGWv5UO1FBVwxvOOMG9pU2zvATWQiZCQg6gChq2k2RCCVr7ZCwOxjqBBt3AZDZD', '283177689020690', '2020-01-11', 5, 2, 2, 1, 1, 1, 1, '<p>Game được thiết kế và phát hành bởi Lê Quang Vỹ</p>', NULL, '2020-03-12 12:34:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `fight_rooms`
--

CREATE TABLE `fight_rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL,
  `user_challenge` bigint UNSIGNED NOT NULL,
  `user_challenge_hp` int NOT NULL DEFAULT '0',
  `user_challenge_energy` int NOT NULL DEFAULT '0',
  `user_receive_challenge` int DEFAULT NULL,
  `turn` tinyint NOT NULL DEFAULT '0',
  `is_ready` tinyint NOT NULL DEFAULT '0',
  `status` tinyint DEFAULT NULL,
  `effected` json DEFAULT NULL,
  `buff` json DEFAULT NULL,
  `countdown_skill` json DEFAULT NULL,
  `check_status` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `fight_rooms`
--

INSERT INTO `fight_rooms` (`id`, `room_id`, `user_challenge`, `user_challenge_hp`, `user_challenge_energy`, `user_receive_challenge`, `turn`, `is_ready`, `status`, `effected`, `buff`, `countdown_skill`, `check_status`, `created_at`, `updated_at`) VALUES
(140, 30, 4, 13428, 200, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, '2020-07-18 10:19:59', '2020-07-18 10:19:59'),
(141, 30, 612, 112866363, 200, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, '2020-07-18 10:20:07', '2020-07-18 10:20:07'),
(142, 31, 614, 450, 200, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, '2020-07-20 07:45:12', '2020-07-20 07:45:12'),
(143, 31, 613, 450, 200, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, '2020-07-20 07:45:17', '2020-07-20 07:45:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `fight_room_logs`
--

CREATE TABLE `fight_room_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_win_id` bigint UNSIGNED NOT NULL,
  `user_lose_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `fight_room_logs`
--

INSERT INTO `fight_room_logs` (`id`, `user_win_id`, `user_lose_id`, `created_at`, `updated_at`) VALUES
(8, 4, 612, '2020-03-16 10:42:20', '2020-03-16 10:42:20'),
(9, 4, 612, '2020-03-16 10:43:06', '2020-03-16 10:43:06'),
(10, 4, 612, '2020-03-16 10:44:28', '2020-03-16 10:44:28'),
(11, 4, 612, '2020-03-16 10:47:09', '2020-03-16 10:47:09'),
(12, 4, 612, '2020-03-16 16:22:10', '2020-03-16 16:22:10'),
(13, 4, 612, '2020-03-16 16:23:14', '2020-03-16 16:23:14'),
(14, 4, 612, '2020-03-16 16:23:58', '2020-03-16 16:23:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gears`
--

CREATE TABLE `gears` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_tag` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_tag` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `character_id` bigint UNSIGNED NOT NULL,
  `cate_gear_id` bigint UNSIGNED NOT NULL,
  `strength` json DEFAULT NULL,
  `intelligent` json DEFAULT NULL,
  `agility` json DEFAULT NULL,
  `lucky` json DEFAULT NULL,
  `health_points` json DEFAULT NULL,
  `armor_strength` json DEFAULT NULL,
  `armor_intelligent` json DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rgb` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level_required` tinyint NOT NULL DEFAULT '0',
  `vip_required` tinyint NOT NULL DEFAULT '0',
  `price` bigint NOT NULL DEFAULT '0',
  `price_type` tinyint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `gears`
--

INSERT INTO `gears` (`id`, `name`, `class_tag`, `shop_tag`, `character_id`, `cate_gear_id`, `strength`, `intelligent`, `agility`, `lucky`, `health_points`, `armor_strength`, `armor_intelligent`, `description`, `rgb`, `level_required`, `vip_required`, `price`, `price_type`, `status`, `created_at`, `updated_at`) VALUES
(24, 'Kiếm Gỉ', 'weapon_warrior_0', 'shop_weapon_warrior_0', 3, 2, '5', '0', '0', '0', '0', '1', '1', 'Kiếm sắt bị gỉ', 'whitesmoke', 1, 0, 10000, 0, 1, '2020-01-15 09:24:41', '2020-03-09 03:56:06'),
(25, 'Giáp Vải', 'slim_armor_warrior_1', 'shop_armor_warrior_1', 3, 1, '0', '0', '2', '1', '5', '3', '3', 'Giáp vải nhẹ được làm từ vải tằm', 'whitesmoke', 1, 0, 10000, 0, 1, '2020-01-15 09:26:55', '2020-03-09 03:56:17'),
(26, 'Mũ Viking', 'head_warrior_1', 'shop_head_warrior_1', 3, 3, '0', '0', '0', '0', '0', '1', '1', 'Chiếc mũ do người Viking làm ra', 'whitesmoke', 1, 0, 10000, 0, 1, '2020-01-15 09:28:54', '2020-03-09 03:56:27'),
(27, 'Khiên Gỗ', 'shield_warrior_1', 'shop_shield_warrior_1', 3, 4, '2', '0', '1', '0', '5', '5', '5', 'Được làm bằng gỗ sim nghìn năm cực kì rắn chắc', 'whitesmoke', 1, 0, 10000, 0, 1, '2020-01-15 09:30:33', '2020-03-09 03:56:35'),
(28, 'Kiếm Bạc', 'weapon_warrior_1', 'shop_weapon_warrior_1', 3, 2, '15', '0', '2', '0', '0', '1', '1', 'Được làm bằng quặng bạc ở núi everest chống han gỉ', 'whitesmoke', 5, 0, 35000, 0, 1, '2020-01-15 09:31:16', '2020-03-09 03:56:46'),
(29, 'Giáp Bạc', 'slim_armor_warrior_2', 'shop_armor_warrior_2', 3, 1, '0', '0', '2', '1', '15', '5', '5', NULL, 'whitesmoke', 5, 0, 35000, 0, 1, '2020-01-15 09:34:26', '2020-03-09 03:56:54'),
(30, 'Mũ Bạc', 'head_warrior_2', 'shop_head_warrior_2', 3, 3, '0', '0', '0', '0', '7', '2', '2', NULL, 'whitesmoke', 5, 0, 35000, 0, 1, '2020-01-15 09:36:52', '2020-03-09 03:57:01'),
(31, 'Khiên Bạc', 'shield_warrior_2', 'shop_shield_warrior_2', 3, 4, '5', '0', '2', '1', '10', '7', '7', NULL, 'whitesmoke', 5, 0, 35000, 0, 1, '2020-01-15 09:37:41', '2020-01-15 09:38:13'),
(32, 'Rìu Titan', 'weapon_warrior_2', 'shop_weapon_warrior_2', 3, 2, '22', '0', '3', '1', '5', '1', '1', NULL, 'whitesmoke', 10, 0, 80000, 0, 1, '2020-01-15 09:38:56', '2020-01-15 09:39:49'),
(33, 'Giáp Bạch Kim', 'slim_armor_warrior_3', 'shop_armor_warrior_3', 3, 1, '0', '0', '4', '1', '30', '8', '8', NULL, 'whitesmoke', 10, 0, 80000, 0, 1, '2020-01-15 09:40:01', '2020-01-15 09:40:34'),
(34, 'Mũ Titan', 'head_warrior_3', 'shop_head_warrior_3', 3, 3, '1', '0', '2', '1', '18', '6', '6', NULL, 'whitesmoke', 10, 0, 80000, 0, 1, '2020-01-15 09:40:46', '2020-01-15 10:14:49'),
(35, 'Khiên Bạch Kim', 'shield_warrior_3', 'shop_shield_warrior_3', 3, 4, '7', '0', '2', '3', '23', '10', '10', NULL, 'whitesmoke', 10, 0, 80000, 0, 1, '2020-01-15 09:41:49', '2020-01-15 09:42:43'),
(36, 'Kiếm Lửa', 'weapon_warrior_5', 'shop_weapon_warrior_5', 3, 2, '35', '0', '5', '5', '10', '5', '5', NULL, 'cadetblue', 25, 0, 20, 1, 1, '2020-01-15 09:43:09', '2020-01-15 09:46:38'),
(38, 'Giáp Lửa', 'slim_armor_warrior_4', 'shop_armor_warrior_4', 3, 1, '0', '0', '5', '2', '38', '10', '10', NULL, 'cadetblue', 25, 0, 20, 1, 1, '2020-01-15 09:44:33', '2020-01-15 10:20:24'),
(39, 'Mũ Lửa Đỏ', 'head_warrior_4', 'shop_head_warrior_4', 3, 3, '5', '0', '5', '2', '24', '8', '8', NULL, 'cadetblue', 25, 0, 20, 1, 1, '2020-01-15 09:47:53', '2020-01-15 09:48:33'),
(40, 'Khiên Hỏa Long', 'shield_warrior_4', 'shop_shield_warrior_4', 3, 4, '12', '0', '5', '5', '30', '18', '18', NULL, 'cadetblue', 25, 0, 20, 1, 1, '2020-01-15 09:48:41', '2020-01-15 09:49:19'),
(41, 'Kiếm Vàng', 'weapon_warrior_6', 'shop_weapon_warrior_6', 3, 2, '60', '0', '15', '5', '50', '8', '8', NULL, 'cadetblue', 40, 0, 100, 1, 1, '2020-01-15 09:49:59', '2020-01-15 09:50:59'),
(42, 'Giáp Vàng', 'slim_armor_warrior_5', 'shop_armor_warrior_5', 3, 1, '10', '0', '10', '5', '100', '25', '25', NULL, 'cadetblue', 40, 0, 100, 1, 1, '2020-01-15 09:51:07', '2020-01-15 09:51:40'),
(43, 'Mũ Vàng Kim', 'head_warrior_5', 'shop_head_warrior_5', 3, 3, '10', '0', '8', '5', '60', '15', '15', NULL, 'cadetblue', 40, 0, 100, 1, 1, '2020-01-15 09:51:48', '2020-01-15 09:52:21'),
(44, 'Khiên Vàng', 'shield_warrior_5', 'shop_shield_warrior_5', 3, 4, '20', '0', '12', '5', '80', '28', '28', NULL, 'cadetblue', 40, 0, 100, 1, 1, '2020-01-15 09:52:31', '2020-01-15 09:53:01'),
(45, 'Dao Gỉ', 'weapon_rogue_0', 'shop_weapon_rogue_0', 2, 2, '3', '0', '2', '2', '0', '0', '0', NULL, 'whitesmoke', 1, 0, 10000, 0, 1, '2020-01-15 09:59:25', '2020-01-15 10:00:35'),
(46, 'Giáp Vải', 'slim_armor_rogue_1', 'shop_armor_rogue_1', 2, 1, '0', '0', '5', '3', '2', '2', '2', NULL, 'whitesmoke', 1, 0, 10000, 0, 1, '2020-01-15 10:00:43', '2020-01-15 10:01:32'),
(47, 'Mũ Vải', 'head_rogue_1', 'shop_head_rogue_1', 2, 3, '0', '0', '2', '0', '0', '0', '0', NULL, 'whitesmoke', 1, 0, 10000, 0, 1, '2020-01-15 10:01:39', '2020-01-15 10:04:04'),
(48, 'Dao Cắt Giấy', 'shield_rogue_1', 'shop_shield_rogue_1', 2, 4, '1', '0', '2', '4', '5', '3', '3', NULL, 'whitesmoke', 1, 0, 10000, 0, 1, '2020-01-15 10:02:18', '2020-01-15 10:04:19'),
(49, 'Dao Bạc', 'weapon_rogue_1', 'shop_weapon_rogue_1', 2, 2, '10', '0', '7', '2', '0', '0', '0', NULL, 'whitesmoke', 5, 0, 35000, 0, 1, '2020-01-15 10:05:54', '2020-01-15 10:06:26'),
(50, 'Giáp Đen', 'slim_armor_rogue_2', 'shop_armor_rogue_2', 2, 1, '0', '0', '7', '3', '10', '4', '4', NULL, 'whitesmoke', 5, 0, 35000, 0, 1, '2020-01-15 10:06:35', '2020-01-15 10:07:14'),
(51, 'Mũ Đen', 'head_rogue_2', 'shop_head_rogue_2', 2, 3, '0', '0', '0', '2', '5', '2', '2', NULL, 'whitesmoke', 5, 0, 35000, 0, 1, '2020-01-15 10:07:23', '2020-01-15 10:07:43'),
(52, 'Dao Quắm', 'shield_rogue_2', 'shop_shield_rogue_2', 2, 4, '3', '0', '2', '3', '7', '5', '5', NULL, 'whitesmoke', 5, 0, 35000, 0, 1, '2020-01-15 10:07:52', '2020-01-15 10:08:37'),
(53, 'Dao Phay Bạc', 'weapon_rogue_2', 'shop_weapon_rogue_2', 2, 2, '15', '0', '5', '3', '3', '1', '1', NULL, 'whitesmoke', 10, 0, 80000, 0, 1, '2020-01-15 10:08:57', '2020-01-15 10:09:38'),
(54, 'Giáp Lam', 'slim_armor_rogue_3', 'shop_armor_rogue_3', 2, 1, '0', '0', '8', '5', '25', '3', '3', NULL, 'whitesmoke', 10, 0, 80000, 0, 1, '2020-01-15 10:09:48', '2020-01-15 10:10:29'),
(55, 'Mũ Lam', 'head_rogue_3', 'shop_head_rogue_3', 2, 3, '1', '0', '2', '5', '10', '4', '4', NULL, 'whitesmoke', 10, 0, 80000, 0, 1, '2020-01-15 10:10:39', '2020-01-15 10:15:09'),
(56, 'Dao Cắt', 'shield_rogue_3', 'shop_shield_rogue_3', 2, 4, '5', '0', '4', '8', '15', '7', '7', NULL, 'whitesmoke', 10, 0, 80000, 0, 1, '2020-01-15 10:11:16', '2020-01-15 10:11:53'),
(57, 'Dao Điện', 'weapon_rogue_5', 'shop_weapon_rogue_5', 2, 2, '25', '0', '8', '8', '10', '2', '2', NULL, 'cadetblue', 25, 0, 20, 1, 1, '2020-01-15 10:15:19', '2020-01-15 10:16:06'),
(59, 'Giáp Hắc Lam', 'slim_armor_rogue_4', 'shop_armor_rogue_4', 2, 1, '0', '0', '7', '6', '30', '7', '7', NULL, 'cadetblue', 25, 0, 20, 1, 1, '2020-01-15 10:18:22', '2020-01-15 10:19:21'),
(60, 'Mũ Hắc Lam', 'head_rogue_4', 'shop_head_rogue_4', 2, 3, '3', '0', '8', '4', '20', '4', '4', NULL, 'cadetblue', 25, 0, 20, 1, 1, '2020-01-15 10:21:04', '2020-01-15 10:21:39'),
(61, 'Côn Nhị Khúc', 'shield_rogue_4', 'shop_shield_rogue_4', 2, 4, '10', '0', '7', '8', '24', '14', '14', NULL, 'cadetblue', 25, 0, 20, 1, 1, '2020-01-15 10:21:51', '2020-01-15 10:22:23'),
(62, 'Dao Móc', 'weapon_rogue_6', 'shop_weapon_rogue_6', 2, 2, '50', '0', '25', '10', '45', '5', '5', NULL, 'cadetblue', 40, 0, 100, 1, 1, '2020-01-15 10:22:44', '2020-01-15 10:23:33'),
(63, 'Giáp Hắc Cực', 'slim_armor_rogue_5', 'shop_armor_rogue_5', 2, 1, '5', '0', '13', '7', '75', '19', '19', NULL, 'cadetblue', 40, 0, 100, 1, 1, '2020-01-15 10:24:22', '2020-01-15 10:25:01'),
(64, 'Mũ Hắc Cực', 'head_rogue_5', 'shop_head_rogue_5', 2, 3, '8', '0', '15', '8', '48', '12', '12', NULL, 'cadetblue', 40, 0, 100, 1, 1, '2020-01-15 10:25:34', '2020-01-15 10:26:01'),
(65, 'Dao Móc', 'shield_rogue_6', 'shop_shield_rogue_6', 2, 4, '15', '0', '16', '10', '70', '22', '22', NULL, 'cadetblue', 40, 0, 100, 1, 1, '2020-01-15 10:26:09', '2020-01-15 10:29:24'),
(66, 'Gậy Gỗ', 'weapon_wizard_0', 'shop_weapon_wizard_0', 4, 2, '0', '6', '0', '0', '0', '0', '0', NULL, 'whitesmoke', 1, 0, 10000, 0, 1, '2020-01-17 18:04:58', '2020-01-17 18:15:38'),
(67, 'Giáp Phép Vải', 'slim_armor_wizard_1', 'shop_armor_wizard_1', 4, 1, '0', '1', '0', '2', '3', '2', '2', NULL, 'whitesmoke', 1, 0, 10000, 0, 1, '2020-01-17 18:08:06', '2020-01-17 18:16:24'),
(68, 'Mũ Phép Thô', 'head_wizard_1', 'shop_head_wizard_1', 4, 3, '0', '2', '0', '0', '0', '0', '0', NULL, 'whitesmoke', 1, 0, 10000, 0, 1, '2020-01-17 18:09:15', '2020-01-17 18:32:17'),
(69, 'Vương Miện Lục Bảo', 'head_healer_1', 'shop_head_healer_1', 4, 4, '0', '2', '0', '1', '2', '1', '2', NULL, 'whitesmoke', 1, 0, 10000, 0, 1, '2020-01-17 18:09:47', '2020-01-17 18:20:32'),
(70, 'Gậy Gỗ Ngàn Năm', 'weapon_wizard_1', 'shop_weapon_wizard_1', 4, 2, '0', '25', '1', '1', '0', '0', '1', NULL, 'whitesmoke', 5, 0, 35000, 0, 1, '2020-01-17 18:21:01', '2020-01-17 18:21:53'),
(71, 'Giáp Vải Tằm', 'slim_armor_wizard_2', 'shop_armor_wizard_2', 4, 1, '0', '0', '1', '2', '12', '2', '3', NULL, 'whitesmoke', 5, 0, 35000, 0, 1, '2020-01-17 18:22:02', '2020-01-17 18:23:18'),
(72, 'Mũ Vải Lam', 'head_wizard_2', 'shop_head_wizard_2', 4, 3, '0', '1', '0', '1', '3', '1', '4', NULL, 'whitesmoke', 5, 0, 35000, 0, 1, '2020-01-17 18:23:30', '2020-01-17 18:24:35'),
(73, 'Vương Miện Hắc Cực', 'head_healer_2', 'shop_head_healer_2', 4, 4, '0', '10', '1', '2', '7', '2', '5', NULL, 'whitesmoke', 5, 0, 35000, 0, 1, '2020-01-17 18:24:43', '2020-01-17 18:43:16'),
(74, 'Gậy Đính Đá', 'weapon_wizard_2', 'shop_weapon_wizard_2', 4, 2, '0', '28', '1', '3', '2', '0', '1', NULL, 'whitesmoke', 10, 0, 80000, 0, 1, '2020-01-17 18:25:55', '2020-01-17 18:26:37'),
(75, 'Giáp Quý Tộc', 'slim_armor_wizard_3', 'shop_armor_wizard_3', 4, 1, '0', '5', '2', '1', '16', '2', '5', NULL, 'whitesmoke', 10, 0, 80000, 0, 1, '2020-01-17 18:26:45', '2020-01-17 18:27:38'),
(76, 'Mũ Pháp Sư Bay', 'head_wizard_3', 'shop_head_wizard_3', 4, 3, '0', '5', '1', '2', '10', '3', '6', NULL, 'whitesmoke', 10, 0, 80000, 0, 1, '2020-01-17 18:27:46', '2020-01-17 18:28:27'),
(77, 'Vương Miện Quý Tộc', 'shield_head_healer_3', 'shop_head_healer_3', 4, 4, '0', '18', '2', '2', '12', '3', '8', NULL, 'whitesmoke', 10, 0, 80000, 0, 1, '2020-01-17 18:29:02', '2020-01-17 18:30:01'),
(78, 'Gậy Pháp Sư Cao Cấp', 'weapon_wizard_5', 'shop_weapon_wizard_5', 4, 2, '0', '55', '1', '5', '6', '3', '5', NULL, 'cadetblue', 25, 0, 20, 1, 1, '2020-01-17 18:30:10', '2020-01-17 18:31:55'),
(79, 'Giáp Pháp Sư Cao Cấp', 'slim_armor_wizard_4', 'shop_armor_wizard_4', 4, 1, '0', '0', '3', '5', '25', '6', '10', NULL, 'cadetblue', 25, 0, 20, 1, 1, '2020-01-17 18:30:57', '2020-01-17 18:31:38'),
(80, 'Mũ Pháp Sư Cao Cấp', 'head_wizard_4', 'shop_head_wizard_4', 4, 3, '0', '10', '2', '5', '12', '3', '8', NULL, 'cadetblue', 25, 0, 20, 1, 1, '2020-01-17 18:32:37', '2020-01-17 18:35:10'),
(81, 'Vương Miện Tinh Linh', 'head_healer_4', 'shop_head_healer_4', 4, 4, '0', '20', '2', '7', '22', '10', '18', NULL, 'cadetblue', 25, 0, 20, 1, 1, '2020-01-17 18:33:55', '2020-01-17 18:42:46'),
(82, 'Gậy Thiên Sứ', 'weapon_wizard_6', 'shop_weapon_wizard_6', 4, 2, '0', '85', '10', '8', '40', '5', '8', NULL, 'cadetblue', 40, 0, 100, 1, 1, '2020-01-17 18:35:29', '2020-01-17 18:36:09'),
(83, 'Giáp Thiên Sứ', 'slim_armor_wizard_5', 'shop_armor_wizard_5', 4, 1, '0', '22', '4', '8', '75', '16', '25', NULL, 'cadetblue', 40, 0, 100, 1, 1, '2020-01-17 18:36:18', '2020-01-17 18:36:58'),
(84, 'Mũ Thiên Sứ', 'head_wizard_5', 'shop_head_wizard_5', 4, 3, '0', '18', '5', '8', '42', '9', '12', NULL, 'cadetblue', 40, 0, 100, 1, 1, '2020-01-17 18:37:07', '2020-01-17 18:40:24'),
(85, 'Vượng Miện Thiên Sứ', 'head_healer_warrior_5', 'shop_head_special_winter2017Healer', 4, 4, '0', '32', '8', '10', '65', '16', '22', NULL, 'cadetblue', 40, 0, 100, 1, 1, '2020-01-17 18:38:05', '2020-01-17 18:40:10'),
(86, 'Mũ Hắc Long', 'head_special_ks2019', 'shop_head_special_ks2019', 3, 3, '999', '0', '999', '999', '999', '999', '999', NULL, 'red', 0, 0, 0, 0, 0, '2020-03-06 15:25:22', '2020-03-06 15:42:34'),
(87, 'Khiên Hắc Long', 'shield_special_ks2019', 'shop_shield_special_ks2019', 3, 4, '999', '0', '999', '999', '999', '999', '999', NULL, 'red', 0, 0, 0, 0, 0, '2020-03-06 15:28:37', '2020-03-06 15:42:23'),
(88, 'Mặt Lạ Hắc Long', 'eyewear_special_ks2019', 'shop_eyewear_special_ks2019', 3, 5, '999', '0', '999', '999', '999', '999', '999', NULL, 'red', 0, 0, 0, 0, 0, '2020-03-06 15:29:44', '2020-03-06 15:42:10'),
(89, 'Thương Hắc Long', 'weapon_special_ks2019', 'shop_weapon_special_ks2019', 3, 2, '999', '0', '999', '999', '999', '999', '999', NULL, 'red', 0, 0, 0, 0, 0, '2020-03-06 15:31:56', '2020-03-06 15:41:58'),
(90, 'Giáp Hắc Long', 'slim_armor_special_ks2019', 'shop_armor_special_ks2019', 3, 1, '999', '0', '999', '999', '999', '999', '999', NULL, 'red', 0, 0, 0, 0, 0, '2020-03-06 15:35:04', '2020-03-06 15:41:45'),
(91, 'Cánh Hắc Ma', 'back_mystery_201905 headAccessory_mystery_201905', 'shop_set_mystery_201905', 2, 6, '200', '200', '200', '200', '200', '200', '200', 'Cánh của hắc ma vương trong thế giới luyện ngục', 'red', 1, 0, 1000, 1, 1, '2020-03-09 04:12:45', '2020-03-09 04:39:54'),
(92, 'Cánh Hắc Ma', 'back_mystery_201905 headAccessory_mystery_201905', 'shop_set_mystery_201905', 3, 6, '200', '200', '200', '200', '200', '200', '200', 'Cánh của hắc ma vương trong thế giới luyện ngục', 'red', 1, 0, 1000, 1, 1, '2020-03-09 04:14:24', '2020-03-09 04:39:27'),
(93, 'Cánh Hắc Ma', 'back_mystery_201905 headAccessory_mystery_201905', 'shop_set_mystery_201905', 4, 6, '200', '200', '200', '200', '200', '200', '200', 'Cánh của hắc ma vương trong thế giới luyện ngục', 'red', 1, 0, 1000, 1, 1, '2020-03-09 04:14:38', '2020-03-09 04:40:30'),
(94, 'Cánh Tinh Linh', 'back_mystery_201801 headAccessory_mystery_201801', 'shop_set_mystery_201801', 2, 6, '200', '200', '200', '200', '200', '200', '200', 'Cánh của loài Elf', 'red', 1, 0, 1000, 1, 1, '2020-03-09 04:38:42', '2020-03-09 04:40:55'),
(95, 'Cánh Tinh Linh', 'back_mystery_201801 headAccessory_mystery_201801', 'shop_set_mystery_201801', 3, 6, '200', '200', '200', '200', '200', '200', '200', 'Cánh của loài Elf', 'red', 1, 0, 1000, 1, 1, '2020-03-09 04:41:11', '2020-03-09 04:41:16'),
(96, 'Cánh Tinh Linh', 'back_mystery_201801 headAccessory_mystery_201801', 'shop_set_mystery_201801', 4, 6, '200', '200', '200', '200', '200', '200', '200', 'Cánh của loài Elf', 'red', 1, 0, 1000, 1, 1, '2020-03-09 04:41:23', '2020-03-09 04:41:27'),
(97, 'Tóc Đỏ', 'customize-option hair_bangs_2_TRUred', 'customize-option hair_bangs_2_TRUred', 3, 7, '{\"default\": 999, \"percent\": 10}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', 'Xuân tóc đỏ =))', 'whitesmoke', 1, 0, 2000, 0, 1, '2020-03-10 10:10:54', '2020-03-10 10:18:30'),
(98, 'Tóc Closeup', 'customize-option hair_bangs_2_aurora', 'customize-option hair_bangs_2_aurora', 2, 7, '5', '5', '5', '5', '5', '5', '5', 'Tóc kem đánh răng closeup', 'whitesmoke', 1, 0, 2000, 0, 1, '2020-03-10 10:18:38', '2020-03-10 10:19:48'),
(99, 'Tóc Xương Rồng', 'customize-option hair_bangs_2_hollygreen', 'customize-option hair_bangs_2_hollygreen', 4, 7, '5', '5', '5', '5', '5', '5', '5', NULL, 'whitesmoke', 1, 0, 2000, 0, 1, '2020-03-10 10:19:56', '2020-03-10 10:20:49'),
(100, 'Cánh Chuồn Chuồn', 'head_mystery_201803 back_mystery_201803', 'shop_set_mystery_201803', 2, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 10:24:19', '2020-03-10 10:24:19'),
(101, 'Cánh Chuồn Chuồn', 'head_mystery_201803 back_mystery_201803', 'shop_set_mystery_201803', 3, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 10:24:19', '2020-03-10 10:24:19'),
(102, 'Cánh Chuồn Chuồn', 'head_mystery_201803 back_mystery_201803', 'shop_set_mystery_201803', 4, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 10:24:19', '2020-03-10 10:24:19'),
(103, 'Cánh Tiên', 'back_mystery_201704', 'shop_back_mystery_201704', 2, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 12:09:46', '2020-03-10 12:09:46'),
(104, 'Cánh Tiên', 'back_mystery_201704', 'shop_back_mystery_201704', 3, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 12:09:46', '2020-03-10 12:09:46'),
(105, 'Cánh Tiên', 'back_mystery_201704', 'shop_back_mystery_201704', 4, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 12:09:46', '2020-03-10 12:09:46'),
(106, 'Cánh Băng Giá', 'head_mystery_201912 back_mystery_201912', 'shop_set_mystery_201912', 2, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 12:14:41', '2020-03-10 12:15:44'),
(107, 'Cánh Băng Giá', 'head_mystery_201912 back_mystery_201912', 'shop_set_mystery_201912', 3, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 12:14:41', '2020-03-10 12:15:39'),
(108, 'Cánh Băng Giá', 'head_mystery_201912 back_mystery_201912', 'shop_set_mystery_201912', 4, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 12:14:41', '2020-03-10 12:15:32'),
(109, 'Cánh Bướm', 'headAccessory_mystery_201404 back_mystery_201404', 'shop_set_mystery_201404', 2, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 12:17:35', '2020-03-10 12:18:20'),
(110, 'Cánh Bướm', 'headAccessory_mystery_201404 back_mystery_201404', 'shop_set_mystery_201404', 3, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 12:17:35', '2020-03-10 12:18:59'),
(111, 'Cánh Bướm', 'headAccessory_mystery_201404 back_mystery_201404', 'shop_set_mystery_201404', 4, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 12:17:35', '2020-03-10 12:19:05'),
(112, 'Cánh Chim', 'back_special_takeThis', 'shop_back_special_takeThis', 2, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 12:21:00', '2020-03-10 12:21:00'),
(113, 'Cánh Chim', 'back_special_takeThis', 'shop_back_special_takeThis', 3, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 12:21:00', '2020-03-10 12:21:00'),
(114, 'Cánh Chim', 'back_special_takeThis', 'shop_back_special_takeThis', 4, 6, '200', '200', '200', '200', '200', '200', '200', NULL, 'red', 1, 0, 1000, 1, 1, '2020-03-10 12:21:00', '2020-03-10 12:21:00'),
(115, 'Red Knight\'s Helmet', 'tanker_helmet_igris', 'shop_tanker_helmet_igris', 3, 3, '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', NULL, 'red', 1, 0, 999, 1, 0, '2020-03-17 14:37:50', '2020-03-17 14:37:50'),
(116, 'Red Knight\'s Armor', 'tanker_armor_igris', 'shop_tanker_armor_igris', 3, 1, '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 0}', NULL, 'red', 1, 0, 999, 1, 0, '2020-03-17 14:39:11', '2020-03-17 14:39:11'),
(117, 'Red Knight\'s Weapon', 'tanker_sword_igris', 'shop_tanker_sword_igris', 3, 2, '{\"default\": 999, \"percent\": 0}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', '{\"default\": 999, \"percent\": 5}', NULL, 'red', 1, 0, 999, 1, 0, '2020-03-17 14:40:49', '2020-03-17 14:40:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gems`
--

CREATE TABLE `gems` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `strength` bigint NOT NULL DEFAULT '0',
  `intelligent` bigint NOT NULL DEFAULT '0',
  `agility` bigint NOT NULL DEFAULT '0',
  `lucky` bigint NOT NULL DEFAULT '0',
  `health_points` bigint NOT NULL DEFAULT '0',
  `armor_strength` bigint NOT NULL DEFAULT '0',
  `armor_intelligent` bigint NOT NULL DEFAULT '0',
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level_required` int NOT NULL DEFAULT '0',
  `vip_required` int NOT NULL DEFAULT '0',
  `rgb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_type` tinyint NOT NULL DEFAULT '0',
  `price` bigint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `gems`
--

INSERT INTO `gems` (`id`, `name`, `image`, `strength`, `intelligent`, `agility`, `lucky`, `health_points`, `armor_strength`, `armor_intelligent`, `description`, `level_required`, `vip_required`, `rgb`, `price_type`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Sức Mạnh I', 'strength-gem-1', 10, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 'whitesmoke', 0, 20000, 1, NULL, NULL),
(2, 'Nhanh Nhẹn I', 'agility-gem-1', 0, 0, 10, 0, 0, 0, 0, NULL, 0, 0, 'whitesmoke', 0, 20000, 1, NULL, NULL),
(3, 'Kháng Công I', 'armor-strength-gem-1', 0, 0, 0, 0, 0, 10, 0, NULL, 0, 0, 'whitesmoke', 0, 20000, 1, NULL, NULL),
(4, 'Sinh Lực I', 'hp-gem-1', 0, 0, 0, 0, 50, 0, 0, NULL, 0, 0, 'whitesmoke', 0, 20000, 1, NULL, NULL),
(5, 'Trí Tuệ I', 'intelligent-gem-1', 0, 10, 0, 0, 0, 0, 0, NULL, 0, 0, 'whitesmoke', 0, 20000, 1, NULL, NULL),
(6, 'May Mắn I', 'lucky-gem-1', 0, 0, 0, 10, 0, 0, 0, NULL, 0, 0, 'whitesmoke', 0, 20000, 1, NULL, NULL),
(7, 'Kháng Phép I', 'armor-intelligent-gem-1', 0, 0, 0, 0, 0, 0, 10, NULL, 0, 0, 'whitesmoke', 0, 20000, 1, NULL, NULL),
(8, 'Toàn Diện I', 'full-gem-1', 10, 10, 10, 10, 50, 10, 10, NULL, 0, 0, 'whitesmoke', 1, 50, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gift_codes`
--

CREATE TABLE `gift_codes` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `query` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_day` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `gift_codes`
--

INSERT INTO `gift_codes` (`id`, `code`, `query`, `expired_day`, `created_at`, `updated_at`) VALUES
(1, 'CANHTY2020', 'UPDATE users SET income_coins = income_coins + 5000,gold = gold + 5 WHERE id = :id^INSERT INTO user_pets(user_id,pet_id) VALUES(:id,25)^INSERT INTO user_gears(user_id,gear_id,status) VALUES(:id,(SELECT id FROM gears WHERE character_id = :character_id ORDER BY RAND() LIMIT 1),0)^UPDATE users SET stranger_chat_times = stranger_chat_times + 5 WHERE id = :id\r\n', '2020-01-25', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `guilds`
--

CREATE TABLE `guilds` (
  `id` bigint UNSIGNED NOT NULL,
  `master_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `noti_board` text COLLATE utf8mb4_unicode_ci,
  `level` int NOT NULL DEFAULT '1',
  `resources` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `guilds`
--

INSERT INTO `guilds` (`id`, `master_id`, `name`, `brand`, `noti_board`, `level`, `resources`, `created_at`, `updated_at`) VALUES
(2, 4, 'Thợ Săn', 'images/guild/0bf51042f01fbc7bcc65517728443aa6.png', '1', 1, 0, '2020-03-13 05:51:02', '2020-03-13 05:51:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `guild_items`
--

CREATE TABLE `guild_items` (
  `guild_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `expire_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `guild_logs`
--

CREATE TABLE `guild_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `guild_id` bigint UNSIGNED NOT NULL,
  `log` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `guild_members`
--

CREATE TABLE `guild_members` (
  `id` bigint UNSIGNED NOT NULL,
  `guild_id` bigint UNSIGNED NOT NULL,
  `member_id` bigint UNSIGNED NOT NULL,
  `resources` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `guild_members`
--

INSERT INTO `guild_members` (`id`, `guild_id`, `member_id`, `resources`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 0, '2020-03-13 05:51:02', '2020-03-13 05:51:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `guild_shops`
--

CREATE TABLE `guild_shops` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_type` tinyint NOT NULL DEFAULT '0',
  `price` bigint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `items`
--

CREATE TABLE `items` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_tag` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `query` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `success_rate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '100',
  `price_type` tinyint NOT NULL DEFAULT '0',
  `price` bigint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `hot` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `class_tag`, `query`, `success_rate`, `price_type`, `price`, `status`, `hot`, `created_at`, `updated_at`) VALUES
(1, 'Lọ Kinh Nghiệm', '+ 100 Kinh Nghiệm sau khi sử dụng', 'inventory_special_fortify', 'UPDATE users SET exp = exp + 100 WHERE id = :id', '100', 0, 2000, 1, 1, NULL, '2020-01-14 05:15:40'),
(2, 'Kẹo', 'Sau khi ăn vào sẽ tăng 20 điểm sức khỏe', 'Food_Candy_Base', 'UPDATE users SET energy = energy + 20 WHERE id = :id', '100', 0, 1000, 1, 0, '2020-01-14 04:46:31', '2020-01-16 16:16:37'),
(3, 'Socola', 'Sau khi ăn vào sẽ tăng 50 điểm sức khỏe', 'Food_Chocolate', 'UPDATE users SET energy = energy + 50 WHERE id = :id', '100', 0, 2200, 1, 0, '2020-01-17 19:03:13', '2020-01-17 19:06:45'),
(4, 'Thịt Bò', 'Sau khi ăn vào sẽ tăng 120 điểm sức khỏe', 'Food_Meat', 'UPDATE users SET energy = energy + 120 WHERE id = :id', '100', 0, 5000, 1, 0, '2020-01-17 19:07:04', '2020-01-17 19:07:33'),
(5, 'Thịt Bò Sốt', 'Sau khi ăn vào sẽ tăng 120 điểm sức khỏe', 'Food_RottenMeat', 'UPDATE users SET energy = energy + 300 WHERE id = :id', '100', 0, 12000, 1, 1, '2020-01-17 19:07:55', '2020-01-17 19:08:21'),
(6, 'Vé Chat', 'Sau khi sử dụng vé có thể vào chat với người lạ', 'inventory_special_congrats', 'UPDATE users SET stranger_chat_times = stranger_chat_times + 1 WHERE id = :id', '100', 0, 200, 1, 0, '2020-01-17 19:10:20', '2020-01-17 19:10:20'),
(7, 'Vé PVP', 'Sau khi dùng vé bạn bạn có thêm 1 cơ hội vào khu vực PVP', 'inventory_special_thankyou', 'UPDATE users SET pvp_times = pvp_times + 1 WHERE id = :id', '100', 0, 1000, 1, 1, '2020-03-09 04:08:12', '2020-03-09 04:08:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `levels`
--

CREATE TABLE `levels` (
  `id` bigint UNSIGNED NOT NULL,
  `level` int NOT NULL,
  `exp_required` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `levels`
--

INSERT INTO `levels` (`id`, `level`, `exp_required`, `created_at`, `updated_at`) VALUES
(1, 1, 0, NULL, NULL),
(3, 2, 80, '2020-01-16 15:01:27', '2020-01-16 15:01:27'),
(4, 3, 104, '2020-01-16 18:14:43', '2020-01-16 18:14:43'),
(5, 4, 135, '2020-01-16 18:14:46', '2020-01-16 18:14:46'),
(6, 5, 176, '2020-01-16 18:14:48', '2020-01-16 18:14:48'),
(7, 6, 229, '2020-01-16 18:14:51', '2020-01-16 18:14:51'),
(8, 7, 298, '2020-01-16 18:14:53', '2020-01-16 18:14:53'),
(9, 8, 387, '2020-01-16 18:14:55', '2020-01-16 18:14:55'),
(10, 9, 503, '2020-01-16 18:14:58', '2020-01-16 18:14:58'),
(11, 10, 654, '2020-01-16 18:14:59', '2020-01-16 18:14:59'),
(12, 11, 850, '2020-01-16 18:15:02', '2020-01-16 18:15:02'),
(13, 12, 1105, '2020-01-16 18:15:04', '2020-01-16 18:15:04'),
(14, 13, 1437, '2020-01-16 18:15:06', '2020-01-16 18:15:06'),
(15, 14, 1868, '2020-01-16 18:15:08', '2020-01-16 18:15:08'),
(16, 15, 2428, '2020-01-16 18:15:10', '2020-01-16 18:15:10'),
(17, 16, 3156, '2020-01-16 18:15:13', '2020-01-16 18:15:13'),
(18, 17, 4103, '2020-01-16 18:15:16', '2020-01-16 18:15:16'),
(19, 18, 5334, '2020-01-16 18:15:18', '2020-01-16 18:15:18'),
(20, 19, 6934, '2020-01-16 18:15:20', '2020-01-16 18:15:20'),
(21, 20, 9014, '2020-01-16 18:15:23', '2020-01-16 18:15:23'),
(22, 21, 11718, '2020-01-16 18:15:25', '2020-01-16 18:15:25'),
(23, 22, 15233, '2020-01-16 18:15:27', '2020-01-16 18:15:27'),
(24, 23, 19803, '2020-01-16 18:15:29', '2020-01-16 18:15:29'),
(25, 24, 25744, '2020-01-16 18:15:32', '2020-01-16 18:15:32'),
(26, 25, 33467, '2020-01-16 18:15:34', '2020-01-16 18:15:34'),
(27, 26, 43507, '2020-01-16 18:15:37', '2020-01-16 18:15:37'),
(28, 27, 56559, '2020-01-16 18:15:39', '2020-01-16 18:15:39'),
(29, 28, 73527, '2020-01-16 18:15:42', '2020-01-16 18:15:42'),
(30, 29, 95585, '2020-01-16 18:15:44', '2020-01-16 18:15:44'),
(31, 30, 124261, '2020-01-16 18:15:46', '2020-01-16 18:15:46'),
(32, 31, 161539, '2020-01-16 18:15:48', '2020-01-16 18:15:48'),
(33, 32, 210001, '2020-01-16 18:15:50', '2020-01-16 18:15:50'),
(34, 33, 273001, '2020-01-16 18:15:55', '2020-01-16 18:15:55'),
(35, 34, 354901, '2020-01-16 18:15:57', '2020-01-16 18:15:57'),
(36, 35, 461371, '2020-01-16 18:15:59', '2020-01-16 18:15:59'),
(37, 36, 599782, '2020-01-16 18:16:01', '2020-01-16 18:16:01'),
(38, 37, 779717, '2020-01-16 18:16:04', '2020-01-16 18:16:04'),
(39, 38, 1013632, '2020-01-16 18:16:06', '2020-01-16 18:16:06'),
(40, 39, 1317722, '2020-01-16 18:16:08', '2020-01-16 18:16:08'),
(41, 40, 1713039, '2020-01-16 18:16:21', '2020-01-16 18:16:21'),
(42, 41, 2226951, '2020-01-16 18:16:22', '2020-01-16 18:16:22'),
(43, 42, 2895036, '2020-01-16 18:16:24', '2020-01-16 18:16:24'),
(44, 43, 3763547, '2020-01-16 18:16:26', '2020-01-16 18:16:26'),
(45, 44, 4892611, '2020-01-16 18:16:27', '2020-01-16 18:16:27'),
(46, 45, 6360394, '2020-01-16 18:16:29', '2020-01-16 18:16:29'),
(47, 46, 8268512, '2020-01-16 18:16:31', '2020-01-16 18:16:31'),
(48, 47, 10749066, '2020-01-16 18:16:33', '2020-01-16 18:16:33'),
(49, 48, 13973786, '2020-01-16 18:16:35', '2020-01-16 18:16:35'),
(50, 49, 18165922, '2020-01-16 18:16:36', '2020-01-16 18:16:36'),
(51, 50, 23615699, '2020-01-16 18:16:45', '2020-01-16 18:16:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_10_07_141608_create_configs_table', 1),
(2, '2019_10_08_120352_create_characters_table', 1),
(3, '2019_10_09_000000_create_users_table', 1),
(4, '2019_10_09_105205_create_skills_table', 1),
(5, '2019_10_09_200342_create_rooms_table', 1),
(6, '2019_10_10_111645_create_user_skills_table', 1),
(7, '2019_10_12_064946_create_cate_gears_table', 1),
(8, '2019_10_12_065002_create_gears_table', 1),
(9, '2019_10_12_065026_create_user_gears_table', 1),
(10, '2019_10_12_100304_create_levels_table', 1),
(11, '2019_10_14_161901_create_fight_rooms_table', 1),
(12, '2019_10_27_123101_create_cache_table', 1),
(13, '2019_12_13_193534_create_trackings_table', 1),
(14, '2019_12_19_120635_create_pushers_table', 1),
(15, '2019_12_19_170744_create_spin_wheels_table', 1),
(16, '2019_12_27_012900_create_pets_table', 1),
(17, '2019_12_27_013106_create_user_pets_table', 1),
(18, '2019_12_29_173847_create_chat_rooms_table', 1),
(19, '2019_12_29_174028_create_chat_conversations_table', 1),
(20, '2020_01_01_184138_create_items_table', 1),
(21, '2020_01_01_215235_create_user_items_table', 1),
(22, '2020_01_02_120406_create_recovery_rooms_table', 1),
(23, '2020_01_03_121923_create_user_recovery_rooms_table', 2),
(24, '2020_01_03_142603_create_practice_rooms_table', 3),
(25, '2020_01_03_142616_create_user_practice_rooms_table', 3),
(26, '2020_01_03_143722_create_sliders_table', 3),
(27, '2020_01_07_015834_create_notifications_table', 4),
(28, '2020_01_17_102336_create_gift_codes_table', 5),
(29, '2020_01_17_102354_create_user_gift_codes_table', 6),
(30, '2020_01_17_103110_create_fight_room_logs_table', 7),
(31, '2020_03_08_004311_create_gems_table', 8),
(32, '2020_03_08_004816_create_user_gems_table', 8),
(33, '2020_03_08_004932_create_user_gear_gems_table', 8),
(34, '2020_03_08_005801_create_guilds_table', 8),
(35, '2020_03_08_005818_create_guild_members_table', 8),
(36, '2020_03_08_005835_create_guild_logs_table', 8),
(37, '2020_03_08_005851_create_guild_shops_table', 8),
(38, '2020_03_08_005920_create_guild_items_table', 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('4dafed51-d2a3-4c8a-a715-c10987a2d5a0', 'App\\Notifications\\Admin\\Broadcast', 'App\\Model\\User', 4, '{\"title\":\"S\\u1ef1 Ki\\u1ec7n \\u0110\\u00f3n T\\u1ebft 2020\",\"message\":\"<p>Qu&agrave; t\\u1eb7ng cho b\\u1ea1n :&nbsp;<\\/p>\\r\\n<p>+ 50.000 V&agrave;ng<\\/p>\\r\\n<p>+ 100 KC<\\/p>\\r\\n<p>+ 5 V&eacute; Tr&ograve; Chuy\\u1ec7n<\\/p>\\r\\n<p>+ Th&uacute; C\\u01b0\\u1ee1i R\\u1ed3ng Xanh<\\/p>\\r\\n<p>&nbsp;<\\/p>\",\"user_id\":\"100012668051362\",\"name\":\"Admin\",\"is_admin\":true}', '2020-01-07 13:36:06', '2020-01-07 13:36:01', '2020-01-07 13:36:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pets`
--

CREATE TABLE `pets` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_tag` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `strength` bigint NOT NULL DEFAULT '0',
  `intelligent` bigint NOT NULL DEFAULT '0',
  `agility` bigint NOT NULL DEFAULT '0',
  `lucky` bigint NOT NULL DEFAULT '0',
  `health_points` bigint NOT NULL DEFAULT '0',
  `armor_strength` bigint NOT NULL DEFAULT '0',
  `armor_intelligent` bigint NOT NULL DEFAULT '0',
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level_required` int NOT NULL DEFAULT '0',
  `vip_required` int NOT NULL DEFAULT '0',
  `rgb` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_type` tinyint NOT NULL DEFAULT '0',
  `price` bigint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pets`
--

INSERT INTO `pets` (`id`, `name`, `class_tag`, `strength`, `intelligent`, `agility`, `lucky`, `health_points`, `armor_strength`, `armor_intelligent`, `description`, `level_required`, `vip_required`, `rgb`, `price_type`, `price`, `status`, `created_at`, `updated_at`) VALUES
(9, 'Sói Xám', 'Wolf-Base', 10, 10, 2, 1, 30, 1, 1, NULL, 5, 0, 'whitesmoke', 0, 100000, 1, '2020-01-13 13:54:55', '2020-03-13 06:41:34'),
(10, 'Hỏa Lang', 'Wolf-Amber', 15, 15, 5, 2, 80, 3, 3, NULL, 7, 0, 'whitesmoke', 0, 250000, 1, '2020-01-13 13:55:00', '2020-03-13 06:41:56'),
(12, 'Thủy Lang', 'Wolf-Aquatic', 23, 23, 8, 5, 150, 5, 5, NULL, 7, 0, 'whitesmoke', 0, 250000, 1, '2020-01-13 14:00:16', '2020-03-13 06:42:57'),
(13, 'Sói LGBT', 'Wolf-Rainbow', 60, 60, 13, 8, 360, 8, 8, NULL, 12, 0, 'whitesmoke', 0, 550000, 1, '2020-01-13 14:01:50', '2020-03-13 06:43:28'),
(14, 'Sói Tình Yêu', 'Wolf-Cupid', 120, 120, 25, 20, 500, 15, 15, NULL, 18, 0, 'cadetblue', 0, 1500000, 1, '2020-01-13 14:09:47', '2020-03-13 06:44:05'),
(15, 'Sói Tiên', 'Wolf-Fairy', 250, 250, 40, 80, 800, 38, 38, NULL, 25, 0, 'cadetblue', 0, 2800000, 1, '2020-01-13 14:13:22', '2020-01-13 14:22:55'),
(16, 'Sói Lam Băng', 'Wolf-Frost', 380, 380, 65, 110, 1250, 52, 52, NULL, 28, 0, 'cadetblue', 1, 100, 1, '2020-01-13 14:18:02', '2020-01-13 14:23:12'),
(17, 'Cậu Vàng', 'Wolf-Golden', 450, 450, 90, 125, 1660, 70, 70, NULL, 35, 0, 'cadetblue', 1, 350, 1, '2020-01-13 14:19:31', '2020-01-13 14:23:23'),
(18, 'Lôi Lang', 'Wolf-Thunderstorm', 500, 500, 120, 175, 2350, 92, 92, NULL, 55, 0, 'green', 1, 1750, 1, '2020-01-13 14:37:06', '2020-01-14 13:29:28'),
(19, 'Lang Thần', 'Wolf-Sunshine', 660, 660, 180, 240, 3000, 120, 120, NULL, 80, 0, 'mediumpurple', 1, 5000, 1, '2020-01-13 14:40:43', '2020-01-14 13:29:11'),
(25, 'Canh Tý 2020', 'Rat-Golden', 20, 20, 20, 20, 20, 20, 20, 'Mừng xuân Canh Tý 2020', 0, 0, 'red', 1, 999999, 0, '2020-01-13 16:54:11', '2020-01-15 09:21:28'),
(26, 'Gryphon Gryphatrice', 'Gryphon-Gryphatrice', 999, 999, 999, 999, 999, 999, 999, NULL, 0, 0, 'red', 0, 0, 0, '2020-03-06 15:41:25', '2020-03-06 15:41:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `practice_rooms`
--

CREATE TABLE `practice_rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `query` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `minutes` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pushers`
--

CREATE TABLE `pushers` (
  `id` bigint UNSIGNED NOT NULL,
  `app_id` int NOT NULL,
  `app_key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_secret` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cluster` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ap1',
  `selected` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pushers`
--

INSERT INTO `pushers` (`id`, `app_id`, `app_key`, `app_secret`, `cluster`, `selected`, `created_at`, `updated_at`) VALUES
(3, 849698, 'ff57710e8efb69d5a654', '7b4acaac527e87921809', 'ap1', 1, '2020-01-17 03:15:47', '2020-01-26 19:05:41'),
(4, 917100, 'f97aa4d97f90a8180680', '8cc05abbc3634225d00f', 'ap1', 0, '2020-01-17 03:16:13', '2020-01-26 19:05:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `recovery_rooms`
--

CREATE TABLE `recovery_rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `query` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `minutes` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `recovery_rooms`
--

INSERT INTO `recovery_rooms` (`id`, `name`, `query`, `description`, `minutes`, `created_at`, `updated_at`) VALUES
(1, 'Sơ Cấp', 'UPDATE users SET energy = energy + 10 WHERE id = :id', 'Phòng bình phục sơ cấp', 30, NULL, NULL),
(2, 'Trung Cấp', 'UPDATE users SET energy = energy + 30 WHERE id = :id', 'Phòng bình phục trung cấp', 60, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `user_create_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `people` tinyint NOT NULL DEFAULT '0',
  `is_fighting` tinyint NOT NULL DEFAULT '0',
  `started_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`id`, `user_create_id`, `name`, `people`, `is_fighting`, `started_at`, `created_at`, `updated_at`) VALUES
(30, 4, '5f12cccf5e3a61595067599', 2, 0, NULL, '2020-07-18 10:19:59', '2020-07-18 10:20:07'),
(31, 614, '5f154b88b23e31595231112', 2, 0, NULL, '2020-07-20 07:45:12', '2020-07-20 07:45:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `skills`
--

CREATE TABLE `skills` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `character_id` bigint UNSIGNED NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `animation` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options` json DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `required_level` tinyint NOT NULL DEFAULT '0',
  `rgb` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` bigint NOT NULL DEFAULT '0',
  `price_type` tinyint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `skills`
--

INSERT INTO `skills` (`id`, `name`, `character_id`, `image`, `animation`, `options`, `description`, `required_level`, `rgb`, `price`, `price_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nghệ Thuật Dao Găm', 2, 'https://vignette.wikia.nocookie.net/tomeofthesun/images/b/b8/Rend.png/revision/latest?cb=20160412061125', 'https://rankingpro.app/assets/images/animations/0.gif', '{\"stun\": {\"turn\": 2, \"animation\": \"stun\", \"probability\": 50}, \"energy\": 100, \"silient\": {\"turn\": 0, \"animation\": \"silient\", \"probability\": 0}, \"coolDown\": 2, \"buffSkill\": false, \"selfEffect\": {\"lucky\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"energy\": {\"turn\": 3, \"type\": \"percent\", \"unit\": 5, \"animation\": \"buff-mana\", \"probability\": 100}, \"agility\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"available\": [\"heal_points\", \"energy\"], \"heal_points\": {\"turn\": 3, \"type\": \"percent\", \"unit\": 10, \"animation\": \"buff-hp\", \"probability\": 100}, \"intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"armor_strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"armor_intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}}, \"damageRange\": [\"300\", \"400\"], \"danamgeType\": \"number\", \"enemyEffect\": {\"lucky\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"energy\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"agility\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"available\": [], \"heal_points\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"armor_strength\": {\"turn\": 2, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"armor_intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}}, \"damageBaseOn\": \"strength\", \"passiveEffect\": {\"available\": [], \"decreDamageIn\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"strength\", \"animation\": null, \"probability\": 0}}, \"setSelfTarget\": {\"turn\": 0, \"probability\": 0}, \"clearAllDebuff\": {\"probability\": 100}, \"clearAllCoolDown\": {\"probability\": 0}, \"selfSpecialEffect\": {\"available\": [\"decreDamageIn\"], \"decreDamageIn\": {\"turn\": 2, \"type\": \"percent\", \"unit\": 30, \"baseOn\": \"strength\", \"animation\": \"cover\", \"probability\": 70}}, \"enemySpecialEffect\": {\"available\": [\"tickDamage\"], \"tickDamage\": {\"turn\": 1, \"type\": \"percent\", \"unit\": 30, \"baseOn\": \"strength\", \"animation\": \"tick\", \"probability\": 100}}, \"backgroundAnimation\": \"dark\"}', 'Gây ra +50 sát thương vật lý cho đối thủ', 1, '#eee', 0, 0, 1, NULL, NULL),
(2, 'Đập Phá', 3, 'https://vignette.wikia.nocookie.net/crusadersquest/images/b/b7/Shining_Star%21.png/revision/latest/scale-to-width-down/211?cb=20150223044028', 'https://rankingpro.app/assets/images/animations/13.gif', '{\"stun\": {\"turn\": 2, \"animation\": \"stun\", \"probability\": 50}, \"energy\": 100, \"silient\": {\"turn\": 0, \"animation\": \"silient\", \"probability\": 0}, \"coolDown\": 2, \"buffSkill\": false, \"selfEffect\": {\"lucky\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"energy\": {\"turn\": 3, \"type\": \"percent\", \"unit\": 5, \"animation\": \"buff-mana\", \"probability\": 100}, \"agility\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"available\": [\"heal_points\", \"energy\"], \"heal_points\": {\"turn\": 3, \"type\": \"percent\", \"unit\": 10, \"animation\": \"buff-hp\", \"probability\": 100}, \"intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"armor_strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"armor_intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}}, \"damageRange\": [\"300\", \"400\"], \"danamgeType\": \"number\", \"enemyEffect\": {\"lucky\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"energy\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"agility\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"available\": [], \"heal_points\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"armor_strength\": {\"turn\": 2, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"armor_intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}}, \"damageBaseOn\": \"strength\", \"passiveEffect\": {\"available\": [], \"decreDamageIn\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"strength\", \"animation\": null, \"probability\": 0}}, \"setSelfTarget\": {\"turn\": 0, \"probability\": 0}, \"clearAllDebuff\": {\"probability\": 100}, \"clearAllCoolDown\": {\"probability\": 0}, \"selfSpecialEffect\": {\"available\": [\"decreDamageIn\"], \"decreDamageIn\": {\"turn\": 2, \"type\": \"percent\", \"unit\": 30, \"baseOn\": \"strength\", \"animation\": \"cover\", \"probability\": 70}}, \"enemySpecialEffect\": {\"available\": [\"tickDamage\"], \"tickDamage\": {\"turn\": 1, \"type\": \"percent\", \"unit\": 30, \"baseOn\": \"strength\", \"animation\": \"tick\", \"probability\": 100}}, \"backgroundAnimation\": \"dark\"}', 'Gây ra +400 sát thương cơ bản và có xác suất 90% tăng 10 nhanh nhẹn trong vòng 1 lượt đánh của đối thủ', 1, '#eee', 0, 0, 1, NULL, NULL),
(3, 'Băng Phá', 4, 'https://vignette.wikia.nocookie.net/tomeofthesun/images/2/2f/Frost_Touch_Talent.png/revision/latest?cb=20160410053424', 'https://rankingpro.app/assets/images/animations/7.gif', '{\"stun\": {\"turn\": 2, \"animation\": \"stun\", \"probability\": 50}, \"energy\": 100, \"silient\": {\"turn\": 0, \"animation\": \"silient\", \"probability\": 0}, \"coolDown\": 2, \"buffSkill\": false, \"selfEffect\": {\"lucky\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"energy\": {\"turn\": 3, \"type\": \"percent\", \"unit\": 5, \"animation\": \"buff-mana\", \"probability\": 100}, \"agility\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"available\": [\"heal_points\", \"energy\"], \"heal_points\": {\"turn\": 3, \"type\": \"percent\", \"unit\": 10, \"animation\": \"buff-hp\", \"probability\": 100}, \"intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"armor_strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"armor_intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}}, \"damageRange\": [\"300\", \"400\"], \"danamgeType\": \"number\", \"enemyEffect\": {\"lucky\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"energy\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"agility\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"available\": [], \"heal_points\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"armor_strength\": {\"turn\": 2, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}, \"armor_intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"animation\": null, \"probability\": 0}}, \"damageBaseOn\": \"strength\", \"passiveEffect\": {\"available\": [], \"decreDamageIn\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"strength\", \"animation\": null, \"probability\": 0}}, \"setSelfTarget\": {\"turn\": 0, \"probability\": 0}, \"clearAllDebuff\": {\"probability\": 100}, \"clearAllCoolDown\": {\"probability\": 0}, \"selfSpecialEffect\": {\"available\": [\"decreDamageIn\"], \"decreDamageIn\": {\"turn\": 2, \"type\": \"percent\", \"unit\": 30, \"baseOn\": \"strength\", \"animation\": \"cover\", \"probability\": 70}}, \"enemySpecialEffect\": {\"available\": [\"tickDamage\"], \"tickDamage\": {\"turn\": 1, \"type\": \"percent\", \"unit\": 30, \"baseOn\": \"strength\", \"animation\": \"tick\", \"probability\": 100}}, \"backgroundAnimation\": \"dark\"}', 'Gây ra +80 sát thương phép cho đối thủ', 1, '#eee', 0, 0, 1, NULL, NULL),
(4, 'Bạo Kiếm', 3, 'https://vignette.wikia.nocookie.net/crusadersquest/images/4/47/Sonic_Sword.png/revision/latest?cb=20150210025623', 'https://rankingpro.app/assets/images/animations/32.gif', '{\"stun\": {\"turn\": 2, \"animation\": \"stun\", \"description\": \"Hiệu ứng choáng kích hoạt\", \"probability\": 50}, \"energy\": 100, \"silient\": {\"turn\": 0, \"animation\": \"silient\", \"description\": \"Hiệu ứng câm lặng kích hoạt\", \"probability\": 0}, \"coolDown\": 2, \"position\": \"freeze\", \"buffSkill\": false, \"isPassive\": false, \"damageType\": \"number\", \"selfEffect\": {\"hp\": {\"turn\": 2, \"type\": \"percent\", \"unit\": 10, \"baseOn\": \"hp\", \"animation\": \"buff-hp\", \"description\": \"+10% HP trong 2 lượt\", \"probability\": 50}, \"lucky\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"lucky\", \"animation\": null, \"description\": null, \"probability\": 0}, \"energy\": {\"turn\": 1, \"type\": \"percent\", \"unit\": 5, \"baseOn\": \"energy\", \"animation\": \"buff-mana\", \"description\": \"+5% Mana trong 1 lượt\", \"probability\": 100}, \"agility\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"agility\", \"animation\": null, \"description\": null, \"probability\": 0}, \"strength\": {\"turn\": 3, \"type\": \"percent\", \"unit\": 20, \"baseOn\": \"strength\", \"animation\": \"buff-strength\", \"description\": \"+20% Sát Thương Vật Lý trong 3 lượt\", \"probability\": 100}, \"available\": [\"hp\", \"energy\", \"strength\"], \"intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"intelligent\", \"animation\": null, \"description\": null, \"probability\": 0}, \"armor_strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"armor_strength\", \"animation\": null, \"description\": null, \"probability\": 0}, \"armor_intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"armor_intelligent\", \"animation\": null, \"description\": null, \"probability\": 0}}, \"damageRange\": [\"300\", \"400\"], \"enemyEffect\": {\"hp\": {\"turn\": 3, \"type\": \"percent\", \"unit\": -20, \"baseOn\": \"hp\", \"animation\": \"debuff-hp\", \"description\": \"-20% HP trong 3 lượt\", \"probability\": 100}, \"lucky\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"lucky\", \"animation\": null, \"description\": null, \"probability\": 0}, \"energy\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"energy\", \"animation\": null, \"description\": null, \"probability\": 0}, \"agility\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"armor_intelligent\", \"animation\": null, \"description\": null, \"probability\": 0}, \"strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"strength\", \"animation\": null, \"description\": null, \"probability\": 0}, \"available\": [\"hp\"], \"intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"intelligent\", \"animation\": null, \"description\": null, \"probability\": 0}, \"armor_strength\": {\"turn\": 2, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"armor_strength\", \"animation\": null, \"description\": null, \"probability\": 0}, \"armor_intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"armor_intelligent\", \"animation\": null, \"description\": null, \"probability\": 0}}, \"timeExecute\": 2000, \"damageBaseOn\": \"strength\", \"passiveEffect\": {\"hp\": {\"turn\": 2, \"type\": \"percent\", \"unit\": 10, \"baseOn\": \"hp\", \"initTurn\": 2, \"animation\": \"buff-hp\", \"description\": \"+10% HP\", \"probability\": 50}, \"lucky\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"lucky\", \"initTurn\": 0, \"animation\": null, \"description\": null, \"probability\": 0}, \"energy\": {\"turn\": 1, \"type\": \"percent\", \"unit\": 5, \"baseOn\": \"energy\", \"initTurn\": 1, \"animation\": \"buff-mana\", \"description\": \"+5% Mana\", \"probability\": 100}, \"agility\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"agility\", \"initTurn\": 0, \"animation\": null, \"description\": null, \"probability\": 0}, \"strength\": {\"turn\": 3, \"type\": \"percent\", \"unit\": 20, \"baseOn\": \"strength\", \"initTurn\": 3, \"animation\": \"buff-strength\", \"description\": \"+20% Sức Mạnh Vật Lý\", \"probability\": 100}, \"available\": [\"hp\"], \"intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"intelligent\", \"initTurn\": 0, \"animation\": null, \"description\": null, \"probability\": 0}, \"decreDamageIn\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"strength\", \"initTurn\": 0, \"animation\": null, \"description\": null, \"probability\": 0}, \"armor_strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"armor_strength\", \"initTurn\": 0, \"animation\": null, \"description\": null, \"probability\": 0}, \"armor_intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"armor_intelligent\", \"initTurn\": 0, \"animation\": null, \"description\": null, \"probability\": 0}}, \"setSelfTarget\": {\"turn\": 0, \"target\": \"only\", \"description\": \"Kích hoạt hiệu ứng khiêu khích\", \"probability\": 0}, \"clearAllDebuff\": {\"description\": \"Xóa bỏ tất cả hiệu ứng bất lợi\", \"probability\": 100}, \"clearAllCoolDown\": {\"description\": \"Hồi chiêu tất cả các kỹ năng\", \"probability\": 0}, \"selfSpecialEffect\": {\"available\": [\"decreDamageIn\"], \"decreDamageIn\": {\"turn\": 2, \"type\": \"percent\", \"unit\": 30, \"baseOn\": \"strength\", \"animation\": \"cover\", \"description\": \"Hiệu ứng vỏ bọc kích hoạt! Có 70% cơ hội giảm 30% sát thương nhận vào\", \"probability\": 70}}, \"enemySpecialEffect\": {\"available\": [\"tickDamage\"], \"tickDamage\": {\"turn\": 1, \"type\": \"percent\", \"unit\": 30, \"baseOn\": \"strength\", \"animation\": \"tick\", \"description\": \"Hiệu ứng đánh dấu kích hoạt! Sát thương vật lý +30% ở lượt đánh tiếp theo\", \"probability\": 100}}, \"backgroundAnimation\": \"dark\"}', '<p>Gây ra thêm 300-400 sát thương vật lý</p>\r\n\r\n<p>Có 50% cơ hội làm cho đối thủ bị choáng trong vòng 2 lượt</p>\r\n\r\n<p>Tự động hồi 10% máu, 5% mana trong vòng 3 lượt.</p>\r\n\r\n<p>Có 70% cơ hội kích hoạt hiệu ứng Vỏ Bọc giúp cho bản thân giảm 30% lượng sát thương vật lý nhận vào trong 1 lượt</p> \r\n\r\n<p>Có 100% cơ hội xóa bỏ hoàn toàn hiệu ứng bất lợi của bản thân</p>\r\n\r\n<p>Hiệu ứng đánh dấu hắc ám kích hoạt sẽ làm cho đòn đánh tiếp theo của bạn gây thêm 30% sát thương vật lý cho đối thủ trong 1 lượt</p>', 1, '#eee', 0, 0, 1, NULL, NULL),
(5, 'Băng Long', 3, 'https://vignette.wikia.nocookie.net/crusadersquest/images/b/bb/Bark_Bomb%21.png/revision/latest/scale-to-width-down/212?cb=20150630094000', 'https://rankingpro.app/assets/images/animations/4.gif', '{\"stun\": {\"turn\": 2, \"animation\": \"stun\", \"description\": \"Hiệu ứng choáng kích hoạt\", \"probability\": 50}, \"energy\": 100, \"silient\": {\"turn\": 0, \"animation\": \"silient\", \"description\": \"Hiệu ứng câm lặng kích hoạt\", \"probability\": 0}, \"coolDown\": 2, \"position\": \"freeze\", \"buffSkill\": false, \"isPassive\": true, \"damageType\": \"number\", \"selfEffect\": {\"hp\": {\"turn\": 2, \"type\": \"percent\", \"unit\": 10, \"baseOn\": \"hp\", \"animation\": \"buff-hp\", \"description\": \"+10% HP trong 2 lượt\", \"probability\": 50}, \"lucky\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"lucky\", \"animation\": null, \"description\": null, \"probability\": 0}, \"energy\": {\"turn\": 1, \"type\": \"percent\", \"unit\": 5, \"baseOn\": \"energy\", \"animation\": \"buff-mana\", \"description\": \"+5% Mana trong 1 lượt\", \"probability\": 100}, \"agility\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"agility\", \"animation\": null, \"description\": null, \"probability\": 0}, \"strength\": {\"turn\": 3, \"type\": \"percent\", \"unit\": 20, \"baseOn\": \"strength\", \"animation\": \"buff-strength\", \"description\": \"+20% Sát Thương Vật Lý trong 3 lượt\", \"probability\": 100}, \"available\": [\"hp\", \"energy\", \"strength\"], \"intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"intelligent\", \"animation\": null, \"description\": null, \"probability\": 0}, \"armor_strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"armor_strength\", \"animation\": null, \"description\": null, \"probability\": 0}, \"armor_intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"armor_intelligent\", \"animation\": null, \"description\": null, \"probability\": 0}}, \"damageRange\": [\"300\", \"400\"], \"enemyEffect\": {\"hp\": {\"turn\": 3, \"type\": \"percent\", \"unit\": -20, \"baseOn\": \"hp\", \"animation\": \"debuff-hp\", \"description\": \"-20% HP trong 3 lượt\", \"probability\": 100}, \"lucky\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"lucky\", \"animation\": null, \"description\": null, \"probability\": 0}, \"energy\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"energy\", \"animation\": null, \"description\": null, \"probability\": 0}, \"agility\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"armor_intelligent\", \"animation\": null, \"description\": null, \"probability\": 0}, \"strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"strength\", \"animation\": null, \"description\": null, \"probability\": 0}, \"available\": [\"hp\"], \"intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"intelligent\", \"animation\": null, \"description\": null, \"probability\": 0}, \"armor_strength\": {\"turn\": 2, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"armor_strength\", \"animation\": null, \"description\": null, \"probability\": 0}, \"armor_intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"armor_intelligent\", \"animation\": null, \"description\": null, \"probability\": 0}}, \"timeExecute\": 2000, \"damageBaseOn\": \"strength\", \"passiveEffect\": {\"hp\": {\"turn\": 2, \"type\": \"percent\", \"unit\": 10, \"baseOn\": \"hp\", \"initTurn\": 2, \"animation\": \"buff-hp\", \"description\": \"+10% HP\", \"probability\": 50}, \"lucky\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"lucky\", \"initTurn\": 0, \"animation\": null, \"description\": null, \"probability\": 0}, \"energy\": {\"turn\": 1, \"type\": \"percent\", \"unit\": 5, \"baseOn\": \"energy\", \"initTurn\": 1, \"animation\": \"buff-mana\", \"description\": \"+5% Mana\", \"probability\": 100}, \"agility\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"agility\", \"initTurn\": 0, \"animation\": null, \"description\": null, \"probability\": 0}, \"strength\": {\"turn\": 3, \"type\": \"percent\", \"unit\": 20, \"baseOn\": \"strength\", \"initTurn\": 3, \"animation\": \"buff-strength\", \"description\": \"+20% Sức Mạnh Vật Lý\", \"probability\": 100}, \"available\": [\"hp\"], \"intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"intelligent\", \"initTurn\": 0, \"animation\": null, \"description\": null, \"probability\": 0}, \"decreDamageIn\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"strength\", \"initTurn\": 0, \"animation\": null, \"description\": null, \"probability\": 0}, \"armor_strength\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"armor_strength\", \"initTurn\": 0, \"animation\": null, \"description\": null, \"probability\": 0}, \"armor_intelligent\": {\"turn\": 0, \"type\": \"percent\", \"unit\": 0, \"baseOn\": \"armor_intelligent\", \"initTurn\": 0, \"animation\": null, \"description\": null, \"probability\": 0}}, \"setSelfTarget\": {\"turn\": 0, \"target\": \"only\", \"description\": \"Kích hoạt hiệu ứng khiêu khích\", \"probability\": 0}, \"clearAllDebuff\": {\"description\": \"Xóa bỏ tất cả hiệu ứng bất lợi\", \"probability\": 100}, \"clearAllCoolDown\": {\"description\": \"Hồi chiêu tất cả các kỹ năng\", \"probability\": 0}, \"selfSpecialEffect\": {\"available\": [\"decreDamageIn\"], \"decreDamageIn\": {\"turn\": 2, \"type\": \"percent\", \"unit\": 30, \"baseOn\": \"strength\", \"animation\": \"cover\", \"description\": \"Hiệu ứng vỏ bọc kích hoạt! Có 70% cơ hội giảm 30% sát thương nhận vào\", \"probability\": 70}}, \"enemySpecialEffect\": {\"available\": [\"tickDamage\"], \"tickDamage\": {\"turn\": 1, \"type\": \"percent\", \"unit\": 30, \"baseOn\": \"strength\", \"animation\": \"tick\", \"description\": \"Hiệu ứng đánh dấu kích hoạt! Sát thương vật lý +30% ở lượt đánh tiếp theo\", \"probability\": 100}}, \"backgroundAnimation\": \"dark\"}', 'Gây ra +100000 sát thương phép, có 100% xác suất làm đóng băng đối thủ trong 1 lượt', 0, 'red', 0, 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `spin_wheels`
--

CREATE TABLE `spin_wheels` (
  `id` bigint UNSIGNED NOT NULL,
  `probability` int NOT NULL DEFAULT '0',
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `result_text` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `query` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `spin_wheels`
--

INSERT INTO `spin_wheels` (`id`, `probability`, `type`, `value`, `result_text`, `query`, `created_at`, `updated_at`) VALUES
(3, 65, 'image', 'https://image.flaticon.com/icons/svg/550/550638.svg', '2K Vàng', 'UPDATE users SET income_coins = income_coins + 2000 WHERE id = :id', '2020-01-17 03:08:19', '2020-01-18 03:06:56'),
(4, 55, 'image', 'https://image.flaticon.com/icons/svg/465/465261.svg', 'Chúc bạn may mắn lần sau', NULL, '2020-01-18 02:49:58', '2020-01-18 02:49:58'),
(5, 40, 'image', 'https://i.pinimg.com/originals/bf/12/2b/bf122bfc08e7b4990fcfc04e7ede91b7.png', '2 KC', 'UPDATE users SET gold = gold + 2 WHERE id = :id', '2020-01-18 02:50:45', '2020-01-18 03:06:26'),
(6, 45, 'image', 'https://image.flaticon.com/icons/svg/411/411005.svg', 'Thịt Bò x5', 'INSERT INTO user_items(user_id,item_id,quantity) VALUES(:id,4,5)', NULL, NULL),
(7, 40, 'image', 'https://image.flaticon.com/icons/svg/365/365877.svg', 'Lọ Kinh Nghiệm x2', 'INSERT INTO user_items(user_id,item_id,quantity) VALUES(:id,1,2)', NULL, NULL),
(8, 20, 'image', 'https://i.imgur.com/G5eVxx1.png', '1 Pet Ngẫu Nhiên', 'INSERT INTO user_pets(user_id,pet_id,status) VALUES(:id,(SELECT id FROM pets ORDER BY RAND() LIMIT 1),0)', '2020-01-18 03:23:46', '2020-01-18 03:23:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trackings`
--

CREATE TABLE `trackings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `trackings`
--

INSERT INTO `trackings` (`id`, `user_id`, `path`, `route`, `redirect`, `created_at`, `updated_at`) VALUES
(164, 4, 'pvp/room/5f12cccf5e3a61595067599', 'user.pvp.room', 0, '2020-07-18 10:19:59', '2020-07-18 10:19:59'),
(165, 612, 'pvp/room/5f12cccf5e3a61595067599', 'user.pvp.room', 1, '2020-07-18 10:20:07', '2020-07-18 10:20:07'),
(166, 614, 'pvp/room/5f154b88b23e31595231112', 'user.pvp.room', 1, '2020-07-20 07:45:12', '2020-07-20 07:45:12'),
(167, 613, 'pvp/room/5f154b88b23e31595231112', 'user.pvp.room', 1, '2020-07-20 07:45:17', '2020-07-20 07:45:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discord_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `character_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `coins` bigint NOT NULL DEFAULT '0',
  `gold` bigint NOT NULL DEFAULT '0',
  `exp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `strength` bigint NOT NULL DEFAULT '0',
  `intelligent` bigint NOT NULL DEFAULT '0',
  `agility` bigint NOT NULL DEFAULT '0',
  `lucky` bigint NOT NULL DEFAULT '0',
  `health_points` bigint NOT NULL DEFAULT '150',
  `armor_strength` bigint NOT NULL DEFAULT '0',
  `armor_intelligent` bigint NOT NULL DEFAULT '0',
  `full_power` bigint NOT NULL DEFAULT '0',
  `pvp_points` int NOT NULL DEFAULT '0',
  `fame` int NOT NULL DEFAULT '0',
  `isVip` tinyint NOT NULL DEFAULT '0',
  `isAdmin` tinyint NOT NULL DEFAULT '0',
  `energy` int NOT NULL DEFAULT '0',
  `location` json DEFAULT NULL,
  `pvp_times` int NOT NULL DEFAULT '0',
  `stranger_chat_times` int NOT NULL DEFAULT '0',
  `stats` json DEFAULT NULL,
  `stat_points` mediumint NOT NULL DEFAULT '0',
  `config` json DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `discord_id`, `provider_id`, `character_id`, `coins`, `gold`, `exp`, `strength`, `intelligent`, `agility`, `lucky`, `health_points`, `armor_strength`, `armor_intelligent`, `full_power`, `pvp_points`, `fame`, `isVip`, `isAdmin`, `energy`, `location`, `pvp_times`, `stranger_chat_times`, `stats`, `stat_points`, `config`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Lê Quang Vỹ', NULL, '823599581405636', 3, 75720112, 36701, '11261384', 20, 0, 5, 5, 80, 8, 8, 37027, 2, 13425, 0, 1, 2040, '{\"lat\": 21.048232472476208, \"lng\": 105.7337712121169}', 24, 16, '{\"lucky\": 0, \"agility\": 0, \"strength\": 0, \"intelligent\": 0, \"health_points\": 0, \"armor_strength\": 0, \"armor_intelligent\": 0}', 22, '{\"canChatInGlobal\": true}', 'mIo7DloTl7v0XM2qVson30PtAMyUT0Z9pGgin8wsTzV6fdiINhqdHuBCgtFO', 1, '2019-12-11 10:24:35', '2020-08-23 14:33:49'),
(612, 'Lê Tâm', NULL, '612', 2, 63758, 0, '0', 0, 0, 0, 0, 37622121, 0, 0, 0, 92812, 0, 0, 0, 177, '{\"lat\": 21.0481743, \"lng\": 105.7336908}', 5, 0, 'null', 0, '{\"canChatInGlobal\": false}', NULL, 1, '2020-03-08 15:22:23', '2020-07-20 11:44:28'),
(613, 'Luân Võ', NULL, '613', 2, 27514, 0, '0', 0, 0, 0, 0, 150, 0, 0, 1, 0, 0, 0, 0, 0, '{\"lat\": 21.0481984, \"lng\": 105.7336879}', 121, 0, 'null', 0, NULL, NULL, 1, '2020-03-08 15:22:23', '2020-07-20 07:45:59'),
(614, 'Trần Văn Trường', NULL, '614', 2, 19345, 0, '0', 0, 0, 0, 0, 150, 0, 0, 1, 0, 0, 0, 0, 0, NULL, 2121, 0, 'null', 0, NULL, NULL, 1, '2020-03-08 15:22:23', '2020-03-13 17:52:39'),
(615, 'Nguyễn Thànnh Trung', NULL, '615', 2, 10458, 0, '0', 0, 0, 0, 0, 150, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 'null', 0, NULL, NULL, 1, '2020-03-08 15:22:23', '2020-03-13 17:52:39'),
(616, 'Thành Đạt', NULL, '616', 2, 9632, 0, '0', 0, 0, 0, 0, 150, 0, 0, 0, 0, 0, 0, 0, 0, '{\"lat\": 21.0481627, \"lng\": 105.7336946}', 0, 0, 'null', 0, NULL, NULL, 1, '2020-03-08 15:22:23', '2020-08-02 07:01:48'),
(617, 'Phi Toàn', NULL, '617', 2, 10308, 0, '0', 0, 0, 0, 0, 150, 0, 0, 1, 0, 0, 0, 0, 0, NULL, 0, 0, 'null', 0, NULL, NULL, 1, '2020-03-08 15:22:23', '2020-03-13 17:52:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_gears`
--

CREATE TABLE `user_gears` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `gear_id` bigint UNSIGNED NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_gears`
--

INSERT INTO `user_gears` (`id`, `user_id`, `gear_id`, `status`, `created_at`, `updated_at`) VALUES
(38, 4, 86, 0, NULL, NULL),
(39, 4, 87, 0, NULL, NULL),
(40, 4, 88, 0, NULL, NULL),
(41, 4, 89, 0, NULL, NULL),
(42, 4, 90, 0, NULL, NULL),
(43, 4, 41, 0, NULL, NULL),
(46, 4, 92, 0, NULL, NULL),
(47, 4, 95, 0, NULL, NULL),
(48, 4, 97, 0, NULL, NULL),
(49, 4, 101, 0, NULL, NULL),
(50, 4, 104, 0, NULL, NULL),
(51, 4, 107, 0, NULL, NULL),
(52, 4, 110, 0, NULL, NULL),
(53, 4, 113, 0, NULL, NULL),
(54, 4, 30, 0, NULL, NULL),
(55, 4, 115, 1, NULL, NULL),
(56, 4, 116, 1, NULL, NULL),
(57, 4, 117, 1, NULL, NULL),
(58, 4, 71, 0, NULL, NULL),
(59, 4, 67, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_gear_gems`
--

CREATE TABLE `user_gear_gems` (
  `user_gear_id` bigint UNSIGNED NOT NULL,
  `user_gem_id` bigint UNSIGNED NOT NULL,
  `gem_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_gear_gems`
--

INSERT INTO `user_gear_gems` (`user_gear_id`, `user_gem_id`, `gem_id`, `created_at`, `updated_at`) VALUES
(38, 3, 2, '2020-08-07 14:49:32', '2020-08-07 14:49:32'),
(51, 1, 1, '2020-03-15 16:54:06', '2020-03-15 16:54:06'),
(54, 6, 1, '2020-03-14 06:14:25', '2020-03-14 06:14:25'),
(55, 14, 1, '2020-03-20 04:52:30', '2020-03-20 04:52:30'),
(55, 15, 1, '2020-03-20 04:52:32', '2020-03-20 04:52:32'),
(55, 16, 1, '2020-03-20 04:52:33', '2020-03-20 04:52:33'),
(56, 11, 1, '2020-03-20 04:52:23', '2020-03-20 04:52:23'),
(56, 12, 1, '2020-03-20 04:52:25', '2020-03-20 04:52:25'),
(56, 13, 1, '2020-03-20 04:52:26', '2020-03-20 04:52:26'),
(57, 8, 1, '2020-03-20 04:51:47', '2020-03-20 04:51:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_gems`
--

CREATE TABLE `user_gems` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `gem_id` bigint UNSIGNED NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_gems`
--

INSERT INTO `user_gems` (`id`, `user_id`, `gem_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 1, NULL, '2020-03-15 16:54:06'),
(3, 4, 2, 1, NULL, '2020-08-07 14:49:32'),
(6, 4, 1, 1, NULL, '2020-03-14 06:14:25'),
(7, 4, 2, 0, NULL, '2020-03-14 06:08:19'),
(8, 4, 1, 1, '2020-03-12 14:47:44', '2020-03-20 04:51:47'),
(9, 4, 1, 0, '2020-03-12 14:47:44', '2020-03-20 04:53:48'),
(10, 4, 1, 0, '2020-03-12 14:47:44', '2020-03-20 04:53:12'),
(11, 4, 1, 1, '2020-03-12 14:47:44', '2020-03-20 04:52:23'),
(12, 4, 1, 1, '2020-03-12 14:47:44', '2020-03-20 04:52:25'),
(13, 4, 1, 1, '2020-03-12 14:47:44', '2020-03-20 04:52:26'),
(14, 4, 1, 1, '2020-03-12 14:47:44', '2020-03-20 04:52:30'),
(15, 4, 1, 1, '2020-03-12 14:47:44', '2020-03-20 04:52:32'),
(16, 4, 1, 1, '2020-03-12 14:47:44', '2020-03-20 04:52:33'),
(17, 4, 1, 0, '2020-03-12 14:47:44', '2020-03-12 14:47:44'),
(18, 4, 2, 0, '2020-08-09 05:58:30', '2020-08-09 05:58:30'),
(19, 4, 2, 0, '2020-08-09 05:58:30', '2020-08-09 05:58:30'),
(20, 4, 2, 0, '2020-08-09 05:58:30', '2020-08-09 05:58:30'),
(21, 4, 2, 0, '2020-08-09 05:58:30', '2020-08-09 05:58:30'),
(22, 4, 2, 0, '2020-08-09 05:58:30', '2020-08-09 05:58:30'),
(23, 4, 2, 0, '2020-08-09 05:58:30', '2020-08-09 05:58:30'),
(24, 4, 2, 0, '2020-08-09 05:58:30', '2020-08-09 05:58:30'),
(25, 4, 2, 0, '2020-08-09 05:58:30', '2020-08-09 05:58:30'),
(26, 4, 2, 0, '2020-08-09 05:58:30', '2020-08-09 05:58:30'),
(27, 4, 2, 0, '2020-08-09 05:58:30', '2020-08-09 05:58:30'),
(28, 4, 2, 0, '2020-08-09 05:58:30', '2020-08-09 05:58:30'),
(29, 4, 1, 0, '2020-08-09 06:21:42', '2020-08-09 06:21:42'),
(30, 4, 1, 0, '2020-08-09 06:21:42', '2020-08-09 06:21:42'),
(31, 4, 1, 0, '2020-08-09 06:21:46', '2020-08-09 06:21:46'),
(32, 4, 1, 0, '2020-08-09 06:21:46', '2020-08-09 06:21:46'),
(33, 4, 1, 0, '2020-08-09 06:21:46', '2020-08-09 06:21:46'),
(34, 4, 1, 0, '2020-08-09 06:21:46', '2020-08-09 06:21:46'),
(35, 4, 1, 0, '2020-08-09 06:21:47', '2020-08-09 06:21:47'),
(36, 4, 1, 0, '2020-08-09 06:21:47', '2020-08-09 06:21:47'),
(37, 4, 1, 0, '2020-08-09 06:21:47', '2020-08-09 06:21:47'),
(38, 4, 1, 0, '2020-08-09 06:21:47', '2020-08-09 06:21:47'),
(39, 4, 1, 0, '2020-08-09 06:21:48', '2020-08-09 06:21:48'),
(40, 4, 1, 0, '2020-08-09 06:21:48', '2020-08-09 06:21:48'),
(41, 4, 1, 0, '2020-08-09 06:21:48', '2020-08-09 06:21:48'),
(42, 4, 1, 0, '2020-08-09 06:21:48', '2020-08-09 06:21:48'),
(43, 4, 1, 0, '2020-08-09 06:21:49', '2020-08-09 06:21:49'),
(44, 4, 1, 0, '2020-08-09 06:21:49', '2020-08-09 06:21:49'),
(45, 4, 1, 0, '2020-08-09 06:21:49', '2020-08-09 06:21:49'),
(46, 4, 1, 0, '2020-08-09 06:21:49', '2020-08-09 06:21:49'),
(47, 4, 1, 0, '2020-08-09 06:21:50', '2020-08-09 06:21:50'),
(48, 4, 1, 0, '2020-08-09 06:21:50', '2020-08-09 06:21:50'),
(49, 4, 1, 0, '2020-08-09 06:21:50', '2020-08-09 06:21:50'),
(50, 4, 1, 0, '2020-08-09 06:21:50', '2020-08-09 06:21:50'),
(51, 4, 1, 0, '2020-08-09 06:21:51', '2020-08-09 06:21:51'),
(52, 4, 1, 0, '2020-08-09 06:21:51', '2020-08-09 06:21:51'),
(53, 4, 1, 0, '2020-08-09 06:21:51', '2020-08-09 06:21:51'),
(54, 4, 1, 0, '2020-08-09 06:21:51', '2020-08-09 06:21:51'),
(55, 4, 1, 0, '2020-08-09 06:21:51', '2020-08-09 06:21:51'),
(56, 4, 1, 0, '2020-08-09 06:21:51', '2020-08-09 06:21:51'),
(57, 4, 1, 0, '2020-08-09 06:21:57', '2020-08-09 06:21:57'),
(58, 4, 1, 0, '2020-08-09 06:21:57', '2020-08-09 06:21:57'),
(59, 4, 1, 0, '2020-08-09 06:22:02', '2020-08-09 06:22:02'),
(60, 4, 1, 0, '2020-08-09 06:22:02', '2020-08-09 06:22:02'),
(61, 4, 1, 0, '2020-08-09 06:22:33', '2020-08-09 06:22:33'),
(62, 4, 1, 0, '2020-08-09 06:22:33', '2020-08-09 06:22:33'),
(63, 4, 1, 0, '2020-08-09 06:22:58', '2020-08-09 06:22:58'),
(64, 4, 1, 0, '2020-08-09 06:22:58', '2020-08-09 06:22:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_gift_codes`
--

CREATE TABLE `user_gift_codes` (
  `user_id` bigint UNSIGNED NOT NULL,
  `gift_code_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_gift_codes`
--

INSERT INTO `user_gift_codes` (`user_id`, `gift_code_id`, `created_at`, `updated_at`) VALUES
(4, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_items`
--

CREATE TABLE `user_items` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_items`
--

INSERT INTO `user_items` (`id`, `user_id`, `item_id`, `quantity`, `created_at`, `updated_at`) VALUES
(5, 4, 6, 9, NULL, '2020-03-20 05:02:50'),
(22, 4, 1, 41, NULL, '2020-07-17 13:26:09'),
(23, 4, 2, 9, NULL, '2020-03-16 09:38:09'),
(24, 4, 3, 9, NULL, '2020-03-09 15:44:26'),
(27, 4, 7, 10, NULL, NULL),
(30, 4, 4, 5, NULL, NULL),
(31, 4, 4, 5, NULL, NULL),
(32, 4, 1, 22, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_pets`
--

CREATE TABLE `user_pets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `pet_id` bigint UNSIGNED NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_pets`
--

INSERT INTO `user_pets` (`id`, `user_id`, `pet_id`, `status`, `created_at`, `updated_at`) VALUES
(7, 4, 14, 0, NULL, NULL),
(8, 4, 15, 0, NULL, NULL),
(9, 4, 16, 1, NULL, NULL),
(10, 4, 17, 0, NULL, NULL),
(33, 4, 26, 0, NULL, NULL),
(34, 4, 9, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_practice_rooms`
--

CREATE TABLE `user_practice_rooms` (
  `user_id` bigint UNSIGNED NOT NULL,
  `practice_room_id` bigint UNSIGNED NOT NULL,
  `end_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_recovery_rooms`
--

CREATE TABLE `user_recovery_rooms` (
  `user_id` bigint UNSIGNED NOT NULL,
  `recovery_room_id` bigint UNSIGNED NOT NULL,
  `end_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_skills`
--

CREATE TABLE `user_skills` (
  `user_id` bigint UNSIGNED NOT NULL,
  `skill_id` bigint UNSIGNED NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_skills`
--

INSERT INTO `user_skills` (`user_id`, `skill_id`, `status`, `created_at`, `updated_at`) VALUES
(4, 2, 1, NULL, NULL),
(4, 4, 1, NULL, NULL),
(4, 5, 1, NULL, NULL),
(612, 1, 1, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD UNIQUE KEY `cache_key_unique` (`key`);

--
-- Chỉ mục cho bảng `cate_gears`
--
ALTER TABLE `cate_gears`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `chat_conversations`
--
ALTER TABLE `chat_conversations`
  ADD PRIMARY KEY (`user_id`,`room_id`),
  ADD KEY `chat_conversations_user_id_index` (`user_id`),
  ADD KEY `chat_conversations_room_id_index` (`room_id`);

--
-- Chỉ mục cho bảng `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `fight_rooms`
--
ALTER TABLE `fight_rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fight_rooms_user_challenge_unique` (`user_challenge`),
  ADD KEY `fight_rooms_room_id_foreign` (`room_id`);

--
-- Chỉ mục cho bảng `fight_room_logs`
--
ALTER TABLE `fight_room_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fight_room_logs_user_win_id_foreign` (`user_win_id`),
  ADD KEY `fight_room_logs_user_lose_id_foreign` (`user_lose_id`);

--
-- Chỉ mục cho bảng `gears`
--
ALTER TABLE `gears`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gears_character_id_foreign` (`character_id`),
  ADD KEY `gears_cate_gear_id_foreign` (`cate_gear_id`);

--
-- Chỉ mục cho bảng `gems`
--
ALTER TABLE `gems`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `gift_codes`
--
ALTER TABLE `gift_codes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `guilds`
--
ALTER TABLE `guilds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guilds_master_id_index` (`master_id`);

--
-- Chỉ mục cho bảng `guild_items`
--
ALTER TABLE `guild_items`
  ADD PRIMARY KEY (`guild_id`,`item_id`),
  ADD KEY `guild_items_guild_id_index` (`guild_id`),
  ADD KEY `guild_items_item_id_index` (`item_id`);

--
-- Chỉ mục cho bảng `guild_logs`
--
ALTER TABLE `guild_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guild_logs_guild_id_index` (`guild_id`);

--
-- Chỉ mục cho bảng `guild_members`
--
ALTER TABLE `guild_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guild_members_guild_id_index` (`guild_id`),
  ADD KEY `guild_members_member_id_index` (`member_id`);

--
-- Chỉ mục cho bảng `guild_shops`
--
ALTER TABLE `guild_shops`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `levels_level_unique` (`level`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Chỉ mục cho bảng `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `practice_rooms`
--
ALTER TABLE `practice_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `pushers`
--
ALTER TABLE `pushers`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `recovery_rooms`
--
ALTER TABLE `recovery_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_user_create_id_foreign` (`user_create_id`);

--
-- Chỉ mục cho bảng `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `effect_rate` (`animation`),
  ADD KEY `skills_character_id_foreign` (`character_id`);

--
-- Chỉ mục cho bảng `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `spin_wheels`
--
ALTER TABLE `spin_wheels`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `trackings`
--
ALTER TABLE `trackings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trackings_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_user_id_unique` (`discord_id`),
  ADD UNIQUE KEY `users_provider_id_unique` (`provider_id`),
  ADD KEY `users_character_id_foreign` (`character_id`);

--
-- Chỉ mục cho bảng `user_gears`
--
ALTER TABLE `user_gears`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_gears_user_id_index` (`user_id`),
  ADD KEY `user_gears_gear_id_index` (`gear_id`);

--
-- Chỉ mục cho bảng `user_gear_gems`
--
ALTER TABLE `user_gear_gems`
  ADD PRIMARY KEY (`user_gear_id`,`user_gem_id`),
  ADD UNIQUE KEY `user_gem_id` (`user_gem_id`),
  ADD KEY `user_gear_gems_user_gear_id_index` (`user_gear_id`),
  ADD KEY `user_gear_gems_user_gem_id_index` (`user_gem_id`),
  ADD KEY `gem_id` (`gem_id`),
  ADD KEY `gem_id_2` (`gem_id`);

--
-- Chỉ mục cho bảng `user_gems`
--
ALTER TABLE `user_gems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_gems_user_id_index` (`user_id`),
  ADD KEY `user_gems_gem_id_index` (`gem_id`);

--
-- Chỉ mục cho bảng `user_gift_codes`
--
ALTER TABLE `user_gift_codes`
  ADD PRIMARY KEY (`user_id`,`gift_code_id`),
  ADD KEY `user_gift_codes_user_id_index` (`user_id`),
  ADD KEY `user_gift_codes_gift_code_id_index` (`gift_code_id`);

--
-- Chỉ mục cho bảng `user_items`
--
ALTER TABLE `user_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_items_user_id_index` (`user_id`),
  ADD KEY `user_items_item_id_index` (`item_id`);

--
-- Chỉ mục cho bảng `user_pets`
--
ALTER TABLE `user_pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_pets_user_id_index` (`user_id`),
  ADD KEY `user_pets_pet_id_index` (`pet_id`);

--
-- Chỉ mục cho bảng `user_practice_rooms`
--
ALTER TABLE `user_practice_rooms`
  ADD PRIMARY KEY (`user_id`,`practice_room_id`),
  ADD KEY `user_practice_rooms_user_id_index` (`user_id`),
  ADD KEY `user_practice_rooms_practice_room_id_index` (`practice_room_id`);

--
-- Chỉ mục cho bảng `user_recovery_rooms`
--
ALTER TABLE `user_recovery_rooms`
  ADD PRIMARY KEY (`user_id`,`recovery_room_id`),
  ADD KEY `user_recovery_rooms_user_id_index` (`user_id`),
  ADD KEY `user_recovery_rooms_recovery_room_id_index` (`recovery_room_id`);

--
-- Chỉ mục cho bảng `user_skills`
--
ALTER TABLE `user_skills`
  ADD PRIMARY KEY (`user_id`,`skill_id`),
  ADD KEY `user_skills_user_id_index` (`user_id`),
  ADD KEY `user_skills_skill_id_index` (`skill_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cate_gears`
--
ALTER TABLE `cate_gears`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `characters`
--
ALTER TABLE `characters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `configs`
--
ALTER TABLE `configs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `fight_rooms`
--
ALTER TABLE `fight_rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT cho bảng `fight_room_logs`
--
ALTER TABLE `fight_room_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `gears`
--
ALTER TABLE `gears`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT cho bảng `gems`
--
ALTER TABLE `gems`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `gift_codes`
--
ALTER TABLE `gift_codes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `guilds`
--
ALTER TABLE `guilds`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `guild_logs`
--
ALTER TABLE `guild_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `guild_members`
--
ALTER TABLE `guild_members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `guild_shops`
--
ALTER TABLE `guild_shops`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `pets`
--
ALTER TABLE `pets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `practice_rooms`
--
ALTER TABLE `practice_rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `pushers`
--
ALTER TABLE `pushers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `recovery_rooms`
--
ALTER TABLE `recovery_rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `skills`
--
ALTER TABLE `skills`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `spin_wheels`
--
ALTER TABLE `spin_wheels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `trackings`
--
ALTER TABLE `trackings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22076;

--
-- AUTO_INCREMENT cho bảng `user_gears`
--
ALTER TABLE `user_gears`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT cho bảng `user_gems`
--
ALTER TABLE `user_gems`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT cho bảng `user_items`
--
ALTER TABLE `user_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `user_pets`
--
ALTER TABLE `user_pets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chat_conversations`
--
ALTER TABLE `chat_conversations`
  ADD CONSTRAINT `chat_conversations_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `chat_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_conversations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `fight_rooms`
--
ALTER TABLE `fight_rooms`
  ADD CONSTRAINT `fight_rooms_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fight_rooms_user_challenge_foreign` FOREIGN KEY (`user_challenge`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `fight_room_logs`
--
ALTER TABLE `fight_room_logs`
  ADD CONSTRAINT `fight_room_logs_user_lose_id_foreign` FOREIGN KEY (`user_lose_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fight_room_logs_user_win_id_foreign` FOREIGN KEY (`user_win_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `gears`
--
ALTER TABLE `gears`
  ADD CONSTRAINT `gears_cate_gear_id_foreign` FOREIGN KEY (`cate_gear_id`) REFERENCES `cate_gears` (`id`),
  ADD CONSTRAINT `gears_character_id_foreign` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`);

--
-- Các ràng buộc cho bảng `guilds`
--
ALTER TABLE `guilds`
  ADD CONSTRAINT `guilds_master_id_foreign` FOREIGN KEY (`master_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `guild_items`
--
ALTER TABLE `guild_items`
  ADD CONSTRAINT `guild_items_guild_id_foreign` FOREIGN KEY (`guild_id`) REFERENCES `guilds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `guild_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `guild_shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `guild_logs`
--
ALTER TABLE `guild_logs`
  ADD CONSTRAINT `guild_logs_guild_id_foreign` FOREIGN KEY (`guild_id`) REFERENCES `guilds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `guild_members`
--
ALTER TABLE `guild_members`
  ADD CONSTRAINT `guild_members_guild_id_foreign` FOREIGN KEY (`guild_id`) REFERENCES `guilds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `guild_members_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_user_create_id_foreign` FOREIGN KEY (`user_create_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_character_id_foreign` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `trackings`
--
ALTER TABLE `trackings`
  ADD CONSTRAINT `trackings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_character_id_foreign` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_gears`
--
ALTER TABLE `user_gears`
  ADD CONSTRAINT `user_gears_gear_id_foreign` FOREIGN KEY (`gear_id`) REFERENCES `gears` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_gears_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_gear_gems`
--
ALTER TABLE `user_gear_gems`
  ADD CONSTRAINT `user_gear_gems_user_gear_id_foreign` FOREIGN KEY (`user_gear_id`) REFERENCES `user_gears` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_gear_gems_user_gem_id_foreign` FOREIGN KEY (`user_gem_id`) REFERENCES `user_gems` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_gems`
--
ALTER TABLE `user_gems`
  ADD CONSTRAINT `user_gems_gem_id_foreign` FOREIGN KEY (`gem_id`) REFERENCES `gems` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_gems_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_gift_codes`
--
ALTER TABLE `user_gift_codes`
  ADD CONSTRAINT `user_gift_codes_gift_code_id_foreign` FOREIGN KEY (`gift_code_id`) REFERENCES `gift_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_gift_codes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_items`
--
ALTER TABLE `user_items`
  ADD CONSTRAINT `user_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_pets`
--
ALTER TABLE `user_pets`
  ADD CONSTRAINT `user_pets_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_pets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_practice_rooms`
--
ALTER TABLE `user_practice_rooms`
  ADD CONSTRAINT `user_practice_rooms_practice_room_id_foreign` FOREIGN KEY (`practice_room_id`) REFERENCES `recovery_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_practice_rooms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_recovery_rooms`
--
ALTER TABLE `user_recovery_rooms`
  ADD CONSTRAINT `user_recovery_rooms_recovery_room_id_foreign` FOREIGN KEY (`recovery_room_id`) REFERENCES `recovery_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_recovery_rooms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_skills`
--
ALTER TABLE `user_skills`
  ADD CONSTRAINT `user_skills_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_skills_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
