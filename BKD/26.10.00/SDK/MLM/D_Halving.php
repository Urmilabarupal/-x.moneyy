<?php   


// Joo code close hai usko mat run kare please.

// D_Halving Closing Function Start.

/*
function DhalvingRefundToWallet($Q=null){
//Add Balance to Wallet from Transaction(Buy)
$Output=0;	
$PendingDhalvingTransactions=PendingDhalvingRefundTransactions($Q);	
if($PendingDhalvingTransactions){
foreach($PendingDhalvingTransactions as $PBT){
	//print_r($PBT['user']);
	if(AddToFunding(array( 'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$PBT['amount'] ))){
		Balance1Transaction($PBT['id']);
	}
	else{ Balance2Transaction($PBT['id']); }
}	
}	
return $Output;
}



function PendingDhalvingRefundTransactions($Q=null){
	
if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'DhalvingRefund'"; }
else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'DhalvingRefund'"; }

global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}



function CloseD_Halving($Q=null){
	
	$AllD_HalvingUsers = AllD_HalvingUsers();
	if($AllD_HalvingUsers){
		
		foreach($AllD_HalvingUsers as $Ps){
			if($Ps){
				
				$Amount = $Ps['amount']-$Ps['staked']; 
				
				$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `balance`, `ttype`, `amount`, `ccc`, `status`) VALUES (NULL, 'Dhalving Refund: ".$Ps['id']." : ".GMT()."', current_timestamp(), current_timestamp(), 'Dhalving_Refund".$Ps['id']."at".Clean(GMT())."', '".$Ps['user']."', '0', 'DhalvingRefund', '".$Amount."', 'ccc', '1');";
				global $DB;	$Output = mysqli_query($DB, $SQL);	
				if($Output){ 
					
					$SQL1="UPDATE `Coinpods_d_halving` SET `status`='5' WHERE `id` = '".$Ps['id']."';";
					global $DB;	$result = mysqli_query($DB, $SQL1);	

				
				}
				else{
					
					$SQL2="UPDATE `Coinpods_d_halving` SET `status`='4' WHERE `id` = '".$Ps['id']."';";
					global $DB;	$result = mysqli_query($DB, $SQL2);	
				
				}
			}
		}
	}
}



function AllD_HalvingUsers($Q=null){
	
	$SQL="SELECT * FROM `Coinpods_d_halving` WHERE `status` = '1' LIMIT 2000";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){ return $ts; }

}


*/




//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




function BurningHXC($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-20
// Input : 
// Output : Total Burning HXC
	
	$echo = 'Burning HXC Start.';
	
	if(i['id']){
		$echo = 'Login User Found.';
		
		$GlobalJackpotAmount = d2p(GlobalJackpotAmount());
		$echo = 'Global Jackpot Amount Found.';
		
		$JackpotHXC = $GlobalJackpotAmount/Price();
		$echo = 'Jackpot HXC Amount Found.';
		
		$ShareHXC = 62500;
		$echo = 'Share HXC Amount Found.';
		
		$Amount = $JackpotHXC+$ShareHXC;
		$echo = 'Total Burning Amount Found.';
	
	}
	else{ $echo = 'Login first.'; }
	return $Amount;
}


function AllD_Halving($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-19
// Input : 
// Output : Total D_Halving Amount
	
	if(i['id']){	
		
		$SQL = "SELECT SUM(`amount`) FROM `Coinpods_d_halving`;";
		if($SQL){	
			
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
			if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
			else{$ts = null;}	
			if($ts){ return $ts[0]['SUM(`amount`)']; }
		
		}
	}
	else{ $echo='Login first.'; }
}



function TotalD_Halving($Q=null){ return D_HalvingTotal($Q); }

