-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 06, 2019 at 07:09 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iosas`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_count` int(55) NOT NULL,
  `form` int(55) NOT NULL,
  `label` varchar(30) NOT NULL,
  `updated` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `has_final` int(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `parent_students`
--

DROP TABLE IF EXISTS `parent_students`;
CREATE TABLE IF NOT EXISTS `parent_students` (
  `parent` int(50) NOT NULL,
  `student` int(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`) VALUES
(1, 'Dashboard'),
(2, 'Students'),
(3, 'Teachers'),
(4, 'Users'),
(5, 'Groups'),
(6, 'Exams'),
(7, 'Reports'),
(8, 'Calendar'),
(9, 'Lessons'),
(12, 'Settings'),
(13, 'Profile'),
(10, 'Medical'),
(11, 'Co-curric');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

DROP TABLE IF EXISTS `schools`;
CREATE TABLE IF NOT EXISTS `schools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `created`, `updated`) VALUES
(1, 'IOSAS High School', '2019-01-05 18:32:55', '2019-01-04 21:00:00'),
(2, 'ST. Mathews School', '2019-01-05 18:32:55', '2019-01-30 21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `student_rand_numbers`
--

DROP TABLE IF EXISTS `student_rand_numbers`;
CREATE TABLE IF NOT EXISTS `student_rand_numbers` (
  `student` int(50) NOT NULL,
  `rand_number` varchar(55) NOT NULL,
  `index_number` varchar(55) NOT NULL,
  `student_number` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sys_users`
--

DROP TABLE IF EXISTS `sys_users`;
CREATE TABLE IF NOT EXISTS `sys_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(55) NOT NULL,
  `password` text NOT NULL,
  `user_id` int(30) NOT NULL,
  `user_type` int(4) NOT NULL DEFAULT '4466',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1=active, 0=inactive',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_users`
--

INSERT INTO `sys_users` (`id`, `username`, `password`, `user_id`, `user_type`, `status`, `created`, `updated`) VALUES
(1, 'iosas', '$2y$10$9zbYEBRTt3maA5mdWdtZgeU4HJupF1H9PWKH49k8mW7ikrBEPHFI2', 1, 1111, 1, '2018-01-06 05:02:39', '2019-01-06 18:01:27'),
(2, 'iosas1', '$2y$10$kMIdNjVKYXCJdugedl0B7u..BK8g1EI3i0CXZIaCD8AeTAnmzWJXC', 2, 4466, 0, '2018-01-06 05:42:39', '2019-01-06 16:50:14'),
(3, 'juma', '$2y$10$8MmpGUR8X1Seq1R/QzMQx./JgxKKhmF4yqqrHitDQZ7Pvwll3igu2', 3, 4466, 0, '2018-01-06 16:53:33', '2019-01-06 17:59:33'),
(4, 'Ian', '$2y$10$CRU3skG/mNxcmVlGTwWX1uf0vnsowZigjvOUsQqghxPJLlRswwIOO', 4, 4466, 0, '2018-01-06 16:53:47', '2019-01-06 17:59:41'),
(5, 'Marry', '$2y$10$Se9XbI6LC10nxwcBCHU5H.RRnElZs7XaZLSVuUbp0IVT.X9KfblGa', 5, 4466, 0, '2019-01-06 16:54:04', '2019-01-06 16:54:04'),
(6, 'Kim', '$2y$10$/DUZo.aqAfAP8wxtuwS29OxwJ1Xc6JZS7p4O0015NnqJaTrl4ZZxu', 6, 4466, 0, '2019-01-06 18:10:39', '2019-01-06 18:10:39'),
(7, 'Irene', '$2y$10$gX5cyltRreQoFR0msskcM.d/QAi90ysvDNwOlhkDW0fdYC0LUz.zm', 7, 4466, 0, '2019-01-06 18:11:08', '2019-01-06 18:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `school_id` int(50) NOT NULL,
  `fname` varchar(25) DEFAULT NULL,
  `mname` varchar(25) DEFAULT NULL,
  `lname` varchar(25) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `phone` int(12) DEFAULT NULL,
  `alt_phone` int(12) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `county` varchar(55) DEFAULT NULL,
  `sub_county` varchar(55) DEFAULT NULL,
  `constituency` varchar(55) DEFAULT NULL,
  `location_ward` varchar(55) DEFAULT NULL,
  `village` varchar(55) DEFAULT NULL,
  `disabilities` text,
  `status` int(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `school_id`, `fname`, `mname`, `lname`, `email`, `phone`, `alt_phone`, `country`, `county`, `sub_county`, `constituency`, `location_ward`, `village`, `disabilities`, `status`, `created`, `updated`) VALUES
(1, 2, NULL, NULL, NULL, 'iotuya05@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2019-01-06 05:02:39', '2019-01-06 05:02:39'),
(2, 2, NULL, NULL, NULL, 'iotuya053@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2019-01-06 05:42:39', '2019-01-06 05:42:39'),
(3, 2, NULL, NULL, NULL, 'juma@iosas.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2019-01-06 16:53:33', '2019-01-06 16:53:33'),
(4, 2, NULL, NULL, NULL, 'ian@iosas.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2019-01-06 16:53:47', '2019-01-06 16:53:47'),
(5, 2, NULL, NULL, NULL, 'marry@iosas.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2019-01-06 16:54:04', '2019-01-06 16:54:04'),
(6, 2, NULL, NULL, NULL, 'kim@iosas.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2019-01-06 18:10:39', '2019-01-06 18:10:39'),
(7, 2, NULL, NULL, NULL, 'irene@iosas.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2019-01-06 18:11:08', '2019-01-06 18:40:06');

-- --------------------------------------------------------

--
-- Table structure for table `user_bio_records`
--

DROP TABLE IF EXISTS `user_bio_records`;
CREATE TABLE IF NOT EXISTS `user_bio_records` (
  `user` int(50) NOT NULL,
  `bp` text,
  `bmi` text,
  `diabetes` text,
  `malaria` text,
  `tb` text,
  `hiv` text,
  `sti` text,
  `weight` decimal(20,2) DEFAULT NULL,
  `height` decimal(20,2) DEFAULT NULL,
  `skin` varchar(30) DEFAULT NULL,
  `eyes` varchar(30) DEFAULT NULL,
  `genetic_disorder` text,
  `allergies` text,
  `climate_sensitivity` text,
  `created` timestamp NOT NULL,
  `updated` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_permisions`
--

DROP TABLE IF EXISTS `user_permisions`;
CREATE TABLE IF NOT EXISTS `user_permisions` (
  `user` int(50) NOT NULL,
  `perm` int(55) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_permisions`
--

INSERT INTO `user_permisions` (`user`, `perm`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(1, 11),
(1, 12),
(2, 11),
(2, 12),
(1, 13),
(2, 13);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
CREATE TABLE IF NOT EXISTS `user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_code` int(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `access_code`, `name`, `created`) VALUES
(1, 4444, 'Default', '2019-01-05 17:04:11'),
(2, 4455, 'Teacher', '2019-01-05 17:04:11'),
(3, 4466, 'Student', '2019-01-05 17:26:11'),
(4, 4477, 'Admin', '2019-01-05 17:26:11'),
(5, 1111, 'Super', '2019-01-05 17:28:04');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
