<?php

$PHP['Share']['modified'] = '2024/09/01';
$PHP['Share']['by'] = 'Pawan Kumar';

$PHP['Share']['function'][1] = 'Share_Pair($Q=null)';
$PHP['Share']['function'][2] = 'Share_Pairs($Q=null)';
$PHP['Share']['function'][3] = 'Share_PairNew($Q=null)';
$PHP['Share']['function'][4] = 'Share_PairStatus($Q=null)';
$PHP['Share']['function'][5] = 'Share_PairUpdate($UID=null)';
$PHP['Share']['function'][6] = 'Share_PriceNew($Q=null)';
$PHP['Share']['function'][7] = 'Share_PriceUpdate($Q=null)';
$PHP['Share']['function'][8] = 'Share_PriceStatus($Q=null)';
$PHP['Share']['function'][9] = 'Share_Price($Q=null)';
$PHP['Share']['function'][9] = 'Share_Prices($Q=null)';
$PHP['Share']['function'][10] = 'Share_TradeNew($Q=null)';
$PHP['Share']['function'][11] = 'Share_TradeUpdate($Q=null)';
$PHP['Share']['function'][12] = 'Share_TradeStatus($Q=null)';
$PHP['Share']['function'][13] = 'Share_Trade($Q=null)';
$PHP['Share']['function'][14] = 'Share_Trades($Q=null)';
$PHP['Share']['function'][15] = 'Share_OrderSell($Q=null)';
$PHP['Share']['function'][16] = 'Share_OrderSellUpdate($Q=null)';
$PHP['Share']['function'][17] = 'Share_OrderBuy($Q=null)';
$PHP['Share']['function'][18] = 'Share_OrderBuyStatus($Q=null)';
$PHP['Share']['function'][19] = 'Share_OrderBuyUpdate($Q=null)';
$PHP['Share']['function'][20] = 'Share_Order($Q=null)';
$PHP['Share']['function'][21] = 'Share_Orders($Q=null)';
$PHP['Share']['function'][22] = 'Share_OrderNew($Q=null)';
$PHP['Share']['function'][23] = 'Share_OrderStatus($Q=null)';
$PHP['Share']['function'][24] = 'Share_OrderUpdate($Q=null)';
$PHP['Share']['function'][25] = 'Share_Wallet($Q=null)';
$PHP['Share']['function'][26] = 'Share_Wallets($Q=null)';
$PHP['Share']['function'][27] = 'Share_WalletNew($Q=null)';
$PHP['Share']['function'][28] = 'Share_WalletUpdate($Q=null)';
$PHP['Share']['function'][29] = 'Share_WalletEnable($Q=null)';
$PHP['Share']['function'][30] = 'Share_WalletStatus($Q=null)';
$PHP['Share']['function'][31] = 'RemoveFromShare_Wallet($Q=null)';
$PHP['Share']['function'][32] = 'AddToShare_Wallet($Q=null)';
$PHP['Share']['function'][33] = 'Share_walletBalance($Q=null)';
$PHP['Share']['function'][34] = 'Share_WalletBalances($Q=null)';
$PHP['Share']['function'][35] = 'Share_OrderMatch($Q=null)';
$PHP['Share']['function'][36] = 'Share_Chart($Q=null)';
$PHP['Share']['function'][37] = 'Share_Charts($Q=null)';
$PHP['Share']['function'][38] = 'Share_ChartNew($Q=null)';
$PHP['Share']['function'][39] = 'Share_ChartStatus($Q=null)';
$PHP['Share']['function'][40] = 'Share_ChartUpdate($Q=null)';
$PHP['Share']['function'][41] = 'PendingShareWallets($Q=null)';
$PHP['Share']['function'][42] = 'CreateShareWallets($Q=null)';
$PHP['Share']['function'][43] = 'ShareBuyTotal($Q=null)';



function ShareBuyTotal($Q=null){
// Developer : Pawan Kumar
// Dtae : 2024-09-06
// Input : 
// Output : Total HXS Buy Amount
	
	$SQL="SELECT SUM(`oca`) FROM `Coinpods_transaction` WHERE `user` != 1 AND `ttype` LIKE 'Buy' AND `ccc` LIKE 'hxs' AND `status` = 1 ORDER BY `id` DESC"; 
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	
	$HXSBuyTotal = d2p($ts[0]['SUM(`oca`)']);
	
	/*if($HXSBuyTotal){
		
		$HXS = Currency('HXS');
		$Amount = d2p($HXSBuyTotal);
		$TotalHXS = $Amount*$HXS['price'];
		
		
	
	}*/
	return $HXSBuyTotal;
}





//* Share Wallet Create 

function CreateShareWallets(){
	$aa=0;
	$PendingShareWallets=PendingShareWallets();	 
	if($PendingShareWallets){
		foreach($PendingShareWallets as $PW){ 
			$aa++;
			
			$Share_Wallets = Share_Wallets(['user'=>$PW['ID']]);
			if(!$Share_Wallets){
				
				$Share_WalletNew = Share_WalletNew(['user'=>$PW['ID'], 'name'=>$PW['ID'], 'ccc'=>'ccc']);	
				if($Share_WalletNew){
					
					$Share_WalletNew = Share_WalletNew(['user'=>$PW['ID'], 'name'=>$PW['ID'], 'ccc'=>'usdt']);	
					if($Share_WalletNew){
						
						$SQL1="UPDATE `Coinusers` SET `ShareWallet` = '1' WHERE `Coinusers`.`ID` = '".$PW['ID']."'";
						global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);		
					
					}
				}
			}
			else{
				$SQL1="UPDATE `Coinusers` SET `ShareWallet` = '1' WHERE `Coinusers`.`ID` = '".$PW['ID']."'";
				global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);		
			}
		}
	}
	//echo $aa;
}




function PendingShareWallets(){

	$SQL="SELECT * FROM `Coinusers` WHERE `ShareWallet` = 0 LIMIT 31421";	
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Share Chart Start

function Share_ChartNew($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : name, pair, type, open, close, lowest, highest
// Output : A new entry in the coinpods_spot_chart table.
	
if(is_array($Q)){ $Name=$Q['name'];  $UID=$Q['uid']; $Type=$Q['type']; $Open=$Q['open']; $Close=$Q['close']; $Lowest=$Q['lowest']; $Highest=$Q['highest']; $Pair=$Q['pair']; }
	
	if( $Name and $UID and $Type and $Open and $Close and $Lowest and $Highest and $Pair){
		
		$SQL="INSERT INTO `".prefix."pods_share_chart`(`id`, `name`, `created`, `modified`, `uid`, `user`, `status`, `pair`, `ttype`, `open`, `close`, `lowest`, `highest`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), '".$UID."', '1', '1', '".$Pair."', '".$Type."', '".$Open."', '".$Close."', '".$Lowest."', '".$Highest."')"; //echo $SQL;
		
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}



function Share_ChartUpdate($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : Only the data that needs to be updated will appear in Coinpods_spot_chart.
// Output : This will update the same data you want to update.
	
	if(is_array($Q)){ $ID=$Q['id']; $Name=$Q['name']; $UID=$Q['uid']; $Status=$Q['status']; $Pair=$Q['pair']; $Type=$Q['ttype']; $Open=$Q['open']; $Close=$Q['close']; $Lowest=$Q['lowest']; $Highest=$Q['highest']; }
	
	$WHERE = " WHERE `".prefix."pods_share_chart`.`id` = '".$ID."'";
	$SET = "UPDATE `".prefix."pods_share_chart` SET `modified`= current_timestamp()";
	
	
	if($Name){$Name = ", `name`='".$Name."'";}
	if($Pair){$Pair = ", `pair`='".$Pair."'";}
	if($Type){$Type = ", `ttype`='".$Type."'";}
	if($Open){$Open = ", `open`='".$Open."'";}
	if($Close){$Close = ", `close`='".$Close."'";}
	if($Lowest){$Lowest = ", `lowest`='".$Lowest."'";}
	if($Highest){$Highest = ", `highest`='".$Highest."'";}
	if($Status=='enable'){$StatusValue = ", `status`='1'";}
	elseif($Status=='disable'){$StatusValue = ", `status`='0'";}
	
	$SQL=$SET.$Name.$Pair.$Type.$Open.$Close.$Lowest.$Highest.$StatusValue.$WHERE;
	if($SQL){ //echo $SQL;
		
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if($results){ return true; }else{ return false; }
	
	}
	else{ $echo = 'SQL Not Found.'; }
}




function Share_ChartStatus($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : Status = 0,1 AND UID
// Output : This function enables and disables the status of the price.
	
	if(is_array($Q)){ $Status=$Q['status']; $UID=$Q['uid']; }
	if($Status and $UID){
		
		if($Status == 'enable'){ $Statuss = 1; } 
		elseif($Status == 'disable'){ $Statuss = 0; }
		
		$SQL="UPDATE `".prefix."pods_share_chart` SET `status` = '".$Statuss."', `modified` = current_timestamp() WHERE `uid` = '".$UID."'"; //echo $SQL;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
	
}




function Share_Charts($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : Chart All Data
// Output : The information about the data that comes from the input is visible.
	
	if(is_array($Q)){
		
		$ID=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Name=isset($Q['name'])?" AND `name` LIKE '%".strtolower($Q['name'])."%'" : '';
		$Created=isset($Q['created'])?" AND `created` >= '".$Q['created']."'" : '';
		$Modified=isset($Q['modified'])?" AND `modified` >= '".$Q['modified']."'" : '';
		$Uid=isset($Q['uid'])?" AND `uid` LIKE '%".strtoupper($Q['uid'])."%'" : '';
		$User=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$Pair=isset($Q['pair'])?" AND `pair` = '".$Q['pair']."'" : '';
		$Type=isset($Q['ttype'])?" AND `ttype` LIKE '%".strtolower($Q['ttype'])."%'" : '';
		$Open=isset($Q['open'])?" AND `open` = '".$Q['open']."'" : '';
		$Close=isset($Q['close'])?" AND `close` = '".$Q['close']."'" : '';
		$Lowest=isset($Q['lowest'])?" AND `lowest` = '".$Q['lowest']."'" : '';
		$Highest=isset($Q['highest'])?" AND `highest` = '".$Q['highest']."'" : '';
		if($Q['status']=='enable'){ $Status = " AND `status` = '1'"; }
		elseif($Q['status']=='disable'){ $Status = " AND `status` = '0'"; }
		
		$Sort = $Q['sort'];
		$SortBy = strtoupper($Q['sortby']);
	
	}
	else{ $User = $Q; }
	
	$WhereClause=$ID.$Name.$Created.$Modified.$Uid.$User.$Pair.$Type.$Open.$Close.$Lowest.$Highest.$Status;
	
	$Limit=isset($Q['limit'])? $Q['limit'] : '';
	if(!$Limit){ $Limit = 111; }
	$Offset=isset($Q['offset'])? $Q['offset'] : 0;
	
	if($Sort){ $SQL = "SELECT * FROM `".prefix."pods_share_chart` WHERE 1 ".$WhereClause." ORDER BY `$Sort` $SortBy LIMIT ".$Limit." OFFSET ".$Offset; }
	else{ $SQL = "SELECT * FROM `".prefix."pods_share_chart` WHERE 1 ".$WhereClause." ORDER BY `id` ASC LIMIT ".$Limit." OFFSET ".$Offset; } //echo $SQL;
	
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); 
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	
	if($ts){ return $ts; }
	else{
		
	$SQL1="SELECT * FROM `".prefix."pods_share_chart` WHERE `status` = '1' ORDER BY `".prefix."pods_share_chart.`id` ASC LIMIT 111";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL1); //echo $SQL1;
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;
		
	}
}




function Share_Chart($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : ChartID
// OUTPUT : Single transaction data from DB by ID($Q)
	
	if($Q){
		
		$SQL = "SELECT * FROM `".prefix."pods_share_chart` WHERE `uid` = '".$Q."'"; //echo $SQL;
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0];
	
	}
	else{ $echo = 'Data Not Found.'; }
}











