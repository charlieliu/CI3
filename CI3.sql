CREATE USER 'asap'@'%' IDENTIFIED BY 'Vt6H2JRmVBJuZx4x';
-- phpMyAdmin SQL Dump
-- version 4.4.11
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2015 年 10 月 21 日 17:55
-- 伺服器版本: 5.5.44-0ubuntu0.14.04.1
-- PHP 版本： 5.5.9-1ubuntu4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `test`
--

-- --------------------------------------------------------

--
-- 資料表結構 `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) COLLATE utf8_bin NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  `HTTP_USER_AGENT` text COLLATE utf8_bin,
  `HTTP_CLIENT_IP` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `HTTP_X_FORWARDED_FOR` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `HTTP_X_CLIENT_IP` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `HTTP_X_CLUSTER_CLIENT_IP` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `REMOTE_ADDR` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `hash_test`
--

CREATE TABLE IF NOT EXISTS `hash_test` (
  `hash_key` varchar(255) COLLATE utf8_bin NOT NULL,
  `md5_var` text COLLATE utf8_bin NOT NULL,
  `sha1_var` text COLLATE utf8_bin NOT NULL,
  `sha256_var` text COLLATE utf8_bin NOT NULL,
  `sha512_var` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `rainbowtable`
--

CREATE TABLE IF NOT EXISTS `rainbowtable` (
  `pwd` varchar(15) COLLATE utf8_bin NOT NULL,
  `md5_var` text COLLATE utf8_bin NOT NULL,
  `sha1_var` text COLLATE utf8_bin NOT NULL,
  `sha256_var` text COLLATE utf8_bin NOT NULL,
  `sha512_var` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(10) NOT NULL,
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `salt` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` varchar(32) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `add_date` int(10) NOT NULL,
  `login_date` int(10) DEFAULT NULL,
  `login_id` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `auth_type` tinyint(4) NOT NULL,
  `addr` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `user_agent`
--

CREATE TABLE IF NOT EXISTS `user_agent` (
  `UA_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `agent_name` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `agent_type` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `agent_system` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `agent_version` varchar(24) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `xhprof_log`
--

CREATE TABLE IF NOT EXISTS `xhprof_log` (
  `run_id` varchar(15) COLLATE utf8_bin NOT NULL,
  `set_name` varchar(15) COLLATE utf8_bin NOT NULL,
  `remark_str` varchar(15) COLLATE utf8_bin NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- 資料表索引 `hash_test`
--
ALTER TABLE `hash_test`
  ADD PRIMARY KEY (`hash_key`);

--
-- 資料表索引 `rainbowtable`
--
ALTER TABLE `rainbowtable`
  ADD PRIMARY KEY (`pwd`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- 資料表索引 `user_agent`
--
ALTER TABLE `user_agent`
  ADD PRIMARY KEY (`UA_id`);

--
-- 資料表索引 `xhprof_log`
--
ALTER TABLE `xhprof_log`
  ADD PRIMARY KEY (`run_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
