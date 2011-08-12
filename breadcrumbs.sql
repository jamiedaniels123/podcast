-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 12, 2011 at 02:32 PM
-- Server version: 5.1.52
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `podcast-admin-dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `breadcrumbs`
--

DROP TABLE IF EXISTS `breadcrumbs`;
CREATE TABLE IF NOT EXISTS `breadcrumbs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `breadcrumbs`
--

INSERT INTO `breadcrumbs` (`id`, `controller`, `action`, `parent_id`, `created`, `updated`, `title`, `url`) VALUES
(1, NULL, NULL, 0, '2011-06-20 10:55:18', '2011-06-20 10:55:18', 'Home', '/'),
(2, 'users', 'dashboard', 0, '2011-06-20 10:56:00', '2011-06-20 10:56:00', 'Dashboard', '/users/dashboard'),
(3, 'podcasts', 'index', 2, '2011-06-20 11:11:21', '2011-06-20 11:11:21', 'Collections', '/podcasts'),
(4, 'podcasts', 'view', 3, '2011-06-20 11:22:18', '2011-06-20 11:22:18', 'Podcast', '/podcasts/view/'),
(5, 'podcasts', 'edit', 3, '2011-06-20 11:22:44', '2011-06-20 11:22:44', 'Podcast', ''),
(6, 'podcasts', 'add', 3, '2011-06-20 11:23:12', '2011-06-20 11:23:12', 'Create', ''),
(8, 'user_groups', 'index', 2, '2011-06-20 11:26:34', '2011-06-20 11:26:34', 'Your User Groups', '/user_groups'),
(9, 'user_groups', 'view', 8, '2011-06-20 11:27:17', '2011-06-20 11:27:17', 'View', ''),
(10, 'user_groups', 'edit', 8, '2011-06-20 11:28:05', '2011-06-20 11:28:05', 'Edit', ''),
(11, 'user_groups', 'add', 8, '2011-06-20 11:29:09', '2011-06-20 11:29:09', 'Create', ''),
(15, 'users', 'admin_index', 2, '2011-06-20 14:48:21', '2011-06-20 14:48:21', 'User Administration', '/admin/users'),
(16, 'users', 'admin_edit', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Profile', ''),
(17, 'user_groups', 'admin_index', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'User Group Administration', '/admin/user_groups'),
(28, 'podcast_items', 'edit', 4, NULL, NULL, 'Track', '/podcast_items/edit/'),
(19, 'user_groups', 'admin_edit', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Edit', ''),
(20, 'user_groups', 'admin_view', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'View', ''),
(21, 'podcasts', 'admin_edit', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Podcast', '/admin/podcasts/edit/'),
(22, 'podcasts', 'admin_index', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Collections Administration', '/admin/podcasts'),
(27, 'podcast_items', 'view', 4, NULL, NULL, 'Track', '/podcast_items/view/'),
(23, 'podcasts', 'admin_view', 22, NULL, NULL, 'Podcast', '/admin/podcasts/view/'),
(26, 'podcasts', 'itunes_index', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'iTunes', '/itunes/podcasts/index'),
(25, 'podcasts', 'youtube_index', 2, NULL, NULL, 'Youtube', '/youtube/podcasts/index'),
(29, 'podcast_items', 'add', 4, NULL, NULL, 'Track', '/podcast_items/add/'),
(30, 'podcast_items', 'admin_view', 23, NULL, NULL, 'Track', '/admin/podcast_items/view/');
