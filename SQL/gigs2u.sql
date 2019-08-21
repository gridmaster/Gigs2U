-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2019 at 07:16 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gigs2u`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_body` text NOT NULL,
  `posted_by_ID` int(11) NOT NULL,
  `posted_to_ID` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `removed` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_body`, `posted_by_ID`, `posted_to_ID`, `date_added`, `removed`, `post_id`) VALUES
(1, 'Sup my b-otch!', 12, 13, '2019-05-19 14:55:18', 'no', 6),
(2, 'Hey ya bone head.', 11, 12, '2019-07-24 22:05:34', 'no', 4),
(3, 'You\'re a dork.', 11, 12, '2019-07-24 22:06:50', 'no', 2),
(4, 'A little dork, anyway.', 11, 12, '2019-07-24 22:07:39', 'no', 2),
(5, 'this better work...', 11, 12, '2019-07-24 22:08:42', 'no', 2),
(6, 'Final test...', 11, 12, '2019-07-24 22:09:21', 'no', 2),
(7, 'Hey stud muffin!', 13, 11, '2019-07-29 23:42:17', 'no', 43),
(8, 'Nice tostito\'s!', 13, 11, '2019-07-29 23:44:59', 'no', 36),
(9, 'pure 60\'s', 11, 11, '2019-08-13 06:01:13', 'no', 92),
(10, 'I like you down on your knees, blue...', 11, 17, '2019-08-18 04:10:23', 'no', 120),
(11, 'You like cigars?', 11, 17, '2019-08-18 04:12:15', 'no', 120),
(12, 'I just love sucking on a warm cigar... got one lit for me?', 17, 17, '2019-08-18 17:09:10', 'no', 120),
(14, 'Forget the dog!', 11, 13, '2019-08-20 16:15:18', 'no', 8),
(15, 'what up?', 11, 11, '2019-08-20 16:40:00', 'no', 43);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `ID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `friendID` int(11) NOT NULL,
  `unfriended` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`ID`, `memberID`, `friendID`, `unfriended`) VALUES
(1, 11, 13, 'no'),
(3, 11, 17, 'no'),
(4, 17, 11, 'no'),
(5, 17, 16, 'no'),
(6, 13, 11, 'no'),
(8, 16, 17, 'no'),
(10, 22, 11, 'no'),
(11, 11, 22, 'no'),
(12, 16, 11, 'no'),
(13, 11, 16, 'no'),
(14, 17, 22, 'no');

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `user_to_ID` int(11) NOT NULL,
  `user_from_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `user_to_ID`, `user_from_ID`) VALUES
(43, 14, 11);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `memberID`, `post_id`) VALUES
(17, 11, 119),
(19, 11, 117),
(22, 17, 120),
(23, 17, 119),
(24, 17, 117),
(25, 17, 107),
(26, 17, 105),
(27, 14, 10),
(28, 22, 163),
(30, 11, 58),
(31, 17, 138),
(32, 11, 172),
(33, 11, 166),
(39, 11, 105),
(40, 11, 163),
(41, 11, 131),
(42, 11, 138),
(43, 11, 120),
(44, 17, 58),
(45, 11, 177);

-- --------------------------------------------------------

--
-- Table structure for table `member_category`
--

CREATE TABLE `member_category` (
  `id` int(11) NOT NULL,
  `category` varchar(20) NOT NULL,
  `categoryCode` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member_category`
--

INSERT INTO `member_category` (`id`, `category`, `categoryCode`) VALUES
(1, 'Individual', 1),
(2, 'Organization', 2);

-- --------------------------------------------------------

--
-- Table structure for table `member_type`
--

