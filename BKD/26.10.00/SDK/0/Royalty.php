<?php


function JackpotSetIncomeToWallet($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-03
// Input :
// Output : Royalty Income Add To Wallet
	
$Output=0;
	$PendingJackpotSetIncome=PendingJackpotSetIncome($Q);
	if($PendingJackpotSetIncome){
		foreach($PendingJackpotSetIncome as $Ps){
			//print_r($Ps['user']);
			if(AddToFunding(array( 'user'=>$Ps['user'], 'ccc'=>strtolower($Ps['ccc']), 'amount'=>$Ps['amount'] ))){
				Balance1Transaction($Ps['id']);
			}
			else{ Balance2Transaction($Ps['id']); }
		}
	}	
	return $Output;
}








function PendingJackpotSetIncome($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-03
// Input :
// Output : Jackpot Set Income Pending Users

	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `ttype`='JackpotSet' AND `balance`='0' AND `user`='".$Q."';"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `ttype`='JackpotSet' AND `balance`='0';"; }
	
	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	if($ts){ return $ts; }

}








function JackpotSetIncomes($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-03
// Input : Minimum, Maximum, Amount
// Output : Transaction Create Royalty Income
	
	$Output=0;
	$echo = 'Jackpot Set Income System Start.'; 
	if(is_array($Q)){ $Minimum=$Q['minimum']; $Maximum=$Q['maximum']; $Amount=$Q['amount']; }
	$echo = 'Is Array Data Found.'; 
	
	if($Minimum or $Maximum or $Amount or 1){
	$echo = 'Minimum And Maximum And Amount Data Found.';
		
		$Royalty2=Royalty2(array('minimum'=>$Minimum, 'maximum'=>$Maximum));
		if($Royalty2){
		$echo = 'Royalty2 Data Found.';
			
			foreach($Royalty2 as $Royalty){
			$echo = 'Foreach Good Working.';
				
				if($Royalty['user']){
				$echo = 'Royalty User Found.';
					
					$Array=array(
						'user'=>$Royalty['user'],
						'amount'=>$Amount
					);
					
					$JackpotSetIncome=JackpotSetIncome($Array);
					if($JackpotSetIncome){ $Output = 1; }
				
				}
			}
		}
	}
	return $Output;
	//echo $echo;
}




function JackpotSetIncome($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-03
// Input : UserID, Amount
// Output : INSERT
	
	$echo = 'Jackpot Set Income Transaction Start.';
	if(is_array($Q)){ $UserID=$Q['user']; $Amount=$Q['amount']; }
	
	if($UserID and $Amount){
	$echo = 'UserID And Amount Found.';
		$Fundings=Fundings($UserID)['usdt'];
		
		$BeforeBalance=$Fundings;
		$AfterBalance=$BeforeBalance+p2d($Amount);
		
		$SQL="INSERT INTO `Coinpods_transaction`(`id`, `created`, `name`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `filled`, `status`, `beforebalance`, `afterbalance`, `price`, `orderid`, `modified`, `buyuser`, `selluser`, `processing`, `walletname`, `buytid`, `selltid`, `buywalletname`, `sellwalletname`, `level`, `total`, `partition`, `jackpot`) VALUES (NULL, current_timestamp(), 'Jackpot Set Income By Manager', '".$UserID."', '', '', '0', 'Jackpot', '".p2d($Amount)."', 'USDT', '', '1', '".$BeforeBalance."', '".$AfterBalance."', '".Price()."', 'JackpotSet_Income :".$UserID.":".clean(GMT())."', current_timestamp(), '', '', '', '', '', '', '', '', '', '', '', '')";
		$echo = 'SQL Query Found.';  //echo $SQL.'<br><br>';
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}







function Royalty2($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-03
// Input : Minimum And Maximum
// Output : Minimum And Maximum By User Information
	
	$echo = 'Royalty System Start.'; 
	if(is_array($Q)){ $Minimum=$Q['minimum']; $Maximum=$Q['maximum']; }
	$echo = 'Is Array Data Found.'; 
	
	if($Minimum or $Maximum or 1){
	$echo = 'Minimum And Maximum Data Found.';
		
		if(!$Minimum){ $Minimum = 0; }
		if(!$Maximum){ $Maximum = 0; }
		
		if($Minimum and $Maximum){ $SQL="SELECT `user` FROM `Coinpods_jackpot` WHERE `total` >= '".p2d($Minimum)."' AND `total` <= '".p2d($Maximum)."';"; }
		elseif($Minimum){ $SQL="SELECT `user` FROM `Coinpods_jackpot` WHERE `total` >= '".p2d($Minimum)."';"; }
		else{ $SQL="SELECT `user` FROM `Coinpods_jackpot` WHERE `total` >= '".p2d($Minimum)."' AND `total` <= '".p2d($Maximum)."';"; } //echo $SQL;
		$echo = 'SQL Query Found.';
		
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		if($ts){ return $ts; }
	
	}
	else{ $echo = 'Minimum And Maximum Data Not Found.'; }
	//echo $echo;
	
}












function Royalty1($Q=null){
// Developer : Pawan Kumar
// Date : 2024-05-02
// Input : minimum, maximum
// Output : Total Count Users By Minimum and Maximum Amount.
	
	$echo = 'Royalty System Start.'; 
	if(is_array($Q)){ $Minimum=$Q['minimum']; $Maximum=$Q['maximum']; }
	$echo = 'Is Array Data Found.'; 
	
	if($Minimum or $Maximum or 1){
	$echo = 'Minimum And Maximum Data Found.';
		
		if(!$Minimum){ $Minimum = 0; }
		if(!$Maximum){ $Maximum = 0; }
		
		if($Minimum and $Maximum){ $SQL="SELECT COUNT(`id`) FROM `Coinpods_jackpot` WHERE `total` >= '".p2d($Minimum)."' AND `total` <= '".p2d($Maximum)."';"; }
		elseif($Minimum){ $SQL="SELECT COUNT(`id`) FROM `Coinpods_jackpot` WHERE `total` >= '".p2d($Minimum)."';"; }
		else{ $SQL="SELECT COUNT(`id`) FROM `Coinpods_jackpot` WHERE `total` >= '".p2d($Minimum)."' AND `total` <= '".p2d($Maximum)."';"; } //echo $SQL;
		$echo = 'SQL Query Found.';
		
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		if($ts){ return $ts[0]['COUNT(`id`)']; }
	
	}
	else{ $echo = 'Minimum And Maximum Data Not Found.'; }
	//echo $echo;
}


?>