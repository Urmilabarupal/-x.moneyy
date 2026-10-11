<?php



function GlobalJackpotAmount($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-09-20
	// Input : 
	// Output : Global Amount Jackpot

	$echo = 'Global Jackpot Amount Start.'; 
	if(i['id']){
		$echo = 'Login User Found.';

		$SQL="SELECT SUM(`total`) FROM `Coinpods_jackpot`";
		if($SQL){	
			$echo = 'SQL Found.';

			global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
			if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
			else{$ts = null;}	
			if($ts){ return $ts[0]['SUM(`total`)']; }
			$echo = 'Success';

		}
		else{ $echo = 'SQL Not Found.'; }
	}
	else{ $echo = 'Login first.'; }
}





function Jackpot_Placement($Q=null){	
	// Developer : A'nil Nayak
	// Date : 2024-04-18
	// Input : Jackpot ID
	// Engine : Palcement of new Jackpot
	// Output : Boolean

	$s=0;	
	if($Q){
		$echo = 'Jackpot id found.';		
		$Jackpot=Jackpot($Q);		
		if($Jackpot){			
			$echo = 'Jackpot found.'; 			
			$User=user(1); $U=explode(':',$User['matrix']);
			if($U){ $echo = 'Jackpot Status found.'; }			
			if($U[1]==1){ $Position = 2; $PJackpot = $U[0]; }
			elseif($U[1]==2){ $Position = 1; $PJackpot = $U[0]+1; }
			else{ $Position = 1; $PJackpot = $U[0]; }			
			if($PJackpot and $Position){ $echo = 'Placement Jackpot and Position found.'; }			
			$Positionn = 'p'.$Position;
			$Array['id'] = $PJackpot;
			$Array[$Positionn] = $Jackpot['id']; //print_r($Array);			
			$JackpotUpdate=JackpotUpdate($Array);			
			if($JackpotUpdate){				
				$SQL="UPDATE `Coinusers` SET `matrix`='".$PJackpot.':'.$Position."' WHERE `ID` = '1'";
				global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); 			
				if($results){ $s=1; }			
			}
			else{ $echo = 'Jackpot update failed attempt.'; }
		}
		else{ $echo = 'Jackpot not found.'; }
	}
	else{ $echo = 'Jackpot id not found.'; }
	//echo $echo;
	return $s;
}










//////////////////////////////////////////////////
///////////////////////////////////////////





function Matrix($Q=null){

	if($Q){

		$User=user(1); $U=explode(':',$User['matrix']);
		//print_r($User[0]);

		if($U[1]==1){

			$User=user($Q); if($User['userid']){
				$JackpotUpdate=JackpotUpdate(array('user'=>$U[0], 'p2'=>$User['userid']));
				if($JackpotUpdate){

					$SQL="UPDATE `Coinusers` SET `matrix`='".$U[0].':2'."' WHERE `ID` = '1'";
					global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); //echo $SQL;

					if($results){

						$Jackpot=Jackpot($U[0]);
						if($Jackpot){ 
							$U=UserByUserID($Jackpot['p1']);

							$SQL1="UPDATE `Coinusers` SET `matrix`='".$U['ID'].':2'."' WHERE `ID` = '1'";
							global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL1); //echo $SQL;
							return $Output;

						}

					}
				}
			}
		}
		elseif($U[1]==2){

			$User=user($Q); if($User['userid']){
				$JackpotUpdate=JackpotUpdate(array('user'=>$U[0], 'p1'=>$User['userid']));
				if($JackpotUpdate){

					$SQL="UPDATE `Coinusers` SET `matrix`='".$U[0].':1'."' WHERE `ID` = '1'";
					global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); //echo $SQL;

				}
			}
		}
		elseif($U[1]==0){

			$User=user($Q); if($User['userid']){
				$JackpotUpdate=JackpotUpdate(array('user'=>$U[0], 'p1'=>$User['userid']));
				if($JackpotUpdate){

					$SQL="UPDATE `Coinusers` SET `matrix`='".$U[0].':1'."' WHERE `ID` = '1'";
					global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); //echo $SQL;

				}
			}
		}
	}
	return $results;
}







