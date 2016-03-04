-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Feb 22, 2016 at 10:21 AM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `auctionsystem`
--
CREATE DATABASE IF NOT EXISTS `auctionsystem` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `auctionsystem`;


-- --------------------------------------------------------

--
-- Table structure for table `auction_watches`
--

DROP TABLE IF EXISTS `auction_watches`;
CREATE TABLE `auction_watches` (
  `watchId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `auctionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

DROP TABLE IF EXISTS `auctions`;
CREATE TABLE `auctions` (
  `auctionId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `quantity` int(11) unsigned NOT NULL DEFAULT '1',
  `startPrice` decimal(10,2) unsigned NOT NULL,
  `reservePrice` decimal(10,2) unsigned NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `sold` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `views` int(11) unsigned NOT NULL DEFAULT '0',
  `reportFrequency` tinyint(4) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=latin1;


--
-- Table structure for table `bids`
--

DROP TABLE IF EXISTS `bids`;
CREATE TABLE `bids` (
  `bidId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `auctionId` int(11) NOT NULL,
  `bidTime` datetime NOT NULL,
  `bidPrice` decimal(10,2) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1141 DEFAULT CHARSET=latin1;


--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `countryId` int(11) NOT NULL,
  `countryName` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`countryId`, `countryName`) VALUES
  (1, 'Afghanistan'),
  (2, 'Albania'),
  (3, 'Algeria'),
  (4, 'American Samoa'),
  (5, 'Andorra'),
  (6, 'Angola'),
  (7, 'Anguilla'),
  (8, 'Antarctica'),
  (9, 'Antigua and Barbuda'),
  (10, 'Argentina'),
  (11, 'Armenia'),
  (12, 'Aruba'),
  (13, 'Australia'),
  (14, 'Austria'),
  (15, 'Azerbaijan'),
  (16, 'Bahamas'),
  (17, 'Bahrain'),
  (18, 'Bangladesh'),
  (19, 'Barbados'),
  (20, 'Belarus'),
  (21, 'Belgium'),
  (22, 'Belize'),
  (23, 'Benin'),
  (24, 'Bermuda'),
  (25, 'Bhutan'),
  (26, 'Bolivia'),
  (27, 'Bosnia and Herzegovina'),
  (28, 'Botswana'),
  (29, 'Bouvet Island'),
  (30, 'Brazil'),
  (31, 'British Indian Ocean Territory'),
  (32, 'Brunei Darussalam'),
  (33, 'Bulgaria'),
  (34, 'Burkina Faso'),
  (35, 'Burundi'),
  (36, 'Cambodia'),
  (37, 'Cameroon'),
  (38, 'Canada'),
  (39, 'Cape Verde'),
  (40, 'Cayman Islands'),
  (41, 'Central African Republic'),
  (42, 'Chad'),
  (43, 'Chile'),
  (44, 'China'),
  (45, 'Christmas Island'),
  (46, 'Cocos (Keeling) Islands'),
  (47, 'Colombia'),
  (48, 'Comoros'),
  (49, 'Congo'),
  (50, 'Cook Islands'),
  (51, 'Costa Rica'),
  (52, 'Croatia (Hrvatska)'),
  (53, 'Cuba'),
  (54, 'Cyprus'),
  (55, 'Czech Republic'),
  (56, 'Denmark'),
  (57, 'Djibouti'),
  (58, 'Dominica'),
  (59, 'Dominican Republic'),
  (60, 'East Timor'),
  (61, 'Ecuador'),
  (62, 'Egypt'),
  (63, 'El Salvador'),
  (64, 'Equatorial Guinea'),
  (65, 'Eritrea'),
  (66, 'Estonia'),
  (67, 'Ethiopia'),
  (68, 'Falkland Islands (Malvinas)'),
  (69, 'Faroe Islands'),
  (70, 'Fiji'),
  (71, 'Finland'),
  (72, 'France'),
  (73, 'France, Metropolitan'),
  (74, 'French Guiana'),
  (75, 'French Polynesia'),
  (76, 'French Southern Territories'),
  (77, 'Gabon'),
  (78, 'Gambia'),
  (79, 'Georgia'),
  (80, 'Germany'),
  (81, 'Ghana'),
  (82, 'Gibraltar'),
  (83, 'Guernsey'),
  (84, 'Greece'),
  (85, 'Greenland'),
  (86, 'Grenada'),
  (87, 'Guadeloupe'),
  (88, 'Guam'),
  (89, 'Guatemala'),
  (90, 'Guinea'),
  (91, 'Guinea-Bissau'),
  (92, 'Guyana'),
  (93, 'Haiti'),
  (94, 'Heard and Mc Donald Islands'),
  (95, 'Honduras'),
  (96, 'Hong Kong'),
  (97, 'Hungary'),
  (98, 'Iceland'),
  (99, 'India'),
  (100, 'Isle of Man'),
  (101, 'Indonesia'),
  (102, 'Iran (Islamic Republic of)'),
  (103, 'Iraq'),
  (104, 'Ireland'),
  (105, 'Israel'),
  (106, 'Italy'),
  (107, 'Ivory Coast'),
  (108, 'Jersey'),
  (109, 'Jamaica'),
  (110, 'Japan'),
  (111, 'Jordan'),
  (112, 'Kazakhstan'),
  (113, 'Kenya'),
  (114, 'Kiribati'),
  (115, 'Korea, Democratic People''s Republic of'),
  (116, 'Korea, Republic of'),
  (117, 'Kosovo'),
  (118, 'Kuwait'),
  (119, 'Kyrgyzstan'),
  (120, 'Lao People''s Democratic Republic'),
  (121, 'Latvia'),
  (122, 'Lebanon'),
  (123, 'Lesotho'),
  (124, 'Liberia'),
  (125, 'Libyan Arab Jamahiriya'),
  (126, 'Liechtenstein'),
  (127, 'Lithuania'),
  (128, 'Luxembourg'),
  (129, 'Macau'),
  (130, 'Macedonia'),
  (131, 'Madagascar'),
  (132, 'Malawi'),
  (133, 'Malaysia'),
  (134, 'Maldives'),
  (135, 'Mali'),
  (136, 'Malta'),
  (137, 'Marshall Islands'),
  (138, 'Martinique'),
  (139, 'Mauritania'),
  (140, 'Mauritius'),
  (141, 'Mayotte'),
  (142, 'Mexico'),
  (143, 'Micronesia, Federated States of'),
  (144, 'Moldova, Republic of'),
  (145, 'Monaco'),
  (146, 'Mongolia'),
  (147, 'Montenegro'),
  (148, 'Montserrat'),
  (149, 'Morocco'),
  (150, 'Mozambique'),
  (151, 'Myanmar'),
  (152, 'Namibia'),
  (153, 'Nauru'),
  (154, 'Nepal'),
  (155, 'Netherlands'),
  (156, 'Netherlands Antilles'),
  (157, 'New Caledonia'),
  (158, 'New Zealand'),
  (159, 'Nicaragua'),
  (160, 'Niger'),
  (161, 'Nigeria'),
  (162, 'Niue'),
  (163, 'Norfolk Island'),
  (164, 'Northern Mariana Islands'),
  (165, 'Norway'),
  (166, 'Oman'),
  (167, 'Pakistan'),
  (168, 'Palau'),
  (169, 'Palestine'),
  (170, 'Panama'),
  (171, 'Papua New Guinea'),
  (172, 'Paraguay'),
  (173, 'Peru'),
  (174, 'Philippines'),
  (175, 'Pitcairn'),
  (176, 'Poland'),
  (177, 'Portugal'),
  (178, 'Puerto Rico'),
  (179, 'Qatar'),
  (180, 'Reunion'),
  (181, 'Romania'),
  (182, 'Russian Federation'),
  (183, 'Rwanda'),
  (184, 'Saint Kitts and Nevis'),
  (185, 'Saint Lucia'),
  (186, 'Saint Vincent and the Grenadines'),
  (187, 'Samoa'),
  (188, 'San Marino'),
  (189, 'Sao Tome and Principe'),
  (190, 'Saudi Arabia'),
  (191, 'Senegal'),
  (192, 'Serbia'),
  (193, 'Seychelles'),
  (194, 'Sierra Leone'),
  (195, 'Singapore'),
  (196, 'Slovakia'),
  (197, 'Slovenia'),
  (198, 'Solomon Islands'),
  (199, 'Somalia'),
  (200, 'South Africa'),
  (201, 'South Georgia South Sandwich Islands'),
  (202, 'Spain'),
  (203, 'Sri Lanka'),
  (204, 'St. Helena'),
  (205, 'St. Pierre and Miquelon'),
  (206, 'Sudan'),
  (207, 'Suriname'),
  (208, 'Svalbard and Jan Mayen Islands'),
  (209, 'Swaziland'),
  (210, 'Sweden'),
  (211, 'Switzerland'),
  (212, 'Syrian Arab Republic'),
  (213, 'Taiwan'),
  (214, 'Tajikistan'),
  (215, 'Tanzania, United Republic of'),
  (216, 'Thailand'),
  (217, 'Togo'),
  (218, 'Tokelau'),
  (219, 'Tonga'),
  (220, 'Trinidad and Tobago'),
  (221, 'Tunisia'),
  (222, 'Turkey'),
  (223, 'Turkmenistan'),
  (224, 'Turks and Caicos Islands'),
  (225, 'Tuvalu'),
  (226, 'Uganda'),
  (227, 'Ukraine'),
  (228, 'United Arab Emirates'),
  (229, 'United Kingdom'),
  (230, 'United States'),
  (231, 'United States minor outlying islands'),
  (232, 'Uruguay'),
  (233, 'Uzbekistan'),
  (234, 'Vanuatu'),
  (235, 'Vatican City State'),
  (236, 'Venezuela'),
  (237, 'Vietnam'),
  (238, 'Virgin Islands (British)'),
  (239, 'Virgin Islands (U.S.)'),
  (240, 'Wallis and Futuna Islands'),
  (241, 'Western Sahara'),
  (242, 'Yemen'),
  (243, 'Yugoslavia'),
  (244, 'Zaire'),
  (245, 'Zambia'),
  (246, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE `feedbacks` (
  `feedbackId` int(11) NOT NULL,
  `auctionId` int(11) NOT NULL,
  `receiverId` int(11) NOT NULL,
  `creatorId` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

DROP TABLE IF EXISTS `item_categories`;
CREATE TABLE `item_categories` (
  `categoryId` int(11) NOT NULL,
  `superCategoryId` int(11) NOT NULL,
  `categoryName` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`categoryId`, `superCategoryId`, `categoryName`) VALUES
  (1, 1, 'Collectables'),
  (2, 1, 'Antiques'),
  (3, 1, 'Sports Memorabilia'),
  (4, 1, 'Coins'),
  (5, 2, 'Garden'),
  (6, 2, 'Appliances'),
  (7, 2, 'DIY Materials'),
  (8, 2, 'Furniture & Homeware'),
  (9, 3, 'Cycling'),
  (10, 3, 'Fishing'),
  (11, 3, 'Fitness, Running & Yoga'),
  (12, 3, 'Golf'),
  (13, 4, 'Mobile Phones'),
  (14, 4, 'Sound & Vision'),
  (15, 4, 'Video Games'),
  (16, 4, 'Computer & Tables'),
  (17, 5, 'Watches'),
  (18, 5, 'Costume Jewellery'),
  (19, 5, 'Vintage & Antique Jewelery'),
  (20, 5, 'Fine Jewelery'),
  (21, 6, 'Radio Controlled'),
  (22, 6, 'Construction Toys'),
  (23, 6, 'Outdoor Toys'),
  (24, 6, 'Action Figures'),
  (25, 7, 'Women''s Clothing'),
  (26, 7, 'Men''s Clothing'),
  (27, 7, 'Shoes'),
  (28, 7, 'Kid''s Fashion'),
  (29, 8, 'Cars'),
  (30, 8, 'Car Parts'),
  (31, 8, 'Motorcycles & Scooters'),
  (32, 8, 'Motorcycle Parts'),
  (33, 9, 'Books, Comics & Magazines'),
  (34, 9, 'Health & Beauty'),
  (35, 9, 'Musical Instruments'),
  (36, 9, 'Business, Office & Industrial');

-- --------------------------------------------------------

--
-- Table structure for table `item_conditions`
--

DROP TABLE IF EXISTS `item_conditions`;
CREATE TABLE `item_conditions` (
  `conditionId` int(2) NOT NULL,
  `conditionName` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_conditions`
--

INSERT INTO `item_conditions` (`conditionId`, `conditionName`) VALUES
  (1, 'Brand New'),
  (2, 'New other'),
  (3, 'Used'),
  (4, 'For parts or not working');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `itemId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `itemName` varchar(45) NOT NULL,
  `itemBrand` varchar(45) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `conditionId` int(2) NOT NULL,
  `itemDescription` varchar(2000) NOT NULL,
  `image` varchar(300) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=latin1;


--
-- Table structure for table `sort_options`
--

DROP TABLE IF EXISTS `sort_options`;
CREATE TABLE `sort_options` (
  `sortId` int(11) NOT NULL,
  `sortName` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sort_options`
--

INSERT INTO `sort_options` (`sortId`, `sortName`) VALUES
  (1, 'Best Match'),
  (2, 'Time: ending soonest'),
  (3, 'Time: newly listed'),
  (4, 'Price: lowest first'),
  (5, 'Price: highest first'),
  (6, 'Distance: nearest first');

-- --------------------------------------------------------

--
-- Table structure for table `super_item_categories`
--

DROP TABLE IF EXISTS `super_item_categories`;
CREATE TABLE `super_item_categories` (
  `superCategoryId` int(11) NOT NULL,
  `superCategoryName` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `super_item_categories`
--

INSERT INTO `super_item_categories` (`superCategoryId`, `superCategoryName`) VALUES
  (1, 'Collectables & Antiques'),
  (2, 'Home & Garden'),
  (3, 'Sporting Goods'),
  (4, 'Electronics'),
  (5, 'Jewelery & Watches'),
  (6, 'Toys & Games'),
  (7, 'Fashion'),
  (8, 'Motors'),
  (9, 'Everything Else');

-- --------------------------------------------------------

--
-- Table structure for table `unverified_users`
--

DROP TABLE IF EXISTS `unverified_users`;
CREATE TABLE `unverified_users` (
  `userId` int(11) NOT NULL,
  `confirmCode` varchar(60) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unverified_users`
--
--
-- INSERT INTO `unverified_users` (`userId`, `confirmCode`) VALUES
--   (6, '38007188'),
--   (7, '38787806'),
--   (8, '84752420'),
--   (9, '36464858'),
--   (110, '64787719'),
--   (113, '75368781'),
--   (114, '10022901'),
--   (115, '32101785'),
--   (116, '30784045'),
--   (117, '91769063'),
--   (118, '1122468');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
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
  `verified` tinyint(1) DEFAULT '0',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `username`, `email`, `firstName`, `lastName`, `address`, `postcode`, `city`, `countryId`, `password`, `verified`, `image`) VALUES
  (1, 'Andy1234', 'xxx', 'Andreas', 'Rauter', 'Flat 23 Prospect House, Donegal Street', 'N19QD', 'London', 229, '$2y$10$VraZBbuk/StYSL3tp261Iu9R3/8YLNVcGaMEN2C8YAFlc6JzMlGpW', 1, ''),
  (5, 'sickAustrian', 'andreas.l.rauter@gmail.com', 'Andreas Lukas', 'Rauter', 'Flat 23 Prospect House, Donegal Street', 'N19QA', 'London', 114, '$2y$10$CdMrB2AI5CcpjMdN8bAuK.1c1BMaqKWdUJshPTGHau5iK1BKe0ZTO', 1, '56c4ee12da9e26.43716469.jpg'),
  (6, 'uuu', 'jack roper@gmail.com', 'll', 'll', 'll', 'll', 'ss', 2, '$2y$10$dA1CDqlihaF4mWzJxoTlsOhiJtiWklkaqrPuaWFOCtJVLSVY2RHvG', 0, NULL),
  (7, 'xxxx', 'xxxx@gmail.com', 'kk', 'kk', 'kk', 'kk', 'kk', 2, '$2y$10$UCDfTwtkCpoMF0DVb5F3Leyn639kh1yV0GfL.5JrXOYRPGhZx5cU.', 0, NULL),
  (8, 'all', 'baumhaus@gmail.com', 'll', 'll', 'll', 'll', 'll', 1, '$2y$10$392npKG7jLqZgW3X.Wp.w.iHtweHNqaT/iPalkoNQ1pP8Z5vmDfSC', 0, NULL),
  (9, 'Gea', 'andreas.rauter1@gmx.at', 'll', 'll', 'll', 'll', 'll', 1, '$2y$10$AJ.NCzeHNy8xBsVvwspyluz13HJVq3fleg7tzrlrCLlZRPsSkO0I6', 0, NULL);


--
-- Indexes for table `auction_watches`
--
ALTER TABLE `auction_watches`
ADD PRIMARY KEY (`watchId`),
ADD KEY `AuctionID_idx` (`auctionId`),
ADD KEY `fk_AuctionWatch_User1_idx` (`userId`);

--
-- Indexes for table `auctions`
--
ALTER TABLE `auctions`
ADD PRIMARY KEY (`auctionId`),
ADD KEY `fk_Auctions_Items1_idx` (`itemId`);

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
ADD PRIMARY KEY (`bidId`),
ADD KEY `fk_bids_auctions1_idx` (`auctionId`),
ADD KEY `fk_bids_users1_idx` (`userId`);

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
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
ADD PRIMARY KEY (`categoryId`),
ADD KEY `fk_superCategory_idx` (`superCategoryId`);

--
-- Indexes for table `item_conditions`
--
ALTER TABLE `item_conditions`
ADD PRIMARY KEY (`conditionId`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
ADD PRIMARY KEY (`itemId`),
ADD KEY `fk_Auction_User1_idx` (`userId`),
ADD KEY `CategoryID_idx` (`categoryId`),
ADD KEY `ConditionNo_idx` (`conditionId`);

--
-- Indexes for table `sort_options`
--
ALTER TABLE `sort_options`
ADD PRIMARY KEY (`sortId`);

--
-- Indexes for table `super_item_categories`
--
ALTER TABLE `super_item_categories`
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
--
-- AUTO_INCREMENT for table `auction_watches`
--
ALTER TABLE `auction_watches`
MODIFY `watchId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `auctions`
--
ALTER TABLE `auctions`
MODIFY `auctionId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=183;
--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
MODIFY `bidId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1141;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
MODIFY `countryId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=247;
--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
MODIFY `feedbackId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=189;
--
-- AUTO_INCREMENT for table `sort_options`
--
ALTER TABLE `sort_options`
MODIFY `sortId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `super_item_categories`
--
ALTER TABLE `super_item_categories`
MODIFY `superCategoryId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `unverified_users`
--
ALTER TABLE `unverified_users`
MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=119;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=119;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auction_watches`
--
ALTER TABLE `auction_watches`
ADD CONSTRAINT `AuctionNo` FOREIGN KEY (`auctionId`) REFERENCES `auctions` (`auctionId`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_AuctionWatch_User1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `auctions`
--
ALTER TABLE `auctions`
ADD CONSTRAINT `fk_item` FOREIGN KEY (`itemId`) REFERENCES `items` (`itemId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `bids`
--
ALTER TABLE `bids`
ADD CONSTRAINT `fk_bids_auctions1` FOREIGN KEY (`auctionId`) REFERENCES `auctions` (`auctionId`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_bids_users1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
ADD CONSTRAINT `fk_Feedback_User1` FOREIGN KEY (`creatorId`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_Feedback_Users1` FOREIGN KEY (`receiverId`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ADD CONSTRAINT `fk_feedbacks_auctions1` FOREIGN KEY (`auctionId`) REFERENCES `auctions` (`auctionId`) ON DELETE NO ACTION ON UPDATE NO ACTION,

--
-- Constraints for table `item_categories`
--
ALTER TABLE `item_categories`
ADD CONSTRAINT `fk_superCategory` FOREIGN KEY (`superCategoryId`) REFERENCES `super_item_categories` (`superCategoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
ADD CONSTRAINT `CategoryNo` FOREIGN KEY (`categoryId`) REFERENCES `item_categories` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `ConditionNo` FOREIGN KEY (`conditionId`) REFERENCES `item_conditions` (`conditionId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_user` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
MODIFY COLUMN itemName VARCHAR(45) CHARACTER SET UTF8 COLLATE UTF8_GENERAL_CI;

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
