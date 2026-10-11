<?php
      //⚠️ALERT DUBAI TRIP WORK PANDING By A'NIL RAJPUROHIT⚠️






function Dec1_TeamStakeeeeee($Q=null){ 
// Developer : AnilNayak (Temporary)
// Date : 2024-10-04
// Input : UserID
// Output : Total Team Deposit 1 To 30 Level
	
	if(!$Q){ $Q=i['id']; }
	
	$Q=UserByUserID($Q)['ID'];
	$B=0; 
	if($Q){	
		
		$Downlines = Subordinates(['user'=>$Q, 'minlevel'=>1, 'maxlevel'=>30, 'LIMIT'=>111111]);
		if($Downlines){
		$aa=0;
		foreach($Downlines as $Level){
		$aa++;  
		$User=user($Level['subordinate']);
		if($User['Dec1_TotalStake']){
					
		$User=$User['Dec1_TotalStake']; 
		$B=$B+$User;
		
		}
		}
		}
	}
	if($B){ /*UpdateTeamStake($B);*/ return $B; }
}
















function CalculateAchievement3($Q=null){
	//Developer = A'NIL RAJPUROHIT
	//Date = 27-01-2025
	//Output = Dubai Trip
$A3=0;
	
if(is_array($Q)){ $MasterLeg = $Q['MasterLeg']; $AnotherLeg = $Q['AnotherLeg']; 	}
	
 
	if($MasterLeg and $AnotherLeg){
	
	if($MasterLeg>=32000 and $AnotherLeg>=32000){ $A3=1; } //DUBAI TRIP
	
	}	
	
return $A3;	
	
}





function PendingAchievements3($Q=null){
	
	$SQL="SELECT * FROM `Coinusers` WHERE `Dec1_MasterLegStake` >= 32000000000000 AND `Dec1_AnotherLegStake` >= 32000000000000 ORDER BY `ID` ASC";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts;	
	
}



function Achievement3($Q=null){
	$results='';
	
	if(is_array($Q)){ $User=$Q['user']; $Achievement3=$Q['achievement3']; }
	if($User and $Achievement3){
		
		$SQL="UPDATE `Coinusers` SET `achievement3` = '".$Achievement3."' WHERE `Coinusers`.`ID` = '".$User."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		
		
	}
	return $results;
	
}


function Achievements3($Q=null){
	//Developer = A'NIL RAJPUROHIT
	//Date = 27-01-2025
	$Total = 0;
	
	$PAs = PendingAchievements3();
	if($PAs){
		
		foreach($PAs as $PA){
			
			$Q = array(
				
				'MasterLeg'=>d2p($PA['Dec1_MasterLegStake']),
				'AnotherLeg'=>d2p($PA['Dec1_AnotherLegStake']),
			);
			
			
			$CalculateAchievement3 = CalculateAchievement3($Q); $Q=0; 
			
			if($CalculateAchievement3){ 
				
				if(Achievement3( array( 'user'=>$PA['ID'], 'achievement3'=>$CalculateAchievement3 ) )){
	
					$Total++;
				}
			}
			
		}		
		
	}	
	
	return $Total;
}



function Dec1_StakeTree($Q=null){
//A'nil Rajpurohit
//27-01-2025	
//Processing
	
	$echo="Dec1_StakeTree Function Start";
	
	if(!$Q){$Q=i['userid']; }
	$Tree=[]; $Rewards=[];
	$users=Downline($Q); // Get users of only level 1
	$Business=0; $DirectStake=0; $DirectDeposit=0;
	if($users){
		$echo="Directs Found";
		$aa=0;
		foreach($users as $user){
			$echo="DirectForeach";
			
			$user=$user['userid'];
			$aa++;
			$thiss=UserByUserID($user);
			$ThisStake=$thiss['Dec1_TotalStake']; $DirectStake=$DirectStake+$ThisStake;
			$echo="Each Direct User Dec1_TotalStake Sum";
			
			$TeamStake=Dec1_TeamStake($thiss['userid']);
			$TB=$ThisStake + $TeamStake;
			$echo="This Stake(Self) And Team Stake Sum";
			
			$Tree[$aa]=array( 'TeamStake'=>d2p($TB), 'ThisStake'=>d2p($ThisStake),  'amount'=>d2p($TB), 'id'=>$thiss['ID'], 'userid'=>$user );
		}
		
		$TreeActual=$Tree;
		arsort($Tree);
		
		$aa=0;
		foreach($Tree as $Branch){
			
			$echo="Tree To Branch Foreach.";
			$aa++;
			if($aa==1){ $Legs[$aa]=$Branch['amount']; $Treee[$aa]=array('id'=>$Branch['id'],'amount'=> $Branch['amount']);}
	//THIS IS FOR ANOTHER LEG
			elseif($aa==2){$Legs[2]=$Legs[2]+$Branch['amount']; $Treee[2] = array( 'id'=>'Another', 'amount'=> $Legs[2]);}
			
			else{
				$echo="THIS IS FOR All LEGS";
				if(!isset($Legs[3])){$Legs[3] = 0;}
				$Legs[3] += $Branch['amount'];
				$Treee[3] = array('id' => 'various', 'amount' => $Legs[3]+$Legs[2]);
			}
		}
		
		foreach($Legs as $Leg){ $Business=$Business+$Leg; $echo="Total Business."; }
		
		$Output=array( 'AllLegs'=>$TreeActual,  'Legs'=>$Treee, 'TeamStake'=>$Business, 'DirectStake'=>d2p($DirectStake),'DirectDeposit'=>d2p($DirectDeposit) );
		
		if($Output){$echo="All Done.";}

	}
	//echo $echo;
	return $Output;
}




