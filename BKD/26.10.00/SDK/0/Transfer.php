<?php


function TransferToWallets($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/03
//Input :
//Output : Adds the amount to the wallet depending on the wallet type.
	
	$PTs=PendingTransfer();
	if($PTs){
		foreach($PTs as $P){

			
			if($P['to'] == 'spot'){ // Spot Wallet

				if(AddToWallet(array( 'user'=>$P['user'], 'ccc'=>strtolower($P['ccc']), 'amount'=>$P['amount'] ))){
				Wallet1Transaction($P['id']); }
				else{ Wallet2Transaction($P['id']); }
				
			}

			
			elseif($P['to'] == 'funding'){ // Funding Wallet

				if(AddToFunding(array( 'user'=>$P['user'], 'ccc'=>strtolower($P['ccc']), 'amount'=>$P['amount'] ))){
				Wallet1Transaction($P['id']); }
				else{ Wallet2Transaction($P['id']); }
			
			}

			
			elseif($P['to'] == 'slot'){ // Slot Wallet

				if(AddToSlotWallet(array( 'user'=>$P['user'], 'ccc'=>strtolower($P['ccc']), 'amount'=>$P['amount'] ))){
				Wallet1Transaction($P['id']); }
				else{ Wallet2Transaction($P['id']); }
			
			}
		}
	}
}




function PendingTransfer($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/03
//Input : 
//Output : Transfer ki all pending transactions
	
	$SQL="SELECT * FROM `Coinpods_transfer` WHERE `wallet` = '0'";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	$return = $ts;
	
	return $return;

}











function TransferNew($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/03
//Input : Amount, CCC, To, From
//Output : New transfer ki transaction create kr deta hai. ( Coinpods_transaction And Coinpods_transfer )
	
	$Output=0;
	
	if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $To=$Q['to']; $From=$Q['from']; }
	$UserID=i['id'];
	
	
if($From == 'spot'){
	
	
	$Wallets=Wallets();
	
	if(i['id']){
		if($To and $Amount and $CCC and $From){
			if($Wallets[$CCC]>=p2d($Amount)){
				
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `buyuser`, `selluser`) VALUES (NULL, 'Transfer:".$From.Clean(GMT()).$To."', current_timestamp(), current_timestamp(), 'Transfer:".$To.Clean(GMT())."', '".i['id']."', '', '', '1', 'Transfer', '".p2d($Amount)."', '".strtolower($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '', '');";
global $DB;$aa = 0; $Staked = mysqli_query($DB, $SQL);
				$TID = mysqli_insert_id($DB);
				
				$Walletss=Wallets(); $Walletss=$Walletss[strtolower($CCC)]; $Walletss=$Walletss-p2d($Amount);
				
				if($Staked){
					
$SQL1="UPDATE `Coinpods_wallet` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_wallet`.`user` = '".$UserID."';"; unset($Walletss);
global $DB;$aa = 0; $Walleted = mysqli_query($DB, $SQL1);
				
				}
				
				if($Walleted){
					
					
$SQL2="INSERT INTO `Coinpods_transfer`(`id`, `name`, `created`, `modified`, `user`, `status`, `from`, `to`, `amount`, `ccc`, `wallet`, `tid`) VALUES (NULL, '".$UserID."', current_timestamp(), current_timestamp(), '".$UserID."', '1', '".$From."', '".$To."', '".p2d($Amount)."', '".strtolower($CCC)."', '0', '".$TID."')";
global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL2);
				
				}
			}
		}
	}
}
elseif($From == 'funding'){
	
	
	$Wallets=Fundings();
	
	if(i['id']){
		if($To and $Amount and $CCC and $From){
			if($Wallets[$CCC]>=p2d($Amount)){ 
	
	
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `buyuser`, `selluser`) VALUES (NULL, 'Transfer:".$To.Clean(GMT()).$From."', current_timestamp(), current_timestamp(), 'Transfer:".$To.Clean(GMT())."', '".i['id']."', '', '', '1', 'Transfer', '".p2d($Amount)."', '".strtolower($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '', '');";
global $DB;$aa = 0; $Staked = mysqli_query($DB, $SQL);
				$TID = mysqli_insert_id($DB);

				
				$Walletss=Fundings(); $Walletss=$Walletss[strtolower($CCC)]; $Walletss=$Walletss-p2d($Amount);
				
				
				if($Staked){
					
$SQL1="UPDATE `Coinpods_funding` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_funding`.`user` = '".$UserID."';"; unset($Walletss);
global $DB;$aa = 0; $Walleted = mysqli_query($DB, $SQL1);
				
				}
				
				
				if($Walleted){
					
$SQL2="INSERT INTO `Coinpods_transfer`(`id`, `name`, `created`, `modified`, `user`, `status`, `from`, `to`, `amount`, `ccc`, `wallet`, `tid`) VALUES (NULL, '".$UserID."', current_timestamp(), current_timestamp(), '".$UserID."', '1', '".$From."', '".$To."', '".p2d($Amount)."', '".strtolower($CCC)."', '0', '".$TID."')";
global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL2);
				
				}
			}
		}
	}
	else{ $echo = 'Not enough sources.'; }
}
return $Output;
}




