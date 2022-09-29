-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 23, 2022 at 06:24 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bankinmanagmentsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `addedemployee`
--

CREATE TABLE `addedemployee` (
  `id` int(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `nid` int(100) NOT NULL,
  `phone` text NOT NULL,
  `password` varchar(100) NOT NULL,
  `cpassword` varchar(100) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `cv` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `addedemployee`
--

INSERT INTO `addedemployee` (`id`, `fname`, `lname`, `uname`, `email`, `nid`, `phone`, `password`, `cpassword`, `picture`, `cv`) VALUES
(3, 'jhdbfjhg', 'jhbfjeg', 'jkfbeb', 'uhfgejme@gmail.com', 23742323, '+8801683238232', 'Hamid123@', 'Hamid123@', '../uploads/profile_picture/284584-urban-colorful-night-Times_Square-New_York_City.jpeg', '../uploads/applicant_cv/CamScanner 08-01-2022 21.17.pdf'),
(4, 'jhbfjhefe', 'jhbfjhebrg', 'jhbfhef', 'hjbsffk@gmail.com', 23324313, '+8801634611111', 'Hadid123@', 'Hadid123@', '../uploads/profile_picture/284584-urban-colorful-night-Times_Square-New_York_City.jpeg', '../uploads/applicant_cv/CamScanner 08-01-2022 21.17.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `admin_account_number`
--

CREATE TABLE `admin_account_number` (
  `serial` int(100) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nid` int(20) NOT NULL,
  `accountno` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_account_number`
--

INSERT INTO `admin_account_number` (`serial`, `uname`, `email`, `nid`, `accountno`) VALUES
(18, 'sajid123', 'sajid@gmail.com', 76786357, 1269817),
(19, 'hamim123', 'hamim@gmail.com', 98745854, 8436863);

-- --------------------------------------------------------

--
-- Table structure for table `admin_back_up`
--

CREATE TABLE `admin_back_up` (
  `applicant_serial` int(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `nid` int(15) NOT NULL,
  `phone` text NOT NULL,
  `password` varchar(15) NOT NULL,
  `cpassword` varchar(15) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `cv` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_back_up`
--

INSERT INTO `admin_back_up` (`applicant_serial`, `fname`, `lname`, `uname`, `email`, `nid`, `phone`, `password`, `cpassword`, `picture`, `cv`) VALUES
(10, 'Sajid', 'Nigga', 'sajid123', 'sajid@gmail.com', 76786357, '+8801634632643', 'Sajid123@', 'Sajid123@', '../uploads/profile_picture/284584-urban-colorful-night-Times_Square-New_York_City.jpeg', '../uploads/applicant_cv/CamScanner 08-01-2022 21.17.pdf'),
(11, 'Hamim', 'Nigga', 'hamim123', 'hamim@gmail.com', 98745854, '+8801800101010', 'Hamim123@', 'Hamim123@', '../uploads/profile_picture/284584-urban-colorful-night-Times_Square-New_York_City.jpeg', '../uploads/applicant_cv/CamScanner 08-01-2022 21.17.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `applicantofadmin`
--

CREATE TABLE `applicantofadmin` (
  `applicant_serial` int(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `nid` int(15) NOT NULL,
  `phone` text NOT NULL,
  `password` varchar(15) NOT NULL,
  `cpassword` varchar(15) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `cv` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applicantofadmin`
--

INSERT INTO `applicantofadmin` (`applicant_serial`, `fname`, `lname`, `uname`, `email`, `nid`, `phone`, `password`, `cpassword`, `picture`, `cv`) VALUES
(64, 'hjdvbehfv', 'hdvhegfv', 'hjvfghefv', 'hhh@gmail.com', 39743248, '+8801683238233', 'Ppl@ying5cards', 'Ppl@ying5cards', '../uploads/profile_picture/284584-urban-colorful-night-Times_Square-New_York_City.jpeg', '../uploads/applicant_cv/CamScanner 08-01-2022 21.17.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `details_table_for_selected_admins`
--

CREATE TABLE `details_table_for_selected_admins` (
  `serial` int(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nid` int(20) NOT NULL,
  `phone` text NOT NULL,
  `salary` int(20) NOT NULL,
  `pin` int(4) NOT NULL,
  `accountno` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `details_table_for_selected_admins`
--

INSERT INTO `details_table_for_selected_admins` (`serial`, `fname`, `lname`, `uname`, `email`, `nid`, `phone`, `salary`, `pin`, `accountno`) VALUES
(21, 'Sajid', 'Nigga', 'sajid123', 'sajid@gmail.com', 76786357, '+8801634632643', 0, 1212, 8001704),
(22, 'Hamim', 'Nigga', 'hamim123', 'hamim@gmail.com', 98745854, '+8801800101010', 0, 2121, 8436863);

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `id` int(100) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `age` int(100) DEFAULT NULL,
  `fathersname` varchar(100) DEFAULT NULL,
  `mothersname` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `presentaddress` text,
  `nid` int(100) DEFAULT NULL,
  `phone` text,
  `cvpath` varchar(100) DEFAULT NULL,
  `imgpath` varchar(100) DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `salary` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`id`, `firstname`, `lastname`, `gender`, `age`, `fathersname`, `mothersname`, `username`, `pass`, `email`, `presentaddress`, `nid`, `phone`, `cvpath`, `imgpath`, `doj`, `salary`) VALUES
(11, 'Sajidgsdfg', 'Mahbub', 'male', 21, 'S.M Mahbubur Rahman', 'Beauty Rahman', 'sajid10', '12Sajid@', 'sajid.mahbub40@gmail.com', '112/3 , DHAKA , 1900', 12345678, '+8801518439144', '../uploads/cv(20-42109-1).pdf', '../uploads/297683814_589411019257927_6597469367971956160_n.jpg', '2022-08-01', 25000);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(100) NOT NULL,
  `tittle` varchar(100) NOT NULL,
  `news_body` varchar(200) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `tittle`, `news_body`, `created`) VALUES
(3, 'Hello', 'Good Morning Everyone', '2022-08-22 04:46:48'),
(4, 'Project Demonstration', 'The demonstrations will start sharp at 8:00 AM.', '2022-08-22 05:08:26');

-- --------------------------------------------------------

--
-- Table structure for table `new_user`
--

CREATE TABLE `new_user` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `nid` int(100) NOT NULL,
  `phone` text NOT NULL,
  `accountno` int(100) NOT NULL,
  `pin` int(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `cpassword` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `new_user`
--

INSERT INTO `new_user` (`user_id`, `fname`, `lname`, `uname`, `email`, `nid`, `phone`, `accountno`, `pin`, `password`, `cpassword`) VALUES
(9, 'dfjkbkhjbvdj', 'jhsbvjhvdb', 'shjbvjkdbv', 'jhvbdjhvbdj', 47657365, '43563457', 465345, 76347835, '', ''),
(10, 'jhbudbvd', 'jhbvjbvj', 'jvbdvjdbv', 'hjbvjhd', 46536437, '67345376', 6745376, 674537, 'djkfnkdjfb', 'jkbvdjfv'),
(11, 'jkdfbvkdjbjk', 'jhbfjhvb', 'jhbvdjhbv', 'kjbsdvjdhv', 784568734, '78465378', 784653847, 8723463, '478564378fh', 'hbcjsvsa'),
(12, 'ajbdsvjhdvb', 'jhbscjsahv', 'jksbvjshvh', 'skjbvjj', 2147483647, '827364', 82746, 87463, 'jsndjksbvj', 'jsbdvjv'),
(13, 'kjbajbvdj', 'jhbavjhd', 'hjbvjahdv', 'bvjhdav', 345353, 'afdbdhjf', 34532543, 535, 'kbvhjdbafj', 'badfjvfd'),
(14, 'ajbvjadhfbvjad', 'abvjhdabvjh', 'kjbvkajdfhbvj', 'jbjvhadbv', 345345, '832565', 2147483647, 73658, 'jhsbvhjdabhj', 'bJVADFV'),
(15, 'djhbfvdh', 'jkbahjdvvb', 'bjhadbjbj', 'hjbajh@gmail.com', 2147483647, '23478685', 7856834, 8756843, 'uasgdhfjabj', 'hsbvjdav'),
(16, 'jhdbjhvbjhdf', 'hjbvsjbadvaj', 'jhsbvjdafh', 'jhbvdbhb@gmail.com', 11111111, 'jahbjdfhbvd', 2147483647, 75628347, 'jsbajvhbdhfjv', 'hbvjhvdfv'),
(17, 'jkbdfvjhdbv', 'jhbdvhjd', 'jksbvjahdf', 'kajbvjhdb@gmail.com', 11111111, '+8801889046538', 2147483647, 48736527, 'kjasbfdhjvdf', 'kjdbvjadf'),
(18, 'jdbvdvbjd', 'jhbdvjhadb', 'hbfvhjdvb', 'jbdvj@gmail.com', 66666666, '+8801634632643', 7777777, 1111, 'Aftab123@', 'Aftab123@'),
(19, 'hjdsbvjsv', 'jhbvjbvj', 'jhdvbevb', 'bvjbvh@gmail.com', 47474747, '+8801800101010', 4752783, 2222, 'Aftab123@', 'Aftab123@'),
(20, 'jhvbhb', 'hjvbhdf', 'hjhvgq', 'hjvhgv@ggmail.com', 47247346, '+8801800101010', 7324662, 1212, 'Aftab123@', 'Aftab123@');

-- --------------------------------------------------------

--
-- Table structure for table `passbook`
--

CREATE TABLE `passbook` (
  `trans_id` int(10) NOT NULL,
  `trans_date` datetime NOT NULL,
  `remarks` varchar(256) NOT NULL,
  `debit` int(14) NOT NULL,
  `credit` int(14) NOT NULL,
  `balance` int(14) NOT NULL,
  `accountno` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `passbook`
--

INSERT INTO `passbook` (`trans_id`, `trans_date`, `remarks`, `debit`, `credit`, `balance`, `accountno`) VALUES
(39, '2022-08-22 08:52:40', 'Cash Deposit', 0, 5000, 5000, 8001704),
(40, '2022-08-22 08:53:30', 'Sent to: Hamim Nigga, AC/No: 8436863', 4999, 0, 1, 8436863),
(41, '2022-08-22 08:53:30', 'Received from: Sajid Nigga, AC/No: 8001704', 0, 4999, 1, 8436863);

-- --------------------------------------------------------

--
-- Table structure for table `registrationofemployee`
--

CREATE TABLE `registrationofemployee` (
  `id` int(11) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `uname` text NOT NULL,
  `email` text NOT NULL,
  `nid` int(100) NOT NULL,
  `phone` text NOT NULL,
  `password` text NOT NULL,
  `cpassword` text NOT NULL,
  `picture` text NOT NULL,
  `cv` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `staticadmin`
--

CREATE TABLE `staticadmin` (
  `admin_id` int(100) NOT NULL,
  `uname` char(50) NOT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `accountno` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staticadmin`
--

INSERT INTO `staticadmin` (`admin_id`, `uname`, `pass`, `email`, `code`, `accountno`) VALUES
(1, 'aftabrakinsad', 'Aftab123@', 'rakinsadaftab@gmail.com', '0', 1000010);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nid` int(100) NOT NULL,
  `phone` text NOT NULL,
  `accountno` int(100) NOT NULL,
  `pin` int(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `cpassword` varchar(100) NOT NULL,
  `picture` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `lname`, `uname`, `email`, `nid`, `phone`, `accountno`, `pin`, `password`, `cpassword`, `picture`) VALUES
(1, 'Hamim', 'Khann', 'hamimm', 'hamim@gmail.com', 32324234, '+8801334786567', 4322345, 3333, 'Hamim123@', 'Hamim123@', '../uploads/profile_picture/284584-urban-colorful-night-Times_Square-New_York_City.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addedemployee`
--
ALTER TABLE `addedemployee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_account_number`
--
ALTER TABLE `admin_account_number`
  ADD PRIMARY KEY (`nid`),
  ADD UNIQUE KEY `serial` (`serial`);

--
-- Indexes for table `admin_back_up`
--
ALTER TABLE `admin_back_up`
  ADD PRIMARY KEY (`nid`),
  ADD UNIQUE KEY `applicant_serial` (`applicant_serial`);

--
-- Indexes for table `applicantofadmin`
--
ALTER TABLE `applicantofadmin`
  ADD PRIMARY KEY (`nid`),
  ADD UNIQUE KEY `applicant_serial` (`applicant_serial`);

--
-- Indexes for table `details_table_for_selected_admins`
--
ALTER TABLE `details_table_for_selected_admins`
  ADD PRIMARY KEY (`nid`),
  ADD UNIQUE KEY `serial` (`serial`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `new_user`
--
ALTER TABLE `new_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `passbook`
--
ALTER TABLE `passbook`
  ADD PRIMARY KEY (`trans_id`);

--
-- Indexes for table `registrationofemployee`
--
ALTER TABLE `registrationofemployee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staticadmin`
--
ALTER TABLE `staticadmin`
  ADD UNIQUE KEY `admin_id` (`admin_id`),
  ADD UNIQUE KEY `admin_id_2` (`admin_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addedemployee`
--
ALTER TABLE `addedemployee`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_account_number`
--
ALTER TABLE `admin_account_number`
  MODIFY `serial` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `admin_back_up`
--
ALTER TABLE `admin_back_up`
  MODIFY `applicant_serial` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `applicantofadmin`
--
ALTER TABLE `applicantofadmin`
  MODIFY `applicant_serial` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `details_table_for_selected_admins`
--
ALTER TABLE `details_table_for_selected_admins`
  MODIFY `serial` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `new_user`
--
ALTER TABLE `new_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `passbook`
--
ALTER TABLE `passbook`
  MODIFY `trans_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `registrationofemployee`
--
ALTER TABLE `registrationofemployee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staticadmin`
--
ALTER TABLE `staticadmin`
  MODIFY `admin_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
