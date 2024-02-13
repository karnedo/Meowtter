-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 09, 2024 at 11:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MEOWTTER`
--

-- --------------------------------------------------------

--
-- Table structure for table `FOLLOWS`
--

CREATE TABLE `FOLLOWS` (
  `following_user` varchar(255) NOT NULL,
  `followed_user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `IMAGES`
--

CREATE TABLE `IMAGES` (
  `id` int(11) NOT NULL,
  `meow` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LIKES`
--

CREATE TABLE `LIKES` (
  `id` int(11) NOT NULL,
  `meow` int(11) NOT NULL,
  `user` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MEOWS`
--

CREATE TABLE `MEOWS` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL COMMENT 'Content of the post',
  `user` varchar(30) NOT NULL,
  `postTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE `USERS` (
  `username` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL COMMENT 'ADMIN for administrator, MOD for moderator, REGULAR for normal users',
  `bannedUntil` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'null for not banned',
  `profileImage` varchar(255) DEFAULT NULL COMMENT 'null for default image'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`username`, `email`, `role`, `bannedUntil`, `profileImage`) VALUES
('ADMINISTRATOR', 'sistemasdegestionempresarial@iesayala.com', 'ADMIN', '2024-02-09 22:35:32', NULL),
('jose', 'joseltrrdz@hotmail.com', 'MOD', '2024-02-09 22:35:56', NULL),
('pepe', 'creadordeluniverso@iesayala.com', 'REGULAR', '2024-02-09 22:36:32', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `FOLLOWS`
--
ALTER TABLE `FOLLOWS`
  ADD KEY `FK_FOLLOWING_USERS` (`following_user`),
  ADD KEY `FK_FOLLOWED_USERS` (`followed_user`);

--
-- Indexes for table `IMAGES`
--
ALTER TABLE `IMAGES`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IMAGES_MEOWS` (`meow`);

--
-- Indexes for table `LIKES`
--
ALTER TABLE `LIKES`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meow` (`meow`,`user`),
  ADD KEY `FK_LIKES_USERS` (`user`);

--
-- Indexes for table `MEOWS`
--
ALTER TABLE `MEOWS`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_MEOWS_USERS` (`user`);

--
-- Indexes for table `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `IMAGES`
--
ALTER TABLE `IMAGES`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LIKES`
--
ALTER TABLE `LIKES`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MEOWS`
--
ALTER TABLE `MEOWS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `FOLLOWS`
--
ALTER TABLE `FOLLOWS`
  ADD CONSTRAINT `FK_FOLLOWED_USERS` FOREIGN KEY (`followed_user`) REFERENCES `USERS` (`username`),
  ADD CONSTRAINT `FK_FOLLOWING_USERS` FOREIGN KEY (`following_user`) REFERENCES `USERS` (`username`);

--
-- Constraints for table `IMAGES`
--
ALTER TABLE `IMAGES`
  ADD CONSTRAINT `FK_IMAGES_MEOWS` FOREIGN KEY (`meow`) REFERENCES `MEOWS` (`id`);

--
-- Constraints for table `LIKES`
--
ALTER TABLE `LIKES`
  ADD CONSTRAINT `FK_LIKES_MEOWS` FOREIGN KEY (`meow`) REFERENCES `MEOWS` (`id`),
  ADD CONSTRAINT `FK_LIKES_USERS` FOREIGN KEY (`user`) REFERENCES `USERS` (`username`);

--
-- Constraints for table `MEOWS`
--
ALTER TABLE `MEOWS`
  ADD CONSTRAINT `FK_MEOWS_USERS` FOREIGN KEY (`user`) REFERENCES `USERS` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
