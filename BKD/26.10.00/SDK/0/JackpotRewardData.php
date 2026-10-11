<?php

function UpdateJackpotData($Q=null){
	
	$PendingJackpotDataUser=PendingJackpotDataUser();
	if($PendingJackpotDataUser){
		foreach($PendingJackpotDataUser as $Ps){
			if($Ps){
				
				$Y = date("Y"); $M = (new DateTime())->modify('-1 month')->format('m'); //$M = date("m");
				$Date = $Y.':'.$M;
				
				$SQL="INSERT INTO `Coinpods_jackpotrewarddata`(`id`, `name`, `created`, `modified`, `user`, `uid`, `status`, `privacy`, `app`, `mlu`, `alu`, `du`, `jackpotteamrewardrank`, `jackpotdirectrewardrank`) VALUES (NULL, 'Jackpot Reward Data', current_timestamp(), '".$Date."-31', '".$Ps['ID']."', '', '1', '', '1', '".$Ps['MasterLegJackpotUser']."', '".$Ps['AnotherLegJackpotUser']."', '".$Ps['JackpotActiveDirect']."', '".$Ps['JackpotTeamRewardRank']."', '".$Ps['JackpotDirectRewardRank']."')";
				global $DB; $aa=0; $results = mysqli_query($DB, $SQL);
				$IID = mysqli_insert_id($DB);
				if($results){
					
					$SQL1="UPDATE `Coinpods_jackpotrewarddata` SET `uid`='".$IID."' WHERE `id` = '".$IID."';";
					global $DB; $aa=0; $results = mysqli_query($DB, $SQL1);
					if($results){
						
						$SQL2="UPDATE `Coinusers` SET `JRDStatus`='1' WHERE `ID` = '".$Ps['ID']."'";
						global $DB; $aa=0; $results = mysqli_query($DB, $SQL2);
					
					}
					else{
						
						$SQL3="UPDATE `Coinusers` SET `JRDStatus`='2' WHERE `ID` = '".$Ps['ID']."'";
						global $DB; $aa=0; $results = mysqli_query($DB, $SQL3);
						
					}
				}
			}
		}
	}
	return $results;
}




function PendingJackpotDataUser($Q=null){
	
	$SQL="SELECT * FROM `Coinusers` WHERE `JackpotActiveDirect` != 0 OR `MasterLegJackpotUser` != 0 OR `AnotherLegJackpotUser` != 0;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	return $ts;

}





?>