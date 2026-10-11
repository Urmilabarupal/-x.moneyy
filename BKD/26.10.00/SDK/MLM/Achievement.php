<?php





function CalculateAchievement2($Q=null){
$A=0;
	
if(is_array($Q)){ $SelfStake = $Q['SelfStake']; $DirectStake = $Q['DirectStake']; $MasterLeg = $Q['MasterLeg']; $AnotherLeg = $Q['AnotherLeg']; 	}
	
 
	if($SelfStake and $MasterLeg and $AnotherLeg and $DirectStake){
	
	if($SelfStake>=500 and $MasterLeg>=5000 and $AnotherLeg>=5000 and $DirectStake>=1000){ $A=1; }
	if($SelfStake>=500 and $MasterLeg>=12500 and $AnotherLeg>=12500 and $DirectStake>=1500){ $A=2; }
	if($SelfStake>=500 and $MasterLeg>=25000 and $AnotherLeg>=25000 and $DirectStake>=2000){ $A=3; }
	if($SelfStake>=500 and $MasterLeg>=50000 and $AnotherLeg>=50000 and $DirectStake>=2500){ $A=4; }
	if($SelfStake>=750 and $MasterLeg>=100000 and $AnotherLeg>=100000 and $DirectStake>=3000){ $A=5; }
	if($SelfStake>=1000 and $MasterLeg>=200000 and $AnotherLeg>=200000 and $DirectStake>=3500){ $A=6; }
	if($SelfStake>=1000 and $MasterLeg>=400000 and $AnotherLeg>=400000 and $DirectStake>=4000){ $A=7; }
	if($SelfStake>=1250 and $MasterLeg>=800000 and $AnotherLeg>=800000 and $DirectStake>=8000){ $A=8; }
	if($SelfStake>=1250 and $MasterLeg>=1600000 and $AnotherLeg>=1600000 and $DirectStake>=16000){ $A=9; }
	if($SelfStake>=2500 and $MasterLeg>=5000000 and $AnotherLeg>=5000000 and $DirectStake>=32000){ $A=10; }
 
	}	
	
return $A;	
	
}





function PendingAchievements2(){
	
	$SQL="SELECT * FROM `Coinusers` WHERE `Sep17_TotalStake` >= 500000000000 AND `Sep17_DirectTotalStake` >= 1000000000000 AND `Sep17_MasterLegStake` >= 5000000000000 AND `Sep17_AnotherLegStake` >= 5000000000000 ORDER BY `ID` ASC";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts;	
	
}



function Achievement2($Q=null){
	$results='';
	
	if(is_array($Q)){ $User=$Q['user']; $Achievement2=$Q['achievement2']; }
	if($User and $Achievement2){
		
		$SQL="UPDATE `Coinusers` SET `achievement2` = '".$Achievement2."' WHERE `Coinusers`.`ID` = '".$User."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		
		
	}
	return $results;
	
}


function Achievements2(){
	$Total = 0;
	
	$PAs = PendingAchievements2();
	if($PAs){
		
		foreach($PAs as $PA){
			
			$Q = array(
				'SelfStake'=>d2p($PA['Sep17_TotalStake']),
				'DirectStake'=>d2p($PA['Sep17_DirectTotalStake']),
				'MasterLeg'=>d2p($PA['Sep17_MasterLegStake']),
				'AnotherLeg'=>d2p($PA['Sep17_AnotherLegStake']),
			);
			
			
			$CalculateAchievement2 = CalculateAchievement2( $Q ); $Q=0; //print_r($CalculateAchievement2);
			
			if($CalculateAchievement2){ 
				if(Achievement2( array( 'user'=>$PA['ID'], 'achievement2'=>$CalculateAchievement2 ) )){
	
					$Total++;
				}
			}
			
		}		
		
	}	
	
	return $Total;
}





















//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function Achievement($Q=null){	

$A=0;	
$SS[1]=5000; $SS[2]=2500; $SS[3]=2500; $SS[4]=2000; $SS[5]=2000; $SS[6]=1500; $SS[7]=1500; $SS[8]=1000; $SS[9]=1000; $SS[10]=1000;	
$TS[1]=10000000; $TS[2]=3200000; $TS[3]=1600000; $TS[4]=800000; $TS[5]=400000; $TS[6]=200000; $TS[7]=100000; $TS[8]=50000; $TS[9]=25000; $TS[10]=10000;	
	
if(is_array($Q)){ $SelfStake = $Q['SelfStake']; $MasterLeg = $Q['MasterLeg']; $AnotherLeg = $Q['AnotherLeg']; $DirectStake = $Q['DirectStake'];	}
	
