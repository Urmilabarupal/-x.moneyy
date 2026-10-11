<?php


function TotalConvert2($Q=null){
// Developer : Pawan Kumar
// Date : 2024-10-13
// Input : UserID
// Output : Convert Total Amount
	
	if($Q){ $SQL="SELECT SUM(`amount`) FROM `Coinpods_convert2` WHERE `user` = '".$Q."'"; }
	else{ $SQL="SELECT SUM(`amount`) FROM `Coinpods_convert2`"; }
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	
	return $ts[0]['SUM(`amount`)'];

}






function Convert2($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-10
// Input : Transaction ID 
// Output : Single Transaction
	
	$echo = 'Convert2 Function Start.';
	if($Q){
		$echo = 'Q Data Found.';
		
		$SQL="SELECT * FROM `".prefix."pods_convert2` WHERE `uid` = '".$Q."';";
		$echo = 'SQL Found.';
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
	
	}
	else{ $echo = 'Data Empty.'; }
	return $ts[0];
	$echo = 'return good working.'; 
}





function Converts2($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-10
	
	$echo = 'Converts2 Function Start.';
	if(is_array($Q)){
		$echo = 'Q Data Found.';
		
		$CreatedMin = $Q['createdmin']; 
		$CreatedMax = $Q['createdmax']; 
	
		$ID=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Name=isset($Q['name'])?" AND `name` LIKE '%".strtolower($Q['name'])."%'" : '';
		$Created=isset($Q['created'])?" AND `created`LIKE '%".$Q['created']."%'" : '';
		$Modified=isset($Q['modified'])?" AND `modified` >= '".$Q['modified']."'" : '';
		$UID=isset($Q['uid'])?" AND `uid` = '".$Q['uid']."'" : '';
		$Privacy=isset($Q['privacy'])?" AND `privacy` = '".$Q['privacy']."'" : '';
		$App=isset($Q['app'])?" AND `app` = '".$Q['app']."'" : '';
		$OCC=isset($Q['occ'])?" AND `occ` = '".$Q['occ']."'" : '';
		$OCA=isset($Q['oca'])?" AND `oca` = '".$Q['oca']."'" : '';
		$Price=isset($Q['price'])?" AND `price` = '".$Q['price']."'" : '';
		$Amount=isset($Q['amount'])?" AND `amount` >= '".p2d($Q['amount'])."'" : '';
		$CCC=isset($Q['ccc'])?" AND `ccc` LIKE '".strtoupper($Q['ccc'])."'" : '';
		$Type=isset($Q['ttype'])?" AND `ttype` LIKE '".$Q['ttype']."'" : '';
		$Tid=isset($Q['tid'])?" AND `tid` = '".$Q['tid']."'" : '';
		$User=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';

		if($Q['status'] == 'enable'){ $Status = " AND `status` = '1'"; }
		elseif($Q['status'] == 'disable'){  $Status = " AND `status` = '0'"; }
		if($Q['balance'] == 'enable'){ $Balance = " AND `balance` = '1'"; }
		elseif($Q['balance'] == 'disable'){  $Balance = " AND `balance` = '0'"; }
		
		if($CreatedMin and $CreatedMax){ $Created=" AND `created` BETWEEN '".$CreatedMin."' AND '".$CreatedMax." 23:59:59'"; }
	 
		$echo = 'Data Found.'; 
	}
	else{ $User = $Q; }
	
	$WhereClause=$ID.$Name.$Created.$Modified.$UID.$Privacy.$App.$OCC.$OCA.$Price.$Amount.$CCC.$Type.$Tid.$User.$Status.$Balance;
	$echo = 'Where Clause Found.';
	
	$Limit=isset($Q['LIMIT'])? $Q['LIMIT'] : '';
	if(!$Limit){ $Limit = 11; }
	$Offset=isset($Q['OFFSET'])? $Q['OFFSET'] : 0;
	$echo = 'LIMIT And OFFSET Found.';
	
	$Short=$Q['short']; if(!$Short){ $Short = 'id'; }
	$ShortBy=$Q['shortby']; if(!$ShortBy){ $ShortBy = 'DESC'; }
	$echo = 'Sort And Sortby Found.';
	
	$MethodColumn=strtolower($Q['methodcolumn']);
	if($MethodColumn){ $MC='(`'.$MethodColumn.'`)'; } 
	else{ $MC=''; }
	
	$Method = strtoupper($Q['method']);
	if(!$Method){ $Method='*'; }
	$MM=$Method.$MC;

	$SQL = "SELECT ".$MM." FROM `".prefix."pods_convert2` WHERE 1 ".$WhereClause."  ORDER BY `".$Short."` ".$ShortBy." LIMIT ".$Limit." OFFSET ".$Offset;
	$echo = 'SQL Found.'; 
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);  //echo $SQL; echo '<br><br>';
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	$echo = 'ts data found.';
	
	//if($ts){ return $ts; }
	if($MC){ $return=$ts[0][$Method.$MC]; }else{ $return=$ts; }
	
	return $return;
	$echo = 'return good working.';
}









