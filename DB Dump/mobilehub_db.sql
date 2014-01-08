-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2014 at 12:57 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mobilehub_db`
--
CREATE DATABASE IF NOT EXISTS `mobilehub_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mobilehub_db`;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `answerId` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(11) NOT NULL,
  `answeredUserId` int(11) NOT NULL,
  `answeredOn` datetime NOT NULL,
  `description` varchar(600) NOT NULL,
  `netVotes` int(4) DEFAULT NULL,
  `upVotes` int(4) NOT NULL,
  `downVotes` int(4) NOT NULL,
  `isBestAnswer` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`answerId`),
  KEY `questionId` (`questionId`),
  KEY `answeredUserId` (`answeredUserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answerId`, `questionId`, `answeredUserId`, `answeredOn`, `description`, `netVotes`, `upVotes`, `downVotes`, `isBestAnswer`) VALUES
(43, 37, 22, '2014-01-01 18:20:54', 'Sample answer', 1, 1, 0, 0),
(44, 36, 32, '2014-01-01 18:20:55', 'You can try posting your current code', 0, 0, 0, 0),
(45, 39, 22, '2014-01-01 18:20:57', 'You can close questions so that no body can provide answers thereafter. Thanks', 0, 0, 0, 0),
(46, 39, 22, '2014-01-01 18:34:03', 'another ansewr', 1, 1, 0, 1),
(47, 39, 2, '2014-01-01 18:21:01', 'dfgdfgdfgfd', 1, 1, 0, 0),
(48, 36, 2, '2013-12-30 18:21:02', 'Yep please do share your code so that we can help you', 0, 0, 0, NULL),
(49, 43, 32, '2013-12-31 22:32:22', 'Use jQuery mobile. It''s the best', 0, 0, 0, 1),
(50, 43, 2, '2014-01-01 17:09:07', 'Another answer on this matter', 0, 0, 0, NULL),
(51, 36, 2, '2014-01-01 17:14:07', 'Write your code from scratch! That''s the best way :)', 1, 1, 0, 1),
(52, 42, 22, '2014-01-01 18:01:58', 'Use media queries.', 0, 0, 0, NULL),
(53, 44, 22, '2014-01-01 18:02:19', 'Media queries FTW!!!', 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `answer_votes`
--

CREATE TABLE IF NOT EXISTS `answer_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `votedUserId` int(11) NOT NULL,
  `isUpVote` tinyint(1) NOT NULL,
  `ansId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `votedUserId` (`votedUserId`),
  KEY `ansId` (`ansId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `answer_votes`
--

