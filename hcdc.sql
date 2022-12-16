-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2022 at 12:41 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hcdc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `datetime` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `headline` varchar(30) NOT NULL,
  `bio` text NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `addedby` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `datetime`, `username`, `password`, `name`, `headline`, `bio`, `image`, `addedby`) VALUES
(1, '27-November-2022 12: 37', 'HCDC', '0342dfc28ab72c61b474ffd54b874b4a', 'Admin_Jhon', 'HCDC BSIT student', '', 'profile.png', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `catcourse`
--

CREATE TABLE `catcourse` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `admin` varchar(30) NOT NULL,
  `datetime` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `admin` varchar(30) NOT NULL,
  `datetime` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `admin`, `datetime`) VALUES
(1, 'Event', 'Admin', '27-November-2022 20: 51');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(10) NOT NULL,
  `datetime` varchar(30) NOT NULL,
  `title` text NOT NULL,
  `category` varchar(30) NOT NULL,
  `publisher` varchar(30) NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `datetime`, `title`, `category`, `publisher`, `image`, `content`) VALUES
(1, '30-November-2022 10: 49', 'Colleges of Engineering and technology', 'course', 'Admin', 'bscei.png\r\n', '<p>The College of Engineering and Technology aims to develop and produce professional engineers and technologist imbued with desirable work ethics</p>');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) NOT NULL,
  `datetime` varchar(30) NOT NULL,
  `title` text NOT NULL,
  `subtitle` varchar(300) NOT NULL,
  `category` varchar(30) NOT NULL,
  `publisher` varchar(30) NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `datetime`, `title`, `subtitle`, `category`, `publisher`, `image`, `content`) VALUES
(1, '27-November-2022 20: 49', 'HCDC celebrates RED WEDNESDAY.', '', 'Event', 'Admin', 'Red.jpg', '					    	 					    	 					    	 					    	 					    	 					    	 					<p>Virtue of the Month of November 2022: JUSTICE Learn to do good; seek justice; rescue the oppressed; defend the orphan; plead for the widow. (Isaiah 1:17)</p>					    					    					    					    					    					    					    '),
(18, '13-December-2022 09: 59', 'Mr and Ms CET day', '', 'Event', 'HCDC', 'cet_ms_and_mr.png', '					    	 					    	 					    	 					    	 					    	 					    	 Holy Cross of Davao City celebrated Mr and Ms. CET day					    					    					    					    					    					    '),
(19, '13-December-2022 10: 11', 'CET DAY', '', 'Event', 'HCDC', 'cet_day.png', 'Holy Cross of Davao City celebrated CET DAY 					    ');

-- --------------------------------------------------------

--
-- Table structure for table `revcourse`
--

CREATE TABLE `revcourse` (
  `id` int(10) NOT NULL,
  `datetime` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `reviews` text NOT NULL,
  `approvedby` varchar(30) NOT NULL,
  `status` varchar(3) NOT NULL,
  `postid` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(10) NOT NULL,
  `datetime` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `reviews` text NOT NULL,
  `approvedby` varchar(30) NOT NULL,
  `status` varchar(3) NOT NULL,
  `postid` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catcourse`
--
ALTER TABLE `catcourse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `revcourse`
--
ALTER TABLE `revcourse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postid` (`postid`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postid` (`postid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `catcourse`
--
ALTER TABLE `catcourse`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `revcourse`
--
ALTER TABLE `revcourse`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