function Wallet1Transaction($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/03
//Input : 
//Output : On success the amount in wallet is updated to wallet == 1.
	
	if($Q){
		
		$SQL="UPDATE `Coinpods_transfer` SET `wallet` = '1' WHERE `Coinpods_transfer`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);
		return  $Output;
	
	}
}


function Wallet2Transaction($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/03
//Input : 
//Output : On unsuccess the amount in wallet is updated to wallet == 2.

	if($Q){
		
		$SQL="UPDATE `Coinpods_transfer` SET `wallet` = '2' WHERE `Coinpods_transfer`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);
		return  $Output;
	
	}
}



function Transfer($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/03
//Input : Transaction ID 
//Output : Single Transaction
	
	if($Q){
		
		$SQL="SELECT * FROM `Coinpods_transfer` WHERE `id` = '".$Q."';";
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
	
	}
	else{ $echo = 'Data Empty.'; }
	return $ts;
}



function Transfers($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/03
	
	if(!$Q){ $Q=5; }
	
	$SQL="SELECT * FROM `Coinpods_transfer` WHERE `status` = '1'  ORDER BY `Coinpods_transfer`.`id` ASC LIMIT '".$Q."'";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
	
}


function TransferUpdate($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/03
	
	if(is_array($Q)){ $ID=$Q['id']; $To=$Q['to']; $CCC=$Q['ccc']; $Tid=$Q['tid']; $User=$Q['user']; $From=$Q['from']; $Name=$Q['name']; $Wallet=$Q['wallet']; $Status=$Q['status']; $Balance=$Q['balance']; }
	
	$WHERE = "WHERE `Coinpods_transfer`.`id` = '".$ID."'";
	$SET = "UPDATE `Coinpods_transfer` SET  `modified`= current_timestamp()";
	
	if($ID){$ID = ", `id`='".$ID."'";}
	if($To){$To = ", `to`='".$To."'";}
	if($CCC){$CCC = ", `ccc`='".$CCC."'";}
	if($Tid){$Tid = ", `tid`='".$Tid."'";}
	if($User){$User = ", `user`='".$User."'";}
	if($From){$From = ", `from`='".$From."'";}
	if($Name){$Name = ", `name`='".$Name."'";}
	if($Wallet){$Wallet = ", `wallet`='".$Wallet."'";}
	if($Status=='enable'){$StatusValue = ", `status`='1'";}elseif($Status=='disable'){$StatusValue = ", `status`='0'";}
	if($Balance=='enable'){$BalanceValue = ", `balance`='1'";}elseif($Balance=='disable'){$BalanceValue = ", `balance`='0'";}
	
	$SQL=$SET.$ID.$To.$CCC.$Tid.$User.$From.$Name.$Wallet.$StatusValue.$BalanceValue.$WHERE;
	
	if($SQL){ // echo $SQL;
		
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if($results){ return true; }else{ return false; }
	
	}
	else{ $echo ='SQL not found.'; }	
	
}



function TransferStatus($Q=null){
//Developer : Pawan Kumar
//Date : 2024/03/03

	
	if(is_array($Q)){ $Status=$Q['status']; $ID=$Q['id']; }
	if($Status and $ID){
		
		if($Status == 'enable'){ $Statuss = 1; } 
		elseif($Status == 'disable'){ $Statuss = 0; }
		
		$SQL="UPDATE `Coinpods_transfer` SET `status` = '".$Statuss."', `modified` = current_timestamp() WHERE `id` = '".$ID."'";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Empty.'; }
	return $results;	
}


?>