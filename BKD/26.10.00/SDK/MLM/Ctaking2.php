<?php

global $HelloXLive;
$servername = "localhost";
$username = "HelloX.Live";
$password = "A@9829011412";
$dbname = "HelloX.Live";

/*
$HelloXLive = new mysqli($servername, $username, $password, $dbname);
if($HelloXLive->connect_error){
	die("Connection failed: " . $HelloXLive->connect_error);
}
*/

//////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////

function Ctaking2_DataPending(){
	
	$SQL="SELECT * FROM `Anniversary2025` WHERE `Slot` = 'Slot3' AND `Deposit` > `Income`;";
	global $HelloXLive;$aa = 0; $results = mysqli_query($HelloXLive, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;} $return = $ts;

	return $return;

}




function Ctaking2_DataNews($Q=null){
	// Developer : Pawan Kumar
	// Date : 2025-09-12

	$Apr=20; 
	$Roi=1.2; 
	$CCC='usdt'; 
	$Period=365; 
	$Ttype='Day';

	$Jackpot_DataPending=Ctaking2_DataPending();
	if($Jackpot_DataPending){
		foreach($Jackpot_DataPending as $Single){
			
			
			$Deposit=$Single['Deposit']+$Single['By_Admin']; 
			$Amount=$Deposit-$Single['Income'];
			
			print_r($Single); echo '<br><hr>';
			//echo 'Deposit : '.$Single['Deposit'].' By Admin : '.$Single['By_Admin'].' Income : '.$Single['Income'].' Amount : '.$Amount.'<br><hr>';
			
			$SQL="INSERT INTO `Ctaking_old2`(`id`, `userid`, `created`, `modified`, `status`, `pending`, `slot`, `amount`, `ccc`, `roi`, `apr`, `period`, `ttype`) VALUES (NULL, '".$Single['Userid']."', current_timestamp(), current_timestamp(), '1', '0', '".$Single['Slot']."', '".p2d($Amount)."', '".$CCC."', '".$Roi."', '".$Apr."', '".$Period."', '".$Ttype."')";
			//global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);		
			
		}
	}
	return $results;
}




function Ctaking_Income2ToWallet($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-09-10

	$Output=0;	
	$Staking_Incomes=Ctaking_Incomes2(['status'=>1, 'balance'=>'false', 'LIMIT'=>11111111]);	
	if($Staking_Incomes){

		foreach($Staking_Incomes as $Ps){

			if(AddToWallet(array( 'user'=>$Ps['user'], 'ccc'=>strtolower($Ps['ccc']), 'amount'=>$Ps['amount'] ))){
				Ctaking_Income2Update(array('uid'=>$Ps['id'], 'balance'=>1));
				$Output=1;
			}
			else{ 
				Ctaking_Income2Update(array('uid'=>$Ps['id'], 'balance'=>2));
			}
		}
	}
	else{ $echo = 'Pending Users Not Found.'; }
	return $Output;
}


function Ctaking_Income2Update($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-09-10
	
	$Coinpods_ctaking = 'Coinpods_ctaking_income2';

	if(is_array($Q)){ $ID=$Q['id']; $Name=$Q['name']; $User=$Q['user']; $Privacy=$Q['privacy']; $App=$Q['app']; $Ttype=$Q['ttype']; $Amount=$Q['amount']; $CCC=$Q['ccc']; $Status=$Q['status']; $Balance=$Q['balance']; $Processing=$Q['processing']; $UID=$Q['uid'];}

	$s=0; global $DB;

	$Modified=" SET `modified` = current_timestamp()";
	if($ID){$ID=", `id` = '".$ID."'";}
	if($Name){$Name=", `name` = '".$Name."'";}
	if($User){$User=", `user` = '".$User."'";}
	if($Privacy){$Privacy=", `privacy` = '".$Privacy."'";}
	if($App){$App=", `app` = '".$App."'";}
	if($Ttype){$Ttype=", `ttype` = '".$Ttype."'";}
	if($Amount){$Amount=", `amount` = '".$Amount."'";}
	if($CCC){$CCC=", `ccc` = '".$CCC."'";}
	if($Balance){$Balance=", `balance` = '".$Balance."'";}
	if($Processing){$Processing=", `processing` = '".$Processing."'";}
	if($Status){$Status=", `status` = '".$Status."'";}

	$SET=$ID.$Modified.$Name.$User.$Privacy.$App.$Ttype.$Amount.$CCC.$Balance.$Processing.$Status; 

	$SQL ="UPDATE `$Coinpods_ctaking` ".$SET." WHERE `$Coinpods_ctaking`.`uid` = '".$UID."'";  
	$users = mysqli_query($DB, $SQL); 
	$s=1; $logs=$SQLl;
	return array('s'=>$s,'logs'=>$logs);  
}




