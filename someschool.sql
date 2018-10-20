-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2018 at 01:54 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `someschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `ID` int(11) NOT NULL,
  `Course_Name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `Cpicture` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`ID`, `Course_Name`, `description`, `Cpicture`) VALUES
(4, 'Green Truck', 'Build a green truck', '../UserPics/Green Truck.png'),
(5, 'Ninja', 'Build a Ninja town', '../UserPics/Ninja.png'),
(9, 'Multiple Trucks', 'A lot of trucks!', '../UserPics/Multiple Trucks.png'),
(14, 'Yellow Race-Car', 'Build a yellow race-car!', '../UserPics/Yellow Race-Car.png'),
(15, 'Race-Course', 'Race cars and trucks in a race course!', '../UserPics/Race-Course.png');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `ID` int(11) NOT NULL,
  `Student_Name` varchar(255) NOT NULL,
  `Phone_Number` varchar(255) NOT NULL,
  `Semail` varchar(255) NOT NULL,
  `Spicture` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`ID`, `Student_Name`, `Phone_Number`, `Semail`, `Spicture`) VALUES
(2, 'Student1', '058-9861548', 'student1@someschool.org', '../UserPics/Student1.png'),
(3, 'Student2', '085-9761285', 'student2@someschool.org', '../UserPics/Student2.png'),
(4, 'Student3', '067-9843265', 'student3@someschool.org', '../UserPics/Student3.png'),
(19, 'Student4', '549-8976523', 'student4@someschool.org', '../UserPics/Student4.png'),
(20, 'Student5', '548-8578965', 'student5@someschool.org', '../UserPics/Student5.png'),
(28, 'Student6', '054-6589478', 'student6@someschool.org', '../UserPics/Student6.png'),
(31, 'Student7', '548-8758945', 'student7@someschool.org', '../UserPics/Student7.png');

-- --------------------------------------------------------

--
-- Table structure for table `studentsandcourses`
--

CREATE TABLE `studentsandcourses` (
  `ID` int(11) NOT NULL,
  `Student_ID` int(11) NOT NULL,
  `Course_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentsandcourses`
--

INSERT INTO `studentsandcourses` (`ID`, `Student_ID`, `Course_ID`) VALUES
(4, 28, 5),
(5, 28, 14),
(82, 3, 4),
(83, 3, 14),
(84, 3, 15),
(85, 4, 5),
(86, 4, 9),
(87, 4, 15),
(88, 19, 4),
(89, 19, 15),
(90, 20, 14),
(91, 31, 4),
(92, 31, 5),
(93, 31, 9),
(94, 31, 14),
(95, 31, 15),
(96, 2, 5),
(97, 2, 9);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `User_Name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `Phone_Number` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `picture` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `User_Name`, `password`, `email`, `Phone_Number`, `role`, `picture`) VALUES
(1, 'Dexter Jax', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'dj@someschool.org', '058-1254844', 'Owner', '../UserPics/principal.png'),
(2, 'Manager1', '63c28682eb0faa053b6e1db2b32818c1f4ba6487', 'manager1@someschool.org', '058-6547854', 'Manager', '../UserPics/Manager1.png'),
(3, 'Manager2', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'manager2@someschool.org', '254-8975645', 'Manager', '../UserPics/Manager2.png'),
(4, 'Sales1', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'sales1@someschool.org', '052-5489325', 'Sales', '../UserPics/Sales1.png'),
(5, 'Sales2', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'sales2@somechool.org', '254-8798565', 'Sales', '../UserPics/Sales2.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `studentsandcourses`
--
ALTER TABLE `studentsandcourses`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `studentsandcourses`
--
ALTER TABLE `studentsandcourses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
