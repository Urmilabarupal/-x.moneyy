<?php
$PHP['App']['modified'] = '2024-11-14';
$PHP['App']['by'] = 'Pawan Kumar';

$PHP['App']['function'][1] = 'App_Transfer($UID)';
$PHP['App']['function'][2] = 'App_Transfers($Array)';
$PHP['App']['function'][3] = 'App_TransferNew($Array)';
$PHP['App']['function'][4] = 'App_TransferStatus($Array)';
$PHP['App']['function'][5] = 'App_TransferUpdate($Array)';



function App_TranfersNew($Q=null){
// Developer : Pawan Kumar
// Date : 2024-11-14
// Input : Array
// Output : hx.money to xah.ai transfer amount
	
	$echo = 'App_Tranfers New Start.';
	if(is_array($Q)){ 
		$User=$Q['user']; $Amount=$Q['amount']; $CCC=$Q['ccc']; $Appfrom=$Q['app-from']; $Appto=$Q['app-to']; $Userfrom=$Q['user-from']; $User_to=$Q['user_to']; $Wallet_from=$Q['wallet_from']; $Wallet_to=$Q['wallet_to'];
		$echo = 'Q Data Found.';
	}
	else{$echo = 'Q Data Not Found.';}
	
	if($User and $Amount and $CCC and $Appfrom and $Appto and $Userfrom and $User_to and $Wallet_from and $Wallet_to){
		$echo = 'All Data Found.';
		
		if(strtolower($Wallet_from)=='spot'){
			$echo = 'Wallet From Spot Found.';
			
			$Orderid = 'App_Transfer:'.$User_to.Clean(GMT());
			$echo = 'Oderid Found.';
			
			$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `buyuser`, `selluser`) VALUES (NULL, 'App_Transfer:".$Userfrom.Clean(GMT()).$User_to."', current_timestamp(), current_timestamp(), '".$Orderid."', '".$User."', '', '', '1', 'App_Transfer', '".p2d($Amount)."', '".strtolower($CCC)."', '1', '', '', '".$User_to."');";
			$echo = 'Spot Wallet SQL Found.';
			global $DB;$aa = 0; $Staked = mysqli_query($DB, $SQL);
			$TID = mysqli_insert_id($DB);
			$echo = 'Spot Wallet Insert Id Found.';
			
			$RemoveFromWallet=RemoveFromWallet(['user'=>$User, 'ccc'=>strtolower($CCC), 'amount'=>p2d($Amount)]);
			if($RemoveFromWallet){
			$echo = 'Spot Wallet Amount Minus Success.';
				
            $App_TransferNew=App_TransferNew(['user'=>$User,'amount'=>$Amount,'ccc'=>$CCC,'app-from'=>$Appfrom,'app-to'=>$Appto,
										  'user-from'=>$Userfrom, 'user_to'=>$User_to, 'wallet_from'=>$Wallet_from,                                                         'wallet_to'=>$Wallet_to, 'tid'=>$TID, 'balance'=>1,'app'=>1, 'show'=>1,]);
				
				if($App_TransferNew){
					$echo = 'Spot Wallet App Transfer Insert Transaction Success.';
					
	            Meting_App_TransferNew(['user'=>$User,'amount'=>$Amount,'ccc'=>$CCC,'app-from'=>$Appfrom,'app-to'=>$Appto,
	            'user-from'=>$Userfrom,'user_to'=>$User_to,'wallet_from'=>$Wallet_from,'wallet_to'=>$Wallet_to,'tid'=>$TID,
				'app'=>1,'show'=>1,]);
				
				}
				else{ $echo = 'Spot Wallet App Transfer Insert Transaction Not Working.'; }
			}
			else{ $echo = 'Spot Wallet Amount Not Minus.'; }
		}
		elseif(strtolower($Wallet_from)=='funding'){
		$echo = 'Wallet From Funding Found.';	
			
			$Orderid = 'App_Transfer:'.$User_to.Clean(GMT());
			$echo = 'Funding Wallet Orderid Found.';
			
			$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `buyuser`, `selluser`) VALUES (NULL, 'App_Transfer:".$Userfrom.Clean(GMT()).$User_to."', current_timestamp(), current_timestamp(), '".$Orderid."', '".$User."', '', '', '1', 'App_Transfer', '".p2d($Amount)."', '".strtolower($CCC)."', '1', '', '', '".$User_to."');";
			$echo = 'Funding Wallet SQL Found.';
			global $DB;$aa = 0; $Staked = mysqli_query($DB, $SQL);
			$TID = mysqli_insert_id($DB);
			$echo = 'Funding Wallet Transaction Insert Id Found.';
			
			$RemoveFromWallet=RemoveFromFunding(['user'=>$User, 'ccc'=>strtolower($CCC), 'amount'=>p2d($Amount)]);
			if($RemoveFromWallet){
			$echo = 'Funding Wallet Amount Minus Success.';
				
            $App_TransferNew=App_TransferNew(['user'=>$User,'amount'=>$Amount,'ccc'=>$CCC,'app-from'=>$Appfrom,'app-to'=>$Appto,
										  'user-from'=>$Userfrom, 'user_to'=>$User_to, 'wallet_from'=>$Wallet_from,                                                         'wallet_to'=>$Wallet_to, 'tid'=>$TID, 'balance'=>1,'app'=>1, 'show'=>1,]);
				
				if($App_TransferNew){
				$echo = 'Funding Wallet App Transfer Insert Transaction Success.';
					
	            Meting_App_TransferNew(['user'=>$User,'amount'=>$Amount,'ccc'=>$CCC,'app-from'=>$Appfrom,'app-to'=>$Appto,
	            'user-from'=>$Userfrom,'user_to'=>$User_to,'wallet_from'=>$Wallet_from,'wallet_to'=>$Wallet_to,'tid'=>$TID,
				'app'=>1,'show'=>1,]);
				
				}
				else{ $echo = 'Funding Wallet App Transfer Insert Transaction Not Working.'; }
			}
			else{ $echo = 'Funding Wallet Amount Not Minus.'; }
		}
		elseif(strtolower($Wallet_from)=='staking_wallet'){
		$echo = 'Wallet From Staking Wallet Found.';
			
			$Orderid = 'App_Transfer:'.$User_to.Clean(GMT());
			$echo = 'Staking Wallet Transaction Orderid Found.';
			
			$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `buyuser`, `selluser`) VALUES (NULL, 'App_Transfer:".$Userfrom.Clean(GMT()).$User_to."', current_timestamp(), current_timestamp(), '".$Orderid."', '".$User."', '', '', '1', 'App_Transfer', '".p2d($Amount)."', '".strtolower($CCC)."', '1', '', '', '".$User_to."');";
			$echo = 'Staking Wallet Transaction SQL Found.'; 
			global $DB;$aa = 0; $Staked = mysqli_query($DB, $SQL);
			$TID = mysqli_insert_id($DB);
			$echo = 'Staking Wallet Transaction Insert Id Found.';
			
			$RemoveFromWallet=RemoveFromStaking_Wallet(['user'=>$User, 'ccc'=>strtolower($CCC), 'amount'=>p2d($Amount)]);
			if($RemoveFromWallet){
			$echo = 'Staking Wallet Amount Minus Success.';
				
            $App_TransferNew=App_TransferNew(['user'=>$User,'amount'=>$Amount,'ccc'=>$CCC,'app-from'=>$Appfrom,'app-to'=>$Appto,
										  'user-from'=>$Userfrom, 'user_to'=>$User_to, 'wallet_from'=>$Wallet_from,                                                         'wallet_to'=>$Wallet_to, 'tid'=>$TID, 'balance'=>1,'app'=>1, 'show'=>1,]);
				
				if($App_TransferNew){
					$echo = 'Staking Wallet App Transfer Transaction Insert Success.';
					
	            Meting_App_TransferNew(['user'=>$User,'amount'=>$Amount,'ccc'=>$CCC,'app-from'=>$Appfrom,'app-to'=>$Appto,
	            'user-from'=>$Userfrom,'user_to'=>$User_to,'wallet_from'=>$Wallet_from,'wallet_to'=>$Wallet_to,'tid'=>$TID,
				'app'=>1,'show'=>1,]);
				
				}
				else{ $echo = 'Staking Wallet App Transfer Insert Transaction Not Working.'; } 
			}
			else{ $echo = 'Staking Wallet Amount Not Minus.';}
		}
		else{ $echo = 'From Wallet Not Found.'; }
	}
	else{ $echo = 'Data Empty.'; }
	return $TID;
}







