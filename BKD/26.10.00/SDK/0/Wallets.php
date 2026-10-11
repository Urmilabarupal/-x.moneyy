<?php


function RemoveFromStaking_Wallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_staking_wallet` SET `".$ccc."` = `".$ccc."` - '".$amount."'  WHERE `Coinpods_staking_wallet`.`user` = '".$user."';"; //echo $SQL;
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
}	
}


 
function AddToStaking_Wallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
$MW=Staking_Wallets($user);	
	
if($MW){	
if($user and $ccc and $amount){	
	
$SQL="UPDATE `Coinpods_staking_wallet` SET `".$ccc."` = `".$ccc."` + '".$amount."' WHERE `Coinpods_staking_wallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	 //echo $SQL;
	return $Output;	
}	
}
}



function CreateStaking_Wallet($Q=null){
$Output='';
	if($Q){
		
		$echo = 'Q Data Found';
		$User=user($Q);
		if($User){
		$echo = 'User Found';
			
		$Fundings=Staking_Wallets($Q);
		if(!$Fundings){
		$echo ='Inserting Funding';
			
			
			$SQL="INSERT INTO `Coinpods_staking_wallet` (`id`, `user`, `name`, `created`, `modified`, `ccc`, `inr`, `eth`, `trx`, `usdt`, `busd`, `bnb`, `btc`) VALUES (NULL, '".$User['ID']."', '".$User['ID']."', current_timestamp(), current_timestamp(), '0', '0', '0', '0', '0', '0', '0', '0');";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	//echo $SQL;
			
			
			if($results){				
				$SQL1="UPDATE `Coinusers` SET `staking_wallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
				global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);		
				$echo = 'All Done';
				
			}
			
			
			
		}
		else{ 
			//print_r($Fundings);
			$SQL1="UPDATE `Coinusers` SET `staking_wallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);			
			$echo = 'Already wallet availble.';
		}
		}
		else{ $echo = 'Wrong user ID.'; }
	}	
	else{ $echo = 'Q Data Not Found.'; }
	//return $echo;
}




function PendingStaking_Wallets(){

	$SQL="SELECT * FROM `Coinusers` WHERE `staking_wallet` = 0 LIMIT 300";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function CreateStaking_Wallets(){
	$aa=0;
	$PendingFundings=PendingStaking_Wallets();	 
	if($PendingFundings){ 
		foreach($PendingFundings as $PW){ $aa++;
			 CreateStaking_Wallet($PW['ID']);		
		}		
	}	
	//echo $aa;
}



function Staking_Wallets($Q=null){
if($Q){$SQL="SELECT * FROM `Coinpods_staking_wallet` WHERE `user` = '".$Q."'"; }
else{ $SQL="SELECT * FROM `Coinpods_staking_wallet` WHERE `user` = '".i['id']."'"; }

	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	

if($ts){$Fundings=$ts[0];
	
$aa=0;$Portfolio=0;
foreach($Fundings as $Funding){ $aa++; if($aa>4){ $Portfolio=$Portfolio+$Funding; } }
$Fundings['Total']=$Portfolio;
$Fundings['Portfolio']=$Portfolio;
	}	
 return $Fundings;

}

$Staking_Wallets=Staking_Wallets();
define('Staking_Wallets',$Staking_Wallets);


 



function TotalStaking_Wallet($Q=null){
if($Q){  $Q=strtolower($Q); } else{ $Q='ccc';}
	
	if(i['id']){		
		$SQL="SELECT SUM(`".$Q."`) FROM `".prefix."pods_staking_wallet`";
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(`'.$Q.'`)'];}
 	}
	else{ return 0; }

}




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function RemoveFromMainWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_main_wallet` SET `".$ccc."` = `".$ccc."` - '".$amount."'  WHERE `Coinpods_main_wallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
}	
}



 
function AddToMainWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_main_wallet` SET `".$ccc."` = `".$ccc."` + '".$amount."'  WHERE `Coinpods_main_wallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
}	
}



