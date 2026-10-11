<?php
// Transaction Types : Deposit, Withdraw, Buy, Sell, Send, Receive, Fee, Stake, Unstake, Transfer, Level

function SamePriceSellOrderLimit($Q=null){
	// Developer : Sahiram Nayak
	// Date : 2026-06-11
	// Input : null
	// Output : price IN Sell Orders	
	$Date=date('Y-m-d');
	
	$SQL="SELECT SUM(`oca`)/1000000000 AS 'amount' , `price` AS 'price' FROM `Coinpods_transaction` WHERE `id` >= 1092054677 AND `ttype` = 'Sell' AND `status` IN(0,1) AND `created` LIKE '%".$Date."%' GROUP BY `price` HAVING SUM(`oca`) < 10000000000000 ORDER BY `amount` ASC LIMIT 1;";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	return $ts[0]['price'];
	
	
}





function SamePriceOrder($Q=null){
	// Developer : Pawan Meghwal
	// Date : 2026-05-15
	// Input : Price
	// Output : USDT Amount IN Sell Orders

	if($Q){
		if(i['branch']){ $Branch = null; $Branch = " AND `branch` = '".i['branch']."'";}

		$SQL="SELECT SUM(`oca`)/1000000000 AS 'amount' FROM `Coinpods_transaction` WHERE `id` >= 1092054677 AND `price` = '".$Q."' AND `ttype` = 'Sell' AND `status` IN(0,1)".$Branch." ";
		global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}

	}
	else{ $echo = 'Userid Not Found.'; }
	return $ts[0]['amount'];
}

function SellOrderPending($Q=null){
	// Developer : Pawan Meghwal
	// Date : 2026-05-15
	// Input : Userid
	// Output : Array

	if($Q){

		$SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `ttype` LIKE 'Sell' AND `status` = 0 ORDER BY `price` ASC";
		global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++; }} 
		else{$ts = null;}

	}
	else{ $echo = 'Userid Not Found.'; }
	return $ts;
}


function Before_After_BalanceUpdate($Q=null){ 

	if($Q){ $Beforebalance = $Q['beforebalance']; $Afterbalance = $Q['afterbalance']; $TransactionID = $Q['id']; }
	else{ $echo = "Data Not Found."; }

	if($TransactionID){ 
		$SQL = "UPDATE `Coinpods_transaction` SET `beforebalance` = '".$Beforebalance."' , `afterbalance`= '".$Afterbalance."' WHERE `id` = '".$TransactionID."'";
		global $DB; $results = mysqli_query($DB, $SQL);  
	}
	else{ $echo = "TID not Found."; }

}


function TransactionNew($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-10-02

	if(is_array($Q)){ $Userid=$Q['user']; $Name=$Q['name']; $CCC=$Q['ccc']; $Amount=$Q['amount']; $Ttype=$Q['ttype']; $OrderID=$Q['orderid']; $Balance=$Q['balance']; }
	if($Userid and $CCC and $Amount and $Ttype and $OrderID){
		if($Balance==1){$Balance=1;} else{$Balance=0;}

		$SQL="INSERT INTO `Coinpods_transaction`(`id`, `created`, `name`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `filled`, `status`, `beforebalance`, `afterbalance`, `price`, `orderid`, `modified`, `buyuser`, `selluser`, `processing`, `walletname`, `buytid`, `selltid`, `buywalletname`, `sellwalletname`, `level`, `total`, `partition`, `jackpot`) VALUES (NULL, current_timestamp(), '".$Name."', '".$Userid."', '', '', '".$Balance."', '".$Ttype."', '".p2d($Amount)."', '".$CCC."', '', '1', '".$BeforeBalance."', '".$AfterBalance."', '".Price()."', '".$OrderID."', current_timestamp(), '', '', '', '', '', '', '', '', '', '', '', '')"; //echo $SQL.'<br><br>';
		global $DB; $results = mysqli_query($DB, $SQL); $Output=mysqli_insert_id($DB);
		return $results;

	}
}







function ManagerWithdrawRefund($Q=null){

	if(is_array($Q)){ $ID=$Q['id']; $Status=$Q['status'];  }

	if($ID && $Status){
		if($Status=='disable'){ $SV=0; }
		else{ if($Status){  $SV=$Status; } }

		$SQL = "UPDATE `Coinpods_transaction` SET `status` = '".$SV."' WHERE `ttype` = 'Withdraw' AND `Coinpods_transaction`.`id` = '".$ID."';";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	}

	return $results;
}


function SpotFundingWalletData($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-07-18
	// Input : Spot, Funding
	// Oooutput : Spot And Funding Wallet Data.

	if(!$Q){ $Q='Spot'; }
	if($Q=='Spot'){ $DESC = 'Coinpods_wallet'; }
	elseif($Q=='Funding'){ $DESC = 'Coinpods_funding'; }
	if($DESC){

		$SQL="SELECT `Coinusers`.`ID`, `Coinpods_wallet`.`ccc` / 1000000000 AS 'Spot_Wallet_Amount', `Coinpods_funding`.`ccc` / 1000000000 AS 'Funding_Wallet_Amount' FROM `Coinusers` JOIN `Coinpods_wallet` ON `Coinpods_wallet`.`user` = `Coinusers`.`ID` JOIN `Coinpods_funding` ON `Coinpods_funding`.`user` = `Coinusers`.`ID` ORDER BY `$DESC`.`ccc` DESC LIMIT 111;";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		return $ts;		

	}
}



function BuyPartitionTradeToWallet($Q=null){
	//Add Balance to Wallet from Transaction(Buy)
	$Output=0;	
	$PendingBuyPartitionTradeTransaction=PendingBuyPartitionTradeTransaction($Q);	
	if($PendingBuyPartitionTradeTransaction){ 
		foreach($PendingBuyPartitionTradeTransaction as $PBT){

			//print_r($PBT['user']);

			$Transaction = Transaction($PBT['name']);
			if($Transaction['status']==5 or $Transaction['status']==4){ 
				$Amount=0; $Amount=$PBT['amount']*$Transaction['price'];

				//$Amount=0; $Amount=$PBT['amount']-$PBT['filled'];

				if($Transaction['walletname'] == 'funding'){

					if(AddToFunding(array( 'user'=>$Transaction['user'], 'ccc'=>strtolower($PBT['occ']), 'amount'=>$Amount ))){
						Status5Transaction($PBT['id']);
					}
					else{ Status3Transaction($PBT['id']); }

				}
				elseif($Transaction['walletname'] == 'jackpot'){

					if(AddToJackpotWallet(array( 'user'=>$Transaction['user'], 'ccc'=>strtolower($PBT['occ']), 'amount'=>$Amount ))){
						Status5Transaction($PBT['id']);
					}
					else{ Status3Transaction($PBT['id']); }

				}
				elseif($Transaction['walletname'] == 'spot'){

					if(AddToWallet(array( 'user'=>$Transaction['user'], 'ccc'=>strtolower($PBT['occ']), 'amount'=>$Amount ))){
						Status5Transaction($PBT['id']);
					}
					else{ Status3Transaction($PBT['id']); }

				}
				elseif($Transaction['walletname'] == 'mainwallet'){

					if(AddToMainWallet(array( 'user'=>$Transaction['user'], 'ccc'=>strtolower($PBT['occ']), 'amount'=>$Amount ))){
						Status5Transaction($PBT['id']);
					}
					else{ Status3Transaction($PBT['id']); }

				}
				else{

					if(AddToWallet(array( 'user'=>$Transaction['user'], 'ccc'=>strtolower($PBT['occ']), 'amount'=>$Amount ))){
						Status5Transaction($PBT['id']);
					}
					else{ Status3Transaction($PBT['id']); }

				}
			}
		}
	}	
	return $Output;
}









function PendingBuyPartitionTradeTransaction($Q=null){

	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `buyuser` = '".$Q."' AND `balance` = '1' AND `status` = 4 AND `ttype` = 'PartitionTrade';"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = '1' AND `status` = 4 AND `ttype` = 'PartitionTrade';"; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		

}