function App_TransferUpdate($Q=null){
// Developer : Pawan Kumar
// Date : 2024-11-14
// Input : Array
// Output : UPDATE
	
	$echo = 'App_Transfer Update Start.';
	if(is_array($Q)){ 
	$echo = 'Q Data Found.';
		
   $Name=$Q['name']; $UID=$Q['uid']; $Status=$Q['status']; $Privacy=$Q['privacy']; $App=$Q['app']; $Show=$Q['show'];                  $Type=$Q['ttype']; $Balance=$Q['balance']; $Amount=$Q['amount']; $CCC=$Q['ccc']; $Wallet=$Q['wallet']; $Tid=$Q['tid'];            $Appfrom=$Q['app-from']; $Appto=$Q['app-to']; $Userfrom=$Q['user-from']; $User_to=$Q['user_to'];                                  $Wallet_from=$Q['wallet_from']; $Wallet_to=$Q['wallet_to'];          
	
	}
	else{ $echo = 'Q Data Not Found.'; }
	
	$WHERE = " WHERE `".prefix."pods_app_transfer`.`uid` = '".$UID."'";
	$SET = "UPDATE `".prefix."pods_app_transfer` SET  `modified`= current_timestamp()";
	$echo = 'WHERE And SET Found.';
	
	if($Name){$Name = ", `name`='".$Name."'";}
	if($Status){$Status = ", `status`='".$Status."'";}
	if($Privacy){$Privacy = ", `privacy`='".$Privacy."'";}
	if($App){$App = ", `app`='".$App."'";}
	if($Show){$Show = ", `show`='".$Show."'";}
	if($Balance){$Balance = ", `balance`='".$Balance."'";}
	if($Amount){$Amount = ", `amount`='".$Amount."'";}
	if($CCC){$CCC = ", `ccc`='".$CCC."'";}
	if($Wallet){$Wallet = ", `wallet`='".$Wallet."'";}
	if($Tid){$Tid = ", `tid`='".$Tid."'";}
	if($Appfrom){$Appfrom = ", `app-from`='".$Appfrom."'";}
	if($Appto){$Appto = ", `app-to`='".$Appto."'";}
	if($Userfrom){$Userfrom = ", `user-from`='".$Userfrom."'";}
	if($User_to){$User_to = ", `user_to`='".$User_to."'";}
	if($Wallet_from){$Wallet_from = ", `wallet_from`='".$Wallet_from."'";}
	if($Wallet_to){$Wallet_to = ", `wallet_to`='".$Wallet_to."'";}
	$SQL=$SET.$Name.$Status.$Privacy.$App.$Show.$Balance.$Amount.$CCC.$Wallet.$Tid.$Appfrom.$Appto.$Userfrom.$User_to.$Wallet_from.$Wallet_to.$WHERE;
	if($SQL){  
	$echo = 'SQL Found.';
		
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if($results){ return true; }else{ return false; }
		$echo = 'Results Found.';
	
	}
	else{ $echo = 'SQL Not Found.'; }
	
}




