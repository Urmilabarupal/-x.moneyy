<?php   


function ReleasesNew($Q=null){
// Developer : Pawan Kumar
// Date : 2024-11-05
// Input :
// Output : ROI Update By Reward Rank
	
	$echo = 'Releases New Start.';
	$Output=0;
	$ReleasesPending = ReleasesPending();
	if($ReleasesPending){
	$echo = 'Releases Pending Found.';
		
		foreach($ReleasesPending as $Ps){
		$echo = 'Foreach Good Working.';
			
			$Amount = d2p($Ps['amount']);
			if($Amount and $Ps['user']){
			$echo = 'Amount And User Found.';
				
				$ReleaseNew=ReleaseNew(['amount'=>$Amount, 'user'=>$Ps['user']]);
				if($ReleaseNew){
					
					$echo = 'Release New Success.';
					$Output=1;
					
				}
				else{ $echo = 'Internal Error.';}
			}
			else{ $echo = 'Amount And User Not Found.'; }
		}
	}
	else{ $echo = 'Releases Pending Not Found.'; }
	return $Output;
}



function ReleaseNew($Q=null){
// Developer : Pawan Kumar
// Date : 2024-11-06
// Input : Amount , Userid
// Output : Rank By C-Halving Roi Update
	
	$echo = 'Release New Start.';
	if(is_array($Q)){ $Amount=$Q['amount']; $User=$Q['user']; }
	if($Amount and $User){
		$echo = 'Amount And User Found.';
		
		if($Amount==10){ $ROI=0.06; }       //Rank=1
		elseif($Amount==50){ $ROI=0.075; }  //Rank=2
		elseif($Amount==100){ $ROI=0.1; }   //Rank=3
		elseif($Amount==200){ $ROI=0.15; }  //Rank=4
		elseif($Amount==400){ $ROI=0.20; }  //Rank=5
		elseif($Amount==800){ $ROI=0.25; }  //Rank=6
		elseif($Amount==1600){ $ROI=0.25; } //Rank=7
		elseif($Amount==3200){ $ROI=0.25; } //Rank=8
		elseif($Amount==6400){ $ROI=0.25; } //Rank=9
		elseif($Amount==12800){ $ROI=0.30; }//Rank=10
		$echo = 'ROI Found.';
		
		if($User and $ROI){
		$echo = 'User And ROI Found.';
			//print_r($User.' '.$ROI); echo '<br>';
			$SQL="UPDATE `Coinpods_c_halving` SET `roi`='".$ROI."' WHERE `user` = '".$User."';";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
			$echo = 'Release New Success.';
		
		}
		else{ $echo = 'User And ROI Not Found.'; }
	}
	else{ $echo = 'Amount And User Not Found.'; }
	return $results;
}



function ReleasesPending($Q=null){
// Developer : Pawan Kumar
// Date : 2024-11-05
// Input : 
// Output : This Month Reward Achieve Users List
	
	$echo = 'Releases Pending Start.';
	$Start = date("Y-m", strtotime("-1 month")).'-31 00:00:00';
	$End = date("Y-m").'-07 23:59:59';
	$echo = 'Start And End Time Found.';

	$SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 1 AND `ttype` = 'RewardNew' AND `created` BETWEEN '".$Start."' AND '".$End."' AND `user` != '7';";
	$echo = 'SQL Found.';
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
	
}





function C_HalvingReset($Q=null){
// Developer : Pawan Kumar
// Date : 2024-11-05
// Input : 
// Output : C-Halving Roi Update
	
	$SQL="UPDATE `Coinpods_c_halving` SET `roi`='0.05'";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	return $results;
}







function TotalStakedC_Halving($Q=null){
// Developer : Pawan Kumar
// Date : 2024-10-14
// Input : UserID
// Output : Total C_Halving Staked Income
	
	if(!$Q){ $Q=i['id']; }
	if($Q){
		
		$SQL="SELECT SUM(`amount`) FROM `Coinpods_transaction` WHERE `ttype` = 'Chalving' AND `user` = '".$Q."'";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		if($ts){ return $ts[0]['SUM(`amount`)']; }
	
	}
	else{ $echo = 'Q Data Not Found.'; } 
}


function AllC_Halving($Q=null){
// Developer : Pawan Kumar
// Date : 2024-10-08
// Input : 
// Output : Total C_Halving Amount
	
	if(i['id']){	
		
		$SQL = "SELECT SUM(`amount`) FROM `Coinpods_c_halving`;";
		if($SQL){	
			
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
			if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
			else{$ts = null;}	
			if($ts){ return $ts[0]['SUM(`amount`)']; }
		
		}
	}
	else{ $echo='Login first.'; }
}



function TotalC_Halving($Q=null){ return C_HalvingTotal($Q); }

