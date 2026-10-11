<?php
import('MLM');


$PHP['Staking']['modified'] = '2024-11-13';
$PHP['Staking']['by'] = 'Pawan Kumar';

$PHP['Staking']['function'][1] = 'Staking_Income($Uid=NULL)';
$PHP['Staking']['function'][2] = 'Staking_IncomeNew($Q=null)';
$PHP['Staking']['function'][3] = 'Staking_IncomeStatus($Q=null)';
$PHP['Staking']['function'][4] = 'Staking_IncomeUpdate($Q=null)';
$PHP['Staking']['function'][5] = 'Staking_Incomes($Q=null)';
$PHP['Staking']['function'][6] = 'StakingToTransaction($Q=null)';
$PHP['Staking']['function'][7] = 'StakingToTransactions($Q=null)';
$PHP['Staking']['function'][8] = 'Staking($Q=null)';
$PHP['Staking']['function'][9] = 'Stakes($Q=null)';
$PHP['Staking']['function'][10] = 'Spot_StakingStatus($Q=null)';
$PHP['Staking']['function'][11] = 'StakingNew($Q=null)';
$PHP['Staking']['function'][12] = 'Spot_StakingUpdate($Q=null)';
$PHP['Staking']['function'][13] = 'Spot_Stakings($Q=null)';
$PHP['Staking']['function'][14] = 'Spot_Staking($Q=null)';
$PHP['Staking']['function'][15] = 'Staking_PlanStatus($Q=null)';
$PHP['Staking']['function'][16] = 'Staking_PlanUpdate($Q=null)';
$PHP['Staking']['function'][18] = 'Staking_PlanNew($Q=null)';
$PHP['Staking']['function'][19] = 'Staking_Plans($Q=null)';
$PHP['Staking']['function'][20] = 'Staking_Plan($Q=null)';
$PHP['Staking']['function'][21] = 'PendingStakingTransactions($Q=null)';
$PHP['Staking']['function'][22] = 'Staking_IncomeToWallet($Q=null)';
$PHP['Staking']['function'][23] = 'StakesToStaking($UID=null)';


function StakingAutoNew($Q=null){
	// Developer : Pawan kumar
	// Date : 2024-04-17
	// Input : Amount, CCC
	// Output : Array Data By New Staking Created.

	$echo = 'Staking New Start.';
	$Output=0;
	

	if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $PlanID=$Q['planid']; $User = $Q['user']; }
	else{ $echo = 'Q data not found.'; }

	$Name = 'Auto Staking New '.$User.' of Amount '.$Amount.' at '.GMT();
	//$Spot_wallets = Spot_wallets(array('user'=>i['id'], 'ccc'=>$CCC));
	//$Wallets = $Spot_wallets[0];

	$Wallets = Wallets($User);
	$echo = 'Spot_wallets data found.';

	if($User and $Amount and $CCC and $PlanID){
		$echo = 'Userid and amount and ccc our planid found.';
		//echo $Wallets[$CCC].' : '.p2d($Amount).'<br>';
		if(number_format($Wallets[$CCC],2)>=number_format(p2d($Amount),2)){
			$echo = 'The amount in the wallet is fine, go ahead.';

			$Array=['id'=>$PlanID, 'minamount'=>$Amount, 'ccc'=>$CCC, 'maxamount'=>$Amount, 'status'=>1]; 
			$Plans=Staking_Plans($Array); unset($Array);
			$Plan=$Plans[count($Plans)-1];
			if($Plan){
				$echo = 'Staking_Plans data found.';

				$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), 'AutoStaking:".$User.Clean(GMT())."', '".$User."', '', '', '1', 'Staking', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."');";
				$echo = 'Coinpods_transaction SQL found.'; 
				global $DB;$aa = 0; $Staked = mysqli_query($DB, $SQL);

				$Wallets = Wallets($User);
				$echo = 'Obtained by subtracting the amount in spot_wallet data.';

				$Walletss=$Wallets[strtolower($CCC)];
				$Walletss=$Walletss-p2d($Amount);
				$echo = 'Amount has been subtracted from Spot_wallet no problem.';

				if($Staked){ 
					$echo = 'The entry into the coinpods_transaction table has been successfully made.';

					$SQL1="UPDATE `Coinpods_wallet` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_wallet`.`user` = '".$User."';";
					unset($Walletss);
					$echo = 'Earn_Wallet SQL found.';
					global $DB;$aa = 0; $Walleted = mysqli_query($DB, $SQL1);

				}
				if($Walleted){
					$echo = 'Success SMS from Wallet has arrived, go ahead.';
					$UserData = SingleUser($User);

					$Price=Price('',[ 'branch'=>$UserData['branch'] ]); 
					$USDT=$Amount*$Price;

					$SQL2="INSERT INTO `Coinpods_staking`(`id`, `name`, `created`, `modified`, `amount`, `user`, `ccc`, `roi`, `period`, `ttype`, `status`, `ist`, `price`, `usd`, `plan`, `uid`, `privacy`, `app`, `apr`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), '".p2d($Amount)."', '".$User."', '".$CCC."', '".$Plan['roi']."', '".$Plan['period']."', '".$Plan['ttype']."', '1', '".IST()."', '".$Price."', '".p2d($USDT)."', '".$Plan['id']."', 'NULL', 'Public', '1', '".$Plan['apr']."')";
					$echo = 'Coinpods_staking SQL found.';
					global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL2);
					$SID=mysqli_insert_id($DB);

					if($SID){

						$Dispatch  = 1;

						if($Dispatch){
							$echo = "Successfully Found.";

							if(strtolower($CCC) == 'ccc'){ $Pair = 'CCC_CCC'; }
							elseif(strtolower($CCC) == 'usdt'){ $Pair = 'USDT_USDT'; }
							else{ $Pair = 'CCC_CCC'; }

							$Array=['feature'=>'Staking','pair'=>$Pair,'user'=>$User,'amount'=>p2d($Amount),];
							HistoryUpdateNew($Array);
						}
						else{ $echo = "Not Found."; }

						$echo = 'Insert Id Found of Coinpods_Staking.';	

						$SQL3="UPDATE `Coinpods_staking` SET `uid`='".$SID."' WHERE `id` = '".$SID."'";
						global $DB; $aa = 0; $Outputt = mysqli_query($DB, $SQL3);
						$echo = 'uid update success.';

					}
					else{ $echo = 'Insert ID of Coinpods_Staking not found.'; }
				}
				else{ $echo = 'No response received from Spot_wallet.'; }
			}
			else{ $echo = 'Stalking plan not found.'; }
		}
		else{ $echo = 'The amount in the wallet is not complete.'; }
	}
	else{ $echo = 'Not enough sources.'; }
	//echo $echo;
	return $SID;

}






function StakingsAutoNew($Q=null){
	// Auto Staking Created By JAspal Byavat


	$LastHour = gmdate('Y-m-d H:i:s', strtotime('-1 minutes'));
	$SQL = "SELECT * FROM `".prefix."pods_wallet` WHERE `modified` <= '".$LastHour."' AND `ccc` >= 10000000 ORDER BY `id` DESC LIMIT 1";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); 
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	//echo $SQL;
	
	if($ts){
		$echo = 'Yes Pendings';
		foreach($ts as $Single){
			if($Single){
				$echo = 'Single Data Found.';
				$Amount = d2p($Single['ccc']);
				$Array = ['id'=>$PlanID,'minamount'=>$Amount,'ccc'=>$CCC,'maxamount'=>$Amount,'status'=>1]; 
				$Plans=Staking_Plans($Array);unset($Array); 
				$Plan=$Plans[count($Plans)-1]; 
				if($Plan){
					if($Plan['status']==1 and $Single['user'] != 744873004151 and  $Single['user'] != 1){

						$Array = ['amount'=>$Amount,'ccc'=>'ccc','planid'=>$Plan['id'],'user'=>$Single['user']];

						$StakingAutoNew=0;
						//print_r($Array);
						$StakingAutoNew = StakingAutoNew($Array);
						if($StakingAutoNew){
							$echo = 'Success';
							StakingToDirectBusinessUpdate($Single['user']);
						}
						else{$echo = 'Faild';}
					}
					else{$echo = 'Plan Is Disabled';}
				}
				else{$echo = 'Plan Not Match';}
			}
			else{$echo = 'Single Not Data Found.';}

			$Return[$Single['user']] = ['o'=>$StakingAutoNew,'c'=>$echo];
		}
	}
	else{$echo = 'No Pendings';}
	return $Return;
}