INSERT INTO `answer_votes` (`id`, `votedUserId`, `isUpVote`, `ansId`) VALUES
(1, 32, 1, 43),
(2, 2, 1, 46),
(3, 22, 1, 47),
(4, 22, 1, 51),
(5, 2, 1, 53);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) NOT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryId`, `categoryName`) VALUES
(1, 'Android'),
(2, 'iOS'),
(3, 'Windows Phone'),
(4, 'General');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('014e919f92e109863c65670712096b96', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', 1389142035, ''),
('0cf23f1365ee38320c55ce2d6883a018', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', 1389128640, 'a:1:{s:9:"user_data";s:0:"";}'),
('1592af6aee3a09dcb6d19845f93718cb', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', 1388999243, 'a:1:{s:9:"user_data";s:0:"";}'),
('205a697faaaffd747b7c3bfb3bcec514', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36 OPR/18.0.12', 1388434295, ''),
('283df55b09be7bdb03954b6b0df24e21', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko', 1389105710, ''),
('29cefc10bd93aa516dd931b9e319afec', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:26.0) Gecko/20100101 Firefox/26.0', 1388596375, 'a:1:{s:9:"user_data";s:0:"";}'),
('3ca19d424c13fb4043e1129d79441b24', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', 1388350769, 'a:1:{s:9:"user_data";s:0:"";}'),
('3fc85f99fb460176b5a23397676a4fc7', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', 1389132091, ''),
('437b0ec8d29fbc6caa422c951a480758', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:26.0) Gecko/20100101 Firefox/26.0', 1389000870, ''),
('4b641f68d43ac5ce1a19f03213a66249', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:26.0) Gecko/20100101 Firefox/26.0', 1388352499, 'a:1:{s:9:"user_data";s:0:"";}'),
('66d22a6742692dd028138c4418e2db58', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', 1389132091, 'a:1:{s:9:"user_data";s:0:"";}'),
('6879ad03c5c487bd19ccf99f7ec2a0b2', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36 OPR/18.0.12', 1389114768, 'a:1:{s:9:"user_data";s:0:"";}'),
('6ef85f77a479d95dfbef7279a50d4877', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', 1388599388, 'a:1:{s:9:"user_data";s:0:"";}'),
('8d656946727116b36bc2619eb40a835c', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', 1388532929, ''),
('8d8534caf5983102f2bcf49ff348a91f', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', 1389028623, 'a:1:{s:9:"user_data";s:0:"";}'),
('9c15f7e4602c9124ccbdaceb19e3c6d9', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:26.0) Gecko/20100101 Firefox/26.0', 1388532615, 'a:1:{s:9:"user_data";s:0:"";}'),
('a639c0017b052b3b07a8bfa16f06325a', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:26.0) Gecko/20100101 Firefox/26.0', 1389034306, ''),
('aabe92e0d36e0fb7bfa251d0baff18e0', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:26.0) Gecko/20100101 Firefox/26.0', 1388351397, 'a:1:{s:9:"user_data";s:0:"";}'),
('bb3e9ba3b0af6beeb331d45dd3e5a34e', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', 1388220706, 'a:1:{s:9:"user_data";s:0:"";}'),
('cfffc016c596e1fd4c8923e4a9f63308', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', 1388424092, ''),
('eac3f879f1acd30c4433dec0f0b0e9d1', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', 1388431374, '');

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE IF NOT EXISTS `logins` (
  `session_id` varchar(40) NOT NULL,
  `name` varchar(50) NOT NULL,
  `loginDate` date DEFAULT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`session_id`, `name`, `loginDate`) VALUES
('03ae3125db79092a59d58a4789828b89', 'sahan91', '2014-01-08'),
('04cf95d2300f32cde20819d31b09ad6f', 'admin', '2014-01-01'),
('0527918a916b11f7fa28922757b94e7c', 'kasun', '2014-01-07'),
('0cf23f1365ee38320c55ce2d6883a018', 'admin', '2014-01-07'),
('13596ca7e608cc448551bb99f4aa2f18', 'admin', '2014-01-07'),
('1571eddc5a5f52bddc5679da21a0aa36', 'sahan91', '2014-01-07'),
('29cefc10bd93aa516dd931b9e319afec', 'sush', '2014-01-01'),
('2e75a89ed53d7b3881614dde64ebf5b7', 'geekmaster', '2014-01-07'),
('2ed24fbad7c6d8f19035e43cb2087079', 'admin', '2014-01-03'),
('36e983fc649d897441602093cd421d71', 'admin', '2014-01-03'),
('3ed374e6d97f56034df8836fcb0a41e5', 'sahan91', '2014-01-01'),
('4036e29bebfc152bd1d03a1220758458', 'sahan91', '2014-01-01'),
('423ebdeecc6d01676be39bbecc854c24', 'sahan91', '2014-01-07'),
('5941f416acf7fe4ef25778a45e239659', 'sahan91', '2014-01-01'),
('5b09885324abbc2630d8ce9c5c57e034', 'sahan91', '2014-01-01'),
('66d22a6742692dd028138c4418e2db58', 'sahan91', '2014-01-07'),
('6ef85f77a479d95dfbef7279a50d4877', 'admin', '2014-01-01'),
('7335a26774772f21237cf8c5af401233', 'sush', '2014-01-01'),
('743ec5a03184965bd789379ff912e904', 'sahan91', '2014-01-01'),
('7545d54232359914e242c726c93e7482', 'sahan91', '2014-01-07'),
('75d3857c2b729ea4427aa128b7f17eac', 'admin', '2014-01-07'),
('81dbead1480011ebedb25e01833cde90', 'sahan91', '2014-01-01'),
('826f4447f4ab04b68d7e59420832d11b', 'sush', '2014-01-01'),
('83318af456cda72b60dfcc0a8276eaed', 'sush', '2014-01-01'),
('86e0c204308f38cb1e7d86b1a7fdc4b1', 'admin', '2014-01-03'),
('8d8534caf5983102f2bcf49ff348a91f', 'sahan91', '2014-01-06'),
('915d38827f3c46c8775ea34925a493ea', 'sush', '2014-01-06'),
('92ad435f403f84cbbe0465cd89145bbf', 'admin', '2014-01-06'),
('955692e6548557dd1e94822668417835', 'admin', '2014-01-07'),
('9bbfdd4d6a60358c6421be95842829c0', 'admin', '2014-01-07'),
('9c15f7e4602c9124ccbdaceb19e3c6d9', 'sahan', '2013-12-31'),
('ad0560f1b08cffcc70c1aee1c9281b86', 'admin', '2014-01-07'),
('adf1854f1ee6acec04ba3bc0de6f87e2', 'sush', '2014-01-01'),
('b6998cf922ffcfb9f6c1e1243e5bf3ed', 'admin', '2013-12-31'),
('ba29dda854b615121c1a794439a1f6ff', 'sahan91', '2014-01-06'),
('bb12efb7d3e1e95493a1638b0108da7a', 'admin', '2013-12-31'),
('bfe444f6ed202f5f68d82d7ada5876d8', 'sahan91', '2014-01-06'),
('c028c83184d0bdf75e5c4b4d1ae51a99', 'sahan91', '2014-01-06'),
('c6e520dab7a01eb73d464803271cb4d5', 'sush', '2014-01-07'),
('c72c0397f4675eaf90a74f1a01a99bda', 'admin', '2014-01-03'),
('ca0d9d7d960277fa87ad81fd3809f647', 'sahan91', '2014-01-07'),
('cd23bcdebef15d881353410368c7726c', 'geekster', '2014-01-07'),
('ce1d16863188eddece543eeb18dc4a89', 'sahan91', '2014-01-01'),
('d1682c1d925f7ac8e0c8969a5ced06fa', 'admin', '2013-12-31'),
('d59b218bd422d9a6941e00525932a6d1', 'sush', '2014-01-01'),
('f07a71f7bc5d077b4ae58668757c8630', 'sahan91', '2013-12-31'),
('f07a71f7bc5d077b4ae58668757c8631', 'sahan91', '2013-12-28'),
('f07a71f7bc5d077b4ae58668757c8671', 'sahan91', '2013-12-30'),
('f1e268e5059faa4f54b037361c5f668f', 'admin', '2014-01-07'),
('f6a7e695e9e31e0ad164b99b51f51578', 'geekster', '2014-01-01'),
('fb86896d3c9852cd7f7db698fe250a84', 'admin', '2014-01-07'),
('fe23674a22e30edfe2c785a5379b0d6d', 'sahan91', '2014-01-07');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `permId` int(11) NOT NULL AUTO_INCREMENT,
  `permKey` varchar(100) NOT NULL,
  PRIMARY KEY (`permId`),
  UNIQUE KEY `permKey` (`permKey`),
  KEY `permKey_2` (`permKey`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permId`, `permKey`) VALUES
