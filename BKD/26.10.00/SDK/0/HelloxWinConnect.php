<?php

/*
global $Win;
	$servername = "localhost";
	$username = "hellox.win";
	$dbname = "hellox.win";
	$password = "db@hellox.win";
 	
	$Win = new mysqli($servername, $username, $password, $dbname);
	if ($Win->connect_error) {
		die("Connection failed: " . $Win->connect_error);
	}
*/
 $link=$Win;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


 
function TotalTransferApp($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-11
// Input : UserID
// Output : Total HXC Hx.Money To Hellox.Win Transfer
	
	if($Q){ $SQL="SELECT SUM(`amount`) FROM `Coinpods_transfer_app` WHERE `user` = '".$Q."'"; }
	else{ $SQL="SELECT SUM(`amount`) FROM `Coinpods_transfer_app`;"; }
	
	if($SQL){
		
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		if($ts){ return $ts[0]['SUM(`amount`)']; }
	
	}
}






function CreateTransfer_App($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-11
// Input : Amount, CCC, To, Toid
// Output : Transaction Create Transfer 
	
$Output=0;
if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $To=$Q['to']; $ToID=$Q['toid']; }
$UserID=i['id'];	
if($UserID and $Amount and $CCC and $ToID and $To=='spot'){ 
$Wallets=Wallets();

if(i['id']){ 
if($To and $Amount and $CCC){ 
if($Wallets[$CCC]>=p2d($Amount)){ 
	
	
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `buyuser`, `selluser`) VALUES (NULL, 'Transfer:".$To.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Transfer:".$To.Clean(GMT())."', '".i['id']."', '', '', '1', 'TransferApp', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '', '');";
	
global $DB;$aa = 0;
$Staked = mysqli_query($DB, $SQL);
	$IID = mysqli_insert_id($DB);
	
$Walletss=Wallets();	 $Walletss=$Walletss[strtolower($CCC)]; $Walletss=$Walletss-p2d($Amount);
if($Staked){ 
$SQL1="UPDATE `Coinpods_wallet` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_wallet`.`user` = '".$UserID."';"; unset($Walletss);
global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL1);
	
if($Output){
	
	$SQL2="INSERT INTO `Coinpods_transfer_app`(`id`, `name`, `created`, `modified`, `uid`, `user`, `status`, `from`, `to`, `balance`, `amount`, `ccc`, `wallet`, `tid`, `toid`) VALUES (NULL, 'Transfer:".$To.Clean(GMT())."', current_timestamp(), current_timestamp(), '".i['id'].':'.$ToID.':'.$IID."', '".i['id']."', '1', '".$To."', 'spot', '1', '".p2d($Amount)."', '".strtoupper($CCC)."', '".$To."', '".$IID."', '".$ToID."')";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL2);
	
if($results){
	
	$SQL3="INSERT INTO `Coinpods_transfer_app`(`id`, `name`, `created`, `modified`, `uid`, `user`, `status`, `from`, `to`, `balance`, `amount`, `ccc`, `wallet`, `tid`, `toid`) VALUES (NULL, 'Transfer:".$To.Clean(GMT())."', current_timestamp(), current_timestamp(), '".i['id'].':'.$ToID.':'.$IID."', '".i['id']."', '1', '".$To."', 'spot', '0', '".p2d($Amount)."', '".strtoupper($CCC)."', '".$To."', '".$IID."', '".$ToID."')";
	global $Win;$aa = 0; $results = mysqli_query($Win, $SQL3);
	
}
}
} 
}
}	
}
}
if($UserID and $Amount and $CCC and $ToID and $To=='funding'){	
$Wallets=Fundings();
 
if(i['id']){ 
if($To and $Amount and $CCC){ 
if($Wallets[$CCC]>=p2d($Amount)){ 
	
	
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `buyuser`, `selluser`) VALUES (NULL, 'Transfer:".$To.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Transfer:".$To.Clean(GMT())."', '".i['id']."', '', '', '1', 'TransferApp', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '', '');";
	
global $DB;$aa = 0;
$Staked = mysqli_query($DB, $SQL);
	$IID = mysqli_insert_id($DB);

	
$Walletss=Fundings();	 $Walletss=$Walletss[strtolower($CCC)]; $Walletss=$Walletss-p2d($Amount);
if($Staked){ 
$SQL1="UPDATE `Coinpods_funding` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_funding`.`user` = '".$UserID."';"; unset($Walletss);
global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL1);
	
	if($Output){
	
	$SQL2="INSERT INTO `Coinpods_transfer_app`(`id`, `name`, `created`, `modified`, `uid`, `user`, `status`, `from`, `to`, `balance`, `amount`, `ccc`, `wallet`, `tid`, `toid`) VALUES (NULL, 'Transfer:".$To.Clean(GMT())."', current_timestamp(), current_timestamp(), '".i['id'].':'.$ToID.':'.$IID."', '".i['id']."', '1', '".$To."', 'spot', '1', '".p2d($Amount)."', '".strtoupper($CCC)."', '".$To."', '".$IID."', '".$ToID."')";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL2);
	
if($results){
	
	$SQL3="INSERT INTO `Coinpods_transfer_app`(`id`, `name`, `created`, `modified`, `uid`, `user`, `status`, `from`, `to`, `balance`, `amount`, `ccc`, `wallet`, `tid`, `toid`) VALUES (NULL, 'Transfer:".$To.Clean(GMT())."', current_timestamp(), current_timestamp(), '".i['id'].':'.$ToID.':'.$IID."', '".i['id']."', '1', '".$To."', 'spot', '0', '".p2d($Amount)."', '".strtoupper($CCC)."', '".$To."', '".$IID."', '".$ToID."')";
	global $Win;$aa = 0; $results = mysqli_query($Win, $SQL3);
	
}
}
} 
}
}
}
else{ $echo = 'Not enough sources.'; }
}	
return $Output;
}









function UpdateWinxID($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-07
// Input : ID, HelloXWin ID
// Output : Update
	
	if(is_array($Q)){ $ID=$Q['id']; $HelloxWin=$Q['HelloxWin']; }
	if($ID and $HelloxWin){
		
		$SQL="UPDATE `Coinusers` SET `HelloxWin`='".$HelloxWin."' WHERE `ID` = '".$ID."'"; 
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		return $results;
	
	}
	else{ $echo = 'Data Empty.'; }
}


function UserByWinX($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-07
// Input : user_login by hellox.win
// Output : SELECT
	
	if($Q){
		
		global $Win; $aa=0;
		$SQL = "SELECT * FROM `".prefix."users` WHERE `user_login` = '".$Q."'";
		$results = mysqli_query($Win,$SQL);
		if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
		else{$ps=null;}
		$user=$ps[0];
		return $user;	
	
	}
}












?>