<?php

import('User');
import('MLM');


$PHP['Staking2']['modified'] = '2024-11-29';
$PHP['Staking2']['by'] = 'Pawan Kumar';

$PHP['Staking2']['function'][1] = 'Staking2_Income($Uid=NULL)';
$PHP['Staking2']['function'][2] = 'Staking2_IncomeNew($Q=null)';
$PHP['Staking2']['function'][3] = 'Staking2_IncomeStatus($Q=null)';
$PHP['Staking2']['function'][4] = 'Staking2_IncomeUpdate($Q=null)';
$PHP['Staking2']['function'][5] = 'Staking2_Incomes($Q=null)';
$PHP['Staking2']['function'][6] = 'Staking2ToTransaction($Q=null)';
$PHP['Staking2']['function'][7] = 'Staking2ToTransactions($Q=null)';
$PHP['Staking2']['function'][8] = 'Staking2($Q=null)';
$PHP['Staking2']['function'][8] = 'StakesToStaking2($UID=null)';
$PHP['Staking2']['function'][9] = 'Stakes2($Q=null)';
$PHP['Staking2']['function'][10] = 'Spot_Staking2Status($Q=null)';
$PHP['Staking2']['function'][11] = 'Staking2New($Q=null)';
$PHP['Staking2']['function'][12] = 'Spot_Staking2Update($Q=null)';
$PHP['Staking2']['function'][13] = 'Spot_Stakings2($Q=null)';
$PHP['Staking2']['function'][14] = 'Spot_Staking2($Q=null)';
$PHP['Staking2']['function'][15] = 'Staking2_PlanStatus($Q=null)';
$PHP['Staking2']['function'][16] = 'Staking2_PlanUpdate($Q=null)';
$PHP['Staking2']['function'][18] = 'Staking2_PlanNew($Q=null)';
$PHP['Staking2']['function'][19] = 'Staking2_Plans($Q=null)';
$PHP['Staking2']['function'][20] = 'Staking2_Plan($Q=null)';
$PHP['Staking2']['function'][21] = 'PendingStaking2Transactions($Q=null)';
$PHP['Staking2']['function'][22] = 'Staking2_IncomeToWallet($Q=null)';






# Jaspal Work Started 



function TotalStaking2_Income($Q=[]){
	$User = $Q['user'];$Created = $Q['created'];
	if(!empty($User) and !empty($Created)){-
		$SQL = null;
		$SQL = "SELECT SUM(`amount`) AS `amount` FROM `Coinpods_staking2_income` WHERE `user` = '".$User."' AND `created` BETWEEN '".gmdate('Y-m-01')." 00:00:00' AND '".$Created." 23:59:59'"; //echo $SQL;
		global $DB;$aa = 0;	$ts=[];$t=null;$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return 	$ts[0]['amount'];
	}
	else{ $echo = 'User Is Required';}
}


function TodayTotalStaking2($User=null){
	if(!empty($User)){
		$SQL = null;
		//$SQL = "SELECT SUM((`roi`*`amount`)/100)*`price` AS `amount` FROM `Coinpods_staking2` WHERE `user` = '".$User."' AND `status` = 1";
		
		$SQL = "SELECT COALESCE( FLOOR( SUM( ((`roi` * `amount`) / 100) * `price` ) ), 0 ) AS `amount` FROM `Coinpods_staking2` WHERE `user` = '".$User."' AND `status` = 1;";
		global $DB;$aa = 0;	$ts=[];$t=null;$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return 	$ts[0]['amount'];
	}
	else{ $echo = 'User Is Required';}
}


function CapingNow($Array = [])
{
	/* [CODEHEADER]
      Developer     : AlienCyborg (2026-04-09)
      Purpose       : Determine user's daily staking income cap from rank.
      Input         : $Array['user']
      Output        : int|float (daily cap amount)
      Dependencies  : User(), Interval(), UID_Encode(), d2p(), d()
    */

	$echo = '[TeamStaking][CapingNow] Started'; d($echo, __LINE__, 'progress');

	$User_Object = new User();
	$OriginalDailyCap = 15;

	$echo = '[TeamStaking][CapingNow] #Try To Run Function : Interval().'; d($echo, __LINE__, 'process');
	$Interval = Interval(gmdate('Y-m-d'));
	$echo = '[TeamStaking][CapingNow] *Try To Run Function : Interval().'; d($echo, __LINE__, 'success');

	$User = null;
	$User = $Array['user'];


	// ---- Guard: User required ----
	if (!$User) {
		$echo = '[TeamStaking][CapingNow] User Not Found.'; d($echo, __LINE__, 'error');
		return $OriginalDailyCap;
	}

	$echo = '[TeamStaking][CapingNow] User Found.'; d($echo, __LINE__, 'process');


	// ---- Guard: Interval required ----
	if (!$Interval) {
		$echo = '[TeamStaking][CapingNow] $Interval Data Not Found.'; d($echo, __LINE__, 'error');
		return $OriginalDailyCap;
	}

	$echo = '[TeamStaking][CapingNow] Interval Data Found.'; d($echo, __LINE__, 'process');


	// ---- Guard: Last month UID ----
	$LastMonthUID = $Interval['month_last']['uid'];

	if (!$LastMonthUID) {
		$echo = '[TeamStaking][CapingNow] Last Month UID Not Found.'; d($echo, __LINE__, 'error');
		return $OriginalDailyCap;
	}

	$echo = '[TeamStaking][CapingNow] Last Month UID Found.'; d($echo, __LINE__, 'process');


	// ---- Step 1: Get user's Reward_Rank from last month ----
	$UID_Encode = [
		'app'      => App['id'],
		'user'     => $User,
		'interval' => $LastMonthUID,
		'method'   => 'COUNT',
		'key'      => 'Reward_Rank',
		'relation' => 'Self',
		'pair'     => 'USDT_USDT',
		'table'    => 'user_meta'
	];

	$echo = '[TeamStaking][CapingNow] #Try To Run Function : UID_Encode().'; d($echo, __LINE__, 'process');
	$UID = UID_Encode($UID_Encode)['uid'];
	unset($UID_Encode);
	$echo = '[TeamStaking][CapingNow] *Try To Run Function : UID_Encode().'; d($echo, __LINE__, 'success');

	$echo = '[TeamStaking][CapingNow] #Try To Run Function : User_Meta().'; d($echo, __LINE__, 'process');
	$User_Meta = $User_Object->User_Meta($UID)['o'];
	unset($UID);
	$echo = '[TeamStaking][CapingNow] *Try To Run Function : User_Meta().'; d($echo, __LINE__, 'success');

	// ---- Step 2: Map rank to daily cap ----
	$Rank = $User_Meta['value'];

	$RankRange = [
		0  => 15,
		1  => 20,
		2  => 30,
		3  => 50,
		4  => 75,
		5  => 125,
		6  => 175,
		7  => 250,
		8  => 500,
		9  => 1000,
		10 => 2000
	];

	if (isset($RankRange[$Rank])) {
		$OriginalDailyCap = $RankRange[$Rank];
		$echo = '[TeamStaking][CapingNow] Rank Capping Found : ' . $OriginalDailyCap . ' User : ' . $User . ' Rank : ' . $Rank; d($echo, __LINE__, 'success');
	} else {
		$echo = '[TeamStaking][CapingNow] daily Capping Rank Not Match , daily Capping Fixed 15$.'; d($echo, __LINE__, 'process');
	}

	$echo = '[TeamStaking][CapingNow] Completed'; d($echo, __LINE__, 'success');
	return $OriginalDailyCap;
}



function TodayDataUpdate($Q=null){
	$echo = 'Step 1: TodayDataUpdate Function Start';d($echo);

	$Return = [];
	$SQL_SELECT = $SQL_UPDATE = null;
	$SQL_SELECT = "SELECT `ID` FROM `Coinusers` WHERE `StakingTeamLevel1` = 1 AND `StakingTeamLevel` = 1;";

	$echo = 'Step 2: Coinusers Select Query Ready';d($echo);

	global $DB;$aa = 0;$ts=[];$t=null;

	$echo = 'Step 3: Coinusers Select Query Execute';d($echo);

	$results = mysqli_query($DB, $SQL_SELECT);

	$echo = 'Step 4: Coinusers Select Query Executed';d($echo);

	if(mysqli_num_rows($results) > 0){
		$echo = 'Step 5: Coinusers Records Found';d($echo);

		while($t = mysqli_fetch_assoc($results)){
			$ts[$aa] = $t;
			$aa++;

			$echo = 'Step 6: Coinusers Record Added In Processing Array';d($echo);
		}
	}
	else{
		$echo = 'Step 5: Coinusers Records Not Found';d($echo);

		$ts = null;
	}

	if(is_array($ts) and !empty($ts)){
		$echo = 'Step 7: Users Processing Start';d($echo);

		foreach($ts as $Single){
			$echo = 'Step 8: Single User Processing Start';d($echo);

			$User = null;
			$User = $Single['ID'];

			if($User){
				$echo = 'Step 9: User Found';d($echo);
				$TodayTotalStaking2 = $CapingNow=0;

				$echo = 'Step 10: Today Total Staking Calculation Start';d($echo);

				$TodayTotalStaking2 = TodayTotalStaking2($User);

				$echo = 'Step 11: Today Total Staking Calculation Complete';d($echo);

				$echo = 'Step 12: Capping Calculation Start';d($echo);

				$CapingNow = p2d(CapingNow(['user'=>$User]));

				$echo = 'Step 13: Capping Calculation Complete';d($echo);

				$echo = 'Step 14: Coinusers Update Query Ready';d($echo);
				if($CapingNow and $TodayTotalStaking2){
					$echo = 'Step 14.1: Coinusers Update Query Execute';d($echo);

				$SQL_UPDATE = "UPDATE `Coinusers` SET  `today_capping` = '".$CapingNow."' , `today_total_teamstaking_sum` = '".$TodayTotalStaking2."' WHERE `ID` = '".$User."'";
				}
				else{$echo = 'Step 14.1: Coinusers Update Query Not Execute';d($echo);}

				$echo = 'Step 15: Coinusers Update Query Execute';d($echo);

				$results = 0; $results = mysqli_query($DB, $SQL_UPDATE);

				$echo = 'Step 16: Coinusers Update Query Executed';d($echo);

				$Return[$User]['result'] = $results;
				$Return[$User]['SQL_UPDATE'] = $SQL_UPDATE;

				$echo = 'Step 17: User Result Added In Return Array';d($echo);

				//echo $results.'<br>';

			}
			else{
				$echo = 'Step 9: User Not Found';d($echo);
			}

			$echo = 'Step 18: Single User Processing Complete';d($echo);
		}

		$echo = 'Step 19: All Users Processing Complete';d($echo);
	}
	else{
		$echo = 'Step 7: Users Processing Array Empty';d($echo);
	}

	$echo = 'Step 20: TodayDataUpdate Function Complete';d($echo);

	return $Return;
}
# Jaspal Work Ended 





















