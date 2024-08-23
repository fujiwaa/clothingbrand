-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 23, 2024 at 09:37 PM
-- Server version: 8.0.37-cll-lve
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `soulnivc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `location_id` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `city` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` int NOT NULL,
  `latitude` varchar(20) NOT NULL,
  `longitude` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `user_id`, `location_id`, `full_name`, `phone`, `country`, `city`, `address`, `postal_code`, `latitude`, `longitude`, `email`, `created_at`, `updated_at`) VALUES
(2, 1, '', 'Muh Syahrul Minanul Aziz', '081572323740', 'Indonesia', 'Bandung', 'jln. ', 0, '-6.9623157', '109.0564449', 'msyahrulma@gmail.com', '2024-06-27 17:14:51', '2024-06-27 17:14:51'),
(3, 1, '', 'Arul', '081234567890', 'Indonesia', 'Kec. Jatibarang, Kab. Brebes', 'Jl. KH. Malawi, Kertasinduyasa', 52261, '-6.9623157', '109.0564449', 'msyahrulma@gmail.com', '2024-06-27 17:15:34', '2024-07-22 17:54:55');

-- --------------------------------------------------------

--
-- Table structure for table `calender`
--

CREATE TABLE `calender` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `start` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calender`
--

INSERT INTO `calender` (`id`, `title`, `start`, `created_at`, `updated_at`) VALUES
(2, 'hahaha', '2024-07-12', '2024-07-03 19:18:52', '2024-07-03 19:18:52'),
(4, 'coba', '2024-07-11', '2024-07-08 00:18:10', '2024-07-16 23:40:33'),
(6, 'haha', '2024-07-16', '2024-07-08 00:33:56', '2024-07-16 23:40:24'),
(7, 'restock hoodie', '2024-07-21', '2024-07-08 23:19:37', '2024-07-08 23:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `image`, `name`) VALUES
(1, 'limited-edition.png', 'LIMITED EDITION'),
(2, 'tshirt.png', 'TSHIRT'),
(3, 'hoodie.png', 'HOODIE'),
(4, 'workshirt.png', 'WORKSHIRT'),
(5, 'longsleeve.png', 'LONGSLEEVE');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Belum Dibaca', '2024-07-03 01:28:51', '2024-07-03 01:28:51'),
(2, 2, 'Belum Dibaca', '2024-07-03 01:28:51', '2024-07-03 01:28:51'),
(3, 1, 'Belum Dibaca', '2024-07-03 01:28:51', '2024-07-03 01:28:51');

-- --------------------------------------------------------

--
-- Table structure for table `chat_reply`
--

CREATE TABLE `chat_reply` (
  `id` int NOT NULL,
  `chat_id` int NOT NULL,
  `sender` varchar(10) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read_admin` int NOT NULL DEFAULT '0',
  `is_read_user` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat_reply`
--

INSERT INTO `chat_reply` (`id`, `chat_id`, `sender`, `message`, `is_read_admin`, `is_read_user`, `created_at`) VALUES
(1, 1, 'user', 'Lorem ipsum dolor sit amet.', 0, 0, '2024-07-03 01:19:58'),
(2, 2, 'user', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat, ut!', 0, 0, '2024-07-03 01:19:58'),
(3, 3, 'user', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat, ut!', 0, 0, '2024-07-03 01:19:58'),
(4, 3, 'admin', 'hello', 0, 0, '2024-07-03 01:19:58'),
(5, 3, 'user', 'oke', 0, 0, '2024-07-03 23:10:16'),
(6, 3, 'user', 'siap', 0, 0, '2024-07-03 23:11:30'),
(7, 3, 'user', 'p', 0, 0, '2024-07-18 20:33:03'),
(8, 3, 'user', 'p', 0, 0, '2024-07-18 20:33:06'),
(9, 3, 'user', 'p', 0, 0, '2024-07-18 20:33:06'),
(10, 3, 'user', 'p', 0, 0, '2024-07-18 20:33:33');

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE `configuration` (
  `id` int NOT NULL,
  `c_key` varchar(50) NOT NULL,
  `c_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`id`, `c_key`, `c_value`) VALUES
