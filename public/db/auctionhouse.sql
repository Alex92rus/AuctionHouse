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
  
  
  
INSERT INTO `countries` (countryName)  VALUES ( 'Afghanistan');
INSERT INTO `countries` (countryName)  VALUES ( 'Albania');
INSERT INTO `countries` (countryName)  VALUES ( 'Algeria');
INSERT INTO `countries` (countryName)  VALUES ( 'American Samoa');
INSERT INTO `countries` (countryName)  VALUES ( 'Andorra');
INSERT INTO `countries` (countryName)  VALUES ( 'Angola');
INSERT INTO `countries` (countryName)  VALUES ( 'Anguilla');
INSERT INTO `countries` (countryName)  VALUES ( 'Antarctica');
INSERT INTO `countries` (countryName)  VALUES ( 'Antigua and Barbuda');
INSERT INTO `countries` (countryName)  VALUES ( 'Argentina');
INSERT INTO `countries` (countryName)  VALUES ( 'Armenia');
INSERT INTO `countries` (countryName)  VALUES ( 'Aruba');
INSERT INTO `countries` (countryName)  VALUES ( 'Australia');
INSERT INTO `countries` (countryName)  VALUES ( 'Austria');
INSERT INTO `countries` (countryName)  VALUES ( 'Azerbaijan');
INSERT INTO `countries` (countryName)  VALUES ( 'Bahamas');
INSERT INTO `countries` (countryName)  VALUES ( 'Bahrain');
INSERT INTO `countries` (countryName)  VALUES ( 'Bangladesh');
INSERT INTO `countries` (countryName)  VALUES ( 'Barbados');
INSERT INTO `countries` (countryName)  VALUES ( 'Belarus');
INSERT INTO `countries` (countryName)  VALUES ( 'Belgium');
INSERT INTO `countries` (countryName)  VALUES ( 'Belize');
INSERT INTO `countries` (countryName)  VALUES ( 'Benin');
INSERT INTO `countries` (countryName)  VALUES ( 'Bermuda');
INSERT INTO `countries` (countryName)  VALUES ( 'Bhutan');
INSERT INTO `countries` (countryName)  VALUES ( 'Bolivia');
INSERT INTO `countries` (countryName)  VALUES ( 'Bosnia and Herzegovina');
INSERT INTO `countries` (countryName)  VALUES ( 'Botswana');
INSERT INTO `countries` (countryName)  VALUES ( 'Bouvet Island');
INSERT INTO `countries` (countryName)  VALUES ( 'Brazil');
INSERT INTO `countries` (countryName)  VALUES ( 'British Indian Ocean Territory');
INSERT INTO `countries` (countryName)  VALUES ( 'Brunei Darussalam');
INSERT INTO `countries` (countryName)  VALUES ( 'Bulgaria');
INSERT INTO `countries` (countryName)  VALUES ( 'Burkina Faso');
INSERT INTO `countries` (countryName)  VALUES ( 'Burundi');
INSERT INTO `countries` (countryName)  VALUES ( 'Cambodia');
INSERT INTO `countries` (countryName)  VALUES ( 'Cameroon');
INSERT INTO `countries` (countryName)  VALUES ( 'Canada');
INSERT INTO `countries` (countryName)  VALUES ( 'Cape Verde');
INSERT INTO `countries` (countryName)  VALUES ( 'Cayman Islands');
INSERT INTO `countries` (countryName)  VALUES ( 'Central African Republic');
INSERT INTO `countries` (countryName)  VALUES ( 'Chad');
INSERT INTO `countries` (countryName)  VALUES ( 'Chile');
INSERT INTO `countries` (countryName)  VALUES ( 'China');
INSERT INTO `countries` (countryName)  VALUES ( 'Christmas Island');
INSERT INTO `countries` (countryName)  VALUES ( 'Cocos (Keeling) Islands');
INSERT INTO `countries` (countryName)  VALUES ( 'Colombia');
INSERT INTO `countries` (countryName)  VALUES ( 'Comoros');
INSERT INTO `countries` (countryName)  VALUES ( 'Congo');
INSERT INTO `countries` (countryName)  VALUES ( 'Cook Islands');
INSERT INTO `countries` (countryName)  VALUES ( 'Costa Rica');
INSERT INTO `countries` (countryName)  VALUES ( 'Croatia (Hrvatska)');
INSERT INTO `countries` (countryName)  VALUES ( 'Cuba');
INSERT INTO `countries` (countryName)  VALUES ( 'Cyprus');
INSERT INTO `countries` (countryName)  VALUES ( 'Czech Republic');
INSERT INTO `countries` (countryName)  VALUES ( 'Denmark');
INSERT INTO `countries` (countryName)  VALUES ( 'Djibouti');
INSERT INTO `countries` (countryName)  VALUES ( 'Dominica');
INSERT INTO `countries` (countryName)  VALUES ( 'Dominican Republic');
INSERT INTO `countries` (countryName)  VALUES ( 'East Timor');
INSERT INTO `countries` (countryName)  VALUES ( 'Ecuador');
INSERT INTO `countries` (countryName)  VALUES ( 'Egypt');
INSERT INTO `countries` (countryName)  VALUES ( 'El Salvador');
INSERT INTO `countries` (countryName)  VALUES ( 'Equatorial Guinea');
INSERT INTO `countries` (countryName)  VALUES ( 'Eritrea');
INSERT INTO `countries` (countryName)  VALUES ( 'Estonia');
INSERT INTO `countries` (countryName)  VALUES ( 'Ethiopia');
INSERT INTO `countries` (countryName)  VALUES ( 'Falkland Islands (Malvinas)');
INSERT INTO `countries` (countryName)  VALUES ( 'Faroe Islands');
INSERT INTO `countries` (countryName)  VALUES ( 'Fiji');
INSERT INTO `countries` (countryName)  VALUES ( 'Finland');
INSERT INTO `countries` (countryName)  VALUES ( 'France');
INSERT INTO `countries` (countryName)  VALUES ( 'France, Metropolitan');
INSERT INTO `countries` (countryName)  VALUES ( 'French Guiana');
INSERT INTO `countries` (countryName)  VALUES ( 'French Polynesia');
INSERT INTO `countries` (countryName)  VALUES ( 'French Southern Territories');
INSERT INTO `countries` (countryName)  VALUES ( 'Gabon');
INSERT INTO `countries` (countryName)  VALUES ( 'Gambia');
INSERT INTO `countries` (countryName)  VALUES ( 'Georgia');
INSERT INTO `countries` (countryName)  VALUES ( 'Germany');
INSERT INTO `countries` (countryName)  VALUES ( 'Ghana');
INSERT INTO `countries` (countryName)  VALUES ( 'Gibraltar');
INSERT INTO `countries` (countryName)  VALUES ( 'Guernsey');
INSERT INTO `countries` (countryName)  VALUES ( 'Greece');
INSERT INTO `countries` (countryName)  VALUES ( 'Greenland');
INSERT INTO `countries` (countryName)  VALUES ( 'Grenada');
INSERT INTO `countries` (countryName)  VALUES ( 'Guadeloupe');
INSERT INTO `countries` (countryName)  VALUES ( 'Guam');
INSERT INTO `countries` (countryName)  VALUES ( 'Guatemala');
INSERT INTO `countries` (countryName)  VALUES ( 'Guinea');
INSERT INTO `countries` (countryName)  VALUES ( 'Guinea-Bissau');
INSERT INTO `countries` (countryName)  VALUES ( 'Guyana');
INSERT INTO `countries` (countryName)  VALUES ( 'Haiti');
INSERT INTO `countries` (countryName)  VALUES ( 'Heard and Mc Donald Islands');
INSERT INTO `countries` (countryName)  VALUES ( 'Honduras');
INSERT INTO `countries` (countryName)  VALUES ( 'Hong Kong');
INSERT INTO `countries` (countryName)  VALUES ( 'Hungary');
INSERT INTO `countries` (countryName)  VALUES ( 'Iceland');
INSERT INTO `countries` (countryName)  VALUES ( 'India');
INSERT INTO `countries` (countryName)  VALUES ( 'Isle of Man');
INSERT INTO `countries` (countryName)  VALUES ( 'Indonesia');
INSERT INTO `countries` (countryName)  VALUES ( 'Iran (Islamic Republic of)');
INSERT INTO `countries` (countryName)  VALUES ( 'Iraq');
INSERT INTO `countries` (countryName)  VALUES ( 'Ireland');
INSERT INTO `countries` (countryName)  VALUES ( 'Israel');
INSERT INTO `countries` (countryName)  VALUES ( 'Italy');
INSERT INTO `countries` (countryName)  VALUES ( 'Ivory Coast');
INSERT INTO `countries` (countryName)  VALUES ( 'Jersey');
INSERT INTO `countries` (countryName)  VALUES ( 'Jamaica');
INSERT INTO `countries` (countryName)  VALUES ( 'Japan');
INSERT INTO `countries` (countryName)  VALUES ( 'Jordan');
INSERT INTO `countries` (countryName)  VALUES ( 'Kazakhstan');
INSERT INTO `countries` (countryName)  VALUES ( 'Kenya');
INSERT INTO `countries` (countryName)  VALUES ( 'Kiribati');
INSERT INTO `countries` (countryName)  VALUES ( 'Korea, Democratic People''s Republic of');
INSERT INTO `countries` (countryName)  VALUES ( 'Korea, Republic of');
INSERT INTO `countries` (countryName)  VALUES ( 'Kosovo');
INSERT INTO `countries` (countryName)  VALUES ( 'Kuwait');
INSERT INTO `countries` (countryName)  VALUES ( 'Kyrgyzstan');
INSERT INTO `countries` (countryName)  VALUES ( 'Lao People''s Democratic Republic');
INSERT INTO `countries` (countryName)  VALUES ( 'Latvia');
INSERT INTO `countries` (countryName)  VALUES ( 'Lebanon');
INSERT INTO `countries` (countryName)  VALUES ( 'Lesotho');
INSERT INTO `countries` (countryName)  VALUES ( 'Liberia');
INSERT INTO `countries` (countryName)  VALUES ( 'Libyan Arab Jamahiriya');
INSERT INTO `countries` (countryName)  VALUES ( 'Liechtenstein');
INSERT INTO `countries` (countryName)  VALUES ( 'Lithuania');
INSERT INTO `countries` (countryName)  VALUES ( 'Luxembourg');
INSERT INTO `countries` (countryName)  VALUES ( 'Macau');
INSERT INTO `countries` (countryName)  VALUES ( 'Macedonia');
INSERT INTO `countries` (countryName)  VALUES ( 'Madagascar');
INSERT INTO `countries` (countryName)  VALUES ( 'Malawi');
INSERT INTO `countries` (countryName)  VALUES ( 'Malaysia');
INSERT INTO `countries` (countryName)  VALUES ( 'Maldives');
INSERT INTO `countries` (countryName)  VALUES ( 'Mali');
INSERT INTO `countries` (countryName)  VALUES ( 'Malta');
INSERT INTO `countries` (countryName)  VALUES ( 'Marshall Islands');
INSERT INTO `countries` (countryName)  VALUES ( 'Martinique');
INSERT INTO `countries` (countryName)  VALUES ( 'Mauritania');
INSERT INTO `countries` (countryName)  VALUES ( 'Mauritius');
INSERT INTO `countries` (countryName)  VALUES ( 'Mayotte');
INSERT INTO `countries` (countryName)  VALUES ( 'Mexico');
INSERT INTO `countries` (countryName)  VALUES ( 'Micronesia, Federated States of');
INSERT INTO `countries` (countryName)  VALUES ( 'Moldova, Republic of');
INSERT INTO `countries` (countryName)  VALUES ( 'Monaco');
INSERT INTO `countries` (countryName)  VALUES ( 'Mongolia');
INSERT INTO `countries` (countryName)  VALUES ( 'Montenegro');
INSERT INTO `countries` (countryName)  VALUES ( 'Montserrat');
INSERT INTO `countries` (countryName)  VALUES ( 'Morocco');
INSERT INTO `countries` (countryName)  VALUES ( 'Mozambique');
INSERT INTO `countries` (countryName)  VALUES ( 'Myanmar');
INSERT INTO `countries` (countryName)  VALUES ( 'Namibia');
INSERT INTO `countries` (countryName)  VALUES ( 'Nauru');
INSERT INTO `countries` (countryName)  VALUES ( 'Nepal');
INSERT INTO `countries` (countryName)  VALUES ( 'Netherlands');
INSERT INTO `countries` (countryName)  VALUES ( 'Netherlands Antilles');
INSERT INTO `countries` (countryName)  VALUES ( 'New Caledonia');
INSERT INTO `countries` (countryName)  VALUES ( 'New Zealand');
INSERT INTO `countries` (countryName)  VALUES ( 'Nicaragua');
INSERT INTO `countries` (countryName)  VALUES ( 'Niger');
INSERT INTO `countries` (countryName)  VALUES ( 'Nigeria');
INSERT INTO `countries` (countryName)  VALUES ( 'Niue');
INSERT INTO `countries` (countryName)  VALUES ( 'Norfolk Island');
INSERT INTO `countries` (countryName)  VALUES ( 'Northern Mariana Islands');
INSERT INTO `countries` (countryName)  VALUES ( 'Norway');
INSERT INTO `countries` (countryName)  VALUES ( 'Oman');
INSERT INTO `countries` (countryName)  VALUES ( 'Pakistan');
INSERT INTO `countries` (countryName)  VALUES ( 'Palau');
INSERT INTO `countries` (countryName)  VALUES ( 'Palestine');
INSERT INTO `countries` (countryName)  VALUES ( 'Panama');
INSERT INTO `countries` (countryName)  VALUES ( 'Papua New Guinea');
INSERT INTO `countries` (countryName)  VALUES ( 'Paraguay');
INSERT INTO `countries` (countryName)  VALUES ( 'Peru');
INSERT INTO `countries` (countryName)  VALUES ( 'Philippines');
INSERT INTO `countries` (countryName)  VALUES ( 'Pitcairn');
INSERT INTO `countries` (countryName)  VALUES ( 'Poland');
INSERT INTO `countries` (countryName)  VALUES ( 'Portugal');
INSERT INTO `countries` (countryName)  VALUES ( 'Puerto Rico');
INSERT INTO `countries` (countryName)  VALUES ( 'Qatar');
INSERT INTO `countries` (countryName)  VALUES ( 'Reunion');
INSERT INTO `countries` (countryName)  VALUES ( 'Romania');
INSERT INTO `countries` (countryName)  VALUES ( 'Russian Federation');
INSERT INTO `countries` (countryName)  VALUES ( 'Rwanda');
INSERT INTO `countries` (countryName)  VALUES ( 'Saint Kitts and Nevis');
INSERT INTO `countries` (countryName)  VALUES ( 'Saint Lucia');
INSERT INTO `countries` (countryName)  VALUES ( 'Saint Vincent and the Grenadines');
INSERT INTO `countries` (countryName)  VALUES ( 'Samoa');
INSERT INTO `countries` (countryName)  VALUES ( 'San Marino');
INSERT INTO `countries` (countryName)  VALUES ( 'Sao Tome and Principe');
INSERT INTO `countries` (countryName)  VALUES ( 'Saudi Arabia');
INSERT INTO `countries` (countryName)  VALUES ( 'Senegal');
INSERT INTO `countries` (countryName)  VALUES ( 'Serbia');
INSERT INTO `countries` (countryName)  VALUES ( 'Seychelles');
INSERT INTO `countries` (countryName)  VALUES ( 'Sierra Leone');
INSERT INTO `countries` (countryName)  VALUES ( 'Singapore');
INSERT INTO `countries` (countryName)  VALUES ( 'Slovakia');
INSERT INTO `countries` (countryName)  VALUES ( 'Slovenia');
INSERT INTO `countries` (countryName)  VALUES ( 'Solomon Islands');
INSERT INTO `countries` (countryName)  VALUES ( 'Somalia');
INSERT INTO `countries` (countryName)  VALUES ( 'South Africa');
INSERT INTO `countries` (countryName)  VALUES ( 'South Georgia South Sandwich Islands');
INSERT INTO `countries` (countryName)  VALUES ( 'Spain');
INSERT INTO `countries` (countryName)  VALUES ( 'Sri Lanka');
INSERT INTO `countries` (countryName)  VALUES ( 'St. Helena');
INSERT INTO `countries` (countryName)  VALUES ( 'St. Pierre and Miquelon');
INSERT INTO `countries` (countryName)  VALUES ( 'Sudan');
INSERT INTO `countries` (countryName)  VALUES ( 'Suriname');
INSERT INTO `countries` (countryName)  VALUES ( 'Svalbard and Jan Mayen Islands');
INSERT INTO `countries` (countryName)  VALUES ( 'Swaziland');
INSERT INTO `countries` (countryName)  VALUES ( 'Sweden');
INSERT INTO `countries` (countryName)  VALUES ( 'Switzerland');
INSERT INTO `countries` (countryName)  VALUES ( 'Syrian Arab Republic');
INSERT INTO `countries` (countryName)  VALUES ( 'Taiwan');
INSERT INTO `countries` (countryName)  VALUES ( 'Tajikistan');
INSERT INTO `countries` (countryName)  VALUES ( 'Tanzania, United Republic of');
INSERT INTO `countries` (countryName)  VALUES ( 'Thailand');
INSERT INTO `countries` (countryName)  VALUES ( 'Togo');
INSERT INTO `countries` (countryName)  VALUES ( 'Tokelau');
INSERT INTO `countries` (countryName)  VALUES ( 'Tonga');
INSERT INTO `countries` (countryName)  VALUES ( 'Trinidad and Tobago');
INSERT INTO `countries` (countryName)  VALUES ( 'Tunisia');
INSERT INTO `countries` (countryName)  VALUES ( 'Turkey');
INSERT INTO `countries` (countryName)  VALUES ( 'Turkmenistan');
INSERT INTO `countries` (countryName)  VALUES ( 'Turks and Caicos Islands');
INSERT INTO `countries` (countryName)  VALUES ( 'Tuvalu');
INSERT INTO `countries` (countryName)  VALUES ( 'Uganda');
INSERT INTO `countries` (countryName)  VALUES ( 'Ukraine');
INSERT INTO `countries` (countryName)  VALUES ( 'United Arab Emirates');
INSERT INTO `countries` (countryName)  VALUES ( 'United Kingdom');
INSERT INTO `countries` (countryName)  VALUES ( 'United States');
INSERT INTO `countries` (countryName)  VALUES ( 'United States minor outlying islands');
INSERT INTO `countries` (countryName)  VALUES ( 'Uruguay');
INSERT INTO `countries` (countryName)  VALUES ( 'Uzbekistan');
INSERT INTO `countries` (countryName)  VALUES ( 'Vanuatu');
INSERT INTO `countries` (countryName)  VALUES ( 'Vatican City State');
INSERT INTO `countries` (countryName)  VALUES ( 'Venezuela');
INSERT INTO `countries` (countryName)  VALUES ( 'Vietnam');
INSERT INTO `countries` (countryName)  VALUES ( 'Virgin Islands (British)');
INSERT INTO `countries` (countryName)  VALUES ( 'Virgin Islands (U.S.)');
INSERT INTO `countries` (countryName)  VALUES ( 'Wallis and Futuna Islands');
INSERT INTO `countries` (countryName)  VALUES ( 'Western Sahara');
INSERT INTO `countries` (countryName)  VALUES ( 'Yemen');
INSERT INTO `countries` (countryName)  VALUES ( 'Yugoslavia');
INSERT INTO `countries` (countryName)  VALUES ( 'Zaire');
INSERT INTO `countries` (countryName)  VALUES ( 'Zambia');
INSERT INTO `countries` (countryName)  VALUES ( 'Zimbabwe');