function Share_OrderMatch($Q=null){
//Where enable and disable are there it means [Enable == 1, Disable == 0]	
	
$Output=0;
$TID=$Q;
if($Q){
	
	$Q=Share_Order($Q);
	if($Q){
	if(is_array($Q)){ $Type=$Q['ttype']; $Amount=$Q['amount']; $Price=$Q['price']; $CCC=$Q['ccc']; $OCC=$Q['occ']; }
		
		
if($Type=='Sell'){
	
	$SQL="SELECT * FROM `".prefix."pods_share_orderbuy` WHERE `occ` = '".$OCC."' AND `balance` = '1' AND `ccc` = '".$CCC."' AND `status` = '0' AND `price` >= ".$Price." AND `amount` != `filled` AND `processing` != '1' ORDER BY `".prefix."pods_share_orderbuy`.`price` DESC , `".prefix."pods_share_orderbuy`.`id` ASC";
	
}
elseif($Type=='Buy'){
	
	$SQL="SELECT * FROM `".prefix."pods_share_ordersell` WHERE `occ` = '".$OCC."' AND `balance` = '1' AND `ccc` = '".$CCC."' AND `status` = '0' AND `price` <= ".$Price." AND `amount` != `filled` AND `processing` != '1' ORDER BY `".prefix."pods_share_ordersell`.`price` ASC , `".prefix."pods_share_ordersell`.`id` ASC";

}
		
		if($Type and $Price and $SQL){
			
			$ts=[]; $t=[];
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
			if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
			else{$ts = null;}
			$Output=1;
			
			if($ts){
				
				if($Type=='Sell'){ Share_OrderSellUpdate(array('id'=>$TID, 'processing'=>'enable')); }
				elseif($Type=='Buy'){ Share_OrderBuyUpdate(array('id'=>$TID, 'processing'=>'enable')); }
				
				$echo='Match orders found : '.count($ts);
				
				foreach($ts as $tt){
					
					if($tt['ttype']=='Sell'){ Share_OrderSellUpdate(array('id'=>$tt['id'], 'processing'=>'enable')); }
					elseif($tt['ttype']=='Buy'){ Share_OrderBuyUpdate(array('id'=>$tt['id'], 'processing'=>'enable')); }
					
					unset($Q);
					
					if($Type=='Sell'){ $Q=Share_OrderSell($TID); }
					elseif($Type=='Buy'){ $Q=Share_OrderBuy($TID); }
					
					if($Q['amount']>$Q['filled']){
						
						$echo='Need to create Trade transaction.';
						$This=0;$That=0;
						
						if($Type=='Sell'){ $t=Share_OrderSell($tt['id']); }
						elseif($Type=='Buy'){ $t=Share_OrderBuy($tt['id']); }
						
						if($t['amount']>$t['filled']){
							
							$This=$Q['amount']-$Q['filled'];
							$That=$t['amount']-$t['filled'];
							
							if($This>$That){ $TradeAmount=$That; $ThisEnd=0; $ThatEnd=1; }
							else{ $TradeAmount=$This; $ThisEnd=1; $ThatEnd=0; }
							
							
							if($Q['ttype']=='Buy' and $t['ttype']=='Sell'){
								
								$Array=array(
									'amount'=>$TradeAmount,
									'price'=>$t['price'],
									'occ'=>$OCC,
									'ccc'=>$CCC,
									'user'=>$Q['user'],
									'buyuser'=>$Q['user'],
									'selluser'=>$t['user'],
									'order'=>$Q['id'],
									'order2'=>$t['id']
								);
							
							}
							elseif($Q['ttype']=='Sell' and $t['ttype']=='Buy'){
								
								$Array=array(
									'amount'=>$TradeAmount,
									'price'=>$t['price'],
									'occ'=>$OCC,
									'ccc'=>$CCC,
									'user'=>$Q['user'],
									'buyuser'=>$t['user'],
									'selluser'=>$Q['user'],
									'order'=>$Q['id'],
									'order2'=>$t['id']
								);
							
							}
							else{$Array=0;}
							
							if($Array){ $echo='Array Okay'; $Spot_TradeNew = Share_TradeNew($Array); }
							if($Spot_TradeNew){
								
    if($Q['ttype']=='Sell'){
		
		$SQL1="UPDATE `".prefix."pods_share_ordersell` SET `filled` = `filled` + '".$TradeAmount."' WHERE `".prefix."pods_share_ordersell`.`id` = '".$Q['id']."';";
		global $DB; $Results = mysqli_query($DB, $SQL1);
	
	}
   elseif($Q['ttype']=='Buy'){
		
		$SQL1="UPDATE `".prefix."pods_share_orderbuy` SET `filled` = `filled` + '".$TradeAmount."' WHERE `".prefix."pods_share_orderbuy`.`id` = '".$Q['id']."';";
		global $DB; $Results = mysqli_query($DB, $SQL1);
	
	}
  if($t['ttype']=='Sell'){
	  
	  $SQL2="UPDATE `".prefix."pods_share_ordersell` SET `filled` = `filled` + '".$TradeAmount."' WHERE `".prefix."pods_share_ordersell`.`id` = '".$t['id']."';";
	  global $DB; $Results = mysqli_query($DB, $SQL2);
	  
  }
 elseif($t['ttype']=='Buy'){
	 
	 $SQL2="UPDATE `".prefix."pods_share_orderbuy` SET `filled` = `filled` + '".$TradeAmount."' WHERE `".prefix."pods_share_orderbuy`.`id` = '".$t['id']."';";
	 global $DB; $Results = mysqli_query($DB, $SQL2);
 
 }
								
     if($ThisEnd){ if($Q['ttype']=='Sell'){ Share_OrderSellUpdate(array('id'=>$Q['id'], 'status'=>'enable')); }                                    elseif($Q['ttype']=='Buy'){ Share_OrderBuyUpdate(array('id'=>$Q['id'], 'status'=>'enable')); }}
			
	 if($ThatEnd){ if($t['ttype']=='Sell'){ Share_OrderSellUpdate(array('id'=>$t['id'], 'status'=>'enable')); }
				   elseif($t['ttype']=='Buy'){ Share_OrderBuyUpdate(array('id'=>$t['id'], 'status'=>'enable')); }}
							
            }
            else{ $echo = $Spot_TradeNew; }
            }
            else{ $echo = 'Order Fucking with another order.'; }
            }
            else{
			   
            if($Q['ttype']=='Sell'){ Share_OrderSellUpdate(array('id'=>$Q['id'], 'status'=>'enable')); $echo = 'Do Nothing.'; }
			elseif($Q['ttype']=='Buy'){ Share_OrderBuyUpdate(array('id'=>$Q['id'], 'status'=>'enable')); $echo = 'Do Nothing.'; }
			   
		    }
		    if($tt['ttype']=='Sell'){ Share_OrderSellUpdate(array('id'=>$tt['id'], 'processing'=>'disable')); }
			elseif($tt['ttype']=='Buy'){ Share_OrderBuyUpdate(array('id'=>$tt['id'], 'processing'=>'disable')); }
					
			}
			if($Type=='Sell'){ Share_OrderSellUpdate(array('id'=>$TID, 'processing'=>'disable')); }
			elseif($Type=='Buy'){ Share_OrderBuyUpdate(array('id'=>$TID, 'processing'=>'disable')); }
				
			}
			else{ $echo = 'No order matched.'; 
			      if($Type=='Sell'){ Share_OrderSellUpdate(array('id'=>$TID, 'processing'=>'disable')); }
			      elseif($Type=='Buy'){ Share_OrderBuyUpdate(array('id'=>$TID, 'processing'=>'disable')); }
				}
		}
		else{ $echo='Not enough resources.'; }
	}
	else{ $echo = 'Order not found.';}
}
else{ $echo = 'Q is empty.';}
return $Output;
}