(1, 'web-name', 'Soulniv'),
(2, 'web-logo', '66452dd732e79_logo.png'),
(3, 'web-address', 'Jl. Abdul Ghoni, Sidopurno 2, Sidokepung, Kabupaten Sidoarjo, Jawa Timur'),
(4, 'web-email', 'msyahrulma@gmail.com'),
(5, 'web-phone', '081234567890'),
(6, 'web-area-id', ''),
(7, 'web-latitude', '-7.4207162'),
(8, 'web-longitude', '112.7094401'),
(9, 'web-postal-code', '61252'),
(10, 'web-couriers', 'jne,jnt,sicepat'),
(11, 'web-sender', 'jiwa'),
(12, 'web-key-biteship', 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiU09VTE5JViIsInVzZXJJZCI6IjY2OWFkMjM1YzYzMTgwMDAxMmEwM2I4ZCIsImlhdCI6MTcyMTY0Mzc0NX0.b3grHp9Ep0vWR7rp1_3BC97_6uYOdigopQUvvUh6j0k');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `id` int NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_image` text NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_category` varchar(100) NOT NULL,
  `size` varchar(5) NOT NULL,
  `quantity` double NOT NULL,
  `price` double NOT NULL,
  `payment` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `expedition` varchar(100) NOT NULL,
  `expedition_type` varchar(20) NOT NULL,
  `tracking_id` varchar(100) NOT NULL,
  `receipt` varchar(100) NOT NULL,
  `price_shipping` double NOT NULL,
  `payment_url` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`id`, `order_id`, `user_id`, `product_id`, `product_image`, `product_name`, `product_category`, `size`, `quantity`, `price`, `payment`, `status`, `expedition`, `expedition_type`, `tracking_id`, `receipt`, `price_shipping`, `payment_url`, `created_at`, `updated_at`) VALUES
(1, '8817324036397', 1, 4, 'longsleeve.png', 'SOULNIV Tee Oversize - SWEET HEART', 'LONGSLEEVE', 'XL', 1, 1000, 'QRIS', 'Dikemas', 'jnt', 'ez', 'dcNuHMJp2ZkSN1Y7KsAB3yZ1', 'WYB-1723825950621', 0, 'https://tripay.co.id/checkout/T3319417657763B5PFK', '2024-08-16 23:28:12', '2024-08-23 19:00:04'),
(2, '2514818746527', 1, 4, 'longsleeve.png', 'SOULNIV Tee Oversize - SWEET HEART', 'LONGSLEEVE', 'L', 1, 1000, 'QRIS', 'Dibatalkan', 'jnt', 'ez', '', '', 16000, 'https://tripay.co.id/checkout/T33194176723682LTFM', '2024-08-17 23:20:58', '2024-08-18 23:22:05'),
(3, '2514818746527', 1, 5, 'workshirt.png', 'SOULNIV Tee Oversize - SWEET HEART', 'WORKSHIRT', 'M', 1, 1000, 'QRIS', 'Dibatalkan', 'jnt', 'ez', '', '', 16000, 'https://tripay.co.id/checkout/T33194176723682LTFM', '2024-08-17 23:20:58', '2024-08-18 23:22:05'),
(4, '8795376514201', 1, 5, 'workshirt.png', 'SOULNIV Tee Oversize - SWEET HEART', 'WORKSHIRT', 'XL', 2, 2000, 'QRIS', 'Selesai', 'jnt', 'ez', '4uKcbCbm8ETmvT1snYiw3evp', 'WYB-1723912114008', 0, 'https://tripay.co.id/checkout/T3319417672390JGK3H', '2024-08-17 23:24:17', '2024-08-18 00:14:04'),
(5, '8795376514201', 1, 4, 'longsleeve.png', 'SOULNIV Tee Oversize - SWEET HEART', 'LONGSLEEVE', 'L', 1, 1000, 'QRIS', 'Selesai', 'jnt', 'ez', '4uKcbCbm8ETmvT1snYiw3evp', 'WYB-1723912114008', 0, 'https://tripay.co.id/checkout/T3319417672390JGK3H', '2024-08-17 23:24:17', '2024-08-18 00:14:04');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `code` varchar(20) NOT NULL,
  `category` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `name`, `logo`, `code`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Mandiri Virtual Account', 'mandiri.png', 'MANDIRIVA', 'Transfer Bank', '2024-07-14 22:19:06', '2024-07-14 22:19:06'),
