<?php
/*
global $DB;
	$servername = "localhost";
	$username = "hx.money.aliens.works";
	$dbname = "hx.money.aliens.works";
	$password = "hx.money.aliens.works";
 	
	$DB = new mysqli($servername, $username, $password, $dbname);
	if ($DB->connect_error) {
		die("Connection failed: " . $DB->connect_error);
	}

 $link = $DB;
*/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





function TicketLevels($Q=null){
	
	$TicketLevel=0;
	if(!$Q){ $Q = i['id']; }
	
	$User=user($Q);
	if($User){
		
		$Downline=Downline($User['userid']);
		if($Downline){
			
			foreach($Downline as $Dow){
				if($Dow){
					
					$TotalTicket=HXAirdropUserByUserID($Dow['userid']);
					if($TotalTicket){
						
						$TicketLevel=$TicketLevel+$TotalTicket['TotalTicket'];
						if($TicketLevel){

							UpdateTicketLevel(array('userid'=>$User['userid'], 'TotalTicket'=>$TicketLevel));

						}
					}
				}
			}
		}
	}
}


function UpdateTicketLevel($Q=null){
//Developer : Pawan Kumar
//Input : UserID, Total Ticket
//Output : Direct me kitni lottery ticket buy ho chuki hai vo count krta hai.
	
	if(is_array($Q)){ $UserID=$Q['userid']; $TicketLevel=$Q['TotalTicket']; }
	if($UserID and $TicketLevel){

		$SQL="UPDATE `Coinusers` SET `TicketLevel` = '".$TicketLevel."' WHERE `userid` = '".$UserID."';"; //echo $SQL;
		global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL); 
	
	}
	else{ $echo='Data Empty.'; }
	return $Output;
}




function HXAirdropUserByUserID($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/25
 
	$SQL="SELECT * FROM `Coinusers` WHERE `userid` = '".$Q."' LIMIT 1"; 
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); 
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}}
	else{$ts = null;}
	$return = $ts[0];
	
	return $return;
}

 














//* Total Ticket Update


function TotalTickets($Q=null){
//Developer : Pawan Kumar
//Date : 2024/02/18
//Input : UserID
//Output : Airdrop ke coinusers table me Khud ki TotalTicket Update krta hai.
	
	$user = User($Q);
	if($user){
		
		$U=Exchange_UserByUsername($user['user_login']);
		if($U){
			
			$UT=UserTicket($U['ID']);
			if($UT){
				
				UpdateTotalTicket(array( 'ID'=>$UT['user'], 'TotalTicket'=>$UT['TotalTicket'] ));
			
			}
		}
	}
}




function UserTicket($Q=null){
	
	$UserID=$Q; $Period=Period();
	if($UserID and $Period){
			
$SQL="SELECT COUNT(`id`) AS 'TotalTicket', `user` FROM `Coinpods_bet` WHERE `period`= '".$Period."' AND `user`= '".$UserID."' GROUP BY `user`;";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}
	
	}
	else{ $echo = 'Data Empty.';}
	return $ts[0];
}





function UpdateTotalTicket($Q=null){
	
	if(is_array($Q)){ $ID=$Q['ID']; $TotalTicket=$Q['TotalTicket']; }
	if($ID and $TotalTicket){
		
		$SQL="UPDATE `Coinusers` SET `TotalTicket` = '".$TotalTicket."' WHERE `ID` = '".$ID."';"; //echo $SQL.'<br>';
		global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);
	
	}
	else{ $echo='Data Empty.'; }
	return $Output;
}



function Period($Q=null){
if(!$Q){ $Q=1; }
if($Q){
	$SQL="SELECT * FROM `Coinpods_period` WHERE `id` = '1'";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0]['period'];	
}	
}
 

//# Total Ticket Update


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




function TotalTOBets($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/25 
	
	$SQL="SELECT COUNT(`id`) AS `Total` FROM `Coinpods_bet` WHERE `status` = 0 LIMIT 11111;";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts[0]['Total'];	
 
	return $return;	
}



function GlobalTodayBetsss($Q=null){
//Developer: Sahiram Nayak
//Date: 2023/12/25	
 
	$Q = Periodsss();		
	$SQL="SELECT * FROM `Coinpods_bet` WHERE `period` LIKE '".$Q."' ORDER BY `Coinpods_bet`.`id` DESC LIMIT 1111";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	
 
	return $return;	
}





function TotalTodayBetsss($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/25	
 
	$Q = Periodsss();			
	$SQL="SELECT COUNT('id') AS `Total` FROM `Coinpods_bet` WHERE `period` LIKE '".$Q."';";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	 
 
	return $ts[0]['Total'];
}


 
 
