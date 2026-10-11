-- Table structure for table `Coinx_staking_plan`

CREATE TABLE IF NOT EXISTS `Coinx_staking_plan` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `user` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `ccc` varchar(50) DEFAULT NULL,
  `ttype` varchar(50) DEFAULT NULL,
  `roi` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `period` int(11) NOT NULL DEFAULT 0,
  `minamount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `maxamount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `description` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `processing` int(11) NOT NULL DEFAULT 0,
  `orderid` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `user` (`user`),
  KEY `ccc` (`ccc`),
  KEY `ttype` (`ttype`),
  KEY `status` (`status`),
  KEY `orderid` (`orderid`),
  KEY `created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