function C_HalvingTotal($Q=null){	
if(i['id']){	

if($Q){ $SQL = "SELECT SUM(`amount`) FROM `Coinpods_c_halving` WHERE `user` = '".$Q."';"; }
else{
	if(i['Role']=='Manager'){ $SQL = "SELECT SUM(`amount`) FROM `Coinpods_c_halving`;"; }
	else{ $Q=i['id']; $SQL = "SELECT SUM(`amount`) FROM `Coinpods_c_halving` WHERE `user` = '".$Q."';";  }
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


function HXConvertTotalIncome($Q=null){
	
	if(!$Q){ $Q=i['id']; }
	if($Q){
		
		global $DB;$aa = 0;
		
		$SQL="SELECT SUM(`amount`) FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `ttype` = 'Chalving' AND `status` = '1' ORDER BY `id` DESC;"; 
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		
		if($ts){ return $ts[0]['SUM(`amount`)']; }
		
	}
}

function C_HalvingIncome($Q=null){ 
if(!$Q){ $Q=i['id']; }
// OUTPUT :  
if($Q){	
global $DB;$aa = 0;
	$SQL = "SELECT SUM(staked) FROM `Coinpods_c_halving` WHERE `user` = '".$Q."';"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){ return $ts[0]['SUM(staked)']; }
}
}






function GlobalTotalC_Halving($Q=null){ 
	
	global $DB;$aa = 0;
	$SQL = "SELECT SUM(staked) FROM `Coinpods_c_halving`"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){ return $ts[0]['SUM(staked)']; }
 
}




 
function ChalvingToWallet($Q=null){
//Add Balance to Wallet from Transaction(Buy)
$Output=0;	
$PendingDhalvingTransactions=PendingChalvingTransactions($Q);	
if($PendingDhalvingTransactions){
foreach($PendingDhalvingTransactions as $PBT){
	//print_r($PBT['user']);
	if(AddToExtraWallet(array( 'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$PBT['amount'] ))){
		Balance1Transaction($PBT['id']);
	}
	else{ Balance2Transaction($PBT['id']); }
}	
}	
return $Output;
}






function PendingChalvingTransactions($Q=null){
	
if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Chalving'"; }
else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'Chalving'"; }
	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}




function ChalvingToTransaction($Q=null){
	
	$BeforeBalance=$AfterBalance=0;
	

	if($Q){
		//if(AddToWallet(array( 'user'=>$Q['user'], 'ccc'=>strtolower($Q['ccc']), 'amount'=>$Q['amount'] )))
		
		if($Q['staking']){
			
			//$Currency = Currency('USDT');
			
			
			$Amount = $Q['staking']*$Q['price'];
			
			$ExtraWallets=ExtraWallets($Q['user'])['usdt'];
			
			$BeforeBalance=$ExtraWallets;
			$AfterBalance=$BeforeBalance+$Amount;
			
			$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`,`afterbalance`) VALUES (NULL, 'Chalving : ".$Q['id']." : ".GMT()."', current_timestamp(), current_timestamp(), 'Chalving".$Q['id']."at".Clean(GMT())."', '".$Q['user']."', '".$Q['staking']."', 'ccc', '0', 'Chalving', '".$Amount."', 'usdt', '1', '".$BeforeBalance."', '".$AfterBalance."');";
			
			global $DB;	$Output = mysqli_query($DB, $SQL);
			
			if($Output){ 
				//$Input = ['feature'=>'Staking_ConvertIncome','amount'=>$Amount,'pair'=>'USDT_USDT','user'=>$Q['user']];
				//LiveData___Feature_Meta($Input);
				
				//$Input = ['feature'=>'Staking_ConvertIncome','amount'=>$Q['staking'],'pair'=>'CCC_CCC','user'=>$Q['user']];
				//LiveData___Feature_Meta($Input);
				$SQL2="UPDATE `Coinpods_c_halving` SET `staked` = `staked` + `staking`, `staking` = 0 WHERE `Coinpods_c_halving`.`id` = '".$Q['id']."';";	
				global $DB;	$Output = mysqli_query($DB, $SQL2);
				return $Output;
			}
		}
	} 	
}

function ChalvingToTransactions(){

	$SQL="SELECT * FROM `Coinpods_c_halving` WHERE `status` = 1 ORDER BY `id` DESC";	
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	
	if($ts){ 
		$Dishpech=0;
		
		foreach($ts as $t){
			ChalvingToTransaction($t);
			
				
				if($Dishpech==1 and $t['staking']){
					
			//	$Amount = $t['staking']*$t['price'];
					
			//	$Array=['feature'=>'Staking_ConvertIncome','pair'=>'CCC_CCC','user'=>$t['user'],'amount'=>$t['staking'],];
				//HistoryUpdateNew($Array);	unset($Array);
				
				
			//	$Array=['feature'=>'Staking_ConvertIncome','pair'=>'USDT_USDT','user'=>$t['user'],'amount'=>$Amount,];
			//	HistoryUpdateNew($Array);unset($Array);
				
				}
				
			
		}	
	}	
}




function C_HalvingToChalving(){
$ab=0;$StakesToStaking=[];
	$Stakes=C_Halvings();	
	if($Stakes){
		foreach($Stakes as $Stake){				
			if(Chalving($Stake)){ $ab++; }			
		}	
	}
	return $ab;	
}




function Chalving($Q=null){
// Need Complete data of a single Stake	
if($Q and is_array($Q)){
	if($Q['status']==1){
	$Staking=$Q['amount']*$Q['roi']/100;
	
	$SQL="UPDATE `Coinpods_c_halving` SET `staking` = `staking` + ".$Staking.", `updated` = current_timestamp()  WHERE `Coinpods_c_halving`.`id` = '".$Q['id']."';"; 
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	return true;
	}	
}
}





function C_Halvings($Q=null){
 
	if($Q){ $SQL="SELECT * FROM `Coinpods_c_halving` WHERE `status` = '1' AND `user` = '".$Q."'"; }
	elseif(i['Role']=='Manager'){ $SQL="SELECT * FROM `Coinpods_c_halving` WHERE `status` = '1' ORDER BY `Coinpods_c_halving`.`id` DESC LIMIT 111"; }
	else{ $SQL="SELECT * FROM `Coinpods_c_halving` WHERE `status` = '1' ORDER BY `Coinpods_c_halving`.`id` DESC"; }
 
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
 
}




function C_HalvingCreate($Q=null){
$InsertID=$BeforeBalance=$AfterBalance=0; 
if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $UserID=$Q['user']; $WT=$Q['wt']; $ByManager=$Q['name']; }
	
	if(!$UserID){ $UserID=i['id']; }
	
	if($WT=='extra'){ 
		$Wallets=ExtraWallets($UserID); $Name='C_Halving'.$ByManager.$UserID.Clean(GMT());
		$ROI=0;
		if($Amount>=10 and $Amount<5000){$ROI=0.05;}
		//elseif($Amount>=10000 and $Amount<20000){$ROI=0.15;}
		elseif($Amount>=5000){$ROI=0.05;}
		else{$ROI=0.05;}
	
	} 
	else{ 
		
		$Wallets=Wallets($UserID); $Name="C_Halving ".$ByManager." : ".$UserID.Clean(GMT());
		$ROI=0;
		if($Amount>=1000 and $Amount<5000){$ROI=0.05;}
		//elseif($Amount>=10000 and $Amount<20000){$ROI=0.15;}
		elseif($Amount>=5000){$ROI=0.05;}
		else{$ROI=0.05;}
	
	}
	
	$Period=5;
	$Type='Years';
	$Status=1;
	
	if($UserID and $Amount and $CCC){ 
		
		$BeforeBalance=$Wallets[strtolower($CCC)];
		$AfterBalance=$BeforeBalance-p2d($Amount);
		
			
		if($Wallets[$CCC]>=p2d($Amount)){ 
			
			$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`,`afterbalance`, `level`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), 'C_Halving:".$UserID.Clean(GMT())."', '".$UserID."', '', '', '1', 'C_Halving', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."','".$AfterBalance."', '0');";
			
	 	global $DB;$aa = 0;  $Staked = mysqli_query($DB, $SQL);
			if($Staked){ $InsertID=mysqli_insert_id($DB); }	
			
			if($WT=='extra'){ $Walletss=ExtraWallets($UserID); } else{ $Walletss=Wallets($UserID); }	
			$Walletss=$Walletss[strtolower($CCC)]; $Walletss=$Walletss-p2d($Amount);
			if($Staked){ 
				
				
				
if($WT=='extra'){
					
$SQL1="UPDATE `Coinpods_extra_wallet` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_extra_wallet`.`user` = '".$UserID."';"; unset($Walletss);
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
elseif($Amount >= 10000 and $Amount <= 99999){ $Offer = 10; }
elseif($Amount >= 100000 and $Amount <= 499999){ $Offer = 15; }
elseif($Amount >= 500000  and $Amount <= 500000000){ $Offer = 20; }
else{ $Offer = 5; }
//if($Offer){ $Offer = $Amount*$Offer/100; $Amount = $Amount+$Offer; }
//*Offer

	$SQL2="INSERT INTO `Coinpods_c_halving` (`id`, `name`, `created`, `modified`, `amount`, `user`, `ccc`, `roi`, `period`, `ttype`, `status`, `price`, `usdt`, `ddd`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), '".p2d($Amount)."', '".$UserID."', '".$CCC."', '".$ROI."', '".$Period."', '".$Type."', '1', '0.060000000000', '', 'HXC');";
	 global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL2);
	
	if($Output){
	
	//$Input = ['feature'=>'Staking_Convert','amount'=>p2d($Amount),'pair'=>'CCC_CCC','user'=>$UserID];
	///LiveData___Feature_Meta($Input);
	

				
	}
}	
}
}
else{ $echo = 'Not enough sources.'; }
return $InsertID;
}




?>