function TotalYesterdayBetsss($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/25	
 
	$Q = Periodsss()-1;			
	$SQL="SELECT COUNT('id') AS `Total` FROM `Coinpods_bet` WHERE `period` LIKE '".$Q."';";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	 
 
	return $ts[0]['Total'];
}


 
 


function TodayBetsss($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/25
	
	if(!$Q){ $Q = i['id']; }
	$QQ = Period();

	$SQL="SELECT * FROM `Coinpods_bet` WHERE `user` = '".$Q."' AND `period` = '".$QQ."' LIMIT 1111;";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	
 
	return $return;	
}














 function Betsssss($Q=null){
//Developer: Pawan Kumar
//Date: 2023/12/25

	$SQL="SELECT * FROM `Coinpods_bet` WHERE `status` = 0 LIMIT 11111;";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	
 
	return $return;	
}



function TodayBetss($Q=null){
//Developer: Sahiram Nayak
//Date: 2024/02/05 
	
	if(!$Q){ $Q = i['id']; } 
	$user = User($Q); 
	$U=Exchange_UserByUsername($user['user_login']); 
	if($U['ID']){ 
		$QQ = Periodsss(); 
		
		$SQL="SELECT * FROM `Coinpods_bet` WHERE `user` = '".$U['ID']."' AND `period` = '".$QQ."' LIMIT 1111;"; 
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);  
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;} 
		$return = $ts; 
		return $return; 
	}
}


  


function YesterdayBetss($Q=null){
//Developer:Sahiram Nayak
//Date: 2024/02/05 
	
	if(!$Q){ $Q = i['id']; }  
	$user = User($Q);
	$U=Exchange_UserByUsername($user['user_login']);
	if($U['ID']){ 
		$QQ = Periodsss()-1; 
		
		$SQL="SELECT * FROM `Coinpods_bet` WHERE `user` = '".$U['ID']."' AND `period` = '".$QQ."' LIMIT 1111;";
		global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);
		if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
		else{$ts = null;}
		$return = $ts;
		return $return;
	}
}

 
function Periodsss($Q=null){
if(!$Q){ $Q=1; }
if($Q){
	$SQL="SELECT * FROM `Coinpods_period` WHERE `id` = '1'";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts[0]['period'];	
}	
}



 

function TodayWinnessssr(){
//Developer: Pawan Kumar
//Date: 2023/12/25
	
	$QQ=Periodsss() -1;
	$SQL="SELECT * FROM `Coinpods_winner` WHERE `wid` LIKE '%".$QQ."%' ORDER BY `Coinpods_winner`.`rank` ASC LIMIT 101";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	
 
	 return $return;	
}


function YesterdayWinnersss(){
//Developer: Pawan Kumar
//Date: 2023/12/25
	
	$QQ=Periodsss()-2;
	$SQL="SELECT * FROM `Coinpods_winner` WHERE `wid` LIKE '%".$QQ."%' ORDER BY `Coinpods_winner`.`rank` ASC LIMIT 101";
	global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); 
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	$return = $ts;	
 
	 return $return;	
}

 





/**/ 
function Exchange_UserByUsername($Q=null){
	$results=[];$SQL='';
	$SQL = "SELECT * FROM `".prefix."users` WHERE `user_login` = '".$Q."' LIMIT 1";
	global $DB;$aa=0; $results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($p = mysqli_fetch_assoc($results)){ $ps[$aa] = $p; $aa++;}} 
	else{$ps=null;}
	$user=$ps[0];
	
	 //print_r($user);
	
		if($user){

		
        $user['username']=$user['user_login'];
        $user['id']=$user['ID'];
		
		if($user['fname']){ $user['name'] = $user['fname'].' '.$user['lname']; $user['DP']=$user['fname'][0].$user['lname'][0]; }
		else{ $user['name'] = $user['username']; $user['DP']=$user['username'][0].$user['username'][1]; }
		
		


		//# active
		
		//$active=active($user);
		$user['active']=$active['active'];$user['active_status']=$active['active_status'];
		
		//* active
	}
	
	
	return $user;
}


 



function Exchange_AddToMiningWallet($Q=null){
if(is_array($Q)){ $user=$Q['user']; $ccc=$Q['ccc']; $network=$Q['network']; $amount=$Q['amount']; }	
	
$user = User($user);
$U = Exchange_UserByUsername($user['user_login']);
if($U){	
if($U and $ccc and $amount){	

	$SQL="UPDATE `Coinpods_funding` SET `".$ccc."` = `".$ccc."` + '".$amount."'  WHERE `Coinpods_funding`.`user` = '".$U['ID']."';";	
	global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL);	
	return true;
	
}
}
	else{ $echo = 'User not found on HelloX Win.'; }
}
 


