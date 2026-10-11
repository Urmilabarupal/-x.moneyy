-- Table structure for table `Coinx_notification_setting`

CREATE TABLE IF NOT EXISTS `Coinx_notification_setting` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `user` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `email_notify` tinyint(1) NOT NULL DEFAULT 1,
  `sms_notify` tinyint(1) NOT NULL DEFAULT 0,
  `push_notify` tinyint(1) NOT NULL DEFAULT 1,
  `trade_notify` tinyint(1) NOT NULL DEFAULT 1,
  `stake_notify` tinyint(1) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `processing` int(11) NOT NULL DEFAULT 0,
  `orderid` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `user` (`user`),
  KEY `status` (`status`),
  KEY `orderid` (`orderid`),
  KEY `created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