//* Share Wallet Started

function Share_WalletBalances($Q=null){
if($Q){$SQL="SELECT * FROM `".prefix."pods_share_wallet` WHERE `user` = '".$Q."'"; }
else{ $SQL="SELECT * FROM `".prefix."pods_share_wallet` WHERE `user` = '".i['id']."'"; }

	global $DB;$aa = 0;
	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	

if($ts){
	$Spots=$ts[0];
	
	$aa=0;$Portfolio=0; $Spot=0;
	foreach($Spots as $Spot){
		$aa++; if($aa>4){ 
			$Portfolio=floatval($Portfolio)+floatval($Spot); 
		} 
	}
	$Spots['Total']=$Portfolio;
	$Spots['Portfolio']=$Portfolio;

}	
 return $Spots;

}
$Spots=Share_WalletBalances();
define('Share_WalletBalances',$Spots);










function Share_walletBalance($User=null,$CCC=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : User, CCC
// Output :  Total Amount By Currency And User 
	
	if($User and $CCC){
		$SQL ="SELECT SUM(`amount`)  FROM `".prefix."pods_share_wallet` WHERE `ccc` = '$CCC' AND `user` = '".$User."'";
		
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0]['SUM(`amount`)'];
	
	}
	else{ $echo = 'Data Empty.'; }
	//echo $echo;
}



function AddToShare_Wallet($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : User, CCC, Amount, Network
// Output : Wallet me amount add krta hai.

	if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }
	if($user and $ccc and $amount){
		
		$SQL="UPDATE `".prefix."pods_share_wallet` SET  `amount`= `amount`+ '".$amount."'  WHERE `user` = '".$user."' AND `ccc` = '".$ccc."' "; 
		
		 global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
	
	}
	else{$echo='This currany is not available';}
	return $results;
}


 
function RemoveFromShare_Wallet($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : User, CCC, Amount
// Output : Wallet se jiss user ki amount minus krta hai By CCC.
	
	if(is_array($Q)){ $user=$Q['user']; $ccc=strtolower($Q['ccc']); $network=$Q['network']; $amount=$Q['amount']; }
	
	if($user and $ccc and $amount){
		
		$SQL="UPDATE `".prefix."pods_share_wallet` SET `amount`=`amount`-'".$amount."', `ccc`= '".$ccc."' WHERE `user`='".$user."'";
		
		global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);
		return true;
	}
	else{ $echo = 'Data Empty.'; }
}



function Share_WalletStatus($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : UID, Status = enable, disable
// Output : Wallet ke status column enable and disable krta hai.
	
	if(is_array($Q)){ $UID=$Q['uid']; $Status=$Q['status']; }
	if($UID and $Status){
		
		if($Status == 'enable'){ $StatusValue = 1; }
		elseif($Status == 'disable'){ $StatusValue = 0; }
		
		$SQL="UPDATE `".prefix."pods_share_wallet` SET `status` = '".$StatusValue."' WHERE `uid` = '".$UID."';"; //echo $SQL;
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}



function Share_WalletEnable($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : UID, Enable = enable, disable
// Output : Wallet ke enable column ko enable and disable krta hai.
	
	if(is_array($Q)){ $UID=$Q['uid']; $Enable=$Q['enable']; }
	if($UID and $Enable){
		
		if($Enable == 'enable'){ $EnableValue = 1; }
		elseif($Enable == 'disable'){ $EnableValue = 0; }
		
		$SQL="UPDATE `".prefix."pods_share_wallet` SET `enable` = '".$EnableValue."' WHERE `uid` = '".$UID."';"; //echo $SQL;
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}



function Share_WalletUpdate($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : ID, Name, Enable, Status, Amount
// Output : Data Update.
	
	if(is_array($Q)){ $ID=$Q['uid']; $CCC=$Q['ccc'];  $Name=$Q['name']; $Status=$Q['status']; $Enable=$Q['enable']; }
	
	if($ID){
		
	$WHERE = " WHERE `uid` = '".$ID."'";
	$SET = "UPDATE `".prefix."pods_share_wallet` SET  `modified`= current_timestamp()";
	if($Name){$Name = ", `name`='".$Name."'";}
	if($CCC){$CCC = ", `ccc`='".$CCC."'";}
	if($Enable=='enable'){$EnableValue = ", `enable`='1'";}
	elseif($Enable=='disable'){$EnableValue = ", `enable`='0'";}
	if($Status=='enable'){$StatusValue = ", `status`='1'";}
	elseif($Status=='disable'){$StatusValue = ", `status`='0'";}
		
	$SQL=$SET.$Name.$CCC.$Amount.$EnableValue.$StatusValue.$WHERE;
		
	if($SQL){  
		
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if($results){ return true; }else{ return false; }
	
	}
	else{ $echo ='SQL not found.'; }
	}
	else{ $echo = 'ID not found.'; }
}



function Share_WalletNew($Q=null){
// Developer : Pawan kumar
// Date : 2024-08-30
// Input : User, Address
// Output : Share wallet me user ka new wallet create krta hai. 
	
	if(is_array($Q)){ $Name=$Q['name']; $CCC=$Q['ccc']; $User=$Q['user'];  $echo='Array is found.';}
	if($CCC and $User ){
		$echo = 'Data Found.';
		
		$UID = $User.':'.strtoupper($CCC);
		$echo = 'UID Found.';
		
		if($UID){
			
			$SQL1="INSERT INTO `Coinpods_share_wallet`(`id`, `name`, `created`, `modified`, `user`, `uid`, `status`, `privacy`, `app`, `enable`, `amount`, `ccc`) VALUES(NULL, '".$Name."', current_timestamp(), current_timestamp(), '".$User."', '".$UID."', '1', 1, '1', '1', '0', '".strtolower($CCC)."')"; 
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL1);
			return $results;
		
		}
		else{ $echo='UID Not Found.'; }
	}
	else{ $echo='Data empty.'; }
	//echo $echo;
}



function Share_Wallets($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : Wallett All Data
// Output : The information about the data that comes from the input is visible.
	
	
	if(is_array($Q)){

		$ID=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Name=isset($Q['name'])?" AND `name` = '".$Q['name']."'" : '';
		$Created=isset($Q['created'])?" AND `created` >= '".$Q['created']."'" : '';
		$Modified=isset($Q['modified'])?" AND `modified` >= '".$Q['modified']."'" : '';
		$User=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$UID=isset($Q['uid'])?" AND `uid` = '".$Q['uid']."'" : '';
		$CCC=isset($Q['ccc'])?" AND `ccc` = '".strtoupper($Q['ccc'])."'" : '';
		$Status=isset($Q['status'])?" AND `status` >= '".$Q['status']."'" : '';
		$Amount=isset($Q['amount'])?" AND `amount` >= '".$Q['amount']."'" : '';
		$Enable=isset($Q['enable'])?" AND `enable` >= '".$Q['enable']."'" : '';
		
	}
	else{ $User = $Q; }
	
	$WhereClause="1".$ID.$Name.$Created.$Modified.$User.$CCC.$UID.$Amount.$Status.$Enable;
	
	       if(isset($Q['sort'])){ $Sort = $Q['sort'];}
            if($Sort == 'id'){ $Sortt = 'id'; }
	        elseif($Sort == 'name'){ $Sortt = 'name'; }
            elseif($Sort == 'created'){ $Sortt = 'created'; }
            elseif($Sort == 'modified'){ $Sortt = 'modified'; }
            elseif($Sort == 'user'){ $Sortt = 'user'; }
            elseif($Sort == 'uid'){ $Sortt = 'uid'; }
            elseif($Sort == 'ccc'){ $Sortt = 'ccc'; }
            elseif($Sort == 'status'){ $Sortt = 'status'; }
            elseif($Sort == 'amount'){ $Sortt = 'amount'; }
            elseif($Sort == 'enable'){ $Sortt = 'enable'; }
	        else{$Sortt = 'id';}		
		 
 if(strtoupper($Q['sortby']) == 'ASC'){ $SortBy='ASC'; }else{$SortBy='DESC';}
            
	$Limit=isset($Q['LIMIT'])? $Q['LIMIT'] : '';
	if(!$Limit){ $Limit = 11; }
	$Offset=isset($Q['OFFSET'])? $Q['OFFSET'] : 0;
	
	
		$SQL = "SELECT * FROM `".prefix."pods_share_wallet` WHERE  ".$WhereClause." ORDER BY `".$Sortt."` $SortBy  LIMIT ".$Limit." OFFSET ".$Offset; 

	    global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts;
	
	}



function Share_Wallet($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : UID
// Output : UID aa rhi uss ka data.
	
	if($Q){
		
		$SQL="SELECT * FROM `".prefix."pods_share_wallet` WHERE `uid` = '".$Q."'"; //echo $SQL;
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0];
	
	}
	else{ $echo = 'Data Empty.'; }
}