function Ctaking_Incomes2($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date: 2025-09-10
	
	$Coinpods_ctaking = 'Coinpods_ctaking_income2';

	if(is_array($Q)){

		$Sort = $Q['Sort'];
		$Id=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Uid=isset($Q['uid'])?" AND `uid` = '".$Q['uid']."'" : '';
		$Name=isset($Q['name'])?" AND `name` = '".$Q['name']."'" : '';
		$Usre=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$Privacy=isset($Q['privacy'])?" AND `privacy` = '".$Q['privacy']."'" : '';
		$App=isset($Q['app'])?" AND `app` = '".$Q['app']."'" : '';
		$Ttype=isset($Q['ttype'])?" AND `ttype` = '".$Q['ttype']."'" : '';
		$Amount=isset($Q['amount'])?" AND `amount` = '".$Q['amount']."'" : '';
		$CCC=isset($Q['ccc'])?" AND `ccc` LIKE '".$Q['ccc']."%'" : '';
		$Processing=isset($Q['processing'])?" AND `processing` = '".$Q['processing']."'" : '';

		if(strtolower($Q['status']) == 'false'){ $Status = " AND `status` = '0'"; }
		else{  $Status = " AND `status` = '".$Q['status']."'"; }

		if(strtolower($Q['balance']) == 'false'){ $Balance = " AND `balance` = '0'"; }
		else{ $Balance = " AND `balance` = '".$Q['balance']."'"; }


		if($Sort == 'id'){ $Sortt = 'id'; }
		elseif($Sort == 'uid'){ $Sortt = 'uid'; }
		elseif($Sort == 'name'){ $Sortt = 'name'; }
		elseif($Sort == 'user'){ $Sortt = 'user'; }
		elseif($Sort == 'privacy'){ $Sortt = 'privacy'; }
		elseif($Sort == 'app'){ $Sortt = 'app'; }
		elseif($Sort == 'ttype'){ $Sortt = 'ttype'; }
		elseif($Sort == 'amount'){ $Sortt = 'amount'; }
		elseif($Sort == 'balance'){ $Sortt = 'balance'; }
		elseif($Sort == 'processing'){ $Sortt = 'processing'; }
		elseif($Sort == 'status'){ $Sortt = 'status'; }
		elseif($Sort == 'ccc'){ $Sortt = 'ccc'; }

		else{$Sortt='id';}
		$SortBy = strtoupper($Q['sortby']); if(!$SortBy){ $SortBy='ASC'; }
	}
	$WhereClause="1".$Id.$Uid.$Name.$Usre.$Privacy.$App.$Ttype.$Amount.$CCC.$Balance.$Processing.$Status;

	$Limit=isset($Q['LIMIT'])? $Q['LIMIT'] : ''; 
	if(!$Limit){ $Limit = 10; }

	$Offset=isset($Q['OFFSET'])? $Q['OFFSET'] : 0;

	$MethodColumn=strtolower($Q['methodcolumn']);
	if($MethodColumn){ $MC='(`'.$MethodColumn.'`)'; } 
	else{ $MC=''; }

	$Method = strtoupper($Q['method']);
	if(!$Method){ $Method='*'; }
	$MM=$Method.$MC;

	$SQL = "SELECT ".$MM." FROM `$Coinpods_ctaking` WHERE ".$WhereClause." ORDER BY `".$Sortt."` $SortBy  LIMIT ".$Limit." OFFSET ".$Offset;

	//echo $SQL;
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);  
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;} 
	if($MC){ $return=$ts[0][$Method.$MC]; }else{ $return=$ts;}
	return $return;   

}





