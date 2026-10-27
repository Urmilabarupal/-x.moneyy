-- Back up x_money before applying this migration.
-- Adds server-side passcode hash storage; existing accounts require wallet re-verification and passcode setup.
ALTER TABLE `Coinx_users`
  ADD COLUMN `passcode_hash` varchar(255) DEFAULT NULL;
