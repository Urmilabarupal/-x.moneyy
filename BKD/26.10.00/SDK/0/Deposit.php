<?php


function SellAndConvertClosing($Q=null){
	// Developer : Pawan Kumar
	// Date : 2026-05-31
	// Input : Null
	// Output : True & False 

	$SQL="UPDATE `Coinusers` SET `TotalDeposit2024`='0', `sell_status`='0', `convert_status`='0'";
	global $DB; $aa=0; $ts=[]; $results = mysqli_query($DB, $SQL);	
	
	return $results;

}


function SellAndConvertActive($Q=null){
	// Developer : Pawan Kumar
	// Date : 2026-05-15
	// Input : Userid
	// Output : True & False 
	$Output=0;
	if($Q){

		$User = user($Q);
		if($User['TotalDeposit2024'] >= 50000000000){

			$SellAndConvertStatusUpdate=SellAndConvertStatusUpdate($Q);
			if($SellAndConvertStatusUpdate){

				$echo = 'Sell And Convert Activation Success.'; 
				$Output=1;

			}
			else{ $echo = 'Sell And Convert Activation Failed.'; }
		}
		else{ $echo = 'Self Deposit Of 50 USDT Is Not Completed For This ID : '.$Q; }
	}
	else{ $echo = 'Userid Not Found.'; }
	return $Output;
}


function SellAndConvertStatusUpdate($Q=null){
	// Developer : Pawan Meghwal
	// Date : 2026-05-15
	// Input : Userid
	// Output : UPDATE

	$SQL="UPDATE `Coinusers` SET `sell_status`='1', `convert_status`='1' WHERE `TotalDeposit2024` >= 50000000000";
	global $DB; $aa=0; $ts=[]; $results = mysqli_query($DB, $SQL);	

	return $results;
}




function DepositNew($Q=null){

	if(is_array($Q)){ $InsertID=$Q['id']; $UserID=$Q['user']; $Hash=$Q['hash']; $Amount=$Q['amount']; $CCC=$Q['ccc']; $BeforeBalance=$Q['beforebalance']; $AfterBalance=$Q['afterbalance']; $Orderid=$Q['orderid']; $WalletName=$Q['walletname']; }
	if($UserID and $Hash and $Amount and $CCC and $Orderid){

		$SQL =" INSERT INTO `Coinpods_deposit` ( `id`, `created`, `name`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `filled`, `status`, `beforebalance`, `afterbalance`, `price`, `orderid`, `modified`, `buyuser`, `selluser`, `processing`, `walletname`, `buytid`, `selltid`, `buywalletname`, `sellwalletname`, `level`, `total`, `partition`, `jackpot`, `feature_meta` ) VALUES ( '".$InsertID."', '".GMT()."', 'Deposit:".$Hash."', '".$UserID."', '', '', '1', 'Deposit', '".$Amount."', '".$CCC."', '0', '1', '".$BeforeBalance."', '".$AfterBalance."', '0', '".$Orderid."', '".GMT()."', '0', '0', '0', '".$WalletName."', '0', '0', '', '', '0', '".$Amount."', '0', '0', '' );";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		return $results;

	}
}




function Deposit($Q=null){
	//Developer : Pawan kumar
	//Date : 2024/03/04
	//Input : Transaction ID
	//Output : Transaction ID details.

	$SQL="SELECT * FROM `Coinpods_transaction` WHERE `id` = '".$Q."'";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}

	return $ts;

}



function Deposits($Q=null){
	//Developer : Pawan Kumar
	//Date : 2024/03/04
	//Input : 
	//Output : Total transactions for how many users have been deposited by the manager.

	$SQL="SELECT * FROM `Coinpods_transaction` WHERE `name` = 'DepositByManager' AND `ttype` = 'Deposit' AND `status` = '1' ORDER BY `id` DESC;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}

	return $ts;
}




