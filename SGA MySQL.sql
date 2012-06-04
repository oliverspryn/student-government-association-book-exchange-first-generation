-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2012 at 01:40 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sga`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookcategories`
--

CREATE TABLE IF NOT EXISTS `bookcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key of the table, and ID of the category',
  `name` longtext NOT NULL COMMENT 'The title of the category',
  `course` text NOT NULL COMMENT 'The short ID name of the course',
  `description` longtext NOT NULL COMMENT 'An optional description for the category',
  `total` int(11) NOT NULL COMMENT 'The total number of books in this category',
  `color1` varchar(7) NOT NULL COMMENT 'The color scheme for the category and the color of the very top border for the category <header>',
  `color2` varchar(7) NOT NULL COMMENT 'Color of the border around the <h1> tag in the category <header>',
  `color3` varchar(7) NOT NULL COMMENT 'Color of the background of the <h1> tag in the category <header>',
  `textColor` varchar(7) NOT NULL COMMENT 'Color of the text of the <h1> tag in the category <header>',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `bookcategories`
--

INSERT INTO `bookcategories` (`id`, `name`, `course`, `description`, `total`, `color1`, `color2`, `color3`, `textColor`) VALUES
(1, 'Mathematics', 'MATH', 'You know + - * /. That kind of stuff.', 0, '#E7D2EF', '#F1E4F5', '#F7EFF9', ''),
(2, 'Physics', 'PHYS', 'You know, why stuff works.', 0, '#5F6B79', '', '', ''),
(3, 'Accounting', 'ACCT', '', 0, '#26878E', '', '', ''),
(4, 'Art', 'ART', '', 18, '#9BCA9C', '#C3DFC4', '#DBECDC', '#9BCA9C'),
(5, 'Astronomy', 'ASTR', '', 0, '#899C2D', '', '', ''),
(6, 'Biology', 'BIO', '', 0, '#D9A600', '', '', ''),
(7, 'Business', 'BUSS', '', 0, '#FECE2C', '', '', ''),
(8, 'Chemistry', 'CHEM', '', 0, '#E04749', '', '', ''),
(9, 'Chinese', 'CHIN', '', 0, '#B43F76', '', '', ''),
(10, 'Computer Science', 'COMP', '', 0, '#B086B6', '', '', ''),
(11, 'Economics', 'ECON', '', 0, '#5660C1', '', '', ''),
(12, 'Education', 'EDUC', '', 0, '#007ACB', '', '', ''),
(13, 'Electrical Engineering', 'EENG', '', 0, '#527591', '', '', ''),
(14, 'Engineering', 'ENGR', '', 0, '#5E6C79', '', '', ''),
(15, 'English', 'ENGL', '', 0, '#9198AA', '', '', ''),
(16, 'Entreprenuership', 'ENTR', '', 0, '#8387AA', '', '', ''),
(17, 'Exercise Science', 'ESCI', '', 0, '#978D81', '', '', ''),
(18, 'French', 'FREN', '', 0, '#5DDCD3', '', '', ''),
(19, 'General Science', 'GSCI', '', 0, '#D9EFD8', '', '', ''),
(20, 'Geology', 'GEOL', '', 0, '#C8DD53', '', '', ''),
(21, 'German', 'GERM', '', 0, '#D28DFA', '', '', ''),
(22, 'Global Studies', 'GLOB', '', 0, '#FECE2C', '', '', ''),
(23, 'Greek', 'GREK', '', 0, '#E97802', '', '', ''),
(24, 'Hebrew', 'HEBR', '', 0, '#D1692C', '', '', ''),
(25, 'History', 'HIST', '', 0, '#48D6FD', '', '', ''),
(26, 'Humanities', 'HUMA', '', 0, '#FFAE61', '', '', ''),
(27, 'Japanese', 'JAPN', '', 0, '#FB97C9', '', '', ''),
(28, 'Mechanical Engineering', 'MECH', '', 0, '#5861BE', '', '', ''),
(29, 'Music', 'MUSC', '', 0, '#48D6FD', '', '', ''),
(30, 'Philosophy', 'PHIL', '', 0, '#96CCE4', '', '', ''),
(31, 'Political Science', 'POLY', '', 0, '#CAD3E2', '', '', ''),
(32, 'Psychology', 'PYCH', '', 0, '#C3D1EC', '', '', ''),
(33, 'Religion', 'RELI', '', 0, '#D2C9CA', '', '', ''),
(34, 'Science Faith & Tech', 'SSFT', '', 0, '#D9D9CF', '', '', ''),
(35, 'Sociology', 'SOCI', '', 0, '#3398CB', '', '', ''),
(36, 'Spanish', 'SPAN', '', 0, '#98FECB', '', '', ''),
(37, 'Special Education', 'SPED', '', 0, '#FE6600', '', '', ''),
(38, 'Theater', 'THEA', '', 0, '#986600', '', '', ''),
(39, 'Communications', 'COMM', '', 0, '#775390', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key of the table, and ID of the book',
  `userID` int(11) NOT NULL COMMENT 'The ID of the current book''s owner',
  `upload` int(10) NOT NULL COMMENT 'Time which this book was added',
  `linkID` varchar(32) NOT NULL COMMENT 'A hashed identifier to link a single book, which was used for multiple and stored in the database once for each class, together by a common ID',
  `ISBN` int(10) NOT NULL COMMENT 'The ISBN-10 number, without the dashes',
  `title` longtext NOT NULL COMMENT 'Title of the book',
  `author` varchar(200) NOT NULL COMMENT 'Author(s) of the book',
  `edition` varchar(200) NOT NULL COMMENT 'The edition of the book',
  `course` int(11) NOT NULL COMMENT 'The system ID for the course for which this book is intended',
  `number` int(3) NOT NULL COMMENT 'The course number for which this book is intended',
  `section` tinytext NOT NULL COMMENT 'The class section for which this book is intended',
  `price` decimal(10,2) NOT NULL COMMENT 'Asking price of the book',
  `condition` text NOT NULL COMMENT 'The books condition: excellent, very good, good, fair, or poor',
  `written` tinytext NOT NULL COMMENT 'Whether or not this book was underlined, highlighted, or written in',
  `comments` longtext NOT NULL COMMENT 'Any comments about the book from the seller',
  `imageURL` longtext NOT NULL COMMENT 'The URL of the book''s cover image',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `userID`, `upload`, `linkID`, `ISBN`, `title`, `author`, `edition`, `course`, `number`, `section`, `price`, `condition`, `written`, `comments`, `imageURL`) VALUES
(1, 278, 1234567890, '', 1234567890, 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 7, 201, 'G', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(2, 278, 1234567890, '', 1234567890, 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 7, 102, 'F', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://www.maureenaplin.com/images/frame/ma_lg_book_covers_pandemic.jpg'),
(3, 278, 1234567890, '', 1234567890, 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 7, 101, 'C', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://media.the-leaky-cauldron.org/gallery/books/coverArt/usa/normal_books_covers_usdh_1.jpg'),
(4, 278, 1234567890, '', 1234567890, 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 7, 201, 'I', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://www.bookbyte.com/image.aspx?isbn=9780077366698'),
(5, 278, 1234567890, '', 1234567890, 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 7, 102, 'B', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(6, 278, 1234567890, '', 1234567890, 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 7, 101, 'D', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(7, 278, 1234567890, '', 1234567890, 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 7, 101, 'A', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(8, 278, 1234567890, '', 1234567890, 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 7, 201, 'N', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(9, 278, 1234567890, '', 1234567890, 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 7, 101, 'A', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(10, 278, 1234567890, '', 1234567890, 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 7, 101, 'A', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(11, 278, 1234567890, '', 1234567890, 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 7, 127, 'A', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(12, 278, 1234567890, '', 1234567890, 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 7, 201, 'G', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(13, 278, 1234567890, '', 1234567890, 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 7, 127, 'A', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(14, 278, 1234567890, '', 1234567890, 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 7, 127, 'F', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(15, 278, 1234567890, '', 1234567890, 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 7, 201, 'G', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(16, 278, 1234567890, '', 1234567890, 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 7, 102, 'I', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(17, 278, 1234567890, '', 1234567890, 'Leonardo: He was the Most Average Joe You''d Ever Meet in Your Entire Existance', 'Oliver Spryn the Great', '1st', 7, 102, 'B', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(18, 278, 1234567890, '', 1234567890, 'Leonardo: He was the Most Average Joe You''d Ever Meet in Your Entire Existance', 'Oliver Spryn the Great', '1st', 7, 202, 'A', '149.99', 'Excellent', '0', 'Awesomeness is commin'' to town!', 'http://4.bp.blogspot.com/_S9plTmz_Qps/RqmO97sBLKI/AAAAAAAAACc/IlDBUshxK1w/s400/Book-Cover-Quantum-Mind-sma.jpg'),
(23, 278, 1338777581, '4c40942ca253dcd79ecb8691484cdd58', 741424282, 'the long walk home', 'anatole kurdsjuk', '', 15, 221, 'C', '10.00', 'Very Good', 'No', '<p>very good book</p>', 'http://ecx.images-amazon.com/images/I/41ascOiF3AL.jpg?gdapi');

-- --------------------------------------------------------

--
-- Table structure for table `collaboration`
--

CREATE TABLE IF NOT EXISTS `collaboration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(11) NOT NULL,
  `visible` text NOT NULL,
  `type` text NOT NULL,
  `fromDate` longtext NOT NULL,
  `fromTime` longtext NOT NULL,
  `toDate` longtext NOT NULL,
  `toTime` longtext NOT NULL,
  `title` longtext NOT NULL,
  `content` longtext NOT NULL,
  `assignee` longtext NOT NULL,
  `task` longtext NOT NULL,
  `description` longtext NOT NULL,
  `dueDate` longtext NOT NULL,
  `priority` longtext NOT NULL,
  `completed` longtext NOT NULL,
  `directories` longtext NOT NULL,
  `questions` longtext NOT NULL,
  `responses` longtext NOT NULL,
  `name` longtext NOT NULL,
  `date` longtext NOT NULL,
  `comment` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=140 ;

