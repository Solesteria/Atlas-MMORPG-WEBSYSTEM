-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 03:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `records`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `user_id`, `item_id`, `quantity`) VALUES
(15, 10, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` enum('helmet','chestplate','leggings','boots','swords','bow','spear','potions') NOT NULL DEFAULT 'helmet',
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `type`, `price`, `description`, `image`) VALUES
(1, 'Iron Helmet', 'helmet', 65.00, 'A conical helmet with pointed top, hammered out from one piece of iron. ', 'https://wiki.melvoridle.com/images/thumb/a/a2/Iron_Helmet_%28item%29.png/250px-Iron_Helmet_%28item%29.png ');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marketplace`
--

CREATE TABLE `marketplace` (
  `id` int(11) NOT NULL,
  `seller_name` varchar(50) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marketplace`
--

INSERT INTO `marketplace` (`id`, `seller_name`, `seller_id`, `item_id`, `item_name`, `quantity`, `price`, `created_at`) VALUES
(10, 'aries', 9, 1, 'Iron Helmet', 1, 1.00, '2024-12-18 14:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `date` varchar(50) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `news_type` enum('Announcement','Update') NOT NULL DEFAULT 'Update',
  `author` varchar(50) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `subtitle` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `link` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `date`, `avatar`, `news_type`, `author`, `title`, `subtitle`, `content`, `image`, `link`) VALUES
(1, 'December 16, 2024', 'https://i.imgur.com/TSI7w2K.jpeg', 'Announcement', 'Cedric', 'Frostval x Friday the 13th', 'Wreck the Halls during part 1 of our Dark Double Holiday event!', 'Frostval is a time to celebrate at home surrounded by family and friends. But winter\'s chill and Friday the 13th\'s darkness can turn even the coziest celebration DEADLY. Log in and join special guest Aurelio Voltaire, his sweet little companion, Candy Claws, and the moglins of Frostvale as you prepare to celebrate part 1 of our double holiday event!', 'https://www.aq.com/cms/images/DN-FrostvalThe13th-Right.jpg', 'https://www.aq.com/cms/images/DN-FrostvalThe13th-Right.jpg'),
(2, 'December 16, 2024', 'https://i.imgur.com/sZQahCt.jpeg', 'Update', 'Rechell', 'Atlas : Infinity News', 'Bubble, bubble, boil and... design notes.', 'We are back with horrifyingly spooky daily progress updates for <a href=\"#\">Atlas Quest Worlds: Infinity</a>. Do you like ghost stories? Imagine we are sitting around a campfire in the pitch black of night. I lean forward.... the light of the flame under-light\'s my face as I begin whispering this dark and sordid tale.', 'https://www.aq.com/cms/images/DN-AQWI-dailyupdate-10.jpg', 'https://www.aq.com/cms/images/DN-AQWI-dailyupdate-10.jpg'),
(3, 'December 18, 2024', 'https://i.imgur.com/3Ii8wrj.jpeg', 'Announcement', 'Gab', 'Sale', 'Buy now', 'New Item in Sale', '', ''),
(4, 'December 18, 2024', 'https://i.imgur.com/TSI7w2K.jpeg', 'Announcement', 'Cedric', 'Guild Spotlight: MISFIT', 'Meet MISFIT: a Home for Every Hero', 'MISFIT is a thriving AQW guild where players of all levels come together to help, learn, and have fun! With community events, guides, and a mission to always lift others up, MISFIT proves that kindness is the ultimate win.', 'https://www.aq.com/cms/images/MISFIT-aqw-guild-spotlight-545.jpg', ''),
(5, 'December 19, 2024', 'https://i.imgur.com/sZQahCt.jpeg', 'Update', 'Rechell', 'Event Release Calendar', 'New game updates every week', 'Check out our weekly game update calendar so you don\'t miss any of our new weekly releases! See them all here!', 'https://www.aq.com/cms/images/DN-Calendar-October2020.jpg', ''),
(6, 'December 19, 2024', 'https://i.imgur.com/3Ii8wrj.jpeg', 'Announcement', 'Gab', 'The Wheel of Doom is BACK', 'Spin Swaggy\'s wheel to get prizes!', 'Five years ago, we launched the Wheels of Doom and Destiny from the Carnival of Fortune. They were one of AQWorlds\' most popular features and starting today... the Wheel of Doom is BACK! /join Doom and talk to Swaggy to buy Fortune Tickets, then spin the wheel and get prizes.', 'https://www.aq.com/cms/images/DN-WheelOfDoomReturnsFinal2-545.png', ''),
(7, 'December 20, 2024', 'https://i.imgur.com/TSI7w2K.jpeg', 'Announcement', 'Cedric', 'Now available at HeroMart', 'Madness of Darkon Print at Heromart!', 'Madness is calling to you... will you answer? Dage the Evil and Darkon joined creative forces to create terrifyingly-epic print just in time for Halloween. Display it on your wall just... try not to stare too deeply at it before you fall asleep. Get yours here, and unlock two exclusive items and a character page badge in AdventureQuest Worlds!', 'https://www.aq.com/cms/images/DN-DarkonMadnessPrint.jpg', ''),
(8, 'December 20, 2024', 'https://i.imgur.com/sZQahCt.jpeg', 'Announcement', 'Rechell', 'RPG Strategy: Unlikely Alliances', 'Good & Evil vs Chaos!', 'Decide whether you will be Good or Evil! Choose quickly, because Chaos monsters have already invaded Lore! Join thousands of players in the battle to defeat Drakath and his 13 Lords of Chaos, then return as we expand the world of Lore with new stories and zones each week.', 'https://www.aq.com/cms/images/webgraphic-13thlordofchaos-NewHP-545.jpg', ''),
(9, 'December 20, 2024', 'https://i.imgur.com/TSI7w2K.jpeg', 'Announcement', 'Gab', 'New Releases Every Week', 'New Zones, Quests, Items, Classes.... and more!', 'AQWorlds is being developed right under your feet as you play it, and our world grows with new stories and zones each week! Whether you love high-tech, low-tech, super-mech, or fantasy games, we want to create the new gear, minigames, and monsters you\'re looking for!', 'https://www.aq.com/cms/images/aqw_chiralboss_NewHP_545.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_logs`
--

CREATE TABLE `transaction_logs` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirmation` varchar(255) NOT NULL,
  `user_type` enum('user','admin') NOT NULL DEFAULT 'user',
  `verify_token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verify_status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `confirmation`, `user_type`, `verify_token`, `created_at`, `verify_status`) VALUES
(8, 'rechell', 'rechellr5@gmail.com', '8983ec6f8601ed93e4131d593d02b516', '8983ec6f8601ed93e4131d593d02b516', 'admin', '64adc8dab399a1628819129805617ebb', '2024-12-16 11:37:14', 1),
(9, 'aries', 'ariesx182@gmail.com', '8983ec6f8601ed93e4131d593d02b516', '8983ec6f8601ed93e4131d593d02b516', 'user', '329aff3c9f8597c3ca8b5546884703bc', '2024-12-16 11:37:54', 1),
(10, 'Black', 'rechellrodriguez83@gmail.com', '8983ec6f8601ed93e4131d593d02b516', '8983ec6f8601ed93e4131d593d02b516', 'user', 'c08b6d23624b4e9177ccc9380d6d5d56', '2024-12-18 10:08:19', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marketplace`
--
ALTER TABLE `marketplace`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seller_name` (`seller_name`) USING BTREE,
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `item_name` (`item_name`) USING BTREE;

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marketplace`
--
ALTER TABLE `marketplace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `marketplace`
--
ALTER TABLE `marketplace`
  ADD CONSTRAINT `marketplace_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `marketplace_ibfk_3` FOREIGN KEY (`seller_name`) REFERENCES `users` (`userName`),
  ADD CONSTRAINT `marketplace_ibfk_4` FOREIGN KEY (`item_name`) REFERENCES `items` (`name`);

--
-- Constraints for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  ADD CONSTRAINT `transaction_logs_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_logs_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_logs_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
