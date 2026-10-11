<?php

import('Account');

function OneByOne__01($Q=null){
	
	if($Q=='hdbdsdhdsdskdjsdiuwe'){
		// $SQL"UPDATE `Coinusers` u
		// INNER JOIN (
		// SELECT q.`user`, q.`amount`, q.`created`,
		// DATE_ADD(q.`created`, INTERVAL 1 MONTH) AS `next_date`,
		// CASE
        //     WHEN q.`amount` >= 20000000000000 THEN 7
        //     WHEN q.`amount` >= 10001000000000 THEN 6
        //     WHEN q.`amount` >= 5001000000000  THEN 5
        //     WHEN q.`amount` >= 2201000000000  THEN 4
        //     WHEN q.`amount` >= 1101000000000  THEN 3
        //     WHEN q.`amount` >= 501000000000   THEN 2
        //     WHEN q.`amount` >= 50000000000    THEN 1
        //     ELSE 0
        // END AS `new_feature_plan`
		// FROM (
		// SELECT d.*, ROW_NUMBER() OVER ( PARTITION BY d.`user` ORDER BY d.`created` ASC ) AS `rn` FROM `Coinpods_deposit` d
		// WHERE d.`created` >= '2026-07-01 00:00:00' AND d.`created` <  '2026-08-01 00:00:00' AND d.`amount` >= 50000000000 AND DATE_ADD(d.`created`, INTERVAL 1 MONTH) > NOW() 
		// ) q
		// WHERE q.`rn` = 1
		// ) x ON u.`ID` = x.`user`
		// SET u.`feature_plan` = x.`new_feature_plan`, u.`staking_amount` = x.`amount`, u.`feature_activate` = x.`next_date` WHERE u.`feature_plan` = 0;";
		// 
		// $SQL="SELECT x.`user`, x.`amount`, x.`created`, DATE_ADD(x.`created`, INTERVAL 1 MONTH) AS `next_date`, u.`ID`, u.`feature_plan` AS `current_feature_plan`,  u.`feature_activate`,
		//       CASE
		// 	       WHEN x.`amount` >= 20000000000000 THEN 7
		// 	       WHEN x.`amount` >= 10001000000000 THEN 6
		// 	       WHEN x.`amount` >= 5001000000000  THEN 5
		// 	       WHEN x.`amount` >= 2201000000000  THEN 4
		// 	       WHEN x.`amount` >= 1101000000000  THEN 3
		// 	       WHEN x.`amount` >= 501000000000   THEN 2
		// 	       WHEN x.`amount` >= 50000000000    THEN 1
		// 	       ELSE 0
		// 	       END AS `new_feature_plan`
		// 	 FROM (  
		// 	        SELECT d.*,  ROW_NUMBER() OVER ( PARTITION BY d.`user` ORDER BY d.`created` ASC ) AS rn FROM `Coinpods_deposit` d 
		// 	        WHERE d.`created` >= '2026-07-01 00:00:00' AND d.`created` <  '2026-08-01 00:00:00' AND d.`amount` >= 50000000000 AND DATE_ADD(d.`created`, INTERVAL 1 MONTH) > NOW()
		// 	     ) x
		// 	 INNER JOIN `Coinusers` u ON u.`ID` = x.`user` AND u.`feature_plan` = 0 WHERE x.`rn` = 1 ORDER BY x.`created` ASC;";
	}
}


function TotalDeposit2024ActiveUpdate($Q = null)
{
	$TDI  = TotalDeposit2024InActive();
	$echo = '';

	if (empty($TDI)) {  $echo .= "No inactive deposit records found.<br>"; return $echo; }
	$echo .= "Total records found: " . count($TDI) . "<br><br>";

	foreach ($TDI as $Index => $TD) {

		if (empty($TD) || !isset($TD['ID'], $TD['staking_amount']) ) { 
			$echo .= "Record #" . ($Index + 1) . " skipped: ID or staking amount missing.<br>";  continue;
		}

		$UserID        = $TD['ID'];
		$StakingAmount = $TD['staking_amount'];


		$SQL="UPDATE `Coinusers` SET `convert_status` = '1',  `sell_status` = '1' WHERE `Coinusers`.`ID` = '" . $UserID . "';  ";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		if ($results) { $echo .= "Success: User ID {$UserID} updated to {$StakingAmount}.<br>"; } 
		else { $echo .= "Failed: User ID {$UserID} could not be updated. Error: " . mysqli_error($DB) . "<br>"; }

	}

	//$echo .= "<strong>TotalDeposit2024 update process completed.</strong><br>";

	return $echo;
}





