<?php


function CreateTransfer($Q=null){
$Output=0;
if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $To=$Q['to']; }
$UserID=i['id'];	
	
$Wallets=Wallets();
 
if(i['id']){ 
if($To and $Amount and $CCC){ 
if($Wallets[$CCC]>=p2d($Amount)){ 
	
	
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `buyuser`, `selluser`) VALUES (NULL, 'Transfer:".$To.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Transfer:".$To.Clean(GMT())."', '".i['id']."', '', '', '0', 'Transfer', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '', '');";
	
global $DB;$aa = 0;
$Staked = mysqli_query($DB, $SQL);
	
$Walletss=Wallets();	 $Walletss=$Walletss[strtolower($CCC)]; $Walletss=$Walletss-p2d($Amount);
if($Staked){ 
$SQL1="UPDATE `Coinpods_wallet` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_wallet`.`user` = '".$UserID."';"; unset($Walletss);
global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL1);	
} 

}
	
	
}
else{ $echo = 'Not enough sources.'; }
}
	return $Output;
}





 
function TransferToWallet($Q=null){
//Add Balance to Wallet from Transaction(Buy)
$Output=0;	
$PendingStakingTransactions=PendingTransferTransactions($Q);	
if($PendingStakingTransactions){
foreach($PendingStakingTransactions as $PBT){
	//print_r($PBT['user']);
	if(AddToFunding(array( 'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$PBT['amount'] ))){
		
		$Walletss = Fundings($PBT['user']);
		UpdateAfterBalance( array( 'id'=>$PBT['id'], 'amount'=>$Walletss['ccc'] ) );
		Balance1Transaction($PBT['id']);
	}
	else{ Balance2Transaction($PBT['id']); }
}	
}	
return $Output;
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




function CreateSend($Q=null){
$Output=0;
if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $To=$Q['to']; }
$UserID=i['id'];	
	
$Wallets=Fundings();
 
if(i['id']){ 
if($To and $Amount and $CCC){ 
if($Wallets[$CCC]>=p2d($Amount)){ 
	
	
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `buyuser`, `selluser`) VALUES (NULL, 'Send:".$To.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Send:".$To.Clean(GMT())."', '".i['id']."', '', '', '0', 'Send', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '".$To."', '".i['id']."');";
	
global $DB;$aa = 0;
$Staked = mysqli_query($DB, $SQL);
	
$Walletss=Fundings();	 $Walletss=$Walletss[strtolower($CCC)]; $Walletss=$Walletss-p2d($Amount);
if($Staked){ 
$SQL1="UPDATE `Coinpods_funding` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_funding`.`user` = '".$UserID."';"; unset($Walletss);
global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL1);	
} 

}
	
	
}
else{ $echo = 'Not enough sources.'; }
}
	return $Output;
}







 
function SendsToWallet($Q=null){
//Add Balance to Wallet from Transaction(Buy)
$Output=0;	
$PendingStakingTransactions=PendingSendTransactions($Q);	
if($PendingStakingTransactions){
foreach($PendingStakingTransactions as $PBT){
	//print_r($PBT['user']);
	if(AddToWallet(array( 'user'=>$PBT['buyuser'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$PBT['amount'] ))){
		Balance1Transaction($PBT['id']);
	}
	else{ Balance2Transaction($PBT['id']); }
}	
}	
return $Output;
}



?>