(2, 'BRI Virtual Account', 'bri.png', 'BRIVA', 'Transfer Bank', '2024-07-14 22:19:06', '2024-07-14 22:19:06'),
(3, 'BNI Virtual Account', 'bni.png', 'BNIVA', 'Transfer Bank', '2024-07-14 22:19:06', '2024-07-14 22:19:06'),
(4, 'Permata Virtual Account', 'permata.png', 'PERMATAVA', 'Transfer Bank', '2024-07-14 22:19:06', '2024-07-14 22:19:06'),
(5, 'Danamon Virtual Account', 'danamon.png', 'DANAMONVA', 'Transfer Bank', '2024-07-14 22:19:06', '2024-07-14 22:19:06'),
(6, 'BSI Virtual Account', 'bsi.png', 'BSIVA', 'Transfer Bank', '2024-07-14 22:19:06', '2024-07-14 22:19:06'),
(7, 'Alfamart', 'alfamart.png', 'ALFAMART', 'Minimarket', '2024-07-14 22:19:06', '2024-07-14 22:19:06'),
(8, 'OVO', 'ovo.png', 'OVO', 'E-Money', '2024-07-14 22:19:06', '2024-07-14 22:19:06'),
(9, 'QRIS', 'qris.png', 'QRIS', 'E-Money', '2024-07-14 22:19:06', '2024-07-14 22:19:06');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `image` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `size` varchar(50) NOT NULL,
  `stock` double NOT NULL,
  `status` varchar(20) NOT NULL,
  `display` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `rating` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `image`, `name`, `category`, `price`, `size`, `stock`, `status`, `display`, `description`, `rating`, `created_at`, `updated_at`) VALUES
