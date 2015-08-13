-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 �?08 �?13 �?13:20
-- 服务器版本: 5.5.40
-- PHP 版本: 5.6.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `phpstudy`
--

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `class_id` int(10) unsigned NOT NULL,
  `stick` enum('true','false') NOT NULL DEFAULT 'false',
  `excellent` enum('true','false') NOT NULL DEFAULT 'false',
  `pass` enum('true','false') NOT NULL DEFAULT 'true',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `user_id` (`user_id`),
  KEY `module_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `user_id`, `class_id`, `stick`, `excellent`, `pass`, `created_at`) VALUES
(1, '巴西世界杯', '巴西世界杯，球迷疯狂！！！！', 10, 0, 'false', 'false', 'true', '2015-08-09 03:07:40'),
(2, '《捉妖记》热映', '《捉妖记》热映，票房突破两亿。', 10, 0, 'false', 'false', 'true', '2015-08-09 03:10:50'),
(4, '丹东', '丹东 中国十大养老圣地', 10, 0, 'false', 'false', 'true', '2015-08-09 05:48:46'),
(5, '房价降低', '房价降低，政府宏观调控。', 10, 2, 'false', 'false', 'true', '2015-08-09 11:11:15'),
(6, '地产商炒作', '地产商炒作，房价又起波澜。', 10, 2, 'false', 'false', 'true', '2015-08-09 11:12:33'),
(10, '《左耳》', '新片上映，收视狂潮，票房过亿。', 10, 1, 'false', 'false', 'true', '2015-08-09 11:52:18'),
(11, '沈阳房价', '沈阳房价降低，1000元每平米', 10, 2, 'false', 'false', 'true', '2015-08-11 08:26:14'),
(12, '房祖名', '龙太子房祖名，出演主角。', 10, 0, 'false', 'false', 'true', '2015-08-11 08:28:20'),
(13, '房子', '开发商接手烂尾楼盘', 10, 2, 'false', 'false', 'true', '2015-08-11 08:30:20'),
(14, '地震，房子倒塌。', '地震，房子倒塌。但是人员并无伤亡。', 10, 2, 'false', 'false', 'true', '2015-08-11 11:25:11');

-- --------------------------------------------------------

--
-- 表的结构 `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `id` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `class`
--

INSERT INTO `class` (`id`, `name`, `description`) VALUES
('0', '体育新闻', ''),
('1', '电影影评', ''),
('2', '商业发展', '');

-- --------------------------------------------------------

--
-- 表的结构 `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` varchar(10) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `article_id` varchar(10) NOT NULL,
  `contents` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `article_id`, `contents`) VALUES
('', '', '', '减肥的官方代表国家法定'),
('', '', '', '好棒'),
('', '', '', '好棒！'),
('', '', '', '令人振奋'),
('', '', '', '猛 '),
('', '', '', '好的'),
('', '', '', '太贵买不起'),
('', '', '5', '加速度发货时发布的身份\r\n'),
('', '', '5', '五二五方法能发出'),
('', '', '5', '房价降低，政府宏观调控');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(24) NOT NULL,
  `password` varchar(62) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `picture` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `mobile`, `created_at`, `picture`) VALUES
(1, 'zoujunbo', 'e0c407e4417eaa35b4ee2ff9f7d6a51b', '1904887391@qq.com', '18240441068', '2015-08-09 04:24:18', '3.jpg'),
(10, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@example.com', '13232323232', '2015-08-12 07:28:30', '3.jpg'),
(11, 'zou_albert', '87d24a36fd9f4d19f3c6947b028a35fd', '1904887391@qq.com', '18240444568', '2015-08-11 21:47:57', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