function App_TransferNew($Q=null){
// Developer : Pawan Kumar
// Date : 2024-11-14
// Input : Array
// Output : INSERT
	
	$echo = 'App_Transfer New Start.';
	if(is_array($Q)){ $Name =$Q['name']; $Created=$Q['created']; $Modified=$Q['modified']; $User=$Q['user']; $Privacy=$Q['privacy']; $App=$Q['app']; $Show=$Q['show']; $Balance=$Q['balance']; $Amount=$Q['amount']; $CCC=$Q['ccc']; $Wallet=$Q['wallet']; $Tid=$Q['tid']; $Appfrom=$Q['app-from']; $Appto=$Q['app-to']; $Userfrom=$Q['user-from']; $User_to=$Q['user_to']; $Wallet_from=$Q['wallet_from']; $Wallet_to=$Q['wallet_to']; }
	$echo='is array data found.';

	if($User){
	$echo='All Data Found.';
		
		if(!$Created or !$Modified){ $Created=GMT(); $Modified=GMT(); }

		$SQL="INSERT INTO `Coinpods_app_transfer`(`id`, `name`, `created`, `modified`, `uid`, `user`, `status`, `privacy`, `app`, `show`, `balance`, `amount`, `ccc`, `wallet`, `tid`, `app-from`, `app-to`, `user-from`, `user_to`, `wallet_from`, `wallet_to`) VALUES (NULL, '".$Name."', '".$Created."', '".$Modified."', '', '".$User."', '1', '".$Privacy."', '".$App."', '".$Show."', '".$Balance."', '".p2d($Amount)."', '".$CCC."', '".$Wallet."', '".$Tid."', '".$Appfrom."', '".$Appto."', '".$Userfrom."', '".$User_to."', '".$Wallet_from."', '".$Wallet_to."')";
		$echo = 'SQL Found.';
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
		$IID=mysqli_insert_id($DB);
		if($IID){
		$echo = 'Insert Id Found.';
			
			$SQL1="UPDATE `".prefix."pods_app_transfer` SET `uid`='".$IID."' WHERE `id` = '".$IID."';";
			global $DB; $aa = 0; $results = mysqli_query($DB, $SQL1);
		
		}
		else{ $echo = 'Insert Id Not Found.'; }
	}
	else{ $echo = 'Userid not found.'; }
	return $results;

}