function StakingToDirectBusinessUpdate($Q=null){

	if($Q){

		$user=user($Q);
		if($user){
			$Referby=$user['referby'];
			if($Referby){
				$Upline=UserByUserID($Referby);

				//Level1StakeTotal($Upline['ID']);
				Level1StakeTotall($Upline['ID']); // Temporary Changed By JAspal Byavat


			}
		}
	}
}



function StakingLevelEnable($Q=null){

	//$MaxDate = date("Y-m").'-31 23:59:59'; // Next month iss date ko change karna hai.
	//$MaxDate = gmdate("Y-m").'-30'; // Next month iss date ko change karna hai.

	 $MaxDate = date("Y-m-t"); //USE THIS After Testing

	$SQL="
		UPDATE `Coinusers` SET `StakingLevel`='".$MaxDate."' WHERE `Level1StakeTotal` >= 50000000000 AND `StakingLevel` != '".$MaxDate."';
		UPDATE `Coinusers` SET `StakingTeamLevel`='1' WHERE `Level1StakeTotal` >= 50000000000 AND `StakingTeamLevel` = '0';
		UPDATE `Coinusers` SET `StakingTeamLevel1`='1' WHERE `Level3StakeTotal` >= 500000000000 AND `StakingTeamLevel1` = '0';
	";

	global $DB;$aa = 0;	$results = mysqli_multi_query($DB, $SQL);	
	if($results){
		$Return = true;
		//  Yahi pe lagana zaruri hai
		while(mysqli_more_results($DB) && mysqli_next_result($DB)){
			// Result sets clear kar diye gaye
		}
	}
	else{ $Return = false;
		 // Optional: error print
		 // echo "Error: " . mysqli_error($DB);
		}
	return $Return;	
}





/*
function StakingLevelEnable($Q=null){

	//$MaxDate = date("Y-m").'-31 23:59:59'; // Next month iss date ko change karna hai.
	$MaxDate = gmdate("Y-m").'-31'; // Next month iss date ko change karna hai.

    // $MaxDate = date("Y-m-t"); USE THIS After Testing

	$SQL="
		UPDATE `Coinusers` SET `StakingLevel`='".$MaxDate."' WHERE `Level1StakeTotal` >= 50000000000 AND `StakingLevel` != '".$MaxDate."';
		UPDATE `Coinusers` SET `StakingTeamLevel`='1' WHERE `Level1StakeTotal` >= 50000000000 AND `StakingTeamLevel` = '0';
		UPDATE `Coinusers` SET `StakingTeamLevel1`='1' WHERE `Level3StakeTotal` >= 500000000000 AND `StakingTeamLevel1` = '0';
	";

	global $DB;$aa = 0;	$results = mysqli_multi_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}

	return $ts;	

}

*/




function Level1StakeTotal($Q=null){ 
	// Developer : Pawan Kumar
	// Date : 2024-11-30
	// Input : UserID
	// Output : Total Staking Level 1


	if(!$Q){ $Q=i['id']; }
	$B=0; 
	if($Q){	

		$Downlines = Subordinates(['user'=>$Q, 'level'=>1, 'LIMIT'=>1111111]);
		if($Downlines){
			$aa=0;
			foreach($Downlines as $Level){
				$aa++;  
				$User=user($Level['subordinate']);
				$SS365Days=PendingSelfDeposit($Level['subordinate']);
				if($SS365Days['amount']){

					$Userr=$SS365Days['amount']; 
					$B=$B+$Userr;
					if($B){

						$SQL="UPDATE `Coinusers` SET `Level1StakeTotal` = '".$B."' WHERE `Coinusers`.`ID` = '".$Q."';";
						global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);

					}  //ELSE ME 
				}
			}
		}
	}
	if($B){ /*UpdateTeamStake($B);*/ return $B; }
}






function TeamStakingUpdate($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-11-30
	// Input :
	// Output : Update Team Total Staking 1 to 3 level

	if(!$Q){ $Q=i['id']; }
	$TotalTeamStaking = TotalTeamStaking($Q);
	if($TotalTeamStaking){

		$SQL="UPDATE `Coinusers` SET `Level3StakeTotal` = '".$TotalTeamStaking."' WHERE `Coinusers`.`ID` = '".$Q."';";
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);

	}
	return $TotalTeamStaking;
}




function TotalTeamStaking($Q=null){ 
	// Developer : Pawan Kumar
	// Date : 2024-11-30
	// Input : UserID
	// Output : Total Team Staking 1 To 3 Level

	if(!$Q){ $Q=i['id']; }
	$B=0; 
	if($Q){	

		$Downlines = Subordinates(['user'=>$Q, 'minlevel'=>1, 'maxlevel'=>3, 'LIMIT'=>1111111]);  
		if($Downlines){
			$aa=0;
			foreach($Downlines as $Level){
				$aa++;  
				$User=user($Level['subordinate']);
				$SS365Days=PendingSelfDeposit($Level['subordinate']);
				if($SS365Days['amount']){

					$User=$SS365Days['amount']; 
					$B=$B+$User;

				}
			}
		}
	}
	if($B){ /*UpdateTeamStake($B);*/ return $B; }
}


function SelfStakingPending365Days($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-11-29
	// Input :
	// Output : Pending Self Total Staking 

	if($Q){

		$Start = date("Y-m").'-01 00:00:01'; $End = date("Y-m").'-31 23:59:59';
		//$Start = '2024-12-01 00:00:01'; $End = '2025-01-01 23:59:59';

		$SQL="SELECT `user`, SUM(`usd`) AS 'amount' FROM `Coinpods_staking` WHERE `created` BETWEEN '".$Start."' AND '".$End."' AND `user`='".$Q."' AND `period` >= 365 GROUP BY `user`;"; //echo $SQL;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}

	}
	return $ts[0];	
}




function SelfStakingPending($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-11-29
	// Input :
	// Output : Pending Self Total Staking 

	$Start = date("Y-m").'-01 00:00:01'; $End = date("Y-m").'-31 23:59:59';

	//$Start = '2024-12-01 00:00:01'; $End = '2025-01-01 23:59:59';

	$SQL="SELECT `user`, SUM(`usd`) AS 'amount' FROM `Coinpods_staking` WHERE `created` BETWEEN '".$Start."' AND '".$End."' AND `period` >= 30 GROUP BY `user`;";  
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}

	return $ts;	

}


function SelfStakingUpdate($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-11-29
	// Input :
	// Output : Update Self Total Staking 

	$SelfStakingPending = SelfStakingPending();
	if($SelfStakingPending){
		foreach($SelfStakingPending as $Ps){
			//print_r($Ps['user'].' '.$Ps['amount']); echo '<br>';

			$SQL="UPDATE `Coinusers` SET `SelfStaking` = '".$Ps['amount']."' WHERE `Coinusers`.`ID` = '".$Ps['user']."';";
			global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	

		}
	}
	return $results;
}









/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function Staking_Offer($Uid=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input :uid   
	// Output :data retrieval 
	if($Uid){

		$SQL="SELECT * FROM `".prefix."pods_staking_offer` WHERE `uid`='".$Uid."'";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}

		return $ts[0];

	}
}


function Staking_OfferStatus($UID=null,$Status=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input :uid  and status  
	// Output :change status only enable and disable


	if($UID and $Status){

		if($Status == 'enable'){$Status = 1;}
		elseif($Status == 'disable'){$Status = 0;} else{$Status ='';}

		$SQL="UPDATE `".prefix."pods_staking_offer` SET `modified`= current_timestamp(), `status`='".$Status."' WHERE `uid`='".$UID."'";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		return $results;

	}
}





