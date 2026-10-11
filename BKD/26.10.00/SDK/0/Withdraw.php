<?php



function DepositsAmountUpdate($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-11-07
	// Input : Userid
	// Output : Main Function Jo XAH Deposit Ki Amount Ko Update Karta Hai. Coinusers Table Ke XAH Column Me.

	$echo = 'Deposits Amount Update Function Start.'; 
	$Output=0;
	$DepositSuccessTransactions=DepositSuccessTransactions($Q);
	if($DepositSuccessTransactions){
		$echo = 'Deposit Pending Transactions Found.'; 

		foreach($DepositSuccessTransactions as $Single){
			$echo = 'Foreach Good Working.'; 

			if($Single){
				$echo = 'Single User Found.'; 

				$WithdrawAmountRemove=WithdrawAmountRemove(['user'=>$Single['user'], 'amount'=>$Single['amount']]);
				if($WithdrawAmountRemove){

					XAHPendingStatusUpdate(['id'=>$Single['id'], 'status'=>1]);
					$Output=1; $echo = 'Success'; 

				}
				else{ 
					XAHPendingStatusUpdate(['id'=>$Single['id'], 'status'=>2]);
					$echo = 'Deposit Amount Not Update.'; 
				}
			}
			else{ $echo = 'Single Transaction Not Found.'; }
		}
	}
	else{ $echo = 'Pending Transaction Not Found.'; }
	return $Output;
}


function WithdrawAmountRemove($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-11-07
	// Input : Userid And Amount
	// Output : Coinusers Table Ke XAH Column Ki Amount Ko Minus Karta Hai.
	
	
	$echo = 'Withdraw Amount Remove Function Start.';
	if(is_array($Q)){ $Userid=$Q['user']; $Amount=$Q['amount']; }
	if($Userid and $Amount){
		$echo = 'Userid And Amount Found.'; 

		$SQL="UPDATE `Coinusers` SET `XAH`=`XAH`-'".$Amount."' WHERE `ID` = '".$Userid."'";
		$echo = 'SQL Created.';
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		$echo = 'Success'; 

	}
	else{ $echo = 'Data Empty! Userid And Amount Not Found.'; }
	return $results;
}


function DepositSuccessTransactions($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-11-07
	// Input : UserID
	// Output : Deposit Ki Success Transactions Select Karta Hai.

	$echo = 'Deposit Success Transactions Function Start.'; 
	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `ttype` = 'Deposit' AND `ccc` = 'ccc' AND `status` = 1 AND `XAHStatus` = 0 ORDER BY `id` DESC"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `ttype` = 'Deposit' AND `ccc` = 'ccc' AND `status` = 1 AND `XAHStatus` = 0 ORDER BY `id` DESC"; }
	$echo = 'SQL Created.'; 

	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$echo = 'Success'; 
	return $ts;		

}






function WithdrawsAmountUpdate($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-11-04
	// Input : Userid
	// Output : Main Function Jo XAH Withdraw Ki Amount Ko Update Karta Hai. Coinusers Table Ke XAH Column Me.

	$echo = 'Withdraws Amount Update Function Start.'; 
	$Output=0;
	$WithdrawSuccessTransactions=WithdrawSuccessTransactions($Q);
	if($WithdrawSuccessTransactions){
		$echo = 'Withdraw Pending Transactions Found.'; 

		foreach($WithdrawSuccessTransactions as $Single){
			$echo = 'Foreach Good Working.'; 

			if($Single){
				$echo = 'Single User Found.'; 

				$WithdrawAmountAdd=WithdrawAmountAdd(['user'=>$Single['user'], 'amount'=>$Single['amount']]);
				if($WithdrawAmountAdd){

					XAHPendingStatusUpdate(['id'=>$Single['id'], 'status'=>1]);
					$Output=1; $echo = 'Success'; 

				}
				else{ 
					XAHPendingStatusUpdate(['id'=>$Single['id'], 'status'=>2]);
					$echo = 'Withdraw Amount Not Update.'; 
				}
			}
			else{ $echo = 'Single Transaction Not Found.'; }
		}
	}
	else{ $echo = 'Pending Transaction Not Found.'; }
	return $Output;
}


function XAHPendingStatusUpdate($Q){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-11-04
	// Input : Transaction Id And Status
	// Output : Transaction Id Ke According Status Update Jo Input Se Aaya Hai.

	$echo = 'XAH Pending Status Update Function Start.';
	if(is_array($Q)){ $ID=$Q['id']; $Status=$Q['status']; }
	if($ID and $Status){
		$echo = 'Transaction Id And Status Found.'; 

		$SQL="UPDATE `Coinpods_transaction` SET `XAHStatus`='".$Status."' WHERE `id` = '".$ID."'";
		$echo = 'SQL Created.'; 
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		$echo = 'Status Update Success.'; 

	}
	else{ $echo = 'Transaction Id And Status Not Found.'; }
	return $results;
}



function WithdrawAmountAdd($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-11-04
	// Input : Array (Userid, Amount)
	// Output : Coinusers Table Ke XAH Column Me XAH Withdraw Ki Amount Ko Update Karta Hai.

	$echo = 'Withdraw Amount Add Function Start.';
	if(is_array($Q)){ $Userid=$Q['user']; $Amount=$Q['amount']; }
	if($Userid and $Amount){
		$echo = 'Userid And Amount Found.'; 

		$SQL="UPDATE `Coinusers` SET `XAH`=`XAH`+'".$Amount."' WHERE `ID` = '".$Userid."'";
		$echo = 'SQL Created.';
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		$echo = 'Success'; 

	}
	else{ $echo = 'Data Empty! Userid And Amount Not Found.'; }
	return $results;
}




function WithdrawSuccessTransactions($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-11-04
	// Input : UserID
	// Output : Withdraw Ki Success Transactions Select Karta Hai.

	$echo = 'Withdraw Success Transactions Function Start.'; 
	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `ttype` = 'Withdraw' AND `ccc` = 'ccc' AND `status` = 1 AND `XAHStatus` = 0 ORDER BY `id` DESC"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `ttype` = 'Withdraw' AND `ccc` = 'ccc' AND `status` = 1 AND `XAHStatus` = 0 ORDER BY `id` DESC"; }
	$echo = 'SQL Created.'; 

	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$echo = 'Success'; 
	return $ts;		

}

?>