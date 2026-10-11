<?php




function  SIPDirectUsers($UserID=null){
	$SQL = '';
	$SpecialUser = ''; 
	if(isset($UserID) and !empty($UserID)){

		$SQL = "SELECT `ID` , `userid` ,  `phone` ,`display_name` FROM `Coinusers` WHERE `referby` = '".$UserID."' AND TotalDeposit2024 >= 50000000000;"; 
		global $DB; $aa = 0; $ts = []; $t = null;$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		return $ts;
	}
	else{$echo = 'UserId ise Required';d($echo);} 
}












function PendingSIPUsers($ActiveDirect=null,$User=null){
	$SQL = '';
	$SpecialUser = ''; 
	if(isset($User) and !empty($User)){$SpecialUser = "AND parent.ID = '".$User."'";}

	//	$SQL = "SELECT parent.ID, team.total_staking_team_users FROM Coinusers AS parent JOIN ( SELECT referby, COUNT(*) AS total_staking_team_users FROM Coinusers WHERE StakingTeamLevel = 1 AND referby IS NOT NULL AND referby != '' GROUP BY referby HAVING COUNT(*) >= ".$ActiveDirect." ) AS team ON parent.userid = team.referby WHERE parent.StakingTeamLevel = 1 AND parent.sip_bonus = 0 ".$SpecialUser.";";

	$SQL = "SELECT parent.ID, team.total_staking_team_users FROM Coinusers AS parent JOIN ( SELECT referby, COUNT(*) AS total_staking_team_users FROM Coinusers WHERE TotalDeposit2024 >= 50000000000 AND referby IS NOT NULL AND referby != '' GROUP BY referby HAVING COUNT(*) >= ".$ActiveDirect." ) AS team ON parent.userid = team.referby WHERE parent.TotalDeposit2024 >= 50000000000 AND parent.sip_bonus = 0 ".$SpecialUser.";"; 





	//echo $SQL;
	global $DB; $aa = 0; $ts = []; $t = null;$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	return $ts;
}




function SIPData($ActiveDirect=null){
	$PendingSIPUsers = [];$Return = [];
	$PendingSIPUsers  =  PendingSIPUsers($ActiveDirect);
	if(isset($PendingSIPUsers) and is_array($PendingSIPUsers)){
		foreach($PendingSIPUsers as $PendingSIPUser){
			$User = null; $User = $PendingSIPUser['ID'];
			if(isset($PendingSIPUser) and !empty($PendingSIPUser)){
				$echo = 'User Found.';

				$Return[$User]['deposit_total_count'] = $PendingSIPUser['total_staking_team_users'];
				//echo '<br><br><br>';
			}
			else{$echo = 'User Not Found.';}
		}
		return $Return;
	}
}



function SIPRewardsNew($ActiveDirect = null){
	$Array = [];
	$Array = [
		['amount_min'=>15,'amount_max'=>29,'bonus'=>30],
		['amount_min'=>30,'amount_max'=>49,'bonus'=>60],
		['amount_min'=>50,'amount_max'=>99,'bonus'=>100],
		['amount_min'=>100,'amount_max'=>199,'bonus'=>200],
		['amount_min'=>200,'amount_max'=>399,'bonus'=>400],
		['amount_min'=>400,'amount_max'=>799,'bonus'=>800],
		['amount_min'=>800,'amount_max'=>1599,'bonus'=>1600],
		['amount_min'=>1600,'amount_max'=>3199,'bonus'=>3200],
		['amount_min'=>3200,'amount_max'=>6399,'bonus'=>6400],
		['amount_min'=>6400,'amount_max'=>99999999,'bonus'=>12800]
	];

	$SIPData = []; $SIPData = SIPData($ActiveDirect);
	if(isset($SIPData) and !empty($SIPData)){
		$echo = 'data Found.';
		foreach($SIPData as $User => $Singe){
			$Reward = 0;
			foreach($Array as $A){
				$DepositAmount = 0; $DepositAmount = $Singe['deposit_total_count'];
				if($DepositAmount >= $A['amount_min'] and $DepositAmount <= $A['amount_max']){ $Reward = p2d($A['bonus']);}
			}

			if($Reward > 0){
				$created = $modified = GMT();
				$name = 'SIP Bonus Direct Count :'.$DepositAmount;
				$user = $buyuser = $selluser = $User;
				$oca = $Reward;$occ = 'USDT';
				$balance = '0';$ttype = 'SIPBonus';
				$amount = $Reward; $ccc = 'USDT';$filled = $DepositAmount; $status = 1;
				$beforebalance = Fundings($User)['usdt'];
				$afterbalance = $beforebalance+$amount;$price = Price();
				$orderid = 'SIPBonus:'.$User.':'.gmdate('Ym');$processing = 0;$walletname='funding';


				$SQL = '';	
				$SQL = "INSERT INTO Coinpods_transaction_copy (created,name,user,oca,occ,balance,ttype,amount,ccc,filled,status,beforebalance,afterbalance,price,orderid,modified,buyuser,selluser,processing,walletname) VALUES ('".$created."','".$name."','".$user."','".$oca."','".$occ."','".$balance."','".$ttype."','".$amount."','".$ccc."',
'".$filled."','".$status."','".$beforebalance."','".$afterbalance."','".$price."','".$orderid."','".$modified."','".$buyuser."','".$selluser."','".$processing."','".$walletname."');";
				global $DB;$results = 0; $results = mysqli_query($DB, $SQL); unset($SQL);
				if($results){
					$echo = 'Transaction Inserted.';
					$SQL_Update = "UPDATE `Coinusers` SET `sip_bonus` = '1'  WHERE `ID` = '".$user."';";
					$resultsupdate = 0; $resultsupdate = mysqli_query($DB, $SQL_Update);unset($SQL_Update);
					$echo = 'Coinusers Update Done';
				}
				else{$echo = 'Transaction Not Insert ? ';}

			}
			else{$echo = 'No reward Metch';}
		}
	}
	else{ $echo = 'No data Found.';}
}




function SIPReset(){
	$SQL = "UPDATE `Coinusers` SET `sip_bonus` = '0'";
	global $DB;$results = 0; $results = mysqli_query($DB, $SQL); unset($SQL);
	if($results){ $echo = 'SIP Reset Done';}else{$echo = 'SIP Reset Faild';}
	echo $echo;
}





function SIPBonusToWallet($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-05-10
	// Input : 
	// Output : Jackpot Reward Transaction Add To Wallet

	$Output=0;
	$PendingJackpotRewardTransaction=PendingSIPBonusTransaction($Q);
	if($PendingJackpotRewardTransaction){
		foreach($PendingJackpotRewardTransaction as $Ps){
			//print_r($PLDT['user']);
			if(AddToFunding(array( 'user'=>$Ps['user'], 'ccc'=>strtolower($Ps['ccc']), 'amount'=>$Ps['amount'] ))){
				Balance1Transaction($Ps['id']);
			}
			else{ Balance2Transaction($Ps['id']); }
		}
	}	
	return $Output;
}



function PendingSIPBonusTransaction($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-05-10
	// Input : 
	// Output : Jackpot Reward Pending Transaction 

	$SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `status` = 1 AND `ttype` LIKE 'SIPBonus'";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;	

}

















?>