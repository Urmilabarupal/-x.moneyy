<?php



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function PawanSep17_StakeTree2024($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-10-04
	// Input : UserID
	// Output : Team Deposit [ Direct Deposit, MasterLeg Deposit, AnotherLeg Deposit ]

	if(!$Q){$Q=i['id']; }
	//if(is_array($Q)){ $User=$Q['user']; $StartDate=$Q['StartDate']; $User=$Q['EndDate']; }
	$Tree=[]; $Rewards=[];	
	$users=Subordinates(['user'=>$Q, 'level'=>1, 'LIMIT'=>11111111111111]); // get users of only level 1
	$Business=0; $DirectStake=0; $DirectDeposit=0;

	if($users){

		$aa=0;	
		foreach($users as $user){
			$aa++;

			$user=$user['subordinate'];
			$thiss=PawanSelfStakingPending($user);  

			$ThisDeposit=$thiss['amount']; $DirectDeposit=$DirectDeposit+$ThisDeposit;
			$TeamDeposit=PawanTeamDeposit2024204($thiss['ID']);	
			$TD=$ThisDeposit + $TeamDeposit; 

			$Rewards[$aa]=array( 'TeamDeposit'=>d2p($TD), 'ThisDeposit'=>d2p($ThisDeposit), 'amount'=>d2p($TD), 'id'=>$thiss['ID'], 'user'=>$user );	

		}
		$RewardActual=$Rewards;
		arsort($Rewards); 

		$bb=0;
		foreach($Rewards as $Reward){
			$bb++;

			if($bb==1){ $DLegs[$bb]=$Reward['amount']; $Rewarddd[$bb]=array('id'=>$Reward['id'], 'amount'=>$Reward['amount']); }
			else{ $DLegs[2]=$DLegs[2]+$Reward['amount']; $Rewarddd[2]=array('id'=>'various', 'amount'=> $DLegs[2]); }

		}
		$Output=array( 'AllLegs'=>$TreeActual, 'Legs'=>$Treee, 'TeamStake'=>$Business, 'DirectStake'=>d2p($DirectStake), 'DirectDeposit'=>d2p($DirectDeposit), 'Reward'=>$Rewarddd );

	}
	return $Output; 
}




function PawanTeamDeposit2024204($Q=null){ 
	// Developer : Pawan Kumar
	// Date : 2024-10-04
	// Input : UserID
	// Output : Total Team Deposit 1 To 30 Level

	if(!$Q){ $Q=i['id']; }
	$B=0; 
	if($Q){	

		$Downlines = Subordinates(['user'=>$Q, 'mindeposit'=>1000000000, 'minlevel'=>1, 'maxlevel'=>30, 'LIMIT'=>11111111111111]);
		if($Downlines){
			$aa=0;
			foreach($Downlines as $Level){
				$aa++;  
				//print_r($Level['subordinate']); echo '<br><br>';
				$User=PawanSelfStakingPending($Level['subordinate']);
				if($User['amount']){

					$User=$User['amount']; 
					$B=$B+$User;

				}
			}
		}
	}
	if($B){ return $B; }
}





function PawanSelfStakingPending($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-11-29
	// Input :
	// Output : Pending Self Total Staking 

	//$Start = date("Y-m").'-01 15:00:01'; $End = date("Y-m").'-31 23:59:59';

	$Start = '2024-01-01 00:00:01'; 
	$End = '2025-01-31 23:59:59';

	$SQL="SELECT `user`, SUM(`usd`) AS 'amount' FROM `Coinpods_staking` WHERE `created` BETWEEN '".$Start."' AND '".$End."' AND `period` >= 30 AND `user` = '".$Q."';"; 
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++; }} 
	else{$ts = null;}

	return $ts[0];	

}






function SpotWalletToFundingWallet(){

	$PendingMainWalletFund=PendingSpotWalletFund();
	if($PendingMainWalletFund){
		foreach($PendingMainWalletFund as $Ps){
			//print_r($Ps['user'].' '.$Ps['usdt']);echo '<br>';

			$AddToWallet = AddToFunding(array( 'user'=>$Ps['user'], 'ccc'=>'ccc', 'amount'=>$Ps['ccc'] ));
			if($AddToWallet){
				RemoveFromWallet(array( 'user'=>$Ps['user'], 'ccc'=>'ccc', 'amount'=>$Ps['ccc'] ));
			}
		}
	}
}


