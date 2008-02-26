-- MySQL dump 10.9
--
-- Host: localhost    Database: fastladder
-- ------------------------------------------------------
-- Server version	4.1.20

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `crawl_statuses`
--

DROP TABLE IF EXISTS `crawl_statuses`;
CREATE TABLE `crawl_statuses` (
  `id` int(11) NOT NULL auto_increment,
  `feed_id` int(11) NOT NULL default '0',
  `status` int(11) NOT NULL default '1',
  `error_count` int(11) NOT NULL default '0',
  `error_message` varchar(255) character set latin1 default NULL,
  `http_status` int(11) default NULL,
  `digest` varchar(255) character set latin1 default NULL,
  `update_frequency` int(11) NOT NULL default '0',
  `crawled_on` datetime default NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `index_crawl_statuses_on_status_and_crawled_on` (`status`,`crawled_on`)
) ENGINE=InnoDB;

--
-- Table structure for table `favicons`
--

DROP TABLE IF EXISTS `favicons`;
CREATE TABLE `favicons` (
  `id` int(11) NOT NULL auto_increment,
  `feed_id` int(11) NOT NULL default '0',
  `image` blob,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `index_favicons_on_feed_id` (`feed_id`)
) ENGINE=InnoDB;

--
-- Table structure for table `feeds`
--

DROP TABLE IF EXISTS `feeds`;
CREATE TABLE `feeds` (
  `id` int(11) NOT NULL auto_increment,
  `feedlink` varchar(255) character set latin1 NOT NULL default '',
  `link` varchar(255) character set latin1 NOT NULL default '',
  `title` text character set latin1 NOT NULL,
  `description` text character set latin1 NOT NULL,
  `subscribers_count` int(11) NOT NULL default '0',
  `image` varchar(255) character set latin1 default NULL,
  `icon` varchar(255) character set latin1 default NULL,
  `modified_on` datetime default NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `index_feeds_on_feedlink` (`feedlink`)
) ENGINE=InnoDB;

--
-- Table structure for table `folders`
--

DROP TABLE IF EXISTS `folders`;
CREATE TABLE `folders` (
  `id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL default '0',
  `name` varchar(255) character set latin1 NOT NULL default '',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `index_folders_on_member_id_and_name` (`member_id`,`name`)
) ENGINE=InnoDB;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `id` int(11) NOT NULL auto_increment,
  `feed_id` int(11) NOT NULL default '0',
  `link` varchar(255) character set latin1 NOT NULL default '',
  `title` text character set latin1 NOT NULL,
  `body` text character set latin1,
  `author` varchar(255) character set latin1 default NULL,
  `category` varchar(255) character set latin1 default NULL,
  `enclosure` varchar(255) character set latin1 default NULL,
  `enclosure_type` varchar(255) character set latin1 default NULL,
  `digest` varchar(255) character set latin1 default NULL,
  `version` int(11) NOT NULL default '1',
  `stored_on` datetime default NULL,
  `modified_on` datetime default NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `index_items_on_feed_id_and_link` (`feed_id`,`link`)
) ENGINE=InnoDB;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) character set latin1 NOT NULL default '',
  `email` varchar(255) character set latin1 default NULL,
  `crypted_password` varchar(255) character set latin1 default NULL,
  `salt` varchar(255) character set latin1 default NULL,
  `remember_token` varchar(255) character set latin1 default NULL,
  `remember_token_expires_at` datetime default NULL,
  `config_dump` text character set latin1,
  `public` tinyint(1) NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `index_members_on_username` (`username`)
) ENGINE=InnoDB;

--
-- Table structure for table `pins`
--

DROP TABLE IF EXISTS `pins`;
CREATE TABLE `pins` (
  `id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL default '0',
  `link` varchar(255) character set latin1 NOT NULL default '',
  `title` varchar(255) character set latin1 default NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `index_pins_on_member_id_and_link` (`member_id`,`link`)
) ENGINE=InnoDB;

--
-- Table structure for table `schema_info`
--

DROP TABLE IF EXISTS `schema_info`;
CREATE TABLE `schema_info` (
  `version` int(11) default NULL
) ENGINE=MyISAM;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL default '0',
  `folder_id` int(11) default NULL,
  `feed_id` int(11) NOT NULL default '0',
  `rate` int(11) NOT NULL default '0',
  `has_unread` tinyint(1) NOT NULL default '0',
  `public` tinyint(1) NOT NULL default '1',
  `ignore_notify` tinyint(1) NOT NULL default '0',
  `viewed_on` datetime default NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `index_subscriptions_on_member_id_and_feed_id` (`member_id`,`feed_id`),
  KEY `index_subscriptions_on_folder_id` (`folder_id`),
  KEY `index_subscriptions_on_feed_id` (`feed_id`)
) ENGINE=InnoDB;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