function Staking_OfferNew($Q=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input :array  
	// Output :Insert new data

	if(is_array($Q)){ $Name=$Q['name']; $User=$Q['user']; $Privacy=$Q['privacy']; $App=$Q['app']; $Maxamount=$Q['maxamount']; $Ttype=$Q['ttype']; $Minamount=$Q['minamount']; $Ccc=$Q['ccc']; $Status=$Q['status']; $Roi=$Q['roi']; $Period=$Q['period']; $Description=$Q['description']; }

	if($Name and $User and $Privacy and $App and $Maxamount and $Ttype and $Minamount and $Ccc and $Status and $Roi and $Period and $Description){
		if($Status == 'enable'){$StatusValue = 1 ;}
		elseif($Status == 'disable'){$StatusValue = 0; }

		$SQL="INSERT INTO `".prefix."pods_staking_offer`(`id`, `name`, `created`, `modified`, `user`, `uid`, `privacy`, `app`, `maxamount`, `ttype`, `minamount`, `ccc`, `status`, `roi`, `period`, `description`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), '".$User."', NULL, '".$Privacy."', '".$App."', '".$Maxamount."', '".$Ttype."', '".$Minamount."', '".$Ccc."', '".$StatusValue."', '".$Roi."', '".$Period."', '".$Description."')";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);

		if($results){

			$SQL1="UPDATE `".prefix."pods_staking_offer` SET `uid`= `id` WHERE `uid` IS NULL";
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);

		}
		return $Output;
	}
	else{ $echo='All parametr required'; }
	//echo $echo;
}



function Staking_OfferUpdate($Q=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input :array  
	// Output :Update data


	if(is_array($Q)){$Name=$Q['name']; $User=$Q['user']; $Privacy=$Q['privacy']; $App=$Q['app']; $Maxamount=$Q['maxamount']; $Ttype=$Q['ttype']; $Minamount=$Q['minamount']; $Ccc=$Q['ccc']; $Status=$Q['status']; $Roi=$Q['roi']; $Period=$Q['period'];
					 $Description=$Q['description']; $UID=$Q['uid']; }


	$modified=" SET `modified` = current_timestamp()";

	if($Name){$Name=", `name` = '".$Name."'";}
	if($User){$Uer=", `user` = '".$User."'";}
	if($Privacy){$Privacy=", `Privacy` = '".$Privacy."'";}
	if($App){$App=", `app` = '".$App."'";}
	if($Maxamount){$Maxamount=", `maxamount` = '".$Maxamount."'";}
	if($Ttype){$Ttype=", `ttype` = '".$Ttype."'";}
	if($Minamount){$Minamount=", `minamount` = '".$Minamount."'";}
	if($Ccc){$Ccc=", `ccc` = '".$Ccc."'";}
	if($Roi){$Roi=", `roi` = '".$Roi."'";}
	if($Period){$Period=", `period` = '".$Period."'";}
	if($Description){$Description=", `description` = '".$Description."'";}
	if($Status == 'enable'){$Statusvalue = ", `status`='1'";}
	elseif($Status=='disable'){$Statusvalue = ", `status`='0'";}

	$SET=$modified.$Name.$User.$Privacy.$App.$Maxamount.$Ttype.$Minamount.$Ccc.$Roi.$Period.$Description.$Statusvalue;

	$SQL ="UPDATE `".prefix."pods_staking_offer` ".$SET." WHERE `".prefix."pods_staking_offer`.`uid` = '".$UID."'";
	global $DB; $users = mysqli_query($DB, $SQL); 
	if(mysqli_num_rows($users) > 0){ while($user = mysqli_fetch_assoc($users)){ $ts[$aa] = $user; $aa++;}} 
	else{$ts = null;}	

	$s=1;$logs=$SQlL;
	return array('s'=>$s,'logs'=>$logs);  
}


function Staking_Offers($Q=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input :array  
	// Output :Search function

	if(is_array($Q)){

		$Sort = $Q['Sort'];
		$Id=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Name=isset($Q['name'])?" AND `name` = '".$Q['name']."'" : '';
		$User=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$Uid=isset($Q['uid'])?" AND `uid` = '".$Q['uid']."'" : '';
		$Privacy=isset($Q['privacy'])?" AND `privacy` = '".$Q['privacy']."'" : '';
		$App=isset($Q['app'])?" AND `app` = '".$Q['app']."'" : '';
		$Maxamount=isset($Q['maxamount'])?" AND `maxamount` = '".$Q['maxamount']."'" : '';
		$Ttype=isset($Q['ttype'])?" AND `ttype` = '".$Q['ttype']."'" : '';
		$Minamount=isset($Q['minamount'])?" AND `minamount` = '".$Q['minamount']."'" : '';
		$Ccc=isset($Q['ccc'])?" AND `ccc` = '".$Q['ccc']."'" : '';
		$Roi=isset($Q['roi'])?" AND `roi` = '".$Q['roi']."'" : '';
		$Period=isset($Q['period'])?" AND `period` = '".$Q['period']."'" : '';
		$Description=isset($Q['description'])?" AND `description` = '".$Q['description']."'" : '';
		$StatusCondition = isset($Q['status']) ? ($Q['status'] == 'enable' ? ' AND `status` = 1' : ($Q['status'] == 'disable' ? ' AND `status` = 0' : '')) : '';

		if($Sort == 'id'){ $Sortt = 'id'; }
		elseif($Sort == 'name'){ $Sortt = 'name'; }
		elseif($Sort == 'user'){ $Sortt = 'user'; }
		elseif($Sort == 'uid'){ $Sortt = 'uid'; }
		elseif($Sort == 'privacy'){ $Sortt = 'privacy'; }
		elseif($Sort == 'app'){ $Sortt = 'app'; }
		elseif($Sort == 'maxamount'){ $Sortt = 'maxamount'; }
		elseif($Sort == 'ccc'){ $Sortt = 'ccc'; }
		elseif($Sort == 'roi'){ $Sortt = 'roi'; }
		elseif($Sort == 'period'){ $Sortt = 'period'; }
		elseif($Sort == 'description'){ $Sortt = 'description'; }
		elseif($Sort == 'status'){ $Sortt = 'status'; }

		else{$Sortt='id';}
		$SortBy = strtoupper($Q['sortby']); if(!$SortBy){ $SortBy='ASC'; }

	}
	$WhereClause="1".$Id.$Name.$Uid.$User.$Privacy.$App.$Maxamount.$Ttype.$Minamount.$Ccc.$Roi.$Period.$Description.$StatusCondition; 

	$Limit=isset($Q['LIMIT'])? $Q['LIMIT'] : ''; 
	if(!$Limit){ $Limit = 10; }

	$Offset=isset($Q['OFFSET'])? $Q['OFFSET'] : 0;

	$SQL = "SELECT * FROM `".prefix."pods_staking_offer` WHERE ".$WhereClause." ORDER BY `".$Sortt."` $SortBy  LIMIT ".$Limit." OFFSET ".$Offset; //echo  $SQL;
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); 
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;} 

	return $ts; 

}







function Staking_IncomeToWallet($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-05-02
	// Input :
	// Output : Add Balance to Wallet from Transaction(Staking)

	$echo = 'Staking_Income To Wallet Start.';
	$Output=0;	
	$Staking_Incomes=Staking_Incomes(['status'=>1, 'balance'=>'false', 'LIMIT'=>11111111]);	
	if($Staking_Incomes){
		$echo = 'Staking Income Pending Users Found.';

		foreach($Staking_Incomes as $Ps){
			$echo = 'Forech Good Working.';

			if(AddToStaking_Wallet(array( 'user'=>$Ps['user'], 'ccc'=>strtolower($Ps['ccc']), 'amount'=>$Ps['amount'] ))){
				Staking_IncomeUpdate(array('uid'=>$Ps['id'], 'balance'=>1));
				$Output=1;
				$echo = 'Amount Add To Staking Wallet Success.';
			}
			else{ 
				Staking_IncomeUpdate(array('uid'=>$Ps['id'], 'balance'=>2));
				$echo = 'Internal Error.';
			}
		}
	}
	else{ $echo = 'Pending Users Not Found.'; }
	return $Output;
}