//* Share Order Start.

function Share_OrderNew($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : Type, Amount, Price, OCC, CCC
// OUTPUT : INSERT

	
$Output=0;
if(is_array($Q)){ $Type=$Q['type']; $Amount=$Q['amount']; $Price=$Q['price']; $OCC=strtolower($Q['occ']); $CCC=strtolower($Q['ccc']); }
	
	$Pair = $CCC.'_'.$OCC;
	
	
$Spot_Wallets=Share_Wallets(array('user'=>i['id'], 'ccc'=>$OCC));
$Wallets = 	$Spot_Wallets[0];
$Total = $Amount*$Price; 
	
	
	
if($Type=='buy'){
	
	
if($Wallets['amount']>=p2d($Total)){ 
	
$Fees=$Amount*0/100; $Amountt=$Amount-$Fees;

$SQL1="INSERT INTO `".prefix."pods_share_order`(`id`, `name`, `created`, `modified`, `uid`, `user`, `status`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `beforebalance`, `afterbalance`, `price`, `filled`, `buyuser`, `selluser`, `processing`, `level`, `fee`, `pair`) VALUES (NULL, 'Buy:".i['id'].Clean(GMT())."', current_timestamp(), current_timestamp(), 'Buy:".i['id'].Clean(GMT())."', '".i['id']."', '0', '".p2d($Total)."', '".$OCC."', '1', 'Buy', '".p2d($Amountt)."', '".$CCC."', '".$Wallets['amount']."', '', '".$Price."', '', '".i['id']."', '', '1', '', '".$Fees."', '".strtoupper($Pair)."')";
	
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL1);
	$Output=mysqli_insert_id($DB);
	
	if($results){
		
		$Spot_Wallets=Share_Wallets(array('user'=>i['id'], 'ccc'=>$OCC));
		$Wallets = 	$Spot_Wallets[0];
		$DDD=$Wallets['amount']; $DDD=$DDD-p2d($Total);
		
		$SQL2="UPDATE `".prefix."pods_share_wallet` SET `amount` = ".$DDD."  WHERE `".prefix."pods_share_wallet`.`user` = '".i['id']."' AND `ccc` = '".$OCC."';";
		global $DB;$aa = 0; $Outputt = mysqli_query($DB, $SQL2);
		
		if($Outputt){
			
			$SQL3="INSERT INTO `".prefix."pods_share_orderbuy`(`id`, `name`, `created`, `modified`, `uid`, `user`, `status`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `beforebalance`, `afterbalance`, `price`, `filled`, `buyuser`, `selluser`, `processing`, `level`, `fee`, `pair`) VALUES ('".$Output."', 'Buy:".i['id'].Clean(GMT())."', current_timestamp(), current_timestamp(), 'Buy:".i['id'].Clean(GMT())."', '".i['id']."', '0', '".p2d($Total)."', '".$OCC."', '1', 'Buy', '".p2d($Amountt)."', '".$CCC."', '".$Wallets['amount']."', '', '".$Price."', '', '".i['id']."', '', '1', '', '".$Fees."', '".strtoupper($Pair)."')";
			
			global $DB;$aa = 0; $results = mysqli_query($DB, $SQL3);
			
		}
	}
}
}
	
elseif($Type=='sell'){
	
	$Spot_Wallets=Share_Wallets(array('user'=>i['id'], 'ccc'=>$CCC));
	$Wallets = 	$Spot_Wallets[0];
	if($Wallets['amount']>=p2d($Amount)){
		
		$Fees=$Total*0/100;
		$Totall=$Total-$Fees;
		
		$SQL1="INSERT INTO `".prefix."pods_share_order`(`id`, `name`, `created`, `modified`, `uid`, `user`, `status`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `beforebalance`, `afterbalance`, `price`, `filled`, `buyuser`, `selluser`, `processing`, `level`, `fee`, `pair`) VALUES (NULL, 'Sell:".i['id'].Clean(GMT())."', current_timestamp(), current_timestamp(), 'Sell:".i['id'].Clean(GMT())."', '".i['id']."', '0', '".p2d($Total)."', '".$OCC."', '1', 'Sell', '".p2d($Amount)."', '".$CCC."', '".$Wallets['amount']."', '', '".$Price."', '', '', '".i['id']."', '1', '', '".$Fees."', '".strtoupper($Pair)."')";
		
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL1);
		$Output=mysqli_insert_id($DB);
		
		if($results){
			
$SQL2="UPDATE `Coinpods_share_wallet` SET `amount` = `amount` - '".p2d($Amount)."'  WHERE `Coinpods_share_wallet`.`user` = '".i['id']."' AND `ccc` = '".$CCC."';";
global $DB;$aa = 0; $Outputt = mysqli_query($DB, $SQL2);
			
			if($Outputt){
				
				$SQL3="INSERT INTO `".prefix."pods_share_ordersell`(`id`, `name`, `created`, `modified`, `uid`, `user`, `status`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `beforebalance`, `afterbalance`, `price`, `filled`, `buyuser`, `selluser`, `processing`, `level`, `fee`, `pair`) VALUES ('".$Output."', 'Sell:".i['id'].Clean(GMT())."', current_timestamp(), current_timestamp(), 'Sell:".i['id'].Clean(GMT())."', '".i['id']."', '0', '".p2d($Total)."', '".$OCC."', '1', 'Sell', '".p2d($Amount)."', '".$CCC."', '".$Wallets['amount']."', '', '".$Price."', '', '', '".i['id']."', '1', '', '".$Fees."', '".strtoupper($Pair)."')";
				
				global $DB;$aa = 0; $results = mysqli_query($DB, $SQL3);
				
			}
		}
	}
}
else{ $Output='Internal Error.'; }
return $Output;
}








function Share_Order($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : TransactionID
// OUTPUT : Single transaction data from DB by ID($Q)
	
	if($Q){
		
		$SQL = "SELECT * FROM `".prefix."pods_share_order` WHERE `id` = ".$Q; //echo $SQL;
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0];
	
	}
	else{ $echo = 'Data Not Found.'; }
}






function Share_Orders($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : Type, CCC, OCC
	
	if(is_array($Q)){ $Type=$Q['type']; $CCC=$Q['ccc']; $OCC=$Q['occ']; }
	
	if($Type and $CCC and $OCC ){
		
		$SQL="SELECT * FROM `".prefix."pods_transaction` WHERE `user` != '' AND `ccc` = '".$CCC."' AND `occ` = '".$OCC."' AND `status` = '0' AND `balance` = '1' AND `amount` != `filled`  AND `ttype` = '".$Type."' ORDER BY `".prefix."pods_transaction`.`price` ASC , `".prefix."pods_transaction`.`id` ASC LIMIT 11 OFFSET 0;"; //echo $SQL;
		
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
	
	}
	else{ $echo = 'Data Empty.'; }
	return $ts;
}







