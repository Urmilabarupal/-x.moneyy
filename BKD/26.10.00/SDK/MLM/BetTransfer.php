<?php

function InsertBets(){
	
	$PendingBetTransfer=PendingBetTransfer();
	if($PendingBetTransfer){
		foreach($PendingBetTransfer as $PBT){
			//print_r($PBT['user']);
			
			$User=user($PBT['user']);
			$LottreyNo=random_int(100000, 999999);
			
			$InsertAirdropBet=InsertAirdropBet( array('user_login'=>$User['user_login'], 'created'=>$PBT['created'], 'modified'=>$PBT['modified'], 'amount'=>$PBT['amount'], 'bid'=>$LottreyNo) );
			if($InsertAirdropBet){
				BetStatusOne($PBT['name']);
			}
			else{ BetStatusTwo($PBT['name']); }
		}
	}
}





function BetStatusOne($Q=null){
	if($Q){
		$SQL="UPDATE `Coinpods_bet` SET `StatusBet`='1' WHERE `name` = '".$Q."';";
		global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);
	}
	return $Output;
}



function BetStatusTwo($Q=null){
	if($Q){
		$SQL="UPDATE `Coinpods_bet` SET `StatusBet`='2' WHERE `name` = '".$Q."';";
		global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);
	}
	return $Output;
}





function InsertAirdropBet($Q=null){
	
	if(is_array($Q)){ $user_login=$Q['user_login']; $created=$Q['created']; $modified=$Q['modified']; $amount=$Q['amount']; $bid=$Q['bid']; }
	if($user_login and $created and $modified and $amount and $bid){
		$User=Exchange_UserByUsername($user_login);
		
		if($User){
		
		$SQL="INSERT INTO `Coinpods_bet`(`id`, `name`, `created`, `modified`, `user`, `amount`, `on`, `ccc`, `period`, `status`, `bid`, `ttype`) VALUES (NULL, 'Hx.money:".$User['ID']."', '".$created."', '".$modified."', '".$User['ID']."', '".$amount."', '', 'ccc', '100003', '0', '".$bid."', '7Day')";
		//print_r($SQL);
		global $DB11;$aa = 0; $Output = mysqli_query($DB11, $SQL);
		}
		else{ echo 'user not found.'.$user_login; }
	}
	return $Output;
}




function PendingBetTransfer(){
	
	$SQL="SELECT * FROM `Coinpods_bet` WHERE `created` LIKE '%2024-02-05%' AND `StatusBet` = '0' LIMIT 1000";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;	
}








?>