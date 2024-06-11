-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2024 at 10:36 AM
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
-- Database: `db_rahmatdhan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_department`
--

CREATE TABLE `tb_department` (
  `dept_id` char(10) NOT NULL,
  `dept_name` enum('IT','Production','Assembly') NOT NULL,
  `dept_loc` enum('Batam') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_department`
--

INSERT INTO `tb_department` (`dept_id`, `dept_name`, `dept_loc`) VALUES
('100018', 'Production', 'Batam'),
('100019', 'IT', 'Batam');

-- --------------------------------------------------------

--
-- Table structure for table `tb_employees`
--

CREATE TABLE `tb_employees` (
  `employee_id` char(10) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `phone_number` char(15) NOT NULL,
  `join_date` date NOT NULL,
  `dept_id` char(10) NOT NULL,
  `salary` char(50) NOT NULL,
  `job_id` char(10) NOT NULL,
  `last_update` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_employees`
--

INSERT INTO `tb_employees` (`employee_id`, `first_name`, `last_name`, `email`, `phone_number`, `join_date`, `dept_id`, `salary`, `job_id`, `last_update`) VALUES
('3311711059', 'Rahmatdhan', 'Rahmatdhan', 'sierahmat19@gmail.com', '6281277973150', '2024-06-05', '100018', '5000000', '100194', '2024-06-11');

-- --------------------------------------------------------

--
-- Table structure for table `tb_job`
--

CREATE TABLE `tb_job` (
  `job_id` char(10) NOT NULL,
  `job_name` varchar(50) NOT NULL,
  `min_salary` char(25) NOT NULL,
  `max_salary` char(25) NOT NULL,
  `dept_id` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_job`
--

INSERT INTO `tb_job` (`job_id`, `job_name`, `min_salary`, `max_salary`, `dept_id`) VALUES
('100193', 'IT Programmer', '5000000', '10000000', '100019'),
('100194', 'Production Controller', '4500000', '7000000', '100018');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_department`
--
ALTER TABLE `tb_department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `tb_employees`
--
ALTER TABLE `tb_employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `fk_job_id` (`job_id`);

--
-- Indexes for table `tb_job`
--
ALTER TABLE `tb_job`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `fk_dept_id` (`dept_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_employees`
--
ALTER TABLE `tb_employees`
  ADD CONSTRAINT `fk_job_id` FOREIGN KEY (`job_id`) REFERENCES `tb_job` (`job_id`),
  ADD CONSTRAINT `tb_employees_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `tb_department` (`dept_id`);

--
-- Constraints for table `tb_job`
--
ALTER TABLE `tb_job`
  ADD CONSTRAINT `fk_dept_id` FOREIGN KEY (`dept_id`) REFERENCES `tb_department` (`dept_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
