<?php


function JackpotActiveUpdates($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-10
// Input :
// Output : Updates when the jackpot was activated.
	
	$Jackpots=PendingJackpotActiveUser();
	if($Jackpots){
	foreach($Jackpots as $Ps){
			//print_r($Ps['user'].' '.$Ps['created']); echo '<br>';
			if($Ps){
			$JackpotActiveUpdate=JackpotActiveUpdate(array('user'=>$Ps['user'], 'active_date'=>$Ps['created']));
				if($JackpotActiveUpdate){
				JackpotUpdate(array('id'=>$Ps['uid'], 'jackpotactive'=>1));
				}
				else{ JackpotUpdate(array('id'=>$Ps['uid'], 'jackpotactive'=>2)); }
			} 
		}
	}
}



function PendingJackpotActiveUser($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-10
// Input : 
// Output : Pending Jackpot Active Users
	
	//$SQL="SELECT * FROM `Coinpods_jackpot` WHERE `jackpotactive` = '0'";
	$SQL="SELECT * FROM `Coinpods_jackpot` WHERE `created` >= '2024-07-01' AND `jackpotactive` = '0'";
	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	if($ts){ return $ts; }

}


function JackpotActiveUpdate($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-10
// Input : UserID, ActiveDate
// Output : Updates when the jackpot was activated.
	
	if(is_array($Q)){ $UserID=$Q['user']; $ActiveDate=$Q['active_date']; }
	if($UserID and $ActiveDate){
		
		$SQL="UPDATE `Coinusers` SET `jackpotactive`='".$ActiveDate."' WHERE `ID` = '".$UserID."';";
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}













function UpdateTodayJackpotIncomeAllUsers($Q=null){
// Developer : Pawan Kumar
// Date : 2024-04-29
// Input :
// Output : Amount update by user coinpods_jackpot table me
	
	$TodayTotalJackpotIncome=TodayTotalJackpotIncome();
	if($TodayTotalJackpotIncome){
		foreach($TodayTotalJackpotIncome as $Ps){
			if($Ps){
				//print_r($Ps['user'].' '.$Ps['amount']);
				
				$SQL="UPDATE `Coinpods_jackpot` SET `today`='".$Ps['amount']."' WHERE `user` = '".$Ps['user']."'";
				global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);

			}
		}
	}
	return $results;
}


function TodayTotalJackpotIncome($Q=null){
// Developer : Pawan Kumar
// Date : 2024-04-29
// Input : 
// Output : Jackpot Today Income By User
	
	$Date = date("Y-m-d");
	$SQL="SELECT SUM(`amount`) AS 'amount', `user` FROM `Coinpods_transaction` WHERE `ttype` LIKE 'Jackpot' AND `created` LIKE '%".$Date."%' GROUP BY `user`";
	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	if($ts){ return $ts; }

}




function ManuallyJackpotIncome($Q=null){
// Developer : Pawan Kumar
// Date : 2024-04-29
// Input :
// Output : Manually Jacpot Income Ki Transaction Create Krta Hai.
	
	$Ps=PendingJackpotManualAmount();
	if($Ps){
		
		foreach($Ps as $P){
		if($P){
			//print_r($P['user']);  echo '<br>';
			
			$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`) VALUES (NULL, 'Manually Jackpot Income', current_timestamp(), current_timestamp(), 'Jackpot_Income:From:Manually:To:".$P['id'].':'.clean(GMT())."', '".$P['user']."', '', '', '0', 'Jackpot', '1000000000', 'USDT', '0', '".$Walletss['ccc']."');"; //echo '<br><br>'.$SQL;
			
			global $DB; $Output = mysqli_query($DB, $SQL);
			if($Output){ UpdateTotalJackpotIncome($P['user']); }
		
		}
	  }
	}
	return $Output;
}





function PendingJackpotManualAmount($Q=null){
// Developer : Pawan Kumar
// Date : 2024-04-29
// Input :
// Output : Jiss user ka total empty hai unn sbhi users ko select krta hai.
	
	$SQL="SELECT * FROM `Coinpods_jackpot` WHERE `total` < 1000000000 ORDER BY `Coinpods_jackpot`.`id` DESC LIMIT 1000;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	return $ts;	
	
}




?>