function TotalDeposit2024InActive($Q=null){

	$SQL="SELECT * FROM `Coinusers` WHERE `convert_status` < 1 and `feature_plan` > 0;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;} 

	return $ts;
}





function UserFeature_IsActive(int $UserID): bool
{
	global $DB;
	if (!$DB instanceof mysqli ||$UserID <= 0){ return false; }
	$SQL = "SELECT `ID` FROM `Coinusers` WHERE `ID` = ? AND `feature_activate` IS NOT NULL AND `feature_activate` > UTC_TIMESTAMP() LIMIT 1 ";

	$Statement = mysqli_prepare($DB, $SQL);

	if ($Statement === false) { error_log('UserFeature_IsActive prepare failed: ' . mysqli_error($DB)); return false; }
	mysqli_stmt_bind_param($Statement,'i',$UserID);
	if(!mysqli_stmt_execute($Statement)){ 
		error_log('UserFeature_IsActive execute failed: ' .mysqli_stmt_error($Statement));
		mysqli_stmt_close($Statement);
		return false;
	}
	mysqli_stmt_store_result($Statement); $IsActive = mysqli_stmt_num_rows($Statement) === 1;
	mysqli_stmt_close($Statement);
	return $IsActive;
}





function UserFeature_Expire(?int $UserID = null): array
{
	global $DB;

	$Response = [ 's' => 0, 'c' => 400, 'o' => 'Feature expiration process failed.', 'expired_users' => 0, ];
	if (!$DB instanceof mysqli) { $Response['o'] = 'Database connection nahi mila.'; return $Response;  }

	/*
     * Single user expire karna ho to UserID pass karein.
     * Sab expired users process karne ho to null pass karein.
     */
	if ($UserID !== null) {

		if ($UserID <= 0) { $Response['o'] = 'Valid user ID nahi mila.'; return $Response; }

		$SQL = "UPDATE `Coinusers` SET `feature_activate` = NULL, `feature_plan` = 0 , `staking_amount` = 0 ,`convert_status` = 0,`sell_status` = 0 WHERE `ID` = ? AND `feature_activate` IS NOT NULL AND `feature_activate` <= UTC_TIMESTAMP() LIMIT 1 ";

		$Statement = mysqli_prepare($DB, $SQL);

		if($Statement === false) { $Response['c'] = 500; $Response['o'] = 'SQL prepare failed: ' . mysqli_error($DB); return $Response; }
		mysqli_stmt_bind_param($Statement,'i',$UserID);
	} 
	else{

		$SQL = "UPDATE `Coinusers` SET `feature_activate` = NULL, `feature_plan` = 0 , `staking_amount` = 0 ,`TotalDeposit2024` = 0 ,`convert_status` = 0,`sell_status` = 0 WHERE `feature_activate` IS NOT NULL AND `feature_activate` <= UTC_TIMESTAMP()";

		$Statement = mysqli_prepare($DB, $SQL);

		if($Statement === false){ $Response['c'] = 500; $Response['o'] = 'SQL prepare failed: ' . mysqli_error($DB); return $Response; }
	}

	if (!mysqli_stmt_execute($Statement)) {
		$Response['c'] = 500;
		$Response['o'] = 'Feature expiration execute failed: '. mysqli_stmt_error($Statement);
		mysqli_stmt_close($Statement);
		return $Response;
	}

	$ExpiredUsers = mysqli_stmt_affected_rows($Statement);

	mysqli_stmt_close($Statement);

	return [
		's' => 1,
		'c' => 200,
		'o' => $ExpiredUsers > 0 ? 'Expired premium features successfully disabled.' : 'Koi expired premium feature nahi mila.',
		'expired_users' => $ExpiredUsers,
	];
}


