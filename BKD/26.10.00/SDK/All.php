<?php
require __DIR__.'/0/0.php';
require __DIR__.'/0/Airdrops.php';
require __DIR__.'/0/API.php';
require __DIR__.'/0/Calls.php';
require __DIR__.'/0/Conversations.php';
//require __DIR__.'/0/CPI.php';
require __DIR__.'/0/Cryptos.php';
require __DIR__.'/0/Currencies.php';
require __DIR__.'/0/Levels.php';
require __DIR__.'/0/Mating.php';
require __DIR__.'/0/Messages.php';
require __DIR__.'/0/Orders.php';
require __DIR__.'/0/OTP.php';
require __DIR__.'/0/Plans.php';
require __DIR__.'/0/Prices.php';
require __DIR__.'/0/Products.php';
require __DIR__.'/0/Search.php';
require __DIR__.'/0/Settings.php';
require __DIR__.'/0/Single.php';
require __DIR__.'/0/Stakes.php';
require __DIR__.'/0/Tools.php';
require __DIR__.'/0/Transactions.php';
require __DIR__.'/0/Users.php';
require __DIR__.'/0/Utilities.php';
require __DIR__.'/0/WalletAddresses.php';
require __DIR__.'/0/Wallets.php';
require __DIR__.'/0/Jackpot.php';
require __DIR__.'/0/Jackpot2.php';
require __DIR__.'/0/Royalty.php';
require __DIR__.'/0/JackpotReward.php';
require __DIR__.'/0/StakeData.php';
require __DIR__.'/0/JackpotRewardData.php';
require __DIR__.'/0/JackpotWorker.php';
require __DIR__.'/0/Share.php';
require __DIR__.'/0/HelloxWinConnect.php';
require __DIR__.'/0/Subordinate.php';
require __DIR__.'/0/Staking.php';
require __DIR__.'/0/Staking2.php';
require __DIR__.'/0/App.php';
require __DIR__.'/0/XAH_Connection.php';
require __DIR__.'/0/Alien.php';
require __DIR__.'/0/Withdraw.php';






//AddToWallet(array( 'user'=>$UserID, 'ccc'=>$PC['ccc'], 'network'=>$PC['network'], 'amount'=>$PC['amount'] ))
//CryptoToWallet();



//CryptosToTransactions(); Run every minute in CronJob
//DepositToWallet();  Run every minute in CronJob
//LevelToWallet(); Run every minute in CronJob

//StakesToStaking(); Run every day in CronJob
//StakingToTransactions(); Run every day in CronJob
//StakingToWallet(); Run every day in CronJob

//WithdrawToWallet(); Run every ajax of Withdraw
//BuyToWallet(); Run every ajax of Buy
//SellToWallet(); Run every ajax of Sell


CreateWallets();
CreateWalletAddresses();

//RewardToWallet();


?>