function JackpotUpdate($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-18
	// Input : Array
	// Output : Array by data update

	if(is_array($Q)){ $ID=$Q['id']; $P1=$Q['p1']; $P2=$Q['p2']; $TP1=$Q['tp1']; $TP2=$Q['tp2']; $Total=$Q['total']; $PP1=$Q['pp1']; $PP2=$Q['pp2']; $JackpotActive=$Q['jackpotactive']; }

	if($ID){

		$WHERE = " WHERE `id` = '".$ID."'";
		$SET = "UPDATE `".prefix."pods_jackpot` SET  `modified`= current_timestamp()";

		if($Name){$Name = ", `name`='".$Name."'";}
		if($P1){$P1 = ", `p1`='".$P1."'";}
		if($P2){$P2 = ", `p2`='".$P2."'";}
		if($TP1){$TP1 = ", `tp1`='".$TP1."'";}
		if($TP2){$TP2 = ", `tp2`='".$TP2."'";}
		if($Total){$Total = ", `total`='".$Total."'";}
		if($PP1){$PP1 = ", `pp1`='".$PP1."'";}
		if($PP2){$PP2 = ", `pp2`='".$PP2."'";}
		if($JackpotActive){$JackpotActive = ", `jackpotactive`='".$JackpotActive."'";}

		$SQL=$SET.$Name.$P1.$P2.$TP1.$TP2.$Total.$PP1.$PP2.$JackpotActive.$WHERE;

		if($SQL){  

			global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
			if($results){ return true; }else{ return false; }

		}
		else{ $echo ='SQL not found.'; }
	}
	else{ $echo = 'ID not found.'; }
}



function JackpotNew($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-18
	// Input : Array
	// Output : Jackpot ki new entry

	if($Q){ 

		$User=user($Q);
		if($User['userid']){

			$SQL="INSERT INTO `".prefix."pods_jackpot`(`id`, `name`, `created`, `modified`, `uid`, `user`, `p1`, `p2`, `tp1`, `tp2`, `total`, `pp1`, `pp2`) VALUES (NULL, '".$User['userid']."', current_timestamp(), current_timestamp(), NULL, '".$Q."', '', '', '', '', '', '', '')";

			global $DB;$aa = 0;
			$results = mysqli_query($DB, $SQL);
			$INSERT=mysqli_insert_id($DB);
			//print_r($INSERT);

			if($results){

				$SQL1="UPDATE `".prefix."pods_jackpot` SET `uid`=`id`";
				global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL1);

				$Jackpot_Placement = Jackpot_Placement($INSERT);
				if($Jackpot_Placement){

					Jackpot_Incomes($INSERT);

				}
			}
		}
	}
	else{ $echo = 'Data Empty.'; }
	return $Output;
}



function JackpotStatus($Q=null){
	//Issme jackpot ka status enable and disable kiya jata hai.	
}



function Jackpots($Q=null){
	// Developer : Pawan kumar
	// Date : 2024-04-18
	// Input : Array
	// Output : array by data select

	if(is_array($Q)){

		$Sort = $Q['sort'];
		$ID=isset($Q['id'])?" AND `id` = '".$Q['id']."'" : '';
		$Name=isset($Q['name'])?" AND `name` LIKE '%".strtolower($Q['name'])."%'" : '';
		$Created=isset($Q['created'])?" AND `created` >= '".$Q['created']."'" : '';
		$Modified=isset($Q['modified'])?" AND `modified` >= '".$Q['modified']."'" : '';
		$User=isset($Q['user'])?" AND `user` LIKE '".$Q['user']."'" : '';
		$Uid=isset($Q['uid'])?" AND `uid` LIKE '".$Q['uid']."'" : '';
		$P1=isset($Q['p1'])?" AND `p1` = '".$Q['p1']."'" : '';
		$P2=isset($Q['p2'])?" AND `p2` = '".$Q['p2']."'" : '';
		$TP1=isset($Q['tp1'])?" AND `tp1` = '".$Q['tp1']."'" : '';
		$TP2=isset($Q['tp2'])?" AND `tp2` = '".$Q['tp2']."'" : '';
		$Total=isset($Q['total'])?" AND `total` = '".$Q['total']."'" : '';
		$PP1=isset($Q['pp1'])?" AND `pp1` = '".$Q['pp1']."'" : '';
		$PP2=isset($Q['pp2'])?" AND `pp2` = '".$Q['pp2']."'" : '';

		if($Sort == 'id'){ $Sortt = 'id'; }
		elseif($Sort == 'name'){ $Sortt = 'name'; }
		elseif($Sort == 'user'){ $Sortt = 'user'; }
		elseif($Sort == 'p1'){ $Sortt = 'p1'; }
		elseif($Sort == 'p2'){ $Sortt = 'p2'; }
		elseif($Sort == 'tp1'){ $Sortt = 'tp1'; }
		elseif($Sort == 'tp2'){ $Sortt = 'tp2'; }
		elseif($Sort == 'total'){ $Sortt = 'total'; }
		elseif($Sort == 'pp1'){ $Sortt = 'pp1'; }
		elseif($Sort == 'pp2'){ $Sortt = 'pp2'; }
		//else{ $Sortt = 'id'; }
		$SortBy = strtoupper($Q['sortby']); if(!$SortBy){ $SortBy='ASC'; }


	}
	else{ $User = $Q; }

	$WhereClause=$ID.$Name.$Created.$Modified.$Uid.$User.$P1.$P2.$TP1.$TP2.$PP1.$PP2;

	$Limit=isset($Q['limit'])? $Q['limit'] : '';
	if(!$Limit){ $Limit = 11; }
	$Offset=isset($Q['offset'])? $Q['offset'] : 0;
	if(!$Sortt){ $Sortt = 'id'; }
	$SQL = "SELECT * FROM `".prefix."pods_jackpot` WHERE 1 ".$WhereClause." ORDER BY `$Sortt` $SortBy LIMIT ".$Limit." OFFSET ".$Offset; //echo $SQL;
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); 
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}

	return $ts;

}