function UserStakings2($Q=null){
	// Developer : Sahiram Nayak
	// Date : 2025-07-02
	// Input :
	// Output :  TRansaction Deta Hai 

	#--*--#
	// Ye Function Team STaking Income Generate karne ke liye banaya Hai 
	// Ye Coinusers Ki Table Me se Jis User Ka StakingTeamLevel1==1 Hai Use SELECT Karta hai Or Free Us Ko Staking2 ke Table me ID Se SELCET Karta Hai 
	//  DONO  Table Ko JOIN Karya Hai ki Jo User Achiever Hai Usi Ko processing  Karya Hai Ki System par load na De 
	#--*--#

	$SQL="SELECT cs2.* FROM `hx.money.os`.`Coinpods_staking2` cs2 JOIN `hx.money.os`.`Coinusers` cu ON cu.id = cs2.user WHERE cu.StakingTeamLevel = 1 AND cu.StakingTeamLevel1 = 1 AND cs2.`status` = 1 AND cs2.`amount` > 0 AND cs2.`staking` > 0 LIMIT 10000  OFFSET 0;";
	//$SQL="SELECT cs2.* FROM `hx.money.os`.`Coinpods_staking2` cs2 JOIN `hx.money.os`.`Coinusers` cu ON cu.id = cs2.user WHERE cu.StakingTeamLevel = 1 AND cu.StakingTeamLevel1 = 1 AND cs2.`status` = 1 AND cs2.`amount` > 0 AND cs2.`staking` > 0 AND cs2.`user` = 1 LIMIT 1000;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}

	return $ts;

}






function Coinusers($Q=null){
	if(!$Q){$Q=i['id'];}

	$SQL="SELECT * FROM `".prefix."users` WHERE `ID`='".$Q."'";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}

	return $ts[0];

}


function Stakings2_Create($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-11-28
	// Input : 
	// Output : Income Of Income Transaction Create Main Function

	$Output=0;
	$Spot_Stakings=Spot_Stakings(['status'=>1, 'level'=>'false']);
	if($Spot_Stakings){
		foreach($Spot_Stakings as $Ps){
			if($Ps){
				$Array=[
					'id'=>$Ps['id'], 
					'uid'=>$Ps['uid'], 
					'created'=>$Ps['created'], 
					'user'=>$Ps['user'], 
					'period'=>$Ps['period'],
					'amount'=>$Ps['amount'], 
					'ccc'=>$Ps['ccc'], 
					'ttype'=>$Ps['ttype'],
					'plan'=>$Ps['plan'],
					'usd'=>$Ps['usd'],
					'price'=>$Ps['price'],
				];

				$Staking2_Create='';
				$Staking2_Create=Staking2_Create($Array);
				if($Staking2_Create){ 

					if(strtolower($Ps['ccc']) == 'ccc'){  $Pair = 'CCC_CCC'; }
					elseif(strtolower($Ps['ccc']) == 'usdt'){  $Pair = 'USDT_USDT'; }

					$Dispatch =  1;

					if($Dispatch){
						$Array=['feature'=>'TeamStaking','pair'=>$Pair,'user'=>$Ps['user'],'amount'=>$Ps['amount'],];
						HistoryUpdateNew($Array);
						$echo = "Successfully Found.";
					}
					else{ $echo = "Data Not Found."; }

					Spot_StakingUpdate(['uid'=>$Ps['uid'], 'level'=>1]);
					$Output=1;
				}
				else{ Spot_StakingUpdate(['uid'=>$Ps['uid'], 'level'=>2]); }
			}
			else{ $echo = 'Pending Staking Not Found.'; }
		}
	}
	else{ $echo = 'Data Not Found.'; }
	return $Output;
}



function Staking2_Create($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-11-28
	// Input : Array
	// Output : Income Of Income Transaction Create 


	if(is_array($Q)){ $Created = $Q['created']; $UID=$Q['uid']; $TID=$Q['id']; $User=$Q['user'];  $Userr=$Q['user']; $Period=$Q['period']; $Amount=$Q['amount']; $USDT=$Q['usd']; $CCC=$Q['ccc']; $Type=$Q['ttype']; $Plan=$Q['plan']; $Price=$Q['price']; }

	if($User and $Period and $Amount and $CCC and $Type and $Plan and $Price){

		$LS=[];
		if($Period == 365){ $LS=['1'=>2, '2'=>1, '3'=>1, '4'=>1, '5'=>1, '6'=>1, '7'=>1, '8'=>1, '9'=>0.50, '10'=>0.50]; }
		elseif($Period == 730){ $LS=['1'=>4, '2'=>2, '3'=>2, '4'=>2, '5'=>2, '6'=>2, '7'=>2, '8'=>2, '9'=>1, '10'=>1]; } 
		elseif($Period == 1825){ $LS=['1'=>8, '2'=>4, '3'=>4, '4'=>4, '5'=>4, '6'=>4, '7'=>4, '8'=>4, '9'=>2, '10'=>2]; }

		$User = User($User); 
		if($User){ $Uplines = Uplines($User['userid']); }

		if($User and $Uplines){
			$aa=0;

			foreach($Uplines as $Upline){

				$CurrentUser = UserByUserID($Upline);
				$aa++;

				if($aa<=10){

					$echo = 'Max Level 10 is okay.';

					if($CurrentUser['ID'] and isset($LS[$aa])){ 
						$echo = 'Current User ID is okay.';
						$ROI = $LS[$aa]/365; 

						if($CurrentUser['StakingTeamLevel'] or 1){
							$echo = 'Staking Team level is okay.';

							$UID = '';
							$UID = $TID.':'.$aa;
							$Name = 'By:'.$Userr.', Level:'.$aa;

							$SQL2="INSERT INTO `Coinpods_staking2` (`id`, `name`, `created`, `modified`, `amount`, `user`, `ccc`, `roi`, `period`, `ttype`, `status`, `ist`, `price`, `usd`, `plan`, `uid`, `privacy`, `app`, `apr`) VALUES (NULL, '".$Name."', '".$Created."', current_timestamp(), '".$Amount."', '".$CurrentUser['ID']."', '".$CCC."', '".$ROI."', '".$Period."', '".$Type."', '1', '".IST()."', '".$Price."', '".$USDT."', '".$Plan."', '".$UID."', 'Public', '1', '".$LS[$aa]."')";
							$echo="SQL for Level $aa:<br> $SQL2<br>";


							global $DB; $Output = mysqli_query($DB, $SQL2);
							if($Output){

								$SID = mysqli_insert_id($DB);
								$echo="Staking ID Created: $SID<br>";

								//$SQL3="UPDATE `Coinpods_staking2` SET `uid` = '".$SID."' WHERE `id` = '".$SID."'";
								//global $DB; $Outputt = mysqli_query($DB, $SQL3);

								$SQL = "INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`) VALUES (NULL, 'Staking2 By: ".$CurrentUser['ID']." Level: ".$aa."', current_timestamp(), current_timestamp(), 'Staking2:".$CurrentUser['ID'].Clean(GMT())."', '".$CurrentUser['ID']."', '', '', '1', 'Staking2', '".$Amount."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '".$Wallets[strtolower($CCC)]."')";
								//global $DB; $Staked = mysqli_query($DB, $SQL);
								$echo="Transaction added for user: ".$CurrentUser['ID']."<br>";

							} 
							else{ $echo="Error: Failed to insert into Coinpods_staking2<br>"; }
						} 
						else{ $echo = 'Your staking team level is not enabled. Please complete your team business.';}
					}
					else{ $echo="Error: Upline User or ROI not found for Level ".$aa."<br>"; }
				}
				else{ $echo = 'Maximum 10 level allow.'.$aa; }
			}
		} 
		else{ $echo="Error: User or Uplines not found."; }
	} 
	else{ $echo="Error: Missing input data.<br>"; }

	return $Output;
}







/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function Staking2_Offer($Uid=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input :uid   
	// Output :data retrieval 
	if($Uid){

		$SQL="SELECT * FROM `".prefix."pods_staking2_offer` WHERE `uid`='".$Uid."'";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}

		return $ts[0];

	}
}


function Staking2_OfferStatus($UID=null,$Status=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input :uid  and status  
	// Output :change status only enable and disable


	if($UID and $Status){

		if($Status == 'enable'){$Status = 1;}
		elseif($Status == 'disable'){$Status = 0;} else{$Status ='';}

		$SQL="UPDATE `".prefix."pods_staking2_offer` SET `modified`= current_timestamp(), `status`='".$Status."' WHERE `uid`='".$UID."'";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		return $results;

	}
}