function TimingSystem($Q = null){

	$Account_Object = new Account();
	$StakingData = Staking20260718();
	if (empty($StakingData)) { echo 'Staking data nahi mila.'; return; }

	foreach ($StakingData as $Staking) {
		$Amount =  $Staking['usdt'];
		$ABD  = AmountByDays($Amount);
		$Account=$Account_Object->Account($Staking['user']);
		if($ABD['plan']==$Account['feature_plan']){ $echo ="Already plan updated.";}
		else{
			if($ABD){
				$echo ="Days found";

				//if($ABD['day']==30){ $Day1=MRD(gmdate('Y-m-d')); }
				//else{ $Day1=$ABD['day']; }

				$Day1=$ABD['day'];

				$NextDate = NextDate($Day1);

				if($NextDate){
					$echo ="Next Date found";
					$Array=['user'=>$Staking['user'], 'date'=>$NextDate, 'feature_plan'=>$ABD['plan'], 'staking_amount'=>$Amount];

					$UserFeature_Activate  = UserFeature_Activate($Array); unset($Array);
					if($UserFeature_Activate==1){ $echo ="User Activate date update success.";}
					else{ $echo ="User Activate date update failde."; }
				}
				else{ $echo ='next date not found.';}

			}
			else{ $echo = '<br>Amount minimum staking range se kam hai.';}
		}
	}

	echo $echo;
}


function UserFeature_Activate($Q=null){

	if(!empty(is_array($Q))){
		$echo ="Q is array found."; 

		$User =$Q['user']; $Data =$Q['date'];  $FP =$Q['feature_plan'];  $SA =$Q['staking_amount']; 
		if($User && $Data && $FP && $SA){

			$SQL="UPDATE `Coinusers` SET `feature_activate`='".$Data."', `feature_plan`='".$FP."' ,`staking_amount`='".$SA."' WHERE `Coinusers`.`ID` = '".$User."';";
			global $DB; $results = mysqli_query($DB, $SQL);
		}
		else{ $echo ="User , date not found."; }
	}
	else{ $echo ="Q is array not found.";  }
	return $results;
}








function MRD($Date = null): int { $Time=$Date ? strtotime($Date) : time(); return (int) date('t', $Time) - (int) date('j', $Time); }

function NextDate(int $day = 1, ?string $date = null): string
{
	$dateObject = new DateTimeImmutable($date ?? 'today'); return $dateObject ->modify("+{$day} days") ->format('Y-m-d');
}



function AmountByDays($Amount = 0)
{
	$Amount =  $Amount;

	if ($Amount >= 20000000000000) { return ['day'=>74,'plan'=>7]; }
	if ($Amount >= 10001000000000) { return ['day'=>66,'plan'=>6]; }
	if ($Amount >= 5001000000000)  { return ['day'=>59,'plan'=>5]; }
	if ($Amount >= 2201000000000)  { return ['day'=>51,'plan'=>4]; }
	if ($Amount >= 1101000000000)  { return ['day'=>44,'plan'=>3]; }
	if ($Amount >= 501000000000)   { return ['day'=>37,'plan'=>2]; }
	if ($Amount >= 50000000000)    { return ['day'=>30,'plan'=>1]; }

	return null;
}

function Staking20260718($Q = null) {

	global $DB;

	//$SQL = "SELECT d.`user`, SUM(d.`amount`) AS `usdt`, u.`staking_amount` FROM `Coinpods_deposit` AS d INNER JOIN `Coinusers` AS u ON u.`ID` = d.`user` WHERE d.`amount` >= 50000000000 AND d.`created` >= DATE_FORMAT(CURDATE(), '%Y-%m-01') AND d.`created` < DATE_FORMAT(CURDATE() + INTERVAL 1 MONTH, '%Y-%m-01') GROUP BY d.`user`, u.`staking_amount` HAVING SUM(d.`amount`) > u.`staking_amount` ORDER BY d.`user` DESC;";

	$SQL="SELECT d.`user`, SUM(d.`amount`) AS `usdt`, u.`staking_amount` FROM `Coinpods_deposit` AS d INNER JOIN `Coinusers` AS u ON u.`ID` = d.`user` WHERE d.`created` >= DATE_FORMAT(CURDATE(), '%Y-%m-01') AND d.`created` < DATE_FORMAT( CURDATE() + INTERVAL 1 MONTH, '%Y-%m-01' ) GROUP BY d.`user`, u.`staking_amount` HAVING SUM(d.`amount`) >= 50000000000 AND SUM(d.`amount`) > u.`staking_amount` ORDER BY d.`user` DESC;";
	$results = mysqli_query($DB, $SQL);
	if ($results === false) { $echo ='SQL Error: ' . mysqli_error($DB); return null; }
	$data = [];
	while ($row = mysqli_fetch_assoc($results)) { $data[] = $row; }
	return $data ?: null;
}


?>