function BuyLevel($Q=null){
	// Developer : Pawan Kumar

	$T = Transaction($Q);
	if($T){

		//$Percent = Percent($T['amount'],8);
		$Amount = $T['amount']*8/100;

		$U=user($T['user']);
		if($U){

			$User=UserByUserID($U['referby']);
			if($User){

				$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`) VALUES (NULL, 'Level".$aa." Income from Deposit', current_timestamp(), current_timestamp(), 'DepositLevel:-TR:".$T['id']."', '".$User['ID']."', '', '', '0', 'Level', '".$Amount."', 'usdt', '1', '');"; //echo $SQL;
				global $DB; $results = mysqli_query($DB, $SQL); $Output=mysqli_insert_id($DB);

				return $results;

			}
		}
	}
}



function BuyLevels(){

	$PTs = PendingBuyLevelTransaction();
	if($PTs){

		foreach($PTs as $T){
			if($T){

				$BuyLevel=BuyLevel($T['id']);
				if($BuyLevel){ Level1Transaction($T['id']); }
				else{ Level2Transaction($T['id']); }

			}	
		}
	}
}



function PendingBuyLevelTransaction($Q=null){
	//Developer : Pawan Kumar
	//Date : 2024/02/29
	//Input :
	//Output : Type == Buy, Status == 1, Level == 0 ( Transaction select krta hai. )

	//$SQL="SELECT * FROM `Coinpods_transaction` WHERE `ttype` = 'Buy' AND `status` = '1' AND `level` = '0' AND `oca` >= 150000000000";
	$SQL="SELECT * FROM `Coinpods_transaction` WHERE `ttype` = 'Deposit' AND `status` = '1' AND `level` = '0' AND `amount` >= 150000000000 AND `ccc` >= 'USDT' AND `created` > '2024-07-20 16:56:04';";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;	

}



function Trade10ToWallet($Q=null){
	//Developer : Pawan Kumar
	//Date : 2024/02/29

	$PT=PendingTrade10Transaction();
	if($PT){
		foreach($PT as $T){

			$Trade=Trade10PercentT($T['id']);
			if($Trade){

				if($Trade['buywalletname'] == 'spot'){

					if(AddToWallet(array( 'user'=>$Trade['buyuser'], 'ccc'=>strtolower($Trade['ccc']), 'amount'=>$Trade['amount'] ))){
						Partition1Transaction($T['id']);
					}
					else{ Partition2Transaction($T['id']); }

				}
				elseif($Trade['buywalletname'] == 'funding'){

					if(AddToFunding(array( 'user'=>$Trade['buyuser'], 'ccc'=>strtolower($Trade['ccc']), 'amount'=>$Trade['amount'] ))){
						Partition1Transaction($T['id']);
					}
					else{ Partition2Transaction($T['id']); }

				}
				elseif($Trade['buywalletname'] == 'jackpot'){

					if(AddToJackpotWallet(array( 'user'=>$Trade['buyuser'], 'ccc'=>strtolower($Trade['ccc']), 'amount'=>$Trade['amount'] ))){
						Partition1Transaction($T['id']);
					}
					else{ Partition2Transaction($T['id']); }

				}
				elseif($Trade['buywalletname'] == 'mainwallet'){

					if(AddToWallet(array( 'user'=>$Trade['buyuser'], 'ccc'=>strtolower($Trade['ccc']), 'amount'=>$Trade['amount'] ))){
						Partition1Transaction($T['id']);
					}
					else{ Partition2Transaction($T['id']); }

				}
			}
		}
	} 
}




function PendingTrade10Transaction($Q=null){
	//Developer : Pawan Kumar
	//Date : 2024/02/29
	//Input :
	//Output : Type == Buy, Status == 1, partition == 0 ( Transaction select krta hai. )

	$SQL="SELECT * FROM `Coinpods_transaction` WHERE `ttype` = 'Buy' AND `status` = '1' AND `partition` = '0'";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;	

}


function Trade10PercentT($Q=null){
	//Developer : Pawan Kumar
	//Date : 2024/02/29
	//Input : Transaction ID
	//Output : Type == Trade, name == Transaction ID ( Transaction select krta hai. )

	$SQL="SELECT * FROM `Coinpods_transaction` WHERE `ttype` = 'PartitionTrade' AND `name` = '".$Q."'";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0];	

}









function TotalTransfer($Q=null){
	//Developer : Pawan Kumar
	//Date : 2024/02/19
	//Input :
	//Output : Hx.money To Hellox.win Total Transfer Amount Ko Sum Krta hai.

	$SQL="SELECT SUM(`amount`) FROM `Coinpods_transaction` WHERE `ttype` = 'TransferWin';";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}

	return $ts[0]['SUM(`amount`)'];

}




function Partition1Transaction($Q=null){
	// Update Transaction status == 1
	if($Q){	
		$SQL="UPDATE `Coinpods_transaction` SET `partition` = '1' WHERE `Coinpods_transaction`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}

function Partition2Transaction($Q=null){
	// Update Transaction status == 2

	if($Q){	
		$SQL="UPDATE `Coinpods_transaction` SET `partition` = '2' WHERE `Coinpods_transaction`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}












function PriceSeAmount($Q=null){
	//Developer : Pawan Kumar
	//Date : 2024/01/20
	//Input : Latest Price
	//Output : Jo price aata hai uss price se amount ko sum kr ke output deta hai.
	if(i['branch']){ $Branch = null; $Branch = " AND `branch` = '".i['branch']."'";}

	if($Q){

		$SQL="SELECT SUM(`oca`) FROM `Coinpods_transaction` WHERE `ttype` = 'Sell' AND `status` IN(1,0) AND `price` = '".$Q."' AND `created` >= '2024-01-26%' ".$Branch.";";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}

		return $ts[0]['SUM(`oca`)'];
	}
}





function LuckyDrawToWallet(){
	$Output=0;
	$PendingLuckyDrawTransactions=PendingLuckyDrawTransactions($Q);
	if($PendingLuckyDrawTransactions){
		foreach($PendingLuckyDrawTransactions as $PLDT){
			//print_r($PLDT['user']);
			if(AddToFunding(array( 'user'=>$PLDT['user'], 'ccc'=>strtolower($PLDT['ccc']), 'amount'=>$PLDT['amount'] ))){
				Balance1Transaction($PLDT['id']);
			}
			else{ Balance2Transaction($PLDT['id']); }
		}
	}	
	return $Output;
}



function PendingLuckyDrawTransactions($Q=null){
	//Developer : Pawan Kumar

	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Win'"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = '0' AND `ttype` = 'Win' AND `status` = '1'"; }
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}











function OrderTotal(){
	//Devloper: Pawan Kumar

	$SQL="SELECT `price` AS `price`, SUM(`amount`) AS `amount`, SUM(`oca`)  AS `oca`, `occ` FROM `Coinpods_transaction` WHERE `ttype` = 'sell' AND `status` = '0' AND `amount`!= `filled` GROUP BY `price` LIMIT 10;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;			
}









function UpdateAfterBalance($Q=null){
	if(is_array($Q)){ $ID=$Q['id']; $Amount=$Q['amount']; }
	if($ID and $Amount){

		global $DB;$aa = 0;
		$SQL = "UPDATE `Coinpods_transaction` SET `afterbalance` = '".$Amount."', `modified` = current_timestamp() WHERE `Coinpods_transaction`.`id` = '".$ID."';"; 
		$results = mysqli_query($DB, $SQL);
		return $results;

	}
}






function SUMOfSellFilled($Q=null){ 
	if(!$Q){$Q='CCC';}

	$GMT=explode(' ',GMT()); $Date=$GMT[0];

	if($Q){	
		global $DB;$aa = 0;
		$SQL = "SELECT SUM(`filled`) FROM `Coinpods_transaction` WHERE `ttype` = 'Sell' AND `ccc` = 'ccc' AND (`status` = '0' OR `status` = '0');"; 
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		if($ts){ 
			return $ts[0]['SUM(`filled`)'];

		}
	}

}



function SUMOfSell($Q=null){ 
	if(!$Q){$Q='CCC';}

	$GMT=explode(' ',GMT()); $Date=$GMT[0];

	if($Q){	
		global $DB;$aa = 0;
		$SQL = "SELECT SUM(`amount`) FROM `Coinpods_transaction` WHERE `ttype` = 'Sell' AND `ccc` = 'ccc' AND (`status` = '0' OR `status` = '0');"; 
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		if($ts){ 
			return $ts[0]['SUM(`amount`)'];

		}
	}

}


function MyPendingOrders($Q=null){

	$SQL="SELECT COUNT(`id`) FROM `Coinpods_transaction` WHERE `status` = '0' AND `ttype` = 'Sell' AND `user` = '".i['id']."';";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){return $ts[0]['COUNT(`id`)'];}

}

function MyTodayOrders($Q=null){ 
	$Today = gmdate("Y-m-d");	
	$SQL="SELECT COUNT(`id`) FROM `Coinpods_transaction` WHERE `user` = '".i['ID']."'  AND `ttype` = 'Sell' AND `created` LIKE '%".$Today."%' ";
	global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){return $ts[0]['COUNT(`id`)'];}

}






function PendingTransferTransactions($Q=null){

	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Transfer'"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'Transfer'"; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}




function PendingSendTransactions($Q=null){

	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Send'"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'Send'"; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}






function PendingRefundTrades($Q=null){	
	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 1  AND `status` = 4  AND `ttype` = 'Trade'  ORDER BY `id` DESC LIMIT 1111"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 1 AND `status` = 4  AND `ttype` = 'Trade'  ORDER BY `id` DESC LIMIT 1111"; }
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}




function RefundTrade($Q=null){
	if($Q){	

		$Trade=Transaction($Q);

		if($Trade){ 




			$TradeAmount=$Trade['amount'];
			$Tax = $TradeAmount*0.401606425705/100;
			$TradeAmount = $TradeAmount+$Tax;



			$TRS = explode(' ', $Trade['orderid']); $TRS=$TRS[0];
			$TRS = explode(':', $TRS);  $TRS=$TRS[1];
			$TRS = explode('-', $TRS); 

			$This=$TRS[0]; $This=explode('=', $This); $This=$This[1];
			$That=$TRS[1]; $That=explode('=', $That); $That=$That[1];






			if(RemoveFromWallet(array( 'user'=>$Trade['buyuser'], 'ccc'=>strtolower($Trade['ccc']), 'amount'=>$Trade['amount'] ))){
				if(RemoveFromWallet(array( 'user'=>$Trade['selluser'], 'ccc'=>strtolower($Trade['occ']), 'amount'=>$Trade['oca'] ))){
					Status5Transaction($Trade['id']);




					$SQL1="UPDATE `Coinpods_transaction` SET `filled` = `filled` - '".$TradeAmount."', `status` = '4'  WHERE `Coinpods_transaction`.`id` = '".$This."';";
					global $DB; $Results = mysqli_query($DB, $SQL1);	
					$SQL2="UPDATE `Coinpods_transaction` SET `filled` = `filled` - '".$TradeAmount."', `status` = '4' WHERE `Coinpods_transaction`.`id` = '".$That."';";
					global $DB; $Resultss = mysqli_query($DB, $SQL2);

					if($Resultss){ /* SellRefundToWallet(); */ }




				}
				else{ Status3Transaction($Trade['id']); }
			}
			else{ Status3Transaction($Trade['id']); }



			echo $This.' '.$TradeAmount.' '.$That.' <br/>';			
		}
		else{ $echo = 'No Trade Found'; }


	}	
}







function RefundTrades($Q=null){

	//Add Balance to Wallet from Transaction(Sell)
	$Output=0;	$Tax=0;
	$TRs=PendingRefundTrades($Q);	
	if($TRs){
		foreach($TRs as $TR){	 

			if(RefundTrade($TR['id'])){
				/*Status5Transaction($TR['id']);*/ $Output++;
			}
			else{ /*Status3Transaction($TR['id']);*/ }
			$Tax=0;
		}	
	}	
	return $Output;

}


















function PendingWithdrawRefundTransactions($Q=null){	
	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 1  AND `status` = 4  AND `ttype` = 'Withdraw' LIMIT 1"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 1 AND `status` = 4  AND `ttype` = 'Withdraw' LIMIT 1"; }
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function WithdrawRefundToWallet($Q=null){

	//Add Balance to Wallet from Transaction(Sell)
	$Output=0;	$Tax=0;
	$TRs=PendingWithdrawRefundTransactions($Q);	
	if($TRs){
		foreach($TRs as $TR){

			$Amount=0; $Amount=$TR['amount'];	
			$Tax = $Amount*11.11111112/100;	
			$Amount = $Amount+$Tax;
			if($Amount>400000000000){ 
				$Amount=$Amount-20000000000; 	
				$Args = [
					'name' => 'Invalid Withdrawal This User : '.$TR['user'].' Of Withdrawal Transaction ID '.$TR['id'], 
					'user' => $TR['user'], 
					'balance' => 1, 
					'ttype' => 'Invalid Withdrawal', 
					'amount' => 20, 
					'ccc' => $TR['ccc'], 
					'filled' => 0, 
					'status' => 1, 
					'beforebalance' => 0, 
					'afterbalance' => 0, 
					'price' => 0, 
					'orderid' => 'Invalid Withdrawal:'.$TR['user'].':'.clean(GMT()), 
					'modified' => GMT(), 
					'created' => GMT(), 
					'buyuser' => $TR['user'], 
					'selluser' => $TR['user'], 
					'processing' => 0, 
					'wallet' => 'spot', 
					'address' => ''
				];

				TransactionNew($Args);
			}
			else{$Amount=$Amount; }


			$User = user($TR['user']);


			if(!empty($User['network']) && strtolower($User['network']) == 'xah') { $TR['ccc']='usdt'; }
			elseif(!empty($User['network']) && strtolower($User['network'])=='bsc'){ $TR['ccc']='usdt'; }
			else{ $TR['ccc']=$TR['ccc'];  }


			$ADDD = '';

			if(strtolower($TR['walletname']) == 'funding'){
				$ADDD = AddToFunding(array( 'user'=>$TR['user'], 'ccc'=>strtolower($TR['ccc']), 'amount'=>$Amount )); 
			}
			else{  $ADDD = AddToWallet(array( 'user'=>$TR['user'], 'ccc'=>strtolower($TR['ccc']), 'amount'=>$Amount )); } 
			 

			if($ADDD){
				Status5Transaction($TR['id']); $Output++;
			}
			else{ Status3Transaction($TR['id']); }
			$Tax=0;
		}	
	}	
	return $Output;

}



function PendingRoyaltyTransactions($Q=null){

	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = '0' AND `ttype` = 'Royalty' LIMIT 111111111"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = '0' AND `ttype` = 'Royalty' LIMIT 1111111111"; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function RoyaltyToWallet($Q=null){
	//Add Balance to Wallet from Transaction(Buy)
	$Output=0;	
	$PendingBuyTransactions=PendingRoyaltyTransactions($Q);	
	if($PendingBuyTransactions){
		foreach($PendingBuyTransactions as $PBT){
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













function MySamePricedOrders($User=null,$Price=null){
	if($User and $Price){
		//$SQL="SELECT COUNT(`id`) FROM `Coinpods_transaction` WHERE `price` = '".$Q."' AND  `status` != '5' AND `ttype` = 'Sell' AND  `created` > '2023-01-24 18:00:00';";
		$SQL="SELECT COUNT(`id`) FROM `Coinpods_transaction` WHERE `price` = '".$Price."' AND  `status` = 1 AND `ttype` = 'Sell' AND `user` = '".$User."' AND  `created` > '2023-12-01 00:00:00';";
		global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		if($ts[0]){return $ts[0]['COUNT(`id`)'];}
	}
}


function SamePricedOrders($Q=null){
	if(i['branch']){ $Branch = null; $Branch = " AND `branch` = '".i['branch']."'";}
	if($Q){
		//$SQL="SELECT COUNT(`id`) FROM `Coinpods_transaction` WHERE `price` = '".$Q."' AND  `status` != '5' AND `ttype` = 'Sell' AND  `created` > '2023-01-24 18:00:00';";
		$SQL="SELECT COUNT(`id`) FROM `Coinpods_transaction` WHERE `price` = '".$Q."' AND  `status` = 0 AND `ttype` = 'Sell' AND  `created` > '2023-01-24 18:00:00' ".$Branch.";";
		global $DB; $aa=0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		if($ts){return $ts[0]['COUNT(`id`)'];}
	}
}




function Processing0Transaction($Q=null){
	if($Q){	
		$SQL="UPDATE `Coinpods_transaction` SET `processing` = '0' WHERE `Coinpods_transaction`.`id` = '".$Q."';";
		global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}

function Processing1Transaction($Q=null){
	if($Q){	
		$SQL="UPDATE `Coinpods_transaction` SET `processing` = '1' WHERE `Coinpods_transaction`.`id` = '".$Q."';";
		global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}






function coin($a=null,$c=null){
	// svg circle stroke-dasharray 264 0 == 100%,  0 264 == 0%
	$s=2.64;$st=264;
	if($a and $c){ 
		$a=p2d($a);
		$m=p2d(min_withdraw($c));
		if($a>=$m){$t=100;}	else{$t=$a*100/$m;} $t=$t*0.777;
		$sd[1]=$t*$s;	$sd[2]=$st-$sd[1];	$coin = number_format($sd[1],0).' '.number_format($sd[2],0);
		return $coin;
	}
	else{return '0 264';}
}


function coin_c($c){
	if($c=='264 0'){$coin_c='gold';}	
	else{$coin_c='';}
	return $coin_c;
}

function racer($a=null,$c=null){
	// coin::after {transform: rotate( 140deg )} -140deg == 0%; 140deg == 100%
	$s=2.80;
	if($a and $c){ 
		$a=p2d($a);
		$m=p2d(min_withdraw($c));
		if($a>=$m){$t=100;}	else{$t=$a*100/$m;}


		$sd=$t*$s;	$sd=$sd-140;
		$racer = number_format($sd,0);
		return 'coin::after {transform: rotate( '.$racer.'deg )}';
	}
	else{return 'coin::after {transform: rotate( -140'.$racer.'deg )}'; }
}






























function PendingRewardTransactions($Q=null){

	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Reward'"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = '0' AND `ttype` = 'Reward' AND `status` = '1'"; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function RewardToWallet($Q=null){
	//Add Balance to Wallet from Transaction(Buy)
	$Output=0;	
	$PendingBuyTransactions=PendingRewardTransactions($Q);	
	if($PendingBuyTransactions){
		foreach($PendingBuyTransactions as $PBT){
			//print_r($PBT['user']);
			if(AddToFunding(array( 'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$PBT['amount'] ))){
				Balance1Transaction($PBT['id']);
			}
			else{ Balance2Transaction($PBT['id']); }
		}	
	}	
	return $Output;
}








function PendingSellRefundTransactions($Q=null){	
	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 1  AND `status` = 4  AND `ttype` = 'Sell'"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 1 AND `status` = 4  AND `ttype` = 'Sell'"; }
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function SellRefundToWallet($Q=null){

	//Add Balance to Wallet from Transaction(Sell)
	$Output=0;	
	$TRs=PendingSellRefundTransactions($Q);	
	if($TRs){
		foreach($TRs as $TR){
			//print_r($PBT['user']);
			$Amount=0; $Amount=$TR['amount']-$TR['filled'];

			if($TR['walletname'] == 'funding'){

				if(AddToFunding(array( 'user'=>$TR['user'], 'ccc'=>strtolower($TR['ccc']), 'amount'=>$Amount ))){
					Status5Transaction($TR['id']);
				}
				else{ Status3Transaction($TR['id']); }
			}
			elseif($TR['walletname'] == 'jackpot'){

				if(AddToFunding(array( 'user'=>$TR['user'], 'ccc'=>strtolower($TR['ccc']), 'amount'=>$Amount ))){
					Status5Transaction($TR['id']);
				}
				else{ Status3Transaction($TR['id']); }
			}
			else{

				if(AddToFunding(array( 'user'=>$TR['user'], 'ccc'=>strtolower($TR['ccc']), 'amount'=>$Amount ))){
					Status5Transaction($TR['id']);
				}
				else{ Status3Transaction($TR['id']); }		

			}



		}	
	}	
	return $Output;

}





function PendingBuyRefundTransactions($Q=null){

	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 1 AND `status` = 4 AND `ttype` = 'Buy'"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = '1'  AND `status` = 4 AND `ttype` = 'Buy' LIMIT 10"; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}



function BuyRefundToWallet($Q=null){
	//Add Balance to Wallet from Transaction(Buy)
	$Output=0;	
	$PendingBuyTransactions=PendingBuyRefundTransactions($Q);	
	if($PendingBuyTransactions){
		foreach($PendingBuyTransactions as $PBT){
			//print_r($PBT['user']);
			$Amount=0; $Amount=$PBT['amount']-$PBT['filled'];

			$Amount=$Amount*$PBT['price'];


			if($PBT['walletname'] == 'funding'){

				if(AddToFunding(array( 'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['occ']), 'amount'=>$Amount ))){
					Status5Transaction($PBT['id']);
				}
				else{ Status3Transaction($PBT['id']); }

			}
			elseif($PBT['walletname'] == 'jackpot'){

				if(AddToJackpotWallet(array( 'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['occ']), 'amount'=>$Amount ))){
					Status5Transaction($PBT['id']);
				}
				else{ Status3Transaction($PBT['id']); }

			}
			elseif($PBT['walletname'] == 'mainwallet'){

				if(AddToMainWallet(array( 'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['occ']), 'amount'=>$Amount ))){
					Status5Transaction($PBT['id']);
				}
				else{ Status3Transaction($PBT['id']); }

			}
			else{

				if(AddToWallet(array( 'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['occ']), 'amount'=>$Amount ))){
					Status5Transaction($PBT['id']);
				}
				else{ Status3Transaction($PBT['id']); }

			}
		}
	}	
	return $Output;
}






function Volume24H($Q=null){ 

	if(!$Q){$Q='CCC';}
	$GMT=explode(' ',GMT()); $Date=$GMT[0];

	if($Q){	

		global $DB;$aa = 0;
		$SQL="SELECT SUM(`amount`) FROM `Coinpods_transaction` WHERE `ccc` = '".$Q."' AND `ttype` IN ('Buy','Sell') AND `created` >= '".$Date."';";
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		if($ts){ 
			return $ts[0]['SUM(`amount`)'];
		}
	}
}





function PendingTradeTransactions($Q=null){

	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Trade'"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'Trade'"; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}








/*


function TradeToWallet($Q=null){
//Add Balance to Wallet from Transaction(Buy)
$Output=0;	
$PendingStakingTransactions=PendingTradeTransactions($Q);	
if($PendingStakingTransactions){
foreach($PendingStakingTransactions as $PBT){
	//print_r($PBT['user']);
	if(AddToWallet(array( 'user'=>$PBT['buyuser'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$PBT['amount'] ))){

		if($PBT['sellwalletname']=='funding'){
		if(AddToFunding(array( 'user'=>$PBT['selluser'], 'ccc'=>strtolower($PBT['occ']), 'amount'=>$PBT['oca'] ))){
		Balance1Transaction($PBT['id']);
		}
		else{ Balance2Transaction($PBT['id']); }
		}		
		else{
		if(AddToWallet(array( 'user'=>$PBT['selluser'], 'ccc'=>strtolower($PBT['occ']), 'amount'=>$PBT['oca'] ))){
		Balance1Transaction($PBT['id']);
		}
		else{ Balance2Transaction($PBT['id']); }
		}


	}
	else{ Balance2Transaction($PBT['id']); }
}	
}	
return $Output;
}



*/
















function TradeToWallet($Q=null){
	//Add Balance to Wallet from Transaction(Buy)
	$Output=0;	
	$PendingStakingTransactions=PendingTradeTransactions($Q);	
	if($PendingStakingTransactions){
		foreach($PendingStakingTransactions as $PBT){


			//offer

			$BuyAmount=$PBT['amount'];


			//offer

			$BuyUser=0;
			if($PBT['buywalletname']=='funding'){ 
				if(AddToFunding(array( 'user'=>$PBT['buyuser'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$BuyAmount ))){ $BuyUser=1; }
			}
			elseif($PBT['buywalletname']=='jackpot'){
				if(AddToJackpotWallet(array( 'user'=>$PBT['buyuser'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$BuyAmount ))){ $BuyUser=1; }
			}
			elseif($PBT['buywalletname']=='mainwallet'){ 
				if(AddToWallet(array( 'user'=>$PBT['buyuser'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$BuyAmount ))){ $BuyUser=1; }
			}
			else{
				if(AddToWallet(array( 'user'=>$PBT['buyuser'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$BuyAmount ))){ $BuyUser=1; }
			}





			if($BuyUser){
				$Amount=$PBT['oca'];

				if($PBT['sellwalletname']=='funding'){
					if(AddToFunding(array( 'user'=>$PBT['selluser'], 'ccc'=>strtolower($PBT['occ']), 'amount'=>$Amount ))){		
						Balance1Transaction($PBT['id']);
					}
					else{ Balance2Transaction($PBT['id']); }
				}		
				else{
					if(AddToWallet(array( 'user'=>$PBT['selluser'], 'ccc'=>strtolower($PBT['occ']), 'amount'=>$Amount ))){
						Balance1Transaction($PBT['id']);
					}
					else{ Balance2Transaction($PBT['id']); }
				}


			}
			else{ Balance2Transaction($PBT['id']); }
		}	
	}	
	return $Output;
}






function CreateTrade($Q=null){
	$Output=0;
	if(is_array($Q)){ $Amount=$Q['amount']; $Price=$Q['price']; $CCC=$Q['ccc']; $OCC=$Q['occ']; $User=$Q['user']; $BuyUser=$Q['buyuser'];  $BuyTID=$Q['buytid']; $BuyWalletName=$Q['buywalletname']; $SellUser=$Q['selluser']; $SellTID=$Q['selltid']; $SellWalletName=$Q['sellwalletname'];  $Order1=$Q['order']; $Order2=$Q['order2']; }	


	if($Amount and $Price and $CCC and $OCC and $User and $BuyUser and $SellUser and $Order1 and $Order2){

		$Total=$Amount*$Price;


		$Fees=$Total*0.6/100;
		$Totall=$Total-$Fees;


		$Fees=$Amount*0.6/100;
		$Amountt=$Amount-$Fees;

		$T1=Transaction($Order1);
		$T2=Transaction($Order2);	


		$This=$T1['amount']-$T1['filled'];		
		$That=$T2['amount']-$T2['filled'];


		if($This>$That){ $TradeAmount=$That;   }
		else{ $TradeAmount=$This;  }	
		
		$Branch = 0;
		if($T2['branch']==$T1['branch']){$Branch=$T1['branch'];}




		if($T1['amount']>$T1['filled'] and $T2['amount']>$T2['filled'] and $TradeAmount==$Amount){	
			$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `price`, `buyuser`, `buytid`, `buywalletname`, `selluser`, `selltid`, `sellwalletname`, `branch`) VALUES (NULL, 'Trade:This=".$Order1.'-That'.$Order2.' '.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Trade:This=".$Order1.'-That='.$Order2.' '.Clean(GMT())."', '".$User."', '".$Totall."', '".$OCC."', '0', 'Trade', '".$Amountt."', 'CCC', '1', '', '".$Price."', '".$BuyUser."', '".$BuyTID."', '".$BuyWalletName."', '".$SellUser."', '".$SellTID."', '".$SellWalletName."', '".$Branch."');";

			global $DB; $Results = mysqli_query($DB, $SQL1); $Output=mysqli_insert_id($DB);
		}
		else{$Output=0;}

		if($Output){
			$Price_BranchUpdateData = json_encode(Price_BranchUpdateData([ $Branch=>$T2['price'] ]));
			$UpdatePrice=UpdatePrice( array( 'Name'=>'Trade', 'Price'=>$T2['price'], 'CCC'=>'CCC', 'DDD'=>'USDT','price_branch'=> $Price_BranchUpdateData) ); 
		}
	}
	return $Output;	
}






function CreateTrade2($Q=null){
	$Output=0;
	if(is_array($Q)){ $Amount=$Q['amount']; $Price=$Q['price']; $CCC=$Q['ccc']; $OCC=$Q['occ']; $User=$Q['user']; $BuyUser=$Q['buyuser'];  $BuyTID=$Q['buytid']; $BuyWalletName=$Q['buywalletname']; $SellUser=$Q['selluser']; $SellTID=$Q['selltid']; $SellWalletName=$Q['sellwalletname'];  $Order1=$Q['order']; $Order2=$Q['order2']; }	


	if($Amount and $Price and $CCC and $OCC and $User and $BuyUser and $SellUser and $Order1 and $Order2){

		$Total=$Amount*$Price;


		$Fees=$Total*0.0/100;
		$Totall=$Total-$Fees;


		$Fees=$Amount*0.0/100;
		$Amountt=$Amount-$Fees;

		$T1=Transaction($Order1);
		$T2=Transaction($Order2);	


		$This=$T1['amount']-$T1['filled'];		
		$That=$T2['amount']-$T2['filled'];


		if($This>$That){ $TradeAmount=$That;   }
		else{ $TradeAmount=$This;  }	




		if($T1['amount']>$T1['filled'] and $T2['amount']>$T2['filled'] and $TradeAmount==$Amount){	
			$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `price`, `buyuser`, `buytid`, `buywalletname`, `selluser`, `selltid`, `sellwalletname`) VALUES (NULL, 'Trade:This=".$Order1.'-That'.$Order2.' '.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Trade:This=".$Order1.'-That='.$Order2.' '.Clean(GMT())."', '".$User."', '".$Totall."', '".$OCC."', '0', 'Trade', '".$Amountt."', 'hxs', '1', '', '".$Price."', '".$BuyUser."', '".$BuyTID."', '".$BuyWalletName."', '".$SellUser."', '".$SellTID."', '".$SellWalletName."');";

			global $DB; $Results = mysqli_query($DB, $SQL1); $Output=mysqli_insert_id($DB);
		}
		else{$Output=0;}

		if($Output){ 
			//$UpdatePrice=UpdatePrice( array( 'Name'=>'Trade', 'Price'=>$T2['price'], 'CCC'=>'hxs', 'DDD'=>'ccc' ) );
		}
	}
	return $Output;	
}



function MatchOrder($Q=null){
	$Output=0;$Branch=null;
	$TID=$Q;
	if($Q){

		$Q=Transaction($Q); 

		if($Q){
			if(is_array($Q)){ $Type=$Q['ttype']; $Amount=$Q['amount']; $Price=$Q['price']; $CCC=$Q['ccc']; $OCC=$Q['occ'];$Branch=$Q['branch']; }
			
			if(!empty($Branch)){ $Branch = " AND `branch` = '".$Branch."'"; }

      




			if($Type=='Sell'){
				$SQL="SELECT * FROM `Coinpods_transaction` WHERE `occ` = 'usdt' AND `balance` = '1' AND `ttype` = 'Buy' AND `ccc` = 'ccc' AND `status` = '0' AND `price` >= ".$Price." AND `price` != `filled` AND `processing` != '1' ".$Branch." ORDER BY `Coinpods_transaction`.`price` DESC , `Coinpods_transaction`.`id` ASC";

			}
			elseif($Type=='Buy'){
				$SQL="SELECT * FROM `Coinpods_transaction` WHERE `occ` = 'usdt' AND `balance` = '1' AND `ttype` = 'Sell' AND `ccc` = 'ccc' AND `status` = '0' AND `price` <= ".$Price." AND `price` != `filled` AND `processing` != '1' ".$Branch." ORDER BY `Coinpods_transaction`.`price` ASC , `Coinpods_transaction`.`id` ASC";
			}

			if($Type and $Price and $SQL){


				$ts=[]; $t=[];
				global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
				if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
				else{$ts = null;}
				$Output=1;

				if($ts){	
					Processing1Transaction($TID);
					$echo='Match orders found : '.count($ts);







					foreach($ts as $tt){
						Processing1Transaction($tt['id']);

						unset($Q);
						$Q=Transaction($TID);

						if($Q['amount']>$Q['filled']){ 

							$echo='Need to create Trade transaction.';

							$This=0;$That=0; 

							$t=Transaction($tt['id']);





							if($t['amount']>$t['filled']){


								$This=$Q['amount']-$Q['filled'];		
								$That=$t['amount']-$t['filled'];


								if($This>$That){ $TradeAmount=$That; $ThisEnd=0; $ThatEnd=1; }
								else{ $TradeAmount=$This; $$ThisEnd=1; $ThatEnd=0; }


								if($Q['ttype']=='Buy' and $t['ttype']=='Sell'){					
									$Array=array(
										'amount'=>$TradeAmount,
										'price'=>$t['price'], 
										'occ'=>'usdt',
										'ccc'=>'ccc',
										'user'=>$Q['user'],
										'buyuser'=>$Q['user'],
										'buytid'=>$Q['id'],
										'buywalletname'=>$Q['walletname'],
										'selluser'=>$t['user'],
										'selltid'=>$t['id'],
										'sellwalletname'=>$t['walletname'],
										'order'=>$Q['id'],
										'order2'=>$t['id']
									);					
								}
								elseif($Q['ttype']=='Sell' and $t['ttype']=='Buy'){					
									$Array=array(
										'amount'=>$TradeAmount,
										'price'=>$t['price'], 
										'occ'=>'usdt',
										'ccc'=>'ccc',
										'user'=>$Q['user'],
										'buyuser'=>$t['user'],
										'buytid'=>$t['id'],
										'buywalletname'=>$t['walletname'],
										'selluser'=>$Q['user'],
										'selltid'=>$Q['id'],
										'sellwalletname'=>$Q['walletname'],
										'order'=>$Q['id'],
										'order2'=>$t['id']
									);					
								}
								else{$Array=0;}





								if($Array){ $echo='Array Okay'; $CreateTrade = CreateTrade( $Array ); }

								if($CreateTrade){

									$SQL1="UPDATE `Coinpods_transaction` SET `filled` = `filled` + '".$TradeAmount."' WHERE `Coinpods_transaction`.`id` = '".$Q['id']."';";
									global $DB; $Results = mysqli_query($DB, $SQL1);	
									$SQL2="UPDATE `Coinpods_transaction` SET `filled` = `filled` + '".$TradeAmount."' WHERE `Coinpods_transaction`.`id` = '".$t['id']."';";
									global $DB; $Results = mysqli_query($DB, $SQL2);

									if($ThisEnd){ Status1Transaction($Q['id']); }
									if($ThatEnd){ Status1Transaction($t['id']); }

								}
								else{ $echo = $CreateTrade; }

							}
							else{ $echo = 'Order Fucking with another order.'; }



						}
						else{ Status1Transaction($Q['id']); $echo = 'Do Nothing.'; }



						Processing0Transaction($tt['id']);	
					}	





					Processing0Transaction($TID);	
				}
				else{ $echo = 'No order matched.'; Processing0Transaction($TID); }


			}
			else{ $echo='Not enough resources.'; }












		}
		else{ $echo = 'Order not found.';}

	}
	else{ $echo = 'Q is empty';}
	return $Output;	

}








function MatchOrder2($Q=null){
	$Output=0;
	$TID=$Q;
	if($Q){

		$Q=Transaction($Q); 

		if($Q){
			if(is_array($Q)){ $Type=$Q['ttype']; $Amount=$Q['amount']; $Price=$Q['price']; $CCC=$Q['ccc']; $OCC=$Q['occ']; }






			if($Type=='Sell'){
				$SQL="SELECT * FROM `Coinpods_transaction` WHERE `occ` = 'ccc' AND `balance` = '1' AND `ttype` = 'Buy' AND `ccc` = 'hxs' AND `status` = '0' AND `price` >= ".$Price." AND `price` != `filled` AND `processing` != '1' ORDER BY `Coinpods_transaction`.`price` DESC , `Coinpods_transaction`.`id` ASC";

			}
			elseif($Type=='Buy'){
				$SQL="SELECT * FROM `Coinpods_transaction` WHERE `occ` = 'ccc' AND `balance` = '1' AND `ttype` = 'Sell' AND `ccc` = 'hxs' AND `status` = '0' AND `price` <= ".$Price." AND `price` != `filled` AND `processing` != '1' ORDER BY `Coinpods_transaction`.`price` ASC , `Coinpods_transaction`.`id` ASC";
			}

			if($Type and $Price and $SQL){


				$ts=[]; $t=[];
				global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
				if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
				else{$ts = null;}
				$Output=1;

				if($ts){	
					Processing1Transaction($TID);
					$echo='Match orders found : '.count($ts);







					foreach($ts as $tt){
						Processing1Transaction($tt['id']);

						unset($Q);
						$Q=Transaction($TID);

						if($Q['amount']>$Q['filled']){ 

							$echo='Need to create Trade transaction.';

							$This=0;$That=0; 

							$t=Transaction($tt['id']);





							if($t['amount']>$t['filled']){


								$This=$Q['amount']-$Q['filled'];		
								$That=$t['amount']-$t['filled'];


								if($This>$That){ $TradeAmount=$That; $ThisEnd=0; $ThatEnd=1; }
								else{ $TradeAmount=$This; $$ThisEnd=1; $ThatEnd=0; }


								if($Q['ttype']=='Buy' and $t['ttype']=='Sell'){					
									$Array=array(
										'amount'=>$TradeAmount,
										'price'=>$t['price'], 
										'occ'=>'ccc',
										'ccc'=>'hxs',
										'user'=>$Q['user'],
										'buyuser'=>$Q['user'],
										'buytid'=>$Q['id'],
										'buywalletname'=>$Q['walletname'],
										'selluser'=>$t['user'],
										'selltid'=>$t['id'],
										'sellwalletname'=>$t['walletname'],
										'order'=>$Q['id'],
										'order2'=>$t['id']
									);					
								}
								elseif($Q['ttype']=='Sell' and $t['ttype']=='Buy'){					
									$Array=array(
										'amount'=>$TradeAmount,
										'price'=>$t['price'], 
										'occ'=>'ccc',
										'ccc'=>'hxs',
										'user'=>$Q['user'],
										'buyuser'=>$t['user'],
										'buytid'=>$t['id'],
										'buywalletname'=>$t['walletname'],
										'selluser'=>$Q['user'],
										'selltid'=>$Q['id'],
										'sellwalletname'=>$Q['walletname'],
										'order'=>$Q['id'],
										'order2'=>$t['id']
									);					
								}
								else{$Array=0;}





								if($Array){ $echo='Array Okay'; $CreateTrade = CreateTrade2( $Array ); }

								if($CreateTrade){

									$SQL1="UPDATE `Coinpods_transaction` SET `filled` = `filled` + '".$TradeAmount."' WHERE `Coinpods_transaction`.`id` = '".$Q['id']."';";
									global $DB; $Results = mysqli_query($DB, $SQL1);	
									$SQL2="UPDATE `Coinpods_transaction` SET `filled` = `filled` + '".$TradeAmount."' WHERE `Coinpods_transaction`.`id` = '".$t['id']."';";
									global $DB; $Results = mysqli_query($DB, $SQL2);

									if($ThisEnd){ Status1Transaction($Q['id']); }
									if($ThatEnd){ Status1Transaction($t['id']); }

								}
								else{ $echo = $CreateTrade; }

							}
							else{ $echo = 'Order Fucking with another order.'; }



						}
						else{ Status1Transaction($Q['id']); $echo = 'Do Nothing.'; }



						Processing0Transaction($tt['id']);	
					}	





					Processing0Transaction($TID);	
				}
				else{ $echo = 'No order matched.'; Processing0Transaction($TID); }


			}
			else{ $echo='Not enough resources.'; }












		}
		else{ $echo = 'Order not found.';}

	}
	else{ $echo = 'Q is empty';}
	return $Output;	

}












function CreateBuySell($Q=null){
	$Output=0;

	$AfterBalance=$BeforeBalance=0;
	if(is_array($Q)){ $Type=$Q['type'];  $Amount=$Q['amount']; $Price=$Q['price']; $OCC=strtolower($Q['occ']); $CCC=strtolower($Q['ccc']); $WT=strtolower($Q['wt']); }


	if($WT=='funding'){ $Wallets=Fundings();  } 
	elseif($WT == 'jackpot'){ $Wallets=JackpotWallets(); }
	elseif($WT == 'mainwallet'){ $Wallets=MainWallets(i['id']); }
	else{ $Wallets=Wallets(); }
	$Total = $Amount*$Price; 



	if($Type=='buy'){


		if($Wallets[$OCC]>=p2d($Total)){ 

			$Fees=$Amount*0/100; $Amountt=$Amount-$Fees;

			$BeforeBalance=$Wallets[$OCC];
			$AfterBalance=$BeforeBalance-p2d($Total);



			if(strtoupper($CCC)=='CCC'){
				if($WT=='jackpot'){

					$Amount92 = Percent($Amount,50);
					$Amount8 = Percent($Amount,50);
					$Total8 = $Amount8*$Price;

				}
				else{

					$Amount92 = Percent($Amount,80);
					$Amount8 = Percent($Amount,20);
					$Total8 = $Amount8*$Price;

				}
			}
			else{ $Amount92 = $Amount; }

			$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`, `price`, `buyuser`, `processing`, `walletname`, `total`, `partition`, `branch`) VALUES (NULL, 'Buy:".i['id'].Clean(GMT())."', current_timestamp(), current_timestamp(), 'Buy:".i['id'].Clean(GMT())."', '".i['id']."', '".p2d($Total)."', '".$OCC."', '1', 'Buy', '".p2d($Amount92)."', '".strtoupper($CCC)."', '0', '".$Wallets['ccc']."', '".$AfterBalance."', '".$Price."', '".i['id']."', '1', '".$WT."', '".p2d($Amount)."', '0', '".i['branch']."');";

			global $DB;$aa = 0;
			$results = mysqli_query($DB, $SQL1);


			$Output=mysqli_insert_id($DB);	
			$IID=$Output;
			if($IID and $Amount8){

				$SQL3="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `price`, `buyuser`, `buytid`, `buywalletname`, `selluser`, `selltid`, `sellwalletname`, `branch`) VALUES (NULL, '".$IID."', current_timestamp(), current_timestamp(), 'Trade:This=".$IID."', '1', '".p2d($Total8)."', '".$OCC."', '1', 'PartitionTrade', '".p2d($Amount8)."', '".strtoupper($CCC)."', '1', '', '".$Price."', '".i['id']."', '".$IID."', '".$WT."', '1', '', '', '".i['branch']."');";
				global $DB; $results = mysqli_query($DB, $SQL3);

				if($results){

					if($WT=='funding'){ $Wallets=Fundings();  }
					elseif($WT=='jackpot'){ $Wallets=JackpotWallets(); }
					elseif($WT=='mainwallet'){ $Wallets=MainWallets(i['id']); }
					else{ $Wallets=Wallets(); }



					$DDD=$Wallets[$OCC]; $DDD=$DDD-p2d($Total);

					if($WT=='funding'){ $SQL2="UPDATE `Coinpods_funding` SET `".$OCC."` = ".$DDD."  WHERE `Coinpods_funding`.`user` = '".i['id']."';"; }

					elseif($WT=='jackpot'){ $SQL2="UPDATE `Coinpods_jackpotwallet` SET `".$OCC."` = ".$DDD."  WHERE `Coinpods_jackpotwallet`.`user` = '".i['id']."';"; }

					elseif($WT=='mainwallet'){ $SQL2="UPDATE `Coinpods_main_wallet` SET `".$OCC."` = ".$DDD."  WHERE `Coinpods_main_wallet`.`user` = '".i['id']."';"; }

					else{ $SQL2="UPDATE `Coinpods_wallet` SET `".$OCC."` = ".$DDD."  WHERE `Coinpods_wallet`.`user` = '".i['id']."';"; }
					global $DB;$aa = 0; 
					$Outputt = mysqli_query($DB, $SQL2);	
				}	

			}


		}
	}





	elseif($Type=='sell'){



		if($Wallets['ccc']>=p2d($Amount)){ 

			$BeforeBalance=$Wallets['ccc'];
			$AfterBalance=$BeforeBalance-p2d($Amount);	

			$Fees=$Total*0/100;
			$Totall=$Total-$Fees;


			$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`, `price`, `selluser`, `processing`, `walletname`, `branch`) VALUES (NULL, 'Sell:".i['id'].Clean(GMT())."', current_timestamp(), current_timestamp(), 'Sell:".i['id'].Clean(GMT())."', '".i['id']."', '".p2d($Total)."', '".$OCC."', '1', 'Sell', '".p2d($Amount)."', '".strtoupper($CCC)."', '0', '".$Wallets['ccc']."', '".$AfterBalance."', '".$Price."', '".i['id']."', '1', '".$WT."', '".i['branch']."');";

			global $DB;$aa = 0;
			$results = mysqli_query($DB, $SQL1);
			$Output=mysqli_insert_id($DB);

			if($results){
				if($WT=='funding'){ $SQL2="UPDATE `Coinpods_funding` SET `$CCC` = `$CCC` - ".p2d($Amount)."  WHERE `Coinpods_funding`.`user` = '".i['id']."';"; }
				else{ $SQL2="UPDATE `Coinpods_wallet` SET `$CCC` = `$CCC` - ".p2d($Amount)."  WHERE `Coinpods_wallet`.`user` = '".i['id']."';"; }
				global $DB;$aa = 0;
				$Outputt = mysqli_query($DB, $SQL2);	
			}	

		}

	}	




	else{ $Output='Internal Error.'; }






	return $Output;
}









function CreateBuySell2($Q=null){
	$Output=0;
	if(is_array($Q)){ $Type=$Q['type'];  $Amount=$Q['amount']; $Price=$Q['price']; $OCC=strtolower($Q['occ']); $CCC=strtolower($Q['ccc']); $WT=strtolower($Q['wt']); }




	if($WT=='funding'){ $Wallets=Fundings();  } 
	elseif($WT == 'jackpot'){ $Wallets=JackpotWallets(); }
	else{ $Wallets=Wallets(); }
	$Total = $Amount*$Price; 






	if($Type=='buy'){


		if($Wallets[$OCC]>=p2d($Total)){ 

			$Fees=$Amount*0/100; $Amountt=$Amount-$Fees;

			if(strtoupper($CCC)=='CCC'){
				if($WT=='jackpot'){

					$Amount92 = Percent($Amount,50);
					$Amount8 = Percent($Amount,50);
					$Total8 = $Amount8*$Price;

				}
				else{

					$Amount92 = Percent($Amount,92);
					$Amount8 = Percent($Amount,8);
					$Total8 = $Amount8*$Price;

				}
			}
			else{ $Amount92 = $Amount; }

			$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `price`, `buyuser`, `processing`, `walletname`, `total`, `partition`) VALUES (NULL, 'Buy:".i['id'].Clean(GMT())."', current_timestamp(), current_timestamp(), 'Buy:".i['id'].Clean(GMT())."', '".i['id']."', '".p2d($Total)."', '".$OCC."', '1', 'Buy', '".p2d($Amount92)."', '".strtoupper($CCC)."', '0', '".$Wallets['ccc']."', '".$Price."', '".i['id']."', '1', '".$WT."', '".p2d($Amount)."', '0');";

			global $DB;$aa = 0;
			$results = mysqli_query($DB, $SQL1);


			$Output=mysqli_insert_id($DB);	
			$IID=$Output;
			if($IID){

				$SQL3="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `price`, `buyuser`, `buytid`, `buywalletname`, `selluser`, `selltid`, `sellwalletname`) VALUES (NULL, '".$IID."', current_timestamp(), current_timestamp(), 'Trade:This=".$IID."', '1', '".p2d($Total8)."', '".$OCC."', '1', 'PartitionTrade', '".p2d($Amount8)."', '".strtoupper($CCC)."', '1', '', '".$Price."', '".i['id']."', '".$IID."', '".$WT."', '1', '', '');";
				//global $DB; $results = mysqli_query($DB, $SQL3);

				if($IID){

					if($WT=='funding'){ $Wallets=Fundings();  }
					elseif($WT=='jackpot'){ $Wallets=JackpotWallets(); }
					else{ $Wallets=Wallets(); }



					$DDD=$Wallets[$OCC]; $DDD=$DDD-p2d($Total);

					if($WT=='funding'){ $SQL2="UPDATE `Coinpods_funding` SET `".$OCC."` = ".$DDD."  WHERE `Coinpods_funding`.`user` = '".i['id']."';"; }

					elseif($WT=='jackpot'){ $SQL2="UPDATE `Coinpods_jackpotwallet` SET `".$OCC."` = ".$DDD."  WHERE `Coinpods_jackpotwallet`.`user` = '".i['id']."';"; }

					else{ $SQL2="UPDATE `Coinpods_wallet` SET `".$OCC."` = ".$DDD."  WHERE `Coinpods_wallet`.`user` = '".i['id']."';"; }
					global $DB;$aa = 0; 
					$Outputt = mysqli_query($DB, $SQL2);	
				}	


			}


		}

	}





	elseif($Type=='sell'){



		if($Wallets['ccc']>=p2d($Amount)){ 


			$Fees=$Total*0/100;
			$Totall=$Total-$Fees;


			$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `price`, `selluser`, `processing`, `walletname`) VALUES (NULL, 'Sell:".i['id'].Clean(GMT())."', current_timestamp(), current_timestamp(), 'Sell:".i['id'].Clean(GMT())."', '".i['id']."', '".p2d($Total)."', '".$OCC."', '1', 'Sell', '".p2d($Amount)."', '".strtoupper($CCC)."', '0', '".$Wallets['ccc']."', '".$Price."', '".i['id']."', '1', '".$WT."');";

			global $DB;$aa = 0;
			$results = mysqli_query($DB, $SQL1);
			$Output=mysqli_insert_id($DB);

			if($results){
				if($WT=='funding'){ $SQL2="UPDATE `Coinpods_funding` SET `$CCC` = `$CCC` - ".p2d($Amount)."  WHERE `Coinpods_funding`.`user` = '".i['id']."';"; }
				else{ $SQL2="UPDATE `Coinpods_wallet` SET `$CCC` = `$CCC` - ".p2d($Amount)."  WHERE `Coinpods_wallet`.`user` = '".i['id']."';"; }
				global $DB;$aa = 0;
				$Outputt = mysqli_query($DB, $SQL2);	
			}	

		}

	}	




	else{ $Output='Internal Error.'; }






	return $Output;
}


















/*
function PendingStakingTransactions($Q=null){

if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Staking'"; }
else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'Staking'"; }

global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function StakingToTransaction($Q=null){
	if($Q){

//if(AddToWallet(array( 'user'=>$Q['user'], 'ccc'=>strtolower($Q['ccc']), 'amount'=>$Q['amount'] )))

if($Q['staking']){

	//$Currency = Currency('REEF');
	//$Amount = $Q['staking']*$Q['price'];

$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`) VALUES (NULL, 'Staking : ".$Q['id']." : ".GMT()."', current_timestamp(), current_timestamp(), 'Staking".$Q['id']."at".Clean(GMT())."', '".$Q['user']."', '', '', '0', 'Staking', '".$Q['staking']."', 'reef', '1');";
	global $DB;	$Output = mysqli_query($DB, $SQL);	

	if($Output){ 
		$SQL2="UPDATE `Coinpods_stake` SET `staked` = `staked` + `staking`, `staking` = 0 WHERE `Coinpods_stake`.`id` = '".$Q['id']."';";	
		global $DB;	$Output = mysqli_query($DB, $SQL2);	
		return $Output;
	}
	}
	} 	
}

