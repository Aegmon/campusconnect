-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2023 at 11:23 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campusconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(1, 'administrator', '$2y$10$u9bjBpZ/RZmmDN4oLlb.fuTcs2I/TAeIe/s69E0/wByD1wdx3.Al6');

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

CREATE TABLE `consultation` (
  `consult_id` int(11) NOT NULL,
  `user_id_host` int(11) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`consult_id`, `user_id_host`, `start_time`, `end_time`, `status`, `link`) VALUES
(1, 48, '2023-10-11 14:15:00', '0000-00-00 00:00:00', 'approved', ''),
(4, 51, '2023-10-11 13:15:00', '0000-00-00 00:00:00', 'pending', 'https://meet.google.com/vzs-gysy-ggc'),
(5, 52, '2023-10-10 13:05:00', '0000-00-00 00:00:00', 'pending', ''),
(6, 51, '2027-10-30 13:15:00', '0000-00-00 00:00:00', 'pending', '');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_info`
--

CREATE TABLE `faculty_info` (
  `faculty_id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_info`
--

INSERT INTO `faculty_info` (`faculty_id`, `userID`, `first_name`, `last_name`, `birthday`, `gender`, `address`, `image`, `email`) VALUES
(3, 16, 'juan', 'Delacruz', '1995-06-08', 'male', 'tarlac City', '../img/WallpaperDog-20533605.png', NULL),
(4, 17, 'Maria', 'Cruz', '1990-10-05', 'female', 'Burot', '../img/gender-distribution-of-s.jpeg', NULL),
(5, 29, 'faculty', 'faculty', '1995-06-15', 'female', 'Tarlac', '../img/kindpng_4750705.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guidancecounselor`
--