function PendingStakingTransactions($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-05-02
	// Input :
	// Output : Pending Transaction Staking Income

	if($Q){ $SQL="SELECT * FROM `".prefix."pods_staking_income` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'StakingIncome'"; }
	else{ $SQL="SELECT * FROM `".prefix."pods_staking_income` WHERE `balance` = 0 AND `ttype` = 'StakingIncome'"; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;	

}






function Staking_Income($Uid=NULL){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input : Uid 
	// Output : Singal transaction select karta hai.

	if($Uid){

		$SQL="SELECT * FROM `".prefix."pods_staking_income` WHERE `uid`='".$Uid."'"; ;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}

		return $ts[0]; 

	}
}


function Staking_IncomeNew($Q=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input : array  
	// Output :insert  New data

	if(is_array($Q)){ $Name=$Q['name']; $User=$Q['user']; $Ttype=$Q['ttype']; $Amount=$Q['amount']; }
	if($Name and $User and $Ttype and $Amount){


		$SQL="INSERT INTO `".prefix."pods_staking_income`(`id`, `name`, `created`, `modified`, `user`,  `privacy`, `app`, `ttype`, `amount`, `ccc`, `status`, `balance`, `processing`) VALUES ('NULL', 'Staking Income:".$Name.":".GMT()."', current_timestamp(), current_timestamp(), '".$User."', 'Public', '1', '".$Ttype."', '".$Amount."', 'usdt', '1', '0', '' )";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		$IID = mysqli_insert_id($DB);
		if($results){

			$SQL1="UPDATE `".prefix."pods_staking_income` SET `uid`='".$IID."' WHERE `id`='".$IID."'" ;
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);

		}
	}
	return $Output;
}




function Staking_IncomeStatus($UID=null, $Status=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input : uid
	// Output :Change status 


	if($UID and $Status){ 

		if($Status == 'enable'){ $StatusValue = 1; }
		elseif($Status == 'disable'){ $StatusValue = 0; } else{$Status ='';}

		$SQL="UPDATE `".prefix."pods_staking_income` SET `modified`=current_timestamp(),`status`='".$StatusValue."'WHERE `uid`='".$UID."'"; 
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);

		return $results; 

	}
}



function Staking_IncomeUpdate($Q=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input : array
	// Output :Update data 

	if(is_array($Q)){ $ID=$Q['id']; $Name=$Q['name']; $User=$Q['user']; $Privacy=$Q['privacy']; $App=$Q['app']; $Ttype=$Q['ttype']; $Amount=$Q['amount']; $CCC=$Q['ccc']; $Status=$Q['status']; $Balance=$Q['balance']; $Processing=$Q['processing']; $UID=$Q['uid'];}

	$s=0; global $DB;

	$Modified=" SET `modified` = current_timestamp()";
	if($ID){$ID=", `id` = '".$ID."'";}
	if($Name){$Name=", `name` = '".$Name."'";}
	if($User){$User=", `user` = '".$User."'";}
	if($Privacy){$Privacy=", `privacy` = '".$Privacy."'";}
	if($App){$App=", `app` = '".$App."'";}
	if($Ttype){$Ttype=", `ttype` = '".$Ttype."'";}
	if($Amount){$Amount=", `amount` = '".$Amount."'";}
	if($CCC){$CCC=", `ccc` = '".$CCC."'";}
	if($Balance){$Balance=", `balance` = '".$Balance."'";}
	if($Processing){$Processing=", `processing` = '".$Processing."'";}
	if($Status){$Status=", `status` = '".$Status."'";}

	//if($Status == 'enable'){$Statusvalue = ", `status`='1'";}
	//elseif($Status=='disable'){$Statusvalue = ", `status`='0'";}  

	$SET=$ID.$Modified.$Name.$User.$Privacy.$App.$Ttype.$Amount.$CCC.$Balance.$Processing.$Status; 

	$SQL ="UPDATE `".prefix."pods_staking_income` ".$SET." WHERE `".prefix."pods_staking_income`.`uid` = '".$UID."'";  
	$users = mysqli_query($DB, $SQL); 

	$s=1;
	$logs=$SQLl;
	return array('s'=>$s,'logs'=>$logs);  
}





function Staking_Incomes($Q=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input : array
	// Output :Search all data 

	if(is_array($Q)){

		$Sort = $Q['Sort'];
		$Id=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Uid=isset($Q['uid'])?" AND `uid` = '".$Q['uid']."'" : '';
		$Name=isset($Q['name'])?" AND `name` = '".$Q['name']."'" : '';
		$Usre=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$Privacy=isset($Q['privacy'])?" AND `privacy` = '".$Q['privacy']."'" : '';
		$App=isset($Q['app'])?" AND `app` = '".$Q['app']."'" : '';
		$Ttype=isset($Q['ttype'])?" AND `ttype` = '".$Q['ttype']."'" : '';
		$Amount=isset($Q['amount'])?" AND `amount` = '".$Q['amount']."'" : '';
		$CCC=isset($Q['ccc'])?" AND `ccc` LIKE '".$Q['ccc']."%'" : '';
		$Processing=isset($Q['processing'])?" AND `processing` = '".$Q['processing']."'" : '';

		if(strtolower($Q['status']) == 'false'){ $Status = " AND `status` = '0'"; }
		else{  $Status = " AND `status` = '".$Q['status']."'"; }

		if(strtolower($Q['balance']) == 'false'){ $Balance = " AND `balance` = '0'"; }
		else{ $Balance = " AND `balance` = '".$Q['balance']."'"; }


		if($Sort == 'id'){ $Sortt = 'id'; }
		elseif($Sort == 'uid'){ $Sortt = 'uid'; }
		elseif($Sort == 'name'){ $Sortt = 'name'; }
		elseif($Sort == 'user'){ $Sortt = 'user'; }
		elseif($Sort == 'privacy'){ $Sortt = 'privacy'; }
		elseif($Sort == 'app'){ $Sortt = 'app'; }
		elseif($Sort == 'ttype'){ $Sortt = 'ttype'; }
		elseif($Sort == 'amount'){ $Sortt = 'amount'; }
		elseif($Sort == 'balance'){ $Sortt = 'balance'; }
		elseif($Sort == 'processing'){ $Sortt = 'processing'; }
		elseif($Sort == 'status'){ $Sortt = 'status'; }
		elseif($Sort == 'ccc'){ $Sortt = 'ccc'; }

		else{$Sortt='id';}
		$SortBy = strtoupper($Q['sortby']); if(!$SortBy){ $SortBy='ASC'; }

	}

	$WhereClause="1".$Id.$Uid.$Name.$Usre.$Privacy.$App.$Ttype.$Amount.$CCC.$Balance.$Processing.$Status;

	$Limit=isset($Q['LIMIT'])? $Q['LIMIT'] : ''; 
	if(!$Limit){ $Limit = 10; }


	$Offset=isset($Q['OFFSET'])? $Q['OFFSET'] : 0;

	$MethodColumn=strtolower($Q['methodcolumn']);
	if($MethodColumn){ $MC='(`'.$MethodColumn.'`)'; } 
	else{ $MC=''; }

	$Method = strtoupper($Q['method']);
	if(!$Method){ $Method='*'; }
	$MM=$Method.$MC;





	$SQL = "SELECT ".$MM." FROM `".prefix."pods_staking_income` WHERE ".$WhereClause." ORDER BY `".$Sortt."` $SortBy  LIMIT ".$Limit." OFFSET ".$Offset;

	//echo $SQL;
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);  
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;} 


	if($MC){ $return=$ts[0][$Method.$MC]; }else{ $return=$ts;}
	return $return;   

}




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Staking Feature Start //





