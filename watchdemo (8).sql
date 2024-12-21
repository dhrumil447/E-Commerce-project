-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 09:34 AM
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
-- Database: `watchdemo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(2, 'admin@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `cust_id`, `product_id`, `quantity`, `added_at`) VALUES
(25, 7, 8, 4, '2024-11-22 16:07:53'),
(26, 7, 16, 1, '2024-11-22 16:35:54'),
(32, 9, 15, 2, '2024-11-22 20:05:56'),
(34, 1, 17, 1, '2024-11-23 08:19:34'),
(36, 1, 15, 3, '2024-11-26 07:58:33'),
(37, 11, 15, 1, '2024-11-27 07:03:54'),
(38, 12, 15, 1, '2024-11-28 13:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `subject`, `message`, `date_sent`) VALUES
(1, 'Dhrumil Patel', 'dhrumil.447@gmail.com', 'I want to the couple watch ', 'Titan couple watch', '2024-11-22 19:56:40'),
(2, 'Dhrumil Patel', 'k@gmail.com', 'hi', 'helo', '2024-11-23 04:31:17'),
(3, 'Dhrumil Patel', 'k@gmail.com', 'order return ', 'product id damaged', '2024-11-23 06:11:29');

-- --------------------------------------------------------

--
-- Table structure for table `cust_registration`
--

CREATE TABLE `cust_registration` (
  `cust_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zipCode` varchar(10) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cust_registration`
--

