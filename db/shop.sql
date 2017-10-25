-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 25, 2017 at 05:01 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) NOT NULL COMMENT 'Help make a custom order for categories',
  `Visibility` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(11, 'Hand Made', 'Hand made items', 1, 0, 0, 0),
(12, 'Computers', 'Computers items', 2, 0, 0, 0),
(13, 'Cell Phones', 'Cell Phones and Accessiores', 3, 0, 0, 0),
(14, 'Clothing', 'Clothing and fashion', 0, 0, 0, 0),
(15, 'Tools', 'Home tools', 4, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(1, 'Good Product. I can make awesome project with it. Fast shipping and the product arrived in good shape and well packaged.', 0, '2017-10-22', 12, 5),
(2, 'The new model (RPi 3) is much faster than its predecessors. Indeed, it’s 10x faster than RPi 1, and double the speed of RPi 2. Now with integrated WiFi and Bluetooth 4.1 which deliver flexibility in siting the Raspberry Pi, and make it more attractive as a set-top computer, a video server, game emulator, and infinitely more. This thing screams!\r\n', 0, '2017-10-20', 13, 5);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`) VALUES
(8, 'Samsung S7', 'Mobile phone in good shape. It\'s good for taken pictures and voor games.', '$400', '2017-10-23', 'Netherlands', '', '2', 0, 0, 13, 12),
(9, 'iPhone 6s', 'Good iPhone. With many apps and games.', '$430', '2017-10-23', 'USA', '', '2', 0, 0, 13, 15),
(10, 'One 1+', 'High perforamnce smart phone with fast processor and large memory.', '$350', '2017-10-23', 'China', '', '1', 0, 0, 13, 20),
(11, 'Nokia', 'smart phone with windows operating system. You can used for al days needs.', '$200', '2017-10-23', 'Europe', '', '2', 0, 0, 13, 3),
(12, 'Arduino uno', 'Computer for making things.', '$5', '2017-10-24', 'Italy', '', '1', 0, 0, 15, 5),
(13, 'Raspberry PI', 'Computer for hobby\'s and awesome DIY projects ', '$40', '2017-10-24', 'UK', '', '1', 0, 0, 12, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0',
  `TrustStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'Seller rank',
  `RegStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'User approval',
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`) VALUES
(1, 'Sami', '601f1889667efaebb33b8c12572835da3f027f78', 'sami@mail.com', 'Samir Dafali', 1, 0, 1, '2017-06-07'),
(2, 'Dylan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'dylan_@mail.com', 'Dylan Van Gisteren', 0, 0, 0, '2017-03-08'),
(3, 'Aria', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'aria_keyzer@mail.com', 'Arend Keyzer', 0, 0, 0, '2017-09-12'),
(5, 'Sherif', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'sherif@mail.com', 'Sherif Ahmed', 0, 0, 0, '2017-10-02'),
(12, 'Rashid', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'rash@mail.com', 'Rashid Latif', 0, 0, 1, '2017-06-14'),
(15, 'Said', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'said_morad@gmail.com', 'Said Morad', 0, 0, 0, '2017-10-02'),
(20, 'Karim', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'karim_@mail.com', 'Karim Naim', 0, 0, 0, '2017-10-02'),
(21, 'Hassan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'hassan@mail.com', '', 0, 0, 0, '2017-10-24'),
(22, 'Nassim', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'nass@mail.com', '', 0, 0, 0, '2017-10-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `comment_user` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