function StakingToTransaction($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-05-01
	// Input : Array
	// Output : INSERT
	$BeforeBalance=$AfterBalance=0;


	$ech = 'Staking To Transaction Start.';
	if($Q){
		$echo = 'Q data found.';

		if($Q['staking']){
			$echo = 'Staking Found.';
			$Staking_Wallets=Staking_Wallets($Q['user']);
			$BeforeBalance=$Staking_Wallets['usdt'];
			$AfterBalance=$BeforeBalance+$Q['staking'];
			
			//

			$SQL="INSERT INTO `".prefix."pods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`) VALUES (NULL, 'Staking Income:".$Q['id'].":".GMT()."', current_timestamp(), current_timestamp(), 'StakingIncome".$Q['id']."at".Clean(GMT())."', '".$Q['user']."', '', '', '1', 'StakingIncome', '".$Q['staking']."', 'usdt', '1', '".$BeforeBalance."', '".$AfterBalance."');";
			$echo = 'SQL Found.'; 
			global $DB;	$Output = mysqli_query($DB, $SQL);
			if($Output){ 
				$echo = 'Coinpods Transaction Output Found.';


				$SQL2="UPDATE `".prefix."pods_staking` SET `totalstaking` = `totalstaking` + `staking`, `staking` = 0 WHERE `".prefix."pods_staking`.`id` = '".$Q['id']."';"; //echo $SQL2;
				global $DB;	$Output = mysqli_query($DB, $SQL2);
				if($Output){
					$echo = 'Coinpods Staking Output Found.';

					$Array = array( 'name'=>$Q['id'], 
								   'user'=>$Q['user'], 
								   'ttype'=>'StakingIncome', 
								   'amount'=>$Q['staking'], 
								   'ccc'=>strtolower($Q['ccc']), 
								  );
					$echo = 'Array data found.';

					$Staking_IncomeNew = Staking_IncomeNew($Array);
					if($Staking_IncomeNew){

						//$Input = ['feature'=>'Staking_Income','amount'=>$Q['staking'],'pair'=>'USDT_USDT','user'=>$Q['user']];
						//LiveData___Feature_Meta($Input);



						$echo = 'Staking_Income New Output Found.';

					}
					else{ $echo = 'Staking_Income New Output Not Found.'; }
				}
				else{ $echo = 'Coinpods Staking Output Not Found.'; }
			}
			else{ $echo = 'Coinpods Transaction Output Not Found.'; }
		}
		else{ $echo = 'Staking Not Found.'; }
	}
	else{ $echo = 'Q Data Not Found.'; }
	return $Output;
	//echo $echo;
} 	






function StakingToTransactions(){
	// Developer : Pawan Kumar
	// Date : 2024-05-01
	// Input : 
	// Output : Staking To Transaction And Staking_Income
	$Dispatche=0;
	$Stakings = Spot_Stakings(array('status'=>1,'staking'=>1, 'sort'=>'id', 'sortby'=>'desc', 'limit'=>11111111, ));
	if($Stakings){
		foreach($Stakings as $Staking){

			StakingToTransaction($Staking);

			if($Dispatche==1){
				$Array=['feature'=>'Staking_Income','pair'=>'USDT_USDT','user'=>$Staking['user'],'amount'=>$Staking['staking'],];
				HistoryUpdateNew($Array);unset($Array);
			}

		}	
	}	
}






function Staking($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-17
	// Input : Array
	// Output : Need Complete data of a single Stake.	

	if($Q and is_array($Q)){
		if($Q['status']==1){
			$Staking=$Q['amount']*$Q['roi']/100;
			$Amount = $Staking*$Q['price'];

			$SQL="UPDATE `".prefix."pods_staking` SET `staking` = `staking` + ".$Amount.", `updated` = current_timestamp()  WHERE `Coinpods_staking`.`id` = '".$Q['id']."';";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
			return true;

		}	
	}
}




function StakesToStaking(){
	// Developer : Pawan Kumar
	// Date : 2024-04-17
	// Input : Array
	// Output : Staking ko Genarate

	$ab=0;
	$StakesToStaking=[];
	
	//$Stakes=Spot_Stakings(['status'=>1,'created'=>'2026-06-27', 'limit'=>111111112]);
	$Stakes=Spot_Stakings(['status'=>1,'limit'=>11111111]);
	//$Stakes=Spot_Stakings(['status'=>1,'created'=>'2026-08-04', 'limit'=>11111111]);
	if($Stakes){
		foreach($Stakes as $Stake){	
			if(Staking($Stake)){ $ab++; }		
		}	
	}
	return $ab;	
}






function Stakes($Q=null){

	if($Q){ $SQL="SELECT * FROM `".prefix."pods_staking` WHERE `user` = '".$Q."'"; }
	else{ $SQL="SELECT * FROM `".prefix."pods_staking` ORDER BY `".prefix."pods_staking`.`id` DESC"; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		

}










function Spot_StakingStatus($Uid=null, $Status=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/13
	// Input : uid and status enable and disable
	// Output : Change status.



	if($Uid and $Status){
		if($Status == 'enable'){$StatusValue = 1;}
		if($Status == 'disable'){$StatusValue = 0;} else{$Status= '';}

		$SQL="UPDATE `".prefix."pods_staking` SET `modified`=current_timestamp(),`status`='".$StatusValue."' WHERE `uid`='".$Uid."'";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL); 
		return $results;

	}
}


function StakingNew($Q=null){
	// Developer : Pawan kumar
	// Date : 2024-04-17
	// Input : Amount, CCC
	// Output : Array Data By New Staking Created.

	$echo = 'Staking New Start.';
	$Output=$AfterBalance=0;

	if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $PlanID=$Q['planid']; $UserID=i['id']; }
	else{ $echo = 'Q data not found.'; }


	//$Spot_wallets = Spot_wallets(array('user'=>i['id'], 'ccc'=>$CCC));
	//$Wallets = $Spot_wallets[0];

	$Wallets = Wallets(i['id']);
	$echo = 'Spot_wallets data found.';

	if($UserID and $Amount and $CCC and $PlanID){
		$echo = 'Userid and amount and ccc our planid found.';

		if($Wallets[$CCC]>=p2d($Amount)){
			$echo = 'The amount in the wallet is fine, go ahead.';

			$Plans=Staking_Plans(['id'=>$PlanID, 'minamount'=>$Amount, 'ccc'=>$CCC, 'maxamount'=>$Amount, 'status'=>1]);
			$Plan=$Plans[0];
			if($Plan){
				$echo = 'Staking_Plans data found.';
				$AfterBalance=$Wallets[strtolower($CCC)]-p2d($Amount);


				$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`) VALUES (NULL, 'Staking:".$UserID.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Staking:".$UserID.Clean(GMT())."', '".$UserID."', '', '', '1', 'Staking', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '".$AfterBalance."');";
				$echo = 'Coinpods_transaction SQL found.'; 
				global $DB;$aa = 0; $Staked = mysqli_query($DB, $SQL);

				$Wallets = Wallets(i['id']);
				$echo = 'Obtained by subtracting the amount in spot_wallet data.';

				$Walletss=$Wallets[strtolower($CCC)];
				$Walletss=$Walletss-p2d($Amount);
				$echo = 'Amount has been subtracted from Spot_wallet no problem.';

				if($Staked){ 
					$echo = 'The entry into the coinpods_transaction table has been successfully made.';

					$SQL1="UPDATE `Coinpods_wallet` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_wallet`.`user` = '".$UserID."';";
					unset($Walletss);
					$echo = 'Earn_Wallet SQL found.';
					global $DB;$aa = 0; $Walleted = mysqli_query($DB, $SQL1);

				}
				if($Walleted){
					$echo = 'Success SMS from Wallet has arrived, go ahead.';

					$Price=Price(); 
					$USDT=$Amount*$Price;

					$SQL2="INSERT INTO `Coinpods_staking`(`id`, `name`, `created`, `modified`, `amount`, `user`, `ccc`, `roi`, `period`, `ttype`, `status`, `ist`, `price`, `usd`, `plan`, `uid`, `privacy`, `app`, `apr`) VALUES (NULL, '".i['id']."', current_timestamp(), current_timestamp(), '".p2d($Amount)."', '".i['id']."', '".$CCC."', '".$Plan['roi']."', '".$Plan['period']."', '".$Plan['ttype']."', '1', '".IST()."', '".$Price."', '".p2d($USDT)."', '".$Plan['id']."', 'NULL', 'Public', '1', '".$Plan['apr']."')";
					$echo = 'Coinpods_staking SQL found.';
					global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL2);
					$SID=mysqli_insert_id($DB);

					if($SID){
						$echo = 'Insert Id Found of Coinpods_Staking.';

						//$Input = ['feature'=>'Staking','amount'=>p2d($USDT),'pair'=>'USDT_USDT','user'=>i['id']];
						//LiveData___Feature_Meta($Input);

						//$Input = ['feature'=>'Staking','amount'=>p2d($Amount),'pair'=>'CCC_CCC','user'=>i['id']];
						//LiveData___Feature_Meta($Input);				

						$SQL3="UPDATE `Coinpods_staking` SET `uid`='".$SID."' WHERE `id` = '".$SID."'";
						global $DB; $aa = 0; $Outputt = mysqli_query($DB, $SQL3);
						$echo = 'uid update success.';

					}
					else{ $echo = 'Insert ID of Coinpods_Staking not found.'; }
				}
				else{ $echo = 'No response received from Spot_wallet.'; }
			}
			else{ $echo = 'Stalking plan not found.'; }
		}
		else{ $echo = 'The amount in the wallet is not complete.'; }
	}
	else{ $echo = 'Not enough sources.'; }
	return $SID;

}


