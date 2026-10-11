<?php





function CreateStake($Q=null){
$Output=0;
if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $UserID=i['id']; }
$Wallets=Wallets();

$ROI=0;
if($Amount>=1000 and $Amount<10000){$ROI=0.10;}
elseif($Amount>=10000 and $Amount<20000){$ROI=0.15;}
elseif($Amount>=20000){$ROI=0.20;}
else{$ROI=0.10;}
	
	

$Period=365;
$Type='Day';
$Status=1;

if($UserID and $Amount and $CCC){ 
if($Wallets[$CCC]>=p2d($Amount)){ 
	
	
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`) VALUES (NULL, 'Stake:".$UserID.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Stake:".$UserID.Clean(GMT())."', '".$UserID."', '', 'RIF', '1', 'Stake', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."');";
	
global $DB;$aa = 0;
$Staked = mysqli_query($DB, $SQL);
	
$Walletss=Wallets();	 $Walletss=$Walletss[strtolower($CCC)]; $Walletss=$Walletss-p2d($Amount);
if($Staked){ 
$SQL1="UPDATE `Coinpods_wallet` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_wallet`.`user` = '".$UserID."';"; unset($Walletss);
global $DB;$aa = 0; $Walleted = mysqli_query($DB, $SQL1);	
}	
	


if($Walleted){
	
	
//#Offer
if($Amount > 0 and $Amount <= 9999){ $Offer = 5; }
else if($Amount >= 10000 and $Amount <= 99999){ $Offer = 10; }
else if($Amount >= 100000 and $Amount <= 499999){ $Offer = 15; }
else if($Amount >= 500000  and $Amount <= 500000000){ $Offer = 20 }
else{ $Offer = 5; }
	
if($Offer){ $Offer = $Amount*$Offer/100; $Amount = $Amount+$Offer; }
//*Offer
	
	$SQL2="INSERT INTO `Coinpods_stake` (`id`, `name`, `created`, `modified`, `amount`, `user`, `ccc`, `roi`, `period`, `ttype`, `status`, `ddd`) VALUES (NULL, '".i['id']."', current_timestamp(), current_timestamp(), '".p2d($Amount)."', '".i['id']."', '".$CCC."', '".$ROI."', '".$Period."', '".$Type."', '1', 'RIF');";
	
global $DB;$aa = 0;
$Output = mysqli_query($DB, $SQL2);
	
}	

}
	
	
}
else{ $echo = 'Not enough sources.'; }
	return $Output;
}





 
function StakingToWallet($Q=null){
//Add Balance to Wallet from Transaction(Buy)
$Output=0;	
$PendingStakingTransactions=PendingStakingTransactions($Q);	
if($PendingStakingTransactions){
foreach($PendingStakingTransactions as $PBT){
	//print_r($PBT['user']);
	if(AddToWallet(array( 'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$PBT['amount'] ))){
		Balance1Transaction($PBT['id']);
	}
	else{ Balance2Transaction($PBT['id']); }
}	
}	
return $Output;
}





	



function Staking($Q=null){
// Need Complete data of a single Stake	
if($Q and is_array($Q)){
	if($Q['status']==1){
	$Staking=$Q['amount']*$Q['roi']/100;
	
	$SQL="UPDATE `Coinpods_stake` SET `staking` = `staking` + ".$Staking.", `updated` = current_timestamp()  WHERE `Coinpods_stake`.`id` = '".$Q['id']."';";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	return true;
	}	
}
}




function StakesToStaking(){
$ab=0;$StakesToStaking=[];
	$Stakes=Stakes();	
	if($Stakes){
		foreach($Stakes as $Stake){				
			if(Staking($Stake)){ $ab++; }			
		}	
	}
	return $ab;	
}

function Stakes($Q=null){
 
	
	if($Q){ $SQL="SELECT * FROM `Coinpods_stake` WHERE `user` = '".$Q."'"; }
	else{ $SQL="SELECT * FROM `Coinpods_stake` ORDER BY `Coinpods_stake`.`id` DESC"; }
	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
 
}



function StakeIncome($Q=null){ 
$Q=i['id'];
// OUTPUT :  
if($Q){	
global $DB;$aa = 0;
	$SQL = "SELECT SUM(staked) FROM `Coinpods_stake` WHERE `user` = '".$Q."';"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){ return $ts[0]['SUM(staked)']; }
}
}


function StakeTotal($Q=null){	
if(i['id']){	

if($Q){ $SQL = "SELECT SUM(amount) FROM `Coinpods_stake` WHERE `user` = '".$Q."';"; }
else{
	if(i['Role']=='Manager'){ $SQL = "SELECT SUM(`amount`) FROM `Coinpods_stake`;"; }
	else{ $Q=i['id']; $SQL = "SELECT SUM(`amount`) FROM `Coinpods_stake` WHERE `user` = '".$Q."';";  }
} 
	
if($SQL){		
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){ return $ts[0]['SUM(`amount`)']; }
}
else{ $echo='Not enough sources.'; }
}
else{ $echo='Login first.'; }
}







