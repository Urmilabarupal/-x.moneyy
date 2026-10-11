<?php

function Slides($Q=null){
//Devloper: Pawan Kumar
//Date: 2023/12/11

	$SQL="SELECT * FROM `Coinpods_slide` WHERE `status` = 1 ORDER BY `Coinpods_slide`.`priority` ASC";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}

	return $ts;	
}











function Sep17_UpdateMasterAndAnotherLeg($Q=null){
if(!$Q){ $Q=i['userid']; }	
$ST = Sep17_StakeTree($Q);
if($ST){

	$MLS=p2d($ST['Legs'][1]['amount']);
	$ALS=p2d($ST['Legs'][2]['amount']);
	$DirectStake=p2d($ST['DirectStake']);
	
$SQL="UPDATE `Coinusers` SET `Sep17_MasterLegStake`='".$MLS."', `Sep17_AnotherLegStake`='".$ALS."', `Sep17_DirectTotalStake`='".$DirectStake."' WHERE `userid`='".$Q."'";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	
	return $ST;
  }
}












function Sep17_2TotalStake($Q=null){
if(is_array($Q)){ $user=$Q['user']; $Amount=$Q['amount']; }	
	if($user and $Amount){
		$SQL="UPDATE `Coinusers` SET `Sep17_TotalStake` = '".$Amount."' WHERE `Coinusers`.`ID` = '".$user."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		return $results;
	}
}





function Sep17_PendingTotalStake(){
$SQL="SELECT SUM(`usdt`) AS `amount`, user FROM `Coinpods_stake` WHERE `name` LIKE 'Stake%' AND `created` > '2023-09-17 00:00:00' GROUP BY `user`;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;	
}


function Sep17_TotalStakes(){	
	$Output=0;
	$PTS=Sep17_PendingTotalStake();
	if($PTS){
		foreach($PTS as $U){
			//print_r($U['ID']);echo '<br>';
			$Sep17_2TotalStake=Sep17_2TotalStake($U);
			if($Sep17_2TotalStake){ $Output++; }
		}
	}
	return $Output;
}








//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







	
function Sep17_TeamStake($Q=null){ 
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
						
				$User=$User['Sep17_TotalStake'];   	
				$B=$B+$User;		
			}						
		}
	}
}
}
	
 
if($B){ /*UpdateTeamStake($B);*/ return $B;}
 	
	
}




































function GlobalTotalStake($Q=null){ 
	
global $DB;$aa = 0;
	$SQL = "SELECT SUM(staked) FROM `Coinpods_stake`"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){ return $ts[0]['SUM(staked)']; }
 
}







function Sep17_TotalStake($Q=null){	
 	

if($Q){ $SQL = "SELECT SUM(`usdt`) FROM `Coinpods_stake` WHERE `user` = '".$Q."' AND `name` LIKE 'Stake%' AND `created` > '2023-09-17 00:00:00';"; }
else{
	if(i['Role']=='Manager'){ $SQL = "SELECT SUM(`usdt`) FROM `Coinpods_stake` AND `name` LIKE 'Stake%' AND `created` > '2023-09-17 00:00:00';"; }
	else{ $Q=i['id']; $SQL = "SELECT SUM(`usdt`) FROM `Coinpods_stake` WHERE `user` = '".$Q."' AND `name` LIKE 'Stake%' AND `created` > '2023-09-17 00:00:00';";  }
} 
	
	
if($SQL){		
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){ return $ts[0]['SUM(`usdt`)']; }
}
else{ $echo='Not enough sources.'; }
 
}

if(i['id']){ Sep17_TotalStake(i['id']); }







function Sep17_UpdateTotalStake($Q=null){
if(!$Q){ $Q=i['id']; }	
	if($Q){print_r($Q);
		$Total=Sep17_TotalStake($Q);
		$SQL="UPDATE `Coinusers` SET `Sep17_TotalStake` = '".$Total."' WHERE `Coinusers`.`ID` = '".$Q."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		return $Total;
	}
}



	
function Sep17_DirectTotalStake($Q=null){ 
//Input : UserID
	
if(i['id']){	
	
if(!$Q){ $Q=i['userid']; }
	$Downline = Downline($Q); $B=0;
	
 	 	
		if($Downline){
			foreach($Downline as $UserID){	
				$UserByUserID = UserByUserID($UserID['userid']);		 		
				
				$User=Sep17_TotalStake($UserByUserID['ID']);   
				$B=$B+$User;				
			}						
		} 	
if($B){ /*UpdateTeamStake($B);*/ return $B; }
}	
	
}



