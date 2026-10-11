-- Table structure for table `Coinx_aip`
-- Used for API registration, scheduling, endpoint details and execution

CREATE TABLE IF NOT EXISTS `Coinx_aip` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `user` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `api_endpoint` varchar(255) DEFAULT NULL,
  `api_method` varchar(20) NOT NULL DEFAULT 'GET',
  `schedule_time` varchar(100) DEFAULT NULL,
  `last_run` datetime DEFAULT NULL,
  `next_run` datetime DEFAULT NULL,
  `interval_seconds` int(11) NOT NULL DEFAULT 0,
  `payload` longtext DEFAULT NULL,
  `response` longtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `processing` int(11) NOT NULL DEFAULT 0,
  `orderid` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `user` (`user`),
  KEY `api_endpoint` (`api_endpoint`),
  KEY `status` (`status`),
  KEY `processing` (`processing`),
  KEY `next_run` (`next_run`),
  KEY `orderid` (`orderid`),
  KEY `created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