function App_TransferStatus($Q=null){
// Developer : Pawan Kumar
// Date : 2024-11-13
// Input : UID, Status
// Output : UID By Status Update
	
	$echo = 'App_Transfer Status Start.';
	if(is_array($Q)){ $UID=$Q['uid']; $Status=$Q['status']; }
	$echo = 'Is Array Good Working.';
	
	if($UID and $Status){
	$echo = 'UID And Status Found.'; 
		
	$App_Transfer=App_Transfer($UID);
	if($App_Transfer){
	$echo = 'App_Transfer Found By UID.';
			
	   if(strtolower($Status)=='false'){ $StatusValue='0'; } 
	   else{ $StatusValue=$Status; }
	   $echo = 'Status Value Found.';
		
	   $SQL="UPDATE `".prefix."pods_app_transfer` SET `status`='".$StatusValue."', `modified`='".GMT()."' WHERE `uid`='".$UID."'";
	   global $DB;$aa = 0; 
	   $results = mysqli_query($DB, $SQL); echo $SQL;
	   $echo = 'Results Found.';
	
	}
	else{ $echo = 'App_Transfer Not Found.';}
	}
	 else{ $echo = 'UID And Status Not Found.'; }
	return $results;

}




function App_Transfers($Q=null){
// Developer : Pawan Kumar
// Date : 2024-11-13
// Input : Array
// Output : Array By Transaction Data 
	
	$echo = 'App_Transfers Start.';
	if(is_array($Q)){
	$echo = 'Q Data Found.';
		
		if(!empty($Q['id'])){ $ID = " AND `id` = '".$Q['id']."'"; }
		if(!empty($Q['name'])){ $Name = " AND `name` LIKE '%".strtolower($Q['name'])."%'"; }
		if(!empty($Q['created'])){ $Created = " AND `created` = '".$Q['created']."'"; }
		if(!empty($Q['modified'])){ $Modified = " AND `modified` = '".$Q['modified']."'"; }
		if(!empty($Q['uid'])){ $Uid = " AND `uid` = '".$Q['uid']."'"; }
		if(!empty($Q['user'])){ $User = " AND `user` = '".$Q['user']."'"; }
		if(!empty($Q['status'])){ $Status = " AND `status` = '".$Q['status']."'"; }
		if(!empty($Q['privacy'])){ $Privacy = " AND `privacy` = '".$Q['privacy']."'"; }
		if(!empty($Q['app'])){ $App = " AND `app` = '".$Q['app']."'"; }
		if(!empty($Q['show'])){ $Show = " AND `show` = '".$Q['show']."'"; }
		if(!empty($Q['balance'])){ $Balance = " AND `balance` = '".$Q['balance']."'"; }
		if(!empty($Q['amount'])){ $Amount = " AND `amount` = '".$Q['amount']."'"; }
		if(!empty($Q['ccc'])){ $CCC = " AND `ccc` = '".$Q['ccc']."'"; }
		if(!empty($Q['wallet'])){ $Wallet = " AND `wallet` = '".$Q['wallet']."'"; }
		if(!empty($Q['tid'])){ $Tid = " AND `tid` = '".$Q['tid']."'"; }
		if(!empty($Q['app-from'])){ $Appfrom = " AND `app-from` = '".$Q['app-from']."'"; }
		if(!empty($Q['app-to'])){ $Appto = " AND `app-to` = '".$Q['app-to']."'"; }
		if(!empty($Q['user-from'])){ $Userfrom = " AND `user-from` = '".$Q['user-from']."'"; }
		if(!empty($Q['user_to'])){ $User_to = " AND `user_to` = '".$Q['user_to']."'"; }
		if(!empty($Q['wallet_from'])){ $Wallet_from = " AND `wallet_from` = '".$Q['wallet_from']."'"; }
		if(!empty($Q['wallet_to'])){ $Wallet_to = " AND `wallet_to` = '".$Q['wallet_to']."'"; }
		

		$Sort = $Q['sort'];
		if($Sort == 'id'){ $Sortt = 'id'; }
		elseif($Sort == 'name'){ $Sortt = 'name'; }
		elseif($Sort == 'created'){ $Sortt = 'created'; }
		elseif($Sort == 'modified'){ $Sortt = 'modified'; }
		elseif($Sort == 'uid'){ $Sortt = 'uid'; }
		elseif($Sort == 'user'){ $Sortt = 'user'; }
		elseif($Sort == 'show'){ $Sortt = 'show'; }
		elseif($Sort == 'balance'){ $Sortt = 'balance'; }
		elseif($Sort == 'amount'){ $Sortt = 'amount'; }
		elseif($Sort == 'ccc'){ $Sortt = 'ccc'; }
		elseif($Sort == 'wallet'){ $Sortt = 'wallet'; }
		elseif($Sort == 'tid'){ $Sortt = 'tid'; }
		elseif($Sort == 'toid'){ $Sortt = 'toid'; }
		elseif($Sort == 'app-from'){ $Sortt = 'app-from'; }
		elseif($Sort == 'app-to'){ $Sortt = 'app-to'; }
		elseif($Sort == 'user-from'){ $Sortt = 'user-from'; }
		elseif($Sort == 'user_to'){ $Sortt = 'user_to'; }
		elseif($Sort == 'wallet_from'){ $Sortt = 'wallet_from'; }
		elseif($Sort == 'wallet_to'){ $Sortt = 'wallet_to'; }
		if(!$Sortt){ $Sortt='id'; }
		
		$SortBy = strtoupper($Q['sortby']);
		if(!$SortBy){ $SortBy='ASC'; }
	
	}
	else{ $User = $Q; }
	             $WhereClause=$ID.$User.$Name.$Created.$Modified.$Uid.$Status.$Privacy.$App.$Show.$Balance.$Amount.$CCC.$Wallet.$Tid.$Appfrom.$Appto.$Userfrom.$User_to.$Wallet_from.$Wallet_to;
	$echo = 'Where Clause Found.';	
	
	$Limit=isset($Q['limit'])? $Q['limit'] : '';
	if(!$Limit){ $Limit = 111; }
	$Offset=isset($Q['offset'])? $Q['offset'] : 0;
	$echo = 'Limit And Offset Found.';
	
	$MethodColumn=strtolower($Q['methodcolumn']);
	if($MethodColumn){ $MC='(`'.$MethodColumn.'`)'; } 
	else{ $MC=''; }
	
	$Method = strtoupper($Q['method']);
	if(!$Method){ $Method='*'; }
	$MM=$Method.$MC;
	
	$SQL = "SELECT ".$MM." FROM `".prefix."pods_app_transfer` WHERE `id`!=0 ".$WhereClause." ORDER BY `".$Sortt."` $SortBy LIMIT ".$Limit." OFFSET ".$Offset;
	$echo = 'SQL Found.'; 
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); //echo $SQL;
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	if($MC){ $return=$ts[0][$Method.''.$MC]; }else{ $return=$ts;}

	return $return;
}



function App_Transfer($Q=null){
// Developer : Pawan Kumar
// Date : 2024-11-13
// Input : UID
// Output : UID By Single Transaction Data
	
	if($Q){
		
		$SQL="SELECT * FROM `".prefix."pods_app_transfer` WHERE `uid` = '".$Q."' LIMIT 1";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0];
	
	}
	else{ $echo = 'Data Empty.'; }
	
}

?>