function StakingToTransactions(){

	$SQL="SELECT * FROM `Coinpods_stake` WHERE `status` = 1 ORDER BY `id` DESC";	

	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	

	if($ts){
		foreach($ts as $t){
			StakingToTransaction($t);

		}	
	}	
}



*/





















function PendingWithdrawTransactions($Q=null){	
	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `status` = 0 AND `ttype` = 'Withdraw' LIMIT 1"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `status` = 0 AND `ttype` = 'Withdraw' LIMIT 1"; }
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}








function WithdrawToWallet($Q=null){
	//Send Balance to Wallet from Transaction(Withdraw)
	$echo = 'WithdrawToWallet Started'; echo $echo;
	$Output=0;	
	$TRs=PendingWithdrawTransactions($Q);	
	if($TRs){
		$echo = 'Pending Transactions found.'; echo $echo;
		foreach($TRs as $TR){ 
			echo $TR['user'];

			$Address='';
			$Addresses = WalletAddresses($TR['user']); 
			if($Addresses){ $Address=$Addresses['bep20']; }	
			if(strtolower($TR['ccc'])=='uxdt'){ $Network='XAH'; }else{ $Network='BSC'; }


			if(SendToWallet(array( 'address'=>$Address, 'ccc'=>strtolower($TR['ccc']), 'amount'=>$TR['amount'], 'network'=>$Network, 'WalletType'=>$TR['walletname'] ))){
				$echo = 'Send To Wallet Success.'; echo $echo;
				Status1Transaction($TR['id']);
				$Output=1;
			}
			else{ 
				$echo = 'Send To Wallet Failed.'; echo $echo;
				Status2Transaction($TR['id']);
			}
			unset($Address);
		}	
	}
	else{ $echo = 'Transactions not found.'; echo $echo; }
	echo $echo;
	return $Output;
}