INSERT INTO `cust_registration` (`cust_id`, `username`, `email`, `phone`, `state`, `district`, `address`, `city`, `zipCode`, `password`) VALUES
(1, 'Dhrumil Patel', 'dhrumil.447@gmail.com', '9512721508', 'State', ' sk', 'Jadar idar', 'idar', '383111', '$2y$10$VlHM9z.eDUwrDqCLCsgwGuVGqDKQWiJGDQi5KbSicvBByil708tr6'),
(7, 'meme_addiictt', 'memeaddict847@gmail.com', '9104567258', 'Gujarat', 'Mehsana', 'Ganpat Vidyanagar ,Mehsana-Gozaria Highway, G.V. Nagar-384012 Mehsana, Gujarat, INDIA.', 'Mahesana', '384012', '$2y$10$Sp.DqHTV07uWXS7FSD3DK.LLV7PvKshuCugY/rK0.1P2xhVKaYQFe'),
(8, 'Mihir Patel', 'm@gmail.com', '9104567258', 'Gujarat', 'Mehsana', 'Ganpat Vidyanagar ,Mehsana-Gozaria Highway, G.V. Nagar-384012 Mehsana, Gujarat, INDIA.', 'Mahesana', '384012', '$2y$10$UZA22fgQ7gxmcKem4nGAq.9PiF2T/ENcV9bN4IMamCbsfszWWX6rm'),
(9, 'Hitarth Patel', 'h@gmail.com', '9512721508', 'Gujarat', 'sabarkantha', 'jadar idar sabarkantha', 'Jadar', '383110', '$2y$10$cG1zQCDxIZr6xibqS.idJexJMYzgLrQFb.rY3soFhN5PKYMrhv0fG'),
(10, 'kalp patel', 'k@gmail.com', '9952566332', 'Munpur', 'MUNPUR', 'Idar', 'Jadar', '383110', '$2y$10$TBL2M/5xbRi6/djv9bl4MeIv4Mud94oxiJQXDZjIOCBxfXus/dLLG'),
(11, 'hitarth', 'hitarthp29@gmail.com', '9913618010', 'Gujarat', 'sabarkantha', 'Idar', 'Jadar', '383110', '$2y$10$mz3KkUoE/.AoheU7rtQ.u.Di5pWPYJ.vga4yPL6tQDyq8x7cs2E3m'),
(12, 'hitarth', 'hitarthp299@gmail.com', '09913618010', 'Gujarat', 'sk', 'Idar', 'Jadar', '383110', '$2y$10$0iUtA8m6Z4pq7cqZP7nwq.Skzz9FyhymFCCfX7Em1wit8bjf290k2');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('UPI','COD') NOT NULL,
  `payment_details` varchar(255) DEFAULT NULL,
  `order_status` enum('Pending','Confirmed','Rejected','Shipped','Out for Delivery','Delivered','Canceled') DEFAULT 'Pending',
  `order_date` datetime DEFAULT current_timestamp(),
  `admin_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `cust_id`, `total_amount`, `payment_method`, `payment_details`, `order_status`, `order_date`, `admin_update`) VALUES
(1, 1, 43500.00, 'UPI', 'dhrumil@ybl', 'Confirmed', '2024-11-23 00:18:12', '2024-11-26 19:13:18'),
(3, 9, 199.00, 'UPI', 'dhrumil@ybl', 'Shipped', '2024-11-23 01:04:06', '2024-11-24 19:34:19'),
(4, 9, 5000.00, 'UPI', 'dhrumil@ybl', 'Confirmed', '2024-11-23 01:38:33', '2024-11-26 21:31:30'),
(7, 1, 1450.00, 'UPI', 'dhrumil@ybl', 'Shipped', '2024-11-23 13:50:22', '2024-11-25 08:20:01'),
(14, 1, 1450.00, 'COD', 'Cash On Delivery', 'Rejected', '2024-11-24 23:56:55', '2024-11-24 19:34:33'),
(16, 1, 1450.00, 'COD', 'Cash On Delivery', 'Confirmed', '2024-11-25 00:19:40', '2024-11-24 19:47:09'),
(17, 1, 1450.00, 'COD', 'Cash On Delivery', 'Confirmed', '2024-11-25 13:47:16', '2024-11-25 08:17:48'),
(18, 1, 1450.00, 'COD', 'Cash On Delivery', '', '2024-11-26 12:52:44', '2024-11-26 07:22:58'),
(19, 1, 1450.00, 'COD', 'Cash On Delivery', 'Canceled', '2024-11-26 13:22:33', '2024-11-26 07:52:39'),
(20, 11, 2500.00, 'UPI', 'dhrumil@ybl', 'Confirmed', '2024-11-27 12:34:06', '2024-11-27 07:05:26'),
(21, 11, 2500.00, 'UPI', 'dhrumil@ybl', 'Pending', '2024-11-27 12:55:55', '2024-11-27 07:25:55'),
(22, 11, 2500.00, 'UPI', '', 'Pending', '2024-11-27 12:56:05', '2024-11-27 07:26:05'),
(23, 11, 2500.00, 'COD', 'Cash On Delivery', 'Pending', '2024-11-28 10:30:08', '2024-11-28 05:00:08'),
(24, 12, 2500.00, 'COD', 'Cash On Delivery', 'Pending', '2024-11-28 18:32:28', '2024-11-28 13:02:28'),
(25, 12, 2500.00, 'COD', 'Cash On Delivery', 'Pending', '2024-11-28 18:36:43', '2024-11-28 13:06:43');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `price`, `quantity`, `created_at`, `product_id`) VALUES
(1, 1, 2500.00, 1, '2024-11-22 18:48:12', 15),
(2, 1, 25000.00, 1, '2024-11-22 18:48:12', 16),
(3, 1, 16000.00, 1, '2024-11-22 18:48:12', 7),
(5, 3, 199.00, 1, '2024-11-22 19:34:06', 6),
(6, 4, 2500.00, 2, '2024-11-22 20:08:33', 15),
(11, 7, 1450.00, 1, '2024-11-23 08:20:22', 17),
(18, 14, 1450.00, 1, '2024-11-24 18:26:55', 17),
(20, 16, 1450.00, 1, '2024-11-24 18:49:40', 17),
(21, 17, 1450.00, 1, '2024-11-25 08:17:16', 17),
(22, 18, 1450.00, 1, '2024-11-26 07:22:44', 17),
(23, 19, 1450.00, 1, '2024-11-26 07:52:33', 17),
(24, 20, 2500.00, 1, '2024-11-27 07:04:06', 15),
(25, 21, 2500.00, 1, '2024-11-27 07:25:55', 15),
(26, 22, 2500.00, 1, '2024-11-27 07:26:05', 15),
(27, 23, 2500.00, 1, '2024-11-28 05:00:08', 15),
(28, 24, 2500.00, 1, '2024-11-28 13:02:28', 15),
(29, 25, 2500.00, 1, '2024-11-28 13:06:43', 15);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_details` varchar(255) DEFAULT NULL,
  `payment_status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `cust_id`, `payment_method`, `payment_details`, `payment_status`, `created_at`) VALUES
(2, 16, 1, 'COD', 'Cash On Delivery', 'Accepted', '2024-11-24 18:49:40'),
(3, 17, 1, 'COD', 'Cash On Delivery', 'Accepted', '2024-11-25 08:17:16'),
(4, 18, 1, 'COD', 'Cash On Delivery', 'Pending', '2024-11-26 07:22:44'),
(5, 19, 1, 'COD', 'Cash On Delivery', 'Pending', '2024-11-26 07:52:33'),
(6, 20, 11, 'UPI', 'dhrumil@ybl', 'Pending', '2024-11-27 07:04:06'),
(7, 21, 11, 'UPI', 'dhrumil@ybl', 'Pending', '2024-11-27 07:25:55'),
(8, 22, 11, 'UPI', '', 'Pending', '2024-11-27 07:26:05'),
(9, 23, 11, 'COD', 'Cash On Delivery', 'Pending', '2024-11-28 05:00:08'),
(10, 24, 12, 'COD', 'Cash On Delivery', 'Pending', '2024-11-28 13:02:28'),
(11, 25, 12, 'COD', 'Cash On Delivery', 'Pending', '2024-11-28 13:06:43');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` enum('Smart Watch','Digital Watch','Analouge Watch') NOT NULL,
  `gender` enum('Men','Women') NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `availability` varchar(50) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL,
  `width` varchar(50) DEFAULT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `manufacturer` varchar(100) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `category`, `gender`, `image`, `availability`, `brand`, `height`, `width`, `weight`, `color`, `manufacturer`, `image1`, `image2`, `image3`) VALUES