(1, 'baju-3.png,baju-1.png,baju-2.png,tshirt.png', 'SOULNIV Tee Oversize - SWEET HEART', 'LIMITED EDITION', 100000, 'S,M,L,XL', 10, 'Tersedia', 'Ya', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos expedita illo ut enim deserunt animi nam maiores praesentium eveniet atque?', '5', '2024-06-28 17:35:16', '2024-06-28 17:35:21'),
(2, 'baju-1.png', 'SOULNIV Workshirt Boxy - Lost', 'LIMITED EDITION', 100000, 'S,M,L,XL', 10, 'Tersedia', 'Ya', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos expedita illo ut enim deserunt animi nam maiores praesentium eveniet atque?', '4.89', '2024-06-28 17:35:25', '2024-06-28 17:35:26'),
(3, 'baju-2.png', 'SOULNIV Double Sleeve Oversize - Star', 'LIMITED EDITION', 100000, 'S,M,L,XL', 10, 'Diarsipkan', 'Ya', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos expedita illo ut enim deserunt animi nam maiores praesentium eveniet atque?', '4.89', '2024-06-28 17:35:30', '2024-06-28 17:35:32'),
(4, 'longsleeve.png', 'SOULNIV Tee Oversize - SWEET HEART', 'LONGSLEEVE', 1000, 'S,M,L,XL', 10, 'Tersedia', 'Tidak', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos expedita illo ut enim deserunt animi nam maiores praesentium eveniet atque?', '5', '2024-06-28 17:35:35', '2024-06-28 17:35:44'),
(5, 'workshirt.png', 'SOULNIV Tee Oversize - SWEET HEART', 'WORKSHIRT', 1000, 'S,M,L,XL', 10, 'Tersedia', 'Tidak', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos expedita illo ut enim deserunt animi nam maiores praesentium eveniet atque?', '5', '2024-06-28 17:35:38', '2024-07-27 18:02:57'),
(6, 'tshirt.png', 'SOULNIV Tee Oversize - SWEET HEART', 'TSHIRT', 100000, 'S,M,L,XL', 10, 'Tersedia', 'Tidak', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos expedita illo ut enim deserunt animi nam maiores praesentium eveniet atque?', '5', '2024-06-28 17:35:40', '2024-06-28 17:35:49'),
(7, '668c1c40b0574_hoodie.png', 'SOULNIV Tee Oversize - SWEET HEART', 'HOODIE,LIMITED EDITION', 300000, 'S,M,L,XL', 10, 'Tersedia', 'Tidak', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos expedita illo ut enim deserunt animi nam maiores praesentium eveniet atque?', '0', '2024-07-08 22:35:18', '2024-07-09 00:05:04');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_image` text NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `rating` varchar(5) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `order_id`, `product_id`, `product_image`, `product_name`, `image`, `rating`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'baju-1.png', 'SOULNIV Workshirt Boxy - Lost', '', '5.0', 'Baguss barangnya', '2024-06-30 23:31:58', '2024-06-30 23:31:58'),
(2, 2, 3, 'baju-2.png', 'SOULNIV Double Sleeve Oversize - Star', '', '4.6', 'Baguss', '2024-06-30 23:31:58', '2024-06-30 23:34:30'),
(3, 2, 3, 'baju-2.png', 'SOULNIV Double Sleeve Oversize - Star', '', '5.0', 'Baguss deh', '2024-06-30 23:31:58', '2024-06-30 23:34:30'),
(4, 2, 2, 'baju-1.png', 'SOULNIV Workshirt Boxy - Lost', '668571cd4d834_hoodie.png', '4.0', 'coba', '2024-07-03 22:44:13', '2024-07-03 22:44:13'),
(5, 3, 3, 'baju-2.png', 'SOULNIV Double Sleeve Oversize - Star', '6685723b23fa0_baju-1.png', '3.0', 'lumayan', '2024-07-03 22:46:03', '2024-07-03 22:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `profile` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `full_name`, `profile`, `email`, `password`, `level`, `created_at`, `updated_at`) VALUES
(1, 'Muh Syahrul Minanul Aziz', 'user.png', 'msyahrulma@gmail.com', '$2y$10$eV5K5Uwng62eCJIrmuV4lu3VN95ppap7kM4OvbvFUkA2Te1n11plS', 'Admin', '2024-06-27 17:23:29', '2024-06-27 17:23:29'),
(2, 'dilla', 'user.png', 'dillac@email.com', '$2y$10$e1G3usd1wPwJgrzLQL6cRO9hXuxr5MeVTs2lwU2Kw5sV8JzQ0kMr6', 'Admin', '2024-06-28 02:40:25', '2024-06-28 02:40:25'),
(3, 'dilla', 'user.png', 'dilla@email.com', '$2y$10$sRln06kSpIZ0UhMoZUYLputcmammxO4Ccefp4llcb432dAvwrKP4m', 'Admin', '2024-06-28 02:41:00', '2024-06-28 02:41:00'),
(5, 'Dzik', 'user.png', 'dz@mail.com', '$2y$10$oQ0RNyDynPRmXwLSluQyC.bvbOBrPKZrKsejq8SXtmuQ818dK1wO.', 'Admin', '2024-07-11 10:15:48', '2024-07-11 10:15:48'),
(6, 'demo', 'user.png', 'demo@gmail.com', '$2y$10$T6fQhkdrI/fEOfiHWvy0ROWNroiAwIasKIJ.JxZpYP6z9cGw8.6/K', 'Member', '2024-07-16 16:18:34', '2024-07-16 16:18:34'),
(7, 'Muhammad Iman Furqon', 'user.png', 'yaelahman0810@gmail.com', '$2y$10$/kOa6.QDpTZq1ZjzoSzNi.SP/HvM1Hxpu6ts5UB4p1osa2PfA3kL6', 'Member', '2024-07-20 14:39:57', '2024-07-20 14:39:57'),
(9, 'Muhammad Khoulifuji', 'user.png', 'fuji@email.com', '$2y$10$O5PxNPlAUlgB1ilSJ.5h0elTnXPNLsmNFxkRxShKfOgAahRBHkTGu', 'Admin', '2024-07-23 18:17:20', '2024-07-23 18:17:20'),
(10, 'aditya', 'user.png', 'codotadit109@gmail.com', '$2y$10$ysbjxaAy/xhpg4uC.EZldeHZkUPWB8B5A9hFTgyOoMii8TrxWgP/.', 'Member', '2024-07-24 21:37:19', '2024-07-24 21:37:19'),
(11, 'Idola Aji Bayu Darma', 'user.png', 'idolaajib@gmail.com', '$2y$10$xnhwI4zx3eBYFzBDaPNxYe7lYehMV6.4EgYoZsHSUYDQGwO1dD5V.', 'Member', '2024-07-24 21:54:30', '2024-07-24 21:54:30'),
(12, 'Muhammad Khoulifuji', 'user.png', 'm.khoulifuji@gmail.com', '$2y$10$o1lm9lGmjmmVe2SjLxf8z.WHyOymP7MWUR5.une1vL7wEBHY6kjCm', 'Member', '2024-07-24 21:58:46', '2024-07-24 21:58:46'),
(13, 'aditya', 'user.png', 'adit@students.amikom.ac.id', '$2y$10$e4tC1R9Hyi4/EJlEh2P.rOLigYu/FDpZkShb50ByHVlIg2LB6N64S', 'Member', '2024-07-26 10:32:22', '2024-07-26 10:32:22'),
(14, 'rian', 'user.png', 'sikkentvchannel5@gmail.com', '$2y$10$eEFoUjH.o/pburBO2DpPKeI2E4pXIolH.GxRLf.EzImnNw09NQ9cC', 'Member', '2024-08-05 15:58:42', '2024-08-05 15:58:42'),
(15, 'rian', 'user.png', 'test@email.com', '$2y$10$s8xco7gjw6k6wl3VKzGp4uYbLfa7FTSUxwDt1IO4cmZkUwRnqiS8q', 'Member', '2024-08-07 15:13:30', '2024-08-07 15:13:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calender`
--
ALTER TABLE `calender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_reply`
--
ALTER TABLE `chat_reply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `calender`
--
ALTER TABLE `calender`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chat_reply`
--
ALTER TABLE `chat_reply`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