function Share_OrderUpdate($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : Only the data that needs to be updated will appear in Coinpods_share_order.
// Output : This will update the same data you want to update.
	
	
	if(is_array($Q)){ $ID=$Q['id']; $Name=$Q['name']; $Uid=$Q['uid']; $User=$Q['user']; $Status=$Q['status']; $OCA=$Q['oca']; $OCC=$Q['occ']; $Balance=$Q['balance']; $Type=$Q['type']; $Amount=$Q['amount']; $CCC=$Q['ccc']; $BeforeBalance=$Q['beforebalance']; $AfterBalance=$Q['afterbalance']; $Price=$Q['price']; $Filled=$Q['filled'];  $Buyuser=$Q['buyuser']; $Selluser=$Q['selluser']; $Processing=$Q['processing']; $Level=$Q['level']; $Fee=$Q['fee']; $Pair=$Q['pair']; }
			
		$WHERE = " WHERE `".prefix."pods_share_order`.`id` = '".$ID."'";
		$SET = "UPDATE `".prefix."pods_share_order` SET  `modified`= current_timestamp()";
		
		if($Name){$Name = ", `name`='".$Name."'";}
		if($OCA){$OCA = ", `oca`='".$OCA."'";}
		if($OCC){$OCC = ", `occ`='".$OCC."'";}
		if($Type){$Type = ", `ttype`='".$Type."'";}
		//if($Amount){$Amount = ", `amount`='".$Amount."'";}
		if($CCC){$CCC = ", `ccc`='".$CCC."'";}
		if($BeforeBalance){$BeforeBalance = ", `beforebalance`='".$BeforeBalance."'";}
		if($AfterBalance){$AfterBalance = ", `afterbalance`='".$AfterBalance."'";}
		if($Price){$Price = ", `price`='".$Price."'";}
		if($Filled){$Filled = ", `filled`='".$Filled."'";}
		if($Buyuser){$Buyuser = ", `buyuser`='".$Buyuser."'";}
		if($Selluser){$Selluser = ", `selluser`='".$Selluser."'";}
		if($Fee){$Fee = ", `fee`='".$Fee."'";}
		if($Pair){$Pair = ", `pair`='".$Pair."'";}
		if($Level=='enable'){$LevelValue = ", `level`='1'";}
		elseif($Level=='disable'){$LevelValue = ", `level`='0'";}
		if($Status=='enable'){$StatusValue = ", `status`='1'";}
		elseif($Status=='disable'){$StatusValue = ", `status`='0'";}
		if($Balance=='enable'){$BalanceValue = ", `balance`='1'";}
		elseif($Balance=='disable'){$BalanceValue = ", `balance`='0'";}
		if($Processing=='enable'){$ProcessingValue = ", `processing`='1'";}
		elseif($Processing=='disable'){$ProcessingValue = ", `processing`='0'";}
		
		$SQL=$SET.$Name.$OCA.$OCC.$BalanceValue.$Type.$CCC.$BeforeBalance.$AfterBalance.$Price.$Filled.$Buyuser.$Selluser.$Fee.$StatusValue.$ProcessingValue.$WHERE;
		
		if($SQL){ //echo $SQL;
			
			global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
			if($results){ return true; }else{ return false; }
		
		}
	else{ $echo = 'SQL Not Found.'; }
}





function Share_OrderStatus($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-30
// Input : UID, Status = enable, disable
// Output : Order ke status column enable and disable krta hai.
	
	if(is_array($Q)){ $ID=$Q['id']; $Status=$Q['status']; }
	if($ID and $Status){
		
		if($Status == 'enable'){ $StatusValue = 1; }
		elseif($Status == 'disable'){ $StatusValue = 0; }
		
		$SQL="UPDATE `".prefix."pods_share_order` SET `status` = '".$StatusValue."' WHERE `id` = '".$ID."';"; //echo $SQL;
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}








//* Spot Order Buy Start

function Share_OrderBuyStatus($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-07
// Input : Status = 0,1 AND UID
// Output : This function enables and disables the status of the spot_orderbuy.
	
	if(is_array($Q)){ $Status=$Q['status']; $UID=$Q['uid']; }
	if($Status and $UID){
		
		if($Status=='enable'){ $StatusValue = '1';}
		elseif($Status=='disable'){ $StatusValue = '0';}

		$SQL="UPDATE `".prefix."pods_share_orderbuy` SET `status` = '".$StatusValue."', `modified` = current_timestamp() WHERE `uid` = '".$UID."'"; echo $SQL;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Emapty.'; }
	return $results;
}








function Share_OrderBuy($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-07
// Input : TransactionID
// OUTPUT : Single transaction data from DB by ID($Q)
	
	if($Q){
		
		$SQL = "SELECT * FROM ".prefix."pods_share_orderbuy` WHERE `id` = ".$Q;
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0];
	
	}
	else{ $echo = 'Data Not Found.'; }
}





function Share_OrderBuyUpdate($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-07
// Input : Only the data that needs to be updated will appear in Coinpods_spot_orderbuy.
// Output : This will update the same data you want to update.
	
	if(is_array($Q)){ $ID=$Q['id']; $Name=$Q['name']; $Uid=$Q['uid']; $User=$Q['user']; $Status=$Q['status']; $OCA=$Q['oca']; $OCC=$Q['occ']; $Balance=$Q['balance']; $Type=$Q['ttype']; $Amount=$Q['amount']; $CCC=$Q['ccc']; $BeforeBalance=$Q['beforebalance']; $AfterBalance=$Q['afterbalance']; $Price=$Q['price']; $Filled=$Q['filled'];  $Buyuser=$Q['buyuser']; $Selluser=$Q['selluser']; $Processing=$Q['processing']; $Level=$Q['level']; $Fee=$Q['fee']; }
	
	
		$WHERE = " WHERE `".prefix."pods_share_orderbuy`.`id` = '".$ID."'";
		$SET = "UPDATE `".prefix."pods_share_orderbuy` SET  `modified`= current_timestamp()";
		
		if($Name){$Name = ", `name`='".$Name."'";}
		if($OCA){$OCA = ", `oca`='".$OCA."'";}
		if($OCC){$OCC = ", `occ`='".$OCC."'";}
		if($Type){$Type = ", `ttype`='".$Type."'";}
		//if($Amount){$Amount = ", `amount`='".$Amount."'";}
		if($CCC){$CCC = ", `ccc`='".$CCC."'";}
		if($BeforeBalance){$BeforeBalance = ", `beforebalance`='".$BeforeBalance."'";}
		if($AfterBalance){$AfterBalance = ", `afterbalance`='".$AfterBalance."'";}
		if($Price){$Price = ", `price`='".$Price."'";}
		if($Filled){$Filled = ", `filled`='".$Filled."'";}
		if($Buyuser){$Buyuser = ", `buyuser`='".$Buyuser."'";}
		if($Selluser){$Selluser = ", `selluser`='".$Selluser."'";}
		if($Fee){$Fee = ", `fee`='".$Fee."'";}
		if($Level=='enable'){$LevelValue = ", `level`='1'";}
		elseif($Level=='disable'){$LevelValue = ", `level`='0'";}
		if($Status=='enable'){$StatusValue = ", `status`='1'";}
		elseif($Status=='disable'){$StatusValue = ", `status`='0'";}
		if($Balance=='enable'){$BalanceValue = ", `balance`='1'";}
		elseif($Balance=='disable'){$BalanceValue = ", `balance`='0'";}
		if($Processing=='enable'){$ProcessingValue = ", `processing`='1'";}
		elseif($Processing=='disable'){$ProcessingValue = ", `processing`='0'";}
		
		$SQL=$SET.$Name.$OCA.$OCC.$BalanceValue.$Type.$CCC.$BeforeBalance.$AfterBalance.$Price.$Filled.$Buyuser.$Selluser.$Fee.$StatusValue.$ProcessingValue.$WHERE;
	
	if($SQL){ //echo $SQL;
		
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if($results){ return true; }else{ return false; }
	
	}
}







//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//* Share Order Sell Start

function Share_OrderSell($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-07
// Input : TransactionID
// OUTPUT : Single transaction data from DB by ID($Q)
	
	if($Q){
		
		$SQL = "SELECT * FROM ".prefix."pods_share_ordersell` WHERE `id` = ".$Q;
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0];
	
	}
	else{ $echo = 'Data Not Found.'; }
}





function Share_OrderSellUpdate($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-07
// Input : Only the data that needs to be updated will appear in Coinpods_spot_ordersell.
// Output : This will update the same data you want to update.
	
	
	if(is_array($Q)){ $ID=$Q['id']; $Name=$Q['name']; $Uid=$Q['uid']; $User=$Q['user']; $Status=$Q['status']; $OCA=$Q['oca']; $OCC=$Q['occ']; $Balance=$Q['balance']; $Type=$Q['ttype']; $Amount=$Q['amount']; $CCC=$Q['ccc']; $BeforeBalance=$Q['beforebalance']; $AfterBalance=$Q['afterbalance']; $Price=$Q['price']; $Filled=$Q['filled'];  $Buyuser=$Q['buyuser']; $Selluser=$Q['selluser']; $Processing=$Q['processing']; $Level=$Q['level']; $Fee=$Q['fee']; }
	
		$WHERE = " WHERE `".prefix."pods_share_ordersell`.`id` = '".$ID."'";
		$SET = "UPDATE `".prefix."pods_share_ordersell` SET  `modified`= current_timestamp()";
		
		if($Name){$Name = ", `name`='".$Name."'";}
		if($OCA){$OCA = ", `oca`='".$OCA."'";}
		if($OCC){$OCC = ", `occ`='".$OCC."'";}
		if($Type){$Type = ", `ttype`='".$Type."'";}
		//if($Amount){$Amount = ", `amount`='".$Amount."'";}
		if($CCC){$CCC = ", `ccc`='".$CCC."'";}
		if($BeforeBalance){$BeforeBalance = ", `beforebalance`='".$BeforeBalance."'";}
		if($AfterBalance){$AfterBalance = ", `afterbalance`='".$AfterBalance."'";}
		if($Price){$Price = ", `price`='".$Price."'";}
		if($Filled){$Filled = ", `filled`='".$Filled."'";}
		if($Buyuser){$Buyuser = ", `buyuser`='".$Buyuser."'";}
		if($Selluser){$Selluser = ", `selluser`='".$Selluser."'";}
		if($Fee){$Fee = ", `fee`='".$Fee."'";}
		if($Level=='enable'){$LevelValue = ", `level`='1'";}
		elseif($Level=='disable'){$LevelValue = ", `level`='0'";}
		if($Status=='enable'){$StatusValue = ", `status`='1'";}
		elseif($Status=='disable'){$StatusValue = ", `status`='0'";}
		if($Balance=='enable'){$BalanceValue = ", `balance`='1'";}
		elseif($Balance=='disable'){$BalanceValue = ", `balance`='0'";}
		if($Processing=='enable'){$ProcessingValue = ", `processing`='1'";}
		elseif($Processing=='disable'){$ProcessingValue = ", `processing`='0'";}
		
		$SQL=$SET.$Name.$OCA.$OCC.$BalanceValue.$Type.$CCC.$BeforeBalance.$AfterBalance.$Price.$Filled.$Buyuser.$Selluser.$Fee.$StatusValue.$ProcessingValue.$WHERE;
	
	if($SQL){ //echo $SQL;
		
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if($results){ return true; }else{ return false; }
	
	}
	else{ $echo = 'SQL Not Found.'; }
}