(6, 'SELLORIA Silicone Unisex ', 'SELLORIA Silicone Unisex Sports Digital Boy\'S Watch (Green Dial Green Colored Strap)', 199.00, 'Digital Watch', 'Men', 'boydigial3.jpg', 'In Stock', 'SELLORIA Silicone', '3', '3', '30', 'green', 'SELLORIA Silicone Pvt Ltd', 'boydigial3.jpg', 'boydigital33.jpg', 'boydigial333.jpg'),
(7, 'Titan Men\'s Maritime Pro ', 'Titan Men\'s Maritime Pro Lateen Sail Chronograph Green Leather Watch-NS1830KL02', 16000.00, 'Analouge Watch', 'Men', 'boyanalog1.jpg', 'In Stock', 'titan', '3', '3', '30', 'green', 'titan Pvt.Ltd', 'boyanalog1.jpg', 'boyanalog11.jpg', 'boyanalog111.jpg'),
(8, 'Titan Classic Silver ', 'Titan Classic Silver Dial Analog with Date Leather Strap watch for Men-NS1584SL03', 5000.00, 'Analouge Watch', 'Men', 'boyanalog2.jpg', 'In Stock', 'titan', '3', '3', '30', 'white', 'titan Pvt.Ltd', 'boyanalog2.jpg', 'boyanalog22.jpg', 'boyanalog222.jpg'),
(9, 'Fastrack Men Quartz ', 'Fastrack Men Quartz Analog Black Dial Leather Strap Watch for Guys-NS38051SL02', 1600.00, 'Analouge Watch', 'Men', 'boyanalog3.jpg', 'In Stock', 'fastrack', '3', '3', '30', 'black', 'Fastrack Pvt Ltd', 'boyanalog3.jpg', 'boyanalog33.jpg', 'boyanalog333.jpg'),
(10, 'Noise ColorFit Pro 4 ', 'Noise ColorFit Pro 4 Alpha 1.78\" AMOLED Display, Bluetooth Calling Smart Watch, Functional Crown, Metallic Build, Intelligent Gesture Control, Instacharge (Rose Pink)', 2500.00, 'Smart Watch', 'Women', 'womansmart1.jpg', 'In Stock', 'Noise', '3', '3', '30', 'pink', 'Noise Pvt Ltd', 'womansmart1.jpg', 'womansmart11.jpg', 'womansmart111.jpg'),
(11, 'Noise Pulse ', 'Noise Pulse 2 Max 1.85\" Display, Bluetooth Calling Smart Watch, 10 Days Battery, 550 NITS Brightness, Smart DND, 100 Sports Modes, Smartwatch for Men and Women (Deep Wine)', 1400.00, 'Smart Watch', 'Women', 'womansmart2.jpg', 'In Stock', 'Noise', '3', '3', '30', 'deep wine', 'Noise Pvt Ltd', 'womansmart2.jpg', 'womansmart22.jpg', 'womansmart222.jpg'),
(13, 'Gio ', 'Gio Collection Classic Stylish Analog Watch for Women Classy Dial with 3 Hand Mechanism Water Resistant Wrist Watch to Compliment Your Look/Ideal Gift for Female & Girls - G3061', 1400.00, 'Analouge Watch', 'Women', 'womananalog1.jpg', 'In Stock', 'Gio', '3', '3', '30', 'goldan', 'Gio Pvt.Ltd', 'womananalog1.jpg', 'womananalog11.jpg', 'womananalog111.jpg'),
(14, 'Titan', 'Titan Women\'s Lagan Chic: Studded Brown Dial Leather Analog Watch with & Elegant Hands-2656WL01', 2000.00, 'Analouge Watch', 'Women', 'womananalog2.jpg', 'In Stock', 'titan', '3', '3', '30', 'Brown', 'titan Pvt.Ltd', 'womananalog2.jpg', 'womananalog22.jpg', 'womananalog222.jpg'),
(15, 'Noise ColorFit Ultra 3', 'Noise ColorFit Ultra 3 Bluetooth Calling Smart Watch with Biggest 1.96\" AMOLED Display, Premium Metallic Build, Functional Crown, Gesture Control with Silicon Strap (Jet Black)', 2500.00, 'Smart Watch', 'Men', 'noise.jpg', 'In Stock', 'Noise', '3', '3', '30', 'black', 'Noise Pvt Ltd', 'noise.jpg', 'noise1.jpg', 'noise2.jpg'),
(16, 'Samsung Galaxy Watch 7 ', 'Samsung Galaxy Watch 7 (44mm, Silver, BT) with 3nm Processor | Dual GPS | Sapphire Glass & Armour Aluminum | 5ATM & IP68 | HR, SpO2, BP & ECG Monitor', 25000.00, 'Smart Watch', 'Men', 'fasttrack.jpg', 'In Stock', 'Samsung', '3', '3', '30', 'Black', 'Samsung Pvt.Ltd', 'fasttrack.jpg', 'fasttrack1.jpg', 'fasttrack2.jpg'),
(17, 'Noise ColorFit Pro 5 Max', 'Noise ColorFit Pro 5 Max 1.96\" AMOLED Display Smart Watch, BT Calling, Post Training Workout Analysis, VO2 Max, Rapid Health, 5X Faster Data Transfer - Space Blue', 1450.00, 'Smart Watch', 'Men', 'boysmart1.jpg', 'In Stock', 'Noise', '3', '3', '30', 'Space blue', 'Noise Pvt Ltd', 'boysmart1.jpg', 'boysmart11.jpg', 'boysmart111.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cust_registration`
--
ALTER TABLE `cust_registration`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_items_ibfk_2` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cust_registration`
--
ALTER TABLE `cust_registration`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `cust_registration` (`cust_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `cust_registration` (`cust_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`cust_id`) REFERENCES `cust_registration` (`cust_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