function DepositToWallet($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024/03/04
	// Input :
	// Output : Add Balance to Wallet from Transaction(Deposit)

	import('Deposit'); $Deposit_Object = new Deposit();
	$Output=0;	
	$PendingDeposits=PendingDeposits($Q);
	if($PendingDeposits){
		foreach($PendingDeposits as $PD){	
			$UserID=$PD['user'];

			if($PD['walletname']=='mainwallet'){

				if(strtolower($PD['ccc'])=='uxdt'){ $PD['ccc']='USDT'; }
				else{ $PD['ccc']=$PD['ccc']; }


				if($UserID){
					if(AddToMainWallet(array( 'user'=>$UserID, 'ccc'=>$PD['ccc'], 'network'=>$PD['network'], 'amount'=>$PD['amount'] ))){
						Balance1Transaction($PD['id']);
						DirectThisMonthDepositUpdate($UserID);
						$Array=['user'=>$UserID, 'amount'=>$PD['amount']];
						$Deposit_Object->Deposit___DepositUser_MetaUpdate($Array); unset($Array);
					}
					else{ Balance2Transaction($PD['id']); }
				}
				else{ Balance2Transaction($PD['id']); }

			}
			elseif($PD['walletname']=='Jackpot'){

				if($UserID){
					if(AddToJackpotWallet(array( 'user'=>$UserID, 'ccc'=>$PD['ccc'], 'network'=>$PD['network'], 'amount'=>$PD['amount'] ))){
						Balance1Transaction($PD['id']);
						DirectThisMonthDepositUpdate($UserID);
						$Array=['user'=>$UserID, 'amount'=>$PD['amount']];
						$Deposit_Object->Deposit___DepositUser_MetaUpdate($Array); unset($Array);
					}
					else{ Balance2Transaction($PD['id']); }
				}
				else{ Balance2Transaction($PD['id']); }

			}
			elseif($PD['walletname']=='funding'){

				if($UserID){
					if(AddToFunding(array( 'user'=>$UserID, 'ccc'=>$PD['ccc'], 'network'=>$PD['network'], 'amount'=>$PD['amount'] ))){
						Balance1Transaction($PD['id']);
						DirectThisMonthDepositUpdate($UserID);
						$Array=['user'=>$UserID, 'amount'=>$PD['amount']];
						$Deposit_Object->Deposit___DepositUser_MetaUpdate($Array); unset($Array);
					}
					else{ Balance2Transaction($PD['id']); }
				}
				else{ Balance2Transaction($PD['id']); }

			}
			elseif($PD['walletname']=='slot'){

				if($UserID){
					if(AddToSlotWallet(array( 'user'=>$UserID, 'ccc'=>$PD['ccc'], 'network'=>$PD['network'], 'amount'=>$PD['amount'] ))){
						Balance1Transaction($PD['id']); 
						DirectThisMonthDepositUpdate($UserID);
						$Array=['user'=>$UserID, 'amount'=>$PD['amount']];
						$Deposit_Object->Deposit___DepositUser_MetaUpdate($Array); unset($Array);
					}
					else{ Balance2Transaction($PD['id']); }
				}
				else{ Balance2Transaction($PD['id']); }

			}
			else{

				if($UserID){
					if(AddToMainWallet(array( 'user'=>$UserID, 'ccc'=>$PD['ccc'], 'network'=>$PD['network'], 'amount'=>$PD['amount'] ))){
						Balance1Transaction($PD['id']);
						DirectThisMonthDepositUpdate($UserID);
						$Array=['user'=>$UserID, 'amount'=>$PD['amount']];
						$Deposit_Object->Deposit___DepositUser_MetaUpdate($Array); unset($Array);
					}
					else{ Balance2Transaction($PD['id']); }
				}
				else{ Balance2Transaction($PD['id']); }

			}
		}
	}
}






function DepositManager($Q=null){
	//Developer : Pawan Kumar
	//Date : 2024/03/04
	//Input : UserID, Amount, CCC, Wallet Type
	//Output : Jab Manager Deposit krta hai to transaction create krta hat.

	if(is_array($Q)){ $UserID=$Q['user']; $Amount=$Q['amount']; $CCC=$Q['ccc']; $WT=$Q['WalletType']; }

	if($UserID and $Amount and $CCC and $WT){

		$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `walletname`) VALUES (NULL, 'DepositByManager', current_timestamp(), current_timestamp(), 'DepositByManager:".$UserID.GMT()."', '".$UserID."', '', '', '0', 'Deposit', '".p2d($Amount)."', '".$CCC."', '1', '".$WT."');";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);

	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}




?>