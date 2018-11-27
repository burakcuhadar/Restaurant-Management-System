-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 07, 2018 at 08:36 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_waiter_count` (IN `table_id` VARCHAR(40), IN `given_datetime` DATETIME)  BEGIN

IF table_id LIKE 'ALL' THEN
	SELECT COUNT(*) FROM assign WHERE start_time <= given_datetime AND end_time >= given_datetime;
ELSE
	SELECT COUNT(*) FROM assign WHERE table_no = table_id AND start_time <= given_datetime AND end_time >= given_datetime;
END IF;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `assign`
--

CREATE TABLE `assign` (
  `waiter_name` varchar(40) NOT NULL,
  `table_no` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assign`
--

INSERT INTO `assign` (`waiter_name`, `table_no`, `start_time`, `end_time`) VALUES
('a', 1, '2018-08-10 10:00:00', '2018-08-10 12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `table_no` int(11) NOT NULL,
  `no_of_seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`table_no`, `no_of_seats`) VALUES
(1, 30),
(2, 88),
(4, 21);

--
-- Triggers `tables`
--
DELIMITER $$
CREATE TRIGGER `after_tables_insert` AFTER INSERT ON `tables` FOR EACH ROW BEGIN
	SET @idle_waiter = (SELECT name FROM waiters WHERE name NOT IN (SELECT waiter_name FROM assign WHERE (start_time BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 HOUR) ) OR (end_time BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 HOUR) ) OR (start_time <= NOW() AND end_time >= DATE_ADD(NOW(), INTERVAL 1 HOUR)) ) LIMIT 1);
	IF  @idle_waiter IS NOT NULL THEN
		INSERT INTO assign(waiter_name, table_no, start_time, end_time) VALUES(@idle_waiter, NEW.table_no, NOW(), DATE_ADD(NOW(), INTERVAL 1 HOUR) );
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `role` enum('admin','head-waiter') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `role`) VALUES
('baba', '123', 'admin'),
('usta', '234', 'head-waiter');

-- --------------------------------------------------------

--
-- Table structure for table `waiters`
--

CREATE TABLE `waiters` (
  `name` varchar(40) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `waiters`
--

INSERT INTO `waiters` (`name`, `age`) VALUES
('a', 23),
('b', 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`table_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `waiters`
--
ALTER TABLE `waiters`
  ADD PRIMARY KEY (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
