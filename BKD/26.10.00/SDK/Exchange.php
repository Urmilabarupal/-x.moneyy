<?php
require __DIR__.'/0/Tools.php';
require __DIR__.'/0/Developer.php';
require __DIR__.'/0/Database.php';
require __DIR__.'/0/Withdraw.php';

require __DIR__.'/0/0.php';



if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron'] or 1){ require __DIR__.'/0/Users.php'; } 

if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/History.php'; }



if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/App.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron'] or 1){ require __DIR__.'/0/Staking2.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron'] or 1){ require __DIR__.'/0/Staking.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron'] or 1){ require __DIR__.'/0/StakingD3.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron'] or 1){ require __DIR__.'/0/Subordinate.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/HelloxWinConnect.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Share.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/JackpotWorker.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/JackpotRewardData.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/StakeData.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/JackpotReward.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Royalty.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Jackpot2.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Jackpot.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Deposit.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Transfer.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Airdrops.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){  __DIR__.'/0/API.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Calls.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Conversations.php'; }
//require __DIR__.'/0/CPI.php';
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Cryptos.php'; }
require __DIR__.'/0/Currencies.php';
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Messages.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Orders.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/OTP.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Plans.php'; }
require __DIR__.'/0/Prices.php';
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Products.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Search.php'; }
require __DIR__.'/0/Settings.php';
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Single.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Transactions.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Utilities.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/WalletAddresses.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Wallets.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Send.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Chart.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Feature_Meta.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/TimingSystem.php'; }

 
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Mating.php'; }


if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron'] or 1){ require __DIR__.'/MLM.php'; }
if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){ require __DIR__.'/0/Servers.php'; }

if($_REQUEST['ajax'] or $_REQUEST['api'] or $_REQUEST['cron']){
	
//TicketLevels(i['id']);
	
}

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
//RewardToWallet();
 

?>