function Withdraw($Q=null){
	$Output=$AfterBalance=0;
	if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $WT=strtolower($Q['wt']);  $OCC=strtolower($Q['occ']); }

	if($WT=='funding'){ $Wallets=Fundings(i['id']); } else{ $Wallets=Wallets(i['id']); }

	if($Wallets[strtolower($CCC)]>=p2d($Amount)){

		$AfterBalance=$Wallets[strtolower($CCC)]-p2d($Amount);

		$Fees=$Amount*10/100;
		$WAmount=$Amount-$Fees;

		$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`,`afterbalance`, `walletname`) VALUES (NULL, 'Withdraw:".i['id'].Clean(GMT())."', current_timestamp(), current_timestamp(), 'Withdraw:".i['id'].Clean(GMT())."', '".i['id']."', '', '', '1', 'Withdraw', '".p2d($WAmount)."', '".strtoupper($OCC)."', '0', '".$Wallets[strtolower($CCC)]."', '".$AfterBalance."', '".$WT."');";

		global $DB;$aa = 0;
		$results = mysqli_query($DB, $SQL1);

		if($results){

			//$Input = ['feature'=>'Withdraw','amount'=>p2d($WAmount),'pair'=>'USDT_USDT','user'=>i['id']];

			//LiveData___Feature_Meta($Input);	


			if($WT=='funding'){ $SQL2="UPDATE `Coinpods_funding` SET `".strtolower($CCC)."` = `".strtolower($CCC)."` - ".p2d($Amount)."  WHERE `Coinpods_funding`.`user` = '".i['id']."';"; }

			else{ $SQL2="UPDATE `Coinpods_wallet` SET `".strtolower($CCC)."` = `".strtolower($CCC)."` - ".p2d($Amount)."  WHERE `Coinpods_wallet`.`user` = '".i['id']."';"; }

			global $DB;$aa = 0;
			$Output = mysqli_query($DB, $SQL2);	
		}	

	}
	return $Output;
}






function PendingSellTransactions($Q=null){	
	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Sell'"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'Sell'"; }
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function SellToWallet($Q=null){
	//Add Balance to Wallet from Transaction(Sell)
	$Output=0;	
	$TRs=PendingSellTransactions($Q);	
	if($TRs){
		foreach($TRs as $TR){
			//print_r($PBT['user']);
			if(AddToWallet(array( 'user'=>$TR['user'], 'ccc'=>strtolower($TR['occ']), 'amount'=>$TR['oca'] ))){
				Balance1Transaction($TR['id']);
			}
			else{ Balance2Transaction($TR['id']); }
		}	
	}	
	return $Output;
}





function PendingBuyTransactions($Q=null){

	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Buy'"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = '0' AND `ttype` = 'Buy'"; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function BuyToWallet($Q=null){
	//Add Balance to Wallet from Transaction(Buy)
	$Output=0;	
	$PendingBuyTransactions=PendingBuyTransactions($Q);	
	if($PendingBuyTransactions){
		foreach($PendingBuyTransactions as $PBT){
			//print_r($PBT['user']);
			if(AddToWallet(array( 'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$PBT['amount'] ))){
				Balance1Transaction($PBT['id']);
			}
			else{ Balance2Transaction($PBT['id']); }
		}	
	}	
	return $Output;
}



/*
function DepositToWallet($Q=null){
//Add Balance to Wallet from Transaction(Deposit)
$Output=0;	
$PendingDeposits=PendingDeposits($Q);
if($PendingDeposits){
foreach($PendingDeposits as $PD){	
	$UserID=$PD['user'];
	if($UserID){
		if(AddToWallet(array( 'user'=>$UserID, 'ccc'=>$PD['ccc'], 'network'=>$PD['network'], 'amount'=>$PD['amount'] ))){			

			Balance1Transaction($PD['id']);
	}
		else{ Balance2Transaction($PD['id']); }
	}
	else{ Balance2Transaction($PD['id']);	}	
}
}
}
*/


function Buy($Q=null){
	$Output=0;
	if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); }
	$Wallets=Wallets();
	$Price=Price('CCC:'.strtoupper($CCC));
	$Total = $Amount*$Price;

	if($Wallets[$CCC]>=p2d($Total)){ 

		$Fees=$Amount*0.4/100;
		$Amountt=$Amount-$Fees;

		$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `price`) VALUES (NULL, 'Buy:".i['id'].Clean(GMT())."', current_timestamp(), current_timestamp(), 'Buy:".i['id'].Clean(GMT())."', '".i['id']."', '".p2d($Total)."', '".$CCC."', '0', 'Buy', '".p2d($Amountt)."', 'CCC', '1', '".$Wallets['ccc']."', '".$Price."');";

		global $DB;$aa = 0;
		$results = mysqli_query($DB, $SQL1);

		if($results){

			$Wallets=Wallets();



			$DDD=$Wallets[$CCC]; $DDD=$DDD-p2d($Total);


			$SQL2="UPDATE `Coinpods_wallet` SET `".$CCC."` = ".$DDD."  WHERE `Coinpods_wallet`.`user` = '".i['id']."';";
			global $DB;$aa = 0;
			$Output = mysqli_query($DB, $SQL2);	
		}	

	}
	return $Output;
}




function Sell($Q=null){
	$Output=0;
	if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); }
	$Wallets=Wallets();

	$Price=Price('CCC:'.strtoupper($CCC));
	$Total = $Amount*$Price;
	if($Wallets['ccc']>=p2d($Amount)){ 


		$Fees=$Total*0.4/100;
		$Totall=$Total-$Fees;


		$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `price`) VALUES (NULL, 'Sell:".i['id'].Clean(GMT())."', current_timestamp(), current_timestamp(), 'Sell:".i['id'].Clean(GMT())."', '".i['id']."', '".p2d($Total)."', '".$CCC."', '0', 'Sell', '".p2d($Amount)."', 'CCC', '1', '".$Wallets['ccc']."', '".$Price."');";

		global $DB;$aa = 0;
		$results = mysqli_query($DB, $SQL1);

		if($results){
			$SQL2="UPDATE `Coinpods_wallet` SET `ccc` = `ccc` - ".p2d($Amount)."  WHERE `Coinpods_wallet`.`user` = '".i['id']."';";
			global $DB;$aa = 0;
			$Output = mysqli_query($DB, $SQL2);	
		}	

	}
	return $Output;
}



















function Balance1Transaction($Q=null){
	// Update Transaction status == 1
	if($Q){	
		$SQL="UPDATE `Coinpods_transaction` SET `balance` = '1' WHERE `Coinpods_transaction`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}

function Balance2Transaction($Q=null){
	// Update Transaction status == 2

	if($Q){	
		$SQL="UPDATE `Coinpods_transaction` SET `balance` = '2' WHERE `Coinpods_transaction`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}



function CryptoToWallet($Q=null){
	/*
$Output=0;

$PendingCryptos=PendingCryptos($Q);
if($PendingCryptos){
foreach($PendingCryptos as $PC){

	$UserID=AddressToID($PC['from']);
	if($UserID){
		if(AddToWallet(array( 'user'=>$UserID, 'ccc'=>$PC['ccc'], 'network'=>$PC['network'], 'amount'=>$PC['amount'] ))){
		Status1Crypto($PC['id']);
	}
	}
	else{Status2Crypto($PC['id']);}



}	
}
*/
}





function CryptosToTransactions($Q=null){
	$Output=0;	$aa=0;
	$PendingCryptos=PendingCryptos($Q);
	if($PendingCryptos){
		foreach($PendingCryptos as $PC){


			$UserID=AddressToID($PC['from']); //$UserID=1;
			if($UserID){ 
				$UID_EncodeArray = ['app'=>App['id'],'user'=>$UserID,'network'=>'Bep20','table'=>'web3_address_backup'];
				$UID = UID_Encode($UID_EncodeArray)['uid'];	
				$Row = Row($UID,'web3_address_backup')['o'];
				$User = user($UserID);


				if(!empty($User['network']) && strtolower($User['network']) == 'xah') { $ToA='0xf2ac3ab32c1fd641a0124da803af79603bd064de'; }
				elseif(!empty($User['network']) && strtolower($User['network'])=='bsc'){ $ToA='0xecE203134679c9886286DA551977DBe149006c01'; }
				elseif(!empty($Row['user'])){ $ToA='0xf2ac3ab32c1fd641a0124da803af79603bd064de'; }
				else{  $ToA='0xecE203134679c9886286DA551977DBe149006c01';  }

				if(strtolower($PC['to'])==strtolower($ToA)){
					CryptoToTransaction($PC['hash']);

				}
				else{ Status6Crypto($PC['id']); }
			}
			else{ Status2Crypto($PC['id']);}


		}	


	}	
}



function CryptoToTransaction($Q=null){
	//Crypto To Transaction : Just By Using Transaction ID
	//#Steps 
	//Get Crypto
	//Inset Transaction
	//Update Crypto

	if($Q){	
		$Transaction=Crypto($Q);	
		if($Transaction){

			$UserID=AddressToID($Transaction['from']); //$UserID=1;



			//offer
			$Offer=0;	
			$AmountUSDT = d2p($Transaction['amount']);
			$Amount=$Transaction['amount'];

			if($AmountUSDT >= 1000){ $Offer=10; }
			//elseif($AmountUSDT >= 400 and $AmountUSDT <= 999){ $Offer=15; }
			//elseif($AmountUSDT >= 1000){ $Offer=20; }
			else{ $Offer=0; }

			//if($Offer){ $Offer = Percent($Amount,$Offer); $Amount=$Amount+$Offer; } 

			//	echo '<br><br>Offer : '.$Offer; echo '<br>USDT : '.$BuyUSDT; echo '<br>Amount : '.$Amount; echo '<br>Amount : '.$Amount;
			//offer	
			$MainWallets=MainWallets($UserID)[strtolower($Transaction['ccc'])];

			$BeforeBalance=$MainWallets;
			$AfterBalance=$BeforeBalance+$Amount;


			$WalletName='mainwallet';	
			if($Transaction['to']==strtolower('0xaD000Bb5e7FDe4103f9F477214C3Cb7970031015')){ $WalletName='Jackpot'; }	

			$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `walletname`, `beforebalance`, `afterbalance`) VALUES (NULL, 'Deposit:".$Transaction['hash']."', '".GMT()."', '".GMT()."', '".$Transaction['hash']."', '".$UserID."', '', '', '0', 'Deposit', '".$Amount."', '".$Transaction['ccc']."', '1', '".$WalletName."', '".$BeforeBalance."', '".$AfterBalance."');";	
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
			$InsertID=mysqli_insert_id($DB);

			if($results){
				
				//$Input = ['feature'=>'Deposit','amount'=>$Amount,'pair'=>'USDT_USDT','user'=>$UserID];
				//LiveData___Feature_Meta($Input);
				
				$DepositNewArray=['id'=>$InsertID, 'user'=>$UserID, 'hash'=>$Transaction['hash'], 'amount'=>$Amount, 'ccc'=>$Transaction['ccc'], 'beforebalance'=>$BeforeBalance, 'afterbalance'=>$AfterBalance, 'orderid'=>$Transaction['hash'], 'walletname'=>$WalletName, ];
				DepositNew($DepositNewArray); unset($DepositNewArray);

				$Dispatche = 1;
				if($Dispatche==1){

					$Array=['feature'=>'Deposit','pair'=>'USDT_USDT','user'=>$UserID,'amount'=>$Amount,];
					HistoryUpdateNew($Array);
				}


				Status1Crypto($Transaction['id']);  return true; 
			} 
			else{ Status2Crypto($Transaction['id']); }

		}	 
	}	
}









function Status0Transaction($Q=null){
	if($Q){	
		$SQL="UPDATE `Coinpods_transaction` SET `status` = '0' WHERE `Coinpods_transaction`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}




function Status1Transaction($Q=null){
	if($Q){	
		$SQL="UPDATE `Coinpods_transaction` SET `status` = '1' WHERE `Coinpods_transaction`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}

function Status2Transaction($Q=null){
	if($Q){	
		$SQL="UPDATE `Coinpods_transaction` SET `status` = '2' WHERE `Coinpods_transaction`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}


function Status3Transaction($Q=null){
	if($Q){	
		$SQL="UPDATE `Coinpods_transaction` SET `status` = '3' WHERE `Coinpods_transaction`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}



function Status4Transaction($Q=null){
	if($Q){	
		$SQL="UPDATE `Coinpods_transaction` SET `status` = '4' WHERE `Coinpods_transaction`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}



function Status5Transaction($Q=null){
	if($Q){	
		$SQL="UPDATE `Coinpods_transaction` SET `status` = '5' WHERE `Coinpods_transaction`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}










function PendingCryptos($Q=null){

	if($Q){ $SQL="SELECT * FROM `Coinpods_crypto` WHERE `from` = '".$Q."' AND `status` = 0"; }
	else{ $SQL="SELECT * FROM `Coinpods_crypto` WHERE `status` = 0"; }

	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;	


}





function Status1Crypto($Q=null){
	if($Q){	
		$SQL="UPDATE `Coinpods_crypto` SET `status` = '1' WHERE `Coinpods_crypto`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}

function Status2Crypto($Q=null){
	if($Q){	
		$SQL="UPDATE `Coinpods_crypto` SET `status` = '2' WHERE `Coinpods_crypto`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}


function Status6Crypto($Q=null){
	if($Q){	
		$SQL="UPDATE `Coinpods_crypto` SET `status` = '6' WHERE `Coinpods_crypto`.`id` = '".$Q."';";
		global $DB;$aa = 0;
		$Output = mysqli_query($DB, $SQL);	
		return  $Output;	
	}	
}












function PendingLevelTransactions($Q=null){

	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Level'"; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'Level'"; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function LevelToWallet($Q=null){
	//Add Balance to Wallet from Transaction(Buy)
	$Output=0;	
	$PendingLevelTransactions=PendingLevelTransactions($Q);	
	if($PendingLevelTransactions){
		foreach($PendingLevelTransactions as $TR){
			//print_r($PBT['user']);
			if(AddToFunding(array( 'user'=>$TR['user'], 'ccc'=>strtolower($TR['ccc']), 'amount'=>$TR['amount'] ))){
				Balance1Transaction($TR['id']);
			}
			else{ Balance2Transaction($TR['id']); }
		}	
	}	
	return $Output;
}






//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



function Level1Transaction($Q=null){
	$Output=0;
	if($Q){	
		$SQL="UPDATE `Coinpods_transaction` SET `level` = '1' WHERE `Coinpods_transaction`.`id` = '".$Q."';";
		global $DB;	$Output = mysqli_query($DB, $SQL);	
	}	
	return $Output;
}




function Level2Transaction($Q=null){
	$Output=0;
	if($Q){	
		$SQL="UPDATE `Coinpods_transaction` SET `level` = '2' WHERE `Coinpods_transaction`.`id` = '".$Q."';";
		global $DB;	$Output = mysqli_query($DB, $SQL);	
	}	
	return $Output;
}





function LevelStake($Q=null){
	$Output=0;


	global $LS;
	$LS=array( '1'=>20,'2'=>2.5,'3'=>1,'4'=>0.25,'5'=>0.25,'6'=>0.25,'7'=>0.25,'8'=>0.25,'9'=>0.25,'10'=>0.25,'11'=>0.25,'12'=>0.25,'13'=>0.25,'14'=>0.25,'15'=>0.25,'16'=>0.25,'17'=>0.25,'18'=>0.25,'19'=>0.25,'20'=>0.25,'21'=>0.25,'22'=>0.25,'23'=>0.25,'24'=>0.25,'25'=>0.25,'26'=>0.25,'27'=>0.25,'28'=>0.25,'29'=>0.25,'30'=>0.25 );


	if($Q){ $Q = Transaction($Q); }

	if($Q){ $User = $Q['user']; $Amount = $Q['amount']; $CCC = strtolower($Q['ccc']); }
	$User=User($User); $II=$User;

	if($User){$Uplines=Uplines($User['userid']);}
	if($Amount and $CCC and $User and $Uplines){

		$aa=0;
		foreach($Uplines as $Upline){

			$User='';
			$User=UserByUserID($Upline);
			$aa++;	
			if($User['ID']){	
				$Income=Percent($Amount,$LS[$aa]);

				$Walletss = Wallets($User['ID']);
				$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`) VALUES (NULL, 'Level".$aa." Income from Stake', current_timestamp(), current_timestamp(), 'StakeLevel:".$aa."-TR:".$Q['id']."', '".$User['ID']."', '', '', '0', 'Level', '".$Income."', '".strtoupper($CCC)."', '0', '".$Walletss['ccc']."');";



				global $DB;	$Output = mysqli_query($DB, $SQL);	
			}	
		}
	}	
	else{ $echo = 'Not enough resources.';  }
	return $Output;
}




