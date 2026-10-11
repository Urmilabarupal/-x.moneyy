<?php


function JackpotLevelIncomes($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-02
// Input : 
// Output : Jackpot Lavel Income Provide.
	
	$Output = 0;
	$echo = 'Jackpot Level Incomes Start.';
	$PendingJackpotLevel = PendingJackpotLevel();
	$echo = 'Pending Jackpot Level Users Found.';
	
	if($PendingJackpotLevel){
		$echo = 'Pending Jackpot Level Validation Good Working.';
		
		foreach($PendingJackpotLevel as $PJL){
			$echo = 'Foreach Good Working.';
			
			if($PJL){
				$echo = 'Pending User Found.';
				
				$User = user($PJL['user']);
				$echo = 'User Found.';
				
				if($User){
					$echo = 'User Validation Good Working.';
					
					$Array = array('referby'=>$User['referby'], 'user'=>$PJL['user']);
					$echo = 'Array Found.';
					
					$JackpotLevelIncome = JackpotLevelIncome($Array);
					if($JackpotLevelIncome){
						
						$Output = 1;
						$echo = 'Success';
						JackpotUplineOne($PJL['user']);
					
					}
					else{ JackpotUplineTwo($PJL['user']); $echo = 'Jackpot Level Income Not Working.'; } 
				}
				else{ $echo = 'User Not Found.'; }
			}
			else{ $echo = 'Pending  User Not Found.'; } 
		}
	}
	else{ $echo = 'Pending Jackpot Level Users Not Found.'; }
}




