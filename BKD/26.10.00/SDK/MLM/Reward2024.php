<?php
import("MLM");


function CompanyMonthlyWithdraw($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : Empty
    // Output : Currant Month Total Company Withdraw
    
    $Start = date("Y-m").'-01 00:00:01'; $End = date("Y-m").'-31 23:59:59';

    $SQL="SELECT  SUM(`amount`)/1000000000 as 'amount' FROM `Coinpods_transaction` WHERE `created` BETWEEN '".$Start."' AND '".$End."' AND `ttype` = 'Withdraw' AND `status` = 1 AND `balance` = 1";
    global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
    if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
    else{$ts = null;}
    return $ts;	

}



function CompanyMonthlyDeposit($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : Empty
    // Output : Currant Month Total Company Deposit
    
    $Start = date("Y-m").'-01 00:00:01'; $End = date("Y-m").'-31 23:59:59';

    $SQL="SELECT  SUM(`amount`)/1000000000 as 'amount' FROM `Coinpods_transaction` WHERE `created` BETWEEN '".$Start."' AND '".$End."' AND `ttype` = 'Deposit' AND `status` = 1";
    global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
    if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
    else{$ts = null;}
    return $ts;	

}






function Reward2024DataZero($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : Empty
    // Output : DirectTotalDeposit, MasterLegDeposit, AnotherLegDeposit, TotalDeposit2024 Data Zero After Reward Closing
	
	$SQL="UPDATE `Coinusers` SET `DirectTotalDeposit`='0', `MasterLegDeposit`='0', `AnotherLegDeposit`='0', `DRewardRank`='0', `TotalDeposit2024`='0', `StakingTeamLevel`='0', `Level3StakeTotal`='0', `Level1StakeTotal`='0', `StakingTeamLevel1`='0', `today_capping`='0', `today_total_teamstaking_sum`='0';";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	return $results;

}




function Reward2024ByRank($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : Rank
    // Output : By Rank User Select
 
	if($Q){
		
		$SQL="SELECT * FROM `Coinusers` WHERE `DRewardRank` = '".$Q."'";
		$echo = 'SQL Found.'; 
		
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		$return = $ts;
		$echo = 'return found.'; 
		
		return $return;
		$echo = 'return good working.';
	
	}
}




function TeamDeposit2024($Q=null){ 
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : UserID
    // Output : 
    
    if(!$Q){ $Q=i['userid']; }
    $B=0;  
    if($Q){	
        $Team = CreateTeam($Q);

        $Downlines = $Team;
        $Users=$Downlines['users'];	
        if($Users){
            $aa=0;
    
            foreach($Users as $Level){
                $aa++;
                if($aa<31){
                    
                    if($Level){
                        foreach($Level as $UserID){	
                            
                            $User=UserByUserID($UserID);
                            $User=$User['TotalDeposit2024'];   	
                            $B=$B+$User;	
            
                        }	
                    }
                }
            }
        }
    }
    if($B){ /*UpdateTeamStake($B);*/ return $B; }
}




function UpdateTotalDeposit2024($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : UserID
    // Output : Single User Self Deposit Update
	
	if(!$Q){ $Q=i['id']; }	
	if($Q){
		
		$Total=TotalStakeDeposit2024($Q);
		$SQL="UPDATE `Coinusers` SET `TotalDeposit2024` = '".$Total."' WHERE `Coinusers`.`ID` = '".$Q."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		return $Total;
	
	}
}



function TotalStakeDeposit2024($Q=null){	
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : UserID
    // Output : Total Deposit

$Start = date("Y-m").'-01 00:00:01';

if($Q){ $SQL = "SELECT SUM(`amount`) FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `ttype` LIKE 'Deposit' AND `ccc` LIKE 'USDT' AND `created` >= '".$Start."';"; }
else{
	if(i['Role']=='Manager'){ $SQL = "SELECT SUM(`amount`) FROM `Coinpods_transaction` WHERE `ttype` LIKE 'Deposit' AND `ccc` LIKE 'USDT' AND `created` >= '".$Start."';"; }
	else{ $Q=i['id']; $SQL = "SELECT SUM(`amount`) FROM `Coinpods_transaction` WHERE `user` = ".$Q." AND `ttype` LIKE 'Deposit' AND `ccc` LIKE 'USDT' AND `created` >= '".$Start."';";  }
} 
	
	if($SQL){		
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){ return $ts[0]['SUM(`amount`)']; }
	
	}
	else{ $echo='Not enough sources.'; }
}