function PendingLevelsStake(){

	$SQL="SELECT * FROM `Coinpods_transaction` WHERE `ttype` LIKE 'Stake' AND `level` = 0 ORDER BY `id` DESC"; 
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		

}




function LevelsStake(){
	$Output=0;
	$Ts=PendingLevelsStake();
	if($Ts){
		foreach($Ts as $T){

			if(LevelStake($T['id'])){ 
				Level1Transaction($T['id']); $Output++; 
			}
			else{ Level2Transaction($T['id']); }
		}	
	}
	return $Output;
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








function Withdrawal($Q=null){
	// OUTPUT : ALL transactions's data from DB by status($Q)
	if(i['id']){
		global $DB;$aa = 0;
		$SQL = "SELECT * FROM `withdraw` WHERE `id` = ".$Q; 
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		return $ts[0];
	}
	else{return false;}
}


function Withdrawn($Q=null){
	// OUTPUT : ALL transactions's data from DB by status($Q)
	if(iam['admin']){
		global $DB;$aa = 0;
		$SQL = "SELECT * FROM `withdraw` WHERE `status` = ".$Q; 
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		return $ts;
	}
	else{return false;}
}


function first_withdraw($Q){
	global $DB;$aa = 0;	
	$SQL = "SELECT * FROM `transactions` WHERE `from` = '".$Q."' ORDER BY `transactions`.`id` ASC"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$first=$ts[0]['created'];

	$DF = diff_in_seconds(array( 'start' => $first, 'end' => GMT() ));
	$DF=number_format($DF/hour,2);
	return $DF;
}


function withdrawed($Q=null){
	// OUTPUT :  single withdraw data from DB by ID($Q)
	global $DB;$aa = 0;
	if(strlen((string) $Q) > 10){$iidd = 'id2';} else{$iidd = 'id';}
	$SQL = "SELECT * FROM `withdraw` WHERE `".$iidd."` = ".$Q;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0];
}