--
-- Dumping data for table `collaboration`
--

INSERT INTO `collaboration` (`id`, `position`, `visible`, `type`, `fromDate`, `fromTime`, `toDate`, `toTime`, `title`, `content`, `assignee`, `task`, `description`, `dueDate`, `priority`, `completed`, `directories`, `questions`, `responses`, `name`, `date`, `comment`) VALUES
(136, 2, 'on', 'Announcement', '', '', '', '', 'This is serious!!!', '<p><span style="background-color: #ffff00;">Pay attention!!!!!!</span></p>', '', '', '', '', '', '', '', '', '', '', '', ''),
(137, 1, 'on', 'Announcement', '04/17/2012', '00:00', '04/23/2012', '13:00', 'Test', '<p>Check!!!</p>', '', '', '', '', '', '', '', '', '', '', '', ''),
(139, 3, 'on', 'Agenda', '04/17/2012', '12:00', '04/24/2012', '12:00', 'Agenda this Week', '<p>Please look at the agenda below for our to-do list:</p>', 'a:2:{i:0;s:30:"Anyone, Everyone, Oliver Spryn";i:1;s:12:"Oliver Spryn";}', 'a:2:{i:0;s:26:"Complete the Sign-Up Sheet";i:1;s:6:"Task 2";}', 'a:2:{i:0;s:66:"Please place this on Google Docs when you are finished! Thank you!";i:1;s:0:"";}', 'a:2:{i:0;s:0:"";i:1;s:10:"04/18/2012";}', 'a:2:{i:0;s:1:"1";i:1;s:1:"3";}', 'a:2:{i:0;s:4:"true";i:1;s:4:"true";}', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `dailyhits`
--

CREATE TABLE IF NOT EXISTS `dailyhits` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) NOT NULL,
  `hits` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=590 ;

