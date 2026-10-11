<?php
 











function PendingMiningTransactions($Q=null){
	
if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Mining'"; }
else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'Mining' LIMIT 11"; }

global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function MiningToTransaction($Q=null){
	
	$BeforeBalance=$AfterBalance=0;
	if($Q){
		
//if(AddToWallet(array( 'user'=>$Q['user'], 'ccc'=>strtolower($Q['ccc']), 'amount'=>$Q['amount'] )))
		
if($Q['staking']){
	
	$Fundings=Fundings($Q['user']);
	$BeforeBalance=$Fundings['ccc'];
	$AfterBalance=$BeforeBalance+$Q['staking'];
	
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`) VALUES (NULL, 'Mining : ".$Q['id']." : ".GMT()."', current_timestamp(), current_timestamp(), 'Staking".$Q['id']."at".Clean(GMT())."', '".$Q['user']."', '', '', '0', 'Mining', '".$Q['staking']."', '".strtolower($Q['ccc'])."', '".$BeforeBalance."', '".$AfterBalance."');";
		
global $DB;	$Output = mysqli_query($DB, $SQL);	
	
	if($Output){ 
		$SQL2="UPDATE `Coinpods_mine` SET `staked` = `staked` + `staking`, `staking` = 0 WHERE `Coinpods_mine`.`id` = '".$Q['id']."';";	
		global $DB;	$Output = mysqli_query($DB, $SQL2);	
		return $Output;
	}
	}		
} 	
}

function MiningToTransactions(){

	$SQL="SELECT * FROM `Coinpods_mine` WHERE `status` = 1 AND `staking` > 0 ORDER BY `Coinpods_mine`.`updated` ASC LIMIT 11";	
	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	
	if($ts){
		foreach($ts as $t){
			MiningToTransaction($t);
			
		}	
	}	
}







function GlobalTotalMine($Q=null){ 
	
global $DB;$aa = 0;
	$SQL = "SELECT SUM(staked) FROM `Coinpods_mine`"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){ return $ts[0]['SUM(staked)']; }
 
}





 


 







 

function InsertMine($Q=null){
$Output='';
if(is_array($Q)){ $User=$Q['user']; $Name=$Q['name']; $Amount=$Q['amount']; $CCC=$Q['ccc']; $ROI=$Q['roi']; $Period=$Q['period'];  $Type=$Q['type']; }
if($User and $Name and $Amount and $CCC and $ROI and $Period and $Type){
	
	$SQL="INSERT INTO `Coinpods_mine` (`id`, `name`, `created`, `modified`, `amount`, `user`, `ccc`, `roi`, `period`, `ttype`, `status`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), '".p2d($Amount)."', '".$User."', '".$CCC."', '".$ROI."', '".$Period."', '".$Type."', '1');";
	global $DB;$aa = 0;
	$Output = mysqli_query($DB, $SQL);
}
return $Output;
}









function CreateMine($Q=null){
$InsertID=0;
if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $UserID=i['id']; $WT=$Q['wt']; }
	

if($WT=='MineWallet'){ 
	$Wallets=MineWallets(i['id']); 
	$Name='ReStake';
	
	$ROI=0;
if($Amount>=1000 and $Amount<10000){$ROI=0.10;}
//elseif($Amount>=10000 and $Amount<20000){$ROI=0.15;}
elseif($Amount>=10000){$ROI=0.10;}
else{$ROI=0.10;}


} 
	else{ 
		$Wallets=Wallets(i['id']);
		$Name="Mining:".$UserID.Clean(GMT());

		
	$ROI=0;
if($Amount>=1000 and $Amount<10000){$ROI=0.10;}
//elseif($Amount>=10000 and $Amount<20000){$ROI=0.15;}
elseif($Amount>=10000){$ROI=0.10;}
else{$ROI=0.10;}

	
	}

	
	

$Period=365;
$Type='Day';
$Status=1;

if($UserID and $Amount and $CCC){ 
if($Wallets[$CCC]>=p2d($Amount)){ 
	
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `level`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), 'Stake:".$UserID.Clean(GMT())."', '".$UserID."', '', '', '1', 'Mine', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '0');";
	
global $DB;$aa = 0;
$Staked = mysqli_query($DB, $SQL);
	
if($Staked){ $InsertID=mysqli_insert_id($DB); }	

if($WT=='MineWallet'){ $Walletss=MineWallets(i['id']); } else{ $Walletss=Wallets(i['id']); }	
	
	$Walletss=$Walletss[strtolower($CCC)]; $Walletss=$Walletss-p2d($Amount);
if($Staked){ 

if($WT=='MineWallet'){
$SQL1="UPDATE `Coinpods_minewallet` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_minewallet`.`user` = '".$UserID."';"; unset($Walletss);
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

	$SQL2="INSERT INTO `Coinpods_mine` (`id`, `name`, `created`, `modified`, `amount`, `user`, `ccc`, `roi`, `period`, `ttype`, `status`, `price`, `usdt`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), '".p2d($Amount)."', '".i['id']."', '".$CCC."', '".$ROI."', '".$Period."', '".$Type."', '1', '".Price()."', '".p2d($Amount*Price())."');";
	
global $DB;$aa = 0;
$Output = mysqli_query($DB, $SQL2);
	
}	

}
	
	
}
else{ $echo = 'Not enough sources.'; }
	return $InsertID;
}