CREATE TABLE `guidancecounselor` (
  `g_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `userID` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guidancecounselor`
--

INSERT INTO `guidancecounselor` (`g_id`, `fname`, `lname`, `birthdate`, `userID`, `image`) VALUES
(1, 'dsa', 'dasdas', '2023-10-12', 36, '../img/169525407_675790189781456_4559649813782853301_n.jpg'),
(2, 'dsa', 'dsadas', '2023-10-06', 37, '../img/fortune-life-logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message_text` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `receiver_id`, `message_text`, `timestamp`) VALUES
(2, 1, 2, 'dsa', '2023-10-25 00:16:05'),
(3, 1, 2, 'dsadas', '2023-10-25 00:17:41'),
(4, 1, 2, 'dsa', '2023-10-25 00:21:48'),
(5, 1, 0, 'dasdas', '2023-10-25 00:22:49'),
(6, 1, 0, 'dsadas', '2023-10-25 00:23:42'),
(7, 1, 16, '', '2023-10-25 00:29:42'),
(8, 1, 16, 'dsadas', '2023-10-25 01:06:43'),
(9, 1, 16, 'dsadas', '2023-10-25 01:40:25'),
(10, 1, 17, 'test', '2023-10-25 01:40:33'),
(11, 1, 17, 'test', '2023-10-25 01:40:46'),
(12, 1, 0, '', '2023-10-30 13:56:11'),
(13, 1, 0, ';l', '2023-10-30 15:11:40'),
(14, 1, 17, '980', '2023-10-30 15:11:46');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_content` text NOT NULL,
  `post_from` enum('admin','user') NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `post_title`, `post_content`, `post_from`, `post_date`) VALUES
(4, 1, 'das', 'dsa', 'admin', '2023-10-24 21:00:38'),
(5, 1, 'Mathematics', 'can you help me solve 2x4?\r\n', 'admin', '2023-10-24 22:28:43'),
(6, 16, 'test faculty', '21321', 'user', '2023-10-25 01:08:20'),
(7, 18, '123', '321321', 'user', '2023-10-25 01:33:50'),
(8, 1, 'Announcement', 'Announcement test', 'admin', '2023-10-25 18:28:36'),
(9, 17, 'Quiz on web', 'test post', 'user', '2023-10-25 18:33:43'),
(10, 48, 'dsa', 'dsadas', 'user', '2023-10-30 11:48:56'),
(11, 51, 'test date', 'test date', 'user', '2023-10-30 14:50:28');

-- --------------------------------------------------------

--
-- Table structure for table `post_replies`
--

CREATE TABLE `post_replies` (
  `reply_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reply_content` text NOT NULL,
  `reply_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reply_from` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_replies`
--

INSERT INTO `post_replies` (`reply_id`, `post_id`, `user_id`, `reply_content`, `reply_date`, `reply_from`) VALUES
(1, 4, 1, 'dsa', '2023-10-24 21:57:58', 'admin'),
(2, 4, 1, 'dsadasdas', '2023-10-24 22:16:43', 'admin'),
(3, 5, 1, 'Sure', '2023-10-24 22:29:05', 'admin'),
(4, 5, 1, 'Thanks!', '2023-10-25 00:02:57', 'admin'),
(5, 5, 16, 'fsd', '2023-10-25 01:11:03', 'admin'),
(6, 8, 17, 'test reply', '2023-10-25 18:33:59', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `strand` int(11) NOT NULL,
  `instructor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `grade`, `strand`, `instructor`) VALUES
(5, 11, 1, 3),
(6, 12, 4, 4),
(7, 12, 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `section_student`
--

CREATE TABLE `section_student` (
  `id` int(11) NOT NULL,
  `stud_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section_student`
--

INSERT INTO `section_student` (`id`, `stud_id`, `section_id`) VALUES
(1, 5, 5),
(2, 8, 5),
(3, 9, 5),
(4, 10, 5),
(5, 11, 5),
(6, 12, 5),
(7, 16, 5),
(8, 19, 6),
(9, 20, 5);

-- --------------------------------------------------------

--
-- Table structure for table `strand`
--

CREATE TABLE `strand` (
  `strand_id` int(11) NOT NULL,
  `strand` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `strand`
--

INSERT INTO `strand` (`strand_id`, `strand`) VALUES
(1, 'HUMSS'),
(2, 'ABM'),
(3, 'TOURISM'),
(4, 'ANIMATION'),
(5, 'HAIR DRESSING');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `stud_id` int(11) NOT NULL,
  `student_number` varchar(255) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `birthdate` varchar(255) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`stud_id`, `student_number`, `fname`, `lname`, `birthdate`, `gender`, `address`, `image`, `user_id`) VALUES
(11, '202322021', 'Maria', 'Makiling', '2012-09-14', 'female', 'Burot', '', 28),
(13, NULL, 'internsight', NULL, NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a/ACg8ocK_XrpeshuLzdxxik89qRb6mAEGDeGJBrP2YyFRN0zd4Q=s96-c', 44),
(14, NULL, 'elezerwaterrefill', NULL, NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a/ACg8ocLenyZTUbUs3HMixsOYcMfTmbq9wFX9KfI23Uk6l_Fz=s96-c', 46),
(15, NULL, 'InsureCollect', NULL, NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a/ACg8ocKKwS1-zUVU-4fipAAQUCRugJQavI9IFn53DqrcOY16=s96-c', 47),
(16, '3213', 'Gian pineda', '', '2023-10-05', 'other', '321', 'https://lh3.googleusercontent.com/a/ACg8ocJn-AhnBsI4U_eYP7sNl_oWCAD9k5QzypWzA1Ggrv-y=s96-c', 48),
(18, NULL, 'Bennor Pineda', NULL, NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a/ACg8ocK44RHecQcIspzJNzo5sc-ENe6a1zbUddDZkGguzo9Ck4U=s96-c', 50),
(19, '201312344', 'Aegmon Targaryen', NULL, '2011-06-02', 'male', 'test', 'https://lh3.googleusercontent.com/a/ACg8ocIILeNVXEL9_yJPPUDvAt5VQhw1tusXicrAG13UTccA=s96-c', 51),
(20, '20213', 'aegmon03', NULL, '2009-05-30', 'male', 'test', 'https://lh3.googleusercontent.com/a/ACg8ocKFQOXF0DTKZKNdFnN12XdqrfO_uGXR5Pn1sX3QbHWL=s96-c', 52);

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `userID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `usertype` enum('faculty','student','guidance') DEFAULT 'faculty',
  `isOnline` int(11) NOT NULL DEFAULT 1,
  `google_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`userID`, `email`, `password`, `lastlogin`, `usertype`, `isOnline`, `google_id`) VALUES
(16, 'juan@email.com', '$2y$10$h01oEtuDD2B9V.Mu0DZCt.Pi3erXalZ.6E8qiZveVWrMj3GSgX8Hi', NULL, 'faculty', 1, ''),
(17, 'maria@email.com', '$2y$10$LlD.13C5AlNYlr1iGBUQFeNFEWuqqjH/XrwTF8SwmZwEvuRyJ99Wy', NULL, 'faculty', 1, ''),
(18, 'stud@email.com', '$2y$10$0R2WLNCSpjrpGE/.ezad5eo5WXoJHxediv8f2vTepnHrXc.Z1vkPi', NULL, 'student', 1, ''),
(19, 'sad@email.com', '$2y$10$Ql8sKd70Ol7HiwLgmTn.tu7ngGFSHrN.fZ0FdU0T2sBJLm8bF5C.a', NULL, 'student', 1, ''),
(21, 'test11@email', '$2y$10$QixYYlOMewy3l6h.x65creHIda1MZmahnRe9kCValt00tFH89c6yK', NULL, 'student', 1, ''),
(24, 'dsa@dsa', '$2y$10$6876de/oyBz6FphRMShgeeqgUjSofrwOMIAHW.Je1od9hYrOqPlcq', NULL, 'student', 1, ''),
(25, 'ttt@email', '$2y$10$4aM1UoqsA4x5imZ26hLxHO4dUAp4xl8xs8KnRPhEqjTSTx9uOnPcG', NULL, 'student', 1, ''),
(27, 'juandelacruz@email.com', '$2y$10$A3y7dtW1UM9ufIvw4P7vaeP1c6qDqYQ2AASyPk35dTiXtdqgjpzMC', NULL, 'student', 1, ''),
(28, 'mariam@gmail.com', '$2y$10$XeQiK9OAsvq0dLlorr5iL.cj401Hl2hgXpY.uRq3/DMy5b37yjKpu', NULL, 'student', 1, ''),
(29, 'faculty@email.com', '$2y$10$I/713gvpjnm6hHSp2jS15ODa3YsrFlduluHm1oYHndzr746/dO1nG', NULL, 'faculty', 1, ''),
(30, 'testg@email.com', '$2y$10$LAL5KisUQU1B3VMvct5FGuAsuKiE.psRMjePiRvcFYtpbcjQJ58Qe', NULL, 'faculty', 1, ''),
(33, '123@email.com', '$2y$10$PtvIahLk6uksrP.vyLuXKetr3zfR2KXYULf2WbW/Krr/0XhMcJHRO', NULL, 'faculty', 1, ''),
(35, 'testtest@email.com', '$2y$10$aVUeivwwSumLcrUB5NL5vuAl4iMC/aQfq2cyyE2bF6rElYOPN9miG', NULL, 'faculty', 1, ''),
(36, 'testetstets@email.com', '$2y$10$4lOIZXMi6/LBjAk5G9c8A.STt5Im0kme4fM6bwMGXhAQKEXdiBRPa', NULL, 'faculty', 1, ''),
(37, 'dsadsasdsad@dadsadas', '$2y$10$uQI./Y.4bEAwmFnHL9AS7.geRXOcbgzrWbJzUL.J2g7y9pI48WRNm', NULL, '', 1, ''),
(38, '', '$2y$10$SPJTKuo3U.TLaj53pZmZ/.YQYG7hevjZPyX3w6/7sdPTO/35UPmRi', NULL, 'student', 1, ''),
(50, 'pinedabennor@gmail.com', NULL, NULL, 'student', 1, '104541031276332420324'),
(51, 'aegmon01@gmail.com', '$2y$10$CeZyl7hchzIX2Md3WmIea.VnDGHk3xTKt/pPZKbdYAulo2H9phNJa', NULL, 'student', 1, '107922906116451359734'),
(52, 'aegmon04@gmail.com', '$2y$10$j.62Wb.A4ZIbOTbhVvT/5OxziHF2OHjsEtNAXvpiNG4klDgw/n7va', NULL, 'student', 1, '107674267294348391225');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`consult_id`),
  ADD KEY `user_id_host` (`user_id_host`);

--
-- Indexes for table `faculty_info`
--
ALTER TABLE `faculty_info`
  ADD PRIMARY KEY (`faculty_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `guidancecounselor`
--
ALTER TABLE `guidancecounselor`
  ADD PRIMARY KEY (`g_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_replies`
--
ALTER TABLE `post_replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `strand` (`strand`),
  ADD KEY `instructor` (`instructor`);

--
-- Indexes for table `section_student`
--
ALTER TABLE `section_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stud_id` (`stud_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `strand`
--
ALTER TABLE `strand`
  ADD PRIMARY KEY (`strand_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`stud_id`),
  ADD UNIQUE KEY `student_number` (`student_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `consultation`
--
ALTER TABLE `consultation`
  MODIFY `consult_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faculty_info`
--
ALTER TABLE `faculty_info`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `guidancecounselor`
--
ALTER TABLE `guidancecounselor`
  MODIFY `g_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `post_replies`
--
ALTER TABLE `post_replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `section_student`
--
ALTER TABLE `section_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `strand`
--
ALTER TABLE `strand`
  MODIFY `strand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `stud_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`user_id_host`) REFERENCES `userdata` (`userID`);

--
-- Constraints for table `faculty_info`
--
ALTER TABLE `faculty_info`
  ADD CONSTRAINT `faculty_info_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `userdata` (`userID`);

--
-- Constraints for table `post_replies`
--
ALTER TABLE `post_replies`
  ADD CONSTRAINT `post_replies_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`strand`) REFERENCES `strand` (`strand_id`),
  ADD CONSTRAINT `section_ibfk_2` FOREIGN KEY (`instructor`) REFERENCES `faculty_info` (`faculty_id`);

--
-- Constraints for table `section_student`
--
ALTER TABLE `section_student`
  ADD CONSTRAINT `section_student_ibfk_1` FOREIGN KEY (`stud_id`) REFERENCES `student` (`stud_id`),
  ADD CONSTRAINT `section_student_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `userdata` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
