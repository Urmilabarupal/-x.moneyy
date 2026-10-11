<?php






function UpdateBetStatus(){
	$TodayPeriod = TodayPeriod()-1;
$SQL1 = "UPDATE `Coinpods_bet` SET  `status` = 2  WHERE `period` = ".$TodayPeriod." AND `bid` NOT IN(SELECT `bid` FROM `Coinpods_luckydraw` WHERE `period` LIKE '".$TodayPeriod."' ORDER BY `id` DESC)";	
$SQL2 = "UPDATE `Coinpods_bet` SET  `status` = 1  WHERE `period` = ".$TodayPeriod." AND `bid` IN(SELECT `bid` FROM `Coinpods_luckydraw` WHERE `period` LIKE '".$TodayPeriod."' ORDER BY `id` DESC)";	
	
	//echo $SQL1;
	//echo $SQL2;
	$results1=$results2=0;
		global $DB; $results1 = mysqli_query($DB, $SQL1);	$results2 = mysqli_query($DB, $SQL2);	
	return $results1+$results2;
}







####################################################################################################################################################################################################
####################################################################################################################################################################################################
####################################################################################################################################################################################################
####################################################################################################################################################################################################
####################################################################################################################################################################################################




 
function PendingLotteryWinToWallet($Q=null){

	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'Win' "; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'Win' "; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function LotteryTicketWinToWallet($Q=null){
	//Add Balance to Wallet from Transaction(Buy)
	$Output=0;	
	 $PendingLevelTransactions=PendingLotteryWinToWallet($Q);	  //print_r($PendingLevelTransactions);
	if($PendingLevelTransactions){
		foreach($PendingLevelTransactions as $TR){
			//print_r($PBT['user']);
			if(AddToFunding(array( 'user'=>$TR['user'], 'ccc'=>strtolower($TR['ccc']), 'amount'=>$TR['amount'] ))){
				Balance1Transaction($TR['id']);
				$Output++;
			}
			else{ Balance2Transaction($TR['id']); }
		}	
	}	
	return $Output;
}

 

#########################################################################################################################################################


 
function PendingLotteryTicket_LevelsToWallet($Q=null){

	if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'LotteryTicket_Level' "; }
	else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'LotteryTicket_Level' "; }

	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}


function LotteryTicket_LevelsToWallet($Q=null){
	//Add Balance to Wallet from Transaction(Buy)
	$Output=0;	
	 $PendingLevelTransactions=PendingLotteryTicket_LevelsToWallet($Q);	 //print_r($PendingLevelTransactions);
	if($PendingLevelTransactions){
		foreach($PendingLevelTransactions as $TR){
			//print_r($PBT['user']);
			if(AddToFunding(array( 'user'=>$TR['user'], 'ccc'=>strtolower($TR['ccc']), 'amount'=>$TR['amount'] ))){
				Balance1Transaction($TR['id']);
				$Output++;
			}
			else{ Balance2Transaction($TR['id']); }
		}	
	}	
	return $Output;
}

 

#########################################################################################################################################################






function LotteryTicket_LevelsNew($Q=null){
	// Developer :Pawan Kumar
	// Date : 2024-09-12
	// Input : 
	// Output : Deposit Level Income Provide

	$Return = [];$PendingDepositTransaction=null;
	$Output=0;
	$Dispatche=1;
	global $LS;
	$LS=array( '1'=>10 );

	$PendingDepositTransaction = PendingLotteryTicket_Levels($Q); 
	$echo = 'Pending LotteryTicket transaction aa rhi hai .';



	if(is_array($PendingDepositTransaction)){
		foreach($PendingDepositTransaction as $Ps){
			$echo = 'Foreach Good Working.';

			//print_r($Ps); echo '<br><br>';
			$Pendinguser=$Amount=$AmountOCA=null;

			if($Ps){ $Pendinguser = $Ps['user']; $Amount = $Ps['amount']; $AmountOCA =  $Ps['oca']; }


			$User=User($Pendinguser);  

			if($User['userid']){ $Uplines = Uplines($User['userid']); }

			if($Amount and $User and $Uplines){
				$echo = 'Amount, Userid And Uplines Found.';
				//print_r($Uplines);
				$aa=0;
				foreach($Uplines as $Upline){
					$echo = 'Foreach 2 Good Working.';

					$User='';
					$User=UserByUserID($Upline);
					$echo = 'User By Userid Data Found.';
					$aa++;
					//echo '<br><br>'; print_r($Upline);
					if($aa<=1){
						$echo = 'Level 1 Found.';



						if(!empty($User['ID'])){
							$echo = 'Userid Found.';
							// print_r($User); echo ':'.$User['ID'].'<br>';
							if(1){
								if(1){
									$echo = 'LotteryTicket_Level Income Condition Match Success.';

									$Walletss = null;$IncomeOCA=$Income=$AfterBalance=0;
									$Income = Percent($Amount,$LS[$aa]);
									$Walletss = Fundings($User['ID']);

									$IncomeOCA = Percent($AmountOCA,$LS[$aa]);
									$OCC = $Ps['occ'];

									$AfterBalance=$Walletss[strtolower($OCC)]+$IncomeOCA;
									
									$BetByUser = null;
									$BetByUser = BetByUser($User['ID']);
									if(!empty($BetByUser)){ $Balance = 0; $Status = 1;}else{$Balance = 6; $Status = 6;}
									
									

									$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`,`buyuser`,`selluser`,`walletname`,`selltid`,`price`,`buywalletname`,`sellwalletname`) VALUES (NULL, 'Level".$aa." Income from LotteryTicket', current_timestamp(), current_timestamp(), 'LotteryTicket_Level:".$aa."-TR:".$Ps['id']."', '".$User['ID']."', '".$Income."', '".$Ps['ccc']."', '".$Balance."', 'LotteryTicket_Level', '".$IncomeOCA."', '".$OCC."', '".$Status."', '".$Walletss[strtolower($OCC)]."', '".$AfterBalance."', '".$User['ID']."', '".$Pendinguser."', '".$Ps['walletname']."', '".$Ps['id']."', '".$Ps['price']."', '".$Ps['walletname']."', '".$Ps['walletname']."');";

									$echo = 'SQL Found.';
									sleep(1);
									global $DB;$Output=0;  $Output = mysqli_query($DB, $SQL);
									if($Output){
										$echo = 'Transaction Output Found.';

										$SQL1='';
										$SQL1="UPDATE `Coinpods_transaction` SET `level`='".$aa."' WHERE `id` = '".$Ps['id']."'";
										global $DB; $Output = mysqli_query($DB, $SQL1);
										$echo = 'Level Income Transaction Create Success.';

									}
									else{ 
										$SQL2='';
										$SQL2="UPDATE `Coinpods_transaction` SET `level`='99' WHERE `id` = '".$Ps['id']."'"; 
										global $DB;  $Output = mysqli_query($DB, $SQL2); 
										$echo = 'Transaction Output Not Found.';
									}
								}
								else{$echo = 'Staking Level Time Over This User : '.$User['ID'].'<br>';}
							}
							else{$echo = 'Staking Level Not Enable This User : '.$User['ID'].'<br>';}
							$Return[$Pendinguser][$User['ID']]['logs']=$echo;
							$Return[$Pendinguser][$User['ID']]['sql_update_insert']=$SQL;
							$Return[$Pendinguser][$User['ID']]['sql_update_success']=$SQL1;
							$Return[$Pendinguser][$User['ID']]['sql_update_faild']=$SQL2;
						}
						else{ $echo = 'UserID Not Found.'; }



					}
					else{ $echo = 'Maximum 1 level allow.'; } 

				}
			}
			else{ $echo = 'Data Empty.'; }
		}
	}
	else{ $echo = 'Pending Transaction Not Found.'; }
	$Return[$Pendinguser]['logs']=$echo;
	return $Return;
}



function PendingLotteryTicket_Levels($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-09-12
	// Input : 
	// Output : Pending Staking Transation Jiska Level Income = 0 hai.

	$SQL="SELECT * FROM `Coinpods_transaction` WHERE `status` = 1 AND `level` = 0 AND `ttype` = 'LotteryTicket' ORDER BY `id` DESC  LIMIT 111;"; //echo $SQL;
	global $DB; $aa = 0;$ts=[]; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	if($ts){ return $ts;}

}



####################################################################################################################################################################################################
####################################################################################################################################################################################################
####################################################################################################################################################################################################
####################################################################################################################################################################################################
####################################################################################################################################################################################################












 
//sleep(1);

//function TodayPeriod(){ $QQ = IST(); $QQ = explode(' ',$QQ); $QQ = clean($QQ[0]); return $QQ; }

# Temp Solution By Jaspal Byavat
function TodayPeriod(){ $QQ = Periodss(); $QQ = $QQ; return $QQ; }
#* Temp Solution By Jaspal Byavat





function WinnerNew($Q=null){
	//Developer : Pawan Kumar
	//Date : 2024/01/01
	//Input : User, Type = Day, Bid = Bet Ki ID, Rank
	//Output : Insert Winner Ki Transaction ( Coinpods_Winner )
	
	if(is_array($Q)){ $User=$Q['user']; $Type=$Q['ttype']; $Bid=$Q['bid']; $Rank=$Q['rank']; $wid=$Q['wid'];  $period=$Q['period']; }
	if($User and $Type and $Bid and $Rank){
		
		
		if($Rank==1){ $Amount=1000; }
		elseif($Rank==2){ $Amount=500; }
		elseif($Rank==3){ $Amount=300; }
		elseif($Rank==4){ $Amount=200; }
		elseif($Rank==5){ $Amount=100; }
		elseif($Rank==6){ $Amount=50; }
		elseif($Rank==7){ $Amount=40; }
		else{ $Amount=0; }
	
		
		if($Amount>0){
		
		$QQ = TodayPeriod();
		$SQL="INSERT INTO `Coinpods_winner`(`id`, `name`, `created`, `modified`, `ttype`, `bid`, `rank`, `user`, `amount`, `ccc`, `status`, `wid`, `period`) VALUES (NULL, 'LT".$Bid."', current_timestamp(), current_timestamp(), '".$Type."', '".$Bid."', '".$Rank."', '".$User."', '".p2d($Amount)."','USDT', '0', '".$wid."', '".$period."')";
		
		global $DB; $results = mysqli_query($DB, $SQL);
		
		}
	}
	else{ echo 'Data Empty.'; }
	
	return $results;
}





function Bet($Q=null){
//Developer : Pawan Kumar
//Date : 2023/12/31
//Input : Bid( Bet ID )
//Output : Bet id se Details
	
	$SQL="SELECT * FROM `Coinpods_bet` WHERE `bid` = '".$Q."';";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts[0];	
 
	return $return;
}

function BetByUser($Q=null){
//Developer : Pawan Kumar
//Date : 2023/12/31
//Input : Bid( Bet ID )
//Output : Bet id se Details
	if($Q){
	$SQL="SELECT * FROM `Coinpods_bet` WHERE `user` = '".$Q."';";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts[0];	
	}
	return $return;
}





function TotalUserOfTodayBets($Q=null){
	//Developer: Pawan Kumar
	//Date: 2023/12/30
	//Input:
	//Output: Total user of today bets.
	
		$QQ = TodayPeriod();
$SQL="SELECT COUNT(`user`), `user` AS 'UserID' FROM `Coinpods_bet` WHERE `period` = '".$QQ."' GROUP BY `user` ORDER BY `COUNT(``user``)` DESC;";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	$Output=count($ts);
	
	return $Output;
}









function LatestBid($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/27
//Input: UserID
//Output: User ki latest transaction bet ki.
	
	$SQL="SELECT * FROM `Coinpods_bet` WHERE `user` = '".$Q."' ORDER BY `Coinpods_bet`.`id` DESC LIMIT 1;";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts[0];	
 
	return $return;
}




function TopBuyerTicket($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/27
//Input:
//Output: User bet ki transaction count krta hai.
	
	$QQ = TodayPeriod();
	$SQL="SELECT COUNT(`user`) AS `total`, `user`, `bid` FROM `Coinpods_bet` WHERE `period` = '".$QQ."' GROUP BY `user` ORDER BY `total` DESC LIMIT 10;";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	
 
	return $return;
}
	







function BetByBID($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/25

	$SQL="SELECT * FROM `Coinpods_bet` WHERE `bid` = '".$Q."';";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts[0];	
 
	return $return;	
}





function Bets($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/25

	$SQL="SELECT * FROM `Coinpods_bet` WHERE `status` = 0 LIMIT 1111 ;";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	
 
	return $return;	
}



function LastWeekGlobalTodayBets($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/25	
 
	$Q = TodayPeriod()-1;		
	$SQL="SELECT * FROM `Coinpods_bet` WHERE `period` LIKE '".$Q."' ORDER BY `Coinpods_bet`.`id` DESC LIMIT 1000";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	
 
	return $return;	
}





function GlobalTodayBets($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/25	
 
	$Q = TodayPeriod();		
	$SQL="SELECT * FROM `Coinpods_bet` WHERE `period` LIKE '".$Q."' ORDER BY `Coinpods_bet`.`id` DESC LIMIT 111";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	
 
	return $return;	
}



function TotalTodayBets($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/25	
 
	$Q = TodayPeriod();			
	$SQL="SELECT COUNT('id') AS `Total` FROM `Coinpods_bet` WHERE `period` LIKE '".$Q."';";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	 
 
	return $ts[0]['Total'];
}

function TotalTodayBetsAmount($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/25	
 
	$Q = TodayPeriod();			
	$SQL="SELECT SUM(`amount`) AS `Total` FROM `Coinpods_bet` WHERE `period` LIKE '".$Q."';"; //echo $SQL;
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	 
 
	return $ts[0]['Total'];
}

 
 
function TotalYesterdayBets($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/25	
 
	$Q = TodayPeriod()-1;			
	$SQL="SELECT COUNT('id') AS `Total` FROM `Coinpods_bet` WHERE `period` LIKE '".$Q."';";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	 
 
	return $ts[0]['Total'];
}


 
 

 


function YesterdayBets($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/25
	
	if(!$Q){ $Q = i['id']; }
	$QQ = TodayPeriod()-1;

	$SQL="SELECT * FROM `Coinpods_bet` WHERE `user` = '".$Q."' AND `period` = '".$QQ."' LIMIT 1111;";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	
 
	return $return;	
}




function Periodss($Q=null){
if(!$Q){ $Q=1; }
if($Q){
	$SQL="SELECT * FROM `Coinpods_period` WHERE `id` = '1'";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0]['period'];	
}	
}
 


function CreateBet($Q=null){

	$results=0;

	if(i['id']){

		if(is_array($Q)){ $Amount=$Q['amount']; $User=$Q['user']; $CCC=strtolower($Q['ccc']); $Wallet=$Q['Wallet']; }

		$user = User($User); 
		//$U = Exchange_UserByUsername($user['user_login']);//print_r($U);
		//if($U['ID'] or 1){

			if($Amount and $User and $CCC and $Wallet){
				$echo = 'Enough sources available.';

				#Jaspal Byavat Work Start

				//if($Amount>=10){ $LottreyNo=random_int(1000000000, 9999999999); }
				if($Amount==number_format(10/Price('CCC:BUSD'),4)){
					$LottreyNo=random_int(1000000000, 9999999999); 
					$echo = 'Amount Match Success';

					$Type='7Day';
					$QQ = Periodss();
					
					if($Wallet == 'Funding'){ $Wallets = Fundings(i['id']); } 
					if($Wallet == 'Wallet'){ $Wallets = Wallets(i['id']); }
					$BeforeBalance=$Wallets[$CCC];
					$AfterBalance=$BeforeBalance-p2d($Amount);

					

				$SQL="INSERT INTO `Coinpods_bet`(`id`, `name`, `created`, `modified`, `user`, `amount`, `on`, `ccc`, `period`, `status`, `bid`, `ttype`, `StatusBet`) VALUES (NULL, 'Hx.money:".$User."', current_timestamp(), current_timestamp(), '".i['id']."', '".p2d($Amount)."', '', '".$CCC."', '".$QQ."', '0', '".$LottreyNo."', '".$Type."', '1')";
				global $DB; $Output = mysqli_query($DB, $SQL); //echo $SQL;
				$OP=mysqli_insert_id($DB);
/*
				if($Wallet == 'Funding'){ $Wallets = Fundings(i['id']); } 
				if($Wallet == 'Wallet'){ $Wallets = Wallets(i['id']); }

				$BeforeBalance=$Wallets[$CCC];
				$AfterBalance=$BeforeBalance-p2d($Amount);

				$SQL11="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`, `price`, `buyuser`, `processing`, `wallet`, `site`) VALUES (NULL, 'LotteryTicket:".$U['ID']."', current_timestamp(), current_timestamp(), 'LotteryTicket:".$U['ID'].":"."HX.money:".i['id'].":".GMT()."', '".$U['ID']."', '', '', '1', 'LotteryTicket', '".p2d($Amount)."', '".$CCC."', '1', '".$Wallets[$CCC]."', '".$AfterBalance."', '0', '0', '0','".$Wallet."','3');";

				global $DB; $results = mysqli_query($DB, $SQL11); $Output=mysqli_insert_id($DB);
				$OPp=mysqli_insert_id($DB); 

				*/
					// $results=1;
					if($OP){

					$OPp = $OP;
					$OCA = p2d($Amount*Price('CCC:BUSD'));

					#Jaspal Byavat Work End
					$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `afterbalance`, `price`, `buyuser`, `processing`,`walletname`) VALUES (NULL, 'LotteryTicket:".i['id']."', current_timestamp(), current_timestamp(), 'LotteryTicket:".i['id'].":".$OPp."', '".i['id']."', '".$OCA."', 'USDT', '1', 'LotteryTicket', '".p2d($Amount)."', '".$CCC."', '1', '".$Wallets[$CCC]."', '".$AfterBalance."', '".Price('CCC:BUSD')."', '".i['id']."', '0','".$Wallet."');";
					global $DB; $results = mysqli_query($DB, $SQL1); $Output=mysqli_insert_id($DB);

					if($results){
						$echo = 'Transaction Create Success';

						if($Wallet == 'Wallet'){

							$SQL2="UPDATE `Coinpods_wallet` SET `".$CCC."` = ".$CCC." - ".p2d($Amount)." WHERE `Coinpods_wallet`.`user` = '".i['id']."';";
							global $DB;$aa = 0; $Outputt = mysqli_query($DB, $SQL2);

						}

						if($Wallet == 'Funding'){

							$SQL3="UPDATE `Coinpods_funding` SET `".$CCC."` = ".$CCC." - ".p2d($Amount)." WHERE `Coinpods_funding`.`user` = '".i['id']."';";
							global $DB;$aa = 0; $Outputt = mysqli_query($DB, $SQL3);

						}

					}
					else{ $echo='failed attempt.'; }
				}
				else{$echo = 'Amount not available.';}
			}
			else{ $echo = 'Not enough resources.'; }
		}
		else{ $echo = 'User not found on HelloX Win.'; }
	}
	else{ $echo ='Login first.'; }
	//}

	if($Outputt==1){ return $Outputt; }
	else{ return $echo; }
}





/*


function sCreateBet( $Q=null ){
//Developer: Pawan Kumar
//Date: 2023/12/25
	
$echo='CreateBet Started.';
	
$results=0;
if(i['id']){
if(is_array($Q)){ $Amount=$Q['amount']; $User=$Q['user']; $CCC=strtolower($Q['ccc']); $Wallet=$Q['Wallet']; }
	
$user = User($User);
	
$U = Exchange_UserByUsername($user['user_login']);
	if($U['ID']){
	//print_r($U['ID']);
	
if($Amount and $U['ID'] and $CCC and $Wallet){
	$echo = 'Enough sources available.';
	
	if($Amount>=10){ $LottreyNo=random_int(100000, 999999); }
	
//$Period=365;
$Type='Day';
	
	
	
	$QQ = Periodss();	
	
	$SQL="INSERT INTO `Coinpods_bet`(`id`, `name`, `created`, `modified`, `user`, `amount`, `on`, `ccc`, `period`, `status`, `bid`, `ttype`) VALUES (NULL, 'Hx.money:".$User."', current_timestamp(), current_timestamp(), '".$U['ID']."', '".p2d($Amount)."', '', '".$CCC."', '".$QQ."', '0', '".$LottreyNo."',  '".$Type."')";
	
	global $DB; $Output = mysqli_query($DB, $SQL);
	
	$OP=mysqli_insert_id($DB);
	
	
	
	
if($Wallet == 'Funding'){ $Wallets = Fundings(i['id']); }
if($Wallet == 'Wallet'){ $Wallets = Wallets(i['id']); }

	
$SQL11="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `price`, `buyuser`, `processing`) VALUES (NULL, 'LotteryTicket:".$U['ID']."', current_timestamp(), current_timestamp(), 'LotteryTicket:".$U['ID'].":".$OP."', '".$U['ID']."', '', '', '1', 'LotteryTicket', '".p2d($Amount)."', '".$CCC."', '1', '".$Wallets[$CCC]."', '0', '0', '0');";
	
global $DB; $results = mysqli_query($DB, $SQL11); $Output=mysqli_insert_id($DB); //echo $SQL11; 
	$results=1;
if($results){
	
	
	
$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `price`, `buyuser`, `processing`) VALUES (NULL, 'LotteryTicket:".i['id']."', current_timestamp(), current_timestamp(), 'LotteryTicket:".i['id'].":".$OP."', '".i['id']."', '', '', '1', 'LotteryTicket', '".p2d($Amount)."', '".$CCC."', '1', '".$Wallets[$CCC]."', '0', '0', '0');";echo $SQL1; echo '<br><br>';
	
global $DB; $resultsss = mysqli_query($DB, $SQL1); $Output=mysqli_insert_id($DB);
		
	if($resultsss){
	
	
	
	
if($Wallet == 'Wallet'){
$SQL2="UPDATE `Coinpods_wallet` SET `".$CCC."` = ".$CCC." - ".p2d($Amount)." WHERE `Coinpods_wallet`.`user` = '".i['id']."';";
global $DB;$aa = 0; $Outputt = mysqli_query($DB, $SQL2);
	
}
if($Wallet == 'Funding'){
$SQL2="UPDATE `Coinpods_funding` SET `".$CCC."` = ".$CCC." - ".p2d($Amount)." WHERE `Coinpods_funding`.`user` = '".i['id']."';";
global $DB;$aa = 0; $Outputt = mysqli_query($DB, $SQL2);
	
}
	}	
}
else{ $echo='Transaction Not created'; }	
	
	
	
	
	
}	
	
}
else{ $echo='Not enough sources : '.$Wallet; }	
		
}
	return $Outputt;	
}






*/












/*
function sCreateBet( $Q=null ){
//Developer: Pawan Kumar
//Date: 2023/12/25
	
$echo='CreateBet Started.';
	
$results=0;
if(i['id']){
if(is_array($Q)){ $Amount=$Q['amount']; $User=$Q['user']; $CCC=strtolower($Q['ccc']); $Wallet=$Q['Wallet']; }
	
$user = User($user);
$U = Exchange_UserByUsername($user['user_login']);
	
	
if($Amount and $User and $CCC and $Wallet){
	$echo = 'Enough sources available.';
	
	if($Amount>=10){ $LottreyNo=random_int(100000, 999999); }
	
//$Period=365;
$Type='Day';
	
	
	
	$QQ = TodayPeriod();	
	
	$SQL="INSERT INTO `Coinpods_bet`(`id`, `name`, `created`, `modified`, `user`, `amount`, `on`, `ccc`, `period`, `status`, `bid`, `ttype`) VALUES (NULL, 'LT".$LottreyNo."', current_timestamp(), current_timestamp(), '".$User."', '".p2d($Amount)."', '', '".$CCC."', '".$QQ."', '0', '".$LottreyNo."',  '".$Type."')";
	
	global $DB; $Output = mysqli_query($DB, $SQL);
	
	$OP=mysqli_insert_id($DB);
	
	
	
	
if($Wallet == 'Funding'){ $Wallets = Fundings(i['id']); }
if($Wallet == 'Wallet'){ $Wallets = Wallets(i['id']); }

	
$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `price`, `buyuser`, `processing`) VALUES (NULL, 'LotteryTicket:".i['id']."', current_timestamp(), current_timestamp(), 'LotteryTicket:".i['id'].":".$OP."', '".i['id']."', '', '', '1', 'LotteryTicket', '".p2d($Amount)."', '".$CCC."', '1', '".$Wallets[$CCC]."', '0', '0', '0');";
	
global $DB; $results = mysqli_query($DB, $SQL1); $Output=mysqli_insert_id($DB);
	
if($results){	
	
if($Wallet == 'Wallet'){
$SQL2="UPDATE `Coinpods_wallet` SET `".$CCC."` = ".$CCC." - ".p2d($Amount)." WHERE `Coinpods_wallet`.`user` = '".i['id']."';";
global $DB;$aa = 0; $Outputt = mysqli_query($DB, $SQL2);
	
}
if($Wallet == 'Funding'){
$SQL2="UPDATE `Coinpods_funding` SET `".$CCC."` = ".$CCC." - ".p2d($Amount)." WHERE `Coinpods_funding`.`user` = '".i['id']."';";
global $DB;$aa = 0; $Outputt = mysqli_query($DB, $SQL2);
	
}
	
}
else{ $echo='Transaction Not created'; }	
	
	
	
	
	
	
	
}
else{ $echo='Not enough sources : '.$Wallet; }	
	
}
	return $Outputt;	
}*/

?>