function CreateMainWallet($Q=null){
$Output='';
	if($Q){
		
		$echo = 'Q Data Found';
		$User=user($Q);
		if($User){
			$echo = 'User Found';
			
		$Fundings=MainWallets($Q);
		if(!$Fundings){
			$echo ='Inserting Funding';
			
			
			$SQL="INSERT INTO `Coinpods_main_wallet` (`id`, `user`, `name`, `created`, `modified`, `ccc`, `inr`, `eth`, `trx`, `usdt`, `busd`, `bnb`, `btc`, `reef`, `hxs`) VALUES (NULL, '".$User['ID']."', '".$User['ID']."', current_timestamp(), current_timestamp(), '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');"; //echo $SQL;
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
			
			
			if($results){				
				$SQL1="UPDATE `Coinusers` SET `MainWallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
				global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);		
				$echo = 'All Done';
				
			}
			
			
			
		}
		else{ 
			//print_r($Fundings);
			$SQL1="UPDATE `Coinusers` SET `MainWallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);			
			$echo = 'Already wallet availble.';
		}
		}
		else{ $echo = 'Wrong user ID.'; }
	}	
	else{ $echo = 'Q Data Not Found.'; }
	//return $echo;
}




function PendingMainWallets(){

	$SQL="SELECT * FROM `Coinusers` WHERE `MainWallet` = 0 LIMIT 10000";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function CreateMainWallets(){
	$aa=0;
	$PendingFundings=PendingMainWallets();	 
	if($PendingFundings){
		foreach($PendingFundings as $PW){ $aa++;
			 CreateMainWallet($PW['ID']);		
		}		
	}	
	//echo $aa;
}









function MainWallets($Q=null){
if($Q){$SQL="SELECT * FROM `Coinpods_main_wallet` WHERE `user` = '".$Q."'"; }
else{ $SQL="SELECT * FROM `Coinpods_main_wallet` WHERE `user` = '".i['id']."'"; }

	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	

if($ts){$Fundings=$ts[0];
	
$aa=0;$Portfolio=0;
foreach($Fundings as $Funding){ $aa++; if($aa>4){ $Portfolio=$Portfolio+$Funding; } }
$Fundings['Total']=$Portfolio;
$Fundings['Portfolio']=$Portfolio;
	}	
 return $Fundings;

}







 




 



function TotalMainWallet($Q=null){
if($Q){  $Q=strtolower($Q); } else{ $Q='ccc';}
	
	if(i['id']){		
		$SQL="SELECT SUM(`".$Q."`) FROM `".prefix."pods_main_wallet`"; 
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(`'.$Q.'`)'];}
 	}
	else{ return 0; }

}










//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




function RemoveFromExtraWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_extra_wallet` SET `".$ccc."` = `".$ccc."` - '".$amount."'  WHERE `Coinpods_extra_wallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
}	
}



 
function AddToExtraWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_extra_wallet` SET `".$ccc."` = `".$ccc."` + '".$amount."'  WHERE `Coinpods_extra_wallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
	//echo $SQL;
}	
}



function CreateExtraWallet($Q=null){
$Output='';
	if($Q){
		
		$echo = 'Q Data Found';
		$User=user($Q);
		if($User){
			$echo = 'User Found';
			
		$Fundings=ExtraWallets($Q);
		if(!$Fundings){
			$echo ='Inserting Funding';
			
			
			$SQL="INSERT INTO `Coinpods_extra_wallet` (`id`, `user`, `name`, `created`, `modified`, `ccc`, `inr`, `eth`, `trx`, `usdt`, `busd`, `bnb`, `btc`, `reef`, `hxs`, `spot_wallet`, `funding_wallet`, `mine_wallet`, `slot_wallet`) VALUES (NULL, '".$User['ID']."', '".$User['ID']."', current_timestamp(), current_timestamp(), '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
			
			//echo $SQL;
			if($results){				
				$SQL1="UPDATE `Coinusers` SET `ExtraWallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
				global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);		
				$echo = 'All Done';
				
			}
			
			
			
		}
		else{ 
			//print_r($Fundings);
			$SQL1="UPDATE `Coinusers` SET `ExtraWallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);			
			$echo = 'Already wallet availble.';
		}
		}
		else{ $echo = 'Wrong user ID.'; }
	}	
	else{ $echo = 'Q Data Not Found.'; }
	//return $echo;
}