function Sep17_UpdateDirectTotalStake(){
	if(i['id']){
		$Total=Sep17_DirectTotalStake();
	    $SQL="UPDATE `Coinusers` SET `Sep17_DirectTotalStake` = '".$Total."' WHERE `Coinusers`.`ID` = '".i['id']."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		return $Total;
	}
}










function TotalStake15Jan($Q=null){	
if(i['id']){	

if($Q){ $SQL = "SELECT SUM(`amount`) FROM `Coinpods_stake` WHERE `user` = '".$Q."' AND `created` > '2023-01-14 18:30:00';"; }
else{
	if(i['Role']=='Manager'){ $SQL = "SELECT SUM(`amount`) FROM `Coinpods_stake` AND `created` > '2023-01-14 18:30:00';"; }
	else{ $Q=i['id']; $SQL = "SELECT SUM(`amount`) FROM `Coinpods_stake` WHERE `user` = '".$Q."' AND `created` > '2023-01-14 18:30:00';";  }
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


function InsertStake($Q=null){
$Output='';
if(is_array($Q)){ $User=$Q['user']; $Name=$Q['name']; $Amount=$Q['amount']; $CCC=$Q['ccc']; $ROI=$Q['roi']; $Period=$Q['period'];  $Type=$Q['type']; }
if($User and $Name and $Amount and $CCC and $ROI and $Period and $Type){
	
	$SQL="INSERT INTO `Coinpods_stake` (`id`, `name`, `created`, `modified`, `amount`, `user`, `ccc`, `roi`, `period`, `ttype`, `status`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), '".p2d($Amount)."', '".$User."', '".$CCC."', '".$ROI."', '".$Period."', '".$Type."', '1');";
	global $DB;$aa = 0;
	$Output = mysqli_query($DB, $SQL);
}
return $Output;
}



function CreateStake($Q=null){
$InsertID=$AfterBalance=0;
	
	print_r($Q);
if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $UserID=i['id']; $WT=$Q['wt']; }
	
if($WT=='funding'){ 
	$Wallets=Fundings(i['id']); $Name='ReStake';
	
	$ROI=0;
if($Amount>=1000 and $Amount<5000){$ROI=0.068;}
//elseif($Amount>=10000 and $Amount<20000){$ROI=0.15;}
elseif($Amount>=5000){$ROI=0.068;}
else{$ROI=0.068;}


} 
	else{ 
		$Wallets=Wallets(i['id']); $Name="Stake:".$UserID.Clean(GMT());

		
	$ROI=0;
if($Amount>=1000 and $Amount<5000){$ROI=0.068;}
//elseif($Amount>=10000 and $Amount<20000){$ROI=0.15;}
elseif($Amount>=5000){$ROI=0.068;}
else{$ROI=0.068;}

	
	}

	
	

$Period=365;
$Type='Day';
$Status=1;

if($UserID and $Amount and $CCC){ 
if($Wallets[$CCC]>=p2d($Amount)){ 
	
	$AfterBalance=$Wallets[strtolower($CCC)]-p2d($Amount);
	
	
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`,`afterbalance`, `level`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), 'Stake:".$UserID.Clean(GMT())."', '".$UserID."', '', 'REEF', '1', 'Stake', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."','".$AfterBalance."', '0');";
	
 global $DB;$aa = 0; $Staked = mysqli_query($DB, $SQL);
	
if($Staked){ $InsertID=mysqli_insert_id($DB); }	

if($WT=='funding'){ $Walletss=Fundings(i['id']); } else{ $Walletss=Wallets(i['id']); }	
	
	$Walletss=$Walletss[strtolower($CCC)]; $Walletss=$Walletss-p2d($Amount);
if($Staked){ 

if($WT=='funding'){
$SQL1="UPDATE `Coinpods_funding` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_funding`.`user` = '".$UserID."';"; unset($Walletss);
global $DB;$aa = 0; $Walleted = mysqli_query($DB, $SQL1);
}
else{
$SQL1="UPDATE `Coinpods_wallet` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_wallet`.`user` = '".$UserID."';"; unset($Walletss);
global $DB;$aa = 0; $Walleted = mysqli_query($DB, $SQL1);	
}	
}	
	


if($Walleted){

//#Offer
if($Amount >= 1 and $Amount <= 9999){ $Offer = 5; }
else if($Amount >= 10000 and $Amount <= 99999){ $Offer = 10; }
else if($Amount >= 100000 and $Amount <= 499999){ $Offer = 15; }
else if($Amount >= 500000  and $Amount <= 500000000){ $Offer = 20; }
else{ $Offer = 5; }
//if($Offer){ $Offer = $Amount*$Offer/100; $Amount = $Amount+$Offer; }
//*Offer

	$SQL2="INSERT INTO `Coinpods_stake` (`id`, `name`, `created`, `modified`, `amount`, `user`, `ccc`, `roi`, `period`, `ttype`, `status`, `price`, `usdt`, `ddd`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), '".p2d($Amount)."', '".i['id']."', '".$CCC."', '".$ROI."', '".$Period."', '".$Type."', '1', '".Price()."', '".p2d($Amount*Price())."', 'REEF');";
	
global $DB;$aa = 0;
$Output = mysqli_query($DB, $SQL2);
	
}	

}
	
	
}
else{ $echo = 'Not enough sources.'; }
	return $InsertID;
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
		$Amount=$Q['amount']*$Q['roi']/100;
		
		//* Reef Calculation
		$Currency = Currency('REEF');
		$ReefPrice = number_format($Currency['price'],4);
		$REEFperHXC = $Q['price']/$ReefPrice;
		$Staking = $Amount*$REEFperHXC;
		//# Reef Calculation
		
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




function AllStakes($Q=null){
	
	if($Q){ $SQL="SELECT * FROM `Coinpods_stake` WHERE `user` = '".$Q."' ORDER BY `Coinpods_stake`.`id` DESC"; }
	else{ $SQL="SELECT * FROM `Coinpods_stake` WHERE `status` != '' ORDER BY `Coinpods_stake`.`id` DESC"; }
	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
 
}


function Stakes($Q=null){
	
	if($Q){ $SQL="SELECT * FROM `Coinpods_stake` WHERE `status` = '1' AND `user` = '".$Q."'"; }
	else{ $SQL="SELECT * FROM `Coinpods_stake` WHERE `status` = '1' ORDER BY `Coinpods_stake`.`id` DESC"; }
	
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

if($Q){ $SQL = "SELECT SUM(`amount`) FROM `Coinpods_stake` WHERE `user` = '".$Q."';"; }
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
	





function TotalStake($Q=null){ return StakeTotal($Q); }


	
	
function TeamStake($Q=null){ 
//Input : UserID
	
if(i['id']){	
	
if(!$Q){ $Q=i['userid']; }
	
$Downlines = Downlines($Q);

$B=0;
$Users=$Downlines['users'];	 
	
if($Users){	
	foreach($Users as $Level){		
		if($Level){
			foreach($Level as $UserID){	
				
				
				
				global $DB; $aa=0; $SQL = "SELECT `ID` FROM `".prefix."users` WHERE `userid` = '".$UserID."'";
				$results = mysqli_query($DB,$SQL);
				if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
				else{$ts = null;}
				//print_r($ts[0]['ID'].'<br/>');
				
				
				$User=StakeTotal($ts[0]['ID']);   	
				$B=$B+$User;				
			}						
		}
	}
}	
	
	
	
if($B){ /*UpdateTeamStake($B);*/ return $B;}
}	
	
}










	
	
function TeamStake15Jan($Q=null){ 
//Input : UserID
	
 	
	
if(!$Q){ $Q=i['userid']; }
	
$Downlines = Downlines($Q);

$B=0; $J=0;
$Users=$Downlines['users'];	 
	
if($Users){	
	foreach($Users as $Level){		
		if($Level){
			foreach($Level as $UserID){	
				
				
				global $DB; $aa=0; $SQL = "SELECT * FROM `".prefix."users` WHERE `userid` = '".$UserID."'";
				$results = mysqli_query($DB,$SQL);
				if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
				else{ $ts = null; }
				//print_r($ts[0]['ID'].'<br/>');
				
				
				//$Jackpots = Jackpots( array( 'user'=>$ts[0]['ID'] ) ); $Jackpot = $Jackpots[0];
				$Jackpot=$ts[0]['jackpotactive'];
				if($Jackpot!=0){ $J++; }
				unset($Jackpot);
				
				
				
				
				
				
				$User=TotalStake15Jan($ts[0]['ID']);   	
				$B=$B+$User;				
			}						
		}
	}
}	
	
	
$Output = array( 'TotalTeamStake'=>$B, 'TotalTeamJackpot'=>$J ); 
	
if($Output){ /*UpdateTeamStake($B);*/ return $Output;}
}	
 


?>