function Staking2_OfferNew($Q=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input :array  
	// Output :Insert new data


	if(is_array($Q)){$Name=$Q['name']; $User=$Q['user']; $Privacy=$Q['privacy']; $App=$Q['app']; $Maxamount=$Q['maxamount']; $Ttype=$Q['ttype']; $Minamount=$Q['minamount']; $Ccc=$Q['ccc']; $Status=$Q['status']; $Roi=$Q['roi']; $Period=$Q['period']; $Description=$Q['description']; }

	if($Name and $User and $Privacy and $App and $Maxamount and $Ttype and $Minamount and $Ccc and $Status and $Roi and $Period and $Description){
		if($Status == 'enable'){$StatusValue = 1 ;}
		elseif($Status == 'disable'){$StatusValue = 0; }

		$SQL="INSERT INTO `".prefix."pods_staking2_offer`(`id`, `name`, `created`, `modified`, `user`, `uid`, `privacy`, `app`, `maxamount`, `ttype`, `minamount`, `ccc`, `status`, `roi`, `period`, `description`) VALUES (NULL, '".$Name."', current_timestamp(), current_timestamp(), '".$User."', NULL, '".$Privacy."', '".$App."', '".$Maxamount."', '".$Ttype."', '".$Minamount."', '".$Ccc."', '".$StatusValue."', '".$Roi."', '".$Period."', '".$Description."')";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);

		if($results){

			$SQL1="UPDATE `".prefix."pods_staking2_offer` SET `uid`= `id` WHERE `uid` IS NULL";
			global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);

		}
		return $Output;
	}
	else{ $echo='All parametr required'; }
	//echo $echo;
}



function Staking2_OfferUpdate($Q=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input :array  
	// Output :Update data


	if(is_array($Q)){$Name=$Q['name']; $User=$Q['user']; $Privacy=$Q['privacy']; $App=$Q['app']; $Maxamount=$Q['maxamount']; $Ttype=$Q['ttype']; $Minamount=$Q['minamount']; $Ccc=$Q['ccc']; $Status=$Q['status']; $Roi=$Q['roi']; $Period=$Q['period'];
					 $Description=$Q['description']; $UID=$Q['uid']; }


	$modified=" SET `modified` = current_timestamp()";

	if($Name){$Name=", `name` = '".$Name."'";}
	if($User){$Uer=", `user` = '".$User."'";}
	if($Privacy){$Privacy=", `Privacy` = '".$Privacy."'";}
	if($App){$App=", `app` = '".$App."'";}
	if($Maxamount){$Maxamount=", `maxamount` = '".$Maxamount."'";}
	if($Ttype){$Ttype=", `ttype` = '".$Ttype."'";}
	if($Minamount){$Minamount=", `minamount` = '".$Minamount."'";}
	if($Ccc){$Ccc=", `ccc` = '".$Ccc."'";}
	if($Roi){$Roi=", `roi` = '".$Roi."'";}
	if($Period){$Period=", `period` = '".$Period."'";}
	if($Description){$Description=", `description` = '".$Description."'";}
	if($Status == 'enable'){$Statusvalue = ", `status`='1'";}
	elseif($Status=='disable'){$Statusvalue = ", `status`='0'";}

	$SET=$modified.$Name.$User.$Privacy.$App.$Maxamount.$Ttype.$Minamount.$Ccc.$Roi.$Period.$Description.$Statusvalue;

	$SQL ="UPDATE `".prefix."pods_staking2_offer` ".$SET." WHERE `".prefix."pods_staking2_offer`.`uid` = '".$UID."'";
	global $DB; $users = mysqli_query($DB, $SQL); 
	if(mysqli_num_rows($users) > 0){ while($user = mysqli_fetch_assoc($users)){ $ts[$aa] = $user; $aa++;}} 
	else{$ts = null;}	

	$s=1;$logs=$SQlL;
	return array('s'=>$s,'logs'=>$logs);  
}


function Staking2_Offers($Q=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input :array  
	// Output :Search function

	if(is_array($Q)){

		$Sort = $Q['Sort'];
		$Id=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Name=isset($Q['name'])?" AND `name` = '".$Q['name']."'" : '';
		$User=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$Uid=isset($Q['uid'])?" AND `uid` = '".$Q['uid']."'" : '';
		$Privacy=isset($Q['privacy'])?" AND `privacy` = '".$Q['privacy']."'" : '';
		$App=isset($Q['app'])?" AND `app` = '".$Q['app']."'" : '';
		$Maxamount=isset($Q['maxamount'])?" AND `maxamount` = '".$Q['maxamount']."'" : '';
		$Ttype=isset($Q['ttype'])?" AND `ttype` = '".$Q['ttype']."'" : '';
		$Minamount=isset($Q['minamount'])?" AND `minamount` = '".$Q['minamount']."'" : '';
		$Ccc=isset($Q['ccc'])?" AND `ccc` = '".$Q['ccc']."'" : '';
		$Roi=isset($Q['roi'])?" AND `roi` = '".$Q['roi']."'" : '';
		$Period=isset($Q['period'])?" AND `period` = '".$Q['period']."'" : '';
		$Description=isset($Q['description'])?" AND `description` = '".$Q['description']."'" : '';
		$StatusCondition = isset($Q['status']) ? ($Q['status'] == 'enable' ? ' AND `status` = 1' : ($Q['status'] == 'disable' ? ' AND `status` = 0' : '')) : '';

		if($Sort == 'id'){ $Sortt = 'id'; }
		elseif($Sort == 'name'){ $Sortt = 'name'; }
		elseif($Sort == 'user'){ $Sortt = 'user'; }
		elseif($Sort == 'uid'){ $Sortt = 'uid'; }
		elseif($Sort == 'privacy'){ $Sortt = 'privacy'; }
		elseif($Sort == 'app'){ $Sortt = 'app'; }
		elseif($Sort == 'maxamount'){ $Sortt = 'maxamount'; }
		elseif($Sort == 'ccc'){ $Sortt = 'ccc'; }
		elseif($Sort == 'roi'){ $Sortt = 'roi'; }
		elseif($Sort == 'period'){ $Sortt = 'period'; }
		elseif($Sort == 'description'){ $Sortt = 'description'; }
		elseif($Sort == 'status'){ $Sortt = 'status'; }

		else{$Sortt='id';}
		$SortBy = strtoupper($Q['sortby']); if(!$SortBy){ $SortBy='ASC'; }

	}
	$WhereClause="1".$Id.$Name.$Uid.$User.$Privacy.$App.$Maxamount.$Ttype.$Minamount.$Ccc.$Roi.$Period.$Description.$StatusCondition; 

	$Limit=isset($Q['LIMIT'])? $Q['LIMIT'] : ''; 
	if(!$Limit){ $Limit = 10; }

	$Offset=isset($Q['OFFSET'])? $Q['OFFSET'] : 0;

	$SQL = "SELECT * FROM `".prefix."pods_staking2_offer` WHERE ".$WhereClause." ORDER BY `".$Sortt."` $SortBy  LIMIT ".$Limit." OFFSET ".$Offset; //echo  $SQL;
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); 
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;} 

	return $ts; 

}







function Staking2_IncomeToWallet($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-05-02
	// Input :
	// Output : Add Balance to Wallet from Transaction(Staking)

	$echo = 'Staking2_Income To Wallet Start.';
	$Output=0;	
	$Staking_Incomes=Staking2_Incomes(['status'=>1, 'balance'=>'false', 'LIMIT'=>500000]);	
	if($Staking_Incomes){ 
		$echo = 'Staking2 Income Pending Users Found.';

		foreach($Staking_Incomes as $Ps){
			$echo = 'Forech Good Working.';

			$Staking_Wallets = Staking_Wallets($Ps['user'])[$Ps['ccc']];

			$BeforeBalance = $Staking_Wallets;
			$AfterBalance = $BeforeBalance+$Ps['amount'];


			if(AddToStaking_Wallet(array( 'user'=>$Ps['user'], 'ccc'=>strtolower($Ps['ccc']), 'amount'=>$Ps['amount'] ))){

				$Before_AfterArray = ['beforebalance'=>$BeforeBalance,'afterbalance'=>$AfterBalance,'id'=>$Ps['tid']];
				Before_After_BalanceUpdate($Before_AfterArray);

				Staking2_IncomeUpdate(array('uid'=>$Ps['uid'], 'balance'=>1));
				$Output=1; $echo = 'Amount Add To Staking Wallet Success.';
			}
			else{ 
				Staking2_IncomeUpdate(array('uid'=>$Ps['uid'], 'balance'=>2));
				$echo = 'Internal Error.';
			}
		}
	}
	else{ $echo = 'Pending Users Not Found.'; }
	return $Output;
}



function PendingStaking2Transactions($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-05-02
	// Input :
	// Output : Pending Transaction Staking Income

	if($Q){ $SQL="SELECT * FROM `".prefix."pods_staking2_income` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'StakingIncome'"; }
	else{ $SQL="SELECT * FROM `".prefix."pods_staking2_income` WHERE `balance` = 0 AND `ttype` = 'StakingIncome'"; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;	

}






function Staking2_Income($Uid=NULL){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input : Uid 
	// Output : Singal transaction select karta hai.

	if($Uid){

		$SQL="SELECT * FROM `".prefix."pods_staking2_income` WHERE `uid`='".$Uid."'"; ;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}

		return $ts[0]; 

	}
}