//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function Share_TradeNew($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-06
// Input : Amount, Price, CCC, OCC, User, Buyuser, Selluser, Order, Order2 
// Output : Creates a new trade transaction in Coinpod_spot_trade.
	
$Output=0;
if(is_array($Q)){ $Amount=$Q['amount']; $Price=$Q['price']; $CCC=$Q['ccc']; $OCC=$Q['occ']; $User=$Q['user']; $BuyUser=$Q['buyuser']; $SellUser=$Q['selluser'];  $Order1=$Q['order']; $Order2=$Q['order2']; }	
	 
 
if($Amount and $Price and $CCC and $OCC and $User and $BuyUser and $SellUser and $Order1 and $Order2){
	
$Total=$Amount*$Price;
	
	
$Fees=$Total*0.4/100;
$Totall=$Total-$Fees;
	
	
$Fees=$Amount*0.4/100;
$Amountt=$Amount-$Fees;
	
$T1=Transaction($Order1);
$T2=Transaction($Order2);	
	

	$This=$T1['amount']-$T1['filled'];		
	$That=$T2['amount']-$T2['filled'];
					

	if($This>$That){ $TradeAmount=$That;   }
	else{ $TradeAmount=$This;  }	
	
	
	
if($T1['amount']>$T1['filled'] and $T2['amount']>$T2['filled'] and $TradeAmount==$Amount){	
$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `price`, `buyuser`, `selluser`) VALUES (NULL, 'Trade:This=".$Order1.'-That'.$Order2.' '.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Trade:This=".$Order1.'-That='.$Order2.' '.Clean(GMT())."', '".$User."', '".$Totall."', '".$OCC."', '0', 'Trade', '".$Amountt."', '".$CCC."', '1', '', '".$Price."', '".$BuyUser."', '".$SellUser."');";
	
	global $DB; $Results = mysqli_query($DB, $SQL1); $Output=mysqli_insert_id($DB);
}
else{$Output=0;}
	
	$PID=$CCC.'_'.$OCC;
	
	if($Output){
		
		$UpdatePrice=UpdatePairPrice( array( 'Name'=>'Trade', 'Price'=>$T2['price'], 'CCC'=>$CCC, 'DDD'=>$OCC, 'PID'=>$PID ) );
		if($UpdatePrice){
			
			$SQL2="INSERT INTO `Coinpods_share_trade`(`id`, `name`, `created`, `modified`, `user`, `uid`, `status`, `balance`, `amount`, `ccc`, `beforebalance`, `afterbalance`, `price`, `filled`, `buyuser`, `selluser`, `processing`, `fee`, `pair`) VALUES ('".$Output."', 'Trade:This=".$Order1.'-That'.$Order2.' '.Clean(GMT())."', current_timestamp(), current_timestamp(), '".$User."', '".$Output."', '1', '0', '".$Amountt."', '".$CCC."', '', '', '".$Price."', '', '".$BuyUser."', '".$SellUser."', '0', '', '".$PID."')";
			global $DB;$aa = 0; $results = mysqli_query($DB, $SQL2);

		}
	}
}
return $Output;	
}






function Share_TradeUpdate($Q=null){
// Developer : Pawan kumar
// Date : 2024-08-06
// Input : Array
// Output : Updates the data that comes from the array.
	
	if(is_array($Q)){ $ID=$Q['id']; $Name=$Q['name']; $Uid=$Q['uid']; $Status=$Q['status'];  $Balance=$Q['balance']; $CCC=$Q['ccc']; $Processing=$Q['processing'];  $Pair=$Q['pair']; }
	
	$WHERE = " WHERE `".prefix."pods_share_trade`.`uid` = '".$Uid."'";
	$SET = "UPDATE `".prefix."pods_share_trade` SET `modified`= current_timestamp()";
	

	if($CCC){$CCC = ", `ccc`='".$CCC."'";}
	if($Name){$Name = ", `name`='".$Name."'";}
	if($Pair){$Pair = ", `pair`='".$Pair."'";}
	
	if($Status=='enable'){$StatusValue = ", `status`='1'";}
	elseif($Status=='disable'){$StatusValue = ", `status`='0'";}
	
	if($Balance=='enable'){$BalanceValue = ", `balance`='1'";}
	elseif($Balance=='disable'){$BalanceValue = ", `balance`='0'";}
	
	if($Processing=='enable'){$ProcessingValue = ", `processing`='1'";}
	elseif($Processing=='disable'){$ProcessingValue = ", `processing`='0'";}
	
	$SQL=$SET.$CCC.$Name.$Pair.$StatusValue.$BalanceValue.$ProcessingValue.$WHERE;
	
	if($SQL){ //echo $SQL;
		
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if($results){ return true; }else{ return false; }
	
	}
	else{ $echo = 'SQL Not Found.'; }
}





function Share_TradeStatus($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-06
// Input : UID, Status = enable, disable
// Output : Spot_Trade ke status column enable and disable krta hai.
	
	if(is_array($Q)){ $UID=$Q['uid']; $Status=$Q['status']; }
	if($UID and $Status){
		
		if($Status == 'enable'){ $StatusValue = 1; }
		elseif($Status == 'disable'){ $StatusValue = 0; }
		
		$SQL="UPDATE `".prefix."pods_share_trade` SET `modified`= current_timestamp(), `status`='".$StatusValue."' WHERE `uid` = '".$UID."';"; 
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}



function Share_Trades($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-06
// Input : Array
// Output : Shows all the data of the array that is coming.
	
	if(is_array($Q)){
		
		$ID=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Name=isset($Q['name'])?" AND `name` LIKE '%".strtolower($Q['name'])."%'" : '';
		$Created=isset($Q['created'])?" AND `created` >= '".$Q['created']."'" : '';
		$Modified=isset($Q['modified'])?" AND `modified` >= '".$Q['modified']."'" : '';
		$User=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$Uid=isset($Q['uid'])?" AND `uid` LIKE '".strtoupper($Q['uid'])."'" : '';
		$Amount=isset($Q['amount'])?" AND `amount` >= '".$Q['amount']."'" : '';
        $CCC=isset($Q['ccc'])?" AND `ccc` LIKE '".strtoupper($Q['ccc'])."'" : '';
		$Beforebalance=isset($Q['beforebalance'])?" AND `beforebalance` = '".$Q['beforebalance']."'" : '';
		$Afterbalance=isset($Q['afterbalance'])?" AND `afterbalance` = '".$Q['afterbalance']."'" : '';
		$Price=isset($Q['price'])?" AND `price` = '".$Q['price']."'" : '';
		$Filled=isset($Q['filled'])?" AND `filled` = '".$Q['filled']."'" : '';
		$Buyuser=isset($Q['buyuser'])?" AND `buyuser` = '".$Q['buyuser']."'" : '';
		$Selluser=isset($Q['selluser'])?" AND `selluser` = '".$Q['selluser']."'" : '';
		$fee=isset($Q['fee'])?" AND `fee` = '".$Q['fee']."'" : '';
		$Pair=isset($Q['pair'])?" AND `pair` = '".$Q['pair']."'" : '';
		
		if($Q['status']=='enable'){ $Status = " AND `status` = '1'"; }
		elseif($Q['status']=='disable'){ $Status = " AND `status` = '0'"; }
		
		if($Q['balance']=='enable'){ $Balance = " AND `balance` = '1'"; }
		elseif($Q['balance']=='disable'){ $Balance = " AND `balance` = '0'"; }
		
		if($Q['processing']=='enable'){ $Processing = " AND `processing` = '1'"; }
		elseif($Q['processing']=='disable'){ $Processing = " AND `processing` = '0'"; }
		
	
	}
	else{ $User = $Q; }
	
	$WhereClause=$ID.$Name.$Created.$Modified.$User.$Uid.$Amount.$CCC.$Beforebalance.$Afterbalance.$Price.$Filled.$Buyuser.$Selluser.$fee.$Pair.$Status.$Balance.$Processing;
	
	
	$Limit=isset($Q['limit'])? $Q['limit'] : '';
	if(!$Limit){ $Limit = 111; }
	$Offset=isset($Q['offset'])? $Q['offset'] : 0;
	
	$Sort = $Q['sort']; if(!$Sort){ $Sort = 'id'; }
	$SortBy = strtoupper($Q['sortby']); if(!$SortBy){ $SortBy = 'DESC'; }
	
	$SQL = "SELECT * FROM `".prefix."pods_share_trade` WHERE 1 ".$WhereClause." ORDER BY `$Sort` $SortBy LIMIT ".$Limit." OFFSET ".$Offset;
	//echo $SQL;
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); 
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	
	if($ts){ return $ts; }
}




