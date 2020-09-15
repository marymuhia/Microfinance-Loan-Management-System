-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2019 at 09:17 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(4) NOT NULL,
  `userName` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `userName`, `password`) VALUES
(1, 'admin', 'Admin@123');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `loanId` int(6) NOT NULL,
  `memberId` int(8) NOT NULL,
  `loanType` varchar(15) NOT NULL,
  `income` int(8) NOT NULL,
  `amount` int(8) NOT NULL,
  `intereset` varchar(5) NOT NULL,
  `payment_term` int(3) NOT NULL,
  `total_paid` int(8) NOT NULL,
  `emi_per_month` int(8) NOT NULL,
  `bankStatementPhoto` varchar(250) NOT NULL,
  `security` varchar(250) NOT NULL,
  `posting_date` date NOT NULL,
  `status` varchar(15) NOT NULL,
  `adminRemark` varchar(100) NOT NULL,
  `adminRemarkDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`loanId`, `memberId`, `loanType`, `income`, `amount`, `intereset`, `payment_term`, `total_paid`, `emi_per_month`, `bankStatementPhoto`, `security`, `posting_date`, `status`, `adminRemark`, `adminRemarkDate`) VALUES
(7, 32328507, 'School fees', 15000, 10000, '7', 1, 10700, 891, '', 'customer.jpg', '2019-06-03', 'Approved', 'adr', '2019-06-03'),
(8, 2777680, 'School fees', 20000, 15000, '7', 1, 16050, 1337, '', 'download (1).jpg', '2019-06-03', 'pending', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `loantype`
--

CREATE TABLE `loantype` (
  `id` int(4) NOT NULL,
  `loanType` varchar(15) NOT NULL,
  `description` varchar(200) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(5) NOT NULL,
  `memberId` int(8) NOT NULL,
  `fName` varchar(15) NOT NULL,
  `lName` varchar(15) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `occupation` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(15) NOT NULL,
  `address` varchar(12) NOT NULL,
  `county` varchar(20) NOT NULL,
  `district` varchar(20) NOT NULL,
  `location` varchar(20) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `dob` date NOT NULL,
  `regDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `memberId`, `fName`, `lName`, `gender`, `phone`, `occupation`, `email`, `password`, `address`, `county`, `district`, `location`, `photo`, `dob`, `regDate`) VALUES
(6, 2777680, 'Randu', 'Karisa', 'M', '+254738242338', 'teacher', 'karisa', 'Admin_123', 'bungoma', 'mombasa', 'mukurweini', 'kirigiti', 'customer.jpg', '2019-06-03', '2019-06-03'),
(1, 32328507, 'Edward', 'Mutahi', 'M', '0718533226', 'studentt', 'eddyzahil@gmail.com', 'Admin@123', '111-10101', 'nyeri', 'mukurweini', 'githi', 'add_user.png', '1995-01-09', '2019-05-24');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(6) NOT NULL,
  `paymentId` varchar(20) NOT NULL,
  `memberId` int(8) NOT NULL,
  `fName` varchar(15) NOT NULL,
  `lName` varchar(15) NOT NULL,
  `amount` int(8) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD UNIQUE KEY `loanId` (`loanId`),
  ADD KEY `n` (`memberId`);

--
-- Indexes for table `loantype`
--
ALTER TABLE `loantype`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`memberId`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentId`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `m` (`memberId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `loanId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `loantype`
--
ALTER TABLE `loantype`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `n` FOREIGN KEY (`memberId`) REFERENCES `member` (`memberId`) ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `m` FOREIGN KEY (`memberId`) REFERENCES `member` (`memberId`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
