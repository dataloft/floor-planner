-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 02, 2014 at 12:01 AM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- --------------------------------------------------------

--
-- Table structure for table `checked_flats`
--

CREATE TABLE `checked_flats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numb_flat` int(11) NOT NULL,
  `coords` varchar(255) NOT NULL,
  `floor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `checked_flats`
--

INSERT INTO `checked_flats` (`id`, `numb_flat`, `coords`, `floor_id`) VALUES
(27, 1, '82,66,105,233,178,205,194,96', 40),
(29, 2, '381,93,382,172,453,174,451,35,420,35,419,26,381,18', 39),
(33, 1, '40,18,41,94,111,95,111,2,73,1,72,20', 39),
(34, 7, '572,202,571,171,494,171,494,201', 39),
(35, 4, '143,20,142,96,173,95,175,20', 39),
(36, 22, '247,113,247,200,281,207,280,188,315,188,315,114', 39);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(5, '', 'test', '064161f8f1efd34ed8c7a39a3885eb7ab4424db0', NULL, 'test@test.test', NULL, NULL, NULL, '3edd35af0df1f94d8d8ff686d9136fd17cf3609e', 0, 1404244820, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `_blocks`
--

CREATE TABLE `_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numb_block` varchar(255) NOT NULL,
  `object_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `_blocks`
--

INSERT INTO `_blocks` (`id`, `numb_block`, `object_id`) VALUES
(15, 'Корпус 1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `_flats`
--

CREATE TABLE `_flats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numb_flat` int(11) NOT NULL,
  `full_area` float NOT NULL,
  `living_area` float NOT NULL,
  `kitchen_area` float NOT NULL,
  `floor` int(11) NOT NULL,
  `count_room` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `price` float NOT NULL,
  `sale_price` float NOT NULL,
  `wc_type` tinytext NOT NULL,
  `balcon` tinytext NOT NULL,
  `loggia` tinytext NOT NULL,
  `thumb` tinytext NOT NULL,
  `img` tinytext NOT NULL,
  `block_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `_flats`
--

INSERT INTO `_flats` (`id`, `numb_flat`, `full_area`, `living_area`, `kitchen_area`, `floor`, `count_room`, `status`, `price`, `sale_price`, `wc_type`, `balcon`, `loggia`, `thumb`, `img`, `block_id`) VALUES
(5, 2, 3, 6, 6, 7, 4, 4, 5, 66, 'sgs', 'w', 'w', '', '', 15),
(6, 2, 3, 6, 6, 7, 4, 4, 5, 666, 'sgs', 'да', 'да', '', '', 14),
(7, 323, 43, 56, 36, 47, 54, 2, 25, 33666, 'sgs', 'дак', 'дар', '', '', 14),
(8, 2, 3, 6, 6, 7, 4, 4, 5, 666, 'sgs', 'да', 'да', '', '', 14),
(9, 32, 43, 56, 36, 47, 54, 1, 25, 33666, 'sgs', 'w', 'w', '', '', 15),
(15, 3, 4, 5, 5, 2, 5, 2, 2, 5, 'dd', 'd', 'w', '', '', 15);

-- --------------------------------------------------------

--
-- Table structure for table `_floors`
--

CREATE TABLE `_floors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numb_floor` varchar(255) NOT NULL,
  `plan` varchar(255) NOT NULL,
  `block_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `_floors`
--

INSERT INTO `_floors` (`id`, `numb_floor`, `plan`, `block_id`) VALUES
(39, '1', '/public/layout/floors/8nowiwx0gnresd.png', 15),
(40, '2', '/public/layout/floors/vro5uayph70iqg.jpg', 15);

-- --------------------------------------------------------

--
-- Table structure for table `_objects`
--

CREATE TABLE `_objects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_object` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `_objects`
--

INSERT INTO `_objects` (`id`, `title_object`) VALUES
(1, 'Брусничное'),
(2, 'Ладожский берег');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