function Share_Trade($Q=NULL){
// Developer : Pawan Kumar
// Date : 2024-08-06
// Input : UID
// Output : Shows all the data of the uid that is coming.
	
	if($Q){
		
		$SQL = "SELECT * FROM `".prefix."pods_share_trade` WHERE `uid` = ".$Q; //echo $SQL;
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0];
	
	}
	else{ $echo = 'Data Not Found.'; }
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function Share_PriceUpdate($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-06
// Input : Only the data that needs to be updated will appear in Coinpods_spot_price.
// Output : This will update the same data you want to update.
	
	if(is_array($Q)){ $ID=$Q['id']; $Name=$Q['name']; $UID=$Q['uid']; $Status=$Q['status']; $Pair=$Q['pair']; $CCC=$Q['ccc']; $OCC=$Q['occ']; $Price=$Q['price']; $Year=$Q['year']; $Month=$Q['month']; $Date=$Q['date']; $Hour=$Q['hour']; $Minute=$Q['minute']; $Second=$Q['second']; $Millisecond=$Q['millisecond']; $Datee=$Q['datee']; $Time=$Q['time']; }
	
	$WHERE = " WHERE `".prefix."pods_share_price`.`id` = '".$ID."'";
	$SET = "UPDATE `".prefix."pods_share_price` SET `modified`= current_timestamp()";
	
	
	if($Name){$Name = ", `name`='".$Name."'";}
	if($Uid){$Uid = ", `uid`='".$Uid."'";}
	if($Pair){$Pair = ", `pair`='".$Pair."'";}
	if($CCC){$CCC = ", `ccc`='".$CCC."'";}
	if($OCC){$OCC = ", `occ`='".$OCC."'";}
	if($Price){$Price = ", `price`='".$Price."'";}
	if($Year){$Year = ", `year`='".$Year."'";}
	if($Month){$Month = ", `month`='".$Month."'";}
	if($Date){$Date = ", `date`='".$Date."'";}
	if($Hour){$Hour = ", `hour`='".$Hour."'";}
	if($Minute){$Minute = ", `minute`='".$Minute."'";}
	if($Second){$Second = ", `second`='".$Second."'";}
	if($Millisecond){$Millisecond = ", `millisecond`='".$Millisecond."'";}
	if($Datee){$Datee = ", `datee`='".$Datee."'";}
	if($Time){$Time = ", `time`='".$Time."'";}
	if($Status=='enable'){$StatusValue = ", `status`='1'";}
	elseif($Status=='disable'){$StatusValue = ", `status`='0'";}
	
	$SQL=$SET.$Name.$Uid.$Pair.$CCC.$OCC.$Price.$Year.$Month.$Date.$Hour.$Minute.$Minbuy.$Second.$Millisecond.$Datee.$Time.$StatusValue.$WHERE;
	
	if($SQL){ //echo $SQL;
		
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if($results){ return true; }else{ return false; }
	
	}
	else{ $echo = 'SQL Not Found.'; }
	
}




function Share_PriceStatus($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-06
// Input : Status = 0,1 AND UID
// Output : This function enables and disables the status of the price.
	
	if(is_array($Q)){ $Status=$Q['status']; $UID=$Q['uid']; }
	if($Status and $UID){
		
		if($Status == 'enable'){ $Statuss = 1; } 
		elseif($Status == 'disable'){ $Statuss = 0; }
		
		$SQL="UPDATE `".prefix."pods_share_price` SET `status` = '".$Statuss."', `modified` = current_timestamp() WHERE `uid` = '".$UID."'"; //echo $SQL;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Empty.'; }
	return $results;
	
}






function Share_Prices($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-06
// Input : Pairs All Data
// Output : The information about the data that comes from the input is visible.
	
	if(is_array($Q)){
		
		$ID=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Name=isset($Q['name'])?" AND `name` LIKE '%".strtolower($Q['name'])."%'" : '';
		$Created=isset($Q['created'])?" AND `created` >= '".$Q['created']."'" : '';
		$Modified=isset($Q['modified'])?" AND `modified` >= '".$Q['modified']."'" : '';
		$Uid=isset($Q['uid'])?" AND `uid` LIKE '".strtoupper($Q['uid'])."'" : '';
		$User=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$Pair=isset($Q['pair'])?" AND `pair` = '".$Q['pair']."'" : '';
        $CCC=isset($Q['ccc'])?" AND `ccc` LIKE '".strtoupper($Q['ccc'])."'" : '';
        $OCC=isset($Q['occ'])?" AND `occ` LIKE '".strtoupper($Q['occ'])."'" : '';
		$Price=isset($Q['price'])?" AND `price` = '".$Q['price']."'" : '';
		$Year=isset($Q['year'])?" AND `year` = '".$Q['year']."'" : '';
		$Month=isset($Q['month'])?" AND `month` = '".$Q['month']."'" : '';
		$Date=isset($Q['date'])?" AND `date` = '".$Q['date']."'" : '';
		$Hour=isset($Q['hour'])?" AND `hour` = '".$Q['hour']."'" : '';
		$Minute=isset($Q['minute'])?" AND `minute` = '".$Q['minute']."'" : '';
		$Second=isset($Q['second'])?" AND `second` = '".$Q['second']."'" : '';
		$Millisecond=isset($Q['millisecond'])?" AND `millisecond` = '".$Q['millisecond']."'" : '';
		$Datee=isset($Q['datee'])?" AND `datee` = '".$Q['datee']."'" : '';
		$Time=isset($Q['time'])?" AND `time` = '".$Q['time']."'" : '';
		
		if($Q['status']=='enable'){ $Status = " AND `status` = '1'"; }
		elseif($Q['status']=='disable'){ $Status = " AND `status` = '0'"; }
		
	}
	else{ $User = $Q; }
	
	$WhereClause=$ID.$Name.$Created.$Modified.$Uid.$User.$Pair.$CCC.$OCC.$Price.$Year.$Month.$Date.$Hour.$Minute.$Second.$Millisecond. $Datee.$Time.$Status;
	
	
	$Limit=isset($Q['limit'])? $Q['limit'] : '';
	if(!$Limit){ $Limit = 111; }
	$Offset=isset($Q['offset'])? $Q['offset'] : 0;
	
	$Sort = $Q['sort']; if(!$Sort){ $Sort = 'id'; }
	$SortBy = strtoupper($Q['sortby']); if(!$SortBy){ $SortBy = 'DESC'; }

	$SQL = "SELECT * FROM `".prefix."pods_share_price` WHERE 1 ".$WhereClause." ORDER BY `$Sort` $SortBy LIMIT ".$Limit." OFFSET ".$Offset;
	//echo $SQL;
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); 
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	
	if($ts){ return $ts; }
	
}






function Share_Price($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-06
// Input : TransactionID
// OUTPUT : Single transaction data from DB by ID($Q)
	
	if($Q){
		
		$SQL = "SELECT * FROM `".prefix."pods_share_price` WHERE `uid` = ".$Q; //echo $SQL;
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0];
	
	}
	else{ $echo = 'Data Not Found.'; }
}






//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function Share_PairNew($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-06
// Input : x, ddd, ccc, uid, low, logo, user, name, tags, high, price, minbuy, volume, status, symbol, maxbuy, stable, minsell,           maxsell, changes, priority, lastprice
// Output : A new entry in the coinpods_spot_pair table.
	
	if(is_array($Q)){ $X=$Q['x']; $DDD=$Q['ddd']; $CCC=$Q['ccc']; $Uid=$Q['uid']; $Low=$Q['low']; $Logo=$Q['logo']; $User=$Q['user']; $Name=$Q['name']; $Tags=$Q['tags']; $High=$Q['high']; $Price=$Q['price']; $Minbuy=$Q['minbuy']; $Volume=$Q['volume']; $Status=$Q['status']; $Symbol=$Q['symbol']; $Maxbuy=$Q['maxbuy']; $Stable=$Q['stable']; $Minsell=$Q['minsell']; $Maxsell=$Q['maxsell']; $Changes=$Q['changes']; $Priority=$Q['priority']; $Lastprice=$Q['lastprice']; }
	
	if($X and $DDD and $CCC and $Uid and $Low and $Logo and $User and $Name and $Tags and $High and $Price and $Minbuy and $Volume and $Status and $Symbol and $Maxbuy and $Stable and $Minsell and $Maxsell and $Changes and $Priority and $Lastprice){
		
		$SQL="INSERT INTO `".prefix."pods_share_pair`(`id`, `name`, `created`, `modified`, `uid`, `user`, `ccc`, `ddd`, `price`, `lastprice`, `volume`, `tags`, `x`, `status`, `symbol`, `logo`, `priority`, `minbuy`, `minsell`, `maxbuy`, `maxsell`, `stable`, `changes`, `high`, `low`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), '".$Uid."', '".$User."', '".$CCC."', '".$DDD."', '".$Price."', '".$Lastprice."', '".$Volume."', '".$Tags."', '".$X."', '".$Status."', '".$Symbol."', '".$Logo."', '".$Priority."', '".$Minbuy."', '".$Minsell."', '".$Maxbuy."', '".$Maxsell."', '".$Stable."', '".$Changes."', '".$High."', '".$Low."')";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Empty.'; }
	return $results;

}