--
-- Dumping data for table `dailyhits`
--

INSERT INTO `dailyhits` (`id`, `date`, `hits`) VALUES
(564, 'Mar-24-2012', 2),
(565, 'Mar-25-2012', 7),
(566, 'Mar-27-2012', 68),
(567, 'Mar-28-2012', 63),
(568, 'Mar-31-2012', 1),
(569, 'Apr-06-2012', 49),
(570, 'Apr-12-2012', 32),
(571, 'Apr-13-2012', 3),
(572, 'Apr-14-2012', 2),
(573, 'Apr-15-2012', 1),
(574, 'Apr-16-2012', 1),
(575, 'Apr-17-2012', 1),
(576, 'Apr-18-2012', 1),
(577, 'Apr-19-2012', 8),
(578, 'Apr-21-2012', 7),
(579, 'Apr-24-2012', 3),
(580, 'Apr-25-2012', 1),
(581, 'May-21-2012', 25),
(582, 'May-22-2012', 2),
(583, 'May-23-2012', 1),
(584, 'May-24-2012', 14),
(585, 'May-26-2012', 5),
(586, 'May-27-2012', 5),
(587, 'May-29-2012', 1),
(588, 'May-30-2012', 1),
(589, 'Jun-02-2012', 2);

-- --------------------------------------------------------

