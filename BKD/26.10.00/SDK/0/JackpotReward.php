<?php


function JackpotDirectRewardByUser($Q=null){
// Developer : Pawan Kumar
// Date : 2024-06-01
// Input : UserID
// Output : UserID by jackpot reward data.
	
	if($Q){
		
		$SQL="SELECT * FROM `Coinpods_jackpotreward` WHERE `user` = '".$Q."' AND `created` LIKE '".date('Y-m')."%'";
		//$SQL = "SELECT * FROM `Coinpods_jackpotreward` WHERE `user` = '".$Q."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		return $ts;
	
	}
}




function RankByUsersCountDirectreward($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-17
// Input : Rank
// Output : Rank By Total User
	
	if($Q){
		
		$SQL="SELECT COUNT(`ID`) as 'Total' FROM `Coinusers` WHERE `JackpotDirectRewardRank` = '".$Q."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		return $ts[0]['Total'];
	
	}
	else{ $echo='Q Data Empty.'; }
}





function RankByUsersDirectreward($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-17
// Input : Rank
// Output : Rank By Users List
	
	if($Q){
		
		$SQL="SELECT * FROM `Coinusers` WHERE `JackpotDirectRewardRank` = '".$Q."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
	
	}
	else{ $echo='Q Data Empty.'; }
	return $ts;	
}






///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function JackpotRewardByUser($Q=null){
// Developer : Pawan Kumar
// Date : 2024-06-01
// Input : UserID
// Output : UserID by jackpot reward data.
	
	if($Q){ 
		
		//$SQL = "SELECT * FROM `Coinpods_jackpotreward` WHERE `user` = '".$Q."';";
		$SQL="SELECT * FROM `Coinpods_jackpotreward` WHERE `user` = '".$Q."' AND `created` LIKE '".date('Y-m')."%'";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		return $ts;
	
	}
}




function RankByUsersCount($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-17
// Input : Rank
// Output : Rank By Total User
	
	if($Q){
		
		$SQL="SELECT COUNT(`ID`) as 'Total' FROM `Coinusers` WHERE `JackpotTeamRewardRank` = '".$Q."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		return $ts[0]['Total'];
	
	}
	else{ $echo='Q Data Empty.'; }
}





function RankByUsers($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-17
// Input : Rank
// Output : Rank By Users List
	
	if($Q){
		
		$SQL="SELECT * FROM `Coinusers` WHERE `JackpotTeamRewardRank` = '".$Q."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
	
	}
	else{ $echo='Q Data Empty.'; }
	return $ts;	
}




function UpdateLegUsers($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-14
// Input : UserID, JackpotActiveDirect, MasterLegJackpotUser And AnotherLegJackpotUser 
// Output : UPDATE
	
	if(is_array($Q)){ $UserID=$Q['userid']; $Direct=$Q['Direct']; $MasterLeg=$Q['MasterLeg']; $AnotherLeg=$Q['AnotherLeg']; }
	if($UserID or $Direct or $MasterLeg or $AnotherLeg){
		
		$SQL="UPDATE `Coinusers` SET `JackpotActiveDirect`='".$Direct."', `MasterLegJackpotUser`='".$MasterLeg."', `AnotherLegJackpotUser`='".$AnotherLeg."' WHERE `userid` = '".$UserID."';";
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
	
	}
	return $results;
}