function Jackpot($Q=null){
	// Developer : Pawan kumar
	// Date : 2024-04-18
	// Input : UID
	// Output : Single Transaction By UID

	if($Q){

		$SQL="SELECT * FROM `".prefix."pods_jackpot` WHERE `id` = '".$Q."';";
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		return $ts[0];

	}
	else{ $echo = 'Data Empty.'; }
}





function UpdateJackpotIncomeTotalUpdate(){
	// One time function sabhi users kee total jackpot income update krne ke liye.

	$Ps=PendingTotalJackpotIncomeUser();
	if($Ps){
		foreach($Ps as $P){
			print_r($P['amount'].' '.$P['user']);

			$SQL="UPDATE `Coinpods_jackpot` SET `total`='".$P['amount']."' WHERE `user` = '".$P['user']."';";
			global $DB; $aa = 0; $results = mysqli_query($DB, $SQL); echo '<br><br>'.$SQL;



		}
	}
	return $results;
}





function PendingTotalJackpotIncomeUser(){
	// One time function sabhi users kee total jackpot income pending nikalne ke liye.

	$SQL="SELECT SUM(`amount`) AS 'amount', `user` FROM `Coinpods_transaction` WHERE `ttype` = 'Jackpot' GROUP BY `user` ORDER BY `amount` DESC LIMIT 2000;";
	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	if($ts){ return $ts; }

}







//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



function TotalJackpotActiveUsers($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024/04/22
	// Input : 
	// Output : Total jackpot active users

	$SQL="SELECT COUNT(`id`) FROM `Coinpods_jackpot`";
	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	if($ts){ return $ts[0]['COUNT(`id`)']; }

}


function TodayJackpotActiveUsers($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024/04/22
	// Input :
	// Output : Today total jackpot active users

	$Today_Date = date("Y-m-d");

	$SQL="SELECT COUNT(`id`) FROM `Coinpods_jackpot` WHERE `created` LIKE '".$Today_Date."%' ORDER BY `id` DESC ";
	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	if($ts){ return $ts[0]['COUNT(`id`)']; }

}






function TodayJackpotIncome($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-19
	// Input : UserID
	// Output :  UserID By Today Total Amount Jackpot Income.

	if($Q){

		$Date = date("Y-m-d");

		$SQL="SELECT SUM(`amount`) FROM `Coinpods_transaction` WHERE `ttype` = 'Jackpot' AND `created` LIKE '%".$Date."%' AND `user` = '".$Q."';"; //echo $SQL;
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(`amount`)']; }

	}
}





function TodayJacpotIncomeUpdate($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-30
	// Input : UserID
	// Output : Today Jackpot Income Update By UserID
	$TodayJackpotIncome=0;
	if($Q){

		$TodayJackpotIncome=TodayJackpotIncome($Q);
		if($TodayJackpotIncome){
			//print_r($TodayJackpotIncome);

			$SQL="UPDATE `Coinpods_jackpot` SET `today`='".$TodayJackpotIncome."' WHERE `user` = '".$Q."'";
			global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);

		}
	}
	else{ $echo='Data Empty.'; }
	return $TodayJackpotIncome;
}





function TotalJackpotIncome($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-19
	// Input : UserID
	// Output :  UserID By Total Amount Jackpot Income.

	if($Q){

		$SQL="SELECT SUM(`amount`) FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `ttype` = 'Jackpot';";
		global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
		else{$ts = null;}
		if($ts){ return $ts[0]['SUM(`amount`)']; }

	}
}






