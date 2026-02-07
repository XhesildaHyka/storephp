-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2026 at 09:04 PM
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
(1, 'Modern Essentials', 'Tailored layers for everyday movement', 'carousel/6983aa763aab4_carousel_2.jpg', 1, '2026-01-24 19:54:45'),
(2, 'Effortless Confidence', 'Structured comfort with a bold edge', 'carousel/6983aa0ee3b13_carousel_1.jpg', 1, '2026-01-24 19:57:13'),
(3, 'Soft Beginnings', 'Designed for comfort from the very start', 'carousel/6983ac0b3f8b4_carousel_3.jpg', 1, '2026-02-04 20:28:59');

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
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `is_read`, `created_at`) VALUES
(1, 'fdsdsfsd', 'aaa@com', 'dsdss', 'trefdeerfds', 1, '2026-02-04 11:14:19'),
(2, 'fdsdsfsd', 'aaa@com', 'dsdss', 'sxz', 1, '2026-02-04 11:21:50'),
(3, 'fdsdsfsd', 'aaa@com', 'dsdss', '78596+68', 1, '2026-02-04 11:40:26');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(30) DEFAULT 'pending',
  `phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `created_at`, `status`, `phone`, `address`) VALUES
(9, 2, 24.99, '2026-02-06 16:30:47', 'completed', '023131206', 'wrsxyrgfcv'),
(10, 1, 24.99, '2026-02-06 20:06:40', 'pending', '0683102476', 'tiran'),
(11, 1, 29.99, '2026-02-06 20:09:14', 'pending', '23212132', 'prov'),
(12, 1, 100.00, '2026-02-07 18:53:01', 'pending', '0656651561', 'rret'),
(13, 1, 100.00, '2026-02-07 18:53:49', 'pending', '032165', 'tiran'),
(14, 1, 190.00, '2026-02-07 19:46:13', 'pending', '032165', 'tirane'),
(15, 1, 90.00, '2026-02-07 19:56:58', 'pending', '0683102476', 'SA');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `size`) VALUES
(9, 9, 14, 1, 24.99, NULL),
(10, 10, 14, 1, 24.99, 'M'),
(11, 11, 15, 1, 29.99, 'S'),
(12, 12, 52, 1, 100.00, '36'),
(13, 13, 52, 1, 100.00, '36'),
(14, 14, 52, 1, 100.00, '36'),
(15, 14, 50, 1, 90.00, '41'),
(16, 15, 50, 1, 90.00, '45');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `material` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `original_price`, `discount_percent`, `category`, `gender`, `image`, `is_new`, `is_offer`, `created_at`, `material`) VALUES
(13, 'White dress', 'A clean, elegant white dress with a timeless silhouette, soft flowing fabric, and a light, effortless feel—perfect for a fresh, graceful look.', 17.59, 21.99, 20, 'clothes', 'women', '6983354720fcf.jpeg', 0, 1, '2026-02-04 12:02:15', 'Cotton'),
(14, 'Brown Women cinch dress', 'A warm, brown dress with a rich, earthy tone and a flattering silhouette, offering a cozy yet elegant look that feels both timeless and effortlessly chic.', 24.99, 24.99, 0, 'clothes', 'women', '6983359a630d7.jpeg', 1, 0, '2026-02-04 12:03:38', 'Canvas'),
(15, 'Denim mini dress', 'A stylish denim mini dress with a fitted silhouette and classic blue wash, combining casual charm with a modern edge for an easy, everyday look.', 29.99, 29.99, 0, 'clothes', 'women', '698335d182926.jpeg', 1, 0, '2026-02-04 12:04:33', 'Cotton'),
(16, 'Doubled-breasted dress', 'A tailored double-breasted dress with structured lines and a flattering fit, featuring polished buttons and a refined silhouette for a confident, sophisticated look.\r\n', 39.99, 39.99, 0, 'clothes', 'women', '6983363af07ad.jpeg', 1, 0, '2026-02-04 12:06:18', 'Cotton'),
(17, 'Black dress', 'A chic short black dress with a sleek silhouette and clean lines, offering a timeless, effortlessly elegant look perfect for any occasion.\r\n', 44.99, 49.99, 10, 'clothes', 'women', '698336a2f1912.jpeg', 0, 1, '2026-02-04 12:08:02', 'Cotton'),
(18, 'Sporty Burgundy Dress', 'A sporty burgundy dress with a rich, deep tone and a comfortable fit, blending athletic-inspired style with a modern, effortless edge.\r\n', 39.99, 39.99, 0, 'clothes', 'women', '69833715362a7.jpeg', 1, 0, '2026-02-04 12:09:57', 'Cotton'),
(19, 'Tennis dress', 'A lightweight tennis dress with a flattering fit and breathable fabric, designed for easy movement while keeping a clean, sporty, and stylish look on and off the court.\r\n', 42.49, 49.99, 15, 'clothes', 'women', '698337896ed3f.jpeg', 0, 1, '2026-02-04 12:11:53', 'Cotton'),
(20, 'Baby blue dress', 'A soft baby blue dress with delicate line detailing, featuring a fresh, airy feel and a flattering silhouette for a clean, modern look.\r\n', 17.84, 20.99, 15, 'clothes', 'women', '6983382596778.jpeg', 0, 1, '2026-02-04 12:14:29', 'Cotton'),
(21, 'Ralph Lauren dress', 'A refined beige dress by **Ralph Lauren**, featuring a timeless silhouette and understated elegance, perfect for a polished, classic look.\r\n', 99.99, 99.99, 0, 'clothes', 'women', '6983386e68804.jpeg', 1, 0, '2026-02-04 12:15:42', 'Cotton'),
(22, 'Black mini skirt', 'A sleek black mini skirt with a flattering fit and clean lines, offering a versatile, modern staple that pairs effortlessly with any look.\r\n', 12.99, 12.99, 0, 'clothes', 'women', '698338c0128eb.jpeg', 1, 0, '2026-02-04 12:17:04', 'Cotton'),
(23, 'Denim skirt', 'A classic denim skirt with a flattering fit and timeless wash, blending casual style with everyday versatility for an easy, laid-back look.\r\n', 13.49, 14.99, 10, 'clothes', 'women', '6983391a88789._', 0, 1, '2026-02-04 12:18:34', 'Jeans'),
(24, 'Flowing brown skirt', 'A flowing brown maxi skirt with a rich, earthy tone and graceful drape, creating an elegant yet relaxed look with effortless movement.\r\n', 29.99, 29.99, 0, 'clothes', 'women', '6983397a04537.jpeg', 1, 0, '2026-02-04 12:20:10', 'Cotton'),
(25, 'Elegant beach skirt', 'An elegant beach skirt with a light, flowing fabric and a graceful silhouette, offering an airy, refined look that moves beautifully in the ocean breeze.\r\n', 39.99, 39.99, 0, 'clothes', 'women', '698339f1b4fa6.jpeg', 1, 0, '2026-02-04 12:22:09', 'Cotton'),
(26, 'Beige pants', 'Clean, versatile beige pants with a tailored fit and a soft, neutral tone, perfect for creating an effortlessly polished everyday look.\r\n', 12.74, 14.99, 15, 'clothes', 'women', '69833a5be42b6.jpeg', 0, 1, '2026-02-04 12:23:55', 'Cotton'),
(27, 'Wide-leg jeans', 'Wide-leg jeans with a relaxed fit and structured denim, offering a modern silhouette that blends comfort with effortless, on-trend style.\r\n', 23.99, 29.99, 20, 'clothes', 'women', '69833aa13f9d7.jpeg', 0, 1, '2026-02-04 12:25:05', 'Jeans'),
(28, 'Classic beige shirt', 'A classic beige men’s shirt in a refined, old-money style, featuring a clean cut, high-quality fabric, and understated elegance for a timeless, sophisticated look.\r\n', 39.99, 39.99, 0, 'clothes', 'men', '69833bb959ff4.jpeg', 1, 0, '2026-02-04 12:29:45', 'Cotton'),
(29, 'Beige polo sweater', 'A beige polo sweater with a refined knit and classic collar, blending soft texture with understated elegance for a polished, old-money inspired look.\r\n', 49.99, 49.99, 0, 'clothes', 'men', '69833c6f69685.jpeg', 1, 0, '2026-02-04 12:32:47', 'Cotton'),
(30, 'short-sleeve linen shirt', 'short-sleeve linen shirt', 24.99, 24.99, 0, 'clothes', 'men', '69833d146b130.jpeg', 1, 0, '2026-02-04 12:35:32', 'Cotton'),
(31, 'royal blue sweater', 'A men’s royal blue sweater with a rich, bold tone and a clean, tailored fit, offering a polished look that’s both classic and effortlessly stylish.\r\n', 41.39, 45.99, 10, 'clothes', 'men', '69833d8b92c21.jpeg', 0, 1, '2026-02-04 12:37:31', 'Cotton'),
(32, 'Wide black pants', 'Wide black pants for men with a relaxed, structured fit and clean lines, delivering a modern, confident look that balances comfort and sophistication.\r\n', 69.99, 69.99, 0, 'clothes', 'men', '69833df8d036a.jpeg', 1, 0, '2026-02-04 12:39:20', 'Cotton'),
(33, 'Classic black tie', 'A classic black tie for men with a sleek, refined finish, adding timeless elegance and a polished touch to any formal look.\r\n', 31.19, 38.99, 20, 'clothes', 'men', '69833e71a0f74.jpeg', 0, 1, '2026-02-04 12:41:21', 'Cotton'),
(34, 'Brown pants', 'Brown pants for men with a tailored fit and warm, versatile tone, offering a refined look that works effortlessly for both casual and smart outfits.\r\n', 47.99, 59.99, 20, 'clothes', 'men', '69833ef83e80c.jpeg', 0, 1, '2026-02-04 12:43:36', 'Cotton'),
(35, 'men’s Hawaiian shirt', 'A men’s Hawaiian shirt with bold tropical prints and a relaxed fit, bringing a vibrant, laid-back island vibe to any casual summer look.\r\n', 53.99, 59.99, 10, 'clothes', 'men', '6983403c13449.jpeg', 0, 1, '2026-02-04 12:49:00', 'Cotton'),
(36, 'white and black men’s polo sweater', 'A white and black men’s polo sweater with a clean, modern contrast, featuring a refined knit and classic collar for a sharp yet effortless look.\r\n', 30.99, 30.99, 0, 'clothes', 'men', '698340d7c42a8.jpeg', 1, 0, '2026-02-04 12:51:35', ''),
(37, 'shirt for baby boys', 'A soft, comfortable shirt for baby boys made from gentle, breathable fabric, designed with an easy fit for all-day comfort and a cute, classic look.\r\n', 29.99, 29.99, 0, 'clothes', 'kids', '698341e262b32.jpeg', 1, 0, '2026-02-04 12:56:02', 'Cotton'),
(38, 'cozy brown shirt for kids', 'A cozy brown shirt for kids with a soft feel and comfortable fit, featuring a warm, earthy tone that’s perfect for everyday wear.\r\n', 20.99, 20.99, 0, 'clothes', 'kids', '69834236a329c.jpeg', 1, 0, '2026-02-04 12:57:26', 'Cotton'),
(39, 'Comfortable kids’ pants with subtle ', 'Comfortable kids’ pants with subtle line detailing, designed in a soft fabric and easy fit for everyday play while adding a stylish, modern touch.\r\n', 27.89, 30.99, 10, 'clothes', 'kids', '698342d965232.jpeg', 0, 1, '2026-02-04 13:00:09', NULL),
(40, 'Beige pants for kids', 'Soft beige pants for kids with a comfortable fit and a clean, neutral tone, perfect for everyday wear and easy outfit pairing.\r\n', 25.49, 29.99, 15, 'clothes', 'kids', '6983432837986.jpeg', 0, 1, '2026-02-04 13:01:28', 'Cotton'),
(41, 'Red dress for little girls', 'A bright red dress for little kids with a soft, comfortable fit and a cheerful design, perfect for playful days and special moments.\r\n', 49.99, 49.99, 0, 'clothes', 'kids', '698343af66687.jpeg', 1, 0, '2026-02-04 13:03:43', 'Cotton'),
(42, 'charming blue dress for girls', 'A charming blue dress for girls with a soft fabric and comfortable fit, offering a sweet, playful look perfect for everyday wear or special occasions.\r\n', 42.49, 49.99, 15, 'clothes', 'kids', '698343ff09d97.jpeg', 0, 1, '2026-02-04 13:05:03', 'Cotton'),
(43, 'Yellow dress for little girls', 'A cheerful yellow dress for kids with a soft, breathable fabric and a comfortable fit, bringing a bright, happy touch to everyday outfits.\r\n', 59.99, 59.99, 0, 'clothes', 'kids', '6983443878b56.jpeg', 1, 0, '2026-02-04 13:06:00', 'Cotton'),
(44, 'Royal Blue Dress', 'A vibrant royal blue dress for kids with a soft, comfortable fit and a rich color, perfect for special occasions or stylish everyday wear.\r\n', 39.99, 49.99, 20, 'clothes', 'kids', '6983448edfb93.jpeg', 0, 1, '2026-02-04 13:07:26', 'Cotton'),
(45, 'Brown Heels', 'Open-Toe Heels for women', 49.99, 49.99, 0, 'shoes', 'women', '698354a7385f2.jpeg', 1, 0, '2026-02-04 14:16:07', 'Leather'),
(46, 'Black Heels', 'Leopard Print Pointed Heels', 59.99, 59.99, 0, 'shoes', 'women', '6983550a01a91.jpeg', 1, 0, '2026-02-04 14:17:46', 'Leather'),
(47, 'Black Leather Boots', 'Black Pointed Heel Ankle Boots', 120.00, 120.00, 0, 'shoes', 'women', '698355695dfe0.jpeg', 1, 0, '2026-02-04 14:19:21', 'Leather'),
(48, 'Black Polka Dots Flats', 'Charming polka dot flats with a comfortable fit and playful pattern, adding a fun yet stylish touch to any outfit.', 55.00, 55.00, 0, 'shoes', 'women', '698355db0735a.jpeg', 1, 0, '2026-02-04 14:21:15', 'Canvas'),
(49, 'Slingback Beige Heels', 'Elegant slingback heels in a soft cream tone with a contrasting black cap toe, finished with a comfortable block heel for a polished, timeless look that works from day to evening.', 95.50, 95.50, 0, 'shoes', 'women', '69835650927ad.jpeg', 1, 0, '2026-02-04 14:23:12', 'Leather'),
(50, 'Beige and Blue Sneakers', 'Classic beige suede sneakers with a low-profile silhouette, finished with contrasting stripes and a gum sole for a clean, retro-inspired look that’s easy to wear every day.', 90.00, 100.00, 10, 'shoes', 'women', '698356f4c4647.jpeg', 0, 1, '2026-02-04 14:25:56', ''),
(51, 'White Sneakers', 'Trendy white sneakers with a sporty silhouette and breathable mesh panels, offering all-day comfort and a clean, modern look perfect for casual wear.', 96.00, 120.00, 20, 'shoes', 'women', '6983574c402a5.jpeg', 0, 1, '2026-02-04 14:27:24', 'Cotton'),
(52, 'Uggs', 'Cozy brown suede mini boots with a platform sole and soft lining, offering a warm, stylish look with added comfort and a modern edge.', 100.00, 200.00, 50, 'shoes', 'women', '6983578ea1a3f.jpeg', 0, 1, '2026-02-04 14:28:30', 'Cotton'),
(53, 'Black Loafers', 'A pair of black chunky loafers with a glossy finish, featuring bold gold chain detailing and a thick treaded sole for a modern, edgy yet polished look.', 35.00, 69.99, 50, 'shoes', 'women', '6983585ed97cd.jpeg', 1, 1, '2026-02-04 14:31:58', 'Leather'),
(54, 'Black Leather Loafers', 'A pair of classic black leather loafers with a smooth polished finish and clean, timeless design, offering understated elegance and everyday sophistication.', 79.99, 79.99, 0, 'shoes', 'men', '698359d88b37f.jpeg', 1, 0, '2026-02-04 14:38:16', 'Leather');

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `product_id`, `size`, `stock`) VALUES
(1415, 50, '30', 0),
(1416, 50, '31', 0),
(1417, 50, '32', 0),
(1418, 50, '33', 0),
(1419, 50, '34', 0),
(1420, 50, '35', 0),
(1421, 50, '36', 33),
(1422, 50, '37', 3),
(1423, 50, '38', 3),
(1424, 50, '39', 3),
(1425, 50, '40', 3),
(1426, 50, '41', 3),
(1427, 50, '42', 3),
(1428, 50, '43', 33),
(1429, 50, '44', 3),
(1430, 50, '45', 1),
(1431, 50, '46', 3),
(1432, 54, '30', 0),
(1433, 54, '31', 0),
(1434, 54, '32', 0),
(1435, 54, '33', 0),
(1436, 54, '34', 0),
(1437, 54, '35', 0),
(1438, 54, '36', 5),
(1439, 54, '37', 5),
(1440, 54, '38', 5),
(1441, 54, '39', 5),
(1442, 54, '40', 0),
(1443, 54, '41', 5),
(1444, 54, '42', 52),
(1445, 54, '43', 2),
(1446, 54, '44', 2),
(1447, 54, '45', 0),
(1448, 54, '46', 2),
(1449, 53, '30', 0),
(1450, 53, '31', 0),
(1451, 53, '32', 0),
(1452, 53, '33', 0),
(1453, 53, '34', 0),
(1454, 53, '35', 0),
(1455, 53, '36', 2),
(1456, 53, '37', 2),
(1457, 53, '38', 2),
(1458, 53, '39', 2),
(1459, 53, '40', 2),
(1460, 53, '41', 2),
(1461, 53, '42', 2),
(1462, 53, '43', 2),
(1463, 53, '44', 2),
(1464, 53, '45', 2),
(1465, 53, '46', 2),
(1466, 52, '30', 0),
(1467, 52, '31', 0),
(1468, 52, '32', 0),
(1469, 52, '33', 0),
(1470, 52, '34', 0),
(1471, 52, '35', 0),
(1472, 52, '36', 2),
(1473, 52, '37', 2),
(1474, 52, '38', 2),
(1475, 52, '39', 2),
(1476, 52, '40', 2),
(1477, 52, '41', 2),
(1478, 52, '42', 2),
(1479, 52, '43', 22),
(1480, 52, '44', 1),
(1481, 52, '45', 2),
(1482, 52, '46', 2),
(1483, 51, '30', 0),
(1484, 51, '31', 0),
(1485, 51, '32', 0),
(1486, 51, '33', 0),
(1487, 51, '34', 0),
(1488, 51, '35', 0),
(1489, 51, '36', 2),
(1490, 51, '37', 2),
(1491, 51, '38', 2),
(1492, 51, '39', 2),
(1493, 51, '40', 2),
(1494, 51, '41', 2),
(1495, 51, '42', 2),
(1496, 51, '43', 2),
(1497, 51, '44', 2),
(1498, 51, '45', 2),
(1499, 51, '46', 2),
(1500, 49, '30', 0),
(1501, 49, '31', 0),
(1502, 49, '32', 0),
(1503, 49, '33', 0),
(1504, 49, '34', 0),
(1505, 49, '35', 0),
(1506, 49, '36', 2),
(1507, 49, '37', 2),
(1508, 49, '38', 2),
(1509, 49, '39', 2),
(1510, 49, '40', 2),
(1511, 49, '41', 0),
(1512, 49, '42', 2),
(1513, 49, '43', 2),
(1514, 49, '44', 2),
(1515, 49, '45', 22),
(1516, 49, '46', 2),
(1517, 48, '30', 0),
(1518, 48, '31', 0),
(1519, 48, '32', 0),
(1520, 48, '33', 0),
(1521, 48, '34', 0),
(1522, 48, '35', 0),
(1523, 48, '36', 2),
(1524, 48, '37', 2),
(1525, 48, '38', 2),
(1526, 48, '39', 0),
(1527, 48, '40', 2),
(1528, 48, '41', 2),
(1529, 48, '42', 2),
(1530, 48, '43', 2),
(1531, 48, '44', 2),
(1532, 48, '45', 22),
(1533, 48, '46', 2),
(1534, 47, '30', 0),
(1535, 47, '31', 0),
(1536, 47, '32', 0),
(1537, 47, '33', 0),
(1538, 47, '34', 0),
(1539, 47, '35', 0),
(1540, 47, '36', 2),
(1541, 47, '37', 2),
(1542, 47, '38', 2),
(1543, 47, '39', 2),
(1544, 47, '40', 2),
(1545, 47, '41', 2),
(1546, 47, '42', 2),
(1547, 47, '43', 2),
(1548, 47, '44', 2),
(1549, 47, '45', 2),
(1550, 47, '46', 2),
(1551, 46, '30', 0),
(1552, 46, '31', 0),
(1553, 46, '32', 0),
(1554, 46, '33', 0),
(1555, 46, '34', 0),
(1556, 46, '35', 0),
(1557, 46, '36', 2),
(1558, 46, '37', 2),
(1559, 46, '38', 0),
(1560, 46, '39', 2),
(1561, 46, '40', 2),
(1562, 46, '41', 2),
(1563, 46, '42', 2),
(1564, 46, '43', 2),
(1565, 46, '44', 2),
(1566, 46, '45', 2),
(1567, 46, '46', 2),
(1568, 45, '30', 0),
(1569, 45, '31', 0),
(1570, 45, '32', 0),
(1571, 45, '33', 0),
(1572, 45, '34', 0),
(1573, 45, '35', 0),
(1574, 45, '36', 2),
(1575, 45, '37', 2),
(1576, 45, '38', 2),
(1577, 45, '39', 2),
(1578, 45, '40', 2),
(1579, 45, '41', 2),
(1580, 45, '42', 2),
(1581, 45, '43', 2),
(1582, 45, '44', 2),
(1583, 45, '45', 22),
(1584, 45, '46', 2);

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
(1, 'Admin', 'admin@store.com', '$2y$10$xEhYe8hgA82hy6k4vlmh6OXLw5626ZI8V902ygKDjWb0vtmu1do8G', 'admin', '2026-01-24 20:09:17'),
(2, 'xhesilda', 'hykaxhesi1@gmail.com', '$2y$10$HdisVgsafsULnTuoIat3MO9rNRml12Co9BX2/8jqVSG6T7yuI2O0e', 'user', '2026-01-25 12:05:46'),
(4, 'Ersa', 'ersa@ksmc', '$2y$10$/CZaNUqWSXGZqQYu.7hCp.VNvjpfOWIMIPs5uNmQO8qhR8XlF9WUa', 'user', '2026-02-04 11:36:57');

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
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_product_size` (`product_id`,`size`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1585;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