function StackCredit($Q=null){
if(i['id']){ // If Logged In

	$II=i(); $WalletBalance=$II['Wallet'];
 
		
	if($WalletBalance){  // If Wallet Balance not zero(0)
	 
		
		
		
	//# ROI	
	if($II['StackUpdated']){$SU = $II['StackUpdated'];} else{$SU = $II['WalletUpdated'];}
	$DF = diff_in_seconds(array( 'start' => $SU, 'end' => GMT() ));
  			
	 
	$life=100; $age=1;		
	if($life > $age){
	// # is Invest EXPIRED	
		
	
		
	//# Is Holiday	
	$holiday=Holiday(); $holiday=0;

	if($holiday){
	//Don't update ROI 
	}
	else
	{
		
		$D2=2222*day;
		$TD=$DF;//TD:Time Diffrance(seconds) = last roi updated to current time
		if($TD>$D2){
			// Time Diffrance is more than 2 days, means may be its holiday(99% chances)
			
	//# Updating ROI DF=DF-HD;		
	$DF=$DF-$D2;
			
	$amount = d2p($t['amount']); $amount = $amount/100;
	$ROI = $t['roi']; $ROI = $ROI/hour;$withdrawable = $ROI*$DF;$wable = $withdrawable;
	$withdrawable = $withdrawable*base;$withdrawable = $withdrawable*$amount;
	$withdrawable = $withdrawable + $t['withdrawable'];
		
	$SET = "`withdrawable` = ".$withdrawable." ,`roi_updated` = '".GMT()."' ,`modified` = '".GMT()."'".$end;			
	$SQL = "UPDATE `transactions` SET ".$SET." WHERE `transactions`.`id` = ".$t['id'];
	$results = mysqli_query($DB, $SQL);$SET=null;
	//* Updating ROI DF=DF-D2;		
	
		
		}
		else{
			// Time Diffrance is not more than 2 days, means no holiday detected
		
		
		
	$amount = d2p($II['Wallet']); $amount = $amount/100;
	$ROI = 2.5; $ROI = $ROI/day;$withdrawable = $ROI*$DF;$wable = $withdrawable;
	$withdrawable = $withdrawable*base;$withdrawable = $withdrawable*$amount;
	$withdrawable = $withdrawable + $II['Stack'];
		
	$SET = "`Stack` = ".$withdrawable." ,`StackUpdated` = '".GMT()."'";			
	$SQL = "UPDATE `".prefix."users` SET ".$SET." WHERE `".prefix."users`.`ID` = ".$II['ID'];
	global $DB; $results = mysqli_query($DB, $SQL);$SET=null;
			
			
		}
	}
	//* Is Holiday	
		
		
		
	// # is Invest EXPIRED		
	}	
	else{ $rrooii = 'ROI Total period expired';}
	//echo number_format(d2p($wable),40);
	//* ROI
		
		
		
		
		
		
	//* is Invest Aproved	
	//}else{ return 'Investment not aproved now till.';}
	}
	}
	
	
	}
//StackCredit();
	





function TotalStake(){
	
	if(i['id']){
		global $DB; $aa = 0;
 		$SQL = "SELECT SUM(Stack) FROM `".prefix."users`";
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(Stack)'];}
 	}
	else{ return 0; }

}




?>