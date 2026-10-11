<?php

function StakingRedeemToWallet($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-11
// Input : 
// Output : Staking Redeem Transaction Add To Funding Wallet
	
	$echo = 'Staking Redeem To Wallet Start.';
	$Output=0;
	$PendingStakingRedeemTransaction=PendingStakingRedeemTransaction($Q);
	if($PendingStakingRedeemTransaction){
	$echo = 'Pending Staking Redeem Transaction Found.';
		
		foreach($PendingStakingRedeemTransaction as $Ps){
		$echo = 'Foreach Good Working.';
			
			if(AddToFunding(array( 'user'=>$Ps['user'], 'ccc'=>strtolower($Ps['ccc']), 'amount'=>$Ps['amount'] ))){
				Balance1Transaction($Ps['id']);
				$echo = 'Add To Funding Wallet Success.';
			}
			else{ 
				Balance2Transaction($Ps['id']); 
				$echo = 'Internal Error.';
			}
		}
	}
	else{ $echo = 'Pending Staking Redeem Transaction Not Found.'; }
	return $Output;
}


function PendingStakingRedeemTransaction($Q=null){
// Developer : Pawan Kumar
// Date : 2024-12-19
// Input : Userid
// Output : Staking Redeem Pending Transaction
	
    if($Q){$SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Staking_Redeem'"; }
	else{$SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'Staking_Redeem'"; }
	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		

}


function StakingRedeems($Q=null){
// Developer : Pawan Kumar
// Date : 2024-12-18
// Input : 
// Output : Transaction Create
	
	$echo = 'Staking Redeems Start.';
	$StakingRedeemPending=StakingRedeemPending();
	if($StakingRedeemPending){
	$echo = 'Staking Redeem Pending Users Found.';
		
		foreach($StakingRedeemPending as $Ps){
		$echo = 'Foreach Good Working.';
			
			if($Ps['user']){
			$echo = 'UserID Found.';
				
				$Orderid='Staking_Redeem:'.$Ps['user'].':'.Clean(GMT()).':'.$Ps['id'];
				$echo = 'Orderid Found.';
				
				$SQL="INSERT INTO `Coinpods_transaction`(`id`, `name`, `user`, `balance`, `ttype`, `amount`, `ccc`, `filled`, `status`, `beforebalance`, `afterbalance`, `price`, `orderid`, `modified`, `created`) VALUES (NULL, 'Staking_Redeem".$Ps['user'].':StakingID:'.$Ps['id']."', '".$Ps['user']."', '0', 'Staking_Redeem', '".$Ps['amount']."', '".$Ps['ccc']."', '', '1', '', '', '".Price()."', '".$Orderid."', '".GMT()."', '".GMT()."')";
				$echo = 'SQL Found.';
				global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
				
				if($results){
				$echo = 'Results Found.';
					
					$SQL1="UPDATE `Coinpods_staking` SET `status`='7' WHERE `id`='".$Ps['id']."'";
					global $DB; $aa = 0; $Output = mysqli_query($DB, $SQL1);
					$echo = 'Staking Status Update Success.';
				
				}
				else{ $echo = 'Coinpods_Transaction Results Not Found.'; }
			}
			else{ $echo = 'UserID Not Found.'; }
		}
	}
	else{ $echo = 'Staking Redeem Pending Users Not Found.'; }
}


function StakingRedeemPending($Q=null){
// Developer : Pawan Kumar
// Date : 2024-12-19
// Input : 
// Output : Staking Redeem Pending Transaction
	
	$SQL="SELECT * FROM `Coinpods_staking` WHERE `status` = 6;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		

}


?>