if(i['id']){ TotalStakeDeposit2024(i['id']); }




function Reward2024ToWallet($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : Empty
    // Output : Reward New Transaction Add To Wallet [ Funding Wallet Add ]
	
	$echo = 'Reward2024 To Wallet Start.';
	$Output=0;
	$PendingReward2024=PendingReward2024($Q);
	if($PendingReward2024){
	$echo = 'Pending Users Found.';
		foreach($PendingReward2024 as $Ps){
		$echo = 'Foreach Good Working.';
						
			if(AddToFunding(array( 'user'=>$Ps['user'], 'ccc'=>strtolower($Ps['ccc']), 'amount'=>$Ps['amount'] ))){
				Balance1Transaction($Ps['id']);
				$echo = 'Add To Funding Wallet Success.';
			}
			else{ 
				Balance2Transaction($Ps['id']);
				$echo = 'Add To Funding Wallet Failed.';
			}
		}
	}	
	else{ $echo = 'Pending Users Not Found.'; }
	return $Output;
}





function PendingReward2024($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : Empty
    // Output : Reward New Transaction Pending List
	
	$echo = 'Pending Reward2024 Function Start.';
	$SQL="SELECT * FROM `".prefix."pods_transaction` WHERE `created` >= '2024-09-11' AND `balance` = 0 AND `ttype` LIKE 'RewardNew' LIMIT 1111";
	$echo = 'SQL Found.';
	
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	$return = $ts;
	$echo = 'return found.'; 
	
	return $return;
	$echo = 'return good working.';
}




function GanrateRewards2024($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : Empty
    // Output : By Rank Reward Provide

	$echo = 'Ganrate Rewards 2024 Start.';
	$PendingRankReward2024=PendingRankReward2024();
	if($PendingRankReward2024){
	$echo = 'Pending Rank Reward Users Found.';
		
		foreach($PendingRankReward2024 as $PR){
		$echo = 'Foreach Good Working.';
			
			$GPR=GanratePendingReward2024($PR['ID']);
			$echo = 'Genrate Pending Reward Success.';
		}
	}
	else{ $echo = 'Pending Rank Reward Users Not Found.'; }
	return $GPR;
}



