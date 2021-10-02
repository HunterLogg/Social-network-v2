-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2021 at 08:30 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fb`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `comment`, `user_id`, `date_created`) VALUES
(8, 4, 'test', 11, '03:12:52pm 03-07-2021'),
(9, 4, 'test', 11, '03:15:55pm 03-07-2021'),
(10, 4, 'test', 10, '03:16:19pm 03-07-2021'),
(11, 4, 'test test', 10, '03:46:36pm 03-07-2021'),
(12, 4, 'test test test', 10, '03:50:03pm 03-07-2021'),
(13, 7, 'comment test', 10, '07:54:12pm 03-07-2021'),
(18, 9, 'nhạc hay ', 10, '12:31:40pm 06-07-2021'),
(23, 3, 'Hello', 10, '07:09:59pm 09-07-2021'),
(31, 25, 'Nhìn trông thật là đẹp.', 16, '08:38:33pm 10-07-2021');

-- --------------------------------------------------------

--
-- Table structure for table `group_chat`
--

CREATE TABLE `group_chat` (
  `id` int(11) NOT NULL,
  `incoming_msg_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `img_name` text NOT NULL,
  `date_send` text NOT NULL,
  `file_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `group_chat`
--

INSERT INTO `group_chat` (`id`, `incoming_msg_id`, `group_id`, `msg`, `img_name`, `date_send`, `file_name`) VALUES
(2, 10, 1, 'hello mấy bạn', '', '09:58:56am 08-07-2021', ''),
(3, 10, 1, 'mấy bạn có thấy gì không', '', '10:06:02am 08-07-2021', ''),
(4, 11, 1, 'nghe', '', '11:01:55am 08-07-2021', ''),
(5, 10, 1, 'hình đẹp không mọi người', 'hinh-nen-4k-dep-cho-may-tinh-lap-top-dien-thoai-11.jpg', '11:12:09am 08-07-2021', ''),
(6, 10, 1, '', '64485.jpg', '11:14:19am 08-07-2021', ''),
(7, 10, 1, '', '0TbWQCD.jpg', '11:14:44am 08-07-2021', ''),
(10, 10, 1, 'file av4 nè mấy fr', '', '07:44:23pm 08-07-2021', 'av4.docx'),
(11, 11, 1, 'oke nhá', '', '08:13:29pm 08-07-2021', ''),
(12, 2, 1, 'oke nhá', '', '08:13:46pm 08-07-2021', ''),
(13, 10, 1, 'có gì mấy cậu check lại giúp tôi nhé', '', '09:07:23pm 08-07-2021', ''),
(14, 2, 1, 'oke ổn rồi cậu.', '', '09:20:10pm 08-07-2021', ''),
(15, 16, 12, 'Hello mọi người', '', '06:59:15pm 10-07-2021', ''),
(16, 14, 12, 'Hello cậu nhá', '', '06:59:21pm 10-07-2021', ''),
(17, 10, 12, 'Hello ', '', '06:59:25pm 10-07-2021', '');

-- --------------------------------------------------------

--
-- Table structure for table `group_mem`
--

CREATE TABLE `group_mem` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `id_mem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `group_mem`
--

INSERT INTO `group_mem` (`id`, `group_id`, `id_mem`) VALUES
(1, 1, 2),
(2, 1, 11),
(3, 1, 10),
(4, 11, 2),
(5, 11, 10),
(12, 12, 16),
(13, 12, 14),
(14, 12, 10);

-- --------------------------------------------------------

--
-- Table structure for table `group_name`
--

CREATE TABLE `group_name` (
  `id` int(11) NOT NULL,
  `group_name` text NOT NULL,
  `id_host` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `group_name`
--

INSERT INTO `group_name` (`id`, `group_name`, `id_host`) VALUES
(1, 'test', 10),
(11, 'hội chat', 10),
(12, 'Test group chat', 14);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `date`) VALUES
(1, 11, 20, '03:12:14pm 10-07-2021'),
(2, 16, 25, '08:37:13pm 10-07-2021'),
(3, 10, 25, '08:44:13pm 10-07-2021');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `incoming_msg_id` int(11) NOT NULL,
  `outgoing_msg_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `date_send` text NOT NULL,
  `img_name` text NOT NULL,
  `file_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `date_send`, `img_name`, `file_name`) VALUES
