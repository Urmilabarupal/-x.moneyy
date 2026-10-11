<?php






function CreateReward($Q=null){
$Output='';
	if($Q){
		
		$echo = 'Q Data Found';
		$User=user($Q);
		if($User){
			$echo = 'User Found';
			
		$Fundings=Reward($Q);
		if(!$Fundings){
			$echo ='Inserting Funding';
			
			
			 
			$SQL="INSERT INTO `Coinpods_reward`(`id`, `name`, `user`, `created`, `modified`, `achievement`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`) VALUES (NULL,'".$User['ID']."','".$User['ID']."', current_timestamp(), current_timestamp(),'0','0','0','0','0','0','0','0','0','0','0')";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
			
			
			if($results){				
				$SQL1="UPDATE `Coinusers` SET `Reward` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
				global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);		
				$echo = 'All Done';
				
			}
			
			
			
		}
		else{ 
			//print_r($Fundings);
			$SQL1="UPDATE `Coinusers` SET `Reward` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);			
			$echo = 'Already wallet availble.';
		}
		}
		else{ $echo = 'Wrong user ID.'; }
	}	
	else{ $echo = 'Q Data Not Found.'; }
	//return $echo;
}



function CreateRewards(){
	$aa=0;
	$PendingFundings=PendingRewards();	 
	if($PendingFundings){
		foreach($PendingFundings as $PW){ $aa++;
			 CreateReward($PW['ID']);		
		}		
	}	
	//echo $aa;
}



function PendingRewards(){

	$SQL="SELECT * FROM `Coinusers` WHERE `Reward` = 0";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}








function Reward($Q=null){
	
if($Q){$SQL="SELECT * FROM `Coinpods_reward` WHERE `user` = '".$Q."'"; }
else{ $SQL="SELECT * FROM `Coinpods_reward` WHERE `user` = '".i['id']."'"; }

	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
 	
 return $ts[0];

}

$Reward=Reward();
define('Reward',$Reward);








?>