function Ctaking2ToTransactions(){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-09-10

	$Dispatche=0;
	$Stakings = Ctakings2(array('status'=>1,'staking'=>1, 'sort'=>'id', 'sortby'=>'desc', 'limit'=>11111111, ));
	if($Stakings){
		foreach($Stakings as $Staking){

			Ctaking2ToTransaction($Staking);

			if($Dispatche==1){
				$Output = 'Success';
			}
		}	
	}	
}



function Ctaking_Income2New($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 205-09-10
	
	$Type='Ctaking Income2';
	$Coinpods_ctaking = 'Coinpods_ctaking_income2';


	if(is_array($Q)){ $Name=$Q['name']; $User=$Q['user']; $Ttype=$Q['ttype']; $Amount=$Q['amount']; }
	if($Name and $User and $Ttype and $Amount){


		$SQL="INSERT INTO `$Coinpods_ctaking`(`id`, `name`, `created`, `modified`, `user`,  `privacy`, `app`, `ttype`, `amount`, `ccc`, `status`, `balance`, `processing`) VALUES ('NULL', '".$Type.":".$Name.":".GMT()."', current_timestamp(), current_timestamp(), '".$User."', 'Public', '1', '".$Ttype."', '".$Amount."', 'usdt', '1', '0', '' )";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		$IID = mysqli_insert_id($DB);
		if($results){

			$SQL1="UPDATE `$Coinpods_ctaking` SET `uid`='".$IID."' WHERE `id`='".$IID."'" ;
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);

		}
	}
	return $Output;
}




function Ctaking2ToTransaction($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-09-10

	$BeforeBalance=$AfterBalance=0;
	$Type='CtakingIncome2';
	$Coinpods_ctaking = 'Coinpods_ctaking2';


	$ech = 'Ctaking To Transaction Start.';
	if($Q){
		$echo = 'Q data found.';

		if($Q['staking']){
			$echo = 'Staking Found.';

			//$Staking_Wallets=Staking_Wallets($Q['user']);
			//$BeforeBalance=$Staking_Wallets['usdt'];
			//$AfterBalance=$BeforeBalance+$Q['staking'];

			$SQL="INSERT INTO `".prefix."pods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`) VALUES (NULL, '".$Type.":".$Q['id'].":".GMT()."', current_timestamp(), current_timestamp(), '".$Type."Income".$Q['id']."at".Clean(GMT())."', '".$Q['user']."', '', '', '1', '".$Type."', '".$Q['staking']."', 'usdt', '1', '".$BeforeBalance."', '".$AfterBalance."');";
			$echo = 'SQL Found.'; 
			global $DB;	$Output = mysqli_query($DB, $SQL);
			if($Output){ 
				$echo = 'Coinpods Transaction Output Found.';


				$SQL2="UPDATE `$Coinpods_ctaking` SET `totalstaking` = `totalstaking` + `staking`, `staking` = 0 WHERE `$Coinpods_ctaking`.`id` = '".$Q['id']."';"; //echo $SQL2;
				global $DB;	$Output = mysqli_query($DB, $SQL2);
				if($Output){
					$echo = 'Coinpods Ctaking Output Found.';

					$Array = array( 'name'=>$Q['id'], 
								   'user'=>$Q['user'], 
								   'ttype'=>$Type, 
								   'amount'=>$Q['staking'], 
								   'ccc'=>strtolower($Q['ccc']), 
								  );
					$echo = 'Array data found.'; 

					$Staking_IncomeNew = Ctaking_Income2New($Array);
					if($Staking_IncomeNew){
						$echo = 'Staking_Income New Output Found.';
					}
					else{ $echo = 'Staking_Income New Output Not Found.'; }
				}
				else{ $echo = 'Coinpods Staking Output Not Found.'; }
			}
			else{ $echo = 'Coinpods Transaction Output Not Found.'; }
		}
		else{ $echo = 'Staking Not Found.'; }
	}
	else{ $echo = 'Q Data Not Found.'; }
	return $Output;
} 	