--
-- Table structure for table `external`
--

CREATE TABLE IF NOT EXISTS `external` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `position` int(11) NOT NULL,
  `visible` text NOT NULL,
  `published` int(1) NOT NULL,
  `display` int(1) NOT NULL,
  `content1` longtext NOT NULL,
  `content2` longtext NOT NULL,
  `content3` longtext NOT NULL,
  `content4` longtext NOT NULL,
  `content5` longtext NOT NULL,
  `content6` longtext NOT NULL,
  `content7` longtext NOT NULL,
  `content8` longtext NOT NULL,
  `content9` longtext NOT NULL,
  `content10` longtext NOT NULL,
  `content11` longtext NOT NULL,
  `content12` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `failedlogins`
--

CREATE TABLE IF NOT EXISTS `failedlogins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timeStamp` longtext NOT NULL,
  `IPAddress` longtext NOT NULL,
  `userName` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=364 ;

--
-- Dumping data for table `failedlogins`
--

INSERT INTO `failedlogins` (`id`, `timeStamp`, `IPAddress`, `userName`) VALUES
(359, '1334326350', '127.0.0.1', 'spryno724'),
(360, '1338075839', '127.0.0.1', ''),
(361, '1338653488', '127.0.0.1', 'spryno724'),
(362, '1338666764', '127.0.0.1', 'wot200@gmail.com'),
(363, '1338666777', '127.0.0.1', 'wot200@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `pagehits`
--

CREATE TABLE IF NOT EXISTS `pagehits` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `hits` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=139 ;

--
-- Dumping data for table `pagehits`
--

INSERT INTO `pagehits` (`id`, `page`, `hits`) VALUES
(130, '123', 217),
(131, '124', 15),
(132, '125', 41),
(133, '128', 1),
(134, '127', 3),
(135, '130', 5),
(136, '131', 3),
(137, '132', 7),
(138, '126', 5);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `position` int(11) NOT NULL,
  `parentPage` int(11) NOT NULL,
  `subPosition` int(11) NOT NULL,
  `visible` text NOT NULL,
  `published` int(1) NOT NULL,
  `display` longtext NOT NULL,
  `content1` longtext NOT NULL,
  `name` longtext NOT NULL,
  `date` longtext NOT NULL,
  `comment` longtext NOT NULL,
  `content2` longtext NOT NULL,
  `content3` longtext NOT NULL,
  `content4` longtext NOT NULL,
  `content5` longtext NOT NULL,
  `content6` longtext NOT NULL,
  `content7` longtext NOT NULL,
  `content8` longtext NOT NULL,
  `content9` longtext NOT NULL,
  `content10` longtext NOT NULL,
  `content11` longtext NOT NULL,
  `content12` longtext NOT NULL,
  `content13` longtext NOT NULL,
  `content14` longtext NOT NULL,
  `content15` longtext NOT NULL,
  `content16` longtext NOT NULL,
  `content17` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=133 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `position`, `parentPage`, `subPosition`, `visible`, `published`, `display`, `content1`, `name`, `date`, `comment`, `content2`, `content3`, `content4`, `content5`, `content6`, `content7`, `content8`, `content9`, `content10`, `content11`, `content12`, `content13`, `content14`, `content15`, `content16`, `content17`) VALUES
