<?php

// Developer : Pawan kumar
// Date : 2024-05-14
// Note : Yh all function one time uss hone wale hai. yh function important nhi hai.


function AddToFundingTotalUnStake($Q=null){
	
	$PendingDataUnStakeUser=PendingDataUnStakeUser();
	if($PendingDataUnStakeUser){
		foreach($PendingDataUnStakeUser as $Ps){
			//print_r($Ps['user'].' '.$Ps['TotalUnstake']);
			
			if(AddToFunding(array( 'user'=>$Ps['user'], 'ccc'=>'ccc', 'amount'=>$Ps['TotalUnstake'] ))){
				
				$SQL="UPDATE `StakeData` SET `status`='1' WHERE `user` = '".$Ps['user']."';";
				global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
			
			}
			else{
				
				$SQL1="UPDATE `StakeData` SET `status`='2' WHERE `user` = '".$Ps['user']."';";
				global $DB; $aa = 0; $results = mysqli_query($DB, $SQL1);
			
			}
		}
	}
	return $results;
}



function PendingDataUnStakeUser($Q=null){
	
	$SQL="SELECT * FROM `StakeData` WHERE `TotalUnstake` != 0 AND `status` = 0 LIMIT 1000";
	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	if($ts){ return $ts; }

}







////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Total Stake Amount ko Funding Wallet Me Add //





function AddToFundingTotalStake($Q=null){
	
	$PendingDataStakeUser=PendingDataStakeUser();
	if($PendingDataStakeUser){
		foreach($PendingDataStakeUser as $Ps){
			//print_r($Ps['user'].' '.$Ps['TotalStake']);
			
			if(AddToFunding(array( 'user'=>$Ps['user'], 'ccc'=>'ccc', 'amount'=>$Ps['TotalStake'] ))){
				
				$SQL="UPDATE `StakeData` SET `status`='1' WHERE `user` = '".$Ps['user']."';";
				global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
			
			}
			else{
				
				$SQL1="UPDATE `StakeData` SET `status`='2' WHERE `user` = '".$Ps['user']."';";
				global $DB; $aa = 0; $results = mysqli_query($DB, $SQL1);
			
			}
		}
	}
	return $results;
}





function PendingDataStakeUser($Q=null){
	
	$SQL="SELECT * FROM `StakeData` WHERE `TotalStake` != 0 AND `status` = 0 LIMIT 1000";
	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	if($ts){ return $ts; }

}






////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update Total UnStake By User Stake Data Table Me //





function UpdateTotalUnstakeByUser($Q=null){
	
	$TotalUnstakeUsers=TotalUnstakeUsers();
	if($TotalUnstakeUsers){
		foreach($TotalUnstakeUsers as $Ps){
			//print_r($Ps['user'].' '.$Ps['TotalStake']); echo '<br>';
			if($Ps){
				
				$SQL="UPDATE `StakeData` SET `TotalUnstake`='".$Ps['TotalUnstake']."' WHERE `user` = '".$Ps['user']."'";
				global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
				if($results){
					
					$SQL1="UPDATE `Coinpods_stake` SET `TotalUnstakeStatus`='1' WHERE `status` = 7 AND `user` = '".$Ps['user']."';";
					global $DB; $aa = 0; $results = mysqli_query($DB, $SQL1);
				
				}
				else{
					
					$SQL2="UPDATE `Coinpods_stake` SET `TotalUnstakeStatus`='2' WHERE `status` = 7 AND `user` = '".$Ps['user']."';";
					global $DB; $aa = 0; $results = mysqli_query($DB, $SQL2);
				
				}
			}
		}
	}
	return $results;
}








function TotalUnstakeUsers($Q=null){
	
	$SQL="SELECT SUM(`amount`) as 'TotalUnstake', `user` FROM `Coinpods_stake` WHERE `status` = 7 AND `TotalUnstakeStatus` = 0 GROUP BY `user` LIMIT 1000;";
	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	if($ts){ return $ts; }
	
}






////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update Total Stake By User Stake Data Table Me //



function UpdateTotalStakeByUser($Q=null){
	
	$TotalStakeUsers=TotalStakeUsers();
	if($TotalStakeUsers){
		foreach($TotalStakeUsers as $Ps){
			//print_r($Ps['user'].' '.$Ps['TotalStake']); echo '<br>';
			if($Ps){
				
				$SQL="UPDATE `StakeData` SET `TotalStake`='".$Ps['TotalStake']."' WHERE `user` = '".$Ps['user']."'";
				global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
				
				if($results){
					
					$SQL1="UPDATE `Coinpods_stake` SET `TotalStakeStatus`='1' WHERE `status` = 1 AND `user` = '".$Ps['user']."';";
					global $DB; $aa = 0; $results = mysqli_query($DB, $SQL1);
				
				}
				else{
					
					$SQL2="UPDATE `Coinpods_stake` SET `TotalStakeStatus`='2' WHERE `status` = 1 AND `user` = '".$Ps['user']."';";
					global $DB; $aa = 0; $results = mysqli_query($DB, $SQL2);
				
				}
			}
		}
	}
	return $results;
}





function TotalStakeUsers($Q=null){
	
	$SQL="SELECT SUM(`amount`) as 'TotalStake', `user` FROM `Coinpods_stake` WHERE `status` = 1 AND `TotalStakeStatus` = 0 GROUP BY `user` LIMIT 10000;";
	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	if($ts){ return $ts; }
	
}












////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// User Entry In StakeData Table me //

function StakeUserUpdate($Q=null){
	
	$PendingStakeUser=PendingStakeUser();
	if($PendingStakeUser){
		foreach($PendingStakeUser as $Ps){
			//print_r($Ps['ID']); echo '<br>';
			
			if($Ps){
				$SQL="INSERT INTO `StakeData`(`id`, `user`, `TotalStake`, `TotalUnstake`, `status`) VALUES (NULL, '".$Ps['ID']."', '','','')";
				global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
				if($results){
					
					$SQL1="UPDATE `Coinusers` SET `StakeUser`='1' WHERE `ID` = '".$Ps['ID']."';";
					global $DB; $aa = 0; $results = mysqli_query($DB, $SQL1);
				
				}
				else{
					
					$SQL2="UPDATE `Coinusers` SET `StakeUser`='2' WHERE `ID` = '".$Ps['ID']."';";
					global $DB; $aa = 0; $results = mysqli_query($DB, $SQL2);
				
				}
			}
		}
	}
return $results;	
}





function PendingStakeUser($Q=null){
	
	$SQL="SELECT * FROM `Coinusers` WHERE `StakeUser` = '0' LIMIT 100000";
	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	if($ts){ return $ts; }

}

?>