function UpdateTotalJackpotIncome($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-19
	// Input : UserID
	// Output : Update total jackpot income by userid

	if($Q){

		$TotalJackpotIncome=TotalJackpotIncome($Q);
		if($TotalJackpotIncome){

			$SQL="UPDATE `Coinpods_jackpot` SET `total`='".$TotalJackpotIncome."' WHERE `user` = '".$Q."';";
			global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);

			return $TotalJackpotIncome;

		}
	}
}








function JackpotNews($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-19
	// Input : 
	// Output : Joo users aa rhe hai uss user ka jackpot me new activation krta hai.

	$PendingJackpotNew=PendingJackpotNew();
	if($PendingJackpotNew){
		foreach($PendingJackpotNew as $Ps){

			if($Ps){

				$jackpots=jackpots(array('user'=>$Ps['user']));
				if($jackpots){ $echo='Already Exists.'; JackpotOne($Ps['user']); }
				else{

					$JackpotNew=JackpotNew($Ps['user']);
					if($JackpotNew){

						$Amount=20000000000;

						JackpotActiveUpdate(array('user'=>$Ps['user'], 'active_date'=>GMT()));
						$Remove=RemoveFromJackpotWallet(array('ccc'=>'usdt', 'user'=>$Ps['user'], 'amount'=>$Amount ));
						if($Remove){
							JackpotOne($Ps['user']);

						}
					}
					else{ JackpotTwo($Ps['user']); }
				}
			}
		}
	}
	else{ $echo='Pending user not found.'; }
	//echo $echo;
}





function PendingJackpotNew($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-19
	// Input : 
	// Output : Jiss user ke buy ki amount 20 usdt ke brar ya jyada hai to unn users ko select krta hai.

	$Amount=20000000000;
	$SQL="SELECT * FROM `Coinpods_jackpotwallet` WHERE `name` = '0' AND `usdt` >= '".$Amount."' LIMIT 20;";  //echo $SQL;
	global $DB; $aa = 0; $results = mysqli_query($DB, $SQL);	 
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	if($ts){ return $ts;}

}


function JackpotOne($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-19
	// Input : UserID
	// Output : Jackpot activation success ho jane par jackpot column ko one update kr deta hai.

	if($Q){	

		$SQL="UPDATE `Coinpods_jackpotwallet` SET `name` = '1' WHERE `user`='".$Q."'";
		global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);
		return  $Output;

	}
}


function JackpotTwo($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-19
	// Input : UserID
	// Output : Jackpot activation faild ho jata hai to jackpot column me two update kr deta hai.

	if($Q){	

		$SQL="UPDATE `Coinpods_jackpotwallet` SET `name` = '2' WHERE `user`='".$Q."'";
		global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);
		return  $Output;

	}
}




