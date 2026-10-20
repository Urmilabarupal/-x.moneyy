-- Run once against the x_money database before deploying API/Register.php.
-- WalletAddress is a legacy numeric column; EVM addresses need a VARCHAR column.
ALTER TABLE `Coinx_users`
  ADD COLUMN `mobile` varchar(20) DEFAULT NULL AFTER `phone`,
  ADD COLUMN `country` varchar(80) DEFAULT NULL AFTER `mobile`,
  ADD COLUMN `wallet_address` varchar(42) DEFAULT NULL AFTER `country`,
  ADD UNIQUE KEY `wallet_address_unique` (`wallet_address`);