function JackpotRewardToWallet($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-10
// Input : 
// Output : Jackpot Reward Transaction Add To Wallet
	
$Output=0;
	$PendingJackpotRewardTransaction=PendingJackpotRewardTransaction($Q);
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



function PendingJackpotRewardTransaction($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-10
// Input : 
// Output : Jackpot Reward Pending Transaction 
	
	$SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` LIKE 'JackpotReward'";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;	

}






//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Jackpot Team Monthly Reward Start //



function JackpotTeamMonthlyRewards($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-15
// Input :
// Output : Jackpot Team Monthly Rewards Provide.
	
	$Output=0;
	$echo="Jackpot Team Monthly Rewards Start.";
	$PendingJackpotTeamMonthlyReward=PendingJackpotTeamMonthlyReward();
	if($PendingJackpotTeamMonthlyReward){
	$echo="Pending Jackpot Team Monthly Reward Users Found.";
		
		foreach($PendingJackpotTeamMonthlyReward as $Ps){
		if($Ps){
		$echo="Foreach Data Found.";
			
			$Array = array('userid'=>$Ps['ID'], 'rank'=>$Ps['JackpotTeamRewardRank']);
			$echo="Array Found.";
			$JackpotTeamMonthlyReward=JackpotTeamMonthlyReward($Array);
			if($JackpotTeamMonthlyReward){
				
				$Output=1; $echo="Success";
			}
			else{ $echo="Jackpot Team Monthly Reward Function Not Working."; }
		   }
		   else{ $echo="Foreach Data Not Found."; }
		 }
	 }
	else{ $echo="Pending Jackpot Team Monthly Reward Users Not Found."; }
return $Output;
}






function JackpotTeamMonthlyReward($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-15
// Input : UserID, Rank
// Output : Rank By Reward Transaction Insert.
	$BeforeBalance=$AfterBalance=0;
	$echo="Jackpot Team Monthly Reward.";
	if(is_array($Q)){ $UserID=$Q['userid']; $Rank=$Q['rank']; }
	$echo="Is Array Good Working.";
	if($UserID and $Rank){
	$echo="UserID And Rank Found.";
		
		if($Rank == 1){ $Reward = 20; }
		elseif($Rank == 2){ $Reward = 40; }
		elseif($Rank == 3){ $Reward = 80; }
		elseif($Rank == 4){ $Reward = 100; }
		elseif($Rank == 5){ $Reward = 200; }
		elseif($Rank == 6){ $Reward = 400; }
		elseif($Rank == 7){ $Reward = 800; }
		elseif($Rank == 8){ $Reward = 1600; }
		elseif($Rank == 9){ $Reward = 3200; }
		elseif($Rank == 10){ $Reward = 6400; }
		$echo="All Condition Good Working.";
		
		if($Reward){
		$echo="Reward Found.";
			
			$Y = date("Y"); $M = (new DateTime())->modify('-1 month')->format('m'); //$M = date("m");
			$UID = $UserID.':'.$Y.':'.$M;
			$Fundings=Fundings($UserID);
			$BeforeBalance=$Fundings['usdt'];
			$AfterBalance=$BeforeBalance+p2d($Reward);
			

			$SQL="INSERT INTO `Coinpods_transaction`(`id`, `created`, `name`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `filled`, `status`, `beforebalance`, `afterbalance`, `price`, `orderid`, `modified`, `buyuser`, `selluser`, `processing`, `walletname`, `buytid`, `selltid`, `buywalletname`, `sellwalletname`, `level`, `total`, `partition`, `jackpot`) VALUES (NULL, current_timestamp(), 'Jackpot Monthly Reward', '".$UserID."', '', '', '0', 'JackpotReward', '".p2d($Reward)."', 'USDT', '', '1', '".$BeforeBalance."', '".$AfterBalance."', '".Price()."', '".$UID."', current_timestamp(), '', '', '', '', '', '', '', '', '', '', '', '')"; //echo $SQL.'<br><br>';
			$echo="SQL Query Found.";
			global $DB; $aa=0; $results = mysqli_query($DB, $SQL);
			$IID = mysqli_insert_id($DB);
			if($results){
				
				$User = user($UserID);
				
				$SQL1="INSERT INTO `Coinpods_jackpotreward`(`id`, `name`, `created`, `modified`, `user`, `uid`, `status`, `privacy`, `app`, `mlu`, `alu`, `du`, `rank`, `amount`, `ccc`, `balance`) VALUES ('".$IID."', 'Jackpot Monthly Reward', current_timestamp(), current_timestamp(), '".$UserID."', '".$UID."', '1', '', '1', '".$User['MasterLegJackpotUser']."', '".$User['AnotherLegJackpotUser']."', '".$User['JackpotActiveDirect']."', '".$Rank."', '".p2d($Reward)."', 'USDT', '0')";
				global $DB; $aa=0; $results = mysqli_query($DB, $SQL1);
			
			}
			else{ $echo = 'Results Data Not Found.'; }
		}
		else{ $echo="Reward Not Found."; }
	}
	else{ $echo="Data Empty."; }
	return $results;
}



function PendingJackpotTeamMonthlyReward($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-15
// Input :
// Output : Pending Users JackpotTeamRewardRank != 0
	
	$SQL="SELECT * FROM `Coinusers` WHERE `JackpotTeamRewardRank` != 0;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;	
	
}







function JackpotMonthlyRewards($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-14
// Input :
// Output : Jackpot Monthly Reward Main Function
	
	$Output=0;
	$echo="Jackpot Monthly Rewards Start.";
	$PendingMonthlyJackpotReward=PendingMonthlyJackpotReward();
	$echo="Pending Monthly Jackpot Reward Users.";
	
	if($PendingMonthlyJackpotReward){
	$echo="Pending Monthly Jackpot Reward Users Found.";
		
		foreach($PendingMonthlyJackpotReward as $Ps){
		$echo="Foreach Good Working.";	
			
			$Direct = $Ps['JackpotActiveDirect'];
			$MasterLeg = $Ps['MasterLegJackpotUser'];
			$AnotherLeg = $Ps['AnotherLegJackpotUser'];
			$echo="Jackpot Active Direct And MasterLeg Users And AnotherLeg Users Found.";
			
			$Array = array('userid'=>$Ps['ID'], 'Direct'=>$Direct, 'MasterLeg'=>$MasterLeg, 'AnotherLeg'=>$AnotherLeg);
			$echo="Array Data Found.";
			//print_r($Array).'<br>';
			$JackpotMonthlyReward=JackpotMonthlyReward($Array);
			if($JackpotMonthlyReward){ $Output=1; $echo="Success."; }
			else{ $echo="Jackpot Monthly Reward Function Not Working."; }
		
		}
	}
	else{ $echo="Pending Monthly Jackpot Reward Users Not Found."; }
	return $Output;
}






function JackpotMonthlyReward($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-14
// Input : UserID, Jackpot Active Direct, MasterLeg Jackpot Active User And AnotherLeg Jacpot Active User
// Output : Jackpot Monthly Reward calculation And Insert Transaction
	
	$echo="Jackpot Monthly Reward Start.";
	if(is_array($Q)){ $UserID=$Q['userid']; $Direct=$Q['Direct']; $MasterLeg=$Q['MasterLeg']; $AnotherLeg=$Q['AnotherLeg']; }
	$echo="Is array good working.";
	if($UserID and $Direct and $MasterLeg and $AnotherLeg){
	$echo="UserID, Direct And Masterleg Users And AnotherLeg Users Found.";
		
		if($Direct >= 20 and $MasterLeg >= 6400 and $AnotherLeg >= 6400){ $Rank = 10; }
		elseif($Direct >= 18 and $MasterLeg >= 3200 and $AnotherLeg >= 3200){ $Rank = 9; }
		elseif($Direct >= 16 and $MasterLeg >= 1600 and $AnotherLeg >= 1600){ $Rank = 8; }
		elseif($Direct >= 14 and $MasterLeg >= 800 and $AnotherLeg >= 800){ $Rank = 7; }
		elseif($Direct >= 12 and $MasterLeg >= 400 and $AnotherLeg >= 400){ $Rank = 6; }
		elseif($Direct >= 10 and $MasterLeg >= 200 and $AnotherLeg >= 200){ $Rank = 5; }
		elseif($Direct >= 8 and $MasterLeg >= 100 and $AnotherLeg >= 100){ $Rank = 4; }
		elseif($Direct >= 6 and $MasterLeg >= 80 and $AnotherLeg >= 80){ $Rank = 3; }
		elseif($Direct >= 4 and $MasterLeg >= 40 and $AnotherLeg >= 40){ $Rank = 2; }
		elseif($Direct >= 2 and $MasterLeg >= 20 and $AnotherLeg >= 20){ $Rank = 1; }
		//print_r($UserID.' '.$Reward); echo '<br><br>';
		$echo="All Conditions Good Working.";
		
		if($Rank){
		$echo="Rank Found.";	
			
			$SQL="UPDATE `Coinusers` SET `JackpotTeamRewardRank`='".$Rank."' WHERE `ID` = '".$UserID."';";
			$echo="SQL Query Found.";
			global $DB; $aa=0; $results = mysqli_query($DB, $SQL);
		
		}
	}
	else{ $echo="Data Not Found."; }
	return $results;
}





function PendingMonthlyJackpotReward($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-14
// Input :
// Output : Pending Users 
	
	$SQL="SELECT * FROM `Coinusers` WHERE `JackpotActiveDirect` != 0 AND `MasterLegJackpotUser` != 0 AND `AnotherLegJackpotUser` != 0";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;	

}





//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Jackpot Direct Monthly Rewards Start //


function JackpotDirectMonthlyRewards($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-15
// Input :
// Output : Rank By Reward Provide.
	
	$Output=0;
	$echo="Jackpot Direct Monthly Rewards Start.";
	$PendingJackpotDirectMonthlyReward=PendingJackpotDirectMonthlyReward();
	if($PendingJackpotDirectMonthlyReward){
	$echo="Pending Jackpot Direct Monthly Reward Users Found.";
		
		foreach($PendingJackpotDirectMonthlyReward as $Ps){
		if($Ps){
		$echo="Foreach Data Found.";
			
			$JackpotMonthlyReward=JackpotDirectMonthlyReward(array('userid'=>$Ps['ID'], 'rank'=>$Ps['JackpotDirectRewardRank']));
			if($JackpotMonthlyReaward){
			$Output=1; $echo="Success";
					
				}
			else{ $echo="Jackpot Monthly Reaward Function Not Working."; }
			}
			else{ $echo="Foreach Data Not Found."; }
		}
	}
	else{ $echo="Data Empty."; }
	return $Output;
}



function JackpotDirectMonthlyReward($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-15
// Input : UserID, Rank
// Output : INSERT
	
	if(is_array($Q)){ $UserID=$Q['userid']; $Rank=$Q['rank']; }
	if($UserID and $Rank){
		
		if($Rank == 1){ $Reward = 20; }
		elseif($Rank == 2){ $Reward = 50; }
		elseif($Rank == 3){ $Reward = 100; }
		
		if($Reward){
			
			$Y = date("Y"); $M = (new DateTime())->modify('-1 month')->format('m'); //$M = date("m");
			$UID = $UserID.':'.$Y.':'.$M;
			
			$SQL="INSERT INTO `Coinpods_transaction`(`id`, `created`, `name`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `filled`, `status`, `beforebalance`, `afterbalance`, `price`, `orderid`, `modified`, `buyuser`, `selluser`, `processing`, `walletname`, `buytid`, `selltid`, `buywalletname`, `sellwalletname`, `level`, `total`, `partition`, `jackpot`) VALUES (NULL, current_timestamp(), 'Jackpot Direct Reward', '".$UserID."', '', '', '0', 'JackpotReward', '".p2d($Reward)."', 'USDT', '', '1', '', '', '".Price()."', '".$UID."', current_timestamp(), '', '', '', '', '', '', '', '', '', '', '', '')"; //echo $SQL.'<br><br>';
			global $DB; $aa=0; $results = mysqli_query($DB, $SQL);
			$IID = mysqli_insert_id($DB);
			if($results){
				
				$User = user($UserID);
				
				$SQL1="INSERT INTO `Coinpods_jackpotreward`(`id`, `name`, `created`, `modified`, `user`, `uid`, `status`, `privacy`, `app`, `mlu`, `alu`, `du`, `rank`, `amount`, `ccc`, `balance`) VALUES ('".$IID."', 'Jackpot Monthly Reward', current_timestamp(), current_timestamp(), '".$UserID."', '".$UID."', '1', '', '1', '".$User['MasterLegJackpotUser']."', '".$User['AnotherLegJackpotUser']."', '".$User['JackpotActiveDirect']."', '".$Rank."', '".p2d($Reward)."', 'USDT', '0')";
				global $DB; $aa=0; $results = mysqli_query($DB, $SQL1);
			
			}
			else{ $echo = 'Results Data Not Found.'; }
		}
		else{ $echo = "Reward Not Found."; }
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}






function PendingJackpotDirectMonthlyReward($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-15
// Input :
// Output : Pending Users JackpotDirectRewardRank != 0
	
	$SQL="SELECT * FROM `Coinusers` WHERE `JackpotDirectRewardRank` != 0;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;	
	
}








function JackpotDirectRewards($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-10
// Input : 
// Output : Jackpot calculates the reward and provides the reward.
	
	$Output=0;
	$echo="Jackpot Direct Rewards Start.";
	$PendingJackpotReward=PendingJackpotReward();
	if($PendingJackpotReward){
	$echo="Pending Jackpot Reward Found.";
		
		foreach($PendingJackpotReward as $Ps){
			if($Ps){
			$echo="Pending Jackpot Reward Found.";
				
			$JackpotReward=JackpotDirectReward(array('userid'=>$Ps['ID'], 'JackpotActiveDirect'=>$Ps['JackpotActiveDirect']));
			if($JackpotReward){ $Output=1; }
			else{$Output=0; }
				
			}
			else{ $echo="Pending Jackpot Reward Not Found.";}
		}
	}
	else{ $echo="Data Empty."; }
	return $Output;
}



function JackpotDirectReward($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-10
// Input : UserID, Amount
// Output : UPDATE Rank
	
	$echo="Jackpot Direct Reward Start.";
	if(is_array($Q)){ $UserID=$Q['userid']; $Direct=$Q['JackpotActiveDirect']; }
	$echo="Is array good working.";
	if($UserID and $Direct){
	$echo="UserID And Direct Found.";
		
		if($Direct >= 100){ $Rank = 3; }
		elseif($Direct >= 50){ $Rank = 2; }
		elseif($Direct >= 20){ $Rank = 1; }
		$echo="All Conditions Good Working.";
		
		if($Rank){
		$echo="Rank Found.";
			
			$SQL="UPDATE `Coinusers` SET `JackpotDirectRewardRank`='".$Rank."' WHERE `ID` = '".$UserID."';";
			global $DB; $aa=0; $results = mysqli_query($DB, $SQL);
		
		}
		else{ $echo = "Rank Not Found."; }
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}






function PendingJackpotReward($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-10
// Input :
// Output : Retrieves a list of users whose property is JackpotActiveDirect != 0.
	
	$SQL="SELECT * FROM `Coinusers` WHERE `JackpotActiveDirect` != 0";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}	
	return $ps;

}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function TotalJackpotActiveDirectUpdate($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-10
// Input : UserID
// Output : Jackpot active direct ko count kar ke update krta hai.
	
	if($Q){
	$Total=TotalJackpotActiveDirect($Q);
	if($Total){
		
    $SQL="UPDATE `Coinusers` SET `JackpotActiveDirect`='".$Total['Total_Direct']."' WHERE `userid` = '".$Total['referby']."';";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);
		
	}
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}






function TotalJackpotActiveDirect($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-10
// Input : UserID
// Output : Counts those whose jackpot is active in the last 30 days.
	
	if($Q){
		
		$Last_30_Days = date('Y-m-d', strtotime('-30 days'));
		
		$SQL="SELECT COUNT(`ID`) as 'Total_Direct', `referby` FROM `Coinusers` WHERE `jackpotactive` != 0 AND `jackpotactive` >= '".$Last_30_Days."%' AND `referby`='".$Q."'"; 
		global $DB; $aa=0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
		else{$ps=null;}	
		return $ps[0];
	
	}
	else{ $echo = 'Data Empty.'; }
}


?>