function Spot_StakingUpdate($Q=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/13
	// Input : Array 
	// Output : Update data.


	if(is_array($Q)){$Saking=$Q['staking'];$Updated=$Q['updated']; $Name=$Q['name']; $Amount=$Q['amount']; $User=$Q['user']; $Ccc=$Q['ccc']; $Roi=$Q['roi']; $Period=$Q['period']; $Ttype=$Q['ttype']; $Status=$Q['status']; $Totalstaking=$Q['totalstaking']; $Ist=$Q['ist']; $Price=$Q['price']; $Usd=$Q['usd']; $Unstaking=$Q['unstaking']; $Plan=$Q['plan']; $Offer=$Q['offer']; $Privacy=$Q['privacy']; $App=$Q['app']; $UID=$Q['uid']; $Level=$Q['level'];}

	$Modified=" SET `modified` = current_timestamp()";
	if($Saking){$Saking=", `saking` = '".$Saking."'";}
	if($Updated){$Updated=", `updated` = '".$Updated."'";}
	if($Name){$Name=", `name` = '".$Name."'";}
	if($Amount){$Amount=", `amount` = '".$Amount."'";}
	if($User){$User=", `user` = '".$User."'";}
	if($Ccc){$Ccc=", `ccc` = '".$Ccc."'";}
	if($Roi){$Roi=", `roi` = '".$Roi."'";}
	if($Period){$Period=", `period` = '".$Period."'";}
	if($Ttype){$Ttype=", `ttype` = '".$Ttype."'";}
	if($Totalstaking){$Totalstaking=", `totalstaking` = '".$Totalstaking."'";}
	if($Ist){$Ist=", `ist` = '".$Ist."'";}
	if($Price){$Price=", `price` = '".$Price."'";}
	if($Usd){$Usd=", `usd` = '".$Usd."'";}
	if($Unstaking){$Unstaking=", `unstaking` = '".$Unstaking."'";}
	if($Plan){$Plan=", `plan` = '".$Plan."'";}
	if($Offer){$Offer=", `offer` = '".$Offer."'";}
	if($Privacy){$Privacy=", `privacy` = '".$Privacy."'";}
	if($App){$App=", `app` = '".$App."'";}

	if($Status=='enable'){$StatusValue = ", `status`='1'";}
	elseif($Status=='disable'){$StatusValue = ", `status`='0'";}

	if(strtolower($Level)=='false'){ $LevelValue = ", `level`='0'"; }
	else{ $LevelValue = ", `level`='".$Level."'"; }

	$SET=$Modified.$Saking.$Updated.$Name.$Amount.$User.$Ccc.$Roi.$Period.$Ttype.$Totalstaking.$Ist.$Price.$Usd.$Unstaking.$Plan.$Offer.$Privacy.$App.$StatusValue.$LevelValue;

	$SQL ="UPDATE `".prefix."pods_staking` ".$SET." WHERE `".prefix."pods_staking`.`uid` = '".$UID."';"; 
	global $DB;$users = mysqli_query($DB, $SQL);   


	if($users){$s=1;$logs=$SQL;}else{$s=0;$logs=$SQL;}
	return array('s'=>$s,'logs'=>$logs);  
}








function Spot_Stakings($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-14
	// Input : Array
	// Output : Gives the details of the data from which the array comes.

	if(is_array($Q)){

		$ID=!empty($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Updated=!empty($Q['updated'])?" AND `updated` LIKE '%".$Q['updated']."%'" : '';
		$Name=!empty($Q['name'])?" AND `name` LIKE '%".strtolower($Q['name'])."%'" : '';
		$Created=!empty($Q['created'])?" AND `created` >= '".$Q['created']."'" : '';
		$Modified=!empty($Q['modified'])?" AND `modified` >= '".$Q['modified']."'" : '';
		$Amount=!empty($Q['amount'])?" AND `amount` >= '".p2d($Q['amount'])."'" : '';
		$User=!empty($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$CCC=!empty($Q['ccc'])?" AND `ccc` LIKE '".strtolower($Q['ccc'])."'" : '';
		$Roi=!empty($Q['roi'])?" AND `roi` = '".$Q['roi']."'" : '';
		$Period=!empty($Q['period'])?" AND `period` = '".$Q['period']."'" : '';
		$Ttype=!empty($Q['ttype'])?" AND `ttype` = '".$Q['ttype']."'" : '';
		$Staking=!empty($Q['staking'])?" AND `staking` >= '".$Q['staking']."'" : '';
		$TotalStaking=!empty($Q['totalstaking'])?" AND `totalstaking` >= '".p2d($Q['totalstaking'])."'" : '';
		$IST=!empty($Q['ist'])?" AND `ist` >= '".$Q['ist']."'" : '';
		$Price=!empty($Q['price'])?" AND `price` = '".$Q['price']."'" : '';
		$USD=!empty($Q['usd'])?" AND `usd` = '".p2d($Q['usd'])."'" : '';
		$UnStaking=!empty($Q['unstaking'])?" AND `unstaking` = '".$Q['unstaking']."'" : '';
		$Plan=!empty($Q['plan'])?" AND `plan` = '".$Q['plan']."'" : '';
		$Offer=!empty($Q['offer'])?" AND `offer` = '".$Q['offer']."'" : '';
		$Uid=!empty($Q['uid'])?" AND `uid` = '".$Q['uid']."'" : '';
		$Privacy=!empty($Q['privacy'])?" AND `privacy` = '".$Q['privacy']."'" : '';

		if(strtolower($Q['status'])=='false'){ $Status = " AND `status` = '0'"; }
		else{ if($Q['status']){ $Status = " AND `status` = '".$Q['status']."'"; } }

		if(!empty($Q['level'])){
			if(strtolower($Q['level']) == 'false'){ $Level = " AND `level` = '0'"; } 
			else{ $Level = " AND `level` = '" . $Q['level'] . "'"; }
		} 
		else{  $Level = ""; }	

		$Sort = $Q['sort']; if(!$Sort){ $Sort='id'; }
		$SortBy = strtoupper($Q['sortby']); if(!$SortBy){ $SortBy='DESC'; }

	}
	else{ $User = $Q; }

	$WhereClause=$ID.$Updated.$Name.$Created.$Modified.$Amount.$User.$CCC.$Roi.$Period.$Ttype.$Staking.$TotalStaking.$IST.$Price.$USD.$UnStaking.$Plan.$Offer.$Uid.$Privacy.$Status.$Level;

	$Limit=!empty($Q['limit'])? $Q['limit'] : '';
	if(!$Limit){ $Limit = 111; }
	$Offset=!empty($Q['offset'])? $Q['offset'] : 0;

	$MethodColumn=strtolower($Q['methodcolumn']);
	if($MethodColumn){ $MC='(`'.$MethodColumn.'`)'; } 
	else{ $MC=''; }

	$Method = strtoupper($Q['method']);
	if(!$Method){ $Method='*'; }
	$MM=$Method.$MC;

	$SQL = "SELECT ".$MM." FROM `".prefix."pods_staking` WHERE `id`!=0 ".$WhereClause." ORDER BY `".$Sort."` $SortBy LIMIT ".$Limit." OFFSET ".$Offset; 
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); //echo $SQL;
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}

	if($MC){ $return=$ts[0][$Method.''.$MC]; }else{ $return=$ts;}
	return $return;
}