if(i['id']){
	if($SelfStake and $MasterLeg and $AnotherLeg and $DirectStake){
	
	if($SelfStake>=1000 and $MasterLeg>=10000 and $AnotherLeg>=10000 and $DirectStake>=2000){ $A=10; }
	if($SelfStake>=2000 and $MasterLeg>=35000 and $AnotherLeg>=35000 and $DirectStake>=5000){ $A=9; }
	if($SelfStake>=3000 and $MasterLeg>=85000 and $AnotherLeg>=85000 and $DirectStake>=9000){ $A=8; }
	if($SelfStake>=4500 and $MasterLeg>=185000 and $AnotherLeg>=185000 and $DirectStake>=14000){ $A=7; }
	if($SelfStake>=6000 and $MasterLeg>=385000 and $AnotherLeg>=385000 and $DirectStake>=20000){ $A=6; }
	if($SelfStake>=8000 and $MasterLeg>=785000 and $AnotherLeg>=785000 and $DirectStake>=27000){ $A=5; }
	if($SelfStake>=10000 and $MasterLeg>=1585000 and $AnotherLeg>=1585000 and $DirectStake>=35000){ $A=4; }
	if($SelfStake>=12500 and $MasterLeg>=3185000 and $AnotherLeg>=3185000 and $DirectStake>=51000){ $A=3; }
	if($SelfStake>=15000 and $MasterLeg>=6385000 and $AnotherLeg>=6385000 and $DirectStake>=83000){ $A=2; }
	if($SelfStake>=20000 and $MasterLeg>=16385000 and $AnotherLeg>=16385000 and $DirectStake>=147000){ $A=1; }
 
  	
		
/*


if($TotalStake>=$SS[10] and $TeamStake>=$TS[10]){ $A=10; }
if($TotalStake>=$SS[10]+$SS[9] and $TeamStake>=$TS[10]+$TS[9]){ $A=9; }
if($TotalStake>=$SS[10]+$SS[9]+$SS[8] and $TeamStake>=$TS[10]+$TS[9]+$TS[8]){ $A=8; }
if($TotalStake>=$SS[10]+$SS[9]+$SS[8]+$SS[7] and $TeamStake>=$TS[10]+$TS[9]+$TS[8]+$TS[7]){ $A=7; }
if($TotalStake>=$SS[10]+$SS[9]+$SS[8]+$SS[7]+$SS[6] and $TeamStake>=$TS[10]+$TS[9]+$TS[8]+$TS[7]+$TS[6]){ $A=6; }
if($TotalStake>=$SS[10]+$SS[9]+$SS[8]+$SS[7]+$SS[6]+$SS[5] and $TeamStake>=$TS[10]+$TS[9]+$TS[8]+$TS[7]+$TS[6]+$TS[5]){ $A=5; }
if($TotalStake>=$SS[10]+$SS[9]+$SS[8]+$SS[7]+$SS[6]+$SS[5]+$SS[4] and $TeamStake>=$TS[10]+$TS[9]+$TS[8]+$TS[7]+$TS[6]+$TS[5]+$TS[4]){ $A=4; }
if($TotalStake>=$SS[10]+$SS[9]+$SS[8]+$SS[7]+$SS[6]+$SS[5]+$SS[4]+$SS[3] and $TeamStake>=$TS[10]+$TS[9]+$TS[8]+$TS[7]+$TS[6]+$TS[5]+$TS[4]+$TS[3]){ $A=3; }
if($TotalStake>=$SS[10]+$SS[9]+$SS[8]+$SS[7]+$SS[6]+$SS[5]+$SS[4]+$SS[3]+$SS[2] and $TeamStake>=$TS[10]+$TS[9]+$TS[8]+$TS[7]+$TS[6]+$TS[5]+$TS[4]+$TS[3]+$TS[2]){ $A=2; }
if($TotalStake>=$SS[10]+$SS[9]+$SS[8]+$SS[7]+$SS[6]+$SS[5]+$SS[4]+$SS[3]+$SS[2]+$SS[1] and $TeamStake>=$TS[10]+$TS[9]+$TS[8]+$TS[7]+$TS[6]+$TS[5]+$TS[4]+$TS[3]+$TS[2]+$TS[1]){ $A=1; }
 
 
 
 
*/
		
		
		
		
		if($A != i['achievement']){
			$SQL="UPDATE `Coinusers` SET `achievement` = '".$A."' WHERE `Coinusers`.`ID` = '".i['id']."';";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);			
		}
		
}
	else{ $echo = 'Not enough resources.'; }
	}
	return $A;
 	
}



?>