CREATE TABLE `member_type` (
  `id` int(11) NOT NULL,
  `memberType` varchar(20) NOT NULL,
  `memberCategory` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member_type`
--

INSERT INTO `member_type` (`id`, `memberType`, `memberCategory`) VALUES
(1, 'Fan', 1),
(2, 'Musician', 1),
(3, 'Band', 2),
(4, 'Venue', 2);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_to_ID` int(11) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `user_from_ID` int(11) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_to`, `user_to_ID`, `user_from`, `user_from_ID`, `body`, `date`, `opened`, `viewed`, `deleted`) VALUES
(1, 'mickey_mouse', 12, 'jim_ballard', 11, 'Hey Mickey!', '2019-05-26 19:47:25', 'yes', 'yes', 'no'),
(6, 'mickey_mouse', 12, 'jim_ballard', 11, 'Sup mouse?', '2019-05-27 18:26:28', 'yes', 'yes', 'no'),
(8, 'jim_ballard', 11, 'mickey_mouse', 12, 'Hi, this is Mickey!', '2019-05-27 18:27:29', 'yes', 'yes', 'no'),
(9, 'mickey_mouse', 12, 'jim_ballard', 11, 'Where\'s Minnie?', '2019-05-27 19:55:21', 'yes', 'yes', 'no'),
(11, 'mickey_mouse', 12, 'jim_ballard', 11, 'What???', '2019-05-27 19:58:50', 'yes', 'yes', 'no'),
(15, 'jim_ballard', 11, 'mickey_mouse', 12, 'What\'s the matter with Minnie?', '2019-05-27 20:02:00', 'yes', 'yes', 'no'),
(16, 'mickey_mouse', 12, 'jim_ballard', 11, 'Nothin\', I just heard she was gettin\' a little Goofy on the side...', '2019-05-27 20:03:31', 'yes', 'yes', 'no'),
(19, 'minnie_mouse', 13, 'jim_ballard', 11, 'Sup babe?', '2019-06-01 03:38:04', 'yes', 'yes', 'no'),
(22, 'mickey_mouse', 12, 'jim_ballard', 11, 'test', '2019-06-01 12:36:14', 'yes', 'yes', 'no'),
(29, 'mickey_mouse', 12, 'jim_ballard', 11, 'Don\'t repeat!', '2019-06-01 12:46:27', 'yes', 'yes', 'no'),
(30, 'goofy_dog', 14, 'jim_ballard', 11, 'What\'s up Goof?', '2019-06-01 14:43:19', 'yes', 'yes', 'no'),
(31, 'minnie_mouse', 13, 'jim_ballard', 11, 'Where\'s Mickey?', '2019-06-01 15:42:02', 'yes', 'yes', 'no'),
(32, 'minnie_mouse', 13, 'jim_ballard', 11, 'I hear he\'s mad at Goofy!', '2019-06-01 15:42:24', 'yes', 'yes', 'no'),
(33, 'jim_ballard', 11, 'bart_simpson', 15, 'Sup dude?', '2019-06-08 20:32:36', 'yes', 'yes', 'no'),
(34, 'jim_ballard', 11, 'bart_simpson', 15, 'Sup dude?', '2019-06-08 20:32:50', 'yes', 'yes', 'no'),
(35, 'goofy_dog', 14, 'jim_ballard', 11, 'How\'s Minnie?', '2019-06-08 20:38:06', 'yes', 'yes', 'no'),
(36, 'jim_ballard', 11, 'homer_simpson', 16, 'Where\'s Marge?', '2019-06-08 20:39:21', 'yes', 'yes', 'no'),
(37, 'jim_ballard', 11, 'marge_simpson', 17, 'Hey baby...', '2019-06-08 20:40:37', 'yes', 'yes', 'no'),
(38, 'marge_simpson', 17, 'jim_ballard', 11, 'Hey Your Blueness!', '2019-06-08 20:41:17', 'yes', 'yes', 'no'),
(39, 'homer_simpson', 16, 'jim_ballard', 11, 'On her knees bud!', '2019-06-08 20:41:31', 'yes', 'yes', 'no'),
(40, 'jim_ballard', 11, 'homer_simpson', 16, 'Did you say Bud?', '2019-06-08 20:41:54', 'yes', 'yes', 'no'),
(41, 'jim_ballard', 11, 'lisa_simpson', 18, 'Hey big boy, they call me Smoken Lisa at school... ', '2019-06-08 20:43:36', 'yes', 'yes', 'no'),
(42, 'jim_ballard', 11, 'minnie_mouse', 13, 'What\'s up, Mr. Giant Package?', '2019-07-29 03:34:46', 'yes', 'yes', 'no'),
(43, 'jim_ballard', 11, 'marge_simpson', 17, 'What\'s up raging one???', '2019-08-12 22:56:04', 'yes', 'yes', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_to_ID` int(11) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `user_from_ID` int(11) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_to`, `user_to_ID`, `user_from`, `user_from_ID`, `message`, `link`, `datetime`, `opened`, `viewed`) VALUES
(1, 'Mickey_Mouse', 12, 'jim_ballard', 11, 'Jim Ballard liked your post', 'post.php?id=41', '2019-07-28 21:05:24', 'no', 'no'),
(2, 'minnie_mouse', 13, 'jim_ballard', 11, 'Jim Ballard liked your post', 'post.php?id=43', '2019-07-28 22:19:43', 'yes', 'yes'),
(3, 'minnie_mouse', 13, 'jim_ballard', 11, 'Jim Ballard liked your post', 'post.php?id=8', '2019-07-29 12:44:41', 'yes', 'yes'),
(4, 'minnie_mouse', 13, 'jim_ballard', 11, 'Jim Ballard commented on your profile post', 'post.php?id=43', '2019-07-29 23:42:17', 'yes', 'yes'),
(5, 'jim_ballard', 11, 'minnie_mouse', 13, 'Minnie Mouse liked your post', 'post.php?id=36', '2019-07-29 23:44:40', 'yes', 'yes'),
(6, 'jim_ballard', 11, 'minnie_mouse', 13, 'Minnie Mouse commented on your post', 'post.php?id=36', '2019-07-29 23:44:59', 'yes', 'yes'),
(7, 'jim_ballard', 11, 'minnie_mouse', 13, 'Minnie Mouse liked your post', 'post.php?id=43', '2019-07-30 23:03:39', 'yes', 'yes'),
(8, 'minnie_mouse', 13, 'jim_ballard', 11, 'Jim Ballard liked your post', 'post.php?id=56', '2019-08-11 23:25:22', 'yes', 'yes'),
(9, 'minnie_mouse', 13, 'jim_ballard', 11, 'Jim Ballard liked your post', 'post.php?id=57', '2019-08-11 23:30:12', 'yes', 'yes'),
(10, 'marge_simpson', 17, 'jim_ballard', 11, 'Jim Ballard liked your post', 'post.php?id=58', '2019-08-12 17:32:24', 'yes', 'yes'),
(11, 'marge_simpson', 17, 'groovieandthedingdongs', 22, 'Groovie And The Dingdongs  liked your post', 'post.php?id=59', '2019-08-12 22:53:50', 'yes', 'yes'),
(12, '', 17, '', 11, 'Jim Ballard liked your post', 'post.php?id=120', '2019-08-21 12:47:50', 'yes', 'yes'),
(13, '', 22, '', 11, 'Jim Ballard liked your post', 'post.php?id=131', '2019-08-21 12:52:06', 'no', 'no'),
(14, '', 17, '', 11, 'Jim Ballard liked your post', 'post.php?id=120', '2019-08-21 12:52:37', 'yes', 'yes'),
(15, '', 11, '', 17, 'Marge Simpson liked your post', 'post.php?id=58', '2019-08-21 13:07:37', 'yes', 'yes'),
(16, '', 17, '', 11, 'Jim Ballard liked your post', 'post.php?id=178', '2019-08-21 18:15:50', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL,
  `added_by_ID` int(11) NOT NULL,
  `user_to_ID` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  `likes` int(11) NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `added_by_ID`, `user_to_ID`, `date_added`, `user_closed`, `deleted`, `likes`, `image`) VALUES
(2, 'My first post!', 12, 0, '2019-05-19 14:49:42', 'no', 'no', 0, ''),
(4, 'Hey, my second post!', 12, 0, '2019-05-19 14:52:30', 'no', 'no', 0, ''),
(6, 'Hey Mickey!', 13, 0, '2019-05-19 14:53:39', 'no', 'no', 0, ''),
(8, 'Hi Goofy!', 13, 0, '2019-05-19 14:58:58', 'no', 'no', 0, ''),
(10, 'Hi Minnie!', 14, 0, '2019-05-19 14:59:30', 'no', 'no', 1, ''),
(12, 'All the leaves are brown...', 11, 0, '2019-05-20 11:32:25', 'no', 'no', 0, ''),
(14, 'Minnie, are you out there!', 11, 14, '2019-05-20 11:34:25', 'no', 'no', 0, ''),
(16, 'I thought I had posted stuff...', 11, 0, '2019-05-22 20:46:10', 'no', 'no', 0, ''),
(18, 'Something to say...', 11, 0, '2019-06-01 12:53:20', 'no', 'no', 0, ''),
(20, 'This is a new post 20190722', 11, 0, '2019-07-22 23:52:12', 'no', 'no', 0, ''),
(37, 'What up, mouse!', 11, 12, '2019-07-24 21:47:18', 'no', 'no', 0, ''),
(38, 'testing the post', 11, 12, '2019-07-24 22:09:40', 'no', 'no', 0, ''),
(39, 'Hey Mickey', 11, 12, '2019-07-28 20:51:50', 'no', 'no', 0, ''),
(40, 'this needs to be saved to the db', 11, 12, '2019-07-28 20:56:39', 'no', 'no', 0, ''),
(41, 'WTF!!!', 11, 12, '2019-07-28 21:05:24', 'no', 'no', 0, ''),
(42, 'Hey manly man!', 11, 0, '2019-07-28 21:50:57', 'no', 'no', 0, ''),
(43, 'Sup girl.', 11, 13, '2019-07-28 22:19:43', 'no', 'no', 0, ''),
(45, 'Arf! Arf!', 11, 0, '2019-08-09 22:11:38', 'no', 'no', 0, ''),
(53, 'Does this work?', 11, 0, '2019-08-11 16:49:18', 'no', 'no', 0, ''),
(58, 'Hey big blue!', 11, 17, '2019-08-12 17:32:24', 'no', 'no', 2, ''),
(59, 'We got a gig tonight. Come one, come all!!!', 22, 17, '2019-08-12 22:53:50', 'no', 'no', 0, ''),
(63, '<br><iframe width=\'420\' height=\'315\' src=\'https://www.youtube.com/embed/9k_aj6b2xsA\n\'></iframe><br>', 11, 0, '2019-08-13 01:51:05', 'no', 'yes', 0, ''),
(64, 'I can\'t wait to see the superbowl!', 11, 0, '2019-08-13 05:05:46', 'no', 'no', 0, ''),
(65, 'Are you going to watch the superbowl?', 11, 0, '2019-08-13 05:06:05', 'no', 'no', 0, ''),
(95, 'doughnuts', 11, 0, '2019-08-13 06:03:54', 'no', 'no', 0, ''),
(96, '', 11, 0, '2019-08-13 06:08:27', 'no', 'no', 0, 'assets/images/posts/5d5245cbc9769tumblr_ng3b5laB6z1u4zwnao1_1280.jpg'),
(97, '<br><iframe width=\'420\' height=\'315\' src=\'https://www.youtube.com/embed/O1R2Vnkn_Xg\'></iframe><br>', 11, 0, '2019-08-13 06:12:37', 'no', 'no', 0, ''),
(98, 'We got stuff for sale!!!', 25, 0, '2019-08-13 14:48:23', 'no', 'no', 0, ''),
(103, 'What up!', 11, 0, '2019-08-16 16:45:28', 'no', 'no', 0, ''),
(104, 'this is a test<br /> <br /> this is another test', 11, 0, '2019-08-16 18:28:21', 'no', 'no', 0, ''),
(105, 'what...', 11, 0, '2019-08-16 18:33:02', 'no', 'no', 2, ''),
(107, 'again', 11, 0, '2019-08-16 18:37:29', 'no', 'no', 1, ''),
(113, 'another test...', 11, 0, '2019-08-16 18:45:39', 'no', 'no', 0, ''),
(117, '98797', 11, 0, '2019-08-16 18:47:08', 'no', 'no', 2, ''),
(119, 'humpty dumpty', 11, 0, '2019-08-16 20:38:54', 'no', 'no', 2, ''),
(120, 'I need a man tonight. Homer is bowling...', 17, 11, '2019-08-17 22:33:56', 'no', 'no', 2, ''),
(121, 'My first post!!!', 22, 0, '2019-08-18 23:05:37', 'no', 'no', 0, ''),
(131, 'We was fab!', 22, 0, '2019-08-18 23:35:55', 'no', 'no', 1, ''),
(138, 'HA!', 11, 0, '2019-08-19 01:34:40', 'no', 'no', 2, ''),
(141, 'arf! FR!', 22, 0, '2019-08-19 12:07:40', 'no', 'no', 0, ''),
(156, 'woof', 11, 0, '2019-08-19 18:25:10', 'no', 'yes', 0, ''),
(162, 'Arf!', 11, 0, '2019-08-19 19:33:24', 'no', 'yes', 0, ''),
(163, 'Sup dude? I hear you get all the chicks...', 22, 11, '2019-08-19 21:43:22', 'no', 'no', 2, ''),
(166, 'Groovy posting to Jim', 22, 11, '2019-08-19 22:01:39', 'no', 'no', 1, ''),
(167, 'Jim posting on Groovy\'s page', 0, 0, '2019-08-20 21:34:52', 'no', 'no', 0, ''),
(169, 'what up?', 0, 0, '2019-08-20 21:50:48', 'no', 'no', 0, ''),
(170, 'test 1', 0, 0, '2019-08-20 21:52:14', 'no', 'no', 0, ''),
(171, 'Jim to Groovie number 1', 0, 0, '2019-08-20 21:55:19', 'no', 'no', 0, ''),
(172, 'this will work...', 11, 0, '2019-08-20 21:55:50', 'no', 'no', 1, ''),
(174, 'ouch...', 0, 0, '2019-08-20 23:11:29', 'no', 'no', 0, ''),
(175, 'qqqqqqqqqqq', 0, 0, '2019-08-20 23:13:38', 'no', 'no', 0, ''),
(176, '???????????????', 11, 22, '2019-08-20 23:21:20', 'no', 'no', 0, ''),
(177, 'My baby!', 11, 0, '2019-08-21 18:14:55', 'no', 'no', 1, 'assets/images/posts/5d5d7c0fd6211LisaInHat.jpg'),
(178, 'Jim to Marge\'s wall.', 11, 17, '2019-08-21 18:15:50', 'no', 'no', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `trends`
--

CREATE TABLE `trends` (
  `title` varchar(50) NOT NULL,
  `hits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trends`
--

INSERT INTO `trends` (`title`, `hits`) VALUES
('Cant', 1),
('Wait', 1),
('Superbowl', 2),
('Watch', 1),
('Doughnuts', 1),
('Stuff', 1),
('Sale', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `memberID` int(11) NOT NULL,
  `memberType` varchar(20) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `entityName` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signup_date` date NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `num_posts` int(11) NOT NULL,
  `num_likes` int(11) NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `friend_array` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`memberID`, `memberType`, `first_name`, `last_name`, `entityName`, `username`, `email`, `password`, `signup_date`, `profile_pic`, `num_posts`, `num_likes`, `user_closed`, `friend_array`) VALUES