function PendingExtraWallets(){

	$SQL="SELECT * FROM `Coinusers` WHERE `ExtraWallet` = 0 LIMIT 1000";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function CreateExtraWallets(){
	
	$aa=0;
	$PendingFundings=PendingExtraWallets();	  //print_r($PendingFundings);
	if($PendingFundings){
		foreach($PendingFundings as $PW){ $aa++;
			 CreateExtraWallet($PW['ID']);		
		}		
	}	
	//echo $aa;
}









function ExtraWallets($Q=null){
if($Q){$SQL="SELECT * FROM `Coinpods_extra_wallet` WHERE `user` = '".$Q."'"; }
else{ $SQL="SELECT * FROM `Coinpods_extra_wallet` WHERE `user` = '".i['id']."'"; }

	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	

if($ts){$Fundings=$ts[0];
	
$aa=0;$Portfolio=0;
foreach($Fundings as $Funding){ $aa++; if($aa>4){ $Portfolio=$Portfolio+$Funding; } }
$Fundings['Total']=$Portfolio;
$Fundings['Portfolio']=$Portfolio;
	}	
 return $Fundings;

}






 




 



function TotalExtraWallet($Q=null){
if($Q){  $Q=strtolower($Q); } else{ $Q='ccc';}
	
	if(i['id']){		
		$SQL="SELECT SUM(`".$Q."`) FROM `".prefix."pods_extra_wallet`"; 
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(`'.$Q.'`)'];}
 	}
	else{ return 0; }

}










//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function RemoveFromJackpotWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_jackpotwallet` SET `".$ccc."` = `".$ccc."` - '".$amount."'  WHERE `Coinpods_jackpotwallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
}	
}



 
function AddToJackpotWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_jackpotwallet` SET `".$ccc."` = `".$ccc."` + '".$amount."'  WHERE `Coinpods_jackpotwallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
}	
}



function CreateJackpotWallet($Q=null){
$Output='';
	if($Q){
		
		$echo = 'Q Data Found';
		$User=user($Q);
		if($User){
			$echo = 'User Found';
			
		$Fundings=JackpotWallets($Q);
		if(!$Fundings){
			$echo ='Inserting Funding';
			
			
			$SQL="INSERT INTO `Coinpods_jackpotwallet` (`id`, `user`, `name`, `created`, `modified`, `ccc`, `inr`, `eth`, `trx`, `usdt`, `busd`, `bnb`, `btc`) VALUES (NULL, '".$User['ID']."', '0', current_timestamp(), current_timestamp(), '0', '0', '0', '0', '0', '0', '0', '0');";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
			
			
			if($results){				
				$SQL1="UPDATE `Coinusers` SET `JackpotWallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
				global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);		
				$echo = 'All Done';
				
			}
			
			
			
		}
		else{ 
			//print_r($Fundings);
			$SQL1="UPDATE `Coinusers` SET `JackpotWallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);			
			$echo = 'Already wallet availble.';
		}
		}
		else{ $echo = 'Wrong user ID.'; }
	}	
	else{ $echo = 'Q Data Not Found.'; }
	//return $echo;
}




function PendingJackpotWallets(){

	$SQL="SELECT * FROM `Coinusers` WHERE `JackpotWallet` = 0 LIMIT 111111";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function CreateJackpotWallets(){
	$aa=0;
	$PendingFundings=PendingJackpotWallets();	 
	if($PendingFundings){
		foreach($PendingFundings as $PW){ $aa++;
			 CreateJackpotWallet($PW['ID']);		
		}		
	}	
	//echo $aa;
}









function JackpotWallets($Q=null){
if($Q){$SQL="SELECT * FROM `Coinpods_jackpotwallet` WHERE `user` = '".$Q."'"; }
else{ $SQL="SELECT * FROM `Coinpods_jackpotwallet` WHERE `user` = '".i['id']."'"; }

	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	

if($ts){$Fundings=$ts[0];
	
$aa=0;$Portfolio=0;
foreach($Fundings as $Funding){ $aa++; if($aa>4){ $Portfolio=$Portfolio+$Funding; } }
$Fundings['Total']=$Portfolio;
$Fundings['Portfolio']=$Portfolio;
	}	
 return $Fundings;

}

$JackpotWallets=JackpotWallets();
define('JackpotWallets',$JackpotWallets);





 




 



function TotalJackpotWallet($Q=null){
if($Q){  $Q=strtolower($Q); } else{ $Q='ccc';}
	
	if(i['id']){		
		$SQL="SELECT SUM(`".$Q."`) FROM `".prefix."pods_jackpotwallet`";
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(`'.$Q.'`)'];}
 	}
	else{ return 0; }

}







////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







function RemoveFromUnstakeWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_unstakewallet` SET `".$ccc."` = `".$ccc."` - '".$amount."'  WHERE `Coinpods_unstakewallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
}	
}



 
function AddToUnstakeWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_unstakewallet` SET `".$ccc."` = `".$ccc."` + '".$amount."'  WHERE `Coinpods_unstakewallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
}	
}



