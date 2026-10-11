<?php

function Jackpot_DataNews($Q=null){
	// Developer : Pawan Kumar
	// Date : 2025-09-12

	$Apr=20; 
	$Roi=1.2; 
	$CCC='usdt'; 
	$Period=365; 
	$Ttype='Day';

	$Jackpot_DataPending=Jackpot_DataPending();
	if($Jackpot_DataPending){
		foreach($Jackpot_DataPending as $Single){

			$Amount=$Single['jackpot_invested']-$Single['jackpot_income'];

			$SQL="INSERT INTO `Ctaking_old7`(`id`, `userid`, `created`, `modified`, `status`, `pending`, `slot`, `amount`, `ccc`, `roi`, `apr`, `period`, `ttype`) VALUES (NULL, '".$Single['userid']."', current_timestamp(), current_timestamp(), '1', '0', '', '".p2d($Amount)."', '".$CCC."', '".$Roi."', '".$Apr."', '".$Period."', '".$Ttype."')";
			global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);				

		}
	}
	return $results;
}



function Jackpot_DataPending($Q=null){

	$SQL="SELECT * FROM `jackpot_anniversary_data` WHERE `pending` = 0";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	return $ts;

}




function Jackpot_AnniversaryNews($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-09-11

	$Pending_Jackpot_AnniversaryData=Pending_Jackpot_AnniversaryData();
	if($Pending_Jackpot_AnniversaryData){
		foreach($Pending_Jackpot_AnniversaryData as $Single){
			$User=user($Single['user']);

			$SQL="INSERT INTO `jackpot_anniversary_data`(`id`, `userid`, `status`, `pending`, `jackpot_invested`, `jackpot_income`) VALUES (NULL, '".$User['userid']."', '1', '0', '".$Single['Jackpot_Invested_Amount']."', '".$Single['Jackpot_Income_Amount']."')";
			//global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);

		}
	}
	return $results;
}




function Pending_Jackpot_AnniversaryData($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-09-11

	$SQL="SELECT `user`, SUM(CASE WHEN `ttype` = 'Deposit' THEN `amount`/1000000000 ELSE 0 END) AS Jackpot_Invested_Amount, SUM(CASE WHEN `ttype` = 'Jackpot' THEN `amount`/1000000000 ELSE 0 END) AS Jackpot_Income_Amount FROM `hx.money.transaction`.`Coinpods_transaction` WHERE `ttype` IN ('Deposit', 'Jackpot') AND (`walletname` = 'Jackpot' OR `ttype` = 'Jackpot') GROUP BY `user`";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	return $ts;

}



?>