function Dec1_UpdateMasterAndAnotherLegStake($Q=null){
//Some Works Pending 	
	                  // NOTE Jis User Ki Team Bdi Hai Tb Ye Function Bhot Load Leta Hai [Check Krna Pdega Pending]
	
	if(!$Q){ $Q=i['userid']; }
	$ST = Dec1_StakeTree($Q); 
	if($ST){

	$MLS=p2d($ST['Legs'][1]['amount']);
	$ALS=p2d($ST['Legs'][2]['amount']); //FOR ANOTHER LEGS
	$AllLegs=p2d($ST['Legs'][3]['amount']);
		
		//echo '<br>'.'MLS '.d2p($MLS).'<br>';
		//echo '<br>'.'ALS '.d2p($ALS).'<br>';
		//echo '<br>'.'AllLegs '.d2p($AllLegs).'<br>';
		
		$SQL="UPDATE `Coinusers` SET `Dec1_MasterLegStake`='".$MLS."', `Dec1_AnotherLegStake`='".$ALS."', `Dec1_AllLegStake`='".$AllLegs."' WHERE `userid`='".$Q."'";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	
	return $results;
  }
}



function Dec1_TeamStake($Q=null){ 
//A'nil Rajpurohit
//Input : UserID
	
 	
	
if(!$Q){ $Q=i['userid']; }
$B=0;  
if($Q){	
$Team = CreateTeam($Q);
//$Team = Team($Q); $Team = json_decode($Team['json'], true);
	
$Downlines = $Team;


$Users=$Downlines['users'];	 
	
if($Users){	
	foreach($Users as $Level){		
		if($Level){
			foreach($Level as $UserID){	
				
				
				 
				$User=UserByUserID($UserID);
						
				$User=$User['Dec1_TotalStake'];   	
				$B=$B+$User;		
			}						
		}
	}
}
}
	
 
if($B){ /*UpdateTeamStake($B);*/ return $B;}
 	
	
}





function Dec1_TotalStake($Q=null){
if(is_array($Q)){ $user=$Q['user']; $Amount=$Q['amount']; }	
	if($user and $Amount){
		$SQL="UPDATE `Coinusers` SET `Dec1_TotalStake` = '".$Amount."' WHERE `Coinusers`.`ID` = '".$user."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		return $results;
	}
}





function Dec1_PendingTotalStake($Q=null){
	
	$SQL="SELECT SUM(`usd`) AS `amount`, user FROM `Coinpods_staking` WHERE `created` > '2024-12-01 00:00:00' AND `created` <= '2025-05-31 23:59:59' AND `period`='1825' GROUP BY `user`;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;	
}


function Dec1_TotalStakes($Q=null){
	$Output=0;
	$PTS=Dec1_PendingTotalStake();
	if($PTS){
		foreach($PTS as $U){
			//print_r($U['ID']);echo '<br>';
			$Dec1_TotalStake=Dec1_TotalStake($U);
			if($Dec1_TotalStake){ $Output++; }
		}
	}
	return $Output;
}









function Dec1_UpdateTotalStake($Q=null){
if(!$Q){ $Q=i['id']; }	
	if($Q){
		$Total=Dec1_TotalStake($Q);
		$SQL="UPDATE `Coinusers` SET `Dec1_TotalStake` = '".$Total."' WHERE `Coinusers`.`ID` = '".$Q."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		return $Total;
	}
}







/*

function SelfStaking6Months($Q=null){
// Developer :A'nil R@jpurohit
// Date : 2025-01-25
// Input : User Id
// Output : Last 6 Month Stake Sum
	
	if($Q){
		
		$Start = '2024-12-01 00:00:01'; $End = '2025-05-31 23:59:59';
		//$Start = date("Y-m").'-01 15:00:01'; $End = date("Y-m").'-31 23:59:59';

		$SQL="SELECT `user`, SUM(`usd`) AS 'amount' FROM `Coinpods_staking` WHERE `created` BETWEEN '".$Start."' AND '".$End."' AND `user`='".$Q."' AND `period` >= 1825 GROUP BY `user`;"; //echo $SQL;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}

	}
	return $ts[0];	
}

*/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




?>