function CreateUnstakeWallet($Q=null){
$Output='';
	if($Q){
		
		$echo = 'Q Data Found';
		$User=user($Q);
		if($User){
			$echo = 'User Found';
			
		$Fundings=UnstakeWallets($Q);
		if(!$Fundings){
			$echo ='Inserting Funding';
			
			
			$SQL="INSERT INTO `Coinpods_unstakewallet` (`id`, `user`, `name`, `created`, `modified`, `ccc`, `inr`, `eth`, `trx`, `usdt`, `busd`, `bnb`, `btc`) VALUES (NULL, '".$User['ID']."', '".$User['ID']."', current_timestamp(), current_timestamp(), '0', '0', '0', '0', '0', '0', '0', '0');";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
			
			
			if($results){				
				$SQL1="UPDATE `Coinusers` SET `UnstakeWallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
				global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);		
				$echo = 'All Done';
				
			}
			
			
			
		}
		else{ 
			//print_r($Fundings);
			$SQL1="UPDATE `Coinusers` SET `UnstakeWallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);			
			$echo = 'Already wallet availble.';
		}
		}
		else{ $echo = 'Wrong user ID.'; }
	}	
	else{ $echo = 'Q Data Not Found.'; }
	//return $echo;
}




function PendingUnstakeWallets(){

	$SQL="SELECT * FROM `Coinusers` WHERE `UnstakeWallet` = 0 LIMIT 111111";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function CreateUnstakeWallets(){
	$aa=0;
	$PendingFundings=PendingUnstakeWallets();	 
	if($PendingFundings){
		foreach($PendingFundings as $PW){ $aa++;
			 CreateUnstakeWallet($PW['ID']);		
		}		
	}	
	//echo $aa;
}









function UnstakeWallets($Q=null){
if($Q){$SQL="SELECT * FROM `Coinpods_unstakewallet` WHERE `user` = '".$Q."'"; }
else{ $SQL="SELECT * FROM `Coinpods_unstakewallet` WHERE `user` = '".i['id']."'"; }

	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	

if($ts){$Fundings=$ts[0];
	
$aa=0;$Portfolio=0;
foreach($Fundings as $Funding){ $aa++; if($aa>4){ $Portfolio=$Portfolio+$Funding; } }
$Fundings['Total']=$Portfolio;
$Fundings['Portfolio']=$Portfolio;
	}	
 return $Fundings;

}

$UnstakeWallets=UnstakeWallets();
define('UnstakeWallets',$UnstakeWallets);





 




 



function TotalUnstakeWallet($Q=null){
if($Q){  $Q=strtolower($Q); } else{ $Q='ccc';}
	
	if(i['id']){		
		$SQL="SELECT SUM(`".$Q."`) FROM `".prefix."pods_Coinpods_unstakewallet`";
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(`'.$Q.'`)'];}
 	}
	else{ return 0; }

}

















////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






function RemoveFromSlotWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_slotwallet` SET `".$ccc."` = `".$ccc."` - '".$amount."'  WHERE `Coinpods_slotwallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
}	
}



 
function AddToSlotWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_slotwallet` SET `".$ccc."` = `".$ccc."` + '".$amount."'  WHERE `Coinpods_slotwallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
}	
}



