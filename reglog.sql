-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 05:49 AM
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
-- Database: `reglog`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `cart_qty` int(50) NOT NULL,
  `cart_size` varchar(150) NOT NULL,
  `cart_color` varchar(150) NOT NULL,
  `cart_user` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `proditem_id` int(150) NOT NULL,
  `order_size` varchar(150) NOT NULL,
  `order_color` varchar(150) NOT NULL,
  `order_qty` int(150) NOT NULL,
  `order_user` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `proditem_id`, `order_size`, `order_color`, `order_qty`, `order_user`) VALUES
(1, 2, '5cm', 'Color: Silver-Plated', 1, 'kvro'),
(2, 1, '12', 'black', 1, 'kvro');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `product_info` varchar(255) NOT NULL,
  `product_img` varchar(150) NOT NULL,
  `product_category` varchar(150) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_size` varchar(150) NOT NULL,
  `product_color` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_info`, `product_img`, `product_category`, `product_price`, `product_size`, `product_color`, `username`) VALUES
(2, 'Lapiz earrings', 'Add a touch of timeless elegance to your jewelry collection with our stunning Lapis Lazuli\r\nEarrings. Known for its deep, celestial blue hue and rich historical significance, Lapis Lazuli has\r\nbeen a symbol of wisdom and truth for centuries. These earring', '667981190edda.jpg', 'Accessories', 150131, '5cm, 6cm, 7cm, 8cm, 9cm', 'Color: Silver-Plated, Gold-Plated', 'howl123'),
(3, 'Diamond necklace', 'Experience the epitome of luxury with our breathtaking Diamond Necklace. Designed for\r\nthose who appreciate the finer things in life, this necklace is a dazzling display of elegance and\r\nsophistication. Perfect for special occasions or as a timeless gift,', '667982883ac60.jpg', 'Accessories', 8000, '0.25carats, .50carats, 1carat', 'Silver-Plated, Gold-Plated', 'kvro'),
(4, 'Emerald necklace', 'Elevate your elegance with our stunning Emerald Necklace. Renowned for their vibrant\r\ngreen hue and timeless allure, emeralds have long been a symbol of beauty and sophistication.\r\nThis necklace is a perfect addition to any jewelry collection, ideal for s', '6679837ccf2d3.jpg', 'Accessories', 5000, '0.25carats, .50carats, 1carat', 'Silver-Plated, Gold-Plated', 'kvro'),
(5, 'Timex watch', 'Discover the perfect blend of style, durability, and functionality with our Timex Watch.\r\nKnown for its reliability and timeless design, this watch is an essential accessory for anyone\r\nseeking both practicality and elegance. Whether for everyday wear or ', '6679843db6ae7.jpg', 'Accessories', 4500, '16mm, 21mm, 24mm', 'Black, White, Blue, Brown', 'kvro'),
(6, 'Samsung S95D SMART TV', 'Immerse yourself in the ultimate viewing experience with the 77&quot; OLED S95D 4K Smart\r\nTV (2024) by leading technology innovator. This television combines state-of-the-art display\r\ntechnology with smart features, delivering unparalleled picture quality', '667984f9c80b8.jpg', 'Entertainment', 169949, '55”, 66”, 77”', 'Black', 'howl123'),
(7, 'Sony Bravia 8', 'Experience the pinnacle of television technology with the Bravia 8, a masterpiece in\r\nvisual and audio innovation. Crafted to redefine home entertainment, this television sets new\r\nstandards with its advanced features and breathtaking performance.', '6679856a7aa80.jpg', 'Entertainment', 46949, '55”, 65”', 'Black', 'howl123'),
(8, 'Samsung Q-Series Soundbar ', 'Immerse yourself in a superior audio experience with the Q-Series Soundbar HW-Q990C\r\nby Samsung. Designed to complement your home entertainment setup, this soundbar delivers\r\nexceptional sound quality and versatility, enhancing your viewing and listening ', '667985df18295.jpg', 'Entertainment', 80990, '130.9 x 59.5 x 27cm', 'black, white, grey', 'howl123'),
(9, 'LG Soundbar SC9S', 'Elevate your home audio experience with the LG Soundbar SC9S, a top-tier sound\r\nsolution designed to provide immersive sound quality and versatility. Ideal for complementing\r\nyour TV setup, this soundbar enriches your entertainment with clear dialogue, im', '6679868929c24.jpg', 'Entertainment', 29990, '975 x 63 x 125 mm', 'black, white, grey', 'howl123'),
(10, 'POND&#39;S ANTI AGING DAY CREAM', 'With Pond&#39;s Age Miracle Day Cream, you get the skin-renewing benefits of retinol even\r\nduring the day. Anti-aging + Brightening + Hydrating, all in one in 1 miracle jar', '667988a551efc.jpg', 'Health & Personal Care', 155, '10G', 'n/a', 'kvro'),
(11, 'POND&#39;S MEN FACIAL WASH ', 'Haggard? Get whiter and energized skin with Pond&#39;s Men Energy Charge', '66798938c1681.jpg', 'Health & Personal Care', 134, '50g', 'n/a', 'kvro'),
(12, 'AXE BODY SPRAY BLACK', 'Fragrance Body Spray, A light and refined fragrance for the understated man who oozes\r\nquiet confidence', '6679898fd3ab1.jpg', 'Health & Personal Care', 145, '50ml', 'n/a', 'kvro'),
(13, 'DOVE BAR SENSITIVE SKIN', 'Our mild touch for Sensitive Skin, this Dove Beauty Bar is a hypoallergenic, fragrance-\r\nfree formula that&#39;s gentle on sensitive skin', '66798a0947792.jpg', 'Health & Personal Care', 214, '100g', 'n/a', 'kvro'),
(14, 'Bench Oversized Loose Pants', 'Bench Oversized Loose Pants', '66798cbbb663a.jpg', 'Mens Apparel', 1299, 'L, XL', 'black', 'howl123'),
(15, 'Bench x Riize Men&#39;s Twill Pants', 'Bench x Riize Men&#39;s Twill Pants', '66798d2e792ba.jpg', 'Mens Apparel', 899, 'M, L, XL, XXL', 'brown', 'howl123'),
(16, 'H&amp;M muslin resort shirt', 'Regular-fit shirt in airy cotton muslin with a resort collar, French front, short sleeves and a\r\nstraight-cut hem with a slit at each side.', '66798d801b7b7.jpg', 'Mens Apparel', 999, 'S, M, L, XL, XXL', 'blue, khaki, cream', 'howl123'),
(18, 'H&amp;M slim fit long sleeve', 'Shirt in a stretch weave made from a cotton blend with a cut-away collar, classic front\r\nand a yoke at the back. Long sleeves with adjustable buttoning at the cuffs and a sleeve placket\r\nwith a link button. Gently rounded hem. Slim fit that hugs the conto', '66798e5f9faac.jpg', 'Mens Apparel', 1549, 'S, M, L, XL, XXL', 'blue, white, black', 'howl123'),
(19, 'Nike Dunk Low', 'Created for the hardwood but taken to the streets, this &#39;80s basketball icon returns with\r\nclassic details and throwback hoops flair. The synthetic leather overlays help the Nike Dunk\r\nchannel vintage style while its padded, low-cut collar lets you ta', '66798f7f93f67.png', 'Mens Shoes', 6895, '7, 8, 9, 10, 11', 'brown, black, white, blue', 'dasbolz'),
(20, 'Nike Pegasus 41', 'Responsive cushioning in the Pegasus provides an energised ride for everyday road\r\nrunning. Experience lighter-weight energy return with dual Air Zoom units and a ReactX foam\r\n\r\nmidsole. Plus, improved engineered mesh on the upper decreases weight and inc', '66798fcf3e731.png', 'Mens Shoes', 7350, '7, 8, 9, 10, 11, 12', 'brown, green, black, white, blue', 'dasbolz'),
(21, 'Adidas advantage', 'A modern upgrade on an iconic tennis shoe. These adidas sneakers feature a faux\r\nleather upper, perforated with the 3-Stripes for a subtle look. Inside, the Cloudfoam Comfort\r\nsockliner feels ultra-soft and plush, absorbing impact while keeping the ride s', '6679901eca056.jpg', 'Mens Shoes', 3550, '6, 7, 8, 9, 10, 11, 12', 'brown, green, black, white, blue', 'dasbolz'),
(22, 'NB 9060', 'Introducing the New Balance 9060, a new iteration that embodies the sophisticated style\r\nand innovative design legacy of the iconic 99X series. Drawing inspiration from classic 99X\r\nmodels and the bold, futuristic aesthetic of the Y2K era, the 9060 presen', '6679906ee6593.jpg', 'Mens Shoes', 5550, '6, 7, 8, 9, 10, 11, 12', 'brown, green, black, white, blue', 'dasbolz'),
(23, 'Air Jordan 36 LUKA', 'The Air Jordan 36 isn&#39;t just the next up in the iconic franchise—it&#39;s an expression of the\r\ndrive and dynamic play that sparked a hoops revolution. This colourway harnesses the power of\r\nLuka&#39;s on-court skills and off-court style. Equipped wit', '667990d27bc30.jpg', 'Mens Shoes', 10677, '6, 7, 8, 9, 10, 11, 12', 'blue-green', 'dasbolz'),
(24, 'Bench Wide Leg Utility Pants', 'Bench Wide Leg Utility Pants', '667991466803e.jpg', 'Womens Apparel', 1399, 'XS, S, M, L, XL', 'khaki, grey', 'dasbolz'),
(25, 'Bench Fit and Flare Dress', 'Bench Fit and Flare Dress', '66799201742c0.jpg', 'Womens Apparel', 1299, 'S, M, L, XL', 'grey, blue', 'dasbolz'),
(27, 'Bench butterfly sleeve top', 'Bench butterfly sleeve top', '6679926942f98.jpg', 'Womens Apparel', 1099, 'S, M, L, XL', 'white, pink', 'dasbolz'),
(28, 'Bench Corduroy Shorts', 'Bench Corduroy Shorts', '667992a97f30e.jpg', 'Womens Apparel', 899, 'S, M, L, XL, XXL', 'black', 'dasbolz'),
(29, 'LG dual inverter split type AirCon', 'The LG Dual Inverter Split Type Air Conditioner is designed to provide powerful and efficient cooling for residential and commercial spaces. This state-of-the-art air conditioning unit combines advanced technology with modern design, offering superior per', '6679947c084a8.jpg', 'Home Appliance', 71888, '18x30x84cm', 'White', 'dasbolz'),
(30, 'Samsung split type Aircon', 'Stay comfortable cool with WindFre Cooling. It gently and quietly disperses air through 23,000 micro air holes, so there is no unpleasant feeling of cold wind on your skin. Its advanced airflow also cools a wider and larger area more evenly. And it uses 7', '667994e8efdf7.jpg', 'Home Appliance', 71888, '18x30x84cm', 'White,Black', 'dasbolz'),
(31, 'Samsung Hybrid Heat Type Dryer', 'The Samsung Hybrid Heat Pump Dryer combines the latest technology to offer efficient and gentle drying for all types of fabrics. This innovative dryer is designed to reduce energy consumption while providing powerful drying performance.', '6679953cd2c7b.jpg', 'Home Appliance', 79888, '76x111x93cm', 'White,Black', 'dasbolz'),
(32, 'Samsung Digital Side by Side Refrigerator', 'The Samsung Digital Side by Side Refrigerator is a modern, high-capacity appliance designed to provide efficient cooling and convenient storage solutions. It combines advanced technology with sleek design, making it an ideal choice for contemporary kitche', '6679958109aa3.jpg', 'Home Appliance', 79888, '97x189x72cm', 'White,Black, Grey', 'dasbolz'),
(33, 'iPhone 15', 'iPhone 15', '667996e55c651.jpg', 'Mobile & Gadgets', 64000, '128gb, 256gb, 512gb', 'black, grey, pink, blue, white', 'kotone'),
(34, 'Samsung s24 ultra', 'Experience the pinnacle of mobile technology with the Samsung Galaxy S24 Ultra. Immerse yourself in a breathtaking 6.8-inch Dynamic AMOLED display, offering vivid colors and HDR10+ support for a cinematic viewing experience.', '6679973b3737d.jpg', 'Mobile & Gadgets', 88990, '128gb, 256gb, 512gb', 'black, grey, pink, blue, white', 'kotone'),
(35, 'Realme 12 pro 5g', 'Realme 12 pro 5g', '667997d88c4ad.jpg', 'Mobile & Gadgets', 36990, '128gb, 512gb', 'black, grey, blue, white', 'kotone'),
(36, 'Xiaomi 14 CIVI', 'Xiaomi 14 CIVI', '6679981c11907.jpg', 'Mobile & Gadgets', 30090, '128gb, 512gb', 'black, green, blue, white', 'kotone'),
(37, 'Creed Aventus', 'Audacious, confident and powerful, this signature fragrance from The House of Creed has been delicately crafted to create a true contemporary classic.', '667998bc0e498.jpg', 'Makeup & Fragrances', 495, '50ml, 100ml', 'n/a', 'kotone'),
(38, 'Dior Sauvage Eau de Toilette', 'Sauvage is an act of creation inspired by wide-open spaces. An ozone blue sky that dominates a white-hot rocky landscape.', '6679991883e29.jpg', 'Makeup & Fragrances', 1350, '60ml, 100ml', 'n/a', 'kotone'),
(39, 'Milani Baked Blush', 'Milani Baked Blush', '66799966cc3ac.jpg', 'Makeup & Fragrances', 985, '3.5g', 'Pink', 'kotone'),
(40, 'Tarte Shape Tape Concealer', 'Tarte Shape Tape Concealer is a highly acclaimed product in the beauty industry, known for its full coverage, long-lasting formula, and versatility.', '667999a2403e4.jpg', 'Makeup & Fragrances', 3655, '10ml', 'n/a', 'kotone');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phoneNum` varchar(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `region` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fname`, `lname`, `username`, `email`, `password`, `phoneNum`, `user`, `region`, `province`, `city`, `barangay`, `image`) VALUES
(1, 'jovan', 'andrade', 'howl123', 'howl123@gmail.com', '12345678', '09123456788', 'business', '4a', 'cavite', 'gma', 'poblacion 1', '667c1fabbd946.jpg'),
(2, 'theo', 'pegenia', 'kvro', '123141@adad', '12345678', '09123456789', 'business', '4', 'cavite', 'indang', 'purok 1', ''),
(3, 'jovan', 'andrade', 'dasbolz', 'adbiabd@adaiwbdw', '12345678', '09123456789', 'business', '4a', 'cavite', 'general mariano alvarez', 'poblacion 1', '6690eeb38f6a2.png'),
(4, 'jovan', 'andrade', 'kotone', 'jovanandrade2004@gmail.com', '12345678', '09123456788', 'business', '4', 'cavite', 'gma', 'poblacion 1', ''),
(5, 'roi/', 'legaspi', 'saki', 'dhflsdhfsdf@bjaksdbasd', 'qwertyuio', '09124125126', 'consumer', 'dsasda', 'aasddssd', 'asdasd', 'asdasd', '667a5a222eeb9.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
