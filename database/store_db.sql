-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2026 at 11:34 PM
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
-- Database: `store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `image`, `is_active`, `created_at`) VALUES
(1, 'aa', 'bb', 'carousel/697523852ab09_golf.jpg', 1, '2026-01-24 19:54:45'),
(2, 'cc', 'dd', 'carousel/6975241906fcf_ab.jpg', 1, '2026-01-24 19:57:13');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(1, 2, 5, 1, '2026-01-25 12:19:34'),
(2, 2, 3, 1, '2026-01-25 12:19:36'),
(3, 2, 4, 1, '2026-01-25 12:27:57');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `discount_percent` int(11) DEFAULT 0,
  `category` enum('shoes','clothes') DEFAULT NULL,
  `gender` enum('men','women','kids') DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_new` tinyint(1) DEFAULT 0,
  `is_offer` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `original_price`, `discount_percent`, `category`, `gender`, `image`, `is_new`, `is_offer`, `created_at`) VALUES
(1, 'bluz', 'yll', 12.00, 12.00, 0, 'clothes', 'men', '697543a2b00b9.jpg', 1, 0, '2026-01-24 22:11:46'),
(3, 'abc', 'ass', 23.00, 23.00, 0, 'shoes', 'women', '6975f87e9d4f7.jpg', 1, 1, '2026-01-25 11:03:26'),
(4, 'xxx', 'yy', 45.00, 45.00, 0, 'clothes', 'men', '6975f8aaedd0b.jpg', 1, 1, '2026-01-25 11:04:10'),
(5, 'aa', 'dsds433', 34.00, 34.00, 0, 'shoes', 'men', '6975f8ca92fcb.jpg', 1, 1, '2026-01-25 11:04:42'),
(7, 'aa', 'fsds', 34.00, 34.00, 0, 'shoes', 'women', '6975fcd1341fe.jpg', 1, 1, '2026-01-25 11:21:53'),
(8, 'aa', 'hjj', 100.00, 100.00, 0, 'shoes', 'men', '69793497c15a6.jpg', 0, 1, '2026-01-27 21:56:39'),
(9, 'aa', 'hjj', 100.00, 100.00, 40, 'shoes', 'men', '697935715a067.jpg', 0, 1, '2026-01-27 22:00:17'),
(10, 'aa', 'dfdcx', 100.00, 100.00, 40, 'shoes', 'men', '6979357cd89d9.jpg', 1, 1, '2026-01-27 22:00:28'),
(11, 'newwww', 'h', 60.00, 100.00, 40, 'shoes', 'men', '697936e52b1fd.jpg', 0, 1, '2026-01-27 22:06:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@store.com', '$2y$10$oFhjcrO1qRzrdSx796bZp.g1seHRH2rd4HIlqnE4RADcdwU.bVcIi', 'admin', '2026-01-24 20:09:17'),
(2, 'xhesilda', 'hykaxhesi1@gmail.com', '$2y$10$HdisVgsafsULnTuoIat3MO9rNRml12Co9BX2/8jqVSG6T7yuI2O0e', 'user', '2026-01-25 12:05:46');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