function Staking2_IncomeNew($Q=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input : array  
	// Output :insert  New data

	$Output=$results=0; 
	$echo = 'Staking2_IncomeNew() : Started.'; d($echo);
	if(is_array($Q)){ $Name=$Q['name']; $User=$Q['user']; $Ttype=$Q['ttype']; $Amount=$Q['amount']; $Status=$Q['status']; $UID=$Q['uid']; $Balance=$Q['balance'];$Tid=$Q['tid']; }
	if($Name and $User and $Ttype and $Amount and $Status and $Tid){
		$echo = 'Staking2_IncomeNew() : All Peramiters Found Continue...'; d($echo);
		if(!empty($Balance)){ $BalanceStatus=$Balance; }
		else{ $Balance=0; }

		$echo = 'Staking2_IncomeNew() : SQL Started.'; d($echo);
		$SQL="INSERT INTO `".prefix."pods_staking2_income`(`id`, `name`, `created`, `modified`, `user`,  `privacy`, `app`, `ttype`, `amount`, `ccc`, `status`, `balance`, `processing`, `tid`, `uid`) VALUES ('NULL', 'Staking2 Income:".$Name.":".GMT()."', '".GMT()."', '".GMT()."', '".$User."', 'Public', '1', '".$Ttype."', '".$Amount."', 'usdt', '".$Status."', '".$Balance."', '' , '".$Tid."', '".$UID."' )";
		$echo = 'Staking2_IncomeNew() : SQL Found.'; d($echo);
		//echo $SQL;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		$IID = mysqli_insert_id($DB);
		if($results){
			$echo = 'Staking2_IncomeNew() : Insert Success.'; d($echo);

			$echo = 'Staking2_IncomeNew() : UID SQL Started.'; d($echo);
			///$SQL1="UPDATE `".prefix."pods_staking2_income` SET `uid`='".$IID."' WHERE `id`='".$IID."'" ;
			$echo = 'Staking2_IncomeNew() : UID SQL Found.'; d($echo);

			//global $DB;$aa = 0;	$Output = mysqli_query($DB, $SQL1);
			//$echo = 'Staking2_IncomeNew() : UID Update Success.'; d($echo);

		}
	}
	$echo = 'Staking2_IncomeNew() : Ended.'; d($echo);
	return $results;
}




function Staking2_IncomeStatus($UID=null, $Status=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input : uid
	// Output :Change status 


	if($UID and $Status){ 

		if($Status == 'enable'){ $StatusValue = 1; }
		elseif($Status == 'disable'){ $StatusValue = 0; } else{$Status ='';}

		$SQL="UPDATE `".prefix."pods_staking2_income` SET `modified`= current_timestamp(),`status`='".$StatusValue."'WHERE `uid`='".$UID."'"; 
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);

		return $results; 

	}
}



function Staking2_IncomeUpdate($Q=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input : array
	// Output :Update data 

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

	//if($Status == 'enable'){$Statusvalue = ", `status`='1'";}
	//elseif($Status=='disable'){$Statusvalue = ", `status`='0'";}  

	$SET=$ID.$Modified.$Name.$User.$Privacy.$App.$Ttype.$Amount.$CCC.$Balance.$Processing.$Status; 

	$SQL ="UPDATE `".prefix."pods_staking2_income` ".$SET." WHERE `".prefix."pods_staking2_income`.`uid` = '".$UID."'";  
	$users = mysqli_query($DB, $SQL); 

	$s=1;
	$logs=$SQLl;
	return array('s'=>$s,'logs'=>$logs);  
}





function Staking2_Incomes($Q=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/15
	// Input : array
	// Output :Search all data 

	if(is_array($Q)){

		$Sort = $Q['Sort'];
		$Id=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Uid=isset($Q['uid'])?" AND `uid` = '".$Q['uid']."'" : '';
		$Name=isset($Q['name'])?" AND `name` = '".$Q['name']."'" : '';
		$Created=isset($Q['created'])?" AND `created` LIKE '%".$Q['created']."%'" : '';
		$Usre=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$Privacy=isset($Q['privacy'])?" AND `privacy` = '".$Q['privacy']."'" : '';
		$App=isset($Q['app'])?" AND `app` = '".$Q['app']."'" : '';
		$Ttype=isset($Q['ttype'])?" AND `ttype` = '".$Q['ttype']."'" : '';
		$Amount=isset($Q['amount'])?" AND `amount` = '".$Q['amount']."'" : '';
		$CCC=isset($Q['ccc'])?" AND `ccc` LIKE '".$Q['ccc']."%'" : '';
		$Processing=isset($Q['processing'])?" AND `processing` = '".$Q['processing']."'" : '';
		if(isset($Q['status']) && $Q['status'] !== ''){
			if(strtolower($Q['status']) == 'false'){  $Status = " AND `status` = '0'"; }
			else{  $Status = " AND `status` = '".$Q['status']."'"; } 
		}
		if(strtolower($Q['balance']) == 'false'){ $Balance = " AND `balance` = '0'"; }
		else{ if($Q['balance']){ $Balance = " AND `balance` = '".$Q['balance']."'"; }}

		$Created_Min = $Q['created_min']; $Created_Max = $Q['created_max'];
		if($Created_Min and $Created_Max){ $Created=" AND `created` BETWEEN '".$Created_Min."' AND '".$Created_Max." 23:59:59'"; }


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
		$SortBy = strtoupper($Q['sortby']); if(!$SortBy){ $SortBy='DESC'; }

	}

	$WhereClause="`id`!=0".$Id.$Uid.$Name.$Usre.$Privacy.$App.$Ttype.$Amount.$CCC.$Balance.$Processing.$Status.$Created;

	$Limit=isset($Q['LIMIT'])? $Q['LIMIT'] : ''; 
	if(!$Limit){ $Limit = 10; }


	$Offset=isset($Q['OFFSET'])? $Q['OFFSET'] : 0;

	$MethodColumn=strtolower($Q['methodcolumn']);
	if($MethodColumn){ $MC='(`'.$MethodColumn.'`)'; } 
	else{ $MC=''; }

	$Method = strtoupper($Q['method']);
	if(!$Method){ $Method='*'; }
	$MM=$Method.$MC;

	$SQL = "SELECT ".$MM." FROM `".prefix."pods_staking2_income` WHERE ".$WhereClause." ORDER BY `".$Sortt."` $SortBy  LIMIT ".$Limit." OFFSET ".$Offset;
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); //echo $SQL;  
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;} 

	if($MC){ $return=$ts[0][$Method.$MC]; }else{ $return=$ts;}
	return $return;   

}




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Staking Feature Start //