function GanratePendingReward2024($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : UserID
    // Output : By Rank RewardNew Transaction Create

	$BeforeBalance=$AfterBalance=0;
	$Dispatche=1;
	if($Q){
		
		$User = user($Q);
		
		if($User['DRewardRank']==1){ $Amount=100; }
		elseif($User['DRewardRank']==2){ $Amount=200; }
		elseif($User['DRewardRank']==3){ $Amount=400; }
		elseif($User['DRewardRank']==4){ $Amount=800; }
		elseif($User['DRewardRank']==5){ $Amount=1600; }
		elseif($User['DRewardRank']==6){ $Amount=3200; }
		elseif($User['DRewardRank']==7){ $Amount=6400; }
		elseif($User['DRewardRank']==8){ $Amount=12800; }
		elseif($User['DRewardRank']==9){ $Amount=25600; }
		elseif($User['DRewardRank']==10){ $Amount=51200; }
		
		if($Amount){
			$Fundings=Fundings($Q);
			$BeforeBalance=$Fundings['usdt'];
			$AfterBalance=$BeforeBalance+p2d($Amount);
			
			
			$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`) VALUES (NULL, 'Reward:".$Q.Clean(date('Y-m-d'))."', current_timestamp(), current_timestamp(), 'Reward:".$Q.':'.Clean(GMT())."', '".$Q."', '', '', '0', 'RewardNew', '".p2d($Amount)."', 'USDT', '1', '".$BeforeBalance."', '".$AfterBalance."');"; 
			global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
			
			if($results){
                if($Dispatche==1){
					
					$Array=['feature'=>'Income_RewardMonthly','pair'=>'USDT_USDT','user'=>$Q,'amount'=>p2d($Amount),];
					HistoryUpdateNew($Array);
					
				}
			}
		}
	}
	return $results;
}



function PendingRankReward2024($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : Empty
    // Output : Rank Not Equal Zero Users Select

	$SQL="SELECT * FROM `Coinusers` WHERE `DRewardRank` != 0";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts;		
}




function Rewards2024($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : UserID
    // Output : Ditect Total Deposit, MasterLeg Deposit, AnotherLeg Deposit According Rank Update In Coinusers Table
 $Subordinate_Object = new Subordinate();
$Output=0;	
	
if(!$Q){$Q=i['id'];}	
$User=user($Q);
$DirectDeposit=d2p($User['DirectTotalDeposit']);	
$MasterLegDeposit=d2p($User['MasterLegDeposit']);	
$AnotherLegDeposit=d2p($User['AnotherLegDeposit']);
	
	if($DirectDeposit>=3200 and $MasterLegDeposit>=512000 and $AnotherLegDeposit>=512000){ $Rank = 10; }
	elseif($DirectDeposit>=1600 and $MasterLegDeposit>=256000 and $AnotherLegDeposit>=256000){ $Rank = 9; }
	elseif($DirectDeposit>=800 and $MasterLegDeposit>=128000 and $AnotherLegDeposit>=128000){ $Rank = 8; }
	elseif($DirectDeposit>=800 and $MasterLegDeposit>=64000 and $AnotherLegDeposit>=64000){ $Rank = 7; }
	elseif($DirectDeposit>=800 and $MasterLegDeposit>=32000 and $AnotherLegDeposit>=32000){ $Rank = 6; }
	elseif($DirectDeposit>=400 and $MasterLegDeposit>=16000 and $AnotherLegDeposit>=16000){ $Rank = 5; }
	elseif($DirectDeposit>=400 and $MasterLegDeposit>=8000 and $AnotherLegDeposit>=8000){ $Rank = 4; }
	elseif($DirectDeposit>=200 and $MasterLegDeposit>=4000 and $AnotherLegDeposit>=4000){ $Rank = 3; }
	elseif($DirectDeposit>=200 and $MasterLegDeposit>=2000 and $AnotherLegDeposit>=2000){ $Rank = 2; }
	elseif($DirectDeposit>=100 and $MasterLegDeposit>=1000 and $AnotherLegDeposit>=1000){ $Rank = 1; }
	else{$Rank=0;}
	
	if($Rank){
		
		$SQL="UPDATE `Coinusers` SET `DRewardRank`='".$Rank."' WHERE `ID`='".$Q."';"; 
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		if($results){ $return = $results; }
		else{ $return=0; }
		
		$Array=['user'=>$Q, 'rank'=>$Rank];
		$Subordinate_Object->Reward_RankUpdate($Array); unset($Array);
	
	}
	return $return;
}



function UpdateTeamBusiness($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : UserID
    // Output : Ditect Total Deposit, MasterLeg Deposit, AnotherLeg Deposit Update

	if(!$Q){ $Q=i['id']; }	
	$ST = Sep17_StakeTree2024($Q); 
	if($ST){
		
		$MLD=p2d($ST['Reward'][1]['amount']);
		$ALD=p2d($ST['Reward'][2]['amount']);
		$DirectDeposit=p2d($ST['DirectDeposit']);
		
		$SQL="UPDATE `Coinusers` SET `MasterLegDeposit`='".$MLD."', `AnotherLegDeposit`='".$ALD."', `DirectTotalDeposit`='".$DirectDeposit."' WHERE `ID`='".$Q."'"; //echo $SQL;
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		
		return $ST;
	}
}



function Sep17_StakeTree2024($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : UserID
    // Output : Direct Deposit, MasterLeg Deposit, AnotherLeg Deposit In Arrray
	
	 
	$Subordinate_Object = new Subordinate(); 
	
	if(!$Q){$Q=i['id']; } 
	$Tree=[]; $Rewards=[];	
	$users=$Subordinate_Object->Subordinates(['user'=>$Q, 'level'=>1, 'LIMIT'=>'All']);
	$Business=0; $DirectStake=0; $DirectDeposit=0;

	if($users){
		
	$aa=0;	
	foreach($users as $user){     
	$aa++;
		
	$user=$user['subordinate'];
	$thiss=user($user);  
		
	$ThisDeposit=$thiss['TotalDeposit2024']; $DirectDeposit=$DirectDeposit+$ThisDeposit;
	$TeamDeposit=TeamDeposit2024204($thiss['ID']);	
	$TD=$ThisDeposit + $TeamDeposit; 
		
	$Rewards[$aa]=array( 'TeamDeposit'=>d2p($TD), 'ThisDeposit'=>d2p($ThisDeposit), 'amount'=>d2p($TD), 'id'=>$thiss['ID'], 'user'=>$user );	
	
	}
	$RewardActual=$Rewards;  
	arsort($Rewards); 
	
	$bb=0;
	foreach($Rewards as $Reward){
	$bb++;
	
	if($bb==1){ $DLegs[$bb]=$Reward['amount']; $Rewarddd[$bb]=array('id'=>$Reward['id'],'amount'=> $Reward['amount']);}
	else{$DLegs[2]=$DLegs[2]+$Reward['amount']; $Rewarddd[2] = array( 'id'=>'various', 'amount'=> $DLegs[2]);}
	
	}
	$Output=array( 'AllLegs'=>$TreeActual, 'Legs'=>$Treee, 'TeamStake'=>$Business, 'DirectStake'=>d2p($DirectStake), 'DirectDeposit'=>d2p($DirectDeposit), 'Reward'=>$Rewarddd );
	
	}
	return $Output; 
}


function TeamDeposit2024204($Q=null){ 
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : UserID
    // Output : Level1 To Level3 Deposit Business 
    
    if(!$Q){ $Q=i['id']; }
	$B=0; 
	if($Q){	
		
	    $Subordinate_Object = new Subordinate(); 
		
		$Downlines =$Subordinate_Object->Subordinates(['user'=>$Q, 'mindeposit'=>1000000000, 'minlevel'=>1, 'maxlevel'=>30, 'LIMIT'=>'All']);
		 
	 
		if($Downlines){
		$aa=0;
		foreach($Downlines as $Level){
		$aa++;  
		$User=user($Level['subordinate']);
		if($User['TotalDeposit2024']){
					
		$User=$User['TotalDeposit2024']; 
		$B=$B+$User;
		
		}
		}
		}
	}
	if($B){ /*UpdateTeamStake($B);*/ return $B; }
}





function SelfDepositUpdate($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : Empty
    // Output : Self Deposit Update In Coinusers Table

	$PendingSelfDeposit = PendingSelfDeposit();
	if($PendingSelfDeposit){
		foreach($PendingSelfDeposit as $Ps){
			
			$SQL="UPDATE `Coinusers` SET `TotalDeposit2024` = '".$Ps['amount']."' WHERE `Coinusers`.`ID` = '".$Ps['user']."';";
			global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	

		}
	}
	return $results;
}





function SelfDepositUpdateSubordinate($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : Empty
    // Output : Self Deposit Update In Subordinate

	$PendingSelfDeposit = PendingSelfDeposit();
	if($PendingSelfDeposit){
		$a=0;
		foreach($PendingSelfDeposit as $Ps){
			$a++;
			
			$SQL="UPDATE `Coinpods_subordinate` SET `deposit`='".$Ps['amount']."' WHERE `subordinate` = '".$Ps['user']."';";
			global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
		
		}
	}
	return $results;
}



function PendingSelfDeposit($Q=null){
    // Developer : Pawan Kumar Meghwal
    // Date : 2025-09-26
    // Input : Empty
    // Output : Self Total Deposit Group By User

	$Start = date("Y-m").'-01 00:00:01'; $End = date("Y-m").'-31 23:59:59';
	if($Q){ 
		$SQL="SELECT SUM(`amount`) AS 'amount' FROM `Coinpods_transaction` WHERE `created` BETWEEN '".$Start."' AND '".$End."' AND `ttype` = 'Deposit' AND `user` = '".$Q."' AND `status` = 1;"; 
	}
	else{ 
		$SQL="SELECT `user`, SUM(`amount`) as 'amount' FROM `Coinpods_transaction` WHERE `created` BETWEEN '".$Start."' AND '".$End."' AND `ttype` = 'Deposit' AND `status` = 1 GROUP BY `user`;"; 
	}
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	if($Q){ return $ts[0]; } else{ return $ts; }

}



?>