(2, 10, 11, 'hello', '05:30:20pm 04-07-2021', '', ''),
(3, 11, 10, 'hello cậu nhá ', '05:30:50pm 04-07-2021', '', ''),
(4, 10, 11, 'cậu khỏe không', '08:26:09pm 04-07-2021', '', ''),
(9, 10, 11, 'dasd', '08:55:55am 05-07-2021', '', ''),
(14, 10, 11, 'hello', '09:41:41am 05-07-2021', '', ''),
(15, 10, 11, 'lô ', '09:43:26am 05-07-2021', '', ''),
(17, 10, 11, 'hello', '04:37:14pm 05-07-2021', '', ''),
(24, 10, 11, 'test ảnh ', '09:10:06pm 06-07-2021', '45204274_673205153080214_8115424857086230528_o.jpg', ''),
(25, 10, 2, 'hello', '09:53:52am 08-07-2021', '', ''),
(30, 10, 11, 'hello', '11:51:01am 08-07-2021', '', ''),
(31, 10, 11, '', '12:02:43pm 08-07-2021', '32879.jpg', ''),
(32, 2, 10, 'hello', '08:59:17pm 08-07-2021', '', ''),
(36, 10, 2, 'gửi bạn tài liệu ', '09:11:46pm 08-07-2021', '', 'php.zip'),
(37, 2, 10, 'ok bạn nhớ', '09:19:24pm 08-07-2021', '', ''),
(38, 10, 2, 'oke bạn', '07:56:04am 09-07-2021', '', ''),
(39, 14, 16, 'Hello', '02:16:50pm 10-07-2021', '', ''),
(40, 16, 14, 'hello', '06:26:39pm 10-07-2021', '', ''),
(41, 14, 10, 'Hello', '06:41:43pm 10-07-2021', '', ''),
(42, 14, 16, 'đẹp không cậu', '06:43:00pm 10-07-2021', '74785.jpg', ''),
(44, 16, 14, 'đẹp cậu.', '06:43:58pm 10-07-2021', '', ''),
(45, 16, 14, 'gửi cậu tài liệu môn học', '07:00:34pm 10-07-2021', '', 'php.zip');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `img_path` text NOT NULL,
  `date` text NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `img_path`, `date`, `type`) VALUES
(1, 10, 'test', 'Hydrangea.png', '09:28:21am 05-07-2021', 1),
(3, 10, 'test ashuthij \r\nkjsdfkg\r\n', 'hoa-tulip-6.jpg', '09:26:22am 04-07-2021', 1),
(4, 11, 'test 2 ', 'img02.jpg', '10:13:16am 03-07-2021', 1),
(7, 11, '123 123 asd a', 'hoa-tulip-6.jpg', '07:45:09pm 03-07-2021', 1),
(8, 2, 'Hoa thật là đẹp!!', 'Hoa-tulip-3.jpg', '09:23:42am 05-07-2021', 1),
(9, 11, 'https://www.youtube.com/watch?v=N1Po4kwS3ME&list=RDw8AYmSdaQZI&index=11', '', '09:58:15am 05-07-2021', 1),
(20, 10, 'test ', 'chess.jpg', '02:53:45pm 06-07-2021', 1),
(25, 14, '', '1059904.jpg', '02:16:43pm 10-07-2021', 1),
(31, 16, 'Hôm nay tôi buồn.', '', '06:19:42pm 10-07-2021', 0),
(32, 16, 'https://www.youtube.com/watch?v=w8AYmSdaQZI&list=RDw8AYmSdaQZI&start_radio=1', '', '09:34:03am 11-07-2021', 1);

-- --------------------------------------------------------

--
-- Table structure for table `relatives`
--

CREATE TABLE `relatives` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `confirm` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `relatives`
--

INSERT INTO `relatives` (`id`, `user_id`, `friend_id`, `confirm`) VALUES
(13, 2, 11, 'add'),
(16, 14, 10, 'accept'),
(28, 10, 15, 'add'),
(38, 10, 11, 'accept'),
(40, 14, 16, 'accept'),
(43, 10, 1, 'add'),
(46, 10, 16, 'accept'),
(50, 16, 2, 'add'),
(51, 14, 11, 'add');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `unique_id` int(200) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `dob` text NOT NULL,
  `gender` varchar(50) NOT NULL,
  `status` varchar(255) NOT NULL,
  `img_user` text NOT NULL,
  `img_cover` text NOT NULL,
  `contact` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `unique_id`, `firstname`, `lastname`, `email`, `password`, `dob`, `gender`, `status`, `img_user`, `img_cover`, `contact`) VALUES
(2, 859810567, 'Phạm', 'Long', 'plong@gmail.com', '09092000Az', '21-12-2000', 'Male', 'Offline', '', '', '0121308245'),
(10, 425788007, 'user', 'Long', 'user@gmail.com', '09092000Az', '20-2-2002', 'Male', 'Active now', 'chess.jpg', '64482.jpg', '0976200449'),
(11, 934019261, 'user', 'test2', 'user1@gmail.com', '09092000Az', '18-9-2004', 'Male', 'Active now', 'Tanya Degurechaff goth loli.png', '', '0909200449'),
(14, 1119873007, 'Phạm', 'Khải', 'provipp5q8@gmail.com', '09092000Az', '21-12-2000', 'Male', 'Offline', '111398c5a1645f3a0675.jpg', '1059904.jpg', '01213130824'),
(15, 1622626437, 'Trần ', 'Hoàng', 'thoang@gmail.com', 'Tranhoang123', '14-7-1998', 'Male', 'Offline', 'Tanya Degurechaff.png', '', '0931453423'),
(16, 65251937, 'Phạm', 'Tuấn Long', 'fv01213130824@gmail.com', '09092000Az', '13-9-1998', 'Male', 'Active now', '2488085597954930882_n.jpg', '44013506090_a57554470c_o.jpg', '0903257823'),
(17, 300101857, 'admin', 'admin', 'admin@gmail.com', 'Admin0', '21-12-2000', 'Male', 'Offline', '6884.jpg', '', '0939815442');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_chat`
--
ALTER TABLE `group_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_mem`
--
ALTER TABLE `group_mem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_name`
--
ALTER TABLE `group_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relatives`
--
ALTER TABLE `relatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `group_chat`
--
ALTER TABLE `group_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `group_mem`
--
ALTER TABLE `group_mem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `group_name`
--
ALTER TABLE `group_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `relatives`
--
ALTER TABLE `relatives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