function Staking2ToTransaction($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-05-01
	// Input : Array
	// Output : INSERT
	$Return = []; $Output=0; $Output1=0; $Output2=$Eligible_Amount=$Laps_Amount=0;$Capping_ABCD=null;
	$User_Object = new User();
	$Object = new Subordinate();
	$echo = 'Staking2ToTransaction() Started.'; d($echo);
	$BeforeBalance=$AfterBalance=$Staking_Wallets=0;

	$echo = 'Staking2ToTransaction() : Staking To Transaction Start.'; d($echo);
	if($Q){
		$echo = 'Staking2ToTransaction() : ID No Processing : '.$Q['id']; d($echo);

		if($Q['staking']){
			$echo = 'Staking2ToTransaction() : Staking Found.'; d($echo);

			//$echo = 'Staking2ToTransaction() : #Try To Run Function : user().'; d($echo);
			//$User=user($Q['user']);
			//$echo = 'Staking2ToTransaction() : *Try To Run Function : user().'; d($echo);

			$Capping_ABCD=$Object->Capping_ABCD(['user'=>$Q['user'], 'amount'=>d2p($Q['staking'])]);
			$Eligible_Amount = $Capping_ABCD['o']['eligible_amount']; //print_r($Capping_ABCD);
			$Laps_Amount = $Capping_ABCD['o']['laps_amount'];
			//print_r($Capping_ABCD);echo '<br><br>';

			if(!empty($Eligible_Amount)){
				
				
								
				if(!empty($Eligible_Amount) && !empty($Laps_Amount)){ 
					$S2UIID='Staking2_ID:'.$Q['id'].':'.gmdate('Ymd').':'.p2d($Eligible_Amount); 
					$S2IUID='Staking2_ID:'.$Q['id'].':'.gmdate('Ymd').':'.p2d($Eligible_Amount);
				}
				else{
					$S2UIID='Staking2_ID:'.$Q['id'].':'.gmdate('Ymd'); 
					$S2IUID='Staking2_ID:'.$Q['id'].':'.gmdate('Ymd');
				}


				$echo = 'Staking2ToTransaction() : #Try To Run Function : Staking_Wallets().'; d($echo);
				$Staking_Wallets=Staking_Wallets($Q['user'])['usdt'];
				$echo = 'Staking2ToTransaction() : *Try To Run Function : Staking_Wallets().'; d($echo);

				$BeforeBalance=$Staking_Wallets;
				$echo = 'Staking2ToTransaction() : $BeforeBalance Found Continue...'; d($echo);

				$AfterBalance=$BeforeBalance+p2d($Eligible_Amount);
				$echo = 'Staking2ToTransaction() : $AfterBalance Found Continue...'; 
				
				
				$echo = 'Jaspal Work Started'; d($echo);
				$Balance = $Status = $TodayTotalStaking2 = $CapingNow = $UserData = null;
				//$TodayTotalStaking2 = TodayTotalStaking2($Q['user']);
				//$CapingNow = p2d(CapingNow(['user'=>$Q['user']]));
				
				$UserData=user($Q['user']);
				$TodayTotalStaking2 = $UserData['today_total_teamstaking_sum'];
				$CapingNow = $UserData['today_capping'];
				 
				if($TodayTotalStaking2>$CapingNow and $CapingNow <= 15000000000){$Balance=$Status=6;}else{$Status=$Balance=1;}
				
 
				
				$echo = 'Jaspal Work Ended '; d($echo);

				$SQL="INSERT INTO `".prefix."pods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`) VALUES (NULL, 'Staking2 Income:".$Q['id'].":".GMT()."', '".GMT()."', '".GMT()."', '".$S2UIID."', '".$Q['user']."', '', '', '".$Balance."', 'Staking2Income', '".p2d($Eligible_Amount)."', 'usdt', '".$Status."', '', '');";
				$echo = 'Staking2ToTransaction() : SQL Found.'; d($echo);
				global $DB;	$Output1 = mysqli_query($DB, $SQL);
				$InsertID = mysqli_insert_id($DB);

				//echo 'Insert ID : '.$InsertID;echo "<br><br>";


				if($Output1 and $InsertID){ 
					$echo = 'Staking2ToTransaction() : Coinpods Transaction Output Found.'; d($echo);

					//$SQL2="UPDATE `".prefix."pods_staking2` SET `totalstaking` = `totalstaking` + `staking`, `staking` = 0 WHERE `".prefix."pods_staking2`.`id` = '".$Q['id']."';"; 
					//global $DB;	$Output = mysqli_query($DB, $SQL2);
					if($Output or 1){
						$echo = 'Staking2ToTransaction() : Coinpods Staking Output Found Continue...'; d($echo);
						
						if($TodayTotalStaking2>$CapingNow and $CapingNow <= 15000000000){$Balance=$Status=6;}else{$Status=1;$Balance=0;}
 
						$Array = array( 'name'=>$Q['id'], 
									   'user'=>$Q['user'], 
									   'ttype'=>'Staking2Income', 
									   'amount'=>p2d($Eligible_Amount), 
									   'ccc'=>strtolower($Q['ccc']),
									   'status'=>$Status, 
									   'balance'=>$Balance, 
									   'tid'=>$InsertID, 
									   'uid'=>$S2IUID, 
									  );

						$echo = 'Staking2ToTransaction() : Staking2_IncomeNew() Array Data Found Continue...'; d($echo);

						$echo = 'Staking2ToTransaction() : #Try To Run Function : Staking2_IncomeNew().'; d($echo);
						$Staking_IncomeNew = Staking2_IncomeNew($Array); unset($Array);
						$echo = 'Staking2ToTransaction() : *Try To Run Function : Staking2_IncomeNew().'; d($echo);

						if($Staking_IncomeNew){
							$echo = 'Staking2_IncomeNew() Output Found Continue...'; d($echo);

							$Interval=Interval(gmdate('Y-m-d'));  //print_r($Interval);
							$echo = '*Try To Run Function : Interval().'; d($echo);
							if($Interval){ 
								$echo = 'Interval Function Data Found.'; d($echo);

								$echo = 'Team Staking Income UID Array Created Started.'; d($echo);
								$UID_Encode = ['app'=>App['id'], 'user'=>$Q['user'], 'interval'=>$Interval['day_this']['uid'], 'method'=>'SUM', 'key'=>'TeamStaking_Income', 'relation'=>'Self', 'pair'=>'USDT_USDT', 'table'=>'user_meta'];
								$echo = 'Team Staking Income UID Array Created.'; d($echo);

								$echo = '#Try To Run Function 1 : UID_Encode().'; d($echo);
								$UID = UID_Encode($UID_Encode)['uid']; unset($UID_Encode);
								$echo = '*Try To Run Function 1 : UID_Encode().'; d($echo);

								$echo = '#Try To Run Function : User_Meta().'; d($echo);
								$User_Meta_TeamStaking_Income = $User_Object->User_Meta($UID)['o'];
								$echo = '*Try To Run Function : User_Meta().'; d($echo);

								$TeamStaking_Income=$User_Meta_TeamStaking_Income['value']+p2d($Eligible_Amount);

								unset($Array);
								$Array = [
									'name'      => 'Team Staking Income',
									'created'   => GMT(),
									'modified'  => GMT(),
									'uid'       => $UID,
									'user'      => $Q['user'],
									'status'    => 1,
									'privacy'   => 'Private',
									'app'       => App['id'],
									'show'      => 1,
									'key'       => 'TeamStaking_Income',
									'value'     => $TeamStaking_Income,
									'interval'  => $Interval['day_this']['uid'],
									'pair'      => 'USDT_USDT',
									'method'    => 'SUM',
									'relation'  => 'Self',
									'uidd'      => '',
									'feature'   => 'TeamStaking_Income'
								];

								$User_MetaUpdateNew=$User_Object->User_MetaUpdateNew($Array); unset($Array);
								//print_r($User_MetaUpdateNew); echo '<br><br>';

							}
							else{ $echo = 'Interval Function Data Not Found.'; d($echo); }
						}
						else{ $echo = 'Staking2ToTransaction() : Staking_Income New Output Not Found.'; d($echo); }
					}
					else{ $echo = 'Staking2ToTransaction() : Coinpods Staking Output Not Found.'; d($echo); }
				}
				else{ $echo = 'Staking2ToTransaction() : Coinpods Transaction Output Not Found.'; d($echo); }
			}
			if(!empty($Laps_Amount)){
				
				if(!empty($Eligible_Amount) && !empty($Laps_Amount)){ 
					$S2UIID='Staking2_ID:'.$Q['id'].':'.gmdate('Ymd').':'.p2d($Laps_Amount); 
					$S2IUID='Staking2_ID:'.$Q['id'].':'.gmdate('Ymd').':'.p2d($Laps_Amount);
				}
				else{
					$S2UIID='Staking2_ID:'.$Q['id'].':'.gmdate('Ymd'); 
					$S2IUID='Staking2_ID:'.$Q['id'].':'.gmdate('Ymd');
				}

			
				
				$SQL="INSERT INTO `".prefix."pods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`) VALUES (NULL, 'Staking2 Income:".$Q['id'].":".GMT()."', '".GMT()."', '".GMT()."', '".$S2UIID."', '".$Q['user']."', '', '', '6', 'Staking2Income', '".p2d($Laps_Amount)."', 'usdt', '6', '', '');";
				$echo = 'Staking2ToTransaction() : SQL Found.'; d($echo);
				global $DB;	$Output2 = mysqli_query($DB, $SQL);
				$InsertID = mysqli_insert_id($DB);
				if($Output2 and $InsertID){ 
					$echo = 'Staking2ToTransaction() : Coinpods Transaction Output Found.'; d($echo);

					//$SQL2="UPDATE `".prefix."pods_staking2` SET `totalstaking` = `totalstaking` + `staking`, `staking` = 0 WHERE `".prefix."pods_staking2`.`id` = '".$Q['id']."';"; 
					//global $DB;	$Output = mysqli_query($DB, $SQL2);
					if($Output or 1){
						$echo = 'Staking2ToTransaction() : Coinpods Staking Output Found Continue...'; d($echo);
					

						$Array = array( 'name'=>$Q['id'], 
									   'user'=>$Q['user'], 
									   'ttype'=>'Staking2Income', 
									   'amount'=>p2d($Laps_Amount), 
									   'ccc'=>strtolower($Q['ccc']), 
									   'status'=>6, 
									   'balance'=>6, 
									   'tid'=>$InsertID, 
									   'uid'=>$S2IUID, 
									  );
						$echo = 'Staking2ToTransaction() : Staking2_IncomeNew() Array Data Found Continue...'; d($echo);

						$echo = 'Staking2ToTransaction() : #Try To Run Function : Staking2_IncomeNew().'; d($echo);
						$Staking_IncomeNew = Staking2_IncomeNew($Array); unset($Array);
						$echo = 'Staking2ToTransaction() : *Try To Run Function : Staking2_IncomeNew().'; d($echo);

					}
					else{ $echo = 'Staking2ToTransaction() : Coinpods Staking Output Not Found.'; d($echo); }
				}
				else{ $echo = 'Staking2ToTransaction() : Coinpods Transaction Output Not Found.'; d($echo); }
			}


			$echo = 'Staking2ToTransaction() : # staking2 Table `totalstaking` = `totalstaking` + `staking` Ended.'; d($echo);
			if($Output1 || $Output2){

				$SQL2="UPDATE `".prefix."pods_staking2` SET `totalstaking` = `totalstaking` + `staking`, `staking` = 0 WHERE `".prefix."pods_staking2`.`id` = '".$Q['id']."';";
				global $DB; $Output = mysqli_query($DB, $SQL2);
				if($Output){
					$echo = 'pods_staking2 Updated Successfully.'; d($echo);
				}
			}
			$echo = 'Staking2ToTransaction() : #* staking2 Table `totalstaking` = `totalstaking` + `staking` Ended.'; d($echo);


		}
		else{ $echo = 'Staking2ToTransaction() : Staking Not Found.'; d($echo); }
	}
	else{ $echo = 'Staking2ToTransaction() : Q Data Not Found.'; d($echo); }
	//$echo = 'Staking2ToTransaction() : Staking2ToTransaction() Ended.'; d($echo);

	$Return = [ 'o'=>$Output,'c'=>$echo ];
	return $Return;
} 	




function Staking2ToTransactions(){
	// Developer : Pawan Kumar
	// Date : 2024-05-01
	// Input : 
	// Output : Staking To Transaction And Staking_Income

	$Dispatche=0;
	$echo = 'Staking2ToTransactions() Started.'; d($echo); 

	//$echo = 'Staking2ToTransactions() Runing Started.'; d($echo); 
	//$Stakings = Spot_Stakings2(['status'=>1,'staking'=>1, 'sort'=>'id', 'sortby'=>'desc', 'limit'=>'100000'],['id','user','status','staking','ccc']);
	//$echo = 'Staking2ToTransactions() Runing Ended.'; d($echo); 

	$echo = 'UserStakings2() Runing Started.'; d($echo); 
	$Stakings=UserStakings2();
	$echo = 'UserStakings2() Runing Ended.'; d($echo); 

	if($Stakings){
		$echo = 'Staking2ToTransactions() Data Found.'; d($echo); 
		$echo = 'Staking2ToTransactions() Total Processing : '.count($Stakings); d($echo); 
		$Return = [];

		foreach($Stakings as $Staking){
			$echo = 'Staking2ToTransactions() Data Foreach.'; d($echo); 

			$echo = '#Try To Run Function : Staking2ToTransaction() Started.'; d($echo); 
			$Staking2ToTransaction = Staking2ToTransaction($Staking);
			$echo = '#*Try To Run Function : Staking2ToTransaction() Ended.'; d($echo);
			$Return[$Staking['id']] = $Staking2ToTransaction;

			if($Dispatche==1){
				//$Array=['feature'=>'TeamStaking_Income','pair'=>'USDT_USDT','user'=>$Staking['user'],'amount'=>$Staking['staking'],];
				//HistoryUpdateNew($Array);

			}
		}	
	}
	$echo = 'Staking2ToTransactions() Ended.'; d($echo); 
	return $Return;
}