(9, 'ANSWER_QUESTION'),
(13, 'DELETE_ANSWER'),
(14, 'DELETE_QUESTION'),
(8, 'DELETE_USERPROFILE'),
(11, 'EDIT_ANSWER'),
(10, 'EDIT_QUESTION'),
(12, 'EDIT_USERPROFILE'),
(15, 'VIEW_ADMINPROFILE'),
(2, 'VIEW_ADMINVIEW'),
(3, 'VIEW_ASKQUESTIONVIEW'),
(1, 'VIEW_REGISTERVIEW'),
(7, 'VOTE_ANSWER_DOWN'),
(6, 'VOTE_ANSWER_UP'),
(5, 'VOTE_QUESTION_DOWN'),
(4, 'VOTE_QUESTION_UP');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `questionId` int(11) NOT NULL AUTO_INCREMENT,
  `questionTitle` varchar(100) NOT NULL,
  `questionDescription` varchar(1000) NOT NULL,
  `askerUserId` int(11) NOT NULL,
  `answerCount` int(5) NOT NULL,
  `askedOn` datetime NOT NULL,
  `upVotes` int(4) NOT NULL,
  `downVotes` int(4) NOT NULL,
  `netVotes` int(4) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `bestAnswerId` int(11) DEFAULT NULL,
  `isClosed` tinyint(1) DEFAULT NULL,
  `closeReason` varchar(100) DEFAULT NULL,
  `closedDate` datetime DEFAULT NULL,
  `closedByUserId` int(11) DEFAULT NULL,
  `isEdited` tinyint(1) DEFAULT NULL,
  `editedByUserId` int(11) DEFAULT NULL,
  `editedDate` datetime DEFAULT NULL,
  `flagCount` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`questionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`questionId`, `questionTitle`, `questionDescription`, `askerUserId`, `answerCount`, `askedOn`, `upVotes`, `downVotes`, `netVotes`, `categoryId`, `bestAnswerId`, `isClosed`, `closeReason`, `closedDate`, `closedByUserId`, `isEdited`, `editedByUserId`, `editedDate`, `flagCount`) VALUES
(35, 'Scroll an HTML file right after it loaded', 'In my app I''m loading a local HTML file to a webview. If some button was clicked, I want to load a local HTML file and scroll it with specific value in y axis. The problem is that the command:<br />\n<br />\n<pre>webview.scrollTo(0, scrollY);</pre><br />\n<br />\nAnyone have any idea how can I achieved this scrolling?', 22, 0, '2013-12-29 07:54:08', 1, 0, 1, 1, NULL, 1, 'This is a duplicate question', '2013-12-29 00:00:00', 22, NULL, NULL, NULL, 1),
(36, 'Echo Out Last_Login Tank Auth Codeigniter', 'I would like to know if it is possible to echo out the users last log in and created information from he users table<br />\n<br />\nBecause I have a user dashboard area where I would like it to show.', 22, 3, '2013-12-29 21:04:55', 1, 1, 0, 4, 51, NULL, NULL, NULL, 0, NULL, NULL, NULL, 0),
(37, 'UPDATE from SELECT using SQL Server', 'How can I update via a select as well in a similar manner? I have a temporary table that has the values, and I want to update another table using those values.', 22, 1, '2013-12-29 07:56:24', 2, 1, 1, 3, NULL, 1, 'Incorrect grammar', '2013-12-29 17:58:04', 2, NULL, NULL, NULL, 0),
(38, 'Run windows phone emulator', 'Please can someone post here how to run the windows phone emulator?<br />\n<br />\nThanks!', 2, 0, '2013-12-29 17:45:21', 8, 5, 3, 3, NULL, 1, 'Possible duplicate', '2013-12-29 17:50:30', 2, NULL, NULL, NULL, 0),
(39, 'What does it mean for a question to be closed?', 'When a question is closed, no additional answers may be posted to it, although the question and existing answers can still be edited (by users with edit privileges) and voted upon, and will continue to count for badges. The asker of a closed question may still accept an answer.<br />\n<br />\nClosed questions can be re-opened by users who have sufficient reputation.', 32, 3, '2013-12-29 21:21:47', 1, 0, 1, 4, 46, NULL, NULL, NULL, NULL, 1, 2, '2014-01-30 00:00:00', 0),
(41, 'jQuery Mobile for mobile and desktop?', 'I''m developing a web app. MySql/PHP back-end, and HTML/jQuery front-end.<br />\n<br />\nI wanted to use jQuery UI framework.<br />\nNow is see that jQuery Mobile is out, and I want to make the app accessible to mobile devices as much as possible.<br />\n<br />\nI Googled, but didn''t find a quality answer.<br />\nCan I make it all to work form the same code if I use jQuery Mobile?<br />\nI''d like it to show mobile widgets if accessed form mobile browser.<br />\nBut use jQuery UI widgets is accessed from desktop browser.<br />\n<br />\nIs that possible just by using jQueyMobile and its markup, or I have to write the front-end for mobile(jQuery Mobile) and desktop(', 2, 0, '2013-12-30 09:06:04', 0, 0, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(42, 'Auto detect mobile browser (via user-agent?)', 'How can I detect if a user is viewing my web site from a mobile web browser so that I can then auto detect and display the appropriate version of my web site?', 2, 1, '2013-12-30 14:17:41', 0, 0, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(43, 'Sencha Touch or jQuery Mobile?', 'I wonder if I were to develop a mobile Web app (now, in two weeks, or in a month), which one should I go for? Which one would you mobile Web developers go for?<br />\n<br />\nIf jQM 1.0 were officially released today, I would most likely embrace it (as long as it actually delivers what it promises). Now that it is in alpha, I wonder whether it is worth to jump into it yet for a commercial grade project? Would Sencha Touch be a better alternative?', 2, 2, '2013-12-30 14:18:30', 0, 0, 0, 4, 49, NULL, NULL, NULL, NULL, 1, 2, '2014-01-01 12:00:09', 0),
(44, 'Mobile Redirect', 'I have a webpage and I was recently asked to create the mobile version for it, now that I''ve done it I was asked to make an automatic redirection so that if the user goes into the webpage through a PDA/iPhone/Smartphone/etc he/she gets automatically directed to the m.website.com but I have no idea how to do this =/ I''ve tried some php''s and javascripts I found using google but nothing so far has helped me. Could you guys?', 2, 1, '2013-12-30 14:19:49', 0, 0, 0, 4, 53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(45, 'What is the best comment in source code you have ever encountered?', 'What is the best comment in source code you have ever encountered? ', 2, 0, '2013-12-30 14:23:05', 0, 0, 0, 4, NULL, 1, '', '2013-12-31 08:06:11', 22, NULL, NULL, NULL, 0),
(46, 'Is jquery-mobile “mobile first”', 'I have read the book "Mobile first" by Luke WROBLEWSKI and many other readings on that topic. I''m a web developer and now I''m really convinced that "mobile first" or "progressive enhancement" is the way to go.<br />\n<br />\nNow I''m looking for a framework to achieve this.', 16, 0, '2013-12-31 08:14:08', 1, 1, 0, 4, NULL, 1, '', '2013-12-31 10:25:32', 22, NULL, NULL, NULL, 0),
(55, 'Codeigniter,create tables and users for MySQL', 'I want to create databases and users with CI programmatically. So far i have these 2 simple MySQL statements.<br />\n<br />\n<pre>CREATE DATABASE `testdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;</pre>', 22, 0, '2014-01-07 19:56:42', 0, 0, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'How to delete arrays in codeigniter', 'Please someone help me to delete arrays in codeigniter', 22, 0, '2014-01-08 00:42:41', 0, 0, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `questions_flags`
--