function withdraws($Q=null){
	// OUTPUT : multiple withdraw data from DB by user_ID($Q)
	if(!$Q){$Q=i['id'];}
	if($Q){
		global $DB;$aa = 0;$LIMIT=11;
		if(iam['admin'] and !PP){$SQL = "SELECT * FROM `withdraw` ORDER BY `withdraw`.`id` DESC LIMIT ".$LIMIT;}
		else{$SQL = "SELECT * FROM `withdraw` WHERE `user` = ".$Q." ORDER BY `withdraw`.`id` DESC";}
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		return $ts;
	}
}


function withdraw0($Q=null){
	// OUTPUT : ALL transactions's data from DB by status($Q)
	if(iam['admin']){
		global $DB;$aa = 0;
		$SQL = "SELECT * FROM `withdraw` WHERE `status` = ".$Q; 
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		return $ts;
	}
	else{return false;}
}
function withdraw0counts($Q=null){
	// OUTPUT : ALL withdraw's count data from DB by status($Q)
	if(iam['admin']){
		global $DB;$aa = 0;
		$SQL = "SELECT COUNT(id) FROM `withdraw` WHERE `status` = ".$Q; 
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		if($ts){return $ts[0]['COUNT(id)'];}
	}
	else{return false;}
}

function reset_wa($Q){
	global $DB;$aa = 0;
	if(strlen((string) $Q) == 3){

		// Update withdrawed = withdrawed + withdrawable		
		$SQL = "UPDATE `transactions` SET `withdrawed` = `withdrawable` + `withdrawed` WHERE `transactions`.`from` = '".i['id']."' AND `c` = '".$Q."'";
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	

		// Reseting Withdrawable amount
		$SQL = "UPDATE `transactions` SET `withdrawable` = 0 WHERE `transactions`.`from` = '".i['id']."' AND `c` = '".$Q."'";
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	

		$twa = total_wa($Q);
		if($twa>0){ return 0;}
		else{return 1;}
	}
	else{ return 'provide currency code';}


}

function aprove_withdraw($Q){
	// OUTPUT : Aprove a withdraw transaction by ADMIN Panel
	global $DB;
	if(is_array($Q)){ $id = $Q['id']; $cyrpto = $Q['cyrpto']; } else{ $id = 0; $cyrpto = 0; }
	if($id and $cyrpto){
		$SQL = "UPDATE `withdraw` SET `status` = '7', `cyrpto` = '".$cyrpto."', `aproved` = '".GMT()."'  WHERE `withdraw`.`id` = ".$id; 
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		return $ts;
	}
	else{ echo ' empty = id or cyrpto'; }
}



function min_withdraw($Q){
	if($Q=='TRX' or $Q=='trx'){return 10;}
	elseif($Q=='ETH' or $Q=='eth'){return 0.005;}
	elseif($Q=='BTC' or $Q=='btc'){return 0.001;}
	else{return 100;}
}


function global_withdraw($c=null){ 
	// OUTPUT : Total of withdrawed amount(aproved) by Currency
	// INPUT : Currency
	global $DB; $aa = 0;

	if($c){
		$SQL = "SELECT SUM(amount) FROM `withdraw` WHERE `c` = '".$c."';";
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(amount)'];}
	}

}




function total_withdraw($c=null,$h=null){ 
	// OUTPUT : total withdrawed(aproved) amount
	if(i['id']){

		global $DB; $aa = 0;

		if(!$h){$h=i['id'];}

		if($c){
			$SQL = "SELECT SUM(amount) FROM `withdraw` WHERE `user` = '".$h."' AND `c` = '".$c."';";
			$results = mysqli_query($DB, $SQL);	
			if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
			else{$ts = null;}
			if($ts){ return $ts[0]['SUM(amount)'];}
		}
	}
	else{ return 0;}

}




function total_aproved_withdraw($c=null,$h=null){ 
	// OUTPUT : total withdrawed(aproved) amount
	if(i['id']){

		global $DB; $aa = 0;

		if(!$h){$h=i['id'];}

		if($c){
			$SQL = "SELECT SUM(amount) FROM `withdraw` WHERE `user` = '".$h."' AND `c` = '".$c."' AND `status` = 7;";
			$results = mysqli_query($DB, $SQL);	
			if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
			else{$ts = null;}
			if($ts){ return $ts[0]['SUM(amount)'];}
		}
	}
	else{ return 0;}

}

function total_unaproved_withdraw($c=null,$h=null){ 
	// OUTPUT : total withdrawed(aproved) amount
	if(i['id']){

		global $DB; $aa = 0;

		if(!$h){$h=i['id'];}

		if($c){
			$SQL = "SELECT SUM(amount) FROM `withdraw` WHERE `user` = '".$h."' AND `c` = '".$c."' AND `status` != 7;";
			$results = mysqli_query($DB, $SQL);	
			if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
			else{$ts = null;}
			if($ts){ return $ts[0]['SUM(amount)'];}
		}
	}
	else{ return 0;}

}







function withdrawwww($Q=null){
	// OUTPUT : return output will only true or false but withdraw function works with database
	// INPUT : required Array(withdraw_from[invest or refers],ccc(currency))

	$time=gmdate("Hi");//tmp 11 am to 6pm	
	$time=999; // disabling withdraw work time


	if($time>430 and $time<1230){ //  WITHDRAW is allow between 11:00 to 18:00


		$first_withdraw=first_withdraw(i['id']);
		$first_withdraw=44;	// disabling first withdraw rule


		if($first_withdraw>24){	 // first withdraw is allow after 24hours
			global $DB;$aa = 0;
			if(is_array($Q)){ $amount=$Q['amount']; $id = $Q['id'];$from = $Q['from'];$ccc = $Q['ccc']; $cyrpto_id = $Q['cyrpto_id']; $wc = $Q['wc']; }


			if($amount and $wc){ 
				if($wc=='TRX' or $wc=='trx'){		
					$WCA=$Q['amount']*s['TOM/TRX'];
				}
				elseif($wc=='INR' or $wc=='inr'){
					$WCA=$Q['amount']*s['TOM/INR'];			
				}
				$WCA=$WCA*base;

			}






















			if($from == 'Wallet'){	
				$amount=$amount*base;
				//# Withdraw from Investment
				if($ccc){
					if($amount <= i['Wallet']){ // was $WA > $MW
						$user_id=i['id'];$id2 = clean(GMT()); //$amount=$WA;		
						/*	//# TAX	 $tax=10; // tax in % $tax=$amount*$tax/100; $amount=$amount-$tax;	 //* TAX	*/
						$tax=0.00;


						$zzzxxx=1;	
						if($zzzxxx){	
							if($user_id and $amount and $ccc){
								$SQL = "INSERT INTO `withdraw` (`id`, `id2`, `amount`, `c`,  `wca`,  `wc`, `tax`, `type`, `refer_id`, `invest_id`, `user`, `status`, `cyrpto`, `cyrpto_id`, `about`, `created`, `modified`, `aproved`) VALUES (NULL, '".$id2."', '".$amount."', '".$ccc."', '".$WCA."', '".$wc."', '".$tax."', 'Wallet', NULL, NULL, '".$user_id."', '1', NULL, '".$cyrpto_id."', NULL, current_timestamp(), current_timestamp(), NULL);";
								$results = mysqli_query($DB, $SQL);	
								if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
								else{$ts = null;}

								// IS CREATED?
								$withdraw = withdrawed($id2);
								if($withdraw['id']){ 



									$Wallet=i['Wallet'];
									if($amount){$Wallet=$Wallet-$amount;
												$SQL = "UPDATE `".prefix."users` SET `Wallet` = '".$Wallet."' WHERE `".prefix."users`.`ID` = ".i['id'];
												global $DB; $results = mysqli_query($DB, $SQL);	
											   }



									return array('status'=>1,'amount'=>$amount); 

								}
								else{ return 'tried but cant create a withdraw request'; }

							}
							else{ return 'Not Enough Sources(User_ID,Amount,CCC,Type) to create a withdraw'; }
						}
						else{ return 'Only Single Withdraw Allow in 24 hours.'; }


					}
					else{ return 'Lower than min withdraw : '.d2p($WA).' '.$cccc; }

					//* Withdraw from Investment
				}
				else{ $echo='Provide currency please';}
			}







			elseif($from == 'Current'){	
				$amount=$amount*base;
				//# Withdraw from Investment
				if($ccc){
					if($amount <= i['Current']){ // was $WA > $MW
						$user_id=i['id'];$id2 = clean(GMT()); //$amount=$WA;		
						/*	//# TAX	 $tax=10; // tax in % $tax=$amount*$tax/100; $amount=$amount-$tax;	 //* TAX	*/
						$tax=0.00;


						$zzzxxx=1;	
						if($zzzxxx){	
							if($user_id and $amount and $ccc){
								$SQL = "INSERT INTO `withdraw` (`id`, `id2`, `amount`, `c`,  `wca`,  `wc`, `tax`, `type`, `refer_id`, `invest_id`, `user`, `status`, `cyrpto`, `cyrpto_id`, `about`, `created`, `modified`, `aproved`) VALUES (NULL, '".$id2."', '".$amount."', '".$ccc."', '".$WCA."', '".$wc."', '".$tax."', 'Current', NULL, NULL, '".$user_id."', '1', NULL, '".$cyrpto_id."', NULL, current_timestamp(), current_timestamp(), NULL);";
								$results = mysqli_query($DB, $SQL);	
								if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
								else{$ts = null;}

								// IS CREATED?
								$withdraw = withdrawed($id2);
								if($withdraw['id']){ 



									$Wallet=i['Current'];
									if($amount){$Wallet=$Wallet-$amount;
												$SQL = "UPDATE `".prefix."users` SET `Current` = '".$Wallet."' WHERE `".prefix."users`.`ID` = ".i['id'];
												global $DB; $results = mysqli_query($DB, $SQL);	
											   }



									return array('status'=>1,'amount'=>$amount); 

								}
								else{ return 'Current : Tried but cant create a withdraw request'; }

							}
							else{ return 'Current : Not Enough Sources(User_ID,Amount,CCC,Type) to create a withdraw'; }
						}
						else{ return 'Current : Only Single Withdraw Allow in 24 hours.'; }


					}
					else{ return 'Current : Lower than min withdraw : '.d2p($WA).' '.$cccc; }

					//* Withdraw from Investment
				}
				else{ $echo='Current : Provide currency please';}
			}













			elseif($from == 'Stack'){	
				$amount=$amount*base;
				//# Withdraw from Investment
				if($ccc){
					if($amount < i['Stack']){ // was $WA > $MW
						$user_id=i['id'];$id2 = clean(GMT()); //$amount=$WA;		
						/*	//# TAX	 $tax=10; // tax in % $tax=$amount*$tax/100; $amount=$amount-$tax;	 //* TAX	*/
						$tax=0.00;


						$zzzxxx=1;	
						if($zzzxxx){	
							if($user_id and $amount and $ccc){
								$SQL = "INSERT INTO `withdraw` (`id`, `id2`, `amount`, `c`, `wca`, `wc`, `tax`, `type`, `refer_id`, `invest_id`, `user`, `status`, `cyrpto`, `cyrpto_id`, `about`, `created`, `modified`, `aproved`) VALUES (NULL, '".$id2."', '".$amount."', '".$ccc."', '".$WCA."',  '".$wc."', '".$tax."', 'Stack', NULL, NULL, '".$user_id."', '1', NULL, '".$cyrpto_id."', NULL, current_timestamp(), current_timestamp(), NULL);";
								$results = mysqli_query($DB, $SQL);	
								if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
								else{$ts = null;}

								// IS CREATED?
								$withdraw = withdrawed($id2);
								if($withdraw['id']){ 



									$Wallet=i['Stack'];
									if($amount){$Wallet=$Wallet-$amount;
												$SQL = "UPDATE `".prefix."users` SET `Stack` = '".$Wallet."' WHERE `".prefix."users`.`ID` = ".i['id'];
												global $DB; $results = mysqli_query($DB, $SQL);	
											   }



									return array('status'=>1,'amount'=>$amount); 

								}
								else{ return 'tried but cant create a withdraw request'; }

							}
							else{ return 'Not Enough Sources(User_ID,Amount,CCC,Type) to create a withdraw'; }
						}
						else{ return 'Only Single Withdraw Allow in 24 hours.'; }


					}
					else{ return 'Lower than min withdraw : '.d2p($WA).' '.$ccc; }

					//* Withdraw from Investment
				}
				else{ $echo='Provide currency please';}
			}




















			elseif($from == 'Refer'){	
				$amount=$amount*base;
				//# Withdraw from Investment
				if($ccc){
					if($amount < i['Refer']){ // was $WA > $MW
						$user_id=i['id'];$id2 = clean(GMT()); //$amount=$WA;		
						/*	//# TAX	 $tax=10; // tax in % $tax=$amount*$tax/100; $amount=$amount-$tax;	 //* TAX	*/
						$tax=0.00;


						$zzzxxx=1;	
						if($zzzxxx){	
							if($user_id and $amount and $ccc){
								$SQL = "INSERT INTO `withdraw` (`id`, `id2`, `amount`, `c`, `wca`, `wc`, `tax`, `type`, `refer_id`, `invest_id`, `user`, `status`, `cyrpto`, `cyrpto_id`, `about`, `created`, `modified`, `aproved`) VALUES (NULL, '".$id2."', '".$amount."', '".$ccc."', '".$WCA."',  '".$wc."', '".$tax."', 'Refer', NULL, NULL, '".$user_id."', '1', NULL, '".$cyrpto_id."', NULL, current_timestamp(), current_timestamp(), NULL);";
								$results = mysqli_query($DB, $SQL);	
								if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
								else{$ts = null;}

								// IS CREATED?
								$withdraw = withdrawed($id2);
								if($withdraw['id']){ 



									$Wallet=i['Refer'];
									if($amount){$Wallet=$Wallet-$amount;
												$SQL = "UPDATE `".prefix."users` SET `Refer` = '".$Wallet."' WHERE `".prefix."users`.`ID` = ".i['id'];
												global $DB; $results = mysqli_query($DB, $SQL);	
											   }



									return array('status'=>1,'amount'=>$amount); 

								}
								else{ return 'tried but cant create a withdraw request'; }

							}
							else{ return 'Not Enough Sources(User_ID,Amount,CCC,Type) to create a withdraw'; }
						}
						else{ return 'Only Single Withdraw Allow in 24 hours.'; }


					}
					else{ return 'Lower than min withdraw : '.d2p($WA).' '.$ccc; }

					//* Withdraw from Investment
				}
				else{ $echo='Provide currency please';}
			}



















			elseif($from == 'invest'){	
				//# Withdraw from Investment
				if($ccc){	
					$WA = total_wa($ccc);

					$wa_refers=0;	
					$wa_refers=wa_refers(i['id']);
					$wa_refers=0;


					$wa_refer_invest=0;
					$wa_refer_invest=wa_refer_invest();	

					$WA=$WA+$wa_refers+$wa_refer_invest;// refers reward + roi income
					$MW = p2d(min_withdraw($ccc));
					if($amount < balance('trx')){ // was $WA > $MW

						//# first withdraw after 24h



						// WA REFERS



						// WA REFERS

						$user_id=i['id'];$id2 = clean(GMT()); //$amount=$WA;



						/*	
	//# TAX	
	$tax=10; // tax in %
	$tax=$amount*$tax/100;
	$amount=$amount-$tax;	
	//* TAX	

	*/





						$zzzxxx=1;	
						if($zzzxxx){	
							if($user_id and $amount and $ccc){
								$SQL = "INSERT INTO `withdraw` (`id`, `id2`, `amount`, `c`, `tax`, `type`, `refer_id`, `invest_id`, `user`, `status`, `cyrpto`, `cyrpto_id`, `about`, `created`, `modified`, `aproved`) VALUES (NULL, '".$id2."', '".$amount."', '".$ccc."', '".$tax."', 'invest', NULL, NULL, '".$user_id."', '1', NULL, '".$cyrpto_id."', NULL, current_timestamp(), current_timestamp(), NULL);";
								$results = mysqli_query($DB, $SQL);	
								if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
								else{$ts = null;}

								// IS CREATED?
								$withdraw = withdrawed($id2);
								if($withdraw['id']){ 

									if(refer_single_reward){
										//# reset refers reward
										$SQL="UPDATE `refers` SET `status` = '9' WHERE `refers`.`user` = '".i['id']."'";
										$results = mysqli_query($DB, $SQL);	
										if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
										else{$ts = null;}
										unset($SQL);
									}
									//* reset refers reward



									//# reset refers_invest reward
									$reset_wa_refer_invest = reset_wa_refer_invest($ccc);
									if($reset_wa_refer_invest){$return=array('status'=>1,'amount'=>$WA); }
									else{ $return='withdraw Reset failed';  }
									unset($SQL);

									//* reset refers_invest reward





									//# reset investsments roi
									$reset_wa = reset_wa($ccc);
									if($reset_wa){return array('status'=>1,'amount'=>$WA); }
									else{ return 'withdraw Reset failed';  }
									//* reset investments roi




								}
								else{ return 'tried but cant create a withdraw request'; }

							}
							else{ return 'Not Enough Sources(User_ID,Amount,CCC,Type) to create a withdraw'; }
						}
						else{ return 'Only Single Withdraw Allow in 24 hours.'; }









					}
					else{ return 'Lower than min withdraw : '.d2p($WA).' '.$ccc; }

					//* Withdraw from Investment
				}
				else{ $echo='Provide currency please';}
			}











			elseif($from == 'referrrrr'){
				//# Withdraw from refer rewards
				$refer=refer($id);	
				$levels=levels(i['id']);$level=$levels['level'];	
				if($level[1]>=$refer['level'])
				{
					if($id){	
						$SQL="SELECT * FROM `withdraw` WHERE `refer_id` = ".$id;
						$results = mysqli_query($DB, $SQL);	
						if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
						else{$ts = null;}
						if($ts[0]){ return 'Already Requested';}
						else{
							// withdraw not create before, creating new	


							$refer=refer($id);	
							if($refer['status']==7 and $refer['aproved']){
								$user_id=i['id'];$id2 = clean(GMT());$amount=$refer['amount'];	


								//# TAX	
								$tax=5; // tax in %
								$tax=$amount*$tax/100;
								$amount=$amount-$tax;	
								//* TAX

								if($user_id and $amount and $refer['c']){
									$SQL = "INSERT INTO `withdraw` (`id`, `id2`, `amount`, `c`, `tax`, `type`, `refer_id`, `invest_id`, `user`, `status`, `cyrpto`, `about`, `created`, `modified`, `aproved`) VALUES (NULL, '".$id2."', '".$amount."', '".$refer['c']."', '".$tax."', 'refer', '".$refer['id']."', NULL, '".$user_id."', '1', NULL, NULL, current_timestamp(), current_timestamp(), NULL);";

									$results = mysqli_query($DB, $SQL);	
									if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
									else{$ts = null;}

									// IS CREATED?
									$withdraw = withdrawed($id2);
									if($withdraw['id']){ 

										// Updating refer transaction status to withdrawed

										$SQL="UPDATE `refers` SET `status` = '9' WHERE `refers`.`id` = ".$id;
										$results = mysqli_query($DB, $SQL);	
										if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
										else{$ts = null;}

										$refer=refer($id);

										if($refer['status']==9){ return array('status'=>1,'amount'=>$amount); }
										else{ return 'Refer status change failed';  }
									}
									else{ return 'tried but cant create a withdraw request'; }
								}
								else{ return 'Not Enough Sources(User_ID,Amount,CCC,Type) to create a withdraw'; }
							}
							else{ return 'Not Withdrawable'; }
						}
					}	
					else{$echo='ID Empty';}	
					//* DIRECT=>REFER
				}
				else{ return 'Need enough directs('.$refer['level'].') to withdraw this refer reward, You have only '.$level[1].' direct referels now till.'; }
				//* Withdraw from refers

			}
















			elseif($from == 'nwiiiiii'){
				//# Withdraw from NWI
				$nwi=nwi();	$WA=$nwi['withdrawable'];
				if($nwi['status']==7 and clean($nwi['aproved'])){

					if($nwi['withdrawable']>=100){

						$user_id=i['id'];$id2 = clean(GMT());$amount=$nwi['withdrawable'];

						//# TAX	
						$tax=10;
						$tax=$amount*$tax/100;
						$amount=$amount-$tax;	
						//* TAX

						if($user_id and $nwi['withdrawable'] and $id2){
							$SQL = "INSERT INTO `withdraw` (`id`, `id2`, `amount`, `c`, `tax`, `type`, `refer_id`, `invest_id`, `user`, `status`, `cyrpto`, `about`, `created`, `modified`, `aproved`) VALUES (NULL, '".$id2."', '".$amount."', 'TRX', '".$tax."', 'nwi', NULL, NULL, '".$user_id."', '1', NULL, NULL, current_timestamp(), current_timestamp(), NULL);";

							$results = mysqli_query($DB, $SQL);	
							if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
							else{$ts = null;}	
							// IS CREATED?
							$withdraw = withdrawed($id2);
							if($withdraw['id']){ 
								// Updating NWI status to withdrawed
								$SQL="UPDATE `nwi` SET `withdrawed` = `withdrawable` + `withdrawed` WHERE `nwi`.`user` = ".i['id'];
								$results = mysqli_query($DB, $SQL);	
								$SQL="UPDATE `nwi` SET `withdrawable` = 0 WHERE `nwi`.`user` = ".i['id'];
								$results = mysqli_query($DB, $SQL);	
								$nwi=nwi();
								if($nwi['withdrawable']<1){return array('status'=>1,'amount'=>$WA); }
								else{ return 'NWI status change failed';  }
							}
							else{ return 'tried but cant create a withdraw request'; }
						}
						else{ return 'Not Enough Sources(User_ID,Amount,CCC,Type) to create a withdraw'; }
					}
					else{ return 'Must be higher than 100 TRX'; }
				}
				else{ return 'Not Withdrawable, may be not aproved'; }







				//* Withdraw NWI

			}	
			else{ return 'From var is empty, so we cant consider that from where you want to withdraw'; }










		}
		else{ return 'Withdraw not activated on your account, You need to wait 24 hours after your first investment...'.$first_withdraw; }
	}	
	else{ return 'Withdraw allow bwtween 10:00 AM to 06:00 PM'; }
}






