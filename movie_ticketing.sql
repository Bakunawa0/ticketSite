-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 16, 2024 at 05:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie_ticketing`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_movies`
--

CREATE TABLE `tbl_movies` (
  `movieID` int(50) NOT NULL,
  `movieName` varchar(255) NOT NULL,
  `rating` varchar(4) NOT NULL,
  `price` float(5,2) NOT NULL,
  `timeStart` time NOT NULL,
  `runTime` time NOT NULL,
  `timeEnd` time NOT NULL,
  `moviePoster` varchar(255) DEFAULT 'icons/missing.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_movies`
--

INSERT INTO `tbl_movies` (`movieID`, `movieName`, `rating`, `price`, `timeStart`, `runTime`, `timeEnd`, `moviePoster`) VALUES
(1973, 'wayang', 'G', 250.00, '10:30:00', '01:30:00', '12:00:00', 'uploads/phpw6JjkI'),
(1974, 'Shromp', 'PG13', 200.00, '13:35:00', '02:00:00', '15:35:00', 'uploads/php2j9RCf'),
(1975, 'MOive', 'G', 200.00, '12:00:00', '01:35:00', '13:35:00', 'uploads/phpKPGELG');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transactions`
--

CREATE TABLE `tbl_transactions` (
  `transactionID` int(6) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `movieName` varchar(255) NOT NULL,
  `transactionAmt` float(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_transactions`
--

INSERT INTO `tbl_transactions` (`transactionID`, `date`, `movieName`, `transactionAmt`) VALUES
(1, '2024-12-16', 'wayang', 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userID` int(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `admin?` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userID`, `username`, `password`, `firstName`, `lastName`, `admin?`) VALUES
(100, 'admin', '1234', 'root', 'person', 1),
(101, 'cash1', '314159265', 'low', 'wage', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_movies`
--
ALTER TABLE `tbl_movies`
  ADD PRIMARY KEY (`movieID`),
  ADD KEY `movieName` (`movieName`);

--
-- Indexes for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  ADD PRIMARY KEY (`transactionID`),
  ADD KEY `movieName` (`movieName`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_movies`
--
ALTER TABLE `tbl_movies`
  MODIFY `movieID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1976;

--
-- AUTO_INCREMENT for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  MODIFY `transactionID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  ADD CONSTRAINT `tbl_transactions_ibfk_1` FOREIGN KEY (`movieName`) REFERENCES `tbl_movies` (`movieName`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
