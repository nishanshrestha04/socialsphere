-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2025 at 07:18 AM
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
-- Database: `24128429`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_email`, `password`) VALUES
(1, 'admin@admin', '123');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`, `created_at`) VALUES
(78, 20, 6, 'hello', '2024-12-26 09:29:07'),
(81, 20, 3, 'l,\';l,\';l,\'l;', '2024-12-27 02:14:22'),
(82, 19, 3, 'nice photo', '2025-01-15 04:25:43'),
(83, 25, 3, 'htdshjfklasd;fs', '2025-01-20 02:13:54'),
(84, 22, 3, 'hitjksaj;kldf', '2025-01-20 02:14:10');

-- --------------------------------------------------------

--
-- Table structure for table `follower_list`
--

CREATE TABLE `follower_list` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `follower_list`
--

INSERT INTO `follower_list` (`id`, `follower_id`, `user_id`) VALUES
(63, 1, 6),
(66, 1, 3),
(85, 3, 1),
(88, 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `user_id`) VALUES
(69, 18, 6),
(70, 20, 6),
(71, 18, 3),
(73, 20, 3),
(74, 21, 3),
(75, 22, 1),
(76, 19, 3),
(77, 22, 3);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_img` text NOT NULL,
  `caption` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post_img`, `caption`, `created_at`) VALUES
(18, 6, '1734835096anime-moon-landscape.jpg', 'This is awesome picture\r\n', '2024-12-22 02:38:17'),
(19, 6, '1735205214Group 55.png', '', '2024-12-26 09:26:54'),
(20, 6, '1735205336Shiva.jpeg', '', '2024-12-26 09:28:56'),
(21, 3, '1735205762image.png', '', '2024-12-26 09:36:02'),
(22, 1, '17357359411.png', 'this is logo\r\n', '2025-01-01 12:52:21'),
(25, 3, '17373392231722609396757.jpg', 'jkldsjfkl', '2025-01-20 02:13:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `profile_pic` text NOT NULL DEFAULT 'default-profile.png',
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `account_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `username`, `password`, `profile_pic`, `created_at`, `updated_at`, `account_status`) VALUES
(1, 'Nishan Shrestha ', 'nishanshrestha212@gmail.com', 'nishan', '202cb962ac59075b964b07152d234b70', '1734532399radha-krishna-5120x2880-14416.png', '2025-01-20 02:20:22', NULL, 1),
(3, 'Nishan Shrestha ', 'nishanshrestha131@gmail.com', 'nishanshrestha', '202cb962ac59075b964b07152d234b70', '1734422573Nishan Shrestha (1).jpg', '2024-12-17 08:05:05', NULL, 1),
(6, 'Nishan Test', 'nishan@shrestha', 'testnishan', '202cb962ac59075b964b07152d234b70', '1734529979anime-moon-landscape (Large).jpg', '2024-12-18 13:52:59', NULL, 1),
(8, 'test nishan', 'test@test', 'test_nishan', '202cb962ac59075b964b07152d234b70', 'default-profile.png', '2025-01-01 12:54:50', NULL, 1),
(9, 'Sovit Test', 'sovit@sovit', 'sovit', '202cb962ac59075b964b07152d234b70', 'default-profile.png', '2025-01-01 12:59:35', NULL, 1),
(10, 'ashu', 'ashu@ashu', 'ashu', '202cb962ac59075b964b07152d234b70', 'default-profile.png', '2025-01-01 13:02:09', NULL, 1),
(11, 'Nishan Shrestha ', 'nishan@123', 'nishan432', '202cb962ac59075b964b07152d234b70', 'default-profile.png', '2025-01-20 02:29:45', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comment_post` (`post_id`),
  ADD KEY `fk_comment_user` (`user_id`);

--
-- Indexes for table `follower_list`
--
ALTER TABLE `follower_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_follower_user` (`user_id`),
  ADD KEY `fk_follower_follower` (`follower_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_like_post` (`post_id`),
  ADD KEY `fk_like_user` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `follower_list`
--
ALTER TABLE `follower_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comment_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `fk_comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `follower_list`
--
ALTER TABLE `follower_list`
  ADD CONSTRAINT `fk_follower_follower` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_follower_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_like_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `fk_like_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