function TransactionByOrderID($Q=null){
	if(i['id']){

		$SQL = "SELECT * FROM `transactions` WHERE `OrderID` = ".$Q; 
		global $DB; $aa=0;$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
		else{$ps=null;}
	}

	return $ps[0];

}







function transaction_by_crypto($Q=null){
	// OUTPUT : single transaction data from DB by crypto($Q)
	global $DB;$aa = 0;
	$SQL = "SELECT * FROM `transactions` WHERE `cyrpto` = '".$Q."'";
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0];
}




function Transaction($Q=null){
	// OUTPUT : single transaction data from DB by ID($Q)
	if($Q){

		//if(strlen((string) $Q) > 10){$iidd = 'id2';} else{$iidd = 'id';}
		$SQL = "SELECT * FROM `Coinpods_transaction` WHERE `id` = ".$Q;
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		return $ts[0];
	}
}



function Transactions($Q=null){
	// OUTPUT : ALL transactions's data from DB by username($Q)
	if(is_array($Q)){ 
		$Name=$Q['name']; $LIMIT=$Q['LIMIT']; $OFFSET=$Q['OFFSET']; $User=$Q['user']; $CCC=$Q['CCC']; $Type=$Q['ttype'];  $Status=$Q['status']; $WalletName=$Q['walletname']; } else{ $User = $Q; }	



	if(!$LIMIT){$LIMIT=11;}	
	if(!$OFFSET){$OFFSET=0;}

	if($Status){ $Status=" AND `status` = '".$Status."'"; }
	if($CCC){ $CCC=" AND `ccc` = '".$CCC."'"; }
	if($Type){ $Type=" AND `ttype` = '".$Type."'"; }
	if($Name){ $Name=" AND `name` LIKE '%".$Name."%'"; }
	if($WalletName){ $WalletName=" AND `walletname` = '".$WalletName."'"; }





	if(i['Role'] == 'Manager'){
		$Where = " `user` != ''".$CCC.$Type.$Name.$WalletName.$Status;
		if($User){ $Where = " `user` = '".$User."'".$CCC.$Type.$WalletName.$Name; }
		$SQL = "SELECT * FROM `Coinpods_transaction` WHERE ".$Where." ORDER BY `Coinpods_transaction`.`id` DESC  LIMIT ".$LIMIT." OFFSET ".$OFFSET;
	}
	else{

		if(!$User){$User=i['id'];}

		$Where = " `user` = '".$User."'".$CCC.$Type.$WalletName.$Name.$Status;

		$SQL = "SELECT * FROM `Coinpods_transaction` WHERE ".$Where." ORDER BY `Coinpods_transaction`.`id` DESC  LIMIT ".$LIMIT." OFFSET ".$OFFSET; }

	//if(i['id']==1){echo $SQL;}

	//$DBC = DBC('transaction');
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	//DBD();print_r($DBC);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;

}















function PendingDeposits($Q=null){
	// OUTPUT : ALL transactions's data from DB by status($Q)

	global $DB;$aa = 0;
	$SQL = "SELECT * FROM `Coinpods_transaction` WHERE `balance` = '0' AND `status` = '1' AND `ttype` = 'Deposit' ORDER BY `id` DESC"; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;

}


















function transactionsssssssss($Q=null){
	// OUTPUT : ALL transactions's data from DB by username($Q)
	if(is_array($Q)){ $LIMIT=$Q['LIMIT']; $OFFSET=$Q['OFFSET']; $Q=$Q['user']; }	
	if(!$Q){$Q=i['id'];}
	if(!$LIMIT){$LIMIT=5;}	
	if(!$OFFSET){$OFFSET=0;}


	global $DB;$aa = 0; 
	if(iam['admin'] and !PP){$SQL = "SELECT * FROM `transactions` ORDER BY `transactions`.`id` DESC  LIMIT ".$LIMIT." OFFSET ".$OFFSET; }
	else{$SQL = "SELECT * FROM `transactions` WHERE `from` = '".$Q."' ORDER BY `transactions`.`id` DESC  LIMIT ".$LIMIT." OFFSET ".$OFFSET; }
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;
}







function transactions0($Q=null){
	// OUTPUT : ALL transactions's data from DB by status($Q)
	if(iam['admin']){
		global $DB;$aa = 0;
		$SQL = "SELECT * FROM `transactions` WHERE `status` = ".$Q; 
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		return $ts;
	}
	else{return false;}
}
function transactions0counts($Q=null){
	// OUTPUT : ALL transactions's data from DB by status($Q)
	if(iam['admin']){
		global $DB;$aa = 0;
		$SQL = "SELECT COUNT(id) FROM `transactions` WHERE `status` = ".$Q; 
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		if($ts){return $ts[0]['COUNT(id)'];}
	}
	else{return false;}
}






$nwi=array('id'=>0,'status'=>'Pending','roi'=>5,'amount'=>100,'withdrawed'=>0,'withdrawable'=>0,'total'=>1825000000000,'days'=>365,'left'=>365);
define('nwi',$nwi);
function nwi($h=null){
	// OUTPUT : NWI data of current user
	global $DB;$aa = 0;
	if(!$h){$h=i['id'];}


	$SQL = "SELECT * FROM `nwi` WHERE `user` = ".$h; 
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	if($ts){return $ts[0];}
	else{return nwi;}
}







function transactionnnnnnnnnnnnn($Q=null){
	// OUTPUT : single transaction data from DB by ID($Q)
	if(i['id']){
		global $DB;$aa = 0;
		if(strlen((string) $Q) > 10){$iidd = 'id2';} else{$iidd = 'id';}
		$SQL = "SELECT * FROM `transactions` WHERE `".$iidd."` = ".$Q;
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		return $ts[0];
	}
}



function investment($Q=null){
	// OUTPUT : single transaction data from DB by ID($Q)
	if($Q){
		global $DB;$aa = 0;
		$SQL = "SELECT * FROM `transactions` WHERE `cyrpto_id` = '".$Q."'";
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		return $ts[0];
	}
}






function roi_for_amount($Q=null){
	// OUTPUT : ROI in % 	
	// INPUT : amount, min amount, max amount, min roi, max roi
	// may be used in function plan()

	$min_amount = $Q['min_amount'];
	$max_amount = $Q['max_amount'];
	$min_roi = $Q['min_roi'];
	$max_roi = $Q['max_roi'];

	$amount = $Q['amount'];

	$A_diff = $max_amount-$min_amount;
	$A_originol = $amount-$min_amount;
	$A_originol = $A_originol*100/$A_diff;

	$R_diff = $max_roi-$min_roi;
	$return = $A_originol*$R_diff/100;
	return $return+$min_roi;

}






function global_invest($c=null){ 
	// OUTPUT : Total of invest amount(aproved) by Currency
	// INPUT : Currency
	global $DB; $aa = 0;

	if($c){
		$SQL = "SELECT SUM(amount) FROM `transactions` WHERE `c` = '".$c."';";
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(amount)'];}
	}

}




function invest_where($Q=null){
	// OUTPUT : multiple withdraw data from DB by user_ID($Q)
	global $DB;$aa = 0;
	$SQL = "SELECT * FROM `transactions` WHERE ".$Q;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;
}






function total_roi($c=null,$h=null){ 
	// OUTPUT : total returns(withdrawable + withdrawed) from user's investment	
	if(i['id']){

		global $DB; $aa = 0;
		if(!$h){$h=i['id'];}

		if($c){
			$SQL = "SELECT SUM(`withdrawable`),SUM(`withdrawed`) FROM `transactions` WHERE `from` = '".$h."' AND `c` = '".$c."';"; 
			$results = mysqli_query($DB, $SQL);	
			if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
			else{$ts = null;}
			if($ts){ return $ts[0]['SUM(`withdrawable`)']+$ts[0]['SUM(`withdrawed`)'];}
		}
	}
	else{return 0;}

}

function total_wa($c=null,$h=null){ 
	// OUTPUT : total withdrawable from user's investment(aproved)
	if(i['id']){
		if(!$h){$h=i['id'];}

		global $DB; $aa = 0;

		if($c and $h){
			$SQL = "SELECT SUM(`withdrawable`) FROM `transactions` WHERE `from` = '".$h."' AND `c` = '".$c."'"; 
			$results = mysqli_query($DB, $SQL);	
			if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
			else{$ts = null;}
			if($ts){ return $ts[0]['SUM(`withdrawable`)'];}
		}
	}
	else{return 0;}

}



function total_invest($c=null,$h=null){ 
	// OUTPUT : total investved(aproved) amount
	if(i['id']){
		global $DB; $aa = 0;
		if(!$h){$h=i['id'];}

		if($c){
			$SQL = "SELECT SUM(amount) FROM `transactions` WHERE `from` = '".$h."' AND `c` = '".$c."'";
			$results = mysqli_query($DB, $SQL);	
			if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
			else{$ts = null;}
			if($ts){ return $ts[0]['SUM(amount)'];}
		}
	}
	else{ return 0; }

}





function aprove_invest($Q){
	// OUTPUT : Aprove a investment transaction by ADMIN Panel
	global $DB;
	if(is_array($Q)){ $id = $Q['id'];$cyrpto=$Q['cyrpto'];$cyrpto_id=$Q['cyrpto_id']; } else{ $id = 0; $cyrpto = 0; }
	if($id and $cyrpto){
		$SQL = "UPDATE `transactions` SET `status` = '7', `cyrpto` = '".$cyrpto."', `cyrpto_id` = '".$cyrpto_id."', `aproved` = '".GMT()."'  WHERE `transactions`.`id` = ".$id; 
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		return $ts;
	}
	else{ echo ' empty = id or cyrpto'; }
}