(11, 'Musician', 'Jim', 'Ballard', '', 'jim_ballard', 'Antlerhorse@gmail.com', '4a508fecff1e1946d3aab22a45fdb416', '2019-05-19', 'assets/images/profile_pics/jim_ballard85bac92b787b4a058424af2abace2b33n.jpeg', 35, 22, 'no', ',mickey_mouse,goofy_dog,minnie_mouse,groovieandthedingdongs,marge_simpson,larry_mcduff,'),
(12, 'Fan', 'Mickey', 'Mouse', '', 'mickey_mouse', 'Mickey@gmail.com', '4a508fecff1e1946d3aab22a45fdb416', '2019-05-19', 'assets/images/profile_pics/Mickey.jpg\r\n\r\n', 2, 2, 'no', ',jim_ballard,minnie_mouse,'),
(13, 'Fan', 'Minnie', 'Mouse', '', 'minnie_mouse', 'Minnie@gmail.com', '4a508fecff1e1946d3aab22a45fdb416', '2019-05-19', 'assets/images/profile_pics/minnie.jpg', 2, 2, 'no', ',mickey_mouse,goofy_dog,jim_ballard,groovieandthedingdongs,'),
(14, 'Fan', 'Goofy', 'Dog', '', 'goofy_dog', 'Goofy@gmail.com', '4a508fecff1e1946d3aab22a45fdb416', '2019-05-19', 'assets/images/profile_pics/goofy.png', 1, 3, 'no', ',minnie_mouse,jim_ballard,jim_ballard,'),
(15, 'Fan', 'Bart', 'Simpson', '', 'bart_simpson', 'Bart@gmail.com', '4a508fecff1e1946d3aab22a45fdb416', '2019-06-08', 'assets/images/profile_pics/Bart.png', 0, 0, 'no', ','),
(16, 'Fan', 'Homer', 'Simpson', '', 'homer_simpson', 'Homer@gmail.com', '4a508fecff1e1946d3aab22a45fdb416', '2019-06-08', 'assets/images/profile_pics/Homer.jpg', 0, 0, 'no', ','),
(17, 'Fan', 'Marge', 'Simpson', '', 'marge_simpson', 'Marge@gmail.com', '4a508fecff1e1946d3aab22a45fdb416', '2019-06-08', 'assets/images/profile_pics/sexy-marge-the-simpsons-10019762-287-385.jpg', 1, 4, 'no', ',groovieandthedingdongs,groovieandthedingdongs,jim_ballard,'),
(18, 'Fan', 'Lisa', 'Simpson', '', 'lisa_simpson', 'Lisa@gmail.com', '4a508fecff1e1946d3aab22a45fdb416', '2019-06-08', 'assets/images/profile_pics/lisa_simpson_01_the_simpsons_51462.jpg', 0, 0, 'no', ','),
(22, 'Band', 'Groovie And The Dingdongs', '', 'Groovie And The Dingdongs', 'groovieandthedingdongs', 'Groovy@mail.com', '4a508fecff1e1946d3aab22a45fdb416', '2019-07-23', 'assets/images/profile_pics/relaxing before the gig.jpg\r\n', 35, 4, 'no', ',jim_ballard,minnie_mouse,marge_simpson,marge_simpson,'),
(23, 'Musician', 'Bob', 'Guitar', 'Bobs Guitar Band', 'bob_guitar', 'Bobg@gmail.com', '4a508fecff1e1946d3aab22a45fdb416', '2019-08-02', 'assets/images/profile_pics/defaults/head_deep_blue.png', 0, 0, 'no', ','),
(24, 'Band', 'Biff', 'Johnston', 'The Gods Of Alfalfa', 'biff_johnston', 'Biffj@gmail.com', '4a508fecff1e1946d3aab22a45fdb416', '2019-08-02', 'assets/images/profile_pics/defaults/head_deep_blue.png', 0, 0, 'no', ','),
(25, 'Vendor', 'Larry', 'Mcduff', 'Seller of fine Instruments', 'larry_mcduff', 'V1@gmail.com', '4a508fecff1e1946d3aab22a45fdb416', '2019-08-13', 'assets/images/profile_pics/larry_mcduff666906a3418e1d704ab2ead3e7e8204an.jpeg', 1, 0, 'no', ',jim_ballard,'),
(26, 'Band', 'Dirk', 'Mcquiggly', 'The Ruttles', 'dirk_mcquiggly', 'Ruttles@gmail.com', '4a508fecff1e1946d3aab22a45fdb416', '2019-08-16', 'assets/images/profile_pics/defaults/head_deep_blue.png', 0, 0, 'no', ',');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_category`
--
ALTER TABLE `member_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_type`
--
ALTER TABLE `member_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`memberID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `member_category`
--
ALTER TABLE `member_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `member_type`
--
ALTER TABLE `member_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `memberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