function PendingSpotWalletFund(){
	$SQL="SELECT * FROM `Coinpods_wallet` WHERE `ccc` != 0 LIMIT 111111";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	return $ts;
}





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/*




function ExportDataToCSV($Q=null){
// Developer : Pawan Kumar
// Date : 2024-11-04
// Input : 
// Output : Jo Data Aa Rha Hai Uss Data Ko CSV File Me Save Karta Hai.

	$SQL = "SELECT `user` AS 'UserID', SUM(`amount`)/1000000000 AS 'Amount', `created` AS 'Date' FROM `Coinpods_transaction` WHERE `created` LIKE '%2024-11%' AND `ttype` LIKE 'Deposit' GROUP BY `user` ORDER BY `Amount` DESC;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}

	if(!empty($ts)){

		$filename = "this_month_deposit_userid.csv"; 
		$file = fopen($filename, 'w'); 

		$headers = array('UserID', 'Amount', 'Date');
        fputcsv($file, $headers);

		foreach($ts as $row){
            fputcsv($file, $row);
        }

		fclose($file);
		echo "डेटा " . $filename . " में सफलतापूर्वक एक्सपोर्ट हो गया है।";
	} 
	else{ echo "कोई डेटा नहीं मिला।"; }
}







function HelloxUsersBlock($Q=null){

	$PendingBlockedUsers = PendingBlockedUsers();
	if($PendingBlockedUsers){
		foreach($PendingBlockedUsers as $Ps){

			if($Ps){
				//print_r($Ps['userid']); echo '<br>';
				$SQL="UPDATE `Coinusers` SET `userblock`='1' WHERE `userid` = '".$Ps['userid']."';";
				global $HelloX2; $aa = 0; $results = mysqli_query($HelloX2, $SQL);

				if($results){

					$SQL1="UPDATE `mamber_details` SET `userblock`='1' WHERE `userid` = '".$Ps['userid']."';";
					global $Mating; $aa = 0; $results = mysqli_query($Mating, $SQL1);

				}
			}
		}
	}
	return $results;
}


function PendingBlockedUsers($Q=null){

	$SQL="SELECT * FROM `Coinusers` WHERE `userblock` = 1 ORDER BY `ID` ASC";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	return $ts;

}










//744872482895 == HX1263813380
//744872452727 == HX35308149
//744872452623 == HX8845015
//print_r(UpdateBlockUser());
function UpdateBlockUser(){

	//NOT BLOCK LEG == 744872452623 , 744872452638
	$Subordinates = Subordinates(['user'=>744872452698,'level'=>1,'LIMIT'=>1111111111]);
	if($Subordinates){

		foreach($Subordinates as $SB){
			if($SB['subordinate'] == 744872452623  or $SB['subordinate'] == 744872452638){
			$echo = 'This User Is Not Block '.$SB['subordinate'];

			}
			else{

				$echo = 'This User Is Block '.$SB['subordinate'];

				$SQL1 = "UPDATE `Coinusers` SET `userblock` = '1' WHERE `ID` = '".$SB['subordinate']."'";
				global $DB; $results = mysqli_query($DB, $SQL1);	

				$DirectSubordinates = Subordinates(['user'=>$SB['subordinate'],'LIMIT'=>111111111111]);
				$subordinat=0; $subordinateLevel=0;
				if($DirectSubordinates){
					foreach($DirectSubordinates as $DS){
						$subordinat++;
						//print_r($DS);

						$SQL = "UPDATE `Coinusers` SET `userblock` = '1' WHERE `ID` = '".$DS['subordinate']."'";
						global $DB;$results = mysqli_query($DB, $SQL);	
						$echo = 'Total Block User'.$subordinat;

					}	
				}
				else{$echo = 'Blocked Directs Subordinate Not Found.';}	
			}
		}
	}
	else{$echo = 'Subordinate Not Found.';}
	//echo $echo.'<br>';	
}




function UnblockUsers($Q=null){

	$Output=0;
	$Subordinates = Subordinates(['user'=>744872482895, 'LIMIT'=>11111111111]);
	if($Subordinates){
		foreach($Subordinates as $Ps){
			//print_r($Ps['subordinate']);

			$SQL = "UPDATE `Coinusers` SET `userblock` = '0' WHERE `ID` = '".$Ps['subordinate']."'";
			//global $DB;$results = mysqli_query($DB, $SQL);	
			$Output++;

		}
	}
	return $Output;
}







function RewardDataMenualUpdate(){

	$Output=0;
	$PendingRewardDataMenualUpdate=PendingRewardDataMenualUpdate();
	if($PendingRewardDataMenualUpdate){
		foreach($PendingRewardDataMenualUpdate as $Ps){
			//print_r($Ps['ID']); echo '<br>';

			//$UpdateTeamBusiness=UpdateTeamBusiness($Ps['ID']);
			if($UpdateTeamBusiness){

				$SQL="UPDATE `Coinusers` SET `pawan`='1' WHERE `ID` = '".$Ps['ID']."'";
				//global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
				$Output=1;

			}
			else{
				$SQL="UPDATE `Coinusers` SET `pawan`='2' WHERE `ID` = '".$Ps['ID']."'";
				//global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
			}

		}

	}
	return $Output;

}



function PendingRewardDataMenualUpdate($Q=null){

	$SQL="SELECT * FROM `Coinusers` WHERE `DRewardRank` != 0 AND `pawan` = 0 ORDER BY `DRewardRank` DESC";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	return $ts;

}







function UnstakeReef($Q=null){
// Developer : Pawan Kumar
// Date : 2024-10-09
// Input : 
// Output : Unstake REEF [ Add To Extra Wallet Me ]

	$PendingReefUnstake = PendingReefUnstake();
	if($PendingReefUnstake){

		foreach($PendingReefUnstake as $Ps){
			if($Ps){

				//print_r($Ps['user'].'  '.$Ps['amount']); echo '<br><br>';

				$AddToExtraWallet = AddToExtraWallet(['user'=>$Ps['user'], 'amount'=>$Ps['amount'], 'ccc'=>'ccc']);
				if($AddToExtraWallet){

					$SQL="UPDATE `Coinpods_stake` SET `unstake` = '1' WHERE `id` = '".$Ps['id']."'";
					global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	

				}
				else{

					$SQL="UPDATE `Coinpods_stake` SET `unstake` = '2' WHERE `id` = '".$Ps['id']."'";
					global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	

				}
			}
		}
	}
}


function PendingReefUnstake($Q=null){
// Developer : Pawan Kumar
// Date : 2024-10-09
// Input : 
// Output : Unstake All Pending Users List

	$SQL = "SELECT * FROM `Coinpods_stake` WHERE `status` = 7 AND `unstake` = 0";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	return $ts;

}






//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Extra Wallet = Wallet1 + Wallet2 + Wallet3 // 


function AllWalletFundTransfers($Q=null){
// Developer : Pawan Kumar
// Date : 2024-10-08
// Input : 
// Output : UPDATE

	$PendingAllWalletFundTransfer = PendingAllWalletFundTransfer();
	if($PendingAllWalletFundTransfer){
		foreach($PendingAllWalletFundTransfer as $Ps){

			if($Ps){

				$AllWalletFundTransfer = AllWalletFundTransfer($Ps['ID'], 'ccc');
				if($AllWalletFundTransfer){

				$SQL="UPDATE `Coinusers` SET `Fund_Add_Extra_Wallet`='1' WHERE `ID` = '".$Ps['ID']."'";
				global $DB; $aa = 0; $Output = mysqli_query($DB, $SQL);

				}
				else{

					$SQL="UPDATE `Coinusers` SET `Fund_Add_Extra_Wallet`='2' WHERE `ID` = '".$Ps['ID']."'";
					global $DB; $aa = 0; $Output = mysqli_query($DB, $SQL);

				}
			}
		}
	}
	return $Output;
}



function PendingAllWalletFundTransfer($Q=null){
// Developer : Pawan Kumar
// Date : 2024-10-08
// Input : 
// Output : Pending Users 

	$SQL="SELECT * FROM `Coinusers` WHERE `Fund_Add_Extra_Wallet` = 0 LIMIT 20000;";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	return $ts;

}



function AllWalletFundTransfer($Q=null, $CCC=null){
// Developer : Pawan Kumar
// Date : 2024-10-08
// Input : UserID, Currency
// Output : UPDATE

	$SpotWallet = Wallets($Q);
	$FundingWallet = Fundings($Q);
	$MineWallet = MineWallets($Q);

	$TotalAmount = $SpotWallet[strtolower($CCC)]+
		           $FundingWallet[strtolower($CCC)]+
		           $MineWallet[strtolower($CCC)];

	//echo 'UserID : '.$Q.'<br>';
	//echo 'Spot Wallet : '.$SpotWallet[strtolower($CCC)].'<br>';
	//echo 'Funding Wallet : '.$FundingWallet[strtolower($CCC)].'<br>';
	//echo 'Mine Wallet : '.$MineWallet[strtolower($CCC)].'<br>';

	//echo 'Total Amount : '.$TotalAmount.'<br><br>';

	if($Q and $TotalAmount){

		$SQL="UPDATE `Coinpods_extra_wallet` SET `ccc`='".$TotalAmount."', `spot_wallet`='".$SpotWallet[strtolower($CCC)]."', `funding_wallet`='".$FundingWallet[strtolower($CCC)]."', `mine_wallet`='".$MineWallet[strtolower($CCC)]."' WHERE `user` = '".$Q."'";
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);


	}
	return $results;
}







//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







function Portfolios($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-04
// Input : 
// Output : Price Update

	$Output=0;
	$TotalPortfolio = TotalPortfolio();
	if($TotalPortfolio){

		$Amount = d2p($TotalPortfolio);
		if($Amount >= 100000){

			$Price = $Amount*0.00001;
			//print_r($Price);
			$UpdatePortfolio = UpdatePortfolio($Price);
			if($UpdatePortfolio){

				$Output++;

			} 
		}
	}
	return $Output;
}




function TotalPortfolio($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-04
// Input : 
// Output : Today Total Trade Amount [HXC]

	$Date = date('Y-m-d');
	$SQL="SELECT SUM(`amount`) FROM `Coinpods_transaction` WHERE `created` LIKE '".$Date."%' AND `ttype` LIKE 'Trade' AND `ccc` LIKE 'CCC'";
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	return $ts[0]['SUM(`amount`)'];
}




function UpdatePortfolio($Q=null){
// Developer : Pawan Kumar
// Date : 2024-09-04
// Input : Price
// Output : HXS Price Update

	if($Q){

		$Price = number_format($Q,2);
		$SQL="UPDATE `Coinpods_currency` SET `modified` = current_timestamp(), `price` = `price`+'".$Price."'  WHERE `ccc` = 'HXS'"; //echo $SQL;
		global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL); 

	}
	return $results;
}





// नोट :- यह एक बार चलने वाला कोड है। कृपया इस कोड से छेड़छाड़ न करें।


// Developer : Pawan Kumar
// Date : 2024-06-29
// Input : 
// Output : Partition Trare Status Update Status == 4


function BuyPartitionTradeToWallet888($Q=null){
//Add Balance to Wallet from Transaction(Buy)
$Output=0;	
$PendingBuyPartitionTradeTransaction=PendingBuyPartitionTradeTransaction($Q);	
if($PendingBuyPartitionTradeTransaction){ 
foreach($PendingBuyPartitionTradeTransaction as $PBT){

	if($PBT['status'] == 4){
	//print_r($PBT['user']);

	$Transaction = Transaction($PBT['name']);
	if($Transaction['status'] == 5){ 
		$Amount=0; $Amount=$PBT['amount']*$Transaction['price'];

		//$Amount=0; $Amount=$PBT['amount']-$PBT['filled'];
	print_r($Transaction['user'].' '.$PBT['occ'].' '.$Amount.' '.$Transaction['walletname']);

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
	else{

		if(AddToWallet(array( 'user'=>$Transaction['user'], 'ccc'=>strtolower($PBT['occ']), 'amount'=>$Amount ))){
		Status5Transaction($PBT['id']);
		}
		else{ Status3Transaction($PBT['id']); }

	}
  }
}
}
}	
return $Output;
}











function PartitionTradeStatusUpdates($Q=null){

	$Output = 0;

	$PendingBuyOldOrder = PendingBuyOldOrder();
	if($PendingBuyOldOrder){
		foreach($PendingBuyOldOrder as $Ps){
			//print_r($Ps['id']);

			if($Ps['status'] == 5){
				$BuyPartitionTrade = BuyPartitionTrade($Ps['id']);
				if($BuyPartitionTrade['status']==1){ 
					if($BuyPartitionTrade['name'] == $Ps['id']){

						$PartitionTradeStatusUpdate = PartitionTradeStatusUpdate($Ps['id']);
						if($PartitionTradeStatusUpdate){

							$Output++; $echo = 'Partition Trade Status Update Success.';

						}
						else{ $echo = 'Internal Error.'; }
					}
					else{ $echo = 'Transaction Id Not Match.'; }
				}
				else{ $echo = 'Transaction Not Found.'; }
			}
			else{ $echo = 'Status Not Match.'; }
		}
	}
	else{ $echo = 'Pending Transaction Not Found.'; }
	return $Output;
}




function BuyPartitionTrade($Q=null){

	if($Q){

		$SQL="SELECT * FROM `Coinpods_transaction` WHERE `name` = '".$Q."' ORDER BY `id` ASC";
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		$return = $ts[0];	
		return $return;

	}
}






function PartitionTradeStatusUpdate($Q=null){

	if($Q){

		$SQL="UPDATE `Coinpods_transaction` SET `status` = '4' WHERE `Coinpods_transaction`.`name` = '".$Q."';"; //echo $SQL;
		global $DB; $results = mysqli_query($DB, $SQL);

	}
	return $results;
}



function PendingBuyOldOrder($Q=null){

	$SQL="SELECT * FROM `Coinpods_transaction` WHERE `created` >= '2024-05-31' AND `ttype` LIKE 'Buy' AND `status` = 5 ORDER BY `Coinpods_transaction`.`id` ASC";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	

	return $return;

}
*/

?>