function Spot_Staking($Q=null){ 
	// Developer : Pawan Kumar
	// Date : 2024-04-14
	// Input : UID
	// Output : Fatch User By UID

	if($Q){

		$SQL="SELECT * FROM `".prefix."pods_staking` WHERE `uid` = '".$Q."';"; //echo $SQL;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0];

	}
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Staking Plan Feature Start //


function Staking_PlanUpdate($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-14
	// Input : Array
	// Output : Updates the data that comes in the array.

	if(is_array($Q)){ $UID=$Q['uid']; $Name=$Q['name']; $Roi=$Q['roi']; $Ttype=$Q['ttype']; $CCC=$Q['ccc']; $Period=$Q['period']; $MinAmount=$Q['minamount']; $MaxAmount=$Q['maxamount']; $Description=$Q['description']; $Status=$Q['status']; }

	if($UID){

		$WHERE = " WHERE `uid` = '".$UID."'";
		$SET = "UPDATE `".prefix."pods_staking_plan` SET  `modified`= current_timestamp()";

		if($Name){ $Name = ", `name`='".$Name."'"; }
		if($Roi){ $Roi = ", `roi`='".$Roi."'"; }
		if($Ttype){ $Ttype = ", `ttype`='".$Ttype."'"; }
		if($CCC){ $CCC = ", `ccc`='".$CCC."'"; }
		if($Period){ $Period = ", `period`='".$Period."'"; }
		if($MinAmount){ $MinAmount = ", `minamount`='".p2d($MinAmount)."'"; }
		if($MaxAmount){ $MaxAmount = ", `maxamount`='".p2d($MaxAmount)."'"; }
		if($Description){ $Description = ", `description`='".$Description."'"; }
		if($Status=='enable'){ $StatusValue = ", `status`='1'"; }
		elseif($Status=='disable'){ $StatusValue = ", `status`='0'"; }

		$SQL=$SET.$Name.$Roi.$Ttype.$CCC.$Period.$MinAmount.$MaxAmount.$Description.$StatusValue.$WHERE;
		if($SQL){

			global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
			if($results){ return true; }else{ return false; }

		}
		else{ $echo ='SQL not found.'; }
	}
	else{ $echo = 'ID not found.'; }
}












function Staking_PlanStatus($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-13
	// Input : UID, Status( Enable, Disable )
	// Output : This function enables and disables the status of the transfer.

	if(is_array($Q)){ $Status=$Q['status']; $UID=$Q['uid']; }
	if($Status and $UID){

		if($Status == 'enable'){ $Statuss = 1; } 
		elseif($Status == 'disable'){ $Statuss = 0; }

		$SQL="UPDATE `".prefix."pods_staking_plan` SET `status` = '".$Statuss."', `modified` = current_timestamp() WHERE `uid` = '".$UID."'"; //echo $SQL;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);

	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}



function Staking_PlanNew($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-14
	// Input : Array
	// Output : Inserts the data in the array that comes in it.

	if(is_array($Q)){ $Roi=$Q['roi']; $Ttype=$Q['ttype']; $MinAmount=$Q['minamount']; $CCC=$Q['ccc']; $Period=$Q['period']; $Description=$Q['description']; $MaxAmount=$Q['maxamount']; }

	if($Roi and $Ttype and $MinAmount and $CCC and $Period and $MaxAmount){

		$SQL="INSERT INTO `".prefix."pods_staking_plan`(`id`, `name`, `created`, `modified`, `user`, `roi`, `ttype`, `minamount`, `ccc`, `status`, `uid`, `privacy`, `app`, `period`, `description`, `maxamount`) VALUES (NULL, 'Staking_Plan', current_timestamp(), current_timestamp(), '2', '".$Roi."', '".$Ttype."', '".p2d($MinAmount)."', '".$CCC."', '1', 'NULL', 'Public', '1', '".$Period."', '".$Description."', '".p2d($MaxAmount)."')";
		global $DB;$aa = 0; $StakingPlan = mysqli_query($DB, $SQL);

		if($StakingPlan){

			$SQL1="UPDATE `".prefix."pods_staking_plan` SET `uid` = `id`";
			global $DB;$aa = 0; $results = mysqli_query($DB, $SQL1);

		}
	}
	return $results;
}







function Staking_Plans($Q=null){
	// Developer : Pawan kumar
	// Date : 2024-04-14
	// Input : Array
	// Output : Gives the details of the data from which the array comes.

	if(is_array($Q)){

		$ID=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Name=isset($Q['name'])?" AND `name` LIKE '%".strtolower($Q['name'])."%'" : '';
		$Created=isset($Q['created'])?" AND `created` >= '".$Q['created']."'" : '';
		$Modified=isset($Q['modified'])?" AND `modified` >= '".$Q['modified']."'" : '';
		$User=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$Roi=isset($Q['roi'])?" AND `roi` = '".$Q['roi']."'" : '';
		$Ttype=isset($Q['ttype'])?" AND `ttype` = '".$Q['ttype']."'" : '';
		$MinAmount=isset($Q['minamount'])?" AND `minamount` <= '".$Q['minamount']."'" : '';
		$CCC=isset($Q['ccc'])?" AND `ccc` LIKE '".strtoupper($Q['ccc'])."'" : '';
		$Uid=isset($Q['uid'])?" AND `uid` LIKE '".strtoupper($Q['uid'])."'" : '';
		$Period=isset($Q['period'])?" AND `period` = '".$Q['period']."'" : '';
		//$Planid=isset($Q['planid'])?" AND `planid` = '".$Q['planid']."'" : '';
		$MaxAmount=isset($Q['maxamount'])?" AND `maxamount` >= '".$Q['maxamount']."'" : '';

		$Sort = $Q['sort']; if(!$Sort){ $Sort='id'; }
		$SortBy = strtoupper($Q['sortby']); if(!$SortBy){ $SortBy='ASC'; }

		if(strtolower($Q['status'])=='false'){ $Status = " AND `status` = '0'"; }
		else{ $Status = " AND `status` = '".$Q['status']."'"; }

	}
	else{ $User = $Q; }

	$WhereClause=$ID.$Name.$Created.$Modified.$User.$Roi.$Ttype.$MinAmount.$CCC.$Uid.$Period.$MaxAmount.$Status;

	$Limit=isset($Q['limit'])? $Q['limit'] : '';
	if(!$Limit){ $Limit = 111; }
	$Offset=isset($Q['offset'])? $Q['offset'] : 0;

	$SQL = "SELECT * FROM `".prefix."pods_staking_plan` WHERE 1 ".$WhereClause." ORDER BY `$Sort` $SortBy LIMIT ".$Limit." OFFSET ".$Offset;  
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); //echo $SQL;
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}

	return $ts;

}