CREATE TABLE IF NOT EXISTS `questions_flags` (
  `flagId` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`flagId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `questions_flags`
--

INSERT INTO `questions_flags` (`flagId`, `questionId`, `userId`) VALUES
(2, 35, 22),
(3, 53, 22);

-- --------------------------------------------------------

--
-- Table structure for table `questions_tags`
--

CREATE TABLE IF NOT EXISTS `questions_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(11) NOT NULL,
  `tagId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questionId` (`questionId`),
  KEY `tagId` (`tagId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `questions_tags`
--

INSERT INTO `questions_tags` (`id`, `questionId`, `tagId`) VALUES
(10, 35, 1),
(11, 35, 30),
(12, 35, 31),
(13, 36, 28),
(14, 36, 32),
(15, 37, 6),
(16, 37, 33),
(17, 38, 6),
(18, 38, 10),
(19, 38, 9),
(20, 39, 9),
(24, 41, 36),
(25, 41, 3),
(26, 42, 30),
(27, 42, 37),
(28, 42, 6),
(29, 43, 38),
(30, 43, 36),
(31, 43, 3),
(32, 44, 3),
(33, 44, 39),
(34, 44, 40),
(35, 45, 25),
(36, 46, 36),
(37, 46, 3),
(51, 55, 28),
(52, 55, 9),
(53, 56, 28),
(54, 56, 9);

-- --------------------------------------------------------

--
-- Table structure for table `question_votes`
--

CREATE TABLE IF NOT EXISTS `question_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `votedUserId` int(11) NOT NULL,
  `isUpVote` tinyint(1) NOT NULL,
  `questId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `votedUserId` (`votedUserId`),
  KEY `loyalityGainedUserId` (`isUpVote`),
  KEY `questId` (`questId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `question_votes`
--

INSERT INTO `question_votes` (`id`, `votedUserId`, `isUpVote`, `questId`) VALUES
(2, 2, 1, 37),
(3, 16, 1, 38),
(4, 16, 1, 37),
(5, 32, 1, 38),
(6, 32, 1, 35),
(7, 32, 0, 36),
(8, 22, 1, 39),
(9, 22, 1, 38),
(10, 22, 1, 46);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `requestId` int(11) NOT NULL AUTO_INCREMENT,
  `rTypeId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `rDate` datetime NOT NULL,
  PRIMARY KEY (`requestId`),
  UNIQUE KEY `userId_2` (`userId`),
  KEY `rTypeId` (`rTypeId`,`userId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `request_types`
--

CREATE TABLE IF NOT EXISTS `request_types` (
  `rTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `rName` varchar(20) NOT NULL,
  PRIMARY KEY (`rTypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `request_types`
--

INSERT INTO `request_types` (`rTypeId`, `rName`) VALUES
(1, 'Account Deletion'),
(2, 'Tutor Registration');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE IF NOT EXISTS `role_permissions` (
  `roleId` int(11) NOT NULL,
  `permId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`roleId`, `permId`) VALUES
(1, 2),
(1, 8),
(1, 13),
(1, 14),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 11),
(2, 12),
(2, 13),
(2, 13),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 10),
(3, 12),
(3, 14),
(4, 1),
(1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tagId` int(11) NOT NULL AUTO_INCREMENT,
  `tagName` varchar(30) NOT NULL,
  PRIMARY KEY (`tagId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tagId`, `tagName`) VALUES
(1, 'android'),
(2, 'phonegap'),
(3, 'mobile'),
(4, 'file format'),
(5, 'os'),
(6, 'windows phone'),
(7, 'enum'),
(8, 'structs'),
(9, 'help'),
(10, 'emulator'),
(11, 'huawei'),
(12, 'sonic'),
(13, 'sim'),
(14, 'asdsa'),
(15, 'asd'),
(16, 'asdas'),
(17, 'das'),
(18, 'dasd'),
(19, 'google maps'),
(20, 'blacklist'),
(21, 'test'),
(23, 'recursion'),
(24, 'programming'),
(25, 'code'),
(26, '.net'),
(27, 'mysql'),
(28, 'codeigniter'),
(29, 'session'),
(30, 'html'),
(31, 'webview'),
(32, 'php'),
(33, 'sql'),
(34, 'simulator'),
(35, 'dev'),
(36, 'jquery'),
(37, 'browser'),
(38, 'sencha'),
(39, 'redirect'),
(40, 'user agent'),
(41, 'web');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullName` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `profileImagePath` varchar(50) DEFAULT NULL,
  `roleId` int(11) NOT NULL,
  `joinedDate` datetime NOT NULL,
  `website` varchar(50) DEFAULT NULL,
  `linkedInUrl` varchar(50) DEFAULT NULL,
  `sOUrl` varchar(50) DEFAULT NULL,
  `reputation` int(10) DEFAULT '0',
  `loyality` int(10) DEFAULT '0',
  `about` varchar(300) DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `emailHash` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `username` (`username`),
  KEY `roleId` (`roleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `username`, `password`, `fullName`, `email`, `profileImagePath`, `roleId`, `joinedDate`, `website`, `linkedInUrl`, `sOUrl`, `reputation`, `loyality`, `about`, `isActive`, `salt`, `emailHash`) VALUES
(2, 'sush', 'bb2dea3315ff08969101fe16d71a6d9c9eccf77d', 'sush', 'sush@gmail.com', '', 2, '2013-12-05 06:37:00', '', '', '', 3, 3, '', 1, '1e43232cccf624093047fc', ''),
(16, 'admin', 'bb2dea3315ff08969101fe16d71a6d9c9eccf77d', 'Admin', 'sahan.serasinghe@gmail.com', NULL, 1, '2013-12-27 00:00:00', NULL, NULL, NULL, 0, 1, NULL, 1, '1e43232cccf624093047fc', 'e3afed0047b08059d0fada10f400c1e5'),
(22, 'sahan91', 'bb2dea3315ff08969101fe16d71a6d9c9eccf77d', 'Sahan Serasinghe', 'sahan@gmail.com', NULL, 2, '2013-12-28 00:00:00', '', NULL, NULL, 3, 3, 'Hi I''m sahan and this is my awesome about me.', 1, '1e43232cccf624093047fc', ''),
(28, 'sahan', 'bb2dea3315ff08969101fe16d71a6d9c9eccf77d', 'sahan', 'sahans@gmaill.com', NULL, 2, '2013-12-28 18:42:31', '', NULL, NULL, 0, 0, NULL, 1, '1e43232cccf624093047fc', ''),
(30, 'sdrfsdfsdf', 'bb2dea3315ff08969101fe16d71a6d9c9eccf77d', 'sdfsdfsdfsd', 'asdsa@gmail.co', NULL, 3, '2013-12-28 20:38:49', '', NULL, NULL, 0, 0, NULL, 1, '1e43232cccf624093047fc', ''),
(32, 'geekster', 'bb2dea3315ff08969101fe16d71a6d9c9eccf77d', 'Harshitha De Silva', 'harsh@gmail.com', NULL, 2, '2013-12-29 19:07:37', '', 'https://www.google.lk/', 'https://www.google.lk/', 0, -2, NULL, 1, '1e43232cccf624093047fc', ''),
(33, 'kasun', 'dedfc6afa5cc8caee1b9016bf753d0678af6ecb4', 'Kasun Sam', 'kas@gmail.com', NULL, 3, '2014-01-07 04:59:08', '', NULL, NULL, 0, 0, NULL, 1, '0a4db4680f78cb93384ae6', NULL),
(34, 'geekmaster', 'f908563c1352bf21225a20a1703e2835fd3b13ed', 'Jeevantha Perera', 'jibo@gmail.com', NULL, 3, '2014-01-07 20:54:52', '', NULL, NULL, 0, 0, NULL, 1, '801c18f86376d5c44c5d9b', NULL),
(35, 'sad1', '693422042afeb757ff943102bc73f28cfe80803e', '', 'sad@gmail.com', NULL, 3, '2014-01-07 21:06:24', '', NULL, NULL, 0, 0, NULL, 1, 'f462efe21751507dac06ba', NULL),
(36, 'sad2', 'a7ccae594ff759d19c8ae3aa424dde4466a9f447', '', 'sad2@gmail.com', NULL, 3, '2014-01-07 21:08:05', '', NULL, NULL, 0, 0, NULL, 1, '872b84474ed29d25f122b2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `roleId` int(11) NOT NULL AUTO_INCREMENT,
  `roleName` varchar(10) NOT NULL,
  PRIMARY KEY (`roleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`roleId`, `roleName`) VALUES
(1, 'Admin'),
(2, 'Tutor'),
(3, 'Student'),
(4, 'Guest');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`questionId`) REFERENCES `questions` (`questionId`),
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`answeredUserId`) REFERENCES `user` (`userId`);

--
-- Constraints for table `answer_votes`
--
ALTER TABLE `answer_votes`
  ADD CONSTRAINT `answer_votes_ibfk_1` FOREIGN KEY (`votedUserId`) REFERENCES `user` (`userId`),
  ADD CONSTRAINT `answer_votes_ibfk_2` FOREIGN KEY (`ansId`) REFERENCES `answers` (`answerId`);

--
-- Constraints for table `questions_tags`
--
ALTER TABLE `questions_tags`
  ADD CONSTRAINT `questions_tags_ibfk_1` FOREIGN KEY (`tagId`) REFERENCES `tags` (`tagId`);

--
-- Constraints for table `question_votes`
--
ALTER TABLE `question_votes`
  ADD CONSTRAINT `question_votes_ibfk_1` FOREIGN KEY (`votedUserId`) REFERENCES `user` (`userId`),
  ADD CONSTRAINT `question_votes_ibfk_3` FOREIGN KEY (`questId`) REFERENCES `questions` (`questionId`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`rTypeId`) REFERENCES `request_types` (`rTypeId`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `user_role` (`roleId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