function Convert2New($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-19
// Input : Amount[HXC] 
// Output : Convert HXC To USDT
	
	$Output=$BeforeBalance=$AfterBalance=0;
	$UserID=i['id'];	
	$Amount = $Q; 			

	if($Amount){ 
		$echo='Amount Found';
		$Wallets=Staking_Wallets($UserID);
		$echo='Staking Wallet Data Found.';
		
		if($UserID){ 
		if($Amount){ 
		if($Wallets['usdt']>=p2d($Amount)){
			
			$BeforeBalance=$Wallets[strtolower('usdt')];
			$AfterBalance=$BeforeBalance-p2d($Amount);
			
			$HEX = $Amount/HighestPriceForConvert();
			$echo='HEX Found.';

			$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`, `buyuser`, `selluser`) VALUES (NULL, 'Convert2:".$UserID.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Convert2:".$UserID.Clean(GMT())."', '".$UserID."', '".p2d($Amount)."', 'usdt', '1', 'Convert2', '".p2d($HEX)."', 'CCC', '1', '".$Wallets[strtolower('usdt')]."', '".$AfterBalance."', '', '');"; 
			global $DB;$aa = 0; $Staked = mysqli_query($DB, $SQL);
			$IID = mysqli_insert_id($DB);
		 
		$Walletss=Staking_Wallets(); $Walletss=$Walletss[strtolower('usdt')]; $Walletss=$Walletss-p2d($Amount);
	    if($Staked){ 
		$echo='Coinpods_transaction inserted.';
		
	 $SQL1="UPDATE `Coinpods_staking_wallet` SET `usdt` = ".$Walletss."  WHERE `Coinpods_staking_wallet`.`user` = '".$UserID."';";
	unset($Walletss);
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL1);
	if($Output){
			
			
			$SQL2="INSERT INTO `Coinpods_convert2`(`id`, `name`, `created`, `modified`, `uid`, `user`, `status`, `privacy`, `app`, `occ`, `oca`, `price`, `amount`, `ccc`, `balance`, `ttype`, `tid`) VALUES (NULL, 'Convert2:".$UserID.Clean(GMT())."', current_timestamp(), current_timestamp(), '".$IID."', '".$UserID."', '1', 'Public', '1', 'usdt', '".p2d($Amount)."', '".HighestPriceForConvert()."', '".p2d($HEX)."', 'ccc', '0', 'Convert2', '".$IID."')";
			global $DB;$aa = 0; $results = mysqli_query($DB, $SQL2);
		
		}
	    }
		} 
		}
		}
	}
	return $results;
}



function Convert2ToWallet($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-10
// Input :
// Output : Adds the amount to the wallet depending on the wallet type.
	
	$echo = 'Convert To Wallets Function Start.';
	$PTs=PendingConvert2();
	$echo = 'Pending Convert2 Users Found.';
	
	if($PTs){
	$echo = 'Pending Convert2  Users Condition Good Working.';
		
	foreach($PTs as $P){
	$echo = 'Foreach Good Working.';
		
		if(AddToFunding(array( 'user'=>$P['user'], 'ccc'=>strtolower($P['ccc']), 'amount'=>$P['amount'] ))){
			Convert21Transaction($P['id']); 
			$echo = 'Add To Wallet success.';
		}
		else{ Convert22Transaction($P['id']); }
	}
	}
	else{ $echo = 'Pending Convert Achieve Users Found.'; }
}




function PendingConvert2($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-10
// Input : 
// Output : Convert ki all pending transactions
	
	$echo = 'Pending Convert2 Function Start.';
	$SQL="SELECT * FROM `".prefix."pods_convert2` WHERE `balance` = '0'";
	$echo = 'SQL Found.';
	
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	$return = $ts;
	$echo = 'return found.'; 
	
	return $return;
	$echo = 'return good working.';

}




function Convert21Transaction($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-10
// Input : Transaction ID
// Output : On success the amount in balance is updated to balance == 1.
	
	$echo = 'Convert21 Transaction Function Start.';
	if($Q){
		
		$SQL="UPDATE `".prefix."pods_convert2` SET `balance` = '1' WHERE `".prefix."pods_convert2`.`id` = '".$Q."';";
		$echo = 'SQL Found.';
		global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);
		return  $Output;
		$echo = 'return good working.';
	
	}
	else{ $echo = 'Q Data Not Found.'; } 
}





function Convert22Transaction($Q=null){
//Developer : Pawan Kumar
//Date : 2024-09-10
//Input : Transaction ID
//Output : On unsuccess the amount in balance is updated to balance == 2.

	$echo = 'Convert22 Transaction Function Start.';
	if($Q){
		$echo = 'Q data found.';
		
		$SQL="UPDATE `".prefix."pods_convert2` SET `balance` = '2' WHERE `".prefix."pods_convert2`.`id` = '".$Q."';";
		$echo = 'SQL Found.';
		global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);
		return  $Output;
		$echo = 'return good working.';
	
	}
	else{ $echo = 'Q data not found.'; }
}










?>