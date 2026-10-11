<?php

function LevelDeposit($Q=null){
	// Developer :Pawan Kumar
	// Date : 2024-09-12
	// Input : 
	// Output : Deposit Level Income Provide

	$Output=0;
	$Dispatche=1;
	global $LS;
	$LS=array( '1'=>2,'2'=>0.5,'3'=>0.5,'4'=>0.5,'5'=>0.25,'6'=>0.25,'7'=>0.25,'8'=>0.25,'9'=>0.25,'10'=>0.25 );

	$PendingDepositTransaction = PendingDepositTransaction($Q); 
	$echo = 'Pending staking transaction aa rhi hai phle yh system deposit par tha.';


	#JAspal
	//$PendingDepositTransaction = $Q;
	#*JAspal
	//print_r($PendingDepositTransaction);

	if(is_array($PendingDepositTransaction)){
		foreach($PendingDepositTransaction as $Ps){
			$echo = 'Foreach Good Working.';

			//print_r($Ps); echo '<br><br>';

			if($Ps){ $User = $Ps['user']; $Amount = $Ps['usd']; }

			$User=User($User); $II=$User;

			if($User['userid']){ $Uplines = Uplines($User['userid']); }

			if($Amount and $User and $Uplines){
				$echo = 'Amount, Userid And Uplines Found.';

				$aa=0;
				foreach($Uplines as $Upline){
					$echo = 'Foreach 2 Good Working.';

					$User='';
					$User=UserByUserID($Upline);
					$echo = 'User By Userid Data Found.';
					$aa++;
					//echo '<br><br>'; print_r($Upline);
					if($aa<=10){
						$echo = 'Level 10 Found.';

						if($User['ID']){
							$echo = 'Userid Found.';
							print_r($User['StakingLevel']); echo ':'.$User['ID'].'<br>';
							if(!empty($User['StakingLevel']) && $User['StakingLevel'] !== '0000-00-00'){

								$dateTime = new DateTime($Ps['created']);
								$PSdate = $dateTime->format("Y-m-d");
								//print_r('MAX DATE '.$User['StakingLevel'].'<br>'.' CREATED DATE '.$PSdate);

								if($User['StakingLevel']>=$PSdate){

									$echo = 'Staking Level Income Condition Match Success.';

									$Income = Percent($Amount,$LS[$aa]);
									$Walletss = Fundings($User['ID']);

									$AfterBalance=$Walletss['usdt']+$Income;

									$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`) VALUES (NULL, 'Level".$aa." Income from Staking', current_timestamp(), current_timestamp(), 'StakingLevel:".$aa."-TR:".$Ps['id']."', '".$User['ID']."', '', '', '0', 'Level', '".$Income."', 'USDT', '1', '".$Walletss['usdt']."', '".$AfterBalance."');";

									$echo = 'SQL Found.';
									sleep(1);
									global $DB; $Output = mysqli_query($DB, $SQL);
									if($Output){

										//$Input = ['feature'=>'Level','amount'=>$Income,'pair'=>'USDT_USDT','user'=>$User['ID']];
										//LiveData___Feature_Meta($Input);

										if($Dispatche==1){
											$Array=['feature'=>'Level','pair'=>'USDT_USDT','user'=>$User['ID'],'amount'=>$Income,];
											HistoryUpdateNew($Array);
										}

										$echo = 'Transaction Output Found.';

										$SQL1="UPDATE `Coinpods_staking` SET `level-income`='1' WHERE `id` = '".$Ps['id']."'";
										global $DB; $Output = mysqli_query($DB, $SQL1);
										$echo = 'Level Income Transaction Create Success.';

									}
									else{ 

										$SQL2="UPDATE `Coinpods_staking` SET `level-income`='2' WHERE `id` = '".$Ps['id']."'"; 
										global $DB; $Output = mysqli_query($DB, $SQL2); 
										$echo = 'Transaction Output Not Found.';
									}
								}
								else{

									$SQL2="UPDATE `Coinpods_staking` SET `level-income`='6' WHERE `id` = '".$Ps['id']."'"; 
									global $DB; $Output = mysqli_query($DB, $SQL2); 

									$echo = 'Staking Level Time Over This User : '.$User['ID'].'<br>';
								}
							}
							
							else{
								$SQL2="UPDATE `Coinpods_staking` SET `level-income`='7' WHERE `id` = '".$Ps['id']."'"; 
								global $DB; $Output = mysqli_query($DB, $SQL2); 
								$echo = 'Staking Level Not Enable This User : '.$User['ID'].'<br>';
							}
						}
						else{ $echo = 'UserID Not Found.'; }
					}
					else{ $echo = 'Maximum 10 level allow.'; } 
				}
			}
			else{ $echo = 'Data Empty.'; }
		}
	}
	else{ $echo = 'Pending Transaction Not Found.'; }
	echo $echo.'<br>';
	return $Output;
}



function PendingDepositTransaction($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-09-12
	// Input : 
	// Output : Pending Staking Transation Jiska Level Income = 0 hai.

	$SQL="SELECT * FROM `Coinpods_staking` WHERE `status` = 1 AND `level-income` = 0 ORDER BY `id` DESC  LIMIT 11;"; //echo $SQL;
	global $DB; $aa = 0;$ts=[]; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	if($ts){ return $ts;}

}


function DirectThisMonthDepositUpdate($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-09-12
	// Input : UserID
	// Output : Direct Deposit Update

	$TotalDeposit=0;
	if($Q){
		$User = user($Q);
		$Downline = Downline($User['referby']);
		if($Downline){

			foreach($Downline as $D){

				$UBUID = UserByUserID($D['userid']);
				//print_r($User['ID']); echo '<br>';

				$TotalDeposit2024=TotalDeposit2024($UBUID['ID']);
				$TotalDeposit=$TotalDeposit+$TotalDeposit2024;

				if($TotalDeposit and $User['referby']){

					$SQL="UPDATE `Coinusers` SET `DirectThisMonthDeposit`='".$TotalDeposit."' WHERE `userid` = '".$User['referby']."'";
					global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	

				}
				else{ $echo = 'TotalDeposit And UserID Not Found.'; }
			}
		}
		else{ $echo = 'Downline Not Found.'; }
	}
	return $results;
}





function TotalDeposit2024($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-09-12
	// Input : UserID
	// Output : Total Deposit Amount By UserID

	if($Q){

		$Start = date("Y-m").'-01';
		$End = date("Y-m").'-31';

		//$SQL = "SELECT SUM(`amount`) FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `ttype` LIKE 'Deposit' AND `ccc` = 'usdt' AND `created` LIKE '".$Date."%'";
		$SQL="SELECT SUM(`amount`) FROM `Coinpods_transaction` WHERE `created` BETWEEN '".$Start."' AND '".$End."' AND `user` = '".$Q."' AND `ttype` = 'Deposit' AND `ccc` = 'USDT' AND `status` = 1";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}	
		if($ts){ return $ts[0]['SUM(`amount`)']; }
	}
	else{ $echo = 'Q Data Empty.'; }
}




?>