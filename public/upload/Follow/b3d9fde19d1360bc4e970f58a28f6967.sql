# Host: localhost  (Version: 5.5.53)
# Date: 2018-07-24 17:37:09
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "admin_permissions"
#

DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(100) NOT NULL DEFAULT '',
  `route_name` varchar(255) DEFAULT NULL,
  `add_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "admin_permissions"
#

/*!40000 ALTER TABLE `admin_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_permissions` ENABLE KEYS */;

#
# Structure for table "admin_roles"
#

DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(100) NOT NULL DEFAULT '',
  `add_time` int(11) NOT NULL DEFAULT '0',
  `permissions` varchar(300) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "admin_roles"
#

/*!40000 ALTER TABLE `admin_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_roles` ENABLE KEYS */;

#
# Structure for table "admin_user"
#

DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(100) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `add_time` int(11) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `roles` int(11) NOT NULL DEFAULT '0',
  `permissions` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "admin_user"
#

/*!40000 ALTER TABLE `admin_user` DISABLE KEYS */;
INSERT INTO `admin_user` VALUES (1,'admin','admin',0,1,0,0);
/*!40000 ALTER TABLE `admin_user` ENABLE KEYS */;
