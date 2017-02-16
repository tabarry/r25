-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Feb 15, 2017 at 10:12 AM
-- Server version: 5.5.42
-- PHP Version: 5.5.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `r25`
--

-- --------------------------------------------------------

--
-- Table structure for table `sulata_blank`
--

DROP TABLE IF EXISTS `sulata_blank`;
CREATE TABLE `sulata_blank` (
  `__ID` int(11) NOT NULL,
  `__Last_Action_On` datetime NOT NULL,
  `__Last_Action_By` varchar(64) NOT NULL,
  `__dbState` enum('Live','Deleted') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sulata_faqs`
--

DROP TABLE IF EXISTS `sulata_faqs`;
CREATE TABLE `sulata_faqs` (
  `faq__ID` int(11) NOT NULL,
  `faq__Question` varchar(255) NOT NULL COMMENT '|s',
  `faq__Answer` text NOT NULL,
  `faq__Sequence` double NOT NULL COMMENT '|s',
  `faq__Status` enum('Active','Inactive') NOT NULL DEFAULT 'Active' COMMENT '|s',
  `faq__Last_Action_On` datetime NOT NULL,
  `faq__Last_Action_By` varchar(64) NOT NULL,
  `faq__dbState` enum('Live','Deleted') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sulata_headers`
--

DROP TABLE IF EXISTS `sulata_headers`;
CREATE TABLE `sulata_headers` (
  `header__ID` int(11) NOT NULL,
  `header__Title` varchar(64) NOT NULL COMMENT '|s',
  `header__Picture` varchar(128) NOT NULL,
  `header__Last_Action_On` datetime NOT NULL,
  `header__Last_Action_By` varchar(64) NOT NULL,
  `header__dbState` enum('Live','Deleted') NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sulata_headers`
--

INSERT INTO `sulata_headers` (`header__ID`, `header__Title`, `header__Picture`, `header__Last_Action_On`, `header__Last_Action_By`, `header__dbState`) VALUES
(1, 'London', '1-51e103d8d698f.jpg', '2013-12-09 08:32:36', 'Installer', 'Live'),
(2, 'Brugge', '2-51e10cac77329.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `sulata_media_categories`
--

DROP TABLE IF EXISTS `sulata_media_categories`;
CREATE TABLE `sulata_media_categories` (
  `mediacat__ID` int(11) NOT NULL,
  `mediacat__Name` varchar(64) NOT NULL COMMENT '|s',
  `mediacat__Picture` varchar(128) DEFAULT NULL,
  `mediacat__Description` text,
  `mediacat__Type` enum('Image','File') NOT NULL COMMENT '|s',
  `mediacat__Thumbnail_Width` int(11) DEFAULT NULL,
  `mediacat__Thumbnail_Height` int(11) DEFAULT NULL,
  `mediacat__Image_Width` int(11) DEFAULT NULL,
  `mediacat__Image_Height` int(11) DEFAULT NULL,
  `mediacat__Sequence` double NOT NULL COMMENT '|s',
  `mediacat__Last_Action_On` datetime NOT NULL,
  `mediacat__Last_Action_By` varchar(64) NOT NULL,
  `mediacat__dbState` enum('Live','Deleted') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sulata_media_files`
--

DROP TABLE IF EXISTS `sulata_media_files`;
CREATE TABLE `sulata_media_files` (
  `mediafile__ID` int(11) NOT NULL,
  `mediafile__Category` int(11) NOT NULL COMMENT '|s|mediacat__ID,mediacat__Name',
  `mediafile__Title` varchar(128) NOT NULL COMMENT '|s',
  `mediafile__File` varchar(128) NOT NULL COMMENT '|s|mediacat__ID,mediacat__Name',
  `mediafile__Short_Description` text,
  `mediafile__Long_Description` text,
  `mediafile__Sequence` double NOT NULL COMMENT '|s',
  `mediafile__Date` date NOT NULL COMMENT '|s',
  `mediafile__Last_Action_On` datetime NOT NULL,
  `mediafile__Last_Action_By` varchar(64) NOT NULL,
  `mediafile__dbState` enum('Live','Deleted') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sulata_pages`
--

DROP TABLE IF EXISTS `sulata_pages`;
CREATE TABLE `sulata_pages` (
  `page__ID` int(11) NOT NULL,
  `page__Name` varchar(64) NOT NULL COMMENT '|s',
  `page__Heading` varchar(128) NOT NULL,
  `page__Permalink` varchar(64) NOT NULL,
  `page__Title` varchar(70) NOT NULL,
  `page__Keyword` varchar(255) NOT NULL,
  `page__Description` varchar(155) NOT NULL,
  `page__Header` int(11) NOT NULL COMMENT '|s|header__ID,header__Title',
  `page__Short_Text` text,
  `page__Long_Text` text NOT NULL,
  `page__Link_Position` enum('Nowhere','Top','Bottom','Side','Top+Bottom','Top+Side','Bottom+Side','Top+Bottom+Side') NOT NULL,
  `page__Parent` int(11) DEFAULT NULL COMMENT '|s|page__ID,page__Name',
  `page__Sequence` double NOT NULL COMMENT '|s',
  `page__Last_Action_On` datetime NOT NULL,
  `page__Last_Action_By` varchar(64) NOT NULL,
  `page__dbState` enum('Live','Deleted') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sulata_settings`
--

DROP TABLE IF EXISTS `sulata_settings`;
CREATE TABLE `sulata_settings` (
  `setting__ID` int(11) NOT NULL,
  `setting__Setting` varchar(64) NOT NULL COMMENT '|s',
  `setting__Key` varchar(64) NOT NULL,
  `setting__Value` varchar(256) NOT NULL COMMENT '|s',
  `setting__Type` enum('Private','Public','Site') NOT NULL,
  `setting__Last_Action_On` datetime NOT NULL,
  `setting__Last_Action_By` varchar(64) NOT NULL,
  `setting__dbState` enum('Live','Deleted') NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sulata_settings`
--

INSERT INTO `sulata_settings` (`setting__ID`, `setting__Setting`, `setting__Key`, `setting__Value`, `setting__Type`, `setting__Last_Action_On`, `setting__Last_Action_By`, `setting__dbState`) VALUES
(1, 'Site Name', 'site_name', 'Rapid CMS', 'Public', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(2, 'Site Tagline', 'site_tagline', 'BackOffice', 'Public', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(3, 'Page Size', 'page_size', '24', 'Public', '2013-12-08 17:36:56', 'Installer', 'Live'),
(4, 'Time Zone', 'timezone', 'ASIA/KARACHI', 'Private', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(5, 'Date Format', 'date_format', 'mm-dd-yy', 'Private', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(6, 'Allowed File Formats', 'allowed_file_formats', 'doc,xls,docx,xlsx,ppt,pptx,pdf,gif,jpg,jpeg,png', 'Private', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(7, 'Allowed Image Formats', 'allowed_image_formats', 'gif,jpg,jpeg,png', 'Private', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(8, 'Allowed Attachment Formats', 'allowed_attachment_formats', 'doc,xls,docx,xlsx,ppt,pptx,pdf,gif,jpg,jpeg,png', 'Private', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(10, 'Site Email', 'site_email', 'tahir@sulata.com.pk', 'Public', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(11, 'Site URL', 'site_url', 'http://www.sulata.com.pk', 'Public', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(12, 'Employee Image Height', 'employee_image_height', '150', 'Public', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(13, 'Employee Image Width', 'employee_image_width', '100', 'Public', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(14, 'Default Meta Title', 'default_meta_title', '-', 'Public', '2013-12-08 17:36:34', 'Installer', 'Live'),
(15, 'Default Meta Description', 'default_meta_description', '-', 'Public', '2013-12-09 09:45:02', 'Installer', 'Live'),
(16, 'Default Meta Keywords', 'default_meta_keywords', '-', 'Public', '2013-12-08 17:36:27', 'Installer', 'Live'),
(17, 'Default Theme', 'default_theme', 'default', 'Private', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(18, 'Header Width', 'header_width', '950', 'Public', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(19, 'Header Height', 'header_height', '130', 'Public', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(20, 'Media Category Width', 'media_category_width', '320', 'Public', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(21, 'Media Category Height', 'media_category_height', '240', 'Public', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Live'),
(22, 'Google Login Enable/Disable (1/0)', 'google_login', '0', 'Private', '2014-10-22 11:51:05', 'Installer', 'Live'),
(23, 'Site Footer', 'site_footer', 'Developed by Sulata iSoft.', 'Public', '2014-11-01 16:25:31', 'Installer', 'Live'),
(24, 'Site Footer Link', 'site_footer_link', 'http://www.sulata.com.pk', 'Public', '2014-11-01 16:25:51', 'Installer', 'Live'),
(25, 'Table View or Card View (table/card)', 'table_or_card', 'card', 'Public', '2014-11-01 16:25:51', 'Installer', 'Live'),
(26, 'Show Modules in Sidebar (0/1)', 'sidebar_links', '0', 'Public', '2014-11-01 16:25:51', 'Installer', 'Live'),
(27, 'Allow Multiple Location Login (0/1)', 'multi_login', '0', 'Public', '2014-11-01 16:25:51', 'Installer', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `sulata_testimonials`
--

DROP TABLE IF EXISTS `sulata_testimonials`;
CREATE TABLE `sulata_testimonials` (
  `testimonial__ID` int(11) NOT NULL,
  `testimonial__Name` varchar(34) NOT NULL COMMENT '|s',
  `testimonial__Location` varchar(100) NOT NULL COMMENT '|s',
  `testimonial__Testimonial` text NOT NULL,
  `testimonial__Date` date NOT NULL COMMENT '|s',
  `testimonial__Status` enum('Active','Inactive') NOT NULL COMMENT '|s',
  `testimonial__Last_Action_On` datetime NOT NULL,
  `testimonial__Last_Action_By` varchar(64) NOT NULL,
  `testimonial__dbState` enum('Live','Deleted') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sulata_users`
--

DROP TABLE IF EXISTS `sulata_users`;
CREATE TABLE `sulata_users` (
  `user__ID` int(11) NOT NULL,
  `user__Name` varchar(32) NOT NULL COMMENT '|s',
  `user__Phone` varchar(32) DEFAULT NULL COMMENT '|s',
  `user__Email` varchar(64) NOT NULL COMMENT '|s',
  `user__Password` varchar(64) NOT NULL,
  `user__Status` enum('Active','Inactive') NOT NULL DEFAULT 'Active' COMMENT '|s',
  `user__Picture` varchar(128) DEFAULT NULL,
  `user__Type` enum('Admin','Company User','Client User') NOT NULL,
  `user__Notes` text,
  `user__Theme` varchar(24) NOT NULL DEFAULT 'default',
  `user__Last_Action_On` datetime NOT NULL,
  `user__Last_Action_By` varchar(64) NOT NULL,
  `user__dbState` enum('Live','Deleted') NOT NULL,
  `user__IP` varchar(15) NOT NULL DEFAULT '127.0.0.1'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sulata_users`
--

INSERT INTO `sulata_users` (`user__ID`, `user__Name`, `user__Phone`, `user__Email`, `user__Password`, `user__Status`, `user__Picture`, `user__Type`, `user__Notes`, `user__Theme`, `user__Last_Action_On`, `user__Last_Action_By`, `user__dbState`, `user__IP`) VALUES
(1, 'Super Admin', '', 'tahir@sulata.com.pk', 'ZEdGb2FYST0=', 'Active', '', 'Admin', '', 'default', '2014-10-25 16:53:53', 'Installer', 'Live', '127.0.0.1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sulata_blank`
--
ALTER TABLE `sulata_blank`
  ADD PRIMARY KEY (`__ID`);

--
-- Indexes for table `sulata_faqs`
--
ALTER TABLE `sulata_faqs`
  ADD PRIMARY KEY (`faq__ID`),
  ADD UNIQUE KEY `faq__Question` (`faq__Question`);

--
-- Indexes for table `sulata_headers`
--
ALTER TABLE `sulata_headers`
  ADD PRIMARY KEY (`header__ID`),
  ADD UNIQUE KEY `header__Title` (`header__Title`);

--
-- Indexes for table `sulata_media_categories`
--
ALTER TABLE `sulata_media_categories`
  ADD PRIMARY KEY (`mediacat__ID`),
  ADD UNIQUE KEY `mediacat__Name` (`mediacat__Name`);

--
-- Indexes for table `sulata_media_files`
--
ALTER TABLE `sulata_media_files`
  ADD PRIMARY KEY (`mediafile__ID`),
  ADD UNIQUE KEY `mediafile__Category` (`mediafile__Category`,`mediafile__Title`);

--
-- Indexes for table `sulata_pages`
--
ALTER TABLE `sulata_pages`
  ADD PRIMARY KEY (`page__ID`),
  ADD UNIQUE KEY `page__Name` (`page__Name`);

--
-- Indexes for table `sulata_settings`
--
ALTER TABLE `sulata_settings`
  ADD PRIMARY KEY (`setting__ID`),
  ADD UNIQUE KEY `setting__Key` (`setting__Key`),
  ADD UNIQUE KEY `setting__Setting` (`setting__Setting`);

--
-- Indexes for table `sulata_users`
--
ALTER TABLE `sulata_users`
  ADD PRIMARY KEY (`user__ID`),
  ADD UNIQUE KEY `employee__Email` (`user__Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sulata_blank`
--
ALTER TABLE `sulata_blank`
  MODIFY `__ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sulata_faqs`
--
ALTER TABLE `sulata_faqs`
  MODIFY `faq__ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sulata_headers`
--
ALTER TABLE `sulata_headers`
  MODIFY `header__ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sulata_media_categories`
--
ALTER TABLE `sulata_media_categories`
  MODIFY `mediacat__ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sulata_media_files`
--
ALTER TABLE `sulata_media_files`
  MODIFY `mediafile__ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sulata_pages`
--
ALTER TABLE `sulata_pages`
  MODIFY `page__ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sulata_settings`
--
ALTER TABLE `sulata_settings`
  MODIFY `setting__ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `sulata_users`
--
ALTER TABLE `sulata_users`
  MODIFY `user__ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
