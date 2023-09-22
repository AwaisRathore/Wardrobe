-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2023 at 11:57 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wardrobedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `Id` int(11) NOT NULL,
  `Brand` int(11) NOT NULL,
  `Model` varchar(255) NOT NULL,
  `Size` int(11) NOT NULL,
  `WardrobeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`Id`, `Name`) VALUES
(1, 'Nike'),
(2, 'Adidas'),
(3, 'Puma'),
(4, 'Under Armour'),
(5, 'Reebok'),
(6, 'ASICS'),
(7, 'New Balance'),
(8, 'Saucony'),
(9, 'Mizuno'),
(10, 'Brooks');

-- --------------------------------------------------------

--
-- Table structure for table `clusters`
--

CREATE TABLE `clusters` (
  `Id` int(11) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Id` int(11) NOT NULL,
  `Role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`Id`, `Role`) VALUES
(1, 'Super Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `RoleId` int(11) NOT NULL DEFAULT 2,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `username`, `email`, `password`, `RoleId`, `token`) VALUES
(3, 'Umer Sudozai', 'umersudozai@gmail.com', '$2y$10$gHXIj2D5hT7Z9llzHK9E/OzBC67LPDPWWsjv7ssRBfhlAC4bJI1AO', 1, '3b054f443221311a5d29444256500ec7'),
(9, 'Awais', 'alex@gmail.com', '$2y$10$2edN967GV4vY125Tk.sdEerNGL4iWG6xsnRFCzyv3YsjLbmxOTlLW', 2, ''),
(10, 'Hammad', 'arthur@gmail.com', '$2y$10$tIC7KuPD7ew4c9AWMFk1XeAcHUJ43nEzbH2bf7U6wis.Mto6OhTbW', 2, ''),
(11, 'Morris', 'momin@gmail.com', '$2y$10$i8fpP7bo6aGvvCahOjT8Uuypchedgqh2qWFCV311OIt1P6RYoCWCq', 2, ''),
(12, 'Tom', 'joshua@gmail.com', '$2y$10$e9j40v8DhPxFXxf6fEw4tu9l1rwziU62dPZ9uZu4EOmaqJf2JDpoO', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `user_clusters`
--

CREATE TABLE `user_clusters` (
  `Id` int(11) NOT NULL,
  `ClusterId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `WardrobeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wardrobes`
--

CREATE TABLE `wardrobes` (
  `Id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wardrobes`
--

INSERT INTO `wardrobes` (`Id`, `Title`, `UserId`) VALUES
(1, 'Shoes Wardrobe', 3),
(7, 'Joshua Wardrobe', 12),
(9, 'Alex Wardrobe', 9),
(10, 'Momins Wardrobe', 11),
(11, 'Hammad Wardrobe', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `WardrobeId` (`WardrobeId`),
  ADD KEY `Brand` (`Brand`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `clusters`
--
ALTER TABLE `clusters`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `RoleId` (`RoleId`);

--
-- Indexes for table `user_clusters`
--
ALTER TABLE `user_clusters`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `ClusterId` (`ClusterId`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `WardrobeId` (`WardrobeId`);

--
-- Indexes for table `wardrobes`
--
ALTER TABLE `wardrobes`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `clusters`
--
ALTER TABLE `clusters`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_clusters`
--
ALTER TABLE `user_clusters`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `wardrobes`
--
ALTER TABLE `wardrobes`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`WardrobeId`) REFERENCES `wardrobes` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`Brand`) REFERENCES `brands` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`RoleId`) REFERENCES `roles` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_clusters`
--
ALTER TABLE `user_clusters`
  ADD CONSTRAINT `user_clusters_ibfk_1` FOREIGN KEY (`ClusterId`) REFERENCES `clusters` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_clusters_ibfk_2` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_clusters_ibfk_3` FOREIGN KEY (`WardrobeId`) REFERENCES `wardrobes` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wardrobes`
--
ALTER TABLE `wardrobes`
  ADD CONSTRAINT `wardrobes_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