function CtakesToCtaking2(){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-09-10

	$ab=0;
	$StakesToStaking=[];
	$Stakes=Ctakings2(['status'=>1, 'limit'=>11111111]);
	if($Stakes){
		foreach($Stakes as $Stake){	
			if(Ctaking2($Stake)){ $ab++; }		
		}	
	}
	return $ab;	
}






function Ctaking2($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-09-10

	if($Q and is_array($Q)){
		if($Q['status']==1){
			$Amount=$Q['amount']*$Q['roi']/100;
			//$Amount = $Staking*$Q['price'];

			$SQL="UPDATE `".prefix."pods_ctaking2` SET `staking` = `staking` + ".$Amount.", `updated` = current_timestamp()  WHERE `Coinpods_ctaking2`.`id` = '".$Q['id']."';";
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
			return true;

		}	
	}
}


function Ctakings2($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-09-10

	if(is_array($Q)){

		$ID=!empty($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Updated=!empty($Q['updated'])?" AND `updated` LIKE '%".$Q['updated']."%'" : '';
		$Name=!empty($Q['name'])?" AND `name` LIKE '%".strtolower($Q['name'])."%'" : '';
		$Created=!empty($Q['created'])?" AND `created` >= '".$Q['created']."'" : '';
		$Modified=!empty($Q['modified'])?" AND `modified` >= '".$Q['modified']."'" : '';
		$Amount=!empty($Q['amount'])?" AND `amount` >= '".p2d($Q['amount'])."'" : '';
		$User=!empty($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$CCC=!empty($Q['ccc'])?" AND `ccc` LIKE '".strtolower($Q['ccc'])."'" : '';
		$Roi=!empty($Q['roi'])?" AND `roi` = '".$Q['roi']."'" : '';
		$Period=!empty($Q['period'])?" AND `period` = '".$Q['period']."'" : '';
		$Ttype=!empty($Q['ttype'])?" AND `ttype` = '".$Q['ttype']."'" : '';
		$Staking=!empty($Q['staking'])?" AND `staking` >= '".$Q['staking']."'" : '';
		$TotalStaking=!empty($Q['totalstaking'])?" AND `totalstaking` >= '".p2d($Q['totalstaking'])."'" : '';
		$IST=!empty($Q['ist'])?" AND `ist` >= '".$Q['ist']."'" : '';
		$Price=!empty($Q['price'])?" AND `price` = '".$Q['price']."'" : '';
		$USD=!empty($Q['usd'])?" AND `usd` = '".p2d($Q['usd'])."'" : '';
		$UnStaking=!empty($Q['unstaking'])?" AND `unstaking` = '".$Q['unstaking']."'" : '';
		$Plan=!empty($Q['plan'])?" AND `plan` = '".$Q['plan']."'" : '';
		$Offer=!empty($Q['offer'])?" AND `offer` = '".$Q['offer']."'" : '';
		$Uid=!empty($Q['uid'])?" AND `uid` = '".$Q['uid']."'" : '';
		$Privacy=!empty($Q['privacy'])?" AND `privacy` = '".$Q['privacy']."'" : '';

		if(strtolower($Q['status'])=='false'){ $Status = " AND `status` = '0'"; }
		else{ if($Q['status']){ $Status = " AND `status` = '".$Q['status']."'"; } }

		if(!empty($Q['level'])){
			if(strtolower($Q['level']) == 'false'){ $Level = " AND `level` = '0'"; } 
			else{ $Level = " AND `level` = '" . $Q['level'] . "'"; }
		} 
		else{  $Level = ""; }	

		$Sort = $Q['sort']; if(!$Sort){ $Sort='id'; }
		$SortBy = strtoupper($Q['sortby']); if(!$SortBy){ $SortBy='DESC'; }

	}
	else{ $User = $Q; }

	$WhereClause=$ID.$Updated.$Name.$Created.$Modified.$Amount.$User.$CCC.$Roi.$Period.$Ttype.$Staking.$TotalStaking.$IST.$Price.$USD.$UnStaking.$Plan.$Offer.$Uid.$Privacy.$Status.$Level;

	$Limit=!empty($Q['limit'])? $Q['limit'] : '';
	if(!$Limit){ $Limit = 111; }
	$Offset=!empty($Q['offset'])? $Q['offset'] : 0;

	$MethodColumn=strtolower($Q['methodcolumn']);
	if($MethodColumn){ $MC='(`'.$MethodColumn.'`)'; } 
	else{ $MC=''; }

	$Method = strtoupper($Q['method']);
	if(!$Method){ $Method='*'; }
	$MM=$Method.$MC;

	$SQL = "SELECT ".$MM." FROM `".prefix."pods_ctaking2` WHERE 1=1 ".$WhereClause." ORDER BY `".$Sort."` $SortBy LIMIT ".$Limit." OFFSET ".$Offset; 
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); //echo $SQL;
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}

	if($MC){ $return=$ts[0][$Method.''.$MC]; }else{ $return=$ts;}
	return $return;
}