function D_HalvingTotal($Q=null){	
if(i['id']){	

if($Q){ $SQL = "SELECT SUM(`amount`) FROM `Coinpods_d_halving` WHERE `user` = '".$Q."';"; }
else{
	if(i['Role']=='Manager'){ $SQL = "SELECT SUM(`amount`) FROM `Coinpods_d_halving`;"; }
	else{ $Q=i['id']; $SQL = "SELECT SUM(`amount`) FROM `Coinpods_d_halving` WHERE `user` = '".$Q."';";  }
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




function D_HalvingIncome($Q=null){ 
$Q=i['id'];
// OUTPUT :  
if($Q){	
global $DB;$aa = 0;
	$SQL = "SELECT SUM(staked) FROM `Coinpods_d_halving` WHERE `user` = '".$Q."';"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){ return $ts[0]['SUM(staked)']; }
}
}






function GlobalTotalD_Halving($Q=null){ 
	
global $DB;$aa = 0;
	$SQL = "SELECT SUM(staked) FROM `Coinpods_d_halving`"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){ return $ts[0]['SUM(staked)']; }
 
}




 
function DhalvingToWallet($Q=null){
//Add Balance to Wallet from Transaction(Buy)
$Output=0;	
$PendingDhalvingTransactions=PendingDhalvingTransactions($Q);	
if($PendingDhalvingTransactions){
foreach($PendingDhalvingTransactions as $PBT){
	//print_r($PBT['user']);
	if(AddToFunding(array( 'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$PBT['amount'] ))){
		Balance1Transaction($PBT['id']);
	}
	else{ Balance2Transaction($PBT['id']); }
}	
}	
return $Output;
}






function PendingDhalvingTransactions($Q=null){
	
if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Dhalving'"; }
else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'Dhalving'"; }

global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}




function DhalvingToTransaction($Q=null){
	if($Q){
		
//if(AddToWallet(array( 'user'=>$Q['user'], 'ccc'=>strtolower($Q['ccc']), 'amount'=>$Q['amount'] )))
		
if($Q['staking']){
	
	//$Currency = Currency('USDT');
	$Amount = $Q['staking']*$Q['price'];

$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`) VALUES (NULL, 'Dhalving : ".$Q['id']." : ".GMT()."', current_timestamp(), current_timestamp(), 'Dhalving".$Q['id']."at".Clean(GMT())."', '".$Q['user']."', '".$Q['staking']."', 'ccc', '0', 'Dhalving', '".$Amount."', 'usdt', '1');";
	global $DB;	$Output = mysqli_query($DB, $SQL);	
	
	if($Output){ 
		$SQL2="UPDATE `Coinpods_d_halving` SET `staked` = `staked` + `staking`, `staking` = 0 WHERE `Coinpods_d_halving`.`id` = '".$Q['id']."';";	
		global $DB;	$Output = mysqli_query($DB, $SQL2);	
		return $Output;
	}
	}
	} 	
}

function DhalvingToTransactions(){

	$SQL="SELECT * FROM `Coinpods_d_halving` WHERE `status` = 1 ORDER BY `id` DESC";	
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	
	if($ts){
		foreach($ts as $t){
			DhalvingToTransaction($t);
			
		}	
	}	
}




function D_HalvingToDhalving(){
$ab=0;$StakesToStaking=[];
	$Stakes=D_Halvings();	
	if($Stakes){
		foreach($Stakes as $Stake){				
			if(Dhalving($Stake)){ $ab++; }			
		}	
	}
	return $ab;	
}




function Dhalving($Q=null){
// Need Complete data of a single Stake	
if($Q and is_array($Q)){
	if($Q['status']==1){
	$Staking=$Q['amount']*$Q['roi']/100;
	
	$SQL="UPDATE `Coinpods_d_halving` SET `staking` = `staking` + ".$Staking.", `updated` = current_timestamp()  WHERE `Coinpods_d_halving`.`id` = '".$Q['id']."';";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	return true;
	}	
}
}





function D_Halvings($Q=null){
 
	if($Q){ $SQL="SELECT * FROM `Coinpods_d_halving` WHERE `status` = '1' AND `user` = '".$Q."'"; }
	elseif(i['Role']=='Manager'){ $SQL="SELECT * FROM `Coinpods_d_halving` WHERE `status` = '1' ORDER BY `Coinpods_d_halving`.`id` DESC LIMIT 111"; }
	else{ $SQL="SELECT * FROM `Coinpods_d_halving` WHERE `status` = '1' ORDER BY `Coinpods_d_halving`.`id` DESC"; }
	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
 
}




function D_HalvingCreate($Q=null){
$InsertID=0;
if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $UserID=i['id']; $WT=$Q['wt']; }
	
if($WT=='funding'){ 
	$Wallets=Fundings(i['id']); $Name='D_Halving'.$UserID.Clean(GMT());
	
	$ROI=0;
if($Amount>=1000 and $Amount<5000){$ROI=0.05;}
//elseif($Amount>=10000 and $Amount<20000){$ROI=0.15;}
elseif($Amount>=5000){$ROI=0.05;}
else{$ROI=0.05;}


} 
	else{ 
		$Wallets=Wallets(i['id']); $Name="D_Halving:".$UserID.Clean(GMT());

		
	$ROI=0;
if($Amount>=1000 and $Amount<5000){$ROI=0.05;}
//elseif($Amount>=10000 and $Amount<20000){$ROI=0.15;}
elseif($Amount>=5000){$ROI=0.05;}
else{$ROI=0.05;}

	
	}

	
	

$Period=365;
$Type='Day';
$Status=1;

if($UserID and $Amount and $CCC){ 
if($Wallets[$CCC]>=p2d($Amount)){ 
	
	
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `level`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), 'D_Halving:".$UserID.Clean(GMT())."', '".$UserID."', '', '', '1', 'D_Halving', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '0');";
	
global $DB;$aa = 0;
$Staked = mysqli_query($DB, $SQL);
	
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

	$SQL2="INSERT INTO `Coinpods_d_halving` (`id`, `name`, `created`, `modified`, `amount`, `user`, `ccc`, `roi`, `period`, `ttype`, `status`, `price`, `usdt`, `ddd`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), '".p2d($Amount)."', '".i['id']."', '".$CCC."', '".$ROI."', '".$Period."', '".$Type."', '1', '0.040000000000', '', 'HXC');";
	
global $DB;$aa = 0;
$Output = mysqli_query($DB, $SQL2);
	
}	

}
	
	
}
else{ $echo = 'Not enough sources.'; }
	return $InsertID;
}




?>