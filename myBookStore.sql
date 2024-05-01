-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 22, 2023 at 06:05 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `textbook_trove_group39`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `username`, `password`) VALUES
(1, 'Admin 1', 'admin1', '$2a$12$XU4sikQ6ZOXsiMeQuvhXj./j2z.uDctR0uQVMxwP/NT5T3z5C20G'),
(2, 'Admin 2', 'admin2', '$2a$12$n7tBps6z9cKEFV03.mtYPeKToZZPpyKiFrJ4X0kKbUtRKFr/4rI72'),
(3, 'Admin 3', 'admin3', '$2a$12$ncBeUHd4I2SDntZW2q1sl.IKGRuyUOf5InRk6XjsRWZ.N9GgXXqtS'),
(4, 'Admin 4', 'admin4', '$2a$12$.2m2iym.YAA1DhQQ0LUIPOQRzom/oyRk0vdTmP5Dhwa01W9/AOKcS'),
(5, 'Admin 5', 'admin5', '$2a$12$qnXOqIJ2JeAM7mP4hqW.FWezjWUuJ1Yw3N3x0y9T95vG0exkCmDjE'),
(6, 'test', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `basket`
--

DROP TABLE IF EXISTS `basket`;
CREATE TABLE IF NOT EXISTS `basket` (
  `basket_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `user_id` int NOT NULL,
  `seller` varchar(255) NOT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`basket_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `book_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `edition` varchar(255) NOT NULL,
  `condition` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `release_year` year NOT NULL,
  `description` varchar(255) NOT NULL,
  `available` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `seller` varchar(255) NOT NULL,
  `img_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `title`, `author`, `edition`, `condition`, `isbn`, `release_year`, `description`, `available`, `publisher`, `price`, `seller`, `img_url`) VALUES
(22, 'Chemistry: The Central Science', 'Theodore L. Brown, H. Eugene LeMay, Bruce E. Bursten', '15th', 'Like_New', '978-0-13-498880-1', 2017, 'A comprehensive chemistry textbook', 'Yes', 'Pearson', 109.99, 'jwilson05', 'ChemistryTheCentralScience'),
(23, 'Principles of Economics', 'N. Gregory Mankiw', '8th', 'Worn', '978-1-305-58512-6', 2017, 'A classic economics textbook', 'Yes', 'Cengage Learning', 289.95, 'jwilson05', 'PrinciplesofEconomics'),
(24, 'Calculus: Early Transcendentals', 'James Stewart', '8th', 'Like_New', '978-1-285-74156-0', 2015, 'A calculus textbook for advanced students', 'No', 'Cengage Learning', 119.99, 'jwilson05', 'CalculusEarlyTranscendentals'),
(25, 'Introduction to Psychology', 'James W. Kalat', '11th', 'Dying', '978-1-305-25067-3', 2016, 'A foundational psychology textbook', 'Yes', 'Cengage Learning', 739.95, 'jwilson05', 'IntroductiontoPsychology'),
(26, 'Physics for Scientists and Engineers', 'Raymond A. Serway, John W. Jewett', '10th', 'Worn', '978-1-285-91334-7', 2018, 'A comprehensive physics textbook', 'No', 'Cengage Learning', 299.99, 'jwilson05', 'PhysicsforScientistsandEngineers'),
(27, 'Organic Chemistry', 'Paula Y. Bruice', '8th', 'Like_New', '978-0-321-97633-0', 2017, 'A textbook for organic chemistry students', 'Yes', 'Pearson', 114.99, 'jwilson05', 'OrganicChemistry'),
(28, 'Microbiology: An Introduction', 'Gerard J. Tortora, Berdell R. Funke, Christine L. Case', '13th', 'Like_New', '978-0-321-96857-2', 2018, 'A comprehensive microbiology textbook', 'No', 'Pearson', 419.99, 'jwilson05', 'MicrobiologyAnIntroduction'),
(29, 'Fundamentals of Financial Management', 'Eugene F. Brigham, Joel F. Houston', '14th', 'Worn', '978-1-337-56055-0', 2017, 'A financial management textbook', 'Yes', 'Cengage Learning', 399.95, 'jwilson05', 'FundamentalsofFinancialManagement'),
(30, 'Essential Cell Biology', 'Bruce Alberts, Dennis Bray, Karen Hopkin', '4th', 'Worn', '978-0-8153-2143-7', 2013, 'A cell biology textbook', 'No', 'Garland Science', 109.99, 'jwilson05', 'EssentialCellBiology'),
(31, 'Business Ethics: Ethical Decision Making & Cases', 'O. C. Ferrell, John Fraedrich, Linda Ferrell', '12th', 'Dying', '978-1-305-50392-2', 2018, 'A business ethics textbook', 'Yes', 'Cengage Learning', 289.95, 'jwilson05', 'BusinessEthicsEthicalDecisionMakingandCases'),
(32, 'Essentials of Human Anatomy & Physiology', 'Elaine N. Marieb, Katja Hoehn', '12th', 'Like_New', '978-0-13-460577-7', 2018, 'A comprehensive anatomy and physiology textbook', 'Yes', 'Pearson', 109.99, 'jwilson05', 'EssentialsofHumanAnatomyandPhysiology'),
(33, 'Modern Database Management', 'Jeffrey A. Hoffer, Ramesh Venkataraman, Heikki Topi', '13th', 'Like_New', '978-0-13-442578-9', 2018, 'A textbook on database management', 'No', 'Pearson', 119.99, 'jwilson05', 'ModernDatabaseManagement'),
(34, 'Statistics for Business & Economics', 'Paul Newbold, William L. Carlson, Betty Thorne', '8th', 'Worn', '978-0-273-79729-0', 2019, 'A statistics textbook for business students', 'Yes', 'Pearson', 993.95, '', 'StatisticsforBusinessandEconomics'),
(35, 'Marketing Management', 'Philip T. Kotler, Kevin Lane Keller', '15th', 'Worn', '978-0-13-385646-0', 2015, 'A marketing management textbook', 'No', 'Pearson', 109.99, '', 'MarketingManagement'),
(36, 'Managerial Accounting', 'Ray H. Garrison, Eric W. Noreen, Peter C. Brewer', '16th', 'Like_New', '978-0-07-811100-6', 2017, 'A managerial accounting textbook', 'Yes', 'McGraw-Hill', 119.99, '', 'ManagerialAccounting'),
(37, 'Fundamentals of Management', 'Stephen P. Robbins, Mary A. Coulter, David A. DeCenzo', '10th', 'Dying', '978-0-13-423747-3', 2017, 'A fundamentals of management textbook', 'No', 'Pearson', 923.95, '', 'FundamentalsofManagement'),
(38, 'Computer Networking: Principles, Protocols and Practice', 'Olivier Bonaventure', '1st', 'Like_New', '978-2-87460-052-2', 2012, 'A computer networking textbook', 'Yes', 'no publisher', 233, '', 'ComputerNetworkingPrinciplesProtocolsandPractice'),
(39, 'Elementary Linear Algebra', 'Ron Larson, David C. Falvo', '8th', 'Worn', '978-1-305-27632-6', 2014, 'A textbook for linear algebra students', 'No', 'Cengage Learning', 923.99, '', 'ElementaryLinearAlgebra'),
(40, 'Fundamentals of Anatomy & Physiology', 'Frederic H. Martini, Judi L. Nath, Edwin F. Bartholomew', '11th', 'Worn', '978-0-13-439602-6', 2017, 'A comprehensive anatomy and physiology textbook', 'Yes', 'Pearson', 923.99, '', 'FundamentalsofAnatomyandPhysiology'),
(41, 'Introduction to Business Statistics', 'Ronald M. Weiers', '7th', 'Like_New', '978-1-111-42480-2', 2012, 'A textbook on business statistics', 'Yes', 'Cengage Learning', 234.95, '', 'IntroductiontoBusinessStatistics'),
(42, 'General Chemistry: The Essential Concepts', 'Raymond Chang, Jason Overby', '7th', 'Dying', '978-1-133-59770-0', 2014, 'A general chemistry textbook', 'No', 'McGraw-Hill', 234.99, '', 'GeneralChemistryTheEssentialConcepts');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `mesage_id` int NOT NULL,
  `sender_id` int NOT NULL,
  `reciever_id` int NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `user_id` int NOT NULL,
  `total` double NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_user`
--

DROP TABLE IF EXISTS `pending_user`;
CREATE TABLE IF NOT EXISTS `pending_user` (
  `pendingUser_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `st_num` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`pendingUser_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pending_user`
--

INSERT INTO `pending_user` (`pendingUser_id`, `name`, `username`, `st_num`, `email`, `password`) VALUES
(4, 'Alicia Brown', 'aliciab', '654321987', 'aliciab@example.com', '3f2306b99b96a1254c0804a4e3d70037'),
(6, 'Laura Miller', 'lauram', '321987654', 'lauram@example.com', '3a2bb2d3de82bc27d7ccfd3b5f570367'),
(7, 'William Wilson', 'willw', '876543219', 'willw@example.com', '60297de63b7c7f485ca4e6d7d7e05150'),
(9, 'Charles Harris', 'charlesh', '567890123', 'charlesh@example.com', '5a8378d51e1617893aa1a21eb93dd7c7'),
(10, 'Emily White', 'emilyw', '789012345', 'emilyw@example.com', 'bd52a5067f0b8b2b4b38374b4c96a73'),
(13, 'Olivia Smith', 'olivias', '321987654', 'olivias@example.com', '8c25bd17e6c88e7e1dd0a73cb734ea19'),
(14, 'Benjamin Lee', 'benjaminl', '654321987', 'benjaminl@example.com', '60297de63b7c7f485ca4e6d7d7e05150'),
(15, 'Grace Davis', 'graced', '789012345', 'graced@example.com', '3a2bb2d3de82bc27d7ccfd3b5f570367'),
(22, 'somename', 'root', '', 'esd@sjkdn.ewcp', '$2y$12$q/kD5jahE/2LQhSmHrL9M.Yr1.ddFpH3Zq/5TpRO2reV3DDyAR/T2'),
(19, 'Sophia Taylor', 'sophiat', '321987654', 'sophiat@example.com', '5a8378d51e1617893aa1a21eb93dd7c7'),
(24, 'mad max', 'root', '438594343', 'zacaejh@sre.cwsew', '$2y$12$R47Z7gdYHnz1y6uJEZ5lLODvliJb0JjLobnTvBwjuubQc5a9G/C8u');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `st_num` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `listing_id` bigint DEFAULT NULL,
  `book_id` bigint DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `listing_id` (`listing_id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `username`, `st_num`, `password`, `email`, `listing_id`, `book_id`) VALUES
(2, 'Kill Bill vol.1', 'sjohnson02', '987654321', '$2a$12$n7tBps6z9cKEFV03.mtYPeKToZZPpyKiFrJ4X0kKbUtRKFr/4rI72', 'sjohnson02@email.com', 2, 2),
(3, 'Michael Williams', 'mwilliams03', '234567890', '$2a$12$ncBeUHd4I2SDntZW2q1sl.IKGRuyUOf5InRk6XjsRWZ.N9GgXXqtS', 'mwilliams03@email.com', 3, 3),
(5, 'James Wilson', 'jwilson05', '345678901', '$2a$12$qnXOqIJ2JeAM7mP4hqW.FWezjWUuJ1Yw3N3x0y9T95vG0exkCmDjE', 'jwilson05@email.com', 5, 5),
(6, 'Emma Brown', 'ebrown06', '987123456', '$2a$12$eqYc4gLhWTTle42ZLop4h.aDnU8H/Se8mDIDPeM/WjxCM2Bb3tdES', 'ebrown06@email.com', 6, 6),
(7, 'William Lee', 'wlee07', '654321789', '$2a$12$8GEnPFodtm/6cvKfJ1Bv3exRKiC75VrsiJktVG6rq2yXsBxjWEVHa', 'wlee07@email.com', 7, 7),
(8, 'Olivia Clark', 'oclark08', '789123456', '$2a$12$a7QbO7P0v1S4XTecpl7RBObq9XxWV/JJEE9abxc0VJiRBOvHPEsQG', 'oclark08@email.com', 8, 8),
(9, 'Kill Bill vol.1', 'bhall09', '987654321', '$2a$12$2N5Bsoa7KsUDyJkqDBtNfusHd/mgYncUVBAP7iRzIs6B.4ziMiTRi', 'bhall09@email.com', 9, 9),
(10, 'Sophia Miller', 'smiller10', '234567890', '$2a$12$f6rC5NRcf2pJwncGt.z7DOUbj4ifDoO7fUE7B3vDDk2CgoO7H/TsK', 'smiller10@email.com', 10, 10),
(29, 'Kill Bill vol.1', 'lucash', '987654321', '8c6976e5b541041a46b9b5d5a9e11601', 'lucash@example.com', NULL, NULL),
(12, 'Daniel King', 'dking13', '987123456', '$2a$12$tG3MncuIj.UujEiE.VYt1uhyMNRBq6p0FzPYu8PZ7zXXIdS6NWDkm', 'dking13@email.com', 12, 12),
(13, 'Mia Wright', 'mwright14', '234567891', '$2a$12$Uv3q9kJ34QWj01Lk1jsTTuNXxSD.G2qXk/ygBB5xd5Fob3okgRsRm', 'mwright14@email.com', 13, 13),
(14, 'Joseph Garcia', 'jgarcia15', '567891234', '$2a$12$1YwqV3L2IZISL7G14okg3.r2zSyvZPimrCEb4qB7Fd/ZG5DLg6wwC', 'jgarcia15@email.com', 14, 14),
(27, 'Kill Bill vol.1', 'sarahj', '987654321', '9a1158154dfa0f7a84ad144e8e52a6', 'sarahj@example.com', NULL, NULL),
(28, 'Kill Bill vol.1', 'ellas', '987654321', '71c480df93d6b9b9c1db1e078b45ed16', 'ellas@example.com', NULL, NULL),
(16, 'David Martinez', 'dmartinez17', '654321789', '$2a$12$Kq4H3VpFr1JGclpNpGAS7.jDtp2A3Gxu8nvHAD0OnNabGmO8Dr98q', 'dmartinez17@email.com', 16, 16),
(17, 'Chloe Scott', 'cscott18', '789123456', '$2a$12$siKu.3Gc1xlOVAPVDeoHnu.l4kqCMe0tA.Vu..tdLB7ncmKfz4WMu', 'cscott18@email.com', 17, 17),
(18, 'Samuel Turner', 'sturner19', '987123456', '$2a$12$EqyM/DeGb3sttRBXli2QiO/r8d9yYyGAI9Z8oqq6bzdb4P3Xsbhwq', 'sturner19@email.com', 18, 18),
(20, 'name', 'test', 'test', 'test', 'test', 34523, 25345),
(26, 'Kill Bill vol.1', 'janesmith', '987654321', '9a1158154dfa0f7a84ad144e8e52a6', 'janesmith@example.com', NULL, NULL),
(25, 'Robert Davis', 'robdavis', '789123456', '8c25bd17e6c88e7e1dd0a73cb734ea19', 'robdavis@example.com', NULL, NULL),
(34, 'TestingApp', 'app', '1234567', '$2y$12$o.j3eXNuK6t7OKp5HjS7u.eScdhsSdqdVAkJP5hbsb2ocEO2HogFe', 'email@asc.cowcw', NULL, NULL),
(33, 'Jennifer Lee', 'jenniferl', '234567890', '71c480df93d6b9b9c1db1e078b45ed16', 'jenniferl@example.com', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
