<?php


function CreateCrypto($Q=null){
// OUTPUT : multiple withdraw data from DB by user_ID($Q)
if($Q){
$SQL = "INSERT INTO `Coinpods_crypto` (`id`, `name`, `hash`, `created`, `modified`, `from`, `status`, `to`, `amount`, `ccc`, `timestamp`, `network`) VALUES (NULL, '".$Q['network'].":".$Q['hash']."', '".$Q['hash']."', current_timestamp(), current_timestamp(), '".$Q['from']."', '0', '".$Q['to']."', '".$Q['amount']."', '".$Q['token']."', '".$Q['timestamp']."', '".$Q['network']."');";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0];
	//return $SQL;
}
}



function create_trxxxxxxxxxxxxx($Q=null){
// OUTPUT : multiple withdraw data from DB by user_ID($Q)
global $DB;$aa = 0;
$SQL = "INSERT INTO `trx` (`id`, `hash`, `from`, `to`, `amount`, `type`, `status`, `token`, `created`, `modified`, `aproved`, `timestamp`) VALUES (NULL, '".$Q['hash']."', '".$Q['from']."', '".$Q['to']."', '".p2d($Q['amount'])."', NULL, '0', '".$Q['token']."', current_timestamp(), current_timestamp(), NULL, '".$Q['timestamp']."');";
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0];
	//return $SQL;
}





function trx_where($Q=null){
// OUTPUT : multiple withdraw data from DB by user_ID($Q)
global $DB;$aa = 0;
	$SQL = "SELECT * FROM `trx` WHERE ".$Q;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;
}




function Crypto($Q=null){
// OUTPUT : multiple withdraw data from DB by user_ID($Q)
if($Q){
	$SQL = "SELECT * FROM `Coinpods_crypto` WHERE `hash` = '".$Q."'";
	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0];
}
}





function trx($Q=null){
// OUTPUT : multiple withdraw data from DB by user_ID($Q)
global $DB;$aa = 0;
	$SQL = "SELECT * FROM `trx` WHERE `hash` = '".$Q."'";
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0];
}





function TRXsPending(){	
if(i['id']){	
	$SQL="SELECT * FROM `trx` WHERE `status` = 0";	
	global $DB; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
}
	return $ts;
}


function TRXToTransaction(){
	$status=0;

	if(i['id']){ // If logged in?
		
		$TRXsPending=TRXsPending();
		 
		
		if($TRXsPending){
			foreach($TRXsPending as $t){
				 
				
				$UBT=UserByTRX($t['from']);
				$status=0;
				
				if($UBT['ID']){ // TRX's wallet is linked to a account
					
					$amount=d2p($t['amount']);
					$amount=$amount*s['TRX/TOM'];
					
					$from=$UBT['ID'];
					$OrderID=$t['hash'];
 					
					
if($amount and $from and $OrderID){
	
	$RR=p2d($amount*5/100); // 5% Referel reward
	$extra=$amount*5;
	$extra=$extra/100;
	//$amount=$extra+$amount;
	
	$OCA=$t['amount'];
	$OCC='TRX';
			
			
			
$SQL="INSERT INTO `transactions` (`id`, `OrderID`, `OCA`, `OCC`, `plan`, `work_start`, `work_end`, `limit`, `type`, `amount`, `c`, `roi`, `status`, `cyrpto_id`, `cyrpto`, `from`, `roi_updated`, `withdrawable`, `withdrawed`, `withdraw_ok`, `about`, `end`, `created`, `modified`, `l1`) VALUES (NULL, '".$OrderID."', '".$OCA."', '".$OCC."', '".$plan['id']."', '".$plan['work_start']."', '".$plan['work_end']."', '".$plan['limit']."', '".$plan['type']."', '".p2d($amount)."', '".$ccc."', '".$plan['roi']."', '1', '".$crypto_id."', '".$crypto_user."', '".$from."', NULL, '0.00000000000000000000', '0.00000000000000000000', NULL, NULL, NULL, current_timestamp(), current_timestamp(), '".$RR."');";
	
 
 		global $DB; $results = mysqli_query($DB, $SQL); // Wallet Balance Updated

		$SQL="UPDATE `trx` SET `status` = '1' WHERE `trx`.`id` =".$t['id'];	
		global $DB; $results = mysqli_query($DB, $SQL); // Transaction status updated
			
		}
				}
				else{  $echo ="TRX's wallet is not linked to any account"; }
			unset($t);	
			}
			
}

   	}
}




?>