function CreateSlotWallet($Q=null){
$Output='';
	if($Q){
		
		$echo = 'Q Data Found';
		$User=user($Q);
		if($User){
			$echo = 'User Found';
			
		$Fundings=SlotWallets($Q);
		if(!$Fundings){
			$echo ='Inserting Funding';
			
			
			$SQL="INSERT INTO `Coinpods_slotwallet` (`id`, `user`, `name`, `created`, `modified`, `ccc`, `inr`, `eth`, `trx`, `usdt`, `busd`, `bnb`, `btc`) VALUES (NULL, '".$User['ID']."', '".$User['ID']."', current_timestamp(), current_timestamp(), '0', '0', '0', '0', '0', '0', '0', '0');";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
			
			
			if($results){				
				$SQL1="UPDATE `Coinusers` SET `SlotWallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
				global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);		
				$echo = 'All Done';
				
			}
			
			
			
		}
		else{ 
			//print_r($Fundings);
			$SQL1="UPDATE `Coinusers` SET `SlotWallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);			
			$echo = 'Already wallet availble.';
		}
		}
		else{ $echo = 'Wrong user ID.'; }
	}	
	else{ $echo = 'Q Data Not Found.'; }
	//return $echo;
}




function PendingSlotWallets(){

	$SQL="SELECT * FROM `Coinusers` WHERE `SlotWallet` = 0 LIMIT 111111";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function CreateSlotWallets(){
	$aa=0;
	$PendingFundings=PendingSlotWallets();	 
	if($PendingFundings){
		foreach($PendingFundings as $PW){ $aa++;
			 CreateSlotWallet($PW['ID']);		
		}		
	}	
	//echo $aa;
}









function SlotWallets($Q=null){
if($Q){$SQL="SELECT * FROM `Coinpods_slotwallet` WHERE `user` = '".$Q."'"; }
else{ $SQL="SELECT * FROM `Coinpods_slotwallet` WHERE `user` = '".i['id']."'"; }

	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	

if($ts){$Fundings=$ts[0];
	
$aa=0;$Portfolio=0;
foreach($Fundings as $Funding){ $aa++; if($aa>4){ $Portfolio=$Portfolio+$Funding; } }
$Fundings['Total']=$Portfolio;
$Fundings['Portfolio']=$Portfolio;
	}	
 return $Fundings;

}

$SlotWallets=SlotWallets();
define('SlotWallets',$SlotWallets);





 




 



function TotalSlotWallet($Q=null){
if($Q){  $Q=strtolower($Q); } else{ $Q='ccc';}
	
	if(i['id']){		
		$SQL="SELECT SUM(`".$Q."`) FROM `".prefix."pods_slotwallet`";
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(`'.$Q.'`)'];}
 	}
	else{ return 0; }

}





//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 

 
function RemoveFromMineWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_minewallet` SET `".$ccc."` = `".$ccc."` - '".$amount."'  WHERE `Coinpods_minewallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
}	
}



 
function AddToMineWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
$MW=MineWallets($user);	
	
if($MW){	
if($user and $ccc and $amount){	
	
$SQL="UPDATE `Coinpods_minewallet` SET `".$ccc."` = `".$ccc."` + '".$amount."'  WHERE `Coinpods_minewallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return $Output;	
}	
}
}



function CreateMineWallet($Q=null){
$Output='';
	if($Q){
		
		$echo = 'Q Data Found';
		$User=user($Q);
		if($User){
			$echo = 'User Found';
			
		$Fundings=MineWallets($Q);
		if(!$Fundings){
			$echo ='Inserting Funding';
			
			
			$SQL="INSERT INTO `Coinpods_minewallet` (`id`, `user`, `name`, `created`, `modified`, `ccc`, `inr`, `eth`, `trx`, `usdt`, `busd`, `bnb`, `btc`) VALUES (NULL, '".$User['ID']."', '".$User['ID']."', current_timestamp(), current_timestamp(), '0', '0', '0', '0', '0', '0', '0', '0');";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
			
			
			if($results){				
				$SQL1="UPDATE `Coinusers` SET `MineWallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
				global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);		
				$echo = 'All Done';
				
			}
			
			
			
		}
		else{ 
			//print_r($Fundings);
			$SQL1="UPDATE `Coinusers` SET `MineWallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);			
			$echo = 'Already wallet availble.';
		}
		}
		else{ $echo = 'Wrong user ID.'; }
	}	
	else{ $echo = 'Q Data Not Found.'; }
	//return $echo;
}




