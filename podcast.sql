-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 06, 2011 at 08:23 AM
-- Server version: 5.1.52
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `podcast`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_levels`
--

CREATE TABLE IF NOT EXISTS `access_levels` (
  `al` tinyint(4) NOT NULL DEFAULT '0',
  `access_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`al`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Access levels and staff roles';

--
-- Dumping data for table `access_levels`
--

INSERT INTO `access_levels` (`al`, `access_name`) VALUES
(9, 'System administrator'),
(1, 'Student'),
(2, 'Supervisor'),
(5, 'Discipline administrator'),
(6, 'Faculty administrator'),
(8, 'Administrator'),
(4, 'Research secretary'),
(7, 'Podcast Author');

-- --------------------------------------------------------

--
-- Table structure for table `breadcrumbs`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `breadcrumbs`
--

INSERT INTO `breadcrumbs` (`id`, `controller`, `action`, `parent_id`, `created`, `updated`, `title`, `url`) VALUES
(1, NULL, NULL, 0, '2011-06-20 10:55:18', '2011-06-20 10:55:18', 'Home', '/'),
(2, 'users', 'dashboard', 0, '2011-06-20 10:56:00', '2011-06-20 10:56:00', 'Dashboard', '/users/dashboard'),
(3, 'podcasts', 'index', 2, '2011-06-20 11:11:21', '2011-06-20 11:11:21', 'Collections', '/podcasts'),
(4, 'podcasts', 'view', 3, '2011-06-20 11:22:18', '2011-06-20 11:22:18', 'View', ''),
(5, 'podcasts', 'edit', 3, '2011-06-20 11:22:44', '2011-06-20 11:22:44', 'Edit', ''),
(6, 'podcasts', 'add', 3, '2011-06-20 11:23:12', '2011-06-20 11:23:12', 'Create', ''),
(7, 'podcasts', 'approve_index', 3, '2011-06-20 11:24:50', '2011-06-20 11:24:50', 'Podcasts Waiting Approval', '/approve/podcasts'),
(8, 'user_groups', 'index', 2, '2011-06-20 11:26:34', '2011-06-20 11:26:34', 'Your User Groups', '/user_groups'),
(9, 'user_groups', 'view', 8, '2011-06-20 11:27:17', '2011-06-20 11:27:17', 'View', ''),
(10, 'user_groups', 'edit', 8, '2011-06-20 11:28:05', '2011-06-20 11:28:05', 'Edit', ''),
(11, 'user_groups', 'add', 8, '2011-06-20 11:29:09', '2011-06-20 11:29:09', 'Create', ''),
(15, 'users', 'admin_index', 2, '2011-06-20 14:48:21', '2011-06-20 14:48:21', 'User Administration', '/admin/users'),
(16, 'users', 'admin_edit', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Edit', ''),
(17, 'user_groups', 'admin_index', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'User Group Administration', NULL),
(18, 'user_groups', 'admin_add', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Create', '/admin/user_groups/add'),
(19, 'user_groups', 'admin_edit', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Edit', ''),
(20, 'user_groups', 'admin_view', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'View', NULL),
(21, 'podcasts', 'admin_edit', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Edit', '/admin/podcasts/edit'),
(22, 'podcasts', 'admin_index', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Collections Administration', '/admin/podcasts'),
(24, 'podcasts', 'admin_add', 21, NULL, NULL, 'Add', '/admin/podcasts/add'),
(23, 'podcasts', 'admin_view', 22, NULL, NULL, 'View', '/admin/podcasts/view'),
(25, 'users', 'apply', 0, '2011-06-22 13:33:10', '2011-06-22 13:33:10', 'Apply to Join', ''),
(26, 'users', 'register', 0, '2011-06-22 13:49:36', '2011-06-22 13:49:36', 'Register', '');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) NOT NULL DEFAULT '0',
  `category` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='iTunes podcast categories' AUTO_INCREMENT=68 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `category`) VALUES
(1, 0, 'Arts'),
(2, 0, 'Business'),
(3, 0, 'Comedy'),
(4, 0, 'Education'),
(5, 0, 'Games & Hobbies'),
(6, 0, 'Government & Organizations'),
(7, 0, 'Health'),
(8, 0, 'Kids & Family'),
(9, 0, 'Music'),
(10, 0, 'News & Politics'),
(11, 0, 'Religion & Spirituality'),
(12, 0, 'Science & Medicine'),
(13, 0, 'Society & Culture'),
(14, 0, 'Sports & Recreation'),
(15, 0, 'Technology'),
(16, 0, 'TV & Film'),
(17, 1, 'Design'),
(18, 1, 'Fashion & Beauty'),
(19, 1, 'Food'),
(20, 1, 'Literature'),
(21, 1, 'Performing Arts'),
(22, 1, 'Visual Arts'),
(23, 2, 'Business News'),
(24, 2, 'Careers'),
(25, 2, 'Investing'),
(26, 2, 'Management & Market'),
(27, 2, 'Shopping'),
(28, 4, 'Education Technology'),
(29, 4, 'Higher Education'),
(30, 4, 'K-12'),
(31, 4, 'Language Courses'),
(32, 4, 'Training'),
(33, 5, 'Automotive'),
(34, 5, 'Aviation'),
(35, 5, 'Hobbies'),
(36, 5, 'Other Games'),
(37, 5, 'Video Games'),
(38, 6, 'Local'),
(39, 6, 'National'),
(40, 6, 'Non-Profit'),
(41, 6, 'Regional'),
(42, 7, 'Alternative Health'),
(43, 7, 'Fitness & Nutrition'),
(44, 7, 'Self-Help'),
(45, 7, 'Sexuality'),
(46, 11, 'Buddhism'),
(47, 11, 'Christianity'),
(48, 11, 'Hinduism'),
(49, 11, 'Islam'),
(50, 11, 'Judaism'),
(51, 11, 'Other'),
(52, 11, 'Spirituality'),
(53, 12, 'Medicine'),
(54, 12, 'Natural Sciences'),
(55, 12, 'Social Sciences'),
(56, 13, 'History'),
(57, 13, 'Personal Journals'),
(58, 13, 'Philosophy'),
(59, 13, 'Places & Travel'),
(60, 14, 'Amateur'),
(61, 14, 'College & High School'),
(62, 14, 'Outdoor'),
(63, 14, 'Professional'),
(64, 15, 'Gadgets'),
(65, 15, 'Tech News'),
(66, 15, 'Podcasting'),
(67, 15, 'Software How-To');

-- --------------------------------------------------------

--
-- Table structure for table `feed_hits_log`
--

CREATE TABLE IF NOT EXISTS `feed_hits_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feed` mediumint(8) unsigned DEFAULT NULL,
  `ip_address` varchar(32) DEFAULT NULL,
  `user_agent` varchar(100) DEFAULT NULL,
  `request` varchar(255) DEFAULT NULL,
  `response` smallint(6) NOT NULL DEFAULT '200',
  `timestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Log of hits on XML files' AUTO_INCREMENT=1103 ;

--
-- Dumping data for table `feed_hits_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `itunesu_categories`
--

CREATE TABLE IF NOT EXISTS `itunesu_categories` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(12) DEFAULT NULL,
  `code_title` varchar(32) DEFAULT NULL,
  `level` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='iTunes U Categories' AUTO_INCREMENT=116 ;

--
-- Dumping data for table `itunesu_categories`
--

INSERT INTO `itunesu_categories` (`id`, `code`, `code_title`, `level`) VALUES
(1, '100', 'Business', 0),
(2, '100100', 'Economics', 1),
(3, '100101', 'Finance', 1),
(4, '100102', 'Hospitality', 1),
(5, '100103', 'Management', 1),
(6, '100104', 'Marketing', 1),
(7, '100105', 'Personal Finance', 1),
(8, '100106', 'Real Estate', 1),
(9, '101', 'Engineering', 0),
(10, '101100', 'Chemical & Petroleum', 1),
(11, '101101', 'Civil', 1),
(12, '101102', 'Computer Science', 1),
(13, '101103', 'Electrical', 1),
(14, '101104', 'Environmental', 1),
(15, '101105', 'Mechanical', 1),
(16, '102', 'Fine Arts', 0),
(17, '102100', 'Architecture', 1),
(18, '102101', 'Art', 1),
(19, '102102', 'Art History', 1),
(20, '102103', 'Dance', 1),
(21, '102104', 'Film', 1),
(22, '102105', 'Graphic Design', 1),
(23, '102106', 'Interior Design', 1),
(24, '102107', 'Music', 1),
(25, '102108', 'Theater', 1),
(26, '103', 'Health & Medicine', 0),
(27, '103100', 'Anatomy & Physiology', 1),
(28, '103101', 'Behavioral Science', 1),
(29, '103102', 'Dentistry', 1),
(30, '103103', 'Diet & Nutrition', 1),
(31, '103104', 'Emergency', 1),
(32, '103105', 'Genetics', 1),
(33, '103106', 'Gerontology', 1),
(34, '103107', 'Health & Exercise Science', 1),
(35, '103108', 'Immunology', 1),
(36, '103109', 'Neuroscience', 1),
(37, '103110', 'Pharmacology & Toxicology', 1),
(38, '103111', 'Psychiatry', 1),
(39, '103112', 'Public Health', 1),
(40, '103113', 'Radiology', 1),
(41, '104', 'History', 0),
(42, '104100', 'Ancient', 1),
(43, '104101', 'Medieval', 1),
(44, '104102', 'Military', 1),
(45, '104103', 'Modern', 1),
(46, '104104', 'African', 1),
(47, '104105', 'Asian', 1),
(48, '104106', 'European', 1),
(49, '104107', 'Middle Eastern', 1),
(50, '104108', 'North American', 1),
(51, '104109', 'South American', 1),
(52, '105', 'Humanities', 0),
(53, '105100', 'Communications', 1),
(54, '105101', 'Philosophy', 1),
(55, '105102', 'Religion', 1),
(56, '106', 'Language', 0),
(57, '106100', 'African', 1),
(58, '106101', 'Ancient', 1),
(59, '106102', 'Asian', 1),
(60, '106103', 'Eastern European/Slavic', 1),
(61, '106104', 'English', 1),
(62, '106105', 'English Language Learners', 1),
(63, '106106', 'French', 1),
(64, '106107', 'German', 1),
(65, '106108', 'Italian', 1),
(66, '106109', 'Linguistics', 1),
(67, '106110', 'Middle Eastern', 1),
(68, '106111', 'Spanish & Portuguese', 1),
(69, '106112', 'Speech Pathology', 1),
(70, '107', 'Literature', 0),
(71, '107100', 'Anthologies', 1),
(72, '107101', 'Biography', 1),
(73, '107102', 'Classics', 1),
(74, '107103', 'Criticism', 1),
(75, '107104', 'Fiction', 1),
(76, '107105', 'Poetry', 1),
(77, '108', 'Mathematics', 0),
(78, '108100', 'Advanced Mathematics', 1),
(79, '108101', 'Algebra', 1),
(80, '108102', 'Arithmetic', 1),
(81, '108103', 'Calculus', 1),
(82, '108104', 'Geometry', 1),
(83, '108105', 'Statistics', 1),
(84, '109', 'Science', 0),
(85, '109100', 'Agricultural', 1),
(86, '109101', 'Astronomy', 1),
(87, '109102', 'Atmospheric', 1),
(88, '109103', 'Biology', 1),
(89, '109104', 'Chemistry', 1),
(90, '109105', 'Ecology', 1),
(91, '109106', 'Geography', 1),
(92, '109107', 'Geology', 1),
(93, '109108', 'Physics', 1),
(94, '110', 'Social Science', 0),
(95, '110100', 'Law', 1),
(96, '110101', 'Political Science', 1),
(97, '110102', 'Public Administration', 1),
(98, '110103', 'Psychology', 1),
(99, '110104', 'Social Welfare', 1),
(100, '110105', 'Sociology', 1),
(101, '111', 'Society', 0),
(102, '111100', 'African-American Studies', 1),
(103, '111101', 'Asian Studies', 1),
(104, '111102', 'European & Russian Studies', 1),
(105, '111103', 'Indigenous Studies', 1),
(106, '111104', 'Latin & Caribbean Studies', 1),
(107, '111105', 'Middle Eastern Studies', 1),
(108, '111106', 'Women''s Studies', 1),
(109, '112', 'Teaching & Education', 0),
(110, '112100', 'Curriculum & Teaching', 1),
(111, '112101', 'Educational Leadership', 1),
(112, '112102', 'Family & Childcare', 1),
(113, '112103', 'Learning Resources', 1),
(114, '112104', 'Psychology & Research', 1),
(115, '112105', 'Special Education', 1);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `lang_code` varchar(6) NOT NULL DEFAULT '',
  `language` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`lang_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Languages';

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`lang_code`, `language`) VALUES
('en-gb', 'English (GB)'),
('es', 'Spanish'),
('it', 'Italian'),
('fr', 'French'),
('en', 'English'),
('en-us', 'English (US)'),
('de', 'German');

-- --------------------------------------------------------

--
-- Table structure for table `media_hits_log`
--

CREATE TABLE IF NOT EXISTS `media_hits_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feed` mediumint(8) unsigned DEFAULT NULL,
  `item_id` mediumint(8) unsigned DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `ip_address` varchar(32) DEFAULT NULL,
  `user_agent` varchar(100) DEFAULT NULL,
  `response` smallint(6) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Log of hits on feed items' AUTO_INCREMENT=569 ;

--
-- Dumping data for table `media_hits_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `endnode` set('Y','N') NOT NULL DEFAULT 'N',
  `title` varchar(150) DEFAULT NULL,
  `description` text,
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hide` set('N','Y') NOT NULL DEFAULT 'N',
  `subject_code` varchar(16) DEFAULT NULL,
  `subject_url_name` varchar(150) DEFAULT NULL,
  `openlearn_url` varchar(150) DEFAULT NULL COMMENT 'Mapping from blue list to OpenLearn; initially used for YouTube migration',
  `use_of_subject` varchar(150) DEFAULT NULL,
  `banner_image` varchar(150) DEFAULT NULL,
  `course_image` varchar(150) DEFAULT NULL,
  `added_by` varchar(24) DEFAULT NULL,
  `added_when` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Nodes' AUTO_INCREMENT=79 ;

--
-- Dumping data for table `nodes`
--

INSERT INTO `nodes` (`id`, `parent_id`, `endnode`, `title`, `description`, `level`, `hide`, `subject_code`, `subject_url_name`, `openlearn_url`, `use_of_subject`, `banner_image`, `course_image`, `added_by`, `added_when`) VALUES
(1, 0, 'N', 'OU Learn', 'Want to get a qualification that will help you develop or change your career? Learn a subject in depth? The Open University â€“ voted top for student satisfaction for three years running â€“ could provide the flexibility, the qualifications and the top-class teaching you''re after. For most courses you don''t need any previous qualifications. And with our world-leading blend of supported open learning and innovative course materials, you''ll get an exceptional learning experience.', 0, 'N', 'OULRN', 'oulearn', 'http://www.open.ac.uk/openlearn/', NULL, NULL, NULL, NULL, NULL),
(2, 0, 'N', 'OU Research', 'The founding Chancellor of the Open University, Lord Crowther, proclaimed that The Open University would be open as to people, open as to places and open as to methods and ideas, and this holds true as much for our distinctive research as it does for our teaching methods.', 0, 'N', 'OURES', 'ouresearch', 'http://www.open.ac.uk/openlearn/', NULL, NULL, NULL, NULL, NULL),
(3, 0, 'N', 'OU Life', 'Our mission \r\nThe Open University is open to people, places, methods and ideas. It promotes educational opportunity and social justice by providing high-quality university education to all who wish to realise their ambitions and fulfil their potential. Through academic research, pedagogic innovation and collaborative partnership it seeks to be a world leader in the design, content and delivery of supported open and distance learning.', 0, 'N', 'OULIFE', 'oulife', 'http://www.open.ac.uk/openlearn/', NULL, NULL, NULL, NULL, NULL),
(4, 0, 'N', 'OU Faculties', 'Podcasts on a wide variety of subjects recorded for the Faculties and Departments of the Open University.', 0, 'Y', NULL, 'oufaculties', 'http://www.open.ac.uk/openlearn/', NULL, NULL, NULL, NULL, NULL),
(5, 1, 'N', 'Arts and Humanities', 'Arts and Humanities encompass subjects that are all concerned with cultural expression and how it has come to take the forms that exist today. They include Art History; Classical Studies; English; History (incorporating History of Science, Technology and Medicine); Music; Philosophy; Religious Studies; African and Asian Studies; and Comparative Criminological Research. Studying in the arts and humanities enables you to explore human culture and its history, from the ancient civilisations of Greece and Rome through the Renaissance, to the twenty-first century. In the process you will gain important analytical and critical skills needed for a wide range of occupations.', 1, 'N', 'AHU   ', 'arts-and-humanities', 'http://www.open.ac.uk/openlearn/history-the-arts', NULL, NULL, NULL, NULL, NULL),
(6, 1, 'N', 'Business and Management', 'Our highly-respected business and management courses will allow you to develop and extend your knowledge, skills and practice â€“ whether youâ€™re looking for a one-off piece of professional updating or a qualification: 75 per cent of the FTSE 100 companies have sponsored OU students. We offer foundation degrees in Business, or Leadership & Management, and a major new Business Studies certificate. You can study accounting, economics, French, ICT, law, Spanish or systems practice as part of our innovative and well-respected Business Studies degree, or use our specialist courses in finance and accounting to provide a route into the accounting profession. ', 1, 'N', 'BMA   ', 'business-and-management', 'http://www.open.ac.uk/openlearn/money-management ', NULL, NULL, NULL, NULL, NULL),
(7, 1, 'N', 'The Open Programme', 'An Open degree is a BA or BSc degree where you choose the courses and subjects that you study. As an alternative to a degree in a named subject, such as computing or history, the Open degree lets you create a degree that''s tailored to your own requirements.', 1, 'Y', 'BOP   ', 'open-programme', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 'N', 'Computing and ICT', 'Virtually everything we do involves information and communication technologies (ICTs) â€“ from booking tickets online and emailing friends, to paying by credit card and using household appliances. At the heart of ICTs are computers â€“ ranging from microprocessors in mobile phones, through personal computers, to large internet servers and mainframes. Most of us simply take these technologies for granted, yet understanding how they work is fascinating. Whether you simply have an enquiring mind, or want to learn more about this fast growing field in order to change career direction or improve your prospects, the OU offers a wide range of courses.', 1, 'N', 'CIT   ', 'computing-and-ict', 'http://www.open.ac.uk/openlearn/science-maths-technology/computing-and-ict ', NULL, NULL, NULL, NULL, NULL),
(9, 1, 'N', 'Childhood and Youth', 'Looking at the world from a childâ€™s or young personâ€™s point of view isnâ€™t always easy. If you want to work with children or young people we offer a wide choice of one-off courses and qualifications that cover the full age range and can help your career. Start slowly, if it suits, and go as far as you need. We offer certificates and degrees from the early years through adolescence to young adulthood. By studying with us you can increase your awareness of what it really means for children growing up in todayâ€™s world, and become more effective in your role.', 1, 'N', 'CYS   ', 'childhood-and-youth', 'http://www.open.ac.uk/openlearn/body-mind/childhood-youth ', NULL, NULL, NULL, NULL, NULL),
(10, 1, 'N', 'Environment, Development and International Studies', 'Climate change, global trade, war, cultural conflict, biodiversity, energy, water and food sourcing, poverty and the challenges of international development are among the defining features of our times. With our courses and qualifications you can explore some of the most challenging trends and developments that are shaping our world and the individuals who inhabit it. You''ll become a more enlightened citizen. And on a professional level you could make a real difference with your highly valued skills, which could lead to many exciting career options in policy making, corporate responsibility or environmental services.', 1, 'N', 'EDI   ', 'environment-development-and-international-studies', 'http://www.open.ac.uk/openlearn/nature-environment/the-environment ', NULL, NULL, NULL, NULL, NULL),
(11, 1, 'N', 'Education', 'Education offers the exciting prospect of making a difference. Itâ€™s important both for individual success and societyâ€™s continuing development. With the changes now taking place to widen participation and strengthen teaching and learning at all levels, education is â€“ more than ever â€“ a dynamic, challenging and rewarding sector to be involved in. The OU has been delivering education courses for over 25 years and now offers a wide range of professional and undergraduate qualifications for practicing teachers, plus general courses to help you support your own child in school. ', 1, 'N', 'EDU   ', 'education', 'http://www.open.ac.uk/openlearn/education', NULL, NULL, NULL, NULL, NULL),
(12, 1, 'N', 'Engineering and Technology', 'If you enjoy solving problems and have a good imagination youâ€™ll find engineering and technology stimulating and challenging fields of study. Our cutting-edge range of courses enable you to explore how innovation, design, engineering technology, systems and people interact. A qualification in any of these areas can lead to exciting career opportunities in business and industry, as well as in the public and voluntary sectors in the UK and further afield. Employers value highly the numerical skills, creativity, scientific knowledge and team-working experience that engineering and technology graduates possess.', 1, 'N', 'ETE   ', 'engineering-and-technology', 'http://www.open.ac.uk/openlearn/science-maths-technology/engineering-and-technology ', NULL, NULL, NULL, NULL, NULL),
(13, 1, 'N', 'Health and Social Care', 'Health and social care is a vast service sector undergoing rapid change, with new government initiatives giving it a higher profile than ever. Priorities on the healthcare agenda include being more responsive to patient needs, and preventing illness by promoting a healthy lifestyle. The focus in frontline health and social care is on giving service-users more independence, choice and control. These developments mean thereâ€™s greater demand for well-trained and multi-skilled people across a range of rewarding employment opportunities. Our courses cover topics ranging from health sciences, health studies, nursing, public health, social care, social work and sport and fitness.', 1, 'N', 'HSC   ', 'health-and-social-care', 'http://www.open.ac.uk/openlearn/body-mind ', NULL, NULL, NULL, NULL, NULL),
(14, 1, 'N', 'Languages', 'Do you want to communicate in another language? Gain an insight into other cultures? Maybe you regret not having pursued language studies at school? Or perhaps language skills will get you the job of your dreams? In our increasingly global economy, being able to communicate effectively with our customers, colleagues and business partners is critical. Learning a modern language is also enjoyable and rewarding. We offer courses in French, German, Spanish, Italian and Welsh and a number of courses about the English language, its history and how it has changed in response to different cultural, social, technological and geographical pressures.', 1, 'N', 'LAN   ', 'languages', 'http://www.open.ac.uk/openlearn/languages', NULL, NULL, NULL, NULL, NULL),
(15, 1, 'N', 'Law', 'Law is a foundation stone of society and plays an increasingly important and visible role in virtually all areas of modern life. Social and environmental responsibilities, business operations and international codes of conduct are all determined and upheld by legal systems. We offer a range of degree programmes and short courses in law to a very wide variety of people from all areas of life. Our courses have been praised by senior judges, eminent lawyers and internationally acclaimed legal academics. For the last two years our law degree has been ranked within the top six in the National Student Survey.', 1, 'N', 'LAW   ', 'law', 'http://www.open.ac.uk/openlearn/society/the-law', NULL, NULL, NULL, NULL, NULL),
(16, 1, 'N', 'Mathematics and Statistics', 'Mathematics and statistics play a part in almost all daily activities. They are at the heart of advances in science and technology, as well as providing indispensable problem-solving and decision-making tools in many areas of life. They underpin the rigorous analysis and modelling required for new policies, designs and systems. Mathematical and statistical knowledge is much sought after by employers for a wide variety of jobs, not least in teaching the subject, and a qualification in any one of the areas we offer can bring real benefits in your professional life.', 1, 'N', 'MST   ', 'mathematics-and-statistics', 'http://www.open.ac.uk/openlearn/science-maths-technology/mathematics-and-statistics', NULL, NULL, NULL, NULL, NULL),
(17, 1, 'N', 'Psychology', 'Weâ€™re all interested in what makes people tick, how they think, act and interact with others. Thatâ€™s why studying psychology â€“ the science of human behavior â€“ is interesting in its own right. But it can also help develop a range of widely applicable transferable skills.  As well as gaining an understanding of ideas, theories and methods in psychology, and learning how to analyze and evaluate psychological concepts, you will develop skills in assessing different kinds of evidence, including both quantitative and qualitative data leading to opportunities in education, industry, the health professions, management, advertising and marketing, human resources, research, counseling, and social services.', 1, 'N', 'PSY   ', 'psychology', 'http://www.open.ac.uk/openlearn/body-mind/psychology', NULL, NULL, NULL, NULL, NULL),
(18, 1, 'N', 'Science', 'The more you look into science, the more fascinating it becomes. Advances in areas such as communications, food production, health care and transport all depend on fresh knowledge emerging from scienceâ€™s many disciplines. Studying science will enhance your understanding of the world, and contribute to your intellectual and personal development. The depth and breadth of our courses encompass topics such as biology, chemistry, earth and environmental science, geology, physics, and planetary and space sciences (including astronomy).', 1, 'N', 'SCI   ', 'science', 'http://www.open.ac.uk/openlearn/science-maths-technology/science', NULL, NULL, NULL, NULL, NULL),
(19, 1, 'N', 'Social Sciences', 'Many social science subjects provide fascinating insights into everyday life in our communities, families and workplaces. Topics include criminology, economics, geography, media studies, politics, psychology, social policy and sociology. In our courses youâ€™ll engage with some of the most compelling and contested questions in contemporary society: How do we communicate with each other? Why do places carry meaning for people? What are our rights as citizens? What shapes our identity and why? Our courses will stimulate your curiosity, encourage you to ask questions and challenge assumptions, and help you understand yourself â€“ and the world we live in â€“ more deeply.', 1, 'N', 'SSC   ', 'social-sciences', 'http://www.open.ac.uk/openlearn/society ', NULL, NULL, NULL, NULL, NULL),
(20, 1, 'N', 'Accounting and Finance', NULL, 2, 'N', 'ACCFIN', 'accounting-and-finance', NULL, NULL, NULL, NULL, NULL, NULL),
(21, 1, 'N', 'Biology', NULL, 2, 'N', 'BIOL  ', 'biology', NULL, NULL, NULL, NULL, NULL, NULL),
(22, 1, 'N', 'Business Management Studies', NULL, 2, 'N', 'BMSTU ', 'business-management-studies', NULL, NULL, NULL, NULL, NULL, NULL),
(23, 1, 'N', 'The Open Programme', NULL, 2, 'N', 'BOP   ', 'open-programme', NULL, NULL, NULL, NULL, NULL, NULL),
(24, 1, 'N', 'Chemistry', NULL, 2, 'N', 'CHEM  ', 'chemistry', NULL, NULL, NULL, NULL, NULL, NULL),
(25, 1, 'N', 'Classical Studies', NULL, 2, 'N', 'CLSSTU', 'classical-studies', NULL, NULL, NULL, NULL, NULL, NULL),
(26, 1, 'N', 'Computing', NULL, 2, 'N', 'COMP  ', 'computing', NULL, NULL, NULL, NULL, NULL, NULL),
(27, 1, 'N', 'Criminology', NULL, 2, 'N', 'CRIM  ', 'criminology', NULL, NULL, NULL, NULL, NULL, NULL),
(28, 1, 'N', 'Children and Young People', NULL, 2, 'N', 'CYP   ', 'children-and-young-people', NULL, NULL, NULL, NULL, NULL, NULL),
(29, 1, 'N', 'Childhood and Youth Studies', NULL, 2, 'N', 'CYSTU ', 'childhood-and-youth-studies', NULL, NULL, NULL, NULL, NULL, NULL),
(30, 1, 'N', 'Design and Innovation', NULL, 2, 'N', 'DESINN', 'design-and-innovation', NULL, NULL, NULL, NULL, NULL, NULL),
(31, 1, 'N', 'Economics', NULL, 2, 'N', 'ECON  ', 'economics', NULL, NULL, NULL, NULL, NULL, NULL),
(32, 1, 'N', 'Educational Technology and Practice', NULL, 2, 'N', 'EDUTP ', 'educational-technology-and-practice', NULL, NULL, NULL, NULL, NULL, NULL),
(33, 1, 'N', 'English Language', NULL, 2, 'N', 'ENGLAN', 'english-language', NULL, NULL, NULL, NULL, NULL, NULL),
(34, 1, 'N', 'Engineering', NULL, 2, 'N', 'ENGN  ', 'engineering', NULL, NULL, NULL, NULL, NULL, NULL),
(35, 1, 'N', 'Environmental Decision Making', NULL, 2, 'N', 'ENVDM ', 'environmental-decision-making', NULL, NULL, NULL, NULL, NULL, NULL),
(36, 1, 'N', 'Environmental Science', NULL, 2, 'N', 'ENVSCI', 'environmental-science', NULL, NULL, NULL, NULL, NULL, NULL),
(37, 1, 'N', 'Environmental Studies', NULL, 2, 'N', 'ENVSTU', 'environmental-studies', NULL, NULL, NULL, NULL, NULL, NULL),
(38, 1, 'N', 'Early Years', NULL, 2, 'N', 'EY    ', 'early-years', NULL, NULL, NULL, NULL, NULL, NULL),
(39, 1, 'N', 'French', NULL, 2, 'N', 'FREN  ', 'french', NULL, NULL, NULL, NULL, NULL, NULL),
(40, 1, 'N', 'Geography', NULL, 2, 'N', 'GEOG  ', 'geography', NULL, NULL, NULL, NULL, NULL, NULL),
(41, 1, 'N', 'Geology', 'Why do earthquakes occur where they do? How is gold formed? What shapes the landscape? How did dinosaurs become extinct? If youâ€™re intrigued by the Earthâ€™s structure, composition and development over time, studying geology with the OU will feed your interest and imagination.', 2, 'N', 'GEOL  ', 'geology', NULL, NULL, NULL, NULL, NULL, NULL),
(42, 1, 'N', 'German', NULL, 2, 'N', 'GERM  ', 'german', NULL, NULL, NULL, NULL, NULL, NULL),
(43, 1, 'N', 'Global Development Management', NULL, 2, 'N', 'GLOBDM', 'global-development-management', NULL, NULL, NULL, NULL, NULL, NULL),
(44, 1, 'N', 'History', NULL, 2, 'N', 'HIS   ', 'history', NULL, NULL, NULL, NULL, NULL, NULL),
(45, 1, 'N', 'History of Art', NULL, 2, 'N', 'HISART', 'history-of-art', NULL, NULL, NULL, NULL, NULL, NULL),
(46, 1, 'N', 'History of Science, Technology and Medicine', NULL, 2, 'N', 'HISSTM', 'history-of-science-technology-and-medicine', NULL, NULL, NULL, NULL, NULL, NULL),
(47, 1, 'N', 'Health Sciences', NULL, 2, 'N', 'HTHSCI', 'health-sciences', NULL, NULL, NULL, NULL, NULL, NULL),
(48, 1, 'N', 'Health Studies', NULL, 2, 'N', 'HTHSTU', 'health-studies', NULL, NULL, NULL, NULL, NULL, NULL),
(49, 1, 'N', 'Information and Communication Technologies', NULL, 2, 'N', 'ICT   ', 'ict', NULL, NULL, NULL, NULL, NULL, NULL),
(50, 1, 'N', 'International Studies', NULL, 2, 'N', 'INTSTU', 'international-studies', NULL, NULL, NULL, NULL, NULL, NULL),
(51, 1, 'N', 'Law', NULL, 2, 'N', 'LAW   ', 'law', NULL, NULL, NULL, NULL, NULL, NULL),
(52, 1, 'N', 'Literature and Creative Writing', NULL, 2, 'N', 'LITCW ', 'literature-and-creative-writing', NULL, NULL, NULL, NULL, NULL, NULL),
(53, 1, 'N', 'Mathematics', NULL, 2, 'N', 'MATH  ', 'mathematics', NULL, NULL, NULL, NULL, NULL, NULL),
(54, 1, 'N', 'Mathematics Education', NULL, 2, 'N', 'MATHED', 'mathematics-education', NULL, NULL, NULL, NULL, NULL, NULL),
(55, 1, 'N', 'Media Studies', NULL, 2, 'N', 'MEDSTU', 'media-studies', NULL, NULL, NULL, NULL, NULL, NULL),
(56, 1, 'N', 'More Languages', NULL, 2, 'N', 'MORLAN', 'more-languages', NULL, NULL, NULL, NULL, NULL, NULL),
(57, 1, 'N', 'Music', NULL, 2, 'N', 'MUS   ', 'music', NULL, NULL, NULL, NULL, NULL, NULL),
(58, 1, 'N', 'Nursing', NULL, 2, 'N', 'NURS  ', 'nursing', NULL, NULL, NULL, NULL, NULL, NULL),
(59, 1, 'N', 'Professional Development in Education', NULL, 2, 'N', 'PDE   ', 'professional-development-in-education', NULL, NULL, NULL, NULL, NULL, NULL),
(60, 1, 'N', 'PGCE', NULL, 2, 'N', 'PGCE  ', 'pgce', NULL, NULL, NULL, NULL, NULL, NULL),
(61, 1, 'N', 'Philosophy', 'Everyone thinks about the meaning of life from time to time. But studying philosophy gives you the opportunity to ponder the big questions. What is reality? Do emotions conflict with reason? How do we reconcile different world views? The OUâ€™s philosophy programme is based broadly on the Anglo-American tradition and gives you a choice of different study options.', 2, 'N', 'PHIL  ', 'philosophy', NULL, NULL, NULL, NULL, NULL, NULL),
(62, 1, 'N', 'Physics and Astronomy', NULL, 2, 'N', 'PHYAST', 'physics-and-astronomy', NULL, NULL, NULL, NULL, NULL, NULL),
(63, 1, 'N', 'Politics', NULL, 2, 'N', 'POL   ', 'politics', NULL, NULL, NULL, NULL, NULL, NULL),
(64, 1, 'N', 'Psychology', NULL, 2, 'N', 'PSY   ', 'psychology', NULL, NULL, NULL, NULL, NULL, NULL),
(65, 1, 'N', 'Psychological Studies', NULL, 2, 'N', 'PSYSTU', 'psychological-studies', NULL, NULL, NULL, NULL, NULL, NULL),
(66, 1, 'N', 'Public Health', NULL, 2, 'N', 'PUBHTH', 'public-health', NULL, NULL, NULL, NULL, NULL, NULL),
(67, 1, 'N', 'Religious Studies', NULL, 2, 'N', 'RELSTU', 'religious-studies', NULL, NULL, NULL, NULL, NULL, NULL),
(68, 1, 'N', 'Social Care', NULL, 2, 'N', 'SOCARE', 'social-care', NULL, NULL, NULL, NULL, NULL, NULL),
(69, 1, 'N', 'Sociology', NULL, 2, 'N', 'SOCY  ', 'sociology', NULL, NULL, NULL, NULL, NULL, NULL),
(70, 1, 'N', 'Social Policy', NULL, 2, 'N', 'SOPOLY', 'social-policy', NULL, NULL, NULL, NULL, NULL, NULL),
(71, 1, 'N', 'Social Work', NULL, 2, 'N', 'SOWORK', 'social-work', NULL, NULL, NULL, NULL, NULL, NULL),
(72, 1, 'N', 'Spanish', NULL, 2, 'N', 'SPAN  ', 'spanish', NULL, NULL, NULL, NULL, NULL, NULL),
(73, 1, 'N', 'Sport and Fitness', NULL, 2, 'N', 'SPOFIT', 'sport-and-fitness', NULL, NULL, NULL, NULL, NULL, NULL),
(74, 1, 'N', 'Statistics', NULL, 2, 'N', 'STAT  ', 'statistics', NULL, NULL, NULL, NULL, NULL, NULL),
(75, 1, 'N', 'Systems', NULL, 2, 'N', 'SYST  ', 'systems', NULL, NULL, NULL, NULL, NULL, NULL),
(76, 1, 'N', 'Technology', NULL, 2, 'N', 'TECH  ', 'technology', NULL, NULL, NULL, NULL, NULL, NULL),
(77, 1, 'N', 'Technology Management', NULL, 2, 'N', 'TECHMA', 'technology-management', NULL, NULL, NULL, NULL, NULL, NULL),
(78, 1, 'N', 'Working with Young People', NULL, 2, 'N', 'WYP   ', 'working-with-young-people', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `node_links`
--

CREATE TABLE IF NOT EXISTS `node_links` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(8) unsigned NOT NULL,
  `child_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

--
-- Dumping data for table `node_links`
--

INSERT INTO `node_links` (`id`, `parent_id`, `child_id`) VALUES
(1, 1, 5),
(2, 1, 6),
(3, 1, 7),
(4, 1, 8),
(5, 1, 9),
(6, 1, 10),
(7, 1, 11),
(8, 1, 12),
(9, 1, 13),
(10, 1, 14),
(11, 1, 15),
(12, 1, 16),
(13, 1, 17),
(14, 1, 18),
(15, 1, 19),
(16, 6, 20),
(17, 18, 21),
(18, 6, 22),
(19, 18, 24),
(20, 5, 25),
(40, 12, 34),
(39, 14, 33),
(38, 5, 33),
(37, 11, 32),
(36, 19, 31),
(35, 12, 30),
(34, 9, 29),
(33, 13, 28),
(32, 19, 27),
(31, 8, 26),
(41, 10, 35),
(42, 10, 36),
(43, 18, 36),
(44, 10, 37),
(45, 9, 38),
(46, 14, 39),
(47, 19, 40),
(48, 18, 41),
(49, 14, 42),
(50, 6, 43),
(51, 10, 43),
(52, 5, 44),
(53, 5, 45),
(54, 5, 46),
(55, 13, 46),
(56, 18, 46),
(57, 13, 47),
(58, 18, 47),
(59, 13, 48),
(60, 12, 49),
(61, 10, 50),
(62, 5, 52),
(63, 16, 53),
(64, 11, 54),
(65, 16, 54),
(66, 5, 55),
(67, 19, 55),
(68, 14, 56),
(69, 5, 57),
(70, 13, 58),
(71, 11, 59),
(72, 11, 60),
(73, 5, 61),
(74, 18, 62),
(75, 19, 63),
(76, 19, 65),
(77, 13, 66),
(78, 18, 66),
(79, 5, 67),
(80, 13, 68),
(81, 19, 69),
(82, 19, 70),
(83, 13, 71),
(84, 14, 72),
(85, 13, 73),
(86, 16, 74),
(87, 6, 75),
(88, 8, 75),
(89, 12, 75),
(90, 12, 76),
(91, 6, 77),
(92, 12, 77),
(93, 9, 78),
(94, 0, 1),
(95, 0, 2),
(96, 0, 3),
(97, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='User Group Permissions' AUTO_INCREMENT=35 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `created`, `modified`) VALUES
(1, 'Populate Custom ID', '2011-05-09 13:52:30', '2011-05-09 13:52:30'),
(2, 'Populate iTunes U Publish Date', '2011-05-09 13:52:53', '2011-05-09 13:52:53'),
(3, 'Populate iTunes U Updated Date', '2011-05-09 13:53:01', '2011-05-09 13:53:01'),
(4, 'Populate iTunes U Date', '2011-05-09 13:53:10', '2011-05-09 13:53:10'),
(5, 'Populate Production Date', '2011-05-09 13:53:19', '2011-05-09 13:53:19'),
(6, 'Populate Rights Date', '2011-05-09 13:53:28', '2011-05-09 13:53:28'),
(7, 'Populate Metadata Date', '2011-05-09 13:53:35', '2011-05-09 13:53:35'),
(8, 'iTunes U URL', '2011-05-09 13:53:44', '2011-05-09 13:53:44'),
(9, 'Populate Unique ID', '2011-05-09 13:53:55', '2011-05-09 13:53:55'),
(10, 'Populate Intended for iTunes U', '2011-05-09 13:54:13', '2011-05-09 13:54:13'),
(11, 'Populate iTunes Site', '2011-05-09 13:54:26', '2011-05-09 13:54:26'),
(12, 'Populate Nodes', '2011-05-09 13:54:34', '2011-05-09 13:54:34'),
(13, 'Populate Title', '2011-05-09 13:54:42', '2011-05-09 13:54:42'),
(14, 'Populate Summary', '2011-05-09 13:54:49', '2011-05-09 13:54:49'),
(15, 'Populate Author', '2011-05-09 13:54:57', '2011-05-09 13:54:57'),
(16, 'Populate iTunes Categories', '2011-05-09 13:55:05', '2011-05-09 13:55:05'),
(17, 'Populate iTunes U Categories', '2011-05-09 13:55:12', '2011-05-09 13:55:12'),
(18, 'Populate iTunes Subtitle', '2011-05-09 13:55:21', '2011-05-09 13:55:21'),
(19, 'Populate Web URL', '2011-05-09 13:55:28', '2011-05-09 13:55:28'),
(20, 'Populate Web Link Text', '2011-05-09 13:55:36', '2011-05-09 13:55:36'),
(21, 'Populate Course Code', '2011-05-09 13:55:45', '2011-05-09 13:55:45'),
(22, 'Populate Copyright', '2011-05-09 13:55:59', '2011-05-09 13:55:59'),
(23, 'Populate Language', '2011-05-09 13:56:08', '2011-05-09 13:56:08'),
(24, 'Populate iTunes Explicit', '2011-05-09 13:56:18', '2011-05-09 13:56:18'),
(25, 'Populate Keywords', '2011-05-09 13:56:25', '2011-05-09 13:56:25'),
(26, 'Populate Owner Name', '2011-05-09 13:56:35', '2011-05-09 13:56:35'),
(27, 'Populate User Group', '2011-05-09 13:56:45', '2011-05-09 13:56:45'),
(28, 'Populate Podcast Image', '2011-05-09 13:56:54', '2011-05-09 13:56:54'),
(29, 'Populate Podcast Logoless Image', '2011-05-09 13:57:00', '2011-05-09 13:57:00'),
(30, 'Populate Logoless Copyright/Credit', '2011-05-09 13:57:13', '2011-05-09 13:57:13'),
(31, 'Populate Podcast Widescreen Image', '2011-05-09 13:57:22', '2011-05-09 13:57:22'),
(32, 'Populate Widescreen Copyright/Credit', '2011-05-09 13:58:50', '2011-05-09 13:58:50'),
(33, 'Populate Private', '2011-05-09 13:59:10', '2011-05-09 13:59:10'),
(34, 'Populate Intranet SAMS Only', '2011-05-09 13:59:30', '2011-05-09 13:59:30');

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

CREATE TABLE IF NOT EXISTS `permission_groups` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `members` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Permission group definitions' AUTO_INCREMENT=37 ;

--
-- Dumping data for table `permission_groups`
--

INSERT INTO `permission_groups` (`id`, `title`, `members`, `created`, `modified`, `description`) VALUES
(36, 'itunes group', '', '2011-05-09 14:56:54', '2011-05-09 15:54:31', 'hellow orld');

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups_permissions`
--

CREATE TABLE IF NOT EXISTS `permission_groups_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `permission_groups_permissions`
--

INSERT INTO `permission_groups_permissions` (`id`, `permission_group_id`, `permission_id`, `created`) VALUES
(32, 36, 1, NULL),
(33, 36, 2, NULL),
(34, 36, 3, NULL),
(35, 36, 4, NULL),
(36, 36, 5, NULL),
(37, 36, 6, NULL),
(38, 36, 7, NULL),
(39, 36, 8, NULL),
(40, 36, 9, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `podcasts`
--

CREATE TABLE IF NOT EXISTS `podcasts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `grouping` varchar(24) NOT NULL COMMENT 'for podcasts imported from spreadsheet; called unique id on podcast form',
  `title` varchar(255) DEFAULT NULL COMMENT 'Podcast title',
  `summary` text COMMENT 'Podcast description',
  `image` varchar(150) DEFAULT NULL COMMENT 'Normal podcast image file',
  `image_copyright` varchar(150) NOT NULL,
  `image_source` varchar(255) NOT NULL,
  `image_logoless` varchar(150) DEFAULT NULL COMMENT 'Logoless image file for OpenLearn',
  `image_ll_copyright` varchar(150) DEFAULT NULL COMMENT 'Copyright or credit for logoless image',
  `image_wide` varchar(150) DEFAULT NULL COMMENT 'Wide format image',
  `image_wide_copyright` varchar(150) DEFAULT NULL COMMENT 'Copyright or credit for wide image',
  `artwork_file` varchar(100) DEFAULT NULL COMMENT 'ZIP archive of podcast artwork for Apple',
  `author` varchar(255) DEFAULT NULL,
  `itunes_u_url` varchar(200) DEFAULT NULL COMMENT 'iTunes unique URL',
  `language` varchar(50) NOT NULL DEFAULT 'en',
  `explicit` set('yes','no','clean') NOT NULL DEFAULT 'no',
  `keywords` text COMMENT 'Comma-delimited',
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `subtitle` text,
  `link` varchar(250) DEFAULT NULL COMMENT 'Related website URL',
  `link_text` varchar(50) DEFAULT NULL COMMENT 'Related website title or description',
  `course_code` varchar(12) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL COMMENT 'Copyright statement for entire podcast',
  `rss_url` varchar(150) DEFAULT NULL COMMENT 'Populated with remote RSS URL for agregating content - legacy funcationality that is no longer supported but this field is tested in the code',
  `custom_id` varchar(50) DEFAULT NULL COMMENT 'Custom feed name; forms part of URL',
  `private` set('N','Y') NOT NULL DEFAULT 'N',
  `intranet_only` set('N','Y') NOT NULL DEFAULT 'N',
  `media_location` set('local','s3nonOU','s3all') NOT NULL DEFAULT 'local' COMMENT 'Location of media files',
  `publish_itunes_u` set('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Flag indicates whether the podcast is publish to iTunes U',
  `publish_itunes_date` date DEFAULT NULL COMMENT 'Date the podcast was published to iTunes U',
  `update_itunes_date` date DEFAULT NULL COMMENT 'Date of last update on iTunes U',
  `intended_itunesu_flag` set('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Y if this podcast intended for iTunesU',
  `openlearn_epub` set('Y','N') NOT NULL DEFAULT 'N' COMMENT 'This flag used to indicate that the Collection contains ePub(s) from OpenLearn',
  `itunesu_site` set('public','private') DEFAULT 'public',
  `target_itunesu_date` date DEFAULT NULL COMMENT 'Date of intended launch in iTunesU',
  `production_date` date DEFAULT NULL COMMENT 'Date of production',
  `rights_date` date DEFAULT NULL COMMENT 'Date rights approved',
  `metadata_date` date DEFAULT NULL COMMENT 'Date metadata completed',
  `publish_youtube` set('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Flag indicates whether the podcast is publish to YouTube',
  `youtube_channel` varchar(50) DEFAULT NULL COMMENT 'Which YouTube channel to upload tracks to',
  `valid_feed` set('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Legacy code - no longer used',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Legacy? Looks unused.',
  `owner_id` int(5) NOT NULL,
  `podcast_flag` tinyint(1) DEFAULT '0',
  `intended_youtube_flag` set('Y','N') DEFAULT 'N',
  `itunesu_justification` text,
  `youtube_justification` text,
  `consider_for_itunesu` tinyint(1) DEFAULT '0',
  `consider_for_youtube` tinyint(1) DEFAULT '0',
  `preferred_node` mediumint(8) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Podcasts' AUTO_INCREMENT=1476 ;

--
-- Dumping data for table `podcasts`
--

INSERT INTO `podcasts` (`id`, `grouping`, `title`, `summary`, `image`, `image_copyright`, `image_source`, `image_logoless`, `image_ll_copyright`, `image_wide`, `image_wide_copyright`, `artwork_file`, `author`, `itunes_u_url`, `language`, `explicit`, `keywords`, `contact_name`, `contact_email`, `subtitle`, `link`, `link_text`, `course_code`, `copyright`, `rss_url`, `custom_id`, `private`, `intranet_only`, `media_location`, `publish_itunes_u`, `publish_itunes_date`, `update_itunes_date`, `intended_itunesu_flag`, `openlearn_epub`, `itunesu_site`, `target_itunesu_date`, `production_date`, `rights_date`, `metadata_date`, `publish_youtube`, `youtube_channel`, `valid_feed`, `created`, `modified`, `deleted`, `owner_id`, `podcast_flag`, `intended_youtube_flag`, `itunesu_justification`, `youtube_justification`, `consider_for_itunesu`, `consider_for_youtube`, `preferred_node`) VALUES
(1472, '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', 'clean', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'N', 'local', 'N', NULL, NULL, 'N', 'N', 'public', NULL, NULL, NULL, NULL, 'N', NULL, 'N', '2011-07-05 15:49:40', '2011-07-05 15:49:40', 0, 0, 0, 'N', NULL, NULL, 0, 0, 0),
(1473, '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', 'clean', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'N', 'local', 'N', NULL, NULL, 'N', 'N', 'public', NULL, NULL, NULL, NULL, 'N', NULL, 'N', '2011-07-05 15:51:32', '2011-07-05 15:51:32', 0, 0, 0, 'N', NULL, NULL, 0, 0, 0),
(1468, '', 'blah', 'gfnfgngfd', '1468_blah.jpg', '', '', NULL, NULL, NULL, NULL, NULL, '', NULL, 'en', 'clean', '', '', '', NULL, 'www.example.com', '', '', '', NULL, '1468_blah', 'Y', '', 'local', 'N', NULL, NULL, 'N', 'N', 'public', NULL, NULL, NULL, NULL, 'N', NULL, 'N', '2011-06-30 15:55:55', '2011-06-30 16:14:48', 0, 1122, 1, 'N', '', NULL, 0, 0, NULL),
(1470, '', 'test', 'ghgjgkjkj', '1470_test.jpg', 'Copyright by ACME', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', 'clean', 'blah etc', 'Charles Jackson', 'charles@jacksoncharles.co.uk', NULL, 'www.example.com', 'Link for the test', NULL, 'Podcast Copyright', NULL, '1470_test', 'Y', 'N', 'local', 'N', NULL, NULL, 'N', 'N', 'public', NULL, NULL, NULL, NULL, 'N', NULL, 'N', '2011-07-05 11:16:00', '2011-07-05 15:09:52', 0, 1119, 1, 'N', 'because i want it.', 'The quick brown fox\r\n\r\njumped over the lazy dog!', 1, 1, 20),
(1471, '', 'tammy', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', 'clean', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1471_tammy', 'Y', 'N', 'local', 'N', NULL, NULL, 'N', 'N', 'public', NULL, NULL, NULL, NULL, 'N', NULL, 'N', '2011-07-05 11:29:05', '2011-07-05 11:29:05', 0, 1119, 0, 'N', NULL, NULL, 0, 0, 0),
(1465, '', 'Ian-Podcast-10', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', 'clean', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1465_ianpodcast10', 'Y', 'N', 'local', 'N', NULL, NULL, 'N', 'N', 'public', NULL, NULL, NULL, NULL, 'N', NULL, 'N', '2011-06-30 11:10:21', '2011-06-30 11:10:21', 0, 1120, 0, 'N', NULL, NULL, 0, 0, 0),
(1469, '', 'dsadsdfsdd', 'sdfsdfdsfd', '1469_dsadsdfsdd.jpg', '', '', 'LL_1469_dsadsdfsdd.jpg', '', NULL, '', '0', 'Charles Jackson', '', 'en', 'clean', '', '', '', '', 'www.exaample.com', '', '', '', NULL, '1469_dsadsdfsdd', 'Y', 'N', 's3nonOU', 'Y', '2011-07-06', '2011-07-21', 'Y', 'Y', 'public', NULL, '2011-07-15', NULL, NULL, 'N', NULL, 'N', '2011-07-01 13:37:49', '2011-07-05 16:01:31', 0, 1119, 1, 'N', 'sfdfdsfsdsdsdsd', 'Because we want it!', 1, 0, 20),
(1474, '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', 'clean', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'N', 'local', 'N', NULL, NULL, 'N', 'N', 'public', NULL, NULL, NULL, NULL, 'N', NULL, 'N', '2011-07-05 15:54:55', '2011-07-05 15:54:55', 0, 0, 0, 'N', NULL, NULL, 0, 0, 0),
(1475, '', 'crap', 'dfvsdvv', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', 'clean', '', '', '', NULL, 'http://www.www.www', 'erbverb', NULL, '', NULL, '1475_crap', 'Y', 'N', 'local', 'N', NULL, NULL, 'N', 'N', 'public', NULL, NULL, NULL, NULL, 'N', NULL, 'N', '2011-07-05 16:03:47', '2011-07-05 16:12:14', 0, 1123, 1, 'N', 'ergerg', 'wervgerg', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `podcasts_categories`
--

CREATE TABLE IF NOT EXISTS `podcasts_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `podcast_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `podcasts_categories`
--

INSERT INTO `podcasts_categories` (`id`, `podcast_id`, `category_id`) VALUES
(9, 1455, 1),
(13, 1457, 60),
(14, 1457, 1),
(15, 1457, 33),
(19, 1469, 42),
(20, 1469, 60),
(21, 1469, 1);

-- --------------------------------------------------------

--
-- Table structure for table `podcasts_itunesu_categories`
--

CREATE TABLE IF NOT EXISTS `podcasts_itunesu_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `podcast_id` int(11) NOT NULL,
  `itunesu_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `podcasts_itunesu_categories`
--

INSERT INTO `podcasts_itunesu_categories` (`id`, `podcast_id`, `itunesu_category_id`) VALUES
(9, 1455, 57),
(10, 1455, 85),
(13, 1457, 46),
(14, 1457, 85),
(17, 1469, 12),
(18, 1469, 110);

-- --------------------------------------------------------

--
-- Table structure for table `podcasts_nodes`
--

CREATE TABLE IF NOT EXISTS `podcasts_nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `podcast_id` int(11) NOT NULL,
  `node_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=600 ;

--
-- Dumping data for table `podcasts_nodes`
--

INSERT INTO `podcasts_nodes` (`id`, `podcast_id`, `node_id`) VALUES
(431, 24, 20),
(432, 24, 5),
(433, 24, 21),
(582, 1404, 20),
(599, 1405, 5);

-- --------------------------------------------------------

--
-- Table structure for table `podcast_items`
--

CREATE TABLE IF NOT EXISTS `podcast_items` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `podcast_id` mediumint(8) unsigned DEFAULT NULL COMMENT 'Link to podcasts record',
  `shortcode` varchar(12) DEFAULT NULL COMMENT 'Unique code for this track',
  `sub_feed` varchar(24) NOT NULL COMMENT 'used to create sub-feeds of a podcast, particularly with iTunes U in mind where you may have multiple ''tabs'' of different content in one ''album'' (podcast)',
  `subsection` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'ID of the subsection this item appears in',
  `youtube_flag` set('N','Y') NOT NULL DEFAULT 'N',
  `itunes_flag` set('N','Y') NOT NULL DEFAULT 'N',
  `openlearn_explore_flag` set('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Used to indicate if the item should appear within the RSS feed provided to OpenLearn Explore website',
  `youtube_title` varchar(80) DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `youtube_description` text,
  `summary` text NOT NULL,
  `author` varchar(150) NOT NULL DEFAULT '',
  `explicit` set('yes','no','clean') NOT NULL DEFAULT 'no',
  `original_filename` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `fileformat` varchar(24) DEFAULT NULL,
  `duration` float(12,4) DEFAULT NULL COMMENT 'In seconds',
  `status` varchar(24) DEFAULT NULL COMMENT 'Legacy - believed not used',
  `published_flag` set('N','Y') NOT NULL DEFAULT 'N',
  `uploaded_by` varchar(24) DEFAULT NULL COMMENT 'Legacy',
  `uploaded_when` datetime DEFAULT NULL COMMENT 'Legacy',
  `processed_state` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Reported by transcoding servers',
  `youtube_id` varchar(64) DEFAULT NULL COMMENT 'This field is populated with the youtube unique id if this track has been uploaded to YouTube',
  `youtube_legacy_track` set('N','Y') DEFAULT 'N' COMMENT 'Used to define YouTube tracks which have not been uploaded via the PPodcast publishing system and thus do not have the relevant tracking tags',
  `created_by` varchar(24) DEFAULT NULL,
  `created_when` datetime DEFAULT NULL,
  `last_modified_by` varchar(24) DEFAULT NULL,
  `last_modified_when` datetime DEFAULT NULL,
  `publication_date` datetime DEFAULT NULL COMMENT 'Date this track will appear live',
  `auto_publish_flag` set('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Set to make track appear live automatically',
  `transcript_filename` varchar(100) DEFAULT NULL,
  `transcript_upload_by` varchar(24) DEFAULT NULL,
  `transcript_upload_when` datetime DEFAULT NULL,
  `image_filename` varchar(100) DEFAULT NULL,
  `image_upload_by` varchar(24) DEFAULT NULL,
  `image_upload_when` datetime DEFAULT NULL,
  `prod_id` varchar(15) DEFAULT NULL,
  `archive_details` text,
  `music_details` text,
  `cover_art_suggestions` text,
  `tape_ref` varchar(15) DEFAULT NULL,
  `epub_isbn` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'ISBN number if an eBook',
  `epub_study_hours` smallint(8) NOT NULL DEFAULT '0',
  `epub_study_level` varchar(20) DEFAULT NULL,
  `source_media` varchar(15) DEFAULT NULL,
  `aspect_ratio` float(6,4) DEFAULT NULL,
  `time_code` text,
  `first_use_date` datetime DEFAULT NULL,
  `episode` varchar(15) DEFAULT NULL,
  `closed_caption` varchar(15) DEFAULT NULL,
  `prod_status` varchar(15) DEFAULT NULL,
  `unit_course` varchar(15) DEFAULT NULL,
  `unit_course_title` varchar(100) DEFAULT NULL,
  `youtube_channel` varchar(100) DEFAULT NULL COMMENT 'Actually YouTube subject category',
  `topic_category` varchar(200) DEFAULT NULL,
  `itunes_genre` varchar(100) DEFAULT NULL,
  `itunes_album` varchar(100) DEFAULT NULL,
  `target_url` varchar(200) DEFAULT NULL,
  `target_url_text` varchar(150) DEFAULT NULL COMMENT 'Text for item-level link',
  `youtube_tags` text,
  `itunes_tags` text,
  `geo_location` varchar(30) DEFAULT NULL,
  `producer_owner` varchar(40) DEFAULT NULL,
  `academic_consultant` text,
  `credits` text,
  `rights_issues` text,
  `rights_approved` text COMMENT 'Free text providing details of rights approval',
  `acknowledgements` text,
  `notes` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Items for podcasts' AUTO_INCREMENT=12578 ;

--
-- Dumping data for table `podcast_items`
--

INSERT INTO `podcast_items` (`id`, `podcast_id`, `shortcode`, `sub_feed`, `subsection`, `youtube_flag`, `itunes_flag`, `openlearn_explore_flag`, `youtube_title`, `title`, `youtube_description`, `summary`, `author`, `explicit`, `original_filename`, `filename`, `fileformat`, `duration`, `status`, `published_flag`, `uploaded_by`, `uploaded_when`, `processed_state`, `youtube_id`, `youtube_legacy_track`, `created_by`, `created_when`, `last_modified_by`, `last_modified_when`, `publication_date`, `auto_publish_flag`, `transcript_filename`, `transcript_upload_by`, `transcript_upload_when`, `image_filename`, `image_upload_by`, `image_upload_when`, `prod_id`, `archive_details`, `music_details`, `cover_art_suggestions`, `tape_ref`, `epub_isbn`, `epub_study_hours`, `epub_study_level`, `source_media`, `aspect_ratio`, `time_code`, `first_use_date`, `episode`, `closed_caption`, `prod_status`, `unit_course`, `unit_course_title`, `youtube_channel`, `topic_category`, `itunes_genre`, `itunes_album`, `target_url`, `target_url_text`, `youtube_tags`, `itunes_tags`, `geo_location`, `producer_owner`, `academic_consultant`, `credits`, `rights_issues`, `rights_approved`, `acknowledgements`, `notes`, `created`, `modified`, `deleted`) VALUES
(12524, 1464, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', NULL, NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 11:09:45', '2011-06-30 11:09:45', 0),
(12523, 1464, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', NULL, NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 11:08:41', '2011-06-30 11:08:41', 0),
(12528, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12528_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 11:32:02', '2011-06-30 16:24:44', 0),
(12576, 1465, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'drop.avi', '12576_drop.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.7500, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-07-04 14:06:14', '2011-07-04 14:06:14', 1),
(12575, 1469, NULL, '', 0, 'N', 'N', 'N', '', '', NULL, '', '', 'no', '1_-_Sweet_Love.ogg', '12575_1_-_Sweet_Love.ogg', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 'N', NULL, NULL, NULL, 'MEDIA_12575_1469_dsadsdfsdd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, '', '', NULL, NULL, '2011-07-01 13:46:00', '2011-07-04 14:04:42', 0),
(12534, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12534_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 11:42:16', '2011-06-30 16:25:59', 1),
(12535, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12535_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 11:44:39', '2011-06-30 11:44:39', 0),
(12536, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12536_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 11:54:44', '2011-06-30 11:54:44', 0),
(12537, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12537_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 11:56:41', '2011-06-30 11:56:41', 0),
(12538, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12538_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 11:58:57', '2011-06-30 11:58:57', 0),
(12539, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12539_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5600, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:04:24', '2011-06-30 12:04:24', 0),
(12540, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12540_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:05:28', '2011-06-30 12:05:28', 0),
(12541, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12541_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:06:38', '2011-06-30 12:06:38', 0),
(12542, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12542_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5600, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:07:33', '2011-06-30 12:07:33', 0),
(12543, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12543_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5600, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:09:38', '2011-06-30 12:09:38', 0),
(12544, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12544_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5600, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:10:59', '2011-06-30 12:10:59', 0),
(12545, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12545_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5600, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:13:39', '2011-06-30 12:13:39', 0),
(12546, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12546_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5600, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:17:16', '2011-06-30 12:17:16', 0),
(12547, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12547_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:23:45', '2011-06-30 12:23:45', 0),
(12548, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12548_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:24:56', '2011-06-30 12:24:56', 0),
(12549, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12549_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:27:40', '2011-06-30 12:27:40', 0),
(12550, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12550_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:29:35', '2011-06-30 12:29:35', 0),
(12551, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12551_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:31:05', '2011-06-30 12:31:05', 0),
(12552, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', NULL, NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:31:33', '2011-06-30 12:31:33', 0),
(12553, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12553_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:32:29', '2011-06-30 12:32:29', 0),
(12554, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12554_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:33:53', '2011-06-30 12:33:53', 0),
(12555, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12555_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:35:51', '2011-06-30 12:35:51', 0),
(12556, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', NULL, NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:36:36', '2011-06-30 12:36:36', 0),
(12557, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12557_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:37:28', '2011-06-30 12:37:28', 0),
(12558, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12558_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:41:32', '2011-06-30 12:41:32', 0),
(12559, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12559_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:42:34', '2011-06-30 12:42:34', 0),
(12560, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12560_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:45:04', '2011-06-30 12:45:04', 0),
(12561, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12561_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:46:52', '2011-06-30 12:46:52', 0),
(12562, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12562_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 12:48:13', '2011-06-30 12:48:13', 0),
(12574, 1468, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', '4_-_Been_So_Long.ogg', '12574_4_-_Been_So_Long.ogg', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 16:20:56', '2011-06-30 16:52:14', 0),
(12564, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12564_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 13:54:54', '2011-06-30 13:54:54', 0),
(12566, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12566_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 14:04:05', '2011-06-30 14:04:05', 0),
(12567, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12567_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 14:06:50', '2011-06-30 14:06:50', 0),
(12568, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12568_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 14:10:25', '2011-06-30 14:10:25', 0),
(12569, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2.avi', '12569_BSG_4.2.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 14:12:23', '2011-06-30 14:12:23', 0),
(12570, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2_01.avi', '12570_BSG_4.2_01.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 14:16:29', '2011-06-30 14:16:29', 0),
(12572, 1467, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'BSG_4.2_01.avi', '12572_BSG_4.2_01.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-06-30 14:22:05', '2011-06-30 14:22:05', 0),
(12577, 1465, NULL, '', 0, 'N', 'N', 'N', NULL, '', NULL, '', '', 'no', 'drop.avi', '12577_drop.avi', NULL, NULL, NULL, 'N', NULL, NULL, 1, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0.7500, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-07-05 16:56:35', '2011-07-05 16:56:35', 0);

-- --------------------------------------------------------

--
-- Table structure for table `podcast_item_media`
--

CREATE TABLE IF NOT EXISTS `podcast_item_media` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `podcast_item` mediumint(8) unsigned NOT NULL,
  `media_type` set('default','3gp','audio-mp3','audio-m4a','audio-m4b','desktop','hd','iphone','iphonecellular','ipod','large','transcript','youtube','extra','ipod-all','desktop-all','high','epub') NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `duration` float(12,4) NOT NULL,
  `uploaded_by` varchar(24) NOT NULL,
  `uploaded_when` datetime NOT NULL,
  `processed_state` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `podcast_item` (`podcast_item`,`media_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='List of media files by ''media type'' associated with a given ' AUTO_INCREMENT=54415 ;

--
-- Dumping data for table `podcast_item_media`
--

INSERT INTO `podcast_item_media` (`id`, `guid`, `podcast_item`, `media_type`, `original_filename`, `filename`, `duration`, `uploaded_by`, `uploaded_when`, `processed_state`) VALUES
(54414, NULL, 12575, 'transcript', 'P46.PDF', '1469_dsadsdfsdd.pdf', 0.0000, '', '0000-00-00 00:00:00', 9);

-- --------------------------------------------------------

--
-- Table structure for table `podcast_links`
--

CREATE TABLE IF NOT EXISTS `podcast_links` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `node_id` mediumint(8) unsigned NOT NULL,
  `podcast_id` mediumint(8) unsigned NOT NULL,
  `primary` set('N','Y') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='LInks between nodes and podcasts' AUTO_INCREMENT=5121 ;

--
-- Dumping data for table `podcast_links`
--

INSERT INTO `podcast_links` (`id`, `node_id`, `podcast_id`, `primary`) VALUES
(5079, 6, 1455, 'N'),
(5085, 22, 1457, 'N'),
(5084, 21, 1457, 'N'),
(5083, 5, 1457, 'N'),
(5096, 22, 1459, 'N'),
(5120, 22, 1469, 'N'),
(5119, 21, 1469, 'N'),
(5118, 20, 1469, 'N'),
(5117, 21, 1470, 'N'),
(5116, 5, 1470, 'N'),
(5115, 20, 1470, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `podcast_related_urls`
--

CREATE TABLE IF NOT EXISTS `podcast_related_urls` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `podcast_id` mediumint(8) unsigned DEFAULT NULL,
  `link_url` varchar(150) DEFAULT NULL,
  `link_text` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Related links for podcasts' AUTO_INCREMENT=44 ;

--
-- Dumping data for table `podcast_related_urls`
--

INSERT INTO `podcast_related_urls` (`id`, `podcast_id`, `link_url`, `link_text`) VALUES
(3, 222, 'http://kmi.open.ac.uk/', 'The Knowledge Media Institute at The Open University'),
(2, 222, 'http://cnm.open.ac.uk/', 'The Centre for New Media, KMi'),
(4, 222, 'http://news.bbc.co.uk/1/hi/uk/default.stm', 'BBC News for the UK'),
(5, 222, 'http://dev.mysql.com/doc/refman/5.0/en/pattern-matching.html', 'MySQL provides standard SQL pattern matching as well as a form of pattern matching based on extended regular expressions similar to those used by Unix utilities such as vi, grep, and sed.'),
(7, 371, 'http://www.open2.net/savingbritainspast/index.html', 'Saving Britain''s Past'),
(8, 372, 'http://www.open2.net/savingbritainspast/index.html', 'Saving Britain''s Past'),
(9, 373, 'http://www.open2.net/savingbritainspast/index.html', 'Saving Britain''s Past'),
(10, 374, 'http://www.open2.net/savingbritainspast/index.html', 'Saving Britain''s Past'),
(11, 458, 'http://www.lambethpalacelibrary.org.uk/content/buildingonhistory', 'Building on History: The Church in London | LAMBETH PALACE LIBRARY'),
(12, 458, 'http://www.kcl.ac.uk/', 'Kingâ€™s College London'),
(13, 458, 'http://www.london.anglican.org/', 'Diocese of London (Church of England)'),
(14, 458, 'http://www.ahrc.ac.uk/Pages/default.aspx', 'Arts and Humanities Research Council [AHRC]'),
(15, 458, 'http://www.open.ac.uk/research/?LKCAMPAIGN=it001_gen&MEDIA=it001_research', 'OU Research'),
(21, 467, 'http://www.open.ac.uk/darwin/', 'Charles Darwin at The Open University'),
(17, 473, 'http://www.open.ac.uk/darwin/', 'Charles Darwin at The Open University'),
(18, 473, 'http://darwin.britishcouncil.org/', 'Darwin Now'),
(19, 474, 'http://www.open.ac.uk/darwin/', 'Charles Darwin at The Open University'),
(20, 474, 'http://darwin.britishcouncil.org/', 'Darwin Now'),
(22, 467, 'http://darwin.britishcouncil.org/', 'Darwin Now'),
(23, 468, 'http://www.open.ac.uk/darwin/', 'Charles Darwin at The Open University'),
(24, 468, 'http://darwin.britishcouncil.org/', 'Darwin Now'),
(25, 469, 'http://www.open.ac.uk/darwin/', 'Charles Darwin at The Open University'),
(26, 469, 'http://darwin.britishcouncil.org/', 'Darwin Now'),
(27, 470, 'http://www.open.ac.uk/darwin/', 'Charles Darwin at The Open University'),
(28, 470, 'http://darwin.britishcouncil.org/', 'Darwin Now'),
(29, 471, 'http://www.open.ac.uk/darwin/', 'Charles Darwin at The Open University'),
(30, 471, 'http://darwin.britishcouncil.org/', 'Darwin Now'),
(31, 478, 'http://www.scitech.ac.uk/', 'Science and Technology Facilities Council'),
(32, 502, 'http://bit.ly/aOt85C', 'Highest resolution version'),
(33, 502, 'http://compendium.open.ac.uk/institute', 'Compendium knowledge mapping tool'),
(34, 230, 'http://www.open.ac.uk/platform', 'Platform'),
(35, 588, 'http://www.open.ac.uk/library', 'Open University Library Services'),
(36, 618, 'http://library.open.ac.uk', 'The Open University Library'),
(37, 662, 'http://www.open.ac.uk/blogs/sociallearn/2010/06/22/learning-in-an-open-world-session/', 'Blog post with slides and commentary'),
(38, 802, 'http://www.youtube.com/watch?v=J3aV2eH8u6M', 'Youtube link'),
(39, 801, 'http://podcast.open.ac.uk/pod/vc-message-to-staff', 'The Vice Chancellor''s messages to staff (original video podcast)'),
(40, 481, 'http://podcast.open.ac.uk/pod/vc-message-to-staff-audio', 'The Vice Chancellor''s messages to staff (audio only version of podcast)'),
(41, 1023, 'http://www.opened.ac.uk', 'SCORE web-site'),
(42, 1107, 'http://www.opened.ac.uk', 'SCORE web-site'),
(43, 1136, 'http://www8.open.ac.uk/researchprojects/historyofou/', 'History of the OU website');

-- --------------------------------------------------------

--
-- Table structure for table `podcast_subsections`
--

CREATE TABLE IF NOT EXISTS `podcast_subsections` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `podcast_id` mediumint(8) unsigned DEFAULT NULL COMMENT 'Cross-link to podcasts table',
  `subsection` tinyint(3) unsigned DEFAULT NULL COMMENT 'Number for order',
  `sub_feed` varchar(50) DEFAULT NULL COMMENT 'Short name',
  `subsection_name` varchar(200) DEFAULT NULL COMMENT 'Long descriptive name',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Podcast subsection titles' AUTO_INCREMENT=37 ;

--
-- Dumping data for table `podcast_subsections`
--


-- --------------------------------------------------------

--
-- Table structure for table `podcast_tags`
--

CREATE TABLE IF NOT EXISTS `podcast_tags` (
  `podcast_id` mediumint(9) NOT NULL DEFAULT '0',
  `tag_id` mediumint(9) NOT NULL DEFAULT '0',
  KEY `podcast_id` (`podcast_id`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `podcast_tags`
--


-- --------------------------------------------------------

--
-- Table structure for table `podcast_youtube_queue`
--

CREATE TABLE IF NOT EXISTS `podcast_youtube_queue` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `podcast_id` mediumint(8) unsigned NOT NULL,
  `track_id` mediumint(8) unsigned NOT NULL,
  `youtube_channel` varchar(100) DEFAULT NULL COMMENT 'Name of YouTube channel to upload to',
  `queued_by` varchar(16) DEFAULT NULL COMMENT 'User who added this track to the queue',
  `queued_when` datetime DEFAULT NULL COMMENT 'When added to the queue',
  `uploaded_when` datetime DEFAULT NULL COMMENT 'Timestamp movie was actually uploaded to YouTube',
  `done_flag` set('N','Y','P','F') NOT NULL DEFAULT 'N',
  `error_code` tinyint(4) NOT NULL DEFAULT '0',
  `error_text` text COMMENT 'Error text returned from YouTube',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Queue of files to upload to YouTube' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `podcast_youtube_queue`
--


-- --------------------------------------------------------

--
-- Table structure for table `queues`
--

CREATE TABLE IF NOT EXISTS `queues` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `data` text,
  `attempts` int(11) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Queue of jobs to be sent to the API' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `queues`
--


-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `tag_text` varchar(150) DEFAULT NULL,
  `preferred` set('N','Y') DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `tag` (`tag_text`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag_text`, `preferred`) VALUES
(1, 'Business and management', 'Y'),
(2, 'Education and teacher training', 'Y'),
(3, 'Health and social care/Health studies', 'Y'),
(4, 'Humanities: arts, languages, history', 'Y'),
(5, 'Information technology and computing', 'Y'),
(6, 'Law and criminology', 'Y'),
(7, 'Mathematics and statistics', 'Y'),
(8, 'Psychology, philosophy, politics, economics', 'Y'),
(9, 'Science', 'Y'),
(10, 'Social sciences', 'Y'),
(11, 'Technology, engineering and manufacturing', 'Y'),
(12, 'Continuing Professional Development', 'N'),
(13, 'developer_test', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE IF NOT EXISTS `temp` (
  `autoid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uniqueid` mediumint(9) DEFAULT NULL,
  `oldid` mediumint(8) unsigned DEFAULT NULL COMMENT 'The old section number',
  PRIMARY KEY (`autoid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Temporary table for renumbering podcast subsections' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `temp`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_title` varchar(12) DEFAULT NULL,
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `accessLevel` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `iTunesU` set('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Can this user access iTunesU',
  `YouTube` set('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Can this user access YouTube',
  `openlearn_explore` set('Y','N') NOT NULL DEFAULT 'N',
  `oucu` varchar(16) DEFAULT NULL,
  `last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `administrator` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `terms` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Users table' AUTO_INCREMENT=1127 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_title`, `firstname`, `lastname`, `email`, `accessLevel`, `iTunesU`, `YouTube`, `openlearn_explore`, `oucu`, `last_updated`, `last_login`, `administrator`, `created`, `terms`, `status`) VALUES
(1120, NULL, 'Ian', 'Newton', 'in625@open.ac.uk', 0, 'Y', 'Y', 'Y', 'in625', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '2011-06-30 10:43:04', 1, 1),
(1119, NULL, 'Charles', 'Jackson', 'cj3998@open.ac.uk', 0, 'Y', 'Y', 'Y', 'cj3998', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '2011-06-30 10:25:26', 1, 1),
(1121, NULL, 'Chris', 'Valentine', 'cpv2@open.ac.uk', 0, 'Y', 'Y', 'Y', 'cpv2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '2011-06-30 10:52:51', 1, 1),
(1122, NULL, 'Peter', 'Scott', 'pjs33@open.ac.uk', 0, 'Y', 'Y', 'Y', 'pjs33', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '2011-06-30 15:55:21', 1, 1),
(1123, NULL, 'Jamie', 'Daniels', 'jdd7@open.ac.uk', 0, 'Y', 'Y', 'Y', 'jdd7', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '2011-07-01 10:12:09', 1, 1),
(1124, NULL, 'Damian', 'Dadswell', 'drd52@open.ac.uk', 0, 'Y', 'Y', 'Y', 'drd52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '2011-07-05 17:07:45', 1, 1),
(1125, NULL, 'Kristoff', 'Van', 'kl2822@open.ac.uk', 0, 'Y', 'Y', 'Y', 'kl2822', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '2011-07-05 17:16:41', 1, 1),
(1126, NULL, 'Ben', 'Hawkridge', 'bh6@open.ac.uk', 0, 'Y', 'Y', 'Y', 'bh6', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '2011-07-06 02:22:33', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `group_title` varchar(50) DEFAULT NULL,
  `members` text NOT NULL,
  `created_by` varchar(16) NOT NULL,
  `created_when` datetime NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='User group definitions' AUTO_INCREMENT=101 ;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_title`, `members`, `created_by`, `created_when`, `created`, `modified`) VALUES
(1, 'KMi', '(964,1)', 'cpv2', '2008-04-16 20:08:34', NULL, NULL),
(2, 'iTunes U Team', '(1096,2,1063,999,1,998,1100)', 'cpv2', '2008-04-16 20:58:41', NULL, NULL),
(3, 'Communications', '(932,953,1015,951,939,952,950)', 'cpv2', '2008-04-16 20:59:06', NULL, NULL),
(4, 'OUBS', '(977,1064,1065,1050)', 'cpv2', '2008-04-24 14:39:33', NULL, NULL),
(5, 'Science', '(944,948,1)', 'bh6', '2008-08-11 19:56:06', NULL, NULL),
(6, 'Platform', '(932,953,1015,951,939,952,950)', 'bh6', '2008-10-08 16:08:27', NULL, NULL),
(7, 'IET', '(1023,956,954,955,989,1,1056)', 'bh6', '2008-10-17 12:39:00', NULL, NULL),
(13, 'OpenLearn Explore', '(953,1008,1007,1000,984)', 'bh6', '2009-11-09 17:51:09', NULL, NULL),
(8, 'LTS-Podcast', '(960,968,935,966,937,934)', 'bh6', '2008-11-16 23:56:20', NULL, NULL),
(19, 'LDT', '(1001,1067,1029,1090)', 'bh6', '2010-08-09 16:36:17', NULL, NULL),
(9, 'LTS-HSC', '(967,937,968)', 'bh6', '2009-04-22 15:23:51', NULL, NULL),
(10, 'CRC', '(983,982)', 'bh6', '2009-07-31 04:23:32', NULL, '2011-05-12 13:10:02'),
(11, 'IET-Lab', '(986,970,989,971)', 'cpv2', '2009-09-24 16:27:58', NULL, NULL),
(15, 'Documentum', '(1038,1049,1050,1019,1012)', 'cpv2', '2010-06-18 12:46:53', NULL, NULL),
(16, 'Library', '(957,945,1021)', 'bh6', '2010-07-13 18:22:41', NULL, NULL),
(17, 'OLnet', '(1026,1023)', 'cpv2', '2010-07-28 08:44:45', NULL, NULL),
(18, 'OUBS-Website', '(1027,1068,1028,1005,1050,1064,1065,1030,1083,1082)', 'bh6', '2010-07-30 04:09:52', NULL, NULL),
(20, 'Open Broadcasting Unit', '(934,1033,1031,1097)', 'bh6', '2010-08-17 04:26:31', NULL, NULL),
(21, 'OHSD', '(1035,1058,1034,1059,1050)', 'cpv2', '2010-09-01 09:00:00', NULL, NULL),
(22, 'Marketing Intranet', '(1038,1036,1050,1037,1012)', 'bh6', '2010-09-03 04:53:21', NULL, NULL),
(23, 'LTS-Mobile-site', '(1010,933)', 'bh6', '2010-10-13 00:49:29', NULL, NULL),
(24, 'LTS-Unison', '(1045,1053,1010,1062)', 'bh6', '2010-11-08 17:00:49', NULL, NULL),
(25, 'Learning Innovation Office', '(933,1056,936)', 'cpv2', '2010-11-11 11:10:37', NULL, NULL),
(26, 'Online Marketing', '(1046,1047)', 'bh6', '2010-12-10 15:27:03', NULL, NULL),
(27, 'Podcast Workshop', '(1069,1070,1071,1073,1074,1075,1076,1077,1078,1079,1072,990)', 'bh6', '2011-01-27 14:43:52', NULL, NULL),
(28, 'T156 Production', '(1091,974,934,983)', 'bh6', '2011-03-07 02:34:58', NULL, NULL),
(29, 'Social Science - Research Project Oecumene', '(1093,1024,1094)', 'bh6', '2011-03-10 05:41:58', NULL, NULL),
(30, 'PSE2010', '(937,1100)', 'bh6', '2011-03-28 04:41:55', NULL, NULL),
(32, 'OUAV', '(947,1048)', 'bh6', '2011-04-08 17:46:49', NULL, NULL),
(33, 'Social Sciences - Research project - ICCM', '(1024,1104,1105,1106,1107)', 'cpv2', '2011-04-18 10:40:35', NULL, NULL),
(99, 'XXXXXXXXXXXXXXX', '', '', '0000-00-00 00:00:00', '2011-06-01 11:19:28', '2011-06-03 23:09:20'),
(78, 'SAsA', '', '', '0000-00-00 00:00:00', '2011-05-12 11:28:39', '2011-05-12 11:28:52'),
(100, 'Kristoffs user group.', '', '', '0000-00-00 00:00:00', '2011-07-05 17:17:30', '2011-07-05 17:17:30');

-- --------------------------------------------------------

--
-- Table structure for table `user_group_podcasts`
--

CREATE TABLE IF NOT EXISTS `user_group_podcasts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `podcast_id` int(11) NOT NULL,
  `moderator` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=169 ;

--
-- Dumping data for table `user_group_podcasts`
--

INSERT INTO `user_group_podcasts` (`id`, `user_group_id`, `podcast_id`, `moderator`) VALUES
(48, 1, 1455, 0),
(49, 15, 1455, 0),
(50, 3, 1455, 1),
(59, 1, 1457, 0),
(60, 2, 1457, 0),
(61, 9, 1457, 0),
(62, 16, 1457, 0),
(63, 25, 1457, 0),
(64, 19, 1457, 1),
(106, 3, 1459, 0),
(107, 7, 1459, 0),
(108, 15, 1459, 0),
(109, 10, 1459, 1),
(143, 3, 1470, 0),
(144, 10, 1470, 0),
(145, 2, 1470, 0),
(146, 15, 1470, 1),
(149, 3, 1469, 0),
(150, 10, 1469, 0),
(151, 15, 1469, 0),
(152, 7, 1469, 0),
(153, 24, 1469, 0),
(154, 17, 1469, 0),
(155, 26, 1469, 0),
(156, 20, 1469, 0),
(157, 13, 1469, 0),
(158, 32, 1469, 0),
(159, 4, 1469, 0),
(160, 18, 1469, 0),
(161, 6, 1469, 0),
(162, 27, 1469, 0),
(163, 30, 1469, 0),
(164, 78, 1469, 0),
(165, 5, 1469, 0),
(166, 29, 1469, 0),
(167, 22, 1469, 1),
(168, 21, 1469, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_permission_groups`
--

CREATE TABLE IF NOT EXISTS `user_permission_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_permission_groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_podcasts`
--

CREATE TABLE IF NOT EXISTS `user_podcasts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `podcast_id` int(11) NOT NULL,
  `moderator` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `user_podcasts`
--

INSERT INTO `user_podcasts` (`id`, `user_id`, `podcast_id`, `moderator`) VALUES
(24, 1095, 1455, 0),
(25, 1082, 1455, 0),
(26, 1024, 1455, 0),
(27, 1097, 1455, 0),
(28, 995, 1455, 1),
(29, 1003, 1455, 1),
(30, 1025, 1455, 1),
(38, 1, 1457, 0),
(39, 974, 1457, 0),
(40, 976, 1457, 0),
(41, 1109, 1457, 0),
(42, 1110, 1457, 1),
(58, 1120, 1470, 0),
(59, 1119, 1470, 0),
(60, 1121, 1470, 1),
(63, 1121, 1469, 0),
(64, 1122, 1469, 0),
(65, 1120, 1469, 1),
(66, 1123, 1469, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_user_groups`
--

CREATE TABLE IF NOT EXISTS `user_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `moderator` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_user_groups`
--

INSERT INTO `user_user_groups` (`id`, `user_id`, `user_group_id`, `moderator`) VALUES
(1, 1125, 100, 1);