function Staking_Plan($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-13
	// Input : UID
	// Output : Fatch User By UID

	if($Q){

		$SQL="SELECT * FROM `".prefix."pods_staking_plan` WHERE `uid` = '".$Q."';"; //echo $SQL;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0];

	}
}



function Staking_Currencies($Q=null){ //Currencies
	//Developer : Himanshu Nayak
	//Date : 2024/10/28
	//Input : Array
	//Output : Joo array me data aata hai uss data ke hisab se data ko select krta hai.

	if(is_array($Q)){

		$ID=!empty($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Name=!empty($Q['name'])?" AND `name` = '".$Q['name']."'" : '';
		$Created=!empty($Q['created'])?" AND `created` >= '".$Q['created']."'" : '';
		$Modified=!empty($Q['modified'])?" AND `modified` >= '".$Q['modified']."'" : '';
		$User=!empty($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$CCC=!empty($Q['ccc'])?" AND `ccc` = '".$Q['ccc']."'" : '';
		$Address=!empty($Q['address'])?" AND `address` = '".$Q['address']."'" : '';
		$Logo=!empty($Q['logo'])?" AND `logo` = '".$Q['logo']."'" : '';
		$Network=!empty($Q['network'])?" AND `network` = '".$Q['network']."'" : '';
		$Price=!empty($Q['price'])?" AND `price` = '".$Q['price']."'" : '';
		$Enable=!empty($Q['enable'])?" AND `enable` >= '".$Q['enable']."'" : '';
		$Supply=!empty($Q['supply'])?" AND `supply` = '".$Q['supply']."'" : '';
		$Priority=!empty($Q['priority'])?" AND `priority` = '".$Q['priority']."'" : '';
		$Uid=!empty($Q['uid'])?" AND `uid` = '".$Q['uid']."'" : '';
		$Status=!empty($Q['status'])?" AND `status` = '".$Q['status']."'" : '';
		$Privacy=!empty($Q['privacy'])?" AND `privacy` = '".$Q['privacy']."'" : '';
		$App=!empty($Q['app'])?" AND `app` = '".$Q['app']."'" : '';
		$Deposit=!empty($Q['deposit'])?" AND `deposit` = '".$Q['deposit']."'" : '';
		$Withdraw=!empty($Q['withdraw'])?" AND `withdraw` = '".$Q['withdraw']."'" : '';
		$Symbol=!empty($Q['symbol'])?" AND `symbol` = '".$Q['symbol']."'" : '';
		$Ttype=!empty($Q['ttype'])?" AND `ttype` = '".$Q['ttype']."'" : '';
		$Change=!empty($Q['change'])?" AND `change` = '".$Q['change']."'" : '';
		$Decimal=!empty($Q['decimal'])?" AND `decimal` = '".$Q['decimal']."'" : '';
		$Send=!empty($Q['send'])?" AND `send` = '".$Q['send']."'" : '';
		$buy=!empty($Q['buy'])?" AND `buy` = '".$Q['buy']."'" : '';
		$Sell=!empty($Q['sell'])?" AND `sell` = '".$Q['sell']."'" : '';
		$Stake=!empty($Q['stake'])?" AND `stake` = '".$Q['stake']."'" : '';
		$Level=!empty($Q['level'])?" AND `level` = '".$Q['level']."'" : '';
		$Airdrop=!empty($Q['airdrop'])?" AND `airdrop` = '".$Q['airdrop']."'" : '';
		$Mindeposit	=!empty($Q['mindeposit'])?" AND `mindeposit` = '".$Q['mindeposit']."'" : '';
		$Maxdeposit=!empty($Q['maxdeposit'])?" AND `maxdeposit` = '".$Q['maxdeposit']."'" : '';
		$Minbuy=!empty($Q['minbuy'])?" AND `minbuy` = '".$Q['minbuy']."'" : '';
		$Maxbuy=!empty($Q['maxbuy'])?" AND `maxbuy` = '".$Q['maxbuy']."'" : '';
		$Minsell=!empty($Q['minsell'])?" AND `minsell` = '".$Q['minsell']."'" : '';
		$Maxsell=!empty($Q['maxsell'])?" AND `maxsell` = '".$Q['maxsell']."'" : '';
		$Minstake=!empty($Q['minstake'])?" AND `minstake` = '".$Q['minstake']."'" : '';
		$Maxstake=!empty($Q['maxstake'])?" AND `maxstake` = '".$Q['maxstake']."'" : '';
		$Minsend=!empty($Q['minsend'])?" AND `minsend` = '".$Q['minsend']."'" : '';
		$Maxsend=!empty($Q['maxsend'])?" AND `maxsend` = '".$Q['maxsend']."'" : '';
		$Minwithdraw=!empty($Q['minwithdraw'])?" AND `minwithdraw` = '".$Q['minwithdraw']."'" : '';
		$Maxwithdraw=!empty($Q['maxwithdraw'])?" AND `maxwithdraw` = '".$Q['maxwithdraw']."'" : '';
		$Erc20=!empty($Q['erc20'])?" AND `erc20` = '".$Q['erc20']."'" : '';
		$Bep20=!empty($Q['bep20'])?" AND `bep20` = '".$Q['bep20']."'" : '';
		$Trc20=!empty($Q['trc20'])?" AND `trc20` = '".$Q['trc20']."'" : '';
		$Audited=!empty($Q['audited'])?" AND `audited` = '".$Q['audited']."'" : '';
		$Volume=!empty($Q['volume'])?" AND `volume` = '".$Q['volume']."'" : '';
		$Marketcap=!empty($Q['marketcap'])?" AND `marketcap` = '".$Q['marketcap']."'" : '';
		$Circulatingsupply=!empty($Q['circulatingsupply'])?" AND `circulatingsupply` = '".$Q['circulatingsupply']."'" : '';
		$categoryy=!empty($Q['categoryy'])?" AND `categoryy` = '".$Q['categoryy']."'" : '';
		$mineable=!empty($Q['mineable'])?" AND `mineable` = '".$Q['mineable']."'" : '';
		$Transfer=!empty($Q['transfer'])?" AND `transfer` = '".$Q['transfer']."'" : '';
		$p2p=!empty($Q['p2p'])?" AND `p2p` = '".$Q['p2p']."'" : '';


		if($Q['enable']=='enable'){ $Enable = " AND `enable` = '1'"; }
		elseif($Q['enable']=='disable'){ $Enable = " AND `enable` = '0'"; }

		$Sort = $Q['sort'];
		$SortBy = strtoupper($Q['sortby']);

	}
	else{ $User = $Q; }

	$WhereClause=$ID.$Name.$Created.$Modified.$User.$CCC.$Address.$Logo.$Network.$Price.$Enable.$Supply.$Priority.$Uid.$Status.$Privacy.$App.$Deposit.$Withdraw.$Symbol.$Ttype.$Change.$Decimal.$Send.$buy.$Sell.$Stake.$Level.$Airdrop.$Mindeposit.$Maxdeposit.$Minbuy.$Maxbuy.$Minsell.$Maxsell.$Minstake.
		$Maxstake.$Minsend.$Maxsend.$Minwithdraw.$Maxwithdraw.$Erc20.$Bep20.$Trc20.$Audited.$Volume.$Marketcap.$Circulatingsupply.$categoryy.$mineable.$Transfer.$p2p;

	$Limit=!empty($Q['LIMIT'])? $Q['LIMIT'] : '';
	if(!$Limit){ $Limit = 111; }
	$Offset=!empty($Q['OFFSET'])? $Q['OFFSET'] : 0;


	if(!$Sort){ $Sort = 'id'; }
	if(!$SortBy){ $SortBy = 'ASC'; }
	$SQL = "SELECT * FROM `".prefix."pods_staking_currency` WHERE 1 ".$WhereClause." ORDER BY `$Sort` $SortBy LIMIT ".$Limit." OFFSET ".$Offset;
	//echo   $SQL;
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}

	if($ts){ return $ts; }

}







?>