function transaction_optimize($Q=null){
	//dont need in this plan

	/*

// OUTPUT : Optimize a investment by id($Q)
// INPUT : Invest_id

//invest_optimize_every_day($Q);	



if($Q){
global $DB;$aa = 0;

// get Invest	
	$SQL = "SELECT * FROM `transactions` WHERE `id` = ".$Q;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	

if($ts){ $t = $ts[0];
// is Invest availble

//if($t['status'] == 7 and $t['aproved']){	 
//# is Invest aproved	




//# END of Invest
$end = time_plus_hours(array( 'time' => $t['created'], 'hours' => $t['limit'] )); 
if($end){$end = " ,`end` = '".$end."'";} else{ $end = null;}
//* END of Invest			











//# ROI	
if($t['roi_updated']){$ru = $t['roi_updated'];} else{$ru = $t['created'];}
$DF = diff_in_seconds(array( 'start' => $ru, 'end' => GMT() ));
$diff = diff_in_seconds(array( 'start' => $t['created'], 'end' => GMT() ));
$age=$diff;


$period = $t['limit'];$period = $period*hour; 
$life=$period;


if($life > $age){
// # is Invest EXPIRED	



//# Is Holiday	
$holiday=Holiday();
$holiday=0;
if($holiday){
//Don't update ROI 
}
else
{

	$D2=2222*day;
	$TD=$DF;//TD:Time Diffrance(seconds) = last roi updated to current time
	if($TD>$D2){
		// Time Diffrance is more than 2 days, means may be its holiday(99% chances)

//# Updating ROI DF=DF-HD;		
$DF=$DF-$D2;

$amount = d2p($t['amount']); $amount = $amount/100;
$ROI = $t['roi']; $ROI = $ROI/hour;$withdrawable = $ROI*$DF;$wable = $withdrawable;
$withdrawable = $withdrawable*base;$withdrawable = $withdrawable*$amount;
$withdrawable = $withdrawable + $t['withdrawable'];

$SET = "`withdrawable` = ".$withdrawable." ,`roi_updated` = '".GMT()."' ,`modified` = '".GMT()."'".$end;			
$SQL = "UPDATE `transactions` SET ".$SET." WHERE `transactions`.`id` = ".$t['id'];
$results = mysqli_query($DB, $SQL);$SET=null;
//* Updating ROI DF=DF-D2;		


	}
	else{
		// Time Diffrance is not more than 2 days, means no holiday detected



$amount = d2p($t['amount']); $amount = $amount/100;
$ROI = $t['roi']; $ROI = $ROI/hour;$withdrawable = $ROI*$DF;$wable = $withdrawable;
$withdrawable = $withdrawable*base;$withdrawable = $withdrawable*$amount;
$withdrawable = $withdrawable + $t['withdrawable'];

$SET = "`withdrawable` = ".$withdrawable." ,`roi_updated` = '".GMT()."' ,`modified` = '".GMT()."'".$end;			
$SQL = "UPDATE `transactions` SET ".$SET." WHERE `transactions`.`id` = ".$t['id'];
$results = mysqli_query($DB, $SQL);$SET=null;


	}
}
//* Is Holiday	



// # is Invest EXPIRED		
}	
else{ $rrooii = 'ROI Total period expired';}
//echo number_format(d2p($wable),40);
//* ROI






//* is Invest Aproved	
//}else{ return 'Investment not aproved now till.';}
}
}

*/
}







function invest_optimize_every_day($Q=null){
	// OUTPUT : Optimize a investment by id($Q)
	// INPUT : Invest_id

	if($Q){
		global $DB;$aa = 0;

		// get Invest	
		$SQL = "SELECT * FROM `transactions` WHERE `id` = ".$Q;
		$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	

		if($ts){ $t = $ts[0];
				// is Invest availble

				//if($t['status'] == 7 and $t['aproved']){	 
				//# is Invest aproved	




				//# END of Invest
				$end = time_plus_hours(array( 'time' => $t['created'], 'hours' => $t['limit'] )); 
				if($end){$end = " ,`end` = '".$end."'";} else{ $end = null;}
				$end='';
				//* END of Invest			











				//# ROI	
				if($t['roi_updated']){$ru = $t['roi_updated'];} else{$ru = $t['created'];}
				$DF = diff_in_seconds(array( 'start' => $ru, 'end' => GMT() )); $ROI_age=$DF; // getting ROI_age(seconds) of investment
				$diff = diff_in_seconds(array( 'start' => $t['created'], 'end' => GMT() )); // getting age of investment
				$age=$diff;
				$period = $t['limit'];$period = $period*hour; 
				$life=$period;


				if($life > $age){
					// # is Invest EXPIRED	



					//# Is Holiday	
					$holiday=Holiday();
					$holiday=0;
					if($holiday){
						//Don't update ROI 
					}
					else
					{


						if($ROI_age>day){ // its mean ROI last update is older than 24 hours






							$D2=2222*day;
							$TD=$DF;//TD:Time Diffrance(seconds) = last roi updated to current time
							if($TD>$D2){
								// Time Diffrance is more than 2 days, means may be its holiday(99% chances)

								//# Updating ROI DF=DF-HD;		
								$DF=$DF-$D2;

								$amount = d2p($t['amount']); $amount = $amount/100;
								$ROI = $t['roi']; $ROI = $ROI/hour;$withdrawable = $ROI*$DF;$wable = $withdrawable;
								$withdrawable = $withdrawable*base;$withdrawable = $withdrawable*$amount;
								$withdrawable = $withdrawable + $t['withdrawable'];

								$SET = "`withdrawable` = ".$withdrawable." ,`roi_updated` = '".GMT()."' ,`modified` = '".GMT()."'".$end;			
								$SQL = "UPDATE `transactions` SET ".$SET." WHERE `transactions`.`id` = ".$t['id'];
								$results = mysqli_query($DB, $SQL);$SET=null;
								//* Updating ROI DF=DF-D2;		


							}







							else{ // Time Diffrance is not more than 2 days, means no holiday detected

								$ROI_age_in_days=$ROI_age/day;	
								$ROI_age_in_days=explode('.',$ROI_age_in_days);$ROI_age=$ROI_age_in_days[0];




								$updated = time_plus_days(array( 'time' => $ru, 'days' => $ROI_age )); 


								$amount = d2p($t['amount']); $amount = $amount/100;

								$ROI = $t['roi']; 
								$ROI=$ROI*12; // evry hour multiuplying to 12h of working hour of a day	

								$withdrawable=$ROI*$ROI_age;$wable = $withdrawable;
								$withdrawable = $withdrawable*base;$withdrawable = $withdrawable*$amount;
								$withdrawable = $withdrawable + $t['withdrawable'];



								$SET = "`withdrawable` = '".$withdrawable."' ,`roi_updated` = '".$updated."' ,`modified` = '".GMT()."'".$end;			
								$SQL = "UPDATE `transactions` SET ".$SET." WHERE `transactions`.`id` = ".$t['id'];
								$results = mysqli_query($DB, $SQL);$SET=null;


							}






						}	
						else{ $rrooii = 'ROI upading need 24 hours';}	
					}
					//* Is Holiday	



					// # is Invest EXPIRED		
				}	
				else{ $rrooii = 'ROI Total period expired';}
				//echo number_format(d2p($wable),40);
				//* ROI






				//* is Invest Aproved	
				//}else{ return 'Investment not aproved now till.';}
			   }
	}


}














function InvestByTRX($Q=null){	
	// OUTPUT : Create a new investment by TRX API
	// Human : Admin

	global $DB;$aa = 0;
	if(is_array($Q)){ $crypto_id = $Q['crypto_id']; $crypto_user = $Q['crypto_user']; $amount = $Q['amount']; $ccc = $Q['ccc']; }



	/*
    //# Level Income	
    $l[1]=$l[2]=$l[3]=$l[4]=$l[5]=$l[6]=$l[7]=$l[8]=$l[9]=$l[10]=$l[11]=
    $aa = 0;$invest = $amount; $lps = levels_plan();
    foreach($lps as $lp){$aa++;$l[$aa] = p2d($invest*$lp['income']/100);}
    //* Level Income
     */  






	if($crypto_id and $crypto_user and $amount and $ccc){


		$trx=trx($crypto_id);




		if(0>1){	




			// get plan data by currency and amount
			$plan = plan(array( 'ccc' => $ccc, 'amount' => $amount, ));
			if($plan['id'] and  $plan['roi'] and $plan['limit'] and $plan['type'] ){ 


				$ROI = $plan['roi']; $plan_id = $plan['id']; $limit = $plan['limit'];$type = $plan['type'];
				$id2 = clean(GMT());


				$SQL="INSERT INTO `transactions` (`id`, `plan`, `work_start`, `work_end`, `limit`, `type`, `amount`, `c`, `roi`, `status`, `cyrpto_id`, `cyrpto`, `from`, `roi_updated`, `withdrawable`, `withdrawed`, `withdraw_ok`, `about`, `end`, `created`, `modified`) VALUES (NULL, '".$plan['id']."', '".$plan['work_start']."', '".$plan['work_end']."', '".$plan['limit']."', '".$plan['type']."', '".p2d($amount)."', '".$ccc."', '".$plan['roi']."', '1', '".$crypto_id."', '".$crypto_user."', '".$crypto_user."', NULL, '0.00000000000000000000', '0.00000000000000000000', NULL, NULL, NULL, current_timestamp(), current_timestamp());";


				$results = mysqli_query($DB, $SQL);	
				if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
				else{$ts = null;}
				$Human=user_by_username($crypto_user);

				enable_level($Human['id'],$plan['level']);


				//	user_level(array('crypto_user'=>$crypto_user, 'plan'=>$plan_id)); // opening levels for invest user

				return $Human['id'].' : '.$plan['level'];
			}
			else{ return 'plan not detected with response : '.$plan['id'].' : '.$plan['roi'].' : '.$plan['limit'].' : '.$plan['type']; }



		}
		else{ return 'nwwwwwwwwwwwwwwww'; }



	}
	else{ return 'Not Enough Arguments'; }
}





function invest($Q=null){	
	// OUTPUT : Create a new investment by Order
	// Human : Admin

	global $DB;$aa = 0;
	if(is_array($Q)){ $OrderID = $Q['OrderID']; $from = $Q['from'];  $crypto_user = $Q['crypto_user']; $amount = $Q['amount']; $ccc=$Q['ccc']; $OCA=$Q['OCA']; $OCC=$Q['OCC'];  }

	if(i['id']){
		//# Level Income	
		$l[1]=$l[2]=$l[3]=$l[4]=$l[5]=$l[6]=$l[7]=$l[8]=$l[9]=$l[10]=$l[11]=
			$aa = 0;$invest = $amount; $lps = levels_plan();
		foreach($lps as $lp){$aa++;$l[$aa] = p2d($invest*$lp['income']/100);}
		//* Level Income

		$L1=p2d($amount*5/100); // 5% Referel reward




		if($OrderID and $from and $amount and $ccc){
			// get plan data by currency and amount
			$plan = plan(array( 'ccc' => $ccc, 'amount' => $amount, ));
			if($plan['id'] and  $plan['roi'] and $plan['limit'] and $plan['type'] ){ 


				$ROI = $plan['roi']; $plan_id = $plan['id']; $limit = $plan['limit'];$type = $plan['type'];
				$id2 = clean(GMT());


				$SQL="INSERT INTO `transactions` (`id`, `OrderID`, `OCA`, `OCC`, `plan`, `work_start`, `work_end`, `limit`, `type`, `amount`, `c`, `roi`, `status`, `cyrpto_id`, `cyrpto`, `from`, `roi_updated`, `withdrawable`, `withdrawed`, `withdraw_ok`, `about`, `end`, `created`, `modified`, `l1`) VALUES (NULL, '".$OrderID."', '".p2d($OCA)."', '".$OCC."', '".$plan['id']."', '".$plan['work_start']."', '".$plan['work_end']."', '".$plan['limit']."', '".$plan['type']."', '".p2d($amount)."', '".$ccc."', '".$plan['roi']."', '1', '".$crypto_id."', '".$crypto_user."', '".$from."', NULL, '0.00000000000000000000', '0.00000000000000000000', NULL, NULL, NULL, current_timestamp(), current_timestamp(), '".$L1."');";


				$results = mysqli_query($DB, $SQL);	
				if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
				else{$ts = null;}


				//$Human=user_by_username($crypto_user);

				//enable_level($Human['id'],$plan['level']);


				//	user_level(array('crypto_user'=>$crypto_user, 'plan'=>$plan_id)); // opening levels for invest user

				return $Human['id'].' : '.$plan['level'];
			}
			else{ return 'plan not detected with response : '.$plan['id'].' : '.$plan['roi'].' : '.$plan['limit'].' : '.$plan['type']; }
		}
		else{ return 'Not Enough Arguments'; }

	}
}



function WalletCredit($TID=null){
	// TID = Tranaction ID
	if(i['id']){ // If logged in?
		if($TID){ // If Transaction ID
			$T=transaction($TID);
			if($T){ // If Transaction Found
				if(!$T['Balance']){// If Balance not Credited

					//PriceUpdate('Buy',d2p($T['amount']));


					$WAmount=$T['amount']*100/100;
					$CAmount=$T['amount']*0/100;

					$ii=i(); 
					$Wallet=$ii['Wallet']+$T['amount'];
					$Current=$ii['Current']+$CAmount;


					$SQL="UPDATE `".prefix."users` SET `Wallet` = '".$Wallet."', `Current` = '".$Current."', `WalletUpdated` = '".GMT()."' WHERE `".prefix."users`.`ID` = ".$T['from'];	
					global $DB; $results = mysqli_query($DB, $SQL); // Wallet Balance Updated

					$SQL="UPDATE `transactions` SET `Balance` = '1' WHERE `transactions`.`id` = ".$T['id'];	
					global $DB; $results = mysqli_query($DB, $SQL); // Transaction status updated


				}
			}
		}
	}
}




function TotalBought(){

	if(i['id']){		
		$SQL = "SELECT SUM(amount) FROM `transactions`";
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(amount)']; }
	}
	else{ return 0; }

}



function TotalSold(){

	if(i['id']){		
		$SQL = "SELECT SUM(amount) FROM `withdraw`";
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(amount)']; }
	}
	else{ return 0; }

}







function TotalWithdrawals($Q=null){
	if(i['id']){	
		if($Q){ $SQL="SELECT SUM(`amount`) FROM `".prefix."pods_transaction` WHERE `ttype` = 'Withdraw' AND `status` = '1' AND `user` = '".$Q."';";  }
		else{
			if(i['Role']=='Manager'){ $SQL="SELECT SUM(`amount`) FROM `".prefix."pods_transaction` WHERE `ttype` = 'Withdraw' AND `status` = '1';";  }
			else{ $Q=i['id'];$SQL="SELECT SUM(`amount`) FROM `".prefix."pods_transaction` WHERE `ttype` = 'Withdraw' AND `status` = '1' AND `user` = '".$Q."';"; }
		} 

		if($SQL){		
			global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
			if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
			else{$ts = null;}
			if($ts){ return $ts[0]['SUM(`amount`)']; }
		}
		else{ return 0; }
	}
}


function TotalDeposit($Q=null){
	if(i['id']){	
		if($Q){ $SQL="SELECT SUM(`amount`) FROM `".prefix."pods_transaction` WHERE `ttype` = 'Deposit' AND `status` = '1' AND `user` = '".$Q."';";  }
		else{
			if(i['Role']=='Manager'){ $SQL="SELECT SUM(`amount`) FROM `".prefix."pods_transaction` WHERE `ttype` = 'Deposit' AND `status` = '1';";  }
			else{ $Q=i['id'];$SQL="SELECT SUM(`amount`) FROM `".prefix."pods_transaction` WHERE `ttype` = 'Deposit' AND `status` = '1' AND `user` = '".$Q."';"; }
		} 

		if($SQL){			
			global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	
			if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
			else{$ts = null;}
			if($ts){ return $ts[0]['SUM(`amount`)']; }
		}
		else{ return 0; }	
	}
}









?>