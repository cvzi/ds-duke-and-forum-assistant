-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `lastaction` int(20) NOT NULL,
  `key` varchar(128) NOT NULL COMMENT 'SHA-512',
  `joinkey` varchar(128) NOT NULL COMMENT 'Sha512',
  `leader_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `record`
--

CREATE TABLE IF NOT EXISTS `record` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `group` int(11) NOT NULL,
  `hash` varchar(128) NOT NULL COMMENT 'SHA-512. Hash of the data string.',
  `version` int(11) NOT NULL,
  `data` text NOT NULL,
  `time` int(20) NOT NULL,
  `downloads` int(20) NOT NULL,
  `author` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

--
-- Trigger `record`
--
DROP TRIGGER IF EXISTS `user_lastaction`;
DELIMITER //
CREATE TRIGGER `user_lastaction` BEFORE INSERT ON `record`
 FOR EACH ROW UPDATE `user` SET `user`.`lastaction` = UNIX_TIMESTAMP() WHERE `user`.`id` = `NEW`.`author`
//
DELIMITER ;
DROP TRIGGER IF EXISTS `group_lastaction`;
DELIMITER //
CREATE TRIGGER `group_lastaction` AFTER INSERT ON `record`
 FOR EACH ROW UPDATE `group` SET `group`.`lastaction` = UNIX_TIMESTAMP() WHERE `group`.`id` = `NEW`.`group`
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL COMMENT 'sha512',
  `lastaction` int(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `usergroup_map`
--

CREATE TABLE IF NOT EXISTS `usergroup_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL COMMENT 'Group ID',
  `uid` int(11) NOT NULL COMMENT 'User ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
