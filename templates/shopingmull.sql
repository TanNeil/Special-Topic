-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-06-02 14:22:43
-- 伺服器版本： 10.4.25-MariaDB
-- PHP 版本： 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `shopingmull`
--

-- --------------------------------------------------------

--
-- 資料表結構 `area`
--

CREATE TABLE `area` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `area`
--

INSERT INTO `area` (`id`, `name`, `number`) VALUES
(1, '飲料區', '1號貨架'),
(2, '飲料區', '2號貨架'),
(3, '飲料區', '3號貨架'),
(4, '生用用品區', '1號貨架'),
(5, '生活用品區', '2號貨架'),
(6, '零食區', '1號貨架'),
(7, '零食區', '2號貨架'),
(8, '零食區', '3號貨架'),
(9, '麵包區', '1號貨架'),
(10, '麵包區', '2號貨架'),
(11, '酒區', '1號貨架'),
(12, '酒區', '2號貨架'),
(13, '飲料區', '4號貨架');

-- --------------------------------------------------------

--
-- 資料表結構 `combine`
--

CREATE TABLE `combine` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `combine`
--

INSERT INTO `combine` (`id`, `name`, `price`) VALUES
(1, '牙刷搭配牙膏', '只要100元'),
(2, '福樂牛奶搭配吐司', '只要50元!!'),
(3, '光泉牛奶搭配波羅', '只要20元!!'),
(4, '可樂搭配薯條三兄弟', '不用錢!'),
(5, '台灣啤酒搭配花生', '只要300元!!'),
(6, '雪山啤酒搭配鱈魚香絲', '優惠價250元~'),
(7, '無', '無');

-- --------------------------------------------------------

--
-- 資料表結構 `info`
--

CREATE TABLE `info` (
  `id` int(10) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sale` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `many_sale` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `c_id` int(11) NOT NULL,
  `a_id` int(11) NOT NULL,
  `image` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `info`
--

INSERT INTO `info` (`id`, `name`, `price`, `sale`, `many_sale`, `c_id`, `a_id`, `image`) VALUES
(1, '牙膏', '20元', '特價只要10元!', '買三送一!!', 1, 4, '0'),
(2, '牙膏', '15元', '10元', '買三送二', 1, 5, '0'),
(3, '福樂牛奶', '原價125元', '特價只要100元', '買一送一!!', 2, 1, 'https://reurl.cc/p6x53l'),
(4, '光泉牛奶', '原價130元', '特價只要110元', '買三送二!', 3, 2, '0'),
(5, '可樂', '原價30元', '現在只要1塊錢!', '買二送二', 4, 3, '0'),
(6, '薯條三兄弟', '原價66元', '現在50元有找!', '買一送一~', 4, 6, '0'),
(7, '花生', '原價10元', '特價5元', '買二送三', 5, 7, '0'),
(8, '鱈魚香絲', '一包60元', '現在只要25元', '買二送二', 6, 8, '0'),
(9, '吐司', '一條45元', '一條現在只要20元!!!', '買一送一不囉嗦~', 2, 9, '0'),
(10, '波羅', '一個25元', '今天只要15元!', '買5送3', 3, 10, '0'),
(11, '台灣啤酒', '一打125元', '限時優惠100元~', '買三送二!', 5, 11, '0'),
(12, '雪山啤酒', '一打250元', '現在200元有找!', '買二送一!', 6, 12, '0'),
(13, '抹香柚茶', '15元', '無', '第二件10塊', 7, 13, '0');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `combine`
--
ALTER TABLE `combine`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `info_ibfk_1` (`c_id`),
  ADD KEY `a_id` (`a_id`);

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `info`
--
ALTER TABLE `info`
  ADD CONSTRAINT `info_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `combine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `info_ibfk_2` FOREIGN KEY (`a_id`) REFERENCES `area` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