function MiningToWallet($Q=null){
//Add Balance to Wallet from Transaction(Buy)
$Output=0;	
$PendingStakingTransactions=PendingMiningTransactions($Q);	
if($PendingStakingTransactions){
foreach($PendingStakingTransactions as $PBT){
	//print_r($PBT['user']);
	if(AddToFunding(array( 'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$PBT['amount'] ))){
		Balance1Transaction($PBT['id']);
		$Output++;
	}
	else{ Balance2Transaction($PBT['id']); }
}	
}	
return $Output;
}





	



function Mining($Q=null){
// Need Complete data of a single Stake	
if($Q and is_array($Q)){
	if($Q['status']==1){
	$Staking=$Q['amount']*$Q['roi']/100;
	
	$SQL="UPDATE `Coinpods_mine` SET `staking` = `staking` + ".$Staking.", `updated` = current_timestamp()  WHERE `Coinpods_mine`.`id` = '".$Q['id']."';";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	return true;
	}	
}
}




function MineToMining(){
$ab=0;$StakesToStaking=[];
	$Stakes=Mines();	
	if($Stakes){
		foreach($Stakes as $Stake){				
			if(Mining($Stake)){ $ab++; }			
		}	
	}
	return $ab;	
}

function Mine($Q=null){
if($Q){ 
  $SQL="SELECT * FROM `Coinpods_mine` WHERE `id` = '".$Q."' LIMIT 1";  
	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0];		
}
}

function Mines($Q=null){
 
	
	if($Q){ $SQL="SELECT * FROM `Coinpods_mine` WHERE `user` = '".$Q."'"; }
	else{ $SQL="SELECT * FROM `Coinpods_mine` ORDER BY `Coinpods_mine`.`id` DESC"; }
	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
 
}



function MineIncome($Q=null){ 
$Q=i['id'];
// OUTPUT :  
if($Q){	
global $DB;$aa = 0;
	$SQL = "SELECT SUM(staked) FROM `Coinpods_mine` WHERE `user` = '".$Q."';"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){ return $ts[0]['SUM(staked)']; }
}
}


function MineTotal($Q=null){	
if(i['id']){	

if($Q){ $SQL = "SELECT SUM(`amount`) FROM `Coinpods_mine` WHERE `user` = '".$Q."';"; }
else{
	if(i['Role']=='Manager'){ $SQL = "SELECT SUM(`amount`) FROM `Coinpods_mine`;"; }
	else{ $Q=i['id']; $SQL = "SELECT SUM(`amount`) FROM `Coinpods_mine` WHERE `user` = '".$Q."';";  }
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






 

function TotalMine($Q=null){ return MineTotal($Q); }


	
	
function TeamMine($Q=null){ 
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
				
				
				$User=MineTotal($ts[0]['ID']);   	
				$B=$B+$User;				
			}						
		}
	}
}	
	
	
	
if($B){ /*UpdateTeamStake($B);*/ return $B;}
}	
	
}

 

 

?>