function PendingMineWallets(){

	$SQL="SELECT * FROM `Coinusers` WHERE `MineWallet` = 0 LIMIT 11111";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function CreateMineWallets(){
	$aa=0;
	$PendingFundings=PendingMineWallets();	 
	if($PendingFundings){
		foreach($PendingFundings as $PW){ $aa++;
			 CreateMineWallet($PW['ID']);		
		}		
	}	
	//echo $aa;
}









function MineWallets($Q=null){
if($Q){$SQL="SELECT * FROM `Coinpods_minewallet` WHERE `user` = '".$Q."'"; }
else{ $SQL="SELECT * FROM `Coinpods_minewallet` WHERE `user` = '".i['id']."'"; }

	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	

if($ts){$Fundings=$ts[0];
	
$aa=0;$Portfolio=0;
foreach($Fundings as $Funding){ $aa++; if($aa>4){ $Portfolio=$Portfolio+$Funding; } }
$Fundings['Total']=$Portfolio;
$Fundings['Portfolio']=$Portfolio;
	}	
 return $Fundings;

}

$MineWallets=MineWallets();
define('MineWallets',$MineWallets);





 




 



function TotalMineWallet($Q=null){
if($Q){  $Q=strtolower($Q); } else{ $Q='ccc';}
	
	if(i['id']){		
		$SQL="SELECT SUM(`".$Q."`) FROM `".prefix."pods_minewallet`";
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(`'.$Q.'`)'];}
 	}
	else{ return 0; }

}





//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
function RemoveFromFunding($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_funding` SET `".$ccc."` = `".$ccc."` - '".$amount."'  WHERE `Coinpods_funding`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);
	//echo $SQL.'<br>';
	return true;	
}	
}



 
function AddToFunding($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_funding` SET `".$ccc."` = `".$ccc."` + '".$amount."'  WHERE `Coinpods_funding`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
}	
}



function CreateFunding($Q=null){
$Output='';
	if($Q){
		
		$echo = 'Q Data Found';
		$User=user($Q);
		if($User){
			$echo = 'User Found';
			
		$Fundings=Fundings($Q);
		if(!$Fundings){
			$echo ='Inserting Funding';
			
			
			$SQL="INSERT INTO `Coinpods_funding` (`id`, `user`, `name`, `created`, `modified`, `ccc`, `inr`, `eth`, `trx`, `usdt`, `busd`, `bnb`, `btc`) VALUES (NULL, '".$User['ID']."', '".$User['ID']."', current_timestamp(), current_timestamp(), '0', '0', '0', '0', '0', '0', '0', '0');";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
			
			
			if($results){				
				$SQL1="UPDATE `Coinusers` SET `Funding` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
				global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);		
				$echo = 'All Done';
				
			}
			
			
			
		}
		else{ 
			//print_r($Fundings);
			$SQL1="UPDATE `Coinusers` SET `Funding` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);			
			$echo = 'Already wallet availble.';
		}
		}
		else{ $echo = 'Wrong user ID.'; }
	}	
	else{ $echo = 'Q Data Not Found.'; }
	//return $echo;
}




function PendingFundings(){

	$SQL="SELECT * FROM `Coinusers` WHERE `Funding` = 0 LIMIT 99999";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function CreateFundings(){
	$aa=0;
	$PendingFundings=PendingFundings();	 
	if($PendingFundings){
		foreach($PendingFundings as $PW){ $aa++;
			 CreateFunding($PW['ID']);		
		}		
	}	
	//echo $aa;
}









function Fundings($Q=null){
if($Q){$SQL="SELECT * FROM `Coinpods_funding` WHERE `user` = '".$Q."'"; }
else{ $SQL="SELECT * FROM `Coinpods_funding` WHERE `user` = '".i['id']."'"; }

	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	

if($ts){$Fundings=$ts[0];
	
$aa=0;$Portfolio=0;
foreach($Fundings as $Funding){ $aa++; if($aa>4){ $Portfolio=$Portfolio+$Funding; } }
$Fundings['Total']=$Portfolio;
$Fundings['Portfolio']=$Portfolio;
	}	
 return $Fundings;

}





 




 



function TotalFunding($Q=null){
if($Q){  $Q=strtolower($Q); } else{ $Q='ccc';}
	
	if(i['id']){		
		$SQL="SELECT SUM(`".$Q."`) FROM `".prefix."pods_funding`";
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(`'.$Q.'`)'];}
 	}
	else{ return 0; }

}




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



 
function RemoveFromWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_wallet` SET `".$ccc."` = `".$ccc."` - '".$amount."'  WHERE `Coinpods_wallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
}	
}



 
function AddToWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
if($user and $ccc and $amount){	
$SQL="UPDATE `Coinpods_wallet` SET `".$ccc."` = `".$ccc."` + '".$amount."'  , `modified` = '".gmdate('Y-m-d H:i:s')."' WHERE `Coinpods_wallet`.`user` = '".$user."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;	
}	
}



