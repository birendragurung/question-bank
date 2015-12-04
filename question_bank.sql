-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2015 at 11:56 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `question_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_panel`
--

CREATE TABLE IF NOT EXISTS `admin_panel` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_panel`
--

INSERT INTO `admin_panel` (`id`, `username`, `password`) VALUES
(1, 'birendra', 'biren'),
(2, 'ajay', 'qwerty');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `affiliated_to` varchar(50) NOT NULL,
  `course_directory` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_name`, `affiliated_to`, `course_directory`) VALUES
(1, 'SLC', 'SLC', 'GON', ''),
(2, 'SCIENCE', '+2Science', 'HSEB', ''),
(3, 'COMMERCE', '+2Commerce', 'HSEB', ''),
(4, 'CSIT', 'BSc.CSIT', 'TU', ''),
(5, 'BBA', 'BBA', 'TU', '');

-- --------------------------------------------------------

--
-- Table structure for table `course_level`
--

CREATE TABLE IF NOT EXISTS `course_level` (
  `id` int(11) NOT NULL,
  `course_id` int(1) NOT NULL,
  `level_id` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_level`
--

INSERT INTO `course_level` (`id`, `course_id`, `level_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 2, 3),
(4, 3, 4),
(5, 3, 5),
(6, 4, 6),
(7, 4, 7),
(8, 4, 8),
(9, 4, 9),
(10, 4, 10),
(11, 4, 11),
(12, 4, 12),
(13, 4, 13),
(14, 5, 14),
(15, 5, 15),
(16, 5, 16),
(17, 5, 17),
(18, 5, 18),
(19, 5, 19),
(20, 5, 20),
(21, 5, 21);

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `id` int(11) NOT NULL,
  `level_id` varchar(30) NOT NULL,
  `level_name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `level_id`, `level_name`) VALUES
(1, 'SLC10', 'SLC 10'),
(2, 'SCIENCE11', 'Science 11'),
(3, 'SCIENCE12', 'Science 12'),
(4, 'COMMERCE11', 'Commerce 11'),
(5, 'COMMERCE12', 'Commerce 12'),
(6, 'CSIT1', 'First semester (CSIT)'),
(7, 'CSIT2', 'Second semester(CSIT)'),
(8, 'CSIT3', 'Third semester(CSIT)'),
(9, 'CSIT4', 'Fourth semester(CSIT)'),
(10, 'CSIT5', 'Fifth semester(CSIT)'),
(11, 'CSIT6', 'Sixth semester(CSIT)'),
(12, 'CSIT7', 'Seventh semester(CSIT)'),
(13, 'CSIT8', 'Eight semester(CSIT)'),
(14, 'BBA1', 'First semester(BBA)'),
(15, 'BBA2', 'Second semester(BBA)'),
(16, 'BBA3', 'Third semester(BBA)'),
(17, 'BBA4', 'Fourth semester(BBA)'),
(18, 'BBA5', 'Fifth semester(BBA)'),
(19, 'BBA6', 'Sixth semester(BBA)'),
(20, 'BBA7', 'Seventh semester(BBA)'),
(21, 'BBA8', 'Eight semester(BBA)');

-- --------------------------------------------------------

--
-- Table structure for table `level_subject`
--

CREATE TABLE IF NOT EXISTS `level_subject` (
  `id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level_subject`
--

INSERT INTO `level_subject` (`id`, `level_id`, `subject_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 3, 4),
(5, 6, 5),
(6, 4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `papers`
--

CREATE TABLE IF NOT EXISTS `papers` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `level_id` int(4) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `papers`
--

INSERT INTO `papers` (`id`, `course_id`, `level_id`, `sub_id`, `year`, `location`) VALUES
(12, 1, 1, 1, 2052, 'papers/SLC/SLC10/NEP10_2052.pdf'),
(20, 1, 1, 1, 2065, 'papers/SLC/SLC10/NEP10_2065.pdf'),
(21, 1, 1, 1, 2069, 'papers/SLC/SLC10/NEP10_2069.pdf'),
(22, 1, 1, 1, 2063, 'papers/SLC/SLC10/NEP10_2063.pdf'),
(24, 1, 1, 1, 2059, 'papers/SLC/SLC10/NEP10_2059.pdf'),
(25, 1, 1, 2, 2065, 'papers/SLC/SLC10/ENG10_2065.pdf'),
(26, 1, 1, 2, 2051, 'papers/SLC/SLC10/ENG10_2051.pdf'),
(29, 2, 2, 3, 2064, 'papers/SCIENCE/SCIENCE11/PHY11_2064.pdf'),
(30, 2, 2, 3, 2067, 'papers/SCIENCE/SCIENCE11/PHY11_2067.pdf'),
(31, 2, 2, 3, 2055, 'papers/SCIENCE/SCIENCE11/PHY11_2055.pdf'),
(32, 2, 3, 4, 2064, 'papers/SCIENCE/SCIENCE12/MTH12_2064.pdf'),
(35, 1, 1, 2, 2057, 'papers/SLC/SLC10/ENG10_2057.pdf'),
(36, 1, 1, 2, 2067, 'papers/SLC/SLC10/ENG10_2067.pdf'),
(37, 3, 4, 6, 2058, 'papers/COMMERCE/COMMERCE11/COM_2058.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL,
  `sub_code` varchar(20) NOT NULL,
  `sub_name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `sub_code`, `sub_name`) VALUES
(1, 'NEP101', 'Hamro Nepali'),
(2, 'ENG10', 'Compulsory English'),
(3, 'PHY11', 'Physics for 11'),
(4, 'MTH12', 'Mathematics 12'),
(5, 'CS50', 'Computer Science'),
(6, 'COM', 'Busdjfslkj');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_panel`
--
ALTER TABLE `admin_panel`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `course_code` (`course_code`), ADD FULLTEXT KEY `course_name` (`course_name`);

--
-- Indexes for table `course_level`
--
ALTER TABLE `course_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `level_id` (`level_id`), ADD FULLTEXT KEY `level_name` (`level_name`);

--
-- Indexes for table `level_subject`
--
ALTER TABLE `level_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `papers`
--
ALTER TABLE `papers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `sub_id` (`sub_code`), ADD FULLTEXT KEY `subject` (`sub_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_panel`
--
ALTER TABLE `admin_panel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `course_level`
--
ALTER TABLE `course_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `level_subject`
--
ALTER TABLE `level_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `papers`
--
ALTER TABLE `papers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
