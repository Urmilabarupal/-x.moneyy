-- Table structure for table `Coinx_cron`
-- Used for Cron Jobs registration, schedules, logs, and background worker executions

CREATE TABLE IF NOT EXISTS `Coinx_cron` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `user` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `cron_url` varchar(255) DEFAULT NULL,
  `command` varchar(255) DEFAULT NULL,
  `expression` varchar(100) DEFAULT NULL,
  `interval_minutes` int(11) NOT NULL DEFAULT 1,
  `last_run` datetime DEFAULT NULL,
  `next_run` datetime DEFAULT NULL,
  `execution_time` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `response` longtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `processing` int(11) NOT NULL DEFAULT 0,
  `orderid` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `user` (`user`),
  KEY `cron_url` (`cron_url`),
  KEY `status` (`status`),
  KEY `processing` (`processing`),
  KEY `next_run` (`next_run`),
  KEY `orderid` (`orderid`),
  KEY `created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