function CreateWallet($Q=null){
$Output='';
	if($Q){
		$User=user($Q);
		if($User){
		$Wallets=Wallets($Q);
		if(!$Wallets){
			$SQL="INSERT INTO `Coinpods_wallet` (`id`, `user`, `name`, `created`, `modified`, `ccc`, `inr`, `eth`, `trx`, `usdt`, `busd`, `bnb`, `btc`) VALUES (NULL, '".$User['ID']."', '".$User['ID']."', current_timestamp(), current_timestamp(), '0', '0', '0', '0', '0', '0', '0', '0');";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
			
			
			if($results){				
				$SQL1="UPDATE `Coinusers` SET `Wallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
				global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);				
				
			}
			
		}
		else{ 
			//print_r($Wallets);
			$SQL1="UPDATE `Coinusers` SET `Wallet` = '1' WHERE `Coinusers`.`ID` = '".$User['ID']."'";
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);			
			$echo = 'Already wallet availble.';
		}
		}
		else{ $echo = 'Wrong user ID.'; }
	}	
}



function CreateWallets(){
	$aa=0;
	$PendingWallets=PendingWallets();	 
	if($PendingWallets){
		foreach($PendingWallets as $PW){ $aa++;
			CreateWallet($PW['ID']);		
		}		
	}	
	 
}



function PendingWallets(){

	$SQL="SELECT * FROM `Coinusers` WHERE `Wallet` = 0";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}








function Wallets($Q=null){
 
	
if($Q){$SQL="SELECT * FROM `Coinpods_wallet` WHERE `user` = '".$Q."'"; }
else{ $SQL="SELECT * FROM `Coinpods_wallet` WHERE `user` = '".i['id']."'"; }
 
	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
 
if($ts){$Wallets=$ts[0];
	
$aa=0;$Portfolio=0;
foreach($Wallets as $Wallet){ $aa++; if($aa>4){ $Portfolio=$Portfolio+$Wallet; } }
$Wallets['Total']=$Portfolio;
$Wallets['Portfolio']=$Portfolio;
	}	
 return $Wallets;

}






function WalletBalance($Q=null){
// OUTPUT : ALL Messages's data from DB by User ID($Q)


if(i['id']){
global $DB;$aa = 0;$LIMIT=111;
	if(iam['admin'] and !PP){$SQL = "SELECT * FROM `Coinpods_messages` ORDER BY `Coinpods_messages`.`modified` DESC LIMIT ".$LIMIT; }
	else{$SQL = "SELECT `Wallet` FROM `Coinusers` WHERE `ID` = ".i['id']; }
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0]['Wallet'];
	}
}




function balance($c=null,$h=null){ 
// OUTPUT : total of aproved(invest + refer earning + withdrawable from invest)
// INPUT : Currency in main variable
 	if(i['id']){		
		return i['Wallet']+i['Current']+i['Stack']+i['Refer'];		
	}
	else{ return 0; }
}




function TotalWallet($Q=null){
if($Q){  $Q=strtolower($Q); } else{ $Q='ccc';}
	
	if(i['id']){		
		$SQL="SELECT SUM(`".$Q."`) FROM `".prefix."pods_wallet`";
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(`'.$Q.'`)'];}
 	}
	else{ return 0; }

}



 


?>