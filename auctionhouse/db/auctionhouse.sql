-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jan 31, 2016 at 09:57 AM
-- Server version: 5.5.42
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `auctionsystem`
--
CREATE DATABASE IF NOT EXISTS `auctionsystem` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `auctionsystem`;

-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

DROP TABLE IF EXISTS `auctions`;
CREATE TABLE IF NOT EXISTS `auctions` (
  `auctionId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `bidId` int(11) DEFAULT NULL,
  `quantity` int(11) unsigned NOT NULL DEFAULT '1',
  `shippingCosts` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `startPrice` decimal(10,2) unsigned NOT NULL,
  `buyNowPrice` decimal(10,2) unsigned DEFAULT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `sold` int(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auctionvisits`
--

DROP TABLE IF EXISTS `auctionvisits`;
CREATE TABLE IF NOT EXISTS `auctionvisits` (
  `visitId` int(11) NOT NULL,
  `auctionId` int(11) NOT NULL,
  `visitTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auctionwatchs`
--

DROP TABLE IF EXISTS `auctionwatchs`;
CREATE TABLE IF NOT EXISTS `auctionwatchs` (
  `watchId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `auctionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

DROP TABLE IF EXISTS `bids`;
CREATE TABLE IF NOT EXISTS `bids` (
  `bidId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `auctionId` int(11) NOT NULL,
  `bidTime` datetime NOT NULL,
  `bidPrice` decimal(10,2) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categoryId` int(11) NOT NULL,
  `superCategoryId` int(11) NOT NULL,
  `categoryName` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `countryId` int(11) NOT NULL,
  `countryName` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE IF NOT EXISTS `feedbacks` (
  `feedbackId` int(11) NOT NULL,
  `auctionId` int(11) NOT NULL,
  `receiverId` int(11) NOT NULL,
  `creatorId` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `itemId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `itemName` varchar(45) NOT NULL,
  `itemBrand` varchar(45) NOT NULL,
  `itemCondition` enum('New','Old') NOT NULL,
  `itemDesciption` varchar(500) NOT NULL,
  `image` blob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supercategories`
--

DROP TABLE IF EXISTS `supercategories`;
CREATE TABLE IF NOT EXISTS `supercategories` (
  `superCategoryId` int(11) NOT NULL,
  `superCategoryName` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unverified_users`
--

DROP TABLE IF EXISTS `unverified_users`;
CREATE TABLE IF NOT EXISTS `unverified_users` (
  `userId` int(11) NOT NULL,
  `confirmCode` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `address` varchar(90) NOT NULL,
  `postcode` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `countryId` int(11) NOT NULL,
  `password` varchar(60) NOT NULL,
  `verified` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auctions`
--
ALTER TABLE `auctions`
  ADD PRIMARY KEY (`auctionId`),
  ADD KEY `fk_Auctions_Items1_idx` (`itemId`),
  ADD KEY `fk_Auction_User1_idx` (`userId`),
  ADD KEY `fk_bid_idx` (`bidId`);

--
-- Indexes for table `auctionvisits`
--
ALTER TABLE `auctionvisits`
  ADD PRIMARY KEY (`visitId`),
  ADD KEY `fk_auction_idx` (`auctionId`);

--
-- Indexes for table `auctionwatchs`
--
ALTER TABLE `auctionwatchs`
  ADD PRIMARY KEY (`watchId`),
  ADD KEY `AuctionID_idx` (`auctionId`),
  ADD KEY `fk_AuctionWatch_User1_idx` (`userId`);

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`bidId`),
  ADD KEY `fk_bids_auctions1_idx` (`auctionId`),
  ADD KEY `fk_bids_users1_idx` (`userId`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`),
  ADD KEY `fk_superCategory_idx` (`superCategoryId`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`countryId`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`feedbackId`),
  ADD KEY `fk_Feedback_Users1_idx` (`receiverId`),
  ADD KEY `fk_Feedback_User1_idx` (`creatorId`),
  ADD KEY `fk_feedbacks_auctions1_idx` (`auctionId`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemId`),
  ADD KEY `CategoryID_idx` (`categoryId`);

--
-- Indexes for table `supercategories`
--
ALTER TABLE `supercategories`
  ADD PRIMARY KEY (`superCategoryId`);

--
-- Indexes for table `unverified_users`
--
ALTER TABLE `unverified_users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userId_UNIQUE` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD KEY `fk_country_idx` (`countryId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auctions`
--
ALTER TABLE `auctions`
  MODIFY `auctionId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `auctionvisits`
--
ALTER TABLE `auctionvisits`
  MODIFY `visitId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `auctionwatchs`
--
ALTER TABLE `auctionwatchs`
  MODIFY `watchId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `bidId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `countryId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `feedbackId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supercategories`
--
ALTER TABLE `supercategories`
  MODIFY `superCategoryId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `unverified_users`
--
ALTER TABLE `unverified_users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auctions`
--
ALTER TABLE `auctions`
  ADD CONSTRAINT `fk_bid` FOREIGN KEY (`bidId`) REFERENCES `bids` (`bidId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_item` FOREIGN KEY (`itemId`) REFERENCES `items` (`itemId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `auctionvisits`
--
ALTER TABLE `auctionvisits`
  ADD CONSTRAINT `fk_auction` FOREIGN KEY (`auctionId`) REFERENCES `auctions` (`auctionId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `auctionwatchs`
--
ALTER TABLE `auctionwatchs`
  ADD CONSTRAINT `AuctionNo` FOREIGN KEY (`auctionId`) REFERENCES `auctions` (`auctionId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_AuctionWatch_User1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `fk_bids_auctions1` FOREIGN KEY (`auctionId`) REFERENCES `auctions` (`auctionId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bids_users1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_superCategory` FOREIGN KEY (`superCategoryId`) REFERENCES `supercategories` (`superCategoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `fk_feedbacks_auctions1` FOREIGN KEY (`auctionId`) REFERENCES `auctions` (`auctionId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Feedback_User1` FOREIGN KEY (`creatorId`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Feedback_Users1` FOREIGN KEY (`receiverId`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `CategoryNo` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `unverified_users`
--
ALTER TABLE `unverified_users`
  ADD CONSTRAINT `userId` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_country` FOREIGN KEY (`countryId`) REFERENCES `countries` (`countryId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