function Staking2($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-17
	// Input : Array
	// Output : Need Complete data of a single Stake.	

	if($Q and is_array($Q)){
		if($Q['status']==1){
			$Staking=$Q['amount']*$Q['roi']/100;
			$Amount = $Staking*$Q['price'];

			$SQL="UPDATE `".prefix."pods_staking2` SET `staking` = `staking` + ".$Amount.", `updated` = current_timestamp()  WHERE `Coinpods_staking2`.`id` = '".$Q['id']."';"; 
			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
			return true;

		}
	}
}




function StakesToStaking2(){
	// Developer : Pawan Kumar
	// Date : 2024-04-17
	// Input : Array
	// Output : Staking ko Genarate

	$ab=0;
	$StakesToStaking=[];
	$Stakes=Spot_Stakings2(['status'=>1, 'limit'=>'All']);
	//$Stakes=Spot_Stakings2(['status'=>1, 'limit'=>'All','created'=>'2026-05-10']);
	//$Stakes=Spot_Stakings2(['status'=>1, 'created_min'=>'2024-12-03', 'created_max'=>'2025-07-12','limit'=>'All','offset'=>0]);
	//$Stakes=UserStakings2();
	// Ye Function Coinusers and staking2 table ko JOIN Kar ke  Data SELECT Karta Hai



	if($Stakes){
		foreach($Stakes as $Stake){	
			//$ab++;
			//echo '<br>Processing : ID-'.$Stake['id'];
			if(Staking2($Stake)){ $ab++; }		
		}	
	}
	return $ab;	
}






function Stakes2($Q=null){

	if($Q){ $SQL="SELECT * FROM `".prefix."pods_staking2` WHERE `user` = '".$Q."'"; }
	else{ $SQL="SELECT * FROM `".prefix."pods_staking2` ORDER BY `".prefix."pods_staking2`.`id` DESC"; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		

}










function Spot_Staking2Status($Uid=null, $Status=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/13
	// Input : uid and status enable and disable
	// Output : Change status.



	if($Uid and $Status){
		if($Status == 'enable'){$StatusValue = 1;}
		if($Status == 'disable'){$StatusValue = 0;} else{$Status= '';}

		$SQL="UPDATE `".prefix."pods_staking2` SET `modified`=current_timestamp(),`status`='".$StatusValue."' WHERE `uid`='".$Uid."'";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL); 
		return $results;

	}
}


function Staking2New($Q=null){
	// Developer : Pawan kumar
	// Date : 2024-04-17
	// Input : Amount, CCC
	// Output : Array Data By New Staking Created.

	$echo = 'Staking New Start.';
	$Output=0;
	$BeforeBalance=$AfterBalance=0;
	if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $PlanID=$Q['planid']; $UserID=i['id']; }
	else{ $echo = 'Q data not found.'; }


	//$Spot_wallets = Spot_wallets(array('user'=>i['id'], 'ccc'=>$CCC));
	//$Wallets = $Spot_wallets[0];

	$Wallets = Wallets(i['id']);
	$echo = 'Spot_wallets data found.';

	if($UserID and $Amount and $CCC and $PlanID){
		$echo = 'Userid and amount and ccc our planid found.';

		if($Wallets[$CCC]>=p2d($Amount)){
			$echo = 'The amount in the wallet is fine, go ahead.';

			$BeforeBalance=$Wallets[$CCC];
			$AfterBalance=$BeforeBalance-p2d($Amount);	

			$Plans=Staking_Plans(['id'=>$PlanID, 'minamount'=>$Amount, 'ccc'=>$CCC, 'maxamount'=>$Amount, 'status'=>1]);
			$Plan=$Plans[0];
			if($Plan){
				$echo = 'Staking_Plans data found.';

				$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`) VALUES (NULL, 'Staking:".$UserID.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Staking:".$UserID.Clean(GMT())."', '".$UserID."', '', '', '1', 'Staking', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '".$AfterBalance."');";
				$echo = 'Coinpods_transaction SQL found.'; 
				global $DB;$aa = 0; $Staked = mysqli_query($DB, $SQL);

				$Wallets = Wallets(i['id']);
				$echo = 'Obtained by subtracting the amount in spot_wallet data.';

				$Walletss=$Wallets[strtolower($CCC)];
				$Walletss=$Walletss-p2d($Amount);
				$echo = 'Amount has been subtracted from Spot_wallet no problem.';

				if($Staked){ 
					$echo = 'The entry into the coinpods_transaction table has been successfully made.';

					$SQL1="UPDATE `Coinpods_wallet` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_wallet`.`user` = '".$UserID."';";
					unset($Walletss);
					$echo = 'Earn_Wallet SQL found.';
					global $DB;$aa = 0; $Walleted = mysqli_query($DB, $SQL1);

				}
				if($Walleted){
					$echo = 'Success SMS from Wallet has arrived, go ahead.';

					$Price=Price(); 
					$USDT=$Amount*$Price;

					$SQL2="INSERT INTO `Coinpods_staking2`(`id`, `name`, `created`, `modified`, `amount`, `user`, `ccc`, `roi`, `period`, `ttype`, `status`, `ist`, `price`, `usd`, `plan`, `uid`, `privacy`, `app`, `apr`) VALUES (NULL, '".i['id']."', current_timestamp(), current_timestamp(), '".p2d($Amount)."', '".i['id']."', '".$CCC."', '".$Plan['roi']."', '".$Plan['period']."', '".$Plan['ttype']."', '1', '".IST()."', '".$Price."', '".p2d($USDT)."', '".$Plan['id']."', 'NULL', 'Public', '1', '".$Plan['apr']."')";
					$echo = 'Coinpods_staking SQL found.';
					global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL2);
					$SID=mysqli_insert_id($DB);

					if($SID){
						$echo = 'Insert Id Found of Coinpods_Staking.';	

						//	$Input = ['feature'=>'TeamStaking','amount'=>p2d($USDT),'pair'=>'USDT_USDT','user'=>i['id']];
						//	LiveData___Feature_Meta($Input);				

						//	$Input = ['feature'=>'TeamStaking','amount'=>p2d($Amount),'pair'=>'CCC_CCC','user'=>i['id']];
						//	LiveData___Feature_Meta($Input);				

						$SQL3="UPDATE `Coinpods_staking2` SET `uid`='".$SID."' WHERE `id` = '".$SID."'";
						global $DB; $aa = 0; $Outputt = mysqli_query($DB, $SQL3);
						$echo = 'uid update success.';

					}
					else{ $echo = 'Insert ID of Coinpods_Staking not found.'; }
				}
				else{ $echo = 'No response received from Spot_wallet.'; }
			}
			else{ $echo = 'Stalking plan not found.'; }
		}
		else{ $echo = 'The amount in the wallet is not complete.'; }
	}
	else{ $echo = 'Not enough sources.'; }
	return $SID;

}


function Spot_Staking2Update($Q=null){
	// Developer : Yogesh kumar
	// Date : 2024/04/13
	// Input : Array 
	// Output : Update data.


	if(is_array($Q)){$Saking=$Q['staking'];$Updated=$Q['updated']; $Name=$Q['name']; $Amount=$Q['amount']; $User=$Q['user']; $Ccc=$Q['ccc']; $Roi=$Q['roi']; $Period=$Q['period']; $Ttype=$Q['ttype']; $Status=$Q['status']; $Totalstaking=$Q['totalstaking']; $Ist=$Q['ist']; $Price=$Q['price']; $Usd=$Q['usd']; $Unstaking=$Q['unstaking']; $Plan=$Q['plan']; $Offer=$Q['offer']; $Privacy=$Q['privacy']; $App=$Q['app'];$UID=$Q['uid'];}

	$Modified=" SET `modified` = current_timestamp()";
	if($Saking){$Saking=", `saking` = '".$Saking."'";}
	if($Updated){$Updated=", `updated` = '".$Updated."'";}
	if($Name){$Name=", `name` = '".$Name."'";}
	if($Amount){$Amount=", `amount` = '".$Amount."'";}
	if($User){$User=", `user` = '".$User."'";}
	if($Ccc){$Ccc=", `ccc` = '".$Ccc."'";}
	if($Roi){$Roi=", `roi` = '".$Roi."'";}
	if($Period){$Period=", `period` = '".$Period."'";}
	if($Ttype){$Ttype=", `ttype` = '".$Ttype."'";}
	if($Totalstaking){$Totalstaking=", `totalstaking` = '".$Totalstaking."'";}
	if($Ist){$Ist=", `ist` = '".$Ist."'";}
	if($Price){$Price=", `price` = '".$Price."'";}
	if($Usd){$Usd=", `usd` = '".$Usd."'";}
	if($Unstaking){$Unstaking=", `unstaking` = '".$Unstaking."'";}
	if($Plan){$Plan=", `plan` = '".$Plan."'";}
	if($Offer){$Offer=", `offer` = '".$Offer."'";}
	if($Privacy){$Privacy=", `privacy` = '".$Privacy."'";}
	if($App){$App=", `app` = '".$App."'";}

	if($Status=='enable'){$StatusValue = ", `status`='1'";}
	elseif($Status=='disable'){$StatusValue = ", `status`='0'";}

	$SET=$Modified.$Saking.$Updated.$Name.$Amount.$User.$Ccc.$Roi.$Period.$Ttype.$Totalstaking.$Ist.$Price.$Usd.$Unstaking.$Plan.$Offer.$Privacy.$App.$StatusValue;

	$SQL ="UPDATE `".prefix."pods_staking2` ".$SET." WHERE `".prefix."pods_staking2`.`uid` = '".$UID."';"; 
	global $DB;$users = mysqli_query($DB, $SQL);   


	if($users){$s=1;$logs=$SQL;}else{$s=0;$logs=$SQL;}
	return array('s'=>$s,'logs'=>$logs);  
}