(123, 1, 0, 0, 'on', 2, '2', 'a:7:{s:5:"title";s:4:"Test";s:7:"content";s:11:"<p>test</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332875470;s:7:"changes";s:1:"1";}', '', '', '', 'a:7:{s:5:"title";s:4:"Test";s:7:"content";s:11:"<p>test</p>";s:8:"comments";s:1:"1";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1334266395;s:7:"changes";s:1:"1";}', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(124, 2, 0, 0, 'on', 2, '1', 'a:7:{s:5:"title";s:10:"More stuff";s:7:"content";s:9:"<p>hi</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332876729;s:7:"changes";s:1:"1";}', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(125, 0, 123, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:25:"We are going to the store";s:7:"content";s:19:"<p>Yes, we are.</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332893714;s:7:"changes";s:1:"1";}', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(126, 0, 123, 2, 'on', 2, '1', 'a:7:{s:5:"title";s:27:"It''s Wal-Mart to be percise";s:7:"content";s:18:"<p>Yes, it is.</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332894467;s:7:"changes";s:1:"1";}', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(127, 0, 123, 3, 'on', 2, '1', 'a:7:{s:5:"title";s:21:"Or was it Sam''s Club?";s:7:"content";s:17:"<p>Don''t know</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332894482;s:7:"changes";s:1:"1";}', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(128, 0, 124, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:7:"Whateve";s:7:"content";s:9:"<p>*r</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332894605;s:7:"changes";s:1:"1";}', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(129, 0, 124, 2, 'on', 2, '1', 'a:7:{s:5:"title";s:3:"Yes";s:7:"content";s:19:"<p>So, whatever</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332894622;s:7:"changes";s:1:"1";}', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(130, 0, 125, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:12:"Which store?";s:7:"content";s:18:"<p>HIH???* HUH</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332948461;s:7:"changes";s:1:"1";}', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(131, 0, 130, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:5:"Title";s:7:"content";s:14:"<p>Content</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332948894;s:7:"changes";s:1:"1";}', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(132, 0, 131, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:10:"More stuff";s:7:"content";s:11:"<p>Nice</p>";s:8:"comments";s:1:"1";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332948906;s:7:"changes";s:1:"1";}', 'a:1:{i:0;s:3:"278";}', 'a:1:{i:0;i:1332949401;}', 'a:1:{i:0;s:4:"Test";}', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE IF NOT EXISTS `privileges` (
  `id` int(1) NOT NULL,
  `deleteFile` int(1) NOT NULL,
  `uploadFile` int(1) NOT NULL,
  `deleteForumComments` int(1) NOT NULL,
  `sendEmail` int(1) NOT NULL,
  `viewStaffPage` int(1) NOT NULL,
  `createStaffPage` int(1) NOT NULL,
  `editStaffPage` int(1) NOT NULL,
  `deleteStaffPage` int(1) NOT NULL,
  `publishStaffPage` int(1) NOT NULL,
  `addStaffComments` int(1) NOT NULL,
  `deleteStaffComments` int(1) NOT NULL,
  `createPage` int(1) NOT NULL,
  `editPage` int(1) NOT NULL,
  `deletePage` int(1) NOT NULL,
  `publishPage` int(1) NOT NULL,
  `createSideBar` int(1) NOT NULL,
  `editSideBar` int(1) NOT NULL,
  `deleteSideBar` int(1) NOT NULL,
  `publishSideBar` int(1) NOT NULL,
  `siteSettings` int(1) NOT NULL,
  `sideBarSettings` int(1) NOT NULL,
  `deleteComments` int(1) NOT NULL,
  `createExternal` int(1) NOT NULL,
  `editExternal` int(1) NOT NULL,
  `deleteExternal` int(1) NOT NULL,
  `publishExternal` int(1) NOT NULL,
  `viewStatistics` int(1) NOT NULL,
  `autoEmail` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Holds the primary key of a question',
  `timeStart` int(10) NOT NULL COMMENT 'The start day of the question''s duration',
  `timeEnd` int(10) NOT NULL COMMENT 'The end day of the question''s duration',
  `title` longtext NOT NULL COMMENT 'A brief title for the question',
  `question` longtext NOT NULL COMMENT 'The text of the question',
  `responseValue` longtext NOT NULL COMMENT 'The total number of responses to a question',
  `responses` longtext NOT NULL COMMENT 'The responses received for each question',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `timeStart`, `timeEnd`, `title`, `question`, `responseValue`, `responses`) VALUES
(1, 1334440800, 1335045600, 'This is our question.', '<p>\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent quis dui a elit interdum molestie vitae a erat. In sit amet turpis a ligula fringilla dapibus. Nulla congue condimentum sem, non scelerisque elit tempor vel. Nullam metus metus, volutpat porttitor auctor in, suscipit ac quam. Vestibulum suscipit molestie malesuada. In hac habitasse platea dictumst. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris auctor egestas quam, ac scelerisque velit mattis a. Nulla ac venenatis quam. Fusce at nisl in magna imperdiet scelerisque. Phasellus interdum fringilla est vel sodales. Mauris dapibus nulla nibh. Vestibulum orci sem, lobortis ut adipiscing vel, tincidunt non ante. Vivamus augue ligula, venenatis rutrum porta quis, rutrum eget urna. Donec tincidunt nibh vel nisi placerat vitae posuere metus posuere. In libero elit, adipiscing ut pretium in, porta quis ipsum.\r\n</p>\r\n<p>\r\nFusce vestibulum rutrum metus a aliquam. Sed vitae augue magna, a placerat enim. Duis in eros nisl, a suscipit lectus. Integer ac tellus quis erat lobortis feugiat eget ac urna. Duis nunc libero, vehicula vitae consequat at, tempor non ipsum. Phasellus leo urna, porta et vestibulum pellentesque, volutpat non massa. Suspendisse vel enim mauris, et gravida erat.\r\n</p>\r\n<p>\r\nAliquam tincidunt lobortis eros, at commodo eros semper ac. Curabitur dignissim, sapien sit amet hendrerit bibendum, odio lorem sollicitudin elit, id pretium arcu orci at eros. Nunc molestie, eros eu euismod dictum, risus leo imperdiet nulla, ut vestibulum libero massa sed diam. Vestibulum sit amet congue ante. Nullam ut tellus libero, a sagittis sapien. Vivamus rhoncus lacinia gravida. Vestibulum vitae est at arcu molestie ultrices vel mattis risus. Donec malesuada vehicula nisi et cursus. Cras nec imperdiet mi. Donec vitae ligula pulvinar velit tempor sodales. Integer massa lacus, sollicitudin quis pretium in, accumsan sit amet quam. Duis dolor felis, ultrices id facilisis eu, congue non erat. Nulla facilisi. Mauris imperdiet orci sit amet nisl ultricies nec pharetra ligula imperdiet. In hac habitasse platea dictumst. Morbi ut libero posuere elit tristique adipiscing a ac magna.\r\n</p>\r\n<p>\r\nPhasellus sapien velit, hendrerit at laoreet vitae, lacinia in dui. Maecenas tincidunt mauris et augue sagittis eget rutrum dolor iaculis. Integer sem velit, dapibus eu faucibus id, pulvinar sit amet velit. In et turpis lectus. In in quam id ipsum vulputate congue. Praesent facilisis metus sed urna mollis in condimentum ligula adipiscing. Curabitur tincidunt tempor mi, id adipiscing dolor porttitor eget. Etiam blandit tempus interdum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec massa leo, hendrerit ut placerat vehicula, gravida ac risus. Aenean ornare congue felis quis hendrerit. Mauris sit amet diam augue. Duis non condimentum quam. Quisque consequat tortor odio. Etiam ornare risus sit amet nibh euismod lacinia.\r\n</p>\r\n<p>\r\nVestibulum in odio odio, nec fermentum diam. Vivamus sed erat ipsum, quis lobortis tortor. Nunc eget feugiat dui. Morbi ornare, arcu ut vulputate mattis, lectus mi ullamcorper turpis, non accumsan velit tortor at neque. Suspendisse quis mi metus. Aliquam congue imperdiet nibh, sit amet venenatis felis ornare sit amet. Nunc imperdiet mattis dui non pellentesque. Quisque sit amet elit quam, et faucibus mi. Donec in varius augue. Fusce vulputate turpis dictum arcu fringilla tristique.\r\n</p>', 'a:5:{s:5:"total";s:2:"67";i:1;s:2:"36";i:2;s:2:"12";i:3;s:1:"9";i:4;s:1:"9";}', 'a:10:{i:0;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:1;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:2;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:3;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:4;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:5;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:6;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:7;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:8;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:9;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}}'),
(2, 1333231200, 1333836000, 'Old Question', 'Old answer', 'a:5:{s:5:"total";s:2:"67";i:1;s:2:"36";i:2;s:2:"12";i:3;s:1:"9";i:4;s:1:"9";}', 'a:10:{i:0;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:1;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:2;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:3;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:4;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:5;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:6;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:7;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:8;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:9;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}}'),
(3, 1335823200, 1336428000, 'New Question', 'Stuff', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `saptcha`
--

CREATE TABLE IF NOT EXISTS `saptcha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` longtext NOT NULL,
  `answer` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `sidebar`
--

CREATE TABLE IF NOT EXISTS `sidebar` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `position` int(11) NOT NULL,
  `visible` text NOT NULL,
  `published` int(1) NOT NULL,
  `display` int(1) NOT NULL,
  `type` text NOT NULL,
  `content1` longtext NOT NULL,
  `content2` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `sidebar`
--

INSERT INTO `sidebar` (`id`, `position`, `visible`, `published`, `display`, `type`, `content1`, `content2`) VALUES
(10, 1, 'on', 2, 1, 'Custom Content', 'a:7:{s:5:"title";s:4:"Nice";s:7:"content";s:17:"<p>Who cares?</p>";s:8:"comments";N;s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332711701;s:7:"changes";s:1:"1";}', ''),
(11, 2, 'on', 2, 1, 'Login', 'a:7:{s:5:"title";s:5:"Login";s:7:"content";s:30:"<p>Hi, please login below:</p>";s:8:"comments";N;s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1333763218;s:7:"changes";s:1:"1";}', '');

-- --------------------------------------------------------

--
-- Table structure for table `siteprofiles`
--

CREATE TABLE IF NOT EXISTS `siteprofiles` (
  `id` int(11) NOT NULL,
  `siteName` varchar(200) NOT NULL,
  `paddingTop` tinyint(4) NOT NULL,
  `paddingLeft` tinyint(4) NOT NULL,
  `paddingRight` tinyint(4) NOT NULL,
  `paddingBottom` tinyint(4) NOT NULL,
  `width` int(3) NOT NULL,
  `height` int(3) NOT NULL,
  `sideBar` text NOT NULL,
  `auto` text NOT NULL,
  `siteFooter` text NOT NULL,
  `author` varchar(200) NOT NULL,
  `language` varchar(15) NOT NULL,
  `copyright` varchar(200) NOT NULL,
  `description` varchar(20000) NOT NULL,
  `meta` text NOT NULL,
  `timeZone` varchar(20) NOT NULL,
  `welcome` text NOT NULL,
  `style` varchar(200) NOT NULL,
  `iconType` text NOT NULL,
  `spellCheckerAPI` varchar(50) NOT NULL,
  `saptcha` text NOT NULL,
  `question` longtext NOT NULL,
  `answer` longtext NOT NULL,
  `failedLogins` int(2) NOT NULL,
  PRIMARY KEY (`siteName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siteprofiles`
--

INSERT INTO `siteprofiles` (`id`, `siteName`, `paddingTop`, `paddingLeft`, `paddingRight`, `paddingBottom`, `width`, `height`, `sideBar`, `auto`, `siteFooter`, `author`, `language`, `copyright`, `description`, `meta`, `timeZone`, `welcome`, `style`, `iconType`, `spellCheckerAPI`, `saptcha`, `question`, `answer`, `failedLogins`) VALUES
(1, 'The Bell News Magazine', 0, 0, 0, 0, 260, 180, 'Right', '', '<p>&copy; 2011 The Bell News Magazine</p>', 'The Bell News Magazine', 'en-US', '© 2011 The Bell News Magazine', 'The collaborative, innovative Bell News Magazine', 'The Bell News Magazine, The PAVCS Bell News Magazine, The Pennsylvania Virtual Charter School Bell News Magazine, Pennsylvania Virtual Charter School Bell News Magazine, Bell News Magazine, Bell News, Bell Magazine, The Bell Magazine, The Bell News', 'America/New_York', 'Ads', 'onlineUniversity.css', 'gif', 'jmyppg6c5k5ajtqcra7u4eql4l864mps48auuqliy3cccqrb6b', 'auto', 'What is the school''s principal''s last name?', 'Perney', 5);

-- --------------------------------------------------------

--
-- Table structure for table `staffpages`
--

CREATE TABLE IF NOT EXISTS `staffpages` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `position` int(11) NOT NULL,
  `published` int(1) NOT NULL,
  `display` int(11) NOT NULL,
  `content1` longtext NOT NULL,
  `name` longtext NOT NULL,
  `date` longtext NOT NULL,
  `comment` longtext NOT NULL,
  `content2` longtext NOT NULL,
  `content3` longtext NOT NULL,
  `content4` longtext NOT NULL,
  `content5` longtext NOT NULL,
  `content6` longtext NOT NULL,
  `content7` longtext NOT NULL,
  `content8` longtext NOT NULL,
  `content9` longtext NOT NULL,
  `content10` longtext NOT NULL,
  `content11` longtext NOT NULL,
  `content12` longtext NOT NULL,
  `content13` longtext NOT NULL,
  `content14` longtext NOT NULL,
  `content15` longtext NOT NULL,
  `content16` longtext NOT NULL,
  `content17` longtext NOT NULL,
  `content18` longtext NOT NULL,
  `content19` longtext NOT NULL,
  `content20` longtext NOT NULL,
  `content21` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `active` varchar(20) NOT NULL,
  `firstName` longtext NOT NULL,
  `lastName` longtext NOT NULL,
  `passWord` longtext NOT NULL,
  `changePassword` text NOT NULL,
  `emailAddress1` longtext NOT NULL,
  `emailAddress2` longtext NOT NULL,
  `emailAddress3` longtext NOT NULL,
  `role` longtext NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `firstName` (`firstName`,`lastName`,`emailAddress1`,`role`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=279 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `active`, `firstName`, `lastName`, `passWord`, `changePassword`, `emailAddress1`, `emailAddress2`, `emailAddress3`, `role`) VALUES
(278, '1332876734', 'Oliver', 'Spryn', '88rLiA128PAAAA==', '', 'wot200@gmail.com', '', '', 'Administrator');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