function WinCreateTransfer($Q=null){
$Output=0;
if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $To=$Q['to']; }
$UserID=i['id'];	
if($UserID and $Amount and $CCC and $To=='spot'){ 
$Wallets=Wallets();

if(i['id']){ 
if($To and $Amount and $CCC){ 
if($Wallets[$CCC]>=p2d($Amount)){ 
	
	
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `buyuser`, `selluser`) VALUES (NULL, 'Transfer:".$To.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Transfer:".$To.Clean(GMT())."', '".i['id']."', '', '', '0', 'TransferWin', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '', '');";
	
global $DB;$aa = 0;
$Staked = mysqli_query($DB, $SQL);
	
$Walletss=Wallets();	 $Walletss=$Walletss[strtolower($CCC)]; $Walletss=$Walletss-p2d($Amount);
if($Staked){ 
$SQL1="UPDATE `Coinpods_wallet` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_wallet`.`user` = '".$UserID."';"; unset($Walletss);
global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL1);	
} 

}
	
}	
}
 
}
if($UserID and $Amount and $CCC and $To=='funding'){	
$Wallets=Fundings();
 
if(i['id']){ 
if($To and $Amount and $CCC){ 
if($Wallets[$CCC]>=p2d($Amount)){ 
	
	
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `buyuser`, `selluser`) VALUES (NULL, 'Transfer:".$To.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Transfer:".$To.Clean(GMT())."', '".i['id']."', '', '', '0', 'TransferWin', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '', '');";
	
global $DB;$aa = 0;
$Staked = mysqli_query($DB, $SQL);
	
$Walletss=Fundings();	 $Walletss=$Walletss[strtolower($CCC)]; $Walletss=$Walletss-p2d($Amount);
if($Staked){ 
$SQL1="UPDATE `Coinpods_funding` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_funding`.`user` = '".$UserID."';"; unset($Walletss);
global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL1);	
} 

}
	
	
}
	
}
else{ $echo = 'Not enough sources.'; }
}	
 
	return $Output;
}


























 
function TransferToWalletaa($Q=null){
//Add Balance to Wallet from Transaction(Buy)
$Output=0;	
$PendingStakingTransactions=PendingTransferTransactionssss($Q);	
if($PendingStakingTransactions){
foreach($PendingStakingTransactions as $PBT){
	//print_r($PBT['user']);
	if(Exchange_AddToMiningWallet(array( 'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$PBT['amount'] ))){
	//if(Exchange_AddToMiningWallet( array( 'name'=>$PBT['name'],'orderid'=>$PBT['orderid'],'user'=>$PBT['user'], 'ccc'=>strtolower($PBT['ccc']), 'amount'=>$PBT['amount'] ))){
		 Balance1Transaction($PBT['id']);
	}
	else{  Balance2Transaction($PBT['id']);   }
}	
}	
return $Output;
}

 


function PendingTransferTransactionssss($Q=null){
	
if($Q){ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `user` = '".$Q."' AND `balance` = 0 AND `ttype` = 'TransferWin'"; }
else{ $SQL="SELECT * FROM `Coinpods_transaction` WHERE `balance` = 0 AND `ttype` = 'TransferWin'"; }

global $DB;$aa = 0;	$results = mysqli_query($DB, $SQL);	
	if(mysqli_num_rows($results) > 0){ while($t = mysqli_fetch_assoc($results)){ $ts[$aa] = $t; $aa++;}} 
	else{$ts = null;}	
	return $ts;		
}





// Comment

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


 



/* 
function WinCreateTransfer($Q=null){
$Output=0;
if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $To=$Q['to']; }
$UserID=i['id'];	
	
$Wallets=Wallets();
 
if(i['id']){ 
if($To and $Amount and $CCC){ 
if($Wallets[$CCC]>=p2d($Amount)){ 
	
	
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`, `buyuser`, `selluser`) VALUES (NULL, 'Transfer:".$To.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Transfer:".$To.Clean(GMT())."', '".i['id']."', '', '', '0', 'TransferWin', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '', '');";
	
global $DB;$aa = 0;
$Staked = mysqli_query($DB, $SQL);
	
$Walletss=Wallets();	 $Walletss=$Walletss[strtolower($CCC)]; $Walletss=$Walletss-p2d($Amount);
if($Staked){ 
$SQL1="UPDATE `Coinpods_wallet` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_wallet`.`user` = '".$UserID."';"; unset($Walletss);
global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL1);	
} 

}
	
	
}
else{ $echo = 'Not enough sources.'; }
}
	return $Output;
}


/*elseif($UserID and $Amount and $CCC  and $WalletType=='wallet'){
$Wallets=Wallets();	
if($Wallets[$CCC]>=p2d($Amount)){ 
	
	
$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, `amount`, `ccc`, `status`, `beforebalance`) VALUES (NULL, 'Staked From Spot Wallet:".$UserID.Clean(GMT())."', current_timestamp(), current_timestamp(), 'Stake:".$UserID.Clean(GMT())."', '".$UserID."', '', '', '1', 'Stake', '".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."');";
	
global $DB;$aa = 0;
$Staked = mysqli_query($DB, $SQL);	
$Wallets=Wallets();	
	$Walletss=$Wallets[strtolower($CCC)];
	$Walletsss=$Walletss-p2d($Amount);
	
if($Staked){ 	
$SQL1="UPDATE `Coinpods_wallet` SET `".strtolower($CCC)."` = ".$Walletsss."  WHERE `Coinpods_wallet`.`user` = '".$UserID."';"; unset($Walletsss);
global $DB;$aa = 0; $Walleted = mysqli_query($DB, $SQL1);	
}		
if($Walleted){
	
	$SQL2="INSERT INTO `Coinpods_stake` (`id`, `name`, `created`, `modified`, `amount`, `user`, `ccc`, `roi`, `period`, `ttype`, `status`) VALUES (NULL, '".i['id']."', current_timestamp(), current_timestamp(), '".p2d($Amount)."', '".i['id']."', '".$CCC."', '".$ROI."', '".$Period."', '".$Type."', '1');";
	
global $DB;$aa = 0;
$Output = mysqli_query($DB, $SQL2);
if($Output){
	
//$UpDrop=UpDrop();
	FirstStake(array( 'amount'=>$Amount));
	
}
}	

}
	
}				
else{ $echo = 'Not enough sources.'; } 

function WinCreateTransfer($Q=null){ 
	$Output=0; 
	if(is_array($Q)){ $Amount=$Q['amount']; $CCC=strtolower($Q['ccc']); $To=$Q['to']; }
	$user = UserByUsername($To);
	print_r($user);
	
	$UserID=i['id']; 
	$Wallets=Wallets(); 
	if(i['id']){ 
		
		if($To and $Amount and $CCC){ 
			if($Wallets[$CCC]>=p2d($Amount)){  
				
				$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, 
				`amount`, `ccc`, `status`, `beforebalance`, `buyuser`, `selluser`) VALUES (NULL, 'Transfer:".$To.Clean(GMT())."', current_timestamp(), 
				current_timestamp(), 'Transfer:".$To.Clean(GMT())."', '".i['id']."', '', '', '0', 'TransferWin', '".p2d($Amount)."', 
				'".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '', '');"; 
				global $DB;$aa = 0; $results = mysqli_query($DB, $SQL); 
				
				if($results){ 
					
					$SQL="INSERT INTO `Coinpods_transaction` (`id`, `name`, `created`, `modified`, `orderid`, `user`, `oca`, `occ`, `balance`, `ttype`, 
					`amount`, `ccc`, `status`, `beforebalance`, `buyuser`, `selluser`) VALUES (NULL, 'Transfer:".$To.Clean(GMT())."', 
					current_timestamp(), current_timestamp(), 'Transfer:".$To.Clean(GMT())."', '".i['id']."', '', '', '0', 'TransferWin', 
					'".p2d($Amount)."', '".strtoupper($CCC)."', '1', '".$Wallets[strtolower($CCC)]."', '', '');"; 
					global $DB;$aa = 0; $Staked = mysqli_query($DB, $SQL); 
					
					$Walletss=Wallets();
					$Walletss=$Walletss[strtolower($CCC)];
					$Walletss=$Walletss-p2d($Amount); 
					
					if($Staked){ 
						
						//$SQL1="UPDATE `Coinpods_wallet` SET `".strtolower($CCC)."` = ".$Walletss."  WHERE `Coinpods_wallet`.`user` = '".$UserID."';"; 
						//unset($Walletss); 
						//global $DB;$aa = 0; $Output = mysqli_query($DB, $SQL1); 
					}  
				}
			}
		}
		else{ $echo = 'Not enough sources.'; }
	}
	return $Output;
}



*/















?>