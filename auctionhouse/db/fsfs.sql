-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema auctionsystem
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema auctionsystem
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `auctionsystem` DEFAULT CHARACTER SET latin1 ;
USE `auctionsystem` ;

-- -----------------------------------------------------
-- Table `auctionsystem`.`auction_views`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `auctionsystem`.`auction_views` ;

CREATE TABLE IF NOT EXISTS `auctionsystem`.`auction_views` (
  `viewId` INT(11) NOT NULL AUTO_INCREMENT,
  `auctionId` INT(11) NOT NULL,
  `viewTime` DATETIME NOT NULL,
  PRIMARY KEY (`viewId`),
  INDEX `fk_auction_idx` (`auctionId` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `auctionsystem`.`super_item_categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `auctionsystem`.`super_item_categories` ;

CREATE TABLE IF NOT EXISTS `auctionsystem`.`super_item_categories` (
  `superCategoryId` INT(11) NOT NULL AUTO_INCREMENT,
  `superCategoryName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`superCategoryId`))
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `auctionsystem`.`item_categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `auctionsystem`.`item_categories` ;

CREATE TABLE IF NOT EXISTS `auctionsystem`.`item_categories` (
  `categoryId` INT(11) NOT NULL AUTO_INCREMENT,
  `superCategoryId` INT(11) NOT NULL,
  `categoryName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`categoryId`),
  INDEX `fk_superCategory_idx` (`superCategoryId` ASC),
  CONSTRAINT `fk_superCategory`
    FOREIGN KEY (`superCategoryId`)
    REFERENCES `auctionsystem`.`super_item_categories` (`superCategoryId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 37
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `auctionsystem`.`item_conditions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `auctionsystem`.`item_conditions` ;

CREATE TABLE IF NOT EXISTS `auctionsystem`.`item_conditions` (
  `conditionId` INT(2) NOT NULL,
  `conditionName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`conditionId`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `auctionsystem`.`items`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `auctionsystem`.`items` ;

CREATE TABLE IF NOT EXISTS `auctionsystem`.`items` (
  `itemId` INT(11) NOT NULL AUTO_INCREMENT,
  `itemName` VARCHAR(45) NOT NULL,
  `itemBrand` VARCHAR(45) NOT NULL,
  `categoryId` INT(11) NOT NULL,
  `conditionId` INT(2) NOT NULL,
  `itemDescription` VARCHAR(2000) NOT NULL,
  `image` VARCHAR(30) NULL DEFAULT NULL,
  PRIMARY KEY (`itemId`),
  INDEX `CategoryID_idx` (`categoryId` ASC),
  INDEX `ConditionNo_idx` (`conditionId` ASC),
  CONSTRAINT `CategoryNo`
    FOREIGN KEY (`categoryId`)
    REFERENCES `auctionsystem`.`item_categories` (`categoryId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `ConditionNo`
    FOREIGN KEY (`conditionId`)
    REFERENCES `auctionsystem`.`item_conditions` (`conditionId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 26
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `auctionsystem`.`countries`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `auctionsystem`.`countries` ;

CREATE TABLE IF NOT EXISTS `auctionsystem`.`countries` (
  `countryId` INT(11) NOT NULL AUTO_INCREMENT,
  `countryName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`countryId`))
ENGINE = InnoDB
AUTO_INCREMENT = 247
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `auctionsystem`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `auctionsystem`.`users` ;

CREATE TABLE IF NOT EXISTS `auctionsystem`.`users` (
  `userId` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `firstName` VARCHAR(45) NOT NULL,
  `lastName` VARCHAR(45) NOT NULL,
  `address` VARCHAR(90) NOT NULL,
  `postcode` VARCHAR(45) NOT NULL,
  `city` VARCHAR(45) NOT NULL,
  `countryId` INT(11) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  `verified` TINYINT(1) NULL DEFAULT '0',
  `image` VARCHAR(30) NULL DEFAULT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  INDEX `fk_country_idx` (`countryId` ASC),
  CONSTRAINT `fk_country`
    FOREIGN KEY (`countryId`)
    REFERENCES `auctionsystem`.`countries` (`countryId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `auctionsystem`.`auctions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `auctionsystem`.`auctions` ;

CREATE TABLE IF NOT EXISTS `auctionsystem`.`auctions` (
  `auctionId` INT(11) NOT NULL AUTO_INCREMENT,
  `itemId` INT(11) NOT NULL,
  `userId` INT(11) NOT NULL,
  `quantity` INT(11) UNSIGNED NOT NULL DEFAULT '1',
  `startPrice` DECIMAL(10,2) UNSIGNED NOT NULL,
  `reservePrice` DECIMAL(10,2) UNSIGNED NOT NULL,
  `startTime` DATETIME NOT NULL,
  `endTime` DATETIME NOT NULL,
  `sold` TINYINT(2) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`auctionId`),
  INDEX `fk_Auctions_Items1_idx` (`itemId` ASC),
  INDEX `fk_Auction_User1_idx` (`userId` ASC),
  CONSTRAINT `fk_item`
    FOREIGN KEY (`itemId`)
    REFERENCES `auctionsystem`.`items` (`itemId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user`
    FOREIGN KEY (`userId`)
    REFERENCES `auctionsystem`.`users` (`userId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `auctionsystem`.`auction_watchs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `auctionsystem`.`auction_watchs` ;

CREATE TABLE IF NOT EXISTS `auctionsystem`.`auction_watchs` (
  `watchId` INT(11) NOT NULL AUTO_INCREMENT,
  `userId` INT(11) NOT NULL,
  `auctionId` INT(11) NOT NULL,
  PRIMARY KEY (`watchId`),
  INDEX `AuctionID_idx` (`auctionId` ASC),
  INDEX `fk_AuctionWatch_User1_idx` (`userId` ASC),
  CONSTRAINT `AuctionNo`
    FOREIGN KEY (`auctionId`)
    REFERENCES `auctionsystem`.`auctions` (`auctionId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_AuctionWatch_User1`
    FOREIGN KEY (`userId`)
    REFERENCES `auctionsystem`.`users` (`userId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `auctionsystem`.`bids`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `auctionsystem`.`bids` ;

CREATE TABLE IF NOT EXISTS `auctionsystem`.`bids` (
  `bidId` INT(11) NOT NULL AUTO_INCREMENT,
  `userId` INT(11) NOT NULL,
  `auctionId` INT(11) NOT NULL,
  `bidTime` DATETIME NOT NULL,
  `bidPrice` DECIMAL(10,2) UNSIGNED NOT NULL,
  PRIMARY KEY (`bidId`),
  INDEX `fk_bids_auctions1_idx` (`auctionId` ASC),
  INDEX `fk_bids_users1_idx` (`userId` ASC),
  CONSTRAINT `fk_bids_auctions1`
    FOREIGN KEY (`auctionId`)
    REFERENCES `auctionsystem`.`auctions` (`auctionId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bids_users1`
    FOREIGN KEY (`userId`)
    REFERENCES `auctionsystem`.`users` (`userId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `auctionsystem`.`feedbacks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `auctionsystem`.`feedbacks` ;

CREATE TABLE IF NOT EXISTS `auctionsystem`.`feedbacks` (
  `feedbackId` INT(11) NOT NULL AUTO_INCREMENT,
  `auctionId` INT(11) NOT NULL,
  `receiverId` INT(11) NOT NULL,
  `creatorId` INT(11) NOT NULL,
  `score` INT(11) NOT NULL,
  `comment` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`feedbackId`),
  INDEX `fk_Feedback_Users1_idx` (`receiverId` ASC),
  INDEX `fk_Feedback_User1_idx` (`creatorId` ASC),
  INDEX `fk_feedbacks_auctions1_idx` (`auctionId` ASC),
  CONSTRAINT `fk_feedbacks_auctions1`
    FOREIGN KEY (`auctionId`)
    REFERENCES `auctionsystem`.`auctions` (`auctionId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Feedback_User1`
    FOREIGN KEY (`creatorId`)
    REFERENCES `auctionsystem`.`users` (`userId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Feedback_Users1`
    FOREIGN KEY (`receiverId`)
    REFERENCES `auctionsystem`.`users` (`userId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `auctionsystem`.`unverified_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `auctionsystem`.`unverified_users` ;

CREATE TABLE IF NOT EXISTS `auctionsystem`.`unverified_users` (
  `userId` INT(11) NOT NULL AUTO_INCREMENT,
  `confirmCode` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE INDEX `userId_UNIQUE` (`userId` ASC),
  CONSTRAINT `userId`
    FOREIGN KEY (`userId`)
    REFERENCES `auctionsystem`.`users` (`userId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