function Ctaking2_New($Q=null){
	// Developer : Pawan Kumar Meghwal
	// Date : 2025-09-10

	$Type='Ctaking2';
	$Ctaking_old='Ctaking_old2';
	$Coinpods_ctaking = 'Coinpods_ctaking2';


	$Ctaking_OLD1_Pending=Ctaking_OLD2_Pending();
	if($Ctaking_OLD1_Pending){
		foreach($Ctaking_OLD1_Pending as $Single){

			$UserByUserid=UserByUserid($Single['userid']);
			$UserID=$UserByUserid['ID'];


			$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`) VALUES (NULL, '".$Type.":".$UserID.Clean(GMT())."', current_timestamp(), current_timestamp(), '".$Type.":".$UserID.Clean(GMT())."', '".$UserID."', '', '', '1', '".$Type."', '".p2d($Single['amount'])."', '".strtoupper($Single['ccc'])."', '1', '0', '0');";
			global $DB;$aa = 0; $Staked = mysqli_query($DB, $SQL);
			if($Staked){ 


				$SQL2="INSERT INTO `$Coinpods_ctaking`(`id`, `name`, `created`, `modified`, `amount`, `user`, `ccc`, `roi`, `period`, `ttype`, `status`, `ist`, `price`, `usd`, `plan`, `uid`, `privacy`, `app`, `apr`) VALUES (NULL, '".$UserID."', current_timestamp(), current_timestamp(), '".p2d($Single['amount'])."', '".$UserID."', '".$Single['ccc']."', '".$Single['roi']."', '".$Single['period']."', '".$Single['ttype']."', '1', '".IST()."', '', '', '', 'NULL', 'Public', '1', '".$Single['apr']."')";
				global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL2);
				$SID=mysqli_insert_id($DB);

				if($SID){

					$SQL3="UPDATE `$Coinpods_ctaking` SET `uid`='".$SID."' WHERE `id` = '".$SID."'";
					global $DB; $aa = 0; $Outputt = mysqli_query($DB, $SQL3);

					if($DB){
						$SQL = "UPDATE `$Ctaking_old` SET `pending`='1' WHERE `id` = '".$Single['id']."'";
						global $DB; $aa = 0; $Outputt = mysqli_query($DB, $SQL);
					}
					else{
						$SQL = "UPDATE `$Ctaking_old` SET `pending`='2' WHERE `id` = '".$Single['id']."'";
						global $DB; $aa = 0; $Outputt = mysqli_query($DB, $SQL);
					}
				}
				else{
					$SQL = "UPDATE `$Ctaking_old` SET `pending`='2' WHERE `id` = '".$Single['id']."'";
					global $DB; $aa = 0; $Outputt = mysqli_query($DB, $SQL);
				}
			}
			else{
				$SQL = "UPDATE `$Ctaking_old` SET `pending`='3' WHERE `id` = '".$Single['id']."'";
				global $DB; $aa = 0; $Outputt = mysqli_query($DB, $SQL);
			}
		}
	}
	else{ $echo = 'Pending Users Not Found.'; }
}




function Ctaking_OLD2_Pending($Q=null){
	// Developer : Pawan Kumar
	// Date : 2025-09-10

	$SQL="SELECT * FROM `Ctaking_old2` WHERE `pending` = 0 LIMIT 1";
	$echo = 'SQL Found.';

	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	$return = $ts;
	$echo = 'return found.'; 

	return $return;
	$echo = 'return good working.';

}



?>