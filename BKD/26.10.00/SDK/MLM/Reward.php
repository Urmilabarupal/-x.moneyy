<?php

function GanrateRewards(){
//Developer: Pawan Kumar	
	$PendingReward=PendingReward();
	if($PendingReward){
		foreach($PendingReward as $PR){
			$GPR=GanratePendingReward($PR['ID']);
		}
	}
	return $GPR;
}






function GanratePendingReward(){
//Developer: Pawan Kumar
    if(i['achievement2']==1){ $R='Samsung Mobile'; }
	elseif(i['achievement2']==2){ $R='HP Leptop'; }
	elseif(i['achievement2']==3){ $R='Scooter/iphone'; }
	elseif(i['achievement2']==4){ $R='Motor Cycle Enfield'; }
	elseif(i['achievement2']==5){ $R='Hatchback Car With Malysia Tour'; }
	elseif(i['achievement2']==6){ $R='Sedan Car With Dubai Tour'; }
	elseif(i['achievement2']==7){ $R='JEEP + Europe Tour'; }
	elseif(i['achievement2']==8){ $R='BMW 3 Series'; }
	elseif(i['achievement2']==9){ $R='2 BHK Dream House'; }
    elseif(i['achievement2']==10){ $R='2 BHK House at Dubai + 3 Annual Trip for 4 Persons + 10% CTO Royalty Every Month'; }

	return $R;
}






function PendingReward(){
//Developer: Pawan Kumar	
	$SQL="SELECT * FROM `Coinusers` WHERE `achievement2` != 0";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts;		
}






function Rewards($Q=null){
//Developer: Pawan Kumar	
$Output=0;	
	
if(!$Q){$Q=i['id'];}	

$SelfStake=d2p(i['Sep17_TotalStake']*0.012);	
$DirectStake=d2p(i['Sep17_DirectTotalStake']*0.012);	
$MasterLegStake=d2p(i['Sep17_MasterLegStake']*0.012);	
$AnotherLegStake=d2p(i['Sep17_AnotherLegStake']*0.012);	


	if($SelfStake>=1000 and $DirectStake>=2000 and $MasterLegStake>=10000 and $AnotherLegStake>=10000){ $Reward= 1; }
	elseif($SelfStake>=1000 and $DirectStake>=3000 and $MasterLegStake>=25000 and $AnotherLegStake>=25000){ $Reward= 2; }
	elseif($SelfStake>=1000 and $DirectStake>=4000 and $MasterLegStake>=50000 and $AnotherLegStake>=50000){ $Reward= 3; }
	elseif($SelfStake>=1000 and $DirectStake>=5000 and $MasterLegStake>=100000 and $AnotherLegStake>=100000){ $Reward= 4; }
	elseif($SelfStake>=1500 and $DirectStake>=6000 and $MasterLegStake>=200000 and $AnotherLegStake>=200000){ $Reward= 5; }
	elseif($SelfStake>=2000 and $DirectStake>=7000 and $MasterLegStake>=400000 and $AnotherLegStake>=400000){ $Reward= 6; }
	elseif($SelfStake>=2000 and $DirectStake>=8000 and $MasterLegStake>=800000 and $AnotherLegStake>=800000){ $Reward= 7; }
    elseif($SelfStake>=2500 and $DirectStake>=16000 and $MasterLegStake>=1600000 and $AnotherLegStake>=1600000){ $Reward= 8; }
	elseif($SelfStake>=2500 and $DirectStake>=32000 and $MasterLegStake>=3200000 and $AnotherLegStake>=3200000){ $Reward= 9; }
    elseif($SelfStake>=3000 and $DirectStake>=64000 and $MasterLegStake>=10000000 and $AnotherLegStake>=10000000){ $Reward= 10; }

	
	
if($Reward){
		
$SQL="UPDATE `Coinusers` SET `achievement2`='".$Reward."' WHERE `ID`='".$Q."';";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if($results){ $return = $PB; }
	else{ $return=0; }
	
	}
return $return;
}



?>