function JackpotLevelIncome($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-02
// Input : ReferID And DirectID
// Output : INSERT
	
	$echo = 'Jackpot Worker Income Transaction Start.';
	if(is_array($Q)){ $Upline = $Q['referby']; $Direct = $Q['user']; }
	if($Upline and $Direct){
		$echo = 'Upline And Direct Found.';
		
		$User = UserByUserID($Upline);
		$echo = 'User Found.';
		
		if($User){
			$echo = 'User Validation Good Working.';
			
			$SQL="INSERT INTO `Coinpods_transaction`(`id`, `created`, `name`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `filled`, `status`, `beforebalance`, `afterbalance`, `price`, `orderid`, `modified`, `buyuser`, `selluser`, `processing`, `walletname`, `buytid`, `selltid`, `buywalletname`, `sellwalletname`, `level`, `total`, `partition`, `jackpot`) VALUES (NULL, current_timestamp(), 'Jackpot Level Income From : ".$Direct."', '".$User['ID']."', '', '', '0', 'Jackpot', '5000000000', 'USDT', '', '1', '', '', '".Price()."', 'JackpotLevel_Income :".$User['ID'].":".clean(GMT())."', current_timestamp(), '', '', '', '', '', '', '', '', '', '', '', '')";
			$echo = 'SQL Query Found.'; //echo $SQL;
			global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
		
		}
		else{ $echo = 'User Not Found.'; }
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}





function JackpotUplineOne($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-02
// Input : UserID
// Output : Update [ Upline = 1 ]
	
	$echo = 'Jackpot Upline One Start.';
	if($Q){
		$echo = 'Q Found.';
		
		$SQL="UPDATE `Coinpods_jackpot` SET `upline` = '1' WHERE `user` = '".$Q."';";
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Q Data Not Found.'; }
	return $results;
}




function JackpotUplineTwo($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-02
// Input : UserID
// Output : Update [ Upline = 2 ]
	
	$echo = 'Jackpot Upline Two Start.';
	if($Q){
		$echo = 'Q Found.';
		
		$SQL="UPDATE `Coinpods_jackpot` SET `upline` = '2' WHERE `user` = '".$Q."';";
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Q Data Not Found.'; }
	return $results;
}








function PendingJackpotLevel($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-02
// Input : 
// Output : Pending Users
	
	$echo = 'Pending Jackpot Level Start.';
	$SQL = "SELECT * FROM `Coinpods_jackpot` WHERE `upline` = '0' LIMIT 1;";
	$echo = 'SQL Found.';
	
	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	if($ts){ return $ts; }
	$echo = 'return good working.';

}







//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function JackpotWorkerDirectZero($Q=null){
// Developer : Pawan Kumar
// Date : 2024-07-09
// Input : 
// Output : UPDATE
	
	$SQL="UPDATE `Coinusers` SET `TodayJackpotActiveDirect` = '0'";
	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	return $results;

}





function JackpotWorkerIncomes($Q=null){
// Developer : Pawan Kumar
// Date : 2024-07-09
// Input : Direct
// Output : Transaction Create Jackpot Worker Income
	
	$Output=0;
	$echo = 'Jackpot Worker Income System Start.'; 
	if(is_array($Q)){ $Direct=$Q['direct']; $Amount=$Q['amount']; }
	$echo = 'Is Array Data Found.'; 

	if($Direct or $Amount){
	$echo = 'Direct And Amount Data Found.';
		
		$JackpotWorker=JackpotWorker($Direct);
		if($JackpotWorker){
		$echo = 'Jackpot Worker Data Found.';
			
			foreach($JackpotWorker as $Jackpot){
			$echo = 'Foreach Good Working.';
				
				if($Jackpot['ID']){
				$echo = 'Jackpot Worker User Found.';
					
					$Array=array(
						'user'=>$Jackpot['ID'],
						'amount'=>$Amount
					);
					$JackpotWorkerIncome=JackpotWorkerIncome($Array);
					if($JackpotWorkerIncome){ $Output = 1; }
				
				}
			}
		}
	}
	return $Output;
	echo $echo;
}





function JackpotWorkerIncome($Q=null){
// Developer : Pawan Kumar
// Date : 2024-07-09
// Input : UserID, Amount
// Output : INSERT
	
	$echo = 'Jackpot Worker Income Transaction Start.';
	if(is_array($Q)){ $UserID=$Q['user']; $Amount=$Q['amount']; }
	
	if($UserID and $Amount){
	$echo = 'UserID And Amount Found.';
		
		$SQL="INSERT INTO `Coinpods_transaction`(`id`, `created`, `name`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `filled`, `status`, `beforebalance`, `afterbalance`, `price`, `orderid`, `modified`, `buyuser`, `selluser`, `processing`, `walletname`, `buytid`, `selltid`, `buywalletname`, `sellwalletname`, `level`, `total`, `partition`, `jackpot`) VALUES (NULL, current_timestamp(), 'Jackpot Worker Income By Manager', '".$UserID."', '', '', '0', 'Jackpot', '".p2d($Amount)."', 'USDT', '', '1', '', '', '".Price()."', 'JackpotWorker_Income :".$UserID.":".clean(GMT())."', current_timestamp(), '', '', '', '', '', '', '', '', '', '', '', '')";
		$echo = 'SQL Query Found.'; //echo $SQL.'<br><br>';
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}







function JackpotWorker($Q=null){
// Developer : Pawan Kumar
// Date : 2024-07-09
// Input : Direct
// Output : Total Count Users By Direct
	
	if($Q){
		
		if($Q <= 9){ $SQL="SELECT `ID` FROM `Coinusers` WHERE `TodayJackpotActiveDirect` = '".$Q."'"; }
		elseif($Q >= 10){ $SQL="SELECT `ID` FROM `Coinusers` WHERE `TodayJackpotActiveDirect` >= '".$Q."';"; } //echo $SQL;
		$echo = 'SQL Query Found.';
		
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		if($ts){ return $ts; }
	
	}
	else{ $echo = 'Q Data Not Found.'; }
}

function JackpotWorkerSets($Q=null){
// Developer : Pawan Kumar
// Date : 2024-07-09
// Input : Direct
// Output : Total Count Users By Direct
	
	if($Q){
		
		if($Q <= 9){ $SQL="SELECT COUNT(`ID`) FROM `Coinusers` WHERE `TodayJackpotActiveDirect` = '".$Q."'"; }
		elseif($Q >= 10){ $SQL="SELECT COUNT(`ID`) FROM `Coinusers` WHERE `TodayJackpotActiveDirect` >= '".$Q."';"; } //echo $SQL;
		$echo = 'SQL Query Found.';
		
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		if($ts){ return $ts[0]['COUNT(`ID`)']; }
	
	}
	else{ $echo = 'Q Data Not Found.'; }
}



function PendingJackpotWorkerUser($Q=null){
	
	$SQL="SELECT * FROM `Coinusers` WHERE `TodayJackpotActiveDirect` != 0";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}	
	return $ps;

}





function JackpotWorkerDirectUpdate($Q=null){
// Developer : Pawan Kumar
// Date : 2024-07-09
// Input :
// Output : UPDATE
	
	$PendingTodayJackpotActiveUsers = PendingTodayJackpotActiveUsers();
	if($PendingTodayJackpotActiveUsers){
		foreach($PendingTodayJackpotActiveUsers as $PTJAU){
			
			if($PTJAU){
				
				$SQL="UPDATE `Coinusers` SET `TodayJackpotActiveDirect` = '".$PTJAU['Total_Direct']."' WHERE `userid` = '".$PTJAU['referby']."'";
				global $DB; $aa=0; $results = mysqli_query($DB, $SQL);
			
			}			
		}		
	}
	return $results;
}





function PendingTodayJackpotActiveUsers($Q=null){
// Developer : Pawan Kumar
// Date : 2024-07-09
// Input :
// Output : Today total jackpot active users
	
	$Today_Date = date("Y-m-d");
	$SQL="SELECT COUNT(`ID`) as 'Total_Direct', `referby` FROM `Coinusers` WHERE `jackpotactive` != 0 AND `jackpotactive` >= '".$Today_Date."%' GROUP BY `referby`;"; 
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}	
	return $ps;

}





?>