function Share_PairUpdate($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-06
// Input : Only the data that needs to be updated will appear in Coinpods_spot_Pair.
// Output : This will update the same data you want to update.

	
	if(is_array($Q)){ $ID=$Q['id']; $X=$Q['x']; $DDD=$Q['ddd']; $CCC=$Q['ccc']; $Uid=$Q['uid']; $Low=$Q['low']; $Logo=$Q['logo'];  $Name=$Q['name']; $Tags=$Q['tags']; $High=$Q['high']; $Price=$Q['price']; $Minbuy=$Q['minbuy']; $Volume=$Q['volume']; $Status=$Q['status']; $Symbol=$Q['symbol']; $Maxbuy=$Q['maxbuy']; $Stable=$Q['stable']; $Minsell=$Q['minsell']; $Maxsell=$Q['maxsell']; $Changes=$Q['changes']; $Priority=$Q['priority']; $Lastprice=$Q['lastprice']; }
	
	$WHERE = " WHERE `".prefix."pods_share_pair`.`id` = '".$ID."'";
	$SET = "UPDATE `".prefix."pods_share_pair` SET  `modified`= current_timestamp()";
	
	if($X){$X = ", `x`='".$X."'";}
	if($DDD){$DDD = ", `ddd`='".$DDD."'";}
	if($CCC){$CCC = ", `ccc`='".$CCC."'";}
	if($Uid){$Uid = ", `uid`='".$Uid."'";}
	if($Low){$Low = ", `low`='".$Low."'";}
	if($Logo){$Logo = ", `logo`='".$Logo."'";}
	if($Name){$Name = ", `name`='".$Name."'";}
	if($Tags){$Tags = ", `tags`='".$Tags."'";}
	if($High){$High = ", `high`='".$High."'";}
	if($Price){$Price = ", `price`='".$Price."'";}
	if($Minbuy){$Minbuy = ", `minbuy`='".$Minbuy."'";}
	if($Volume){$Volume = ", `volume`='".$Volume."'";}
	if($Symbol){$Symbol = ", `symbol`='".$Symbol."'";}
	if($Maxbuy){$Maxbuy = ", `maxbuy`='".$Maxbuy."'";}
	if($Stable){$Stable = ", `stable`='".$Stable."'";}
	if($Minsell){$Minsell = ", `minsell`='".$Minsell."'";}
	if($Maxsell){$Maxsell = ", `maxsell`='".$Maxsell."'";}
	if($Changes){$Changes = ", `changes`='".$Changes."'";}
	if($Priority){$Priority = ", `priority`='".$Priority."'";}
	if($Lastprice){$Lastprice = ", `lastprice`='".$Lastprice."'";}
	if($Status=='enable'){$StatusValue = ", `status`='1'";}
	elseif($Status=='disable'){$StatusValue = ", `status`='0'";}
	
	$SQL=$SET.$X.$DDD.$CCC.$Uid.$Low.$Logo.$Name.$Tags.$High.$Price.$Minbuy.$Volume.$StatusValue.$Symbol.$Maxbuy.$Stable.$Minsell.$Maxsell.$Changes.$Priority.$Lastprice.$WHERE;
	
	if($SQL){  //echo $SQL;
		
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if($results){ return true; }else{ return false; }
	
	}
	else{ $echo = 'SQL Not Found.'; }
	
}




function Share_PairStatus($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-06
// Input : Status = 0,1 AND PairID
// Output : This function enables and disables the status of the pair.
	
	if(is_array($Q)){ $Status=$Q['status']; $UID=$Q['uid']; }
	if($Status and $UID){
		
		if($Status=='enable'){ $StatusValue = '1';}
		elseif($Status=='disable'){ $StatusValue = '0';}
		
		$SQL="UPDATE `".prefix."pods_share_pair` SET `status` = '".$StatusValue."', `modified` = current_timestamp() WHERE `uid` = '".$UID."'";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	
	}
	else{ $echo = 'Data Emapty.'; }
	return $results;
}




function Share_Pairs($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-06
// Input : Pairs All Data
// Output : The information about the data that comes from the input is visible.
	
	if(is_array($Q)){
		
		$X=isset($Q['x'])?" AND `x` = '".$Q['x']."'" : '';
		$ID=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Low=isset($Q['low'])?" AND `low` >= '".$Q['low']."'" : '';
		$User=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$Tags=isset($Q['tags'])?" AND `tags` = '".$Q['tags']."'" : '';
        $High=isset($Q['high'])?" AND `high` >= '".$Q['high']."'" : '';
		$Price=isset($Q['price'])?" AND `price` = '".$Q['price']."'" : '';
		$Stable=isset($Q['stable'])?" AND `stable` = '".$Q['stable']."'" : '';
		$Volume=isset($Q['volume'])?" AND `volume` = '".$Q['volume']."'" : '';
		$Maxbuy=isset($Q['maxbuy'])?" AND `maxbuy` >= '".$Q['maxbuy']."'" : '';
		$Minbuy=isset($Q['minbuy'])?" AND `minbuy` >= '".$Q['minbuy']."'" : '';
		$Uid=isset($Q['uid'])?" AND `uid` LIKE '".strtoupper($Q['uid'])."'" : '';
		$DDD=isset($Q['ddd'])?" AND `ddd` LIKE '".strtoupper($Q['ddd'])."'" : '';
        $CCC=isset($Q['ccc'])?" AND `ccc` LIKE '".strtoupper($Q['ccc'])."'" : '';
		$Created=isset($Q['created'])?" AND `created` >= '".$Q['created']."'" : '';
        $Minsell=isset($Q['minsell'])?" AND `minsell` >= '".$Q['minsell']."'" : '';
        $Maxsell=isset($Q['maxsell'])?" AND `maxsell` >= '".$Q['maxsell']."'" : '';
        $Changes=isset($Q['changes'])?" AND `changes` >= '".$Q['changes']."'" : '';
        $Name=isset($Q['name'])?" AND `name` LIKE '%".strtolower($Q['name'])."%'" : '';
		$Priority=isset($Q['priority'])?" AND `priority` = '".$Q['priority']."'" : '';
		$Modified=isset($Q['modified'])?" AND `modified` >= '".$Q['modified']."'" : '';
        $LastPrice=isset($Q['lastprice'])?" AND `lastprice` = '".$Q['lastprice']."'" : '';
		$Symbol=isset($Q['symbol'])?" AND `symbol` LIKE '".strtoupper($Q['symbol'])."'" : '';
		
		

		if($Q['status']=='enable'){ $Status = " AND `status` = '1'"; }
		elseif($Q['status']=='disable'){ $Status = " AND `status` = '0'"; }

		
	}
	else{ $User = $Q; }
	
	$WhereClause=$ID.$User.$Name.$Created.$Modified.$Uid.$CCC.$DDD.$Price.$LastPrice.$Volume.$Tags.$X.$Status.$Symbol.$Priority. $Minbuy.$Minsell.$Maxbuy.$Maxsell.$Stable.$Changes.$High.$Low;
	
	
		
	$Limit=isset($Q['limit'])? $Q['limit'] : '';
	if(!$Limit){ $Limit = 111; }
	$Offset=isset($Q['offset'])? $Q['offset'] : 0;
	
	$Sort = $Q['sort']; if(!$Sort){ $Sort = 'id'; }
	$SortBy = strtoupper($Q['sortby']); if(!$SortBy){ $SortBy = 'DESC'; }
	
	 $SQL = "SELECT * FROM `".prefix."pods_share_pair` WHERE 1 ".$WhereClause." ORDER BY `$Sort` $SortBy LIMIT ".$Limit." OFFSET ".$Offset;
	
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); //echo $SQL;
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	
	if($ts){ return $ts; }
	}








function Share_Pair($Q=null){
// Developer : Pawan Kumar
// Date : 2024-08-06
// Input : uid
// Output : Single Transaction
	
	if($Q){
		
		$SQL="SELECT * FROM `".prefix."pods_share_pair` WHERE `uid` = '".$Q."' LIMIT 1";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0];
	
	}
	else{ $echo = 'Data Empty.'; }
}


	
?>