function JackpotToWallet($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-19
	// Input :
	// Output : Jackpot Income ko wallet me leke jata hai.
	$Output=0;
	$PendingLuckyDrawTransactions=PendingJackpot($Q);
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


function PendingJackpot($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-19
	// Input : 
	// Output : Pending Transaction Jackpot Income.

	$SQL="SELECT * FROM `Coinpods_transaction` WHERE `ttype` LIKE 'Jackpot' AND `balance` = 0 ORDER BY `id` DESC"; 
	global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		

}




function Jackpot_Incomes($Q=null){
	// Developer : Pawan Kumar7
	// Date : 2024-04-19
	// Input : ID
	// Output : Jackpot Income Transaction Create
	$echo = 'Jackpot_Incomes Started.';
	$Output=0;

	$PendingJackpotIncome=PendingJackpotIncome();
	if($PendingJackpotIncome){
		foreach($PendingJackpotIncome as $Ps){
			$echo = 'Jackpot_Incomes Started with : '.$Ps['id'];

			$Uplines=Jackpot_Uplines($Ps['id']); //print_r($Uplines);
			$aa=0;

			foreach($Uplines as $Upline){
				$echo = 'Jackpot_Income Started for : '.$Upline; 
				if($Upline){

					$Jackpot_Income=Jackpot_Income(array('from'=>$Ps['id'], 'to'=>$Upline));

					if($Jackpot_Income){ JackpotLevelOne($Ps['id']); }
					else{ JackpotLevelTwo($Ps['id']); }

				}
			}
		}
	}
	else{ $echo = 'Not enough resources.';  }
	//echo $echo;
	//return $Output;
}



function Jackpot_Income($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-19
	// Input : ID
	// Output : Insert Transaction Jackpot Income
	$echo = 'Jackpot_Income Started.';

	if(is_array($Q)){ $From=$Q['from']; $To=$Q['to']; }
	if($From and $To){
		$echo = 'Jackpot_Income Started with : '.$To;

		$Jackpot=Jackpot($To);
		if($Jackpot['user']){
			$echo = 'Jackpot_Income : Jackpot found.';

			$UpdateTotalJackpotIncome=UpdateTotalJackpotIncome($Jackpot['user']);
			if($UpdateTotalJackpotIncome){
				$echo = 'Jackpot total income update success.';

				if($Jackpot['total']<=1828000000000){
					$echo = 'Jackpot_Income : LIMIT Availble.';

					$TodayJacpotIncomeUpdate=TodayJacpotIncomeUpdate($Jackpot['user']);
					$echo = 'Today jackpot income update success.';

					if($TodayJacpotIncomeUpdate < 1000000000){
						$echo='Today Jackpot Income Found.';

						$OrderID = 'Jackpot_Income:From:'.$From.':To:'.$To; print_r('<br><br>'.$OrderID);// OrderID 
						$echo = 'Jackpot order id found : '.$OrderID;

						$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`) VALUES (NULL, 'Level".$aa." Income from Jackpot', current_timestamp(), current_timestamp(), '".$OrderID."', '".$Jackpot['user']."', '', '', '0', 'Jackpot', '1000000000', 'USDT', '1', '".$Walletss['ccc']."');"; //echo '<br><br>'.$SQL;

						global $DB;	$Output = mysqli_query($DB, $SQL);
						$echo = 'Jackpot_Income INSERTED.';

					}
					else{

						$SQL1="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`) VALUES (NULL, 'Level".$aa." Income from Jackpot', current_timestamp(), current_timestamp(), 'Jackpot_Income:From:".$From.':To:2'.clean(GMT())."', '2', '', '', '0', 'Jackpot', '1000000000', 'USDT', '1', '".$Walletss['ccc']."');"; //echo '<br><br>'.$SQL1;
						global $DB;	$Output = mysqli_query($DB, $SQL1);

					}
				}
				else{ $echo='Amount Already Completed.'; }
			}
			else{ $echo='Jackpot total income not update.'; }
		}
		else{ $echo='User not found.'; }
	}
	else{ $echo='Data not found.'; }

	//echo $echo;
	return $Output;
}


function JackpotLevelOne($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-20
	// Input : ID
	// Output : Coinpods_Jackpot level = 1 Krta hai.

	if($Q){

		$SQL="UPDATE `Coinpods_jackpot` SET `level`='1' WHERE `id` = '".$Q."'";
		global $DB;	$Output = mysqli_query($DB, $SQL);

		return $Output;

	}
	else{ $echo = 'Q data not found.'; }
}



function JackpotLevelTwo($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-20
	// Input : ID
	// Output : Coinpods_Jackpot level = 2 Krta hai.

	if($Q){

		$SQL="UPDATE `Coinpods_jackpot` SET `level`='2' WHERE `id` = '".$Q."'";
		global $DB;	$Output = mysqli_query($DB, $SQL);

		return $Output;

	}
	else{ $echo = 'Q data not found.'; }
}








function PendingJackpotIncome($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-19
	// Input : 
	// Output : Jackpot income pending users

	$SQL="SELECT * FROM `Coinpods_jackpot` WHERE `level` = '0' LIMIT 1;";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;} 
	return $ts;

}




function Jackpot_Uplines($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-19
	// Input : ID
	// Output : Uplines

	$aa=1;
	if($Q){$Users[$aa]=Jackpot_Upline($Q);}

	$Uplines[$aa]=$Users[1]['id']; $aa++;
	$Users[$aa]=Jackpot_Upline($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['id']; $aa++;
	$Users[$aa]=Jackpot_Upline($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['id']; $aa++;
	$Users[$aa]=Jackpot_Upline($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['id']; $aa++;
	$Users[$aa]=Jackpot_Upline($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['id']; $aa++;
	$Users[$aa]=Jackpot_Upline($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['id']; $aa++;
	$Users[$aa]=Jackpot_Upline($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['id']; $aa++;
	$Users[$aa]=Jackpot_Upline($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['id']; $aa++;
	$Users[$aa]=Jackpot_Upline($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['id']; $aa++;
	$Users[$aa]=Jackpot_Upline($Uplines[$aa-1]); $Uplines[$aa]=$Users[$aa]['id']; $aa++;

	return $Uplines;
}



function Jackpot_Upline($Q=null){
	// Developer : Pawan Kumar
	// Date : 2024-04-19
	// Input : ID
	// Output : ID By Upline

	if($Q){

		$SQL="SELECT * FROM `Coinpods_jackpot` WHERE `p1` = '".$Q."' OR `p2` = '".$Q."';";
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;} 
		return $ts[0];

	}
}





?>