function Spot_Stakings2($Q=null,$Select=[]){
	// Developer : Pawan Kumar
	// Date : 2024-04-14
	// Input : Array
	// Output : Gives the details of the data from which the array comes.

	if(is_array($Q)){

		$ID=!empty($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Updated=!empty($Q['updated'])?" AND `updated` LIKE '%".$Q['updated']."%'" : '';
		$Name=!empty($Q['name'])?" AND `name` LIKE '%".strtolower($Q['name'])."%'" : '';
		$Created=!empty($Q['created'])?" AND `created` >= '".$Q['created']."'" : '';
		$Modified=!empty($Q['modified'])?" AND `modified` >= '".$Q['modified']."'" : '';
		$Amount=!empty($Q['amount'])?" AND `amount` >= '".p2d($Q['amount'])."'" : '';
		$Staking=!empty($Q['staking'])?" AND `staking` >= '".$Q['staking']."'" : '';
		$User=!empty($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$CCC=!empty($Q['ccc'])?" AND `ccc` LIKE '".strtolower($Q['ccc'])."'" : '';
		$Roi=!empty($Q['roi'])?" AND `roi` = '".$Q['roi']."'" : '';
		$Period=!empty($Q['period'])?" AND `period` = '".$Q['period']."'" : '';
		$Ttype=!empty($Q['ttype'])?" AND `ttype` = '".$Q['ttype']."'" : '';
		$TotalStaking=!empty($Q['totalstaking'])?" AND `totalstaking` >= '".p2d($Q['totalstaking'])."'" : '';
		$IST=!empty($Q['ist'])?" AND `ist` >= '".$Q['ist']."'" : '';
		$Price=!empty($Q['price'])?" AND `price` = '".$Q['price']."'" : '';
		$USD=!empty($Q['usd'])?" AND `usd` = '".p2d($Q['usd'])."'" : '';
		$UnStaking=!empty($Q['unstaking'])?" AND `unstaking` = '".$Q['unstaking']."'" : '';
		$Plan=!empty($Q['plan'])?" AND `plan` = '".$Q['plan']."'" : '';
		$Offer=!empty($Q['offer'])?" AND `offer` = '".$Q['offer']."'" : '';
		$Uid=!empty($Q['uid'])?" AND `uid` = '".$Q['uid']."'" : '';
		$Privacy=!empty($Q['privacy'])?" AND `privacy` = '".$Q['privacy']."'" : '';

		$Created_Min = $Q['created_min']; $Created_Max = $Q['created_max']; 
		if($Created_Min and $Created_Max){ $Created=" AND `created` BETWEEN '".$Created_Min."' AND '".$Created_Max." 23:59:59'"; }

		if(strtolower($Q['status'])=='false'){ $Status = " AND `status` = '0'"; }
		else{ $Status = " AND `status` = '".$Q['status']."'"; }

		$Sort = $Q['sort']; if(!$Sort){ $Sort='id'; }
		$SortBy = strtoupper($Q['sortby']); if(!$SortBy){ $SortBy='DESC'; }

	}
	else{ $User = $Q; }

	$WhereClause=$ID.$Updated.$Name.$Created.$Modified.$Amount.$Staking.$User.$CCC.$Roi.$Period.$Ttype.$TotalStaking.$IST.$Price.$USD.$UnStaking.$Plan.$Offer.$Uid.$Privacy.$Status;

	$LIMIT=$Q['limit'];
	if($LIMIT=='All'){ $LMT=''; }
	elseif($LIMIT){ $LMT="LIMIT ".$LIMIT."";  }
	else{ $LMT="LIMIT 101";  }

	$OFFSET=$Q['offset'];

	if($OFFSET){ $OFSET="OFFSET ".$OFFSET."";  }
	else{ $OFSET ='';}

	$Offset=!empty($Q['offset'])? $Q['offset'] : 0;

	$MethodColumn=strtolower($Q['methodcolumn']);
	if($MethodColumn){ $MC='(`'.$MethodColumn.'`)'; } 
	else{ $MC=''; }

	$Method = strtoupper($Q['method']);
	if(count($Select) > 0 ){ $Method= "`".implode("`,`",$Select)."`"; }
	elseif(!$Method){ $Method='*'; }
	$MM=$Method.$MC;

	$SQL = "SELECT ".$MM." FROM `".prefix."pods_staking2` WHERE 1=1 ".$WhereClause." ORDER BY `".$Sort."` $SortBy ".$LMT." ".$OFSET;  

	//echo $SQL;
	global $DB;$aa = 0; $ts=[]; $results = mysqli_query($DB, $SQL); 
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}

	if($MC){ $return=$ts[0][$Method.''.$MC]; }else{ $return=$ts;}
	return $return;
}




function Spot_Staking2($Q=null){ 
	// Developer : Pawan Kumar
	// Date : 2024-04-14
	// Input : UID
	// Output : Fatch User By UID

	if($Q){

		$SQL="SELECT * FROM `".prefix."pods_staking2` WHERE `uid` = '".$Q."';"; //echo $SQL;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0];

	}
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Staking Plan Feature Start //


function Staking2_PlanUpdate($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-14
	// Input : Array
	// Output : Updates the data that comes in the array.

	if(is_array($Q)){ $UID=$Q['uid']; $Name=$Q['name']; $Roi=$Q['roi']; $Ttype=$Q['ttype']; $CCC=$Q['ccc']; $Period=$Q['period']; $MinAmount=$Q['minamount']; $MaxAmount=$Q['maxamount']; $Description=$Q['description']; $Status=$Q['status']; }

	if($UID){

		$WHERE = " WHERE `uid` = '".$UID."'";
		$SET = "UPDATE `".prefix."pods_staking2_plan` SET  `modified`= current_timestamp()";

		if($Name){ $Name = ", `name`='".$Name."'"; }
		if($Roi){ $Roi = ", `roi`='".$Roi."'"; }
		if($Ttype){ $Ttype = ", `ttype`='".$Ttype."'"; }
		if($CCC){ $CCC = ", `ccc`='".$CCC."'"; }
		if($Period){ $Period = ", `period`='".$Period."'"; }
		if($MinAmount){ $MinAmount = ", `minamount`='".p2d($MinAmount)."'"; }
		if($MaxAmount){ $MaxAmount = ", `maxamount`='".p2d($MaxAmount)."'"; }
		if($Description){ $Description = ", `description`='".$Description."'"; }
		if($Status=='enable'){ $StatusValue = ", `status`='1'"; }
		elseif($Status=='disable'){ $StatusValue = ", `status`='0'"; }

		$SQL=$SET.$Name.$Roi.$Ttype.$CCC.$Period.$MinAmount.$MaxAmount.$Description.$StatusValue.$WHERE;
		if($SQL){

			global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
			if($results){ return true; }else{ return false; }

		}
		else{ $echo ='SQL not found.'; }
	}
	else{ $echo = 'ID not found.'; }
}












function Staking2_PlanStatus($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-13
	// Input : UID, Status( Enable, Disable )
	// Output : This function enables and disables the status of the transfer.

	if(is_array($Q)){ $Status=$Q['status']; $UID=$Q['uid']; }
	if($Status and $UID){

		if($Status == 'enable'){ $Statuss = 1; } 
		elseif($Status == 'disable'){ $Statuss = 0; }

		$SQL="UPDATE `".prefix."pods_staking2_plan` SET `status` = '".$Statuss."', `modified` = current_timestamp() WHERE `uid` = '".$UID."'"; //echo $SQL;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);

	}
	else{ $echo = 'Data Empty.'; }
	return $results;
}



function Staking2_PlanNew($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-14
	// Input : Array
	// Output : Inserts the data in the array that comes in it.

	if(is_array($Q)){ $Roi=$Q['roi']; $Ttype=$Q['ttype']; $MinAmount=$Q['minamount']; $CCC=$Q['ccc']; $Period=$Q['period']; $Description=$Q['description']; $MaxAmount=$Q['maxamount']; }

	if($Roi and $Ttype and $MinAmount and $CCC and $Period and $MaxAmount){

		$SQL="INSERT INTO `".prefix."pods_staking2_plan`(`id`, `name`, `created`, `modified`, `user`, `roi`, `ttype`, `minamount`, `ccc`, `status`, `uid`, `privacy`, `app`, `period`, `description`, `maxamount`) VALUES (NULL, 'Staking2_Plan', current_timestamp(), current_timestamp(), '2', '".$Roi."', '".$Ttype."', '".p2d($MinAmount)."', '".$CCC."', '1', 'NULL', 'Public', '1', '".$Period."', '".$Description."', '".p2d($MaxAmount)."')";
		global $DB;$aa = 0; $StakingPlan = mysqli_query($DB, $SQL);

		if($StakingPlan){

			$SQL1="UPDATE `".prefix."pods_staking2_plan` SET `uid` = `id`";
			global $DB;$aa = 0; $results = mysqli_query($DB, $SQL1);

		}
	}
	return $results;
}







function Staking2_Plans($Q=null){
	// Developer : Pawan kumar
	// Date : 2024-04-14
	// Input : Array
	// Output : Gives the details of the data from which the array comes.

	if(is_array($Q)){

		$ID=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Name=isset($Q['name'])?" AND `name` LIKE '%".strtolower($Q['name'])."%'" : '';
		$Created=isset($Q['created'])?" AND `created` >= '".$Q['created']."'" : '';
		$Modified=isset($Q['modified'])?" AND `modified` >= '".$Q['modified']."'" : '';
		$User=isset($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$Roi=isset($Q['roi'])?" AND `roi` = '".$Q['roi']."'" : '';
		$Ttype=isset($Q['ttype'])?" AND `ttype` = '".$Q['ttype']."'" : '';
		$MinAmount=isset($Q['minamount'])?" AND `minamount` <= '".$Q['minamount']."'" : '';
		$CCC=isset($Q['ccc'])?" AND `ccc` LIKE '".strtoupper($Q['ccc'])."'" : '';
		$Uid=isset($Q['uid'])?" AND `uid` LIKE '".strtoupper($Q['uid'])."'" : '';
		$Period=isset($Q['period'])?" AND `period` = '".$Q['period']."'" : '';
		//$Planid=isset($Q['planid'])?" AND `planid` = '".$Q['planid']."'" : '';
		$MaxAmount=isset($Q['maxamount'])?" AND `maxamount` >= '".$Q['maxamount']."'" : '';

		$Sort = $Q['sort']; if(!$Sort){ $Sort='id'; }
		$SortBy = strtoupper($Q['sortby']); if(!$SortBy){ $SortBy='ASC'; }

		if(strtolower($Q['status'])=='false'){ $Status = " AND `status` = '0'"; }
		else{ $Status = " AND `status` = '".$Q['status']."'"; }

	}
	else{ $User = $Q; }

	$WhereClause=$ID.$Name.$Created.$Modified.$User.$Roi.$Ttype.$MinAmount.$CCC.$Uid.$Period.$MaxAmount.$Status;

	$Limit=isset($Q['limit'])? $Q['limit'] : '';
	if(!$Limit){ $Limit = 111; }
	$Offset=isset($Q['offset'])? $Q['offset'] : 0;

	$SQL = "SELECT * FROM `".prefix."pods_staking2_plan` WHERE 1 ".$WhereClause." ORDER BY `$Sort` $SortBy LIMIT ".$Limit." OFFSET ".$Offset;  
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); //echo $SQL;
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}

	return $ts;

}




function Staking2_Plan($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-13
	// Input : UID
	// Output : Fatch User By UID

	if($Q){

		$SQL="SELECT * FROM `".prefix."pods_staking2_plan` WHERE `uid` = '".$Q."';"; //echo $SQL;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0];

	}
}



function Staking2_Currencies($Q=null){ //Currencies
	//Developer : Himanshu Nayak
	//Date : 2024/10/28
	//Input : Array
	//Output : Joo array me data aata hai uss data ke hisab se data ko select krta hai.

	if(is_array($Q)){

		$ID=!empty($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Name=!empty($Q['name'])?" AND `name` = '".$Q['name']."'" : '';
		$Created=!empty($Q['created'])?" AND `created` >= '".$Q['created']."'" : '';
		$Modified=!empty($Q['modified'])?" AND `modified` >= '".$Q['modified']."'" : '';
		$User=!empty($Q['user'])?" AND `user` = '".$Q['user']."'" : '';
		$CCC=!empty($Q['ccc'])?" AND `ccc` = '".$Q['ccc']."'" : '';
		$Address=!empty($Q['address'])?" AND `address` = '".$Q['address']."'" : '';
		$Logo=!empty($Q['logo'])?" AND `logo` = '".$Q['logo']."'" : '';
		$Network=!empty($Q['network'])?" AND `network` = '".$Q['network']."'" : '';
		$Price=!empty($Q['price'])?" AND `price` = '".$Q['price']."'" : '';
		$Enable=!empty($Q['enable'])?" AND `enable` >= '".$Q['enable']."'" : '';
		$Supply=!empty($Q['supply'])?" AND `supply` = '".$Q['supply']."'" : '';
		$Priority=!empty($Q['priority'])?" AND `priority` = '".$Q['priority']."'" : '';
		$Uid=!empty($Q['uid'])?" AND `uid` = '".$Q['uid']."'" : '';
		$Status=!empty($Q['status'])?" AND `status` = '".$Q['status']."'" : '';
		$Privacy=!empty($Q['privacy'])?" AND `privacy` = '".$Q['privacy']."'" : '';
		$App=!empty($Q['app'])?" AND `app` = '".$Q['app']."'" : '';
		$Deposit=!empty($Q['deposit'])?" AND `deposit` = '".$Q['deposit']."'" : '';
		$Withdraw=!empty($Q['withdraw'])?" AND `withdraw` = '".$Q['withdraw']."'" : '';
		$Symbol=!empty($Q['symbol'])?" AND `symbol` = '".$Q['symbol']."'" : '';
		$Ttype=!empty($Q['ttype'])?" AND `ttype` = '".$Q['ttype']."'" : '';
		$Change=!empty($Q['change'])?" AND `change` = '".$Q['change']."'" : '';
		$Decimal=!empty($Q['decimal'])?" AND `decimal` = '".$Q['decimal']."'" : '';
		$Send=!empty($Q['send'])?" AND `send` = '".$Q['send']."'" : '';
		$buy=!empty($Q['buy'])?" AND `buy` = '".$Q['buy']."'" : '';
		$Sell=!empty($Q['sell'])?" AND `sell` = '".$Q['sell']."'" : '';
		$Stake=!empty($Q['stake'])?" AND `stake` = '".$Q['stake']."'" : '';
		$Level=!empty($Q['level'])?" AND `level` = '".$Q['level']."'" : '';
		$Airdrop=!empty($Q['airdrop'])?" AND `airdrop` = '".$Q['airdrop']."'" : '';
		$Mindeposit	=!empty($Q['mindeposit'])?" AND `mindeposit` = '".$Q['mindeposit']."'" : '';
		$Maxdeposit=!empty($Q['maxdeposit'])?" AND `maxdeposit` = '".$Q['maxdeposit']."'" : '';
		$Minbuy=!empty($Q['minbuy'])?" AND `minbuy` = '".$Q['minbuy']."'" : '';
		$Maxbuy=!empty($Q['maxbuy'])?" AND `maxbuy` = '".$Q['maxbuy']."'" : '';
		$Minsell=!empty($Q['minsell'])?" AND `minsell` = '".$Q['minsell']."'" : '';
		$Maxsell=!empty($Q['maxsell'])?" AND `maxsell` = '".$Q['maxsell']."'" : '';
		$Minstake=!empty($Q['minstake'])?" AND `minstake` = '".$Q['minstake']."'" : '';
		$Maxstake=!empty($Q['maxstake'])?" AND `maxstake` = '".$Q['maxstake']."'" : '';
		$Minsend=!empty($Q['minsend'])?" AND `minsend` = '".$Q['minsend']."'" : '';
		$Maxsend=!empty($Q['maxsend'])?" AND `maxsend` = '".$Q['maxsend']."'" : '';
		$Minwithdraw=!empty($Q['minwithdraw'])?" AND `minwithdraw` = '".$Q['minwithdraw']."'" : '';
		$Maxwithdraw=!empty($Q['maxwithdraw'])?" AND `maxwithdraw` = '".$Q['maxwithdraw']."'" : '';
		$Erc20=!empty($Q['erc20'])?" AND `erc20` = '".$Q['erc20']."'" : '';
		$Bep20=!empty($Q['bep20'])?" AND `bep20` = '".$Q['bep20']."'" : '';
		$Trc20=!empty($Q['trc20'])?" AND `trc20` = '".$Q['trc20']."'" : '';
		$Audited=!empty($Q['audited'])?" AND `audited` = '".$Q['audited']."'" : '';
		$Volume=!empty($Q['volume'])?" AND `volume` = '".$Q['volume']."'" : '';
		$Marketcap=!empty($Q['marketcap'])?" AND `marketcap` = '".$Q['marketcap']."'" : '';
		$Circulatingsupply=!empty($Q['circulatingsupply'])?" AND `circulatingsupply` = '".$Q['circulatingsupply']."'" : '';
		$categoryy=!empty($Q['categoryy'])?" AND `categoryy` = '".$Q['categoryy']."'" : '';
		$mineable=!empty($Q['mineable'])?" AND `mineable` = '".$Q['mineable']."'" : '';
		$Transfer=!empty($Q['transfer'])?" AND `transfer` = '".$Q['transfer']."'" : '';
		$p2p=!empty($Q['p2p'])?" AND `p2p` = '".$Q['p2p']."'" : '';


		if($Q['enable']=='enable'){ $Enable = " AND `enable` = '1'"; }
		elseif($Q['enable']=='disable'){ $Enable = " AND `enable` = '0'"; }

		$Sort = $Q['sort'];
		$SortBy = strtoupper($Q['sortby']);

	}
	else{ $User = $Q; }

	$WhereClause=$ID.$Name.$Created.$Modified.$User.$CCC.$Address.$Logo.$Network.$Price.$Enable.$Supply.$Priority.$Uid.$Status.$Privacy.$App.$Deposit.$Withdraw.$Symbol.$Ttype.$Change.$Decimal.$Send.$buy.$Sell.$Stake.$Level.$Airdrop.$Mindeposit.$Maxdeposit.$Minbuy.$Maxbuy.$Minsell.$Maxsell.$Minstake.
		$Maxstake.$Minsend.$Maxsend.$Minwithdraw.$Maxwithdraw.$Erc20.$Bep20.$Trc20.$Audited.$Volume.$Marketcap.$Circulatingsupply.$categoryy.$mineable.$Transfer.$p2p;

	$Limit=!empty($Q['LIMIT'])? $Q['LIMIT'] : '';
	if(!$Limit){ $Limit = 111; }
	$Offset=!empty($Q['OFFSET'])? $Q['OFFSET'] : 0;


	if(!$Sort){ $Sort = 'id'; }
	if(!$SortBy){ $SortBy = 'ASC'; }
	$SQL = "SELECT * FROM `".prefix."pods_staking2_currency` WHERE 1 ".$WhereClause." ORDER BY `$Sort` $SortBy LIMIT ".$Limit." OFFSET ".$Offset;
	//echo   $SQL;
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}

	if($ts){ return $ts; }

}







?>