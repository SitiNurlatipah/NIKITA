-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2022 at 03:50 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mapcomp`
--

-- --------------------------------------------------------

--
-- Table structure for table `competencies_directory`
--

CREATE TABLE `competencies_directory` (
  `id_directory` int(11) NOT NULL,
  `id_curriculum` int(11) NOT NULL,
  `id_job_title` char(8) NOT NULL,
  `between_year` varchar(150) NOT NULL,
  `target` int(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `competencies_directory`
--

INSERT INTO `competencies_directory` (`id_directory`, `id_curriculum`, `id_job_title`, `between_year`, `target`) VALUES
(1, 1, 'JT-0048', '', 4),
(2, 3, 'JT-0049', '', 3),
(3, 4, 'JT-0047', '', 5),
(4, 5, 'JT-0047', '', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `competencies_directory`
--
ALTER TABLE `competencies_directory`
  ADD PRIMARY KEY (`id_directory`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `competencies_directory`
--
ALTER TABLE `competencies_directory`
  MODIFY `id_directory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
